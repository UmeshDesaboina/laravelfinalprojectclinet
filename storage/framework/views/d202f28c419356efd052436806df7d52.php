<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-dark-900 dark:bg-dark-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-3xl p-8 mb-8 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="absolute inset-0 bg-hero-pattern opacity-20"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-black mb-2">Welcome back, <?php echo e(auth()->user()->name); ?>!</h1>
                        <p class="text-primary-100">Manage your orders, profile, and preferences</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="<?php echo e(route('shop')); ?>" class="px-6 py-3 bg-white text-primary-600 rounded-full font-bold hover:bg-primary-50 transition-all shadow-xl shadow-primary-500/20">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-dark-800 dark:text-white"><?php echo e(auth()->user()->orders->count()); ?></p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Total Orders</p>
                </div>

                <div class="stat-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-yellow-500 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-yellow-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-dark-800 dark:text-white"><?php echo e(auth()->user()->orders->whereIn('status', ['pending', 'processing', 'shipped'])->count()); ?></p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Active Orders</p>
                </div>

                <div class="stat-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-green-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-dark-800 dark:text-white"><?php echo e(auth()->user()->orders->where('status', 'delivered')->count()); ?></p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Completed</p>
                </div>

                <div class="stat-card group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-red-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-dark-800 dark:text-white"><?php echo e(auth()->user()->wishlists->count() ?? 0); ?></p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Wishlist Items</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="card-flat p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-black text-dark-800 dark:text-white">Recent Orders</h3>
                            <a href="<?php echo e(route('orders.index')); ?>" class="link-arrow text-sm">View All</a>
                        </div>
                        
                        <?php
                            $recentOrders = auth()->user()->orders()->latest()->take(3)->get();
                            $totalSpent = auth()->user()->orders()->where('payment_status', 'paid')->sum('total');
                        ?>
                        
                        <?php if($recentOrders->isEmpty()): ?>
                            <div class="text-center py-12">
                                <div class="w-20 h-20 rounded-full bg-dark-100 dark:bg-dark-800 flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <p class="text-dark-500 mb-4">No orders yet</p>
                                <a href="<?php echo e(route('shop')); ?>" class="btn-primary !py-3 !px-6 rounded-full inline-flex items-center gap-2">
                                    <span>Start Shopping</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-5 bg-dark-50 dark:bg-dark-700/50 rounded-2xl hover:bg-dark-100 dark:hover:bg-dark-700 transition-colors group">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500/20 to-accent-500/20 flex items-center justify-center font-black text-xs text-primary-600">
                                                #<?php echo e(substr($order->order_number, 0, 8)); ?>

                                            </div>
                                            <div>
                                                <p class="font-bold text-dark-800 dark:text-white"><?php echo e($order->order_number); ?></p>
                                                <p class="text-xs text-dark-400"><?php echo e($order->created_at->format('M d, Y • h:i A')); ?></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-black text-gradient bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text">₹<?php echo e(number_format($order->total, 2)); ?></p>
                                            <span class="status-badge 
                                                <?php if($order->status === 'delivered'): ?> status-delivered
                                                <?php elseif($order->status === 'cancelled'): ?> status-cancelled
                                                <?php elseif($order->status === 'pending'): ?> status-pending
                                                <?php else: ?> status-processing <?php endif; ?>">
                                                <?php echo e($order->status); ?>

                                            </span>
                                        </div>
                                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="px-4 py-2 text-sm font-bold text-dark-400 hover:text-primary-500 transition-colors">
                                            View →
                                        </a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <!-- Spending Summary -->
                            <div class="mt-6 p-4 bg-gradient-to-r from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-2xl">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-dark-500">Total Spent</p>
                                        <p class="text-2xl font-black text-gradient bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text">₹<?php echo e(number_format($totalSpent, 2)); ?></p>
                                    </div>
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Order Tracking Section -->
                    <?php
                        $activeOrders = auth()->user()->orders()->whereIn('status', ['pending', 'processing', 'shipped'])->latest()->get();
                    ?>
                    <?php if($activeOrders->count() > 0): ?>
                    <div class="card-flat p-8 mt-8">
                        <h3 class="text-xl font-black text-dark-800 dark:text-white mb-6">Track Your Orders</h3>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $activeOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-4 border border-dark-200 dark:border-dark-700 rounded-2xl">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="font-bold text-dark-800 dark:text-white"><?php echo e($order->order_number); ?></p>
                                        <p class="text-xs text-dark-500"><?php echo e($order->created_at->format('M d, Y')); ?></p>
                                    </div>
                                    <span class="status-badge 
                                        <?php if($order->status === 'shipped'): ?> status-shipped
                                        <?php elseif($order->status === 'processing'): ?> status-processing
                                        <?php else: ?> status-pending <?php endif; ?>">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="relative">
                                    <div class="flex items-center justify-between">
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs font-bold">✓</div>
                                            <p class="text-xs text-dark-500 mt-1">Ordered</p>
                                        </div>
                                        <div class="flex-1 h-1 mx-2 rounded-full <?php if(in_array($order->status, ['processing', 'shipped', 'delivered'])): ?> bg-green-500 <?php else: ?> bg-dark-200 dark:bg-dark-700 <?php endif; ?>"></div>
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full <?php if(in_array($order->status, ['processing', 'shipped', 'delivered'])): ?> bg-green-500 <?php else: ?> bg-dark-200 dark:bg-dark-700 <?php endif; ?> flex items-center justify-center text-white text-xs font-bold">✓</div>
                                            <p class="text-xs text-dark-500 mt-1">Processing</p>
                                        </div>
                                        <div class="flex-1 h-1 mx-2 rounded-full <?php if(in_array($order->status, ['shipped', 'delivered'])): ?> bg-green-500 <?php else: ?> bg-dark-200 dark:bg-dark-700 <?php endif; ?>"></div>
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full <?php if(in_array($order->status, ['shipped', 'delivered'])): ?> bg-green-500 <?php else: ?> bg-dark-200 dark:bg-dark-700 <?php endif; ?> flex items-center justify-center text-white text-xs font-bold">✓</div>
                                            <p class="text-xs text-dark-500 mt-1">Shipped</p>
                                        </div>
                                        <div class="flex-1 h-1 mx-2 rounded-full <?php if($order->status === 'delivered'): ?> bg-green-500 <?php else: ?> bg-dark-200 dark:bg-dark-700 <?php endif; ?>"></div>
                                        <div class="flex flex-col items-center">
                                            <div class="w-8 h-8 rounded-full <?php if($order->status === 'delivered'): ?> bg-green-500 <?php else: ?> bg-dark-200 dark:bg-dark-700 <?php endif; ?> flex items-center justify-center text-white text-xs font-bold">✓</div>
                                            <p class="text-xs text-dark-500 mt-1">Delivered</p>
                                        </div>
                                    </div>
                                </div>
                                <?php if($order->tracking_id): ?>
                                <div class="mt-4 pt-4 border-t border-dark-200 dark:border-dark-700">
                                    <p class="text-xs text-dark-500">Tracking: <span class="font-bold text-dark-800"><?php echo e($order->tracking_id); ?></span></p>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Quick Links & Account Info -->
                <div class="lg:col-span-1">
                    <div class="card-flat p-8 mb-6">
                        <h3 class="text-xl font-black text-dark-800 dark:text-white mb-6">Quick Links</h3>
                        <div class="space-y-3">
                            <a href="<?php echo e(route('orders.index')); ?>" class="flex items-center gap-4 p-4 bg-dark-50 dark:bg-dark-700/50 rounded-xl hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <span class="font-bold text-dark-700 dark:text-dark-200 group-hover:text-primary-500 transition-colors">My Orders</span>
                            </a>
                            <a href="<?php echo e(route('wishlist.index')); ?>" class="flex items-center gap-4 p-4 bg-dark-50 dark:bg-dark-700/50 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                <span class="font-bold text-dark-700 dark:text-dark-200 group-hover:text-red-500 transition-colors">Wishlist</span>
                            </a>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-4 p-4 bg-dark-50 dark:bg-dark-700/50 rounded-xl hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-violet-500 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="font-bold text-dark-700 dark:text-dark-200 group-hover:text-purple-500 transition-colors">Edit Profile</span>
                            </a>
                            <a href="<?php echo e(route('addresses.index')); ?>" class="flex items-center gap-4 p-4 bg-dark-50 dark:bg-dark-700/50 rounded-xl hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="font-bold text-dark-700 dark:text-dark-200 group-hover:text-green-500 transition-colors">Addresses</span>
                            </a>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="card-flat p-8">
                        <h3 class="text-xl font-black text-dark-800 dark:text-white mb-6">Account Info</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(auth()->user()->name); ?>&background=22c55e&color=fff&size=64" class="w-14 h-14 rounded-xl border-2 border-primary-500 shadow-lg shadow-primary-500/20" alt="">
                                <div>
                                    <p class="font-bold text-dark-800 dark:text-white"><?php echo e(auth()->user()->name); ?></p>
                                    <p class="text-sm text-dark-500"><?php echo e(auth()->user()->email); ?></p>
                                </div>
                            </div>
                            <div class="border-t border-dark-100 dark:border-dark-700 pt-4">
                                <p class="text-sm text-dark-500 mb-2">Member since</p>
                                <p class="font-bold text-dark-800 dark:text-white"><?php echo e(auth()->user()->created_at->format('M d, Y')); ?></p>
                            </div>
                            <?php if(auth()->user()->addresses->count() > 0): ?>
                            <div class="border-t border-dark-100 dark:border-dark-700 pt-4">
                                <p class="text-sm text-dark-500 mb-2">Default Address</p>
                                <p class="font-bold text-dark-800 dark:text-white text-sm"><?php echo e(auth()->user()->addresses->where('is_default', true)->first()->full_name ?? 'Not set'); ?></p>
                                <p class="text-xs text-dark-400"><?php echo e(auth()->user()->addresses->where('is_default', true)->first()->city ?? ''); ?>, <?php echo e(auth()->user()->addresses->where('is_default', true)->first()->state ?? ''); ?></p>
                            </div>
                            <?php endif; ?>
                            <!-- Security -->
                            <div class="border-t border-dark-100 dark:border-dark-700 pt-4">
                                <p class="text-sm text-dark-500 mb-3">Security</p>
                                <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-2 text-sm text-primary-500 hover:text-primary-600 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Update Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/dashboard.blade.php ENDPATH**/ ?>