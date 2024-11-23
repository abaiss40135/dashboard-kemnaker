<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact karno@brainmatics.com'], 404);
});

Route::namespace('API')->group(function () {
    Route::namespace('v1')->middleware('auth:web')->group(function () {
        Route::middleware('polda-request')
            ->group(function () {
                Route::namespace('Dashboard')
                    ->name('api.dashboard.')
                    ->prefix('dashboard')
                    ->group(function () {
                        Route::match(['GET', 'POST'], 'jenis', 'KamtibmasController@getCountJenisLaporan')->name('count-jenis');
                        Route::match(['GET', 'POST'], 'bidang', 'KamtibmasController@bidang')->name('bidang');
                        Route::match(['GET', 'POST'], 'keyword', 'KamtibmasController@keyword')->name('keyword');
                    });

                Route::name('api.laporan.')
                    ->prefix('laporan')
                    ->group(function () {
                        Route::match(['GET', 'POST'], 'get', 'LaporanController@get')->name('get');
                    });

                Route::namespace('Laporan')
                    ->name('api.laporan.')
                    ->prefix('laporan')
                    ->group(function () {
                        Route::match(['GET', 'POST'], 'latest-laporan-informasi', 'DeteksiDiniController@getLatestLaporan')->name('dd.latest');
                    });
            });

        Route::prefix(config('app.sipp_api_version'))->group(function () {
//            Route::get('get-token', 'AuthController@getToken')->name('get-token');
//            Route::get('get-personel/{nrp}', 'AuthController@getPersonelByNrp')->name('get-personel');
        });
    });

    Route::namespace('SISLAP')->name('sislap.')->prefix('sislap')->group(function () {
        Route::namespace('LAPHAR')->name('laphar.')->prefix('laphar')->group(function () {
            Route::middleware('auth.sislap')->name('pmk.')->group(function () {
                Route::prefix('pmk')->group(function () {

                });
                Route::post('pmk', 'PMKController@get')->name('get');
            });
        });
    });

    Route::namespace('OSS')->name('oss.')->prefix('oss')->group(function () {
        Route::get('inquery-nib/{nib}', 'OSSController@inqueryNIB')->name('inquery-nib');
        Route::get('generate-lampiran-sio/{pendaftaran_sio}', 'OSSController@generateLampiranSio')->name('generate-lampiran-sio');
        Route::post('receive-nib', 'OSSController@receiveNIB')->name('receive-nib')->middleware('throttle.receiveNIB:120');
        Route::post('receive-file-ds', 'OSSController@receiveFileDS')->name('receive-file-ds');
        Route::name('sso.')->prefix('sso')->group(function () {
            Route::get('receive-token', 'SSOController@receiveToken')->name('receive-token');
            Route::get('userinfo-token', 'SSOController@userinfoToken')->name('userinfo-token');
            Route::post('login', 'SSOController@login')->name('login');
            Route::post('validate-token', 'SSOController@validateToken')->name('validate-token');
            Route::post('update-token', 'SSOController@updateToken')->name('update-token');
            Route::post('revoke-token', 'SSOController@updateToken')->name('revoke-token');
        });
    });

    Route::prefix('twitter')->group(function () {
        Route::get('trend-indonesia', 'TwitterController@getIndonesiasTrends')->name('get-twitter.indonesia-trends');
        Route::get('closest-trends', 'TwitterController@getClosestTrends')->name('get-twitter.closest-trends');
    });

    Route::prefix('youtube')->name('get-youtube.')->group(function () {
        Route::get('trend-indonesia', 'YoutubeController@getTrendingIndonesia')->name('get-trending-indonesia');
    });

    Route::get('check-health', 'CheckHealthController@check')->name('check-health');
});

Route::namespace("API\LaravelFcm")->name("laravel-fcm.")->prefix("laravel-fcm")->group(function () {
    Route::get("test-push-notif", "PushNotificationController@testPushNotif")->name("test-push-notif");
});
