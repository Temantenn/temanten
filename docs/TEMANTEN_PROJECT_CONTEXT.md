# Temanten Project Context

Dokumen ini merangkum konteks teknis project Temanten berdasarkan analisis struktur project dan beberapa file utama. Scope dokumen ini hanya sebagai referensi internal; tidak ada perubahan kode aplikasi yang dilakukan.

## 1. Ringkasan Stack

- Framework utama: Laravel/PHP.
- Frontend templating: Blade templates di `resources/views`.
- Styling dan asset build: Vite, Tailwind/CSS, dengan entry umum di `resources/css/app.css` dan `resources/js/app.js`.
- Database: Laravel migrations di `database/migrations`.
- Autentikasi: Laravel auth scaffold/routes melalui `routes/auth.php` dan controller di `app/Http/Controllers/Auth`.
- Domain utama aplikasi: katalog tema undangan, pemesanan undangan, pembayaran/QRIS, dashboard admin, dashboard client, manajemen tamu, RSVP/ucapan, dan halaman undangan publik.

## 2. Struktur Domain/Model

Model utama yang terlihat:

- `app/Models/User.php`
  - Mewakili akun pengguna.
  - Role digunakan untuk membedakan admin dan client.

- `app/Models/Theme.php`
  - Mewakili tema undangan.
  - Field penting dari migrasi awal: `name`, `slug`, `view_path`, `thumbnail`, `is_active`.
  - Ada dukungan harga melalui field tambahan `price` dan `promo_price` dari migrasi lanjutan.
  - Accessor harga tersedia untuk original price, effective price, promo status, dan format harga.

- `app/Models/Invitation.php`
  - Mewakili undangan milik client.
  - Field penting: `uuid`, `theme_id`, `user_id`, `slug`, `client_whatsapp`, `status`, `event_date`, `content`.
  - `content` dicast sebagai array JSON dan menjadi sumber data utama untuk mempelai, acara, media, amplop, love story, dan quote.
  - Relasi: belongs to `User`, belongs to `Theme`, dan has many `Guest`.
  - Banyak accessor membaca struktur `content`, misalnya nama mempelai, waktu akad/resepsi, media, gallery, rekening, dan alamat kado.

- `app/Models/Guest.php`
  - Mewakili tamu undangan.
  - Digunakan untuk personalisasi link via query `to`, import/export tamu, ucapan, dan RSVP.

- `app/Models/Order.php`
  - Mewakili pesanan/pembayaran tema undangan.
  - Terhubung dengan theme dan user.

- `app/Models/ActivityLog.php`
  - Digunakan untuk mencatat aktivitas seperti RSVP/ucapan masuk.

## 3. Route dan Alur Utama

Route utama berada di `routes/web.php`.

### Halaman publik

- `/` mengarah ke landing page `resources/views/landing.blade.php`.
- `/themes` menampilkan katalog tema melalui `ThemeController@index`.
- `/themes/{slug}` diarahkan ke `ThemeController@show`, tetapi perlu dicatat ada indikasi view detail yang dirujuk adalah `themes.detail`.
- `/demo/{theme}` menampilkan demo tema melalui `InvitationController@demo`.
- `/undangan/{slug}` menampilkan undangan aktif melalui `InvitationController@show`.

### Alur pemesanan

- `/buat-undangan` GET menampilkan form order melalui `OrderController@create`.
- `/buat-undangan` POST membuat user client, order, dan invitation pending melalui `OrderController@store`.
- `/pembayaran` menampilkan halaman pembayaran QRIS dinamis melalui `OrderController@payment`.
- `/order-success/{id}` terdaftar di route, tetapi detail implementasi perlu dicek pada controller terkait karena tidak terlihat dalam potongan `OrderController` yang dianalisis.

### RSVP dan ucapan

- `/kirim-ucapan` POST menerima ucapan dan status kehadiran melalui `InvitationController@kirimUcapan`.
- `/rsvp/{id}` POST terdaftar menuju `InvitationController@submitRSVP`, tetapi method tersebut tidak terlihat pada potongan controller yang dianalisis; ini menjadi risiko inkonsistensi.
- Route RSVP/ucapan diberi throttle `10,1`.

### Dashboard admin

Prefix `/admin` dengan middleware `auth` dan `admin`:

- Dashboard admin.
- Approval order/invitation.
- Reset password user.
- Manajemen harga tema/default price.
- Manajemen akun admin.

### Dashboard client

Prefix `/client` dengan middleware `auth`:

- Dashboard client.
- Import/download/export tamu.
- Tambah/hapus tamu.
- Settings undangan dan update settings.

### API wilayah

Prefix `/api/wilayah` dengan throttle `60,1`:

- Provinces.
- Regencies.
- Districts.
- Villages.

## 4. Konvensi Tema Undangan

Konvensi tema yang terlihat:

- Setiap theme memiliki `slug` unik di database.
- Setiap theme memiliki `view_path` yang menunjuk ke Blade view, misalnya `themes.pixel-adventure.index`.
- File Blade tema ditempatkan di `resources/views/themes/{slug}/index.blade.php`.
- Musik default tema mengikuti pola `public/assets/music/{slug}.mp3`, melalui accessor `Invitation::getMusicFileAttribute()`.
- Demo tema dibuat oleh `InvitationController@demo` menggunakan object dummy dan struktur `content` yang menyerupai invitation nyata.
- View tema diharapkan membaca data dari `$invitation`, `$guest`, dan/atau `$comments`.
- Data utama konten undangan berada di JSON `content` dengan konvensi struktur:
  - `mempelai.pria` dan `mempelai.wanita`.
  - `acara.akad` dan `acara.resepsi`.
  - `media.cover`, `media.music`, `media.video_link`, `media.gallery`.
  - `love_stories`.
  - `amplop`.
  - `quote`.

## 5. Status Integrasi `pixel-adventure`

Integrasi tema `pixel-adventure` sudah terlihat pada beberapa bagian project:

- View tema tersedia di `resources/views/themes/pixel-adventure/index.blade.php`.
- Migrasi penambahan theme tersedia di `database/migrations/2026_05_11_053006_add_pixel_adventure_theme.php`.
- Migrasi tersebut melakukan `Theme::updateOrCreate` dengan:
  - `slug`: `pixel-adventure`.
  - `name`: `Pixel Adventure`.
  - `view_path`: `themes.pixel-adventure.index`.
  - `description`: `Retro pixel art game-style wedding invitation`.
  - `is_active`: `true`.
- Folder asset khusus terlihat di `public/assets/themes/pixel-adventure`, tetapi dari listing saat ini hanya ditemukan `LICENSES.md`.
- Musik default berdasarkan konvensi accessor akan mencari `public/assets/music/pixel-adventure.mp3`; file tersebut tidak terlihat pada daftar asset musik yang dianalisis.
- View `pixel-adventure` memakai font Google `Press Start 2P`, Vite app CSS/JS, dan CSS inline yang sangat besar di dalam Blade.
- View `pixel-adventure` tampak mobile-first dengan wrapper maksimal sekitar 430px dan gaya retro pixel art.

## 6. Risiko/Inkonstistensi yang Ditemukan

Daftar risiko berikut bersifat hasil observasi awal dan perlu diverifikasi sebelum diperbaiki:

1. Route `/rsvp/{id}` mengarah ke `InvitationController@submitRSVP`, tetapi method `submitRSVP` tidak terlihat pada `app/Http/Controllers/InvitationController.php` yang dianalisis.
2. Route `/themes/{slug}` memakai `ThemeController@show` yang me-return `themes.detail`, sementara file `resources/views/themes/detail.blade.php` tidak terlihat pada daftar file awal.
3. Route `/order-success/{id}` mengarah ke `OrderController@success`, tetapi method `success` tidak terlihat pada `app/Http/Controllers/OrderController.php` yang dianalisis.
4. Migrasi `database/migrations/2026_05_11_053006_add_pixel_adventure_theme.php` mengisi kolom `description`, sedangkan migrasi awal `themes` yang dianalisis hanya menunjukkan `name`, `slug`, `view_path`, `thumbnail`, dan `is_active`. Perlu dipastikan kolom `description` memang sudah ditambahkan oleh migrasi lain atau tersedia di database aktual.
5. File musik `public/assets/music/pixel-adventure.mp3` tidak terlihat pada daftar asset musik, sementara accessor default akan mencoba path tersebut untuk theme `pixel-adventure`.
6. Folder `public/assets/themes/pixel-adventure` hanya terlihat memiliki `LICENSES.md`; jika view mengharapkan asset tambahan lokal, asset tersebut perlu diverifikasi.
7. `InvitationController@demo` menyimpan API key Unsplash secara hard-coded di controller. Ini berisiko dari sisi keamanan dan maintainability.
8. `InvitationController@demo` hanya mengirim `invitation` ke view, sedangkan beberapa theme mungkin mengharapkan `$guest` atau `$comments`; perlu dicek konsistensi setiap theme.
9. `resources/views/themes/pixel-adventure/index.blade.php` berisi CSS inline sangat besar, sehingga maintenance, diff review, dan caching CSS bisa kurang optimal.
10. Penggunaan fallback media berbeda-beda bisa berpotensi menghasilkan broken asset jika path tidak ada, terutama untuk musik dan gambar cover.

## 7. Rekomendasi Perbaikan Minimal

Rekomendasi berikut diprioritaskan kecil, aman, dan mudah direview:

1. Verifikasi dan tambahkan method yang hilang jika memang route aktif:
   - `InvitationController@submitRSVP` untuk route `/rsvp/{id}`.
   - `OrderController@success` untuk route `/order-success/{id}`.
2. Pastikan view `themes.detail` tersedia atau ubah route detail theme agar mengarah ke view yang benar.
3. Pastikan schema `themes` memiliki kolom `description` sebelum migrasi `pixel-adventure` dijalankan, atau hilangkan pengisian `description` jika kolom tidak digunakan.
4. Tambahkan `public/assets/music/pixel-adventure.mp3` atau sediakan fallback aman jika file musik theme tidak ada.
5. Pindahkan Unsplash API key dari controller ke konfigurasi/env, lalu akses via `config/services.php` atau env wrapper yang sesuai.
6. Untuk demo theme, kirim variabel default yang konsisten seperti `$guest = null` dan `$comments = collect([])` agar semua view theme aman.
7. Jika `pixel-adventure` sudah stabil, pertimbangkan memindahkan CSS besar dari inline Blade ke file CSS terpisah, tetapi lakukan sebagai perubahan terpisah agar risiko kecil.
8. Tambahkan validasi ringan untuk memastikan setiap theme aktif memiliki `view_path` yang valid dan file musik opsional tidak menyebabkan error fatal.

## 8. Checklist Validasi

Checklist validasi manual/teknis yang disarankan:

- [ ] Jalankan `php artisan route:list` dan pastikan tidak ada route yang menunjuk ke method controller yang tidak tersedia.
- [ ] Buka `/themes` dan pastikan katalog theme aktif tampil.
- [ ] Buka `/themes/pixel-adventure` jika halaman detail theme tersedia.
- [ ] Buka `/demo/pixel-adventure` dan pastikan view demo tampil tanpa error variable undefined.
- [ ] Buka `/undangan/{slug}` untuk invitation aktif yang memakai `pixel-adventure`.
- [ ] Test submit ucapan via `/kirim-ucapan` dan pastikan data guest/comment tersimpan.
- [ ] Test RSVP jika route `/rsvp/{id}` memang masih digunakan.
- [ ] Pastikan asset musik `public/assets/music/pixel-adventure.mp3` ada atau fallback berjalan aman.
- [ ] Pastikan migrasi pixel adventure tidak gagal karena kolom `description`.
- [ ] Jalankan `php artisan view:clear` setelah perubahan Blade/theme.
- [ ] Jalankan build frontend bila ada perubahan CSS/JS: `npm run build`.

## 9. Catatan Scope Dokumen

Dokumen ini hanya mencatat konteks, risiko, dan rekomendasi. Tidak ada refactor, perubahan controller, perubahan route, perubahan view, perubahan migration, atau perubahan asset aplikasi yang dilakukan dalam pembuatan dokumen ini.
