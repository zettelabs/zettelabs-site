<section class="mx-auto max-w-3xl px-6 py-24 md:py-32" aria-labelledby="faq-h">
    <h2 id="faq-h" class="text-3xl font-semibold tracking-tight text-ink md:text-4xl">{{ __('Sık sorulanlar') }}</h2>
    <div class="mt-10 divide-y divide-line border-y border-line">
        @foreach ($faq as $question => $answer)
            <details class="group py-5">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-6 text-lg font-medium text-ink [&::-webkit-details-marker]:hidden">
                    {{ __($question) }}
                    <svg class="shrink-0 text-ink-dim transition-transform group-open:rotate-180" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 7.5l6 6 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </summary>
                <p class="mt-3 max-w-[60ch] text-ink-dim">{{ __($answer) }}</p>
            </details>
        @endforeach
    </div>
</section>
