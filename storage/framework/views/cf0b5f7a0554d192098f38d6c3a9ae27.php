<?php $__env->startSection('title', 'Ubah Pengguna'); ?>
<?php $__env->startSection('page_title', 'Ubah Data Pengguna'); ?>
<?php $__env->startSection('page_description', 'Perbarui nama, email, role, atau ubah kata sandi pengguna.'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="<?php echo e(route('users.update', $user)); ?>" method="POST" class="space-y-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
            <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required
                   class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-xs text-rose-600 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Alamat Email <span class="text-rose-500">*</span></label>
            <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required
                   class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-xs text-rose-600 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="role" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Role Hak Akses <span class="text-rose-500">*</span></label>
            <select name="role" id="role" required
                    class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <option value="pelanggan" <?php echo e(old('role', $user->role) == 'pelanggan' || old('role', $user->role) == 'pembeli' ? 'selected' : ''); ?>>Pelanggan (Order Menu Mandiri & Cek Struk Sendiri)</option>
                <option value="staff" <?php echo e(old('role', $user->role) == 'staff' ? 'selected' : ''); ?>>Staff / Barista (Kasir POS, Menu, & Pasokan Bahan)</option>
                <option value="owner" <?php echo e(old('role', $user->role) == 'owner' || old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Owner Kafe (Wewenang Penuh, Audit Finansial & User)</option>
            </select>
            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-xs text-rose-600 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="pt-2 border-t border-slate-100">
            <span class="text-[11px] text-slate-500 block mb-3 font-medium">Kosongkan kolom password di bawah jika Anda tidak ingin mengganti kata sandi.</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" id="password"
                           class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Minimal 8 karakter">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs text-rose-600 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full text-xs px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ulangi kata sandi baru">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
            <a href="<?php echo e(route('users.index')); ?>" class="text-xs px-4 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="text-xs px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-sm transition">Perbarui Pengguna</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/users/edit.blade.php ENDPATH**/ ?>