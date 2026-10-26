@extends('layouts.app')

@section('title', 'Pasokan Bahan Roastery (Stock-In)')
@section('page_title', 'Pasokan Bahan Baku & Biji Kopi (Stock-In)')
@section('page_description', 'Catat nota penerimaan biji kopi, susu segar, dan bahan pastry dari supplier roastery untuk menambah saldo stok kafe secara otomatis.')

@section('content')
<div class="max-w-5xl mx-auto">
    <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm" class="space-y-6">
        @csrf

        <!-- Top Header Info Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-slate-400">Informasi Faktur Pasokan Bahan</span>
                <span class="text-[10px] font-mono font-bold bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-full uppercase">
                    Modul: Purchase Order (PO)
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="supplier_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Mitra Supplier Roastery & Bahan <span class="text-rose-500">*</span>
                    </label>
                    <select name="supplier_id" id="supplier_id" required
                            class="w-full text-xs px-4 py-2.5 bg-slate-50 border rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition font-medium @error('supplier_id') border-rose-500 @else border-slate-300 @enderror">
                        <option value="">-- Pilih Supplier Resmi --</option>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }} ({{ $supplier->phone ?? 'Tanpa Telp' }})
                        </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="purchased_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Penerimaan Bahan <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local" name="purchased_at" id="purchased_at" 
                           value="{{ old('purchased_at', now()->format('Y-m-d\TH:i')) }}" required
                           class="w-full text-xs font-mono px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan Pengiriman / No. Surat Jalan Supplier</label>
                <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                       class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition"
                       placeholder="Contoh: Pasokan mingguan biji kopi Gayo & susu segar batch Lembang...">
            </div>
        </div>

        <!-- Detail Items Section -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Rincian Bahan Baku yang Diterima</h3>
                    <p class="text-xs text-slate-500">Jumlah porsi/stok yang dicatat akan langsung diakumulasikan ke saldo gudang kafe.</p>
                </div>
                <button type="button" onclick="addItemRow()" 
                        class="inline-flex items-center space-x-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-md shadow-slate-900/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Baris Bahan</span>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="itemsTable">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                        <tr>
                            <th class="p-3 w-5/12">Pilih Menu / Bahan Baku</th>
                            <th class="p-3 w-2/12 text-center">Jumlah (Qty Masuk)</th>
                            <th class="p-3 w-2/12 text-right">Harga Modal Beli</th>
                            <th class="p-3 w-2/12 text-right">Subtotal</th>
                            <th class="p-3 w-1/12 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="itemsContainer" class="divide-y divide-slate-100 font-medium">
                        <!-- Dynamic rows inserted here -->
                    </tbody>
                </table>
            </div>

            <!-- Grand Total Ribbon -->
            <div class="pt-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4 bg-slate-50/60 p-5 rounded-2xl border">
                <div class="text-xs text-slate-500 max-w-sm">
                    <span class="font-bold text-slate-700 block mb-0.5">📦 Otomasi Perhitungan Stok Kafe</span>
                    Sistem langsung memperbarui harga modal beli rata-rata dan menambah kuantitas stok menu seketika.
                </div>

                <div class="text-right">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Total Biaya Pasokan</span>
                    <span class="text-3xl font-black text-amber-800 font-mono tracking-tight block" id="grandTotalText">
                        Rp 0
                    </span>
                </div>
            </div>
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('purchases.index') }}" class="text-xs font-bold px-5 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" 
                    class="text-xs font-extrabold px-7 py-3 bg-gradient-to-r from-amber-600 via-amber-700 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white rounded-xl shadow-lg shadow-amber-600/30 hover:shadow-amber-600/50 hover:-translate-y-0.5 transition duration-150 uppercase tracking-wider">
                Simpan Pasokan & Tambah Stok
            </button>
        </div>
    </form>
</div>

<script>
    const availableProducts = @json($products);
    let rowIndex = 0;

    function addItemRow(selectedProductId = '', qty = 1, unitCost = '') {
        const container = document.getElementById('itemsContainer');
        const tr = document.createElement('tr');
        tr.className = 'item-row hover:bg-slate-50/60 transition';
        tr.id = `row-${rowIndex}`;

        let productOptions = '<option value="">-- Pilih Menu / Bahan --</option>';
        availableProducts.forEach(p => {
            const isSelected = p.id == selectedProductId ? 'selected' : '';
            productOptions += `<option value="${p.id}" data-cost="${p.purchase_price}" ${isSelected}>${p.sku} - ${p.name}</option>`;
        });

        tr.innerHTML = `
            <td class="p-3">
                <select name="items[${rowIndex}][product_id]" required onchange="onProductChange(this, ${rowIndex})"
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium product-select">
                    ${productOptions}
                </select>
            </td>
            <td class="p-3 text-center">
                <input type="number" name="items[${rowIndex}][quantity]" value="${qty}" min="1" required oninput="calculateSubtotal(${rowIndex})"
                       class="w-24 text-center text-xs font-mono font-bold px-2 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 qty-input">
            </td>
            <td class="p-3 text-right">
                <div class="relative inline-block w-36">
                    <span class="absolute left-3 top-2 text-[10px] font-mono text-slate-400">Rp</span>
                    <input type="number" name="items[${rowIndex}][unit_cost]" value="${unitCost}" min="0" step="100" required oninput="calculateSubtotal(${rowIndex})"
                           class="w-full pl-8 pr-3 py-2 text-right text-xs font-mono font-bold bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 unit-cost-input">
                </div>
            </td>
            <td class="p-3 text-right font-mono font-black text-slate-900 subtotal-text text-sm" id="subtotal-${rowIndex}">
                Rp 0
            </td>
            <td class="p-3 text-center">
                <button type="button" onclick="removeRow(${rowIndex})" class="text-rose-400 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </td>
        `;

        container.appendChild(tr);
        rowIndex++;
    }

    function onProductChange(selectElem, index) {
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const cost = selectedOption.getAttribute('data-cost');
        const row = document.getElementById(`row-${index}`);
        const costInput = row.querySelector('.unit-cost-input');

        if (cost && (!costInput.value || costInput.value == '0')) {
            costInput.value = cost;
        }

        calculateSubtotal(index);
    }

    function calculateSubtotal(index) {
        const row = document.getElementById(`row-${index}`);
        if (!row) return;

        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const unitCost = parseFloat(row.querySelector('.unit-cost-input').value) || 0;
        const subtotal = qty * unitCost;

        row.querySelector('.subtotal-text').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const unitCost = parseFloat(row.querySelector('.unit-cost-input').value) || 0;
            grandTotal += (qty * unitCost);
        });

        document.getElementById('grandTotalText').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    function removeRow(index) {
        const row = document.getElementById(`row-${index}`);
        if (row) {
            row.remove();
            calculateGrandTotal();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        addItemRow();
    });
</script>
@endsection
