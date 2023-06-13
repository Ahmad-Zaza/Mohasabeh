<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Reports;

use App\Models\Vouchers\InitialVouchersList;
use CRUDBooster;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use Session;

class AccountstatementController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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
		$this->button_add = false;
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = false;
		$this->button_filter = false;
		$this->button_import = false;
		$this->button_export = true;
		$this->table = "entries";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Entry Base Id", "name" => "entry_base_id", "join" => "entry_base,id"];
		$this->col[] = ["label" => "Debit", "name" => "debit"];
		$this->col[] = ["label" => "Credit", "name" => "credit"];
		$this->col[] = ["label" => "Account Id", "name" => "account_id", "join" => "accounts,id"];
		$this->col[] = ["label" => "Sorting", "name" => "sorting"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Entry Base Id', 'name' => 'entry_base_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'entry_base,id'];
		$this->form[] = ['label' => 'Debit', 'name' => 'debit', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Credit', 'name' => 'credit', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Account Id', 'name' => 'account_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'account,id'];
		$this->form[] = ['label' => 'Active', 'name' => 'active', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Sorting', 'name' => 'sorting', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
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



	//By the way, you can still create your own method in here... :)
	public function getIndex(\Illuminate\Http\Request $request)
	{
		if (!CRUDBooster::isView())
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.you_dont_have_access_permission'), "warning");

		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);

		if ($request->has('from_date') && $request->input('from_date') != null) {

			array_push($conditions, ['entry_base.date', '>=', $request->from_date]);

		}

		if ($request->has('to_date') && $request->input('to_date') != null) {

			array_push($conditions, ['entry_base.date', '<=', $request->to_date." 23:59:59"]);

		}

		if ($request->has('currency_id') && $request->input('currency_id') != -1 && $request->input('currency_id') != -2 && is_numeric($request->currency_id)) {

			array_push($conditions, ['currencies.id', '=', $request->currency_id]);

		}

		$user = CRUDBooster::getUser();
		$persons = $user->getPersonsForReports();


		$query = EntryBase::select(
			'entries.id as record_id',
			'entry_base.date as entryDate', 'entry_base.narration as entryNarration', 'entry_base.id as entryBaseId',
			'entries.debit as debit', 'entries.credit as credit',
			'bills.p_code as billCode', 'bill_types.name_ar as billTypeName', 'bills.id as billId'
			, 'bill_types.id as billTypeId', 'currencies.id as currency_id', 'currencies.name_ar as currency_nameAr',
			'vouchers.id as VoucherId', 'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as VoucherTypeId',
			'voucher_types.name_ar as VoucherTypeName',
			'accounts.name_ar as accountName'


		)
			->join("entries", "entries.entry_base_id", "entry_base.id")
			->leftjoin("bills", "bills.id", "entry_base.bill_id")
			->leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->leftjoin("voucher_types", "vouchers.voucher_type_id", "voucher_types.id")
			->leftjoin("bill_types", "bill_types.id", "bills.bill_type_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("persons", "persons.account_id", "accounts.id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions);


		$person_name = '';
		if ($request->input('person_id') != -1 && $request->input('person_id') != null) {

			$person = Person::select('account_id')->where('id', $request->input('person_id'))->first();

			$person = Person::where('id', $request->person_id)->first();

			$person_name = $person->name_ar;

			$query->where('entries.account_id', $person->account_id);

			$query->orderBy('entry_base.date')->orderBy('entry_base.id')->orderby('record_id','ASC')->distinct();

			$all_data = $query->get();

			$sum_balance = array();
			foreach ($active_currencies as $curr) {
				$sum_balance['curr_balance_' . $curr->id] = 0;
			}
			$all_data->each(function ($item) use (&$sum_balance) {
				$paid = ($item->credit ? $item->credit : 0);
				$received = ($item->debit ? $item->debit : 0);
				$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
				$item->sum_balance = $sum_balance;
			});
			$final_balance = $sum_balance;



			//get limit data to show them
			$data = $query->offset(0)->limit(config('setting.PAGINATIOM_LIMITATION'))->get();
			$sum_balance = array();
			foreach ($active_currencies as $curr) {
				$sum_balance['curr_balance_' . $curr->id] = 0;
			}
			$data->each(function ($item) use (&$sum_balance) {
				$paid = ($item->credit ? $item->credit : 0);
				$received = ($item->debit ? $item->debit : 0);
				$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
				$item->sum_balance = $sum_balance;

				if ($item->billId != null) {
					$item->type_name = $item->billTypeName;
					$item->code = $item->billCode;

					$item->temp_id = $item->billId;
					$item->temp_type = $item->billTypeId;
					$item->is_bill = 'yes';
				}
				else {
					$item->type_name = $item->VoucherTypeName;
					$item->code = $item->VoucherCode;
					if($item->VoucherTypeId == 4){
						$iv_group_id = InitialVouchersList::where('p_code',$item->code)->where('cycle_id',Session::get('display_cycle'))->first()->iv_group_id;
						$item->temp_id = $iv_group_id;
					}else{
						$item->temp_id = $item->VoucherId;
					}
					$item->temp_type = $item->VoucherTypeId;
					$item->is_bill = 'no';
				}

				$item->entryNarration = ($item->entryNarration) ? $item->entryNarration : "";

			});



		}


		return view("report.accountStatement", array("data" => $data,
			"persons" => $persons, "person_id" => $request->input('person_id'),
			"person_name" => $person_name,
			'from_date' => $request->from_date, 'to_date' => $request->to_date,
			"active_currencies" => $active_currencies,
			"currency_id" => $request->input('currency_id'),
			'final_balance' => $final_balance,
			'sum_balance' => $sum_balance
		));


	}

	//export to excel file xls
	public function export($filter)
	{

		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		$filter = json_decode($filter);
		$filter = collect($filter);
		$request = array();
		$filter->each(function ($f) use (&$request) {
			$request["$f->name"] = $f->value;
		});
		//build Query
		//--------------------------------------
		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);
		if ($request['from_date'] && $request['from_date'] != null) {
			array_push($conditions, ['entry_base.date', '>=', $request['from_date']]);
		}

		if ($request['to_date'] && $request['to_date'] != null) {
			array_push($conditions, ['entry_base.date', '<=', $request['to_date']." 23:59:59"]);
		}

		if ($request['currency_id'] && $request['currency_id'] != -1 && $request['currency_id'] != -2 && is_numeric($request['currency_id'])) {
			array_push($conditions, ['currencies.id', '=', $request['currency_id']]);
		}

		$query = EntryBase::select(
			'entries.id as record_id',
			'entry_base.date as entryDate', 'entry_base.narration as entryNarration', 'entry_base.id as entryBaseId',
			'entries.debit as debit', 'entries.credit as credit',
			'bills.p_code as billCode', 'bill_types.name_ar as billTypeName', 'bills.id as billId'
			, 'bill_types.id as billTypeId', 'currencies.id as currency_id', 'currencies.name_ar as currency_nameAr',
			'vouchers.id as VoucherId', 'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as VoucherTypeId',
			'voucher_types.name_ar as VoucherTypeName',
			'accounts.name_ar as accountName'


		)
			->join("entries", "entries.entry_base_id", "entry_base.id")
			->leftjoin("bills", "bills.id", "entry_base.bill_id")
			->leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->leftjoin("voucher_types", "vouchers.voucher_type_id", "voucher_types.id")
			->leftjoin("bill_types", "bill_types.id", "bills.bill_type_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("persons", "persons.account_id", "accounts.id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions);

		if ($request['person_id'] != -1 && $request['person_id'] != null) {
			$person = Person::where('id', $request['person_id'])->first();
			$query->where('entries.account_id', $person->account_id);
			$query->orderBy('entry_base.date')->orderBy('entry_base.id')->orderby('record_id','ASC')->distinct();
		}
		//--------------------------------
		$report = $query->get();

		$json = json_encode($report);
		$data = json_decode($json, true);
		if ($data == null) {
			return trans('messages.no_data_please_using_filter_to_show_your_data_and_press_export_aging');
		}
		$rows_count = count($data) + 3;
		$new_data = array();
		$heading = array();
		$empty_row = array();


		if ($request['currency_id'] != -1) {
			$all_debit = 0;
			$all_credit = 0;
			$all_total = 0;

			foreach ($data as $arr) {
				$debit = $arr['debit'] != null ? $arr['debit'] : '0';
				$credit = $arr['credit'] != null ? $arr['credit'] : '0';
				$temp = array(
					"accountName" => $arr['accountName'],
					"entryDate" => $arr['entryDate'],
					"entryNarration" => $arr['entryNarration'],
					"debit" => $debit,
					"credit" => $credit,
					"currency_nameAr" => $arr['currency_nameAr']
				);

				$all_debit += $debit;
				$all_credit += $credit;

				array_push($new_data, $temp);
			}
			$result = array(
				"accountName" => '',
				"entryDate" => '',
				"entryNarration" => '',
				"debit" => $all_debit,
				"credit" => $all_credit,
				"currency" => '',
				'total' => ($all_debit - $all_credit)
			);
			array_push($new_data, $result);

			$data = $new_data;

			$heading = array(
				"accountName" => trans('modules.account'),
				"entryDate" => trans('modules.date'),
				"entryNarration" => trans('modules.narration'),
				"debit" => trans('modules.debit'),
				"credit" => trans('modules.credit'),
				"currency_nameAr" => trans('modules.currency')
			);
			$empty_row = array(
				'', '', '', '', '', '', '', '', '', ''
			);
		}
		else { //عرض تفصيل الحساب بجميع اللغات
			$final_balances = array();
			foreach ($active_currencies as $curr) {
				$final_balances['curr_balance_' . $curr->id] = 0;
			}

			foreach ($data as $arr) {
				$debit = $arr['debit'] != null ? $arr['debit'] : '0';
				$credit = $arr['credit'] != null ? $arr['credit'] : '0';

				$final_balances['curr_balance_' . $arr['currency_id']] += ($debit - $credit);
				$temp = array(
					"accountName" => $arr['accountName'],
					"entryDate" => $arr['entryDate'],
					"entryNarration" => $arr['entryNarration'],
					"debit" => $debit,
					"credit" => $credit,
					"currency_nameAr" => $arr['currency_nameAr']
				);
				foreach ($active_currencies as $curr) {
					$temp['curr_balance_' . $curr->id] = $final_balances['curr_balance_' . $curr->id] != 0 ? $final_balances['curr_balance_' . $curr->id] : '0';
				}

				array_push($new_data, $temp);
			}
			$result = array(
				"accountName" => '',
				"entryDate" => '',
				"entryNarration" => '',
				"debit" => '',
				"credit" => '',
				"currency" => '',
			);

			$heading = array(
				"accountName" => trans('modules.account'),
				"entryDate" => trans('modules.date'),
				"entryNarration" => trans('modules.narration'),
				"debit" => trans('modules.debit'),
				"credit" => trans('modules.credit'),
				"currency_nameAr" => trans('modules.currency')
			);

			$empty_row = array(
				'', '', '', '', '', '', '', '', '', ''
			);

			foreach ($active_currencies as $curr) {
				$result['curr_balance_' . $curr->id] = $final_balances['curr_balance_' . $curr->id] != 0 ? $final_balances['curr_balance_' . $curr->id] : '0';
				$heading['curr_balance_' . $curr->id] = trans('modules.balance') . $curr->name_ar;
				array_push($empty_row, '');
			}

			array_push($new_data, $result);
			$data = $new_data;
		}



		Excel::create('export_account_statement_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data, $heading, $empty_row, $rows_count) {

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

			$excel->sheet('Result', function ($sheet) use ($data, $heading, $empty_row, $rows_count) {
				    $sheet->setOrientation('landscape');
				    $sheet->setPageMargin(0.25);

				    $sheet->fromArray($data);
				    // Add before first row
    				$sheet->prependRow(1, $heading);
				    $sheet->row(1, function ($row) {
					        // call cell manipulation methods
        					$row->setBackground('#cccccc');

				        }
				        );
				        $sheet->row($rows_count, function ($row) {
					        //style last row
        					$row->setBackground('#cccccc');

				        }
				        );
				        $sheet->appendRow(2, $empty_row);

				        $sheet->freezeFirstRow();
				        // Set auto size for sheet
        				$sheet->setAutoSize(true);



			        }
			        );

		        })->export('xls');

	}

	public function loadmore($offset, $limit, $sumbalance, $filter)
	{
		$filter = json_decode($filter);
		$filter = collect($filter);
		$request = array();
		$filter->each(function ($f) use (&$request) {
			$request["$f->name"] = $f->value;
		});
		//return response()->json($filter);
		//build Query
		//--------------------------------------
		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);
		if ($request['from_date'] && $request['from_date'] != null) {
			array_push($conditions, ['entry_base.date', '>=', $request['from_date']]);
		}

		if ($request['to_date'] && $request['to_date'] != null) {
			array_push($conditions, ['entry_base.date', '<=', $request['to_date']." 23:59:59"]);
		}

		if ($request['currency_id'] && $request['currency_id'] != -1 && $request['currency_id'] != -2 && is_numeric($request['currency_id'])) {
			array_push($conditions, ['currencies.id', '=', $request['currency_id']]);
		}


		$query = EntryBase::select(
			'entries.id as record_id',
			'entry_base.date as entryDate', 'entry_base.narration as entryNarration', 'entry_base.id as entryBaseId',
			'entries.debit as debit', 'entries.credit as credit',
			'bills.p_code as billCode', 'bill_types.name_ar as billTypeName', 'bills.id as billId'
			, 'bill_types.id as billTypeId', 'currencies.id as currency_id', 'currencies.name_ar as currency_nameAr',
			'vouchers.id as VoucherId', 'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as VoucherTypeId',
			'voucher_types.name_ar as VoucherTypeName',
			'accounts.name_ar as accountName'


		)
			->join("entries", "entries.entry_base_id", "entry_base.id")
			->leftjoin("bills", "bills.id", "entry_base.bill_id")
			->leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->leftjoin("voucher_types", "vouchers.voucher_type_id", "voucher_types.id")
			->leftjoin("bill_types", "bill_types.id", "bills.bill_type_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("persons", "persons.account_id", "accounts.id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions);

		if ($request['person_id'] != -1 && $request['person_id'] != null) {
			$person = Person::where('id', $request['person_id'])->first();
			$query->where('entries.account_id', $person->account_id);
			$query->orderBy('entry_base.date')->orderBy('entry_base.id')->orderby('record_id','ASC')->distinct();
		}
		//-------------------

		$data = $query->offset($offset)->limit($limit)->get();

		if ($data->count() > 0) {
			$sum_balance = json_decode($sumbalance, true);
			$data->each(function ($item) use (&$sum_balance) {
				$paid = ($item->credit ? $item->credit : 0);
				$received = ($item->debit ? $item->debit : 0);
				$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
				$item->sum_balance = $sum_balance;

				//add number format
				$temp_sum_balance = array();
				foreach ($sum_balance as $key => $bal) {
					$temp_sum_balance[$key] = ($bal) ? number_format($bal, 2) : "0.00";
				}
				$item->sum_balance_fix_format = $temp_sum_balance;

				$item->credit = ($item->credit) ? number_format($item->credit, 2) : 0;
				$item->debit = ($item->debit) ? number_format($item->debit, 2) : 0;

				if ($item->billId != null) {
					$item->type_name = $item->billTypeName;
					$item->code = $item->billCode;

					$item->temp_id = $item->billId;
					$item->temp_type = $item->billTypeId;
					$item->is_bill = 'yes';
				}
				else {
					$item->type_name = $item->VoucherTypeName;
					$item->code = $item->VoucherCode;
					
					if($item->VoucherTypeId == 4){ 
						$iv_group_id = InitialVouchersList::where('p_code',$item->code)->where('cycle_id',Session::get('display_cycle'))->first()->iv_group_id;
						$item->temp_id = $iv_group_id;
					}else{
						$item->temp_id = $item->VoucherId;
					}

					$item->temp_type = $item->VoucherTypeId;
					$item->is_bill = 'no';
				}


				$item->entryNarration = ($item->entryNarration) ? $item->entryNarration : "";

			});
		}

		return response()->json($data);
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

		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);

		if ($request['from_date'] && $request['from_date'] != null) {
			array_push($conditions, ['entry_base.date', '>=', $request['from_date']]);
		}

		if ($request['to_date'] && $request['to_date'] != null) {
			array_push($conditions, ['entry_base.date', '<=', $request['to_date']." 23:59:59"]);
		}

		if ($request['currency_id'] && $request['currency_id'] != -1 && $request['currency_id'] != -2 && is_numeric($request['currency_id'])) {
			array_push($conditions, ['currencies.id', '=', $request['currency_id']]);
		}

		$query = EntryBase::select(
			'entries.id as record_id',
			'entry_base.date as entryDate', 'entry_base.narration as entryNarration', 'entry_base.id as entryBaseId',
			'entries.debit as debit', 'entries.credit as credit',
			'bills.p_code as billCode', 'bill_types.name_ar as billTypeName', 'bills.id as billId'
			, 'bill_types.id as billTypeId', 'currencies.id as currency_id', 'currencies.name_ar as currency_nameAr',
			'vouchers.id as VoucherId', 'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as VoucherTypeId',
			'voucher_types.name_ar as VoucherTypeName',
			'accounts.name_ar as accountName'


		)
			->join("entries", "entries.entry_base_id", "entry_base.id")
			->leftjoin("bills", "bills.id", "entry_base.bill_id")
			->leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->leftjoin("voucher_types", "vouchers.voucher_type_id", "voucher_types.id")
			->leftjoin("bill_types", "bill_types.id", "bills.bill_type_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("persons", "persons.account_id", "accounts.id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions);


		$person_name = '';
		if ($request['person_id'] != -1 && $request['person_id'] != null) {

			$person = Person::select('account_id')->where('id', $request['person_id'])->first();

			$person = Person::where('id', $request['person_id'])->first();

			$person_name = $person->name_ar;

			$query->where('entries.account_id', $person->account_id);

			$query->orderBy('entry_base.date')->orderBy('entry_base.id')->orderby('record_id','ASC')->distinct();

			$all_data = $query->get();
			$data = $all_data;

			$sum_balance = array();
			foreach ($active_currencies as $curr) {
				$sum_balance['curr_balance_' . $curr->id] = 0;
			}
			$all_data->each(function ($item) use (&$sum_balance) {
				$paid = ($item->credit ? $item->credit : 0);
				$received = ($item->debit ? $item->debit : 0);
				$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
				$item->sum_balance = $sum_balance;
			});
			$final_balance = $sum_balance;


			$sum_balance = array();
			foreach ($active_currencies as $curr) {
				$sum_balance['curr_balance_' . $curr->id] = 0;
			}
			$data->each(function ($item) use (&$sum_balance) {
				$paid = ($item->credit ? $item->credit : 0);
				$received = ($item->debit ? $item->debit : 0);
				$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
				$item->sum_balance = $sum_balance;

				if ($item->billId != null) {
					$item->type_name = $item->billTypeName;
					$item->code = $item->billCode;

					$item->temp_id = $item->billId;
					$item->temp_type = $item->billTypeId;
					$item->is_bill = 'yes';
				}
				else {
					$item->type_name = $item->VoucherTypeName;
					$item->code = $item->VoucherCode;

					$item->temp_id = $item->VoucherId;
					$item->temp_type = $item->VoucherTypeId;
					$item->is_bill = 'no';
				}

				$item->entryNarration = ($item->entryNarration) ? $item->entryNarration : "";

			});


		}

		//----------------------------------------------

		return view("report_print.accountStatement", array("data" => $data,
			"person_name" => $person_name,
			"active_currencies" => $active_currencies,
			"currency_id" => $request['currency_id'],
			'final_balance' => $final_balance,
			'sum_balance' => $sum_balance
		));

	}

}
