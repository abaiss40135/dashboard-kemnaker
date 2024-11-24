<?php

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
Route::get('/', fn() => redirect(route('login')));
Route::get('/administrator', 'Admin\DashboardController@index')->name('administrator');
Route::get('captcha', 'CaptchaController@getCaptcha')->name('captcha');


Route::get('/select2', function() {
    return [
        'halo'
    ];
})->name('user.select2');
