<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\User;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplier = Supplier::where('name', 'PT Roastery Kopi Nusantara')->first() ?? Supplier::first();
        $admin = User::whereIn('role', ['owner', 'admin'])->first() ?? User::first();
        $beans = Product::where('sku', 'BNS-GYO-250G')->first();
        $croissant = Product::where('sku', 'BAK-CRST-BTR')->first();

        if ($supplier && $admin && $beans && $croissant) {
            $total = (20 * $beans->purchase_price) + (30 * $croissant->purchase_price);

            $purchase = Purchase::updateOrCreate(
                ['purchase_number' => 'PO-20240101-001'],
                [
                    'supplier_id' => $supplier->id,
                    'user_id' => $admin->id,
                    'total' => $total, // (20 * 45.000) + (30 * 12.000) = 900.000 + 360.000 = 1.260.000
                    'status' => 'completed',
                    'purchased_at' => now()->subDays(3),
                    'notes' => 'Pasokan biji kopi Arabika Gayo dan pasokan mentah pastry harian',
                ]
            );

            // Purchase Items
            PurchaseItem::updateOrCreate(
                [
                    'purchase_id' => $purchase->id,
                    'product_id' => $beans->id,
                ],
                [
                    'quantity' => 20,
                    'unit_cost' => $beans->purchase_price,
                    'subtotal' => 20 * $beans->purchase_price,
                ]
            );

            PurchaseItem::updateOrCreate(
                [
                    'purchase_id' => $purchase->id,
                    'product_id' => $croissant->id,
                ],
                [
                    'quantity' => 30,
                    'unit_cost' => $croissant->purchase_price,
                    'subtotal' => 30 * $croissant->purchase_price,
                ]
            );
        }
    }
}
