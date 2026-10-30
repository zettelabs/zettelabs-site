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
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=background.erase.replace.change.blur.remove',
        'privacy_url' => 'https://backgroundmagic-beb46.web.app/privacy-policy',
        'icon' => 'icon-background-wizard.webp?v=2',
        'screenshots' => ['shot-background-wizard-1.webp', 'shot-background-wizard-2.webp', 'shot-background-wizard-3.webp', 'shot-background-wizard-4.webp', 'shot-background-wizard-5.webp'],
    ],

    'cleanpix' => [
        'name' => 'CleanPix',
        'tagline' => 'Tekrarlayan ve birbirine benzeyen fotoğrafları bulup telefonunda yer aç.',
        'description' => 'CleanPix, cihazındaki yinelenen ya da birbirine çok benzeyen fotoğrafları tarar; hangisini sileceğine sen karar verirsin.',
        'features' => [
            'Hızlı tarama algoritması',
            'Silme kararı tamamen sende',
            'Fotoğraflar cihazından hiç çıkmaz',
            'Sade, kolay arayüz',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.similarphotofinder.cleaner.removeduplicate',
        'privacy_url' => 'https://similiar-finder.web.app/privacy-policy',
        'icon' => 'icon-cleanpix.webp?v=2',
        'screenshots' => ['shot-cleanpix-1.webp', 'shot-cleanpix-2.webp', 'shot-cleanpix-3.webp', 'shot-cleanpix-4.webp', 'shot-cleanpix-5.webp', 'shot-cleanpix-6.webp'],
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
            'LinkedIn, WhatsApp ve benzeri platformlar için ideal',
            'Hızlı kaydet ve paylaş',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.remove.background.change.photo',
        'privacy_url' => 'https://circlepix-3db60.web.app/privacy-policy',
        'icon' => 'icon-circlepix.webp?v=2',
        'screenshots' => ['shot-circlepix-1.webp', 'shot-circlepix-2.webp', 'shot-circlepix-3.webp', 'shot-circlepix-4.webp', 'shot-circlepix-5.webp', 'shot-circlepix-6.webp'],
    ],

    'simple-alarm' => [
        'name' => 'Simple Alarm',
        'tagline' => 'Sade, esnek ve kişiselleştirilebilir bir alarm uygulaması.',
        'description' => 'Simple Alarm, özelleştirilebilir arka planlar ve haftanın günlerine göre esnek programlarla sabahlarını kolaylaştırır.',
        'features' => [
            'Özelleştirilebilir alarm arka planları',
            'Haftanın günlerine göre esnek programlama',
            'Kişisel uyanma melodileri',
            'Sade, kullanıcı dostu arayüz',
        ],
        'play_store' => 'https://play.google.com/store/apps/details?id=com.alarm.simple.clock',
        'privacy_url' => 'https://simple-alarm-79b72.web.app/privacy-policy',
        'icon' => 'icon-simple-alarm.webp?v=2',
        'screenshots' => ['shot-simple-alarm-1.webp', 'shot-simple-alarm-2.webp', 'shot-simple-alarm-3.webp', 'shot-simple-alarm-4.webp', 'shot-simple-alarm-5.webp'],
    ],

];
