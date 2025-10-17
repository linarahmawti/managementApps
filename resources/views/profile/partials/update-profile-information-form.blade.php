<section>
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
            <i class="fas fa-user mr-2 text-blue-500"></i>
            {{ __('Profile Information') }}
        </h3>
        <p class="text-sm text-gray-600 mt-1">{{ __("Update your account's profile information and email address.") }}</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-gray-700" />
                <x-text-input id="name" name="name" type="text"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    :value="old('name', $user->name)" required autofocus />
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                <x-text-input id="email" name="email" type="email"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    :value="old('email', $user->email)" required />
                <x-input-error class="mt-1" :messages="$errors->get('email')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                    <p class="text-sm text-yellow-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-yellow-600 hover:text-yellow-800 ml-1">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                </div>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-green-600">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-3 pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600 flex items-center">
                    <i class="fas fa-check-circle mr-1"></i>
                    {{ __('Saved successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>
