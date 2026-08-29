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

        return view('apps.show', ['app' => $app]);
    }

    public function legacyPrivacy(string $appName): View
    {
        return view('legal.legacy', ['appName' => $appName]);
    }
}
