@extends('layouts.app')

@section('content')
<div class="py-24 bg-dark-50 dark:bg-dark-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-4 mb-12">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-red-500/30">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </div>
            <div>
                <h1 class="text-4xl font-black text-dark-800 dark:text-white">My Wishlist</h1>
                <p class="text-dark-500 mt-1">{{ $wishlistItems->count() }} {{ $wishlistItems->count() === 1 ? 'item' : 'items' }} saved</p>
            </div>
        </div>

        @if($wishlistItems->isEmpty())
            <div class="card-flat p-20 text-center">
                <div class="w-24 h-24 rounded-full bg-dark-100 dark:bg-dark-800 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-dark-800 dark:text-white mb-4">Your wishlist is empty</h2>
                <p class="text-dark-500 mb-8">Save items you love to your wishlist and they'll appear here.</p>
                <a href="{{ route('shop') }}" class="btn-primary !py-4 !px-8 rounded-full inline-flex items-center gap-2">
                    <span>Explore Products</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($wishlistItems as $item)
                    @include('components.product-card', ['product' => $item->product])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
