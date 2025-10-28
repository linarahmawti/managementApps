<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Today's Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-calendar-day mr-2 text-blue-600"></i>
                        Statistik Hari Ini
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <i class="fas fa-truck text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-600">Total Pengantaran</h4>
                                    <p class="text-3xl font-bold text-blue-600">{{ $this->todayStats['total_deliveries'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-6 rounded-lg border-l-4 border-green-500">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-600">Pendapatan</h4>
                                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($this->todayStats['total_revenue'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-6 rounded-lg border-l-4 border-yellow-500">
                            <div class="flex items-center">
                                <div class="p-3 bg-yellow-100 rounded-lg">
                                    <i class="fas fa-boxes text-yellow-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-600">Total Penjualan (pcs)</h4>
                                    <p class="text-3xl font-bold text-yellow-600">{{ number_format($this->todayStats['delivered_items']) }} <span class="text-xl font-medium text-yellow-600">pcs</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-lg border-l-4 border-purple-500">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <i class="fas fa-map-marker-alt text-purple-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-600">Lokasi Terlayani</h4>
                                    <p class="text-3xl font-bold text-purple-600">{{ $this->todayStats['unique_locations'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-indigo-600"></i>
                        Statistik Bulan Ini
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-200">
                            <div class="text-center">
                                <i class="fas fa-shipping-fast text-indigo-600 text-3xl mb-2"></i>
                                <h4 class="text-lg font-semibold text-gray-800">{{ $this->monthlyStats['total_deliveries'] }}</h4>
                                <p class="text-sm text-gray-600">Total Pengantaran</p>
                            </div>
                        </div>

                        <div class="bg-emerald-50 p-6 rounded-lg border border-emerald-200">
                            <div class="text-center">
                                <i class="fas fa-coins text-emerald-600 text-3xl mb-2"></i>
                                <h4 class="text-lg font-semibold text-gray-800">Rp {{ number_format($this->monthlyStats['total_revenue'], 0, ',', '.') }}</h4>
                                <p class="text-sm text-gray-600">Total Pendapatan</p>
                            </div>
                        </div>

                        <div class="bg-orange-50 p-6 rounded-lg border border-orange-200">
                            <div class="text-center">
                                <i class="fas fa-cubes text-orange-600 text-3xl mb-2"></i>
                                <h4 class="text-lg font-semibold text-gray-800">{{ number_format($this->monthlyStats['delivered_items']) }} <span class="text-sm text-gray-600">pcs</span></h4>
                                <p class="text-sm text-gray-600">Total Penjualan (pcs)</p>
                            </div>
                        </div>

                        <div class="bg-pink-50 p-6 rounded-lg border border-pink-200">
                            <div class="text-center">
                                <i class="fas fa-globe text-pink-600 text-3xl mb-2"></i>
                                <h4 class="text-lg font-semibold text-gray-800">{{ $this->monthlyStats['unique_locations'] }}</h4>
                                <p class="text-sm text-gray-600">Lokasi Terlayani</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-chart-line mr-2 text-green-600"></i>
                        Trend Pendapatan 7 Hari Terakhir
                    </h3>
                    <div class="h-64 flex items-end justify-between space-x-2">
                        @foreach($this->chartData as $data)
                            <div class="flex flex-col items-center flex-1">
                                <div class="bg-green-500 rounded-t w-full relative"
                                     style="height: {{ $data['revenue'] > 0 ? (($data['revenue'] / max(array_column($chartData, 'revenue'))) * 200) : 5 }}px;">
                                    <div class="text-xs text-white p-1 text-center">
                                        {{ $data['revenue'] > 0 ? 'Rp ' . number_format($data['revenue']/1000, 0) . 'k' : '0' }}
                                    </div>
                                </div>
                                <div class="text-xs text-gray-600 mt-2">{{ $data['date'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Employees & Recent Reports -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Performing Employees -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-trophy mr-2 text-yellow-600"></i>
                            Karyawan Terbaik Bulan Ini
                        </h3>
                        <div class="space-y-4">
                            @forelse($this->topEmployees as $index => $employee)
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-semibold text-gray-800">{{ $employee->karyawan->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $employee->total_reports }} pengantaran</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-green-600">Rp {{ number_format($employee->total_revenue, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada data karyawan</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <i class="fas fa-clock mr-2 text-blue-600"></i>
                            Laporan Terbaru
                        </h3>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($this->recentReports as $report)
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-800 text-sm">{{ $report->nama_barang }}</h4>
                                        <p class="text-xs text-gray-600">{{ $report->karyawan->name }} • {{ $report->lokasi_pengantaran }}</p>
                                        <p class="text-xs text-gray-500">{{ $report->tanggal_laporan->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($report->status_pengantaran === 'delivered') bg-green-100 text-green-800
                                            @elseif($report->status_pengantaran === 'on_delivery') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $report->status_pengantaran)) }}
                                        </span>
                                        <p class="text-xs text-gray-600 mt-1">{{ number_format($report->jumlah_diantar) }} unit</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">Belum ada laporan</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                        Quick Actions
                    </h3>
                    <div class="flex space-x-4">
                        <a href="/admin/assignments" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Assignment Baru
                        </a>
                        <a href="/admin/progress-reports" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-file-alt mr-2"></i>
                            Lihat Semua Laporan
                        </a>
                        <a href="/admin/barangs" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-boxes mr-2"></i>
                            Kelola Barang
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Font Awesome CDN -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</x-app-layout>
