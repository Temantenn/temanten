<x-app-layout>
    @php
        $totalCount  = $pendingOrders->count() + $activeOrders->count();
        $pendCount   = $pendingOrders->count();
        $actCount    = $activeOrders->count();
    @endphp

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.18em]"
                   style="color: var(--dashboard-muted);">Admin Console</p>
                <h1 class="text-[22px] font-semibold tracking-[-0.4px] mt-1"
                    style="color: var(--dashboard-text);">
                    Halo, {{ Auth::user()->name }}
                </h1>
                <p class="text-[13px] mt-0.5" style="color: var(--dashboard-muted);">
                    {{ now()->translatedFormat('l, d F Y') }} · {{ $pendCount }} permintaan menunggu
                </p>
            </div>
        </div>
    </x-slot>

    <div class="admin-cmd py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="flash flash-success" role="alert">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="flash flash-error" role="alert">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- KPI Strip --}}
            <section class="kpi-strip">
                <div class="kpi">
                    <p class="kpi-label">Permintaan</p>
                    <p class="kpi-value mono">{{ $pendCount }}</p>
                    <p class="kpi-meta">menunggu aktivasi</p>
                </div>
                <div class="kpi">
                    <p class="kpi-label">Klien Aktif</p>
                    <p class="kpi-value mono">{{ $actCount }}</p>
                    <p class="kpi-meta">undangan tayang</p>
                </div>
                <div class="kpi">
                    <p class="kpi-label">Total</p>
                    <p class="kpi-value mono">{{ $totalCount }}</p>
                    <p class="kpi-meta">semua pesanan</p>
                </div>
                <div class="kpi">
                    <p class="kpi-label">Konversi</p>
                    <p class="kpi-value mono">{{ $totalCount > 0 ? round(($actCount / $totalCount) * 100) : 0 }}<span class="kpi-unit">%</span></p>
                    <p class="kpi-meta">pending → aktif</p>
                </div>
            </section>

            {{-- Quick Actions Row --}}
            <section class="quick-row">
                <a href="{{ route('admin.themes.pricing') }}" class="qa">
                    <span class="qa-icon" style="background: rgba(8, 145, 178, 0.08); color: var(--dashboard-accent);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <span class="qa-text">
                        <span class="qa-title">Harga Tema</span>
                        <span class="qa-sub">Atur harga & default</span>
                    </span>
                </a>
                <a href="{{ route('admin.admins') }}" class="qa">
                    <span class="qa-icon" style="background: rgba(139, 92, 246, 0.08); color: #8b5cf6;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <span class="qa-text">
                        <span class="qa-title">Kelola Admin</span>
                        <span class="qa-sub">Tambah & hapus admin</span>
                    </span>
                </a>
                <a href="{{ route('admin.themes.index') }}" class="qa">
                    <span class="qa-icon" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                    <span class="qa-text">
                        <span class="qa-title">Thumbnail & Musik</span>
                        <span class="qa-sub">Upload per tema</span>
                    </span>
                </a>
                <div class="qa qa-disabled" aria-disabled="true">
                    <span class="qa-icon" style="background: rgba(139, 92, 246, 0.08); color: #8b5cf6;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <span class="qa-text">
                        <span class="qa-title">Activity Log <span class="qa-soon">Segera</span></span>
                        <span class="qa-sub">Audit jejak admin</span>
                    </span>
                </div>
            </section>

            {{-- INCOMING REQUESTS — Kanban --}}
            <section class="panel" x-data="{ filterTheme: '' }">
                <header class="panel-head">
                    <div>
                        <h2 class="panel-title">Permintaan Masuk</h2>
                        <p class="panel-sub">{{ $pendCount }} pesanan menunggu aktivasi</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($pendCount > 0)
                            <span class="dot-pulse" aria-label="perlu tindakan"></span>
                            <span class="text-[11px] font-medium uppercase tracking-wider" style="color: var(--dashboard-danger);">Perlu Tindakan</span>
                        @endif
                    </div>
                </header>

                @if($pendCount > 0)
                    <div class="kanban">
                        @foreach($pendingOrders as $order)
                            @php
                                $wa = $order->client_whatsapp;
                                $waFormatted = str_starts_with($wa, '0') ? '62'.substr($wa, 1) : (str_starts_with($wa, '8') ? '62'.$wa : $wa);
                            @endphp
                            <article class="kb-card" data-theme="{{ strtolower($order->theme->slug ?? '') }}">
                                <div class="kb-top">
                                    <span class="kb-id mono">#INV-{{ $order->id }}</span>
                                    <span class="kb-time">{{ $order->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="kb-couple">
                                    <p class="kb-pria">{{ $order->content['mempelai']['pria']['nama'] ?? '—' }}</p>
                                    <p class="kb-amp">&</p>
                                    <p class="kb-wanita">{{ $order->content['mempelai']['wanita']['nama'] ?? '—' }}</p>
                                </div>

                                <dl class="kb-meta">
                                    <div class="kb-row">
                                        <dt>Tema</dt>
                                        <dd>{{ $order->theme->name ?? '—' }}</dd>
                                    </div>
                                    <div class="kb-row">
                                        <dt>Acara</dt>
                                        <dd>{{ $order->event_date->format('d M Y') }}</dd>
                                    </div>
                                    <div class="kb-row">
                                        <dt>WA</dt>
                                        <dd><a href="https://wa.me/{{ $waFormatted }}" target="_blank" class="kb-wa mono">{{ $waFormatted }}</a></dd>
                                    </div>
                                </dl>

                                <div class="kb-actions">
                                    <form action="{{ route('admin.approve', $order->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" data-testid="admin-approve-order" class="kb-btn kb-btn-primary w-full">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Setujui
                                        </button>
                                    </form>
                                    <button type="button" class="kb-btn kb-btn-ghost" onclick="openRejectModal({{ $order->id }}, '{{ addslashes($order->content['mempelai']['pria']['nama'] ?? '') }} & {{ addslashes($order->content['mempelai']['wanita']['nama'] ?? '') }}')">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty">
                        <p class="empty-title">Semua bersih 🎉</p>
                        <p class="empty-sub">Tidak ada pesanan yang perlu diproses saat ini.</p>
                    </div>
                @endif
            </section>

            {{-- ACTIVE CLIENTS — Searchable Table --}}
            <section class="panel" x-data="clientTable()">
                <header class="panel-head">
                    <div>
                        <h2 class="panel-title">Klien Aktif</h2>
                        <p class="panel-sub"><span x-text="visibleCount"></span> dari {{ $actCount }} akun aktif</p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <div class="search-wrap">
                            <svg class="w-3.5 h-3.5 search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" x-model="q" placeholder="Cari nama, email, tema…" class="search-input">
                        </div>
                        <select x-model="themeFilter" class="filter-select">
                            <option value="">Semua Tema</option>
                            @foreach(\App\Models\Theme::orderBy('name')->get() as $t)
                                <option value="{{ strtolower($t->slug) }}">{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </header>

                @if($actCount > 0)
                    <div class="tbl">
                        <div class="tbl-head">
                            <div>Klien</div>
                            <div>Email Login</div>
                            <div>Tema</div>
                            <div>Acara</div>
                            <div class="text-right">Aksi</div>
                        </div>
                        @foreach($activeOrders as $client)
                            @php
                                $themeSlug = strtolower($client->theme->slug ?? '');
                                $searchKey = strtolower(
                                    ($client->content['mempelai']['pria']['nama'] ?? '') . ' ' .
                                    ($client->content['mempelai']['wanita']['nama'] ?? '') . ' ' .
                                    ($client->user->email ?? '') . ' ' .
                                    ($client->theme->name ?? '')
                                );
                            @endphp
                            <div class="tbl-row"
                                 x-show="matches({{ json_encode($searchKey) }}, '{{ $themeSlug }}')"
                                 x-cloak>
                                <div class="tbl-cell">
                                    <p class="tbl-name">{{ $client->content['mempelai']['pria']['nama'] ?? '—' }}</p>
                                    <p class="tbl-sub">{{ $client->content['mempelai']['wanita']['nama'] ?? '—' }}</p>
                                </div>
                                <div class="tbl-cell">
                                    @if($client->user)
                                        <span class="tbl-mono">{{ $client->user->email }}</span>
                                    @else
                                        <span class="tbl-err">User Missing</span>
                                    @endif
                                </div>
                                <div class="tbl-cell">
                                    <span class="tbl-theme">{{ $client->theme->name ?? '—' }}</span>
                                </div>
                                <div class="tbl-cell">
                                    <span class="tbl-date mono">{{ $client->event_date->format('d M Y') }}</span>
                                </div>
                                <div class="tbl-cell text-right">
                                    <div x-data="{ open: false }" @click.outside="open = false" class="relative inline-block">
                                        <button @click="open = !open" class="row-btn" data-testid="row-actions-{{ $client->id }}">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                                        </button>
                                        <div x-show="open" x-cloak x-transition.opacity class="row-menu">
                                            <a href="{{ url('undangan/'.$client->slug) }}" target="_blank" class="row-menu-item">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                Lihat Undangan
                                            </a>
                                            @if($client->user)
                                                <button type="button" onclick="openResetModal({{ $client->user->id }}, '{{ $client->user->email }}')" class="row-menu-item">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                                    Reset Password
                                                </button>
                                            @endif
                                            <a href="https://wa.me/{{ str_starts_with($client->client_whatsapp, '0') ? '62'.substr($client->client_whatsapp, 1) : (str_starts_with($client->client_whatsapp, '8') ? '62'.$client->client_whatsapp : $client->client_whatsapp) }}" target="_blank" class="row-menu-item">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                                Hubungi WA
                                            </a>
                                            <div class="row-menu-sep"></div>
                                            <button type="button" class="row-menu-item row-menu-danger" onclick="openCancelModal({{ $client->id }}, '{{ $client->content['mempelai']['pria']['nama'] ?? '' }} & {{ $client->content['mempelai']['wanita']['nama'] ?? '' }}')">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                Batalkan Undangan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div x-show="visibleCount === 0" x-cloak class="empty-search">
                            <p>Tidak ada klien yang cocok dengan pencarian.</p>
                        </div>
                    </div>
                @else
                    <div class="empty">
                        <p class="empty-title">Belum ada klien aktif</p>
                        <p class="empty-sub">Aktifkan pesanan di atas untuk menambah klien pertama.</p>
                    </div>
                @endif
            </section>

        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="reject-modal" class="modal-ov" style="display:none;">
        <div class="modal-box">
            <button type="button" onclick="closeModal('reject-modal')" class="modal-x">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="modal-icon-wrap modal-icon-danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <h3 class="modal-title">Tolak pesanan?</h3>
            <p class="modal-desc">Anda akan menolak pesanan untuk <br><strong id="reject-target-name" class="modal-target"></strong></p>
            <form id="reject-form" method="POST">
                @csrf
                <textarea name="reason" rows="3" maxlength="500" placeholder="Alasan penolakan (opsional)…"
                          class="modal-textarea"></textarea>
                <div class="modal-actions">
                    <button type="button" onclick="closeModal('reject-modal')" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reset Password Modal --}}
    <div id="reset-modal" class="modal-ov" style="display:none;">
        <div class="modal-box">
            <button type="button" onclick="closeModal('reset-modal')" class="modal-x">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="modal-icon-wrap modal-icon-warn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <h3 class="modal-title">Reset password?</h3>
            <p class="modal-desc">Password baru akan dibuat dan ditampilkan setelah konfirmasi untuk akun <br><strong id="reset-target-email" class="modal-target mono"></strong></p>
            <form id="reset-form" method="POST">
                @csrf
                <div class="modal-actions">
                    <button type="button" onclick="closeModal('reset-modal')" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-warn">Reset Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Cancel Invitation Modal --}}
    <div id="cancel-modal" class="modal-ov" style="display:none;">
        <div class="modal-box">
            <button type="button" onclick="closeModal('cancel-modal')" class="modal-x">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="modal-icon-wrap modal-icon-danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <h3 class="modal-title">Batalkan undangan?</h3>
            <p class="modal-desc">Undangan <br><strong id="cancel-target-name" class="modal-target"></strong> akan dinonaktifkan dan tidak bisa diakses tamu lagi.</p>
            <form id="cancel-form" method="POST">
                @csrf
                <textarea name="reason" rows="3" maxlength="500" placeholder="Alasan pembatalan (opsional)…"
                          class="modal-textarea"></textarea>
                <div class="modal-actions">
                    <button type="button" onclick="closeModal('cancel-modal')" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- New Account Created Modal (after approve) --}}
    @if(session('new_account'))
    <div class="modal-ov" id="newAccountModal" style="display:flex;">
        <div class="modal-box">
            <button type="button" onclick="document.getElementById('newAccountModal').remove()" class="modal-x">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="modal-icon-wrap modal-icon-success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="modal-title">Akun berhasil dibuat</h3>
            <p class="modal-desc">Salin kredensial sebelum menutup.</p>

            <div class="cred">
                <div class="cred-row">
                    <span class="cred-key">Email</span>
                    <span class="cred-val mono">{{ session('new_account')['email'] }}</span>
                </div>
                <div class="cred-row">
                    <span class="cred-key">Password</span>
                    <span class="cred-val cred-pw mono">{{ session('new_account')['password'] }}</span>
                </div>
            </div>

            <div class="wa-block">
                <label class="wa-label">Template WhatsApp</label>
                <div class="wa-text-wrap">
                    <textarea id="waMessage" readonly class="modal-textarea wa-text">Halo, undangan sudah aktif! 🎉

Login Dashboard:
🔗 {{ url('/login') }}
📧 {{ session('new_account')['email'] }}
🔑 {{ session('new_account')['password'] }}

Terima kasih!</textarea>
                    <button type="button" onclick="copyWA(this)" class="copy-btn">Salin</button>
                </div>
            </div>

            <button onclick="document.getElementById('newAccountModal').remove()" class="btn btn-primary w-full mt-4">Selesai</button>
        </div>
    </div>
    @endif

    {{-- Reset Success Modal --}}
    @if(session('reset_success'))
    <div class="modal-ov" id="resetModal" style="display:flex;">
        <div class="modal-box">
            <button type="button" onclick="document.getElementById('resetModal').remove()" class="modal-x">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="modal-icon-wrap modal-icon-warn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
            <h3 class="modal-title">Password berhasil direset</h3>
            <div class="cred">
                <div class="cred-row">
                    <span class="cred-key">Akun</span>
                    <span class="cred-val mono">{{ session('reset_success')['email'] }}</span>
                </div>
                <div class="cred-row">
                    <span class="cred-key">Password Baru</span>
                    <span class="cred-val cred-pw mono">{{ session('reset_success')['password'] }}</span>
                </div>
            </div>
            <button onclick="document.getElementById('resetModal').remove()" class="btn btn-primary w-full mt-4">Tutup</button>
        </div>
    </div>
    @endif

    <style>
        [x-cloak] { display: none !important; }

        /* === KPI Strip === */
        .admin-cmd .kpi-strip {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--dashboard-border);
            border: 1px solid var(--dashboard-border);
            border-radius: 12px;
            overflow: hidden;
        }
        @media (max-width: 768px) { .admin-cmd .kpi-strip { grid-template-columns: repeat(2, 1fr); } }
        .admin-cmd .kpi {
            padding: 18px 20px;
            background: var(--dashboard-surface);
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .admin-cmd .kpi-label {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--dashboard-muted);
        }
        .admin-cmd .kpi-value {
            font-size: 30px;
            font-weight: 600;
            letter-spacing: -0.8px;
            color: var(--dashboard-text);
            line-height: 1.1;
            margin-top: 4px;
        }
        .admin-cmd .kpi-unit { font-size: 18px; color: var(--dashboard-muted); margin-left: 2px; }
        .admin-cmd .kpi-meta { font-size: 12px; color: var(--dashboard-muted); margin-top: 2px; }
        .admin-cmd .kpi-accent .kpi-value { color: var(--dashboard-accent); }
        .mono { font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, monospace; font-feature-settings: "ss01"; }

        /* === Quick Actions Row === */
        .admin-cmd .quick-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        @media (max-width: 768px) { .admin-cmd .quick-row { grid-template-columns: repeat(2, 1fr); } }
        .admin-cmd .qa {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 10px;
            transition: border-color 0.15s, background 0.15s;
        }
        .admin-cmd .qa:hover {
            border-color: var(--dashboard-text);
            background: color-mix(in srgb, var(--dashboard-text) 4%, var(--dashboard-surface));
        }
        .admin-cmd .qa-disabled {
            opacity: 0.55;
            cursor: not-allowed;
        }
        .admin-cmd .qa-disabled:hover {
            border-color: var(--dashboard-border);
            background: var(--dashboard-surface);
        }
        .admin-cmd .qa-soon {
            display: inline-block;
            margin-left: 0.4rem;
            padding: 1px 6px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--dashboard-muted);
            background: var(--dashboard-surface-soft);
            border: 1px solid var(--dashboard-border);
            border-radius: 4px;
            vertical-align: middle;
            line-height: 1.4;
        }
        .admin-cmd .qa-icon {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            flex-shrink: 0;
        }
        .admin-cmd .qa-text { display: flex; flex-direction: column; min-width: 0; }
        .admin-cmd .qa-title { font-size: 13px; font-weight: 500; color: var(--dashboard-text); }
        .admin-cmd .qa-sub { font-size: 11px; color: var(--dashboard-muted); margin-top: 1px; }

        /* === Panel (card) === */
        .admin-cmd .panel {
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 12px;
            overflow: hidden;
        }
        .admin-cmd .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--dashboard-border);
        }
        .admin-cmd .panel-title {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -0.15px;
            color: var(--dashboard-text);
        }
        .admin-cmd .panel-sub {
            font-size: 12px;
            color: var(--dashboard-muted);
            margin-top: 1px;
        }
        .dot-pulse {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--dashboard-danger);
            box-shadow: 0 0 0 0 color-mix(in srgb, var(--dashboard-danger) 60%, transparent);
            animation: pulse-ring 1.6s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 color-mix(in srgb, var(--dashboard-danger) 60%, transparent); }
            70% { box-shadow: 0 0 0 8px transparent; }
            100% { box-shadow: 0 0 0 0 transparent; }
        }

        /* === Kanban === */
        .admin-cmd .kanban {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 12px;
            padding: 16px;
        }
        .admin-cmd .kb-card {
            border: 1px solid var(--dashboard-border);
            border-radius: 10px;
            padding: 14px;
            background: var(--dashboard-bg);
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: border-color 0.15s, transform 0.15s;
        }
        .admin-cmd .kb-card:hover {
            border-color: var(--dashboard-accent);
            transform: translateY(-1px);
        }
        .admin-cmd .kb-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-cmd .kb-id {
            font-size: 11px;
            color: var(--dashboard-muted);
            letter-spacing: 0.05em;
        }
        .admin-cmd .kb-time {
            font-size: 11px;
            color: var(--dashboard-muted);
        }
        .admin-cmd .kb-couple {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .admin-cmd .kb-pria, .admin-cmd .kb-wanita {
            font-size: 14px;
            font-weight: 500;
            color: var(--dashboard-text);
            line-height: 1.3;
        }
        .admin-cmd .kb-amp {
            font-size: 11px;
            color: var(--dashboard-muted);
            font-style: italic;
            line-height: 1;
        }
        .admin-cmd .kb-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 10px 0;
            border-top: 1px solid var(--dashboard-border);
            border-bottom: 1px solid var(--dashboard-border);
        }
        .admin-cmd .kb-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }
        .admin-cmd .kb-row dt {
            color: var(--dashboard-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 10px;
            font-weight: 500;
        }
        .admin-cmd .kb-row dd { color: var(--dashboard-text); text-align: right; }
        .admin-cmd .kb-wa { color: var(--dashboard-accent); text-decoration: none; }
        .admin-cmd .kb-wa:hover { text-decoration: underline; }

        .admin-cmd .kb-actions {
            display: flex;
            gap: 6px;
        }
        .admin-cmd .kb-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            height: 32px;
            padding: 0 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background 0.15s, opacity 0.15s;
        }
        .admin-cmd .kb-btn-primary {
            background: var(--dashboard-accent);
            color: #fff;
        }
        .admin-cmd .kb-btn-primary:hover { opacity: 0.85; }
        .admin-cmd .kb-btn-ghost {
            background: transparent;
            border-color: var(--dashboard-border);
            color: var(--dashboard-muted);
            width: 32px;
            padding: 0;
        }
        .admin-cmd .kb-btn-ghost:hover {
            color: var(--dashboard-danger);
            border-color: var(--dashboard-danger);
        }

        /* === Active Clients Table === */
        .admin-cmd .search-wrap {
            position: relative;
            flex: 1;
            min-width: 0;
        }
        .admin-cmd .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dashboard-muted);
            pointer-events: none;
        }
        .admin-cmd .search-input {
            width: 100%;
            height: 32px;
            padding: 0 10px 0 30px;
            background: var(--dashboard-bg);
            border: 1px solid var(--dashboard-border);
            border-radius: 6px;
            font-size: 12px;
            color: var(--dashboard-text);
            outline: none;
            transition: border-color 0.15s;
        }
        .admin-cmd .search-input::placeholder { color: var(--dashboard-muted); }
        .admin-cmd .search-input:focus { border-color: var(--dashboard-accent); }
        .admin-cmd .filter-select {
            height: 32px;
            padding: 0 28px 0 10px;
            background: var(--dashboard-bg);
            border: 1px solid var(--dashboard-border);
            border-radius: 6px;
            font-size: 12px;
            color: var(--dashboard-text);
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%236B7280' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        .admin-cmd .tbl { display: flex; flex-direction: column; }
        .admin-cmd .tbl-head, .admin-cmd .tbl-row {
            display: grid;
            grid-template-columns: 1.4fr 1.6fr 1fr 0.8fr 60px;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
        }
        @media (max-width: 768px) {
            .admin-cmd .tbl-head { display: none; }
            .admin-cmd .tbl-row { grid-template-columns: 1fr; gap: 4px; padding: 12px 16px; border-bottom: 1px solid var(--dashboard-border); }
        }
        .admin-cmd .tbl-head {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--dashboard-muted);
            background: color-mix(in srgb, var(--dashboard-bg) 70%, transparent);
            border-bottom: 1px solid var(--dashboard-border);
        }
        .admin-cmd .tbl-row {
            border-bottom: 1px solid var(--dashboard-border);
            font-size: 13px;
            transition: background 0.12s;
        }
        .admin-cmd .tbl-row:last-child { border-bottom: none; }
        .admin-cmd .tbl-row:hover { background: color-mix(in srgb, var(--dashboard-accent) 4%, transparent); }
        .admin-cmd .tbl-cell { min-width: 0; }
        .admin-cmd .tbl-name { font-size: 13px; font-weight: 500; color: var(--dashboard-text); }
        .admin-cmd .tbl-sub { font-size: 12px; color: var(--dashboard-muted); margin-top: 1px; }
        .admin-cmd .tbl-mono { font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 12px; color: var(--dashboard-text); }
        .admin-cmd .tbl-err {
            font-size: 11px; color: var(--dashboard-danger); font-weight: 500;
            padding: 2px 6px; border-radius: 4px;
            background: color-mix(in srgb, var(--dashboard-danger) 8%, transparent);
        }
        .admin-cmd .tbl-theme { font-size: 12px; color: var(--dashboard-text); }
        .admin-cmd .tbl-date { font-size: 12px; color: var(--dashboard-muted); }

        .admin-cmd .row-btn {
            width: 28px; height: 28px;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 6px;
            background: transparent;
            border: 1px solid transparent;
            color: var(--dashboard-muted);
            cursor: pointer;
            transition: background 0.12s, color 0.12s;
        }
        .admin-cmd .row-btn:hover { background: var(--dashboard-bg); color: var(--dashboard-text); }
        .admin-cmd .row-menu {
            position: absolute;
            right: 0; top: calc(100% + 4px);
            min-width: 180px;
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12), 0 0 0 1px rgba(0,0,0,0.04);
            padding: 4px;
            z-index: 20;
        }
        .admin-cmd .row-menu-item {
            display: flex; align-items: center; gap: 8px;
            width: 100%;
            padding: 7px 10px;
            font-size: 12px;
            color: var(--dashboard-text);
            background: transparent;
            border: none;
            border-radius: 5px;
            text-align: left;
            cursor: pointer;
            transition: background 0.1s;
            text-decoration: none;
        }
        .admin-cmd .row-menu-item:hover { background: var(--dashboard-bg); }
        .admin-cmd .row-menu-sep { height: 1px; background: var(--dashboard-border); margin: 4px 0; }
        .admin-cmd .row-menu-danger { color: var(--dashboard-danger); }
        .admin-cmd .row-menu-danger:hover { background: color-mix(in srgb, var(--dashboard-danger) 8%, transparent); }

        /* === Empty states === */
        .admin-cmd .empty {
            padding: 48px 24px;
            text-align: center;
        }
        .admin-cmd .empty-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--dashboard-text);
            margin-bottom: 4px;
        }
        .admin-cmd .empty-sub {
            font-size: 12px;
            color: var(--dashboard-muted);
        }
        .admin-cmd .empty-search {
            padding: 32px 18px;
            text-align: center;
            font-size: 13px;
            color: var(--dashboard-muted);
        }

        /* === Flash === */
        .flash {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            border: 1px solid;
        }
        .flash-success {
            color: #047857;
            background: color-mix(in srgb, #10b981 8%, transparent);
            border-color: color-mix(in srgb, #10b981 25%, transparent);
        }
        html.dark .flash-success { color: #6ee7b7; }
        .flash-error {
            color: #b91c1c;
            background: color-mix(in srgb, #ef4444 8%, transparent);
            border-color: color-mix(in srgb, #ef4444 25%, transparent);
        }
        html.dark .flash-error { color: #fca5a5; }

        /* === Modal === */
        .modal-ov {
            position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            padding: 16px;
        }
        .modal-box {
            position: relative;
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 12px;
            padding: 28px 24px 22px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: modalIn 0.18s ease;
        }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.96) translateY(8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-x {
            position: absolute; top: 12px; right: 12px;
            width: 24px; height: 24px;
            display: flex; align-items: center; justify-content: center;
            background: transparent;
            border: none;
            border-radius: 4px;
            color: var(--dashboard-muted);
            cursor: pointer;
        }
        .modal-x:hover { background: var(--dashboard-bg); color: var(--dashboard-text); }
        .modal-icon-wrap {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 14px;
        }
        .modal-icon-danger { background: color-mix(in srgb, #ef4444 10%, transparent); color: #ef4444; }
        .modal-icon-warn { background: color-mix(in srgb, #f59e0b 10%, transparent); color: #f59e0b; }
        .modal-icon-success { background: color-mix(in srgb, #10b981 10%, transparent); color: #10b981; }
        .modal-title {
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            color: var(--dashboard-text);
            letter-spacing: -0.2px;
        }
        .modal-desc {
            font-size: 13px;
            color: var(--dashboard-muted);
            text-align: center;
            margin-top: 6px;
            line-height: 1.5;
        }
        .modal-target { color: var(--dashboard-text); font-weight: 500; }
        .modal-textarea {
            width: 100%;
            padding: 10px 12px;
            background: var(--dashboard-bg);
            border: 1px solid var(--dashboard-border);
            border-radius: 6px;
            font-size: 13px;
            color: var(--dashboard-text);
            font-family: inherit;
            resize: vertical;
            margin-top: 14px;
            outline: none;
            transition: border-color 0.15s;
        }
        .modal-textarea:focus { border-color: var(--dashboard-accent); }
        .modal-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 16px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            height: 34px;
            padding: 0 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer;
            transition: opacity 0.15s, background 0.15s;
        }
        .btn:hover { opacity: 0.88; }
        .btn-ghost {
            background: transparent;
            border-color: var(--dashboard-border);
            color: var(--dashboard-text);
        }
        .btn-ghost:hover { background: var(--dashboard-bg); opacity: 1; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-warn { background: #f59e0b; color: #fff; }
        .btn-primary { background: var(--dashboard-accent); color: #fff; }

        .cred {
            margin-top: 16px;
            background: var(--dashboard-bg);
            border: 1px solid var(--dashboard-border);
            border-radius: 8px;
            padding: 12px 14px;
        }
        .cred-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
        }
        .cred-row + .cred-row { border-top: 1px solid var(--dashboard-border); }
        .cred-key {
            font-size: 11px;
            color: var(--dashboard-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .cred-val { font-size: 13px; color: var(--dashboard-text); }
        .cred-pw { color: #ef4444; font-weight: 500; letter-spacing: 0.04em; }

        .wa-block { margin-top: 14px; }
        .wa-label {
            display: block;
            font-size: 11px;
            color: var(--dashboard-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .wa-text-wrap { position: relative; }
        .wa-text { height: 130px !important; margin-top: 0 !important; padding-right: 60px; }
        .copy-btn {
            position: absolute;
            top: 8px; right: 8px;
            height: 24px;
            padding: 0 10px;
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            color: var(--dashboard-text);
            cursor: pointer;
        }
        .copy-btn:hover { border-color: var(--dashboard-accent); color: var(--dashboard-accent); }

        /* === Print === */
        @media print {
            .admin-cmd .quick-row, .admin-cmd .kb-actions, .admin-cmd .row-btn, .modal-ov { display: none !important; }
        }
    </style>

    <script>
        function openRejectModal(id, coupleName) {
            const form = document.getElementById('reject-form');
            form.action = `/admin/reject/${id}`;
            document.getElementById('reject-target-name').textContent = coupleName;
            document.getElementById('reject-modal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function openResetModal(userId, email) {
            const form = document.getElementById('reset-form');
            form.action = `/admin/reset-password/${userId}`;
            document.getElementById('reset-target-email').textContent = email;
            document.getElementById('reset-modal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function openCancelModal(id, coupleName) {
            const form = document.getElementById('cancel-form');
            form.action = `/admin/invitations/${id}/cancel`;
            document.getElementById('cancel-target-name').textContent = coupleName;
            document.getElementById('cancel-modal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
            document.body.style.overflow = '';
        }

        function copyWA(btn) {
            const text = document.getElementById('waMessage').value;
            navigator.clipboard.writeText(text).then(() => {
                const original = btn.textContent;
                btn.textContent = 'Tersalin ✓';
                btn.style.color = '#10b981';
                setTimeout(() => { btn.textContent = original; btn.style.color = ''; }, 1800);
            });
        }

        function clientTable() {
            return {
                q: '',
                themeFilter: '',
                visibleCount: {{ $actCount }},
                matches(searchKey, themeSlug) {
                    const q = this.q.toLowerCase().trim();
                    const matchesQ = !q || searchKey.includes(q);
                    const matchesT = !this.themeFilter || themeSlug === this.themeFilter;
                    return matchesQ && matchesT;
                },
                recompute() {
                    this.$nextTick(() => {
                        const rows = document.querySelectorAll('.tbl-row');
                        let n = 0;
                        rows.forEach(r => { if (r.offsetParent !== null) n++; });
                        this.visibleCount = n;
                    });
                },
                init() {
                    this.$watch('q', () => this.recompute());
                    this.$watch('themeFilter', () => this.recompute());
                }
            };
        }
    </script>
</x-app-layout>
