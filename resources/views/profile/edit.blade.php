<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="bg-white shadow rounded-lg overflow-hidden">

                <!-- Content -->
                <div class="p-6 space-y-8">
                    @include('profile.partials.update-profile-information-form')

                    <hr class="border-gray-200">

                    @include('profile.partials.update-password-form')

                    <hr class="border-gray-200">

                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
