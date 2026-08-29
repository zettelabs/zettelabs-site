@extends('layouts.site')

@section('title', "Privacy Policy — {$appName}")
@section('description', "Privacy Policy for the {$appName} mobile app.")

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20 text-ink">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Privacy Policy
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">{{ $appName }} — Privacy Policy</h1>

        <div class="prose prose-neutral mt-8 max-w-none prose-headings:font-semibold prose-headings:text-ink prose-p:text-ink-dim prose-li:text-ink-dim prose-a:text-accent prose-strong:text-ink">
            @include('legal.partials.legacy-body', ['appName' => $appName])
        </div>
    </div>

@endsection
