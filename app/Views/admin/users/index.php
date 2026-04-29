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

    <main class="flex-1 p-6" x-data="gantiSandiApp()">

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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">

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
                            <th class="px-4 py-3 font-bold text-center w-32">Aksi</th>
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
                                        <div class="flex items-center justify-center gap-1.5">
                                            <!-- Tombol Ganti Sandi -->
                                            <?php
                                                $currentRole = session()->get('role');
                                                $isSelf = ($u['username'] === session()->get('username'));
                                                $canChange = ($currentRole === 'superadmin' || $isSelf);
                                            ?>
                                            <?php if ($canChange): ?>
                                                <button type="button" title="Ganti Sandi"
                                                        @click="openModal(<?= $u['id'] ?>, '<?= esc($u['username'], 'js') ?>', <?= $isSelf ? 'true' : 'false' ?>)"
                                                        class="w-7 h-7 flex items-center justify-center bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>

                                            <!-- Tombol Hapus -->
                                            <?php if ($u['username'] !== session()->get('username')): ?>
                                                <form action="<?= base_url('admin/users/hapus/' . $u['id']) ?>" method="POST"
                                                      onsubmit="return confirm('Hapus admin <?= esc($u['username'], 'js') ?>?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" title="Hapus"
                                                            class="w-7 h-7 flex items-center justify-center bg-red-500 hover:bg-red-700 text-white rounded-lg transition-colors shadow-sm">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if (!$canChange && $u['username'] === session()->get('username')): ?>
                                                <span class="text-xs text-gray-400 italic">Anda</span>
                                            <?php endif; ?>
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
                <p class="text-xs text-gray-500">Total: <strong><?= count($users ?? []) ?></strong> admin</p>
            </div>
        </div>

        <!-- ═══════ MODAL GANTI SANDI ═══════ -->
        <div x-show="showModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeModal()"></div>

                <!-- Modal Card -->
                <div class="relative bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-md mx-4 overflow-hidden">

                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 flex items-center justify-center shadow-sm">
                                <svg class="w-4.5 h-4.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-gray-800">Ganti Sandi</h3>
                                <p class="text-xs text-gray-500">User: <span class="font-bold text-amber-600" x-text="targetUsername"></span></p>
                            </div>
                        </div>
                        <button @click="closeModal()" class="w-7 h-7 rounded-lg flex items-center justify-center hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form :action="formAction" method="POST" class="p-6 space-y-4">
                        <?= csrf_field() ?>

                        <!-- Password Lama (hanya jika ganti sandi sendiri) -->
                        <template x-if="isSelf">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Password Lama <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showOld ? 'text' : 'password'" name="password_lama" required
                                           class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition-all bg-gray-50 focus:bg-white"
                                           placeholder="Masukkan password lama">
                                    <button type="button" @click="showOld = !showOld" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <svg x-show="!showOld" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="showOld" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Password Baru -->
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input :type="showNew ? 'text' : 'password'" name="password_baru" required minlength="4"
                                       class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition-all bg-gray-50 focus:bg-white"
                                       placeholder="Minimal 4 karakter">
                                <button type="button" @click="showNew = !showNew" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirm" required minlength="4"
                                       class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition-all bg-gray-50 focus:bg-white"
                                       placeholder="Ulangi password baru">
                                <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Info -->
                        <template x-if="!isSelf">
                            <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 rounded-xl px-3.5 py-2.5">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-blue-700 font-medium">Sebagai superadmin, Anda dapat langsung mengatur sandi baru tanpa memerlukan password lama.</p>
                            </div>
                        </template>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-2 pt-2">
                            <button type="button" @click="closeModal()"
                                    class="px-4 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Sandi
                            </button>
                        </div>
                    </form>
                </div>
        </div>

    </main>
</div>

<script>
function gantiSandiApp() {
    return {
        showModal: false,
        targetId: null,
        targetUsername: '',
        isSelf: false,
        formAction: '',
        showOld: false,
        showNew: false,
        showConfirm: false,

        openModal(id, username, isSelf) {
            this.targetId = id;
            this.targetUsername = username;
            this.isSelf = isSelf;
            this.formAction = '<?= base_url('admin/users/ganti-sandi/') ?>' + id;
            this.showOld = false;
            this.showNew = false;
            this.showConfirm = false;
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
            this.targetId = null;
            this.targetUsername = '';
            this.isSelf = false;
            this.formAction = '';
        }
    }
}
</script>

</body>
</html>
