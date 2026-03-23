@extends('layouts.app')

@section('content')
<div class="py-24 bg-dark-50 dark:bg-dark-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-12">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <h1 class="text-4xl font-black text-dark-800 dark:text-white">My Orders</h1>
                <p class="text-dark-500 mt-1">Track and manage your orders</p>
            </div>
        </div>

        @if($orders->isEmpty())
            <div class="card-flat p-20 text-center">
                <div class="w-24 h-24 rounded-full bg-dark-100 dark:bg-dark-800 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-dark-800 dark:text-white mb-4">No orders yet</h2>
                <p class="text-dark-500 mb-8">You haven't placed any orders yet.</p>
                <a href="{{ route('shop') }}" class="btn-primary !py-4 !px-8 rounded-full inline-flex items-center gap-2">
                    <span>Start Shopping</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="card-flat p-8 flex flex-col md:flex-row justify-between items-center gap-8 group hover:border-primary-500 transition-all">
                        <div class="flex items-center gap-8">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary-500/20 to-accent-500/20 flex items-center justify-center font-black text-xs text-primary-500">
                                #{{ substr($order->order_number, 0, 8) }}
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-dark-400 mb-1">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                <h3 class="text-xl font-black text-dark-800 dark:text-white">₹{{ number_format($order->total, 2) }}</h3>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full 
                                        @if($order->status === 'delivered') bg-green-500
                                        @elseif($order->status === 'cancelled') bg-red-500
                                        @else bg-blue-500 @endif"></span>
                                    <span class="status-badge 
                                        @if($order->status === 'delivered') status-delivered
                                        @elseif($order->status === 'cancelled') status-cancelled
                                        @elseif($order->status === 'pending') status-pending
                                        @elseif($order->status === 'shipped') status-shipped
                                        @else status-processing @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('orders.show', $order) }}" class="btn-secondary !py-3 !px-6">
                                <span class="flex items-center gap-2">
                                    View Details
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </span>
                            </a>
                            @if($order->status === 'delivered')
                                <a href="{{ route('orders.return.form', $order) }}" class="px-6 py-3 rounded-xl font-bold text-dark-500 hover:text-primary-500 transition-colors">
                                    Return
                                </a>
                            @endif
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all" onclick="return confirm('Cancel this order?')">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-12">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
