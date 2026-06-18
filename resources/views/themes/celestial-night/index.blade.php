<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%2212%22 fill=%22%230B1026%22/><text x=%2224%22 y=%2232%22 text-anchor=%22middle%22 font-size=%2224%22>🌙</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #1a1a40;
            --primary-dark: #0b0b1e;
            --primary-light: #2d2d6b;
            --secondary: #4a2f8a;
            --accent: #c9a84c;
            --accent-light: #e8d48b;
            --gold: #c9a84c;
            --gold-light: #e8d48b;
            --bg: #0b0b1e;
            --bg-card: rgba(15, 15, 42, 0.85);
            --text: #e8e8f0;
            --text-light: #a8a8c8;
            --text-muted: #6868a0;
            --white: #ffffff;
            --shadow: 0 8px 32px rgba(201, 168, 76, 0.15);
            --shadow-hover: 0 12px 40px rgba(201, 168, 76, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-snap-type: none;
            overflow-y: auto;
        }

        body {
            font-family: 'Cormorant Garamond', serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.7;
            min-height: 100dvh;
            height: auto;
            width: auto;
            overflow-x: hidden;
            overflow-y: auto;
        }
        /* ===== LOCK COVER (gaya buka undangan) ===== */
        body.cover-locked { overflow: hidden; height: 100dvh; touch-action: none; overscroll-behavior: none; }
        body.cover-locked .celestial-page > .section:not(.section-cover) { visibility: hidden; }
        body.cover-locked .scroll-indicator { display: none; }

        /* ===== STAR CANVAS ===== */
        .stars-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* ===== LAYOUT ===== */
        .celestial-page {
            position: relative;
            z-index: 1;
            min-height: 100dvh;
        }

        .section {
            min-height: 100dvh;
            scroll-snap-align: none;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 3rem 1.5rem;
        }

        .section-inner {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        /* ===== COVER SECTION ===== */
        .section-cover {
            background: linear-gradient(180deg, #0b0b1e 0%, #1a1a40 40%, #2d1854 100%);
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .section-cover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(2px 2px at 20% 30%, #fff 0.5px, transparent 1px),
                radial-gradient(2px 2px at 40% 70%, #fff 0.5px, transparent 1px),
                radial-gradient(1px 1px at 60% 20%, #fff 0.5px, transparent 1px),
                radial-gradient(2px 2px at 80% 50%, #fff 0.5px, transparent 1px),
                radial-gradient(1px 1px at 10% 80%, #fff 0.5px, transparent 1px),
                radial-gradient(1px 1px at 70% 90%, #fff 0.5px, transparent 1px),
                radial-gradient(2px 2px at 90% 15%, #fff 0.5px, transparent 1px),
                radial-gradient(1px 1px at 50% 50%, #fff 0.5px, transparent 1px);
            animation: twinkle 4s ease-in-out infinite alternate;
        }

        @keyframes twinkle {
            0% { opacity: 0.6; }
            100% { opacity: 1; }
        }

        .cover-moon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, #f5e6a3 0%, #c9a84c 50%, #8b6914 100%);
            box-shadow: 0 0 60px rgba(201, 168, 76, 0.4), 0 0 120px rgba(201, 168, 76, 0.2);
            margin: 0 auto 2rem;
            position: relative;
            animation: moonGlow 3s ease-in-out infinite alternate;
        }

        @keyframes moonGlow {
            0% { box-shadow: 0 0 60px rgba(201, 168, 76, 0.4), 0 0 120px rgba(201, 168, 76, 0.2); }
            100% { box-shadow: 0 0 80px rgba(201, 168, 76, 0.6), 0 0 160px rgba(201, 168, 76, 0.3); }
        }

        .cover-moon::after {
            content: '';
            position: absolute;
            top: 15%;
            left: 55%;
            width: 75%;
            height: 75%;
            border-radius: 50%;
            background: var(--primary-dark);
            opacity: 0.15;
        }

        .cover-subtitle {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.85rem;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1rem;
            font-weight: 300;
        }

        .cover-names {
            font-family: 'Great Vibes', cursive;
            font-size: 2.8rem;
            color: var(--gold-light);
            line-height: 1.3;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 30px rgba(201, 168, 76, 0.3);
        }

        .cover-ampersand {
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            color: var(--accent);
            display: block;
            margin: 0.2rem 0;
            opacity: 0.8;
        }

        .cover-date {
            font-size: 0.95rem;
            letter-spacing: 3px;
            color: var(--text-light);
            margin-top: 1.5rem;
            font-weight: 300;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s ease-in-out infinite;
            color: var(--gold);
            opacity: 0.6;
            font-size: 1.5rem;
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        /* ===== DIVIDER ===== */
        .celestial-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }

        .celestial-divider .line {
            width: 40px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .celestial-divider .star {
            color: var(--gold);
            font-size: 0.8rem;
        }

        /* ===== GLASS CARDS ===== */
        .glass-card {
            background: rgba(15, 15, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* ===== SECTION TITLES ===== */
        .section-title {
            font-family: 'Great Vibes', cursive;
            font-size: 2.2rem;
            color: var(--gold-light);
            margin-bottom: 0.5rem;
        }

        .section-label {
            font-size: 0.75rem;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        /* ===== QURAN VERSE ===== */
        .quran-card {
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.1), rgba(15, 15, 42, 0.8));
        }

        .quran-arabic {
            font-size: 1.4rem;
            line-height: 2;
            color: var(--gold-light);
            margin-bottom: 1rem;
            font-weight: 300;
        }

        .quran-text {
            font-size: 0.95rem;
            color: var(--text-light);
            font-style: italic;
            margin-bottom: 0.5rem;
        }

        .quran-source {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* ===== COUPLE SECTION ===== */
        .couple-grid {
            display: grid;
            gap: 1.5rem;
        }

        .person-card {
            text-align: center;
        }

        .person-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            border: 2px solid var(--gold);
            box-shadow: 0 0 20px rgba(201, 168, 76, 0.2);
            overflow: hidden;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .person-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .person-avatar .ph {
            font-size: 2.5rem;
            color: var(--gold);
        }

        .person-name {
            font-family: 'Great Vibes', cursive;
            font-size: 1.8rem;
            color: var(--gold-light);
            margin-bottom: 0.3rem;
        }

        .person-fullname {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .person-parents {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
        }

        .person-instagram {
            font-size: 0.8rem;
            color: var(--accent);
        }

        .couple-heart {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem 0;
        }

        .couple-heart i {
            font-size: 1.5rem;
            color: var(--gold);
            animation: heartPulse 2s ease-in-out infinite;
        }

        @keyframes heartPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        /* ===== EVENT CARDS ===== */
        .event-card {
            text-align: center;
        }

        .event-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.2), rgba(74, 47, 138, 0.3));
            border: 1px solid rgba(201, 168, 76, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .event-icon i {
            color: var(--gold);
            font-size: 1.2rem;
        }

        .event-label {
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.5rem;
        }

        .event-title {
            font-family: 'Great Vibes', cursive;
            font-size: 1.6rem;
            color: var(--gold-light);
            margin-bottom: 1rem;
        }

        .event-info {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 0.3rem;
        }

        .event-info i {
            color: var(--gold);
            margin-right: 0.3rem;
        }

        .event-venue {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            margin: 0.8rem 0 0.3rem;
        }

        .event-address {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .maps-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.8rem;
            padding: 0.5rem 1.2rem;
            background: transparent;
            border: 1px solid var(--gold);
            border-radius: 2rem;
            color: var(--gold);
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .maps-btn:hover {
            background: rgba(201, 168, 76, 0.15);
        }

        /* ===== LOVE STORY ===== */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, var(--gold), transparent);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            text-align: left;
        }

        .timeline-item::before {
            content: '✦';
            position: absolute;
            left: -2rem;
            top: 0;
            color: var(--gold);
            font-size: 0.7rem;
            transform: translateX(-50%);
        }

        .timeline-year {
            font-size: 0.75rem;
            letter-spacing: 3px;
            color: var(--gold);
            margin-bottom: 0.3rem;
        }

        .timeline-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .timeline-desc {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        /* ===== QUOTE ===== */
        .quote-text {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.15rem;
            line-height: 1.8;
            color: var(--text);
        }

        .quote-author {
            font-size: 0.8rem;
            color: var(--gold);
            margin-top: 1rem;
        }

        /* ===== GALLERY ===== */
        .gallery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .gallery-item {
            border-radius: 0.75rem;
            overflow: hidden;
            aspect-ratio: 1;
            background: var(--primary-light);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* ===== GIFT / AMPLOP ===== */
        .gift-card {
            background: linear-gradient(135deg, rgba(201, 168, 76, 0.08), rgba(15, 15, 42, 0.8));
        }

        .gift-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .gift-bank {
            padding: 1rem;
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 0.75rem;
            margin-bottom: 0.8rem;
        }

        .gift-bank-name {
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.5rem;
        }

        .gift-account {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .gift-holder {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .copy-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
            padding: 0.4rem 1rem;
            background: transparent;
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 2rem;
            color: var(--gold);
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .copy-btn:hover {
            background: rgba(201, 168, 76, 0.1);
        }

        /* ===== RSVP & WISHES ===== */
        .rsvp-form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(15, 15, 42, 0.6);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 0.5rem;
            color: var(--text);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--gold);
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-select option {
            background: var(--primary-dark);
        }

        .rsvp-attendance {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .rsvp-btn {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid rgba(201, 168, 76, 0.3);
            border-radius: 0.5rem;
            background: transparent;
            color: var(--text-light);
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .rsvp-btn.active {
            background: rgba(201, 168, 76, 0.2);
            border-color: var(--gold);
            color: var(--gold);
        }

        .submit-btn {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, var(--gold), #a8862e);
            border: none;
            border-radius: 2rem;
            color: var(--primary-dark);
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(201, 168, 76, 0.3);
        }

        /* ===== WISHES LIST ===== */
        .wishes-list {
            max-height: 400px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--gold) transparent;
        }

        .wish-item {
            padding: 1rem;
            border-bottom: 1px solid rgba(201, 168, 76, 0.1);
            text-align: left;
        }

        .wish-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .wish-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: white;
            font-weight: 600;
        }

        .wish-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text);
        }

        .wish-time {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .wish-text {
            font-size: 0.9rem;
            color: var(--text-light);
            padding-left: 3rem;
        }

        .no-wishes {
            color: var(--text-muted);
            font-style: italic;
            padding: 2rem 0;
            font-size: 0.9rem;
        }

        /* ===== COUNTDOWN ===== */
        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .countdown-item {
            text-align: center;
        }

        .countdown-value {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1;
        }

        .countdown-label {
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 0.3rem;
        }

        /* ===== NAV DOTS ===== */
        .nav-dots {
            position: fixed;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .nav-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(201, 168, 76, 0.3);
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            padding: 0;
        }

        .nav-dot.active {
            background: var(--gold);
            box-shadow: 0 0 10px rgba(201, 168, 76, 0.5);
        }

        /* ===== FOOTER ===== */
        .celestial-footer {
            padding: 2rem 1.5rem;
            text-align: center;
            background: linear-gradient(180deg, transparent, rgba(11, 11, 30, 0.9));
        }

        .footer-names {
            font-family: 'Great Vibes', cursive;
            font-size: 1.5rem;
            color: var(--gold-light);
        }

        .footer-text {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }

        .footer-brand {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 1rem;
            opacity: 0.5;
        }

        /* ===== MUSIC TOGGLE ===== */
        .music-toggle {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 100;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(15, 15, 42, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(201, 168, 76, 0.3);
            color: var(--gold);
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .music-toggle:hover {
            border-color: var(--gold);
            box-shadow: 0 0 15px rgba(201, 168, 76, 0.3);
        }

        .music-toggle.muted {
            opacity: 0.5;
        }

        /* ===== RESPONSIVE ===== */
        @media (min-width: 768px) {
            .cover-names {
                font-size: 3.5rem;
            }

            .section-inner {
                max-width: 480px;
            }

            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* ===== ANIMATIONS ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== SHOOTING STAR ===== */
        .shooting-star {
            position: absolute;
            width: 80px;
            height: 1px;
            background: linear-gradient(90deg, rgba(201, 168, 76, 0.8), transparent);
            animation: shoot 3s ease-in-out infinite;
            opacity: 0;
        }

        .shooting-star:nth-child(1) {
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .shooting-star:nth-child(2) {
            top: 25%;
            left: 60%;
            animation-delay: 1.5s;
        }

        @keyframes shoot {
            0% { transform: translateX(0) translateY(0) rotate(-35deg); opacity: 0; }
            5% { opacity: 1; }
            30% { transform: translateX(200px) translateY(120px) rotate(-35deg); opacity: 0; }
            100% { opacity: 0; }
        }
        /* ===== OPEN INVITATION BUTTON (celestial glass) ===== */
        /* ===== OPEN GUEST (nama tamu di atas tombol buka) ===== */
        .open-guest {
            margin: 1.5rem auto 0;
            text-align: center;
        }
        .open-guest-eyebrow {
            font-size: .7rem;
            letter-spacing: .35em;
            text-transform: uppercase;
            color: var(--gold);
            opacity: .85;
            margin-bottom: .35rem;
            font-weight: 300;
        }
        .open-guest-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.25rem;
            color: var(--gold-light);
            letter-spacing: .05em;
            text-shadow: 0 0 16px rgba(201, 168, 76, .25);
        }
        .open-invitation-btn {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            margin: 1.75rem auto 0;
            padding: .85rem 1.75rem;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #f5e9c9;
            background: linear-gradient(135deg, rgba(255,255,255,.14) 0%, rgba(245,233,201,.18) 100%);
            border: 1px solid rgba(245,233,201,.45);
            border-radius: 999px;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 0 24px rgba(245,233,201,.18), inset 0 0 12px rgba(245,233,201,.08);
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
            animation: openBtnPulse 2.8s ease-in-out infinite;
        }
        .open-invitation-btn:hover,
        .open-invitation-btn:focus-visible {
            transform: translateY(-2px) scale(1.02);
            background: linear-gradient(135deg, rgba(245,233,201,.28) 0%, rgba(255,255,255,.22) 100%);
            box-shadow: 0 0 36px rgba(245,233,201,.45), inset 0 0 14px rgba(245,233,201,.18);
            outline: none;
        }
        .open-invitation-btn i { font-size: 1.1rem; }
        @keyframes openBtnPulse {
            0%, 100% { box-shadow: 0 0 24px rgba(245,233,201,.18), inset 0 0 12px rgba(245,233,201,.08); }
            50%      { box-shadow: 0 0 32px rgba(245,233,201,.35), inset 0 0 14px rgba(245,233,201,.15); }
        }
    </style>
</head>
<body class="cover-locked">
    {{-- Shooting Stars --}}
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>

    {{-- Stars Canvas --}}
    <canvas class="stars-canvas" id="starsCanvas"></canvas>

    {{-- Nav Dots --}}
    <nav class="nav-dots" id="navDots">
        <button class="nav-dot active" data-section="0" aria-label="Cover"></button>
        <button class="nav-dot" data-section="1" aria-label="Ayat"></button>
        <button class="nav-dot" data-section="2" aria-label="Mempelai"></button>
        <button class="nav-dot" data-section="3" aria-label="Acara"></button>
        <button class="nav-dot" data-section="4" aria-label="Love Story"></button>
        <button class="nav-dot" data-section="5" aria-label="Galeri"></button>
        <button class="nav-dot" data-section="6" aria-label="Amplop"></button>
        <button class="nav-dot" data-section="7" aria-label="RSVP"></button>
    </nav>

    <div class="celestial-page" x-data="celestialInvitation()" x-init="init()">

        {{-- ==================== COVER ==================== --}}
        <section class="section section-cover" id="section-0">
            <div class="section-inner fade-up">
                <div class="cover-moon"></div>
                <p class="cover-subtitle">The Wedding of</p>
                <h1 class="cover-names">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}
                    <span class="cover-ampersand">&</span>
                    {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h1>
                <p class="cover-date">
                    @if(!empty($invitation->content['acara']['akad']['waktu']))
                        {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'])->translatedFormat('d F Y') }}
                    @else
                        Tanggal Pernikahan
                    @endif
                </p>
                <div class="open-guest">
                    <p class="open-guest-eyebrow">Kepada Yth.</p>
                    <p class="open-guest-name">{{ $guest->name ?? ($invitation->content['guest_name'] ?? 'Tamu Undangan') }}</p>
                </div>
                <div class="open-cta-wrap">
                    <button type="button" class="open-invitation-btn" onclick="openInvitation()" aria-label="Buka Undangan">
                        <i class="ph ph-envelope-open"></i>
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
            <div class="scroll-indicator">
                <i class="ph ph-caret-double-down"></i>
            </div>
        </section>

        {{-- ==================== QURAN VERSE ==================== --}}
        <section class="section" id="section-1" style="background: linear-gradient(180deg, #2d1854 0%, #1a1a40 100%);">
            <div class="section-inner fade-up">
                <div class="glass-card quran-card">
                    <div class="celestial-divider">
                        <span class="line"></span>
                        <span class="star">✦</span>
                        <span class="line"></span>
                    </div>
                    <p class="quran-arabic" dir="rtl">وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً</p>
                    <p class="quran-text">"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang."</p>
                    <p class="quran-source">QS. Ar-Rum: 21</p>
                    <div class="celestial-divider">
                        <span class="line"></span>
                        <span class="star">✦</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== COUPLE ==================== --}}
        <section class="section" id="section-2" style="background: linear-gradient(180deg, #1a1a40 0%, #0f0f2a 50%, #1a1a40 100%);">
            <div class="section-inner fade-up">
                <p class="section-label">Mempelai</p>
                <h2 class="section-title">Bride & Groom</h2>
                <div class="celestial-divider">
                    <span class="line"></span>
                    <span class="star">✦</span>
                    <span class="line"></span>
                </div>

                <div class="couple-grid">
                    {{-- GROOM --}}
                    <div class="person-card glass-card">
                        <div class="person-avatar">
                            @if(!empty($invitation->content['mempelai']['pria']['foto']))
                                <img src="{{ $invitation->content['mempelai']['pria']['foto'] }}" alt="{{ $invitation->content['mempelai']['pria']['nama'] ?? '' }}">
                            @else
                                <i class="ph ph-user"></i>
                            @endif
                        </div>
                        <h3 class="person-name">{{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}</h3>
                        <p class="person-fullname">{{ $invitation->content['mempelai']['pria']['nama'] ?? '' }}</p>
                        <p class="person-parents">Putra dari {{ $invitation->content['mempelai']['pria']['ayah'] ?? '' }} & {{ $invitation->content['mempelai']['pria']['ibu'] ?? '' }}</p>
                        @if(!empty($invitation->content['mempelai']['pria']['instagram']))
                            <p class="person-instagram">
                                <i class="ph ph-instagram-logo"></i> {{ $invitation->content['mempelai']['pria']['instagram'] }}
                            </p>
                        @endif
                    </div>

                    {{-- Heart --}}
                    <div class="couple-heart">
                        <i class="ph-fill ph-heart"></i>
                    </div>

                    {{-- BRIDE --}}
                    <div class="person-card glass-card">
                        <div class="person-avatar">
                            @if(!empty($invitation->content['mempelai']['wanita']['foto']))
                                <img src="{{ $invitation->content['mempelai']['wanita']['foto'] }}" alt="{{ $invitation->content['mempelai']['wanita']['nama'] ?? '' }}">
                            @else
                                <i class="ph ph-user"></i>
                            @endif
                        </div>
                        <h3 class="person-name">{{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</h3>
                        <p class="person-fullname">{{ $invitation->content['mempelai']['wanita']['nama'] ?? '' }}</p>
                        <p class="person-parents">Putri dari {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '' }} & {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '' }}</p>
                        @if(!empty($invitation->content['mempelai']['wanita']['instagram']))
                            <p class="person-instagram">
                                <i class="ph ph-instagram-logo"></i> {{ $invitation->content['mempelai']['wanita']['instagram'] }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== EVENTS ==================== --}}
        <section class="section" id="section-3" style="background: linear-gradient(180deg, #1a1a40 0%, #2d1854 50%, #1a1a40 100%);">
            <div class="section-inner fade-up">
                <p class="section-label">Acara</p>
                <h2 class="section-title">Wedding Events</h2>
                <div class="celestial-divider">
                    <span class="line"></span>
                    <span class="star">✦</span>
                    <span class="line"></span>
                </div>

                {{-- Countdown --}}
                @if(!empty($invitation->content['acara']['akad']['waktu']))
                <div class="glass-card" x-data="countdown('{{ $invitation->content['acara']['akad']['waktu'] }}')" x-init="start()">
                    <p class="section-label" style="margin-bottom:0.5rem">Hitung Mundur</p>
                    <div class="countdown-grid">
                        <div class="countdown-item">
                            <div class="countdown-value" x-text="days">0</div>
                            <div class="countdown-label">Hari</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-value" x-text="hours">0</div>
                            <div class="countdown-label">Jam</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-value" x-text="minutes">0</div>
                            <div class="countdown-label">Menit</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-value" x-text="seconds">0</div>
                            <div class="countdown-label">Detik</div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- AKAD --}}
                @if(!empty($invitation->content['acara']['akad']))
                <div class="glass-card event-card">
                    <div class="event-icon">
                        <i class="ph ph-church"></i>
                    </div>
                    <p class="event-label">Akad Nikah</p>
                    <h3 class="event-title">The Ceremony</h3>
                    <p class="event-info">
                        <i class="ph ph-calendar"></i>
                        @if(!empty($invitation->content['acara']['akad']['waktu']))
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'])->translatedFormat('l, d F Y') }}
                        @endif
                    </p>
                    <p class="event-info">
                        <i class="ph ph-clock"></i>
                        @if(!empty($invitation->content['acara']['akad']['waktu']))
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'])->format('H:i') }} WIB
                        @endif
                    </p>
                    @if(!empty($invitation->content['acara']['akad']['tempat']))
                        <p class="event-venue">{{ $invitation->content['acara']['akad']['tempat'] }}</p>
                    @endif
                    @if(!empty($invitation->content['acara']['akad']['alamat']))
                        <p class="event-address">{{ $invitation->content['acara']['akad']['alamat'] }}</p>
                    @endif
                    @if(!empty($invitation->content['acara']['akad']['maps']))
                        <a href="{{ $invitation->content['acara']['akad']['maps'] }}" target="_blank" class="maps-btn">
                            <i class="ph ph-map-pin"></i> Lihat Lokasi
                        </a>
                    @endif
                </div>
                @endif

                {{-- RESEPSI --}}
                @if(!empty($invitation->content['acara']['resepsi']))
                <div class="glass-card event-card">
                    <div class="event-icon">
                        <i class="ph ph-champagne"></i>
                    </div>
                    <p class="event-label">Resepsi</p>
                    <h3 class="event-title">The Celebration</h3>
                    <p class="event-info">
                        <i class="ph ph-calendar"></i>
                        @if(!empty($invitation->content['acara']['resepsi']['waktu']))
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'])->translatedFormat('l, d F Y') }}
                        @endif
                    </p>
                    <p class="event-info">
                        <i class="ph ph-clock"></i>
                        @if(!empty($invitation->content['acara']['resepsi']['waktu']))
                            {{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'])->format('H:i') }} WIB
                        @endif
                    </p>
                    @if(!empty($invitation->content['acara']['resepsi']['tempat']))
                        <p class="event-venue">{{ $invitation->content['acara']['resepsi']['tempat'] }}</p>
                    @endif
                    @if(!empty($invitation->content['acara']['resepsi']['alamat']))
                        <p class="event-address">{{ $invitation->content['acara']['resepsi']['alamat'] }}</p>
                    @endif
                    @if(!empty($invitation->content['acara']['resepsi']['maps']))
                        <a href="{{ $invitation->content['acara']['resepsi']['maps'] }}" target="_blank" class="maps-btn">
                            <i class="ph ph-map-pin"></i> Lihat Lokasi
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </section>

        {{-- ==================== LOVE STORY ==================== --}}
        @if(!empty($invitation->content['love_stories']) && count($invitation->content['love_stories']) > 0)
        <section class="section" id="section-4" style="background: linear-gradient(180deg, #1a1a40 0%, #0f0f2a 100%);">
            <div class="section-inner fade-up">
                <p class="section-label">Our Journey</p>
                <h2 class="section-title">Love Story</h2>
                <div class="celestial-divider">
                    <span class="line"></span>
                    <span class="star">✦</span>
                    <span class="line"></span>
                </div>

                <div class="glass-card">
                    <div class="timeline">
                        @foreach($invitation->content['love_stories'] as $story)
                        <div class="timeline-item">
                            @if(!empty($story['year']))
                                <p class="timeline-year">{{ $story['year'] }}</p>
                            @endif
                            <h4 class="timeline-title">{{ $story['title'] ?? '' }}</h4>
                            <p class="timeline-desc">{{ $story['description'] ?? '' }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- ==================== QUOTE ==================== --}}
        @if(!empty($invitation->content['quote']))
        <section class="section" style="background: linear-gradient(180deg, #0f0f2a 0%, #1a1a40 100%); min-height: 50vh;">
            <div class="section-inner fade-up">
                <div class="glass-card">
                    <div class="celestial-divider">
                        <span class="line"></span>
                        <span class="star">✦</span>
                        <span class="line"></span>
                    </div>
                    <p class="quote-text">"{{ $invitation->content['quote'] }}"</p>
                    <div class="celestial-divider">
                        <span class="line"></span>
                        <span class="star">✦</span>
                        <span class="line"></span>
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- ==================== GALLERY ==================== --}}
        @if(!empty($invitation->content['media']['gallery']) && count($invitation->content['media']['gallery']) > 0)
        <section class="section" id="section-5" style="background: linear-gradient(180deg, #1a1a40 0%, #2d1854 100%);">
            <div class="section-inner fade-up">
                <p class="section-label">Galeri</p>
                <h2 class="section-title">Our Moments</h2>
                <div class="celestial-divider">
                    <span class="line"></span>
                    <span class="star">✦</span>
                    <span class="line"></span>
                </div>

                <div class="gallery-grid">
                    @foreach($invitation->content['media']['gallery'] as $photo)
                        <div class="gallery-item">
                            <img src="{{ $photo }}" alt="Gallery" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- ==================== GIFT / AMPLOP ==================== --}}
        @if(!empty($invitation->content['amplop']))
        <section class="section" id="section-6" style="background: linear-gradient(180deg, #2d1854 0%, #1a1a40 100%);">
            <div class="section-inner fade-up">
                <p class="section-label">Hadiah</p>
                <h2 class="section-title">Wedding Gift</h2>
                <div class="celestial-divider">
                    <span class="line"></span>
                    <span class="star">✦</span>
                    <span class="line"></span>
                </div>

                <div class="glass-card gift-card">
                    <div class="gift-icon">🎁</div>
                    <p class="quran-text" style="margin-bottom:1.5rem">
                        Tanpa mengurangi rasa hormat, bagi yang ingin memberikan tanda kasih untuk kedua mempelai, dapat melalui:
                    </p>

                    @if(!empty($invitation->content['amplop']['bank_name']))
                    <div class="gift-bank">
                        <p class="gift-bank-name">{{ $invitation->content['amplop']['bank_name'] }}</p>
                        <p class="gift-account">{{ $invitation->content['amplop']['account_number'] }}</p>
                        <p class="gift-holder">a.n. {{ $invitation->content['amplop']['account_holder'] }}</p>
                        <button class="copy-btn" @click="copyToClipboard('{{ $invitation->content['amplop']['account_number'] }}')">
                            <i class="ph ph-copy"></i> Salin Nomor
                        </button>
                    </div>
                    @endif

                    @if(!empty($invitation->content['amplop']['alamat_kado']))
                    <div class="gift-bank">
                        <p class="gift-bank-name">Kirim Kado</p>
                        <p class="gift-holder">{{ $invitation->content['amplop']['alamat_kado'] }}</p>
                        @if(!empty($invitation->content['amplop']['maps_kado']))
                            <a href="{{ $invitation->content['amplop']['maps_kado'] }}" target="_blank" class="maps-btn" style="margin-top:0.5rem">
                                <i class="ph ph-map-pin"></i> Lihat Maps
                            </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif

        {{-- ==================== RSVP & WISHES ==================== --}}
        <section class="section" id="section-7" style="background: linear-gradient(180deg, #1a1a40 0%, #0b0b1e 100%);">
            <div class="section-inner fade-up">
                <p class="section-label">Konfirmasi</p>
                <h2 class="section-title">RSVP & Wishes</h2>
                <div class="celestial-divider">
                    <span class="line"></span>
                    <span class="star">✦</span>
                    <span class="line"></span>
                </div>

                {{-- RSVP Form --}}
                <div class="glass-card">
                    <form class="rsvp-form" @submit.prevent="submitRSVP()">
                        <div class="form-group">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-input" x-model="rsvp.name" placeholder="Nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kehadiran</label>
                            <div class="rsvp-attendance">
                                <button type="button" class="rsvp-btn" :class="{'active': rsvp.attendance === 'hadir'}" @click="rsvp.attendance = 'hadir'">
                                    ✨ Hadir
                                </button>
                                <button type="button" class="rsvp-btn" :class="{'active': rsvp.attendance === 'tidak_hadir'}" @click="rsvp.attendance = 'tidak_hadir'">
                                    🌙 Tidak Hadir
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah Tamu</label>
                            <select class="form-select" x-model="rsvp.guests">
                                <option value="1">1 Orang</option>
                                <option value="2">2 Orang</option>
                                <option value="3">3 Orang</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ucapan & Doa</label>
                            <textarea class="form-textarea" x-model="rsvp.wish" placeholder="Tulis ucapan dan doa untuk kedua mempelai..."></textarea>
                        </div>
                        <button type="submit" class="submit-btn" :disabled="rsvpSubmitting">
                            <span x-show="!rsvpSubmitting">Kirim Ucapan</span>
                            <span x-show="rsvpSubmitting">Mengirim...</span>
                        </button>
                    </form>
                </div>

                {{-- Wishes List --}}
                <div class="glass-card" style="margin-top:1.5rem">
                    <h3 style="font-family:'Great Vibes',cursive;font-size:1.4rem;color:var(--gold-light);margin-bottom:1rem;">Ucapan & Doa</h3>
                    <div class="wishes-list">
                        <template x-if="wishes.length === 0">
                            <p class="no-wishes">Belum ada ucapan. Jadilah yang pertama!</p>
                        </template>
                        <template x-for="wish in wishes" :key="wish.id">
                            <div class="wish-item">
                                <div class="wish-header">
                                    <div class="wish-avatar" x-text="wish.name.charAt(0).toUpperCase()"></div>
                                    <div>
                                        <p class="wish-name" x-text="wish.name"></p>
                                        <p class="wish-time" x-text="wish.time"></p>
                                    </div>
                                </div>
                                <p class="wish-text" x-text="wish.message"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        {{-- ==================== FOOTER ==================== --}}
        <footer class="celestial-footer">
            <div class="celestial-divider">
                <span class="line"></span>
                <span class="star">✦</span>
                <span class="line"></span>
            </div>
            <p class="footer-names">
                {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} &
                {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
            </p>
            <p class="footer-text">Terima kasih atas doa & restu Anda</p>
            <p class="footer-brand">Made with ✦ by Temanten</p>
        </footer>
    </div>

{{-- Music Toggle --}}
@php
    $musicFile = data_get($invitation, 'music_file') ?? data_get($invitation, 'content.media.music');
    $musicFile = $musicFile && file_exists(public_path($musicFile)) ? $musicFile : null;
@endphp
    @if($musicFile)
    <button class="music-toggle" id="musicToggle" onclick="toggleMusic()" title="Toggle Music">
        <i class="ph ph-speaker-simple-high" id="musicIcon"></i>
    </button>
    <audio id="bgMusic" loop preload="auto">
        <source src="{{ asset($musicFile) }}" type="audio/mpeg">
    </audio>
    @endif

    <script>
        // ===== STARS CANVAS =====
        (function() {
            const canvas = document.getElementById('starsCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let stars = [];
            const STAR_COUNT = 150;

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }

            function createStars() {
                stars = [];
                for (let i = 0; i < STAR_COUNT; i++) {
                    stars.push({
                        x: Math.random() * canvas.width,
                        y: Math.random() * canvas.height,
                        r: Math.random() * 1.5 + 0.5,
                        alpha: Math.random(),
                        da: (Math.random() - 0.5) * 0.02
                    });
                }
            }

            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                stars.forEach(s => {
                    s.alpha += s.da;
                    if (s.alpha <= 0.2 || s.alpha >= 1) s.da *= -1;
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(255, 255, 255, ${s.alpha})`;
                    ctx.fill();
                });
                requestAnimationFrame(draw);
            }

            resize();
            createStars();
            draw();
            window.addEventListener('resize', () => { resize(); createStars(); });
        })();

        // ===== MUSIC =====
        let musicPlaying = false;
        function toggleMusic() {
            const audio = document.getElementById('bgMusic');
            const icon = document.getElementById('musicIcon');
            const btn = document.getElementById('musicToggle');
            if (!audio) return;
            if (musicPlaying) {
                audio.pause();
                icon.className = 'ph ph-speaker-simple-slash';
                btn.classList.add('muted');
            } else {
                audio.play();
                icon.className = 'ph ph-speaker-simple-high';
                btn.classList.remove('muted');
            }
            musicPlaying = !musicPlaying;
        }

        // ===== NAV DOTS =====
        (function() {
            const dots = document.querySelectorAll('.nav-dot');
            const sections = document.querySelectorAll('.section');

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const idx = dot.dataset.section;
                    const target = document.getElementById('section-' + idx);
                    if (target) target.scrollIntoView({ behavior: 'smooth' });
                });
            });

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const idx = Array.from(sections).indexOf(entry.target);
                        dots.forEach(d => d.classList.remove('active'));
                        if (dots[idx]) dots[idx].classList.add('active');
                    }
                });
            }, { threshold: 0.5 });

            sections.forEach(s => observer.observe(s));
        })();

        // ===== FADE UP ANIMATION =====
        (function() {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
        })();

        // ===== AUTO PLAY MUSIC ON FIRST INTERACTION =====
        document.addEventListener('click', function firstClick() {
            const audio = document.getElementById('bgMusic');
            const icon = document.getElementById('musicIcon');
            const btn = document.getElementById('musicToggle');
            if (audio && !musicPlaying) {
                audio.play().then(() => {
                    musicPlaying = true;
                    icon.className = 'ph ph-speaker-simple-high';
                    btn.classList.remove('muted');
                }).catch(() => {});
            }
            document.removeEventListener('click', firstClick);
        }, { once: true });

        // ===== OPEN INVITATION HANDLER =====
        function openInvitation() {
            // Lepaskan kunci cover (boleh scroll lagi)
            document.body.classList.remove('cover-locked');
            // Tutup nav-dots sampai cover dibuka
            const navDots = document.getElementById('navDots');
            if (navDots) navDots.style.display = '';

            const audio = document.getElementById('bgMusic');
            const icon  = document.getElementById('musicIcon');
            const btn   = document.getElementById('musicToggle');
            if (audio && !musicPlaying) {
                audio.play().then(() => {
                    musicPlaying = true;
                    if (icon) icon.className = 'ph ph-speaker-simple-high';
                    if (btn)  btn.classList.remove('muted');
                }).catch(() => {});
            }
            // Smooth scroll ke section berikutnya setelah unlock
            setTimeout(() => {
                const next = document.getElementById('section-1') || document.querySelector('.section:not(.section-cover)');
                if (next) next.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 60);
        }
    </script>

    <script>
        function celestialInvitation() {
            return {
                rsvp: {
                    name: '',
                    attendance: 'hadir',
                    guests: '1',
                    wish: ''
                },
                rsvpSubmitting: false,
                wishes: [],

                init() {
                    this.loadWishes();
                },

                async submitRSVP() {
                    if (!this.rsvp.name.trim()) return;
                    this.rsvpSubmitting = true;
                    try {
                        const slug = '{{ $invitation->slug ?? "" }}';
                        const response = await fetch(`/undangan/${slug}/ucapan`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                nama: this.rsvp.name,
                                kehadiran: this.rsvp.attendance,
                                jumlah_tamu: parseInt(this.rsvp.guests),
                                ucapan: this.rsvp.wish
                            })
                        });
                        const data = await response.json();
                        if (data.success) {
                            this.wishes.unshift({
                                id: Date.now(),
                                name: this.rsvp.name,
                                message: this.rsvp.wish || (this.rsvp.attendance === 'hadir' ? 'Akan hadir ✨' : 'Tidak bisa hadir 🌙'),
                                time: 'Baru saja'
                            });
                            this.rsvp = { name: '', attendance: 'hadir', guests: '1', wish: '' };
                        }
                    } catch (e) {
                        console.error('RSVP error:', e);
                    }
                    this.rsvpSubmitting = false;
                },

                async loadWishes() {
                    const slug = '{{ $invitation->slug ?? "" }}';
                    if (!slug || slug.startsWith('demo-')) return; // Demo pages: no real wishes
                    try {
                        const response = await fetch(`/undangan/${slug}/ucapan`, {
                            headers: { 'Accept': 'application/json' }
                        });
                        const data = await response.json();
                        if (data.success && data.data) {
                            this.wishes = data.data.map(g => ({
                                id: g.id,
                                name: g.nama,
                                message: g.ucapan || (g.kehadiran === 'hadir' ? 'Akan hadir ✨' : 'Tidak bisa hadir 🌙'),
                                time: g.created_at_human || g.created_at
                            }));
                        }
                    } catch (e) {
                        console.error('Load wishes error:', e);
                    }
                },

                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        alert('Nomor rekening berhasil disalin!');
                    }).catch(() => {
                        const el = document.createElement('textarea');
                        el.value = text;
                        document.body.appendChild(el);
                        el.select();
                        document.execCommand('copy');
                        document.body.removeChild(el);
                        alert('Nomor rekening berhasil disalin!');
                    });
                }
            };
        }

        function countdown(targetDate) {
            return {
                days: '0',
                hours: '0',
                minutes: '0',
                seconds: '0',
                interval: null,

                start() {
                    this.update();
                    this.interval = setInterval(() => this.update(), 1000);
                },

                update() {
                    const target = new Date(targetDate).getTime();
                    const now = new Date().getTime();
                    const diff = target - now;

                    if (diff <= 0) {
                        this.days = this.hours = this.minutes = this.seconds = '0';
                        if (this.interval) clearInterval(this.interval);
                        return;
                    }

                    this.days = Math.floor(diff / (1000 * 60 * 60 * 24)).toString();
                    this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                    this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                    this.seconds = Math.floor((diff % (1000 * 60)) / 1000).toString().padStart(2, '0');
                }
            };
        }
    </script>
</body>
</html>