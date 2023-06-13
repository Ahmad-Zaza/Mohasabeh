<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Reports;

use App\Models\Vouchers\InitialVouchersList;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use Session;


class GeneralEntryRecordController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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

		if (!CRUDBooster::isView())
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.you_dont_have_access_permission'), "warning");

		$conditions = array( ['entries.action', '=', NULL],['entries.cycle_id', '=',  Session::get('display_cycle')]);




		if ($request->has('currency_id') && $request->input('currency_id') != -1 && is_numeric($request->currency_id)) {

			array_push($conditions, ['currencies.id', '=', $request->currency_id]);

		}
		if ($request->has('from_date') && $request->input('from_date') != null) {

			array_push($conditions, ['entry_base.date', '>=', $request->from_date]);

		}

		if ($request->has('to_date') && $request->input('to_date') != null) {

			array_push($conditions, ['entry_base.date', '<=', $request->to_date." 23:59:59"]);

		}

		$user = CRUDBooster::getUser();
		$accounts_ids = $user->getAccountsIdsForReports();
		$accounts = Account::whereIn('id',$accounts_ids)->get();

		$currencies = Currency::get();


		$query = Entry::select(
			'entries.id as record_id',
			'accounts.id as id',
			'accounts.parent_id as parent_id',
			'accounts.name_ar as name',
			'entries.credit AS paid_amount',
			'entries.debit AS received_amount',
			'entries.status AS entry_status',
			'currencies.name_ar as currency',
			'currencies.id as currency_id',
			'entries.equalizer as equalizer',
			'entry_base.entry_number as entryBaseId',
			'entry_base.create_at as date',
			DB::raw("(SELECT name FROM cms_users WHERE
				 cms_users.id = entry_base.create_by) as employee_name"),
			'entry_base.narration as narration',
			'entry_base.bill_id as bill_id',
			DB::raw("(SELECT bill_type_id FROM bills WHERE
				 bills.id = entry_base.bill_id) as bill_type"),
			'entry_base.voucher_id as voucher_id',
			DB::raw("(SELECT voucher_type_id FROM vouchers WHERE
				vouchers.id = entry_base.voucher_id) as voucher_type"),
			'vouchers.p_code as voucher_p_code'	

		)
			->join("entry_base", "entry_base.id", "entries.entry_base_id")
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions)
			->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');


		if ($request->has('account_id') && $request->input('account_id') != -1) {
			$query->where('accounts.id', $request->account_id);
		}

		if ($user->roleId == 4) {
			if ($user->boxAccount != $request->account_id) {
				$delegate_id = $user->id;
				$delegates = User::where('id', $user->id)->get();

				$query->where(function ($query) use ($request) {
					$query->where('bills.delegate_id', '=', $request->delegate_id)
						->orWhere('vouchers.delegate_id', '=', $request->delegate_id);

				});
			}
			else {
				$delegates = [];
			}


		}
		else {
			$delegates = User::whereIn('id_cms_privileges', explode(',',config('setting.DELEGATES_ROLES_IDS')))->get();
		}


		if ($request->input('delegate_id') != null && $request->input('delegate_id') != -1 && $delegate_id == null && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
			$delegate_id = $request->input('delegate_id');
			$query->where(function ($query) use ($request) {
				$query->where('bills.delegate_id', '=', $request->delegate_id)
					->orWhere('vouchers.delegate_id', '=', $request->delegate_id);

			});
		}

		$data = $query->paginate(config('setting.PAGINATIOM_LIMITATION'));

		//change initial voucher id to initial vouchers group id
		$data->each(function ($item) {
			if($item->voucher_type == 4){ 
				$iv_group_id = InitialVouchersList::where('p_code',$item->voucher_p_code)->where('cycle_id',Session::get('display_cycle'))->first()->iv_group_id;
				$item->voucher_id = $iv_group_id;
			}
		 });
		
		if (!in_array($user->roleId,explode(',',config('setting.Roles_IDS_HAS_VIEW_ALL_REPORTS_PERMISSION')))) {
			if ($request->input('delegate_id') != null && $request->input('delegate_id') != -1) {
				if ($user->id != $request->input('delegate_id')) {
					$data = [];
				}
			}
		}

		
		return view("report.general_entry_record", array("data" => $data, "accounts" => $accounts,
			"currencies" => $currencies, "account_id" => $request->input('account_id'),
			"currency_id" => $request->input('currency_id'),
			'from_date' => $request->from_date, 'to_date' => $request->to_date,
			'delegates' => $delegates, 'delegate_id' => $delegate_id));
	}

	//By the way, you can still create your own method in here... :)

	//export to excel file xls
	public function export($filter)
	{

		$filter = json_decode($filter);
		$filter = collect($filter);
		$request = array();
		$filter->each(function ($f) use (&$request) {
			$request["$f->name"] = $f->value;
		});

		//make query with filter
		$conditions = array( ['entries.action', '=', NULL],['entries.cycle_id', '=',  Session::get('display_cycle')]);
		if ($request['currency_id'] && $request['currency_id'] != -1 && is_numeric($request['currency_id'])) {
			array_push($conditions, ['currencies.id', '=', $request['currency_id']]);
		}
		if ($request['from_date'] && $request['from_date'] != null) {
			array_push($conditions, ['entry_base.date', '>=', $request['from_date']]);
		}

		if ($request['to_date'] && $request['to_date'] != null) {
			array_push($conditions, ['entry_base.date', '<=', $request['to_date']." 23:59:59"]);
		}
		$query = Entry::select(
			'entries.id as record_id',
			'accounts.id as id',
			'accounts.parent_id as parent_id',
			'accounts.name_ar as name',
			'entries.credit AS paid_amount',
			'entries.debit AS received_amount',
			'entries.status AS entry_status',
			'currencies.name_ar as currency',
			'currencies.id as currency_id',
			'entries.equalizer as equalizer',
			'entry_base.entry_number as entryBaseId',
			'entry_base.create_at as date',
			DB::raw("(SELECT name FROM cms_users WHERE
				cms_users.id = entry_base.create_by) as employee_name"),
			'entry_base.narration as narration',
			'entry_base.bill_id as bill_id',
			DB::raw("(SELECT bill_type_id FROM bills WHERE
				bills.id = entry_base.bill_id) as bill_type"),
			'entry_base.voucher_id as voucher_id',
			DB::raw("(SELECT voucher_type_id FROM vouchers WHERE
				vouchers.id = entry_base.voucher_id) as voucher_type")

		)
			->join("entry_base", "entry_base.id", "entries.entry_base_id")
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions)
			->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');


		if ($request['account_id'] && $request['account_id'] != -1) {
			$query->where('accounts.id', $request['account_id']);
		}
		$user = CRUDBooster::getUser();
		if ($user->roleId == 4) {
			if ($user->boxAccount != $request['account_id']) {
				$delegate_id = $user->id;

				$query->where(function ($query) use ($request) {
					$query->where('bills.delegate_id', '=', $request['delegate_id'])
						->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);
				});
			}
		}

		if ($request['delegate_id'] != null && $request['delegate_id'] != -1 && $delegate_id == null && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {

			$query->where(function ($query) use ($request) {
				$query->where('bills.delegate_id', '=', $request['delegate_id'])
					->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);
			});
		}

		//---------------------
		$report = $query->get();
		$json = json_encode($report);
		$data = json_decode($json, true);
		if ($data == null) {
			return trans('messages.no_data_please_using_filter_to_show_your_data_and_press_export_aging');
		}

		$new_data = array();
		foreach ($data as $arr) {
			$received_amount = $arr['received_amount'] != null ? $arr['received_amount'] : '0';
			$paid_amount = $arr['paid_amount'] != null ? $arr['paid_amount'] : '0';
			$temp = array(
				"entryBaseId" => $arr['entryBaseId'],
				"name" => $arr['name'],
				"received_amount" => $received_amount,
				"paid_amount" => $paid_amount,
				"date" => $arr['date'],
				"employee_name" => $arr['employee_name'],
				"narration" => $arr['narration'],
				"currency" => $arr['currency'],
				"entry_status" => ($arr['entry_status'])?trans('labels.active_entry'):trans('labels.inactive_entry'),
			);

			array_push($new_data, $temp);
		}
		$data = $new_data;

		Excel::create('export_general_entry_record_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data) {

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

			$excel->sheet('Result', function ($sheet) use ($data) {
				    $sheet->setOrientation('landscape');
				    $sheet->setPageMargin(0.25);

				    $sheet->fromArray($data);
				    // Add before first row
    				$sheet->prependRow(1, array(
				    	"entryBaseId" => trans('modules.entry_base'),
				    	"name" => trans('modules.name'),
				    	"received_amount" => trans('modules.debit'),
				    	"paid_amount" => trans('modules.credit'),
				    	"date" => trans('modules.date'),
				    	"employee_name" => trans('modules.staff'),
				    	"narration" => trans('modules.narration'),
				    	"currency" => trans('modules.currency'),
				    	"entry_status" => trans('modules.entry_status'),
				    ));
				    $sheet->row(1, function ($row) {
					        // call cell manipulation methods
        					$row->setBackground('#cccccc');

				        }
				        );
				        $sheet->appendRow(2, array(
				        	'', '', '', '', '', '', '', '', '', '', ''
				        ));

				        $sheet->freezeFirstRow();
				        // Set auto size for sheet
        				$sheet->setAutoSize(true);
			        }
			        );

		        })->export('xls');

	}

	public function print($filter)
	{
		//get report from session
		$filter = json_decode($filter);
		$filter = collect($filter);
		$request = array();
		$filter->each(function ($f) use (&$request) {
			$request["$f->name"] = $f->value;
		});

		//make query with filter
		$conditions = array( ['entries.action', '=', NULL],['entries.cycle_id', '=',  Session::get('display_cycle')]);
		if ($request['currency_id'] && $request['currency_id'] != -1 && is_numeric($request['currency_id'])) {
			array_push($conditions, ['currencies.id', '=', $request['currency_id']]);
		}
		if ($request['from_date'] && $request['from_date'] != null) {
			array_push($conditions, ['entry_base.date', '>=', $request['from_date']]);
		}

		if ($request['to_date'] && $request['to_date'] != null) {
			array_push($conditions, ['entry_base.date', '<=', $request['to_date']." 23:59:59"]);
		}
		$query = Entry::select(
			'entries.id as record_id',
			'accounts.id as id',
			'accounts.parent_id as parent_id',
			'accounts.name_ar as name',
			'entries.credit AS paid_amount',
			'entries.debit AS received_amount',
			'entries.status AS entry_status',
			'currencies.name_ar as currency',
			'currencies.id as currency_id',
			'entries.equalizer as equalizer',
			'entry_base.entry_number as entryBaseId',
			'entry_base.create_at as date',
			DB::raw("(SELECT name FROM cms_users WHERE
				cms_users.id = entry_base.create_by) as employee_name"),
			'entry_base.narration as narration',
			'entry_base.bill_id as bill_id',
			DB::raw("(SELECT bill_type_id FROM bills WHERE
				bills.id = entry_base.bill_id) as bill_type"),
			'entry_base.voucher_id as voucher_id',
			DB::raw("(SELECT voucher_type_id FROM vouchers WHERE
				vouchers.id = entry_base.voucher_id) as voucher_type")

		)
			->join("entry_base", "entry_base.id", "entries.entry_base_id")
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions)
			->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');


		if ($request['account_id'] && $request['account_id'] != -1) {
			$query->where('accounts.id', $request['account_id']);
		}
		$user = CRUDBooster::getUser();
		if ($user->roleId == 4) {
			if ($user->boxAccount != $request['account_id']) {
				$delegate_id = $user->id;

				$query->where(function ($query) use ($request) {
					$query->where('bills.delegate_id', '=', $request['delegate_id'])
						->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);
				});
			}
		}

		if ($request['delegate_id'] != null && $request['delegate_id'] != -1 && $delegate_id == null && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {

			$query->where(function ($query) use ($request) {
				$query->where('bills.delegate_id', '=', $request['delegate_id'])
					->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);
			});
		}

		//---------------------
		$data = $query->get();
		return view("report_print.general_entry_record", array("data" => $data));
	}

}
