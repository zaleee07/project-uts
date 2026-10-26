@extends('layouts.app')

@section('title', auth()->user()->isPembeli() ? ('Struk Pesanan ' . $sale->sale_number) : ('Struk Kasir ' . $sale->sale_number))
@section('page_title', auth()->user()->isPembeli() ? 'Struk Pesanan Saya' : 'Struk Kasir & Faktur Penjualan')
@section('page_description', auth()->user()->isPembeli() ? 'Bukti transaksi pembelian kopi dan tanda terima pembayaran sah.' : 'Struk transaksi kasir POS penjualan menu kepada tamu.')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Top Action Links -->
    <div class="flex items-center justify-between">
        <a href="{{ route('sales.index') }}" class="text-xs text-blue-600 hover:underline flex items-center space-x-1">
            <span>&larr; {{ auth()->user()->isPembeli() ? 'Kembali ke Riwayat Pesanan Saya' : 'Kembali ke Riwayat Penjualan' }}</span>
        </a>

        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-3 py-1.5 rounded-lg transition border border-slate-300">
                Cetak Struk (Print)
            </button>

            @if(auth()->user()->isAdmin() && $sale->status === 'completed')
            <form action="{{ route('sales.cancel', $sale) }}" method="POST"
                  onsubmit="return confirm('PERINGATAN: Membatalkan penjualan ini akan mengembalikan seluruh stok barang ke inventaris. Lanjutkan?')">
                @csrf
                <button type="submit" class="text-xs bg-rose-50 border border-rose-300 hover:bg-rose-100 text-rose-700 font-semibold px-3.5 py-1.5 rounded-lg transition shadow-sm">
                    Batalkan Transaksi Penjualan Ini
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Invoice Sheet -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-6" id="printableInvoice">
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-slate-100 pb-6">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ auth()->user()->isPembeli() ? 'Struk Bukti Pembelian' : 'Struk / Faktur Penjualan Resmi' }}</span>
                <h2 class="text-2xl font-black text-slate-900 font-mono mt-0.5">{{ $sale->sale_number }}</h2>
                <p class="text-xs text-slate-500 mt-1">Waktu Transaksi: {{ $sale->sold_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $sale->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                    STATUS: {{ strtoupper($sale->status) }}
                </span>
                <p class="text-xs text-slate-500 mt-2">{{ auth()->user()->isPembeli() ? 'Pemesan' : 'Kasir' }}: <strong class="text-slate-800">{{ $sale->user->name ?? '-' }}</strong></p>
            </div>
        </div>

        @if($sale->notes)
        <div class="text-xs bg-slate-50 p-3 rounded-lg border border-slate-100">
            <span class="text-slate-400 uppercase font-semibold">Catatan Transaksi:</span>
            <span class="text-slate-700 ml-1">{{ $sale->notes }}</span>
        </div>
        @endif

        <!-- Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">SKU & Nama Produk</th>
                        <th class="p-3 text-center">Jumlah (Qty)</th>
                        <th class="p-3 text-right">Harga Satuan</th>
                        <th class="p-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sale->items as $item)
                    <tr>
                        <td class="p-3 text-slate-400 font-mono">{{ $loop->iteration }}</td>
                        <td class="p-3">
                            <span class="font-mono text-slate-500 block text-[11px]">{{ $item->product->sku ?? '-' }}</span>
                            <span class="font-bold text-slate-900">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                        </td>
                        <td class="p-3 text-center font-bold text-slate-800">{{ $item->quantity }} pcs</td>
                        <td class="p-3 text-right font-mono text-slate-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="p-3 text-right font-mono font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-slate-200">
                    <tr>
                        <td colspan="4" class="p-4 text-right font-bold text-sm text-slate-700 uppercase">Total Pembayaran:</td>
                        <td class="p-4 text-right font-black text-xl text-emerald-600 font-mono">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center pt-6 border-t border-slate-100 text-slate-400 text-xs">
            ☕ Terima kasih atas kunjungan Anda di <strong>Zenith Coffee & Roastery</strong>. Nikmati racikan minuman dan pastry Anda!
        </div>
    </div>
</div>
@endsection
