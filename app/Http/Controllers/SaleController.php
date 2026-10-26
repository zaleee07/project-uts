<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Http\Requests\StoreSaleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'items.product']);

        // Jika login sebagai Pembeli, hanya tampilkan riwayat transaksinya sendiri
        if (auth()->user()->isPembeli()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $query->where('sale_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->filterDate($request->start_date, $request->end_date);
        }

        $sales = $query->latest('sold_at')->paginate(10)->withQueryString();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // Only active products with stock > 0 for new sale
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('products'));
    }

    public function store(StoreSaleRequest $request)
    {
        $sale = DB::transaction(function () use ($request) {
            $saleNumber = 'SO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'sale_number' => $saleNumber,
                'total' => 0,
                'status' => 'completed',
                'sold_at' => $request->sold_at ?? now(),
                'notes' => $request->notes,
            ]);

            $total = 0;

            foreach ($request->items as $itemData) {
                // Pessimistic locking: lock the product row for update to prevent race condition
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
                $qty = (int) $itemData['quantity'];

                if ($qty < 1) {
                    throw ValidationException::withMessages([
                        'items' => "Kuantitas untuk produk '{$product->name}' harus minimal 1.",
                    ]);
                }

                // Check available stock
                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok untuk produk '{$product->name}' (SKU: {$product->sku}) tidak mencukupi! Stok tersedia: {$product->stock}, permintaan transaksi: {$qty}.",
                    ]);
                }

                // Server-calculated unit price and subtotal
                $unitPrice = $product->selling_price;
                $subtotal = $unitPrice * $qty;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                // Atomic decrement of stock
                $product->decrement('stock', $qty);

                $total += $subtotal;
            }

            // Update total after all items processed
            $sale->update(['total' => $total]);

            return $sale;
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', "Transaksi penjualan {$sale->sale_number} berhasil diproses dan stok telah diperbarui.");
    }

    public function show(Sale $sale)
    {
        if (auth()->user()->isPembeli() && $sale->user_id !== auth()->id()) {
            abort(403, 'Akses Ditolak: Anda tidak dapat melihat struk transaksi milik pengguna lain.');
        }

        $sale->load(['user', 'items.product']);
        return view('sales.show', compact('sale'));
    }

    /**
     * Cancel sale (Admin only)
     * Reverts stock reduction.
     */
    public function cancel(Request $request, Sale $sale)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin yang berhak membatalkan transaksi penjualan.');
        }

        if ($sale->status === 'cancelled') {
            return back()->with('error', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                // Restoring stock
                $product->increment('stock', $item->quantity);
            }

            $sale->update(['status' => 'cancelled']);
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Transaksi penjualan berhasil dibatalkan dan stok produk telah dikembalikan ke inventaris.');
    }
}
