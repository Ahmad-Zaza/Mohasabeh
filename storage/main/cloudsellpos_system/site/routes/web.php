<?php

use Illuminate\Support\Facades\Route;

header("Content-Type: text/html");
/*
|------------------------------------------------------------------------|
Web Routes
|-------------------------------------------------------------------------- |
| Here is where you can register web routes for your application. These |
routes are loaded by the RouteServiceProvider within a group which |
contains the "web" middleware group. Now create something great! |
 */

$base_url = config('crudbooster.ADMIN_PATH');
\LaravelLocalization::setLocale(config('setting.LANG'));

Route::get('/clear-cache', function () {
    \Artisan::call('cache:clear');
    Artisan::call('config:clear');
    \Artisan::call('route:clear');
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

Route::group(['middleware' => ['\crocodicstudio_voila\crudbooster\middlewares\CBBackend']], function () use ($base_url) {

    Route::get('lang/{locale}', function ($locale) {
        \App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    });

    //requests
    Route::post($base_url . '/sort', "General\SortingModelController@sorting");
    Route::get($base_url . '/seo/{model}/{model_id?}', 'General\SEOController@get');
    Route::post('/seo-store/{model}', 'General\SEOController@store');

    //images manage
    Route::get('/manage-image/resize/{width?}/{height?}/{img}', function ($width = 100, $height = 100, $img) {
        return \Image::make(public_path("$img"))->resize($width, $height)->response('jpg');
    }
    )->name('manage-image-resize')->where('img', '(.*)');

    Route::get('/manage-image/crop/{width?}/{height?}/{img}', function ($width = 100, $height = 100, $img) {
        return \Image::make(public_path("$img"))->crop($width, $height)->response('jpg');
    }
    )->name('manage-image-crop')->where('img', '(.*)');

    ################################## Bills ############################################
    Route::post('/bill/check', "Bills\BillsPurchaseInvoiceController@checkBox");
    Route::get('/items/getPrice/{id}', 'General\BillsFunctionsController@getPriceById');
    Route::get('/items/getPrice/currency{currency}/item{id}/customer{customer}', 'General\BillsFunctionsController@getItemPriceByIdForCustomer');
    Route::get('/items/getPurchasePrice/currency{currency}/item{id}/suplier{suplier}', 'General\BillsFunctionsController@getItemPriceByIdForSupplier');
    Route::get('/bills/getItems', 'General\BillsFunctionsController@getItems');
    Route::get('/bills/getInventoryByDelegate/{id}', 'General\BillsFunctionsController@getInventoryByDelegate');
    Route::get('/bills/check_bill_number_unique/num{bill_number}/id{id}/type{bill_type}', 'Bills\BillsSalesInvoiceController@check_bill_number_unique');
    Route::get('/inventory/items/{id}', 'General\BillsFunctionsController@getInventoryItems');

    Route::get('/inventory/items/{id}/bill{editID}', 'General\BillsFunctionsController@getInventoryItems');

    Route::get('/inventory{inv}/item{id}/check/qty{qty}', 'General\BillsFunctionsController@checkInventoryItem');

    Route::get('/delegate/inventories/{id}', 'General\BillsFunctionsController@getDelegateInventories');

    ################################ Vouchers ############################################
    Route::get('/voucher/checkBox/{currency_id}/{amount}/{editedID}', 'General\VouchersFunctionsController@checkBoxBalance');
    Route::get('/voucherTransfer/checkBox/{currency_id}/{amount}/{account_id}/{editedID}', 'General\VouchersFunctionsController@checkAccountBalance');
    Route::get('/currency/getEx_rate/{id}', 'General\CurrenciesFunctionsController@getExchangeRate');
    Route::get('/voucher/getOppositeEx_rate/{currency_id}/{opposite}', 'General\CurrenciesFunctionsController@getOppositeExchangeRate');
    Route::get('/vouchers/check_voucher_number_unique/num{voucher_number}/id{id}/type{voucher_type}', 'Vouchers\InitialVoucherController@check_voucher_number_unique');
    Route::get('/voucher/calculateAmountAfterOpposite/{amount}/{currency_id}/{opposite}/{ex_rate}', 'General\VouchersFunctionsController@calculateVoucherAmountAfterOppositeTransfer');

    Route::get('/voucherTransfer/confirm_receipt_amount/{id}', 'General\VouchersFunctionsController@confirmReceiptAmount');
    ################################## Items ############################################
    Route::get('/items/getUnit/{id}', 'General\ItemsFunctionsController@getItemUnit');

    ############################### Inventories ############################################
    Route::get('/inventory{inv}/item{item_id}/check/edit/qty{qty}/transfer{id}', 'Inventories\TransferItemsController@checkInventoryItemEditQty');
    Route::get('/ib/fixOldData', 'Inventories\InventoryBeginningController@fixOldData');

    Route::get('/TransferTracking/confirm_receipt_items/{id}/{items_track_ids}', 'General\InventoriesFunctionsController@confirmReceiptItems');
    Route::get('/TransferTracking/addNote/id{id}/user{user_id}/note{msg}', 'General\InventoriesFunctionsController@addNoteToReceiptItemsNotification');
    Route::get('/modules/transfer_items/notes/{id}', 'Inventories\TransferItemsController@showNotes');
    ################################ Accounts ############################################
    Route::get('/delegate/getCustomers_account_id/{id}', 'Accounts\CustomersController@getCustomers_account_id');
    Route::get('/delegate/getDelegate_id/{id}', 'Accounts\CustomersController@getDelegate_id');

    Route::get(config('crudbooster.ADMIN_PATH') . "/users/display-roles", 'Users\UsersController@displayRoles');
    ################################# Reports ############################################
    Route::post('/reports/getDealCurrencies/{account_id}', 'Reports\AccountstatementController@getDealCurrencies');

    ## Export to Execel file ##
    Route::get(config('crudbooster.ADMIN_PATH') . "/inventory_accounting/export/{filter}", 'Reports\InventoryAccountingController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/item_movement/export/{filter}", 'Reports\ItemMovementController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/general_entry_record/export/{filter}", 'Reports\GeneralEntryRecordController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/account_statement/export/{filter}", 'Reports\AccountstatementController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/account/export/{filter}", 'Reports\AccountReportController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/closing_accounts/export/{filter}", 'Reports\ClosingAccountsController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/salesmen/export/{filter}", 'Reports\SalesmenReportController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/entries_history/export/{filter}", 'Reports\EntriesHistoryController@export');
    ## Print Report ##
    Route::get(config('crudbooster.ADMIN_PATH') . "/inventory_accounting/print/{filter}", 'Reports\InventoryAccountingController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/item_movement/print/{filter}", 'Reports\ItemMovementController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/general_entry_record/print/{filter}", 'Reports\GeneralEntryRecordController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/account_statement/print/{filter}", 'Reports\AccountstatementController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/account/print/{filter}", 'Reports\AccountReportController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/closing_accounts/print/{filter}", 'Reports\ClosingAccountsController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/salesmen/print/{filter}", 'Reports\SalesmenReportController@print');
    Route::get(config('crudbooster.ADMIN_PATH') . "/entries_history/print/{filter}", 'Reports\EntriesHistoryController@print');
    ## Load More ##
    Route::get(config('crudbooster.ADMIN_PATH') . "/inventory_accounting/loadmore/offset{offset}/limit{limit}/{filter}", 'Reports\InventoryAccountingController@loadmore');
    Route::get(config('crudbooster.ADMIN_PATH') . "/item_movement/loadmore/offset{offset}/limit{limit}/subtotal{subtotal}/{filter}", 'Reports\ItemMovementController@loadmore');
    Route::get(config('crudbooster.ADMIN_PATH') . "/account/loadmore/offset{offset}/limit{limit}/sumbalance{sumbalance}/{filter}", 'Reports\AccountReportController@loadmore');
    Route::get(config('crudbooster.ADMIN_PATH') . "/account_statement/loadmore/offset{offset}/limit{limit}/sumbalance{sumbalance}/{filter}", 'Reports\AccountstatementController@loadmore');

    ############################### Statistics ############################################
    Route::get(config('crudbooster.ADMIN_PATH') . "/salesmen/statistics", 'Statistics\StatisticsController@getSalesmenStatistics');
    Route::get(config('crudbooster.ADMIN_PATH') . "/viewer/statistics", 'Statistics\StatisticsController@getAdminStatistics');
    Route::get(config('crudbooster.ADMIN_PATH') . "/manager/statistics", 'Statistics\StatisticsController@getManagerStatistics');
    Route::get(config('crudbooster.ADMIN_PATH') . "/salesmanager/statistics", 'Statistics\StatisticsController@getSalesManagerStatistics');
    Route::get(config('crudbooster.ADMIN_PATH') . "/factory_delegate/statistics", 'Statistics\StatisticsController@getFactoryDelegateStatistics');
    Route::get(config('crudbooster.ADMIN_PATH') . "/factory_cashier/statistics", 'Statistics\StatisticsController@getFactoryCashierStatistics');

    Route::get(config('crudbooster.ADMIN_PATH') . "/admin/statistics", 'Statistics\StatisticsController@getAdminStatistics');
    Route::get(config('crudbooster.ADMIN_PATH') . "/admin/statistics/setting", 'Statistics\StatisticsController@getAdminStatisticsSetting');
    Route::get(config('crudbooster.ADMIN_PATH') . "/admin/statistics/setting/edit/{data}", 'Statistics\StatisticsController@editStatisticsSetting');
    ################################ General ############################################
    Route::get('/inventories/getItems', 'General\GeneralFunctionsController@getItems');
    Route::get('/bill-items/{id}', 'General\GeneralFunctionsController@getBillItemsDetails');
    Route::get('/persons/getParentAccount/{id}', 'General\GeneralFunctionsController@getParentAccount');
    Route::post('/currencies/getDefaultCurrency', 'General\CurrenciesFunctionsController@getDefaultCurrency');
    Route::get('/getDelegateNameByPersonId/{id}', 'General\GeneralFunctionsController@getDelegateNameByPersonId');

    Route::get('/find-data', 'General\GeneralFunctionsController@findData');

    ##################### Import data from excel file ########################

    Route::get(config('crudbooster.ADMIN_PATH') . "/initial_voucher/import-data-form", 'Vouchers\InitialVoucherController@importDataForm')->name('Import-Data-Form');
    Route::post(config('crudbooster.ADMIN_PATH') . "/initial_voucher/get-import-data", 'Vouchers\InitialVoucherController@getDataFromExcel')->name('get-import-data');

    Route::get(config('crudbooster.ADMIN_PATH') . "/inventories/import-data-form", 'Inventories\InventoriesController@importDataForm');
    Route::post(config('crudbooster.ADMIN_PATH') . "/inventories/get-import-data", 'Inventories\InventoriesController@getDataFromExcel');

    Route::get(config('crudbooster.ADMIN_PATH') . "/item_categories/import-data-form", 'Items\ItemCategoriesController@importDataForm');
    Route::post(config('crudbooster.ADMIN_PATH') . "/item_categories/get-import-data", 'Items\ItemCategoriesController@getDataFromExcel');

    Route::get(config('crudbooster.ADMIN_PATH') . "/items/import-data-form", 'Items\ItemsController@importDataForm');
    Route::post(config('crudbooster.ADMIN_PATH') . "/items/get-import-data", 'Items\ItemsController@getDataFromExcel');

    Route::get(config('crudbooster.ADMIN_PATH') . "/inventory_beginning/import-data-form", 'Inventories\InventoryBeginningController@importDataForm');
    Route::post(config('crudbooster.ADMIN_PATH') . "/inventory_beginning/get-import-data", 'Inventories\InventoryBeginningController@getDataFromExcel');

    Route::get(config('crudbooster.ADMIN_PATH') . "/persons/import-data-form", 'Accounts\CustomersController@importDataForm');
    Route::post(config('crudbooster.ADMIN_PATH') . "/persons/get-import-data", 'Accounts\CustomersController@getDataFromExcel');
    Route::get(config('crudbooster.ADMIN_PATH') . "/accounts/export", 'Accounts\AccountsController@export');

    Route::get(config('crudbooster.ADMIN_PATH') . "/inventories/export", 'Inventories\InventoriesController@export');

    Route::get(config('crudbooster.ADMIN_PATH') . "/item_categories/export", 'Items\ItemCategoriesController@export');
    Route::get(config('crudbooster.ADMIN_PATH') . "/items/export", 'Items\ItemsController@export');

    ################################# Testing ############################################
    Route::group(['middleware' => ['web', '\crocodicstudio_voila\crudbooster\middlewares\CBBackend']], function () {
        Route::get(config('crudbooster.ADMIN_PATH') . "/database/reset", 'Data\ImportController@resetDB');
    });
    Route::get('/reports/getCustomers/{id}', 'Reports\SalesmenReportController@getCustomers');
    Route::get('/getFirstChildren/{id}', 'General\GeneralFunctionsController@getFirstChildernForAccount');
    Route::get('/getChildrenBalances/{id}', 'General\GeneralFunctionsController@getAccountChildernBalances');
    Route::get('/getBalancesTest/{id}', 'General\GeneralFunctionsController@getBalancesTest');
    Route::get('/cal_closed_account_balance/{id}', 'General\GeneralFunctionsController@getClosed_account_balance');
    Route::get('/check_inventory_item_quantity/inv{inv}/item{item}/quantity{q}', 'General\GeneralFunctionsController@getInventoryQauntityItem');
    Route::get('/calculateProfitsAndLoss', 'General\GeneralFunctionsController@calculateProfitsAndLoss');
    Route::get('/sendmail', "General\GeneralFunctionsController@sendmail");
    Route::get('/emptyMainTablesDB', 'General\GeneralFunctionsController@emptyDBMainTables');

    Route::get('/checkBeforeDelete/{path}/{id}', 'General\GeneralFunctionsController@checkBeforeDelete');

    ######################### Backups #################################
    Route::get(config('crudbooster.ADMIN_PATH') . "/backups_management/create", 'Data\BackupsManagementController@createBackup');
    Route::get(config('crudbooster.ADMIN_PATH') . "/backups_management/restore/{id}", 'Data\BackupsManagementController@restoreBackup');
    Route::post('/backup/create', 'Data\BackupController@createBackupDB');
    Route::get('/backup/restore/{id}', 'Data\BackupController@restoreBackupDB');

    ######################### Mohasabeh Configrations #######################
    Route::get("/mohasabeh_configration/sendDomainRequest/{domain}/{msg?}", 'Configration\MohasabehConfigrationController@sendDomainRequest');
    Route::get("/mohasabeh_configration/mailMohasabehTeam/{msg}", 'Configration\MohasabehConfigrationController@mailMohasabehTeam');
    Route::get("/mohasabeh_configration/renewal_request/{period}/{msg}", 'Configration\MohasabehConfigrationController@sendRenewalRequest');

    ######################## Rotate Data ################################
    Route::post(config('crudbooster.ADMIN_PATH') . '/rotate_data/continue_rotate_data', 'Data\RotateDataController@continue_rotate_data');
    Route::get(config('crudbooster.ADMIN_PATH') . '/rotate_data/result', 'Data\RotateDataController@showResult');

    Route::get('/rotate_data', 'General\RotateDataFunctionsController@rotate_data');
    Route::get('/rotate_data/check_date/{rotate_date}', 'General\RotateDataFunctionsController@checkRotateDate');

    ######################## Financial Cycles ################################
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/settings/{id}', 'FinancialCycles\FinancialCyclesController@showSettings');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/result/{id}', 'FinancialCycles\FinancialCyclesController@showResult');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/history/{id}', 'FinancialCycles\FinancialCyclesController@showActionsHistory');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/display/{id}', 'FinancialCycles\FinancialCyclesController@displayCycle');

    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/goBackToCurrentCycle', 'FinancialCycles\FinancialCyclesController@goBackToCurrentCycle')->name('goBackToCurrentCycle');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/reCalculateData', 'FinancialCycles\FinancialCyclesController@reCalculateData');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/reCalculateData/{edit_cycle}', 'FinancialCycles\FinancialCyclesController@reCalculateData');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/saveReCalculateDataResult/options/{options}', 'FinancialCycles\FinancialCyclesController@saveReCalculateDataResult');
    Route::get(config('crudbooster.ADMIN_PATH') . '/financial_cycles/IgnoreReCalculateData', 'FinancialCycles\FinancialCyclesController@IgnoreReCalculateData');

    ############################ System Settings ################################
    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/temp_stop', 'Configration\SystemSettingsController@changeTempStop');
    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/temp_stop/edit/{data}', 'Configration\SystemSettingsController@editTempStopStatus');

    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/images_settings', 'Configration\SystemSettingsController@changeImagesSettings');
    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/images_settings/edit/{data}', 'Configration\SystemSettingsController@editImagesSettings');

    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/bills_settings', 'Configration\SystemSettingsController@changeBillsSettings');
    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/bills_settings/edit/{data}', 'Configration\SystemSettingsController@editBillsSettings');

    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/lock_url', 'Configration\SystemSettingsController@lockSystemURL');
    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/lock_url/lock', 'Configration\SystemSettingsController@makeSystemUrlLocked');

    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/https_setting', 'Configration\SystemSettingsController@getHttpsSettings');
    Route::get(config('crudbooster.ADMIN_PATH') . '/system_settings/https_setting/edit', 'Configration\SystemSettingsController@editHttpsSettings');

    ################################ Test Models ##########################

    Route::get('/test', 'General\TestModels@test');
    Route::get('/fixOldEdited', 'General\TestModels@fixOldEditedBillsAndVouchers');
    Route::get('/fixOldDataAction', 'General\TestModels@fixedEditedDeletedActionOldData');

    Route::get('/initial_vouchers_fixOldData', 'Vouchers\InitialVoucherController@fixOldData');

    /*
//fix initial vouchers list
Route::get('/fixInitialVouchersList', 'General\TestModels@fixInitialVouchersList');

// that must step by step
Route::get('/fixAllDeletedRecords', 'General\TestModels@fixAllDeletedRecords');
Route::get('/deleteAllEditedDeletedRecords', 'General\TestModels@deleteAllEditedDeletedRecords');
Route::get('/fixEditedFieldsForBillsAndVouchers', 'General\TestModels@fixEditedFieldsForBillsAndVouchers');
 */

});

############################### Actice System #########################
Route::get('/unlock/system/{token}', 'Configration\SystemSettingsController@unLockSystemURL');
