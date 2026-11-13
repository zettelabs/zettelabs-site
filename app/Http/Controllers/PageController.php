<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function adsTxt(): Response
    {
        return response("google.com, pub-3571406260581518, DIRECT, f08c47fec0942fa0\n")
            ->header('Content-Type', 'text/plain');
    }

    public function sitemap(): Response
    {
        $urls = [route('home'), route('privacy'), route('terms'), ...array_map(fn (string $slug) => route('apps.show', $slug), array_keys(config('apps'))), ...array_map(fn (string $exam) => route('exams.show', $exam), array_keys(config('exams')))];

        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            . implode('', array_map(fn (string $u) => '<url><loc>' . e($u) . '</loc></url>', $urls))
            . '</urlset>';

        return response($xml)->header('Content-Type', 'application/xml');
    }

    public function home(): View
    {
        $apps = array_map(
            fn (array $app) => [...$app, 'shot' => $this->localizedImage($app['screenshots'][0])],
            config('apps'),
        );

        return view('home', ['apps' => $apps]);
    }

    public function privacy(): View
    {
        return view('legal.privacy');
    }

    public function terms(): View
    {
        return view('legal.terms');
    }

    public function llmsTxt(): Response
    {
        $text = <<<TXT
        # Zettelabs

        > Zettelabs is an independent studio building small, focused Android apps that solve one everyday problem each. The apps are free and ad-supported; photo and alarm data stays on the device.

        ## Apps

        - [Background Wizard]({bw}): remove, replace or blur photo backgrounds on Android.
        - [CleanPix]({cp}): find duplicate and similar photos and free up space.
        - [CirclePix]({ci}): turn a photo into a profile picture with a cut-out subject in a styled circle.
        - [Simple Alarm]({sa}): a simple, customizable alarm app.

        ## Policies

        - [Privacy policy]({privacy})
        - [Terms of use]({terms})

        ## Contact

        zettelabs@gmail.com
        TXT;

        return response(strtr($text, [
            '{bw}' => route('apps.show', 'background-wizard'), '{cp}' => route('apps.show', 'cleanpix'),
            '{ci}' => route('apps.show', 'circlepix'), '{sa}' => route('apps.show', 'simple-alarm'),
            '{privacy}' => route('privacy'), '{terms}' => route('terms'),
        ]))->header('Content-Type', 'text/plain; charset=utf-8');
    }

    public function app(string $slug): View
    {
        $app = config("apps.{$slug}");

        abort_unless($app, 404);

        $app['screenshots'] = array_map($this->localizedImage(...), $app['screenshots']);
        $app['banner'] = $this->localizedImage("banner-{$slug}.webp");

        return view("apps.{$slug}", ['app' => $app]);
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

    public function exam(string $exam): View
    {
        app()->setLocale('tr');

        $data = config("exams.{$exam}");
        $sessions = array_map(fn (string $at) => Carbon::parse($at, 'Europe/Istanbul'), $data['sessions']);
        // Count down to the next session; once all are past, keep the last one (page then says it is over).
        $next = collect($sessions)->first(fn (Carbon $at) => $at->isFuture()) ?? end($sessions);

        return view('exams.show', [
            'exam' => $exam,
            'data' => $data,
            'sessions' => $sessions,
            'next' => $next,
            'cta' => config('apps.sinavsayaci.play_store') ?? route('apps.show', 'sinavsayaci'),
        ]);
    }

    public function legacyPrivacy(string $appName): View
    {
        return view('legal.legacy', ['appName' => $appName]);
    }

    public function backgroundWizardPrivacy(): View
    {
        return view('legal.background-wizard');
    }

    public function cleanpixPrivacy(): View
    {
        return view('legal.cleanpix');
    }

    public function simpleAlarmPrivacy(): View
    {
        return view('legal.simple-alarm');
    }

    public function circlepixPrivacy(): View
    {
        return view('legal.circlepix');
    }
}
