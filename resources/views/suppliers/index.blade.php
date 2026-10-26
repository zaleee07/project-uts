@extends('layouts.app')

@section('title', 'Supplier Roastery & Bahan')
@section('page_title', 'Mitra Supplier Roastery & Bahan Baku')
@section('page_description', 'Kelola direktori roastery biji kopi, peternakan dairy susu, dan distributor bahan kafe.')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('suppliers.index') }}" class="flex items-center space-x-2 w-full sm:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, telp..."
                   class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-3 py-2 bg-slate-800 text-white text-xs rounded-lg hover:bg-slate-700 transition">Cari</button>
            @if(request('search'))
            <a href="{{ route('suppliers.index') }}" class="px-2 py-2 text-slate-500 text-xs hover:text-slate-700">Reset</a>
            @endif
        </form>

        <a href="{{ route('suppliers.create') }}" class="inline-flex items-center space-x-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
            <span>🚚 + Tambah Supplier Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">#</th>
                        <th class="p-3.5">Nama Supplier</th>
                        <th class="p-3.5">Kontak & Email</th>
                        <th class="p-3.5">Alamat</th>
                        <th class="p-3.5 text-center">Transaksi PO</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 text-slate-400 font-mono">{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td class="p-3.5 font-bold text-slate-900">{{ $supplier->name }}</td>
                        <td class="p-3.5">
                            <div class="text-slate-800 font-medium">{{ $supplier->phone ?? '-' }}</div>
                            <div class="text-slate-500 text-[11px]">{{ $supplier->email ?? '-' }}</div>
                        </td>
                        <td class="p-3.5 text-slate-600 max-w-xs truncate">{{ $supplier->address ?? '-' }}</td>
                        <td class="p-3.5 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $supplier->purchases_count }} Pembelian
                            </span>
                        </td>
                        <td class="p-3.5 text-right space-x-2">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="text-blue-600 hover:text-blue-800 font-medium">Ubah</a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">Tidak ada pemasok yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $suppliers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
