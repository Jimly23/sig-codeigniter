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

        /* Field styles */
        .field-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .field-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            color: #1f2937;
            background: #f9fafb;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field-input:focus {
            outline: none;
            border-color: #1a56db;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,86,219,0.12);
        }
        .field-input.is-invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        /* Foto upload box */
        .foto-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 2px dashed #d1d5db;
            border-radius: 0.75rem;
            padding: 1rem 0.5rem;
            background: #f9fafb;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
            min-height: 110px;
        }
        .foto-box:hover { border-color: #1a56db; background: #eff6ff; }
        .foto-box input[type="file"] { display: none; }
        .foto-box img.preview { max-height: 70px; object-fit: cover; border-radius: 6px; }
    </style>
</head>
<body class="font-sans min-h-screen">

<?= view('admin/partials/sidebar') ?>

<div class="ml-52 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-6 h-14">
            <div class="flex items-center gap-2 text-sm">
                <a href="<?= base_url('admin/sekolah') ?>" class="text-gray-400 hover:text-primary transition-colors flex items-center gap-1">
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl mx-auto">

            <!-- Card Header -->
            <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="w-8 h-8 rounded-lg <?= $isEdit ? 'bg-blue-100' : 'bg-yellow-100' ?> flex items-center justify-center">
                    <svg class="w-4 h-4 <?= $isEdit ? 'text-primary' : 'text-secondary' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php if ($isEdit): ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        <?php else: ?>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        <?php endif; ?>
                    </svg>
                </div>
                <h2 class="text-base font-black text-gray-800"><?= esc($pageTitle) ?></h2>
            </div>

            <!-- Form -->
            <form action="<?= $isEdit
                    ? base_url('admin/sekolah/update/' . $sekolah['id'])
                    : base_url('admin/sekolah/simpan') ?>"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-6 space-y-5">

                <?= csrf_field() ?>

                <!-- Row: Kecamatan + Akreditasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="field-label" for="kecamatan">Kecamatan <span class="text-red-500">*</span></label>
                        <select name="kecamatan" id="kecamatan" required class="field-input cursor-pointer">
                            <option value="">— Pilih —</option>
                            <?php foreach ($kecamatanList as $kec): ?>
                                <option value="<?= esc($kec) ?>"
                                    <?= (old('kecamatan', $isEdit ? $sekolah['kecamatan'] : '') === $kec) ? 'selected' : '' ?>>
                                    <?= esc($kec) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="field-label" for="akreditasi">Akreditasi <span class="text-red-500">*</span></label>
                        <select name="akreditasi" id="akreditasi" required class="field-input cursor-pointer">
                            <option value="">— Pilih —</option>
                            <?php foreach (['A' => 'Akreditasi A', 'B' => 'Akreditasi B', 'C' => 'Akreditasi C', 'TT' => 'Tidak Terakreditasi'] as $val => $label): ?>
                                <option value="<?= $val ?>"
                                    <?= (old('akreditasi', $isEdit ? $sekolah['akreditasi'] : '') === $val) ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Row: NPSN + Luas Tanah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="field-label" for="npsn">NPSN <span class="text-red-500">*</span></label>
                        <input type="text" id="npsn" name="npsn"
                               placeholder="Contoh: 20326501"
                               value="<?= esc(old('npsn', $isEdit ? ($sekolah['npsn'] ?? '') : '')) ?>"
                               required
                               class="field-input font-mono">
                    </div>
                    <div>
                        <label class="field-label" for="luas_tanah">Luas Tanah</label>
                        <input type="text" id="luas_tanah" name="luas_tanah"
                               placeholder="Contoh: 12.450 m²"
                               value="<?= esc(old('luas_tanah', $isEdit ? ($sekolah['luas_tanah'] ?? '') : '')) ?>"
                               class="field-input">
                    </div>
                </div>

                <!-- Nama Sekolah -->
                <div>
                    <label class="field-label" for="nama">Nama Sekolah <span class="text-red-500">*</span></label>
                    <input type="text" id="nama" name="nama" required
                           placeholder="Contoh: SMK Negeri 1 Bumiayu"
                           value="<?= esc(old('nama', $isEdit ? $sekolah['nama'] : '')) ?>"
                           class="field-input">
                </div>

                <!-- Alamat -->
                <div>
                    <label class="field-label" for="alamat">Alamat <span class="text-red-500">*</span></label>
                    <textarea id="alamat" name="alamat" rows="2" required
                              placeholder="Jl. Raya Bumiayu No. 1, Kec. Bumiayu, Kab. Brebes"
                              class="field-input resize-none"><?= esc(old('alamat', $isEdit ? $sekolah['alamat'] : '')) ?></textarea>
                </div>

                <!-- Fasilitas (foto upload) -->
                <div>
                    <label class="field-label">Fasilitas Sekolah (Foto)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        <?php
                        $fotoSlots = [
                            'foto1' => 'Foto Sekolah',
                            'foto2' => 'Ruang Kelas',
                            'foto3' => 'Lab. Sekolah',
                            'foto4' => 'Lapangan Olahraga',
                            'foto5' => 'Fasilitas Lainnya',
                        ];
                        ?>
                        <?php foreach ($fotoSlots as $name => $label): ?>
                            <div class="foto-box" onclick="document.getElementById('<?= $name ?>').click()">
                                <input type="file" id="<?= $name ?>" name="<?= $name ?>"
                                       accept="image/*"
                                       onchange="previewFoto(this, '<?= $name ?>_preview')">

                                <?php if ($isEdit && !empty($sekolah[$name])): ?>
                                    <!-- Tampilkan foto existing -->
                                    <img id="<?= $name ?>_preview"
                                         src="<?= base_url('uploads/sekolah/' . $sekolah[$name]) ?>"
                                         alt="preview"
                                         class="preview">
                                    <svg class="w-8 h-8 text-gray-300 hidden" id="<?= $name ?>_icon"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                <?php else: ?>
                                    <img id="<?= $name ?>_preview"
                                         src="#" alt="preview"
                                         class="preview hidden">
                                    <svg class="w-8 h-8 text-gray-300" id="<?= $name ?>_icon"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                <?php endif; ?>

                                <p class="text-[10px] font-bold text-gray-500 text-center leading-tight"><?= $label ?></p>
                                <span class="text-[10px] text-blue-400 font-semibold">Klik untuk pilih foto</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Jurusan Sekolah -->
                <div>
                    <label class="field-label" for="jurusan">Jurusan Sekolah</label>
                    <input type="text" id="jurusan" name="jurusan"
                           placeholder="Teknik Komputer & Jaringan, Akuntansi, Pemasaran"
                           value="<?= esc(old('jurusan', $isEdit ? $sekolah['jurusan'] : '')) ?>"
                           class="field-input">
                </div>

                <!-- Row: Kepala Sekolah + Kontak -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="field-label" for="kepala_sekolah">Kepala Sekolah</label>
                        <input type="text" id="kepala_sekolah" name="kepala_sekolah"
                               placeholder="Drs. H. Ahmad Fauzi, M.Pd."
                               value="<?= esc(old('kepala_sekolah', $isEdit ? $sekolah['kepala_sekolah'] : '')) ?>"
                               class="field-input">
                    </div>
                    <div>
                        <label class="field-label" for="no_telp">Kontak (No. Telepon)</label>
                        <input type="text" id="no_telp" name="no_telp"
                               placeholder="(0289) 432100"
                               value="<?= esc(old('no_telp', $isEdit ? $sekolah['no_telp'] : '')) ?>"
                               class="field-input">
                    </div>
                </div>

                <!-- Row: Email + Website -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="field-label" for="email">Email</label>
                        <input type="email" id="email" name="email"
                               placeholder="smk@email.com"
                               value="<?= esc(old('email', $isEdit ? $sekolah['email'] : '')) ?>"
                               class="field-input">
                    </div>
                    <div>
                        <label class="field-label" for="website">Media Sosial &amp; Website</label>
                        <input type="text" id="website" name="website"
                               placeholder="www.smk.sch.id / IG: @smkbrebes"
                               value="<?= esc(old('website', $isEdit ? $sekolah['website'] : '')) ?>"
                               class="field-input">
                    </div>
                </div>

                <!-- Google Maps Link Input -->
                <div>
                    <label class="field-label" for="gmaps_link">
                        🔗 Link Google Maps
                        <span class="text-gray-400 font-normal normal-case tracking-normal">(Paste link → koordinat otomatis terisi)</span>
                    </label>
                    <div class="flex gap-3">
                        <input type="text" id="gmaps_link"
                               placeholder="Paste link Google Maps di sini, contoh: https://maps.google.com/?q=-7.2143,108.9347"
                               class="field-input flex-1">
                        <button type="button" id="btn-extract"
                                class="px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center gap-1.5 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Ambil Koordinat
                        </button>
                    </div>
                    <div id="extract-feedback" class="text-xs mt-1.5 hidden"></div>
                </div>

                <!-- Row: Latitude + Longitude -->
                <div>
                    <label class="field-label">Koordinat Lokasi <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Latitude</label>
                            <input type="number" id="latitude" name="latitude" step="any" required
                                   placeholder="-7.2143"
                                   value="<?= esc(old('latitude', $isEdit ? $sekolah['latitude'] : '')) ?>"
                                   class="field-input font-mono">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Longitude</label>
                            <input type="number" id="longitude" name="longitude" step="any" required
                                   placeholder="108.9347"
                                   value="<?= esc(old('longitude', $isEdit ? $sekolah['longitude'] : '')) ?>"
                                   class="field-input font-mono">
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1.5">
                        💡 Tip: Paste link Google Maps di atas, atau klik kanan lokasi di
                        <a href="https://maps.google.com" target="_blank" class="text-primary underline">Google Maps</a>
                        untuk copy koordinat.
                    </p>
                </div>

                <!-- Mini Map Preview -->
                <div>
                    <label class="field-label">Preview Lokasi di Peta</label>
                    <iframe id="mini-map" 
                            src="https://maps.google.com/maps?q=<?= esc(old('latitude', $isEdit ? $sekolah['latitude'] : '-7.2200')) ?>,<?= esc(old('longitude', $isEdit ? $sekolah['longitude'] : '108.9000')) ?>&hl=id&z=15&output=embed" 
                            width="100%" 
                            height="250" 
                            style="border:0; border-radius: 0.75rem;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <p class="text-xs text-gray-400 mt-1.5">📌 Peta akan otomatis berubah saat koordinat terisi.</p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 pt-4 flex items-center justify-between gap-4">
                    <a href="<?= base_url('admin/sekolah') ?>"
                       class="inline-flex items-center gap-2 px-5 py-2.5 border-2 border-gray-300 text-gray-600 font-bold text-sm rounded-xl hover:border-gray-400 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>

                    <button type="submit" id="btn-submit"
                            class="inline-flex items-center gap-2 px-8 py-2.5 bg-primary text-white font-black text-sm rounded-xl shadow-md hover:bg-blue-700 hover:shadow-lg transition-all hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if ($isEdit): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            <?php else: ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            <?php endif; ?>
                        </svg>
                        <?= $isEdit ? 'Update Data' : 'Simpan Data' ?>
                    </button>
                </div>

            </form>
        </div>

    </main>
</div>

<script>
    // Preview foto sebelum upload
    function previewFoto(input, previewId) {
        const preview = document.getElementById(previewId);
        const iconId  = previewId.replace('_preview', '_icon');
        const icon    = document.getElementById(iconId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (icon) icon.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ─── MINI MAP + MARKER ──────────────────────────────────
    const miniMap = document.getElementById('mini-map');

    // Saat input lat/lng diubah manual → update marker
    function updateMarkerFromInputs() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            miniMap.src = `https://maps.google.com/maps?q=${lat},${lng}&hl=id&z=15&output=embed`;
        }
    }
    document.getElementById('latitude').addEventListener('change', updateMarkerFromInputs);
    document.getElementById('longitude').addEventListener('change', updateMarkerFromInputs);

    // ─── GOOGLE MAPS LINK EXTRACTOR ────────────────────────
    function extractCoordsFromLink(link) {
        // Pattern 1: @-7.2143,108.9347 (dari URL saat buka Google Maps)
        let match = link.match(/@(-?\d+\.?\d*),\s*(-?\d+\.?\d*)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        // Pattern 2: ?q=-7.2143,108.9347 atau query=-7.2143,108.9347
        match = link.match(/[?&]q=(-?\d+\.?\d*),\s*(-?\d+\.?\d*)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        // Pattern 3: /place/-7.2143,108.9347
        match = link.match(/\/place\/(-?\d+\.?\d*),\s*(-?\d+\.?\d*)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        // Pattern 4: ll=-7.2143,108.9347
        match = link.match(/ll=(-?\d+\.?\d*),\s*(-?\d+\.?\d*)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        // Pattern 5: /maps/-7.2143,108.9347 atau /maps?...
        match = link.match(/\/maps\/(-?\d+\.?\d*),\s*(-?\d+\.?\d*)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        // Pattern 6: !3d-7.2143!4d108.9347 (embedded maps)
        match = link.match(/!3d(-?\d+\.?\d*)!4d(-?\d+\.?\d*)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        // Pattern 7: Langsung koordinat: -7.2143, 108.9347
        match = link.match(/^(-?\d+\.?\d*),\s*(-?\d+\.?\d*)$/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        return null;
    }

    const feedbackEl = document.getElementById('extract-feedback');

    document.getElementById('btn-extract').addEventListener('click', async function() {
        const link = document.getElementById('gmaps_link').value.trim();

        if (!link) {
            feedbackEl.className = 'text-xs mt-1.5 text-red-500 font-semibold';
            feedbackEl.textContent = '❌ Paste link Google Maps terlebih dahulu.';
            feedbackEl.classList.remove('hidden');
            return;
        }

        // Tampilkan loading
        feedbackEl.className = 'text-xs mt-1.5 text-blue-500 font-semibold';
        feedbackEl.innerHTML = 'Memproses link...';
        feedbackEl.classList.remove('hidden');

        let coords = extractCoordsFromLink(link);

        // Jika tidak ketemu, coba expand URL (untuk link pendek seperti maps.app.goo.gl)
        if (!coords) {
            try {
                const formData = new FormData();
                formData.append('url', link);
                
                const response = await fetch('<?= base_url('api/expand-url') ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                if (data.status === 'success' && data.expanded_url) {
                    coords = extractCoordsFromLink(data.expanded_url);
                }
            } catch (err) {
                console.error('Failed to expand URL:', err);
            }
        }

        if (coords && !isNaN(coords.lat) && !isNaN(coords.lng)) {
            document.getElementById('latitude').value  = coords.lat.toFixed(7);
            document.getElementById('longitude').value = coords.lng.toFixed(7);

            // Update marker & map
            miniMap.src = `https://maps.google.com/maps?q=${coords.lat},${coords.lng}&hl=id&z=15&output=embed`;

            feedbackEl.className = 'text-xs mt-1.5 text-green-600 font-semibold';
            feedbackEl.innerHTML = `✅ Koordinat berhasil diambil: <span class="font-mono">${coords.lat.toFixed(7)}, ${coords.lng.toFixed(7)}</span>`;
            feedbackEl.classList.remove('hidden');

            // Highlight input
            document.getElementById('latitude').style.borderColor  = '#10b981';
            document.getElementById('longitude').style.borderColor = '#10b981';
            setTimeout(() => {
                document.getElementById('latitude').style.borderColor  = '';
                document.getElementById('longitude').style.borderColor = '';
            }, 2000);
        } else {
            feedbackEl.className = 'text-xs mt-1.5 text-red-500 font-semibold';
            feedbackEl.textContent = '❌ Gagal mengambil koordinat. Pastikan link Google Maps valid.';
            feedbackEl.classList.remove('hidden');
        }
    });

    // Auto extract saat paste
    document.getElementById('gmaps_link').addEventListener('paste', function() {
        setTimeout(() => {
            document.getElementById('btn-extract').click();
        }, 100);
    });

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
