<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – SIG SMK Brebes Selatan</title>

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
                    keyframes: {
                        fadeUp: {
                            '0%':   { opacity: '0', transform: 'translateY(24px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        shake: {
                            '0%,100%': { transform: 'translateX(0)' },
                            '20%,60%': { transform: 'translateX(-6px)' },
                            '40%,80%': { transform: 'translateX(6px)' },
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.6s ease forwards',
                        'shake':   'shake 0.4s ease',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: #d1d5db;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Input focus ring */
        .field-input:focus {
            outline: none;
            border-color: #9ca3af;
            box-shadow: 0 0 0 3px rgba(156,163,175,0.25);
        }

        /* Eye toggle */
        .eye-btn { cursor: pointer; color: #9ca3af; }
        .eye-btn:hover { color: #6b7280; }
    </style>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo-brebes.png') ?>">
</head>

<body class="font-sans">

    <!-- Card -->
    <div class="animate-fade-up w-full max-w-sm mx-4">

        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-5">
                <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center overflow-hidden">
                    <img src="<?= base_url('images/logo-brebes.png') ?>"
                         alt="Logo Kabupaten Brebes"
                         class="w-16 h-16 object-contain">
                </div>
            </div>

            <h1 class="text-xl sm:text-2xl font-black text-gray-800 uppercase tracking-wide leading-tight">
                Sistem Informasi Geografis<br>Sekolah Menengah Kejuruan
            </h1>

            <p class="mt-3 text-sm font-semibold text-gray-600 tracking-wide">Login Admin</p>
        </div>

        <!-- Error Alert -->
        <?php if (session()->getFlashdata('error')): ?>
            <div id="error-alert"
                 class="animate-shake flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-4 py-3 rounded-xl mb-4">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/80 px-8 py-8">
            <form action="<?= base_url('login') ?>" method="POST" id="login-form">
                <?= csrf_field() ?>

                <!-- Username -->
                <div class="mb-4">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input type="text"
                               id="username"
                               name="username"
                               placeholder="Username"
                               value="<?= esc(old('username')) ?>"
                               autocomplete="username"
                               required
                               class="field-input w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-sm text-gray-700 font-medium placeholder-gray-400 transition-all duration-200">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="Password"
                               autocomplete="current-password"
                               required
                               class="field-input w-full pl-11 pr-11 py-3 bg-gray-50 border border-gray-300 rounded-xl text-sm text-gray-700 font-medium placeholder-gray-400 transition-all duration-200">
                        <!-- Eye toggle -->
                        <button type="button" id="toggle-pw"
                                class="eye-btn absolute right-4 top-1/2 -translate-y-1/2 transition-colors">
                            <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="text-right mb-6">
                    <a href="#" id="link-forgot"
                       class="text-xs text-gray-500 hover:text-primary transition-colors font-medium">
                        Forgot Password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="btn-login"
                        class="w-full py-3 bg-gray-500 hover:bg-gray-600 active:bg-gray-700
                               text-white font-black text-sm tracking-widest uppercase
                               rounded-xl shadow-md hover:shadow-lg
                               transition-all duration-200 hover:-translate-y-0.5
                               flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login
                </button>
            </form>
        </div>

        <!-- Back to site -->
        <div class="text-center mt-5">
            <a href="<?= base_url('/') ?>"
               class="text-xs text-gray-500 hover:text-gray-700 transition-colors font-medium inline-flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke halaman utama
            </a>
        </div>

    </div><!-- /card -->


    <script>
        // Toggle show/hide password
        const toggleBtn = document.getElementById('toggle-pw');
        const pwInput   = document.getElementById('password');
        const eyeOpen   = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        toggleBtn.addEventListener('click', () => {
            const isHidden = pwInput.type === 'password';
            pwInput.type   = isHidden ? 'text' : 'password';
            eyeOpen.classList.toggle('hidden',  isHidden);
            eyeClosed.classList.toggle('hidden', !isHidden);
        });

        // Loading state on submit
        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('btn-login');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Memproses...
            `;
        });
    </script>

</body>
</html>
