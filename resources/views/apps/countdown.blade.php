@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    use Carbon\Carbon;

    $tr = app()->getLocale() === 'tr';
    $today = Carbon::today('Europe/Istanbul');
    $screen = fn (int $n) => asset(str_replace('shot-countdown-', 'screen-countdown-', $app['screenshots'][$n - 1]));

    // The app's own six free widget colours (Themes.kt), in its order; locked ones are left out.
    $themes = [
        'ink' => ['bg' => '#15161B', 'fg' => '#FFFFFF', 'accent' => '#CF6A48'],
        'paper' => ['bg' => '#FFFFFF', 'fg' => '#15161B', 'accent' => '#0E7C66'],
        'tangerine' => ['bg' => '#CF6A48', 'fg' => '#15161B', 'accent' => '#15161B'],
        'cobalt' => ['bg' => '#2446E0', 'fg' => '#FFFFFF', 'accent' => '#C9D3FF'],
        'mint' => ['bg' => '#0E7C66', 'fg' => '#FFFFFF', 'accent' => '#C8F0E4'],
        'lemon' => ['bg' => '#FFD84D', 'fg' => '#15161B', 'accent' => '#15161B'],
    ];
    $themeNames = ['ink' => 'Mürekkep', 'paper' => 'Kâğıt', 'tangerine' => 'Mandalina', 'cobalt' => 'Kobalt', 'mint' => 'Nane', 'lemon' => 'Limon'];

    // Templates as the app presets them (Templates.kt); sample dates where the user would pick one.
    $templates = [
        'newyear' => ['name' => 'Yılbaşı', 'date' => $today->copy()->setDate($today->year, 1, 1)->addYear(), 'theme' => 'lemon', 'yearly' => true],
        'wedding' => ['name' => 'Düğün', 'date' => $today->copy()->addDays(212), 'theme' => 'lemon', 'yearly' => false],
        'vacation' => ['name' => 'Tatil', 'date' => $today->copy()->addDays(233), 'theme' => 'mint', 'yearly' => false],
        'birthday' => ['name' => 'Doğum günü', 'date' => Carbon::create(2027, 2, 14, 0, 0, 0, 'Europe/Istanbul'), 'theme' => 'cobalt', 'yearly' => true],
        'baby' => ['name' => 'Bebeğin doğumu', 'date' => $today->copy()->addDays(128), 'theme' => 'paper', 'yearly' => false],
        'since' => ['name' => 'Sigarasız günler', 'date' => $today->copy()->subDays(103), 'theme' => 'tangerine', 'yearly' => false],
    ];
    $templatesJson = json_encode(array_map(fn ($t) => ['name' => __($t['name']), 'date' => $t['date']->toDateString(), 'theme' => $t['theme'], 'yearly' => $t['yearly']], $templates));

    $days = fn (Carbon $d) => (int) $today->diffInDays($d, false);
    $fmtDate = fn (Carbon $d) => $tr ? $d->translatedFormat('j M Y') : $d->format('M j, Y');
    $hero = $templates['newyear'];
    $heroDays = $days($hero['date']);

    // The reminder bar: 100 → 30 → 7 → 1 → the day, segments as long as the real gaps.
    $stages = [
        ['days' => 70, 'from' => 100, 'theme' => 'lemon', 'text' => '100 gün kala ilk hatırlatma gelir. Sayaç ana ekranda her sabah bir eksilir.'],
        ['days' => 23, 'from' => 30, 'theme' => 'mint', 'text' => '30 gün kala ikinci hatırlatma. Widget\'ı değiştirmek istersen renk ya da boyut seç.'],
        ['days' => 6, 'from' => 7, 'theme' => 'paper', 'text' => '7 gün kala üçüncü hatırlatma. Sayacı resim olarak paylaşabilirsin.'],
        ['days' => 1, 'from' => 1, 'theme' => 'tangerine', 'text' => '1 gün kala son hatırlatma.'],
        ['days' => 0, 'from' => 0, 'theme' => 'ink', 'text' => 'O gün bildirim gelir; sayaç sıfırı gösterir, sonra kaç gün olduğunu saymaya başlar.'],
    ];

    $faq = [
        'Countdown Widget ücretli mi?' => 'Hayır, ücretsizdir. Uygulamaya geri döndüğünde reklam görürsün; ek renkleri ve fotoğraf arka planını açmak için izlemeyi seçebileceğin isteğe bağlı reklamlar da var. Widget\'ta asla reklam yoktur.',
        'Widget\'ı nasıl eklerim?' => '+ düğmesine dokun, şablon seç ya da sıfırdan başla; tarihi ve rengi seç. Sonra ana ekrana uzun bas, Countdown Widget\'ı ekle ve sayacını seç.',
        'Tarih geçince ne olur?' => 'Sayaç durmaz: o günden itibaren kaç gün geçtiğini sayar. "Her yıl tekrar" açıksa bir sonraki yıla geçer.',
        'Hatırlatmalar ne zaman gelir?' => '100, 30, 7 ve 1 gün kala ve o gün. "Kaç gün oldu" sayaçlarında 7, 30 ve 100. günde ve her yıl dönümünde.',
        'Kaç sayaç ekleyebilirim?' => 'Sınırsız. Her sayacın kendi rengi, boyutu ve hatırlatma ayarı olur.',
        'Fotoğraf arka planı nasıl açılır?' => 'Renk seçiminde ► işaretli bir seçeneğe dokun ve bir reklam izle; o renk ya da fotoğraf arka planı kalıcı olarak açılır.',
        'Hesap açmam gerekiyor mu?' => 'Hayır. Hesap açmak ya da üye olmak yok; uygulama internetsiz çalışır ve sayaçların yalnızca cihazında kalır.',
    ];
@endphp

@section('content')
<div class="cw" data-cw data-today="{{ $today->toDateString() }}">
    <style>
        /* Countdown Widget page: the widget's own colours are the chapters, and the widget is the thing you set up. */
        .cw {
            --cw-ink: #15161B;
            --cw-paper: #FFFFFF;
            --cw-tangerine: #CF6A48;
            --cw-cobalt: #2446E0;
            --cw-mint: #0E7C66;
            --cw-lemon: #FFD84D;
            --cw-stage: #F2F2F5;
            --cw-stage-2: #E3E3EA;
        }
        .cw-display {
            font-size: clamp(3rem, 5.6vw, 5.5rem);
            line-height: 0.92;
            letter-spacing: -0.035em;
        }
        .cw-h2 {
            font-size: clamp(2.5rem, 4.4vw, 4.25rem);
            line-height: 0.95;
            letter-spacing: -0.03em;
        }

        /* Hero: the widget's rounded square, giant, cropped by the viewport, counting. */
        .cw-hero {
            position: relative;
            overflow: hidden;
            min-height: calc(100svh - 76px);
        }
        .cw-hero::before {
            content: '';
            position: absolute;
            width: 130vw;
            height: 130vw;
            left: -15vw;
            top: 56svh;
            border-radius: 18%;
            background: var(--cw-lemon);
        }
        .cw-shape-body {
            position: absolute;
            left: 24px;
            top: calc(56svh + 9vw);
            width: calc(100vw - 48px);
            color: var(--cw-ink);
        }
        @media (min-width: 1024px) {
            .cw-hero::before {
                width: 120vh;
                height: 120vh;
                left: calc(82% - 60vh);
                top: calc(55% - 60vh);
            }
            .cw-shape-body {
                left: calc(82% - 49vh);
                top: calc(55% - 34vh);
                width: 70vh;
            }
        }

        /* Chapters: flat fields, butted together. */
        .cw-chapter {
            min-height: 90svh;
        }

        /* The reminder bar, the product's own progress bar enlarged. */
        [data-ui].cw-bar {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-height: 70svh;
        }
        [data-ui] .cw-seg {
            flex: var(--grow) 1 0;
            min-height: 72px;
            padding: 20px;
        }
        @media (min-width: 1024px) {
            [data-ui].cw-bar {
                flex-direction: row;
                min-height: 22vh;
            }
            [data-ui] .cw-seg {
                min-width: 12%;
                min-height: 0;
            }
        }

        /* The widget, at its true size, in the app's own manner. */
        [data-ui].cw-widget {
            border-radius: 22px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 240px;
            height: 240px;
            background: var(--bg);
            color: var(--fg);
            transition: background-color 200ms ease-out, color 200ms ease-out;
        }
        [data-ui].cw-widget[data-size="2x1"] {
            height: 120px;
            flex-direction: row;
            align-items: center;
            gap: 14px;
        }
        [data-ui].cw-widget[data-size="4x2"] {
            width: min(420px, 100%);
        }
        [data-ui] .cw-w-name {
            font-size: 15px;
            font-weight: 700;
        }
        [data-ui] .cw-w-n {
            font-size: 64px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.03em;
            font-variant-numeric: tabular-nums;
        }
        [data-ui].cw-widget[data-size="2x1"] .cw-w-n {
            font-size: 44px;
        }
        [data-ui] .cw-w-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--accent);
        }
        [data-ui] .cw-w-bar {
            height: 8px;
            border-radius: 4px;
            background: color-mix(in srgb, var(--fg) 25%, transparent);
            overflow: hidden;
        }
        [data-ui] .cw-w-bar > span {
            display: block;
            height: 100%;
            width: var(--p);
            background: var(--accent);
            transition: width 300ms ease-out;
        }
        [data-ui].cw-widget:not([data-size="4x2"]) .cw-w-bar,
        [data-ui].cw-widget[data-size="2x1"] .cw-w-date {
            display: none;
        }

        /* The controls: the app's own chips and swatches, filled, no outlines. */
        .cw-chip {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 999px;
            background: var(--cw-stage-2);
            color: var(--cw-ink);
            font-weight: 600;
            cursor: pointer;
            min-height: 44px;
            line-height: 24px;
        }
        .cw-opt:checked + .cw-chip {
            background: var(--cw-ink);
            color: var(--cw-paper);
        }
        .cw-opt:focus-visible + .cw-chip {
            outline: 3px solid var(--color-accent);
            outline-offset: 2px;
        }
        .cw-swatch {
            display: block;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--bg);
            cursor: pointer;
        }
        .cw-opt:checked + .cw-swatch {
            outline: 4px solid var(--cw-ink);
            outline-offset: 3px;
        }
        .cw-opt:focus-visible + .cw-swatch {
            outline: 4px solid var(--color-accent);
            outline-offset: 3px;
        }
        .cw-date {
            display: block;
            width: 100%;
            min-height: 48px;
            padding: 10px 14px;
            border-radius: 12px;
            background: var(--cw-stage-2);
            color: var(--cw-ink);
            font: inherit;
            font-weight: 600;
        }
        .cw-date:focus-visible {
            outline: 3px solid var(--color-accent);
            outline-offset: 2px;
        }
        .cw-switch {
            position: relative;
            width: 56px;
            height: 32px;
            border-radius: 16px;
            background: var(--cw-stage-2);
            cursor: pointer;
            flex: none;
            transition: background-color 150ms ease-out;
        }
        .cw-switch::after {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--cw-ink);
            transition: transform 150ms ease-out;
        }
        .cw-opt:checked + .cw-switch {
            background: var(--cw-tangerine);
        }
        .cw-opt:checked + .cw-switch::after {
            transform: translateX(24px);
        }
        .cw-opt:focus-visible + .cw-switch {
            outline: 3px solid var(--color-accent);
            outline-offset: 2px;
        }

        /* Questions as filled tiles, one open at a time. */
        .cw-tile {
            background: var(--color-surface);
            color: var(--color-ink);
        }
        .cw-tile[open] {
            background: var(--cw-lemon);
            color: var(--cw-ink);
        }
        .cw-tile summary {
            list-style: none;
            cursor: pointer;
        }
        .cw-tile summary::-webkit-details-marker {
            display: none;
        }
        .cw-plus {
            position: relative;
            width: 16px;
            height: 16px;
            flex: none;
        }
        .cw-plus::before,
        .cw-plus::after {
            content: '';
            position: absolute;
            left: 0;
            top: 6.5px;
            width: 16px;
            height: 3px;
            background: currentColor;
            transition: transform 200ms ease-out;
        }
        .cw-plus::after {
            transform: rotate(90deg);
        }
        .cw-tile[open] .cw-plus::after {
            transform: rotate(0deg);
        }
        .cw-tile summary:focus-visible {
            outline: 3px solid var(--color-accent);
            outline-offset: -3px;
        }

        /* The closing word fills the band's width. */
        .cw-word {
            font-size: calc((100vw - 48px) / (var(--letters) * 0.8));
            line-height: 0.8;
            letter-spacing: -0.04em;
        }
        .cw-band:hover,
        .cw-band:focus-visible {
            background: var(--cw-ink);
            color: var(--cw-lemon);
        }

        @media (prefers-reduced-motion: no-preference) {
            .cw-hero::before {
                animation: cw-shutter 1100ms cubic-bezier(0.16, 1, 0.3, 1) both;
            }
            .cw-rise {
                animation: rise 500ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
                animation-delay: calc(var(--i, 0) * 80ms);
            }
            .reveal-on .cw-bar [data-reveal]:not(.is-in) {
                transform: scaleY(0.92);
            }
            .cw-reprint {
                animation: cw-in 260ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
            }
            .cw-chip:active,
            .cw-swatch:active {
                transform: scale(0.95);
            }
            .cw-chip,
            .cw-swatch {
                transition: transform 120ms ease-out, background-color 150ms ease-out, color 150ms ease-out;
            }
        }
        @keyframes cw-shutter {
            from { clip-path: inset(0 0 0 100%); transform: scale(1.12); }
            to { clip-path: inset(0 0 0 0); }
        }
        @media (max-width: 1023px) {
            @keyframes cw-shutter {
                from { clip-path: inset(100% 0 0 0); transform: scale(1.12); }
                to { clip-path: inset(0 0 0 0); }
            }
        }
        @keyframes cw-in {
            from { opacity: 0; transform: translateY(6px); }
        }
    </style>

    {{-- Hero: the widget, giant, counting to New Year. --}}
    <section class="cw-hero">
        <div class="cw-shape-body" data-ui data-hero-widget>
                <p class="text-[clamp(1.25rem,2vw,1.75rem)] font-bold">{{ __($hero['name']) }}</p>
                <p class="mt-2 text-[clamp(6rem,16vw,15rem)] font-extrabold leading-none tracking-[-0.05em] tabular-nums" data-hero-days>{{ $heroDays }}</p>
                <p class="mt-2 text-[clamp(1rem,1.6vw,1.5rem)] font-bold uppercase tracking-[0.04em]">{{ __('gün kaldı') }}</p>
                <p class="mt-1 text-[clamp(1rem,1.6vw,1.5rem)] font-semibold">{{ $fmtDate($hero['date']) }}</p>
        </div>

        <div class="relative mx-auto grid max-w-6xl px-6 pt-[12svh] lg:min-h-[calc(100svh-76px)] lg:grid-cols-12 lg:items-center lg:pt-0">
            <div class="lg:col-span-6">
                <h1 class="cw-display cw-rise font-extrabold text-ink">
                    {{ __('Kaç gün') }}<br>{{ __('kaldı?') }}
                </h1>
                <p class="cw-rise mt-6 max-w-[34ch] text-[17px] leading-relaxed text-ink" style="--i: 1">{{ __('Düğüne, tatile, doğum gününe ya da herhangi bir tarihe kaç gün kaldığını ana ekranında gör. Geçmiş bir tarih için kaç gün olduğunu da sayar.') }}</p>
                <p class="cw-rise mt-8" style="--i: 2">
                    @if ($app['play_store'])
                        <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press inline-block rounded-[22px] bg-accent px-6 py-4 font-semibold text-canvas hover:bg-accent-deep">{{ __("Google Play'de aç") }}</a>
                    @else
                        <span class="inline-block rounded-[22px] bg-surface px-6 py-4 font-semibold text-ink">{{ __("Yakında Google Play'de") }}</span>
                    @endif
                    <a href="{{ $app['privacy_url'] }}" class="ml-4 inline-block font-semibold text-ink underline decoration-ink/40 underline-offset-4 transition-colors hover:decoration-current">{{ __('Gizlilik Politikası') }}</a>
                </p>
            </div>
        </div>
    </section>

    {{-- Chapter: the reminders, as the bar they make. --}}
    <section class="cw-chapter flex flex-col justify-center py-24 text-white lg:py-32" style="background: var(--cw-cobalt)">
        <div class="mx-auto w-full max-w-6xl px-6">
            <h2 class="cw-display font-extrabold">{{ __('Yüz günden o güne') }}</h2>
            <p class="mt-6 max-w-[44ch] text-[17px] leading-relaxed">{{ __('Hatırlatmalar 100, 30, 7 ve 1 gün kala ve o gün gelir. Aradaki süreler çubukta gerçek uzunluklarıyla duruyor.') }}</p>

            <div class="cw-bar mt-16" data-ui>
                @foreach ($stages as $s => $stage)
                    <div class="cw-seg flex flex-col justify-between gap-4" data-reveal style="--grow: {{ max($stage['days'], 1) }}; background: {{ $themes[$stage['theme']]['bg'] }}; color: {{ $themes[$stage['theme']]['fg'] }}">
                        <p class="text-[clamp(1.25rem,2vw,1.875rem)] font-bold leading-none">{{ $stage['days'] > 1 ? __(':n gün', ['n' => $stage['days']]) : ($stage['days'] ? __('1 gün') : __('O gün')) }}</p>
                        <p class="max-w-[22ch] text-[17px] leading-snug lg:hidden">{{ __($stage['text']) }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 hidden gap-[6px] lg:flex">
                @foreach ($stages as $s => $stage)
                    <p class="max-w-[22ch] text-[17px] leading-snug" style="flex: {{ max($stage['days'], 1) }} 1 0; min-width: 12%">{{ __($stage['text']) }}</p>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Chapter: the widget you set up. --}}
    <section class="cw-chapter" style="background: var(--cw-stage); color: var(--cw-ink)" data-setup>
        <div class="mx-auto grid max-w-6xl lg:grid-cols-12 lg:gap-6 lg:px-6">
            {{-- The output: sticky, at true size. --}}
            <div class="mx-6 flex min-h-[42svh] items-center justify-center rounded-[22px] px-6 py-10 lg:sticky lg:top-0 lg:col-span-6 lg:mx-0 lg:h-[100svh] lg:rounded-none" style="background: var(--cw-stage-2)">
                <div class="cw-widget" data-ui data-widget data-size="2x2" style="--bg: {{ $themes[$hero['theme']]['bg'] }}; --fg: {{ $themes[$hero['theme']]['fg'] }}; --accent: {{ $themes[$hero['theme']]['accent'] }}; --p: 0%">
                    <p class="cw-w-name" data-w-name>{{ __($hero['name']) }}</p>
                    <div>
                        <p class="cw-w-n" data-w-days>{{ abs($heroDays) }}</p>
                        <p class="cw-w-label" data-w-label>{{ mb_strtoupper(__('gün kaldı')) }}</p>
                        <p class="cw-w-date mt-1 text-[12px] opacity-80" data-w-date>{{ $fmtDate($hero['date']) }}</p>
                    </div>
                    <div class="cw-w-bar" aria-hidden="true"><span></span></div>
                </div>
            </div>

            {{-- The controls, one per block. --}}
            <form class="px-6 pb-24 pt-16 text-[17px] lg:col-span-5 lg:col-start-8 lg:px-0 lg:pt-[72px]" data-controls>
                <h2 class="cw-h2 font-bold">{{ __('Kendi sayacını kur') }}</h2>

                <div class="mt-16 lg:mt-[40vh]" data-reveal>
                    <p class="text-2xl font-semibold leading-tight">{{ __('Şablon seç, tarihi gir.') }}</p>
                    <p class="mt-3 max-w-[44ch] text-[17px] leading-relaxed">{{ __('On hazır şablon var: düğün, tatil, doğum günü, bebek, terhis, yıl dönümü, emeklilik, yılbaşı, Noel ve "kaç gün oldu". Ya da sıfırdan başla.') }}</p>
                    <fieldset class="mt-5 flex flex-wrap gap-2">
                        <legend class="sr-only">{{ __('Şablon') }}</legend>
                        @foreach ($templates as $key => $t)
                            <label><input type="radio" name="template" value="{{ $key }}" class="cw-opt sr-only" @checked($key === 'newyear')><span class="cw-chip">{{ __($t['name']) }}</span></label>
                        @endforeach
                    </fieldset>
                    <label class="mt-4 block">
                        <span class="block text-[15px] font-semibold">{{ __('Tarih') }}</span>
                        <input type="date" name="date" class="cw-date mt-1" value="{{ $hero['date']->toDateString() }}">
                    </label>
                </div>

                <div class="mt-16 lg:mt-[50vh]" data-reveal>
                    <p class="text-2xl font-semibold leading-tight">{{ __('Altı renk, hepsi ücretsiz.') }}</p>
                    <p class="mt-3 max-w-[44ch] text-[17px] leading-relaxed">{{ __('Dört renk daha ve fotoğraf arka planı, bir reklam izleyince kalıcı olarak açılır.') }}</p>
                    <fieldset class="mt-5 flex flex-wrap gap-4">
                        <legend class="sr-only">{{ __('Widget rengi') }}</legend>
                        @foreach ($themes as $key => $theme)
                            <label title="{{ __($themeNames[$key]) }}"><input type="radio" name="theme" value="{{ $key }}" class="cw-opt sr-only" @checked($key === $hero['theme']) aria-label="{{ __($themeNames[$key]) }}"><span class="cw-swatch" style="--bg: {{ $theme['bg'] }}"></span></label>
                        @endforeach
                    </fieldset>
                </div>

                <div class="mt-16 lg:mt-[50vh]" data-reveal>
                    <p class="text-2xl font-semibold leading-tight">{{ __('Üç boyut.') }}</p>
                    <p class="mt-3 max-w-[44ch] text-[17px] leading-relaxed">{{ __('2×1 yalnızca sayı, 2×2 sayı ve tarih, 4×2 ilerleme çubuğuyla. Boyutu ana ekranda seçersin.') }}</p>
                    <fieldset class="mt-5 flex flex-wrap gap-2">
                        <legend class="sr-only">{{ __('Widget boyutu') }}</legend>
                        @foreach (['2x1', '2x2', '4x2'] as $size)
                            <label><input type="radio" name="size" value="{{ $size }}" class="cw-opt sr-only" @checked($size === '2x2')><span class="cw-chip">{{ str_replace('x', '×', $size) }}</span></label>
                        @endforeach
                    </fieldset>
                </div>

                <div class="mt-16 lg:mt-[50vh]" data-reveal>
                    <p class="text-2xl font-semibold leading-tight">{{ __('Her yıl tekrar, önemli günlerde hatırlat.') }}</p>
                    <p class="mt-3 max-w-[44ch] text-[17px] leading-relaxed">{{ __('Doğum günü ve yıl dönümü geçince bir sonraki yıla atlar. Hatırlatmalar sayaca göre gelir:') }} <span class="font-semibold" data-w-reminders></span></p>
                    <label class="mt-5 flex items-center gap-4"><input type="checkbox" name="yearly" class="cw-opt sr-only" @checked($hero['yearly'])><span class="cw-switch" aria-hidden="true"></span><span class="font-semibold">{{ __('Her yıl tekrarla') }}</span></label>
                </div>
            </form>
        </div>
    </section>

    {{-- Chapter: the app, in one strip. --}}
    <section class="cw-chapter flex flex-col justify-center py-24 text-white lg:py-32" style="background: var(--cw-mint)">
        <div class="mx-auto w-full max-w-6xl px-6">
            <h2 class="cw-h2 font-bold">{{ __('Uygulamanın içi') }}</h2>
            <div class="mt-12 grid grid-cols-2 gap-3 lg:grid-cols-4 lg:gap-4">
                @foreach ($tr ? [
                    1 => 'Countdown Widget liste ekranı: düğün 212, yaz tatili 233, doğum günü 94 gün kaldı',
                    2 => 'Countdown Widget düzenleme ekranı: ad, tarih, her yıl tekrar, hatırlatma ve renk seçimi',
                    3 => 'Ana ekranda üç widget: kaç gün önce, kaç gün kaldı',
                    4 => 'Resim olarak paylaşılan bir sayaç: 94 gün kaldı',
                ] : [
                    1 => 'Countdown Widget opening screen with the app icon',
                    2 => 'Countdown Widget list: wedding 212, summer vacation 233, birthday 94 days left',
                    3 => 'Three widgets on the home screen: days ago, days left',
                    4 => 'A countdown shared as a picture: 94 days left',
                ] as $n => $alt)
                    <img src="{{ $screen($n) }}" alt="{{ __($alt) }}" width="364" height="624" loading="lazy" class="w-full rounded-[22px]" data-reveal>
                @endforeach
            </div>
            <p class="mt-8 max-w-[60ch] text-[17px] leading-relaxed">{{ __('Liste, düzenleme, ana ekran ve paylaşım. Hesap yok, internet gerekmez; sayaçların telefonunda kalır.') }}</p>
        </div>
    </section>

    {{-- Chapter: questions. --}}
    <section class="cw-chapter py-24 lg:py-32" aria-labelledby="faq-h">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 lg:grid-cols-12 lg:gap-6">
            <h2 id="faq-h" class="cw-h2 font-bold text-ink lg:col-span-4 lg:sticky lg:top-24 lg:self-start">{{ __('Sık sorulanlar') }}</h2>
            <div class="grid gap-2 lg:col-span-8">
                @foreach ($faq as $q => $a)
                    <details class="cw-tile rounded-[22px]" name="cw-faq" data-reveal @if ($loop->first) open @endif>
                        <summary class="flex min-h-[72px] items-center justify-between gap-6 px-6 py-5 text-[18px] font-medium">{{ __($q) }}<span class="cw-plus" aria-hidden="true"></span></summary>
                        <p class="max-w-[52ch] px-6 pb-6 text-[17px] leading-relaxed">{{ __($a) }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Close: the word. Becomes the Play link once the app is on Play. --}}
    <section>
        <h2 class="sr-only">{{ $app['play_store'] ? __("Google Play'de aç") : __("Yakında Google Play'de") }}</h2>
        @php $word = $app['play_store'] ? __('İndir') : __('Yakında'); @endphp
        @if ($app['play_store'])
            <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="cw-band flex h-[46svh] min-h-[300px] flex-col justify-between px-6 pt-6 pb-6 md:h-[60svh] md:min-h-[420px]" style="background: var(--cw-lemon); color: var(--cw-ink)">
        @else
            <div class="flex h-[46svh] min-h-[300px] flex-col justify-between px-6 pt-6 pb-6 md:h-[60svh] md:min-h-[420px]" style="background: var(--cw-lemon); color: var(--cw-ink)">
        @endif
            <span class="flex items-start justify-between gap-6">
                <span class="max-w-[26ch] text-[17px] font-semibold leading-snug md:text-[18px]">{{ $app['play_store'] ? __("Countdown Widget'ı Google Play'de aç ve telefonuna kur.") : __("Yakında Google Play'de. Ücretsiz, Android için; widget'ta reklam yok.") }}</span>
                <svg class="h-8 w-8 shrink-0 md:h-12 md:w-12" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M12 36L36 12M16 12h20v20" stroke="currentColor" stroke-width="4"/></svg>
            </span>
            <span class="cw-word block font-extrabold uppercase" style="--letters: {{ mb_strlen($word) }}">{{ $word }}</span>
        @if ($app['play_store'])
            </a>
        @else
            </div>
        @endif
    </section>
</div>

<script>
    // The widget you set up: template, date, colour, size and yearly repeat change the widget at once, with the app's own day maths.
    (() => {
        const root = document.querySelector('[data-cw]');
        const lang = document.documentElement.lang;
        const templates = {!! $templatesJson !!};
        const themes = @json($themes);
        const t = {
            left: @json(mb_strtoupper(__('gün kaldı'))), ago: @json(mb_strtoupper(__('gün önce'))),
            ahead: @json(__(':list gün kala ve o gün.')), behind: @json(__(':list. günde ve her yıl dönümünde.')), anniversary: @json(__('her yıl dönümünde.')), today: @json(__('bugün.')),
        };
        const day = 86400000;
        const parse = (s) => { const [y, m, d] = s.split('-').map(Number); return Date.UTC(y, m - 1, d); };
        const today = parse(root.dataset.today);
        const nowLocal = new Date();
        const todayLocal = Date.UTC(nowLocal.getFullYear(), nowLocal.getMonth(), nowLocal.getDate());
        const fmt = (ms) => new Date(ms).toLocaleDateString(lang, { day: 'numeric', month: 'short', year: 'numeric', timeZone: 'UTC' });

        // Yearly dates roll to the next occurrence, as in the app.
        const target = (dateMs, yearly, base) => {
            if (!yearly || dateMs >= base) return dateMs;
            const d = new Date(dateMs), b = new Date(base);
            let next = Date.UTC(b.getUTCFullYear(), d.getUTCMonth(), d.getUTCDate());
            if (next < base) next = Date.UTC(b.getUTCFullYear() + 1, d.getUTCMonth(), d.getUTCDate());
            return next;
        };
        const reminders = (days) => {
            if (days === 0) return t.today;
            if (days > 0) return t.ahead.replace(':list', [100, 30, 7, 1].filter((n) => n < days).join(', ') || '—');
            const next = [7, 30, 100].filter((n) => n > -days);
            return next.length ? t.behind.replace(':list', next.join(', ')) : t.anniversary;
        };
        const set = (el, text) => { if (el.textContent !== text) { el.textContent = text; el.classList.remove('cw-reprint'); void el.offsetWidth; el.classList.add('cw-reprint'); } };

        // Hero: the visitor's own date decides the count.
        const heroDays = root.querySelector('[data-hero-days]');
        set(heroDays, Math.round((target(parse(templates.newyear.date), true, todayLocal) - todayLocal) / day));

        const form = root.querySelector('[data-controls]');
        const widget = root.querySelector('[data-widget]');
        const update = () => {
            const key = form.template.value;
            const theme = themes[form.theme.value];
            const date = target(parse(form.date.value || templates[key].date), form.yearly.checked, todayLocal);
            const days = Math.round((date - todayLocal) / day);
            widget.dataset.size = form.size.value;
            widget.style.setProperty('--bg', theme.bg);
            widget.style.setProperty('--fg', theme.fg);
            widget.style.setProperty('--accent', theme.accent);
            // Progress as the app draws it: share of the time passed since the countdown was set; here, set 30 days ago.
            const start = todayLocal - 30 * day;
            widget.style.setProperty('--p', `${date <= start ? 100 : Math.min(100, Math.max(0, (100 * (todayLocal - start)) / (date - start)))}%`);
            set(widget.querySelector('[data-w-name]'), templates[key].name);
            set(widget.querySelector('[data-w-days]'), Math.abs(days));
            set(widget.querySelector('[data-w-label]'), days >= 0 ? t.left : t.ago);
            set(widget.querySelector('[data-w-date]'), fmt(date));
            set(root.querySelector('[data-w-reminders]'), reminders(days));
        };
        form.addEventListener('change', (e) => {
            if (e.target.name === 'template') {
                const tpl = templates[e.target.value];
                form.date.value = tpl.date;
                form.yearly.checked = tpl.yearly;
                form.theme.value = tpl.theme;
            }
            update();
        });
        form.addEventListener('submit', (e) => e.preventDefault());
        update();

        // Set the closing word so it spans the band exactly.
        const word = root.querySelector('.cw-word');
        const fit = () => {
            word.style.fontSize = '';
            const range = document.createRange();
            range.selectNodeContents(word);
            const size = parseFloat(getComputedStyle(word).fontSize);
            word.style.fontSize = `${(size * word.clientWidth) / range.getBoundingClientRect().width}px`;
        };
        document.fonts.ready.then(fit);
        addEventListener('resize', fit);
    })();
</script>
@endsection
