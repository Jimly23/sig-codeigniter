<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Geografis SMK di Wilayah Brebes Selatan – Peta persebaran Sekolah Menengah Kejuruan secara digital dan interaktif.">
    <title>SIG SMK Brebes Selatan</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary:   '#1a56db',
                        secondary: '#e3a008',
                    },
                    animation: {
                        'fade-up':   'fadeUp 0.8s ease forwards',
                        'fade-in':   'fadeIn 0.6s ease forwards',
                        'slide-in':  'slideIn 0.7s ease forwards',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%':   { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%':   { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%':   { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                    },
                }
            }
        }
    </script>

    <style>
        /* Hero overlay gradient */
        .hero-overlay {
            background: linear-gradient(
                to right,
                rgba(0,0,0,0.82) 0%,
                rgba(0,0,0,0.55) 55%,
                rgba(0,0,0,0.15) 100%
            );
        }

        /* Navbar scroll shadow */
        .navbar-scrolled {
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        }

        /* Animated underline on nav link hover */
        .nav-link::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #e3a008;
            transition: width .3s ease;
        }
        .nav-link:hover::after { width: 100%; }

        /* Scrollbar thin */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #1a56db; border-radius: 4px; }

        /* Leaflet map height */
        #map-smk {
            height: 420px;
            width: 100%;
            border-radius: 0.75rem;
            z-index: 0;
        }

        /* Stat counter animation */
        .stat-number {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        /* Custom Leaflet popup */
        .leaflet-popup-content-wrapper {
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15) !important;
        }
        .leaflet-popup-content {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            line-height: 1.6;
        }
        .popup-title {
            font-weight: 800;
            color: #1a56db;
            font-size: 14px;
            margin-bottom: 4px;
        }
        .popup-detail {
            color: #6b7280;
            font-size: 12px;
        }
    </style>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo-brebes.png') ?>">
</head>

<body class="font-sans bg-gray-50 text-gray-800 overflow-x-hidden">

<!-- ═══════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════ -->
<nav id="navbar"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">

        <!-- Logo -->
        <a href="#" class="flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white shadow-md group-hover:scale-105 transition-transform duration-200 overflow-hidden">
                <img src="<?= base_url('images/logo-brebes.png') ?>" alt="Logo Kabupaten Brebes" class="w-10 h-10 object-contain">
            </div>
            <div class="hidden sm:block">
                <p class="text-xs font-semibold text-gray-500 leading-none">SIG SMK</p>
                <p class="text-sm font-bold text-primary leading-none">Brebes Selatan</p>
            </div>
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex items-center gap-8">
            <li>
                <a href="#home" id="nav-home"
                   class="nav-link text-sm font-semibold text-gray-700 hover:text-primary pb-0.5 transition-colors duration-200">
                    Home
                </a>
            </li>
            <li>
                <a href="<?= base_url('sekolah') ?>" id="nav-data"
                   class="nav-link text-sm font-semibold text-gray-700 hover:text-primary pb-0.5 transition-colors duration-200">
                    Data Sekolah
                </a>
            </li>
            <li>
                <a href="<?= base_url('login') ?>"
                   class="inline-flex items-center justify-center px-5 py-2 text-sm font-bold text-primary bg-blue-50 border border-blue-100 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm hover:shadow">
                    Login Admin
                </a>
            </li>
        </ul>

        <!-- Mobile Hamburger -->
        <button id="menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 py-3 space-y-1">
            <a href="<?= base_url('/') ?>" class="block px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-primary transition-colors">Home</a>
            <a href="<?= base_url('sekolah') ?>" class="block px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-primary transition-colors">Data Sekolah</a>
            <div class="pt-2 mt-2 border-t border-gray-100">
                <a href="<?= base_url('login') ?>" class="block w-full text-center px-3 py-2.5 rounded-lg text-sm font-bold text-primary bg-blue-50 border border-blue-100 hover:bg-primary hover:text-white transition-all">
                    Login Admin
                </a>
            </div>
        </div>
    </div>
</nav>


<!-- ═══════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════ -->
<section id="home"
         class="relative min-h-screen flex items-center pt-16"
         style="background: url('<?= base_url('images/hero_bg.png') ?>') center center / cover no-repeat;">

    <!-- Dark overlay -->
    <div class="absolute inset-0 hero-overlay"></div>

    <!-- Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-24">
        <div class="max-w-2xl">

            <!-- Badge -->
            <div class="animate-fade-in opacity-0 inline-flex items-center gap-2 bg-secondary/20 border border-secondary/40 text-secondary text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-6"
                 style="animation-delay:0.1s; animation-fill-mode:forwards">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                Sistem Informasi Geografis
            </div>

            <!-- Subtitle -->
            <p class="animate-slide-in opacity-0 text-gray-200 text-sm sm:text-base font-semibold uppercase tracking-wider mb-2"
               style="animation-delay:0.25s; animation-fill-mode:forwards">
                Sekolah Menengah Kejuruan
            </p>

            <!-- Main Title -->
            <h1 class="animate-fade-up opacity-0 text-4xl sm:text-5xl md:text-6xl font-black text-white leading-tight mb-6"
                style="animation-delay:0.4s; animation-fill-mode:forwards">
                BREBES<br>
                <span class="text-secondary">SELATAN</span>
            </h1>

            <!-- Description -->
            <p class="animate-fade-up opacity-0 text-gray-200 text-base sm:text-lg font-medium leading-relaxed mb-8 max-w-xl"
               style="animation-delay:0.6s; animation-fill-mode:forwards">
                Sistem Informasi Ini Merupakan Website Untuk Pemetaan Geografis SMK
                Di Wilayah Brebes Selatan.
            </p>

            <!-- CTA Buttons -->
            <div class="animate-fade-up opacity-0 flex flex-wrap gap-4"
                 style="animation-delay:0.75s; animation-fill-mode:forwards">
                <a href="<?= base_url('sekolah') ?>" id="btn-lihat-data"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-primary font-bold text-sm rounded-lg shadow-xl hover:bg-primary hover:text-white border-2 border-white hover:border-primary transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Lihat Data Sekolah
                </a>
                <a href="#tentang" id="btn-tentang"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-transparent text-white font-bold text-sm rounded-lg border-2 border-white/50 hover:border-white hover:bg-white/10 transition-all duration-300 hover:-translate-y-0.5">
                    Tentang SIG
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="#peta-lokasi" id="btn-tentang"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-transparent text-white font-bold text-sm rounded-lg border-2 border-white/50 hover:border-white hover:bg-white/10 transition-all duration-300 hover:-translate-y-0.5">
                    Lihat Peta Sekolah
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <!-- Stats Row -->
            <div class="animate-fade-up opacity-0 flex flex-wrap gap-8 mt-14"
                 style="animation-delay:0.9s; animation-fill-mode:forwards">
                <div>
                    <p class="text-3xl font-black text-white">37</p>
                    <p class="text-xs text-gray-300 font-medium mt-0.5">SMK Terdaftar</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <p class="text-3xl font-black text-white">6</p>
                    <p class="text-xs text-gray-300 font-medium mt-0.5">Kecamatan</p>
                </div>
                <div class="w-px bg-white/20"></div>
                <div>
                    <p class="text-3xl font-black text-white">100<span class="text-secondary">%</span></p>
                    <p class="text-xs text-gray-300 font-medium mt-0.5">Data Akurat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom tagline bar -->
    <div class="absolute bottom-0 left-0 right-0 bg-black/60 backdrop-blur-sm py-3 px-6">
        <p class="text-center text-white font-black text-sm sm:text-base tracking-[0.25em] uppercase">
            SIAP KERJA &bull; SANTUN &bull; MANDIRI &bull; KREATIF
        </p>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-16 right-8 flex flex-col items-center gap-2 animate-bounce">
        <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     TENTANG SECTION
═══════════════════════════════════════════════ -->
<section id="tentang" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
        <div class="text-center mb-14">
            <span class="inline-block bg-blue-50 text-primary text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">Tentang Kami</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4">Apa Itu SIG SMK Brebes Selatan?</h2>
            <p class="text-gray-500 max-w-2xl mx-auto text-base leading-relaxed">
                Platform pemetaan digital yang menyajikan informasi lengkap lokasi dan profil
                Sekolah Menengah Kejuruan (SMK) di wilayah Brebes Selatan secara interaktif.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="group p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center mb-6 group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Peta Interaktif</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Visualisasi lokasi seluruh SMK pada peta digital yang mudah digunakan dan responsif.</p>
            </div>

            <!-- Card 2 -->
            <div class="group p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white">
                <div class="w-14 h-14 rounded-xl bg-yellow-50 flex items-center justify-center mb-6 group-hover:bg-secondary group-hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7 text-secondary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Data Lengkap</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Profil sekolah lengkap mencakup jurusan, alamat, kontak, dan akreditasi masing-masing SMK.</p>
            </div>

            <!-- Card 3 -->
            <div class="group p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 bg-white">
                <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:scale-110 transition-all duration-300">
                    <svg class="w-7 h-7 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Statistik & Laporan</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Grafik dan statistik persebaran SMK per kecamatan untuk kebutuhan perencanaan pendidikan.</p>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     PETA LOKASI SMK SECTION
═══════════════════════════════════════════════ -->
<section id="peta-lokasi" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">

        <!-- Header -->
        <div class="text-center mb-10">
            <span class="inline-block bg-blue-50 text-primary text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">Peta Interaktif</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">PETA LOKASI SMK</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-sm leading-relaxed">
                Temukan lokasi seluruh SMK di Wilayah Brebes Selatan secara interaktif.
                Klik marker pada peta untuk melihat detail sekolah.
            </p>
        </div>

        <!-- Map Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            <!-- Map Container -->
            <div class="relative">
                <div id="map-smk"></div>

                <!-- Detail Sekolah button — overlay pojok kanan bawah -->
                <div class="absolute bottom-4 right-4 z-[999]">
                    <a href="/sekolah" id="btn-detail-sekolah"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-primary font-bold text-sm rounded-lg shadow-lg border border-gray-200 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Detail Sekolah
                    </a>
                </div>
            </div>

            <!-- Stats Bar bawah peta -->
            <div class="flex flex-col sm:flex-row items-stretch divide-y sm:divide-y-0 sm:divide-x divide-gray-100 bg-gray-50 border-t border-gray-100">

                <!-- Stat 1 — Jangkauan Peta -->
                <div class="flex-1 flex items-center gap-4 px-8 py-5">
                    <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Jangkauan Peta</p>
                        <p class="text-lg font-black text-gray-900">Brebes <span class="text-primary">Selatan</span></p>
                        <p class="text-xs text-gray-400">Kabupaten Brebes, Jawa Tengah</p>
                    </div>
                </div>

                <!-- Stat 2 — Jumlah SMK -->
                <div class="flex-1 flex items-center gap-4 px-8 py-5">
                    <div class="w-11 h-11 rounded-xl bg-yellow-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Jumlah SMK</p>
                        <p class="text-lg font-black text-gray-900">
                            <span id="smk-count" class="stat-number">0</span>
                            <span class="text-secondary"> Sekolah</span>
                        </p>
                        <p class="text-xs text-gray-400">Tersebar di Brebes Selatan</p>
                    </div>
                </div>

                <!-- Stat 3 — Kecamatan -->
                <div class="flex-1 flex items-center gap-4 px-8 py-5">
                    <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Kecamatan</p>
                        <p class="text-lg font-black text-gray-900">
                            <span id="kec-count" class="stat-number">0</span>
                            <span class="text-green-600"> Wilayah</span>
                        </p>
                        <p class="text-xs text-gray-400">Kecamatan di Brebes Selatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     DATA SEKOLAH SECTION (placeholder/CTA)
═══════════════════════════════════════════════ -->
<section id="data-sekolah" class="py-20 bg-gradient-to-br from-primary to-blue-800">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 text-center">
        <span class="inline-block bg-white/10 text-white text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-6 border border-white/20">Data Sekolah</span>
        <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">Temukan SMK di Wilayah Brebes Selatan</h2>
        <p class="text-blue-100 max-w-xl mx-auto mb-10 text-base leading-relaxed">
            Akses data lengkap seluruh SMK: lokasi di peta, jurusan tersedia, akreditasi, dan informasi kontak.
        </p>
        <a href="/sekolah" id="btn-data-sekolah"
           class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary font-bold text-sm rounded-xl shadow-2xl hover:bg-secondary hover:text-white transition-all duration-300 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            Lihat Semua Data Sekolah
        </a>
    </div>
</section>


<!-- ═══════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════ -->
<footer class="bg-gray-900 text-gray-400 py-10">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">

            <!-- Brand -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-800 overflow-hidden">
                    <img src="<?= base_url('images/logo-brebes.png') ?>" alt="Logo Kabupaten Brebes" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <p class="text-white font-bold text-sm">SIG SMK Brebes Selatan</p>
                    <p class="text-xs text-gray-500">Sistem Informasi Geografis SMK</p>
                </div>
            </div>

            <!-- Tagline -->
            <p class="text-xs font-bold tracking-widest uppercase text-gray-500 text-center">
                SIAP KERJA &bull; SANTUN &bull; MANDIRI &bull; KREATIF
            </p>

            <!-- Copyright -->
            <p class="text-xs text-gray-600 text-center">
                &copy; <?= date('Y') ?> SIG SMK Brebes Selatan. All rights reserved.
            </p>
        </div>
    </div>
</footer>


<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<!-- ═══════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════ -->
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 10) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    // Mobile menu toggle
    const menuBtn  = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Intersection Observer for scroll animations
    const observerOptions = { threshold: 0.15 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100');
                entry.target.classList.remove('opacity-0', 'translate-y-8');
            }
        });
    }, observerOptions);

    document.querySelectorAll('section > div').forEach(el => {
        el.classList.add('transition-all', 'duration-700');
        observer.observe(el);
    });

    // ─── LEAFLET MAP ──────────────────────────────────────────
    // Koordinat pusat Brebes Selatan (Kab. Brebes, Jawa Tengah)
    const mapCenter = [-7.2200, 108.9000];

    // Deteksi ukuran layar untuk zoom dinamis (Mobile: 10, Desktop: 11)
    const initialZoom = window.innerWidth < 768 ? 10 : 11;

    const map = L.map('map-smk', {
        center: mapCenter,
        zoom: initialZoom,
        zoomSnap: 0.5,
        zoomDelta: 0.5,
        zoomControl: true,
        attributionControl: true,
    });

    // ─── TILE LAYERS ──────────────────────────────────────────
    // Satelit (Google) — default
    const satelit = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '&copy; Google Maps'
    });

    // Peta biasa (OpenStreetMap)
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    // Hybrid (Google Satellite + label)
    const hybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '&copy; Google Maps'
    });

    // Set satelit sebagai default
    satelit.addTo(map);

    // Layer control (pojok kanan atas)
    L.control.layers({
        '🛰️ Satelit': satelit,
        '🗺️ Peta': osm,
        '🌍 Hybrid': hybrid,
    }, null, { position: 'topright', collapsed: true }).addTo(map);

    // Custom marker icon
    const smkIcon = L.divIcon({
        html: `<div style="
            width:32px; height:32px; border-radius:50% 50% 50% 0;
            background:#1a56db; border:3px solid white;
            box-shadow:0 4px 12px rgba(26,86,219,0.5);
            transform:rotate(-45deg);
        "></div>`,
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -36],
        className: ''
    });

    // ─── DATA SEKOLAH DARI DATABASE ───────────────────────────
    const smkData = <?= json_encode(array_map(function($s) {
        return [
            'id'         => (int)$s['id'],
            'name'       => $s['nama'],
            'kecamatan'  => $s['kecamatan'],
            'alamat'     => $s['alamat'],
            'jurusan'    => $s['jurusan'] ?? '-',
            'akreditasi' => $s['akreditasi'] ?? '-',
            'npsn'       => $s['npsn'] ?? '-',
            'lat'        => (float)$s['latitude'],
            'lng'        => (float)$s['longitude'],
        ];
    }, $sekolah ?? [])) ?>;

    // ─── GEOJSON KECAMATAN ────────────────────────────────────
    let geoJsonLayer = null;
    let activeKecamatan = null;

    // Warna per kecamatan
    const kecamatanColors = {
        'Bumiayu':       { color: '#1a56db', fillColor: '#3b82f6' },
        'Paguyangan':    { color: '#059669', fillColor: '#10b981' },
        'Sirampog':      { color: '#dc2626', fillColor: '#ef4444' },
        'Tonjong':       { color: '#9333ea', fillColor: '#a855f7' },
        'Bantarkawung':  { color: '#ea580c', fillColor: '#f97316' },
        'Salem':         { color: '#0891b2', fillColor: '#06b6d4' },
    };

    // Load GeoJSON
    fetch('<?= base_url("data/brebes-full.geojson") ?>')
        .then(res => res.json())
        .then(data => {
            geoJsonLayer = L.geoJSON(data, {
                style: function(feature) {
                    const kecName = feature.properties.nama;
                    
                    // Khusus batas luar Brebes Selatan (jika tergambar dalam satu poligon besar)
                    if (kecName === 'Brebes Selatan') {
                        return {
                            color: '#111827', // Garis luar warna sangat gelap
                            fillColor: 'transparent',
                            fillOpacity: 0,
                            weight: 3,
                            opacity: 1,
                            dashArray: ''
                        };
                    }

                    // Untuk batas tiap kecamatan
                    const colorSet = kecamatanColors[kecName] || { color: '#6b7280', fillColor: '#9ca3af' };
                    return {
                        color: colorSet.color,
                        fillColor: colorSet.fillColor,
                        fillOpacity: 0.15,
                        weight: 2,
                        opacity: 0.8,
                        dashArray: '5, 5',
                    };
                },
                onEachFeature: function(feature, layer) {
                    const kecName = feature.properties.nama;

                    // Jangan tambahkan interaksi untuk batas luar
                    if (kecName === 'Brebes Selatan') return;

                    const colorSet = kecamatanColors[kecName] || { color: '#6b7280' };

                    // Tooltip nama kecamatan
                    layer.bindTooltip(
                        `<div style="font-family:Inter,sans-serif;font-weight:800;font-size:12px;color:${colorSet.color}">
                            📍 Kec. ${kecName}
                        </div>`,
                        { sticky: true, direction: 'top', offset: [0, -10] }
                    );

                    // Hover effect
                    layer.on('mouseover', function() {
                        if (activeKecamatan !== kecName) {
                            this.setStyle({ fillOpacity: 0.30, weight: 3, dashArray: '' });
                        }
                    });
                    layer.on('mouseout', function() {
                        if (activeKecamatan !== kecName) {
                            this.setStyle({ fillOpacity: 0.15, weight: 2, dashArray: '5, 5' });
                        }
                    });
                }
            }).addTo(map);
        })
        .catch(err => console.warn('GeoJSON load error:', err));

    // Fungsi highlight kecamatan
    function highlightKecamatan(kecName) {
        if (!geoJsonLayer) return;

        // Reset semua layer
        geoJsonLayer.eachLayer(function(layer) {
            if (layer.feature.properties.nama === 'Brebes Selatan') return;
            layer.setStyle({
                fillOpacity: 0.10,
                weight: 2,
                dashArray: '5, 5',
                opacity: 0.5,
            });
        });

        // Highlight yang dipilih
        activeKecamatan = kecName;
        geoJsonLayer.eachLayer(function(layer) {
            if (layer.feature.properties.nama === kecName) {
                layer.setStyle({
                    fillOpacity: 0.45,
                    weight: 4,
                    dashArray: '',
                    opacity: 1,
                });
                layer.bringToFront();
            }
        });
    }

    // Reset highlight
    function resetHighlight() {
        if (!geoJsonLayer) return;
        activeKecamatan = null;
        geoJsonLayer.eachLayer(function(layer) {
            if (layer.feature.properties.nama === 'Brebes Selatan') return;
            layer.setStyle({
                fillOpacity: 0.15,
                weight: 2,
                dashArray: '5, 5',
                opacity: 0.8,
            });
        });
    }

    // ─── PASANG MARKER ────────────────────────────────────────
    const markers = [];
    smkData.forEach(smk => {
        const akrColor = smk.akreditasi === 'A' ? '#15803d' :
                          smk.akreditasi === 'B' ? '#1d4ed8' :
                          smk.akreditasi === 'C' ? '#92400e' : '#6b7280';
        const akrBg    = smk.akreditasi === 'A' ? '#dcfce7' :
                          smk.akreditasi === 'B' ? '#dbeafe' :
                          smk.akreditasi === 'C' ? '#fef9c3' : '#f3f4f6';

        const popup = `
            <div style="min-width:220px;">
                <div class="popup-title">${smk.name}</div>
                <div class="popup-detail" style="margin-bottom:2px;">
                    <span style="display:inline-block;background:${akrBg};color:${akrColor};font-weight:800;font-size:10px;padding:2px 8px;border-radius:20px;">
                        Akreditasi ${smk.akreditasi}
                    </span>
                </div>
                <div class="popup-detail">📍 Kec. ${smk.kecamatan}</div>
                <div class="popup-detail">🏫 NPSN: ${smk.npsn}</div>
                <div class="popup-detail">📚 ${smk.jurusan}</div>
                <div style="margin-top:8px;padding-top:6px;border-top:1px solid #e5e7eb;">
                    <a href="/sekolah/detail/${smk.id}" style="color:#1a56db;font-weight:700;font-size:12px;text-decoration:none;">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        `;

        const marker = L.marker([smk.lat, smk.lng], { icon: smkIcon })
            .addTo(map)
            .bindPopup(popup);

        // Klik marker → zoom + highlight kecamatan
        marker.on('click', function() {
            map.flyTo([smk.lat, smk.lng], 14, { duration: 0.8 });
            highlightKecamatan(smk.kecamatan);
        });

        markers.push(marker);
    });

    // Klik di area kosong → reset
    map.on('click', function(e) {
        // Hanya reset jika tidak klik marker/popup
        if (!e.originalEvent.target.closest('.leaflet-marker-icon') &&
            !e.originalEvent.target.closest('.leaflet-popup')) {
            resetHighlight();
            map.flyTo(mapCenter, initialZoom, { duration: 0.5 });
        }
    });

    // Hitung kecamatan unik
    const kecamatanUnik = new Set(smkData.map(s => s.kecamatan)).size || 6;

    // Animasi counter
    function animateCounter(el, target, duration) {
        let start = 0;
        const step = Math.ceil(target / (duration / 30));
        const timer = setInterval(() => {
            start = Math.min(start + step, target);
            el.textContent = start;
            if (start >= target) clearInterval(timer);
        }, 30);
    }

    // Jalankan counter saat section masuk viewport
    const petaSection = document.getElementById('peta-lokasi');
    let counterDone = false;
    const petaObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !counterDone) {
                counterDone = true;
                animateCounter(document.getElementById('smk-count'), smkData.length, 800);
                animateCounter(document.getElementById('kec-count'), kecamatanUnik, 800);
                // Invalidate map size (penting jika map di dalam hidden element)
                setTimeout(() => map.invalidateSize(), 100);
            }
        });
    }, { threshold: 0.2 });
    petaObserver.observe(petaSection);
</script>

</body>
</html>
