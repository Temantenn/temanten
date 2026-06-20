<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em]"
                   style="color: var(--dashboard-muted);">Admin Console</p>
                <h1 class="text-[22px] font-semibold tracking-[-0.4px] mt-1"
                   style="color: var(--dashboard-text);">
                    🎨 Manajemen Harga Tema
                </h1>
                <p class="text-[13px] mt-0.5" style="color: var(--dashboard-muted);">
                    Atur harga normal &amp; promo untuk setiap tema. {{ $totalCount }} tema · {{ $customCount }} harga khusus
                </p>
            </div>

            {{-- Default price (compact) --}}
            <form action="{{ route('admin.themes.defaultPrice') }}" method="POST"
                  class="flex items-center gap-2 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-1.5 shadow-sm">
                @csrf
                <span class="text-[10px] uppercase font-bold tracking-wider px-2"
                      style="color: var(--dashboard-muted);">Default</span>
                <div class="flex items-center rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600">
                    <span class="inline-flex items-center px-2 bg-gray-50 dark:bg-slate-700/50 text-[11px] font-bold"
                          style="color: var(--dashboard-muted);">Rp</span>
                    <input type="number" name="default_price" value="{{ $defaultPrice }}"
                           min="0" max="99999999" step="1000"
                           class="w-28 px-2 py-1.5 text-sm font-bold focus:outline-none bg-white dark:bg-slate-800"
                           style="color: var(--dashboard-text);" required>
                </div>
                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                    Set
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold border"
                     style="color:#047857; background:color-mix(in srgb,#10b981 8%,transparent); border-color:color-mix(in srgb,#10b981 25%,transparent);">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any() || session('error'))
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl text-sm font-semibold border"
                     style="color:#b91c1c; background:color-mix(in srgb,#ef4444 8%,transparent); border-color:color-mix(in srgb,#ef4444 25%,transparent);">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>
                        @if(session('error')){{ session('error') }}@endif
                        @if($errors->any())
                            <ul class="list-disc pl-5 space-y-1 text-sm">
                                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        @endif
                    </span>
                </div>
            @endif

            {{-- ── LIST HARGA PER TEMA ────────────────────────────── --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">

                {{-- Table header (desktop) --}}
                <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3 text-[10px] font-bold tracking-wider uppercase border-b border-gray-100 dark:border-slate-700/50"
                     style="color: var(--dashboard-muted);">
                    <div class="col-span-5">Tema</div>
                    <div class="col-span-3">Harga Normal</div>
                    <div class="col-span-3">Harga Promo</div>
                    <div class="col-span-1 text-right">Aksi</div>
                </div>

                <div class="divide-y divide-gray-50 dark:divide-slate-700/50">
                    @foreach($themes as $theme)
                        @php
                            $hasCustom = !is_null($theme->price);
                            $thumbFile = $theme->thumbnail ?: ($theme->slug . '.webp');
                            $thumbExists = file_exists(public_path('assets/thumbnail/' . $thumbFile));
                        @endphp
                        <div class="px-4 sm:px-6 py-4 hover:bg-gray-50/50 dark:hover:bg-slate-700/20 transition-colors">

                            {{-- Desktop: grid layout --}}
                            <div class="hidden md:grid grid-cols-12 gap-4 items-center">
                                {{-- Tema --}}
                                <div class="col-span-5 flex items-center gap-3 min-w-0">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 shadow-sm border border-gray-100 dark:border-slate-600 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50">
                                        @if($thumbExists)
                                            <img src="{{ asset('assets/thumbnail/' . $thumbFile) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-indigo-500 dark:text-indigo-300">{{ substr($theme->name,0,2) }}</div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="font-bold text-sm leading-tight truncate" style="color: var(--dashboard-text);">{{ $theme->name }}</h3>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($theme->has_promo)
                                                <span class="bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">Promo</span>
                                                <span class="text-[11px] line-through font-semibold" style="color: var(--dashboard-muted);">{{ $theme->formatted_original_price }}</span>
                                                <span class="text-[11px] font-extrabold text-amber-600 dark:text-amber-400">{{ $theme->formatted_price }}</span>
                                            @elseif($hasCustom)
                                                <span class="bg-rose-100 dark:bg-rose-500/20 text-rose-700 dark:text-rose-400 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">Custom</span>
                                                <span class="text-[11px] font-bold" style="color: var(--dashboard-text);">{{ $theme->formatted_price }}</span>
                                            @else
                                                <span class="bg-gray-100 dark:bg-slate-700 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider" style="color: var(--dashboard-muted);">Default</span>
                                                <span class="text-[11px] font-semibold" style="color: var(--dashboard-muted);">{{ $theme->formatted_price }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Harga Normal --}}
                                <div class="col-span-3">
                                    <form action="{{ route('admin.themes.price', $theme->id) }}" method="POST" id="form-{{ $theme->id }}-price">
                                        @csrf
                                        <div class="flex rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 focus-within:border-indigo-500 dark:focus-within:border-indigo-400 transition-all">
                                            <span class="inline-flex items-center px-2 bg-gray-50 dark:bg-slate-700/50 text-[11px] font-bold border-r border-gray-200 dark:border-slate-600" style="color: var(--dashboard-muted);">Rp</span>
                                            <input type="number" name="price" value="{{ $theme->price ?? '' }}" min="0" max="99999999" step="1000"
                                                   placeholder="{{ number_format($defaultPrice, 0, ',', '.') }}"
                                                   class="w-full px-2 py-1.5 text-sm font-semibold focus:outline-none bg-white dark:bg-slate-800" style="color: var(--dashboard-text);">
                                        </div>
                                        <input type="hidden" name="promo_price" value="{{ $theme->promo_price ?? '' }}">
                                    </form>
                                </div>

                                {{-- Harga Promo --}}
                                <div class="col-span-3">
                                    <form action="{{ route('admin.themes.price', $theme->id) }}" method="POST" id="form-{{ $theme->id }}-promo">
                                        @csrf
                                        <input type="hidden" name="price" value="{{ $theme->price ?? '' }}">
                                        <div class="flex rounded-lg overflow-hidden border border-amber-200 dark:border-amber-500/30 focus-within:border-amber-500 dark:focus-within:border-amber-400 transition-all">
                                            <span class="inline-flex items-center px-2 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-bold border-r border-amber-200 dark:border-amber-500/30">Rp</span>
                                            <input type="number" name="promo_price" value="{{ $theme->promo_price ?? '' }}" min="0" max="99999999" step="1000"
                                                   placeholder="Opsional"
                                                   class="w-full px-2 py-1.5 text-sm font-semibold focus:outline-none bg-amber-50/30 dark:bg-slate-800" style="color: var(--dashboard-text);">
                                        </div>
                                    </form>
                                </div>

                                {{-- Aksi --}}
                                <div class="col-span-1 flex flex-col items-stretch gap-1">
                                    <button type="submit" form="form-{{ $theme->id }}-price"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-bold px-2 py-1.5 rounded-md transition shadow-sm">
                                        Simpan
                                    </button>
                                    @if($hasCustom)
                                        <button type="submit" form="form-{{ $theme->id }}-reset"
                                                class="bg-gray-100 dark:bg-slate-700/50 hover:bg-red-50 dark:hover:bg-red-500/10 text-[11px] font-semibold px-2 py-1.5 rounded-md transition border border-gray-200 dark:border-slate-600 hover:border-red-200 dark:hover:border-red-500/30"
                                                style="color: var(--dashboard-muted);"
                                                onclick="return confirm('Reset {{ $theme->name }} ke harga default?')">
                                            Reset
                                        </button>
                                        <form id="form-{{ $theme->id }}-reset" action="{{ route('admin.themes.price', $theme->id) }}" method="POST" class="hidden">
                                            @csrf
                                            <input type="hidden" name="price" value="">
                                            <input type="hidden" name="promo_price" value="">
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Mobile: stacked layout --}}
                            <div class="md:hidden space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0 shadow-sm border border-gray-100 dark:border-slate-600 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50">
                                        @if($thumbExists)
                                            <img src="{{ asset('assets/thumbnail/' . $thumbFile) }}" alt="{{ $theme->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xs font-bold text-indigo-500 dark:text-indigo-300">{{ substr($theme->name,0,2) }}</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-sm leading-tight truncate" style="color: var(--dashboard-text);">{{ $theme->name }}</h3>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            @if($theme->has_promo)
                                                <span class="bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">Promo</span>
                                            @elseif($hasCustom)
                                                <span class="bg-rose-100 dark:bg-rose-500/20 text-rose-700 dark:text-rose-400 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider">Custom</span>
                                            @else
                                                <span class="bg-gray-100 dark:bg-slate-700 text-[10px] font-bold px-1.5 py-0.5 rounded uppercase tracking-wider" style="color: var(--dashboard-muted);">Default</span>
                                            @endif
                                            <span class="text-[11px] font-bold" style="color: var(--dashboard-text);">{{ $theme->formatted_price }}</span>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('admin.themes.price', $theme->id) }}" method="POST" class="space-y-2">
                                    @csrf
                                    <div>
                                        <label class="text-[10px] uppercase font-bold tracking-wider block mb-1" style="color: var(--dashboard-muted);">Harga Normal</label>
                                        <div class="flex rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 focus-within:border-indigo-500 dark:focus-within:border-indigo-400 transition-all">
                                            <span class="inline-flex items-center px-2 bg-gray-50 dark:bg-slate-700/50 text-[11px] font-bold border-r border-gray-200 dark:border-slate-600" style="color: var(--dashboard-muted);">Rp</span>
                                            <input type="number" name="price" value="{{ $theme->price ?? '' }}" min="0" max="99999999" step="1000"
                                                   placeholder="{{ number_format($defaultPrice, 0, ',', '.') }}"
                                                   class="w-full px-2 py-1.5 text-sm font-semibold focus:outline-none bg-white dark:bg-slate-800" style="color: var(--dashboard-text);">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-[10px] uppercase font-bold tracking-wider text-amber-600 dark:text-amber-400 block mb-1">Harga Promo <span class="text-amber-500/60 normal-case font-medium">(opsional)</span></label>
                                        <div class="flex rounded-lg overflow-hidden border border-amber-200 dark:border-amber-500/30 focus-within:border-amber-500 dark:focus-within:border-amber-400 transition-all">
                                            <span class="inline-flex items-center px-2 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-bold border-r border-amber-200 dark:border-amber-500/30">Rp</span>
                                            <input type="number" name="promo_price" value="{{ $theme->promo_price ?? '' }}" min="0" max="99999999" step="1000"
                                                   placeholder="Opsional"
                                                   class="w-full px-2 py-1.5 text-sm font-semibold focus:outline-none bg-amber-50/30 dark:bg-slate-800" style="color: var(--dashboard-text);">
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-2 rounded-lg transition shadow-sm">Simpan</button>
                                        @if($hasCustom)
                                            <button type="submit" form="form-{{ $theme->id }}-reset-m" class="bg-gray-100 dark:bg-slate-700/50 text-xs font-semibold px-3 py-2 rounded-lg transition border border-gray-200 dark:border-slate-600" style="color: var(--dashboard-muted);">Reset</button>
                                            <form id="form-{{ $theme->id }}-reset-m" action="{{ route('admin.themes.price', $theme->id) }}" method="POST" class="hidden">
                                                @csrf
                                                <input type="hidden" name="price" value="">
                                                <input type="hidden" name="promo_price" value="">
                                            </form>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Per-page selector + Pagination --}}
                @if($themes->hasPages() || $perPage < $totalCount)
                    <div class="px-6 py-3 border-t border-gray-100 dark:border-slate-700/50 space-y-3">
                        {{-- Per-page selector --}}
                        <form method="GET" action="{{ url()->current() }}" id="per-page-form"
                              class="flex items-center justify-end gap-2 text-xs"
                              style="color: var(--dashboard-muted);">
                            @foreach(request()->except(['per_page', 'page']) as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                            <label for="per_page_select" class="font-semibold">Tampilkan</label>
                            <div class="relative">
                                <select id="per_page_select" name="per_page" onchange="document.getElementById('per-page-form').submit()"
                                        class="appearance-none pr-7 pl-2.5 py-1.5 text-xs font-semibold rounded-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800 focus:outline-none focus:border-indigo-500 cursor-pointer"
                                        style="color: var(--dashboard-text);">
                                    <option value="8"  {{ $perPage === 8  ? 'selected' : '' }}>8 / halaman</option>
                                    <option value="16" {{ $perPage === 16 ? 'selected' : '' }}>16 / halaman</option>
                                    <option value="24" {{ $perPage === 24 ? 'selected' : '' }}>24 / halaman</option>
                                </select>
                                <svg class="w-3 h-3 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </form>

                        {{-- Pagination links (custom admin-tailwind view) --}}
                        @if($themes->hasPages())
                            {{ $themes->links('vendor.pagination.admin-tailwind') }}
                        @endif
                    </div>
                @endif
            </div>

            {{-- Summary stats (compact) --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 px-4 py-3 text-center">
                    <div class="text-xl font-extrabold text-indigo-600 dark:text-indigo-400 tabular-nums">{{ $totalCount }}</div>
                    <div class="text-[10px] font-bold tracking-wider uppercase mt-0.5" style="color: var(--dashboard-muted);">Total Tema</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 px-4 py-3 text-center">
                    <div class="text-xl font-extrabold text-rose-500 dark:text-rose-400 tabular-nums">{{ $customCount }}</div>
                    <div class="text-[10px] font-bold tracking-wider uppercase mt-0.5" style="color: var(--dashboard-muted);">Harga Custom</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 px-4 py-3 text-center">
                    <div class="text-sm font-extrabold text-emerald-600 dark:text-emerald-400 tabular-nums mt-1">Rp {{ number_format($minPrice, 0, ',', '.') }}</div>
                    <div class="text-[10px] font-bold tracking-wider uppercase mt-1" style="color: var(--dashboard-muted);">Terendah</div>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 px-4 py-3 text-center">
                    <div class="text-sm font-extrabold text-purple-600 dark:text-purple-400 tabular-nums mt-1">Rp {{ number_format($maxPrice, 0, ',', '.') }}</div>
                    <div class="text-[10px] font-bold tracking-wider uppercase mt-1" style="color: var(--dashboard-muted);">Tertinggi</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
