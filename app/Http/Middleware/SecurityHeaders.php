<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Add hardening response headers to every web response.
     * (CSP is intentionally left to the edge/Nginx config in deploy/, because the
     * Filament admin + inline handlers need a carefully-scoped policy.)
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            'X-Frame-Options'        => 'SAMEORIGIN',                       // clickjacking
            'X-Content-Type-Options' => 'nosniff',                          // MIME sniffing
            'Referrer-Policy'        => 'strict-origin-when-cross-origin',
            'Permissions-Policy'     => 'geolocation=(), microphone=(), camera=(), payment=()',
            'X-Permitted-Cross-Domain-Policies' => 'none',
        ];

        foreach ($headers as $key => $value) {
            if (! $response->headers->has($key)) {
                $response->headers->set($key, $value);
            }
        }

        // Strip version-leaking headers where possible.
        $response->headers->remove('X-Powered-By');

        // HSTS only over HTTPS (so local http dev is unaffected).
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}
