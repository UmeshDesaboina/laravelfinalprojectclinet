@extends('layouts.app')

@section('content')
<div class="py-24 bg-dark-50 dark:bg-dark-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-12">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white shadow-lg shadow-primary-500/30">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <h1 class="text-4xl font-black text-dark-800 dark:text-white">Your Cart</h1>
                <p class="text-dark-500 mt-1">{{ $cartItems->count() }} {{ $cartItems->count() === 1 ? 'item' : 'items' }} in your cart</p>
            </div>
        </div>

        @if($cartItems->isEmpty())
            <div class="card-flat p-20 text-center">
                <div class="w-24 h-24 rounded-full bg-dark-100 dark:bg-dark-800 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-dark-800 dark:text-white mb-4">Your cart is empty</h2>
                <p class="text-dark-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop') }}" class="btn-primary !py-4 !px-8 rounded-full inline-flex items-center gap-2">
                    <span>Start Shopping</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Items List -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cartItems as $item)
                        @php
                            $price = $item->product->discount_price ?? $item->product->price;
                            $isLowStock = $item->product->stock < 5;
                            $isOutOfStock = $item->product->stock <= 0;
                        @endphp
                        <div class="card-flat p-6 flex items-center gap-6 relative group {{ $isOutOfStock ? 'opacity-60' : '' }}">
                            @if($isOutOfStock)
                                <div class="absolute inset-0 bg-red-500/10 rounded-3xl z-10"></div>
                            @endif
                            <div class="w-28 h-36 rounded-2xl overflow-hidden bg-dark-100 dark:bg-dark-700 flex-shrink-0 relative">
                                <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                @if($isOutOfStock)
                                    <div class="absolute inset-0 bg-dark-900/50 flex items-center justify-center">
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Out of Stock</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold text-dark-400 uppercase tracking-widest mb-1">{{ $item->product->category->name }}</p>
                                        <h3 class="font-bold text-lg text-dark-800 dark:text-white mb-1">{{ $item->product->name }}</h3>
                                        @if($item->variant)
                                            <p class="text-xs text-dark-500 mb-4 font-bold">Size: {{ $item->variant }}</p>
                                        @endif
                                        @if($isLowStock && !$isOutOfStock)
                                            <p class="text-xs text-orange-500 font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>
                                                Only {{ $item->product->stock }} left
                                            </p>
                                        @endif
                                    </div>
                                    <button onclick="removeItem({{ $item->id }})" class="w-10 h-10 rounded-xl bg-dark-50 dark:bg-dark-700 text-dark-300 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-3 bg-dark-50 dark:bg-dark-700/50 rounded-xl px-4 py-2">
                                        <button onclick="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-8 h-8 rounded-lg bg-dark-100 dark:bg-dark-600 text-dark-500 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 font-black text-lg transition-all">-</button>
                                        <span class="font-black text-sm w-8 text-center text-dark-800 dark:text-white">{{ $item->quantity }}</span>
                                        <button onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" {{ $item->product->stock <= $item->quantity ? 'disabled' : '' }} class="w-8 h-8 rounded-lg bg-dark-100 dark:bg-dark-600 text-dark-500 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 font-black text-lg transition-all disabled:opacity-50">+</button>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-lg text-gradient bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text">₹{{ number_format($price * $item->quantity, 2) }}</p>
                                        <p class="text-[10px] text-dark-400 font-bold">₹{{ number_format($price, 2) }} / unit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="card-flat p-10 sticky top-28">
                        <h2 class="text-2xl font-black text-dark-800 dark:text-white mb-8">Order Summary</h2>
                        
                        <!-- Coupon Code -->
                        <div class="mb-8">
                            <label class="text-xs font-black uppercase tracking-widest text-dark-400 mb-3 block">Apply Coupon</label>
                            <form action="{{ route('checkout.apply-coupon') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" name="code" placeholder="Enter coupon code" class="flex-1 rounded-xl bg-dark-50 dark:bg-dark-700 border border-dark-200 dark:border-dark-600 text-dark-800 dark:text-white text-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <button type="submit" class="btn-primary !py-3 !px-4 !text-sm">Apply</button>
                            </form>
                        </div>

                        <div class="space-y-5 mb-8">
                            <div class="flex justify-between text-sm font-semibold">
                                <span class="text-dark-500">Subtotal</span>
                                <span class="text-dark-800 dark:text-white font-bold">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-semibold">
                                <span class="text-dark-500">Delivery</span>
                                <span class="text-dark-800 dark:text-white font-bold">₹{{ number_format($deliveryCharge, 2) }}</span>
                            </div>
                            @if($subtotal > 1000)
                            <div class="flex justify-between text-sm font-semibold">
                                <span class="text-green-600">Free Shipping</span>
                                <span class="text-green-600 font-bold line-through">₹{{ number_format($deliveryCharge, 2) }}</span>
                            </div>
                            @endif
                            <div class="border-t-2 border-dark-100 dark:border-dark-700 pt-5 flex justify-between">
                                <span class="text-lg font-black text-dark-800 dark:text-white">Total</span>
                                <span class="text-2xl font-black text-gradient bg-gradient-to-r from-primary-500 to-primary-600 bg-clip-text">₹{{ number_format($subtotal + ($subtotal > 1000 ? 0 : $deliveryCharge), 2) }}</span>
                            </div>
                        </div>
                        
                        @php
                            $hasOutOfStock = $cartItems->contains(fn($item) => $item->product->stock <= 0);
                        @endphp
                        
                        @if($hasOutOfStock)
                            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                <p class="text-sm text-red-600 dark:text-red-400 font-semibold">Some items are out of stock. Please remove them to proceed.</p>
                            </div>
                        @endif

                        <a href="{{ route('checkout') }}" {{ $hasOutOfStock ? 'onclick="event.preventDefault(); alert(\'Please remove out of stock items\');"' : '' }} class="block w-full gradient-primary text-white py-5 rounded-2xl font-black text-center text-lg hover:opacity-90 transition-all shadow-xl shadow-primary-500/20">
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('shop') }}" class="block w-full text-center mt-4 text-sm font-semibold text-dark-500 hover:text-primary-500 transition-colors">
                            Continue Shopping
                        </a>

                        <div class="flex items-center justify-center gap-4 mt-6">
                            <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span class="text-xs text-dark-400 font-medium">Secure checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateQty(id, qty) {
        if (qty < 1) return;
        fetch(`{{ url('cart/update') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }

    function removeItem(id) {
        if (!confirm('Remove this item?')) return;
        fetch(`{{ url('cart/remove') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
</script>
@endpush
