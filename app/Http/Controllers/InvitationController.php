<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use App\Models\Theme;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class InvitationController extends Controller
{
    public function show($slug, Request $request)
    {
        $cacheKey = "invitation:{$slug}";
        $cached = Cache::get($cacheKey);

        if ($cached) {
            $invitation = $this->findViewableInvitationBySlug($slug);
            $comments = $cached['comments'];
        } else {
            $invitation = $this->findViewableInvitationBySlug($slug);

            $comments = $invitation->guests()
                ->whereNotNull('comment')
                ->where('comment', '!=', '')
                ->orderBy('updated_at', 'desc')
                ->get();

            Cache::put($cacheKey, [
                'invitation' => $invitation,
                'comments'   => $comments,
            ], 3600);
        }

        $guest = null;
        if ($request->has('to')) {
            $guest = $invitation->guests()
                ->where('slug', $request->query('to'))
                ->first();
        }

        $viewPath = $invitation->theme->view_path;

        if (!view()->exists($viewPath)) {
            abort(404, "File tema tidak ditemukan: $viewPath");
        }

        return view($viewPath, compact('invitation', 'guest', 'comments'));
    }

    public function demo($themeSlug)
    {
        $theme = Theme::where('slug', $themeSlug)->firstOrFail();

        $invitation = new \stdClass();
        $invitation->slug = 'demo-' . $themeSlug;

        $unsplashKey = 'C9aJ-2k6P3AkE5YTnAuw3A46NRfA5q7nhhfFMP5bDOw';
        $getDummyImg = function($keyword, $orientation = 'portrait') use ($unsplashKey) {
            return \Illuminate\Support\Facades\Cache::remember("unsplash_dummy_" . md5($keyword . $orientation), 86400, function() use ($unsplashKey, $keyword, $orientation) {
                try {
                    $response = \Illuminate\Support\Facades\Http::timeout(5)->get("https://api.unsplash.com/photos/random", [
                        'query' => $keyword,
                        'client_id' => $unsplashKey,
                        'orientation' => $orientation
                    ]);
                    if ($response->successful()) {
                        return $response->json()['urls']['regular'];
                    }
                    return 'https://placehold.co/800x600/DDDDDD/666666/png?text=' . urlencode(substr($keyword, 0, 15));
                } catch (\Exception $e) {
                    return 'https://placehold.co/800x600/DDDDDD/666666/png?text=' . urlencode(substr($keyword, 0, 15));
                }
            });
        };

        $content = [
            'mempelai' => [
                'pria' => [
                    'nama' => 'Romeo Putra Perkasa',
                    'panggilan' => 'Romeo',
                    'ayah' => 'Bpk. Wijaya',
                    'ibu' => 'Ibu Sarah',
                    'instagram' => 'romeo_official',
                    'foto' => $getDummyImg('handsome groom suit wedding'),
                ],
                'wanita' => [
                    'nama' => 'Juliet Bunga Jelita',
                    'panggilan' => 'Juliet',
                    'ayah' => 'Bpk. Sutrisno',
                    'ibu' => 'Ibu Hartini',
                    'instagram' => 'juliet_beauty',
                    'foto' => $getDummyImg('beautiful bride dress wedding'),
                ],
            ],
            'acara' => [
                'akad' => [
                    'judul' => 'Akad Nikah',
                    'waktu' => now()->addDays(10)->format('Y-m-d H:i:s'),
                    'tempat' => 'Masjid Besar Istiqlal',
                    'alamat' => 'Jl. Taman Wijaya Kusuma, Jakarta Pusat',
                    'maps' => 'https://goo.gl/maps/contoh',
                ],
                'resepsi' => [
                    'judul' => 'Resepsi Pernikahan',
                    'waktu' => now()->addDays(10)->addHours(2)->format('Y-m-d H:i:s'),
                    'tempat' => 'Grand Ballroom Hotel Mulia',
                    'alamat' => 'Jl. Asia Afrika, Senayan, Jakarta',
                    'maps' => 'https://goo.gl/maps/contoh',
                ],
            ],
            'quote' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri...',
            'media' => [
                'cover' => $getDummyImg('luxury wedding venue decoration', 'landscape'),
                'music' => 'assets/music/' . $themeSlug . '.mp3',
                'video_link' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'gallery' => [
                    $getDummyImg('wedding rings', 'landscape'),
                    $getDummyImg('wedding bouquet', 'portrait'),
                    $getDummyImg('wedding couple walking', 'landscape'),
                    $getDummyImg('wedding cake', 'portrait'),
                ],
            ],
            'love_stories' => [
                [
                    'year' => '2020',
                    'title' => 'Pertama Bertemu',
                    'story' => 'Kami bertemu pertama kali di sebuah kedai kopi di Jakarta Selatan...',
                ],
                [
                    'year' => '2022',
                    'title' => 'Lamaran',
                    'story' => 'Setelah 2 tahun bersama, Romeo memberanikan diri melamar...',
                ],
            ],
            'amplop' => [
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder' => 'Romeo Putra',
                'alamat_kado' => 'Jl. Mawar Melati No. 123, Jakarta Selatan',
                'maps_kado' => 'https://goo.gl/maps/kado',
            ],
        ];

        $invitation->content = $content;
        $invitation->comments = collect([]);
        $invitation->og_image = asset('favicon.ico');

        return view($theme->view_path, compact('invitation'));
    }

    public function kirimUcapan(Request $request)
    {
        $validated = $request->validate([
            'invitation_slug' => 'required|string',
            'nama'            => 'required|string|max:255',
            'ucapan'          => 'required|string|max:2000',
            'kehadiran'       => 'required|in:hadir,tidak_hadir,ragu',
        ]);

        $invitation = $this->findViewableInvitationBySlug($validated['invitation_slug']);

        try {
            $this->saveGuestResponse($invitation, $validated);

        } catch (\Throwable $e) {
            Log::channel('daily')->error('Failed to save ucapan/rsvp', [
                'invitation_slug' => $validated['invitation_slug'],
                'error'           => $e->getMessage(),
            ]);

            return back()->with('error', 'Gagal mengirim ucapan. Silakan coba lagi.');
        }

        return back()->with('success', 'Terima kasih! Ucapan Anda berhasil dikirim.');
    }

    public function listUcapan($slug)
    {
        $invitation = $this->findViewableInvitationBySlug($slug);

        $guests = $invitation->guests()
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $guests->map(fn (Guest $guest) => $this->formatGuestResponse($guest))->values(),
        ]);
    }

    public function storeUcapan($slug, Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'ucapan'      => 'nullable|string|max:2000',
            'kehadiran'   => 'required|in:hadir,tidak_hadir,ragu',
            'jumlah_tamu' => 'nullable|integer|min:1|max:10',
        ]);

        $invitation = $this->findViewableInvitationBySlug($slug);

        try {
            $guest = $this->saveGuestResponse($invitation, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! RSVP Anda berhasil dikirim.',
                'data'    => $this->formatGuestResponse($guest),
            ]);
        } catch (\Throwable $e) {
            Log::channel('daily')->error('Failed to save ucapan/rsvp', [
                'invitation_slug' => $slug,
                'error'           => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ucapan. Silakan coba lagi.',
            ], 500);
        }
    }

    public function submitRSVP($id, Request $request)
    {
        $this->normalizeGuestResponseAliases($request);

        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'ucapan'      => 'nullable|string|max:2000',
            'kehadiran'   => 'required|in:hadir,tidak_hadir,ragu',
            'jumlah_tamu' => 'nullable|integer|min:1|max:10',
        ]);

        $invitation = $this->findViewableInvitationById($id);

        try {
            $guest = $this->saveGuestResponse($invitation, $validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Terima kasih! RSVP Anda berhasil dikirim.',
                    'data'    => $this->formatGuestResponse($guest),
                ]);
            }

            return back()->with('success', 'Terima kasih! RSVP Anda berhasil dikirim.');
        } catch (\Throwable $e) {
            Log::channel('daily')->error('Failed to save rsvp', [
                'invitation_id' => $id,
                'error'         => $e->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim RSVP. Silakan coba lagi.',
                ], 500);
            }

            return back()->with('error', 'Gagal mengirim RSVP. Silakan coba lagi.');
        }
    }

    private function findViewableInvitationBySlug(string $slug): Invitation
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        if ($invitation->isExpired()) {
            Cache::forget("invitation:{$invitation->slug}");
            abort(410, 'Undangan ini sudah kedaluwarsa.');
        }

        return $invitation;
    }

    private function findViewableInvitationById($id): Invitation
    {
        $invitation = Invitation::whereKey($id)
            ->where('status', 'active')
            ->firstOrFail();

        if ($invitation->isExpired()) {
            Cache::forget("invitation:{$invitation->slug}");
            abort(410, 'Undangan ini sudah kedaluwarsa.');
        }

        return $invitation;
    }

    private function normalizeGuestResponseAliases(Request $request): void
    {
        $aliases = [];

        if (!$request->has('nama') && $request->has('name')) {
            $aliases['nama'] = $request->input('name');
        }

        if (!$request->has('ucapan') && $request->has('comment')) {
            $aliases['ucapan'] = $request->input('comment');
        }

        if (!$request->has('kehadiran') && $request->has('rsvp_status')) {
            $aliases['kehadiran'] = $request->input('rsvp_status');
        }

        if ($aliases !== []) {
            $request->merge($aliases);
        }
    }

    private function saveGuestResponse(Invitation $invitation, array $data): Guest
    {
        $name = trim($data['nama']);
        $comment = array_key_exists('ucapan', $data)
            ? trim((string) $data['ucapan'])
            : null;

        $payload = [
            'rsvp_status' => $data['kehadiran'],
        ];

        if (array_key_exists('ucapan', $data)) {
            $payload['comment'] = $comment === '' ? null : $comment;
        }

        $guest = $invitation->guests()
            ->where('name', $name)
            ->first();

        if ($guest) {
            $guest->update($payload);
        } else {
            $guest = $invitation->guests()->create(array_merge([
                'name'     => $name,
                'slug'     => Str::slug($name) . '-' . Str::random(4),
                'category' => 'Umum',
            ], $payload));
        }

        Cache::forget("invitation:{$invitation->slug}");

        ActivityLog::record('info', 'guest.rsvp_submitted', $invitation, [
            'nama'      => $name,
            'kehadiran' => $data['kehadiran'],
        ]);

        return $guest->fresh();
    }

    private function formatGuestResponse(Guest $guest): array
    {
        return [
            'id'               => $guest->id,
            'nama'             => $guest->name,
            'ucapan'           => $guest->comment,
            'kehadiran'        => $guest->rsvp_status,
            'created_at'       => optional($guest->updated_at)->toDateTimeString(),
            'created_at_human' => optional($guest->updated_at)->diffForHumans(),
        ];
    }
}
