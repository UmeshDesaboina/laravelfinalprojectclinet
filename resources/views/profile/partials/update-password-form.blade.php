<section>
    <header class="mb-8">
        <h2 class="text-xl font-black text-dark-800 dark:text-white">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-dark-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="input-field" autocomplete="current-password">
            @error('current_password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">New Password</label>
            <input id="update_password_password" name="password" type="password" class="input-field" autocomplete="new-password">
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="input-field" autocomplete="new-password">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn-primary">Save Changes</button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-500 font-medium">Saved successfully!</p>
            @endif
        </div>
    </form>
</section>
