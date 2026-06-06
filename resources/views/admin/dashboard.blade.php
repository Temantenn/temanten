<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl transition-transform" style="background: var(--dashboard-surface); border: 1px solid var(--dashboard-border); color: var(--dashboard-accent);">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em]" style="color: var(--dashboard-accent);">Temanten Admin Control</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight" style="color: var(--dashboard-text);">
                        Admin Dashboard
                    </h2>
                    <p class="text-sm mt-0.5" style="color: var(--dashboard-muted);">
                        Kelola pesanan dan akun klien dalam satu tempat
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-xl shadow-sm" style="background: var(--dashboard-surface); border: 1px solid var(--dashboard-border);">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-sm" style="color: var(--dashboard-muted);">System Online</span>
                </div>
                <a href="{{ route('admin.themes') }}"
                   class="hidden md:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition shadow-lg"
                   style="background: var(--dashboard-accent); color: var(--dashboard-bg);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Harga Tema
                </a>
            </div>
        </div>
    </x-slot>

    <div class="admin-wv-dashboard py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <x-alert-success :message="session('success')" />
            @endif

            <!-- Stats Cards -->
            <div class="admin-kpi-grid grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stat-card stat-card-pending">
                    <div class="stat-icon bg-gradient-to-br from-amber-400 to-orange-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Menunggu Aktivasi</p>
                        <p class="stat-value text-amber-600 dark:text-amber-400">{{ $pendingOrders->count() }}</p>
                    </div>
                    <div class="stat-bg-pattern"></div>
                </div>
                <div class="stat-card stat-card-active">
                    <div class="stat-icon bg-gradient-to-br from-emerald-400 to-green-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Klien Aktif</p>
                        <p class="stat-value text-emerald-600 dark:text-emerald-400">{{ $activeOrders->count() }}</p>
                    </div>
                    <div class="stat-bg-pattern"></div>
                </div>
                <div class="stat-card stat-card-total">
                    <div class="stat-icon bg-gradient-to-br from-blue-400 to-blue-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Undangan</p>
                        <p class="stat-value text-indigo-600 dark:text-indigo-400">{{ $pendingOrders->count() + $activeOrders->count() }}</p>
                    </div>
                    <div class="stat-bg-pattern"></div>
                </div>
            </div>

            <!-- Pending Orders Section -->
            <div class="dashboard-card">
                <div class="card-header card-header-warning">
                    <div class="flex items-center gap-4">
                        <div class="header-icon bg-gradient-to-br from-amber-500 to-orange-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="card-title">Permintaan Masuk</h3>
                            <p class="card-subtitle">{{ $pendingOrders->count() }} pesanan menunggu aktivasi</p>
                        </div>
                    </div>
                    @if($pendingOrders->count() > 0)
                    <span class="badge badge-warning animate-pulse">Perlu Tindakan</span>
                    @endif
                </div>

                @if($pendingOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID / Tanggal</th>
                                <th>Mempelai</th>
                                <th>Paket</th>
                                <th>Kontak</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOrders as $order)
                            @php
                                $wa = $order->client_whatsapp;
                                $waFormatted = str_starts_with($wa, '0') ? '62'.substr($wa, 1) : (str_starts_with($wa, '8') ? '62'.$wa : $wa);
                            @endphp
                            <tr class="table-row-hover">
                                <td>
                                    <span class="id-badge id-badge-warning">#INV-{{ $order->id }}</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $order->content['mempelai']['pria']['nama'] }} & {{ $order->content['mempelai']['wanita']['nama'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $order->event_date->format('d M Y') }}
                                    </p>
                                </td>
                                <td>
                                    <span class="theme-badge">{{ $order->theme->name }}</span>
                                </td>
                                <td>
                                    <a href="https://wa.me/{{ $waFormatted }}" target="_blank" class="wa-link">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        {{ $waFormatted }}
                                    </a>
                                </td>
                                <td class="text-right">
                                    <form id="approve-form-{{ $order->id }}" action="{{ route('admin.approve', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn-activate w-full justify-center" data-testid="admin-approve-order" data-order-slug="{{ $order->slug }}" onclick="openAdminModal('approve-modal-{{ $order->id }}')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            Setujui
                                        </button>
                                    </form>

                                    <!-- Flowbite Approve Modal -->
                                    <div id="approve-modal-{{ $order->id }}" tabindex="-1" style="display:none;" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[100] w-full h-full bg-black/50 flex justify-center items-center">
                                        <div class="p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-2xl shadow-sm p-4 md:p-6 text-center">
                                                <button type="button" style="position:absolute; top:12px; right:12px;" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeAdminModal('approve-modal-{{ $order->id }}')">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Tutup</span>
                                                </button>
                                                <div class="p-4 md:p-5">
                                                    <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-500 mb-4">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">Aktifkan Order?</h3>
                                                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Anda akan mengaktifkan pesanan undangan untuk:<br><strong class="text-gray-700 dark:text-white">{{ $order->content['mempelai']['pria']['nama'] }} & {{ $order->content['mempelai']['wanita']['nama'] }}</strong></p>
                                                    
                                                    <div class="flex items-center justify-center" style="gap:0.75rem;">
                                                        <button onclick="document.getElementById('approve-form-{{ $order->id }}').submit()" type="button" data-testid="admin-approve-confirm" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none dark:focus:ring-blue-800">
                                                            Ya, Aktifkan!
                                                        </button>
                                                        <button onclick="closeAdminModal('approve-modal-{{ $order->id }}')" type="button" class="text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:ring-4 focus:ring-gray-200 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon bg-amber-100 dark:bg-amber-900/20">
                        <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <p class="empty-text">Tidak ada pesanan baru</p>
                    <p class="empty-subtext">Pesanan baru akan muncul di sini</p>
                </div>
                @endif
            </div>

            <!-- Active Clients Section -->
            <div class="dashboard-card">
                <div class="card-header card-header-success">
                    <div class="flex items-center gap-4">
                        <div class="header-icon bg-gradient-to-br from-emerald-500 to-green-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="card-title">Klien Aktif</h3>
                            <p class="card-subtitle">{{ $activeOrders->count() }} akun sudah aktif</p>
                        </div>
                    </div>
                </div>

                @if($activeOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Info Login</th>
                                <th>Detail Klien</th>
                                <th>Status</th>
                                <th class="text-right">Manajemen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeOrders as $client)
                            <tr class="table-row-hover">
                                <td>
                                    @if($client->user)
                                    <div class="email-display">{{ $client->user->email }}</div>
                                    <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 uppercase tracking-wider font-semibold">Username</p>
                                    @else
                                    <span class="error-badge">Error: User Missing</span>
                                    @endif
                                </td>
                                <td>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $client->content['mempelai']['pria']['nama'] }} & {{ $client->content['mempelai']['wanita']['nama'] }}</p>
                                    <a href="{{ url('undangan/'.$client->slug) }}" target="_blank" class="invite-link">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Lihat Undangan
                                    </a>
                                </td>
                                <td>
                                    <span class="status-badge status-active">
                                        <span class="status-dot"></span>
                                        AKTIF
                                    </span>
                                </td>
                                <td class="text-right">
                                    @if($client->user)
                                    <form id="reset-form-{{ $client->user->id }}" action="{{ route('admin.resetPassword', $client->user->id) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn-reset" onclick="openAdminModal('popup-modal-{{ $client->user->id }}')">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                            Reset Password
                                        </button>
                                    </form>

                                    <!-- Flowbite Reset Modal -->
                                    <div id="popup-modal-{{ $client->user->id }}" tabindex="-1" style="display:none;" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[100] w-full h-full bg-black/50 flex justify-center items-center">
                                        <div class="p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white border border-gray-200 dark:border-gray-700 dark:bg-gray-800 rounded-2xl shadow-sm p-4 md:p-6">
                                                <button type="button" style="position:absolute; top:12px; right:12px;" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" onclick="closeAdminModal('popup-modal-{{ $client->user->id }}')">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-red-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                                    <h3 class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">Reset Password Akun?</h3>
                                                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin mereset password untuk akun <br><strong class="text-gray-700 dark:text-white">{{ $client->user->email }}</strong>?</p>
                                                    
                                                    <div class="flex items-center justify-center" style="gap:0.75rem;">
                                                        <button onclick="document.getElementById('reset-form-{{ $client->user->id }}').submit()" type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none dark:focus:ring-red-800">
                                                            Ya, Reset
                                                        </button>
                                                        <button onclick="closeAdminModal('popup-modal-{{ $client->user->id }}')" type="button" class="text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:ring-4 focus:ring-gray-200 shadow-sm font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon bg-emerald-100 dark:bg-emerald-900/20">
                        <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <p class="empty-text">Belum ada klien aktif</p>
                    <p class="empty-subtext">Aktifkan pesanan untuk menambah klien</p>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- New Account Modal -->
    @if(session('new_account'))
    <div class="modal-overlay" id="newAccountModal">
        <div class="modal-content">
            <div class="modal-header-success">
                <div class="modal-icon bg-gradient-to-br from-emerald-400 to-green-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="modal-title">Akun Berhasil Dibuat!</h2>
                <p class="modal-subtitle">Salin detail login sebelum menutup</p>
            </div>

            <div class="credentials-box">
                <div class="credential-row">
                    <span class="credential-label">Email</span>
                    <span class="credential-value select-all">{{ session('new_account')['email'] }}</span>
                </div>
                <div class="credential-row">
                    <span class="credential-label">Password</span>
                    <span class="credential-value credential-password select-all">{{ session('new_account')['password'] }}</span>
                </div>
            </div>

            <div class="wa-template-box">
                <label class="wa-template-label">Template Pesan WhatsApp</label>
                <div class="relative">
                    <textarea id="waMessage" class="wa-textarea" readonly>Halo Kak, undangan sudah aktif! 🎉

Login Dashboard:
🔗 {{ url('/login') }}
📧 {{ session('new_account')['email'] }}
🔑 {{ session('new_account')['password'] }}

Terima kasih!</textarea>
                    <button onclick="copyWAMessage(this)" class="copy-btn">Salin</button>
                </div>
            </div>

            <button onclick="closeModal('newAccountModal')" class="modal-close-btn">
                Selesai & Tutup
            </button>
        </div>
    </div>
    @endif

    <!-- Reset Password Modal -->
    @if(session('reset_success'))
    <div class="modal-overlay" id="resetModal">
        <div class="modal-content">
            <div class="modal-header-warning">
                <div class="modal-icon bg-gradient-to-br from-amber-400 to-orange-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h2 class="modal-title">Password Berhasil Direset!</h2>
            </div>

            <div class="new-password-box">
                <p class="new-password-label">Password Baru</p>
                <p class="new-password-value select-all mb-2">{{ session('reset_success')['password'] }}</p>
                <button onclick="copyResetPassword(this, '{{ session('reset_success')['password'] }}')" class="copy-btn mt-3" style="position: relative; display: inline-flex; align-items: center; justify-content: center; transform: none; right: auto; top: auto; background: white; border: 1px solid #e5e7eb; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; color: #374151; transition: all 0.2s; margin: 0 auto;">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Salin Password
                </button>
            </div>

            <button onclick="closeModal('resetModal')" class="modal-close-btn">Tutup</button>
        </div>
    </div>
    @endif

    <style>
        .admin-wv-dashboard {
            background:
                linear-gradient(var(--dashboard-grid) 1px, transparent 1px),
                linear-gradient(90deg, var(--dashboard-grid) 1px, transparent 1px),
                radial-gradient(circle at 16% 12%, color-mix(in srgb, var(--dashboard-accent) 12%, transparent), transparent 26rem),
                radial-gradient(circle at 84% 20%, color-mix(in srgb, var(--dashboard-danger) 8%, transparent), transparent 24rem),
                var(--dashboard-bg);
            background-size: 48px 48px, 48px 48px, auto, auto, auto;
            color: var(--dashboard-text);
        }
        .admin-wv-dashboard .text-gray-900,
        .admin-wv-dashboard .text-gray-800,
        .admin-wv-dashboard .dark\:text-white,
        .admin-wv-dashboard .dark\:text-neutral-200,
        .admin-wv-dashboard .font-bold {
            color: var(--dashboard-text) !important;
        }
        .admin-wv-dashboard .text-gray-500,
        .admin-wv-dashboard .text-gray-400,
        .admin-wv-dashboard .dark\:text-gray-400,
        .admin-wv-dashboard .dark\:text-gray-500 {
            color: var(--dashboard-muted) !important;
        }
        .admin-wv-dashboard .bg-white,
        .admin-wv-dashboard .dark\:bg-gray-800,
        .admin-wv-dashboard .dark\:bg-gray-700 {
            background: var(--dashboard-surface) !important;
        }
        .admin-wv-dashboard .border,
        .admin-wv-dashboard .dark\:border-gray-700,
        .admin-wv-dashboard .dark\:border-gray-500 {
            border-color: var(--dashboard-border) !important;
        }

        /* Stat Cards */
        .admin-wv-dashboard > div {
            position: relative;
        }
        .admin-wv-dashboard > div::before {
            content: 'ADMIN / LIVE OPS';
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: .75rem;
            padding: .45rem .8rem;
            border-radius: 999px;
            background: color-mix(in srgb, var(--dashboard-surface) 88%, transparent);
            border: 1px solid var(--dashboard-border);
            color: var(--dashboard-accent);
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .14em;
            box-shadow: 0 12px 26px rgba(0, 0, 0, .16);
        }
        .admin-kpi-grid {
            align-items: stretch;
        }
        .stat-card {
            position: relative;
            background: var(--dashboard-surface);
            border-radius: 1.5rem;
            padding: 1.35rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            overflow: hidden;
            border: 1px solid var(--dashboard-border);
            box-shadow: 0 22px 56px rgba(0, 0, 0, 0.24);
            transition: all 0.3s ease;
        }
        .stat-card::before { content: ''; position: absolute; inset: 0 0 auto 0; height: 3px; background: linear-gradient(90deg, var(--dashboard-accent), var(--dashboard-live)); opacity: .85; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 18px 38px color-mix(in srgb, var(--dashboard-accent) 12%, transparent); }
        .dark .stat-card { background: var(--dashboard-surface); border-color: var(--dashboard-border); }
        .stat-icon { width: 3.5rem; height: 3.5rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.2); flex-shrink: 0; }
        .stat-content { flex: 1; }
        .stat-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: var(--dashboard-muted); }
        .dark .stat-label { color: var(--dashboard-muted); }
        .stat-value { font-family: 'JetBrains Mono', ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 2rem; font-weight: 800; line-height: 1.2; color: var(--dashboard-accent) !important; }
        .stat-bg-pattern { position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; border-radius: 50%; background: currentColor; opacity: 0.05; }

        /* Dashboard Card */
        .dashboard-card {
            background: var(--dashboard-surface);
            border-radius: 1.6rem;
            overflow: hidden;
            border: 1px solid var(--dashboard-border);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.24);
        }
        .dark .dashboard-card { background: var(--dashboard-surface); border-color: var(--dashboard-border); }

        .dashboard-card::before { content: ''; display: block; height: 3px; background: linear-gradient(90deg, var(--dashboard-accent), var(--dashboard-live)); opacity: .78; }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            border-bottom: 1px solid var(--dashboard-border);
        }
        .dark .card-header { border-color: var(--dashboard-border); }
        .card-header-warning { background: linear-gradient(to right, color-mix(in srgb, var(--dashboard-danger) 12%, transparent), transparent); }
        .card-header-success { background: linear-gradient(to right, color-mix(in srgb, var(--dashboard-live) 10%, transparent), transparent); }
        .header-icon { width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.2); }
        .card-title { font-size: 1.25rem; font-weight: 700; color: var(--dashboard-text); }
        .dark .card-title { color: white; }
        .card-subtitle { font-size: 0.875rem; color: var(--dashboard-muted); }
        .dark .card-subtitle { color: var(--dashboard-muted); }

        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: .4rem; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge::before { content: ''; width: .45rem; height: .45rem; border-radius: 999px; background: currentColor; box-shadow: 0 0 14px currentColor; }
        .badge-warning { background: #3A1C1C; color: #FF453A; border: 1px solid rgba(255, 69, 58, 0.42); box-shadow: 0 4px 12px -2px rgba(255, 69, 58, 0.2); }
        .id-badge { font-family: monospace; font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.5rem; border-radius: 0.375rem; }
        .id-badge-warning { background: rgba(251, 191, 36, 0.15); color: #b45309; }
        .dark .id-badge-warning { background: rgba(251, 191, 36, 0.2); color: #fcd34d; }
        .theme-badge { background: rgba(0, 229, 255, 0.10); color: #00E5FF; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; border: 1px solid rgba(0, 229, 255, 0.28); }
        .dark .theme-badge { background: rgba(0, 229, 255, 0.10); color: #00E5FF; border-color: rgba(0, 229, 255, 0.28); }
        .status-badge { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
        .status-active { background: rgba(50, 215, 75, 0.14); color: #32D74B; border: 1px solid rgba(50, 215, 75, 0.35); }
        .dark .status-active { background: rgba(50, 215, 75, 0.14); color: #32D74B; border-color: rgba(50, 215, 75, 0.35); }
        .status-dot { width: 0.5rem; height: 0.5rem; background: currentColor; border-radius: 50%; animation: pulse 2s infinite; }
        .error-badge { background: rgba(239, 68, 68, 0.15); color: #dc2626; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; }
        .dark .error-badge { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        /* Table */
        .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .data-table thead { background: var(--dashboard-surface-soft); }
        .dark .data-table thead { background: var(--dashboard-surface-soft); }
        .data-table th { padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: var(--dashboard-muted); }
        .dark .data-table th { color: var(--dashboard-muted); }
        .data-table td { padding: 1.1rem 1.5rem; vertical-align: middle; color: var(--dashboard-text); }
        .data-table tbody tr { border-bottom: 1px solid var(--dashboard-border); }
        .dark .data-table tbody tr { border-color: var(--dashboard-border); }
        .data-table tbody tr:last-child { border-bottom: 0; }
        .table-row-hover { transition: background .2s ease, transform .2s ease; }
        .table-row-hover:hover { background: color-mix(in srgb, var(--dashboard-surface) 86%, var(--dashboard-accent)); }
        .dark .table-row-hover:hover { background: color-mix(in srgb, var(--dashboard-surface) 86%, var(--dashboard-accent)); }

        /* Links */
        .wa-link { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(34, 197, 94, 0.1); color: #16a34a; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; border: 1px solid rgba(34, 197, 94, 0.2); transition: all 0.2s; }
        .wa-link:hover { background: rgba(34, 197, 94, 0.2); transform: translateY(-1px); }
        .dark .wa-link { background: rgba(34, 197, 94, 0.15); color: #4ade80; border-color: rgba(34, 197, 94, 0.3); }
        .invite-link { display: inline-flex; align-items: center; gap: 0.25rem; color: var(--dashboard-accent); font-size: 0.75rem; font-weight: 600; margin-top: 0.25rem; transition: color 0.2s; }
        .invite-link:hover { color: var(--dashboard-accent); text-decoration: underline; }
        .dark .invite-link { color: var(--dashboard-accent); }
        .dark .invite-link:hover { color: var(--dashboard-accent); }
        .email-display { font-family: 'JetBrains Mono', monospace; font-size: 0.875rem; font-weight: 600; background: var(--dashboard-bg); color: var(--dashboard-text); padding: 0.375rem 0.625rem; border-radius: 0.5rem; border: 1px solid var(--dashboard-border); display: inline-block; }
        .dark .email-display { background: var(--dashboard-bg); color: var(--dashboard-text); }

        /* Buttons */
        .btn-activate { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--dashboard-accent); color: var(--dashboard-bg); padding: 0.625rem 1.25rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em; box-shadow: 0 10px 24px color-mix(in srgb, var(--dashboard-accent) 18%, transparent); transition: all 0.2s; }
        .btn-activate:hover { transform: translateY(-2px); background: var(--dashboard-accent); box-shadow: 0 14px 28px color-mix(in srgb, var(--dashboard-accent) 24%, transparent); }
        .btn-reset { display: inline-flex; align-items: center; gap: 0.375rem; background: color-mix(in srgb, var(--dashboard-surface) 86%, var(--dashboard-danger)); color: var(--dashboard-danger); padding: 0.55rem 1rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; border: 1px solid color-mix(in srgb, var(--dashboard-danger) 34%, transparent); transition: all 0.2s; margin-left: auto; }
        .btn-reset:hover { background: rgba(239, 68, 68, 0.1); }
        .dark .btn-reset { background: rgb(55 65 81); color: #f87171; border-color: rgba(239, 68, 68, 0.4); }
        .dark .btn-reset:hover { background: rgba(239, 68, 68, 0.2); }

        .relative.bg-white.border,
        .relative.dark\:bg-gray-800 {
            background: var(--dashboard-surface) !important;
            border-color: var(--dashboard-border) !important;
            box-shadow: 0 26px 68px rgba(0, 0, 0, .28) !important;
        }
        .relative.bg-white.border button[type="button"] {
            border-radius: 999px !important;
        }

        /* Empty State */
        .empty-state { padding: 4rem 2rem; text-align: center; }
        .empty-icon { width: 5rem; height: 5rem; border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .empty-text { font-size: 1rem; font-weight: 600; color: #6b7280; }
        .dark .empty-text { color: #9ca3af; }
        .empty-subtext { font-size: 0.875rem; color: #9ca3af; margin-top: 0.25rem; }
        .dark .empty-subtext { color: #6b7280; }

        /* Modal */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.72); backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; z-index: 50; padding: 1rem; }
        .modal-content { background: var(--dashboard-surface); border: 1px solid var(--dashboard-border); border-radius: 1.6rem; padding: 2rem; max-width: 28rem; width: 100%; box-shadow: 0 28px 72px rgba(0, 0, 0, 0.34); animation: modalIn 0.3s ease; }
        .dark .modal-content { background: rgb(17 24 39); }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.95) translateY(10px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-header-success, .modal-header-warning { text-align: center; margin-bottom: 1.5rem; }
        .modal-icon { width: 4.5rem; height: 4.5rem; border-radius: 1.25rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2); }
        .modal-title { font-size: 1.5rem; font-weight: 800; color: #1f2937; }
        .dark .modal-title { color: white; }
        .modal-subtitle { font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem; }
        .dark .modal-subtitle { color: #9ca3af; }
        .credentials-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem; }
        .dark .credentials-box { background: rgb(31 41 55); border-color: rgb(55 65 81); }
        .credential-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; }
        .credential-row:first-child { border-bottom: 1px solid #e5e7eb; }
        .dark .credential-row:first-child { border-color: rgb(55 65 81); }
        .credential-label { font-size: 0.875rem; font-weight: 600; color: #6b7280; }
        .dark .credential-label { color: #9ca3af; }
        .credential-value { font-family: monospace; font-weight: 700; color: #1f2937; }
        .dark .credential-value { color: white; }
        .credential-password { background: white; padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; color: #dc2626; letter-spacing: 0.1em; }
        .dark .credential-password { background: rgb(55 65 81); border-color: rgb(75 85 99); color: #f87171; }
        .wa-template-box { margin-bottom: 1.5rem; }
        .wa-template-label { display: block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin-bottom: 0.5rem; }
        .dark .wa-template-label { color: #9ca3af; }
        .wa-textarea { width: 100%; height: 8rem; padding: 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; background: #f9fafb; font-size: 0.875rem; color: #374151; resize: none; line-height: 1.5; }
        .dark .wa-textarea { background: rgb(31 41 55); border-color: rgb(55 65 81); color: #d1d5db; }
        .copy-btn { position: absolute; top: 0.5rem; right: 0.5rem; background: white; border: 1px solid #e5e7eb; padding: 0.25rem 0.625rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .copy-btn:hover { color: #6366f1; border-color: #6366f1; }
        .dark .copy-btn { background: rgb(55 65 81); border-color: rgb(75 85 99); color: #d1d5db; }
        .modal-close-btn { width: 100%; background: linear-gradient(to right, #1f2937, #111827); color: white; padding: 1rem; border-radius: 0.75rem; font-weight: 700; transition: all 0.2s; box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.2); }
        .modal-close-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px -4px rgba(0, 0, 0, 0.3); }
        .dark .modal-close-btn { background: linear-gradient(to right, #6366f1, #8b5cf6); }
        .new-password-box { text-align: center; background: rgba(251, 191, 36, 0.1); border: 1px solid rgba(251, 191, 36, 0.3); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; }
        .new-password-label { font-size: 0.875rem; font-weight: 600; color: #b45309; margin-bottom: 0.5rem; }
        .dark .new-password-label { color: #fcd34d; }
        .new-password-value { font-family: monospace; font-size: 1.5rem; font-weight: 800; color: #1f2937; background: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; display: inline-block; letter-spacing: 0.15em; border: 1px solid rgba(251, 191, 36, 0.3); }
        .dark .new-password-value { background: rgb(55 65 81); color: white; border-color: rgba(251, 191, 36, 0.4); }

        @media (max-width: 768px) {
            .admin-wv-dashboard { padding-top: 1rem; }
            .admin-wv-dashboard > div { gap: 1rem; }
            .admin-wv-dashboard > div::before { margin-bottom: 0; }
            .card-header { align-items: flex-start; gap: 1rem; flex-direction: column; padding: 1rem; }
            .stat-card { padding: 1rem; }
            .data-table th,
            .data-table td { padding: .9rem 1rem; }
            .btn-activate,
            .btn-reset { white-space: nowrap; }
        }

        /* Animations */
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    </style>

    <script>
        function closeModal(id) {
            document.getElementById(id).remove();
        }

        function copyWAMessage(btn) {
            navigator.clipboard.writeText(document.getElementById('waMessage').value);
            btn.innerText = 'Disalin!';
            btn.style.color = '#10b981';
            setTimeout(() => { btn.innerText = 'Salin'; btn.style.color = ''; }, 2000);
        }






        function copyResetPassword(btn, text) {
            navigator.clipboard.writeText(text).then(() => {
                const originalHTML = btn.innerHTML;
                btn.innerText = 'Tersalin!';
                btn.style.background = '#10b981';
                btn.style.color = 'white';
                btn.style.borderColor = 'transparent';
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.style.background = 'white';
                    btn.style.color = '#374151';
                    btn.style.borderColor = '#e5e7eb';
                }, 2000);
            });
        }
        function openAdminModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }
        function closeAdminModal(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
    </script>
</x-app-layout>