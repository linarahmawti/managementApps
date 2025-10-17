@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('karyawan.reports.index') }}"
               class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Progress Report</h1>
        </div>

        <!-- Assignment Information -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Assignment Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Related Assignment</label>
                    @if($report->assignment)
                        <p class="text-gray-900">{{ $report->assignment->judul_assignment }}</p>
                    @else
                        <p class="text-gray-500 italic">Self Report (No Assignment)</p>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Karyawan</label>
                    <p class="text-gray-900">{{ $report->karyawan->name }}</p>
                </div>
            </div>
        </div>

        <!-- Delivery Details -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Delivery Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                    <p class="text-gray-900">{{ $report->nama_barang }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Pengantaran</label>
                    <p class="text-gray-900">{{ $report->lokasi_pengantaran }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Diantar</label>
                    <p class="text-gray-900">{{ number_format($report->jumlah_diantar) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Total</label>
                    <p class="text-gray-900">Rp {{ number_format($report->harga_total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Status & Notes -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status & Notes</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Pengantaran</label>
                    @php
                        $statusClasses = [
                            'belum_dikirim' => 'bg-red-100 text-red-800',
                            'dalam_perjalanan' => 'bg-yellow-100 text-yellow-800',
                            'selesai' => 'bg-green-100 text-green-800'
                        ];
                        $statusLabels = [
                            'belum_dikirim' => 'Belum Dikirim',
                            'dalam_perjalanan' => 'Dalam Perjalanan',
                            'selesai' => 'Selesai'
                        ];
                        $statusClass = $statusClasses[$report->status_pengantaran] ?? 'bg-gray-100 text-gray-800';
                        $statusLabel = $statusLabels[$report->status_pengantaran] ?? ucfirst(str_replace('_', ' ', $report->status_pengantaran));
                    @endphp
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Laporan</label>
                    <p class="text-gray-900">{{ $report->tanggal_laporan->format('d/m/Y H:i') }}</p>
                </div>
                @if($report->catatan)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <p class="text-gray-900 bg-white p-3 rounded border">{{ $report->catatan }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('karyawan.reports.index') }}"
               class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                Back to List
            </a>
            <a href="{{ route('karyawan.reports.edit', $report) }}"
               class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Edit Report
            </a>
        </div>
    </div>
</div>
@endsection
