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

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::prefix('kemnaker')
        ->name('kemnaker.')
        ->group(function () {
            Route::get('/', fn () => redirect()->route('dashboard.kemnaker.rekapitulasi-keuangan'))->name('index');
            Route::get('rekapitulasi-keuangan', fn () => view('dashboard.kemnaker.rekapitulasi-keuangan.index'))->name('rekapitulasi-keuangan');
            Route::get('bmn', fn () => view('dashboard.kemnaker.bmn.index'))->name('bmn');
            Route::get('sdm', fn () => view('dashboard.kemnaker.sdm.index'))->name('sdm');
            Route::get('kpi', fn () => view('dashboard.kemnaker.kpi.index'))->name('kpi');
            Route::get('tlhp', fn () => view('dashboard.kemnaker.tlhp.index'))->name('tlhp');
            Route::get('pengelolaan-proyek', fn () => view('dashboard.kemnaker.pengelolaan-proyek.index'))->name('pengelolaan-proyek');
        })
    ;

    Route::prefix('ketenagakerjaan')
        ->name('ketenagakerjaan.')
        ->group(function () {
            Route::get('/', fn () => redirect()->route('dashboard.ketenagakerjaan.pekerja'))->name('index');
            Route::get('pekerja', fn () => view('dashboard.ketenagakerjaan.pekerja.index'))->name('pekerja');
            Route::get('upah', fn () => view('dashboard.ketenagakerjaan.upah.index'))->name('upah');
            Route::get('jam-kerja', fn () => view('dashboard.ketenagakerjaan.jam-kerja.index'))->name('jam-kerja');
            Route::get('pengangguran-terbuka', fn () => view('dashboard.ketenagakerjaan.pengangguran-terbuka.index'))->name('pengangguran-terbuka');
        })
    ;

    Route::prefix('entry-data')
        ->name('entry-data.')
        ->group(function () {
            Route::prefix('kemnaker')
                ->name('kemnaker.')
                ->group(function () {
                    Route::get('/', fn () => view('dashboard.entry-data.kemnaker.index'))->name('index');
                })
            ;

            Route::prefix('ketenagakerjaan')
                ->name('ketenagakerjaan.')
                ->group(function () {
                    Route::get('/', fn () => view('dashboard.entry-data.ketenagakerjaan.index'))->name('index');
                })
            ;
        })
    ;
});

Route::get('captcha', 'CaptchaController@getCaptcha')->name('captcha');

Route::get('/select2', function () {
    return [
        'halo',
    ];
})->name('user.select2');
