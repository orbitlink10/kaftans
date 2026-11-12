<?php

namespace App\Http\Controllers;

use App\Services\FashionCatalog;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class StorefrontController extends Controller
{
    private const RELATED_COLLECTIONS = [
        'wedding-kaftan-dresses' => ['embroidered-kaftan-dresses', 'plus-size-kaftan-dresses'],
        'embroidered-kaftan-dresses' => ['wedding-kaftan-dresses', 'plus-size-kaftan-dresses'],
        'casual-kaftan-dresses' => ['beach-kaftans', 'plus-size-kaftan-dresses'],
        'beach-kaftans' => ['casual-kaftan-dresses', 'kaftan-dresses-for-ladies'],
        'plus-size-kaftan-dresses' => ['casual-kaftan-dresses', 'embroidered-kaftan-dresses'],
        'kaftan-dresses-nairobi' => ['kaftan-dresses-for-ladies', 'wedding-kaftan-dresses'],
    ];

    public function __construct(private FashionCatalog $catalog) {}

    private function render(string $view, array $data = [])
    {
        $data['title'] ??= kaftan_brand();
        $data['description'] ??= config('kaftan.description');
        $data['canonical'] ??= kaftan_url('/');
        $data['noindex'] = $data['noindex'] ?? ! kaftan_indexable();
        $data['canonicalBase'] = rtrim(config('kaftan.canonical_base'), '/');
        $data['collections'] = $this->catalog->collections();
        $data['navigation'] = $this->catalog->navigation();

        return response()->view('storefront.'.$view, $data)
            ->header('X-Robots-Tag', $data['noindex'] ? 'noindex, nofollow' : 'index, follow');
    }

    public function home()
    {
        $products = $this->catalog->products();
        $summaries = $this->catalog->categorySummaries();

        return $this->render('home', [
            'products' => $products->take(4),
            'picks' => $products->slice(4, 4),
            'summaries' => $summaries,
            'title' => 'Kaftan Dresses in Kenya | Kaftan Dress Kenya',
            'description' => config('kaftan.description'),
            'canonical' => kaftan_url('/'),
            'noindex' => ! kaftan_indexable(),
            'heroImage' => '/kaftan/hero.webp',
        ]);
    }

    public function collection(Request $request, ?string $collection = null)
    {
        $collections = $this->catalog->collections();
        abort_if($collection && ! isset($collections[$collection]), 404);

        $category = $collection ? $this->catalog->category($collection) : null;
        $request->validate(['q' => 'nullable|string|max:120', 'size' => 'nullable|string|max:30', 'color' => 'nullable|string|max:40', 'min' => 'nullable|integer|min:0', 'max' => 'nullable|integer|min:0', 'sort' => 'nullable|in:newest,price-asc,price-desc,name', 'page' => 'nullable|integer|min:1|max:10000']);

        $query = trim((string) $request->query('q', ''));
        $all = $collection
            ? $this->catalog->products()->filter(fn ($p) => $this->catalog->productInCategory($p, $collection))
            : $this->catalog->products();

        $options = $all->flatMap(fn ($p) => $p['variants']);
        $filtered = $all->filter(function ($p) use ($request, $query) {
            if ($query !== '' && ! $this->catalog->matchesSearch($p, $query)) {
                return false;
            }
            if ($request->filled('min') && $p['price'] < (int) $request->min) {
                return false;
            }
            if ($request->filled('max') && $p['price'] > (int) $request->max) {
                return false;
            }

            return collect($p['variants'])->contains(fn ($v) => (! $request->filled('size') || $v['size'] === $request->size) && (! $request->filled('color') || $v['color'] === $request->color) && (! $request->boolean('available') || $v['stock'] > 0));
        });

        $filtered = match ($request->get('sort')) {
            'price-asc' => $filtered->sortBy('price'),
            'price-desc' => $filtered->sortByDesc('price'),
            'name' => $filtered->sortBy('name'),
            default => $filtered,
        };

        $products = new LengthAwarePaginator($filtered->values()->forPage($request->integer('page', 1), 8), $filtered->count(), 8, $request->integer('page', 1), ['path' => $request->url(), 'query' => $request->query()]);
        abort_if($products->currentPage() > max(1, $products->lastPage()), 404);

        $filtersActive = $request->hasAny(['q', 'size', 'color', 'min', 'max', 'available', 'sort']);
        $indexable = kaftan_indexable() && $category && $category->is_indexable && $all->isNotEmpty() && ! $filtersActive;
        $canonicalPath = $collection ? '/collections/'.$collection : '/search';
        $canonical = kaftan_url($canonicalPath).(! $filtersActive && $request->integer('page', 1) > 1 ? '?page='.$request->integer('page', 1) : '');

        $title = $collection
            ? (($category?->meta_title) ?: $collections[$collection].' | Kaftan Dress Kenya')
            : ($query !== '' ? 'Search results for “'.$query.'” | Kaftan Dress Kenya' : 'Search | Kaftan Dress Kenya');

        $description = $collection
            ? ($category?->meta_description ?: 'Shop '.mb_strtolower($collections[$collection]).' at Kaftan Dress Kenya with prices in KSh.')
            : 'Search kaftan dresses in Kenya by style, size, colour or price.';

        $related = [];
        if ($collection) {
            $summaries = $this->catalog->categorySummaries();
            foreach (self::RELATED_COLLECTIONS[$collection] ?? [] as $slug) {
                if ($slug !== $collection && isset($summaries[$slug]) && $summaries[$slug]['count'] > 0) {
                    $related[$slug] = $summaries[$slug]['model']->name;
                }
            }
        }

        return $this->render('collection', [
            'categoryData' => $category,
            'description' => $description,
            'products' => $products,
            'collection' => $collection,
            'query' => $query,
            'sizes' => $options->pluck('size')->unique(),
            'colors' => $options->pluck('color')->unique(),
            'relatedCollections' => $related,
            'title' => $title,
            'canonical' => $canonical,
            'noindex' => ! $indexable,
        ]);
    }

    public function product(string $slug)
    {
        $product = $this->catalog->product($slug);
        $links = $this->catalog->categoryLinks($product);
        $productCollections = $this->catalog->productCollections($product);
        $related = $this->catalog->products()
            ->filter(fn ($item) => $item['slug'] !== $slug
                && array_intersect($this->catalog->productCollections($item), $productCollections)
                && collect($item['variants'])->sum('stock') > 0)
            ->take(4);

        return $this->render('product', [
            'description' => $product['meta_description'] ?: Str::limit($product['description'], 155),
            'product' => $product,
            'breadcrumbs' => $links,
            'related' => $related,
            'title' => $product['name'].' | '.kaftan_brand(),
            'canonical' => kaftan_url('/products/'.$product['slug']),
            'noindex' => ! kaftan_indexable() || $product['demo'],
        ]);
    }

    public function cart()
    {
        $lines = $this->catalog->cart();
        $subtotal = array_sum(array_column($lines, 'total'));

        return $this->render('cart', ['lines' => $lines, 'subtotal' => $subtotal, 'title' => 'Your bag | '.kaftan_brand(), 'canonical' => kaftan_url('/cart'), 'noindex' => true]);
    }

    public function add(Request $request)
    {
        $data = $request->validate(['slug' => 'required|string', 'variant' => 'required|string', 'quantity' => 'required|integer|min:1|max:20']);
        $product = $this->catalog->product($data['slug']);
        $variant = collect($product['variants'])->firstWhere('id', $data['variant']);
        $key = $product['slug'].'-'.$data['variant'];
        $cart = $this->cartSession();
        $quantity = ($cart[$key]['quantity'] ?? 0) + $data['quantity'];
        if (! $variant || $quantity > $variant['stock']) {
            return back()->withErrors(['variant' => 'Choose an available size and colour. The requested quantity must be in stock.']);
        }
        $cart[$key] = ['slug' => $product['slug'], 'variant' => $variant['id'], 'quantity' => $quantity];
        session(['kaftan.cart' => $cart]);

        return redirect('/cart')->with('success', 'Added to your bag.');
    }

    public function update(Request $request)
    {
        $data = $request->validate(['key' => 'required|string', 'quantity' => 'required|integer|min:0|max:20']);
        $cart = $this->cartSession();
        $lines = $this->catalog->cart();
        if ($data['quantity'] === 0) {
            unset($cart[$data['key']]);
        } elseif (isset($lines[$data['key']]) && $data['quantity'] <= $lines[$data['key']]['variant']['stock']) {
            $cart[$data['key']]['quantity'] = $data['quantity'];
        } else {
            return back()->withErrors(['quantity' => 'That quantity is not available.']);
        }
        session(['kaftan.cart' => $cart]);

        return redirect('/cart');
    }

    public function checkout()
    {
        $lines = $this->catalog->cart();
        $subtotal = array_sum(array_column($lines, 'total'));

        return $this->render('checkout', ['lines' => $lines, 'subtotal' => $subtotal, 'title' => 'Checkout | '.kaftan_brand(), 'canonical' => kaftan_url('/checkout'), 'noindex' => true]);
    }

    public function previewOrder(Request $request)
    {
        abort_unless(config('kaftan.preview'), 503, 'Checkout is not configured. No payment has been taken.');
        $phone = preg_replace('/\D/', '', (string) $request->input('phone'));
        if (preg_match('/^0[17]\d{8}$/', $phone)) {
            $phone = '254'.substr($phone, 1);
        } elseif (preg_match('/^[17]\d{8}$/', $phone)) {
            $phone = '254'.$phone;
        }
        $request->merge(['phone' => $phone]);
        $data = $request->validate(['name' => 'required|string|max:150', 'email' => 'required|email|max:255', 'phone' => ['required', 'regex:/^254[17]\d{8}$/'], 'county' => 'required|string|max:100', 'town' => 'required|string|max:100', 'address' => 'required|string|max:255', 'landmark' => 'nullable|string|max:255', 'token' => 'required|string']);
        if (session('kaftan.confirmed_token') === $data['token']) {
            return redirect('/order-confirmation');
        }
        abort_unless(hash_equals((string) session('kaftan.checkout_token'), $data['token']), 419);
        $lines = $this->catalog->cart();
        if (! $lines || collect($lines)->contains(fn ($line) => ! $line['valid'])) {
            return redirect('/cart')->withErrors(['stock' => 'Review your bag before continuing.']);
        }
        session(['kaftan.confirmation' => ['reference' => 'PREVIEW-'.strtoupper(substr(hash('sha256', $data['token']), 0, 8)), 'subtotal' => array_sum(array_column($lines, 'total')), 'phone' => $phone], 'kaftan.confirmed_token' => $data['token'], 'kaftan.cart' => [], 'kaftan.checkout_token' => null]);

        return redirect('/order-confirmation');
    }

    public function confirmation()
    {
        abort_unless(session()->has('kaftan.confirmation'), 404);

        return $this->render('confirmation', ['title' => 'Preview confirmation | '.kaftan_brand(), 'canonical' => kaftan_url('/order-confirmation'), 'noindex' => true]);
    }

    public function wishlist(Request $request)
    {
        if ($request->isMethod('post')) {
            $slug = $request->validate(['slug' => 'required|string'])['slug'];
            $this->catalog->product($slug);
            $list = session('kaftan.wishlist', []);
            $list = in_array($slug, $list) ? array_values(array_diff($list, [$slug])) : [...$list, $slug];
            session(['kaftan.wishlist' => $list]);

            return back()->with('success', 'Wishlist updated.');
        }

        return $this->render('wishlist', ['products' => $this->catalog->products()->whereIn('slug', session('kaftan.wishlist', [])), 'title' => 'Your wishlist | '.kaftan_brand(), 'canonical' => kaftan_url('/wishlist'), 'noindex' => true]);
    }

    public function newsletter(Request $request)
    {
        $data = $request->validate(['email' => 'required|email|max:255', 'consent' => 'accepted']);
        if (config('kaftan.preview')) {
            return back()->with('success', 'Preview signup tested. Your email has not been subscribed to marketing.');
        }
        abort_unless(Schema::hasTable('fashion_subscribers'), 503);
        DB::table('fashion_subscribers')->insertOrIgnore(['email' => mb_strtolower($data['email']), 'consented_at' => now(), 'created_at' => now(), 'updated_at' => now()]);

        return back()->with('success', 'Your signup has been saved.');
    }

    public function page(string $page)
    {
        $pages = require base_path('resources/demo/pages.php');
        abort_unless(isset($pages[$page]), 404);
        $content = $pages[$page];
        $noindex = ! kaftan_indexable() || $page === 'account';

        return $this->render('page', [
            'page' => $page,
            'content' => $content,
            'title' => $content['title'].' | '.kaftan_brand(),
            'description' => $content['meta_description'] ?? $content['intro'],
            'canonical' => kaftan_url('/'.$page),
            'noindex' => $noindex,
        ]);
    }

    public function robots()
    {
        if (! kaftan_indexable()) {
            return response("User-agent: *\nDisallow: /\n", 200, ['Content-Type' => 'text/plain']);
        }

        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            'Disallow: /dashboard',
            'Disallow: /bookings',
            'Disallow: /cart',
            'Disallow: /checkout',
            'Disallow: /account',
            'Disallow: /wishlist',
            'Disallow: /search',
            'Disallow: /order-confirmation',
            'Disallow: /login',
            'Disallow: /register',
            'Disallow: /forgot-password',
            'Disallow: /reset-password',
            'Disallow: /*?',
            'Allow: /*?page=',
            'Sitemap: '.kaftan_url('/sitemap.xml'),
        ];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain']);
    }

    public function sitemap()
    {
        $paths = [];
        if (kaftan_indexable()) {
            $products = $this->catalog->products();
            $paths[] = '/';

            foreach ($this->catalog->categorySummaries() as $slug => $summary) {
                if ($summary['count'] < 1 || ! $summary['model']->is_indexable) {
                    continue;
                }
                $paths[] = '/collections/'.$slug;
                for ($page = 2; $page <= (int) ceil($summary['count'] / 8); $page++) {
                    $paths[] = '/collections/'.$slug.'?page='.$page;
                }
            }

            foreach ($products as $product) {
                $paths[] = '/products/'.$product['slug'];
            }

            foreach (['about', 'contact', 'size-guide', 'delivery-shipping', 'returns-exchanges', 'faqs', 'privacy', 'terms', 'blog', 'blog/how-to-choose-a-kaftan-dress-in-kenya'] as $page) {
                $paths[] = '/'.$page;
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach (array_unique($paths) as $path) {
            $xml .= '<url><loc>'.htmlspecialchars(kaftan_url($path), ENT_XML1).'</loc></url>';
        }

        return response($xml.'</urlset>', 200, ['Content-Type' => 'application/xml']);
    }

    private function cartSession(): array
    {
        return session('kaftan.cart', session('reyana.cart', []));
    }
}
