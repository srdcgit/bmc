<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CronjobController;
use App\Models\Payment;
use App\Services\SmsService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\IndexController;
// use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\LangController;

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
Route::get('search_shop_with_details', [AuthController::class, 'search_details'])->name('search_details');
Route::get('mobile_verify', [AuthController::class, 'mobile_verify'])->name('mobile_verify');
Route::get('get-shops-by-establishment/{id}', [AuthController::class, 'getShopsByEstablishment']);
/******************LOGIN PAGE ROUTES START****************/
Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');
Route::get('firebase_otp_verification', [HomeController::class, 'otpVerification']);
Route::view('/','auth.login');
Route::view('login','auth.login');
Route::get('search_shop',[AuthController::class,'search_shop']);
Route::get('pay',[AuthController::class,'pay'])->name('pay');
Route::get('shop/{id}',[AuthController::class,'shopDetail'])->name('shop.detail');
Route::get('shop_payments/{id}',[AuthController::class,'shop_payments'])->name('shop_payments');
Route::get('receipt/{id}',[AuthController::class,'receipt'])->name('receipt');
Route::get('receipt/invoices/{id}',[AuthController::class,'invoices'])->name('invoices');
Route::post('payment_pay',[AuthController::class,'storePay']);
Route::view('success_message','auth.success_message');
Route::post('success',[AuthController::class,'success'])->name('success');
Route::post('success_for_multiple',[AuthController::class,'success_for_multiple'])->name('success_for_multiple');
Route::post('muliple_for_non_auth',[AuthController::class,'muliple_for_non_auth'])->name('muliple_for_non_auth');
Route::get('payment-for-api',[AuthController::class,'paymentForApi'])->name('payment_for_api');
Route::post('success-for-api',[AuthController::class,'successForApi'])->name('success_for_api');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('fix-payment-issue',[AuthController::class,'paymentIssue'])->name('paymment.issue');
/******************LOGIN PAGE ROUTES END****************/

/*******************REGISTER ROUTE START*************/
Route::view('register','auth.register');
Route::post('register',[AuthController::class,'register'])->name('register');
/*******************REGISTER ROUTE END*************/

/*******************CRONJOB ROUTES ROUTE START*************/
Route::get('get-payments',[CronjobController::class,'getPayments'])->name('logout');
/*******************LOGOUT ROUTE END*************/
/*******************LOGOUT ROUTE START*************/
Route::get('logout',[AuthController::class,'logout'])->name('logout');
/*******************LOGOUT ROUTE END*************/
Route::post('get_city_against_states',[AuthController::class,'getCityAgainstStates'])->name('get_city_against_states');
Route::post('get_state_against_countries',[AuthController::class,'getStateAgainstCountries'])->name('get_state_against_countries');


/*******************ADMIN ROUTE START*************/
include __DIR__ . '/admin.php';
/*******************ADMIN ROUTE END*************/
/*******************SUPER ADMIN ROUTE START*************/
include __DIR__ . '/super_admin.php';
/*******************SUPER ADMIN ROUTE END*************/
/*******************COLLECTION STAFF ROUTE START*************/
include __DIR__ . '/collection_staff.php';
/*******************COLLECTION STAFF ROUTE END*************/


/*******************ZDC STAFF ROUTE START*************/
include __DIR__ . '/zdc.php';
/*******************ZDC STAFF ROUTE END*************/
Route::get('/',[IndexController::class, 'index'])->name('web.index');
Route::get('establistment-shops/{name}',[IndexController::class, 'shops'])->name('web.shops');
/******************FUNCTIONALITY ROUTES****************/
Route::get('test_sms', function() {
  $payment = Payment::where('type','monthly')->first();
   $response = (new SmsService())->sendWhatsappSMS('7008124707',$payment);
   dd($response);
    return 'DONE';
  });Route::get('cd', function() {
    Artisan::call('config:cache');
    Artisan::call('migrate:refresh');
    Artisan::call('db:seed', [ '--class' => DatabaseSeeder::class]);
    Artisan::call('view:clear');
    return 'DONE';
  });
  Route::get('migrate', function() {
    Artisan::call('config:cache');
    Artisan::call('migrate');
    Artisan::call('view:clear');
    return 'DONE';
  });
  Route::get('cache_clear', function() {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'DONE';
  });

  Route::get('testing', function() {
    Artisan::call('create:monthly-payments');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'DONE';
  });
  // Route::get('logs', [LogViewerController::class, 'index']);
// 
  // Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');