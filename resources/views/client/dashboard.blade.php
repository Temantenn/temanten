<x-app-layout>
    @section('title', 'Dashboard Klien - Temanten')
    @section('seo_description', 'Dashboard klien Temanten — kelola tamu, RSVP, QR check-in, ucapan, dan analytics undangan pernikahan Anda.')

    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-xs font-bold uppercase tracking-[0.24em]" style="color: var(--dashboard-accent);">Temanten Control Center</p>
            <h2 class="text-2xl font-extrabold leading-tight" style="color: var(--dashboard-text);">
                {{ __('Dashboard Undangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="client-wv-dashboard py-8 min-h-screen" data-testid="client-dashboard">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ALERTS --}}
            @if(session('success'))
                <x-alert-success :message="session('success')" />
            @endif
            @if($errors->any())
                <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 px-5 py-4 rounded-xl shadow" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="list-disc pl-5 mt-1 space-y-1 text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            {{-- ═══ HERO GREETING + URL + CTAs ═══ --}}
            <div class="client-hero-card bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="client-hero-inner bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                        <div class="space-y-3 min-w-0 max-w-full flex-1">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shrink-0">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-2xl font-extrabold text-white break-words">Halo, {{ Auth::user()->name }}! 👋</h3>
                                    <p class="text-white/80 text-sm break-words">Selamat datang kembali di dashboard Anda</p>
                                </div>
                            </div>
                            @if(isset($invitation))
                                <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-2 rounded-xl w-full sm:max-w-fit min-w-0">
                                    <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101"/></svg>
                                    <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" class="text-white font-semibold hover:underline text-sm truncate flex-1 min-w-0 sm:max-w-xs">{{ url('undangan/' . $invitation->slug) }}</a>
                                    <button onclick="copyToClipboard('{{ url('undangan/' . $invitation->slug) }}')" class="text-white/80 hover:text-white transition ml-1" title="Salin Link">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 bg-yellow-500/20 px-3 py-2 rounded-xl">
                                    <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span class="text-sm text-white font-semibold">Belum memiliki undangan aktif</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if(isset($invitation))
                                <a href="{{ route('invitation.show', $invitation->slug) }}" target="_blank" data-testid="client-invitation-link" class="group px-5 py-3 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white font-bold rounded-xl hover:bg-white/30 transition flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Undangan
                                </a>
                                <a href="{{ route('client.settings') }}" data-testid="client-settings-link" class="group px-5 py-3 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-50 transition shadow flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit Undangan
                                </a>
                            @else
                                <a href="{{ route('order.create') }}" class="px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl hover:bg-gray-50 transition shadow flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Buat Undangan Baru
                                </a>
                            @endif
                        </div>
                    </div>
            </div>
        </div>

        {{-- ═══ 2-COL: COUNTDOWN + RSVP OVERVIEW ═══ --}}
        @if(isset($invitation) && $invitation->event_date)
            @php
                $eventDate = \Carbon\Carbon::parse($invitation->event_date);
                $daysLeft = now()->startOfDay()->diffInDays($eventDate->startOfDay(), false);
                $tamuCol = collect($guests ?? []);
                $total = $tamuCol->count();
                $hadir = $tamuCol->where('rsvp_status','hadir')->count();
                $tidakHadir = $tamuCol->whereIn('rsvp_status',['tidak_hadir','ragu'])->count();
                $pending = $tamuCol->whereIn('rsvp_status',['pending',null])->count();
                $checkedIn = $tamuCol->whereNotNull('checked_in_at')->count();
                $konfirmasiPct = $total > 0 ? round($hadir/$total*100) : 0;
                $checkinPct = $total > 0 ? round($checkedIn/$total*100) : 0;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Countdown --}}
                <div class="client-panel bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">⏳</span>
                        <span class="text-xs font-bold uppercase tracking-wider" style="color: var(--dashboard-muted);">
                            @if($daysLeft > 0) Hitung Mundur
                            @elseif($daysLeft == 0) Hari H
                            @else Acara Selesai
                            @endif
                        </span>
                        <span class="ml-auto inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $invitation->status === 'active' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $invitation->status === 'active' ? 'bg-green-500' : 'bg-yellow-500 animate-pulse' }}"></span>
                            {{ $invitation->status === 'active' ? 'Aktif' : ucfirst($invitation->status) }}
                        </span>
                    </div>
                    @if($daysLeft > 0)
                        <div class="flex items-baseline gap-2"><span class="text-5xl font-black leading-none" style="color: var(--dashboard-accent);">{{ $daysLeft }}</span><span class="text-gray-500 font-medium">hari lagi</span></div>
                        <div class="text-sm text-gray-500 mt-2">Menuju <strong class="text-gray-900">{{ $eventDate->translatedFormat('d F Y') }}</strong></div>
                    @elseif($daysLeft == 0)
                        <div class="text-3xl font-black" style="color: var(--dashboard-accent);">🎉 Hari H!</div>
                        <div class="text-sm text-gray-500 mt-1">Selamat atas hari istimewa Anda!</div>
                    @else
                        <div class="text-3xl font-black" style="color: var(--dashboard-accent);">{{ abs($daysLeft) }} hari lalu</div>
                        <div class="text-sm text-gray-500 mt-1">Semoga momennya indah!</div>
                    @endif
                </div>

                {{-- RSVP Overview --}}
                <div class="client-panel bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">👥</span>
                        <span class="text-xs font-bold uppercase tracking-wider" style="color: var(--dashboard-muted);">RSVP Overview</span>
                        <span class="ml-auto text-xs font-semibold text-gray-500">{{ $total }} tamu terdaftar</span>
                    </div>
                    <div class="flex items-baseline gap-2 mb-2">
                        <span class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $hadir }} <span class="text-base font-normal text-gray-400">/ {{ $total }} terkonfirmasi</span></span>
                        <span class="ml-auto text-sm font-bold" style="color: var(--dashboard-accent);">{{ $konfirmasiPct }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2 overflow-hidden mb-3">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-700" style="width: {{ $konfirmasiPct }}%"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-lg p-2">
                            <div class="text-emerald-700 dark:text-emerald-400 font-bold text-lg">{{ $hadir }}</div>
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">RSVP Hadir</div>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2">
                            <div class="text-amber-700 dark:text-amber-400 font-bold text-lg">{{ $pending }}</div>
                            <div class="text-xs text-amber-600 dark:text-amber-400 font-semibold">Pending</div>
                        </div>
                        <div class="bg-rose-50 dark:bg-rose-900/20 rounded-lg p-2">
                            <div class="text-rose-700 dark:text-rose-400 font-bold text-lg">{{ $tidakHadir }}</div>
                            <div class="text-xs text-rose-600 dark:text-rose-400 font-semibold">Tidak Hadir</div>
                        </div>
                    </div>
                    {{-- Check-in progress (separate, scanner-based) --}}
                    <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 flex items-center gap-1.5">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                QR Check-in
                            </span>
                            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $checkedIn }} / {{ $total }} ({{ $checkinPct }}%)</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full transition-all duration-700" style="width: {{ $checkinPct }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ═══ GUEST MANAGEMENT HERO ═══ --}}
        @if(isset($invitation))
        @php
            // re-compute kalau tidak ada event_date di atas
            $tamuCol = collect($guests ?? []);
            $total = $tamuCol->count();
            $hadir = $tamuCol->where('rsvp_status','hadir')->count();
            $tidakHadir = $tamuCol->whereIn('rsvp_status',['tidak_hadir','ragu'])->count();
            $pending = $tamuCol->whereIn('rsvp_status',['pending',null])->count();
        @endphp
        <div class="client-table-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden" x-data="{ modalAdd: false, modalImport: false }">
            {{-- Header: Title + Action Buttons --}}
            <div class="p-5 border-b dark:border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-purple-500 to-pink-600 text-white rounded-xl shadow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">Daftar Tamu</h3>
                        <p class="text-xs text-gray-500" id="guestCountDisplay">{{ count($guests ?? []) }} tamu</p>
                    </div>
                </div>
                <div class="flex flex-wrap sm:flex-nowrap gap-2 w-full sm:w-auto">
                    <button type="button" @click="modalAdd = true" class="flex-1 sm:flex-initial px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-1.5 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Manual
                    </button>
                    <button type="button" @click="modalImport = true" class="flex-1 sm:flex-initial px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold flex items-center justify-center gap-1.5 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        Import Excel
                    </button>
                </div>
            </div>

            {{-- Tabs + Search --}}
            <div class="px-5 pt-4 flex flex-col lg:flex-row lg:items-center justify-between gap-3 border-b border-gray-100 dark:border-gray-700">
                <div class="flex gap-1 overflow-x-auto flex-nowrap scrollbar-hide min-w-0" id="rsvpTabs">
                    <button data-rsvp-tab="" class="rsvp-tab shrink-0 px-4 py-2 text-sm font-bold text-indigo-600 border-b-2 border-indigo-600 whitespace-nowrap">Semua ({{ $total }})</button>
                    <button data-rsvp-tab="hadir" class="rsvp-tab shrink-0 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">Hadir ({{ $hadir }})</button>
                    <button data-rsvp-tab="pending" class="rsvp-tab shrink-0 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">Pending ({{ $pending }})</button>
                    <button data-rsvp-tab="tidak_hadir" class="rsvp-tab shrink-0 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 border-b-2 border-transparent whitespace-nowrap">Tidak Hadir ({{ $tidakHadir }})</button>
                </div>
                <div class="relative w-full lg:w-56 pb-3 lg:pb-0">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="guestSearch" onkeyup="filterGuests()" placeholder="Cari nama..." class="pl-9 pr-3 py-2 w-full border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl text-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition">
                </div>
            </div>

            {{-- Guest List --}}
            @if(count($guests ?? []) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="guestTable">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tamu</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">WhatsApp</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">RSVP</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Check-in</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700" id="guestTableBody">
                        @foreach($guests as $guest)
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition guest-row"
                            data-name="{{ strtolower($guest->name) }}"
                            data-rsvp="{{ $guest->rsvp_status ?? 'pending' }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex-shrink-0 flex items-center justify-center">
                                        <span class="text-indigo-700 dark:text-indigo-300 font-bold text-xs">{{ substr($guest->name,0,1) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 dark:text-white text-sm leading-tight truncate">{{ $guest->name }}</p>
                                        <span class="inline-flex items-center text-[10px] px-1.5 py-0.5 rounded-full font-medium
                                            {{ $guest->category === 'VIP' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                            {{ $guest->category == 'VIP' ? '⭐ ' : '' }}{{ $guest->category ?? 'Umum' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                @if($guest->whatsapp)
                                    <a href="https://wa.me/62{{ ltrim($guest->whatsapp,'0') }}" target="_blank" class="text-xs text-green-600 hover:text-green-800 font-medium flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z"/></svg>
                                        {{ $guest->whatsapp }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($guest->rsvp_status == 'hadir')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Hadir
                                    </span>
                                @elseif(in_array($guest->rsvp_status, ['tidak_hadir','ragu']))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> {{ $guest->rsvp_status == 'tidak_hadir' ? 'Tidak Hadir' : 'Ragu' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($guest->checked_in_at)
                                    <div class="inline-flex flex-col">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                            Check-in
                                        </span>
                                        <span class="text-[10px] text-gray-500 mt-0.5">{{ $guest->checked_in_at->format('H:i') }} WIB · {{ $guest->checked_in_at->translatedFormat('d M') }}</span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    @php
                                        $pPria = $invitation->content['mempelai']['pria']['panggilan'] ?? 'Mempelai Pria';
                                        $pWanita = $invitation->content['mempelai']['wanita']['panggilan'] ?? 'Mempelai Wanita';
                                        $pesanWa = "Assalamu'alaikum Warahmatullahi Wabarakatuh / Selamat Sejahtera,\n\n"
                                                 . "Kepada Yth. *{$guest->name}*,\n\n"
                                                 . "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada acara pernikahan kami:\n\n"
                                                 . "👰🤵 *{$pPria} & {$pWanita}*\n\n"
                                                 . "Informasi lengkap mengenai jadwal, lokasi, dan konfirmasi kehadiran (RSVP) dapat dilihat melalui tautan undangan digital berikut ini:\n\n"
                                                 . route('invitation.show', ['slug'=>$invitation->slug,'to'=>$guest->slug]) . "\n\n"
                                                 . "Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir di hari istimewa kami.\n\n"
                                                 . "Terima kasih,\n"
                                                 . "Wassalamu'alaikum Warahmatullahi Wabarakatuh.";
                                        $waText = urlencode($pesanWa);
                                        $rawPhone = preg_replace('/[^0-9]/', '', (string)($guest->whatsapp ?? ''));
                                        if (str_starts_with($rawPhone, '0')) { $rawPhone = substr($rawPhone, 1); }
                                        if (!str_starts_with($rawPhone, '62') && strlen($rawPhone) >= 8) { $rawPhone = '62' . $rawPhone; }
                                        $waUrl = $rawPhone ? "https://wa.me/{$rawPhone}?text={$waText}" : "https://wa.me/?text={$waText}";
                                    @endphp
                                    <button onclick="copyToClipboard('{{ route('invitation.show', ['slug'=>$invitation->slug,'to'=>$guest->slug]) }}')" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition" title="Salin Link">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3"/></svg>
                                    </button>
                                    <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition" title="Kirim WA ke {{ $guest->name }}">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z"/></svg>
                                    </a>
                                    <a href="{{ route('invitation.show', ['slug'=>$invitation->slug,'to'=>$guest->slug]) }}" target="_blank" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Lihat Undangan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <form action="{{ route('client.deleteGuest', $guest->id) }}" method="POST" onsubmit="return confirm('Hapus tamu \"{{ addslashes($guest->name) }}\"?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="noGuestResult" class="hidden py-10 text-center text-gray-400 text-sm">Tidak ada tamu yang cocok.</div>
            </div>
            @else
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-indigo-100 dark:from-gray-700 dark:to-indigo-900 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-1">Belum Ada Data Tamu</h4>
                <p class="text-gray-400 text-sm mb-5">Tambahkan tamu via input manual atau upload Excel</p>
                <div class="flex gap-3 justify-center flex-wrap">
                    <button @click="modalAdd = true" class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl font-bold text-sm shadow transition">✏️ Input Manual</button>
                    <button @click="modalImport = true" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-bold text-sm shadow transition">📊 Upload Excel</button>
                </div>
            </div>
            @endif

            {{-- ═══ MODAL: TAMBAH MANUAL ═══ --}}
            <div x-show="modalAdd" x-cloak @keydown.escape.window="modalAdd = false" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display:none;">
                <div @click.outside="modalAdd = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" style="background: var(--dashboard-surface);">
                    <div class="p-6 border-b dark:border-gray-700 flex items-center justify-between">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Tambah Tamu Manual</h3>
                        <button @click="modalAdd = false" class="text-gray-400 hover:text-gray-700 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <form action="{{ route('client.storeGuest') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Tamu <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-indigo-400 focus:ring-indigo-300 focus:ring-opacity-40 dark:focus:border-indigo-300 focus:outline-none focus:ring transition-colors" placeholder="Budi Santoso">
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">No. WhatsApp</label>
                            <div class="flex mt-1">
                                <span class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-50 border border-r-0 border-gray-200 rounded-l-md dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600">+62</span>
                                <input type="text" name="whatsapp" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-200 rounded-r-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-indigo-400 focus:ring-indigo-300 focus:ring-opacity-40 dark:focus:border-indigo-300 focus:outline-none focus:ring transition-colors" placeholder="8123456789">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Kategori</label>
                                <select name="category" class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-indigo-400 focus:ring-indigo-300 focus:ring-opacity-40 dark:focus:border-indigo-300 focus:outline-none focus:ring transition-colors">
                                    <option>Umum</option><option>Keluarga</option><option>Teman</option><option>VIP</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Provinsi</label>
                                <select id="tamu_province" class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-indigo-400 focus:ring-indigo-300 focus:ring-opacity-40 dark:focus:border-indigo-300 focus:outline-none focus:ring transition-colors">
                                    <option value="">-- Provinsi --</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Kab / Kota</label>
                            <select id="tamu_regency" class="block w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-indigo-400 focus:ring-indigo-300 focus:ring-opacity-40 dark:focus:border-indigo-300 focus:outline-none focus:ring transition-colors" disabled>
                                <option value="">-- Pilih Provinsi dulu --</option>
                            </select>
                            <input type="hidden" name="address" id="tamu_address_val">
                        </div>
                        <div class="pt-2 flex gap-2">
                            <button type="button" @click="modalAdd = false" class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">Batal</button>
                            <button type="submit" class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Simpan Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ═══ MODAL: IMPORT EXCEL ═══ --}}
            <div x-show="modalImport" x-cloak @keydown.escape.window="modalImport = false" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" style="display:none;">
                <div @click.outside="modalImport = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" style="background: var(--dashboard-surface);">
                    <div class="p-6 border-b dark:border-gray-700 flex items-center justify-between">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Import Data Tamu</h3>
                        <button @click="modalImport = false" class="text-gray-400 hover:text-gray-700 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <form action="{{ route('client.importGuests') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-3">
                        @csrf
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer" onclick="document.getElementById('fileCsv').click()">
                            <input type="file" name="file" id="fileCsv" class="hidden" accept=".csv,.txt,.xlsx,.xls" onchange="updateFileName(this)">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <p class="text-sm text-gray-500"><span class="font-semibold text-indigo-600">Klik untuk upload</span></p>
                            <p class="text-xs text-gray-400 mt-1">.xlsx, .xls, .csv (Max 2MB)</p>
                        </div>
                        <div id="fileNameDisplay" class="hidden p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <p class="text-xs text-green-700 dark:text-green-300 font-medium truncate" id="fileNameText"></p>
                        </div>
                        <button type="submit" class="w-full px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-emerald-600 hover:bg-emerald-700 rounded-md focus:outline-none focus:bg-emerald-700 flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Import Data Tamu
                        </button>
                        <div class="mt-2 pt-3 border-t dark:border-gray-700 flex flex-col gap-2">
                            <a href="{{ route('client.downloadTemplate') }}" class="flex items-center justify-center gap-2 text-sm text-indigo-600 dark:text-indigo-400 font-semibold hover:text-indigo-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download Template Excel
                            </a>
                            @if(count($guests ?? []) > 0)
                            <a href="{{ route('client.exportGuests', $invitation->id) }}" class="flex items-center justify-center gap-2 text-sm text-green-600 dark:text-green-400 font-semibold hover:text-green-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4 8l-4-4m0 0l4-4m-4 4h12"/></svg>
                                Export Daftar Hadir (CSV)
                            </a>
                            <a href="{{ route('client.printQrCards') }}" target="_blank" class="flex items-center justify-center gap-2 text-sm text-indigo-600 dark:text-indigo-400 font-semibold hover:text-indigo-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                Cetak QR Check-in Tamu
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        </div>
    </div>

    <style>
        .client-wv-dashboard {
            background:
                linear-gradient(var(--dashboard-grid) 1px, transparent 1px),
                linear-gradient(90deg, var(--dashboard-grid) 1px, transparent 1px),
                radial-gradient(circle at 18% 8%, color-mix(in srgb, var(--dashboard-accent) 13%, transparent), transparent 24rem),
                radial-gradient(circle at 82% 18%, color-mix(in srgb, var(--dashboard-live) 8%, transparent), transparent 22rem),
                var(--dashboard-bg);
            background-size: 48px 48px, 48px 48px, auto, auto, auto;
            color: var(--dashboard-text);
        }
        .client-wv-dashboard .bg-white,
        .client-wv-dashboard .dark\:bg-gray-800,
        .client-wv-dashboard .dark\:bg-gray-700,
        .client-wv-dashboard .dark\:bg-gray-900 {
            background: var(--dashboard-surface) !important;
        }
        .client-wv-dashboard .rounded-2xl,
        .client-wv-dashboard .sm\:rounded-3xl {
            border-radius: 16px !important;
        }
        .client-wv-dashboard .shadow,
        .client-wv-dashboard .shadow-lg,
        .client-wv-dashboard .shadow-xl {
            box-shadow: 0 20px 44px rgba(0, 0, 0, 0.28) !important;
        }
        .client-wv-dashboard .border,
        .client-wv-dashboard .border-b,
        .client-wv-dashboard .border-t,
        .client-wv-dashboard .dark\:border-gray-700,
        .client-wv-dashboard .dark\:border-gray-600 {
            border-color: var(--dashboard-border) !important;
        }
        .client-wv-dashboard > div > .bg-white:first-of-type > div {
            background:
                linear-gradient(135deg, color-mix(in srgb, var(--dashboard-accent) 16%, transparent), color-mix(in srgb, var(--dashboard-live) 8%, transparent)),
                var(--dashboard-surface) !important;
            border: 1px solid var(--dashboard-border);
        }
        .client-wv-dashboard h3,
        .client-wv-dashboard h4,
        .client-wv-dashboard .font-bold,
        .client-wv-dashboard .font-extrabold,
        .client-wv-dashboard .text-gray-800,
        .client-wv-dashboard .text-gray-900,
        .client-wv-dashboard .dark\:text-white {
            color: var(--dashboard-text) !important;
        }
        .client-wv-dashboard p,
        .client-wv-dashboard label,
        .client-wv-dashboard .text-gray-500,
        .client-wv-dashboard .text-gray-400,
        .client-wv-dashboard .dark\:text-gray-400 {
            color: var(--dashboard-muted) !important;
        }
        .client-wv-dashboard .text-3xl,
        .client-wv-dashboard .text-5xl {
            font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
            color: var(--dashboard-accent) !important;
            letter-spacing: -0.04em;
        }
        .client-hero-card {
            position: relative;
            overflow: hidden;
            border: 1px solid color-mix(in srgb, var(--dashboard-accent) 22%, var(--dashboard-border)) !important;
            box-shadow: 0 28px 70px rgba(0, 0, 0, 0.24) !important;
        }
        .client-hero-card::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 12% 18%, color-mix(in srgb, var(--dashboard-accent) 28%, transparent), transparent 18rem),
                radial-gradient(circle at 92% 8%, color-mix(in srgb, var(--dashboard-live) 16%, transparent), transparent 16rem);
            opacity: .9;
            z-index: 0;
        }
        .client-hero-inner {
            position: relative;
            z-index: 1;
            min-height: 13rem;
            display: flex;
            align-items: center;
        }
        .client-hero-inner > div { width: 100%; }
        .client-hero-inner .bg-white\/15,
        .client-hero-inner .bg-white\/20 {
            background: color-mix(in srgb, var(--dashboard-surface) 62%, transparent) !important;
            border: 1px solid color-mix(in srgb, var(--dashboard-accent) 26%, transparent);
        }
        .client-hero-inner a,
        .client-hero-inner button,
        .client-hero-inner h3,
        .client-hero-inner p,
        .client-hero-inner svg,
        .client-hero-inner span {
            color: var(--dashboard-text) !important;
        }
        .client-hero-inner a[href*="settings"],
        .client-hero-inner a[href*="order"] {
            color: var(--dashboard-bg) !important;
        }
        .client-panel,
        .client-table-card {
            position: relative;
            overflow: hidden;
            background: color-mix(in srgb, var(--dashboard-surface) 96%, var(--dashboard-accent)) !important;
            border: 1px solid color-mix(in srgb, var(--dashboard-border) 78%, var(--dashboard-accent)) !important;
            box-shadow: 0 22px 54px rgba(0, 0, 0, 0.22) !important;
        }
        .client-panel::before,
        .client-table-card::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 3px;
            background: linear-gradient(90deg, var(--dashboard-accent), var(--dashboard-live));
            opacity: .8;
        }
        .client-panel > *,
        .client-table-card > * { position: relative; z-index: 1; }
        .client-wv-dashboard input,
        .client-wv-dashboard select,
        .client-wv-dashboard textarea {
            background: var(--dashboard-bg) !important;
            border-color: var(--dashboard-border) !important;
            color: var(--dashboard-text) !important;
            border-radius: 12px !important;
        }
        .client-wv-dashboard input:focus,
        .client-wv-dashboard select:focus,
        .client-wv-dashboard textarea:focus {
            border-color: var(--dashboard-accent) !important;
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--dashboard-accent) 16%, transparent) !important;
        }
        .client-wv-dashboard button[type="submit"] {
            min-height: 2.9rem;
            border-radius: 999px !important;
            font-weight: 800 !important;
            letter-spacing: .01em;
        }
        .client-wv-dashboard button[type="submit"],
        .client-wv-dashboard a[href*="settings"],
        .client-wv-dashboard a[href*="order"] {
            background: var(--dashboard-accent) !important;
            color: var(--dashboard-bg) !important;
            border-color: color-mix(in srgb, var(--dashboard-accent) 55%, transparent) !important;
            box-shadow: 0 12px 26px color-mix(in srgb, var(--dashboard-accent) 18%, transparent) !important;
        }
        .client-wv-dashboard table thead,
        .client-wv-dashboard .bg-gray-50,
        .client-wv-dashboard .dark\:bg-gray-700\/50 {
            background: var(--dashboard-surface-soft) !important;
        }
        .client-wv-dashboard tbody tr,
        .client-wv-dashboard .guest-row {
            background: var(--dashboard-surface) !important;
            border-bottom: 1px solid var(--dashboard-border) !important;
        }
        .client-wv-dashboard tbody tr:hover,
        .client-wv-dashboard .guest-row:hover {
            background: color-mix(in srgb, var(--dashboard-surface) 86%, var(--dashboard-accent)) !important;
        }
        .client-wv-dashboard th {
            color: var(--dashboard-muted) !important;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
        }
        .client-wv-dashboard td,
        .client-wv-dashboard td p {
            color: var(--dashboard-text) !important;
        }
        .client-wv-dashboard .bg-red-50,
        .client-wv-dashboard .dark\:bg-red-900\/30 {
            background: #3A1C1C !important;
            color: #FF453A !important;
            border-color: rgba(255, 69, 58, 0.4) !important;
        }
        .client-wv-dashboard .bg-green-50,
        .client-wv-dashboard .dark\:bg-green-900\/30 {
            background: rgba(50, 215, 75, 0.12) !important;
            color: #32D74B !important;
            border-color: rgba(50, 215, 75, 0.35) !important;
        }
        .client-wv-dashboard .bg-yellow-50,
        .client-wv-dashboard .dark\:bg-yellow-900\/30 {
            background: rgba(255, 204, 0, 0.12) !important;
            color: #FFD60A !important;
            border-color: rgba(255, 204, 0, 0.35) !important;
        }
        .client-wv-dashboard .border-2.border-dashed {
            background: color-mix(in srgb, var(--dashboard-bg) 70%, var(--dashboard-accent)) !important;
            border-color: color-mix(in srgb, var(--dashboard-accent) 30%, var(--dashboard-border)) !important;
            border-radius: 18px !important;
        }
        .client-wv-dashboard .border-2.border-dashed:hover {
            background: color-mix(in srgb, var(--dashboard-bg) 58%, var(--dashboard-accent)) !important;
        }
        .client-table-card table { border-collapse: separate; border-spacing: 0; }
        .client-table-card thead th:first-child { border-top-left-radius: 14px; }
        .client-table-card thead th:last-child { border-top-right-radius: 14px; }
        .client-table-card tbody tr:last-child td { border-bottom: 0 !important; }
        .client-table-card .p-1\.5 {
            width: 2.15rem;
            height: 2.15rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--dashboard-border);
            background: color-mix(in srgb, var(--dashboard-surface) 86%, var(--dashboard-bg));
        }
        .client-wv-dashboard #noGuestResult,
        .client-wv-dashboard .p-10.text-center {
            background: linear-gradient(135deg, color-mix(in srgb, var(--dashboard-accent) 8%, transparent), transparent);
        }
        /* RSVP tabs */
        .rsvp-tab { transition: color 0.15s, border-color 0.15s; }
        .rsvp-tab.is-active { color: var(--dashboard-accent) !important; border-color: var(--dashboard-accent) !important; }
        /* Modal: hide Alpine cloak */
        [x-cloak] { display: none !important; }
        @media (max-width: 640px) {
            .client-wv-dashboard { padding-top: 1rem; }
            .client-hero-inner { padding: 1.25rem !important; min-height: auto; }
            .client-wv-dashboard .text-3xl { font-size: 1.55rem !important; }
            .client-table-card th,
            .client-table-card td { padding: .85rem .9rem !important; }
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-15px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slideDown { animation: slideDown 0.4s ease-out; }
    </style>

    <script>
        function updateFileName(input) {
            const box = document.getElementById('fileNameDisplay');
            const txt = document.getElementById('fileNameText');
            if (input.files && input.files.length > 0) {
                const f = input.files[0];
                txt.textContent = f.name + ' (' + (f.size/1024).toFixed(1) + ' KB)';
                box.classList.remove('hidden');
            } else { box.classList.add('hidden'); }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => showToast('Link berhasil disalin! 🎉', 'success')).catch(() => showToast('Gagal menyalin link', 'error'));
        }

        function showToast(message, type = 'success') {
            const existing = document.getElementById('customToast');
            if (existing) existing.remove();
            const t = document.createElement('div');
            t.id = 'customToast';
            t.className = `fixed bottom-6 right-6 z-50 px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3 font-semibold text-sm text-white transition-all duration-300 ${type === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-pink-600'}`;
            t.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"/></svg>${message}`;
            document.body.appendChild(t);
            setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateX(400px)'; setTimeout(() => t.remove(), 300); }, 3000);
        }

        let activeRsvpTab = '';

        function setActiveTab(tab) {
            activeRsvpTab = tab || '';
            document.querySelectorAll('.rsvp-tab').forEach(el => {
                const isActive = (el.dataset.rsvpTab || '') === activeRsvpTab;
                el.classList.toggle('is-active', isActive);
                el.classList.toggle('text-indigo-600', isActive);
                el.classList.toggle('border-indigo-600', isActive);
                el.classList.toggle('text-gray-600', !isActive);
                el.classList.toggle('border-transparent', !isActive);
            });
        }

        function filterGuests() {
            const search = document.getElementById('guestSearch').value.toLowerCase();
            const rsvp = activeRsvpTab;
            const rows = document.querySelectorAll('.guest-row');
            let visible = 0;
            rows.forEach(row => {
                const name = row.dataset.name || '';
                const status = row.dataset.rsvp || '';
                const matchSearch = !search || name.includes(search);
                const matchRsvp = !rsvp || status === rsvp || (rsvp === 'pending' && (status === 'pending' || status === ''));
                if (matchSearch && matchRsvp) { row.style.display = ''; visible++; } else { row.style.display = 'none'; }
            });
            const noResult = document.getElementById('noGuestResult');
            if (noResult) noResult.classList.toggle('hidden', visible > 0);
            const countEl = document.getElementById('guestCountDisplay');
            if (countEl) countEl.textContent = visible + ' tamu' + (search || rsvp ? ' ditemukan' : '');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[role="alert"]').forEach(el => {
                setTimeout(() => { el.style.opacity = '0'; el.style.transform = 'translateY(-10px)'; el.style.transition = 'all 0.3s'; setTimeout(() => el.remove(), 300); }, 5000);
            });

            // RSVP tabs click handler
            document.querySelectorAll('.rsvp-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    setActiveTab(this.dataset.rsvpTab || '');
                    filterGuests();
                });
            });

            // Init dropdown provinsi untuk form tambah tamu
            initTamuProvince();
        });

        async function initTamuProvince() {
            const provEl = document.getElementById('tamu_province');
            const regEl  = document.getElementById('tamu_regency');
            if (!provEl) return;

            try {
                const res = await fetch('/api/wilayah/provinces');
                const provinces = await res.json();
                provinces.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.name;
                    provEl.appendChild(opt);
                });
            } catch(e) { console.error(e); }

            provEl.addEventListener('change', async function() {
                regEl.innerHTML = '<option value="">-- Pilih Kab/Kota --</option>';
                regEl.disabled = true;
                document.getElementById('tamu_address_val').value = '';
                if (!this.value) return;
                try {
                    const res = await fetch('/api/wilayah/regencies/' + this.value);
                    const regencies = await res.json();
                    regencies.forEach(r => {
                        const opt = document.createElement('option');
                        opt.value = r.id;
                        opt.textContent = r.name;
                        regEl.appendChild(opt);
                    });
                    regEl.disabled = false;
                } catch(e) { console.error(e); }
            });

            regEl.addEventListener('change', function() {
                const provName = provEl.options[provEl.selectedIndex]?.text || '';
                const regName  = this.options[this.selectedIndex]?.text || '';
                const val = [regName, provName].filter(Boolean).join(', ');
                document.getElementById('tamu_address_val').value = val;
            });
        }
    </script>

</x-app-layout>