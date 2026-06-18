@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $shortId = Str::afterLast($order->order_number, '-');
    $now = Carbon::now()->locale('id')->isoFormat('D MMMM Y');
    $hargaLayanan = $order->theme->effective_price;
    $kodeUnik = $order->unique_code;
    // Tampilkan harga flat ke user. unique_code tetap ada di DB
    // dan otomatis ter-inject ke nominal QRIS untuk auto-verify.
    $total = $order->theme->effective_price;

    $waNumber = env('ADMIN_WHATSAPP', '6282220312195');
    $waMessage = "Halo Admin, saya sudah melakukan pembayaran:\n\nOrder: {$order->order_number}\nTema: {$order->theme->name}\nNominal: Rp " . number_format($total, 0, ',', '.') . "\n\nMohon dicek, terima kasih!";
    $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Faktur {{ $shortId }} · Temanten</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        /* Dotted divider */
        .dotted-divider {
            border-top: 1px dashed var(--line);
            margin: 1rem 0;
        }
        .dotted-divider-thick {
            border-top: 2px dashed var(--line);
            margin: 1.25rem 0;
        }

        /* QR container */
        .qr-frame {
            background: var(--paper);
            border: 1px solid var(--line);
            padding: 1rem;
            border-radius: 1rem;
            position: relative;
        }
        .qr-frame::before, .qr-frame::after {
            content: '';
            position: absolute;
            width: 14px; height: 14px;
            border: 2px solid var(--brown-soft);
        }
        .qr-frame::before { top: -2px; left: -2px; border-right: none; border-bottom: none; border-top-left-radius: 1rem; }
        .qr-frame::after { bottom: -2px; right: -2px; border-left: none; border-top: none; border-bottom-right-radius: 1rem; }

        /* QR corner brackets */
        .qr-corner {
            position: absolute;
            width: 16px; height: 16px;
            border: 2px solid var(--brown);
        }
        .qr-corner.tl { top: 6px; left: 6px; border-right: none; border-bottom: none; }
        .qr-corner.tr { top: 6px; right: 6px; border-left: none; border-bottom: none; }
        .qr-corner.bl { bottom: 6px; left: 6px; border-right: none; border-top: none; }
        .qr-corner.br { bottom: 6px; right: 6px; border-left: none; border-top: none; }

        /* Scanline animation */
        @keyframes scanline {
            0%   { transform: translateY(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(180px); opacity: 0; }
        }
        .scanline {
            position: absolute;
            left: 8px; right: 8px;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--brown-soft) 50%, transparent 100%);
            animation: scanline 2.4s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            pointer-events: none;
        }

        /* Vol. ribbon */
        .vol-ribbon {
            display: inline-flex;
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
        }
        .vol-ribbon::before {
            content: '✦';
            color: var(--brown-light);
            font-size: 0.65rem;
        }
        .vol-ribbon::after {
            content: '✦';
            color: var(--brown-light);
            font-size: 0.65rem;
        }

        /* Step TOC */
        .toc-item {
            display: flex;
            align-items: baseline;
            gap: 0.6rem;
            padding: 0.4rem 0;
            border-bottom: 1px dotted var(--line);
        }
        .toc-item:last-child { border-bottom: none; }
        .toc-num {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.95rem;
            color: var(--brown-light);
            min-width: 1.5rem;
        }
        .toc-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: var(--brown);
            flex: 1;
        }

        /* Stamp badge */
        .stamp {
            display: inline-block;
            padding: 0.3rem 0.85rem;
            border: 2px solid var(--success);
            color: var(--success);
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            transform: rotate(-3deg);
            border-radius: 0.25rem;
            background: rgba(106,122,74,0.04);
        }

        /* Big total amount */
        .total-amount {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            line-height: 1;
            color: var(--ink);
            letter-spacing: -0.02em;
        }
        .total-amount .rp {
            font-size: 1rem;
            color: var(--brown-light);
            margin-right: 0.4rem;
            font-weight: 500;
            vertical-align: 0.5em;
        }
        .total-amount .num {
            font-size: 3rem;
            font-weight: 700;
        }

        /* Primary CTA */
        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            width: 100%;
            padding: 1rem 1.5rem;
            background: var(--ink);
            color: var(--paper-light);
            border-radius: 0.85rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 250ms cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px -8px rgba(28,24,20,0.4);
            border: 1px solid var(--ink);
        }
        .btn-primary:hover {
            background: var(--ink-soft);
            transform: translateY(-1px);
            box-shadow: 0 12px 28px -8px rgba(28,24,20,0.5);
        }
        .btn-primary:active { transform: translateY(0); }

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

        /* Status pill */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            font-family: 'Inter', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.18em;
        }
        .status-pill-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--brown-light);
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }

        /* Label micro */
        .label-micro {
            font-family: 'Inter', sans-serif;
            font-size: 0.6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.22em;
            color: var(--brown-light);
        }

        /* Help link */
        .help-link {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.85rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.85rem;
            color: var(--brown);
            text-decoration: none;
            transition: color 200ms;
        }
        .help-link:hover { color: var(--ink); }
        .help-link::before { content: '→'; font-style: normal; }

        /* Item row in invoice */
        .invoice-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 0.6rem 0;
            border-bottom: 1px dotted var(--line);
            font-size: 0.8rem;
        }
        .invoice-row:last-child { border-bottom: none; }
        .invoice-row .label { color: var(--brown); font-weight: 500; }
        .invoice-row .value { font-family: 'Cormorant Garamond', serif; font-weight: 600; color: var(--ink); font-size: 1rem; }
        .invoice-row.highlight .value { color: var(--brown-light); }

        /* Receipt stub (perforated edge) */
        .receipt-stub {
            position: relative;
        }
        .receipt-stub::before {
            content: '';
            position: absolute;
            left: 50%;
            top: -8px;
            transform: translateX(-50%);
            width: 16px; height: 16px;
            background: var(--paper-deep);
            border-radius: 50%;
        }
        @media (min-width: 768px) {
            .receipt-stub-divider {
                position: absolute;
                left: 50%; top: 0; bottom: 0;
                border-left: 2px dashed var(--line);
            }
        }

        /* Mobile-first card sizing */
        .card-container {
            max-width: 360px;
            margin: 0 auto;
        }
        @media (min-width: 768px) {
            .card-container { max-width: 64rem; }   /* md: 1024 */
        }
        @media (min-width: 1280px) {
            .card-container { max-width: 80rem; }   /* xl: 1280 */
        }
        @media (min-width: 1536px) {
            .card-container { max-width: 88rem; }   /* 2xl: 1408 */
        }

        /* Ultrawide flanking decoration (2xl+) */
        .flank-decor {
            display: none;
        }
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

        /* Animations */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .anim-in {
            animation: fade-in 600ms cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
            .scanline { display: none; }
        }
    </style>
</head>
<body x-data="paymentTimer('{{ $order->expired_at->toIso8601String() }}')">

    {{-- Ultrawide flanking decoration --}}
    <aside class="flank-decor left" aria-hidden="true">Faktur · Edisi 2026 · Halaman 1</aside>
    <aside class="flank-decor right" aria-hidden="true">QRIS · Pembayaran Aman</aside>

    {{-- Top band: brand + Vol. ribbon --}}
    <header class="w-full pt-8 pb-4 px-4 anim-in">
        <div class="card-container flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="font-display text-2xl font-semibold tracking-tight text-[color:var(--ink)]">
                    Tementen<span class="text-[color:var(--brown-light)]">.</span>
                </span>
            </a>
            <span class="vol-ribbon hidden sm:inline-flex">Vol. 1 · Edisi Pembayaran</span>
            <span class="vol-ribbon sm:hidden">Vol. 1</span>
        </div>
    </header>

    {{-- Main card --}}
    <main class="w-full px-4 pb-8">
        <article class="card-container relative">

            {{-- Watermark --}}
            <div class="watermark" aria-hidden="true"><span>TEMENTEN</span></div>

            {{-- Paper card --}}
            <div class="paper-card rounded-3xl overflow-hidden relative anim-in">

                {{-- Top invoice header strip --}}
                <div class="px-6 md:px-10 pt-7 md:pt-9 pb-5 border-b border-dashed border-[color:var(--line)]">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <span class="label-micro">Faktur Pembayaran</span>
                            <h1 class="font-display text-3xl md:text-4xl font-semibold italic text-[color:var(--ink)] mt-1 leading-none">
                                Faktur <span class="text-[color:var(--brown-light)]">№ {{ $shortId }}</span>
                            </h1>
                        </div>
                        <div class="text-right">
                            <span class="label-micro">Diterbitkan</span>
                            <p class="font-display italic text-base text-[color:var(--brown)] mt-1">{{ $now }}</p>
                            <div class="mt-2 status-pill border border-[color:var(--brown-light)]" style="color: var(--brown);">
                                <span class="status-pill-dot"></span>
                                QRIS Aktif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Two-column body --}}
                <div class="md:flex relative">

                    {{-- Receipt stub divider (md+) --}}
                    <div class="receipt-stub-divider hidden md:block"></div>

                    {{-- LEFT: Order details --}}
                    <section class="md:w-1/2 p-6 md:p-10 md:pr-12 relative">

                        <span class="label-micro">Pesanan Anda</span>
                        <h2 class="font-display text-2xl md:text-3xl font-semibold text-[color:var(--ink)] mt-2 leading-tight">
                            {{ $order->theme->name }}
                        </h2>
                        <div class="mt-2 flex items-center gap-2 flex-wrap">
                            <span class="font-display italic text-sm text-[color:var(--brown-light)]">Tema Pernikahan</span>
                            @if($order->theme->tier ?? false)
                                <span class="stamp">{{ strtoupper($order->theme->tier) }}</span>
                            @else
                                <span class="stamp">Premium</span>
                            @endif
                        </div>

                        {{-- Mobile: total prominently above breakdown --}}
                        <div class="md:hidden mt-6 mb-4 pb-5 border-b border-dashed border-[color:var(--line)]">
                            <span class="label-micro">Total Tagihan</span>
                            <div class="total-amount mt-2">
                                <span class="rp">Rp</span><span class="num">{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Breakdown --}}
                        <div class="mt-5">
                            <span class="label-micro">Rincian Biaya</span>
                            <div class="mt-2">
                                <div class="invoice-row">
                                    <span class="label">Harga Layanan</span>
                                    <span class="value">Rp {{ number_format($hargaLayanan, 0, ',', '.') }}</span>
                                </div>
                                <div class="invoice-row">
                                    <span class="label">Metode Pembayaran</span>
                                    <span class="value">QRIS</span>
                                </div>
                            </div>
                        </div>

                        {{-- Desktop total (right-aligned) --}}
                        <div class="hidden md:block mt-5 pt-5 border-t-2 border-dashed border-[color:var(--line)]">
                            <div class="flex items-end justify-between gap-4">
                                <div>
                                    <span class="label-micro">Total Akhir</span>
                                    <p class="font-display italic text-sm text-[color:var(--brown)] mt-1">Total pembayaran</p>
                                </div>
                                <div class="total-amount text-right">
                                    <span class="rp">Rp</span><span class="num">{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- CTA desktop --}}
                        <div class="hidden md:block mt-8">
                            <a href="{{ $waLink }}" target="_blank" class="btn-primary group">
                                <span>Konfirmasi via WhatsApp</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="{{ $waLink }}" target="_blank" class="help-link">
                                Chat admin dulu sebelum bayar
                            </a>
                        </div>

                        {{-- Trust strip --}}
                        <div class="hidden md:flex mt-7 pt-5 border-t border-dotted border-[color:var(--line)] items-center justify-between gap-3 text-[color:var(--brown-light)]">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                <span class="font-display italic text-xs">SSL Aman</span>
                            </div>
                            <span class="text-[color:var(--line)]">·</span>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="font-display italic text-xs">Privasi Dijaga</span>
                            </div>
                            <span class="text-[color:var(--line)]">·</span>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="font-display italic text-xs">Garansi 100%</span>
                            </div>
                        </div>
                    </section>

                    {{-- RIGHT: QR + pay steps --}}
                    <section class="md:w-1/2 p-6 md:p-8 md:pl-12 bg-[color:var(--paper)] relative">

                        {{-- Countdown --}}
                        <div class="text-center md:text-left">
                            <span class="label-micro">Batas Akhir Pembayaran</span>
                            <div class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-[color:var(--paper-light)] border border-[color:var(--line)] rounded-lg shadow-sm">
                                <span class="status-pill-dot"></span>
                                <span class="font-mono text-xl font-bold text-[color:var(--brown)] tracking-wider">
                                    <span x-text="hours">00</span>:<span x-text="minutes">00</span>:<span x-text="seconds">00</span>
                                </span>
                            </div>
                        </div>

                        {{-- QR --}}
                        <div class="mt-5 md:mt-6 flex flex-col items-center">
                            <div class="qr-frame">
                                <div class="relative bg-white rounded-lg p-2 overflow-hidden">
                                    <span class="qr-corner tl"></span>
                                    <span class="qr-corner tr"></span>
                                    <span class="qr-corner bl"></span>
                                    <span class="qr-corner br"></span>
                                    <div id="qris-svg-container" class="flex items-center justify-center">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(160)->margin(2)->color(28, 24, 20)->generate($order->dynamic_qris) !!}
                                    </div>
                                    <span class="scanline"></span>
                                </div>
                            </div>
                            <p class="font-display italic text-sm text-[color:var(--brown)] mt-3">
                                Pindai dengan e-wallet Anda
                            </p>

                            {{-- Simpan QR --}}
                            <button onclick="downloadQR()" type="button" class="btn-secondary mt-2">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Simpan QRIS
                            </button>
                        </div>

                        {{-- Step TOC + Penting combined --}}
                        <div class="mt-4 md:mt-5">
                            <span class="label-micro">Langkah & Catatan Pembayaran</span>
                            <div class="mt-2 border-t border-b border-[color:var(--line)]">
                                <div class="toc-item">
                                    <span class="toc-num">I.</span>
                                    <span class="toc-text">Buka e-wallet</span>
                                </div>
                                <div class="toc-item">
                                    <span class="toc-num">II.</span>
                                    <span class="toc-text">Pindai QR di atas</span>
                                </div>
                                <div class="toc-item">
                                    <span class="toc-num">III.</span>
                                    <span class="toc-text">Bayar sesuai nominal di e-wallet</span>
                                </div>
                                <div class="toc-item">
                                    <span class="toc-num">IV.</span>
                                    <span class="toc-text">Konfirmasi via WhatsApp</span>
                                </div>
                                <div class="toc-item !border-b-0 !py-3 bg-[color:var(--paper-light)] -mx-px px-3 mt-1">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-[color:var(--brown-soft)]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                        <p class="font-serif text-[11px] text-[color:var(--brown)] leading-snug">
                                            <span class="font-bold uppercase tracking-wide text-[10px] text-[color:var(--brown-soft)]">Penting · </span>
                                            Nominal yang muncul di e-wallet mungkin sedikit berbeda dengan harga di invoice. Bayar <span class="font-display italic font-semibold text-[color:var(--ink)]">tepat sesuai nominal e-wallet</span> agar sistem otomatis verifikasi pembayaran Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Mobile CTA --}}
                <div class="md:hidden p-6 border-t border-dashed border-[color:var(--line)] bg-[color:var(--paper)]">
                    <a href="{{ $waLink }}" target="_blank" class="btn-primary group">
                        <span>Konfirmasi via WhatsApp</span>
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ $waLink }}" target="_blank" class="help-link">
                        Chat admin dulu sebelum bayar
                    </a>
                </div>
            </div>

            {{-- Footer ribbon --}}
            <div class="mt-6 text-center">
                <p class="font-display italic text-xs text-[color:var(--brown-light)] tracking-wide">
                    Halaman 1 dari 1 · © {{ date('Y') }} Temanten Digital Invitation
                </p>
            </div>
        </article>
    </main>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('paymentTimer', (expiredAt) => ({
            hours: '00',
            minutes: '00',
            seconds: '00',
            endTime: new Date(expiredAt).getTime(),
            init() {
                this.updateTimer();
                setInterval(() => this.updateTimer(), 1000);
            },
            updateTimer() {
                const now = new Date().getTime();
                const distance = this.endTime - now;
                if (distance < 0) {
                    this.hours = '00'; this.minutes = '00'; this.seconds = '00';
                    return;
                }
                this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
            }
        }));
    });

    function downloadQR() {
        const svg = document.querySelector('#qris-svg-container svg');
        if(!svg) return;

        if(!svg.getAttribute('xmlns')) {
            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        }

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        const padding = 20;
        const size = 200 + (padding * 2);
        canvas.width = size;
        canvas.height = size;

        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        const svgData = new XMLSerializer().serializeToString(svg);
        const blob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
        const URL = window.URL || window.webkitURL || window;
        const blobURL = URL.createObjectURL(blob);

        const img = new Image();
        img.onload = function() {
            ctx.drawImage(img, padding, padding);
            const pngUrl = canvas.toDataURL('image/png');

            const downloadLink = document.createElement('a');
            downloadLink.href = pngUrl;
            downloadLink.download = 'QRIS_TEMANTEN_{{ $shortId }}.png';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

            URL.revokeObjectURL(blobURL);
        };
        img.src = blobURL;
    }
</script>
</body>
</html>
