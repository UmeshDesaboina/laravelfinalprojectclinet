@extends('layouts.admin')

@section('title', 'Coupon Management')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="{ openCreateModal: false, openEditModal: false, editCoupon: {} }">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Coupon List</h4>
        <button @click="openCreateModal = true" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors">
            Add New Coupon
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">Code</th>
                    <th class="py-4 px-6">Type</th>
                    <th class="py-4 px-6">Value</th>
                    <th class="py-4 px-6">Min Order</th>
                    <th class="py-4 px-6">Expiry</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($coupons as $coupon)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6 font-bold text-gray-800 dark:text-white">{{ $coupon->code }}</td>
                        <td class="py-4 px-6 capitalize">{{ $coupon->type }}</td>
                        <td class="py-4 px-6">{{ $coupon->type == 'percent' ? $coupon->value.'%' : '₹'.number_format($coupon->value, 2) }}</td>
                        <td class="py-4 px-6">₹{{ number_format($coupon->min_order, 2) }}</td>
                        <td class="py-4 px-6">{{ $coupon->expiry_date ? $coupon->expiry_date : 'No Expiry' }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $coupon->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <button @click="editCoupon = {{ $coupon }}; openEditModal = true" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</button>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-6">
        {{ $coupons->links() }}
    </div>

    <!-- Create Modal -->
    <div x-show="openCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-md p-6 shadow-xl" @click.away="openCreateModal = false">
            <h3 class="text-xl font-bold mb-4">Add New Coupon</h3>
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Coupon Code</label>
                        <input type="text" name="code" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Type</label>
                        <select name="type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                            <option value="fixed">Fixed Amount</option>
                            <option value="percent">Percentage</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Value</label>
                        <input type="number" step="0.01" name="value" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Min Order (₹)</label>
                        <input type="number" step="0.01" name="min_order" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" value="0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Expiry Date</label>
                        <input type="date" name="expiry_date" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Usage Limit</label>
                        <input type="number" name="usage_limit" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" checked class="rounded text-green-500">
                        <span class="ml-2 text-sm">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openCreateModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-md p-6 shadow-xl" @click.away="openEditModal = false">
            <h3 class="text-xl font-bold mb-4">Edit Coupon</h3>
            <form :action="`{{ url('admin/coupons') }}/${editCoupon.id}`" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium mb-1">Coupon Code</label>
                        <input type="text" name="code" x-model="editCoupon.code" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Type</label>
                        <select name="type" x-model="editCoupon.type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                            <option value="fixed">Fixed Amount</option>
                            <option value="percent">Percentage</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Value</label>
                        <input type="number" step="0.01" name="value" x-model="editCoupon.value" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Min Order (₹)</label>
                        <input type="number" step="0.01" name="min_order" x-model="editCoupon.min_order" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Expiry Date</label>
                        <input type="date" name="expiry_date" x-model="editCoupon.expiry_date" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Usage Limit</label>
                        <input type="number" name="usage_limit" x-model="editCoupon.usage_limit" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" :checked="editCoupon.is_active" class="rounded text-green-500">
                        <span class="ml-2 text-sm">Active</span>
                    </label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
