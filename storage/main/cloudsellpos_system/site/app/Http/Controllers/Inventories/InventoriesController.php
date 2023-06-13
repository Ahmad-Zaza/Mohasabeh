<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Inventories;

use App\Models\Users\GeneralDelegate;
use Request;
use DB;
use CRUDBooster;
use App\Models\Inventories\Inventory;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\GeneralTrait;
use App\Traits\ImportDataTrait;
use App\Http\Controllers\Data\ImportController;
use App\Models\Users\User;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Users\Delegate;


class InventoriesController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use GeneralTrait,ImportDataTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "name_en";
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
		$this->table = "inventories";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => trans('modules.name_en'), "name" => "name_en"];
		$this->col[] = ["label" => trans('modules.name_ar'), "name" => "name_ar"];
		$this->col[] = ["label" => trans('modules.code'), "name" => "code"];
		$this->col[] = ["label" => trans('modules.delegate'), "name" => "delegate_id"];
		$this->col[] = ["label" => trans('modules.parent_category'), "name" => "parent_id", "join" => "inventories,name_ar"];
		$this->col[] = ["label" => trans('modules.major_classification'), "name" => "major_classification"];
		$this->col[] = ["label" => trans('modules.notes'), "name" => "note"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => trans('modules.name_en'), 'name' => 'name_en', 'type' => 'text', 'validation' => 'unique:inventories,name_en', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.name_ar'), 'name' => 'name_ar', 'type' => 'text', 'validation' => 'required|unique:inventories,name_ar', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.code'), 'name' => 'code', 'type' => 'number', 'width' => 'col-sm-10', 'validation' => 'unique:inventories,code', 'help' => trans('help.inventory_code_generated_if_inventory_has_parent_or_you_must_insert_inventory_code')];
		//$this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges = 4' . $this->getDelegateCondition()];

		$id = CRUDBooster::getCurrentId();
		$method = CRUDBooster::getCurrentMethod();
		$custom_select = view('custom.multi_delegates_select', ['id' => $id, 'method' => $method])->render();
		$this->form[] = ["label" => trans('crudbooster.Delegates'), "name" => "delegates", "type" => "custom", "html" => $custom_select];

		$this->form[] = ['label' => trans('modules.parent_category'), 'name' => 'parent_id', 'type' => 'select2', 'width' => 'col-sm-10', 'datatable' => 'inventories,name_ar', 'datatable_where' => 'major_classification=1'];
		$this->form[] = ['label' => trans('modules.major_classification'), 'name' => 'major_classification', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '1|'.trans('modules.yes').';0|'.trans('modules.no'), 'value' => 0];
		$this->form[] = ['label' => trans('modules.notes'), 'name' => 'note', 'type' => 'textarea', 'width' => 'col-sm-10'];

		//$this->form[] = ['label'=>trans('modules.active),'name'=>'active','type'=>'radio','width'=>'col-sm-9','dataenum'=>'1|'.trans('modules.yes').';0|'.trans('modules.no')];
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
		$this->script_js .="
			$('#name_en').change(function(){
				$(this).val($(this).val().trim());
			});
			$('#name_ar').change(function(){
				$(this).val($(this).val().trim());
			});
		";
		if (!CRUDBooster::isSuperAdmin() && CRUDBooster::getCurrentMethod() == 'getEdit') {
			$this->script_js .= "
					$('#form-group-code').css('display','none');
					$('#form-group-delegates').css('display','none');
					$('#form-group-parent_id').css('display','none');
					$('#form-group-major_classification').css('display','none');
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

		if ($postdata['major_classification'] != 1) {
			$avilableInventoriesNum = $this->getPackageConfigValue('inventories_num');
			//check if package config allow to add inventory
			$inventories_now = Inventory::where('major_classification', 0)->get();
			if ($avilableInventoriesNum > 0 && count($inventories_now) + 1 > $avilableInventoriesNum) {
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.cannot_add_inventory_allowed_number_is')."  $avilableInventoriesNum", "warning");
			}
		}

		if ($postdata['parent_id'] == null && $postdata['code'] == null) {
			CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.you_must_insert_code_if_you_add_inventory_without_parent'), "warning");
		}

		if ($postdata['parent_id'] != null) {
			$parent_id = $postdata['parent_id'];
			$postdata['code'] = Inventory::getCode($parent_id);
		}

		$delegates = $postdata['delegates'];
		session()->put("delegates", $delegates);

		unset($postdata['delegates']);
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

		if($delegates == "") {$delegates = array();}
		Inventory::find($id)->delegates()->sync($delegates);

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

		$inv = Inventory::where('id', $id)->first();
		if ($postdata['parent_id'] == null && $postdata['code'] == null) {
			CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.you_must_insert_code_if_you_edit_inventory_without_parent'), "warning");
		}

		if ($postdata['parent_id'] != null && $postdata['parent_id'] != $inv->parent_id) {
			$parent_id = $postdata['parent_id'];
			$postdata['code'] = Inventory::getCode($parent_id);
		}

		//change relationship between inventories and delegates
		$inventory_id = session("inventory_id");
		$delegates = $postdata['delegates'];
		DB::beginTransaction();
		try {

			//eidt Inventories
			if($delegates == "") {$delegates = array();}
			$inv->delegates()->sync($delegates); //remove old and add new Delegates
	
			DB::commit();

		}
		catch (Exception $e) {
			DB::rollback();
		}


		unset($postdata['delegates']);
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
		//check if inventory has degate account
		$inv_delegates = Inventory::find($id)->delegates;
		if ($inv_delegates->count() > 0) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.cannot_delete_inventory_has_delegate'), "warning");
		}

		//check if inventory has item_tracking records
		$hasRecords = false;
		$records = ItemTracking::where('source', $id)->orwhere('destination', $id)->get();
		if (count($records) > 0) {
			$hasRecords = true;
		}

		if ($hasRecords) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.cannot_delete_inventory_has_entries'), "warning");
		}
		//check if inventory main inventory has children
		$hasChildren = false;
		$children = Inventory::where('parent_id', $id)->get();
		if (count($children) > 0) {
			$hasChildren = true;
		}
		if ($hasChildren) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.cannot_delete_inventory_has_sons'), "warning");
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

	public function getIndex()
	{

		if (!CRUDBooster::isView())
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.you_dont_have_access_permission'), "warning");


		$user = CRUDBooster::getUser();

		if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) { //delegate , factory delegate
			$itemCategories = GeneralDelegate::with(['inventories'=>function($q){
				$q->orderBy('id', 'asc');
			}])->find($user->id)->inventories;
			
			$allItemCategories = Inventory::orderBy('sorting', 'asc')->get();
		}
		else {
			$itemCategories = Inventory::where('parent_id', '=', NULL)->orderBy('sorting', 'asc')->get();
			$allItemCategories = Inventory::orderBy('sorting', 'asc')->get();
		}


		$table_name = "inventories";

		return view('itemCategories.categoryTreeview', compact('itemCategories', 'table_name', 'allItemCategories'));

	}



	//By the way, you can still create your own method in here... :)



	//export to excel file xls
	public function export()
	{
		$data = Inventory::get()->toArray();

		$new_data = array();
		foreach ($data as $arr) {

			$temp = array(
				"name_en" => $arr['name_en'],
				"name_ar" => $arr['name_ar'],
				"code" => $arr['code'],
			);

			array_push($new_data, $temp);
		}

		$data = $new_data;

		Excel::create('Inventories_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data) {

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
				    	"name_en" => trans('modules.English_Name'),
				    	"name_ar" => trans('modules.Arabic_Name'),
				    	"code" => trans('modules.code'),
				    ));
				    $sheet->row(1, function ($row) {
					        // call cell manipulation methods
        					$row->setBackground('#cccccc');

				        }
				        );

				        $sheet->appendRow(2, array('', '', '', ));

				        $sheet->freezeFirstRow();
				        // Set auto size for sheet
        				$sheet->setAutoSize(true);



			        }
			        );

		        })->export('xls');

	
}

	
	//importing data methods in ImportDataTraits
	
}