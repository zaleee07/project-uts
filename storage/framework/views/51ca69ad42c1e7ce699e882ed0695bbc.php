<?php $__env->startSection('title', 'Faktur Pembelian ' . $purchase->purchase_number); ?>
<?php $__env->startSection('page_title', 'Detail Transaksi Pembelian'); ?>
<?php $__env->startSection('page_description', 'Bukti tanda terima penerimaan barang masuk dan rekapitulasi item.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Top Action Links -->
    <div class="flex items-center justify-between">
        <a href="<?php echo e(route('purchases.index')); ?>" class="text-xs text-blue-600 hover:underline flex items-center space-x-1">
            <span>&larr; Kembali ke Riwayat Pembelian</span>
        </a>

        <?php if(auth()->user()->isAdmin() && $purchase->status === 'completed'): ?>
        <form action="<?php echo e(route('purchases.cancel', $purchase)); ?>" method="POST"
              onsubmit="return confirm('PERINGATAN: Membatalkan transaksi ini akan menarik kembali stok produk sejumlah yang telah dibeli. Lanjutkan pembatalan?')">
            <?php echo csrf_field(); ?>
            <button type="submit" class="text-xs bg-rose-50 border border-rose-300 hover:bg-rose-100 text-rose-700 font-semibold px-3.5 py-1.5 rounded-lg transition shadow-sm">
                Batalkan Transaksi Pembelian Ini
            </button>
        </form>
        <?php endif; ?>
    </div>

    <!-- Invoice Sheet -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 space-y-6">
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 border-b border-slate-100 pb-6">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Bukti Penerimaan Barang</span>
                <h2 class="text-2xl font-black text-slate-900 font-mono mt-0.5"><?php echo e($purchase->purchase_number); ?></h2>
                <p class="text-xs text-slate-500 mt-1">Dicatat pada: <?php echo e($purchase->purchased_at->translatedFormat('d F Y, H:i')); ?> WIB</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider <?php echo e($purchase->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'); ?>">
                    STATUS: <?php echo e(strtoupper($purchase->status)); ?>

                </span>
                <p class="text-xs text-slate-500 mt-2">Petugas: <strong class="text-slate-800"><?php echo e($purchase->user->name ?? '-'); ?></strong></p>
            </div>
        </div>

        <!-- Supplier & Notes -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-xl border border-slate-100">
            <div>
                <span class="text-slate-400 uppercase font-semibold block mb-0.5">Identitas Pemasok (Supplier)</span>
                <h4 class="font-bold text-slate-900 text-sm"><?php echo e($purchase->supplier->name); ?></h4>
                <p class="text-slate-600 mt-0.5"><?php echo e($purchase->supplier->phone ?? '-'); ?> | <?php echo e($purchase->supplier->email ?? '-'); ?></p>
                <p class="text-slate-500 mt-0.5"><?php echo e($purchase->supplier->address ?? '-'); ?></p>
            </div>
            <div>
                <span class="text-slate-400 uppercase font-semibold block mb-0.5">Catatan Tambahan</span>
                <p class="text-slate-700 italic"><?php echo e($purchase->notes ?? 'Tidak ada catatan.'); ?></p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">SKU & Nama Produk</th>
                        <th class="p-3 text-center">Jumlah Diterima</th>
                        <th class="p-3 text-right">Harga Beli Satuan</th>
                        <th class="p-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="p-3 text-slate-400 font-mono"><?php echo e($loop->iteration); ?></td>
                        <td class="p-3">
                            <span class="font-mono text-slate-500 block text-[11px]"><?php echo e($item->product->sku ?? '-'); ?></span>
                            <span class="font-bold text-slate-900"><?php echo e($item->product->name ?? 'Produk dihapus'); ?></span>
                        </td>
                        <td class="p-3 text-center font-bold text-slate-800"><?php echo e($item->quantity); ?> unit</td>
                        <td class="p-3 text-right font-mono text-slate-600">Rp <?php echo e(number_format($item->unit_cost, 0, ',', '.')); ?></td>
                        <td class="p-3 text-right font-mono font-bold text-slate-900">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="border-t-2 border-slate-200">
                    <tr>
                        <td colspan="4" class="p-4 text-right font-bold text-sm text-slate-700 uppercase">Total Nilai Pembelian:</td>
                        <td class="p-4 text-right font-black text-lg text-blue-600 font-mono">Rp <?php echo e(number_format($purchase->total, 0, ',', '.')); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/purchases/show.blade.php ENDPATH**/ ?>