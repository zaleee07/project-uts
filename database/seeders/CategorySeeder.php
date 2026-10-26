<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Signature Kopi Susu', 'description' => 'Menu kopi susu kekinian dengan gula aren dan perisa spesial'],
            ['name' => 'Espresso & Coffee Bar', 'description' => 'Minuman klasik berbasis espresso: Americano, Latte, Cappuccino'],
            ['name' => 'Non-Coffee & Mocktails', 'description' => 'Minuman segar non-kopi: Matcha Latte, Cokelat Belgia, Red Velvet'],
            ['name' => 'Artisan Pastry & Bakery', 'description' => 'Roti dan kue panggang segar: Butter Croissant, Cinnamon Roll'],
            ['name' => 'Biji Kopi & Kemasan', 'description' => 'Biji kopi sangrai asli Nusantara dalam kemasan 250g'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
