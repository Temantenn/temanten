<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post['title'] }} · Temanten Blog</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @php
        $seoTitle = $post['title'] . ' · Temanten Blog';
        $seoDescription = $post['description'];
        $seoImage = asset($post['og_image'] ?? 'assets/og-image.jpg');
        $seoKeywords = $post['keywords'] ?? 'undangan pernikahan digital';
        $seoType = 'article';
    @endphp

    @include('partials.seo', [
        'seoTitle'       => $seoTitle,
        'seoDescription' => $seoDescription,
        'seoImage'       => $seoImage,
        'seoType'        => $seoType,
        'seoKeywords'    => $seoKeywords,
        'seoAuthor'      => $post['author'] ?? 'Tim Temanten',
    ])

    {{-- Article schema.org JSON-LD for Google rich results --}}
    @php
        $articleSchema = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => $post['title'],
            'description'   => $post['description'],
            'image'         => $seoImage,
            'datePublished' => $post['date'],
            'author'        => ['@type' => 'Person', 'name' => $post['author'] ?? 'Tim Temanten'],
            'publisher'     => [
                '@type' => 'Organization',
                'name'  => 'Temanten',
                'logo'  => ['@type' => 'ImageObject', 'url' => asset('assets/logo.jpg')],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg: #faf7f2;
            --color-text: #2d2419;
            --color-text-muted: #6b5d4f;
            --color-gold: #b8924a;
            --color-brown: #6f4e2a;
            --color-card: #ffffff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--color-bg); color: var(--color-text); line-height: 1.7; }
        a { color: var(--color-gold); text-decoration: none; }
        a:hover { text-decoration: underline; }

        .header { background: var(--color-card); border-bottom: 1px solid rgba(184,146,74,.15); position: sticky; top: 0; z-index: 100; }
        .header-inner { max-width: 1200px; margin: 0 auto; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 26px; font-weight: 700; color: var(--color-brown); letter-spacing: -.02em; }
        .logo span { color: var(--color-gold); }
        .nav { display: flex; gap: 24px; align-items: center; }
        .nav a { color: var(--color-text); font-weight: 500; font-size: 15px; }
        .nav .btn-cta { background: var(--color-brown); color: white !important; padding: 10px 20px; border-radius: 8px; font-weight: 600; }

        .article { max-width: 760px; margin: 0 auto; padding: 60px 24px 40px; }
        .breadcrumb { font-size: 14px; color: var(--color-text-muted); margin-bottom: 24px; }
        .breadcrumb a { color: var(--color-text-muted); }
        .article-meta { display: flex; gap: 16px; align-items: center; margin-bottom: 20px; font-size: 14px; color: var(--color-text-muted); }
        .article-meta .author { font-weight: 600; color: var(--color-brown); }
        .article h1 { font-family: 'Cormorant Garamond', serif; font-size: clamp(32px, 5vw, 48px); font-weight: 600; line-height: 1.2; letter-spacing: -.02em; margin-bottom: 24px; color: var(--color-brown); }
        .article .description { font-size: 19px; color: var(--color-text-muted); margin-bottom: 32px; font-style: italic; padding-left: 16px; border-left: 3px solid var(--color-gold); }
        .article-body { font-size: 17px; }
        .article-body h2 { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 600; margin: 40px 0 16px; color: var(--color-brown); }
        .article-body h3 { font-size: 22px; font-weight: 600; margin: 32px 0 12px; color: var(--color-brown); }
        .article-body p { margin-bottom: 18px; }
        .article-body ul, .article-body ol { margin: 0 0 18px 24px; }
        .article-body li { margin-bottom: 8px; }
        .article-body blockquote { background: rgba(184,146,74,.08); border-left: 4px solid var(--color-gold); padding: 16px 20px; margin: 24px 0; font-style: italic; border-radius: 0 8px 8px 0; }
        .article-body code { background: rgba(184,146,74,.12); padding: 2px 6px; border-radius: 4px; font-size: 15px; font-family: ui-monospace, monospace; color: var(--color-brown); }
        .article-body strong { color: var(--color-brown); font-weight: 600; }

        .cta-box { background: linear-gradient(135deg, var(--color-brown), var(--color-gold)); color: white; padding: 32px; border-radius: 14px; text-align: center; margin: 48px 0; }
        .cta-box h3 { font-family: 'Cormorant Garamond', serif; font-size: 26px; margin-bottom: 12px; color: white; }
        .cta-box p { margin-bottom: 20px; opacity: .92; }
        .cta-box a { display: inline-block; background: white; color: var(--color-brown); padding: 12px 28px; border-radius: 8px; font-weight: 600; }
        .cta-box a:hover { text-decoration: none; transform: scale(1.02); transition: transform .15s; }

        .related { max-width: 1200px; margin: 0 auto; padding: 40px 24px 80px; border-top: 1px solid rgba(184,146,74,.15); }
        .related h3 { font-family: 'Cormorant Garamond', serif; font-size: 28px; color: var(--color-brown); margin-bottom: 24px; text-align: center; }
        .related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 24px; }
        .related-card { background: var(--color-card); border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(45,36,25,.06); }
        .related-card h4 { font-family: 'Cormorant Garamond', serif; font-size: 20px; margin-bottom: 8px; color: var(--color-brown); }
        .related-card time { font-size: 13px; color: var(--color-text-muted); }

        @media (max-width: 768px) {
            .nav { gap: 12px; }
            .nav a:not(.btn-cta) { display: none; }
            .article { padding: 32px 20px 24px; }
            .related-grid { grid-template-columns: 1fr; }
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

    <article class="article">
        <nav class="breadcrumb">
            <a href="/">Beranda</a> › <a href="/blog">Blog</a> › <span>{{ \Illuminate\Support\Str::limit($post['title'], 50) }}</span>
        </nav>

        <div class="article-meta">
            <span class="author">{{ $post['author'] }}</span>
            <span>·</span>
            <time datetime="{{ $post['date'] }}">{{ \Carbon\Carbon::parse($post['date'])->translatedFormat('d F Y') }}</time>
            <span>·</span>
            <span>{{ $post['reading_min'] }} min baca</span>
        </div>

        <h1>{{ $post['title'] }}</h1>
        <p class="description">{{ $post['description'] }}</p>

        <div class="article-body">
            {!! $post['body'] !!}

            <div class="cta-box">
                <h3>Siap Buat Undangan Impian?</h3>
                <p>Pilih dari 16+ tema eksklusif. Preview langsung, order hari ini, file siap 1×24 jam.</p>
                <a href="/themes">Lihat Katalog Tema →</a>
            </div>
        </div>
    </article>

    @if(count($related) > 0)
    <section class="related">
        <h3>Artikel Terkait</h3>
        <div class="related-grid">
            @foreach($related as $r)
                <a href="/blog/{{ $r['slug'] }}" class="related-card">
                    <time datetime="{{ $r['date'] }}">{{ \Carbon\Carbon::parse($r['date'])->translatedFormat('d F Y') }}</time>
                    <h4>{{ $r['title'] }}</h4>
                </a>
            @endforeach
        </div>
    </section>
    @endif
</body>
</html>
