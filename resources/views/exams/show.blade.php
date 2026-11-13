@php
    $fmt = fn ($at) => $at->locale('tr')->translatedFormat('j F Y l, H.i');
    $left = max(0, (int) now()->diffInSeconds($next, false));
    $over = $left === 0;
    $tahmini = $data['estimated'] ? ' (tahmini)' : '';
    $faq = [
        "2027 {$data['name']} ne zaman?" => collect($sessions)->map(fn ($at, $label) => "{$label}: {$fmt($at)}{$tahmini}")->implode('; ') . '.',
        "{$data['to']} kaç gün kaldı?" => $over
            ? "2027 {$data['name']} oturumlarının hepsi yapıldı. Bir sonraki takvim açıklanınca bu sayfa güncellenir."
            : "Bugün itibarıyla " . intdiv($left, 86400) . " gün kaldı ({$fmt($next)}). Yukarıdaki sayaç saat ve dakikayı da canlı gösterir.",
        'Bu tarih kesin mi?' => $data['estimated']
            ? "Hayır, bu tarih tahminidir: {$data['source']}. Resmî takvim açıklanınca güncellenir."
            : "Tarih resmî takvimden alındı: {$data['source']}, son kontrol " . \Carbon\Carbon::parse($data['checked'])->locale('tr')->translatedFormat('j F Y') . ". Kurum takvimi değiştirebilir; kesin bilgi için resmî duyuruları takip et.",
        'Geri sayımı telefonumda nasıl görürüm?' => "Sınav Sayacı uygulamasıyla. {$data['name']} geri sayımını ana ekranına widget olarak koyar; widget her gece kendiliğinden güncellenir. Ücretsizdir, hesap gerektirmez.",
    ];
    $others = collect(config('exams'))->except($exam);
@endphp
@extends('layouts.site')

@section('title', "{$data['to']} kaç gün kaldı? 2027 {$data['name']} geri sayım")
@section('description', "2027 {$data['name']} ne zaman, kaç gün kaldı? {$fmt($next)} tarihine canlı geri sayım, oturum tarihleri ve resmî kaynak.")

@section('content')

    <section class="mx-auto max-w-3xl px-6 pt-10 pb-16 md:pt-16">
        <h1 class="text-4xl font-bold leading-[1.05] tracking-[-0.025em] text-ink md:text-6xl">{{ $data['to'] }} kaç gün kaldı?</h1>
        <p class="mt-4 text-lg text-ink-dim">{{ $data['full'] }} · {{ $fmt($next) }}{{ $tahmini }}</p>

        @if ($over)
            <p class="mt-10 text-2xl font-semibold text-ink">2027 {{ $data['name'] }} yapıldı. Yeni takvim açıklanınca sayaç güncellenecek.</p>
        @else
            <div id="sayac" data-target="{{ $next->getTimestampMs() }}" class="mt-10 grid grid-cols-3 gap-3 text-center md:gap-6" aria-live="off">
                @foreach (['gun' => [intdiv($left, 86400), 'gün'], 'saat' => [intdiv($left % 86400, 3600), 'saat'], 'dk' => [intdiv($left % 3600, 60), 'dakika']] as $key => [$value, $unit])
                    <div class="rounded-2xl bg-surface px-2 py-6">
                        <div data-k="{{ $key }}" class="text-4xl font-bold tabular-nums text-ink sm:text-5xl md:text-7xl">{{ $value }}</div>
                        <div class="mt-1 text-ink-dim">{{ $unit }}</div>
                    </div>
                @endforeach
            </div>
            <script>
                (() => {
                    const el = document.getElementById('sayac'), target = +el.dataset.target;
                    const tick = () => {
                        const s = Math.max(0, Math.floor((target - Date.now()) / 1000));
                        el.querySelector('[data-k=gun]').textContent = Math.floor(s / 86400);
                        el.querySelector('[data-k=saat]').textContent = Math.floor(s % 86400 / 3600);
                        el.querySelector('[data-k=dk]').textContent = Math.floor(s % 3600 / 60);
                    };
                    tick();
                    setInterval(tick, 15000);
                })();
            </script>
        @endif

        <a href="{{ $cta }}" @if (str_starts_with($cta, 'http')) target="_blank" rel="noopener" @endif class="press mt-10 inline-block rounded-full bg-accent px-6 py-3.5 font-semibold text-canvas hover:bg-accent-deep">Geri sayımı telefonunda widget olarak gör</a>

        <h2 class="mt-16 text-2xl font-bold text-ink md:text-3xl">2027 {{ $data['name'] }} tarihleri</h2>
        <ul class="mt-6 divide-y divide-line border-y border-line">
            @foreach ($sessions as $label => $at)
                <li class="flex flex-wrap justify-between gap-x-6 gap-y-1 py-4 text-ink">
                    <span class="font-medium">{{ $label }}</span>
                    <span class="text-ink-dim">{{ $fmt($at) }}{{ $tahmini }}</span>
                </li>
            @endforeach
        </ul>
        <p class="mt-8 max-w-[60ch] text-lg text-ink">{{ $data['about'] }}</p>
        <p class="mt-4 text-sm text-ink-dim">
            Kaynak: {{ $data['source'] }}{{ $data['estimated'] ? ' — tarih tahminidir, resmî değildir' : '' }}. Son kontrol: {{ \Carbon\Carbon::parse($data['checked'])->locale('tr')->translatedFormat('j F Y') }}.
            Bu sayfanın ÖSYM veya MEB ile bağlantısı yoktur.
        </p>
    </section>

    @include('apps.partials.faq', ['faq' => $faq])

    <section class="mx-auto max-w-3xl px-6 pb-24">
        <h2 class="text-2xl font-bold text-ink">Diğer sınavlar</h2>
        <ul class="mt-4 flex flex-wrap gap-3">
            @foreach ($others as $slug => $other)
                <li><a href="{{ route('exams.show', $slug) }}" class="inline-block rounded-full bg-surface px-4 py-2 text-ink hover:text-accent">{{ $other['to'] }} kaç gün kaldı?</a></li>
            @endforeach
        </ul>
    </section>

    <script type="application/ld+json">{!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($faq)->map(fn ($a, $q) => ['@type' => 'Question', 'name' => $q, 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $a]])->values(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>

@endsection
