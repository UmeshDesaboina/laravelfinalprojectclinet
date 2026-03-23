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
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-4 sm:px-6">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="text-3xl font-bold text-green-500 tracking-tight">
                    FIGHT<span class="text-gray-900 dark:text-white">WISDOM</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md">
                @yield('content')
            </div>
        </div>
    </body>
</html>
