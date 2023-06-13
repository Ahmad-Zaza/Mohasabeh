<?php
namespace App\Traits;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Users\User;
use App\Models\Vouchers\Voucher;
use App\Models\Vouchers\VoucherFile;
use DB;
use CRUDBooster;
use Request;
use Session;

trait VouchersTrait
{
    
    /*     make copy from Voucher before edit and change all transaction (item,money) to new copy     */
    public function makeVoucherAsDeleted($id)
    {

        $voucher = Voucher::find($id);
        $delete_voucher = collect($voucher);
        $delete_voucher->forget('id');

        $delete_voucher->put('edit_at', date('Y-m-d H:i:s'));
        $delete_voucher->put('edit_by', CRUDBooster::myId());

        $delete_voucher->put('action', 'edit');
        $delete_voucher_id = Voucher::insertGetId($delete_voucher->all());


        VoucherFile::where("voucher_id", $id)->update([
            "voucher_id" => $delete_voucher_id
        ]);


        $base = EntryBase::where("voucher_id", $id)->get();
        foreach ($base as $item) {
            EntryBase::where("id", $item->id)->update([
                "voucher_id" => $delete_voucher_id,
                "edit_at" => date('Y-m-d H:i:s'),
                "edit_by" => CRUDBooster::myId(),
                "action" => 'edit'
            ]);

            Entry::where("entry_base_id", $item->id)->update([
                //update edit_at, edit_by
                "edit_at" => date('Y-m-d H:i:s'),
                "edit_by" => CRUDBooster::myId(),
                "action" => 'edit'
            ]);
        }

    }

    
    public function deleteVoucher($id)
    {

        $voucher = Voucher::find($id);
        $delete_voucher = collect($voucher);

        Voucher::where('id', $id)->update([
            'delete_by' => CRUDBooster::myId(),
            'delete_at' => date('Y-m-d H:i:s'),
            'action' => 'delete'
        ]);


        $base = EntryBase::where("voucher_id", $id)->get();
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

    }

    
    public function checkVoucherP_Code($p_code)
    {
        $res = Voucher::where('p_code', $p_code)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->get();
        $bool = false;
        if (count($res) > 0) {
            $bool = true;
        }
        if ($bool) {
            //in add operation 
            return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.p_code_must_unique'), "warning");

        }
    }

    
    /************************* Check Voucher Number**********************/
    ///////////////////////////////////////////////////////////////////
    public function check_voucher_number_unique($num, $id, $voucher_type)
    {

        $conditions = array(['vouchers.action', '=', NULL],['vouchers.cycle_id', '=', Session::get('display_cycle')]);
        $query = Voucher::where('voucher_number', $num)->where('voucher_type_id', $voucher_type)
            ->where($conditions);
        if ($id != 0) {
            $query->where('id', '!=', $id);
        }
        $bill = $query->first();
        $check = 0;
        if ($bill) {
            $check = 1; //voucher_number already used
        }

        return $check;
    }

    public function checkVoucher($postdata, $action, $id = '', $voucher_type)
    {

        if ($voucher_type == 3 && $action == 'edit') { //transfer vouchers
            $v = Voucher::find($id);
            if($v->status == 1){
                return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.you_cannot_edit_transfer_voucher_because_amount_receipt_by_debit'), "warning");
            }
        }

        //check Voucher_number 
        if ($postdata['voucher_number'] && $postdata['voucher_number'] !== '') {
            if ($id == '') {
                $id = 0;
            }
            $bool = $this->check_voucher_number_unique($postdata['voucher_number'], $id, $voucher_type);
            if ($bool) {
                if ($action == 'add') {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.voucher_number_already_used',['voucher_number' => $postdata['voucher_number']]), "warning");
                }
                else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.voucher_number_already_used',['voucher_number' => $postdata['voucher_number']]), "warning");
                }
            }
        }

        if ($voucher_type != 4) {
            if ($postdata['amount'] <= 0) {
                if ($action == 'add') {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.add_voucher_failed_because_voucher_value_0_or_negative'), "warning");
                }
                else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.add_voucher_failed_because_voucher_value_0_or_negative'), "warning");
                }
            }
        }
        else {
            if ($postdata['amount'] == 0) {
                if ($action == 'add') {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.you_cannot_save_voucher_because_voucher_value_is_zero'), "warning");
                }
                else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.you_cannot_save_voucher_because_voucher_value_is_zero'), "warning");
                }
            }
        }

        if($voucher_type == 3){ //transfer voucher
            if($postdata['debit'] == $postdata['credit']){
                if ($action == 'add') {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.must_debit_and_credit_are_different'), "warning");
                }
                else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.must_debit_and_credit_are_different'), "warning");
                }
            }
        }

        if($voucher_type == 5){ //Daily voucher
            $users_box_arr = User::select('account_id')->distinct()->pluck('account_id')->toArray();
            array_pull($users_box_arr,0);
            array_push($users_box_arr, (int)$this->getSystemConfigValue("General_Box"));
            if(in_array($postdata['credit'],$users_box_arr)){
                $account_has_enough = $this->checkAccountHasAmount($postdata['credit'], $postdata['amount'], $postdata['currency_id'], $action, $id);
                if($account_has_enough == false){
                    if ($action == 'add') {
                        return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.add_daily_voucher_failed_because_account_doesnot_have_enough'), "warning");
                    } else {
			            return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.edit_daily_voucher_failed_because_account_doesnot_have_enough'), "warning");
                    }
                }
            }
        }

    }
    
    public function calculateVoucherEntriesEqualizer($amount, $currency_id, $opposite)
    {

        $gfunc = new GeneralFunctionsController();
        $majorCurr = $gfunc->getMajorCurrency();
        $entries_equalizer = 0;
        if ($currency_id == $majorCurr->id) {
            $entries_equalizer = $amount;
        }
        elseif ($currency_id != $majorCurr->id && $opposite == $majorCurr->id) {
            $ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
            $entries_equalizer = $amount * $ex_rate;
        }
        elseif ($currency_id != $majorCurr->id && $opposite != $majorCurr->id) {
            if ($currency_id == $opposite) {
                $ex_rate = Currency::where('id', $currency_id)->first()->ex_rate;
                $entries_equalizer = $amount * $ex_rate;
            }
        }
        return $entries_equalizer;
    }


    public function checkAccountHasAmount($account_id,$amount,$currency_id,$action,$edit_id = 0){
        $gfunc = new GeneralFunctionsController();
        $balance = $gfunc->getAccountBalance($account_id);
        $currency_bal = $balance->filter(function ($bal) use ($currency_id) {
            return $bal->currency_id == $currency_id ;
        })->values()[0]->curr_balance;
        
        $orgin_currency_bal = $currency_bal;
        if($action == 'edit'){
            $old_amount = 0;
            $old_voucher = Voucher::where('id', $edit_id)->where('cycle_id', Session::get('display_cycle'))->where('currency_id', $currency_id)->first();
            if($old_voucher){
                $old_amount = $old_voucher->amount;
            }
            $orgin_currency_bal = $currency_bal + $old_amount;
        }
        if($orgin_currency_bal < $amount ){
            return false; //account doesnot have enough
        }
        return true;
    }
}