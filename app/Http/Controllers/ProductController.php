<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search by SKU or Name
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by Low Stock
        if ($request->boolean('low_stock')) {
            $query->lowStock();
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'purchaseItems.purchase.supplier', 'saleItems.sale.user']);
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Business rule from Slide 8:
        // Produk yang sudah dipakai dalam transaksi tidak dihapus secara hard delete;
        // gunakan larangan hapus atau soft delete.
        $hasTransactions = $product->purchaseItems()->exists() || $product->saleItems()->exists();

        if ($hasTransactions) {
            // Soft delete preserving integrity
            $product->delete();
            return redirect()->route('products.index')
                ->with('success', 'Produk telah di-nonaktifkan (soft deleted) untuk menjaga integritas riwayat transaksi.');
        }

        // Hard delete if never used in any transactions
        $product->forceDelete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus permanen dari sistem.');
    }
}
