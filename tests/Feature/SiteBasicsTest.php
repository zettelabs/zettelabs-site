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
        foreach (['cleanpix', 'circlepix', 'simple-alarm', 'background-wizard', 'offlinescanner'] as $slug) {
            $this->get("/{$slug}")->assertOk()->assertSee('Common questions');
        }
    }
}
