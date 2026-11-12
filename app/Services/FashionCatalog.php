<?php

namespace App\Services;

use App\Models\FashionCategory;
use App\Models\FashionProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class FashionCatalog
{
    public const ROOT = 'kaftan-dresses-for-ladies';

    public static function allCategories(): array
    {
        return Schema::hasTable('fashion_categories')
            ? FashionCategory::orderBy('name')->pluck('name', 'slug')->all()
            : [];
    }

    public function models(): Collection
    {
        if (! Schema::hasTable('fashion_categories')) {
            return collect();
        }

        $all = FashionCategory::orderBy('id')->get();
        $root = $all->firstWhere('slug', self::ROOT);
        if (! $root) {
            return collect();
        }

        $ids = [$root->id];
        do {
            $added = false;
            foreach ($all as $category) {
                if ($category->parent_id && in_array((int) $category->parent_id, $ids, true) && ! in_array($category->id, $ids, true)) {
                    $ids[] = $category->id;
                    $added = true;
                }
            }
        } while ($added);

        return $all->whereIn('id', $ids)->sortBy(fn ($category) => $category->id === $root->id ? 0 : 1)->values();
    }

    public function collections(): array
    {
        $collections = $this->models()->pluck('name', 'slug')->all();

        return $collections ?: [self::ROOT => 'Kaftan Dresses for Ladies'];
    }

    public function category(string $slug): ?FashionCategory
    {
        return $this->models()->firstWhere('slug', $slug);
    }

    public function descendantsOf(string $slug): array
    {
        $models = $this->models();
        $category = $models->firstWhere('slug', $slug);
        if (! $category) {
            return [$slug];
        }

        $ids = [$category->id];
        do {
            $added = false;
            foreach ($models as $candidate) {
                if ($candidate->parent_id && in_array((int) $candidate->parent_id, $ids, true) && ! in_array($candidate->id, $ids, true)) {
                    $ids[] = $candidate->id;
                    $added = true;
                }
            }
        } while ($added);

        return $models->whereIn('id', $ids)->pluck('slug')->all();
    }

    public function products(): Collection
    {
        if (config('kaftan.preview')) {
            return collect(require base_path('resources/demo/catalog.php'))->map(function ($product) {
                $product['collections'] = array_values(array_filter(array_unique([$product['collection'], $product['subcategory'] ?? null])));

                return $product;
            });
        }

        if (! Schema::hasTable('fashion_products') || ! Schema::hasTable('fashion_categories')) {
            return collect();
        }

        $slugs = array_keys($this->collections());
        $ids = FashionCategory::whereIn('slug', $slugs)->pluck('id');

        return FashionProduct::with(['variants', 'subcategory'])
            ->where('active', true)
            ->where(function ($query) use ($slugs, $ids) {
                $query->whereIn('collection', $slugs)->orWhereIn('subcategory_id', $ids);
            })
            ->latest()
            ->get()
            ->map(function ($p) {
                $collections = array_values(array_filter(array_unique([$p->collection, $p->subcategory?->slug])));

                return [
                    'id' => (string) $p->id,
                    'slug' => $p->slug,
                    'name' => $p->name,
                    'collection' => $p->collection,
                    'collections' => $collections,
                    'price' => $p->price,
                    'marked_price' => $p->marked_price,
                    'subcategory' => $p->subcategory?->slug,
                    'meta_description' => $p->meta_description,
                    'description_html' => $p->description_html,
                    'description' => $p->description,
                    'care' => $p->care,
                    'image' => $p->image ?: '/kaftan/placeholder.svg',
                    'alt' => $p->name,
                    'updated_at' => $p->updated_at?->toAtomString(),
                    'demo' => false,
                    'variants' => $p->variants->map(fn ($v) => ['id' => (string) $v->id, 'size' => $v->size, 'color' => $v->color, 'stock' => $v->stock])->all(),
                ];
            });
    }

    public function product(string $slug): array
    {
        return $this->products()->firstWhere('slug', $slug) ?? abort(404);
    }

    public function productInCategory(array $product, string $slug): bool
    {
        return (bool) array_intersect($this->productCollections($product), $this->descendantsOf($slug));
    }

    public function productCollections(array $product): array
    {
        return $product['collections'] ?? array_values(array_filter(array_unique([$product['collection'] ?? null, $product['subcategory'] ?? null])));
    }

    public function categorySummaries(): array
    {
        $products = $this->products();
        $models = $this->models();
        $summaries = [];

        foreach ($models as $model) {
            $slugs = $this->descendantsOf($model->slug);
            $items = $products->filter(fn ($product) => (bool) array_intersect($this->productCollections($product), $slugs));
            $summaries[$model->slug] = [
                'model' => $model,
                'count' => $items->count(),
                'min_price' => $items->min('price'),
                'max_price' => $items->max('price'),
                'image' => $model->image,
            ];
        }

        return $summaries;
    }

    public function navigation(): array
    {
        $navigation = [];
        foreach ($this->categorySummaries() as $slug => $summary) {
            if ($summary['count'] > 0) {
                $navigation[$slug] = $summary['model']->name;
            }
        }

        return $navigation;
    }

    public function categoryLinks(array $product): array
    {
        $models = $this->models()->keyBy('slug');
        $chain = [];
        $current = $product['subcategory'] ?? $product['collection'] ?? null;

        while ($current && $models->has($current)) {
            $model = $models->get($current);
            array_unshift($chain, ['slug' => $model->slug, 'name' => $model->name]);
            $parent = $model->parent_id ? $models->firstWhere('id', $model->parent_id) : null;
            $current = $parent?->slug;
        }

        if (isset($models[$product['collection'] ?? '']) && ! in_array($product['collection'], array_column($chain, 'slug'), true)) {
            array_unshift($chain, ['slug' => $product['collection'], 'name' => $models[$product['collection']]->name]);
        }

        return array_values(array_unique($chain, SORT_REGULAR));
    }

    public static function normalizeSearch(string $query): string
    {
        $query = mb_strtolower(trim($query));

        return preg_replace('/\bkafta(ns?)?\b/u', 'kaftan', $query) ?? $query;
    }

    public function matchesSearch(array $product, string $query): bool
    {
        $query = self::normalizeSearch($query);
        if ($query === '') {
            return true;
        }

        $categoryNames = [];
        foreach ($product['collections'] as $slug) {
            $model = $this->models()->firstWhere('slug', $slug);
            if ($model) {
                $categoryNames[] = $model->name;
            }
        }

        $haystack = mb_strtolower(implode(' ', array_filter([
            $product['name'],
            $product['description'] ?? '',
            $product['care'] ?? '',
            $product['slug'] ?? '',
            implode(' ', $categoryNames),
            implode(' ', collect($product['variants'])->pluck('size')->unique()->all()),
            implode(' ', collect($product['variants'])->pluck('color')->unique()->all()),
        ])));

        foreach (preg_split('/\s+/u', $query) as $term) {
            if ($term !== '' && ! str_contains($haystack, $term)) {
                return false;
            }
        }

        return true;
    }

    public function cart(): array
    {
        $lines = [];
        foreach (session('kaftan.cart', session('reyana.cart', [])) as $key => $line) {
            $p = $this->products()->firstWhere('slug', $line['slug']);
            $v = $p ? collect($p['variants'])->firstWhere('id', $line['variant']) : null;
            if (! $v) {
                continue;
            }
            $lines[$key] = ['product' => $p, 'variant' => $v, 'quantity' => $line['quantity'], 'total' => $p['price'] * $line['quantity'], 'valid' => $v['stock'] >= $line['quantity']];
        }

        return $lines;
    }
}
