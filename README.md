# Temanten

Platform undangan pernikahan digital berbasis web — elegan, responsif, dan mudah dikustomisasi.

Dibangun dengan Laravel 12, Blade, Vite, Tailwind CSS, Alpine.js, Flowbite, dan MySQL.

---

## Overview

Temanten adalah aplikasi Laravel yang menyediakan layanan undangan pernikahan digital dengan katalog tema, alur pemesanan, dashboard klien untuk mengelola konten undangan, dan dashboard admin untuk approval serta manajemen harga. Tamu dapat membuka undangan publik, mengirim RSVP, dan mengirim ucapan/doa.

Target pengguna:

- **Guest** — membuat pesanan, membuka undangan, mengirim RSVP/ucapan
- **Client** — mengelola konten undangannya sendiri (data pengantin, acara, galeri, QRIS, musik)
- **Admin** — menyetujui pesanan, mengatur harga tema, mengelola thumbnail, dan reset password klien

---

## Tech Stack

- **Backend:** Laravel 12, PHP ^8.2
- **Frontend:** Blade, Vite 7, Tailwind CSS 3, Alpine.js 3, Flowbite 4
- **Database:** MySQL / MariaDB
- **Auth:** Laravel Breeze
- **Image processing:** Intervention Image 3 + Sharp
- **Excel import/export:** Maatwebsite Excel 3
- **QR Code:** simplesoftwareio/simple-qrcode
- **E2E testing:** Playwright 1.60
- **Unit/Feature testing:** Pest 3

---

## Fitur Utama

### Katalog 16 Tema

| # | Tema | Konsep singkat |
|---|------|----------------|
| 1 | barakah-love | Islami lembut |
| 2 | boho-terracotta | Bohemian hangat |
| 3 | celestial-night | Elegan malam berbintang |
| 4 | cherry-blossom | Romantis bunga sakura |
| 5 | emerald-garden | Hijau emerald & emas |
| 6 | floral-pastel | Bunga pastel lembut |
| 7 | golden-sunrise | Hangat keemasan |
| 8 | jawa-keraton | Tradisional Jawa |
| 9 | midnight-garden | Garden malam gelap |
| 10 | ocean-breeze | Segar biru laut |
| 11 | pixel-adventure | Retro pixel game |
| 12 | royal-glass | Glassmorphism mewah |
| 13 | rustic-green | Natural kayu & daun |
| 14 | sekar-jagad | Jawa klasik floral |
| 15 | sunda-asih | Sunda lembut |
| 16 | watercolor-flow | Artistik cat air |

### Pemesanan & Alur Utama

1. Guest membuka landing & katalog tema
2. Guest mengisi form pemesanan (`/buat-undangan`)
3. Order masuk dengan status **pending**
4. Admin menyetujui order di dashboard
5. Client login dan melengkapi data undangan di settings
6. Guest membuka undangan publik (`/undangan/{slug}`)
7. Guest mengirim RSVP atau ucapan/doa

### Dashboard Admin

- Daftar & approval order
- Reset password klien (modal Flowbite + tombol salin)
- Manajemen harga per tema (harga dasar & promo)
- Manajemen thumbnail tema (upload/update WebP) — `Admin\ThemeController`
- Upload musik default per tema
- Manajemen akun admin tambahan

### Dashboard Client

- Statistik RSVP real-time (total, hadir, tidak hadir, pending)
- Edit konten undangan: data pengantin, acara, lokasi, Maps, musik
- Upload foto galeri dengan kompresi otomatis ke WebP (client-side, max ~2500px @ 85% quality)
- Hapus foto galeri individual
- Upload QRIS untuk amplop digital
- Manajemen tamu: tambah, hapus, search, filter, import Excel/CSV, export, template siap pakai
- Integrasi dropdown wilayah Indonesia (Provinsi → Kabupaten → Kecamatan → Kelurahan)

### Halaman Publik

- Landing page + katalog tema dengan live preview
- Undangan publik per slug
- Form RSVP
- Form ucapan/doa
- Bagian gift/QRIS (jika diaktifkan klien)
- Google Maps link
- Musik tema

### Keamanan

- Signed URL untuk akses gambar via route `/storage/invitations/{uuid}/{filename}` (middleware `signed` + throttle)
- Validasi path traversal pada filename
- Middleware `admin` untuk route admin
- Policy `InvitationPolicy` dan `GuestPolicy` untuk authorization
- Rate limit pada form publik (ucapan, RSVP, wilayah API)
- CSRF protection default Laravel

---

## Requirements

- PHP ^8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Laragon (direkomendasikan untuk Windows) atau server lokal apapun

---

## Installation

```bash
# 1. Clone
git clone https://github.com/Temantenn/temanten.git
cd temanten

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=temanten
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Migrasi + seeder
php artisan migrate --seed

# 6. Storage link
php artisan storage:link

# 7. Build assets
npm run build
```

Akses default Laragon: **http://temanten.test**

---

## Local Development

```bash
# Terminal 1: Vite dev server
npm run dev

# Terminal 2: Laravel server
php artisan serve
```

Atau gunakan script composer:

```bash
composer dev
```

Script ini menjalankan concurrently: `php artisan serve`, `php artisan queue:listen`, dan `npm run dev`.

---

## Demo Account

Dari `.env.example`:

```txt
Admin:
  Email:    admin@temanten.test
  Password: temanten123
```

Akun klien dibuat otomatis ketika admin menyetujui order. Akun tamu tidak perlu login untuk mengirim RSVP/ucapan.

`PUBLIC_REGISTRATION_ENABLED=false` — registrasi publik ditutup; alur pemesanan adalah jalur masuk klien.

---

## User Roles

### Guest

- Melihat landing & katalog tema
- Membuat pesanan baru
- Membuka undangan publik via link/slug
- Mengirim RSVP
- Mengirim ucapan/doa

### Client

- Login ke `/dashboard` (auto-redirect ke `/client/dashboard`)
- Melihat statistik RSVP
- Edit data undangan (settings)
- Upload & hapus galeri
- Upload QRIS
- Manajemen tamu (CRUD, import/export)
- Edit musik tema

### Admin

- Login ke `/dashboard` (auto-redirect ke `/admin/dashboard`)
- Approve order pending
- Reset password klien
- Set harga & promo per tema
- Upload thumbnail & musik default per tema
- Tambah/hapus admin lain

---

## Routes Utama

### Publik

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/` | Landing page |
| GET | `/themes` | Katalog tema |
| GET | `/themes/{slug}` | Detail tema |
| GET | `/buat-undangan` | Form pemesanan |
| POST | `/buat-undangan` | Submit pesanan (throttle 5/menit) |
| GET | `/pembayaran` | Halaman pembayaran |
| GET | `/order-success/{order_number}` | Konfirmasi order |
| GET | `/demo/{theme}` | Demo tema |
| GET | `/undangan/{slug}` | Undangan publik |
| POST | `/kirim-ucapan` | Kirim ucapan (throttle 10/menit) |
| GET | `/undangan/{slug}/ucapan` | List ucapan |
| POST | `/undangan/{slug}/ucapan` | Submit ucapan |
| POST | `/rsvp/{id}` | Submit RSVP |
| GET | `/storage/invitations/{uuid}/{filename}` | Gambar signed |

### API Wilayah

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/api/wilayah/provinces` | List provinsi |
| GET | `/api/wilayah/regencies/{province_id}` | List kabupaten |
| GET | `/api/wilayah/districts/{regency_id}` | List kecamatan |
| GET | `/api/wilayah/villages/{district_id}` | List kelurahan |

### Admin (middleware `auth` + `admin`)

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/admin/dashboard` | Dashboard admin |
| POST | `/admin/approve/{id}` | Approve order |
| POST | `/admin/reset-password/{user_id}` | Reset password klien |
| GET | `/admin/themes-pricing` | Kelola harga tema |
| POST | `/admin/themes/{id}/price` | Update harga tema |
| POST | `/admin/themes/default-price` | Update harga default |
| GET/POST | `/admin/themes` | Manajemen thumbnail & musik |
| GET/POST/DELETE | `/admin/admins` | Manajemen admin |

### Client (middleware `auth`)

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | `/client/dashboard` | Dashboard klien |
| GET | `/client/settings` | Form edit undangan |
| PUT | `/client/settings` | Update undangan |
| POST | `/client/import-guests` | Import Excel/CSV tamu |
| GET | `/client/download-template` | Template Excel |
| GET | `/client/export-guests/{invitation}` | Export tamu |
| POST | `/client/store-guest` | Tambah tamu |
| DELETE | `/client/delete-guest/{guest}` | Hapus tamu |

---

## Konvensi Aset

| Tipe | Path | Format |
|------|------|--------|
| Thumbnail tema | `public/assets/thumbnail/{slug}.webp` | WebP |
| Musik default tema | `public/assets/music/{slug}.mp3` | MP3 |
| Aset publik (logo, frame, bg) | `public/assets/*` | WebP |
| QRIS | `public/img/qris.webp` | WebP |
| Upload klien | `storage/app/public/invitations/{uuid}/` | WebP (auto-compress) |

Konversi thumbnail ke WebP: jalankan `node convert-to-webp.cjs` setelah menambah aset baru.

---

## Testing

```bash
# Test Laravel (Pest)
php artisan test

# E2E Playwright (headed)
npx playwright test --headed
```

Cakupan test yang ada di `tests/Feature/`:

- `AuthenticationTest` & `RegistrationTest` — auth flow
- `PublicUcapanTest` — submit ucapan publik
- `ClientAuthorizationTest` — klien tidak bisa edit invitation milik klien lain
- `DemoRouteTest` — halaman demo tema

Test E2E: `tests/e2e/guest-order-flow.spec.js`

---

## Struktur Proyek

```
app/
├── Http/Controllers/
│   ├── AdminController.php          # Approval, reset password, pricing
│   ├── Admin/ThemeController.php    # Thumbnail & default music CRUD
│   ├── ClientController.php         # Dashboard, settings, guest CRUD
│   ├── InvitationController.php     # Publik, demo, RSVP, ucapan
│   ├── OrderController.php          # Alur pemesanan
│   ├── ThemeController.php          # Katalog publik
│   ├── WilayahController.php        # Proxy API wilayah Indonesia
│   └── Auth/                        # Breeze auth
├── Models/                          # User, Order, Invitation, Guest, Theme
├── Policies/                        # InvitationPolicy, GuestPolicy
├── Services/                        # OrderService, InvitationService, QrisService
└── Support/WhatsAppNumber.php
database/
├── migrations/                      # Termasuk 4 migrasi tambahan (soft deletes, unique code, theme desc, default music)
└── seeders/ThemeSeeder.php
resources/views/
├── admin/                           # Dashboard, themes
├── client/                          # Dashboard, settings
├── order/                           # Form, payment, success
├── themes/                          # 16 tema + catalog.blade.php
├── auth/                            # Breeze views
├── landing.blade.php
└── layouts/
routes/
└── web.php
public/
├── assets/                          # thumbnail, music, logo, frame, bg
└── img/                             # QRIS
tests/
├── Feature/                         # Pest feature tests
└── e2e/                             # Playwright specs
docs/                                # Audit & handover docs
```

---

## Useful Commands

```bash
# Inspect semua route
php artisan route:list

# Clear cache saat perubahan config/view
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# Storage link (wajib setelah install)
php artisan storage:link

# Konversi aset ke WebP
node convert-to-webp.cjs

# Build production
npm run build
```

---

## Deployment Notes

Prasyarat production:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` ter-set (`php artisan key:generate`)
- Database terkonfigurasi
- `storage/` dan `bootstrap/cache/` writable
- `php artisan storage:link` dijalankan
- HTTPS aktif (untuk signed URL)

Perintah deploy standar:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Risiko yang perlu dicek manual:

- Shared hosting: upload `post_max_size` & `upload_max_filesize` cukup besar — kompresi WebP di sisi klien sudah mengurangi risiko `PostTooLargeException`
- Queue: `QUEUE_CONNECTION=sync` di `.env.example` — worker queue belum dikonfigurasi
- Mail: masih default SMTP `localhost:1025` (umumnya MailHog/Mailpit untuk dev) — perlu dikonfigurasi ulang untuk production

---

## Known Limitations

- Tidak ada payment gateway nyata — halaman `/pembayaran` adalah halaman info, integrasi payment belum diimplementasikan
- Email belum terkoneksi ke provider production
- Tidak ada queue worker background — semua proses sync
- Search/filter UI di daftar tamu masih basic (perlu pagination & sort konsisten di mobile)
- Beberapa tema masih dalam tahap polish animasi dan kontras mobile
- Tidak ada backup/restore database otomatis
- Tidak ada storage S3 — hanya `public` disk lokal

---

## Roadmap

- Integrasi payment gateway (Midtrans/Xendit) untuk order
- Halaman settings klien yang lebih modular (split per section)
- Notifikasi WhatsApp real untuk order & ucapan
- Optimasi gambar otomatis (lazy loading + responsive srcset)
- Multi-bahasa (ID/EN)
- Tema editor (warna & font override) tanpa edit kode
- E2E coverage lebih luas (admin approval, client settings, mobile viewport)
- Backup terjadwal ke cloud storage

---

## Troubleshooting

- **500 error setelah pull** → jalankan `composer install`, cek `.env`, jalankan `php artisan migrate`
- **Aset Vite tidak load** → `npm install` lalu `npm run build` (atau `npm run dev` untuk dev)
- **Gambar upload tidak muncul** → `php artisan storage:link`
- **Route tidak ditemukan setelah perubahan** → `php artisan route:clear`
- **Perubahan Blade tidak terlihat** → `php artisan view:clear`
- **Error signed URL / 403 pada gambar** → pastikan `APP_URL` di `.env` sesuai domain yang diakses
- **Error database** → cek kredensial MySQL di `.env` dan pastikan database `temanten` sudah dibuat

---

## License

MIT.
