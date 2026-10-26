@extends('layouts.app')

@section('title', 'Pasokan Bahan Roastery')
@section('page_title', 'Pasokan Bahan Baku (Stock-In)')
@section('page_description', 'Riwayat penerimaan pasokan biji kopi dan bahan dari supplier roastery ke kafe.')

@section('content')
<div class="space-y-5">
    <!-- Filter and Search Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-3">
        <form method="GET" action="{{ route('purchases.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-center">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. PO atau nama supplier..."
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
                <a href="{{ route('purchases.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 text-xs rounded-lg hover:bg-slate-200 transition">
                    Reset
                </a>
                @endif
            </div>
        </form>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <a href="{{ route('purchases.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-md shadow-amber-600/20 transition hover:-translate-y-0.5">
                <span>☕ + Catat Pasokan Bahan Baru</span>
            </a>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">No. PO</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Pemasok</th>
                        <th class="p-3.5">Dibuat Oleh</th>
                        <th class="p-3.5 text-center">Jumlah Item</th>
                        <th class="p-3.5 text-right">Total Transaksi</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($purchases as $purchase)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-mono font-bold text-teal-600">
                            <a href="{{ route('purchases.show', $purchase) }}">{{ $purchase->purchase_number }}</a>
                        </td>
                        <td class="p-3.5 text-slate-600">{{ $purchase->purchased_at->format('d/m/Y H:i') }}</td>
                        <td class="p-3.5 font-semibold text-slate-800">{{ $purchase->supplier->name ?? '-' }}</td>
                        <td class="p-3.5 text-slate-600">{{ $purchase->user->name ?? '-' }}</td>
                        <td class="p-3.5 text-center font-mono">{{ $purchase->items->count() }} item</td>
                        <td class="p-3.5 text-right font-bold text-slate-900">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-center">
                            @if($purchase->status === 'completed')
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
                            <a href="{{ route('purchases.show', $purchase) }}" class="text-teal-600 hover:text-teal-800 font-bold">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400">
                            Belum ada transaksi pembelian yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($purchases->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $purchases->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
