<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * BlogController — lightweight static blog untuk SEO content.
 *
 * Posts disimpan sebagai array di method posts() (bukan DB)
 * biar cepet ship + ga butuh migration. Kalau nanti > 20 posts,
 * pindah ke DB atau markdown files.
 */
class BlogController extends Controller
{
    /**
     * Daftar post — key = slug, value = metadata + body (HTML).
     * Slug menggunakan bahasa Indonesia + dash.
     */
    protected function posts(): array
    {
        return [
            '10-tema-undangan-pernikahan-islami-modern-2026' => [
                'title'       => '10 Tema Undangan Pernikahan Islami Modern 2026 yang Wajib Dilirik',
                'description' => 'Cari tema undangan pernikahan islami yg modern tapi tetap syar\'i? Ini 10 pilihan terbaik 2026 — lengkap dengan nuansa kaligrafi, geometri, dan warna emas.',
                'keywords'    => 'undangan pernikahan islami, tema undangan islami modern, undangan syar\'i, undangan islami 2026',
                'date'        => '2026-06-15',
                'author'      => 'Tim Temanten',
                'reading_min' => 6,
                'og_image'    => 'assets/blog-islami.jpg',
                'body'        => '
                <p>Menikah dalam nuansa islami bukan berarti tampilannya kaku atau jadul. Di 2026, tren undangan pernikahan islami justru makin estetik — perpaduan kaligrafi Arab modern, geometri Islamic pattern, dan warna-warna earth-tone yang elegan.</p>

                <h2>1. <a href="/themes/barakah-love">Barakah Love</a></h2>
                <p>Nuansa gold-leaf di atas background deep teal. Aksen arabesque di setiap sudut. Cocok untuk pasangan yang ingin tema islami tapi tetap modern dan instagramable.</p>

                <h2>2. Emerald Garden</h2>
                <p>Warna zamrud dominan dengan border geometris islamic pattern. Terasa lapang, segar, dan penuh berkah. Sangat cocok untuk akad di outdoor garden.</p>

                <h2>3. Golden Sunrise</h2>
                <p>Gradient sunrise — dari deep amber ke ivory. Tipografi serif arabic-inspired. Nuansa pagi yang penuh harapan, pas untuk pasangan yang menikah pagi hari.</p>

                <h2>4. Sekar Jagad</h2>
                <p>Perpaduan islami dan Jawa — motif batik bunga dengan bismillah header. Warna sage, terracotta, dan gold. Cocok untuk pasangan Jawa-Muslim.</p>

                <h2>5. Jawa Keraton</h2>
                <p>Royal Javanese + islami spirit. Aksen gunungan wayang + kaligrafi Asmaul Husna. Untuk pasangan yang ingin nuansa kerajaan Jawa.</p>

                <h2>6. Sunda Asih</h2>
                <p>Nuansa Sunda dengan kujang mini-icon dan ukiran bambu. Warna earth-tone lembut. Sangat romantis untuk akad di daerah Priangan.</p>

                <h2>7. Royal Glass</h2>
                <p>Deep navy + gold filigree + kaligrafi geometris. Terasa megah tapi islami. Cocok untuk resepsi di ballroom hotel.</p>

                <h2>8. Celestial Night</h2>
                <p>Langit malam bertabur bintang + bulan sabit + constellation. Warna midnight blue dengan silver typography. Romantis dan spiritual.</p>

                <h2>9. Watercolor Flow</h2>
                <p>Watercolour lembut dengan motif geometri islami samar. Warna pastel earth. Untuk pasangan yang suka tampilan artsy dan lembut.</p>

                <h2>10. Floral Pastel</h2>
                <p>Bunga-bunga pastel dengan aksen gold arabic typography. Feminim tapi tidak lebay. Cocok untuk akad intimate.</p>

                <h2>Tips Memilih Tema Islami</h2>
                <ul>
                    <li>Pastikan ada ruang untuk <strong>bismillah</strong> atau <strong>Asmaul Husna</strong> di header</li>
                    <li>Hindari ilustrasi makhluk bernyawa (manusia/binatang) untuk patuh sunnah</li>
                    <li>Pilih warna earth-tone (gold, sage, navy, terracotta) daripada neon</li>
                    <li>Pastikan typography tetap <strong>readable</strong> — jangan terlalu dekoratif untuk teks panjang</li>
                </ul>

                <p>Semua 10 tema di atas sudah tersedia di <a href="/themes">katalog Temanten</a> dengan preview langsung. Bisa di-custom nama, tanggal, dan amplop digital. Order hari ini, file siap 1×24 jam.</p>
                ',
            ],

            'cara-buat-undangan-pernikahan-digital-gratis' => [
                'title'       => 'Cara Buat Undangan Pernikahan Digital Gratis yang Terlihat Premium',
                'description' => 'Mau undangan digital yg murah tapi keliatan mahal? Ikuti 7 langkah ini — dari pilih platform sampai kirim ke tamu via WA.',
                'keywords'    => 'undangan pernikahan digital gratis, cara buat undangan online, undangan digital murah, tips undangan premium',
                'date'        => '2026-06-10',
                'author'      => 'Tim Temanten',
                'reading_min' => 5,
                'og_image'    => 'assets/blog-gratis.jpg',
                'body'        => '
                <p>Undangan pernikahan digital itu murah, cepat, dan ramah lingkungan. Tapi banyak orang ragu karena takut keliatan "bikin sendiri" — typo, layout berantakan, atau warna norak. Padahal kalau tau triknya, undangan digital bisa keliatan lebih premium dari yg cetak.</p>

                <h2>Langkah 1: Pilih Platform yang Tepat</h2>
                <p>Hindari platform yg cuma kasih template kosong — pilih yg punya <strong>tema siap pakai</strong> dengan kurasi desain. <a href="/themes">Temanten</a> punya 16 tema islami, modern, tradisional, dark, floral — semuanya sudah didesain oleh desainer.</p>

                <h2>Langkah 2: Tulis Copy dengan Singkat &amp; Elegan</h2>
                <p>Jangan terlalu panjang. Yang penting:</p>
                <ul>
                    <li>Nama lengkap kedua mempelai + orang tua</li>
                    <li>Tanggal, waktu, lokasi (akad &amp; resepsi)</li>
                    <li>QR code untuk check-in (opsional)</li>
                    <li>Link Google Maps</li>
                    <li>Amplop digital (rekening atau QRIS)</li>
                </ul>

                <h2>Langkah 3: Pilih Foto Cover yang Bagus</h2>
                <p>Pre-wedding atau candid bareng pasangan. Resolusi minimal 1200×630 (standar OG image). Hindari foto terlalu kecil atau blur.</p>

                <h2>Langkah 4: Cek Mobile Preview</h2>
                <p>80% tamu buka undangan dari HP. Pastikan:</p>
                <ul>
                    <li>Text terbaca tanpa zoom</li>
                    <li>Tombol CTA (Lokasi, RSVP, Amplop) jelas</li>
                    <li>Musik auto-play off (user-friendly)</li>
                </ul>

                <h2>Langkah 5: Custom Domain (Opsional)</h2>
                <p>Biar lebih premium, gunakan subdomain sendiri: <code>namakamu.temanten.biz.id</code> atau domain custom. Tamu lebih trust dibanding URL random.</p>

                <h2>Langkah 6: Kirim via WhatsApp</h2>
                <p>Jangan kirim link mentah. Tambahkan pesan personal:</p>
                <blockquote>"Assalamu\'alaikum Wr Wb, dengan penuh suka cita kami mengundang Bapak/Ibu/Saudara untuk hadir di pernikahan kami. Mohon buka undangannya di link berikut: [link]"</blockquote>

                <h2>Langkah 7: RSVP &amp; Amplop Digital</h2>
                <p>Pakai fitur RSVP online biar tahu berapa tamu yang hadir (buat catering). Amplop digital via QRIS bikin tamu gampang kirim kado uang tanpa harus datang ke ATM.</p>

                <h2>Estimasi Biaya</h2>
                <ul>
                    <li><strong>Cetak undangan konvensional</strong>: Rp 2-5 juta untuk 300 lembar</li>
                    <li><strong>Undangan digital premium</strong>: Rp 50-300 ribu untuk unlimited tamu + RSVP + amplop digital</li>
                </ul>

                <p>Hemat 90%, lebih cepat, lebih eco-friendly, dan lebih mudah di-update kalau ada perubahan rencana.</p>

                <p>Mulai dari <a href="/themes">katalog Temanten</a> — preview gratis, order kapan saja.</p>
                ',
            ],
        ];
    }

    public function index(Request $request)
    {
        $posts = collect($this->posts())->map(function ($p, $slug) {
            $p['slug'] = $slug;
            return $p;
        })->sortByDesc('date')->values()->all();

        return view('blog.index', ['posts' => $posts]);
    }

    public function show(Request $request, string $slug)
    {
        $posts = $this->posts();

        if (! isset($posts[$slug])) {
            abort(404);
        }

        $post = $posts[$slug];
        $post['slug'] = $slug;

        // Related posts — 2 most recent other posts
        $related = collect($posts)
            ->reject(fn ($p, $s) => $s === $slug)
            ->map(fn ($p, $s) => array_merge($p, ['slug' => $s]))
            ->sortByDesc('date')
            ->take(2)
            ->values()
            ->all();

        return view('blog.show', [
            'post'    => $post,
            'related' => $related,
        ]);
    }
}