@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', $app['tagline'])

@php
    // The app's own before/after pairs: the same frame, only the background changes.
    $tools = [
        ['tab' => 'Kaldır', 'title' => 'Arka planı kaldır', 'fact' => 'Şeffaf PNG, tam çözünürlük', 'before' => 'remove-original', 'after' => 'remove-removed', 'alt' => 'Arka planı kaldırılmış hali',
            'text' => 'Yapay zekâ konuyu bulur, gerisini siler. Kesimi tam çözünürlükte şeffaf PNG olarak kaydet; istersen boş kenarları kırp.'],
        ['tab' => 'Değiştir', 'title' => 'Arka planı değiştir', 'fact' => 'Şehir, fantastik, minimalist, doğa, mevsimsel ya da düz renk', 'before' => 'change-original', 'after' => 'change-changed', 'alt' => 'Arka planı değiştirilmiş hali',
            'text' => 'Kendini bir şehre, fantastik bir dünyaya ya da doğaya taşı veya sade bir renk seç. Galerindeki bir fotoğraf da arka plan olabilir; konuyu sürükle, iki parmakla boyutlandır.'],
        ['tab' => 'Bulanıklaştır', 'title' => 'Arka planı bulanıklaştır', 'fact' => 'Bulanıklık gücü 1 ile 25 arasında', 'before' => 'blur-original', 'after' => 'blur-blurred', 'alt' => 'Arka planı bulanıklaştırılmış hali',
            'text' => 'Her fotoğrafa yumuşak portre görünümü. Gücü tek bir kaydırıcıyla ayarla; orijinali görmek için Karşılaştır\'a dokun.'],
    ];
    $steps = [
        ['name' => 'Aracı seç', 'text' => 'Ana ekranda Kaldır, Değiştir ya da Bulanıklaştır\'a dokun.', 'shot' => 3, 'alt' => 'Background Wizard ana ekranı', 'tile' => 'bg-surface', 'size' => 'bw-tile-s'],
        ['name' => 'Fotoğrafı ayarla', 'text' => 'Galeriden ya da kameradan bir fotoğraf seç; arka planı ya da bulanıklık gücünü belirle.', 'shot' => 1, 'alt' => 'Arka plan değiştirme ekranı', 'tile' => 'bg-[#0c2a3a]', 'size' => 'bw-tile-m'],
        ['name' => 'Kaydet ve paylaş', 'text' => 'Sonuç galerindeki “Background Wizard” albümüne kaydedilir; istediğin uygulamada paylaş.', 'shot' => 4, 'alt' => 'Fotoğrafa kaydedildi ekranı', 'tile' => 'bg-[#123c52]', 'size' => 'bw-tile-l'],
    ];
    $faq = [
        'Background Wizard ücretli mi?' => 'Hayır, ücretsizdir ve reklamlarla desteklenir. Düzenleme ekranında reklam gösterilmez. Ek arka plan koleksiyonları kısa bir reklam izleyerek 24 saatliğine açılır.',
        'Fotoğraflarım bir yere yükleniyor mu?' => 'Hayır. Konuyu bulan yapay zekâ telefonunda çalışır; fotoğrafların cihazından çıkmaz.',
        'Kesimi hangi biçimde kaydediyor?' => 'Şeffaf arka planlı PNG olarak, tam çözünürlükte. İstersen boş kenarları kırpıp kesimi konuya sıkıca oturtabilirsin.',
        'Kendi fotoğrafımı arka plan yapabilir miyim?' => 'Evet. Galerindeki herhangi bir fotoğrafı seçebilir ya da şehir, fantastik, minimalist, doğa ve mevsimsel koleksiyonlarından veya düz renklerden birini kullanabilirsin.',
        'Kaydettiklerimi nerede bulurum?' => 'Galerindeki “Background Wizard” albümünde. Kaydettikten sonra istediğin uygulamada doğrudan paylaşabilirsin.',
        'Hangi cihazlarda çalışır?' => 'Android 7.0 ve üzeri cihazlarda. Uygulama Türkçe, İngilizce ve altı dilde daha kullanılabilir.',
    ];
    $img = fn (string $name) => asset("images/apps/background-wizard-{$name}.webp");
@endphp

@section('content')

    <style>
        /* Page-local: the app's own deep teal as the second field, and the before/after compare. */
        .bw {
            --bw-field: #0c2a3a;
            --bw-edge: max(1.5rem, calc((100vw - 72rem) / 2 + 1.5rem));
            --bw-h: clamp(1.75rem, 2.4vw, 2.5rem);
            --bw-display: clamp(2.25rem, 6.5vw, 6.5rem);
        }
        @media (min-width: 768px) {
            .bw { --bw-h: clamp(2rem, 2.4vw, 2.5rem); }
        }
        .bw-compare { --pos: 50%; }
        .bw-pair { opacity: 0; transition: opacity 0.35s ease-out; }
        .bw-pair.is-on { opacity: 1; }
        .bw-before { clip-path: inset(0 calc(100% - var(--pos)) 0 0); }
        .bw-after { clip-path: inset(0 0 0 var(--pos)); }
        .bw-knob { left: var(--pos); }
        .bw-range { -webkit-appearance: none; appearance: none; background: transparent; touch-action: pan-y; cursor: ew-resize; }
        .bw-range::-webkit-slider-thumb { -webkit-appearance: none; width: 3rem; height: 100vh; background: transparent; }
        .bw-range::-moz-range-thumb { width: 3rem; height: 100vh; border: 0; background: transparent; }
        .bw-range:focus-visible + .bw-knob { outline: 3px solid var(--color-ink); outline-offset: 3px; }
        .bw-tile-s { height: 30vh; }
        .bw-tile-m { height: 44vh; }
        .bw-tile-l { height: 60vh; }
        @media (max-width: 1023px) {
            .bw-tile-s { height: 60vw; }
            .bw-tile-m { height: 72vw; }
            .bw-tile-l { height: 84vw; }
        }
    </style>

    <div class="bw">

        {{-- Hero and the three tools: the text scrolls, the compare tile holds and swaps to the tool in view. --}}
        <section class="flex flex-col lg:grid lg:grid-cols-2" data-bw-story>
            <div class="bg-[var(--bw-field)] lg:sticky lg:top-0 lg:order-2 lg:h-svh lg:pr-[var(--bw-edge)]">
            <div class="bw-compare relative h-[48svh] overflow-hidden lg:h-full" data-bw-compare>
                @foreach ($tools as $i => $tool)
                    <div class="bw-pair absolute inset-0 {{ $i ? '' : 'is-on' }}" data-bw-pair>
                        <img src="{{ $img($tool['before']) }}" alt="{{ __('Orijinal fotoğraf') }}" width="1100" height="1100" @if ($i) loading="lazy" @endif class="bw-before absolute inset-0 h-full w-full object-cover object-top">
                        <img src="{{ $img($tool['after']) }}" alt="{{ __($tool['alt']) }}" width="1100" height="1100" @if ($i) loading="lazy" @endif class="bw-after absolute inset-0 h-full w-full object-cover object-top">
                    </div>
                @endforeach
                <span class="absolute top-4 left-4 rounded-full bg-canvas px-3 py-1 text-base text-ink lg:top-auto lg:bottom-6 lg:left-6">{{ __('Önce') }}</span>
                <span class="absolute top-4 right-4 rounded-full bg-canvas px-3 py-1 text-base text-ink lg:top-auto lg:right-6 lg:bottom-6">{{ __('Sonra') }}</span>
                <input type="range" min="0" max="100" value="50" aria-label="{{ __('Önceyi ve sonrayı karşılaştır') }}" class="bw-range absolute inset-0 h-full w-full" data-bw-range>
                <span class="bw-knob pointer-events-none absolute top-1/2 flex h-12 w-12 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-ink text-canvas" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M9 6l-6 6 6 6M15 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <div class="absolute bottom-4 left-4 flex flex-wrap gap-2 lg:top-6 lg:bottom-auto lg:left-6" role="group" aria-label="{{ __('Araç') }}">
                    @foreach ($tools as $i => $tool)
                        <button type="button" data-bw-tab="{{ $i }}" aria-pressed="{{ $i ? 'false' : 'true' }}" class="press rounded-full bg-canvas px-4 py-2.5 text-base font-semibold text-ink hover:bg-surface aria-pressed:bg-ink aria-pressed:text-canvas">
                            {{ __($tool['tab']) }}
                        </button>
                    @endforeach
                </div>
            </div>
            </div>

            <div class="pl-6 pr-6 lg:order-1 lg:pl-[var(--bw-edge)] lg:pr-12">
                <div class="flex flex-col pt-8 pb-16 lg:min-h-[calc(100svh-4.5rem)] lg:pt-6 lg:pb-12" data-bw-step="0">
                    <div class="rise hidden items-center gap-3 lg:flex">
                        <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" width="48" height="48" class="h-12 w-12 rounded-xl">
                        <span class="text-xl font-bold text-ink">{{ $app['name'] }}</span>
                    </div>
                    <div class="lg:mt-auto">
                        <h1 class="rise text-[length:var(--bw-h)] font-bold leading-[1.05] tracking-[-0.025em] text-ink" style="--i: 1">{{ __('Kaldır, değiştir, bulanıklaştır') }}</h1>
                        <p class="rise mt-6 max-w-[38ch] text-xl text-ink" style="--i: 2">{{ __('Cihazındaki yapay zekâ fotoğraftaki kişiyi ya da nesneyi bulur; arka planla ne olacağına sen karar verirsin.') }}</p>
                        <div class="rise mt-8 flex flex-wrap items-center gap-x-6 gap-y-4" style="--i: 3">
                            <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press rounded-full bg-accent px-6 py-3.5 font-semibold text-canvas hover:bg-accent-deep">
                                {{ __("Google Play'de aç") }}
                            </a>
                            <a href="{{ $app['privacy_url'] }}" class="font-semibold text-ink underline decoration-transparent underline-offset-4 transition-colors hover:decoration-current">
                                {{ __('Gizlilik Politikası') }}
                            </a>
                        </div>
                    </div>
                </div>

                @foreach ($tools as $i => $tool)
                    <div class="flex flex-col justify-center py-10 lg:min-h-[70svh] lg:py-12" data-bw-step="{{ $i }}">
                        <h2 data-reveal class="text-[length:var(--bw-h)] font-bold leading-[1.05] tracking-[-0.025em] text-ink">{{ __($tool['title']) }}</h2>
                        <p data-reveal class="mt-5 max-w-[42ch] text-xl text-ink">{{ __($tool['text']) }}</p>
                        <p data-reveal class="mt-4 text-base text-ink-dim">{{ __($tool['fact']) }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- The cut-out itself, on a light field so the transparent PNG reads as what it is. --}}
        <section class="overflow-hidden bg-ink text-canvas">
            <div class="mx-auto grid max-w-6xl gap-10 px-6 pt-24 md:grid-cols-12 md:gap-6 md:pt-32">
                <div class="md:col-span-6 md:pb-32">
                    <h2 data-reveal class="text-[length:var(--bw-display)] font-bold leading-[0.92] tracking-[-0.04em]">{{ __('Tek fotoğraf, üç araç') }}</h2>
                    <p data-reveal class="mt-10 max-w-[40ch] text-xl">{{ __('Aynı fotoğraf üzerinde Kaldır, Değiştir ve Bulanıklaştır arasında baştan başlamadan geçiş yap.') }}</p>
                    <p data-reveal class="mt-5 max-w-[40ch] text-xl text-[#4a4558]">{{ __('Fotoğrafların cihazında işlenir, hiçbir yere yüklenmez. Sonuçlar galerindeki “Background Wizard” albümüne kaydedilir.') }}</p>
                </div>
                <img data-reveal src="{{ $img('remove-removed') }}" alt="{{ __('Arka planı kaldırılmış bir portre kesimi') }}" width="1100" height="1163" loading="lazy" class="w-full self-end md:col-span-6">
            </div>
        </section>

        {{-- Three stages, each tile larger than the one before. --}}
        <section class="mx-auto max-w-6xl px-6 py-24 lg:py-40">
            <div class="grid gap-7 lg:grid-cols-12 lg:items-end lg:gap-2.5">
                <h2 data-reveal class="text-[length:var(--bw-h)] font-bold leading-[1.05] tracking-[-0.025em] text-ink lg:col-span-7 lg:row-start-1 lg:self-start">{{ __('Seç, ayarla, kaydet') }}</h2>
                @foreach ($steps as $i => $step)
                    <div data-reveal class="{{ ['lg:col-span-3 lg:row-start-2', 'lg:col-span-4 lg:row-start-2', 'lg:col-span-5 lg:row-span-2 lg:row-start-1'][$i] }}">
                        <div class="{{ $step['size'] }} {{ $step['tile'] }} flex items-end justify-center overflow-hidden rounded-3xl px-6 pt-6">
                            <img src="{{ asset($app['screenshots'][$step['shot']]) }}" alt="{{ __($step['alt']) }}" width="540" height="960" loading="lazy" class="aspect-[540/640] w-[min(78%,20rem)] rounded-t-3xl object-cover object-bottom">
                        </div>
                        <div class="mt-5 lg:min-h-[7.5rem] lg:pr-4">
                            <h3 class="text-xl font-semibold text-ink">{{ __($step['name']) }}</h3>
                            <p class="mt-2 text-base text-ink">{{ __($step['text']) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="bg-surface">
            <div class="mx-auto max-w-6xl px-6 py-24 md:py-40">
                <h2 data-reveal class="text-[length:var(--bw-display)] font-bold leading-[0.92] tracking-[-0.04em] text-ink">{{ __('Sık sorulanlar') }}</h2>
                <div class="mt-12 grid md:mt-20 md:grid-cols-12">
                    <div class="flex flex-col gap-3 md:col-span-8 md:col-start-5">
                        @foreach ($faq as $question => $answer)
                            <details data-reveal class="group -mx-6 rounded-3xl px-6 py-4 transition-colors open:bg-canvas">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-6 text-2xl text-ink [&::-webkit-details-marker]:hidden">
                                    {{ __($question) }}
                                    <svg class="shrink-0 transition-transform group-open:rotate-180" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 7.5l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </summary>
                                <p class="mt-4 max-w-[48ch] pb-2 text-base text-ink">{{ __($answer) }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- The photo returns, blurred, to close the page. --}}
        <section class="bg-[var(--bw-field)]">
            <div class="mx-auto grid max-w-6xl items-center gap-10 px-6 py-24 lg:grid-cols-12 lg:gap-6 lg:py-32">
                <div class="lg:order-2 lg:col-span-4 lg:col-start-9">
                    <h2 data-reveal class="text-[length:var(--bw-h)] font-bold leading-[1.05] tracking-[-0.025em] text-ink">{{ __('Arka planı sen seç') }}</h2>
                    <p data-reveal class="mt-5 text-xl text-ink">{{ __('Ücretsiz indir; fotoğrafların cihazından hiç çıkmaz.') }}</p>
                    <p data-reveal class="mt-4 text-2xl font-semibold text-ink">{{ __('Android 7.0 ve üzeri') }}</p>
                    <a data-reveal href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press mt-8 inline-block rounded-full bg-accent px-6 py-3.5 font-semibold text-canvas hover:bg-accent-deep">
                        {{ __("Google Play'de aç") }}
                    </a>
                </div>
                <div data-reveal class="overflow-hidden rounded-3xl lg:order-1 lg:col-span-7">
                    <img src="{{ $img('blur-blurred') }}" alt="{{ __('Arka planı bulanıklaştırılmış, şapkalı bir kadın portresi') }}" width="1100" height="1100" loading="lazy" class="aspect-[4/5] w-full scale-[1.3] object-cover object-[30%_0%] [transform-origin:30%_0%]">
                </div>
            </div>
        </section>

    </div>

    <script>
        // Compare slider, tool tabs, and the tool that follows the text in view.
        (() => {
            const compare = document.querySelector('[data-bw-compare]');
            const pairs = compare.querySelectorAll('[data-bw-pair]');
            const tabs = document.querySelectorAll('[data-bw-tab]');
            let current = 0;

            const show = (i) => {
                if (i === current) return;
                current = i;
                pairs.forEach((p, n) => p.classList.toggle('is-on', n === i));
                tabs.forEach((t, n) => t.setAttribute('aria-pressed', n === i));
            };

            compare.querySelector('[data-bw-range]').addEventListener('input', (e) => compare.style.setProperty('--pos', e.target.value + '%'));
            tabs.forEach((t) => t.addEventListener('click', () => show(+t.dataset.bwTab)));

            if ('IntersectionObserver' in window) {
                const io = new IntersectionObserver((entries) => entries.forEach((e) => e.isIntersecting && show(+e.target.dataset.bwStep)), { rootMargin: '-55% 0px -40% 0px' });
                document.querySelectorAll('[data-bw-step]').forEach((s) => io.observe(s));
            }
        })();
    </script>

@endsection
