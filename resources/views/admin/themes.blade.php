<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Harga Tema — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        @keyframes fadeInUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .animate-in { animation: fadeInUp 0.45s ease-out both; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">

{{-- ── TOPBAR ─────────────────────────────────────────────── --}}
<nav class="bg-white dark:bg-slate-800 border-b border-gray-100 dark:border-slate-700/50 sticky top-0 z-50 shadow-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 transition flex items-center gap-2 text-xs sm:text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
            <span class="text-gray-300 dark:text-slate-600">|</span>
            <h1 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white flex flex-wrap items-center gap-2">
                🎨 <span class="hidden sm:inline">Manajemen</span> Harga 
                <span class="text-[0.65rem] sm:text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 px-2 py-0.5 rounded-full ml-1">Admin</span>
            </h1>
        </div>
        
        <button id="themeToggle" class="p-2 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors focus:outline-none" title="Toggle Dark Mode">
            <svg id="themeIconSun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg id="themeIconMoon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>
</nav>

<div class="max-w-6xl mx-auto px-6 py-10 space-y-8">

    {{-- ── ALERTS ─────────────────────────────────────────── --}}
    @if(session('success'))
        <x-alert-success :message="session('success')" />
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl animate-in">
        <ul class="list-disc pl-5 space-y-1 text-sm">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- ── HARGA DEFAULT GLOBAL ─────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700/50 overflow-hidden animate-in transition-colors duration-300">
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/40 dark:to-purple-900/40 px-8 py-6 border-b border-gray-100 dark:border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 004 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Harga Default Global</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Berlaku untuk tema yang tidak memiliki harga khusus</p>
                </div>
            </div>
        </div>
        <div class="px-8 py-6">
            <form action="{{ route('admin.themes.defaultPrice') }}" method="POST">
                @csrf
                <label class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2">Harga Default (Rp)</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="flex-1 w-full relative">
                        <div class="flex rounded-xl overflow-hidden border-2 border-gray-200 dark:border-slate-600 focus-within:border-indigo-500 dark:focus-within:border-indigo-400 transition-all">
                            <span class="inline-flex items-center px-4 bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 text-sm font-semibold border-r border-gray-200 dark:border-slate-600">Rp</span>
                            <input type="number" name="default_price"
                                   value="{{ $defaultPrice }}"
                                   min="0" max="99999999" step="1000"
                                   class="flex-1 px-4 py-3 text-lg font-bold text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:outline-none"
                                   required>
                        </div>
                    </div>
                    <button type="submit" class="w-full sm:w-auto self-stretch bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-3 rounded-xl transition flex items-center justify-center gap-2 shadow-lg shadow-indigo-200 dark:shadow-none whitespace-nowrap text-sm sm:text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Default
                    </button>
                </div>
                <p class="text-xs text-gray-400 dark:text-slate-500 mt-2">Nilai saat ini: <strong class="dark:text-slate-300">Rp {{ number_format($defaultPrice, 0, ',', '.') }}</strong> · Disimpan di file <code class="bg-gray-100 dark:bg-slate-700 px-1 rounded">.env</code></p>
            </form>
        </div>
    </div>

    {{-- ── HARGA PER TEMA ─────────────────────────────────── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-100 dark:border-slate-700/50 overflow-hidden animate-in transition-colors duration-300" style="animation-delay:0.1s">
        <div class="bg-gradient-to-r from-rose-50 to-pink-50 dark:from-rose-900/30 dark:to-pink-900/30 px-8 py-6 border-b border-gray-100 dark:border-slate-700/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Harga Per Tema</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Kosongkan harga untuk menggunakan harga default global</p>
                </div>
            </div>
        </div>

        <div class="divide-y divide-gray-50 dark:divide-slate-700/50">
            @foreach($themes as $theme)
            @php
                $hasCustom = !is_null($theme->price);
                $thumbFile = $theme->thumbnail ?: ($theme->slug . '.webp');
                $thumbExists = file_exists(public_path('assets/thumbnail/' . $thumbFile));
            @endphp
            <div class="px-8 py-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 hover:bg-gray-50/60 dark:hover:bg-slate-700/30 transition-colors group">

                {{-- Thumbnail --}}
                <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 shadow border border-gray-100 dark:border-slate-600">
                    @if($thumbExists)
                        <img src="{{ asset('assets/thumbnail/' . $thumbFile) }}" class="w-full h-full object-cover" alt="">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center text-xs font-bold text-indigo-500 dark:text-indigo-300">{{ substr($theme->name,0,2) }}</div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1.5 mt-1 sm:mt-0">
                        <h3 class="font-bold text-gray-900 dark:text-white text-base">{{ $theme->name }}</h3>
                        @if($hasCustom)
                            @if($theme->has_promo)
                                <span class="bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[0.65rem] font-bold px-2 py-0.5 rounded flex items-center gap-1 uppercase tracking-wider">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path></svg>
                                    Promo Aktif
                                </span>
                            @else
                                <span class="bg-rose-100 dark:bg-rose-500/20 text-rose-700 dark:text-rose-400 text-[0.65rem] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Harga Khusus</span>
                            @endif
                        @else
                            <span class="bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-400 text-[0.65rem] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Pakai Default</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($theme->has_promo)
                            <span class="text-xs text-gray-400 dark:text-slate-500 line-through font-semibold">{{ $theme->formatted_original_price }}</span>
                            <span class="text-sm font-extrabold text-amber-600 dark:text-amber-400">{{ $theme->formatted_price }}</span>
                        @else
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $theme->formatted_price }}</span>
                        @endif
                    </div>
                </div>

                {{-- Form harga --}}
                <form action="{{ route('admin.themes.price', $theme->id) }}" method="POST"
                      class="flex flex-col sm:flex-row items-end sm:items-center gap-2 flex-shrink-0 mt-3 sm:mt-0 w-full sm:w-auto">
                    @csrf
                    
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        <!-- Harga Normal Input -->
                        <div class="flex items-center gap-2">
                            <span class="text-[0.65rem] uppercase font-bold text-gray-400 dark:text-slate-500 w-16 sm:w-auto sm:hidden">Normal:</span>
                            <div class="flex rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 focus-within:border-indigo-500 dark:focus-within:border-indigo-400 transition-all flex-1 sm:flex-initial">
                                <span class="inline-flex items-center px-2.5 bg-gray-50 dark:bg-slate-700/50 text-gray-400 dark:text-slate-400 text-xs font-bold border-r border-gray-200 dark:border-slate-600">Rp</span>
                                <input type="number" name="price"
                                    value="{{ $theme->price ?? '' }}"
                                    min="0" max="99999999" step="1000"
                                    placeholder="{{ number_format($defaultPrice, 0, ',', '.') }}"
                                    class="w-full sm:w-28 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white bg-white dark:bg-slate-800 focus:outline-none placeholder-gray-300 dark:placeholder-slate-600">
                            </div>
                        </div>

                        <!-- Harga Promo Input -->
                        <div class="flex items-center gap-2">
                            <span class="text-[0.65rem] uppercase font-bold text-amber-500 dark:text-amber-500 w-16 sm:w-auto sm:hidden">Promo:</span>
                            <div class="flex rounded-lg overflow-hidden border border-amber-200 dark:border-amber-500/30 focus-within:border-amber-500 dark:focus-within:border-amber-400 transition-all shadow-sm flex-1 sm:flex-initial">
                                <span class="inline-flex items-center px-2.5 bg-amber-50 dark:bg-amber-500/10 text-amber-500 dark:text-amber-400 text-xs font-bold border-r border-amber-200 dark:border-amber-500/30">Rp</span>
                                <input type="number" name="promo_price"
                                    value="{{ $theme->promo_price ?? '' }}"
                                    min="0" max="99999999" step="1000"
                                    placeholder="Opsional"
                                    class="w-full sm:w-28 px-2.5 py-1.5 text-sm font-semibold text-gray-900 dark:text-white focus:outline-none bg-amber-50/30 dark:bg-slate-800 placeholder-amber-200 dark:placeholder-slate-600 cursor-text">
                            </div>
                        </div>
                    </div>

                    <div class="flex sm:flex-col gap-2 ml-0 sm:ml-2 h-full justify-center w-full sm:w-auto mt-2 sm:mt-0">
                        <button type="submit"
                                class="flex-1 sm:flex-initial bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm h-full max-h-10">
                            Simpan
                        </button>
                        @if($hasCustom)
                        <button type="submit" form="reset-{{ $theme->id }}"
                                class="flex-1 sm:flex-initial bg-gray-100 dark:bg-slate-700/50 hover:bg-red-50 dark:hover:bg-red-500/10 text-gray-500 dark:text-slate-400 hover:text-red-500 dark:hover:text-red-400 border border-gray-200 dark:border-slate-600 hover:border-red-200 dark:hover:border-red-500/30 transition text-xs font-semibold px-4 py-2 rounded-lg"
                                title="Reset ke default">Reset</button>
                        @endif
                    </div>
                </form>

                {{-- Hidden reset form --}}
                @if($hasCustom)
                <form id="reset-{{ $theme->id }}" action="{{ route('admin.themes.price', $theme->id) }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="price" value="">
                    <input type="hidden" name="promo_price" value="">
                </form>
                @endif
            </div>
            @endforeach
        </div>

        <div class="px-8 py-4 bg-amber-50 dark:bg-amber-500/10 border-t border-amber-100 dark:border-amber-500/20 flex items-center gap-3 transition-colors duration-300">
            <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            <p class="text-[0.7rem] sm:text-xs text-amber-700 dark:text-amber-400 font-medium">Kosongkan field harga normal dan klik Simpan untuk menghapus harga khusus (tema akan kembali menggunakan harga default global).</p>
        </div>

        {{-- Pagination --}}
        @if($themes->hasPages())
            <div class="px-8 py-4 border-t border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-800/30">
                {{ $themes->links('vendor.pagination.admin-tailwind') }}
            </div>
        @endif
    </div>

    {{-- ── RINGKASAN ─────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 animate-in" style="animation-delay:0.2s">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 shadow-sm px-4 sm:px-5 py-4 text-center transition-colors duration-300 flex flex-col justify-center">
            <div class="text-xl sm:text-2xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $totalCount }}</div>
            <div class="text-[0.65rem] sm:text-xs font-bold tracking-wider uppercase text-gray-500 dark:text-slate-400 mt-1">Total Tema</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 shadow-sm px-4 sm:px-5 py-4 text-center transition-colors duration-300 flex flex-col justify-center">
            <div class="text-xl sm:text-2xl font-extrabold text-rose-500 dark:text-rose-400">{{ $customCount }}</div>
            <div class="text-[0.65rem] sm:text-xs font-bold tracking-wider uppercase text-gray-500 dark:text-slate-400 mt-1">Harga Kh.</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 shadow-sm px-3 sm:px-5 py-4 text-center transition-colors duration-300 flex flex-col justify-center">
            <div class="text-sm sm:text-lg font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">Rp <br class="sm:hidden">{{ number_format($minPrice, 0, ',', '.') }}</div>
            <div class="text-[0.6rem] sm:text-[0.65rem] font-bold tracking-wider uppercase text-gray-500 dark:text-slate-400 mt-1.5">Terendah</div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 shadow-sm px-3 sm:px-5 py-4 text-center transition-colors duration-300 flex flex-col justify-center">
            <div class="text-sm sm:text-lg font-extrabold text-purple-600 dark:text-purple-400 mt-1">Rp <br class="sm:hidden">{{ number_format($maxPrice, 0, ',', '.') }}</div>
            <div class="text-[0.6rem] sm:text-[0.65rem] font-bold tracking-wider uppercase text-gray-500 dark:text-slate-400 mt-1.5">Tertinggi</div>
        </div>
    </div>

</div>

<script>
    const themeToggleBtn = document.getElementById('themeToggle');
    const themeIconSun = document.getElementById('themeIconSun');
    const themeIconMoon = document.getElementById('themeIconMoon');
    const html = document.documentElement;

    // Cek theme dari localStorage ATAU preferensi sistem
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
        themeIconSun.classList.remove('hidden');
        themeIconMoon.classList.add('hidden');
    } else {
        html.classList.remove('dark');
        themeIconMoon.classList.remove('hidden');
        themeIconSun.classList.add('hidden');
    }

    // Toggle theme
    themeToggleBtn.addEventListener('click', () => {
        html.classList.toggle('dark');
        
        if (html.classList.contains('dark')) {
            localStorage.theme = 'dark';
            themeIconSun.classList.remove('hidden');
            themeIconMoon.classList.add('hidden');
        } else {
            localStorage.theme = 'light';
            themeIconMoon.classList.remove('hidden');
            themeIconSun.classList.add('hidden');
        }
    });
</script>
</body>
</html>
