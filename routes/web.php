<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/ads.txt', [PageController::class, 'adsTxt']);
Route::get('/app-ads.txt', [PageController::class, 'adsTxt']);

// Legacy Play Console privacy policy URLs — do not rename, live apps' store
// listings link here directly. See ZETTELABSOLD_LEGACY.md for provenance.
Route::get('/privacy_policy', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Learn Words')
    ->name('legacy.privacy.learn-words');

Route::get('/privacy_policy_background_wizard', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Background Wizard')
    ->name('legacy.privacy.background-wizard');

// CleanPix and CirclePix's Play Console listings use their Firebase-hosted
// policies; old site URLs forward there so only one text exists per app.
Route::permanentRedirect('/privacy_policy_photo_finder', 'https://similiar-finder.web.app/privacy-policy');

Route::get('/privacy_policy_simple_alarm', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Simple Alarm')
    ->name('legacy.privacy.simple-alarm');

Route::permanentRedirect('/privacy_policy_circlepix', 'https://circlepix-3db60.web.app/privacy-policy');

// Per-app branding pages, driven by config/apps.php.
Route::get('/{slug}', [PageController::class, 'app'])
    ->where('slug', 'background-wizard|cleanpix|circlepix|simple-alarm')
    ->name('apps.show');
