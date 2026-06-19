<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak QR Tamu · {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Mempelai' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Mempelai' }}</title>

    @php
        use SimpleSoftwareIO\QrCode\Facades\QrCode;
        $pria = $invitation->content['mempelai']['pria']['panggilan'] ?? 'Mempelai Pria';
        $wanita = $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Mempelai Wanita';
        $fullPria = $invitation->content['mempelai']['pria']['nama'] ?? '';
        $fullWanita = $invitation->content['mempelai']['wanita']['nama'] ?? '';
        $eventDate = '';
        if (isset($invitation->content['acara']['resepsi']['waktu'])) {
            try {
                $eventDate = \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'])->translatedFormat('d F Y');
            } catch (\Throwable $e) {}
        }
    @endphp

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: #f5f1ea;
            color: #1c1814;
            padding: 24px;
            min-height: 100vh;
        }

        /* Screen-only controls */
        .toolbar {
            max-width: 1200px;
            margin: 0 auto 24px;
            background: white;
            border-radius: 16px;
            padding: 20px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .toolbar-info {
            flex: 1;
            min-width: 240px;
        }
        .toolbar-info h1 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .toolbar-info p {
            font-size: 13px;
            color: #6b7280;
        }
        .toolbar-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }
        .btn-primary {
            background: #1c1814;
            color: #e8d4a8;
        }
        .btn-primary:hover { background: #2a201a; }
        .btn-secondary {
            background: #f3f4f6;
            color: #1c1814;
            border: 1px solid #e5e7eb;
        }
        .btn-secondary:hover { background: #e5e7eb; }

        /* QR card grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 4px 12px rgba(0,0,0,0.04);
            break-inside: avoid;
            page-break-inside: avoid;
            border: 1px solid #f0e6d2;
        }
        .card-header {
            border-bottom: 1px solid #f0e6d2;
            padding-bottom: 12px;
            margin-bottom: 14px;
        }
        .card-couple {
            font-family: 'Georgia', serif;
            font-style: italic;
            font-size: 14px;
            color: #1c1814;
            margin-bottom: 2px;
        }
        .card-event {
            font-size: 11px;
            color: #6b7280;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .card-qr {
            display: inline-block;
            background: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 12px;
        }
        .card-qr svg { display: block; }
        .card-name {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 4px;
        }
        .card-category {
            display: inline-block;
            background: #faf6ef;
            color: #6b7280;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 500;
        }
        .card-status {
            margin-top: 10px;
            padding: 4px 10px;
            background: #dcfce7;
            color: #166534;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        /* Print styles */
        @media print {
            body { background: white; padding: 0; }
            .toolbar { display: none !important; }
            .grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0;
                max-width: 100%;
            }
            .card {
                box-shadow: none;
                border: 1px dashed #d1d5db;
                border-radius: 0;
                margin: 0;
                padding: 14px 10px;
            }
            @page {
                size: A4;
                margin: 12mm;
            }
        }
        @media (max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
            .toolbar { flex-direction: column; align-items: stretch; }
        }
    </style>
</head>
<body>

    <div class="toolbar">
        <div class="toolbar-info">
            <h1>Cetak QR Tamu — {{ $pria }} & {{ $wanita }}</h1>
            <p>{{ $guests->count() }} kartu siap cetak. Klik "Cetak" lalu gunakan Ctrl+P / Cmd+P.</p>
        </div>
        <div class="toolbar-actions">
            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">← Kembali</a>
            <button onclick="window.print()" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
        </div>
    </div>

    <div class="grid">
        @forelse($guests as $guest)
            <div class="card">
                <div class="card-header">
                    <div class="card-couple">{{ $pria }} <span style="opacity:0.5">&</span> {{ $wanita }}</div>
                    @if($eventDate)<div class="card-event">{{ $eventDate }}</div>@endif
                </div>

                <div class="card-qr">
                    {!! QrCode::size(140)->margin(0)->color(28, 24, 20)->generate($guest->checkin_url) !!}
                </div>

                <div class="card-name">{{ $guest->name }}</div>
                @if($guest->category)
                    <div class="card-category">{{ $guest->category }}</div>
                @endif

                @if($guest->checked_in_at)
                    <div class="card-status">✓ CHECK-IN {{ $guest->checked_in_at->format('H:i') }} WIB</div>
                @endif
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #6b7280;">
                Belum ada tamu. Tambahkan tamu di dashboard terlebih dahulu.
            </div>
        @endforelse
    </div>

</body>
</html>