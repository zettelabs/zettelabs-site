@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@section('content')

    <section class="mx-auto max-w-6xl px-6 pt-10 pb-24 md:pt-16 md:pb-32">
        <div class="rise flex items-center gap-3">
            <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" width="48" height="48" class="h-12 w-12 rounded-xl">
            <span class="text-xl font-bold text-ink">{{ $app['name'] }}</span>
        </div>
        <h1 class="rise mt-10 max-w-[18ch] text-4xl font-bold leading-[1.05] tracking-[-0.025em] text-ink md:text-6xl" style="--i: 1">{{ __($app['tagline']) }}</h1>
        <p class="rise mt-6 max-w-[48ch] text-xl text-ink" style="--i: 2">{{ __($app['description']) }}</p>
        <div class="rise mt-8 flex flex-wrap items-center gap-x-6 gap-y-4" style="--i: 3">
            @if ($app['play_store'])
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press rounded-full bg-accent px-6 py-3.5 font-semibold text-canvas hover:bg-accent-deep">{{ __("Google Play'de aç") }}</a>
            @else
                <span class="rounded-full bg-surface px-6 py-3.5 font-semibold text-ink">{{ __("Yakında Google Play'de") }}</span>
            @endif
            @if ($app['privacy_url'])
                <a href="{{ $app['privacy_url'] }}" class="font-semibold text-ink underline decoration-transparent underline-offset-4 transition-colors hover:decoration-current">{{ __('Gizlilik Politikası') }}</a>
            @endif
        </div>

        <div class="mt-16 grid grid-cols-2 gap-4 md:mt-24 md:grid-cols-4 md:gap-6">
            @foreach ($app['screenshots'] as $shot)
                <img src="{{ asset($shot) }}" alt="{{ __(':app ekran görüntüsü :n', ['app' => $app['name'], 'n' => $loop->iteration]) }}" width="540" height="960" @if (! $loop->first) loading="lazy" @endif class="aspect-[9/16] w-full rounded-2xl bg-surface object-cover">
            @endforeach
        </div>
    </section>

    <section class="bg-surface">
        <div class="mx-auto max-w-6xl px-6 py-24 md:py-32">
            <h2 class="text-3xl font-bold tracking-[-0.02em] text-ink md:text-5xl">{{ __('Özellikler') }}</h2>
            <ul class="mt-10 grid gap-x-10 gap-y-5 md:grid-cols-2">
                @foreach ($app['features'] as $feature)
                    <li class="border-t border-line pt-5 text-lg text-ink">{{ __($feature) }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('apps.partials.faq', ['faq' => [
        'Offline Scanner ücretli mi?' => 'Hayır, ücretsizdir ve reklamlarla desteklenir.',
        'Belgelerim bir yere yükleniyor mu?' => 'Hayır. Tarama, PDF oluşturma ve metin tanıma telefonunda yapılır; hesap ve bulut yüklemesi yoktur. Yalnızca reklamlar internet kullanır.',
        'İnternet olmadan çalışır mı?' => 'Evet. Tarayıcı modülü ilk kullanımda Google Play hizmetleri üzerinden bir kez indirilir (yaklaşık 200 KB); sonrası tamamen çevrimdışı çalışır.',
        'Metin tanıma hangi dilleri destekler?' => 'Latin alfabesi kullanan dilleri: Türkçe, İngilizce, İspanyolca, Portekizce, Almanca, Endonezce ve benzerleri.',
    ]])

@endsection
