<?php $__env->startSection('title', 'Pengadaan Stok Baru'); ?>
<?php $__env->startSection('page_title', 'Pengadaan Stok / Pembelian (Stock-In)'); ?>
<?php $__env->startSection('page_description', 'Catat faktur penerimaan barang dari mitra supplier untuk menambah stok inventori gudang secara otomatis.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto">
    <form action="<?php echo e(route('purchases.store')); ?>" method="POST" id="purchaseForm" class="space-y-6">
        <?php echo csrf_field(); ?>

        <!-- Top Header Info Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-slate-400">Informasi Faktur Pengadaan</span>
                <span class="text-[10px] font-mono font-bold bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full uppercase">
                    Modul: Purchase Order (PO)
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="supplier_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Mitra Pemasok (Supplier) <span class="text-rose-500">*</span>
                    </label>
                    <select name="supplier_id" id="supplier_id" required
                            class="w-full text-xs px-4 py-2.5 bg-slate-50 border rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition font-medium <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Pilih Pemasok Resmi --</option>
                        <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($supplier->id); ?>" <?php echo e(old('supplier_id') == $supplier->id ? 'selected' : ''); ?>>
                            <?php echo e($supplier->name); ?> (<?php echo e($supplier->phone ?? 'Tanpa Telp'); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-rose-600 mt-1 font-medium"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="purchased_at" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Penerimaan Barang <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local" name="purchased_at" id="purchased_at" 
                           value="<?php echo e(old('purchased_at', now()->format('Y-m-d\TH:i'))); ?>" required
                           class="w-full text-xs font-mono px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Catatan PO / Nomor Resi Pengiriman</label>
                <input type="text" name="notes" id="notes" value="<?php echo e(old('notes')); ?>"
                       class="w-full text-xs px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                       placeholder="Contoh: Batch pengiriman ke-2 via Truk Ekspedisi...">
            </div>
        </div>

        <!-- Detail Items Section -->
        <div class="bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-slate-400">Rincian Barang yang Diterima</h3>
                    <p class="text-xs text-slate-500">Stok produk yang ditambahkan akan otomatis diakumulasikan ke saldo gudang.</p>
                </div>
                <button type="button" onclick="addItemRow()" 
                        class="inline-flex items-center space-x-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-md shadow-slate-900/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Baris Produk</span>
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="itemsTable">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                        <tr>
                            <th class="p-3 w-5/12">Pilih Produk</th>
                            <th class="p-3 w-2/12 text-center">Jumlah (Qty)</th>
                            <th class="p-3 w-2/12 text-right">Harga Beli Satuan</th>
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
                    <span class="font-bold text-slate-700 block mb-0.5">📦 Otomasi Perubahan Stok</span>
                    Setelah data disimpan, sistem langsung mengupdate harga beli modal terbaru dan menambah jumlah unit fisik.
                </div>

                <div class="text-right">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">Total Biaya Pengadaan</span>
                    <span class="text-3xl font-black text-blue-700 font-mono tracking-tight block" id="grandTotalText">
                        Rp 0
                    </span>
                </div>
            </div>
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex items-center justify-end space-x-3">
            <a href="<?php echo e(route('purchases.index')); ?>" class="text-xs font-bold px-5 py-3 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" 
                    class="text-xs font-extrabold px-7 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:-translate-y-0.5 transition duration-150 uppercase tracking-wider">
                Simpan Transaksi & Tambah Stok
            </button>
        </div>
    </form>
</div>

<script>
    const availableProducts = <?php echo json_encode($products, 15, 512) ?>;
    let rowIndex = 0;

    function addItemRow(selectedProductId = '', qty = 1, unitCost = '') {
        const container = document.getElementById('itemsContainer');
        const tr = document.createElement('tr');
        tr.className = 'item-row hover:bg-slate-50/60 transition';
        tr.id = `row-${rowIndex}`;

        let productOptions = '<option value="">-- Pilih Produk --</option>';
        availableProducts.forEach(p => {
            const isSelected = p.id == selectedProductId ? 'selected' : '';
            productOptions += `<option value="${p.id}" data-cost="${p.purchase_price}" ${isSelected}>${p.sku} - ${p.name} (Stok: ${p.stock})</option>`;
        });

        tr.innerHTML = `
            <td class="p-3">
                <select name="items[${rowIndex}][product_id]" required onchange="onProductChange(this, ${rowIndex})"
                        class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium product-select">
                    ${productOptions}
                </select>
            </td>
            <td class="p-3 text-center">
                <input type="number" name="items[${rowIndex}][quantity]" value="${qty}" min="1" required oninput="calculateSubtotal(${rowIndex})"
                       class="w-20 text-center text-xs font-mono font-bold px-2 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 qty-input">
            </td>
            <td class="p-3 text-right">
                <input type="number" step="100" min="0" name="items[${rowIndex}][unit_cost]" value="${unitCost}" required oninput="calculateSubtotal(${rowIndex})"
                       placeholder="0" class="w-full text-right text-xs font-mono px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 cost-input">
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
        if (unitCost !== '') {
            calculateSubtotal(rowIndex);
        }
        rowIndex++;
    }

    function onProductChange(selectElem, index) {
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const cost = selectedOption.getAttribute('data-cost') || 0;
        const row = document.getElementById(`row-${index}`);
        const costInput = row.querySelector('.cost-input');
        costInput.value = cost;
        calculateSubtotal(index);
    }

    function calculateSubtotal(index) {
        const row = document.getElementById(`row-${index}`);
        if (!row) return;

        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
        const subtotal = qty * cost;

        row.querySelector('.subtotal-text').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
            grandTotal += (qty * cost);
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/purchases/create.blade.php ENDPATH**/ ?>