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

Route::group(['middleware' => ['auth:customer']], function () {
    Route::get('/profile', [\App\Http\Controllers\Dashboard\HomeController::class, 'index']);
    Route::get('/profile/change-email', [\App\Http\Controllers\Dashboard\HomeController::class, 'change_email_view'])->name('dashboard.change_email_view');
    Route::post('/profile/change-email', [\App\Http\Controllers\Dashboard\ProfileController::class, 'change_email'])->name('dashboard.change_email');

    Route::get('/profile/change-password', [\App\Http\Controllers\Dashboard\HomeController::class, 'change_password_view'])->name('dashboard.change_password_view');
    Route::post('/profile/change-password', [\App\Http\Controllers\Dashboard\ProfileController::class, 'change_password'])->name('dashboard.change_password');

    Route::get('/profile/change-personal-info', [\App\Http\Controllers\Dashboard\HomeController::class, 'change_personal_info_view'])->name('dashboard.change_personal_info_view');
    Route::post('/profile/change-personal-info', [\App\Http\Controllers\Dashboard\ProfileController::class, 'change_personal_info'])->name('dashboard.change_personal_info');
    Route::get('/profile/upgrade-account-ajax', [\App\Http\Controllers\Dashboard\HomeController::class, 'upgrade_account_ajax'])->name('dashboard.upgrade_account_ajax');
    Route::get('/profile/upgrade-account', [\App\Http\Controllers\Dashboard\HomeController::class, 'upgrade_account_view'])->name('dashboard.upgrade_account_view');

    Route::get('/logout', [\App\Http\Controllers\Dashboard\HomeController::class, 'logout'])->name('dashboard.logout');

    ## Payment
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
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
// Route::get('pricing', 'HomeController@pricing');

Route::get('admin/customers/set-free-trial/{id}', 'AdminCustomersController@setFreeTrial');
Route::post('admin/customers/saveFreeTrial', 'AdminCustomersController@saveFreeTrial');
Route::get('admin/customers/set-subscription/{id}', 'AdminCustomersController@setSubscription');
Route::post('admin/customers/saveSubscription', 'AdminCustomersController@saveSubscription');
Route::get('admin/customers/renewal-subscription/{id}', 'AdminCustomersController@renewalSubscription');
Route::post('admin/customers/saveRenewalSubscription', 'AdminCustomersController@saveRenewalSubscription');
Route::get('admin/customers/generateJson/{id}', 'AdminCustomersController@generateJson');
Route::get('admin/customers/activateCustomer/{id}', 'AdminCustomersController@activateCustomer');
Route::get('admin/customers/renewalSubscriptionPage/{id}', 'AdminCustomersController@renewalSubscriptionPage');
Route::get('admin/customers/deleteCustomer/{id}', 'AdminCustomersController@deleteCustomer');
Route::get('admin/customers/send-link/{id}', 'AdminCustomersController@sendLink');
Route::get('admin/customers/set-free-trial-link/{id}', 'AdminCustomersController@setFreeTrialLink');
Route::post('admin/customers/saveLink', 'AdminCustomersController@saveLink');

$base_url = config('crudbooster.ADMIN_PATH');
Route::get($base_url . '/pages/{id}', "PageInfoController@viewpage");
Route::post($base_url . '/sort', "SortingModelController@sorting");
Route::get($base_url . '/seo/{model}/{model_id?}', 'SEOController@get');
Route::post('/seo-store/{model}', 'SEOController@store');
Route::get($base_url . '/information/{model}', 'PageInfoController@get');
Route::post('/info-page-store/{model}', 'PageInfoController@store');
Route::get($base_url . '/style/form/{id}', 'CmsFormController@getForm');
Route::get($base_url . '/response/form/{id}', 'CmsFormController@getSubmits');
Route::get($base_url . '/viewpage/{page_id}', 'AdminPagesController@viewpage');
Route::get($base_url . '/getForms', 'CmsFormController@getForms');
Route::post('request/form/{id}', 'CmsFormController@submit');

//images manage
Route::get('admin/saveImagesModule', 'ImageController@saveImagesModule');
Route::get('admin/deleteImageModule/{id}', 'ImageController@deleteImageModule');
Route::get('admin/image/{fleet_id?}', "ImageController@index");
Route::get('image/upload', 'ImageController@fileCreate')->name('images.upload');
Route::post('image/upload/store/{fleet_id}', 'ImageController@fileStore');
Route::get('/image/delete/{id}', 'ImageController@fileDestroy');
Route::get('/image/showImageJson/{fleet_id?}', 'ImageController@showImageJson');
Route::get('/manage-image/resize/{width?}/{height?}/{img}', 'ImageController@resizeImage')->name('manage-image-resize')->where('img', '(.*)');
Route::get('/manage-image/crop/{width?}/{height?}/{img}', 'ImageController@cropImage')->name('manage-image-crop')->where('img', '(.*)');

Route::get('/clear/route', 'HomeController@cleanCache');
Route::post('modules/sort', "SortingModelController@sorting");
Route::post('save-contact', 'HomeController@saveContact');