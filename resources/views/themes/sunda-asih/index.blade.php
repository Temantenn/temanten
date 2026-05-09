<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sunda Asih — {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Dian' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Sari' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{
    --hijau:#4A6B46;--hijau2:#3A5437;--sage:#809671;--sage-l:#B5C5AA;--sage-xl:#E1E9DD;
    --bambu:#C9B793;--krem:#FDFBF7;--krem2:#F6F4EB;--emas:#B89352;--emas-l:#D6BC87;--emas-xl:#F3EAD3;
    --kayu:#4A3C31;--border:rgba(184,147,82,0.2);
}
*{box-sizing:border-box;margin:0;padding:0}

/* ── WHOLE PAGE IS A SCROLL ─────────────────────────── */
html{scroll-behavior:smooth}
/* Handmade paper texture pattern */
body{width:100%;overflow-x:hidden;background-color:var(--krem);
    background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
    font-family:'Plus Jakarta Sans',sans-serif;color:var(--kayu)}
.app-scroll{max-width:480px;margin:0 auto;position:relative;background-color:var(--krem);
    background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
    box-shadow: 0 0 40px rgba(0,0,0,0.05);
}

/* ── COVER GATE ─────────────────────────────────────── */
.gate{position:fixed;inset:0;z-index:999;display:flex;align-items:stretch;max-width:480px;margin:0 auto;left:0;right:0;background:var(--krem);
    background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
    transition: opacity 0.8s ease;
}
.gate.fade-out{opacity:0;pointer-events:none;}

.tirai{position:absolute;top:0;bottom:0;width:50%;transition:transform 1.3s cubic-bezier(0.77,0,0.18,1);overflow:hidden;background-color:var(--krem2);}
.tirai-left{left:0;transform-origin:left;border-right:1px solid var(--border)}
.tirai-right{right:0;transform-origin:right;border-left:1px solid var(--border)}

/* Pressed leaf corner decorations */
.leaf-corner {
    position:absolute; width:180px; height:180px; background-size:contain; background-repeat:no-repeat; pointer-events:none; opacity:0.8; mix-blend-mode:multiply;
    background-image:url('https://images.unsplash.com/photo-1541961017774-22349e4a1262?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80');
}
.leaf-tl { top:-30px; left:-30px; transform:rotate(-15deg); }
.leaf-br { bottom:-30px; right:-30px; transform:rotate(165deg); }

.gate.open .tirai-left{transform:translateX(-100%)}
.gate.open .tirai-right{transform:translateX(100%)}
.gate-content{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:2;padding:0 28px;text-align:center}
.gate-content.fade-out{opacity:0;transition:opacity 0.3s}
.cloud-tl { position:absolute; top:-20px; left:-30px; width:160px; transform:rotate(15deg); opacity:0.9; color:var(--emas); filter:drop-shadow(2px 4px 6px rgba(0,0,0,0.05)); z-index:1; }
.cloud-tr { position:absolute; top:30px; right:-20px; width:120px; transform:rotate(-15deg) scaleX(-1); opacity:0.85; color:var(--sage); filter:drop-shadow(2px 4px 6px rgba(0,0,0,0.05)); z-index:1; }
.cloud-bl { position:absolute; bottom:70px; left:-30px; width:140px; transform:rotate(10deg); opacity:0.8; color:var(--emas-l); filter:drop-shadow(2px 4px 6px rgba(0,0,0,0.05)); z-index:1; }
.cloud-br { position:absolute; bottom:-10px; right:-10px; width:180px; transform:rotate(-10deg) scaleX(-1); opacity:0.95; color:var(--emas); filter:drop-shadow(2px 4px 6px rgba(0,0,0,0.05)); z-index:1; }

.gate-leaves { position:absolute; top:48%; left:50%; transform:translate(-50%, -50%); width:460px; height:460px; z-index:1; pointer-events:none; }
.gate-frame-container { position:relative; z-index:5; width:280px; min-height:260px; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:30px 20px; text-align:center; margin-top:10px; }

.gate-eyebrow{font-size:12px;letter-spacing:4px;color:var(--emas);margin-bottom:8px;font-weight:600;text-transform:uppercase}
.gate-names{font-family:'Cormorant Garamond',serif;font-size:3.1rem;font-weight:600;font-style:italic;color:var(--kayu);line-height:0.9;margin:5px 0 10px;text-shadow: 1px 1px 0 rgba(255,255,255,0.5)}
.gate-amp{color:var(--emas);font-style:normal;font-weight:400;font-size:2.2rem;display:inline-block;margin:6px 0;}
.gate-subtitle{font-size:11px;letter-spacing:3px;color:var(--kayu);margin-bottom:0;font-weight:600;text-transform:uppercase}
.gate-guest-box{background:white;border:1px solid var(--border);border-radius:2px 14px 2px 14px;padding:12px 28px;margin-bottom:24px;display:inline-block;box-shadow:0 8px 24px rgba(184,147,82,0.1);position:relative;z-index:10;}
.gate-guest-lbl{font-size:8px;letter-spacing:3px;color:var(--sage);text-transform:uppercase;font-weight:700}
.gate-guest-nm{font-family:'Cormorant Garamond',serif;font-weight:600;font-style:italic;font-size:1.4rem;color:var(--kayu);margin-top:2px}
.btn-buka{position:relative;z-index:50;pointer-events:auto;background:var(--emas);color:var(--krem);border:none;padding:14px 40px;font-weight:600;font-size:11px;letter-spacing:3px;text-transform:uppercase;cursor:pointer;transition:0.4s;border-radius:50px;box-shadow:0 10px 20px rgba(184,147,82,0.25)}
.btn-buka:hover{box-shadow:0 12px 25px rgba(184,147,82,0.4);transform:translateY(-2px);background:var(--kayu)}

/* ── MEGA MENDUNG BG ───────────────────────────────── */
.mendung{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='80'%3E%3Cellipse cx='60' cy='80' rx='50' ry='40' fill='none' stroke='%23B89352' stroke-width='0.8' opacity='0.15'/%3E%3Cellipse cx='60' cy='80' rx='38' ry='30' fill='none' stroke='%23B89352' stroke-width='0.7' opacity='0.1'/%3E%3Cellipse cx='60' cy='80' rx='26' ry='20' fill='none' stroke='%23B89352' stroke-width='0.6' opacity='0.08'/%3E%3C/svg%3E");background-size:120px 80px;}

/* ── SCROLL SPY DOTS ──────────────────────────────── */
.scroll-spy{position:fixed;right:12px;top:50%;transform:translateY(-50%);z-index:200;display:flex;flex-direction:column;gap:8px;opacity:0;transition:opacity 0.5s;pointer-events:none}
.scroll-spy.show{opacity:1;pointer-events:all}
.spy-dot{width:8px;height:8px;border-radius:50%;background:rgba(122,158,126,0.3);border:1px solid var(--sage);cursor:pointer;transition:0.3s;display:block;position:relative}
.spy-dot::before{content:attr(data-label);position:absolute;right:16px;top:50%;transform:translateY(-50%);background:var(--hijau);color:var(--emas-l);font-size:9px;letter-spacing:1.5px;padding:3px 8px;border-radius:4px;white-space:nowrap;opacity:0;transition:opacity 0.2s;pointer-events:none;font-family:'Plus Jakarta Sans',sans-serif}
.spy-dot:hover::before{opacity:1}
.spy-dot.active{background:var(--emas);border-color:var(--emas);transform:scale(1.4)}

/* ── MUSIC FAB ─────────────────────────────────────── */
.music-fab{position:fixed;bottom:24px;right:14px;width:40px;height:40px;background:var(--sage);border-radius:50%;display:flex;align-items:center;justify-content:center;z-index:500;cursor:pointer;box-shadow:0 3px 14px rgba(45,90,39,0.45);opacity:0;pointer-events:none;transition:opacity 0.5s;font-size:16px;color:white}
.music-fab.show{opacity:1;pointer-events:all}
@keyframes spin-slow{to{transform:rotate(360deg)}}
.playing{animation:spin-slow 8s linear infinite}

/* ── SECTION LEAF DIVIDER ─────────────────────────── */
.leaf-divider{text-align:center;padding:6px 0;overflow:hidden;line-height:0}
.leaf-divider svg{display:block;margin:0 auto;width:100%;max-width:480px}

/* ── COMMON SECTION STYLE ─────────────────────────── */
.sa-section{position:relative;padding:0}
.sec-inner{padding:36px 18px 28px}
.sec-eyebrow{font-size:8px;letter-spacing:5px;text-transform:uppercase;color:var(--sage);font-weight:600;text-align:center;margin-bottom:6px}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:2rem;font-style:italic;color:var(--hijau);text-align:center;margin-bottom:4px}
.green-line{height:1px;background:linear-gradient(to right,transparent,var(--sage),transparent);width:60px;margin:8px auto 20px}

/* ── HERO / HOME ─────────────────────────────────── */
.hero{height:60vh;background-size:cover;background-position:center;position:relative}
.hero::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(45,90,39,0.25) 0%,var(--krem) 100%)}
.home-card{background:var(--krem2);border:1px solid var(--border);padding:22px 18px 18px;margin:-30px 14px 0;position:relative;z-index:5;text-align:center;border-radius:2px 16px 2px 16px;box-shadow:0 8px 32px rgba(45,90,39,0.1)}
.home-names{font-family:'Cormorant Garamond',serif;font-size:2rem;font-style:italic;color:var(--hijau);line-height:1.2;margin-bottom:12px}
.home-amp{color:var(--emas)}
.cd-row{display:flex;justify-content:center;gap:6px;margin:12px 0 4px}
.cd-box{background:var(--hijau);border-radius:8px 2px 8px 2px;padding:8px 12px;min-width:52px;text-align:center}
.cd-num{display:block;font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:var(--emas-xl);line-height:1;font-weight:300}
.cd-lbl{font-size:7px;letter-spacing:2px;color:var(--sage-l);text-transform:uppercase;margin-top:2px;display:block}
.quote-block{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1rem;color:var(--kayu);text-align:center;padding:22px 22px 10px;line-height:1.9;opacity:0.85}
.philo{background:var(--hijau);margin:0 14px;padding:14px 16px;border-radius:2px 14px 2px 14px;text-align:center}
.philo p{font-size:8px;letter-spacing:2px;color:var(--sage-l);text-transform:uppercase;line-height:2}
.philo strong{display:block;font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1rem;color:var(--emas-l);font-weight:300;letter-spacing:0;text-transform:none}

/* ── MEMPELAI — zigzag portrait cards ────────────── */
.mempelai-cards{display:flex;flex-direction:column;gap:0}
.mp-card{display:flex;gap:14px;padding:20px 18px;align-items:center}
.mp-card:first-child{background:var(--krem2)}
.mp-card:last-child{background:var(--hijau);flex-direction:row-reverse}
.mp-photo{width:90px;height:120px;object-fit:cover;object-position:center top;border-radius:50% 50% 50% 50% / 60% 60% 40% 40%;border:3px solid var(--emas);box-shadow:0 6px 20px rgba(45,90,39,0.3);flex-shrink:0}
.mp-card:last-child .mp-photo{border-color:var(--sage-l)}
.mp-info{flex:1}
.mp-role{font-size:7.5px;letter-spacing:3px;text-transform:uppercase;font-weight:600;margin-bottom:4px}
.mp-card:first-child .mp-role{color:var(--sage)}
.mp-card:last-child .mp-role{color:var(--sage-l)}
.mp-name{font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-style:italic;line-height:1.3;margin-bottom:6px}
.mp-card:first-child .mp-name{color:var(--hijau)}
.mp-card:last-child .mp-name{color:var(--krem)}
.mp-parents{font-size:10px;line-height:1.9}
.mp-card:first-child .mp-parents{color:var(--kayu)}
.mp-card:last-child .mp-parents{color:rgba(212,234,212,0.75)}
.mp-ig{font-size:10px;margin-top:6px;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
.mp-card:first-child .mp-ig{color:var(--sage)}
.mp-card:last-child .mp-ig{color:var(--sage-l)}

/* ── KISAH — ZIGZAG ──────────────────────────────── */
.zz-track{padding:6px 14px 20px;position:relative}
.zz-track::before{content:'';position:absolute;left:50%;top:0;bottom:0;width:1px;background:linear-gradient(to bottom,var(--emas),var(--sage));transform:translateX(-50%);opacity:0.3}
.zz-item{display:flex;align-items:flex-start;margin-bottom:18px;position:relative}
.zz-item:nth-child(odd){flex-direction:row}
.zz-item:nth-child(even){flex-direction:row-reverse}
.zz-card{flex:0 0 calc(50% - 26px);background:var(--krem2);border:1px solid var(--border);padding:14px 12px;border-radius:2px 14px 2px 14px}
.zz-item:nth-child(even) .zz-card{background:var(--hijau)}
.zz-dot-wrap{flex:0 0 52px;display:flex;justify-content:center;padding-top:14px}
.zz-dot{width:12px;height:12px;background:var(--emas);border-radius:50%;box-shadow:0 0 10px rgba(196,151,60,0.7);border:2px solid var(--krem)}
.spacer{flex:0 0 calc(50% - 26px)}
.zz-year{font-size:8px;letter-spacing:3px;font-weight:600;color:var(--sage);margin-bottom:4px}
.zz-item:nth-child(even) .zz-year{color:var(--emas-l)}
.zz-title{font-family:'Cormorant Garamond',serif;font-size:1.05rem;font-style:italic;color:var(--hijau);margin-bottom:4px}
.zz-item:nth-child(even) .zz-title{color:var(--krem)}
.zz-text{font-size:10.5px;color:var(--kayu);line-height:1.75}
.zz-item:nth-child(even) .zz-text{color:var(--sage-xl)}

/* ── ACARA — DUAL COLUMN PANELS ──────────────────── */
.dual-cols{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border)}
.ev-col{padding:20px 14px;background:var(--krem2)}
.ev-col:last-child{background:var(--hijau)}
.ev-num{font-family:'Cormorant Garamond',serif;font-size:2.8rem;color:rgba(196,151,60,0.15);line-height:1;margin-bottom:2px;font-weight:300}
.ev-badge{font-size:7.5px;letter-spacing:3px;text-transform:uppercase;font-weight:700;display:block;margin-bottom:8px}
.ev-col:first-child .ev-badge{color:var(--sage)}
.ev-col:last-child .ev-badge{color:var(--emas-l)}
.ev-title{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.05rem;color:var(--hijau);margin-bottom:10px}
.ev-col:last-child .ev-title{color:var(--krem)}
.ev-row{display:flex;gap:6px;align-items:flex-start;margin-bottom:8px;font-size:10px;line-height:1.55}
.ev-col:first-child .ev-row{color:var(--kayu)}
.ev-col:last-child .ev-row{color:var(--sage-l)}
.ev-icon{font-size:12px;flex-shrink:0;margin-top:1px}
.btn-map{display:inline-flex;align-items:center;gap:4px;margin-top:8px;background:rgba(168,197,160,0.2);border:1px solid var(--border);color:var(--sage);padding:5px 12px;font-size:9px;letter-spacing:1.5px;text-decoration:none;border-radius:0 8px 0 8px;font-weight:600}
.ev-col:last-child .btn-map{background:rgba(255,255,255,0.07);border-color:rgba(222,185,108,0.3);color:var(--emas-l)}

/* ── GALERI — featured + thumb strip ─────────────── */
.g-feat{position:relative;overflow:hidden;background:var(--krem2);display:flex;align-items:center;justify-content:center;min-height:260px}
.g-feat::before{content:'';position:absolute;inset:12px;border:1px solid rgba(196,151,60,0.5);z-index:2;pointer-events:none}
.g-feat-img{width:100%;max-height:70vh;height:auto;object-fit:contain;display:block;filter:saturate(0.95)}
.g-strip{display:flex;gap:3px;overflow-x:auto;padding:3px 0;background:var(--krem)}
.g-strip::-webkit-scrollbar{height:2px}
.g-strip::-webkit-scrollbar-thumb{background:var(--sage)}
.g-thumb{flex:0 0 90px;height:110px;object-fit:cover;display:block;filter:saturate(0.75) brightness(0.9);cursor:pointer;transition:filter 0.3s;background:var(--krem2)}
.g-thumb:hover,.g-thumb.active{filter:saturate(1.1) brightness(1)}

/* ── GIFT + RSVP ─────────────────────────────────── */
.gift-card{background:linear-gradient(135deg,var(--hijau),var(--hijau2));border:1px solid rgba(222,185,108,0.3);margin:0 14px 14px;padding:20px;border-radius:2px 14px 2px 14px;position:relative;overflow:hidden}
.gift-card::after{content:'🍃';position:absolute;right:14px;top:12px;font-size:28px;opacity:0.12}
.gift-bank{font-size:9px;letter-spacing:3px;color:var(--emas-l);font-weight:600;margin-bottom:4px}
.gift-num{font-size:1.45rem;font-weight:700;letter-spacing:3px;color:var(--krem);margin-bottom:2px}
.gift-holder{font-size:10px;color:rgba(212,234,212,0.7)}
.btn-copy{display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:rgba(168,197,160,0.15);border:1px solid rgba(222,185,108,0.35);color:var(--emas-l);padding:6px 16px;font-size:10px;letter-spacing:2px;cursor:pointer;border-radius:50px 4px 50px 4px;transition:0.3s;font-weight:600}
.form-input{width:100%;background:rgba(212,234,212,0.12);border:1px solid var(--border);padding:10px 14px;color:var(--kayu);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;margin-bottom:10px;outline:none;transition:0.3s;border-radius:8px 2px 8px 2px}
.form-input:focus{border-color:var(--sage)}
.btn-kirim{width:100%;background:linear-gradient(135deg,var(--hijau),var(--hijau2));color:var(--emas-l);border:none;padding:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:10px;letter-spacing:3px;text-transform:uppercase;cursor:pointer;transition:0.3s;border-radius:2px 12px 2px 12px}
.btn-kirim:hover{box-shadow:0 4px 18px rgba(45,90,39,0.35)}
.wish-card{background:var(--krem2);border:1px solid var(--border);padding:12px 14px;margin-bottom:8px;border-radius:2px 10px 2px 10px;border-left:3px solid var(--sage)}
.wish-hdr{display:flex;align-items:center;gap:8px;margin-bottom:4px}
.wish-av{width:28px;height:28px;background:var(--hijau);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;color:var(--emas-xl);font-weight:600;flex-shrink:0}
.wish-nm{font-size:12px;font-weight:600;color:var(--hijau)}
.wish-tm{font-size:9px;color:var(--sage);margin-left:auto}
.wish-txt{font-size:11px;color:var(--kayu);font-style:italic;line-height:1.7}

/* ── TOAST ───────────────────────────────────────── */
.toast{position:fixed;bottom:76px;left:50%;transform:translateX(-50%) translateY(14px);background:var(--hijau);color:var(--emas-l);padding:8px 22px;font-size:10px;letter-spacing:2px;z-index:9999;opacity:0;transition:0.3s;white-space:nowrap;border-radius:50px;font-weight:600}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

/* ── FIREFLIES ───────────────────────────────────── */
.ff-layer{position:fixed;inset:0;pointer-events:none;z-index:0;overflow:hidden}
@keyframes ff{0%{opacity:0;transform:translate(0,0)}30%{opacity:0.8}70%{opacity:0.3}100%{opacity:0;transform:translate(var(--dx),var(--dy))}}
.ff{position:absolute;width:3px;height:3px;background:#a8e890;border-radius:50%;box-shadow:0 0 6px 2px rgba(168,232,144,0.6);animation:ff 6s infinite}
@keyframes fadeInPage{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.app-scroll{opacity:0}
.app-scroll.animate-in{animation:fadeInPage 0.9s cubic-bezier(0.22,0.61,0.36,1) forwards}

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
function saImg2($p,$fb='https://images.unsplash.com/photo-1519741497674-611481863552?w=800&fit=crop'){
    if(!$p||str_contains($p,'placeholder'))return $fb;
    return \Illuminate\Support\Str::startsWith($p,'http')?$p:asset($p);
}
$pria   =$invitation->content['mempelai']['pria']  ??[];
$wanita =$invitation->content['mempelai']['wanita']??[];
$akad   =$invitation->content['acara']['akad']     ??[];
$resepsi=$invitation->content['acara']['resepsi']  ??[];
$amplop =$invitation->content['amplop']            ??[];
$gallery=$invitation->content['media']['gallery']  ??[
    'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&fit=crop',
    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=400&fit=crop',
    'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&fit=crop',
    'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&fit=crop',
];
$stories=$invitation->content['love_stories']??[
    ['year'=>'Tepung','title'=>'Pepanggihan','story'=>'Dina hiji poé nu cerah, kami tepung dina hiji acara budaya nu pinuh ku kabungahan.'],
    ['year'=>'Asih','title'=>'Haté Nyambung','story'=>'Ti kanca jadi babaturan, terus asih nu tulus jeung jero ngagembleng haté urang duaan.'],
    ['year'=>'Lamar','title'=>'Ngajak Babarengan','story'=>'Di handapeun langit pasundan nu héjo, anjeunna ngajak kuring hirup babarengan satuluyna.'],
];
$target=\Carbon\Carbon::parse($akad['waktu']??now()->addDays(90));
@endphp

{{-- Fireflies --}}
<div class="ff-layer" id="ffLayer"></div>

{{-- Music --}}
<audio id="bgAudio" loop>
    <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/sunda-asih.mp3') }}" type="audio/mpeg">
</audio>
<div class="music-fab" id="musicFab" onclick="toggleMusic()">♪</div>

{{-- Scroll spy dots --}}
<div class="scroll-spy" id="scrollSpy">
    <span class="spy-dot" data-target="s-home" data-label="Imah" onclick="scrollTo2('s-home')"></span>
    <span class="spy-dot" data-target="s-mempelai" data-label="Mempelai" onclick="scrollTo2('s-mempelai')"></span>
    <span class="spy-dot" data-target="s-kisah" data-label="Lakon" onclick="scrollTo2('s-kisah')"></span>
    <span class="spy-dot" data-target="s-acara" data-label="Acara" onclick="scrollTo2('s-acara')"></span>
    <span class="spy-dot" data-target="s-galeri" data-label="Galeri" onclick="scrollTo2('s-galeri')"></span>
    <span class="spy-dot" data-target="s-ucapan" data-label="Sungkem" onclick="scrollTo2('s-ucapan')"></span>
</div>

{{-- ═══ GATE (fixed overlay) ═══ --}}
<div class="gate" id="gate">
    <div class="tirai tirai-left"><div class="leaf-corner leaf-tl"></div></div>
    <div class="tirai tirai-right"><div class="leaf-corner leaf-br"></div></div>
    <div class="gate-content" id="gateContent">

        <!-- Background Mega Mendung Clouds -->
        <!-- Top Left -->
        <svg class="cloud-tl" viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <path d="M50,15 C30,15 15,30 20,45 C10,40 5,50 15,55 C25,60 40,50 50,55 C60,50 75,60 85,55 C95,50 90,40 80,45 C85,30 70,15 50,15 Z" fill="currentColor" opacity="0.9"/>
            <path d="M50,22 C35,22 25,32 28,42 C20,38 18,45 25,48 C32,51 42,44 50,48 C58,44 68,51 75,48 C82,45 80,38 72,42 C75,32 65,22 50,22 Z" fill="var(--krem)"/>
            <path d="M50,28 C40,28 32,35 34,40 C28,38 27,42 32,44 C38,46 44,40 50,44 C56,40 62,46 68,44 C73,42 72,38 66,40 C68,35 60,28 50,28 Z" fill="currentColor" opacity="0.7"/>
        </svg>

        <!-- Top Right -->
        <svg class="cloud-tr" viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <path d="M50,15 C30,15 15,30 20,45 C10,40 5,50 15,55 C25,60 40,50 50,55 C60,50 75,60 85,55 C95,50 90,40 80,45 C85,30 70,15 50,15 Z" fill="currentColor" opacity="0.85"/>
            <path d="M50,22 C35,22 25,32 28,42 C20,38 18,45 25,48 C32,51 42,44 50,48 C58,44 68,51 75,48 C82,45 80,38 72,42 C75,32 65,22 50,22 Z" fill="var(--krem)"/>
            <path d="M50,28 C40,28 32,35 34,40 C28,38 27,42 32,44 C38,46 44,40 50,44 C56,40 62,46 68,44 C73,42 72,38 66,40 C68,35 60,28 50,28 Z" fill="currentColor" opacity="0.6"/>
        </svg>

        <!-- Bottom Left -->
        <svg class="cloud-bl" viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <path d="M50,15 C30,15 15,30 20,45 C10,40 5,50 15,55 C25,60 40,50 50,55 C60,50 75,60 85,55 C95,50 90,40 80,45 C85,30 70,15 50,15 Z" fill="currentColor" opacity="0.8"/>
            <path d="M50,22 C35,22 25,32 28,42 C20,38 18,45 25,48 C32,51 42,44 50,48 C58,44 68,51 75,48 C82,45 80,38 72,42 C75,32 65,22 50,22 Z" fill="var(--krem)"/>
            <path d="M50,28 C40,28 32,35 34,40 C28,38 27,42 32,44 C38,46 44,40 50,44 C56,40 62,46 68,44 C73,42 72,38 66,40 C68,35 60,28 50,28 Z" fill="currentColor" opacity="0.75"/>
        </svg>

        <!-- Bottom Right -->
        <svg class="cloud-br" viewBox="0 0 100 60" xmlns="http://www.w3.org/2000/svg">
            <path d="M50,15 C30,15 15,30 20,45 C10,40 5,50 15,55 C25,60 40,50 50,55 C60,50 75,60 85,55 C95,50 90,40 80,45 C85,30 70,15 50,15 Z" fill="currentColor" opacity="0.9"/>
            <path d="M50,22 C35,22 25,32 28,42 C20,38 18,45 25,48 C32,51 42,44 50,48 C58,44 68,51 75,48 C82,45 80,38 72,42 C75,32 65,22 50,22 Z" fill="var(--krem)"/>
            <path d="M50,28 C40,28 32,35 34,40 C28,38 27,42 32,44 C38,46 44,40 50,44 C56,40 62,46 68,44 C73,42 72,38 66,40 C68,35 60,28 50,28 Z" fill="currentColor" opacity="0.7"/>
        </svg>

        <!-- Center Leaves Radiating -->
        <svg class="gate-leaves" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- upward pointing branch -->
                <g id="fern" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M0,0 Q10,-50 0,-110" fill="none" stroke="var(--sage)" stroke-width="2"/>
                    <path d="M2,-20 Q20,-30 25,-20 Q15,-10 2,-20" fill="var(--sage)"/>
                    <path d="M-2,-25 Q-20,-35 -25,-25 Q-15,-15 -2,-25" fill="var(--sage-l)"/>
                    
                    <path d="M3,-45 Q25,-55 30,-45 Q20,-35 3,-45" fill="var(--sage-l)"/>
                    <path d="M-3,-50 Q-25,-60 -30,-50 Q-20,-40 -3,-50" fill="var(--sage)"/>
                    
                    <path d="M2,-70 Q20,-80 25,-70 Q15,-60 2,-70" fill="var(--sage)"/>
                    <path d="M-2,-75 Q-20,-85 -25,-75 Q-15,-65 -2,-75" fill="var(--sage-l)"/>
                    
                    <path d="M1,-90 Q15,-100 20,-90 Q10,-80 1,-90" fill="var(--sage-l)"/>
                    <path d="M-1,-95 Q-15,-105 -20,-95 Q-10,-85 -1,-95" fill="var(--sage)"/>
                </g>
                <g id="round-leaf">
                    <path d="M0,0 Q-10,-40 0,-90" fill="none" stroke="var(--hijau)" stroke-width="1.5"/>
                    <circle cx="-5" cy="-25" r="5" fill="var(--hijau)"/>
                    <circle cx="8" cy="-45" r="6" fill="var(--hijau)"/>
                    <circle cx="-6" cy="-65" r="5" fill="var(--hijau)"/>
                    <circle cx="4" cy="-85" r="4" fill="var(--hijau)"/>
                </g>
            </defs>
            <g transform="translate(200, 200)">
                <use href="#fern" transform="rotate(30) translate(0, -60) scale(1.5)" opacity="0.8" />
                <use href="#round-leaf" transform="rotate(75) translate(0, -50) scale(1.4)" opacity="0.7" />
                <use href="#fern" transform="rotate(120) translate(0, -70) scale(1.3)" opacity="0.9" />
                <use href="#round-leaf" transform="rotate(165) translate(0, -60) scale(1.5)" opacity="0.6" />
                <use href="#fern" transform="rotate(210) translate(0, -60) scale(1.6)" opacity="0.8" />
                <use href="#round-leaf" transform="rotate(255) translate(0, -50) scale(1.4)" opacity="0.7" />
                <use href="#fern" transform="rotate(300) translate(0, -70) scale(1.4)" opacity="0.9" />
                <use href="#round-leaf" transform="rotate(345) translate(0, -60) scale(1.5)" opacity="0.6" />
            </g>
        </svg>

        <div class="gate-frame-container">
            <!-- Scalloped/Lobed Frame -->
            <svg style="position:absolute; inset:0; width:100%; height:100%; z-index:-1; filter: drop-shadow(0 15px 30px rgba(74,60,49,0.15));" viewBox="0 0 280 260" preserveAspectRatio="none">
                <!-- Solid Fill -->
                <path d="M 40 10 Q 50 10 50 0 L 230 0 Q 230 10 240 10 L 270 10 L 270 40 Q 270 50 280 50 L 280 210 Q 270 210 270 220 L 270 250 L 240 250 Q 230 250 230 260 L 50 260 Q 50 250 40 250 L 10 250 L 10 220 Q 10 210 0 210 L 0 50 Q 10 50 10 40 L 10 10 Z" fill="var(--krem)"/>
                <!-- Outer Gold Border -->
                <path d="M 40 10 Q 50 10 50 0 L 230 0 Q 230 10 240 10 L 270 10 L 270 40 Q 270 50 280 50 L 280 210 Q 270 210 270 220 L 270 250 L 240 250 Q 230 250 230 260 L 50 260 Q 50 250 40 250 L 10 250 L 10 220 Q 10 210 0 210 L 0 50 Q 10 50 10 40 L 10 10 Z" fill="none" stroke="var(--emas)" stroke-width="2"/>
                <!-- Inner Gold Line -->
                <path d="M 43 14 Q 53 14 53 4 L 227 4 Q 227 14 237 14 L 266 14 L 266 43 Q 266 53 276 53 L 276 207 Q 266 207 266 217 L 266 246 L 237 246 Q 227 246 227 256 L 53 256 Q 53 246 43 246 L 14 246 L 14 217 Q 14 207 4 207 L 4 53 Q 14 53 14 43 L 14 14 Z" fill="none" stroke="var(--emas)" stroke-width="0.5"/>
            </svg>
            
            <p class="gate-eyebrow">Pangulem Nikah</p>
            <h1 class="gate-names">{{ $pria['panggilan'] ?? 'Dian' }} <br><span class="gate-amp">&amp;</span><br> {{ $wanita['panggilan'] ?? 'Sari' }}</h1>
            <p class="gate-subtitle">{{ \Carbon\Carbon::parse($target)->translatedFormat('d - m - Y') }}</p>
        </div>
        
        <div style="height:35px;"></div>
        
        @if(isset($guest))
        <div class="gate-guest-box">
            <div class="gate-guest-lbl">Kanggo Yth.</div>
            <div class="gate-guest-nm">{{ $guest->name }}</div>
        </div>
        @else
        <div style="height:20px;"></div>
        @endif
        
        <!-- Button is outside bounding boxes and pointer-events:none makes the SVGs ignore clicks -->
        <button class="btn-buka" onclick="openSurat()">Buka Undangan</button>
    </div>
</div>

{{-- ═══ CONTINUOUS SCROLL CONTENT ═══ --}}
<div class="app-scroll" id="appScroll" style="display:none">

    {{-- HOME --}}
    <section class="sa-section mendung" id="s-home">
        <div class="hero" style="background-image:url('{{ saImg2($invitation->content['media']['cover'] ?? '') }}')"></div>
        <div class="home-card">
            <p class="sec-eyebrow">✦ Wilujeng Sumping ✦</p>
            <h2 class="home-names">{{ $pria['panggilan'] ?? 'Dian' }} <span class="home-amp">&amp;</span> {{ $wanita['panggilan'] ?? 'Sari' }}</h2>
            <p style="font-size:14px;color:var(--sage);margin-bottom:6px">🍃 &nbsp; 🌸 &nbsp; 🍃</p>
            <div class="cd-row">
                <div class="cd-box"><span class="cd-num" id="cdD">--</span><span class="cd-lbl">Poé</span></div>
                <div class="cd-box"><span class="cd-num" id="cdH">--</span><span class="cd-lbl">Jam</span></div>
                <div class="cd-box"><span class="cd-num" id="cdM">--</span><span class="cd-lbl">Menit</span></div>
                <div class="cd-box"><span class="cd-num" id="cdS">--</span><span class="cd-lbl">Detik</span></div>
            </div>
        </div>
        <p class="quote-block">"{{ $invitation->content['quote'] ?? 'Silih asah, silih asih, silih asuh — dina asih anu tulus urang sasarengan nanjeurkeun kahirupan anu éndah.' }}"</p>
        <div class="philo"><p>Filosofi Sunda<br><strong>Silih Asah · Silih Asih · Silih Asuh</strong></p></div>
        <div style="height:14px"></div>
    </section>

    {{-- WAVE DIVIDER --}}
    <div class="leaf-divider">
        <svg viewBox="0 0 480 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,20 Q60,0 120,20 Q180,40 240,20 Q300,0 360,20 Q420,40 480,20 L480,40 L0,40 Z" fill="#F6F4EB"/>
            <path d="M0,28 Q60,8 120,28 Q180,48 240,28 Q300,8 360,28 Q420,48 480,28" fill="none" stroke="rgba(128,150,113,0.2)" stroke-width="1"/>
        </svg>
    </div>

    {{-- MEMPELAI --}}
    <section class="sa-section" id="s-mempelai" style="background:var(--krem2)">
        <div class="sec-inner" style="padding-bottom:0">
            <p class="sec-eyebrow">💑 Nu Kagungan Kersa</p>
            <h2 class="sec-title">Mempelai</h2>
            <div class="green-line"></div>
        </div>
        <div class="mempelai-cards">
            <div class="mp-card">
                <img src="{{ saImg2($pria['foto'] ?? '', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=560&fit=crop') }}" class="mp-photo" alt="">
                <div class="mp-info">
                    <p class="mp-role">Mempelai Pameget</p>
                    <h3 class="mp-name">{{ $pria['nama'] ?? 'Dian Ramdhan, S.T.' }}</h3>
                    <p class="mp-parents">Putra ti<br><strong>Bp. {{ $pria['ayah'] ?? '...' }}</strong><br>&amp; <strong>Ibu {{ $pria['ibu'] ?? '...' }}</strong></p>
                    @if(!empty($formatInstagram($pria['instagram'] ?? '')['username']))<a href="{{ $formatInstagram($pria['instagram'] ?? '')['url'] }}" class="mp-ig" target="_blank">🍃 {{ $formatInstagram($pria['instagram'] ?? '')['display'] }}</a>@endif
                </div>
            </div>
            <div class="mp-card">
                <img src="{{ saImg2($wanita['foto'] ?? '', 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&h=560&fit=crop') }}" class="mp-photo" alt="">
                <div class="mp-info">
                    <p class="mp-role">Mempelai Istri</p>
                    <h3 class="mp-name">{{ $wanita['nama'] ?? 'Sari Melati, S.Pd.' }}</h3>
                    <p class="mp-parents">Putri ti<br><strong>Bp. {{ $wanita['ayah'] ?? '...' }}</strong><br>&amp; <strong>Ibu {{ $wanita['ibu'] ?? '...' }}</strong></p>
                    @if(!empty($formatInstagram($wanita['instagram'] ?? '')['username']))<a href="{{ $formatInstagram($wanita['instagram'] ?? '')['url'] }}" class="mp-ig" target="_blank">🌸 {{ $formatInstagram($wanita['instagram'] ?? '')['display'] }}</a>@endif
                </div>
            </div>
        </div>
        <div style="height:14px;background:var(--krem2)"></div>
    </section>

    {{-- WAVE DIVIDER 2 --}}
    <div class="leaf-divider" style="background:var(--krem2)">
        <svg viewBox="0 0 480 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,20 Q60,40 120,20 Q180,0 240,20 Q300,40 360,20 Q420,0 480,20 L480,40 L0,40 Z" fill="#FDFBF7"/>
            <path d="M0,14 Q60,34 120,14 Q180,-6 240,14 Q300,34 360,14 Q420,-6 480,14" fill="none" stroke="rgba(128,150,113,0.2)" stroke-width="1"/>
        </svg>
    </div>

    {{-- KISAH --}}
    <section class="sa-section mendung" id="s-kisah">
        <div class="sec-inner" style="padding-bottom:0">
            <p class="sec-eyebrow">🌿 Lakon Asih</p>
            <h2 class="sec-title">Kisah Cinta</h2>
            <div class="green-line"></div>
        </div>
        <div class="zz-track">
            @foreach($stories as $idx => $s)
            @if(!empty($s['title']))
            <div class="zz-item">
                @if($idx % 2 == 0)
                <div class="zz-card"><p class="zz-year">🌿 {{ $s['year'] ?? '' }}</p><h4 class="zz-title">{{ $s['title'] }}</h4><p class="zz-text">{{ $s['story'] }}</p></div>
                <div class="zz-dot-wrap"><div class="zz-dot"></div></div>
                <div class="spacer"></div>
                @else
                <div class="spacer"></div>
                <div class="zz-dot-wrap"><div class="zz-dot"></div></div>
                <div class="zz-card"><p class="zz-year">🌸 {{ $s['year'] ?? '' }}</p><h4 class="zz-title">{{ $s['title'] }}</h4><p class="zz-text">{{ $s['story'] }}</p></div>
                @endif
            </div>
            @endif
            @endforeach
        </div>
    </section>

    {{-- VINE DIVIDER --}}
    <div class="leaf-divider" style="background:var(--krem)">
        <svg viewBox="0 0 480 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,10 Q120,50 240,10 Q360,-30 480,10 L480,50 L0,50 Z" fill="#FDFBF7"/>
            <path d="M0,10 Q120,50 240,10 Q360,-30 480,10" fill="none" stroke="rgba(184,147,82,0.25)" stroke-width="1"/>
        </svg>
    </div>

    {{-- ACARA --}}
    <section class="sa-section" id="s-acara" style="background:var(--krem)">
        <div class="sec-inner" style="padding-bottom:12px">
            <p class="sec-eyebrow">🌸 Kasempetan Anu Ditunggu</p>
            <h2 class="sec-title">Acara Nikah</h2>
            <div class="green-line"></div>
        </div>
        <div class="dual-cols">
            <div class="ev-col">
                <div class="ev-num">I</div>
                <span class="ev-badge">Akad Nikah</span>
                <div class="ev-title">{{ $akad['judul'] ?? 'Ijab Kabul' }}</div>
                <div class="ev-row"><span class="ev-icon">🌿</span><span>{{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->translatedFormat('l, d M Y') }}</span></div>
                <div class="ev-row"><span class="ev-icon">🕐</span><span>{{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->format('H:i') }} WIB</span></div>
                <div class="ev-row"><span class="ev-icon">📍</span><span>{{ $akad['tempat'] ?? 'Pendopo' }}@if(!empty($akad['alamat']))<br>{{ $akad['alamat'] }}@endif</span></div>
                @php
                    $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                    $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                    $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                @endphp
                @if($akadL1)<div class="ev-row" style="padding-left:20px;"><span>{{ $akadL1 }}</span></div>@endif
                @if($akadL2)<div class="ev-row" style="padding-left:20px;"><span>{{ $akadL2 }}</span></div>@endif
                @if(!empty($akad['maps'] ?? null) || !empty($akad['alamat'] ?? null))
                @php
                    $maps = $akad['maps'] ?? $akad['alamat'];
                    $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                        ? $maps 
                        : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                @endphp
                <a href="{{ $mapsUrl }}" class="btn-map" target="_blank" rel="noopener noreferrer">🌿 Maps</a>
                @endif
            </div>
            <div class="ev-col">
                <div class="ev-num">II</div>
                <span class="ev-badge">Resepsi</span>
                <div class="ev-title">{{ $resepsi['judul'] ?? 'Pesta Nikah' }}</div>
                <div class="ev-row"><span class="ev-icon">🌸</span><span>{{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->translatedFormat('l, d M Y') }}</span></div>
                <div class="ev-row"><span class="ev-icon">🕐</span><span>{{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->format('H:i') }} WIB</span></div>
                <div class="ev-row"><span class="ev-icon">📍</span><span>{{ $resepsi['tempat'] ?? 'Gedung' }}@if(!empty($resepsi['alamat']))<br>{{ $resepsi['alamat'] }}@endif</span></div>
                @php
                    $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                    $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                    $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                @endphp
                @if($resepsiL1)<div class="ev-row" style="padding-left:20px;"><span>{{ $resepsiL1 }}</span></div>@endif
                @if($resepsiL2)<div class="ev-row" style="padding-left:20px;"><span>{{ $resepsiL2 }}</span></div>@endif
                @if(!empty($resepsi['maps'] ?? null) || !empty($resepsi['alamat'] ?? null))
                @php
                    $maps = $resepsi['maps'] ?? $resepsi['alamat'];
                    $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                        ? $maps 
                        : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                @endphp
                <a href="{{ $mapsUrl }}" class="btn-map" target="_blank" rel="noopener noreferrer">🌸 Maps</a>
                @endif
            </div>
        </div>
        @php
            $dressSA = $invitation->content['acara']['dresscode'] ?? [];
            $dressSAJudul = trim($dressSA['judul'] ?? '');
            $dressSAInfo = trim($dressSA['info'] ?? '');
        @endphp
        @if($dressSAJudul !== '' || $dressSAInfo !== '')
        <div style="margin:12px 14px;padding:14px 16px;background:rgba(122,158,126,0.1);border:1px solid var(--border);border-radius:2px 12px 2px 12px;text-align:center">
            <p style="font-size:8px;letter-spacing:3px;text-transform:uppercase;color:var(--sage);font-weight:600;margin-bottom:4px">Dresscode</p>
            @if($dressSAJudul !== '')<p style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1rem;color:var(--hijau)">{{ $dressSAJudul }}</p>@endif
            @if($dressSAInfo !== '')<p style="font-size:10px;color:var(--kayu);opacity:0.75;margin-top:2px">{{ $dressSAInfo }}</p>@endif
        </div>
        @endif
        <div style="height:10px"></div>
    </section>

    {{-- WAVE DOWN --}}
    <div class="leaf-divider" style="background:var(--krem)">
        <svg viewBox="0 0 480 36" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,0 L480,0 L480,18 Q360,36 240,18 Q120,0 0,18 Z" fill="#F6F4EB"/>
        </svg>
    </div>

    {{-- GALERI --}}
    <section class="sa-section" id="s-galeri" style="background:var(--krem2)">
        <div class="sec-inner" style="padding-bottom:12px">
            <p class="sec-eyebrow">📸 Pepotoan</p>
            <h2 class="sec-title">Galeri</h2>
            <div class="green-line"></div>
        </div>
        @if(count($gallery) > 0)
        <div class="g-feat">
            <img src="{{ saImg2($gallery[0]) }}" class="g-feat-img" alt="" id="gFeat">
        </div>
        @endif
        <div class="g-strip">
            @foreach($gallery as $foto)
            <img src="{{ saImg2($foto) }}" class="g-thumb" alt="" onclick="switchFeat(this.src,this)">
            @endforeach
        </div>
        <p style="text-align:center;font-size:9px;letter-spacing:2px;color:var(--sage);opacity:0.6;padding:8px 0 4px">← Geser untuk foto lainnya →</p>
    </section>

    {{-- WAVE UP --}}
    <div class="leaf-divider" style="background:var(--krem2)">
        <svg viewBox="0 0 480 36" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,18 Q120,0 240,18 Q360,36 480,18 L480,36 L0,36 Z" fill="#FDFBF7"/>
        </svg>
    </div>

    {{-- RSVP & GIFT --}}
    <section class="sa-section mendung" id="s-ucapan">
        <div class="sec-inner" style="padding-bottom:12px">
            <p class="sec-eyebrow">✉️ Atur Ucapan</p>
            <h2 class="sec-title">Sungkem &amp; Hadiah</h2>
            <div class="green-line"></div>
        </div>

        @if(!empty($amplop['bank_name']))
        <div class="gift-card">
            <p class="gift-bank">🍃 &nbsp; {{ $amplop['bank_name'] }} &nbsp; 🍃</p>
            <p class="gift-num" id="numRek">{{ $amplop['account_number'] ?? '000 000 0000' }}</p>
            <p class="gift-holder">a/n {{ $amplop['account_holder'] ?? 'Nama Penerima' }}</p>
            <button class="btn-copy" onclick="copyNum()">🌿 &nbsp; Salin Nomor</button>
        </div>
        @endif

        @if(!empty($amplop['qris_image']))
        <div class="gift-card" style="margin-top:14px; text-align:center;">
            <p class="gift-bank" style="margin-bottom:10px;">🍃 &nbsp; Atawa Pindai QRIS &nbsp; 🍃</p>
            <img src="{{ asset($amplop['qris_image']) }}" alt="QRIS" loading="lazy" style="width:170px; max-width:70%; height:auto; aspect-ratio:1/1; object-fit:contain; background:#fff; padding:8px; border-radius:12px; border:1px solid var(--border); margin:0 auto; display:block;">
        </div>
        @endif

        <div style="padding:0 14px 14px">
            @if(session('success'))
            <div style="background:rgba(122,158,126,0.15);border:1px solid var(--border);color:var(--hijau);padding:10px 14px;margin-bottom:14px;font-size:12px;text-align:center;border-radius:8px">{{ session('success') }}</div>
            @endif
            <form action="{{ route('kirim.ucapan') }}" method="POST">
                @csrf
                <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                <input type="text" name="nama" class="form-input" placeholder="Nami panjenengan..." required>
                <select name="kehadiran" class="form-input">
                    <option value="hadir">🌸 Abdi badhe sumping</option>
                    <option value="tidak_hadir">Hapunten, teu tiasa sumping</option>
                    <option value="ragu">Dereng tiasa mastiken</option>
                </select>
                <textarea name="ucapan" rows="3" class="form-input" placeholder="Ucapan sareng pangdoana..." required style="resize:none"></textarea>
                <button type="submit" class="btn-kirim">🍃 &nbsp; Kirimkeun Ucapan</button>
            </form>
        </div>

        @if($invitation->comments->count() > 0)
        <div style="padding:0 14px 30px">
            <p style="font-size:9px;letter-spacing:3px;color:var(--sage);font-weight:600;margin-bottom:12px">🌿 Ucapan Tamu</p>
            @foreach($invitation->comments->sortByDesc('created_at')->take(10) as $c)
            <div class="wish-card">
                <div class="wish-hdr">
                    <div class="wish-av">{{ substr($c->name ?? $c->nama ?? '?',0,1) }}</div>
                    <span class="wish-nm">{{ $c->name ?? $c->nama }}</span>
                    <span class="wish-tm">{{ $c->created_at->diffForHumans() }}</span>
                </div>
                <p class="wish-txt">"{{ $c->comment ?? $c->ucapan }}"</p>
            </div>
            @endforeach
        </div>
        @endif
    </section>

</div>{{-- /app-scroll --}}

<div class="toast" id="toast"></div>

<script>
// ── Fireflies
(function(){
    const c=document.getElementById('ffLayer');
    for(let i=0;i<18;i++){
        const f=document.createElement('div');f.className='ff';
        const dx=(Math.random()*80-40)+'px',dy=(Math.random()*80-40)+'px';
        f.style.cssText=`left:${Math.random()*100}%;top:${Math.random()*100}%;--dx:${dx};--dy:${dy};animation-delay:${Math.random()*6}s;animation-duration:${5+Math.random()*5}s;width:${1+Math.random()*2}px;height:${1+Math.random()*2}px;`;
        c.appendChild(f);
    }
})();

// ── Open Gate → smooth reveal of continuous scroll
function openSurat(){
    const gate = document.getElementById('gate');
    const gc   = document.getElementById('gateContent');
    const app  = document.getElementById('appScroll');

    // 1) Pre-render home content behind the gate so no blank flash
    app.style.display = 'block';
    window.scrollTo(0, 0);

    // 2) Fade inner content first
    gc.classList.add('fade-out');

    // 3) Slide the tirai (curtains) open
    setTimeout(() => gate.classList.add('open'), 200);

    // 4) Crossfade: gate fades to transparent while home fades in
    setTimeout(() => {
        gate.classList.add('fade-out');
        app.classList.add('animate-in');
        document.getElementById('scrollSpy').classList.add('show');
        document.getElementById('musicFab').classList.add('show');
        document.getElementById('bgAudio')?.play().catch(() => {});
        initScrollSpy();
    }, 900);

    // 5) Remove the gate completely after the crossfade finishes
    setTimeout(() => { gate.style.display = 'none'; }, 1800);
}

// ── Scroll spy
const sections=['s-home','s-mempelai','s-kisah','s-acara','s-galeri','s-ucapan'];
function initScrollSpy(){
    const obs=new IntersectionObserver(entries=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                document.querySelectorAll('.spy-dot').forEach(d=>d.classList.remove('active'));
                const dot=document.querySelector(`.spy-dot[data-target="${e.target.id}"]`);
                if(dot)dot.classList.add('active');
            }
        });
    },{threshold:0.4});
    sections.forEach(id=>{const el=document.getElementById(id);if(el)obs.observe(el);});
}

function scrollTo2(id){
    document.getElementById(id)?.scrollIntoView({behavior:'smooth',block:'start'});
}

// ── Music
function toggleMusic(){
    const a=document.getElementById('bgAudio'),f=document.getElementById('musicFab');
    if(!a)return;
    if(a.paused){a.play();f.classList.add('playing');}
    else{a.pause();f.classList.remove('playing');}
}

// ── Gallery
function switchFeat(src,el){
    document.getElementById('gFeat').src=src;
    document.querySelectorAll('.g-thumb').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
}

// ── Countdown
const tgt=new Date("{{ $target->format('Y-m-d H:i:s') }}").getTime();
setInterval(()=>{
    const d=tgt-Date.now();if(d<=0)return;
    const pad=v=>String(Math.floor(v)).padStart(2,'0');
    document.getElementById('cdD').textContent=pad(d/864e5);
    document.getElementById('cdH').textContent=pad((d%864e5)/36e5);
    document.getElementById('cdM').textContent=pad((d%36e5)/6e4);
    document.getElementById('cdS').textContent=pad((d%6e4)/1e3);
},1000);

// ── Copy
function copyNum(){
    const t=document.getElementById('numRek')?.innerText;
    if(t)navigator.clipboard.writeText(t).then(()=>showToast('Nomer rekening disalin ✓'));
}

// ── Toast
function showToast(msg){
    const t=document.getElementById('toast');
    t.textContent=msg;t.classList.add('show');
    setTimeout(()=>t.classList.remove('show'),2500);
}
</script>
</body>
</html>
