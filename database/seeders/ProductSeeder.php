<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kopiSusu = Category::where('name', 'Signature Kopi Susu')->first();
        $espresso = Category::where('name', 'Espresso & Coffee Bar')->first();
        $nonCoffee = Category::where('name', 'Non-Coffee & Mocktails')->first();
        $pastry = Category::where('name', 'Artisan Pastry & Bakery')->first();
        $beans = Category::where('name', 'Biji Kopi & Kemasan')->first();

        $products = [
            [
                'category_id' => $kopiSusu ? $kopiSusu->id : 1,
                'sku' => 'KOP-AREN-ICE',
                'name' => 'Es Kopi Susu Gula Aren Signature',
                'purchase_price' => 8000,
                'selling_price' => 22000,
                'stock' => 85,
                'minimum_stock' => 15,
            ],
            [
                'category_id' => $kopiSusu ? $kopiSusu->id : 1,
                'sku' => 'KOP-CARAMEL',
                'name' => 'Iced Salted Caramel Macchiato',
                'purchase_price' => 11000,
                'selling_price' => 28000,
                'stock' => 40,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $espresso ? $espresso->id : 2,
                'sku' => 'KOP-AMR-HOT',
                'name' => 'Hot Americano Arabica Single Origin',
                'purchase_price' => 6000,
                'selling_price' => 20000,
                'stock' => 60,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $espresso ? $espresso->id : 2,
                'sku' => 'KOP-CAPPUC',
                'name' => 'Hot Cappuccino Velvety Milk Foam',
                'purchase_price' => 9000,
                'selling_price' => 25000,
                'stock' => 45,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $nonCoffee ? $nonCoffee->id : 3,
                'sku' => 'NCF-MTC-ICE',
                'name' => 'Iced Kyoto Matcha Latte',
                'purchase_price' => 12000,
                'selling_price' => 26000,
                'stock' => 5, // LOW STOCK (minimum_stock = 10)
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $nonCoffee ? $nonCoffee->id : 3,
                'sku' => 'NCF-CHO-ICE',
                'name' => 'Iced Belgian Dark Chocolate',
                'purchase_price' => 10000,
                'selling_price' => 24000,
                'stock' => 35,
                'minimum_stock' => 10,
            ],
            [
                'category_id' => $pastry ? $pastry->id : 4,
                'sku' => 'BAK-CRST-BTR',
                'name' => 'French Butter Croissant Fresh Baked',
                'purchase_price' => 12000,
                'selling_price' => 25000,
                'stock' => 20,
                'minimum_stock' => 8,
            ],
            [
                'category_id' => $pastry ? $pastry->id : 4,
                'sku' => 'BAK-CIN-ROL',
                'name' => 'Cinnamon Roll Cream Cheese Glaze',
                'purchase_price' => 14000,
                'selling_price' => 27000,
                'stock' => 0, // OUT OF STOCK demo
                'minimum_stock' => 5,
            ],
            [
                'category_id' => $beans ? $beans->id : 5,
                'sku' => 'BNS-GYO-250G',
                'name' => 'Biji Kopi Arabika Aceh Gayo Medium Roast 250g',
                'purchase_price' => 45000,
                'selling_price' => 75000,
                'stock' => 25,
                'minimum_stock' => 5,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['sku' => $p['sku']], $p);
        }
    }
}
