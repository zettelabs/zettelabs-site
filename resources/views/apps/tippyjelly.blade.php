@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    // The four screens are cut from the store screenshots; they live next to shot-1, in the same locale folder.
    $screen = fn (string $n) => asset(str_replace('shot-tippyjelly-1', "screen-tippyjelly-{$n}", $app['screenshots'][0]));

    $sheets = [
        ['drop', '#ffe27a', 'Kaydır, bırak, bitti.', 'Sola ya da sağa kaydır, parmağını kaldır. Kontrol bu kadar. Otobüste, yatakta ya da sırada tek elle oynarsın.', 'Tahtanın üstünde bekleyen, üzerinde 8 yazan ayı jölesi ve aşağı inen nişan çizgisi'],
        ['merge', '#ffb26b', 'Aynı sayılar birleşir.', 'Aynı sayıdaki iki jöle birbirine değince bir sonraki sayıya dönüşür: daha büyük ve daha neşeli. Zincirleme birleştirmeler daha yüksek puan getirir.', '68 puan: tahtada yan yana duran iki 16\'lık tavşan jölesi'],
        ['tip', '#ff8fa3', 'Tek ayak, gerçek ağırlık.', 'Her jölenin gerçek bir ağırlığı var ve büyüdükçe ağırlaşıyor. Bir tarafa fazla yüklenirsen tahta yan yatar. Her jölenin nereye düşeceğini planla, birleştirmeyle sol ve sağı dengele.', 'İki tavşan jölesinin ağırlığıyla sağa yatan tahta'],
        ['over', '#67e3d5', 'Üç düşüş, oyun biter.', 'Üç jöle tahtadan düşerse tur sona erer. Turlar kısa, bir tur daha demek kolay. Puanın birleştirdikçe artar, en iyi puanın telefonunda saklanır.', 'Devrildi! kartı: 108 puan ve Yeni rekor!'],
    ];

    // The game's six animals, in the order the numbers climb (tier % 6 in the game's code).
    $jellies = [
        ['Civciv', 2, 'İki civciv değince 4 olur: bir kedi.'],
        ['Kedi', 4, 'İki kedi değince 8 olur: bir ayı.'],
        ['Ayı', 8, 'İki ayı değince 16 olur: bir tavşan.'],
        ['Tavşan', 16, 'İki tavşan değince 32 olur: bir kurbağa.'],
        ['Kurbağa', 32, 'İki kurbağa değince 64 olur: bir geyik.'],
        ['Geyik', 64, 'İki geyik değince 128 olur ve sayılar büyümeye devam eder.'],
    ];

    $ways = [
        'İzlemesi keyifli, yaylanan ve sallanan fizik',
        'Dikey ekran, tek elle oynama',
        'Çevrimdışı çalışır, internet gerekmez',
        'Hesap yok, kayıt yok',
        'Her molaya sığan hızlı turlar',
    ];

    $faq = [
        ['Fiyat', 'Tippy Jelly ücretli mi?', 'Hayır, ücretsizdir ve reklamlarla desteklenir: küçük bir banner ve turlar arasında ara sıra çıkan bir reklam.'],
        ['Kontrol', 'Nasıl oynanır?', 'Sola ya da sağa kaydır, parmağını kaldır. Jöle oraya düşer. Aynı sayıdaki iki jöle değince birleşir.'],
        ['Tur sonu', 'Oyun ne zaman biter?', 'Üç jöle tahtadan düşerse tur sona erer. Turlar kısa, bir dakikalığına girip çıkabilirsin.'],
        ['İnternet', 'İnternet ya da hesap gerekiyor mu?', 'Hayır. Çevrimdışı çalışır, internet gerekmez. Hesap yok, kayıt yok.'],
        ['Rekor', 'Puanım nerede saklanıyor?', 'En iyi puanın telefonunda saklanır.'],
    ];
    $faqColours = ['#f2b84b', '#ff8fa3', '#67e3d5', '#ffe27a', '#ffb26b'];

    $jsText = json_encode([
        'points' => __('puan'),
        'next' => __('sonraki'),
        'hearts' => __('Kalan can: :n'),
        'over' => __('Devrildi!'),
    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
@endphp

@section('content')
<div class="tj" data-tj>
    <style>
        /* Tippy Jelly page: the game's own colours, and its own shape: the honey plank on one pin. */
        .tj {
            --tj-bg: #231a3d;
            --tj-card: #33275a;
            --tj-ink: #fff4e6;
            --tj-muted: #bdb1da;
            --tj-pink: #ff6f91;
            --tj-honey: #f2b84b;
            --tj-pin: #4a3b7a;
            --tj-face: #231a3d;
            --tj-r: 8px;
            color: var(--tj-ink);
            background: var(--tj-bg);
            overflow-x: clip;
        }
        .tj-pad { padding-inline: 24px; }
        .tj-wrap { max-width: 72rem; margin-inline: auto; }
        .tj-h2 { font-size: clamp(2.25rem, 4.2vw, 4rem); line-height: 1; letter-spacing: -0.035em; font-weight: 800; }
        .tj-h3 { font-size: clamp(1.5rem, 2.6vw, 2.5rem); line-height: 1.05; letter-spacing: -0.03em; font-weight: 800; }
        .tj-lead { font-size: 1.1875rem; line-height: 1.5; }
        .tj-body { font-size: 1.0625rem; line-height: 1.55; }

        /* One button shape on the whole page: the plank, a flat bar with the plank's corner. */
        .tj-btn {
            display: inline-flex; align-items: center; justify-content: center; min-height: 52px; padding: 0 28px; border-radius: var(--tj-r);
            font-weight: 800; background: var(--tj-honey); color: var(--tj-face);
            transition: transform .15s ease-out, background-color .15s ease-out;
        }
        .tj-btn:hover { background: var(--tj-ink); }
        .tj-btn:active { transform: scale(.97) rotate(-1.5deg); }
        .tj-link { font-weight: 700; text-decoration: underline; text-decoration-thickness: 2px; text-underline-offset: 5px; transition: color .15s; }
        .tj-link:hover { color: var(--tj-honey); }
        .tj :focus-visible { outline: 3px solid var(--tj-pink); outline-offset: 3px; }

        /* Hero: the violet ground of the game, and the board you can play on. */
        .tj-hero { min-height: calc(100svh - 76px); padding-block: 40px 56px; display: flex; align-items: center; }
        .tj-hero-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 40px; align-items: center; width: 100%; }
        @media (min-width: 1024px) { .tj-hero-grid { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); gap: 48px; } }
        .tj-id { display: flex; align-items: center; gap: 12px; font-weight: 800; font-size: 1.1875rem; }
        .tj-id img { width: 48px; height: 48px; border-radius: 12px; }
        .tj-display { font-size: clamp(3.25rem, 5.6vw, 5.25rem); line-height: .95; letter-spacing: -0.04em; font-weight: 800; margin-top: 40px; }
        .tj-line { display: block; overflow: hidden; padding-bottom: .08em; margin-bottom: -.08em; }
        .tj-line > span { display: block; animation: tj-up .9s cubic-bezier(.16, 1, .3, 1) both; }
        .tj-line + .tj-line > span { animation-delay: .08s; color: var(--tj-honey); }
        @keyframes tj-up { from { transform: translateY(105%); } }
        .tj-hero .tj-lead { margin-top: 32px; max-width: 34ch; }
        .tj-cta { display: flex; flex-wrap: wrap; align-items: center; gap: 16px 28px; margin-top: 32px; }

        .tj-stage { position: relative; width: min(100%, calc((100svh - 230px) * .851)); min-width: min(100%, 320px); margin-inline: auto; }
        .tj-board { position: relative; aspect-ratio: 400 / 470; }
        .tj-board canvas { position: absolute; inset: 0; width: 100%; height: 100%; display: none; touch-action: pan-y; cursor: crosshair; }
        .tj-board img { width: 100%; height: 100%; object-fit: cover; border-radius: var(--tj-r); }
        .tj-js .tj-board canvas { display: block; }
        .tj-js .tj-board img, .tj-controls { display: none; }
        .tj-js .tj-controls { display: flex; }
        .tj-controls { align-items: center; gap: 16px; margin-top: 8px; }
        .tj-controls input { flex: 1; min-width: 0; accent-color: var(--tj-honey); height: 44px; cursor: pointer; }
        .tj-note { margin-top: 12px; color: var(--tj-muted); font-size: 1rem; text-align: center; }
        .tj-over {
            position: absolute; left: 50%; top: 38%; translate: -50% -50%; display: none; text-align: center;
            background: var(--tj-card); border-radius: var(--tj-r); padding: 28px 36px; min-width: 240px;
        }
        .tj-over.is-on { display: block; animation: tj-pop .35s cubic-bezier(.34, 1.56, .64, 1) both; }
        .tj-over p:first-child { font-size: 1.75rem; font-weight: 800; letter-spacing: -0.02em; }
        .tj-over p + p { font-size: 1.0625rem; color: var(--tj-muted); margin: 4px 0 20px; }
        @keyframes tj-pop { from { opacity: 0; transform: scale(.85); } }

        /* Features: four sheets in the jellies' own colours, sliding over each other like folders in a drawer. */
        .tj-rules { padding-top: clamp(96px, 12vw, 160px); }
        .tj-rules > .tj-wrap { margin-bottom: 48px; }
        .tj-sheet { position: relative; color: var(--tj-face); border-radius: 28px 28px 0 0; }
        .tj-sheet-in { display: grid; grid-template-columns: minmax(0, 1fr); padding-bottom: 32px; }
        .tj-sheet h3 { display: flex; align-items: center; min-height: 52px; font-size: 1.375rem; font-weight: 800; letter-spacing: -0.02em; order: 0; }
        .tj-sheet figure { order: 1; margin-top: 4px; position: relative; overflow: hidden; border-radius: var(--tj-r); aspect-ratio: 4 / 3; }
        .tj-sheet figure img { width: 100%; height: 100%; object-fit: cover; object-position: 50% 30%; }
        .tj-sheet p { order: 2; margin-top: 24px; max-width: 40ch; }
        @media (min-width: 1024px) {
            .tj-sheet { height: max(480px, calc(100svh - 24px - var(--n) * 72px)); }
            .tj-sheet-in { grid-template-columns: repeat(12, minmax(0, 1fr)); column-gap: 24px; grid-template-rows: 72px 1fr; height: 100%; padding-bottom: 0; }
            .tj-sheet h3 { grid-column: 1 / 7; grid-row: 1; min-height: 72px; font-size: clamp(1.75rem, 3vw, 2.75rem); }
            .tj-sheet p { grid-column: 1 / 6; grid-row: 2; align-self: end; margin: 0 0 56px; font-size: 1.1875rem; }
            .tj-sheet figure { grid-column: 7 / 13; grid-row: 1 / 3; margin: 72px 0 0; aspect-ratio: auto; border-radius: var(--tj-r) var(--tj-r) 0 0; }
        }
        /* Sheets stack only where each one, pinned, still fits the screen whole. */
        @media (min-width: 1024px) and (min-height: 760px) { .tj-sheet { position: sticky; top: calc(var(--n) * 72px); } }
        /* The signature move: the first screen opens upward like a shutter as its sheet arrives. */
        .tj-shutter img { transition: transform 1.1s cubic-bezier(.16, 1, .3, 1); }
        .reveal-on .tj-shutter { clip-path: inset(100% 0 0 0); transition: clip-path 1.1s cubic-bezier(.77, 0, .18, 1); }
        .reveal-on .tj-shutter img { transform: scale(1.12); }
        .reveal-on .tj-shutter.is-in { clip-path: inset(0); }
        .reveal-on .tj-shutter.is-in img { transform: none; }

        /* Showcase: the six animals, one at a time, on the plank. */
        .tj-cast { background: var(--tj-ink); color: var(--tj-face); padding-block: clamp(96px, 12vw, 160px); }
        .tj-cast-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 32px; }
        @media (min-width: 1024px) { .tj-cast-grid { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); gap: 48px; align-items: end; } }
        .tj-cast h2 { color: #6b5ba3; }
        .tj-cast-list { display: flex; flex-direction: column; margin-top: 8px; }
        .tj-name {
            display: flex; align-items: baseline; gap: 14px; text-align: left; font-size: clamp(1.75rem, 2.9vw, 2.75rem); font-weight: 800;
            letter-spacing: -0.03em; line-height: 1.15; color: #6b5ba3; transition: color .15s, transform .2s cubic-bezier(.2, .7, .2, 1);
        }
        .tj-name small { font-size: 1.0625rem; letter-spacing: 0; font-weight: 700; }
        .tj-name:hover { color: var(--tj-face); }
        .tj-name[aria-pressed="true"] { color: var(--tj-face); transform: translateX(10px); }
        .tj-name[aria-pressed="true"]::before { content: ''; align-self: center; width: 28px; height: 8px; border-radius: 3px; background: var(--tj-honey); }
        .tj-show { position: relative; }
        .tj-show canvas { width: 100%; aspect-ratio: 10 / 7; display: block; }
        .tj-fact { font-size: 1.0625rem; line-height: 1.5; font-weight: 600; max-width: 34ch; margin-top: 8px; }
        .tj-fact.tj-reprint { animation: tj-in .3s ease-out; }
        @keyframes tj-in { from { opacity: 0; transform: translateY(6px); } }
        @media (max-width: 1023px) {
            .tj-cast-list { flex-direction: row; gap: 24px; overflow-x: auto; padding-bottom: 8px; scrollbar-width: none; }
            .tj-name { font-size: 1.625rem; flex: none; }
            .tj-name[aria-pressed="true"] { transform: none; }
        }

        /* The one full-width band: a field of plank honey, the list's bullets cut as little planks. */
        .tj-ways { background: var(--tj-honey); color: var(--tj-face); padding-block: clamp(96px, 12vw, 160px); }
        .tj-ways-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 40px; }
        @media (min-width: 1024px) { .tj-ways-grid { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); gap: 48px; } }
        .tj-ways li { display: flex; align-items: center; gap: 20px; font-size: clamp(1.25rem, 2vw, 1.75rem); font-weight: 700; letter-spacing: -0.02em; padding-block: 14px; }
        .tj-ways li::before { content: ''; flex: none; width: 40px; height: 10px; border-radius: 3px; background: var(--tj-face); rotate: -6deg; }
        .tj-ways li:nth-child(even)::before { rotate: 6deg; }
        .tj-ways .tj-body { margin-top: 24px; max-width: 40ch; }

        /* Questions: index cards filed in a drawer, each with its tab. */
        .tj-faq { padding-block: clamp(96px, 12vw, 160px); }
        .tj-faq-in { max-width: 52rem; margin-inline: auto; }
        .tj-cards { margin-top: 64px; }
        .tj-card { position: relative; color: var(--tj-face); border-radius: 0 var(--tj-r) var(--tj-r) var(--tj-r); margin-top: 40px; }
        .tj-card + .tj-card { margin-top: 24px; }
        .tj-card:not(:first-child) { border-top-left-radius: var(--tj-r); }
        .tj-tab {
            position: absolute; bottom: 100%; left: calc(var(--n) * 48px); width: 120px; height: 40px; display: flex; align-items: center; padding-left: 16px;
            border-radius: var(--tj-r) var(--tj-r) 0 0; background: inherit; font-size: 1rem; font-weight: 800;
        }
        .tj-card:first-child .tj-tab { left: 0; }
        .tj-q { display: block; width: 100%; text-align: left; font-size: 1.25rem; font-weight: 700; letter-spacing: -0.01em; padding: 20px 20px 36px; }
        .tj-a { padding: 0 20px 40px; max-width: 50ch; font-size: 1rem; line-height: 1.55; }
        .tj-a[hidden] { display: none; }
        .tj-card.is-open .tj-a { animation: tj-in .25s ease-out; }
        @media (min-width: 768px) {
            .tj-tab { width: 200px; left: calc(var(--n) * 150px); }
            .tj-q { padding: 22px 28px 40px; }
            .tj-a { padding: 0 28px 44px; font-size: 1.0625rem; }
        }

        /* The close: one word, the whole band is the link. */
        .tj-go {
            display: block; position: relative; background: var(--tj-pink); color: var(--tj-face); border-radius: 28px 28px 0 0;
            min-height: 46svh; padding: 24px 24px 24px; overflow: hidden;
        }
        @media (min-width: 1024px) { .tj-go { min-height: 60svh; padding: 32px 48px; } }
        a.tj-go:hover, a.tj-go:focus-visible { background: var(--tj-face); color: var(--tj-pink); outline-offset: -6px; }
        .tj-go-top { display: flex; justify-content: space-between; gap: 24px; align-items: start; }
        .tj-go-top p { font-size: 1.0625rem; font-weight: 700; max-width: 26ch; }
        @media (min-width: 1024px) { .tj-go-top p { font-size: 1.25rem; } }
        .tj-go-top svg { flex: none; width: 32px; height: 32px; }
        @media (min-width: 1024px) { .tj-go-top svg { width: 48px; height: 48px; } }
        .tj-word { position: absolute; left: 16px; right: 16px; bottom: 8px; font-size: clamp(6rem, 27vw, 26rem); line-height: .8; letter-spacing: -0.06em; font-weight: 900; white-space: nowrap; }
        @media (min-width: 1024px) { .tj-word { left: 40px; bottom: 16px; } }
        .tj-go:hover .tj-word { transform: translateX(8px); }
        .tj-word { transition: transform .3s cubic-bezier(.2, .7, .2, 1); }

        @media (prefers-reduced-motion: reduce) {
            .tj-line > span, .tj-over.is-on, .tj-fact.tj-reprint, .tj-card.is-open .tj-a { animation: none; }
            .reveal-on .tj-shutter, .reveal-on .tj-shutter img { clip-path: none; transform: none; transition: none; }
            .tj-name, .tj-word, .tj-btn { transition: none; }
        }
    </style>

    <section class="tj-hero tj-pad" aria-labelledby="tj-h1">
        <div class="tj-hero-grid tj-wrap">
            <div>
                <div class="tj-id rise">
                    <img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" width="48" height="48">
                    <span>{{ $app['name'] }}</span>
                </div>
                <h1 id="tj-h1" class="tj-display">
                    <span class="tj-line"><span>{{ __('Tek ayak,') }}</span></span>
                    <span class="tj-line"><span>{{ __('tek tahta.') }}</span></span>
                </h1>
                <p class="tj-lead rise" style="--i: 3">{{ __($app['tagline']) }} {{ __('Tek parmakla, internetsiz bile oynanan rahat bir fizik bulmacası.') }}</p>
                <div class="tj-cta rise" style="--i: 4">
                    @if ($app['play_store'])
                        <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="tj-btn">{{ __("Google Play'de aç") }}</a>
                    @else
                        <span class="tj-btn">{{ __("Yakında Google Play'de") }}</span>
                    @endif
                    @if ($app['privacy_url'])
                        <a href="{{ $app['privacy_url'] }}" class="tj-link">{{ __('Gizlilik Politikası') }}</a>
                    @endif
                </div>
            </div>

            <div class="tj-stage rise" style="--i: 2" data-game>
                <div class="tj-board">
                    <img src="{{ $screen('drop') }}" alt="{{ __($sheets[0][4]) }}" width="720" height="867">
                    <canvas data-canvas role="img" aria-label="{{ __('Oynanabilir tahta: jöleyi kaydırıp bırak') }}"></canvas>
                    <div class="tj-over" data-over aria-live="polite">
                        <p>{{ __('Devrildi!') }}</p>
                        <p data-over-score></p>
                        <button type="button" class="tj-btn" data-again>{{ __('Bir daha') }}</button>
                    </div>
                </div>
                <div class="tj-controls">
                    <input type="range" min="-100" max="100" value="0" data-aim aria-label="{{ __('Jölenin düşeceği yer') }}">
                    <button type="button" class="tj-btn" data-drop>{{ __('Bırak') }}</button>
                </div>
                <p class="tj-note">{{ __('Burada dene: tahtaya dokun ya da kaydır.') }}</p>
                <p class="sr-only" aria-live="polite" data-status></p>
            </div>
        </div>
    </section>

    <section class="tj-rules" aria-labelledby="tj-rules-h">
        <div class="tj-wrap tj-pad">
            <h2 id="tj-rules-h" class="tj-h2" data-reveal>{{ __('Dört kural, bir tahta.') }}</h2>
        </div>
        @foreach ($sheets as [$key, $colour, $title, $text, $alt])
            <article class="tj-sheet tj-pad" style="--n: {{ $loop->index }}; background: {{ $colour }}">
                <div class="tj-sheet-in tj-wrap">
                    <h3>{{ __($title) }}</h3>
                    <figure class="{{ $loop->first ? 'tj-shutter' : '' }}" @if ($loop->first) data-reveal @endif>
                        <img src="{{ $screen($key) }}" alt="{{ __($alt) }}" width="720" height="867" loading="lazy">
                    </figure>
                    <p class="tj-body" data-reveal>{{ __($text) }}</p>
                </div>
            </article>
        @endforeach
    </section>

    <section class="tj-cast tj-pad" aria-labelledby="tj-cast-h">
        <div class="tj-cast-grid tj-wrap">
            <div>
                <h2 id="tj-cast-h" class="tj-h3" data-reveal>{{ __('Civcivden geyiğe') }}</h2>
                <div class="tj-cast-list" data-reveal role="group" aria-label="{{ __('Jöleler') }}">
                    @foreach ($jellies as [$name, $value, $fact])
                        <button type="button" class="tj-name" data-jelly="{{ $value }}" data-fact="{{ __($fact) }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ __($name) }} <small>{{ $value }}</small></button>
                    @endforeach
                </div>
            </div>
            <div class="tj-show" data-reveal>
                <canvas data-show role="img" aria-label="{{ __('Seçilen jöle tahtanın üstünde') }}"></canvas>
                <p class="tj-fact" data-fact-out aria-live="polite">{{ __($jellies[0][2]) }}</p>
            </div>
        </div>
    </section>

    <section class="tj-ways tj-pad" aria-labelledby="tj-ways-h">
        <div class="tj-ways-grid tj-wrap">
            <div>
                <h2 id="tj-ways-h" class="tj-h2" data-reveal>{{ __('Senin tarzın') }}</h2>
                <p class="tj-body" data-reveal>{{ __($app['description']) }}</p>
            </div>
            <ul>
                @foreach ($ways as $way)
                    <li data-reveal>{{ __($way) }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    <section class="tj-faq tj-pad" aria-labelledby="faq-h">
        <div class="tj-faq-in">
            <h2 id="faq-h" class="tj-h2" data-reveal>{{ __('Sık sorulanlar') }}</h2>
            <div class="tj-cards" data-cards>
                @foreach ($faq as [$tab, $question, $answer])
                    <div class="tj-card {{ $loop->first ? 'is-open' : '' }}" style="--n: {{ $loop->index }}; background: {{ $faqColours[$loop->index] }}" data-reveal>
                        <span class="tj-tab" aria-hidden="true">{{ __($tab) }}</span>
                        <h3><button type="button" class="tj-q" id="tj-q{{ $loop->index }}" aria-controls="tj-a{{ $loop->index }}" aria-expanded="true">{{ __($question) }}</button></h3>
                        <p class="tj-a" id="tj-a{{ $loop->index }}" role="region" aria-labelledby="tj-q{{ $loop->index }}">{{ __($answer) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="tj-pad" aria-labelledby="tj-go-h">
        <div class="tj-wrap">
            @if ($app['play_store'])
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="tj-go" data-reveal>
            @else
                <div class="tj-go" data-reveal>
            @endif
                <div class="tj-go-top">
                    <p id="tj-go-h">{{ $app['play_store'] ? __("Google Play'de aç ve ilk turu oyna.") : __("Yakında Google Play'de") }}</p>
                    <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 36 36 12M16 12h20v20"/></svg>
                </div>
                <span class="tj-word" aria-hidden="true">{{ __('Oyna') }}</span>
            @if ($app['play_store'])
                </a>
            @else
                </div>
            @endif
        </div>
    </section>

    <script>
        (() => {
            const root = document.querySelector('[data-tj]');
            root.classList.add('tj-js');
            const T = {!! $jsText !!};
            const calm = matchMedia('(prefers-reduced-motion: reduce)').matches;
            const FONT = getComputedStyle(root).fontFamily;

            // The game's own jelly: colours by tier, size and weight from the number, animal by tier % 6.
            const COLORS = ['#ffe27a', '#ffb26b', '#ff8fa3', '#e58cff', '#8fa8ff', '#67e3d5', '#9df07f', '#ffc4e1', '#fff08a', '#a8ecff', '#ff8a7a'];
            const FACE = '#3a1e55', HONEY = '#f2b84b', PIN = '#4a3b7a', INK = '#fff4e6', MUTED = '#bdb1da', PINK = '#ff6f91';
            const tierOf = (v) => Math.log2(v) - 1;
            const sideOf = (v) => Math.min(120, 32 + 9 * tierOf(v));
            const massOf = (v) => sideOf(v) ** 2 * (1 + tierOf(v) * 0.35);

            const rr = (c, x, y, w, h, r) => { c.beginPath(); c.moveTo(x + r, y); c.arcTo(x + w, y, x + w, y + h, r); c.arcTo(x + w, y + h, x, y + h, r); c.arcTo(x, y + h, x, y, r); c.arcTo(x, y, x + w, y, r); c.closePath(); };
            const blob = (c, r, t) => {
                c.beginPath();
                for (let i = 0; i <= 36; i++) {
                    const a = (i / 36) * 6.2832, low = Math.max(0, Math.sin(a)), rad = r * (1 + 0.022 * Math.sin(3 * a + t));
                    const px = Math.cos(a) * rad * (1 + 0.08 * low), py = Math.sin(a) * rad * (1 - 0.06 * low);
                    i ? c.lineTo(px, py) : c.moveTo(px, py);
                }
                c.closePath();
            };
            const features = (c, tier, r, color) => {
                c.fillStyle = color; c.strokeStyle = color; c.lineCap = 'round';
                switch (tier % 6) {
                    case 0: c.lineWidth = r * 0.14; c.beginPath(); c.moveTo(0, -r * 0.9); c.quadraticCurveTo(r * 0.05, -r * 1.3, r * 0.3, -r * 1.3); c.stroke(); break;
                    case 1: for (const d of [-1, 1]) { c.beginPath(); c.moveTo(d * r * 0.85, -r * 0.45); c.lineTo(d * r * 0.72, -r * 1.2); c.lineTo(d * r * 0.2, -r * 0.88); c.closePath(); c.fill(); } break;
                    case 2: for (const d of [-1, 1]) { c.beginPath(); c.arc(d * r * 0.68, -r * 0.78, r * 0.3, 0, 6.28); c.fill(); } break;
                    case 3: for (const d of [-1, 1]) { c.save(); c.translate(d * r * 0.38, -r * 1.2); c.rotate(d * 0.14); c.beginPath(); c.ellipse(0, 0, r * 0.19, r * 0.55, 0, 0, 6.28); c.fill(); c.restore(); } break;
                    case 4: for (const d of [-1, 1]) { c.beginPath(); c.arc(d * r * 0.46, -r * 0.86, r * 0.28, 0, 6.28); c.fill(); } break;
                    default: c.lineWidth = r * 0.1; for (const d of [-1, 1]) { c.beginPath(); c.moveTo(d * r * 0.35, -r * 0.85); c.lineTo(d * r * 0.55, -r * 1.35); c.moveTo(d * r * 0.47, -r * 1.12); c.lineTo(d * r * 0.8, -r * 1.25); c.stroke(); }
                }
            };
            const jelly = (c, x, y, s, v, o = {}) => {
                const tier = Math.max(0, Math.round(tierOf(v))), color = COLORS[tier % COLORS.length], r = s / 2;
                const sq = calm ? 0 : o.sq || 0, grow = 1 + (calm ? 0 : o.pop || 0) * 0.5, t = calm ? 0 : o.t || 0;
                c.save(); c.translate(x, y); c.rotate(o.rot || 0); c.scale((1 + sq) * grow, (1 - sq) * grow);
                features(c, tier, r, color);
                blob(c, r, t); c.fillStyle = color; c.fill();
                c.save(); c.clip();
                let g = c.createRadialGradient(-r * 0.3, -r * 0.45, r * 0.05, -r * 0.3, -r * 0.45, r * 1.1);
                g.addColorStop(0, 'rgba(255,255,255,.6)'); g.addColorStop(1, 'rgba(255,255,255,0)'); c.fillStyle = g; c.fillRect(-r * 1.3, -r * 1.3, r * 2.6, r * 2.6);
                g = c.createRadialGradient(0, 0, r * 0.6, 0, 0, r * 1.1);
                g.addColorStop(0, 'rgba(90,20,110,0)'); g.addColorStop(1, 'rgba(90,20,110,.32)'); c.fillStyle = g; c.fillRect(-r * 1.3, -r * 1.3, r * 2.6, r * 2.6);
                c.restore();
                const eye = Math.max(1.8, r * 0.12), ex = r * 0.36, ey = -r * 0.22;
                c.fillStyle = 'rgba(255,90,130,.35)'; for (const d of [-1, 1]) { c.beginPath(); c.ellipse(d * r * 0.58, ey + r * 0.2, r * 0.15, r * 0.09, 0, 0, 6.28); c.fill(); }
                for (const d of [-1, 1]) {
                    c.fillStyle = FACE; c.beginPath(); c.arc(d * ex, ey, eye, 0, 6.28); c.fill();
                    c.fillStyle = '#fff'; c.beginPath(); c.arc(d * ex - eye * 0.3, ey - eye * 0.35, eye * 0.35, 0, 6.28); c.fill();
                }
                c.fillStyle = FACE; c.font = `700 ${Math.max(12, s * 0.36)}px ${FONT}`; c.textAlign = 'center'; c.textBaseline = 'middle'; c.fillText(v, 0, r * 0.42);
                c.restore();
            };
            const pinAndPlank = (c, px, py, len, tilt) => {
                c.fillStyle = 'rgba(0,0,0,.2)'; c.beginPath(); c.ellipse(px, py + 82, len * 0.32, 9, 0, 0, 6.28); c.fill();
                c.fillStyle = PIN; c.beginPath(); c.moveTo(px, py); c.lineTo(px + 38, py + 80); c.lineTo(px - 38, py + 80); c.closePath(); c.fill();
                c.save(); c.translate(px, py); c.rotate(tilt); c.fillStyle = HONEY; rr(c, -len / 2, -8, len, 16, 6); c.fill();
            };
            const fit = (canvas, w, h) => {
                const d = Math.min(devicePixelRatio || 1, 2), cw = canvas.clientWidth;
                canvas.width = Math.round(cw * d); canvas.height = Math.round(((cw * h) / w) * d);
                return (cw / w) * d;
            };

            // Board model: jellies sit in one row along the plank (x from the pin), the plank tips with their weight.
            // shortcut: a 1D row, no stacking, unlike the app's full 2D physics; enough to show merge and tip.
            const settle = (row) => {
                const merged = [];
                for (let guard = 0, again = true; again && guard < 24; guard++) {
                    again = false; row.sort((a, b) => a.x - b.x);
                    for (let i = 0; i < row.length - 1; i++) {
                        const a = row[i], b = row[i + 1], need = (sideOf(a.v) + sideOf(b.v)) / 2, gap = b.x - a.x;
                        const ma = massOf(a.v), mb = massOf(b.v);
                        if (a.v === b.v && gap < need + 0.5) {
                            const n = { v: a.v * 2, x: (a.x * ma + b.x * mb) / (ma + mb), vx: (a.vx * ma + b.vx * mb) / (ma + mb), sq: 0, pop: 0.4 };
                            row.splice(i, 2, n); merged.push(n); again = true; break;
                        }
                        if (gap < need) {
                            const o = need - gap, v = (a.vx * ma + b.vx * mb) / (ma + mb);
                            a.x -= (o * mb) / (ma + mb); b.x += (o * ma) / (ma + mb); a.vx = b.vx = v; again = true;
                        }
                    }
                }
                return merged;
            };
            {
                const t = [{ v: 2, x: 0, vx: 0 }, { v: 2, x: 20, vx: 0 }];
                console.assert(settle(t).length === 1 && t.length === 1 && t[0].v === 4, 'tippy: equal jellies merge');
                const u = [{ v: 2, x: 0, vx: 0 }, { v: 4, x: 10, vx: 0 }];
                settle(u); console.assert(u.length === 2 && u[1].x - u[0].x >= (sideOf(2) + sideOf(4)) / 2 - 0.01, 'tippy: different jellies push apart');
                const w = [{ v: 2, x: 0, vx: 0 }, { v: 2, x: 30, vx: 0 }, { v: 4, x: 50, vx: 0 }];
                console.assert(settle(w).length === 2 && w.length === 1 && w[0].v === 8, 'tippy: merges chain');
            }

            const W = 400, H = 470, PX = 200, PY = 352, L = 150, DROP_Y = 104;
            const game = root.querySelector('[data-game]');
            const canvas = game.querySelector('[data-canvas]'), ctx = canvas.getContext('2d');
            const aimIn = game.querySelector('[data-aim]'), over = game.querySelector('[data-over]'), status = game.querySelector('[data-status]');
            const rnd = () => { const r = Math.random(); return r < 0.55 ? 2 : r < 0.85 ? 4 : 8; };
            let G, scale = 1, clock = 0, seen = false, raf = 0;
            const reset = () => {
                G = { row: [], air: [], fall: [], floats: [], th: 0, om: 0, score: 0, hearts: 3, cur: 2, next: rnd(), aim: 0, cool: 0, over: false };
                over.classList.remove('is-on'); status.textContent = T.hearts.replace(':n', 3);
            };
            const limit = () => L - sideOf(G.cur) / 2;
            const setAim = (x) => { G.aim = Math.max(-limit(), Math.min(limit(), x)); aimIn.value = Math.round((G.aim / limit()) * 100); };
            const drop = () => {
                if (G.over || G.cool > 0) return;
                G.air.push({ v: G.cur, x: PX + G.aim, y: DROP_Y, vy: 0 });
                G.cur = G.next; G.next = rnd(); G.cool = 26; setAim(G.aim);
            };
            const lose = () => {
                G.hearts--; status.textContent = T.hearts.replace(':n', Math.max(0, G.hearts));
                if (G.hearts <= 0 && !G.over) {
                    G.over = true; over.querySelector('[data-over-score]').textContent = `${G.score} ${T.points}`; over.classList.add('is-on');
                }
            };

            const step = () => {
                clock++; if (G.cool > 0) G.cool--;
                const sin = Math.sin(G.th), cos = Math.cos(G.th);
                for (const a of [...G.air]) {
                    a.vy += 0.5; a.y += a.vy;
                    const s = sideOf(a.v), px = (a.x - PX) / cos, surf = PY + px * sin - (8 + s * 0.47) / cos;
                    if (Math.abs(px) <= L && a.y >= surf && a.y - a.vy <= surf + 4) {
                        G.air.splice(G.air.indexOf(a), 1); G.row.push({ v: a.v, x: px, vx: 0, sq: 0.25, pop: 0 });
                    } else if (a.y > H + 80) { G.air.splice(G.air.indexOf(a), 1); lose(); }
                }
                for (const j of G.row) {
                    j.vx += 0.25 * sin; j.vx *= 0.97;
                    if (Math.abs(sin) < 0.07 && Math.abs(j.vx) < 0.3) j.vx *= 0.6;
                    j.x += j.vx; j.sq *= 0.85; j.pop *= 0.85;
                }
                for (const m of settle(G.row)) { G.score += m.v; G.floats.push({ x: m.x, life: 1, text: `+${m.v}` }); }
                for (const j of [...G.row]) {
                    if (Math.abs(j.x) > L + 2) {
                        G.row.splice(G.row.indexOf(j), 1);
                        const s = sideOf(j.v);
                        G.fall.push({ v: j.v, x: PX + j.x * cos + (8 + s * 0.47) * sin, y: PY + j.x * sin - (8 + s * 0.47) * cos, vx: j.vx * cos, vy: j.vx * sin, spin: 0 });
                        lose();
                    }
                }
                for (const f of [...G.fall]) { f.vy += 0.5; f.x += f.vx; f.y += f.vy; f.spin += f.vx * 0.02; if (f.y > H + 120) G.fall.splice(G.fall.indexOf(f), 1); }
                for (const f of G.floats) f.life -= 0.02;
                G.floats = G.floats.filter((f) => f.life > 0);
                // Restoring pull of the pin, plus the jellies' weight: bigger is heavier (the game's own size and density).
                const torque = G.row.reduce((t, j) => t + massOf(j.v) * j.x, 0);
                G.om += torque * 1.4e-9 - 0.004 * G.th; G.om *= 0.95; G.th += G.om;
                if (Math.abs(G.th) > 0.4) { G.th = Math.sign(G.th) * 0.4; G.om = 0; }
            };

            const heart = (c, x, y, s, on) => {
                c.fillStyle = on ? PINK : PIN; c.beginPath(); c.moveTo(x, y + s * 0.3);
                c.bezierCurveTo(x, y, x - s * 0.5, y, x - s * 0.5, y + s * 0.3); c.bezierCurveTo(x - s * 0.5, y + s * 0.6, x, y + s * 0.75, x, y + s);
                c.bezierCurveTo(x, y + s * 0.75, x + s * 0.5, y + s * 0.6, x + s * 0.5, y + s * 0.3); c.bezierCurveTo(x + s * 0.5, y, x, y, x, y + s * 0.3); c.fill();
            };
            const draw = () => {
                const c = ctx; c.setTransform(1, 0, 0, 1, 0, 0); c.clearRect(0, 0, canvas.width, canvas.height); c.setTransform(scale, 0, 0, scale, 0, 0);
                for (let i = 0; i < 3; i++) heart(c, 24 + i * 30, 26, 22, i < G.hearts);
                c.fillStyle = INK; c.font = `800 38px ${FONT}`; c.textAlign = 'center'; c.textBaseline = 'alphabetic'; c.fillText(G.score, PX, 56);
                c.fillStyle = MUTED; c.font = `600 14px ${FONT}`; c.fillText(T.next, 356, 30); jelly(c, 356, 58, 28, G.next);
                if (!G.over && G.cool === 0) {
                    const s = sideOf(G.cur), x = PX + G.aim;
                    c.strokeStyle = '#6b5ba3'; c.lineWidth = 2; c.setLineDash([6, 8]); c.beginPath(); c.moveTo(x, DROP_Y + s / 2); c.lineTo(x, PY - 12); c.stroke(); c.setLineDash([]);
                    jelly(c, x, DROP_Y, s, G.cur, { t: clock * 0.05 });
                }
                const sway = G.row.length || calm ? 0 : Math.sin(clock / 60) * 0.05;
                pinAndPlank(c, PX, PY, L * 2, G.th + sway);
                G.row.forEach((j, i) => { const s = sideOf(j.v); jelly(c, j.x, -8 - s * 0.47, s, j.v, { sq: j.sq + (calm ? 0 : Math.sin(clock * 0.07 + i) * 0.015), pop: j.pop, t: clock * 0.05 + i, rot: -(G.th + sway) * 0.7 }); });
                for (const f of G.floats) { c.globalAlpha = f.life; c.fillStyle = INK; c.font = `800 20px ${FONT}`; c.textAlign = 'center'; c.fillText(f.text, f.x, -90 - (1 - f.life) * 40); }
                c.globalAlpha = 1; c.restore();
                for (const a of G.air) jelly(c, a.x, a.y, sideOf(a.v), a.v);
                for (const f of G.fall) jelly(c, f.x, f.y, sideOf(f.v), f.v, { rot: f.spin });
            };
            const loop = () => { step(); draw(); raf = seen ? requestAnimationFrame(loop) : 0; };
            const start = () => { if (!raf) raf = requestAnimationFrame(loop); };

            const worldX = (e) => (e.offsetX / canvas.clientWidth) * W - PX;
            let aiming = false;
            canvas.addEventListener('pointerdown', (e) => { aiming = true; setAim(worldX(e)); });
            canvas.addEventListener('pointermove', (e) => { if (aiming || e.pointerType === 'mouse') setAim(worldX(e)); });
            canvas.addEventListener('pointerup', () => { if (aiming) drop(); aiming = false; });
            canvas.addEventListener('pointercancel', () => { aiming = false; });
            aimIn.addEventListener('input', () => { G.aim = (aimIn.value / 100) * limit(); });
            game.querySelector('[data-drop]').addEventListener('click', drop);
            over.querySelector('[data-again]').addEventListener('click', () => { reset(); game.querySelector('[data-drop]').focus(); });

            // The showcase: the chosen animal standing on the plank.
            const show = root.querySelector('[data-show]'), sctx = show.getContext('2d'), factOut = root.querySelector('[data-fact-out]');
            let picked = 2, sScale = 1, sSeen = false, sRaf = 0, sClock = 0, sPop = 0;
            const drawShow = () => {
                sClock++; sPop *= 0.88;
                const c = sctx, tilt = calm ? -0.04 : Math.sin(sClock / 70) * 0.04;
                c.setTransform(1, 0, 0, 1, 0, 0); c.clearRect(0, 0, show.width, show.height); c.setTransform(sScale, 0, 0, sScale, 0, 0);
                pinAndPlank(c, 300, 300, 520, tilt);
                const s = 190;
                jelly(c, 0, -8 - s * 0.47, s, picked, { t: sClock * 0.05, pop: sPop, sq: calm ? 0 : Math.sin(sClock * 0.06) * 0.02, rot: -tilt });
                c.restore();
                sRaf = sSeen && !calm ? requestAnimationFrame(drawShow) : 0;
            };
            root.querySelectorAll('[data-jelly]').forEach((b) => b.addEventListener('click', () => {
                root.querySelectorAll('[data-jelly]').forEach((x) => x.setAttribute('aria-pressed', x === b));
                picked = Number(b.dataset.jelly); sPop = 0.35;
                factOut.textContent = b.dataset.fact; factOut.classList.remove('tj-reprint'); void factOut.offsetWidth; factOut.classList.add('tj-reprint');
                if (!sRaf) drawShow();
            }));

            const size = () => { scale = fit(canvas, W, H); sScale = fit(show, 600, 420); draw(); if (!sRaf) drawShow(); };
            addEventListener('resize', size);
            new IntersectionObserver(([e]) => { seen = e.isIntersecting; if (seen) start(); }).observe(canvas);
            new IntersectionObserver(([e]) => { sSeen = e.isIntersecting; if (sSeen && !sRaf) drawShow(); }).observe(show);
            reset(); size();

            // Questions: one card open at a time; without the script every answer stays visible.
            const cards = [...root.querySelectorAll('.tj-card')];
            const open = (card) => cards.forEach((x) => {
                const on = x === card; x.classList.toggle('is-open', on);
                x.querySelector('.tj-q').setAttribute('aria-expanded', on); x.querySelector('.tj-a').hidden = !on;
            });
            cards.forEach((card) => card.querySelector('.tj-q').addEventListener('click', () => open(card)));
            open(cards[0]);
        })();
    </script>
</div>
@endsection
