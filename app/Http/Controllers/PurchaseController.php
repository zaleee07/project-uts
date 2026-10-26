<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use App\Http\Requests\StorePurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with(['supplier', 'user', 'items.product']);

        if ($request->filled('search')) {
            $query->where('purchase_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('supplier', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') || $request->filled('end_date')) {
            $query->filterDate($request->start_date, $request->end_date);
        }

        $purchases = $query->latest('purchased_at')->paginate(10)->withQueryString();

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(StorePurchaseRequest $request)
    {
        $purchase = DB::transaction(function () use ($request) {
            $purchaseNumber = 'PO-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'user_id' => auth()->id(),
                'purchase_number' => $purchaseNumber,
                'total' => 0, // Calculated dynamically below
                'status' => 'completed',
                'purchased_at' => $request->purchased_at ?? now(),
                'notes' => $request->notes,
            ]);

            $total = 0;

            foreach ($request->items as $itemData) {
                $qty = (int) $itemData['quantity'];
                $unitCost = (float) $itemData['unit_cost'];

                if ($qty < 1 || $unitCost < 0) {
                    throw ValidationException::withMessages([
                        'items' => 'Kuantitas atau harga beli item tidak valid.',
                    ]);
                }

                // Pessimistic lock for atomic stock update
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);

                $subtotal = $unitCost * $qty;

                // Save detail item
                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_cost' => $unitCost,
                    'subtotal' => $subtotal,
                ]);

                // Increment stock on successful transaction
                $product->increment('stock', $qty);

                // Optionally update product's latest purchase price
                $product->update(['purchase_price' => $unitCost]);

                $total += $subtotal;
            }

            // Total is calculated and verified on server-side
            $purchase->update(['total' => $total]);

            return $purchase;
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', "Transaksi pembelian {$purchase->purchase_number} berhasil disimpan dan stok produk telah ditambahkan.");
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'user', 'items.product']);
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Cancel purchase (Admin only)
     * Reverts stock addition if current stock is sufficient.
     */
    public function cancel(Request $request, Purchase $purchase)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Hanya Admin yang memiliki hak akses untuk membatalkan transaksi.');
        }

        if ($purchase->status === 'cancelled') {
            return back()->with('error', 'Transaksi pembelian ini sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($purchase) {
            foreach ($purchase->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cancel' => "Gagal membatalkan: Stok produk '{$product->name}' tersisa {$product->stock}, tidak cukup untuk dikurangi {$item->quantity} (sebagian stok kemungkinan telah terjual).",
                    ]);
                }

                $product->decrement('stock', $item->quantity);
            }

            $purchase->update(['status' => 'cancelled']);
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Transaksi pembelian berhasil dibatalkan dan penambahan stok telah ditarik kembali.');
    }
}
