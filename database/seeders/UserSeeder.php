<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barang;
use App\Models\Assignment;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@managementapps.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Karyawan Users
        $karyawan1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@managementapps.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        $karyawan2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@managementapps.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        $karyawan3 = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@managementapps.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        // Create Sample Barang
        $barang1 = Barang::create([
            'nama_barang' => 'Laptop Dell Inspiron',
            'kode_barang' => 'LPT001',
            'harga_barang' => 8500000,
            'stok' => 50,
            'deskripsi' => 'Laptop Dell Inspiron 15 3000 Series'
        ]);

        $barang2 = Barang::create([
            'nama_barang' => 'Mouse Wireless Logitech',
            'kode_barang' => 'MSE002',
            'harga_barang' => 250000,
            'stok' => 200,
            'deskripsi' => 'Mouse wireless Logitech M100'
        ]);

        $barang3 = Barang::create([
            'nama_barang' => 'Keyboard Mechanical',
            'kode_barang' => 'KBD003',
            'harga_barang' => 750000,
            'stok' => 80,
            'deskripsi' => 'Keyboard mechanical gaming RGB'
        ]);

        $barang4 = Barang::create([
            'nama_barang' => 'Monitor LED 24 inch',
            'kode_barang' => 'MON004',
            'harga_barang' => 2200000,
            'stok' => 30,
            'deskripsi' => 'Monitor LED 24 inch Full HD'
        ]);

        // Create Sample Assignments
        Assignment::create([
            'barang_id' => $barang1->id,
            'karyawan_id' => $karyawan1->id,
            'jumlah' => 5,
            'lokasi_tujuan' => 'Jakarta Pusat - PT. ABC Technology',
            'status' => 'pending',
            'tanggal_assignment' => now(),
            'catatan' => 'Harap hati-hati saat pengiriman, barang elektronik'
        ]);

        Assignment::create([
            'barang_id' => $barang2->id,
            'karyawan_id' => $karyawan2->id,
            'jumlah' => 25,
            'lokasi_tujuan' => 'Surabaya - Toko Komputer Sejahtera',
            'status' => 'in_progress',
            'tanggal_assignment' => now()->subDays(1),
            'catatan' => 'Pengiriman reguler'
        ]);

        Assignment::create([
            'barang_id' => $barang3->id,
            'karyawan_id' => $karyawan3->id,
            'jumlah' => 10,
            'lokasi_tujuan' => 'Bandung - Gaming Store XYZ',
            'status' => 'pending',
            'tanggal_assignment' => now(),
            'catatan' => 'Customer premium, prioritas tinggi'
        ]);

        Assignment::create([
            'barang_id' => $barang4->id,
            'karyawan_id' => $karyawan1->id,
            'jumlah' => 3,
            'lokasi_tujuan' => 'Yogyakarta - Universitas ABC',
            'status' => 'pending',
            'tanggal_assignment' => now()->addDays(1),
            'catatan' => 'Pengiriman untuk kebutuhan lab komputer'
        ]);
    }
}
