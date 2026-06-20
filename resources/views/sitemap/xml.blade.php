@php
    $base = rtrim(config('app.url'), '/');
    $now = now()->toAtomString();

    // Static public pages
    $static = [
        ['loc' => '/',         'priority' => '1.0', 'changefreq' => 'weekly'],
        ['loc' => '/themes',   'priority' => '0.9', 'changefreq' => 'weekly'],
        ['loc' => '/buat-undangan', 'priority' => '0.9', 'changefreq' => 'monthly'],
        ['loc' => '/blog',     'priority' => '0.8', 'changefreq' => 'weekly'],
    ];

    // Theme detail pages — sample demo URLs (no real order needed)
    $themeSlugs = ['barakah-love','boho-terracotta','celestial-night','cherry-blossom',
        'emerald-garden','floral-pastel','golden-sunrise','jawa-keraton',
        'midnight-garden','ocean-breeze','pixel-adventure','royal-glass',
        'rustic-green','sekar-jagad','sunda-asih','watercolor-flow'];

    // Blog posts
    $posts = [
        ['slug' => '10-tema-undangan-pernikahan-islami-modern-2026', 'date' => '2026-06-15'],
        ['slug' => 'cara-buat-undangan-pernikahan-digital-gratis',   'date' => '2026-06-10'],
    ];
@endphp
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($static as $s)
    <url>
        <loc>{{ $base }}{{ $s['loc'] }}</loc>
        <lastmod>{{ $now }}</lastmod>
        <changefreq>{{ $s['changefreq'] }}</changefreq>
        <priority>{{ $s['priority'] }}</priority>
    </url>
@endforeach
@foreach($themeSlugs as $slug)
    <url>
        <loc>{{ $base }}/themes/{{ $slug }}</loc>
        <lastmod>{{ $now }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
@endforeach
@foreach($posts as $p)
    <url>
        <loc>{{ $base }}/blog/{{ $p['slug'] }}</loc>
        <lastmod>{{ $p['date'] }}T08:00:00+07:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
@endforeach
</urlset>
