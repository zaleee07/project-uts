<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT Roastery Kopi Nusantara',
                'phone' => '021-5558989',
                'email' => 'roastery@kopinusantara.id',
                'address' => 'Sentra Roastery Kopi No. 12, Jakarta Selatan',
            ],
            [
                'name' => 'CV Sumber Dairy & Susu Segar',
                'phone' => '022-7774321',
                'email' => 'order@sumberdairy.com',
                'address' => 'Kawasan Agrowisata Susu Lembang Kav. 8, Bandung',
            ],
            [
                'name' => 'Artisan Syrup & Bakery Supply',
                'phone' => '031-8886543',
                'email' => 'supply@artisansyrup.co.id',
                'address' => 'Pergudangan Industri Makanan No. 5, Surabaya',
            ],
        ];

        foreach ($suppliers as $sup) {
            Supplier::updateOrCreate(['name' => $sup['name']], $sup);
        }
    }
}
