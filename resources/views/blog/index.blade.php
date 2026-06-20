@php
    $seoTitle = 'Blog Temanten — Tips & Inspirasi Undangan Pernikahan Digital';
    $seoDescription = 'Artikel terbaru tentang undangan pernikahan digital: tips memilih tema, cara order, hingga strategi SEO biar undangan lo gampang ditemukan.';
    $seoImage = asset('assets/og-image.jpg');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seoTitle }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @include('partials.seo', [
        'seoTitle'       => $seoTitle,
        'seoDescription' => $seoDescription,
        'seoImage'       => $seoImage,
    ])

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg: #faf7f2;
            --color-text: #2d2419;
            --color-text-muted: #6b5d4f;
            --color-gold: #b8924a;
            --color-brown: #6f4e2a;
            --color-card: #ffffff;
            --shadow-sm: 0 1px 3px rgba(45,36,25,.06), 0 1px 2px rgba(45,36,25,.04);
            --shadow-md: 0 4px 16px rgba(45,36,25,.08);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--color-bg); color: var(--color-text); line-height: 1.6; }

        /* Header */
        .header { background: var(--color-card); border-bottom: 1px solid rgba(184,146,74,.15); position: sticky; top: 0; z-index: 100; backdrop-filter: blur(8px); }
        .header-inner { max-width: 1200px; margin: 0 auto; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 700; color: var(--color-brown); text-decoration: none; letter-spacing: -.02em; }
        .logo span { color: var(--color-gold); }
        .nav { display: flex; gap: 24px; align-items: center; }
        .nav a { color: var(--color-text); text-decoration: none; font-weight: 500; font-size: 15px; transition: color .2s; }
        .nav a:hover { color: var(--color-gold); }
        .nav .btn-cta { background: var(--color-brown); color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; }
        .nav .btn-cta:hover { background: var(--color-gold); color: white; }

        /* Hero */
        .hero { max-width: 1200px; margin: 0 auto; padding: 80px 24px 40px; text-align: center; }
        .hero h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(36px, 6vw, 56px); font-weight: 600; letter-spacing: -.02em; margin-bottom: 16px; color: var(--color-brown); }
        .hero h1 span { color: var(--color-gold); font-style: italic; }
        .hero p { font-size: 18px; color: var(--color-text-muted); max-width: 680px; margin: 0 auto; }

        /* Posts grid */
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 24px 80px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 32px; }
        .card { background: var(--color-card); border-radius: 14px; overflow: hidden; box-shadow: var(--shadow-sm); transition: transform .25s, box-shadow .25s; text-decoration: none; color: inherit; display: flex; flex-direction: column; }
        .card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .card-image { aspect-ratio: 16/9; background: linear-gradient(135deg, var(--color-gold), var(--color-brown)); display: flex; align-items: center; justify-content: center; color: white; font-family: 'Cormorant Garamond', serif; font-size: 64px; font-weight: 600; font-style: italic; }
        .card-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .card-meta { display: flex; gap: 12px; font-size: 13px; color: var(--color-text-muted); margin-bottom: 12px; }
        .card-meta time { font-weight: 500; }
        .card h2 { font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 600; line-height: 1.3; margin-bottom: 12px; color: var(--color-brown); }
        .card p { font-size: 15px; color: var(--color-text-muted); flex: 1; }
        .card-cta { margin-top: 16px; color: var(--color-gold); font-weight: 600; font-size: 14px; }

        @media (max-width: 768px) {
            .nav { gap: 12px; }
            .nav a:not(.btn-cta) { display: none; }
            .hero { padding: 48px 24px 24px; }
            .grid { grid-template-columns: 1fr; gap: 20px; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a href="/" class="logo">TEMANTEN<span>.</span></a>
            <nav class="nav">
                <a href="/themes">Tema</a>
                <a href="/blog">Blog</a>
                <a href="/buat-undangan" class="btn-cta">Buat Undangan</a>
            </nav>
        </div>
    </header>

    <section class="hero">
        <h1>Inspirasi &amp; <span>Tips</span> Pernikahan Digital</h1>
        <p>Panduan lengkap memilih tema, mengirim undangan via WhatsApp, hingga strategi SEO biar undangan lo gampang ditemukan calon tamu.</p>
    </section>

    <main class="container">
        <div class="grid">
            @foreach($posts as $post)
                <a href="/blog/{{ $post['slug'] }}" class="card">
                    <div class="card-image">
                        {{ Str::limit($post['title'], 1, '') }}
                    </div>
                    <div class="card-body">
                        <div class="card-meta">
                            <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->translatedFormat('d F Y') }}</time>
                            <span>·</span>
                            <span>{{ $post['reading_min'] }} min baca</span>
                        </div>
                        <h2>{{ $post['title'] }}</h2>
                        <p>{{ $post['description'] }}</p>
                        <div class="card-cta">Baca selengkapnya →</div>
                    </div>
                </a>
            @endforeach
        </div>
    </main>
</body>
</html>
