@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('karyawan.reports.index') }}"
               class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Create Progress Report</h1>
        </div>

        <form action="{{ route('karyawan.reports.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Assignment Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Assignment Information</h3>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="assignment_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Related Assignment (Optional)
                        </label>
                        <select name="assignment_id" id="assignment_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Self Report (No Assignment)</option>
                            @foreach($assignments as $assignment)
                                <option value="{{ $assignment->id }}" {{ old('assignment_id') == $assignment->id ? 'selected' : '' }}>
                                    {{ $assignment->judul_assignment }}
                                </option>
                            @endforeach
                        </select>
                        @error('assignment_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Delivery Details -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Delivery Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Barang *
                        </label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('nama_barang')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lokasi_pengantaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Pengantaran *
                        </label>
                        <input type="text" name="lokasi_pengantaran" id="lokasi_pengantaran" value="{{ old('lokasi_pengantaran') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('lokasi_pengantaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah_diantar" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Diantar *
                        </label>
                        <input type="number" name="jumlah_diantar" id="jumlah_diantar" value="{{ old('jumlah_diantar') }}"
                               min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('jumlah_diantar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_total" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Total *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="harga_total" id="harga_total" value="{{ old('harga_total') }}"
                                   min="0" step="0.01" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        @error('harga_total')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status & Notes -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status & Notes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status_pengantaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Pengantaran *
                        </label>
                        <select name="status_pengantaran" id="status_pengantaran"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="belum_dikirim" {{ old('status_pengantaran') == 'belum_dikirim' ? 'selected' : '' }}>
                                Belum Dikirim
                            </option>
                            <option value="dalam_perjalanan" {{ old('status_pengantaran') == 'dalam_perjalanan' ? 'selected' : '' }}>
                                Dalam Perjalanan
                            </option>
                            <option value="selesai" {{ old('status_pengantaran') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                        @error('status_pengantaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_laporan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Laporan *
                        </label>
                        <input type="datetime-local" name="tanggal_laporan" id="tanggal_laporan"
                               value="{{ old('tanggal_laporan', now()->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('tanggal_laporan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="catatan" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('karyawan.reports.index') }}"
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Create Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
