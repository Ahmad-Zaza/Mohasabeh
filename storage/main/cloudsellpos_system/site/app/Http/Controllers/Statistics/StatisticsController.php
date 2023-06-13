<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Statistics;

use DB;
use CRUDBooster;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\SystemConfigration\StatisticSetting;
use Session;
class StatisticsController
{



	
	//By the way, you can still create your own method in here... :)

	public function getAdminStatisticsSetting()
	{
		$id = CRUDBooster::myId();
		$admin = User::find($id);

		$load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");
		$load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");

		$data = [];
		return view("statistics.admin_statistic_setting", array("data" => $data, "load_js" => $load_js, "load_css" => $load_css));
	}

	public function editStatisticsSetting($data)
	{
		$setting = json_decode($data);
		$show_method = '';
		$choosen_accounts = [];
		foreach ($setting as $set) {
			if ($set->name == 'show_method') {
				$show_method = $set->value;
			}
			if ($set->name == 'accounts[]') {
				array_push($choosen_accounts, $set->value);
			}
		}

		StatisticSetting::where('id', 1)->update([
			"value" => '' . $show_method
		]);


		StatisticSetting::where('id', 2)->update([
			"value" => implode(',', $choosen_accounts)
		]);

		return 1; //as true
	}

	public function getAdminStatistics()
	{

		$last_show_method = StatisticSetting::where('id', 1)->first()->value;
		$last_choosen_accounts = StatisticSetting::where('id', 2)->first()->value;

		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		$accounts_ids = explode(',', $last_choosen_accounts);
		
		$general_box = $gfunc->getSystemConfigValue("General_Box");

		
		if (in_array($general_box, $accounts_ids)) {
			//delete account_id from array
			if (($key = array_search($general_box, $accounts_ids)) !== false) {
				unset($accounts_ids[$key]);
			}
			//add deleted general_box in the begining of array
			array_unshift($accounts_ids, "" . $general_box);
		}
		
		$accounts_Balances = [];
		if ($accounts_ids[0] != "") {
			foreach ($accounts_ids as $id) {
				$acc_info = Account::where('id', $id)->first();
				$temp = array('account_id' => $acc_info->id, 'account_name' => $acc_info->name_ar);
				$balance = $gfunc->getAccountBalance($id);
				$temp['balance'] = $balance;
				array_push($accounts_Balances, $temp);
			}
		}
		//fix data to useful format
		$accounts_info = array();

		foreach ($accounts_Balances as $item) {
			$arr = array('account_id' => $item['account_id'], 'account_name' => $item['account_name']);
			foreach ($active_currencies as $curr) {
				$arr['curr_balance_' . $curr->id] = 0;
			}
			if (count($item['balance']) > 0) {
				foreach ($item['balance'] as $bal) {
					$arr['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
				}
			}

			array_push($accounts_info, $arr);

		}
		
		if(CRUDBooster::isSuperadmin()){
			//get notification
			$notifications = $gfunc->getNotifications();
		}
		

		return view("statistics.admin_statistic", array("accounts_info" => $accounts_info, "show_method" => $last_show_method, "active_currencies" => $active_currencies,"general_box"=>$general_box,'notifications' => $notifications));

	}

	public function getManagerStatistics()
	{

		$last_show_method = StatisticSetting::where('id', 1)->first()->value;
		$last_choosen_accounts = StatisticSetting::where('id', 2)->first()->value;

		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		$accounts_ids = explode(',', $last_choosen_accounts);

		$general_box = $gfunc->getSystemConfigValue("General_Box");

		if (in_array($general_box, $accounts_ids)) {
			//delete account_id from array
			if (($key = array_search($general_box, $accounts_ids)) !== false) {
				unset($accounts_ids[$key]);
			}
			//add deleted general_box in the begining of array
			array_unshift($accounts_ids, "" . $general_box);
		}

		//----------------------------
		$accounts_Balances = [];
		if ($accounts_ids[0] != "") {
			foreach ($accounts_ids as $id) {
				$acc_info = Account::where('id', $id)->first();
				$temp = array('account_id' => $acc_info->id, 'account_name' => $acc_info->name_ar);
				$balance = $gfunc->getAccountBalance($id);
				$temp['balance'] = $balance;
				array_push($accounts_Balances, $temp);
			}
		}
		//fix data to useful format
		$accounts_info = array();

		foreach ($accounts_Balances as $item) {
			$arr = array('account_id' => $item['account_id'], 'account_name' => $item['account_name']);
			foreach ($active_currencies as $curr) {
				$arr['curr_balance_' . $curr->id] = 0;
			}
			if (count($item['balance']) > 0) {
				foreach ($item['balance'] as $bal) {
					$arr['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
				}
			}

			array_push($accounts_info, $arr);

		}

		//get notification
		$notifications = $gfunc->getNotifications();

		return view("statistics.manager_statistic", array("accounts_info" => $accounts_info, "show_method" => $last_show_method, "active_currencies" => $active_currencies ,"general_box"=>$general_box,'notifications'=>$notifications));

	}

	public function getSalesManagerStatistics()
	{
		
			$user = CRUDBooster::getUser();
			
			
			$gfunc = new GeneralFunctionsController();
			$salesmanager_balance = $gfunc->getAccountBalance($user->boxAccount);

			$customers = $user->getCustomers();
		
			$customers_Balances = array();
			foreach ($customers as $customer) {
				$temp = array('customer_account_id' => $customer->account_id, 'customer_name' => $customer->name_ar);
				$customer_balance = $gfunc->getAccountBalance($customer->account_id);
				$temp['balance'] = $customer_balance;
				array_push($customers_Balances, $temp);
			}
			//fix data to useful forma
			$cust_accounts_info = array();
			$active_currencies = $gfunc->getActiveCurrencies();
			foreach ($customers_Balances as $item) {
				$arr = array('account_id' => $item['customer_account_id'], 'account_name' => $item['customer_name']);
				foreach ($active_currencies as $curr) {
					$arr['curr_balance_' . $curr->id] = 0;
				}
				if (count($item['balance']) > 0) {
					foreach ($item['balance'] as $bal) {
						$arr['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
					}
					array_push($cust_accounts_info, $arr);
				}

			}

			//get notification
			$notifications = $gfunc->getNotifications();

			return view("statistics.salesmanager_statistic", array("user_account_id" => $user->boxAccount, "user_name" => $user->name, 'user_balance' => $salesmanager_balance,
				"customers_balances" => $cust_accounts_info, "active_currencies" => $active_currencies,'notifications'=>$notifications));
		
	}

	public function getSalesmenStatistics()
	{

		$user = CRUDBooster::getUser();
			
		if ($user->roleId == 4) {
			$gfunc = new GeneralFunctionsController();
			$salesman_balance = $gfunc->getAccountBalance($user->boxAccount);

			$customers = $user->getCustomers();
			//dd($customers);
			$customers_Balances = array();
			foreach ($customers as $customer) {
				$temp = array('customer_account_id' => $customer->account_id, 'customer_name' => $customer->name_ar);
				$customer_balance = $gfunc->getAccountBalance($customer->account_id);
				$temp['balance'] = $customer_balance;
				array_push($customers_Balances, $temp);
			}
			//dd($customers_Balances);
			//fix data to useful forma
			$cust_accounts_info = array();
			$active_currencies = $gfunc->getActiveCurrencies();
			foreach ($customers_Balances as $item) {
				$arr = array('account_id' => $item['customer_account_id'], 'account_name' => $item['customer_name']);
				foreach ($active_currencies as $curr) {
					$arr['curr_balance_' . $curr->id] = 0;
				}
				if (count($item['balance']) > 0) {
					foreach ($item['balance'] as $bal) {
						$arr['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
					}
					array_push($cust_accounts_info, $arr);
				}

			}
			//return response()->json($salesman_balance);

			//جلب أرصدة الموردين الذين يتعاملون معه
			/*$suppliers= $gfunc->getSalesmanSuppliers($salesman->id);
			 $suppliers_Balances = array();
			 foreach($suppliers as $supplier){
			 $temp=array('supplier_account_id'=>$supplier->account_id,'supplier_name'=>$supplier->name_ar);
			 $supplier_balance= $gfunc->getAccountBalance($supplier->account_id);
			 $temp['balance'] = $supplier_balance;
			 array_push($suppliers_Balances,$temp);
			 }
			 //dd($suppliers_Balances);
			 //fix data to useful forma
			 $sups_accounts_info = array();
			 $active_currencies = $gfunc->getActiveCurrencies();
			 foreach($suppliers_Balances as $item){
			 $arr=array('account_id'=>$item['supplier_account_id'],'account_name'=>$item['supplier_name']);
			 foreach($active_currencies as $curr){
			 $arr['curr_balance_'.$curr->id]=0;	
			 }
			 if(count($item['balance']) > 0 ){
			 foreach($item['balance'] as $bal){
			 $arr['curr_balance_'.$bal->currency_id]=$bal->curr_balance;
			 }
			 array_push($sups_accounts_info,$arr); 
			 }
			 
			 }
			 */
			//return response()->json($sups_accounts_info);


			//get notification
			$notifications = $gfunc->getNotifications();
			

			return view("statistics.salesmen_statistic", array("salesman_account_id" => $user->boxAccount, "salesman_name" => $user->name, 'salesman_balance' => $salesman_balance,
				"customers_balances" => $cust_accounts_info, "active_currencies" => $active_currencies,'notifications'=>$notifications));
		}
	}

	public function getFactoryDelegateStatistics()
	{
		
			$user = CRUDBooster::getUser();
			
			$gfunc = new GeneralFunctionsController();
			$customers = $user->getCustomers();
			
			$customers_Balances = array();
			foreach ($customers as $customer) {
				$temp = array('customer_account_id' => $customer->account_id, 'customer_name' => $customer->name_ar);
				$customer_balance = $gfunc->getAccountBalance($customer->account_id);
				$temp['balance'] = $customer_balance;
				array_push($customers_Balances, $temp);
			}
			
			//fix data to useful forma
			$cust_accounts_info = array();
			$active_currencies = $gfunc->getActiveCurrencies();
			foreach ($customers_Balances as $item) {
				$arr = array('account_id' => $item['customer_account_id'], 'account_name' => $item['customer_name']);
				foreach ($active_currencies as $curr) {
					$arr['curr_balance_' . $curr->id] = 0;
				}
				if (count($item['balance']) > 0) {
					foreach ($item['balance'] as $bal) {
						$arr['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
					}
					array_push($cust_accounts_info, $arr);
				}

			}

			//get notification
			$notifications = $gfunc->getNotifications();

			return view("statistics.factory_delegate_statistic", array("user_name" => $user->name, 
				"customers_balances" => $cust_accounts_info, "active_currencies" => $active_currencies,'notifications'=>$notifications));
		
	}

	public function getFactoryCashierStatistics()
	{
		
			$user = CRUDBooster::getUser();
			
			$gfunc = new GeneralFunctionsController();
			$factory_cashier_balance = $gfunc->getAccountBalance($user->boxAccount);
			
			$customers = $user->getCustomers();
			
			$customers_Balances = array();
			foreach ($customers as $customer) {
				$temp = array('customer_account_id' => $customer->account_id, 'customer_name' => $customer->name_ar);
				$customer_balance = $gfunc->getAccountBalance($customer->account_id);
				$temp['balance'] = $customer_balance;
				array_push($customers_Balances, $temp);
			}
			//dd($customers_Balances);
			//fix data to useful forma
			$cust_accounts_info = array();
			$active_currencies = $gfunc->getActiveCurrencies();
			foreach ($customers_Balances as $item) {
				$arr = array('account_id' => $item['customer_account_id'], 'account_name' => $item['customer_name']);
				foreach ($active_currencies as $curr) {
					$arr['curr_balance_' . $curr->id] = 0;
				}
				if (count($item['balance']) > 0) {
					foreach ($item['balance'] as $bal) {
						$arr['curr_balance_' . $bal->currency_id] = $bal->curr_balance;
					}	
				}
				array_push($cust_accounts_info, $arr);
			}

			//get notification
			$notifications = $gfunc->getNotifications();

			return view("statistics.factory_cashier_statistic", array("user_account_id" => $user->boxAccount, "user_name" => $user->name, 'user_balance' => $factory_cashier_balance,
				"customers_balances" => $cust_accounts_info, "active_currencies" => $active_currencies,'notifications'=>$notifications));
		
	}


}
