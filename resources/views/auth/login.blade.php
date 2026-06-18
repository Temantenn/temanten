<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Temanten</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* === Base === */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #faf7f2;
            color: #2a2620;
            -webkit-font-smoothing: antialiased;
        }

        /* === LEFT PANEL — Beige paper + testimonials === */
        .panel-left {
            position: relative;
            width: 55%;
            overflow: hidden;
            display: none;
            background: #f4ede0;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (min-width: 768px) {
            .panel-left { display: flex; }
        }

        /* Paper texture — layered radial gradients + SVG noise */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(180,150,110,0.10) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(160,120,90,0.08) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.4'/%3E%3C/svg%3E");
            opacity: 0.55;
            z-index: 0;
        }

        /* Hand-drawn ornaments */
        .ornament-top, .ornament-bottom {
            position: absolute;
            z-index: 1;
            color: #b08765;
            pointer-events: none;
        }

        .ornament-top { top: 2.5rem; left: 50%; transform: translateX(-50%); }
        .ornament-bottom { bottom: 2.5rem; left: 50%; transform: translateX(-50%) scaleY(-1); }

        /* Main content */
        .panel-content {
            position: relative;
            z-index: 2;
            padding: 5rem 3.5rem 1.5rem;
            text-align: center;
            color: #3a2f24;
        }

        .panel-eyebrow {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #a07a52;
            margin-bottom: 1.5rem;
        }

        .panel-quote {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.1rem;
            line-height: 1.3;
            font-weight: 500;
            color: #2a2620;
            font-style: italic;
            margin: 0 auto 1.5rem;
            max-width: 440px;
        }

        .panel-attribution {
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            color: #6b5d4a;
        }

        .panel-attribution strong {
            color: #2a2620;
            font-weight: 500;
        }

        /* Testimonial cards */
        .testimonials {
            position: relative;
            z-index: 2;
            padding: 1.5rem 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .testimonial {
            background: rgba(255,253,247,0.75);
            border: 1px solid rgba(180,150,110,0.28);
            border-radius: 14px;
            padding: 1.1rem 1.35rem;
            backdrop-filter: blur(6px);
            display: flex;
            align-items: flex-start;
            gap: 0.95rem;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .testimonial:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(122,90,58,0.10);
        }

        .testimonial-photo {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
            border: 2px solid #d4a574;
        }

        .testimonial-photo-1 { background-image: url('https://i.pravatar.cc/120?img=32'); }
        .testimonial-photo-2 { background-image: url('https://i.pravatar.cc/120?img=45'); }
        .testimonial-photo-3 { background-image: url('https://i.pravatar.cc/120?img=20'); }

        .testimonial-body {
            flex: 1;
            font-size: 0.8rem;
            line-height: 1.55;
            color: #4a3f30;
        }

        .testimonial-body .stars {
            color: #d4a574;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            margin-bottom: 0.3rem;
        }

        .testimonial-body strong {
            display: block;
            color: #2a2620;
            font-weight: 500;
            margin-top: 0.4rem;
            font-size: 0.78rem;
        }

        /* Quote ribbon */
        .ribbon {
            position: relative;
            z-index: 2;
            margin: 0 3rem 3rem;
            padding: 0.8rem 1.25rem;
            background: rgba(255,253,247,0.55);
            border: 1px dashed rgba(180,150,110,0.4);
            border-radius: 999px;
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.85rem;
            color: #6b5d4a;
        }

        .ribbon::before { content: '~'; margin-right: 0.4rem; color: #d4a574; }

        /* === RIGHT PANEL — Form === */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            padding-bottom: calc(2.5rem + env(safe-area-inset-bottom, 0px));
            background: #faf7f2;
            position: relative;
            overflow: hidden;
        }

        /* Subtle pattern to fill ultrawide screens */
        .panel-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 30% 20%, rgba(212,165,116,0.05) 0%, transparent 40%),
                radial-gradient(circle at 70% 80%, rgba(160,122,82,0.04) 0%, transparent 40%);
            pointer-events: none;
        }

        /* Bottom ornament for visual balance on ultrawide */
        .panel-right-ornament {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            color: #b08765;
            opacity: 0.4;
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
        }

        /* Brand */
        .brand {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 500;
            color: #2a2620;
            letter-spacing: -0.01em;
            line-height: 1;
        }

        .brand-name .dot { color: #d4a574; }

        .brand-sub {
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            color: #8a7860;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            font-weight: 400;
            margin-top: 0.5rem;
        }

        .ornament-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin: 0 auto 1.5rem auto;
            color: #b08765;
        }

        .ornament-divider svg { opacity: 0.6; }

        /* Welcome message */
        .welcome {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .welcome h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: #2a2620;
            margin-bottom: 0.3rem;
        }

        .welcome p {
            font-size: 0.85rem;
            color: #6b5d4a;
        }

        /* Top-of-form error alert */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 10px;
            padding: 0.75rem 1rem 0.75rem 0.85rem;
            font-size: 0.8rem;
            line-height: 1.5;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .alert-error svg { flex-shrink: 0; margin-top: 0.1rem; }

        .alert-status {
            background: #f0f9f4;
            border: 1px solid #bbf0d0;
            color: #166534;
            border-radius: 10px;
            padding: 0.75rem 1rem 0.75rem 0.85rem;
            font-size: 0.8rem;
            line-height: 1.5;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .alert-status svg { flex-shrink: 0; margin-top: 0.1rem; }

        /* Form */
        .form-group { margin-bottom: 1.05rem; }

        .form-label-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 0.4rem;
            gap: 0.5rem;
        }

        .form-label {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.95rem;
            font-style: italic;
            font-weight: 500;
            color: #3a2f24;
        }

        .form-link { display: none; }

        .input-wrapper { position: relative; }

        .form-input {
            width: 100%;
            padding: 0.72rem 2.6rem 0.72rem 0.95rem;
            border: 1px solid #d8c5a8;
            border-radius: 8px;
            background: #fffbf3;
            font-size: 0.875rem;
            color: #2a2620;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .form-input::placeholder { color: #b8a585; }

        .form-input:focus {
            border-color: #a07a52;
            box-shadow: 0 0 0 3px rgba(160,122,82,0.10);
            background: white;
        }

        .form-input.is-invalid {
            border-color: #b91c1c;
            background: #fef2f2;
        }

        .form-input.is-invalid:focus {
            border-color: #991b1b;
            box-shadow: 0 0 0 3px rgba(185,28,28,0.12);
            background: #fef2f2;
        }

        .form-input.is-valid {
            border-color: #7a8a4a;
            background: #fdfcf6;
        }

        .form-input.is-valid:focus {
            border-color: #5f7038;
            box-shadow: 0 0 0 3px rgba(122,138,74,0.15);
        }

        /* Right icons inside input */
        .input-right {
            position: absolute;
            top: 50%;
            right: 0.7rem;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .input-valid-icon, .input-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7a8a4a;
        }

        .input-valid-icon { display: none; }
        .form-input.is-valid ~ .input-right .input-valid-icon { display: flex; }
        .form-input.is-valid ~ .input-right .input-toggle { display: none; }

        .input-toggle {
            color: #a07a52;
            background: none;
            border: none;
            padding: 0.25rem;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .input-toggle:hover { background: rgba(160,122,82,0.10); }
        .input-toggle:focus-visible { outline: 2px solid #a07a52; outline-offset: 2px; }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #6b5d4a;
            cursor: pointer;
        }

        .form-checkbox {
            width: 14px;
            height: 14px;
            border-radius: 3px;
            border: 1.5px solid #d4a574;
            accent-color: #a07a52;
            cursor: pointer;
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.3rem;
            margin-top: 0.5rem;
        }

        /* Submit button — warm earth tone, serif italic */
        .btn-submit {
            width: 100%;
            padding: 0.85rem 1rem;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #2a2620 0%, #3a2f24 100%);
            color: #faf7f2;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            font-weight: 500;
            font-style: italic;
            letter-spacing: 0.02em;
            cursor: pointer;
            position: relative;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 4px 20px rgba(42,38,32,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow: 0 6px 28px rgba(42,38,32,0.35);
        }

        .btn-submit:active:not(:disabled) { transform: translateY(0); }

        .btn-submit:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        .btn-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(250,247,242,0.3);
            border-top-color: #faf7f2;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* Trust badges */
        .login-footer {
            text-align: center;
            margin-top: 1.25rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            color: #8a7860;
        }

        .login-footer a {
            color: #a07a52;
            font-weight: 500;
            text-decoration: none;
        }

        .login-footer a:hover { text-decoration: underline; }

        /* Help link — small, below submit, points to admin contact page */
        .help-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            margin-top: 0.85rem;
            font-size: 0.78rem;
            color: #8a7860;
        }

        .help-link a {
            color: #a07a52;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }

        .help-link a:hover { color: #7a5a3a; text-decoration: underline; }

        /* Trust badges */
        .trust-badges {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.85rem;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(180,150,110,0.22);
            font-size: 0.7rem;
            color: #8a7860;
            letter-spacing: 0.04em;
        }

        .trust-badges span {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .trust-badges svg { color: #a07a52; }

        /* Daily quote at bottom of form */
        .daily-quote {
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(180,150,110,0.22);
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.85rem;
            line-height: 1.5;
            color: #8a7860;
        }

        .daily-quote::before {
            content: '“';
            display: block;
            font-size: 1.75rem;
            line-height: 0.5;
            color: #d4a574;
            margin-bottom: 0.4rem;
        }

        /* Loading overlay */
        #loadingOverlay.hidden { display: none; }
        #loadingOverlay {
            position: fixed;
            inset: 0;
            background: rgba(42,38,32,0.96);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .pl-t { width: 80px; height: 80px; margin: 0 auto; }
        .pl__ring { stroke: rgba(212,165,116,0.18); stroke-width: 4; stroke-linecap: round; }
        .pl__worm { stroke: #d4a574; stroke-width: 4; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 40 140; animation: worm-t 2s cubic-bezier(0.42, 0, 0.58, 1) infinite; }
        @keyframes worm-t { 0% { stroke-dashoffset: 40; } 100% { stroke-dashoffset: -140; } }

        /* === Reduced motion === */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .testimonial:hover { transform: none; }
            .btn-submit:hover:not(:disabled) { transform: none; }
        }

        /* === Mobile tweaks === */
        @media (max-width: 767px) {
            .panel-right { padding: 1.5rem 1.25rem; }
            .login-card { max-width: 100%; }
            .brand-name { font-size: 2.1rem; }
            .welcome h2 { font-size: 1.3rem; }
            .testimonials, .panel-content { display: none; }
            .ribbon { display: none; }
            .ornament-top, .ornament-bottom { display: none; }
        }
    </style>
</head>
<body>

    {{-- ========== LEFT PANEL ========== --}}
    <div class="panel-left" aria-hidden="true">

        <div class="ornament-top">
            <svg width="100" height="40" viewBox="0 0 100 40" fill="none">
                <path d="M10 20 Q30 5 50 20 T90 20" stroke="currentColor" stroke-width="1.2" fill="none" stroke-linecap="round"/>
                <circle cx="50" cy="20" r="2" fill="currentColor"/>
                <path d="M40 18 Q42 14 44 18 M56 18 Q58 14 60 18" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="ornament-bottom">
            <svg width="100" height="40" viewBox="0 0 100 40" fill="none">
                <path d="M10 20 Q30 5 50 20 T90 20" stroke="currentColor" stroke-width="1.2" fill="none" stroke-linecap="round"/>
                <circle cx="50" cy="20" r="2" fill="currentColor"/>
                <path d="M40 18 Q42 14 44 18 M56 18 Q58 14 60 18" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="panel-content">
            <p class="panel-eyebrow">— Cerita dari Pasangan Kami —</p>
            <blockquote class="panel-quote">Cinta bukan tentang menemukan orang yang sempurna, tapi melihat orang yang tidak sempurna dengan cara yang sempurna.</blockquote>
            <p class="panel-attribution"><strong>Andi &amp; Sari</strong> · Jakarta, 2025</p>
        </div>

        <div class="testimonials">
            <div class="testimonial">
                <div class="testimonial-photo testimonial-photo-1" role="img" aria-label="Rina & Adi"></div>
                <div class="testimonial-body">
                    <div class="stars" aria-label="5 dari 5 bintang">★ ★ ★ ★ ★</div>
                    Tamu-tamu kami semua terkesan! Konsep digitalnya sangat modern, dan proses pesan undangannya gampang banget.
                    <strong>— Rina &amp; Adi, Bandung</strong>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-photo testimonial-photo-2" role="img" aria-label="Maya & Doni"></div>
                <div class="testimonial-body">
                    <div class="stars" aria-label="5 dari 5 bintang">★ ★ ★ ★ ★</div>
                    Tema-nya cantik-cantik, kami pilih Rustic Green. RSVP online-nya juga praktis, langsung bisa lihat konfirmasi.
                    <strong>— Maya &amp; Doni, Yogyakarta</strong>
                </div>
            </div>
            <div class="testimonial">
                <div class="testimonial-photo testimonial-photo-3" role="img" aria-label="Dewi & Reza"></div>
                <div class="testimonial-body">
                    <div class="stars" aria-label="5 dari 5 bintang">★ ★ ★ ★ ★</div>
                    Buku tamu digitalnya jadi kenangan yang bisa dibuka kapan saja. Recommended banget!
                    <strong>— Dewi &amp; Reza, Surabaya</strong>
                </div>
            </div>
        </div>

        <div class="ribbon">Cinta sejati tidak pernah berakhir</div>
    </div>

    {{-- ========== RIGHT PANEL (LOGIN FORM) ========== --}}
    <div class="panel-right">
        <div class="login-card">
            <div class="brand">
                <div class="brand-name">Temanten<span class="dot">.</span></div>
                <p class="brand-sub">Portal Klien</p>
            </div>

            <div class="ornament-divider" aria-hidden="true">
                <svg width="60" height="12" viewBox="0 0 60 12" fill="none">
                    <path d="M5 6 Q15 1 25 6 T55 6" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round"/>
                    <circle cx="30" cy="6" r="1.5" fill="currentColor"/>
                </svg>
            </div>

            <div class="welcome">
                <h2>Selamat datang kembali</h2>
                <p>Masuk untuk melanjutkan perjalanan Anda</p>
            </div>

            {{-- Session status (positive) --}}
            @if (session('status'))
                <div class="alert-status" role="status">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Top-of-form error alert (replaces inline email error) --}}
            @if ($errors->any())
                <div class="alert-error" role="alert" id="loginErrorAlert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>
                        @if ($errors->has('email'))
                            {{ $errors->first('email') }}
                        @else
                            {{ $errors->first() }}
                        @endif
                    </span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <div class="form-label-row">
                        <label class="form-label" for="email">Alamat email</label>
                    </div>
                    <div class="input-wrapper">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-input @if($errors->any()) is-invalid is-invalid-server @endif @if(old('email') && !$errors->any()) is-valid @endif"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@temanten.id"
                            aria-describedby="emailHelp"
                        >
                        <div class="input-right">
                            <span class="input-valid-icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div class="form-label-row">
                        <label class="form-label" for="password">Kata sandi</label>
                    </div>
                    <div class="input-wrapper">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input @if($errors->any()) is-invalid @endif"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        <div class="input-right">
                            <button type="button" class="input-toggle" id="togglePassword" aria-label="Tampilkan kata sandi" title="Tampilkan/sembunyikan kata sandi">
                                <svg id="eyeOffIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                                <svg id="eyeOnIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="form-row">
                    <label class="checkbox-label" for="remember_me">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="form-checkbox"
                        >
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <span class="btn-spinner" aria-hidden="true"></span>
                    <span class="btn-label">Masuk</span>
                </button>
            </form>

            {{-- Need help link → forgot-password info page (admin contact) --}}
            <div class="help-link">
                <span>Butuh bantuan masuk?</span>
                <a href="{{ route('password.request') }}">Hubungi admin →</a>
            </div>

            {{-- Trust badges --}}
            <div class="trust-badges" aria-label="Jaminan keamanan & privasi">
                <span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    SSL Aman
                </span>
                <span aria-hidden="true">·</span>
                <span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Privasi Dijaga
                </span>
                <span aria-hidden="true">·</span>
                <span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Garansi 100%
                </span>
            </div>

            {{-- Footer --}}
            <div class="login-footer">
                <p>Belum memiliki akun undangan? <a href="{{ route('order.create') }}">Pesan sekarang →</a></p>
            </div>

            {{-- Daily quote --}}
            <div class="daily-quote" id="dailyQuote">Setiap hari adalah halaman baru dalam cerita cinta kalian</div>
        </div>

        <div class="panel-right-ornament" aria-hidden="true">
            <svg width="120" height="20" viewBox="0 0 120 20" fill="none">
                <path d="M5 10 Q20 0 35 10 T65 10 T95 10 T115 10" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round"/>
                <circle cx="60" cy="10" r="2" fill="currentColor"/>
            </svg>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div id="loadingOverlay" class="hidden">
        <div>
            <div class="pl-t">
                <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path class="pl__ring" d="M15,16 L33,16 M24,16 L24,36" fill="none"/>
                    <path class="pl__worm" d="M15,16 L33,16 L24,16 L24,36" fill="none"/>
                </svg>
            </div>
            <h3 style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-style:italic; color:#faf7f2; margin-top:1.25rem;">Menyiapkan Dashboard Anda…</h3>
            <p style="color: rgba(212,165,116,0.7); font-size: 0.85rem; margin-top: 0.4rem;">Mohon tunggu sebentar.</p>
        </div>
    </div>

    <script>
        (function () {
            'use strict';

            // === Real-time email validation ===
            const emailInput = document.getElementById('email');
            if (emailInput) {
                const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
                const validateEmail = () => {
                    // Skip if there's a server-side error (don't override server state)
                    if (emailInput.classList.contains('is-invalid-server')) {
                        return;
                    }
                    const v = emailInput.value.trim();
                    if (v.length === 0) {
                        emailInput.classList.remove('is-valid');
                        return;
                    }
                    if (emailRe.test(v)) {
                        emailInput.classList.add('is-valid');
                    } else {
                        emailInput.classList.remove('is-valid');
                    }
                };
                emailInput.addEventListener('input', validateEmail);
                emailInput.addEventListener('blur', validateEmail);
                // Run once on load (in case of old value)
                validateEmail();
            }

            // === Password toggle ===
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.getElementById('togglePassword');
            const eyeOff = document.getElementById('eyeOffIcon');
            const eyeOn = document.getElementById('eyeOnIcon');
            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    eyeOff.style.display = isPassword ? 'none' : 'block';
                    eyeOn.style.display = isPassword ? 'block' : 'none';
                    toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
                    passwordInput.focus();
                });
            }

            // === Welcome back personalization (localStorage) ===
            try {
                const lastEmail = localStorage.getItem('temanten_last_email');
                if (lastEmail && emailInput && !emailInput.value) {
                    emailInput.value = lastEmail;
                    emailInput.dispatchEvent(new Event('input'));
                }
                if (emailInput) {
                    emailInput.addEventListener('change', function () {
                        if (emailInput.value) {
                            localStorage.setItem('temanten_last_email', emailInput.value);
                        }
                    });
                }
            } catch (e) { /* localStorage unavailable, skip */ }

            // === Submit button loading state ===
            const form = document.getElementById('loginForm');
            const btnSubmit = document.getElementById('btnSubmit');
            const btnLabel = btnSubmit ? btnSubmit.querySelector('.btn-label') : null;
            const btnSpinner = btnSubmit ? btnSubmit.querySelector('.btn-spinner') : null;
            if (form && btnSubmit) {
                form.addEventListener('submit', function (e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        form.reportValidity();
                        return;
                    }
                    btnSubmit.disabled = true;
                    if (btnSpinner) btnSpinner.style.display = 'inline-block';
                    if (btnLabel) btnLabel.textContent = 'Memverifikasi…';
                    // Show loading overlay
                    const overlay = document.getElementById('loadingOverlay');
                    if (overlay) overlay.classList.remove('hidden');
                });
            }

            // === Auto-focus error alert for screen readers ===
            const errAlert = document.getElementById('loginErrorAlert');
            if (errAlert) {
                errAlert.setAttribute('tabindex', '-1');
                errAlert.focus({ preventScroll: false });
            }

            // === Daily quote rotator (changes per day) ===
            const quotes = [
                'Setiap hari adalah halaman baru dalam cerita cinta kalian',
                'Cinta yang tulus adalah hadiah terindah untuk diberikan',
                'Bersama, setiap musim terasa seperti musim semi',
                'Dua hati, satu perjalanan — selamanya',
            ];
            const dq = document.getElementById('dailyQuote');
            if (dq) {
                const dayOfYear = Math.floor((Date.now() - new Date(new Date().getFullYear(), 0, 0)) / 86400000);
                dq.textContent = quotes[dayOfYear % quotes.length];
            }
        })();
    </script>
</body>
</html>
