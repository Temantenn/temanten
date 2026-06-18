<nav x-data="{ open: false }" class="nav-container">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo & Nav Links -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="nav-logo group">
                    <div class="logo-icon" style="overflow: hidden; padding: 0; background: transparent;">
                        <img src="{{ asset('assets/mini-logo.webp') }}" alt="Logo Temanten" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <span class="logo-text">Temanten</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.admins') }}" class="nav-link {{ request()->routeIs('admin.admins') ? 'nav-link-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Kelola Admin
                        </a>
                    @else
                        <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'nav-link-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('client.settings') }}" class="nav-link {{ request()->routeIs('client.settings') ? 'nav-link-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Undangan
                        </a>
                    @endif
                </div>
            </div>

            <!-- User Info & Actions -->
            <div class="hidden sm:flex sm:items-center gap-4">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role {{ Auth::user()->role === 'admin' ? 'role-admin' : 'role-client' }}">
                            {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Client' }}
                        </span>
                    </div>
                </div>

                <div class="nav-divider"></div>

                <x-theme-toggle />

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" data-testid="logout-button" class="logout-btn group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="hidden lg:inline">Keluar</span>
                    </button>
                </form>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="mobile-menu-btn">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden mobile-menu">
        <div class="mobile-menu-header">
            <div class="mobile-user-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="mobile-user-name">{{ Auth::user()->name }}</p>
                <p class="mobile-user-email">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <div class="mobile-nav-links">
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('admin.dashboard') ? 'mobile-nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    Dashboard Admin
                </a>
                <a href="{{ route('admin.admins') }}" class="mobile-nav-link {{ request()->routeIs('admin.admins') ? 'mobile-nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Kelola Admin
                </a>
            @else
                <a href="{{ route('client.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('client.dashboard') ? 'mobile-nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('client.settings') }}" class="mobile-nav-link {{ request()->routeIs('client.settings') ? 'mobile-nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Undangan
                </a>
            @endif
        </div>

        <div class="mobile-logout">
            <div class="mobile-theme-row">
                <span class="mobile-theme-label">Tema</span>
                <x-theme-toggle />
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" data-testid="logout-button" class="mobile-logout-btn">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <style>
        .nav-container {
            background: color-mix(in srgb, var(--dashboard-bg) 94%, transparent);
            border-bottom: 1px solid var(--dashboard-border);
            box-shadow: 0 18px 34px rgba(0, 0, 0, 0.14);
            position: sticky;
            top: 0;
            z-index: 40;
            backdrop-filter: blur(16px);
        }
        .dark .nav-container {
            background: color-mix(in srgb, var(--dashboard-bg) 94%, transparent);
            border-color: var(--dashboard-border);
        }

        /* Logo */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }
        .logo-icon {
            width: 2.25rem;
            height: 2.25rem;
            background: linear-gradient(135deg, #ec4899, #8b5cf6);
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px -2px rgba(236, 72, 153, 0.4);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .nav-logo:hover .logo-icon {
            transform: scale(1.05) rotate(-3deg);
            box-shadow: 0 6px 16px -2px rgba(236, 72, 153, 0.5);
        }
        .logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--dashboard-text);
            letter-spacing: -0.03em;
        }
        .logo-text::after {
            content: ' / LIVE';
            color: var(--dashboard-accent);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            margin-left: 0.35rem;
        }

        /* Nav Links */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dashboard-muted);
            border-radius: 0.625rem;
            border: 1px solid transparent;
            transition: all 0.2s;
            text-decoration: none;
        }
        .nav-link:hover {
            color: var(--dashboard-text);
            background: color-mix(in srgb, var(--dashboard-accent) 8%, transparent);
            border-color: color-mix(in srgb, var(--dashboard-accent) 18%, transparent);
        }
        .dark .nav-link { color: var(--dashboard-muted); }
        .dark .nav-link:hover { color: var(--dashboard-text); background: color-mix(in srgb, var(--dashboard-accent) 8%, transparent); }
        .nav-link-active {
            color: var(--dashboard-accent) !important;
            background: color-mix(in srgb, var(--dashboard-accent) 12%, transparent);
            border-color: color-mix(in srgb, var(--dashboard-accent) 28%, transparent);
            box-shadow: 0 0 20px color-mix(in srgb, var(--dashboard-accent) 8%, transparent);
        }
        .dark .nav-link-active {
            color: var(--dashboard-accent) !important;
            background: color-mix(in srgb, var(--dashboard-accent) 12%, transparent);
        }

        /* User Info */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .user-avatar {
            width: 2.25rem;
            height: 2.25rem;
            background: linear-gradient(135deg, var(--dashboard-accent), var(--dashboard-live));
            border-radius: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            box-shadow: 0 2px 8px -2px rgba(99, 102, 241, 0.4);
        }
        .user-details {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        .user-name {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--dashboard-text);
        }
        .dark .user-name { color: white; }
        .user-role {
            font-size: 0.625rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
        }
        .role-admin {
            background: color-mix(in srgb, var(--dashboard-danger) 14%, transparent);
            color: var(--dashboard-danger);
        }
        .dark .role-admin {
            background: rgba(255, 69, 58, 0.18);
            color: #FF453A;
        }
        .role-client {
            background: color-mix(in srgb, var(--dashboard-live) 14%, transparent);
            color: var(--dashboard-live);
        }
        .dark .role-client {
            background: rgba(50, 215, 75, 0.18);
            color: #32D74B;
        }

        .nav-divider {
            width: 1px;
            height: 2rem;
            background: var(--dashboard-border);
        }
        .dark .nav-divider { background: var(--dashboard-border); }

        /* Logout Button */
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ef4444;
            border-radius: 0.625rem;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
        }
        .dark .logout-btn { color: #f87171; }
        .dark .logout-btn:hover { background: rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.3); }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            padding: 0.5rem;
            border-radius: 0.625rem;
            color: #98989D;
            transition: all 0.2s;
        }
        .mobile-menu-btn:hover {
            background: rgba(0, 229, 255, 0.08);
            color: #00E5FF;
        }
        .dark .mobile-menu-btn { color: #98989D; }
        .dark .mobile-menu-btn:hover { background: rgba(0, 229, 255, 0.08); color: #00E5FF; }

        /* Mobile Menu */
        .mobile-menu {
            background: #1E1E1E;
            border-top: 1px solid #2C2C2E;
            animation: slideDown 0.2s ease;
        }
        .dark .mobile-menu { background: #1E1E1E; border-color: #2C2C2E; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .mobile-menu-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: linear-gradient(to right, rgba(0, 229, 255, 0.08), transparent);
            border-bottom: 1px solid #2C2C2E;
        }
        .dark .mobile-menu-header { border-color: #2C2C2E; background: linear-gradient(to right, rgba(0, 229, 255, 0.08), transparent); }
        .mobile-user-avatar {
            width: 2.75rem;
            height: 2.75rem;
            background: linear-gradient(135deg, #00E5FF, #32D74B);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }
        .mobile-user-name {
            font-weight: 700;
            color: #FFFFFF;
        }
        .dark .mobile-user-name { color: white; }
        .mobile-user-email {
            font-size: 0.75rem;
            color: #6b7280;
        }
        .dark .mobile-user-email { color: #9ca3af; }

        .mobile-nav-links {
            padding: 0.5rem;
        }
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #98989D;
            border-radius: 0.625rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .mobile-nav-link:hover { background: rgba(0, 229, 255, 0.08); color: #FFFFFF; }
        .dark .mobile-nav-link { color: #98989D; }
        .dark .mobile-nav-link:hover { background: rgba(0, 229, 255, 0.08); }
        .mobile-nav-active {
            background: rgba(0, 229, 255, 0.12) !important;
            color: #00E5FF !important;
        }
        .dark .mobile-nav-active {
            background: rgba(0, 229, 255, 0.12) !important;
            color: #00E5FF !important;
        }

        .mobile-logout {
            padding: 0.5rem;
            border-top: 1px solid #2C2C2E;
        }
        .dark .mobile-logout { border-color: #2C2C2E; }
        .mobile-logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #ef4444;
            border-radius: 0.625rem;
            transition: all 0.2s;
        }
        .mobile-logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }
        .dark .mobile-logout-btn { color: #f87171; }
        .dark .mobile-logout-btn:hover { background: rgba(239, 68, 68, 0.15); }

        .mobile-theme-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.625rem;
            background: color-mix(in srgb, var(--dashboard-accent) 6%, transparent);
        }
        .mobile-theme-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dashboard-muted);
        }
    </style>
</nav>