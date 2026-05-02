<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Dashboard') ?> – Admin SIG SMK Brebes Selatan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#1a56db', secondary: '#e3a008' },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { background: #f3f4f6; }
    </style>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo-brebes.png') ?>">
</head>
<body class="font-sans min-h-screen">

<!-- Sidebar -->
<?= view('admin/partials/sidebar') ?>

<!-- Wrapper kanan -->
<div class="ml-52 min-h-screen flex flex-col">

    <!-- Top Header -->
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-6 h-14">
            <!-- Breadcrumb / page title -->
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-semibold text-gray-700"><?= esc($pageTitle ?? 'Dashboard') ?></span>
            </div>

            <div class="flex items-center gap-4">
                <!-- Date -->
                <span class="text-xs text-gray-400 font-medium bg-gray-100 px-3 py-1 rounded-full">
                    <?= date('d/m/Y') ?>
                </span>
                <!-- Admin info -->
                <a href="<?= base_url('admin/users') ?>" title="Kelola Admin" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                    <span class="text-sm font-bold text-gray-700"><?= esc(session()->get('username') ?? 'Admin') ?></span>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-black uppercase shadow-sm">
                        <?= strtoupper(substr(session()->get('username') ?? 'A', 0, 1)) ?>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-6">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-5 py-3 rounded-xl">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <!-- Page Header -->
        <div class="mb-8 text-center">
            <h1 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight uppercase tracking-wide">
                Sistem Informasi Geografis Sekolah Menengah<br>Kejuruan Brebes Selatan
            </h1>
            <div class="w-16 h-1 bg-primary rounded-full mx-auto mt-3"></div>
        </div>

        <!-- Stats Card: Total -->
        <div class="flex justify-center mb-6">
            <div class="inline-flex items-center gap-3 bg-white border border-gray-200 shadow-sm rounded-2xl px-6 py-3">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="text-sm font-bold text-gray-600">Total SMK:</span>
                <span class="text-2xl font-black text-primary"><?= $totalSMK ?></span>
            </div>
        </div>

        <!-- Jumlah SMK Berdasarkan Kecamatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-base font-black text-gray-800 mb-6 text-center">Jumlah SMK Berdasarkan Kecamatan</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <?php foreach ($statsKec as $kec => $count): ?>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <p class="text-xs font-bold text-gray-600 mb-2 leading-tight"><?= esc($kec) ?></p>
                        <p class="text-4xl font-black text-gray-800 mb-4 group-hover:text-primary transition-colors"><?= $count ?></p>
                        <a href="<?= base_url('admin/sekolah?kecamatan=' . urlencode($kec)) ?>"
                           class="inline-block w-full py-1.5 bg-gray-200 hover:bg-primary hover:text-white text-gray-700 text-xs font-bold rounded-lg transition-all duration-200">
                            Lihat
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <a href="<?= base_url('admin/sekolah') ?>"
               class="flex items-center gap-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                    <svg class="w-6 h-6 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Menu</p>
                    <p class="text-sm font-black text-gray-800">Kelola Data SMK</p>
                </div>
            </a>

            <a href="<?= base_url('admin/sekolah/tambah') ?>"
               class="flex items-center gap-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center group-hover:bg-secondary group-hover:scale-110 transition-all">
                    <svg class="w-6 h-6 text-secondary group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Menu</p>
                    <p class="text-sm font-black text-gray-800">Tambah Data SMK</p>
                </div>
            </a>

            <a href="<?= base_url('/') ?>" target="_blank"
               class="flex items-center gap-4 bg-white rounded-2xl border border-gray-200 shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center group-hover:bg-green-600 group-hover:scale-110 transition-all">
                    <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Link</p>
                    <p class="text-sm font-black text-gray-800">Lihat Halaman Publik</p>
                </div>
            </a>
        </div>

    </main>
</div><!-- /wrapper -->

</body>
</html>
