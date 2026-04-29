<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail informasi <?= esc($sekolah['nama']) ?> – SIG SMK Brebes Selatan.">
    <title>Detail <?= esc($sekolah['nama']) ?> – SIG SMK Brebes Selatan</title>

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
                    colors: { primary: '#1a56db', secondary: '#e3a008' },
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

        #map-detail {
            height: 380px;
            width: 100%;
            border-radius: 0.75rem;
            z-index: 0;
            border: 0;
        }

        /* Info row */
        .info-row {
            display: grid;
            grid-template-columns: 160px 1fr;
            align-items: start;
            gap: 0.5rem 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .info-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
        }

        .badge-A { background:#dcfce7; color:#15803d; }
        .badge-B { background:#dbeafe; color:#1d4ed8; }
        .badge-C { background:#fef9c3; color:#92400e; }

        /* Fasilitas gallery placeholder */
        .gallery-placeholder {
            background: linear-gradient(135deg, #e0e7ff 0%, #dbeafe 100%);
            border: 2px dashed #93c5fd;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            gap: 0.5rem;
        }


    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800 overflow-x-hidden">

<!-- ═══════════════════ NAVBAR ═══════════════════ -->
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <a href="<?= base_url('/') ?>" class="flex items-center gap-3 group">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white shadow-md group-hover:scale-105 transition-transform overflow-hidden">
                <img src="<?= base_url('images/logo-brebes.png') ?>" alt="Logo Brebes" class="w-10 h-10 object-contain">
            </div>
            <div class="hidden sm:block">
                <p class="text-xs font-semibold text-gray-500 leading-none">SIG SMK</p>
                <p class="text-sm font-bold text-primary leading-none">Brebes Selatan</p>
            </div>
        </a>

        <ul class="hidden md:flex items-center gap-8">
            <li><a href="<?= base_url('/') ?>"       class="nav-link text-sm font-semibold text-gray-700 hover:text-primary pb-0.5 transition-colors">Home</a></li>
            <li><a href="<?= base_url('sekolah') ?>" class="nav-link text-sm font-semibold text-primary pb-0.5 border-b-2 border-primary">Data Sekolah</a></li>
        </ul>

        <button id="menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="px-4 py-3 space-y-1">
            <a href="<?= base_url('/') ?>"       class="block px-3 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-primary">Home</a>
            <a href="<?= base_url('sekolah') ?>" class="block px-3 py-2 rounded-lg text-sm font-semibold bg-blue-50 text-primary">Data Sekolah</a>
        </div>
    </div>
</nav>


<!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
<main class="pt-16 min-h-screen pb-16">

    <!-- Page Header -->
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-6">
            <nav class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                <a href="<?= base_url('/') ?>"       class="hover:text-primary transition-colors">Home</a>
                <span>/</span>
                <a href="<?= base_url('sekolah') ?>" class="hover:text-primary transition-colors">Data Sekolah</a>
                <span>/</span>
                <span class="text-primary font-medium">Detail SMK</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900">DETAIL SMK</h1>
                    <p class="text-gray-500 text-sm mt-0.5"><?= esc($sekolah['nama']) ?></p>
                </div>
                <a href="<?= base_url('sekolah') ?>" id="btn-kembali"
                   class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-300 text-gray-600 font-bold text-sm rounded-xl hover:border-primary hover:text-primary hover:bg-blue-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 py-8 space-y-8">

        <!-- ─── Row 1: Informasi SMK + Peta ─── -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Informasi SMK -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-blue-700 px-6 py-4 flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-white font-black text-base tracking-wide">Informasi SMK</h2>
                </div>

                <div class="px-6 py-2">
                    <div class="info-row">
                        <span class="info-label">Nama Sekolah</span>
                        <span class="info-value font-black text-primary"><?= esc($sekolah['nama']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NPSN</span>
                        <span class="info-value font-mono tracking-wide"><?= esc($sekolah['npsn'] ?? '-') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kecamatan</span>
                        <span class="info-value">
                            <span class="inline-block bg-gray-100 text-gray-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                <?= esc($sekolah['kecamatan']) ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-value"><?= esc($sekolah['alamat']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Luas Tanah</span>
                        <span class="info-value"><?= esc($sekolah['luas_tanah'] ?? '-') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No. Telepon</span>
                        <span class="info-value"><?= esc($sekolah['no_telp'] ?? '-') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value text-primary"><?= esc($sekolah['email'] ?? '-') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Website & Medsos</span>
                        <span class="info-value">
                            <div class="flex flex-wrap gap-2">
                                <?php if (!empty($sekolah['website']) && $sekolah['website'] !== '-'): ?>
                                    <?php
                                        $webUrl = $sekolah['website'];
                                        if (!preg_match('/^https?:\/\//', $webUrl)) $webUrl = 'https://' . $webUrl;
                                    ?>
                                    <a href="<?= esc($webUrl) ?>" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-primary text-xs font-bold rounded-lg border border-blue-200 hover:bg-primary hover:text-white transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                                        Website
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($sekolah['media_sosial']) && $sekolah['media_sosial'] !== '-'): ?>
                                    <?php
                                        $sosmedUrl = $sekolah['media_sosial'];
                                        if (!preg_match('/^https?:\/\//', $sosmedUrl)) $sosmedUrl = 'https://' . $sosmedUrl;
                                    ?>
                                    <a href="<?= esc($sosmedUrl) ?>" target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-pink-50 text-pink-600 text-xs font-bold rounded-lg border border-pink-200 hover:bg-pink-600 hover:text-white transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                        Media Sosial
                                    </a>
                                <?php endif; ?>
                                <?php if (empty($sekolah['website']) && empty($sekolah['media_sosial'])): ?>
                                    <span class="text-gray-400">–</span>
                                <?php endif; ?>
                            </div>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jurusan</span>
                        <span class="info-value text-xs leading-relaxed"><?= esc($sekolah['jurusan']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Akreditasi</span>
                        <span class="info-value">
                            <span class="inline-block text-xs font-black px-3 py-1 rounded-full
                                <?= $sekolah['akreditasi'] === 'A' ? 'badge-A' : ($sekolah['akreditasi'] === 'B' ? 'badge-B' : 'badge-C') ?>">
                                <?= esc($sekolah['akreditasi']) ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Lokasi / Peta -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-4 flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-white font-black text-base tracking-wide">Lokasi</h2>
                </div>

                <div class="relative p-0">
                    <iframe id="map-detail" 
                            src="https://maps.google.com/maps?q=<?= (float)$sekolah['latitude'] ?>,<?= (float)$sekolah['longitude'] ?>&hl=id&z=15&output=embed" 
                            width="100%" 
                            height="380" 
                            style="border:0; border-radius: 0.75rem;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <!-- Tombol Rute -->
                    <div class="absolute bottom-4 right-4 z-[999]">
                        <a id="btn-rute"
                           href="https://www.google.com/maps/dir/?api=1&destination=<?= $sekolah['latitude'] ?>,<?= $sekolah['longitude'] ?>"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white font-bold text-sm rounded-lg shadow-lg hover:bg-blue-700 transition-all hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Rute
                        </a>
                    </div>
                </div>

                <!-- Koordinat info -->
                <div class="border-t border-gray-100 bg-gray-50 px-5 py-3 flex items-center gap-4 text-xs text-gray-500">
                    <span>📍 Lat: <strong class="text-gray-700"><?= $sekolah['latitude'] ?></strong></span>
                    <span>📍 Lng: <strong class="text-gray-700"><?= $sekolah['longitude'] ?></strong></span>
                </div>
            </div>
        </div>

        <!-- ─── Row 2: Fasilitas Sekolah ─── -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-secondary to-amber-500 px-6 py-4 flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-white font-black text-base tracking-wide">Fasilitas Sekolah</h2>
            </div>

            <div class="p-6">
                <?php
                    $fotoLabels = ['Foto Sekolah','Ruang Kelas','Lab. Sekolah','Lapangan Olahraga','Fasilitas Lainnya'];
                    $fotoKeys   = ['foto1','foto2','foto3','foto4','foto5'];
                    $fotos = [];
                    foreach ($fotoKeys as $i => $key) {
                        if (!empty($sekolah[$key])) {
                            $fotos[] = ['src' => $sekolah[$key], 'label' => $fotoLabels[$i]];
                        }
                    }
                    $hasFoto = !empty($fotos);
                ?>

                <?php if ($hasFoto): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        <?php foreach ($fotos as $foto): ?>
                            <div class="rounded-xl overflow-hidden border border-gray-100 shadow-sm group cursor-pointer"
                                 onclick="openLightbox('<?= base_url('uploads/sekolah/' . esc($foto['src'])) ?>', '<?= esc($foto['label'], 'js') ?>')">
                                <img src="<?= base_url('uploads/sekolah/' . esc($foto['src'])) ?>"
                                     alt="<?= esc($foto['label']) ?> – <?= esc($sekolah['nama']) ?>"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="px-3 py-2 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                                    <p class="text-xs font-bold text-gray-600"><?= esc($foto['label']) ?></p>
                                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- 5 placeholder slots sesuai kategori fasilitas -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <?php foreach ($fotoLabels as $label): ?>
                            <div class="gallery-placeholder">
                                <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-[10px] font-bold text-blue-400 text-center leading-tight"><?= $label ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div><!-- /max-w-7xl -->
</main>


<!-- ═══════════════════ FOOTER ═══════════════════ -->
<footer class="bg-gray-900 text-gray-400 py-8">
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


<!-- ═══════════════════ LIGHTBOX MODAL ═══════════════════ -->
<div id="lightbox" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/80 backdrop-blur-sm" onclick="closeLightbox(event)">
    <button onclick="closeLightbox(event, true)" class="absolute top-4 right-4 z-10 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/40 rounded-full text-white transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <div class="max-w-4xl max-h-[90vh] mx-4" onclick="event.stopPropagation()">
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain">
        <p id="lightbox-label" class="text-center text-white text-sm font-bold mt-3"></p>
    </div>
</div>

<script>
    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () =>
        navbar.classList.toggle('navbar-scrolled', window.scrollY > 10));

    // Mobile menu
    document.getElementById('menu-btn').addEventListener('click', () =>
        document.getElementById('mobile-menu').classList.toggle('hidden'));

    // Lightbox
    function openLightbox(src, label) {
        const lb = document.getElementById('lightbox');
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox-label').textContent = label;
        lb.classList.remove('hidden');
        lb.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox(e, force) {
        if (force || e.target === document.getElementById('lightbox')) {
            const lb = document.getElementById('lightbox');
            lb.classList.add('hidden');
            lb.classList.remove('flex');
            document.body.style.overflow = '';
        }
    }
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox(null, true);
    });
</script>

</body>
</html>
