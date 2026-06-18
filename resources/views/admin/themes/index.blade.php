<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.18em]" style="color: var(--dashboard-muted);">Manajemen</p>
            <h1 class="font-semibold text-[22px] leading-[1.1] tracking-[-0.4px] mt-1" style="color: var(--dashboard-text);">Thumbnail &amp; Default Music</h1>
            <p class="text-[13px] mt-1" style="color: var(--dashboard-muted);">Upload thumbnail (auto WebP) dan musik default per tema · {{ $themes->total() }} tema terdaftar</p>
        </div>
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }

        /* ===== Table container ===== */
        .themes-shell {
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .themes-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
        }

        /* Header */
        .themes-table thead th {
            position: sticky; top: 0; z-index: 2;
            background: var(--dashboard-surface-soft);
            color: var(--dashboard-muted);
            font-size: 10.5px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.1em;
            text-align: left;
            padding: 10px 14px;
            border-bottom: 1px solid var(--dashboard-border);
            white-space: nowrap;
        }
        .themes-table thead th.num { text-align: right; }
        .themes-table thead th.center { text-align: center; }

        /* Body */
        .themes-table tbody tr {
            transition: background 0.12s ease;
        }
        .themes-table tbody tr:hover { background: var(--dashboard-surface-soft); }
        .themes-table tbody tr + tr td { border-top: 1px solid var(--dashboard-border); }

        .themes-table td {
            padding: 10px 14px;
            vertical-align: middle;
            color: var(--dashboard-text);
        }

        /* ===== Mini thumbnail ===== */
        .thumb {
            width: 56px; height: 40px;
            border-radius: 6px;
            overflow: hidden;
            background: var(--dashboard-surface-soft);
            display: flex; align-items: center; justify-content: center;
            border: 1px solid var(--dashboard-border);
            flex-shrink: 0;
        }
        .thumb img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        .thumb-empty {
            color: var(--dashboard-muted); opacity: 0.55;
            font-size: 9px; font-weight: 500;
            text-align: center; line-height: 1.05;
        }

        /* ===== Name + slug ===== */
        .theme-name {
            font-weight: 600; color: var(--dashboard-text);
            font-size: 13.5px; line-height: 1.25;
            letter-spacing: -0.1px;
        }
        .theme-slug-row {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 11px;
            color: var(--dashboard-muted);
            margin-top: 1px;
        }

        /* ===== Status pill ===== */
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 2px 8px; border-radius: 999px;
            font-size: 10.5px; font-weight: 600;
            letter-spacing: 0.02em;
        }
        .status-on {
            background: rgba(16, 185, 129, 0.10);
            color: #047857;
        }
        .status-off {
            background: var(--dashboard-surface-soft);
            color: var(--dashboard-muted);
            border: 1px solid var(--dashboard-border);
        }
        .dark .status-on { background: rgba(16, 185, 129, 0.18); color: #34d399; }
        .dark .status-on { background: rgba(16, 185, 129, 0.18); color: #34d399; }

        /* ===== Filename display ===== */
        .file-name {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 11.5px;
            color: var(--dashboard-muted);
            display: block;
            max-width: 180px;
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        .file-name.has { color: var(--dashboard-text); }
        .file-empty { color: var(--dashboard-muted); opacity: 0.55; }

        /* ===== Compact dropzone ===== */
        .drop-mini {
            position: relative;
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 10px;
            background: var(--dashboard-surface-soft);
            border: 1px dashed var(--dashboard-border);
            border-radius: 7px;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            min-width: 180px;
        }
        .drop-mini:hover, .drop-mini.is-drag {
            border-color: var(--dashboard-accent);
            background: color-mix(in srgb, var(--dashboard-accent) 5%, var(--dashboard-surface-soft));
        }
        .drop-mini input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer;
            width: 100%; height: 100%;
        }
        .drop-mini svg { width: 14px; height: 14px; flex-shrink: 0; color: var(--dashboard-muted); }
        .drop-mini .drop-text {
            font-size: 11.5px; color: var(--dashboard-muted);
            overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
            max-width: 140px;
        }
        .drop-mini .drop-text.has-file { color: var(--dashboard-accent); font-weight: 500; }

        /* ===== Simpan button (row action) ===== */
        .btn-save {
            padding: 6px 12px;
            border-radius: 6px;
            background: var(--dashboard-accent);
            color: #fff;
            font-size: 12px; font-weight: 600;
            border: none; cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
            display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-save:hover:not(:disabled) { opacity: 0.9; }
        .btn-save:active:not(:disabled) { transform: scale(0.97); }
        .btn-save:disabled { opacity: 0.4; cursor: not-allowed; }

        /* ===== Empty state row ===== */
        .empty-row {
            text-align: center;
            padding: 40px 20px;
            color: var(--dashboard-muted);
        }

        /* ===== Search bar ===== */
        .search-row {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px;
            border-bottom: 1px solid var(--dashboard-border);
            background: var(--dashboard-surface);
        }
        .search-input {
            flex: 1;
            padding: 7px 10px 7px 32px;
            border: 1px solid var(--dashboard-border);
            border-radius: 6px;
            background: var(--dashboard-surface-soft);
            color: var(--dashboard-text);
            font-size: 13px;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='M21 21l-4.35-4.35'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 9px 50%;
            background-size: 14px;
        }
        .search-input:focus {
            border-color: var(--dashboard-accent);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--dashboard-accent) 15%, transparent);
        }
        .search-input::placeholder { color: var(--dashboard-muted); }

        .count-pill {
            font-size: 11px; font-weight: 600;
            padding: 3px 8px; border-radius: 999px;
            background: var(--dashboard-surface-soft);
            color: var(--dashboard-muted);
            border: 1px solid var(--dashboard-border);
        }

        /* ===== Status filter chips ===== */
        .filter-chips { display: inline-flex; gap: 4px; }
        .chip {
            padding: 5px 10px; border-radius: 6px;
            font-size: 11.5px; font-weight: 500;
            color: var(--dashboard-muted);
            border: 1px solid transparent;
            background: transparent;
            cursor: pointer;
            transition: all 0.12s;
        }
        .chip:hover { color: var(--dashboard-text); }
        .chip.active {
            color: var(--dashboard-text);
            background: var(--dashboard-surface-soft);
            border-color: var(--dashboard-border);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .col-file { display: none; }
        }
    </style>

    <div class="themes-shell">

        {{-- Toolbar: search (server-side) + filter chips (links) --}}
        <div class="search-row">
            <form method="GET" action="{{ route('admin.themes.index') }}" class="contents">
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama atau slug tema…" class="search-input" autocomplete="off">
                @if(($filter ?? 'all') !== 'all')
                    <input type="hidden" name="filter" value="{{ $filter }}">
                @endif
            </form>
            <div class="filter-chips">
                <a href="{{ route('admin.themes.index', array_filter(['q' => $q ?? null, 'filter' => 'all'])) }}"
                   class="chip {{ ($filter ?? 'all') === 'all' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.themes.index', array_filter(['q' => $q ?? null, 'filter' => 'with'])) }}"
                   class="chip {{ ($filter ?? 'all') === 'with' ? 'active' : '' }}">Ada thumbnail</a>
                <a href="{{ route('admin.themes.index', array_filter(['q' => $q ?? null, 'filter' => 'without'])) }}"
                   class="chip {{ ($filter ?? 'all') === 'without' ? 'active' : '' }}">Belum ada</a>
            </div>
            <span class="count-pill mono">{{ $themes->total() }}</span>
        </div>

        <div style="overflow-x:auto;">
        <table class="themes-table">
            <thead>
                <tr>
                    <th style="width:42px;">#</th>
                    <th style="width:70px;">Thumb</th>
                    <th>Tema</th>
                    <th>Status</th>
                    <th class="col-file">File Thumbnail</th>
                    <th class="col-file">File Musik</th>
                    <th style="min-width:200px;">Upload Thumbnail</th>
                    <th style="min-width:200px;">Upload Musik</th>
                    <th class="center" style="width:90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($themes as $theme)
                    @php
                        $hasThumb = !empty($theme->thumbnail);
                        $hasMusic = !empty($theme->default_music);
                        $thumbUrl = $hasThumb ? asset('storage/themes/thumbnails/' . $theme->thumbnail) : null;
                        $musicUrl = $hasMusic ? asset('storage/themes/music/' . $theme->default_music) : null;
                    @endphp
                    <tr x-data="{ submitting: false }"
                        data-status-filter="{{ $hasThumb ? 'with' : 'without' }}">

                        {{-- # --}}
                        <td class="mono" style="color: var(--dashboard-muted); font-size:11.5px;">{{ str_pad($theme->id, 2, '0', STR_PAD_LEFT) }}</td>

                        {{-- Mini thumb --}}
                        <td>
                            <div class="thumb">
                                @if($hasThumb)
                                    <img src="{{ $thumbUrl }}" alt="{{ $theme->name }}" loading="lazy">
                                @else
                                    <span class="thumb-empty">no<br>img</span>
                                @endif
                            </div>
                        </td>

                        {{-- Name + slug --}}
                        <td>
                            <div class="theme-name">{{ $theme->name }}</div>
                            <div class="theme-slug-row">{{ $theme->slug }}</div>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="status-pill {{ $hasThumb ? 'status-on' : 'status-off' }}">
                                @if($hasThumb) ✓ Thumbnail @else Tanpa @endif
                            </span>
                        </td>

                        {{-- File thumb name --}}
                        <td class="col-file">
                            @if($hasThumb)
                                <a href="{{ $thumbUrl }}" target="_blank" class="file-name has" title="{{ $theme->thumbnail }}">{{ $theme->thumbnail }}</a>
                            @else
                                <span class="file-name file-empty">—</span>
                            @endif
                        </td>

                        {{-- File music name --}}
                        <td class="col-file">
                            @if($hasMusic)
                                <a href="{{ $musicUrl }}" target="_blank" class="file-name has" title="{{ $theme->default_music }}">{{ $theme->default_music }}</a>
                            @else
                                <span class="file-name file-empty">—</span>
                            @endif
                        </td>

                        {{-- Upload thumb --}}
                        <td>
                            <form method="POST" action="{{ route('admin.themes.update', $theme) }}" enctype="multipart/form-data"
                                  x-data="{ name: '', dragging: false, submitting: false }"
                                  @submit="submitting = true">
                                @csrf @method('PUT')
                                <div class="drop-mini" :class="dragging ? 'is-drag' : ''"
                                     @dragover.prevent="dragging = true"
                                     @dragleave="dragging = false"
                                     @drop.prevent="dragging = false">
                                    <input type="file" name="thumbnail" accept="image/*"
                                           @change="name = $event.target.files[0]?.name || ''">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="9" cy="9" r="2"/>
                                        <path d="M21 15l-5-5L5 21"/>
                                    </svg>
                                    <span class="drop-text" :class="name ? 'has-file' : ''"
                                          x-text="name || 'JPG/PNG/WebP · max 8MB'"></span>
                                </div>
                            </form>
                        </td>

                        {{-- Upload music --}}
                        <td>
                            <form method="POST" action="{{ route('admin.themes.update', $theme) }}" enctype="multipart/form-data"
                                  x-data="{ name: '', dragging: false }"
                                  id="music-form-{{ $theme->id }}">
                                @csrf @method('PUT')
                                <div class="drop-mini" :class="dragging ? 'is-drag' : ''"
                                     @dragover.prevent="dragging = true"
                                     @dragleave="dragging = false"
                                     @drop.prevent="dragging = false">
                                    <input type="file" name="default_music" accept="audio/*"
                                           @change="name = $event.target.files[0]?.name || ''">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 18V5l12-2v13"/>
                                        <circle cx="6" cy="18" r="3"/>
                                        <circle cx="18" cy="16" r="3"/>
                                    </svg>
                                    <span class="drop-text" :class="name ? 'has-file' : ''"
                                          x-text="name || 'MP3/WAV/OGG/M4A · max 20MB'"></span>
                                </div>
                            </form>
                        </td>

                        {{-- Action --}}
                        <td class="center">
                            <button type="button" class="btn-save"
                                    @click="
                                        const forms = $root.querySelectorAll('form[action*=\'/admin/themes/{{ $theme->id }}\']');
                                        let combined = new FormData();
                                        let csrf = '';
                                        forms.forEach((f, i) => {
                                            const fd = new FormData(f);
                                            csrf = fd.get('_token');
                                            const thumb = fd.get('thumbnail'); if (thumb && thumb.size) { combined.append('thumbnail', thumb); combined.append('_method','PUT'); combined.append('_token', csrf); }
                                            const music = fd.get('default_music'); if (music && music.size) { combined.append('default_music', music); if (!combined.has('_method')) {combined.append('_method','PUT'); combined.append('_token', csrf);} }
                                        });
                                        if (![...combined.keys()].some(k => ['thumbnail','default_music'].includes(k))) return;
                                        submitting = true;
                                        fetch('{{ route('admin.themes.update', $theme) }}', { method: 'POST', body: combined, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                                          .then(r => r.ok ? location.reload() : alert('Gagal: HTTP ' + r.status));
                                    "
                                    :disabled="submitting">
                                <span x-show="!submitting">Simpan</span>
                                <span x-show="submitting" x-cloak>…</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="empty-row">
                        @if($q || ($filter ?? 'all') !== 'all')
                            Tidak ada tema yang cocok dengan filter "{{ $q }}" @if(($filter ?? 'all') !== 'all')(filter: {{ $filter }})@endif.
                        @else
                            Belum ada tema. Tambah tema di database.
                        @endif
                    </td></tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Pagination --}}
        @if($themes->hasPages())
            <div class="px-4 py-4 border-t border-gray-100 dark:border-gray-700/50">
                {{ $themes->links('vendor.pagination.admin-tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
