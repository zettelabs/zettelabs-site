@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    $tr = app()->getLocale() === 'tr';
    $shot = fn (int $n) => asset($app['screenshots'][$n - 1]);
    $pic = fn (string $file) => asset("images/apps/skydesk/{$file}");

    // Real airports from the app's own table (code, city, lat, lon); the pass is printed for IST → CDG until the visitor picks a route.
    $airports = [
        ['IST', 'Istanbul', 41.275, 28.752], ['ESB', 'Ankara', 40.128, 32.995], ['ADB', 'Izmir', 38.292, 27.157], ['AYT', 'Antalya', 36.898, 30.800],
        ['LHR', 'London', 51.470, -0.454], ['CDG', 'Paris', 49.010, 2.548], ['AMS', 'Amsterdam', 52.310, 4.768], ['FRA', 'Frankfurt', 50.037, 8.562],
        ['BER', 'Berlin', 52.366, 13.503], ['ZRH', 'Zurich', 47.465, 8.549], ['VIE', 'Vienna', 48.110, 16.570], ['ATH', 'Athens', 37.936, 23.947],
        ['FCO', 'Rome', 41.800, 12.239], ['MAD', 'Madrid', 40.472, -3.561], ['BCN', 'Barcelona', 41.297, 2.078], ['LIS', 'Lisbon', 38.774, -9.134],
        ['CPH', 'Copenhagen', 55.618, 12.656], ['DXB', 'Dubai', 25.253, 55.364], ['DOH', 'Doha', 25.273, 51.608], ['CAI', 'Cairo', 30.122, 31.406],
        ['SIN', 'Singapore', 1.364, 103.991], ['HND', 'Tokyo', 35.552, 139.780], ['SYD', 'Sydney', -33.946, 151.177], ['JFK', 'New York', 40.640, -73.779],
        ['SFO', 'San Francisco', 37.619, -122.375], ['GRU', 'Sao Paulo', -23.432, -46.469],
    ];
    $byCode = array_column($airports, null, 0);
    $airportsJson = json_encode(array_map(fn ($a) => ['code' => $a[0], 'city' => $a[1], 'lat' => $a[2], 'lon' => $a[3]], $airports));
    $from = $byCode['IST'];
    $to = $byCode['CDG'];

    // Same maths as the app: great circle on a 6371 km sphere; cruise at 800 km/h plus 10 min taxi, to 5 min, kept inside 15–180 min.
    $km = function (array $a, array $b): float {
        $h = sin(deg2rad($b[2] - $a[2]) / 2) ** 2 + cos(deg2rad($a[2])) * cos(deg2rad($b[2])) * sin(deg2rad($b[3] - $a[3]) / 2) ** 2;

        return 2 * 6371 * asin(sqrt(min(1, max(0, $h))));
    };
    $minutes = fn (float $km) => (int) min(180, max(15, round(($km / 800 * 60 + 10) / 5) * 5));
    $fmtKm = fn (float $km) => number_format($km, 0, '', $tr ? '.' : ',');
    $fmtMin = fn (int $m) => $m < 60 ? __(':m dk', ['m' => $m]) : ($m % 60 ? __(':h sa :m dk', ['h' => intdiv($m, 60), 'm' => $m % 60]) : __(':h sa', ['h' => intdiv($m, 60)]));

    $routeKm = $km($from, $to);
    $routeMin = $minutes($routeKm);

    // The phone screen cut out of each store screenshot (screen-skydesk-N.webp beside shot-skydesk-N.webp, in both locale folders).
    // shortcut: the cache-busting hash is the store shot's, not the crop's; re-run the crop and bump nothing if only the crop changes.
    $screen = fn (int $n) => asset(str_replace('shot-skydesk-', 'screen-skydesk-', $app['screenshots'][$n - 1]));

    $sheets = [
        ['name' => 'Harita ve geri sayım', 'text' => 'Uçağın dünya haritasında ilerler. Büyük geri sayım, uçtuğun ve kalan kilometre tek ekranda.', 'shot' => 1, 'focus' => '50% 40%', 'alt' => 'Skydesk uçuş ekranı: IST–CDG rotası haritada, inişe kalan 0:51:20'],
        ['name' => 'Kabin', 'text' => 'Ekran kapalıyken de uçar; bildirimde geri sayım görünür. İstersen yumuşak kabin uğultusu dikkat dağıtan sesleri örter ve Rahatsız Etme uçuş boyunca açık kalır.', 'video' => true],
        ['name' => 'İniş', 'text' => 'Uçak inince seans biter: süre uçuş defterine yazılır, pasaportuna şehrin damgası vurulur. İnişini paylaşabilirsin.', 'shot' => 3, 'focus' => '50% 0%', 'alt' => 'Skydesk iniş ekranı: Varış Paris, 1 sa 23 dk odak süresi, rozetler'],
        ['name' => 'Pasaport', 'text' => 'Uçuş, saat ve kilometre toplamları, bu haftanın odak grafiği, günlük seri ve indiğin her şehrin damgası.', 'shot' => 4, 'focus' => '50% 100%', 'alt' => 'Skydesk pasaport ekranı: 9 uçuş, 9 ülke, 7 gün seri, şehir damgaları'],
    ];

    $faq = [
        'Skydesk ücretli mi?' => 'Hayır, ücretsizdir ve reklamlarla desteklenir: iniş ekranında küçük bir reklam ve oturum başına en fazla bir tam ekran reklam. Uçuş sırasında asla.',
        'Ekranı kapatırsam sayaç durur mu?' => 'Hayır. Ekran kapalıyken de çalışmaya devam eder ve bildirimde geri sayım görünür. Uygulamayı kapatsan bile uçuş zamanında iner.',
        'İnternet gerekiyor mu? Verilerim nerede?' => 'Hayır, her şey çevrimdışı çalışır. Hesap ve kayıt yoktur; uçuşların, damgaların ve serin yalnızca cihazında kalır.',
        'Uçuş süresi nasıl hesaplanıyor?' => 'İki havalimanı arasındaki büyük daire mesafesi 800 km/sa seyir hızına bölünür, 10 dakika taksi eklenir ve 5 dakikaya yuvarlanır. En kısa uçuş 15, en uzun 180 dakikadır.',
        'Rotayı sevmedim, süreyi kendim seçebilir miyim?' => 'Evet. 25, 50 ve 90 dakikalık hazır süreler var; Özel ile 15–180 dakika arasında istediğin süreyi kaydırıcıdan seçersin.',
        'Uçuşu yarıda kesersem ne olur?' => 'Uçuş iptal olur, damga ve süre işlenmez. Serin yalnızca o gün hiç inmezsen bozulur.',
        'Kabin sesi nedir?' => 'Kahverengi gürültüden üretilen yumuşak bir uğultu; kulaklıkla ya da hoparlörden dikkat dağıtan sesleri örter. İstersen açarsın.',
        'Hangi telefonlarda çalışır?' => 'Android 7.0 ve üzeri. Rahatsız Etme için sistem izni istenir; vermezsen uçuş yine kalkar.',
    ];
@endphp

@section('content')
<div class="sd" data-sd>
    <style>
        /* Skydesk page, built as the boarding pass the app issues for each session. */
        .sd {
            --sd-paper: var(--color-ink);
            --sd-paper-2: #e2dfea;
            --sd-t1: #171325;
            --sd-t2: #282038;
            --sd-t3: #3b3352;
            --sd-t4: #dcd8e8;
        }

        /* The pass: paper on the dark ground, a stripe band across its top, tidy columns like a printed ticket. */
        .sd-pass {
            background: var(--sd-paper);
            color: var(--color-canvas);
        }
        .sd-stripe {
            display: flex;
            height: 40px;
            overflow: hidden;
            contain: inline-size;
        }
        .sd-stripe > span {
            flex: 0 0 28px;
        }
        .sd-stripe > span:nth-child(odd) {
            background: var(--color-canvas);
        }
        .sd-h1 {
            font-size: clamp(2.5rem, 4.4vw, 4.25rem);
            line-height: 0.95;
            letter-spacing: -0.035em;
        }
        .sd-line {
            display: block;
            overflow: hidden;
            padding-bottom: 0.08em;
        }
        .sd-line > span {
            display: block;
        }
        /* The route fields are the live thing: a select dressed as the pass's printed field. */
        .sd-field {
            display: block;
            background: var(--sd-paper-2);
            padding: 12px 14px 10px;
        }
        .sd-field select {
            display: block;
            width: 100%;
            appearance: none;
            background: transparent;
            border: 0;
            padding: 0;
            font: inherit;
            font-size: clamp(2rem, 3.2vw, 2.75rem);
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.02em;
            color: var(--color-canvas);
            cursor: pointer;
        }
        .sd-field select:focus-visible {
            outline: 3px solid var(--color-accent);
            outline-offset: 4px;
        }
        .sd-field:hover {
            background: #d6d2e2;
        }

        /* The window beside the pass: one real picture, held while the pass scrolls. */
        .sd-window {
            overflow: hidden;
            background: var(--sd-t1);
        }
        .sd-window img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 62%;
        }

        /* The itinerary slip: paper with a zigzag foot, rows with dotted leaders. */
        .sd-slip {
            background: var(--sd-paper);
            color: var(--color-canvas);
            clip-path: polygon(0 0, 100% 0, 100% calc(100% - 14px),
                97.5% 100%, 95% calc(100% - 14px), 92.5% 100%, 90% calc(100% - 14px), 87.5% 100%, 85% calc(100% - 14px), 82.5% 100%, 80% calc(100% - 14px),
                77.5% 100%, 75% calc(100% - 14px), 72.5% 100%, 70% calc(100% - 14px), 67.5% 100%, 65% calc(100% - 14px), 62.5% 100%, 60% calc(100% - 14px),
                57.5% 100%, 55% calc(100% - 14px), 52.5% 100%, 50% calc(100% - 14px), 47.5% 100%, 45% calc(100% - 14px), 42.5% 100%, 40% calc(100% - 14px),
                37.5% 100%, 35% calc(100% - 14px), 32.5% 100%, 30% calc(100% - 14px), 27.5% 100%, 25% calc(100% - 14px), 22.5% 100%, 20% calc(100% - 14px),
                17.5% 100%, 15% calc(100% - 14px), 12.5% 100%, 10% calc(100% - 14px), 7.5% 100%, 5% calc(100% - 14px), 2.5% 100%, 0 calc(100% - 14px));
        }
        .sd-row {
            display: flex;
            align-items: baseline;
            gap: 12px;
        }
        .sd-row > span:last-child {
            white-space: nowrap;
        }
        .sd-row .sd-dots {
            flex: 1;
            min-width: 24px;
            border-bottom: 4px dotted currentColor;
            transform: translateY(-5px);
        }

        /* Features: colour sheets that slide up over each other, the last one paper. */
        .sd-sheet {
            min-height: 86svh;
            color: var(--color-ink);
        }
        .sd-sheet:nth-child(1) { background: var(--sd-t1); }
        .sd-sheet:nth-child(2) { background: var(--sd-t2); }
        .sd-sheet:nth-child(3) { background: var(--sd-t3); }
        .sd-sheet:nth-child(4) { background: var(--sd-t4); color: var(--color-canvas); }
        /* Desktop: sheets slide up over each other, each leaving its 72px title band. Earlier sheets are taller by the
           offsets below them, so when the stack scrolls away together every band is still showing. */
        @media (min-width: 1024px) {
            .sd-sheet { position: sticky; }
            .sd-sheet:nth-child(1) { top: 0; min-height: calc(86svh + 216px); }
            .sd-sheet:nth-child(2) { top: 72px; min-height: calc(86svh + 144px); }
            .sd-sheet:nth-child(3) { top: 144px; min-height: calc(86svh + 72px); }
            .sd-sheet:nth-child(4) { top: 216px; }
        }
        .sd-sheet video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 50% 100%;
        }

        /* Questions as reading text, the notes on the back of the pass. */
        .sd-faq {
            columns: 1;
            column-gap: 56px;
        }
        .sd-faq p {
            break-inside: avoid;
        }

        /* The close: the stub, tilted on the accent field and cropped by it. */
        .sd-stub {
            background: var(--sd-paper);
            color: var(--color-canvas);
            transform: rotate(-1deg);
        }
        .sd-stub .sd-go {
            display: block;
            background: var(--color-canvas);
            color: var(--color-ink);
        }
        .sd-stub .sd-go:hover,
        .sd-stub .sd-go:focus-visible {
            background: var(--color-accent);
            color: var(--color-canvas);
        }

        @media (min-width: 1024px) {
            .sd-sheet:nth-child(2) { top: 72px; }
            .sd-faq {
                columns: 2;
            }
            .sd-stub {
                transform: rotate(2deg);
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            .sd-line > span {
                animation: sd-mask 900ms cubic-bezier(0.16, 1, 0.3, 1) both;
            }
            .sd-line + .sd-line > span {
                animation-delay: 110ms;
            }
            .sd-stripe > span {
                animation: sd-print 500ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
                animation-delay: calc(var(--i) * 18ms);
            }
            .sd-after {
                animation: rise 500ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
                animation-delay: calc(250ms + var(--i, 0) * 70ms);
            }
            .sd-window img {
                animation: sd-drift 14s ease-in-out infinite alternate;
            }
            /* The pass reprints when the route changes. */
            .sd-reprint {
                animation: sd-in 320ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
            }
            .sd-field:active select {
                transform: scale(0.98);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .sd-sheet video {
                display: none;
            }
            .sd-sheet .sd-poster {
                display: block;
            }
        }
        .sd-sheet .sd-poster {
            display: none;
        }

        @keyframes sd-mask {
            from { transform: translateY(105%); }
        }
        @keyframes sd-print {
            from { transform: scaleY(0); }
        }
        @keyframes sd-drift {
            from { transform: scale(1.04) translateX(-1.5%); }
            to { transform: scale(1.04) translateX(1.5%); }
        }
        @keyframes sd-in {
            from { opacity: 0; transform: translateY(6px); }
        }
    </style>

    {{-- Hero: the boarding pass beside the window. --}}
    <section class="mx-auto grid max-w-6xl grid-cols-1 gap-3 px-6 pt-4 lg:grid-cols-2 lg:pt-6">
        {{-- Phone: the window comes first, the pass overlaps its foot. --}}
        <div class="sd-window h-[48svh] min-h-[280px] lg:sticky lg:top-6 lg:order-2 lg:h-[calc(100svh-48px)] lg:min-h-[640px]">
            <img src="{{ $pic('view-from-an-airplane-window-showing-the.jpg') }}" alt="{{ __('Uçak penceresinden kanat ve bulutların üstünde mavi gökyüzü') }}" width="1536" height="2048" fetchpriority="high">
        </div>

        <div class="sd-pass -mt-6 lg:order-1 lg:mt-0" data-pass>
            <div class="sd-stripe" aria-hidden="true">
                @for ($i = 0; $i < 40; $i++)<span style="--i: {{ $i }}"></span>@endfor
            </div>

            <div class="px-6 pb-8 pt-8 lg:px-10 lg:pb-10 lg:pt-10">
                <h1 class="sd-h1 font-extrabold">
                    <span class="sd-line"><span>{{ __('Her seans') }}</span></span>
                    <span class="sd-line"><span>{{ __('bir uçuş.') }}</span></span>
                </h1>
                <p class="sd-after mt-6 max-w-[40ch] text-[17px] leading-relaxed" style="--i: 1">{{ __('Skydesk çevrimdışı bir odak zamanlayıcı. Rotanı seç, uçağa bin; uçak inene kadar odakta kal. Rotanın uçuş süresi seansın olur.') }}</p>

                {{-- The live thing: a route, priced in minutes with the app's own formula. --}}
                <form class="sd-after mt-8 grid grid-cols-2 gap-3" style="--i: 2" data-route>
                    <label class="sd-field">
                        <span class="block text-[15px] font-semibold">{{ __('Nereden') }}</span>
                        <select name="from" data-from aria-describedby="sd-fare">
                            @foreach ($airports as $a)
                                <option value="{{ $a[0] }}" @selected($a[0] === $from[0])>{{ $a[0] }}</option>
                            @endforeach
                        </select>
                        <span class="mt-1 block text-[15px]" data-from-city>{{ $from[1] }}</span>
                    </label>
                    <label class="sd-field">
                        <span class="block text-[15px] font-semibold">{{ __('Nereye') }}</span>
                        <select name="to" data-to aria-describedby="sd-fare">
                            @foreach ($airports as $a)
                                <option value="{{ $a[0] }}" @selected($a[0] === $to[0])>{{ $a[0] }}</option>
                            @endforeach
                        </select>
                        <span class="mt-1 block text-[15px]" data-to-city>{{ $to[1] }}</span>
                    </label>
                </form>

                <dl id="sd-fare" class="sd-after mt-6 grid grid-cols-2 gap-3 text-[15px]" style="--i: 3" aria-live="polite">
                    <div><dt class="font-semibold">{{ __('Mesafe') }}</dt><dd class="text-2xl font-bold tabular-nums" data-km>{{ $fmtKm($routeKm) }} km</dd></div>
                    <div><dt class="font-semibold">{{ __('Uçuş süresi = seans') }}</dt><dd class="text-2xl font-bold tabular-nums" data-min>{{ $fmtMin($routeMin) }}</dd></div>
                    <div><dt class="font-semibold">{{ __('Koltuk') }}</dt><dd class="text-2xl font-bold">{{ __('Masan') }}</dd></div>
                    <div><dt class="font-semibold">{{ __('Uçuş sırasında reklam') }}</dt><dd class="text-2xl font-bold">{{ __('Yok') }}</dd></div>
                </dl>

                <div class="sd-after mt-8 flex flex-wrap items-center gap-x-6 gap-y-4" style="--i: 4">
                    <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press inline-block bg-canvas px-6 py-4 font-semibold text-ink hover:bg-accent hover:text-canvas">{{ __("Google Play'de aç") }}</a>
                    <a href="{{ $app['privacy_url'] }}" class="font-semibold underline decoration-canvas/40 underline-offset-4 transition-colors hover:decoration-current">{{ __('Gizlilik Politikası') }}</a>
                </div>
                <p class="sd-after mt-8 text-[15px]" style="--i: 5">{{ __('Gerçek havalimanları, gerçek mesafeler. Uygulamada 168 havalimanı var; süreyi rota belirler ya da sen seçersin.') }}</p>
                <p class="sd-after mt-8 flex items-center justify-between gap-4 text-[15px] font-semibold" style="--i: 6">
                    <span class="flex items-center gap-2"><img src="{{ asset('images/apps/' . $app['icon']) }}" alt="" width="28" height="28" class="h-7 w-7">Skydesk</span>
                    <span>{{ __('Biniş kartı') }}</span>
                </p>
            </div>
        </div>
    </section>

    {{-- How it works: the itinerary slip. --}}
    <section class="pt-32 md:pt-48">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-5">
                <h2 class="text-[clamp(2.5rem,4.4vw,4.25rem)] font-bold leading-none tracking-[-0.03em] text-ink">{{ __('Uçuş planı') }}</h2>
                <p class="mt-6 max-w-[32ch] text-[17px] leading-relaxed text-ink">{{ __('Bir Skydesk seansı gerçek bir uçuş gibi üç parçadır. Sen yalnızca rotayı seçersin; gerisini uçak yapar.') }}</p>
                <p class="mt-4 max-w-[32ch] text-[17px] leading-relaxed text-ink">{{ __('Aşağıdaki plan, yukarıda seçtiğin rota için yazıldı.') }}</p>
            </div>

            <div class="sd-slip px-6 pb-10 pt-7 text-[17px] tabular-nums lg:col-span-5 lg:col-start-7 lg:px-8" data-reveal>
                <p class="text-2xl font-bold">{{ __('Kalkış') }}</p>
                <div class="sd-row mt-3"><span>{{ __('Rota') }}</span><span class="sd-dots"></span><span class="font-semibold" data-route-code>{{ $from[0] }} → {{ $to[0] }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Uçuş süresi') }}</span><span class="sd-dots"></span><span class="font-semibold" data-min>{{ $fmtMin($routeMin) }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Ya da hazır süre') }}</span><span class="sd-dots"></span><span class="font-semibold">25 · 50 · 90 {{ __('dk') }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Biniş kartı') }}</span><span class="sd-dots"></span><span class="font-semibold">{{ __('kalkış') }}</span></div>

                <p class="mt-7 text-2xl font-bold">{{ __('Seyir') }}</p>
                <div class="sd-row mt-3"><span>{{ __('Harita ve geri sayım') }}</span><span class="sd-dots"></span><span class="font-semibold">{{ __('uçuş boyunca') }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Ekran kapalı') }}</span><span class="sd-dots"></span><span class="font-semibold">{{ __('uçar') }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Kabin sesi, Rahatsız Etme') }}</span><span class="sd-dots"></span><span class="font-semibold">{{ __('isteğe bağlı') }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Reklam') }}</span><span class="sd-dots"></span><span class="font-semibold">{{ __('yok') }}</span></div>

                <p class="mt-7 text-2xl font-bold">{{ __('İniş') }}</p>
                <div class="sd-row mt-3"><span>{{ __('Pasaport damgası') }}</span><span class="sd-dots"></span><span class="font-semibold" data-to-city>{{ $to[1] }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Uçuş defterine') }}</span><span class="sd-dots"></span><span class="font-semibold" data-min>{{ $fmtMin($routeMin) }}</span></div>
                <div class="sd-row mt-2"><span>{{ __('Küçük bir reklam') }}</span><span class="sd-dots"></span><span class="font-semibold">{{ __('iniş ekranında') }}</span></div>

                <p class="-mx-6 mt-8 flex min-h-11 items-center bg-canvas px-6 text-[17px] font-semibold text-ink lg:-mx-8 lg:px-8" data-hold>{{ __('Elinde: :city damgası ve :min odak.', ['city' => $to[1], 'min' => $fmtMin($routeMin)]) }}</p>
            </div>
        </div>
    </section>

    {{-- Features: the cabin, sheet by sheet. --}}
    <section class="pt-32 md:pt-48">
        <div class="mx-auto max-w-6xl px-6 pb-12">
            <h2 class="text-[clamp(2.5rem,4.4vw,4.25rem)] font-bold leading-none tracking-[-0.03em] text-ink">{{ __('Kabinde neler var') }}</h2>
        </div>
        <div>
            @foreach ($sheets as $s => $sheet)
                <div class="sd-sheet">
                    <div class="mx-auto grid max-w-6xl gap-6 px-6 lg:min-h-[86svh] lg:grid-cols-12 lg:gap-6">
                        <div class="flex flex-col justify-between gap-8 pt-5 lg:col-span-6 lg:pb-8">
                            <h3 class="text-[clamp(1.75rem,3vw,2.75rem)] font-bold leading-none tracking-[-0.02em]">{{ __($sheet['name']) }}</h3>
                            <p class="max-w-[40ch] text-[17px] leading-relaxed" data-reveal>{{ __($sheet['text']) }}</p>
                        </div>
                        <div class="pb-0 lg:col-span-6 lg:pt-[72px]">
                            @if ($sheet['video'] ?? false)
                                <div class="relative aspect-[4/3] overflow-hidden lg:h-[calc(86svh-72px)] lg:aspect-auto">
                                    <video autoplay muted loop playsinline preload="metadata" poster="{{ $pic('clouds-from-airplane-window-1-2016-08-poster.jpg') }}" width="854" height="480" aria-hidden="true"><source src="{{ $pic('clouds-from-airplane-window-1-2016-08.webm') }}" type="video/webm"></video>
                                    <img class="sd-poster absolute inset-0 h-full w-full object-cover object-bottom" src="{{ $pic('clouds-from-airplane-window-1-2016-08-poster.jpg') }}" alt="{{ __('Uçak kanadı bulutların üstünde') }}" width="1280" height="720" loading="lazy">
                                </div>
                            @else
                                <img src="{{ $screen($sheet['shot']) }}" alt="{{ __($sheet['alt']) }}" width="364" height="624" loading="lazy" class="mx-auto w-[min(100%,380px)] lg:mx-0 lg:h-[calc(86svh-72px)] lg:w-full lg:object-cover" style="object-position: {{ $sheet['focus'] }}">
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Questions, as the notes on the back. --}}
    <section class="pt-32 md:pt-48" aria-labelledby="faq-h">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 lg:grid-cols-12 lg:gap-6">
            <h2 id="faq-h" class="text-[clamp(1.75rem,3vw,2.75rem)] font-bold leading-none tracking-[-0.02em] text-ink lg:col-span-3">{{ __('Sık sorulanlar') }}</h2>
            <div class="sd-faq text-[17px] leading-[1.55] text-ink lg:col-span-8 lg:col-start-5">
                @foreach ($faq as $q => $a)
                    <p @class(['mt-5' => ! $loop->first]) data-reveal><strong class="font-semibold">{{ __($q) }}</strong> {{ __($a) }}</p>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Close: the stub. --}}
    <section class="mt-32 overflow-hidden bg-accent md:mt-48">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 pt-16 lg:grid-cols-12 lg:gap-6 lg:pt-24">
            <div class="flex items-end lg:col-span-4 lg:pb-16">
                <p class="max-w-[28ch] text-2xl font-semibold leading-snug text-canvas">{{ __('Bir sonraki dersin ya da işin için biniş kartını al. Uçak inene kadar masandasın.') }}</p>
            </div>
            <div class="sd-stub mx-auto -mb-10 flex w-[92%] flex-col justify-center px-6 pb-20 pt-8 text-center lg:col-span-6 lg:col-start-7 lg:-mb-16 lg:aspect-[7/5] lg:w-full lg:self-end lg:px-12 lg:pb-24 lg:pt-10" data-reveal>
                <h2 class="text-[clamp(1.75rem,3vw,2.75rem)] font-bold leading-none tracking-[-0.02em]">{{ __('Biniş kartını al') }}</h2>
                <p class="mt-4 text-[17px]">{{ __('Ücretsiz, Android için. Hesap yok, kayıt yok, uçuşta reklam yok.') }}</p>
                <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="sd-go press mt-8 flex h-14 items-center justify-center text-[17px] font-semibold">{{ __("Google Play'de aç") }}</a>
                <p class="mt-5 text-[15px]"><a href="{{ $app['privacy_url'] }}" class="underline decoration-canvas/40 underline-offset-4 hover:decoration-current">{{ __('Gizlilik Politikası') }}</a></p>
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-6xl px-6 pt-10">
        <p class="max-w-[70ch] text-[15px] leading-relaxed text-ink-dim">
            {{ __('Pencere fotoğrafı:') }} <a href="https://wordpress.org/photos/photo/424667aec8/" class="underline underline-offset-2 hover:text-ink">Moin Uddin Ahmed</a>, CC0, WordPress Photo Directory.
            {{ __('Bulut videosu:') }} <a href="https://commons.wikimedia.org/wiki/File:Clouds_from_Airplane_Window_1_2016-08-29.webm" class="underline underline-offset-2 hover:text-ink">F ASTILY</a>, CC BY-SA 4.0, Wikimedia Commons.
        </p>
    </div>
</div>

<script>
    // The pass reprints for the chosen route with the app's own maths: great circle on a 6371 km sphere, 800 km/h plus 10 min taxi, to 5 min, 15–180.
    (() => {
        const root = document.querySelector('[data-sd]');
        const airports = {!! $airportsJson !!};
        const lang = document.documentElement.lang;
        const t = { hm: @json(__(':h sa :m dk')), h: @json(__(':h sa')), m: @json(__(':m dk')), hold: @json(__('Elinde: :city damgası ve :min odak.')) };
        const rad = (d) => (d * Math.PI) / 180;
        const km = (a, b) => {
            const h = Math.sin(rad(b.lat - a.lat) / 2) ** 2 + Math.cos(rad(a.lat)) * Math.cos(rad(b.lat)) * Math.sin(rad(b.lon - a.lon) / 2) ** 2;
            return 2 * 6371 * Math.asin(Math.sqrt(Math.min(1, Math.max(0, h))));
        };
        const minutes = (d) => Math.min(180, Math.max(15, Math.round((d / 800 * 60 + 10) / 5) * 5));
        const fmtMin = (m) => (m < 60 ? t.m : m % 60 ? t.hm : t.h).replace(':h', Math.floor(m / 60)).replace(':m', m % 60);
        const set = (sel, text) => root.querySelectorAll(sel).forEach((el) => { el.textContent = text; el.classList.remove('sd-reprint'); void el.offsetWidth; el.classList.add('sd-reprint'); });

        const update = () => {
            const from = airports.find((a) => a.code === root.querySelector('[data-from]').value);
            const to = airports.find((a) => a.code === root.querySelector('[data-to]').value);
            const d = km(from, to);
            const m = minutes(d);
            set('[data-from-city]', from.city);
            set('[data-to-city]', to.city);
            set('[data-route-code]', `${from.code} → ${to.code}`);
            set('[data-km]', `${Math.round(d).toLocaleString(lang)} km`);
            set('[data-min]', fmtMin(m));
            set('[data-hold]', t.hold.replace(':city', to.city).replace(':min', fmtMin(m)));
        };

        root.querySelector('[data-route]').addEventListener('change', update);
        root.querySelector('[data-route]').addEventListener('submit', (e) => e.preventDefault());
    })();
</script>
@endsection
