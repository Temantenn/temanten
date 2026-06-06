<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Tema - Temanten Digital Invitation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <style>

        .glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .nav-scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --primary-light: #818CF8;
            --secondary: #10B981;
            --accent: #F59E0B;
            --dark: #1F2937;
            --gray-900: #111827;
            --gray-800: #1F2937;
            --gray-700: #374151;
            --gray-600: #4B5563;
            --gray-500: #6B7280;
            --gray-400: #9CA3AF;
            --gray-300: #D1D5DB;
            --gray-200: #E5E7EB;
            --gray-100: #F3F4F6;
            --gray-50: #F9FAFB;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #F8FAFC 0%, #EEF2FF 50%, #FDF4FF 100%);
            min-height: 100vh;
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
        }

        .hero {
            padding: 8rem 2rem 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(79, 70, 229, 0.1);
            border: 1px solid rgba(79, 70, 229, 0.2);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .hero-badge span {
            background: var(--primary);
            color: white;
            padding: 0.125rem 0.5rem;
            border-radius: 50px;
            font-size: 0.7rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, var(--gray-900), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: var(--gray-500);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--gray-500);
        }

        .filter-bar {
            max-width: 1280px;
            margin: 0 auto 2rem;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            background: white;
            padding: 0.375rem;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            max-width: 100%;
        }

        .filter-tabs::-webkit-scrollbar { 
            display: none; 
        }

        .filter-tab {
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            background: transparent;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .filter-tab:hover { color: var(--primary); }
        .filter-tab.active {
            background: var(--primary);
            color: white;
        }

        .filter-search {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: white;
            padding: 0.625rem 1.25rem;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 2px solid transparent;
            transition: all 0.3s;
        }
        
        .filter-search:focus-within {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .filter-search input {
            border: none;
            outline: none;
            font-size: 0.875rem;
            width: 180px;
            font-family: inherit;
            color: var(--gray-700);
            background: transparent;
        }

        .filter-search input::placeholder { color: var(--gray-400); }

        /* Custom Dropdown Styles */
        .custom-dropdown {
            position: relative;
            min-width: 170px;
            font-family: inherit;
        }

        .dropdown-trigger {
            width: 100%;
            padding: 0.625rem 1.25rem;
            background: white;
            border-radius: 50px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dropdown-trigger:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transform: translateY(-2px);
            color: var(--primary);
        }

        .dropdown-trigger.active {
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            color: var(--primary);
            background: var(--gray-50);
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 0.75rem);
            left: 0;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            padding: 0.5rem;
            display: none;
            z-index: 100;
            border: 1px solid var(--gray-100);
            animation: dropdownSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes dropdownSlideIn {
            from { opacity: 0; transform: translateY(-10px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-menu.show { display: block; }

        .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item:hover {
            background: var(--gray-50);
            color: var(--primary);
        }

        .dropdown-item.selected {
            background: rgba(79, 70, 229, 0.05);
            color: var(--primary);
            font-weight: 700;
        }

        .filter-search input::placeholder { color: var(--gray-400); }

        .themes-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        .themes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 2rem;
        }

        .theme-card {
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(148, 163, 184, 0.18);
        }

        .theme-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 28px 70px rgba(79, 70, 229, 0.18);
            border-color: rgba(99, 102, 241, 0.22);
        }

        .theme-card-image {
            position: relative;
            aspect-ratio: 3/4;
            overflow: hidden;
            background: linear-gradient(135deg, var(--gray-100), var(--gray-200));
        }

        .theme-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .theme-card:hover .theme-card-image img {
            transform: scale(1.05);
        }

        .theme-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                transparent 0%,
                transparent 40%,
                rgba(0,0,0,0.7) 100%
            );
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
        }

        .theme-card:hover .theme-card-overlay { opacity: 1; }

        .theme-card-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-preview {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.75rem;
            background: white;
            color: var(--gray-800);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.2s;
        }

        .btn-preview:hover { background: var(--gray-100); }

        .btn-choose {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.75rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.2s;
        }

        .btn-choose:hover { transform: scale(1.02); }

        .theme-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.875rem;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .theme-badge.new { color: var(--secondary); }
        .theme-badge.popular { color: var(--accent); }
        .theme-badge.islamic { color: #2D5A4A; }

        .theme-price-wrapper {
            position: absolute;
            top: 1.5rem;
            right: 0;
            filter: drop-shadow(-4px 4px 10px rgba(0,0,0,0.15));
            z-index: 10;
        }

        .theme-price {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(14px);
            /* Membentuk seperti ribbon / hexagon cut di sebelah kiri */
            clip-path: polygon(15px 0%, 100% 0%, 100% 100%, 15px 100%, 0% 50%);
            padding: 0.55rem 1.05rem 0.55rem 1.8rem;
            min-width: 92px;
            font-family: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-left: 4px solid var(--accent);
        }

        .theme-card-body {
            padding: 1.5rem;
        }

        .theme-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-100);
        }

        .theme-card-footnote {
            font-size: 0.72rem;
            color: var(--gray-500);
            line-height: 1.35;
        }

        .theme-card-order-link {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            white-space: nowrap;
            color: var(--primary);
            font-size: 0.78rem;
            font-weight: 800;
            text-decoration: none;
        }

        .theme-card-category {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray-400);
            margin-bottom: 0.5rem;
        }

        .theme-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .theme-card-description {
            font-size: 0.85rem;
            color: var(--gray-500);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .theme-card-features {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .feature-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.75rem;
            background: var(--gray-100);
            border-radius: 50px;
            font-size: 0.7rem;
            color: var(--gray-600);
        }

        .feature-tag svg { width: 12px; height: 12px; }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .cta-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 4rem 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .btn-cta-white {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: white;
            color: var(--primary);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-cta-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }

        .footer {
            background: var(--gray-900);
            color: var(--gray-400);
            padding: 3rem 2rem 2rem;
            text-align: center;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 1.5rem 0;
        }

        .footer-links a {
            color: var(--gray-400);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s;
        }

        .footer-links a:hover { color: white; }

        .footer-copyright {
            font-size: 0.8rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-800);
        }

        .filter-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .navbar-nav { display: none; }

            .hero { padding: 7rem 1.5rem 3rem; }
            .hero-title { font-size: 2rem; }
            .hero-stats { gap: 1.5rem; }
            .stat-number { font-size: 1.5rem; }

            .filter-bar { flex-direction: column; align-items: stretch; }
            .filter-tabs { overflow-x: auto; padding-bottom: 0.5rem; }
            
            .filter-actions {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
            }
            
            .filter-search { justify-content: flex-start; width: 100%; }
            .filter-search input { width: 100%; }
            
            .custom-dropdown { width: 100%; min-width: 100%; }
            .custom-dropdown .dropdown-trigger { width: 100%; justify-content: space-between; }

            .themes-grid { grid-template-columns: 1fr; gap: 1.5rem; }
            .theme-card-image { aspect-ratio: 4/5; }

            .cta-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <div id="previewModal" class="fixed inset-0 z-[100] hidden bg-black/95 backdrop-blur-xl transition-all duration-500 opacity-0 flex flex-col">

        {{-- Modal Header --}}
        <div class="w-full shrink-0 bg-gray-950/95 border-b border-white/10 flex justify-between items-center px-5 py-3 z-50">
            {{-- Left: device toggle + theme name --}}
            <div class="flex items-center gap-4">
                <div class="flex bg-white/5 rounded-xl p-1 border border-white/10 gap-1">
                    <button onclick="setDevice('mobile')" id="btnMobile" title="Mobile" class="px-3 py-2 rounded-lg text-xs font-semibold text-indigo-300 bg-indigo-600/30 border border-indigo-500/40 transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Mobile
                    </button>
                    <button onclick="setDevice('desktop')" id="btnDesktop" title="Desktop" class="px-3 py-2 rounded-lg text-xs font-semibold text-white/50 hover:text-white hover:bg-white/10 transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Desktop
                    </button>
                </div>
                <div class="hidden md:block">
                    <p id="previewThemeName" class="text-white font-semibold text-sm">Preview Tema</p>
                    <p class="text-white/40 text-xs">Scroll untuk jelajahi · Klik luar untuk tutup</p>
                </div>
            </div>
            {{-- Right: Order + Close --}}
            <div class="flex items-center gap-3">
                <a id="btnOrderTheme" href="#"
                   class="hidden sm:flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-5 py-2.5 rounded-full text-sm font-bold transition-all shadow-lg shadow-indigo-500/30 hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Pilih Tema Ini
                </a>
                <button onclick="closePreview()" title="Tutup (Esc)" class="text-white/60 hover:text-white bg-white/5 hover:bg-red-600 border border-white/10 hover:border-red-500 rounded-xl p-2.5 transition-all group">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="flex-1 flex items-center justify-center overflow-hidden relative" onclick="closePreview()">

            {{-- Loader --}}
            <div id="loader" class="absolute inset-0 flex flex-col items-center justify-center z-20 pointer-events-none gap-4 bg-black/80">
                <div class="relative">
                    <div class="animate-spin rounded-full h-14 w-14 border-4 border-indigo-500/30 border-t-indigo-500"></div>
                </div>
                <p class="text-white/50 text-sm">Memuat tema...</p>
            </div>

            {{-- Phone Frame (Mobile) --}}
            <div id="frameWrapper" onclick="event.stopPropagation()" class="relative transition-all duration-500 flex-shrink-0 shadow-2xl">
                {{-- Phone chrome --}}
                <div id="phoneChromeTop" class="absolute top-0 inset-x-0 z-30 pointer-events-none">
                    <div class="mx-auto w-[120px] h-[28px] bg-gray-900 rounded-b-2xl"></div>
                </div>
                {{-- Home indicator --}}
                <div id="phoneChromeBottom" class="absolute bottom-0 inset-x-0 z-30 pointer-events-none flex justify-center pb-2">
                    <div class="w-20 h-1 bg-white/30 rounded-full"></div>
                </div>
                <iframe id="previewFrame" src="" frameborder="0" scrolling="yes"
                    class="block bg-white"
                    style="width:375px;height:calc(100vh - 110px);border-radius:44px;display:block;"
                    onload="onFrameLoad()"></iframe>
            </div>
        </div>
    </div>

    <nav id="mainNav" class="fixed w-full z-50 glass border-b border-gray-100/50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex justify-between items-center">

            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl overflow-hidden shadow-md group-hover:rotate-12 group-hover:scale-110 transition-all duration-300 drop-shadow-lg">
                    <img src="{{ asset('assets/mini-logo.jpg') }}" alt="Logo Temanten" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-xl text-gray-900 tracking-tight leading-none">TEMANTEN</span>
                    <span class="text-[10px] text-gray-600 font-semibold tracking-wider uppercase">Digital Invitation</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-10 text-sm font-semibold text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-all duration-300 hover:scale-105 relative group">
                    Beranda
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('themes.index') }}" class="text-indigo-600 font-bold relative group">
                    Katalog Tema
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-indigo-600 transition-all duration-300"></span>
                </a>
                <a href="{{ route('order.create') }}" class="hover:text-indigo-600 transition-all duration-300 hover:scale-105 relative group">
                    Pesan Sekarang
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-indigo-600 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 hidden md:block transition-all duration-300 hover:scale-105">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 hover:text-indigo-600 hidden md:block transition-all duration-300 hover:scale-105">Masuk</a>
                @endauth
                <a href="{{ route('order.create') }}" class="btn-primary relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 sm:px-5 sm:py-2.5 md:px-6 md:py-3 rounded-full text-[10px] sm:text-xs md:text-sm font-bold shadow-xl shadow-indigo-200 hover:shadow-2xl hover:shadow-indigo-300 hover:scale-105 transition-all duration-300 whitespace-nowrap">
                    <span class="relative z-10">Buat Undangan</span>
                </a>
                <!-- Mobile Menu Button -->
                <button type="button" id="mobileMenuBtn" class="md:hidden text-gray-700 hover:text-indigo-600 p-2 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobileMenuPanel" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full left-0 origin-top transform transition-all duration-300 opacity-0 -translate-y-2">
            <div class="px-6 py-4 space-y-4">
                <a href="{{ route('home') }}" class="block w-full text-gray-700 font-semibold hover:text-indigo-600 py-2 mobile-link">Beranda</a>
                <a href="{{ route('themes.index') }}" class="block w-full text-indigo-600 font-bold py-2 mobile-link">Katalog Tema</a>
                <a href="{{ route('order.create') }}" class="block w-full text-gray-700 font-semibold hover:text-indigo-600 py-2 mobile-link">Pesan Sekarang</a>
                <div class="h-px bg-gray-100 my-2"></div>
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full text-center text-gray-700 font-bold hover:text-indigo-600 py-2 border-2 border-gray-200 rounded-full">Dashboard Menu</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center text-gray-700 font-bold hover:text-indigo-600 py-2 border-2 border-gray-200 rounded-full">Masuk Akun</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <span>NEW</span>
                Tema Islami Tersedia
            </div>
            <h1 class="hero-title">Koleksi Tema Undangan Digital Premium</h1>
            <p class="hero-subtitle">Pilih desain yang sesuai dengan kepribadian dan gaya pernikahan Anda. Semua tema responsif dan siap pakai.</p>

            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $themes->count() }}+</div>
                    <div class="stat-label">Tema Tersedia</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">Aman</div>
                    <div class="stat-label">Privasi Terjaga</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Responsive</div>
                </div>
            </div>
        </div>
    </section>

    <div class="filter-bar" style="flex-wrap:wrap; gap:0.75rem;">
        <div class="filter-tabs" id="filterTabs">
            <button class="filter-tab active" data-filter="all">Semua <span id="cnt-all" class="ml-1 text-xs bg-indigo-100 text-indigo-600 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="modern">Modern <span id="cnt-modern" class="ml-1 text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="islamic">Islami <span id="cnt-islamic" class="ml-1 text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="floral">Floral <span id="cnt-floral" class="ml-1 text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="rustic">Rustic <span id="cnt-rustic" class="ml-1 text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="boho terracotta">Boho <span id="cnt-boho-terracotta" class="ml-1 text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="dark" style="color:#9333ea;">🌙 Dark <span id="cnt-dark" class="ml-1 text-xs bg-purple-100 text-purple-600 px-1.5 py-0.5 rounded-full font-bold"></span></button>
            <button class="filter-tab" data-filter="traditional" style="color:#92400e;">🏛️ Jawa <span id="cnt-traditional" class="ml-1 text-xs bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-full font-bold"></span></button>
        </div>
        <div class="filter-actions">
            <div class="filter-search">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="searchInput" placeholder="Cari tema favorit...">
            </div>

            <!-- Custom Price Dropdown -->
            <div class="custom-dropdown" id="priceDropdown">
                <input type="hidden" id="priceFilter" value="all">
                <button class="dropdown-trigger" type="button">
                    <span class="flex items-center gap-2">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0114 0z"/></svg>
                        <span class="trigger-label">Semua Harga</span>
                    </span>
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="dropdown-menu">
                    <div class="dropdown-item selected" data-value="all">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        Semua Harga
                    </div>
                    <div class="dropdown-item" data-value="under50">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Di Bawah 50rb
                    </div>
                    <div class="dropdown-item" data-value="50to100">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M3 4v16M3 4l3 3m15-3l-3 3"/></svg>
                        50rb - 100rb
                    </div>
                    <div class="dropdown-item" data-value="above100">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/></svg>
                        Di Atas 100rb
                    </div>
                </div>
            </div>

            <!-- Custom Sort Dropdown -->
            <div class="custom-dropdown" id="sortDropdown">
                <input type="hidden" id="sortSelect" value="default">
                <button class="dropdown-trigger" type="button">
                    <span class="flex items-center gap-2">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                        <span class="trigger-label">Urutkan</span>
                    </span>
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="dropdown-menu">
                    <div class="dropdown-item selected" data-value="default">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Default
                    </div>
                    <div class="dropdown-item" data-value="az">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                        A → Z
                    </div>
                    <div class="dropdown-item" data-value="za">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                        Z → A
                    </div>
                    <div class="dropdown-item" data-value="newest">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Terbaru
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="themes-section">
        @if($themes->count() > 0)
        <div class="themes-grid">
            @foreach($themes as $theme)
            @php
                $descriptions = [
                    'barakah-love' => 'Tema elegan dengan nuansa Islami, warna sage green dan gold. Cocok untuk pasangan muslim.',
                    'emerald-garden' => 'Tema elegan dengan nuansa hijau emerald dan sentuhan emas. Cocok untuk pernikahan modern yang natural.',
                    'floral-pastel' => 'Desain romantis dengan motif bunga pastel yang lembut dan elegan.',
                    'rustic-green' => 'Gaya natural dengan sentuhan kayu dan dedaunan hijau segar.',
                    'royal-glass' => 'Tema mewah dengan efek glassmorphism yang modern dan premium.',
                    'boho-terracotta' => 'Tema bergaya Bohemian dengan sentuhan warna Terracotta yang hangat dan artistik.',
                    'ocean-breeze' => 'Tema segar dengan nuansa laut dan ombak yang menenangkan. Cocok untuk pernikahan outdoor atau pantai.',
                    'watercolor-flow' => 'Tema artistik dengan sentuhan cat air yang lembut dan mengalir indah.',
                    'midnight-garden' => 'Tema mewah bertema malam dengan aksen emas berkilau. Nuansa gelap, elegan, dan penuh bintang.',
                    'jawa-keraton' => 'Tema sakral tradisional Jawa. Nuansa sogan, emas, dan batik kawung dengan animasi gunungan wayang yang megah.',
                    'sunda-asih' => 'Tema natural tradisional Sunda. Hijau daun, bambu, dan mega mendung dengan animasi tirai kain dan siluet rumah panggung.',
                    'sekar-jagad' => 'Tema elegan kontemporer. Dusty rose, navy, dan emas dengan navigasi top-tab, flip card acara, dan galeri masonry.',
                    'pixel-adventure' => 'Tema undangan bergaya retro pixel art dengan pengalaman interaktif seperti game petualangan.',
                ];
                $description = $descriptions[$theme->slug] ?? 'Tema undangan digital dengan desain eksklusif dan responsif.';

                $categories = [
                    'barakah-love' => 'Islamic',
                    'emerald-garden' => 'Islamic',
                    'floral-pastel' => 'Floral',
                    'rustic-green' => 'Rustic',
                    'royal-glass' => 'Modern',
                    'boho-terracotta' => 'Boho Terracotta',
                    'ocean-breeze' => 'Modern',
                    'watercolor-flow' => 'Modern',
                    'midnight-garden' => 'Dark',
                    'jawa-keraton' => 'Traditional',
                    'sunda-asih' => 'Traditional',
                    'sekar-jagad' => 'Wedding',
                    'pixel-adventure' => 'Modern',
                ];
                $category = $categories[$theme->slug] ?? 'Wedding';

                $badges = [
                    'barakah-love' => ['islamic', '🕌 Islamic'],
                    'emerald-garden' => ['new', '✨ New'],
                    'floral-pastel' => ['popular', '⭐ Popular'],
                    'rustic-green' => ['new', '✨ New'],
                    'boho-terracotta' => ['new', '✨ New'],
                    'ocean-breeze' => ['popular', '🌊 Popular'],
                    'watercolor-flow' => ['new', '🎨 New'],
                    'midnight-garden' => ['new', '🌙 New'],
                    'jawa-keraton' => ['new', '🏛️ New'],
                    'sunda-asih' => ['new', '🌿 New'],
                    'sekar-jagad' => ['new', '🌸 New'],
                    'pixel-adventure' => ['new', '🎮 New'],
                ];
                $badge = $badges[$theme->slug] ?? null;

                $features = [
                    'barakah-love' => ['Ayat Al-Quran', 'Countdown', 'RSVP', 'Music'],
                    'emerald-garden' => ['Love Story', 'Gallery', 'RSVP', 'Music'],
                    'floral-pastel' => ['Gallery', 'Love Story', 'RSVP', 'Music'],
                    'rustic-green' => ['Countdown', 'Gallery', 'RSVP', 'Maps'],
                    'royal-glass' => ['Glass Effect', 'Gallery', 'RSVP', 'Music'],
                    'boho-terracotta' => ['Bohemian Art', 'Gallery', 'RSVP', 'Music'],
                    'ocean-breeze' => ['Ocean Vibes', 'Gallery', 'RSVP', 'Music'],
                    'watercolor-flow' => ['Artistic', 'Gallery', 'RSVP', 'Music'],
                    'midnight-garden' => ['Dark Luxury', 'Stars BG', 'RSVP', 'Music'],
                    'jawa-keraton' => ['Gunungan Gate', 'Batik Motif', 'RSVP', 'Music'],
                    'sunda-asih' => ['Rumah Panggung', 'Mega Mendung', 'RSVP', 'Music'],
                    'sekar-jagad' => ['Flip Card', 'Snap Scroll', 'RSVP', 'Music'],
                    'pixel-adventure' => ['Pixel Art', 'Game Quest', 'RSVP', 'Gallery'],
                ];
                $featureList = $features[$theme->slug] ?? ['Responsive', 'Gallery', 'RSVP'];
            @endphp
            <div class="theme-card" data-category="{{ strtolower($category) }}" data-name="{{ strtolower($theme->name) }}" data-price="{{ $theme->effective_price }}">
                <div class="theme-card-image">
                    @if($badge)
                    <span class="theme-badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                    @endif
                    @if($theme->has_promo)
                        <div class="theme-price-wrapper">
                            <div class="theme-price shadow-sm">
                                <span class="text-[0.65rem] text-slate-500 line-through font-bold mb-0.5 tracking-wide">{{ $theme->short_original_price }}</span>
                                <span class="text-amber-500 font-extrabold text-sm">{{ $theme->short_price }}</span>
                            </div>
                        </div>
                    @else
                        <div class="theme-price-wrapper">
                            <div class="theme-price shadow-sm text-indigo-600 font-extrabold text-sm py-1.5">
                                {{ $theme->short_price }}
                            </div>
                        </div>
                    @endif
                    {{-- Selalu gunakan slug sebagai nama file thumbnail, bukan kolom thumbnail dari DB --}}
                    <img src="{{ asset('assets/thumbnail/' . $theme->slug . '.png') }}" alt="{{ $theme->name }}" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=600&fit=crop'">
                    <div class="theme-card-overlay">
                        <div class="theme-card-actions">
                            <button onclick="openPreview('{{ route('demo.show', $theme->slug) }}', '{{ addslashes($theme->name) }}')" class="btn-preview">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Preview
                            </button>
                            <a href="{{ route('order.create', ['theme' => $theme->slug]) }}" class="btn-choose">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Pilih Tema
                            </a>
                        </div>
                    </div>
                </div>
                <div class="theme-card-body">
                    <p class="theme-card-category">{{ $category }}</p>
                    <h3 class="theme-card-title">{{ $theme->name }}</h3>
                    <p class="theme-card-description">{{ $description }}</p>
                    <div class="theme-card-features">
                        @foreach($featureList as $feature)
                        <span class="feature-tag">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $feature }}
                        </span>
                        @endforeach
                    </div>
                    <div class="theme-card-footer">
                        <p class="theme-card-footnote">Cocok untuk undangan cepat, elegan, dan mudah dikelola.</p>
                        <a href="{{ route('order.create', ['theme' => $theme->slug]) }}" class="theme-card-order-link">
                            Order
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">🎨</div>
            <h3>Belum Ada Tema</h3>
            <p>Tema undangan akan segera tersedia. Nantikan koleksi terbaru kami!</p>
        </div>
        @endif
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2 class="cta-title">Siap Membuat Undangan Impian Anda?</h2>
            <p class="cta-subtitle">Pilih tema favorit dan mulai buat undangan digital dalam hitungan menit. Mudah, cepat, dan elegan.</p>
            <a href="{{ route('order.create') }}" class="btn-cta-white">
                Mulai Sekarang
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </section>

    <!-- Footer - Enhanced -->
    <footer class="bg-gradient-to-b from-gray-900 to-black text-white relative overflow-hidden mt-12">
        <!-- Decorative Top Border -->
        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        
        <div class="max-w-7xl mx-auto px-6 py-16 relative z-10 w-full">
            <!-- Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12 text-left">
                
                <!-- Brand Column -->
                <div class="space-y-6 md:col-span-2">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl overflow-hidden shadow-lg border border-white/10">
                            <img src="{{ asset('assets/mini-logo.jpg') }}" alt="Logo Temanten" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h2 class="font-extrabold text-2xl tracking-tight m-0 p-0 text-white">TEMANTEN</h2>
                            <p class="text-[0.65rem] text-indigo-300 font-bold tracking-[0.2em] uppercase m-0 p-0 text-left">Digital Invitation</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-sm m-0">
                        Platform pembuatan undangan pernikahan digital elegan, modern, dan mudah digunakan. Bagikan kebahagiaan Anda hanya dalam beberapa menit bersama Temanten.
                    </p>
                    <!-- Social Media -->
                    <div class="flex gap-4 pt-2">
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-indigo-600 rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/10 text-white cursor-pointer" style="text-decoration: none;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-pink-600 rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/10 text-white cursor-pointer" style="text-decoration: none;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/5 hover:bg-blue-500 rounded-full flex items-center justify-center transition-all hover:scale-110 border border-white/10 text-white cursor-pointer" style="text-decoration: none;">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Navigasi Utama -->
                <div class="space-y-6">
                    <h3 class="font-bold text-white text-lg tracking-wide uppercase text-sm border-b border-white/10 pb-3 inline-block m-0">Menu Utama</h3>
                    <ul class="space-y-4 p-0 m-0" style="list-style: none;">
                        <li><a href="/" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm" style="text-decoration: none;"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Beranda</a></li>
                        <li><a href="/#fitur" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm" style="text-decoration: none;"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Fitur Unggulan</a></li>
                        <li><a href="/#faq" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm" style="text-decoration: none;"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Tanya Jawab (FAQ)</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-indigo-400 transition-colors flex items-center gap-2 text-sm" style="text-decoration: none;"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500/50"></span> Login Dashboard</a></li>
                    </ul>
                </div>

                <!-- Hubungi Kami -->
                <div class="space-y-6">
                    <h3 class="font-bold text-white text-lg tracking-wide uppercase text-sm border-b border-white/10 pb-3 inline-block m-0">Hubungi Kami</h3>
                    <div class="space-y-4 text-sm">
                        <div class="flex items-start gap-4 text-gray-400">
                            <div class="bg-white/5 p-2 rounded-lg text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-white/90 mb-0.5">WhatsApp Admin</div>
                                <a href="https://wa.me/6282220312195" target="_blank" class="text-gray-400 hover:text-indigo-400 transition-colors" style="text-decoration: none;">+62 822-2031-2195</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 text-gray-400">
                            <div class="bg-white/5 p-2 rounded-lg text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-white/90 mb-0.5">Email Dukungan</div>
                                <a href="mailto:hello@temanten.com" class="text-gray-400 hover:text-indigo-400 transition-colors" style="text-decoration: none;">hello@temanten.com</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 text-gray-400">
                            <div class="bg-white/5 p-2 rounded-lg text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-white/90 mb-0.5">Jam Operasional</div>
                                <span>Senin - Sabtu (09.00 - 17.00)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Bar -->
            <div class="pt-8 border-t border-white/10 m-0">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-400 text-sm text-center md:text-left m-0">
                        &copy; {{ date('Y') }} <span class="font-bold text-white tracking-widest">TEMANTEN</span>. Seluruh hak cipta dilindungi.
                    </p>
                    <div class="flex items-center gap-6 mt-4 md:mt-0 font-medium text-sm">
                        <!-- <a href="#" class="text-gray-500 hover:text-white transition-colors" style="text-decoration: none;">Syarat & Ketentuan</a>
                        <a href="#" class="text-gray-500 hover:text-white transition-colors" style="text-decoration: none;">Kebijakan Privasi</a> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>

        const modal = document.getElementById('previewModal');
        const frame = document.getElementById('previewFrame');
        const loader = document.getElementById('loader');
        const frameWrapper = document.getElementById('frameWrapper');
        const phoneNotch = document.getElementById('phoneNotch');
        const btnMobile = document.getElementById('btnMobile');
        const btnDesktop = document.getElementById('btnDesktop');
        const btnOrder = document.getElementById('btnOrderTheme');

        window.hideLoader = function () {
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.classList.add('hidden'), 300);
            }
        };

        window.onFrameLoad = function () {
            window.hideLoader();
        };

        window.openPreview = function (url, themeName) {
            if (loader) {
                loader.classList.remove('hidden');
                loader.style.opacity = '1';
            }
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(() => modal.style.opacity = '1');
                modal.style.transition = 'opacity 0.3s';
            }
            if (frame) { frame.src = url; }
            // Update theme name in header
            const nameEl = document.getElementById('previewThemeName');
            if (nameEl && themeName) nameEl.textContent = 'Preview: ' + themeName;
            // Update order button
            if (btnOrder && url) {
                const slug = url.split('/').pop();
                btnOrder.href = "{{ route('order.create') }}?theme=" + slug;
            }
            setDevice('mobile');
        };

        window.closePreview = function () {
            if (modal) {
                modal.style.opacity = '0';
                document.body.style.overflow = '';
                setTimeout(() => {
                    modal.classList.add('hidden');
                    if (frame) frame.src = '';
                }, 150);
            }
        };

        window.setDevice = function (type) {
            if (!frameWrapper || !frame) return;
            const vhFrame = 'calc(100vh - 110px)';

            const chromeTop = document.getElementById('phoneChromeTop');
            const chromeBot = document.getElementById('phoneChromeBottom');

            if (type === 'mobile') {
                frameWrapper.style.cssText = `
                    border-radius: 44px;
                    border: 8px solid #111;
                    box-shadow: 0 0 0 1px #333, 0 40px 80px rgba(0,0,0,0.6);
                    overflow: hidden;
                    transition: all 0.4s ease;
                    width: min(375px, 95vw);
                    margin: 0 auto;
                `;
                frame.style.cssText = `width: 100%; height:${vhFrame}; border-radius:32px; display:block;`;
                if (chromeTop) chromeTop.style.display = 'block';
                if (chromeBot) chromeBot.style.display = 'flex';
                // Highlight buttons
                btnMobile.className = 'px-3 py-2 rounded-lg text-xs font-semibold text-indigo-300 bg-indigo-600/30 border border-indigo-500/40 transition-all flex items-center gap-1.5';
                btnDesktop.className = 'px-3 py-2 rounded-lg text-xs font-semibold text-white/50 hover:text-white hover:bg-white/10 transition-all flex items-center gap-1.5';
            } else {
                frameWrapper.style.cssText = `
                    border-radius: 16px;
                    border: none;
                    box-shadow: 0 40px 80px rgba(0,0,0,0.5);
                    overflow: hidden;
                    transition: all 0.4s ease;
                    width: min(1200px, 92vw);
                    margin: 0 auto;
                `;
                frame.style.cssText = `width: 100%; height:${vhFrame}; border-radius:0; display:block;`;
                if (chromeTop) chromeTop.style.display = 'none';
                if (chromeBot) chromeBot.style.display = 'none';
                btnDesktop.className = 'px-3 py-2 rounded-lg text-xs font-semibold text-indigo-300 bg-indigo-600/30 border border-indigo-500/40 transition-all flex items-center gap-1.5';
                btnMobile.className = 'px-3 py-2 rounded-lg text-xs font-semibold text-white/50 hover:text-white hover:bg-white/10 transition-all flex items-center gap-1.5';
            }
        };

        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape") closePreview();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.filter-tab');
            const searchInput = document.getElementById('searchInput');
            const sortSelect = document.getElementById('sortSelect');
            const cards = Array.from(document.querySelectorAll('.theme-card'));
            const themesGrid = document.querySelector('.themes-grid');

            // ── Count badges per category ─────────────────────────────
            function updateCounts() {
                const allCards = document.querySelectorAll('.theme-card');
                const counts = { all: allCards.length };
                allCards.forEach(c => {
                    const cat = (c.getAttribute('data-category') || '').toLowerCase();
                    counts[cat] = (counts[cat] || 0) + 1;
                });
                document.querySelectorAll('.filter-tab').forEach(tab => {
                    const f = tab.getAttribute('data-filter');
                    const key = f === 'all' ? 'all' : f.toLowerCase();
                    const el = tab.querySelector('span');
                    if (el) el.textContent = counts[key] || 0;
                });
            }
            updateCounts();

            // ── Sort ──────────────────────────────────────────────────
            function sortCards(type) {
                if (!themesGrid) return;
                const sorted = [...cards];
                if (type === 'az') sorted.sort((a, b) => (a.dataset.name || '').localeCompare(b.dataset.name || ''));
                else if (type === 'za') sorted.sort((a, b) => (b.dataset.name || '').localeCompare(a.dataset.name || ''));
                else sorted.sort((a, b) => parseInt(a.dataset.order||0) - parseInt(b.dataset.order||0));
                sorted.forEach(c => themesGrid.appendChild(c));
            }
            // Record original order
            cards.forEach((c, i) => c.dataset.order = i);

            // ── Filter + Search ──────────────────────────────────────
            function filterThemes() {
                const activeTab = document.querySelector('.filter-tab.active');
                const category = (activeTab ? activeTab.getAttribute('data-filter') : 'all').toLowerCase();
                const searchTerm = (searchInput?.value || '').toLowerCase().trim();
                const priceRange = document.getElementById('priceFilter')?.value || 'all';
                let visibleCount = 0;

                cards.forEach(card => {
                    const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
                    const cardName = (card.getAttribute('data-name') || '').toLowerCase();
                    const cardPrice = parseInt(card.getAttribute('data-price') || 0);

                    const matchesCategory = category === 'all' || cardCategory === category;
                    const matchesSearch = !searchTerm || cardName.includes(searchTerm);
                    
                    let matchesPrice = true;
                    if (priceRange === 'under50') matchesPrice = cardPrice < 50000;
                    else if (priceRange === '50to100') matchesPrice = cardPrice >= 50000 && cardPrice <= 100000;
                    else if (priceRange === 'above100') matchesPrice = cardPrice > 100000;

                    if (matchesCategory && matchesSearch && matchesPrice) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Empty state
                let emptyMsg = document.getElementById('dynamicEmpty');
                if (visibleCount === 0) {
                    if (!emptyMsg) {
                        emptyMsg = document.createElement('div');
                        emptyMsg.id = 'dynamicEmpty';
                        emptyMsg.className = 'empty-state';
                        themesGrid?.parentNode.appendChild(emptyMsg);
                    }
                    emptyMsg.innerHTML = `<div class="empty-state-icon">🔍</div><h3>Tidak Ada Hasil</h3><p>Coba kata kunci lain atau ganti kategori.</p>`;
                    emptyMsg.style.display = 'block';
                    if (themesGrid) themesGrid.style.display = 'none';
                } else {
                    if (emptyMsg) emptyMsg.style.display = 'none';
                    if (themesGrid) themesGrid.style.display = 'grid';
                }
            }

            // ── Custom Dropdowns Logic ───────────────────────────────
            document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
                const trigger = dropdown.querySelector('.dropdown-trigger');
                const menu = dropdown.querySelector('.dropdown-menu');
                const items = dropdown.querySelectorAll('.dropdown-item');
                const input = dropdown.querySelector('input[type="hidden"]');
                const label = dropdown.querySelector('.trigger-label');

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(m => {
                        if (m !== menu) m.classList.remove('show');
                    });
                    document.querySelectorAll('.dropdown-trigger').forEach(t => {
                        if (t !== trigger) t.classList.remove('active');
                    });
                    
                    menu.classList.toggle('show');
                    trigger.classList.toggle('active');
                });

                items.forEach(item => {
                    item.addEventListener('click', () => {
                        const val = item.getAttribute('data-value');
                        const text = item.textContent.trim();
                        
                        input.value = val;
                        label.textContent = text;
                        
                        items.forEach(i => i.classList.remove('selected'));
                        item.classList.add('selected');
                        
                        menu.classList.remove('show');
                        trigger.classList.remove('active');
                        
                        // Trigger sort or filter
                        if (input.id === 'sortSelect') {
                            sortCards(val);
                        }
                        filterThemes();
                    });
                });
            });

            // Close dropdowns on outside click
            window.addEventListener('click', () => {
                document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
                document.querySelectorAll('.dropdown-trigger').forEach(t => t.classList.remove('active'));
            });

            // ── Event Listeners ───────────────────────────────────────
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    filterThemes();
                });
            });
            searchInput?.addEventListener('input', filterThemes);
        });

        const mainNav = document.getElementById('mainNav');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenuPanel = document.getElementById('mobileMenuPanel');
        const mobileLinks = document.querySelectorAll('.mobile-link');
        
        // Mobile Menu Toggle
        if (mobileMenuBtn && mobileMenuPanel) {
            mobileMenuBtn.addEventListener('click', () => {
                const isHidden = mobileMenuPanel.classList.contains('hidden');
                if (isHidden) {
                    mobileMenuPanel.classList.remove('hidden');
                    setTimeout(() => {
                        mobileMenuPanel.classList.remove('opacity-0', '-translate-y-2');
                        mobileMenuPanel.classList.add('opacity-100', 'translate-y-0');
                    }, 10);
                    mobileMenuBtn.innerHTML = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                } else {
                    mobileMenuPanel.classList.add('opacity-0', '-translate-y-2');
                    mobileMenuPanel.classList.remove('opacity-100', 'translate-y-0');
                    setTimeout(() => {
                        mobileMenuPanel.classList.add('hidden');
                    }, 300);
                    mobileMenuBtn.innerHTML = '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>';
                }
            });

            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenuBtn.click();
                });
            });
        }

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                mainNav.classList.add('nav-scrolled', 'py-3');
                mainNav.classList.remove('py-5');
            } else {
                mainNav.classList.remove('nav-scrolled', 'py-3');
                mainNav.classList.add('py-5');
            }
        });
    </script>
</body>
</html>
