<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard - Temanten</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|jetbrains-mono:500,600,700&display=swap" rel="stylesheet" />

        <script>
            (function () {
                var theme = localStorage.getItem('theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (theme === 'dark' || (!theme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --dashboard-bg: #F5F7FB;
                --dashboard-surface: #FFFFFF;
                --dashboard-surface-soft: #F9FAFB;
                --dashboard-border: #E5E7EB;
                --dashboard-text: #111827;
                --dashboard-muted: #6B7280;
                --dashboard-accent: #0891B2;
                --dashboard-live: #16A34A;
                --dashboard-danger: #DC2626;
                --dashboard-grid: rgba(148, 163, 184, 0.20);
            }
            html.dark {
                --dashboard-bg: #121212;
                --dashboard-surface: #1E1E1E;
                --dashboard-surface-soft: #181818;
                --dashboard-border: #2C2C2E;
                --dashboard-text: #FFFFFF;
                --dashboard-muted: #98989D;
                --dashboard-accent: #00E5FF;
                --dashboard-live: #32D74B;
                --dashboard-danger: #FF453A;
                --dashboard-grid: rgba(44, 44, 46, 0.28);
            }
            body {
                background: var(--dashboard-bg);
                color: var(--dashboard-text);
                font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            }
            .dashboard-shell {
                min-height: 100vh;
                background:
                    radial-gradient(circle at top left, color-mix(in srgb, var(--dashboard-accent) 12%, transparent), transparent 30rem),
                    radial-gradient(circle at bottom right, color-mix(in srgb, var(--dashboard-live) 10%, transparent), transparent 28rem),
                    var(--dashboard-bg);
            }
            .dashboard-header {
                background: color-mix(in srgb, var(--dashboard-bg) 92%, transparent);
                border-bottom: 1px solid var(--dashboard-border);
                box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
                backdrop-filter: blur(14px);
            }
            .dashboard-header h1,
            .dashboard-header h2,
            .dashboard-header h3 {
                color: var(--dashboard-text) !important;
            }
        </style>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    </head>
    <body class="font-sans antialiased overflow-y-auto">
        
        <div class="dashboard-shell">
            @auth
                @include('layouts.navigation')
            @endauth

            @isset($header)
                <header class="dashboard-header transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
        
        <x-theme-toggle />
    </body>
</html>