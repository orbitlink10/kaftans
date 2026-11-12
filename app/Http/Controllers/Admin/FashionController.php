<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FashionProduct;
use App\Services\FashionCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FashionController extends Controller
{
    public function index(Request $request)
    {
        return $this->form(new FashionProduct);
    }

    private function form(FashionProduct $product)
    {
        return view('admin.fashion', [
            'product' => $product->load('variants'),
            'categories' => \App\Models\FashionCategory::orderBy('name')->get(),
            'storefrontRoot' => FashionCatalog::ROOT,
        ]);
    }

    public function products(Request $request)
    {
        $data = $request->validate(['q' => 'nullable|string|max:120', 'collection' => ['nullable', Rule::in(array_keys(FashionCatalog::allCategories()))]]);
        return view('admin.products', [
            'products' => FashionProduct::when($data['q'] ?? null, fn ($q, $term) => $q->where('name', 'like', '%'.$term.'%'))->when($data['collection'] ?? null, fn ($q, $slug) => $q->where('collection', $slug))->latest()->paginate(20)->withQueryString(),
            'collections' => FashionCatalog::allCategories(),
        ]);
    }

    public function edit(FashionProduct $product)
    {
        return $this->form($product);
    }

    public function destroy(FashionProduct $product)
    {
        $product->variants()->delete();
        $product->delete();
        return redirect()->route('admin.products.list')->with('success', 'Product deleted.');
    }

    public function preview(FashionProduct $product)
    {
        return view('admin.product-preview', ['product' => $product->load('variants'), 'collections' => FashionCatalog::allCategories()]);
    }

    public function save(Request $request)
    {
        $request->merge(['slug' => $request->input('slug') ?: \Illuminate\Support\Str::slug($request->input('name', ''))]);
        $data = $request->validate(['id' => 'nullable|exists:fashion_products,id', 'name' => 'required|string|max:160', 'slug' => ['required', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'max:180', Rule::unique('fashion_products', 'slug')->ignore($request->id)], 'collection' => ['required', Rule::in(array_keys(FashionCatalog::allCategories()))], 'price' => 'required|integer|min:1|max:1000000', 'marked_price' => 'nullable|integer|min:1|max:1000000|gte:price', 'meta_description' => 'nullable|string|max:1000', 'subcategory_id' => 'nullable|integer|exists:fashion_categories,id', 'quantity' => 'required_without:variants|nullable|integer|min:0|max:100000', 'description' => 'required|string|max:20000', 'care' => 'nullable|string|max:3000', 'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', 'active' => 'nullable|boolean', 'variants' => 'nullable|array|min:1|max:50', 'variants.*.size' => 'required|string|max:30', 'variants.*.color' => 'required|string|max:40', 'variants.*.stock' => 'required|integer|min:0|max:100000']);
        if (!empty($data['subcategory_id'])) {
            $parent = \App\Models\FashionCategory::where('slug', $data['collection'])->firstOrFail();
            if (!\App\Models\FashionCategory::whereKey($data['subcategory_id'])->where('parent_id', $parent->id)->exists()) {
                return back()->withErrors(['subcategory_id' => 'Choose a subcategory belonging to the selected category.'])->withInput();
            }
        }
        $data['variants'] = $data['variants'] ?? [['size' => 'One Size', 'color' => 'Standard', 'stock' => (int) $data['quantity']]];
        $data['description_html'] = \App\Services\CategoryDescription::clean($data['description']);
        $data['description'] = trim(html_entity_decode(strip_tags($data['description_html']), ENT_QUOTES, 'UTF-8'));
        if ($data['description'] === '') {
            return back()->withErrors(['description' => 'Enter a product description.'])->withInput();
        }
        $pairs = collect($data['variants'])->map(fn ($v) => mb_strtolower($v['size'].'|'.$v['color']));
        if ($pairs->unique()->count() !== $pairs->count()) {
            return back()->withErrors(['variants' => 'Each size and colour combination must be unique.'])->withInput();
        }
        DB::transaction(function () use ($request, $data) {
            $product = isset($data['id']) ? FashionProduct::findOrFail($data['id']) : new FashionProduct;
            $fields = collect($data)->except(['id', 'variants', 'image', 'quantity'])->all();
            $fields['active'] = $request->boolean('active');
            if ($request->hasFile('image')) {
                $fields['image'] = '/fashion-images/'.basename($request->file('image')->store('reyana', 'public'));
            }
            $product->fill($fields)->save();
            $kept = [];
            foreach ($data['variants'] as $v) {
                $variant = $product->variants()->updateOrCreate(['size' => $v['size'], 'color' => $v['color']], ['stock' => $v['stock']]);
                $kept[] = $variant->id;
            }
            $product->variants()->whereNotIn('id', $kept)->delete();
        });

        return redirect()->route('admin.products.list')->with('success', 'Product saved.');
    }
}
