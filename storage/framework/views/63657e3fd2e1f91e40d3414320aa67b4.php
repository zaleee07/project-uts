<?php $__env->startSection('title', auth()->user()->isPembeli() ? 'Riwayat Pesanan Kopi Saya' : 'Transaksi Penjualan Kasir'); ?>
<?php $__env->startSection('page_title', auth()->user()->isPembeli() ? 'Riwayat Pesanan Kopi Saya' : 'Transaksi Kasir Kafe (Point of Sale)'); ?>
<?php $__env->startSection('page_description', auth()->user()->isPembeli() ? 'Daftar struk transaksi kopi dan riwayat pembayaran Anda.' : 'Kelola transaksi kasir barista, pencetakan struk, dan pemantauan pesanan keluar.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <!-- Filter and Search Bar -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm space-y-3">
        <form method="GET" action="<?php echo e(route('sales.index')); ?>" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 items-center">
            <!-- Search -->
            <div class="md:col-span-2">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="<?php echo e(auth()->user()->isPembeli() ? 'Cari No. Faktur...' : 'Cari No. Faktur atau nama kasir...'); ?>"
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
                <a href="<?php echo e(route('sales.index')); ?>" class="px-3 py-2 bg-slate-100 text-slate-600 text-xs rounded-lg hover:bg-slate-200 transition">
                    Reset
                </a>
                <?php endif; ?>
            </div>
        </form>

        <div class="pt-3 border-t border-slate-100 flex justify-end">
            <?php if(auth()->user()->isPembeli()): ?>
            <a href="<?php echo e(route('sales.create')); ?>" class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                <span>☕ + Pesan Kopi Baru</span>
            </a>
            <?php else: ?>
            <a href="<?php echo e(route('sales.create')); ?>" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
                <span>☕ + Order Kasir Barista (POS)</span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">No. Faktur</th>
                        <th class="p-3.5">Tanggal</th>
                        <th class="p-3.5"><?php echo e(auth()->user()->isPembeli() ? 'Pemesan' : 'Kasir / Petugas'); ?></th>
                        <th class="p-3.5 text-center">Jumlah Item</th>
                        <th class="p-3.5 text-right">Total Transaksi</th>
                        <th class="p-3.5 text-center">Status</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-mono font-bold text-emerald-600">
                            <a href="<?php echo e(route('sales.show', $sale)); ?>"><?php echo e($sale->sale_number); ?></a>
                        </td>
                        <td class="p-3.5 text-slate-600"><?php echo e($sale->sold_at->format('d/m/Y H:i')); ?></td>
                        <td class="p-3.5 font-semibold text-slate-800"><?php echo e($sale->user->name ?? '-'); ?></td>
                        <td class="p-3.5 text-center font-mono"><?php echo e($sale->items->count()); ?> item</td>
                        <td class="p-3.5 text-right font-bold text-slate-900">Rp <?php echo e(number_format($sale->total, 0, ',', '.')); ?></td>
                        <td class="p-3.5 text-center">
                            <?php if($sale->status === 'completed'): ?>
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
                            <a href="<?php echo e(route('sales.show', $sale)); ?>" class="text-emerald-600 hover:text-emerald-800 font-bold">Lihat Faktur</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400">
                            <?php echo e(auth()->user()->isPembeli() ? 'Anda belum memiliki riwayat pesanan belanja.' : 'Belum ada riwayat transaksi penjualan.'); ?>

                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($sales->hasPages()): ?>
        <div class="p-4 border-t border-slate-100">
            <?php echo e($sales->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/sales/index.blade.php ENDPATH**/ ?>