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

$base_url = config('crudbooster.ADMIN_PATH');
\LaravelLocalization::setLocale(config('setting.LANG'));

Route::get('/clear-cache', function () {
    \Artisan::call('cache:clear');
    Artisan::call('config:clear');
    // Artisan::call('config:cache');
    Artisan::call('view:clear');
    // Artisan::call('view:cache');
});

Route::group([

    'prefix' => \LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],

], function () {
    Route::redirect('/', 'modules')->name("home");
});


// Route::get("/import-data",function(){
//     $faq=DB::table("products_catalog_users")
//     ->select(
//         'products_catalog_users.*',
//         'countries.country as country_name'
//     )
//     ->join('countries','countries.id','products_catalog_users.country_id')
//     ->get();

//     foreach ($faq as $key => $value) {
//         DB::table("request_catalogs")->insert([
//             'name'=>$value->full_name,
//             'email'=>$value->email,
//             'company'=>$value->company_name,
//             'tel'=>$value->tel,
//             'code'=>$value->code,
//             'admin_note'=>$value->note,
//             'active'=>$value->active,
//             'country'=>$value->country_name,
//             'date'=>date('Y-m-d'),
//             'ip'=>$value->ip."-".$value->country_name
//         ]);
//     }
// });

Route::post('/contact/request', "FrontController@contactUsRequest");

Route::post('/testimonials/request', "FrontController@testimonialsRequest");
Route::post('/bill/check', "AdminBillsPurchaseInvoiceController@checkBox");


Route::post('request/form/{id}', 'CmsFormController@submit');

Route::get('lang/{locale}', function ($locale) {
    \App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

// Route::get('insertData', function($locale){
//     for ($i=0; $i <100 ; $i++) {
//        $product=new App\Product();
//        $product->name="product".$i;
//        $product->price=$i*10;
//        //fill all fields

//        $product->save();
//     }
// });





Route::get('modules/category-tree-view','CategoryController@manageCategory')->name('category-tree-view');
Route::post('add-category','CategoryController@addCategory')->name('add.category');
// Route::get('modules/getToSort/{parent_id}','AdminCategoriesController@getToSort')->name('getToSort');
// Route::post('post-sortable','AdminCategoriesController@ordring');


// Route::get('/comment/approvecomment/{id}', 'commentController@approvecomment')->name('approvecomment');
// Route::get('/comment/rejectioncomment/{id}', 'CommentController@rejectioncomment')->name('rejectioncomment');

//requests
Route::post('/request/save/{id}', "FrontController@requestEvent");
Route::post('/contact_us', "FrontController@contactUsRequest");

Route::get('pages/{id}', "PageInfoController@viewpage");

Route::post($base_url . '/sort', "SortingModelController@sorting");
Route::get($base_url . '/image/{fleet_id?}', "ImageController@index");
Route::get('image/upload', 'ImageController@fileCreate')->name('images.upload');
Route::post('image/upload/store/{fleet_id}', 'ImageController@fileStore');
Route::get('/image/delete/{id}', 'ImageController@fileDestroy');
Route::get('/image/showImageJson/{fleet_id?}', 'ImageController@showImageJson');
Route::get($base_url . '/seo/{model}/{model_id?}', 'SEOController@get');
Route::post('/seo-store/{model}', 'SEOController@store');
Route::get($base_url . '/information/{model}', 'PageInfoController@get');
Route::post('/info-page-store/{model}', 'PageInfoController@store');
Route::post($base_url . '/saveImagesModule', 'ImageController@saveImagesModule');
Route::get($base_url . '/deleteImageModule/{id}', 'ImageController@deleteImageModule');
Route::get($base_url . '/style/form/{id}', 'CmsFormController@getForm');
Route::get($base_url . '/response/form/{id}', 'CmsFormController@getSubmits');
// Route::get($base_url . '/viewpage/{page_id}', 'AdminPagesController@viewpage');
Route::get($base_url . '/getForms', 'CmsFormController@getForms');
Route::post('request/form/{id}', 'CmsFormController@submit');
Route::get($base_url . '/languages', 'LanguageTranslationController@index')->name('languages');
Route::post('translations/update', 'LanguageTranslationController@transUpdate')->name('translation.update.json');
Route::post('translations/updateKey', 'LanguageTranslationController@transUpdateKey')->name('translation.update.json.key');
Route::delete('translations/destroy/{key}', 'LanguageTranslationController@destroy')->name('translations.destroy');
Route::post('translations/create', 'LanguageTranslationController@store')->name('translations.create');

//images manage

// Route::get('/manage-image/resize/{width?}/{height?}/{img}', function ($width = 100, $height = 100, $img) {
//     return \Image::make(public_path("$img"))->resize($width, $height)->response('jpg');
// })->name('manage-image-resize')->where('img', '(.*)');

// Route::get('/manage-image/crop/{width?}/{height?}/{img}', function ($width = 100, $height = 100, $img) {
//     return \Image::make(public_path("$img"))->crop($width, $height)->response('jpg');
// })->name('manage-image-crop')->where('img', '(.*)');

Route::get('/landingPage/create/{template_id}', 'LandingPageController@store');
Route::get('/landingPage/getAllForms', 'LandingPageController@getAllForms');
Route::post('/landingPage/save', 'LandingPageController@saveLanding');
Route::get('/landingPages', 'LandingPageController@getAllLandings')->name('landing.index');
Route::get('/landingPage/show/{id}', 'LandingPageController@show');
Route::get('/landingPage/edit/{id}', 'LandingPageController@edit');
Route::post('/landingPage/save/{id}', 'LandingPageController@update');
Route::get('/landingPage/get/{id}', 'LandingPageController@get_info');

Route::get('/templatesLanding', 'TemplateController@index')->name('template.index');
Route::get($base_url . '/fromscratch', 'TemplateController@fromscratch')->name('template.fromscratch');
Route::get($base_url . '/fromscratch/edit/{id}', 'TemplateController@fromscratch')->name('template.fromscratch');
Route::get('/items/getPrice/{id}', 'AdminBillsPurchaseInvoiceController@getPriceById');
Route::get('/bills/getDelegateNameById/{id}', 'AdminBillsSalesInvoiceController@getDelegateNameById');
Route::get('/bills/getCustomers', 'AdminBillsSalesInvoiceController@getCustomers');
Route::get('/bills/getItems', 'AdminBillsPurchaseInvoiceController@getItems');
Route::post('/reports/getCustomers/{id}', 'AdminSalesmenReportController@getCustomers');
Route::post('/reports/getDelegates/{id}', 'AdminSalesmenReportController@getDelegates');
Route::post('/reports/getDealCurrencies/{account_id}', 'AdminAccountstatementController@getDealCurrencies');
Route::post('/reports/getCurrenciesDealing/{account_id}', 'AdminSalesmenReportController@getCurrenciesDealing');
Route::post('/bills/getDefaultCurrency', 'AdminBillsPurchaseInvoiceController@getDefaultCurrency');
Route::get('/voucher/checkBox/{currency_id}/{amount}', 'AdminPaymentVoucherController@checkBox');
Route::get('/voucherTransfer/checkBox/{currency_id}/{amount}/{account_id}', 'AdminTransferVouchersController@checkBox');
Route::get('/bills/getInventoryByDelegate/{id}', 'AdminBillsSalesInvoiceController@getInventoryByDelegate');
Route::get('/currency/getEx_rate/{id}', 'AdminReceiptVoucherController@getExchangeRate');
## Added Route ##
Route::get('/voucher/calculateAmountAfterOpposite/{amount}/{currency_id}/{opposite}/{ex_rate}', 'AdminReceiptVoucherController@calculateVoucherAmountAfterOppositeTransfer');



Route::get('/inventory/items/{id}', 'AdminBillsSalesInvoiceController@getInventoryItems');
Route::get('/inventory{inv}/item{id}/check/qty{qty}', 'AdminBillsSalesInvoiceController@checkInventoryItem');

Route::get(config('crudbooster.ADMIN_PATH')."/salesmen/statistics",'AdminStatisticsController@getSalesmenStatistics');

Route::post('/continue_rotate_data', 'AdminReportsRotateDataController@continue_rotate_data');
Route::get('/rotate_data', 'GeneralFunctionsController@rotate_data');


Route::get('/inventories/getItems', 'GeneralFunctionsController@getItems');


Route::get('/bill-items/{id}', 'GeneralFunctionsController@getBillItemsDetails');

Route::get('/persons/getParentAccount/{id}', 'GeneralFunctionsController@getParentAccount');

Route::get(config('crudbooster.ADMIN_PATH')."/admin/statistics",'AdminStatisticsController@getAdminStatistics');
Route::get(config('crudbooster.ADMIN_PATH')."/admin/statistics/setting",'AdminStatisticsController@getAdminStatisticsSetting');
Route::get(config('crudbooster.ADMIN_PATH')."/admin/statistics/setting/edit/{data}",'AdminStatisticsController@editStatisticsSetting');

##############Export to Execel file ##############
Route::get(config('crudbooster.ADMIN_PATH')."/inventory_accounting/export/{filter}",'AdminInventoryAccountingController@export');
Route::get(config('crudbooster.ADMIN_PATH')."/material_movement/export/{filter}",'AdminItemTracking102Controller@export');
Route::get(config('crudbooster.ADMIN_PATH')."/general_entry_record/export/{filter}",'AdminReports118Controller@export');
Route::get(config('crudbooster.ADMIN_PATH')."/account_statement/export/{filter}",'AdminAccountstatementController@export');
Route::get(config('crudbooster.ADMIN_PATH')."/account/export/{filter}",'AdminReports99Controller@export');
Route::get(config('crudbooster.ADMIN_PATH')."/closing_accounts/export/{filter}",'AdminReports117Controller@export');
Route::get(config('crudbooster.ADMIN_PATH')."/salesmen/export/{filter}",'AdminSalesmenReportController@export');

Route::get(config('crudbooster.ADMIN_PATH')."/entries_history/export/{filter}",'AdminReportsEntriesHistoryController@export');


##################### Import data from excel file ########################

Route::get(config('crudbooster.ADMIN_PATH')."/initial_voucher/import-data-form",'AdminInitialVoucherController@importDataForm')->name('Import-Data-Form');
Route::post(config('crudbooster.ADMIN_PATH')."/initial_voucher/get-import-data",'AdminInitialVoucherController@getDataFromExcel')->name('get-import-data');

Route::get(config('crudbooster.ADMIN_PATH')."/inventories/import-data-form",'AdminInventoriesController@importDataForm');
Route::post(config('crudbooster.ADMIN_PATH')."/inventories/get-import-data",'AdminInventoriesController@getDataFromExcel');

Route::get(config('crudbooster.ADMIN_PATH')."/item_categories/import-data-form",'AdminItemCategoriesController@importDataForm');
Route::post(config('crudbooster.ADMIN_PATH')."/item_categories/get-import-data",'AdminItemCategoriesController@getDataFromExcel');

Route::get(config('crudbooster.ADMIN_PATH')."/items/import-data-form",'AdminItemsController@importDataForm');
Route::post(config('crudbooster.ADMIN_PATH')."/items/get-import-data",'AdminItemsController@getDataFromExcel');

Route::get(config('crudbooster.ADMIN_PATH')."/item_tracking100/import-data-form",'AdminItemTracking100Controller@importDataForm');
Route::post(config('crudbooster.ADMIN_PATH')."/item_tracking100/get-import-data",'AdminItemTracking100Controller@getDataFromExcel');

Route::get(config('crudbooster.ADMIN_PATH')."/persons/import-data-form",'AdminPersonsController@importDataForm');
Route::post(config('crudbooster.ADMIN_PATH')."/persons/get-import-data",'AdminPersonsController@getDataFromExcel');
Route::get(config('crudbooster.ADMIN_PATH')."/accounts/export",'AdminAccountsController@export');

Route::get(config('crudbooster.ADMIN_PATH')."/inventories/export",'AdminInventoriesController@export');

Route::group(['middleware' => ['web', '\crocodicstudio_voila\crudbooster\middlewares\CBBackend']], function () {
	Route::get(config('crudbooster.ADMIN_PATH')."/database/reset",'ImportController@resetDB');
});
################## For Test ######################
Route::get('/reports/getCustomers/{id}', 'AdminSalesmenReportController@getCustomers');
Route::get('/getFirstChildren/{id}', 'GeneralFunctionsController@getFirstChildernForAccount');
Route::get('/getChildrenBalances/{id}', 'GeneralFunctionsController@getAccountChildernBalances');
Route::get('/getBalancesTest/{id}', 'GeneralFunctionsController@getBalancesTest');
Route::get('/cal_closed_account_balance/{id}', 'GeneralFunctionsController@getClosed_account_balance');
Route::get('/check_inventory_item_quantity/inv{inv}/item{item}/quantity{q}', 'GeneralFunctionsController@getInventoryQauntityItem');

Route::get('/calculateProfitsAndLoss', 'GeneralFunctionsController@calculateProfitsAndLoss');

Route::get('/sendmail', "GeneralFunctionsController@sendmail");

Route::get('/emptyDB', 'GeneralFunctionsController@emptyDBMainTables');
