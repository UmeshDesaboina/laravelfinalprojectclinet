@extends('layouts.admin')

@section('title', 'Return Management')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
        <h4 class="text-lg font-bold text-gray-800 dark:text-white">Return Requests</h4>
        <a href="{{ route('admin.dashboard') }}" class="text-sm text-green-500 hover:text-green-600">← Back to Dashboard</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-sm font-medium text-gray-500 dark:text-gray-400 border-b border-gray-100 dark:border-gray-700">
                    <th class="py-4 px-6">Request ID</th>
                    <th class="py-4 px-6">Order ID</th>
                    <th class="py-4 px-6">Customer</th>
                    <th class="py-4 px-6">Reason</th>
                    <th class="py-4 px-6">Refund Amount</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($returns as $return)
                    <tr class="text-sm text-gray-700 dark:text-gray-300">
                        <td class="py-4 px-6 font-medium text-gray-800 dark:text-white">{{ $return->request_number }}</td>
                        <td class="py-4 px-6">{{ $return->order ? $return->order->order_number : 'N/A' }}</td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span>{{ $return->user ? $return->user->name : 'N/A' }}</span>
                                <span class="text-xs text-gray-500">{{ $return->user ? $return->user->email : '' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 max-w-xs truncate">{{ ucfirst(str_replace('_', ' ', $return->reason)) }}</td>
                        <td class="py-4 px-6">₹{{ number_format($return->refund_amount ?? 0, 2) }}</td>
                        <td class="py-4 px-6">
                            <select onchange="updateReturnStatus({{ $return->id }}, this.value)" 
                                class="text-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                <option value="requested" {{ $return->status == 'requested' ? 'selected' : '' }}>Requested</option>
                                <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="picked" {{ $return->status == 'picked' ? 'selected' : '' }}>Picked</option>
                                <option value="received" {{ $return->status == 'received' ? 'selected' : '' }}>Received</option>
                                <option value="refunded" {{ $return->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('admin.returns.show', $return) }}" class="text-blue-500 hover:text-blue-700 font-semibold">View</a>
                            @if($return->order)
                                <a href="{{ route('admin.orders.show', $return->order_id) }}" class="text-green-500 hover:text-green-700 font-semibold">Order</a>
                            @endif
                            <form action="{{ route('admin.returns.destroy', $return) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">No return requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-6">
        {{ $returns->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateReturnStatus(id, status) {
        let data = { status: status };
        
        if (status === 'approved' || status === 'picked') {
            const courierName = prompt('Enter Courier Name for pickup:');
            const trackingId = prompt('Enter Tracking ID:');
            if (!courierName || !trackingId) {
                location.reload();
                return;
            }
            data.courier_name = courierName;
            data.tracking_id = trackingId;
        }
        
        fetch(`/admin/returns/update-status/${id}`, {
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
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message || 'Return status updated',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Error updating status',
                showConfirmButton: false,
                timer: 2000
            });
            location.reload();
        });
    }
</script>
@endpush
