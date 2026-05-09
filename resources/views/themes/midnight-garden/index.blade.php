<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Raka' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Nadia' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        :root {
            --bg: #0d0d18;
            --card: #141428;
            --gold: #c9a84c;
            --gold-light: #e8c96e;
            --rose: #8b3a5a;
            --text: #e8e0d0;
            --text-muted: #8a8070;
            --border: rgba(201,168,76,0.2);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Jost', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .app {
            max-width: 480px;
            margin: 0 auto;
            position: relative;
            min-height: 100vh;
            background: var(--bg);
            overflow: hidden;
        }

        /* ───── GATE COVER ───── */
        .gate {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, #1a1a3a 0%, #0d0d18 100%);
            transition: transform 1.2s cubic-bezier(0.77,0,0.18,1);
        }
        /* Silk Texture & Glitter Overlay */
        .gate::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: 
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n' %3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.6' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E"),
                radial-gradient(circle at 20% 30%, rgba(201,168,76,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(201,168,76,0.05) 0%, transparent 50%);
            opacity: 0.6;
        }
        .glitter {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Ccircle cx='10' cy='10' r='0.5' fill='%23e8c96e' opacity='0.4'/%3E%3Ccircle cx='50' cy='30' r='0.8' fill='%23e8c96e' opacity='0.6'/%3E%3Ccircle cx='80' cy='20' r='0.4' fill='%23e8c96e' opacity='0.3'/%3E%3Ccircle cx='20' cy='80' r='0.6' fill='%23e8c96e' opacity='0.5'/%3E%3Ccircle cx='70' cy='60' r='0.5' fill='%23e8c96e' opacity='0.4'/%3E%3C/svg%3E");
            background-size: 150px 150px;
            opacity: 0.5;
            pointer-events: none;
        }
        .gate.open { transform: translateY(-100%); }
        .gate-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 30px;
        }
        .gate-eyebrow {
            font-size: 11px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: var(--gold-light);
            margin-bottom: 30px;
            font-weight: 500;
        }
        .gate-names {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 400;
            font-style: italic;
            line-height: 1.1;
            color: #fff;
            text-shadow: 0 0 25px rgba(255,255,255,0.25), 0 0 50px rgba(201,168,76,0.15);
            margin-bottom: 20px;
        }
        .gate-amp {
            color: var(--gold-light);
            font-style: normal;
            font-size: 3.5rem;
            display: block;
            margin: 5px 0;
            filter: drop-shadow(0 0 10px rgba(201,168,76,0.4));
        }
        .gate-divider-gold {
            width: 120px;
            height: 1.5px;
            background: linear-gradient(to right, transparent, var(--gold), transparent);
            margin: 25px auto;
        }
        .gate-date {
            font-size: 14px;
            letter-spacing: 2px;
            color: var(--gold-light);
            margin-bottom: 40px;
            font-weight: 400;
        }
        .gate-guest-box {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(201,168,76,0.25);
            border-radius: 50px;
            padding: 12px 40px;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .gate-guest-label { font-size: 9px; letter-spacing: 2px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
        .gate-guest-name { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: #fff; font-style: italic; }
        .btn-open {
            background: linear-gradient(135deg, #B8860B, #E4C366, #B8860B);
            color: #1a1a3a;
            border: none;
            padding: 16px 50px;
            border-radius: 50px;
            font-family: 'Jost', sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.4s;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3), inset 0 2px 5px rgba(255,255,255,0.3);
            display: block;
            margin: 0 auto;
        }
        .btn-open:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 15px 50px rgba(201,168,76,0.4); filter: brightness(1.1); }

        /* ───── FLOATING ELEMENTS ───── */
        .music-btn {
            position: fixed;
            bottom: 85px;
            right: 16px;
            width: 42px;
            height: 42px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 500;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(201,168,76,0.4);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s;
            color: #0d0d18;
            font-size: 18px;
        }
        .music-btn.visible { opacity: 1; pointer-events: all; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .spin { animation: spin 4s linear infinite; }

        /* ───── BOTTOM NAV ───── */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            background: rgba(20,20,40,0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-around;
            padding: 10px 0 calc(10px + env(safe-area-inset-bottom));
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s;
        }
        .bottom-nav.visible { opacity: 1; pointer-events: all; }
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 10px;
            transition: 0.2s;
            font-size: 20px;
            color: var(--text-muted);
            z-index: 10;
        }
        .nav-item.active, .nav-item:hover { color: var(--gold); }
        .nav-item span { font-size: 8px; letter-spacing: 1px; text-transform: uppercase; }

        /* ───── PAGES ───── */
        .page { display: none; height: 100vh; overflow-y: auto; padding-bottom: 100px; }
        .page.active { display: block; }
        .page::-webkit-scrollbar { width: 0; }

        /* ───── DECORATIVE STARS ───── */
        .stars { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .star { position: absolute; width: 2px; height: 2px; background: rgba(201,168,76,0.5); border-radius: 50%; animation: twinkle 3s infinite alternate; }
        @keyframes twinkle { 0% { opacity: 0.2; } 100% { opacity: 1; } }

        /* ───── HERO PAGE ───── */
        .hero-cover {
            height: 56vh;
            background-size: cover;
            background-position: center;
            position: relative;
            border-radius: 0 0 40px 40px;
            overflow: hidden;
        }
        .hero-cover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 30%, var(--bg) 100%);
        }
        .hero-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 28px 24px;
            margin: -24px 20px 20px;
            position: relative;
            z-index: 10;
            text-align: center;
        }
        .hero-card-eyebrow {
            font-size: 9px;
            letter-spacing: 5px;
            color: var(--gold);
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .hero-card-names {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 300;
            font-style: italic;
            color: var(--text);
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .countdown-grid { display: flex; justify-content: center; gap: 10px; }
        .countdown-box {
            background: rgba(201,168,76,0.08);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 10px 14px;
            min-width: 58px;
            text-align: center;
        }
        .countdown-num { display: block; font-size: 1.5rem; font-weight: 600; color: var(--gold); line-height: 1; }
        .countdown-label { font-size: 8px; letter-spacing: 2px; color: var(--text-muted); text-transform: uppercase; margin-top: 4px; display: block; }
        .divider-gold {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 20px;
            color: var(--gold);
            opacity: 0.4;
        }
        .divider-gold::before, .divider-gold::after { content: ''; flex: 1; height: 1px; background: currentColor; }
        .quote-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1rem;
            color: var(--text-muted);
            text-align: center;
            padding: 0 20px;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        /* ───── SECTION BASE ───── */
        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 300;
            font-style: italic;
            color: var(--gold-light);
            text-align: center;
            margin-bottom: 24px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px;
            margin: 0 20px 16px;
        }

        /* ───── COUPLE ───── */
        .couple-photo {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center top;

            border: 3px solid var(--gold);
            box-shadow: 0 0 30px rgba(201,168,76,0.25);
            display: block;
            margin: 0 auto 14px;
        }
        .couple-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-style: italic;
            color: var(--gold-light);
            text-align: center;
        }
        .couple-role {
            font-size: 9px;
            letter-spacing: 4px;
            color: var(--gold);
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .couple-parents { font-size: 12px; color: var(--text-muted); text-align: center; line-height: 1.8; }

        /* ───── TIMELINE ───── */
        .timeline { position: relative; padding-left: 20px; }
        .timeline::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 1px; background: linear-gradient(to bottom, transparent, var(--gold), transparent); }
        .timeline-item { position: relative; margin-bottom: 28px; padding-left: 20px; }
        .timeline-dot {
            position: absolute;
            left: -24px;
            top: 3px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 10px rgba(201,168,76,0.6);
        }
        .timeline-year { font-size: 10px; letter-spacing: 2px; color: var(--gold); text-transform: uppercase; }
        .timeline-title { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-style: italic; color: var(--text); margin: 2px 0 4px; }
        .timeline-text { font-size: 12px; color: var(--text-muted); line-height: 1.7; }

        /* ───── EVENT ───── */
        .event-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 20px;
            margin: 0 20px 16px;
            position: relative;
            overflow: hidden;
        }
        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            bottom: 0;
            background: linear-gradient(to bottom, var(--gold), var(--rose));
            border-radius: 0 2px 2px 0;
        }
        .event-name { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-style: italic; color: var(--gold-light); margin-bottom: 12px; }
        .event-detail { font-size: 12px; color: var(--text-muted); margin-bottom: 4px; display: flex; align-items: center; gap: 8px; }
        .event-detail i { color: var(--gold); font-size: 14px; width: 16px; }
        .btn-maps {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            background: rgba(201,168,76,0.1);
            border: 1px solid var(--border);
            color: var(--gold);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 11px;
            letter-spacing: 1px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-maps:hover { background: rgba(201,168,76,0.2); }

        /* ───── GALLERY ───── */
        .gallery-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 10px; padding: 0 20px; }
        .gallery-img {
            width: 100%;
            height: auto;
            aspect-ratio: 4 / 5;
            object-fit: contain;
            background: rgba(13, 13, 24, 0.6);
            border-radius: 14px;
            border: 1px solid var(--border);
            filter: brightness(0.65) saturate(0.8) sepia(0.15);
            transition: filter 0.4s;
            display: block;
        }
        .gallery-img:hover { filter: brightness(0.85) saturate(0.95); }
        .gallery-img:first-child { grid-column: 1/-1; aspect-ratio: 16 / 10; }
        /* Give couple photos a subtle gold tint to match theme */
        .couple-photo { filter: brightness(0.85) contrast(1.05); }

        /* ───── GIFT ───── */
        .gift-card {
            background: linear-gradient(135deg, #1e1a30, #2a1f3d);
            border: 1px solid rgba(201,168,76,0.3);
            border-radius: 20px;
            padding: 24px;
            margin: 0 20px 16px;
            position: relative;
            overflow: hidden;
        }
        .gift-card::after {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 120px; height: 120px;
            background: radial-gradient(circle, rgba(201,168,76,0.15), transparent 70%);
            border-radius: 50%;
        }
        .gift-bank { font-size: 10px; letter-spacing: 3px; color: var(--gold); text-transform: uppercase; margin-bottom: 6px; }
        .gift-number { font-size: 1.6rem; font-weight: 600; letter-spacing: 3px; color: var(--text); margin-bottom: 4px; }
        .gift-holder { font-size: 12px; color: var(--text-muted); }
        .btn-copy {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 14px;
            background: rgba(201,168,76,0.15);
            border: 1px solid var(--border);
            color: var(--gold);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 11px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-copy:hover { background: rgba(201,168,76,0.25); }

        /* ───── WISHES ───── */
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 16px;
            color: var(--text);
            font-family: 'Jost', sans-serif;
            font-size: 13px;
            margin-bottom: 10px;
            outline: none;
            transition: border 0.3s;
        }
        .form-input:focus { border-color: var(--gold); }
        .form-input option { background: var(--card); }
        .btn-submit-form {
            width: 100%;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: #0d0d18;
            border: none;
            padding: 13px;
            border-radius: 12px;
            font-family: 'Jost', sans-serif;
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit-form:hover { box-shadow: 0 0 20px rgba(201,168,76,0.4); }
        .wish-bubble {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 16px;
            margin-bottom: 10px;
        }
        .wish-header { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
        .wish-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--rose), var(--gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
            color: white;
            flex-shrink: 0;
        }
        .wish-name { font-size: 13px; font-weight: 600; color: var(--text); }
        .wish-time { font-size: 10px; color: var(--text-muted); }
        .wish-text { font-size: 12px; color: var(--text-muted); line-height: 1.7; font-style: italic; }
        .rsvp-badge {
            font-size: 10px;
            padding: 2px 10px;
            border-radius: 10px;
            margin-left: auto;
            flex-shrink: 0;
        }
        .rsvp-hadir { background: rgba(52,211,153,0.15); color: #34d399; }
        .rsvp-tidak { background: rgba(239,68,68,0.15); color: #ef4444; }
        .rsvp-ragu { background: rgba(251,191,36,0.15); color: #fbbf24; }

        /* ───── TOAST ───── */
        .toast {
            position: fixed;
            bottom: 90px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: var(--gold);
            color: #0d0d18;
            padding: 10px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 12px;
            z-index: 9999;
            opacity: 0;
            transition: 0.3s;
            white-space: nowrap;
        }
        .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
    </style>
</head>
<body>
@php
    $formatInstagram = function ($value) {
        $value = trim((string) ($value ?? ''));
        if ($value === '') {
            return ['username' => '', 'display' => '', 'url' => ''];
        }

        $value = preg_replace('/^https?:\/\/(www\.)?instagram\.com\//i', '', $value);
        $value = preg_replace('/^instagram\.com\//i', '', $value);
        $value = ltrim($value, '@');
        $value = strtok($value, '?/#');
        $value = trim((string) $value, " /	

 ");

        return [
            'username' => $value,
            'display' => $value !== '' ? '@' . $value : '',
            'url' => $value !== '' ? 'https://instagram.com/' . $value : '',
        ];
    };
@endphp


@php
    function mgImgUrl($path) {
        // Verified working Unsplash IDs — unique set for Midnight Garden
        if (!$path) return 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&fit=crop&q=80';
        if (str_contains($path, 'placeholder')) return 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&fit=crop&q=80';
        return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
    }

    $pria = $invitation->content['mempelai']['pria'] ?? [];
    $wanita = $invitation->content['mempelai']['wanita'] ?? [];
    $akad = $invitation->content['acara']['akad'] ?? [];
    $resepsi = $invitation->content['acara']['resepsi'] ?? [];
    $amplop = $invitation->content['amplop'] ?? [];
    $love_stories = $invitation->content['love_stories'] ?? [
        ['year' => '2020', 'title' => 'Pertemuan Pertama', 'story' => 'Di bawah sinar bulan yang penuh, dua jiwa bertemu untuk pertama kalinya.'],
        ['year' => '2022', 'title' => 'Jatuh Cinta', 'story' => 'Tanpa disadari, hati ini telah terpaut dalam kesunyian malam yang indah.'],
        ['year' => '2024', 'title' => 'Lamaran', 'story' => 'Di taman yang sunyi dihiasi seribu bintang, ia memintaku untuk menjadi satu.'],
    ];
    // Verified working IDs — dark CSS filter applied via .gallery-img to create moody night look
    $gallery = $invitation->content['media']['gallery'] ?? [
        'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&fit=crop&q=80',
        'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&fit=crop&q=80',
        'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&fit=crop&q=80',
    ];
    $targetDate = \Carbon\Carbon::parse($akad['waktu'] ?? now()->addDays(90));
@endphp

<div class="app">
    <!-- Stars background -->
    <div class="stars" id="starsContainer"></div>

    <!-- Music — default: midnight-garden.mp3 (client upload overrides) -->
    <audio id="bgMusic" loop>
        <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/midnight-garden.mp3') }}" type="audio/mpeg">
    </audio>
    <div class="music-btn" id="musicBtn" onclick="toggleMusic()">
        <i class="ph-fill ph-music-notes" id="musicIcon"></i>
    </div>

    <!-- Gate / Cover -->
    <div class="gate" id="gate">
        <div class="glitter"></div>
        <div class="gate-content" id="gateContent">
            <p class="gate-eyebrow">THE WEDDING OF</p>
            <h1 class="gate-names">
                {{ $pria['panggilan'] ?? 'Romeo' }}
                <span class="gate-amp">&amp;</span>
                {{ $wanita['panggilan'] ?? 'Juliet' }}
            </h1>
            
            <div class="gate-divider-gold"></div>

            <p class="gate-date">{{ $targetDate->translatedFormat('d F Y') }}</p>

            @if(isset($guest))
            <div class="gate-guest-box">
                <div class="gate-guest-label">Nama Tamu</div>
                <div class="gate-guest-name">{{ $guest->name }}</div>
            </div><br>
            @endif

            <button class="btn-open" onclick="openInvitation()">Buka Undangan</button>
        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- PAGE: HOME -->
    <!-- ══════════════════════════════════════════ -->
    <div class="page active" id="page-home">
        <div class="hero-cover" style="background-image: url('{{ mgImgUrl($invitation->content['media']['cover'] ?? 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=800&fit=crop&q=80') }}');"></div>

        <div class="hero-card">
            <p class="hero-card-eyebrow">✦ Save The Date ✦</p>
            <h2 class="hero-card-names">
                {{ $pria['panggilan'] ?? 'Raka' }} & {{ $wanita['panggilan'] ?? 'Nadia' }}
            </h2>
            <div class="countdown-grid">
                <div class="countdown-box"><span class="countdown-num" id="cd-days">--</span><span class="countdown-label">Hari</span></div>
                <div class="countdown-box"><span class="countdown-num" id="cd-hours">--</span><span class="countdown-label">Jam</span></div>
                <div class="countdown-box"><span class="countdown-num" id="cd-mins">--</span><span class="countdown-label">Menit</span></div>
                <div class="countdown-box"><span class="countdown-num" id="cd-secs">--</span><span class="countdown-label">Detik</span></div>
            </div>
        </div>

        <div class="divider-gold"><i class="ph-fill ph-flower-lotus"></i></div>

        <p class="quote-text">
            "{{ $invitation->content['quote'] ?? 'Dua jiwa yang disatukan bukan oleh kebetulan, melainkan oleh takdir yang telah tertulis di antara bintang-bintang.' }}"
        </p>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- PAGE: COUPLE -->
    <!-- ══════════════════════════════════════════ -->
    <div class="page" id="page-couple">
        <div style="padding: 40px 0 0;">
            <h2 class="section-title">✦ Mempelai ✦</h2>

            <div class="card">
                <img src="{{ mgImgUrl($pria['foto'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&q=80') }}" class="couple-photo" alt="Groom">
                <p class="couple-role">The Groom</p>
                <h3 class="couple-name">{{ $pria['nama'] ?? 'Raka Wiratama' }}</h3>
                <p class="couple-parents" style="margin-top:8px;">
                    Putra dari Bapak {{ $pria['ayah'] ?? '...' }}<br>& Ibu {{ $pria['ibu'] ?? '...' }}
                </p>
                @if(!empty($formatInstagram($pria['instagram'] ?? '')['username']))
                <a href="{{ $formatInstagram($pria['instagram'] ?? '')['url'] }}" target="_blank" rel="noopener noreferrer" style="display:block; text-align:center; margin-top:10px; color:var(--gold); font-size:12px;">
                    <i class="ph-fill ph-instagram-logo"></i> {{ $formatInstagram($pria['instagram'] ?? '')['display'] }}
                </a>
                @endif
            </div>

            <div style="text-align:center; font-family:'Cormorant Garamond',serif; font-size:2.5rem; font-style:italic; color:var(--gold); padding: 8px 0;">&</div>

            <div class="card">
                <img src="{{ mgImgUrl($wanita['foto'] ?? 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&h=400&fit=crop&q=80') }}" class="couple-photo" alt="Bride">
                <p class="couple-role">The Bride</p>
                <h3 class="couple-name">{{ $wanita['nama'] ?? 'Nadia Salsabila' }}</h3>
                <p class="couple-parents" style="margin-top:8px;">
                    Putri dari Bapak {{ $wanita['ayah'] ?? '...' }}<br>& Ibu {{ $wanita['ibu'] ?? '...' }}
                </p>
                @if(!empty($formatInstagram($wanita['instagram'] ?? '')['username']))
                <a href="{{ $formatInstagram($wanita['instagram'] ?? '')['url'] }}" target="_blank" rel="noopener noreferrer" style="display:block; text-align:center; margin-top:10px; color:var(--gold); font-size:12px;">
                    <i class="ph-fill ph-instagram-logo"></i> {{ $formatInstagram($wanita['instagram'] ?? '')['display'] }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- PAGE: STORY -->
    <!-- ══════════════════════════════════════════ -->
    <div class="page" id="page-story">
        <div style="padding: 40px 20px 0;">
            <h2 class="section-title">✦ Kisah Kami ✦</h2>
            <div class="timeline">
                @foreach($love_stories as $story)
                @if(!empty($story['title']))
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-year">{{ $story['year'] ?? '' }}</div>
                    <div class="timeline-title">{{ $story['title'] ?? '' }}</div>
                    <div class="timeline-text">{{ $story['story'] ?? '' }}</div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- PAGE: EVENT -->
    <!-- ══════════════════════════════════════════ -->
    <div class="page" id="page-event">
        <div style="padding: 40px 0 0;">
            <h2 class="section-title">✦ Acara ✦</h2>

            <div class="event-card">
                <p class="event-name">{{ $akad['judul'] ?? 'Akad Nikah' }}</p>
                <div class="event-detail">
                    <i class="ph-fill ph-calendar"></i>
                    {{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                </div>
                <div class="event-detail">
                    <i class="ph-fill ph-clock"></i>
                    Pukul {{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->format('H:i') }} WIB
                </div>
                <div class="event-detail" style="flex-direction: column; align-items: flex-start; padding-left: 24px; position: relative;">
                    <i class="ph-fill ph-map-pin" style="position: absolute; left: 0; top: 2px;"></i>
                    <span>{{ $akad['tempat'] ?? '-' }}@if(!empty($akad['alamat'])), {{ $akad['alamat'] }}@endif</span>
                    @php
                        $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                        $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                        $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($akadL1)<span>{{ $akadL1 }}</span>@endif
                    @if($akadL2)<span>{{ $akadL2 }}</span>@endif
                </div>
                @if(!empty($akad['maps'] ?? null) || !empty($akad['alamat'] ?? null))
                @php
                    $maps = $akad['maps'] ?? $akad['alamat'];
                    $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                        ? $maps 
                        : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                @endphp
                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-maps">
                    <i class="ph-bold ph-navigation-arrow"></i> Google Maps
                </a>
                @endif
            </div>

            <div class="event-card">
                <p class="event-name">{{ $resepsi['judul'] ?? 'Resepsi' }}</p>
                <div class="event-detail">
                    <i class="ph-fill ph-calendar"></i>
                    {{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                </div>
                <div class="event-detail">
                    <i class="ph-fill ph-clock"></i>
                    Pukul {{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->format('H:i') }} WIB
                </div>
                <div class="event-detail" style="flex-direction: column; align-items: flex-start; padding-left: 24px; position: relative;">
                    <i class="ph-fill ph-map-pin" style="position: absolute; left: 0; top: 2px;"></i>
                    <span>{{ $resepsi['tempat'] ?? '-' }}@if(!empty($resepsi['alamat'])), {{ $resepsi['alamat'] }}@endif</span>
                    @php
                        $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                        $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                        $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($resepsiL1)<span>{{ $resepsiL1 }}</span>@endif
                    @if($resepsiL2)<span>{{ $resepsiL2 }}</span>@endif
                </div>
                @if(!empty($resepsi['maps'] ?? null) || !empty($resepsi['alamat'] ?? null))
                @php
                    $maps = $resepsi['maps'] ?? $resepsi['alamat'];
                    $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                        ? $maps 
                        : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                @endphp
                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-maps">
                    <i class="ph-bold ph-navigation-arrow"></i> Google Maps
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- PAGE: GALLERY -->
    <!-- ══════════════════════════════════════════ -->
    <div class="page" id="page-gallery">
        <div style="padding: 40px 0 0;">
            <h2 class="section-title">✦ Galeri ✦</h2>
            <div class="gallery-grid">
                @foreach($gallery as $photo)
                <img src="{{ mgImgUrl($photo) }}" class="gallery-img" alt="Gallery">
                @endforeach
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════ -->
    <!-- PAGE: WISHES (+ Gift) -->
    <!-- ══════════════════════════════════════════ -->
    <div class="page" id="page-wishes">
        <div style="padding: 40px 0 0;">
            <h2 class="section-title">✦ Wedding Gift ✦</h2>

            @if(!empty($amplop['bank_name']))
            <div class="gift-card">
                <p class="gift-bank">{{ $amplop['bank_name'] }}</p>
                <p class="gift-number" id="giftNumber">{{ $amplop['account_number'] ?? '0000000000' }}</p>
                <p class="gift-holder">a.n {{ $amplop['account_holder'] ?? 'Nama Penerima' }}</p>
                <button class="btn-copy" onclick="copyGift()">
                    <i class="ph-bold ph-copy"></i> Salin Nomor
                </button>
            </div>
            @endif

            @if(!empty($amplop['qris_image']))
            <div class="gift-card" style="margin-top:16px; text-align:center;">
                <p class="gift-bank" style="margin-bottom:10px;">✦ Atau Pindai QRIS ✦</p>
                <img src="{{ asset($amplop['qris_image']) }}" alt="QRIS" loading="lazy" style="width:170px; max-width:70%; height:auto; aspect-ratio:1/1; object-fit:contain; background:#fff; padding:8px; border-radius:12px; border:1px solid rgba(212,175,55,0.4); margin:0 auto; display:block;">
            </div>
            @endif

            @if(!empty($amplop['alamat_kado']))
            <div class="card" style="display:flex; align-items:center; gap:12px;">
                <i class="ph-fill ph-gift" style="color:var(--gold); font-size:24px; flex-shrink:0;"></i>
                <div>
                    <div style="font-size:11px; letter-spacing:2px; color:var(--gold); text-transform:uppercase; margin-bottom:4px;">Kirim Kado</div>
                    <div style="font-size:12px; color:var(--text-muted);">{{ $amplop['alamat_kado'] }}</div>
                </div>
            </div>
            @endif

            <h2 class="section-title" style="margin-top:30px;">✦ Ucapan & Doa ✦</h2>

            <div class="card">
                @if(session('success'))
                <div style="background:rgba(52,211,153,0.1); border:1px solid rgba(52,211,153,0.3); color:#34d399; padding:10px; border-radius:10px; margin-bottom:14px; font-size:12px; text-align:center;">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('kirim.ucapan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                    <input type="text" name="nama" class="form-input" placeholder="Nama Anda" required>
                    <select name="kehadiran" class="form-input">
                        <option value="hadir">Saya Akan Hadir ✓</option>
                        <option value="tidak_hadir">Maaf, Tidak Bisa Hadir</option>
                        <option value="ragu">Masih Belum Pasti</option>
                    </select>
                    <textarea name="ucapan" rows="3" class="form-input" placeholder="Kirimkan doa dan restu terbaik Anda..." required style="resize:none;"></textarea>
                    <button type="submit" class="btn-submit-form">Kirim Ucapan</button>
                </form>
            </div>

            @if($invitation->comments->count() > 0)
            <div style="padding: 0 20px;">
                @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                <div class="wish-bubble">
                    <div class="wish-header">
                        <div class="wish-avatar">{{ substr($comment->name ?? $comment->nama ?? '?', 0, 1) }}</div>
                        <div>
                            <div class="wish-name">{{ $comment->name ?? $comment->nama }}</div>
                            <div class="wish-time">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                        @php $rs = $comment->rsvp_status ?? $comment->kehadiran ?? 'hadir'; @endphp
                        <span class="rsvp-badge {{ str_contains($rs,'hadir') && !str_contains($rs,'tidak') && !str_contains($rs,'Tidak') ? 'rsvp-hadir' : (str_contains($rs,'ragu') || str_contains($rs,'Ragu') ? 'rsvp-ragu' : 'rsvp-tidak') }}">
                            {{ str_replace('_',' ', $rs) }}
                        </span>
                    </div>
                    <p class="wish-text">"{{ $comment->comment ?? $comment->ucapan }}"</p>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align:center; padding:20px; color:var(--text-muted); font-size:13px; font-style:italic;">
                Jadilah yang pertama mengirim ucapan ✨
            </div>
            @endif
        </div>
    </div>

    <!-- Bottom Nav -->
    <nav class="bottom-nav" id="bottomNav">
        <div class="nav-item active" onclick="navTo('home',this)"><i class="ph-fill ph-moon-stars"></i><span>Home</span></div>
        <div class="nav-item" onclick="navTo('couple',this)"><i class="ph-fill ph-heart"></i><span>Kita</span></div>
        <div class="nav-item" onclick="navTo('story',this)"><i class="ph-fill ph-book-open-text"></i><span>Kisah</span></div>
        <div class="nav-item" onclick="navTo('event',this)"><i class="ph-fill ph-calendar-star"></i><span>Acara</span></div>
        <div class="nav-item" onclick="navTo('gallery',this)"><i class="ph-fill ph-images"></i><span>Galeri</span></div>
        <div class="nav-item" onclick="navTo('wishes',this)"><i class="ph-fill ph-chat-circle-dots"></i><span>Ucapan</span></div>
    </nav>
</div>

<!-- Toast -->
<div class="toast" id="toast"></div>

<script>
    // Stars background
    (function() {
        const c = document.getElementById('starsContainer');
        for(let i = 0; i < 60; i++) {
            const s = document.createElement('div');
            s.className = 'star';
            s.style.left = Math.random()*100+'%';
            s.style.top = Math.random()*100+'%';
            s.style.animationDelay = Math.random()*3+'s';
            s.style.animationDuration = (2+Math.random()*2)+'s';
            c.appendChild(s);
        }
    })();

    // Open invitation
    function openInvitation() {
        const gate = document.getElementById('gate');
        gate.classList.add('open');
        gate.style.pointerEvents = 'none';
        document.body.style.overflow = 'auto';
        setTimeout(() => {
            document.getElementById('bottomNav').classList.add('visible');
            document.getElementById('musicBtn').classList.add('visible');
        }, 800);
        const audio = document.getElementById('bgMusic');
        if(audio) audio.play().catch(()=>{});
        setTimeout(() => { gate.style.display = 'none'; }, 1500);
    }

    // Nav
    function navTo(page, el) {
        document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        const target = document.getElementById('page-'+page);
        if(target) { target.classList.add('active'); target.scrollTop = 0; }
        el.classList.add('active');
    }

    // Music
    function toggleMusic() {
        const audio = document.getElementById('bgMusic');
        const btn = document.getElementById('musicBtn');
        if (!audio) return;
        if (audio.paused) { audio.play(); btn.classList.add('spin'); }
        else { audio.pause(); btn.classList.remove('spin'); }
    }

    // Copy gift
    function copyGift() {
        const txt = document.getElementById('giftNumber')?.innerText;
        if (txt) navigator.clipboard.writeText(txt).then(() => showToast('Nomor rekening disalin! ✓'));
    }

    // Toast
    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2500);
    }

    // Countdown
    const target = new Date("{{ $targetDate->format('Y-m-d H:i:s') }}").getTime();
    setInterval(() => {
        const now = new Date().getTime();
        const diff = target - now;
        if (diff <= 0) {
            ['cd-days','cd-hours','cd-mins','cd-secs'].forEach(id => { const el = document.getElementById(id); if(el) el.textContent = '0'; });
            return;
        }
        const d = Math.floor(diff/(1e3*60*60*24));
        const h = Math.floor((diff%(1e3*60*60*24))/(1e3*60*60));
        const m = Math.floor((diff%(1e3*60*60))/(1e3*60));
        const s = Math.floor((diff%(1e3*60))/1e3);
        const set = (id, v) => { const el = document.getElementById(id); if(el) el.textContent = String(v).padStart(2,'0'); };
        set('cd-days', d); set('cd-hours', h); set('cd-mins', m); set('cd-secs', s);
    }, 1000);
</script>
</body>
</html>
