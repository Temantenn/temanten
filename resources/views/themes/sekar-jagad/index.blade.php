<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sekar Jagad — {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Aryo' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Kirana' }}</title>
<meta property="og:title" content="{{ $invitation->title ?? 'Undangan Pernikahan' }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit($invitation->content['quote'] ?? 'Bismillah, izinkan kami mengundang Bapak/Ibu/Saudara/i ke acara pernikahan kami.', 100) }}">
<meta property="og:image" content="{{ $invitation->og_image }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{
    --bg:#FAFAF6; 
    --warm:#F5EDE0; 
    --pink:#D4898B; 
    --rose:#AE6673; /* Refined Dusty Rose */
    --sage:#7A9E89; 
    --gold:#C89948; /* Improved Gold */
    --gold-l:#F1D592; /* Richer Cream Gold */
    --navy:#233058; /* Deep Midnight Navy */
    --text:#3D2B1F; 
    --muted:rgba(61,43,31,0.55); 
    --border:rgba(180,130,130,0.22);
}
*{box-sizing:border-box;margin:0;padding:0}
html,body{overflow:hidden;height:100vh;background:var(--bg);font-family:'Plus Jakarta Sans',sans-serif;color:var(--text)}

/* ────────────────────────────────────────────────
   FLORAL BACKGROUND PATTERN
──────────────────────────────────────────────── */
.floral-bg{
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='2' fill='none' stroke='%23D4898B' stroke-width='0.5' opacity='0.2'/%3E%3Ccircle cx='30' cy='30' r='8' fill='none' stroke='%23D4898B' stroke-width='0.4' opacity='0.12'/%3E%3Cpath d='M30,22 Q34,26 30,30 Q26,26 30,22' fill='%23D4898B' opacity='0.08'/%3E%3Cpath d='M30,38 Q34,34 30,30 Q26,34 30,38' fill='%23D4898B' opacity='0.08'/%3E%3Cpath d='M22,30 Q26,34 30,30 Q26,26 22,30' fill='%23D4898B' opacity='0.08'/%3E%3Cpath d='M38,30 Q34,34 30,30 Q34,26 38,30' fill='%23D4898B' opacity='0.08'/%3E%3C/svg%3E");
    background-size:60px 60px;
}
.dark-floral{
    background-color:var(--navy);
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='8' fill='none' stroke='%23E4B857' stroke-width='0.4' opacity='0.1'/%3E%3Cpath d='M30,22 Q34,26 30,30 Q26,26 30,22' fill='%23E4B857' opacity='0.06'/%3E%3Cpath d='M30,38 Q34,34 30,30 Q26,34 30,38' fill='%23E4B857' opacity='0.06'/%3E%3Cpath d='M22,30 Q26,34 30,30 Q26,26 22,30' fill='%23E4B857' opacity='0.06'/%3E%3Cpath d='M38,30 Q34,34 30,30 Q34,26 38,30' fill='%23E4B857' opacity='0.06'/%3E%3C/svg%3E");
    background-size:60px 60px;
}

/* ────────────────────────────────────────────────
   KELOPAK GATE — 4 quadrant panels
──────────────────────────────────────────────── */
.gate{position:fixed;inset:0;z-index:999;max-width:480px;margin:0 auto;left:0;right:0;}
.kp{position:absolute;width:50%;height:50%;transition:transform 1.3s cubic-bezier(0.68,-0.15,0.27,1.15);background:var(--rose);}
.kp1{top:0;left:0;transform-origin:top left;
    background:linear-gradient(135deg,#8B4550,var(--rose));}
.kp2{top:0;right:0;transform-origin:top right;
    background:linear-gradient(225deg,#8B4550,var(--rose));}
.kp3{bottom:0;left:0;transform-origin:bottom left;
    background:linear-gradient(45deg,var(--rose),#8B4550);}
.kp4{bottom:0;right:0;transform-origin:bottom right;
    background:linear-gradient(315deg,var(--rose),#8B4550);}
/* each kp has a floral pattern overlay */
.kp::before{content:'';position:absolute;inset:0;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Ccircle cx='40' cy='40' r='18' fill='none' stroke='%23F5EDE0' stroke-width='0.7' opacity='0.15'/%3E%3Ccircle cx='40' cy='40' r='10' fill='none' stroke='%23F5EDE0' stroke-width='0.5' opacity='0.12'/%3E%3Cpath d='M40,22 Q46,31 40,40 Q34,31 40,22' fill='%23F5EDE0' opacity='0.08'/%3E%3Cpath d='M40,58 Q46,49 40,40 Q34,49 40,58' fill='%23F5EDE0' opacity='0.08'/%3E%3Cpath d='M22,40 Q31,46 40,40 Q31,34 22,40' fill='%23F5EDE0' opacity='0.08'/%3E%3Cpath d='M58,40 Q49,46 40,40 Q49,34 58,40' fill='%23F5EDE0' opacity='0.08'/%3E%3C/svg%3E");
    background-size:80px 80px;}
.gate.open .kp1{transform:translate(-100%,-100%)}
.gate.open .kp2{transform:translate(100%,-100%)}
.gate.open .kp3{transform:translate(-100%,100%)}
.gate.open .kp4{transform:translate(100%,100%)}
.gate-body{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:5;padding:0 28px;text-align:center}
.gate-body.fade-out{opacity:0;transition:opacity 0.3s}
.gate-flower{margin:0 auto 20px;display:block}
.g-eyebrow{font-size:10px;letter-spacing:4px;text-transform:uppercase;color:rgba(245,237,224,0.85);margin-bottom:12px;font-weight:600}
.g-names{font-family:'Cormorant Garamond',serif;font-size:3.5rem;font-weight:600;font-style:italic;color:var(--warm);line-height:1.15;text-shadow:0 3px 25px rgba(0,0,0,0.3), 0 0 10px rgba(184,134,11,0.3);margin-bottom:10px}
.g-amp{color:var(--gold-l);font-style:normal}
.g-subtitle{font-size:11px;letter-spacing:2px;color:rgba(228,184,87,0.8);margin-bottom:18px;font-weight:500}
.g-guest-box{background:rgba(245,237,224,0.12);border:1px solid rgba(228,184,87,0.3);border-radius:50px;padding:8px 22px;margin-bottom:20px;display:inline-block}
.g-guest-lbl{font-size:8px;letter-spacing:3px;color:rgba(245,237,224,0.65);text-transform:uppercase}
.g-guest-nm{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.1rem;color:var(--warm)}
.btn-open{background:linear-gradient(135deg,#D4AF37, #F1D592, #D4AF37);color:var(--navy);border:none;padding:14px 48px;font-weight:800;font-size:14px;letter-spacing:2px;cursor:pointer;transition:0.4s;border-radius:100px;box-shadow: 0 10px 30px rgba(0,0,0,0.2);display:flex;align-items:center;gap:10px;}
.btn-open:hover{box-shadow:0 12px 32px rgba(201,145,42,0.65);transform:translateY(-3px);filter:brightness(1.1)}

/* ────────────────────────────────────────────────
   TOP NAV — pill tabs
──────────────────────────────────────────────── */
.top-nav{position:fixed;top:0;left:50%;transform:translateX(-50%);width:100%;max-width:480px;z-index:300;height:48px;background:rgba(250,250,246,0.95);backdrop-filter:blur(16px);border-bottom:1px solid var(--border);display:none;align-items:center;overflow-x:auto;gap:2px;padding:0 8px}
.top-nav.show{display:flex}
.top-nav::-webkit-scrollbar{display:none}
.tn-btn{flex-shrink:0;padding:6px 14px;font-size:10px;letter-spacing:1.5px;font-weight:600;border:none;background:transparent;cursor:pointer;color:var(--muted);transition:0.2s;border-radius:50px;font-family:'Plus Jakarta Sans',sans-serif;white-space:nowrap}
.tn-btn.active,.tn-btn:hover{background:var(--rose);color:white}

/* ────────────────────────────────────────────────
   SNAP SCROLL CONTAINER
──────────────────────────────────────────────── */
.snap-wrap{position:fixed;inset:0;inset-top:48px;top:48px;overflow-y:scroll;scroll-snap-type:y mandatory;display:none;max-width:480px;margin:0 auto;left:0;right:0}
.snap-wrap.show{display:block}
.snap-wrap::-webkit-scrollbar{display:none}
.snap-sec{height:calc(100vh - 48px);scroll-snap-align:start;overflow:hidden;position:relative}
.snap-sec.auto-h{height:auto;min-height:calc(100vh - 48px);overflow-y:auto;scroll-snap-align:start}

/* Progress indicator */
.progress-pill{position:fixed;bottom:16px;right:14px;background:rgba(44,62,110,0.85);color:rgba(228,184,87,0.9);font-size:9px;letter-spacing:2px;padding:5px 10px;border-radius:50px;z-index:400;display:none;font-weight:600;pointer-events:none}
.progress-pill.show{display:block}

/* Music FAB */
.music-fab{position:fixed;bottom:16px;left:14px;width:38px;height:38px;background:var(--rose);border-radius:50%;display:flex;align-items:center;justify-content:center;z-index:400;cursor:pointer;box-shadow:0 3px 14px rgba(176,100,112,0.45);opacity:0;pointer-events:none;transition:opacity 0.5s;font-size:15px;color:white}
.music-fab.show{opacity:1;pointer-events:all}
@keyframes spin-slow{to{transform:rotate(360deg)}}
.playing{animation:spin-slow 8s linear infinite}

/* ────────────────────────────────────────────────
   SECTION: HOME
──────────────────────────────────────────────── */
.home-sec{display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;background:var(--bg);padding:0 24px}
.home-sec::before{content:'';position:absolute;inset:0;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='2' fill='none' stroke='%23D4898B' stroke-width='0.5' opacity='0.2'/%3E%3Ccircle cx='30' cy='30' r='8' fill='none' stroke='%23D4898B' stroke-width='0.4' opacity='0.12'/%3E%3Cpath d='M30,22 Q34,26 30,30 Q26,26 30,22' fill='%23D4898B' opacity='0.08'/%3E%3Cpath d='M30,38 Q34,34 30,30 Q26,34 30,38' fill='%23D4898B' opacity='0.08'/%3E%3Cpath d='M22,30 Q26,34 30,30 Q26,26 22,30' fill='%23D4898B' opacity='0.08'/%3E%3Cpath d='M38,30 Q34,34 30,30 Q34,26 38,30' fill='%23D4898B' opacity='0.08'/%3E%3C/svg%3E");background-size:60px 60px;pointer-events:none}
.home-eyebrow{font-size:8px;letter-spacing:5px;text-transform:uppercase;color:var(--pink);margin-bottom:14px;position:relative}
.home-cover-photo{
    width:180px;height:220px;
    object-fit:cover;
    border-radius:100px 100px 18px 18px;
    border:4px solid var(--warm);
    box-shadow:0 0 0 6px rgba(212,137,139,0.18),0 12px 36px rgba(176,100,112,0.28);
    margin-bottom:18px;
    position:relative;
    background:var(--warm);
}

.home-names{font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:300;font-style:italic;color:var(--navy);line-height:1.2;margin-bottom:4px;position:relative}
.home-amp{color:var(--rose)}
.home-date{font-size:9px;letter-spacing:4px;text-transform:uppercase;color:var(--muted);margin-bottom:18px;position:relative}
.cd-row{display:flex;gap:8px;justify-content:center;position:relative;margin-bottom:20px}
.cd-box{background:var(--navy);border-radius:8px;padding:8px 10px;min-width:50px;text-align:center}
.cd-num{display:block;font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:var(--gold-l);line-height:1}
.cd-lbl{font-size:6.5px;letter-spacing:2px;color:rgba(228,184,87,0.6);text-transform:uppercase;margin-top:2px;display:block}
.home-quote{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:0.92rem;color:var(--muted);line-height:1.9;position:relative;max-width:340px}

/* ────────────────────────────────────────────────
   SECTION: COUPLE — diagonal split
──────────────────────────────────────────────── */
.couple-diag{display:grid;grid-template-columns:1fr 1fr;height:100%}
.cd-pria{background:var(--navy);background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='8' fill='none' stroke='%23E4B857' stroke-width='0.4' opacity='0.1'/%3E%3C/svg%3E");background-size:60px 60px;clip-path:polygon(0 0,100% 0,80% 100%,0 100%);padding:32px 14px 24px 18px;display:flex;flex-direction:column;align-items:center}
.cd-wanita{background:var(--warm);clip-path:polygon(20% 0,100% 0,100% 100%,0 100%);padding:32px 18px 24px 32px;display:flex;flex-direction:column;align-items:center}
.cp-photo{width:100px;height:130px;object-fit:cover;object-position:center top;border-radius:50% 50% 50% 50% / 40% 40% 60% 60%;border:3px solid;margin-bottom:12px}
.cd-pria .cp-photo{border-color:var(--gold-l);box-shadow:0 6px 24px rgba(0,0,0,0.3)}
.cd-wanita .cp-photo{border-color:var(--rose);box-shadow:0 6px 24px rgba(176,100,112,0.25)}
.cp-role{font-size:7px;letter-spacing:3px;text-transform:uppercase;font-weight:700;margin-bottom:4px}
.cd-pria .cp-role{color:var(--gold-l)}
.cd-wanita .cp-role{color:var(--rose)}
.cp-name{font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-style:italic;text-align:center;line-height:1.3;margin-bottom:6px}
.cd-pria .cp-name{color:var(--warm)}
.cd-wanita .cp-name{color:var(--navy)}
.cp-parents{font-size:9.5px;text-align:center;line-height:1.9}
.cd-pria .cp-parents{color:rgba(245,237,224,0.65)}
.cd-wanita .cp-parents{color:var(--muted)}
.cp-ig{font-size:10px;margin-top:8px;text-decoration:none;display:inline-flex;align-items:center;gap:4px}
.cd-pria .cp-ig{color:var(--gold-l)}
.cd-wanita .cp-ig{color:var(--rose)}

/* ────────────────────────────────────────────────
   SECTION: STORY — alternating full-width bands
──────────────────────────────────────────────── */
.bands-wrap{height:100%;overflow-y:scroll;scroll-snap-type:y mandatory}
.bands-wrap::-webkit-scrollbar{display:none}
.band{min-height:100%;scroll-snap-align:start;display:flex;flex-direction:column;justify-content:center;padding:32px 22px}
.band:nth-child(odd){background:var(--bg)}
.band:nth-child(even){background:var(--navy)}
@keyframes pulse-dot{0%,100%{box-shadow:0 0 0 0 rgba(201,145,42,0.5)}50%{box-shadow:0 0 0 12px rgba(201,145,42,0)}}
.band-num{font-family:'Cormorant Garamond',serif;font-size:4rem;font-weight:300;line-height:1;margin-bottom:6px;opacity:0.18}
.band:nth-child(odd) .band-num{color:var(--rose)}
.band:nth-child(even) .band-num{color:var(--gold-l)}
.band-year{font-size:8px;letter-spacing:4px;text-transform:uppercase;font-weight:600;margin-bottom:8px;display:flex;align-items:center;gap:8px}
.band:nth-child(odd) .band-year{color:var(--pink)}
.band:nth-child(even) .band-year{color:var(--gold-l)}
.band-dot{width:8px;height:8px;background:var(--gold);border-radius:50%;animation:pulse-dot 2s infinite;flex-shrink:0}
.band-title{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-style:italic;margin-bottom:10px}
.band:nth-child(odd) .band-title{color:var(--navy)}
.band:nth-child(even) .band-title{color:var(--warm)}
.band-text{font-size:12px;line-height:1.9;max-width:380px}
.band:nth-child(odd) .band-text{color:var(--muted)}
.band:nth-child(even) .band-text{color:rgba(245,237,224,0.7)}
.band-hint{font-size:8px;letter-spacing:2px;text-align:center;margin-top:24px;opacity:0.45}
.band:nth-child(odd) .band-hint{color:var(--rose)}
.band:nth-child(even) .band-hint{color:var(--gold-l)}

/* ────────────────────────────────────────────────
   SECTION: ACARA — 3D FLIP CARD
──────────────────────────────────────────────── */
.acara-sec{display:flex;flex-direction:column;align-items:center;justify-content:center;background:var(--warm)}
.acara-head{text-align:center;margin-bottom:18px}
.sec-eyebrow{font-size:8px;letter-spacing:5px;text-transform:uppercase;color:var(--pink);margin-bottom:6px;font-weight:600}
.sec-title{font-family:'Cormorant Garamond',serif;font-size:1.8rem;font-style:italic;color:var(--navy)}
.sec-line{height:1px;background:linear-gradient(to right,transparent,var(--pink),transparent);width:60px;margin:8px auto 0}

.flip-hint{font-size:9px;letter-spacing:2px;color:var(--muted);text-align:center;margin-bottom:14px;opacity:0.7}
.flip-wrap{perspective:1200px;width:calc(100% - 48px);max-width:340px;height:320px;cursor:pointer}
.flip-inner{width:100%;height:100%;position:relative;transform-style:preserve-3d;transition:transform 0.8s cubic-bezier(0.45,0.05,0.55,0.95)}
.flip-inner.flipped{transform:rotateY(180deg)}
.flip-face{position:absolute;inset:0;border-radius:4px 24px 4px 24px;padding:24px 22px;backface-visibility:hidden;display:flex;flex-direction:column;justify-content:center}
.flip-front{background:var(--navy);border:1px solid rgba(228,184,87,0.25)}
.flip-back{background:var(--rose);transform:rotateY(180deg);border:1px solid rgba(245,237,224,0.25)}
.flip-tag{font-size:7.5px;letter-spacing:3px;text-transform:uppercase;font-weight:700;margin-bottom:8px}
.flip-front .flip-tag{color:var(--gold-l)}
.flip-back .flip-tag{color:rgba(245,237,224,0.75)}
.flip-main-title{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-style:italic;margin-bottom:14px}
.flip-front .flip-main-title{color:var(--warm)}
.flip-back .flip-main-title{color:var(--warm)}
.ev-row{display:flex;gap:8px;align-items:flex-start;margin-bottom:10px;font-size:11.5px;line-height:1.55}
.flip-front .ev-row{color:rgba(245,237,224,0.75)}
.flip-back .ev-row{color:rgba(245,237,224,0.85)}
.ev-i{font-size:14px;flex-shrink:0;margin-top:1px}
.btn-map-flip{display:inline-flex;align-items:center;gap:4px;margin-top:10px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.25);color:rgba(245,237,224,0.85);padding:6px 14px;font-size:9px;letter-spacing:2px;text-decoration:none;border-radius:50px;font-weight:600;transition:0.3s}
.flip-indicator{display:flex;justify-content:center;gap:8px;margin-top:14px}
.fi-dot{width:8px;height:8px;border-radius:50%;background:var(--border);transition:0.3s}
.fi-dot.active{background:var(--rose)}
.dresscode-strip{margin-top:12px;background:rgba(44,62,110,0.06);border:1px solid var(--border);padding:10px 18px;border-radius:50px;text-align:center;font-size:10px;color:var(--muted)}

/* ────────────────────────────────────────────────
   SECTION: GALLERY — CSS masonry columns
──────────────────────────────────────────────── */
.galeri-sec{background:var(--bg);overflow-y:auto}
.galeri-sec::-webkit-scrollbar{width:0}
.galeri-head{text-align:center;padding:28px 0 16px}
.masonry{columns:2;gap:3px;padding:0}
.masonry-item{break-inside:avoid;position:relative;overflow:hidden;display:block;margin-bottom:3px;cursor:pointer}
.masonry-item img{width:100%;display:block;filter:saturate(0.85);transition:filter 0.4s,transform 0.5s}
.masonry-item:hover img{filter:saturate(1.05);transform:scale(1.04)}
.masonry-item::after{content:'';position:absolute;inset:0;border-inset:0;outline:1.5px solid rgba(201,145,42,0.4);outline-offset:-8px;pointer-events:none}
.masonry-item:first-child{column-span:all;margin-bottom:3px}
.masonry-item:first-child img{height:200px;object-fit:cover}

/* ────────────────────────────────────────────────
   SECTION: GIFT — envelope animation
──────────────────────────────────────────────── */
.gift-sec{background:var(--warm);overflow-y:auto}
.gift-sec::-webkit-scrollbar{width:0}
/* Envelope */
.env-wrap{margin:0 22px 16px;position:relative;cursor:pointer}
.envelope{background:linear-gradient(135deg,var(--navy),#1a2d5e);border-radius:4px 16px 4px 16px;overflow:hidden;border:1px solid rgba(228,184,87,0.3)}
.env-flap{height:70px;background:linear-gradient(to bottom,#243870,var(--navy));display:flex;align-items:center;justify-content:center;font-size:22px;transition:0.4s}
.env-flap.open{transform:scaleY(-1);transform-origin:top}
.env-body{padding:20px;max-height:0;overflow:hidden;transition:max-height 0.6s ease}
.env-body.open{max-height:360px}
.env-bank{font-size:9px;letter-spacing:3px;color:var(--gold-l);font-weight:600;margin-bottom:4px}
.env-num{font-size:1.4rem;font-weight:700;letter-spacing:3px;color:var(--warm);margin-bottom:2px}
.env-holder{font-size:10px;color:rgba(212,234,212,0.65)}
.btn-copy{display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:rgba(228,184,87,0.12);border:1px solid rgba(228,184,87,0.35);color:var(--gold-l);padding:6px 16px;font-size:10px;letter-spacing:2px;cursor:pointer;border-radius:50px;transition:0.3s;font-weight:600}
.env-hint{font-size:9px;letter-spacing:2px;color:var(--muted);text-align:center;margin-bottom:12px;opacity:0.7}
/* RSVP form */
.form-input{width:100%;background:rgba(212,137,139,0.06);border:1px solid var(--border);padding:10px 14px;color:var(--text);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;margin-bottom:10px;outline:none;transition:0.3s;border-radius:8px}
.form-input:focus{border-color:var(--pink)}
.btn-kirim{width:100%;background:linear-gradient(135deg,var(--navy),#243870);color:var(--gold-l);border:none;padding:12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:10px;letter-spacing:3px;text-transform:uppercase;cursor:pointer;transition:0.3s;border-radius:4px 16px 4px 16px}
.btn-kirim:hover{box-shadow:0 4px 20px rgba(44,62,110,0.4)}
.wish-card{background:white;border:1px solid var(--border);padding:12px 14px;margin-bottom:8px;border-radius:4px 12px 4px 12px;border-left:3px solid var(--pink)}
.wish-hdr{display:flex;align-items:center;gap:8px;margin-bottom:4px}
.wish-av{width:28px;height:28px;background:var(--navy);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;color:var(--gold-l);font-weight:600}
.wish-nm{font-size:12px;font-weight:600;color:var(--navy)}
.wish-tm{font-size:9px;color:var(--pink);margin-left:auto}
.wish-txt{font-size:11px;color:var(--muted);font-style:italic;line-height:1.7}
.toast{position:fixed;bottom:20px;left:50%;transform:translateX(-50%) translateY(14px);background:var(--navy);color:var(--gold-l);padding:8px 22px;font-size:10px;letter-spacing:2px;z-index:9999;opacity:0;transition:0.3s;white-space:nowrap;border-radius:50px;font-weight:600}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
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
function sjImg($p,$fb='https://images.unsplash.com/photo-1519741497674-611481863552?w=800&fit=crop'){
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
    'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=400&fit=crop',
];
$stories=$invitation->content['love_stories']??[
    ['year'=>'Suatu Hari','title'=>'Pertemuan','story'=>'Di antara keramaian, satu tatapan mengubah segalanya. Sebuah awal yang sederhana, menjadi cerita yang tak terlupakan.'],
    ['year'=>'Berselang Waktu','title'=>'Mendekat','story'=>'Dari obrolan singkat ke pertemuan yang lebih sering, kami perlahan menyadari ada yang istimewa di antara kami.'],
    ['year'=>'Memantapkan Hati','title'=>'Lamaran','story'=>'Dengan segenap keberanian dan cinta yang menggenapi, ia bertanya — dan jawaban satu kata itu mengubah segalanya.'],
];
$target=\Carbon\Carbon::parse($akad['waktu']??now()->addDays(90));
$sections=[
    ['id'=>'s-home','label'=>'Beranda'],
    ['id'=>'s-couple','label'=>'Mempelai'],
    ['id'=>'s-story','label'=>'Kisah'],
    ['id'=>'s-acara','label'=>'Acara'],
    ['id'=>'s-galeri','label'=>'Galeri'],
    ['id'=>'s-gift','label'=>'Hadiah & Ucapan'],
];
@endphp

<audio id="bgAudio" loop>
    <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/sekar-jagad.mp3') }}" type="audio/mpeg">
</audio>
<div class="music-fab" id="musicFab" onclick="toggleMusic()">♪</div>
<div class="progress-pill" id="progPill">1 / {{ count($sections) }}</div>

{{-- ═══ KELOPAK GATE ═══ --}}
<div class="gate" id="gate">
    <div class="kp kp1"></div><div class="kp kp2"></div>
    <div class="kp kp3"></div><div class="kp kp4"></div>
    <div class="gate-body" id="gateBody">
        {{-- Complex Floral Ornament --}}
        <div class="gate-flower" style="position:relative; width:220px; height:220px; margin: 0 auto 30px;">
            <!-- Outer Petals (Navy Path) -->
            <svg style="position:absolute; inset:0;" viewBox="0 0 100 100">
                <path d="M50,10 Q65,30 90,50 Q65,70 50,90 Q35,70 10,50 Q35,30 50,10" fill="none" stroke="var(--navy)" stroke-width="1.5" />
                <path d="M50,15 L50,85 M15,50 L85,50" stroke="rgba(35,48,88,0.3)" stroke-width="0.5" />
                <path d="M30,30 L70,70 M70,30 L30,70" stroke="rgba(35,48,88,0.2)" stroke-width="0.5" />
            </svg>
            <!-- Large Petal Fills -->
            <svg style="position:absolute; inset:10px;" viewBox="0 0 100 100">
                <path d="M50,5 Q70,35 95,50 Q70,65 50,95 Q30,65 5,50 Q30,35 50,5" fill="rgba(245,237,224,0.4)" />
                <path d="M50,12 Q65,35 88,50 Q65,65 50,88 Q35,65 12,50 Q35,35 50,12" fill="rgba(212,137,139,0.3)" />
            </svg>
            <!-- Central Mandalla Flower -->
            <svg style="position:absolute; inset:40px;" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" fill="white" filter="drop-shadow(0 4px 10px rgba(0,0,0,0.1))" />
                @for($i=0; $i<8; $i++)
                <ellipse cx="50" cy="30" rx="12" ry="22" fill="var(--warm)" transform="rotate({{ $i * 45 }} 50 50)" />
                @endfor
                @for($i=0; $i<8; $i++)
                <ellipse cx="50" cy="35" rx="8" ry="16" fill="var(--gold-l)" transform="rotate({{ $i * 45 + 22.5 }} 50 50)" />
                @endfor
                <circle cx="50" cy="50" r="10" fill="var(--navy)" />
                <circle cx="50" cy="50" r="6" fill="var(--gold)" />
            </svg>
        </div>
        
        <h1 class="g-names">{{ $pria['panggilan'] ?? 'Aryo' }} <span class="g-amp">&amp;</span> {{ $wanita['panggilan'] ?? 'Kirana' }}</h1>
        <p class="g-subtitle">Sekar Jagad · Undangan Pernikahan</p>
        
        @if(isset($guest))
        <div class="g-guest-box">
            <div class="g-guest-lbl">Kepada Yth.</div>
            <div class="g-guest-nm">{{ $guest->name }}</div>
        </div><br>
        @endif
        <button class="btn-open" onclick="openKelopak()">
            <span>✦</span>
            <span>Buka Undangan</span>
        </button>
    </div>
</div>

{{-- ═══ TOP NAV ═══ --}}
<nav class="top-nav" id="topNav">
    @foreach($sections as $i => $s)
    <button class="tn-btn {{ $i===0?'active':'' }}" id="tn-{{$i}}" onclick="snapTo('{{ $s['id'] }}',{{$i}})">{{ $s['label'] }}</button>
    @endforeach
</nav>

{{-- ═══ SNAP SCROLL CONTAINER ═══ --}}
<div class="snap-wrap" id="snapWrap">

    {{-- HOME --}}
    <section class="snap-sec home-sec floral-bg" id="s-home">
        <p class="home-eyebrow">✦ Selamat Datang ✦</p>
        @php
            $coverSrc = $invitation->content['media']['cover']
                ?? $invitation->content['media']['hero']
                ?? ($gallery[0] ?? null);
        @endphp
        <img src="{{ sjImg($coverSrc, 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800&fit=crop') }}"
             class="home-cover-photo"
             alt="Foto {{ $pria['panggilan'] ?? 'Mempelai' }} & {{ $wanita['panggilan'] ?? 'Mempelai' }}"
             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800&fit=crop';">
        <h2 class="home-names">{{ $pria['panggilan'] ?? 'Aryo' }} <span class="home-amp">&amp;</span> {{ $wanita['panggilan'] ?? 'Kirana' }}</h2>
        <p class="home-date">{{ $target->translatedFormat('d · F · Y') }}</p>
        <div class="cd-row">
            <div class="cd-box"><span class="cd-num" id="cdD">--</span><span class="cd-lbl">Hari</span></div>
            <div class="cd-box"><span class="cd-num" id="cdH">--</span><span class="cd-lbl">Jam</span></div>
            <div class="cd-box"><span class="cd-num" id="cdM">--</span><span class="cd-lbl">Menit</span></div>
            <div class="cd-box"><span class="cd-num" id="cdS">--</span><span class="cd-lbl">Detik</span></div>
        </div>
        <p class="home-quote">"{{ $invitation->content['quote'] ?? 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu istri-istri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya.' }}"</p>
    </section>

    {{-- COUPLE --}}
    <section class="snap-sec" id="s-couple">
        <div class="couple-diag" style="height:100%">
            <div class="cd-pria">
                <img src="{{ sjImg($pria['foto'] ?? '', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=600&fit=crop') }}" class="cp-photo" alt="">
                <p class="cp-role">Mempelai Pria</p>
                <h3 class="cp-name">{{ $pria['nama'] ?? 'Aryo Wicaksono, S.T.' }}</h3>
                <p class="cp-parents">Putra dari<br><strong>Bp. {{ $pria['ayah'] ?? '...' }}</strong><br>&amp; <strong>Ibu {{ $pria['ibu'] ?? '...' }}</strong></p>
                @if(!empty($formatInstagram($pria['instagram'] ?? '')['username']))<a href="{{ $formatInstagram($pria['instagram'] ?? '')['url'] }}" class="cp-ig" target="_blank">✦ {{ $formatInstagram($pria['instagram'] ?? '')['display'] }}</a>@endif
            </div>
            <div class="cd-wanita">
                <img src="{{ sjImg($wanita['foto'] ?? '', 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&h=600&fit=crop') }}" class="cp-photo" alt="">
                <p class="cp-role">Mempelai Wanita</p>
                <h3 class="cp-name">{{ $wanita['nama'] ?? 'Kirana Sari, S.Pd.' }}</h3>
                <p class="cp-parents">Putri dari<br><strong>Bp. {{ $wanita['ayah'] ?? '...' }}</strong><br>&amp; <strong>Ibu {{ $wanita['ibu'] ?? '...' }}</strong></p>
                @if(!empty($formatInstagram($wanita['instagram'] ?? '')['username']))<a href="{{ $formatInstagram($wanita['instagram'] ?? '')['url'] }}" class="cp-ig" target="_blank">♡ {{ $formatInstagram($wanita['instagram'] ?? '')['display'] }}</a>@endif
            </div>
        </div>
    </section>

    {{-- STORY — alternating bands --}}
    <section class="snap-sec" id="s-story">
        <div class="bands-wrap">
            @foreach($stories as $i => $s)
            @if(!empty($s['title']))
            <div class="band">
                <div class="band-num">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</div>
                <p class="band-year"><span class="band-dot"></span>{{ $s['year'] ?? '' }}</p>
                <h4 class="band-title">{{ $s['title'] ?? '' }}</h4>
                <p class="band-text">{{ $s['story'] ?? '' }}</p>
                @if($loop->last)<p class="band-hint">← Cerita kami ↑</p>@else<p class="band-hint">↓ Selanjutnya</p>@endif
            </div>
            @endif
            @endforeach
        </div>
    </section>

    {{-- ACARA — 3D FLIP --}}
    <section class="snap-sec acara-sec" id="s-acara">
        <div class="acara-head">
            <p class="sec-eyebrow">✦ Momen Sakral ✦</p>
            <h2 class="sec-title">Acara Pernikahan</h2>
            <div class="sec-line"></div>
        </div>
        <p class="flip-hint">⟳ &nbsp; Ketuk kartu untuk membalik</p>
        <div class="flip-wrap" onclick="flipCard()">
            <div class="flip-inner" id="flipInner">
                {{-- FRONT: AKAD --}}
                <div class="flip-face flip-front">
                    <span class="flip-tag">· Akad Nikah ·</span>
                    <div class="flip-main-title">{{ $akad['judul'] ?? 'Ijab Kabul' }}</div>
                    <div class="ev-row"><span class="ev-i">📅</span><span>{{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->translatedFormat('l, d F Y') }}</span></div>
                    <div class="ev-row"><span class="ev-i">🕐</span><span>Pukul {{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->format('H:i') }} WIB</span></div>
                    <div class="ev-row"><span class="ev-i">📍</span><span>{{ $akad['tempat'] ?? 'Pendopo Kediaman' }}@if(!empty($akad['alamat']))<br>{{ $akad['alamat'] }}@endif</span></div>
                    @php
                        $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                        $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                        $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($akadL1)<div class="ev-row" style="padding-left:22px;"><span>{{ $akadL1 }}</span></div>@endif
                    @if($akadL2)<div class="ev-row" style="padding-left:22px;"><span>{{ $akadL2 }}</span></div>@endif
                    @if(!empty($akad['maps'] ?? null) || !empty($akad['alamat'] ?? null))
                    @php
                        $maps = $akad['maps'] ?? $akad['alamat'];
                        $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                            ? $maps 
                            : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                    @endphp
                    <a href="{{ $mapsUrl }}" class="btn-map-flip" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()">🗺 Peta Lokasi</a>
                    @endif
                </div>
                {{-- BACK: RESEPSI --}}
                <div class="flip-face flip-back">
                    <span class="flip-tag">· Resepsi Pernikahan ·</span>
                    <div class="flip-main-title">{{ $resepsi['judul'] ?? 'Walimatul Ursy' }}</div>
                    <div class="ev-row"><span class="ev-i">📅</span><span>{{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->translatedFormat('l, d F Y') }}</span></div>
                    <div class="ev-row"><span class="ev-i">🕐</span><span>Pukul {{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->format('H:i') }} WIB</span></div>
                    <div class="ev-row"><span class="ev-i">📍</span><span>{{ $resepsi['tempat'] ?? 'Gedung Pertemuan' }}@if(!empty($resepsi['alamat']))<br>{{ $resepsi['alamat'] }}@endif</span></div>
                    @php
                        $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                        $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                        $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($resepsiL1)<div class="ev-row" style="padding-left:22px;"><span>{{ $resepsiL1 }}</span></div>@endif
                    @if($resepsiL2)<div class="ev-row" style="padding-left:22px;"><span>{{ $resepsiL2 }}</span></div>@endif
                    @if(!empty($resepsi['maps'] ?? null) || !empty($resepsi['alamat'] ?? null))
                    @php
                        $maps = $resepsi['maps'] ?? $resepsi['alamat'];
                        $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                            ? $maps 
                            : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                    @endphp
                    <a href="{{ $mapsUrl }}" class="btn-map-flip" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()">🗺 Peta Lokasi</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="flip-indicator">
            <div class="fi-dot active" id="fd0"></div>
            <div class="fi-dot" id="fd1"></div>
        </div>
        @php
            $dressSJ = $invitation->content['acara']['dresscode'] ?? [];
            $dressSJJudul = trim($dressSJ['judul'] ?? '');
            $dressSJInfo = trim($dressSJ['info'] ?? '');
        @endphp
        @if($dressSJJudul !== '' || $dressSJInfo !== '')
        <div class="dresscode-strip">
            Dresscode:
            @if($dressSJJudul !== '')<strong style="color:var(--navy)">{{ $dressSJJudul }}</strong>@endif
            @if($dressSJInfo !== '')<span style="color:var(--muted);margin-left:6px">· {{ $dressSJInfo }}</span>@endif
        </div>
        @endif
    </section>

    {{-- GALLERY — CSS masonry --}}
    <section class="snap-sec auto-h galeri-sec" id="s-galeri">
        <div class="galeri-head">
            <p class="sec-eyebrow">✦ Potret Kasih ✦</p>
            <h2 class="sec-title">Galeri</h2>
            <div class="sec-line"></div>
        </div>
        <div class="masonry">
            @foreach($gallery as $foto)
            <div class="masonry-item">
                <img src="{{ sjImg($foto) }}" alt="" loading="lazy">
            </div>
            @endforeach
        </div>
        <div style="height:16px"></div>
    </section>

    {{-- GIFT + RSVP — envelope --}}
    <section class="snap-sec auto-h gift-sec" id="s-gift">
        <div style="padding:28px 0 14px;text-align:center">
            <p class="sec-eyebrow">✦ Hadiah &amp; Ucapan ✦</p>
            <h2 class="sec-title">Ucapan &amp; Doa</h2>
            <div class="sec-line"></div>
        </div>

        @if(!empty($amplop['bank_name']))
        <p class="env-hint">💌 Ketuk amplop untuk membuka</p>
        <div class="env-wrap" onclick="openEnv()">
            <div class="envelope">
                <div class="env-flap" id="envFlap">💌</div>
                <div class="env-body" id="envBody">
                    <p class="env-bank">✦ {{ $amplop['bank_name'] }} ✦</p>
                    <p class="env-num" id="numRek">{{ $amplop['account_number'] ?? '000 000 0000' }}</p>
                    <p class="env-holder">a/n {{ $amplop['account_holder'] ?? 'Nama Penerima' }}</p>
                    <button class="btn-copy" onclick="copyNum();event.stopPropagation()">✦ &nbsp; Salin Nomor</button>
                    @if(isset($amplop['qris_image']))
                    <div style="margin-top: 15px; border-top: 1px dashed rgba(212,137,139,0.4); padding-top: 15px;">
                        <p style="font-size: 10px; color: var(--navy); margin-bottom: 8px; letter-spacing: 1px;">Atau Scan QRIS Berikut:</p>
                        <img src="{{ asset($amplop['qris_image']) }}" alt="QRIS" style="width: 120px; height: 120px; object-fit: contain; border-radius: 8px; border: 2px solid rgba(245,237,224,1); background: white;">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div style="padding:0 22px 14px">
            @if(session('success'))
            <div style="background:rgba(212,137,139,0.12);border:1px solid var(--border);color:var(--navy);padding:10px 14px;margin-bottom:14px;font-size:12px;text-align:center;border-radius:8px">{{ session('success') }}</div>
            @endif
            <form action="{{ route('kirim.ucapan') }}" method="POST">
                @csrf
                <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                <input type="text" name="nama" class="form-input" placeholder="Nama..." required>
                <select name="kehadiran" class="form-input">
                    <option value="hadir">✦ Insya Allah hadir</option>
                    <option value="tidak_hadir">Mohon maaf, berhalangan</option>
                    <option value="ragu">Belum dapat memastikan</option>
                </select>
                <textarea name="ucapan" rows="3" class="form-input" placeholder="Tulis ucapan dan doa..." required style="resize:none"></textarea>
                <button type="submit" class="btn-kirim">✦ &nbsp; Kirim Ucapan</button>
            </form>
        </div>

        @if($invitation->comments->count() > 0)
        <div style="padding:0 22px 30px">
            <p style="font-size:9px;letter-spacing:3px;color:var(--pink);font-weight:600;margin-bottom:12px">✦ Ucapan &amp; Doa Tamu</p>
            @foreach($invitation->comments->sortByDesc('created_at')->take(8) as $c)
            <div class="wish-card">
                <div class="wish-hdr">
                    <div class="wish-av">{{ substr($c->name??$c->nama??'?',0,1) }}</div>
                    <span class="wish-nm">{{ $c->name??$c->nama }}</span>
                    <span class="wish-tm">{{ $c->created_at->diffForHumans() }}</span>
                </div>
                <p class="wish-txt">"{{ $c->comment??$c->ucapan }}"</p>
            </div>
            @endforeach
        </div>
        @endif
    </section>
</div>

<div class="toast" id="toast"></div>

<script>
const TOTAL={{count($sections)}};
let curIdx=0;
let isFlipped=false;
let envOpened=false;

// ── Kelopak open
function openKelopak(){
    document.getElementById('gateBody').classList.add('fade-out');
    setTimeout(()=>document.getElementById('gate').classList.add('open'),300);
    setTimeout(()=>{
        document.getElementById('gate').style.display='none';
        document.getElementById('topNav').classList.add('show');
        document.getElementById('snapWrap').classList.add('show');
        document.getElementById('musicFab').classList.add('show');
        document.getElementById('progPill').classList.add('show');
        document.getElementById('bgAudio')?.play().catch(()=>{});
        initScrollSpy();
    },1650);
}

// ── Snap to section
function snapTo(id,idx){
    document.getElementById(id)?.scrollIntoView({behavior:'smooth',block:'start'});
    setActive(idx);
}

function setActive(idx){
    curIdx=idx;
    document.querySelectorAll('.tn-btn').forEach((b,i)=>{b.classList.toggle('active',i===idx);});
    document.getElementById('progPill').textContent=`${idx+1} / ${TOTAL}`;
}

// ── Scroll spy via IntersectionObserver
function initScrollSpy(){
    const secs=['s-home','s-couple','s-story','s-acara','s-galeri','s-gift'];
    const obs=new IntersectionObserver(entries=>{
        entries.forEach(e=>{
            if(e.isIntersecting){
                const i=secs.indexOf(e.target.id);
                if(i>=0)setActive(i);
            }
        });
    },{threshold:0.5,root:document.getElementById('snapWrap')});
    secs.forEach(id=>{const el=document.getElementById(id);if(el)obs.observe(el);});
}

// ── 3D Flip card
function flipCard(){
    isFlipped=!isFlipped;
    document.getElementById('flipInner').classList.toggle('flipped',isFlipped);
    document.getElementById('fd0').classList.toggle('active',!isFlipped);
    document.getElementById('fd1').classList.toggle('active',isFlipped);
}

// ── Envelope
function openEnv(){
    if(!envOpened){
        envOpened=true;
        document.getElementById('envFlap').classList.add('open');
        document.getElementById('envBody').classList.add('open');
    }
}

// ── Music
function toggleMusic(){
    const a=document.getElementById('bgAudio'),f=document.getElementById('musicFab');
    if(a.paused){a.play();f.classList.add('playing');}
    else{a.pause();f.classList.remove('playing');}
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
    if(t)navigator.clipboard.writeText(t).then(()=>showToast('Nomor rekening disalin ✓'));
}
function showToast(msg){
    const t=document.getElementById('toast');
    t.textContent=msg;t.classList.add('show');
    setTimeout(()=>t.classList.remove('show'),2500);
}
</script>
</body>
</html>
