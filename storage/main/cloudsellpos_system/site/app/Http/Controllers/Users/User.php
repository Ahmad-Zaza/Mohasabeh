<?php
namespace App\Http\Controllers\Users;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Account;
use App\Models\Accounts\Customer;
use App\Models\Accounts\Person;
use App\Models\Accounts\Supplier;
use App\Models\Inventories\Inventory;
use App\Models\Users\GeneralDelegate;
use CRUDBooster;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class User{
     public $id;
     public $name;
     public $isSuperAdmin;
     public $roleId;
     public $hasBox; //false -> has general box , true -> has own account
     public $boxAccount;
     public $showCustomersStatus; //all, own customers in Customers Modules
     public $showCustomersStatusInProcess; //all, own customers in bills,vouchers,reports
     public $customersAccountId;  
     public $showSuppliersStatus; //all, own suppliers
     public $suppliersIds;
     public $showInventorisStatus; //all, own inventories
     public $showAccountsStatus; //all, own accounts
     public $accountsIds;

     public $showStaffFeild;

     function __construct() {
        $gfunc = new GeneralFunctionsController();
        $this->id = Session::get('admin_id');
        $user_info = \App\Models\Users\User::find($this->id);
        $this->name = $user_info->name;
        $this->isSuperAdmin = Session::get('admin_is_superadmin');
        $this->roleId = Session::get('admin_privileges');
        switch($this->roleId){
            case 1:  //Super Admin
                $this->hasBox = 'general';   // has Box or Not (general,own,none)
                $this->boxAccount = $gfunc->getSystemConfigValue("General_Box");       // his Box Account ID
                $this->showCustomersStatus = 'all'; //view System Customers in Customers module (all,own)
                $this->showCustomersStatusInProcess = 'all'; ////view System Customers in bills,vouchers,reports (all,own)
                $this->customersAccountId = $gfunc->getSystemConfigValue('Customers_Account');    //has customers account id where id=2 is General Customers Account ID
                $this->showSuppliersStatus = 'all'; // all, own, own_and_delegates_suppliers in bills,vouchers,reports
                $this->showInventorisStatus = 'all'; //all , own in bills,vouchers,reports
                $this->showAccountsStatus = 'all'; // all, own, own_with_other ,all_without_main
                $this->showStaffFeild = true;
                break;
            case 2: //Manager
                $this->hasBox = 'general';
                $this->boxAccount = $gfunc->getSystemConfigValue("General_Box");
                $this->showCustomersStatus = 'all';
                $this->showCustomersStatusInProcess = 'all';
                $this->customersAccountId = $gfunc->getSystemConfigValue('Customers_Account');
                $this->showSuppliersStatus = 'all';
                $this->showInventorisStatus = 'all';
                $this->showAccountsStatus = 'all';
                $this->showStaffFeild = true;
                break;
            case 3: //Sales Manager
                $this->hasBox = 'own';
                $this->boxAccount = $user_info->account_id;
                $this->showCustomersStatus = 'own';
                $this->showCustomersStatusInProcess = 'all';
                $this->customersAccountId = $user_info->customers_account_id;
                $this->showSuppliersStatus = 'own_and_delegates_suppliers';
                $this->showInventorisStatus = 'all';
                $this->showAccountsStatus = 'own_with_other'; // own with other delegates customers, delegates suppliers, visiable_for_delegate accounts
                $this->showStaffFeild = true;
                break;
            case 4: // Delegate
                $this->hasBox = 'own';
                $this->boxAccount = $user_info->account_id;
                $this->showCustomersStatus = 'own';
                $this->showCustomersStatusInProcess = 'own';
                $this->customersAccountId = $user_info->customers_account_id;
                $this->showSuppliersStatus = 'own';
                $this->showInventorisStatus = 'own';
                $this->showAccountsStatus = 'own';
                $this->showStaffFeild = false;
                break;
            case 5: // Just View
                $this->hasBox = 'general';
                $this->boxAccount = $gfunc->getSystemConfigValue("General_Box");
                $this->showCustomersStatus = 'all';
                $this->showCustomersStatusInProcess = 'all';
                $this->customersAccountId = $gfunc->getSystemConfigValue('Customers_Account');
                $this->showSuppliersStatus = 'all';
                $this->showInventorisStatus = 'all';
                $this->showAccountsStatus = 'all';
                $this->showStaffFeild = true;
                break;            
            case 6: //Factory Delegate
                $this->hasBox = 'none';
                $this->boxAccount = 0;
                $this->showCustomersStatus = 'all';
                $this->showCustomersStatusInProcess = 'all';
                $this->customersAccountId = $user_info->customers_account_id;
                $this->showSuppliersStatus = 'all';
                $this->showInventorisStatus = 'own';
                $this->showAccountsStatus = 'all_without_main';
                $this->showStaffFeild = true;
                break;            
            case 7: //Factory Cashier
                $this->hasBox = 'own';
                $this->boxAccount = $user_info->account_id;
                $this->showCustomersStatus = 'all';
                $this->showCustomersStatusInProcess = 'all';
                $this->customersAccountId = 0;
                $this->showSuppliersStatus = 'all';
                $this->showInventorisStatus = 'none';
                $this->showAccountsStatus = 'all_without_main';
                $this->showStaffFeild = true;
                break;            
            
                
            default:
                $this->hasBox = false;
                $this->boxAccount = 0;
                $this->showCustomersStatus = 'all';
                $this->showCustomersStatusInProcess = 'all';
                $this->customersAccountId = $gfunc->getSystemConfigValue('Customers_Account');
                $this->showSuppliersStatus = 'all';
                $this->showInventorisStatus = 'all';
                $this->showAccountsStatus = 'all';
                $this->showStaffFeild = false;

        }
      }

      public function getCustomers(){
        $customers = [];
        switch($this->showCustomersStatus){
            case 'all':
                $customers = Customer::get();
                break;
            case 'own':
                $customers = Customer::where('delegate_id',$this->id)->get();
                break;
        }
        return $customers;
      }
      
      public function getCustomersIdsInProcess(){
        $customersIds = [];
        switch($this->showCustomersStatusInProcess){
            case 'all':
                $customersIds = Customer::get()->pluck('account_id')->toArray();
                break;
            case 'own':
                $customersIds = Customer::where('delegate_id',$this->id)->get()->pluck('account_id')->toArray();
                break;
        }

        if(count($customersIds) == 0){ //don't have customers yet.
            $customersIds = [0];
        }
        
        return $customersIds;
      }

      
      public function getSuppliersAccountsIds(){
        $accountsIds = [];
        switch($this->showSuppliersStatus){
            case 'all':
                $accountsIds = Supplier::get()->pluck('account_id')->toArray();    
                break;
            case 'own':    
                $accountsIds = Supplier::whereHas('delegates',function($q){
                    return $q->where('delegate_id',$this->id);
                })->get()->pluck('account_id')->toArray();
                break;
            case 'own_and_delegates_suppliers':
                $accountsIds = Supplier::whereHas('delegates')->get()->pluck('account_id')->toArray();
                break;    
        }

        if(count($accountsIds) == 0){ //don't have suppliers yet.
            $accountsIds = [0];
        }

        return $accountsIds;
      }

      public function getInventoriesIds(){
        $inventoriesIds = [];
        switch($this->showInventorisStatus){
            case 'all':
                $inventoriesIds = Inventory::where('major_classification',0)->get()->pluck('id')->toArray();
                break;
            case 'own':
                $inventoriesIds = GeneralDelegate::where('id',$this->id)->first()->inventories()->pluck('inventory_id')->toArray();
                break;
        }
        if(count($inventoriesIds) == 0){ //don't have inventories yet.
            $inventoriesIds = [0];
        }
        return $inventoriesIds;
      }

    public function getAccountsIdsForVouchers()
    {
        $accountsIds=[];
        switch($this->showAccountsStatus){
            case 'all':
                $accountsIds = Account::where('major_classification', 0)->get()->pluck('id')->toArray();
                break;
            case 'own':
                $accountsarr = [];
                $delegate =GeneralDelegate::find($this->id);

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

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();                    
                break;
            case 'own_with_other': // own with other  delegates customers, delegates suppliers, visiable_for_delegate accounts
                $accountsarr = [];

                //get suppliers where has delegates
                $suppliers = Supplier::whereHas('delegates')->get();
                foreach ($suppliers as $sup) {
                    array_push($accountsarr, $sup->account_id);
                }
                //get all customers
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    array_push($accountsarr, $customer->account_id);
                }

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();
                break;
            case 'all_without_main': // all customers, all suppliers, visiable_for_delegate accounts
                $accountsarr = [];
                //get suppliers where has delegates
                $suppliers = Supplier::get();
                foreach ($suppliers as $sup) {
                    array_push($accountsarr, $sup->account_id);
                }
                //get all customers
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    array_push($accountsarr, $customer->account_id);
                }

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();
                break;        
        }

        if(count($accountsIds) == 0){ //don't have accounts yet.
            $accountsIds = [0];
        }

        return $accountsIds;
    }

    public function getAccountsIdsForDailyVouchers()
    {
        $accountsIds=[];
        switch($this->showAccountsStatus){
            case 'all':
                $accountsIds = Account::where('major_classification', 0)->get()->pluck('id')->toArray();
                break;
            case 'own':
                $accountsarr = [];
                array_push($accountsarr, $this->boxAccount);
                $delegate =GeneralDelegate::find($this->id);

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

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();                    
                break;
            case 'own_with_other': // own with other  delegates customers, delegates suppliers, visiable_for_delegate accounts
                $accountsarr = [];
                array_push($accountsarr, $this->boxAccount);
                //get suppliers where has delegates
                $suppliers = Supplier::whereHas('delegates')->get();
                foreach ($suppliers as $sup) {
                    array_push($accountsarr, $sup->account_id);
                }
                //get all customers
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    array_push($accountsarr, $customer->account_id);
                }

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();
                break;
            case 'all_without_main': // box ,all customers, all suppliers, visiable_for_delegate accounts
                $accountsarr = [];
                array_push($accountsarr, $this->boxAccount);
                //get suppliers where has delegates
                $suppliers = Supplier::get();
                foreach ($suppliers as $sup) {
                    array_push($accountsarr, $sup->account_id);
                }
                //get all customers
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    array_push($accountsarr, $customer->account_id);
                }

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();
                break;        
        }

        if(count($accountsIds) == 0){ //don't have accounts yet.
            $accountsIds = [0];
        }

        return $accountsIds;
    }

    public function getAccountsIdsForReports()
    {
        $accountsIds=[];
        switch($this->showAccountsStatus){
            case 'all':
                $accountsIds = Account::get()->pluck('id')->toArray();
                break;
            case 'own':
                $accountsarr = [];
                array_push($accountsarr, $this->boxAccount);
                $delegate =GeneralDelegate::find($this->id);

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

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();                    
                break;
            case 'own_with_other': // own with other  delegates customers, delegates suppliers, visiable_for_delegate accounts
                $accountsarr = [];
                array_push($accountsarr, $this->boxAccount);
                //get suppliers where has delegates
                $suppliers = Supplier::whereHas('delegates')->get();
                foreach ($suppliers as $sup) {
                    array_push($accountsarr, $sup->account_id);
                }
                //get all customers
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    array_push($accountsarr, $customer->account_id);
                }

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();
                break;  

            case 'all_without_main': // box ,all customers, all suppliers, visiable_for_delegate accounts
                $accountsarr = [];
                array_push($accountsarr, $this->boxAccount);
                //get suppliers where has delegates
                $suppliers = Supplier::get();
                foreach ($suppliers as $sup) {
                    array_push($accountsarr, $sup->account_id);
                }
                //get all customers
                $customers = Customer::get();
                foreach ($customers as $customer) {
                    array_push($accountsarr, $customer->account_id);
                }

                $accountsIds = Account::whereIn('id', $accountsarr)->orWhere('visible_to_delegates', '1')->distinct()->get()->pluck('id')->toArray();
                break;        
        }

        
        if(count($accountsIds) == 0){ //don't have accounts yet.
            $accountsIds = [0];
        }

        return $accountsIds;
    }
    
    public function getPersonsForReports() //customers & suppliers
    {
        $persons = [];
        $customers_accounts_ids = $this->getCustomersIdsInProcess();
        $suppliers_accounts_ids = $this->getSuppliersAccountsIds();

        $persons_accounts_id = array_merge($customers_accounts_ids, $suppliers_accounts_ids);
        $persons = Person::whereIn('account_id',$persons_accounts_id)->get();
        return $persons;
    }

}