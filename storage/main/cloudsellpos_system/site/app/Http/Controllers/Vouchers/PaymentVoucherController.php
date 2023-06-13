<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Vouchers;

use App\Http\Controllers\General\VouchersFunctionsController;
use App\Traits\AccountsTrait;
use App\Traits\VouchersTrait;
use DB;
use CRUDBooster;
use App\Traits\GeneralTrait;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Vouchers\Voucher;
use App\Models\Vouchers\VoucherType;
use App\Models\Vouchers\VoucherFile;
use Session;

class PaymentVoucherController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait,AccountsTrait,VouchersTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "date,desc";
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
		$user = CRUDBooster::getUser();
		
		$this->col = [];
		$this->col[] = ["label" => trans('modules.code'), "name" => "p_code"];
		$this->col[] = ["label" => trans('modules.voucher_number'), "name" => "voucher_number"];
		$this->col[] = ["label" => trans('modules.date'), "name" => "date"];
		$this->col[] = ["label" => trans('modules.opposite_account'), "name" => "debit", "join" => "accounts,name_ar"];
		$this->col[] = ["label" => trans('modules.majar_account'), "name" => "credit", "join" => "accounts,name_ar"];
		$this->col[] = ["label" => trans('modules.narration'), "name" => "narration"];
		$this->col[] = ["label" => trans('modules.currency'), "name" => "currency_id", "join" => "currencies,name_ar"];
		$this->col[] = ["label" => trans('modules.voucher_amount'), "name" => "amount"];
		if ($user->showStaffFeild == true)
		$this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name"];
		else
		$this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name", "visible" => false];

		$this->col[] = ["label" => "", "name" => "checked_for_update", "visible" => false];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE


		$this->form = [];
		$this->form[] = ['label' => trans('modules.transfer_number'), 'name' => 'voucher_number', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];

		$this->form[] = ['label' => trans('modules.account'), 'name' => 'debit', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $user->getAccountsIdsForVouchers()) . ')'];
		if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
			$this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS').') ' . $this->getDelegateCondition()];
		}
		else {
			$this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS').') ' . $this->getDelegateCondition()];
		}
		$this->form[] = ['label' => trans('modules.narration'), 'name' => 'narration', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.date'), 'name' => 'date', 'type' => 'datetime', 'value' => date('Y-m-d H:i:s', time()), 'validation' => 'required|date', 'width' => 'col-sm-10'];

		$this->form[] = ['label' => trans('modules.paid_currency'), 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'currencies,name_ar','datatable_where' =>'active=1'];
		$this->form[] = ['label' => trans('modules.paid_value'), 'name' => 'amount', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:1', 'width' => 'col-sm-10', 'value' => 0];
		$gfunc = new GeneralFunctionsController();
		$curr_enum_str = $gfunc->getActiveCurrenciesAsEnumString();
		$this->form[] = ['label' => trans('modules.opposite'), 'name' => 'opposite', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => "$curr_enum_str"];
		$this->form[] = ['label' => trans('modules.ex_rate'), 'name' => 'ex_rate', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:0.001', 'width' => 'col-sm-10', "help" => trans('help.payment_voucher_ex_rate_help'), 'value' => 1];

		$this->form[] = ['label' => trans('modules.equalizer'), 'name' => 'equalizer', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:1', 'width' => 'col-sm-10', 'value' => 0 ,'readonly'=>true];
		$columns[] = ['label' => trans('modules.image'), 'name' => 'file_id', 'type' => 'upload', 'required' => true, 'upload_type' => 'image'];
		$this->form[] = ['label' => trans('modules.add_image_en_ar'), 'name' => 'vouchers_files', 'type' => 'child', 'columns' => $columns, 'table' => 'vouchers_files', 'foreign_key' => 'voucher_id'];
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
		$gfunc = new GeneralFunctionsController();
        $hasPermission = $gfunc->checkOldCycleHasEditedPermission();

		$this->addaction = array();
		if (CRUDBooster::isSuperAdmin() && $hasPermission ) {
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/true/[id]'), 'icon' => 'fa fa-check', 'color' => 'success', 'title' => trans('modules.checked'), 'showIf' => "[checked_for_update] == '0'"];
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/false/[id]'), 'icon' => 'fa fa-ban', 'color' => 'warning', 'title' => trans('modules.remove_checked'), 'showIf' => "[checked_for_update] == '1'"];
			$this->button_edit = true;
		}
		$this->addaction[] = ['label' => '', 'url' => 'javascript:void(0);', 'icon' => 'fa fa-image', 'color' => 'info', 'title' => trans('messages.voucher_has_attach'), 'showIf' => "[attach] > 0"];

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
		if (CRUDBooster::isSuperAdmin() && $hasPermission ) {
			$this->button_selected[] = ['label' => trans('modules.checked'), 'icon' => 'fa fa-check', 'name' => 'set_checked'];
			$this->button_selected[] = ['label' => trans('modules.remove_checked'), 'icon' => 'fa fa-ban', 'name' => 'set_remove_checked'];
		}

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
		if(CRUDBooster::isColumnExists($this->table,'checked_for_update')){
            $this->table_row_color[] = ["condition" => "[checked_for_update]==1", "color" => "info checked"];
        }


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
		$this->script_js .=" 
			var  _BOX_BALANCE_NOT_ENOUGH_CURRENT_BALANCE_IS= '".trans('alert.box_balance_not_enough_current_balance_is')."';
			var  _VOUCHER_NUMBER_IS_USED= '".trans('alert.document_number_is_used')."';
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
		$this->load_js[] = asset("js/modules_js/vouchers/payment_voucher_script1.js");
		if (CRUDBooster::isSuperAdmin()) {
				$this->load_js[] = asset("js/modules_js/vouchers/payment_voucher_script2.js");
		}
		if (CRUDBooster::getCurrentMethod() != 'getEdit') {
				$this->load_js[] = asset("js/modules_js/vouchers/payment_voucher_script3.js");
		}



		/*
		 | ----------------------------------------------------------------------
		 | Add css style at body
		 | ----------------------------------------------------------------------
		 | css code in the variable
		 | $this->style_css = ".style{....}";
		 |
		 */
		$this->style_css = "
				.selected-action ul li:nth-child(1),
				.selected-action ul li:nth-child(2),
				.selected-action ul li:nth-child(3) {
					display: none !important;
				} 
				#form-group-ex_rate .help-block{
					color:#f39c12;
				}
			";
		if (!CRUDBooster::isSuperAdmin()) {
			$this->style_css .= "
					.selected-action {
						display: none !important;
					}
					tr.checked .btn-edit, tr.checked .btn-delete{
                        display:none;
                    }
				";
		}



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

	public function getSetStatus($status, $id)
	{
		if ($status == 'true')
			$status = true;
		elseif ($status == 'false')
			$status = false;


		Voucher::where('id', $id)->update(['checked_for_update' => $status]);

		//This will redirect back and gives a message
		if ($status) {
			CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.voucher_status_changed_and_delegate_cannot_have_permission_on_it'), "success");
		}
		else {
			CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.voucher_status_changed_and_delegate_has_permission_on_it'), "success");
		}
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
		if ($button_name == 'set_checked') {
			Voucher::whereIn('id', $id_selected)->update(['checked_for_update' => '1']);
		}
		if ($button_name == 'set_remove_checked') {
			Voucher::whereIn('id', $id_selected)->update(['checked_for_update' => '0']);
		}

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
        $user = CRUDBooster::getUser();

		if ($user->roleId == 4) { //delegate
			$query->where('delegate_id', $user->id);
		}

		if (in_array($user->roleId,[3,6])) { //sales manager & factory Delegate show all vouchers except vouchers build by admins or managers
            $query->whereNotIn('vouchers.staff_id',$this->getAdminsIds());
        }

		$query->where("voucher_type_id", 2);
		$query->where("action", NULL);
		$query->where("cycle_id", Session::get('display_cycle'));
		

		$query = $query->select('vouchers.id as id', DB::raw("(SELECT count(*) FROM vouchers_files
                                    WHERE vouchers_files.voucher_id = vouchers.id ) as attach "));
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
		if ($column_index == 8) {
			$column_value = number_format($column_value, 2);
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
		$this->checkVoucher($postdata, 'add', null, 2);

		$user = CRUDBooster::getUser();

		$max = Voucher::where("voucher_type_id", 2)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
		$prefixCode = VoucherType::where('id', 2)->select('prefix')->first();

		$postdata["code"] = ($max) ? $max + 1 : 1;
		$postdata['p_code'] = $prefixCode->prefix . '' . $postdata['code'];

		//check if p_code unique
		$this->checkVoucherP_Code($postdata['p_code']);

		$postdata['voucher_type_id'] = 2;
		$postdata["staff_id"] = CRUDBooster::myId();


		if ($user->hasBox == 'own') {
			$postdata['credit'] = $user->boxAccount;
		}
		else {
			$box_account_id = $this->getSystemConfigValue("General_Box");
			if ($box_account_id)
				$postdata['credit'] = $box_account_id;
		}
		//check credit box 
		$vfunc = new VouchersFunctionsController();
		$res = $vfunc->checkBoxBalance($postdata['currency_id'], $postdata['amount']);
		$result = $res->original;
		if ($result['res']) {
			CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.add_voucher_failed_because_credit_account_doesnot_have_enough_current_balance_is') . $result['sum'], "danger");
		}

		$postdata['create_by'] = CRUDBooster::myId();


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
			VoucherFile::where('file_id', null)->delete();

			$voucher = Voucher::find($id);
			$max = EntryBase::max('entry_number');
			$entry_number = $max + 1;

			$entry_base_id = EntryBase::insertGetId([
				'entry_number' => $entry_number,
				'narration' => $voucher->narration,
				'date' => $voucher->date,
				'voucher_id' => $id,
				'active' => 1,
				'cycle_id' => Session::get('display_cycle'),
				'create_by' => CRUDBooster::myId()

			]);
			//حساب قيمة المعادل التي سيتم حفظها بالقيود المالية
			$entries_equalizer = $this->calculateVoucherEntriesEqualizer($voucher->amount, $voucher->currency_id, $voucher->opposite);
			if ($voucher->currency_id != $voucher->opposite) {



				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $voucher->equalizer,
					'account_id' => $voucher->debit,
					'credit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->opposite,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => CRUDBooster::myId()

				]);

				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'credit' => $voucher->amount,
					'account_id' => $voucher->credit,
					'debit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => CRUDBooster::myId()

				]);
			}
			else {
				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $voucher->amount,
					'account_id' => $voucher->debit,
					'credit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => CRUDBooster::myId()

				]);

				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'credit' => $voucher->amount,
					'account_id' => $voucher->credit,
					'debit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => CRUDBooster::myId()

				]);
			}



			DB::commit();
		}

		catch (\Exception $e) {
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

		$this->checkVoucher($postdata, 'edit', $id, 2);

		$user = CRUDBooster::getUser();

		$postdata['voucher_type_id'] = 2;

		if ($user->hasBox == 'own') {
			$postdata['credit'] = $user->boxAccount;
		}
		else {
			$box_account_id = $this->getSystemConfigValue("General_Box");
			if ($box_account_id)
				$postdata['credit'] = $box_account_id;
		}

		//check credit box 
		$vfunc = new VouchersFunctionsController();
		$res = $vfunc->checkBoxBalance($postdata['currency_id'], $postdata['amount'], $id);
		$result = $res->original;
		if ($result['res']) {
			CRUDBooster::redirect(CRUDBooster::mainpath("edit/" . $id), trans('messages.add_voucher_failed_because_credit_account_doesnot_have_enough_current_balance_is') . $result['sum'], "danger");
		}

		$postdata['create_by'] = CRUDBooster::myId();


		//create new Voucher with another id and save old data to new record with delete_by delete_at
		//change forgin key in others tables voucher_id to new copy of Voucher with delete_by delete_at
		$this->makeVoucherAsDeleted($id);

		$postdata["edit_by"] = CRUDBooster::myId();
        $postdata["edit_at"] = date('Y-m-d H:i:s');

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
			VoucherFile::where('file_id', null)->delete();

			$voucher = Voucher::find($id);
			$max = EntryBase::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('entry_number');
			$entry_number = $max + 1;

			$entry_base_id = EntryBase::insertGetId([
				'entry_number' => $entry_number,
				'narration' => $voucher->narration,
				'date' => $voucher->date,
				'voucher_id' => $id,
				'active' => 1,
				'cycle_id' => Session::get('display_cycle'),
				'create_by' => $voucher->create_by

			]);
			//حساب قيمة المعادل التي ستحفظ بالقيود المالية
			$entries_equalizer = $this->calculateVoucherEntriesEqualizer($voucher->amount, $voucher->currency_id, $voucher->opposite);
			if ($voucher->currency_id != $voucher->opposite) {



				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $voucher->equalizer,
					'account_id' => $voucher->debit,
					'credit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->opposite,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => $voucher->create_by

				]);

				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'credit' => $voucher->amount,
					'account_id' => $voucher->credit,
					'debit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => $voucher->create_by

				]);
			}
			else {
				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'debit' => $voucher->amount,
					'account_id' => $voucher->debit,
					'credit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => $voucher->create_by

				]);

				Entry::insert([
					'entry_base_id' => $entry_base_id,
					'credit' => $voucher->amount,
					'account_id' => $voucher->credit,
					'debit' => null,
					'ex_rate' => $voucher->ex_rate,
					'equalizer' => $entries_equalizer,
					'opposite' => $voucher->opposite,
					'currency_id' => $voucher->currency_id,
					'cycle_id' => Session::get('display_cycle'),
					'create_by' => $voucher->create_by

				]);
			}



			DB::commit();
		}

		catch (\Exception $e) {
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

		return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.delete_voucher_success'), "success");

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
	public function getEdit($id)
	{
		$voucher = Voucher::find($id);
		if(!CRUDBooster::isManager() && ($voucher->delegate_id !== CRUDBooster::getUser()->id)){
			//check if role is factory cashier
            if(CRUDBooster::getUser()->roleId != 7 || ((CRUDBooster::getUser()->roleId == 7) && ($voucher->staff_id !== CRUDBooster::getUser()->id)))
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_update_permission_on_other_delegate_voucher'), "warning");
        }
		if (!CRUDBooster::isSuperadmin() && $voucher->checked_for_update == 1) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_edit_permission_on_this_voucher'), "warning");
		}
		return parent::getEdit($id); // TODO: Change the autogenerated stub
	}

	public function getDelete($id)
	{
		$voucher = Voucher::find($id);
		if(!CRUDBooster::isManager() && ($voucher->delegate_id !== CRUDBooster::getUser()->id)){
            //check if role is factory cashier
            if(CRUDBooster::getUser()->roleId != 7 || ((CRUDBooster::getUser()->roleId == 7) && ($voucher->staff_id !== CRUDBooster::getUser()->id)))
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_delete_permission_on_other_delegate_voucher'), "warning");
        }
		if (!CRUDBooster::isSuperadmin() && $voucher->checked_for_update == 1) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_delete_permision_on_this_voucher'), "warning");
		}
		return parent::getDelete($id); // TODO: Change the autogenerated stub
	}


}
