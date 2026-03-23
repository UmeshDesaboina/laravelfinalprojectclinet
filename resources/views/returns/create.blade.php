@extends('layouts.app')

@section('content')
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('orders.show', $order) }}" class="text-xs font-black uppercase tracking-widest text-green-500 mb-4 inline-block hover:text-green-600">← Back to Order</a>
        
        <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-xl">
            <h1 class="text-3xl font-black mb-2">Request Return</h1>
            <p class="text-gray-500 mb-8">Order #{{ $order->order_number }}</p>

            <form action="{{ route('orders.return', $order) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Reason for Return *</label>
                        <select name="reason" required class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                            <option value="">Select a reason</option>
                            <option value="defective">Defective/Damaged</option>
                            <option value="wrong_item">Wrong Item Received</option>
                            <option value="not_as_described">Not as Described</option>
                            <option value="damaged_in_transit">Damaged in Transit</option>
                            <option value="changed_mind">Changed Mind</option>
                            <option value="other">Other</option>
                        </select>
                        @error('reason')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Description (Optional)</label>
                        <textarea name="reason_description" rows="4" class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" placeholder="Please describe the issue...">{{ old('reason_description') }}</textarea>
                    </div>

                    <div class="border-t dark:border-gray-700 pt-6">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4">Bank Details for Refund</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Account Holder Name *</label>
                                <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}" required class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                                @error('bank_account_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Bank Account Number *</label>
                                <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}" required class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4">
                                @error('bank_account_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">IFSC Code *</label>
                                <input type="text" name="bank_ifsc" value="{{ old('bank_ifsc') }}" required class="w-full rounded-2xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4" placeholder="e.g., SBIN0001234">
                                @error('bank_ifsc')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-10">
                    <a href="{{ route('orders.show', $order) }}" class="px-8 py-4 text-gray-500 font-bold hover:bg-gray-50 dark:hover:bg-gray-700 rounded-2xl">Cancel</a>
                    <button type="submit" class="bg-orange-500 text-white px-10 py-4 rounded-2xl font-black hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20">Submit Return</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
