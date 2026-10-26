@extends('layouts.app')

@section('title', 'Katalog Menu & Pesanan Pelanggan')
@section('page_title', 'Menu Kafe & Pemesanan Online')
@section('page_description', 'Pilih menu kopi susu, espresso, artisan pastry, atau biji kopi favoritmu. Pesan langsung tanpa antre dengan struk digital instan.')

@section('content')
<div class="space-y-6">

    <!-- 1. HERO BANNER PELANGGAN (Warm Coffee Ambient & Eye-Catching) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-amber-950 to-slate-900 text-white p-6 md:p-8 shadow-lg border border-slate-800">
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-amber-500/25 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 left-1/3 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="space-y-2 max-w-xl">
                <div class="inline-flex items-center space-x-2 bg-amber-500/20 border border-amber-400/30 px-3 py-1 rounded-full text-xs font-semibold text-amber-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Member Pelanggan Aktif</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-display font-black tracking-tight text-white flex items-center gap-2">
                    <span>Halo, {{ auth()->user()->name }}</span> <span>☕</span>
                </h2>
                <p class="text-xs md:text-sm text-slate-300 font-normal leading-relaxed">
                    Mau ngopi apa hari ini? Nikmati racikan espresso premium, signature kopi susu aren, atau butter croissant fresh oven. Pesan langsung di sini dan struk pesanan otomatis terbit.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('sales.create') }}" 
                   class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:from-amber-600 hover:to-amber-800 text-white text-xs font-bold px-5 py-3 rounded-2xl shadow-md shadow-amber-500/30 transition hover:-translate-y-0.5 uppercase tracking-wider">
                    <span>☕ + Pesan Kopi Sekarang</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. KARTU STATISTIK BELANJA PELANGGAN -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Total Pengeluaran Belanja Saya -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Belanja Saya</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                Rp {{ number_format($myTotalSpent, 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-slate-500 mt-1 font-medium">Akumulasi seluruh pesanan kopi & pastry Anda</p>
        </div>

        <!-- Card 2: Jumlah Pesanan Saya -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Pesanan Sukses</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <span class="text-lg">☕</span>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                {{ number_format($myCompletedOrdersCount) }} <span class="text-xs font-semibold text-slate-400">Pesanan</span>
            </h3>
            <p class="text-[11px] text-slate-500 mt-1">
                <a href="{{ route('sales.index') }}" class="text-amber-700 font-bold hover:underline">Lihat riwayat struk saya &rarr;</a>
            </p>
        </div>

        <!-- Card 3: Status Member -->
        <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Status Keanggotaan</span>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-xl font-black text-emerald-600 tracking-tight">
                Zenith Coffee VIP Member
            </h3>
            <p class="text-[11px] text-slate-500 mt-1 font-medium">Pesan mandiri tanpa perlu antre di kasir</p>
        </div>
    </div>

    <!-- 3. KATALOG MENU KAFE SIAP DIPESAN -->
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
            <div>
                <h3 class="text-base font-display font-extrabold text-slate-900">Katalog Menu & Produk Kafe</h3>
                <p class="text-xs text-slate-500">Ketersediaan menu terhubung langsung secara real-time dengan stok barista.</p>
            </div>
            <a href="{{ route('sales.create') }}" class="text-xs font-bold text-amber-700 hover:text-amber-900">Buka Formulir Pesanan &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($catalogProducts as $prod)
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[10px] font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-lg border border-amber-200/60">
                            {{ $prod->sku }}
                        </span>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $prod->stock > 5 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                            Tersedia: {{ $prod->stock }} porsi
                        </span>
                    </div>

                    <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-amber-700 transition line-clamp-1">
                        {{ $prod->name }}
                    </h4>
                    <p class="text-[11px] text-slate-500 font-medium">{{ $prod->category->name ?? 'Menu Kafe' }}</p>
                </div>

                <div class="pt-4 mt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] text-slate-400 block uppercase font-bold">Harga Menu</span>
                        <span class="text-base font-black font-mono text-slate-900">Rp {{ number_format($prod->selling_price, 0, ',', '.') }}</span>
                    </div>
                    @if($prod->stock > 0)
                    <a href="{{ route('sales.create', ['product_id' => $prod->id]) }}" 
                       class="inline-flex items-center space-x-1.5 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition hover:scale-105">
                        <span>☕ + Pesan</span>
                    </a>
                    @else
                    <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-3 py-1.5 rounded-xl cursor-not-allowed">
                        Sold Out
                    </span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 p-8 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                Saat ini belum ada menu yang tersedia untuk dipesan.
            </div>
            @endforelse
        </div>
    </div>

    <!-- 4. RIWAYAT 5 PESANAN SAYA TERBARU -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></div>
                <h4 class="font-extrabold text-sm text-slate-900">Riwayat 5 Pesanan Kopi & Pastry Terakhir</h4>
            </div>
            <a href="{{ route('sales.index') }}" class="text-xs font-bold text-amber-700 hover:text-amber-900">Semua Riwayat Pesanan &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3.5">No. Struk Pesanan</th>
                        <th class="p-3.5">Waktu Pesan</th>
                        <th class="p-3.5 text-center">Jumlah Menu</th>
                        <th class="p-3.5 text-right">Total Pembayaran</th>
                        <th class="p-3.5 text-center">Status Pesanan</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($myRecentOrders as $order)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-mono font-bold text-amber-700">
                            {{ $order->sale_number }}
                        </td>
                        <td class="p-3.5 text-slate-600">{{ $order->sold_at->translatedFormat('d M Y, H:i') }} WIB</td>
                        <td class="p-3.5 text-center font-mono">{{ $order->items->count() }} menu</td>
                        <td class="p-3.5 text-right font-mono font-black text-slate-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="p-3.5 text-center">
                            @if($order->status === 'completed')
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Berhasil
                            </span>
                            @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 line-through">
                                Dibatalkan
                            </span>
                            @endif
                        </td>
                        <td class="p-3.5 text-right">
                            <a href="{{ route('sales.show', $order) }}" class="text-amber-700 hover:text-amber-900 font-bold">Lihat Struk Digital</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">
                            Anda belum memiliki riwayat pesanan kopi. Klik tombol <strong>"☕ + Pesan Kopi Sekarang"</strong> di atas untuk memesan!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
