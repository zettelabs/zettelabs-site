@extends('layouts.site')

{{-- Same text as ~/sinavsayaci/docs/gizlilik-politikasi.html; keep the two in step. Turkish only: the app is Turkey-only. --}}
@section('title', 'Sınav Sayacı Gizlilik Politikası')
@section('description', "Sınav Sayacı (YKS, LGS, KPSS geri sayım widget'ı) uygulamasının gizlilik politikası. Geliştirici: Zettelabs.")

@section('content')

    <div class="mx-auto max-w-3xl px-6 py-16 md:py-20" lang="tr">
        <span class="inline-flex items-center gap-2 rounded-full border border-line bg-accent-soft px-3 py-1 font-mono text-xs uppercase tracking-wider text-accent-deep">
            Gizlilik Politikası
        </span>
        <h1 class="mt-5 text-3xl font-semibold text-ink md:text-4xl">Sınav Sayacı Gizlilik Politikası</h1>
        <p class="mt-4 text-sm text-ink-dim">Uygulama: Sınav Sayacı (com.sayac.sinav.yks.lgs.kpss) · Geliştirici: Zettelabs · Yürürlük: 11 Kasım 2026 · 0.1.0 ve sonrası sürümler için geçerlidir</p>

        <p class="mt-8 text-ink-dim">Bu politika, Sınav Sayacı'nın hangi bilgileri işlediğini, neden işlediğini ve elinizdeki seçenekleri açıklar. Uygulama hesap gerektirmez; adınızı, e-posta adresinizi, telefon numaranızı veya rehberinizi istemez.</p>

        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">1. Verileriniz cihazınızda kalır</h2>
<p class="mt-3 text-ink-dim">Seçtiğiniz sınavlar, kendi eklediğiniz sınavlar, düzelttiğiniz tarihler, deneme netleriniz, günlük hedefiniz ve çalışma seriniz yalnızca telefonunuzdaki uygulamaya ait özel depolamada tutulur. Bunlar bize veya üçüncü bir tarafa <strong class="text-ink">gönderilmez</strong>. Sınav takvimi uygulamanın içinde gelir; internetten indirilmez.</p>
<p class="mt-3 text-ink-dim">Duvar kâğıdı veya paylaşma özelliğini kullandığınızda oluşturulan görsel, seçtiğiniz uygulamaya (ör. mesajlaşma uygulaması) verilir; o andan sonra o uygulamanın politikası geçerlidir.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">2. İzinler</h2>
<div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
<thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">İzin</th><th class="p-2 font-semibold">Neden</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
<tr><td>Bildirimler</td><td>İsteğe bağlı sabah hatırlatması ("sınava X gün kaldı", başvuru ve sonuç tarihleri). Kapalı gelir; açarsanız izin istenir.</td></tr>
<tr><td>Alarmlar ve hatırlatıcılar (tam alarm)</td><td>Widget'ın gece yarısı gün değişiminde tam saatinde güncellenmesi için.</td></tr>
<tr><td>Açılışta başlatma</td><td>Telefon yeniden başlayınca widget'ı ve alarmı yeniden kurmak için.</td></tr>
<tr><td>Duvar kâğıdı ayarlama</td><td>Yalnızca siz "Ana ekran" veya "Kilit ekranı" dediğinizde geri sayım görselini duvar kâğıdı yapmak için.</td></tr>
<tr><td>İnternet</td><td>Reklamları, uygulama ayarlarını ve çökme raporlarını yüklemek için (aşağıya bakın). Netleriniz ve hedefleriniz gönderilmez.</td></tr>
</tbody></table></div>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">3. Üçüncü taraf hizmetlerin topladığı bilgiler</h2>
<p class="mt-3 text-ink-dim">Sınav Sayacı ücretsizdir ve reklamlarla desteklenir. Widget'larda reklam yoktur. Aşağıdaki Google hizmetleri cihazınızdan otomatik olarak bilgi toplayabilir:</p>
<div class="mt-3 overflow-x-auto"><table class="w-full border-collapse text-left text-sm text-ink-dim">
<thead><tr class="border-b border-line text-ink"><th class="p-2 font-semibold">Hizmet</th><th class="p-2 font-semibold">Amaç</th><th class="p-2 font-semibold">Toplanabilecek veriler</th></tr></thead><tbody class="[&_td]:border-b [&_td]:border-line [&_td]:p-2 [&_td]:align-top">
<tr><td>Google AdMob</td><td>Reklam gösterme (banner, tam ekran, ödüllü ve yerel reklamlar)</td><td>Reklam kimliği, IP adresi, cihaz ve uygulama bilgileri, reklam etkileşimleri</td></tr>
<tr><td>Google User Messaging Platform</td><td>Gereken bölgelerde reklam onayınızı almak ve saklamak</td><td>Onay tercihleriniz, cihaz bilgileri</td></tr>
<tr><td>Firebase Analytics</td><td>Uygulamanın nasıl kullanıldığını anlamak</td><td>Kullanım olayları, uygulama örnek kimliği, cihaz ve uygulama bilgileri, IP'den türetilen yaklaşık konum</td></tr>
<tr><td>Firebase Crashlytics</td><td>Çökmeleri teşhis etmek</td><td>Çökme kayıtları, çökme anındaki cihaz durumu, uygulama örnek kimliği</td></tr>
<tr><td>Firebase Remote Config</td><td>Reklam sıklığı gibi ayarları güncelleme olmadan değiştirmek</td><td>Uygulama örnek kimliği, cihaz ve uygulama bilgileri</td></tr>
</tbody></table></div>
<p class="mt-3 text-ink-dim">Bu hizmetler kendi politikalarına tabidir: <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/privacy">Google Gizlilik Politikası</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://policies.google.com/technologies/partner-sites">Google'ın uygulamalardan elde ettiği bilgileri kullanımı</a>, <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="https://firebase.google.com/support/privacy">Firebase gizlilik bilgileri</a>. Kişisel bilgilerinizi satmayız. Veriler şifreli bağlantı (HTTPS) ile iletilir.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">4. Seçenekleriniz</h2>
<ul class="mt-3 list-disc space-y-2 pl-6 text-ink-dim">
<li><strong class="text-ink">Reklam onayı:</strong> Avrupa Ekonomik Alanı, Birleşik Krallık, İsviçre veya onay gereken başka bir bölgedeyseniz, kişiselleştirilmiş reklam göstermeden önce onayınız istenir.</li>
<li><strong class="text-ink">Reklam kimliği:</strong> Android Ayarlar › Gizlilik › Reklamlar bölümünden reklam kimliğinizi sıfırlayabilir veya silebilirsiniz.</li>
<li><strong class="text-ink">Verileri silme:</strong> Uygulamadaki netleri tek tek silebilirsiniz. Uygulamanın depolamasını temizlemek veya uygulamayı kaldırmak cihazdaki tüm verileri siler. Uygulama örneğinize bağlı analiz verisinin silinmesini istemek için aşağıdaki adrese yazın.</li>
</ul>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">5. Saklama süresi</h2>
<p class="mt-3 text-ink-dim">Verileriniz siz silene, depolamayı temizleyene veya uygulamayı kaldırana kadar cihazınızda kalır. Firebase Analytics verileri en fazla 14 ay, Crashlytics çökme verileri en fazla 90 gün saklanır. Reklam verileri Google'ın politikalarına göre saklanır.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">6. Çocuklar</h2>
<p class="mt-3 text-ink-dim">Sınav Sayacı 13 yaşından küçük çocuklara yönelik değildir ve onlardan bilerek kişisel bilgi toplamayız. Uygulama, sınava hazırlanan ortaokul (LGS) ve lise öğrencilerinin de kullanabileceği genel bir araçtır; reklam onayı ve kişiselleştirme tercihleri yukarıdaki gibi uygulanır. Bir çocuğun uygulama üzerinden bilgi verdiğini düşünüyorsanız bizimle iletişime geçin; silme için gerekeni yaparız.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">7. Haklarınız</h2>
<p class="mt-3 text-ink-dim">Yaşadığınız yere göre (ör. KVKK, GDPR, UK GDPR, CCPA) kişisel verilerinize erişme, düzeltme, silme, işlenmesine itiraz etme ve onayı geri çekme haklarına sahip olabilirsiniz. Hesap veya verilerinizin kendisi bizde tutulmadığı için çoğu veri yukarıdaki Google hizmetlerindedir; her talepte size yardımcı oluruz.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">8. Takvim ve resmî kaynaklar</h2>
<p class="mt-3 text-ink-dim">Sınav tarihleri ÖSYM ve MEB'in yayımladığı 2027 sınav takvimlerinden alınmıştır. Uygulamanın ÖSYM, MEB veya herhangi bir kamu kurumuyla bağlantısı yoktur; resmî duyuruları kurumların sitelerinden kontrol edin.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">9. Değişiklikler</h2>
<p class="mt-3 text-ink-dim">Uygulama değiştikçe bu politikayı güncelleyebiliriz. Yeni sürüm bu sayfada yeni yürürlük tarihiyle yayımlanır.</p>
        </section>
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-ink">10. İletişim</h2>
<p class="mt-3 text-ink-dim">Zettelabs — <a class="text-accent underline underline-offset-2 hover:text-accent-deep" href="mailto:zettelabs@gmail.com">zettelabs@gmail.com</a></p>
        </section>
    </div>

@endsection
