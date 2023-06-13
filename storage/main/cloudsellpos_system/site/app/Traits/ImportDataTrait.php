<?php
namespace App\Traits;

use App\Http\Controllers\Data\ImportController;
use DB;
use CRUDBooster;
use Request;

trait ImportDataTrait
{

	public function importDataForm()
	{
        $module_path = CRUDBooster::getCurrentModule()->path;
        $example_file = '';
        switch ($module_path) {
            case 'inventories':
                $example_file = 'Inventories.xlsx';
                break;
            case 'item_categories':
                $example_file = 'ItemsCategories.xlsx';
                break;
            case 'items':
                $example_file = 'Items.xlsx';
                break;
            case 'inventory_beginning':
                $example_file = 'InventoryBeginning.xlsx';
                break;
            case 'persons':
                $example_file = 'Customers.xlsx';
                break;
            case 'initial_voucher':
                $example_file = 'InitialVouchers.xlsx';
                break;
                  
        }
		$example_file = 'examples/' . $example_file;
		return view('data.import', compact('example_file'));
	}

	public function getDataFromExcel(Request $request)
	{
		$process_method = request()->get('process_method');
		$this->cbLoader();

		if (Request::hasFile('userfile')) {
			$importCtrl = new ImportController();
			$url_filename = $importCtrl->uploadExcelDatafile($request);
			$result = $importCtrl->importDataforModule($url_filename, $process_method);

			$reports = $result['reports'];
			$import_status = $result['import_status'];
			return view('data.import', compact('import_status', 'reports'));
		}
		else {
			$import_status = 'failed';
			$reports = array(trans('messages.upload_file_failed_try_again'));
			return view('data.import', compact('import_status', 'reports'));
		}

	}

}