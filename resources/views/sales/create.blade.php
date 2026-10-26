@extends('layouts.app')

@section('title', auth()->user()->isPembeli() ? 'Pemesanan Menu Kafe' : 'Kasir Kafe & POS Barista')
@section('page_title', auth()->user()->isPembeli() ? 'Formulir Pemesanan Menu Kafe' : 'Kasir / Point of Sale (POS) Barista')
@section('page_description', auth()->user()->isPembeli() ? 'Pilih menu kopi, non-coffee, atau pastry favorit Anda. Total harga dihitung transparan dan akurat.' : 'Input pesanan tamu kafe (dine-in / takeaway). Stok menu dan bahan baku berkurang secara instan.')

@section('content')
<div class="max-w-5xl mx-auto">
    <form action="{{ route('sales.store') }}" method="POST" id="saleForm" class="space-y-6">
        @csrf

        <!-- Top Header Info Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-slate-400">Informasi Struk / Order Kafe</span>
                @if(auth()->user()->isPembeli())
                <span class="text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full uppercase">
                    Metode: Order Mandiri Pelanggan
                </span>
                @else
                <span class="text-[10px] font-mono font-bold bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-full uppercase">
                    Metode: Kasir Barista POS
                </span>
                @endif
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="sold_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Waktu Pemesanan <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local" name="sold_at" id="sold_at" 
                           value="{{ old('sold_at', now()->format('Y-m-d\TH:i')) }}" required
                           class="w-full text-xs font-mono px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ auth()->user()->isPembeli() ? 'Nama Pemesan' : 'Operator Kasir' }}</label>
                    <div class="flex items-center space-x-2 px-4 py-2 bg-slate-100/80 border border-slate-200 rounded-xl">
                        <div class="w-2.5 h-2.5 rounded-full {{ auth()->user()->isPembeli() ? 'bg-emerald-500' : 'bg-amber-600' }}"></div>
                        <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] uppercase font-mono text-slate-500">({{ auth()->user()->role }})</span>
                    </div>
                </div>
            </div>

            <div>
                <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">{{ auth()->user()->isPembeli() ? 'Catatan Khusus (Contoh: Less Sugar, Less Ice)' : 'Nomor Meja / Catatan Tamu' }}</label>
                <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                       class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition"
                       placeholder="{{ auth()->user()->isPembeli() ? 'Contoh: Less sugar, extra ice, pick-up jam 14:00...' : 'Contoh: Meja 05 / Dine-In / Takeaway Bpk. Andi...' }}">
            </div>
        </div>

        <!-- Detail Items Section (Cart) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Keranjang Menu Pesanan</h3>
                    <p class="text-xs text-slate-500">Ketersediaan porsi divalidasi dan dikunci langsung dari database kafe.</p>
                </div>
                <button type="button" onclick="addItemRow()" 
                        class="inline-flex items-center space-x-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-md shadow-slate-900/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Baris Menu</span>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="itemsTable">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                        <tr>
                            <th class="p-3 w-5/12">Pilih Menu Kopi / Pastry</th>
                            <th class="p-3 w-2/12 text-center">Porsi Tersedia</th>
                            <th class="p-3 w-2/12 text-center">Qty Pesan</th>
                            <th class="p-3 w-2/12 text-right">Harga Satuan</th>
                            <th class="p-3 w-2/12 text-right">Subtotal</th>
                            <th class="p-3 w-1/12 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="itemsContainer" class="divide-y divide-slate-100 font-medium">
                        <!-- Dynamic items -->
                    </tbody>
                </table>
            </div>

            <!-- Total Checkout Ribbon -->
            <div class="pt-6 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4 bg-slate-50/60 p-5 rounded-2xl border">
                <div class="text-xs text-slate-500 max-w-sm">
                    <span class="font-bold text-slate-700 block mb-0.5">🔒 Transaksi Terenkripsi & Akurat</span>
                    Harga menu dan kalkulasi subtotal dikunci di server untuk memastikan keaslian transaksi finansial kafe.
                </div>

                <div class="text-right">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Total Tagihan Pesanan</span>
                    <span class="text-3xl font-black text-amber-700 font-mono tracking-tight block" id="grandTotalText">
                        Rp 0
                    </span>
                </div>
            </div>
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('sales.index') }}" class="text-xs font-bold px-5 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition">
                Batal
            </a>
            @if(auth()->user()->isPembeli())
            <button type="submit" 
                    class="text-xs font-extrabold px-7 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/50 hover:-translate-y-0.5 transition duration-150 uppercase tracking-wider">
                ☕ Konfirmasi & Bayar Pesanan
            </button>
            @else
            <button type="submit" 
                    class="text-xs font-extrabold px-7 py-3 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white rounded-xl shadow-lg shadow-amber-600/30 hover:shadow-amber-600/50 hover:-translate-y-0.5 transition duration-150 uppercase tracking-wider">
                ☕ Cetak Struk & Potong Stok
            </button>
            @endif
        </div>
    </form>
</div>

<script>
    const availableProducts = @json($products);
    let rowIndex = 0;

    function addItemRow(selectedProductId = '', qty = 1) {
        const container = document.getElementById('itemsContainer');
        const tr = document.createElement('tr');
        tr.className = 'item-row hover:bg-slate-50/60 transition';
        tr.id = `row-${rowIndex}`;

        let productOptions = '<option value="">-- Pilih Menu Tersedia --</option>';
        availableProducts.forEach(p => {
            const isSelected = p.id == selectedProductId ? 'selected' : '';
            productOptions += `<option value="${p.id}" data-price="${p.selling_price}" data-stock="${p.stock}" ${isSelected}>${p.sku} - ${p.name}</option>`;
        });

        tr.innerHTML = `
            <td class="p-3">
                <select name="items[${rowIndex}][product_id]" required onchange="onProductChange(this, ${rowIndex})"
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium product-select">
                    ${productOptions}
                </select>
            </td>
            <td class="p-3 text-center">
                <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-mono font-bold text-slate-700 bg-slate-100 stock-badge" id="stock-${rowIndex}">
                    -
                </span>
            </td>
            <td class="p-3 text-center">
                <input type="number" name="items[${rowIndex}][quantity]" value="${qty}" min="1" required oninput="calculateSubtotal(${rowIndex})"
                       class="w-20 text-center text-xs font-mono font-bold px-2 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 qty-input">
            </td>
            <td class="p-3 text-right font-mono text-slate-500 unit-price-text" id="price-${rowIndex}">
                Rp 0
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
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
        const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

        const row = document.getElementById(`row-${index}`);
        const badge = row.querySelector('.stock-badge');
        badge.textContent = stock + ' porsi';
        row.querySelector('.unit-price-text').textContent = 'Rp ' + price.toLocaleString('id-ID');

        const qtyInput = row.querySelector('.qty-input');
        qtyInput.setAttribute('max', stock);

        calculateSubtotal(index);
    }

    function calculateSubtotal(index) {
        const row = document.getElementById(`row-${index}`);
        if (!row) return;

        const selectElem = row.querySelector('.product-select');
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const price = parseFloat(selectedOption?.getAttribute('data-price')) || 0;
        const stock = parseInt(selectedOption?.getAttribute('data-stock')) || 0;
        const qtyInput = row.querySelector('.qty-input');
        const qty = parseFloat(qtyInput.value) || 0;
        const badge = row.querySelector('.stock-badge');

        if (qty > stock) {
            qtyInput.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-700');
            badge.classList.remove('bg-slate-100', 'text-slate-700');
            badge.classList.add('bg-rose-100', 'text-rose-700');
        } else {
            qtyInput.classList.remove('border-rose-500', 'bg-rose-50', 'text-rose-700');
            badge.classList.remove('bg-rose-100', 'text-rose-700');
            badge.classList.add('bg-slate-100', 'text-slate-700');
        }

        const subtotal = qty * price;
        row.querySelector('.subtotal-text').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            const selectElem = row.querySelector('.product-select');
            const selectedOption = selectElem.options[selectElem.selectedIndex];
            const price = parseFloat(selectedOption?.getAttribute('data-price')) || 0;
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            grandTotal += (qty * price);
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
        const initialProductId = "{{ request('product_id', '') }}";
        addItemRow(initialProductId);
        if (initialProductId) {
            const firstSelect = document.querySelector('.product-select');
            if (firstSelect) {
                onProductChange(firstSelect, 0);
            }
        }
    });
</script>
@endsection
