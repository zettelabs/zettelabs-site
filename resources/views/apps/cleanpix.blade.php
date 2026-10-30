@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    $tr = app()->getLocale() === 'tr';
    $mb = fn (float $n) => number_format($n, 2, $tr ? ',' : '.', $tr ? '.' : ',');
    $shot = fn (int $n) => asset($app['screenshots'][$n - 1]);
    // Frame name as the camera wrote it: IMGP1715, P1080987, Dsc3972, 0047 (7).
    $frameName = fn (string $source) => preg_match('/([A-Za-z]*\d+(?: \(\d\))?)\.jpg$/', $source, $m) ? $m[1] : $source;

    // The first frame of each group is the original; the rest are the look-alikes that would go.
    $roll = array_map(function (array $group) {
        $total = array_sum(array_column($group['frames'], 'mb'));

        return [...$group, 'total' => $total, 'frees' => $total - $group['frames'][0]['mb']];
    }, $app['roll']);
    $frames = array_sum(array_map(fn ($g) => count($g['frames']), $roll));
    $toDelete = $frames - count($roll);
    $freed = array_sum(array_column($roll, 'frees'));

    $stages = [
        ['name' => 'Tara', 'text' => 'Hızlı, Temel ya da Gelişmiş modu seç. Hızlı en çabuk olanı, Temel önerilen denge, Gelişmiş daha yavaş ama en isabetli. Tarama arka planda sürer.', 'shot' => 4],
        ['name' => 'Grupla', 'text' => 'Seri çekimler ve birbirine çok benzeyen kareler yan yana gruplanır; her grubun orijinali işaretlenir.', 'shot' => 1],
        ['name' => 'Seç', 'text' => 'Akıllı seçim her gruptaki en iyi fotoğrafı tutar, gerisini seçer. Her seçimi tek dokunuşla değiştirebilirsin.', 'shot' => 2],
        ['name' => 'Karşılaştır', 'text' => 'Bir grubu tam ekranda aç ve silmeden önce kareler arasında kaydır. Neyin kalacağına sen karar verirsin.', 'shot' => 5],
        ['name' => 'Sil', 'text' => 'Onayla; CleanPix kaç fotoğrafın gittiğini ve ne kadar yer açıldığını gösterir.', 'shot' => 6],
    ];

    // Each tile is a crop of a real screenshot (540×960): [x, y, w, h] in its pixels, and the window's width in the tile.
    $tiles = [
        ['name' => 'Üç tarama modu', 'fact' => 'Hızlı, Temel (önerilen) ve Gelişmiş.', 'shot' => 3, 'crop' => [84, 725, 372, 235], 'width' => 80],
        ['name' => 'Depolama bir bakışta', 'fact' => 'Telefonunda ne kadar yer kullandığını tarama başlamadan gör.', 'shot' => 3, 'crop' => [84, 380, 372, 330], 'width' => 50, 'wide' => true],
        ['name' => 'Akıllı seçim', 'fact' => 'Her gruptan en iyisi kalır, gerisi seçilir.', 'shot' => 2, 'crop' => [96, 440, 348, 240], 'width' => 80],
        ['name' => 'Tam ekran karşılaştırma', 'fact' => 'Silmeden önce her kareye büyük bak.', 'shot' => 5, 'crop' => [82, 370, 376, 560], 'width' => 58],
        ['name' => 'Temiz bir galeri', 'fact' => 'Kaç fotoğrafın gittiğini ve açılan yeri gösterir.', 'shot' => 6, 'crop' => [96, 620, 348, 240], 'width' => 80],
    ];
    $crop = fn (array $t) => sprintf(
        'width:%d%%;aspect-ratio:%d/%d;--w:%.2f%%;--x:%.2f%%;--y:%.2f%%',
        $t['width'], $t['crop'][2], $t['crop'][3], 54000 / $t['crop'][2], -100 * $t['crop'][0] / 540, -100 * $t['crop'][1] / 960,
    );
@endphp

@section('content')
<div class="cp" data-locale="{{ app()->getLocale() }}">
    <style>
        /* CleanPix page, dressed as a darkroom contact sheet: one keeper per group, the rest marked. */
        .cp {
            --cp-t1: #1c1729;
            --cp-t2: #282038;
            --cp-t3: #3b3352;
            --cp-t4: #8d85a8;
            --cp-t5: #dcd8e8;
            --cp-row: #1a1626;
        }

        /* Hero: the shout and the picture that rises under it. */
        .cp-shout {
            font-size: min(9.4vw, 8.2rem);
            line-height: 0.9;
            letter-spacing: -0.045em;
        }
        .cp-line {
            display: block;
            overflow: hidden;
            padding-bottom: 0.06em;
        }
        .cp-line > span {
            display: block;
        }

        /* How it works: a row of tinted panels, the checked one open. */
        .cp-stages {
            display: flex;
            flex-direction: column;
        }
        .cp-stage {
            position: relative;
            color: var(--color-ink);
        }
        .cp-stage:nth-child(1) { background: var(--cp-t1); }
        .cp-stage:nth-child(2) { background: var(--cp-t2); }
        .cp-stage:nth-child(3) { background: var(--cp-t3); }
        .cp-stage:nth-child(4) { background: var(--cp-t4); color: var(--color-canvas); }
        .cp-stage:nth-child(5) { background: var(--cp-t5); color: var(--color-canvas); }
        .cp-stage-tab {
            display: flex;
            align-items: center;
            height: 64px;
            padding: 0 20px;
            cursor: pointer;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .cp-stage-body {
            display: none;
            padding: 0 20px 24px;
        }
        .cp-stage:has(input:checked) .cp-stage-body {
            display: grid;
            gap: 24px;
            padding-top: 24px;
        }
        /* The open stage names itself in its heading. */
        .cp-stage:has(input:checked) .cp-stage-tab {
            display: none;
        }
        .cp-stage:has(input:focus-visible) {
            outline: 3px solid var(--color-accent);
            outline-offset: -3px;
        }

        @media (min-width: 1024px) {
            .cp-stages {
                flex-direction: row;
                height: 520px;
            }
            .cp-stage {
                flex: 0 0 calc(42% / 4);
                min-width: 0;
                overflow: hidden;
                transition: flex-basis 450ms cubic-bezier(0.2, 0.7, 0.2, 1);
            }
            .cp-stage:has(input:checked) {
                flex-basis: 58%;
            }
            .cp-stage-tab {
                position: absolute;
                inset: 0;
                height: auto;
                align-items: flex-end;
                padding: 24px 22px;
            }
            .cp-stage-tab span {
                writing-mode: vertical-rl;
                transform: rotate(180deg);
            }
            /* Fixed at the open width so the text does not reflow while the panel slides. */
            .cp-stage-body {
                position: absolute;
                inset: 0;
                grid-template-columns: 1fr auto;
                padding: 32px;
                width: calc((min(100vw, 72rem) - 3rem) * 0.58);
            }
        }

        /* The scan result, set like a departure board. */
        .cp-board li {
            background: var(--cp-row);
        }
        .cp-board li:has(> input:checked) {
            background: var(--color-accent);
            color: var(--color-canvas);
        }
        .cp-board li:has(> input:focus-visible) {
            outline: 3px solid var(--color-ink);
            outline-offset: 2px;
        }
        .cp-detail {
            display: none;
        }
        .cp-board li:has(> input:checked) .cp-detail {
            display: grid;
        }
        .cp-board li:has(> input:checked) .cp-status {
            background: var(--color-canvas);
            color: var(--color-ink);
        }
        .cp-frame img {
            transition: filter 200ms ease-out, transform 200ms ease-out;
        }
        /* Frames that would go fade to grey, like a struck-out frame on a contact sheet. */
        .cp-frame:has(input:not(:checked)) img {
            filter: grayscale(1) brightness(0.55);
        }
        .cp-frame:has(input:checked) img {
            outline: 4px solid var(--color-canvas);
            outline-offset: -4px;
        }
        .cp-frame:hover img {
            filter: none;
        }
        .cp-frame:has(input:focus-visible) {
            outline: 3px solid var(--color-canvas);
            outline-offset: 3px;
        }
        .cp-frame .cp-keep,
        .cp-frame:has(input:checked) .cp-drop {
            display: none;
        }
        .cp-frame:has(input:checked) .cp-keep {
            display: inline;
        }

        /* Features: interface crops on flat tiles. */
        .cp-window {
            position: relative;
            overflow: hidden;
        }
        .cp-window img {
            position: absolute;
            left: 0;
            top: 0;
            max-width: none;
            width: var(--w);
            transform: translate(var(--x), var(--y));
        }

        /* The closing band: the whole thing is the link; field and word swap on hover. */
        .cp-cta {
            background: var(--color-accent);
            color: var(--color-canvas);
        }
        .cp-cta:hover,
        .cp-cta:focus-visible {
            background: var(--color-canvas);
            color: var(--color-accent);
        }
        .cp-cta:focus-visible {
            outline: 4px solid var(--color-accent);
            outline-offset: -4px;
        }
        .cp-word {
            font-size: calc((100vw - 48px) / (var(--letters) * 0.62));
            line-height: 0.8;
            letter-spacing: -0.04em;
        }

        .reveal-on .cp [data-reveal]:not(.is-in) {
            transform: translateY(24px);
        }
        /* Board rows slide in sideways so a row on its way never covers the one above. */
        .reveal-on .cp-board [data-reveal]:not(.is-in) {
            transform: translateX(-24px);
        }

        @media (prefers-reduced-motion: no-preference) {
            .cp-line > span {
                animation: cp-mask 900ms cubic-bezier(0.16, 1, 0.3, 1) both;
            }
            .cp-line + .cp-line > span {
                animation-delay: 110ms;
            }
            .cp-after {
                animation: rise 600ms cubic-bezier(0.2, 0.7, 0.2, 1) 500ms both;
            }
            .cp-rise img {
                animation: cp-lift 1200ms cubic-bezier(0.16, 1, 0.3, 1) 250ms both;
            }
            .cp-frame:hover img {
                transform: scale(1.03);
            }
        }

        @keyframes cp-mask {
            from {
                transform: translateY(105%);
            }
        }

        @keyframes cp-lift {
            from {
                transform: translateY(18%);
            }
        }
    </style>

    {{-- Hero --}}
    <section class="flex flex-col lg:min-h-[calc(100svh-76px)]">
        <div class="mx-auto w-full max-w-6xl px-6 pt-10 lg:pt-14">
            <h1 class="cp-shout text-center font-extrabold uppercase text-ink">
                <span class="cp-line"><span>{{ __('Birini tut.') }}</span></span>
                <span class="cp-line"><span>{{ __('Gerisini sil.') }}</span></span>
            </h1>

            {{-- Phone: what it is and the action sit between the shout and the picture. --}}
            <div class="cp-after mt-8 lg:hidden">
                <p class="text-lg leading-relaxed text-ink">{{ __('CleanPix, telefonundaki tekrarlayan ve birbirine benzeyen fotoğrafları gruplar; her gruptan en iyisini tutar, gerisini senin onayınla siler.') }}</p>
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press mt-6 inline-block bg-accent px-6 py-4 font-semibold text-canvas hover:bg-accent-deep">{{ __("Google Play'de aç") }}</a>
            </div>
        </div>

        <div class="mx-auto mt-10 grid w-full max-w-6xl flex-1 gap-6 px-6 lg:mt-12 lg:grid-cols-[1fr_auto_1fr]">
            <div class="cp-after hidden self-end pb-10 lg:block">
                <p class="max-w-[300px] text-lg leading-relaxed text-ink">{{ __('CleanPix, telefonundaki tekrarlayan ve birbirine benzeyen fotoğrafları gruplar; her gruptan en iyisini tutar, gerisini senin onayınla siler.') }}</p>
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press mt-6 inline-block bg-accent px-6 py-4 font-semibold text-canvas hover:bg-accent-deep">{{ __("Google Play'de aç") }}</a>
            </div>

            {{-- The picture rises from the bottom edge; only its top shows. --}}
            <div class="cp-rise relative mx-auto h-[min(86vw,560px)] w-[72%] max-w-[440px] overflow-hidden lg:h-auto lg:min-h-[340px] lg:w-[30vw] lg:max-w-[400px]">
                <img src="{{ $shot(2) }}" alt="{{ __('CleanPix tarama sonucu: her grupta orijinal işaretli, benzerleri silinmek üzere seçili.') }}" width="540" height="960" class="absolute inset-x-0 top-0 block w-full" style="margin-top: -58%;">
            </div>

            <div class="cp-after hidden self-end justify-self-end pb-10 text-right lg:block">
                <p class="max-w-[260px] text-lg leading-relaxed text-ink">{{ __('Android için. Fotoğrafların telefonundan hiç çıkmaz.') }}</p>
                <a href="{{ $app['privacy_url'] }}" class="mt-4 inline-block font-semibold text-ink underline decoration-ink/40 underline-offset-4 transition-colors hover:decoration-current">{{ __('Gizlilik Politikası') }}</a>
            </div>
        </div>
    </section>

    {{-- The sample scan: the live thing. --}}
    <section class="pt-24 md:pt-40" data-roll>
        <div class="mx-auto grid max-w-6xl gap-6 px-6 md:grid-cols-12">
            <h2 data-reveal class="text-[clamp(2.25rem,4vw,3.75rem)] font-bold leading-none tracking-[-0.03em] text-ink md:col-span-5">{{ __(':count grup bulundu', ['count' => count($roll)]) }}</h2>
            <div data-reveal class="text-lg leading-relaxed text-ink md:col-span-6 md:col-start-7">
                <p>{{ __('Örnek bir rulo: Palm Beach ve Nikkō\'da art arda çekilmiş :frames kare. Her grupta tutmak istediğin kareye dokun.', ['frames' => $frames]) }}</p>
                <p class="mt-3 font-semibold" aria-live="polite">{!! __('Silinecek: :count kare. Geri kazanılan: :mb MB.', ['count' => '<span data-total-count>' . $toDelete . '</span>', 'mb' => '<span data-total-mb>' . $mb($freed) . '</span>']) !!}</p>
            </div>
        </div>

        <ul class="cp-board mt-12 grid gap-1 px-2 lg:mt-16 lg:px-3">
            @foreach ($roll as $g => $group)
                <li data-reveal data-group class="relative text-ink transition-colors">
                    <input type="radio" name="cp-group" id="cp-group-{{ $g }}" class="peer sr-only" @checked($g === 3)>
                    <label for="cp-group-{{ $g }}" class="grid h-16 cursor-pointer grid-cols-[1fr_auto] items-center gap-4 px-4 lg:h-[72px] lg:grid-cols-12 lg:px-6">
                        <span class="truncate text-xl font-bold tracking-[-0.01em] lg:col-span-5 lg:text-[28px]">{{ __($group['name']) }}</span>
                        <span class="hidden text-[28px] font-medium tabular-nums lg:col-span-2 lg:block">{{ __(':count kare', ['count' => count($group['frames'])]) }}</span>
                        <span class="hidden text-[28px] font-medium tabular-nums lg:col-span-2 lg:block">{{ $mb($group['total']) }} MB</span>
                        <span class="hidden text-[28px] font-medium tabular-nums lg:col-span-2 lg:block">−<span data-group-mb>{{ $mb($group['frees']) }}</span> MB</span>
                        <span class="cp-status justify-self-end whitespace-nowrap bg-[#2c2640] px-3 py-1.5 text-base font-semibold tabular-nums lg:col-span-1">{{ __(':count silinecek', ['count' => count($group['frames']) - 1]) }}</span>
                    </label>

                    <div class="cp-detail gap-5 px-4 pb-5 lg:grid-cols-12 lg:px-6 lg:pb-6">
                        <fieldset class="lg:col-span-8">
                            <legend class="sr-only">{{ __('Hangi kare kalsın?') }}</legend>
                            <div class="grid grid-cols-2 gap-2 sm:grid-cols-4">
                                @foreach ($group['frames'] as $f => $frame)
                                    <label class="cp-frame relative block cursor-pointer">
                                        <input type="radio" name="cp-keep-{{ $g }}" value="{{ $f }}" class="sr-only" data-mb="{{ $frame['mb'] }}" data-name="{{ $frameName($frame['source']) }}" @checked($f === 0)>
                                        <img src="{{ asset('images/apps/cleanpix-roll/' . $frame['file']) }}" alt="{{ __($group['name']) }}, {{ $frameName($frame['source']) }}" width="800" height="533" loading="lazy" class="block aspect-[3/2] w-full object-cover">
                                        <span class="absolute top-0 left-0 bg-canvas px-2 py-1 text-base font-semibold text-ink"><span class="cp-keep">{{ __('Kalsın') }}</span><span class="cp-drop">{{ __('Sil') }}</span></span>
                                        <span class="mt-1.5 block truncate text-base font-semibold tabular-nums">{{ $frameName($frame['source']) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                        <p class="self-end text-xl font-semibold leading-snug lg:col-span-4" data-group-line>
                            {{ __('Tutulan kare: :frame. :count kare gidiyor, :mb MB geri geliyor.', ['frame' => $frameName($group['frames'][0]['source']), 'count' => count($group['frames']) - 1, 'mb' => $mb($group['frees'])]) }}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- How it works --}}
    <section class="pt-32 md:pt-48">
        <div class="mx-auto max-w-6xl px-6">
            <div class="grid gap-6 md:grid-cols-12">
                <h2 data-reveal class="text-[clamp(2.25rem,4vw,3.75rem)] font-bold leading-none tracking-[-0.03em] text-ink md:col-span-5">{{ __('Taramadan boş alana') }}</h2>
                <p data-reveal class="text-lg leading-relaxed text-ink md:col-span-5 md:col-start-7">{{ __('CleanPix galerini beş adımda temizler. Sen onaylamadan hiçbir fotoğraf silinmez ve her grupta orijinal işaretli kalır.') }}</p>
            </div>

            <div data-reveal class="cp-stages mt-12 md:mt-16">
                @foreach ($stages as $s => $stage)
                    <div class="cp-stage">
                        <input type="radio" name="cp-stage" id="cp-stage-{{ $s }}" class="sr-only" @checked($s === 0)>
                        <label for="cp-stage-{{ $s }}" class="cp-stage-tab"><span>{{ __($stage['name']) }}</span></label>
                        <div class="cp-stage-body">
                            <div class="flex flex-col justify-between gap-6">
                                <h3 class="text-[clamp(2.25rem,4vw,3.75rem)] font-bold leading-none tracking-[-0.03em]">{{ __($stage['name']) }}</h3>
                                <p class="max-w-[36ch] text-lg leading-relaxed">{{ __($stage['text']) }}</p>
                            </div>
                            <img src="{{ $shot($stage['shot']) }}" alt="{{ __('CleanPix ekranı: :stage', ['stage' => __($stage['name'])]) }}" width="540" height="960" loading="lazy" class="w-[200px] lg:w-[256px]">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="pt-32 md:pt-48">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 md:grid-cols-12 md:gap-6">
            <div class="md:col-span-3">
                <h2 data-reveal class="text-[clamp(2.25rem,4vw,3.75rem)] font-bold leading-none tracking-[-0.03em] text-ink">{{ __('Uygulamanın içinden') }}</h2>
                <p data-reveal class="mt-5 max-w-[30ch] text-lg leading-relaxed text-ink">{{ __('Karşılaştırma telefonunda yapılır; CleanPix hiçbir fotoğrafı internete yüklemez.') }}</p>
                <a data-reveal href="{{ $app['privacy_url'] }}" class="mt-5 inline-block font-semibold text-ink underline decoration-ink/40 underline-offset-4 transition-colors hover:decoration-current">{{ __('Gizlilik Politikası') }}</a>
            </div>

            <ul class="grid grid-cols-2 gap-x-2.5 gap-y-8 md:col-span-9 md:grid-cols-3">
                @foreach ($tiles as $t => $tile)
                    <li data-reveal @class(['col-span-2' => $tile['wide'] ?? false, 'max-md:order-first' => $tile['wide'] ?? false])>
                        <div @class(['flex items-center justify-center', ['bg-surface', 'bg-[#dcd8e8]', 'bg-[#3b3352]'][$t % 3], ($tile['wide'] ?? false) ? 'aspect-[8/5]' : 'aspect-[4/5]'])>
                            <div class="cp-window" style="{{ $crop($tile) }}">
                                <img src="{{ $shot($tile['shot']) }}" alt="" width="540" height="960" loading="lazy">
                            </div>
                        </div>
                        <h3 class="mt-3 text-lg font-semibold text-ink md:text-xl">{{ __($tile['name']) }}</h3>
                        <p class="mt-1 text-base leading-snug text-ink-dim">{{ __($tile['fact']) }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Close: the word is the button. --}}
    <section class="pt-32 md:pt-48">
        <h2 class="sr-only">{{ __("Google Play'de aç") }}</h2>
        <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="cp-cta flex h-[46svh] min-h-[300px] flex-col justify-between px-6 pt-6 pb-6 md:h-[60svh] md:min-h-[420px]">
            <span class="flex items-start justify-between gap-6">
                <span class="max-w-[24ch] text-lg font-semibold leading-snug md:text-xl">{{ __("CleanPix'i Google Play'de aç ve telefonuna kur.") }}</span>
                <svg class="h-8 w-8 shrink-0 md:h-12 md:w-12" viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M12 36L36 12M16 12h20v20" stroke="currentColor" stroke-width="4"/></svg>
            </span>
            <span class="cp-word block font-extrabold uppercase" style="--letters: {{ mb_strlen(__('İndir')) }}">{{ __('İndir') }}</span>
        </a>

        <div class="mx-auto max-w-6xl px-6 pt-10">
            <p class="max-w-[60ch] text-base leading-relaxed text-ink-dim">
                {{ __('Örnek rulodaki fotoğraflar Wikimedia Commons\'tan:') }}
                @foreach ($roll as $group)
                    {{ __($group['name']) }}: {{ $group['author'] }}, {{ $group['licence'] }}
                    (@foreach ($group['frames'] as $frame)<a href="https://commons.wikimedia.org/wiki/File:{{ str_replace(' ', '_', $frame['source']) }}" class="underline underline-offset-2 hover:text-ink">{{ $frameName($frame['source']) }}</a>@if (! $loop->last), @endif @endforeach){{ $loop->last ? '.' : ';' }}
                @endforeach
            </p>
        </div>
    </section>
</div>

<script>
    // Sample scan: picking a keeper updates that group's line and the page total.
    (() => {
        const root = document.querySelector('[data-roll]');
        const lang = document.documentElement.lang;
        const mb = (n) => n.toLocaleString(lang, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const template = @json(__('Tutulan kare: :frame. :count kare gidiyor, :mb MB geri geliyor.'));

        const update = () => {
            let freed = 0;
            root.querySelectorAll('[data-group]').forEach((group) => {
                const frames = [...group.querySelectorAll('input[data-mb]')];
                const keep = frames.find((input) => input.checked) ?? frames[0];
                const frees = frames.reduce((sum, input) => sum + +input.dataset.mb, 0) - +keep.dataset.mb;
                freed += frees;
                group.querySelector('[data-group-mb]').textContent = mb(frees);
                group.querySelector('[data-group-line]').textContent = template
                    .replace(':frame', keep.dataset.name)
                    .replace(':count', frames.length - 1)
                    .replace(':mb', mb(frees));
            });
            root.querySelector('[data-total-mb]').textContent = mb(freed);
        };

        root.addEventListener('change', update);

        // Set the closing word so it spans the band exactly, whatever the language.
        const word = document.querySelector('.cp-word');
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
