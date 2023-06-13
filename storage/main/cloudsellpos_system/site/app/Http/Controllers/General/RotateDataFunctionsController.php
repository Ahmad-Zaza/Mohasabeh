<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\General;

use App\Models\FinancialCycles\FinancialCycle;
use App\Models\SystemConfigration\SystemSetting;
use Carbon\Carbon;
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

class RotateDataFunctionsController extends GeneralFunctionsController{

    //===================================================================================
    //                                 Rotate data
    //===================================================================================
    
    //تحقق من وجود قيود مسجلة ضمن النظام بعد تاريخ الإقفال
    public function checkRotateDate ($rotate_date){
        
        //if($rotate_date <= date('Y-m-d')){ //check if choosen date before current date
            $status = EntryBase::where('cycle_id',Session::get('current_cycle'))->where('date', '>', $rotate_date." 23:59:59")->first();
            $tracking_status = ItemTracking::where('cycle_id',Session::get('current_cycle'))->where('date', '>', $rotate_date." 23:59:59")->first();
            if($status || $tracking_status){
                return json_encode(array('status'=>'error','massege'=>trans('messages.there_are_entries_after_choosen_date_so_you_cannot_rotate_at_this_date_choose_other_date')));
            } else {
                return json_encode(array('status'=>'success','massege'=>trans('messages.choosen_date_correct_there_arenot_any_entries_after_this_date')));
            }
        // }else{
        //     return json_encode(array('status'=>'error','massege'=>trans('messages.you_cannot_choose_date_after_current_date')));
        // }     
    }

    //حساب الأرصدة الإفتتاحية للسنة المالية الجديدة
    public function calculate_opening_balances($rotate_date){
        $rotate_date = $rotate_date." 23:59:59";
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
				$conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=', Session::get('display_cycle') ]);
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
                    ->where('entries.create_at', '<=',  $rotate_date)
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

    

    public function generateVoucherP_code($newCycleId){

        $max = Voucher::where("voucher_type_id", 4)->where('cycle_id', $newCycleId)->max('code');
        $prefixCode = VoucherType::where('id', 4)->select('prefix')->first();
        $code = ($max) ? $max + 1 : 1;
        $p_code= $prefixCode->prefix . '' . $code;

        return array('code'=>$code,'p_code' => $p_code);
    }


    //بناء سند افتتاحي وحفظه ضمن الداتا بيز 
    //وبناء القيود المتعلقة به ضمن جدول المناقلات المالية
    public function create_begining_Voucher($codes,$debit,$credit,$currency_id,$amount,$rotate_date,$iv_group_id,$newCycleId){
            $code =$codes['code'];
            $p_code = $codes['p_code'];     
            $voucher_type_id = 4;
            $staff_id = CRUDBooster::myId();
            $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
            $narration = trans('modules.initial_voucher');
            $ex_rate = Currency::find($currency_id)->ex_rate;
           
            //create voucher 
            $voucher_id = Voucher::insertGetId([
				'code' => $code,
                'p_code' => $p_code,
                'voucher_type_id' =>$voucher_type_id,
                'debit' => $debit,
                'credit' => $credit,
                'narration' => $narration,
                'staff_id' => $staff_id,
                'date' => $date,
                'currency_id' => $currency_id,
                'amount' => $amount,
                'ex_rate'=>$ex_rate,
                'equalizer'=>(float)($amount*$ex_rate),
                'active' => 1,
                'cycle_id'=>$newCycleId
			]);

            //create entry_base and entries for voucher
            $max = EntryBase::where('cycle_id',$newCycleId)->max('entry_number');
			$entry_number = $max + 1;
            
            $entry_base_id = EntryBase::insertGetId([
				'entry_number' => $entry_number,
				'narration' => $narration,
				'date' => $date,
				'voucher_id' => $voucher_id,
				'active' => 1,
                'cycle_id'=>$newCycleId

			]);

			if ($debit == 0) {
				$entry = Entry::insert([
					'entry_base_id' => $entry_base_id,
					'debit' => null,
					'account_id' => $credit,
					'credit' => $amount,
					'currency_id' => $currency_id,
                    'ex_rate'=>$ex_rate,
                    'equalizer'=>(float)($amount*$ex_rate),
                    'cycle_id'=>$newCycleId
				]);
			} else {
				$entry = Entry::insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $amount,
					'account_id' => $debit,
					'credit' => null,
					'currency_id' => $currency_id,
                    'ex_rate'=>$ex_rate,
                    'equalizer'=>(float)($amount*$ex_rate),
                    'cycle_id'=>$newCycleId
				]);
			}

            //add initial voucher to inital voucher group
            $account_id = ($debit == 0)?$credit:$debit;
            $temp_amount = ($debit == 0) ? (-1)*$amount : $amount;
            InitialVouchersList::insert([
                'iv_group_id'=>$iv_group_id,
                'account_id'=>$account_id,
                'currency_id'=>$currency_id,
                'amount'=>$temp_amount,
                'p_code'=>$p_code,
                'cycle_id'=>$newCycleId
            ]);

    }

    //بناء السندات الإفتتاحية للسنة الماليةالجديدة
    public function create_begining_entries_for_new_cycle($accounts_info,$rotate_date,$newCycleId){
        $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
        $iv_group_id = InitialVouchersGroup::insertGetId([
            'voucher_number'=>1,
            'narration'=>trans('labels.initial_vouchers_after_rotate_data',['rotate_date'=>$rotate_date]),
            'date'=>$date,
            'staff_id'=>CRUDBooster::myId(),
            'cycle_id'=>$newCycleId
        ]);
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($accounts_info as $account){
                foreach($activeCurrencies as $curr){
                    if((float)$account['curr_balance_'.$curr->id] != 0){
                        //generate code and P_code
                        $codes = $this->generateVoucherP_code($newCycleId);
                        $currency_id = $curr->id;
                        $credit = 0;
                        $debit = 0;
                        if ((float)$account['curr_balance_'.$curr->id] < 0) {
                            $credit = $account['account_id'];
                        } else {
                            $debit = $account['account_id'];
                        }
                        $amount = abs((float)$account['curr_balance_'.$curr->id]);
                        
                        
                        //بناء سند افتتاحي
                         $this->create_begining_Voucher($codes,$debit,$credit,$currency_id,$amount,$rotate_date,$iv_group_id,$newCycleId);
    
                    }
                }
        }
        return $iv_group_id;
    }


    //حساب المخزون المتبقي ضمن المستودعات للسنة المالية الجديدة
    public function getItemsAmountInAllInventories($rotate_date){
        $rotate_date = $rotate_date." 23:59:59";
        $query2 = DB::table("item_tracking as t0")
		->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
            'source.id as sourceInventory_id',
			DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
						WHERE t1.transaction_operation = 'in'
                        and t1.status = 1  
						and t1.action is NULL
                        and t1.cycle_id = ".Session::get('display_cycle')." 
                        and t1.date <= '$rotate_date'
						and t1.item_id = t0.item_id 
						and t0.source = t1.source 
						) as item_in "),
			DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
					   WHERE t2.transaction_operation = 'out'
                        and t2.status = 1 
						and t2.action is NULL
                        and t2.cycle_id = ".Session::get('display_cycle')."  
                        and t2.date <= '$rotate_date'
						and t0.item_id = t2.item_id and t0.source = t2.source) as item_out"))
						->join("items", "items.id", "t0.item_id")
						->leftjoin("inventories as source","t0.source", "source.id")

		->GROUPby('itemId','t0.source');
                $query2->where('t0.date','<=',$rotate_date);
                $query2->where('t0.status', 1);
				$query2->where('t0.action',NULL);
                $query2->where('t0.cycle_id',Session::get('display_cycle'));
				$query2->orderby('source.name_ar','desc');
		$inventories_data = $query2->get();

        return $inventories_data;
    }


    //بناء قيود بضاعة أول مدة للمخزون المتبقي ضمن الستودعات 
    public function create_inventory_beginning_for_new_cycle($items_amounts,$rotate_date,$newCycleId){
        $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
        $staff_id = CRUDBooster::myId();
        $index = 1;
        $prefixCode = ItemTrackingType::where('id', 5)->select('prefix')->first();
       
        $inventories_has_group = array();
        $bt_groups_ids = array();

        foreach($items_amounts as $item){
            $group_id = 0;
            if (!in_array($item->sourceInventory_id, $inventories_has_group)) {
                array_push($inventories_has_group, $item->sourceInventory_id);
                $bt_group_id = BeginningTracking::insertGetId([
                    'source'=>$item->sourceInventory_id,
                    'date'=>$date,
                    'note'=>trans('labels.begin_track_after_rotate_data'),
                    'staff_id'=>$staff_id,
                    'cycle_id'=> $newCycleId
                ]);
                $bt_groups_ids["" . $item->sourceInventory_id] = $bt_group_id;
                $group_id = $bt_group_id;
            } else {
                $group_id = $bt_groups_ids["" . $item->sourceInventory_id];
            }

            $p_code = $prefixCode->prefix."$index";
             $qty = (float) $item->item_in - (float) $item->item_out;
             ItemTracking::insert([
                'code' => $index,
                'p_code' => $p_code,
                'item_id' => $item->itemId,
                'item_tracking_type_id' => 5,
                'source' => $item->sourceInventory_id,
                'date' =>  $date,
                'quantity' => $qty,
                'note' => trans('modules.begnning_inventory_items'),
                'transaction_operation' => 'in',
                'active' => 1,
                'cycle_id'=> $newCycleId
            ]);

            $item_unit_name=Item::select('item_units.name_ar as unit_name')->where('items.id',$item->itemId)
                            ->leftjoin('item_units','item_units.id','items.item_unit_id')->first()->unit_name;
            BeginningTrackingList::insert([
                'ib_tracking_id'=>$group_id,
                'item_id'=>$item->itemId,
                'item_unit'=>$item_unit_name,
                'quantity'=>$qty,
                'p_code'=>$p_code,
                'cycle_id'=> $newCycleId
            ]);
            $index++;
        }
    }

    public function getAccountBalanceUseingEqualizer($account_id,$rotate_date){
        $rotate_date = $rotate_date." 23:59:59";
        $conditions = array(['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle') ]);
        $query = Entry::select(
            'accounts.id as id',
            'accounts.name_ar as name',
            DB::raw('sum(IFNULL(entries.equalizer,0)) as sum_equalizer')
        )
            ->join("entry_base", "entry_base.id", "entries.entry_base_id")
            ->join("accounts", "accounts.id", "entries.account_id")
            ->join("currencies", "currencies.id", "entries.currency_id")
            ->where('entries.create_at', '<=',  $rotate_date)
            ->where($conditions)
            ->where('accounts.id',$account_id)
            ->orWhereNull('entries.create_at')
            ->where($conditions)
            ->where('accounts.id',$account_id);
        $res = $query->first();
        
        $value = $res->sum_equalizer;
            
        return $value;
    }
    
    

    //جلب قائمة بالكلف التقديرية لكل مادة حسب طريقة حساب الكلفة المختارة بإعدادات التدوير
    //حيث نقوم بحساب متوسط  سعر المادة بفواتير المشتريات
    //واسعار المواد التي تكون بالدولار نقوم بضربها بقيمة سعر الصرف
    //أو تكون كلفة المادة هي أخر سعر شراء
    //والتي تمت قبل تاريخ التدوير المختار
    public function getItemsCostList($item_cost_type,$date){
        $date = $date." 23:59:59";
        $items_cost_list = array();
        if($item_cost_type == 1){ //حساب تكلفة المادة كوسطي سعر المادة بفواتير الشراء
            $query = BillItem::select('items.id as itemId','items.name_ar as nameAr','items.cost as item_cost',         
                    DB::raw("(SELECT avg(bills_items.unit_price * bills.ex_rate) as new_unit_price 
                            FROM `bills_items` , `bills` 
                            WHERE bills_items.bill_id = bills.id 
                                    and bills_items.item_id = itemId
                                    and bills.bill_type_id = 1  
                                    and bills.date <=  '$date' 
                                    and bills.action is NULL
                                    and bills.cycle_id = ".Session::get('display_cycle')."   
                                    group by bills_items.item_id) as new_item_cost "))
                                ->join("items", "items.id", "bills_items.item_id")
                                ->leftjoin("bills","bills_items.bill_id", "bills.id")

                ->GROUPby('itemId');
                $query->where('bills.action',NULL);
                $query->where('bills.cycle_id',Session::get('display_cycle'));
                

                $items_cost_list = $query->get();
            
              
        }else{ //تكلفة بأخر سعر شراء
            $query = BillItem::select('items.id as itemId','items.name_ar as nameAr','items.cost as item_cost',         
                    DB::raw("(SELECT  (bills_items.unit_price * bills.ex_rate) as new_unit_price 
                    FROM `bills_items` , `bills` 
                    WHERE bills_items.bill_id = bills.id 
                            and bills_items.item_id = itemId
                            and bills.bill_type_id = 1 
                            and bills.date <=  '$date'  
                            and bills.action is NULL
                            and bills.cycle_id = ".Session::get('display_cycle')."  
                            ORDER BY bills.id DESC
                            LIMIT 1) as new_item_cost "))
                                ->join("items", "items.id", "bills_items.item_id")
                                ->leftjoin("bills","bills_items.bill_id", "bills.id")

                ->GROUPby('itemId');
                $query->where('bills.action',NULL);
                $query->where('bills.cycle_id',Session::get('display_cycle'));

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

    //حساب قيمة التقديرية لبضاعة أخر المدة ب ل.س
    public function calculate_last_inventories_items_value($rotate_date,$items_cost_list){
        

        $last_inventories_items = $this->getItemsAmountInAllInventories($rotate_date);
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
    public function getBeginItemsAmountInAllInventories($rotate_date){
        $rotate_date = $rotate_date." 23:59:59";
        $query = DB::table("item_tracking as t0")
		->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
            'source.id as sourceInventory_id',
			DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
						WHERE t1.transaction_operation = 'in' 
                        and (t1.item_tracking_type_id = 5)
                        and t1.date <= '$rotate_date'
                        and t1.status = 1
						and t1.action is NULL 
                        and t1.cycle_id = ".Session::get('display_cycle')."
						and t1.item_id = t0.item_id 
						and t0.source = t1.source 
						) as item_in ")
			            )
						->join("items", "items.id", "t0.item_id")
						->leftjoin("inventories as source","t0.source", "source.id")

		->GROUPby('itemId','t0.source');
                $query->where('t0.status',1);
				$query->where('t0.action',NULL);
                $query->where('t0.cycle_id',Session::get('display_cycle'));
               
				$query->orderby('source.name_ar','desc');
		$inventories_data = $query->get();
        
        return $inventories_data;
    }

    //حساب قيمة التقديرية لبضاعة أول المدة ب ل.س
    //بضاعة أول المدة = بضاعة أول المدة للعام المدور 
    public function calculate_begin_inventories_items_value($rotate_date,$items_cost_list){
        

        $begin_items = $this->getBeginItemsAmountInAllInventories($rotate_date);
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

    //جلب  وسطي سعر صرف العملات خلال تاريخ معين
    public function getAVGEx_rateAtDate($date){

       $date_time_start = date('Y-m-d H:i:s',strtotime($date));
       $date_time_end = date('Y-m-d H:i:s',strtotime($date.' 23:59:59'));

        $result = CurrencyHistory::select('currency_history.currency_id','currencies.name_ar',DB::raw('AVG(currency_history.ex_rate) as avg_ex_rate'))
                     ->where('edit_at','>',$date_time_start)
                     ->where('edit_at','<',$date_time_end)
                     ->join('currencies','currency_history.currency_id','currencies.id')
                     ->groupBy('currency_id')->pluck('avg_ex_rate','currency_history.currency_id');
        $average_at_date = array();            
        $currencies_not_majer = $this->getCurrencies_Not_Major();
        foreach($currencies_not_majer as $curr){
            $average_at_date[$curr->id] = $result[$curr->id];
        }
        
        //check if get correct average and not null
        foreach($currencies_not_majer as $curr){
            if($average_at_date[$curr->id] == null){
                //اخر تعديل قبل التاريخ المحدد
                $ex_rate = CurrencyHistory::select('currency_history.currency_id','currencies.name_ar','currency_history.ex_rate','currency_history.edit_at')
                ->where('edit_at','<',$date_time_start)
                ->where('currency_id',$curr->id)
                ->join('currencies','currency_history.currency_id','currencies.id')
                ->orderby('edit_at','desc')
                ->first()->ex_rate;
                if($ex_rate != null){
                    $average_at_date[$curr->id] = $ex_rate;
                }else{
                    $average_at_date[$curr->id] = Currency::where('id',$curr->id)->first()->ex_rate;
                }
            }
        }
        return $average_at_date;
    }

    //جلب  أخر سعر صرف العملات خلال تاريخ معين
    public function getEx_rateAtDate($date){
        $date_time_end = date('Y-m-d H:i:s',strtotime($date.' 23:59:59'));
         
         $ex_rate_at_date = array();            
         $currencies_not_majer = $this->getCurrencies_Not_Major();
         foreach($currencies_not_majer as $curr){

            $result = CurrencyHistory::select('currency_history.currency_id','currencies.name_ar','currency_history.ex_rate')
            ->where('edit_at','<',$date_time_end)
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

     
    //حساب الأرباح والخسائر
    public function calculateProfitsAndLoss(){

        //setting
        $setting = Session::get('rotate_setting');
        //dd($setting);
        $bals_all_values = Session::get('rotate_bals_all_values');
        
        $items_cost_list = $this->getItemsCostList($setting['item_cost_type'],$setting['rotate_date']);
        //dd($items_cost_list);

        //حساب قيمة بضاعة أخر المدة والتي قبل تاريخ التدوير المختار
        $last_inventories_items_value = $this->calculate_last_inventories_items_value($setting['rotate_date'],$items_cost_list);
        //dd($last_inventories_items_value);
       
        //حساب قيمة  بضاعة أول مدة 
        $begin_inventories_items_value = $this->calculate_begin_inventories_items_value($setting['rotate_date'],$items_cost_list);
        //dd($begin_inventories_items_value);

        //حساب مجمل الربح
        //حساب قيمة الأرصدة بالليرة السورية وبسعر الصرف الحالي المدخل بإعدادات التدوير 
        
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
        //dd($ex_rate_difference_value);
     
        $sales_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Sales_Account'),$setting['rotate_date']);
        $purchases_return_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Purchases_Return_Account'),$setting['rotate_date']);
        $purchases_inMajorCurrency= $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Purchases_Account'),$setting['rotate_date']);
        $sales_return_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Sales_Return_Account'),$setting['rotate_date']);
        $earned_discount_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Earned_Discount'),$setting['rotate_date']);
        $granted_discount_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Granted_Discount'),$setting['rotate_date']);

        
        //  جلب قيمة الإيرادات قبل تاريخ التدوير المختار
        $incomes_balances = array();
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($activeCurrencies as $curr){
            $incomes_balances['final_balance_'.$curr->id] = 0;
        }

        $this->getAccountBalance_sum_childrenBalances_at_date($this->getSystemConfigValue('Incomes_Account'),$setting['rotate_date'].' 23:59:59',$incomes_balances);        
        $all_incomes = $incomes_balances['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_incomes +=($incomes_balances['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }
        //dd($all_incomes);
        
        

        //جلب قيمة المصاريف قبل تاريخ التدوير المحدد
        $outgoings_balances = array();
        foreach($activeCurrencies as $curr){
            $outgoings_balances['final_balance_'.$curr->id] = 0;
        }
        $this->getAccountBalance_sum_childrenBalances_at_date($this->getSystemConfigValue('Outgoings_Account'),$setting['rotate_date'].' 23:59:59',$outgoings_balances);
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

        //dd($result);
        //Storage::disk('local')->append('rotate_data_test.txt', json_encode($result)."/n");
        //return json_encode($all_outgoings);
        return  $result;
      
    }


    //تهيئة جميع  الجداول التي تدخل بعملية تدوير الحسابات 
    public function resetTablesBeforeRotateData($rotate_date,$profits_details,$setting){
        
        //Insert rotate_data_result table and profits_and_loss value to last year
        RotateDataResult::insert([
            "cycle_id" => Session::get('display_cycle'),
            "rotate_date"=>$rotate_date,
            "net_profit"=>$profits_details['net_profit'],
            "gross_profit"=>$profits_details['gross_profit'],
            "sales"=>$profits_details['sales_inMajorCurrency'],
            "purchases"=>$profits_details['purchases_inMajorCurrency'],
            "sales_return"=>$profits_details['sales_return_inMajorCurrency'],
            "purchases_return"=>$profits_details['purchases_return_inMajorCurrency'],
            "earned_discount"=>$profits_details['earned_discount_inMajorCurrency'],
            "granted_discount"=>$profits_details['granted_discount_inMajorCurrency'],
            "last_inventories_items_value"=>$profits_details['last_inventories_items_value'],
            "begin_inventories_items_value"=>$profits_details['begin_inventories_items_value'],
            "incomes"=>$profits_details['all_incomes_inMajorCurrency'],
            "outgoings"=>$profits_details['all_outgoings_inMajorCurrency'],
            "ex_rate_difference_value"=>$profits_details['ex_rate_difference_value'],
            "date" => date('Y-m-d'),
        ]);

        $currencies_ex_rate_arr = array();
        $currencies_not_majer = $this->getCurrencies_Not_Major();
        foreach($currencies_not_majer as $curr){
            $temp = "ex_rate_$curr->id|".$setting['ex_rate_'.$curr->id];
            array_push($currencies_ex_rate_arr,$temp);
        }
        $currencies_ex_rates_str = implode(',',$currencies_ex_rate_arr);

        FinancialCycle::where('id', Session::get('display_cycle'))->update([
            'cycle_name' => $setting['cycle_name'],
            'rotate_date' => $setting['rotate_date'] ,
            'currencies_ex_rate'=>$currencies_ex_rates_str,
            'item_cost_type'=> $setting['item_cost_type'],
            'profits_account_id'=> $setting['profits_account'],
            'diff_ex_rate_account_id'=> $setting['diff_ex_rate_account'],
            'last_inventories_items_value_account_id'=>$setting['last_inventories_items_value_account'],
            'created_date'=> date('Y-m-d h:i:s'),
            'status'=>'finished',
        ]);

        $newCycleId = FinancialCycle::insertGetId([
            'status'=>'current'
        ]);

        return $newCycleId;
        
    }

    
    public function emptyDBMainTables_in_rotate_data(){
           
        ItemTracking::truncate();
        Entry::truncate();
        EntryBase::truncate();
        Bill::truncate();
        BillFile::truncate();
        BillItem::truncate();
        Voucher::truncate();
        VoucherFile::truncate();
        TransferTracking::truncate();
        TransferTrackingList::truncate();
        TransferTrackingNote::truncate();
        BeginningTracking::truncate();
        BeginningTrackingList::truncate();
        InitialVouchersGroup::truncate();
        InitialVouchersList::truncate();

        $LogQuery = "TRUNCATE TABLE  cms_logs;";
        DB::select(DB::raw($LogQuery));
        return true;

    }

    public function setEx_rate_diffrence_value_to_Account($ex_rate_difference_account_id,$ex_rate_difference_value,$rotate_date,$iv_res_group_id,$newCycleId){
            $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date))); 
            $codes = $this->generateVoucherP_code($newCycleId);
            $code =$codes['code'];
            $p_code = $codes['p_code'];     
            $voucher_type_id = 4;
            $staff_id = CRUDBooster::myId();
            $narration = trans('modules.initial_voucher');
            $currency_id = $this->getMajorCurrency()->id;
            $ex_rate =  $this->getMajorCurrency()->ex_rate;
            $amount = (float)$ex_rate_difference_value;
            $credit = 0;
            $debit = 0;
            if ((float)$amount < 0) {
                $credit = $ex_rate_difference_account_id;
            } else {
                $debit = $ex_rate_difference_account_id;
            }
            //create voucher 
            $voucher_id = Voucher::insertGetId([
				'code' => $code,
                'p_code' => $p_code,
                'voucher_type_id' =>$voucher_type_id,
                'debit' => $debit,
                'credit' => $credit,
                'narration' => $narration,
                'staff_id' => $staff_id,
                'date' => $date,
                'currency_id' => $currency_id,
                'amount' => abs((float)$amount),
                'ex_rate'=>$ex_rate,
                'equalizer'=>(float)(abs((float)$amount)*$ex_rate),
                'active' => 1,
                'cycle_id'=>$newCycleId
			]);
            
            
            $max = EntryBase::where('cycle_id',$newCycleId)->max('entry_number');
			$entry_number = $max + 1;
            
            $entry_base_id = EntryBase::insertGetId([
				'entry_number' => $entry_number,
				'narration' => trans('modules.diffrent_ex_rate_value_after_rotate_data'),
				'date' => $date,
                'voucher_id' => $voucher_id,
				'active' => 1,
                'cycle_id'=>$newCycleId
			]);

            $credit_amount = null;
            $debit_amount = null;
            if ((float)$amount < 0) {
                $credit_amount = abs((float)$amount);
            } else {
                $debit_amount = abs((float)$amount);
            }
            $entry = Entry::insert([
                'entry_base_id' => $entry_base_id,
                'debit' => $debit_amount,
                'credit' => $credit_amount,
                'account_id' => $ex_rate_difference_account_id,
                'currency_id' => $currency_id,
                'ex_rate'=>$ex_rate,
                'equalizer'=>(float)(abs((float)$amount)*$ex_rate),
                'cycle_id'=>$newCycleId
            ]);

            InitialVouchersList::insert([
                'iv_group_id'=>$iv_res_group_id,
                'account_id'=>$ex_rate_difference_account_id,
                'currency_id'=>$currency_id,
                'amount'=>$amount,
                'p_code'=>$p_code,
                'cycle_id'=>$newCycleId
            ]);
			
    }

public function setLast_inventories_items_value_to_Account($last_inventories_items_value_account_id,$last_inventories_items_value,$rotate_date,$iv_res_group_id,$newCycleId){
    $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));         
    $codes = $this->generateVoucherP_code($newCycleId);
    $code =$codes['code'];
    $p_code = $codes['p_code'];     
    $voucher_type_id = 4;
    $staff_id = CRUDBooster::myId();
    $narration = trans('modules.initial_voucher');
    $currency_id = $this->getMajorCurrency()->id;
    $ex_rate =  $this->getMajorCurrency()->ex_rate;
    $amount = (float)$last_inventories_items_value;
    //create voucher 
    $credit = 0;
    $debit = 0;
    if ((float)$amount < 0) {
        $credit = $last_inventories_items_value_account_id;
    } else {
        $debit = $last_inventories_items_value_account_id;
    }
    $voucher_id = Voucher::insertGetId([
        'code' => $code,
        'p_code' => $p_code,
        'voucher_type_id' =>$voucher_type_id,
        'debit' => $debit,
        'credit' => $credit,
        'narration' => $narration,
        'staff_id' => $staff_id,
        'date' => $date,
        'currency_id' => $currency_id,
        'amount' =>  abs((float)$amount),
        'ex_rate'=>$ex_rate,
        'equalizer'=>(float)( abs((float)$amount)*$ex_rate),
        'active' => 1,
        'cycle_id'=>$newCycleId
    ]);
    
    
    $max = EntryBase::where('cycle_id',$newCycleId)->max('entry_number');
    $entry_number = $max + 1;
    
    $entry_base_id = EntryBase::insertGetId([
        'entry_number' => $entry_number,
        'narration' => trans('modules.last_inventories_items_value_after_rotate_data'),
        'date' => $date,
        'voucher_id' => $voucher_id,
        'active' => 1,
        'cycle_id'=>$newCycleId
    ]);

    $credit_amount = null;
    $debit_amount = null;
    if ((float)$amount < 0) {
        $credit_amount = abs((float)$amount);
    } else {
        $debit_amount = abs((float)$amount);
    }
    
    $entry = Entry::insert([
        'entry_base_id' => $entry_base_id,
        'debit' => $debit_amount,
        'credit' => $credit_amount,
        'account_id' => $last_inventories_items_value_account_id,
        'currency_id' => $currency_id,
        'ex_rate'=>$ex_rate,
        'equalizer'=>(float)(abs((float)$amount)*$ex_rate),
        'cycle_id'=>$newCycleId
    ]);

    InitialVouchersList::insert([
        'iv_group_id'=>$iv_res_group_id,
        'account_id'=>$last_inventories_items_value_account_id,
        'currency_id'=>$currency_id,
        'amount'=>$amount,
        'p_code'=>$p_code,
        'cycle_id'=>$newCycleId
    ]);
    
}

    public function setProfits_value_to_Account($profits_account_id,$net_profit,$rotate_date,$iv_res_group_id,$newCycleId){
            $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));    
            $codes = $this->generateVoucherP_code($newCycleId);
            $code =$codes['code'];
            $p_code = $codes['p_code'];     
            $voucher_type_id = 4;
            $staff_id = CRUDBooster::myId();
            $narration = trans('modules.initial_voucher');
            $currency_id = $this->getMajorCurrency()->id;
            $ex_rate =  $this->getMajorCurrency()->ex_rate;
            $amount = (float) $net_profit;
            $credit = 0;
            $debit = 0;
            if ((float)$amount < 0) {
                $credit = $profits_account_id;
            } else {
                $debit = $profits_account_id;
            }
            //create voucher 
            $voucher_id = Voucher::insertGetId([
                'code' => $code,
                'p_code' => $p_code,
                'voucher_type_id' =>$voucher_type_id,
                'debit' => $debit,
                'credit' => $credit,
                'narration' => $narration,
                'staff_id' => $staff_id,
                'date' => $date,
                'currency_id' => $currency_id,
                'amount' => abs($amount),
                'ex_rate'=>$ex_rate,
                'equalizer'=>(float)(abs($amount)*$ex_rate),
                'active' => 1,
                'cycle_id' => $newCycleId
            ]);
            
            
            $max = EntryBase::where('cycle_id',$newCycleId)->max('entry_number');
            $entry_number = $max + 1;
            
            $entry_base_id = EntryBase::insertGetId([
                'entry_number' => $entry_number,
                'narration' => trans('modules.profits_value_after_rotate_data'),
                'date' => $date,
                'voucher_id' => $voucher_id,
                'active' => 1,
                'cycle_id' => $newCycleId
            ]);

            $credit_amount = null;
            $debit_amount = null;
            if ((float)$amount < 0) {
                $credit_amount = abs((float)$amount);
            } else {
                $debit_amount = abs((float)$amount);
            }
            $entry = Entry::insert([
                'entry_base_id' => $entry_base_id,
                'debit' => $debit_amount,
                'credit' => $credit_amount,
                'account_id' => $profits_account_id,
                'currency_id' => $currency_id,
                'ex_rate'=>$ex_rate,
                'equalizer'=>(float)(abs($amount)*$ex_rate),
                'cycle_id' => $newCycleId
            ]);

            InitialVouchersList::insert([
                'iv_group_id'=>$iv_res_group_id,
                'account_id'=>$profits_account_id,
                'currency_id'=>$currency_id,
                'amount'=>$net_profit,
                'p_code'=>$p_code,
                'cycle_id' => $newCycleId
            ]);
            
    }

    //اعتماد سعر صرف جديد بعد التدوير
    public function setNewEx_rate_after_rotate_data($ex_rate_arr){
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

    //تغيير كلف المواد بعد عملية التدوير
    public function setNewItemsCost_after_rotate_data($items_cost_list){
        foreach($items_cost_list as $key => $item){
            Item::where('id',$key)->update([
                'cost'=>$item['cost']
            ]);
        }
    }

    //تدوير الحسابات
    public function rotate_data(){
       

        set_time_limit(1000000);
        $setting = Session::get('rotate_setting');
        $rotate_date = $setting['rotate_date'];
       
        //check if there are any entries after rotate date 
        $res = json_decode($this->checkRotateDate($setting['rotate_date']));
        if($res->status == 'error'){
            return json_encode(array('status'=>'error','massege'=>$res->massege));
        }

        //check if make rotate data in this date before
        $res= RotateDataResult::where('rotate_date', $rotate_date)->first();
        if($res){
            return json_encode(array('status'=>'error','massege'=>trans('messages.you_make_rotate_data_at_this_date_before')));
        }

        //make system backup before rotate data
        $backup_name = trans('messages.backup_name_before_rotate_data',['rotate_date'=>$rotate_date]);
        $backup_notes = trans('messages.backup_notes_before_rotate_data',['rotate_date'=>$rotate_date]);
        $backupCtrl = new BackupController();
        $backup_result = json_decode($backupCtrl->createBackupDB($backup_name,$backup_notes,2));
        if($backup_result->status == 'error' ){
             return json_encode(array('status'=>'error','massege'=>$backup_result->massege));
        }
         //إيقاف النظام بشكل مؤقت منعا لإدخال بيانات من قبل المستخدمين
         $system_temp_stop_status = SystemSetting::where('setting_key', 'system_stop')->first()->setting_value;
         SystemSetting::where('setting_key','system_stop')->update([
             'setting_value'=>'on'
         ]);

        //تجهيز الأرصدة الإبتدائية
        $opening_balances = $this->calculate_opening_balances($rotate_date);
        //dd($opening_balances);
        //تجهيز  المخزون المتبقي للمستودعات
        $items_amounts = $this->getItemsAmountInAllInventories($rotate_date);
        //dd($items_amounts);
        //جلب قيمة الأرباح والخسائر
        $profits_details = $this->calculateProfitsAndLoss();
        //dd($profits_and_loss);

        // تهيئة جميع الجداول 
        //bills, vouches,entry_base , entries, item_tracking ... etc.
        $newCycleId = $this->resetTablesBeforeRotateData($rotate_date,$profits_details,$setting);

        //اعتماد سعر الصرف العملات المدخل ضمن عملية التدوير  لسعر صرف بالسنة المالية الجديدة
        $this->setNewEx_rate_after_rotate_data($setting);

        //بناء السندات الإفتتاحية للسنة المالية الجديدة
        //وبالتاريخ التالي لتاريخ التدوير
        $iv_res_group_id = $this->create_begining_entries_for_new_cycle($opening_balances['accounts_info'],$rotate_date,$newCycleId);
       
        //اسناد قيمة الربح الصافي بعد عملية التدوير لحساب المختار لحفظ قيمة الربح قبل عملية التدوير
        $this->setProfits_value_to_Account($setting['profits_account'],$profits_details['net_profit'],$rotate_date,$iv_res_group_id,$newCycleId);
        
        //اسناد قيمة فرق سعر الصرف للحساب فرق سعر الصرف المحدد خلال عملية التدوير
        $this->setEx_rate_diffrence_value_to_Account($setting['diff_ex_rate_account'],$profits_details['ex_rate_difference_value'],$rotate_date,$iv_res_group_id,$newCycleId);
        
        //اسناد قيمة بضاعة أخر المدة للحساب المحدد خلال عملية التدوير
        $this->setLast_inventories_items_value_to_Account($setting['last_inventories_items_value_account'],$profits_details['last_inventories_items_value'],$rotate_date,$iv_res_group_id,$newCycleId);

        //بناء قيود بضاعة أول مدة للمخزون المتبقي بالمستودعات
        $this->create_inventory_beginning_for_new_cycle($items_amounts,$rotate_date,$newCycleId);

      
        //اعتماد  كلف جديدة للمواد بعد التدوير  بالاعتماد على خيار المحدد بعملية التدوير
        //سواء كان وسطي أو أخر سعر شراء

        $items_cost_list = $profits_details['items_cost_list']; //قائمة بالكلف الجديدة للمواد بعد عملية التدوير
        $this->setNewItemsCost_after_rotate_data($items_cost_list);
        
        Session::forget('rotate_setting');
        Session::put('display_cycle', $newCycleId);
        Session::put('current_cycle', $newCycleId);  
        //إعادة حالة إيقاف النظام للحالة السابقة
        SystemSetting::where('setting_key','system_stop')->update([
            'setting_value'=>$system_temp_stop_status
        ]);

        return json_encode(array('status'=>'success','massege'=>trans('messages.rotate_data_finished_successfully')));
    }

}

