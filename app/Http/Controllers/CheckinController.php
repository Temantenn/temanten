<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Public endpoint untuk QR Check-in.
 *
 * Flow:
 * 1. Owner kirim URL invitation + ?to={guest_slug} ke tamu via WA
 * 2. Tamu buka invitation, lihat QR code unik mereka
 * 3. Di venue, staff scan QR tamu → buka /check-in/{invitation}/{token}
 * 4. Staff lihat info tamu + tap "Konfirmasi Hadir" → mark checked_in_at = now()
 *
 * URL aman karena:
 * - checkin_token 48-char random (288 bits entropy)
 * - Tidak ada auth requirement (staff di venue gak punya akun)
 * - Idempotent: scan kedua kali cuma menampilkan status, tidak double-mark
 */
class CheckinController extends Controller
{
    public function show(string $invitationSlug, string $token, Request $request)
    {
        $invitation = Invitation::where('slug', $invitationSlug)
            ->where('status', 'active')
            ->first();

        if (!$invitation) {
            abort(404, 'Undangan tidak ditemukan atau belum aktif.');
        }

        $guest = Guest::where('invitation_id', $invitation->id)
            ->where('checkin_token', $token)
            ->first();

        if (!$guest) {
            abort(404, 'QR code tidak valid untuk undangan ini.');
        }

        return view('checkin.show', [
            'invitation' => $invitation,
            'guest'      => $guest,
            'alreadyCheckedIn' => $guest->checked_in_at !== null,
        ]);
    }

    public function confirm(string $invitationSlug, string $token, Request $request)
    {
        $invitation = Invitation::where('slug', $invitationSlug)
            ->where('status', 'active')
            ->firstOrFail();

        $guest = Guest::where('invitation_id', $invitation->id)
            ->where('checkin_token', $token)
            ->firstOrFail();

        $alreadyCheckedIn = $guest->checked_in_at !== null;

        if (!$alreadyCheckedIn) {
            $guest->markCheckedIn();

            // Bust invitation cache (kalau ada views yang pakai checked_in_at)
            Cache::forget("invitation:{$invitation->slug}");

            Log::info('guest.checked_in', [
                'invitation_id' => $invitation->id,
                'guest_id'      => $guest->id,
                'guest_name'    => $guest->name,
            ]);
        }

        return view('checkin.show', [
            'invitation'       => $invitation,
            'guest'            => $guest,
            'alreadyCheckedIn' => $alreadyCheckedIn,
            'justCheckedIn'    => !$alreadyCheckedIn,
        ]);
    }
}