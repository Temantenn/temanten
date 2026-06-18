<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hubungi Admin — Temanten</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f4ede0;
            color: #2a2620;
            -webkit-font-smoothing: antialiased;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(180,150,110,0.10) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(160,120,90,0.08) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' /%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.4'/%3E%3C/svg%3E");
        }

        .wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
        }

        .card {
            width: 100%;
            max-width: 440px;
            background: rgba(255,253,247,0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(180,150,110,0.3);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 12px 40px rgba(122,90,58,0.10);
            text-align: center;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: rgba(212,165,116,0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            color: #a07a52;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 500;
            color: #2a2620;
            line-height: 1;
            margin-bottom: 0.4rem;
        }

        .brand-name .dot { color: #d4a574; }

        .ornament-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1.25rem auto;
            color: #b08765;
        }

        .ornament-divider svg { opacity: 0.6; }

        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 500;
            color: #2a2620;
            margin-bottom: 0.6rem;
        }

        p.lead {
            font-size: 0.9rem;
            color: #6b5d4a;
            line-height: 1.6;
            margin-bottom: 1.75rem;
        }

        .contact-card {
            background: rgba(255,253,247,0.6);
            border: 1px solid rgba(180,150,110,0.25);
            border-radius: 12px;
            padding: 1.1rem 1.25rem;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .contact-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .contact-row + .contact-row { margin-top: 0.85rem; padding-top: 0.85rem; border-top: 1px solid rgba(180,150,110,0.18); }

        .contact-row svg { color: #a07a52; flex-shrink: 0; margin-top: 0.1rem; }

        .contact-row strong {
            color: #2a2620;
            font-weight: 500;
            display: block;
            margin-bottom: 0.15rem;
        }

        .contact-row a { color: #a07a52; text-decoration: none; font-weight: 500; }
        .contact-row a:hover { text-decoration: underline; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.82rem;
            color: #a07a52;
            text-decoration: none;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .back-link:hover { text-decoration: underline; color: #7a5a3a; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="icon-circle" aria-hidden="true">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>

            <div class="brand-name">Temanten<span class="dot">.</span></div>

            <div class="ornament-divider" aria-hidden="true">
                <svg width="60" height="12" viewBox="0 0 60 12" fill="none">
                    <path d="M5 6 Q15 1 25 6 T55 6" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round"/>
                    <circle cx="30" cy="6" r="1.5" fill="currentColor"/>
                </svg>
            </div>

            <h1>Reset kata sandi lewat admin</h1>
            <p class="lead">Untuk menjaga keamanan data Anda, pengaturan ulang kata sandi dilakukan secara manual oleh tim admin kami.</p>

            <div class="contact-card">
                <div class="contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <strong>Email</strong>
                        <a href="mailto:admin@temanten.id">admin@temanten.id</a>
                    </div>
                </div>
                <div class="contact-row">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <div>
                        <strong>WhatsApp</strong>
                        Chat admin dengan menyertakan email akun Anda
                    </div>
                </div>
            </div>

            <a href="{{ route('login') }}" class="back-link">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke halaman masuk
            </a>
        </div>
    </div>
</body>
</html>
