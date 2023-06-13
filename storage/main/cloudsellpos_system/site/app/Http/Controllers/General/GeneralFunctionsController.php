<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\General;

use App\Models\Accounts\Supplier;
use App\Models\Bills\BillFile;
use App\Models\FinancialCycles\FinancialCycle;
use App\Models\FinancialCycles\ReCalculateCycleHistory;
use App\Models\Inventories\BeginningTracking;
use App\Models\Inventories\BeginningTrackingList;
use App\Models\Inventories\TransferTracking;
use App\Models\Inventories\TransferTrackingNote;
use App\Models\SystemConfigration\SystemSetting;
use App\Models\Users\GeneralDelegate;
use App\Models\Vouchers\InitialVouchersGroup;
use App\Models\Vouchers\InitialVouchersList;
use App\Models\Vouchers\VoucherFile;
use crocodicstudio_voila\crudbooster\helpers\CB;
use Illuminate\Support\Facades\DB;
use CRUDBooster;
use Illuminate\Support\Facades\Request;
use Session;
use Illuminate\Support\Facades\Storage;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Vouchers\Voucher;
use Illuminate\Support\Facades\Cache;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Bills\Bill;
use App\Models\Currencies\Currency;
use App\Models\Currencies\CurrencyHistory;
use App\Models\Vouchers\VoucherType;
use App\Models\ItemsTracking\ItemTrackingType;
use App\Models\Items\Item;
use App\Models\Inventories\TransferTrackingList;
use App\Models\SystemConfigration\SystemConfig;
use App\Models\RotateData\RotateDataResult;
use App\Models\Users\Delegate;
use App\Models\Bills\BillItem;
use Illuminate\Support\Facades\File;  

class GeneralFunctionsController extends Controller{


    //جلب رصيد حساب 
    public function getAccountBalance($account_id){

        $conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);
        $query = Entry::select(
            'accounts.id as id',
            'accounts.name_ar as name',
            'currencies.name_ar as currency',
            'currencies.id as currency_id',
            DB::raw('sum(IFNULL(entries.credit,0)) as all_paid_amount, entries.currency_id'),
            DB::raw('sum(IFNULL(entries.debit,0)) as all_received_amount, entries.currency_id'),
            DB::raw('(sum(IFNULL(entries.debit,0)) - sum(IFNULL(entries.credit,0))) as curr_balance, entries.currency_id')
        )
            ->join("entry_base", "entry_base.id", "entries.entry_base_id")
            ->join("accounts", "accounts.id", "entries.account_id")
            ->join("currencies", "currencies.id", "entries.currency_id")
            ->where($conditions)
            ->where('accounts.id',$account_id)
            ->groupBy('entries.currency_id');
        $res = $query->get();
       
        return $res;    
    }

    public function getAccountBalanceAtDate($account_id,$date){

        $conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);
        $query = Entry::select(
            'accounts.id as id',
            'accounts.name_ar as name',
            'currencies.name_ar as currency',
            'currencies.id as currency_id',
            DB::raw('sum(IFNULL(entries.credit,0)) as all_paid_amount, entries.currency_id'),
            DB::raw('sum(IFNULL(entries.debit,0)) as all_received_amount, entries.currency_id'),
            DB::raw('(sum(IFNULL(entries.debit,0)) - sum(IFNULL(entries.credit,0))) as curr_balance, entries.currency_id')
        )
            ->join("entry_base", "entry_base.id", "entries.entry_base_id")
            ->join("accounts", "accounts.id", "entries.account_id")
            ->join("currencies", "currencies.id", "entries.currency_id")
            ->where('entries.create_at', '<=',  $date)
            ->where($conditions)
            ->where('accounts.id',$account_id)
            ->orWhereNull('entries.create_at')
            ->where($conditions)
            ->where('accounts.id',$account_id)
            ->groupBy('entries.currency_id');
        $res = $query->get();
        return $res;    
    }

    //جلب زبائن مندوب ما

    public function getSalesmanCustomers($id){
        $customers = Delegate::where('id',$id)->first()->customers;
        return $customers;
    }
    
    //جلب موردي مندوب ما
    public function getSalesmanSuppliers($id){
        $suppliers = Delegate::with(['suppliers' => function ($q){
            return $q->select('name_ar','account_id');
        }])->where('id',$id)->first()->suppliers;
        return $suppliers;
    }

    /*****************************************************/
    //          توابع الحسابات التجميعية
    /****************************************************/

    //جلب الأبناء المباشرين لحساب معين
    public function getFirstChildernForAccount($account_id){

        $first_childs =Account::select('id','name_ar','code','major_classification','closing_account_type')
                                            ->where('parent_id',$account_id)->get();
        return $first_childs;
    }

    //تحقق من أن الحساب يملك أبناء
    public function checkIfAccountHasChildren($account_id){
        $first_childs =Account::where('parent_id',$account_id)->get();
         $hasChilds = false;
         if($first_childs->count() > 0){
            $hasChilds = true;
         }
         return $hasChilds;
    }

    //تابع يتحقق من الحساب هل هو حساب حقيقي أم تجميعي
    public function checkIfAccountHasEntries($account_id){
        $count =Entry::where('account_id',$account_id)->where('cycle_id',Session::get('display_cycle'))->get()->count();
         $hasEntries = false;
         if($count > 0){
            $hasEntries = true; 
         }
         return $hasEntries;
    }

    //جلب أرصدة جميع الآبناء لحساب تجميعي معين
    public function getAccountChildernBalances($account_id,&$childernBalances){

        $hasChilds=$this->checkIfAccountHasChildren($account_id);
        if($hasChilds){
            $children = $this->getFirstChildernForAccount($account_id);
            foreach($children as $child){
                $this->getAccountChildernBalances($child->id,$childernBalances);
            }
        }else{
            $bal=$this->getAccountBalance($account_id);

            if(count($bal) > 0){
                array_push($childernBalances,$bal);
            }
               
        }

    }

      //جلب  رصيد حساب تجميعي معين
      public function getAccountBalance_sum_childrenBalances($account_id,&$currencies_balance){

        $hasChilds=$this->checkIfAccountHasChildren($account_id);
        if($hasChilds){
            $children = $this->getFirstChildernForAccount($account_id);
            foreach($children as $child){
                $this->getAccountBalance_sum_childrenBalances($child->id,$currencies_balance);
            }
        }else{
            $bal=$this->getAccountBalance($account_id);
            if(count($bal) > 0){
                foreach($bal as $item){
                    $currencies_balance['curr_balance_'.$item->currency_id] += $item->curr_balance;
                }
            }
               
        }

    }

    //جلب  رصيد حساب تجميعي معين
    public function getAccountBalance_sum_childrenBalances_at_date($account_id,$date,&$final_balances){
        
        $hasChilds=$this->checkIfAccountHasChildren($account_id);
        
        if($hasChilds){
            $children = $this->getFirstChildernForAccount($account_id);
            foreach($children as $child){
                $this->getAccountBalance_sum_childrenBalances_at_date($child->id,$date,$final_balances);
            }
        }else{
            $bal=$this->getAccountBalanceAtDate($account_id,$date);
            if(count($bal) > 0){
                foreach($bal as $item){
                    $final_balances['final_balance_'.$item->currency_id] += $item->curr_balance; 
                }
            }
               
        }

    }

    //جلب قائمة بأرقام الحسابات المغلقة بحساب إغلاق معين
    public function getAccountsIDsListInClosingAccountType($closing_account_type){
        $accountsIDs = Account::select('id','name_ar')->where('closing_account_type',$closing_account_type)->pluck('id')->toArray();
        return $accountsIDs; 
    }

    //تابع يقوم بجلب قائمة بجميع الحسابات الحقيقية  وتفصيل حول رصيد كل حساب والتي تدخل بمعرفة اجمالي حساب الإغلاق
    //حيث يتم فيه التحقق من الحساب هل له أبناء يقوم بفحص كل ابن   في حال كان مغلق ضمن نفس النوع يتجاهله 
    //لأنه سوف يحسب لوحده وهو موجود ضمن القائمة accountsIDS
    //ويتم تجاهل جميع حسابات الآبناء المغلقة على نوع أخر مختلف عن الذي نقوم بحساب مبلغه الإجمالي
    public function getAccountBalanceForClosing($account_id,$closing_account_type,$accountsIDs,&$childernBalances,&$curr_balances){
        $hasChilds=$this->checkIfAccountHasChildren($account_id);
        if($hasChilds){
            $children = $this->getFirstChildernForAccount($account_id);
            foreach($children as $child){
                //check if account not in accountsIDs and his closing_account_type null
                if(!in_array($child->id,$accountsIDs) && ($child->closing_account_type == null)){
                    $this->getAccountBalanceForClosing($child->id,$closing_account_type,$accountsIDs,$childernBalances,$curr_balances);
                }
            }
        }else{
            $bal=$this->getAccountBalance($account_id);
            
            if(count($bal) > 0){
                
                array_push($childernBalances,$bal);
                foreach($bal as $item){
                    $curr_balances['curr_balance_'.$item->currency_id] +=$item->curr_balance;
                }
            }  
        }
    }

    //تابع يقوم بمعالجة جميع الحسابات التي تم تسجيلها على أنها مقفلة بنوع الإغلاق المدروس
    //ويجلب قائمة بكل الحسابات الداخلة بحساب نوع إغلاق معين
    public function getClosingAccountTypeBalanceAsArray($closing_account_type,$accountsIDs,&$childernBalances){
            $allAccountsList = array();
            foreach($accountsIDs as $account_id){
                $account_name = Account::select('id','name_ar')->where('id',$account_id)->first()->name_ar;
                $arr = array(
                    'account_id'=>$account_id,
                    'account_name'=>$account_name
                );
                $activeCurrencies = $this->getActiveCurrencies();
                $curr_balances = array();
                foreach($activeCurrencies as $curr){
                    $curr_balances['curr_balance_'.$curr->id] = 0;
                }
                $this->getAccountBalanceForClosing($account_id,$closing_account_type,$accountsIDs,$childernBalances,$curr_balances);
                foreach($activeCurrencies as $curr){
                    $arr['curr_balance_'.$curr->id] = $curr_balances['curr_balance_'.$curr->id];
                }

                array_push($allAccountsList,$arr);
            }
            return $allAccountsList;
    }

 

    /*************** Items Functions *********************/
    ///////////////////////////////////////////////////////

        public function getItems(){
            $user = CRUDBooster::getUser();
            
            if(in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))){
                $inventories_ids = GeneralDelegate::find($user->id)->inventories()->pluck('inventory_id')->toArray();
                $items_ids = ItemTracking::where('status',1)->where('action',NULL)->where('cycle_id',Session::get('display_cycle'))->whereIn('source',$inventories_ids)->distinct('item_id')->pluck('item_id')->toArray();
                $items = Item::whereIn('id',$items_ids)->get();
            }else{
                $items = Item::get();
            }
           
           return $items;
        }
    		
		public function getItemsIds(){
            $user = CRUDBooster::getUser();
            $items_ids=[];
			if(in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))){
                $delegate_id = $user->id;
                $inventories_ids = GeneralDelegate::find($delegate_id)->inventories()->pluck('inventory_id')->toArray();
                $items_ids = ItemTracking::where('status',1)->where('action',NULL)->where('cycle_id',Session::get('display_cycle'))->whereIn('source',$inventories_ids)->distinct('item_id')->pluck('item_id')->toArray();
            }else{
				$items_ids = Item::pluck('id')->toArray();
			}
              
            return $items_ids;
		}
    
        //check if inventory has enough qauntity from item
        public function getInventoryQauntityItem($inventory,$item,$quantity,$action = '',$id = 0 ){

            $query = DB::table("item_tracking as t0")
                ->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
                    DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
                                WHERE t1.transaction_operation = 'in'
                                and t1.status = 1 
								and t1.action is NULL 
                                and t1.cycle_id = ".Session::get('display_cycle')."  
                                and t1.item_id = t0.item_id 
                                and t0.source = t1.source ) as item_in "),
                    DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
                               WHERE t2.transaction_operation = 'out'
                                and t2.status = 1
							    and t2.action is NULL 
                                and t2.cycle_id = ".Session::get('display_cycle')."   
                                and t0.item_id = t2.item_id and t0.source = t2.source) as item_out"))
                                ->join("items", "items.id", "t0.item_id")
                                ->leftjoin("inventories as source","t0.source", "source.id")

                ->GROUPby('itemId','t0.source');

                $query->where('items.id', $item );
                $query->where('t0.source', $inventory);
                $query->where('t0.status',1);
                $query->where('t0.action',NULL);
                $query->where('t0.cycle_id', Session::get('display_cycle'));              
                $data = $query->get();
                $curr_qty = ($data[0]->item_in - $data[0]->item_out);
                if($action == 'edit'){
                    $item_old_qty = TransferTrackingList::where('transfer_tracking_id', $id)
                                                                    ->where('item_id',$item)->sum('quantity');
                    $curr_qty += $item_old_qty; 
                }
                $hasEnough = false;
                if ( $curr_qty >= $quantity ){
                    $hasEnough = true;
                }
              return $hasEnough;
        }


        public function getBillItemsDetails($id){
                
                $bill_items = BillItem::join("items", "items.id", "bills_items.item_id")
                 ->where('bill_id',$id)->orderby('bills_items.id','desc')->get();

                $result = "<table class='table'>
                        <tr>
                            <th>".trans('modules.item')."</th>
                            <th>".trans('modules.quantity')."</th>
                            <th>".trans('modules.unit_price')."</th>
                        </tr>";
                 
                    foreach($bill_items as $item_details){
                        
                        $result .="<tr>
                            <td>$item_details->name_ar</td>
                            <td>$item_details->quantity</td>
                            <td>$item_details->unit_price</td>
                        </tr>";
                    }

                    $result .="</table>";

                    echo $result;

        }


        public function getParentAccount($person_id){

            if($person_id != null){
                $person = Person::where('id',$person_id)->first();
                $person_account = Account::where('id',$person->account_id)->first();
                return $person_account->parent_id;
            }else{
                return null;
            }

           
        }

        /*  Start Currencies Functions   */
        public function getActiveCurrencies(){
            $currencies = Currency::where('active',1)->get();
            return $currencies;
        }
        //قائمة بالعملات الغير رأيسية
        public function getCurrencies_Not_Major(){
            $currencies = Currency::where('is_major',0)->where('active',1)->get();
            return $currencies;
        }
        //جلب العملة الرئيسية
        public function getMajorCurrency(){
            $majorCurrency = Currency::where('is_major',1)->where('active',1)->first();
            return $majorCurrency;
        }

        public function getActiveCurrenciesAsEnumString(){
            $active_currencies = $this->getActiveCurrencies();
            $enum_values= array();
            foreach($active_currencies as $curr){
                $enum_values[] = $curr->id."|".$curr->name_ar; 
            }
            $enum_values_str = implode(";",$enum_values);
            return $enum_values_str;
        }

     /*************** Configration Functions *********************/
    //////////////////////////////////////////////////////////////

        public function getSystemConfigValue($key){
            $config_value = Cache::rememberForever("$key", function () use ($key){
                return SystemConfig::where('config_key',$key)->first()->config_value;
            });
            return $config_value;        
        }

        public function checkCycleSession(){

            if(!Session::get('current_cycle')){
                $current_cycle_id=FinancialCycle::where('status', 'current')->first()->id;
                Session::put('current_cycle',$current_cycle_id);
            }
            
            if(!Session::get('display_cycle')){
                Session::put('display_cycle',Session::get('current_cycle'));
            }
           
            if(Session::get('display_cycle') != Session::get('current_cycle')){
                return false;
            } else {
                return true;
            }
        }

    public function checkOldCycleEdited()
    {
        $user= CRUDBooster::getUser();
        if ($user && $user->isSuperAdmin) {
            if (Session::get('display_cycle') == Session::get('current_cycle')) {
                $status = SystemSetting::where('setting_key', 'old_cycle_edited')->first()->setting_value;
                if ($status == 'true') {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }   
    }

    public function checkOldCycleHasEditedPermission()
    {
       
        if(Session::get('display_cycle') != Session::get('current_cycle')){
            $user= CRUDBooster::getUser();
            if ($user && $user->isSuperAdmin) {
                $lastRotatedCycle = FinancialCycle::where('status', 'finished')->orderBy('id', 'desc')->first()->id;
                if(Session::get('display_cycle') == $lastRotatedCycle){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    ///////////////////////////////////////////////////////////////


    public function getDelegateNameByPersonId($id)
    {
        $person = Person::where('account_id', $id)->first();
        if ($person->person_type_id == 1) { //زبون
            $delegate = User::find($person->delegate_id);
        }
        else {
            $delegate = Supplier::where('id',$person->id)->first()->delegates()->first();
        }


        return response()->json($delegate);
    }


    public function getNotifications()
    {
        $user=CRUDBooster::getUser();
        $notifications = ['status'=>false,'list'=>array()];
        
        if($user->hasBox != 'none'){
            //get receipt notifications
            $receipt_notifications_count = Voucher::where('vouchers.debit', $user->boxAccount)
            ->where("voucher_type_id", 3)
            ->where('status', 0)
            ->where("action", NULL)
            ->where("cycle_id", Session::get('display_cycle'))
            ->get()->count();
        
            if($receipt_notifications_count){
                array_push($notifications['list'], (object)array(
                    'slag'=>'receipt_notifications',
                    'count' => $receipt_notifications_count,
                    'link' => 'modules/receipt_notifications'
                    )
                );
            }
        }

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            $user_invs = $user->getInventoriesIds();

            $receipt_items_notifications_count = TransferTracking::whereIn('destination',$user_invs)
            ->where('status','!=', 1)
            ->where("cycle_id", Session::get('display_cycle'))
            ->get()->count();

            if($receipt_items_notifications_count){
                array_push($notifications['list'], (object)array(
                    'slag'=>'receipt_items_notifications',
                    'count' => $receipt_items_notifications_count,
                    'link' => 'modules/receipt_items_notifications'
                    )
                );
            }
        }
        
        if(count($notifications['list']) > 0){
            $notifications['status'] = true;
        }

        return collect($notifications);
        
    }

    //check if there any entries or itemtracking next of deleted bill , voucher, transfer tracking, inventory beginning tracking
    public function checkBeforeDelete($path,$id)
    {
        $change_delete_msg = false;
        $new_massege = "";
        if($path && $id){
            switch($path){
                case 'bills_purchase_invoice':
                case 'bills_purchase_return_invoice':
                case 'bills_sales_invoice':
                case 'bills_sales_return_invoice':
                    //check entries
                    $bill = Bill::find($id);
                    $bill_accounts = array($bill->debit,$bill->credit);
                    $next_entries_related = Entry::whereIn('account_id', $bill_accounts)
                                                    ->where('currency_id', $bill->currency_id)
                                                    ->where('create_at', '>', $bill->create_at)
                                                    ->where('action',NULL)
                                                    ->where('cycle_id',Session::get('display_cycle'))
                                                    ->get(); 
                  
                    if($next_entries_related->count() > 0){
                        $change_delete_msg = true;
                    }
                    
                    //check item tracking                                
                    $bill_items_ids = BillItem::where('bill_id',$bill->id)->pluck('item_id')->toArray();
                    $bill_transaction_operation = ItemTracking::where('bill_id', $bill->id)->first()->transaction_operation;
                    
                    if($bill_transaction_operation == 'in'){
                        $next_item_tracking_related = ItemTracking::whereIn('item_id',$bill_items_ids)
                        ->where('transaction_operation','out')
                        ->where('source',$bill->inventory_id)
                        ->where('date', '>', $bill->date)
                        ->where('status',1)
                        ->where('action',NULL)
                        ->where('cycle_id',Session::get('display_cycle'))
                        ->get(); 
                       
                        if($next_item_tracking_related->count() > 0){
                            $change_delete_msg = true;
                        }
                    }
                    $new_massege = trans('messages.delete_this_bill_maybe_effect_on_system_because_some_bill_items_or_bill_accounts_used_after_bill_date');
                    break;
                case 'receipt_voucher':
                case 'payment_voucher':
                case 'daily_voucher':
                    $voucher = Voucher::find($id);
                    $voucher_entry = $voucher->entries()->whereNotNULL('debit')->first();
                    if($voucher_entry){
                        $debit = $voucher->debit;
                        $next_entries_related = Entry::where('account_id', $debit)
                        ->whereNotNULL('credit')
                        ->where('create_at', '>', $voucher_entry->create_at)
                        ->where('status',1)
                        ->where('action',NULL)
                        ->where('cycle_id',Session::get('display_cycle'))
                        ->get();
                        if($next_entries_related->count() > 0){
                            $change_delete_msg = true;
                        }
                    }
                    $new_massege = trans('messages.delete_this_voucher_maybe_effect_on_system_because_debit_account_has_paid_operations_after_voucher_date');                 
                    break;
                case 'transfer_vouchers':
                    $tv_status = Voucher::find($id)->status;
                    if($tv_status == 1){
                        $change_delete_msg = true;
                    }
                    $new_massege = trans('messages.delete_transfer_voucher_effect_on_system_because_amount_receipt_by_debit_account');                 
                    break;    
                case 'initial_voucher':
                    $initial_voucher_group = InitialVouchersGroup::find($id);
                   
                    $initial_voucher_list_accounts = InitialVouchersList::where('iv_group_id', $id)->distinct('account_id')->pluck('account_id')->toArray();
                    $accounts_bills = Bill::select('id')
                                            ->where('date','>',$initial_voucher_group->date)
                                            ->whereIn('debit', $initial_voucher_list_accounts)
                                            ->orWhereIn('credit', $initial_voucher_list_accounts)
                                            ->get();
                                            
                    $accounts_vouchers = Voucher::select('id')
                                                   ->where('date','>',$initial_voucher_group->date)
                                                   ->whereIn('debit', $initial_voucher_list_accounts)
                                                   ->orWhereIn('credit', $initial_voucher_list_accounts)
                                                   ->get();

                    if (($accounts_bills->count() > 0) || ($accounts_vouchers->count() > 0)) {
                        $change_delete_msg = true;
                    }                               
                    
                    $new_massege = trans('messages.delete_initial_vouchers_maybe_effect_on_system_because_accounts_used_in_bills_or_vouchers_after_voucher_date');                 
                    break;
                case 'inventory_beginning':
                    $bi_track = BeginningTracking::find($id);
                    $next_item_tracking_related = ItemTracking::where('source',$bi_track->source)
                    ->where('transaction_operation','out')
                    ->where('date', '>', $bi_track->date)
                    ->where('status',1)
                    ->where('action',NULL)
                    ->where('cycle_id',Session::get('display_cycle'))
                    ->get();

                    if($next_item_tracking_related->count() > 0){
                        $change_delete_msg = true;
                    }
                    $new_massege = trans('messages.delete_inventory_beginning_maybe_effect_on_system_because_some_items_takeout_inventory_after_voucher_date');                 
                    break;

                case 'transfer_items':
                    $ti_status = TransferTracking::find($id)->status;
                    if($ti_status == 1 || $ti_status == 2){
                        $change_delete_msg = true;
                    }
                    $new_massege = trans('messages.delete_transfer_items_maybe_effect_on_system_because_items_be_receipted_by_inventory_delegate');                 
                    break;

                case 'items':
                    $it = ItemTracking::where('item_id', $id)->get();
                    if($it->count() > 0){
                        $change_delete_msg = true;
                    }
                    $new_massege = trans('messages.delete_item_used_in_system_alert');                 
                    break;

                case 'accounts':
                    $entries = Entry::where('account_id', $id)->get();
                    if($entries->count() > 0){
                        $change_delete_msg = true;
                    }
                    $new_massege = trans('messages.delete_account_used_in_system_alert');                 
                    break;
                case 'persons':
                case 'suppliers':    
                    $person_account_id = Person::find($id)->account_id;
                    $entries = Entry::where('account_id', $person_account_id)->get();
                    if($entries->count() > 0){
                        $change_delete_msg = true;
                    }
                    if($path == 'suppliers'){
                        $new_massege = trans('messages.delete_supplier_used_in_system_alert');  
                    } else {
                        $new_massege = trans('messages.delete_customer_used_in_system_alert');  
                    }
                    break;
                case 'inventories':    
                    $item_tracking = ItemTracking::where('source', $id)->get();
                    if($item_tracking->count() > 0){
                        $change_delete_msg = true;
                    }
                    $new_massege = trans('messages.delete_inventory_used_in_system_alert');  
                   
                    break;     


                default:
                    $change_delete_msg = false;
                    break;    
            }
        }
        
        if($change_delete_msg){
            return json_encode(array('status'=>'warning','massege'=>"$new_massege"));
        } else {
            return json_encode(array('status'=>'success','massege'=>trans('crudbooster.delete_description_confirm')));        
        }

    }


    public function getDaysBetweenTwoDate($start, $end)
    {
		$start = strtotime($start);
		$end = strtotime($end);
		$days_between = ceil(abs($end - $start) / 86400);
        return $days_between;
    }

    public function getFolderSize($folder_path)
    {
        if (file_exists($folder_path)) {
            $all_size = 0;
            foreach (File::allFiles($folder_path) as $file) {
                $all_size += $file->getSize();
            }
            return number_format($all_size / 1048576, 2); //in Mega
        } else {
            mkdir($folder_path, 0755, true);
            return number_format(0, 2);
        }

    }
    public function createAjaxSelect2($name,$label,$datatable,$where,$format,$value = 0)
    {
        $value = ($value)?$value:$_REQUEST["$name"];
        $raw = explode(',', $datatable);
        $url = '/find-data';

        $table1 = $raw[0];
        $column1 = $raw[1];

        @$table2 = $raw[2];
        @$column2 = $raw[3];

        @$table3 = $raw[4];
        @$column3 = $raw[5];

        return array(
            'html' => "<select class='form-control ajax-select2' name='$name' id='select-ajax-$name'> </select>",
            'script' => "
                <script>
                
                        $('#select-ajax-$name').select2({
                            language: 'ar',
                            placeholder: {
                                id: '-1',
                                text: '".trans('crudbooster.text_prefix_option')." $label'
                            },
                            allowClear: true,
                            ajax: {
                                url: '$url',
                                delay: 250,
                                data: function (params) {
                                    var query = {
                                        q: params.term,
                                        format: '$format',
                                        table1: '$table1',
                                        column1: '$column1',
                                        table2: '$table2',
                                        column2: '$column2',
                                        table3: '$table3',
                                        column3: '$column3',
                                        where: '".addslashes($where)."'
                                    }
                                    return query;
                                },
                                processResults: function (data) {
                                    return {
                                        results: data.items
                                    };
                                }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 1,
                            ".(($value)?"
                                initSelection: function (element, callback) {
                                    var id = $(element).val() ? $(element).val() : '$value';
                                    if (id !== '') {
                                        $.ajax('$url', {
                                            data: {
                                                id: id,
                                                format: '$format',
                                                table1: '$table1',
                                                column1: '$column1',
                                                table2: '$table2',
                                                column2: '$column2',
                                                table3: '$table3',
                                                column3: '$column3'
                                            },
                                            dataType: 'json'
                                        }).done(function (data) {
                                            callback(data.items[0]);
                                            $('#select-ajax-$name').html(\"<option value='\" + data.items[0].id + \"' selected >\" + data.items[0].text + \"</option>\");
                                        });
                                    }
                                }
                            ":"")."
                           
                            

                            
                        });
                </script>
            
        "
        );
    }
    public function findData()
	{
		$q = Request::get('q');
        $id = Request::get('id');
        $limit = Request::get('limit') ?: 10;
        $format = Request::get('format');

        $table1 = Request::get('table1');
        $table1PK = CB::pk($table1);
        $column1 = Request::get('column1');

        @$table2 = Request::get('table2');
        @$column2 = Request::get('column2');

        @$table3 = Request::get('table3');
        @$column3 = Request::get('column3');

        $where = Request::get('where');

        $fk = Request::get('fk');
        $fk_value = Request::get('fk_value');

        if ($q || $id || $table1) {
            $rows = DB::table($table1);
            $rows->select($table1.'.*');
            $rows->take($limit);

            if (CRUDBooster::isColumnExists($table1, 'deleted_at')) {
                $rows->where($table1.'.deleted_at', null);
            }

            if ($fk && $fk_value) {
                $rows->where($table1.'.'.$fk, $fk_value);
            }

            if ($table1 && $column1) {

                $orderby_table = $table1;
                $orderby_column = $column1;
            }

            if ($table2 && $column2) {
                $table2PK = CB::pk($table2);
                $rows->join($table2, $table2.'.'.$table2PK, '=', $table1.'.'.$column1);
                $columns = CRUDBooster::getTableColumns($table2);
                foreach ($columns as $col) {
                    $rows->addselect($table2.".".$col." as ".$table2."_".$col);
                }
                $orderby_table = $table2;
                $orderby_column = $column2;
            }

            if ($table3 && $column3) {
                $table3PK = CB::pk($table3);
                $rows->join($table3, $table3.'.'.$table3PK, '=', $table2.'.'.$column2);
                $columns = CRUDBooster::getTableColumns($table3);
                foreach ($columns as $col) {
                    $rows->addselect($table3.".".$col." as ".$table3."_".$col);
                }
                $orderby_table = $table3;
                $orderby_column = $column3;
            }

            if ($id) {
                $rows->where($table1.".".$table1PK, $id);
            }

            if ($where) {
                $rows->whereraw($where);
            }

            if ($format) {
                $format = str_replace('&#039;', "'", $format);
                $rows->addselect(DB::raw("CONCAT($format) as text"));
                if ($q) {
                    $rows->whereraw("CONCAT($format) like '%".$q."%'");
                }
            } else {
                $rows->addselect($orderby_table.'.'.$orderby_column.' as text');
                if ($q) {
                    $rows->where($orderby_table.'.'.$orderby_column, 'like', '%'.$q.'%');
                }
                $rows->orderBy($orderby_table.'.'.$orderby_column, 'asc');
            }

            $result = [];
            $result['items'] = $rows->get();
        } else {
            $result = [];
            $result['items'] = [];
        }

		return response()->json($result);

	}

    //########################################
    //             Test
    //########################################

    //اختبار الحسابات التراجعية
    public function getBalancesTest($accout_id){
        
        /*
        $childernBalances = array();
        $this->getAccountChildernBalances($accout_id,$childernBalances);
        return json_encode($childernBalances);
        */
        $currencies_balance = array();
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($activeCurrencies as $curr){
            $currencies_balance['curr_balance_'.$curr->id] = 0;
        }
        
        $this->getAccountBalance_sum_childrenBalances($accout_id,$currencies_balance);
        dd($currencies_balance);
    }

    //اختبار الحسابات الإغلاق
    public function getClosed_account_balance($closing_account_type){

        $accountsIDs = $this->getAccountsIDsListInClosingAccountType($closing_account_type);
        $childernBalances = array();
        $result = $this->getClosingAccountTypeBalanceAsArray($closing_account_type,$accountsIDs,$childernBalances);
       
         return json_encode($result);       
    }


        //test
        public function SendMail() {

			$data = ['name'=>"haider",'email'=>"haider.ali.issa@gmail.com",'message'=>"message here"];
			CRUDBooster::sendEmail(['to'=>'haider.ali.issa@gmail.com','data'=>$data,'template'=>'forgot_password_backend','attachments'=>[]]);
		     
		}

        

        public function emptyDBMainTables(){
           
            ItemTracking::truncate();
            echo "Items Tracking table is Empty now. done...<br/>";

            Entry::truncate();
            echo "entries table is Empty now. done...<br/>";
    
            EntryBase::truncate();
            echo "entry_base table is Empty now. done...<br/>";
    
            Bill::truncate();
            echo "Bills table is Empty now. done...<br/>";
    
            BillFile::truncate();
            echo "bills_files table is Empty now. done...<br/>";
    
            BillItem::truncate();
            echo "bills_items table is Empty now. done...<br/>";

            Voucher::truncate();
            echo "Vouchers table is Empty now. done...<br/>";
            
            VoucherFile::truncate();
            echo "vouchers_files table is Empty now. done...<br/>";

            TransferTracking::truncate();
            echo "Transfer Tracking table is Empty now. done...<br/>";

            TransferTrackingList::truncate();
            echo "Transfer Items List table is Empty now. done...<br/>";

            TransferTrackingNote::truncate();
            echo "Transfer Items Notes table is Empty now. done...<br/>";

            BeginningTracking::truncate();
            echo "Inventory Beginning Tracking table is Empty now. done...<br/>";

            BeginningTrackingList::truncate();
            echo "Inventory Beginning Items List table is Empty now. done...<br/>";

            InitialVouchersGroup::truncate();
            echo "Initial Vouchers Groups table is Empty now. done...<br/>";

            InitialVouchersList::truncate();
            echo "Initial Vouchers List table is Empty now. done...<br/>";
            
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
            
            echo "<br>-------------------------------------------------<br/>";
            echo "DATABASE is Empty. you can make your Test";
            echo "<br>-------------------------------------------------<br/>";
    
            //return true;
    
        }
}

