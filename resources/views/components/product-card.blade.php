<div class="group card hover-lift relative" x-data="{ wishlisted: false, quickViewOpen: false }">
    <!-- Badge -->
    @if($product->discount_price)
        <span class="absolute top-4 left-4 bg-gradient-to-r from-red-500 to-red-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-full z-10 shadow-lg shadow-red-500/30 animate-pulse-slow">
            {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}% OFF
        </span>
    @endif

    @if($product->is_featured)
        <span class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-[10px] font-bold px-3 py-1.5 rounded-full z-10 shadow-lg shadow-yellow-500/30 mt-12">
            FEATURED
        </span>
    @endif

    <!-- Wishlist Toggle -->
    <button onclick="toggleWishlist({{ $product->id }})" class="absolute top-4 right-4 p-3 bg-white/90 dark:bg-dark-800/90 backdrop-blur-md rounded-full text-dark-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-300 z-10 shadow-lg border border-white/20 hover:border-red-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
    </button>

    <!-- Compare Checkbox -->
    <button @click="toggleCompare({{ $product->id }})" class="absolute top-4 left-1/2 -translate-x-1/2 mt-16 p-2 bg-white/90 dark:bg-dark-800/90 backdrop-blur-md rounded-full text-dark-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-300 z-10 shadow-lg border border-white/20" title="Add to Compare">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
    </button>

    <!-- Image -->
    <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-[4/5] overflow-hidden bg-dark-100 dark:bg-dark-700 rounded-t-3xl">
        @if($product->images->count() > 0)
            <img src="{{ asset('storage/' . $product->images->first()->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="{{ $product->name }}">
            @if($product->images->count() > 1)
                <img src="{{ asset('storage/' . $product->images->skip(1)->first()->image) }}" class="w-full h-full object-cover absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" alt="{{ $product->name }}">
            @endif
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-dark-100 to-dark-200 dark:from-dark-700 dark:to-dark-800">
                <span class="text-6xl font-bold bg-gradient-to-r from-primary-500 to-accent-500 bg-clip-text text-transparent uppercase">{{ substr($product->name, 0, 1) }}</span>
            </div>
        @endif
        <!-- Quick Add Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-6">
            <button onclick="event.preventDefault(); addToCart({{ $product->id }})" class="w-full btn-primary !py-4 rounded-2xl !text-sm transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Quick Add
                </span>
            </button>
        </div>
    </a>

    <!-- Info -->
    <div class="p-5">
        <div class="flex items-center justify-between mb-2">
            <p class="text-[10px] font-bold text-dark-400 uppercase tracking-widest">{{ $product->category->name }}</p>
            @if($product->stock > 0)
                <span class="text-[10px] font-bold text-green-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    In Stock ({{ $product->stock }})
                </span>
            @else
                <span class="text-[10px] font-bold text-red-500 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                    Out of Stock
                </span>
            @endif
        </div>
        <a href="{{ route('products.show', $product->slug) }}" class="block text-lg font-bold text-dark-800 dark:text-white mb-2 group-hover:text-primary-500 transition-colors duration-300 line-clamp-2">{{ $product->name }}</a>
        
        <!-- Short Description -->
        @if($product->description)
            <p class="text-xs text-dark-500 dark:text-dark-400 line-clamp-2 mb-3">{{ strip_tags($product->description) }}</p>
        @endif
        
        <div class="flex items-center justify-between mt-3">
            <div class="flex flex-col">
                @if($product->discount_price)
                    <span class="text-xs text-dark-400 line-through decoration-red-500">₹{{ number_format($product->price, 2) }}</span>
                    <span class="text-xl font-black text-gradient bg-gradient-to-r from-primary-500 to-primary-600 tracking-tight">₹{{ number_format($product->discount_price, 2) }}</span>
                @else
                    <span class="text-xl font-black bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text text-transparent tracking-tight">₹{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <!-- Ratings -->
            <div class="flex items-center gap-1.5">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($product->average_rating) ? 'text-yellow-400' : 'text-dark-300 dark:text-dark-600' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    @endfor
                </div>
                <span class="text-xs font-semibold text-dark-500">({{ $product->review_count }})</span>
            </div>
        </div>
    </div>
</div>
