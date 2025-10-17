<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-6 ">
            <!-- Success Alert -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm  rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat datang, {{ Auth::user()->name }}!
                            </h3>
                            <p class="text-gray-600">Silakan laporkan progress pengantaran barang Anda.</p>
                        </div>
                        <div class="text-6xl">
                            🚛
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-500 overflow-hidden shadow-lg rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Input Laporan Pengantaran</h3>
                                <p class="text-white mb-4">Laporkan barang yang telah Anda antarkan hari ini</p>
                                <a href="{{ route('karyawan.input-progress') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-blue-500 font-semibold rounded-lg hover:bg-blue-50 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Buat Laporan Baru
                                </a>
                            </div>
                            <div class="text-6xl">
                                📋
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-500 overflow-hidden shadow-lg rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">Kelola Laporan Saya</h3>
                                <p class="mb-4 text-white">Lihat, edit, dan kelola semua laporan pengantaran Anda</p>
                                <a href="{{ route('karyawan.reports.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white text-blue-500 font-semibold rounded-lg hover:bg-blue-50 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Lihat Semua Laporan
                                </a>
                            </div>
                            <div class="text-6xl">
                                📊
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white overflow-hidden shadow-sm   rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <i class="fas fa-tasks text-orange-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-600">Tugas Aktif</h4>
                                <p class="text-2xl font-bold text-orange-600">{{ $assignments->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm   rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-lg">
                                <i class="fas fa-clipboard-check text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-600">Total Laporan</h4>
                                <p class="text-2xl font-bold text-green-600">{{ $stats['total_reports'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm   rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-600">Laporan Hari Ini</h4>
                                <p class="text-2xl font-bold text-blue-600">{{ $stats['today_reports'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm   rounded-lg border border-gray-100 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center">
                            <div class="p-3 bg-emerald-100 rounded-lg">
                                <i class="fas fa-truck text-emerald-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-600">Berhasil Diantar</h4>
                                <p class="text-2xl font-bold text-emerald-600">{{ $stats['delivered_reports'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments from Admin -->
            @if ($assignments->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm  rounded-lg border border-gray-100">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-tasks mr-3 text-blue-600"></i>
                            Tugas Pengantaran dari Admin
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($assignments as $assignment)
                                <div
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200 bg-gradient-to-br from-gray-50 to-white">
                                    <!-- Header -->
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 truncate">
                                                {{ $assignment->barang->nama_barang }}</h4>
                                            <p class="text-xs text-gray-500">{{ $assignment->barang->kode_barang }}</p>
                                        </div>
                                        @php
                                            $statusClasses = match ($assignment->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                default => 'bg-green-100 text-green-800',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses }} ml-2">
                                            {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                                        </span>
                                    </div>

                                    <!-- Info Grid dengan Icons -->
                                    <div class="space-y-2 mb-3">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                            <span
                                                class="text-gray-700 truncate">{{ $assignment->lokasi_tujuan }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-boxes w-4 text-orange-500 mr-2"></i>
                                            <span class="text-gray-700">{{ $assignment->jumlah }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-calendar w-4 text-blue-500 mr-2"></i>
                                            <span
                                                class="text-gray-700">{{ $assignment->tanggal_assignment->format('d M Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Catatan (jika ada) -->
                                    @if ($assignment->catatan)
                                        <div class="mb-3 p-2 bg-amber-50 border border-amber-200 rounded text-xs">
                                            <i class="fas fa-sticky-note text-amber-600 mr-1"></i>
                                            <span
                                                class="text-gray-700">{{ Str::limit($assignment->catatan, 50) }}</span>
                                        </div>
                                    @endif

                                    <!-- Action Button -->
                                    <div class="pt-3 border-t border-gray-100">
                                        <a href="{{ route('karyawan.input-progress') }}?assignment_id={{ $assignment->id }}"
                                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors duration-200">
                                            <i class="fas fa-plus mr-2"></i>Buat Laporan
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Reports -->
            @if ($recentReports->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm  rounded-lg border border-gray-100">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-history mr-3 text-purple-600"></i>
                            Laporan Terbaru
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($recentReports as $report)
                                <div
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200 bg-gradient-to-br from-white to-gray-50">
                                    <!-- Header -->
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-800 truncate">
                                                {{ $report->nama_barang }}</h4>
                                            <p class="text-xs text-gray-500">
                                                {{ $report->tanggal_laporan->format('d M Y') }}</p>
                                        </div>
                                        @php
                                            $statusClasses = match ($report->status_pengantaran) {
                                                'delivered', 'selesai' => 'bg-green-100 text-green-800',
                                                'on_delivery', 'dalam_perjalanan' => 'bg-blue-100 text-blue-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-red-100 text-red-800',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses }} ml-2">
                                            @if (in_array($report->status_pengantaran, ['delivered', 'selesai']))
                                                ✅ Selesai
                                            @elseif(in_array($report->status_pengantaran, ['on_delivery', 'dalam_perjalanan']))
                                                🚛 Dalam Proses
                                            @elseif($report->status_pengantaran === 'pending')
                                                ⏳ Menunggu
                                            @else
                                                ❌ Gagal
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Info dengan Icons -->
                                    <div class="space-y-2 mb-3">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                            <span
                                                class="text-gray-700 truncate">{{ $report->lokasi_pengantaran }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-boxes w-4 text-orange-500 mr-2"></i>
                                            <span class="text-gray-700">{{ number_format($report->jumlah_diantar) }}
                                                pcs</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-clock w-4 text-blue-500 mr-2"></i>
                                            <span
                                                class="text-gray-700">{{ $report->tanggal_laporan->format('H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar (jika status dalam perjalanan) -->
                                    @if (in_array($report->status_pengantaran, ['on_delivery', 'dalam_perjalanan']))
                                        <div class="mb-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Dalam proses pengantaran...</p>
                                        </div>
                                    @endif

                                    <!-- Action/Detail Button -->
                                    <div class="pt-3 border-t border-gray-100">
                                        <button
                                            class="w-full inline-flex items-center justify-center px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Show More Button -->
                        <div class="mt-4 text-center">
                            <a href="{{ route('karyawan.reports.index') }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-purple-600 hover:text-purple-800 transition-colors duration-200">
                                <i class="fas fa-arrow-right mr-2"></i>
                                Lihat Semua Laporan
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
