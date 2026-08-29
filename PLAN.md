# zettelabs.app — Durum ve Karar Özeti

Yeni bir session'a başlarken önce bunu oku. Bu repo, `zettelabs.app` kök domaininin
Laravel kaynak kodu — Thrift-AI (`thriftai.zettelabs.app`) reposundan tamamen bağımsız.

## Karar özeti

- **Stack**: Laravel 13 + Blade + Tailwind v4, thriftai.zettelabs.app'teki desenle aynı
  (controller-based route'lar — closure YOK, `route:cache` kırılıyor).
- **Kimlik**: Fiyat Radarı'nın Forest/Moss/Cream'inden bilinçli olarak farklı, nötr bir
  Zettelabs kimliği — Inter + IBM Plex Mono, grafit/beyaz + indigo aksan (`resources/css/app.css`).
- **i18n**: Varsayılan EN, TR dropdown, session tabanlı (`SetLocale` middleware) — thriftai
  ile birebir aynı mekanizma. Kaynak string'ler Türkçe, çeviriler `lang/en.json`.
- **Mimari karar (kullanıcı talebi)**: Sadece Fiyat Radarı kendi subdomain'inde
  (`thriftai.zettelabs.app`) kalıyor. Diğer 5 uygulamanın **kendi marka/tanıtım sayfası**
  zettelabs.app altında route'lanıyor (`/background-wizard`, `/learn-words`, `/cleanpix`,
  `/circlepix`, `/simple-alarm`) — Play Store'a değil, önce bu sayfalara link veriyoruz.
  İçerik `config/apps.php`'de data olarak tutuluyor, tek bir `resources/views/apps/show.blade.php`
  şablonu kullanılıyor (5 ayrı blade dosyası değil).

## KRİTİK: Legacy Play Console URL'leri — DEĞİŞTİRME

`~/Downloads/zettelabsold` (eski, git dışı bir Laravel kurulumu, bu makinede local) zettelabs.app'in
önceki koduydu. O projede route'suz "ölü" görünen 4 gizlilik politikası blade dosyası vardı, ama
**Play Store'daki gerçek uygulama listelemeleri hâlâ bu tam URL'lere link veriyor** (Play Store
listeleme sayfalarından doğrulandı, browser ile kontrol edildi):

| URL (değiştirilemez) | Uygulama | Play Console applicationId |
|---|---|---|
| `/privacy_policy` | Learn Words | `com.zettelabs.learnwords` |
| `/privacy_policy_background_wizard` | Background Wizard | `background.erase.replace.change.blur.remove` |
| `/privacy_policy_photo_finder` | CleanPix (Play Store'da "Photo Finder"dan "CleanPix: Clean Duplicate Pics"e yeniden adlandırılmış, ama gizlilik URL'i eski adla kaldı) | `com.similarphotofinder.cleaner.removeduplicate` |
| `/privacy_policy_simple_alarm` | Simple Alarm | `com.alarm.simple.clock` |

Bu 4 route (`routes/web.php`'de "Legacy Play Console" yorumuyla işaretli) ve içerikleri
(`resources/views/legal/legacy.blade.php` + `legal/partials/legacy-body.blade.php`, orijinal
İngilizce "Privacy Policy Generator" metniyle **birebir aynı**, sadece uygulama adı değişiyor)
**asla silinmemeli veya URL'leri değiştirilmemeli** — Play Console'daki kayıtlı linkler kırılır,
bu da ilgili uygulamanın Play Store'da askıya alınmasına yol açabilir.

`/ads.txt` da aynı sebeple korunuyor (Google AdSense yayıncı kimliği, eski projeden aynen taşındı).

**Düzeltildi**: CirclePix, Play Console'da hâlâ Learn Words ile aynı `/privacy_policy` URL'ini
kullanıyordu (eski bir karışıklık). Site tarafında `/privacy_policy_circlepix` adında ayrı bir
route + sayfa eklendi (`config/apps.php`'deki CirclePix `privacy_url`'i buna güncellendi).
**Kullanıcının yapması gereken tek adım**: Play Console'da CirclePix uygulamasının gizlilik
politikası URL'ini `https://zettelabs.app/privacy_policy_circlepix` olarak güncellemek — bu adımı
Claude atamıyor, Play Console hesabına giriş gerektiriyor.

## Uygulama portföyü (`config/apps.php`)

Play Store'da **Zettelabs** geliştirici hesabı altında canlı 5 uygulama (developer sayfasından
doğrulandı): Learn Words, Simple Alarm, CleanPix, Background Wizard, CirclePix. Artı Fiyat Radarı
(henüz Play Store'da değil, sadece web'de — bkz. Thrift-AI reposu). Ana sayfadaki portföy grid'i
(`resources/views/home.blade.php`, `#urunler` bölümü) bu 6 uygulamayı listeliyor.

## Kapsam dışı (henüz yapılmadı)

- GitHub'da repo oluşturup push etmek — kullanıcı onayı bekleniyor.
- Plesk'te `zettelabs.app` için yeni domain/hosting kaydı açmak ve deploy etmek. Thrift-AI'deki
  deploy sorunlarını (`Thrift-AI/PLAN.md` → "Deploy (Plesk, thriftai.zettelabs.app)") tekrar
  yaşamamak için: composer.json'da PHP kısıtı zaten geniş tutuldu (`^8.3`), ama yine de sunucunun
  gerçek PHP CLI sürümü deploy öncesi kontrol edilmeli.
- Görsel/logo varlıkları — şu an sadece basit bir SVG monogram var, gerçek bir logo yok.

## Yerel geliştirme

```bash
cd ~/zettelabs-site
php artisan serve --host=127.0.0.1 --port=8001   # thriftai'nin 8000 portuyla çakışmasın diye 8001
npm run dev    # ya da npm run build
```
