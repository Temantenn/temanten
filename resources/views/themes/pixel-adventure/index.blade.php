<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Adventure - {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* PIXEL ADVENTURE THEME STYLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Press Start 2P', monospace;
            background: #121225;
            color: #fff;
            overflow-x: hidden;
            overflow-y: auto;
            line-height: 1.6;
            min-height: 100dvh;
            margin: 0;
            padding: 0;
        }
        
        /* Desktop wrapper - dark background */
        .pixel-page {
            min-height: 100dvh;
            background: #121225;
            display: flex;
            justify-content: center;
            align-items: stretch;
            overflow: hidden;
        }
        
        /* Mobile phone frame - game container */
        .pixel-phone {
            width: 100%;
            max-width: 430px;
            min-height: 100dvh;
            height: 100dvh;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            background: #87ceeb;
            box-shadow: 0 0 50px rgba(0,0,0,0.8);
        }
        
        @media (max-width: 430px) {
            .pixel-phone {
                max-width: none;
                width: 100vw;
                box-shadow: none;
            }
        }
        
        /* Game world viewport - contains all scenes */
        .game-world {
            position: absolute;
            inset: 0;
            overflow: hidden;
            background: linear-gradient(180deg, #5b9bd5 0%, #87ceeb 40%, #98d8c8 70%, #6b8e23 85%, #556b2f 100%);
        }
        
        .game-world::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px),
                repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px);
            pointer-events: none;
            z-index: 1;
        }
        
        /* Pixel Clouds */
        .clouds {
            position: absolute;
            top: 80px;
            left: 0;
            right: 0;
            height: 100px;
            z-index: 1;
        }
        
        .cloud {
            position: absolute;
            background: #fff;
            opacity: 0.9;
            animation: cloudDrift 30s linear infinite;
        }
        
        .cloud-1 {
            width: 60px;
            height: 20px;
            top: 20px;
            left: 10%;
            box-shadow: 
                20px 0 0 #fff,
                -20px 0 0 #fff,
                0 -8px 0 #fff,
                20px -8px 0 #fff;
        }
        
        .cloud-2 {
            width: 40px;
            height: 16px;
            top: 50px;
            left: 60%;
            animation-delay: -15s;
            box-shadow: 
                16px 0 0 #fff,
                -16px 0 0 #fff,
                0 -6px 0 #fff;
        }
        
        @keyframes cloudDrift {
            0% { transform: translateX(0); }
            100% { transform: translateX(100px); }
        }
        
        /* Mountains */
        .mountains {
            position: absolute;
            bottom: 120px;
            left: 0;
            right: 0;
            height: 150px;
            z-index: 1;
        }
        
        .mountain {
            position: absolute;
            bottom: 0;
            width: 0;
            height: 0;
            border-left: 80px solid transparent;
            border-right: 80px solid transparent;
            border-bottom: 120px solid #4a7c59;
        }
        
        .mountain-1 {
            left: -20px;
            opacity: 0.6;
        }
        
        .mountain-2 {
            left: 100px;
            border-bottom-color: #5a8c69;
            opacity: 0.7;
        }
        
        .mountain-3 {
            right: 50px;
            border-bottom-color: #3a6c49;
            opacity: 0.5;
        }
        
        @keyframes cloudFloat {
            0% { transform: translateX(0); }
            100% { transform: translateX(100px); }
        }
        
        /* Ground Layer */
        .ground-layer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(180deg, #6b8e23 0%, #556b2f 50%, #3d5a1f 100%);
            border-top: 4px solid #4a7023;
            z-index: 3;
        }
        
        .ground-layer::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 0;
            right: 0;
            height: 8px;
            background: repeating-linear-gradient(90deg, #4a7023 0px, #4a7023 8px, transparent 8px, transparent 16px);
        }
        
        /* Grass decoration */
        .grass {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            z-index: 4;
        }
        
        .grass-blade {
            position: absolute;
            bottom: 0;
            width: 4px;
            height: 12px;
            background: #7cb342;
        }
        
        .grass-blade:nth-child(1) { left: 10%; }
        .grass-blade:nth-child(2) { left: 25%; height: 16px; }
        .grass-blade:nth-child(3) { left: 40%; height: 10px; }
        .grass-blade:nth-child(4) { left: 55%; height: 14px; }
        .grass-blade:nth-child(5) { left: 70%; height: 12px; }
        .grass-blade:nth-child(6) { left: 85%; height: 16px; }
        
        /* Flowers */
        .flower {
            position: absolute;
            bottom: 15px;
            width: 8px;
            height: 8px;
            background: #ff69b4;
            border-radius: 50%;
            z-index: 4;
        }
        
        .flower::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 3px;
            width: 2px;
            height: 10px;
            background: #7cb342;
        }
        
        .flower-1 { left: 15%; }
        .flower-2 { left: 45%; background: #ffd700; }
        .flower-3 { left: 75%; background: #ff1493; }
        .flower-4 { left: 30%; bottom: 18px; background: #ff6b6b; }
        .flower-5 { left: 60%; bottom: 16px; background: #00ffff; }
        
        /* Pixel Trees */
        .pixel-tree {
            position: absolute;
            bottom: 100px;
            width: 32px;
            height: 48px;
            z-index: 2;
        }
        
        .pixel-tree::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 12px;
            width: 8px;
            height: 20px;
            background: #8b4513;
            border: 2px solid #000;
        }
        
        .pixel-tree::after {
            content: '';
            position: absolute;
            top: 0;
            left: 4px;
            width: 24px;
            height: 24px;
            background: #228b22;
            border: 2px solid #000;
            border-radius: 50%;
        }
        
        .tree-left { left: 5%; }
        .tree-right { right: 5%; }
        
        /* Sun */
        .sun {
            position: absolute;
            top: 50px;
            right: 50px;
            width: 40px;
            height: 40px;
            background: #ffd700;
            border-radius: 50%;
            border: 3px solid #000;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
            z-index: 2;
        }
        
        .sun::before,
        .sun::after {
            content: '';
            position: absolute;
            background: #ffd700;
            border: 2px solid #000;
        }
        
        /* Sun rays - horizontal */
        .sun::before {
            width: 50px;
            height: 4px;
            top: 18px;
            left: -5px;
        }
        
        /* Sun rays - vertical */
        .sun::after {
            width: 4px;
            height: 50px;
            top: -5px;
            left: 18px;
        }
        
        /* Pixel Birds */
        .birds {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 150px;
            z-index: 2;
            pointer-events: none;
        }
        
        .bird {
            position: absolute;
            width: 12px;
            height: 4px;
            animation: birdFly 8s linear infinite;
        }
        
        .bird::before,
        .bird::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 2px;
            background: #333;
            top: 0;
            border-radius: 50% 50% 0 0;
        }
        
        .bird::before {
            left: 0;
            transform-origin: right bottom;
            animation: wingFlap 0.4s ease-in-out infinite alternate;
        }
        
        .bird::after {
            right: 0;
            transform-origin: left bottom;
            animation: wingFlap 0.4s ease-in-out infinite alternate-reverse;
        }
        
        .bird:nth-child(1) { top: 15%; left: -20px; animation-delay: 0s; animation-duration: 10s; }
        .bird:nth-child(2) { top: 25%; left: -40px; animation-delay: 2s; animation-duration: 12s; }
        .bird:nth-child(3) { top: 10%; left: -30px; animation-delay: 4s; animation-duration: 9s; }
        
        @keyframes birdFly {
            0% { transform: translateX(0); }
            100% { transform: translateX(500px); }
        }
        
        @keyframes wingFlap {
            0% { transform: rotate(-30deg); }
            100% { transform: rotate(30deg); }
        }
        
        /* Gate Screen */
        #gate {
            position: absolute;
            inset: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            transition: opacity 0.5s, visibility 0.5s;
        }
        
        #gate.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        
        .pixel-title {
            font-size: 1.5rem;
            color: #ffd700;
            text-shadow: 4px 4px 0 #ff1493, 8px 8px 0 #00ffff;
            margin-bottom: 2rem;
            text-align: center;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .pixel-btn {
            background: #ffd700;
            color: #000;
            border: 4px solid #000;
            padding: 1rem 2rem;
            font-size: 0.75rem;
            cursor: pointer;
            box-shadow: 6px 6px 0 #000;
            transition: all 0.1s;
            text-transform: uppercase;
        }
        
        .pixel-btn:hover {
            transform: translate(2px, 2px);
            box-shadow: 4px 4px 0 #000;
        }
        
        .pixel-btn:active {
            transform: translate(6px, 6px);
            box-shadow: 0 0 0 #000;
        }
        
        /* Scene track - horizontal scroll container */
        .scene-track {
            display: flex;
            height: 100%;
            transition: transform 0.45s ease;
            will-change: transform;
        }
        
        .scene {
            flex: 0 0 100%;
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem 8rem;
        }
        
        /* Navigation Arrows - inside frame */
        .nav-arrow {
            position: absolute;
            top: 55%;
            transform: translateY(-50%);
            z-index: 55;
            background: rgba(255, 215, 0, 0.95);
            border: 3px solid #000;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            box-shadow: 3px 3px 0 #000;
            transition: all 0.1s;
        }
        
        .nav-arrow:hover {
            transform: translateY(-50%) scale(1.05);
        }
        
        .nav-arrow:active {
            transform: translateY(-50%) scale(0.95);
            box-shadow: 1px 1px 0 #000;
        }
        
        .nav-arrow.left {
            left: 12px;
        }
        
        .nav-arrow.right {
            right: 12px;
        }
        
        .nav-arrow.hidden {
            display: none;
        }
        
        /* Interactive Objects - Enhanced Pixel Style */
        .interactive-object {
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.9) 0%, rgba(101, 67, 33, 0.9) 100%);
            border: 3px solid #000;
            box-shadow:
                inset -3px -3px 0 rgba(0,0,0,0.3),
                inset 3px 3px 0 rgba(255,255,255,0.2),
                3px 3px 0 #000,
                0 0 15px rgba(255, 215, 0, 0.3);
            padding: 0.6rem 0.8rem;
            margin: 0.4rem;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            max-width: 115px;
            min-width: 95px;
            position: relative;
            animation: objectBounce 2s ease-in-out infinite;
        }
        
        @keyframes objectBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        .interactive-object::before {
            content: 'TAP';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background: #ff1493;
            color: #fff;
            padding: 2px 8px;
            font-size: 0.4rem;
            border: 2px solid #000;
            animation: tapBlink 1s ease-in-out infinite;
        }
        
        @keyframes tapBlink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .interactive-object:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 
                inset -4px -4px 0 rgba(0,0,0,0.3),
                inset 4px 4px 0 rgba(255,255,255,0.2),
                6px 6px 0 #000,
                0 0 40px rgba(255, 215, 0, 0.8);
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.9) 0%, rgba(218, 165, 32, 0.9) 100%);
            animation: none;
        }
        
        .interactive-object.visited::before {
            content: '✓';
            background: #00ff00;
        }
        
        .interactive-object .icon {
            font-size: 1.6rem;
            margin-bottom: 0.25rem;
            filter: drop-shadow(2px 2px 0 #000);
        }

        .romantic-frame-icon {
            width: 92px;
            height: 78px;
            margin: 0 auto 0.45rem;
            position: relative;
            border: 4px solid #000;
            background: linear-gradient(180deg, #ff8fb8 0%, #ff5c93 55%, #d7266a 100%);
            box-shadow:
                inset -4px -4px 0 rgba(0,0,0,0.22),
                inset 4px 4px 0 rgba(255,255,255,0.35),
                5px 5px 0 #000;
        }

        .romantic-frame-icon::before,
        .romantic-frame-icon::after {
            content: '';
            position: absolute;
            top: -14px;
            width: 22px;
            height: 22px;
            background: #ff1493;
            border: 3px solid #000;
            transform: rotate(45deg);
            box-shadow: 2px 2px 0 rgba(0,0,0,0.35);
        }

        .romantic-frame-icon::before {
            left: 18px;
        }

        .romantic-frame-icon::after {
            right: 18px;
        }

        .romantic-frame-photo {
            position: absolute;
            top: 15px;
            width: 28px;
            height: 42px;
            background: linear-gradient(180deg, #ffe9f3 0%, #ffc3d8 100%);
            border: 3px solid #000;
            overflow: hidden;
        }

        .romantic-frame-photo.left {
            left: 14px;
        }

        .romantic-frame-photo.right {
            right: 14px;
        }

        .romantic-frame-photo::before {
            content: '';
            position: absolute;
            top: 7px;
            left: 50%;
            width: 12px;
            height: 12px;
            background: #5b2a86;
            border-radius: 50%;
            transform: translateX(-50%);
            box-shadow: 0 0 0 2px #3b1760;
        }

        .romantic-frame-photo::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -6px;
            width: 28px;
            height: 26px;
            background: #6d3bb7;
            border-radius: 12px 12px 0 0;
            transform: translateX(-50%);
            box-shadow: inset -4px -3px 0 rgba(0,0,0,0.22);
        }

        .romantic-frame-sparkle {
            position: absolute;
            top: 32px;
            left: 50%;
            width: 8px;
            height: 8px;
            background: #ffd700;
            border: 2px solid #000;
            transform: translateX(-50%) rotate(45deg);
            box-shadow:
                -30px -18px 0 -2px #fff4a8,
                30px -18px 0 -2px #fff4a8;
        }
        
        .interactive-object .label {
            font-size: 0.4rem;
            color: #fff;
            text-shadow: 2px 2px 0 #000;
            letter-spacing: 0.5px;
            line-height: 1.4;
        }
        
        /* HUD - Quest System - compact inside frame */
        .hud {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.92);
            border: 2px solid #ffd700;
            padding: 0.35rem 0.5rem;
            z-index: 50;
            box-shadow: 2px 2px 0 #000;
            max-width: calc(100% - 20px);
        }
        
        .hud-title {
            font-size: 0.42rem;
            color: #ffd700;
            margin-bottom: 0.4rem;
            text-align: center;
        }
        
        .hud-quest {
            font-size: 0.35rem;
            color: #fff;
            line-height: 1.5;
            text-align: center;
        }
        
        .hud-progress {
            display: flex;
            gap: 0.25rem;
            margin-top: 0.4rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .hud-item {
            font-size: 0.32rem;
            padding: 0.18rem 0.35rem;
            background: rgba(255,255,255,0.1);
            border: 2px solid #666;
            color: #666;
            white-space: nowrap;
        }
        
        .hud-item.completed {
            background: #00ff00;
            border-color: #00ff00;
            color: #000;
        }
        
        /* Modal - RPG Dialog Style */
        .modal {
            position: absolute;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.92);
            padding: 1rem;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border: 5px solid #000;
            box-shadow:
                inset 0 0 0 3px #ffd700,
                inset 0 0 0 6px #000,
                6px 6px 0 #000,
                0 0 40px rgba(255, 215, 0, 0.5);
            padding: 0;
            max-width: calc(100% - 28px);
            width: 90%;
            max-height: 80dvh;
            position: relative;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #ffd700, #daa520);
            border-bottom: 4px solid #000;
            padding: 0.8rem 1rem;
            position: relative;
        }
        
        .modal-body {
            padding: 1.5rem;
            max-height: calc(80vh - 60px);
            overflow-y: auto;
        }
        
        .modal-body::-webkit-scrollbar {
            width: 12px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #000;
            border: 2px solid #ffd700;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: #ffd700;
            border: 2px solid #000;
        }
        
        .modal-close {
            position: absolute;
            top: 50%;
            right: 0.5rem;
            transform: translateY(-50%);
            background: #ff1493;
            color: #fff;
            border: 3px solid #000;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            box-shadow: 3px 3px 0 #000;
            transition: all 0.1s;
        }
        
        .modal-close:hover {
            background: #ff69b4;
            transform: translateY(-50%) scale(1.1);
        }
        
        .modal-close:active {
            transform: translateY(-50%) scale(0.95);
            box-shadow: 1px 1px 0 #000;
        }
        
        .modal-title {
            font-size: 0.7rem;
            color: #000;
            text-align: center;
            text-shadow: 2px 2px 0 rgba(255,255,255,0.5);
            letter-spacing: 2px;
        }
        
        /* Pixel Characters */
        .pixel-character {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            border: 3px solid #000;
            position: relative;
            margin: 1rem;
            box-shadow: 4px 4px 0 #000;
        }
        
        .pixel-character::before {
            content: '👤';
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        
        /* Form Styles */
        .pixel-input,
        .pixel-textarea,
        .pixel-select {
            width: 100%;
            background: #000;
            color: #ffd700;
            border: 3px solid #ffd700;
            padding: 0.75rem;
            font-family: 'Press Start 2P', monospace;
            font-size: 0.6rem;
            margin-bottom: 1rem;
        }
        
        .pixel-textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .pixel-label {
            display: block;
            color: #ffd700;
            font-size: 0.6rem;
            margin-bottom: 0.5rem;
        }
        
        /* Couple Detail Modal */
        .couple-detail {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-align: left;
        }
        
        .couple-detail-photo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #ffd700;
            flex: 0 0 150px;
            box-shadow: 4px 4px 0 #000;
        }
        
        .couple-detail-info {
            flex: 1;
            min-width: 0;
        }
        
        .couple-detail-name {
            font-size: 0.8rem;
            color: #ffd700;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }
        
        .couple-detail-parents {
            font-size: 0.5rem;
            color: #fff;
            line-height: 1.8;
            margin-bottom: 1rem;
        }
        
        /* Photo Gallery */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .photo-item {
            aspect-ratio: 1;
            overflow: hidden;
            border: 3px solid #ffd700;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .photo-item:hover {
            transform: scale(1.05);
        }
        
        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .countdown-panel,
        .story-card,
        .video-frame,
        .empty-state,
        .gift-address-card {
            background: rgba(0,0,0,0.6);
            border: 3px solid #ffd700;
            box-shadow: 4px 4px 0 #000;
            padding: 1rem;
            margin: 1rem 0;
        }

        .event-scene-content {
            width: 100%;
            max-width: 390px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.2rem;
            position: relative;
            z-index: 20;
        }

        .event-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: stretch;
            position: relative;
            z-index: 30;
        }

        .countdown-panel {
            width: min(100%, 330px);
            padding: 0.75rem;
            margin: 0;
            position: relative;
            z-index: 20;
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.35rem;
            margin-top: 0.65rem;
        }

        .countdown-item {
            background: #000;
            border: 3px solid #00ffff;
            padding: 0.45rem 0.2rem;
            text-align: center;
            min-width: 0;
        }

        .countdown-number {
            display: block;
            color: #ffd700;
            font-size: 0.62rem;
            margin-bottom: 0.25rem;
        }

        .countdown-label {
            display: block;
            color: #fff;
            font-size: 0.3rem;
        }

        .story-year {
            display: inline-block;
            background: #ff1493;
            color: #fff;
            border: 2px solid #000;
            padding: 0.25rem 0.5rem;
            font-size: 0.45rem;
            margin-bottom: 0.7rem;
        }

        .story-title {
            color: #ffd700;
            font-size: 0.65rem;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .story-text,
        .empty-state {
            color: #fff;
            font-size: 0.5rem;
            line-height: 1.8;
        }

        .video-frame {
            aspect-ratio: 16 / 9;
            padding: 0;
            overflow: hidden;
        }

        .video-frame iframe {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }

        .cover-preview {
            width: 170px;
            height: 110px;
            object-fit: cover;
            border: 4px solid #ffd700;
            box-shadow: 5px 5px 0 #000;
            margin: 0 auto 1rem;
            display: block;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .couple-detail {
                flex-direction: column;
                text-align: center;
            }
            
            .couple-detail-photo {
                flex-basis: auto;
            }
            
            .pixel-title {
                font-size: 1rem;
            }
            
            .modal-content {
                padding: 1.5rem;
            }
            
            .modal-title {
                font-size: 0.8rem;
            }
            
            .interactive-object {
                padding: 1rem;
                margin: 0.5rem;
            }
            
            .nav-arrow {
                width: 40px;
                height: 40px;
            }
        }
        
        /* Music Button - inside frame top right */
        .music-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 60;
            background: #ffd700;
            border: 3px solid #000;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 3px 3px 0 #000;
            animation: pulse 2s infinite;
            font-size: 1.2rem;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .music-btn.paused {
            animation: none;
            opacity: 0.7;
        }
        
        .music-btn:active {
            transform: scale(0.95);
            box-shadow: 1px 1px 0 #000;
        }
        
        /* Copy Button */
        .copy-btn {
            background: #00ffff;
            color: #000;
            border: 3px solid #000;
            padding: 0.5rem 1rem;
            font-size: 0.6rem;
            cursor: pointer;
            box-shadow: 3px 3px 0 #000;
            margin-top: 0.5rem;
            font-family: 'Press Start 2P', monospace;
        }
        
        .copy-btn:hover {
            transform: translate(1px, 1px);
            box-shadow: 2px 2px 0 #000;
        }
        
        /* Scene Indicators - inside frame bottom */
        .scene-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 55;
            display: flex;
            gap: 0.4rem;
        }
        
        .scene-dot {
            width: 14px;
            height: 14px;
            background: rgba(255, 255, 255, 0.25);
            border: 2px solid #000;
            box-shadow: inset 0 0 0 2px #ffd700;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .scene-dot:hover {
            transform: scale(1.15);
            background: rgba(255, 215, 0, 0.5);
        }
        
        .scene-dot.active {
            background: #ffd700;
            box-shadow:
                inset 0 0 0 2px #fff,
                0 0 8px #ffd700;
            animation: dotPulse 1s ease-in-out infinite;
        }
        
        @keyframes dotPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }
        
        /* Pixel Characters */
        .pixel-character {
            position: absolute;
            bottom: 105px;
            width: 40px;
            height: 56px;
            transition: all 0.5s ease;
            z-index: 10;
            animation: characterIdle 2s ease-in-out infinite;
        }
        
        @keyframes characterIdle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }
        
        .pixel-character.groom {
            left: 38%;
        }
        
        .pixel-character.bride {
            right: 38%;
        }
        
        /* Pixel Objects SVG Styles */
        .pixel-house {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
        }
        
        .pixel-board {
            width: 70px;
            height: 70px;
            margin: 0 auto 1rem;
        }
        
        .pixel-chest {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
        }
        
        .pixel-mailbox {
            width: 50px;
            height: 60px;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>

@php
    // Helper functions
    $formatInstagram = function ($value) {
        $value = trim((string) ($value ?? ''));
        if ($value === '') {
            return ['username' => '', 'display' => '', 'url' => ''];
        }
        
        $value = preg_replace('/^https?:\/\/(www\.)?instagram\.com\//i', '', $value);
        $value = preg_replace('/^instagram\.com\//i', '', $value);
        $value = ltrim($value, '@');
        $value = strtok($value, '?/#');
        $value = trim((string) $value);
        
        return [
            'username' => $value,
            'display' => $value !== '' ? '@' . $value : '',
            'url' => $value !== '' ? 'https://instagram.com/' . $value : '',
        ];
    };
    
    $mapsUrl = function ($maps, $alamat) {
        $maps = trim((string) ($maps ?? ''));
        $alamat = trim((string) ($alamat ?? ''));
        $target = $maps !== '' ? $maps : $alamat;
        
        if ($target === '') {
            return '';
        }
        
        return Str::startsWith($target, ['http://', 'https://'])
            ? $target
            : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($target);
    };
    
    $getParentName = function ($person, $parent) {
        $person = is_array($person) ? $person : [];
        $legacyKey = $parent === 'ayah' ? 'nama_ayah' : 'nama_ibu';

        return trim((string) ($person[$parent] ?? $person[$legacyKey] ?? ''));
    };

    $formatEventDateTime = function ($event) {
        $event = is_array($event) ? $event : [];
        $waktu = trim((string) ($event['waktu'] ?? ''));
        $tanggal = trim((string) ($event['tanggal'] ?? ''));

        if ($waktu !== '') {
            try {
                $dateTime = \Carbon\Carbon::parse($waktu)->locale('id');

                return [
                    'tanggal' => $dateTime->translatedFormat('l, d F Y'),
                    'waktu' => $dateTime->format('H.i') . ' WIB',
                ];
            } catch (\Throwable $e) {
                return [
                    'tanggal' => $tanggal,
                    'waktu' => $waktu,
                ];
            }
        }

        return [
            'tanggal' => $tanggal,
            'waktu' => '',
        ];
    };

    $normalizeEmbedUrl = function ($url) {
        $url = trim((string) ($url ?? ''));
        if ($url === '') return '';

        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        if (preg_match('/youtu\.be\/([^?&]+)/i', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    };

    $akadEvent = $invitation->content['acara']['akad'] ?? [];
    $resepsiEvent = $invitation->content['acara']['resepsi'] ?? [];
    $mainEvent = !empty($akadEvent['waktu'] ?? '') ? $akadEvent : $resepsiEvent;
    $mainEventDateTime = $formatEventDateTime($mainEvent);
    $mainEventTarget = trim((string) ($mainEvent['waktu'] ?? ''));
    $coverImage = $invitation->content['media']['cover'] ?? '';
    $loveStories = $invitation->content['love_stories'] ?? [];
    $videoLink = $normalizeEmbedUrl($invitation->content['media']['video_link'] ?? '');
    $giftAddress = trim((string) ($invitation->content['amplop']['alamat_kado'] ?? ''));
    $giftMap = $mapsUrl($invitation->content['amplop']['maps_kado'] ?? '', $giftAddress);

    $pixelAdventureFileUrl = function ($path, $default = 'https://via.placeholder.com/300') {
            if (empty($path)) return $default;
            if (filter_var($path, FILTER_VALIDATE_URL)) return $path;
            if (strpos($path, 'storage/') === 0) return asset($path);
            if (strpos($path, 'assets/') === 0) return asset($path);
            return asset('storage/' . $path);
    }
@endphp

<!-- Pixel Page Wrapper -->
<div class="pixel-page">
<div class="pixel-phone">

<!-- Music Button -->
@php
    $paMusic = $invitation->content['media']['music'] ?? null;
    $paMusicSrc = ($paMusic && !str_contains($paMusic, 'placeholder'))
        ? $pixelAdventureFileUrl($paMusic)
        : asset('assets/music/pixel-adventure.mp3');
@endphp
<div class="music-btn" id="musicBtn" onclick="toggleMusic()">
    🎵
</div>
<audio id="bgMusic" loop>
    <source src="{{ $paMusicSrc }}" type="audio/mp3">
</audio>

<!-- Gate Screen -->
<div id="gate">
    <div style="text-align: center; padding: 2rem;">
        <p style="font-size: 0.6rem; color: #00ffff; margin-bottom: 1rem;">THE WEDDING OF</p>
        
        <h1 class="pixel-title">
            {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}<br>
            &<br>
            {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
        </h1>
        
        <div style="background: rgba(0,0,0,0.5); border: 3px solid #ffd700; padding: 1rem; margin: 2rem auto; max-width: 300px;">
            <p style="font-size: 0.5rem; color: #ffd700; margin-bottom: 0.5rem;">KEPADA YTH.</p>
            <p style="font-size: 0.7rem; color: #fff;">{{ isset($guest) ? $guest->name : 'Tamu Undangan' }}</p>
        </div>
        
        <button class="pixel-btn" onclick="startAdventure()">
            ▶ Mulai Petualangan
        </button>
    </div>
</div>

<!-- HUD - Quest System -->
<div class="hud" id="questHud" style="display: none;">
    <div class="hud-title">⚔️ QUEST AKTIF</div>
    <div class="hud-quest">Temukan semua info pernikahan!</div>
    <div class="hud-progress">
        <div class="hud-item" data-quest="profil">Profil</div>
        <div class="hud-item" data-quest="acara">Acara</div>
        <div class="hud-item" data-quest="cerita">Cerita</div>
        <div class="hud-item" data-quest="hadiah">Hadiah</div>
        <div class="hud-item" data-quest="ucapan">Ucapan</div>
    </div>
    </div>
</div>

<div class="game-world" id="worldContainer" style="display: none;">
    <!-- Clouds -->
    <div class="clouds">
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
    </div>
    
    <!-- Sun -->
    <div class="sun"></div>
    
    <!-- Pixel Birds -->
    <div class="birds">
        <div class="bird"></div>
        <div class="bird"></div>
        <div class="bird"></div>
    </div>
    
    <!-- Mountains -->
    <div class="mountains">
        <div class="mountain mountain-1"></div>
        <div class="mountain mountain-2"></div>
        <div class="mountain mountain-3"></div>
    </div>
    
    <!-- Pixel Trees -->
    <div class="pixel-tree tree-left"></div>
    <div class="pixel-tree tree-right"></div>
    
    <!-- Ground Layer -->
    <div class="ground-layer">
        <div class="grass">
            <div class="grass-blade"></div>
            <div class="grass-blade"></div>
            <div class="grass-blade"></div>
            <div class="grass-blade"></div>
            <div class="grass-blade"></div>
            <div class="grass-blade"></div>
        </div>
        <div class="flower flower-1"></div>
        <div class="flower flower-2"></div>
        <div class="flower flower-3"></div>
        <div class="flower flower-4"></div>
        <div class="flower flower-5"></div>
    </div>
    
    <!-- Pixel Characters -->
    <div class="pixel-character groom">
        <svg viewBox="0 0 48 64" xmlns="http://www.w3.org/2000/svg">
            <!-- Groom pixel art -->
            <rect x="16" y="8" width="16" height="8" fill="#000"/>
            <rect x="12" y="16" width="24" height="8" fill="#ffd4a3"/>
            <rect x="16" y="20" width="4" height="2" fill="#000"/>
            <rect x="28" y="20" width="4" height="2" fill="#000"/>
            <rect x="20" y="24" width="8" height="2" fill="#000"/>
            <rect x="8" y="24" width="32" height="16" fill="#1a1a1a"/>
            <rect x="12" y="28" width="4" height="4" fill="#fff"/>
            <rect x="32" y="28" width="4" height="4" fill="#fff"/>
            <rect x="8" y="40" width="12" height="16" fill="#2c2c2c"/>
            <rect x="28" y="40" width="12" height="16" fill="#2c2c2c"/>
            <rect x="8" y="56" width="12" height="8" fill="#000"/>
            <rect x="28" y="56" width="12" height="8" fill="#000"/>
        </svg>
    </div>
    
    <div class="pixel-character bride">
        <svg viewBox="0 0 48 64" xmlns="http://www.w3.org/2000/svg">
            <!-- Bride pixel art -->
            <rect x="16" y="4" width="16" height="4" fill="#fff"/>
            <rect x="16" y="8" width="16" height="8" fill="#000"/>
            <rect x="12" y="16" width="24" height="8" fill="#ffd4a3"/>
            <rect x="16" y="20" width="4" height="2" fill="#000"/>
            <rect x="28" y="20" width="4" height="2" fill="#000"/>
            <rect x="20" y="24" width="8" height="2" fill="#ff69b4"/>
            <rect x="8" y="24" width="32" height="16" fill="#fff"/>
            <rect x="12" y="28" width="4" height="4" fill="#ff69b4"/>
            <rect x="32" y="28" width="4" height="4" fill="#ff69b4"/>
            <rect x="4" y="40" width="40" height="16" fill="#fff"/>
            <rect x="12" y="56" width="8" height="8" fill="#ffd4a3"/>
            <rect x="28" y="56" width="8" height="8" fill="#ffd4a3"/>
        </svg>
    </div>
    
    <div class="scene-track" id="worldTrack">
        
        <!-- Scene 1: Couple Profile -->
        <div class="scene" data-scene="0">
            <h2 style="font-size: 0.8rem; color: #ffd700; margin-bottom: 2rem; text-align: center;">MEMPELAI</h2>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                <div class="interactive-object" onclick="openModal('modalPria')">
                    <div class="icon">🤵</div>
                    <div class="label">MEMPELAI PRIA</div>
                </div>
                
                <div class="interactive-object" onclick="openModal('modalWanita')">
                    <div class="icon">👰</div>
                    <div class="label">MEMPELAI WANITA</div>
                </div>
            </div>
        </div>
        
        <!-- Scene 2: Event Details -->
        <div class="scene" data-scene="1">
            <div class="event-scene-content">
                <h2 style="font-size: 0.75rem; color: #ffd700; margin-bottom: 0.2rem; text-align: center;">📋 PAPAN ACARA</h2>
                
                @if($mainEventTarget)
                <div class="countdown-panel" data-countdown-target="{{ $mainEventTarget }}" style="text-align: center;">
                    <p style="font-size: 0.42rem; color: #00ffff; line-height: 1.7;">COUNTDOWN MENUJU ACARA</p>
                    @if($mainEventDateTime['tanggal'])
                    <p style="font-size: 0.38rem; color: #fff; margin-top: 0.35rem;">{{ $mainEventDateTime['tanggal'] }}</p>
                    @endif
                    <div class="countdown-grid">
                        <div class="countdown-item"><span class="countdown-number" id="countDays">0</span><span class="countdown-label">Hari</span></div>
                        <div class="countdown-item"><span class="countdown-number" id="countHours">0</span><span class="countdown-label">Jam</span></div>
                        <div class="countdown-item"><span class="countdown-number" id="countMinutes">0</span><span class="countdown-label">Menit</span></div>
                        <div class="countdown-item"><span class="countdown-number" id="countSeconds">0</span><span class="countdown-label">Detik</span></div>
                    </div>
                </div>
                @endif
                
                <div class="event-actions">
                    @if(isset($invitation->content['acara']['akad']))
                    <div class="interactive-object" onclick="openModal('modalAkad')">
                        <div class="icon">🕌</div>
                        <div class="label">AKAD NIKAH</div>
                    </div>
                    @endif
                    
                    @if(isset($invitation->content['acara']['resepsi']))
                    <div class="interactive-object" onclick="openModal('modalResepsi')">
                        <div class="icon">🎉</div>
                        <div class="label">RESEPSI</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Scene 3: Love Story & Video -->
        <div class="scene" data-scene="2">
            <h2 style="font-size: 0.8rem; color: #ffd700; margin-bottom: 2rem; text-align: center;">💕 QUEST CINTA</h2>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                @if(is_array($loveStories) && count($loveStories) > 0)
                <div class="interactive-object" onclick="openModal('modalLoveStory')">
                    <div class="icon">📜</div>
                    <div class="label">LOVE STORY</div>
                </div>
                @endif

                @if($videoLink)
                <div class="interactive-object" onclick="openModal('modalVideo')">
                    <div class="icon">🎬</div>
                    <div class="label">VIDEO</div>
                </div>
                @endif

                @if((!is_array($loveStories) || count($loveStories) === 0) && !$videoLink)
                <div class="empty-state">Belum ada cerita/video yang ditambahkan.</div>
                @endif
            </div>
        </div>
        
        <!-- Scene 4: Gift & RSVP -->
        <div class="scene" data-scene="3">
            <h2 style="font-size: 0.8rem; color: #ffd700; margin-bottom: 2rem; text-align: center;">🎁 PETI HADIAH & RSVP</h2>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                @if(isset($invitation->content['amplop']))
                <div class="interactive-object" onclick="openModal('modalAmplop')">
                    <div class="icon">💰</div>
                    <div class="label">AMPLOP DIGITAL</div>
                </div>
                @endif
                
                <div class="interactive-object" onclick="openModal('modalBukuTamu')">
                    <div class="icon">📖</div>
                    <div class="label">BUKU TAMU</div>
                </div>
            </div>
        </div>
        
        <!-- Scene 5: Gallery & Wishes -->
        <div class="scene" data-scene="4">
            <h2 style="font-size: 0.8rem; color: #ffd700; margin-bottom: 2rem; text-align: center;">📸 GALERI & UCAPAN</h2>
            
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                @if(isset($invitation->content['media']['gallery']) && count($invitation->content['media']['gallery']) > 0)
                <div class="interactive-object" onclick="openModal('modalGallery')">
                    <div class="romantic-frame-icon" aria-hidden="true">
                        <div class="romantic-frame-photo left"></div>
                        <div class="romantic-frame-photo right"></div>
                        <div class="romantic-frame-sparkle"></div>
                    </div>
                    <div class="label">GALERI FOTO</div>
                </div>
                @endif
                
                <div class="interactive-object" onclick="openModal('modalUcapan')">
                    <div class="icon">💬</div>
                    <div class="label">LIHAT UCAPAN</div>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- Navigation Arrows -->
    <div class="nav-arrow left" id="navLeft" onclick="navigateScene(-1)">◀</div>
    <div class="nav-arrow right" id="navRight" onclick="navigateScene(1)">▶</div>
    
    <!-- Scene Indicators -->
    <div class="scene-indicator" id="sceneIndicator"></div>
</div><!-- End game-world -->
</div><!-- End pixel-phone -->
</div><!-- End pixel-page -->

<!-- Modal: Mempelai Pria -->
<div class="modal" id="modalPria" data-quest="profil">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">🤵 MEMPELAI PRIA</h3>
            <div class="modal-close" onclick="closeModal('modalPria')">✕</div>
        </div>
        
        <div class="modal-body">
            <div class="couple-detail">
                <img src="{{ $pixelAdventureFileUrl($invitation->content['mempelai']['pria']['foto'] ?? null) }}"
                     class="couple-detail-photo">
                
                <div class="couple-detail-info">
                    <p class="couple-detail-name">
                        {{ $invitation->content['mempelai']['pria']['nama'] ?? 'Nama Pria' }}
                    </p>
                    
                    @php
                        $ayahPria = $getParentName($invitation->content['mempelai']['pria'] ?? [], 'ayah');
                        $ibuPria = $getParentName($invitation->content['mempelai']['pria'] ?? [], 'ibu');
                    @endphp
                    @if($ayahPria || $ibuPria)
                    <p class="couple-detail-parents">
                        Putra dari<br>
                        @if($ayahPria)
                        Bpk. {{ $ayahPria }}
                        @endif
                        @if($ayahPria && $ibuPria)
                        &
                        @endif
                        @if($ibuPria)
                        Ibu {{ $ibuPria }}
                        @endif
                    </p>
                    @endif
                    
                    @if(isset($invitation->content['mempelai']['pria']['instagram']))
                    @php $igPria = $formatInstagram($invitation->content['mempelai']['pria']['instagram']); @endphp
                    @if($igPria['url'])
                    <a href="{{ $igPria['url'] }}" target="_blank" rel="noopener noreferrer" class="pixel-btn" style="display: inline-block; font-size: 0.6rem; padding: 0.5rem 1rem;">
                        📷 {{ $igPria['display'] }}
                    </a>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Mempelai Wanita -->
<div class="modal" id="modalWanita" data-quest="profil">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">👰 MEMPELAI WANITA</h3>
            <div class="modal-close" onclick="closeModal('modalWanita')">✕</div>
        </div>
        
        <div class="modal-body">
            <div class="couple-detail">
                <img src="{{ $pixelAdventureFileUrl($invitation->content['mempelai']['wanita']['foto'] ?? null) }}"
                     class="couple-detail-photo">
                
                <div class="couple-detail-info">
                    <p class="couple-detail-name">
                        {{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Nama Wanita' }}
                    </p>
                    
                    @php
                        $ayahWanita = $getParentName($invitation->content['mempelai']['wanita'] ?? [], 'ayah');
                        $ibuWanita = $getParentName($invitation->content['mempelai']['wanita'] ?? [], 'ibu');
                    @endphp
                    @if($ayahWanita || $ibuWanita)
                    <p class="couple-detail-parents">
                        Putri dari<br>
                        @if($ayahWanita)
                        Bpk. {{ $ayahWanita }}
                        @endif
                        @if($ayahWanita && $ibuWanita)
                        &
                        @endif
                        @if($ibuWanita)
                        Ibu {{ $ibuWanita }}
                        @endif
                    </p>
                    @endif
                    
                    @if(isset($invitation->content['mempelai']['wanita']['instagram']))
                    @php $igWanita = $formatInstagram($invitation->content['mempelai']['wanita']['instagram']); @endphp
                    @if($igWanita['url'])
                    <a href="{{ $igWanita['url'] }}" target="_blank" rel="noopener noreferrer" class="pixel-btn" style="display: inline-block; font-size: 0.6rem; padding: 0.5rem 1rem;">
                        📷 {{ $igWanita['display'] }}
                    </a>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Akad Nikah -->
@if(isset($invitation->content['acara']['akad']))
<div class="modal" id="modalAkad" data-quest="acara">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">🕌 AKAD NIKAH</h3>
            <div class="modal-close" onclick="closeModal('modalAkad')">✕</div>
        </div>
        
        <div class="modal-body" style="font-size: 0.6rem; line-height: 2; color: #fff;">
            @php $akadDateTime = $formatEventDateTime($invitation->content['acara']['akad'] ?? []); @endphp
            @if($akadDateTime['tanggal'])
            <p><strong style="color: #ffd700;">📅 Tanggal:</strong><br>{{ $akadDateTime['tanggal'] }}</p>
            @endif
            
            @if($akadDateTime['waktu'])
            <p><strong style="color: #ffd700;">⏰ Waktu:</strong><br>{{ $akadDateTime['waktu'] }}</p>
            @endif
            
            @if(isset($invitation->content['acara']['akad']['judul']))
            <p><strong style="color: #ffd700;">📌 Acara:</strong><br>{{ $invitation->content['acara']['akad']['judul'] }}</p>
            @endif

            @if(isset($invitation->content['acara']['akad']['tempat']))
            <p><strong style="color: #ffd700;">🏛️ Tempat:</strong><br>{{ $invitation->content['acara']['akad']['tempat'] }}</p>
            @endif

            @if(isset($invitation->content['acara']['akad']['alamat']))
            <p><strong style="color: #ffd700;">📍 Alamat:</strong><br>{{ $invitation->content['acara']['akad']['alamat'] }}</p>
            @endif
            
            @php
                $akadMaps = $mapsUrl(
                    $invitation->content['acara']['akad']['maps'] ?? '',
                    $invitation->content['acara']['akad']['alamat'] ?? ''
                );
            @endphp
            @if($akadMaps)
            <a href="{{ $akadMaps }}" target="_blank" rel="noopener noreferrer" class="pixel-btn" style="display: inline-block; margin-top: 1rem;">
                🗺️ BUKA MAPS
            </a>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Modal: Resepsi -->
@if(isset($invitation->content['acara']['resepsi']))
<div class="modal" id="modalResepsi" data-quest="acara">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">🎉 RESEPSI</h3>
            <div class="modal-close" onclick="closeModal('modalResepsi')">✕</div>
        </div>
        
        <div class="modal-body" style="font-size: 0.6rem; line-height: 2; color: #fff;">
            @php $resepsiDateTime = $formatEventDateTime($invitation->content['acara']['resepsi'] ?? []); @endphp
            @if($resepsiDateTime['tanggal'])
            <p><strong style="color: #ffd700;">📅 Tanggal:</strong><br>{{ $resepsiDateTime['tanggal'] }}</p>
            @endif
            
            @if($resepsiDateTime['waktu'])
            <p><strong style="color: #ffd700;">⏰ Waktu:</strong><br>{{ $resepsiDateTime['waktu'] }}</p>
            @endif
            
            @if(isset($invitation->content['acara']['resepsi']['judul']))
            <p><strong style="color: #ffd700;">📌 Acara:</strong><br>{{ $invitation->content['acara']['resepsi']['judul'] }}</p>
            @endif

            @if(isset($invitation->content['acara']['resepsi']['tempat']))
            <p><strong style="color: #ffd700;">🏛️ Tempat:</strong><br>{{ $invitation->content['acara']['resepsi']['tempat'] }}</p>
            @endif

            @if(isset($invitation->content['acara']['resepsi']['alamat']))
            <p><strong style="color: #ffd700;">📍 Alamat:</strong><br>{{ $invitation->content['acara']['resepsi']['alamat'] }}</p>
            @endif
            
            @php
                $resepsiMaps = $mapsUrl(
                    $invitation->content['acara']['resepsi']['maps'] ?? '',
                    $invitation->content['acara']['resepsi']['alamat'] ?? ''
                );
            @endphp
            @if($resepsiMaps)
            <a href="{{ $resepsiMaps }}" target="_blank" rel="noopener noreferrer" class="pixel-btn" style="display: inline-block; margin-top: 1rem;">
                🗺️ BUKA MAPS
            </a>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Modal: Amplop Digital -->
@if(isset($invitation->content['amplop']))
<div class="modal" id="modalAmplop" data-quest="hadiah">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">💰 AMPLOP DIGITAL</h3>
            <div class="modal-close" onclick="closeModal('modalAmplop')">✕</div>
        </div>
        
        <div class="modal-body" style="font-size: 0.6rem; line-height: 2; color: #fff; text-align: center;">
            <p style="margin-bottom: 1rem;">Tanpa mengurangi rasa hormat, bagi yang ingin memberikan tanda kasih dapat melalui:</p>
            
            @if(isset($invitation->content['amplop']['bank_name']))
            <div style="background: rgba(0,0,0,0.5); border: 3px solid #ffd700; padding: 1rem; margin-bottom: 1rem;">
                <p><strong style="color: #ffd700;">🏦 Bank:</strong><br>{{ $invitation->content['amplop']['bank_name'] }}</p>
                
                @if(isset($invitation->content['amplop']['account_number']))
                <p><strong style="color: #ffd700;">💳 No. Rekening:</strong><br>{{ $invitation->content['amplop']['account_number'] }}</p>
                @endif
                
                @if(isset($invitation->content['amplop']['account_holder']))
                <p><strong style="color: #ffd700;">👤 Atas Nama:</strong><br>{{ $invitation->content['amplop']['account_holder'] }}</p>
                @endif
                
                @if(isset($invitation->content['amplop']['account_number']))
                <button class="copy-btn" onclick="copyToClipboard('{{ $invitation->content['amplop']['account_number'] }}')">
                    📋 SALIN NO. REKENING
                </button>
                @endif
            </div>
            @endif
            
            @if($giftAddress)
            <div class="gift-address-card">
                <p><strong style="color: #ffd700;">📦 Alamat Kado:</strong><br>{{ $giftAddress }}</p>
                @if($giftMap)
                <a href="{{ $giftMap }}" target="_blank" rel="noopener noreferrer" class="pixel-btn" style="display: inline-block; margin-top: 1rem; font-size: 0.5rem; padding: 0.6rem 1rem;">
                    🗺️ BUKA MAPS KADO
                </a>
                @endif
            </div>
            @endif
            
            @if(isset($invitation->content['amplop']['qris_image']) && $invitation->content['amplop']['qris_image'])
            <div style="margin-top: 1rem;">
                <p style="color: #ffd700; margin-bottom: 0.5rem;"><strong>QRIS:</strong></p>
                <img src="{{ $pixelAdventureFileUrl($invitation->content['amplop']['qris_image']) }}"
                     style="max-width: 200px; border: 3px solid #ffd700;">
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Modal: Love Story -->
@if(is_array($loveStories) && count($loveStories) > 0)
<div class="modal" id="modalLoveStory" data-quest="cerita">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">💕 LOVE STORY</h3>
            <div class="modal-close" onclick="closeModal('modalLoveStory')">✕</div>
        </div>
        <div class="modal-body">
            @foreach($loveStories as $story)
            <div class="story-card">
                @if(!empty($story['year']))
                <span class="story-year">{{ $story['year'] }}</span>
                @endif
                <div class="story-title">{{ $story['title'] ?? 'Cerita Kami' }}</div>
                <div class="story-text">{{ $story['story'] ?? '' }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Modal: Video -->
@if($videoLink)
<div class="modal" id="modalVideo" data-quest="cerita">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">🎬 VIDEO</h3>
            <div class="modal-close" onclick="closeModal('modalVideo')">✕</div>
        </div>
        <div class="modal-body">
            <div class="video-frame">
                <iframe src="{{ $videoLink }}" title="Video Wedding" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal: Buku Tamu -->
<div class="modal" id="modalBukuTamu" data-quest="ucapan">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">📖 BUKU TAMU</h3>
            <div class="modal-close" onclick="closeModal('modalBukuTamu')">✕</div>
        </div>
        
        <div class="modal-body">
        <form action="{{ route('kirim.ucapan') }}" method="POST">
            @csrf
            <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">
            
            <label class="pixel-label">NAMA:</label>
            <input type="text" name="nama" class="pixel-input" required value="{{ isset($guest) ? $guest->name : '' }}">
            
            <label class="pixel-label">KEHADIRAN:</label>
            <select name="kehadiran" class="pixel-select" required>
                <option value="">-- PILIH --</option>
                <option value="hadir">✓ HADIR</option>
                <option value="tidak_hadir">✗ TIDAK HADIR</option>
                <option value="ragu">? MASIH RAGU</option>
            </select>
            
            <label class="pixel-label">UCAPAN & DOA:</label>
            <textarea name="ucapan" class="pixel-textarea" required placeholder="Tulis ucapan & doa untuk mempelai..."></textarea>
            
            <button type="submit" class="pixel-btn" style="width: 100%;">
                ✓ KIRIM KONFIRMASI
            </button>
        </form>
        </div>
    </div>
</div>

<!-- Modal: Lihat Ucapan -->
<div class="modal" id="modalUcapan">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">💬 UCAPAN DARI TAMU</h3>
            <div class="modal-close" onclick="closeModal('modalUcapan')">✕</div>
        </div>
        
        <div class="modal-body">
        @if(isset($comments) && count($comments) > 0)
            @foreach($comments as $comment)
            <div style="background: rgba(0,0,0,0.5); border: 2px solid #ffd700; padding: 1rem; margin-bottom: 1rem;">
                <p style="font-size: 0.6rem; color: #ffd700; margin-bottom: 0.5rem;">
                    {{ $comment->name }}
                    @php $rsvpStatus = $comment->rsvp_status ?? $comment->attendance ?? null; @endphp
                    @if($rsvpStatus)
                    <span style="color: #00ff00; margin-left: 0.5rem;">
                        @if($rsvpStatus == 'hadir')
                        ✓ Hadir
                        @elseif($rsvpStatus == 'tidak_hadir')
                        ✗ Tidak Hadir
                        @else
                        ? Ragu
                        @endif
                    </span>
                    @endif
                </p>
                <p style="font-size: 0.5rem; color: #fff; line-height: 1.6;">{{ $comment->comment }}</p>
            </div>
            @endforeach
        @else
            <p style="text-align: center; color: #ffd700; font-size: 0.6rem;">Belum ada ucapan dari tamu.</p>
        @endif
        </div>
    </div>
</div>

<!-- Modal: Gallery -->
@if(isset($invitation->content['media']['gallery']) && count($invitation->content['media']['gallery']) > 0)
<div class="modal" id="modalGallery">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">🖼️ GALERI FOTO</h3>
            <div class="modal-close" onclick="closeModal('modalGallery')">✕</div>
        </div>
        
        <div class="modal-body">
        <div class="photo-grid">
            @foreach($invitation->content['media']['gallery'] as $photo)
            <div class="photo-item" onclick="viewPhoto('{{ $pixelAdventureFileUrl($photo) }}')">
                <img src="{{ $pixelAdventureFileUrl($photo) }}" alt="Gallery">
            </div>
            @endforeach
        </div>
        </div>
    </div>
</div>

<!-- Modal: Photo Viewer -->
<div class="modal" id="modalPhotoViewer">
    <div class="modal-content" style="max-width: 90vw;">
        <div class="modal-header">
            <div class="modal-close" onclick="closeModal('modalPhotoViewer')">✕</div>
        </div>
        <div class="modal-body" style="padding: 0;">
        <img id="photoViewerImg" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxIiBoZWlnaHQ9IjEiPjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9InRyYW5zcGFyZW50Ii8+PC9zdmc+" style="width: 100%; border: 3px solid #ffd700; display: none;">
        </div>
    </div>
</div>
@endif

<script>
    let currentScene = 0;
    const totalScenes = 5;
    let musicPlaying = false;
    
    // Quest tracking
    const questProgress = {
        profil: false,
        acara: false,
        cerita: false,
        hadiah: false,
        ucapan: false
    };
    
    // Start Adventure
    function startAdventure() {
        document.getElementById('gate').classList.add('hidden');
        document.getElementById('worldContainer').style.display = 'block';
        document.getElementById('questHud').style.display = 'block';
        updateNavigation();
        createSceneIndicators();
        loadQuestProgress();
        
        // Auto play music if available
        const music = document.getElementById('bgMusic');
        if (music) {
            music.play().catch(() => {});
            musicPlaying = true;
            document.getElementById('musicBtn')?.classList.remove('paused');
        }
    }
    
    // Load quest progress from localStorage
    function loadQuestProgress() {
        const saved = localStorage.getItem('pixelQuestProgress');
        if (saved) {
            Object.assign(questProgress, JSON.parse(saved));
            updateQuestHUD();
        }
    }
    
    // Save quest progress
    function saveQuestProgress() {
        localStorage.setItem('pixelQuestProgress', JSON.stringify(questProgress));
    }
    
    // Update quest HUD
    function updateQuestHUD() {
        Object.keys(questProgress).forEach(quest => {
            const item = document.querySelector(`[data-quest="${quest}"]`);
            if (item && item.classList.contains('hud-item')) {
                if (questProgress[quest]) {
                    item.classList.add('completed');
                } else {
                    item.classList.remove('completed');
                }
            }
        });
    }
    
    // Mark quest as completed
    function completeQuest(questName) {
        if (questProgress[questName] !== undefined) {
            questProgress[questName] = true;
            saveQuestProgress();
            updateQuestHUD();
        }
    }
    
    // Navigate Scene
    function navigateScene(direction) {
        currentScene += direction;
        if (currentScene < 0) currentScene = 0;
        if (currentScene >= totalScenes) currentScene = totalScenes - 1;
        
        const track = document.getElementById('worldTrack');
        const phoneFrame = document.querySelector('.pixel-phone');
        if (phoneFrame) {
            track.style.transform = `translateX(calc(-1 * ${currentScene} * 100%))`;
        }
        
        updateNavigation();
        updateSceneIndicators();
    }
    
    // Update Navigation Arrows
    function updateNavigation() {
        const leftArrow = document.getElementById('navLeft');
        const rightArrow = document.getElementById('navRight');
        
        if (currentScene === 0) {
            leftArrow.classList.add('hidden');
        } else {
            leftArrow.classList.remove('hidden');
        }
        
        if (currentScene === totalScenes - 1) {
            rightArrow.classList.add('hidden');
        } else {
            rightArrow.classList.remove('hidden');
        }
    }
    
    // Create Scene Indicators
    function createSceneIndicators() {
        const container = document.getElementById('sceneIndicator');
        container.innerHTML = '';
        
        for (let i = 0; i < totalScenes; i++) {
            const dot = document.createElement('div');
            dot.className = 'scene-dot' + (i === 0 ? ' active' : '');
            dot.onclick = () => goToScene(i);
            container.appendChild(dot);
        }
    }
    
    // Update Scene Indicators
    function updateSceneIndicators() {
        const dots = document.querySelectorAll('.scene-dot');
        dots.forEach((dot, index) => {
            if (index === currentScene) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }
    
    // Go to Scene
    function goToScene(index) {
        currentScene = index;
        const track = document.getElementById('worldTrack');
        const phoneFrame = document.querySelector('.pixel-phone');
        if (phoneFrame) {
            track.style.transform = `translateX(calc(-1 * ${currentScene} * 100%))`;
        }
        
        updateNavigation();
        updateSceneIndicators();
    }
    // Toggle Music
    function toggleMusic() {
        const music = document.getElementById('bgMusic');
        const btn = document.getElementById('musicBtn');
        
        if (!music) return;
        
        if (musicPlaying) {
            music.pause();
            btn.classList.add('paused');
        } else {
            music.play();
            btn.classList.remove('paused');
        }
        
        musicPlaying = !musicPlaying;
    }
    
    // Open Modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Mark quest as completed
        const questType = modal.getAttribute('data-quest');
        if (questType) {
            completeQuest(questType);
        }
        
        // Mark interactive object as visited
        const objects = document.querySelectorAll('.interactive-object');
        objects.forEach(obj => {
            if (obj.getAttribute('onclick')?.includes(modalId)) {
                obj.classList.add('visited');
            }
        });
    }
    
    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Copy to Clipboard
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('✓ Nomor rekening berhasil disalin!');
        }).catch(() => {
            alert('✗ Gagal menyalin. Silakan salin manual.');
        });
    }
    
    // View Photo
    function viewPhoto(url) {
        const img = document.getElementById('photoViewerImg');
        img.src = url;
        img.style.display = 'block';
        openModal('modalPhotoViewer');
    }
    
    // Close modal on outside click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (document.querySelector('.modal.active')) return;
        
        if (e.key === 'ArrowLeft') {
            navigateScene(-1);
        } else if (e.key === 'ArrowRight') {
            navigateScene(1);
        }
    });

    function startCountdown() {
        const panel = document.querySelector('[data-countdown-target]');
        if (!panel) return;

        const target = new Date(panel.getAttribute('data-countdown-target').replace(' ', 'T')).getTime();
        if (Number.isNaN(target)) return;

        const setText = (id, value) => {
            const element = document.getElementById(id);
            if (element) element.textContent = value;
        };

        const tick = () => {
            const distance = target - new Date().getTime();
            if (distance <= 0) {
                setText('countDays', '0');
                setText('countHours', '0');
                setText('countMinutes', '0');
                setText('countSeconds', '0');
                return;
            }

            setText('countDays', Math.floor(distance / (1000 * 60 * 60 * 24)));
            setText('countHours', Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
            setText('countMinutes', Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
            setText('countSeconds', Math.floor((distance % (1000 * 60)) / 1000));
        };

        tick();
        setInterval(tick, 1000);
    }

    startCountdown();
</script>

</body>
</html>
