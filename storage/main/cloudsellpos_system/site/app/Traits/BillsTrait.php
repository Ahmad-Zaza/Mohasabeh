<?php
namespace App\Traits;

use App\Models\Bills\Bill;
use App\Models\Bills\BillFile;
use App\Models\Bills\BillItem;
use App\Models\Currencies\Currency;
use App\Models\Currencies\CurrencyHistory;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Items\Item;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\SystemConfigration\SystemSetting;
use App\Models\Users\User;
use Carbon\Carbon;
use DB;
use CRUDBooster;
use Illuminate\Support\Facades\Session;
use Request;

trait BillsTrait
{
    
    //make copy from bill before edit and change all transaction (item,money) to new copy
    public function makeBillAsDeleted($id)
    {

        $bill = Bill::find($id);
        $delete_bill = collect($bill);
        $delete_bill->forget('id');


        $delete_bill->put('delete_at', date('Y-m-d H:i:s'));
        $delete_bill->put('delete_by', CRUDBooster::myId());
        $delete_bill->put('edit_at', date('Y-m-d H:i:s'));
        $delete_bill->put('edit_by', CRUDBooster::myId());
        $delete_bill->put('action', 'edit');
        $delete_bill_id = Bill::insertGetId($delete_bill->all());

        BillFile::where("bill_id", $id)->update([
            "bill_id" => $delete_bill_id
        ]);

        BillItem::where("bill_id", $id)->update([
            "bill_id" => $delete_bill_id
        ]);

        $base = EntryBase::where("bill_id", $id)->get();
        foreach ($base as $item) {
            EntryBase::where("id", $item->id)->update([
                "bill_id" => $delete_bill_id,
                "edit_at" => date('Y-m-d H:i:s'),
                "edit_by" => CRUDBooster::myId(),
                "action" => 'edit'
            ]);

            Entry::where("entry_base_id", $item->id)->update([
                //update delete_at, delete_by
                "edit_at" => date('Y-m-d H:i:s'),
                "edit_by" => CRUDBooster::myId(),
                "action" => 'edit'
            ]);
        }

        $tracking_records = ItemTracking::where("bill_id", $id)->get();
        foreach ($tracking_records as $item) {
            ItemTracking::where("id", $item->id)->update([
                "bill_id" => $delete_bill_id,
                "edit_at" => date('Y-m-d H:i:s'),
                "edit_by" => CRUDBooster::myId(),
                "action" => "edit"
            ]);
        }
    }

    
    public function deleteBill($id)
    {

        $bill = Bill::find($id);
        $delete_bill = collect($bill);

        Bill::where('id', $id)->update([
            'delete_by' => CRUDBooster::myId(),
            'delete_at' => date('Y-m-d H:i:s'),
            'action' => 'delete',
        ]);

        $base = EntryBase::where("bill_id", $id)->get();
        foreach ($base as $item) {
            EntryBase::where("id", $item->id)->update([
                "delete_at" => date('Y-m-d H:i:s'),
                "delete_by" => CRUDBooster::myId(),
                'action' => 'delete'
            ]);

            Entry::where("entry_base_id", $item->id)->update([
                //update delete_at, delete_by
                "delete_at" => date('Y-m-d H:i:s'),
                "delete_by" => CRUDBooster::myId(),
                'action' => 'delete'
            ]);
        }

        $tracking_records = ItemTracking::where("bill_id", $id)->get();
        foreach ($tracking_records as $item) {
            ItemTracking::where("id", $item->id)->update([
                "delete_at" => date('Y-m-d H:i:s'),
                "delete_by" => CRUDBooster::myId(),
                'action' => 'delete'
            ]);
        }
    }

    /************************* Check Bill Number**********************/
    ///////////////////////////////////////////////////////////////////
    public function check_bill_number_unique($num, $id, $bill_type)
    {

        $conditions = array(['bills.action', '=', NULL],['bills.cycle_id', '=', Session::get('display_cycle')]);
        $query = Bill::where('bill_number', $num)->where('bill_type_id', $bill_type)
            ->where($conditions);
        if ($id != 0) {
            $query->where('id', '!=', $id);
        }
        $bill = $query->first();
        $check = 0;
        if ($bill) {
            $check = 1; //bill_number already used
        }

        return $check;
    }
    
    public function checkInventoryItemQty($inventory, $id, $request_qty, $action, $bill_id)
    {
        //check if inventory has all item amount
        //select form data base here
        $sql = "SELECT sum(quantity) as counters, transaction_operation FROM `item_tracking` 
                    WHERE item_id = $id and item_tracking.source = $inventory and item_tracking.status = 1 
                    and item_tracking.action is NULL
                    and item_tracking.cycle_id = ".Session::get('display_cycle')."
                    GROUP BY transaction_operation";
        $in_out_res = DB::select($sql);

        $income = 0;
        $outcome = 0;
        foreach ($in_out_res as $res) {
            if ($res->transaction_operation == 'in') {
                $income = $res->counters;
            }
            if ($res->transaction_operation == 'out') {
                $outcome = $res->counters;
            }
        }

        if ($action == 'edit') {
            $prev_qty = BillItem::where('bill_id', $bill_id)->where('item_id', $id)->first()->quantity;
            $outcome = $outcome - $prev_qty;
        }
        if ($income < ($outcome + $request_qty)) {
            return false;
        }
        else {
            return true;
        }

    }


    public function checkBoxHasAmount($currency_id, $amount, $action, $id)
    {
        $user = CRUDBooster::getUser();
        if ($user->hasBox == 'own') {
            $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
                from entries , entry_base , accounts , currencies WHERE  
                accounts.id=entries.account_id and accounts.id = " . $user->boxAccount . "
                AND entry_base.id=entries.entry_base_id 
                AND currencies.id=entries.currency_id and entries.account_id= " . $user->boxAccount . "
                AND entries.currency_id=" . (int)$currency_id . "
                AND entries.action is NULL 
                AND entries.cycle_id = ".Session::get('display_cycle').";
                ";
        }
        else {

            $box_account_id = $this->getSystemConfigValue("General_Box");

            $sql = "select (IFNULL(sum(entries.debit), 0)-IFNULL(sum(entries.credit), 0)) as q 
                    from entries , entry_base , accounts , currencies WHERE  
                    accounts.id=entries.account_id and accounts.id = " . $box_account_id . " 
                    AND entry_base.id=entries.entry_base_id 
                    AND currencies.id=entries.currency_id and entries.account_id=" . $box_account_id . "
                    AND entries.currency_id=" . (int)$currency_id . "
                    AND entries.action is NULL 
                    AND entries.cycle_id = ".Session::get('display_cycle')." ;
                ";

        }



        $value = DB::select($sql);
        $box_value = (int)$value[0]->q;

        if ($action == 'edit') {
            $amount_before_edit = Bill::where('id', $id)->first()->amount;
            $box_value = $box_value + (int)$amount_before_edit;
        }
        if ((int)$amount > $box_value) {
            return false;
        }
        else {
            return true;
        }

    }

    public function checkBill($postdata, $action, $id = '', $bill_type)
    {
        //dd($postdata);

       //check if package config allow to add New Bill at this month
        if ($action == 'add') {
            
            $avilableMonthBillNum = $this->getPackageConfigValue('month_bills_num');
            $month_bills = Bill::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->whereMonth('date', Carbon::now()->month)->get();
            if ($avilableMonthBillNum > 0 && count($month_bills) + 1 > $avilableMonthBillNum) {
                return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.connot_add_new_Bill_allwed_count_at_month_is')." $avilableMonthBillNum", "warning");
            }
        }

        $allRequestData = Request::all();
        //check if count of items in bill > 0 
        $itemsIds = $allRequestData['adafmad-item_id'];
        if ($itemsIds == null || ($itemsIds != null && count($itemsIds) < 0)) {
            if ($action == 'add') {
                return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.please_enter_items_in_bill'), "warning");
            }
            else {
                return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.please_enter_items_in_bill'), "warning");
            }

        }
        
        //check bill amount after discount
        $allowNegativeBills_setting_value =SystemSetting::where('setting_key','negative_bills')->first()->setting_value;
        if($postdata['after_discount'] <= 0 && $allowNegativeBills_setting_value == 'off'){
            $this->setItemsDataToSession();
            if ($action == 'add') {
                return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.cannot_add_bill_with_amount_after_discount_equal_zero'), "warning");
            }
            else {
                return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.cannot_edit_bill_with_amount_after_discount_equal_zero'), "warning");
            } 
        }
        
        //check bill_number 
        if ($postdata['bill_number'] && $postdata['bill_number'] !== '') {
            if ($id == '') {
                $id = 0;
            }
            $bool = $this->check_bill_number_unique($postdata['bill_number'], $id, $bill_type);
            if ($bool) {
                $this->setItemsDataToSession();
                if ($action == 'add') {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.bill_number_already_used',['bill_number' => $postdata['bill_number']]), "warning");
                }
                else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.bill_number_already_used',['bill_number' => $postdata['bill_number']]), "warning");
                }
            }
        }

        $inv = $postdata['inventory_id'];
        //check if bill has inventory id
        if ($inv == null) {
            $this->setItemsDataToSession();
            if ($action == 'add') {
                return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('modules.you_must_choose_inventory_in_bill'), "warning");
            }
            else {
                return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('modules.you_must_choose_inventory_in_bill'), "warning");
            }

        }

        if ($bill_type == 2 || $bill_type == 3) { //تحقق من هذا الشرط في حال فاتورة مبيع و فاتورة مردود شراء
            //check if inventory doesn't have enough from item
            if ($itemsIds != null && count($itemsIds) > 0) {
                $itemsQty = $allRequestData['adafmad-quantity'];
                $itemsCount = count($itemsIds);
                $bool = true;

                for ($i = 0; $i < $itemsCount; $i++) {
                    $b = $this->checkInventoryItemQty($inv, $itemsIds[$i], $itemsQty[$i], $action, $id);
                    if ($b == false) {
                        $bool = false;
                    }
                }
                
                if ($bool == false) { //أحدى مواد الفاتورة لايملك المستودع الكمية المطلوب منها
                    $this->setItemsDataToSession();
                    if ($action == 'add') {
                        return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.one_item_in_bill_inventory_cannot_has_enough'), "warning");
                    }
                    else {
                        return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.one_item_in_bill_inventory_cannot_has_enough'), "warning");
                    }
                }


            }
        }

        if ($bill_type == 1 || $bill_type == 4) { //تحقق من هذا الشرط في حال فاتورة شراء أو فاتورة مردود مبيع            
            if ($postdata['is_cash'] == 1) {
                //check if Box has all bill Amount
                $bool = $this->checkBoxHasAmount($postdata['currency_id'], $postdata['after_discount'], $action, $id);
                if (!$bool) {
                    $this->setItemsDataToSession();
                    if ($action == 'add') {
                        return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.box_balance_not_enough_for_bill_value'), "warning");
                    }
                    else {
                        return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.box_balance_not_enough_for_bill_value'), "warning");
                    }
                }
            }
        }

    }

    
    public function changeExchangeRate($currency, $ex_rate)
    {
        Currency::where("id", $currency)->update([
            "ex_rate" => $ex_rate
        ]);
        CurrencyHistory::insert([
            'currency_id' => $currency,
            'ex_rate' => $ex_rate,
            'edit_by' => CRUDBooster::myId(),
        ]);
    }
    
    public function checkP_Code($p_code)
    {
        $res = Bill::where('p_code', $p_code)->where('action', NULL)->where('cycle_id',Session::get('display_cycle'))->get();
        $bool = false;
        if (count($res) > 0) {
            $bool = true;
        }
        if ($bool) {
            //in add operation 
            return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.p_code_must_unique'), "warning");

        }
    }

    public function setItemsDataToSession(){
        $allRequestData = Request::all();
        //set items list to session as collection
        $IdsArr = $allRequestData['adafmad-item_id'];
        $quantityArr = $allRequestData['adafmad-quantity'];
        $unit_priceArr = $allRequestData['adafmad-unit_price'];
        $subtotalArr = $allRequestData['adafmad-subtotal'];
        $oldData = array();
        if($IdsArr){
            foreach($IdsArr as $key=>$id){
                $item_info = [
                    "item_id"=>$id,
                    "items_name_ar"=> Item::find($id)->name_ar,
                    "quantity"=>$quantityArr["$key"],
                    "unit_price"=> $unit_priceArr["$key"],
                    "subtotal"=> $subtotalArr["$key"]                                        
                ];
                array_push($oldData,(object)$item_info);
            }
        }
        $oldData = collect($oldData);
        Session::put("OldData", $oldData);
    }

}