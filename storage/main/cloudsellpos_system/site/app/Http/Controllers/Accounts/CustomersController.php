<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Accounts\Account;
use Request;
use DB;
use CRUDBooster;
use App\Traits\GeneralTrait;
use App\Traits\ImportDataTrait;
use App\Http\Controllers\Data\ImportController;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Entries\Entry;

class CustomersController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait,ImportDataTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "first_name_en";
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
		$this->table = "persons";
		# END CONFIGURATION DO NOT REMOVE THIS LINE
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => trans('modules.code'), "name" => "code"];
		$this->col[] = ["label" => trans('modules.name_ar'), "name" => "name_ar"];
		$this->col[] = ["label" => trans('modules.email'), "name" => "email"];
		$this->col[] = ["label" => trans('modules.phone_number'), "name" => "phone_number"];
		$this->col[] = ["label" => trans('modules.account'), "name" => "account_id", "join" => "accounts,name_ar"];
		$this->col[] = ["label" => trans('modules.delegate'), "name" => "delegate_id", "join" => "cms_users,name"];
		# END COLUMNS DO NOT REMOVE THIS LINE
		$user = CRUDBooster::getUser();
		# START FORM DO NOT REMOVE THIS LINE 
		$this->form = [];
		$this->form[] = ['label' => trans('modules.name_en'), 'name' => 'name_en', 'type' => 'text', 'validation' => 'unique:persons,name_en', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.name_ar'), 'name' => 'name_ar', 'type' => 'text', 'validation' => 'required|unique:persons,name_ar', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.email'), 'name' => 'email', 'type' => 'email', 'width' => 'col-sm-10', 'help' => trans('help.email_help')];
		$this->form[] = ['label' => trans('modules.phone_number'), 'name' => 'phone_number', 'type' => 'number', 'validation' => 'required', 'width' => 'col-sm-10', 'help' => trans('help.can_enter_just_numbers')];
		if (!in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) { 
			$this->form[] = ['label' => trans('modules.parent_account'), 'name' => 'account_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification=1 and parent_id = ' . $this->getSystemConfigValue('Customers_Account'), 'help' => trans('help.customer_parent_account_help')];
		}

		//$this->form[] = ['label'=>trans('modules.type'),'name'=>'person_type_id','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'person_type,name_ar'];
		$this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'width' => 'col-sm-10', 'validation' => 'required', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS').') ' . $this->getDelegateCondition()];

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

		if (CRUDBooster::getCurrentMethod() == 'getIndex' && CRUDBooster::isCreate() == true) {
			$this->alert[] = ['message' => trans('messages.customers_info_note'), 'type' => 'info'];
		}

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
				var  _NUM_PHONE_NUMBER_CHARACTERS_LEAST_THAN_DEFAULT= '".trans('alert.num_phone_number_characters_least_than_default')."';
                var _NUM_PHONE_NUMBER_CHARACTERS_MORE_THAN_DEFAULT = '".trans('alert.num_phone_number_characters_more_than_default')."';
				var  _NUM_PHONE_NUMBER_CHARACTERS_CORRECT= '".trans('alert.num_phone_number_characters_correct')."';
		";
		$this->script_js .="
			$('#name_en').change(function(){
				$(this).val($(this).val().trim());
			});
			$('#name_ar').change(function(){
				$(this).val($(this).val().trim());
			});

			$('#phone_number').keyup(function(){
				let phone_number = $('#phone_number').val(); 
				if(phone_number.length < 7 ){
					$('#form-group-phone_number div .text-danger').css('color','#a94442');
					$('#form-group-phone_number div .text-danger').html(_NUM_PHONE_NUMBER_CHARACTERS_LEAST_THAN_DEFAULT);
					$('#btn-save-data').attr('disabled',true);
					$('#btn-save-more').attr('disabled',true);
				}else if(phone_number.length > 10 ){
					$('#form-group-phone_number div .text-danger').css('color','#a94442');
					$('#form-group-phone_number div .text-danger').html(_NUM_PHONE_NUMBER_CHARACTERS_MORE_THAN_DEFAULT);
					$('#btn-save-data').attr('disabled',true);
					$('#btn-save-more').attr('disabled',true);
				}else{
					$('#form-group-phone_number div .text-danger').html(_NUM_PHONE_NUMBER_CHARACTERS_CORRECT); 
					$('#form-group-phone_number div .text-danger').css('color','#00a65a');
					$('#btn-save-data').attr('disabled',false);
					$('#btn-save-more').attr('disabled',false);
				}  
			});
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
		$this->load_js[] = asset("js/modules_js/accounts/customers_script.js");



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
		if (!CRUDBooster::isManager()) {
			$this->style_css .= "
					#form-group-delegate_id{
						cursor:not-allowed;
					}
					#form-group-delegate_id div {
						pointer-events: none;
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
		if ($user->showCustomersStatus == 'own') {
			$query->where('delegate_id', $user->id);
		}

		$query->where('person_type_id', 1);
		if (!Request::get('filter_column')) {
			$query->orderBy('id', 'DESC');
		}
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
	
		//check if package config allow to add New Customer/Supplier
		$avilableClientsNum = $this->getPackageConfigValue('clients_num');
		$clients_now = Person::get();
		if ($avilableClientsNum > 0 && count($clients_now) + 1 > $avilableClientsNum) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.connot_add_new_client_allwed_count_is')." $avilableClientsNum", "warning");
		}

		DB::beginTransaction();
		try {
			//عند الدخول كحساب مندوب نقوم بإضافة الزبائن ضمن حساب زبائنه ديناميكيا
			if ($postdata['account_id'] == null) {
				$postdata['account_id'] = CRUDBooster::getUser()->customersAccountId;
			}

			$code = Account::getCode($postdata['account_id']);

			$accountId = Account::insertGetId([
				'name_en' => $postdata['name_en'],
				'name_ar' => $postdata['name_ar'],
				'code' => $code,
				'parent_id' => $postdata['account_id'],
				'major_classification' => 0,
				"active" => 1

			]);

			$postdata['person_type_id'] = 1;
			$postdata['account_id'] = $accountId;
			$postdata['code'] = $code;
			DB::commit();

		}
		catch (Exception $e) {
			DB::rollback();
		}
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
		$customer_account_id = Person::where('id', $id)->first()->account_id;

		$user = CRUDBooster::getUser();
		if (!in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
			$parent_id = $postdata['account_id'];
			//change parent_id and code for supplier account
			$code = Account::getCode($parent_id);
			Account::where('id', $customer_account_id)->update([
				"name_ar" => $postdata['name_ar'],
				"name_en" => $postdata['name_en'],
				"parent_id" => $parent_id,
				"code" => $code
			]);
		}

		$postdata['account_id'] = $customer_account_id;

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

		$person = Person::where("id", $id)->first();
		$account_id = $person->account_id;
		$res = Entry::where("account_id", $account_id)->get();
		if ($res->count() > 0) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.no_delete_customer_has_entries'), "warning");
		}
		else {
			//delete this person and delete his account 
			Account::where("id", $account_id)->delete();
		}

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



	public function getCustomers_account_id($id)
	{
		$customers_account_id = User::where('id', $id)->first()->customers_account_id;
		return $customers_account_id;
	}
	public function getDelegate_id($customers_account_id)
	{
		$id = User::where('customers_account_id', $customers_account_id)->first()->id;
		return $id;
	}

	//importing data methods in ImportDataTraits

}