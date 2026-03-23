@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="card-flat overflow-hidden">
    <div class="p-6 border-b border-dark-100 dark:border-dark-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h4 class="text-lg font-bold text-dark-800 dark:text-white">Product List</h4>
            <p class="text-sm text-dark-500 mt-1">Manage your products inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Add Product</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-dark-500 dark:text-dark-400 uppercase tracking-wider bg-dark-50 dark:bg-dark-800/50">
                    <th class="py-4 px-6">Product</th>
                    <th class="py-4 px-6">Category</th>
                    <th class="py-4 px-6">Price</th>
                    <th class="py-4 px-6">Stock</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                @foreach($products as $product)
                    <tr class="table-row">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image) }}" class="w-14 h-14 rounded-xl object-cover shadow-sm" alt="">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-dark-100 dark:bg-dark-700 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-dark-800 dark:text-white">{{ $product->name }}</p>
                                    @if($product->is_featured)
                                        <span class="inline-flex items-center gap-1 text-xs text-yellow-600 mt-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-dark-600 dark:text-dark-400">{{ $product->category->name }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-semibold text-dark-800 dark:text-white">₹{{ number_format($product->price, 2) }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1 text-sm font-medium {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $product->stock }} units
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <button onclick="toggleFeatured({{ $product->id }})" id="featured-btn-{{ $product->id }}" 
                                class="badge {{ $product->is_featured ? 'badge-primary' : 'bg-dark-100 dark:bg-dark-700 text-dark-600 dark:text-dark-400' }}">
                                {{ $product->is_featured ? 'Featured' : 'Standard' }}
                            </button>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors">
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
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleFeatured(id) {
        fetch(`{{ url('admin/products/featured-toggle') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById(`featured-btn-${id}`);
                if (data.is_featured) {
                    btn.classList.remove('bg-dark-100', 'dark:bg-dark-700', 'text-dark-600', 'dark:text-dark-400');
                    btn.classList.add('badge-primary');
                    btn.innerText = 'Featured';
                } else {
                    btn.classList.remove('badge-primary');
                    btn.classList.add('bg-dark-100', 'dark:bg-dark-700', 'text-dark-600', 'dark:text-dark-400');
                    btn.innerText = 'Standard';
                }
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Featured status updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
@endpush
