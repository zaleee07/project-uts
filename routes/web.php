<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes - ZENITH Coffee & Roastery
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Authenticated System Routes
Route::middleware('auth')->group(function () {
    // Root redirect
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products (Index & Show available to Staff and Admin)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::middleware('role:admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    });
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Transactions: Purchases (Stock-In) - accessible only by Staff & Admin (Pembeli dilarang)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);
    });

    // POS sales and customer orders
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);

    // ==========================================
    // Admin Exclusive Routes (Role Protected)
    // ==========================================
    Route::middleware('role:admin')->group(function () {
        // Products Master Data Management (Create, Edit, Delete)
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Master Data Categories
        Route::resource('categories', CategoryController::class);

        // Master Data Suppliers
        Route::resource('suppliers', SupplierController::class);

        // User & Role Management
        Route::resource('users', UserController::class);

        // Transaction Cancellations with Stock Reversal (Admin Only)
        Route::post('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
        Route::post('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
    });
});
