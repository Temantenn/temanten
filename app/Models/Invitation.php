<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Invitation extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'content' => 'array',
        'event_date' => 'datetime',
        'expires_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getGroomNameAttribute()
    {
        return $this->content['mempelai']['pria']['nama'] ?? '-';
    }

    public function getGroomNicknameAttribute()
    {
        return $this->content['mempelai']['pria']['panggilan'] ?? '';
    }

    public function getGroomFatherAttribute()
    {
        return $this->content['mempelai']['pria']['ayah'] ?? '';
    }

    public function getGroomMotherAttribute()
    {
        return $this->content['mempelai']['pria']['ibu'] ?? '';
    }

    public function getGroomInstagramAttribute()
    {
        return $this->content['mempelai']['pria']['instagram'] ?? '';
    }

    public function getGroomPhotoAttribute()
    {
        return $this->content['mempelai']['pria']['foto'] ?? null;
    }

    public function getBrideNameAttribute()
    {
        return $this->content['mempelai']['wanita']['nama'] ?? '-';
    }

    public function getBrideNicknameAttribute()
    {
        return $this->content['mempelai']['wanita']['panggilan'] ?? '';
    }

    public function getBrideFatherAttribute()
    {
        return $this->content['mempelai']['wanita']['ayah'] ?? '';
    }

    public function getBrideMotherAttribute()
    {
        return $this->content['mempelai']['wanita']['ibu'] ?? '';
    }

    public function getBrideInstagramAttribute()
    {
        return $this->content['mempelai']['wanita']['instagram'] ?? '';
    }

    public function getBridePhotoAttribute()
    {
        return $this->content['mempelai']['wanita']['foto'] ?? null;
    }

    public function getAkadTitleAttribute()
    {
        return $this->content['acara']['akad']['judul'] ?? 'Akad Nikah';
    }

    public function getAkadDatetimeAttribute()
    {
        return isset($this->content['acara']['akad']['waktu'])
            ? Carbon::parse($this->content['acara']['akad']['waktu'])
            : Carbon::now();
    }

    public function getAkadLocationAttribute()
    {
        return $this->content['acara']['akad']['tempat'] ?? '';
    }

    public function getAkadAddressAttribute()
    {
        return $this->content['acara']['akad']['alamat'] ?? '';
    }

    public function getAkadMapLinkAttribute()
    {
        return $this->content['acara']['akad']['maps'] ?? '#';
    }

    public function getResepsiTitleAttribute()
    {
        return $this->content['acara']['resepsi']['judul'] ?? 'Resepsi Pernikahan';
    }

    public function getResepsiDatetimeAttribute()
    {
        return isset($this->content['acara']['resepsi']['waktu'])
            ? Carbon::parse($this->content['acara']['resepsi']['waktu'])
            : Carbon::now();
    }

    public function getResepsiLocationAttribute()
    {
        return $this->content['acara']['resepsi']['tempat'] ?? '';
    }

    public function getResepsiAddressAttribute()
    {
        return $this->content['acara']['resepsi']['alamat'] ?? '';
    }

    public function getResepsiMapLinkAttribute()
    {
        return $this->content['acara']['resepsi']['maps'] ?? '#';
    }

    public function getQuoteAttribute()
    {
        return $this->content['quote'] ?? '';
    }

    public function getLoveStoriesAttribute()
    {
        return $this->content['love_stories'] ?? [];
    }

    public function getCoverImageAttribute()
    {
        return $this->content['media']['cover'] ?? null;
    }

    public function getOgImageAttribute()
    {
        $clientOg = $this->content['media']['og_image'] ?? null;

        if ($clientOg && $this->publicFileUrl($clientOg)) {
            return $this->publicFileUrl($clientOg);
        }

        // Fallback to Cover Image (which might be handled by theme or specific path)
        $cover = $this->cover_image;
        if ($cover) {
            // Check if cover is a placeholder (http) or a local storage path
            return $this->publicFileUrl($cover) ?? asset('favicon.ico');
        }

        return asset('favicon.ico');
    }

    public function getMusicFileAttribute()
    {
        $clientMusic = $this->content['media']['music'] ?? null;

        if ($clientMusic && $this->publicFileUrl($clientMusic)) {
            return $this->publicFileUrl($clientMusic);
        }

        if ($this->theme) {
            return 'assets/music/' . $this->theme->slug . '.mp3';
        }

        return '';
    }

    /**
     * Normalize both legacy `storage/invitations/...` values and relative
     * public-disk paths into one browser URL without `storage/storage/...`.
     */
    protected function publicFileUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $relative = ltrim($path, '/');
        if (\Illuminate\Support\Str::startsWith($relative, 'storage/')) {
            $relative = substr($relative, strlen('storage/'));
        }

        if (!Storage::disk('public')->exists($relative)) {
            return null;
        }

        return asset('storage/' . $relative);
    }

    public function getGalleryPhotosAttribute()
    {
        return $this->content['media']['gallery'] ?? [];
    }

    /**
     * Public invitation URL (absolute, scheme + host).
     * Used by the client dashboard Share Kit and any deep link.
     */
    public function getPublicUrlAttribute(): string
    {
        return route('invitation.show', ['slug' => $this->slug], absolute: true);
    }

    public function getBankNameAttribute()
    {
        return $this->content['amplop']['bank_name'] ?? '';
    }

    public function getBankNumberAttribute()
    {
        return $this->content['amplop']['account_number'] ?? '';
    }

    public function getBankHolderAttribute()
    {
        return $this->content['amplop']['account_holder'] ?? '';
    }

    public function getGiftAddressAttribute()
    {
        return $this->content['amplop']['alamat_kado'] ?? '';
    }

    public function getGiftMapLinkAttribute()
    {
        return $this->content['amplop']['maps_kado'] ?? '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function comments()
    {
        return $this->hasMany(Guest::class)
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->orderBy('updated_at', 'desc');
    }

    // ── Expiry helpers ──────────────────────────────────────────

    /**
     * Is this invitation past its expiry date?
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * Set expiry based on INVITATION_EXPIRY_DAYS config.
     * Called automatically when invitation is created/activated.
     */
    public function setDefaultExpiry(): void
    {
        $days = (int) config('temanten.invitation_expiry_days', 365);
        if ($days > 0 && $this->expires_at === null) {
            $this->expires_at = now()->addDays($days);
            $this->save();
        }
    }

    /**
     * Check if invitation is viewable (active + not expired).
     */
    public function isViewable(): bool
    {
        return $this->status === 'active' && !$this->isExpired();
    }
}
