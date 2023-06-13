<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Data;

use App\Http\Controllers\General\RotateDataFunctionsController;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\SystemConfigration\PackageConfig;
use Session;
use Illuminate\Http\Request;
use DB;
use App\Traits\GeneralTrait;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Account;
use CRUDBooster;

class RotateDataController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "account_name";
		$this->limit = "20";
		$this->orderby = "sorting,asc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = true;
		$this->table = "reports";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Account Name", "name" => "account_name"];
		$this->col[] = ["label" => "Received Amount", "name" => "received_amount"];
		$this->col[] = ["label" => "Paamount", "name" => "paid_amount"];
		$this->col[] = ["label" => "Currency", "name" => "currency"];
		$this->col[] = ["label" => "Date", "name" => "date"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ["label" => "Account Name", "name" => "account_name", "type" => "text", "required" => TRUE, "validation" => "required|min:1|max:255"];
		$this->form[] = ["label" => "Received Amount", "name" => "received_amount", "type" => "text", "required" => TRUE, "validation" => "required|min:1|max:255"];
		$this->form[] = ["label" => "Paamount", "name" => "paid_amount", "type" => "text", "required" => TRUE, "validation" => "required|min:1|max:255"];
		$this->form[] = ["label" => "Currency", "name" => "currency", "type" => "text", "required" => TRUE, "validation" => "required|min:1|max:255"];
		$this->form[] = ["label" => "Date", "name" => "date", "type" => "date", "required" => TRUE, "validation" => "required|date"];

		# END FORM DO NOT REMOVE THIS LINE

		/*
		 | ----------------------------------------------------------------------
		 | Sub Module
		 | ----------------------------------------------------------------------
		 | @label          = Label of action
		 | @path           = Path of sub module
		 | @foreign_key 	  = foreign key of sub table/module
		 | @button_color   = Bootstrap Class (primary,success,warning,danger)
		 | @button_icon    = Font Awesome Class
		 | @parent_columns = Sparate with comma, e.g : name,created_at
		 |
		 */
		$this->sub_module = array();


		/*
		 | ----------------------------------------------------------------------
		 | Add More Action Button / Menu
		 | ----------------------------------------------------------------------
		 | @label       = Label of action
		 | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
		 | @icon        = Font awesome class icon. e.g : fa fa-bars
		 | @color 	   = Default is primary. (primary, warning, succecss, info)
		 | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
		 |
		 */
		$this->addaction = array();


		/*
		 | ----------------------------------------------------------------------
		 | Add More Button Selected
		 | ----------------------------------------------------------------------
		 | @label       = Label of action
		 | @icon 	   = Icon from fontawesome
		 | @name 	   = Name of button
		 | Then about the action, you should code at actionButtonSelected method
		 |
		 */
		$this->button_selected = array();


		/*
		 | ----------------------------------------------------------------------
		 | Add alert message to this module at overheader
		 | ----------------------------------------------------------------------
		 | @message = Text of message
		 | @type    = warning,success,danger,info
		 |
		 */
		$this->alert = array();



		/*
		 | ----------------------------------------------------------------------
		 | Add more button to header button
		 | ----------------------------------------------------------------------
		 | @label = Name of button
		 | @url   = URL Target
		 | @icon  = Icon from Awesome.
		 |
		 */
		$this->index_button = array();



		/*
		 | ----------------------------------------------------------------------
		 | Customize Table Row Color
		 | ----------------------------------------------------------------------
		 | @condition = If condition. You may use field alias. E.g : [id] == 1
		 | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
		 |
		 */
		$this->table_row_color = array();



		/*
		 | ----------------------------------------------------------------------
		 | You may use this bellow array to add statistic at dashboard
		 | ----------------------------------------------------------------------
		 | @label, @count, @icon, @color
		 |
		 */
		$this->index_statistic = array();



		/*
		 | ----------------------------------------------------------------------
		 | Add javascript at body
		 | ----------------------------------------------------------------------
		 | javascript code in the variable
		 | $this->script_js = "function() { ... }";
		 |
		 */
		$this->script_js = NULL;


		/*
		 | ----------------------------------------------------------------------
		 | Include HTML Code before index table
		 | ----------------------------------------------------------------------
		 | html code to display it before index table
		 | $this->pre_index_html = "<p>test</p>";
		 |
		 */
		$this->pre_index_html = null;



		/*
		 | ----------------------------------------------------------------------
		 | Include HTML Code after index table
		 | ----------------------------------------------------------------------
		 | html code to display it after index table
		 | $this->post_index_html = "<p>test</p>";
		 |
		 */
		$this->post_index_html = null;



		/*
		 | ----------------------------------------------------------------------
		 | Include Javascript File
		 | ----------------------------------------------------------------------
		 | URL of your javascript each array
		 | $this->load_js[] = asset("myfile.js");
		 |
		 */
		$this->load_js = array();



		/*
		 | ----------------------------------------------------------------------
		 | Add css style at body
		 | ----------------------------------------------------------------------
		 | css code in the variable
		 | $this->style_css = ".style{....}";
		 |
		 */
		$this->style_css = NULL;



		/*
		 | ----------------------------------------------------------------------
		 | Include css File
		 | ----------------------------------------------------------------------
		 | URL of your css each array
		 | $this->load_css[] = asset("myfile.css");
		 |
		 */
		$this->load_css = array();
	}


	/*
	 | ----------------------------------------------------------------------
	 | Hook for button selected
	 | ----------------------------------------------------------------------
	 | @id_selected = the id selected
	 | @button_name = the name of button
	 |
	 */
	public function actionButtonSelected($id_selected, $button_name)
	{
	//Your code here

	}


	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate query of index result
	 | ----------------------------------------------------------------------
	 | @query = current sql query
	 |
	 */
	public function hook_query_index(&$query)
	{

	//Your code here



	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate row of index table html
	 | ----------------------------------------------------------------------
	 |
	 */
	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
		$column_value = 1;
	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate data input before add data is execute
	 | ----------------------------------------------------------------------
	 | @arr
	 |
	 */
	public function hook_before_add(&$postdata)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command after add public static function called
	 | ----------------------------------------------------------------------
	 | @id = last insert id
	 |
	 */
	public function hook_after_add($id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate data input before update data is execute
	 | ----------------------------------------------------------------------
	 | @postdata = input post data
	 | @id       = current id
	 |
	 */
	public function hook_before_edit(&$postdata, $id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command after edit public static function called
	 | ----------------------------------------------------------------------
	 | @id       = current id
	 |
	 */
	public function hook_after_edit($id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command before delete public static function called
	 | ----------------------------------------------------------------------
	 | @id       = current id
	 |
	 */
	public function hook_before_delete($id)
	{
	//Your code here

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for execute command after delete public static function called
	 | ----------------------------------------------------------------------
	 | @id       = current id
	 |
	 */
	public function hook_after_delete($id)
	{
	//Your code here

	}


	public function getIndex(Request $request)
	{
		
		//check if display Cycle is current Cycle
		if(Session::get('display_cycle') == Session::get('current_cycle')){
			$not_current_cycle_error = 0; //false

			$rotate_date = date("Y-m-d");
			$gfunc = new GeneralFunctionsController();
			$main_accounts_ids = explode(',', $gfunc->getSystemConfigValue('Main_Accounts_ids'));
			$accounts = Account::where('major_classification', 0)->whereNotIn('id', $main_accounts_ids)->orderby('id', 'desc')->get();

			$currencies_not_major = Currency::where('is_major', 0)->where('active', 1)->get();

			
			$inActiveStatus=EntryBase::join('entries','entries.entry_base_id','entry_base.id')
										->join('vouchers','vouchers.id','entry_base.voucher_id')	
										->where('entries.status', 0)
										->where('vouchers.voucher_type_id',3) //check just transfer vouchers
										->whereNotNull('entry_base.voucher_id')
										->whereNull('entries.action')
										->where('entries.cycle_id',Session::get('display_cycle'))
										->first(); 

			$inActiveTrackStatus = ItemTracking::where('item_tracking_type_id',6)
												->where('cycle_id',Session::get('display_cycle'))
												->where('status', 0)
												->whereNull('action')
												->first(); //check just transfer items records
			$errors = false;
			if($inActiveStatus || $inActiveTrackStatus){
				$errors = true;
			}
			$old_setting = Session::get('rotate_setting');


			//check if package config allow to add New Backup
			$totat_backups_size = PackageConfig::first()->backups_size;
			$backups_db_path = storage_path('app/backups');
			$backups_attacts_path = storage_path('app/backups_attachs');
			$current_backups_size = $gfunc->getFolderSize($backups_db_path) + $gfunc->getFolderSize($backups_attacts_path);

			$backups_size_error = 0;
			if ($totat_backups_size > 0 && ($current_backups_size >= $totat_backups_size)) {
				$backups_size_error = 1;
			}
		} else {
			$not_current_cycle_error = 1;
		}


		return view("data.rotate_data_setting", array("rotate_date" => $rotate_date, "accounts" => $accounts,
			"currencies_not_major" => $currencies_not_major,'old_setting'=>$old_setting ,'errors'=>$errors,
			'backups_size_error'=>$backups_size_error , 'not_current_cycle_error'=>$not_current_cycle_error
		));
	}


	public function continue_rotate_data(Request $request)
	{
		Session::forget('rotate_setting');
		Session::forget('rotate_bals_all_values');

		$rotate_setting = $request->request->all();
		
		Session::put('rotate_setting', $rotate_setting);
		
		$RDfunc = new RotateDataFunctionsController();

		$rotate_date_status=json_decode($RDfunc->checkRotateDate($rotate_setting['rotate_date']));
		if ($rotate_date_status->status == 'error') {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], $rotate_date_status->massege, "danger");
		}

		
		//جلب معلومات الأرصدة الإفتتاحية للسنة الماليةالجديدة
		$res = $RDfunc->calculate_opening_balances($rotate_setting['rotate_date']);
		$accounts_info = $res['accounts_info'];
		
		$activeCurrencies = $RDfunc->getActiveCurrencies();
		$final_balances = array();
		$final_balances['final_equalizer']=$res['final_equalizer'];
		foreach ($activeCurrencies as $curr) {
			$final_balances['final_balance_' . $curr->id] = $res['final_balance_' . $curr->id];
		}

		/******************** جلب المخزون المتبقي من المواد ضمن المستودعات ****************/
		$inventories_data = $RDfunc->getItemsAmountInAllInventories($rotate_setting['rotate_date']);
		/************** حساب الأرباح والخسائر **********************/

		Session::put('rotate_bals_all_values', $final_balances);

		$profits_and_loss = (object)$RDfunc->calculateProfitsAndLoss();

		
		//add values of  net_profit,ex_rate_difference_value,last_inventories_items_value to final balances array
		$majorCurr = $RDfunc->getMajorCurrency();
		$final_balances['final_balance_with_rotate_accounts'] = $final_balances['final_balance_' . $majorCurr->id] + ($profits_and_loss->net_profit + $profits_and_loss->last_inventories_items_value + $profits_and_loss->ex_rate_difference_value); 
		//dd($final_balances);
		$next_rotate_date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_setting['rotate_date'])));
		//dd($profits_and_loss);
		return view("data.rotate_data", array("data" => $accounts_info, 'next_rotate_date'=>$next_rotate_date,"inventories_data" => $inventories_data,
			'profits_and_loss' => $profits_and_loss,
			'final_balances' => $final_balances, 'activeCurrencies' => $activeCurrencies,'majorCurrency'=>$majorCurr
		));
	}

	public function showResult(){
		return view("data.rotate_data_result");
	}

}
