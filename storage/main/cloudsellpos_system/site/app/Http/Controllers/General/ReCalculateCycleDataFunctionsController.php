<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\General;

use App\Models\FinancialCycles\FinancialCycle;
use App\Models\SystemConfigration\SystemSetting;
use Illuminate\Support\Facades\File; 
use App\Http\Controllers\Data\BackupController;
use App\Models\Accounts\Supplier;
use App\Models\Bills\BillFile;
use App\Models\Inventories\BeginningTracking;
use App\Models\Inventories\BeginningTrackingList;
use App\Models\Inventories\TransferTracking;
use App\Models\Inventories\TransferTrackingNote;
use App\Models\Users\GeneralDelegate;
use App\Models\Vouchers\InitialVouchersGroup;
use App\Models\Vouchers\InitialVouchersList;
use App\Models\Vouchers\VoucherFile;
use Illuminate\Support\Facades\DB;
use CRUDBooster;
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

class ReCalculateCycleDataFunctionsController extends GeneralFunctionsController{
    
    #####################################################################################################################
    ###################### Function Using with Re Calculate Data after edit old Cycle ###################################
    #####################################################################################################################


    //حساب الأرصدة الإفتتاحية للسنة المالية محددة
    public function calculate_opening_balances_for_cycle($cycle_id){
        //query from db to get information
		//جلب حسابات التي دخل بحساب الأرصدة الافتتاحية 
		//وهي الصناديق و الزبائن والموردين و المندوبين
		//-------------------------------------------------------
        $choosen_account_ids=array();
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($activeCurrencies as $curr){
            array_push($choosen_account_ids,$curr->account_id);
        }

		$persons_account_ids=Person::select('account_id')->get();
        
		foreach($persons_account_ids as $person){
			array_push($choosen_account_ids,$person->account_id);
		}

		$users_has_box_account_ids=User::select('account_id')->where('account_id','!=',0)->get();
		foreach($users_has_box_account_ids as $user){
			array_push($choosen_account_ids,$user->account_id);
		}
		//-------------------------------------------------------

		$accounts = Account::select('id','name_ar')->whereIn('id',$choosen_account_ids)->get();

		//get balance in all choosen accounts that have entries in system
		$accounts_with_balance=collect();
        foreach($accounts as $account){
				$conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=', $cycle_id ]);
                $query = Entry::select('accounts.id as id',
                				'accounts.name_ar as name',
                				'currencies.name_ar as currency',
                				'currencies.id as currency_id',
                                'entries.debit',
                                'entries.credit',
                                'entries.ex_rate',
                                'entries.equalizer'
                                )
					->join("entry_base", "entry_base.id", "entries.entry_base_id")
					->join("accounts", "accounts.id", "entries.account_id")
					->join("currencies", "currencies.id", "entries.currency_id")
					->where($conditions)
					->where('accounts.id',$account->id)
                    ->orWhereNull('entries.create_at')
                    ->where($conditions)
					->where('accounts.id',$account->id);
				$res = $query->get();
                //change equalizer sginal base on debit or credit
                $res->each(function($item){
                    if($item->debit == NULL){
                        $item->equalizer = -1 * $item->equalizer;
                    }
                });
                $acc_info=collect();
                foreach($activeCurrencies as $curr){

                    $group = $res->filter(function($item) use($curr){
                        return $item->currency_id == $curr->id;
                    })->values();
                    if($group){
                        $all_paid_amount=$group->sum('credit');
                        $all_received_amount=$group->sum('debit');
                        $curr_balance= $all_received_amount - $all_paid_amount;
                        $equalizer_balance= $group->sum('equalizer');
                        if($curr_balance != 0 || $equalizer_balance != 0){
                            $first_rec = $group->first();
                            $temp = collect([
                                'id'=>$first_rec->id,
                                'name'=>$first_rec->name,
                                'currency'=>$first_rec->currency,
                                'currency_id'=>$first_rec->currency_id,
                                'all_paid_amount'=>$all_paid_amount,
                                'all_received_amount'=>$all_received_amount,
                                'curr_balance'=>$curr_balance,
                                'equalizer_balance'=>$equalizer_balance
                            ]);

                            $acc_info->push($temp);
                        }
                    }
                }
                if($acc_info->count() > 0){
                    $accounts_with_balance->push($acc_info);	
                }  			
		}
       
        //dd($accounts_with_balance);
        $final_balances = array();
        $final_balances['final_equalizer'] = 0;
        foreach($activeCurrencies as $curr){
            $final_balances['final_balance_'.$curr->id] = 0;
        }
        

		$accounts_info = array();
		foreach($accounts_with_balance as $items){
             //dd($items);   
			 if(count($items) > 0 ){
					$arr=array('account_id'=>0,'account_name'=>'','equalizer_balance'=>0);
                    foreach($activeCurrencies as $curr){
                        $arr['curr_balance_'.$curr->id] = 0;
                    }
                    $account_equalizer_balance=0;
                    foreach($items as $item){
                        //dd($item);
						$arr['account_id']=$item['id'];
						$arr['account_name']=$item['name'];
                        
                        $arr['curr_balance_'.$item['currency_id']] = $item['curr_balance'];
                        $account_equalizer_balance += $item['equalizer_balance'];
                        $final_balances['final_balance_'.$item['currency_id']] += $item['curr_balance'];
					}
                    $arr['equalizer_balance'] = $account_equalizer_balance;
                    $final_balances['final_equalizer'] += $account_equalizer_balance;	
                    array_push($accounts_info,$arr);
				}
		}
        
		$accounts_info=collect($accounts_info);
        //dd($accounts_info);
        $result = array(
            'accounts_info' => $accounts_info
        );
        foreach($activeCurrencies as $curr){
            $result['final_balance_'.$curr->id] = $final_balances['final_balance_'.$curr->id];
        }
            $result['final_equalizer'] = $final_balances['final_equalizer'];
        //dd($result);
        return $result;
    }

   
     //حساب المخزون المتبقي ضمن المستودعات للسنة المالية الجديدة
     public function getItemsAmountInAllInventories_for_cycle($cycle_id){
     
        $query2 = DB::table("item_tracking as t0")
		->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
            'source.id as sourceInventory_id',
			DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
						WHERE t1.transaction_operation = 'in'
                        and t1.status = 1  
						and t1.action is NULL
                        and t1.cycle_id = $cycle_id 
						and t1.item_id = t0.item_id 
						and t0.source = t1.source 
						) as item_in "),
			DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
					   WHERE t2.transaction_operation = 'out'
                        and t2.status = 1 
						and t2.action is NULL
                        and t2.cycle_id = $cycle_id   
						and t0.item_id = t2.item_id and t0.source = t2.source) as item_out"))
						->join("items", "items.id", "t0.item_id")
						->leftjoin("inventories as source","t0.source", "source.id")

		->GROUPby('itemId','t0.source');
                $query2->where('t0.status', 1);
				$query2->where('t0.action',NULL);
                $query2->where('t0.cycle_id',$cycle_id);
				$query2->orderby('source.name_ar','desc');
		$inventories_data = $query2->get();

        return $inventories_data;
    }


    //جلب قائمة بالكلف التقديرية لكل مادة حسب طريقة حساب الكلفة المختارة بإعدادات التدوير
    //حيث نقوم بحساب متوسط  سعر المادة بفواتير المشتريات
    //واسعار المواد التي تكون بالدولار نقوم بضربها بقيمة سعر الصرف
    //أو تكون كلفة المادة هي أخر سعر شراء
    public function getItemsCostList_for_cycle($item_cost_type,$cycle_id){
       
        $items_cost_list = array();
        if($item_cost_type == 1){ //حساب تكلفة المادة كوسطي سعر المادة بفواتير الشراء
            $query = BillItem::select('items.id as itemId','items.name_ar as nameAr','items.cost as item_cost',         
                    DB::raw("(SELECT avg(bills_items.unit_price * bills.ex_rate) as new_unit_price 
                            FROM `bills_items` , `bills` 
                            WHERE bills_items.bill_id = bills.id 
                                    and bills_items.item_id = itemId
                                    and bills.bill_type_id = 1  
                                    and bills.action is NULL
                                    and bills.cycle_id = ".$cycle_id."   
                                    group by bills_items.item_id) as new_item_cost "))
                                ->join("items", "items.id", "bills_items.item_id")
                                ->leftjoin("bills","bills_items.bill_id", "bills.id")

                ->GROUPby('itemId');
                $query->where('bills.action',NULL);
                $query->where('bills.cycle_id',$cycle_id);
                

                $items_cost_list = $query->get();
            
              
        }else{ //تكلفة بأخر سعر شراء
            $query = BillItem::select('items.id as itemId','items.name_ar as nameAr','items.cost as item_cost',         
                    DB::raw("(SELECT  (bills_items.unit_price * bills.ex_rate) as new_unit_price 
                    FROM `bills_items` , `bills` 
                    WHERE bills_items.bill_id = bills.id 
                            and bills_items.item_id = itemId
                            and bills.bill_type_id = 1 
                            and bills.action is NULL
                            and bills.cycle_id = ".$cycle_id."  
                            ORDER BY bills.id DESC
                            LIMIT 1) as new_item_cost "))
                                ->join("items", "items.id", "bills_items.item_id")
                                ->leftjoin("bills","bills_items.bill_id", "bills.id")

                ->GROUPby('itemId');
                $query->where('bills.action',NULL);
                $query->where('bills.cycle_id',$cycle_id);

                $items_cost_list = $query->get();
            
        }
                
        
        $items_purchase_ids = $items_cost_list->pluck('itemId')->all();
        $items_purchase_list =$items_cost_list->pluck('new_item_cost','itemId')->all();

        $items_info = Item::select('id','name_ar','cost')->get();
        $final_items_cost_list = array();
        foreach($items_info as $item){
             $new_cost = 0;
             $item_cost = $item->cost !=null?$item->cost:0;
             if(in_array($item->id,$items_purchase_ids)){
                 $purchase_cost = $items_purchase_list[$item->id] != null?$items_purchase_list[$item->id]:0;
                 if($purchase_cost > 0){
                     if($item_cost_type == 1){ //وسطي الكلف
                        $new_cost =  ($item_cost + $purchase_cost)/2;
                     }else{ //أخر سعر شراء
                        $new_cost = $purchase_cost;
                     }
                 }else{    
                    $new_cost = $item_cost;
                 }  
             }else{
                $new_cost = $item_cost;
             }

             $final_items_cost_list[$item->id] = array('name_ar'=>$item->name_ar,'cost'=> $new_cost);
        }
        return $final_items_cost_list;
    }

      //حساب قيمة التقديرية لبضاعة أخر المدة ب ل.س لسنة مالية محددة
      public function calculate_last_inventories_items_value_for_cycle($cycle_id,$items_cost_list){
        

        $last_inventories_items = $this->getItemsAmountInAllInventories_for_cycle($cycle_id);
        //dd($last_inventories_items);
        $last_inventories_items_value = 0;
        foreach($last_inventories_items as $item){
            $item_in = $item->item_in!=null?$item->item_in:0;
            $item_out = $item->item_out!=null?$item->item_out:0;

            //جلب كلفة المادة من قائمة الكلف
            $item_cost = $items_cost_list[$item->itemId]['cost'];
            
            $item_value = ($item_in - $item_out) *  $item_cost;
            $last_inventories_items_value += $item_value;
        }

        return $last_inventories_items_value;
    }

      //جلب بضاعة أول مدة والتي دخلت النظام كبضاعة أول مدة 
      public function getBeginItemsAmountInAllInventories_for_cycle($cycle_id){
        
        $query = DB::table("item_tracking as t0")
		->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
            'source.id as sourceInventory_id',
			DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
						WHERE t1.transaction_operation = 'in' 
                        and (t1.item_tracking_type_id = 5)
                        and t1.status = 1
						and t1.action is NULL 
                        and t1.cycle_id = ".$cycle_id."
						and t1.item_id = t0.item_id 
						and t0.source = t1.source 
						) as item_in ")
			            )
						->join("items", "items.id", "t0.item_id")
						->leftjoin("inventories as source","t0.source", "source.id")

		->GROUPby('itemId','t0.source');
                $query->where('t0.status',1);
				$query->where('t0.action',NULL);
                $query->where('t0.cycle_id',$cycle_id);
               
				$query->orderby('source.name_ar','desc');
		$inventories_data = $query->get();
        
        return $inventories_data;
    }

    //حساب قيمة التقديرية لبضاعة أول المدة ب ل.س
    //بضاعة أول المدة = بضاعة أول المدة سنة مالية محددة
    public function calculate_begin_inventories_items_value_for_cycle($cycle_id,$items_cost_list){
        

        $begin_items = $this->getBeginItemsAmountInAllInventories_for_cycle($cycle_id);
        //dd($begin_items);
        $begin_inventories_items_value = 0;
        foreach($begin_items as $item){
            $item_in = $item->item_in!=null?$item->item_in:0;

            //جلب كلفة المادة من قائمة الكلف
            $item_cost = $items_cost_list[$item->itemId]['cost'];
            
            $item_value = $item_in *  $item_cost;
            $begin_inventories_items_value += $item_value;
        }

        return $begin_inventories_items_value;
    }

    public function getLastEx_rate(){
        
         $ex_rate_at_date = array();            
         $currencies_not_majer = $this->getCurrencies_Not_Major();
         foreach($currencies_not_majer as $curr){

        $result = CurrencyHistory::select('currency_history.currency_id','currencies.name_ar','currency_history.ex_rate')    
            ->where('currency_history.currency_id',$curr->id)
            ->join('currencies','currency_history.currency_id','currencies.id')
            ->orderby('edit_at','desc')
            ->first();
             $ex_rate_at_date[$curr->id] = $result->ex_rate;
         }
        //dd($ex_rate_at_date);
         //check if get correct ex_rate and not null
         foreach($currencies_not_majer as $curr){
             if($ex_rate_at_date[$curr->id] == null){
                $ex_rate_at_date[$curr->id] = Currency::where('id',$curr->id)->first()->ex_rate;
             }
         }
         return $ex_rate_at_date;
     }

     
    public function getAccountBalanceUseingEqualizer_for_cycle($account_id,$cycle_id){
        
        $conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  $cycle_id ]);
        $query = Entry::select(
            'accounts.id as id',
            'accounts.name_ar as name',
            DB::raw('sum(IFNULL(entries.equalizer,0)) as sum_equalizer')
        )
            ->join("entry_base", "entry_base.id", "entries.entry_base_id")
            ->join("accounts", "accounts.id", "entries.account_id")
            ->join("currencies", "currencies.id", "entries.currency_id")
            ->where($conditions)
            ->where('accounts.id',$account_id)
            ->orWhereNull('entries.create_at')
            ->where($conditions)
            ->where('accounts.id',$account_id);
        $res = $query->first();
        
        $value = $res->sum_equalizer;
            
        return $value;
    }

    public function getAccountBalance_for_cycle($account_id,$cycle_id){

        $conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  $cycle_id]);
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

     //جلب  رصيد حساب تجميعي معين
     public function getAccountBalance_sum_childrenBalances_for_cycle($account_id,$cycle_id,&$final_balances){
        
        $hasChilds=$this->checkIfAccountHasChildren($account_id);
        
        if($hasChilds){
            $children = $this->getFirstChildernForAccount($account_id);
            foreach($children as $child){
                $this->getAccountBalance_sum_childrenBalances_for_cycle($child->id,$cycle_id,$final_balances);
            }
        }else{
            $bal=$this->getAccountBalance_for_cycle($account_id,$cycle_id);
            if(count($bal) > 0){
                foreach($bal as $item){
                    $final_balances['final_balance_'.$item->currency_id] += $item->curr_balance; 
                }
            }
               
        }

    }

    //حساب الأرباح والخسائر لسنة مالية محددة
    public function calculateProfitsAndLoss_for_cycle($cycle_id){

        //setting
        $setting = Session::get('rotate_setting');
        //dd($setting);
        $bals_all_values = Session::get('rotate_bals_all_values');
        
        $items_cost_list = $this->getItemsCostList_for_cycle($setting['item_cost_type'],$cycle_id);
        Session::put('new_items_cost', $items_cost_list);
        //dd($items_cost_list);

        //حساب قيمة بضاعة أخر المدة للدورة المالية المحددة
        $last_inventories_items_value = $this->calculate_last_inventories_items_value_for_cycle($cycle_id,$items_cost_list);
        //dd($last_inventories_items_value);
       
        //حساب قيمة  بضاعة أول مدة 
        $begin_inventories_items_value = $this->calculate_begin_inventories_items_value_for_cycle($cycle_id,$items_cost_list);
        //dd($begin_inventories_items_value);
      
        //dd($setting);
        //سعر الصرف المدخلة مع الإعدادات
        $ex_rate_now=$setting;
    
        //قيمة فرق سعر الصرف
        $majorCurrency = $this->getMajorCurrency();
        $currencies_not_majer = $this->getCurrencies_Not_Major();
        
        $ex_rate_difference_value=0;
        $all_bals_value_now = $bals_all_values['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_bals_value_now += ($bals_all_values['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }
        
        $ex_rate_difference_value = $all_bals_value_now - $bals_all_values['final_equalizer'];
        
     
        $sales_inMajorCurrency = $this->getAccountBalanceUseingEqualizer_for_cycle($this->getSystemConfigValue('Sales_Account'),$cycle_id);
        $purchases_return_inMajorCurrency = $this->getAccountBalanceUseingEqualizer_for_cycle($this->getSystemConfigValue('Purchases_Return_Account'),$cycle_id);
        $purchases_inMajorCurrency= $this->getAccountBalanceUseingEqualizer_for_cycle($this->getSystemConfigValue('Purchases_Account'),$cycle_id);
        $sales_return_inMajorCurrency = $this->getAccountBalanceUseingEqualizer_for_cycle($this->getSystemConfigValue('Sales_Return_Account'),$cycle_id);
        $earned_discount_inMajorCurrency = $this->getAccountBalanceUseingEqualizer_for_cycle($this->getSystemConfigValue('Earned_Discount'),$cycle_id);
        $granted_discount_inMajorCurrency = $this->getAccountBalanceUseingEqualizer_for_cycle($this->getSystemConfigValue('Granted_Discount'),$cycle_id);

        //dd($granted_discount_inMajorCurrency);
        
        //  جلب قيمة الإيرادات لدورة مالية محددة
        $incomes_balances = array();
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($activeCurrencies as $curr){
            $incomes_balances['final_balance_'.$curr->id] = 0;
        }

        $this->getAccountBalance_sum_childrenBalances_for_cycle($this->getSystemConfigValue('Incomes_Account'),$cycle_id,$incomes_balances);        
        $all_incomes = $incomes_balances['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_incomes +=($incomes_balances['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }
        //dd($all_incomes);
        
        

        //جلب قيمة المصاريف لدورة مالية محددة
        $outgoings_balances = array();
        foreach($activeCurrencies as $curr){
            $outgoings_balances['final_balance_'.$curr->id] = 0;
        }
        $this->getAccountBalance_sum_childrenBalances_for_cycle($this->getSystemConfigValue('Outgoings_Account'),$cycle_id,$outgoings_balances);
        $all_outgoings = $outgoings_balances['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_outgoings +=($outgoings_balances['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }
        //dd($all_outgoings);

        //gross profit مجمل الربح
        //مجمل الربح = المبيعات+ مردود مشتريات + الحسم المكتسب +   بضاعة اخر المدة  - (بضاعة أول المدة + المشتريات + مردود مبيعات + الحسم الممنوح)
        //or
        //مجمل الربح = المبيعات - مردود المبيعات - الحسم الممنوح +بضاعة أخر المدة  - (بضاعة أول المدة + المشتريات - مرود المشتريات - الحسم المكتسب)
        $gross_profit_credit  = $sales_inMajorCurrency + $purchases_return_inMajorCurrency + $earned_discount_inMajorCurrency + $last_inventories_items_value;  
        $gross_profit_debit = $begin_inventories_items_value +  $purchases_inMajorCurrency + $sales_return_inMajorCurrency + $granted_discount_inMajorCurrency ;
        $gross_profit = $gross_profit_credit - $gross_profit_debit;

        //Net profit صافي الربح
        //صافي الربح = مجمل الربح  + الإيرادات -(كافة المصاريف)
        $net_profit_credit = $gross_profit + $all_incomes;
        $net_profit_debit = $all_outgoings;
        $net_profit = $net_profit_credit - $net_profit_debit;

        $result = array(
            'gross_profit'=>$gross_profit,
            'gross_profit_credit'=>$gross_profit_credit,
            'gross_profit_debit'=>$gross_profit_debit,
            'net_profit'=>$net_profit,
            'net_profit_credit'=>$net_profit_credit,
            'net_profit_debit'=>$net_profit_debit,
            'sales_inMajorCurrency'=>$sales_inMajorCurrency,
            'purchases_return_inMajorCurrency'=>$purchases_return_inMajorCurrency,
            'purchases_inMajorCurrency'=>$purchases_inMajorCurrency,
            'earned_discount_inMajorCurrency'=>$earned_discount_inMajorCurrency,
            'granted_discount_inMajorCurrency'=>$granted_discount_inMajorCurrency,
            'sales_return_inMajorCurrency'=>$sales_return_inMajorCurrency,
            'last_inventories_items_value'=>$last_inventories_items_value,
            'begin_inventories_items_value'=>$begin_inventories_items_value,
            'all_incomes_inMajorCurrency'=>$all_incomes,
            'all_outgoings_inMajorCurrency'=>$all_outgoings,
            'ex_rate_difference_value' => $ex_rate_difference_value,
            'items_cost_list'=>$items_cost_list
        );

        
        //Storage::disk('local')->append('rotate_data_test.txt', json_encode($result)."/n");
        //return json_encode($all_outgoings);
        return  $result;
      
    }

    public function upgrade_current_cycle_initial_balances($new_initial_balances)
    {
        $cycle_setting =Session::get('rotate_setting');
        $rotate_date = $cycle_setting['rotate_date'];
        $date_after_rotate_date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
        //get initial baclance package id in current cycle
        $initial_balances_package_in_current_cycle_id = InitialVouchersGroup::where('cycle_id', Session::get('current_cycle'))
            ->where('date', $date_after_rotate_date)
            ->orderby('date', 'desc')
            ->first()->id;
        
        foreach ($new_initial_balances as $ib) {
            //dd($ib);
            $activeCurrencies = $this->getActiveCurrencies();
            foreach ($activeCurrencies as $curr) {
                //check if inital balance exist
                $old_ib = InitialVouchersList::where('iv_group_id', $initial_balances_package_in_current_cycle_id)
                    ->where('currency_id', $curr->id)
                    ->where('account_id', $ib['account_id'])->first();

                if($old_ib){ //found 
                    if((float)$ib['curr_balance_'.$curr->id] != 0){
                        //change InitialVouchersList record value
                        $old_ib->update([
                                'amount'=> $ib['curr_balance_'.$curr->id]
                        ]);
                        //change initial voucher  entries (voucher, entries)
                        if((float)$ib['curr_balance_'.$curr->id] > 0){ 
                            //change voucher record
                            $iv = Voucher::where('p_code', $old_ib->p_code)->where('cycle_id', Session::get('current_cycle'))->first();
                            $iv->update([
                                'debit'=>$ib['account_id'],
                                'credit'=>0,
                                'amount'=>$ib['curr_balance_'.$curr->id],
                                'equalizer'=>$ib['curr_balance_'.$curr->id]*$iv->ex_rate
                            ]);
                            //change entries record
                            $iv_entry_base = EntryBase::where('voucher_id', $iv->id)->first();
                            $iv_entry = Entry::where('entry_base_id', $iv_entry_base->id)->first();
                            $iv_entry->update([
                                'debit'=>abs($ib['curr_balance_'.$curr->id]),
                                'credit'=>NULL,
                                'equalizer'=>abs($ib['curr_balance_'.$curr->id]) * $iv_entry->ex_rate
                            ]);
                        }else{
                            $iv = Voucher::where('p_code', $old_ib->p_code)->where('cycle_id', Session::get('current_cycle'))->first();
                            $iv->update([
                                'debit'=>0,
                                'credit'=>$ib['account_id'],
                                'amount'=>abs($ib['curr_balance_'.$curr->id]),
                                'equalizer'=>abs($ib['curr_balance_'.$curr->id])*$iv->ex_rate
                            ]);
                            //change entries record
                            $iv_entry_base = EntryBase::where('voucher_id', $iv->id)->first();
                            $iv_entry = Entry::where('entry_base_id', $iv_entry_base->id)->first();
                            $iv_entry->update([
                                'debit'=>NULL,
                                'credit'=>abs($ib['curr_balance_'.$curr->id]),
                                'equalizer'=>abs($ib['curr_balance_'.$curr->id]) * $iv_entry->ex_rate
                            ]);
                        }

                    } else {
                        //delete old initial voucher
                        $iv = Voucher::where('p_code', $old_ib->p_code)->where('cycle_id', Session::get('current_cycle'))->first();
                        $iv_entry_base = EntryBase::where('voucher_id', $iv->id)->first();
                        Entry::where('entry_base_id', $iv_entry_base->id)->delete();
                        $iv_entry_base->delete();
                        $iv->delete();
                        $old_ib->delete();
                    }
                   
                } else {//not found 
                    if((float)$ib['curr_balance_'.$curr->id] != 0){
                        //create new initial voucher
                        $RDFunc = new RotateDataFunctionsController();
                        //generate code and P_code
                        $codes = $RDFunc->generateVoucherP_code(Session::get('current_cycle'));
                        $currency_id = $curr->id;
                        $credit = 0;
                        $debit = 0;
                        if ((float)$ib['curr_balance_'.$curr->id] < 0) {
                            $credit = $ib['account_id'];
                        } else {
                            $debit = $ib['account_id'];
                        }
                        $amount = abs((float)$ib['curr_balance_'.$curr->id]);

                        //بناء سند افتتاحي للدورة المالية الحالية
                        $RDFunc->create_begining_Voucher($codes,$debit,$credit,$currency_id,$amount,$date_after_rotate_date,$initial_balances_package_in_current_cycle_id,Session::get('current_cycle'));
    
                    }
                }     
                
            }

        }
    }

    public function upgrade_current_cycle_beginning_items($new_beginning_items){
        //dd($new_beginning_items);
        $cycle_setting =Session::get('rotate_setting');
        $rotate_date = $cycle_setting['rotate_date'];
        $date_after_rotate_date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
        //dd($date_after_rotate_date);
        foreach($new_beginning_items as $ib){
            $ib->total_qty = (float)$ib->item_in - (float)$ib->item_out;
            //dd($ib);
            $ib_group = BeginningTracking::where('cycle_id',Session::get('current_cycle'))
                                            ->where('date',$date_after_rotate_date)
                                            ->where('source',$ib->sourceInventory_id)->first();
            //dd($ib_group);  
            if($ib_group){ //group found
                $old_bt = BeginningTrackingList::where('ib_tracking_id',$ib_group->id)->where('item_id',$ib->itemId)->first();
                //dd($old_bt);
                if($old_bt){ //item has track
                     //update track
                     $old_bt->update([
                        'quantity'=>$ib->total_qty,
                     ]);
                     $it = ItemTracking::where('p_code',$old_bt->p_code)->where('cycle_id',Session::get('current_cycle'))->first();
                     $it->update([
                        'quantity'=>$ib->total_qty
                     ]);
                }else{ //item doesn't have track
                    //add new track
                    $max = ItemTracking::where("item_tracking_type_id", 5)->where('action',NULL)->where('cycle_id',Session::get('current_cycle'))->max('code');
					$prefixCode = ItemTrackingType::where('id',5)->select('prefix')->first();
					$maxCode = ($max) ? $max + 1 : 1;
					$p_code = $prefixCode->prefix .''. $maxCode;
                    ItemTracking::insert([
                        'code' => $maxCode,
                        'p_code' => $p_code,
                        'item_id' => $ib->itemId,
                        'item_tracking_type_id' => 5,
                        'source' => $ib->sourceInventory_id,
                        'date' =>  $date_after_rotate_date,
                        'quantity' => $ib->total_qty,
                        'note' => trans('modules.begnning_inventory_items'),
                        'transaction_operation' => 'in',
                        'active' => 1,
                        'cycle_id'=> Session::get('current_cycle')
                    ]);
        
                    $item_unit_name=Item::select('item_units.name_ar as unit_name')->where('items.id',$ib->itemId)
                                    ->leftjoin('item_units','item_units.id','items.item_unit_id')->first()->unit_name;
                    BeginningTrackingList::insert([
                        'ib_tracking_id'=>$ib_group->id,
                        'item_id'=>$ib->itemId,
                        'item_unit'=>$item_unit_name,
                        'quantity'=>$ib->total_qty,
                        'p_code'=>$p_code,
                        'cycle_id'=> Session::get('current_cycle')
                    ]);
                }
            }else{//group not found
                //create group and add begging item record
                $bt_group_id = BeginningTracking::insertGetId([
                    'source'=>$ib->sourceInventory_id,
                    'date'=>$date_after_rotate_date,
                    'note'=>trans('labels.begin_track_after_rotate_data'),
                    'staff_id'=>CRUDBooster::myId(),
                    'cycle_id'=> Session::get('current_cycle')
                ]);

                $max = ItemTracking::where("item_tracking_type_id", 5)->where('action',NULL)->where('cycle_id',Session::get('current_cycle'))->max('code');
                $prefixCode = ItemTrackingType::where('id',5)->select('prefix')->first();
                $maxCode = ($max) ? $max + 1 : 1;
                $p_code = $prefixCode->prefix .''. $maxCode;
                ItemTracking::insert([
                    'code' => $maxCode,
                    'p_code' => $p_code,
                    'item_id' => $ib->itemId,
                    'item_tracking_type_id' => 5,
                    'source' => $ib->sourceInventory_id,
                    'date' =>  $date_after_rotate_date,
                    'quantity' => $ib->total_qty,
                    'note' => trans('modules.begnning_inventory_items'),
                    'transaction_operation' => 'in',
                    'active' => 1,
                    'cycle_id'=> Session::get('current_cycle')
                ]);
    
                $item_unit_name=Item::select('item_units.name_ar as unit_name')->where('items.id',$ib->itemId)
                                ->leftjoin('item_units','item_units.id','items.item_unit_id')->first()->unit_name;
                BeginningTrackingList::insert([
                    'ib_tracking_id'=>$bt_group_id,
                    'item_id'=>$ib->itemId,
                    'item_unit'=>$item_unit_name,
                    'quantity'=>$ib->total_qty,
                    'p_code'=>$p_code,
                    'cycle_id'=> Session::get('current_cycle')
                ]);
            }                              

        }
    }

    public function upgrade_current_cycle_entries_list($new_entries_list){
        $editedCycle_id = SystemSetting::where('setting_key','old_cycle_edited_id')->first()->setting_value;
		$cycle = FinancialCycle::where('id', $editedCycle_id)->first();
        $result = RotateDataResult::where('cycle_id',$cycle->id)->first();
        if($result){
            $result->update([
                'net_profit'=>$new_entries_list->net_profit,
                'gross_profit'=>$new_entries_list->gross_profit,
                'sales'=>$new_entries_list->sales_inMajorCurrency,
                'purchases'=>$new_entries_list->purchases_inMajorCurrency,
                'sales_return'=>$new_entries_list->sales_return_inMajorCurrency,
                'purchases_return'=>$new_entries_list->purchases_return_inMajorCurrency,
                'earned_discount'=>$new_entries_list->earned_discount_inMajorCurrency,
                'granted_discount'=>$new_entries_list->granted_discount_inMajorCurrency,
                'last_inventories_items_value'=>$new_entries_list->last_inventories_items_value,
                'begin_inventories_items_value'=>$new_entries_list->begin_inventories_items_value,
                'incomes'=>$new_entries_list->all_incomes_inMajorCurrency,
                'outgoings'=>$new_entries_list->all_outgoings_inMajorCurrency,
                'ex_rate_difference_value'=>$new_entries_list->ex_rate_difference_value,
            ]);
        }
    }

    public function upgrade_helpful_account($account_id,$amount,$ib_package_id,$date){
        $major_curr = $this->getMajorCurrency();    
        $old_ib = InitialVouchersList::where('iv_group_id', $ib_package_id)
        ->where('currency_id', $major_curr->id)
        ->where('account_id', $account_id)->first();

        if($old_ib){ //found 
                //change InitialVouchersList record value
                $old_ib->update([
                        'amount'=> $amount
                ]);
                //change initial voucher  entries (voucher, entries)
                if((float)$amount > 0){ 
                    //change voucher record
                    $iv = Voucher::where('p_code', $old_ib->p_code)->where('cycle_id', Session::get('current_cycle'))->first();
                    $iv->update([
                        'debit'=>$account_id,
                        'credit'=>0,
                        'amount'=>$amount,
                        'equalizer'=>$amount
                    ]);
                    //change entries record
                    $iv_entry_base = EntryBase::where('voucher_id', $iv->id)->first();
                    $iv_entry = Entry::where('entry_base_id', $iv_entry_base->id)->first();
                    $iv_entry->update([
                        'debit'=>abs($amount),
                        'credit'=>NULL,
                        'equalizer'=>abs($amount)
                    ]);
                }else{
                    $iv = Voucher::where('p_code', $old_ib->p_code)->where('cycle_id', Session::get('current_cycle'))->first();
                    $iv->update([
                        'debit'=>0,
                        'credit'=>$account_id,
                        'amount'=>abs($amount),
                        'equalizer'=>abs($amount)
                    ]);
                    //change entries record
                    $iv_entry_base = EntryBase::where('voucher_id', $iv->id)->first();
                    $iv_entry = Entry::where('entry_base_id', $iv_entry_base->id)->first();
                    $iv_entry->update([
                        'debit'=>NULL,
                        'credit'=>abs($amount),
                        'equalizer'=>abs($amount) 
                    ]);
                }
           
        } else {//not found 
           
            //create new initial voucher
            $RDFunc = new RotateDataFunctionsController();
            //generate code and P_code
            $codes = $RDFunc->generateVoucherP_code(Session::get('current_cycle'));
            $currency_id = $major_curr->id;
            $credit = 0;
            $debit = 0;
            if ((float)$amount < 0) {
                $credit = $account_id;
            } else {
                $debit = $account_id;
            }
            $amount = abs((float)$amount);

            //بناء سند افتتاحي للدورة المالية الحالية
            $RDFunc->create_begining_Voucher($codes,$debit,$credit,$currency_id,$amount,$date,$ib_package_id,Session::get('current_cycle'));
            
        }
    }
    public function upgrade_current_cycle_helpful_accounts($new_entries_list,$cycle_setting){
        $rotate_date = $cycle_setting['rotate_date'];
        $date_after_rotate_date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
        //get initial baclance package id in current cycle
        $initial_balances_package_in_current_cycle_id = InitialVouchersGroup::where('cycle_id', Session::get('current_cycle'))
            ->where('date', $date_after_rotate_date)
            ->orderby('date', 'desc')
            ->first()->id;
       
        //upgrade profit account        
        $this->upgrade_helpful_account($cycle_setting['profits_account'],$new_entries_list->net_profit,$initial_balances_package_in_current_cycle_id,$date_after_rotate_date);    
        
        //upgrade diff ex_rate account        
        $this->upgrade_helpful_account($cycle_setting['diff_ex_rate_account'],$new_entries_list->ex_rate_difference_value,$initial_balances_package_in_current_cycle_id,$date_after_rotate_date);    
        
        //upgrade last inventories items value account
        $this->upgrade_helpful_account($cycle_setting['last_inventories_items_value_account'],$new_entries_list->last_inventories_items_value,$initial_balances_package_in_current_cycle_id,$date_after_rotate_date);    
        
    }

    public function upgrade_current_cycle_items_cost($new_items_cost){
        foreach($new_items_cost as $key => $item){
            Item::where('id',$key)->update([
                'cost'=>$item['cost']
            ]);
        }
    }


    public function upgrade_current_cycle_currencies_ex_rates($ex_rate_arr){
        $currencies_not_majer = $this->getCurrencies_Not_Major();
        foreach($currencies_not_majer as $curr){
            Currency::where("id",$curr->id)->update([
                "ex_rate"=>$ex_rate_arr['ex_rate_'.$curr->id]
            ]);
            CurrencyHistory::insert([
                'currency_id' => $curr->id,
                'ex_rate' => $ex_rate_arr['ex_rate_'.$curr->id],
                'edit_by' => CRUDBooster::myId(),
            ]);
        }   
    }
    public function saveRe_Calculate_Data_Result($options)
    {
        //dd($options);
        
        //update initial balances
		if (in_array('initial_balances', $options)) {
            $new_initial_balances =Session::get('new_initial_balances');
            $this->upgrade_current_cycle_initial_balances($new_initial_balances);

            //dd($new_initial_balances);
		}

        //update Beginning items
		if (in_array('beginning_items', $options)) {
			$new_beginning_items =Session::get('new_beginning_items');
            $this->upgrade_current_cycle_beginning_items($new_beginning_items);
            
            //dd($new_beginning_items);
		}
        
        //update entries list
		if (in_array('entries_list', $options)) {
            $new_entries_list =Session::get('new_entries_list');
            $this->upgrade_current_cycle_entries_list($new_entries_list);
			//dd($new_entries_list);

		}

        //update helpful accounts
		if (in_array('helpful_accounts', $options)) {
            $cycle_setting =Session::get('rotate_setting');
			$new_entries_list =Session::get('new_entries_list');
            $this->upgrade_current_cycle_helpful_accounts($new_entries_list,$cycle_setting);
            //dd($new_entries_list);
		}

        //update items cost
        if (in_array('items_cost', $options)) {
            $new_items_cost =Session::get('new_items_cost');
            $this->upgrade_current_cycle_items_cost($new_items_cost);
            //dd($new_items_cost);
		}

        //update currencies ex-rates
        if (in_array('currencies_ex_rates', $options)) {            
			$cycle_setting =Session::get('rotate_setting');
            //dd($cycle_setting);
            $this->upgrade_current_cycle_currencies_ex_rates($cycle_setting);   
		}

        Session::forget('rotate_setting');
        Session::forget('new_initial_balances');
        Session::forget('new_beginning_items');
        Session::forget('new_entries_list');
        Session::forget('new_items_cost');

        //finish cycle edited status
        SystemSetting::where('setting_key','old_cycle_edited')->update([
            'setting_value'=>'false'
        ]);
        SystemSetting::where('setting_key','old_cycle_edited_id')->update([
            'setting_value'=>''
        ]);

        return true;
    }

}

