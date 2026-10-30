@extends('layouts.site')

@section('title', __('Zettelabs — Mobil Uygulama Stüdyosu'))
@section('description', __('Zettelabs, gündelik problemleri çözen küçük, odaklı mobil uygulamalar geliştiren bağımsız bir stüdyo.'))

@section('content')

    <section class="mx-auto max-w-6xl px-6 pt-14 pb-24 md:pt-24 md:pb-32">
        <h1 class="rise text-balance text-[clamp(2.5rem,7.2vw,6.5rem)] font-bold leading-[0.95] tracking-[-0.035em] text-ink">
            {{ __('Bir uygulama, bir iş.') }}
        </h1>
        <div class="mt-8 flex flex-col gap-8 md:mt-10 md:flex-row md:items-end md:justify-between">
            <p class="rise max-w-xl text-lg text-ink md:text-xl" style="--i: 1">
                {{ __('Zettelabs bağımsız bir mobil uygulama stüdyosu. Her uygulama tek bir problemi iyi çözmek için var — büyük, karmaşık platformlar değil.') }}
            </p>
            <div class="rise flex shrink-0 flex-wrap items-center gap-6" style="--i: 2">
                <a href="#urunler" class="press rounded-full bg-accent px-6 py-3.5 font-semibold text-canvas hover:bg-accent-deep">
                    {{ __('Uygulamalarımızı gör') }}
                </a>
                <a href="mailto:zettelabs@gmail.com" class="font-semibold text-ink underline-offset-4 hover:underline">
                    {{ __('Bize ulaşın') }}
                </a>
            </div>
        </div>

        <div class="mt-14 grid grid-cols-2 gap-4 md:mt-20 md:grid-cols-4 md:gap-6">
            @foreach ($apps as $slug => $item)
                <a href="{{ route('apps.show', $slug) }}" class="rise group block" style="--i: {{ $loop->index + 3 }}">
                    <img
                        src="{{ asset($item['shot']) }}"
                        alt="{{ $item['name'] }}"
                        width="540"
                        height="960"
                        class="aspect-[9/16] w-full rounded-2xl bg-surface object-cover transition-transform duration-300 ease-out group-hover:-translate-y-2"
                    >
                    <span class="mt-4 block font-semibold text-ink">{{ $item['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section id="urunler" class="scroll-mt-8 bg-surface">
        <div class="mx-auto max-w-6xl px-6 py-24 md:py-32">
            <h2 data-reveal class="text-4xl font-bold tracking-[-0.02em] text-ink md:text-6xl">{{ __('Uygulamalarımız') }}</h2>

            <ul class="mt-12 md:mt-16">
                <li data-reveal class="grid grid-cols-[3.5rem_1fr] items-center gap-x-5 gap-y-3 py-6 md:grid-cols-12 md:gap-x-6 md:py-8">
                    <img src="{{ asset('images/apps/icon-fiyat-radari.webp') }}" alt="" loading="lazy" class="h-14 w-14 rounded-2xl md:col-span-1">
                    <h3 class="text-2xl font-bold text-ink md:col-span-3 md:text-3xl">{{ __('Fiyat Radarı') }}</h3>
                    <p class="col-span-2 text-ink md:col-span-6">
                        {{ __('İkinci el ürünlerin piyasa değerini fotoğraflayarak saniyeler içinde öğrenin — sahibinden, dolap ve benzeri platformlarda fırsat avlayanlar için.') }}
                    </p>
                    <a href="https://thriftai.zettelabs.app" class="col-span-2 font-semibold text-accent hover:text-accent-deep md:col-span-2 md:justify-self-end">
                        {{ __('Siteyi ziyaret et') }} ↗
                    </a>
                </li>
                @foreach ($apps as $slug => $item)
                    <li data-reveal class="grid grid-cols-[3.5rem_1fr] items-center gap-x-5 gap-y-3 py-6 md:grid-cols-12 md:gap-x-6 md:py-8">
                        <img src="{{ asset('images/apps/' . $item['icon']) }}" alt="" loading="lazy" class="h-14 w-14 rounded-2xl md:col-span-1">
                        <h3 class="text-2xl font-bold text-ink md:col-span-3 md:text-3xl">{{ $item['name'] }}</h3>
                        <p class="col-span-2 text-ink md:col-span-6">{{ __($item['tagline']) }}</p>
                        <a href="{{ route('apps.show', $slug) }}" class="col-span-2 font-semibold text-accent hover:text-accent-deep md:col-span-2 md:justify-self-end">
                            {{ __('Uygulamayı gör') }} →
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-12 px-6 py-24 md:grid-cols-12 md:gap-6 md:py-32">
        <h2 data-reveal class="text-4xl font-bold tracking-[-0.02em] text-ink md:col-span-5 md:text-6xl">{{ __('Nasıl çalışıyoruz') }}</h2>
        <div class="grid gap-10 md:col-span-7 md:gap-12">
            <div data-reveal>
                <h3 class="text-2xl font-semibold text-ink">{{ __('Tek problem, tek uygulama') }}</h3>
                <p class="mt-2 text-lg text-ink">{{ __('Her uygulama dar ve net bir ihtiyaca odaklanır, gereksiz özellik eklemeyiz.') }}</p>
            </div>
            <div data-reveal>
                <h3 class="text-2xl font-semibold text-ink">{{ __('Gizliliğe saygılı') }}</h3>
                <p class="mt-2 text-lg text-ink">{{ __('Mümkün olduğunca az veri topluyoruz, verinin çoğu cihazında kalır.') }}</p>
            </div>
            <div data-reveal>
                <h3 class="text-2xl font-semibold text-ink">{{ __('Bağımsız ve küçük') }}</h3>
                <p class="mt-2 text-lg text-ink">{{ __('Küçük bir ekip olarak çalışıyoruz — hızlı karar alır, hızlı iyileştiririz.') }}</p>
            </div>
        </div>
    </section>

@endsection
