<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FashionCategory;
use App\Models\FashionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FashionCategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.categories', ['categories' => FashionCategory::when($request->boolean('subcategories'), fn ($q) => $q->whereNotNull('parent_id'))->latest('id')->paginate(20)->withQueryString()]);
    }

    public function create()
    {
        return $this->form(new FashionCategory);
    }

    public function edit(FashionCategory $category)
    {
        return $this->form($category);
    }

    private function form(FashionCategory $category)
    {
        return view('admin.category-form', ['category' => $category, 'parents' => FashionCategory::orderBy('name')->get()->reject(fn ($parent) => $parent->id === $category->id)]);
    }

    public function store(Request $request)
    {
        return $this->save($request, new FashionCategory);
    }

    public function update(Request $request, FashionCategory $category)
    {
        return $this->save($request, $category);
    }

    private function save(Request $request, FashionCategory $category)
    {
        $request->merge(['slug' => $request->input('slug') ?: Str::slug($request->input('name', ''))]);
        $data = $request->validate([
            'name' => 'required|string|max:160',
            'slug' => ['required', 'max:180', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::notIn(['new-arrivals', 'sale']), Rule::unique('fashion_categories')->ignore($category->id)],
            'meta_description' => 'nullable|string|max:1000', 'meta_title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:20000',
            'parent_id' => 'nullable|integer|exists:fashion_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'is_indexable' => 'nullable|boolean',
        ]);
        $data['is_indexable'] = $request->boolean('is_indexable');
        $parent = $data['parent_id'] ?? null;
        $seen = [];
        while ($parent) {
            if ((int) $parent === $category->id || isset($seen[$parent])) {
                return back()->withErrors(['parent_id' => 'Choose a parent outside this category and its descendants.'])->withInput();
            }
            $seen[$parent] = true;
            $parent = FashionCategory::findOrFail($parent)->parent_id;
        }
        unset($data['image']);
        if ($request->hasFile('image')) {
            $data['image'] = '/fashion-images/'.basename($request->file('image')->store('reyana', 'public'));
        }
        $data['description'] = \App\Services\CategoryDescription::clean($data['description'] ?? '');
        DB::transaction(function () use ($category, $data) {
            $oldSlug = $category->slug;
            $category->fill($data)->save();
            if ($oldSlug && $oldSlug !== $category->slug) {
                FashionProduct::where('collection', $oldSlug)->update(['collection' => $category->slug]);
            }
        });

        return redirect()->route('admin.categories.index')->with('success', 'Category saved.');
    }

    public function destroy(FashionCategory $category)
    {
        if (FashionProduct::where('collection', $category->slug)->orWhere('subcategory_id', $category->id)->exists() || FashionCategory::where('parent_id', $category->id)->exists()) {
            return back()->withErrors(['category' => 'Move this category’s products and sub categories before deleting it.']);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
