@extends('layouts.site')

@section('title', __('Kullanım Şartları — Zettelabs'))
@section('description', __('Zettelabs sitesinin ve mobil uygulamalarının kullanım şartları.'))

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            {{ __('Kullanım Şartları') }}
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">{{ __('Zettelabs Kullanım Şartları') }}</h1>
        <p class="mt-4 max-w-xl text-ink-dim">
            {{ __('Bu şartlar zettelabs.app sitesini ve Zettelabs tarafından Google Play’de yayınlanan mobil uygulamaları kapsar. Siteyi ya da uygulamaları kullanarak bu şartları kabul etmiş olursunuz.') }}
        </p>
        <dl class="mt-6 flex flex-wrap gap-x-8 gap-y-2 font-mono text-xs text-ink-dim">
            <div><dt class="inline text-ink">{{ __('Yürürlük tarihi:') }}</dt> <dd class="inline">{{ __('1 Kasım 2026') }}</dd></div>
        </dl>

        @foreach ([
            ['1. Uygulamaların kullanımı', 'Uygulamalarımız kişisel ve ticari olmayan kullanım için sunulur. Uygulamaları tersine mühendislikle çözmemeyi, kopyalayıp yeniden dağıtmamayı ve hukuka aykırı amaçlarla kullanmamayı kabul edersiniz. Google Play’in kendi kullanım şartları da geçerlidir.'],
            ['2. Reklamlar', 'Uygulamalarımız ücretsizdir ve reklamlarla desteklenir. Reklamlar Google AdMob üzerinden gösterilir; hangi verilerin toplandığı her uygulamanın gizlilik politikasında açıklanmıştır.'],
            ['3. Fotoğraflarınız ve içerikleriniz', 'Fotoğraflarınızın ve oluşturduğunuz içeriklerin hakları size aittir. Fotoğraflar cihazınızda işlenir, bize gönderilmez. İşlediğiniz içerik üzerinde gerekli haklara sahip olmak sizin sorumluluğunuzdadır.'],
            ['4. Garanti reddi', 'Uygulamalar ve site “olduğu gibi” sunulur. Kesintisiz ya da hatasız çalışacağına dair garanti vermeyiz. Silme işlemi yapan uygulamalarda (ör. CleanPix) önemli fotoğraflarınızı silmeden önce yedeklemenizi öneririz.'],
            ['5. Sorumluluğun sınırı', 'Yasaların izin verdiği ölçüde Zettelabs, uygulamaların ya da sitenin kullanımından doğan dolaylı zararlardan, veri veya alarm kaybından sorumlu tutulamaz. Alarm gibi zamana duyarlı işlevlerde cihazınızın ayarları ve sistem kısıtlamaları sonucu etkileyebilir.'],
            ['6. Değişiklikler', 'Bu şartları zaman zaman güncelleyebiliriz. Güncel sürüm her zaman bu sayfada yayınlanır; yürürlük tarihi değişir.'],
        ] as [$heading, $text])
            <section class="mt-10 scroll-mt-6">
                <h2 class="text-xl font-semibold text-ink">{{ __($heading) }}</h2>
                <p class="mt-3 text-ink-dim">{{ __($text) }}</p>
            </section>
        @endforeach

        <section class="mt-10 scroll-mt-6">
            <h2 class="text-xl font-semibold text-ink">{{ __('7. İletişim') }}</h2>
            <p class="mt-3 text-ink-dim">{{ __('Bu şartlar hakkında sorularınız için:') }}</p>
            <a href="mailto:zettelabs@gmail.com" class="mt-1 inline-block font-medium text-accent underline underline-offset-2 transition-colors hover:text-accent-deep">zettelabs@gmail.com</a>
        </section>
    </div>

@endsection
