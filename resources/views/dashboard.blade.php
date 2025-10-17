<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Auth::user()->role === 'admin')
                {{ __('Admin Dashboard') }}
            @else
                {{ __('Karyawan Dashboard') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->role === 'admin')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="mb-4">Selamat datang, Admin!</p>
                        <div class="space-y-4">
                            <a href="/admin" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-cogs mr-2"></i>
                                Panel Admin Filament
                            </a>
                            <a href="{{ route('admin.analytics') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 ml-2">
                                <i class="fas fa-chart-bar mr-2"></i>
                                Analytics Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="mb-4">Selamat datang, {{ Auth::user()->name }}!</p>
                        <a href="{{ route('karyawan.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-truck mr-2"></i>
                            Dashboard Pengantaran
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
