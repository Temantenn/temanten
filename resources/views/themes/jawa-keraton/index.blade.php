<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Undangan Pernikahan {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Raka' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Sari' }}</title>
<meta property="og:title" content="{{ $invitation->title ?? 'Undangan Pernikahan' }}">
<meta property="og:description" content="{{ \Illuminate\Support\Str::limit($invitation->content['quote'] ?? 'Bismillah, izinkan kami mengundang Bapak/Ibu/Saudara/i ke acara pernikahan kami.', 100) }}">
<meta property="og:image" content="{{ $invitation->og_image }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Cinzel:wght@400;600;700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root {
    --sogan:#3D1F0D; --sogan2:#5C2E14; --gold:#B8861A; --gold-l:#E0B84A; --gold-xl:#F2D785;
    --ivory:#F5EBD0; --ivory2:#EDD9A3; --krem:#FAF3E0; --hitam:#1A0E05;
    --bg:#F5EBD0; --border:rgba(184,134,26,0.35);
}
*{box-sizing:border-box;margin:0;padding:0}
html,body{width:100%;height:100%;overflow:hidden;background:var(--bg);font-family:'Jost',sans-serif;color:var(--sogan)}

/* ═══ BATIK BACKGROUND PATTERN — KAWUNG & PARANG ═══ */
.batik-bg {
    background-color:var(--krem);
    background-image:
        radial-gradient(circle at center, rgba(250,243,224,0.78) 0 38%, rgba(250,243,224,0) 39%),
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='96' height='96' viewBox='0 0 96 96'%3E%3Cg fill='none' stroke='%23B8861A' stroke-width='1' opacity='.22'%3E%3Cellipse cx='48' cy='22' rx='13' ry='22'/%3E%3Cellipse cx='48' cy='74' rx='13' ry='22'/%3E%3Cellipse cx='22' cy='48' rx='22' ry='13'/%3E%3Cellipse cx='74' cy='48' rx='22' ry='13'/%3E%3Ccircle cx='48' cy='48' r='6'/%3E%3C/g%3E%3Cg fill='%23B8861A' opacity='.09'%3E%3Cpath d='M0 8 C18 22 18 38 0 52 V42 C8 34 8 26 0 18z'/%3E%3Cpath d='M96 44 C78 58 78 74 96 88 V78 C88 70 88 62 96 54z'/%3E%3C/g%3E%3C/svg%3E");
    background-size:140px 140px, 96px 96px;
}
.batik-dark {
    background-color:var(--sogan);
    background-image:
        linear-gradient(135deg, rgba(224,184,74,0.06) 25%, transparent 25%, transparent 50%, rgba(224,184,74,0.06) 50%, rgba(224,184,74,0.06) 75%, transparent 75%, transparent),
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92'%3E%3Cg fill='none' stroke='%23E0B84A' stroke-width='1' opacity='.16'%3E%3Cpath d='M-12 74 C18 54 30 28 18 -8'/%3E%3Cpath d='M14 100 C44 80 56 54 44 18'/%3E%3Cpath d='M40 126 C70 106 82 80 70 44'/%3E%3Cpath d='M66 152 C96 132 108 106 96 70'/%3E%3C/g%3E%3Cg fill='%23E0B84A' opacity='.12'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3Ccircle cx='66' cy='46' r='2'/%3E%3Ccircle cx='42' cy='78' r='2'/%3E%3C/g%3E%3C/svg%3E");
    background-size:36px 36px, 92px 92px;
}

/* ═══ APP WRAPPER ═══ */
.app{max-width:480px;height:100vh;margin:0 auto;position:relative;overflow:hidden}

/* ═══ GUNUNGAN GATE ═══ */
.gate{position:absolute;inset:0;z-index:999;display:flex;align-items:center;justify-content:center;background:radial-gradient(circle at center,rgba(92,46,20,0.18),transparent 58%)}
.gate::before,.gate::after{content:"";position:absolute;top:18px;bottom:18px;width:22px;z-index:1;border-top:1px solid rgba(224,184,74,0.55);border-bottom:1px solid rgba(224,184,74,0.55);background:repeating-linear-gradient(45deg,rgba(224,184,74,0.25) 0 7px,rgba(224,184,74,0.05) 7px 14px)}
.gate::before{left:18px}.gate::after{right:18px}
.gate-half{position:absolute;top:0;bottom:0;width:50%;transition:transform 1.4s cubic-bezier(0.77,0,0.18,1)}
.gate-left{left:0;transform-origin:left center;background:var(--hitam);background-image:linear-gradient(90deg,rgba(224,184,74,0.12),transparent 26%),url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92'%3E%3Cg fill='none' stroke='%23B8861A' stroke-width='1' opacity='.16'%3E%3Cellipse cx='46' cy='21' rx='12' ry='21'/%3E%3Cellipse cx='46' cy='71' rx='12' ry='21'/%3E%3Cellipse cx='21' cy='46' rx='21' ry='12'/%3E%3Cellipse cx='71' cy='46' rx='21' ry='12'/%3E%3C/g%3E%3C/svg%3E")}
.gate-right{right:0;transform-origin:right center;background:var(--hitam);background-image:linear-gradient(270deg,rgba(224,184,74,0.12),transparent 26%),url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='92' height='92' viewBox='0 0 92 92'%3E%3Cg fill='none' stroke='%23B8861A' stroke-width='1' opacity='.16'%3E%3Cellipse cx='46' cy='21' rx='12' ry='21'/%3E%3Cellipse cx='46' cy='71' rx='12' ry='21'/%3E%3Cellipse cx='21' cy='46' rx='21' ry='12'/%3E%3Cellipse cx='71' cy='46' rx='21' ry='12'/%3E%3C/g%3E%3C/svg%3E")}
.gate.open .gate-left{transform:translateX(-100%)}
.gate.open .gate-right{transform:translateX(100%)}
.gate-center{position:relative;z-index:2;text-align:center;padding:0 24px;pointer-events:none}
.gate-center.hide{opacity:0;transition:opacity 0.4s}
.jawa-ornament{width:118px;height:138px;margin:0 auto 18px;position:relative;filter:drop-shadow(0 12px 18px rgba(0,0,0,0.35))}
.jawa-ornament::before{content:"";position:absolute;inset:0;background:linear-gradient(160deg,var(--gold-xl),var(--gold) 42%,#7f4c0a 100%);clip-path:polygon(50% 0,67% 12%,78% 27%,86% 46%,82% 67%,69% 85%,50% 100%,31% 85%,18% 67%,14% 46%,22% 27%,33% 12%);border:1px solid rgba(242,215,133,0.7)}
.jawa-ornament::after{content:"";position:absolute;inset:12px 18px 18px;background:var(--hitam);opacity:.86;clip-path:polygon(50% 0,62% 13%,70% 31%,76% 50%,70% 70%,58% 88%,50% 100%,42% 88%,30% 70%,24% 50%,30% 31%,38% 13%)}
.jawa-ornament .kayon-line{position:absolute;left:50%;top:25px;width:2px;height:82px;background:linear-gradient(var(--gold-xl),var(--gold));transform:translateX(-50%);z-index:2;box-shadow:0 0 0 1px rgba(26,14,5,0.22)}
.jawa-ornament .kayon-line::before,.jawa-ornament .kayon-line::after{content:"";position:absolute;top:24px;width:32px;height:32px;border:2px solid var(--gold-l);border-radius:50%;opacity:.9}
.jawa-ornament .kayon-line::before{right:6px;border-right:0;border-bottom:0;transform:rotate(-25deg)}
.jawa-ornament .kayon-line::after{left:6px;border-left:0;border-bottom:0;transform:rotate(25deg)}
.gate-eyebrow{font-size:10px;letter-spacing:6px;text-transform:uppercase;color:var(--gold-l);margin-bottom:15px;opacity:0.9}
.gate-names{font-family:'Cormorant Garamond',serif;font-size:3.2rem;font-weight:400;font-style:italic;color:var(--ivory);line-height:1.1;margin:18px 0}
.gate-amp{color:var(--ivory);font-style:normal;font-weight:300;display:inline-block;margin:0 10px}
.gate-divider-wrap{margin:18px auto;display:flex;align-items:center;justify-content:center;gap:12px;opacity:0.6}
.gate-divider{width:60px;height:1px;background:linear-gradient(to right,transparent,var(--gold-xl),var(--gold-xl),transparent)}
.gate-divider-dot{width:4px;height:4px;background:var(--gold-l);border-radius:50%}
.btn-buka{background:linear-gradient(135deg,#B8861A, #F2D785, #B8861A);color:var(--hitam);border:none;padding:14px 44px;font-family:'Cinzel',serif;font-weight:700;font-size:12px;letter-spacing:2.5px;text-transform:uppercase;cursor:pointer;transition:0.4s;border-radius:50px;pointer-events:all;box-shadow:0 10px 30px rgba(184,134,26,0.25);display:inline-flex;align-items:center;gap:10px}
.btn-buka:hover{box-shadow:0 12px 35px rgba(184,134,26,0.45);transform:translateY(-3px);filter:brightness(1.05)}

/* ═══ GATE GUEST (nama tamu di atas tombol buka) ═══ */
.gate-guest{margin:6px auto 18px;padding:10px 16px;border-top:1px solid rgba(184,134,26,0.35);border-bottom:1px solid rgba(184,134,26,0.35);max-width:340px;pointer-events:all}
.gate-guest-eyebrow{font-size:9px;letter-spacing:4px;text-transform:uppercase;color:var(--gold-l);opacity:.85;margin-bottom:4px;font-family:'Cinzel',serif}
.gate-guest-name{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.2rem;color:var(--ivory);line-height:1.2;margin:0}

/* ═══ PAGES ═══ */
.page{position:absolute;inset:0;overflow-y:auto;display:none;padding-bottom:130px}
.page.active{display:block}
.page::-webkit-scrollbar{width:0}

/* ═══ MUSIC FAB ═══ */
.music-fab{position:fixed;bottom:88px;right:14px;width:38px;height:38px;background:var(--gold);border-radius:50%;display:flex;align-items:center;justify-content:center;z-index:500;cursor:pointer;box-shadow:0 0 16px rgba(184,134,26,0.5);opacity:0;pointer-events:none;transition:opacity 0.5s;font-size:15px;color:var(--hitam)}
.music-fab.show{opacity:1;pointer-events:all}
@keyframes spin-slow{to{transform:rotate(360deg)}}
.playing{animation:spin-slow 6s linear infinite}

/* ═══ RADIAL NAV ═══ */
.radial-nav{position:fixed;bottom:0;left:50%;transform:translateX(-50%);width:100%;max-width:480px;z-index:300;opacity:0;pointer-events:none;transition:opacity 0.5s}
.radial-nav.show{opacity:1;pointer-events:all}
.radial-bar{height:70px;background:rgba(61,31,13,0.97);backdrop-filter:blur(20px);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-around;padding:0 8px}
.nav-btn{display:flex;flex:1;flex-direction:column;align-items:center;justify-content:center;gap:3px;cursor:pointer;padding:0;height:100%;transition:0.2s;color:rgba(224,184,74,0.45);border:none;background:none;pointer-events:auto;min-width:0}
.nav-btn.active,.nav-btn:hover{color:var(--gold-l);background:rgba(224,184,74,0.05)}
.nav-btn span{font-size:7px;letter-spacing:1px;text-transform:uppercase;font-family:'Cinzel',serif;white-space:nowrap}
.nav-icon{font-size:18px;line-height:1}

/* ═══ SECTION TITLE ═══ */
.sec-title{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:300;font-style:italic;color:var(--gold);text-align:center;margin-bottom:6px}
.sec-ornament{text-align:center;color:var(--gold-l);opacity:0.68;font-size:1.1rem;letter-spacing:8px;margin-bottom:20px}
.sec-ornament::before,.sec-ornament::after{content:'ꦋ';font-size:.85rem;margin:0 8px;color:var(--gold)}
.gold-line{width:72px;height:1px;background:linear-gradient(to right,transparent,var(--gold),var(--gold-xl),var(--gold),transparent);margin:10px auto}

/* ═══ HOME PAGE ═══ */
.home-hero{height:56vh;background-size:cover;background-position:center;position:relative}
.home-hero::before{content:"";position:absolute;left:18px;right:18px;top:18px;bottom:18px;border:1px solid rgba(242,215,133,0.55);z-index:1;pointer-events:none;box-shadow:0 0 0 6px rgba(61,31,13,0.12)}
.home-hero::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,rgba(61,31,13,0.28),var(--bg) 100%)}
.home-card{background:var(--krem);border:1px solid var(--border);border-radius:2px;padding:28px 20px 24px;margin:-20px 16px 20px;position:relative;z-index:5;text-align:center;box-shadow:0 8px 40px rgba(61,31,13,0.12)}
.home-card::before,.home-card::after{content:"";position:absolute;left:12px;right:12px;height:10px;background:repeating-linear-gradient(90deg,var(--gold) 0 10px,transparent 10px 20px);opacity:.42;pointer-events:none}.home-card::before{top:8px}.home-card::after{bottom:8px}
.home-couple{font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-style:italic;color:var(--sogan);line-height:1.2;margin-bottom:16px}
.home-amp{color:var(--gold);font-style:normal}
.cd-grid{display:flex;justify-content:center;gap:8px}
.cd-box{background:var(--sogan);border:1px solid var(--border);padding:8px 12px;min-width:54px;text-align:center}
.cd-num{display:block;font-family:'Cinzel',serif;font-size:1.4rem;color:var(--gold-l);line-height:1}
.cd-lbl{font-size:7px;letter-spacing:2px;color:var(--ivory2);text-transform:uppercase;margin-top:3px;display:block}
.home-quote{font-family:'Cormorant Garamond',serif;font-style:italic;font-size:0.95rem;color:var(--sogan2);text-align:center;padding:0 20px;line-height:1.9;margin-bottom:20px;opacity:0.85}

/* ═══ COUPLE PAGE — SPLIT ═══ */
.couple-split{display:grid;grid-template-columns:1fr 1fr;gap:0;min-height:calc(100vh - 90px)}
.couple-half{padding:30px 14px 20px;display:flex;flex-direction:column;align-items:center}
.couple-half:first-child{background:var(--sogan);background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='10' r='9' fill='none' stroke='%23E0B84A' stroke-width='0.7' opacity='0.1'/%3E%3Ccircle cx='30' cy='50' r='9' fill='none' stroke='%23E0B84A' stroke-width='0.7' opacity='0.1'/%3E%3Ccircle cx='10' cy='30' r='9' fill='none' stroke='%23E0B84A' stroke-width='0.7' opacity='0.1'/%3E%3Ccircle cx='50' cy='30' r='9' fill='none' stroke='%23E0B84A' stroke-width='0.7' opacity='0.1'/%3E%3C/svg%3E");}
.couple-half:last-child{background:var(--krem)}
.couple-photo{width:110px;height:110px;border-radius:50%;object-fit:cover;object-position:center top;border:3px solid var(--gold);box-shadow:0 0 0 6px rgba(184,134,26,0.2),0 8px 24px rgba(61,31,13,0.4);margin-bottom:14px}
.couple-role{font-size:8px;letter-spacing:4px;text-transform:uppercase;font-family:'Cinzel',serif;margin-bottom:2px}
.couple-half:first-child .couple-role{color:var(--gold-l)}
.couple-half:last-child .couple-role{color:var(--sogan)}
.couple-name{font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-style:italic;text-align:center;line-height:1.2;margin-bottom:8px}
.couple-half:first-child .couple-name{color:var(--ivory)}
.couple-half:last-child .couple-name{color:var(--sogan)}
.couple-parents{font-size:10px;text-align:center;line-height:1.8}
.couple-half:first-child .couple-parents{color:rgba(245,235,208,0.65)}
.couple-half:last-child .couple-parents{color:var(--sogan2);opacity:0.8}
.couple-divider{display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;z-index:10;margin-top:40px}
.couple-amp-badge{background:linear-gradient(135deg,var(--gold),var(--gold-l));color:var(--hitam);width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-style:italic;box-shadow:0 4px 20px rgba(184,134,26,0.5);margin:0 auto}

/* ═══ KISAH — HORIZONTAL TIMELINE ═══ */
.story-page{padding:40px 0 0}
.story-track{overflow-x:auto;padding:20px 20px 30px;display:flex;gap:16px;-webkit-overflow-scrolling:touch;scroll-snap-type:x mandatory}
.story-track::-webkit-scrollbar{height:3px}
.story-track::-webkit-scrollbar-track{background:var(--ivory2)}
.story-track::-webkit-scrollbar-thumb{background:var(--gold)}
.story-card{min-width:220px;background:var(--krem);border:1px solid var(--border);padding:20px 16px;position:relative;scroll-snap-align:start;flex-shrink:0}
.story-card::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:linear-gradient(to bottom,var(--gold),var(--gold-l))}
.story-year{font-family:'Cinzel',serif;font-size:10px;letter-spacing:3px;color:var(--gold);margin-bottom:6px}
.story-title{font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-style:italic;color:var(--sogan);margin-bottom:6px}
.story-text{font-size:11px;color:var(--sogan2);line-height:1.8;opacity:0.85}
.story-dot{width:10px;height:10px;background:var(--gold);border-radius:50%;box-shadow:0 0 8px rgba(184,134,26,0.7);margin-bottom:8px}

/* ═══ ACARA — ACCORDION ═══ */
.event-page{padding:40px 0 0}
.accordion-item{border-bottom:1px solid var(--border)}
.accordion-header{display:flex;align-items:center;justify-content:space-between;padding:18px 20px;cursor:pointer;background:transparent;border:none;width:100%;text-align:left;transition:background 0.2s}
.accordion-header:hover{background:rgba(184,134,26,0.05)}
.accordion-title{font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-style:italic;color:var(--sogan)}
.accordion-chevron{color:var(--gold);font-size:18px;transition:transform 0.3s}
.accordion-body{max-height:0;overflow:hidden;transition:max-height 0.5s ease,padding 0.3s}
.accordion-body.open{max-height:400px}
.accordion-inner{padding:0 20px 20px}
.ev-detail{display:flex;align-items:flex-start;gap:10px;margin-bottom:10px;font-size:12px;color:var(--sogan2)}
.ev-icon{color:var(--gold);font-size:16px;margin-top:1px;flex-shrink:0}
.btn-maps-jawa{display:inline-flex;align-items:center;gap:6px;margin-top:10px;background:var(--sogan);color:var(--gold-l);padding:7px 18px;font-family:'Cinzel',serif;font-size:9px;letter-spacing:2px;text-decoration:none;transition:0.3s;border:1px solid var(--border)}
.btn-maps-jawa:hover{background:var(--sogan2)}

/* ═══ GALERI — BATIK FRAME ═══ */
.gallery-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:3px;padding:0}
.gallery-item{position:relative;overflow:hidden;aspect-ratio:4/5;background:var(--ivory2)}
.gallery-img{width:100%;height:100%;object-fit:contain;display:block;filter:sepia(0.15) contrast(1.05);transition:transform 0.5s,filter 0.3s}
.gallery-item:hover .gallery-img{transform:scale(1.04);filter:sepia(0) contrast(1)}
.gallery-item::after{content:'';position:absolute;inset:6px;border:1px solid rgba(184,134,26,0.5);pointer-events:none}
.gallery-item:first-child{grid-column:1/-1;aspect-ratio:16/10}

/* ═══ RSVP & GIFT ═══ */
.wishes-page{padding:40px 0 140px}
.gift-strip{background:linear-gradient(135deg,var(--sogan),var(--sogan2));border:1px solid var(--border);margin:0 16px 16px;padding:20px;position:relative;overflow:hidden}
.gift-strip::before{content:'ꦋ ꦋ ꦋ';position:absolute;top:10px;right:14px;color:var(--gold-l);opacity:0.35;font-size:12px;letter-spacing:6px}
.gift-bank{font-size:9px;letter-spacing:3px;color:var(--gold-l);text-transform:uppercase;margin-bottom:4px;font-family:'Cinzel',serif}
.gift-num{font-size:1.5rem;font-weight:600;letter-spacing:4px;color:var(--ivory);margin-bottom:2px}
.gift-holder{font-size:11px;color:rgba(245,235,208,0.6)}
.btn-copy-jawa{display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:rgba(224,184,74,0.15);border:1px solid rgba(224,184,74,0.4);color:var(--gold-l);padding:6px 16px;font-size:10px;letter-spacing:2px;font-family:'Cinzel',serif;cursor:pointer;transition:0.3s}
.btn-copy-jawa:hover{background:rgba(224,184,74,0.25)}
.form-input-jawa{width:100%;background:rgba(245,235,208,0.5);border:1px solid var(--border);padding:10px 14px;color:var(--sogan);font-family:'Jost',sans-serif;font-size:12px;margin-bottom:10px;outline:none;transition:border 0.3s}
.form-input-jawa:focus{border-color:var(--gold)}
.form-input-jawa option{background:var(--krem)}
.btn-kirim{width:100%;background:linear-gradient(135deg,var(--sogan),var(--sogan2));color:var(--gold-l);border:none;padding:12px;font-family:'Cinzel',serif;font-weight:600;font-size:10px;letter-spacing:4px;text-transform:uppercase;cursor:pointer;transition:0.3s;border:1px solid var(--border)}
.btn-kirim:hover{background:linear-gradient(135deg,var(--sogan2),var(--sogan));box-shadow:0 0 20px rgba(184,134,26,0.3)}
.wish-card{background:var(--krem);border:1px solid var(--border);padding:12px 14px;margin-bottom:8px;border-left:3px solid var(--gold)}
.wish-hdr{display:flex;align-items:center;gap:8px;margin-bottom:4px}
.wish-av{width:28px;height:28px;background:var(--sogan);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:11px;color:var(--gold-l);flex-shrink:0}
.wish-nm{font-size:12px;font-weight:600;color:var(--sogan)}
.wish-tm{font-size:9px;color:var(--sogan2);opacity:0.7;margin-left:auto}
.wish-txt{font-size:11px;color:var(--sogan2);font-style:italic;line-height:1.7}

/* ═══ TOAST ═══ */
.toast{position:fixed;bottom:92px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--gold);color:var(--hitam);padding:8px 22px;font-family:'Cinzel',serif;font-size:10px;letter-spacing:2px;z-index:9999;opacity:0;transition:0.3s;white-space:nowrap}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

/* ═══ PARTICLES ═══ */
.particles{position:fixed;inset:0;pointer-events:none;z-index:0;overflow:hidden}
.particle{position:absolute;width:3px;height:3px;background:var(--gold-l);border-radius:50%;opacity:0;animation:float-up 8s infinite}
@keyframes float-up{0%{opacity:0;transform:translateY(0) scale(1)}20%{opacity:0.6}80%{opacity:0.2}100%{opacity:0;transform:translateY(-60vh) scale(0.3)}}
.wayang-shadow{position:absolute;bottom:88px;width:74px;height:128px;z-index:2;opacity:.18;pointer-events:none;background:var(--hitam);clip-path:polygon(50% 0,61% 13%,58% 27%,74% 38%,62% 50%,78% 72%,60% 67%,55% 100%,45% 100%,40% 67%,22% 72%,38% 50%,26% 38%,42% 27%,39% 13%)}
.wayang-shadow.left{left:18px;transform:rotate(-8deg)}.wayang-shadow.right{right:18px;transform:scaleX(-1) rotate(-8deg)}
@media(max-width:380px){.gate-names{font-size:2.5rem}.jawa-ornament{width:96px;height:112px}.home-couple{font-size:1.8rem}.couple-photo{width:90px;height:90px}.gate::before,.gate::after{width:14px}.wayang-shadow{width:54px;height:96px}}
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
function jwImg($p) {
    if(!$p||str_contains($p,'placeholder')) return 'https://images.unsplash.com/photo-1519225421980-715cb0202128?w=800&fit=crop&q=80';
    return \Illuminate\Support\Str::startsWith($p,'http') ? $p : asset($p);
}
function jwImgPria($p) {
    if(!$p||str_contains($p,'placeholder')) return 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop&q=80';
    return \Illuminate\Support\Str::startsWith($p,'http') ? $p : asset($p);
}
function jwImgWanita($p) {
    if(!$p||str_contains($p,'placeholder')) return 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?w=400&h=400&fit=crop&q=80';
    return \Illuminate\Support\Str::startsWith($p,'http') ? $p : asset($p);
}
$pria    = $invitation->content['mempelai']['pria']   ?? [];
$wanita  = $invitation->content['mempelai']['wanita'] ?? [];
$akad    = $invitation->content['acara']['akad']      ?? [];
$resepsi = $invitation->content['acara']['resepsi']   ?? [];
$amplop  = $invitation->content['amplop']             ?? [];
$gallery = $invitation->content['media']['gallery']   ?? [
    'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800&fit=crop',
    'https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=400&fit=crop',
    'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=400&fit=crop',
    'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&fit=crop',
];
$stories = $invitation->content['love_stories'] ?? [
    ['year'=>'2021','title'=>'Pepanggihan','story'=>'Kaping pisan kepethuk ing adicara budaya, tatapan mripat loro loro kang nyawiji.'],
    ['year'=>'2022','title'=>'Tresna Tuwuh','story'=>'Saka kanca dadi kanca raket, banjur tresna mbangun asih kang jero.'],
    ['year'=>'2023','title'=>'Lamaran','story'=>'Ing sangisore langit kang biru, dheweke ngajakku urip bebarengan sak lawase.'],
];
$target = \Carbon\Carbon::parse($akad['waktu'] ?? now()->addDays(90));
@endphp

<div class="app">

    {{-- Particles --}}
    <div class="particles" id="particles"></div>

    {{-- Music --}}
    <audio id="bgAudio" loop>
        <source src="{{ asset($invitation->content['media']['music'] ?? 'assets/music/jawa-keraton.mp3') }}" type="audio/mpeg">
    </audio>
    <div class="music-fab" id="musicFab" onclick="toggleMusic()">♪</div>

    {{-- ▼▼▼ GATE / COVER ▼▼▼ --}}
    <div class="gate" id="gate">
        <div class="gate-half gate-left"></div>
        <div class="gate-half gate-right"></div>
        <div class="gate-center" id="gateContent">

            <div class="jawa-ornament" aria-hidden="true"><span class="kayon-line"></span></div>
            <p class="gate-eyebrow">PAWIWAHAN AGUNG</p>

            <div class="gate-divider-wrap" style="transform:translateY(-8px)">
                <div class="gate-divider"></div>
                <div class="gate-divider-dot"></div>
                <div class="gate-divider"></div>
            </div>

            <h1 class="gate-names">
                {{ $pria['panggilan'] ?? 'Raka' }} <span class="gate-amp">&amp;</span> {{ $wanita['panggilan'] ?? 'Sari' }}
            </h1>

            <div class="gate-divider-wrap" style="transform:translateY(8px)">
                <div class="gate-divider"></div>
                <div class="gate-divider-dot"></div>
                <div class="gate-divider"></div>
            </div>

            <p style="font-size:9px;letter-spacing:3px;color:var(--gold-l);opacity:.82;font-family:'Cinzel',serif;text-transform:uppercase">ꦱꦸꦒꦼꦁ ꦫꦮꦸꦃ</p>
            <br><br>

            <div class="gate-guest">
                <p class="gate-guest-eyebrow">ꦏꦼꦥꦝꦻ ꦪꦁ ꦠꦲꦸ</p>
                <p class="gate-guest-name">{{ $guest->name ?? 'Tamu Undangan' }}</p>
            </div>

            <button class="btn-buka" onclick="openSurat()">Buka Surat</button>
        </div>
    </div>

    {{-- ▼▼▼ PAGE: HOME ▼▼▼ --}}
    <div class="page active batik-bg" id="pg-home">
        <div class="wayang-shadow left" aria-hidden="true"></div>
        <div class="wayang-shadow right" aria-hidden="true"></div>
        <div class="home-hero" style="background-image:url('{{ jwImg($invitation->content['media']['cover'] ?? '') }}')"></div>
        <div class="home-card">
            <p style="font-size:9px;letter-spacing:5px;color:var(--gold);text-transform:uppercase;margin-bottom:8px;font-family:'Cinzel',serif">ꦋ Wilujeng Rawuh ꦋ</p>
            <h2 class="home-couple">{{ $pria['panggilan'] ?? 'Raka' }} <span class="home-amp">&amp;</span> {{ $wanita['panggilan'] ?? 'Sari' }}</h2>
            <div class="gold-line"></div>
            <div class="cd-grid" style="margin:12px 0">
                <div class="cd-box"><span class="cd-num" id="cdD">--</span><span class="cd-lbl">Dinten</span></div>
                <div class="cd-box"><span class="cd-num" id="cdH">--</span><span class="cd-lbl">Jam</span></div>
                <div class="cd-box"><span class="cd-num" id="cdM">--</span><span class="cd-lbl">Menit</span></div>
                <div class="cd-box"><span class="cd-num" id="cdS">--</span><span class="cd-lbl">Detik</span></div>
            </div>
        </div>
        <div class="gold-line"></div>
        <p class="home-quote">
            "{{ $invitation->content['quote'] ?? 'Loro-lorone atunggal, manunggaling kalbu ingkang suci lan tresna ingkang langgeng.' }}"
        </p>
        <p style="text-align:center;font-size:9px;letter-spacing:3px;color:var(--gold);opacity:0.6;padding-bottom:10px">✦ &nbsp;&nbsp; ✦ &nbsp;&nbsp; ✦</p>
    </div>

    {{-- ▼▼▼ PAGE: MEMPELAI ▼▼▼ --}}
    <div class="page" id="pg-mempelai">
        <div style="padding:36px 0 0;text-align:center">
            <h2 class="sec-title">Ingkang Kagungan Kersa</h2>
            <p class="sec-ornament">✦ &nbsp; ✦ &nbsp; ✦</p>
        </div>
        <div class="couple-split">
            <div class="couple-half">
                <img src="{{ jwImgPria($pria['foto'] ?? '') }}" class="couple-photo" alt="Mempelai Pria">
                <p class="couple-role">Mempelai Kakung</p>
                <h3 class="couple-name" style="color:var(--ivory)">{{ $pria['nama'] ?? 'Raka Wiratama, S.T.' }}</h3>
                <div class="gold-line"></div>
                <p class="couple-parents">
                    Putra saking<br>
                    <strong style="color:var(--ivory2)">Bp. {{ $pria['ayah'] ?? '...' }}</strong><br>
                    &amp; <strong style="color:var(--ivory2)">Ibu {{ $pria['ibu'] ?? '...' }}</strong>
                </p>
                @if(!empty($formatInstagram($pria['instagram'] ?? '')['username']))
                <a href="{{ $formatInstagram($pria['instagram'] ?? '')['url'] }}" target="_blank" rel="noopener noreferrer" style="margin-top:10px;color:var(--gold-l);font-size:11px;text-decoration:none">
                    IG &#64;{{ ltrim($pria['instagram'], '@') }}
                </a>
                @endif
            </div>
            <div class="couple-half">
                <img src="{{ jwImgWanita($wanita['foto'] ?? '') }}" class="couple-photo" alt="Mempelai Wanita">
                <p class="couple-role">Mempelai Putri</p>
                <h3 class="couple-name">{{ $wanita['nama'] ?? 'Sari Larasati, S.Pd.' }}</h3>
                <div class="gold-line"></div>
                <p class="couple-parents">
                    Putri saking<br>
                    <strong>Bp. {{ $wanita['ayah'] ?? '...' }}</strong><br>
                    &amp; <strong>Ibu {{ $wanita['ibu'] ?? '...' }}</strong>
                </p>
                @if(!empty($formatInstagram($wanita['instagram'] ?? '')['username']))
                <a href="{{ $formatInstagram($wanita['instagram'] ?? '')['url'] }}" target="_blank" rel="noopener noreferrer" style="margin-top:10px;color:var(--gold);font-size:11px;text-decoration:none">
                    IG &#64;{{ ltrim($wanita['instagram'], '@') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ▼▼▼ PAGE: KISAH ▼▼▼ --}}
    <div class="page batik-bg story-page" id="pg-kisah">
        <h2 class="sec-title">Lakon Asmara</h2>
        <p class="sec-ornament">✦ &nbsp; ✦ &nbsp; ✦</p>
        <div class="story-track">
            @foreach($stories as $s)
            @if(!empty($s['title']))
            <div class="story-card">
                <div class="story-dot"></div>
                <p class="story-year">{{ $s['year'] ?? '' }}</p>
                <h4 class="story-title">{{ $s['title'] ?? '' }}</h4>
                <p class="story-text">{{ $s['story'] ?? '' }}</p>
            </div>
            @endif
            @endforeach
        </div>
        <p style="text-align:center;font-size:9px;letter-spacing:3px;color:var(--sogan2);opacity:0.5;padding:0 0 16px">← Geser untuk selanjutnya →</p>
    </div>

    {{-- ▼▼▼ PAGE: ACARA ▼▼▼ --}}
    <div class="page batik-bg event-page" id="pg-acara">
        <h2 class="sec-title">Adicara Pawiwahan</h2>
        <p class="sec-ornament">✦ &nbsp; ✦ &nbsp; ✦</p>

        {{-- Akad --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAcc(0)">
                <div>
                    <p style="font-size:9px;letter-spacing:3px;color:var(--gold);font-family:'Cinzel',serif;text-transform:uppercase;margin-bottom:2px">I.</p>
                    <span class="accordion-title">{{ $akad['judul'] ?? 'Akad Nikah' }}</span>
                </div>
                <span class="accordion-chevron" id="chev0">▾</span>
            </button>
            <div class="accordion-body open" id="acc0">
                <div class="accordion-inner">
                    <div class="ev-detail"><span class="ev-icon">◈</span><span>{{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->translatedFormat('l, d F Y') }}</span></div>
                    <div class="ev-detail"><span class="ev-icon">◈</span><span>Pukul {{ \Carbon\Carbon::parse($akad['waktu'] ?? now())->format('H:i') }} WIB</span></div>
                    <div class="ev-detail"><span class="ev-icon">◈</span><span>{{ $akad['tempat'] ?? 'Pendopo Kediaman' }}@if(!empty($akad['alamat'])), {{ $akad['alamat'] }}@endif</span></div>
                    @php
                        $akadW = $invitation->content['acara']['akad']['wilayah'] ?? [];
                        $akadL1 = collect([!empty($akadW['village']) ? 'Kel. '.Str::title(strtolower($akadW['village'])) : null, !empty($akadW['district']) ? 'Kec. '.Str::title(strtolower($akadW['district'])) : null])->filter()->implode(', ');
                        $akadL2 = collect([!empty($akadW['regency']) ? Str::title(strtolower($akadW['regency'])) : null, !empty($akadW['province']) ? Str::title(strtolower($akadW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($akadL1)<div class="ev-detail" style="padding-left: 26px;"><span>{{ $akadL1 }}</span></div>@endif
                    @if($akadL2)<div class="ev-detail" style="padding-left: 26px;"><span>{{ $akadL2 }}</span></div>@endif
                    @if(!empty($akad['maps'] ?? null) || !empty($akad['alamat'] ?? null))
                    @php
                        $maps = $akad['maps'] ?? $akad['alamat'];
                        $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                            ? $maps 
                            : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                    @endphp
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-maps-jawa">◈ &nbsp; Peta Lokasi</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Resepsi --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAcc(1)">
                <div>
                    <p style="font-size:9px;letter-spacing:3px;color:var(--gold);font-family:'Cinzel',serif;text-transform:uppercase;margin-bottom:2px">II.</p>
                    <span class="accordion-title">{{ $resepsi['judul'] ?? 'Resepsi' }}</span>
                </div>
                <span class="accordion-chevron" id="chev1">▾</span>
            </button>
            <div class="accordion-body" id="acc1">
                <div class="accordion-inner">
                    <div class="ev-detail"><span class="ev-icon">◈</span><span>{{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->translatedFormat('l, d F Y') }}</span></div>
                    <div class="ev-detail"><span class="ev-icon">◈</span><span>Pukul {{ \Carbon\Carbon::parse($resepsi['waktu'] ?? now())->format('H:i') }} WIB</span></div>
                    <div class="ev-detail"><span class="ev-icon">◈</span><span>{{ $resepsi['tempat'] ?? 'Pendopo Kediaman' }}@if(!empty($resepsi['alamat'])), {{ $resepsi['alamat'] }}@endif</span></div>
                    @php
                        $resepsiW = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                        $resepsiL1 = collect([!empty($resepsiW['village']) ? 'Kel. '.Str::title(strtolower($resepsiW['village'])) : null, !empty($resepsiW['district']) ? 'Kec. '.Str::title(strtolower($resepsiW['district'])) : null])->filter()->implode(', ');
                        $resepsiL2 = collect([!empty($resepsiW['regency']) ? Str::title(strtolower($resepsiW['regency'])) : null, !empty($resepsiW['province']) ? Str::title(strtolower($resepsiW['province'])) : null])->filter()->implode(', ');
                    @endphp
                    @if($resepsiL1)<div class="ev-detail" style="padding-left: 26px;"><span>{{ $resepsiL1 }}</span></div>@endif
                    @if($resepsiL2)<div class="ev-detail" style="padding-left: 26px;"><span>{{ $resepsiL2 }}</span></div>@endif
                    @if(!empty($resepsi['maps'] ?? null) || !empty($resepsi['alamat'] ?? null))
                    @php
                        $maps = $resepsi['maps'] ?? $resepsi['alamat'];
                        $mapsUrl = (str_starts_with($maps, 'http://') || str_starts_with($maps, 'https://')) 
                            ? $maps 
                            : "https://www.google.com/maps/search/?api=1&query=" . urlencode($maps);
                    @endphp
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-maps-jawa">◈ &nbsp; Peta Lokasi</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Pakaian info --}}
        @php
            $dress = $invitation->content['acara']['dresscode'] ?? [];
            $dressJudul = trim($dress['judul'] ?? '');
            $dressInfo = trim($dress['info'] ?? '');
        @endphp
        @if($dressJudul !== '' || $dressInfo !== '')
        <div style="margin:20px 16px;padding:16px;background:rgba(184,134,26,0.08);border:1px solid var(--border);text-align:center">
            <p style="font-family:'Cinzel',serif;font-size:8px;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:6px">Dresscode</p>
            @if($dressJudul !== '')<p style="font-family:'Cormorant Garamond',serif;font-style:italic;font-size:1.1rem;color:var(--sogan)">{{ $dressJudul }}</p>@endif
            @if($dressInfo !== '')<p style="font-size:10px;color:var(--sogan2);opacity:0.7;margin-top:4px">{{ $dressInfo }}</p>@endif
        </div>
        @endif
    </div>

    {{-- ▼▼▼ PAGE: GALERI ▼▼▼ --}}
    <div class="page" id="pg-galeri" style="padding-top:36px">
        <h2 class="sec-title">Pepotoan</h2>
        <p class="sec-ornament">✦ &nbsp; ✦ &nbsp; ✦</p>
        <div class="gallery-grid">
            @foreach($gallery as $foto)
            <div class="gallery-item">
                <img src="{{ jwImg($foto) }}" class="gallery-img" alt="">
            </div>
            @endforeach
        </div>
    </div>

    {{-- ▼▼▼ PAGE: UCAPAN & GIFT ▼▼▼ --}}
    <div class="page batik-bg wishes-page" id="pg-ucapan">
        <h2 class="sec-title">Atur Sungkem</h2>
        <p class="sec-ornament">✦ &nbsp; ✦ &nbsp; ✦</p>

        @if(!empty($amplop['bank_name']))
        <div class="gift-strip">
            <p class="gift-bank">✦ &nbsp; {{ $amplop['bank_name'] }} &nbsp; ✦</p>
            <p class="gift-num" id="giftNum">{{ $amplop['account_number'] ?? '000 000 0000' }}</p>
            <p class="gift-holder">a/n {{ $amplop['account_holder'] ?? 'Nama Penerima' }}</p>
            <button class="btn-copy-jawa" onclick="copyGift()">◈ &nbsp; Salin Nomor</button>
            @if(isset($amplop['qris_image']))
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed rgba(184,134,26,0.5);">
                <p style="font-family:'Cinzel',serif;font-size:9px;color:var(--gold);margin-bottom:10px;letter-spacing:1px;">ATAU PINDAI QRIS</p>
                <img src="{{ asset($amplop['qris_image']) }}" alt="QRIS" style="width: 140px; height: 140px; object-fit: contain; border-radius: 4px; border: 2px solid var(--gold); padding: 4px; background: white; margin: 0 auto;">
            </div>
            @endif
        </div>
        @endif

        <div style="padding:0 16px 16px">
            @if(session('success'))
            <div style="background:rgba(184,134,26,0.1);border:1px solid var(--border);color:var(--sogan);padding:10px;margin-bottom:14px;font-size:12px;text-align:center">{{ session('success') }}</div>
            @endif
            <form action="{{ route('kirim.ucapan') }}" method="POST">
                @csrf
                <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
                <input type="text" name="nama" class="form-input-jawa" placeholder="Asma panjenengan" required>
                <select name="kehadiran" class="form-input-jawa">
                    <option value="hadir">Kula badhe rawuh ✓</option>
                    <option value="tidak_hadir">Nyuwun pangapunten, mboten saged</option>
                    <option value="ragu">Dereng saged masteni</option>
                </select>
                <textarea name="ucapan" rows="3" class="form-input-jawa" placeholder="Atur pangestunipun..." required style="resize:none"></textarea>
                <button type="submit" class="btn-kirim">✦ &nbsp; Kirim Ucapan &nbsp; ✦</button>
            </form>
        </div>

        @if($invitation->comments->count() > 0)
        <div style="padding:0 16px">
            <p style="font-family:'Cinzel',serif;font-size:9px;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:12px">✦ Ucapan Tamu ✦</p>
            @foreach($invitation->comments->sortByDesc('created_at') as $c)
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
    </div>

    {{-- RADIAL NAV --}}
    <nav class="radial-nav" id="radialNav" style="z-index: 10000; pointer-events: auto;">
        <div class="radial-bar">
            <button class="nav-btn active" id="nb-home" onclick="goPage('home',this)">
                <span class="nav-icon">⌂</span><span>Griyo</span>
            </button>
            <button class="nav-btn" id="nb-mempelai" onclick="goPage('mempelai',this)">
                <span class="nav-icon">♡</span><span>Mempelai</span>
            </button>
            <button class="nav-btn" id="nb-kisah" onclick="goPage('kisah',this)">
                <span class="nav-icon">◎</span><span>Lakon</span>
            </button>
            <button class="nav-btn" id="nb-acara" onclick="goPage('acara',this)">
                <span class="nav-icon">❖</span><span>Acara</span>
            </button>
            <button class="nav-btn" id="nb-galeri" onclick="goPage('galeri',this)">
                <span class="nav-icon">⊞</span><span>Pepotoan</span>
            </button>
            <button class="nav-btn" id="nb-ucapan" onclick="goPage('ucapan',this)">
                <span class="nav-icon">✉</span><span>Sungkem</span>
            </button>
        </div>
    </nav>
</div>

<div class="toast" id="toast"></div>

<script>
// ── Particles ────────────────────────────────────────
(function(){
    const c = document.getElementById('particles');
    for(let i=0;i<18;i++){
        const p=document.createElement('div');
        p.className='particle';
        p.style.left=Math.random()*100+'%';
        p.style.top=Math.random()*100+'%';
        p.style.animationDelay=(Math.random()*8)+'s';
        p.style.animationDuration=(6+Math.random()*6)+'s';
        p.style.width=p.style.height=(1+Math.random()*3)+'px';
        p.style.opacity='0';
        c.appendChild(p);
    }
})();

// ── Open Gate ────────────────────────────────────────
function openSurat(){
    const gate = document.getElementById('gate');
    const gc   = document.getElementById('gateContent');
    gc.classList.add('hide');
    gate.style.pointerEvents = 'none';
    setTimeout(()=>{ gate.classList.add('open'); },300);
    setTimeout(()=>{
        gate.style.display = 'none';
        document.getElementById('radialNav').classList.add('show');
        document.getElementById('musicFab').classList.add('show');
        const a = document.getElementById('bgAudio');
        if(a) a.play().catch(()=>{});
    }, 1200);
}

// ── Navigation ───────────────────────────────────────
function goPage(id, btn){
    document.querySelectorAll('.page').forEach(p=>p.classList.toggle('active', p.id === 'pg-'+id));
    document.querySelectorAll('.nav-btn').forEach(b=>b.classList.remove('active'));
    const pg = document.getElementById('pg-'+id);
    if(pg){pg.scrollTop=0;}
    if(btn) btn.classList.add('active');
}

// ── Music ────────────────────────────────────────────
function toggleMusic(){
    const a=document.getElementById('bgAudio');
    const f=document.getElementById('musicFab');
    if(!a) return;
    if(a.paused){a.play();f.classList.add('playing');}
    else{a.pause();f.classList.remove('playing');}
}

// ── Accordion ────────────────────────────────────────
function toggleAcc(i){
    const body=document.getElementById('acc'+i);
    const chev=document.getElementById('chev'+i);
    const isOpen=body.classList.contains('open');
    document.querySelectorAll('.accordion-body').forEach(b=>b.classList.remove('open'));
    document.querySelectorAll('.accordion-chevron').forEach(c=>c.style.transform='');
    if(!isOpen){body.classList.add('open');chev.style.transform='rotate(180deg)';}
}

// ── Countdown ────────────────────────────────────────
const tgt=new Date("{{ $target->format('Y-m-d H:i:s') }}").getTime();
setInterval(()=>{
    const diff=tgt-Date.now();
    if(diff<=0) return;
    const pad=v=>String(Math.floor(v)).padStart(2,'0');
    document.getElementById('cdD').textContent=pad(diff/864e5);
    document.getElementById('cdH').textContent=pad((diff%864e5)/36e5);
    document.getElementById('cdM').textContent=pad((diff%36e5)/6e4);
    document.getElementById('cdS').textContent=pad((diff%6e4)/1e3);
},1000);

// ── Copy gift ────────────────────────────────────────
function copyGift(){
    const t=document.getElementById('giftNum')?.innerText;
    if(t) navigator.clipboard.writeText(t).then(()=>showToast('Nomor rekening disalin ✓'));
}

// ── Toast ────────────────────────────────────────────
function showToast(msg){
    const t=document.getElementById('toast');
    t.textContent=msg;t.classList.add('show');
    setTimeout(()=>t.classList.remove('show'),2500);
}
</script>
</body>
</html>
