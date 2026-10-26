<?php $__env->startSection('title', 'Kategori Menu Kafe'); ?>
<?php $__env->startSection('page_title', 'Master Kategori Menu Kafe'); ?>
<?php $__env->startSection('page_description', 'Kelola kelompok menu minuman espresso, signature kopi susu, non-coffee, dan artisan pastry.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <!-- Header Controls -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" action="<?php echo e(route('categories.index')); ?>" class="flex items-center space-x-2 w-full sm:w-80">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama kategori..."
                   class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-3 py-2 bg-slate-800 text-white text-xs rounded-lg hover:bg-slate-700 transition">Cari</button>
            <?php if(request('search')): ?>
            <a href="<?php echo e(route('categories.index')); ?>" class="px-2 py-2 text-slate-500 text-xs hover:text-slate-700">Reset</a>
            <?php endif; ?>
        </form>

        <a href="<?php echo e(route('categories.create')); ?>" class="inline-flex items-center space-x-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
            <span>☕ + Tambah Kategori Baru</span>
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">#</th>
                        <th class="p-3.5">Nama Kategori</th>
                        <th class="p-3.5">Deskripsi</th>
                        <th class="p-3.5 text-center">Jumlah Produk</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 text-slate-400 font-mono"><?php echo e($categories->firstItem() + $loop->index); ?></td>
                        <td class="p-3.5 font-bold text-slate-900"><?php echo e($category->name); ?></td>
                        <td class="p-3.5 text-slate-600"><?php echo e($category->description ?? '-'); ?></td>
                        <td class="p-3.5 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                <?php echo e($category->products_count); ?> Produk
                            </span>
                        </td>
                        <td class="p-3.5 text-right space-x-2">
                            <a href="<?php echo e(route('categories.edit', $category)); ?>" class="text-blue-600 hover:text-blue-800 font-medium">Ubah</a>
                            <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-400">Tidak ada kategori produk yang ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($categories->hasPages()): ?>
        <div class="p-4 border-t border-slate-100">
            <?php echo e($categories->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/categories/index.blade.php ENDPATH**/ ?>