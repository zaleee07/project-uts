<?php $__env->startSection('title', auth()->user()->isOwner() ? 'Dashboard Eksekutif Owner' : 'Dashboard Operasional Staff & Barista'); ?>
<?php $__env->startSection('page_title', auth()->user()->isOwner() ? 'Ringkasan Eksekutif Kafe & Kinerja Bisnis' : 'Pusat Kendali Operasional Barista & Kasir'); ?>
<?php $__env->startSection('page_description', auth()->user()->isOwner() ? 'Pantau total omset penjualan kopi, perputaran stok bahan baku roastery, dan laba operasional secara menyeluruh.' : 'Kelola penerimaan pasokan biji kopi, pemantauan bahan menipis, dan transaksi kasir POS harian.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- 1. HERO WELCOME BANNER (Eye-Catching, Warm & Teduh) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-amber-950 to-slate-900 text-white p-6 md:p-8 shadow-lg border border-slate-800">
        <!-- Ambient Warm Glow -->
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 left-1/3 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-5">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md border border-white/20 px-3 py-1 rounded-full text-xs font-semibold text-slate-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Hak Akses: <strong class="text-white"><?php echo e(strtoupper(auth()->user()->role)); ?></strong></span>
                </div>
                <h2 class="text-2xl md:text-3xl font-display font-black tracking-tight text-white flex items-center gap-2">
                    <span>Selamat Datang di Zenith Coffee, <?php echo e(auth()->user()->name); ?></span> <span>☕</span>
                </h2>
                <p class="text-xs md:text-sm text-slate-300 font-normal leading-relaxed">
                    <?php if(auth()->user()->isOwner()): ?>
                        Anda memiliki hak akses penuh sebagai <strong>Owner Kafe</strong> untuk mengaudit perputaran kasir, valuasi aset biji kopi & pastry, serta mengelola seluruh akun karyawan dan pelanggan.
                    <?php else: ?>
                        Anda bertugas sebagai <strong>Staff / Barista</strong> untuk melayani pesanan kasir POS, mencatat pasokan bahan baku dari supplier roastery, dan memantau stok menu yang menipis.
                    <?php endif; ?>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="<?php echo e(route('sales.create')); ?>" 
                   class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 hover:from-amber-700 hover:to-amber-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-amber-600/30 transition hover:-translate-y-0.5">
                    <span>☕ + Order Kasir Barista</span>
                </a>
                <a href="<?php echo e(route('purchases.create')); ?>" 
                   class="inline-flex items-center space-x-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold px-4 py-2.5 rounded-xl backdrop-blur-md transition hover:-translate-y-0.5">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>+ Pasok Bahan (Stock-In)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. PETA ALUR KERJA BISNIS KAFE (Interactive Visual Business Flow) -->
    <!-- Sangat Mudah Dipahami dan Dipresentasikan ke Dosen -->
    <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-200/90 shadow-sm space-y-3">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 border-b border-slate-100 pb-3">
            <div>
                <span class="text-[11px] font-extrabold uppercase tracking-widest text-amber-700 font-mono">Peta Alur Kerja Kafe (End-to-End Coffee POS Workflow)</span>
                <h3 class="text-sm font-extrabold text-slate-900">Alur Terintegrasi: Dari Pasokan Biji Kopi hingga Penjualan Kasir</h3>
            </div>
            <span class="text-xs text-slate-400 font-medium">Klik kotak tahap untuk langsung menuju modul &rarr;</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3.5 pt-1">
            <!-- Tahap 1: Pengadaan Bahan Baku -->
            <a href="<?php echo e(route('purchases.create')); ?>" class="p-4 rounded-2xl bg-slate-50 hover:bg-amber-50/60 border border-slate-200 hover:border-amber-300 transition group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-6 h-6 rounded-lg bg-amber-600 text-white font-mono font-bold text-xs flex items-center justify-center">1</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 bg-amber-100 px-2 py-0.5 rounded-md">Stock-In</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 group-hover:text-amber-800 transition">Pasokan Bahan Roastery</h4>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Supplier kirim biji kopi & susu &rarr; staf input nota &rarr; <strong class="text-emerald-700">stok bahan baku fisik bertambah</strong> di kafe.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-200/60 text-[11px] font-bold text-amber-800 flex items-center space-x-1">
                    <span>Input Pasokan Bahan</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Tahap 2: Manajemen Menu & Stok -->
            <a href="<?php echo e(route('products.index')); ?>" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/60 border border-slate-200 hover:border-emerald-300 transition group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-mono font-bold text-xs flex items-center justify-center">2</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">Menu Kafe</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 group-hover:text-emerald-700 transition">Katalog Menu & Biji Kopi</h4>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Mencatat SKU menu, harga modal vs harga jual, serta mendeteksi otomatis jika ada <strong class="text-amber-700">bahan kritis / habis</strong>.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-200/60 text-[11px] font-bold text-emerald-700 flex items-center space-x-1">
                    <span>Lihat Stok Menu</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Tahap 3: Kasir POS & Pelanggan -->
            <a href="<?php echo e(route('sales.create')); ?>" class="p-4 rounded-2xl bg-slate-50 hover:bg-sky-50/60 border border-slate-200 hover:border-sky-300 transition group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-6 h-6 rounded-lg bg-sky-600 text-white font-mono font-bold text-xs flex items-center justify-center">3</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-sky-700 bg-sky-100 px-2 py-0.5 rounded-md">Stock-Out</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 group-hover:text-sky-700 transition">Kasir Barista & Order Tamu</h4>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Tamu pesan kopi/pastry &rarr; sistem lock stok &rarr; <strong class="text-rose-600">stok menu terpotong instan</strong> & nota cetak.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-200/60 text-[11px] font-bold text-sky-700 flex items-center space-x-1">
                    <span>Buka Kasir POS</span>
                    <span>&rarr;</span>
                </div>
            </a>

            <!-- Tahap 4: Laporan & Audit Owner -->
            <a href="<?php echo e(route('sales.index')); ?>" class="p-4 rounded-2xl bg-slate-50 hover:bg-purple-50/60 border border-slate-200 hover:border-purple-300 transition group flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="w-6 h-6 rounded-lg bg-purple-600 text-white font-mono font-bold text-xs flex items-center justify-center">4</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-purple-800 bg-purple-100 px-2 py-0.5 rounded-md">Owner Audit</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-slate-900 group-hover:text-purple-800 transition">Audit Omset & Keuangan</h4>
                    <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">
                        Owner memantau rekap omset harian, modal bahan, dan mutasi arus kas kafe secara akurat tanpa manipulasi.
                    </p>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-200/60 text-[11px] font-bold text-purple-800 flex items-center space-x-1">
                    <span>Rekap Penjualan</span>
                    <span>&rarr;</span>
                </div>
            </a>
        </div>
    </div>

    <!-- 3. KARTU STATISTIK METRIK (Elegan, Lembut & Jelas) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Omset Hari Ini -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Omset Kasir Hari Ini</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                Rp <?php echo e(number_format($salesToday, 0, ',', '.')); ?>

            </h3>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-medium">Bulan Berjalan:</span>
                <span class="font-mono font-bold text-emerald-600">Rp <?php echo e(number_format($salesThisMonth, 0, ',', '.')); ?></span>
            </div>
        </div>

        <!-- Card 2: Total Menu / Valuasi Aset -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">
                    <?php echo e(auth()->user()->isOwner() ? 'Valuasi Stok Bahan Baku' : 'Total Menu Kafe'); ?>

                </span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center group-hover:scale-110 transition">
                    <span class="text-lg">☕</span>
                </div>
            </div>
            <?php if(auth()->user()->isOwner()): ?>
            <h3 class="text-2xl font-black text-amber-800 font-mono tracking-tight">
                Rp <?php echo e(number_format($totalInventoryValue, 0, ',', '.')); ?>

            </h3>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-medium">Total Menu & Bahan:</span>
                <span class="font-mono font-bold text-slate-700"><?php echo e($totalProducts); ?> SKU Menu</span>
            </div>
            <?php else: ?>
            <h3 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                <?php echo e(number_format($totalProducts)); ?> <span class="text-xs font-semibold text-slate-400">SKU</span>
            </h3>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-medium">Status Menu:</span>
                <a href="<?php echo e(route('products.index')); ?>" class="font-bold text-amber-700 hover:underline">Kelola Menu &rarr;</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Card 3: Total Transaksi Terproses -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Transaksi</span>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black text-slate-900 font-mono tracking-tight">
                <?php echo e(number_format($totalSalesCount + $totalPurchasesCount)); ?>

            </h3>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-mono">Penjualan: <?php echo e($totalSalesCount); ?></span>
                <span class="text-slate-500 font-mono">Pasokan: <?php echo e($totalPurchasesCount); ?></span>
            </div>
        </div>

        <!-- Card 4: Peringatan Stok Kritis -->
        <div class="bg-white p-5 rounded-2xl border <?php echo e($lowStockCount > 0 ? 'border-amber-300 bg-amber-50/20' : 'border-slate-200/90'); ?> shadow-sm hover:shadow-md transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Menu Menipis / Kritis</span>
                <div class="w-10 h-10 rounded-xl <?php echo e($lowStockCount > 0 ? 'bg-amber-100 text-amber-600 animate-pulse' : 'bg-slate-100 text-slate-400'); ?> flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <h3 class="text-2xl font-black <?php echo e($lowStockCount > 0 ? 'text-amber-600' : 'text-slate-900'); ?> font-mono tracking-tight">
                <?php echo e(number_format($lowStockCount)); ?> <span class="text-xs font-semibold text-slate-400">SKU</span>
            </h3>
            <div class="mt-2 pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-medium">Perlu Tindakan:</span>
                <a href="<?php echo e(route('products.index', ['low_stock' => 1])); ?>" class="font-bold text-amber-700 hover:underline">Periksa Detail &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 4. LOW STOCK ALERT BANNER (Jika Ada Menu / Bahan Menipis) -->
    <?php if($lowStockProducts->count() > 0): ?>
    <div class="bg-amber-50/70 border border-amber-200 rounded-3xl p-6 shadow-xs">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-sm text-slate-900">Perhatian: Stok Bahan Baku / Menu Berada di Bawah Batas Minimum!</h4>
                    <p class="text-xs text-slate-500">Segera pesan pasokan ke supplier roastery untuk mencegah kehabisan menu di kasir.</p>
                </div>
            </div>
            <a href="<?php echo e(route('purchases.create')); ?>" 
               class="text-xs bg-amber-600 hover:bg-amber-700 text-white font-bold px-4 py-2 rounded-xl shadow-sm transition hover:-translate-y-0.5 flex-shrink-0">
                + Pasok Bahan ke Supplier
            </a>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-amber-200/80 bg-white">
            <table class="w-full text-left text-xs">
                <thead class="bg-amber-50/80 text-slate-600 font-bold uppercase tracking-wider border-b border-amber-200/60">
                    <tr>
                        <th class="p-3">Kode SKU</th>
                        <th class="p-3">Nama Menu / Produk</th>
                        <th class="p-3">Kategori</th>
                        <th class="p-3 text-center">Sisa Stok Fisik</th>
                        <th class="p-3 text-center">Batas Minimum</th>
                        <th class="p-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-amber-100 font-medium">
                    <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-amber-50/40 transition">
                        <td class="p-3 font-mono font-bold text-slate-700"><?php echo e($p->sku); ?></td>
                        <td class="p-3 font-extrabold text-slate-900"><?php echo e($p->name); ?></td>
                        <td class="p-3 text-slate-500"><?php echo e($p->category->name ?? '-'); ?></td>
                        <td class="p-3 text-center font-mono font-black <?php echo e($p->stock <= 0 ? 'text-rose-600' : 'text-amber-600'); ?>">
                            <?php echo e($p->stock); ?> porsi / pcs
                        </td>
                        <td class="p-3 text-center font-mono text-slate-500"><?php echo e($p->minimum_stock); ?> unit</td>
                        <td class="p-3 text-center">
                            <?php if($p->stock <= 0): ?>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 uppercase tracking-wider">
                                Sold Out (0)
                            </span>
                            <?php else: ?>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase tracking-wider animate-pulse">
                                Kritis
                            </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- 5. TABEL RIWAYAT TRANSAKSI TERAKHIR (2 Kolom Bersih) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Sales -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <div class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></div>
                    <h4 class="font-extrabold text-sm text-slate-900">Transaksi Kasir Terakhir (Order Masuk)</h4>
                </div>
                <a href="<?php echo e(route('sales.index')); ?>" class="text-xs font-bold text-amber-700 hover:text-amber-900">Semua Order &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                        <tr>
                            <th class="p-3.5">No. Struk</th>
                            <th class="p-3.5">Kasir / Pemesan</th>
                            <th class="p-3.5 text-right">Total Tagihan</th>
                            <th class="p-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3.5 font-mono font-bold text-amber-700">
                                <a href="<?php echo e(route('sales.show', $sale)); ?>" class="hover:underline"><?php echo e($sale->sale_number); ?></a>
                            </td>
                            <td class="p-3.5 text-slate-700 font-medium"><?php echo e($sale->user->name ?? '-'); ?></td>
                            <td class="p-3.5 text-right font-mono font-black text-slate-900">Rp <?php echo e(number_format($sale->total, 0, ',', '.')); ?></td>
                            <td class="p-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo e($sale->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-500 line-through'); ?>">
                                    <?php echo e($sale->status); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-400">Belum ada transaksi penjualan tercatat.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Purchases -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <div class="w-3 h-3 rounded-full bg-amber-600 ring-4 ring-amber-100"></div>
                    <h4 class="font-extrabold text-sm text-slate-900">Pasokan Bahan Roastery Terakhir</h4>
                </div>
                <a href="<?php echo e(route('purchases.index')); ?>" class="text-xs font-bold text-amber-700 hover:text-amber-900">Semua Pasokan &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                        <tr>
                            <th class="p-3.5">No. PO</th>
                            <th class="p-3.5">Supplier</th>
                            <th class="p-3.5 text-right">Total Biaya</th>
                            <th class="p-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentPurchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3.5 font-mono font-bold text-amber-700">
                                <a href="<?php echo e(route('purchases.show', $purchase)); ?>" class="hover:underline"><?php echo e($purchase->purchase_number); ?></a>
                            </td>
                            <td class="p-3.5 text-slate-700 font-medium"><?php echo e($purchase->supplier->name ?? '-'); ?></td>
                            <td class="p-3.5 text-right font-mono font-black text-slate-900">Rp <?php echo e(number_format($purchase->total, 0, ',', '.')); ?></td>
                            <td class="p-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider <?php echo e($purchase->status === 'completed' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-500 line-through'); ?>">
                                    <?php echo e($purchase->status); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-400">Belum ada transaksi pasokan tercatat.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/dashboard/index.blade.php ENDPATH**/ ?>