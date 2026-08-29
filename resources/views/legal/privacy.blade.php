@extends('layouts.site')

@section('title', __('Gizlilik Politikası — Zettelabs'))
@section('description', __('Zettelabs kurumsal sitesinin ve genel iletişim kanallarının gizlilik politikası.'))

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            {{ __('Gizlilik Politikası') }}
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">{{ __('Zettelabs Gizlilik Politikası') }}</h1>
        <p class="mt-4 max-w-xl text-ink-dim">
            {{ __('Bu politika zettelabs.app kurumsal sitesini ve buradaki iletişim kanallarını kapsar. Her uygulamamızın kendi gizlilik politikası, ilgili uygulamanın kendi sayfasında yayınlanır — uygulama içi veri toplama ve kullanımı için o politikaya bakın.') }}
        </p>
        <dl class="mt-6 flex flex-wrap gap-x-8 gap-y-2 font-mono text-xs text-ink-dim">
            <div><dt class="inline text-ink">{{ __('Kapsam:') }}</dt> <dd class="inline">zettelabs.app</dd></div>
            <div><dt class="inline text-ink">{{ __('Yürürlük tarihi:') }}</dt> <dd class="inline">{{ __('29 Ağustos 2026') }}</dd></div>
        </dl>

        <section class="mt-12 scroll-mt-6">
            <h2 class="text-xl font-semibold text-ink">{{ __('1. Bu site hangi verileri toplar') }}</h2>
            <p class="mt-3 text-ink-dim">{{ __('zettelabs.app bir hesap sistemi veya form içermez. Standart web sunucu günlükleri (IP adresi, tarayıcı bilgisi, ziyaret edilen sayfa) dışında kişisel veri toplamayız. Dil tercihiniz (EN/TR), yalnızca oturumunuz süresince tarayıcınızın çerez/oturum belleğinde tutulur.') }}</p>
        </section>

        <section class="mt-10 scroll-mt-6">
            <h2 class="text-xl font-semibold text-ink">{{ __('2. Uygulamalarımızın gizlilik politikaları') }}</h2>
            <p class="mt-3 text-ink-dim">{{ __('Her mobil uygulamamızın kendi veri toplama ve kullanım politikası, o uygulamanın kendi sitesinde yayınlanır. Örneğin Fiyat Radarı için:') }}</p>
            <a href="https://thriftai.zettelabs.app/privacy-policy" class="mt-2 inline-block text-accent underline underline-offset-2 hover:text-accent-deep">thriftai.zettelabs.app/privacy-policy</a>
        </section>

        <section class="mt-10 scroll-mt-6">
            <h2 class="text-xl font-semibold text-ink">{{ __('3. İletişim') }}</h2>
            <p class="mt-3 text-ink-dim">{{ __('Bu politika veya verileriniz hakkında sorularınız için bize ulaşabilirsiniz:') }}</p>
            <a href="mailto:zettelabs@gmail.com" class="mt-1 inline-block font-medium text-accent underline underline-offset-2 hover:text-accent-deep">zettelabs@gmail.com</a>
        </section>
    </div>

@endsection
