<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'whatsapp',
        'category',
        'address',
        'slug',
        'rsvp_status',
        'jumlah_tamu',
        'comment',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name) . '-' . Str::random(8);
            }
        });
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}