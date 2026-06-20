@php
    use Illuminate\Support\Str;

    // Theme metadata (category, badges, features) — same source-of-truth as old catalog
    $themeMeta = [
        'pixel-adventure'  => ['category' => 'modern',      'label' => 'Modern',     'badge' => 'BARU',     'features' => ['Pixel Art', 'Game Quest', 'RSVP', 'Galeri']],
        'cherry-blossom'   => ['category' => 'floral',      'label' => 'Floral',     'badge' => '',          'features' => ['Sakura', 'Animasi', 'RSVP', 'Musik']],
        'celestial-night'  => ['category' => 'dark',        'label' => 'Malam',      'badge' => '',          'features' => ['Bintang', 'Bulan', 'RSVP', 'Musik']],
        'rustic-green'     => ['category' => 'rustic',      'label' => 'Rustic',     'badge' => '',          'features' => ['Kayu', 'Daun', 'RSVP', 'Maps']],
        'floral-pastel'    => ['category' => 'floral',      'label' => 'Floral',     'badge' => 'POPULER',  'features' => ['Bunga', 'Romantis', 'RSVP', 'Musik']],
        'royal-glass'      => ['category' => 'modern',      'label' => 'Modern',     'badge' => '',          'features' => ['Glassmorphism', 'Galeri', 'RSVP', 'Musik']],
        'barakah-love'     => ['category' => 'islami',      'label' => 'Islami',     'badge' => '',          'features' => ['Ayat Al-Quran', 'Countdown', 'RSVP', 'Musik']],
        'boho-terracotta'  => ['category' => 'boho',        'label' => 'Boho',       'badge' => '',          'features' => ['Bohemian', 'Art', 'RSVP', 'Musik']],
        'emerald-garden'   => ['category' => 'islami',      'label' => 'Islami',     'badge' => '',          'features' => ['Hijau Zamrud', 'Emas', 'RSVP', 'Musik']],
        'ocean-breeze'     => ['category' => 'modern',      'label' => 'Modern',     'badge' => 'POPULER',  'features' => ['Laut', 'Angin', 'RSVP', 'Musik']],
        'watercolor-flow'  => ['category' => 'modern',      'label' => 'Modern',     'badge' => '',          'features' => ['Cat Air', 'Artistik', 'RSVP', 'Musik']],
        'golden-sunrise'   => ['category' => 'floral',      'label' => 'Floral',     'badge' => '',          'features' => ['Emas', 'Hangat', 'RSVP', 'Musik']],
        'jawa-keraton'     => ['category' => 'traditional', 'label' => 'Tradisional','badge' => '',          'features' => ['Sogan', 'Gunungan', 'RSVP', 'Musik']],
        'midnight-garden'  => ['category' => 'dark',        'label' => 'Malam',      'badge' => '',          'features' => ['Taman Malam', 'Emas', 'RSVP', 'Musik']],
        'sekar-jagad'      => ['category' => 'traditional', 'label' => 'Tradisional','badge' => '',          'features' => ['Batik', 'Flip Card', 'RSVP', 'Musik']],
        'sunda-asih'       => ['category' => 'traditional', 'label' => 'Tradisional','badge' => '',          'features' => ['Mega Mendung', 'Rumah Panggung', 'RSVP', 'Musik']],
    ];

    // Compute counts per category
    $categoryCounts = ['all' => $themes->count()];
    foreach ($themes as $t) {
        $cat = $themeMeta[$t->slug]['category'] ?? 'modern';
        $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + 1;
    }

    // Filter category definitions in display order
    $categoryFilters = [
        'all'         => 'Semua',
        'modern'      => 'Modern',
        'islami'      => 'Islami',
        'floral'      => 'Floral',
        'rustic'      => 'Rustic',
        'boho'        => 'Boho',
        'dark'        => 'Malam',
        'traditional' => 'Tradisional',
    ];

    // Indonesian number → words (for H1 dynamic count: "Enam belas desain…", "Dua puluh tiga desain…")
    $idNumberToWords = function (int $n): string {
        $base = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
        if ($n === 0) return 'nol';
        if ($n < 10) return $base[$n];
        if ($n === 10) return 'sepuluh';
        if ($n === 11) return 'sebelas';
        if ($n < 20) return $base[$n - 10] . ' belas';
        if ($n < 100) {
            $tens = intdiv($n, 10);
            $ones = $n % 10;
            $result = $base[$tens] . ' puluh';
            if ($ones) $result .= ' ' . $base[$ones];
            return $result;
        }
        if ($n === 100) return 'seratus';
        // Fallback for >100 — keep numeric
        return (string) $n;
    };
    $themeCount = $themes->count();
    $themeCountWord = ucfirst($idNumberToWords($themeCount));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Tema · Temanten — 16+ Desain Undangan Pernikahan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @include('partials.seo', [
        'seoTitle'       => 'Katalog Tema · Temanten — 16+ Desain Undangan Pernikahan',
        'seoDescription' => 'Jelajahi 16+ desain undangan pernikahan digital eksklusif. Pilihan tema Islami, Boho, Floral, Modern, Tradisional, dan Dark. Preview langsung sebelum order.',
        'seoImage'       => asset('assets/og-image.jpg'),
        'seoType'        => 'website',
    ])

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --paper:        #f4ede0;
            --paper-deep:   #ebe1cf;
            --paper-light:  #faf6ee;
            --ink:          #1c1814;
            --ink-soft:     #2a2520;
            --brown:        #5a4a35;
            --brown-light:  #a07a52;
            --brown-soft:   #8b6f3f;
            --line:         #d4c5a0;
            --line-soft:    #e8dcc4;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background-color: var(--paper-deep);
            background-image:
                repeating-linear-gradient(45deg, rgba(160,122,82,0.025) 0 2px, transparent 2px 6px),
                radial-gradient(ellipse at top right, rgba(184,149,106,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at bottom left, rgba(160,122,82,0.05) 0%, transparent 60%);
            min-height: 100vh;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-mono    { font-family: 'JetBrains Mono', monospace; }

        /* ---------- Header ---------- */
        .site-header {
            position: sticky; top: 0; z-index: 50;
            background: rgba(250, 246, 238, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--line-soft);
        }
        .header-inner {
            max-width: 1280px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; padding: 1rem 1.25rem;
        }
        @media (min-width: 768px) { .header-inner { padding: 1.25rem 2rem; } }
        .brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600; font-size: 1.5rem;
            color: var(--ink); letter-spacing: -0.01em;
        }
        .brand .dot { color: var(--brown-light); }
        .nav { display: none; gap: 1.75rem; align-items: center; }
        @media (min-width: 768px) { .nav { display: flex; } }
        .nav a {
            font-size: 0.82rem; font-weight: 500;
            color: var(--brown); text-decoration: none;
            letter-spacing: 0.04em; text-transform: uppercase;
            transition: color 200ms;
        }
        .nav a:hover { color: var(--ink); }
        .nav a.active { color: var(--ink); border-bottom: 1px solid var(--ink); padding-bottom: 2px; }
        .btn-hairline {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.55rem 1rem;
            border: 1px solid var(--ink); border-radius: 999px;
            font-size: 0.72rem; font-weight: 600;
            color: var(--ink); text-decoration: none;
            letter-spacing: 0.12em; text-transform: uppercase;
            transition: all 200ms;
            white-space: nowrap;
        }
        .btn-hairline:hover { background: var(--ink); color: var(--paper-light); }

        /* ---------- Page wrap ---------- */
        .wrap { max-width: 1280px; margin: 0 auto; padding: 0 1.25rem; }
        @media (min-width: 768px) { .wrap { padding: 0 2rem; } }

        /* ---------- Hero title block ---------- */
        .hero { padding: 3rem 1.25rem 2rem; }
        @media (min-width: 768px) { .hero { padding: 4.5rem 2rem 3rem; } }
        .eyebrow {
            display: inline-block;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 0.85rem;
            color: var(--brown-light);
            letter-spacing: 0.18em; text-transform: uppercase;
        }
        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-style: italic;
            font-size: clamp(2.4rem, 6vw, 4.5rem);
            line-height: 1.05;
            letter-spacing: -0.01em;
            color: var(--ink);
            margin-top: 0.75rem;
            max-width: 18ch;
        }
        .hero-title .em { font-style: italic; color: var(--brown); }
        .hero-sub {
            margin-top: 1.25rem;
            font-size: 1rem; line-height: 1.6;
            color: var(--brown);
            max-width: 56ch;
        }
        .hero-rule { display: flex; align-items: center; gap: 1rem; margin: 2rem 0 1.5rem; }
        .hero-rule .line { flex: 1; height: 1px; background: var(--line); }
        .hero-rule .stat {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.9rem;
            color: var(--brown-light);
            letter-spacing: 0.1em;
            white-space: nowrap;
        }

        /* ---------- Filter bar ---------- */
        .filter-bar {
            border-top: 1px solid var(--line-soft);
            border-bottom: 1px solid var(--line-soft);
            padding: 1.25rem 0;
            margin-bottom: 2.5rem;
        }
        .filter-row {
            display: flex; flex-direction: column; gap: 1rem;
        }
        @media (min-width: 768px) {
            .filter-row { flex-direction: row; align-items: center; justify-content: space-between; gap: 1.5rem; }
        }
        .filter-tabs {
            display: flex; gap: 1.25rem; overflow-x: auto;
            scrollbar-width: none; padding-bottom: 2px;
        }
        .filter-tabs::-webkit-scrollbar { display: none; }
        .filter-tab {
            background: transparent; border: none; padding: 0.4rem 0;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem; font-weight: 500;
            color: var(--brown-light);
            letter-spacing: 0.12em; text-transform: uppercase;
            cursor: pointer; white-space: nowrap;
            border-bottom: 1.5px solid transparent;
            transition: all 200ms;
            display: inline-flex; align-items: center; gap: 0.35rem;
        }
        .filter-tab:hover { color: var(--ink); }
        .filter-tab.active { color: var(--ink); border-bottom-color: var(--ink); }
        .filter-tab .count {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.55rem; font-weight: 500;
            color: var(--brown-light);
            letter-spacing: 0;
            vertical-align: super;
            line-height: 1;
        }
        .filter-tab.active .count { color: var(--ink); }
        .filter-tools { display: flex; gap: 0.6rem; align-items: center; }
        .search-input {
            background: transparent;
            border: none; border-bottom: 1px solid var(--line);
            padding: 0.4rem 0.2rem;
            font-family: 'Inter', sans-serif; font-size: 0.85rem;
            color: var(--ink); width: 14rem;
            outline: none;
            font-style: italic;
        }
        .search-input::placeholder { color: var(--brown-light); font-style: italic; }
        .search-input:focus { border-bottom-color: var(--ink); }
        select.sort-select {
            background: transparent;
            border: none; border-bottom: 1px solid var(--line);
            padding: 0.4rem 1.5rem 0.4rem 0.2rem;
            font-family: 'Inter', sans-serif; font-size: 0.78rem;
            font-weight: 500; color: var(--brown);
            letter-spacing: 0.08em; text-transform: uppercase;
            cursor: pointer; outline: none;
            -webkit-appearance: none; appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'><path fill='none' stroke='%23a07a52' stroke-width='1.5' d='M1 1l4 4 4-4'/></svg>");
            background-repeat: no-repeat;
            background-position: right 0.2rem center;
        }
        select.sort-select:focus { border-bottom-color: var(--ink); color: var(--ink); }

        /* ---------- Cards grid ---------- */
        .grid-themes {
            display: grid; gap: 1.5rem 1.25rem;
            grid-template-columns: 1fr;
        }
        @media (min-width: 640px) { .grid-themes { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .grid-themes { grid-template-columns: repeat(3, 1fr); gap: 2.25rem 1.5rem; } }

        .card-theme {
            display: flex; flex-direction: column;
            border: 1px solid var(--line-soft);
            background: var(--paper-light);
            border-radius: 0.5rem;
            overflow: hidden;
            transition: border-color 200ms;
            cursor: pointer;
        }
        .card-theme:hover { border-color: var(--ink); }
        .card-theme:hover .thumb img { transform: scale(1.04); }
        .card-theme:hover .card-title { font-style: italic; text-decoration: underline; text-underline-offset: 4px; }
        .card-theme[data-hidden="true"] { display: none; }

        .thumb {
            position: relative;
            aspect-ratio: 4 / 5;
            background: var(--paper);
            overflow: hidden;
        }
        .thumb img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 400ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .thumb-num {
            position: absolute; top: 0.6rem; left: 0.7rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-weight: 600;
            font-size: 0.95rem;
            color: var(--paper-light);
            text-shadow: 0 1px 3px rgba(0,0,0,0.4);
            letter-spacing: 0.04em;
        }
        .thumb-badge {
            position: absolute; top: 0.65rem; right: 0.75rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-weight: 600;
            font-size: 0.78rem;
            color: var(--paper-light);
            text-shadow: 0 1px 3px rgba(0,0,0,0.55);
            letter-spacing: 0.06em;
        }
        .thumb-price {
            position: absolute; bottom: 0.6rem; right: 0.7rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem; font-weight: 500;
            color: var(--paper-light);
            background: rgba(28,24,20,0.55);
            backdrop-filter: blur(4px);
            padding: 0.25rem 0.55rem; border-radius: 0.2rem;
        }

        .card-caption { padding: 1rem 1.1rem 1.1rem; }
        .card-cat {
            font-family: 'Inter', sans-serif;
            font-size: 0.62rem; font-weight: 600;
            color: var(--brown-light);
            letter-spacing: 0.18em; text-transform: uppercase;
        }
        .card-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600; font-size: 1.45rem;
            color: var(--ink);
            margin: 0.4rem 0 0.5rem;
            line-height: 1.15;
            letter-spacing: -0.01em;
            transition: all 200ms;
        }
        .card-features {
            font-size: 0.78rem;
            color: var(--brown);
            margin-bottom: 0.85rem;
            line-height: 1.5;
        }
        .card-action {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem; font-weight: 600;
            color: var(--ink);
            text-transform: uppercase; letter-spacing: 0.16em;
            text-decoration: none;
            display: inline-flex; align-items: center; gap: 0.35rem;
            border-top: 1px solid var(--line-soft);
            padding-top: 0.85rem;
            margin-top: auto;
            transition: gap 200ms;
        }
        .card-action:hover { gap: 0.55rem; }

        /* ---------- Empty state ---------- */
        .empty {
            text-align: center; padding: 4rem 1rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 1.25rem;
            color: var(--brown-light);
            grid-column: 1 / -1;
        }

        /* ---------- CTA ---------- */
        .cta {
            margin: 5rem 0 4rem;
            padding: 3rem 2rem;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            text-align: center;
        }
        @media (min-width: 768px) { .cta { padding: 4.5rem 3rem; } }
        .cta-quote {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: clamp(1.4rem, 3vw, 2rem);
            line-height: 1.4;
            color: var(--ink);
            max-width: 32ch; margin: 0 auto 2rem;
        }
        .btn-dark {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: var(--ink); color: var(--paper-light);
            padding: 0.95rem 1.6rem; border-radius: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.14em;
            text-decoration: none;
            transition: background 200ms;
            border: 1px solid var(--ink);
        }
        .btn-dark:hover { background: var(--ink-soft); }

        /* ---------- Footer ---------- */
        .site-footer {
            padding: 2rem 0 3rem;
            text-align: center;
        }
        .footer-rule { height: 1px; background: var(--line-soft); margin: 0 auto 1.5rem; max-width: 8rem; }
        .footer-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.95rem;
            color: var(--brown-light);
            letter-spacing: 0.04em;
        }

        /* ---------- Empty cover fallback ---------- */
        .thumb-fallback {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 2rem; color: var(--brown-light);
            background: linear-gradient(135deg, var(--paper-light) 0%, var(--paper-deep) 100%);
        }

        /* ---------- Preview modal (consistent with landing) ---------- */
        .preview-modal {
            position: fixed; inset: 0; z-index: 9999;
            background: rgba(28, 22, 14, 0.85);
            display: none;
            align-items: center; justify-content: center;
            padding: 1.5rem;
            backdrop-filter: blur(4px);
        }
        .preview-modal.open { display: flex; }
        .preview-frame {
            position: relative;
            width: 100%; max-width: 1100px; height: 90vh;
            background: var(--paper-light);
            border: 1px solid var(--line);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .preview-frame iframe { width: 100%; height: 100%; border: 0; display: block; }
        .preview-loader {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 1.25rem;
            background: linear-gradient(135deg, #f5ede0 0%, #ebe0c8 100%);
            z-index: 5;
            transition: opacity 300ms ease;
        }
        .preview-loader.hidden { opacity: 0; pointer-events: none; }
        .preview-spinner {
            width: 3rem; height: 3rem;
            border: 3px solid rgba(184, 149, 106, 0.2);
            border-top-color: #b8956a;
            border-radius: 50%;
            animation: preview-spin 800ms linear infinite;
        }
        @keyframes preview-spin {
            to { transform: rotate(360deg); }
        }
        .preview-loader-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1rem;
            color: #5c4a30;
            letter-spacing: 0.02em;
        }
        .preview-loader-dots::after {
            content: '';
            display: inline-block;
            width: 1.2em;
            text-align: left;
            animation: preview-dots 1.4s steps(4, end) infinite;
        }
        @keyframes preview-dots {
            0%   { content: ''; }
            25%  { content: '.'; }
            50%  { content: '..'; }
            75%  { content: '...'; }
            100% { content: ''; }
        }
        .preview-close {
            position: absolute; top: 0.5rem; right: 0.5rem;
            background: rgba(244, 237, 224, 0.95);
            backdrop-filter: blur(6px);
            border: 1px solid var(--line);
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-size: 0.95rem;
            color: var(--ink);
            cursor: pointer;
            padding: 0.4rem 0.85rem;
            letter-spacing: 0.04em;
            transition: all 200ms;
            z-index: 10;
        }
        .preview-close:hover {
            background: var(--ink);
            color: var(--paper-light);
            border-color: var(--ink);
        }

        /* Thumb hint on hover */
        .thumb { position: relative; display: block; cursor: zoom-in; }
        .thumb::after {
            content: 'LIHAT PREVIEW';
            position: absolute; inset: 0;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.2em;
            color: var(--paper-light);
            background: rgba(28, 22, 14, 0.55);
            opacity: 0;
            transition: opacity 250ms;
            pointer-events: none;
        }
        .thumb:hover::after { opacity: 1; }
        .thumb:hover img { transform: scale(1.02); }
        .thumb img { transition: transform 400ms ease; }
    </style>
</head>
<body>

{{-- ============ HEADER ============ --}}
<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}" class="brand">Tementen<span class="dot">.</span></a>
        <nav class="nav">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('themes.index') }}" class="active">Katalog</a>
            <a href="{{ route('order.create') }}">Pesan</a>
            <a href="{{ route('login') }}">Masuk</a>
        </nav>
        <a href="{{ route('order.create') }}" class="btn-hairline">
            Buat Undangan
            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</header>

{{-- ============ HERO ============ --}}
<section class="hero wrap">
    <span class="eyebrow">Edisi 01 · Koleksi Tema · Musim 2026</span>
    <h1 class="hero-title">Koleksi desain <span class="em">pilihan</span> untuk hari istimewa Anda.</h1>
    <p class="hero-sub">
        Pilih tema yang paling sesuai dengan kepribadian dan gaya pernikahan Anda. Setiap tema sudah responsif di semua perangkat, siap pakai, dan dapat disesuaikan melalui dashboard setelah pemesanan.
    </p>
    <div class="hero-rule">
        <span class="line"></span>
        <span class="stat">{{ $themes->count() }} Tema · {{ count($categoryFilters) - 1 }} Kategori · Sejak 2026</span>
        <span class="line"></span>
    </div>
</section>

{{-- ============ FILTER ============ --}}
<section class="filter-bar">
    <div class="wrap filter-row">
        <div class="filter-tabs" id="filterTabs">
            @foreach($categoryFilters as $key => $label)
                <button class="filter-tab {{ $key === 'all' ? 'active' : '' }}" data-filter="{{ $key }}">
                    {{ $label }}<span class="count">{{ $categoryCounts[$key] ?? 0 }}</span>
                </button>
            @endforeach
        </div>
        <div class="filter-tools">
            <input type="text" id="searchInput" class="search-input" placeholder="Cari tema favorit…">
            <select id="sortSelect" class="sort-select">
                <option value="default">Urut</option>
                <option value="newest">Terbaru</option>
                <option value="name-asc">Nama A–Z</option>
                <option value="name-desc">Nama Z–A</option>
            </select>
        </div>
    </div>
</section>

{{-- ============ CARDS ============ --}}
<section class="wrap">
    <div class="grid-themes" id="themesGrid">
        @forelse($themes as $idx => $theme)
            @php
                $meta = $themeMeta[$theme->slug] ?? ['category' => 'modern', 'label' => 'Modern', 'badge' => '', 'features' => ['Responsive', 'Galeri', 'RSVP']];
                $thumb = asset('storage/themes/thumbnails/' . $theme->thumbnail);
                $price = $theme->effective_price ?? config('app.default_price');
                $number = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                $createdTs = $theme->created_at ? $theme->created_at->timestamp : 0;
            @endphp
            <article class="card-theme"
                     data-category="{{ $meta['category'] }}"
                     data-name="{{ strtolower($theme->name) }}"
                     data-price="{{ $price }}"
                     data-created="{{ $createdTs }}"
                     data-hidden="false">
                <a href="javascript:void(0)" onclick="openPreview('{{ route('demo.show', $theme->slug) }}')" class="thumb" aria-label="Lihat preview {{ $theme->name }}">
                    @if($theme->thumbnail && file_exists(storage_path('app/public/themes/thumbnails/' . $theme->thumbnail)))
                        <img src="{{ $thumb }}" alt="{{ $theme->name }}" loading="eager" decoding="async">
                    @else
                        <div class="thumb-fallback">{{ Str::limit($theme->name, 1, '') }}</div>
                    @endif
                    <span class="thumb-num">{{ $number }}</span>
                    @if($meta['badge'])
                        <span class="thumb-badge">{{ $meta['badge'] }}</span>
                    @endif
                    <span class="thumb-price">Rp {{ number_format($price / 1000, 0) }}K</span>
                </a>
                <div class="card-caption">
                    <div class="card-cat">{{ $meta['label'] }}</div>
                    <h3 class="card-title">{{ $theme->name }}</h3>
                    <p class="card-features">{{ implode(' · ', $meta['features']) }}</p>
                    <a href="{{ route('order.create', ['theme' => $theme->slug]) }}" class="card-action">
                        Pilih Tema
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </article>
        @empty
            <div class="empty">Tidak ada tema ditemukan.</div>
        @endforelse
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="cta wrap">
    <p class="cta-quote">
        “Hari bahagia Anda layak dimulai dengan cara yang paling indah.”
    </p>
    <a href="{{ route('order.create') }}" class="btn-dark">
        Mulai Buat Undangan
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
    </a>
</section>

{{-- ============ FOOTER ============ --}}
<footer class="site-footer">
    <div class="footer-rule"></div>
    <p class="footer-text">Tementen · Edisi 2026 · Vol. 1</p>
</footer>

<!-- Preview modal -->
<div class="preview-modal" id="previewModal">
    <div class="preview-frame">
        <button class="preview-close" type="button" onclick="closePreview()">Tutup ✕</button>
        <div class="preview-loader" id="previewLoader">
            <div class="preview-spinner" aria-hidden="true"></div>
            <div class="preview-loader-text">Memuat preview<span class="preview-loader-dots"></span></div>
        </div>
        <iframe id="previewFrame" src="" title="Preview" loading="lazy" onload="hidePreviewLoader()"></iframe>
    </div>
</div>

<script>
(function() {
    const grid = document.getElementById('themesGrid');
    if (!grid) return;
    const cards = Array.from(grid.querySelectorAll('.card-theme'));
    const tabs = document.querySelectorAll('.filter-tab');
    const search = document.getElementById('searchInput');
    const sortSel = document.getElementById('sortSelect');

    let activeFilter = 'all';
    let searchQuery = '';

    function applyFilter() {
        let visible = 0;
        cards.forEach(card => {
            const cat = card.dataset.category;
            const name = card.dataset.name;
            const matchesCat = activeFilter === 'all' || cat === activeFilter;
            const matchesSearch = !searchQuery || name.includes(searchQuery);
            const show = matchesCat && matchesSearch;
            card.dataset.hidden = show ? 'false' : 'true';
            if (show) visible++;
        });
        // Empty state
        let empty = grid.querySelector('.empty');
        if (visible === 0 && !empty) {
            empty = document.createElement('div');
            empty.className = 'empty';
            empty.textContent = 'Tidak ada tema cocok dengan filter ini.';
            grid.appendChild(empty);
        } else if (visible > 0 && empty) {
            empty.remove();
        }
    }

    function applySort() {
        const mode = sortSel.value;
        if (mode === 'default') {
            // restore natural order — re-insert in original DOM order
            cards.sort((a, b) => 0);
        } else if (mode === 'name-asc') {
            cards.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
        } else if (mode === 'name-desc') {
            cards.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
        } else if (mode === 'newest') {
            cards.sort((a, b) => parseInt(b.dataset.created) - parseInt(a.dataset.created));
        }
        cards.forEach(c => grid.appendChild(c));
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activeFilter = tab.dataset.filter;
            applyFilter();
        });
    });

    search.addEventListener('input', e => {
        searchQuery = e.target.value.toLowerCase().trim();
        applyFilter();
    });

    sortSel.addEventListener('change', applySort);
})();

// Preview modal (consistent with landing #tema section)
function hidePreviewLoader() {
    const loader = document.getElementById('previewLoader');
    if (loader) loader.classList.add('hidden');
}
window.openPreview = function(url) {
    const modal = document.getElementById('previewModal');
    const frame = document.getElementById('previewFrame');
    const loader = document.getElementById('previewLoader');
    if (!modal || !frame) return;
    if (loader) loader.classList.remove('hidden');
    frame.src = url;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
};
window.closePreview = function() {
    const modal = document.getElementById('previewModal');
    if (!modal) return;
    modal.classList.remove('open');
    const frame = document.getElementById('previewFrame');
    if (frame) frame.src = '';
    const loader = document.getElementById('previewLoader');
    if (loader) loader.classList.remove('hidden');
    document.body.style.overflow = '';
};
document.getElementById('previewModal').addEventListener('click', (e) => {
    if (e.target.id === 'previewModal') closePreview();
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closePreview();
});
</script>
</body>
</html>
