<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%2212%22 fill=%22%23F8BBD0%22/><text x=%2224%22 y=%2232%22 text-anchor=%22middle%22 font-size=%2224%22>🌸</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Noto+Serif+JP:wght@200;300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        :root {
            --primary: #E8A0BF;
            --primary-dark: #D4789C;
            --primary-light: #F8D7E8;
            --secondary: #C77DBA;
            --accent: #F2C6DE;
            --gold: #D4A574;
            --gold-light: #F0D9B5;
            --bg: #FFF9FB;
            --bg-card: rgba(255, 255, 255, 0.85);
            --text: #4A3540;
            --text-light: #8B7080;
            --text-muted: #B8A0AC;
            --white: #FFFFFF;
            --shadow: 0 8px 32px rgba(232, 160, 191, 0.15);
            --shadow-hover: 0 12px 40px rgba(232, 160, 191, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Cormorant Garamond', 'Noto Serif JP', serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
            line-height: 1.7;
        }

        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: var(--white);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 40px rgba(232, 160, 191, 0.1);
        }

        /* ── Sakura Petals ── */
        .sakura-petal {
            position: fixed;
            pointer-events: none;
            z-index: 9998;
            opacity: 0;
        }

        /* ── Hero / Cover ── */
        #heroCover {
            position: fixed;
            inset: 0;
            z-index: 9999;
            transition: transform 1.2s cubic-bezier(0.77, 0, 0.175, 1);
        }
        #heroCover.open { transform: translateY(-100%); }

        .hero {
            height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(74, 53, 64, 0.3) 0%,
                rgba(232, 160, 191, 0.4) 50%,
                rgba(74, 53, 64, 0.6) 100%
            );
        }

        .hero-box {
            position: relative;
            z-index: 2;
        }

        .hero-ornament {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .hero-subtitle {
            text-transform: uppercase;
            letter-spacing: 4px;
            font-size: 0.75rem;
            font-weight: 400;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .hero-names {
            font-family: 'Great Vibes', cursive;
            font-size: 3.2rem;
            line-height: 1.2;
            margin: 10px 0;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .hero-date {
            font-size: 0.95rem;
            letter-spacing: 2px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .hero-guest-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 12px 28px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: inline-block;
            margin-bottom: 25px;
        }

        .hero-guest-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
        }

        .hero-guest-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 2px;
        }

        .btn-open {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-size: 0.95rem;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s;
            box-shadow: 0 4px 20px rgba(232, 160, 191, 0.4);
            text-transform: uppercase;
        }

        .btn-open:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(232, 160, 191, 0.5);
        }

        /* ── Sections ── */
        .section {
            padding: 40px 25px;
            position: relative;
        }

        .section-divider {
            text-align: center;
            padding: 10px 0;
            font-size: 1.5rem;
            color: var(--primary);
            opacity: 0.5;
        }

        .section-title {
            font-family: 'Great Vibes', cursive;
            font-size: 2.5rem;
            color: var(--primary-dark);
            text-align: center;
            margin-bottom: 8px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 0.8rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 25px;
        }

        /* ── Glass Card ── */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 30px 25px;
            border: 1px solid rgba(232, 160, 191, 0.15);
            box-shadow: var(--shadow);
            text-align: center;
        }

        /* ── Quote ── */
        .quote-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .quote-text {
            font-style: italic;
            font-size: 1rem;
            line-height: 1.8;
            color: var(--text-light);
        }

        .quote-ornament {
            margin-top: 15px;
            font-size: 1.2rem;
            color: var(--primary);
            opacity: 0.4;
        }

        /* ── Couple Section ── */
        .couple-section {
            background: linear-gradient(180deg, var(--bg) 0%, rgba(248, 215, 232, 0.2) 50%, var(--bg) 100%);
        }

        .couple-img-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .couple-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            object-position: center top;
            border: 4px solid var(--white);
            box-shadow: 0 8px 25px rgba(232, 160, 191, 0.3);
        }

        .couple-img-frame {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid var(--primary-light);
            pointer-events: none;
        }

        .couple-name {
            font-family: 'Great Vibes', cursive;
            font-size: 2.2rem;
            color: var(--primary-dark);
            margin: 8px 0;
        }

        .couple-parents {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.6;
        }

        .couple-instagram {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--secondary);
            text-decoration: none;
            font-size: 0.8rem;
            margin-top: 5px;
            transition: color 0.3s;
        }

        .couple-instagram:hover { color: var(--primary-dark); }

        .couple-ampersand {
            font-family: 'Great Vibes', cursive;
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.5;
            margin: 20px 0;
        }

        /* ── Timeline / Love Story ── */
        .timeline {
            position: relative;
            padding-left: 25px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, var(--primary-light), var(--primary), var(--primary-light));
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-left: 15px;
        }

        .timeline-item::before {
            content: '🌸';
            position: absolute;
            left: -22px;
            top: 0;
            font-size: 0.9rem;
        }

        .timeline-year {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 3px;
        }

        .timeline-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 5px;
        }

        .timeline-story {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.6;
        }

        /* ── Countdown ── */
        .countdown-box {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .timer-item {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 12px 8px;
            border-radius: 16px;
            min-width: 60px;
            box-shadow: 0 4px 15px rgba(232, 160, 191, 0.3);
        }

        .timer-item span {
            font-size: 1.4rem;
            font-weight: 700;
            display: block;
            font-family: 'Cormorant Garamond', serif;
        }

        .timer-item small {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* ── Event Item ── */
        .event-card {
            background: linear-gradient(135deg, rgba(248, 215, 232, 0.3), rgba(255, 255, 255, 0.5));
            border: 1px solid rgba(232, 160, 191, 0.2);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            text-align: center;
        }

        .event-icon {
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .event-title {
            font-family: 'Great Vibes', cursive;
            font-size: 1.8rem;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .event-datetime {
            font-weight: 600;
            color: var(--text);
            margin: 5px 0;
            font-size: 0.95rem;
        }

        .event-time {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .event-venue {
            font-size: 0.9rem;
            margin-top: 8px;
            font-weight: 500;
            color: var(--text);
        }

        .event-address {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .btn-maps {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 12px;
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(232, 160, 191, 0.3);
        }

        .btn-maps:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(232, 160, 191, 0.4);
        }

        /* ── Gallery ── */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .gallery-item {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 16px;
            transition: transform 0.3s;
        }

        .gallery-item:hover { transform: scale(1.02); }

        .gallery-item:nth-child(3n+1) {
            grid-column: span 2;
            height: 220px;
        }

        /* ── Gift / Amplop ── */
        .bank-container {
            background: linear-gradient(135deg, var(--primary-light), rgba(255, 255, 255, 0.8));
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 15px;
            border: 1px solid rgba(232, 160, 191, 0.2);
        }

        .bank-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 5px;
        }

        .bank-number {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--primary-dark);
            margin: 8px 0;
        }

        .bank-holder {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .btn-copy {
            margin-top: 12px;
            background: var(--white);
            border: 2px solid var(--primary);
            padding: 8px 24px;
            border-radius: 50px;
            cursor: pointer;
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Cormorant Garamond', serif;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-copy:hover {
            background: var(--primary);
            color: white;
        }

        /* ── Buku Tamu ── */
        .form-control {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 12px;
            border: 2px solid rgba(232, 160, 191, 0.2);
            border-radius: 12px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.95rem;
            color: var(--text);
            background: rgba(255, 255, 255, 0.8);
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(232, 160, 191, 0.1);
        }

        .form-control::placeholder { color: var(--text-muted); }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            width: 100%;
            cursor: pointer;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(232, 160, 191, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(232, 160, 191, 0.4);
        }

        /* ── Comments ── */
        .comment-item {
            border-bottom: 1px solid rgba(232, 160, 191, 0.1);
            padding: 15px 0;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-name {
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 0.95rem;
        }

        .comment-badge {
            font-size: 0.65rem;
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 3px 10px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .comment-text {
            margin-top: 6px;
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.6;
        }

        .comment-time {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ── Music ── */
        .music-box {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(232, 160, 191, 0.4);
            cursor: pointer;
            transition: all 0.3s;
            color: white;
        }

        .music-box:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(232, 160, 191, 0.5);
        }

        .spin { animation: spin 3s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        /* ── Footer ── */
        .footer-section {
            background: linear-gradient(180deg, var(--bg), rgba(248, 215, 232, 0.3));
            padding: 40px 25px 30px;
            text-align: center;
        }

        .footer-names {
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .footer-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            letter-spacing: 2px;
        }

        .footer-brand {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(232, 160, 191, 0.2);
            font-size: 0.7rem;
            color: var(--text-muted);
            letter-spacing: 1px;
        }

        /* ── Sakura Background Decorations ── */
        .sakura-deco {
            position: absolute;
            pointer-events: none;
            opacity: 0.08;
            font-size: 3rem;
        }

        .sakura-deco-1 { top: 20px; right: 15px; transform: rotate(15deg); }
        .sakura-deco-2 { bottom: 30px; left: 10px; transform: rotate(-25deg); }
        .sakura-deco-3 { top: 50%; right: 5px; transform: rotate(45deg); }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .hero-names { font-size: 2.5rem; }
            .section-title { font-size: 2rem; }
            .couple-name { font-size: 1.8rem; }
            .countdown-box { gap: 8px; }
            .timer-item { min-width: 50px; padding: 10px 6px; }
            .timer-item span { font-size: 1.2rem; }
        }
    </style>
</head>
<body style="overflow: hidden;">
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
        $value = trim((string) $value, " /\t\n\r\0\x0B");
        return [
            'username' => $value,
            'display' => $value !== '' ? '@' . $value : '',
            'url' => $value !== '' ? 'https://instagram.com/' . $value : '',
        ];
    };

    $mapsUrl = function ($maps, $alamat) {
        $maps = trim((string) ($maps ?? ''));
        $alamat = trim((string) ($alamat ?? ''));
        $target = $maps !== '' ? $maps : $alamat;
        if ($target === '') return '';
        return Str::startsWith($target, ['http://', 'https://'])
            ? $target
            : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($target);
    };

    function getImgUrl($path) {
        if (!$path) return 'https://via.placeholder.com/150';
        return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
    }
@endphp

    <div class="mobile-container">

        @php
            $cbMusic = $invitation->content['media']['music'] ?? null;
            $cbMusicSrc = ($cbMusic && !str_contains($cbMusic, 'placeholder'))
                ? getImgUrl($cbMusic)
                : asset('assets/music/cherry-blossom.mp3');
        @endphp
        <div class="music-box" onclick="toggleMusic()" id="musicBtn" style="display:none;">
            <i class="ph-fill ph-music-note"></i>
        </div>
        <audio id="bgMusic" loop>
            <source src="{{ $cbMusicSrc }}" type="audio/mpeg">
        </audio>

        {{-- ═══════════ COVER ═══════════ --}}
        <section class="hero" id="heroCover" style="background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? '') }}');">
            <div class="hero-box">
                <div class="hero-ornament">🌸</div>
                <p class="hero-subtitle">The Wedding Of</p>
                <h1 class="hero-names">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}
                    <br> & <br>
                    {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h1>
                <p class="hero-date">
                    {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                </p>
                <div class="hero-guest-box">
                    <small class="hero-guest-label">Kepada Yth.</small>
                    <div class="hero-guest-name">{{ isset($guest) ? $guest->name : 'Tamu Undangan' }}</div>
                </div>
                <br>
                <button class="btn-open" onclick="openInvitation()">
                    <i class="ph ph-envelope-simple-open" style="margin-right: 6px;"></i> Buka Undangan
                </button>
            </div>
        </section>

        {{-- ═══════════ MAIN CONTENT ═══════════ --}}
        <div id="mainContent">

            {{-- Inner Hero --}}
            <div style="position: relative; text-align: center; color: white; padding: 60px 25px; background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? '') }}'); background-size: cover; background-position: center;">
                <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(232,160,191,0.5), rgba(74,53,64,0.6));"></div>
                <div style="position: relative; z-index: 2;">
                    <div style="font-size: 1.5rem; margin-bottom: 10px;">🌸</div>
                    <h2 style="font-family: 'Great Vibes', cursive; font-size: 2.5rem; margin: 0; line-height: 1.3;">We Are Getting Married</h2>
                    <p style="margin-top: 10px; font-size: 0.9rem; letter-spacing: 2px; opacity: 0.9;">Mohon doa restu dari Bapak/Ibu/Saudara/i</p>
                </div>
            </div>

            {{-- ═══════════ QUOTE ═══════════ --}}
            <section class="section">
                <div class="glass-card">
                    <div class="quote-icon"><i class="ph-duotone ph-flower-lotus"></i></div>
                    <p class="quote-text">"{{ $invitation->content['quote'] ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.' }}"</p>
                    <div class="quote-ornament">✿ ❀ ✿</div>
                </div>
            </section>

            <div class="section-divider">🌸</div>

            {{-- ═══════════ COUPLE ═══════════ --}}
            <section class="section couple-section">
                <h2 class="section-title">Mempelai</h2>
                <p class="section-subtitle">Dua Hati Satu Cinta</p>

                <div class="glass-card">
                    <div style="margin-bottom: 30px;">
                        <div class="couple-img-wrapper">
                            <img src="{{ getImgUrl($invitation->content['mempelai']['pria']['foto'] ?? '') }}" class="couple-img">
                            <div class="couple-img-frame"></div>
                        </div>
                        <h3 class="couple-name">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Mempelai Pria' }}</h3>
                        <p class="couple-parents">Putra dari Bapak {{ $invitation->content['mempelai']['pria']['ayah'] ?? '...' }}<br>& Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? '...' }}</p>
                        @if(!empty($formatInstagram($invitation->content['mempelai']['pria']['instagram'] ?? '')['username']))
                        <a href="{{ $formatInstagram($invitation->content['mempelai']['pria']['instagram'] ?? '')['url'] }}" target="_blank" rel="noopener noreferrer" class="couple-instagram">
                            <i class="ph-logo ph-instagram-logo"></i> {{ $formatInstagram($invitation->content['mempelai']['pria']['instagram'] ?? '')['display'] }}
                        </a>
                        @endif
                    </div>

                    <div class="couple-ampersand">&</div>

                    <div>
                        <div class="couple-img-wrapper">
                            <img src="{{ getImgUrl($invitation->content['mempelai']['wanita']['foto'] ?? '') }}" class="couple-img">
                            <div class="couple-img-frame"></div>
                        </div>
                        <h3 class="couple-name">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Mempelai Wanita' }}</h3>
                        <p class="couple-parents">Putri dari Bapak {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '...' }}<br>& Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '...' }}</p>
                        @if(!empty($formatInstagram($invitation->content['mempelai']['wanita']['instagram'] ?? '')['username']))
                        <a href="{{ $formatInstagram($invitation->content['mempelai']['wanita']['instagram'] ?? '')['url'] }}" target="_blank" rel="noopener noreferrer" class="couple-instagram">
                            <i class="ph-logo ph-instagram-logo"></i> {{ $formatInstagram($invitation->content['mempelai']['wanita']['instagram'] ?? '')['display'] }}
                        </a>
                        @endif
                    </div>
                </div>
            </section>

            <div class="section-divider">🌸</div>

            {{-- ═══════════ LOVE STORY ═══════════ --}}
            @if(isset($invitation->content['love_stories']) && is_array($invitation->content['love_stories']))
            <section class="section">
                <h2 class="section-title">Love Story</h2>
                <p class="section-subtitle">Perjalanan Cinta Kami</p>
                <div class="glass-card" style="text-align: left;">
                    <div class="timeline">
                        @foreach($invitation->content['love_stories'] as $story)
                        @if(!empty($story['title']))
                        <div class="timeline-item">
                            <span class="timeline-year">{{ $story['year'] ?? '' }}</span>
                            <h4 class="timeline-title">{{ $story['title'] ?? '' }}</h4>
                            <p class="timeline-story">{{ $story['story'] ?? '' }}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </section>
            <div class="section-divider">🌸</div>
            @endif

            {{-- ═══════════ SAVE THE DATE ═══════════ --}}
            <section class="section">
                <h2 class="section-title">Save The Date</h2>
                <p class="section-subtitle">Hari Bahagia Kami</p>

                <div class="glass-card">
                    <div class="countdown-box" id="countdown">
                        <div class="timer-item"><span id="days">00</span><small>Hari</small></div>
                        <div class="timer-item"><span id="hours">00</span><small>Jam</small></div>
                        <div class="timer-item"><span id="minutes">00</span><small>Menit</small></div>
                        <div class="timer-item"><span id="seconds">00</span><small>Detik</small></div>
                    </div>

                    <div class="event-card">
                        <div class="event-icon">💍</div>
                        <h3 class="event-title">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h3>
                        <p class="event-datetime">
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="event-time">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
                        <p class="event-venue">{{ $invitation->content['acara']['akad']['tempat'] ?? '' }}</p>
                        @php
                            $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                            $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                            $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                        @endphp
                        @if($akadL1)<p class="event-address">{{ $akadL1 }}</p>@endif
                        @if($akadL2)<p class="event-address">{{ $akadL2 }}</p>@endif
                        @if($mapsUrl($invitation->content['acara']['akad']['maps'] ?? '', $invitation->content['acara']['akad']['alamat'] ?? '') !== '')
                            <a href="{{ $mapsUrl($invitation->content['acara']['akad']['maps'] ?? '', $invitation->content['acara']['akad']['alamat'] ?? '') }}" target="_blank" rel="noopener noreferrer" class="btn-maps">
                                <i class="ph ph-map-pin"></i> Google Maps
                            </a>
                        @endif
                    </div>

                    <div class="event-card">
                        <div class="event-icon">🎉</div>
                        <h3 class="event-title">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi' }}</h3>
                        <p class="event-datetime">
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="event-time">{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</p>
                        <p class="event-venue">{{ $invitation->content['acara']['resepsi']['tempat'] ?? '' }}</p>
                        @php
                            $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                            $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                            $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                        @endphp
                        @if($resepsiL1)<p class="event-address">{{ $resepsiL1 }}</p>@endif
                        @if($resepsiL2)<p class="event-address">{{ $resepsiL2 }}</p>@endif
                        @if($mapsUrl($invitation->content['acara']['resepsi']['maps'] ?? '', $invitation->content['acara']['resepsi']['alamat'] ?? '') !== '')
                            <a href="{{ $mapsUrl($invitation->content['acara']['resepsi']['maps'] ?? '', $invitation->content['acara']['resepsi']['alamat'] ?? '') }}" target="_blank" rel="noopener noreferrer" class="btn-maps">
                                <i class="ph ph-map-pin"></i> Google Maps
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <div class="section-divider">🌸</div>

            {{-- ═══════════ GALLERY ═══════════ --}}
            @if(isset($invitation->content['media']['gallery']) && is_array($invitation->content['media']['gallery']))
            <section class="section">
                <h2 class="section-title">Our Moments</h2>
                <p class="section-subtitle">Momen Indah Kami</p>
                <div class="glass-card">
                    <div class="gallery-grid">
                        @foreach($invitation->content['media']['gallery'] as $photo)
                            <img src="{{ getImgUrl($photo) }}" class="gallery-item" loading="lazy">
                        @endforeach
                    </div>
                </div>
            </section>
            <div class="section-divider">🌸</div>
            @endif

            {{-- ═══════════ WEDDING GIFT ═══════════ --}}
            <section class="section">
                <h2 class="section-title">Wedding Gift</h2>
                <p class="section-subtitle">Tanda Kasih</p>
                <div class="glass-card">
                    <p style="margin-bottom: 20px; font-size: 0.9rem; color: var(--text-light);">Doa restu Anda merupakan karunia yang sangat berarti bagi kami.</p>

                    @if(!empty($invitation->content['amplop']['bank_name']))
                    <div class="bank-container">
                        <div class="bank-name">{{ $invitation->content['amplop']['bank_name'] }}</div>
                        <div class="bank-number" id="rek1">{{ $invitation->content['amplop']['account_number'] ?? '0000000' }}</div>
                        <div class="bank-holder">a.n {{ $invitation->content['amplop']['account_holder'] ?? 'Nama' }}</div>
                        <button onclick="copyToClipboard('rek1')" class="btn-copy">
                            <i class="ph ph-copy"></i> Salin Nomor
                        </button>
                    </div>
                    @endif

                    @if(!empty($invitation->content['amplop']['qris_image']))
                    <div style="margin-top: 20px; text-align: center;">
                        <p style="text-transform: uppercase; font-size: 0.7rem; letter-spacing: 3px; margin-bottom: 12px; color: var(--primary-dark); font-weight: 600;">Atau Pindai QRIS</p>
                        <img src="{{ getImgUrl($invitation->content['amplop']['qris_image'] ?? '') }}" alt="QRIS" loading="lazy" style="width: 170px; max-width: 70%; height: auto; aspect-ratio: 1 / 1; object-fit: contain; background: #fff; padding: 10px; border-radius: 16px; border: 1px solid rgba(232,160,191,0.2); box-shadow: 0 4px 15px rgba(232,160,191,0.15); margin: 0 auto; display: block;">
                    </div>
                    @endif

                    <div style="margin-top: 25px;">
                        <h4 style="text-transform: uppercase; font-size: 0.75rem; letter-spacing: 2px; color: var(--primary-dark); margin-bottom: 8px;">Kirim Kado</h4>
                        <p style="font-size: 0.85rem; color: var(--text-light);">{{ $invitation->content['amplop']['alamat_kado'] ?? '-' }}</p>
                        @if(!empty($invitation->content['amplop']['maps_kado'] ?? null) || !empty($invitation->content['amplop']['alamat_kado'] ?? null))
                        <a href="{{ (str_starts_with(($invitation->content['amplop']['maps_kado'] ?? $invitation->content['amplop']['alamat_kado'] ?? ''), 'http://') || str_starts_with(($invitation->content['amplop']['maps_kado'] ?? $invitation->content['amplop']['alamat_kado'] ?? ''), 'https://')) ? ($invitation->content['amplop']['maps_kado'] ?? $invitation->content['amplop']['alamat_kado'] ?? '') : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($invitation->content['amplop']['maps_kado'] ?? $invitation->content['amplop']['alamat_kado'] ?? '') }}" target="_blank" rel="noopener noreferrer" style="display:inline-block; margin-top:8px; font-size:0.8rem; color:var(--primary-dark); text-decoration: none;">
                            <i class="ph ph-map-pin"></i> Lihat Lokasi Kado
                        </a>
                        @endif
                    </div>
                </div>
            </section>

            <div class="section-divider">🌸</div>

            {{-- ═══════════ BUKU TAMU ═══════════ --}}
            <section class="section" style="padding-bottom: 50px;">
                <h2 class="section-title">Kirim Ucapan</h2>
                <p class="section-subtitle">Doa & Harapan</p>
                <div class="glass-card">
                    @if(session('success'))
                        <div style="background: rgba(232,160,191,0.15); color: var(--primary-dark); padding: 12px; border-radius: 12px; margin-bottom: 20px; text-align:center; font-size: 0.9rem; border: 1px solid rgba(232,160,191,0.3);">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('kirim.ucapan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                        @if(!empty($invitation->resolved_to_token ?? ''))
                            <input type="hidden" name="_to" value="{{ $invitation->resolved_to_token }}">
                        @endif
                        <input type="text" name="nama" class="form-control" placeholder="Nama Anda" required value="{{ $invitation->resolved_guest->name ?? '' }}" @if(!empty($invitation->resolved_guest)) readonly @endif>
                        <select name="kehadiran" class="form-control" required>
                            <option value="hadir">✦ Hadir</option>
                            <option value="tidak_hadir">✦ Tidak Hadir</option>
                            <option value="ragu">✦ Ragu-ragu</option>
                        </select>
                        <textarea name="ucapan" class="form-control" rows="3" placeholder="Tulis doa restu Anda..." required></textarea>
                        <button type="submit" class="btn-submit">Kirim Ucapan</button>
                    </form>

                    <div style="margin-top: 30px; text-align: left; max-height: 300px; overflow-y: auto;">
                        @if($invitation->comments->count() > 0)
                            @foreach($invitation->comments->sortByDesc('created_at') as $comment)
                                <div class="comment-item">
                                    <div class="comment-header">
                                        <strong class="comment-name">{{ $comment->name }}</strong>
                                        <span class="comment-badge">{{ ucfirst(str_replace('_', ' ', $comment->rsvp_status)) }}</span>
                                    </div>
                                    <p class="comment-text">{{ $comment->comment }}</p>
                                    <small class="comment-time">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            @endforeach
                        @else
                            <p style="text-align: center; color: var(--text-muted); font-size: 0.9rem; padding: 20px 0;">Belum ada ucapan. Jadilah yang pertama! 🌸</p>
                        @endif
                    </div>
                </div>
            </section>

            {{-- ═══════════ FOOTER ═══════════ --}}
            <div class="footer-section">
                <div style="font-size: 1.5rem; margin-bottom: 10px;">🌸</div>
                <h2 class="footer-names">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h2>
                <p class="footer-text">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('d F Y') }}</p>
                <p class="footer-brand">Created with 🤍 Temanten</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /* ── Sakura Petals Animation ── */
            function createSakuraPetals() {
                const container = document.querySelector('.mobile-container');
                if (!container) return;

                for (let i = 0; i < 20; i++) {
                    setTimeout(() => {
                        const petal = document.createElement('div');
                        petal.innerHTML = '🌸';
                        petal.style.cssText = `
                            position: fixed;
                            font-size: ${Math.random() * 12 + 8}px;
                            left: ${Math.random() * 100}%;
                            top: -30px;
                            opacity: ${Math.random() * 0.4 + 0.2};
                            pointer-events: none;
                            z-index: 9998;
                            transition: all ${Math.random() * 8 + 6}s linear;
                        `;
                        document.body.appendChild(petal);

                        setTimeout(() => {
                            petal.style.top = '110vh';
                            petal.style.left = `${parseFloat(petal.style.left) + (Math.random() * 30 - 15)}%`;
                            petal.style.transform = `rotate(${Math.random() * 720}deg)`;
                        }, 100);

                        setTimeout(() => {
                            petal.remove();
                        }, (Math.random() * 8 + 6) * 1000 + 200);
                    }, i * 800);
                }

                // Loop petals
                setInterval(() => {
                    const petal = document.createElement('div');
                    petal.innerHTML = '🌸';
                    petal.style.cssText = `
                        position: fixed;
                        font-size: ${Math.random() * 12 + 8}px;
                        left: ${Math.random() * 100}%;
                        top: -30px;
                        opacity: ${Math.random() * 0.4 + 0.2};
                        pointer-events: none;
                        z-index: 9998;
                        transition: all ${Math.random() * 8 + 6}s linear;
                    `;
                    document.body.appendChild(petal);

                    setTimeout(() => {
                        petal.style.top = '110vh';
                        petal.style.left = `${parseFloat(petal.style.left) + (Math.random() * 30 - 15)}%`;
                        petal.style.transform = `rotate(${Math.random() * 720}deg)`;
                    }, 100);

                    setTimeout(() => {
                        petal.remove();
                    }, (Math.random() * 8 + 6) * 1000 + 200);
                }, 1200);
            }
            createSakuraPetals();

            /* ── Music ── */
            const audio = document.getElementById('bgMusic');
            const musicBtn = document.getElementById('musicBtn');

            window.openInvitation = function() {
                const cover = document.getElementById('heroCover');
                if (cover) cover.classList.add('open');
                document.body.style.overflow = 'auto';

                if (audio && musicBtn) {
                    musicBtn.style.display = 'flex';
                    audio.play().then(() => {
                        musicBtn.classList.add('spin');
                    }).catch(e => console.log("Audio play blocked"));
                }
            }

            window.toggleMusic = function() {
                if (audio && musicBtn) {
                    if (audio.paused) {
                        audio.play();
                        musicBtn.classList.add('spin');
                    } else {
                        audio.pause();
                        musicBtn.classList.remove('spin');
                    }
                }
            }

            window.copyToClipboard = function(id) {
                const el = document.getElementById(id);
                if (el) {
                    navigator.clipboard.writeText(el.innerText).then(() => {
                        const btn = el.parentElement.querySelector('.btn-copy');
                        if (btn) {
                            const original = btn.innerHTML;
                            btn.innerHTML = '<i class="ph ph-check"></i> Tersalin!';
                            setTimeout(() => { btn.innerHTML = original; }, 2000);
                        }
                    });
                }
            }

            /* ── Countdown ── */
            const targetStr = "{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('Y-m-d H:i:s') }}";
            const targetDate = new Date(targetStr).getTime();

            setInterval(function() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    ['days', 'hours', 'minutes', 'seconds'].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.innerText = "0";
                    });
                    return;
                }

                const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((distance % (1000 * 60)) / 1000);

                if (document.getElementById("days")) document.getElementById("days").innerText = d;
                if (document.getElementById("hours")) document.getElementById("hours").innerText = h;
                if (document.getElementById("minutes")) document.getElementById("minutes").innerText = m;
                if (document.getElementById("seconds")) document.getElementById("seconds").innerText = s;
            }, 1000);
        });
    </script>
</body>
</html>