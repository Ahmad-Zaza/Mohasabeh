<?php

namespace App\Http\Controllers;

use function MongoDB\BSON\fromJSON;
use Session;
use Request;
use DB;
use CRUDBooster;
use Carbon\Carbon;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;


class AdminInventoryAccountingController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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
		$this->table = "item_tracking";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Code", "name" => "code"];
		$this->col[] = ["label" => "Item Id", "name" => "item_id", "join" => "items,name_ar"];
		$this->col[] = ["label" => "Source", "name" => "source", "join" => "inventories,name_ar"];
		$this->col[] = ["label" => "Date", "name" => "date"];
		$this->col[] = ["label" => "Quantity", "name" => "quantity"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Code', 'name' => 'code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Item Id', 'name' => 'item_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'items,name_ar'];
		$this->form[] = ['label' => 'Source', 'name' => 'source', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Date', 'name' => 'date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ['label'=>'Code','name'=>'code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Item Id','name'=>'item_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'items,name_ar'];
		//$this->form[] = ['label'=>'Source','name'=>'source','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Date','name'=>'date','type'=>'date','validation'=>'required|date','width'=>'col-sm-10','datatable'=>'inventories,name_ar'];
		# OLD END FORM

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
		$this->alert        = array();



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


	public function getIndex()
	{
		$request = $_REQUEST;

		if (!CRUDBooster::isView()) CRUDBooster::denyAccess();

		$id = CRUDBooster::myId();
		$me = DB::table('cms_users')->find($id);
		if ($me->id_cms_privileges == 4) {
			$inventories = DB::table('inventories')->where('major_classification', 0)->where('delegate_id', $id)->get();
			$inventories_ids = DB::table('inventories')->where('major_classification', 0)->where('delegate_id', $id)->pluck('id')->toArray();

			$items_ids = DB::table('item_tracking')->where('delete_by', 0)->where('rotate_year', NULL)->whereIn('source', $inventories_ids)->distinct('item_id')->pluck('item_id')->toArray();
			$items = DB::table('items')->whereIn('id', $items_ids)->get();
		} else {
			$inventories = DB::table('inventories')->where('major_classification', 0)->get();
			$inventories_ids = DB::table('inventories')->where('major_classification', 0)->select('id')->pluck('id')->toArray();
			$items = DB::table('items')->get();
		}

		if ($request->date == null) {
			$request->date = Carbon::now();
		}

		$query = DB::table("item_tracking as t0")
			->select(
				"t0.item_id as itemId",
				'items.name_ar as nameAr',
				'source.name_ar as sourceInventory',
				DB::raw("(SELECT SUM(t1.quantity) FROM item_tracking as t1
                                WHERE t1.transaction_operation = 'in'
								and t1.delete_by = '0' and t1.rotate_year is NULL
                                and t1.item_id = t0.item_id
                                and t0.source = t1.source
                                and t1.date <= '" . ($request->date) . "') as item_in "),
				DB::raw("(SELECT SUM(t2.quantity) FROM item_tracking as t2
                               WHERE t2.transaction_operation = 'out'
							    and t2.delete_by = '0' and t2.rotate_year is NULL
                                and t0.item_id = t2.item_id and t0.source = t2.source) as item_out")
			)
			->join("items", "items.id", "t0.item_id")
			->leftjoin("inventories as source", "t0.source", "source.id")->where('t0.date', '<=', $request->date)

			->GROUPby('itemId', 't0.source');

		if ($request->input('item_id') != -1 && $request->input('item_id') != null) {
			$query->where('items.id', $request->item_id);
		}

		if ($me->id_cms_privileges == 4) {
			if ($request->input('inventory_id') != -1 && $request->input('inventory_id') != null) {
				$query->where('t0.source', $request->inventory_id);
			} else {
				$query->whereIn('t0.source', $inventories_ids)->orWhereIn('t0.destination', $inventories_ids);
				$query->where('t0.delete_by', 0)->where('t0.rotate_year', NULL);
			}
		} else {
			if ($request->input('inventory_id') != -1 && $request->input('inventory_id') != null) {
				$query->where('t0.source', $request->inventory_id);
			}
		}



		$query->where('t0.delete_by', 0);
		$query->where('t0.rotate_year', NULL);
		$data = $query->get();

		Session::put('inv_acc_report', $data);

		return view("report.inventoryAccounting", array(
			"data" => $data,  'inventories' => $inventories,
			"inventory_id" => $request->input('inventory_id'), 'date' => $request->date, "items" => $items,
			"item_id" => $request->input('item_id')
		));
	}

	//export to excel file xls
	public function export($filter)
	{
		//get report from session
		$report = Session::get('inv_acc_report');
		$json  = json_encode($report);
		$data = json_decode($json, true);
		if ($data == null) {
			return "No Data, Please using filter to show your data and press export aging.";
		}
		$new_data = array();
		$all_in = 0;
		$all_out = 0;
		$all_total = 0;
		foreach ($data as $arr) {
			$arr['item_in'] = $arr['item_in'] != null ? $arr['item_in'] : '0';
			$arr['item_out'] = $arr['item_out'] != null ? $arr['item_out'] : '0';
			$arr['total'] = $arr['item_in'] - $arr['item_out'];

			$all_in += $arr['item_in'];
			$all_out += $arr['item_out'];
			$all_total += $arr['total'];
			array_push($new_data, $arr);
		}
		$result = array('itemId' => '', 'nameAr' => '', 'sourceInventory' => '', 'item_in' => $all_in, 'item_out' => $all_out, 'total' => $all_total);
		array_push($new_data, $result);
		$data = $new_data;

		Excel::create('export_inventory_accounting_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data) {

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
					"itemId" => 'رقم المادة',
					"nameAr" => "اسم المادة",
					"sourceInventory" => "المستودع",
					"item_in" => "داخل",
					"item_out" => "خارج",
					"total" => "الرصيد",
				));
				$sheet->row(1, function ($row) {
					// call cell manipulation methods
					$row->setBackground('#cccccc');
				});
				$sheet->appendRow(2, array(
					'', '', '', '', '', ''
				));

				$sheet->freezeFirstRow();
				// Set auto size for sheet
				$sheet->setAutoSize(true);
			});
		})->export('xls');
	}
}
