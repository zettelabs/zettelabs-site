@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    $t = fn (string $key) => __("simple-alarm.{$key}");
    // Zigzag edge for paper sheets: teeth across the width, `$top`/`$bottom` cut.
    $zigzag = function (bool $top, bool $bottom, int $teeth = 32, int $depth = 10) {
        $n = $teeth * 2;
        $points = [];
        for ($i = 0; $i <= $n; $i++) {
            $points[] = round($i / $n * 100, 3) . '% ' . ($top && $i % 2 ? "{$depth}px" : '0');
        }
        for ($i = $n; $i >= 0; $i--) {
            $points[] = round($i / $n * 100, 3) . '% ' . ($bottom && $i % 2 ? "calc(100% - {$depth}px)" : '100%');
        }

        return 'polygon(' . implode(', ', $points) . ')';
    };
    $screens = $t('screens');
    $copy = [
        'locale' => app()->getLocale(),
        'days' => $t('days'),
        'day' => $t('unit_day'),
        'hour' => $t('unit_hour'),
        'min' => $t('unit_min'),
        'ringsIn' => $t('rings_in'),
    ];
@endphp

@section('content')
<style>
    .sa {
        --sa-ground: #121214;
        --sa-ink: #f4f3f0;
        --sa-muted: #bdb8ae;
        --sa-paper: #eae8e3;
        --sa-paper-2: #dbd8d1;
        --sa-paper-ink: #17171a;
        --sa-paper-muted: #55525a;
        --sa-band-1: #1d1e22;
        --sa-band-2: #2a2b30;
        --sa-amber: #ffb547;
        --sa-amber-deep: #f29f22;
        --sa-xl: clamp(3.5rem, 8vw, 8rem);
        --sa-l: clamp(2.25rem, 4vw, 3.5rem);
        --sa-m: 1.5rem;
        --sa-body: 1.125rem;
        --sa-small: 0.9375rem;
        background: var(--sa-ground);
        color: var(--sa-ink);
        font-size: var(--sa-body);
        line-height: 1.55;
    }
    .sa .tnum { font-variant-numeric: tabular-nums; }
    .sa-wrap { margin-inline: auto; max-width: 72rem; padding-inline: 1.5rem; }
    .sa-h-xl { font-size: var(--sa-xl); font-weight: 800; letter-spacing: -0.035em; line-height: 0.92; }
    .sa-h-l { font-size: var(--sa-l); font-weight: 700; letter-spacing: -0.025em; line-height: 1.02; text-wrap: balance; }
    .sa-m { font-size: var(--sa-m); line-height: 1.25; }
    .sa-small { font-size: var(--sa-small); line-height: 1.5; }

    /* One button shape for the page: square corners, one fill. */
    .sa-btn {
        display: inline-flex; align-items: center; justify-content: center; min-height: 3.5rem;
        padding: 0 1.75rem; font-weight: 700; transition: transform .15s ease-out, background-color .15s ease-out;
    }
    .sa-btn:active { transform: scale(.97); }
    .sa-btn-ink { background: var(--sa-paper-ink); color: var(--sa-paper); }
    .sa-btn-ink:hover { background: #2e2e33; }
    .sa-btn-amber { background: var(--sa-amber); color: var(--sa-paper-ink); }
    .sa-btn-amber:hover { background: var(--sa-amber-deep); }
    .sa a:focus-visible, .sa button:focus-visible, .sa input:focus-visible { outline: 3px solid var(--sa-amber); outline-offset: 3px; }
    .sa-paperish a:focus-visible, .sa-paperish button:focus-visible, .sa-amberish a:focus-visible, .sa-amberish button:focus-visible, .sa-amberish input:focus-visible { outline-color: var(--sa-paper-ink); }

    /* Hero: the sunrise, then the alarm cards stacked like tabbed folders. */
    .sa-hero { position: relative; display: flex; flex-direction: column; min-height: calc(100svh - 4.5rem); isolation: isolate; overflow: hidden; }
    /* On narrow screens the photo runs taller than the hero so the sun sets just above the tabs, clear of the words. */
    .sa-hero-photo { position: absolute; inset: 0 0 auto; z-index: -1; width: 100%; height: 125%; object-fit: cover; object-position: 50% 0; }
    @media (min-width: 768px) { .sa-hero-photo { height: 100%; object-position: 50% 30%; } }
    .sa-hero-head { padding: 4.5rem 1.5rem 0; text-align: center; }
    .sa-hero-head h1 { text-transform: uppercase; }
    .sa-hero-head p { max-width: 30ch; margin: 2.25rem auto 0; font-size: var(--sa-m); line-height: 1.35; font-weight: 500; }
    .sa-folders { margin-top: auto; padding-top: 6rem; }
    .sa-band { position: relative; width: 100%; margin-inline: auto; }
    .sa-band-strip { height: 3.25rem; }
    /* The tab runs 4px down into its own band, so the hover lift shows more tab, never a gap. */
    .sa-tab {
        position: absolute; bottom: calc(100% - 4px); height: calc(2rem + 4px); padding: 0 1.25rem 4px; display: flex; align-items: center;
        font-size: var(--sa-small); font-weight: 700; background: inherit; color: inherit;
        clip-path: polygon(.75rem 0, calc(100% - .75rem) 0, 100% 100%, 0 100%);
        transition: transform .2s cubic-bezier(.2,.7,.2,1);
    }
    @media (hover: hover) { .sa-tab:hover { transform: translateY(-4px); } }
    /* The front tab never sits over the big time: right on a phone, far left on desktop. */
    .sa-band:nth-child(1) .sa-tab { right: 1rem; }
    .sa-band:nth-child(2) .sa-tab { left: 50%; translate: -50% 0; }
    .sa-band:nth-child(3) .sa-tab { left: 1rem; }
    .sa-band:nth-child(4) .sa-tab { right: 1rem; }
    .sa-amberish { background: var(--sa-amber); color: var(--sa-paper-ink); }
    .sa-paperish { background: var(--sa-paper); color: var(--sa-paper-ink); }
    .sa-front { padding: 1.5rem 1rem 2.5rem; display: flex; flex-direction: column; gap: 1.75rem; }
    .sa-front .sa-btn { width: 100%; }
    /* Below desktop the time is a line of the card, not a second title under the button. */
    .sa-next-time { font-size: var(--sa-m); font-weight: 700; line-height: 1.25; }
    @media (min-width: 1024px) {
        .sa-band, .sa-panel { width: 86%; }
        .sa-band-strip { height: 4rem; }
        .sa-tab { height: calc(2.5rem + 4px); padding: 0 1.75rem 4px; font-size: var(--sa-body); clip-path: polygon(1rem 0, calc(100% - 1rem) 0, 100% 100%, 0 100%); }
        .sa-band:nth-child(1) .sa-tab { right: auto; left: 78%; }
        .sa-band:nth-child(2) .sa-tab { left: 56%; translate: none; }
        .sa-band:nth-child(3) .sa-tab { left: 30%; }
        .sa-band:nth-child(4) .sa-tab { right: auto; left: 4%; }
        .sa-front { flex-direction: row; align-items: flex-start; justify-content: space-between; padding: 2rem 0 3rem; }
        .sa-front .sa-btn { width: auto; }
        .sa-next-time { font-size: var(--sa-l); letter-spacing: -0.02em; line-height: 1; }
    }

    /* Screens: the open front folder carries on; one plate, the index beside it. */
    .sa-panel { margin-inline: auto; }
    .sa-plate { position: relative; aspect-ratio: 1; background: var(--sa-band-1); overflow: hidden; }
    .sa-plate img {
        position: absolute; top: 6%; left: 50%; height: 88%; width: auto; aspect-ratio: 9 / 16; translate: -50% 0;
        opacity: 0; transition: opacity 0s .2s;
    }
    /* The new screen fades in on top while the old one holds underneath, so the plate never dims. */
    .sa-plate img.is-on { opacity: 1; z-index: 1; transition: opacity .2s cubic-bezier(.2,.7,.2,1); }
    .sa-plate img:first-child { position: relative; display: block; }
    .sa-index button { display: block; width: 100%; padding: .875rem 1rem; text-align: left; color: var(--sa-paper-muted); transition: background-color .15s ease-out, color .15s ease-out; }
    .sa-index button[aria-pressed='true'] { background: var(--sa-paper-2); color: var(--sa-paper-ink); }
    .sa-index button:hover { color: var(--sa-paper-ink); }
    .sa-index strong { display: block; font-size: var(--sa-m); line-height: 1.25; }
    .sa-cells { display: grid; grid-template-columns: 1fr 1fr; }
    .sa-cells a { min-height: 4.5rem; display: flex; align-items: center; padding: 0 1.25rem; font-weight: 700; transition: background-color .15s ease-out; }
    .sa-cell-2 { background: var(--sa-paper-2); }
    .sa-cell-2:hover { background: #cfccc4; }

    /* Settings: a menu sheet with dotted leaders. */
    .sa-sheet { padding: 3.5rem 1.25rem; }
    .sa-row { display: flex; align-items: baseline; gap: .75rem; }
    .sa-row .sa-lead { flex: 1; min-width: 1.5rem; border-bottom: 4px dotted var(--sa-paper-muted); translate: 0 -.3em; }
    @media (min-width: 768px) { .sa-sheet { padding: 4rem 3rem; } }

    /* A morning: the slip over the sea. */
    .sa-morning { position: relative; isolation: isolate; background: var(--sa-band-2); }
    /* Mirrored so the open sea sits behind the heading and the cliff behind the slip. */
    .sa-morning video { position: absolute; inset: 0; z-index: -1; width: 100%; height: 100%; object-fit: cover; object-position: 80% 60%; transform: scaleX(-1); }
    .sa-morning::after { content: ''; position: absolute; inset: 0; z-index: -1; background: rgb(18 18 20 / .7); }
    .sa-waves-toggle {
        position: absolute; right: 1rem; bottom: 1rem; display: flex; align-items: center; gap: .5rem; min-height: 2.75rem; padding: 0 1rem;
        border: 1px solid rgb(244 243 240 / .3); color: var(--sa-muted); font-size: var(--sa-small); font-weight: 600;
        transition: background-color .15s ease-out, color .15s ease-out;
    }
    .sa-waves-toggle:hover { color: var(--sa-ink); }
    .sa-waves-toggle[aria-pressed='true'] { background: var(--sa-ink); color: var(--sa-ground); }
    .sa-slip { padding: 2.5rem 1.25rem 3.5rem; }
    .sa-slip-total { display: flex; justify-content: space-between; align-items: center; min-height: 2.75rem; padding: 0 1rem; margin-inline: -1rem; background: var(--sa-paper-ink); color: var(--sa-paper); font-weight: 700; }
    @media (min-width: 768px) { .sa-slip { padding: 3rem 2.5rem 4rem; } .sa-slip-total { margin-inline: -2.5rem; padding: 0 2.5rem; } }

    /* Set one: the app's own edit dialog, live. Its borders and shadow are the app's. */
    .sa-dialog { background: #1c1d21; color: var(--sa-ink); border-radius: 1.75rem; padding: 1.5rem; box-shadow: 0 30px 60px -20px rgb(0 0 0 / .45); }
    .sa-dialog input[type='time'] {
        width: 100%; background: #26272c; border-radius: 1rem; padding: .5rem 1rem; text-align: center; color: var(--sa-ink);
        font-size: var(--sa-l); font-weight: 600; font-variant-numeric: tabular-nums; color-scheme: dark;
    }
    .sa-dialog input[type='text'] { width: 100%; background: transparent; border: 1px solid #55565c; border-radius: .75rem; padding: .75rem 1rem; color: var(--sa-ink); }
    .sa-chip {
        height: 2.75rem; min-width: 2.75rem; padding: 0 .5rem; border-radius: 999px; background: #2c2d33; color: var(--sa-ink);
        font-size: var(--sa-small); font-weight: 600; transition: background-color .15s ease-out, transform .15s ease-out;
    }
    .sa-chip:active { transform: scale(.94); }
    .sa-chip[aria-pressed='true'] { background: var(--sa-amber); color: var(--sa-paper-ink); }
    .sa-preset { height: 2.5rem; padding: 0 1rem; border-radius: 999px; border: 1px solid #44454b; font-size: var(--sa-small); transition: border-color .15s ease-out, color .15s ease-out; }
    .sa-preset[aria-pressed='true'] { border-color: var(--sa-amber); color: var(--sa-amber); }
    .sa-dialog .sa-btn { width: 100%; border-radius: 999px; }
    .sa-dialog .sa-btn:focus-visible { outline-color: var(--sa-ink); }

    @media (prefers-reduced-motion: reduce) {
        .sa-plate img, .sa-plate img.is-on, .sa-tab, .sa-index button { transition: none; }
        .sa-tab:hover, .sa-btn:active, .sa-chip:active { transform: none; }
    }
</style>

<div class="sa" data-sa='@json($copy)'>

    {{-- Hero --}}
    <section class="sa-hero">
        <img src="{{ asset('images/apps/simple-alarm-black-sea-sunrise.webp') }}" alt="" width="1600" height="1200" class="sa-hero-photo" fetchpriority="high">
        <div class="sa-hero-head">
            {{-- lang="en": the uppercase brand name must not take Turkish dotted İ. --}}
            <h1 class="sa-h-xl rise" lang="en">{{ $app['name'] }}</h1>
            <p class="rise" style="--i: 1">{{ $t('lead') }}</p>
        </div>

        <div class="sa-folders">
            <div class="sa-band sa-amberish">
                <a href="#set" class="sa-tab">{{ $t('tab_set') }}</a>
                <div class="sa-band-strip"></div>
            </div>
            <div class="sa-band" style="background: var(--sa-band-2)">
                <a href="#morning" class="sa-tab">{{ $t('tab_morning') }}</a>
                <div class="sa-band-strip"></div>
            </div>
            <div class="sa-band" style="background: var(--sa-band-1)">
                <a href="#settings" class="sa-tab">{{ $t('tab_settings') }}</a>
                <div class="sa-band-strip"></div>
            </div>
            <div class="sa-band sa-paperish">
                <a href="#screens" class="sa-tab">{{ $t('tab_screens') }}</a>
                <div class="sa-wrap sa-front">
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="sa-btn sa-btn-ink">{{ $t('play') }}</a>
                    <div class="lg:text-right">
                        <p class="sa-next-time tnum" data-sa-time>{{ $t('time') }}</p>
                        <p class="mt-2 tnum"><span data-sa-name>{{ $t('alarm_name') }}</span> · <span data-sa-left>{{ $t('next_fallback') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Screens: the front folder, open --}}
    <section id="screens" class="sa-panel sa-paperish scroll-mt-6">
        <div class="sa-wrap grid gap-10 pt-8 pb-16 lg:grid-cols-12 lg:gap-6 lg:pb-28">
            <div class="lg:col-span-5 lg:col-start-8 lg:row-start-1">
                <h2 class="sa-h-l">{{ $t('screens_title') }}</h2>
                <p class="mt-5 max-w-[34ch]">{{ $t('screens_text') }}</p>
            </div>
            <div class="lg:col-span-6 lg:row-span-2 lg:row-start-1">
                <div class="sa-plate" data-reveal>
                    @foreach ($app['screenshots'] as $i => $shot)
                        <img src="{{ asset($shot) }}" alt="{{ $screens[$i][2] }}" width="540" height="960" @if ($i) loading="lazy" @endif @class(['is-on' => $i === 0]) data-sa-plate>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col justify-end gap-10 lg:col-span-6 lg:col-start-7">
                <ul class="sa-index">
                    @foreach ($screens as $i => [$title, $line])
                        <li>
                            <button type="button" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}" data-sa-shot="{{ $i }}">
                                <strong>{{ $title }}</strong>
                                <span class="sa-small">{{ $line }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="sa-cells">
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="sa-btn-ink">{{ $t('play') }}</a>
                    <a href="{{ $app['privacy_url'] }}" class="sa-cell-2">{{ $t('privacy') }}</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Settings --}}
    <section id="settings" class="mt-24 py-24 md:py-28" style="background: var(--sa-band-1)">
        <div class="sa-wrap grid gap-12 md:grid-cols-12 md:gap-6">
            <div class="sa-sheet sa-paperish md:col-span-7" style="clip-path: {{ $zigzag(true, true) }}" data-reveal>
                <h2 class="sa-h-l text-center">{{ $t('settings_title') }}</h2>
                @foreach ($t('settings') as $group => $items)
                    <h3 class="mt-11 text-xl font-bold">{{ $group }}</h3>
                    <ul class="mt-4 space-y-[18px]">
                        @foreach ($items as [$name, $value, $note])
                            <li>
                                <div class="sa-row"><span class="font-semibold">{{ $name }}</span><span class="sa-lead" aria-hidden="true"></span><span class="tnum whitespace-nowrap">{{ $value }}</span></div>
                                <p class="sa-small mt-1 max-w-[34ch]" style="color: var(--sa-paper-muted)">{{ $note }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
            <div class="md:col-span-4 md:col-start-9">
                <img src="{{ asset($app['screenshots'][2]) }}" alt="{{ $t('settings_shot_alt') }}" width="540" height="960" loading="lazy" class="aspect-[9/13] w-full object-cover object-bottom md:sticky md:top-12" data-reveal>
            </div>
        </div>
    </section>

    {{-- A morning --}}
    <section id="morning" class="sa-morning py-24 md:py-40">
        <video muted loop playsinline preload="metadata" poster="{{ asset('images/apps/simple-alarm-waves-poster.webp') }}" width="854" height="480" aria-hidden="true" data-sa-video>
            <source src="{{ asset('images/apps/simple-alarm-waves.webm') }}" type="video/webm">
        </video>
        <div class="sa-wrap grid gap-12 md:grid-cols-12 md:gap-6">
            <div class="md:col-span-5">
                <h2 class="sa-h-l">{{ $t('morning_title') }}</h2>
                <p class="mt-6 max-w-[30ch]">{{ $t('morning_text') }}</p>
            </div>
            <div class="sa-slip sa-paperish tnum md:col-span-6 md:col-start-7 lg:col-span-5 lg:col-start-7" style="clip-path: {{ $zigzag(false, true, 18, 12) }}" data-reveal>
                @foreach ($t('morning') as $when => $rows)
                    <h3 @class(['font-bold', 'mt-7' => ! $loop->first])>{{ $when }}</h3>
                    <ul class="mt-2 space-y-2">
                        @foreach ($rows as [$what, $at])
                            <li class="sa-row"><span>{{ $what }}</span><span class="sa-lead" aria-hidden="true"></span><span class="whitespace-nowrap">{{ $at }}</span></li>
                        @endforeach
                    </ul>
                @endforeach
                <p class="sa-slip-total mt-8"><span>{{ $t('morning_total')[0] }}</span><span>{{ $t('morning_total')[1] }}</span></p>
            </div>
        </div>
        <button type="button" class="sa-waves-toggle" aria-pressed="false" data-sa-waves>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="currentColor" aria-hidden="true"><rect x="2" y="1.5" width="2.5" height="9"/><rect x="7.5" y="1.5" width="2.5" height="9"/></svg>
            {{ $t('waves_pause') }}
        </button>
    </section>

    {{-- Set one --}}
    <section id="set" class="sa-amberish py-20 md:py-32">
        <div class="sa-wrap grid min-h-[70svh] gap-12 lg:grid-cols-12 lg:gap-6">
            <div class="self-end lg:col-span-7">
                <h2 class="sa-h-xl">{{ $t('set_title') }}</h2>
                <p class="mt-8 max-w-[38ch]">{{ $t('set_text') }}</p>
            </div>
            <div class="self-center md:max-w-[28rem] lg:col-span-5 lg:max-w-none" data-reveal>
                <form class="sa-dialog" data-ui onsubmit="return false">
                    <p class="text-center font-semibold">{{ $t('dialog_title') }}</p>
                    <label class="mt-5 block">
                        <span class="sr-only">{{ $t('dialog_time') }}</span>
                        <input type="time" value="06:30" required data-sa-input>
                    </label>
                    <fieldset class="mt-5">
                        <legend class="sa-small font-semibold">{{ $t('dialog_repeat') }}</legend>
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach ($t('days') as $d => $day)
                                <button type="button" class="sa-chip" aria-pressed="{{ $d < 5 ? 'true' : 'false' }}" data-sa-day="{{ $d }}">{{ $day }}</button>
                            @endforeach
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button" class="sa-preset" aria-pressed="true" data-sa-preset="0,1,2,3,4">{{ $t('preset_weekdays') }}</button>
                            <button type="button" class="sa-preset" aria-pressed="false" data-sa-preset="0,1,2,3,4,5,6">{{ $t('preset_daily') }}</button>
                            <button type="button" class="sa-preset" aria-pressed="false" data-sa-preset="">{{ $t('preset_once') }}</button>
                        </div>
                    </fieldset>
                    <label class="mt-5 block">
                        <span class="sa-small font-semibold">{{ $t('dialog_name') }}</span>
                        <input type="text" value="{{ $t('alarm_name') }}" maxlength="24" class="mt-2" data-sa-name-input>
                    </label>
                    <p class="mt-5 text-center tnum" style="color: var(--sa-amber)" aria-live="polite" data-sa-left>{{ $t('next_fallback') }}</p>
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="sa-btn sa-btn-amber mt-5">{{ $t('play') }}</a>
                </form>
            </div>
        </div>
    </section>

    {{-- Close --}}
    <section class="pt-28 pb-16 md:pt-40">
        <div class="sa-wrap">
            <h2 class="sa-h-xl">{{ $app['name'] }}</h2>
            <div class="mt-16 grid gap-12 md:grid-cols-12 md:gap-6">
                <ul class="sa-m space-y-3 font-semibold md:col-span-5" style="color: var(--sa-amber)">
                    <li><a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="underline decoration-transparent underline-offset-4 transition-colors hover:decoration-current">Google Play</a></li>
                    <li><a href="{{ $app['privacy_url'] }}" class="underline decoration-transparent underline-offset-4 transition-colors hover:decoration-current">{{ $t('privacy') }}</a></li>
                    <li><a href="mailto:zettelabs@gmail.com" class="underline decoration-transparent underline-offset-4 transition-colors hover:decoration-current">zettelabs@gmail.com</a></li>
                </ul>
                <div class="sa-small grid grid-cols-2 gap-8 md:col-span-6 md:col-start-7 md:grid-cols-3">
                    <div>
                        <h3 class="font-bold">{{ $t('more_apps') }}</h3>
                        <ul class="mt-3 space-y-2" style="color: var(--sa-muted)">
                            @foreach (['background-wizard', 'cleanpix', 'circlepix'] as $other)
                                <li><a href="{{ route('apps.show', $other) }}" class="transition-colors hover:text-[var(--sa-ink)]">{{ config("apps.{$other}.name") }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold">{{ $t('studio') }}</h3>
                        <ul class="mt-3 space-y-2" style="color: var(--sa-muted)">
                            <li><a href="{{ route('home') }}" class="transition-colors hover:text-[var(--sa-ink)]">{{ $t('home') }}</a></li>
                            <li><a href="{{ route('privacy') }}" class="transition-colors hover:text-[var(--sa-ink)]">{{ __('Gizlilik') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <h3 class="font-bold">{{ $t('pictures') }}</h3>
                        <ul class="mt-3 space-y-2" style="color: var(--sa-muted)">
                            <li><a href="https://commons.wikimedia.org/wiki/File:Sunrise_over_the_Black_Sea.jpg" class="transition-colors hover:text-[var(--sa-ink)]">{{ $t('credit_photo') }}</a></li>
                            <li><a href="https://commons.wikimedia.org/wiki/File:Ocean_waves_at_L%C3%A6kjavik_beach,_Iceland.webm" class="transition-colors hover:text-[var(--sa-ink)]">{{ $t('credit_video') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    (() => {
        const root = document.querySelector('[data-sa]');
        const copy = JSON.parse(root.dataset.sa);
        const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Screens index: pointing at, focusing or tapping a row shows its screen in the plate.
        const plates = root.querySelectorAll('[data-sa-plate]');
        const rows = root.querySelectorAll('[data-sa-shot]');
        const show = (n) => {
            plates.forEach((img, i) => img.classList.toggle('is-on', i === n));
            rows.forEach((row, i) => row.setAttribute('aria-pressed', i === n));
        };
        rows.forEach((row) => {
            const n = Number(row.dataset.saShot);
            ['pointerenter', 'focus', 'click'].forEach((type) => row.addEventListener(type, () => show(n)));
        });

        // The alarm: one time and a set of weekdays (0 = Monday); none means once.
        const input = root.querySelector('[data-sa-input]');
        const days = new Set([0, 1, 2, 3, 4]);
        const timeFormat = new Intl.DateTimeFormat(copy.locale, { hour: copy.locale === 'en' ? 'numeric' : '2-digit', minute: '2-digit' });

        const nextRing = (now, hh, mm) => {
            for (let d = 0; d <= 7; d++) {
                const at = new Date(now.getFullYear(), now.getMonth(), now.getDate() + d, hh, mm);
                if (at > now && (!days.size || days.has((at.getDay() + 6) % 7))) return at;
            }
        };

        const render = () => {
            const [hh, mm] = (input.value || '06:30').split(':').map(Number);
            const now = new Date();
            const at = nextRing(now, hh, mm);
            const mins = Math.ceil((at - now) / 60000);
            const parts = [
                [Math.floor(mins / 1440), copy.day],
                [Math.floor((mins % 1440) / 60), copy.hour],
                [mins % 60, copy.min],
            ].filter(([n], i) => n || i === 2).map(([n, unit]) => `${n} ${unit}`);
            const text = `${copy.ringsIn} ${parts.join(' ')} · ${copy.days[(at.getDay() + 6) % 7]}`;
            root.querySelectorAll('[data-sa-left]').forEach((el) => (el.textContent = text));
            root.querySelectorAll('[data-sa-time]').forEach((el) => (el.textContent = timeFormat.format(at)));
            root.querySelectorAll('[data-sa-day]').forEach((chip) => chip.setAttribute('aria-pressed', days.has(Number(chip.dataset.saDay))));
            const key = [...days].sort().join(',');
            root.querySelectorAll('[data-sa-preset]').forEach((p) => p.setAttribute('aria-pressed', p.dataset.saPreset === key));
        };

        input.addEventListener('input', render);
        root.querySelectorAll('[data-sa-day]').forEach((chip) => chip.addEventListener('click', () => {
            const d = Number(chip.dataset.saDay);
            days.has(d) ? days.delete(d) : days.add(d);
            render();
        }));
        root.querySelectorAll('[data-sa-preset]').forEach((p) => p.addEventListener('click', () => {
            days.clear();
            p.dataset.saPreset.split(',').filter(Boolean).forEach((d) => days.add(Number(d)));
            render();
        }));
        root.querySelector('[data-sa-name-input]').addEventListener('input', (e) => {
            root.querySelector('[data-sa-name]').textContent = e.target.value.trim() || '—';
        });
        render();
        setInterval(render, 30000);

        // The sea moves only while it is on screen and not paused; reduced motion starts it paused, on the poster.
        const video = root.querySelector('[data-sa-video]');
        const wavesToggle = root.querySelector('[data-sa-waves]');
        let paused = reduce;
        let inView = false;
        const syncWaves = () => {
            wavesToggle.setAttribute('aria-pressed', paused);
            paused || !inView ? video.pause() : video.play().catch(() => {});
        };
        wavesToggle.addEventListener('click', () => {
            paused = !paused;
            syncWaves();
        });
        new IntersectionObserver(([entry]) => {
            inView = entry.isIntersecting;
            syncWaves();
        }).observe(video.parentElement);
        syncWaves();
    })();
</script>
@endsection
