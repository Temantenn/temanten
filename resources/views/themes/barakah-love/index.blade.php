<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 rx=%2212%22 fill=%22%234F46E5%22/><path d=%22M15 13h18v6h-6v17h-6v-17h-6v-6z%22 fill=%22white%22/></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --ivory: #FDFBF7;
            --ivory-dark: #F5F0E6;
            --cream: #FAF7F0;
            --sage: #87A878;
            --sage-light: #A8C49A;
            --emerald: #2D5A4A;
            --emerald-dark: #1F4435;
            --gold: #C9A962;
            --gold-light: #D4BA7A;
            --text-dark: #2C2C2C;
            --text-medium: #4A4A4A;
            --text-light: #7A7A7A;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #E8E4DD;
            color: var(--text-dark);
            overflow: hidden;
            line-height: 1.6;
        }

        .font-arabic { font-family: 'Amiri', serif; }
        .font-elegant { font-family: 'Cormorant Garamond', serif; }

        .mobile-container {
            max-width: 480px;
            margin: 0 auto;
            background: var(--ivory);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 60px rgba(0,0,0,0.15);
        }

        .cover {
            height: 100vh;
            background-size: cover;
            background-position: center;
            position: fixed;
            inset: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cover::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(45, 90, 74, 0.2) 0%,
                rgba(45, 90, 74, 0.4) 40%,
                rgba(0, 0, 0, 0.6) 100%
            );
        }

        .cover.open { transform: translateY(-100%); }

        .cover-content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 2rem;
            max-width: 360px;
        }

        .cover-bismillah {
            font-size: 1.75rem;
            margin-bottom: 2rem;
            text-shadow: 0 2px 8px rgba(0,0,0,0.4);
            opacity: 0.95;
        }

        .cover-ornament {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto 1.5rem;
        }

        .cover-label {
            font-size: 0.7rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            opacity: 0.85;
            margin-bottom: 0.5rem;
        }

        .cover-names {
            font-size: 2.75rem;
            font-weight: 600;
            margin: 0.75rem 0 1.5rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.4);
            line-height: 1.1;
        }

        .cover-date {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
        }

        .cover-guest-box {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 1rem 2rem;
            border-radius: 100px;
            border: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 2rem;
        }

        .cover-guest-box small {
            font-size: 0.65rem;
            opacity: 0.8;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .cover-guest-box p {
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 0.25rem;
        }

        .btn-open {
            background: var(--gold);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 20px rgba(201, 169, 98, 0.4);
        }

        .btn-open:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(201, 169, 98, 0.5);
        }

        #mainContent { display: none; }

        .hero-inside {
            position: relative;
            padding: 4rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dark) 100%);
            color: white;
            overflow: hidden;
        }

        .hero-inside::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0L30 60M0 30L60 30M0 0L60 60M60 0L0 60' stroke='%23ffffff' stroke-width='0.5' fill='none' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .hero-inside-content { position: relative; z-index: 2; }

        .hero-title {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 0.85rem;
            opacity: 0.85;
            max-width: 280px;
            margin: 0 auto;
        }

        .islamic-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 2rem 0;
        }

        .islamic-divider-line {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold));
        }

        .islamic-divider-line:last-child {
            background: linear-gradient(90deg, var(--gold), transparent);
        }

        .islamic-divider-icon {
            color: var(--gold);
            font-size: 1.25rem;
        }

        .section {
            padding: 4rem 1.75rem;
            text-align: center;
        }

        .section-sm { padding: 3rem 1.75rem; }
        .section-lg { padding: 5rem 1.75rem; }

        .section-alt { background: var(--cream); }

        .section-header {
            margin-bottom: 2.5rem;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--sage-light), var(--sage));
            border-radius: 50%;
            color: white;
            font-size: 1.25rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--emerald);
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .section-subtitle {
            font-size: 0.85rem;
            color: var(--text-light);
            max-width: 300px;
            margin: 0 auto;
        }

        .quote-section {
            background: linear-gradient(180deg, var(--ivory-dark) 0%, var(--ivory) 100%);
            padding: 4rem 2rem;
        }

        .quote-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 40px rgba(45, 90, 74, 0.06);
            border: 1px solid rgba(201, 169, 98, 0.15);
            position: relative;
        }

        .quote-card::before {
            content: '"';
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            font-size: 4rem;
            font-family: 'Cormorant Garamond', serif;
            color: var(--gold);
            opacity: 0.3;
            line-height: 1;
        }

        .quote-arabic {
            font-size: 1.3rem;
            color: var(--emerald);
            direction: rtl;
            line-height: 2.2;
            margin-bottom: 1.5rem;
        }

        .quote-text {
            font-size: 0.9rem;
            color: var(--text-medium);
            font-style: italic;
            line-height: 1.8;
        }

        .quote-ref {
            font-size: 0.75rem;
            color: var(--sage);
            margin-top: 1rem;
            font-weight: 600;
        }

        .couple-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 40px rgba(45, 90, 74, 0.06);
            margin-bottom: 1rem;
        }

        .couple-img-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 1.25rem;
        }

        .couple-img-wrapper::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--sage));
            z-index: 0;
        }

        .couple-img {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            object-position: center top; /* Prioritas wajah bagian atas */
            border: 4px solid white;
            z-index: 1;
        }


        .couple-name {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--emerald);
            margin-bottom: 0.25rem;
        }

        .couple-fullname {
            font-size: 0.9rem;
            color: var(--text-medium);
            margin-bottom: 0.75rem;
        }

        .couple-parents {
            font-size: 0.8rem;
            color: var(--text-light);
            line-height: 1.7;
        }

        .couple-ig {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: var(--ivory);
            border-radius: 50px;
            font-size: 0.8rem;
            color: var(--emerald);
            text-decoration: none;
            transition: all 0.2s;
        }

        .couple-ig:hover { background: var(--ivory-dark); }

        .couple-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 0;
        }

        .couple-divider-circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .countdown-wrapper {
            background: white;
            border-radius: 20px;
            padding: 2rem 1.5rem;
            box-shadow: 0 8px 40px rgba(45, 90, 74, 0.06);
            margin-bottom: 2rem;
        }

        .countdown-label {
            font-size: 0.75rem;
            color: var(--text-light);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .countdown-item {
            background: linear-gradient(135deg, var(--emerald), var(--emerald-dark));
            color: white;
            padding: 1rem 0;
            border-radius: 12px;
            min-width: 60px;
            text-align: center;
        }

        .countdown-item span {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
            line-height: 1;
        }

        .countdown-item small {
            font-size: 0.6rem;
            text-transform: uppercase;
            opacity: 0.8;
            letter-spacing: 0.5px;
        }

        .event-cards {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .event-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 40px rgba(45, 90, 74, 0.06);
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .event-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, var(--gold), var(--sage));
        }

        .event-badge {
            display: inline-block;
            background: var(--ivory);
            color: var(--emerald);
            padding: 0.375rem 1rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .event-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--emerald);
            margin-bottom: 1rem;
        }

        .event-detail {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .event-detail-icon {
            width: 32px;
            height: 32px;
            background: var(--ivory);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--sage);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .event-detail-text {
            flex: 1;
        }

        .event-detail-text strong {
            display: block;
            font-size: 0.9rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .event-detail-text span {
            display: block;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .btn-maps {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            margin-top: 1rem;
            padding: 0.625rem 1.25rem;
            background: var(--emerald);
            color: white;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-maps:hover {
            background: var(--emerald-dark);
            transform: translateY(-1px);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .gallery-item {
            aspect-ratio: 1;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .gallery-item:first-child {
            grid-column: span 2;
            aspect-ratio: 16/10;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img { transform: scale(1.05); }

        .story-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .story-timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, var(--gold), var(--sage), var(--gold));
        }

        .story-item {
            position: relative;
            text-align: left;
            padding-bottom: 2rem;
        }

        .story-item:last-child { padding-bottom: 0; }

        .story-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            background: var(--gold);
            border-radius: 50%;
            border: 3px solid var(--ivory);
            transform: translateX(-5px);
        }

        .story-year {
            display: inline-block;
            background: var(--gold);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .story-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--emerald);
            margin-bottom: 0.25rem;
        }

        .story-text {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.7;
        }

        .gift-card {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dark) 100%);
            color: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .gift-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(201,169,98,0.1) 0%, transparent 70%);
        }

        .gift-card-content { position: relative; z-index: 2; }

        .gift-bank {
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0.9;
        }

        .gift-number {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0.75rem 0;
        }

        .gift-name {
            font-size: 0.8rem;
            opacity: 0.85;
        }

        .btn-copy {
            background: var(--gold);
            color: white;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1rem;
            transition: all 0.2s;
        }

        .btn-copy:hover { background: var(--gold-light); }

        .gift-address {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: left;
        }

        .gift-address-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--emerald);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .gift-address-text {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.6;
        }

        .rsvp-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 8px 40px rgba(45, 90, 74, 0.06);
        }

        .form-group { margin-bottom: 1rem; }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-medium);
            margin-bottom: 0.5rem;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1.5px solid #E5E5E5;
            border-radius: 12px;
            font-size: 0.875rem;
            font-family: inherit;
            background: var(--ivory);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--sage);
            background: white;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--sage), var(--emerald));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 0.5rem;
        }

        .btn-submit:hover { opacity: 0.9; }

        .comments-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 0 1rem;
            margin-top: 1.5rem;
            border-top: 1px solid #F0F0F0;
        }

        .comments-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--emerald);
        }

        .comments-count {
            font-size: 0.75rem;
            color: var(--text-light);
            background: var(--ivory);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
        }

        .comments-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .comment-item {
            padding: 1rem 0;
            border-bottom: 1px solid #F5F5F5;
        }

        .comment-item:last-child { border-bottom: none; }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--sage), var(--emerald));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .comment-info { flex: 1; text-align: left; }

        .comment-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-dark);
        }

        .comment-time {
            font-size: 0.7rem;
            color: var(--text-light);
        }

        .comment-status {
            font-size: 0.6rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            background: var(--ivory-dark);
            color: var(--text-medium);
        }

        .comment-text {
            font-size: 0.85rem;
            color: var(--text-medium);
            text-align: left;
            line-height: 1.6;
            padding-left: 3rem;
        }

        .prayer-section {
            background: var(--ivory-dark);
            padding: 4rem 2rem 0;
        }

        .prayer-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 40px rgba(45, 90, 74, 0.06);
            margin-bottom: 3rem;
        }

        .prayer-arabic {
            font-size: 1.15rem;
            color: var(--emerald);
            direction: rtl;
            line-height: 2.2;
            margin-bottom: 1.25rem;
        }

        .closing-section {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dark) 100%);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            margin: 0 -2rem;
            position: relative;
        }

        .closing-section::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 40px;
            background: var(--ivory-dark);
            clip-path: ellipse(60% 100% at 50% 0%);
        }

        .closing-text {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.8;
            max-width: 300px;
            margin: 0 auto 1.5rem;
        }

        .closing-salam {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-bottom: 1.5rem;
        }

        .closing-names {
            font-size: 2rem;
            font-weight: 600;
            color: var(--gold);
        }

        footer {
            background: var(--emerald-dark);
            color: rgba(255,255,255,0.6);
            text-align: center;
            padding: 2rem;
            font-size: 0.75rem;
        }

        footer a { color: var(--gold); text-decoration: none; }

        .music-btn {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            cursor: pointer;
            z-index: 50;
            font-size: 1.25rem;
            transition: all 0.2s;
        }

        .music-btn:hover { transform: scale(1.05); }
        .spin { animation: spin 3s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .success-msg {
            background: rgba(135, 168, 120, 0.15);
            border: 1px solid var(--sage);
            color: var(--emerald);
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }
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
        function getImgUrl($path) {
            if (!$path) return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop';
            if (str_contains($path, 'placeholder')) return 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop';
            return \Illuminate\Support\Str::startsWith($path, 'http') ? $path : asset($path);
        }
    @endphp

    <div class="mobile-container">

        @php
            $userMusic = $invitation->content['media']['music'] ?? null;
            $defaultMusic = asset('assets/music/barakah-love.mp3');
            $musicUrl = ($userMusic && !str_contains($userMusic, 'placeholder'))
                ? (\Illuminate\Support\Str::startsWith($userMusic, 'http') ? $userMusic : asset($userMusic))
                : $defaultMusic;
        @endphp
        <div class="music-btn" id="musicBtn" onclick="toggleMusic()">🎵</div>
        <audio id="bgMusic" loop>
            <source src="{{ $musicUrl }}" type="audio/mpeg">
        </audio>

        <section class="cover" id="heroCover" style="background-image: url('{{ getImgUrl($invitation->content['media']['cover'] ?? '') }}');">
            <div class="cover-content">
                <p class="cover-bismillah font-arabic">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
                <div class="cover-ornament"></div>
                <p class="cover-label">The Wedding Of</p>
                <h1 class="cover-names font-elegant">
                    {{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}
                    <br>&<br>
                    {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}
                </h1>
                <p class="cover-date">{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}</p>
                <div class="cover-guest-box">
                    <small>Kepada Yth.</small>
                    <p>{{ isset($guest) ? $guest->name : 'Tamu Undangan' }}</p>
                </div>
                <button class="btn-open" onclick="openInvitation()">Buka Undangan</button>
            </div>
        </section>

        <div id="mainContent">

            <section class="hero-inside">
                <div class="hero-inside-content">
                    <h2 class="hero-title font-elegant">We Are Getting Married</h2>
                    <p class="hero-subtitle">Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan kami.</p>
                </div>
            </section>

            <section class="section quote-section">
                <div class="quote-card">
                    <p class="quote-arabic font-arabic">وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً</p>
                    <p class="quote-text">"{{ $invitation->content['quote'] ?? 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang.' }}"</p>
                    <p class="quote-ref">(QS. Ar-Rum: 21)</p>
                </div>
            </section>

            <div class="islamic-divider">
                <div class="islamic-divider-line"></div>
                <span class="islamic-divider-icon">✦</span>
                <div class="islamic-divider-line"></div>
            </div>

            <section class="section section-sm">
                <div class="section-header">
                    <h2 class="section-title font-elegant">Mempelai</h2>
                    <p class="section-subtitle">Dua insan yang dipersatukan oleh Allah SWT</p>
                </div>

                <div class="couple-card">
                    <div class="couple-img-wrapper">
                        <img src="{{ getImgUrl($invitation->content['mempelai']['pria']['foto'] ?? '') }}" class="couple-img" alt="Groom">
                    </div>
                    <h3 class="couple-name font-elegant">{{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Pria' }}</h3>
                    <p class="couple-fullname">{{ $invitation->content['mempelai']['pria']['nama'] ?? 'Nama Lengkap' }}</p>
                    <p class="couple-parents">Putra dari<br>Bpk. {{ $invitation->content['mempelai']['pria']['ayah'] ?? '...' }} & Ibu {{ $invitation->content['mempelai']['pria']['ibu'] ?? '...' }}</p>
                    @php $igPria = $formatInstagram($invitation->content['mempelai']['pria']['instagram'] ?? ''); @endphp
                    @if(!empty($igPria['username']))
                    <a href="{{ $igPria['url'] }}" target="_blank" rel="noopener noreferrer" class="couple-ig">📷 {{ $igPria['display'] }}</a>
                    @endif
                </div>

                <div class="couple-divider">
                    <div class="couple-divider-circle font-elegant">&</div>
                </div>

                <div class="couple-card">
                    <div class="couple-img-wrapper">
                        <img src="{{ getImgUrl($invitation->content['mempelai']['wanita']['foto'] ?? '') }}" class="couple-img" alt="Bride">
                    </div>
                    <h3 class="couple-name font-elegant">{{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Wanita' }}</h3>
                    <p class="couple-fullname">{{ $invitation->content['mempelai']['wanita']['nama'] ?? 'Nama Lengkap' }}</p>
                    <p class="couple-parents">Putri dari<br>Bpk. {{ $invitation->content['mempelai']['wanita']['ayah'] ?? '...' }} & Ibu {{ $invitation->content['mempelai']['wanita']['ibu'] ?? '...' }}</p>
                    @php $igWanita = $formatInstagram($invitation->content['mempelai']['wanita']['instagram'] ?? ''); @endphp
                    @if(!empty($igWanita['username']))
                    <a href="{{ $igWanita['url'] }}" target="_blank" rel="noopener noreferrer" class="couple-ig">📷 {{ $igWanita['display'] }}</a>
                    @endif
                </div>
            </section>

            @if(isset($invitation->content['love_stories']) && is_array($invitation->content['love_stories']) && count($invitation->content['love_stories']) > 0)
            <section class="section section-alt">
                <div class="section-header">
                    <h2 class="section-title font-elegant">Love Story</h2>
                    <p class="section-subtitle">Perjalanan cinta kami hingga bersatu</p>
                </div>
                <div class="story-timeline">
                    @foreach($invitation->content['love_stories'] as $story)
                    @if(!empty($story['title']))
                    <div class="story-item">
                        <span class="story-year">{{ $story['year'] ?? '' }}</span>
                        <h4 class="story-title">{{ $story['title'] ?? '' }}</h4>
                        <p class="story-text">{{ $story['story'] ?? '' }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </section>
            @endif

            <div class="islamic-divider">
                <div class="islamic-divider-line"></div>
                <span class="islamic-divider-icon">❖</span>
                <div class="islamic-divider-line"></div>
            </div>

            <section class="section section-lg">
                <div class="section-header">
                    <h2 class="section-title font-elegant">Rangkaian Acara</h2>
                    <p class="section-subtitle">Insya Allah akan diselenggarakan pada</p>
                </div>

                <div class="countdown-wrapper">
                    <p class="countdown-label">Menuju Hari Bahagia</p>
                    <div class="countdown" id="countdown">
                        <div class="countdown-item"><span id="days">00</span><small>Hari</small></div>
                        <div class="countdown-item"><span id="hours">00</span><small>Jam</small></div>
                        <div class="countdown-item"><span id="minutes">00</span><small>Menit</small></div>
                        <div class="countdown-item"><span id="seconds">00</span><small>Detik</small></div>
                    </div>
                </div>

                <div class="event-cards">
                    <div class="event-card">
                        <span class="event-badge">Akad Nikah</span>
                        <h4 class="event-title font-elegant">{{ $invitation->content['acara']['akad']['judul'] ?? 'Akad Nikah' }}</h4>
                        <div class="event-detail">
                            <div class="event-detail-icon">📅</div>
                            <div class="event-detail-text">
                                <strong>{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->translatedFormat('l, d F Y') }}</strong>
                                <span>{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</span>
                            </div>
                        </div>
                        <div class="event-detail">
                            <div class="event-detail-icon">📍</div>
                            <div class="event-detail-text">
                                <strong>{{ $invitation->content['acara']['akad']['tempat'] ?? 'Tempat' }}</strong>
                                <span>{{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</span>
                                @php
                                    $akadWilayah = $invitation->content['acara']['akad']['wilayah'] ?? [];
                                    $akadLine1 = collect([
                                        !empty($akadWilayah['village'])  ? 'Kel. '.Str::title(strtolower($akadWilayah['village'])) : null,
                                        !empty($akadWilayah['district']) ? 'Kec. '.Str::title(strtolower($akadWilayah['district'])) : null,
                                    ])->filter()->implode(', ');
                                    $akadLine2 = collect([
                                        !empty($akadWilayah['regency'])  ? Str::title(strtolower($akadWilayah['regency'])) : null,
                                        !empty($akadWilayah['province']) ? Str::title(strtolower($akadWilayah['province'])) : null,
                                    ])->filter()->implode(', ');
                                @endphp
                                @if($akadLine1)<span>{{ $akadLine1 }}</span>@endif
                                @if($akadLine2)<span>{{ $akadLine2 }}</span>@endif
                            </div>
                        </div>
                        @if(!empty($invitation->content['acara']['akad']['maps'] ?? null) || !empty($invitation->content['acara']['akad']['alamat'] ?? null))
                        @php
                            $akadMaps = $invitation->content['acara']['akad']['maps'] ?? $invitation->content['acara']['akad']['alamat'];
                            $akadMapsUrl = (str_starts_with($akadMaps, 'http://') || str_starts_with($akadMaps, 'https://')) 
                                ? $akadMaps 
                                : "https://www.google.com/maps/search/?api=1&query=" . urlencode($akadMaps);
                        @endphp
                        <a href="{{ $akadMapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-maps">📍 Buka Maps</a>
                        @endif
                    </div>

                    <div class="event-card">
                        <span class="event-badge">Resepsi</span>
                        <h4 class="event-title font-elegant">{{ $invitation->content['acara']['resepsi']['judul'] ?? 'Resepsi Pernikahan' }}</h4>
                        <div class="event-detail">
                            <div class="event-detail-icon">📅</div>
                            <div class="event-detail-text">
                                <strong>{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->translatedFormat('l, d F Y') }}</strong>
                                <span>{{ \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'] ?? now())->format('H:i') }} WIB - Selesai</span>
                            </div>
                        </div>
                        <div class="event-detail">
                            <div class="event-detail-icon">📍</div>
                            <div class="event-detail-text">
                                <strong>{{ $invitation->content['acara']['resepsi']['tempat'] ?? 'Tempat' }}</strong>
                                <span>{{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</span>
                                @php
                                    $resepsiWilayah = $invitation->content['acara']['resepsi']['wilayah'] ?? [];
                                    $resepsiLine1 = collect([
                                        !empty($resepsiWilayah['village'])  ? 'Kel. '.Str::title(strtolower($resepsiWilayah['village'])) : null,
                                        !empty($resepsiWilayah['district']) ? 'Kec. '.Str::title(strtolower($resepsiWilayah['district'])) : null,
                                    ])->filter()->implode(', ');
                                    $resepsiLine2 = collect([
                                        !empty($resepsiWilayah['regency'])  ? Str::title(strtolower($resepsiWilayah['regency'])) : null,
                                        !empty($resepsiWilayah['province']) ? Str::title(strtolower($resepsiWilayah['province'])) : null,
                                    ])->filter()->implode(', ');
                                @endphp
                                @if($resepsiLine1)<span>{{ $resepsiLine1 }}</span>@endif
                                @if($resepsiLine2)<span>{{ $resepsiLine2 }}</span>@endif
                            </div>
                        </div>
                        @if(!empty($invitation->content['acara']['resepsi']['maps'] ?? null) || !empty($invitation->content['acara']['resepsi']['alamat'] ?? null))
                        @php
                            $resepsiMaps = $invitation->content['acara']['resepsi']['maps'] ?? $invitation->content['acara']['resepsi']['alamat'];
                            $resepsiMapsUrl = (str_starts_with($resepsiMaps, 'http://') || str_starts_with($resepsiMaps, 'https://')) 
                                ? $resepsiMaps 
                                : "https://www.google.com/maps/search/?api=1&query=" . urlencode($resepsiMaps);
                        @endphp
                        <a href="{{ $resepsiMapsUrl }}" target="_blank" rel="noopener noreferrer" class="btn-maps">📍 Buka Maps</a>
                        @endif
                    </div>
                </div>
            </section>

            @if(isset($invitation->content['media']['gallery']) && is_array($invitation->content['media']['gallery']) && count($invitation->content['media']['gallery']) > 0)
            <section class="section section-alt">
                <div class="section-header">
                    <h2 class="section-title font-elegant">Galeri Kami</h2>
                    <p class="section-subtitle">Momen-momen indah bersama</p>
                </div>
                <div class="gallery-grid">
                    @foreach($invitation->content['media']['gallery'] as $photo)
                    <div class="gallery-item">
                        <img src="{{ getImgUrl($photo) }}" alt="Gallery" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <div class="islamic-divider">
                <div class="islamic-divider-line"></div>
                <span class="islamic-divider-icon">✦</span>
                <div class="islamic-divider-line"></div>
            </div>

            <section class="section">
                <div class="section-header">
                    <h2 class="section-title font-elegant">Amplop Digital</h2>
                    <p class="section-subtitle">Doa restu Anda adalah hadiah terindah bagi kami</p>
                </div>

                @if(!empty($invitation->content['amplop']['bank_name']))
                <div class="gift-card">
                    <div class="gift-card-content">
                        <p class="gift-bank">{{ $invitation->content['amplop']['bank_name'] }}</p>
                        <p class="gift-number" id="rekening">{{ $invitation->content['amplop']['account_number'] ?? '' }}</p>
                        <p class="gift-name">a.n {{ $invitation->content['amplop']['account_holder'] ?? '' }}</p>
                        <button class="btn-copy" onclick="copyRek()">📋 Salin Nomor</button>
                    </div>
                </div>
                @endif

                @if(!empty($invitation->content['amplop']['qris_image']))
                <div class="gift-card" style="margin-top: 20px; text-align: center;">
                    <div class="gift-card-content">
                        <p class="gift-bank" style="margin-bottom: 12px;">Atau Pindai QRIS</p>
                        <img src="{{ getImgUrl($invitation->content['amplop']['qris_image'] ?? '') }}" alt="QRIS" loading="lazy" style="width: 180px; max-width: 70%; height: auto; aspect-ratio: 1 / 1; object-fit: contain; background: #fff; padding: 8px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); margin: 0 auto; display: block;">
                    </div>
                </div>
                @endif

                @if(!empty($invitation->content['amplop']['alamat_kado']))
                <div class="gift-address">
                    <p class="gift-address-title">🎁 Kirim Kado</p>
                    <p class="gift-address-text">{{ $invitation->content['amplop']['alamat_kado'] }}</p>
                </div>
                @endif
            </section>

            <section class="section section-alt">
                <div class="section-header">
                    <h2 class="section-title font-elegant">Kirim Ucapan</h2>
                    <p class="section-subtitle">Sampaikan doa dan harapan terbaik Anda</p>
                </div>

                <div class="rsvp-card">
                    @if(session('success'))
                    <div class="success-msg">✓ {{ session('success') }}</div>
                    @endif

                    <form action="{{ route('kirim.ucapan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="invitation_slug" value="{{ $invitation->slug }}">

                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Konfirmasi Kehadiran</label>
                            <select name="kehadiran" class="form-control" required>
                                <option value="hadir">✓ Hadir</option>
                                <option value="tidak_hadir">✗ Tidak Hadir</option>
                                <option value="ragu">? Ragu-ragu</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Ucapan & Doa</label>
                            <textarea name="ucapan" class="form-control" rows="3" placeholder="Tuliskan ucapan dan doa terbaik Anda..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit">Kirim Ucapan</button>
                    </form>

                    @php
                        $allComments = isset($comments) ? $comments : ($invitation->comments ?? collect([]));
                    @endphp

                    <div class="comments-header">
                        <span class="comments-title">Ucapan & Doa</span>
                        <span class="comments-count">{{ $allComments->count() }} ucapan</span>
                    </div>

                    <div class="comments-list">
                        @if($allComments->count() > 0)
                            @foreach($allComments->sortByDesc('created_at') as $comment)
                            <div class="comment-item">
                                <div class="comment-header">
                                    <div class="comment-avatar">{{ strtoupper(substr($comment->name, 0, 1)) }}</div>
                                    <div class="comment-info">
                                        <span class="comment-name">{{ $comment->name }}</span>
                                        <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <span class="comment-status">{{ ucfirst(str_replace('_', ' ', $comment->rsvp_status)) }}</span>
                                </div>
                                <p class="comment-text">{{ $comment->comment }}</p>
                            </div>
                            @endforeach
                        @else
                            <p style="text-align: center; color: var(--text-light); padding: 2rem 1rem; font-size: 0.85rem;">Belum ada ucapan. Jadilah yang pertama!</p>
                        @endif
                    </div>
                </div>
            </section>

            <section class="prayer-section">
                <div class="prayer-card">
                    <p class="prayer-arabic font-arabic">رَبَّنَا هَبْ لَنَا مِنْ أَزْوَاجِنَا وَذُرِّيَّاتِنَا قُرَّةَ أَعْيُنٍ وَاجْعَلْنَا لِلْمُتَّقِينَ إِمَامًا</p>
                    <p class="quote-text">"Ya Tuhan kami, anugerahkanlah kepada kami pasangan dan keturunan yang menyenangkan hati kami, dan jadikanlah kami pemimpin bagi orang-orang yang bertakwa."</p>
                    <p class="quote-ref">(QS. Al-Furqan: 74)</p>
                </div>

                <div class="closing-section">
                    <p class="closing-text">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.</p>
                    <p class="closing-salam">Wassalamu'alaikum Warahmatullahi Wabarakatuh</p>
                    <p class="closing-names font-elegant">{{ $invitation->content['mempelai']['pria']['panggilan'] ?? 'Romeo' }} & {{ $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Juliet' }}</p>
                </div>
            </section>

            <footer>
                <p style="margin-bottom: 0.5rem;">Created with ❤️</p>
                <p style="color: var(--gold); font-weight: 600;">Barakah Love Theme</p>
                <p style="margin-top: 0.75rem;">© 2026 <a href="{{ url('/') }}">Temanten</a></p>
            </footer>
        </div>
    </div>

    <script>
        function openInvitation() {
            document.getElementById('heroCover').classList.add('open');
            document.getElementById('mainContent').style.display = 'block';
            document.body.style.overflow = 'auto';

            const audio = document.getElementById('bgMusic');
            const btn = document.getElementById('musicBtn');
            if (audio && btn) {
                btn.style.display = 'flex';
                audio.play().then(() => btn.classList.add('spin')).catch(() => {});
            }
        }

        function toggleMusic() {
            const audio = document.getElementById('bgMusic');
            const btn = document.getElementById('musicBtn');
            if (audio.paused) {
                audio.play();
                btn.classList.add('spin');
            } else {
                audio.pause();
                btn.classList.remove('spin');
            }
        }

        function copyRek() {
            const rek = document.getElementById('rekening');
            if (rek) {
                navigator.clipboard.writeText(rek.innerText).then(() => alert('Nomor rekening disalin!'));
            }
        }

        const targetDate = new Date("{{ \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'] ?? now())->format('Y-m-d H:i:s') }}").getTime();
        setInterval(() => {
            const now = new Date().getTime();
            const diff = targetDate - now;
            if (diff < 0) return;
            document.getElementById('days').innerText = Math.floor(diff / (1000 * 60 * 60 * 24));
            document.getElementById('hours').innerText = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById('minutes').innerText = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById('seconds').innerText = Math.floor((diff % (1000 * 60)) / 1000);
        }, 1000);
    </script>
</body>
</html>
