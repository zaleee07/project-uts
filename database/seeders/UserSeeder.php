<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Owner / Pemilik Usaha (Wewenang Penuh, Laporan Keuangan, User Management)
        User::updateOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Budi Hartono (Owner Kafe)',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        // Alias admin ke owner
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Budi Hartono (Owner Kafe)',
                'password' => Hash::make('password123'),
                'role' => 'owner',
            ]
        );

        // 2. Akun Staff / Barista & Kasir (Kelola Pasokan Stok Masuk, Menu, Kasir POS)
        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Siti Rahma (Head Barista & Kasir)',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        // Staff Tambahan
        User::updateOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'name' => 'Ahmad Fauzi (Barista & Restock)',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        // 3. Akun Pelanggan (Pesan Menu Mandiri, Riwayat Pesanan & Struk Pribadi)
        User::updateOrCreate(
            ['email' => 'pelanggan@example.com'],
            [
                'name' => 'Rizky Pratama (Member Pelanggan)',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
            ]
        );

        // Alias pembeli ke pelanggan
        User::updateOrCreate(
            ['email' => 'pembeli@example.com'],
            [
                'name' => 'Rizky Pratama (Member Pelanggan)',
                'password' => Hash::make('password123'),
                'role' => 'pelanggan',
            ]
        );
    }
}
