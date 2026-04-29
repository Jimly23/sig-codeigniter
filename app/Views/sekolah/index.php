<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar seluruh SMK di Wilayah Brebes Selatan – Sistem Informasi Geografis SMK.">
    <title>Detail Data SMK – SIG SMK Brebes Selatan</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary:   '#1a56db',
                        secondary: '#e3a008',
                    },
                }
            }
        }
    </script>

    <style>
        .navbar-scrolled { box-shadow: 0 4px 24px rgba(0,0,0,0.12); }
        .nav-link::after { content:''; display:block; width:0; height:2px; background:#e3a008; transition:width .3s; }
        .nav-link:hover::after { width:100%; }
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-thumb { background:#1a56db; border-radius:4px; }

        /* Baris tabel zebra */
        tbody tr:nth-child(odd)  { background:#f8faff; }
        tbody tr:nth-child(even) { background:#ffffff; }
        tbody tr:hover           { background:#eff6ff; }

        /* Badge akreditasi */
        .badge-A { background:#dcfce7; color:#15803d; }
        .badge-B { background:#dbeafe; color:#1d4ed8; }
        .badge-C { background:#fef9c3; color:#92400e; }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800 overflow-x-hidden">

<!-- ═══════════════════ NAVBAR ═══════════════════ -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">

        <!-- Logo -->
        <a href="<?= base_url('/') ?>" class="flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white shadow-md group-hover:scale-105 transition-transform overflow-hidden">
                <img src="<?= base_url('images/logo-brebes.png') ?>" alt="Logo Brebes" class="w-10 h-10 object-contain">
            </div>
            <div class="hidden sm:block">
                <p class="text-xs font-semibold text-gray-500 leading-none">SIG SMK</p>
                <p class="text-sm font-bold text-primary leading-none">Brebes Selatan</p>
            </div>
        </a>

        <!-- Menu Desktop -->
        <ul class="hidden md:flex items-center gap-8">
            <li><a href="<?= base_url('/') ?>" class="nav-link text-sm font-semibold text-gray-700 hover:text-primary pb-0.5 transition-colors">Home</a></li>
            <li><a href="<?= base_url('sekolah') ?>" class="nav-link text-sm font-semibold text-primary pb-0.5 border-b-2 border-primary">Data Sekolah</a></li>
            <li>
                <a href="<?= base_url('login') ?>"
                   class="inline-flex items-center justify-center px-5 py-2 text-sm font-bold text-primary bg-blue-50 border border-blue-100 rounded-xl hover:bg-primary hover:text-white transition-all shadow-sm hover:shadow">
                    Login Admin
                </a>
            </li>
        </ul>

        <!-- Mobile hamburger -->
        <button id="menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 py-3 space-y-1">
            <a href="<?= base_url('/') ?>"       class="block px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-primary transition-colors">Home</a>
            <a href="<?= base_url('sekolah') ?>" class="block px-3 py-2 rounded-lg text-sm font-semibold bg-blue-50 text-primary transition-colors">Data Sekolah</a>
            <div class="pt-2 mt-2 border-t border-gray-100">
                <a href="<?= base_url('login') ?>" class="block w-full text-center px-3 py-2.5 rounded-lg text-sm font-bold text-primary bg-blue-50 border border-blue-100 hover:bg-primary hover:text-white transition-all">
                    Login Admin
                </a>
            </div>
        </div>
    </div>
</nav>


<!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
<main class="pt-16 min-h-screen">

    <!-- Page Header -->
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-1">
                        <a href="<?= base_url('/') ?>" class="hover:text-primary transition-colors">Home</a>
                        <span>/</span>
                        <span class="text-primary font-medium">Data Sekolah</span>
                    </nav>
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900">DETAIL DATA SMK</h1>
                    <p class="text-gray-500 text-sm mt-1">Daftar Sekolah Menengah Kejuruan di Wilayah Brebes Selatan</p>
                </div>
                <div class="flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Total SMK</p>
                        <p class="text-xl font-black text-primary"><?= count($sekolah) ?> <span class="text-sm font-semibold text-gray-600">Sekolah</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-8">

        <!-- Filter Kecamatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
            <p class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter Berdasarkan Kecamatan:
            </p>
            <form method="GET" action="<?= base_url('sekolah') ?>" class="flex flex-wrap gap-3 items-center">
                <select name="kecamatan" id="filter-kecamatan"
                    class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-primary focus:border-primary outline-none bg-white min-w-[200px] cursor-pointer transition-all">
                    <option value="">— SEMUA KECAMATAN —</option>
                    <?php foreach ($kecamatanList as $kec): ?>
                        <option value="<?= esc($kec) ?>" <?= $filterKec === $kec ? 'selected' : '' ?>>
                            <?= esc(strtoupper($kec)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" id="btn-filter"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Terapkan
                </button>

                <?php if ($filterKec): ?>
                    <a href="<?= base_url('sekolah') ?>" id="btn-reset-filter"
                        class="inline-flex items-center gap-1 px-4 py-2.5 text-sm font-semibold text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                <?php endif; ?>
            </form>

            <?php if ($filterKec): ?>
                <p class="text-xs text-gray-500 mt-3">
                    Menampilkan <span class="font-bold text-primary"><?= count($sekolah) ?> SMK</span>
                    di Kecamatan <span class="font-bold"><?= esc($filterKec) ?></span>
                </p>
            <?php endif; ?>
        </div>

        <!-- Tabel Data SMK -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="px-4 py-3.5 text-center font-bold tracking-wide w-12">No</th>
                            <th class="px-4 py-3.5 text-left   font-bold tracking-wide">Nama SMK</th>
                            <th class="px-4 py-3.5 text-left   font-bold tracking-wide">Kecamatan</th>
                            <th class="px-4 py-3.5 text-left   font-bold tracking-wide">Alamat</th>
                            <th class="px-4 py-3.5 text-center font-bold tracking-wide w-28">Akreditasi</th>
                            <th class="px-4 py-3.5 text-center font-bold tracking-wide w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($sekolah)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-16 text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold">Tidak ada data SMK ditemukan.</p>
                                    <p class="text-xs mt-1">Coba ubah filter kecamatan.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sekolah as $i => $s): ?>
                                <tr class="transition-colors duration-150">
                                    <td class="px-4 py-3 text-center font-bold text-gray-500"><?= $i + 1 ?>.</td>
                                    <td class="px-4 py-3">
                                        <p class="font-bold text-gray-900"><?= esc($s['nama']) ?></p>
                                        <p class="text-xs text-gray-400 mt-0.5">NPSN: <?= esc($s['npsn'] ?? '-') ?></p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                            <?= esc($s['kecamatan']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 text-xs leading-relaxed max-w-xs"><?= esc($s['alamat']) ?></td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-block text-xs font-black px-3 py-1 rounded-full
                                            <?= $s['akreditasi'] === 'A' ? 'badge-A' : ($s['akreditasi'] === 'B' ? 'badge-B' : 'badge-C') ?>">
                                            <?= esc($s['akreditasi']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="<?= base_url('sekolah/detail/' . $s['id']) ?>"
                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail SMK
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table footer -->
            <?php if (!empty($sekolah)): ?>
                <div class="bg-gray-50 border-t border-gray-100 px-6 py-3 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Menampilkan <strong><?= count($sekolah) ?></strong> data SMK</p>
                    <p class="text-xs text-gray-400">SIG SMK Brebes Selatan &copy; <?= date('Y') ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<!-- ═══════════════════ FOOTER ═══════════════════ -->
<footer class="bg-gray-900 text-gray-400 py-8 mt-12">
    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gray-800 overflow-hidden">
                    <img src="<?= base_url('images/logo-brebes.png') ?>" alt="Logo Brebes" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <p class="text-white font-bold text-sm">SIG SMK Brebes Selatan</p>
                    <p class="text-xs text-gray-500">Sistem Informasi Geografis SMK</p>
                </div>
            </div>
            <p class="text-xs font-bold tracking-widest uppercase text-gray-500">
                SIAP KERJA &bull; SANTUN &bull; MANDIRI &bull; KREATIF
            </p>
            <p class="text-xs text-gray-600">&copy; <?= date('Y') ?> SIG SMK Brebes Selatan.</p>
        </div>
    </div>
</footer>

<script>
    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () =>
        navbar.classList.toggle('navbar-scrolled', window.scrollY > 10));

    // Mobile menu
    document.getElementById('menu-btn').addEventListener('click', () =>
        document.getElementById('mobile-menu').classList.toggle('hidden'));
</script>

</body>
</html>
