@extends('layouts.app')

@section('content')
<div class="py-24 bg-dark-50 dark:bg-dark-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-green-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-black text-dark-800 dark:text-white">My Addresses</h1>
                    <p class="text-dark-500 mt-1">Manage your shipping addresses</p>
                </div>
            </div>
            <button onclick="openAddressModal()" class="btn-primary !py-3 !px-6">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add New Address
                </span>
            </button>
        </div>

        @if($addresses->isEmpty())
            <div class="card-flat p-20 text-center">
                <div class="w-24 h-24 rounded-full bg-dark-100 dark:bg-dark-800 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-dark-800 dark:text-white mb-4">No addresses saved</h2>
                <p class="text-dark-500 mb-8">Add a shipping address to make checkout faster.</p>
                <button onclick="openAddressModal()" class="btn-primary !py-4 !px-8 rounded-full inline-flex items-center gap-2">
                    <span>Add Your First Address</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($addresses as $address)
                    <div class="card-flat p-8 relative group hover:border-primary-500 transition-all">
                        @if($address->is_default)
                            <span class="absolute top-4 right-4 text-[10px] font-black uppercase tracking-widest text-primary-500 bg-primary-50 px-3 py-1 rounded-full">Default</span>
                        @endif
                        <div class="flex flex-col h-full">
                            <span class="font-bold text-xl mb-1 text-dark-800 dark:text-white">{{ $address->full_name }}</span>
                            <span class="text-sm text-dark-500 mb-4">{{ $address->phone }}</span>
                            <p class="text-sm text-dark-400 leading-relaxed flex-1">
                                {{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                            </p>
                        </div>
                        <div class="flex items-center gap-4 mt-6 pt-6 border-t border-dark-100 dark:border-dark-700">
                            @if(!$address->is_default)
                                <form action="{{ route('addresses.set-default', $address) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold text-primary-500 hover:text-primary-600">Set as Default</button>
                                </form>
                            @endif
                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="ml-auto">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-600" onclick="return confirm('Delete this address?')">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Address Modal -->
    <div id="address-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 hidden" x-data="{ open: false }" x-show="open" x-transition>
        <div class="bg-white dark:bg-dark-800 rounded-[2.5rem] w-full max-w-xl p-10 shadow-2xl relative">
            <button onclick="closeAddressModal()" class="absolute top-6 right-6 text-dark-400 hover:text-dark-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-3xl font-black mb-8 text-dark-800 dark:text-white">Add New Address</h3>
            <form action="{{ route('addresses.store') }}" method="POST" id="address-form">
                @csrf
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Full Name</label>
                        <input type="text" name="full_name" required class="input-field">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Phone Number</label>
                        <input type="text" name="phone" required class="input-field">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Full Address</label>
                        <textarea name="address" rows="3" required class="input-field"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">City</label>
                        <input type="text" name="city" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">State</label>
                        <input type="text" name="state" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Pincode</label>
                        <input type="text" name="pincode" required class="input-field">
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-10">
                    <button type="button" onclick="closeAddressModal()" class="btn-secondary !py-3 !px-6">Cancel</button>
                    <button type="submit" class="btn-primary !py-3 !px-6">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openAddressModal() {
        const modal = document.getElementById('address-modal');
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    }
    
    function closeAddressModal() {
        const modal = document.getElementById('address-modal');
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }
</script>
@endpush
