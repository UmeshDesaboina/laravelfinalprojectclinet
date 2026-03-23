@foreach($products as $product)
    @include('components.product-card', ['product' => $product])
@endforeach

@if($products->isEmpty())
    <div class="col-span-full py-20 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <p class="text-xl font-bold text-gray-500">No products found matching your criteria.</p>
    </div>
@endif
