@extends('layouts.site')

@section('title', "{$app['name']} — Zettelabs")
@section('description', __($app['tagline']))

@php
    $tr = app()->getLocale() === 'tr';
    $pic = fn (string $file) => asset("images/apps/offlinescanner/{$file}");
    $screen = fn (int $n) => asset(str_replace('shot-offlinescanner-', 'screen-offlinescanner-', $app['screenshots'][$n - 1]));

    // Four real documents from the open collections stand in as the sample scans; their text is what the search reads.
    $docs = [
        ['file' => 'receipt-flat.webp', 'title' => 'Berghotel Grosse Scheidegg', 'date' => __('9 Kas 2026 01:16'), 'text' => 'Berghotel Grosse Scheidegg, 3818 Grindelwald, Familie R. Müller. Rech. Nr. 4572, 30.07.2007 13:29:17, Bar, Tisch 7/01. 2x Latte Macchiato à 4.50 CHF 9.00. 1x Gloki à 5.00 CHF 5.00. 1x Schweinschnitzel à 22.00 CHF 22.00. 1x Chässpätzli à 18.50 CHF 18.50. Total: CHF 54.50. Incl. 7.6% MwSt 54.50 CHF: 3.85. Entspricht in Euro 36.33 EUR. Es bediente Sie: Ursula.'],
        ['file' => 'typewritten-letter-of-pierre-chouteau-st-louis.webp', 'title' => 'Pierre Chouteau, St. Louis', 'date' => __('9 Kas 2026 01:15'), 'text' => 'Sept. 5, 1903. Miss Mary Louise Dalton, Missouri Historical Socy., St. Louis. My dear Miss Dalton: I think the following will fully answer your inquiries, but if locations, months and days are desired, many can be furnished. Pierre Ligueste de Laclede, born 1724, emigrated to Louisiana 1755, founded St. Louis 1764, died 1778. He died June 20th, 1778, at the mouth of the Arkansas river while en route from New Orleans to St. Louis. Very truly yours, Pierre Chouteau. Dictated.'],
        ['file' => 'a-very-early-typewritten-letter-as-part.webp', 'title' => 'Justices Court, Salt Lake City', 'date' => __('8 Kas 2026 18:40'), 'text' => 'In the Justices Court of the Fifth Precinct of Salt Lake City, Utah Territory. Salt Lake City Foundry and Manufacturing Company, a corporation, Plaintiff, vs. Pleasant Valley Coal Company, a corporation, Defendant. Complaint. November 28, 1884. One coal screen 2146, $171.68. Cartage on same, .50. December 1, 1884. Cash prepaid freight 9.60. Total $181.78. Le Grand Young, Attorney for Plaintiff. Subscribed and sworn to before me this 20th day of April, 1886. W. Van Cott, Notary public.'],
        ['file' => 'handwritten-letter-from-t-k-riddick-house.webp', 'title' => 'Hotel Hermitage, Nashville', 'date' => __('8 Kas 2026 18:22'), 'text' => 'Hotel Hermitage, Meyer Hotel Co., Proprietors. Robert R. Meyer, President. Fireproof. European. Nashville, Tenn. When in Knoxville stop at Hotel Farragut. When in Atlanta stop at Hotel Winecoff. Robt. E. Hyde, Resident Manager.'],
    ];
    $docsJson = json_encode(array_map(fn ($d) => ['title' => $d['title'], 'text' => $d['text']], $docs));
    $excerpt = fn (string $t) => mb_substr($t, 0, 60) . '…';

    // The folders in the hero, back to front; each lends its colour to the section it opens.
    $folders = [
        ['name' => 'Nasıl çalışır', 'href' => '#nasil', 'bg' => '#F5B641', 'fg' => '#0f0c18', 'tab' => '8%'],
        ['name' => 'Neler yapar', 'href' => '#neler', 'bg' => '#dcd8e8', 'fg' => '#0f0c18', 'tab' => '30%'],
        ['name' => 'Sorular', 'href' => '#sorular', 'bg' => '#3b3352', 'fg' => '#f5f4f8', 'tab' => '52%'],
        ['name' => 'Gizlilik', 'href' => $app['privacy_url'], 'bg' => '#282038', 'fg' => '#f5f4f8', 'tab' => '70%'],
        ['name' => 'İndir', 'href' => '#indir', 'bg' => '#1c1729', 'fg' => '#f5f4f8', 'tab' => '84%'],
    ];

    $fields = [
        ['bg' => '#dcd8e8', 'fg' => '#0f0c18', 'text' => 'Önce kamera kenarları bulur.'],
        ['bg' => '#3b3352', 'fg' => '#f5f4f8', 'text' => 'Sonra sayfa düzleşir.'],
        ['bg' => '#282038', 'fg' => '#f5f4f8', 'text' => 'Metin tanınır, cihazda.'],
        ['bg' => '#F5B641', 'fg' => '#0f0c18', 'text' => 'Listende durur, aranabilir.'],
    ];

    $tiles = [
        ['name' => 'Kamerayla tara ya da galeriden al', 'fact' => 'Belgeler, fişler, notlar, mektuplar.', 'file' => 'typewritten-letter-of-pierre-chouteau-st-louis.webp', 'alt' => '1903 tarihli daktiloyla yazılmış bir mektup'],
        ['name' => 'Tek seferde çok sayfalı PDF', 'fact' => 'Sayfaları art arda tara; tek PDF olur.', 'file' => 'notebook-mastrino-circa-1920.webp', 'alt' => '1920 dolaylarından, alfabetik ayraçlı bir not defteri', 'wide' => true],
        ['name' => 'Otomatik kenar bulma', 'fact' => 'Perspektif düzeltilir; masa kadrajdan çıkar.', 'file' => 'receiptswiss.webp', 'alt' => 'Ahşap bir masada duran bir restoran fişi'],
        ['name' => 'Cihaz-içi OCR', 'fact' => 'Her sayfadan metin; Latin alfabesiyle yazılmış diller.', 'file' => 'a-very-early-typewritten-letter-as-part.webp', 'alt' => '1886 tarihli daktiloyla yazılmış bir mahkeme dilekçesi'],
        ['name' => 'Tüm taramalarda ara', 'fact' => 'Bir ad, tutar ya da tarih yaz; sonuç metinden gelir.', 'file' => 'handwritten-letter-from-t-k-riddick-house.webp', 'alt' => '1920 tarihli, otel antetli el yazısı bir mektup'],
        ['name' => 'PDF\'i ya da metni paylaş', 'fact' => 'Metni kopyala, PDF\'i gönder.', 'shot' => 2, 'alt' => 'Offline Scanner: tanınan metin ekranı'],
    ];

    $faq = [
        ['tab' => 'Ücret', 'q' => 'Offline Scanner ücretli mi?', 'a' => 'Hayır, ücretsizdir ve reklamlarla desteklenir. Reklamlar tarama ekranında değil, PDF kaydedildikten sonra ve uygulamaya dönüşte gelir.'],
        ['tab' => 'Gizlilik', 'q' => 'Belgelerim bir yere yükleniyor mu?', 'a' => 'Hayır. Tarama, PDF oluşturma ve metin tanıma telefonunda yapılır; hesap ve bulut yüklemesi yoktur. Yalnızca reklamlar internet kullanır.'],
        ['tab' => 'İnternet', 'q' => 'İnternet olmadan çalışır mı?', 'a' => 'Evet. Tarayıcı modülü ilk kullanımda Google Play hizmetleri üzerinden bir kez indirilir (yaklaşık 200 KB); sonrası tamamen çevrimdışı çalışır.'],
        ['tab' => 'Diller', 'q' => 'Metin tanıma hangi dilleri destekler?', 'a' => 'Latin alfabesi kullanan dilleri: Türkçe, İngilizce, İspanyolca, Portekizce, Almanca, Endonezce ve benzerleri.'],
        ['tab' => 'Arama', 'q' => 'Arama neyi arar?', 'a' => 'Her taramanın tanınan metnini ve adını. Bir ad, tutar ya da tarih yazarsın; eşleşen taramalar listede kalır.'],
        ['tab' => 'Telefon', 'q' => 'Hangi telefonlarda çalışır?', 'a' => 'Android 7.0 ve üzeri, Google Play hizmetleri olan telefonlarda.'],
    ];
@endphp

@section('content')
<div class="os" data-os>
    <style>
        /* Offline Scanner page: scans filed in folders. The folder tab is the one shape, from the hero to the index cards. */
        .os {
            --os-amber: #F5B641;
            --os-t1: #1c1729;
            --os-t2: #282038;
            --os-t3: #3b3352;
            --os-t4: #dcd8e8;
        }
        .os-display {
            font-size: clamp(4.5rem, 10vw, 10rem);
            line-height: 0.9;
            letter-spacing: -0.04em;
        }
        .os-big {
            font-size: clamp(2.375rem, 4.6vw, 4.5rem);
            line-height: 0.92;
            letter-spacing: -0.035em;
        }
        .os-h2 {
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            line-height: 0.95;
            letter-spacing: -0.03em;
        }
        .os-clause {
            font-size: clamp(1.375rem, 2vw, 2rem);
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        /* The folder: a filled shape with a trapezoid tab rising from its top edge, cut once and reused. */
        .os-folder {
            --tx: 8%;
            --tw: 200px;
            --th: 40px;
            --x: min(var(--tx), calc(100% - var(--tw)));
            clip-path: polygon(0 var(--th), var(--x) var(--th), calc(var(--x) + 12px) 0, calc(var(--x) + var(--tw) - 12px) 0, calc(var(--x) + var(--tw)) var(--th), 100% var(--th), 100% 100%, 0 100%);
            padding-top: var(--th);
        }
        .os-tab {
            position: absolute;
            left: min(var(--tx), calc(100% - var(--tw)));
            top: 0;
            width: var(--tw);
            height: var(--th);
            display: flex;
            align-items: center;
            padding: 0 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .os-btn {
            display: inline-block;
            clip-path: polygon(8px 0, calc(100% - 8px) 0, 100% 10px, 100% 100%, 0 100%, 0 10px);
            padding: 16px 28px 14px;
            background: var(--os-amber);
            color: var(--color-canvas);
            font-weight: 600;
        }
        .os-btn:hover,
        .os-btn:focus-visible {
            background: var(--color-ink);
        }
        /* Pictures take the folder shape too: the tab at the top left, a third of the width. */
        .os-mask {
            --tx: 0%;
            --tw: 34%;
            --th: 7%;
            clip-path: polygon(0 var(--th), 4% 0, 30% 0, var(--tw) var(--th), 100% var(--th), 100% 100%, 0 100%);
        }

        /* Hero: the stack. */
        .os-stack {
            position: relative;
            height: 49svh;
            min-height: 360px;
            overflow: hidden;
        }
        .os-stack .os-folder {
            position: absolute;
            left: 50%;
            width: 86%;
            height: 120%;
            transform: translateX(-50%);
            top: calc(var(--i) * 64px);
        }
        .os-stack .os-folder:hover {
            top: calc(var(--i) * 64px - 6px);
        }
        @media (max-width: 1023px) {
            .os-stack .os-folder {
                width: 100%;
                top: calc(var(--i) * 52px);
                --tw: 140px;
                --th: 32px;
            }
            .os-stack .os-tab {
                font-size: 15px;
                padding: 0 14px;
            }
        }

        /* Four fields, one card. */
        .os-field {
            min-height: 64svh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }
        @media (min-width: 1024px) {
            .os-field {
                min-height: 84svh;
                padding: 28px;
            }
        }
        [data-ui].os-card {
            width: 260px;
            background: #171325;
            color: #f5f4f8;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 150ms ease-out;
        }
        .os-field:hover [data-ui].os-card {
            transform: translateY(-6px);
        }
        [data-ui] .os-ui-text {
            font-size: 12px;
            line-height: 1.4;
            color: #d6d2e2;
        }
        [data-ui] .os-ui-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--os-amber);
        }
        [data-ui] .os-ui-row {
            display: flex;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            background: #211c31;
        }
        [data-ui] .os-ui-search {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border: 1px solid #3b3352;
            border-radius: 10px;
            background: #171325;
            color: #a7a2b8;
            font-size: 14px;
        }
        [data-ui] .os-ui-search input {
            width: 100%;
            background: transparent;
            border: 0;
            outline: 0;
            color: #f5f4f8;
            font: inherit;
        }
        [data-ui] .os-ui-search:focus-within {
            border-color: var(--os-amber);
        }
        [data-ui] mark {
            background: var(--os-amber);
            color: #0f0c18;
            border-radius: 2px;
            padding: 0 1px;
        }

        /* Tiles. */
        .os-tile {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 10% 14% 0;
        }
        .os-tile img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        /* Index cards. */
        .os-cardq {
            position: relative;
            --th: 40px;
            --tw: 200px;
        }
        .os-cardq summary {
            list-style: none;
            cursor: pointer;
        }
        .os-cardq summary::-webkit-details-marker {
            display: none;
        }
        .os-cardq summary:focus-visible {
            outline: 3px solid var(--os-amber);
            outline-offset: -3px;
        }
        @media (max-width: 1023px) {
            .os-cardq {
                --tw: 120px;
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            /* The folders are dealt into the drawer, back to front. */
            .os-stack .os-folder {
                animation: os-deal 700ms cubic-bezier(0.16, 1, 0.3, 1) both;
                animation-delay: calc(var(--i) * 90ms);
                transition: top 150ms ease-out;
            }
            .os-rise {
                animation: rise 500ms cubic-bezier(0.2, 0.7, 0.2, 1) both;
                animation-delay: calc(var(--i, 0) * 80ms);
            }
            .reveal-on .os-tile[data-reveal]:not(.is-in) {
                transform: translateY(24px);
            }
            .os-btn {
                transition: background-color 150ms ease-out, transform 120ms ease-out;
            }
            .os-btn:active {
                transform: scale(0.97);
            }
            .os-reprint {
                animation: os-in 240ms ease-out both;
            }
            .os-tile.os-drift img {
                animation: os-drift 16s ease-in-out infinite alternate;
            }
        }
        @keyframes os-deal {
            from { transform: translate(-50%, 40%); opacity: 0; }
        }
        @keyframes os-in {
            from { opacity: 0; transform: translateY(4px); }
        }
        @keyframes os-drift {
            from { object-position: 50% 0%; }
            to { object-position: 50% 30%; }
        }
    </style>

    {{-- Hero: the drawer of folders. --}}
    <section class="flex flex-col lg:min-h-[calc(100svh-76px)]">
        <div class="mx-auto w-full max-w-6xl px-6 pt-10 text-center lg:pt-14">
            <h1 class="os-display os-rise font-extrabold uppercase text-ink">{{ __('Tara ve bul') }}</h1>
            <p class="os-rise mx-auto mt-6 max-w-[46ch] text-[18px] leading-relaxed text-ink" style="--i: 1">{{ __('Offline Scanner belgeleri kamerayla tarar, PDF\'e ve aranabilir metne çevirir. Hesap yok, bulut yok: hiçbir şey telefonundan çıkmaz.') }}</p>
        </div>

        <div class="os-stack mt-10 flex-1 lg:mt-12">
            @foreach ($folders as $i => $f)
                @if (! $loop->last)
                    <a href="{{ $f['href'] }}" class="os-folder block" style="--i: {{ $i }}; --tx: {{ $f['tab'] }}; background: {{ $f['bg'] }}; color: {{ $f['fg'] }}">
                        <span class="os-tab">{{ __($f['name']) }}</span>
                    </a>
                @else
                    {{-- The front folder is open: it holds the one action. --}}
                    <div class="os-folder" style="--i: {{ $i }}; --tx: {{ $f['tab'] }}; background: {{ $f['bg'] }}; color: {{ $f['fg'] }}">
                        <a href="{{ $f['href'] }}" class="os-tab">{{ __($f['name']) }}</a>
                        <div class="px-8 pt-8">
                            <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="os-btn press">{{ __("Google Play'de aç") }}</a>
                            <p class="mt-4 max-w-[40ch] text-[15px] text-ink-dim">{{ __('Android için, ücretsiz. Tarayıcı modülü ilk seferde bir kez iner (yaklaşık 200 KB); sonrası tamamen çevrimdışı.') }} <a href="{{ $app['privacy_url'] }}" class="underline underline-offset-2 hover:text-ink">{{ __('Gizlilik Politikası') }}</a></p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- One scan, four stops. --}}
    <section id="nasil" class="scroll-mt-6 pt-32 md:pt-48">
        <div class="grid lg:grid-cols-4">
            @foreach ($fields as $i => $field)
                <div class="os-field" style="background: {{ $field['bg'] }}; color: {{ $field['fg'] }}">
                    <div>
                        @if ($loop->first)
                            <h2 class="os-clause font-extrabold">{{ __('Bir taramanın yolu') }}</h2>
                        @endif
                    </div>

                    <div class="mx-auto my-8 w-full max-w-[260px]" data-reveal>
                        <div class="os-card" data-ui>
                            @if ($i === 0)
                                <div class="relative">
                                    <img src="{{ $pic('receiptswiss.webp') }}" alt="{{ __('Masadaki fiş; bulunan kenarlar sarı çizgiyle işaretli') }}" width="900" height="1200" loading="lazy" class="block aspect-[3/4] w-full object-cover">
                                    <svg class="absolute inset-0 h-full w-full" viewBox="0 0 300 400" aria-hidden="true"><polygon points="38,22 262,22 262,392 32,392" fill="none" stroke="#F5B641" stroke-width="3"/><circle cx="38" cy="22" r="6" fill="#F5B641"/><circle cx="262" cy="22" r="6" fill="#F5B641"/><circle cx="262" cy="392" r="6" fill="#F5B641"/><circle cx="32" cy="392" r="6" fill="#F5B641"/></svg>
                                </div>
                                <p class="os-ui-label p-3">{{ __('Kenarlar bulundu') }}</p>
                            @elseif ($i === 1)
                                <img src="{{ $pic('receipt-flat.webp') }}" alt="{{ __('Aynı fiş, düzleştirilmiş ve kırpılmış') }}" width="689" height="1106" loading="lazy" class="block aspect-[3/4] w-full object-cover object-top">
                                <p class="os-ui-label p-3">{{ __('Sayfa 1 · düzleştirildi') }}</p>
                            @elseif ($i === 2)
                                <div class="flex gap-3 p-3">
                                    <img src="{{ $pic('receipt-flat.webp') }}" alt="" width="689" height="1106" loading="lazy" class="block h-24 w-16 object-cover object-top">
                                    <div>
                                        <p class="text-[13px] font-semibold">{{ $docs[0]['title'] }}</p>
                                        <p class="os-ui-text">{{ $docs[0]['date'] }} · {{ __('1 sayfa') }}</p>
                                    </div>
                                </div>
                                <div class="px-3 pb-3">
                                    <p class="os-ui-label">{{ __('Tanınan metin') }} · {{ __('Cihazda') }}</p>
                                    <p class="os-ui-text mt-1">Berghotel Grosse Scheidegg<br>3818 Grindelwald<br>Rech.Nr. 4572 · 30.07.2007<br>2x Latte Macchiato à 4.50 CHF 9.00<br>1x Schweinschnitzel à 22.00 CHF 22.00<br>Total: CHF 54.50</p>
                                </div>
                            @else
                                <div class="p-3">
                                    <div class="os-ui-search"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2"/></svg><span class="text-ink">Schnitzel</span></div>
                                    <div class="os-ui-row mt-3">
                                        <img src="{{ $pic('receipt-flat.webp') }}" alt="" width="689" height="1106" loading="lazy" class="block h-16 w-12 object-cover object-top">
                                        <div class="min-w-0">
                                            <p class="truncate text-[13px] font-semibold">{{ $docs[0]['title'] }}</p>
                                            <p class="os-ui-text">…1x <mark>Schweinschnitzel</mark> à 22.00 CHF…</p>
                                            <p class="os-ui-text">{{ $docs[0]['date'] }} · {{ __('1 sayfa') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <p @class(['os-clause max-w-[16ch] font-semibold', 'lg:ml-auto lg:text-right' => $loop->last])>{{ __($field['text']) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Specimens: real documents on tiles. --}}
    <section id="neler" class="scroll-mt-6 pt-32 md:pt-48">
        <div class="mx-auto grid max-w-6xl gap-10 px-6 lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-3">
                <h2 class="os-h2 font-bold text-ink">{{ __('Neler yapar') }}</h2>
                <p class="mt-5 max-w-[30ch] text-[17px] leading-relaxed text-ink">{{ __('Kâğıt ne olursa olsun: fiş, mektup, defter, dilekçe. Hepsi telefonunda PDF ve metin olur.') }}</p>
            </div>
            <ul class="grid grid-cols-2 gap-x-2 gap-y-8 lg:col-span-9 lg:grid-cols-3 lg:gap-x-[10px]">
                @foreach ($tiles as $t => $tile)
                    <li @class(['col-span-2 max-lg:order-first' => $tile['wide'] ?? false])>
                        <div @class(['os-tile', ['bg-[#dcd8e8]', 'bg-[#3b3352]', 'bg-[#F5B641]'][$t % 3], ($tile['wide'] ?? false) ? 'aspect-[8/5]' : 'aspect-[4/5]', 'os-drift' => $tile['wide'] ?? false])>
                            <div class="os-mask h-[76%] w-full lg:w-[70%]" data-reveal>
                                <img src="{{ isset($tile['shot']) ? $screen($tile['shot']) : $pic($tile['file']) }}" alt="{{ __($tile['alt']) }}" width="900" height="1200" loading="lazy">
                            </div>
                        </div>
                        <h3 class="mt-3 text-[18px] font-semibold text-ink lg:text-[20px]">{{ __($tile['name']) }}</h3>
                        <p class="mt-1 text-[15px] leading-snug text-ink-dim lg:text-[16px]">{{ __($tile['fact']) }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Questions, filed. --}}
    <section id="sorular" class="scroll-mt-6 pt-32 md:pt-48" aria-labelledby="faq-h">
        <div class="mx-auto max-w-6xl px-6 lg:grid lg:grid-cols-12 lg:gap-6">
            <div class="lg:col-span-8 lg:col-start-3">
                <h2 id="faq-h" class="os-h2 font-bold text-ink">{{ __('Sık sorulanlar') }}</h2>
                <div class="mt-10">
                    @foreach ($faq as $i => $item)
                        <details class="os-cardq os-folder" name="os-faq" @if ($loop->first) open @endif data-reveal style="--tx: {{ min($i * 150, 700) }}px; background: {{ ['#dcd8e8', '#3b3352', '#F5B641'][$i % 3] }}; color: {{ $i % 3 === 1 ? '#f5f4f8' : '#0f0c18' }}; @if (! $loop->first) margin-top: -4px; @endif">
                            <summary class="flex min-h-[96px] items-center justify-between gap-4 px-5 text-[18px] font-medium lg:px-6 lg:text-[20px]"><span class="os-tab" aria-hidden="true">{{ __($item['tab']) }}</span>{{ __($item['q']) }}<span class="text-[20px]" aria-hidden="true">+</span></summary>
                            <p class="max-w-[50ch] px-6 pb-8 text-[17px] leading-relaxed">{{ __($item['a']) }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Close: the first screen, already open. Type, and the four scans answer. --}}
    <section id="indir" class="mt-32 scroll-mt-6 md:mt-48" style="background: var(--os-amber); color: var(--color-canvas)">
        <div class="mx-auto flex min-h-[90svh] max-w-6xl flex-col gap-12 px-6 py-16 lg:grid lg:grid-cols-12 lg:items-center lg:gap-6 lg:py-24">
            <div class="lg:col-span-6 lg:self-end lg:pb-4">
                <h2 class="os-big font-extrabold">{{ __('Taramaların') }}<br>{{ __('telefonunda.') }}</h2>
                <p class="mt-6 max-w-[40ch] text-[17px] leading-relaxed">{{ __('Google Play\'de aç ve ilk belgeni tara. Tarama, PDF ve metin tanıma cihazında kalır. Taramalar ekranındaki kutuya bir kelime yaz: dört örnek belge onu metninde bulur.') }}</p>
            </div>

            <div class="w-full max-w-[440px] lg:col-span-5 lg:col-start-8" data-reveal>
                <div class="os-card !w-full rounded-2xl" data-ui data-list>
                    <div class="flex items-center justify-between px-4 pt-4">
                        <p class="text-[22px] font-bold">{{ __('Taramalar') }}</p>
                        <p class="os-ui-label rounded-md bg-[#211c31] px-2 py-1">{{ __('Çevrimdışı · gizli') }}</p>
                    </div>
                    <div class="p-4">
                        <label class="os-ui-search">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="2"/></svg>
                            <input type="search" placeholder="{{ __('Taramalarının metninde ara') }}" aria-label="{{ __('Taramalarının metninde ara') }}" data-q>
                        </label>
                        <ul class="mt-3 grid gap-2" data-rows>
                            @foreach ($docs as $d => $doc)
                                <li class="os-ui-row" data-row="{{ $d }}">
                                    <img src="{{ $pic($doc['file']) }}" alt="" width="900" height="1200" loading="lazy" class="block h-16 w-12 shrink-0 object-cover object-top">
                                    <div class="min-w-0">
                                        <p class="truncate text-[13px] font-semibold">{{ $doc['title'] }}</p>
                                        <p class="os-ui-text truncate" data-snippet>{{ $excerpt($doc['text']) }}</p>
                                        <p class="os-ui-text">{{ $doc['date'] }} · {{ __('1 sayfa') }}</p>
                                    </div>
                                </li>
                            @endforeach
                            <li class="os-ui-text hidden px-2 py-3" data-empty>{{ __('Sonuç yok.') }}</li>
                        </ul>
                        <a href="{{ $app['play_store'] }}" target="_blank" rel="noopener" class="press mt-4 flex h-12 items-center justify-center rounded-xl bg-[#F5B641] text-[15px] font-semibold text-[#0f0c18] hover:bg-[#f5f4f8]">{{ __("Google Play'de aç") }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-6xl px-6 pt-10">
        <p class="max-w-[60ch] text-[15px] leading-relaxed text-ink-dim">
            {{ __('Örnek belgeler açık koleksiyonlardan; hiçbiri uygulamanın kendi taraması değildir:') }}
            <a href="https://commons.wikimedia.org/wiki/File:ReceiptSwiss.webp" class="underline underline-offset-2 hover:text-ink">ReceiptSwiss</a> (Audrius Meskauskas, <a href="https://creativecommons.org/licenses/by-sa/3.0/" class="underline underline-offset-2 hover:text-ink">CC BY-SA 3.0</a>; {{ __('sayfaya kırpılmış') }});
            <a href="https://commons.wikimedia.org/wiki/File:Typewritten_letter_of_Pierre_Chouteau,_St._Louis,_to_Miss_Mary_Louise_Dalton,_Missouri_Historical_Society,_September_5,_1903_-_DPLA_-_f7afaf7cc9d87b0cfc2d154272e31ea9.webp" class="underline underline-offset-2 hover:text-ink">Pierre Chouteau, 1903</a> (Missouri Historical Society, {{ __('kamu malı') }});
            <a href="https://commons.wikimedia.org/wiki/File:A_Very_Early_Typewritten_Letter_as_Part_of_a_Court_Case_in_the_Utah_Territory,_dated_1886.tif" class="underline underline-offset-2 hover:text-ink">Utah Territory, 1886</a> ({{ __('kamu malı') }});
            <a href="https://commons.wikimedia.org/wiki/File:Handwritten_Letter_from_T._K._Riddick,_House_of_Representatives_of_Tennessee_to_Bainbridge_Colby,_Secretary_of_State_Informing_Him_That_He_Had_Wired_the_Points_of_Order_and_the_Stat_-_DPLA_-_36b8012453b269f1bf0367114aab8ab9_(page_1).webp" class="underline underline-offset-2 hover:text-ink">T. K. Riddick, 1920</a> (NARA, {{ __('kamu malı') }});
            <a href="https://collections.museumsvictoria.com.au/items/252183" class="underline underline-offset-2 hover:text-ink">Notebook, Mastrino, c. 1920</a> (Museums Victoria, <a href="https://creativecommons.org/licenses/by/4.0/" class="underline underline-offset-2 hover:text-ink">CC BY 4.0</a>).
        </p>
    </div>
</div>

<script>
    // The first screen's search box reads the four sample scans' text, as the app reads every scan's recognised text.
    (() => {
        const root = document.querySelector('[data-os]');
        const docs = {!! $docsJson !!};
        const lang = document.documentElement.lang;
        const input = root.querySelector('[data-q]');
        const rows = [...root.querySelectorAll('[data-row]')];
        const empty = root.querySelector('[data-empty]');
        const fold = (s) => s.toLocaleLowerCase(lang);
        const esc = (s) => s.replace(/[&<>]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c]));

        const search = () => {
            const q = input.value.trim();
            let hits = 0;
            rows.forEach((row, i) => {
                const doc = docs[i];
                const snippet = row.querySelector('[data-snippet]');
                const at = q ? fold(doc.title + ' ' + doc.text).indexOf(fold(q)) : -1;
                const show = !q || at >= 0;
                row.classList.toggle('hidden', !show);
                if (!show) return;
                hits++;
                if (!q) { snippet.textContent = doc.text.slice(0, 60) + '…'; return; }
                const full = doc.title + ' ' + doc.text;
                const start = Math.max(0, at - 24);
                snippet.innerHTML = (start ? '…' : '') + esc(full.slice(start, at)) + '<mark>' + esc(full.slice(at, at + q.length)) + '</mark>' + esc(full.slice(at + q.length, at + q.length + 40)) + '…';
                snippet.classList.remove('os-reprint'); void snippet.offsetWidth; snippet.classList.add('os-reprint');
            });
            empty.classList.toggle('hidden', hits > 0);
        };
        input.addEventListener('input', search);

        // Links that open a folder also open the matching section's details card, so the drawer answers.
        root.querySelectorAll('.os-cardq').forEach((d) => {
            const sign = () => { d.querySelector('summary span:last-child').textContent = d.open ? '–' : '+'; };
            d.addEventListener('toggle', sign);
            sign();
        });
    })();
</script>
@endsection
