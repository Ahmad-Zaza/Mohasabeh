<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use CRUDBooster;
use Session;
use Illuminate\Support\Facades\Storage;
use App\ItemTracking;
use App\Entry;
use App\EntryBase;
use App\Voucher;
use Illuminate\Support\Facades\Cache;

class GeneralFunctionsController extends Controller{


    //جلب رصيد حساب 
    public function getAccountBalance($account_id){

        $conditions = array(['entries.delete_by', '=',  0 ],['entries.rotate_year', '=',  NULL ]);
        $query = DB::table("entries")->select(
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

        $conditions = array(['entries.delete_by', '=',  0 ],['entries.rotate_year', '=',  NULL ]);
        $query = DB::table("entries")->select(
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
        $sql = "select persons.account_id, persons.name_ar from persons 
                where persons.person_type_id = 1 and persons.delegate_id =$id";
        $customers = DB::select($sql);		
        return $customers;
    }
    //===================================================================================
    //                                 Rotate data
    //===================================================================================

    //حساب الأرصدة الإفتتاحية للسنة المالية الجديدة
    public function calculate_opening_balances($rotate_date){
        //$rotate_date = "2022-01-08";
        $rotate_date = $rotate_date." 23:59:59";
        //dd($rotate_date);
        //query from db to get information
		//جلب حسابات التي دخل بحساب الأرصدة الافتتاحية 
		//وهي الصناديق و الزبائن والموردين و المندوبين
		//-------------------------------------------------------
        $choosen_account_ids=array();
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($activeCurrencies as $curr){
            array_push($choosen_account_ids,$curr->account_id);
        }

		$persons_account_ids=DB::table("persons")->select('account_id')->get();
        
		foreach($persons_account_ids as $person){
			array_push($choosen_account_ids,$person->account_id);
		}

		$salesman_account_ids=DB::table("cms_users")->select('account_id')->where('id_cms_privileges',4)->get();
		foreach($salesman_account_ids as $salesman){
			array_push($choosen_account_ids,$salesman->account_id);
		}
		
        //dd($choosen_account_ids);
		//-------------------------------------------------------

		$accounts = DB::table("accounts")->select('id','name_ar')->whereIn('id',$choosen_account_ids)->get();
		//dd($accounts);

		//get blance in all choosen accounts that have entries in system
		$accounts_with_balance=collect();
        foreach($accounts as $account){
				$conditions = array(['entries.delete_by', '=',  0 ],['entries.rotate_year', '=',  NULL ]);
                $query = DB::table("entries")->select(
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
                    ->where('entries.create_at', '<=',  $rotate_date)
					->where($conditions)
					->where('accounts.id',$account->id)
                    ->orWhereNull('entries.create_at')
                    ->where($conditions)
					->where('accounts.id',$account->id)
					->groupBy('entries.currency_id');
				$res = $query->get();

				$accounts_with_balance->push($res);	
		}
		
        //dd($accounts_with_balance);
        $final_balances = array();
        foreach($activeCurrencies as $curr){
            $final_balances['final_balance_'.$curr->id] = 0;
        }
		
		$accounts_info = array();

		foreach($accounts_with_balance as $items){
			 if(count($items) > 0 ){
					$arr=array('account_id'=>0,'account_name'=>'');
                    foreach($activeCurrencies as $curr){
                        $arr['curr_balance_'.$curr->id] = 0;
                    }

                    foreach($items as $item){
						$arr['account_id']=$item->id;
						$arr['account_name']=$item->name;

                        $arr['curr_balance_'.$item->currency_id] = $item->curr_balance;
                        $final_balances['final_balance_'.$item->currency_id] += $item->curr_balance;
							
					}
                    array_push($accounts_info,$arr);
				}
		}
		//dd($accounts_info);
		$accounts_info=collect($accounts_info);

        $result = array(
            'accounts_info' => $accounts_info
        );
        foreach($activeCurrencies as $curr){
            $result['final_balance_'.$curr->id] = $final_balances['final_balance_'.$curr->id];
        }
        //dd($result);
        return $result;
    }

    public function generateVoucherP_code(){

        $max = DB::table('vouchers')->where("voucher_type_id", 4)->where('rotate_year',NULL)->max('code');
        $prefixCode = DB::table('voucher_types')->where('id', 4)->select('prefix')->first();
        $code = ($max) ? $max + 1 : 1;
        $p_code= $prefixCode->prefix . '' . $code;

        return array('code'=>$code,'p_code' => $p_code);
    }


    //بناء سند افتتاحي وحفظه ضمن الداتا بيز 
    //وبناء القيود المتعلقة به ضمن جدول المناقلات المالية
    public function create_begining_Voucher($codes,$debit,$credit,$currency_id,$amount,$rotate_date){
            $code =$codes['code'];
            $p_code = $codes['p_code'];     
            $voucher_type_id = 4;
            $staff_id = CRUDBooster::myId();
            $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
            $narration = "سند افتتاحي";
            
           
            //create voucher 
            $voucher_id = DB::table("vouchers")->insertGetId([
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
                'active' => 1,
			]);

            //create entry_base and entries for voucher
            $max = DB::table('entry_base')->where('rotate_year',NULL)->max('entry_number');
			$entry_number = $max + 1;
            
            $entry_base_id = DB::table("entry_base")->insertGetId([
				'entry_number' => $entry_number,
				'narration' => $narration,
				'date' => $date,
				'voucher_id' => $voucher_id,
				'active' => 1

			]);

			if ($debit == 0) {
				$entry = DB::table("entries")->insert([
					'entry_base_id' => $entry_base_id,
					'debit' => null,
					'account_id' => $credit,
					'credit' => $amount,
					//'ex_rate' => $ex_rate,
					//'equalizer' => $equalizer,
					//'opposite' => $opposite,
					'currency_id' => $currency_id
				]);
			} else {
				$entry = DB::table("entries")->insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $amount,
					'account_id' => $debit,
					'credit' => null,
					//'ex_rate' => $ex_rate,
					//'equalizer' => $equalizer,
					//'opposite' => $opposite,
					'currency_id' => $currency_id
				]);
			}

    }

    //بناء السندات الإفتتاحية للسنة الماليةالجديدة
    public function create_begining_entries_for_new_year($accounts_info,$rotate_date){

        //return json_encode($accounts_info);
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($accounts_info as $account){
                foreach($activeCurrencies as $curr){
                    if((float)$account['curr_balance_'.$curr->id] != 0){
                        //generate code and P_code
                        $codes = $this->generateVoucherP_code();
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
                         $this->create_begining_Voucher($codes,$debit,$credit,$currency_id,$amount,$rotate_date);
    
                    }
                }
        }
        //return json_encode($accounts_info);
    }


    //حساب المخزون المتبقي ضمن المستودعات
    public function getItemsAmountInAllInventories($rotate_date){
        
        $query2 = DB::table("item_tracking as t0")
		->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
            'source.id as sourceInventory_id',
			DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
						WHERE t1.transaction_operation = 'in' 
						and t1.delete_by = '0'
                        and t1.rotate_year IS NULL
                        and t1.date <= '$rotate_date'
						and t1.item_id = t0.item_id 
						and t0.source = t1.source 
						) as item_in "),
			DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
					   WHERE t2.transaction_operation = 'out'
						and t2.delete_by = '0'
                        and t2.rotate_year IS NULL
                        and t2.date <= '$rotate_date'
						and t0.item_id = t2.item_id and t0.source = t2.source) as item_out"))
						->join("items", "items.id", "t0.item_id")
						->leftjoin("inventories as source","t0.source", "source.id")

		->GROUPby('itemId','t0.source');
                $query2->where('t0.date','<=',$rotate_date);
				$query2->where('t0.delete_by',0);
                $query2->where('t0.rotate_year',NULL);
				$query2->orderby('source.name_ar','desc');
		$inventories_data = $query2->get();

		//dd($inventories_data);
        return $inventories_data;
    }


    //بناء قيود بضاعة أول مدة للمخزون المتبقي ضمن الستودعات 
    public function create_inventory_beginning_for_new_year($items_amounts,$rotate_date){
        $index = 1;
        $prefixCode = DB::table('inventory_type_id')->where('id', 5)->select('prefix')->first();

        foreach($items_amounts as $item){

             DB::table("item_tracking")->insert([
                'code' => $index,
                'p_code' => $prefixCode->prefix." $index",
                'item_id' => $item->itemId,
                'inventory_id_type_id' => 5,
                'source' => $item->sourceInventory_id,
                'date' =>  date('Y-m-d', strtotime('+1 day', strtotime($rotate_date))),
                'quantity' => (int)$item->item_in - (int)$item->item_out,
                'note' => 'بضاعة أول مدة',
                'transaction_operation' => 'in',
                'active' => 1,
            ]);

            $index++;
        }
    }

    public function getAccountBalanceUseingEqualizer($account_id,$rotate_date){
       
        $conditions = array(['entries.delete_by', '=',  0 ],['entries.rotate_year', '=',  NULL ]);
        $query = DB::table("entries")->select(
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
        //return $res;    
            
        $value = $res->sum_equalizer;
            
        return $value;
    }
    
    

    //جلب قائمة بالكلف التقديرية لكل مادة حسب طريقة حساب الكلفة المختارة بإعدادات التدوير
    //حيث نقوم بحساب متوسط  سعر المادة بفواتير المشتريات
    //واسعار المواد التي تكون بالدولار نقوم بضربها بقيمة سعر الصرف
    //أو تكون كلفة المادة هي أخر سعر شراء
    //والتي تمت قبل تاريخ التدوير المختار
    public function getItemsCostList($item_cost_type,$date){
        $items_cost_list = array();
        if($item_cost_type == 1){ //حساب تكلفة المادة كوسطي سعر المادة بفواتير الشراء
            $query = DB::table("bill_item")
                ->select('items.id as itemId','items.name_ar as nameAr','items.cost as item_cost',         
                    DB::raw("(SELECT avg(bill_item.unit_price * bills.ex_rate) as new_unit_price 
                            FROM `bill_item` , `bills` 
                            WHERE bill_item.bill_id = bills.id 
                                    and bill_item.item_id = itemId
                                    and bills.bill_type_id = 1  
                                    and bills.date <=  '$date' 
                                    and bills.delete_by = 0 
                                    and bills.rotate_year is NULL 
                                    group by bill_item.item_id) as new_item_cost "))
                                ->join("items", "items.id", "bill_item.item_id")
                                ->leftjoin("bills","bill_item.bill_id", "bills.id")

                ->GROUPby('itemId');
                $query->where('bills.delete_by',0);
                $query->where('bills.rotate_year',NULL);

                $items_cost_list = $query->get();
            
              
        }else{ //تكلفة بأخر سعر شراء
            $query = DB::table("bill_item")
                ->select('items.id as itemId','items.name_ar as nameAr','items.cost as item_cost',         
                    DB::raw("(SELECT  (bill_item.unit_price * bills.ex_rate) as new_unit_price 
                    FROM `bill_item` , `bills` 
                    WHERE bill_item.bill_id = bills.id 
                            and bill_item.item_id = itemId
                            and bills.bill_type_id = 1 
                            and bills.date <=  '$date'  
                            and bills.delete_by = 0 
                            and bills.rotate_year is NULL
                            ORDER BY bills.id DESC
                            LIMIT 1) as new_item_cost "))
                                ->join("items", "items.id", "bill_item.item_id")
                                ->leftjoin("bills","bill_item.bill_id", "bills.id")

                ->GROUPby('itemId');
                $query->where('bills.delete_by',0);
                $query->where('bills.rotate_year',NULL);

                $items_cost_list = $query->get();
            
        }
                
        
        $items_purchase_ids = $items_cost_list->pluck('itemId')->all();
        $items_purchase_list =$items_cost_list->pluck('new_item_cost','itemId')->all();

        $items_info = DB::table('items')->select('id','name_ar','cost')->get();
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

    //جلب بضاعة أول مدة والتي دخلت النظام كبضاعة أول مدة او من فواتير المشتريات والتي تمت قبل
    //تاريخ التدوير
    public function getBeginItemsAmountInAllInventories($rotate_date){
        $query = DB::table("item_tracking as t0")
		->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
            'source.id as sourceInventory_id',
			DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
						WHERE t1.transaction_operation = 'in' 
                        and (t1.inventory_id_type_id = 5 or t1.inventory_id_type_id = 1)
                        and t1.date <= '$rotate_date'
						and t1.delete_by = '0'
                        and t1.rotate_year IS NULL
						and t1.item_id = t0.item_id 
						and t0.source = t1.source 
						) as item_in ")
			            )
						->join("items", "items.id", "t0.item_id")
						->leftjoin("inventories as source","t0.source", "source.id")

		->GROUPby('itemId','t0.source');

				$query->where('t0.delete_by',0);
                $query->where('t0.rotate_year',NULL);
				$query->orderby('source.name_ar','desc');
		$inventories_data = $query->get();
        
        return $inventories_data;
    }

    //حساب قيمة التقديرية لبضاعة أول المدة ب ل.س
    //بضاعة أول المدة = بضاعة أول المدة للعام المدور + مادخل النظام من مواد بفواتير شراء
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

    //جلب سعر صرف العملات خلال تاريخ معين
    public function getEx_rateAtDate($date){

       $date_time_start = date('Y-m-d H:i:s',strtotime($date));
       $date_time_end = date('Y-m-d H:i:s',strtotime($date.' 23:59:59'));

       $result = DB::table('currency_history')
                     ->select('currency_history.currency_id','currencies.name_ar',DB::raw('AVG(currency_history.ex_rate) as avg_ex_rate'))
                     ->where('edit_at','>',$date_time_start)
                     ->where('edit_at','<',$date_time_end)
                     ->join('currencies','currency_history.currency_id','currencies.id')
                     ->groupBy('currency_id')->pluck('avg_ex_rate','currency_history.currency_id');
        
        //dd($result);   
        $average_at_date = array();            
        $currencies_not_majer = $this->getCurrencies_Not_Major();
        foreach($currencies_not_majer as $curr){
            $average_at_date[$curr->id] = $result[$curr->id];
        }
        
        //check if get correct average and not null
        foreach($currencies_not_majer as $curr){
            if($average_at_date[$curr->id] == null){
                //اخر تعديل قبل التاريخ المحدد
                $ex_rate = DB::table('currency_history')
                ->select('currency_history.currency_id','currencies.name_ar','currency_history.ex_rate','currency_history.edit_at')
                ->where('edit_at','<',$date_time_start)
                ->where('currency_id',$curr->id)
                ->join('currencies','currency_history.currency_id','currencies.id')
                ->orderby('edit_at','desc')
                ->first()->ex_rate;
                if($ex_rate != null){
                    $average_at_date[$curr->id] = $ex_rate;
                }else{
                    $average_at_date[$curr->id] = DB::table('currencies')->where('id',$curr->id)->first()->ex_rate;
                }
            }
        }
        //dd($average_at_date);
        return $average_at_date;
    }

    //حساب الأرباح والخسائر
    public function calculateProfitsAndLoss(){

        //setting
        /*$setting = array(
            "ex_rate_2" => "2300.00",
            "ex_rate_3" => "2400.00",
            "rotate_date" => "2022-01-04",
            "item_cost_type" => "1",
            "account_id" => "770"
        );*/
        $setting = Session::get('rotate_setting');
        $bals_all_values = Session::get('rotate_bals_all_values');
        //dd($bals_all_values);
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
        //سعر الصرف بتارخ التدوير
        $ex_rate_at_date = $this->getEx_rateAtDate($setting['rotate_date']);
        
        //قيمة فرق سعر الصرف
        $majorCurrency = $this->getMajorCurrency();
        $currencies_not_majer = $this->getCurrencies_Not_Major();

        $ex_rate_difference_value=0;
        $all_bals_value_now = $bals_all_values['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_bals_value_now += ($bals_all_values['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }
        
        $all_bals_value_at_date = $bals_all_values['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_bals_value_at_date += ($bals_all_values['final_balance_'.$curr->id] * $ex_rate_at_date[$curr->id]);
        }
        
        $ex_rate_difference_value = $all_bals_value_now - $all_bals_value_at_date;
        //dd($ex_rate_difference_value);
     
        $sales_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Sales_Account'),$setting['rotate_date']);
        $purchases_return_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Purchases_Return_Account'),$setting['rotate_date']);
        $purchases_inMajorCurrency= $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Purchases_Account'),$setting['rotate_date']);
        $sales_return_inMajorCurrency = $this->getAccountBalanceUseingEqualizer($this->getSystemConfigValue('Sales_Return_Account'),$setting['rotate_date']);

        //  جلب قيمة الإيرادات قبل تاريخ التدوير المختار
        
        $incomes_balances = array();
        $activeCurrencies = $this->getActiveCurrencies();
        foreach($activeCurrencies as $curr){
            $incomes_balances['final_balance_'.$curr->id] = 0;
        }
        $this->getAccountBalance_sum_childrenBalances_at_date($this->getSystemConfigValue('Incomes_Account'),$setting['rotate_date'],$incomes_balances);
        $all_incomes = $incomes_balances['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_incomes +=($incomes_balances['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }

        

        //جلب قيمة المصاريف قبل تاريخ التدوير المحدد
        $outgoings_balances = array();
        foreach($activeCurrencies as $curr){
            $outgoings_balances['final_balance_'.$curr->id] = 0;
        }
        $this->getAccountBalance_sum_childrenBalances_at_date($this->getSystemConfigValue('Outgoings_Account'),$setting['rotate_date'],$outgoings_balances);
        $all_outgoings = $outgoings_balances['final_balance_'.$majorCurrency->id];
        foreach($currencies_not_majer as $curr){
            $all_outgoings +=($outgoings_balances['final_balance_'.$curr->id] * $ex_rate_now['ex_rate_'.$curr->id]);
        }
        //dd($all_outgoings);

        //gross profit مجمل الربح
        //مجمل الربح = المبيعات+ مردود مشتريات + بضاعة اخر المدة  - (بضاعة أول المدة + المشتريات + مردود مبيعات)
        $gross_profit_debit  = $sales_inMajorCurrency + $purchases_return_inMajorCurrency + $last_inventories_items_value;  
        $gross_profit_credit = $begin_inventories_items_value +  $purchases_inMajorCurrency + $sales_return_inMajorCurrency ;
        $gross_profit = $gross_profit_debit - $gross_profit_credit;

        //Net profit صافي الربح
        //صافي الربح = مجمل الربح  + الإيرادات -(كافة المصاريف)
        $net_profit_debit = $gross_profit + $all_incomes;
        $net_profit_credit = $all_outgoings;
        $net_profit = $net_profit_debit - $net_profit_credit;

        $result = array(
            'gross_profit'=>$gross_profit,
            'gross_profit_debit'=>$gross_profit_debit,
            'gross_profit_credit'=>$gross_profit_credit,
            'net_profit'=>$net_profit,
            'net_profit_debit'=>$net_profit_debit,
            'net_profit_credit'=>$net_profit_credit,
            'sales_inMajorCurrency'=>$sales_inMajorCurrency,
            'purchases_return_inMajorCurrency'=>$purchases_return_inMajorCurrency,
            'purchases_inMajorCurrency'=>$purchases_inMajorCurrency,
            'sales_return_inMajorCurrency'=>$sales_return_inMajorCurrency,
            'last_inventories_items_value'=>$last_inventories_items_value,
            'begin_inventories_items_value'=>$begin_inventories_items_value,
            'all_incomes_inMajorCurrency'=>$all_incomes,
            'all_outgoings_inMajorCurrency'=>$all_outgoings,
            'ex_rate_difference_value' => $ex_rate_difference_value,
            'items_cost_list'=>$items_cost_list
        );

      
        Storage::disk('local')->append('rotate_data_test.txt', json_encode($result)."/n");
        //return json_encode($all_outgoings);
        return  $result;
      
    }


    //تهيئة جميع  الجداول التي تدخل بعملية تدوير الحسابات 
    //حيث يتم اسناد قيمة السنة السابقة إلى جميع القيود المالية وحركة المواد 
    //لعتبارها قيود قديمة لا تدخل بالسنة المالية الجديدة
    public function resetTablesBeforeRotateData($rotate_date,$profits_and_loss){

        DB::table("bills")->where('rotate_year',NULL)->where('date','<=',$rotate_date)->update([
            "rotate_year"=>$rotate_date
        ]);
        DB::table("vouchers")->where('rotate_year',NULL)->where('date','<=',$rotate_date)->update([
            "rotate_year"=>$rotate_date
        ]);
               
        DB::table("entry_base")->where('rotate_year',NULL)->where('date','<=',$rotate_date)->update([
            "rotate_year"=>$rotate_date
        ]);


        DB::table('entries')
            ->join('entry_base','entry_base.id','=','entries.entry_base_id')
            ->where('entry_base.date','<=', $rotate_date)
            ->where('entries.rotate_year',NULL)
            ->update(array("entries.rotate_year"=>$rotate_date));

        DB::table("item_tracking")->where('rotate_year',NULL)->where('date','<=',$rotate_date)->update([
            "rotate_year"=>$rotate_date
        ]);

        //update rotate_data_result table and profits_and_loss value to last year
        DB::table("rotate_data_result")->where('profit_and_loss',NULL)->where('rotate_date',$rotate_date)->update([
            "profit_and_loss"=>$profits_and_loss,
            "date" => date("Y-m-d"),
        ]);

    }

    public function setEx_rate_diffrence_value_to_Account($ex_rate_difference_account_id,$ex_rate_difference_value,$rotate_date){
            
            $codes = $this->generateVoucherP_code();
            $code =$codes['code'];
            $p_code = $codes['p_code'];     
            $voucher_type_id = 4;
            $staff_id = CRUDBooster::myId();
            $date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_date)));
            $narration = "سند افتتاحي";
            
           
            //create voucher 
            $voucher_id = DB::table("vouchers")->insertGetId([
				'code' => $code,
                'p_code' => $p_code,
                'voucher_type_id' =>$voucher_type_id,
                'debit' => $ex_rate_difference_account_id,
                'credit' => 0,
                'narration' => $narration,
                'staff_id' => $staff_id,
                'date' => $date,
                'currency_id' => 1,
                'amount' => abs((float)$ex_rate_difference_value),
                'active' => 1
			]);
            
            
            $max = DB::table('entry_base')->where('rotate_year',NULL)->max('entry_number');
			$entry_number = $max + 1;
            
            $entry_base_id = DB::table("entry_base")->insertGetId([
				'entry_number' => $entry_number,
				'narration' => "قيمة فرق سعر الصرف الناتج عن التدوير",
				'date' => $date,
                'voucher_id' => $voucher_id,
				'active' => 1
			]);

            $entry = DB::table("entries")->insert([
                'entry_base_id' => $entry_base_id,
                'debit' => abs((float)$ex_rate_difference_value),
                'account_id' => $ex_rate_difference_account_id,
                'credit' => null,
                'currency_id' => 1
            ]);
			
    }

    //اعتماد سعر صرف جديد بعد التدوير
    public function setNewEx_rate_after_rotate_data($ex_rate_arr){
        $currencies_not_majer = $this->getCurrencies_Not_Major();
        foreach($currencies_not_majer as $curr){
            DB::table("currencies")->where("id",$curr->id)->update([
                "ex_rate"=>$ex_rate_arr['ex_rate_'.$curr->id]
            ]);
            DB::table('currency_history')->insert([
                'currency_id' => $curr->id,
                'ex_rate' => $ex_rate_arr['ex_rate_'.$curr->id],
                'edit_by' => CRUDBooster::myId(),
            ]);
        }
    }

    //تغيير كلف المواد بعد عملية التدوير
    public function setNewItemsCost_after_rotate_data($items_cost_list){
        foreach($items_cost_list as $key => $item){
            DB::table('items')->where('id',$key)->update([
                'cost'=>$item['cost']
            ]);
        }
    }

    //تدوير الحسابات
    public function rotate_data(){
        set_time_limit(1000000);
        $setting = Session::get('rotate_setting');
        $rotate_date = $setting['rotate_date'];
        //dd($setting);
        //check rotate data in this date
        $rotate_year_res = DB::table("rotate_data_result")->where('rotate_date',$rotate_date)->first(); 
        if($rotate_year_res != null){
            return json_encode(array('status'=>'error','massege'=>"Error, you rotate data in this date before."));
        }else{
            DB::table('rotate_data_result')->insert(['rotate_date'=>$rotate_date]);
        } 
      
        

        //تجهيز الأرصدة الإبتدائية
        $opening_balances = $this->calculate_opening_balances($rotate_date);
        //dd($opening_balances);
        //تجهيز  المخزون المتبقي للمستودعات
        $items_amounts = $this->getItemsAmountInAllInventories($rotate_date);

        //جلب قيمة الأرباح والخسائر
        $profits_details = $this->calculateProfitsAndLoss();
        $profits_and_loss = $profits_details['net_profit'];

        //return json_encode($profits_details);
        // تهيئة جميع الجداول 
        //bills, vouches,entry_base , entries, item_tracking
        $this->resetTablesBeforeRotateData($rotate_date,$profits_and_loss);

        //اسناد قيمة فرق سعر الصرف للحساب فرق سعر الصرف المحدد خلال عملية التدوير
        $this->setEx_rate_diffrence_value_to_Account($setting['account_id'],$profits_details['ex_rate_difference_value'],$rotate_date);


        //بناء السندات الإفتتاحية للسنة المالية الجديدة
        //وبالتاريخ التالي لتاريخ التدوير
        $this->create_begining_entries_for_new_year($opening_balances['accounts_info'],$rotate_date);

        //بناء قيود بضاعة أول مدة للمخزون المتبقي بالمستودعات
        $this->create_inventory_beginning_for_new_year($items_amounts,$rotate_date);

        //اعتماد سعر الصرف العملات المدخل ضمن عملية التدوير  لسعر صرف بالسنة المالية الجديدة
        $this->setNewEx_rate_after_rotate_data($setting);

        //اعتماد  كلف جديدة للمواد بعد التدوير  بالاعتماد على خيار المحدد بعملية التدوير
        //سواء كان وسطي أو أخر سعر شراء

        $items_cost_list = $profits_details['items_cost_list']; //قائمة بالكلف الجديدة للمواد بعد عملية التدوير
        $this->setNewItemsCost_after_rotate_data($items_cost_list);
        
        
        return json_encode(array('status'=>'success','massege'=>"Process done."));
    }


    /*****************************************************/
    //          توابع الحسابات التجميعية
    /****************************************************/

    //جلب الأبناء المباشرين لحساب معين
    public function getFirstChildernForAccount($account_id){

        $first_childs =DB::table('accounts')->select('id','name_ar','code','major_classification','person_id','closing_account_type')
                                            ->where('parent_id',$account_id)->get();
        return $first_childs;
    }

    //تحقق من أن الحساب يملك أبناء
    public function checkIfAccountHasChildren($account_id){
        $first_childs =DB::table('accounts')->where('parent_id',$account_id)->get();
         $hasChilds = false;
         if($first_childs->count() > 0){
            $hasChilds = true;
         }
         return $hasChilds;
    }

    //تابع يتحقق من الحساب هل هو حساب حقيقي أم تجميعي
    public function checkIfAccountHasEntries($account_id){
        $count =DB::table('entries')->where('account_id',$account_id)->get()->count();
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
                dd($bal);
                foreach($bal as $item){
                    $final_balances['final_balance_'.$item->currency_id] += $item->curr_balance; 
                }
            }
               
        }

    }

    //جلب قائمة بأرقام الحسابات المغلقة بحساب إغلاق معين
    public function getAccountsIDsListInClosingAccountType($closing_account_type){
        $accountsIDs = DB::table("accounts")->select('id','name_ar')->where('closing_account_type',$closing_account_type)->pluck('id')->toArray();
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
                //dd($bal);
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
                $account_name = DB::table('accounts')->select('id','name_ar')->where('id',$account_id)->first()->name_ar;
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


    /*************** Items Functions *********************/
    ///////////////////////////////////////////////////////

        public function getItems(){
            $id = CRUDBooster::myId();
            $me = DB::table('cms_users')->find($id);
            
            if($me->id_cms_privileges == 4){
                $inventories = DB::table('inventories')->where('major_classification',0)->where('delegate_id', $id)->get();
                $inventories_ids = DB::table('inventories')->where('major_classification',0)->where('delegate_id', $id)->pluck('id')->toArray();
            
                $items_ids = DB::table('item_tracking')->where('delete_by',0)->where('rotate_year',NULL)->whereIn('source',$inventories_ids)->distinct('item_id')->pluck('item_id')->toArray();
                $items = DB::table('items')->whereIn('id',$items_ids)->get();
            }else{
                $items = DB::table('items')->get();
            }
           
           return $items;
        }
    		
		public function getItemsIds(){
			$id = CRUDBooster::myId();
			$me = DB::table('cms_users')->find($id);
            $items_ids=[];
			if($me->id_cms_privileges == 4){
                $inventories = DB::table('inventories')->where('major_classification',0)->where('delegate_id', $id)->get();
                $inventories_ids = DB::table('inventories')->where('major_classification',0)->where('delegate_id', $id)->pluck('id')->toArray();
               
				$items_ids = DB::table('item_tracking')->where('delete_by',0)->where('rotate_year',NULL)->whereIn('source',$inventories_ids)->distinct('item_id')->pluck('item_id')->toArray();
            }else{
				$items_ids = DB::table('items')->pluck('id')->toArray();
			}
              
            return $items_ids;
		}
    
        //check if inventory has enough qauntity from item
        public function getInventoryQauntityItem($inventory,$item,$quantity){

            $query = DB::table("item_tracking as t0")
                ->select("t0.item_id as itemId",'items.name_ar as nameAr','source.name_ar as sourceInventory',
                    DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
                                WHERE t1.transaction_operation = 'in' 
								and t1.delete_by = '0' and t1.rotate_year is NULL 
                                and t1.item_id = t0.item_id 
                                and t0.source = t1.source ) as item_in "),
                    DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
                               WHERE t2.transaction_operation = 'out'
							    and t2.delete_by = '0' and t2.rotate_year is NULL 
                                and t0.item_id = t2.item_id and t0.source = t2.source) as item_out"))
                                ->join("items", "items.id", "t0.item_id")
                                ->leftjoin("inventories as source","t0.source", "source.id")

                ->GROUPby('itemId','t0.source');

                $query->where('items.id', $item );
                $query->where('t0.source', $inventory);
                $query->where('t0.delete_by',0);
                $query->where('t0.rotate_year',NULL);
                $data = $query->get();

                $hasEnough = false;
                if ( ($data[0]->item_in - $data[0]->item_out) >= $quantity ){
                    $hasEnough = true;
                }
              return $hasEnough;
        }


        public function getBillItemsDetails($id){
                
                $bill_items = DB::table('bill_item')
                 ->join("items", "items.id", "bill_item.item_id")
                 ->where('bill_id',$id)->orderby('bill_item.id','desc')->get();

                $result = "<table class='table'>
                        <tr>
                            <th>المادة</th>
                            <th>الكمية</th>
                            <th>سعر الواحدة</th>
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
                $person = DB::table('persons')->where('id',$person_id)->first();
                $person_account = DB::table('accounts')->where('id',$person->account_id)->first();
                return $person_account->parent_id;
            }else{
                return null;
            }

           
        }

        /*  Start Currencies Functions   */
        public function getActiveCurrencies(){
            $currencies = DB::table('currencies')->where('active',1)->get();
            return $currencies;
        }
        //قائمة بالعملات الغير رأيسية
        public function getCurrencies_Not_Major(){
            $currencies = DB::table('currencies')->where('is_major',0)->where('active',1)->get();
            return $currencies;
        }
        //جلب العملة الرئيسية
        public function getMajorCurrency(){
            $majorCurrency = DB::table('currencies')->where('is_major',1)->where('active',1)->first();
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
                return DB::table('system_config')->where('config_key',$key)->first()->config_value;
            });
            return $config_value;        
        }

    ///////////////////////////////////////////////////////////////
        //test
        public function SendMail() {

			$data = ['name'=>"haider",'email'=>"haider.ali.issa@gmail.com",'message'=>"message here"];
			CRUDBooster::sendEmail(['to'=>'haider.ali.issa@gmail.com','data'=>$data,'template'=>'forgot_password_backend','attachments'=>[]]);
			
			 
			 /*$to = "haider.ali.issa@gmail.com";
			 $subject = "This is subject";
			 
			 $message = "<b>This is HTML message.</b>";
			 $message .= "<h1>This is headline.</h1>";
			 
			 $header = "From:info@domdomta.com \r\n";
			 $header .= "MIME-Version: 1.0\r\n";
			 $header .= "Content-type: text/html\r\n";
			 
			 $retval = mail ($to,$subject,$message,$header);
			 
			 if( $retval == true ) {
				echo "Message sent successfully...";
			 }else {
				echo "Message could not be sent...";
			 }
		     */
			 //echo env('MAIL_USERNAME');
		     
		}

        public function emptyDBMainTables(){
            ItemTracking::truncate();
            echo "Items Tracking table is Empty now. done...<br/>";

            Entry::truncate();
            echo "entries table is Empty now. done...<br/>";
    
            EntryBase::truncate();
            echo "entry_base table is Empty now. done...<br/>";
    
            $BillsQuery = "TRUNCATE TABLE  bills;";
            DB::select(DB::raw($BillsQuery));
            echo "Bills table is Empty now. done...<br/>";
    
            $BillsQuery = "TRUNCATE TABLE  bills_files;";
            DB::select(DB::raw($BillsQuery));
            echo "bills_files table is Empty now. done...<br/>";
    
            $BillsQuery = "TRUNCATE TABLE  	bill_item;";
            DB::select(DB::raw($BillsQuery));
            echo "	bill_item table is Empty now. done...<br/>";

            Voucher::truncate();
            echo "Vouchers table is Empty now. done...<br/>";
         
            echo "<br>-------------------------------------------------<br/>";
            echo "DATABASE is Empty. you can make your Test";
            echo "<br>-------------------------------------------------<br/>";
    
            return "";
    
        }
}

