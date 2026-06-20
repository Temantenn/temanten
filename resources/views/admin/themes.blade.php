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
                    Atur harga normal &amp; promo. {{ $totalCount }} tema · {{ $customCount }} harga khusus
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

    <div class="py-6" x-data="{
            openId: null,
            themeName: '',
            themeId: 0,
            price: '',
            promo: '',
            defaultPrice: {{ (int) $defaultPrice }},
            hasCustom: false,
            open(id, name, price, promo) {
                this.openId = id;
                this.themeName = name;
                this.price = price;
                this.promo = promo;
                this.hasCustom = price !== '' && price !== null;
                $nextTick(() => {
                    const form = document.getElementById('edit-modal-form');
                    if (form) form.action = '/admin/themes/' + id + '/price';
                });
            }
         }"
         @keydown.escape.window="openId = null">

        <style>[x-cloak]{display:none!important}</style>

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

            {{-- ── PINTEREST-STYLE MASONRY GRID ─────────────────────── --}}
            <div class="columns-2 sm:columns-3 lg:columns-4 xl:columns-5 gap-4">
                @foreach($themes as $theme)
                    @php
                        $hasCustom = !is_null($theme->price);
                        $thumbFile = $theme->thumbnail ?: ($theme->slug . '.webp');
                        $thumbExists = file_exists(public_path('assets/thumbnail/' . $thumbFile));
                    @endphp
                    <div class="break-inside-avoid mb-4 group">
                        <div class="relative rounded-2xl overflow-hidden bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700/50 shadow-sm hover:shadow-xl transition-all duration-300"
                             style="color: var(--dashboard-text);">

                            {{-- Thumbnail (varied aspect ratios for Pinterest feel) --}}
                            @php
                                $ratios = ['aspect-[3/4]', 'aspect-[4/5]', 'aspect-[1/1]', 'aspect-[2/3]', 'aspect-[5/7]'];
                                $aspectClass = $ratios[$theme->id % count($ratios)];
                            @endphp
                            <div class="relative overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 {{ $aspectClass }}">
                                @if($thumbExists)
                                    <img src="{{ asset('assets/thumbnail/' . $thumbFile) }}"
                                         alt="{{ $theme->name }}"
                                         loading="lazy"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-500 tracking-tighter">
                                            {{ substr($theme->name, 0, 2) }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Badges (top-left) --}}
                                <div class="absolute top-2 left-2 flex flex-col gap-1 items-start">
                                    @if($theme->has_promo)
                                        <span class="bg-amber-500/95 backdrop-blur-sm text-white text-[10px] font-extrabold px-2 py-1 rounded-md uppercase tracking-wider shadow-lg">
                                            ⚡ Promo
                                        </span>
                                    @elseif($hasCustom)
                                        <span class="bg-rose-500/95 backdrop-blur-sm text-white text-[10px] font-extrabold px-2 py-1 rounded-md uppercase tracking-wider shadow-lg">
                                            Custom
                                        </span>
                                    @else
                                        <span class="bg-slate-900/60 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wider">
                                            Default
                                        </span>
                                    @endif
                                </div>

                                {{-- Edit button (top-right) --}}
                                <button type="button"
                                        @click="open({{ $theme->id }}, @js($theme->name), @js((string)($theme->price ?? '')), @js((string)($theme->promo_price ?? '')))"
                                        class="absolute top-2 right-2 w-9 h-9 rounded-full bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-900 text-indigo-600 dark:text-indigo-400 shadow-lg flex items-center justify-center transition opacity-0 group-hover:opacity-100 focus:opacity-100"
                                        title="Edit harga">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Footer info --}}
                            <div class="p-3">
                                <h3 class="font-bold text-sm leading-tight truncate">
                                    {{ $theme->name }}
                                </h3>
                                <div class="flex items-baseline gap-1.5 mt-1">
                                    @if($theme->has_promo)
                                        <span class="text-[10px] line-through font-semibold"
                                              style="color: var(--dashboard-muted);">
                                            {{ $theme->formatted_original_price }}
                                        </span>
                                        <span class="text-sm font-extrabold text-amber-600 dark:text-amber-400">
                                            {{ $theme->formatted_price }}
                                        </span>
                                    @else
                                        <span class="text-sm font-extrabold">
                                            {{ $theme->formatted_price }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($themes->hasPages())
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700/50 px-4 py-3">
                    {{ $themes->links('vendor.pagination.admin-tailwind') }}
                </div>
            @endif

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

        {{-- ── EDIT MODAL ─────────────────────────────────────────── --}}
        <div x-show="openId !== null"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="openId = null"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             style="display: none;">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
                 @click.stop>
                <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold" style="color: var(--dashboard-text);">Edit Harga</h2>
                        <p class="text-xs mt-0.5" style="color: var(--dashboard-muted);" x-text="themeName"></p>
                    </div>
                    <button @click="openId = null" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition" style="color: var(--dashboard-muted);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="edit-modal-form" method="POST" action="" class="px-6 py-5 space-y-4">
                    @csrf

                    {{-- Normal price --}}
                    <div>
                        <label class="block text-[11px] uppercase font-bold tracking-wider mb-1.5"
                               style="color: var(--dashboard-muted);">Harga Normal</label>
                        <div class="flex rounded-xl overflow-hidden border-2 border-gray-200 dark:border-slate-600 focus-within:border-indigo-500 dark:focus-within:border-indigo-400 transition-all">
                            <span class="inline-flex items-center px-3 bg-gray-50 dark:bg-slate-700/50 text-sm font-bold border-r border-gray-200 dark:border-slate-600"
                                  style="color: var(--dashboard-muted);">Rp</span>
                            <input type="number" name="price" x-model="price"
                                   min="0" max="99999999" step="1000"
                                   :placeholder="defaultPrice.toLocaleString('id-ID')"
                                   class="flex-1 px-3 py-2.5 text-base font-bold focus:outline-none bg-white dark:bg-slate-800"
                                   style="color: var(--dashboard-text);">
                        </div>
                        <p class="text-[10px] mt-1" style="color: var(--dashboard-muted);">
                            Kosongkan untuk kembali ke harga default
                        </p>
                    </div>

                    {{-- Promo price --}}
                    <div>
                        <label class="block text-[11px] uppercase font-bold tracking-wider mb-1.5 text-amber-600 dark:text-amber-400">
                            Harga Promo <span class="text-amber-500/60 normal-case font-medium">(opsional)</span>
                        </label>
                        <div class="flex rounded-xl overflow-hidden border-2 border-amber-200 dark:border-amber-500/30 focus-within:border-amber-500 dark:focus-within:border-amber-400 transition-all">
                            <span class="inline-flex items-center px-3 bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold border-r border-amber-200 dark:border-amber-500/30">Rp</span>
                            <input type="number" name="promo_price" x-model="promo"
                                   min="0" max="99999999" step="1000"
                                   placeholder="Tanpa promo"
                                   class="flex-1 px-3 py-2.5 text-base font-bold focus:outline-none bg-amber-50/30 dark:bg-slate-800"
                                   style="color: var(--dashboard-text);">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <button type="submit"
                                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                            Simpan
                        </button>
                        <button type="button"
                                @click="price = ''; promo = ''"
                                class="px-3 py-2.5 rounded-xl border border-gray-200 dark:border-slate-600 text-xs font-bold hover:bg-gray-50 dark:hover:bg-slate-700 transition"
                                style="color: var(--dashboard-muted);">
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
