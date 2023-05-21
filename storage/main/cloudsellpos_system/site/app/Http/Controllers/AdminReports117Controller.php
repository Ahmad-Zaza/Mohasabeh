<?php

namespace App\Http\Controllers;

use crocodicstudio_voila\crudbooster\helpers\CRUDBooster as HelpersCRUDBooster;
use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;
class AdminReports117Controller extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

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
		$this->alert        = array();



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
		//query from db to get information

		$closing_account_type =$request->input('closing_account_type');
		if($closing_account_type == null){
			$closing_account_type = 1;
		}
	
		$closing_types= DB::table('closing_accounts_types')->where('active','1')->get();
		
		$res = DB::table('closing_accounts_types')->find($closing_account_type);
		$closing_account_type_name = $res->name_ar;

		$gfunc= new GeneralFunctionsController();
		$accountsIDs = $gfunc->getAccountsIDsListInClosingAccountType($closing_account_type);
        $childernBalances = array();
        $result = $gfunc->getClosingAccountTypeBalanceAsArray($closing_account_type,$accountsIDs,$childernBalances);
		//dd($result);
		$accounts_info=collect($result);
		$activeCurrencies = $gfunc->getActiveCurrencies();
		$final_balances = array();
		foreach($activeCurrencies as $curr){
			$final_balances['curr_balance_'.$curr->id] = 0;
		}
		foreach($accounts_info as $account){
			foreach($activeCurrencies as $curr){
				$final_balances['curr_balance_'.$curr->id] += $account['curr_balance_'.$curr->id];
			}
		}

		//dd($accounts_info);
		Session::put('closing_accounts_report',$accounts_info);

		return view("report.closing_accounts", array("data" => $accounts_info,"closing_types" => $closing_types,
		"closing_account_type"=>$closing_account_type,"closing_account_type_name"=>$closing_account_type_name,
		'final_balances'=>$final_balances,'activeCurrencies'=>$activeCurrencies
		));
	}

	//By the way, you can still create your own method in here... :)
	//export to excel file xls
	public function export($filter){
		//get report from session
		$report = Session::get('closing_accounts_report');
		$json  = json_encode($report);
		$data = json_decode($json, true);
		$rows_count = count($data) + 3;
		if($data==null){
		    return "No Data, Please using filter to show your data and press export aging.";
		}
		//dd($data);
			$new_data = array();

			$gfunc= new GeneralFunctionsController();
			$activeCurrencies = $gfunc->getActiveCurrencies();
			$final_balances = array();
			foreach($activeCurrencies as $curr){
				$final_balances['curr_balance_'.$curr->id] = 0;
			}

			foreach($data as $arr){
				$sp_balance= $arr['sp_balance']!=null?$arr['sp_balance']:'0';
				$dollar_balance=$arr['dollar_balance']!=null?$arr['dollar_balance']:'0';
				$euro_balance=$arr['euro_balance']!=null?$arr['euro_balance']:'0';
				$temp = array(
					"account_name"=>$arr['account_name']
				);
				foreach($activeCurrencies as $curr){
					$temp['curr_balance_'.$curr->id] = $arr['curr_balance_'.$curr->id]!=null?$arr['curr_balance_'.$curr->id]:'0';
					$final_balances['curr_balance_'.$curr->id] += $temp['curr_balance_'.$curr->id];
				}

				array_push($new_data,$temp);
			}

			$heading = array(
				"account_name"=>"الحساب"
			);
			$empty_row = array(
				''
			);
			$result =  array(
				"account_name"=>'إجمالي الرصيد'
				);

			foreach($activeCurrencies as $curr){
				$heading['curr_balance_'.$curr->id] = "رصيد ".$curr->name_ar;
				array_push($empty_row,'');
				$result['curr_balance_'.$curr->id] = $final_balances['curr_balance_'.$curr->id]!=null?$final_balances['curr_balance_'.$curr->id]:'0';
			}

			array_push($new_data,$result);
			
			
			$data= $new_data;

			

		
		Excel::create('export_closing_accounts_'.date('Y-m-d H:i:s',time()), function($excel) use ($data,$heading,$empty_row,$rows_count) {

			// Set the title
			$excel->setTitle('Export To Excel');
		
			// Chain the setters
			$excel->setCreator('Voila')
				->setCompany('Voila');
		
			// Call them separately
			$excel->setDescription('Accounting System');

			$excel->getDefaultStyle()
				->getAlignment()
				->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$excel->sheet('Result', function($sheet) use ($data,$heading,$empty_row,$rows_count) {
				$sheet->setOrientation('landscape');
				$sheet->setPageMargin(0.25);
				
				$sheet->fromArray($data);
				// Add before first row
				$sheet->prependRow(1, $heading);
				$sheet->row(1, function($row) {
					// call cell manipulation methods
					$row->setBackground('#cccccc');
				});
				$sheet->row($rows_count, function($row) {
					// style last row
					$row->setBackground('#cccccc');
				});
				$sheet->appendRow(2, $empty_row);

				$sheet->freezeFirstRow();
				// Set auto size for sheet
				$sheet->setAutoSize(true);
			});
		
		})->export('xls');
		
	}

}
