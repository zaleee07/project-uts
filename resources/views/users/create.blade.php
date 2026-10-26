@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna Baru')
@section('page_description', 'Daftarkan akun pengguna baru dan tetapkan role hak akses.')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-rose-500 @else border-slate-300 @enderror"
                   placeholder="Contoh: Rian Anggara">
            @error('name')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Alamat Email <span class="text-rose-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-rose-500 @else border-slate-300 @enderror"
                   placeholder="user@example.com">
            @error('email')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="role" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Role Hak Akses <span class="text-rose-500">*</span></label>
            <select name="role" id="role" required
                    class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 @error('role') border-rose-500 @else border-slate-300 @enderror">
                <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan (Order Menu Mandiri & Cek Struk Sendiri)</option>
                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff / Barista (Kasir POS, Menu, & Pasokan Bahan)</option>
                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner Kafe (Wewenang Penuh, Audit Finansial & User)</option>
            </select>
            @error('role')
            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi <span class="text-rose-500">*</span></label>
                <input type="password" name="password" id="password" required
                       class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-rose-500 @else border-slate-300 @enderror"
                       placeholder="Minimal 8 karakter">
                @error('password')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Ulangi kata sandi">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="{{ route('users.index') }}" class="text-xs px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="text-xs px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-sm transition">Simpan Pengguna</button>
        </div>
    </form>
</div>
@endsection
