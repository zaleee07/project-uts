<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\User;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = User::where('role', 'staff')->first() ?? User::first();
        $kopiAren = Product::where('sku', 'KOP-AREN-ICE')->first();
        $croissant = Product::where('sku', 'BAK-CRST-BTR')->first();
        $macchiato = Product::where('sku', 'KOP-CARAMEL')->first();
        $matcha = Product::where('sku', 'NCF-MTC-ICE')->first();
        $beans = Product::where('sku', 'BNS-GYO-250G')->first();

        if ($staff && $kopiAren && $croissant && $macchiato) {
            // Sale 1: Transaksi Kasir POS (Dine In)
            $total1 = (2 * $kopiAren->selling_price) + (1 * $croissant->selling_price); // (2 * 22000) + 25000 = 69000
            $sale1 = Sale::updateOrCreate(
                ['sale_number' => 'SO-20240101-001'],
                [
                    'user_id' => $staff->id,
                    'total' => $total1,
                    'status' => 'completed',
                    'sold_at' => now()->subHours(4),
                    'notes' => 'Pesanan Dine-In Meja 04 (Kasir Barista)',
                ]
            );

            SaleItem::updateOrCreate(
                [
                    'sale_id' => $sale1->id,
                    'product_id' => $kopiAren->id,
                ],
                [
                    'quantity' => 2,
                    'unit_price' => $kopiAren->selling_price,
                    'subtotal' => 2 * $kopiAren->selling_price,
                ]
            );

            SaleItem::updateOrCreate(
                [
                    'sale_id' => $sale1->id,
                    'product_id' => $croissant->id,
                ],
                [
                    'quantity' => 1,
                    'unit_price' => $croissant->selling_price,
                    'subtotal' => $croissant->selling_price,
                ]
            );

            // Sale 2: Transaksi Kasir POS (Takeaway)
            $total2 = (1 * $macchiato->selling_price) + (1 * ($matcha ? $matcha->selling_price : 26000));
            $sale2 = Sale::updateOrCreate(
                ['sale_number' => 'SO-20240101-002'],
                [
                    'user_id' => $staff->id,
                    'total' => $total2,
                    'status' => 'completed',
                    'sold_at' => now()->subHours(2),
                    'notes' => 'Pesanan Takeaway Drive-thru (Kasir Barista)',
                ]
            );

            SaleItem::updateOrCreate(
                [
                    'sale_id' => $sale2->id,
                    'product_id' => $macchiato->id,
                ],
                [
                    'quantity' => 1,
                    'unit_price' => $macchiato->selling_price,
                    'subtotal' => $macchiato->selling_price,
                ]
            );

            if ($matcha) {
                SaleItem::updateOrCreate(
                    [
                        'sale_id' => $sale2->id,
                        'product_id' => $matcha->id,
                    ],
                    [
                        'quantity' => 1,
                        'unit_price' => $matcha->selling_price,
                        'subtotal' => $matcha->selling_price,
                    ]
                );
            }

            // Sale 3: Pelanggan Order Mandiri (Online App)
            $pelanggan = User::whereIn('role', ['pelanggan', 'pembeli'])->first();
            if ($pelanggan && $beans) {
                $total3 = (1 * $kopiAren->selling_price) + (1 * $beans->selling_price); // 22000 + 75000 = 97000
                $sale3 = Sale::updateOrCreate(
                    ['sale_number' => 'SO-20240101-003'],
                    [
                        'user_id' => $pelanggan->id,
                        'total' => $total3,
                        'status' => 'completed',
                        'sold_at' => now()->subMinutes(45),
                        'notes' => 'Pesanan Mandiri Aplikasi Pelanggan (Self Pick-up)',
                    ]
                );

                SaleItem::updateOrCreate(
                    [
                        'sale_id' => $sale3->id,
                        'product_id' => $kopiAren->id,
                    ],
                    [
                        'quantity' => 1,
                        'unit_price' => $kopiAren->selling_price,
                        'subtotal' => $kopiAren->selling_price,
                    ]
                );

                SaleItem::updateOrCreate(
                    [
                        'sale_id' => $sale3->id,
                        'product_id' => $beans->id,
                    ],
                    [
                        'quantity' => 1,
                        'unit_price' => $beans->selling_price,
                        'subtotal' => $beans->selling_price,
                    ]
                );
            }
        }
    }
}
