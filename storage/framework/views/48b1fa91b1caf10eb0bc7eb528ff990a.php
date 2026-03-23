<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-flat overflow-hidden">
    <div class="p-6 border-b border-dark-100 dark:border-dark-700">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="text-lg font-bold text-dark-800 dark:text-white">Customer List</h4>
                <p class="text-sm text-dark-500 mt-1">Manage your customer accounts</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Search users..." class="w-64 rounded-xl bg-dark-50 dark:bg-dark-700 border border-dark-200 dark:border-dark-600 text-sm py-2.5 pl-11 pr-4 focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all duration-300">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-xs font-semibold text-dark-500 dark:text-dark-400 uppercase tracking-wider bg-dark-50 dark:bg-dark-800/50">
                    <th class="py-4 px-6">User</th>
                    <th class="py-4 px-6">Email</th>
                    <th class="py-4 px-6">Joined</th>
                    <th class="py-4 px-6">Orders</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="table-row">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e($user->name); ?>&background=6366f1&color=fff&size=48" class="w-12 h-12 rounded-xl" alt="">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-dark-800 dark:text-white"><?php echo e($user->name); ?></span>
                                    <span class="text-xs text-dark-400"><?php echo e($user->email); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-dark-600 dark:text-dark-400"><?php echo e($user->email); ?></span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm text-dark-600 dark:text-dark-400"><?php echo e($user->created_at->format('M d, Y')); ?></span>
                        </td>
                        <td class="py-4 px-6">
                            <?php if($user->orders && $user->orders->count() > 0): ?>
                                <div class="flex flex-col gap-1">
                                    <?php $__currentLoopData = $user->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400"><?php echo e($order->order_number); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <span class="text-sm text-dark-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6">
                            <button onclick="toggleBlock(<?php echo e($user->id); ?>)" id="block-btn-<?php echo e($user->id); ?>" 
                                class="badge <?php echo e($user->is_blocked ? 'bg-red-100 text-red-700 dark:bg-red-900/30' : 'badge-primary'); ?>">
                                <?php echo e($user->is_blocked ? 'Blocked' : 'Active'); ?>

                            </button>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="p-2 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
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
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleBlock(id) {
        fetch(`<?php echo e(url('admin/users/toggle-block')); ?>/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const btn = document.getElementById(`block-btn-${id}`);
                if (data.is_blocked) {
                    btn.classList.remove('badge-primary');
                    btn.classList.add('bg-red-100', 'text-red-700', 'dark:bg-red-900/30');
                    btn.innerText = 'Blocked';
                } else {
                    btn.classList.remove('bg-red-100', 'text-red-700', 'dark:bg-red-900/30');
                    btn.classList.add('badge-primary');
                    btn.innerText = 'Active';
                }
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: `User ${data.is_blocked ? 'blocked' : 'unblocked'} successfully`,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/admin/users/index.blade.php ENDPATH**/ ?>