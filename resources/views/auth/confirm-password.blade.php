@extends('components.guest-layout')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-[2rem] p-8 shadow-xl border border-gray-100 dark:border-gray-700">
    <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white text-center mb-6">Confirm Password</h2>
    
    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Password</label>
            <input id="password" name="password" type="password" class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4 focus:ring-2 focus:ring-green-500" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <button type="submit" class="w-full bg-green-500 text-white py-4 rounded-xl font-black text-lg hover:bg-green-600 transition-all shadow-xl">
            {{ __('Confirm') }}
        </button>
    </form>
</div>
@endsection
