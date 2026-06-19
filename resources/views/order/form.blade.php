@php
    $selectedThemeSlug = request('theme');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Undangan · Temanten</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Magazine Notion inline style — MUST come AFTER @vite so it wins cascade against app.css global rules (e.g. landing-page body #050505). --}}
    <style>
        :root {
            --paper: #f4ede0;
            --paper-deep: #ebe1cf;
            --paper-light: #faf6ee;
            --ink: #1c1814;
            --ink-soft: #2a2520;
            --brown: #5a4a35;
            --brown-light: #a07a52;
            --brown-soft: #8b6f3f;
            --gold: #b8956a;
            --line: #d4c5a0;
            --line-soft: #e8dcc4;
            --success: #6a7a4a;
            --danger: #8b3a3a;
        }

        html, body { background: var(--paper-deep); }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--ink);
            background-color: var(--paper-deep);
            background-image:
                repeating-linear-gradient(45deg, rgba(160,122,82,0.025) 0 2px, transparent 2px 6px),
                radial-gradient(ellipse at top right, rgba(184,149,106,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at bottom left, rgba(160,122,82,0.05) 0%, transparent 60%);
            min-height: 100dvh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        [x-cloak] { display: none !important; }

        .font-display { font-family: 'Cormorant Garamond', serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Paper card with subtle texture */
        .paper-card {
            background-color: var(--paper-light);
            background-image:
                repeating-linear-gradient(0deg, rgba(160,122,82,0.018) 0 1px, transparent 1px 3px),
                radial-gradient(circle at 20% 30%, rgba(184,149,106,0.04) 0%, transparent 50%);
            box-shadow:
                0 1px 0 rgba(255,255,255,0.5) inset,
                0 20px 50px -10px rgba(28,24,20,0.18),
                0 8px 20px -5px rgba(28,24,20,0.08);
        }

        /* Diagonal watermark */
        .watermark {
            position: absolute;
            inset: 0;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .watermark span {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 11rem;
            color: rgba(160,122,82,0.04);
            transform: rotate(-22deg);
            letter-spacing: 0.05em;
            white-space: nowrap;
            user-select: none;
        }
        @media (max-width: 768px) {
            .watermark span { font-size: 6rem; }
        }

        .dotted-divider { border-top: 1px dashed var(--line); margin: 1rem 0; }
        .dotted-divider-thick { border-top: 2px dashed var(--line); margin: 1.25rem 0; }

        /* Vol. ribbon — no display set, let Tailwind utilities (inline-flex, hidden sm:inline-flex) control */
        .vol-ribbon {
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.85rem;
            border: 1px solid var(--brown-light);
            border-radius: 999px;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.7rem;
            color: var(--brown);
            letter-spacing: 0.18em;
            text-transform: uppercase;
            line-height: 1;
            white-space: nowrap;
        }
        .vol-ribbon::before { content: '✦'; color: var(--brown-light); font-size: 0.65rem; }
        .vol-ribbon::after { content: '✦'; color: var(--brown-light); font-size: 0.65rem; }

        /* Step navigator (top) */
        .step-nav-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 0.75rem;
            border-radius: 999px;
            transition: all 250ms;
            position: relative;
        }
        .step-nav-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem; height: 1.75rem;
            border-radius: 50%;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1.5px solid var(--line);
            background: var(--paper-light);
            color: var(--brown-light);
            flex-shrink: 0;
            transition: all 250ms;
        }
        .step-nav-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--brown-light);
            transition: color 250ms;
        }
        .step-nav-item.active .step-nav-num {
            background: var(--brown);
            border-color: var(--brown);
            color: var(--paper-light);
            transform: scale(1.1);
            box-shadow: 0 4px 12px -2px rgba(90,74,53,0.4);
        }
        .step-nav-item.active .step-nav-text { color: var(--ink); }
        .step-nav-item.completed .step-nav-num {
            background: var(--success);
            border-color: var(--success);
            color: var(--paper-light);
        }
        .step-nav-item.completed .step-nav-text { color: var(--brown); }
        .step-nav-divider {
            flex: 1;
            height: 1px;
            border-top: 1px dashed var(--line);
            margin: 0 0.25rem;
            min-width: 1rem;
            max-width: 3rem;
        }
        .step-nav-divider.completed { border-top-style: solid; border-color: var(--success); }

        /* Section number badge */
        .section-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem; height: 2.5rem;
            border: 1px solid var(--brown-light);
            border-radius: 0.6rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--brown);
            background: var(--paper);
        }

        .label-micro {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: var(--brown-light);
        }

        /* Theme card */
        .theme-card-label {
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 2px solid var(--line);
            border-radius: 1.25rem;
            padding: 0.875rem;
            background: var(--paper-light);
            cursor: pointer;
            transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .theme-card-label:hover {
            border-color: var(--brown-light);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -8px rgba(28,24,20,0.12);
        }
        .theme-card-label.selected {
            border-color: var(--brown);
            background: var(--paper);
            box-shadow: 0 0 0 3px rgba(160,122,82,0.15), 0 10px 25px -8px rgba(28,24,20,0.15);
        }
        .theme-thumb {
            position: relative;
            height: 6rem; width: 5rem;
            background: var(--paper-deep);
            border-radius: 1rem;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(28,24,20,0.1);
            border: 1px solid var(--line-soft);
        }
        .theme-thumb img { height: 100%; width: 100%; object-fit: cover; }
        .theme-thumb-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--paper) 0%, var(--paper-deep) 100%);
            color: var(--brown-light);
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.75rem;
            text-align: center;
            padding: 0 0.5rem;
        }
        .radio-indicator {
            width: 1.75rem; height: 1.75rem;
            border-radius: 50%;
            border: 2px solid var(--line);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 200ms;
        }
        .theme-card-label.selected .radio-indicator {
            background: var(--brown);
            border-color: var(--brown);
        }
        .radio-check { width: 1rem; height: 1rem; color: var(--paper-light); display: none; }
        .theme-card-label.selected .radio-check { display: block; }

        /* Inputs */
        .paper-input {
            width: 100%;
            padding: 0.875rem 1rem;
            background: var(--paper-light);
            border: 1.5px solid var(--line);
            border-radius: 0.75rem;
            color: var(--ink);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 200ms;
        }
        .paper-input::placeholder { color: var(--brown-light); opacity: 0.6; }
        .paper-input:focus {
            outline: none;
            border-color: var(--brown);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(160,122,82,0.15);
        }
        .paper-input.invalid {
            border-color: var(--danger);
            background: rgba(139,58,58,0.03);
        }
        .paper-input-lg { font-size: 1.05rem; padding: 1rem 1.1rem; }
        .input-group {
            display: flex;
            overflow: hidden;
            border: 1.5px solid var(--line);
            border-radius: 0.75rem;
            background: var(--paper-light);
            transition: all 200ms;
        }
        .input-group:focus-within {
            border-color: var(--brown);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(160,122,82,0.15);
        }
        .input-group.invalid { border-color: var(--danger); background: rgba(139,58,58,0.03); }
        .input-group .input-prefix {
            display: inline-flex;
            align-items: center;
            padding: 0 1rem;
            background: var(--paper);
            color: var(--brown);
            font-size: 0.85rem;
            font-weight: 600;
            border-right: 1px solid var(--line);
        }
        .input-group .paper-input { border: none; border-radius: 0; background: transparent; flex: 1; }
        .input-group .paper-input:focus { box-shadow: none; }
        .input-error {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--danger);
            font-weight: 500;
        }
        .input-error svg { width: 0.95rem; height: 0.95rem; flex-shrink: 0; }

        /* Form field */
        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--brown);
        }
        .form-label svg { width: 1.1rem; height: 1.1rem; color: var(--brown-light); }
        .form-hint {
            display: flex;
            align-items: flex-start;
            gap: 0.4rem;
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--brown);
            line-height: 1.4;
        }
        .form-hint svg { width: 0.95rem; height: 0.95rem; color: var(--brown-light); flex-shrink: 0; margin-top: 0.1rem; }

        /* Error alert (server validation) */
        .error-alert {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: rgba(139,58,58,0.05);
            border: 1.5px solid rgba(139,58,58,0.3);
            border-left: 4px solid var(--danger);
            border-radius: 0.75rem;
        }
        .error-alert svg { color: var(--danger); flex-shrink: 0; margin-top: 0.1rem; }
        .error-alert h3 { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 1.15rem; font-weight: 600; color: var(--danger); margin-bottom: 0.5rem; }
        .error-alert ul { list-style: disc; padding-left: 1.25rem; font-size: 0.85rem; color: var(--ink-soft); }

        /* Info card */
        .info-card {
            padding: 1.5rem;
            background: linear-gradient(135deg, rgba(184,149,106,0.08) 0%, rgba(184,149,106,0.04) 100%);
            border: 1.5px dashed var(--gold);
            border-radius: 1rem;
        }
        .info-card svg.header-icon { color: var(--brown-soft); flex-shrink: 0; }
        .info-card h4 { font-family: 'Cormorant Garamond', serif; font-style: italic; font-size: 1.15rem; font-weight: 600; color: var(--ink); margin-bottom: 0.5rem; }
        .info-card p { font-size: 0.85rem; color: var(--ink-soft); line-height: 1.6; }
        .info-card .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.3rem 0.75rem;
            background: var(--paper-light);
            border: 1px solid var(--line);
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--brown);
        }

        /* Promo tag */
        .promo-tag {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            background: linear-gradient(135deg, #b8956a 0%, #8b6f3f 100%);
            color: var(--paper-light);
            border-radius: 999px;
            font-size: 0.55rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        .price-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.75rem;
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 999px;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }
        .price-promo { color: var(--brown); }
        .price-strike { color: var(--brown-light); opacity: 0.6; text-decoration: line-through; font-size: 0.85em; }

        /* Review step */
        .review-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.875rem 0;
            border-bottom: 1px dotted var(--line);
            gap: 1rem;
        }
        .review-row:last-child { border-bottom: none; }
        .review-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            color: var(--brown-light);
            flex-shrink: 0;
            min-width: 6rem;
        }
        .review-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            color: var(--ink);
            text-align: right;
            font-weight: 500;
            word-break: break-word;
        }
        .review-edit {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.5rem;
            font-size: 0.7rem;
            color: var(--brown);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 0.4rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 200ms;
        }
        .review-edit:hover { color: var(--ink); background: var(--paper); }

        /* Bottom step nav bar */
        .step-nav-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 40;
            padding: 1rem 1rem calc(1rem + env(safe-area-inset-bottom));
            background: linear-gradient(to top, var(--paper-deep) 0%, var(--paper-deep) 70%, transparent 100%);
            pointer-events: none;
        }
        .step-nav-bar > * { pointer-events: auto; }
        .step-nav-card {
            background: var(--paper-light);
            border: 1.5px solid var(--line);
            border-radius: 1.5rem;
            padding: 0.85rem 1rem;
            box-shadow: 0 20px 50px -15px rgba(28,24,20,0.3), 0 1px 0 rgba(255,255,255,0.5) inset;
            max-width: 64rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            min-width: 0;
        }
        .step-nav-card > * { min-width: 0; flex-shrink: 1; }
        .step-nav-card .btn-primary { flex-shrink: 0; min-width: 0; }
        @media (min-width: 768px) {
            .step-nav-card { padding: 1.25rem 1.75rem; gap: 0.75rem; }
            .step-nav-card .btn-primary { min-width: 9rem; }
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.8rem 1.1rem;
            background: var(--ink);
            color: var(--paper-light);
            border-radius: 0.85rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px -8px rgba(28,24,20,0.4);
            border: 1px solid var(--ink);
            cursor: pointer;
            white-space: nowrap;
        }
        @media (min-width: 768px) {
            .btn-primary { padding: 0.9rem 1.6rem; font-size: 0.8rem; letter-spacing: 0.12em; gap: 0.6rem; }
        }
        .btn-primary:hover:not(:disabled) {
            background: var(--ink-soft);
            transform: translateY(-1px);
            box-shadow: 0 12px 28px -8px rgba(28,24,20,0.5);
        }
        .btn-primary:active:not(:disabled) { transform: translateY(0); }
        .btn-primary:disabled { opacity: 0.4; cursor: not-allowed; }
        .btn-primary.is-final {
            background: linear-gradient(135deg, var(--brown) 0%, var(--ink) 100%);
            border-color: var(--brown);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.9rem 1.2rem;
            background: transparent;
            color: var(--brown);
            border: 1.5px solid var(--line);
            border-radius: 0.85rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            cursor: pointer;
            transition: all 200ms;
            white-space: nowrap;
        }
        .btn-ghost:hover {
            background: var(--paper);
            border-color: var(--brown-light);
            color: var(--ink);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.55rem 0.95rem;
            background: transparent;
            color: var(--brown);
            border: 1px solid var(--line);
            border-radius: 0.6rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            cursor: pointer;
            transition: all 200ms;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background: var(--paper);
            border-color: var(--brown-light);
            color: var(--ink);
        }

        /* Top brand bar */
        .top-bar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(250, 246, 238, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--line);
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(28, 24, 20, 0.96);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loading-overlay.hidden { display: none; }
        .loading-overlay .spinner {
            width: 5rem; height: 5rem;
            border-radius: 50%;
            border: 3px solid rgba(184,149,106,0.15);
            border-top-color: var(--gold);
            animation: spin 0.9s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .loading-overlay h3 {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.6rem;
            color: var(--paper-light);
            margin-bottom: 0.5rem;
        }
        .loading-overlay p {
            color: rgba(250, 246, 238, 0.6);
            font-size: 0.9rem;
        }

        /* Animations - opacity only */
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .anim-in { animation: fade-in 500ms cubic-bezier(0.4, 0, 0.2, 1) both; }
        .anim-in-1 { animation: fade-in 500ms cubic-bezier(0.4, 0, 0.2, 1) 100ms both; }
        .anim-in-2 { animation: fade-in 500ms cubic-bezier(0.4, 0, 0.2, 1) 200ms both; }

        /* Mobile-first sizing */
        .form-container { max-width: 64rem; margin: 0 auto; padding: 2rem 1rem 11rem; }
        @media (min-width: 768px) { .form-container { padding: 2.5rem 1.5rem 11rem; } }
        @media (min-width: 1280px) { .form-container { padding: 3rem 2rem 11rem; } }

        .card-container { max-width: 64rem; margin: 0 auto; }
        @media (min-width: 1280px) { .card-container { max-width: 80rem; } }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: var(--paper); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: var(--line); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: var(--brown-light); }

        /* Ultrawide flanking */
        .flank-decor { display: none; }
        @media (min-width: 1536px) {
            .flank-decor {
                display: flex;
                position: fixed;
                top: 50%;
                transform: translateY(-50%);
                writing-mode: vertical-rl;
                text-orientation: mixed;
                font-family: 'Cormorant Garamond', serif;
                font-style: italic;
                font-weight: 500;
                font-size: 0.75rem;
                color: var(--brown-light);
                letter-spacing: 0.4em;
                text-transform: uppercase;
                pointer-events: none;
                user-select: none;
                z-index: 1;
            }
            .flank-decor.left { left: 2rem; }
            .flank-decor.right { right: 2rem; transform: translateY(-50%) rotate(180deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body x-data="orderForm"
      data-total="{{ old('theme_id') ? ($themes->firstWhere('id', old('theme_id'))->effective_price ?? config('app.default_price')) : config('app.default_price') }}"
      data-theme-id="{{ old('theme_id') ?? 'null' }}"
      data-theme-name="{{ old('theme_id') ? ($themes->firstWhere('id', old('theme_id'))->name ?? '') : '' }}"
      data-whatsapp="{{ old('client_whatsapp') }}"
      data-slug="{{ old('slug') }}"
      data-groom="{{ old('groom_name') }}"
      data-bride="{{ old('bride_name') }}"
      data-date="{{ old('event_date') }}">

    {{-- Ultrawide flanking decoration --}}
    <aside class="flank-decor left" aria-hidden="true">Formulir · Edisi 2026 · Halaman 1</aside>
    <aside class="flank-decor right" aria-hidden="true">Undangan Digital · Aman &amp; Otomatis</aside>

    {{-- Top brand bar --}}
    <header class="top-bar">
        <div class="card-container flex items-center justify-between gap-4 px-4 md:px-6 py-3.5">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <span class="font-display text-xl md:text-2xl font-semibold tracking-tight text-[color:var(--ink)]">
                    Tementen<span class="text-[color:var(--brown-light)]">.</span>
                </span>
            </a>
            <span class="vol-ribbon hidden sm:inline-flex">Vol. 1 · Edisi Pemesanan</span>
            <a href="{{ route('home') }}" class="btn-secondary">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Beranda
            </a>
        </div>
    </header>

    <div class="form-container">

        {{-- Hero header --}}
        <div class="text-center mb-8 anim-in">
            <span class="vol-ribbon inline-flex">Proses · 4 Langkah</span>
            <h1 class="font-display text-3xl md:text-5xl font-semibold italic text-[color:var(--ink)] mt-3 leading-[1.05] tracking-tight">
                <span x-text="['Langkah Pertama','Lengkapi Data','Info Acara','Langkah Terakhir'][step - 1] || 'Menuju'"></span> Menuju<br>
                <span class="text-[color:var(--brown-light)]">Undangan Impianmu</span>
            </h1>
            <p class="mt-3 text-sm md:text-base text-[color:var(--brown)] max-w-2xl mx-auto leading-relaxed">
                Isi data singkat untuk membuat pesanan. Akun akan dibuatkan otomatis, undangan langsung bisa diakses.
            </p>
        </div>

        {{-- Top step navigator --}}
        <div class="mb-8 anim-in-1">
            <div class="flex items-center justify-center gap-1 sm:gap-2 max-w-3xl mx-auto px-2">
                <template x-for="(label, idx) in ['Pilih Tema', 'Data Diri', 'Info Acara', 'Konfirmasi']" :key="idx">
                    <div class="contents">
                        <div class="step-nav-item"
                             :class="{
                                'active': step === idx + 1,
                                'completed': step > idx + 1
                             }">
                            <span class="step-nav-num">
                                <template x-if="step > idx + 1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </template>
                                <template x-if="step <= idx + 1">
                                    <span x-text="['I','II','III','IV'][idx] + '.'"></span>
                                </template>
                            </span>
                            <span class="step-nav-text hidden md:inline" x-text="label"></span>
                        </div>
                        <template x-if="idx < 3">
                            <span class="step-nav-divider" :class="{ 'completed': step > idx + 1 }"></span>
                        </template>
                    </div>
                </template>
            </div>
        </div>

        {{-- Server-side error messages --}}
        @if ($errors->any())
        <div class="mb-8 anim-in">
            <div class="error-alert">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <div class="flex-1">
                    <h3>Periksa kembali isian Anda</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST" x-ref="form" @submit="submitForm($event)">
            @csrf

            {{-- ============== STEP 1: PILIH TEMA ============== --}}
            <section x-show="step === 1" x-cloak class="paper-card rounded-2xl overflow-hidden relative">
                <div class="watermark" aria-hidden="true"><span>TEMA</span></div>

                <header class="px-6 md:px-10 pt-7 md:pt-9 pb-5 border-b border-dashed border-[color:var(--line)] relative">
                    <div class="flex items-start gap-4">
                        <span class="section-num">I</span>
                        <div class="flex-1">
                            <span class="label-micro">Langkah Pertama</span>
                            <h2 class="font-display text-2xl md:text-3xl font-semibold text-[color:var(--ink)] mt-1 leading-tight">Pilih Tema Undangan</h2>
                            <p class="text-sm text-[color:var(--brown)] mt-1.5 leading-relaxed">Pilih desain yang paling sesuai dengan kepribadian Anda.</p>
                        </div>
                    </div>
                </header>

                <div class="p-6 md:p-10 relative">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($themes as $theme)
                        <div class="relative">
                            <input type="radio" name="theme_id" id="theme_{{ $theme->id }}" value="{{ $theme->id }}"
                                   class="sr-only theme-radio"
                                   {{ (old('theme_id') == $theme->id || $selectedThemeSlug == $theme->slug) ? 'checked' : '' }}
                                   @change="selectTheme({{ $theme->id }}, {{ $theme->effective_price }}, {{ json_encode($theme->name) }})"
                                   required>

                            <label for="theme_{{ $theme->id }}" class="theme-card-label {{ (old('theme_id') == $theme->id || $selectedThemeSlug == $theme->slug) ? 'selected' : '' }}">
                                <div class="theme-thumb">
                                    @php $thumbUrl = theme_thumb_url($theme); @endphp
                                    @if($thumbUrl)
                                        <img src="{{ $thumbUrl }}" alt="{{ $theme->name }}">
                                    @else
                                        <div class="theme-thumb-placeholder">{{ $theme->name }}</div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <h3 class="font-display font-semibold text-[color:var(--ink)] text-base truncate leading-tight">{{ $theme->name }}</h3>
                                            <p class="text-[10px] text-[color:var(--brown-light)] mt-0.5 uppercase tracking-wider font-semibold">Premium · Mobile Ready</p>
                                        </div>
                                        @if($theme->has_promo)
                                            <span class="promo-tag">Promo</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        @if($theme->has_promo)
                                            <div class="price-pill">
                                                <span class="price-strike">{{ $theme->short_original_price }}</span>
                                                <span class="price-promo">{{ $theme->short_price }}</span>
                                            </div>
                                        @else
                                            <div class="price-pill">
                                                <span class="price-promo">{{ $theme->short_price }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <p class="mt-1.5 text-[10px] font-semibold text-[color:var(--brown-light)] uppercase tracking-wider">Preview · RSVP · Galeri · Musik</p>
                                </div>

                                <div class="radio-indicator">
                                    <svg class="radio-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ============== STEP 2: DATA DIRI ============== --}}
            <section x-show="step === 2" x-cloak class="paper-card rounded-2xl overflow-hidden relative">
                <div class="watermark" aria-hidden="true"><span>DATA</span></div>

                <header class="px-6 md:px-10 pt-7 md:pt-9 pb-5 border-b border-dashed border-[color:var(--line)] relative">
                    <div class="flex items-start gap-4">
                        <span class="section-num">II</span>
                        <div class="flex-1">
                            <span class="label-micro">Langkah Kedua</span>
                            <h2 class="font-display text-2xl md:text-3xl font-semibold text-[color:var(--ink)] mt-1 leading-tight">Data Pemesan &amp; Akun</h2>
                            <p class="text-sm text-[color:var(--brown)] mt-1.5 leading-relaxed">Informasi kontak dan link undangan yang Anda inginkan.</p>
                        </div>
                    </div>
                </header>

                <div class="p-6 md:px-10 md:py-9 space-y-7 relative">
                    {{-- WhatsApp --}}
                    <div>
                        <label class="form-label">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            Nomor WhatsApp <span class="text-[color:var(--danger)]">*</span>
                        </label>
                        <div class="input-group" :class="{ 'invalid': errors.whatsapp }">
                            <span class="input-prefix">+62</span>
                            <input type="number" name="client_whatsapp" x-model="form.whatsapp" @input="clearError('whatsapp')" class="paper-input paper-input-lg" placeholder="8123456789" required>
                        </div>
                        <template x-if="errors.whatsapp">
                            <p class="input-error">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span x-text="errors.whatsapp"></span>
                            </p>
                        </template>
                        <p class="form-hint" x-show="!errors.whatsapp">
                            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span>Digunakan untuk notifikasi pesanan dan akses dashboard Anda.</span>
                        </p>
                    </div>

                    {{-- Slug --}}
                    <div>
                        <label class="form-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Link Undangan <span class="text-[color:var(--danger)]">*</span>
                        </label>
                        <div class="input-group" :class="{ 'invalid': errors.slug }">
                            <span class="input-prefix">undangan.com/</span>
                            <input type="text" name="slug" x-model="form.slug" @input="sanitizeSlug(); clearError('slug')" @blur="sanitizeSlug()" class="paper-input paper-input-lg" placeholder="romeo-juliet" pattern="[a-z0-9-]+" required>
                        </div>
                        <template x-if="errors.slug">
                            <p class="input-error">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span x-text="errors.slug"></span>
                            </p>
                        </template>
                        <p class="form-hint" x-show="!errors.slug">
                            <svg class="text-[color:var(--gold)]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            <span>
                                <strong>Aturan:</strong> huruf kecil, angka, dan strip (-) saja. Contoh: <code class="font-mono bg-[color:var(--paper)] px-1.5 py-0.5 rounded text-[color:var(--brown)]">rudi-siti</code>.
                            </span>
                        </p>
                    </div>
                </div>
            </section>

            {{-- ============== STEP 3: INFO ACARA ============== --}}
            <section x-show="step === 3" x-cloak class="paper-card rounded-2xl overflow-hidden relative">
                <div class="watermark" aria-hidden="true"><span>ACARA</span></div>

                <header class="px-6 md:px-10 pt-7 md:pt-9 pb-5 border-b border-dashed border-[color:var(--line)] relative">
                    <div class="flex items-start gap-4">
                        <span class="section-num">III</span>
                        <div class="flex-1">
                            <span class="label-micro">Langkah Ketiga</span>
                            <h2 class="font-display text-2xl md:text-3xl font-semibold text-[color:var(--ink)] mt-1 leading-tight">Informasi Acara</h2>
                            <p class="text-sm text-[color:var(--brown)] mt-1.5 leading-relaxed">Data dasar untuk judul dan tanggal utama di undangan Anda.</p>
                        </div>
                    </div>
                </header>

                <div class="p-6 md:px-10 md:py-9 space-y-7 relative">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                Nama Panggilan Pria <span class="text-[color:var(--danger)]">*</span>
                            </label>
                            <input type="text" name="groom_name" x-model="form.groom" @input="clearError('groom')" class="paper-input paper-input-lg" :class="{ 'invalid': errors.groom }" placeholder="Contoh: Romeo" required>
                            <input type="hidden" name="groom_father" value="-">
                            <input type="hidden" name="groom_mother" value="-">
                            <template x-if="errors.groom">
                                <p class="input-error">
                                    <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span x-text="errors.groom"></span>
                                </p>
                            </template>
                        </div>

                        <div>
                            <label class="form-label">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                Nama Panggilan Wanita <span class="text-[color:var(--danger)]">*</span>
                            </label>
                            <input type="text" name="bride_name" x-model="form.bride" @input="clearError('bride')" class="paper-input paper-input-lg" :class="{ 'invalid': errors.bride }" placeholder="Contoh: Juliet" required>
                            <input type="hidden" name="bride_father" value="-">
                            <input type="hidden" name="bride_mother" value="-">
                            <template x-if="errors.bride">
                                <p class="input-error">
                                    <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span x-text="errors.bride"></span>
                                </p>
                            </template>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Tanggal Acara <span class="text-[color:var(--danger)]">*</span>
                        </label>
                        <input type="date" name="event_date" x-model="form.date" @input="clearError('date')" class="paper-input paper-input-lg" :class="{ 'invalid': errors.date }" required>
                        <input type="hidden" name="location_address" value="Alamat belum diisi">
                        <template x-if="errors.date">
                            <p class="input-error">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span x-text="errors.date"></span>
                            </p>
                        </template>
                    </div>

                    <div class="info-card">
                        <div class="flex gap-4 items-start">
                            <svg class="header-icon w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <div class="flex-1">
                                <h4>Tenang, data lain bisa dilengkapi nanti</h4>
                                <p>Foto, galeri, cerita cinta, lokasi detail, dan informasi lainnya dapat Anda lengkapi di <strong>Dashboard Client</strong> setelah pendaftaran berhasil.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============== STEP 4: KONFIRMASI ============== --}}
            <section x-show="step === 4" x-cloak class="paper-card rounded-2xl overflow-hidden relative">
                <div class="watermark" aria-hidden="true"><span>REVIEW</span></div>

                <header class="px-6 md:px-10 pt-7 md:pt-9 pb-5 border-b border-dashed border-[color:var(--line)] relative">
                    <div class="flex items-start gap-4">
                        <span class="section-num">IV</span>
                        <div class="flex-1">
                            <span class="label-micro">Langkah Terakhir</span>
                            <h2 class="font-display text-2xl md:text-3xl font-semibold text-[color:var(--ink)] mt-1 leading-tight">Konfirmasi Pesanan</h2>
                            <p class="text-sm text-[color:var(--brown)] mt-1.5 leading-relaxed">Periksa kembali data Anda sebelum membuat pesanan.</p>
                        </div>
                    </div>
                </header>

                <div class="p-6 md:px-10 md:py-9 space-y-6 relative">
                    <div>
                        <div class="review-row">
                            <span class="review-label">Tema</span>
                            <div class="text-right">
                                <div class="review-value" x-text="form.themeName || '—'"></div>
                                <button type="button" @click="goToStep(1)" class="review-edit">Ubah</button>
                            </div>
                        </div>
                        <div class="review-row">
                            <span class="review-label">WhatsApp</span>
                            <div class="text-right">
                                <div class="review-value">+62 <span x-text="form.whatsapp || '—'"></span></div>
                                <button type="button" @click="goToStep(2)" class="review-edit">Ubah</button>
                            </div>
                        </div>
                        <div class="review-row">
                            <span class="review-label">Link</span>
                            <div class="text-right">
                                <div class="review-value font-mono text-sm">undangan.com/<span x-text="form.slug || '—'"></span></div>
                                <button type="button" @click="goToStep(2)" class="review-edit">Ubah</button>
                            </div>
                        </div>
                        <div class="review-row">
                            <span class="review-label">Mempelai</span>
                            <div class="text-right">
                                <div class="review-value" x-text="(form.groom && form.bride) ? (form.groom + ' & ' + form.bride) : '—'"></div>
                                <button type="button" @click="goToStep(3)" class="review-edit">Ubah</button>
                            </div>
                        </div>
                        <div class="review-row">
                            <span class="review-label">Tanggal</span>
                            <div class="text-right">
                                <div class="review-value" x-text="form.date ? new Date(form.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '—'"></div>
                                <button type="button" @click="goToStep(3)" class="review-edit">Ubah</button>
                            </div>
                        </div>
                    </div>

                    <div class="dotted-divider-thick"></div>

                    <div class="flex items-end justify-between gap-4 pt-2">
                        <div>
                            <span class="label-micro">Total Pembayaran</span>
                            <p class="font-display italic text-sm text-[color:var(--brown)] mt-1">Akses langsung · QRIS otomatis</p>
                        </div>
                        <div class="text-right">
                            <div class="font-display text-3xl md:text-4xl font-bold text-[color:var(--ink)]" x-text="formatRupiah(total)"></div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Submit (final step only) --}}
            <button type="submit" id="btnSubmit" data-testid="order-submit" class="hidden" :disabled="step !== 4">Submit</button>
        </form>
    </div>

    {{-- Bottom step nav bar --}}
    <div class="step-nav-bar">
        <div class="step-nav-card">
            <button type="button" @click="prevStep()" x-show="step > 1" class="btn-ghost">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </button>
            <div x-show="step === 1" class="hidden md:flex flex-col text-left">
                <span class="label-micro">Total</span>
                <span class="font-display text-lg font-semibold text-[color:var(--ink)]" x-text="formatRupiah(total)"></span>
            </div>

            <div class="flex items-center gap-3 ml-auto">
                <span class="hidden sm:inline-flex vol-ribbon">
                    <span>Langkah</span>&nbsp;<span x-text="step"></span>&nbsp;<span>dari</span>&nbsp;<span>4</span>
                </span>
                <button type="button" @click="nextStep()" :disabled="!canProceed" class="btn-primary" :class="{ 'is-final': step === 4 }">
                    <span x-show="step < 4">Lanjut</span>
                    <span x-show="step === 4">Buat Pesanan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Loading overlay --}}
    <div id="loadingOverlay" class="loading-overlay hidden">
        <div class="text-center space-y-5 max-w-md px-6">
            <div class="spinner mx-auto"></div>
            <div>
                <h3>Memproses Pesanan Anda</h3>
                <p>Mohon tunggu sebentar, jangan tutup halaman ini.</p>
            </div>
        </div>
    </div>

</body>
</html>
