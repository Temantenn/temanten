<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 via-rose-500 to-red-500 rounded-2xl flex items-center justify-center shadow-xl shadow-pink-500/30 rotate-3 hover:rotate-0 transition-transform">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Manajemen Admin
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-0.5">
                        Kelola akun dan hak akses administrator sistem
                    </p>
                </div>
            </div>
            <button onclick="document.getElementById('addAdminModal').classList.remove('hidden')" 
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-pink-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Admin Baru
            </button>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <x-alert-success :message="session('success')" />
            @endif

            <div class="dashboard-card">
                <div class="card-header card-header-info">
                    <div class="flex items-center gap-4">
                        <div class="header-icon bg-gradient-to-br from-blue-500 to-cyan-500">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="card-title">Daftar Admin Aktif</h3>
                            <p class="card-subtitle">Total {{ $admins->total() }} administrator terdaftar</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Administrator</th>
                                <th>Role</th>
                                <th>Bergabung Pada</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr class="table-row-hover">
                                <td>
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 flex flex-shrink-0 items-center justify-center text-gray-800 dark:text-gray-200 font-bold text-lg shadow-sm">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ $admin->name }}</p>
                                            <p class="text-xs font-mono text-gray-500 dark:text-gray-400 mt-1">{{ $admin->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge bg-pink-100 text-pink-700 border-pink-200 dark:bg-pink-900/30 dark:text-pink-400 dark:border-pink-800/50">
                                        SUPER ADMIN
                                    </span>
                                </td>
                                <td>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $admin->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $admin->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="text-right">
                                    @if($admin->id !== auth()->id())
                                    <form action="{{ route('admin.destroyAdmin', $admin->id) }}" method="POST" class="inline" onsubmit="konfirmasiHapus(event, '{{ $admin->name }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Hapus Permanen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
                                        Sedang Login
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($admins->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/50">
                        {{ $admins->links('vendor.pagination.admin-tailwind') }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>

    <!-- Modal Tambah Admin -->
    <div id="addAdminModal" class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full overflow-hidden transform transition-all border border-gray-100 dark:border-gray-700">
            <div class="bg-gradient-to-r from-pink-600 to-rose-600 p-6 text-white flex justify-between items-center">
                <h3 class="font-bold text-xl">Tambah Admin Baru</h3>
                <button onclick="document.getElementById('addAdminModal').classList.add('hidden')" class="text-white/80 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ route('admin.storeAdmin') }}" method="POST">
                @csrf
                <div class="p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Lengkapi form di bawah ini untuk menambahkan akun administrator baru ke dalam sistem.</p>
                    
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="name">Nama Lengkap</label>
                            <input id="name" name="name" type="text" required class="block w-full px-4 py-2.5 mt-1.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-900/50 dark:text-gray-300 dark:border-gray-600 focus:bg-white focus:border-pink-400 focus:ring-pink-300 focus:ring-opacity-40 dark:focus:border-pink-300 focus:outline-none focus:ring transition-all duration-200">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="emailAddress">Email Address <span class="text-xs font-normal text-gray-500 dark:text-gray-500">(digunakan untuk login)</span></label>
                            <input id="emailAddress" name="email" type="email" required class="block w-full px-4 py-2.5 mt-1.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-900/50 dark:text-gray-300 dark:border-gray-600 focus:bg-white focus:border-pink-400 focus:ring-pink-300 focus:ring-opacity-40 dark:focus:border-pink-300 focus:outline-none focus:ring transition-all duration-200">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="password">Password</label>
                            <input id="password" name="password" type="password" required class="block w-full px-4 py-2.5 mt-1.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-900/50 dark:text-gray-300 dark:border-gray-600 focus:bg-white focus:border-pink-400 focus:ring-pink-300 focus:ring-opacity-40 dark:focus:border-pink-300 focus:outline-none focus:ring transition-all duration-200">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200" for="passwordConfirmation">Konfirmasi Password</label>
                            <input id="passwordConfirmation" name="password_confirmation" type="password" required class="block w-full px-4 py-2.5 mt-1.5 text-gray-700 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-900/50 dark:text-gray-300 dark:border-gray-600 focus:bg-white focus:border-pink-400 focus:ring-pink-300 focus:ring-opacity-40 dark:focus:border-pink-300 focus:outline-none focus:ring transition-all duration-200">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end px-6 py-4 bg-gray-50/80 dark:bg-gray-800/80 border-t border-gray-100 dark:border-gray-700 gap-3">
                    <button type="button" onclick="document.getElementById('addAdminModal').classList.add('hidden')" class="px-6 py-2.5 text-sm font-bold leading-5 text-gray-700 transition-colors duration-300 transform bg-white border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">Batal</button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold leading-5 text-white transition-colors duration-300 transform bg-gradient-to-r from-pink-600 to-rose-600 rounded-lg hover:from-pink-700 hover:to-rose-700 shadow-md shadow-pink-500/30 focus:outline-none focus:ring focus:ring-pink-300 focus:ring-opacity-80 flex items-center gap-2">
                        Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>


    <style>
        .dashboard-card { background: white; border-radius: 1.5rem; overflow: hidden; border: 1px solid rgba(229, 231, 235, 0.5); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .dark .dashboard-card { background: rgb(17 24 39); border-color: rgba(55, 65, 81, 0.5); }
        .card-header { display: flex; align-items: center; justify-content: space-between; padding: 1.5rem; border-bottom: 1px solid rgba(229, 231, 235, 0.5); }
        .card-header-info { background: linear-gradient(to right, rgba(59, 130, 246, 0.08), transparent); }
        .dark .card-header { border-color: rgba(55, 65, 81, 0.5); }
        .header-icon { width: 3rem; height: 3rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.2); }
        .card-title { font-size: 1.25rem; font-weight: 700; color: #1f2937; }
        .dark .card-title { color: white; }
        .card-subtitle { font-size: 0.875rem; color: #6b7280; }
        .dark .card-subtitle { color: #9ca3af; }

        .data-table { width: 100%; }
        .data-table thead { background: #f9fafb; }
        .dark .data-table thead { background: rgb(31 41 55); }
        .data-table th { padding: 1rem 1.5rem; text-align: left; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; }
        .data-table td { padding: 1rem 1.5rem; vertical-align: middle; }
        .data-table tbody tr { border-bottom: 1px solid #f3f4f6; }
        .dark .data-table tbody tr { border-color: rgb(55 65 81); }
        .table-row-hover:hover { background: rgba(236, 72, 153, 0.04); }
        
        .status-badge { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.05em; border: 1px solid transparent; }
        
        .btn-delete { display: inline-flex; align-items: center; gap: 0.375rem; background: rgba(239, 68, 68, 0.1); color: #dc2626; padding: 0.5rem 1rem; border-radius: 0.625rem; font-size: 0.75rem; font-weight: 600; border: 1px solid rgba(239, 68, 68, 0.2); transition: all 0.2s; }
        .btn-delete:hover { background: rgba(239, 68, 68, 0.2); border-color: rgba(239, 68, 68, 0.4); }
    </style>

    <script>

        
        @if(session('error'))
        Swal.fire({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
            icon: 'error', title: '{{ session("error") }}'
        });
        @endif

        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan!',
            text: '{{ $errors->first() }}',
            confirmButtonColor: '#e11d48'
        });
        @endif

        function konfirmasiHapus(event, nama) {
            event.preventDefault();
            Swal.fire({
                title: 'Hapus Super Admin?',
                html: "Aksi ini tidak bisa dibatalkan.<br>Admin <b>" + nama + "</b> akan kehilangan seluruh akses sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Hapus Permanen',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
</x-app-layout>
