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

// Each app's policy now lives on its own Firebase Hosting site; these old
// URLs forward there so store links keep working and only one text exists.
Route::permanentRedirect('/privacy_policy_background_wizard', 'https://backgroundmagic-beb46.web.app/privacy-policy');

Route::permanentRedirect('/privacy_policy_photo_finder', 'https://similiar-finder.web.app/privacy-policy');

Route::permanentRedirect('/privacy_policy_simple_alarm', 'https://simple-alarm-79b72.web.app/privacy-policy');

Route::permanentRedirect('/privacy_policy_circlepix', 'https://circlepix-3db60.web.app/privacy-policy');

// Per-app branding pages, driven by config/apps.php.
Route::get('/{slug}', [PageController::class, 'app'])
    ->where('slug', 'background-wizard|cleanpix|circlepix|simple-alarm')
    ->name('apps.show');
