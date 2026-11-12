@extends('layouts.dashboard')
@section('title', $product->exists ? 'Update Product' : 'Add Product')
@section('dashboard-title', '')
@section('dashboard-subtitle', '')
@section('content')
@include('admin.catalog-style')
@php
    $selectedCategory = old('collection', $product->collection);
    $selectedSubcategory = old('subcategory_id', $product->subcategory_id);
    $variantData = old('variants', $product->variants->map(fn ($v) => ['size' => $v->size, 'color' => $v->color, 'stock' => $v->stock])->all());
    $hasVariants = count($variantData) > 1 || (count($variantData) === 1 && ($variantData[0]['size'] !== 'One Size' || $variantData[0]['color'] !== 'Standard'));
@endphp
<div class="catalog-screen"><div class="catalog-header"><div><h1>{{ $product->exists ? 'Update Product' : 'Add Product' }}</h1><p>Fill in the product details below to {{ $product->exists ? 'update this item' : 'add a new item' }}</p></div><a href="{{ route('admin.products.list') }}">Back to products</a></div>
<div class="catalog-panel"><form class="catalog-form" action="{{ url('/admin/fashion') }}" method="post" enctype="multipart/form-data">@csrf
@if($product->exists)<input type="hidden" name="id" value="{{ $product->id }}">@endif
<div class="catalog-field"><label for="name">Product Name</label><input id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Enter product name" maxlength="160" required></div>
<div class="catalog-field"><label for="price">Price (KES)</label><input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="Enter product price" min="1" max="1000000" step="1" required></div>
<div class="catalog-field"><label for="marked_price">Marked Price (KES)</label><input id="marked_price" type="number" name="marked_price" value="{{ old('marked_price', $product->marked_price) }}" placeholder="Enter marked price" min="1" max="1000000" step="1"><small class="text-muted">Optional original price, equal to or higher than the selling price.</small></div>
<div class="catalog-field"><label for="quantity">Quantity</label><input id="quantity" type="number" name="quantity" value="{{ old('quantity', $product->variants->sum('stock')) }}" min="0" max="100000" required><small id="quantity-help" class="text-muted">Available stock. When using variants, this is the sum of variant stock.</small></div>
<div class="catalog-field"><label for="collection">Category</label><select id="collection" name="collection" required><option value="">Select Category</option>@foreach($categories as $category)<option value="{{ $category->slug }}" data-id="{{ $category->id }}" @selected($selectedCategory===$category->slug)>{{ $category->name }}{{ $category->slug === $storefrontRoot ? ' (Shop All Kaftans)' : '' }}</option>@endforeach</select><small class="text-muted">Kaftan collections live under “Kaftan Dresses for Ladies”. Choose a subcategory to add the product to one extra collection.</small></div>
<div class="catalog-field"><label for="subcategory_id">Subcategory</label><select id="subcategory_id" name="subcategory_id"><option value="">Select Subcategory (optional)</option>@foreach($categories->whereNotNull('parent_id') as $category)<option value="{{ $category->id }}" data-parent="{{ $category->parent_id }}" @selected($selectedSubcategory==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
<div class="catalog-field"><label for="meta_description">Meta Description</label><textarea id="meta_description" name="meta_description" maxlength="1000" placeholder="Write a short search-friendly summary">{{ old('meta_description', $product->meta_description) }}</textarea></div>
<div class="catalog-field"><label for="description">Description</label><textarea id="description" name="description" placeholder="Write the product description here...">{{ old('description', $product->description_html ?: $product->description) }}</textarea></div>
<div class="catalog-field"><label for="image">Product Image</label><input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">@if($product->image)<img class="catalog-photo mt-3" src="{{ $product->image }}" alt="{{ $product->name }}">@endif</div>
<details><summary>URL and Care Details</summary><div class="catalog-field"><label for="slug">URL slug</label><input id="slug" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="Generated from product name" maxlength="180"></div><div class="catalog-field"><label for="care">Fabric, Fit & Care</label><textarea id="care" name="care" maxlength="3000">{{ old('care', $product->care) }}</textarea></div></details>
<details @if($hasVariants) open @endif><summary>Size and Colour Variants (Optional)</summary>
<label class="mb-3"><input id="use-variants" type="checkbox" @checked($hasVariants)> Manage stock by size and colour</label>
<fieldset id="variant-fields"><div id="variant-rows">@foreach($variantData ?: [['size'=>'','color'=>'','stock'=>0]] as $variant)<div class="row g-2 mb-3 variant-row"><div class="col-md-4 catalog-field"><label>Size<input name="variants[{{ $loop->index }}][size]" value="{{ $variant['size'] }}" maxlength="30" required></label></div><div class="col-md-4 catalog-field"><label>Colour<input name="variants[{{ $loop->index }}][color]" value="{{ $variant['color'] }}" maxlength="40" required></label></div><div class="col-md-3 catalog-field"><label>Stock<input type="number" name="variants[{{ $loop->index }}][stock]" value="{{ $variant['stock'] }}" min="0" max="100000" required></label></div><div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-variant" aria-label="Remove variant">Remove</button></div></div>@endforeach</div><button id="add-variant" class="btn btn-outline-primary" type="button">Add Variant</button></fieldset></details>
<label class="d-block mb-4"><input type="checkbox" name="active" value="1" @checked(old('active', $product->active))> Publish product</label>
<div class="catalog-footer"><a href="{{ route('admin.products.list') }}">Cancel</a><button class="catalog-btn">Save Product</button></div>
</form></div></div>
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
if(window.tinymce)tinymce.init({selector:'#description',height:400,menubar:'file edit view insert format tools table',plugins:'lists link table code fullscreen',toolbar:'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link table | code fullscreen',promotion:false,branding:false});
const category=document.getElementById('collection'),sub=document.getElementById('subcategory_id');
const subOptions=Array.from(sub.options).slice(1).map(option=>option.cloneNode(true));
function filterSubcategories(){const selected=sub.value;const parent=category.selectedOptions[0]?.dataset.id;sub.replaceChildren(new Option('Select Subcategory (optional)',''));const matches=subOptions.filter(option=>option.dataset.parent===parent);for(const option of matches)sub.add(option.cloneNode(true));sub.value=matches.some(option=>option.value===selected)?selected:'';sub.disabled=matches.length===0;if(!matches.length)sub.options[0].text='No subcategories available';}
category.addEventListener('change',filterSubcategories);filterSubcategories();
const toggle=document.getElementById('use-variants'),fields=document.getElementById('variant-fields'),rows=document.getElementById('variant-rows'),quantity=document.getElementById('quantity');
function syncQuantity(){fields.disabled=!toggle.checked;quantity.readOnly=toggle.checked;if(toggle.checked)quantity.value=Array.from(rows.querySelectorAll('input[type=number]')).reduce((sum,input)=>sum+(Number(input.value)||0),0);}
function renumber(){Array.from(rows.children).forEach((row,index)=>row.querySelectorAll('input').forEach(input=>input.name=input.name.replace(/\[\d+\]/,'['+index+']')));syncQuantity();}
toggle.addEventListener('change',syncQuantity);rows.addEventListener('input',syncQuantity);
rows.addEventListener('click',event=>{if(event.target.classList.contains('remove-variant')&&rows.children.length>1){event.target.closest('.variant-row').remove();renumber();}});
document.getElementById('add-variant').addEventListener('click',()=>{if(rows.children.length>=50)return;const row=rows.firstElementChild.cloneNode(true);row.querySelectorAll('input').forEach(input=>input.value=input.type==='number'?'0':'');rows.append(row);renumber();});syncQuantity();
</script>
@endsection
