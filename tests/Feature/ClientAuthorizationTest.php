<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Theme;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Tests\TestCase;

class ClientAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->resetSchema();
    }

    public function test_user_cannot_export_another_users_invitation_guests(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $this->actingAs($other)
            ->get(route('client.exportGuests', $invitation))
            ->assertForbidden();
    }

    public function test_owner_can_download_guest_template_csv(): void
    {
        [$owner] = $this->createOwnedInvitation();

        $response = $this->actingAs($owner)
            ->get(route('client.downloadTemplate'))
            ->assertOk()
            ->assertHeader('Content-Disposition', 'attachment; filename="template_tamu.csv"');

        $content = $response->getContent();

        $this->assertStringStartsWith("\xEF\xBB\xBF", $content);
        $this->assertStringContainsString('"Nama Tamu","Nomor WA",Kategori,Alamat', $content);
        $this->assertStringContainsString('"Budi Santoso",081234567890,"Teman Kerja",Jakarta', $content);
    }

    public function test_owner_can_export_own_guests_csv(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $invitation->guests()->create([
            'name'        => 'Tamu Hadir',
            'category'    => 'Keluarga',
            'whatsapp'    => '6281234567890',
            'rsvp_status' => 'hadir',
            'comment'     => 'Selamat',
            'jumlah_tamu' => 2,
        ]);

        $response = $this->actingAs($owner)
            ->get(route('client.exportGuests', $invitation))
            ->assertOk();

        $disposition = $response->headers->get('Content-Disposition');
        $content = $response->getContent();

        $this->assertStringStartsWith('attachment; filename="daftar_tamu_' . $invitation->slug . '_', $disposition);
        $this->assertStringEndsWith('.csv"', $disposition);
        $this->assertStringStartsWith("\xEF\xBB\xBF", $content);
        $this->assertStringContainsString('Nama,Kategori,WhatsApp,"Status Kehadiran",Ucapan,"Jumlah Tamu","Tanggal Input"', $content);
        $this->assertStringContainsString('"Tamu Hadir",Keluarga,6281234567890,Hadir,Selamat,2,', $content);
    }

    public function test_user_cannot_delete_another_users_guest(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();
        $guest = $invitation->guests()->create([
            'name'        => 'Tamu Owner',
            'category'    => 'Umum',
            'rsvp_status' => 'pending',
        ]);

        $this->actingAs($other)
            ->delete(route('client.deleteGuest', $guest))
            ->assertForbidden();

        $this->assertDatabaseHas('guests', [
            'id'   => $guest->id,
            'name' => 'Tamu Owner',
        ]);
    }

    public function test_owner_can_delete_own_guest(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();
        $guest = $invitation->guests()->create([
            'name'        => 'Tamu Owner',
            'category'    => 'Umum',
            'rsvp_status' => 'pending',
        ]);

        $this->actingAs($owner)
            ->delete(route('client.deleteGuest', $guest))
            ->assertRedirect();

        $this->assertDatabaseMissing('guests', [
            'id' => $guest->id,
        ]);
    }

    public function test_guest_whatsapp_is_normalized_when_stored(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $this->actingAs($owner)
            ->post(route('client.storeGuest'), [
                'name'     => 'Tamu WA',
                'whatsapp' => '0812-3456-7890',
                'category' => 'Umum',
                'address'  => 'Jakarta',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Tamu WA',
            'whatsapp'      => '6281234567890',
        ]);
    }

    public function test_invalid_guest_whatsapp_is_rejected(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $this->actingAs($owner)
            ->from(route('client.dashboard'))
            ->post(route('client.storeGuest'), [
                'name'     => 'Tamu Invalid',
                'whatsapp' => '12345abc',
            ])
            ->assertRedirect(route('client.dashboard'))
            ->assertSessionHasErrors('whatsapp');

        $this->assertDatabaseMissing('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Tamu Invalid',
        ]);
    }

    public function test_import_rejects_invalid_whatsapp_and_saves_nothing(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $file = UploadedFile::fake()->createWithContent(
            'guests.csv',
            "Nama Tamu,Nomor WA,Kategori,Alamat\nValid,081234567890,Teman,Jakarta\nInvalid,12345abc,Keluarga,Bandung\n"
        );

        $this->actingAs($owner)
            ->from(route('client.dashboard'))
            ->post(route('client.importGuests'), ['file' => $file])
            ->assertRedirect(route('client.dashboard'))
            ->assertSessionHasErrors('file');

        $this->assertDatabaseMissing('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Valid',
        ]);
        $this->assertDatabaseMissing('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Invalid',
        ]);
    }

    public function test_import_normalizes_valid_whatsapp(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $file = UploadedFile::fake()->createWithContent(
            'guests.csv',
            "Nama Tamu,Nomor WA,Kategori,Alamat\nValid,0812 3456 7890,Teman,Jakarta\n"
        );

        $this->actingAs($owner)
            ->post(route('client.importGuests'), ['file' => $file])
            ->assertRedirect();

        $this->assertDatabaseHas('guests', [
            'invitation_id' => $invitation->id,
            'name'          => 'Valid',
            'whatsapp'      => '6281234567890',
        ]);
    }

    public function test_order_whatsapp_is_normalized_when_stored(): void
    {
        $theme = $this->createTheme();

        $this->from(route('order.create'))
            ->post(route('order.store'), [
                'slug'            => 'order-wa-' . Str::random(8),
                'theme_id'        => $theme->id,
                'client_whatsapp' => '+62 812-3456-7890',
                'groom_name'      => 'Budi',
                'bride_name'      => 'Siti',
                'event_date'      => now()->addDay()->toDateString(),
            ])
            ->assertRedirect(route('order.payment'));

        $this->assertDatabaseHas('invitations', [
            'client_whatsapp' => '6281234567890',
        ]);
    }

    public function test_invalid_order_whatsapp_is_rejected(): void
    {
        $theme = $this->createTheme();

        $this->from(route('order.create'))
            ->post(route('order.store'), [
                'slug'            => 'order-invalid-' . Str::random(8),
                'theme_id'        => $theme->id,
                'client_whatsapp' => '12345abc',
                'groom_name'      => 'Budi',
                'bride_name'      => 'Siti',
                'event_date'      => now()->addDay()->toDateString(),
            ])
            ->assertRedirect(route('order.create'))
            ->assertSessionHasErrors('client_whatsapp');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('invitations', 0);
    }

    public function test_order_unique_code_collision_retries_and_recalculates_total(): void
    {
        $theme = $this->createTheme();
        $existingUser = User::factory()->create();

        Order::create([
            'order_number' => 'TRX-EXISTING-1',
            'theme_id'     => $theme->id,
            'user_id'      => $existingUser->id,
            'unique_code'  => 123,
            'total_amount' => 99123,
            'status'       => 'pending',
            'expired_at'   => now()->addHour(),
        ]);

        $this->app->bind(OrderService::class, function () {
            return new class extends OrderService {
                private array $codes = [123, 456];
                private int $orderNumber = 0;

                public function generateUniqueCode(): int
                {
                    $code = $this->codes[0] ?? 789;
                    array_shift($this->codes);

                    return $code;
                }

                public function generateOrderNumber(): string
                {
                    $this->orderNumber++;

                    return 'TRX-RETRY-' . $this->orderNumber;
                }
            };
        });

        $this->from(route('order.create'))
            ->post(route('order.store'), [
                'slug'            => 'order-retry-' . Str::random(8),
                'theme_id'        => $theme->id,
                'client_whatsapp' => '081234567890',
                'groom_name'      => 'Budi',
                'bride_name'      => 'Siti',
                'event_date'      => now()->addDay()->toDateString(),
            ])
            ->assertRedirect(route('order.payment'));

        $order = Order::where('unique_code', 456)->firstOrFail();

        $this->assertSame(99456, (int) $order->total_amount);
        $this->assertDatabaseCount('orders', 2);
    }

    public function test_order_total_uses_same_effective_price_as_form(): void
    {
        $theme = Theme::create([
            'name'        => 'Free Promo Theme',
            'slug'        => 'free-promo-' . Str::random(8),
            'view_path'   => 'themes.test.index',
            'is_active'   => true,
            'price'       => 99000,
            'promo_price' => 0,
        ]);

        $this->app->bind(OrderService::class, function () {
            return new class extends OrderService {
                public function generateUniqueCode(): int
                {
                    return 321;
                }

                public function generateOrderNumber(): string
                {
                    return 'TRX-ZERO-PROMO';
                }
            };
        });

        $this->from(route('order.create'))
            ->post(route('order.store'), [
                'slug'            => 'order-zero-' . Str::random(8),
                'theme_id'        => $theme->id,
                'client_whatsapp' => '081234567890',
                'groom_name'      => 'Budi',
                'bride_name'      => 'Siti',
                'event_date'      => now()->addDay()->toDateString(),
            ])
            ->assertRedirect(route('order.payment'));

        $order = Order::where('unique_code', 321)->firstOrFail();

        $this->assertSame(321, (int) $order->total_amount);
    }

    public function test_payment_view_labels_unique_code_as_addition_not_discount(): void
    {
        $theme = $this->createTheme();
        $user = User::factory()->create();
        $order = Order::create([
            'order_number' => 'TRX-PAYMENT-LABEL',
            'theme_id'     => $theme->id,
            'user_id'      => $user->id,
            'unique_code'  => 123,
            'total_amount' => 99123,
            'status'       => 'pending',
            'expired_at'   => now()->addHour(),
        ]);
        $order->setRelation('theme', $theme);
        $order->dynamic_qris = 'test-qris';

        $this->view('order.payment', ['order' => $order])
            ->assertSee('Kode Unik Pembayaran', false)
            ->assertSee('+Rp 123', false)
            ->assertDontSee('Promo Spesial', false)
            ->assertDontSee('-Rp 123', false);
    }

    public function test_signed_storage_image_url_serves_file(): void
    {
        $url = $this->fakeSignedImageUrl('hero.jpg');

        $response = $this->get($url)
            ->assertOk()
            ->assertContent('fake-image');

        $cacheControl = $response->headers->get('Cache-Control');

        $this->assertStringContainsString('public', $cacheControl);
        $this->assertStringContainsString('max-age=3600', $cacheControl);
    }

    public function test_storage_image_route_requires_valid_signature(): void
    {
        [$uuid, $filename] = $this->fakeSignedImage('hero.jpg');

        $this->get(route('storage.images', ['uuid' => $uuid, 'filename' => $filename]))
            ->assertForbidden();
    }

    public function test_signed_storage_image_uses_dedicated_throttle_bucket(): void
    {
        config(['temanten.signed_image_rate_limit' => 2]);

        $url = $this->fakeSignedImageUrl('hero.jpg');
        $clientIp = '203.0.113.80';

        $this->withServerVariables(['REMOTE_ADDR' => $clientIp])->get($url)->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => $clientIp])->get($url)->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => $clientIp])->get($url)->assertTooManyRequests();
    }

    public function test_gallery_delete_moves_photo_to_trash_without_physical_delete(): void
    {
        Storage::fake('public');
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $keepPath = "storage/invitations/{$invitation->id}/keep.jpg";
        $deletePath = "storage/invitations/{$invitation->id}/delete.jpg";

        Storage::disk('public')->put("invitations/{$invitation->id}/delete.jpg", 'fake-image');

        $invitation->forceFill([
            'content' => [
                'mempelai' => [
                    'pria' => ['nama' => 'A'],
                    'wanita' => ['nama' => 'B'],
                ],
                'media' => [
                    'gallery' => [$keepPath, $deletePath],
                    'gallery_trash' => [],
                ],
            ],
        ])->save();

        $this->actingAs($owner)
            ->put(route('client.updateSettings'), [
                'groom_name' => 'A',
                'bride_name' => 'B',
                'delete_gallery' => [1],
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $invitation->refresh();

        $this->assertSame([$keepPath], $invitation->content['media']['gallery']);
        $this->assertSame([$deletePath], $invitation->content['media']['gallery_trash']);
        Storage::disk('public')->assertExists("invitations/{$invitation->id}/delete.jpg");
    }

    public function test_gallery_restore_moves_photo_from_trash_back_to_gallery(): void
    {
        [$owner, $other, $invitation] = $this->createOwnedInvitation();

        $keepPath = "storage/invitations/{$invitation->id}/keep.jpg";
        $deletedPath = "storage/invitations/{$invitation->id}/deleted.jpg";

        $invitation->forceFill([
            'content' => [
                'mempelai' => [
                    'pria' => ['nama' => 'A'],
                    'wanita' => ['nama' => 'B'],
                ],
                'media' => [
                    'gallery' => [$keepPath],
                    'gallery_trash' => [$deletedPath],
                ],
            ],
        ])->save();

        $this->actingAs($owner)
            ->put(route('client.updateSettings'), [
                'groom_name' => 'A',
                'bride_name' => 'B',
                'restore_gallery' => [0],
            ])
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $invitation->refresh();

        $this->assertSame([$keepPath, $deletedPath], $invitation->content['media']['gallery']);
        $this->assertSame([], $invitation->content['media']['gallery_trash']);
    }

    private function createOwnedInvitation(): array
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $theme = $this->createTheme();

        $invitation = Invitation::create([
            'uuid'            => (string) Str::uuid(),
            'theme_id'        => $theme->id,
            'user_id'         => $owner->id,
            'slug'            => 'test-undangan-' . Str::random(8),
            'client_whatsapp' => '6281234567890',
            'status'          => 'active',
            'event_date'      => now()->addDay(),
            'content'         => ['mempelai' => ['pria' => ['nama' => 'A'], 'wanita' => ['nama' => 'B']]],
        ]);

        return [$owner, $other, $invitation];
    }

    private function createTheme(): Theme
    {
        return Theme::create([
            'name'      => 'Test Theme',
            'slug'      => 'test-theme-' . Str::random(8),
            'view_path' => 'themes.test.index',
            'is_active' => true,
            'price'     => 99000,
        ]);
    }

    private function fakeSignedImageUrl(string $filename): string
    {
        [$uuid, $storedFilename] = $this->fakeSignedImage($filename);

        return URL::signedRoute('storage.images', ['uuid' => $uuid, 'filename' => $storedFilename]);
    }

    private function fakeSignedImage(string $filename): array
    {
        config(['filesystems.default' => 'local']);
        Storage::fake('local');

        $uuid = (string) Str::uuid();

        Storage::put("public/invitations/{$uuid}/{$filename}", 'fake-image');

        return [$uuid, $filename];
    }

    private function resetSchema(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('guests');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('invitations');
        Schema::dropIfExists('themes');
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('client');
            $table->rememberToken();
            $table->timestamps();
        });

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

        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('theme_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('unique_code')->unique();
            $table->bigInteger('total_amount');
            $table->string('status')->default('pending');
            $table->timestamp('expired_at');
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
            $table->string('address')->nullable();
            $table->unsignedInteger('jumlah_tamu')->default(1);
            $table->string('phone_number')->nullable();
            $table->string('rsvp_status')->default('pending');
            $table->text('comment')->nullable();
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
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }
}