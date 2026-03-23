@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Product Name</label>
                <input type="text" name="name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select name="category_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Price (₹)</label>
                <input type="number" step="0.01" name="price" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Discount Price (₹)</label>
                <input type="number" step="0.01" name="discount_price" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Stock</label>
                <input type="number" name="stock" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Delivery Charge (₹)</label>
                <input type="number" step="0.01" name="delivery_charge" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700"></textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Variants (Sizes, comma separated)</label>
            <input type="text" name="variants[]" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" placeholder="e.g. S, M, L, XL">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Images</label>
            <input type="file" name="images[]" multiple class="w-full">
            <p class="text-xs text-gray-500 mt-1">You can select multiple images.</p>
        </div>

        <div class="flex gap-4 mb-8">
            <label class="flex items-center">
                <input type="checkbox" name="is_featured" class="rounded text-green-500">
                <span class="ml-2 text-sm">Featured Product</span>
            </label>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" checked class="rounded text-green-500">
                <span class="ml-2 text-sm">Active</span>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-2 text-gray-500 hover:bg-gray-100 rounded-lg font-semibold transition-colors">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 font-semibold transition-colors shadow-sm">Save Product</button>
        </div>
    </form>
</div>
@endsection
