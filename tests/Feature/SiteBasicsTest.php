<?php

namespace Tests\Feature;

use Tests\TestCase;

class SiteBasicsTest extends TestCase
{
    public function test_sitemap_lists_home_and_apps(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertSee('/background-wizard', false)->assertSee('/privacy', false);
    }

    public function test_pages_carry_security_headers_and_canonical(): void
    {
        $this->get('/')->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Strict-Transport-Security')
            ->assertSee('rel="canonical"', false)
            ->assertSee('property="og:title"', false);
    }

    public function test_custom_404_has_a_way_home(): void
    {
        $this->get('/nope')->assertNotFound()->assertSee('Page not found');
    }

    public function test_app_descriptions_are_english_by_default(): void
    {
        $this->get('/background-wizard')->assertSee('Remove, replace, or blur photo backgrounds.', false);
    }

    public function test_skip_link_targets_main(): void
    {
        $this->get('/')->assertSee('href="#main"', false)->assertSee('id="main"', false);
    }

    public function test_terms_and_llms_txt_exist(): void
    {
        $this->get('/terms')->assertOk()->assertSee('Terms of Use');
        $this->get('/llms.txt')->assertOk()->assertHeader('Content-Type', 'text/plain; charset=utf-8')->assertSee('/background-wizard', false)->assertSee('/terms', false);
    }

    public function test_apps_without_their_own_faq_get_the_shared_one(): void
    {
        foreach (['cleanpix', 'circlepix', 'simple-alarm', 'background-wizard', 'offlinescanner', 'skydesk', 'countdown'] as $slug) {
            $this->get("/{$slug}")->assertOk()->assertSee('Common questions');
        }
    }

    public function test_offline_scanner_page_links_its_privacy_policy(): void
    {
        $this->get('/offlinescanner')->assertOk()->assertSee('href="/offlinescanner/privacy"', false);
        $this->get('/offlinescanner/privacy')->assertOk()->assertSee('Offline Scanner Privacy Policy');
    }

    public function test_skydesk_page_links_play_and_its_privacy_policy(): void
    {
        $this->get('/skydesk')->assertOk()->assertSee('href="/skydesk/privacy"', false)->assertSee('play.google.com/store/apps/details?id=com.zettelabs.skydesk', false);
        $this->get('/skydesk/privacy')->assertOk()->assertSee('Skydesk Privacy Policy');
    }

    public function test_countdown_page_is_coming_soon_in_both_locales(): void
    {
        $this->withSession(['locale' => 'tr'])->get('/countdown')->assertOk()->assertSee("Yakında Google Play'de")->assertSee('images/apps/shot-countdown-1.webp', false)->assertDontSee('play.google.com');
        $this->withSession(['locale' => 'en'])->get('/countdown')->assertOk()->assertSee('Coming soon on Google Play')->assertSee('images/apps/en/shot-countdown-1.webp', false)->assertSee('zettelabs-countdown.web.app/privacy-policy')->assertDontSee('play.google.com');
    }

    public function test_sinavsayaci_privacy_policy_is_published(): void
    {
        $this->get('/sinavsayaci/privacy')->assertOk()->assertSee('Sınav Sayacı Gizlilik Politikası')->assertSee('com.sayac.sinav.yks.lgs.kpss');
    }

    public function test_exam_countdown_pages_render_and_are_in_the_sitemap(): void
    {
        foreach (array_keys(config('exams')) as $exam) {
            $this->get("/{$exam}-kac-gun-kaldi")->assertOk()->assertSee('<html lang="tr">', false)
                ->assertSee('"@type":"FAQPage"', false)->assertSee('href="'.url('/sinavsayaci').'"', false);
        }
        $this->get('/yks-kac-gun-kaldi')->assertSee("YKS'ye kaç gün kaldı?", false)->assertSee('19 Haziran 2027 Cumartesi, 10.15');
        $this->get('/sitemap.xml')->assertSee('/msu-kac-gun-kaldi', false);
        $this->get('/xyz-kac-gun-kaldi')->assertNotFound();
    }

    public function test_exam_cta_uses_play_store_once_set(): void
    {
        config(['apps.sinavsayaci.play_store' => 'https://play.google.com/store/apps/details?id=com.sayac.sinav.yks.lgs.kpss']);
        $this->get('/lgs-kac-gun-kaldi')->assertSee('play.google.com/store/apps/details?id=com.sayac.sinav.yks.lgs.kpss', false);
    }
}
