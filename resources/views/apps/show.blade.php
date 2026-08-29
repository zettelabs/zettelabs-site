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

            <span class="mt-6 inline-flex items-center gap-1.5 rounded-full bg-accent-soft px-2.5 py-1 font-mono text-[0.65rem] uppercase tracking-wider text-accent-deep">
                {{ __($app['kicker']) }}
            </span>
            <h1 class="mt-4 text-3xl font-semibold leading-tight text-balance text-ink md:text-4xl">{{ $app['name'] }}</h1>
            <p class="mt-3 max-w-xl text-lg text-ink-dim">{{ __($app['tagline']) }}</p>
            <p class="mt-4 max-w-xl text-ink-dim">{{ __($app['description']) }}</p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-lg bg-ink px-5 py-3 text-sm font-medium text-canvas hover:bg-ink/90">
                    {{ __("Google Play'de aç") }}
                </a>
                <a href="{{ $app['privacy_url'] }}" class="inline-flex items-center gap-2 rounded-lg border border-line px-5 py-3 text-sm font-medium text-ink hover:border-ink/40">
                    {{ __('Gizlilik Politikası') }}
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-6 py-16 md:py-20">
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

@endsection
