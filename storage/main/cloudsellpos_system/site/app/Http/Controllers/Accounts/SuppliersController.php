<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Accounts;

use App\Models\Accounts\Account;
use App\Traits\GeneralTrait;
use Request;
use DB;
use CRUDBooster;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Entries\Entry;
use App\Models\Accounts\Supplier;

class SuppliersController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait;
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
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => trans('modules.name_en'), 'name' => 'name_en', 'type' => 'text', 'validation' => 'unique:persons,name_en', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.name_ar'), 'name' => 'name_ar', 'type' => 'text', 'validation' => 'required|unique:persons,name_ar', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.email'), 'name' => 'email', 'type' => 'email', 'width' => 'col-sm-10', 'help' => trans('help.email_help')];
		$this->form[] = ['label' => trans('modules.phone_number'), 'name' => 'phone_number', 'type' => 'number', 'validation' => 'required', 'width' => 'col-sm-10', 'help' => trans('help.can_enter_just_numbers')];
		
		if(CRUDBooster::isManager()){
			$this->form[] = ['label' => trans('modules.parent_account'), 'name' => 'account_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification=1'];
		
			$id = CRUDBooster::getCurrentId();
			$method = CRUDBooster::getCurrentMethod();
			$custom_select = view('custom.multi_supplier_delegates_select', ['id' => $id, 'method' => $method])->render();
			$this->form[] = ["label" => trans('crudbooster.Delegates'), "name" => "supplier_delegates", "type" => "custom", "html" => $custom_select];
		}
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

		if (CRUDBooster::isSuperAdmin() && CRUDBooster::getCurrentMethod() == 'getIndex') {
			$this->alert[] = ['message' => trans('messages.suppliers_info_note'), 'type' => 'info'];
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
		$this->load_js[] = asset("js/modules_js/accounts/suppliers_script.js");


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
				#form-group-account_id,
				#form-group-supplier_delegates{
					cursor:not-allowed;
				}
				#form-group-account_id div,
				#form-group-supplier_delegates div {
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
		
		if (in_array($user->roleId,[3,4])) { //delegate , sales manager
			$query->join('suppliers_delegates', 'suppliers_delegates.supplier_id', 'persons.id')
				->where('suppliers_delegates.delegate_id', $user->id);
		}
		$query->where('person_type_id', '2');
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

		$user = CRUDBooster::getUser();
		if(!$postdata['account_id']){
			$postdata['account_id'] = 18;
		}
		if($user->roleId == 3){ //sales manager
			$postdata['supplier_delegates'] = [$user->id];
		}
		//dd($postdata);

		DB::beginTransaction();
		try {
			$code = Account::getCode($postdata['account_id']);

			$accountId = Account::insertGetId([
				'name_en' => $postdata['name_en'],
				'name_ar' => $postdata['name_ar'],
				'code' => $code,
				'parent_id' => $postdata['account_id'],
				'major_classification' => 0,
				"active" => 1

			]);


			$postdata['person_type_id'] = 2;
			$postdata['account_id'] = $accountId;
			$postdata['code'] = $code;
			DB::commit();

		}
		catch (Exception $e) {
			DB::rollback();
		}

		$delegates = $postdata['supplier_delegates'];
		session()->put("delegates", $delegates);

		unset($postdata['supplier_delegates']);
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

		$delegates = session("delegates");

		
		if ($delegates == "") {$delegates = array();}
		//add Inventory Delegates
		$supplier=Supplier::where('id', $id)->first();
		$supplier->delegates()->sync($delegates); //remove old and add new delegates

		session()->forget("delegates");


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

		if(!CRUDBooster::isManager()){ //sales manager
			$supplier=Supplier::where('id', $id)->first();
			if($supplier->delegates()->count() > 1){
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.no_edit_supplier_because_he_has_many_delegates'), "warning");
			}
		}

		$supplier_account_id = Person::where('id', $id)->first()->account_id;
		if(CRUDBooster::isManager()){

			$parent_id = $postdata['account_id'];
			$code = Account::getCode($parent_id);
			//change parent_id and code for supplier account
			Account::where('id', $supplier_account_id)->update([
				"parent_id" => $parent_id,
				"code" => $code
			]);

			$postdata['account_id'] = $supplier_account_id;

			//change relationship between inventories and delegates
			$supplier_id = session("supplier_id");
			$delegates = $postdata['supplier_delegates'];
			DB::beginTransaction();
			try {
				
				if ($delegates == "") {$delegates = array();}
				//edit Inventory Delegates
				$supplier=Supplier::where('id', $supplier_id)->first();
				$supplier->delegates()->sync($delegates); //remove old and add new delegates
				DB::commit();

			}
			catch (Exception $e) {
				DB::rollback();
			}


			unset($postdata['supplier_delegates']);
		}

		Account::where('id', $supplier_account_id)->update([
			"name_ar" => $postdata['name_ar'],
			"name_en" => $postdata['name_en']
		]);


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
		$supplier=Supplier::where('id',$id)->first();
		if ($supplier->entries->count() > 0) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.no_delete_supplier_has_entries'), "warning");
		}else if($supplier->delegates->count() > 1){
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.no_delete_supplier_because_he_has_many_delegates'), "warning");
		}
		else {
			//delete this person and delete his account
			$supplier->delegates()->sync(array()); //remove records in suppliers_delegates
			$supplier->account()->delete();

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



//By the way, you can still create your own method in here... :)


}