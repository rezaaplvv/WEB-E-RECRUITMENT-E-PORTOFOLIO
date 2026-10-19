<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Recruitment & E-Portofolio D3 Teknik Informatika USU')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Karir dan E-Portofolio Resmi Lulusan D3 Teknik Informatika, Fakultas Vokasi, Universitas Sumatera Utara.')">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex flex-col min-h-full font-sans text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Identity -->
                <div class="flex items-center space-x-3">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold shadow-sm group-hover:bg-blue-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <span class="block text-base font-bold text-slate-900 tracking-tight leading-none">E-Recruitment & Portofolio</span>
                            <span class="block text-xs font-medium text-slate-500 mt-1">D3 TI - Fakultas Vokasi USU</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-sm font-medium {{ request()->is('/') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('lowongan.index') }}" class="text-sm font-medium {{ request()->routeIs('lowongan.*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Lowongan Kerja
                    </a>
                    <a href="{{ route('talenta.index') }}" class="text-sm font-medium {{ request()->routeIs('talenta.*') ? 'text-blue-600 font-semibold' : 'text-slate-600 hover:text-slate-900' }} transition-colors">
                        Direktori Talenta
                    </a>
                </nav>

                <!-- Auth Actions -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        @php
                            $dashboardRoute = match(auth()->user()->role) {
                                'admin' => route('admin.dashboard'),
                                'perusahaan' => route('perusahaan.dashboard'),
                                'pelamar' => route('pelamar.dashboard'),
                                default => url('/'),
                            };
                            $roleLabel = match(auth()->user()->role) {
                                'admin' => 'Admin Prodi',
                                'perusahaan' => 'HRD Perusahaan',
                                'pelamar' => 'Mahasiswa / Alumni',
                                default => 'Pengguna',
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Buka Panel Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg transition-colors" title="Keluar">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Daftar Akun
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Toggle Button -->
                <div class="flex md:hidden">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-500 hover:text-slate-700 rounded-md focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!mobileMenuOpen">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="mobileMenuOpen" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-4 space-y-2" style="display: none;">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->is('/') ? 'text-blue-600 bg-blue-50' : 'text-slate-700 hover:bg-slate-50' }}">
                Beranda
            </a>
            <a href="{{ route('lowongan.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('lowongan.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-700 hover:bg-slate-50' }}">
                Lowongan Kerja
            </a>
            <a href="{{ route('talenta.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('talenta.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-700 hover:bg-slate-50' }}">
                Direktori Talenta
            </a>
            <div class="pt-4 border-t border-slate-200 flex flex-col space-y-2">
                @auth
                    <a href="{{ $dashboardRoute }}" class="w-full text-center py-2 px-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2 px-4 text-sm font-medium text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2 px-4 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Global Flash Notification Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between" role="alert">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between" role="alert">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 mb-4 rounded-lg bg-blue-50 border border-blue-200 text-blue-800 flex items-center justify-between" role="alert">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('info') }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Slot -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Professional Corporate Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: Identity -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white font-bold">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-base font-bold text-slate-900">E-Recruitment & E-Portofolio</span>
                    </div>
                    <p class="text-sm text-slate-600 max-w-md leading-relaxed">
                        Platform resmi penghubung dunia industri dan lulusan berkompeten Program Studi D3 Teknik Informatika, Fakultas Vokasi, Universitas Sumatera Utara.
                    </p>
                    <p class="text-xs text-slate-500">
                        Kampus Padang Bulan, Jl. Alumni No. 1, Medan, Sumatera Utara 20155
                    </p>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-900 mb-4">Navigasi</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ url('/') }}" class="text-slate-600 hover:text-blue-600 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('lowongan.index') }}" class="text-slate-600 hover:text-blue-600 transition-colors">Katalog Lowongan</a></li>
                        <li><a href="{{ route('talenta.index') }}" class="text-slate-600 hover:text-blue-600 transition-colors">Direktori Talenta</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 transition-colors">Portal Masuk</a></li>
                    </ul>
                </div>

                <!-- Col 3: Kemitraan -->
                <div>
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-900 mb-4">Kemitraan Industri</h3>
                    <p class="text-sm text-slate-600 mb-3 leading-relaxed">
                        Ingin merekrut talenta siap kerja bidang rekayasa perangkat lunak dan infrastruktur TI?
                    </p>
                    <a href="{{ route('register') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700">
                        Daftar Sebagai Mitra
                        <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Program Studi D3 Teknik Informatika - Fakultas Vokasi Universitas Sumatera Utara. Hak Cipta Dilindungi.</p>
                <p class="mt-2 sm:mt-0 font-medium">Sistem Rekrutmen Elektronik & Showcase Portofolio</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
