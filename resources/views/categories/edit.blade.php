@extends('layouts.app')

@section('title', 'Ubah Kategori')
@section('page_title', 'Ubah Kategori Produk')
@section('page_description', 'Perbarui informasi kategori produk.')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                   class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-rose-500 @else border-slate-300 @enderror">
            @error('name')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Deskripsi (Opsional)</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('categories.index') }}" class="text-xs px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="text-xs px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-sm transition">Perbarui Kategori</button>
        </div>
    </form>
</div>
@endsection
