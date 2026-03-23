@extends('layouts.app')

@section('content')
<div class="py-12 bg-dark-50 dark:bg-dark-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="card-flat p-8 sticky top-28">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl font-bold text-dark-800 dark:text-white">Filters</h2>
                        <button class="text-xs font-semibold text-primary-500 hover:text-primary-600 transition-colors">Clear All</button>
                    </div>
                    
                    <!-- Categories -->
                    <div class="mb-10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-dark-400 mb-4">Category</h3>
                        <div class="space-y-3">
                            <label class="flex items-center group cursor-pointer">
                                <input type="radio" name="category" value="" checked class="hidden" onchange="filterProducts()">
                                <span class="text-sm font-medium text-dark-600 dark:text-dark-400 group-hover:text-primary-500 transition-colors">All Categories</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} class="hidden" onchange="filterProducts()">
                                    <span class="text-sm font-medium text-dark-600 dark:text-dark-400 group-hover:text-primary-500 transition-colors {{ request('category') == $category->slug ? 'text-primary-500 font-semibold' : '' }}">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-dark-400 mb-4">Price Range</h3>
                        <div class="space-y-4">
                            <input type="range" min="0" max="10000" step="100" class="w-full h-2 bg-dark-200 dark:bg-dark-700 rounded-lg appearance-none cursor-pointer accent-primary-500" id="priceRange" oninput="document.getElementById('priceVal').innerText = '₹' + this.value" onchange="filterProducts()">
                            <div class="flex justify-between text-xs font-bold text-dark-500">
                                <span>₹0</span>
                                <span id="priceVal" class="text-primary-500">₹5000</span>
                                <span>₹10000+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="mb-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-dark-400 mb-4">Size</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <button onclick="toggleSize('{{ $size }}')" class="size-btn w-12 h-12 rounded-xl border-2 border-dark-200 dark:border-dark-600 flex items-center justify-center text-sm font-bold text-dark-600 dark:text-dark-400 hover:border-primary-500 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-300" data-size="{{ $size }}">{{ $size }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Product Grid Area -->
            <div class="flex-1">
                <!-- Toolbar -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 card-flat p-4">
                    <p class="text-sm text-dark-500 font-medium"><span id="product-count">{{ $products->total() }}</span> products found</p>
                    <div class="flex items-center gap-4">
                        <span class="text-xs font-black uppercase tracking-widest text-dark-400">Sort by:</span>
                        <select onchange="filterProducts()" id="sortSelect" class="bg-transparent border-none focus:ring-0 text-sm font-bold cursor-pointer text-dark-700 dark:text-dark-300 pr-8">
                            <option value="newest">Newest First</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="best_seller">Best Seller</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @include('shop.product-grid', ['products' => $products])
                </div>

                <!-- Pagination -->
                <div id="pagination-links" class="mt-16">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let selectedSize = '';

    function toggleSize(size) {
        if (selectedSize === size) {
            selectedSize = '';
        } else {
            selectedSize = size;
        }
        
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('bg-primary-500', 'text-white', 'border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
            if (btn.dataset.size === selectedSize) {
                btn.classList.add('bg-primary-500', 'text-white', 'border-primary-500');
            } else {
                btn.classList.add('border-dark-200', 'dark:border-dark-600', 'text-dark-600', 'dark:text-dark-400');
            }
        });
        
        filterProducts();
    }

    function filterProducts(page = 1) {
        const category = document.querySelector('input[name="category"]:checked')?.value || '';
        const price = document.getElementById('priceRange').value;
        const sort = document.getElementById('sortSelect').value;
        
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        url.searchParams.set('category', category);
        url.searchParams.set('max_price', price);
        url.searchParams.set('size', selectedSize);
        url.searchParams.set('sort', sort);
        
        window.history.pushState({}, '', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('product-grid').innerHTML = data.html;
            document.getElementById('pagination-links').innerHTML = data.pagination;
            // Scroll to top of grid
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Handle pagination click
    document.addEventListener('click', function(e) {
        if (e.target.closest('#pagination-links a')) {
            e.preventDefault();
            const url = new URL(e.target.closest('a').href);
            const page = url.searchParams.get('page');
            filterProducts(page);
        }
    });
</script>
@endpush
