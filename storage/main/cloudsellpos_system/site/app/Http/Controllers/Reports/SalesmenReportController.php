<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Reports;

use DB;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Bills\Bill;
use App\Models\Bills\BillType;
use App\Models\Currencies\Currency;
use App\Models\Entries\EntryBase;
use App\Models\Vouchers\VoucherType;
use App\Models\Accounts\Customer;
use Session;

class SalesmenReportController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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
		$this->col[] = ["label" => trans('modules.code'), "name" => "code"];
		$this->col[] = ["label" => trans('modules.debit'), "name" => "debit"];
		$this->col[] = ["label" => trans('modules.credit'), "name" => "credit"];
		$this->col[] = ["label" => trans('modules.date'), "name" => "date"];
		$this->col[] = ["label" => trans('modules.bill_type'), "name" => "bill_type_id", "join" => "bill_types,name_en"];
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
		$this->script_js = "";


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


	public function getIndex(\Illuminate\Http\Request $request)
	{

		if (!CRUDBooster::isView())
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.you_dont_have_access_permission'), "warning");

		//===================================================================
		$delegates = User::whereIn('id_cms_privileges', explode(',',config('setting.DELEGATES_ROLES_IDS')))->get();
		$customers = Customer::select('account_id', 'name_ar')->get();
		$currencies = Currency::get();

		$conditions = array(['entry_base.action', '=', NULL],['entry_base.cycle_id', '=',  Session::get('display_cycle')]);

		//new Query

		$query = EntryBase::select(
			'entry_base.date as date',
			'entry_base.narration as narration',
			'bills.id as bill_id',
			'bills.bill_type_id as bill_type_id',
			'bills.currency_id as bill_currency_id',
			'bills.debit as bill_debit',
			'bills.credit as bill_credit',
			'bills.staff_id as bill_staff_id',
			'bills.is_cash as bill_is_cash',
			'bills.bill_number as bill_number',
			'vouchers.id as voucher_id',
			'vouchers.voucher_type_id as voucher_type_id',
			'vouchers.currency_id as voucher_currency_id',
			'vouchers.debit as voucher_debit',
			'vouchers.credit as voucher_credit',
			'vouchers.staff_id as voucher_staff_id',
			'vouchers.voucher_number as voucher_number'

		)
			//->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("bills", function ($join) { 
				$join->on('bills.id', '=', 'entry_base.bill_id');
				$join->on('bills.status', DB::raw("'1'"));//just active bills
			})
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->where($conditions)
			->orderby('entry_base.date', 'desc')->orderby('entry_base.id');


		$delegate_name = '';
		if ($request->input('delegate_id') != -1 && $request->input('delegate_id') != null) {

			$res = User::find($request->input('delegate_id'));
			$delegate_name = $res->name;

			$query->where(function ($query) use ($request) {
				$query->where('bills.delegate_id', '=', $request->delegate_id)
					->orWhere('vouchers.delegate_id', '=', $request->delegate_id);

			});


			if ($request->input('from_date') != null && $request->input('to_date') == null) {
				$query->where('entry_base.date', '>=', $request->from_date);
			}
			if ($request->input('from_date') == null && $request->input('to_date') != null) {
				$query->where('entry_base.date', '<=', $request->to_date." 23:59:59");
			}
			if ($request->input('from_date') != null && $request->input('to_date') != null) {
				$query->whereBetween('entry_base.date', [$request->from_date, $request->to_date." 23:59:59"]);
			}


			$query->orderBy('entry_base.date')->distinct();
			$data = $query->paginate(config('setting.PAGINATIOM_LIMITATION'));

			$data->each(function ($item) {
				if ($item->bill_id != null) {
					$item->id = $item->bill_id;
					$item->number = ($item->bill_number != null) ? $item->bill_number : '';
					$item->type_id = $item->bill_type_id;
					$item->type_name = BillType::find($item->bill_type_id)->name_ar;
					$item->currency_id = $item->bill_currency_id;
					$item->currency_name = Currency::find($item->bill_currency_id)->name_ar;
					$item->debit = $item->bill_debit;
					$item->debit_name = Account::find($item->bill_debit)->name_ar;
					$item->credit = $item->bill_credit;
					$item->credit_name = Account::find($item->bill_credit)->name_ar;
					$item->staff_id = $item->bill_staff_id;
					$item->staff_name = User::find($item->staff_id)->name;
					if ($item->bill_is_cash == 1) {
						$item->is_cash = trans('modules.cash');
					}
					else {
						$item->is_cash = trans('modules.post');
					}

					if ($item->type_id == 2 || $item->type_id == 3) {
						$item->customer_name = $item->debit_name;
					}
					else {
						$item->customer_name = $item->credit_name;
					}
					$item->is_bill = 'yes';
				}
				else {

					$item->id = $item->voucher_id;
					$item->number = ($item->voucher_number != null) ? $item->voucher_number : '';
					$item->type_id = $item->voucher_type_id;
					$item->type_name = VoucherType::find($item->voucher_type_id)->name_ar;
					$item->currency_id = $item->voucher_currency_id;
					$item->currency_name = Currency::find($item->voucher_currency_id)->name_ar;
					$item->debit = $item->voucher_debit;
					$item->debit_name = Account::find($item->voucher_debit)->name_ar;
					$item->credit = $item->voucher_credit;
					$item->credit_name = Account::find($item->voucher_credit)->name_ar;
					$item->staff_id = $item->voucher_staff_id;
					$item->staff_name = User::find($item->voucher_staff_id)->name;
					$item->is_cash = '';
					if ($item->type_id == 2 || $item->type_id == 3 || $item->type_id == 5) {
						$item->customer_name = $item->debit_name;
					}
					else {
						$item->customer_name = $item->credit_name;
					}
					$item->is_bill = 'no';
				}
			});

		}

		return view("report.salesmen", array("data" => $data, "delegates" => $delegates,
			"delegate_id" => $request->input('delegate_id'), 'delegate_name' => $delegate_name,
			'from_date' => $request->input('from_date'), 'to_date' => $request->input('to_date'),
			'customers' => $customers, 'account_id' => $request->input('account_id'),
			"currencies" => $currencies, "currency_id" => $request->input('currency_id')));


	}

	//By the way, you can still create your own method in here... :)

	//export to excel file xls
	public function export($filter)
	{
		//get report from session
		$filter = json_decode($filter);
		$filter = collect($filter);
		$request = array();
		$filter->each(function ($f) use (&$request) {
			$request["$f->name"] = $f->value;
		});
		//build query here
		$conditions = array(['entry_base.action', '=', NULL],['entry_base.cycle_id', '=',  Session::get('display_cycle')]);

		//new Query

		$query = EntryBase::select(
			'entry_base.date as date',
			'entry_base.narration as narration',
			'bills.id as bill_id',
			'bills.bill_type_id as bill_type_id',
			'bills.currency_id as bill_currency_id',
			'bills.debit as bill_debit',
			'bills.credit as bill_credit',
			'bills.staff_id as bill_staff_id',
			'bills.is_cash as bill_is_cash',
			'bills.bill_number as bill_number',
			'vouchers.id as voucher_id',
			'vouchers.voucher_type_id as voucher_type_id',
			'vouchers.currency_id as voucher_currency_id',
			'vouchers.debit as voucher_debit',
			'vouchers.credit as voucher_credit',
			'vouchers.staff_id as voucher_staff_id',
			'vouchers.voucher_number as voucher_number'
		)
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->where($conditions)
			->orderby('entry_base.date', 'desc')->orderby('entry_base.id');


		$delegate_name = '';
		if ($request['delegate_id'] != -1 && $request['delegate_id'] != null) {

			$res = User::find($request['delegate_id']);
			$delegate_name = $res->name;

			$query->where(function ($query) use ($request) {
				$query->where('bills.delegate_id', '=', $request['delegate_id'])
					->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);

			});


			if ($request['from_date'] != null && $request['to_date'] == null) {
				$query->where('entry_base.date', '>=', $request['from_date']);
			}
			if ($request['from_date'] == null && $request['to_date'] != null) {
				$query->where('entry_base.date', '<=', $request['to_date']." 23:59:59");
			}
			if ($request['from_date'] != null && $request['to_date'] != null) {
				$query->whereBetween('entry_base.date', [$request['from_date'], $request['to_date']." 23:59:59"]);
			}

			$query->orderBy('entry_base.date')->distinct();
			$data = $query->get();

			$data->each(function ($item) {
				if ($item->bill_id != null) {
					$item->id = $item->bill_id;
					$item->number = ($item->bill_number != null) ? $item->bill_number : '';
					$item->type_id = $item->bill_type_id;
					$item->type_name = BillType::find($item->bill_type_id)->name_ar;
					$item->currency_id = $item->bill_currency_id;
					$item->currency_name = Currency::find($item->bill_currency_id)->name_ar;
					$item->debit = $item->bill_debit;
					$item->debit_name = Account::find($item->bill_debit)->name_ar;
					$item->credit = $item->bill_credit;
					$item->credit_name = Account::find($item->bill_credit)->name_ar;
					$item->staff_id = $item->bill_staff_id;
					$item->staff_name = User::find($item->staff_id)->name;
					if ($item->bill_is_cash == 1) {
						$item->is_cash = trans('modules.cash');
					}
					else {
						$item->is_cash = trans('modules.post');
					}

					if ($item->type_id == 2 || $item->type_id == 3) {
						$item->customer_name = $item->debit_name;
					}
					else {
						$item->customer_name = $item->credit_name;
					}
					$item->is_bill = 'yes';
				}
				else {

					$item->id = $item->voucher_id;
					$item->number = ($item->voucher_number != null) ? $item->voucher_number : '';
					$item->type_id = $item->voucher_type_id;
					$item->type_name = VoucherType::find($item->voucher_type_id)->name_ar;
					$item->currency_id = $item->voucher_currency_id;
					$item->currency_name = Currency::find($item->voucher_currency_id)->name_ar;
					$item->debit = $item->voucher_debit;
					$item->debit_name = Account::find($item->voucher_debit)->name_ar;
					$item->credit = $item->voucher_credit;
					$item->credit_name = Account::find($item->voucher_credit)->name_ar;
					$item->staff_id = $item->voucher_staff_id;
					$item->staff_name = User::find($item->voucher_staff_id)->name;
					$item->is_cash = '';
					if ($item->type_id == 2 || $item->type_id == 3 || $item->type_id == 5) {
						$item->customer_name = $item->debit_name;
					}
					else {
						$item->customer_name = $item->credit_name;
					}
					$item->is_bill = 'no';
				}
			});
		}
		//---------------------------------

		$json = json_encode($data);
		$data = json_decode($json, true);
		$bills_number = count($data);
		$rows_count = count($data);

		if ($data == null) {
			return trans('messages.no_data_please_using_filter_to_show_your_data_and_press_export_aging');
		}
		$new_data = array();

		foreach ($data as $arr) {

			$temp = array(
				"delegate" => $delegate_name,
				"type_name" => $arr['type_name'],
				"number" => $arr['number'],
				"narration" => $arr['narration'],
				"date" => $arr['date'],
				"customer_name" => $arr['customer_name'],
				"currency_name" => $arr['currency_name'],
				"is_cash" => $arr['is_cash'],
				"staff_name" => $arr['staff_name'],
			);

			array_push($new_data, $temp);
		}

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
				    	"delegate" => trans('modules.delegate'),
				    	"number" => trans('modules.type_name'),
				    	"type_name" => trans('modules.operation_name'),
				    	"narration" => trans('modules.narration'),
				    	"date" => trans('modules.date'),
				    	"customer_name" => trans('modules.client'),
				    	"currency_name" => trans('modules.currency'),
				    	"is_cash" => trans('modules.paid_type'),
				    	"staff_name" => trans('modules.staff'),
				    ));
				    $sheet->row(1, function ($row) {
					        // call cell manipulation methods
        					$row->setBackground('#cccccc');
				        }
				        );

				        $sheet->appendRow(2, array(
				        	'', '', '', '', '', '', '', '', ''
				        ));

				        $sheet->freezeFirstRow();
				        // Set auto size for sheet
        				$sheet->setAutoSize(true);
			        }
			        );

		        })->export('xls');

	}

	//print function
	public function print($filter)
	{

		$filter = json_decode($filter);
		$filter = collect($filter);
		$request = array();
		$filter->each(function ($f) use (&$request) {
			$request["$f->name"] = $f->value;
		});
		$conditions = array(['entry_base.action', '=', NULL],['entry_base.cycle_id', '=',  Session::get('display_cycle')]);

		//new Query

		$query = EntryBase::select(
			'entry_base.date as date',
			'entry_base.narration as narration',
			'bills.id as bill_id',
			'bills.bill_type_id as bill_type_id',
			'bills.currency_id as bill_currency_id',
			'bills.debit as bill_debit',
			'bills.credit as bill_credit',
			'bills.staff_id as bill_staff_id',
			'bills.is_cash as bill_is_cash',
			'bills.bill_number as bill_number',
			'vouchers.id as voucher_id',
			'vouchers.voucher_type_id as voucher_type_id',
			'vouchers.currency_id as voucher_currency_id',
			'vouchers.debit as voucher_debit',
			'vouchers.credit as voucher_credit',
			'vouchers.staff_id as voucher_staff_id',
			'vouchers.voucher_number as voucher_number'

		)
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->where($conditions)
			->orderby('entry_base.date', 'desc')->orderby('entry_base.id');


		$delegate_name = '';
		if ($request['delegate_id'] != -1 && $request['delegate_id'] != null) {

			$res = User::find($request['delegate_id']);
			$delegate_name = $res->name;

			$query->where(function ($query) use ($request) {
				$query->where('bills.delegate_id', '=', $request['delegate_id'])
					->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);

			});


			if ($request['from_date'] != null && $request['to_date'] == null) {
				$query->where('entry_base.date', '>=', $request['from_date']);
			}
			if ($request['from_date'] == null && $request['to_date'] != null) {
				$query->where('entry_base.date', '<=', $request['to_date']." 23:59:59");
			}
			if ($request['from_date'] != null && $request['to_date'] != null) {
				$query->whereBetween('entry_base.date', [$request['from_date'], $request['to_date']." 23:59:59"]);
			}
			$query->orderBy('entry_base.date')->distinct();
			$data = $query->get();
			$data->each(function ($item) {
				if ($item->bill_id != null) {
					$item->id = $item->bill_id;
					$item->number = ($item->bill_number != null) ? $item->bill_number : '';
					$item->type_id = $item->bill_type_id;
					$item->type_name = BillType::find($item->bill_type_id)->name_ar;
					$item->currency_id = $item->bill_currency_id;
					$item->currency_name = Currency::find($item->bill_currency_id)->name_ar;
					$item->debit = $item->bill_debit;
					$item->debit_name = Account::find($item->bill_debit)->name_ar;
					$item->credit = $item->bill_credit;
					$item->credit_name = Account::find($item->bill_credit)->name_ar;
					$item->staff_id = $item->bill_staff_id;
					$item->staff_name = User::find($item->staff_id)->name;
					if ($item->bill_is_cash == 1) {
						$item->is_cash = trans('modules.cash');
					}
					else {
						$item->is_cash = trans('modules.post');
					}

					if ($item->type_id == 2 || $item->type_id == 3) {
						$item->customer_name = $item->debit_name;
					}
					else {
						$item->customer_name = $item->credit_name;
					}
					$item->is_bill = 'yes';
				}
				else {

					$item->id = $item->voucher_id;
					$item->number = ($item->voucher_number != null) ? $item->voucher_number : '';
					$item->type_id = $item->voucher_type_id;
					$item->type_name = VoucherType::find($item->voucher_type_id)->name_ar;
					$item->currency_id = $item->voucher_currency_id;
					$item->currency_name = Currency::find($item->voucher_currency_id)->name_ar;
					$item->debit = $item->voucher_debit;
					$item->debit_name = Account::find($item->voucher_debit)->name_ar;
					$item->credit = $item->voucher_credit;
					$item->credit_name = Account::find($item->voucher_credit)->name_ar;
					$item->staff_id = $item->voucher_staff_id;
					$item->staff_name = User::find($item->voucher_staff_id)->name;
					$item->is_cash = '';
					if ($item->type_id == 2 || $item->type_id == 3 || $item->type_id == 5) {
						$item->customer_name = $item->debit_name;
					}
					else {
						$item->customer_name = $item->credit_name;
					}
					$item->is_bill = 'no';
				}
			});
		}

		return view("report_print.salesmen", array("data" => $data, 'delegate_name' => $delegate_name));

	}
}
