<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 |-------------------------------------------------------------------------
 | Auth Routes
 |-------------------------------------------------------------------------
 |
 | Register, forger, verification and All the routes that user needs to be authenticated (Login)
 | Check authenticated will be handle by auth middleware
 |
 */

Auth::routes(['register' => false]);
Route::impersonate();
Route::get('/', fn () => redirect(route('login')));

Route::prefix('dashboard-kemnaker')
    ->name('dashboard-kemnaker.')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('dashboard-kemnaker.rekapitulasi-keuangan'))->name('index');
        Route::get('rekapitulasi-keuangan', fn () => view('dashboard-kemnaker.rekapitulasi-keuangan.index'))->name('rekapitulasi-keuangan');
        Route::get('bmn', fn () => redirect()->route('dashboard-kemnaker.rekapitulasi-keuangan'))->name('bmn');
        Route::get('sdm', fn () => redirect()->route('dashboard-kemnaker.rekapitulasi-keuangan'))->name('sdm');
        Route::get('kpi', fn () => redirect()->route('dashboard-kemnaker.rekapitulasi-keuangan'))->name('kpi');
        Route::get('tlhp', fn () => redirect()->route('dashboard-kemnaker.rekapitulasi-keuangan'))->name('tlhp');
        Route::get('pengelolaan-proyek', fn () => redirect()->route('dashboard-kemnaker.rekapitulasi-keuangan'))->name('pengelolaan-proyek');
    })
;

Route::prefix('dashboard-ketenagakerjaan')
    ->name('dashboard-ketenagakerjaan.')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('dashboard-ketenagakerjaan.pekerja'))->name('index');
        Route::get('pekerja', fn () => view('dashboard-ketenagakerjaan.index'))->name('pekerja');
        Route::get('upah', fn () => redirect()->route('dashboard-ketenagakerjaan.pekerja'))->name('upah');
        Route::get('jam-kerja', fn () => redirect()->route('dashboard-ketenagakerjaan.pekerja'))->name('jam-kerja');
        Route::get('pengangguran-terbuka', fn () => redirect()->route('dashboard-ketenagakerjaan.pekerja'))->name('pengangguran-terbuka');
    })
;

Route::get('captcha', 'CaptchaController@getCaptcha')->name('captcha');

Route::get('/select2', function () {
    return [
        'halo',
    ];
})->name('user.select2');
