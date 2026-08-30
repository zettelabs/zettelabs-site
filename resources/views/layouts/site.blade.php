<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0f0c18">

        <title>@yield('title', 'Zettelabs')</title>
        <meta name="description" content="@yield('description', __('Zettelabs — mobil uygulamalar geliştiren küçük bir ekip.'))">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-canvas text-ink font-sans antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="border-b border-line">
                <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-x-4 gap-y-2 px-4 py-4 sm:px-6 sm:py-5">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg" style="background-image: linear-gradient(135deg, #ff007c, #a855f7 60%, #38bdf8);">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="4" width="16" height="4" rx="1" fill="white"/>
                                <rect x="4" y="16" width="16" height="4" rx="1" fill="white"/>
                                <polygon points="16.5,8 20,8 7.5,16 4,16" fill="white"/>
                            </svg>
                        </span>
                        <span class="text-lg font-bold tracking-tight text-ink">Zettelabs</span>
                    </a>
                    <nav class="flex items-center gap-3 text-sm sm:gap-5">
                        <a href="{{ route('home') }}#urunler" class="text-ink-dim hover:text-ink">{{ __('Uygulamalar') }}</a>
                        <a href="{{ route('privacy') }}" class="text-ink-dim hover:text-ink">{{ __('Gizlilik') }}</a>
                        <label class="relative">
                            <span class="sr-only">{{ __('Dil seçin') }}</span>
                            <select
                                onchange="location.href = this.value"
                                class="cursor-pointer appearance-none rounded-md border border-line bg-surface py-1.5 pl-3 pr-7 text-sm text-ink-dim"
                            >
                                <option value="{{ route('locale.switch', 'en') }}" @selected(app()->getLocale() === 'en')>EN</option>
                                <option value="{{ route('locale.switch', 'tr') }}" @selected(app()->getLocale() === 'tr')>TR</option>
                            </select>
                            <svg class="pointer-events-none absolute right-2 top-1/2 h-3 w-3 -translate-y-1/2 text-ink-dim" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </label>
                    </nav>
                </div>
            </header>

            <main class="flex-1">
                @yield('content')
            </main>

            <footer class="border-t border-line">
                <div class="mx-auto flex max-w-5xl flex-col gap-4 px-6 py-8 text-sm text-ink-dim sm:flex-row sm:items-center sm:justify-between">
                    <p>{{ __('© :year Zettelabs. Tüm hakları saklıdır.', ['year' => date('Y')]) }}</p>
                    <div class="flex gap-5">
                        <a href="{{ route('privacy') }}" class="hover:text-ink">{{ __('Gizlilik Politikası') }}</a>
                        <a href="mailto:zettelabs@gmail.com" class="hover:text-ink">{{ __('İletişim') }}</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
