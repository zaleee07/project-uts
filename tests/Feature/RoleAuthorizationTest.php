<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected $staff;
    protected $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->staff = User::create([
            'name' => 'Staff Biasa',
            'email' => 'staff@test.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        $this->owner = User::create([
            'name' => 'Owner Pemilik',
            'email' => 'owner@test.com',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);
    }

    public function test_staff_cannot_access_user_management()
    {
        $response = $this->actingAs($this->staff)->get('/users');
        $response->assertStatus(403);
    }

    public function test_staff_cannot_create_categories()
    {
        $response = $this->actingAs($this->staff)->get('/categories/create');
        $response->assertStatus(403);

        $postResponse = $this->actingAs($this->staff)->post('/categories', [
            'name' => 'Kategori Ilegal',
        ]);
        $postResponse->assertStatus(403);
    }

    public function test_owner_can_access_user_management_and_categories()
    {
        $response = $this->actingAs($this->owner)->get('/users');
        $response->assertStatus(200);

        $categoryResponse = $this->actingAs($this->owner)->get('/categories/create');
        $categoryResponse->assertStatus(200);
    }

    public function test_pelanggan_cannot_access_purchases_or_user_management()
    {
        $pelanggan = User::create([
            'name' => 'Akun Pelanggan',
            'email' => 'pelanggan@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        // Pelanggan cannot access purchases
        $this->actingAs($pelanggan)->get('/purchases')->assertStatus(403);

        // Pelanggan cannot access user management
        $this->actingAs($pelanggan)->get('/users')->assertStatus(403);
    }

    public function test_pelanggan_accesses_dedicated_pelanggan_dashboard()
    {
        $pelanggan = User::create([
            'name' => 'Akun Pelanggan 2',
            'email' => 'pelanggan2@test.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        $response = $this->actingAs($pelanggan)->get('/dashboard');
        $response->assertStatus(200);
    }
}
