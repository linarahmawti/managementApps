<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 space-y-6">

            <!-- Success Alert -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Main Form -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                <div class="p-6">
                    <div class="mb-6">
                        <span class="flex items-center text-2xl mb-2">
                            <i class="fas fa-clipboard-list mr-3 text-blue-600"></i>
                            <h3 class="text-2xl font-semibold text-gray-800 ">Formulir Laporan Pengantaran</h3>
                        </span>
                        <p class="text-sm text-gray-600">Isi data pengantaran barang yang telah Anda lakukan</p>
                    </div>

                    <form action="{{ route('karyawan.progress.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Assignment Select -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-tasks mr-1 text-blue-500"></i>Pilih Assignment
                                </label>
                                <select name="assignment_id" id="assignment_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('assignment_id') border-red-500 @enderror"
                                    required onchange="updateFormFields()">
                                    <option value="">Pilih Assignment</option>
                                    @foreach ($assignments as $assignment)
                                        <option value="{{ $assignment->id }}"
                                            data-nama-barang="{{ $assignment->barang->nama_barang }}"
                                            data-lokasi="{{ $assignment->lokasi_tujuan }}"
                                            data-harga-satuan="{{ $assignment->harga_satuan }}"
                                            data-jumlah="{{ $assignment->jumlah }}"
                                            {{ old('assignment_id') == $assignment->id ? 'selected' : '' }}>
                                            {{ $assignment->barang->nama_barang }} - {{ $assignment->lokasi_tujuan }}
                                            ({{ $assignment->jumlah }} pcs)
                                        </option>
                                    @endforeach
                                </select>
                                @error('assignment_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Barang (Auto-filled, readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-box mr-1 text-blue-500"></i>Nama Barang
                                </label>
                                <input type="text" name="nama_barang" id="nama_barang"
                                    value="{{ old('nama_barang') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-sm"
                                    placeholder="Pilih assignment terlebih dahulu" readonly>
                                @error('nama_barang')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Pengantaran (Auto-filled, readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-map-marker-alt mr-1 text-red-500"></i>Lokasi Pengantaran
                                </label>
                                <input type="text" name="lokasi_pengantaran" id="lokasi_pengantaran"
                                    value="{{ old('lokasi_pengantaran') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 text-sm"
                                    placeholder="Pilih assignment terlebih dahulu" readonly>
                                @error('lokasi_pengantaran')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jumlah Barang yang Diantar -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-sort-numeric-up mr-1 text-orange-500"></i>Jumlah Diantar
                                </label>
                                <input type="number" name="jumlah_diantar" id="jumlah_diantar"
                                    value="{{ old('jumlah_diantar') }}" min="1" max=""
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('jumlah_diantar') border-red-500 @enderror"
                                    placeholder="0" required onchange="calculateTotal()">
                                @error('jumlah_diantar')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Satuan (Auto-filled, readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-tag mr-1 text-green-500"></i>Harga Satuan
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute top-1/2 -translate-y-1/2 text-gray-500 text-sm"></span>
                                    <input type="text" id="harga_satuan_display"
                                        class="w-full border border-gray-300 rounded-lg pl-3 py-2 bg-gray-100 text-sm text-gray-800"
                                        placeholder="0" readonly>
                                    <input type="hidden" name="harga_satuan" id="harga_satuan"
                                        value="{{ old('harga_satuan') }}">
                                </div>
                                @error('harga_satuan')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Total (Auto-calculated, format Rp) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-money-bill-wave mr-1 text-green-500"></i>Harga Total
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute top-1/2 -translate-y-1/2 text-gray-500 text-sm"></span>
                                    <input type="text" id="harga_total_display"
                                        class="w-full border border-gray-300 rounded-lg pl-3 py-2 bg-gray-100 text-sm text-gray-800"
                                        placeholder="0" readonly>
                                    <input type="hidden" name="harga_total" id="harga_total"
                                        value="{{ old('harga_total') }}">
                                </div>
                                @error('harga_total')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Pengantaran -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-info-circle mr-1 text-purple-500"></i>Status Pengantaran
                                </label>
                                <select name="status_pengantaran"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('status_pengantaran') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Status</option>
                                    <option value="on_delivery"
                                        {{ old('status_pengantaran') == 'on_delivery' ? 'selected' : '' }}>
                                        🚚 Sedang Dalam Pengantaran
                                    </option>
                                    <option value="delivered"
                                        {{ old('status_pengantaran') == 'delivered' ? 'selected' : '' }}>
                                        ✅ Berhasil Diantar
                                    </option>
                                    <option value="failed"
                                        {{ old('status_pengantaran') == 'failed' ? 'selected' : '' }}>
                                        ❌ Gagal Diantar
                                    </option>
                                </select>
                                @error('status_pengantaran')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Catatan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-sticky-note mr-1 text-yellow-500"></i>Catatan (Opsional)
                                </label>
                                <textarea name="catatan" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Pastikan semua data sudah benar
                                </span>
                                <div class="flex space-x-3">
                                    <a href="{{ route('dashboard') }}"
                                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                                    </a>
                                    <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        Kirim Laporan
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>

            <!-- Recent Reports -->
            @if (Auth::user()->progressReports->count() > 0)
                <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-history mr-2 text-purple-600"></i>
                            Laporan Terakhir
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach (Auth::user()->progressReports()->with('assignment')->latest('tanggal_laporan')->take(3)->get() as $report)
                                <div
                                    class="p-3 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-sm transition-shadow">
                                    <h4 class="font-medium text-gray-800 text-sm truncate">{{ $report->nama_barang }}
                                    </h4>
                                    <p class="text-xs text-gray-600 truncate">{{ $report->lokasi_pengantaran }}</p>
                                    <div class="flex justify-between items-center mt-2">
                                        @php
                                            // Gunakan status assignment jika ada, jika tidak gunakan status progress report
                                            $displayStatus = $report->assignment
                                                ? $report->assignment->status
                                                : $report->status_pengantaran;

                                            $statusClasses = match ($displayStatus) {
                                                'completed', 'delivered' => 'bg-green-100 text-green-800',
                                                'in_progress', 'on_delivery' => 'bg-blue-100 text-blue-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-red-100 text-red-800',
                                            };

                                            $statusIcon = match ($displayStatus) {
                                                'completed', 'delivered' => '✅',
                                                'in_progress', 'on_delivery' => '🚚',
                                                'pending' => '⏳',
                                                default => '❌',
                                            };

                                            $statusText = match ($displayStatus) {
                                                'completed' => 'Selesai',
                                                'delivered' => 'Diantar',
                                                'in_progress' => 'Sedang Proses',
                                                'on_delivery' => 'Dalam Pengantaran',
                                                'pending' => 'Menunggu',
                                                'cancelled' => 'Dibatalkan',
                                                'failed' => 'Gagal',
                                                default => ucfirst(str_replace('_', ' ', $displayStatus)),
                                            };
                                        @endphp
                                        <span class="text-xs px-2 py-1 rounded-full {{ $statusClasses }}">
                                            {{ $statusIcon }} {{ $statusText }}
                                        </span>
                                        <span
                                            class="text-xs text-gray-500">{{ $report->tanggal_laporan->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function updateFormFields() {
            const select = document.getElementById('assignment_id');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value) {
                // Auto-fill form fields
                document.getElementById('nama_barang').value = selectedOption.dataset.namaBarang;
                document.getElementById('lokasi_pengantaran').value = selectedOption.dataset.lokasi;
                document.getElementById('harga_satuan').value = selectedOption.dataset.hargaSatuan;

                // Set max quantity
                const maxJumlah = selectedOption.dataset.jumlah;
                document.getElementById('jumlah_diantar').max = maxJumlah;
                document.getElementById('jumlah_diantar').placeholder = `Max: ${maxJumlah} unit`;

                // Reset jumlah and total
                document.getElementById('jumlah_diantar').value = '';
                document.getElementById('harga_total').value = '';
            } else {
                // Clear all fields
                document.getElementById('nama_barang').value = '';
                document.getElementById('lokasi_pengantaran').value = '';
                document.getElementById('harga_satuan').value = '';
                document.getElementById('jumlah_diantar').value = '';
                document.getElementById('jumlah_diantar').max = '';
                document.getElementById('jumlah_diantar').placeholder = '0';
                document.getElementById('harga_total').value = '';
            }
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function updateFormFields() {
            const select = document.getElementById('assignment_id');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value) {
                document.getElementById('nama_barang').value = selectedOption.dataset.namaBarang;
                document.getElementById('lokasi_pengantaran').value = selectedOption.dataset.lokasi;
                const hargaSatuan = parseFloat(selectedOption.dataset.hargaSatuan) || 0;

                // isi input hidden & tampilan
                document.getElementById('harga_satuan').value = hargaSatuan;
                document.getElementById('harga_satuan_display').value = formatRupiah(hargaSatuan);

                const maxJumlah = selectedOption.dataset.jumlah;
                const jumlahInput = document.getElementById('jumlah_diantar');
                jumlahInput.max = maxJumlah;
                jumlahInput.placeholder = `Max: ${maxJumlah} unit`;
                jumlahInput.value = '';

                // reset total
                document.getElementById('harga_total').value = '';
                document.getElementById('harga_total_display').value = '';
            } else {
                ['nama_barang', 'lokasi_pengantaran', 'harga_satuan', 'jumlah_diantar', 'harga_total'].forEach(id => {
                    document.getElementById(id).value = '';
                });
                document.getElementById('harga_satuan_display').value = '';
                document.getElementById('harga_total_display').value = '';
            }
        }

        function calculateTotal() {
            const jumlah = parseFloat(document.getElementById('jumlah_diantar').value) || 0;
            const hargaSatuan = parseFloat(document.getElementById('harga_satuan').value) || 0;
            const total = jumlah * hargaSatuan;

            document.getElementById('harga_total').value = total;
            document.getElementById('harga_total_display').value = formatRupiah(total);
        }
    </script>
</x-app-layout>
