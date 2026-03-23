<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col fixed h-full">
        
        <!-- Logo -->
        <div class="p-5 flex items-center justify-between border-b border-gray-700">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center">
                    ⚡
                </div>
                <span class="text-xl font-bold">FightWisdom</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-3 flex-1 space-y-2">

            <a href="{{ route('admin.dashboard') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Dashboard
            </a>

            <a href="{{ route('admin.categories.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Categories
            </a>

            <a href="{{ route('admin.products.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Products
            </a>

            <a href="{{ route('admin.orders.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Orders
            </a>

            <a href="{{ route('admin.users.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Users
            </a>

            <a href="{{ route('admin.coupons.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Coupons
            </a>

            <a href="{{ route('admin.returns.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Returns
            </a>

            <a href="{{ route('admin.reviews.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Reviews
            </a>

            <a href="{{ route('admin.reports.index') }}" class="block p-3 rounded-lg hover:bg-gray-700">
                Reports
            </a>

        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-lg text-white">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="ml-64 flex-1 p-8">

        <!-- Header -->
        <header class="mb-8 flex justify-between items-center">
            <h2 class="text-2xl font-bold">@yield('title')</h2>

            <input type="text" placeholder="Search..." 
                   class="border px-4 py-2 rounded-lg">
        </header>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')

    </main>

</div>
</body>
</html>
