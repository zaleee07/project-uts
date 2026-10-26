<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - ZENITH Coffee & Roastery</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk (Sangat Nyaman di Mata) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk Dropdown & Navigasi Mulus -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Space Grotesk"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        slate: {
                            850: '#172033',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        amber: {
                            850: '#78350f',
                            950: '#451a03',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col selection:bg-amber-600 selection:text-white" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">

    <!-- TOP-NAVBAR ARCHITECTURE (Teduh, Elegan, Eye-Catching & Ramah Mata) -->
    <header class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Left: Brand Logo & Role Pill -->
                <div class="flex items-center space-x-4 lg:space-x-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-600 via-amber-500 to-emerald-400 flex items-center justify-center font-black text-white text-lg shadow-md shadow-amber-600/30 group-hover:scale-105 transition duration-200 ring-2 ring-white/10">
                            ☕
                        </div>
                        <div>
                            <span class="font-display font-black text-lg tracking-wider text-white block leading-none">ZENITH<span class="text-amber-400">.</span>COFFEE</span>
                            <span class="text-[9px] text-amber-200/70 font-semibold tracking-widest uppercase block mt-0.5">SMART CAFE & ROASTERY</span>
                        </div>
                    </a>

                    <!-- Current Active Role Badge -->
                    <div class="hidden sm:inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-[11px] font-bold font-mono shadow-xs
                        @if(auth()->user()->isOwner()) bg-amber-500/15 text-amber-300 border border-amber-500/30
                        @elseif(auth()->user()->isPelanggan()) bg-emerald-500/15 text-emerald-300 border border-emerald-500/30
                        @else bg-sky-500/15 text-sky-300 border border-sky-500/30 @endif">
                        <span>
                            @if(auth()->user()->isOwner()) 👑 OWNER KAFE
                            @elseif(auth()->user()->isPelanggan()) 🛍️ PELANGGAN
                            @else ⚡ STAFF / BARISTA @endif
                        </span>
                    </div>
                </div>

                <!-- Center: Navigation Links Sesuai Role -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-1.5 text-xs font-semibold">
                    @if(auth()->user()->isPelanggan())
                        <!-- MENU KHUSUS PELANGGAN -->
                        <a href="{{ route('dashboard') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            ☕ Beranda & Menu
                        </a>
                        <a href="{{ route('sales.create') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('sales.create') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            🛍️ Pesan Online
                        </a>
                        <a href="{{ route('sales.index') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('sales.index') || request()->routeIs('sales.show') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            📄 Riwayat Pesanan Saya
                        </a>
                    @else
                        <!-- MENU OWNER & ADMIN/STAFF -->
                        <a href="{{ route('dashboard') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            📊 Ringkasan Kafe
                        </a>
                        
                        <!-- 1. Master Menu & Bahan -->
                        <a href="{{ route('products.index') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('products.*') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            ☕ Menu & Biji Kopi
                        </a>

                        @if(auth()->user()->isOwner())
                        <a href="{{ route('categories.index') }}" 
                           class="px-3 py-2 rounded-xl transition {{ request()->routeIs('categories.*') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            🏷️ Kategori Menu
                        </a>
                        <a href="{{ route('suppliers.index') }}" 
                           class="px-3 py-2 rounded-xl transition {{ request()->routeIs('suppliers.*') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            🚚 Supplier Roastery
                        </a>
                        @endif

                        <!-- 2. Alur Transaksi: In & Out -->
                        <a href="{{ route('purchases.index') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('purchases.*') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            📥 Pasokan Bahan (Stock-In)
                        </a>
                        <a href="{{ route('sales.index') }}" 
                           class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('sales.*') && !request()->routeIs('sales.create') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            ☕ Kasir & Order POS
                        </a>

                        @if(auth()->user()->isOwner())
                        <a href="{{ route('users.index') }}" 
                           class="px-3 py-2 rounded-xl transition {{ request()->routeIs('users.*') ? 'bg-amber-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            👥 Akun User
                        </a>
                        @endif
                    @endif
                </nav>

                <!-- Right: Quick CTA & User Profile -->
                <div class="flex items-center space-x-3">
                    @if(auth()->user()->isPelanggan())
                    <a href="{{ route('sales.create') }}" class="hidden sm:inline-flex items-center space-x-1.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-md shadow-emerald-500/20 transition hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>+ Pesan Menu</span>
                    </a>
                    @else
                    <a href="{{ route('sales.create') }}" class="hidden sm:inline-flex items-center space-x-1.5 bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 hover:from-amber-700 hover:to-amber-600 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-md shadow-amber-600/30 transition hover:-translate-y-0.5">
                        <span>☕ + Order Kasir Barista</span>
                    </a>
                    @endif

                    <!-- User Dropdown Menu -->
                    <div class="relative" @click.away="userDropdownOpen = false">
                        <button @click="userDropdownOpen = !userDropdownOpen" 
                                class="flex items-center space-x-2 p-1.5 rounded-xl hover:bg-slate-800 transition text-left border border-slate-700/80">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-600 to-emerald-400 flex items-center justify-center text-white font-black text-xs ring-1 ring-white/20">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden lg:block">
                                <span class="text-xs font-bold text-white block leading-tight truncate max-w-[130px]">{{ auth()->user()->name }}</span>
                                <span class="text-[9px] uppercase font-mono tracking-wider text-slate-400 font-bold">{{ auth()->user()->role }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition" :class="{'rotate-180': userDropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="userDropdownOpen" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-60 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50 text-xs text-slate-800">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-[11px] text-slate-500 font-mono truncate">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-[9px] font-extrabold uppercase rounded 
                                    @if(auth()->user()->isOwner()) bg-amber-100 text-amber-800
                                    @elseif(auth()->user()->isPelanggan()) bg-emerald-100 text-emerald-800
                                    @else bg-sky-100 text-sky-800 @endif">
                                    Role: {{ strtoupper(auth()->user()->role) }}
                                </span>
                            </div>
                            <div class="p-1.5">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-2 text-rose-600 hover:text-white hover:bg-rose-600 px-3 py-2 rounded-xl font-bold transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-slate-300 hover:text-white p-2 rounded-xl bg-slate-800 border border-slate-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-slate-900 border-b border-slate-800 px-4 pt-2 pb-4 space-y-1 text-xs font-semibold">
            @if(auth()->user()->isPelanggan())
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">☕ Beranda & Menu</a>
                <a href="{{ route('sales.create') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">🛍️ Pesan Online</a>
                <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">📄 Riwayat Pesanan Saya</a>
            @else
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">📊 Ringkasan Kafe</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">☕ Menu & Biji Kopi</a>
                @if(auth()->user()->isOwner())
                <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">🏷️ Kategori Menu</a>
                <a href="{{ route('suppliers.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">🚚 Supplier Roastery</a>
                @endif
                <a href="{{ route('purchases.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">📥 Pasokan Bahan (Stock-In)</a>
                <a href="{{ route('sales.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">☕ Kasir & Order POS</a>
                @if(auth()->user()->isOwner())
                <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-xl text-slate-300 hover:bg-slate-800">👥 Akun User</a>
                @endif
            @endif
        </div>
    </header>

    <!-- SUB-HEADER TITLE BAR (Konteks Halaman Bersih & Tenang) -->
    <div class="bg-white border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-display font-extrabold text-slate-900 tracking-tight">@yield('page_title', 'Dashboard')</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">@yield('page_description', 'Sistem Kasir & Operasional Zenith Coffee Roastery')</p>
            </div>

            <div class="flex items-center space-x-2 text-xs font-mono font-medium text-slate-600 bg-slate-100 border border-slate-200 px-3.5 py-1.5 rounded-xl">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- FLASH ALERT MESSAGES -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-5 w-full">
        @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl shadow-xs flex items-start space-x-3">
            <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="text-xs font-semibold leading-relaxed pt-0.5">{{ session('success') }}</div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl shadow-xs flex items-start space-x-3">
            <div class="w-6 h-6 rounded-lg bg-rose-600 text-white flex items-center justify-center flex-shrink-0 mt-0.5 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <div class="text-xs font-semibold leading-relaxed pt-0.5">{{ session('error') }}</div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-900 p-4 rounded-2xl shadow-xs">
            <div class="flex items-center space-x-2 font-bold text-xs mb-1.5 text-amber-800">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Mohon periksa kembali input formulir Anda:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 pl-2 text-amber-800">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <!-- MAIN APP CANVAS (Spacious, Eye-Friendly Canvas) -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-1 w-full">
        @yield('content')
    </main>

    <!-- CLEAN COFFEE OS FOOTER -->
    <footer class="bg-white border-t border-slate-200 py-4 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2 font-medium">
            <div class="flex items-center space-x-2">
                <span class="font-display font-bold text-slate-800">☕ ZENITH COFFEE & ROASTERY</span>
                <span>•</span>
                <span>3 Role: Owner Kafe, Staff Kasir/Barista, dan Pelanggan</span>
            </div>
            <div class="font-mono text-[11px] text-slate-400">
                UTS Web Programming 2 • ACID Transactions & Pessimistic Locking
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
