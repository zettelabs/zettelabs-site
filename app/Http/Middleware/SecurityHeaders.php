<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // No includeSubDomains: thriftai.zettelabs.app is a separate deployment.
        // shortcut: no CSP, the Vite/font setup needs a tested policy first; add one when it is worth the testing.
        $response->headers->add([
            'Strict-Transport-Security' => 'max-age=31536000',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ]);
        header_remove('X-Powered-By');

        return $response;
    }
}
