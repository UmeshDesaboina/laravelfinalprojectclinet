@extends('layouts.app')

@section('content')
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="checkoutData()" x-init="init()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black mb-12">Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-10">
                <!-- Shipping Address -->
                <section>
                    <div class="flex justify-between items-end mb-6">
                        <h2 class="text-xl font-black uppercase tracking-widest text-gray-400">Shipping Address</h2>
                        <button @click="openAddModal()" class="text-green-500 font-bold hover:text-green-600">+ Add New Address</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($addresses as $address)
                            <div class="relative bg-white dark:bg-gray-800 p-6 rounded-3xl border-2 cursor-pointer transition-all"
                                :class="selectedAddress == {{ $address->id }} ? 'border-green-500 shadow-xl' : 'border-transparent hover:border-gray-200'"
                                @click="selectedAddress = {{ $address->id }}">
                                <input type="radio" name="address_id" value="{{ $address->id }}" x-model="selectedAddress" class="hidden">
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col h-full">
                                        <span class="font-bold text-lg mb-1">{{ $address->full_name }}</span>
                                        <span class="text-sm text-gray-500 mb-4">{{ $address->phone }}</span>
                                        <p class="text-sm text-gray-400 leading-relaxed flex-1">
                                            {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}
                                        </p>
                                        @if($address->is_default)
                                            <span class="mt-4 text-[10px] font-black uppercase tracking-widest text-green-500">Default Address</span>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        <button @click.stop="openEditModal({{ $address->id }}, '{{ $address->full_name }}', '{{ $address->phone }}', '{{ $address->address_line_1 }}', '{{ $address->city }}', '{{ $address->state }}', '{{ $address->postal_code }}')" class="p-2 text-gray-400 hover:text-green-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <div x-show="selectedAddress == {{ $address->id }}" class="absolute top-4 right-4 text-green-500">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($addresses->isEmpty())
                        <div class="bg-white dark:bg-gray-800 p-12 rounded-[2.5rem] text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                            <p class="text-gray-500 font-bold mb-6">You haven't added any shipping addresses yet.</p>
                            <button @click="openAddModal()" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-8 py-4 rounded-2xl font-bold">Add Your First Address</button>
                        </div>
                    @endif
                </section>

                <!-- Payment Method -->
                <section>
                    <h2 class="text-xl font-black uppercase tracking-widest text-gray-400 mb-6">Payment Method</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="bg-white dark:bg-gray-800 p-6 rounded-3xl border-2 cursor-pointer transition-all flex items-center gap-4"
                            :class="paymentMethod == 'COD' ? 'border-green-500 shadow-xl' : 'border-transparent hover:border-gray-200'">
                            <input type="radio" name="payment_method" value="COD" x-model="paymentMethod" class="hidden">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400" :class="paymentMethod == 'COD' ? 'text-green-500' : ''">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold">Cash on Delivery</p>
                                <p class="text-xs text-gray-400">Pay when you receive your order</p>
                            </div>
                        </label>
                        <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-3xl border-2 border-gray-200 dark:border-gray-600 flex items-center gap-4 opacity-60 cursor-not-allowed">
                            <div class="w-12 h-12 rounded-2xl bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold">Online Payment</p>
                                <p class="text-xs text-red-500 font-semibold">Coming Soon</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700 sticky top-28">
                    <h2 class="text-2xl font-black mb-8">Order Summary</h2>
                    
                    <div class="space-y-4 mb-8 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-16 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-700 flex-shrink-0">
                                    <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold line-clamp-1">{{ $item->product->name }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-black text-gray-900 dark:text-white">₹{{ number_format(($item->product->discount_price ?? $item->product->price) * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Coupon -->
                    <div class="mb-6">
                        <div class="flex gap-2">
                            <input type="text" x-model="couponCode" placeholder="Coupon Code" class="flex-1 rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-4">
                            <button @click="applyCoupon" class="bg-green-500 text-white px-6 py-3 rounded-2xl font-black text-sm hover:bg-green-600 transition-all">Apply</button>
                        </div>
                    </div>

                    <!-- Available Coupons -->
                    @if($availableCoupons->count() > 0)
                    <div class="mb-6">
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Available Coupons</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto">
                            @foreach($availableCoupons as $coupon)
                            <div @click="couponCode = '{{ $coupon->code }}'; applyCoupon()" class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl border border-green-200 dark:border-green-800 cursor-pointer hover:from-green-100 hover:to-emerald-100 dark:hover:from-green-900/30 dark:hover:to-emerald-900/30 transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-green-500 text-white flex items-center justify-center font-black text-xs">
                                        {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '₹' . number_format($coupon->value, 0) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-green-600 transition-colors">{{ $coupon->code }}</p>
                                        <p class="text-[10px] text-gray-500">
                                            @if($coupon->type === 'percentage')
                                                {{ $coupon->value }}% off
                                            @else
                                                ₹{{ number_format($coupon->value, 0) }} off
                                            @endif
                                            @if($coupon->min_order_amount > 0)
                                                • Min order ₹{{ number_format($coupon->min_order_amount, 0) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <span class="text-green-500 text-xs font-bold">Tap to apply</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-sm font-bold text-gray-500">
                            <span>Subtotal</span>
                            <span class="text-gray-900 dark:text-white">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-gray-500">
                            <span>Delivery</span>
                            <span class="text-gray-900 dark:text-white">₹{{ number_format($deliveryCharge, 2) }}</span>
                        </div>
                        <div x-show="discount > 0" class="flex justify-between text-sm font-bold text-green-500" x-cloak>
                            <span>Discount</span>
                            <span x-text="`-₹${discount.toFixed(2)}`" class="text-red-500"></span>
                        </div>
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between">
                            <span class="text-lg font-black">Total</span>
                            <span class="text-2xl font-black text-green-500" x-text="`₹${(total - discount).toFixed(2)}`"></span>
                        </div>
                    </div>

                    <button @click="processCheckout" class="w-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 py-5 rounded-2xl font-black text-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-2xl shadow-gray-200 dark:shadow-none">Place Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Address Modal -->
    <div x-show="openAddressModal" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] w-full max-w-xl p-10 shadow-2xl relative" @click.away="closeModal()">
            <h3 class="text-3xl font-black mb-8" x-text="editingAddressId ? 'Edit Address' : 'Add New Address'"></h3>
            <form id="address-form">
                <input type="hidden" id="address-id" value="">
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Full Name</label>
                        <input type="text" id="address-name" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" required>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Phone Number</label>
                        <input type="text" id="address-phone" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Full Address</label>
                        <textarea id="address-full" rows="3" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" required></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">City</label>
                        <input type="text" id="address-city" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">State</label>
                        <input type="text" id="address-state" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" required>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Pincode</label>
                        <input type="text" id="address-pincode" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" required>
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-10">
                    <button type="button" @click="closeModal()" class="px-8 py-4 text-gray-500 font-bold hover:bg-gray-50 rounded-2xl">Cancel</button>
                    <button type="button" @click="saveAddress()" class="bg-green-500 text-white px-10 py-4 rounded-2xl font-black hover:bg-green-600 transition-all shadow-xl shadow-green-500/20">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function checkoutData() {
        return {
            selectedAddress: '{{ $addresses->where('is_default', true)->first()->id ?? '' }}',
            paymentMethod: 'COD',
            couponCode: '',
            discount: 0,
            openAddressModal: false,
            editingAddressId: null,
            total: {{ $subtotal + $deliveryCharge }},
            init() {
                // Set default address if none selected
                if (!this.selectedAddress) {
                    const firstAddress = document.querySelector('input[name="address_id"]');
                    if (firstAddress) {
                        this.selectedAddress = firstAddress.value;
                    }
                }
            },
            openAddModal() {
                this.editingAddressId = null;
                document.getElementById('address-id').value = '';
                document.getElementById('address-name').value = '';
                document.getElementById('address-phone').value = '';
                document.getElementById('address-full').value = '';
                document.getElementById('address-city').value = '';
                document.getElementById('address-state').value = '';
                document.getElementById('address-pincode').value = '';
                this.openAddressModal = true;
            },
            openEditModal(id, full_name, phone, address_line_1, city, state, postal_code) {
                this.editingAddressId = id;
                document.getElementById('address-id').value = id;
                document.getElementById('address-name').value = full_name;
                document.getElementById('address-phone').value = phone;
                document.getElementById('address-full').value = address_line_1;
                document.getElementById('address-city').value = city;
                document.getElementById('address-state').value = state;
                document.getElementById('address-pincode').value = postal_code;
                this.openAddressModal = true;
            },
            closeModal() {
                this.openAddressModal = false;
                this.editingAddressId = null;
            },
            saveAddress() {
                const id = document.getElementById('address-id').value;
                const full_name = document.getElementById('address-name').value;
                const phone = document.getElementById('address-phone').value;
                const address_line_1 = document.getElementById('address-full').value;
                const city = document.getElementById('address-city').value;
                const state = document.getElementById('address-state').value;
                const postal_code = document.getElementById('address-pincode').value;

                if (!full_name || !phone || !address_line_1 || !city || !state || !postal_code) {
                    Swal.fire('Error', 'Please fill all fields', 'error');
                    return;
                }

                const url = id ? '/addresses/' + id : '/api/addresses';
                const method = id ? 'PUT' : 'POST';

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ full_name, phone, address_line_1, city, state, postal_code })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        Swal.fire('Error', data.message || 'Failed to save address', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to save address', 'error');
                });
            },
            applyCoupon() {
                if (!this.couponCode) return;
                fetch(`{{ route('checkout.apply-coupon') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ code: this.couponCode })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.discount = data.discount;
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
            },
            processCheckout() {
                if (!this.selectedAddress) {
                    Swal.fire('Error', 'Please select a shipping address', 'error');
                    return;
                }

                fetch(`{{ route('checkout.process') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        address_id: this.selectedAddress,
                        payment_method: this.paymentMethod,
                        coupon_code: this.couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Placed!',
                            text: 'Redirecting to your order details...',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = data.redirect;
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
            }
        }
    }
</script>
@endpush
