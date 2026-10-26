<?php $__env->startSection('title', 'Pasokan Bahan Roastery'); ?>
<?php $__env->startSection('page_title', 'Pasokan Bahan Baku (Stock-In)'); ?>
<?php $__env->startSection('page_description', 'Riwayat penerimaan pasokan biji kopi dan bahan dari supplier roastery ke kafe.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <!-- Filter and Search Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-3">
        <form method="GET" action="<?php echo e(route('purchases.index')); ?>" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-center">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari No. PO atau nama supplier..."
                       class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Start Date -->
            <div>
                <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" title="Tanggal Mulai"
                       class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- End Date -->
            <div>
                <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" title="Tanggal Akhir"
                       class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Buttons -->
            <div class="flex items-center space-x-2 justify-end">
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-xs font-semibold rounded-lg hover:bg-slate-700 transition">
                    Filter
                </button>
                <?php if(request()->anyFilled(['search', 'start_date', 'end_date', 'status'])): ?>
                <a href="<?php echo e(route('purchases.index')); ?>" class="px-3 py-2 bg-slate-100 text-slate-600 text-xs rounded-lg hover:bg-slate-200 transition">
                    Reset
                </a>
                <?php endif; ?>
            </div>
        </form>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <a href="<?php echo e(route('purchases.create')); ?>" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-md shadow-amber-600/20 transition hover:-translate-y-0.5">
                <span>☕ + Catat Pasokan Bahan Baru</span>
            </a>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">No. PO</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5">Pemasok</th>
                        <th class="p-3.5">Dibuat Oleh</th>
                        <th class="p-3.5 text-center">Jumlah Item</th>
                        <th class="p-3.5 text-right">Total Transaksi</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-mono font-bold text-teal-600">
                            <a href="<?php echo e(route('purchases.show', $purchase)); ?>"><?php echo e($purchase->purchase_number); ?></a>
                        </td>
                        <td class="p-3.5 text-slate-600"><?php echo e($purchase->purchased_at->format('d/m/Y H:i')); ?></td>
                        <td class="p-3.5 font-semibold text-slate-800"><?php echo e($purchase->supplier->name ?? '-'); ?></td>
                        <td class="p-3.5 text-slate-600"><?php echo e($purchase->user->name ?? '-'); ?></td>
                        <td class="p-3.5 text-center font-mono"><?php echo e($purchase->items->count()); ?> item</td>
                        <td class="p-3.5 text-right font-bold text-slate-900">Rp <?php echo e(number_format($purchase->total, 0, ',', '.')); ?></td>
                        <td class="p-3.5 text-center">
                            <?php if($purchase->status === 'completed'): ?>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-100 text-emerald-800">
                                Selesai
                            </span>
                            <?php else: ?>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-slate-200 text-slate-600 line-through">
                                Dibatalkan
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-3.5 text-right">
                            <a href="<?php echo e(route('purchases.show', $purchase)); ?>" class="text-teal-600 hover:text-teal-800 font-bold">Lihat Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400">
                            Belum ada transaksi pembelian yang tercatat.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($purchases->hasPages()): ?>
        <div class="p-4 border-t border-slate-100">
            <?php echo e($purchases->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/purchases/index.blade.php ENDPATH**/ ?>