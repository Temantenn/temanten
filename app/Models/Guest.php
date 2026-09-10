<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'whatsapp',
        'category',
        'address',
        'slug',
        'checkin_token',
        'rsvp_status',
        'jumlah_tamu',
        'is_anonymous_wish',
        'comment',
        'checked_in_at',
    ];

    protected $casts = [
        'jumlah_tamu' => 'integer',
        'checked_in_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name) . '-' . Str::random(8);
            }
            if (empty($model->checkin_token)) {
                // Loop retry sampai dapat unique token (collision harusnya sangat jarang)
                do {
                    $token = Str::random(48);
                } while (static::where('checkin_token', $token)->exists());
                $model->checkin_token = $token;
            }
        });
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    /**
     * URL yang di-encode ke QR code. Staff scan → buka URL ini di browser → konfirmasi hadir.
     */
    public function getCheckinUrlAttribute(): string
    {
        return route('checkin.show', [
            'invitation' => $this->invitation->slug,
            'token'      => $this->checkin_token,
        ]);
    }

    public function getIsCheckedInAttribute(): bool
    {
        return $this->checked_in_at !== null;
    }

    /**
     * Mark guest as checked-in. Idempotent — kalau sudah pernah, return existing timestamp.
     */
    public function markCheckedIn(): bool
    {
        if ($this->checked_in_at) {
            return false;
        }

        $timestamp = now();
        $updated = static::query()
            ->whereKey($this->getKey())
            ->whereNull('checked_in_at')
            ->update([
                'checked_in_at' => $timestamp,
                'updated_at'    => $timestamp,
            ]);

        if ($updated > 0) {
            $this->checked_in_at = $timestamp;
            return true;
        }

        $this->refresh();
        return false;
    }
}
