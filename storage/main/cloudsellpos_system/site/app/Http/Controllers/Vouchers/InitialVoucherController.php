<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Vouchers;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\SystemConfigration\SystemSetting;
use App\Traits\AccountsTrait;
use App\Traits\VouchersTrait;
use Session;
use Illuminate\Support\Facades\Request;
use DB;
use CRUDBooster;
use App\Models\Accounts\Account;
use App\Traits\GeneralTrait;
use App\Traits\ImportDataTrait;
use App\Http\Controllers\Data\ImportController;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Currencies\Currency;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\Vouchers\Voucher;
use App\Models\Vouchers\VoucherType;
use App\Models\Vouchers\VoucherFile;
use App\Models\Vouchers\InitialVouchersGroup;
use App\Models\Vouchers\InitialVouchersList;

class InitialVoucherController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait,ImportDataTrait,VouchersTrait,AccountsTrait;
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
		$this->table = "initial_vouchers_groups";
		# END CONFIGURATION DO NOT REMOVE THIS LINE
		

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => trans('modules.voucher_number'), "name" => "voucher_number"];
		$this->col[] = ["label" => trans('modules.date'), "name" => "date"];
		$this->col[] = ["label" => trans('modules.narration'), "name" => "narration"];
		$this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$user = CRUDBooster::getUser();
		$this->form = [];
		$this->form[] = ['label' => trans('modules.transfer_number'), 'name' => 'voucher_number', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.narration'), 'name' => 'narration', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.date'), 'name' => 'date', 'type' => 'datetime', 'value' => date('Y-m-d H:i:s', time()), 'validation' => 'required|date', 'width' => 'col-sm-10'];
		
		
		$columns[] = ['label' => trans('modules.account'), 'name' => 'account_id', 'type' => 'select', 'required' => true , 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $user->getAccountsIdsForVouchers()) . ')'];
		$columns[] = ['label' => trans('modules.currency'), 'name' => 'currency_id', 'type' => 'select', 'required' => true,  'datatable' => 'currencies,name_ar','datatable_where' =>'active=1'];
		$columns[] = ['label' => trans('modules.voucher_amount'), 'name' => 'amount', 'type' => 'number',  'required' => true];
		$this->form[] = ['label' => trans('modules.add_to_vouchers_ar_en'), 'name' => 'initial_vouchers_list', 'type' => 'child','validation' => 'required', 'columns' => $columns, 'table' => 'initial_vouchers_list', 'foreign_key' => 'iv_group_id'];
			
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
		$gfunc = new GeneralFunctionsController();
        $hasPermission = $gfunc->checkOldCycleHasEditedPermission(); //when display old cycles hasPermission = false execipt last cycle hasPermission = true 
		if (CRUDBooster::getCurrentMethod() == 'getIndex' && CRUDBooster::isSuperAdmin() && $hasPermission) {
			$this->index_button[] = ['label' => trans('modules.import_data'), 'url' => CRUDBooster::mainpath("import-data-form"), "icon" => "fa fa-download"];
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
		$this->script_js = "";
		$this->script_js .=" 
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
		$this->load_js[] = asset("js/modules_js/vouchers/initial_voucher_script.js");


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
		$user = CRUDBooster::getUser();
		if(!CRUDBooster::isManager()){
			$query->where('staff_id', $user->id);
		}
		$query->where('cycle_id', Session::get('display_cycle'));
		
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
		$postdata["staff_id"] = CRUDBooster::myId();
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
			$iv_group = InitialVouchersGroup::find($id);
			$iv_group_list = InitialVouchersList::where('iv_group_id', $iv_group->id)->get();
			//dd($iv_group_list);
			foreach($iv_group_list as $iv){
				// $this->checkVoucher($postdata, 'add', null, 4);
					

				$max = Voucher::where("voucher_type_id", 4)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
				$prefixCode = VoucherType::where('id', 4)->select('prefix')->first();

				$maxCode = ($max) ? $max + 1 : 1;
				$p_code = $prefixCode->prefix . '' . $maxCode;
				
				// //check if p_code unique
				// $this->checkVoucherP_Code($postdata['p_code']);
				$voucher_type_id = 4;
				$staff_id = CRUDBooster::myId();

				if ($iv["amount"] < 0) {
					$iv["credit"] = $iv["account_id"];
					$iv["debit"] = 0;
				}
				else {
					$iv["credit"] = 0;
					$iv["debit"] = $iv["account_id"];
				}
				$iv["orginal_amount"] =$iv["amount"]; 
				$iv["amount"] = abs($iv["amount"]);

				$ex_rate = Currency::where('id', $iv["currency_id"])->first()->ex_rate;
				$iv["ex_rate"] = $ex_rate;
				$iv["equalizer"] = $iv["amount"] * $ex_rate;

				// unset($postdata["account"]);

				$iv['create_by'] = CRUDBooster::myId();
				
					VoucherFile::where('file_id', null)->delete();
				    $voucher_id = Voucher::insertGetId(
						['code' => $maxCode, 'p_code' =>$p_code ,
						'voucher_type_id'=>$voucher_type_id,
						'debit'=>$iv["debit"],'credit'=>$iv['credit'],
						'staff_id'=>$staff_id ,'narration' =>trans('modules.initial_voucher'),
						'date'=>$iv_group->date,'currency_id'=>$iv['currency_id'],
						'amount'=>$iv['amount'],'ex_rate'=>$iv['ex_rate'],
						'equalizer'=>$iv['equalizer'],
						'create_by'=>$iv['create_by'],
						'cycle_id' => Session::get('display_cycle')
						]
					);
					$voucher = Voucher::find($voucher_id);
					$max = EntryBase::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('entry_number');
					$entry_number = $max + 1;

					$entry_base_id = EntryBase::insertGetId([
						'entry_number' => $entry_number,
						'narration' => $voucher->narration,
						'date' => $voucher->date,
						'voucher_id' => $voucher->id,
						'active' => 1,
						'cycle_id' => Session::get('display_cycle'),
						'create_by' => CRUDBooster::myId()

					]);

					if ($voucher->debit == 0) {
						$entry = Entry::insert([
							'entry_base_id' => $entry_base_id,
							'debit' => null,
							'account_id' => $voucher->credit,
							'credit' => $voucher->amount,
							'ex_rate' => $voucher->ex_rate,
							'equalizer' => $voucher->equalizer,
							'opposite' => $voucher->opposite,
							'currency_id' => $voucher->currency_id,
							'cycle_id' => Session::get('display_cycle'),
							'create_by' => CRUDBooster::myId()
						]);
					}
					else {
						$entry = Entry::insert([
							'entry_base_id' => $entry_base_id,
							'debit' => $voucher->amount,
							'account_id' => $voucher->debit,
							'credit' => null,
							'ex_rate' => $voucher->ex_rate,
							'equalizer' => $voucher->equalizer,
							'opposite' => $voucher->opposite,
							'currency_id' => $voucher->currency_id,
							'cycle_id' => Session::get('display_cycle'),
							'create_by' => CRUDBooster::myId()
						]);
					}

					InitialVouchersList::where('id',$iv['id'])->update([
						'amount' => $iv['orginal_amount'],
						'p_code' =>$p_code,
						'cycle_id' => Session::get('display_cycle') 
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
		
		$postdata["staff_id"] = CRUDBooster::myId();

		$iv_group = InitialVouchersGroup::find($id);
		$iv_group_list = InitialVouchersList::where('iv_group_id', $iv_group->id)->get();
		//dd($iv_group_list);
		foreach($iv_group_list as $iv){
			$voucher = Voucher::where('p_code',$iv->p_code)->where('cycle_id', Session::get('display_cycle'))->first();
			$entry_base = EntryBase::where('voucher_id',$voucher->id)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->first();
			Entry::where('entry_base_id',$entry_base->id)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->delete();
			$entry_base->delete();
			$voucher->delete();
		}
		InitialVouchersList::where('iv_group_id',$iv_group->id)->delete();

		InitialVouchersGroup::where('id',$id)->update([
			'voucher_number' => $postdata['voucher_number'],
			'narration' => $postdata['narration'],
			'date'=>$postdata['date'],
			'staff_id'=>$postdata['staff_id']
			]);

		$allRequestData = Request::all();
		//dd($allRequestData);
		$accountsIds = $allRequestData['adfelalsndat-account_id'];
		$currenciesIds = $allRequestData['adfelalsndat-currency_id'];
		$amounts = $allRequestData['adfelalsndat-amount'];
		$ivouchers_info = array();
		foreach($accountsIds as $key => $account_id){
			$ivouchers_info[$key] = array(
									'account_id'=>$accountsIds[$key],
									'currency_id'=>$currenciesIds[$key],
									'amount' => $amounts[$key]
								);
		}

		//dd($ivouchers_info);
		foreach($ivouchers_info as $iv){
				$max = Voucher::where("voucher_type_id", 4)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
				$prefixCode = VoucherType::where('id', 4)->select('prefix')->first();

				$maxCode = ($max) ? $max + 1 : 1;
				$p_code = $prefixCode->prefix . '' . $maxCode;
				
				// //check if p_code unique
				// $this->checkVoucherP_Code($postdata['p_code']);
				$voucher_type_id = 4;
				$staff_id = CRUDBooster::myId();

				if ($iv["amount"] < 0) {
					$iv["credit"] = $iv["account_id"];
					$iv["debit"] = 0;
				}
				else {
					$iv["credit"] = 0;
					$iv["debit"] = $iv["account_id"];
				}

				$iv["orginal_amount"] =$iv["amount"]; 
				$iv["amount"] = abs($iv["amount"]);

				$ex_rate = Currency::where('id', $iv["currency_id"])->first()->ex_rate;
				$iv["ex_rate"] = $ex_rate;
				$iv["equalizer"] = $iv["amount"] * $ex_rate;

				// unset($postdata["account"]);

				$iv['create_by'] = CRUDBooster::myId();
				
					VoucherFile::where('file_id', null)->delete();
				    $voucher_id = Voucher::insertGetId(
						['code' => $maxCode, 'p_code' =>$p_code,
						'voucher_type_id'=>$voucher_type_id,
						'debit'=>$iv["debit"],'credit'=>$iv['credit'],
						'staff_id'=>$staff_id ,'narration' =>trans('modules.initial_voucher'),
						'date'=>$iv_group->date,'currency_id'=>$iv['currency_id'],
						'amount'=>$iv['amount'],'ex_rate'=>$iv['ex_rate'],
						'equalizer'=>$iv['equalizer'],
						'create_by'=>$iv['create_by'],
						'cycle_id' => Session::get('display_cycle')
						]
					);
					$voucher = Voucher::find($voucher_id);
					$max = EntryBase::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('entry_number');
					$entry_number = $max + 1;

					$entry_base_id = EntryBase::insertGetId([
						'entry_number' => $entry_number,
						'narration' => $voucher->narration,
						'date' => $voucher->date,
						'voucher_id' => $voucher->id,
						'active' => 1,
						'cycle_id' => Session::get('display_cycle'),
						'create_by' => CRUDBooster::myId()

					]);

					if ($voucher->debit == 0) {
						$entry = Entry::insert([
							'entry_base_id' => $entry_base_id,
							'debit' => null,
							'account_id' => $voucher->credit,
							'credit' => $voucher->amount,
							'ex_rate' => $voucher->ex_rate,
							'equalizer' => $voucher->equalizer,
							'opposite' => $voucher->opposite,
							'currency_id' => $voucher->currency_id,
							'cycle_id' => Session::get('display_cycle'),
							'create_by' => CRUDBooster::myId()
						]);
					}
					else {
						$entry = Entry::insert([
							'entry_base_id' => $entry_base_id,
							'debit' => $voucher->amount,
							'account_id' => $voucher->debit,
							'credit' => null,
							'ex_rate' => $voucher->ex_rate,
							'equalizer' => $voucher->equalizer,
							'opposite' => $voucher->opposite,
							'currency_id' => $voucher->currency_id,
							'cycle_id' => Session::get('display_cycle'),
							'create_by' => CRUDBooster::myId()
						]);
					}

					InitialVouchersList::insertGetId([
						'iv_group_id' => $iv_group->id,
						'account_id' => $iv['account_id'],
						'currency_id' => $iv['currency_id'],
						'amount' => $iv['orginal_amount'],
						'p_code' => $p_code,
						'cycle_id' => Session::get('display_cycle')
					]);
					
		}


		//change old_cycle_edited setting
        if(Session::get('display_cycle') != Session::get('current_cycle')){
            SystemSetting::where('setting_key', 'old_cycle_edited')->update([
                'setting_value'=>'true'
            ]);

            SystemSetting::where('setting_key', 'old_cycle_edited_id')->update([
                'setting_value'=>Session::get('display_cycle')
            ]);
        }
		
		return CRUDBooster::redirect(CRUDBooster::mainpath(""),trans('messages.edit_data_success'),"success");
		

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
		$ivouchers = InitialVouchersList::where('iv_group_id', $id)->get();
		foreach($ivouchers as $iv){
			$voucher = Voucher::where('p_code',$iv->p_code)->where('cycle_id', Session::get('display_cycle'))->first();
			$entry_base = EntryBase::where('voucher_id',$voucher->id)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->first();
			Entry::where('entry_base_id',$entry_base->id)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->delete();
			$entry_base->delete();
			$voucher->delete();
			$iv->delete();
		}
		InitialVouchersGroup::where('id',$id)->delete();

		//change old_cycle_edited setting
        if(Session::get('display_cycle') != Session::get('current_cycle')){
            SystemSetting::where('setting_key', 'old_cycle_edited')->update([
                'setting_value'=>'true'
            ]);

            SystemSetting::where('setting_key', 'old_cycle_edited_id')->update([
                'setting_value'=>Session::get('display_cycle')
            ]);
        }
		return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.delete_vouchers_success'), "success");
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

	//importing data methods in ImportDataTraits
	
}