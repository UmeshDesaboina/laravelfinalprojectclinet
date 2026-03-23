@extends('layouts.app')

@section('content')
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ showReturnModal: false, reason: '', reason_description: '', bank_account_number: '', bank_ifsc: '', bank_account_name: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <a href="{{ route('orders.index') }}" class="text-xs font-black uppercase tracking-widest text-green-500 mb-4 inline-block hover:text-green-600">← Back to Orders</a>
                <h1 class="text-4xl font-black">Order {{ $order->order_number }}</h1>
                <p class="text-gray-500 font-medium mt-2">Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('orders.invoice', $order) }}" class="px-8 py-4 rounded-2xl font-black bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all">Download Invoice</a>
                @if($order->status === 'pending')
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-8 py-4 rounded-2xl font-black bg-red-500 text-white hover:bg-red-600 transition-all" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                    </form>
                @endif
                @if($order->status === 'delivered' && $order->returnRequest->isEmpty())
                    <form action="{{ route('orders.return.form', $order) }}" method="GET">
                        <button type="submit" class="px-8 py-4 rounded-2xl font-black bg-orange-500 text-white shadow-xl shadow-orange-500/20 hover:bg-orange-600 transition-all">Request Return</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-10">
                <!-- Status Timeline -->
                <section class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm">
                    <h2 class="text-xl font-black uppercase tracking-widest text-gray-400 mb-10">Order Status</h2>
                    <div class="relative flex flex-col md:flex-row justify-between gap-8">
                        @php
                            $steps = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIdx = array_search($order->status, $steps);
                        @endphp
                        @foreach($steps as $idx => $step)
                            <div class="flex flex-row md:flex-col items-center gap-4 relative z-10 flex-1">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-sm
                                    @if($currentIdx !== false && $idx <= $currentIdx) bg-green-500 text-white shadow-xl shadow-green-500/30 @else bg-gray-100 dark:bg-gray-700 text-gray-400 @endif">
                                    @if($currentIdx !== false && $idx < $currentIdx)
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    @else
                                        {{ $idx + 1 }}
                                    @endif
                                </div>
                                <span class="font-black text-xs uppercase tracking-widest @if($currentIdx !== false && $idx <= $currentIdx) text-gray-900 dark:text-white @else text-gray-400 @endif">{{ ucfirst($step) }}</span>
                            </div>
                        @endforeach
                        <div class="absolute top-6 left-0 w-full h-1 bg-gray-100 dark:bg-gray-700 -z-0 hidden md:block"></div>
                        @if($currentIdx !== false)
                        <div class="absolute top-6 left-0 h-1 bg-green-500 transition-all duration-1000 -z-0 hidden md:block" style="width: {{ ($currentIdx / (count($steps)-1)) * 100 }}%"></div>
                        @endif
                    </div>
                </section>

                <!-- Tracking Details -->
                @if($order->tracking_id)
                <section class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm border border-green-200 dark:border-green-800">
                    <h2 class="text-xl font-black uppercase tracking-widest text-gray-400 mb-6">Tracking Details</h2>
                    <div class="flex items-center gap-6 p-6 bg-green-50 dark:bg-green-900/20 rounded-2xl">
                        <div class="w-16 h-16 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-500">Shipped via {{ $order->courier_name }}</p>
                            <p class="text-2xl font-black text-green-600">Tracking ID: {{ $order->tracking_id }}</p>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Return Request Status - ONLY shows if return was explicitly requested by user -->
                @if($order->returnRequest->count() > 0)
                @foreach($order->returnRequest as $return)
                <section class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-black uppercase tracking-widest text-gray-400">Return Request</h2>
                        @if(in_array($return->status, ['pending', 'approved']))
                            <form action="{{ route('returns.cancel', $return) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-sm font-bold text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" onclick="return confirm('Are you sure you want to cancel this return request?')">
                                    Cancel Return
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-700/50 rounded-2xl mb-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="font-bold text-gray-800 dark:text-white">Request #{{ $return->request_number }}</p>
                                <p class="text-xs text-gray-500 mt-1">Submitted on {{ $return->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $return->status_badge_class }}">
                                {{ ucfirst($return->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Reason:</strong> {{ ucfirst(str_replace('_', ' ', $return->reason)) }}</p>
                        @if($return->reason_description)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Description:</strong> {{ $return->reason_description }}</p>
                        @endif
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><strong>Refund Amount:</strong> ₹{{ number_format($return->refund_amount, 2) }}</p>
                    </div>

                    @if($return->status === 'approved')
                    <div class="p-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800">
                        <h3 class="font-bold text-blue-800 dark:text-blue-200 mb-4">Return Pickup Tracking</h3>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-500">Pickup via {{ $return->courier_name }}</p>
                                <p class="text-lg font-black text-blue-600">{{ $return->tracking_id }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($return->status === 'refunded')
                    <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-2xl border border-green-200 dark:border-green-800">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-green-800 dark:text-green-200">Refund Processed</p>
                                <p class="text-sm text-gray-500">₹{{ number_format($return->refund_amount, 2) }} refunded to your account</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </section>
                @endforeach
                @endif

                <!-- Items -->
                <section class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm">
                    <h2 class="text-xl font-black uppercase tracking-widest text-gray-400 mb-8">Items</h2>
                    <div class="divide-y dark:divide-gray-700">
                        @foreach($order->items as $item)
                            <div class="py-6 flex items-center gap-6 group">
                                <div class="w-20 h-24 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-700 flex-shrink-0">
                                    <img src="{{ $item->product && $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-black text-lg group-hover:text-green-500 transition-colors">{{ $item->product ? $item->product->name : 'Product Deleted' }}</h3>
                                    @if($item->variant)
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Size: {{ $item->variant }}</p>
                                    @endif
                                    <p class="text-sm font-bold text-gray-500 mt-2">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                                </div>
                                <p class="text-xl font-black">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="space-y-10">
                <!-- Shipping Details -->
                <section class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-black uppercase tracking-widest text-gray-400 mb-6">Shipping</h2>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-black">{{ $order->address ? $order->address->name : 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ $order->address ? $order->address->phone : '' }}</p>
                            </div>
                        </div>
                        @if($order->address)
                        <p class="text-sm text-gray-400 leading-relaxed pl-14">
                            {{ $order->address->address }}, {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}
                        </p>
                        @endif
                    </div>
                </section>

                <!-- Order Summary -->
                <section class="bg-gray-900 text-white rounded-[2.5rem] p-10 shadow-2xl">
                    <h2 class="text-xl font-black uppercase tracking-widest text-gray-500 mb-8">Summary</h2>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm font-bold text-gray-400">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($order->subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-gray-400">
                            <span>Delivery</span>
                            <span>₹{{ number_format($order->shipping_cost ?? 0, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-sm font-bold text-green-500">
                                <span>Discount</span>
                                <span>-₹{{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="border-t border-white/10 pt-4 flex justify-between">
                            <span class="text-lg font-black">Total Paid</span>
                            <span class="text-3xl font-black text-green-500 tracking-tight">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-gray-500">Payment</p>
                            <p class="text-sm font-bold">{{ strtoupper($order->payment_method) }} ({{ ucfirst($order->payment_status) }})</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Return Request Modal -->
<div x-show="showReturnModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    x-cloak>
    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] w-full max-w-xl p-10 shadow-2xl" @click.away="showReturnModal = false" @keydown.escape.window="showReturnModal = false">
        <h3 class="text-2xl font-black mb-8">Request Return</h3>
        <form action="{{ route('orders.return', $order) }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Reason for Return</label>
                    <select name="reason" x-model="reason" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                        <option value="">Select a reason</option>
                        <option value="defective">Defective/Damaged</option>
                        <option value="wrong_item">Wrong Item Received</option>
                        <option value="not_as_described">Not as Described</option>
                        <option value="damaged_in_transit">Damaged in Transit</option>
                        <option value="changed_mind">Changed Mind</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Description (Optional)</label>
                    <textarea name="reason_description" x-model="reason_description" rows="3" class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" placeholder="Please describe the issue..."></textarea>
                </div>

                <div class="border-t dark:border-gray-700 pt-6">
                    <h4 class="font-bold text-gray-800 dark:text-white mb-4">Bank Details for Refund</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Account Holder Name</label>
                            <input type="text" name="bank_account_name" x-model="bank_account_name" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Bank Account Number</label>
                            <input type="text" name="bank_account_number" x-model="bank_account_number" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">IFSC Code</label>
                            <input type="text" name="bank_ifsc" x-model="bank_ifsc" required class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" placeholder="e.g., SBIN0001234">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <button type="button" @click="showReturnModal = false" class="px-8 py-4 text-gray-500 font-bold hover:bg-gray-50 dark:hover:bg-gray-700 rounded-2xl">Cancel</button>
                <button type="submit" class="bg-orange-500 text-white px-10 py-4 rounded-2xl font-black hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20">Submit Return</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50 px-6 py-4 bg-green-500 text-white rounded-xl shadow-xl font-bold flex items-center gap-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50 px-6 py-4 bg-red-500 text-white rounded-xl shadow-xl font-bold flex items-center gap-3">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    {{ session('error') }}
</div>
@endif
@endsection
