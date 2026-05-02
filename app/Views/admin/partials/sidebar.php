<!-- ═══════════════════ SIDEBAR ═══════════════════
     Variables expected:
       $activePage    : 'dashboard' | 'sekolah' | 'tambah' | 'users'
       $kecamatanList : array of kecamatan strings
       $filterKec     : currently filtered kecamatan (optional)
═══════════════════════════════════════════════ -->
<?php
$filterKec     = $filterKec     ?? '';
$kecamatanList = $kecamatanList ?? [];
?>
<aside id="sidebar"
       class="fixed top-0 left-0 h-full w-52 bg-white border-r border-gray-200 z-30 flex flex-col shadow-sm transition-transform duration-300">

    <!-- Brand -->
    <div class="flex items-center gap-2.5 px-4 py-4 border-b border-gray-100">
        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 flex-shrink-0 shadow">
            <img src="<?= base_url('images/logo-brebes.png') ?>" alt="Logo" class="w-full h-full object-contain">
        </div>
        <div>
            <p class="text-xs font-black text-gray-800 leading-tight">SIG SMK</p>
            <p class="text-[10px] font-bold text-primary leading-tight uppercase tracking-wide">Brebes Selatan</p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-0.5">

        <!-- Dashboard -->
        <a href="<?= base_url('admin/dashboard') ?>"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-bold transition-all duration-150
                  <?= $activePage === 'dashboard' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:bg-blue-50 hover:text-primary' ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <!-- Data SMK accordion -->
        <div x-data="{ open: <?= in_array($activePage, ['sekolah']) ? 'true' : 'true' ?> }">
            <button @click="open = !open"
                    class="w-full flex items-center justify-between gap-2 px-3 py-2.5 rounded-lg text-sm font-bold transition-all duration-150
                           <?= $activePage === 'sekolah' ? 'text-primary' : 'text-gray-600 hover:bg-blue-50 hover:text-primary' ?>">
                <span class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Data SMK
                </span>
                <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="ml-4 mt-0.5 space-y-0.5 border-l-2 border-blue-100 pl-3">

                <!-- All -->
                <a href="<?= base_url('admin/sekolah') ?>"
                   class="block py-1.5 text-xs font-semibold transition-colors
                          <?= ($activePage === 'sekolah' && !$filterKec) ? 'text-primary' : 'text-gray-500 hover:text-primary' ?>">
                    Semua
                </a>

                <?php foreach ($kecamatanList as $kec): ?>
                    <a href="<?= base_url('admin/sekolah?kecamatan=' . urlencode($kec)) ?>"
                       class="block py-1.5 text-xs font-semibold transition-colors
                              <?= $filterKec === $kec ? 'text-primary font-bold' : 'text-gray-500 hover:text-primary' ?>">
                        <?= esc($kec) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tambah Data -->
        <a href="<?= base_url('admin/sekolah/tambah') ?>"
           class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-bold transition-all duration-150
                  <?= $activePage === 'tambah' ? 'bg-secondary text-white shadow' : 'text-gray-600 hover:bg-yellow-50 hover:text-secondary' ?>">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Data
        </a>


    </nav>

    <!-- Logout -->
    <div class="border-t border-gray-100 p-3">
        <a href="<?= base_url('logout') ?>"
           class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-bold text-red-500 hover:bg-red-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Keluar
        </a>
    </div>
</aside>
