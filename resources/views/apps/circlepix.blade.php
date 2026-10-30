@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', $app['tagline'])

@php
    // Each style pairs a real demo photo with what the app made of it (cropped from its own screen captures).
    $styles = [
        'ring' => ['Halka', 'İnce lacivert kenarlık, açık mavi dolgu. İş profili için yeterince sade.'],
        'fill' => ['Dolgu', 'Krem zemin, pembe daire; baş halkanın üstünden taşar.'],
        'neon' => ['Neon', 'Siyah zemin üstünde mor neon halka, parlaklığı ayarlanabilir.'],
        'badge' => ['#OPENTOWORK', 'Kavisli yeşil rozet, iş aradığını ilk bakışta söyler.'],
        'pastel' => ['Çift renk', 'Krem kenarlık içinde pembe dolgu, tek dokunuşla kaydedildi.'],
    ];
    $stages = [
        ['#cfe0f2', 2, 'Bir dokunuş', 'Önce galeriden bir fotoğraf seç.'],
        ['#f3c6dc', 3, 'Birkaç saniye', 'Sonra yapay zekâ arka planı telefonunda kaldırır.'],
        ['#f8eccd', 6, 'Ne kadar istersen', 'Ardından hazır bir stil seç ya da dolgu, kenarlık ve neonu kendin ayarla.'],
        ['#cfe9dd', 2, 'Bir dokunuş', 'Son olarak galeriye kaydet ya da hemen paylaş.'],
    ];
    $img = fn (string $name) => asset('images/apps/' . (app()->getLocale() === 'en' ? 'en/' : '') . $name);
@endphp

@section('content')
    <style>
        .cp { --cp-coral: #ff5064; --cp-ink: #0f0c18; --cp-paper: #f5f4f8; --cp-cream: #f8eccd; --cp-sky: #cfe0f2; --cp-navy: #1e2a57; --cp-gutter: max(1.5rem, calc((100vw - 72rem) / 2 + 1.5rem)); }

        /* Hero: one headline, two inks. The h1 sets line two in the deep ink; a decorative paper copy of that
           line covers only what lies above the waterline (1.24em down: about a third into the capitals). */
        .cp-hl { font-size: clamp(3.5rem, 15.5vw, 5rem); font-weight: 800; line-height: 0.86; letter-spacing: -0.03em; text-transform: uppercase; }
        @media (min-width: 48rem) { .cp-hl { font-size: clamp(4rem, 9vw, 8.5rem); } }
        .cp-hl-top { color: var(--cp-paper); }
        .cp-hl-top .cp-line + .cp-line { color: var(--cp-ink); background: var(--cp-coral); }
        .cp-hl-dry .cp-line + .cp-line { background: var(--cp-ink); }
        .cp-hl-dry { position: absolute; inset: 0; z-index: 1; pointer-events: none; color: var(--cp-paper); clip-path: inset(-20% -5% calc(100% - 1.24em) -5%); }
        .cp-line { display: block; overflow: hidden; padding-block: 0.1em; margin-block: -0.1em; }
        .cp-line > * { display: block; }
        .cp-sea { position: absolute; z-index: -1; top: 1.24em; left: -100vw; right: -100vw; height: 200vh; background: var(--cp-coral); }

        @media (prefers-reduced-motion: no-preference) {
            .cp-line > * { animation: cp-surface 0.9s cubic-bezier(0.16, 1, 0.3, 1) both; }
            .cp-line + .cp-line > * { animation-delay: 110ms; }
        }
        @keyframes cp-surface { from { transform: translateY(105%); } }

        /* Showcase: the radio you pick shows its own pair; no script needed. */
        .cp-pair { display: none; }
        @foreach (array_keys($styles) as $key)
            .cp-show:has(input[value="{{ $key }}"]:checked) [data-style="{{ $key }}"] { display: block; }
        @endforeach
        .cp-show:not(:has(input:checked)) [data-style="ring"] { display: block; }
        .cp-pick:has(input:checked) { background: var(--cp-paper); color: var(--cp-ink); }
        .cp-pick:has(input:focus-visible) { outline: 3px solid var(--cp-coral); outline-offset: 2px; }

        .cp-split { display: grid; grid-template-columns: 1fr; }
        .cp-split > * { min-width: 0; }
        .cp-split h2 { display: contents; }
        .cp-h1 { grid-area: 1 / 1; } .cp-in { grid-area: 2 / 1; } .cp-h2 { grid-area: 3 / 1; } .cp-out { grid-area: 4 / 1; }
        @media (min-width: 48rem) {
            .cp-split { grid-template-columns: 1fr 1fr; grid-template-rows: 1fr auto; min-height: 90svh; }
            .cp-in { grid-area: 1 / 1; } .cp-h1 { grid-area: 2 / 1; } .cp-out { grid-area: 1 / 2; } .cp-h2 { grid-area: 2 / 2; }
        }

        /* One heading size for every section. */
        .cp-h { font-size: clamp(2.25rem, 10vw, 3rem); font-weight: 700; line-height: 0.95; letter-spacing: -0.03em; }
        @media (min-width: 48rem) { .cp-h { font-size: clamp(2.25rem, 4.6vw, 4.5rem); } }

        /* How it works: the progress bar, enlarged. */
        .cp-stage { min-height: max(4.5rem, calc(var(--g) * 3.6svh)); }
        @media (min-width: 48rem) { .cp-stage { flex: var(--g) 1 0; min-width: 12%; min-height: 0; } }

        /* Features board: 12 columns of 104px rows on desktop, two columns of 28vw rows on a phone. */
        .cp-board { display: grid; gap: 6px; grid-template-columns: repeat(2, 1fr); grid-auto-rows: 28vw; }
        .cp-board > * { overflow: hidden; grid-column: span 1; grid-row: span 2; }
        .cp-board > .w6 { grid-column: span 2; grid-row: span 3; }
        .cp-board > .cp-head { grid-row: span 2; }
        @media (min-width: 48rem) {
            .cp-board { gap: 8px; grid-template-columns: repeat(12, 1fr); grid-auto-rows: 104px; }
            .cp-board > * { grid-column: span 3; grid-row: span 2; }
            .cp-board > .w6 { grid-column: span 6; grid-row: span 2; }
            .cp-board > .h4 { grid-row: span 4; }
        }
    </style>

    <div class="cp">
        {{-- Hero: the round profile picture sits on the waterline between the app's dark screen and its coral. --}}
        <section class="relative isolate overflow-hidden bg-[var(--cp-ink)]">
            <div class="mx-auto flex min-h-[calc(100svh-4.5rem)] max-w-6xl flex-col px-6 pt-4 pb-8 md:pb-12">
                <p class="rise flex items-center gap-3 text-lg font-bold text-[var(--cp-paper)]">
                    <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" width="40" height="40" class="h-10 w-10 rounded-xl">
                    CirclePix
                </p>
                <div class="min-h-6 flex-1"></div>
                <img src="{{ asset('images/apps/circlepix-out-pastel.webp') }}" alt="{{ __('CirclePix ile yapılmış yuvarlak profil fotoğrafı: krem kenarlık, pembe dolgu') }}" width="800" height="800" class="rise mb-6 aspect-square w-[52vw] max-w-64 self-end [clip-path:circle(48.5%)] md:hidden" style="--i: 2">
                <div class="relative">
                    <h1 class="cp-hl cp-hl-top">
                        <span class="cp-line"><span>{{ __('Senin') }}</span></span>
                        <span class="cp-line"><span>{{ __('halkan') }}</span></span>
                    </h1>
                    <b class="cp-hl cp-hl-dry" aria-hidden="true">
                        <i class="cp-line not-italic"><i>&nbsp;</i></i>
                        <i class="cp-line not-italic"><i class="not-italic">{{ __('halkan') }}</i></i>
                    </b>
                    <div class="cp-hl cp-sea"></div>
                    <img src="{{ asset('images/apps/circlepix-out-pastel.webp') }}" alt="{{ __('CirclePix ile yapılmış yuvarlak profil fotoğrafı: krem kenarlık, pembe dolgu') }}" width="800" height="800" class="rise absolute top-[68%] right-0 z-[2] hidden aspect-square w-[min(34vw,27rem)] -translate-y-1/2 [clip-path:circle(48.5%)] md:block" style="--i: 2">
                </div>
                <div class="min-h-8 flex-1"></div>
                <div class="rise flex flex-col gap-6 bg-[var(--cp-coral)] text-[var(--cp-ink)] md:flex-row md:items-end md:justify-between" style="--i: 3">
                    <p class="max-w-xl text-lg">{{ __('CirclePix, herhangi bir fotoğraftan seni saniyeler içinde keser ve renkli bir halkaya yerleştirir: LinkedIn ve WhatsApp için hazır profil fotoğrafı, Android\'de.') }}</p>
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press shrink-0 bg-[var(--cp-ink)] px-6 py-4 text-center font-semibold text-[var(--cp-paper)] hover:bg-[#2a2440] focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[var(--cp-ink)]">
                        {{ __("Google Play'de aç") }}
                    </a>
                </div>
            </div>
        </section>

        {{-- Showcase: what you hand the app on the dark half, what it gives back on the light half. --}}
        <section class="cp-show cp-split" aria-labelledby="cp-show-title">
            <div class="cp-in relative bg-[var(--cp-ink)] pt-2 pr-6 pb-10 pl-[var(--cp-gutter)] md:pt-[18svh] md:pr-10">
                <fieldset class="grid grid-cols-[minmax(0,10rem)_1fr] items-start gap-5 md:grid-cols-1 md:gap-8 lg:grid-cols-[minmax(0,18rem)_1fr]">
                    <legend class="sr-only">{{ __('Bir fotoğraf ve stil seç') }}</legend>
                    <div data-reveal class="md:max-w-[16rem] lg:max-w-none">
                        @foreach ($styles as $key => [$name])
                            <img data-style="{{ $key }}" src="{{ asset("images/apps/circlepix-in-{$key}.webp") }}" alt="{{ __('Seçilen fotoğrafın aslı, arka planıyla') }}" width="600" height="800" loading="lazy" class="cp-pair aspect-[3/4] w-full object-cover">
                        @endforeach
                    </div>
                    <div class="flex flex-col gap-1.5">
                        @foreach ($styles as $key => [$name])
                            <label data-reveal class="cp-pick flex cursor-pointer items-center gap-3 p-1.5 pr-3 text-base text-[var(--cp-paper)] transition-colors hover:bg-white/10 md:text-xl">
                                <input type="radio" name="cp-style" value="{{ $key }}" class="sr-only" @checked($loop->first)>
                                <img src="{{ asset("images/apps/circlepix-in-{$key}.webp") }}" alt="" width="600" height="800" loading="lazy" class="aspect-square w-10 shrink-0 object-cover md:w-14">
                                <span class="min-w-0 break-words">{{ __($name) }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            </div>

            <h2 id="cp-show-title" class="cp-h">
                <span class="cp-h1 flex items-end bg-[var(--cp-ink)] pt-20 pr-6 pb-8 pl-[var(--cp-gutter)] md:pt-2 md:pb-10 text-[var(--cp-paper)]">{{ __('Fotoğrafını seç,') }}</span>
                <span class="cp-h2 flex items-end bg-[var(--cp-sky)] pt-10 pr-[var(--cp-gutter)] pl-6 text-[var(--cp-ink)] md:justify-end md:pt-2 md:pb-10 md:text-right">{{ __('halkanı gör.') }}</span>
            </h2>

            <div class="cp-out bg-[var(--cp-sky)] pt-8 pr-[var(--cp-gutter)] pb-20 pl-6 text-[var(--cp-ink)] md:pt-[18svh] md:pb-10 md:pl-10" aria-live="polite">
                @foreach ($styles as $key => [$name, $line])
                    <figure data-style="{{ $key }}" class="cp-pair ml-auto max-w-[30rem]">
                        <img src="{{ asset("images/apps/circlepix-out-{$key}.webp") }}" alt="{{ __('CirclePix çıktısı') }}: {{ __($name) }}" width="800" height="800" loading="lazy" class="aspect-square w-full {{ $key === 'pastel' ? '[clip-path:circle(48.5%)]' : 'rounded-[6%]' }}">
                        <figcaption class="mt-6">
                            <span class="block text-2xl font-bold">{{ __($name) }}</span>
                            <span class="mt-1 block text-lg">{{ __($line) }}</span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>

        {{-- How it works: the app's own progress bar, enlarged until it is the diagram. --}}
        <section class="bg-[var(--cp-navy)] py-24 text-[var(--cp-paper)] md:py-40">
            <div class="mx-auto max-w-6xl px-6">
                <h2 data-reveal class="cp-h">{{ __('Fotoğraftan profile') }}</h2>
                <ol class="mt-12 flex flex-col gap-1.5 md:mt-16 md:flex-row" data-ui>
                    @foreach ($stages as [$colour, $grow, $time, $clause])
                        <li data-reveal class="cp-stage flex flex-col bg-[var(--seg)] p-4 text-[var(--cp-ink)] md:bg-transparent md:p-0 md:text-[var(--cp-paper)]" style="--seg: {{ $colour }}; --g: {{ $grow }}">
                            <span class="block text-2xl font-bold md:h-[22vh] md:min-h-36 md:bg-[var(--seg)] md:p-5 md:text-[var(--cp-ink)]">{{ __($time) }}</span>
                            <span class="mt-1 block max-w-[22ch] text-base md:mt-4 md:text-lg">{{ __($clause) }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        {{-- Features: the controls themselves, close up. --}}
        <section class="bg-[#f3c6dc] py-24 md:py-40">
            <div class="cp-board mx-auto max-w-6xl px-6">
                <div class="cp-head w6 bg-[var(--cp-navy)] p-5 text-[var(--cp-paper)] md:p-6">
                    <h2 data-reveal class="cp-h max-w-[12ch]">{{ __('Her ayar, yakından') }}</h2>
                </div>

                @foreach ([['w6', 'presets', 'Hazır stiller', 'Hazır görünümler, tek dokunuşla.'], ['w6 h4', 'badge', 'Rozet', '#OPENTOWORK, #HIRING, #FREELANCE ya da kendi yazın.']] as [$size, $file, $name, $line])
                    <figure data-reveal class="{{ $size }} flex flex-col bg-[#111113] text-[var(--cp-paper)]">
                        <img src="{{ $img("circlepix-ui-{$file}.webp") }}" alt="{{ __('CirclePix ekranından kesit') }}: {{ __($name) }}" width="800" height="{{ $file === 'badge' ? 667 : 281 }}" loading="lazy" class="min-h-0 w-full flex-1 object-cover object-top">
                        <figcaption class="p-5"><span class="block text-lg font-semibold">{{ __($name) }}</span><span class="block text-base">{{ __($line) }}</span></figcaption>
                    </figure>
                @endforeach

                <figure data-reveal class="h4 relative flex flex-col justify-end bg-[#cfe9dd] text-[var(--cp-ink)]">
                    <span data-ui aria-hidden="true" class="absolute -top-[0.4em] -right-[0.6em] grid grid-cols-3 gap-[0.35em] text-[3rem] md:text-[3.25rem]">
                        @foreach (['#ffffff', '#cfe0f2', '#f3c6dc', '#dcd3f1', '#cfe9dd', '#f8dcc4', '#f8eccd', '#2e3170', '#ffffff'] as $swatch)
                            <span class="box-content block h-[1em] w-[1em] rounded-full {{ $loop->index === 2 ? 'ring-[0.08em] ring-[var(--cp-coral)] ring-offset-[0.06em] ring-offset-[#1c1b20]' : '' }}" style="background: {{ $swatch }}; border: 0.1em solid #1c1b20"></span>
                        @endforeach
                    </span>
                    <figcaption class="relative bg-[#cfe9dd] p-5"><span class="block text-lg font-semibold">{{ __('Renkler') }}</span><span class="block text-base">{{ __('Dolgu ve kenarlık için hazır renkler.') }}</span></figcaption>
                </figure>

                <figure data-reveal class="h4 flex flex-col bg-[#111113] text-[var(--cp-paper)]">
                    <img src="{{ $img('circlepix-ui-removing.webp') }}" alt="{{ __('CirclePix ekranından kesit') }}: {{ __('Arka plan kaldırılıyor…') }}" width="800" height="874" loading="lazy" class="min-h-0 w-full flex-1 object-cover object-bottom">
                    <figcaption class="p-5"><span class="block text-lg font-semibold">{{ __('Telefonunda kesilir') }}</span><span class="block text-base">{{ __('Fotoğrafın cihazdan çıkmaz.') }}</span></figcaption>
                </figure>

                <figure data-reveal class="relative flex flex-col justify-end bg-[#cfe0f2] text-[var(--cp-ink)]">
                    <span data-ui aria-hidden="true" class="absolute top-[0.25em] -right-[0.45em] flex h-[1em] w-[1.75em] items-center justify-end rounded-full bg-[var(--cp-coral)] p-[0.1em] text-[4.5rem]"><span class="block h-[0.8em] w-[0.8em] rounded-full bg-white"></span></span>
                    <figcaption class="relative p-5"><span class="block text-lg font-semibold">{{ __('Dolgu') }}</span><span class="block text-base">{{ __('Daireyi doldur ya da boş bırak.') }}</span></figcaption>
                </figure>

                <figure data-reveal class="relative flex flex-col justify-end bg-[var(--cp-navy)] text-[var(--cp-paper)]">
                    <span data-ui aria-hidden="true" class="absolute -top-[0.1em] -right-[0.35em] rounded-full bg-[var(--cp-coral)] px-[0.45em] py-[0.12em] text-[3.5rem] leading-none font-bold text-white">PRO</span>
                    <figcaption class="relative p-5"><span class="block text-lg font-semibold">{{ __('Pro stiller') }}</span><span class="block text-base">{{ __('Kavisli rozetler, renk geçişli halkalar.') }}</span></figcaption>
                </figure>

                <figure data-reveal class="w6 relative flex flex-col justify-end bg-white text-[var(--cp-ink)]">
                    <span data-ui aria-hidden="true" class="absolute -top-[0.2em] -right-[0.5em] flex items-center gap-[0.6em] rounded-full bg-[var(--cp-coral)] py-[0.35em] pr-[1em] pl-[0.8em] text-[3.25rem] leading-none font-semibold text-white">
                        <svg class="h-[0.9em] w-[0.9em]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg>
                        {{ __('Paylaş') }}
                    </span>
                    <figcaption class="relative p-5"><span class="block text-lg font-semibold">{{ __('Kaydet ve paylaş') }}</span><span class="block text-base">{{ __('Galeriye ya da doğrudan WhatsApp ve LinkedIn\'e.') }}</span></figcaption>
                </figure>
            </div>
        </section>

        {{-- Close: the app at work, at true size, next to the one action. --}}
        <section class="bg-[var(--cp-coral)] text-[var(--cp-ink)]">
            <div class="mx-auto grid min-h-[90svh] max-w-6xl gap-12 px-6 py-20 md:grid-cols-12 md:gap-6 md:py-24">
                <div class="flex flex-col md:col-span-7 md:justify-end">
                    <h2 data-reveal class="cp-h">
                        <span class="block">{{ __('Profilin') }}</span>
                        <span class="block">{{ __('hazır.') }}</span>
                    </h2>
                    <p data-reveal class="mt-6 max-w-md text-lg">{{ __('CirclePix Android\'de ücretsiz. İndir, bir fotoğraf seç; kesim saniyeler sürer ve fotoğrafın telefonundan çıkmaz.') }}</p>
                    <div data-reveal class="mt-8 flex flex-col gap-5 sm:flex-row sm:items-center">
                        <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press flex h-13 items-center justify-center bg-[var(--cp-ink)] px-6 font-semibold text-[var(--cp-paper)] hover:bg-[#2a2440] focus-visible:outline-3 focus-visible:outline-offset-2 focus-visible:outline-[var(--cp-ink)]">
                            {{ __("Google Play'de aç") }}
                        </a>
                        <a href="{{ $app['privacy_url'] }}" class="font-semibold underline decoration-2 underline-offset-4 hover:decoration-transparent">
                            {{ __('Gizlilik Politikası') }}
                        </a>
                    </div>
                </div>
                <figure data-reveal class="self-center md:col-span-4 md:col-start-9">
                    <video class="mx-auto aspect-[9/20] w-full max-w-[18rem] rounded-[1.75rem] bg-[#111113] object-cover" src="{{ asset('images/apps/circlepix-flow.mp4') }}" poster="{{ asset('images/apps/circlepix-flow-poster.webp') }}" width="576" height="1280" muted loop playsinline autoplay data-cp-clip aria-describedby="cp-clip-caption"></video>
                    <figcaption id="cp-clip-caption" class="mx-auto mt-4 max-w-[18rem] text-base">{{ __('Uygulamadan gerçek bir kayıt: sokakta çekilmiş fotoğraf kesilir, neon halkaya yerleşir.') }}</figcaption>
                </figure>
            </div>
        </section>
    </div>

    <script>
        // Respect reduced motion: hold the clip on its poster and hand the visitor the controls.
        if (matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.querySelectorAll('[data-cp-clip]').forEach((v) => { v.pause(); v.removeAttribute('autoplay'); v.controls = true; });
        }
    </script>
@endsection
