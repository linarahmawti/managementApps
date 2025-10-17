<section>
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-lock mr-2 text-green-500"></i>
            {{ __('Update Password') }}
        </h3>
        <p class="text-sm text-gray-600 mt-1">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-medium text-gray-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" 
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" 
                placeholder="Enter your current password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-medium text-gray-700" />
                <x-text-input id="update_password_password" name="password" type="password" 
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" 
                    placeholder="Enter new password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-gray-700" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500" 
                    placeholder="Confirm new password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-key mr-2"></i>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ __('Password updated!') }}
                </p>
            @endif
        </div>
    </form>
</section>