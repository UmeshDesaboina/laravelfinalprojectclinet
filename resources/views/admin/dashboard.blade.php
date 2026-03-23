@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Orders -->
    <div class="stat-card group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Total Orders</p>
                <h3 class="text-3xl font-bold text-dark-800 dark:text-white mt-2">{{ $totalOrders }}</h3>
                <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +12.5% from last month
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="stat-card group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Total Revenue</p>
                <h3 class="text-3xl font-bold text-dark-800 dark:text-white mt-2">₹{{ number_format($totalRevenue, 2) }}</h3>
                <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +8.2% from last month
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="stat-card group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Total Users</p>
                <h3 class="text-3xl font-bold text-dark-800 dark:text-white mt-2">{{ $totalUsers }}</h3>
                <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +5.3% from last month
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Products Sold -->
    <div class="stat-card group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-dark-500 dark:text-dark-400">Products Sold</p>
                <h3 class="text-3xl font-bold text-dark-800 dark:text-white mt-2">{{ $totalProductsSold }}</h3>
                <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    +15.8% from last month
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Sales Chart -->
    <div class="card-flat p-6">
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-lg font-bold text-dark-800 dark:text-white">Sales Analytics</h4>
            <select class="text-sm rounded-lg border-dark-200 dark:border-dark-700 bg-white dark:bg-dark-700 px-3 py-2">
                <option>Last 7 days</option>
                <option>Last 30 days</option>
                <option>Last 90 days</option>
            </select>
        </div>
        <canvas id="salesChart" class="max-h-80"></canvas>
    </div>

    <!-- Recent Orders -->
    <div class="card-flat p-6">
        <div class="flex items-center justify-between mb-6">
            <h4 class="text-lg font-bold text-dark-800 dark:text-white">Recent Orders</h4>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-primary-500 hover:text-primary-600 transition-colors">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs font-semibold text-dark-500 dark:text-dark-400 uppercase tracking-wider border-b border-dark-100 dark:border-dark-700">
                        <th class="pb-4 px-2">Order ID</th>
                        <th class="pb-4 px-2">Customer</th>
                        <th class="pb-4 px-2">Amount</th>
                        <th class="pb-4 px-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-100 dark:divide-dark-700">
                    @foreach($recentOrders as $order)
                        <tr class="table-row text-sm">
                            <td class="py-4 px-2 font-semibold text-dark-800 dark:text-white">{{ $order->order_number }}</td>
                            <td class="py-4 px-2">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ $order->user->name }}&background=6366f1&color=fff&size=32" class="w-8 h-8 rounded-lg" alt="">
                                    <span class="text-dark-700 dark:text-dark-300">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-2 font-semibold text-dark-800 dark:text-white">₹{{ number_format($order->total, 2) }}</td>
                            <td class="py-4 px-2">
                                <span class="status-badge 
                                    @if($order->status === 'delivered') status-delivered
                                    @elseif($order->status === 'pending') status-pending
                                    @elseif($order->status === 'cancelled') status-cancelled
                                    @else status-processing @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Alerts Section -->
@if($lowStockProducts->count() > 0 || $pendingReviews > 0 || $pendingReturns > 0)
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Low Stock Alert -->
    @if($lowStockProducts->count() > 0)
    <div class="card-flat p-6 border-l-4 border-orange-500">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-dark-800 dark:text-white">Low Stock Alert</h4>
                <p class="text-xs text-dark-500">{{ $lowStockProducts->count() }} products need attention</p>
            </div>
        </div>
        <div class="space-y-2">
            @foreach($lowStockProducts->take(3) as $product)
            <div class="flex items-center justify-between text-sm">
                <span class="text-dark-700 dark:text-dark-300 line-clamp-1">{{ $product->name }}</span>
                <span class="font-bold text-orange-500">{{ $product->stock }} left</span>
            </div>
            @endforeach
        </div>
        <a href="{{ route('admin.products.index') }}?stock=low" class="text-xs font-semibold text-primary-500 hover:text-primary-600 mt-3 inline-flex items-center gap-1">
            View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
    @endif

    <!-- Pending Reviews -->
    @if($pendingReviews > 0)
    <div class="card-flat p-6 border-l-4 border-yellow-500">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-dark-800 dark:text-white">Pending Reviews</h4>
                <p class="text-xs text-dark-500">{{ $pendingReviews }} awaiting approval</p>
            </div>
        </div>
        <a href="{{ route('admin.reviews.pending') }}" class="btn-secondary !py-2 !px-4 !text-sm w-full justify-center">
            Moderate Reviews
        </a>
    </div>
    @endif

    <!-- Return Requests -->
    @if($pendingReturns > 0)
    <div class="card-flat p-6 border-l-4 border-red-500">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-dark-800 dark:text-white">Return Requests</h4>
                <p class="text-xs text-dark-500">{{ $pendingReturns }} pending approval</p>
            </div>
        </div>
        <a href="{{ route('admin.returns.index') }}?status=pending" class="btn-secondary !py-2 !px-4 !text-sm w-full justify-center">
            Review Returns
        </a>
    </div>
    @endif
</div>
@endif

<!-- Top Products -->
<div class="card-flat p-6">
    <div class="flex items-center justify-between mb-6">
        <h4 class="text-lg font-bold text-dark-800 dark:text-white">Top Selling Products</h4>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @foreach($topProducts as $item)
        @if($item->product)
        <div class="flex items-center gap-3 p-3 bg-dark-50 dark:bg-dark-700/50 rounded-xl">
            @if($item->product->images->count() > 0)
                <img src="{{ asset('storage/' . $item->product->images->first()->image) }}" class="w-12 h-12 rounded-lg object-cover" alt="">
            @else
                <div class="w-12 h-12 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                    <span class="text-primary-500 font-bold text-xs">{{ substr($item->product->name, 0, 2) }}</span>
                </div>
            @endif
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-dark-800 dark:text-white line-clamp-1">{{ $item->product->name }}</p>
                <p class="text-xs text-primary-500 font-bold">{{ $item->total_sold }} sold</p>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData->pluck('date')) !!},
            datasets: [{
                label: 'Sales (₹)',
                data: {!! json_encode($salesData->pluck('total')) !!},
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#22c55e',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#fff',
                    bodyColor: '#94a3b8',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: { color: '#94a3b8' }
                },
                x: { 
                    grid: { display: false },
                    ticks: { color: '#94a3b8' }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
</script>
@endpush
