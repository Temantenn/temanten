@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
{{-- QR Check-in overlay untuk tamu yang buka invitation via ?to=slug --}}
{{-- Fixed position bottom-right, brand-consistent (brown/gold), collapsible --}}
<style>
    .qr-checkin-fab {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
    }
    .qr-checkin-fab__trigger {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1c1814 0%, #2a201a 100%);
        color: #e8d4a8;
        border: 2px solid #c9a96e;
        box-shadow: 0 8px 24px rgba(28, 24, 20, 0.4), 0 0 0 4px rgba(201, 169, 110, 0.15);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .qr-checkin-fab__trigger:hover { transform: scale(1.08); }
    .qr-checkin-fab__trigger:active { transform: scale(0.95); }
    .qr-checkin-fab__trigger svg { width: 28px; height: 28px; }
    .qr-checkin-fab__panel {
        position: absolute;
        bottom: 72px;
        right: 0;
        width: 280px;
        background: #faf6ef;
        color: #1c1814;
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(201, 169, 110, 0.3);
        overflow: hidden;
        opacity: 0;
        transform: scale(0.9) translateY(10px);
        transform-origin: bottom right;
        pointer-events: none;
        transition: opacity 0.2s, transform 0.2s;
    }
    .qr-checkin-fab.is-open .qr-checkin-fab__panel {
        opacity: 1;
        transform: scale(1) translateY(0);
        pointer-events: auto;
    }
    .qr-checkin-fab__panel-head {
        background: linear-gradient(135deg, #1c1814 0%, #2a201a 100%);
        color: #e8d4a8;
        padding: 14px 16px;
        font-size: 11px;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        font-weight: 600;
        text-align: center;
    }
    .qr-checkin-fab__panel-body {
        padding: 16px;
        text-align: center;
    }
    .qr-checkin-fab__qr {
        background: white;
        padding: 12px;
        border-radius: 12px;
        display: inline-block;
        margin: 0 auto 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    .qr-checkin-fab__qr svg { display: block; }
    .qr-checkin-fab__name {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .qr-checkin-fab__hint {
        font-size: 11px;
        color: #6b7280;
        line-height: 1.4;
    }
    .qr-checkin-fab__status {
        margin-top: 12px;
        padding: 8px 12px;
        background: #dcfce7;
        color: #166534;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    @media (max-width: 480px) {
        .qr-checkin-fab__panel { width: 260px; }
    }
    @media print {
        .qr-checkin-fab { display: none !important; }
    }
</style>

<div class="qr-checkin-fab" id="qrCheckinFab">
    <div class="qr-checkin-fab__panel" role="dialog" aria-label="QR Check-in Anda">
        <div class="qr-checkin-fab__panel-head">
            QR Check-in Anda
        </div>
        <div class="qr-checkin-fab__panel-body">
            <div class="qr-checkin-fab__qr">
                {!! QrCode::size(160)->margin(1)->color(28, 24, 20)->generate($checkinUrl) !!}
            </div>
            <div class="qr-checkin-fab__name">{{ $guest->name }}</div>
            <div class="qr-checkin-fab__hint">
                Tunjukkan QR ini kepada panitia di lokasi acara untuk absensi cepat
            </div>
            @if($guest->checked_in_at)
                <div class="qr-checkin-fab__status">
                    ✓ Sudah check-in pada {{ $guest->checked_in_at->format('H:i') }} WIB
                </div>
            @endif
        </div>
    </div>
    <button type="button" class="qr-checkin-fab__trigger" aria-label="Buka QR Check-in" id="qrCheckinTrigger">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
        </svg>
    </button>
</div>

<script>
    (function() {
        const fab = document.getElementById('qrCheckinFab');
        const trigger = document.getElementById('qrCheckinTrigger');
        if (!fab || !trigger) return;

        function toggle(open) {
            fab.classList.toggle('is-open', open);
        }

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            toggle(!fab.classList.contains('is-open'));
        });

        document.addEventListener('click', function(e) {
            if (!fab.contains(e.target)) {
                toggle(false);
            }
        });

        // Auto-open kalau URL punya hash #checkin
        if (window.location.hash === '#checkin') {
            toggle(true);
        }
    })();
</script>