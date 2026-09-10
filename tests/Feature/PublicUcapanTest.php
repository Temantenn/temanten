<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\Theme;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicUcapanTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
        Cache::flush();

        $this->resetSchema();
    }

    public function test_public_ucapan_endpoint_stores_guest_response_for_active_invitation(): void
    {
        $invitation = $this->createInvitation();

        $response = $this->postJson("/undangan/{$invitation->slug}/ucapan", [
            'nama'        => 'Budi Santoso',
            'ucapan'      => 'Selamat menempuh hidup baru.',
            'kehadiran'   => 'hadir',
            'jumlah_tamu' => 2,
        ]);

        $response
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.nama', 'Budi Santoso')
            ->assertJsonPath('data.kehadiran', 'hadir');

        $this->assertDatabaseHas('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Budi Santoso',
            'rsvp_status'   => 'hadir',
            'jumlah_tamu'   => 2,
            'comment'       => 'Selamat menempuh hidup baru.',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'event' => 'guest.rsvp_submitted',
        ]);
    }

    public function test_pending_invitation_cannot_accept_public_ucapan(): void
    {
        $invitation = $this->createInvitation(status: 'pending');

        $this->postJson("/undangan/{$invitation->slug}/ucapan", [
            'nama'      => 'Budi Santoso',
            'ucapan'    => 'Selamat.',
            'kehadiran' => 'hadir',
        ])->assertNotFound();

        $this->assertDatabaseCount('guests', 0);
    }

    public function test_expired_invitation_cannot_accept_public_ucapan(): void
    {
        $invitation = $this->createInvitation(expiresAt: now()->subMinute());

        $this->postJson("/undangan/{$invitation->slug}/ucapan", [
            'nama'      => 'Budi Santoso',
            'ucapan'    => 'Selamat.',
            'kehadiran' => 'hadir',
        ])->assertStatus(410);

        $this->assertDatabaseCount('guests', 0);
    }

    public function test_public_ucapan_list_only_returns_guests_with_comments(): void
    {
        $invitation = $this->createInvitation();

        $invitation->guests()->create([
            'name'        => 'Ani',
            'slug'        => 'ani',
            'category'    => 'Umum',
            'rsvp_status' => 'hadir',
            'comment'     => 'Selamat ya.',
        ]);

        $invitation->guests()->create([
            'name'        => 'Cici',
            'slug'        => 'cici',
            'category'    => 'Umum',
            'rsvp_status' => 'hadir',
            'comment'     => null,
        ]);

        $this->getJson("/undangan/{$invitation->slug}/ucapan")
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.nama', 'Ani')
            ->assertJsonMissing(['nama' => 'Cici']);
    }

    public function test_legacy_rsvp_endpoint_accepts_alias_payload(): void
    {
        $invitation = $this->createInvitation();

        $this->postJson("/rsvp/{$invitation->id}", [
            'name'        => 'Dina',
            'comment'     => 'InsyaAllah hadir.',
            'rsvp_status' => 'ragu',
        ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.nama', 'Dina')
            ->assertJsonPath('data.kehadiran', 'ragu');

        $this->assertDatabaseHas('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Dina',
            'rsvp_status'   => 'ragu',
            'comment'       => 'InsyaAllah hadir.',
        ]);
    }

    public function test_partial_name_match_cannot_update_guest_from_another_invitation(): void
    {
        $invitation = $this->createInvitation();
        $otherTheme = Theme::create([
            'name'      => 'Other Test Theme',
            'slug'      => 'other-test-theme',
            'view_path' => 'themes.test.index',
            'is_active' => true,
        ]);
        $otherInvitation = Invitation::create([
            'uuid'            => (string) Str::uuid(),
            'theme_id'        => $otherTheme->id,
            'slug'            => 'other-undangan',
            'client_whatsapp' => '6281234567890',
            'status'          => 'active',
            'event_date'      => now()->addDay(),
            'expires_at'      => now()->addDay(),
            'content'         => ['mempelai' => ['pria' => [], 'wanita' => []]],
        ]);

        $otherGuest = $otherInvitation->guests()->create([
            'name'        => 'Budi Santoso',
            'category'    => 'Umum',
            'rsvp_status' => 'pending',
        ]);

        $this->postJson("/undangan/{$invitation->slug}/ucapan", [
            'nama'      => 'Santoso',
            'ucapan'    => 'Salam untuk kalian.',
            'kehadiran' => 'hadir',
        ])->assertOk();

        $this->assertDatabaseHas('guests', [
            'id'            => $otherGuest->id,
            'rsvp_status'   => 'pending',
            'comment'       => null,
        ]);
        $this->assertDatabaseHas('guests', [
            'invitation_id'     => $invitation->id,
            'name'              => 'Santoso',
            'is_anonymous_wish' => true,
        ]);
    }

    private function createInvitation(string $status = 'active', mixed $expiresAt = null): Invitation
    {
        $theme = Theme::create([
            'name'      => 'Test Theme',
            'slug'      => 'test-theme',
            'view_path' => 'themes.test.index',
            'is_active' => true,
        ]);

        return Invitation::create([
            'uuid'            => (string) Str::uuid(),
            'theme_id'        => $theme->id,
            'slug'            => 'test-undangan',
            'client_whatsapp' => '6281234567890',
            'status'          => $status,
            'event_date'      => now()->addDay(),
            'expires_at'      => $expiresAt,
            'content'         => [
                'mempelai' => [
                    'pria'   => ['nama' => 'Romeo'],
                    'wanita' => ['nama' => 'Juliet'],
                ],
            ],
        ]);
    }

    private function resetSchema(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('guests');
        Schema::dropIfExists('invitations');
        Schema::dropIfExists('themes');

        Schema::create('themes', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('view_path');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->integer('promo_price')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('invitations', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('theme_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('slug')->unique();
            $table->string('client_whatsapp');
            $table->string('status')->default('pending');
            $table->dateTime('event_date');
            $table->json('content');
            $table->dateTime('expires_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('guests', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('invitation_id');
            $table->string('name');
            $table->string('slug');
            $table->string('category')->default('Regular');
            $table->string('whatsapp')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('checkin_token', 64)->nullable()->unique();
            $table->string('rsvp_status')->default('pending');
            $table->unsignedTinyInteger('jumlah_tamu')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->boolean('is_anonymous_wish')->default(false)->index();
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table): void {
            $table->id();
            $table->string('type');
            $table->string('event');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }
}
