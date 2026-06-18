import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('orderForm', () => ({
    step: 1,
    total: 0,
    form: {
        themeId: null,
        themeName: '',
        whatsapp: '',
        slug: '',
        groom: '',
        bride: '',
        date: '',
    },
    errors: {},

    init() {
        const root = this.$root;
        const get = (k) => root.dataset[k] ?? null;
        const num = (v) => (v === null || v === '' || v === 'null') ? null : Number(v);
        const str = (v) => (v === null || v === 'null') ? '' : String(v);

        this.total = num(get('total')) ?? 0;
        this.form.themeId = num(get('themeId'));
        this.form.themeName = str(get('themeName'));
        this.form.whatsapp = str(get('whatsapp')).replace(/^0/, '');
        this.form.slug = str(get('slug'));
        this.form.groom = str(get('groom'));
        this.form.bride = str(get('bride'));
        this.form.date = str(get('date'));

        if (this.form.themeId) {
            const radio = document.querySelector(`input[name="theme_id"][value="${this.form.themeId}"]`);
            if (radio) radio.checked = true;
        }

        this.$watch('form.themeId', () => this.syncThemeSelection());
        this.syncThemeSelection();
    },

    syncThemeSelection() {
        document.querySelectorAll('.theme-card-label').forEach(lbl => lbl.classList.remove('selected'));
        if (this.form.themeId) {
            const radio = document.querySelector(`input[name="theme_id"][value="${this.form.themeId}"]`);
            if (radio) {
                const label = document.querySelector(`label[for="${radio.id}"]`);
                if (label) label.classList.add('selected');
            }
        }
    },

    selectTheme(id, price, name) {
        this.form.themeId = id;
        this.form.themeName = name;
        this.total = price;
        this.clearError('theme');
    },

    sanitizeSlug() {
        this.form.slug = (this.form.slug || '')
            .toLowerCase()
            .replace(/[^a-z0-9-]/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    },

    clearError(field) {
        if (this.errors[field]) delete this.errors[field];
    },

    formatRupiah(n) {
        if (!n) return 'Rp 0';
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    },

    get canProceed() {
        if (this.step === 1) return !!this.form.themeId;
        if (this.step === 2) return !!this.form.whatsapp && this.form.whatsapp.length >= 8 && !!this.form.slug && this.form.slug.length >= 3;
        if (this.step === 3) return !!this.form.groom && !!this.form.bride && !!this.form.date;
        return true;
    },

    validateStep() {
        this.errors = {};
        if (this.step === 1 && !this.form.themeId) {
            this.errors.theme = 'Pilih tema undangan terlebih dahulu';
            return false;
        }
        if (this.step === 2) {
            if (!this.form.whatsapp || this.form.whatsapp.length < 8) {
                this.errors.whatsapp = 'Nomor WhatsApp minimal 8 digit';
                return false;
            }
            if (!this.form.slug || this.form.slug.length < 3) {
                this.errors.slug = 'Link undangan minimal 3 karakter';
                return false;
            }
            if (!/^[a-z0-9-]+$/.test(this.form.slug)) {
                this.errors.slug = 'Hanya huruf kecil, angka, dan tanda strip (-)';
                return false;
            }
        }
        if (this.step === 3) {
            if (!this.form.groom) { this.errors.groom = 'Nama pengantin pria belum diisi'; return false; }
            if (!this.form.bride) { this.errors.bride = 'Nama pengantin wanita belum diisi'; return false; }
            if (!this.form.date) { this.errors.date = 'Tanggal acara belum diisi'; return false; }
        }
        return true;
    },

    nextStep() {
        if (!this.validateStep()) return;
        if (this.step < 4) this.step++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    prevStep() {
        if (this.step > 1) this.step--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    goToStep(target) {
        // Only allow going back, or forward to next if current is valid
        if (target < this.step) { this.step = target; return; }
        if (target === this.step + 1 && this.validateStep()) {
            this.step = target;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    submitForm(event) {
        if (!this.validateStep()) { event.preventDefault(); return; }
        // Show loading
        const btn = document.getElementById('btnSubmit');
        const overlay = document.getElementById('loadingOverlay');
        if (btn) btn.disabled = true;
        if (overlay) overlay.classList.remove('hidden');
    },
}));

Alpine.start();
