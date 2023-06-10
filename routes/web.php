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

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('setLang/{lang}', "LanguageController@switchLang")->name('lang.switch');

//Mini Dashboard

Route::group(['prefix'  => 'profile','middleware' => ['auth:customer']], function () {
    Route::get('/', [\App\Http\Controllers\Dashboard\HomeController::class, 'index']);
    Route::get('/change-email', [\App\Http\Controllers\Dashboard\HomeController::class, 'change_email_view'])->name('dashboard.change_email_view');
    Route::post('/change-email', [\App\Http\Controllers\Dashboard\ProfileController::class, 'change_email'])->name('dashboard.change_email');

    Route::get('/change-password', [\App\Http\Controllers\Dashboard\HomeController::class, 'change_password_view'])->name('dashboard.change_password_view');
    Route::post('/change-password', [\App\Http\Controllers\Dashboard\ProfileController::class, 'change_password'])->name('dashboard.change_password');

    Route::get('/change-personal-info', [\App\Http\Controllers\Dashboard\HomeController::class, 'change_personal_info_view'])->name('dashboard.change_personal_info_view');
    Route::post('/change-personal-info', [\App\Http\Controllers\Dashboard\ProfileController::class, 'change_personal_info'])->name('dashboard.change_personal_info');
    Route::get('/upgrade-account-ajax', [\App\Http\Controllers\Dashboard\HomeController::class, 'upgrade_account_ajax'])->name('dashboard.upgrade_account_ajax');
    Route::get('/checkout', [\App\Http\Controllers\Dashboard\HomeController::class, 'checkout'])->name('dashboard.upgrade_account_view');
    Route::get('/my-payments', [\App\Http\Controllers\Dashboard\HomeController::class, 'my_payments'])->name('dashboard.my_payments');

    Route::post('/delete-customer', [\App\Http\Controllers\Dashboard\HomeController::class, 'delete_customer'])->name('dashboard.delete_customer');

    Route::get('/logout', [\App\Http\Controllers\Dashboard\HomeController::class, 'logout'])->name('dashboard.logout');

    ## Payment
    Route::prefix('/payment')->group(function () {
        Route::get('/success', [PaymentController::class, 'successPage'])->name('success-payment-page');
        Route::get('/error', [PaymentController::class, 'errorPage'])->name('error-payment-page');
    });

    Route::prefix('/transaction')->group(function () {
        // Inline (Website) PayPal Payment Routes
        Route::get('/process', [PaymentController::class, 'processTransaction'])->name('process-transaction');
        Route::get('/success', [PaymentController::class, 'successTransaction'])->name('success-transaction');
        Route::get('/cancel', [PaymentController::class, 'cancelTransaction'])->name('cancel-transaction');
        // Api PayPal Payment Routes
        Route::post('/', [PaymentController::class, 'createTransaction'])->name('create-transaction');
        Route::post('/{id}/capture', [PaymentController::class, 'captureTransaction'])->name('capture-transaction');
    });
});

Route::post('login-customer', "HomeController@loginCustomer")->name("login-customer");
Route::post('forget-password-customer', "HomeController@forgetPasswordCustomer")->name("forget-password-customer");

Route::get('/', "HomeController@index")->name("home");
Route::post('save-customer', 'HomeController@saveCustomer')->name('save-customer');
Route::get('solution/{id}', 'HomeController@solutions');
Route::get('solution/{id}', 'HomeController@solutions');
Route::get('pricing', 'HomeController@pricing')->name('pricing');
Route::get('activate-customer/{id}', 'HomeController@customer_activate');
Route::get('customers/{token}', 'HomeController@activationProgress');
Route::get('customers/email/{email}', 'HomeController@checkEmailUnique');

Route::get('admin/customers/renewal-subscription/{id}', 'AdminCustomersController@renewalSubscription');
Route::post('admin/customers/saveRenewalSubscription', 'AdminCustomersController@saveRenewalSubscription');
Route::get('admin/customers/renewalSubscriptionPage/{id}', 'AdminCustomersController@renewalSubscriptionPage');
Route::get('admin/customers/deleteCustomer/{id}', 'AdminCustomersController@deleteCustomer');


//images manage
Route::get('/clear/route', 'HomeController@cleanCache');
Route::post('save-contact', 'HomeController@saveContact');
