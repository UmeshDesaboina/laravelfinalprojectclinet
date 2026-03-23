@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Product Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select name="category_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Price (₹)</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Discount Price (₹)</label>
                <input type="number" step="0.01" name="discount_price" value="{{ $product->discount_price }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Stock</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Delivery Charge (₹)</label>
                <input type="number" step="0.01" name="delivery_charge" value="{{ $product->delivery_charge }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">{{ $product->description }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Variants (Sizes, comma separated)</label>
            <input type="text" name="variants[]" value="{{ is_array($product->variants) ? implode(',', $product->variants) : '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" placeholder="e.g. S, M, L, XL">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">New Images</label>
            <input type="file" name="images[]" multiple class="w-full">
            <div class="grid grid-cols-5 gap-4 mt-4">
                @foreach($product->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-24 object-cover rounded-lg" alt="">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4 mb-8">
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-green-500">
                <span class="ml-2 text-sm">Featured Product</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" {{ $product->is_active ? 'checked' : '' }} class="rounded text-green-500">
                <span class="ml-2 text-sm">Active</span>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 text-gray-500 hover:bg-gray-100 rounded-lg font-semibold transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-semibold transition-colors shadow-sm">Update Product</button>
        </div>
    </form>
</div>
@endsection
