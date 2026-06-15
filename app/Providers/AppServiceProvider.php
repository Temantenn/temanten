<?php

namespace App\Providers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Policies\GuestPolicy;
use App\Policies\InvitationPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Invitation::class, InvitationPolicy::class);
        Gate::policy(Guest::class, GuestPolicy::class);

        RateLimiter::for('signed-images', function (Request $request) {
            $maxAttempts = max(1, (int) config('temanten.signed_image_rate_limit', 240));

            return Limit::perMinute($maxAttempts)->by('signed-images:'.$request->ip());
        });
    }
}
