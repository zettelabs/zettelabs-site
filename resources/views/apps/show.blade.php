@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', $app['tagline'])

@section('content')

    <section class="mx-auto max-w-6xl px-6 pt-14 pb-24 md:pt-20 md:pb-32">
        <div class="grid gap-8 md:grid-cols-12 md:items-end md:gap-6">
            <div class="md:col-span-7">
                <div class="rise flex items-center gap-5">
                    <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" class="h-16 w-16 shrink-0 rounded-2xl md:h-20 md:w-20">
                    <h1 class="text-[clamp(2.5rem,6vw,5.5rem)] font-bold leading-[0.95] tracking-[-0.035em] text-ink">{{ $app['name'] }}</h1>
                </div>
                <p class="rise mt-6 max-w-xl text-lg text-ink md:text-xl" style="--i: 1">{{ __($app['tagline']) }}</p>
            </div>
            <div class="rise flex flex-wrap items-center gap-6 md:col-span-5 md:justify-self-end" style="--i: 2">
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press rounded-full bg-accent px-6 py-3.5 font-semibold text-canvas hover:bg-accent-deep">
                    {{ __("Google Play'de aç") }}
                </a>
                <a href="{{ $app['privacy_url'] }}" class="font-semibold text-ink underline-offset-4 hover:underline">
                    {{ __('Gizlilik Politikası') }}
                </a>
            </div>
        </div>

        @if ($app['banner'])
            <img src="{{ asset($app['banner']) }}" alt="{{ $app['name'] }}" width="1024" height="500" class="rise mt-12 aspect-[1024/500] w-full rounded-2xl object-cover md:mt-16" style="--i: 3">
        @endif
    </section>

    <section class="bg-surface py-24 md:py-32">
        <div class="mx-auto grid max-w-6xl gap-12 px-6 md:grid-cols-12 md:gap-6">
            <div class="md:col-span-5">
                <h2 data-reveal class="text-4xl font-bold tracking-[-0.02em] text-ink md:text-5xl">{{ __('Özellikler') }}</h2>
                <p data-reveal class="mt-5 text-lg text-ink">{{ __($app['description']) }}</p>
            </div>
            <ul class="grid gap-6 md:col-span-6 md:col-start-7">
                @foreach ($app['features'] as $feature)
                    <li data-reveal class="flex items-start gap-3 text-lg text-ink">
                        <svg class="mt-1.5 shrink-0 text-accent" width="18" height="18" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8.5L6.5 12L13 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>{{ __($feature) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Four copies so half the track (the loop distance) always outruns a wide screen. --}}
        <div class="marquee mt-20 md:mt-28" style="--marquee-duration: {{ count($app['screenshots']) * 8 }}s;">
            <div class="marquee-track">
                @for ($i = 0; $i < 4; $i++)
                    @foreach ($app['screenshots'] as $screenshot)
                        <div class="ml-6 aspect-[9/16] w-56 shrink-0 overflow-hidden rounded-2xl sm:w-64">
                            <img src="{{ asset($screenshot) }}" alt="" loading="lazy" class="h-full w-full object-cover object-top">
                        </div>
                    @endforeach
                @endfor
            </div>
        </div>
    </section>

@endsection
