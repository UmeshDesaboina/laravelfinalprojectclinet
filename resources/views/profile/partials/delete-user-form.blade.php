<section class="space-y-6">
    <header class="mb-8">
        <h2 class="text-xl font-black text-dark-800 dark:text-white">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm text-dark-500">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 rounded-xl font-bold bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all"
    >{{ __('Delete Account') }}</button>

    <div x-data="{ show: @entangle('errors.userDeletion.isNotEmpty') }">
        <div x-show="$dispatch('open-modal', 'confirm-user-deletion')" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div class="bg-white dark:bg-dark-800 rounded-2xl p-8 max-w-md w-full shadow-2xl" @click.away="$dispatch('close')">
                <h2 class="text-xl font-black text-dark-800 dark:text-white mb-4">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-dark-500 mb-6">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}
                </p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-6">
                        <label for="password" class="block text-xs font-black uppercase tracking-widest text-dark-400 mb-2">Password</label>
                        <input id="password" name="password" type="password" class="input-field" placeholder="Enter your password">
                        @error('password', 'userDeletion')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="button" @click="$dispatch('close')" class="btn-secondary !py-3 !px-6">Cancel</button>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold bg-red-500 text-white hover:bg-red-600 transition-all">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
