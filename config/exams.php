<?php

// Turkish "<sınav> kaç gün kaldı" SEO pages (/yks-kac-gun-kaldi …), funnelling to /sinavsayaci.
// Dates match ~/sinavsayaci/app/src/main/assets/exams.json. Times are Türkiye time (UTC+3).
// When ÖSYM/MEB publish the next calendar (ÖSYM: each October), update `sessions`, `source` and `checked`.
// `estimated => true` shows "tahmini" on the page: use it for any date not in an official calendar.

$osym = 'ÖSYM 2027 Yılı Sınav Takvimi (dokuman.osym.gov.tr/web/2026/10/osym-2027-yili-sinav-takvimi-7d09wi-28090734.pdf)';

return [

    'yks' => [
        'name' => 'YKS',
        'to' => "YKS'ye",
        'full' => 'Yükseköğretim Kurumları Sınavı',
        'about' => "YKS, üniversiteye girişte ÖSYM'nin yaptığı sınavdır. 1. oturum TYT (Temel Yeterlilik Testi) herkes içindir; 2. oturum AYT (Alan Yeterlilik Testleri) sayısal, eşit ağırlık ve sözel; 3. oturum YDT (Yabancı Dil Testi) dil puanı isteyenler içindir. 2027 YKS başvuruları 4 Şubat – 2 Mart 2027, sonuçlar 21 Temmuz 2027'de.",
        'sessions' => [
            'TYT (1. oturum)' => '2027-06-19 10:15',
            'AYT (2. oturum)' => '2027-06-20 10:15',
            'YDT (3. oturum)' => '2027-06-20 15:45',
        ],
        'estimated' => false,
        'source' => $osym,
        'checked' => '2026-11-13',
    ],

    'lgs' => [
        'name' => 'LGS',
        'to' => "LGS'ye",
        'full' => 'Ortaöğretim Kurumlarına İlişkin Merkezî Sınav',
        'about' => "LGS, 8. sınıf öğrencilerinin fen, sosyal bilimler ve Anadolu liselerine yerleşmek için girdiği, MEB'in yaptığı merkezî sınavdır. Sözel ve sayısal olmak üzere iki oturumda, aynı gün yapılır.",
        'sessions' => [
            'LGS (sözel ve sayısal oturumlar)' => '2027-06-13 09:30',
        ],
        'estimated' => false,
        'source' => 'MEB 2027 Yılı Sınav Uygulama Takvimi (meb.gov.tr)',
        'checked' => '2026-11-13',
    ],

    'kpss' => [
        'name' => 'KPSS',
        'to' => "KPSS'ye",
        'full' => 'Kamu Personel Seçme Sınavı',
        'about' => "KPSS, kamuda memur ve uzman yardımcısı alımları için ÖSYM'nin yaptığı sınavdır. ÖSYM'nin 2027 takviminde KPSS A Grubu var: Genel Yetenek-Genel Kültür 12 Eylül, Alan Bilgisi 18-19 Eylül 2027. Başvurular 8-19 Temmuz 2027, sonuçlar 13 Ekim 2027'de. KPSS Lisans (B grubu), Ön Lisans ve Ortaöğretim oturumları 2027 takviminde yer almıyor.",
        'sessions' => [
            'KPSS A Grubu · Genel Yetenek-Genel Kültür' => '2027-09-12 10:15',
            'KPSS A Grubu · Alan Bilgisi 1. gün' => '2027-09-18 10:15',
            'KPSS A Grubu · Alan Bilgisi 2. gün' => '2027-09-19 10:15',
        ],
        'estimated' => false,
        'source' => $osym,
        'checked' => '2026-11-13',
    ],

    'ales' => [
        'name' => 'ALES',
        'to' => "ALES'e",
        'full' => 'Akademik Personel ve Lisansüstü Eğitimi Giriş Sınavı',
        'about' => "ALES, yüksek lisans ve doktora başvurularında ve araştırma görevlisi alımlarında istenen, sayısal ve sözel testlerden oluşan ÖSYM sınavıdır. 2027'de üç kez yapılır; sayaç sıradaki ALES'e kalan süreyi gösterir.",
        'sessions' => [
            '2027-ALES/1' => '2027-04-18 10:15',
            '2027-ALES/2' => '2027-07-11 10:15',
            '2027-ALES/3' => '2027-11-28 10:15',
        ],
        'estimated' => false,
        'source' => $osym,
        'checked' => '2026-11-13',
    ],

    'dgs' => [
        'name' => 'DGS',
        'to' => "DGS'ye",
        'full' => 'Dikey Geçiş Sınavı',
        'about' => "DGS, ön lisans mezunlarının ve son sınıf öğrencilerinin lisans programlarına dikey geçiş yapmak için girdiği ÖSYM sınavıdır. 2027 DGS başvuruları 26 Mayıs – 3 Haziran 2027, sonuçlar 12 Ağustos 2027'de.",
        'sessions' => [
            'DGS' => '2027-07-18 10:15',
        ],
        'estimated' => false,
        'source' => $osym,
        'checked' => '2026-11-13',
    ],

    'msu' => [
        'name' => 'MSÜ',
        'to' => "MSÜ'ye",
        'full' => 'Millî Savunma Üniversitesi Askerî Öğrenci Aday Belirleme Sınavı',
        'about' => "MSÜ sınavı, harp okulları, astsubay meslek yüksekokulları ve askerî öğrenci kaynaklarına aday belirlemek için ÖSYM'nin yaptığı sınavdır. 2027 MSÜ başvuruları 13 Ocak – 10 Şubat 2027, sonuçlar 15 Nisan 2027'de.",
        'sessions' => [
            'MSÜ' => '2027-03-20 10:15',
        ],
        'estimated' => false,
        'source' => $osym,
        'checked' => '2026-11-13',
    ],

];
