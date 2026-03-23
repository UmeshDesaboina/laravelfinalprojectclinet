@extends('layouts.admin')

@section('title', 'Sales Reports')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Cards -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($totalOrders) }}</h3>
        </div>
        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">₹{{ number_format($totalRevenue, 2) }}</h3>
        </div>
        <div class="p-3 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($totalUsers) }}</h3>
        </div>
        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 text-purple-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Products</p>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($totalProducts) }}</h3>
        </div>
        <div class="p-3 bg-orange-100 dark:bg-orange-900/30 text-orange-600 rounded-xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Export Orders -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Export Orders</h4>
        <form action="{{ route('admin.reports.export') }}" method="GET" class="flex flex-wrap gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">From Date</label>
                <input type="date" name="start_date" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">To Date</label>
                <input type="date" name="end_date" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold text-sm transition-colors shadow-sm">
                    Export CSV
                </button>
            </div>
        </form>
    </div>

    <!-- Top Selling Products -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Top Selling Products</h4>
        <div class="space-y-3">
            @forelse($topProducts->take(5) as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full text-xs font-bold flex items-center justify-center">{{ $loop->iteration }}</span>
                        <span class="text-sm font-medium">{{ Str::limit($product->name, 25) }}</span>
                    </div>
                    <span class="text-sm font-bold text-gray-500">{{ $product->order_items_count }} sold</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No sales data available.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Monthly Sales -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Monthly Sales</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                        <th class="py-3 px-2">Month</th>
                        <th class="py-3 px-2 text-right">Orders</th>
                        <th class="py-3 px-2 text-right">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($monthlySales->take(12) as $sale)
                        <tr class="text-sm text-gray-700 dark:text-gray-300">
                            <td class="py-3 px-2">{{ Carbon\Carbon::create()->month($sale->month)->format('F') }} {{ $sale->year }}</td>
                            <td class="py-3 px-2 text-right">{{ $sale->orders }}</td>
                            <td class="py-3 px-2 text-right font-bold text-green-500">₹{{ number_format($sale->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No sales data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Categories -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Top Categories</h4>
        <div class="space-y-3">
            @forelse($topCategories as $category)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium">{{ $category->name }}</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: {{ $loop->first ? 100 : ($category->total_sold / $topCategories->first()->total_sold * 100) }}%"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-500 w-16 text-right">{{ $category->total_sold }} sold</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No category data available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
