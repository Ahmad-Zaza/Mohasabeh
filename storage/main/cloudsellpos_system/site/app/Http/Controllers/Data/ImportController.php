<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Data;

use App\Models\Bills\Bill;
use App\Models\Bills\BillFile;
use App\Models\Bills\BillItem;
use App\Models\Currencies\CurrencyHistory;
use App\Models\FinancialCycles\FinancialCycle;
use App\Models\FinancialCycles\ReCalculateCycleHistory;
use App\Models\Inventories\TransferTracking;
use App\Models\Inventories\TransferTrackingList;
use App\Models\RotateData\RotateDataResult;
use App\Models\SystemConfigration\SystemSetting;
use App\Models\Vouchers\InitialVouchersGroup;
use App\Models\Vouchers\InitialVouchersList;
use App\Models\Vouchers\VoucherFile;
use CRUDBooster;
use App\Models\Accounts\Account;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Inventories\Inventory;
use App\Models\Items\ItemCategory;
use App\Models\Items\ItemUnit;
use App\Models\Items\Item;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Accounts\Person;
use App\Models\Vouchers\Voucher;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\General\Controller;
use App\Models\Users\User;
use App\Models\Currencies\Currency;
use App\Models\SystemConfigration\StatisticSetting;
use App\Models\Inventories\BeginningTrackingList;
use App\Models\Inventories\BeginningTracking;
use Session;

class ImportController extends Controller
{

    //------------------------------- Import Data Function ---------------------------

    //upload excel file and save it in storage folder
    //return name of uploaded file
    public function uploadExcelDatafile(Request $request)
    {
        $file = Request::file('userfile');
        $ext = $file->getClientOriginalExtension();

        $validator = Validator::make([
            'extension' => $ext,
        ], [
            'extension' => 'in:xls,xlsx,csv',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect()->back()->with(['message' => implode('<br/>', $message), 'message_type' => 'warning']);
        }

        //Create Directory Monthly
        $filePath = 'uploads/' . CRUDBooster::myId() . '/' . date('Y-m');
        Storage::makeDirectory($filePath);

        //Move file to storage
        $filename = md5(str_random(5)) . '.' . $ext;
        $url_filename = '';
        if (Storage::putFileAs($filePath, $file, $filename)) {
            $url_filename = $filePath . '/' . $filename;
        }
        return $url_filename;
    }

    //read uploaded file and insert data to database
    public function importDataforModule($file, $process_method = 1)
    {
        set_time_limit(1000000);
        $module = CRUDBooster::getCurrentModule();
        //dd($module);

        $result = Excel::load(storage_path("app/" . $file))->toObject();
        $result = collect($result);
        //dd($result);
        $module_path = $module->path;

        $reports = array();
        $import_status = "success";
        $importing_num = 0;
        $errors_record_num = 0;
        $similarity_record_num = 0;
        if (count($result) == 0) {
            array_push($reports, trans('messages.file_doesnot_have_data'));
            $import_status = "failed";
        }

        if (count($result) > 0) {

            if ($module_path == 'inventories') {
                foreach ($result as $item) {
                    $inventory = new Inventory();
                    $inventory->name_en = $item["alasm_alenklyzy"];
                    $inventory->name_ar = $item["alasm_alaarby"];
                    $inventory->code = $item["alrmz"];

                    $delegate_account_id = Account::where('code', $item["rmz_hsab_sndok_almndob"])->first()->id;
                    $delegate_id = User::where('account_id', $delegate_account_id)->first()->id;
                    $inventory->delegate_id = $delegate_id;

                    $inventory->major_classification = $item["hl_ho_reysy_naam_1_la_0"] ? 1 : 0;

                    if ($item["rmz_almstodaa_alab"]) {
                        $parent = Inventory::where('code', $item["rmz_almstodaa_alab"])->first()->id;
                        $inventory->parent_id = $parent;
                    }
                    $inventory->note = "";

                    $inventory->save();

                    $importing_num += 1;
                }
            }
            else if ($module_path == 'item_categories') {
                foreach ($result as $index => $item) {
                    if ($item["alasm_alaarby"] != "" && $item["alrmz"] != "") {
                        $similarity_res = $this->checkSimilarityRecord($module_path, $item);
                        $found_status = $similarity_res['found_status'];
                        if (!$found_status) {
                            $item_cat = new ItemCategory();
                            $item_cat->name_en = $item["alasm_alenklyzy"];
                            $item_cat->name_ar = $item["alasm_alaarby"];
                            $item_cat->code = $item["alrmz"];
                            $item_cat->major_classification = 1;

                            if ($item["rmz_altsnyf_alab"]) {
                                $parent = ItemCategory::where('code', $item["rmz_altsnyf_alab"])->first()->id;
                                $item_cat->parent_id = $parent;
                            }

                            $item_cat->save();
                            $importing_num += 1;
                        }
                        else {
                            $similarity_record_num += 1;
                            $found_record_id = $similarity_res['found_record_id'];
                            if ($process_method == 2) { //استبدال
                                $this->replaceSimilarityRecord($module_path, $found_record_id, $item);
                                $record_num = $index + 2;
                                array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.thers_are_similar_data_so_replace_its'));
                            }
                            else {
                                $record_num = $index + 2;
                                array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_are_similar_data_so_ignor_it'));
                            }
                        }

                    }
                    else {
                        $record_num = $index + 2;
                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.some_field_doesnot_have_values'));
                        $errors_record_num++;
                    }
                }
            }
            else if ($module_path == 'items') {
                $max = Item::max('code');
                $code = ($max) ? $max : 0;
                foreach ($result as $index => $item) {
                    if ($item["alasm_alaarby"] != "" || $item["rmz_tsnyf_almoad"] != "") {
                        $item_category = ItemCategory::where('code', $item["rmz_tsnyf_almoad"])->first()->id;
                        if ($item_category) {
                            $similarity_res = $this->checkSimilarityRecord($module_path, $item);
                            $found_status = $similarity_res['found_status'];
                            if (!$found_status) {

                                $itemImport = new Item();
                                $itemImport->name_en = $item["alasm_alenklyzy"];
                                $itemImport->name_ar = $item["alasm_alaarby"];
                                $code = $code + 1;

                                $itemImport->code = $code;
                                $item_generate_code = sprintf('%05d', $code);
                                $itemImport->p_code = $item["rmz_tsnyf_almoad"] . $item_generate_code;

                                $itemImport->item_number = ($item["rkm_almad"] != null) ? $item["rkm_almad"] : '';


                                $itemImport->item_category_id = $item_category;

                                $item_unit = ItemUnit::where('name_ar', $item["alohd"])->first()->id;
                                if ($item_unit) {
                                    $itemImport->item_unit_id = $item_unit;
                                }
                                else { //item unit don't found
                                    $unit_id = ItemUnit::insertGetId([
                                        'name_en' => "",
                                        'name_ar' => $item["alohd"],
                                        "active" => 1
                                    ]);
                                    $itemImport->item_unit_id = $unit_id;
                                }

                                $itemImport->cost = $item["altklf"];
                                $itemImport->price = $item["alsaar"];

                                $itemImport->timestamps = false;

                                $itemImport->save();

                                $importing_num += 1;
                            }
                            else {
                                $similarity_record_num += 1;
                                $found_record_id = $similarity_res['found_record_id'];
                                if ($process_method == 2) { //استبدال
                                    $this->replaceSimilarityRecord($module_path, $found_record_id, $item);
                                    $record_num = $index + 2;
                                    array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.thers_are_similar_data_so_replace_its'));
                                }
                                else {
                                    $record_num = $index + 2;
                                    array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_are_similar_data_so_ignor_it'));
                                }
                            }
                        }
                        else {
                            $record_num = $index + 2;
                            array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_is_category_code_wrong'));
                            $errors_record_num++;
                        }
                    }
                    else {
                        $record_num = $index + 2;
                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.some_field_doesnot_have_values'));
                        $errors_record_num++;
                    }

                }

            }
            else if ($module_path == 'inventory_beginning') {
                $max = ItemTracking::where("item_tracking_type_id", 5)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
                $code = ($max) ? $max : 0;

                $invs = array();
                $ib_tracking = array();

                foreach ($result as $index => $item) {
                    if ($item["rmz_almad"] != "") {
                        $item_id = Item::where('p_code', $item["rmz_almad"])->first()->id;
                        $inventory_id = Inventory::where('code', $item["rmz_almstodaa"])->first()->id;

                        if ($item_id) {
                            if ($inventory_id) {
                                $similarity_res = $this->checkSimilarityRecord($module_path, $item);
                                $found_status = $similarity_res['found_status'];
                                if (!$found_status) {
                                    $unit_name = Item::join('item_units', 'item_units.id', 'items.item_unit_id')
                                        ->where('items.id', $item_id)->first()->name_ar;

                                    if (in_array($inventory_id, $invs)) {
                                        //add item tracking record
                                        $itemTrack = new ItemTracking();
                                        $code = $code + 1;
                                        $p_code = "IB-" . $code;
                                        $itemTrack->code = $code;
                                        $itemTrack->p_code = $p_code;
                                        $itemTrack->item_id = $item_id;
                                        $itemTrack->item_tracking_type_id = 5;
                                        $itemTrack->source = $inventory_id;
                                        $itemTrack->quantity = $item["alaadd"];
                                        $itemTrack->transaction_operation = "in";
                                        $itemTrack->date = date('Y-m-d h:i:s');
                                        $itemTrack->timestamps = false;
                                        $itemTrack->cycle_id = Session::get('display_cycle');
                                        $itemTrack->save();

                                        BeginningTrackingList::insertGetId([
                                            'ib_tracking_id' => $ib_tracking["$inventory_id"],
                                            'item_id' => $item_id,
                                            'item_unit' => $unit_name,
                                            'quantity' => $item["alaadd"],
                                            'p_code' => $p_code,
                                            'cycle_id'=>Session::get('display_cycle')
                                        ]
                                        );

                                    }
                                    else {
                                        $ib_index = BeginningTracking::insertGetId([
                                            'ib_number' => '',
                                            'source' => $inventory_id,
                                            'note' => trans('labels.import_beginning_items'),
                                            'date' => date('Y-m-d h:i:s'),
                                            'staff_id' => 1,
                                            'cycle_id'=>Session::get('display_cycle')
                                        ]
                                        );
                                        array_push($invs, $inventory_id);
                                        $ib_tracking["$inventory_id"] = $ib_index;

                                        //add item tracking record
                                        $itemTrack = new ItemTracking();
                                        $code = $code + 1;
                                        $p_code = "IB-" . $code;
                                        $itemTrack->code = $code;
                                        $itemTrack->p_code = $p_code;
                                        $itemTrack->item_id = $item_id;
                                        $itemTrack->item_tracking_type_id = 5;
                                        $itemTrack->source = $inventory_id;
                                        $itemTrack->quantity = $item["alaadd"];
                                        $itemTrack->transaction_operation = "in";
                                        $itemTrack->date = date('Y-m-d h:i:s');
                                        $itemTrack->timestamps = false;
                                        $itemTrack->cycle_id = Session::get('display_cycle');
                                        $itemTrack->save();

                                        BeginningTrackingList::insertGetId([
                                            'ib_tracking_id' => $ib_tracking["$inventory_id"],
                                            'item_id' => $item_id,
                                            'item_unit' => $unit_name,
                                            'quantity' => $item["alaadd"],
                                            'p_code' => $p_code,
                                            'cycle_id'=>Session::get('display_cycle')
                                        ]
                                        );

                                    }

                                    $importing_num += 1;
                                }
                                else {
                                    $similarity_record_num += 1;
                                    $found_record_id = $similarity_res['found_record_id'];
                                    if ($process_method == 2) { //استبدال
                                        $this->replaceSimilarityRecord($module_path, $found_record_id, $item);
                                        $record_num = $index + 2;
                                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.thers_are_similar_data_so_replace_its'));
                                    }
                                    else {
                                        $record_num = $index + 2;
                                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_are_similar_data_so_ignor_it'));
                                    }
                                }
                            }
                            else {
                                $record_num = $index + 2;
                                array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_is_inventory_code_wrong'));
                                $errors_record_num++;
                            }

                        }
                        else {
                            $record_num = $index + 2;
                            array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_is_item_code_wrong'));
                            $errors_record_num++;
                        }

                    }
                    else {
                        $record_num = $index + 2;
                        array_push($reports, trans('messages.record') . " [$record_num]" . trans('messages.some_field_doesnot_have_values'));
                        $errors_record_num++;
                    }
                }
            }
            else if ($module_path == 'persons') { //الزبائن
                foreach ($result as $index => $item) {
                    if ($item['rmz_hsab_zbaen_almndob'] != "" || $item['alasm_alaarby'] != "") {
                        $similarity_res = $this->checkSimilarityRecord($module_path, $item);
                        $found_status = $similarity_res['found_status'];
                        if (!$found_status) {
                            $person = new Person();
                            $person->name_en = $item["alasm_alenklyzy"];
                            $person->name_ar = $item["alasm_alaarby"];
                            $person->email = $item["alaymyl"];
                            $person->phone_number = $item["rkm_alhatf"];
                            $parent_id = Account::where('code', $item['rmz_hsab_zbaen_almndob'])->first()->id;
                            if (!$parent_id) {
                                $parent_id = 2; //id = 2 customers account id
                            }
                            //-----------
                            $code = Account::getCode($parent_id);
                            $person->code = $code;
                            $accountId = Account::insertGetId([
                                'name_en' => $item['alasm_alenklyzy'],
                                'name_ar' => $item['alasm_alaarby'],
                                'code' => $code,
                                'parent_id' => $parent_id,
                                'major_classification' => 0,
                                "active" => 1
                            ]);
                            $person->timestamps = false;
                            $person->account_id = $accountId;
                            $person->person_type_id = 1;

                            $delegate_id = User::where('customers_account_id', $parent_id)->first()->id;
                            if ($delegate_id) {
                                $person->delegate_id = $delegate_id;
                            }

                            $person->save();

                            $importing_num += 1;
                        }
                        else {
                            $similarity_record_num += 1;
                            $found_record_id = $similarity_res['found_record_id'];
                            if ($process_method == 2) { //استبدال
                                $this->replaceSimilarityRecord($module_path, $found_record_id, $item);
                                $record_num = $index + 2;
                                array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.thers_are_similar_data_so_replace_its'));
                            }
                            else {
                                $record_num = $index + 2;
                                array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_are_similar_data_so_ignor_it'));
                            }
                        }
                    }
                    else {
                        $record_num = $index + 2;
                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.some_field_doesnot_have_values'));
                        $errors_record_num++;
                    }
                }

            }
            else if ($module_path == 'initial_voucher') { //الارصدة الافتتاحية
                $iv_group_has_build = false;
                $iv_group_has_build_id = 0;
                $code = Voucher::where("voucher_type_id", 4)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
                foreach ($result as $index => $item) {

                    if ($item['rmz_alhsab'] != "" || $item['rmz_alaaml'] != "" || $item['alrsyd'] != "") {
                        $account_id = Account::where('code', (int)$item["rmz_alhsab"])->first()->id;
                        $currency_id = Currency::where('code', $item["rmz_alaaml"])->first()->id;
                        if ($currency_id) {
                            if ($account_id) {
                                $similarity_res = $this->checkSimilarityRecord($module_path, $item);
                                $found_status = $similarity_res['found_status'];
                                if (!$found_status) {
                                    //create initial voucher
                                    $voucher = new Voucher();
                                    $code = $code + 1;
                                    $voucher->code = $code;

                                    $voucher->p_code = "IV-" . $voucher->code;

                                    $voucher->voucher_number = '';

                                    if ($item['alrsyd'] < 0) {
                                        $voucher->credit = $account_id;
                                        $voucher->debit = 0;
                                    }
                                    else {
                                        $voucher->credit = 0;
                                        $voucher->debit = $account_id;
                                    }
                    
                                    $voucher->voucher_type_id = 4;
                                    $orginal_amount = ($item["alrsyd"] != null) ? $item['alrsyd'] : 0;
                                    $voucher->amount = ($item["alrsyd"] != null) ? abs($item['alrsyd']) : 0;

                                    $voucher->currency_id = $currency_id;

                                    $ex_rate = ($item["saar_alsrf"] != null) ? $item["saar_alsrf"] : 0;
                                    if ($ex_rate == 0) {
                                        $ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
                                    }
                                    $voucher->ex_rate = $ex_rate;
                                    $voucher->equalizer = $voucher->amount * $ex_rate;

                                    $voucher->staff_id = 1;
                                    $voucher->narration = "سند افتتاحي";
                                    $voucher->date = date('Y-m-d h:i:s');
                                    $voucher->cycle_id = Session::get('display_cycle');
                                    $voucher->timestamps = false;

                                    $voucher->save();


                                    //add initial voucher to entry_base && entries table 
                                    $max = EntryBase::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('entry_number');
                                    $entry_number = $max + 1;

                                    $entry_base_id = EntryBase::insertGetId([
                                        'entry_number' => $entry_number,
                                        'narration' => $voucher->narration,
                                        'date' => $voucher->date,
                                        'voucher_id' => $voucher->id,
                                        'active' => 1,
                                        'cycle_id' => Session::get('display_cycle'),
                                        'create_by' => 1
                                    ]);

                                    if ($voucher->debit == 0) {
                                        Entry::insert([
                                            'entry_base_id' => $entry_base_id,
                                            'debit' => null,
                                            'account_id' => $voucher->credit,
                                            'credit' => $voucher->amount,
                                            'ex_rate' => $voucher->ex_rate,
                                            'equalizer' => $voucher->equalizer,
                                            'opposite' => $voucher->opposite,
                                            'currency_id' => $voucher->currency_id,
                                            'cycle_id' => Session::get('display_cycle'),
                                            'create_by' => 1
                                        ]);
                                    }
                                    else {
                                        Entry::insert([
                                            'entry_base_id' => $entry_base_id,
                                            'debit' => $voucher->amount,
                                            'account_id' => $voucher->debit,
                                            'credit' => null,
                                            'ex_rate' => $voucher->ex_rate,
                                            'equalizer' => $voucher->equalizer,
                                            'opposite' => $voucher->opposite,
                                            'currency_id' => $voucher->currency_id,
                                            'cycle_id' => Session::get('display_cycle'),
                                            'create_by' => 1
                                        ]);
                                    }
                                    //build initial vouchers group when add first initial voucher
                                    if($iv_group_has_build == false){ 
                                        $iv_group_id = InitialVouchersGroup::insertGetId([
                                            'voucher_number' => '',
                                            'narration' => trans('labels.import_initial_vouchers'),
                                            'date'=>date('Y-m-d h:i:s'),
                                            'staff_id'=>1,
                                            'cycle_id' => Session::get('display_cycle')
                                        ]);
                                        $iv_group_has_build = true;
                                        $iv_group_has_build_id = $iv_group_id;
                                    }
                                    

                                    InitialVouchersList::insertGetId([
                                        'iv_group_id' => $iv_group_has_build_id,
                                        'account_id' => $account_id,
                                        'currency_id' => $currency_id,
                                        'amount' => $orginal_amount,
                                        'p_code' => $voucher->p_code,
                                        'cycle_id' => Session::get('display_cycle')
                                    ]);

                                    $importing_num += 1;
                                }
                                else {
                                    $similarity_record_num += 1;
                                    $found_record_id = $similarity_res['found_record_id'];
                                    if ($process_method == 2) { //استبدال
                                        $this->replaceSimilarityRecord($module_path, $found_record_id, $item);
                                        $record_num = $index + 2;
                                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.thers_are_similar_data_so_replace_its'));
                                    }
                                    else {
                                        $record_num = $index + 2;
                                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_are_similar_data_so_ignor_it'));
                                    }
                                }

                            }
                            else {
                                $record_num = $index + 2;
                                array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_is_account_code_wrong'));
                                $errors_record_num++;
                            }
                        }
                        else {
                            $record_num = $index + 2;
                            array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.there_is_currency_code_wrong'));
                            $errors_record_num++;
                        }

                    }
                    else {
                        $record_num = $index + 2;
                        array_push($reports, trans('messages.record') . " [$record_num] " . trans('messages.some_field_doesnot_have_values'));
                        $errors_record_num++;
                    }

                }
            }


        } //end main if

        if ($errors_record_num > 0) {
            array_push($reports, trans('messages.imported_records_errors_count_is'). ' ' . $errors_record_num);
        }
        if ($similarity_record_num > 0) {
            if ($process_method == 1) {
                array_push($reports, trans('messages.similarity_records_count_and_ignor_its_is') . ' ' . $similarity_record_num);
            }
            else {
                array_push($reports, trans('messages.similarity_records_count_and_replace_its_is') . ' ' . $similarity_record_num);
            }

        }

        array_push($reports, trans('messages.imported_records_count_is') . ' ' . $importing_num);



        return array(
            'import_status' => $import_status,
            'reports' => $reports,
        );
    }


    public function checkSimilarityRecord($module_path, $item)
    {
        $id = 0;
        switch ($module_path) {
            case 'item_categories':
                $id = ItemCategory::where('code', $item["alrmz"])->first()->id;
                break;
            case 'items':
                $id = Item::where('name_ar', $item["alasm_alaarby"])->first()->id;
                break;
            case 'inventory_beginning':
                $item_id = Item::where('p_code', $item["rmz_almad"])->first()->id;
                $inventory_id = Inventory::where('code', $item["rmz_almstodaa"])->first()->id;
                $conditions = array(['item_tracking.action', '=', NULL],['item_tracking.cycle_id','=',Session::get('display_cycle')]);
                $id = ItemTracking::where('item_tracking_type_id', 5)
                    ->where('item_id', $item_id)
                    ->where('source', $inventory_id)
                    ->where($conditions)
                    ->first()->id;
                break;
            case 'persons':
                $delegate_customers_account_id = Account::where('code', $item['rmz_hsab_zbaen_almndob'])->first()->id;
                $delegate_id = User::where('customers_account_id', $delegate_customers_account_id)->first()->id;
                $id = Person::where('name_ar', $item["alasm_alaarby"])->where('delegate_id', $delegate_id)->first()->id;
                break;
            case 'initial_voucher':
                $account_id = Account::where('code', (int)$item["rmz_alhsab"])->first()->id;
                $currency_id = Currency::where('code', $item["rmz_alaaml"])->first()->id;
                $conditions = array(['vouchers.action', '=', NULL],['vouchers.cycle_id', '=', Session::get('display_cycle')]);

                $id = Voucher::where('voucher_type_id', 4)->where('debit', $account_id)
                    ->where('currency_id', $currency_id)
                    ->where($conditions)
                    ->orwhere('credit', $account_id)
                    ->where('currency_id', $currency_id)
                    ->where($conditions)
                    ->first()->id;

                // if($item['alrsyd'] > 0){
                //     $id = Voucher::where('voucher_type_id', 4)->where('debit', $account_id)
                //     ->where('currency_id', $currency_id)
                //     ->where($conditions)
                //     ->first()->id;
                // }else{
                //     $id = Voucher::where('voucher_type_id', 4)->where('credit', $account_id)
                //     ->where('currency_id', $currency_id)
                //     ->where($conditions)
                //     ->first()->id;
                // }
                break;


        }

        if ($id && $id != 0) {
            return array('found_status' => true, 'found_record_id' => $id);
        }
        else {
            return array('found_status' => false, 'found_record_id' => 0);
        }

    }

    public function replaceSimilarityRecord($module_path, $found_record_id, $item)
    {
        switch ($module_path) {
            case 'item_categories':
                if ($item["rmz_altsnyf_alab"]) {
                    $parent_id = ItemCategory::where('code', $item["rmz_altsnyf_alab"])->first()->id;
                }
                $data = array(
                    'name_en' => $item["alasm_alenklyzy"],
                    'name_ar' => $item["alasm_alaarby"],
                    'parent_id' => $parent_id,
                );
                ItemCategory::whereId($found_record_id)->update($data);
                break;

            case 'items':
                $item_number = ($item["rkm_almad"] != null) ? $item["rkm_almad"] : '';
                $item_category_id = ItemCategory::where('code', $item["rmz_tsnyf_almoad"])->first()->id;
                $item_unit_id = 0;
                $item_unit = ItemUnit::where('name_ar', $item["alohd"])->first()->id;
                if ($item_unit) {
                    $item_unit_id = $item_unit;
                }
                else { //item unit don't found
                    $unit_id = ItemUnit::insertGetId([
                        'name_en' => "",
                        'name_ar' => $item["alohd"],
                        "active" => 1
                    ]);
                    $item_unit_id = $unit_id;
                }
                $data = array(
                    'name_en' => $item["alasm_alenklyzy"],
                    'name_ar' => $item["alasm_alaarby"],
                    'item_number' => $item_number,
                    'item_category_id' => $item_category_id,
                    'item_unit_id' => $item_unit_id,
                    'cost' => $item["altklf"],
                    'price' => $item["alsaar"],
                );
                Item::whereId($found_record_id)->update($data);
                break;

            case 'persons':
                $data = array(
                    'name_en' => $item["alasm_alenklyzy"],
                    'name_ar' => $item["alasm_alaarby"],
                    'email' => $item["alaymyl"],
                    'phone_number' => $item["rkm_alhatf"],
                );
                Person::whereId($found_record_id)->update($data);
                break;

            case 'inventory_beginning':
                $data = array(
                    'quantity' => $item["alaadd"],
                );
                ItemTracking::whereId($found_record_id)->update($data);

                $p_code = ItemTracking::where('id', $found_record_id)->first()->p_code;
                BeginningTrackingList::where('p_code', $p_code)->where('cycle_id',Session::get('display_cycle'))->update([
                    'quantity' => $item["alaadd"]
                ]);
                break;

            case 'initial_voucher':
                $amount = ($item["alrsyd"] != null) ? $item["alrsyd"] : 0;
                $ex_rate = ($item["saar_alsrf"] != null) ? $item["saar_alsrf"] : 0;
                $voucher_number = ($item["rkm_alothyk"] != null) ? $item["rkm_alothyk"] : '';

                if ($ex_rate == 0) {
                    $ex_rate = Currency::where('code', $item["rmz_alaaml"])->first()->ex_rate;
                }

                $account_id = Account::where('code', (int)$item["rmz_alhsab"])->first()->id;

                $debit=0;
                $credit=0;
                if($amount > 0){
                    $debit = $account_id;
                }else{
                    $credit = $account_id;
                }
                $data = array(
                    'debit'=>$debit,
                    'credit'=>$credit,
                    'amount' => abs($amount),
                    'voucher_number' => $voucher_number,
                    'ex_rate' => $ex_rate,
                    'equalizer' => abs($amount) * $ex_rate,

                );
                Voucher::whereId($found_record_id)->update($data);

                $entry_base_id = EntryBase::where('voucher_id', $found_record_id)->first()->id;
                $debit_amount=0;
                $credit_amount=0;
                if($amount > 0){
                    $debit_amount = abs($amount);
                }else{
                    $credit_amount = abs($amount);
                }
                Entry::where('entry_base_id', $entry_base_id)->update(array(
                    'debit'=>$debit_amount,
                    'credit'=>$credit_amount,
                    'ex_rate' => $ex_rate,
                    'equalizer' => abs($amount) * $ex_rate,
                ));

                $voucher = Voucher::find($found_record_id);
                InitialVouchersList::where('p_code',$voucher->p_code)->where('account_id',$account_id)->where('cycle_id',Session::get('display_cycle'))->update([
                    'amount'=>$amount
                ]);
                break;

        }
    }

    public function resetDB()
    {
        ItemCategory::truncate();
        echo "Items Categories table is Empty now. done...<br/>";
        Inventory::truncate();
        echo "Inventories table is Empty now. done...<br/>";
        Item::truncate();
        echo "Items table is Empty now. done...<br/>";
        Voucher::truncate();
        echo "Vouchers table is Empty now. done...<br/>";

        VoucherFile::truncate();
        echo "vouchers_files table is Empty now. done...<br/>";

        ItemTracking::truncate();
        echo "Items Tracking table is Empty now. done...<br/>";

        TransferTracking::truncate();
        echo "Transfer Tracking table is Empty now. done...<br/>";

        TransferTrackingList::truncate();
        echo "Transfer Items List table is Empty now. done...<br/>";

        BeginningTracking::truncate();
        echo "Inventory Beginning Tracking table is Empty now. done...<br/>";

        BeginningTrackingList::truncate();
        echo "Inventory Beginning Items List table is Empty now. done...<br/>";

        InitialVouchersGroup::truncate();
        echo "Initial Vouchers Groups table is Empty now. done...<br/>";

        InitialVouchersList::truncate();
        echo "Initial Vouchers List table is Empty now. done...<br/>";


        Person::truncate();
        echo "Persons table is Empty now. done...<br/>";

        Entry::truncate();
        echo "entries table is Empty now. done...<br/>";

        EntryBase::truncate();
        echo "entry_base table is Empty now. done...<br/>";

        Bill::truncate();
        echo "Bills table is Empty now. done...<br/>";

        BillFile::truncate();
        echo "bills_files table is Empty now. done...<br/>";

        BillItem::truncate();
        echo "	bills_items table is Empty now. done...<br/>";

        //-----------------
        Account::truncate();
        echo "Accounts table is Empty now. done...<br/>";

        $accountsQuery = "
        INSERT INTO `accounts` (`id`, `name_en`, `name_ar`, `code`, `parent_id`, `major_classification`, `active`, `sorting`, `closing_account_type`) VALUES
        (1, NULL, 'الأصول', 1, NULL, 1, 1, NULL, NULL),
        (2, NULL, 'الزبائن', 101, 1, 1, 1, NULL, 3),
        (3, NULL, 'حسابات النقدية', 102, 1, 1, 1, NULL, 1),
        (4, NULL, 'الصندوق العام', 10201, 3, 0, 1, NULL, NULL),
        (5, NULL, 'حسابات نقدية المندوبين', 103, 1, 1, 1, NULL, NULL),
        (6, NULL, 'المصروفات', 3, NULL, 1, 1, NULL, 3),
        (7, NULL, 'مصروف سيارة المندوب', 301, 6, 0, 1, NULL, NULL),
        (8, NULL, 'اجور شحن ومصروف مبيعات', 302, 6, 0, 1, NULL, NULL),
        (9, NULL, 'مصاريف مختلفة ', 303, 6, 0, 1, NULL, NULL),
        (10, NULL, 'حسابات المواد', 4, NULL, 1, 1, NULL, NULL),
        (11, NULL, 'مشتريات', 401, 10, 0, 1, NULL, NULL),
        (12, NULL, 'مردود مشتريات', 402, 10, 0, 1, NULL, NULL),
        (13, NULL, 'مبيعات', 403, 10, 0, 1, NULL, NULL),
        (14, NULL, 'مردود مبيعات', 404, 10, 0, 1, NULL, NULL),
        (15, NULL, 'الحسم الممنوح', 405, 10, 0, 1, NULL, NULL),
        (16, NULL, 'الحسم المكتسب', 406, 10, 0, 1, NULL, NULL),
        (17, NULL, 'الإيرادات', 5, NULL, 1, 1, NULL, NULL),
        (18, 'Supplers', 'الموردون', 104, 1, 1, 1, NULL, NULL);
         ";
        //DB::raw($accountsQuery);
        DB::select(DB::raw($accountsQuery));
        echo "Insert main Accounts data to accounts table . done...<br/>";

        Currency::truncate();
        echo "Currencies table is Empty now. done...<br/>";

        CurrencyHistory::truncate();
        echo "currency_history table is Empty now. done...<br/>";


        $currenciesQuery = "
        INSERT INTO `currencies` (`id`, `name_en`, `name_ar`, `code`, `account_id`, `is_major`, `note`, `ex_rate`, `icon`, `color`, `active`, `sorting`) VALUES
        (1, 'S.P', 'ل.س', 'SYP', 4, 1, 'العملة الاساسية', '1.00', 'fa fa-money', 'red', 1, 1)
         ";
        DB::select(DB::raw($currenciesQuery));
        echo "Insert main Currency data to currencies table . done...<br/>";

        StatisticSetting::where('id', 2)->update([
            "value" => '4'
        ]);
        echo "change statistics setting done...<br/>";

        $Query = "TRUNCATE TABLE  inventories_delegates;";
        DB::select(DB::raw($Query));
        echo "inventories_delegates table is Empty now. done...<br/>";

        $Query = "TRUNCATE TABLE  suppliers_delegates;";
        DB::select(DB::raw($Query));
        echo "suppliers_delegates table is Empty now. done...<br/>";


        $cms_usersQuery = "TRUNCATE TABLE  cms_users;";
        DB::select(DB::raw($cms_usersQuery));
        User::truncate();
        echo "CMS Users table is Empty now. done...<br/>";

        $super_admin_pass = '$2y$10$MyiovAMt9R8jmFl4vUUCVO2kw6.q76HWLQJvuUZ.zlZIJCzRpwvDy'; //pass1234
        $cms_usersQuery = "
        INSERT INTO `cms_users` (`id`, `name`, `photo`, `email`, `password`, `id_cms_privileges`, `created_at`, `updated_at`, `status`,  `account_id`, `customers_account_id`) VALUES
        (1, 'Super Admin', '/images/portfolio1_logo.png', 'superadmin@voila.digital', '$super_admin_pass', 1, '2019-05-30 06:06:58', '2020-07-21 12:55:23', 'Active', 0, 0),
        (2, 'Admin', '/images/portfolio1_logo.png', 'admin@voila.digital', '$super_admin_pass', 1, '2019-05-30 06:06:58', '2020-07-21 12:55:23', 'Active', 0, 0);
        ";

        DB::select(DB::raw($cms_usersQuery));
        echo "Insert main Cms Users data to cms_users table . done...<br/>";

        CurrencyHistory::truncate();
        echo "Currency History table is Empty now. done...<br/>";

        RotateDataResult::truncate();
        echo "Rotate Data Cycle Result table is Empty now. done...<br/>";

        ReCalculateCycleHistory::truncate();
        echo "ReCalculate Cycle History table is Empty now. done...<br/>";

        FinancialCycle::truncate();
        echo "Financial Cycle table is Empty now. done...<br/>";
        
        $newCycleId =FinancialCycle::insertGetId([
            'status'=>'current'
        ]);
        echo "Financial Cycle table Insert inital Cycle. done...<br/>";

        Session::put('display_cycle', $newCycleId);
        Session::put('current_cycle', $newCycleId); 
        echo "set Current  Cycle in Session. done...<br/>";
        
        //finish cycle edited status
        SystemSetting::where('setting_key','old_cycle_edited')->update([
            'setting_value'=>'false'
        ]);
        SystemSetting::where('setting_key','old_cycle_edited_id')->update([
            'setting_value'=>''
        ]);
        echo "re-configration edited cycle status. done...<br/>";
        
        $LogQuery = "TRUNCATE TABLE  cms_logs;";
         DB::select(DB::raw($LogQuery));
         echo "CMS Logs table is Empty now. done...<br/>";
        

        /*$package_configQuery = "TRUNCATE TABLE  package_config;";
         DB::select(DB::raw($package_configQuery));
         echo "package_config table is Empty now. done...<br/>";
         */

        echo "<br>-------------------------------------------------<br/>";
        echo "DATABASE is Ready to import Data";
        echo "<br>-------------------------------------------------<br/>";

        return "";

    }


}
