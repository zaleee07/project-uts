<?php $__env->startSection('title', 'Portal Belanja'); ?>
<?php $__env->startSection('page_title', 'Customer Commerce Portal'); ?>
<?php $__env->startSection('page_description', 'Katalog belanja resmi, kalkulasi stok transparan, dan riwayat faktur pembayaran Anda.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-7">

    <!-- Zenith Obsidian Customer Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-zinc-950 via-zinc-900 to-zinc-950 text-white p-7 md:p-8 shadow-2xl border border-zinc-800">
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 left-1/3 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="space-y-2 max-w-xl">
                <div class="inline-flex items-center space-x-2 bg-zinc-800/80 border border-zinc-700/80 px-3 py-1 rounded-full text-[11px] font-semibold text-emerald-300">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>ZENITH VERIFIED BUYER</span>
                </div>
                <h2 class="text-2xl md:text-3xl font-display font-black tracking-tight text-white">
                    Selamat Berbelanja, <?php echo e(auth()->user()->name); ?>

                </h2>
                <p class="text-xs md:text-sm text-zinc-400 font-normal leading-relaxed">
                    Katalog kebutuhan usaha & ritel Anda dengan jaminan stok langsung dari gudang utama. Setiap transaksi menghasilkan faktur sah otomatis.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('sales.create')); ?>" 
                   class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600 hover:from-emerald-600 hover:to-cyan-700 text-zinc-950 text-xs font-black px-5 py-3 rounded-2xl shadow-lg shadow-emerald-500/25 transition hover:-translate-y-0.5 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-zinc-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>Mulai Pesanan Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 3 Kartu Metrik Khusus Pembeli -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Card 1: Total Pengeluaran Belanja Saya -->
        <div class="bg-white p-5 rounded-3xl border border-zinc-200/90 shadow-xs hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider">Total Belanja Saya</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-zinc-900 font-mono tracking-tight">
                Rp <?php echo e(number_format($myTotalSpent, 0, ',', '.')); ?>

            </h3>
            <p class="text-[11px] text-zinc-500 mt-1 font-medium">Akumulasi seluruh transaksi selesai</p>
        </div>

        <!-- Card 2: Jumlah Pesanan Saya -->
        <div class="bg-white p-5 rounded-3xl border border-zinc-200/90 shadow-xs hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider">Total Pesanan Sukses</span>
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-zinc-900 font-mono tracking-tight">
                <?php echo e(number_format($myCompletedOrdersCount)); ?> <span class="text-xs font-semibold text-zinc-400">Order</span>
            </h3>
            <p class="text-[11px] text-zinc-500 mt-1">
                <a href="<?php echo e(route('sales.index')); ?>" class="text-teal-600 font-bold hover:underline">Semua bukti belanja &rarr;</a>
            </p>
        </div>

        <!-- Card 3: Status Member / Pelanggan -->
        <div class="bg-white p-5 rounded-3xl border border-zinc-200/90 shadow-xs hover:shadow-md transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider">Status Akun</span>
                <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-xl font-black text-emerald-600 tracking-tight">
                Member Premium
            </h3>
            <p class="text-[11px] text-zinc-500 mt-1 font-medium">Akses langsung harga grosir katalog</p>
        </div>
    </div>

    <!-- Katalog Produk Siap Beli (Produk Rekomendasi) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-display font-extrabold text-zinc-900">Katalog Produk Pilihan Siap Beli</h3>
                <p class="text-xs text-zinc-500">Stok barang terverifikasi otomatis dari server gudang.</p>
            </div>
            <a href="<?php echo e(route('sales.create')); ?>" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">Formulir Pesanan Custom &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php $__empty_1 = true; $__currentLoopData = $catalogProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white p-4 rounded-3xl border border-zinc-200/80 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[10px] font-bold text-zinc-700 bg-zinc-100 px-2 py-0.5 rounded-md border border-zinc-200">
                            <?php echo e($prod->sku); ?>

                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full <?php echo e($prod->stock > 5 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'); ?>">
                            Stok: <?php echo e($prod->stock); ?>

                        </span>
                    </div>

                    <h4 class="font-bold text-xs text-zinc-900 group-hover:text-emerald-600 transition line-clamp-2">
                        <?php echo e($prod->name); ?>

                    </h4>
                    <p class="text-[10px] text-zinc-400 font-medium"><?php echo e($prod->category->name ?? 'Kategori Umum'); ?></p>
                </div>

                <div class="pt-3 mt-3 border-t border-zinc-100 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] text-zinc-400 block uppercase font-bold">Harga Satuan</span>
                        <span class="text-sm font-black font-mono text-zinc-900">Rp <?php echo e(number_format($prod->selling_price, 0, ',', '.')); ?></span>
                    </div>
                    <a href="<?php echo e(route('sales.create', ['product_id' => $prod->id])); ?>" 
                       class="inline-flex items-center space-x-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-[11px] font-bold px-3 py-1.5 rounded-xl shadow-xs transition hover:scale-105">
                        <span>+ Beli</span>
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-4 p-8 text-center text-zinc-400 bg-white rounded-3xl border border-zinc-200">
                Saat ini belum ada produk yang tersedia untuk dibeli.
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Riwayat Pesanan Belanja Saya Terbaru -->
    <div class="bg-white rounded-3xl border border-zinc-200/90 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-zinc-100 flex items-center justify-between">
            <div class="flex items-center space-x-2.5">
                <div class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></div>
                <h4 class="font-extrabold text-sm text-zinc-900">Riwayat 5 Pesanan Belanja Saya Terbaru</h4>
            </div>
            <a href="<?php echo e(route('sales.index')); ?>" class="text-xs font-bold text-emerald-600 hover:text-emerald-800">Semua Riwayat &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50/70 text-zinc-500 uppercase font-bold text-[10px] tracking-wider">
                    <tr>
                        <th class="p-3.5">No. Faktur Pesanan</th>
                        <th class="p-3.5">Waktu Belanja</th>
                        <th class="p-3.5 text-center">Jumlah Barang</th>
                        <th class="p-3.5 text-right">Total Pembayaran</th>
                        <th class="p-3.5 text-center">Status Pesanan</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 font-medium">
                    <?php $__empty_1 = true; $__currentLoopData = $myRecentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-zinc-50/80 transition">
                        <td class="p-3.5 font-mono font-bold text-emerald-600">
                            <?php echo e($order->sale_number); ?>

                        </td>
                        <td class="p-3.5 text-zinc-600"><?php echo e($order->sold_at->translatedFormat('d M Y, H:i')); ?> WIB</td>
                        <td class="p-3.5 text-center font-mono"><?php echo e($order->items->count()); ?> item</td>
                        <td class="p-3.5 text-right font-mono font-black text-zinc-900">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></td>
                        <td class="p-3.5 text-center">
                            <?php if($order->status === 'completed'): ?>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                Berhasil
                            </span>
                            <?php else: ?>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 line-through">
                                Dibatalkan
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-3.5 text-right">
                            <a href="<?php echo e(route('sales.show', $order)); ?>" class="text-emerald-600 hover:text-emerald-800 font-bold">Lihat Struk</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="p-8 text-center text-zinc-400">
                            Anda belum pernah melakukan transaksi belanja. Klik tombol <strong>"Mulai Pesanan Baru"</strong> di atas untuk berbelanja!
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/dashboard/pembeli.blade.php ENDPATH**/ ?>