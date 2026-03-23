<section>
    <header class="mb-8">
        <h2 class="text-xl font-black text-dark-800 dark:text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-dark-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Name</label>
            <input id="name" name="name" type="text" class="input-field" :value="old('name', $user->name)" required autofocus autocomplete="name">
            @error('name')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Email</label>
            <input id="email" name="email" type="email" class="input-field" :value="old('email', $user->email)" required autocomplete="username">
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                    <p class="text-sm text-yellow-700 dark:text-yellow-400">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline font-medium text-yellow-600 hover:text-yellow-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">Save Changes</button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-500 font-medium">Saved successfully!</p>
            @endif
        </div>
    </form>
</section>
