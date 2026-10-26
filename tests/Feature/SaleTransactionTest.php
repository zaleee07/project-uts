<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTransactionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $productA;
    protected $productB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Staff Kasir',
            'email' => 'kasir@test.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        $category = Category::create(['name' => 'Alat Tulis']);

        $this->productA = Product::create([
            'category_id' => $category->id,
            'sku' => 'SKU-A',
            'name' => 'Buku Catatan',
            'purchase_price' => 5000,
            'selling_price' => 10000,
            'stock' => 20,
            'minimum_stock' => 5,
        ]);

        $this->productB = Product::create([
            'category_id' => $category->id,
            'sku' => 'SKU-B',
            'name' => 'Pulpen Gel',
            'purchase_price' => 2000,
            'selling_price' => 4000,
            'stock' => 5, // Only 5 in stock
            'minimum_stock' => 2,
        ]);
    }

    public function test_sale_successfully_decrements_product_stock()
    {
        $response = $this->actingAs($this->user)->post('/sales', [
            'sold_at' => now()->toDateTimeString(),
            'notes' => 'Penjualan tunai',
            'items' => [
                [
                    'product_id' => $this->productA->id,
                    'quantity' => 4,
                ]
            ]
        ]);

        $response->assertSessionHasNoErrors();

        // Total should be 4 * 10,000 = 40,000
        $this->assertDatabaseHas('sales', [
            'total' => 40000,
            'status' => 'completed',
        ]);

        // Stock should be decremented from 20 to 16
        $this->assertEquals(16, $this->productA->fresh()->stock);
    }

    public function test_insufficient_stock_rejects_sale_and_leaves_stock_untouched()
    {
        // Product B only has 5 items. Request 8 items (insufficient)
        $response = $this->actingAs($this->user)->post('/sales', [
            'sold_at' => now()->toDateTimeString(),
            'items' => [
                [
                    'product_id' => $this->productB->id,
                    'quantity' => 8,
                ]
            ]
        ]);

        $response->assertSessionHasErrors('items');

        // Verify no sale was created
        $this->assertEquals(0, Sale::count());

        // Stock remains untouched at 5
        $this->assertEquals(5, $this->productB->fresh()->stock);
    }

    public function test_atomicity_rolls_back_entire_transaction_if_any_item_fails()
    {
        // Try selling 2 of Product A (valid, has 20), but 10 of Product B (invalid, only has 5)
        $response = $this->actingAs($this->user)->post('/sales', [
            'sold_at' => now()->toDateTimeString(),
            'items' => [
                [
                    'product_id' => $this->productA->id,
                    'quantity' => 2,
                ],
                [
                    'product_id' => $this->productB->id,
                    'quantity' => 10, // Fails here!
                ]
            ]
        ]);

        $response->assertSessionHasErrors('items');

        // Rollback verification:
        // Neither sale header nor sale items exist in DB
        $this->assertEquals(0, Sale::count());

        // Product A stock must NOT be decremented; it stays at 20!
        $this->assertEquals(20, $this->productA->fresh()->stock);
        $this->assertEquals(5, $this->productB->fresh()->stock);
    }
}
