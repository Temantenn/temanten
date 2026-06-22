<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware
 *
 * Menambahkan HTTP security headers ke semua response:
 *  - Strict-Transport-Security (HSTS)        : paksa HTTPS, cegah downgrade attack
 *  - X-Content-Type-Options                  : blokir MIME sniffing
 *  - X-Frame-Options                         : anti-clickjacking (DENY)
 *  - X-XSS-Protection                        : legacy XSS auditor (defense-in-depth)
 *  - Referrer-Policy                         : batasi info referrer ke external
 *  - Permissions-Policy                      : blokir fitur browser sensitif
 *  - Cross-Origin-Opener-Policy              : isolasi window (Spectre)
 *  - Cross-Origin-Resource-Policy            : kontrol resource loading
 *  - Content-Security-Policy (CSP)           : batasi source script/style (longgar untuk keep undangan interactive)
 *  - X-Powered-By removal                    : sembunyikan fingerprint
 *
 * Note: HSTS hanya dikirim saat request via HTTPS.
 *
 * Refs:
 *  - https://owasp.org/www-project-secure-headers/
 *  - https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // HSTS: aktif hanya kalau HTTPS (production)
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload',
                false  // replace = false agar tidak overwrite kalau sudah ada
            );
        }

        // Anti-MIME-sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff', false);

        // Anti-clickjacking — DENY = tidak boleh di-frame sama sekali
        $response->headers->set('X-Frame-Options', 'DENY', false);

        // Legacy XSS auditor (defense-in-depth, sebagian besar browser modern sudah ignore)
        $response->headers->set('X-XSS-Protection', '1; mode=block', false);

        // Referrer policy: hanya kirim origin untuk HTTPS request, no-referrer untuk HTTP
        $response->headers->set(
            'Referrer-Policy',
            $request->isSecure() ? 'strict-origin-when-cross-origin' : 'no-referrer',
            false
        );

        // Permissions Policy: blokir fitur browser yang tidak kita pakai
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()',
            false
        );

        // Cross-Origin policies
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin', false);
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin', false);

        // Content Security Policy — longgar supaya tema interaktif (YouTube embed, Unsplash, Google Fonts, Vite dev, inline scripts) tetap jalan
        // Untuk produksi strict, nanti bisa di-tighten per route
        $csp = $this->buildContentSecurityPolicy($request);
        $response->headers->set('Content-Security-Policy', $csp, false);

        // Hapus X-Powered-By untuk sembunyikan fingerprint
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }

    /**
     * Build CSP yang cukup longgar untuk fitur undangan:
     * - YouTube iframe embed
     * - Google Fonts
     * - Unsplash images
     * - Bunny CDN (untuk v1)
     * - Cloudflare R2 (untuk media)
     * - Inline scripts/styles (Alpine.js, theme animations)
     * - Vite HMR (dev only)
     *
     * @return string
     */
    protected function buildContentSecurityPolicy(Request $request): string
    {
        $isDev = config('app.debug');

        $directives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net https://www.youtube.com https://s.ytimg.com https://*.googletagmanager.com" . ($isDev ? " ws://localhost:* http://localhost:* http://127.0.0.1:*" : ""),
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://fonts.gstatic.com https://cdn.jsdelivr.net",
            "img-src 'self' data: blob: https: http:",  // https: + http: untuk cover Unsplash + tema gallery
            "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net https://unpkg.com https://cdn.jsdelivr.net",
            "media-src 'self' https: blob:",  // audio tema + video
            "frame-src 'self' https://www.youtube.com https://youtube.com https://www.youtube-nocookie.com",
            "connect-src 'self' https: wss: ws:" . ($isDev ? " ws://localhost:* http://localhost:* http://127.0.0.1:*" : ""),
            "worker-src 'self' blob:",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ];

        // Upgrade insecure requests hanya di production HTTPS
        if ($request->isSecure() && ! $isDev) {
            $directives[] = 'upgrade-insecure-requests';
        }

        return implode('; ', $directives);
    }
}
