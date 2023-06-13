<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Items;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\Items\Item;
use App\Traits\ItemsTrait;
use Request;
use DB;
use CRUDBooster;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Items\ItemCategory;
use App\Http\Controllers\Data\ImportController;
use App\Models\Users\User;
use App\Models\ItemsTracking\ItemTracking;
use App\Traits\ImportDataTrait;

class ItemsController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
	use ImportDataTrait,ItemsTrait;
	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "id,desc";
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
		$this->table = "items";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => trans('modules.code'), "name" => "p_code"];
		$this->col[] = ["label" => trans('modules.item_number'), "name" => "item_number"];
		$this->col[] = ["label" => trans('modules.name_ar'), "name" => "name_ar"];
		$this->col[] = ["label" => trans('modules.item_category'), "name" => "item_category_id", "join" => "item_categories,name_ar"];
		$this->col[] = ["label" => trans('modules.item_unit'), "name" => "item_unit_id", "join" => "item_units,name_ar"];
		$this->col[] = ["label" => trans('modules.cost'), "name" => "cost"];
		$this->col[] = ["label" => trans('modules.price'), "name" => "price"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];

		if (CRUDBooster::getCurrentMethod() == 'getDetail') {
			$this->form[] = ['label' => trans('modules.item_code'), 'name' => 'p_code', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
		}
		$this->form[] = ['label' => trans('modules.item_number'), 'name' => 'item_number', 'type' => 'text', 'validation' => 'unique:items', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.name_en'), 'name' => 'name_en', 'type' => 'text', 'validation' => 'unique:items,name_en', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.name_ar'), 'name' => 'name_ar', 'type' => 'text', 'validation' => 'required|unique:items,name_ar', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.parent_category'), 'name' => 'item_category_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'item_categories,name_ar', 'datatable_where' => ''];
		$this->form[] = ['label' => trans('modules.item_unit'), 'name' => 'item_unit_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'item_units,name_ar'];
		$this->form[] = ['label' => trans('modules.cost'), 'name' => 'cost', 'step' => 'any', 'type' => 'number', 'width' => 'col-sm-10', 'validation' => 'min:0.01'];
		$this->form[] = ['label' => trans('modules.price'), 'name' => 'price', 'type' => 'number', 'step' => 'any', 'width' => 'col-sm-10', 'validation' => 'min:0.01'];
		$this->form[] = ['label' => trans('modules.production_date'), 'name' => 'production_date', 'type' => 'date', 'width' => 'col-sm-10', 'validation' => 'date'];
		$this->form[] = ['label' => trans('modules.mix_number'), 'name' => 'mix_number', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => trans('modules.expiration_date'), 'name' => 'expiration_date', 'type' => 'date', 'width' => 'col-sm-10', 'validation' => 'date'];

		$this->form[] = ['label' => trans('modules.visible_to_delegates'), 'name' => 'visible_to_delegates', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '1|'.trans('modules.yes').';0|'.trans('modules.no'), 'value' => '1'];
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
			$cats_count = ItemCategory::count();
			if ($cats_count > 0) {
				$this->index_button[] = ['label' => trans('modules.import_data'), 'url' => CRUDBooster::mainpath("import-data-form"), "icon" => "fa fa-download"];
			}
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
		$this->script_js = NULL;
		$this->script_js .="
			$('#name_en').change(function(){
				$(this).val($(this).val().trim());
			});
			$('#name_ar').change(function(){
				$(this).val($(this).val().trim());
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
		if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
			$query->where('visible_to_delegates', 1);
		}
		if (!Request::get('filter_column')) {
			$query->orderBy('id', 'ASC');
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

		$max = Item::max('code');
		$postdata["code"] = ($max) ? $max + 1 : 1;
		$cat_code = ItemCategory::find($postdata['item_category_id'])->code;
		$item_generate_code = sprintf('%05d', $postdata["code"]);

		$postdata['p_code'] = $cat_code . $item_generate_code;
		$this->checkItemP_Code($postdata['p_code']);

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

		$item = Item::where("id", $id)->first();
		$cat_code = ItemCategory::find($postdata['item_category_id'])->code;
		$item_generate_code = sprintf('%05d', $item->code);

		$postdata['p_code'] = $cat_code . $item_generate_code;


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

		$res = ItemTracking::where("item_id", $id)->get();
		if ($res->count() > 0) {
			return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.delete_item_failed_it_has_entries'), "warning");
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

	//export to excel file xls
	public function export()
	{
		$data = Item::get()->toArray();

		$new_data = array();
		foreach ($data as $arr) {

			$temp = array(
				"name_en" => $arr['name_en'],
				"name_ar" => $arr['name_ar'],
				"p_code" => $arr['p_code'],
			);

			array_push($new_data, $temp);
		}

		$data = $new_data;

		Excel::create('Items_Info_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data) {

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
				    	"p_code" => trans('modules.code'),
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
