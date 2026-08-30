@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', $app['tagline'])

@section('content')

    <section class="border-b border-line bg-surface">
        <div class="mx-auto max-w-3xl px-6 py-16 md:py-24">
            <a href="{{ route('home') }}#urunler" class="inline-flex items-center gap-1.5 text-sm text-ink-dim hover:text-ink">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 3L3 11M3 11H9M3 11V5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ __('Tüm uygulamalar') }}
            </a>

            <div class="mt-6 flex items-center gap-4">
                <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" class="h-16 w-16 shrink-0 rounded-2xl border border-line">
                <div>
                    <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-accent-soft px-2.5 py-1 font-mono text-[0.65rem] uppercase tracking-wider text-accent-deep">
                        {{ __($app['kicker']) }}
                    </span>
                    <h1 class="mt-2 text-3xl font-semibold leading-tight text-balance text-ink md:text-4xl">{{ $app['name'] }}</h1>
                </div>
            </div>
            <p class="mt-5 max-w-xl text-lg text-ink-dim">{{ __($app['tagline']) }}</p>
            <p class="mt-4 max-w-xl text-ink-dim">{{ __($app['description']) }}</p>
        </div>
    </section>

    <section class="py-16 md:py-16">
        <div class="marquee" style="--marquee-duration: {{ count($app['screenshots']) * 4 }}s;">
            <div class="marquee-track">
                @for ($i = 0; $i < 2; $i++)
                    @foreach ($app['screenshots'] as $screenshot)
                        <div class="ml-4 aspect-[9/16] w-48 shrink-0 overflow-hidden rounded-2xl border border-line bg-surface sm:w-56">
                            <img src="{{ asset('images/apps/' . $screenshot) }}" alt="" loading="lazy" class="h-full w-full object-cover object-top">
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-6 pb-16 md:pb-20">
        <h2 class="text-xl font-semibold text-ink">{{ __('Özellikler') }}</h2>
        <ul class="mt-6 grid gap-4 sm:grid-cols-2">
            @foreach ($app['features'] as $feature)
                <li class="flex items-start gap-2.5 rounded-xl border border-line bg-surface p-4 text-sm text-ink-dim">
                    <svg class="mt-0.5 shrink-0 text-accent" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 8.5L6.5 12L13 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ __($feature) }}</span>
                </li>
            @endforeach
        </ul>
    </section>

    <section class="mx-auto max-w-3xl px-6 pb-16 md:pb-24">
        <div class="relative overflow-hidden rounded-2xl border border-line bg-surface p-10 text-center">
            <div class="glow-blob pointer-events-none absolute -bottom-32 left-1/2 h-[280px] w-[500px] -translate-x-1/2 opacity-60"></div>
            <div class="relative">
                <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" class="mx-auto h-14 w-14 rounded-2xl border border-line">
                <h2 class="mt-4 text-2xl font-semibold text-ink">{{ __('Hemen deneyin') }}</h2>
                <p class="mx-auto mt-2 max-w-sm text-ink-dim">{{ __($app['tagline']) }}</p>
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-ink px-5 py-3 text-sm font-semibold text-canvas hover:bg-ink/90">
                        {{ __("Google Play'de aç") }}
                    </a>
                    <a href="{{ $app['privacy_url'] }}" class="inline-flex items-center gap-2 rounded-full border border-accent/50 px-5 py-3 text-sm font-medium text-ink hover:border-accent">
                        {{ __('Gizlilik Politikası') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
