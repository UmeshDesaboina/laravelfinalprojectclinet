<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-dark-50 dark:bg-dark-950 text-dark-800 dark:text-dark-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/80 dark:bg-dark-800/80 backdrop-blur-xl border-b border-dark-100 dark:border-dark-700/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold tracking-tight">
                        <span class="bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text text-transparent">FIGHT</span><span class="text-dark-800 dark:text-white">WISDOM</span>
                    </a>
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold text-dark-600 dark:text-dark-300 hover:text-primary-500 transition-colors">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-primary !py-2.5 !px-6 rounded-full text-sm">
                            <span>Join Now</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-dark-800 dark:bg-dark-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-dark-500 text-sm">&copy; <?php echo e(date('Y')); ?> FIGHTWISDOM. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/components/guest-layout.blade.php ENDPATH**/ ?>