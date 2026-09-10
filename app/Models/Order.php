<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'theme_id',
        'user_id',
        'invitation_id',
        'unique_code',
        'total_amount',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
}
