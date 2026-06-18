{{-- Static theme toggle pill (no fixed positioning) --}}
<div x-data="themeToggle()" x-init="init()">

    <button @click="toggle()"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
            :aria-pressed="darkMode.toString()"
            aria-label="Toggle tema gelap/terang"
            class="theme-btn"
            :class="[darkMode ? 'is-dark' : 'is-light', hover ? 'is-hover' : '']">

        <span class="theme-btn-track" :class="darkMode ? 'on-right' : 'on-left'"></span>

        <span class="theme-icon icon-sun" :class="darkMode ? 'icon-out' : 'icon-in'">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4"/>
                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
            </svg>
        </span>

        <span class="theme-icon icon-moon" :class="darkMode ? 'icon-in' : 'icon-out'">
            <svg viewBox="0 0 24 24" fill="currentColor" stroke="none">
                <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </span>
    </button>

    <style>
        .theme-btn {
            position: relative;
            width: 50px;
            height: 26px;
            border-radius: 999px;
            border: 1px solid var(--dashboard-border);
            background: var(--dashboard-surface);
            cursor: pointer;
            transition: background 0.4s ease, border-color 0.4s ease, transform 0.15s ease;
            overflow: hidden;
            flex-shrink: 0;
        }
        .theme-btn.is-dark {
            background: #1a1d23;
            border-color: rgba(255,255,255,0.1);
        }
        .theme-btn.is-hover { transform: translateY(-1px); }
        .theme-btn:active { transform: scale(0.97); }

        .theme-btn-track {
            position: absolute;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--dashboard-accent);
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1), background 0.4s ease;
        }
        .theme-btn-track.on-left  { left: 3px;  background: #fbbf24; }
        .theme-btn-track.on-right { left: 26px; background: #6366f1; }

        .theme-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: inline-flex;
            width: 14px;
            height: 14px;
            transition: opacity 0.3s ease, transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }
        .theme-icon svg { width: 100%; height: 100%; }
        .icon-sun  { left: 6px;  color: #f59e0b; }
        .icon-moon { right: 6px; color: #c7d2fe; }

        .icon-in {
            opacity: 1;
            transform: translateY(-50%) rotate(0deg) scale(1);
        }
        .icon-out {
            opacity: 0;
            transform: translateY(-50%) rotate(90deg) scale(0.5);
        }
    </style>
</div>

<script>
    function themeToggle() {
        return {
            darkMode: false,
            hover: false,
            init() {
                this.darkMode = localStorage.getItem('theme') === 'dark'
                    || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
                this.apply();
            },
            apply() {
                document.documentElement.classList.toggle('dark', this.darkMode);
            },
            toggle() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                this.apply();
            }
        }
    }
</script>
