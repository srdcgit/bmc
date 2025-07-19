<?php
/****************** COLLECTION STAFF MIDDLEWARE PAGES ROUTES START****************/

use App\Http\Controllers\CollectionStaff\PaymentController;
use App\Http\Controllers\CollectionStaff\ShopController;
use App\Http\Controllers\CollectionStaff\StreetVendorController;

Route::group(['prefix' => 'collection_staff', 'as'=>'collection_staff.','middleware' => 'auth:user','collection_staff'], function () {

    Route::group(['middleware' => ['collection_staff']], function (){


    /*******************DASHBOARD ROUTE START*************/
    Route::view('dashboard','collection_staff.dashboard.index')->name('dashboard.index');
    /*******************DASHBOARD ROUTE END*************/
    /*******************SHOP ROUTE START*************/
    Route::post('shop/get_wards',[ShopController::class,'getWards'])->name('shop.get_wards');
    Route::post('shop/get_establishments',[ShopController::class,'getEstablishments'])->name('shop.get_establishments');
    Route::post('shop/get_establishment_shops',[ShopController::class,'getEstablishmentShops'])->name('shop.get_establishment_shops');
    Route::post('shop/get_taken_establishment_shops',[ShopController::class,'getTakenEstablishmentShops'])->name('shop.get_taken_establishment_shops');
    Route::post('shop/get_establishment_shop',[ShopController::class,'getEstablishmentShop'])->name('shop.get_establishment_shop');
    Route::post('shop/get_establishment_shop_with_data',[ShopController::class,'getEstablishmentShopWithData'])->name('shop.get_establishment_shop_with_data');
    Route::get('shop/exclude_interest/{id}',[ShopController::class,'excludeInterest'])->name('shop.exclude_interest');
    Route::resource('shop',ShopController::class);
    /*******************SHOP ROUTE END*************/
    /*******************PAYMENT ROUTE START*************/
    Route::post('payment/pay',[PaymentController::class,'storePay'])->name('payment.pay');
    Route::get('payment/view',[PaymentController::class,'view'])->name('payment.view');
    Route::get('payment/pending/{id}',[PaymentController::class,'pending'])->name('payment.pending');
    Route::resource('payment',PaymentController::class);

    //street vendor
    Route::get('street_vendor',[StreetVendorController::class,'index'])->name('street_vendor.index');
    Route::get('street_vendor/add',[StreetVendorController::class,'add'])->name('street_vendor.add');
    Route::post('street_vendor/store',[StreetVendorController::class,'store'])->name('street_vendor.store');
    Route::get('street_vendor/edit/{id}',[StreetVendorController::class,'edit'])->name('street_vendor.edit');
    Route::post('street_vendor/update/{id}',[StreetVendorController::class,'update'])->name('street_vendor.update');
    Route::get('street_vendor/delete/{id}',[StreetVendorController::class,'delete'])->name('street_vendor.delete');
    /*******************PAYMENT ROUTE END*************/
});
});
/****************** COLLECTION STAFF MIDDLEWARE PAGES ROUTES END****************/
?>
