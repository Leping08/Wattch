<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

/* Public Routes */
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('pages.public.home');
})->name('home');

/* @see SignUpController::index() */
Route::get('/sign-up', 'SignUpController@index')->name('sign-up.index');

/* @see SignUpController::store() */
Route::post('/sign-up', 'SignUpController@store')->name('sign-up.store');

Route::get('/privacy-policy', function () {
    return view('pages.public.privacy-policy'); //TODO: Add privacy policy page
});

Route::get('/contact-us', function () {
    return view('pages.public.contact-us'); //TODO: Add contact us page
});

/* Auth Routes */
Route::middleware('auth')->group(function () {

    /* @see DashboardController::index() */
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    /* @see WebsiteController::index() */
    Route::get('/websites', 'WebsiteController@index')->name('websites.index');

    /* @see WebsiteController::show() */
    Route::get('/websites/{website}', 'WebsiteController@show')->name('websites.show');

    /* @see WebsiteController::store() */
    Route::post('/websites', 'WebsiteController@store')->name('websites.store');

    /* @see WebsiteController::edit() */
    Route::get('/websites/{website}/edit', 'WebsiteController@edit')->name('websites.edit');

    /* @see WebsiteController::destroy() */
    Route::delete('/websites/{website}', 'WebsiteController@destroy')->name('websites.destroy');

    /* @see PageController::index() */
    Route::get('/pages', 'PageController@index')->name('pages.index');

    /* @see PageController::show() */
    Route::get('/pages/{page}', 'PageController@show')->name('pages.show');

    /* @see PageController::store() */
    Route::post('/pages', 'PageController@store')->name('pages.store');

    /* @see PageController::destroy() */
    Route::delete('/pages/{page}', 'PageController@destroy')->name('pages.destroy');

    /* @see ScanWebsiteController::store() */
    Route::post('/scan/websites/{website}', 'ScanWebsiteController@store')->name('scan.websites');

    /* @see ScanPageController::store() */
    Route::post('/scan/pages/{page}', 'ScanPageController@store')->name('scan.pages');

    /* @see PageAssertionsController::index() */
    Route::get('/pages/{page}/assertions', 'PageAssertionsController@index')->name('pages.assertions.index');

    /* @see PageAssertionsController::store() */
    Route::post('/pages/{page}/assertions', 'PageAssertionsController@store')->name('pages.assertions.store');

    /* @see ScreenshotController::show() */
    Route::get('/screenshots/{screenshot}', 'ScreenshotController@show')->name('screenshots.show');

    /* @see ResponseController::show() */
    Route::get('/responses/{response}', 'ResponseController@show')->name('responses.show');

    /* @see AssertionController::index() */
    Route::get('/assertions', 'AssertionController@index')->name('assertions.index');

    /* @see AssertionController::show() */
    Route::get('/assertions/{assertion}', 'AssertionController@show')->name('assertions.show');

    /* @see RunAssertionController::index() */
    Route::post('/assertions/{assertion}/run', 'RunAssertionController@index')->name('assertions.run.index');

    /* @see AssertionResultController::index() */
    Route::get('/results', 'AssertionResultController@index')->name('results.index');

    /* @see AssertionResultController::show() */
    Route::get('/results/{result}', 'AssertionResultController@show')->name('results.show');

    /* @see AccountController::index() */
    Route::get('/settings/account', 'Settings\AccountController@index')->name('settings.account.index');

    /* @see AccountController::store() */
    Route::post('/settings/account', 'Settings\AccountController@store')->name('settings.account.store');

    /* @see BillingController::index() */
    Route::get('/settings/billing', 'Settings\BillingController@index')->name('settings.billing.index');

    /* @see BillingController::store() */
    Route::post('/settings/billing', 'Settings\BillingController@store')->name('settings.billing.store');

    /* @see DownloadInvoiceController::show() */
    Route::get('/settings/billing/{invoiceId}', 'Settings\DownloadInvoiceController@show')->name('settings.billing.download_invoice.show');


    /* @see NotificationController::index() */
    Route::get('/settings/notifications', 'Settings\NotificationController@index')->name('settings.notifications.index');

    /* @see NotificationController::store() */
    Route::post('/settings/notifications', 'Settings\NotificationController@store')->name('settings.notifications.store');
});
