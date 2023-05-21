<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use CRUDBooster;
use App\Account;
use crocodicstudio_voila\crudbooster\helpers\CRUDBooster as HelpersCRUDBooster;
use App\Traits\GeneralTrait;

class AdminInitialVoucherController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "vouchers";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "الرمز", "name" => "p_code"];
		$this->col[] = ["label" => "التاريخ", "name" => "date"];
		$this->col[] = ["label" => "التاريخ", "name" => "credit", "visible" => false];
		$this->col[] = ["label" => "نوع السند", "name" => "voucher_type_id", "join" => "voucher_types,name_ar"];
		$this->col[] = ["label" => "الحساب", "name" => "debit", "callback_php" => '$row->debit!==0?$this->getAccountName($row->debit):$this->getAccountName($row->credit)'];
		//$this->col[] = ["label"=>"الحساب","name"=>"credit"];
		$this->col[] = ["label" => "البيان", "name" => "narration"];
		$this->col[] = ["label" => "العملة", "name" => "currency_id", "join" => "currencies,name_ar"];
		$this->col[] = ["label" => "القيمة", "name" => "amount", "callback_php" => '$row->debit!==0?$row->amount:$row->amount*-1'];
		$this->col[] = ["label" => "الموظف", "name" => "staff_id", "join" => "cms_users,name"];
		//$this->col[] = ["label" => "active", "name" => "active"];
		# END COLUMNS DO NOT REMOVE THIS LINE
        
		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		
		if(CRUDBooster::getCurrentMethod() == 'getDetail') {
			$this->form[] = ['label' => 'الحساب', 'name' => 'debit', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $this->getPersons()) . ')'];
			$this->form[] = ['label' => 'الحساب', 'name' => 'credit', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $this->getPersons()) . ')'];
		}else{
			$this->form[] = ['label' => 'الحساب', 'name' => 'account', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $this->getPersons()) . ')'];
		}
		
		$this->form[] = ['label' => 'البيان', 'name' => 'narration', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'التاريخ', 'name' => 'date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'العملة', 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'currencies,name_ar'];
		$this->form[] = ['label' => 'القيمة', 'name' => 'amount', 'type' => 'number', 'validation' => 'required', 'width' => 'col-sm-10'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ["label"=>"Code","name"=>"code","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"P Code","name"=>"p_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Voucher Type Id","name"=>"voucher_type_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"voucher_type,id"];
		//$this->form[] = ["label"=>"Debit","name"=>"debit","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Credit","name"=>"credit","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Delegate Id","name"=>"delegate_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"delegate,id"];
		//$this->form[] = ["label"=>"Staff Id","name"=>"staff_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"staff,id"];
		//$this->form[] = ["label"=>"Narration","name"=>"narration","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Date","name"=>"date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
		//$this->form[] = ["label"=>"Currency Id","name"=>"currency_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"currency,id"];
		//$this->form[] = ["label"=>"Amount","name"=>"amount","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Ex Rate","name"=>"ex_rate","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Equalizer","name"=>"equalizer","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Opposite","name"=>"opposite","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Active","name"=>"active","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Sorting","name"=>"sorting","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		# OLD END FORM

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
		$vouchers_count=DB::table("vouchers")->count();
		if($vouchers_count == 0){
			$this->index_button[] = ['label'=>'استيراد البيانات','url'=>CRUDBooster::mainpath("import-data-form"),"icon"=>"fa fa-download"];
		}
		


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
	        | FESAL VOILA DONT REMOVE THIS LINE
	        | ----------------------------------------------------------------------
            | IF NOT SUCCESS ADD  $this->col[] = ["label"=>"Active","name"=>"active"]; IN COLUMNS
            |
            */

		$this->table_row_color[] = ["condition" => "[active]==1", "color" => "success"];
		$this->table_row_color[] = ["condition" => "[active]==0", "color" => "danger"];


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
		$this->script_js = "
			$(document).ready(function(){
			
			});";


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
		$me = DB::table('cms_users')->find(CRUDBooster::myId());
		if ($me->id_cms_privileges == 4) {
			$query->where('delegate_id', $me->id);
		}
		$query->where("voucher_type_id", 4);
		$query->where("delete_by", 0);
		$query->where("rotate_year", NULL);
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
		if($column_index == 7){
			$column_value = number_format($column_value,2);
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
		
		$max = DB::table('vouchers')->where("voucher_type_id", 4)->where('delete_by',0)->where('rotate_year',NULL)->max('code');
		$prefixCode = DB::table('voucher_types')->where('id', 4)->select('prefix')->first();

		$postdata["code"] = ($max) ? $max + 1 : 1;
		$postdata['p_code'] = $prefixCode->prefix . '' . $postdata['code'];

		//check if p_code unique
		$this->checkVoucherP_Code($postdata['p_code']);
		
		$postdata['voucher_type_id'] = 4;

		$postdata["staff_id"] = CRUDBooster::myId();

		if ($postdata["amount"] < 0) {
			$postdata["credit"] = $postdata["account"];
		} else {
			$postdata["debit"] = $postdata["account"];
		}

		$postdata["amount"] = abs($postdata["amount"]);

		$ex_rate = DB::table('currencies')->where('id',$postdata["currency_id"])->first()->ex_rate;
		$postdata["ex_rate"] =$ex_rate;
		$postdata["equalizer"] = $postdata["amount"] * $ex_rate;

		unset($postdata["account"]);

		$postdata['create_by']=CRUDBooster::myId();
		//dd($postdata);
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
		DB::beginTransaction();
		try {
			DB::table('files_vouchers')->where('file_id', null)->delete();

			$voucher = DB::table('vouchers')->find($id);
			$max = DB::table('entry_base')->where('delete_by',0)->where('rotate_year',NULL)->max('entry_number');
			$entry_number = $max + 1;

			$entry_base_id = DB::table("entry_base")->insertGetId([
				'entry_number' => $entry_number,
				'narration' => $voucher->narration,
				'date' => $voucher->date,
				'voucher_id' => $id,
				'active' => 1,
				'create_by'=> CRUDBooster::myId()

			]);

			if ($voucher->debit == 0) {

				$entry = DB::table("entries")->insert([
					'entry_base_id' => $entry_base_id,
					'debit' => null,
					'account_id' => $voucher->credit,
					'credit' => $voucher->amount,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $voucher->equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'create_by'=> CRUDBooster::myId()
				]);
			} else {
				$entry = DB::table("entries")->insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $voucher->amount,
					'account_id' => $voucher->debit,
					'credit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $voucher->equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'create_by'=> CRUDBooster::myId()
				]);
			}


			DB::commit();
		} catch (\Exception $e) {
			// Rollback Transaction
			DB::rollback();
		}
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
		$voucher_id = DB::table('vouchers')->find($id);

		$postdata["staff_id"] = CRUDBooster::myId();

		if ($postdata["amount"] < 0) {
			$postdata["credit"] = $postdata["account"];
		} else {
			$postdata["debit"] = $postdata["account"];
		}

		$postdata["amount"] = abs($postdata["amount"]);

		$ex_rate = DB::table('currencies')->where('id',$postdata["currency_id"])->first()->ex_rate;
		$postdata["ex_rate"] =$ex_rate;
		$postdata["equalizer"] = $postdata["amount"] * $ex_rate;

		unset($postdata["account"]);

		//create new Voucher with another id and save old data to new record with delete_by delete_at
        //change forgin key in others tables voucher_id to new copy of Voucher with delete_by delete_at
		$this->makeVoucherAsDeleted($id);

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
		DB::beginTransaction();
		try {
			
			$voucher = DB::table('vouchers')->find($id);
			$max = DB::table('entry_base')->max('entry_number');
			$entry_number = $max + 1;

			$entry_base_id = DB::table("entry_base")->insertGetId([
				'entry_number' => $entry_number,
				'narration' => $voucher->narration,
				'date' => $voucher->date,
				'voucher_id' => $id,
				'active' => 1,
                'create_by'=> CRUDBooster::myId()

			]);

			if ($voucher->debit == 0) {

				$entry = DB::table("entries")->insert([
					'entry_base_id' => $entry_base_id,
					'debit' => null,
					'account_id' => $voucher->credit,
					'credit' => $voucher->amount,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $voucher->equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'create_by'=> CRUDBooster::myId()
				]);
			} else {
				$entry = DB::table("entries")->insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $voucher->amount,
					'account_id' => $voucher->debit,
					'credit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $voucher->equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'create_by'=> CRUDBooster::myId()
				]);
			}


			DB::commit();
		} catch (\Exception $e) {
			// Rollback Transaction
			DB::rollback();
		}

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
		$this->deleteVoucher($id);

		return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "تم حذف السند بنجاح.", "success");
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

	public function getAccountName($accountId)
	{
		return Account::where("id", $accountId)->first()->name_ar;
	}

	public function getPersons()
	{

		$accountsIds = [];
		$accountsarr = [];

		$id = CRUDBooster::myId();

		$me = DB::table('cms_users')->find($id);

		if ($me->id_cms_privileges == 4) {
			$accounts = DB::table('persons')->where('delegate_id', '!=', $me->id)->select('account_id')->get();

			foreach ($accounts as $account) {
				array_push($accountsarr, $account->account_id);
			}

			$persons = DB::table('accounts')->select('id')->whereNotIn('id', $accountsarr)->where('major_classification', 0)->get();
		} else {
			$persons = DB::table('accounts')->select('id')->where('major_classification', 0)->get();
		}

		foreach ($persons as $person) {
			array_push($accountsIds, $person->id);
		}
		return $accountsIds;
	}

	public function getEdit($id)
	{

		$vouchers = DB::table('vouchers')->where('id', $id)->first();
		if ($vouchers->debit == 0) {
			$vouchers->amount *= -1;
			$vouchers->account = $vouchers->credit;
		}else{
			$vouchers->amount *= 1;
			$vouchers->account = $vouchers->debit;
		}
		
		$data = [];
		$data['page_title'] = 'Edit InitialVoucher';
		$data['row'] = $vouchers;

		$this->cbView('crudbooster::default.form', $data);
	}

	//By the way, you can still create your own method in here... :)

	public function importDataForm(){
			$example_file= 'الأرصدة الافتتاحية.xlsx';
			$example_file= 'examples/'.$example_file;

			return view('data.import',compact('example_file'));
		}
	
		public function getDataFromExcel(Request $request)
		{
			//dd($request);
			
			$this->cbLoader();
			
			if (Request::hasFile('userfile')) {
				$importCtrl= new ImportController();
				$url_filename =  $importCtrl -> uploadExcelDatafile($request);
				$result = $importCtrl->importDataforModule($url_filename);
				if($result['import_status'] == 'success'){
					return redirect()->back()->with([
						'import_status'=>'success',
						'reports'=>$result['reports'],
					]);
				}else{
					return redirect()->back()->with([
						'import_status'=>'failed',
						'reports'=>$result['reports'],
					]);
				}
			} else {
				return redirect()->back()->with([
					'import_status'=>'failed',
					'reports'=>array("لم يتم رفع الملف بنجاح حاول مرة أخرى"),
				]);
			}
		
		}

}