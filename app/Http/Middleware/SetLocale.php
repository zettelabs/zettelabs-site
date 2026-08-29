<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @var array<int, string>
     */
    private const SUPPORTED_LOCALES = ['en', 'tr'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale', 'en');

        if (in_array($locale, self::SUPPORTED_LOCALES, true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
