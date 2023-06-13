<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Reports;


use App\Models\Vouchers\InitialVouchersList;
use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Accounts\Customer;

class AccountReportController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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


		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);




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
			'currencies.name_ar as currency',
			'currencies.id as currency_id',
			'entries.equalizer as equalizer',
			'entry_base.date as date',
			'entry_base.narration as narration',
			'bills.id as billId',
			'bills.bill_type_id as billTypeId',
			'vouchers.id as voucherId',
			'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as voucherTypeId'
		)
			->join("entry_base", "entry_base.id", "entries.entry_base_id")
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions)
			->where('accounts.id', $request->account_id)
			->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');


		if ($user->roleId == 4) { //delegate
			if ($user->boxAccount != $request->account_id) {
				$delegate_id = $user->id;
				$delegates = User::where('id', $user->id)->get();

				$isCustomer = Customer::where('account_id', $request->account_id)->first();
				if (!$isCustomer) {
					$query->where(function ($query) use ($delegate_id) {
						$query->where('bills.delegate_id', '=', $delegate_id)
							->orWhere('vouchers.delegate_id', '=', $delegate_id);

					});
				}

			}
			else {
				$delegates = [];
			}


		}
		else {
			
			$delegates = User::whereIn('id_cms_privileges', explode(',',config('setting.DELEGATES_ROLES_IDS')))->get();

			if ($request->input('delegate_id') != null && $request->input('delegate_id') != -1  && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {

				$query->where(function ($query) use ($request) {
					$query->where('bills.delegate_id', '=', $request->delegate_id)
						->orWhere('vouchers.delegate_id', '=', $request->delegate_id);

				});
			}
		}






		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		if ($request->account_id != null && $request->account_id != -1) {
			$hasChilds = $gfunc->checkIfAccountHasChildren($request->account_id);
			if (!$hasChilds) { //الحساب ليس حساب تجميعي
				//get final balance with filter condition
				$all_data = $query->get();
				$sum_balance = array();
				foreach ($active_currencies as $curr) {
					$sum_balance['curr_balance_' . $curr->id] = 0;
				}
				$all_data->each(function ($item) use (&$sum_balance) {
					$paid = $item->paid_amount;
					$received = $item->received_amount;
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
					$paid = $item->paid_amount;
					$received = $item->received_amount;
					$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
					$item->sum_balance = $sum_balance;

					if ($item->billId != null) {
						$item->temp_id = $item->billId;
						$item->temp_type = $item->billTypeId;
						$item->is_bill = 'yes';
					}
					else {
						if($item->voucherTypeId == 4){ 
							$iv_group_id = InitialVouchersList::where('p_code',$item->VoucherCode)->where('cycle_id',Session::get('display_cycle'))->first()->iv_group_id;
							$item->temp_id = $iv_group_id;
						}else{
							$item->temp_id = $item->voucherId;
						}
						$item->temp_type = $item->voucherTypeId;
						$item->is_bill = 'no';
					}

				});

				$type_display = 1;
			}
			else {
				$type_display = 2;
				$first_childs = $gfunc->getFirstChildernForAccount($request->account_id);
				$data = [];
				foreach ($first_childs as $child) {
					$temp = array('id' => $child->id, 'name' => $child->name_ar);
					$currencies_balance = array();

					foreach ($active_currencies as $curr) {
						$currencies_balance['curr_balance_' . $curr->id] = 0;
					}
					$gfunc->getAccountBalance_sum_childrenBalances($child->id, $currencies_balance);
					foreach ($active_currencies as $curr) {
						$temp['curr_balance_' . $curr->id] = $currencies_balance['curr_balance_' . $curr->id];
					}
					array_push($data, $temp);
				}

			}

		}
		else {
			$data = [];
		}


		if (!CRUDBooster::isSuperAdmin()) {
			if ($request->input('delegate_id') != null && $request->input('delegate_id') != -1) {
				if ($user->id != $request->input('delegate_id')) {
					$data = [];
				}
			}

		}

		Session::put('account_report', $data);
		Session::put('account_report_type_display', $type_display);
		Session::put('account_report_currency', $request->input('currency_id'));

		return view("report.account", array("data" => $data, 'type_display' => $type_display, "accounts" => $accounts,
			"currencies" => $currencies, "account_id" => $request->input('account_id'),
			"currency_id" => $request->input('currency_id'),
			'from_date' => $request->from_date, 'to_date' => $request->to_date,
			'delegates' => $delegates, 'delegate_id' => $request->input('delegate_id'),
			'active_currencies' => $active_currencies,
			'final_balance' => $final_balance,
			'sum_balance' => $sum_balance
		));
	}

	//By the way, you can still create your own method in here... :)

	//export to excel file xls
	public function export($filter)
	{
		//get report from session
		$data = Session::get('account_report');
		$rows_count = count($data) + 3;
		if ($data == null) {
			return trans('messages.no_data_please_using_filter_to_show_your_data_and_press_export_aging');
		}
		$type_display = Session::get('account_report_type_display');
		$account_currency = Session::get('account_report_currency');
		$heading = array();
		$empty_row = array();

		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		if ($type_display == 2) { //report display type رصيد تجميعي
			$new_data = array();

			$final_balances = array();
			foreach ($active_currencies as $curr) {
				$final_balances['curr_balance_' . $curr->id] = 0;
			}

			foreach ($data as $arr) {
				$temp = array(
					"name" => $arr['name']
				);
				foreach ($active_currencies as $curr) {
					$temp['curr_balance_' . $curr->id] = $arr['curr_balance_' . $curr->id] != null ? $arr['curr_balance_' . $curr->id] : '0';
					$final_balances['curr_balance_' . $curr->id] += $temp['curr_balance_' . $curr->id];
				}

				array_push($new_data, $temp);
			}
			$result = array(
				"name" => ''
			);
			$heading = array(
				"name" => trans('modules.account')
			);
			$empty_row = array(
				''
			);
			foreach ($active_currencies as $curr) {
				$result['curr_balance_' . $curr->id] = $final_balances['curr_balance_' . $curr->id];
				$heading['curr_balance_' . $curr->id] = trans('modules.balance') . ' ' . $curr->name_ar;
				array_push($empty_row, '');
			}
			array_push($new_data, $result);


			$data = $new_data;



		}
		else { //type dispaly = 1  حساب ليس تجميعي
			$filter = json_decode($filter);
			$filter = collect($filter);
			$request = array();
			$filter->each(function ($f) use (&$request) {
				$request["$f->name"] = $f->value;
			});
			//build Query
			//--------------------------------------
			$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);

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
				'currencies.name_ar as currency',
				'currencies.id as currency_id',
				'entries.equalizer as equalizer',
				'entry_base.date as date',
				'entry_base.narration as narration',
				'bills.id as billId',
				'bills.bill_type_id as billTypeId',
				'vouchers.id as voucherId',
				'vouchers.p_code as VoucherCode',
				'vouchers.voucher_type_id as voucherTypeId'
			)
				->join("entry_base", "entry_base.id", "entries.entry_base_id")
				->Leftjoin("bills", "bills.id", "entry_base.bill_id")
				->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
				->join("accounts", "accounts.id", "entries.account_id")
				->join("currencies", "currencies.id", "entries.currency_id")
				->where($conditions)
				->where('accounts.id', $request['account_id'])
				->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');

			$user = CRUDBooster::getUser();
			if ($user->roleId == 4) {
				if ($user->boxAccount != $request['account_id']) {
					$delegate_id = $user->id;
					$isCustomer = Customer::where('account_id', $request['account_id'])->first();
					if (!$isCustomer) {
						$query->where(function ($query) use ($delegate_id) {
							$query->where('bills.delegate_id', '=', $delegate_id)
								->orWhere('vouchers.delegate_id', '=', $delegate_id);
						});
					}
				}
			}
			else { //is superadmin
				if ($request['delegate_id'] != null && $request['delegate_id'] != -1  && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
					$query->where(function ($query) use ($request) {
						$query->where('bills.delegate_id', '=', $request['delegate_id'])
							->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);
					});
				}
			}



			$data = $query->get();
			$rows_count = count($data) + 3;
			//-------------------

			if ($account_currency != -1) { //تم تحديد العملة بالتقرير
				$new_data = array();
				$total = 0;

				foreach ($data as $arr) {
					//convert object to array
					$json = json_encode($arr);
					$arr = json_decode($json, true);
					$received_amount = $arr['received_amount'] != null ? $arr['received_amount'] : '0';
					$paid_amount = $arr['paid_amount'] != null ? $arr['paid_amount'] : '0';
					$total += ($received_amount - $paid_amount);
					$temp = array(
						"name" => $arr['name'],
						"received_amount" => $received_amount,
						"paid_amount" => $paid_amount,
						"date" => $arr['date'],
						"narration" => $arr['narration'],
						"currency" => $arr['currency'],
						"total" => $total != 0 ? $total : '0'
					);

					array_push($new_data, $temp);
				}

				$data = $new_data;

				$heading = array(
					"name" => trans('modules.name'),
					"received_amount" => trans('modules.debit'),
					"paid_amount" => trans('modules.credit'),
					"date" => trans('modules.date'),
					"narration" => trans('modules.narration'),
					"currency" => trans('modules.currency'),
					"total" => trans('modules.the_balance'),
				);
				$empty_row = array(
					'', '', '', '', '', '', ''
				);
			}
			else {
				$new_data = array();

				$final_balances = array();
				foreach ($active_currencies as $curr) {
					$final_balances['curr_balance_' . $curr->id] = 0;
				}

				foreach ($data as $arr) {
					//convert object to array	
					$json = json_encode($arr);
					$arr = json_decode($json, true);
					$received_amount = $arr['received_amount'] != null ? $arr['received_amount'] : '0';
					$paid_amount = $arr['paid_amount'] != null ? $arr['paid_amount'] : '0';

					$final_balances['curr_balance_' . $arr['currency_id']] += ($received_amount - $paid_amount);

					$temp = array(
						"name" => $arr['name'],
						"received_amount" => $received_amount,
						"paid_amount" => $paid_amount,
						"date" => $arr['date'],
						"narration" => $arr['narration'],
						"currency" => $arr['currency']
					);

					foreach ($active_currencies as $curr) {
						$temp['curr_balance_' . $curr->id] = $final_balances['curr_balance_' . $curr->id] != 0 ? $final_balances['curr_balance_' . $curr->id] : '0';
					}
					array_push($new_data, $temp);
				}



				$result = array(
					"name" => '',
					"received_amount" => "",
					"paid_amount" => "",
					"date" => "",
					"narration" => "",
					"currency" => "",
				);
				$heading = array(
					"name" => trans('modules.name'),
					"received_amount" => trans('modules.debit'),
					"paid_amount" => trans('modules.credit'),
					"date" => trans('modules.date'),
					"narration" => trans('modules.narration'),
					"currency" => trans('modules.currency'),
				);
				$empty_row = array(
					'', '', '', '', '', ''
				);
				foreach ($active_currencies as $curr) {
					$result['curr_balance_' . $curr->id] = $final_balances['curr_balance_' . $curr->id];
					$heading['curr_balance_' . $curr->id] = trans('modules.balance') . $curr->name_ar;
					array_push($empty_row, '');
				}
				array_push($new_data, $result);

				$data = $new_data;
			}

		}


		Excel::create('export_account_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data, $heading, $empty_row, $rows_count) {

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
		//build Query
		//--------------------------------------
		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);

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
			'currencies.name_ar as currency',
			'currencies.id as currency_id',
			'entries.equalizer as equalizer',
			'entry_base.date as date',
			'entry_base.narration as narration',
			'bills.id as billId',
			'bills.bill_type_id as billTypeId',
			'vouchers.id as voucherId',
			'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as voucherTypeId'
		)
			->join("entry_base", "entry_base.id", "entries.entry_base_id")
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions)
			->where('accounts.id', $request['account_id'])
			->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');

		$user = CRUDBooster::getUser();
		if ($user->roleId == 4) {
			if ($user->boxAccount != $request['account_id']) {
				$delegate_id = $user->id;
				$isCustomer = Customer::where('account_id', $request['account_id'])->first();
				if (!$isCustomer) {
					$query->where(function ($query) use ($delegate_id) {
						$query->where('bills.delegate_id', '=', $delegate_id)
							->orWhere('vouchers.delegate_id', '=', $delegate_id);
					});
				}
			}
		}
		else { //is superadmin
			if ($request['delegate_id'] != null && $request['delegate_id'] != -1 && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
				$query->where(function ($query) use ($request) {
					$query->where('bills.delegate_id', '=', $request['delegate_id'])
						->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);
				});
			}
		}


		//-------------------

		$data = $query->offset($offset)->limit($limit)->get();

		if ($data->count() > 0) {
			$sum_balance = json_decode($sumbalance, true);
			$data->each(function ($item) use (&$sum_balance) {
				$paid = $item->paid_amount;
				$received = $item->received_amount;
				$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
				$item->sum_balance = $sum_balance;
				//add number format
				$temp_sum_balance = array();
				foreach ($sum_balance as $key => $bal) {
					$temp_sum_balance[$key] = ($bal) ? number_format($bal, 2) : "0.00";
				}
				$item->sum_balance_fix_format = $temp_sum_balance;

				$item->received_amount = ($item->received_amount) ? number_format($item->received_amount, 2) : 0;
				$item->paid_amount = ($item->paid_amount) ? number_format($item->paid_amount, 2) : 0;

				$item->narration = ($item->narration) ? $item->narration : "";

				if ($item->billId != null) {
					$item->temp_id = $item->billId;
					$item->temp_type = $item->billTypeId;
					$item->is_bill = 'yes';
				}
				else {
					if($item->voucherTypeId == 4){ 
						$iv_group_id = InitialVouchersList::where('p_code',$item->VoucherCode)->where('cycle_id',Session::get('display_cycle'))->first()->iv_group_id;
						$item->temp_id = $iv_group_id;
					}else{
						$item->temp_id = $item->voucherId;
					}
					$item->temp_type = $item->voucherTypeId;
					$item->is_bill = 'no';
				}
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

		$conditions = array( ['entries.status', '=',  1],['entries.action', '=',  NULL ],['entries.cycle_id', '=',  Session::get('display_cycle')]);

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
			'currencies.name_ar as currency',
			'currencies.id as currency_id',
			'entries.equalizer as equalizer',
			'entry_base.date as date',
			'entry_base.narration as narration',
			'bills.id as billId',
			'bills.bill_type_id as billTypeId',
			'vouchers.id as voucherId',
			'vouchers.p_code as VoucherCode',
			'vouchers.voucher_type_id as voucherTypeId'
		)
			->join("entry_base", "entry_base.id", "entries.entry_base_id")
			->Leftjoin("bills", "bills.id", "entry_base.bill_id")
			->Leftjoin("vouchers", "vouchers.id", "entry_base.voucher_id")
			->join("accounts", "accounts.id", "entries.account_id")
			->join("currencies", "currencies.id", "entries.currency_id")
			->where($conditions)
			->where('accounts.id', $request['account_id'])
			->orderby('entry_base.date')->orderby('entry_base.id')->orderby('record_id','ASC');


		$user = CRUDBooster::getUser();	
		if ($user->roleId == 4) {
			if ($user->boxAccount != $request['account_id']) {
				$delegate_id = $user->id;
				$isCustomer = Customer::where('account_id', $request['account_id'])->first();
				if (!$isCustomer) {
					$query->where(function ($query) use ($delegate_id) {
						$query->where('bills.delegate_id', '=', $delegate_id)
							->orWhere('vouchers.delegate_id', '=', $delegate_id);

					});
				}
			}
		}
		else {

			if ($request['delegate_id'] != null && $request['delegate_id'] != -1  && !in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {

				$query->where(function ($query) use ($request) {
					$query->where('bills.delegate_id', '=', $request['delegate_id'])
						->orWhere('vouchers.delegate_id', '=', $request['delegate_id']);

				});
			}
		}






		$gfunc = new GeneralFunctionsController();
		$active_currencies = $gfunc->getActiveCurrencies();

		if ($request['account_id'] != null && $request['account_id'] != -1) {
			$hasChilds = $gfunc->checkIfAccountHasChildren($request['account_id']);
			if (!$hasChilds) { //الحساب ليس حساب تجميعي
				//get final balance with filter condition
				$all_data = $query->get();
				$data = $all_data;

				$sum_balance = array();
				foreach ($active_currencies as $curr) {
					$sum_balance['curr_balance_' . $curr->id] = 0;
				}
				$all_data->each(function ($item) use (&$sum_balance) {
					$paid = $item->paid_amount;
					$received = $item->received_amount;
					$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
					$item->sum_balance = $sum_balance;
				});
				$final_balance = $sum_balance;

				$sum_balance = array();
				foreach ($active_currencies as $curr) {
					$sum_balance['curr_balance_' . $curr->id] = 0;
				}
				$data->each(function ($item) use (&$sum_balance) {
					$paid = $item->paid_amount;
					$received = $item->received_amount;
					$sum_balance['curr_balance_' . $item->currency_id] = $sum_balance['curr_balance_' . $item->currency_id] + ($received - $paid);
					$item->sum_balance = $sum_balance;

					if ($item->billId != null) {
						$item->temp_id = $item->billId;
						$item->temp_type = $item->billTypeId;
						$item->is_bill = 'yes';
					}
					else {
						if($item->voucherTypeId == 4){ 
							$iv_group_id = InitialVouchersList::where('p_code',$item->VoucherCode)->where('cycle_id',Session::get('display_cycle'))->first()->iv_group_id;
							$item->temp_id = $iv_group_id;
						}else{
							$item->temp_id = $item->voucherId;
						}
						$item->temp_type = $item->voucherTypeId;
						$item->is_bill = 'no';
					}

				});

				$type_display = 1;
			}
			else {
				$type_display = 2;
				$first_childs = $gfunc->getFirstChildernForAccount($request['account_id']);
				$data = [];
				foreach ($first_childs as $child) {
					$temp = array('id' => $child->id, 'name' => $child->name_ar);
					$currencies_balance = array();

					foreach ($active_currencies as $curr) {
						$currencies_balance['curr_balance_' . $curr->id] = 0;
					}
					$gfunc->getAccountBalance_sum_childrenBalances($child->id, $currencies_balance);
					foreach ($active_currencies as $curr) {
						$temp['curr_balance_' . $curr->id] = $currencies_balance['curr_balance_' . $curr->id];
					}
					array_push($data, $temp);
				}

			}

		}
		else {
			$data = [];
		}


		if (!CRUDBooster::isSuperAdmin()) {
			if ($request['delegate_id'] != null && $request['delegate_id'] != -1) {
				if ($user->id != $request['delegate_id']) {
					$data = [];
				}
			}

		}

		//----------------------------------------------
		return view("report_print.account", array("data" => $data, 'type_display' => $type_display,
			"account_id" => $request['account_id'],
			"currency_id" => $request['currency_id'],
			'delegate_id' => $request['delegate_id'],
			'active_currencies' => $active_currencies,
			'final_balance' => $final_balance,
			'sum_balance' => $sum_balance));
	}

}
