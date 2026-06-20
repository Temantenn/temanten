<?php
    /* ---------------------------------------------------------------
     * THEME METADATA — sama dengan catalog.blade.php untuk konsistensi
     * key: slug → category key, label Indonesia, badge, features
     * --------------------------------------------------------------- */
    $themeMeta = [
        'pixel-adventure'   => ['category' => 'modern',      'label' => 'Modern',      'badge' => 'BARU'],
        'cherry-blossom'    => ['category' => 'floral',      'label' => 'Floral',      'badge' => ''],
        'celestial-night'   => ['category' => 'dark',        'label' => 'Malam',       'badge' => 'POPULER'],
        'rustic-green'      => ['category' => 'rustic',      'label' => 'Rustic',      'badge' => ''],
        'floral-pastel'     => ['category' => 'floral',      'label' => 'Floral',      'badge' => ''],
        'royal-glass'       => ['category' => 'modern',      'label' => 'Modern',      'badge' => 'BARU'],
        'barakah-love'      => ['category' => 'islami',      'label' => 'Islami',      'badge' => 'POPULER'],
        'boho-terracotta'   => ['category' => 'boho',        'label' => 'Boho',        'badge' => ''],
        'emerald-garden'    => ['category' => 'floral',      'label' => 'Floral',      'badge' => ''],
        'ocean-breeze'      => ['category' => 'modern',      'label' => 'Modern',      'badge' => ''],
        'watercolor-flow'   => ['category' => 'floral',      'label' => 'Floral',      'badge' => ''],
        'golden-sunrise'    => ['category' => 'modern',      'label' => 'Modern',      'badge' => 'BARU'],
        'jawa-keraton'      => ['category' => 'traditional', 'label' => 'Tradisional', 'badge' => ''],
        'midnight-garden'   => ['category' => 'dark',        'label' => 'Malam',       'badge' => ''],
        'sekar-jagad'       => ['category' => 'traditional', 'label' => 'Tradisional', 'badge' => ''],
        'sunda-asih'        => ['category' => 'traditional', 'label' => 'Tradisional', 'badge' => 'BARU'],
    ];

    $featuredThemes = \App\Models\Theme::where('is_active', true)->orderBy('id')->take(3)->get();
    $totalThemes    = \App\Models\Theme::where('is_active', true)->count();

    /* Kategori dinamis: hitung distinct category dari tema aktif saja.
       Pakai $themeMeta key 'category' (sama sumbernya dengan catalog). */
    $categoryCount = $featuredThemes->isEmpty() && $totalThemes === 0
        ? 0
        : \App\Models\Theme::where('is_active', true)
            ->get()
            ->map(fn($t) => $themeMeta[$t->slug]['category'] ?? 'modern')
            ->unique()
            ->count();

    /* Tahun "Sejak" dinamis dari tema paling lama. Fallback ke tahun ini. */
    $sinceYear = \App\Models\Theme::min('created_at')
        ? \Carbon\Carbon::parse(\App\Models\Theme::min('created_at'))->year
        : (int) date('Y');

    $heroTheme      = $featuredThemes->first() ?? \App\Models\Theme::first();
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEMANTEN — Platform Undangan Digital Elegan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @include('partials.seo', [
        'seoTitle'       => 'TEMANTEN — Platform Undangan Digital Elegan',
        'seoDescription' => 'Buat undangan pernikahan digital yang elegan dan modern. 16+ tema eksklusif Islami, Boho, Floral, Modern, Tradisional. RSVP, galeri, musik, dan amplop digital dalam satu paket.',
        'seoImage'       => asset('assets/og-image.jpg'),
        'seoType'        => 'website',
    ])

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --paper: #f4ede0;
            --paper-light: #faf5ec;
            --paper-deep: #ebe1ce;
            --ink: #2a1f12;
            --brown: #5c4a3a;
            --brown-light: #8c7a64;
            --brown-soft: #b5a48e;
            --line: rgba(58,42,26,0.18);
            --line-soft: rgba(58,42,26,0.08);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .wrap { max-width: 1200px; margin: 0 auto; padding: 0 1.25rem; }
        @media (min-width: 768px) { .wrap { padding: 0 2rem; } }

        .serif { font-family: 'Cormorant Garamond', serif; }
        .italic-serif { font-family: 'Cormorant Garamond', serif; font-style: italic; }
        .mono { font-family: 'JetBrains Mono', monospace; }

        .eyebrow {
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            color: var(--brown);
        }

        .btn-dark {
            display: inline-flex; align-items: center; gap: 0.55rem;
            background: var(--ink); color: var(--paper-light);
            padding: 0.9rem 1.5rem; border: 1px solid var(--ink);
            font-family: 'Inter', sans-serif;
            font-size: 0.76rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.16em;
            text-decoration: none;
            transition: background 200ms, gap 200ms;
            cursor: pointer;
        }
        .btn-dark:hover { background: var(--brown); gap: 0.75rem; }

        .btn-line {
            display: inline-flex; align-items: center; gap: 0.55rem;
            background: transparent; color: var(--ink);
            padding: 0.9rem 1.5rem; border: 1px solid var(--ink);
            font-family: 'Inter', sans-serif;
            font-size: 0.76rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.16em;
            text-decoration: none;
            transition: background 200ms, color 200ms, gap 200ms;
            cursor: pointer;
        }
        .btn-line:hover { background: var(--ink); color: var(--paper-light); gap: 0.75rem; }

        /* ============= NAV ============= */
        .site-nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(244, 237, 224, 0.92);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line-soft);
        }
        .nav-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.9rem 1.25rem;
            max-width: 1200px; margin: 0 auto;
            gap: 1rem;
        }
        @media (min-width: 768px) { .nav-row { padding: 1rem 2rem; } }

        .nav-brand {
            display: flex; align-items: center; gap: 0.6rem;
            text-decoration: none; color: var(--ink);
        }
        .nav-brand-mark {
            width: 32px; height: 32px;
            border: 1px solid var(--line);
            overflow: hidden;
        }
        .nav-brand-mark img { width: 100%; height: 100%; object-fit: cover; }
        .nav-brand-text { display: flex; flex-direction: column; line-height: 1.05; }
        .nav-brand-text .name {
            font-family: 'Inter', sans-serif;
            font-weight: 700; font-size: 0.92rem; letter-spacing: 0.06em;
        }
        .nav-brand-text .sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.7rem; color: var(--brown);
            letter-spacing: 0.04em;
        }

        .nav-links { display: none; gap: 1.75rem; align-items: center; }
        @media (min-width: 768px) { .nav-links { display: flex; } }
        .nav-links a {
            color: var(--ink); text-decoration: none;
            font-weight: 500; font-size: 0.85rem;
            position: relative;
            padding-bottom: 2px;
        }
        .nav-links a::after {
            content: ''; position: absolute; left: 0; right: 0; bottom: -2px;
            height: 1px; background: var(--ink);
            transform: scaleX(0); transform-origin: left;
            transition: transform 220ms;
        }
        .nav-links a:hover::after { transform: scaleX(1); }

        .nav-cta { display: flex; align-items: center; gap: 0.5rem; }
        .nav-cta .nav-auth {
            color: var(--ink); text-decoration: none;
            font-size: 0.78rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.14em;
            padding: 0.5rem 0.85rem;
            border: 1px solid var(--line);
        }
        @media (max-width: 479px) {
            .nav-cta .nav-auth {
                padding: 0.45rem 0.6rem;
                font-size: 0.7rem;
                letter-spacing: 0.1em;
            }
        }
        .nav-cta .nav-auth:hover { border-color: var(--ink); font-style: italic; }
        .nav-cta .btn-dark { padding: 0.7rem 1.1rem; font-size: 0.7rem; }

        .nav-menu-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 36px; height: 36px;
            background: transparent; border: 1px solid var(--line);
            cursor: pointer; color: var(--ink);
            padding: 0;
        }
        @media (min-width: 768px) { .nav-menu-btn { display: none; } }
        .nav-menu-btn:hover { border-color: var(--ink); }

        /* Mobile menu panel */
        .mobile-panel {
            position: fixed; left: 0; right: 0; top: 60px;
            background: var(--paper);
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: 1.5rem 1.25rem 2rem;
            transform: translateY(-110%);
            opacity: 0;
            transition: transform 280ms, opacity 280ms;
            pointer-events: none;
            z-index: 99;
        }
        .mobile-panel.open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
        .mobile-panel a.mobile-link {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            color: var(--ink);
            text-decoration: none;
            padding: 0.85rem 0;
            border-bottom: 1px solid var(--line-soft);
        }
        .mobile-panel a.mobile-link:hover { font-style: italic; }
        .mobile-panel .mobile-link-secondary {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: var(--brown);
            border: 1px solid var(--line);
            padding: 0.85rem 1rem;
            margin-top: 1rem;
            border-radius: 0;
            background: transparent;
        }
        .mobile-panel .mobile-link-secondary:hover {
            background: var(--ink);
            color: var(--paper-light);
            font-style: normal;
            border-color: var(--ink);
        }
        .mobile-panel .mobile-link-secondary svg { flex-shrink: 0; }
        .mobile-panel .mobile-cta {
            margin-top: 1.25rem;
            display: block;
            text-align: center;
        }

        /* ============= HERO ============= */
        .hero { padding: 4.5rem 0 3.5rem; }
        @media (min-width: 768px) { .hero { padding: 6.5rem 0 5rem; } }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: center;
        }
        @media (min-width: 960px) {
            .hero-grid { grid-template-columns: 1.15fr 0.85fr; gap: 4rem; }
        }

        .hero-eyebrow { display: block; margin-bottom: 1.5rem; }
        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: clamp(2.4rem, 6vw, 4.4rem);
            line-height: 1.04;
            letter-spacing: -0.012em;
            margin: 0 0 1.5rem;
            max-width: 18ch;
            color: var(--ink);
        }
        .hero-title .em { font-style: italic; font-weight: 400; }
        .hero-sub {
            font-size: 1rem;
            line-height: 1.7;
            color: var(--brown);
            max-width: 52ch;
            margin: 0 0 2.25rem;
        }
        .hero-cta { display: flex; flex-wrap: wrap; gap: 0.7rem; margin-bottom: 2.5rem; }
        .hero-rule { display: flex; align-items: center; gap: 1rem; max-width: 540px; }
        .hero-rule .line { flex: 1; height: 1px; background: var(--line); }
        .hero-rule .stat {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.68rem; letter-spacing: 0.16em;
            color: var(--brown);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .hero-visual {
            position: relative;
            aspect-ratio: 4/5;
            background: var(--paper-deep);
            border: 1px solid var(--line);
            overflow: hidden;
            max-width: 460px;
            margin: 0 auto;
            width: 100%;
        }
        .hero-visual img {
            width: 100%; height: 100%; object-fit: cover;
            display: block;
        }
        .hero-visual-cap {
            position: absolute; bottom: 1rem; left: 1rem;
            background: var(--paper);
            padding: 0.55rem 0.9rem;
            border: 1px solid var(--line);
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.85rem;
            color: var(--ink);
            letter-spacing: 0.02em;
        }
        .hero-visual-mark {
            position: absolute; top: 1rem; right: 1rem;
            background: var(--paper);
            padding: 0.4rem 0.75rem;
            border: 1px solid var(--line);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.18em;
            color: var(--brown);
            text-transform: uppercase;
        }

        /* ============= SECTION HEADERS ============= */
        .section { padding: 4.5rem 0; }
        @media (min-width: 768px) { .section { padding: 6.5rem 0; } }
        .section.tinted { background: var(--paper-light); }

        .section-head { text-align: center; margin-bottom: 3.5rem; }
        .section-head .eyebrow { display: block; margin-bottom: 1.25rem; }
        .section-head .title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: clamp(1.9rem, 4vw, 2.75rem);
            line-height: 1.12;
            letter-spacing: -0.005em;
            margin: 0 0 1rem;
        }
        .section-head .title .em { font-style: italic; }
        .section-head .sub {
            font-size: 0.98rem;
            color: var(--brown);
            max-width: 56ch;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ============= TEMA SECTION ============= */
        .tema-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        @media (min-width: 640px) { .tema-grid { grid-template-columns: repeat(3, 1fr); } }

        .tema-card {
            background: var(--paper-light);
            border: 1px solid var(--line);
            overflow: hidden;
            transition: border-color 220ms;
        }
        .tema-card:hover { border-color: var(--ink); }

        .tema-card-img {
            position: relative;
            display: block;
            aspect-ratio: 3/4;
            background: var(--paper-deep);
            overflow: hidden;
        }
        .tema-card-img img {
            width: 100%; height: 100%; object-fit: cover;
            display: block;
            transition: transform 500ms ease;
        }
        .tema-card:hover .tema-card-img img { transform: scale(1.03); }

        .tema-card-num {
            position: absolute; top: 0.7rem; left: 0.7rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.66rem; letter-spacing: 0.1em;
            color: var(--paper-light);
            background: rgba(42,31,18,0.78);
            padding: 0.28rem 0.5rem;
        }
        .tema-card-cat {
            position: absolute; top: 0.7rem; right: 0.7rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.82rem;
            color: var(--paper-light);
            background: rgba(42,31,18,0.78);
            padding: 0.28rem 0.6rem;
            letter-spacing: 0.02em;
        }

        .tema-card-body { padding: 1.1rem 1.2rem 1.35rem; }
        .tema-card-name {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 1.4rem;
            line-height: 1.15;
            margin: 0 0 0.45rem;
        }
        .tema-card-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.66rem;
            letter-spacing: 0.14em;
            color: var(--brown-light);
            text-transform: uppercase;
            margin-bottom: 0.85rem;
        }
        .tema-card-price {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 1.3rem;
            color: var(--ink);
            margin-bottom: 1rem;
            line-height: 1;
        }
        .tema-card-action {
            display: inline-flex; align-items: center; gap: 0.4rem;
            font-size: 0.74rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.14em;
            color: var(--ink); text-decoration: none;
            border-bottom: 1px solid var(--ink);
            padding-bottom: 2px;
            transition: gap 200ms;
        }
        .tema-card-action:hover { gap: 0.6rem; }

        .tema-cta { text-align: center; margin-top: 3.5rem; }

        /* ============= FITUR SECTION ============= */
        .fitur-grid {
            display: grid;
            grid-template-columns: 1fr;
            border-top: 1px solid var(--line);
            border-left: 1px solid var(--line);
        }
        @media (min-width: 640px) { .fitur-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 960px) { .fitur-grid { grid-template-columns: repeat(3, 1fr); } }

        .fitur-item {
            padding: 2rem 1.5rem;
            border-right: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            background: var(--paper);
        }
        .fitur-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            color: var(--brown-light);
            letter-spacing: 0.18em;
            margin-bottom: 1rem;
        }
        .fitur-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-style: italic;
            font-size: 1.4rem;
            line-height: 1.2;
            margin: 0 0 0.8rem;
        }
        .fitur-desc {
            font-size: 0.9rem;
            color: var(--brown);
            line-height: 1.65;
            margin: 0;
        }

        /* ============= CARA KERJA ============= */
        .steps {
            display: grid;
            grid-template-columns: 1fr;
            border-top: 1px solid var(--line);
            border-left: 1px solid var(--line);
        }
        @media (min-width: 640px) { .steps { grid-template-columns: repeat(3, 1fr); } }

        .step {
            padding: 2.25rem 1.5rem;
            border-right: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            background: var(--paper);
        }
        .step-roman {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-style: italic;
            font-size: 2.3rem;
            line-height: 1;
            color: var(--brown-soft);
            margin-bottom: 1rem;
        }
        .step-title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 1.3rem;
            margin: 0 0 0.55rem;
        }
        .step-desc {
            font-size: 0.9rem;
            color: var(--brown);
            line-height: 1.65;
            margin: 0;
        }

        /* ============= PULL QUOTE ============= */
        .pullquote {
            padding: 4.5rem 0;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            text-align: center;
        }
        .pullquote-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 400;
            font-size: clamp(1.5rem, 3vw, 2.15rem);
            line-height: 1.35;
            color: var(--ink);
            max-width: 32ch;
            margin: 0 auto 1.25rem;
        }
        .pullquote-attr {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.2em;
            color: var(--brown);
            text-transform: uppercase;
        }

        /* ============= CTA FINAL ============= */
        .cta-final { text-align: center; padding: 5.5rem 0; }
        .cta-final .eyebrow { display: block; margin-bottom: 1rem; }
        .cta-final .title {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: clamp(1.9rem, 4vw, 2.75rem);
            line-height: 1.12;
            max-width: 22ch;
            margin: 0 auto 1.25rem;
        }
        .cta-final .title .em { font-style: italic; }
        .cta-final .sub {
            font-size: 0.98rem;
            color: var(--brown);
            max-width: 48ch;
            margin: 0 auto 2.25rem;
            line-height: 1.7;
        }

        /* ============= FAQ ============= */
        .faq-list { max-width: 720px; margin: 0 auto; }
        .faq-item { border-bottom: 1px solid var(--line); }
        .faq-item:first-child { border-top: 1px solid var(--line); }
        .faq-q {
            width: 100%;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.4rem 0;
            background: transparent; border: none;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 1.2rem;
            line-height: 1.3;
            color: var(--ink);
            text-align: left;
            cursor: pointer;
            gap: 1rem;
        }
        .faq-q:hover { font-style: italic; }
        .faq-q .icon {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.4rem;
            color: var(--brown);
            transition: transform 220ms;
            flex-shrink: 0;
            line-height: 1;
        }
        .faq-item.open .faq-q .icon { transform: rotate(45deg); }
        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height 320ms ease;
            font-size: 0.92rem;
            color: var(--brown);
            line-height: 1.7;
        }
        .faq-item.open .faq-a { max-height: 400px; }
        .faq-a-inner { padding: 0 0 1.5rem; max-width: 60ch; }

        /* ============= FOOTER ============= */
        .site-footer {
            padding: 3rem 0 2rem;
            border-top: 1px solid var(--line);
            background: var(--paper-light);
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2.25rem;
            margin-bottom: 2.5rem;
        }
        @media (min-width: 768px) {
            .footer-grid { grid-template-columns: 1.6fr 1fr 1fr 1fr; gap: 2.5rem; }
        }
        .footer-brand .name {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.06em;
            margin-bottom: 0.35rem;
        }
        .footer-brand .tag {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: var(--brown);
            font-size: 0.88rem;
            margin-bottom: 0.85rem;
        }
        .footer-brand .desc {
            font-size: 0.85rem;
            color: var(--brown);
            line-height: 1.6;
            margin: 0;
            max-width: 36ch;
        }
        .footer-col h4 {
            font-family: 'JetBrains Mono', monospace;
            text-transform: uppercase;
            font-size: 0.68rem;
            letter-spacing: 0.2em;
            color: var(--brown);
            margin: 0 0 0.9rem;
            font-weight: 500;
        }
        .footer-col ul { list-style: none; margin: 0; padding: 0; }
        .footer-col li { margin-bottom: 0.55rem; }
        .footer-col a {
            color: var(--ink); text-decoration: none;
            font-size: 0.9rem;
        }
        .footer-col a:hover { font-style: italic; }
        .footer-bottom {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 0.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--line-soft);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.66rem;
            letter-spacing: 0.16em;
            color: var(--brown);
            text-transform: uppercase;
        }

        /* Preview modal */
        .preview-modal {
            position: fixed; inset: 0;
            background: rgba(42,31,18,0.88);
            z-index: 1000;
            display: none; align-items: center; justify-content: center;
            padding: 1.25rem;
        }
        .preview-modal.open { display: flex; }
        .preview-frame {
            background: var(--paper);
            width: 100%; max-width: 420px; height: 86vh;
            max-height: 820px;
            border: 1px solid var(--line);
            position: relative;
        }
        .preview-frame iframe { width: 100%; height: 100%; border: 0; display: block; }
        .preview-loader {
            position: absolute; inset: 0;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            gap: 1rem;
            background: linear-gradient(135deg, var(--paper) 0%, #ebe0c8 100%);
            z-index: 5;
            transition: opacity 300ms ease;
        }
        .preview-loader.hidden { opacity: 0; pointer-events: none; }
        .preview-spinner {
            width: 2.5rem; height: 2.5rem;
            border: 3px solid rgba(184, 149, 106, 0.2);
            border-top-color: var(--brown-light);
            border-radius: 50%;
            animation: preview-spin 800ms linear infinite;
        }
        @keyframes preview-spin { to { transform: rotate(360deg); } }
        .preview-loader-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem; letter-spacing: 0.14em;
            color: var(--brown);
            text-transform: uppercase;
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
            color: var(--ink);
            background: rgba(244, 237, 224, 0.95);
            backdrop-filter: blur(6px);
            border: 1px solid var(--line);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem; letter-spacing: 0.14em;
            cursor: pointer;
            text-transform: uppercase;
            padding: 0.4rem 0.75rem;
            z-index: 10;
            transition: all 200ms;
        }
        .preview-close:hover {
            background: var(--ink);
            color: var(--paper-light);
            border-color: var(--ink);
        }
    </style>
</head>
<body>

<!-- ================= NAV ================= -->
<nav class="site-nav">
    <div class="nav-row">
        <a href="#" class="nav-brand">
            <span class="nav-brand-mark">
                <img src="{{ asset('assets/mini-logo.webp') }}" alt="Temanten">
            </span>
            <span class="nav-brand-text">
                <span class="name">TEMANTEN</span>
                <span class="sub">Digital Invitation</span>
            </span>
        </a>

        <div class="nav-links">
            <a href="#fitur">Fitur</a>
            <a href="{{ route('themes.index') }}">Katalog</a>
            <a href="#cara-kerja">Cara Kerja</a>
            <a href="#faq">FAQ</a>
        </div>

        <div class="nav-cta">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-auth">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-auth">Masuk</a>
            @endauth
            <a href="{{ route('order.create') }}" class="btn-dark">Buat Undangan</a>
            <button type="button" class="nav-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
</nav>

<div class="mobile-panel" id="mobileMenuPanel">
    <a href="#fitur" class="mobile-link">Fitur</a>
    <a href="{{ route('themes.index') }}" class="mobile-link">Katalog</a>
    <a href="#cara-kerja" class="mobile-link">Cara Kerja</a>
    <a href="#faq" class="mobile-link">FAQ</a>

    <div class="mobile-auth">
        @auth
            <a href="{{ route('dashboard') }}" class="mobile-link mobile-link-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard Saya
            </a>
        @else
            <a href="{{ route('login') }}" class="mobile-link mobile-link-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Masuk
            </a>
        @endauth
    </div>

    <a href="{{ route('order.create') }}" class="btn-dark mobile-cta">Buat Undangan</a>
</div>

<!-- ================= HERO ================= -->
<section class="hero">
    <div class="wrap">
        <div class="hero-grid">
            <div>
                <span class="eyebrow hero-eyebrow">Platform Undangan Digital · 2026</span>
                <h1 class="hero-title">
                    Bagikan momen <span class="em">istimewa</span> Anda dengan cara yang paling <span class="em">indah</span>.
                </h1>
                <p class="hero-sub">
                    Platform undangan digital untuk pasangan modern — tema premium yang elegan, manajemen tamu yang praktis, dan aktivasi dalam hitungan menit.
                </p>
                <div class="hero-cta">
                    <a href="{{ route('order.create') }}" class="btn-dark">
                        Mulai Buat Undangan
                        <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="#tema" class="btn-line">Lihat Koleksi</a>
                </div>
                <div class="hero-rule">
                    <span class="line"></span>
                    <span class="stat">{{ $totalThemes }} Tema · {{ $categoryCount }} Kategori · Sejak {{ $sinceYear }}</span>
                    <span class="line"></span>
                </div>
            </div>

            @if($heroTheme)
            <div class="hero-visual">
                <img src="{{ theme_thumb_url($heroTheme) }}" alt="{{ $heroTheme->name }}" loading="eager" decoding="async">
                <span class="hero-visual-mark">No. 01</span>
                <span class="hero-visual-cap">— {{ $heroTheme->name }}</span>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- ================= TEMA ================= -->
<section class="section" id="tema">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Koleksi Tema</span>
            <h2 class="title">Tiga tema <span class="em">pilihan</span> untuk Anda.</h2>
            <p class="sub">Setiap tema dirancang mobile-first dengan perhatian pada detail — animasi lembut, tipografi elegan, dan mudah disesuaikan setelah pemesanan.</p>
        </div>

        <div class="tema-grid">
            @foreach($featuredThemes as $i => $theme)
                @php
                    $meta = $themeMeta[$theme->slug] ?? ['category' => 'modern', 'label' => 'Modern'];
                    $catLabel = $meta['label'];
                    $catKey = $meta['category'];
                @endphp
                <article class="tema-card">
                    <a href="javascript:void(0)" onclick="openPreview('{{ route('demo.show', $theme->slug) }}')" class="tema-card-img">
                        <img src="{{ theme_thumb_url($theme) }}" alt="{{ $theme->name }}" loading="eager" decoding="async">
                        <span class="tema-card-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="tema-card-cat">{{ $catLabel }}</span>
                    </a>
                    <div class="tema-card-body">
                        <h3 class="tema-card-name">{{ $theme->name }}</h3>
                        <div class="tema-card-tag">Responsive · Galeri · RSVP</div>
                        <div class="tema-card-price">{{ $theme->short_price }}</div>
                        <a href="{{ route('order.create') }}?theme={{ $theme->slug }}" class="tema-card-action">
                            Pilih Tema
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="tema-cta">
            <a href="{{ route('themes.index') }}" class="btn-line">
                Jelajahi {{ $totalThemes }} Tema Lengkap
                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ================= FITUR ================= -->
<section class="section tinted" id="fitur">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Fitur Unggulan</span>
            <h2 class="title">Dirancang untuk <span class="em">kenyamanan</span> Anda.</h2>
            <p class="sub">Semua yang Anda butuhkan untuk mengelola undangan digital tanpa repot.</p>
        </div>

        <div class="fitur-grid">
            <div class="fitur-item">
                <div class="fitur-num">01</div>
                <h3 class="fitur-title">Tema Premium</h3>
                <p class="fitur-desc">{{ $totalThemes }} desain eksklusif mobile-first dengan animasi lembut dan mudah disesuaikan melalui dashboard.</p>
            </div>
            <div class="fitur-item">
                <div class="fitur-num">02</div>
                <h3 class="fitur-title">Manajemen Tamu</h3>
                <p class="fitur-desc">Undang tamu via WhatsApp, kelola RSVP, dan kirim reminder otomatis. Laporan lengkap tersedia di dashboard.</p>
            </div>
            <div class="fitur-item">
                <div class="fitur-num">03</div>
                <h3 class="fitur-title">Galeri Foto</h3>
                <p class="fitur-desc">Upload foto pre-wedding tanpa batas. Dilengkapi lightbox dan layout otomatis menyesuaikan jumlah foto.</p>
            </div>
            <div class="fitur-item">
                <div class="fitur-num">04</div>
                <h3 class="fitur-title">Musik & Animasi</h3>
                <p class="fitur-desc">Pilih backsound romantis dari koleksi kami. Animasi scroll halus untuk pengalaman yang elegan.</p>
            </div>
            <div class="fitur-item">
                <div class="fitur-num">05</div>
                <h3 class="fitur-title">QR Check-in</h3>
                <p class="fitur-desc">Setiap tamu mendapat QR code unik. Scan di lokasi untuk absensi cepat tanpa antre.</p>
            </div>
            <div class="fitur-item">
                <div class="fitur-num">06</div>
                <h3 class="fitur-title">Edit Kapan Saja</h3>
                <p class="fitur-desc">Akses dashboard 24/7 untuk mengubah nama, tanggal, lokasi, dan konten lain. Revisi tanpa batas.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CARA KERJA ================= -->
<section class="section" id="cara-kerja">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Cara Kerja</span>
            <h2 class="title">Tiga langkah <span class="em">sederhana</span>.</h2>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-roman">I.</div>
                <h3 class="step-title">Pilih Tema</h3>
                <p class="step-desc">Jelajahi {{ $totalThemes }} tema premium dan pilih yang paling sesuai dengan kepribadian Anda.</p>
            </div>
            <div class="step">
                <div class="step-roman">II.</div>
                <h3 class="step-title">Isi Data</h3>
                <p class="step-desc">Lengkapi formulir dengan data calon pengantin, tanggal, lokasi, dan detail acara.</p>
            </div>
            <div class="step">
                <div class="step-roman">III.</div>
                <h3 class="step-title">Bayar & Sebarkan</h3>
                <p class="step-desc">Selesaikan pembayaran via QRIS. Undangan langsung aktif dan siap dibagikan ke tamu.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= PULL QUOTE ================= -->
<section class="pullquote">
    <div class="wrap">
        <p class="pullquote-text">
            “Hari bahagia Anda layak dimulai dengan cara yang paling indah.”
        </p>
        <span class="pullquote-attr">— Tim Temanten</span>
    </div>
</section>

<!-- ================= CTA FINAL ================= -->
<section class="cta-final">
    <div class="wrap">
        <span class="eyebrow">Mulai Sekarang</span>
        <h2 class="title">Siap membuat <span class="em">kisah</span> Anda?</h2>
        <p class="sub">Buat undangan digital pertama Anda dalam hitungan menit. Tanpa kartu kredit, tanpa komitmen.</p>
        <a href="{{ route('order.create') }}" class="btn-dark">
            Buat Undangan
            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
    </div>
</section>

<!-- ================= FAQ ================= -->
<section class="section tinted" id="faq">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Tanya Jawab</span>
            <h2 class="title">Pertanyaan yang <span class="em">sering</span> ditanyakan.</h2>
            <p class="sub">Jika ada pertanyaan lain, jangan ragu menghubungi kami via WhatsApp.</p>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-q" type="button">
                    <span>Berapa lama proses pembuatan undangan?</span>
                    <span class="icon">+</span>
                </button>
                <div class="faq-a"><div class="faq-a-inner">
                    Proses sangat cepat. Pilih tema, isi data, dan bayar. Setelah pembayaran terverifikasi otomatis, undangan langsung aktif dan siap disebarkan saat itu juga.
                </div></div>
            </div>

            <div class="faq-item">
                <button class="faq-q" type="button">
                    <span>Apakah saya bisa mengubah data setelah jadi?</span>
                    <span class="icon">+</span>
                </button>
                <div class="faq-a"><div class="faq-a-inner">
                    Tentu. Dashboard tersedia 24/7 untuk mengubah nama, tanggal, lokasi, foto, dan konten lainnya. Revisi tanpa batas selama akun aktif.
                </div></div>
            </div>

            <div class="faq-item">
                <button class="faq-q" type="button">
                    <span>Berapa batas maksimal foto?</span>
                    <span class="icon">+</span>
                </button>
                <div class="faq-a"><div class="faq-a-inner">
                    Tidak ada batasan. Anda bisa mengunggah puluhan foto pre-wedding ke galeri undangan digital selama akun aktif.
                </div></div>
            </div>

            <div class="faq-item">
                <button class="faq-q" type="button">
                    <span>Bagaimana cara tamu menerima undangan?</span>
                    <span class="icon">+</span>
                </button>
                <div class="faq-a"><div class="faq-a-inner">
                    Setiap tamu menerima link undangan personal via WhatsApp. Cukup klik link untuk membuka undangan di browser — tanpa install aplikasi.
                </div></div>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="site-footer">
    <div class="wrap">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="name">TEMANTEN</div>
                <div class="tag">Digital Invitation</div>
                <p class="desc">Platform undangan digital untuk pasangan modern. Dibuat di Indonesia dengan cinta.</p>
            </div>
            <div class="footer-col">
                <h4>Jelajahi</h4>
                <ul>
                    <li><a href="{{ route('themes.index') }}">Katalog Tema</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#cara-kerja">Cara Kerja</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Akun</h4>
                <ul>
                    @auth
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    @endauth
                    <li><a href="{{ route('order.create') }}">Buat Undangan</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Kontak</h4>
                <ul>
                    <li><a href="https://wa.me/6282220312195" target="_blank" rel="noopener">WhatsApp Admin</a></li>
                    <li><a href="mailto:hello@temanten.com">hello@temanten.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2026 Temanten</span>
            <span>Dibuat di Indonesia</span>
        </div>
    </div>
</footer>

<!-- Preview modal -->
<div class="preview-modal" id="previewModal">
    <div class="preview-frame">
        <button class="preview-close" type="button" onclick="closePreview()">Tutup ✕</button>
        <div class="preview-loader" id="previewLoader">
            <div class="preview-spinner" aria-hidden="true"></div>
            <div class="preview-loader-text">Memuat<span class="preview-loader-dots"></span></div>
        </div>
        <iframe id="previewFrame" src="" title="Preview" onload="hidePreviewLoader()"></iframe>
    </div>
</div>

<script>
    // Mobile menu
    (function() {
        const btn = document.getElementById('mobileMenuBtn');
        const panel = document.getElementById('mobileMenuPanel');
        if (!btn || !panel) return;
        btn.addEventListener('click', () => panel.classList.toggle('open'));
        document.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', () => panel.classList.remove('open'));
        });
    })();

    // FAQ accordion (exclusive)
    document.querySelectorAll('.faq-q').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = btn.parentElement;
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });

    // Preview modal
    function hidePreviewLoader() {
        const loader = document.getElementById('previewLoader');
        if (loader) loader.classList.add('hidden');
    }
    window.openPreview = function(url) {
        const modal = document.getElementById('previewModal');
        const frame = document.getElementById('previewFrame');
        const loader = document.getElementById('previewLoader');
        if (loader) loader.classList.remove('hidden');
        frame.src = url;
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    };
    window.closePreview = function() {
        const modal = document.getElementById('previewModal');
        modal.classList.remove('open');
        document.body.style.overflow = '';
        const f = document.getElementById('previewFrame');
        f.src = '';
        const loader = document.getElementById('previewLoader');
        if (loader) loader.classList.remove('hidden');
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
