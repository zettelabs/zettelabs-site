<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/terms', [PageController::class, 'terms'])->name('terms');

Route::get('/llms.txt', [PageController::class, 'llmsTxt']);

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/sitemap.xml', [PageController::class, 'sitemap']);

Route::get('/ads.txt', [PageController::class, 'adsTxt']);
Route::get('/app-ads.txt', [PageController::class, 'adsTxt']);

// Legacy Play Console privacy policy URLs — do not rename, live apps' store
// listings link here directly. See ZETTELABSOLD_LEGACY.md for provenance.
Route::get('/privacy_policy', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Learn Words')
    ->name('legacy.privacy.learn-words');

// Background Wizard's policy is served here directly (no redirect): Play's
// crawler rejected the 301 to web.app as "not a valid privacy policy page".
Route::get('/privacy_policy_background_wizard', [PageController::class, 'backgroundWizardPrivacy'])
    ->name('legacy.privacy.background-wizard');

// Same for the other apps: Play's crawler does not accept redirects to a
// third-party host, so each policy is served here directly.
Route::get('/privacy_policy_photo_finder', [PageController::class, 'cleanpixPrivacy'])
    ->name('legacy.privacy.cleanpix');

Route::get('/privacy_policy_simple_alarm', [PageController::class, 'simpleAlarmPrivacy'])
    ->name('legacy.privacy.simple-alarm');

Route::get('/privacy_policy_circlepix', [PageController::class, 'circlepixPrivacy'])
    ->name('legacy.privacy.circlepix');

// Offline Scanner's policy lives under the app's own path (new app, no legacy Play URL).
Route::view('/offlinescanner/privacy', 'legal.offlinescanner')->name('privacy.offlinescanner');
Route::view('/skydesk/privacy', 'legal.skydesk')->name('privacy.skydesk');
Route::view('/sinavsayaci/privacy', 'legal.sinavsayaci')->name('privacy.sinavsayaci');

// Per-app branding pages, driven by config/apps.php.
Route::get('/{slug}', [PageController::class, 'app'])
    ->where('slug', 'background-wizard|cleanpix|circlepix|simple-alarm|offlinescanner|skydesk|countdown|sinavsayaci')
    ->name('apps.show');
