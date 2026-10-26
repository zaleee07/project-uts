<?php $__env->startSection('title', 'Katalog Menu & Biji Kopi'); ?>
<?php $__env->startSection('page_title', 'Master Menu Kafe & Stok Biji Kopi'); ?>
<?php $__env->startSection('page_description', 'Kelola SKU minuman/pastry, penetapan harga jual & modal, serta pemantauan stok fisik di bar kafe.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Filter & Action Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
        <form method="GET" action="<?php echo e(route('products.index')); ?>" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 items-center">
            <!-- Search SKU / Name -->
            <div class="relative">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau SKU..."
                       class="w-full text-xs pl-3.5 pr-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
            </div>

            <!-- Filter Category -->
            <div>
                <select name="category_id" class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 font-medium">
                    <option value="">Semua Kategori Produk</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Filter Low Stock Toggle -->
            <div class="flex items-center space-x-2.5 px-1">
                <input type="checkbox" name="low_stock" id="low_stock" value="1" <?php echo e(request('low_stock') ? 'checked' : ''); ?>

                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                <label for="low_stock" class="text-xs font-bold text-slate-700 cursor-pointer">Hanya Stok Kritis / Habis</label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-2 justify-end">
                <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl shadow-md transition duration-150">
                    Terapkan Filter
                </button>
                <?php if(request()->anyFilled(['search', 'category_id', 'low_stock'])): ?>
                <a href="<?php echo e(route('products.index')); ?>" class="px-3 py-2.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl hover:bg-slate-200 transition">
                    Reset
                </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if(auth()->user()->isAdmin()): ?>
        <div class="pt-3.5 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-slate-400 font-medium">Menampilkan <strong class="text-slate-700"><?php echo e($products->total()); ?></strong> total menu & bahan baku</span>
            <a href="<?php echo e(route('products.create')); ?>" class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-600 via-amber-700 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-amber-600/25 transition hover:-translate-y-0.5">
                <span>☕ + Tambah Menu Baru</span>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="p-4">SKU / Kode</th>
                        <th class="p-4">Nama Produk</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4 text-right">Harga Modal</th>
                        <th class="p-4 text-right">Harga Jual</th>
                        <th class="p-4 text-center">Stok Fisik</th>
                        <th class="p-4 text-center">Batas Min</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/80 transition <?php echo e($product->isLowStock() ? 'bg-amber-50/20' : ''); ?>">
                        <td class="p-4">
                            <span class="font-mono font-bold text-zinc-800 bg-zinc-100 px-2.5 py-1 rounded-lg border border-zinc-200">
                                <?php echo e($product->sku); ?>

                            </span>
                        </td>
                        <td class="p-4">
                            <a href="<?php echo e(route('products.show', $product)); ?>" class="font-extrabold text-slate-900 hover:text-emerald-600 transition block text-sm">
                                <?php echo e($product->name); ?>

                            </a>
                        </td>
                        <td class="p-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                <?php echo e($product->category->name ?? '-'); ?>

                            </span>
                        </td>
                        <td class="p-4 text-right font-mono text-slate-500">Rp <?php echo e(number_format($product->purchase_price, 0, ',', '.')); ?></td>
                        <td class="p-4 text-right font-mono font-bold text-slate-900">Rp <?php echo e(number_format($product->selling_price, 0, ',', '.')); ?></td>
                        <td class="p-4 text-center">
                            <?php if($product->stock <= 0): ?>
                                <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-200 uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    <span>Habis (0)</span>
                                </span>
                            <?php elseif($product->isLowStock()): ?>
                                <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 border border-amber-200 uppercase tracking-wider animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    <span><?php echo e($product->stock); ?> (Kritis)</span>
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    <span><?php echo e($product->stock); ?> unit</span>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center font-mono text-slate-500"><?php echo e($product->minimum_stock); ?></td>
                        <td class="p-4 text-right space-x-2">
                            <a href="<?php echo e(route('products.show', $product)); ?>" class="text-slate-600 hover:text-slate-900 font-bold">Detail</a>
                            <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('products.edit', $product)); ?>" class="text-emerald-600 hover:text-emerald-800 font-bold">Ubah</a>
                            <form action="<?php echo e(route('products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan produk ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="p-10 text-center text-slate-400">
                            Tidak ada produk yang cocok dengan pencarian atau filter yang dipilih.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($products->hasPages()): ?>
        <div class="p-5 border-t border-slate-100">
            <?php echo e($products->links()); ?>

        </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/products/index.blade.php ENDPATH**/ ?>