<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Currencies;

use Request;
use DB;
use App\Models\Accounts\Account;
use CRUDBooster;
use crocodicstudio_voila\crudbooster\fonts\Fontawesome;
use App\Traits\GeneralTrait;
use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Currencies\Currency;
use App\Models\Currencies\CurrencyHistory;
use App\Models\Entries\Entry;
use App\Models\SystemConfigration\StatisticSetting;

class CurrenciesController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "name_en";
		$this->limit = "20";
		$this->orderby = "id,asc";
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
		$this->table = "currencies";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => trans('modules.name_ar'), "name" => "name_ar"];
		$this->col[] = ["label" => trans('modules.code'), "name" => "code"];
		$this->col[] = ["label" => trans('modules.account'), "name" => "account_id", "join" => "accounts,name_ar"];
		$this->col[] = ["label" => trans('modules.ex_rate'), "name" => "ex_rate"];
		$this->col[] = ["label" => trans('modules.is_major'), "name" => "is_major"];
		$this->col[] = ["label" => trans('modules.is_used'), "name" => "active"];


		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => trans('modules.name_en'), 'name' => 'name_en', 'type' => 'text', 'validation' => 'required|unique:currencies,name_en', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.name_ar'), 'name' => 'name_ar', 'type' => 'text', 'validation' => 'required|unique:currencies,name_ar', 'width' => 'col-sm-10'];
		//SYP|SYP;USD|USD;EUR|EUR;SAR|SAR;EGP|EGP;KWD|KWD;QAR|QAR
		$currencies_codes = array('SYP|'.trans('modules.SYP'), 'USD|'.trans('modules.USD'), 'EUR|'.trans('modules.EUR'), 'SAR|'.trans('modules.SAR'), 'EGP|'.trans('modules.EGP'), 'KWD|'.trans('modules.KWD'), 'QAR|'.trans('modules.QAR'));
		$this->form[] = ['label' => trans('modules.code'), 'name' => 'code', 'type' => 'select', 'validation' => 'required|unique:currencies,code', 'width' => 'col-sm-10', 'dataenum' => '' . implode(';', $currencies_codes) . ''];

		if (CRUDBooster::getCurrentMethod() == 'getEdit') {
			$this->form[] = ['label' => trans('modules.box_account'), 'name' => 'account_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification=0 and parent_id = ' . $this->getSystemConfigValue('Currencies_Parent_Account')];
		}

		$this->form[] = ['label' => trans('modules.is_used'), 'name' => 'active', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '1|'.trans('modules.yes').';0|'.trans('modules.no'), 'value' => 1];
		$this->form[] = ['label' => trans('modules.ex_rate'), 'name' => 'ex_rate', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:0.01', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.is_this_currency_major'), 'name' => 'is_major', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '1|'.trans('modules.yes').';0|'.trans('modules.no'), 'value' => 0];
		$this->form[] = ['label' => trans('modules.notes'), 'name' => 'note', 'type' => 'textarea', 'width' => 'col-sm-10'];

		$fontawesome = Fontawesome::getIcons();
		$custom = view('crudbooster::components.list_icon', compact('fontawesome', 'row'))->render();
		$this->form[] = ['label' => trans('modules.icon'), 'name' => 'icon', 'type' => 'custom', 'html' => $custom, 'required' => true];
		$this->form[] = [
			'label' => trans('modules.color'),
			'name' => 'color',
			'type' => 'select2',
			'dataenum' => ['red', 'green', 'aqua', 'light-blue', 'yellow'],
			'required' => true,
			'value' => 'red',
		];
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
		$this->table_row_color[] = ["condition" => "[is_major]==1", "color" => "major"];

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
		$this->script_js = "
				$('#name_en').change(function(){
					$(this).val($(this).val().trim());
				});
				$('#name_ar').change(function(){
					$(this).val($(this).val().trim());
				});
		";
		if (CRUDBooster::getCurrentMethod() != 'getIndex') {
			$this->script_js .= "
				$(function() {
					function format(icon) {          
						var originalOption = icon.element;
						var label = $(originalOption).text();
						var val = $(originalOption).val();
						if(!val) return label;
						var \$resp = $('<span><i style=\"margin-top:5px\" class=\"pull-right ' + $(originalOption).val() + '\"></i> ' + $(originalOption).data('label') + '</span>');
						return \$resp;
					}
					$('#list-icon').select2({
						width: \"100%\",
						templateResult: format,
						templateSelection: format
					});
					$('#list-icon').attr('required','true');
	
				});
				";
		}


		if (CRUDBooster::getCurrentMethod() == 'getEdit') {
			$id = Request::segment(4);
			$icon = Currency::where('id', $id)->first()->icon;
			$this->script_js .= "
					$('#list-icon').val('$icon').change();
				";
		}

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
				tr.major .btn-delete{
					display:none;
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
		if ($column_index == 5) {
			if ($column_value == '1') {
				$column_value = trans('crudbooster.Yes');
			}
			else {
				$column_value = trans('crudbooster.No');
			}
		}

		if ($column_index == 6 && !CRUDBooster::isSuperAdmin()) {
			$column_value = '';
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

		$avilableCurrenciesNum = $this->getPackageConfigValue('currencies_num');
		//check if package config allow to add currency
		$currencies_now = Currency::get();
		if ($avilableCurrenciesNum > 0 && count($currencies_now) + 1 > $avilableCurrenciesNum) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.connot_add_new_currency_allwed_count_is')."$avilableCurrenciesNum", "warning");
		}

		$gfunc = new GeneralFunctionsController();
		$majorCurrency = $gfunc->getMajorCurrency();
		$res = Entry::get();
		if ($majorCurrency != null && $postdata['is_major'] == 1 && count($res) > 0) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.connot_make_currency_is_major_it_has_entries'), "warning");
		}

		if ($postdata['is_major'] == 1 && $postdata['active'] == 0 ) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.cannot_make_currency_major_and_not_used'), "warning");
		}

		if ($postdata['is_major'] == 1 && $postdata['ex_rate'] != 1 ) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.must_ex_rate_for_currency_major_equal_one'), "warning");
		}

		$postdata['account_id'] = $this->getSystemConfigValue("General_Box");


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
		//dd($postdata);
		$currency = Currency::find($id);
		if ($currency->is_major) {
			Currency::where('id', '!=', $id)->update(['is_major' => false]);
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

		$curr = Currency::find($id);
		//check if excist entries
		$res = Entry::get();
		if (count($res) > 0 && $postdata['is_major'] == 1 && $curr->is_major == 0) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.connot_make_currency_major'), "warning");
		}

		//make major currency as not major
		if ($postdata['is_major'] == 0 && $curr->is_major == 1) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.connot_make_currency_not_major'), "warning");
		}

		if ($postdata['is_major'] == 1 && $postdata['active'] == 0 ) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.cannot_make_currency_major_and_not_used'), "warning");
		
		}

		if ($postdata['is_major'] == 1 && $postdata['ex_rate'] != 1 ) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.must_ex_rate_for_currency_major_equal_one'), "warning");
		}
		
		$res2 = Entry::where('currency_id', $id)->get();
		if ($postdata['active'] == 0 && (count($res2) > 0)) {
			return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.connot_make_currency_isnot_used'), "warning");
		}

		$curr_ex_rate = Currency::where('id', $id)->first()->ex_rate;
		if ($curr_ex_rate != $postdata['ex_rate']) {
			CurrencyHistory::insert([
				'currency_id' => $id,
				'ex_rate' => $postdata['ex_rate'],
				'edit_by' => CRUDBooster::myId(),
			]);
		}

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
		$currency = Currency::find($id);

		if ($currency->is_major) {
			Currency::where('id', '!=', $id)->update(['is_major' => false]);
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
		$curr = Currency::find($id);
		$is_major = $curr->is_major;


		$res = Entry::where("currency_id", $id)->get();
		if ($res->count() > 0) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.canot_delete_this_currency'), "warning");
		}
		elseif ($is_major == 1) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.canot_delete_this_currency_is_major'), "warning");
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
