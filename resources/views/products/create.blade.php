@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page_title', 'Tambah Produk Baru')
@section('page_description', 'Daftarkan SKU baru, kategori, harga modal & jual, serta batas minimum stok.')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="sku" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kode SKU <span class="text-rose-500">*</span></label>
                <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                       class="w-full text-xs font-mono px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sku') border-rose-500 @else border-slate-300 @enderror"
                       placeholder="Contoh: ELK-CHG-65W">
                @error('sku')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kategori Produk <span class="text-rose-500">*</span></label>
                <select name="category_id" id="category_id" required
                        class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-rose-500 @else border-slate-300 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Produk <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-rose-500 @else border-slate-300 @enderror"
                   placeholder="Contoh: Fast Charger GaN 65W Type-C">
            @error('name')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="purchase_price" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga Beli / Modal (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" step="100" min="0" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', 0) }}" required
                       class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('purchase_price') border-rose-500 @else border-slate-300 @enderror">
                @error('purchase_price')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="selling_price" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                <input type="number" step="100" min="0" name="selling_price" id="selling_price" value="{{ old('selling_price', 0) }}" required
                       class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('selling_price') border-rose-500 @else border-slate-300 @enderror">
                @error('selling_price')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="stock" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Stok Awal Fisik</label>
                <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', 0) }}"
                       class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="minimum_stock" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Batas Minimum Stok (Alert) <span class="text-rose-500">*</span></label>
                <input type="number" min="0" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 5) }}" required
                       class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('minimum_stock') border-rose-500 @else border-slate-300 @enderror">
                @error('minimum_stock')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('products.index') }}" class="text-xs px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="text-xs px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-sm transition">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection
