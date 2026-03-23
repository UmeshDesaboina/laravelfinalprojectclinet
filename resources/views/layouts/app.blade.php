<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" /> -->

    <!-- Scripts -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-dark-50 dark:bg-dark-950 text-dark-800 dark:text-dark-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav x-data="{ open: false, searchOpen: false, cartCount: 0 }" class="bg-white/80 dark:bg-dark-800/80 backdrop-blur-xl border-b border-dark-100 dark:border-dark-700/50 sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight group">
                            <span class="bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text text-transparent">FIGHT</span><span class="text-dark-800 dark:text-white">WISDOM</span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }} inline-flex items-center px-1 pt-1 text-sm font-medium leading-5">
                            Home
                        </a>
                        <a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }} inline-flex items-center px-1 pt-1 text-sm font-medium leading-5">
                            Shop
                        </a>
                        <a href="#" class="nav-link inline-flex items-center px-1 pt-1 text-sm font-medium leading-5">
                            New Arrivals
                        </a>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-5">
                        <!-- Search -->
                        <div class="relative hidden md:block" x-data="{ query: '', results: [] }">
                            <input type="text" x-model="query" @input.debounce.300ms="fetch(`{{ route('api.search-suggestions') }}?q=${query}`).then(r => r.ok ? r.json() : []).then(d => results = d).catch(() => results = [])" placeholder="Search products..." class="w-64 rounded-full bg-dark-100 dark:bg-dark-700 border border-transparent focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-sm py-2.5 px-5 transition-all duration-300">
                            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <div x-show="query.length > 2 && results.length > 0" class="absolute top-full mt-3 w-full bg-white dark:bg-dark-800 rounded-2xl shadow-soft-lg border border-dark-100 dark:border-dark-700 p-3 z-50" x-cloak>
                                <template x-for="item in results" :key="item.id">
                                    <a :href="`{{ url('products') }}/${item.slug}`" class="flex items-center gap-3 p-3 hover:bg-dark-50 dark:hover:bg-dark-700 rounded-xl transition-colors duration-200">
                                        <img :src="item.image" class="w-12 h-12 rounded-xl object-cover">
                                        <div>
                                            <p class="text-sm font-semibold text-dark-800 dark:text-white" x-text="item.name"></p>
                                            <p class="text-xs text-primary-600 font-bold" x-text="`₹${item.price}`"></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>

                        <!-- User Menu -->
                        @auth
                            <div class="flex items-center gap-1">
                                <a href="{{ route('wishlist.index') }}" class="icon-btn relative" title="Wishlist">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </a>
                                <a href="{{ route('cart.index') }}" class="icon-btn relative" title="Cart">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span x-show="cartCount > 0" class="absolute -top-1 -right-1 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-glow-green" x-text="cartCount"></span>
                                </a>
                                <button @click="compareOpen = true" class="icon-btn relative" title="Compare">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    <span id="compare-count" class="absolute -top-1 -right-1 bg-gradient-to-r from-accent-500 to-accent-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full hidden">0</span>
                                </button>
                                <div class="relative ml-2" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center gap-2 p-1 rounded-xl hover:bg-dark-100 dark:hover:bg-dark-700 transition-colors duration-300">
                                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=22c55e&color=fff" class="w-9 h-9 rounded-xl border-2 border-transparent hover:border-primary-500 transition-colors duration-300" alt="">
                                    </button>
                                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-3 w-56 bg-white dark:bg-dark-800 rounded-2xl shadow-soft-xl border border-dark-100 dark:border-dark-700 py-3 z-50" x-cloak>
                                        <div class="px-4 py-2 border-b border-dark-100 dark:border-dark-700">
                                            <p class="text-sm font-semibold text-dark-800 dark:text-white">{{ auth()->user()->name }}</p>
                                            <p class="text-xs text-dark-500">{{ auth()->user()->email }}</p>
                                        </div>
                                        @if(auth()->user()->isAdmin())
                                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-dark-600 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-700 transition-colors">
                                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Admin Panel
                                            </a>
                                        @endif
                                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-dark-600 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            Dashboard
                                        </a>
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-dark-600 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            Profile
                                        </a>
                                        <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-dark-600 dark:text-dark-300 hover:bg-dark-50 dark:hover:bg-dark-700 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            My Orders
                                        </a>
                                        <div class="border-t border-dark-100 dark:border-dark-700 mt-2 pt-2">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-dark-600 dark:text-dark-300 hover:text-primary-500 transition-colors">Login</a>
                                <a href="{{ route('register') }}" class="btn-primary !py-2.5 !px-6 rounded-full text-sm">
                                    <span>Join Now</span>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-dark-800 dark:bg-dark-900 border-t border-dark-700 pt-20 pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                    <div class="col-span-1 md:col-span-1">
                        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight mb-6 block">
                            <span class="bg-gradient-to-r from-primary-400 to-primary-500 bg-clip-text text-transparent">FIGHT</span><span class="text-white">WISDOM</span>
                        </a>
                        <p class="text-dark-400 text-sm leading-relaxed">
                            Experience the best premium e-commerce design with smooth animations and transitions. Built for performance and user experience.
                        </p>
                        <div class="flex gap-4 mt-6">
                            <a href="#" class="w-10 h-10 rounded-xl bg-dark-700 flex items-center justify-center text-dark-400 hover:bg-primary-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-dark-700 flex items-center justify-center text-dark-400 hover:bg-primary-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-dark-700 flex items-center justify-center text-dark-400 hover:bg-primary-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-6">Shop</h4>
                        <ul class="space-y-4 text-sm text-dark-400">
                            <li><a href="{{ route('shop') }}" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">All Products <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">Featured <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">New Arrivals <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">Best Sellers <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-6">Support</h4>
                        <ul class="space-y-4 text-sm text-dark-400">
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">Order Tracking <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">Returns & Refunds <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">Shipping Policy <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                            <li><a href="#" class="hover:text-primary-400 transition-colors duration-300 inline-flex items-center gap-2 group">Contact Us <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-6">Newsletter</h4>
                        <p class="text-sm text-dark-400 mb-4">Subscribe to get latest updates and offers.</p>
                        <form class="flex gap-2">
                            <input type="email" placeholder="Email address" class="flex-1 rounded-xl bg-dark-700 border border-dark-600 text-white placeholder:text-dark-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-sm px-4 py-3 transition-all duration-300">
                            <button type="submit" class="btn-primary !px-5 !py-3 rounded-xl">
                                <span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-dark-700 pt-10 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-dark-500">
                    <p>© 2026 FIGHTWISDOM. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-primary-400 transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-primary-400 transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/cart/count')
                .then(r => r.json())
                .then(d => {
                    document.querySelector('nav[x-data]').__x.$data.cartCount = d.count || 0;
                })
                .catch(() => {});
        });
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
