@extends('components.guest-layout')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-[2rem] p-8 shadow-xl border border-gray-100 dark:border-gray-700">
    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
            <input id="email" name="email" type="email" class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4 focus:ring-2 focus:ring-green-500" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <button type="submit" class="w-full bg-green-500 text-white py-4 rounded-xl font-black text-lg hover:bg-green-600 transition-all shadow-xl">
            {{ __('Email Password Reset Link') }}
        </button>
    </form>
</div>
@endsection
