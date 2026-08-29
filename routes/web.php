<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/ads.txt', [PageController::class, 'adsTxt']);

// Legacy Play Console privacy policy URLs — do not rename, live apps' store
// listings link here directly. See ZETTELABSOLD_LEGACY.md for provenance.
Route::get('/privacy_policy', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Learn Words')
    ->name('legacy.privacy.learn-words');

Route::get('/privacy_policy_background_wizard', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Background Wizard')
    ->name('legacy.privacy.background-wizard');

Route::get('/privacy_policy_photo_finder', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Photo Finder')
    ->name('legacy.privacy.photo-finder');

Route::get('/privacy_policy_simple_alarm', [PageController::class, 'legacyPrivacy'])
    ->defaults('appName', 'Simple Alarm')
    ->name('legacy.privacy.simple-alarm');

// Per-app branding pages, driven by config/apps.php.
Route::get('/{slug}', [PageController::class, 'app'])
    ->where('slug', 'background-wizard|learn-words|cleanpix|circlepix|simple-alarm')
    ->name('apps.show');
