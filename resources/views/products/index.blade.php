@extends('layouts.app')

@section('title', 'Katalog Menu & Biji Kopi')
@section('page_title', 'Master Menu Kafe & Stok Biji Kopi')
@section('page_description', 'Kelola SKU minuman/pastry, penetapan harga jual & modal, serta pemantauan stok fisik di bar kafe.')

@section('content')
<div class="space-y-6">

    <!-- Filter & Action Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-center">
            <!-- Search SKU / Name -->
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU..."
                       class="w-full text-xs pl-3.5 pr-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
            </div>

            <!-- Filter Category -->
            <div>
                <select name="category_id" class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 font-medium">
                    <option value="">Semua Kategori Produk</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Low Stock Toggle -->
            <div class="flex items-center space-x-2.5 px-1">
                <input type="checkbox" name="low_stock" id="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}
                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                <label for="low_stock" class="text-xs font-bold text-slate-700 cursor-pointer">Hanya Stok Kritis / Habis</label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-2 justify-end">
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-md transition duration-150">
                    Terapkan Filter
                </button>
                @if(request()->anyFilled(['search', 'category_id', 'low_stock']))
                <a href="{{ route('products.index') }}" class="px-3 py-2.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl hover:bg-slate-200 transition">
                    Reset
                </a>
                @endif
            </div>
        </form>

        @if(auth()->user()->isAdmin())
        <div class="pt-3.5 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-slate-400 font-medium">Menampilkan <strong class="text-slate-700">{{ $products->total() }}</strong> total menu & bahan baku</span>
            <a href="{{ route('products.create') }}" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 via-amber-700 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-amber-600/25 transition hover:-translate-y-0.5">
                <span>☕ + Tambah Menu Baru</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="p-4">SKU / Kode</th>
                        <th class="p-4">Nama Produk</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4 text-right">Harga Modal</th>
                        <th class="p-4 text-right">Harga Jual</th>
                        <th class="p-4 text-center">Stok Fisik</th>
                        <th class="p-4 text-center">Batas Min</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/80 transition {{ $product->isLowStock() ? 'bg-amber-50/20' : '' }}">
                        <td class="p-4">
                            <span class="font-mono font-bold text-zinc-800 bg-zinc-100 px-2.5 py-1 rounded-lg border border-zinc-200">
                                {{ $product->sku }}
                            </span>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('products.show', $product) }}" class="font-extrabold text-slate-900 hover:text-emerald-600 transition block text-sm">
                                {{ $product->name }}
                            </a>
                        </td>
                        <td class="p-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 text-right font-mono text-slate-500">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                        <td class="p-4 text-right font-mono font-bold text-slate-900">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="p-4 text-center">
                            @if($product->stock <= 0)
                                <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    <span>Habis (0)</span>
                                </span>
                            @elseif($product->isLowStock())
                                <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 border border-amber-200 uppercase tracking-wider animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span>{{ $product->stock }} (Kritis)</span>
                                </span>
                            @else
                                <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span>{{ $product->stock }} unit</span>
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center font-mono text-slate-500">{{ $product->minimum_stock }}</td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('products.show', $product) }}" class="text-slate-600 hover:text-slate-900 font-bold">Detail</a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('products.edit', $product) }}" class="text-emerald-600 hover:text-emerald-800 font-bold">Ubah</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-10 text-center text-slate-400">
                            Tidak ada produk yang cocok dengan pencarian atau filter yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="p-5 border-t border-slate-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
