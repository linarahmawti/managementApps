<section>
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-red-600 flex items-center">
            <i class="fas fa-trash mr-2"></i>
            {{ __('Delete Account') }}
        </h3>
        <p class="text-sm text-gray-600 mt-1">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </div>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Are you sure?') }}</h2>
                    <p class="text-sm text-gray-600">{{ __('This action cannot be undone.') }}</p>
                </div>
            </div>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="mb-4">
                    <x-input-label for="password" value="{{ __('Confirm with your password') }}" class="text-sm font-medium text-gray-700" />
                    <x-text-input id="password" name="password" type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="Enter your password to confirm" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400 transition-colors">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
