<?php
namespace App\Traits;

use App\Models\Accounts\Account;
use App\Models\Accounts\Customer;
use App\Models\Accounts\Supplier;
use App\Models\Users\Delegate;
use App\Models\Users\User;
use DB;
use CRUDBooster;
use Request;

trait AccountsTrait
{


    public function getCustomersIds()
    {

        $accountsIds = [];
        $id = CRUDBooster::myId();

        $me = User::find($id);

        if ($me->id_cms_privileges == 4) {
            $persons = Customer::where('delegate_id', $me->id)->select('account_id')->get();
        }
        else {
            $persons = Customer::select('account_id')->get();
        }

        foreach ($persons as $person) {
            array_push($accountsIds, $person->account_id);
        }
        if (count($accountsIds) <= 0) {
            array_push($accountsIds, 0);
        }
        return $accountsIds;
    }

    public function getSuppliersIds()
    {

        $accountsIds = [];
        $id = CRUDBooster::myId();
        $me = User::find($id);
        if ($me->id_cms_privileges == 4) {
            $suppliers = Delegate::with(['suppliers'=>function ($q){
                return $q->select('name_ar','account_id');
            }])->where('id',$me->id)->first()->suppliers;
        }
        else {
            $suppliers = Supplier::select('account_id')->get();
        }
        
        foreach ($suppliers as $sup) {
            array_push($accountsIds, $sup->account_id);
        }
        if ($accountsIds == null){
            $module_path = CRUDBooster::getCurrentModule()->path;
            if($module_path == "bills_purchase_invoice"){
                return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_access_to_purchase_bills_you_donnot_have_supplier'), "warning");
            }else{
                return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_access_to_return_purchase_bills_you_donnot_have_supplier'), "warning");
            }
        }
        return $accountsIds;

    }


    public function getAccountsIdsForVoucher()
    {
        $accountsIds = [];
        $accountsarr = [];
        $id = CRUDBooster::myId();
        $me = User::find($id);
        if ($me->id_cms_privileges == 4) {
            $delegate =Delegate::find($me->id);

            //get delegate suppliers
            $suppliers = $delegate->suppliers;
            foreach ($suppliers as $sup) {
                array_push($accountsarr, $sup->account_id);
            }
            //get delegate customers
            $customers = $delegate->customers;
            foreach ($customers as $customer) {
                array_push($accountsarr, $customer->account_id);
            }

            $accounts = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get();
        }
        else {
            $accounts = Account::select('id')->where('major_classification', 0)->get();

        }

        foreach ($accounts as $account) {
            array_push($accountsIds, $account->id);
        }
        return $accountsIds;
    }


	public function getAccountName($accountId)
	{
		return Account::where("id", $accountId)->first()->name_ar;
	}


}