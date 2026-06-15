<?php

namespace App\Policies;

use App\Models\Guest;
use App\Models\User;

class GuestPolicy
{
    public function delete(User $user, Guest $guest): bool
    {
        if (!$guest->relationLoaded('invitation')) {
            $guest->load('invitation');
        }

        return (int) $guest->invitation?->user_id === (int) $user->id;
    }
}