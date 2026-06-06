<?php

namespace Tests\Unit;

use App\Models\Invitation;
use Carbon\Carbon;
use Tests\TestCase;

class InvitationVisibilityTest extends TestCase
{
    public function test_active_non_expired_invitation_is_viewable(): void
    {
        $invitation = new Invitation([
            'status'     => 'active',
            'expires_at' => Carbon::now()->addDay(),
        ]);

        $this->assertTrue($invitation->isViewable());
    }

    public function test_pending_invitation_is_not_viewable(): void
    {
        $invitation = new Invitation([
            'status'     => 'pending',
            'expires_at' => Carbon::now()->addDay(),
        ]);

        $this->assertFalse($invitation->isViewable());
    }

    public function test_expired_invitation_is_not_viewable(): void
    {
        $invitation = new Invitation([
            'status'     => 'active',
            'expires_at' => Carbon::now()->subDay(),
        ]);

        $this->assertFalse($invitation->isViewable());
    }
}
