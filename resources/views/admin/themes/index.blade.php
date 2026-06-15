<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Thumbnail & Musik Tema — Admin Temanten</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen">

    {{-- Top bar --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </a>
                <div>
                    <h1 class="text-base sm:text-lg font-bold text-slate-900">Manajemen Tema</h1>
                    <p class="text-xs text-slate-500">Thumbnail & Default Music</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.themes.pricing') }}" class="hidden sm:inline-flex items-center gap-2 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Kelola Harga
                </a>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg transition">
                    Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Flash message --}}
        @if(session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-3 text-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="rounded-xl border border-rose-200 bg-rose-50 text-rose-800 px-4 py-3 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Page header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">Thumbnail & Default Music</h2>
                <p class="text-sm text-slate-500 mt-1">Upload thumbnail (auto-convert WebP) dan musik default untuk masing-masing tema. File lama otomatis terhapus saat diganti.</p>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-semibold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Thumbnail: JPG/PNG/WEBP → WebP q80
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-purple-50 text-purple-700 font-semibold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                    Music: MP3/M4A/WAV/OGG
                </span>
            </div>
        </div>

        {{-- Themes grid --}}
        @if($themes->isEmpty())
            <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-white p-12 text-center">
                <div class="text-5xl mb-3">🎨</div>
                <h3 class="font-bold text-slate-700">Belum ada tema</h3>
                <p class="text-sm text-slate-500 mt-1">Tambah tema terlebih dahulu di database.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($themes as $theme)
                    @php
                        $thumbStorage = $theme->thumbnail
                            ? asset('storage/themes/thumbnails/' . $theme->thumbnail)
                            : null;
                        $musicUrl = $theme->default_music
                            ? asset('storage/themes/music/' . $theme->default_music)
                            : null;
                        $isActive = (bool) ($theme->is_active ?? true);
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        {{-- Thumbnail preview --}}
                        <div class="relative aspect-[9/16] max-h-72 bg-gradient-to-br from-slate-100 to-slate-200 overflow-hidden">
                            @if($thumbStorage)
                                <img src="{{ $thumbStorage }}" alt="Thumbnail {{ $theme->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-xs font-medium">Belum ada thumbnail</span>
                                </div>
                            @endif
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/90 backdrop-blur text-[10px] font-bold text-slate-700 shadow-sm">
                                    {{ $theme->slug }}
                                </span>
                            </div>
                            <div class="absolute top-2 right-2">
                                @if($isActive)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/90 text-white text-[10px] font-bold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-500/90 text-white text-[10px] font-bold">
                                        Non-aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Info + form --}}
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="font-bold text-slate-900">{{ $theme->name }}</h3>
                            <div class="text-xs text-slate-500 mt-0.5 space-y-0.5">
                                <p>Thumbnail: <span class="font-mono text-slate-600">{{ $theme->thumbnail ?? '— belum diupload —' }}</span></p>
                                <p>Music: <span class="font-mono text-slate-600">{{ $theme->default_music ?? '— belum diupload —' }}</span></p>
                            </div>

                            @if($musicUrl)
                                <audio controls preload="none" class="w-full mt-3 h-9" style="border-radius: 8px;">
                                    <source src="{{ $musicUrl }}" type="audio/mpeg">
                                    Browser tidak mendukung audio.
                                </audio>
                            @endif

                            <form action="{{ route('admin.themes.update', $theme->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3 flex-1 flex flex-col">
                                @csrf
                                @method('PUT')

                                {{-- Thumbnail input --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1 uppercase tracking-wider">Thumbnail Baru</label>
                                    <label class="flex flex-col items-center justify-center w-full h-20 px-3 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 transition group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-[10px] text-slate-500 group-hover:text-indigo-600 font-semibold text-center">
                                            JPG / PNG / WEBP (max 8MB) → auto WebP
                                        </span>
                                        <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="this.previousElementSibling.previousElementSibling.querySelector('span')&&(this.previousElementSibling.previousElementSibling.querySelector('span').textContent=this.files[0]?.name||'JPG / PNG / WEBP (max 8MB) → auto WebP')">
                                    </label>
                                </div>

                                {{-- Music input --}}
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1 uppercase tracking-wider">Default Music Baru</label>
                                    <label class="flex flex-col items-center justify-center w-full h-20 px-3 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-purple-400 hover:bg-purple-50/40 transition group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                                        <span class="text-[10px] text-slate-500 group-hover:text-purple-600 font-semibold text-center">
                                            MP3 / M4A / WAV / OGG (max 20MB)
                                        </span>
                                        <input type="file" name="default_music" accept="audio/mpeg,audio/mp4,audio/x-m4a,audio/wav,audio/ogg" class="hidden" onchange="this.previousElementSibling.previousElementSibling.querySelector('span')&&(this.previousElementSibling.previousElementSibling.querySelector('span').textContent=this.files[0]?.name||'MP3 / M4A / WAV / OGG (max 20MB)')">
                                    </label>
                                </div>

                                <button type="submit" class="mt-auto w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-200 hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Simpan Thumbnail & Musik
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="text-xs text-slate-400 text-center pt-4">
            © {{ date('Y') }} Temanten Admin · File lama otomatis terhapus saat diganti.
        </p>
    </main>

</body>
</html>
