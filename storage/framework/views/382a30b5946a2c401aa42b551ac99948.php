<?php $__env->startSection('title', 'Order Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-flat overflow-hidden">
    <div class="p-6 border-b border-dark-100 dark:border-dark-700 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h4 class="text-lg font-bold text-dark-800 dark:text-white">Order List</h4>
            <p class="text-sm text-dark-500 mt-1">Manage and track all customer orders</p>
        </div>
        <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" class="flex gap-3">
            <select name="status" class="rounded-xl border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-700 text-sm px-4 py-2.5">
                <option value="">All Status</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                <option value="shipped" <?php echo e(request('status') == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
            </select>
            <button type="submit" class="btn-primary !py-2.5 !px-5 !text-sm rounded-xl">
                <span>Filter</span>
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-dark-500 dark:text-dark-400 uppercase tracking-wider bg-dark-50 dark:bg-dark-800/50">
                    <th class="py-4 px-6">Order</th>
                    <th class="py-4 px-6">Customer</th>
                    <th class="py-4 px-6">Amount</th>
                    <th class="py-4 px-6">Payment</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="table-row">
                        <td class="py-4 px-6">
                            <span class="font-bold text-dark-800 dark:text-white"><?php echo e($order->order_number); ?></span>
                            <span class="text-xs text-dark-400 block mt-1"><?php echo e($order->created_at->format('M d, Y h:i A')); ?></span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e($order->user->name); ?>&background=6366f1&color=fff&size=40" class="w-10 h-10 rounded-xl" alt="">
                                <div class="flex flex-col">
                                    <span class="font-medium text-dark-800 dark:text-white"><?php echo e($order->user->name); ?></span>
                                    <span class="text-xs text-dark-400"><?php echo e($order->user->email); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-dark-800 dark:text-white">₹<?php echo e(number_format($order->total, 2)); ?></span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="badge <?php echo e($order->payment_status == 'paid' ? 'badge-primary' : 'bg-red-100 text-red-700 dark:bg-red-900/30'); ?>">
                                <?php echo e(ucfirst($order->payment_status)); ?>

                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <select onchange="updateOrderStatus(<?php echo e($order->id); ?>, this.value)" 
                                class="text-xs rounded-lg border-dark-200 dark:border-dark-600 bg-white dark:bg-dark-700 px-3 py-2 font-medium">
                                <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                                <option value="shipped" <?php echo e($order->status == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                <option value="delivered" <?php echo e($order->status == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                                <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="p-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <form action="<?php echo e(route('admin.orders.destroy', $order)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/40 transition-all duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t border-dark-100 dark:border-dark-700">
        <?php echo e($orders->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateOrderStatus(id, status) {
        let data = { status: status };
        
        if (status === 'shipped') {
            const courierName = prompt('Enter Courier Name (required for shipped):');
            const trackingId = prompt('Enter Tracking ID (required for shipped):');
            if (!courierName || !trackingId) {
                location.reload();
                return;
            }
            data.courier_name = courierName;
            data.tracking_id = trackingId;
        }
        
        fetch(`<?php echo e(url('admin/orders/update-status')); ?>/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Order status updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>