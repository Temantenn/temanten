<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#1c1814">
    <title>Check-in Tamu · {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Mempelai' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Mempelai' }}</title>

    <style>
        :root {
            --brown: #1c1814;
            --brown-soft: #2a201a;
            --gold: #c9a96e;
            --gold-soft: #e8d4a8;
            --cream: #faf6ef;
            --green: #16a34a;
            --green-soft: #dcfce7;
            --red: #dc2626;
            --red-soft: #fee2e2;
            --gray: #6b7280;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
        html, body { min-height: 100dvh; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, var(--brown) 0%, var(--brown-soft) 100%);
            color: var(--cream);
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        .card {
            background: var(--cream);
            color: var(--brown);
            width: 100%;
            max-width: 480px;
            margin: 16px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4), 0 0 0 1px rgba(201, 169, 110, 0.2);
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .header {
            background: linear-gradient(135deg, var(--brown) 0%, var(--brown-soft) 100%);
            color: var(--gold-soft);
            padding: 24px 24px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle at center, rgba(201, 169, 110, 0.15) 0%, transparent 60%);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }
        .header h1 {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            opacity: 0.7;
            margin-bottom: 6px;
            position: relative;
        }
        .header h2 {
            font-size: 20px;
            font-weight: 700;
            font-family: 'Georgia', serif;
            font-style: italic;
            position: relative;
        }
        .body {
            padding: 28px 24px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .status-pending::before { background: #f59e0b; }
        .status-done {
            background: var(--green-soft);
            color: #166534;
        }
        .status-done::before { background: var(--green); animation: none; opacity: 1; }

        .guest-name {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px;
            font-family: 'Georgia', serif;
        }
        .guest-meta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 24px;
            padding-bottom: 24px;
            border-bottom: 1px dashed #e5d9c0;
        }
        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--gray);
            background: rgba(28, 24, 20, 0.05);
            padding: 6px 12px;
            border-radius: 999px;
        }
        .meta-pill svg { width: 14px; height: 14px; }
        .form-section {
            margin-top: 24px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 18px 24px;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
            letter-spacing: 0.02em;
        }
        .btn:active { transform: scale(0.98); }
        .btn-primary {
            background: linear-gradient(135deg, var(--brown) 0%, var(--brown-soft) 100%);
            color: var(--gold-soft);
            box-shadow: 0 6px 20px rgba(28, 24, 20, 0.3);
        }
        .btn-primary:hover { box-shadow: 0 8px 24px rgba(28, 24, 20, 0.4); }
        .btn-success {
            background: linear-gradient(135deg, var(--green) 0%, #15803d 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(22, 163, 74, 0.3);
        }
        .checkin-time {
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
            color: var(--green);
            font-weight: 600;
        }
        .checkin-time strong { font-size: 16px; display: block; margin-top: 4px; }
        .footer {
            padding: 20px 24px;
            background: rgba(28, 24, 20, 0.03);
            text-align: center;
            font-size: 11px;
            color: var(--gray);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .footer-divider {
            width: 40px;
            height: 1px;
            background: var(--gold);
            margin: 8px auto;
            opacity: 0.5;
        }
        .success-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            background: var(--green-soft);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .success-icon svg { width: 36px; height: 36px; color: var(--green); }
        .toast {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--brown);
            color: var(--gold-soft);
            padding: 12px 24px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 100;
            animation: toastIn 0.3s ease-out;
        }
        @keyframes toastIn {
            from { transform: translate(-50%, -20px); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
    </style>
</head>
<body>

    @if(isset($justCheckedIn) && $justCheckedIn)
        <div class="toast">✓ Check-in berhasil dicatat</div>
    @endif

    <div class="card">
        <div class="header">
            <h1>Check-in Tamu</h1>
            <h2>
                @php
                    $pria = $invitation->content['mempelai']['pria']['panggilan'] ?? 'Mempelai Pria';
                    $wanita = $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Mempelai Wanita';
                @endphp
                {{ $pria }} <span style="opacity:0.6">&</span> {{ $wanita }}
            </h2>
        </div>

        <div class="body">
            @if($alreadyCheckedIn)
                <div class="status-badge status-done">Sudah Check-in</div>

                <div class="success-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            @else
                <div class="status-badge status-pending">Menunggu Konfirmasi</div>
            @endif

            <div class="guest-name">{{ $guest->name }}</div>

            <div class="guest-meta">
                @if($guest->category)
                    <div class="meta-pill">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        {{ $guest->category }}
                    </div>
                @endif
                @if($guest->rsvp_status)
                    <div class="meta-pill">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        RSVP: {{ ucfirst(str_replace('_', ' ', $guest->rsvp_status)) }}
                    </div>
                @endif
            </div>

            @if($alreadyCheckedIn)
                <div class="checkin-time">
                    Check-in pada
                    <strong>{{ $guest->checked_in_at->format('H:i') }} WIB · {{ $guest->checked_in_at->translatedFormat('d F Y') }}</strong>
                </div>
                <div class="form-section">
                    <a href="{{ url()->current() }}" class="btn btn-success">Selesai</a>
                </div>
            @else
                <form method="POST" action="{{ route('checkin.confirm', ['invitation' => $invitation->slug, 'token' => $guest->checkin_token]) }}">
                    @csrf
                    <div class="form-section">
                        <button type="submit" class="btn btn-primary">
                            ✓ Konfirmasi Hadir
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <div class="footer">
            Tementen
            <div class="footer-divider"></div>
            QR Check-in System
        </div>
    </div>

</body>
</html>