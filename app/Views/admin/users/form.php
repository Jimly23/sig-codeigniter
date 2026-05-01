<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle) ?> – Admin SIG SMK Brebes Selatan</title>
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
        .field-label {
            display: block; font-size: 0.75rem; font-weight: 700; color: #374151;
            margin-bottom: 0.375rem; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .field-input {
            width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.625rem;
            font-size: 0.875rem; color: #1f2937; background: #f9fafb;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field-input:focus {
            outline: none; border-color: #1a56db; background: #fff;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.12);
        }
    </style>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo-brebes.png') ?>">
</head>
<body class="font-sans min-h-screen">

<?= view('admin/partials/sidebar') ?>

<div class="ml-52 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-6 h-14">
            <div class="flex items-center gap-2 text-sm">
                <a href="<?= base_url('admin/users') ?>" class="text-gray-400 hover:text-primary transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <span class="text-gray-300">/</span>
                <span class="font-bold text-gray-700"><?= esc($pageTitle) ?></span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full"><?= date('d/m/Y') ?></span>
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

        <!-- Validation Errors -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-5 py-3 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-black">Terdapat kesalahan:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-lg mx-auto">

            <!-- Card Header -->
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h2 class="text-base font-black text-gray-800"><?= esc($pageTitle) ?></h2>
            </div>

            <!-- Form -->
            <form action="<?= base_url('admin/users/simpan') ?>"
                  method="POST"
                  class="p-6 space-y-5">

                <?= csrf_field() ?>

                <!-- Username -->
                <div>
                    <label class="field-label" for="username">Username <span class="text-red-500">*</span></label>
                    <input type="text" id="username" name="username" required
                           placeholder="Contoh: admin2"
                           value="<?= esc(old('username', '')) ?>"
                           class="field-input">
                </div>

                <!-- Password -->
                <div>
                    <label class="field-label" for="password">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required
                           placeholder="Minimal 4 karakter"
                           class="field-input">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label class="field-label" for="password_confirm">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password_confirm" name="password_confirm" required
                           placeholder="Ulangi password"
                           class="field-input">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="field-label" for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                           placeholder="Contoh: Ahmad Fauzi"
                           value="<?= esc(old('nama_lengkap', '')) ?>"
                           class="field-input">
                </div>

                <!-- Role -->
                <div>
                    <label class="field-label" for="role">Role</label>
                    <select name="role" id="role" class="field-input cursor-pointer">
                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="superadmin" <?= old('role') === 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                    </select>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 pt-4 flex items-center justify-between gap-4">
                    <a href="<?= base_url('admin/users') ?>"
                       class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-300 text-gray-600 font-bold text-sm rounded-xl hover:border-gray-400 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>

                    <button type="submit" id="btn-submit"
                            class="inline-flex items-center gap-2 px-8 py-2.5 bg-primary text-white font-black text-sm rounded-xl shadow-md hover:bg-blue-700 hover:shadow-lg transition-all hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Simpan Admin
                    </button>
                </div>

            </form>
        </div>

    </main>
</div>

<script>
    // Loading state saat submit
    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Menyimpan...
        `;
    });
</script>

</body>
</html>
