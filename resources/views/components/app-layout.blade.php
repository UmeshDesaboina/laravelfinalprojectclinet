<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
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
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-5">
                        <!-- Search -->
                        <div class="relative hidden md:block" x-data="{ query: '', results: [] }">
                            <input type="text" x-model="query" @input.debounce.300ms="fetch(`/api/search-suggestions?q=${query}`).then(r => r.json()).then(d => results = d)" placeholder="Search products..." class="w-64 rounded-full bg-dark-100 dark:bg-dark-700 border border-transparent focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 text-sm py-2.5 px-5 transition-all duration-300">
                            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <div x-show="query.length > 2 && results.length > 0" class="absolute top-full mt-3 w-full bg-white dark:bg-dark-800 rounded-2xl shadow-soft-lg border border-dark-100 dark:border-dark-700 p-3 z-50" x-cloak>
                                <template x-for="item in results" :key="item.id">
                                    <a :href="`/products/${item.slug}`" class="flex items-center gap-3 p-3 hover:bg-dark-50 dark:hover:bg-dark-700 rounded-xl transition-colors duration-200">
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

                        <!-- Mobile menu button -->
                        <div class="flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-dark-400 hover:text-dark-500 hover:bg-dark-100 dark:hover:bg-dark-700 transition-colors">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-primary-500 text-base font-medium text-primary-600 bg-primary-50 focus:outline-none transition-colors">Home</a>
                    <a href="{{ route('shop') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-dark-600 hover:text-dark-800 hover:bg-dark-50 dark:text-dark-300 dark:hover:text-white dark:hover:bg-dark-700 transition-colors">Shop</a>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-dark-800 dark:bg-dark-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                    <div>
                        <a href="{{ route('home') }}" class="text-2xl font-black inline-flex mb-4">
                            <span class="bg-gradient-to-r from-primary-400 to-primary-500 bg-clip-text text-transparent">FIGHT</span><span class="text-white">WISDOM</span>
                        </a>
                        <p class="text-dark-400 text-sm leading-relaxed">Your premium destination for quality products. We bring you the best at competitive prices.</p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Quick Links</h4>
                        <div class="space-y-2">
                            <a href="{{ route('shop') }}" class="block text-dark-400 hover:text-primary-400 transition-colors text-sm">Shop</a>
                            <a href="{{ route('wishlist.index') }}" class="block text-dark-400 hover:text-primary-400 transition-colors text-sm">Wishlist</a>
                            <a href="{{ route('orders.index') }}" class="block text-dark-400 hover:text-primary-400 transition-colors text-sm">Track Order</a>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Support</h4>
                        <div class="space-y-2">
                            <a href="#" class="block text-dark-400 hover:text-primary-400 transition-colors text-sm">Help Center</a>
                            <a href="#" class="block text-dark-400 hover:text-primary-400 transition-colors text-sm">Shipping Info</a>
                            <a href="#" class="block text-dark-400 hover:text-primary-400 transition-colors text-sm">Returns</a>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold mb-4">Contact</h4>
                        <div class="space-y-2 text-dark-400 text-sm">
                            <p>support@fightwisdom.com</p>
                            <p>+91 1234567890</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-dark-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-dark-500">
                    <p>&copy; {{ date('Y') }} FIGHTWISDOM. All rights reserved.</p>
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
                    if (document.querySelector('nav[x-data]')) {
                        document.querySelector('nav[x-data]').__x.$data.cartCount = d.count || 0;
                    }
                })
                .catch(() => {});
        });
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
