<?php

// Copy for resources/views/apps/simple-alarm.blade.php; kept apart so the page owns its words.
return [
    'lead' => 'Sade, esnek ve kişiselleştirilebilir bir alarm uygulaması.',
    'play' => "Google Play'de aç",
    'privacy' => 'Gizlilik Politikası',

    'next' => 'Sonraki alarm',
    'next_fallback' => 'Hafta içi her sabah',
    'alarm_name' => 'İş',
    'time' => '06:30',

    'tab_screens' => 'Ekranlar',
    'tab_settings' => 'Ayarlar',
    'tab_morning' => 'Bir sabah',
    'tab_set' => 'Hemen kur',

    'screens_title' => 'Ekranlar',
    'screens_text' => 'Her iş kendi ekranında: alarm çalar, listelenir, kurulur; arka planını ve sesini sen seçersin.',
    'screens' => [
        ['Çalan alarm', 'Tam ekran alarm, ertele ve kaydırarak kapat', 'Tam ekran çalan alarm: deniz manzarası üzerinde 06:30 ve Ertele (10 dk) düğmesi'],
        ['Alarm listesi', 'Sıradaki alarmını ve çalmasına kalan süreyi gör', 'Alarm listesi: en üstte sonraki alarm 06:30 ve kalan süre, altında İş, Spor ve Hafta sonu alarmları'],
        ['Alarm kurma', 'Hafta içi, her gün ya da bir kez, seçim senin', 'Alarmı düzenleme ekranı: saat seçici, tekrar günleri, alarm adı, ses ve ses düzeyi'],
        ['Arka planlar', 'Çalan alarmın arkasına bir fotoğraf koy', 'Arka plan galerisi: seçili deniz fotoğrafı ve diğer fotoğraflar'],
        ['Sesler', '15 hazır ses veya kendi müziğin', 'Ses listesi: Acoustic seçili, altında diğer hazır sesler ve Tonlarım düğmesi'],
    ],

    'settings_title' => 'Ayarlar',
    'settings_shot_alt' => 'Uygulamanın Alarmı Düzenle ekranı',
    'settings' => [
        'Zamanlama' => [
            ['Hafta içi', 'Pzt–Cum', 'Tek dokunuşla beş iş günü.'],
            ['Her gün', '7 gün', 'Hafta sonu dahil her sabah.'],
            ['Bir kez', 'tek sefer', 'Yalnızca bir sabah için.'],
            ['Sonrakini atla', 'tek dokunuş', 'Programı bozmadan bir sabahı geç.'],
        ],
        'Uyanış' => [
            ['Tam ekran alarm', 'büyük saat', 'Saat ve alarmın adı ekranı kaplar.'],
            ['Ertele', '10 dk', 'Bir dokunuşla on dakika daha.'],
            ['Kaydırarak kapat', 'tek hareket', 'Yanlışlıkla kapanmaz.'],
            ['Kalan süre', 'sa. ve dk.', 'Listede her alarmın çalmasına ne kadar kaldığı.'],
        ],
        'Ses ve görünüm' => [
            ['Hazır sesler', '15', 'Acoustic’ten LostVoices’a.'],
            ['Kendi müziğin', 'Tonlarım', 'Telefonundaki bir şarkıyla uyan.'],
            ['Ses düzeyi', 'alarm başına', 'Her alarmın kendi ses düzeyi.'],
            ['Arka plan', 'fotoğraf', 'Çalan alarmın arkasındaki manzara.'],
        ],
    ],

    'morning_title' => 'Akşam kur, sabah uyan',
    'morning_text' => 'Alarmı bir kez kurarsın; hafta boyunca hangi sabah çalacağını o bilir.',
    'morning' => [
        'Pazar akşamı' => [
            ['Saati seç', '06:30'],
            ['Günleri seç', 'Pzt–Cum'],
            ['Sesi seç', 'Acoustic'],
        ],
        'Pazartesi sabahı' => [
            ['Alarm çalar', '06:30'],
            ['Ertele', '+10 dk'],
            ['Kaydır, kapat', '06:40'],
        ],
        'Cumartesi' => [
            ['İş alarmı', 'susar'],
            ['Hafta sonu alarmı', '09:00'],
        ],
    ],
    'morning_total' => ['Tek kurulum', 'beş sabah'],

    'set_title' => 'Yarını kur',
    'set_text' => "Google Play'den indir; ilk alarmını bir dakikadan kısa sürede kurarsın.",
    'dialog_title' => 'Alarmı Düzenle',
    'dialog_time' => 'Saat',
    'dialog_repeat' => 'Tekrarla',
    'dialog_name' => 'Alarm adı',
    'preset_weekdays' => 'Hafta içi',
    'preset_daily' => 'Her gün',
    'preset_once' => 'Bir kez',
    'rings_in' => 'Çalmasına',

    'more_apps' => 'Diğer uygulamalar',
    'studio' => 'Zettelabs',
    'home' => 'Ana sayfa',
    'pictures' => 'Görseller',
    'credit_photo' => 'Gün doğumu: Alexandru Panoiu, CC BY 2.0',
    'credit_video' => 'Dalgalar: Alexander Grebenkov, CC BY 3.0',

    // Countdown words, read by the page script.
    'days' => ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'],
    'unit_day' => 'gün',
    'unit_hour' => 'sa.',
    'unit_min' => 'dk.',
];
