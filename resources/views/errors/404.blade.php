@extends('layouts.site')

@section('title', __('Sayfa bulunamadı') . ' — Zettelabs')

@section('content')
    <section class="mx-auto max-w-3xl px-6 py-24 text-center">
        <p class="font-mono text-sm text-ink-dim">404</p>
        <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">{{ __('Sayfa bulunamadı') }}</h1>
        <p class="mt-4 text-ink-dim">{{ __('Aradığınız sayfa taşınmış ya da hiç var olmamış olabilir.') }}</p>
        <a href="{{ route('home') }}" class="mt-8 inline-block rounded-md border border-line bg-surface px-5 py-2.5 text-sm font-medium text-ink transition-colors hover:border-ink-dim">{{ __('Ana sayfaya dön') }}</a>
    </section>
@endsection
