<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    public function view(User $user, Invitation $invitation): bool
    {
        return $this->owns($user, $invitation);
    }

    public function update(User $user, Invitation $invitation): bool
    {
        return $this->owns($user, $invitation);
    }

    public function export(User $user, Invitation $invitation): bool
    {
        return $this->owns($user, $invitation);
    }

    public function addGuest(User $user, Invitation $invitation): bool
    {
        return $this->owns($user, $invitation);
    }

    public function importGuests(User $user, Invitation $invitation): bool
    {
        return $this->owns($user, $invitation);
    }

    private function owns(User $user, Invitation $invitation): bool
    {
        return (int) $invitation->user_id === (int) $user->id;
    }
}