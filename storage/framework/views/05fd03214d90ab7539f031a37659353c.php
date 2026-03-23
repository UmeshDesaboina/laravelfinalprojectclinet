<?php $__env->startSection('title', 'Order Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-green-500 hover:text-green-600">← Back to Orders</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white">Order Items</h4>
                    <span class="text-sm text-gray-500">Order #<?php echo e($order->order_number); ?></span>
                </div>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                            <th class="py-4">Product</th>
                            <th class="py-4">Quantity</th>
                            <th class="py-4 text-right">Price</th>
                            <th class="py-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-sm text-gray-700 dark:text-gray-300">
                                <td class="py-4 flex items-center gap-4">
                                    <img src="<?php echo e($item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : 'https://via.placeholder.com/150'); ?>" class="w-12 h-12 rounded-lg object-cover" alt="">
                                    <div>
                                        <p class="font-medium"><?php echo e($item->product->name); ?></p>
                                        <?php if($item->variant): ?>
                                            <p class="text-xs text-gray-500">Size: <?php echo e($item->variant); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-4"><?php echo e($item->quantity); ?></td>
                                <td class="py-4 text-right">₹<?php echo e(number_format($item->price, 2)); ?></td>
                                <td class="py-4 text-right font-medium">₹<?php echo e(number_format($item->price * $item->quantity, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex flex-col items-end">
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <p>Subtotal: <span class="text-gray-800 dark:text-white font-medium">₹<?php echo e(number_format($order->subtotal, 2)); ?></span></p>
                    <p>Delivery: <span class="text-gray-800 dark:text-white font-medium">₹<?php echo e(number_format($order->shipping_cost, 2)); ?></span></p>
                    <?php if($order->discount > 0): ?>
                        <p>Discount: <span class="text-green-500 font-medium">-₹<?php echo e(number_format($order->discount, 2)); ?></span></p>
                    <?php endif; ?>
                    <p class="text-lg font-bold text-gray-800 dark:text-white mt-4 border-t pt-4">Total: ₹<?php echo e(number_format($order->total, 2)); ?></p>
                </div>
            </div>
        </div>

        <!-- Return Requests -->
        <?php if($order->returnRequest->count() > 0): ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h4 class="text-lg font-bold text-gray-800 dark:text-white">Return Requests</h4>
            </div>
            <div class="p-6">
                <?php $__currentLoopData = $order->returnRequest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-b dark:border-gray-700 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-gray-800 dark:text-white">Request #<?php echo e($return->request_number); ?></p>
                                <p class="text-xs text-gray-500">Status: <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($return->status_badge_class); ?>"><?php echo e(ucfirst($return->status)); ?></span></p>
                            </div>
                            <span class="text-xs text-gray-500"><?php echo e($return->created_at->format('M d, Y h:i A')); ?></span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><strong>Reason:</strong> <?php echo e(ucfirst(str_replace('_', ' ', $return->reason))); ?></p>
                        <?php if($return->reason_description): ?>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><strong>Description:</strong> <?php echo e($return->reason_description); ?></p>
                        <?php endif; ?>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><strong>Refund Amount:</strong> ₹<?php echo e(number_format($return->refund_amount, 2)); ?></p>
                        
                        <?php if($return->courier_name && $return->tracking_id): ?>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><strong>Pickup Courier:</strong> <?php echo e($return->courier_name); ?></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2"><strong>Tracking ID:</strong> <?php echo e($return->tracking_id); ?></p>
                        <?php endif; ?>

                        <?php if($return->bank_account_number): ?>
                            <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-xs font-bold text-gray-500 uppercase mb-2">Bank Details for Refund</p>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>A/C Name:</strong> <?php echo e($return->bank_account_name); ?></p>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>A/C Number:</strong> <?php echo e($return->bank_account_number); ?></p>
                                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>IFSC:</strong> <?php echo e($return->bank_ifsc); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 flex gap-2">
                            <?php if($return->status === 'requested'): ?>
                                <button onclick="updateReturnStatus(<?php echo e($return->id); ?>, 'approved')" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600">Approve</button>
                                <button onclick="updateReturnStatus(<?php echo e($return->id); ?>, 'rejected')" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600">Reject</button>
                            <?php elseif($return->status === 'approved'): ?>
                                <button onclick="updateReturnStatus(<?php echo e($return->id); ?>, 'picked')" class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600">Mark Picked</button>
                            <?php elseif($return->status === 'picked'): ?>
                                <button onclick="updateReturnStatus(<?php echo e($return->id); ?>, 'received')" class="px-4 py-2 bg-indigo-500 text-white rounded-lg text-sm font-semibold hover:bg-indigo-600">Mark Received</button>
                            <?php elseif($return->status === 'received'): ?>
                                <button onclick="updateReturnStatus(<?php echo e($return->id); ?>, 'refunded')" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700">Process Refund</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="space-y-6">
        <!-- Order Status -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Order Status</h4>
            <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST" id="status-form">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" id="order-status" onchange="toggleTrackingFields()" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
                        <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                        <option value="shipped" <?php echo e($order->status == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                        <option value="delivered" <?php echo e($order->status == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                        <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                
                <div id="tracking-fields" class="space-y-4 <?php echo e($order->status == 'shipped' ? '' : 'hidden'); ?>">
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Courier Name</label>
                        <input type="text" name="courier_name" id="courier_name" value="<?php echo e($order->courier_name); ?>" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" placeholder="e.g., Delhivery, BlueDart">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Tracking ID</label>
                        <input type="text" name="tracking_id" id="tracking_id" value="<?php echo e($order->tracking_id); ?>" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" placeholder="Enter tracking number">
                    </div>
                </div>

                <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-colors shadow-sm">Update Order</button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Customer Info</h4>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=<?php echo e($order->user->name); ?>" class="w-10 h-10 rounded-full" alt="">
                    <div>
                        <p class="font-medium"><?php echo e($order->user->name); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($order->user->email); ?></p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <p class="text-sm font-semibold mb-2">Shipping Address</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <?php if($order->address): ?>
                            <?php echo e($order->address->name); ?><br>
                            <?php echo e($order->address->phone); ?><br>
                            <?php echo e($order->address->address); ?><br>
                            <?php echo e($order->address->city); ?>, <?php echo e($order->address->state); ?> - <?php echo e($order->address->pincode); ?>

                        <?php else: ?>
                            <?php echo e($order->shipping_address); ?>

                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleTrackingFields() {
        const status = document.getElementById('order-status').value;
        const trackingFields = document.getElementById('tracking-fields');
        if (status === 'shipped') {
            trackingFields.classList.remove('hidden');
            document.getElementById('courier_name').required = true;
            document.getElementById('tracking_id').required = true;
        } else {
            trackingFields.classList.add('hidden');
            document.getElementById('courier_name').required = false;
            document.getElementById('tracking_id').required = false;
        }
    }

    document.getElementById('status-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                setTimeout(() => location.reload(), 1500);
            }
        });
    });

    function updateReturnStatus(id, status) {
        const data = { status: status };
        
        if (status === 'approved' || status === 'picked') {
            const courierName = prompt('Enter Courier Name:');
            const trackingId = prompt('Enter Tracking ID:');
            if (!courierName || !trackingId) return;
            data.courier_name = courierName;
            data.tracking_id = trackingId;
        }

        fetch(`/admin/returns/update-status/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                setTimeout(() => location.reload(), 1500);
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>