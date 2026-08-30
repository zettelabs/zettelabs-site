@extends('layouts.site')

@section('title', __('Zettelabs — Mobil Uygulama Stüdyosu'))
@section('description', __('Zettelabs, gündelik problemleri çözen küçük, odaklı mobil uygulamalar geliştiren bağımsız bir stüdyo.'))

@section('content')

    <section class="relative overflow-hidden border-b border-line bg-canvas">
        <div class="glow-blob pointer-events-none absolute -top-40 left-1/2 h-[420px] w-[720px] -translate-x-1/2"></div>
        <div class="dot-grid pointer-events-none absolute inset-0"></div>
        <div class="relative mx-auto max-w-5xl px-6 py-20 md:py-28">
            <span class="inline-flex items-center gap-2 rounded-full border border-line bg-surface/70 px-3 py-1 font-mono text-xs uppercase tracking-wider text-ink-dim">
                {{ __('Mobil uygulama stüdyosu') }}
            </span>
            <h1 class="mt-5 max-w-2xl text-4xl font-bold leading-tight text-balance text-ink md:text-5xl">
                {{ __('Küçük bir ekip, gündelik problemler için') }} <span class="gradient-text">{{ __('odaklı uygulamalar') }}</span> {{ __('yapıyor.') }}
            </h1>
            <p class="mt-4 max-w-xl text-lg text-ink-dim">
                {{ __('Zettelabs bağımsız bir mobil uygulama stüdyosu. Her uygulama tek bir problemi iyi çözmek için var — büyük, karmaşık platformlar değil.') }}
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="#urunler" class="inline-flex items-center gap-2 rounded-full bg-ink px-5 py-3 text-sm font-semibold text-canvas hover:bg-ink/90">
                    {{ __('Uygulamalarımızı gör') }}
                </a>
                <a href="mailto:zettelabs@gmail.com" class="inline-flex items-center gap-2 rounded-full border border-accent/50 px-5 py-3 text-sm font-medium text-ink hover:border-accent">
                    {{ __('Bize ulaşın') }}
                </a>
            </div>
        </div>
    </section>

    <section id="urunler" class="mx-auto max-w-5xl px-6 py-16 md:py-24">
        <h2 class="text-2xl font-semibold text-ink md:text-3xl">{{ __('Uygulamalarımız') }}</h2>
        <p class="mt-2 max-w-xl text-ink-dim">{{ __('Her biri tek bir işi iyi yapmak için tasarlandı.') }}</p>

        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-colors hover:border-accent/40">
                <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-accent-soft px-2.5 py-1 font-mono text-[0.65rem] uppercase tracking-wider text-accent-deep">
                    {{ __("Web'de yayında") }}
                </span>
                <h3 class="mt-4 font-semibold text-ink">{{ __('Fiyat Radarı') }}</h3>
                <p class="mt-2 flex-1 text-sm text-ink-dim">
                    {{ __('İkinci el ürünlerin piyasa değerini fotoğraflayarak saniyeler içinde öğrenin — sahibinden, dolap ve benzeri platformlarda fırsat avlayanlar için.') }}
                </p>
                <a href="https://thriftai.zettelabs.app" class="mt-5 inline-flex items-center gap-1.5 text-sm font-medium text-accent hover:text-accent-deep">
                    {{ __('Siteyi ziyaret et') }}
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 11L11 3M11 3H5M11 3V9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>

            @foreach ($apps as $slug => $item)
                <div class="flex flex-col rounded-2xl border border-line bg-surface p-6 transition-colors hover:border-accent/40">
                    <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-accent-soft px-2.5 py-1 font-mono text-[0.65rem] uppercase tracking-wider text-accent-deep">
                        {{ __($item['kicker']) }}
                    </span>
                    <h3 class="mt-4 font-semibold text-ink">{{ $item['name'] }}</h3>
                    <p class="mt-2 flex-1 text-sm text-ink-dim">
                        {{ __($item['tagline']) }}
                    </p>
                    <a href="{{ route('apps.show', $slug) }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-medium text-accent hover:text-accent-deep">
                        {{ __('Uygulamayı gör') }}
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 11L11 3M11 3H5M11 3V9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="border-t border-line bg-surface">
        <div class="mx-auto max-w-5xl px-6 py-16 md:py-24">
            <h2 class="text-2xl font-semibold text-ink md:text-3xl">{{ __('Nasıl çalışıyoruz') }}</h2>
            <div class="mt-10 grid gap-8 md:grid-cols-3">
                <div>
                    <span class="font-mono text-sm text-accent">01</span>
                    <h3 class="mt-2 font-semibold text-ink">{{ __('Tek problem, tek uygulama') }}</h3>
                    <p class="mt-2 text-sm text-ink-dim">{{ __('Her uygulama dar ve net bir ihtiyaca odaklanır, gereksiz özellik eklemeyiz.') }}</p>
                </div>
                <div>
                    <span class="font-mono text-sm text-accent">02</span>
                    <h3 class="mt-2 font-semibold text-ink">{{ __('Gizliliğe saygılı') }}</h3>
                    <p class="mt-2 text-sm text-ink-dim">{{ __('Mümkün olduğunca az veri topluyoruz, verinin çoğu cihazında kalır.') }}</p>
                </div>
                <div>
                    <span class="font-mono text-sm text-accent">03</span>
                    <h3 class="mt-2 font-semibold text-ink">{{ __('Bağımsız ve küçük') }}</h3>
                    <p class="mt-2 text-sm text-ink-dim">{{ __('Küçük bir ekip olarak çalışıyoruz — hızlı karar alır, hızlı iyileştiririz.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="iletisim" class="mx-auto max-w-5xl px-6 py-16 md:py-24">
        <div class="relative overflow-hidden rounded-2xl border border-line bg-surface p-10 text-center">
            <div class="glow-blob pointer-events-none absolute -bottom-32 left-1/2 h-[280px] w-[500px] -translate-x-1/2 opacity-60"></div>
            <div class="relative">
                <h2 class="text-2xl font-semibold text-ink md:text-3xl">{{ __('Bir sorunuz mu var?') }}</h2>
                <p class="mx-auto mt-2 max-w-md text-ink-dim">{{ __('Uygulamalarımız, iş birlikleri ya da başka bir konuda bize ulaşın.') }}</p>
                <a href="mailto:zettelabs@gmail.com" class="mt-6 inline-flex items-center gap-2 rounded-full bg-ink px-5 py-3 text-sm font-semibold text-canvas hover:bg-ink/90">
                    zettelabs@gmail.com
                </a>
            </div>
        </div>
    </section>

@endsection
