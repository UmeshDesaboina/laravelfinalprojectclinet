

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-dark-900 dark:bg-dark-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card group">
                    <p class="text-3xl font-black text-dark-800 dark:text-white">
                        {{ auth()->user()->orders->count() }}
                    </p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Total Orders</p>
                </div>

                <div class="stat-card group">
                    <p class="text-3xl font-black text-dark-800 dark:text-white">
                        {{ auth()->user()->orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}
                    </p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Active Orders</p>
                </div>

                <div class="stat-card group">
                    <p class="text-3xl font-black text-dark-800 dark:text-white">
                        {{ auth()->user()->orders->where('status', 'delivered')->count() }}
                    </p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Completed</p>
                </div>

                <div class="stat-card group">
                    <p class="text-3xl font-black text-dark-800 dark:text-white">
                        {{ auth()->user()->wishlists->count() ?? 0 }}
                    </p>
                    <p class="text-sm text-dark-500 font-medium mt-1">Wishlist Items</p>
                </div>
            </div>

            @php
                $recentOrders = auth()->user()->orders()->latest()->take(3)->get();

                // ✅ FIXED HERE
                $totalSpent = auth()->user()->orders()
                    ->where('payment_status', 'paid')
                    ->sum('total_amount');
            @endphp

            <div class="card-flat p-8">
                <h3 class="text-xl font-black text-dark-800 dark:text-white mb-6">Recent Orders</h3>

                @if($recentOrders->isEmpty())
                    <p>No orders yet</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                            <div class="flex justify-between items-center p-4 bg-dark-50 rounded-xl">

                                <div>
                                    <p class="font-bold text-dark-800">{{ $order->order_number }}</p>
                                    <p class="text-xs text-dark-400">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </p>
                                </div>

                                <!-- ✅ FIXED HERE -->
                                <div class="font-bold text-green-500">
                                    ₹{{ number_format($order->total_amount, 2) }}
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- Total Spent -->
                    <div class="mt-6 p-4 bg-green-100 rounded-xl">
                        <p class="text-sm text-gray-600">Total Spent</p>

                        <!-- ✅ FIXED HERE -->
                        <p class="text-2xl font-bold text-green-600">
                            ₹{{ number_format($totalSpent, 2) }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>


