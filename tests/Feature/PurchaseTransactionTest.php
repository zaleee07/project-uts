<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $supplier;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Staff Operasional',
            'email' => 'staff@test.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        $category = Category::create(['name' => 'Signature Kopi Susu']);

        $this->supplier = Supplier::create([
            'name' => 'Supplier Utama',
            'phone' => '08123456789',
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'sku' => 'PRD-TEST-01',
            'name' => 'Kabel USB',
            'purchase_price' => 10000,
            'selling_price' => 20000,
            'stock' => 10, // Initial stock = 10
            'minimum_stock' => 5,
        ]);
    }

    public function test_purchase_successfully_increments_product_stock()
    {
        $response = $this->actingAs($this->user)->post('/purchases', [
            'supplier_id' => $this->supplier->id,
            'purchased_at' => now()->toDateTimeString(),
            'notes' => 'Restock pengadaan barang baru',
            'items' => [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 15,
                    'unit_cost' => 12000,
                ]
            ]
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('purchases', [
            'supplier_id' => $this->supplier->id,
            'total' => 15 * 12000, // 180,000
            'status' => 'completed',
        ]);

        // Verify stock has incremented from 10 + 15 = 25
        $this->assertEquals(25, $this->product->fresh()->stock);
    }
}
