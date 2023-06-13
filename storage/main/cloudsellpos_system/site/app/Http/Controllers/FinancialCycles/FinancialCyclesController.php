<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\FinancialCycles;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Http\Controllers\General\ReCalculateCycleDataFunctionsController;
use App\Models\Accounts\Account;
use App\Models\FinancialCycles\FinancialCycle;
use App\Models\FinancialCycles\ReCalculateCycleHistory;
use App\Models\RotateData\RotateDataResult;
use App\Models\SystemConfigration\SystemSetting;
use DB;
use CRUDBooster;
use Session;
class FinancialCyclesController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "cycle_name";
		$this->limit = "20";
		$this->orderby = "rotate_date,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "financial_cycles";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => trans('modules.cycle_name'), "name" => "cycle_name"];
		$this->col[] = ["label" => trans('modules.rotate_date'), "name" => "rotate_date"];
		$this->col[] = ["label" => trans('modules.created_date'), "name" => "created_date"];
		$this->col[] = ["label" => trans('modules.status'), "name" => "status"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => trans('modules.cycle_name'), 'name' => 'cycle_name', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.rotate_date'), 'name' => 'rotate_date', 'type' => 'date', 'validation' => '', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.created_date'), 'name' => 'created_date', 'type' => 'datetime', 'validation' => '', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.status'), 'name' => 'status', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
        
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
		$this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('display/[id]'),'icon'=>'fa fa-eye','color'=>'primary','title'=> trans('labels.display_cycle'),'showIf'=>"[status] == 'finished'"];
		if(CRUDBooster::isManager()){
			$this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('settings/[id]'),'icon'=>'fa fa-gear','color'=>'info','title'=> trans('labels.cycle_setting'),'showIf'=>"[status] == 'finished'"];
			$this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('result/[id]'),'icon'=>'fa fa-pie-chart','color'=>'success','title'=> trans('labels.cycle_result'),'showIf'=>"[status] == 'finished'"];
		}
		if(CRUDBooster::isSuperadmin()){
			$this->addaction[] = ['label'=>'','url'=>CRUDBooster::mainpath('history/[id]'),'icon'=>'fa fa-list','color'=>'warning','title'=> trans('labels.actions_history'),'showIf'=>"[status] == 'finished'"];
		}
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
		$this->style_css = "
				.selected-action {
					display: none !important;
				}
			";



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
		$query = $query->where('status','finished');

	}

	/*
	 | ----------------------------------------------------------------------
	 | Hook for manipulate row of index table html
	 | ----------------------------------------------------------------------
	 |
	 */
	public function hook_row_index($column_index, &$column_value)
	{
		if ($column_index == 3) {
			if ($column_value == 'finished') {
				$column_value = trans('labels.finished');
			}
		}
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



	//By the way, you can still create your own method in here... :)
	public function showSettings($id){
		$cycle = FinancialCycle::find($id);

		$currencies_ex_rates_arr = explode(',',$cycle->currencies_ex_rate);
		$rotate_data_ex_rates = array(); 
		foreach($currencies_ex_rates_arr as $ex_rate_val){
			$temp = explode('|',$ex_rate_val);
			$rotate_data_ex_rates[$temp[0]] = $temp[1]; 
		}


		$gfunc = new GeneralFunctionsController();
		$not_major_currenies = $gfunc->getCurrencies_Not_Major();
		
		$cycle_setting = array(
			'rotate_date'=> $cycle->rotate_date,
			'item_cost_type'=> ($cycle->item_cost_type == 0)?trans('labels.last_purchase'):trans('labels.cost_avg'),
			'profits_account'=> Account::find($cycle->profits_account_id)->name_ar,
			'diff_ex_rate_account'=> Account::find($cycle->diff_ex_rate_account_id)->name_ar,
			'last_inventories_items_value_account'=> Account::find($cycle->last_inventories_items_value_account_id)->name_ar,
			'currencies_ex_rates'=> $rotate_data_ex_rates ,
		);
		//dd($cycle_setting);
		return view('financial_cycles.settings',array('cycle_setting'=>$cycle_setting,
													  'not_major_currenies'=>$not_major_currenies,
													  'rotate_data_ex_rates'=>$rotate_data_ex_rates
													));
	}
	public function showResult($id){
		$result = RotateDataResult::where('cycle_id', $id)->first();
		$result->gross_profit_debit = ($result->sales_return + $result->granted_discount + $result->purchases + $result->begin_inventories_items_value);
		$result->gross_profit_credit = ($result->sales + $result->purchases_return + $result->earned_discount + $result->last_inventories_items_value);
		$result->net_profit_debit = $result->outgoings;
		$result->net_profit_credit = $result->gross_profit + $result->incomes;

		return view('financial_cycles.result',array('cycle_result'=>$result));
	}

	public function showActionsHistory($id){
		
		$cycle = FinancialCycle::find($id);
		$cycle_history = ReCalculateCycleHistory::where('cycle_id',$id)->orderby('date','desc')->get();
		$upgrade_cycle_id = $cycle_history->first()->upgrade_cycle_id;
		$showActionBtn = false;
		if($upgrade_cycle_id == Session::get('current_cycle')){
			$showActionBtn = true;
		}
		$cycle_history->each(function($record){
			$upgrade_cycle_name = FinancialCycle::find($record->upgrade_cycle_id)->cycle_name;	
			if($upgrade_cycle_name){
				$record->upgrade_cycle_name = $upgrade_cycle_name;
			}else{
				$record->upgrade_cycle_name = trans('labels.current_cycle');
			}
			if($record->action == 'ignore'){
				$record->action_trans = trans('labels.ignore_edits');
			}else{
				$record->action_trans = trans('labels.re_calculate_data');
			}
			$record->options = explode(',',$record->options);
		});
		
		return view('financial_cycles.actions_history',array('cycle'=>$cycle,'cycle_history'=>$cycle_history,'showActionBtn'=>$showActionBtn));
	}
	public function displayCycle($id)
	{
		Session::put('display_cycle',$id);
		$display_cycle_name = FinancialCycle::where('id', $id)->first()->cycle_name;
		Session::put('display_cycle_name',$display_cycle_name);
		return redirect(CRUDBooster::adminPath());
	}


	public function goBackToCurrentCycle()
	{
		$curr_cycle_id = FinancialCycle::where('status', 'current')->first()->id;
		Session::put('display_cycle',$curr_cycle_id);
		Session::forget('display_cycle_name');
		return redirect(CRUDBooster::adminPath());
	}


	public function reCalculateData($edit_cycle = 0){

		//default options to update current cycle data
		$options_arr = array('initial_balances','beginning_items');
		$editedCycle_id=0;
		if($edit_cycle == 0){
			$editedCycle_id = SystemSetting::where('setting_key','old_cycle_edited_id')->first()->setting_value;
		}else{
			$editedCycle_id = $edit_cycle;	
			SystemSetting::where('setting_key', 'old_cycle_edited_id')->update([
				'setting_value'=>"$editedCycle_id"
			]);
		} 
		//get rotate settings
		$cycle = FinancialCycle::where('id', $editedCycle_id)->first();
		$rotate_settings = array(
			'rotate_date'=>$cycle->rotate_date,
			'item_cost_type'=>$cycle->item_cost_type,
			'profits_account'=>$cycle->profits_account_id,
			'diff_ex_rate_account'=>$cycle->diff_ex_rate_account_id,
			'last_inventories_items_value_account'=>$cycle->last_inventories_items_value_account_id,
		);

		$currencies_ex_rate_arr = explode(',', $cycle->currencies_ex_rate);
		foreach($currencies_ex_rate_arr as $val){
			$ex_rate = explode('|', $val);
			$rotate_settings["".$ex_rate[0]] = $ex_rate[1]; 
		} 

		Session::put('rotate_setting', $rotate_settings);
		//dd($rotate_settings);
		$ReCalfunc = new ReCalculateCycleDataFunctionsController();
		//حساب الارصدة الافتتاحية للسنة مالية معينة
		$res = $ReCalfunc->calculate_opening_balances_for_cycle($cycle->id);
		$accounts_info = $res['accounts_info'];
		Session::put('new_initial_balances', $accounts_info);

		$activeCurrencies = $ReCalfunc->getActiveCurrencies();
		$final_balances = array();
		$final_balances['final_equalizer']=$res['final_equalizer'];
		foreach ($activeCurrencies as $curr) {
			$final_balances['final_balance_' . $curr->id] = $res['final_balance_' . $curr->id];
		}
		//dd($res);
		//حساب بضاعة أول المدة لسنة مالية معينة
		$inventories_data = $ReCalfunc->getItemsAmountInAllInventories_for_cycle($cycle->id);
		Session::put('new_beginning_items', $inventories_data);
		//dd($inventories_data);

		//حساب الأرباح والخسائر
		Session::put('rotate_bals_all_values', $final_balances);
		$profits_and_loss = (object)$ReCalfunc->calculateProfitsAndLoss_for_cycle($cycle->id);
		Session::put('new_entries_list', $profits_and_loss);

		//add values of  net_profit,ex_rate_difference_value,last_inventories_items_value to final balances array
		$majorCurr = $ReCalfunc->getMajorCurrency();
		$final_balances['final_balance_with_rotate_accounts'] = $final_balances['final_balance_' . $majorCurr->id] + ($profits_and_loss->net_profit + $profits_and_loss->last_inventories_items_value + $profits_and_loss->ex_rate_difference_value); 
		//dd($final_balances);
		$next_rotate_date = date('Y-m-d', strtotime('+1 day', strtotime($rotate_settings['rotate_date'])));
		//dd($profits_and_loss);
		return view("financial_cycles.re_calculate_data_result", array("data" => $accounts_info, 'next_rotate_date'=>$next_rotate_date,"inventories_data" => $inventories_data,
			'profits_and_loss' => $profits_and_loss,
			'final_balances' => $final_balances, 'activeCurrencies' => $activeCurrencies,'majorCurrency'=>$majorCurr,
			'cycle_id'=>$cycle->id,'cycle_name'=>$cycle->cycle_name,'options'=>$options_arr
		));

	}

	public function saveReCalculateDataResult($options)
	{
		//save in recalculate cycle history 
		$curr_cycle_id = FinancialCycle::where('status', 'current')->first()->id;
		$editedCycle_id = SystemSetting::where('setting_key','old_cycle_edited_id')->first()->setting_value;
		ReCalculateCycleHistory::insert([
			'cycle_id'=>$editedCycle_id,
			'action'=>'re-calculate-data',
			'options'=>"$options",
			'upgrade_cycle_id'=>$curr_cycle_id,
		]);

		//do reCalculate data
		$options_arr = explode(',', $options);
		$ReCalfunc = new ReCalculateCycleDataFunctionsController();
		$ReCalfunc->saveRe_Calculate_Data_Result($options_arr);

		return json_encode(array('status'=>'success','message'=>trans('messages.success_message')));
	}
	public function IgnoreReCalculateData(){
		$curr_cycle_id = FinancialCycle::where('status', 'current')->first()->id;
		$editedCycle_id = SystemSetting::where('setting_key','old_cycle_edited_id')->first()->setting_value;
		ReCalculateCycleHistory::insert([
			'cycle_id'=>$editedCycle_id,
			'action'=>'ignore',
			'options'=>'',
			'upgrade_cycle_id'=>$curr_cycle_id,
		]);

		SystemSetting::where('setting_key', 'old_cycle_edited')->update([
			'setting_value'=>'false'
		]);
		SystemSetting::where('setting_key', 'old_cycle_edited_id')->update([
			'setting_value'=>''
		]);
		
		return json_encode(array('status'=>'success','message'=>trans('messages.success_message')));
	}

	
	
}