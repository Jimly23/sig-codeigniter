<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data SMK – Admin SIG SMK Brebes Selatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter','sans-serif'] }, colors: { primary:'#1a56db', secondary:'#e3a008' } } }
        }
    </script>
    <style>
        [x-cloak]{display:none!important}
        body{background:#f3f4f6}
        tbody tr:nth-child(odd){background:#f8faff}
        tbody tr:nth-child(even){background:#fff}
        tbody tr:hover{background:#eff6ff}
    </style>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo-brebes.png') ?>">
</head>
<body class="font-sans min-h-screen">

<?= view('admin/partials/sidebar') ?>

<div class="ml-52 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-6 h-14">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span class="font-semibold text-gray-700">Kelola Data SMK</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400 font-medium bg-gray-100 px-3 py-1 rounded-full"><?= date('d/m/Y') ?></span>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-gray-700"><?= esc(session()->get('username') ?? 'Admin') ?></span>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white text-xs font-black">
                        <?= strtoupper(substr(session()->get('username') ?? 'A', 0, 1)) ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 p-6">

        <!-- Flash -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold px-5 py-3 rounded-xl">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <!-- Card tabel -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <!-- Card header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-black text-gray-800">Data SMK Brebes Selatan</h2>
                    <?php if ($filterKec): ?>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Filter: <span class="font-bold text-primary"><?= esc($filterKec) ?></span>
                            <a href="<?= base_url('admin/sekolah') ?>" class="ml-2 text-red-400 hover:text-red-600 font-bold">✕ Reset</a>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Search -->
                    <form method="GET" action="<?= base_url('admin/sekolah') ?>" class="flex items-center gap-2">
                        <?php if ($filterKec): ?><input type="hidden" name="kecamatan" value="<?= esc($filterKec) ?>"><?php endif; ?>
                        <div class="relative">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                                   placeholder="Search..."
                                   class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none w-48">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors">Cari</button>
                    </form>
                    <!-- Tambah -->
                    <a href="<?= base_url('admin/sekolah/tambah') ?>"
                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-secondary text-white text-sm font-bold rounded-lg hover:bg-amber-500 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </a>
                </div>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="px-3 py-3 font-bold w-10 text-center">No</th>
                            <th class="px-3 py-3 font-bold min-w-[180px]">Nama Sekolah</th>
                            <th class="px-3 py-3 font-bold min-w-[180px]">Alamat</th>
                            <th class="px-3 py-3 font-bold text-center w-24">Akreditasi</th>
                            <th class="px-3 py-3 font-bold min-w-[120px]">Fasilitas</th>
                            <th class="px-3 py-3 font-bold min-w-[160px]">Jurusan Sekolah</th>
                            <th class="px-3 py-3 font-bold min-w-[120px]">Kontak</th>
                            <th class="px-3 py-3 font-bold min-w-[140px]">Medsos, Website</th>
                            <th class="px-3 py-3 font-bold w-24">Latitude</th>
                            <th class="px-3 py-3 font-bold w-24">Longitude</th>
                            <th class="px-3 py-3 font-bold text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($sekolah)): ?>
                            <tr>
                                <td colspan="11" class="py-16 text-center text-gray-400">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold text-sm">Tidak ada data.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($sekolah as $i => $s): ?>
                                <tr class="transition-colors">
                                    <td class="px-3 py-2.5 text-center text-gray-500 font-bold text-xs"><?= $i + 1 ?>.</td>
                                    <td class="px-3 py-2.5">
                                        <p class="font-bold text-gray-900 text-xs leading-tight"><?= esc($s['nama']) ?></p>
                                        <p class="text-[10px] text-gray-400"><?= esc($s['kecamatan']) ?></p>
                                    </td>
                                    <td class="px-3 py-2.5 text-xs text-gray-600 leading-relaxed"><?= esc($s['alamat']) ?></td>
                                    <td class="px-3 py-2.5 text-center">
                                        <span class="inline-block text-xs font-black px-2.5 py-0.5 rounded-full
                                            <?= $s['akreditasi']==='A' ? 'bg-green-100 text-green-700' : ($s['akreditasi']==='B' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') ?>">
                                            <?= esc($s['akreditasi']) ?>
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-xs text-gray-500">
                                        <?= (!empty($s['foto1']) || !empty($s['foto2'])) ? '📷 Ada foto' : '<span class="text-gray-300">–</span>' ?>
                                    </td>
                                    <td class="px-3 py-2.5 text-xs text-gray-600 leading-relaxed"><?= esc($s['jurusan']) ?></td>
                                    <td class="px-3 py-2.5 text-xs text-gray-600"><?= esc($s['no_telp']) ?></td>
                                    <td class="px-3 py-2.5 text-xs text-primary"><?= esc($s['email']) ?></td>
                                    <td class="px-3 py-2.5 text-xs text-gray-500 font-mono"><?= $s['latitude'] ?></td>
                                    <td class="px-3 py-2.5 text-xs text-gray-500 font-mono"><?= $s['longitude'] ?></td>
                                    <td class="px-3 py-2.5">
                                        <div class="flex flex-col gap-1 items-center">
                                            <!-- Edit -->
                                            <a href="<?= base_url('admin/sekolah/edit/' . $s['id']) ?>"
                                               title="Edit"
                                               class="w-7 h-7 flex items-center justify-center bg-blue-500 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                            </a>
                                            <!-- Hapus -->
                                            <form action="<?= base_url('admin/sekolah/hapus/' . $s['id']) ?>" method="POST"
                                                  onsubmit="return confirm('Hapus <?= esc($s['nama'], 'js') ?>?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" title="Hapus"
                                                        class="w-7 h-7 flex items-center justify-center bg-red-500 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer tabel -->
            <div class="bg-gray-50 border-t border-gray-100 px-6 py-3 flex items-center justify-between">
                <p class="text-xs text-gray-500">Menampilkan <strong><?= count($sekolah) ?></strong> data SMK</p>
                <p class="text-xs text-gray-400">Total: <?= count($sekolah) ?> entries</p>
            </div>
        </div>

    </main>
</div>

</body>
</html>
