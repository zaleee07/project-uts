@extends('layouts.app')

@section('title', auth()->user()->isPembeli() ? 'Riwayat Pesanan Kopi Saya' : 'Transaksi Penjualan Kasir')
@section('page_title', auth()->user()->isPembeli() ? 'Riwayat Pesanan Kopi Saya' : 'Transaksi Kasir Kafe (Point of Sale)')
@section('page_description', auth()->user()->isPembeli() ? 'Daftar struk transaksi kopi dan riwayat pembayaran Anda.' : 'Kelola transaksi kasir barista, pencetakan struk, dan pemantauan pesanan keluar.')

@section('content')
<div class="space-y-5">
    <!-- Filter and Search Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-3">
        <form method="GET" action="{{ route('sales.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-center">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="{{ auth()->user()->isPembeli() ? 'Cari No. Faktur...' : 'Cari No. Faktur atau nama kasir...' }}"
                       class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Start Date -->
            <div>
                <input type="date" name="start_date" value="{{ request('start_date') }}" title="Tanggal Mulai"
                       class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- End Date -->
            <div>
                <input type="date" name="end_date" value="{{ request('end_date') }}" title="Tanggal Akhir"
                       class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-2 justify-end">
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 transition">
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'start_date', 'end_date', 'status']))
                <a href="{{ route('sales.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 text-xs rounded-lg hover:bg-slate-200 transition">
                    Reset
                </a>
                @endif
            </div>
        </form>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            @if(auth()->user()->isPembeli())
            <a href="{{ route('sales.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                <span>☕ + Pesan Kopi Baru</span>
            </a>
            @else
            <a href="{{ route('sales.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                <span>☕ + Order Kasir Barista (POS)</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">No. Faktur</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">{{ auth()->user()->isPembeli() ? 'Pemesan' : 'Kasir / Petugas' }}</th>
                        <th class="p-3.5 text-center">Jumlah Item</th>
                        <th class="p-3.5 text-right">Total Transaksi</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sales as $sale)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-mono font-bold text-emerald-600">
                            <a href="{{ route('sales.show', $sale) }}">{{ $sale->sale_number }}</a>
                        </td>
                        <td class="p-3.5 text-slate-600">{{ $sale->sold_at->format('d/m/Y H:i') }}</td>
                        <td class="p-3.5 font-semibold text-slate-800">{{ $sale->user->name ?? '-' }}</td>
                        <td class="p-3.5 text-center font-mono">{{ $sale->items->count() }} item</td>
                        <td class="p-3.5 text-right font-bold text-slate-900">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-center">
                            @if($sale->status === 'completed')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                Selesai
                            </span>
                            @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-200 text-slate-600 line-through">
                                Dibatalkan
                            </span>
                            @endif
                        </td>
                        <td class="p-3.5 text-right">
                            <a href="{{ route('sales.show', $sale) }}" class="text-emerald-600 hover:text-emerald-800 font-bold">Lihat Faktur</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">
                            {{ auth()->user()->isPembeli() ? 'Anda belum memiliki riwayat pesanan belanja.' : 'Belum ada riwayat transaksi penjualan.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sales->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $sales->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
