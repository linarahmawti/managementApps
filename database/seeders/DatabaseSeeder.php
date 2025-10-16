<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🧍‍♂ Admin Accounts
        User::create([
            'name' => 'Admin Satu',
            'email' => 'admin1@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin Dua',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 👷‍♂ Karyawan Accounts
        User::create([
            'name' => 'Karyawan Satu',
            'email' => 'karyawan1@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);

        User::create([
            'name' => 'Karyawan Dua',
            'email' => 'karyawan2@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);
    }
}
