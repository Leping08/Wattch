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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();


/* Public Routes */
Route::get('/', function () {
    return view('pages.public.home');
});

Route::get('/about', function () {
    return view('pages.public.about'); //TODO: Add about page
});

Route::get('/pricing', function () {
    return view('pages.public.pricing'); //TODO: Add pricing page
});

Route::get('/privacy-policy', function () {
    return view('pages.public.privacy-policy'); //TODO: Add privacy policy page
});

Route::get('/contact-us', function () {
    return view('pages.public.contact-us'); //TODO: Add contact us page
});

Route::get('/test', function (){
    return \App\User::find(1)->paymentMethods();
});

/* Auth Routes */
Route::middleware('auth')->group(function () {

    /* @see DashboardController::index() */
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/profile', 'ProfileController@index')->name('profile');


    /* @see WebsiteController::index() */
    Route::get('/websites', 'WebsiteController@index')->name('websites.index');

    /* @see WebsiteController::show() */
    Route::get('/websites/{website}', 'WebsiteController@show')->name('websites.show');

    /* @see WebsiteController::store() */
    Route::post('/websites', 'WebsiteController@store')->name('websites.store');

    /* @see WebsiteController::edit() */
    Route::get('/websites/{website}/edit', 'WebsiteController@edit')->name('websites.edit');


    /* @see PageController::index() */
    Route::get('/pages', 'PageController@index')->name('pages.index');

    /* @see PageController::show() */
    Route::get('/pages/{page}', 'PageController@show')->name('pages.show');

    /* @see PageController::store() */
    Route::post('/pages', 'PageController@store')->name('pages.store');


    /* @see ScanWebsiteController::store() */
    Route::post('/scan/websites/{website}', 'ScanWebsiteController@store')->name('scan.websites');

    /* @see ScanPageController::store() */
    Route::post('/scan/pages/{website}', 'ScanPageController@store')->name('scan.pages');
});
