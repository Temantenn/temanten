<x-app-layout>
    @section('title', 'Edit Undangan - Temanten')
    @section('seo_description', 'Edit detail undangan pernikahan Anda: profil mempelai, acara, media, cerita cinta, dan amplop digital. Semua dalam satu halaman.')

    <x-slot name="header">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight flex items-center gap-3">
                <span class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </span>
                {{ __('Edit Undangan') }}
            </h2>
            <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="group inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-2xl text-sm font-semibold shadow-xl shadow-indigo-500/25 transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-1">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Lihat Website
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 min-h-screen pb-40 sm:pb-36" data-testid="client-settings">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Toast kanan-atas (otomatis hilang 4 detik) --}}
            @if(session('success'))
                <x-alert-success :message="session('success')" />
            @endif

            {{-- Banner inline persisten (tidak tergantung Alpine, tidak auto-dismiss) --}}
            @if(session('success'))
                <div id="settings-success-banner" role="status" aria-live="polite"
                    class="relative flex items-start gap-4 bg-gradient-to-r from-emerald-500 to-teal-500 text-white p-5 rounded-2xl shadow-xl shadow-emerald-500/25 animate-fade-in">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-lg leading-tight">Data berhasil disimpan</p>
                        <p class="text-sm text-white/90 mt-1">{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="document.getElementById('settings-success-banner')?.remove()" aria-label="Tutup notifikasi" class="text-white/80 hover:text-white transition-colors flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
            <div class="bg-gradient-to-r from-red-500 to-rose-500 text-white p-5 rounded-2xl shadow-xl shadow-red-500/25">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="font-bold text-lg">Periksa Inputan Anda</p>
                </div>
                <ul class="list-disc pl-16 text-sm space-y-1 text-white/90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @php
                $mapValue = fn ($value) => $value === '#' ? '' : ($value ?? '');
            @endphp

            <form id="settingsForm" action="{{ route('client.updateSettings') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="settings-guide-card" x-data="{ guideOpen: window.matchMedia('(min-width: 768px)').matches }">
                    <div class="flex items-start gap-3 flex-1">
                        <div class="shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-pink-500 text-white flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="settings-eyebrow">Panduan Edit</span>
                            <h3 class="text-base sm:text-lg font-extrabold text-gray-900 dark:text-white mt-0.5">Lengkapi konten undangan bertahap</h3>
                            <div x-show="guideOpen" x-cloak x-transition.duration.200ms>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 leading-relaxed">Mulai dari data mempelai, acara, media, lalu amplop digital. Klik tab untuk loncat ke bagian, lalu simpan sekali di akhir.</p>
                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1.5 text-xs text-gray-600 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>5 bagian</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>2 field wajib</span>
                                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Simpan di akhir</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" @click="guideOpen = !guideOpen" :aria-expanded="guideOpen" aria-label="Toggle panduan"
                        class="shrink-0 inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-white dark:hover:bg-gray-800 transition">
                        <span x-text="guideOpen ? 'Sembunyikan' : 'Tampilkan'"></span>
                        <svg :class="guideOpen ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>

                <!-- Field Legend -->
                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 px-1 text-[11px] text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center gap-1.5"><span class="text-red-500 font-bold text-sm leading-none">*</span> Wajib diisi</span>
                    <span class="inline-flex items-center gap-1.5"><svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Sisanya opsional</span>
                    <span class="inline-flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Simpan di akhir</span>
                </div>

                <!-- Sticky Tab Navigation -->
                <nav id="section-tabs" class="sticky top-16 z-30 -mx-4 sm:mx-0 px-4 sm:px-0">
                    <div class="bg-white/85 dark:bg-gray-900/85 backdrop-blur-xl backdrop-saturate-150 border border-gray-200/70 dark:border-gray-700/70 shadow-lg shadow-black/5 rounded-2xl p-1.5">
                        <ul class="flex items-stretch gap-1 overflow-x-auto scrollbar-hide" role="tablist">
                            <li class="flex-1 min-w-[88px] sm:min-w-[110px]">
                                <a href="#section-profil" data-tab="profil" class="section-tab group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all">
                                    <span class="tab-num shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-extrabold">01</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    <span class="hidden sm:inline">Profil</span>
                                </a>
                            </li>
                            <li class="flex-1 min-w-[88px] sm:min-w-[110px]">
                                <a href="#section-acara" data-tab="acara" class="section-tab group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all">
                                    <span class="tab-num shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-extrabold">02</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="hidden sm:inline">Acara</span>
                                </a>
                            </li>
                            <li class="flex-1 min-w-[88px] sm:min-w-[110px]">
                                <a href="#section-media" data-tab="media" class="section-tab group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all">
                                    <span class="tab-num shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-extrabold">03</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="hidden sm:inline">Media</span>
                                </a>
                            </li>
                            <li class="flex-1 min-w-[88px] sm:min-w-[110px]">
                                <a href="#section-cerita" data-tab="cerita" class="section-tab group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all">
                                    <span class="tab-num shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-extrabold">04</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span class="hidden sm:inline">Cerita</span>
                                </a>
                            </li>
                            <li class="flex-1 min-w-[88px] sm:min-w-[110px]">
                                <a href="#section-amplop" data-tab="amplop" class="section-tab group flex items-center justify-center gap-2 px-3 py-2.5 rounded-xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all">
                                    <span class="tab-num shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-[10px] font-extrabold">05</span>
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    <span class="hidden sm:inline">Amplop</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Section 1: Profil Mempelai -->
                <div id="section-profil" class="settings-card scroll-mt-32">
                    <div class="settings-header">
                        <div class="settings-icon bg-gradient-to-br from-pink-500 to-rose-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="settings-title">Profil Mempelai</h3>
                            <p class="settings-subtitle">Informasi lengkap kedua mempelai</p>
                        </div>
                        <span class="text-[11px] text-gray-500 dark:text-gray-400 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100 dark:bg-gray-800">
                            <span class="text-red-500 font-bold">*</span> Wajib diisi
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                        <!-- Mempelai Pria -->
                        <div class="profile-card profile-card-groom">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="relative group">
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden ring-4 ring-indigo-500/30 shadow-xl">
                                        <img id="prev-groom" src="{{ isset($invitation->content['mempelai']['pria']['foto']) ? asset($invitation->content['mempelai']['pria']['foto']) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                    </div>
                                    <label class="absolute inset-0 bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition-opacity">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <input type="file" name="groom_photo" onchange="previewImage(this, 'prev-groom')" class="hidden">
                                    </label>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-indigo-600 dark:text-indigo-400">Mempelai Pria</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Klik foto untuk mengubah</p>
                                    <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1 leading-snug">
                                        📸 Disarankan upload foto <strong>portrait 4:5</strong> atau <strong>3:4</strong>. Crop manual dari galeri/HP sebelum upload agar hasil tiap tema lebih rapi.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="input-group">
                                    <label class="input-label">Nama Lengkap <span class="text-red-500" aria-label="wajib diisi">*</span></label>
                                    <input type="text" name="groom_name" required value="{{ $invitation->content['mempelai']['pria']['nama'] ?? '' }}" class="input-field" placeholder="Nama Lengkap Pria">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="input-group">
                                        <label class="input-label">Panggilan</label>
                                        <input type="text" name="groom_nickname" value="{{ $invitation->content['mempelai']['pria']['panggilan'] ?? '' }}" class="input-field" placeholder="Romeo">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Instagram</label>
                                        <input type="text" name="groom_instagram" value="{{ $invitation->content['mempelai']['pria']['instagram'] ?? '' }}" class="input-field" placeholder="@username">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Nama Ayah</label>
                                    <input type="text" name="groom_father" value="{{ $invitation->content['mempelai']['pria']['ayah'] ?? '' }}" class="input-field" placeholder="Bpk...">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Nama Ibu</label>
                                    <input type="text" name="groom_mother" value="{{ $invitation->content['mempelai']['pria']['ibu'] ?? '' }}" class="input-field" placeholder="Ibu...">
                                </div>
                            </div>
                        </div>

                        <!-- Mempelai Wanita -->
                        <div class="profile-card profile-card-bride">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="relative group">
                                    <div class="w-20 h-20 rounded-2xl overflow-hidden ring-4 ring-pink-500/30 shadow-xl">
                                        <img id="prev-bride" src="{{ isset($invitation->content['mempelai']['wanita']['foto']) ? asset($invitation->content['mempelai']['wanita']['foto']) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                    </div>
                                    <label class="absolute inset-0 bg-black/50 rounded-2xl opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition-opacity">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <input type="file" name="bride_photo" onchange="previewImage(this, 'prev-bride')" class="hidden">
                                    </label>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-pink-600 dark:text-pink-400">Mempelai Wanita</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Klik foto untuk mengubah</p>
                                    <p class="text-[11px] text-amber-600 dark:text-amber-400 mt-1 leading-snug">
                                        📸 Disarankan upload foto <strong>portrait 4:5</strong> atau <strong>3:4</strong>. Crop manual dari galeri/HP sebelum upload agar hasil tiap tema lebih rapi.
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="input-group">
                                    <label class="input-label">Nama Lengkap <span class="text-red-500" aria-label="wajib diisi">*</span></label>
                                    <input type="text" name="bride_name" required value="{{ $invitation->content['mempelai']['wanita']['nama'] ?? '' }}" class="input-field" placeholder="Nama Lengkap Wanita">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="input-group">
                                        <label class="input-label">Panggilan</label>
                                        <input type="text" name="bride_nickname" value="{{ $invitation->content['mempelai']['wanita']['panggilan'] ?? '' }}" class="input-field" placeholder="Juliet">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Instagram</label>
                                        <input type="text" name="bride_instagram" value="{{ $invitation->content['mempelai']['wanita']['instagram'] ?? '' }}" class="input-field" placeholder="@username">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Nama Ayah</label>
                                    <input type="text" name="bride_father" value="{{ $invitation->content['mempelai']['wanita']['ayah'] ?? '' }}" class="input-field" placeholder="Bpk...">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Nama Ibu</label>
                                    <input type="text" name="bride_mother" value="{{ $invitation->content['mempelai']['wanita']['ibu'] ?? '' }}" class="input-field" placeholder="Ibu...">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 pb-6">
                        <div class="input-group">
                            <label class="input-label">Quote Undangan</label>
                            <textarea name="quote" rows="3" class="input-field" placeholder="Tulis kata-kata mutiara yang bermakna...">{{ $invitation->content['quote'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Rangkaian Acara -->
                <div id="section-acara" class="settings-card scroll-mt-32">
                    <div class="settings-header">
                        <div class="settings-icon bg-gradient-to-br from-amber-500 to-orange-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="settings-title">Rangkaian Acara</h3>
                            <p class="settings-subtitle">Jadwal dan lokasi acara pernikahan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                        <!-- Akad -->
                        <div class="event-card">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-white">Akad Nikah</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="input-group">
                                    <label class="input-label">Judul Acara</label>
                                    <input type="text" name="akad_title" value="{{ $invitation->content['acara']['akad']['judul'] ?? '' }}" class="input-field" placeholder="Akad Nikah">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Waktu</label>
                                    <input type="datetime-local" name="akad_datetime" value="{{ isset($invitation->content['acara']['akad']['waktu']) ? \Carbon\Carbon::parse($invitation->content['acara']['akad']['waktu'])->format('Y-m-d\TH:i') : '' }}" class="input-field">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Lokasi (Nama Tempat / Venue)</label>
                                    <input type="text" name="akad_location" value="{{ $invitation->content['acara']['akad']['tempat'] ?? '' }}" class="input-field" placeholder="Masjid Agung">
                                </div>
                                {{-- Wilayah Akad --}}
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="input-group">
                                        <label class="input-label">Provinsi</label>
                                        <select id="akad_province" class="input-field wilayah-province" data-target="akad" data-saved="{{ $invitation->content['acara']['akad']['wilayah']['province'] ?? '' }}">
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                        <input type="hidden" name="akad_province_name" id="akad_province_name" value="{{ $invitation->content['acara']['akad']['wilayah']['province'] ?? '' }}">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Kab / Kota</label>
                                        <select id="akad_regency" class="input-field" data-saved="{{ $invitation->content['acara']['akad']['wilayah']['regency'] ?? '' }}" disabled>
                                            <option value="">-- Pilih Kab/Kota --</option>
                                        </select>
                                        <input type="hidden" name="akad_regency_name" id="akad_regency_name" value="{{ $invitation->content['acara']['akad']['wilayah']['regency'] ?? '' }}">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Kecamatan</label>
                                        <select id="akad_district" class="input-field" data-saved="{{ $invitation->content['acara']['akad']['wilayah']['district'] ?? '' }}" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                        <input type="hidden" name="akad_district_name" id="akad_district_name" value="{{ $invitation->content['acara']['akad']['wilayah']['district'] ?? '' }}">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Kelurahan / Desa</label>
                                        <select id="akad_village" class="input-field" data-saved="{{ $invitation->content['acara']['akad']['wilayah']['village'] ?? '' }}" disabled>
                                            <option value="">-- Pilih Kelurahan --</option>
                                        </select>
                                        <input type="hidden" name="akad_village_name" id="akad_village_name" value="{{ $invitation->content['acara']['akad']['wilayah']['village'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Alamat Lengkap (Detail Jalan / Gedung)</label>
                                    <textarea name="akad_address" rows="2" class="input-field">{{ $invitation->content['acara']['akad']['alamat'] ?? '' }}</textarea>
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Link Maps</label>
                                    <input type="text" name="akad_map_link" value="{{ old('akad_map_link', $mapValue($invitation->content['acara']['akad']['maps'] ?? null)) }}" class="input-field" placeholder="https://maps.google.com/...">
                                </div>
                            </div>
                        </div>

                        <!-- Resepsi -->
                        <div class="event-card">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-800 dark:text-white">Resepsi</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="input-group">
                                    <label class="input-label">Judul Acara</label>
                                    <input type="text" name="resepsi_title" value="{{ $invitation->content['acara']['resepsi']['judul'] ?? '' }}" class="input-field" placeholder="Resepsi">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Waktu</label>
                                    <input type="datetime-local" name="resepsi_datetime" value="{{ isset($invitation->content['acara']['resepsi']['waktu']) ? \Carbon\Carbon::parse($invitation->content['acara']['resepsi']['waktu'])->format('Y-m-d\TH:i') : '' }}" class="input-field">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Lokasi (Nama Tempat / Venue)</label>
                                    <input type="text" name="resepsi_location" value="{{ $invitation->content['acara']['resepsi']['tempat'] ?? '' }}" class="input-field" placeholder="Hotel...">
                                </div>
                                {{-- Wilayah Resepsi --}}
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="input-group">
                                        <label class="input-label">Provinsi</label>
                                        <select id="resepsi_province" class="input-field wilayah-province" data-target="resepsi" data-saved="{{ $invitation->content['acara']['resepsi']['wilayah']['province'] ?? '' }}">
                                            <option value="">-- Pilih Provinsi --</option>
                                        </select>
                                        <input type="hidden" name="resepsi_province_name" id="resepsi_province_name" value="{{ $invitation->content['acara']['resepsi']['wilayah']['province'] ?? '' }}">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Kab / Kota</label>
                                        <select id="resepsi_regency" class="input-field" data-saved="{{ $invitation->content['acara']['resepsi']['wilayah']['regency'] ?? '' }}" disabled>
                                            <option value="">-- Pilih Kab/Kota --</option>
                                        </select>
                                        <input type="hidden" name="resepsi_regency_name" id="resepsi_regency_name" value="{{ $invitation->content['acara']['resepsi']['wilayah']['regency'] ?? '' }}">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Kecamatan</label>
                                        <select id="resepsi_district" class="input-field" data-saved="{{ $invitation->content['acara']['resepsi']['wilayah']['district'] ?? '' }}" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                        <input type="hidden" name="resepsi_district_name" id="resepsi_district_name" value="{{ $invitation->content['acara']['resepsi']['wilayah']['district'] ?? '' }}">
                                    </div>
                                    <div class="input-group">
                                        <label class="input-label">Kelurahan / Desa</label>
                                        <select id="resepsi_village" class="input-field" data-saved="{{ $invitation->content['acara']['resepsi']['wilayah']['village'] ?? '' }}" disabled>
                                            <option value="">-- Pilih Kelurahan --</option>
                                        </select>
                                        <input type="hidden" name="resepsi_village_name" id="resepsi_village_name" value="{{ $invitation->content['acara']['resepsi']['wilayah']['village'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Alamat Lengkap (Detail Jalan / Gedung)</label>
                                    <textarea name="resepsi_address" rows="2" class="input-field">{{ $invitation->content['acara']['resepsi']['alamat'] ?? '' }}</textarea>
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Link Maps</label>
                                    <input type="text" name="resepsi_map_link" value="{{ old('resepsi_map_link', $mapValue($invitation->content['acara']['resepsi']['maps'] ?? null)) }}" class="input-field" placeholder="https://maps.google.com/...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Media & Galeri -->
                <div id="section-media" class="settings-card scroll-mt-32">
                    <div class="settings-header">
                        <div class="settings-icon bg-gradient-to-br from-violet-500 to-purple-600">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="settings-title">Media & Galeri</h3>
                            <p class="settings-subtitle">Foto, video, dan musik untuk undangan</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="upload-card">
                                <div class="upload-icon">
                                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <h5 class="font-semibold text-gray-800 dark:text-white mb-1">Foto Cover</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Foto utama undangan</p>
                                <input type="file" name="cover_image" class="file-input">
                                @if(isset($invitation->content['media']['cover']))
                                    <span class="inline-flex items-center gap-1 text-xs text-emerald-600 mt-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Cover tersedia</span>
                                @endif
                            </div>
                            <div class="upload-card">
                                <div class="upload-icon">
                                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101M10 14a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                                </div>
                                <h5 class="font-semibold text-gray-800 dark:text-white mb-1">Thumbnail WhatsApp</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Opsional (Rasio 1:1)</p>
                                <input type="file" name="og_image" accept="image/png, image/jpeg, image/jpg" class="file-input">
                                @if(isset($invitation->content['media']['og_image']))
                                    <span class="inline-flex items-center gap-1 text-xs text-emerald-600 mt-2"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Thumbnail khusus aktif</span>
                                @endif
                            </div>
                            <div class="upload-card">
                                <div class="upload-icon">
                                    <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                </div>
                                <h5 class="font-semibold text-gray-800 dark:text-white mb-1">Background Musik</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Format MP3</p>
                                <input type="file" name="music_file" accept=".mp3" class="file-input">
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <label class="input-label">Link Video YouTube</label>
                            <input type="text" name="video_link" value="{{ $invitation->content['media']['video_link'] ?? '' }}" class="input-field" placeholder="https://www.youtube.com/embed/...">
                        </div>

                        <div class="upload-card">
                            <div class="upload-icon">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h5 class="font-semibold text-gray-800 dark:text-white mb-1">Galeri Foto</h5>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Upload banyak foto sekaligus</p>
                            <input type="file" name="gallery_photos[]" multiple class="file-input">
                        </div>
                        
                        @php
                            $gallery = array_values($invitation->content['media']['gallery'] ?? []);
                            $galleryTrash = array_values($invitation->content['media']['gallery_trash'] ?? []);
                        @endphp
                        @if(count($gallery) > 0)
                            <div class="mt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Foto Galeri ({{ count($gallery) }})</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">Klik ikon <svg class="w-3 h-3 inline text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> untuk menandai foto yang akan dihapus saat Simpan</p>
                                </div>
                                <div class="grid grid-cols-3 md:grid-cols-6 gap-3" id="gallery-preview-container">
                                    @foreach($gallery as $index => $photo)
                                        <div class="relative aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all group gallery-item" data-index="{{ $index }}">
                                            <img src="{{ asset($photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Foto galeri {{ $index + 1 }}">
                                            {{-- Overlay penanda 'akan dihapus' (disembunyikan default) --}}
                                            <div class="gallery-delete-overlay absolute inset-0 bg-red-600/70 flex items-center justify-center text-white text-xs font-bold hidden z-10">
                                                <div class="text-center">
                                                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    AKAN DIHAPUS
                                                </div>
                                            </div>
                                            <button type="button" onclick="toggleDeleteGallery(this, {{ $index }})"
                                                class="gallery-delete-btn absolute top-1.5 right-1.5 bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg md:opacity-0 md:group-hover:opacity-100 opacity-100 transition-all backdrop-blur-sm z-20 shadow-lg"
                                                aria-label="Hapus foto galeri"
                                                title="Tandai foto ini untuk dihapus saat Simpan Perubahan">
                                                <svg class="w-4 h-4 gallery-delete-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <svg class="w-4 h-4 gallery-undo-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(count($galleryTrash) > 0)
                            <div class="mt-6 rounded-2xl border border-amber-200 dark:border-amber-700/50 bg-amber-50/60 dark:bg-amber-950/20 p-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                                    <div>
                                        <p class="text-sm font-bold text-amber-700 dark:text-amber-300">Sampah Galeri ({{ count($galleryTrash) }})</p>
                                        <p class="text-xs text-amber-700/80 dark:text-amber-300/80">Foto yang dihapus tidak langsung hilang. Klik pulihkan lalu Simpan Perubahan.</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 md:grid-cols-6 gap-3" id="gallery-trash-container">
                                    @foreach($galleryTrash as $index => $photo)
                                        <div class="relative aspect-square rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all group gallery-trash-item" data-index="{{ $index }}">
                                            <img src="{{ asset($photo) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-300" alt="Foto terhapus {{ $index + 1 }}">
                                            <div class="gallery-restore-overlay absolute inset-0 bg-emerald-600/75 flex items-center justify-center text-white text-xs font-bold hidden z-10">
                                                <div class="text-center">
                                                    <svg class="w-6 h-6 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                    AKAN DIPULIHKAN
                                                </div>
                                            </div>
                                            <button type="button" onclick="toggleRestoreGallery(this, {{ $index }})"
                                                class="gallery-restore-btn absolute top-1.5 right-1.5 bg-emerald-500 hover:bg-emerald-600 text-white p-1.5 rounded-lg md:opacity-0 md:group-hover:opacity-100 opacity-100 transition-all backdrop-blur-sm z-20 shadow-lg"
                                                aria-label="Pulihkan foto galeri"
                                                title="Pulihkan foto ini saat Simpan Perubahan">
                                                <svg class="w-4 h-4 gallery-restore-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                                <svg class="w-4 h-4 gallery-restore-undo-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Section 4: Love Story -->
                <div id="section-cerita" class="settings-card scroll-mt-32">
                    <div class="settings-header">
                        <div class="settings-icon bg-gradient-to-br from-rose-500 to-pink-600">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="settings-title">Love Story</h3>
                            <p class="settings-subtitle">Ceritakan perjalanan cinta kalian</p>
                        </div>
                    </div>

                    @php 
                        $stories = $invitation->content['love_stories'] ?? []; 
                        for($i=count($stories); $i<3; $i++) {
                            $stories[] = ['year' => '', 'title' => '', 'story' => '', 'image' => null];
                        }
                    @endphp

                    <div class="p-6 space-y-4" id="love-stories-container">
                        @foreach ($stories as $index => $story)
                        <div class="story-card" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md story-index-badge">{{ $index + 1 }}</div>
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Bagian <span class="story-index-label">{{ $index + 1 }}</span></span>
                                </div>
                                <button type="button" onclick="removeStory(this)" class="text-red-500 hover:text-red-700 bg-red-50/50 hover:bg-red-100 px-3 py-1.5 rounded-md text-xs font-semibold transition-colors">Hapus</button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                <div class="md:col-span-2">
                                    <label class="input-label">Tahun</label>
                                    <input type="text" name="love_stories[{{ $index }}][year]" value="{{ $story['year'] ?? '' }}" class="input-field text-center" placeholder="2020">
                                </div>
                                <div class="md:col-span-4">
                                    <label class="input-label">Judul</label>
                                    <input type="text" name="love_stories[{{ $index }}][title]" value="{{ $story['title'] ?? '' }}" class="input-field" placeholder="Pertama Bertemu">
                                </div>
                                <div class="md:col-span-6">
                                    <label class="input-label">Cerita</label>
                                    <textarea name="love_stories[{{ $index }}][story]" rows="1" class="input-field" placeholder="Cerita singkat...">{{ $story['story'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="px-6 pb-6 text-center">
                        <button type="button" onclick="addStory()" class="px-5 py-2.5 text-sm font-semibold text-pink-600 bg-pink-50/50 border border-pink-200/50 rounded-lg hover:bg-pink-100 transition-colors inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Cerita Perjalanan
                        </button>
                    </div>
                </div>

                <!-- Section 5: Amplop Digital -->
                <div id="section-amplop" class="settings-card scroll-mt-32">
                    <div class="settings-header">
                        <div class="settings-icon bg-gradient-to-br from-emerald-500 to-teal-600">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="settings-title">Amplop Digital</h3>
                            <p class="settings-subtitle">Informasi transfer dan kirim kado</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="input-group">
                                <label class="input-label">Bank / E-Wallet</label>
                                <input type="text" name="bank_name" value="{{ $invitation->content['amplop']['bank_name'] ?? '' }}" class="input-field" placeholder="BCA">
                            </div>
                            <div class="input-group">
                                <label class="input-label">No Rekening</label>
                                <input type="text" name="bank_number" value="{{ $invitation->content['amplop']['account_number'] ?? '' }}" class="input-field" placeholder="1234567890">
                            </div>
                            <div class="input-group">
                                <label class="input-label">Atas Nama</label>
                                <input type="text" name="bank_holder" value="{{ $invitation->content['amplop']['account_holder'] ?? '' }}" class="input-field" placeholder="Nama Pemilik">
                            </div>
                        </div>

                        <div class="upload-card relative group" style="border-color: rgba(16, 185, 129, 0.5); padding: 1.5rem;">
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden ring-4 ring-emerald-500/30 shadow-xl bg-white flex items-center justify-center flex-shrink-0 relative">
                                    <img id="prev-qris" src="{{ isset($invitation->content['amplop']['qris_image']) ? asset($invitation->content['amplop']['qris_image']) : 'https://via.placeholder.com/150?text=QRIS' }}" class="w-full h-full object-contain p-2">
                                    <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center cursor-pointer transition-opacity">
                                        <svg class="w-6 h-6 text-white mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <input type="file" name="qris_image" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(this, 'prev-qris')" class="hidden">
                                        <span class="text-[10px] text-white font-semibold">Ubah QR</span>
                                    </label>
                                </div>
                                <div class="text-left flex-1">
                                    <h5 class="font-bold text-gray-800 dark:text-white mb-1">Barcode QRIS <span class="text-xs font-normal text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-md ml-2 inline-block">Opsional</span></h5>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Unggah barcode untuk mempermudah tamu dalam memberikan amplop digital.</p>
                                    @if(isset($invitation->content['amplop']['qris_image']))
                                        <p class="text-[10px] font-medium text-emerald-600 mt-2">QRIS aktif &akan ditampilkan di undangan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Wilayah Kado --}}
                        <div class="input-group">
                            <label class="input-label mb-2 block">Wilayah Pengiriman Kado</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="input-group">
                                    <label class="input-label">Provinsi</label>
                                    <select id="kado_province" class="input-field wilayah-province" data-target="kado" data-saved="{{ $invitation->content['amplop']['wilayah']['province'] ?? '' }}">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                    <input type="hidden" name="kado_province_name" id="kado_province_name" value="{{ $invitation->content['amplop']['wilayah']['province'] ?? '' }}">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Kab / Kota</label>
                                    <select id="kado_regency" class="input-field" data-saved="{{ $invitation->content['amplop']['wilayah']['regency'] ?? '' }}" disabled>
                                        <option value="">-- Pilih Kab/Kota --</option>
                                    </select>
                                    <input type="hidden" name="kado_regency_name" id="kado_regency_name" value="{{ $invitation->content['amplop']['wilayah']['regency'] ?? '' }}">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Kecamatan</label>
                                    <select id="kado_district" class="input-field" data-saved="{{ $invitation->content['amplop']['wilayah']['district'] ?? '' }}" disabled>
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                    <input type="hidden" name="kado_district_name" id="kado_district_name" value="{{ $invitation->content['amplop']['wilayah']['district'] ?? '' }}">
                                </div>
                                <div class="input-group">
                                    <label class="input-label">Kelurahan / Desa</label>
                                    <select id="kado_village" class="input-field" data-saved="{{ $invitation->content['amplop']['wilayah']['village'] ?? '' }}" disabled>
                                        <option value="">-- Pilih Kelurahan --</option>
                                    </select>
                                    <input type="hidden" name="kado_village_name" id="kado_village_name" value="{{ $invitation->content['amplop']['wilayah']['village'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="input-group">
                                <label class="input-label">Alamat Kirim Kado (Detail Jalan)</label>
                                <textarea name="gift_address" rows="2" class="input-field" placeholder="Jalan...">{{ $invitation->content['amplop']['alamat_kado'] ?? '' }}</textarea>
                            </div>
                            <div class="input-group">
                                <label class="input-label">Link Maps Alamat Kado</label>
                                <input type="text" name="gift_map_link" value="{{ old('gift_map_link', $mapValue($invitation->content['amplop']['maps_kado'] ?? null)) }}" class="input-field" placeholder="https://maps.google.com/...">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fixed Save Button -->
                <div class="fixed bottom-0 left-0 right-0 bg-white/85 dark:bg-gray-900/85 backdrop-blur-xl border-t border-gray-200/50 dark:border-gray-700/50 p-3 sm:p-4 pb-[max(0.75rem,env(safe-area-inset-bottom))] z-50 shadow-2xl shadow-black/10"
                    x-data="{
                        dirty: false,
                        saving: false,
                        savedAt: {{ $invitation->updated_at?->toIso8601String() ? "'".$invitation->updated_at->toIso8601String()."'" : 'null' }},
                        init() {
                            // Watch all form fields for dirty state
                            this.$el.closest('form').addEventListener('input', () => this.dirty = true);
                            this.$el.closest('form').addEventListener('change', () => this.dirty = true);
                            this.$el.closest('form').addEventListener('submit', () => { this.saving = true; this.dirty = false; });
                        },
                        formatTime(iso) {
                            if (!iso) return '';
                            const d = new Date(iso);
                            const now = new Date();
                            const diff = Math.floor((now - d) / 1000);
                            if (diff < 60) return 'baru saja';
                            if (diff < 3600) return Math.floor(diff/60) + ' menit lalu';
                            if (diff < 86400) return Math.floor(diff/3600) + ' jam lalu';
                            return d.toLocaleDateString('id-ID', {day:'numeric', month:'short', hour:'2-digit', minute:'2-digit'});
                        }
                    }"
                    x-init="setInterval(() => { if (savedAt) $el.querySelector('[data-saved-time]')?.textContent = formatTime(savedAt); }, 30000)">
                    <div class="max-w-5xl mx-auto flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 text-sm min-w-0">
                            <template x-if="saving">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-semibold">
                                    <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path></svg>
                                    <span class="hidden sm:inline">Menyimpan...</span>
                                </span>
                            </template>
                            <template x-if="!saving && dirty">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span class="hidden sm:inline">Belum disimpan</span>
                                </span>
                            </template>
                            <template x-if="!saving && !dirty && savedAt">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="hidden sm:inline">Tersimpan <span data-saved-time x-text="formatTime(savedAt)"></span></span>
                                    <span class="sm:hidden">OK</span>
                                </span>
                            </template>
                            <template x-if="!saving && !dirty && !savedAt">
                                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-semibold">
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>Belum pernah disimpan
                                </span>
                            </template>
                        </div>
                        <button type="submit" :disabled="saving"
                            class="px-5 sm:px-8 py-2.5 sm:py-3 text-white transition-all duration-200 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 disabled:opacity-60 disabled:cursor-wait flex items-center justify-center gap-2 font-bold shadow-xl shadow-indigo-500/20 text-sm sm:text-base">
                            <svg x-show="!saving" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <svg x-show="saving" x-cloak class="w-5 h-5 flex-shrink-0 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z"></path></svg>
                            <span x-text="saving ? 'Menyimpan...' : 'Simpan Semua Perubahan'">Simpan Semua Perubahan</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <style>
        .settings-guide-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1.5rem;
            align-items: center;
            padding: 1.5rem;
            border-radius: 1.5rem;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(236, 72, 153, 0.08)), white;
            border: 1px solid rgba(99, 102, 241, 0.15);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.06);
        }
        .dark .settings-guide-card {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(236, 72, 153, 0.12)), rgb(17 24 39);
            border-color: rgba(99, 102, 241, 0.25);
        }
        .settings-eyebrow {
            display: inline-flex;
            font-size: 0.7rem;
            font-weight: 900;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #4f46e5;
        }
        .section-tab {
            color: #6b7280;
            background: transparent;
            border: 1px solid transparent;
        }
        .section-tab:hover {
            color: #4338ca;
            background: rgba(99, 102, 241, 0.08);
        }
        .section-tab .tab-num {
            background: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            transition: all .2s ease;
        }
        .section-tab:hover .tab-num {
            background: rgba(99, 102, 241, 0.2);
            transform: scale(1.05);
        }
        .section-tab.is-active {
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.35);
        }
        .section-tab.is-active .tab-num {
            background: rgba(255,255,255,.22);
            color: #ffffff;
        }
        .dark .section-tab { color: #9ca3af; }
        .dark .section-tab:hover { color: #c7d2fe; background: rgba(99, 102, 241, 0.15); }
        .dark .section-tab .tab-num { background: rgba(165,180,252,.15); color: #a5b4fc; }
        .dark .section-tab:hover .tab-num { background: rgba(165,180,252,.25); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { scrollbar-width: none; }

        /* Settings Card */
        .settings-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        .dark .settings-card {
            background: rgb(17 24 39);
            border-color: rgba(55, 65, 81, 0.5);
        }

        .settings-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
            background: linear-gradient(to right, rgba(249, 250, 251, 0.5), transparent);
        }
        .dark .settings-header {
            border-color: rgba(55, 65, 81, 0.5);
            background: linear-gradient(to right, rgba(31, 41, 55, 0.5), transparent);
        }

        .settings-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .settings-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }
        .dark .settings-title {
            color: white;
        }

        .settings-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
        }
        .dark .settings-subtitle {
            color: #9ca3af;
        }

        /* Profile Cards */
        .profile-card {
            background: linear-gradient(135deg, rgba(249, 250, 251, 0.8), rgba(243, 244, 246, 0.4));
            border-radius: 1.25rem;
            padding: 1.5rem;
            border: 1px solid rgba(229, 231, 235, 0.8);
        }
        .dark .profile-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.4));
            border-color: rgba(55, 65, 81, 0.8);
        }

        /* Event Cards */
        .event-card {
            background: linear-gradient(135deg, rgba(249, 250, 251, 0.8), rgba(243, 244, 246, 0.4));
            border-radius: 1.25rem;
            padding: 1.5rem;
            border: 1px solid rgba(229, 231, 235, 0.8);
        }
        .dark .event-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.4));
            border-color: rgba(55, 65, 81, 0.8);
        }

        /* Story Cards */
        .story-card {
            background: linear-gradient(135deg, rgba(249, 250, 251, 0.8), rgba(243, 244, 246, 0.4));
            border-radius: 1rem;
            padding: 1.25rem;
            border: 1px solid rgba(229, 231, 235, 0.8);
        }
        .dark .story-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.4));
            border-color: rgba(55, 65, 81, 0.8);
        }

        /* Upload Cards */
        .upload-card {
            background: linear-gradient(135deg, rgba(249, 250, 251, 0.8), rgba(243, 244, 246, 0.4));
            border: 2px dashed rgba(209, 213, 219, 0.8);
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }
        .upload-card:hover {
            border-color: #6366f1;
            background: rgba(99, 102, 241, 0.05);
        }
        .dark .upload-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.4));
            border-color: rgba(75, 85, 99, 0.8);
        }
        .dark .upload-card:hover {
            border-color: #818cf8;
            background: rgba(99, 102, 241, 0.1);
        }

        .upload-icon {
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem;
            background: white;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .dark .upload-icon {
            background: rgb(31 41 55);
        }

        /* Input Styles */
        .input-group {
            margin-bottom: 0;
        }

        .input-label {
            display: block;
            color: #374151; /* text-gray-700 */
        }
        .dark .input-label {
            color: #e5e7eb; /* text-gray-200 */
        }

        .input-field {
            display: block;
            width: 100%;
            padding: 0.72rem 1rem;
            margin-top: 0.5rem;
            color: #374151;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.875rem;
            transition: all 0.2s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #60a5fa; /* border-blue-400 */
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.4); /* ring-blue-300 */
        }
        .dark .input-field {
            background-color: #1f2937; /* bg-gray-800 */
            border-color: #4b5563; /* border-gray-600 */
            color: #d1d5db; /* text-gray-300 */
        }
        .dark .input-field:focus {
            border-color: #93c5fd; /* border-blue-300 */
            box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.4);
        }
        .dark .input-field::placeholder {
            color: #9ca3af;
        }

        .file-input {
            font-size: 0.875rem;
            color: #6b7280;
        }
        .dark .file-input {
            color: #9ca3af;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeInSlide 0.35s ease-out forwards;
        }

        .settings-card {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        .settings-card:nth-child(2) { animation-delay: 0.1s; }
        .settings-card:nth-child(3) { animation-delay: 0.2s; }
        .settings-card:nth-child(4) { animation-delay: 0.3s; }
        .settings-card:nth-child(5) { animation-delay: 0.4s; }

        @media (max-width: 768px) {
            .settings-guide-card { grid-template-columns: 1fr; }
            .settings-guide-steps { justify-content: flex-start; max-width: none; }
            .settings-header { align-items: flex-start; }
        }
    </style>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) { 
                    preview.src = e.target.result; 
                }
                reader.readAsDataURL(file);
            }
        }

        /**
         * Toggle penanda hapus foto gallery.
         * - Klik pertama: tandai foto untuk dihapus (overlay merah + hidden input delete_gallery[] ditambahkan).
         * - Klik kedua: batalkan penandaan (overlay & hidden input dihilangkan).
         * Saat Simpan, server memindahkan foto ke sampah galeri tanpa menghapus file fisik.
         */
        function toggleDeleteGallery(btn, index) {
            const item = btn.closest('.gallery-item');
            if (!item) return;
            const container = document.getElementById('gallery-preview-container');
            if (!container) return;
            const overlay = item.querySelector('.gallery-delete-overlay');
            const delIcon = btn.querySelector('.gallery-delete-icon');
            const undoIcon = btn.querySelector('.gallery-undo-icon');
            const hiddenInputId = 'delete_gallery_input_' + index;
            const existing = document.getElementById(hiddenInputId);

            if (existing) {
                // Batal hapus
                existing.remove();
                if (overlay) overlay.classList.add('hidden');
                if (delIcon) delIcon.classList.remove('hidden');
                if (undoIcon) undoIcon.classList.add('hidden');
                btn.setAttribute('title', 'Tandai foto ini untuk dihapus saat Simpan Perubahan');
                btn.classList.remove('bg-amber-500', 'hover:bg-amber-600');
                btn.classList.add('bg-red-500', 'hover:bg-red-600');
            } else {
                // Tandai untuk dihapus
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_gallery[]';
                input.value = index;
                input.id = hiddenInputId;
                container.appendChild(input);
                if (overlay) overlay.classList.remove('hidden');
                if (delIcon) delIcon.classList.add('hidden');
                if (undoIcon) undoIcon.classList.remove('hidden');
                btn.setAttribute('title', 'Batalkan - Foto tidak jadi dihapus');
                btn.classList.remove('bg-red-500', 'hover:bg-red-600');
                btn.classList.add('bg-amber-500', 'hover:bg-amber-600');
            }
        }

        // Backward compatibility (bila masih ada script lama yang memanggil)
        function deleteGalleryPhoto(btn, index) {
            toggleDeleteGallery(btn, index);
        }

        function toggleRestoreGallery(btn, index) {
            const item = btn.closest('.gallery-trash-item');
            if (!item) return;
            const container = document.getElementById('gallery-trash-container');
            if (!container) return;
            const overlay = item.querySelector('.gallery-restore-overlay');
            const restoreIcon = btn.querySelector('.gallery-restore-icon');
            const undoIcon = btn.querySelector('.gallery-restore-undo-icon');
            const hiddenInputId = 'restore_gallery_input_' + index;
            const existing = document.getElementById(hiddenInputId);

            if (existing) {
                existing.remove();
                if (overlay) overlay.classList.add('hidden');
                if (restoreIcon) restoreIcon.classList.remove('hidden');
                if (undoIcon) undoIcon.classList.add('hidden');
                btn.setAttribute('title', 'Pulihkan foto ini saat Simpan Perubahan');
                btn.classList.remove('bg-amber-500', 'hover:bg-amber-600');
                btn.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
            } else {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'restore_gallery[]';
                input.value = index;
                input.id = hiddenInputId;
                container.appendChild(input);
                if (overlay) overlay.classList.remove('hidden');
                if (restoreIcon) restoreIcon.classList.add('hidden');
                if (undoIcon) undoIcon.classList.remove('hidden');
                btn.setAttribute('title', 'Batalkan - Foto tidak jadi dipulihkan');
                btn.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
                btn.classList.add('bg-amber-500', 'hover:bg-amber-600');
            }
        }

        function addStory() {
            const container = document.getElementById('love-stories-container');
            const items = container.querySelectorAll('.story-card');
            let maxIndex = -1;
            items.forEach(el => {
                const idx = parseInt(el.getAttribute('data-index'));
                if (idx > maxIndex) maxIndex = idx;
            });
            const newIndex = maxIndex + 1;
            
            const html = `
            <div class="story-card" data-index="${newIndex}">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-md story-index-badge">${newIndex + 1}</div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Bagian <span class="story-index-label">${newIndex + 1}</span></span>
                    </div>
                    <button type="button" onclick="removeStory(this)" class="text-red-500 hover:text-red-700 bg-red-50/50 hover:bg-red-100 px-3 py-1.5 rounded-md text-xs font-semibold transition-colors">Hapus</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-2">
                        <label class="input-label">Tahun</label>
                        <input type="text" name="love_stories[${newIndex}][year]" class="input-field text-center" placeholder="2020">
                    </div>
                    <div class="md:col-span-4">
                        <label class="input-label">Judul</label>
                        <input type="text" name="love_stories[${newIndex}][title]" class="input-field" placeholder="Pertama Bertemu">
                    </div>
                    <div class="md:col-span-6">
                        <label class="input-label">Cerita</label>
                        <textarea name="love_stories[${newIndex}][story]" rows="1" class="input-field" placeholder="Cerita singkat..."></textarea>
                    </div>
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            updateStoryIndices();
        }

        function removeStory(btn) {
            if(confirm('Hapus cerita ini?')) {
                const item = btn.closest('.story-card');
                item.remove();
                updateStoryIndices();
            }
        }

        function updateStoryIndices() {
            const items = document.querySelectorAll('.story-card');
            items.forEach((item, idx) => {
                const num = idx + 1;
                item.querySelector('.story-index-badge').textContent = num;
                item.querySelector('.story-index-label').textContent = num;
            });
        }

        // =============================================
        // Wilayah Indonesia — Chained Dropdown
        // =============================================
        const wilayahGroups = ['akad', 'resepsi', 'kado'];

        async function fetchWilayah(url) {
            try {
                const res = await fetch(url);
                return await res.json();
            } catch(e) {
                console.error('Gagal fetch wilayah:', e);
                return [];
            }
        }

        function populateSelect(selectEl, data, nameKey, savedValue) {
            selectEl.innerHTML = '<option value="">-- Pilih --</option>';
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item[nameKey];
                if (item[nameKey] === savedValue) opt.selected = true;
                selectEl.appendChild(opt);
            });
            selectEl.disabled = false;
        }

        async function initProvince(prefix) {
            const provinceEl = document.getElementById(prefix + '_province');
            if (!provinceEl) return;

            const savedProv = provinceEl.dataset.saved || '';
            const savedReg  = document.getElementById(prefix + '_regency')?.dataset.saved || '';
            const savedDist = document.getElementById(prefix + '_district')?.dataset.saved || '';
            const savedVil  = document.getElementById(prefix + '_village')?.dataset.saved || '';

            const provinces = await fetchWilayah('/api/wilayah/provinces');
            populateSelect(provinceEl, provinces, 'name', savedProv);

            // If there's a saved value, cascade load next levels
            const selectedProv = provinces.find(p => p.name === savedProv);
            if (selectedProv) {
                await loadRegency(prefix, selectedProv.id, savedReg, savedDist, savedVil);
            }

            // On change handler
            provinceEl.addEventListener('change', async function() {
                const selOpt = this.options[this.selectedIndex];
                document.getElementById(prefix + '_province_name').value = selOpt.text !== '-- Pilih --' ? selOpt.text : '';
                
                // Reset downstream
                resetSelect(prefix + '_regency');
                resetSelect(prefix + '_district');
                resetSelect(prefix + '_village');
                document.getElementById(prefix + '_regency_name').value = '';
                document.getElementById(prefix + '_district_name').value = '';
                document.getElementById(prefix + '_village_name').value = '';

                if (this.value) {
                    await loadRegency(prefix, this.value, '', '', '');
                }
            });
        }

        async function loadRegency(prefix, provinceId, savedReg, savedDist, savedVil) {
            const regencyEl = document.getElementById(prefix + '_regency');
            if (!regencyEl) return;

            const regencies = await fetchWilayah('/api/wilayah/regencies/' + provinceId);
            populateSelect(regencyEl, regencies, 'name', savedReg);

            const selectedReg = regencies.find(r => r.name === savedReg);
            if (selectedReg) {
                await loadDistrict(prefix, selectedReg.id, savedDist, savedVil);
            }

            regencyEl.addEventListener('change', async function() {
                const selOpt = this.options[this.selectedIndex];
                document.getElementById(prefix + '_regency_name').value = selOpt.text !== '-- Pilih --' ? selOpt.text : '';
                resetSelect(prefix + '_district');
                resetSelect(prefix + '_village');
                document.getElementById(prefix + '_district_name').value = '';
                document.getElementById(prefix + '_village_name').value = '';
                if (this.value) await loadDistrict(prefix, this.value, '', '');
            });
        }

        async function loadDistrict(prefix, regencyId, savedDist, savedVil) {
            const districtEl = document.getElementById(prefix + '_district');
            if (!districtEl) return;

            const districts = await fetchWilayah('/api/wilayah/districts/' + regencyId);
            populateSelect(districtEl, districts, 'name', savedDist);

            const selectedDist = districts.find(d => d.name === savedDist);
            if (selectedDist) {
                await loadVillage(prefix, selectedDist.id, savedVil);
            }

            districtEl.addEventListener('change', async function() {
                const selOpt = this.options[this.selectedIndex];
                document.getElementById(prefix + '_district_name').value = selOpt.text !== '-- Pilih --' ? selOpt.text : '';
                resetSelect(prefix + '_village');
                document.getElementById(prefix + '_village_name').value = '';
                if (this.value) await loadVillage(prefix, this.value, '');
            });
        }

        async function loadVillage(prefix, districtId, savedVil) {
            const villageEl = document.getElementById(prefix + '_village');
            if (!villageEl) return;

            const villages = await fetchWilayah('/api/wilayah/villages/' + districtId);
            populateSelect(villageEl, villages, 'name', savedVil);

            villageEl.addEventListener('change', function() {
                const selOpt = this.options[this.selectedIndex];
                document.getElementById(prefix + '_village_name').value = selOpt.text !== '-- Pilih --' ? selOpt.text : '';
            });
        }

        function resetSelect(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.innerHTML = '<option value="">-- Pilih --</option>';
            el.disabled = true;
        }

        // Initialize all dropdown groups on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            wilayahGroups.forEach(prefix => initProvince(prefix));

            // Auto-scroll ke banner sukses / error supaya notifikasi pasti terlihat
            const notifEl = document.getElementById('settings-success-banner')
                || document.querySelector('[role="status"]')
                || document.querySelector('.bg-gradient-to-r.from-red-500');
            if (notifEl) {
                try {
                    notifEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } catch (e) {
                    window.scrollTo(0, 0);
                }
            }
        });


        // =============================================
        // Client-Side Image Compression (Fix POST Too Large)
        // =============================================
        const settingsFormEl = document.getElementById('settingsForm');
        settingsFormEl && settingsFormEl.addEventListener('submit', async function(e) {
            e.preventDefault(); // Pause submission
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<svg class="w-5 h-5 animate-spin mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengompresi Foto...';

            const fileInputs = this.querySelectorAll('input[type="file"]');
            
            for (let input of fileInputs) {
                if (input.files && input.files.length > 0) {
                    const dataTransfer = new DataTransfer();
                    
                    for (let i = 0; i < input.files.length; i++) {
                        const file = input.files[i];
                        
                        // Only compress images
                        if (!file.type.match(/image.*/)) {
                            dataTransfer.items.add(file);
                            continue;
                        }

                        try {
                            // Max 2500px (HD), convert to WebP at 85% Quality for huge size savings without blur
                            const compressedFile = await compressImage(file, 2500, 2500, 0.85); 
                            dataTransfer.items.add(compressedFile);
                        } catch (err) {
                            console.error('Compression failed for', file.name, err);
                            dataTransfer.items.add(file); // Fallback to original if compression fails
                        }
                    }
                    
                    // Replace original files with compressed files
                    input.files = dataTransfer.files;
                }
            }
            
            submitBtn.innerHTML = '<svg class="w-5 h-5 animate-spin mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
            this.submit(); // Resume submission
        });

        function compressImage(file, maxWidth, maxHeight, quality) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = event => {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = () => {
                        let width = img.width;
                        let height = img.height;

                        if (width > height) {
                            if (width > maxWidth) {
                                height = Math.round((height *= maxWidth / width));
                                width = maxWidth;
                            }
                        } else {
                            if (height > maxHeight) {
                                width = Math.round((width *= maxHeight / height));
                                height = maxHeight;
                            }
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        // Output format (Force WebP for best size/quality ratio, fallback to jpeg)
                        const outType = 'image/webp';
                        
                        canvas.toBlob((blob) => {
                            if (!blob) {
                                reject(new Error('Canvas is empty'));
                                return;
                            }
                            // Keep original filename but change extension to .webp if applicable
                            const newFilename = file.name.replace(/\.[^/.]+$/, "") + ".webp";
                            // Return new File object
                            const newFile = new File([blob], newFilename, {
                                type: outType,
                                lastModified: Date.now()
                            });
                            resolve(newFile);
                        }, outType, quality);
                    };
                    img.onerror = error => reject(error);
                };
                reader.onerror = error => reject(error);
            });
        }

        // Scroll-spy: highlight tab matching currently visible section
        (function(){
            var tabs = document.querySelectorAll('.section-tab');
            if(!tabs.length) return;
            var sections = ['profil','acara','media','cerita','amplop'].map(function(k){
                return { key: k, el: document.getElementById('section-' + k) };
            }).filter(function(s){ return !!s.el; });

            function setActive(key){
                tabs.forEach(function(t){
                    if(t.dataset.tab === key) t.classList.add('is-active');
                    else t.classList.remove('is-active');
                });
            }

            function pickActive(){
                // Active = section whose top is closest to (but past) nav bottom (~140px)
                var navBottom = (document.getElementById('section-tabs').getBoundingClientRect().bottom || 140);
                var threshold = navBottom + 60; // account for ~60px into section content
                var current = sections[0].key; // default first
                for(var i=0;i<sections.length;i++){
                    if(sections[i].el.getBoundingClientRect().top <= threshold) current = sections[i].key;
                }
                setActive(current);
            }

            // Initial active = first section
            setActive('profil');

            // Use scroll listener (more reliable than IO for our case)
            var ticking = false;
            window.addEventListener('scroll', function(){
                if(!ticking){
                    window.requestAnimationFrame(function(){ pickActive(); ticking = false; });
                    ticking = true;
                }
            }, { passive: true });
            window.addEventListener('resize', pickActive);
            // Run once after load to handle restored scroll positions
            setTimeout(pickActive, 100);

            // Smooth scroll on tab click + set active immediately
            tabs.forEach(function(t){
                t.addEventListener('click', function(){
                    setActive(t.dataset.tab);
                });
            });
        })();
    </script>
</x-app-layout>