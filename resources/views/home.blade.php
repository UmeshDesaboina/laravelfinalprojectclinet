@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-dark-900 h-[650px] flex items-center overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="">
        <div class="absolute inset-0 bg-gradient-to-r from-dark-900 via-dark-900/80 to-transparent"></div>
    </div>
    <div class="absolute inset-0 bg-hero-pattern opacity-30"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500/20 backdrop-blur-sm rounded-full text-primary-400 text-sm font-semibold mb-6 animate-fade-in">
                <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                New Collection Available
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight animate-fade-in-up">
                Elevate Your <span class="bg-gradient-to-r from-primary-400 to-primary-500 bg-clip-text text-transparent">Lifestyle</span>
            </h1>
            <p class="text-lg md:text-xl mb-10 text-dark-300">Discover premium products curated just for you. Quality meets style in every collection.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('shop') }}" class="btn-primary !py-4 !px-8 text-lg rounded-full group">
                    <span class="flex items-center gap-2">
                        Shop Now
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </span>
                </a>
                <a href="{{ route('shop') }}?featured=1" class="btn-secondary !py-4 !px-8 text-lg rounded-full">
                    <span class="flex items-center gap-2">
                        Featured
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-float">
        <div class="w-6 h-10 rounded-full border-2 border-white/30 flex items-start justify-center p-2">
            <div class="w-1.5 h-3 bg-white/50 rounded-full animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Features Banner -->
<section class="py-8 bg-white dark:bg-dark-800 border-b border-dark-100 dark:border-dark-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-dark-800 dark:text-white text-sm">Free Shipping</h4>
                    <p class="text-xs text-dark-500">On orders above ₹500</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-dark-800 dark:text-white text-sm">Easy Returns</h4>
                    <p class="text-xs text-dark-500">30-day return policy</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-dark-800 dark:text-white text-sm">Secure Payment</h4>
                    <p class="text-xs text-dark-500">100% secure checkout</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-dark-800 dark:text-white text-sm">24/7 Support</h4>
                    <p class="text-xs text-dark-500">Dedicated support</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-24 bg-white dark:bg-dark-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-xs font-bold text-primary-500 uppercase tracking-widest mb-2 block">Browse Categories</span>
                <h2 class="text-3xl font-bold text-dark-800 dark:text-white mb-2">Shop by Category</h2>
                <p class="text-dark-500 dark:text-dark-400">Explore our diverse collections</p>
            </div>
            <a href="{{ route('shop') }}" class="link-arrow hidden sm:flex">
                View All Categories
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
                <a href="{{ route('shop', ['category' => $category->slug]) }}" class="group text-center">
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-dark-100 to-dark-200 dark:from-dark-700 dark:to-dark-800 mb-4 shadow-sm group-hover:shadow-xl group-hover:shadow-primary-500/10 transition-all duration-500">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" alt="{{ $category->name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500/20 to-accent-500/20">
                                <span class="text-4xl font-bold bg-gradient-to-r from-primary-500 to-accent-500 bg-clip-text text-transparent">{{ substr($category->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-500/0 to-primary-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <h3 class="font-bold text-dark-800 dark:text-white group-hover:text-primary-500 transition-colors duration-300">{{ $category->name }}</h3>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-24 bg-dark-50 dark:bg-dark-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-xs font-bold text-primary-500 uppercase tracking-widest mb-2 block">Handpicked For You</span>
                <h2 class="text-3xl font-bold text-dark-800 dark:text-white mb-2">Featured Products</h2>
                <p class="text-dark-500 dark:text-dark-400">Handpicked items you'll love</p>
            </div>
            <a href="{{ route('shop') }}" class="link-arrow hidden sm:flex">
                View All Products
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>

<!-- Newsletter Banner -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-dark-800 to-dark-900 rounded-[2rem] overflow-hidden relative">
            <div class="absolute inset-0 opacity-30">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500/20 to-accent-500/20"></div>
            <div class="relative z-10 px-8 py-16 md:p-20 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Join the <span class="bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">Community</span></h2>
                <p class="text-dark-300 text-lg mb-10 max-w-xl mx-auto">Subscribe to our newsletter and get 10% off your first order plus early access to new drops.</p>
                <form class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
                    <input type="email" placeholder="Enter your email" class="flex-1 rounded-full bg-white/10 border border-white/20 text-white placeholder:text-dark-400 focus:ring-2 focus:ring-primary-500 px-6 py-4 backdrop-blur-md transition-all duration-300">
                    <button type="submit" class="btn-primary !py-4 !px-8 rounded-full whitespace-nowrap">
                        <span class="flex items-center justify-center gap-2">
                            Subscribe
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
