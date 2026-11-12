<?php

return [

    'background-wizard' => [
        'name' => 'Background Wizard',
        'tagline' => 'Fotoğraflardan arka planı kaldırın, değiştirin ya da bulanıklaştırın.',
        'description' => 'Yapay zekâ destekli otomatik arka plan kaldırma, hazır arka planlarla değiştirme ve profesyonel bulanıklaştırma efektleri — hepsi tek uygulamada.',
        'features' => [
            'Yapay zekâ ile otomatik arka plan kaldırma',
            'Doğa, şehir, düz renk gibi hazır arka planlarla değiştirme',
            'Profesyonel görünüm için arka plan bulanıklaştırma',
            'Şeffaf arka planlı PNG kesimler',
            'Vesikalık ve pasaport fotoğrafı: dört boyut, düz arka plan, 10×15 cm ya da A4 baskı sayfası',
            'Amaç odaklı ana ekran: “Ne için kullanacaksın?” sorusuyla ürün fotoğrafı, evcil hayvan, profil fotoğrafı ya da vesikalık seç',
            'Ürün fotoğrafı modu: beyaz, açık gri, krem, mermer ya da şeffaf arka plan, açılıp kapanan gölge ve elle kenar düzeltme',
            'Gideceği yere göre boyut: pazar yeri için 2000 px 1:1, 9:16 hikâye, şeffaf PNG ya da orijinal boyut',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=background.erase.replace.change.blur.remove',
        'privacy_url' => 'https://backgroundmagic-beb46.web.app/privacy-policy',
        'icon' => 'icon-background-wizard.webp?v=2',
        'screenshots' => ['shot-background-wizard-1.webp', 'shot-background-wizard-2.webp', 'shot-background-wizard-3.webp', 'shot-background-wizard-4.webp', 'shot-background-wizard-5.webp', 'shot-background-wizard-6.webp'],
    ],

    'cleanpix' => [
        'name' => 'CleanPix',
        'tagline' => 'Tekrarlayan ve birbirine benzeyen fotoğrafları bulup telefonunda yer aç.',
        'description' => 'CleanPix, cihazındaki yinelenen ya da birbirine çok benzeyen fotoğrafları tarar; hangisini sileceğine sen karar verirsin.',
        'features' => [
            'Hızlı tarama algoritması',
            'Eski ekran görüntülerini ve büyük videoları temizle: Depolama dökümü 90 günden eski ekran görüntülerini ve 100 MB ve üzeri videoları bulur, birkaç dokunuşla yer açarsın.',
            'Silme kararı tamamen sende',
            'Fotoğraflar cihazından hiç çıkmaz',
            'Sade, kolay arayüz',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.similarphotofinder.cleaner.removeduplicate',
        'privacy_url' => 'https://similiar-finder.web.app/privacy-policy',
        'icon' => 'icon-cleanpix.webp?v=2',
        'screenshots' => ['shot-cleanpix-1.webp', 'shot-cleanpix-2.webp', 'shot-cleanpix-3.webp', 'shot-cleanpix-4.webp', 'shot-cleanpix-5.webp', 'shot-cleanpix-6.webp', 'shot-cleanpix-7.webp'],
        // The page's sample scan: real look-alike sequences from Wikimedia Commons (images/apps/cleanpix-roll/).
        // `mb` is each original file's size on Commons; `source` is its Commons file title.
        'roll' => [
            ['name' => 'Gün batımında palmiyeler', 'author' => 'John Robert McPherson', 'licence' => 'CC0', 'frames' => [
                ['file' => 'cleanpix-sunset-1715.webp', 'mb' => 3.92, 'source' => 'Sunset clouds and palms, 1-47 Philippine Pde Palm Beach IMGP1715.jpg'],
                ['file' => 'cleanpix-sunset-1717.webp', 'mb' => 4.00, 'source' => 'Sunset clouds and palms, 1-47 Philippine Pde Palm Beach IMGP1717.jpg'],
                ['file' => 'cleanpix-sunset-1719.webp', 'mb' => 3.97, 'source' => 'Sunset clouds and palms, 1-47 Philippine Pde Palm Beach IMGP1719.jpg'],
                ['file' => 'cleanpix-sunset-1721.webp', 'mb' => 3.76, 'source' => 'Sunset clouds and palms, 1-47 Philippine Pde Palm Beach IMGP1721.jpg'],
            ]],
            ['name' => 'Akşam göğünde Venüs ve Jüpiter', 'author' => 'John Robert McPherson', 'licence' => 'CC0', 'frames' => [
                ['file' => 'cleanpix-venus-1020462.webp', 'mb' => 9.72, 'source' => 'Conjunction of Venus and Jupiter at sunset 44 Philippine Pde Palm Beach L1020462.jpg'],
                ['file' => 'cleanpix-venus-1020466.webp', 'mb' => 9.70, 'source' => 'Conjunction of Venus and Jupiter at sunset 44 Philippine Pde Palm Beach L1020466.jpg'],
                ['file' => 'cleanpix-venus-1020467.webp', 'mb' => 8.40, 'source' => 'Conjunction of Venus and Jupiter at sunset 44 Philippine Pde Palm Beach L1020467.jpg'],
                ['file' => 'cleanpix-venus-1020469.webp', 'mb' => 10.11, 'source' => 'Conjunction of Venus and Jupiter at sunset 44 Philippine Pde Palm Beach L1020469.jpg'],
            ]],
            ['name' => 'Salon ve yemek odası', 'author' => 'John Robert McPherson', 'licence' => 'CC BY-SA 4.0', 'frames' => [
                ['file' => 'cleanpix-lounge-1080987.webp', 'mb' => 10.55, 'source' => 'Lounge and dining room 47 Philippine Pde Palm Beach P1080987.jpg'],
                ['file' => 'cleanpix-lounge-1080988.webp', 'mb' => 11.82, 'source' => 'Lounge and dining room 47 Philippine Pde Palm Beach P1080988.jpg'],
                ['file' => 'cleanpix-lounge-1080989.webp', 'mb' => 15.21, 'source' => 'Lounge and dining room 47 Philippine Pde Palm Beach P1080989.jpg'],
                ['file' => 'cleanpix-lounge-1080990.webp', 'mb' => 14.23, 'source' => 'Lounge and dining room 47 Philippine Pde Palm Beach P1080990.jpg'],
            ]],
            ['name' => 'Lagün, Palm Beach', 'author' => 'John Robert McPherson', 'licence' => 'CC BY-SA 4.0', 'frames' => [
                ['file' => 'cleanpix-lagoon-0126.webp', 'mb' => 3.59, 'source' => 'Lagoon, Palm Beach, Gold Coast IMGP0126.jpg'],
                ['file' => 'cleanpix-lagoon-0127.webp', 'mb' => 3.32, 'source' => 'Lagoon, Palm Beach, Gold Coast IMGP0127.jpg'],
                ['file' => 'cleanpix-lagoon-0128.webp', 'mb' => 2.85, 'source' => 'Lagoon, Palm Beach, Gold Coast IMGP0128.jpg'],
                ['file' => 'cleanpix-lagoon-0129.webp', 'mb' => 2.56, 'source' => 'Lagoon, Palm Beach, Gold Coast IMGP0129.jpg'],
            ]],
            ['name' => 'Ağaç siluetleri, Salk Oval', 'author' => 'John Robert McPherson', 'licence' => 'CC BY-SA 4.0', 'frames' => [
                ['file' => 'cleanpix-roadside-1577.webp', 'mb' => 9.36, 'source' => 'Roadside vegetation in silhouette Salk Oval Sarawak Ave Palm Beach IMGP1577.jpg'],
                ['file' => 'cleanpix-roadside-1578.webp', 'mb' => 9.84, 'source' => 'Roadside vegetation in silhouette Salk Oval Sarawak Ave Palm Beach IMGP1578.jpg'],
                ['file' => 'cleanpix-roadside-1579.webp', 'mb' => 11.57, 'source' => 'Roadside vegetation in silhouette Salk Oval Sarawak Ave Palm Beach IMGP1579.jpg'],
            ]],
            ['name' => 'Currumbin Kayası', 'author' => 'John Robert McPherson', 'licence' => 'CC BY-SA 4.0', 'frames' => [
                ['file' => 'cleanpix-currumbin-0047-7.webp', 'mb' => 11.86, 'source' => 'Currumbin Rock from Palm Beach Surf Life Saving Club Jefferson Lane Palm Beach Gold Coast Queensland IMG 0047 (7).jpg'],
                ['file' => 'cleanpix-currumbin-0047-8.webp', 'mb' => 19.42, 'source' => 'Currumbin Rock from Palm Beach Surf Life Saving Club Jefferson Lane Palm Beach Gold Coast Queensland IMG 0047 (8).jpg'],
            ]],
            ['name' => 'Gün batımı bulutları', 'author' => 'John Robert McPherson', 'licence' => 'CC0', 'frames' => [
                ['file' => 'cleanpix-clouds-9792.webp', 'mb' => 1.69, 'source' => 'Sunset clouds, Philippine Pde Palm Beach IMGP9792.jpg'],
                ['file' => 'cleanpix-clouds-9793.webp', 'mb' => 1.78, 'source' => 'Sunset clouds, Philippine Pde Palm Beach IMGP9793.jpg'],
            ]],
            ['name' => 'Uyuyan kedi, Nikkō Tōshō-gū', 'author' => 'Fg2', 'licence' => 'public domain', 'frames' => [
                ['file' => 'cleanpix-cat-3972.webp', 'mb' => 0.73, 'source' => 'Toshogu-Sleeping-Cat-Dsc3972.jpg'],
                ['file' => 'cleanpix-cat-33988.webp', 'mb' => 0.52, 'source' => 'Toshogu-Sleeping-Cat-Dsc33988.jpg'],
            ]],
        ],
    ],

    'circlepix' => [
        'name' => 'CirclePix',
        'tagline' => 'Yapay zekâ ile saniyeler içinde şeffaf arka planlı profil fotoğrafı üret.',
        'description' => 'CirclePix, arka planı otomatik temizler; renkli çerçeveler ve neon efektlerle profil fotoğrafını öne çıkarır.',
        'features' => [
            'Yapay zekâ ile otomatik arka plan temizleme',
            'Renkli çerçeve ve neon efektler',
            'Daire, kare, yuvarlak köşeli kare ya da altıgen çerçeve şekli',
            'WhatsApp, Instagram, LinkedIn, Discord, Telegram, Slack ve Steam için boyut rehberi',
            'Boyut kanıtı: avatarın 48, 32 ve 24 dp\'de koyu ve açık satırlarda, kaydetmeden önce sohbet listelerindeki küçük hâlini gör',
            'LinkedIn, WhatsApp ve benzeri platformlar için ideal',
            'Hızlı kaydet ve paylaş',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.remove.background.change.photo',
        'privacy_url' => 'https://circlepix-3db60.web.app/privacy-policy',
        'icon' => 'icon-circlepix.webp?v=2',
        'screenshots' => ['shot-circlepix-1.webp', 'shot-circlepix-2.webp', 'shot-circlepix-3.webp', 'shot-circlepix-4.webp', 'shot-circlepix-5.webp', 'shot-circlepix-6.webp', 'shot-circlepix-7.webp', 'shot-circlepix-8.webp'],
    ],

    'simple-alarm' => [
        'name' => 'Simple Alarm',
        'tagline' => 'Sade, esnek ve kişiselleştirilebilir bir alarm uygulaması.',
        'description' => 'Simple Alarm, özelleştirilebilir arka planlar ve haftanın günlerine göre esnek programlarla sabahlarını kolaylaştırır.',
        'features' => [
            'Uyanma görevleri: QR/barkod tarama, matematik, sallama, kod yazma',
            'Uyanma kontrolü: cevap yoksa alarm yeniden çalar',
            'Erteleme sınırı: 1, 2, 3 ya da sınırsız',
            'Saniyeler içinde alarm: saati kaydır, günleri seç, bitti',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.alarm.simple.clock',
        'privacy_url' => 'https://simple-alarm-79b72.web.app/privacy-policy',
        'icon' => 'icon-simple-alarm.webp?v=2',
        'screenshots' => ['shot-simple-alarm-1.webp', 'shot-simple-alarm-2.webp', 'shot-simple-alarm-3.webp', 'shot-simple-alarm-4.webp', 'shot-simple-alarm-5.webp'],
    ],

    'offlinescanner' => [
        'name' => 'Offline Scanner',
        'tagline' => 'Belgeleri kamerayla tara; telefonunda PDF\'e ve aranabilir metne dönüştür.',
        'description' => 'Offline Scanner belgeleri, fişleri ve notları kamerayla tarar; telefonunda çok sayfalı PDF\'e ve aranabilir metne dönüştürür. Hesap yok, bulut yok.',
        'features' => [
            'Kamerayla tara ya da galerinden içe aktar',
            'Otomatik kenar bulma ve perspektif düzeltme',
            'Tek seferde çok sayfalı PDF',
            'Cihaz-içi OCR: her sayfadan metin çıkar (Latin alfabesi kullanan diller: Türkçe, İngilizce, İspanyolca, Portekizce, Almanca, Endonezce vb.)',
            'Tüm taramalarının metninde tek yerden arama',
            'PDF\'i ya da metni paylaş, metni kopyala',
            'Belgelerin telefonundan çıkmaz: tarama, PDF oluşturma ve metin tanıma cihazında yapılır. Yalnızca reklamlar internet kullanır.',
            'Tarayıcı modülü ilk kullanımda Google Play hizmetleri üzerinden bir kez indirilir (yaklaşık 200 KB); sonrası tamamen çevrimdışı çalışır.',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.scanner.offline.pdf.ocr',
        'privacy_url' => '/offlinescanner/privacy',
        'icon' => 'icon-offlinescanner.webp',
        'screenshots' => ['shot-offlinescanner-1.webp', 'shot-offlinescanner-2.webp', 'shot-offlinescanner-3.webp', 'shot-offlinescanner-4.webp'],
    ],

    // Not on Play yet: play_store stays null and the page shows "Yakında" until it is set.
    'skydesk' => [
        'name' => 'Skydesk',
        'tagline' => 'Her ders veya iş seansını bir uçuşa çevir.',
        'description' => 'Skydesk, tamamen çevrimdışı çalışan bir odak zamanlayıcıdır: rotanı seç, uçağa bin ve uçak yere inene kadar odakta kal. Hesap yok, kayıt yok.',
        'features' => [
            'Kalkış ve varış havalimanını seç; rotanın uçuş süresi odak seansın olur. İstersen hazır süreler ya da özel kaydırıcı',
            'Uçağının dünya haritasında ilerleyişini, büyük geri sayımı, uçtuğun ve kalan kilometreyi izle',
            'Ekran kapalıyken de çalışır, bildirimde geri sayım görünür; uygulamayı kapatsan bile zamanında iner',
            'İsteğe bağlı kabin sesi: dikkat dağıtan sesleri örten yumuşak kabin uğultusu (kahverengi gürültü)',
            'İsteğe bağlı Rahatsız Etme modu uçuş boyunca açık kalır, indiğinde eski haline döner',
            'Pasaport: indiğin her şehir için damga, ayrıca ülkeler ve rozetler',
            'Günlük seri, bu haftanın odak grafiği ve toplam uçuş, saat ve kilometreyle uçuş defteri',
            'Hesap yok, kayıt yok: her şey çevrimdışı çalışır, verilerin cihazında kalır. Uçuş sırasında reklam yok.',
        ],
        'play_store' => null,
        'privacy_url' => '/skydesk/privacy',
        'icon' => 'icon-skydesk.webp',
        'screenshots' => ['shot-skydesk-1.webp', 'shot-skydesk-2.webp', 'shot-skydesk-3.webp', 'shot-skydesk-4.webp'],
    ],

    // Not on Play yet: play_store stays null and the page shows "Yakında" until it is set.
    'countdown' => [
        'name' => 'Countdown Widget',
        'tagline' => 'Kaç gün kaldı? Düğün, tatil, doğum günü için ana ekranda gün sayacı widget\'ı.',
        'description' => 'Geri sayım widget\'ı ve gün sayacı: düğüne, tatile, doğum gününe ya da istediğin tarihe kaç gün kaldığını ana ekranında gör. Üzerinden kaç gün geçti de hesaplar.',
        'features' => [
            'Sınırsız sayaç: gelecek tarih için kaç gün kaldı, geçmiş tarih için kaç gün oldu',
            'Doğum günü ve yıl dönümü için her yıl tekrar',
            'Üç boyutta ana ekran widget\'ı: 2x1, 2x2 ve ilerleme çubuklu 4x2',
            'Hazır şablonlar: düğün, tatil, doğum günü, doğum tarihi (bebek), terhis, kaç gün oldu, yıl dönümü, emeklilik, yılbaşı ve Noel',
            'Hatırlatıcılar: 100, 30, 7 ve 1 gün kala ve o gün. "Kaç gün oldu" sayaçlarında 7, 30, 100 ve 365. gün',
            '6 ücretsiz renk; bir reklam izleyerek 4 ek rengi ve fotoğraf arka planını kalıcı olarak aç',
            'Her sayacı resim olarak paylaş',
            'Hesap açmak ya da üye olmak yok. İnternetsiz çalışır, sayaçların cihazında kalır.',
        ],
        'play_store' => null,
        'privacy_url' => 'https://zettelabs-countdown.web.app/privacy-policy',
        'icon' => 'icon-countdown.webp',
        'screenshots' => ['shot-countdown-1.webp', 'shot-countdown-2.webp', 'shot-countdown-3.webp', 'shot-countdown-4.webp'],
    ],

];
