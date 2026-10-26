@extends('layouts.app')

@section('title', 'Detail Produk ' . $product->sku)
@section('page_title', 'Informasi Detail Produk')
@section('page_description', 'Detail spesifikasi harga, ketersediaan stok, dan mutasi barang.')

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('products.index') }}" class="text-xs text-blue-600 hover:underline flex items-center space-x-1">
            <span>&larr; Kembali ke Daftar Produk</span>
        </a>
        @if(auth()->user()->isAdmin())
        <div class="flex items-center space-x-2">
            <a href="{{ route('products.edit', $product) }}" class="text-xs bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
                Ubah Produk
            </a>
        </div>
        @endif
    </div>

    <!-- Product Card Info -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-3">
            <span class="text-xs font-mono uppercase bg-slate-100 text-slate-700 px-2.5 py-1 rounded font-semibold">{{ $product->sku }}</span>
            <h2 class="text-xl font-bold text-slate-900">{{ $product->name }}</h2>
            <p class="text-xs text-slate-500">Kategori: <strong class="text-slate-700">{{ $product->category->name ?? '-' }}</strong></p>
        </div>

        <div class="space-y-2 border-y md:border-y-0 md:border-x border-slate-100 py-4 md:py-0 md:px-6">
            <div class="flex justify-between text-xs">
                <span class="text-slate-500">Harga Beli / Modal:</span>
                <span class="font-mono font-semibold text-slate-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-slate-500">Harga Jual Konsumen:</span>
                <span class="font-mono font-bold text-blue-700">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-xs">
                <span class="text-slate-500">Estimasi Margin:</span>
                <span class="font-mono font-semibold text-emerald-600">
                    Rp {{ number_format($product->selling_price - $product->purchase_price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="space-y-3 flex flex-col justify-center items-start md:items-end">
            <div class="text-left md:text-right">
                <span class="text-xs text-slate-500 uppercase font-semibold block">Sisa Stok Fisik</span>
                <span class="text-3xl font-extrabold {{ $product->stock <= 0 ? 'text-rose-600' : ($product->isLowStock() ? 'text-amber-600' : 'text-emerald-600') }}">
                    {{ $product->stock }}
                </span>
                <span class="text-xs text-slate-500 block">Batas Minimum: {{ $product->minimum_stock }} unit</span>
            </div>
        </div>
    </div>

    <!-- Transaction History (Mutasi Stok) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Riwayat Pembelian -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Riwayat Masuk (Pembelian)</h3>
                <span class="text-xs text-slate-500">{{ $product->purchaseItems->count() }} Transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100/60 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3">No. PO</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3 text-center">Qty Masuk</th>
                            <th class="p-3 text-right">Harga Beli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($product->purchaseItems as $pItem)
                        <tr>
                            <td class="p-3 font-mono font-medium text-blue-600">
                                <a href="{{ route('purchases.show', $pItem->purchase_id) }}">{{ $pItem->purchase->purchase_number ?? '-' }}</a>
                            </td>
                            <td class="p-3 text-slate-600">{{ $pItem->purchase->purchased_at ? $pItem->purchase->purchased_at->format('d/m/Y') : '-' }}</td>
                            <td class="p-3 text-center font-bold text-emerald-600">+{{ $pItem->quantity }}</td>
                            <td class="p-3 text-right font-mono">Rp {{ number_format($pItem->unit_cost, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-slate-400">Belum ada riwayat pembelian untuk produk ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Riwayat Penjualan -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Riwayat Keluar (Penjualan)</h3>
                <span class="text-xs text-slate-500">{{ $product->saleItems->count() }} Transaksi</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100/60 text-slate-500 uppercase font-semibold">
                        <tr>
                            <th class="p-3">No. Faktur</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3 text-center">Qty Keluar</th>
                            <th class="p-3 text-right">Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($product->saleItems as $sItem)
                        <tr>
                            <td class="p-3 font-mono font-medium text-blue-600">
                                <a href="{{ route('sales.show', $sItem->sale_id) }}">{{ $sItem->sale->sale_number ?? '-' }}</a>
                            </td>
                            <td class="p-3 text-slate-600">{{ $sItem->sale->sold_at ? $sItem->sale->sold_at->format('d/m/Y') : '-' }}</td>
                            <td class="p-3 text-center font-bold text-rose-600">-{{ $sItem->quantity }}</td>
                            <td class="p-3 text-right font-mono">Rp {{ number_format($sItem->unit_price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-slate-400">Belum ada riwayat penjualan untuk produk ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
