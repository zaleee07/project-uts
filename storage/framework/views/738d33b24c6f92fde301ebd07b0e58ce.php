<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - ZENITH Coffee & Roastery</title>
    <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-sans antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-slate-800">

    <!-- Ambient Warm Glow (Teduh di Mata, Sangat Nyaman & Menawan) -->
    <div class="absolute -top-40 -left-40 w-[450px] h-[450px] bg-amber-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-[450px] h-[450px] bg-emerald-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-amber-700/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        <!-- Main Card: Bersih, Elegan, Eye-Catching -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden transition-all duration-300">
            <!-- Header Section -->
            <div class="p-8 pb-6 text-center border-b border-slate-100 bg-gradient-to-b from-amber-50/50 to-white">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-600 via-amber-500 to-amber-700 flex items-center justify-center mx-auto mb-3.5 shadow-md shadow-amber-600/30 ring-4 ring-white text-2xl">
                    ☕
                </div>
                <h2 class="font-display text-2xl font-black tracking-tight text-slate-900">ZENITH<span class="text-amber-500">.</span>COFFEE</h2>
                <p class="text-xs text-slate-500 font-medium mt-1">Smart Cafe POS, Roastery Supply & Multi-Role System</p>
                <div class="inline-flex items-center space-x-1.5 mt-3 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-[10px] font-mono font-bold text-amber-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>UTS Web Programming 2 • 3 Role Aktif</span>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8 pt-6 space-y-5">
                <?php if(session('error')): ?>
                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-3.5 rounded-xl font-medium">
                    <?php echo e(session('error')); ?>

                </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs p-3.5 rounded-xl font-medium">
                    <?php echo e(session('success')); ?>

                </div>
                <?php endif; ?>

                <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email', 'owner@example.com')); ?>" required autofocus
                               class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition duration-150 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="nama@email.com">
                        <?php $__errorArgs = ['email'];
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
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <input type="password" id="password" name="password" value="password123" required
                               class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition duration-150 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-rose-500 <?php else: ?> border-slate-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="••••••••">
                        <?php $__errorArgs = ['password'];
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

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                            <span class="font-medium">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-amber-600 via-amber-700 to-amber-800 hover:from-amber-700 hover:to-amber-900 text-white font-bold py-3.5 px-4 rounded-xl shadow-md shadow-amber-600/25 hover:shadow-lg hover:-translate-y-0.5 transition duration-150 text-xs uppercase tracking-wider">
                        Masuk ke Kafe
                    </button>
                </form>

                <!-- One Click Demo Login: 3 ROLE RESMI -->
                <div class="pt-5 border-t border-slate-100">
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest text-center mb-3">Pilih Akun Demo (Klik Langsung Terisi)</p>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Role 1: Owner -->
                        <button type="button" onclick="fillOwner()" 
                                class="p-2.5 bg-amber-50 hover:bg-amber-100/80 border border-amber-200/80 rounded-2xl text-left transition duration-150 group hover:scale-[1.02] shadow-2xs">
                            <div class="flex items-center justify-between">
                                <span class="font-black text-[11px] text-amber-900">👑 Owner</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            </div>
                            <span class="text-[9px] text-amber-700 block truncate font-mono mt-0.5">owner@ex...</span>
                            <span class="text-[8px] text-amber-600 font-mono">password123</span>
                        </button>

                        <!-- Role 2: Admin / Staff -->
                        <button type="button" onclick="fillStaff()" 
                                class="p-2.5 bg-sky-50 hover:bg-sky-100/80 border border-sky-200/80 rounded-2xl text-left transition duration-150 group hover:scale-[1.02] shadow-2xs">
                            <div class="flex items-center justify-between">
                                <span class="font-black text-[11px] text-sky-900">⚡ Staff</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                            </div>
                            <span class="text-[9px] text-sky-700 block truncate font-mono mt-0.5">staff@ex...</span>
                            <span class="text-[8px] text-sky-600 font-mono">password123</span>
                        </button>

                        <!-- Role 3: Pelanggan -->
                        <button type="button" onclick="fillPelanggan()" 
                                class="p-2.5 bg-emerald-50 hover:bg-emerald-100/80 border border-emerald-200/80 rounded-2xl text-left transition duration-150 group hover:scale-[1.02] shadow-2xs">
                            <div class="flex items-center justify-between">
                                <span class="font-black text-[11px] text-emerald-900">🛍️ Pelanggan</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            </div>
                            <span class="text-[9px] text-emerald-700 block truncate font-mono mt-0.5">pelanggan@ex...</span>
                            <span class="text-[8px] text-emerald-600 font-mono">password123</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillOwner() {
            document.getElementById('email').value = 'owner@example.com';
            document.getElementById('password').value = 'password123';
        }
        function fillStaff() {
            document.getElementById('email').value = 'staff@example.com';
            document.getElementById('password').value = 'password123';
        }
        function fillPelanggan() {
            document.getElementById('email').value = 'pelanggan@example.com';
            document.getElementById('password').value = 'password123';
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\USER\.gemini\antigravity\scratch\inventory-sales\resources\views/auth/login.blade.php ENDPATH**/ ?>