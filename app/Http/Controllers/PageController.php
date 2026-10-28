<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function adsTxt(): Response
    {
        return response("google.com, pub-3571406260581518, DIRECT, f08c47fec0942fa0\n")
            ->header('Content-Type', 'text/plain');
    }

    public function home(): View
    {
        return view('home', ['apps' => config('apps')]);
    }

    public function privacy(): View
    {
        return view('legal.privacy');
    }

    public function app(string $slug): View
    {
        $app = config("apps.{$slug}");

        abort_unless($app, 404);

        $app['screenshots'] = array_map($this->localizedImage(...), $app['screenshots']);
        $app['banner'] = $this->localizedImage("banner-{$slug}.webp");

        return view('apps.show', ['app' => $app]);
    }

    // English assets live in images/apps/en/; the root holds Turkish ones. Fall back either way.
    private function localizedImage(string $file): ?string
    {
        $dirs = app()->getLocale() === 'en' ? ['en/', ''] : ['', 'en/'];

        foreach ($dirs as $dir) {
            $path = public_path("images/apps/{$dir}{$file}");

            if (file_exists($path)) {
                // Version by content so replaced images bypass browser caches.
                return "images/apps/{$dir}{$file}?v=" . substr(md5_file($path), 0, 8);
            }
        }

        return null;
    }

    public function legacyPrivacy(string $appName): View
    {
        return view('legal.legacy', ['appName' => $appName]);
    }
}
