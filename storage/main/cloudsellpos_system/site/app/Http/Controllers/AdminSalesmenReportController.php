<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;

class AdminSalesmenReportController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "sorting,asc";
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
		$this->table = "bills";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "الرمز", "name" => "code"];
		$this->col[] = ["label" => "مدين", "name" => "debit"];
		$this->col[] = ["label" => "دائن", "name" => "credit"];
		$this->col[] = ["label" => "التاريخ", "name" => "date"];
		$this->col[] = ["label" => "نوع الفاتورة", "name" => "bill_type_id", "join" => "bill_type,name_en"];
		$this->col[] = ["label" => "Inventory Id", "name" => "inventory_id", "join" => "inventories,id"];
		$this->col[] = ["label" => "Currency Id", "name" => "currency_id", "join" => "currencies,id"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Code', 'name' => 'code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Debit', 'name' => 'debit', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Credit', 'name' => 'credit', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Date', 'name' => 'date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Bill Type Id', 'name' => 'bill_type_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'bill_type,name_en'];
		$this->form[] = ['label' => 'Inventory Id', 'name' => 'inventory_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'inventory,id'];
		$this->form[] = ['label' => 'Currency Id', 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'currency,id'];
		$this->form[] = ['label' => 'Staff Id', 'name' => 'staff_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'staff,id'];
		$this->form[] = ['label' => 'Note', 'name' => 'note', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Is Cash', 'name' => 'is_cash', 'type' => 'radio', 'validation' => 'required|integer', 'width' => 'col-sm-10', 'dataenum' => 'Array'];
		$this->form[] = ['label' => 'Bill Number', 'name' => 'bill_number', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Amount', 'name' => 'amount', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Active', 'name' => 'active', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Sorting', 'name' => 'sorting', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'P Code', 'name' => 'p_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Delegate Id', 'name' => 'delegate_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'delegate,id'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ['label'=>'Code','name'=>'code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Debit','name'=>'debit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Credit','name'=>'credit','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Date','name'=>'date','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Bill Type Id','name'=>'bill_type_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bill_type,name_en'];
		//$this->form[] = ['label'=>'Inventory Id','name'=>'inventory_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'inventory,id'];
		//$this->form[] = ['label'=>'Currency Id','name'=>'currency_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'currency,id'];
		//$this->form[] = ['label'=>'Staff Id','name'=>'staff_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'staff,id'];
		//$this->form[] = ['label'=>'Note','name'=>'note','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Is Cash','name'=>'is_cash','type'=>'radio','validation'=>'required|integer','width'=>'col-sm-10','dataenum'=>'Array'];
		//$this->form[] = ['label'=>'Bill Number','name'=>'bill_number','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Amount','name'=>'amount','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Active','name'=>'active','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Sorting','name'=>'sorting','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'P Code','name'=>'p_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Delegate Id','name'=>'delegate_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'delegate,id'];
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
		$this->script_js = "$('#delegate_id').change(function(){
		       debugger
		       	var id = $(this).val();

		        document.getElementById('account_id').options.length = 0;
		        $.post('/reports/getCustomers/'+id,function(res){
		         res.forEach(element => {
                 $('#account_id').append(new Option(element.name_ar+' - '+element.code, element.account_id));

                     });
		        })
		        })
		";


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


	public function getIndex()
	{
		$request = $_REQUEST;

		if (!CRUDBooster::isView()) CRUDBooster::denyAccess();


		$delegates = DB::table('cms_users')->where('id_cms_privileges', 4)->get();

		$items = DB::table('items')->get();
		$customers = DB::table('persons')->where('person_type_id', 1)->select('account_id', 'name_ar')->get();
		$currencies = DB::table("currencies")->get();

		$query = DB::table("bills")->select(
			'bills.date as billDate',
			'bills.amount as billAmount',
			'bills.note as billNote',
			'bills.is_cash',
			'bills.p_code as billCode',
			'bills.id as billId',
			'bills.bill_type_id as type',
			'p1.name_ar as personName',
			'p2.name_ar as personName1',
			'bills.currency_id as currency_id',
			'bills.equalizer as equalizer'

		)
			->leftjoin("persons as p1", "p1.account_id", "bills.debit")
			->leftjoin("persons as p2", "p2.account_id", "bills.credit")
			->join("bill_item", "bill_item.bill_id", "bills.id")
			->where('bills.delete_by', 0)
			->where('bills.rotate_year', NULL);

		$delegate_name = '';
		if ($request->input('delegate_id') != -1 && $request->input('delegate_id') != null) {

			$res = DB::table('cms_users')->find($request->input('delegate_id'));
			$delegate_name = $res->name;

			$query->where('bills.delegate_id', $request->delegate_id);
			if ($request->input('item_id') != -1 && $request->input('item_id') != null) {

				$query->where('bill_item.item_id', $request->item_id);
				//                    $data = $query->orderBy('bills.date')->get();

			}

			if ($request->input('from_date') != null && $request->input('to_date') == null) {
				$query->where('bills.date', '>=', $request->from_date);
			}
			if ($request->input('from_date') == null && $request->input('to_date') != null) {
				$query->where('bills.date', '<=', $request->to_date);
			}
			if ($request->input('from_date') != null && $request->input('to_date') != null) {
				$query->whereBetween('bills.date', [$request->from_date, $request->to_date]);
			}

			if ($request->input('account_id') != -1 && $request->input('account_id') != null) {
				$query->Where(function ($query1) use ($request) {
					$query1->where('bills.credit', $request->input('account_id'))->orwhere('bills.debit', $request->input('account_id'));
				});
			}


			if ($request->input('currency_id') != -1 && $request->input('currency_id') != null) {
				$query->where('bills.currency_id', $request->input('currency_id'));
			}


			$data = $query->orderBy('bills.date')->distinct()->get();
		}
		//dd($data);
		Session::put('salesmen_report', $data);
		Session::put('salesmen_report_delegate_name', $delegate_name);

		//        dd($request->input('from_date'));
		return view("report.salesmen", array(
			"data" => $data, "delegates" => $delegates,
			"delegate_id" => $request->input('delegate_id'), 'delegate_name' => $delegate_name, "items" => $items,
			"item_id" => $request->input('item_id'), 'from_date' => $request->input('from_date'),
			'to_date' => $request->input('to_date'), 'customers' => $customers, 'account_id' => $request->input('account_id'),
			"currencies" => $currencies, "currency_id" => $request->input('currency_id')
		));
	}

	//By the way, you can still create your own method in here... :)
	public function getCustomers($id)
	{
		//get customers delegate_id is $id and has bills
		$sql = "select DISTINCT(persons.account_id), persons.name_ar from persons , bills
					where (persons.account_id = bills.credit or persons.account_id = bills.debit) and persons.person_type_id = 1
					and bills.delete_by = 0 and bills.rotate_year is NULL
					and persons.delegate_id =$id";
		$customers = DB::select($sql);
		return $customers;
	}

	public function getDelegates($id)
	{
		//            $user = DB::table('perso')
		$customer = DB::table('persons')->where('person_type_id', 1)->where('account_id', $id)->first();

		$delegate  = DB::table('cms_users')->where('id', $customer->delegate_id)->get();
		return $delegate;
	}


	public function getCurrenciesDealing($id)
	{
		$bills   = DB::table('bills')->select('currency_id')->where('bills.credit', $id)->orwhere('bills.debit', $id)
			->distinct('currency_id')->get();

		$currencies = [];
		foreach ($bills as $bill) {
			array_push($currencies, $bill->currency_id);
		}

		$currenciesToSend = DB::table('currencies')->whereIn('id', $currencies)->get;

		return $currenciesToSend;
	}

	//export to excel file xls
	public function export($filter)
	{
		//get report from session
		$report = Session::get('salesmen_report');
		$json  = json_encode($report);
		$data = json_decode($json, true);
		$bills_number = count($data);
		$rows_count = count($data);

		$delegate_name = Session::get('salesmen_report_delegate_name');

		if ($data == null) {
			return "No Data, Please using filter to show your data and press export aging.";
		}
		//dd($data);
		$new_data = array();
		$totalval = 0;

		foreach ($data as $arr) {
			$subTotal = 0;
			$equalizer = $arr['equalizer'] != null ? $arr['equalizer'] : '0';
			$personName = '';
			if ($arr['type'] == 2) {
				$personName = $arr['personName'];
				if ($arr['currency_id'] != 1) {
					$subTotal = $equalizer;
				} else {
					$subTotal =  $arr['billAmount'];
				}
				$totalval += $subTotal;
			} elseif ($arr['type'] == 4) {
				$personName = $arr['personName1'];
				$subTotal = -$arr['billAmount'];
				$totalval = $totalval - $arr['billAmount'];
			}

			$currency_name = 'ل.س';
			if ($arr['currency_id'] == 2) {
				$currency_name = 'دولار';
			} else if ($arr['currency_id'] == 3) {
				$currency_name = 'يورو';
			}


			$temp = array(
				"delegate" => $delegate_name,
				"billDate" => $arr['billDate'],
				"billCode" => $arr['billCode'],
				"billNote" => $arr['billNote'],
				"is_cash" => $arr['is_cash'] == 1 ? 'نقدي' : 'أجل',
				"personName" => $personName,
				"billAmount" => $subTotal,
				"currency_id" => $currency_name
			);

			array_push($new_data, $temp);
		}
		$result =  array();
		array_push($new_data, $result);
		$result =  array(
			"tilte" => 'عدد الفواتير',
			"count" => $bills_number
		);
		array_push($new_data, $result);
		$result =  array(
			"tilte" => 'مجموع قيم الفواتير',
			"total" => $totalval != null ? $totalval : '0'
		);
		array_push($new_data, $result);

		$data = $new_data;

		Excel::create('export_salesmen_report_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data, $rows_count) {

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

			$excel->sheet('Result', function ($sheet) use ($data, $rows_count) {
				$sheet->setOrientation('landscape');
				$sheet->setPageMargin(0.25);

				$sheet->fromArray($data);
				// Add before first row
				$sheet->prependRow(1, array(
					"delegate" => "المندوب",
					"billDate" => "التاريخ",
					"billCode" => "الرمز",
					"billNote" => "ملاحظات",
					"is_cash" => "نوع العملية",
					"personName" => "الزبون",
					"billAmount" => "المجموع",
					"currency_id" => "العملة",
				));
				$sheet->row(1, function ($row) {
					// call cell manipulation methods
					$row->setBackground('#cccccc');
				});
				$sheet->row($rows_count + 4, function ($row) {
					// style last row
					$row->setBackground('#cccccc');
				});
				$sheet->row($rows_count + 5, function ($row) {
					// style last row
					$row->setBackground('#cccccc');
				});
				$sheet->appendRow(2, array(
					'', '', '', '', '', '', '', ''
				));

				$sheet->freezeFirstRow();
				// Set auto size for sheet
				$sheet->setAutoSize(true);
			});
		})->export('xls');
	}
}
