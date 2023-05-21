<?php

namespace App\Http\Controllers;

use crocodicstudio_voila\crudbooster\helpers\CRUDBooster as HelpersCRUDBooster;
use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;

class AdminStatisticsController
{



	public function getSalesmenStatistics()
	{

		$id = CRUDBooster::myId();
		$salesman = DB::table('cms_users')->find($id);
		
		if ($salesman->id_cms_privileges == 4) {
			$gfunc= new GeneralFunctionsController();
			$salesman_balance= $gfunc->getAccountBalance($salesman->account_id);

			$customers= $gfunc->getSalesmanCustomers($salesman->id);

			$customers_Balances = array();
			foreach($customers as $customer){
				$temp=array('customer_account_id'=>$customer->account_id,'customer_name'=>$customer->name_ar);
				$customer_balance= $gfunc->getAccountBalance($customer->account_id);
				$temp['balance'] = $customer_balance;
				array_push($customers_Balances,$temp);
			}

		//dd($customers_Balances);
		//fix data to useful forma
		$cust_accounts_info = array();
		$active_currencies = $gfunc->getActiveCurrencies();
		foreach($customers_Balances as $item){
			$arr=array('account_id'=>$item['customer_account_id'],'account_name'=>$item['customer_name']);
			foreach($active_currencies as $curr){
				$arr['curr_balance_'.$curr->id]=0;	
			}
				if(count($item['balance']) > 0 ){
					foreach($item['balance'] as $bal){
						$arr['curr_balance_'.$bal->currency_id]=$bal->curr_balance;
					}
					array_push($cust_accounts_info,$arr); 
				}
				
		}
		//return json_encode($salesman_balance);

		return view("statistics.salesmen_statistic", array("salesman_account_id" => $salesman->account_id,"salesman_name" => $salesman->name,'salesman_balance'=>$salesman_balance,
					"customers_balances"=>$cust_accounts_info,"active_currencies"=>$active_currencies));
		}
	}

	//By the way, you can still create your own method in here... :)

	public function getAdminStatisticsSetting(){
		$id = CRUDBooster::myId();
		$admin = DB::table('cms_users')->find($id);
		
		$load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");
        $load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");

		$data = [];
		return view("statistics.admin_statistic_setting", array("data"=>$data,"load_js"=>$load_js,"load_css"=>$load_css));
	}

	public function editStatisticsSetting($data){
		$setting=json_decode($data); 
		$show_method = '';
		$choosen_accounts = [];
		foreach($setting as $set){
			if($set->name == 'show_method'){
				$show_method = $set->value;
			}
			if($set->name == 'accounts[]'){
				array_push($choosen_accounts,$set->value);
			}
		}


		//return implode(',',$choosen_accounts);
		DB::table('statistics_setting')->where('id',1)->update([
            "value"=>''.$show_method
        ]);
			
	
		DB::table('statistics_setting')->where('id',2)->update([
			"value"=>implode(',',$choosen_accounts)
		]);

	    return 1; //as true
	}

	public function getAdminStatistics()
	{

		$last_show_method = DB::table('statistics_setting')->where('id',1)->first()->value;
		$last_choosen_accounts = DB::table('statistics_setting')->where('id',2)->first()->value;
		
		$gfunc= new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		$accounts_ids = explode(',',$last_choosen_accounts);
		
		//dd($accounts_ids);
		//إعادة ترتيب الحسابات لوضع الصناديق بالاول
		$activeCurrenciesReversed = $active_currencies->reverse();
		foreach ($activeCurrenciesReversed as $curr) {
			if(in_array($curr->account_id,$accounts_ids)){
				//delete account_id from array
				if (($key = array_search($curr->account_id, $accounts_ids)) !== false) {
					unset($accounts_ids[$key]);
				}
				//add deleted account_id in the begining of array
				array_unshift($accounts_ids , "".$curr->account_id);
			}
		}
		//----------------------------
		//dd($accounts_ids);
		$accounts_Balances = [];
		if($accounts_ids[0]!=""){
			foreach($accounts_ids as $id){
				$acc_info = DB::table('accounts')->where('id',$id)->first();
				$temp=array('account_id'=>$acc_info->id,'account_name'=>$acc_info->name_ar);
				$balance= $gfunc->getAccountBalance($id);
				$temp['balance'] = $balance;
				array_push($accounts_Balances,$temp);
			}
		}
		//dd($accounts_Balances);
		//fix data to useful format
		$accounts_info = array();
		
		foreach($accounts_Balances as $item){
				$arr=array('account_id'=>$item['account_id'],'account_name'=>$item['account_name']);
				foreach($active_currencies as $curr){
					$arr['curr_balance_'.$curr->id]=0;	
				}	
				if(count($item['balance']) > 0 ){
					foreach($item['balance'] as $bal){
							$arr['curr_balance_'.$bal->currency_id]=$bal->curr_balance;
					}
				}

				array_push($accounts_info,$arr); 
				
		}

		//return json_encode($accounts_info);
		
		return view("statistics.admin_statistic", array("accounts_info"=>$accounts_info,"show_method"=>$last_show_method,"active_currencies"=>$active_currencies));
		
	}
 
}
