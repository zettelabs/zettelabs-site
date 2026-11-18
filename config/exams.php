<?php

// Turkish "<sınav> kaç gün kaldı" SEO pages (/yks-kac-gun-kaldi …), funnelling to /sinavsayaci.
// Dates match ~/sinavsayaci/app/src/main/assets/exams.json. Times are Türkiye time (UTC+3).
// When ÖSYM/MEB publish the next calendar (ÖSYM: each October), update `sessions`, `source` and `checked`.
// Optional: `meta` (meta description tail), `more_title` + `more` (exam-specific facts), `related` (slug => in-body link), `faq` (extra Q&A).
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
        'more_title' => 'YKS oturumları kısaca',
        'more' => [
            'TYT: 120 soru, 165 dakika (Türkçe, sosyal bilimler, temel matematik, fen bilimleri). Herkes girer; ön lisans tercihleri için TYT puanı yeter.',
            'AYT: 160 soru, 180 dakika. Lisans programlarının sayısal, eşit ağırlık ve sözel puanları TYT ile birlikte hesaplanır.',
            'YDT: 80 soru, 120 dakika. Yabancı dil programları için.',
            'Üç oturum aynı hafta sonunda: 19 Haziran Cumartesi TYT, 20 Haziran Pazar sabah AYT, öğleden sonra YDT.',
        ],
        'related' => ['msu' => "MSÜ sınavı da TYT biçiminde. Harp okulu düşünüyorsan MSÜ'ye kalan süreye bak"],
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
        'more_title' => 'LGS oturumları kısaca',
        'more' => [
            'Sözel oturum: 50 soru, 75 dakika (Türkçe 20, T.C. İnkılap Tarihi ve Atatürkçülük 10, Din Kültürü 10, yabancı dil 10).',
            'Sayısal oturum: 40 soru, 80 dakika (matematik 20, fen bilimleri 20).',
            'Üç yanlış bir doğruyu götürür.',
            'Sınava girmek zorunlu değildir; girmeyen öğrenciler adrese dayalı yerleştirmeyle liseye yerleşir.',
        ],
    ],

    'kpss' => [
        'name' => 'KPSS',
        'to' => "KPSS'ye",
        'full' => 'Kamu Personel Seçme Sınavı',
        'about' => "KPSS, kamuda memur ve uzman yardımcısı alımları için ÖSYM'nin yaptığı sınavdır. ÖSYM'nin 2027 takviminde KPSS A Grubu var: Genel Yetenek-Genel Kültür 12 Eylül, Alan Bilgisi 18-19 Eylül 2027. Başvurular 8-19 Temmuz 2027, sonuçlar 13 Ekim 2027'de.",
        'sessions' => [
            'KPSS A Grubu · Genel Yetenek-Genel Kültür' => '2027-09-12 10:15',
            'KPSS A Grubu · Alan Bilgisi 1. gün' => '2027-09-18 10:15',
            'KPSS A Grubu · Alan Bilgisi 2. gün' => '2027-09-19 10:15',
        ],
        'estimated' => false,
        'source' => $osym,
        'checked' => '2026-11-18',
        'meta' => "Başvuru 8-19 Temmuz, sonuç 13 Ekim. 2027'de hangi KPSS oturumları var, ÖABT ne zaman?",
        'more_title' => "2027'de hangi KPSS oturumları var?",
        'more' => [
            "KPSS Lisans (B grubu), KPSS Ön Lisans ve KPSS Ortaöğretim ÖSYM'nin 2027 takviminde yok; son olarak 2026'da yapıldılar. Sonraki tarihleri kesinleşmedi.",
            'Öğretmen adayları için ÖABT artık KPSS içinde değil, MEB Akademi Giriş Sınavı (MEB-AGS) kapsamında: AGS 8 Mayıs, ÖABT 9 Mayıs 2027. Başvuru 19-29 Mart, sonuç 11 Haziran 2027.',
            'Genel Yetenek-Genel Kültür testi 120 soru, 130 dakikadır: genel yetenek (Türkçe, matematik) 60, genel kültür (tarih, coğrafya, vatandaşlık, güncel bilgiler) 60 soru.',
            'Alan Bilgisi testleri (hukuk, iktisat, maliye, işletme, muhasebe, çalışma ekonomisi, istatistik, kamu yönetimi, uluslararası ilişkiler) iki güne yayılır; aday yalnız hedeflediği kadronun istediği testlere girer.',
        ],
        'related' => ['ales' => "Lisansüstü eğitim veya araştırma görevlisi kadrosu için ALES'e kalan süre"],
        'faq' => [
            "2027'de KPSS Lisans, Ön Lisans ve Ortaöğretim var mı?" => "ÖSYM'nin 2027 sınav takviminde bu oturumlar yok; 2027'de yalnız KPSS A Grubu var. Sonraki tarihleri kesinleşmedi, ÖSYM duyurularını takip et.",
            'ÖABT 2027 ne zaman?' => "ÖABT 2027'de KPSS kapsamında değil, MEB Akademi Giriş Sınavı (MEB-AGS) kapsamında yapılıyor: AGS 8 Mayıs, ÖABT 9 Mayıs 2027. Başvuru 19-29 Mart, sonuç 11 Haziran 2027.",
            'KPSS 2027 başvuruları ne zaman?' => 'KPSS A Grubu başvuruları 8-19 Temmuz 2027 arasında ÖSYM üzerinden yapılır; sonuçlar 13 Ekim 2027.',
        ],
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
        'checked' => '2026-11-18',
        'more_title' => 'ALES kısaca',
        'more' => [
            'Sayısal 50, sözel 50 soru; süre 150 dakika.',
            'Sayısal, sözel ve eşit ağırlık olmak üzere üç puan türü hesaplanır; puan 5 yıl geçerlidir.',
            '2027 başvuruları: ALES/1 24 Şubat – 4 Mart, ALES/2 25 Mayıs – 2 Haziran, ALES/3 12-20 Ekim. Sonuçlar 7 Mayıs, 30 Temmuz ve 17 Aralık 2027.',
        ],
        'related' => ['kpss' => "Kamu kadroları için KPSS A Grubu'na kalan süre"],
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
        'checked' => '2026-11-18',
        'more_title' => 'DGS kısaca',
        'more' => [
            'Sayısal 50, sözel 50 soru; süre 150 dakika.',
            'Yerleştirmede DGS puanına ön lisans başarı puanın (OBP) da eklenir.',
            'Başvuru 26 Mayıs – 3 Haziran, geç başvuru 15 Haziran, sonuç 12 Ağustos 2027.',
        ],
        'related' => ['ales' => "Lisansı bitirince yüksek lisans için ALES'e kalan süre"],
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
        'checked' => '2026-11-18',
        'meta' => "Başvuru 13 Ocak – 10 Şubat, sonuç 15 Nisan. Canlı sayaç ve ücretsiz telefon widget'ı.",
        'more_title' => 'MSÜ sınavı kısaca',
        'more' => [
            'Sınav TYT biçimindedir: 120 soru, 165 dakika (Türkçe 40, sosyal bilimler 20, temel matematik 40, fen bilimleri 20).',
            "Puanı yeterli adaylar MSÜ'nün sonraki seçim aşamalarına (sağlık, spor ve mülakat gibi) çağrılır; ayrıntılar MSÜ kılavuzunda.",
        ],
        'related' => ['yks' => "Konular TYT ile aynı: YKS'ye kalan süre"],
        'faq' => [
            'MSÜ 2027 başvuruları ne zaman?' => '13 Ocak – 10 Şubat 2027 arasında ÖSYM üzerinden. Sınav 20 Mart 2027, sonuç 15 Nisan 2027.',
            'MSÜ sınavında kaç soru var?' => '120 soru, 165 dakika; TYT biçimindedir: Türkçe 40, sosyal bilimler 20, temel matematik 40, fen bilimleri 20 soru.',
        ],
    ],

];
