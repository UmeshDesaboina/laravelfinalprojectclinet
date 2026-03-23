<?php $__env->startSection('title', 'User Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <!-- User Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <div class="text-center">
                <img src="https://ui-avatars.com/api/?name=<?php echo e($user->name); ?>" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-green-500" alt="">
                <h3 class="text-xl font-bold"><?php echo e($user->name); ?></h3>
                <p class="text-gray-500 text-sm"><?php echo e($user->email); ?></p>
                <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full <?php echo e($user->is_blocked ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'); ?>">
                    <?php echo e($user->is_blocked ? 'Blocked' : 'Active'); ?>

                </span>
            </div>
            <div class="mt-6 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Member Since</span>
                    <span class="font-medium"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Orders</span>
                    <span class="font-medium"><?php echo e($userOrders->count()); ?></span>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 flex gap-3">
                <form action="<?php echo e(route('admin.users.toggle-block', $user)); ?>" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full px-4 py-2 <?php echo e($user->is_blocked ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600'); ?> text-white rounded-lg font-semibold text-sm transition-colors">
                        <?php echo e($user->is_blocked ? 'Unblock User' : 'Block User'); ?>

                    </button>
                </form>
                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-red-500 rounded-lg font-semibold text-sm hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" onclick="return confirm('Delete this user?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- User Addresses -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h4 class="text-lg font-bold mb-4">Saved Addresses</h4>
            <?php if($user->addresses->isEmpty()): ?>
                <p class="text-gray-500 text-sm">No addresses saved.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $user->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                            <p class="font-bold text-sm"><?php echo e($address->name); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e($address->phone); ?></p>
                            <p class="text-xs text-gray-400 mt-2"><?php echo e($address->address); ?>, <?php echo e($address->city); ?>, <?php echo e($address->state); ?> - <?php echo e($address->pincode); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="lg:col-span-2">
        <!-- User Orders -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h4 class="text-lg font-bold">Order History</h4>
            </div>
            <?php if($userOrders->isEmpty()): ?>
                <div class="p-12 text-center">
                    <p class="text-gray-500">No orders yet.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                                <th class="py-4 px-6">Order ID</th>
                                <th class="py-4 px-6">Amount</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <?php $__currentLoopData = $userOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-sm text-gray-700 dark:text-gray-300">
                                    <td class="py-4 px-6 font-medium">#<?php echo e($order->id); ?></td>
                                    <td class="py-4 px-6">₹<?php echo e(number_format($order->total, 2)); ?></td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($order->status_badge_class); ?>">
                                            <?php echo e(ucfirst($order->status)); ?>

                                        </span>
                                    </td>
                                    <td class="py-4 px-6"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-6">
                    <?php echo e($userOrders->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/admin/users/show.blade.php ENDPATH**/ ?>