<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->category = Category::create([
            'name' => 'Elektronik',
            'description' => 'Gadget dan elektronik',
        ]);
    }

    public function test_product_cannot_be_created_with_duplicate_sku()
    {
        Product::create([
            'category_id' => $this->category->id,
            'sku' => 'SKU-001',
            'name' => 'Original Item',
            'purchase_price' => 10000,
            'selling_price' => 15000,
            'stock' => 10,
            'minimum_stock' => 5,
        ]);

        $response = $this->actingAs($this->admin)->post('/products', [
            'category_id' => $this->category->id,
            'sku' => 'SKU-001', // Duplicate SKU
            'name' => 'Duplicate Item',
            'purchase_price' => 12000,
            'selling_price' => 18000,
            'minimum_stock' => 5,
        ]);

        $response->assertSessionHasErrors('sku');
    }

    public function test_product_cannot_have_negative_price()
    {
        $response = $this->actingAs($this->admin)->post('/products', [
            'category_id' => $this->category->id,
            'sku' => 'SKU-002',
            'name' => 'Negative Price Item',
            'purchase_price' => -5000,
            'selling_price' => 10000,
            'minimum_stock' => 5,
        ]);

        $response->assertSessionHasErrors('purchase_price');
    }

    public function test_product_can_be_created_successfully()
    {
        $response = $this->actingAs($this->admin)->post('/products', [
            'category_id' => $this->category->id,
            'sku' => 'SKU-SUCCESS',
            'name' => 'Mouse Wireless',
            'purchase_price' => 50000,
            'selling_price' => 75000,
            'stock' => 20,
            'minimum_stock' => 5,
        ]);

        $response->assertRedirect('/products');
        $this->assertDatabaseHas('products', [
            'sku' => 'SKU-SUCCESS',
            'name' => 'Mouse Wireless',
            'stock' => 20,
        ]);
    }
}
