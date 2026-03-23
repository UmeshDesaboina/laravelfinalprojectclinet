@extends('layouts.admin')

@section('title', 'Return Request Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.returns.index') }}" class="text-sm text-green-500 hover:text-green-600">← Back to Returns</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        <!-- Return Request Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Return Request</h4>
                        <p class="text-sm text-gray-500">Request #{{ $return->request_number }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $return->status_badge_class }}">
                        {{ ucfirst($return->status) }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Reason</p>
                        <p class="font-bold text-gray-800 dark:text-white">{{ ucfirst(str_replace('_', ' ', $return->reason)) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Refund Amount</p>
                        <p class="font-bold text-gray-800 dark:text-white">₹{{ number_format($return->refund_amount ?? 0, 2) }}</p>
                    </div>
                    @if($return->reason_description)
                    <div class="col-span-2">
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Description</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $return->reason_description }}</p>
                    </div>
                    @endif
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Requested On</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $return->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @if($return->processed_at)
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Processed On</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $return->processed_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif
                    @if($return->refunded_at)
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Refunded On</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $return->refunded_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Return Tracking -->
        @if($return->courier_name && $return->tracking_id)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-blue-200 dark:border-blue-800 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h4 class="text-lg font-bold text-gray-800 dark:text-white">Pickup Tracking</h4>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500">Courier: {{ $return->courier_name }}</p>
                        <p class="text-xl font-black text-blue-600">Tracking ID: {{ $return->tracking_id }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Order Details -->
        @if($return->order)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-bold text-gray-800 dark:text-white">Original Order</h4>
                    <a href="{{ route('admin.orders.show', $return->order) }}" class="text-blue-500 hover:text-blue-700 text-sm font-semibold">View Order →</a>
                </div>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Order #{{ $return->order->order_number }} | Total: ₹{{ number_format($return->order->total, 2) }}</p>
                <div class="space-y-4">
                    @foreach($return->order->items as $item)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <img src="{{ $item->product && $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : 'https://via.placeholder.com/100' }}" class="w-16 h-16 rounded-lg object-cover">
                        <div class="flex-1">
                            <p class="font-bold text-gray-800 dark:text-white">{{ $item->product ? $item->product->name : 'Product Deleted' }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                        </div>
                        <p class="font-bold text-gray-800 dark:text-white">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <!-- Update Status -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Update Status</h4>
            <form id="status-form">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select id="return-status" onchange="toggleTrackingFields()" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm">
                        <option value="requested" {{ $return->status == 'requested' ? 'selected' : '' }}>Requested</option>
                        <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="picked" {{ $return->status == 'picked' ? 'selected' : '' }}>Picked</option>
                        <option value="received" {{ $return->status == 'received' ? 'selected' : '' }}>Received</option>
                        <option value="refunded" {{ $return->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                
                <div id="tracking-fields" class="space-y-4 {{ in_array($return->status, ['approved', 'picked']) ? '' : 'hidden' }}">
                    <div>
                        <label class="block text-sm font-medium mb-2">Courier Name</label>
                        <input type="text" id="courier_name" value="{{ $return->courier_name }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" placeholder="e.g., Delhivery">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Tracking ID</label>
                        <input type="text" id="tracking_id" value="{{ $return->tracking_id }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-sm" placeholder="Enter tracking number">
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-colors">Update Status</button>
            </form>
        </div>

        <!-- Bank Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Bank Details for Refund</h4>
            @if($return->bank_account_number)
            <div class="space-y-3">
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Account Holder</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $return->bank_account_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">Account Number</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $return->bank_account_number }}</p>
                </div>
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-gray-400">IFSC Code</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $return->bank_ifsc }}</p>
                </div>
            </div>
            @else
            <p class="text-gray-500 text-sm">No bank details provided</p>
            @endif
        </div>

        <!-- Customer Info -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <h4 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Customer Info</h4>
            @if($return->user)
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ $return->user->name }}" class="w-10 h-10 rounded-full" alt="">
                <div>
                    <p class="font-medium">{{ $return->user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $return->user->email }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleTrackingFields() {
        const status = document.getElementById('return-status').value;
        const trackingFields = document.getElementById('tracking-fields');
        if (status === 'approved' || status === 'picked') {
            trackingFields.classList.remove('hidden');
        } else {
            trackingFields.classList.add('hidden');
        }
    }

    document.getElementById('status-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const status = document.getElementById('return-status').value;
        let data = { status: status };
        
        if (status === 'approved' || status === 'picked') {
            data.courier_name = document.getElementById('courier_name').value;
            data.tracking_id = document.getElementById('tracking_id').value;
            if (!data.courier_name || !data.tracking_id) {
                alert('Please enter courier name and tracking ID');
                return;
            }
        }
        
        fetch(`/admin/returns/update-status/{{ $return->id }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
</script>
@endpush
