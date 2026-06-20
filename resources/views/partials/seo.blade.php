@php
    /*
    |--------------------------------------------------------------------------
    | SEO Partial — meta description + Open Graph + Twitter Card
    |--------------------------------------------------------------------------
    |
    | Variabel yang bisa di-override (opsional, semua punya default):
    |   $seoTitle        string  — page title (default: "Temanten — Platform Undangan Digital Elegan")
    |   $seoDescription  string  — deskripsi 150-160 char untuk SERP
    |   $seoImage        string  — full URL OG image 1200x630 ideal
    |   $seoType         string  — og:type (default: "website")
    |   $seoUrl          string  — og:url canonical
    |   $seoKeywords     string  — comma-separated keywords
    |
    | Pemakaian:
    |   @include('partials.seo')
    |   atau override:
    |   @include('partials.seo', ['seoTitle' => 'Judul custom', 'seoDescription' => '...'])
    |
    */

    $defaultTitle       = 'Temanten — Platform Undangan Digital Elegan';
    $defaultDescription = 'Buat undangan pernikahan digital yang elegan dan modern. 16+ tema eksklusif Islami, Boho, Floral, Modern, Tradisional. RSVP, galeri, musik, dan amplop digital dalam satu paket.';
    $defaultImage       = asset('assets/og-image.jpg');
    $defaultType        = 'website';
    $defaultKeywords    = 'undangan digital, undangan pernikahan, wedding invitation, undangan online, temanten, undangan modern, undangan islami, undangan jawa';

    $seoTitle       = $seoTitle       ?? $defaultTitle;
    $seoDescription = $seoDescription ?? $defaultDescription;
    $seoImage       = $seoImage       ?? $defaultImage;
    $seoType        = $seoType        ?? $defaultType;
    $seoUrl         = $seoUrl         ?? url()->current();
    $seoKeywords    = $seoKeywords    ?? $defaultKeywords;
@endphp

{{-- Primary meta --}}
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">
<meta name="author" content="Temanten">
<meta name="robots" content="index, follow">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $seoType }}">
<meta property="og:url" content="{{ $seoUrl }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:image" content="{{ $seoImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $seoTitle }}">
<meta property="og:site_name" content="Temanten">
<meta property="og:locale" content="id_ID">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $seoUrl }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
<meta name="twitter:image" content="{{ $seoImage }}">
<meta name="twitter:image:alt" content="{{ $seoTitle }}">

{{-- Canonical --}}
<link rel="canonical" href="{{ $seoUrl }}">
