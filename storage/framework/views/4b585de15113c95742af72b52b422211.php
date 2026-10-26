<?php $__env->startSection('title', 'Kelola Pengguna Kafe'); ?>
<?php $__env->startSection('page_title', 'Manajemen Pengguna & Karyawan Kafe'); ?>
<?php $__env->startSection('page_description', 'Kelola akun pengguna, hak akses 3 Role (Owner Kafe, Staff/Barista, dan Pelanggan), serta kredensial login.'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-5">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <form method="GET" action="<?php echo e(route('users.index')); ?>" class="flex items-center space-x-2 w-full sm:w-96">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama atau email..."
                   class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="role" class="text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 font-medium">
                <option value="">Semua Role</option>
                <option value="owner" <?php echo e(request('role') == 'owner' ? 'selected' : ''); ?>>Owner</option>
                <option value="staff" <?php echo e(request('role') == 'staff' ? 'selected' : ''); ?>>Staff / Barista</option>
                <option value="pelanggan" <?php echo e(request('role') == 'pelanggan' ? 'selected' : ''); ?>>Pelanggan</option>
            </select>
            <button type="submit" class="px-3 py-2 bg-slate-800 text-white text-xs rounded-lg hover:bg-slate-700 transition">Cari</button>
            <?php if(request()->anyFilled(['search', 'role'])): ?>
            <a href="<?php echo e(route('users.index')); ?>" class="px-2 py-2 text-slate-500 text-xs hover:text-slate-700">Reset</a>
            <?php endif; ?>
        </form>

        <a href="<?php echo e(route('users.create')); ?>" class="inline-flex items-center space-x-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition">
            <span>👥 + Tambah Pengguna Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="p-3.5">#</th>
                        <th class="p-3.5">Nama Lengkap</th>
                        <th class="p-3.5">Alamat Email</th>
                        <th class="p-3.5 text-center">Hak Akses Role</th>
                        <th class="p-3.5 text-slate-500">Terdaftar Sejak</th>
                        <th class="p-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 text-slate-400 font-mono"><?php echo e($users->firstItem() + $loop->index); ?></td>
                        <td class="p-3.5 font-bold text-slate-900">
                            <?php echo e($user->name); ?>

                            <?php if($user->id === auth()->id()): ?>
                            <span class="ml-1 text-[10px] text-blue-600 bg-blue-50 px-2 py-0.5 rounded font-normal">(Anda)</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-3.5 text-slate-600 font-mono"><?php echo e($user->email); ?></td>
                        <td class="p-3.5 text-center">
                            <?php if($user->role === 'owner' || $user->role === 'admin'): ?>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                👑 OWNER KAFE
                            </span>
                            <?php elseif($user->role === 'staff'): ?>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800 border border-sky-200">
                                ⚡ STAFF / BARISTA
                            </span>
                            <?php else: ?>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                🛍️ PELANGGAN
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="p-3.5 text-slate-500"><?php echo e($user->created_at->format('d M Y')); ?></td>
                        <td class="p-3.5 text-right space-x-2">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-blue-600 hover:text-blue-800 font-medium">Ubah</a>
                            <?php if($user->id !== auth()->id()): ?>
                            <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium">Hapus</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">Tidak ada data pengguna ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($users->hasPages()): ?>
        <div class="p-4 border-t border-slate-100">
            <?php echo e($users->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/users/index.blade.php ENDPATH**/ ?>