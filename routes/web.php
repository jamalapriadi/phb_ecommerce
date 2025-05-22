<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\CustomerAuthController;

//kode baru diubah menjadi seperti ini
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product']);
Route::get('categories',[HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart']);
Route::get('checkout', [HomepageController::class, 'checkout']);

/** route untuk customer */
Route::group(['prefix'=>'customer'], function(){
    Route::controller(CustomerAuthController::class)->group(function(){
        //route untuk login
        Route::get('login','login')->name('customer.login');

        //route untuk aksi login
        Route::post('login','store_login')->name('customer.store_login');

        //route untuk register
        Route::get('register','register')->name('customer.register');

        //route untuk aksi register
        Route::post('register','store_register')->name('customer.store_register');

        //route untuk logout
        Route::post('logout','logout')->name('customer.logout');
    });
});
/** end route untuk customer */



Route::group(['prefix'=>'dashboard','middleware'=>['auth','verified']], function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('categories',ProductCategoryController::class);
    Route::resource('products',ProductController::class);

});


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
