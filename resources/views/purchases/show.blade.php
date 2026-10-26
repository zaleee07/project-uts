@extends('layouts.app')

@section('title', 'Faktur Pasokan ' . $purchase->purchase_number)
@section('page_title', 'Detail Pasokan Bahan Roastery')
@section('page_description', 'Bukti tanda terima penerimaan pasokan bahan baku dan rekapitulasi item.')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Top Action Links -->
    <div class="flex items-center justify-between">
        <a href="{{ route('purchases.index') }}" class="text-xs text-blue-600 hover:underline flex items-center space-x-1">
            <span>&larr; Kembali ke Riwayat Pembelian</span>
        </a>

        @if(auth()->user()->isAdmin() && $purchase->status === 'completed')
        <form action="{{ route('purchases.cancel', $purchase) }}" method="POST"
              onsubmit="return confirm('PERINGATAN: Membatalkan transaksi ini akan menarik kembali stok produk sejumlah yang telah dibeli. Lanjutkan pembatalan?')">
            @csrf
            <button type="submit" class="text-xs bg-rose-50 border border-rose-300 hover:bg-rose-100 text-rose-700 font-semibold px-3.5 py-1.5 rounded-lg transition shadow-sm">
                Batalkan Transaksi Pembelian Ini
            </button>
        </form>
        @endif
    </div>

    <!-- Invoice Sheet -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-6">
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-slate-100 pb-6">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Bukti Penerimaan Bahan Baku Roastery</span>
                <h2 class="text-2xl font-black text-slate-900 font-mono mt-0.5">{{ $purchase->purchase_number }}</h2>
                <p class="text-xs text-slate-500 mt-1">Dicatat pada: {{ $purchase->purchased_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $purchase->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    STATUS: {{ strtoupper($purchase->status) }}
                </span>
                <p class="text-xs text-slate-500 mt-2">Petugas: <strong class="text-slate-800">{{ $purchase->user->name ?? '-' }}</strong></p>
            </div>
        </div>

        <!-- Supplier & Notes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-xl border border-slate-100">
            <div>
                <span class="text-slate-400 uppercase font-semibold block mb-0.5">Identitas Pemasok (Supplier)</span>
                <h4 class="font-bold text-slate-900 text-sm">{{ $purchase->supplier->name }}</h4>
                <p class="text-slate-600 mt-0.5">{{ $purchase->supplier->phone ?? '-' }} | {{ $purchase->supplier->email ?? '-' }}</p>
                <p class="text-slate-500 mt-0.5">{{ $purchase->supplier->address ?? '-' }}</p>
            </div>
            <div>
                <span class="text-slate-400 uppercase font-semibold block mb-0.5">Catatan Tambahan</span>
                <p class="text-slate-700 italic">{{ $purchase->notes ?? 'Tidak ada catatan.' }}</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">SKU & Nama Menu / Bahan</th>
                        <th class="p-3 text-center">Jumlah Diterima</th>
                        <th class="p-3 text-right">Harga Modal Satuan</th>
                        <th class="p-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($purchase->items as $item)
                    <tr>
                        <td class="p-3 text-slate-400 font-mono">{{ $loop->iteration }}</td>
                        <td class="p-3">
                            <span class="font-mono text-slate-500 block text-[11px]">{{ $item->product->sku ?? '-' }}</span>
                            <span class="font-bold text-slate-900">{{ $item->product->name ?? 'Produk dihapus' }}</span>
                        </td>
                        <td class="p-3 text-center font-bold text-slate-800">{{ $item->quantity }} pcs / item</td>
                        <td class="p-3 text-right font-mono text-slate-600">Rp {{ number_format($item->unit_cost, 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-mono font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-slate-200">
                    <tr>
                        <td colspan="4" class="p-4 text-right font-bold text-sm text-slate-700 uppercase">Total Nilai Pasokan:</td>
                        <td class="p-4 text-right font-black text-lg text-amber-700 font-mono">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
