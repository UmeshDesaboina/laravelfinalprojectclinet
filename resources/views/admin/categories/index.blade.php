@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="card-flat overflow-hidden" x-data="{ openCreateModal: false, openEditModal: false, editCategory: {} }">
    <div class="p-6 border-b border-dark-100 dark:border-dark-700 flex justify-between items-center">
        <div>
            <h4 class="text-lg font-bold text-dark-800 dark:text-white">Category List</h4>
            <p class="text-sm text-dark-500 mt-1">Organize your products into categories</p>
        </div>
        <button @click="openCreateModal = true" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Add Category</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-dark-500 dark:text-dark-400 uppercase tracking-wider bg-dark-50 dark:bg-dark-800/50">
                    <th class="py-4 px-6">Image</th>
                    <th class="py-4 px-6">Name</th>
                    <th class="py-4 px-6">Slug</th>
                    <th class="py-4 px-6">Products</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                @foreach($categories as $category)
                    <tr class="table-row">
                        <td class="py-4 px-6">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-14 h-14 rounded-xl object-cover shadow-sm" alt="">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-500/20 to-accent-500/20 flex items-center justify-center">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-primary-500 to-accent-500 bg-clip-text text-transparent">{{ substr($category->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-semibold text-dark-800 dark:text-white">{{ $category->name }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-dark-500 font-mono">{{ $category->slug }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-primary-50 dark:bg-primary-900/20 text-primary-600 font-semibold text-sm">
                                {{ $category->products ? $category->products->count() : 0 }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="badge {{ $category->is_active ? 'badge-primary' : 'bg-red-100 text-red-700 dark:bg-red-900/30' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="editCategory = {{ $category }}; openEditModal = true" class="p-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/40 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t border-dark-100 dark:border-dark-700">
        {{ $categories->links() }}
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-cloak>
        <div x-show="openCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white dark:bg-dark-800 rounded-3xl w-full max-w-md p-8 shadow-soft-xl" @click.away="openCreateModal = false">
            <h3 class="text-xl font-bold text-dark-800 dark:text-white mb-6">Add New Category</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-dark-700 dark:text-dark-300 mb-2">Category Name</label>
                    <input type="text" name="name" class="input-field" placeholder="Enter category name" required>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-dark-700 dark:text-dark-300 mb-2">Image</label>
                    <input type="file" name="image" class="w-full text-sm text-dark-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                </div>
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" checked class="w-5 h-5 rounded text-primary-500">
                        <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openCreateModal = false" class="btn-secondary !py-3">Cancel</button>
                    <button type="submit" class="btn-primary !py-3">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="openEditModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-cloak>
        <div x-show="openEditModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="bg-white dark:bg-dark-800 rounded-3xl w-full max-w-md p-8 shadow-soft-xl" @click.away="openEditModal = false">
            <h3 class="text-xl font-bold text-dark-800 dark:text-white mb-6">Edit Category</h3>
            <form :action="`{{ url('admin/categories') }}/${editCategory.id}`" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-dark-700 dark:text-dark-300 mb-2">Category Name</label>
                    <input type="text" name="name" x-model="editCategory.name" class="input-field" required>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-dark-700 dark:text-dark-300 mb-2">Image</label>
                    <input type="file" name="image" class="w-full text-sm text-dark-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100">
                </div>
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" :checked="editCategory.is_active" class="w-5 h-5 rounded text-primary-500">
                        <span class="text-sm font-medium text-dark-700 dark:text-dark-300">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openEditModal = false" class="btn-secondary !py-3">Cancel</button>
                    <button type="submit" class="btn-primary !py-3">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
