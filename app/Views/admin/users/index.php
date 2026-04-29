<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin – Admin SIG SMK Brebes Selatan</title>
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
</head>
<body class="font-sans min-h-screen">

<?= view('admin/partials/sidebar') ?>

<div class="ml-52 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-6 h-14">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                <span class="font-semibold text-gray-700">Kelola Admin</span>
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

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-5 py-3 rounded-xl">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Card tabel -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">

            <!-- Card header -->
            <div class="flex items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-black text-gray-800">Daftar Admin</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola pengguna yang memiliki akses panel admin</p>
                </div>
                <a href="<?= base_url('admin/users/tambah') ?>"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-secondary text-white text-sm font-bold rounded-lg hover:bg-amber-500 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Admin
                </a>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="px-4 py-3 font-bold w-10 text-center">No</th>
                            <th class="px-4 py-3 font-bold">Username</th>
                            <th class="px-4 py-3 font-bold">Nama Lengkap</th>
                            <th class="px-4 py-3 font-bold text-center">Role</th>
                            <th class="px-4 py-3 font-bold text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-400">
                                    <p class="font-semibold text-sm">Belum ada data admin.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $i => $u): ?>
                                <tr class="transition-colors">
                                    <td class="px-4 py-2.5 text-center text-gray-500 font-bold text-xs"><?= $i + 1 ?>.</td>
                                    <td class="px-4 py-2.5">
                                        <p class="font-bold text-gray-900 text-sm"><?= esc($u['username']) ?></p>
                                    </td>
                                    <td class="px-4 py-2.5 text-sm text-gray-600"><?= esc($u['nama_lengkap'] ?? '-') ?></td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span class="inline-block text-xs font-black px-2.5 py-0.5 rounded-full
                                            <?= $u['role'] === 'superadmin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' ?>">
                                            <?= esc($u['role']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <?php if ($u['username'] !== session()->get('username')): ?>
                                            <form action="<?= base_url('admin/users/hapus/' . $u['id']) ?>" method="POST"
                                                  onsubmit="return confirm('Hapus admin <?= esc($u['username'], 'js') ?>?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" title="Hapus"
                                                        class="w-7 h-7 flex items-center justify-center bg-red-500 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm mx-auto">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic">Anda</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer tabel -->
            <div class="bg-gray-50 border-t border-gray-100 px-6 py-3 flex items-center justify-between">
                <p class="text-xs text-gray-500">Total: <strong><?= count($users ?? []) ?></strong> admin</p>
            </div>
        </div>

    </main>
</div>

</body>
</html>
