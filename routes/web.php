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

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/clear/route', function () {

    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    return "done";
});

Route::post('login-customer', "HomeController@loginCustomer")->name("login-customer");
Route::post('forget-password-customer', "HomeController@forgetPasswordCustomer")->name("forget-password-customer");

Route::get('/', "HomeController@index")->name("home");
Route::post('save-customer', 'HomeController@saveCustomer')->name('save-customer');
Route::get('solution/{id}', 'HomeController@solutions');
Route::get('solution/{id}', 'HomeController@solutions');
Route::get('pricing', 'HomeController@pricing');
Route::get('activate-customer/{id}', 'HomeController@customer_activate');
Route::get('customers/{token}', 'HomeController@activationProgress');
Route::get('customers/email/{email}', 'HomeController@checkEmailUnique');
Route::get('pricing', 'HomeController@pricing');
Route::get('/setLang/{lang}', function ($lang) {
    if (!in_array($lang, ['en', 'ar'])) {
        abort(404);
    }
    Session::put("locale",$lang);
    return redirect()->back();
});


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

Route::get('admin/customers/send-link/{id}', 'AdminCustomersController@sendLink'); // yazan_edits

Route::get('admin/customers/set-free-trial-link/{id}', 'AdminCustomersController@setFreeTrialLink'); // yazan_edits
Route::post('admin/customers/saveLink', 'AdminCustomersController@saveLink'); // yazan_edits
//Route::get('admin/PricingPackageOptions','crocodicstudio_voila\crudbooster\controllers\MenusClientController@getModulesItem');


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
Route::get('/manage-image/resize/{width?}/{height?}/{img}', function ($width = 100, $height = 100, $img) {
    return \Image::make(public_path("$img"))->resize($width, $height)->response('jpg');
})->name('manage-image-resize')->where('img', '(.*)');

Route::get('/manage-image/crop/{width?}/{height?}/{img}', function ($width = 100, $height = 100, $img) {
    return \Image::make(public_path("$img"))->crop($width, $height)->response('jpg');
})->name('manage-image-crop')->where('img', '(.*)');
############ Added Routes ###########
Route::post('modules/sort', "SortingModelController@sorting");
Route::post('save-contact','HomeController@saveContact');