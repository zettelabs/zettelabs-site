@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    use Carbon\Carbon;

    $today = Carbon::today('Europe/Istanbul');
    $screen = fn (string $n) => asset("images/apps/screen-sinavsayaci-{$n}.webp");

    // Each exam's next session from config/exams.php (the same dates the app ships and the SEO pages use).
    $exams = [];
    foreach (config('exams') as $slug => $exam) {
        foreach ($exam['sessions'] as $label => $when) {
            $date = Carbon::parse($when, 'Europe/Istanbul')->startOfDay();
            if ($date->gte($today)) {
                $exams[$slug] = [
                    'slug' => $slug,
                    'name' => $slug === 'yks' ? 'YKS · TYT' : $exam['name'],
                    'to' => $exam['to'],
                    'date' => $date->toDateString(),
                    'days' => (int) $today->diffInDays($date),
                ];
                break;
            }
        }
    }
    $first = $exams['yks'] ?? reset($exams);
    $seasonStart = Carbon::create(2026, 9, 1, 0, 0, 0, 'Europe/Istanbul');
    $weeksTotal = (int) ceil($seasonStart->diffInDays(Carbon::parse($first['date'], 'Europe/Istanbul')) / 7);
    $weeksGone = min($weeksTotal, (int) floor($seasonStart->diffInDays($today, false) / 7));
    $examsJson = json_encode(array_values($exams));

    $faq = [
        'Sınav Sayacı ücretli mi?' => 'Hayır, ücretsizdir ve reklamlarla desteklenir. Widget ücretsizdir, hiçbir zaman kilitlenmez ve içinde reklam yoktur. 3 ek widget teması kısa bir reklam izleyerek açılır.',
        'Sınav tarihleri nereden geliyor?' => 'ÖSYM\'nin ve MEB\'in yayımladığı 2027 sınav takvimlerinden. Takvim değişirse uygulama güncellenir; o zamana kadar tarihi elle düzeltebilirsin. Resmî duyuruları her zaman osym.gov.tr ve meb.gov.tr\'den kontrol et.',
        'Verilerim nerede?' => 'Hesap yok, bulut yok. Sınavların, netlerin ve hedeflerin yalnızca telefonunda durur. Yalnızca reklamlar internet kullanır. Sınav Sayacı\'nın ÖSYM, MEB veya herhangi bir kamu kurumuyla bağlantısı yoktur.',
    ];
@endphp

@section('content')
<div class="ss" data-ss data-today="{{ $today->toDateString() }}" data-season="{{ $seasonStart->toDateString() }}">
    <style>
        /* Sınav Sayacı page: the app's own colours, and the app's own motif: one dot per week until the exam. */
        .ss {
            --ss-teal: #2C5F6B;
            --ss-teal-deep: #234E58;
            --ss-teal-soft: #4B7C88;
            --ss-yellow: #FFD84A;
            --ss-cream: #F3F1EC;
            --ss-cream-2: #E6E3DB;
            --ss-ink: #15171A;
            --ss-coral: #F2603D;
            --ss-blue: #A9D3E8;
            --ss-green: #C9E3B5;
            --ss-peach: #FFE0D6;
            color: var(--ss-ink);
        }
        .ss-pad { padding-inline: 24px; }
        .ss-wrap { max-width: 72rem; margin-inline: auto; }
        .ss-h2 { font-size: clamp(2rem, 3.9vw, 3.5rem); line-height: 0.98; letter-spacing: -0.035em; font-weight: 800; }
        .ss-lead { font-size: 1.1875rem; line-height: 1.5; max-width: 40ch; }
        .ss-btn {
            display: inline-flex; align-items: center; min-height: 48px; padding: 0 26px; border-radius: 999px;
            font-weight: 700; background: var(--ss-yellow); color: var(--ss-ink);
            transition: transform .15s ease-out, background-color .15s ease-out;
        }
        .ss-btn:hover { background: #fff; }
        .ss-btn:active { transform: scale(.97); }
        .ss-btn:focus-visible, .ss-chip:focus-visible, .ss-seg:focus-visible, .ss-q-btn:focus-visible, .ss-row:focus-visible { outline: 3px solid var(--ss-coral); outline-offset: 3px; }
        .ss-link { font-weight: 700; text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 5px; }

        /* Hero: one teal field, the number as the loudest thing, the weeks as dots. */
        .ss-hero { background: var(--ss-teal); color: #fff; min-height: calc(100svh - 76px); padding-block: 40px 72px; }
        .ss-hero-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 48px; align-items: center; }
        @media (min-width: 1024px) { .ss-hero-grid { grid-template-columns: minmax(0, 7fr) minmax(0, 5fr); gap: 64px; } }
        .ss-display { font-size: clamp(2.5rem, 4.9vw, 4.5rem); line-height: 0.95; letter-spacing: -0.04em; font-weight: 800; }
        .ss-line { display: block; overflow: hidden; padding-bottom: .08em; margin-bottom: -.08em; }
        .ss-line > span { display: block; animation: ss-up .9s cubic-bezier(.16, 1, .3, 1) both; }
        .ss-line:nth-child(2) > span { animation-delay: .11s; }
        @keyframes ss-up { from { transform: translateY(105%); } }
        .ss-chips { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 36px; }
        .ss-chip {
            min-height: 48px; padding: 0 20px; border-radius: 999px; font-weight: 700; font-size: 1rem;
            background: var(--ss-teal-deep); color: #fff; transition: transform .15s ease-out, background-color .15s ease-out;
        }
        .ss-chip:hover { background: var(--ss-teal-soft); }
        .ss-chip:active { transform: scale(.96); }
        .ss-chip[aria-pressed="true"] { background: var(--ss-yellow); color: var(--ss-ink); }
        .ss-count { display: flex; align-items: baseline; flex-wrap: wrap; gap: 6px 20px; margin-top: 28px; }
        .ss-num { font-size: clamp(6rem, 15vw, 13rem); line-height: .82; letter-spacing: -0.05em; font-weight: 800; color: var(--ss-yellow); font-variant-numeric: tabular-nums; }
        .ss-numlabel { font-size: clamp(1.5rem, 2.4vw, 2.25rem); font-weight: 700; }
        .ss-reprint { animation: ss-print .35s cubic-bezier(.2, .7, .2, 1); }
        @keyframes ss-print { from { opacity: 0; transform: translateY(14px); } }
        .ss-dots { display: grid; grid-template-columns: repeat(auto-fill, 14px); gap: 7px; margin-top: 32px; max-width: 640px; }
        .ss-dots i { width: 14px; height: 14px; border-radius: 50%; background: var(--ss-yellow); display: block; }
        .ss-dots i.gone { background: var(--ss-teal-soft); }
        .ss-dots i.last { background: var(--ss-coral); }
        .ss-dotnote { margin-top: 14px; font-size: 1rem; color: #fff; opacity: .9; }
        .ss-cta { display: flex; flex-wrap: wrap; align-items: center; gap: 16px 28px; margin-top: 36px; }
        .ss-phone { width: min(100%, 360px); margin-inline: auto; display: block; border-radius: 36px; background: var(--ss-teal-deep); height: auto; }

        /* Widgets: the widget, drawn live at the app's own sizes, on a yellow stage. */
        .ss-widgets { background: var(--ss-cream); padding-block: clamp(96px, 12vw, 180px); }
        .ss-split { display: grid; grid-template-columns: minmax(0, 1fr); gap: 56px; align-items: center; }
        .ss-text-first { order: -1; }
        @media (min-width: 1024px) { .ss-text-first { order: 0; } }
        @media (min-width: 1024px) { .ss-split { grid-template-columns: minmax(0, 6fr) minmax(0, 6fr); gap: 80px; } }
        .ss-stage { background: var(--ss-yellow); min-height: 520px; display: grid; place-items: center; padding: 32px; border-radius: 28px; }
        [data-ui].ss-w { background: var(--ss-teal); color: #fff; border-radius: 28px; transition: width .35s cubic-bezier(.2, .7, .2, 1), height .35s cubic-bezier(.2, .7, .2, 1); overflow: hidden; }
        .ss-w { max-width: 100%; }
        .ss-w[data-size="2x1"] { width: 300px; height: 160px; padding: 22px 24px; }
        .ss-w[data-size="2x2"] { width: 300px; height: 400px; padding: 28px 26px; }
        .ss-w[data-size="4x2"] { width: 420px; height: 300px; padding: 18px; }
        .ss-w .wd-1, .ss-w .wd-2, .ss-w .wd-4 { display: none; }
        .ss-w[data-size="2x1"] .wd-1, .ss-w[data-size="2x2"] .wd-2, .ss-w[data-size="4x2"] .wd-4 { display: block; }
        .w-name { font-weight: 700; font-size: 1rem; }
        .w-big { font-weight: 800; letter-spacing: -0.04em; line-height: 1; font-variant-numeric: tabular-nums; }
        .wd-1 .w-big { font-size: 3rem; color: var(--ss-yellow); }
        .wd-1 .w-bar { display: flex; gap: 4px; margin-top: 16px; }
        .wd-1 .w-bar b { flex: 1; height: 14px; border-radius: 4px; background: var(--ss-teal-soft); }
        .wd-1 .w-bar b.on { background: var(--ss-yellow); }
        .wd-2 .w-big { font-size: 5.25rem; margin-top: 18px; }
        .wd-2 .w-dots { display: grid; grid-template-columns: repeat(auto-fill, 12px); gap: 6px; margin-top: 26px; }
        .wd-2 .w-dots i { width: 12px; height: 12px; border-radius: 50%; background: var(--ss-yellow); }
        .wd-2 .w-dots i.gone { background: var(--ss-teal-soft); }
        .wd-4 { display: none; }
        .wd-4 .w-tiles { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; height: 264px; }
        .w-tile { border-radius: 20px; padding: 18px; color: var(--ss-ink); display: flex; flex-direction: column; justify-content: space-between; }
        .w-tile .w-big { font-size: 4rem; }
        .w-tile small { font-size: .9375rem; font-weight: 600; display: block; margin-top: 6px; }
        .ss-segs { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 32px; }
        .ss-seg { min-height: 48px; padding: 0 22px; border-radius: 999px; font-weight: 700; background: var(--ss-cream-2); color: var(--ss-ink); transition: transform .15s ease-out, background-color .15s ease-out; }
        .ss-seg:hover { background: #D8D4CA; }
        .ss-seg:active { transform: scale(.96); }
        .ss-seg[aria-pressed="true"] { background: var(--ss-ink); color: var(--ss-yellow); }
        .ss-phone-only { display: block; }
        @media (min-width: 1024px) { .ss-phone-only { display: none; } }
        .ss-shot { width: 100%; max-width: 380px; border-radius: 32px; display: block; background: var(--ss-cream-2); }

        /* Nets: a yellow field, the app's own net chart at real size. */
        .ss-nets { background: var(--ss-yellow); padding-block: clamp(96px, 12vw, 180px); }
        .ss-nets .ss-lead { font-size: 1.25rem; }
        .ss-facts { margin-top: 36px; display: grid; gap: 20px; max-width: 44ch; font-size: 1.125rem; line-height: 1.5; }
        .ss-facts b { font-weight: 800; }

        /* The exams: every exam as a field of its own, the days left set large. */
        .ss-exams { background: var(--ss-ink); color: #fff; padding-block: clamp(96px, 12vw, 180px); }
        .ss-rows { display: grid; gap: 10px; margin-top: 56px; }
        .ss-row {
            display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 8px 24px; align-items: baseline;
            padding: 22px clamp(18px, 2.4vw, 36px); border-radius: 20px; background: #20242A; color: #fff;
            transition: background-color .15s ease-out, transform .15s ease-out;
        }
        .ss-row:hover { background: var(--ss-yellow); color: var(--ss-ink); }
        .ss-row:active { transform: scale(.995); }
        .ss-row-name { font-size: clamp(1.5rem, 3vw, 2.5rem); font-weight: 800; letter-spacing: -0.03em; line-height: 1.05; }
        .ss-row-date { font-size: 1rem; margin-top: 6px; opacity: .85; }
        .ss-row-days { font-size: clamp(2.5rem, 5vw, 4.5rem); font-weight: 800; letter-spacing: -0.04em; line-height: 1; font-variant-numeric: tabular-nums; text-align: right; }
        .ss-row-days small { font-size: 1rem; font-weight: 700; letter-spacing: 0; margin-left: 8px; }

        /* Run-in column: the exams screen at the left, the quiet paragraphs at the right. */
        .ss-run { background: var(--ss-cream); padding-block: clamp(96px, 12vw, 180px); }
        .ss-col { max-width: 560px; }
        .ss-col p { font-size: 1.1875rem; line-height: 1.6; margin-top: 28px; }
        .ss-col p b { font-weight: 800; }
        .ss-col p span { color: #4a4d52; }

        /* Questions: an index, one answer. */
        .ss-faq { background: var(--ss-teal); color: #fff; padding-block: clamp(96px, 12vw, 180px); }
        .ss-faq-grid { display: grid; gap: 40px; margin-top: 48px; }
        @media (min-width: 1024px) { .ss-faq-grid { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); gap: 80px; } }
        .ss-q-btn { display: flex; gap: 14px; align-items: baseline; width: 100%; text-align: left; font-size: 1.125rem; font-weight: 600; padding: 9px 0; color: #fff; opacity: .78; transition: opacity .15s; }
        .ss-q-btn::before { content: ''; flex: none; width: 8px; height: 8px; border-radius: 50%; background: var(--ss-teal-soft); transform: translateY(-1px); }
        .ss-q-btn:hover { opacity: 1; }
        .ss-q-btn[aria-expanded="true"] { opacity: 1; font-weight: 800; }
        .ss-q-btn[aria-expanded="true"]::before { background: var(--ss-yellow); }
        .ss-a { font-size: 1.0625rem; line-height: 1.55; padding: 4px 0 14px 22px; max-width: 52ch; }
        .ss-pane { display: none; }
        .ss-js .ss-a { display: none; }
        .ss-js .ss-q.is-open .ss-a { display: block; }
        @media (min-width: 1024px) {
            .ss-js .ss-q.is-open .ss-a { display: none; }
            .ss-js .ss-pane { display: block; position: sticky; top: 120px; align-self: start; font-size: clamp(1.5rem, 2.2vw, 1.875rem); line-height: 1.3; max-width: 30ch; }
            .ss-pane.ss-reprint { animation: ss-print .15s ease-out; }
        }

        /* The close: one sentence, one action. */
        .ss-close { background: var(--ss-cream); padding-block: clamp(120px, 16vw, 240px); }
        .ss-close p { font-size: 1.375rem; line-height: 1.4; max-width: 34ch; font-weight: 600; }

        @media (prefers-reduced-motion: reduce) {
            .ss-line > span, .ss-reprint { animation: none; }
            [data-ui].ss-w { transition: none; }
        }
    </style>

    <section class="ss-hero ss-pad" aria-labelledby="ss-h1">
        <div class="ss-hero-grid ss-wrap">
            <div>
                <h1 id="ss-h1" class="ss-display"><span class="ss-line"><span>{{ __('Sınavına') }}</span></span><span class="ss-line"><span>{{ __('kaç gün kaldı?') }}</span></span></h1>
                <p class="rise ss-lead mt-6" style="--i: 2">{{ __("YKS, LGS, KPSS ve diğer ÖSYM sınavları için ana ekranda geri sayım widget'ı. Gece yarısı kendiliğinden güncellenir.") }}</p>

                <div class="rise ss-chips" role="group" aria-label="{{ __('Sınavını seç') }}" style="--i: 3">
                    @foreach ($exams as $exam)
                        <button type="button" class="ss-chip" data-exam="{{ $exam['slug'] }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $exam['name'] }}</button>
                    @endforeach
                </div>

                <div class="ss-count" aria-live="polite">
                    <span class="ss-num" data-days>{{ $first['days'] }}</span>
                    <span class="ss-numlabel">{{ __('gün kaldı') }} · <span data-weeks>{{ $weeksTotal - $weeksGone }}</span> {{ __('hafta') }}</span>
                </div>
                <div class="ss-dots" data-dots aria-hidden="true">
                    @for ($i = 0; $i < $weeksTotal; $i++)<i class="{{ $i < $weeksGone ? 'gone' : '' }}{{ $i === $weeksTotal - 1 ? ' last' : '' }}"></i>@endfor
                </div>
                <p class="ss-dotnote">{{ __('Her nokta bir hafta. Eylülden bugüne kadar olanlar soluk, sınava kadar olanlar sarı.') }}</p>

                <div class="ss-cta">
                    @if ($app['play_store'])
                        <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="ss-btn">{{ __("Google Play'de aç") }}</a>
                    @else
                        <span class="ss-btn">{{ __("Yakında Google Play'de") }}</span>
                    @endif
                    @if ($app['privacy_url'])
                        <a href="{{ $app['privacy_url'] }}" class="ss-link">{{ __('Gizlilik Politikası') }}</a>
                    @endif
                </div>
            </div>
            <img src="{{ $screen('home') }}" alt="{{ __('Sınav Sayacı ana ekranı: 219 gün kaldı, haftalık noktalar, başvuru ve sonuç tarihleri') }}" width="720" height="1300" class="ss-phone">
        </div>
    </section>

    <section class="ss-widgets ss-pad" aria-labelledby="ss-widgets-h">
        <div class="ss-split ss-wrap">
            <div data-reveal>
                <h2 id="ss-widgets-h" class="ss-h2">{{ __('Ana ekranında hep doğru gün') }}</h2>
                <p class="ss-lead mt-6">{{ __('Üç boyutta widget. Telefon yeniden başlasa, saat ya da saat dilimi değişse de kendini yeniler. Widget\'ta reklam yok.') }}</p>
                <div class="ss-segs" role="group" aria-label="{{ __('Widget boyutu') }}">
                    <button type="button" class="ss-seg" data-size="2x1" aria-pressed="false">2×1</button>
                    <button type="button" class="ss-seg" data-size="2x2" aria-pressed="true">2×2</button>
                    <button type="button" class="ss-seg" data-size="4x2" aria-pressed="false">4×2</button>
                </div>
                <p class="mt-6 max-w-[44ch] text-lg leading-relaxed" style="color: #4a4d52">{{ __('Yukarıda seçtiğin sınav burada da görünür. 2×1 gün sayısını, 2×2 sınav adını ve haftalık noktaları, 4×2 iki sınavı gösterir.') }}</p>
            </div>
            <div class="ss-stage" data-reveal>
                <div class="ss-w" data-ui data-size="2x2" data-widget>
                    <div class="wd-1">
                        <div class="w-big"><span data-w-days>{{ $first['days'] }}</span><small class="text-base font-bold" style="letter-spacing: 0"> {{ __('gün') }} · <span data-w-name>{{ $first['name'] }}</span></small></div>
                        <div class="w-bar" data-w-bar></div>
                    </div>
                    <div class="wd-2">
                        <div class="w-name" data-w-name>{{ $first['name'] }}</div>
                        <div class="w-big"><span data-w-days>{{ $first['days'] }}</span> <small class="text-xl font-bold" style="letter-spacing: 0">{{ __('gün') }}</small></div>
                        <div class="w-dots" data-w-dots></div>
                    </div>
                    <div class="wd-4">
                        <div class="w-tiles">
                            <div class="w-tile" style="background: var(--ss-blue)"><div class="w-name" data-w-name>{{ $first['name'] }}</div><div><div class="w-big" data-w-days>{{ $first['days'] }}</div><small data-w-date></small></div></div>
                            <div class="w-tile" style="background: var(--ss-green)"><div class="w-name" data-w-name2></div><div><div class="w-big" data-w-days2></div><small data-w-date2></small></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{ $screen('widgets') }}" alt="{{ __('Ana ekranda üç Sınav Sayacı widget\'ı: 2×1, 4×2 ve 2×2') }}" width="720" height="1140" loading="lazy" class="ss-shot ss-phone-only mx-auto mt-24">
    </section>

    <section class="ss-nets ss-pad" aria-labelledby="ss-nets-h">
        <div class="ss-split ss-wrap">
            <img src="{{ $screen('nets') }}" alt="{{ __('Deneme netleri ekranı: son net 66,50, ilk denemeden +18,00, altı denemenin grafiği') }}" width="720" height="1316" loading="lazy" class="ss-shot" data-reveal>
            <div data-reveal class="ss-text-first">
                <h2 id="ss-nets-h" class="ss-h2">{{ __('Netlerin yukarı gidiyor mu?') }}</h2>
                <p class="ss-lead mt-6">{{ __('TYT, AYT, LGS ya da diğer denemelerinin netini kaydet, gelişimini grafikte gör.') }}</p>
                <div class="ss-facts">
                    <p><b>{{ __('Günlük soru hedefi.') }}</b> {{ __('Bugün kaç soru çözdüğünü say, çalışma serini koru.') }}</p>
                    <p><b>{{ __('Çalışma serisi.') }}</b> {{ __('Her gün biraz çalış; seri bozulmasın.') }}</p>
                    <p><b>{{ __('Hesap yok.') }}</b> {{ __('Netlerin ve hedeflerin yalnızca telefonunda durur.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="ss-exams ss-pad" aria-labelledby="ss-exams-h">
        <div class="ss-wrap">
            <h2 id="ss-exams-h" class="ss-h2">{{ __('Sınavına kaç gün kaldı?') }}</h2>
            <p class="ss-lead mt-6">{{ __('ÖSYM ve MEB 2027 takviminden her sınavın sıradaki oturumu. Birine dokun, sayfasını aç.') }}</p>
            <div class="ss-rows">
                @foreach (config('exams') as $slug => $exam)
                    @continue(! isset($exams[$slug]))
                    @php($row = $exams[$slug])
                    <a href="{{ route('exams.show', $slug) }}" lang="tr" class="ss-row" data-reveal>
                        <span>
                            <span class="ss-row-name block">{{ $exam['to'] }} kaç gün kaldı?</span>
                            <span class="ss-row-date block">{{ Carbon::parse($row['date'])->locale('tr')->translatedFormat('j F Y l') }}</span>
                        </span>
                        <span class="ss-row-days">{{ $row['days'] }}<small>gün</small></span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ss-run ss-pad" aria-labelledby="ss-run-h">
        <div class="ss-split ss-wrap">
            <img src="{{ $screen('exams') }}" alt="{{ __('Sınavlarım ekranı: YKS TYT ve AYT, LGS, KPSS, MSÜ ve ALES tarihleri işaretlenebilir') }}" width="720" height="1316" loading="lazy" class="ss-shot" data-reveal>
            <div class="ss-col ss-text-first" data-reveal>
                <h2 id="ss-run-h" class="ss-h2">{{ __('Tarih değişirse düzelt') }}</h2>
                <p><b>{{ __('Önce sınavını seç.') }}</b> <span>{{ __('Birden çok sınav işaretleyebilirsin; ilki ana sayaç olur. Okul sınavı ya da ehliyet gibi kendi sınavını da ekle.') }}</span></p>
                <p><b>{{ __('Sonra tarihi gör.') }}</b> <span>{{ __('Gün, saat ve dakika sayacı; başvuru ve sonuç tarihleri hep yanında.') }}</span></p>
                <p><b>{{ __('Gün yaklaşınca haber alırsın.') }}</b> <span>{{ __('İsteğe bağlı sabah bildirimi gelir; başvurunun bitmesine 3 gün kala ve sonuç günü de haber verir.') }}</span></p>
                <p><b>{{ __('İstersen paylaş.') }}</b> <span>{{ __('"X gün kaldı" görselini ana ya da kilit ekranına duvar kâğıdı yap ya da arkadaşına gönder.') }}</span></p>
            </div>
        </div>
    </section>

    <section class="ss-faq ss-pad" aria-labelledby="faq-h">
        <div class="ss-wrap">
            <h2 id="faq-h" class="ss-h2">{{ __('Sık sorulanlar') }}</h2>
            <div class="ss-faq-grid">
                <div data-faq>
                    @foreach ($faq as $question => $answer)
                        <div class="ss-q {{ $loop->first ? 'is-open' : '' }}">
                            <button type="button" class="ss-q-btn" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">{{ __($question) }}</button>
                            <p class="ss-a" data-a>{{ __($answer) }}</p>
                        </div>
                    @endforeach
                </div>
                <p class="ss-pane" data-pane aria-live="polite"></p>
            </div>
        </div>
    </section>

    <section class="ss-close ss-pad">
        <div class="ss-wrap">
            <p data-reveal>{{ __('Sınavın bir gün yaklaştı. Sayacı ana ekranına koy, gerisini gece yarısı kendisi yapsın.') }}</p>
            <div class="ss-cta" data-reveal>
                @if ($app['play_store'])
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="ss-btn" style="background: var(--ss-ink); color: var(--ss-yellow)">{{ __("Google Play'de aç") }}</a>
                @else
                    <span class="ss-btn" style="background: var(--ss-ink); color: var(--ss-yellow)">{{ __("Yakında Google Play'de") }}</span>
                @endif
                @if ($app['privacy_url'])
                    <a href="{{ $app['privacy_url'] }}" class="ss-link">{{ __('Gizlilik Politikası') }}</a>
                @endif
            </div>
        </div>
    </section>

    <script>
        (() => {
            const root = document.querySelector('[data-ss]');
            root.classList.add('ss-js');
            const lang = document.documentElement.lang;
            const exams = {!! $examsJson !!};
            const day = 86400000;
            const parse = (s) => { const [y, m, d] = s.split('-').map(Number); return Date.UTC(y, m - 1, d); };
            const now = new Date();
            const today = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate());
            const season = parse(root.dataset.season);
            const fmt = (s) => new Date(parse(s)).toLocaleDateString(lang, { day: 'numeric', month: 'short', timeZone: 'UTC' });
            const daysTo = (e) => Math.round((parse(e.date) - today) / day);
            const weeksOf = (e) => Math.max(1, Math.ceil((parse(e.date) - season) / (7 * day)));
            const goneOf = (e) => Math.min(weeksOf(e), Math.max(0, Math.floor((today - season) / (7 * day))));
            const set = (el, text) => { if (el && el.textContent !== String(text)) { el.textContent = text; el.classList.remove('ss-reprint'); void el.offsetWidth; el.classList.add('ss-reprint'); } };
            const all = (sel) => root.querySelectorAll(sel);
            const dots = (box, e, cls) => {
                const total = weeksOf(e), gone = goneOf(e);
                box.replaceChildren(...Array.from({ length: total }, (_, i) => {
                    const d = document.createElement('i');
                    d.className = (i < gone ? 'gone ' : '') + (cls && i === total - 1 ? 'last' : '');
                    return d;
                }));
            };

            let cur = exams[0];
            let size = '2x2';
            const widget = root.querySelector('[data-widget]');
            const render = () => {
                const days = daysTo(cur), total = weeksOf(cur), gone = goneOf(cur);
                set(root.querySelector('[data-days]'), days);
                set(root.querySelector('[data-weeks]'), total - gone);
                dots(root.querySelector('[data-dots]'), cur, true);
                all('[data-exam]').forEach((b) => b.setAttribute('aria-pressed', b.dataset.exam === cur.slug));

                widget.dataset.size = size;
                all('[data-size]').forEach((b) => b.setAttribute('aria-pressed', b.dataset.size === size));
                all('[data-w-days]').forEach((el) => set(el, days));
                all('[data-w-name]').forEach((el) => set(el, cur.name));
                set(root.querySelector('[data-w-date]'), fmt(cur.date));
                const other = exams[(exams.indexOf(cur) + 1) % exams.length];
                set(root.querySelector('[data-w-name2]'), other.name);
                set(root.querySelector('[data-w-days2]'), daysTo(other));
                set(root.querySelector('[data-w-date2]'), fmt(other.date));
                dots(root.querySelector('[data-w-dots]'), cur, false);
                // The 2×1 widget's bar: 20 segments, the share of the season still ahead is yellow.
                const bar = root.querySelector('[data-w-bar]');
                const on = Math.round((20 * (total - gone)) / total);
                bar.replaceChildren(...Array.from({ length: 20 }, (_, i) => { const b = document.createElement('b'); if (i >= 20 - on) b.className = 'on'; return b; }));
            };
            all('[data-exam]').forEach((b) => b.addEventListener('click', () => { cur = exams.find((e) => e.slug === b.dataset.exam); render(); }));
            all('[data-size]').forEach((b) => b.addEventListener('click', () => { size = b.dataset.size; render(); }));
            render();

            // Questions: hover, click and focus select; the answer shows in the pane on desktop, beneath the question on a phone.
            const pane = root.querySelector('[data-pane]');
            const qs = [...root.querySelectorAll('.ss-q')];
            const pick = (q) => {
                qs.forEach((x) => { x.classList.toggle('is-open', x === q); x.querySelector('button').setAttribute('aria-expanded', x === q); });
                set(pane, q.querySelector('[data-a]').textContent);
            };
            qs.forEach((q) => {
                const b = q.querySelector('button');
                b.addEventListener('click', () => pick(q));
                b.addEventListener('focus', () => pick(q));
                b.addEventListener('mouseenter', () => matchMedia('(min-width: 1024px)').matches && pick(q));
            });
            pick(qs[0]);
        })();
    </script>
</div>
@endsection
