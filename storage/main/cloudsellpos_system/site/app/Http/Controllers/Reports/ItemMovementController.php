<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Reports;

use App\Models\Users\Delegate;
use App\Models\Users\GeneralDelegate;
use DB;
use CRUDBooster;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Users\User;
use App\Models\ItemsTracking\ItemTrackingType;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Items\Item;
use App\Models\Inventories\Inventory;
use App\Models\Inventories\BeginningTrackingList;
use App\Models\Inventories\TransferTrackingList;
use Session;
class ItemMovementController extends \crocodicstudio_voila\crudbooster\controllers\CBController
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
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "item_tracking";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Date", "name" => "date"];
        $this->col[] = ["label" => "Item", "name" => "item", "join" => "items,name_ar"];
        $this->col[] = ["label" => "Total", "name" => "quantity"];
        $this->col[] = ["label" => "Inventory", "name" => "source", "join" => "inventories,name_ar"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Code', 'name' => 'code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Item Id', 'name' => 'item_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'item,id'];
        $this->form[] = ['label' => 'Inventory Type Id', 'name' => 'item_tracking_type_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'inventory_type,id'];
        $this->form[] = ['label' => 'Source', 'name' => 'source', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Destination', 'name' => 'destination', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Date', 'name' => 'date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Quantity', 'name' => 'quantity', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Bill Id', 'name' => 'bill_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'bill,id'];
        $this->form[] = ['label' => 'Note', 'name' => 'note', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Transaction Operation', 'name' => 'transaction_operation', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Active', 'name' => 'active', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Sorting', 'name' => 'sorting', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
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

    public function getIndex(Request $request)
    {



        if (!CRUDBooster::isView())
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('crudbooster.you_dont_have_access_permission'), "warning");


        $types = ItemTrackingType::get();

        $user = CRUDBooster::getUser();

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
			$delegate = GeneralDelegate::find($user->id);
			$inventories_ids = $delegate->inventories()->pluck('inventory_id')->toArray();
			$inventories = $delegate->inventories;

            $items_ids = ItemTracking::where('status',1)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->whereIn('source', $inventories_ids)->distinct('item_id')->pluck('item_id')->toArray();
            $items = Item::whereIn('id', $items_ids)->get();
        }
        else {
            if($user->roleId == 3){  //Sales Manager
                $items = Item::where('visible_to_delegates',1)->get();
            }else{
                $items = Item::get();
            }
            $inventories = Inventory::where('major_classification', 0)->get();
            $inventories_ids = Inventory::where('major_classification', 0)->select('id')->pluck('id')->toArray();
        }



        $query = ItemTracking::select(
            'item_tracking.id as record_id',
            'item_tracking.p_code as trackingName', 'item_tracking.date as trackingDate',
            'item_tracking.transaction_operation as trackingOperation',
            'item_tracking.quantity as trackingQuantity',
            'items.name_ar as itemNameAr',
            'item_units.name_ar as itemUnitNameAr',
            'source.name_ar as sourceInventory',
            'item_tracking_types.id as typeId',
            'item_tracking_types.name_ar as typeName',
            'bills.id as billId', 'item_tracking_types.name_en as typeEn', 'item_tracking.id as trackingId',

            DB::raw("(SELECT name_ar FROM accounts WHERE
                            accounts.id = bills.debit ) as debitName"),
            DB::raw("(SELECT name_ar FROM accounts WHERE
                            accounts.id = bills.credit ) as creditName"),
            DB::raw("(SELECT max(unit_price) FROM bills_items WHERE
                                 bills_items.item_id = item_tracking.item_id and
                                 bills_items.bill_id = bills.id) as itemPrice"),
            DB::raw("(SELECT price FROM items WHERE
                                 items.id = item_tracking.item_id) as itemOrginalPrice"),
            DB::raw("(SELECT t1.quantity FROM item_tracking as t1
                                WHERE t1.transaction_operation = 'in'
                                and t1.status = 1 
                                and t1.action is NULL 
                                and t1.cycle_id = ".Session::get('display_cycle')."  
                                and t1.id = item_tracking.id and item_tracking.source = t1.source ) as item_in "),
            DB::raw("(SELECT t2.quantity FROM item_tracking as t2
                               WHERE t2.transaction_operation = 'out'
                               and t2.status = 1 
                               and t2.action is NULL 
                               and t2.cycle_id = ".Session::get('display_cycle')."  
                               and item_tracking.id = t2.id and item_tracking.source = t2.source) as item_out")
        )
            ->join("items", "items.id", "item_tracking.item_id")
            ->join("item_units", "item_units.id", "items.item_unit_id")
            ->join("item_tracking_types", "item_tracking_types.id", "item_tracking.item_tracking_type_id")
            ->leftjoin("inventories as source", "item_tracking.source", "source.id")
            ->leftjoin("inventories as destination", "destination.id", "item_tracking.destination")
            ->leftjoin("bills", "item_tracking.bill_id", "bills.id")
            ->where('item_tracking.status', 1)
            ->where('item_tracking.action', NULL)
            ->where('item_tracking.cycle_id', Session::get('display_cycle'))
            ->orderBy('trackingDate');

        if ($request->input('item_id') != -1 && $request->input('item_id') != null) {
            $query->where('item_tracking.item_id', $request->item_id);
        }

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            if ($request->input('inventory_id') != -1 && $request->input('inventory_id') != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request->inventory_id);
                    $query1->where('item_tracking.action', NULL);
                });
            }
            else {
                $query->whereIn('item_tracking.source', $inventories_ids);
                $query->where('item_tracking.action', NULL);
            }

        }
        else {
            if ($request->input('inventory_id') != -1 && $request->input('inventory_id') != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request->inventory_id);
                });
            }
        }

        if ($request->input('type_id') != -1 && $request->input('type_id') != null) {
            $query->where('item_tracking.item_tracking_type_id', $request->type_id);
        }

        if ($request->input('from_date') != null && $request->input('to_date') == null) {
            $query->where('item_tracking.date', '>=', $request->from_date);
        }
        if ($request->input('from_date') == null && $request->input('to_date') != null) {
            $query->where('item_tracking.date', '<=', $request->to_date." 23:59:59");
        }
        if ($request->input('from_date') != null && $request->input('to_date') != null) {
            $query->whereBetween('item_tracking.date', [$request->from_date, $request->to_date." 23:59:59"]);
        }
        $query->distinct('items.id');
        //return $query->toSql();

        //calculate total 
        $res = $query->get();
        $data_collect = collect($res);
        $item_in = $data_collect->sum('item_in');
        $item_out = $data_collect->sum('item_out');
        $item_total = $item_in - $item_out;

        $data = $query->offset(0)->limit(config('setting.PAGINATIOM_LIMITATION'))->get();


        return view("report.itemMovement", array("data" => $data, "items" => $items, 'types' => $types,
            'inventories' => $inventories, "inventory_id" => $request->input('inventory_id'),
            "item_id" => $request->input('item_id'),
            "type_id" => $request->input('type_id'), 'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'total_quantity' => $item_total
        ));


    }

    //export to excel file xls
    public function export($filter)
    {
        $filter = json_decode($filter);
        $filter = collect($filter);
        $request = array();
        $filter->each(function ($f) use (&$request) {
            $request["$f->name"] = $f->value;
        });

        //make query
        //--------------------------------
        $user = CRUDBooster::getUser();

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            $inventories_ids = GeneralDelegate::find($user->id)->inventories()->pluck('inventory_id')->toArray();
        }
        else {
            $inventories_ids = Inventory::where('major_classification', 0)->select('id')->pluck('id')->toArray();
        }

        $query = ItemTracking::select(
            'item_tracking.id as record_id',
            'item_tracking.p_code as trackingName', 'item_tracking.date as trackingDate',
            'item_tracking.transaction_operation as trackingOperation',
            'item_tracking.quantity as trackingQuantity',
            'items.name_ar as itemNameAr',
            'item_units.name_ar as itemUnitNameAr',
            'source.name_ar as sourceInventory',
            'item_tracking_types.id as typeId',
            'item_tracking_types.name_ar as typeName',
            'bills.id as billId', 'item_tracking_types.name_en as typeEn', 'item_tracking.id as trackingId',

            DB::raw("(SELECT name_ar FROM accounts WHERE
                            accounts.id = bills.debit ) as debitName"),
            DB::raw("(SELECT name_ar FROM accounts WHERE
                            accounts.id = bills.credit ) as creditName"),
            DB::raw("(SELECT max(unit_price) FROM bills_items WHERE
                                 bills_items.item_id = item_tracking.item_id and
                                 bills_items.bill_id = bills.id) as itemPrice"),
            DB::raw("(SELECT price FROM items WHERE
                                 items.id = item_tracking.item_id) as itemOrginalPrice"),
            DB::raw("(SELECT t1.quantity FROM item_tracking as t1
                                WHERE t1.transaction_operation = 'in' 
                                and t1.status = 1 
                                and t1.action is NULL 
                                and t1.cycle_id = ".Session::get('display_cycle')."  
                                and t1.id = item_tracking.id and item_tracking.source = t1.source ) as item_in "),
            DB::raw("(SELECT t2.quantity FROM item_tracking as t2
                               WHERE t2.transaction_operation = 'out'
                               and t2.status = 1 
                               and t2.action is NULL 
                               and t2.cycle_id = ".Session::get('display_cycle')."  
                               and item_tracking.id = t2.id and item_tracking.source = t2.source) as item_out")
        )
            ->join("items", "items.id", "item_tracking.item_id")
            ->join("item_units", "item_units.id", "items.item_unit_id")
            ->join("item_tracking_types", "item_tracking_types.id", "item_tracking.item_tracking_type_id")
            ->leftjoin("inventories as source", "item_tracking.source", "source.id")
            ->leftjoin("inventories as destination", "destination.id", "item_tracking.destination")
            ->leftjoin("bills", "item_tracking.bill_id", "bills.id")
            ->where('item_tracking.status', 1)
            ->where('item_tracking.action', NULL)
            ->where('item_tracking.cycle_id', Session::get('display_cycle'))
            ->orderBy('trackingDate');

        if ($request['item_id'] != -1 && $request['item_id'] != null) {
            $query->where('item_tracking.item_id', $request['item_id']);
        }

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            if ($request['inventory_id'] != -1 && $request['inventory_id'] != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request['inventory_id']);
                    $query1->where('item_tracking.action', NULL);
                });
            }
            else {
                $query->whereIn('item_tracking.source', $inventories_ids);
                $query->where('item_tracking.action', NULL);
            }

        }
        else {
            if ($request['inventory_id'] != -1 && $request['inventory_id'] != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request['inventory_id']);
                });
            }
        }

        if ($request['type_id'] != -1 && $request['type_id'] != null) {
            $query->where('item_tracking.item_tracking_type_id', $request['type_id']);
        }

        if ($request['from_date'] != null && $request['to_date'] == null) {
            $query->where('item_tracking.date', '>=', $request['from_date']);
        }
        if ($request['from_date'] == null && $request['to_date'] != null) {
            $query->where('item_tracking.date', '<=', $request['to_date']." 23:59:59");
        }
        if ($request['from_date'] != null && $request['to_date'] != null) {
            $query->whereBetween('item_tracking.date', [$request['from_date'], $request['to_date']." 23:59:59"]);
        }
        $query->distinct('items.id');
        //--------------------------------
        $report = $query->get();
        $json = json_encode($report);
        $data = json_decode($json, true);
        $request_item_id = $request['item_id'];

        if ($request_item_id == null || $data == null) {
            return trans('messages.no_data_please_using_filter_to_show_your_data_and_press_export_aging');
        }
        //dd($data);
        $new_data = array();
        $all_total = 0;
        foreach ($data as $arr) {
            $item_in = $arr['item_in'] != null ? $arr['item_in'] : '0';
            $item_out = $arr['item_out'] != null ? $arr['item_out'] : '0';
            $temp = array(
                "typeName" => $arr['typeName'],
                "trackingName" => $arr['trackingName'],
                "creditName" => $arr['creditName'],
                "trackingDate" => $arr['trackingDate'],
                "sourceInventory" => $arr['sourceInventory'],
                "itemNameAr" => $arr['itemNameAr'],
                "itemUnitNameAr" => $arr['itemUnitNameAr'],
                "item_in" => $item_in,
                "item_out" => $item_out,
            );

            if ($arr['trackingOperation'] == 'in') {
                $all_total += $item_in;
            }
            else {
                $all_total -= $item_out;
            }
            $temp['total'] = $all_total;

            array_push($new_data, $temp);
        }
        $result = array('typeName' => '', 'trackingName' => '', 'creditName' => '',
            'trackingDate' => '', 'sourceInventory' => '', 'itemNameAr' => '',
            'itemUnitNameAr' => '', 'item_in' => '', 'item_out' => '',
            'total' => $all_total);
        array_push($new_data, $result);
        $data = $new_data;

        Excel::create('export_item_movement_' . date('Y-m-d H:i:s', time()), function ($excel) use ($data) {

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
                        "typeName" => trans('modules.type_name'),
                        "trackingName" => trans('modules.code'),
                        "creditName" => trans('modules.client'),
                        "trackingDate" => trans('modules.date'),
                        "sourceInventory" => trans('modules.inventory'),
                        "itemNameAr" => trans('modules.item_name'),
                        "itemUnitNameAr" => trans('modules.item_unit'),
                        "item_in" => trans('modules.in'),
                        "item_out" => trans('modules.out'),
                        "total" => trans('modules.balance'),
                    ));
                    $sheet->row(1, function ($row) {
                            // call cell manipulation methods
                            $row->setBackground('#cccccc');

                        }
                        );
                        $sheet->appendRow(2, array(
                            '', '', '', '', '', '', '', '', '', '', '', ''
                        ));

                        $sheet->freezeFirstRow();
                        // Set auto size for sheet
                        $sheet->setAutoSize(true);



                    }
                    );

                })->export('xls');

    }

    public function loadmore($offset, $limit, $subtotal, $filter)
    {
        $filter = json_decode($filter);
        $filter = collect($filter);
        $request = array();
        $filter->each(function ($f) use (&$request) {
            $request["$f->name"] = $f->value;
        });
        //build Query
        //--------------------------------------
        $user = CRUDBooster::getUser();
        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            $inventories_ids = GeneralDelegate::find($user->id)->inventories()->pluck('inventory_id')->toArray();
        }
        else {
            $inventories_ids = Inventory::where('major_classification', 0)->select('id')->pluck('id')->toArray();
        }

        $query = ItemTracking::select(
            'item_tracking.id as record_id',
            'item_tracking.p_code as trackingName', 'item_tracking.date as trackingDate',
            'item_tracking.transaction_operation as trackingOperation',
            'item_tracking.quantity as trackingQuantity',
            'items.name_ar as itemNameAr',
            'item_units.name_ar as itemUnitNameAr',
            'source.name_ar as sourceInventory',
            'item_tracking_types.id as typeId',
            'item_tracking_types.name_ar as typeName',
            'bills.id as billId', 'item_tracking_types.name_en as typeEn', 'item_tracking.id as trackingId',

            DB::raw("(SELECT name_ar FROM accounts WHERE
                            accounts.id = bills.debit ) as debitName"),
            DB::raw("(SELECT name_ar FROM accounts WHERE
                            accounts.id = bills.credit ) as creditName"),
            DB::raw("(SELECT max(unit_price) FROM bills_items WHERE
                                 bills_items.item_id = item_tracking.item_id and
                                 bills_items.bill_id = bills.id) as itemPrice"),
            DB::raw("(SELECT price FROM items WHERE
                                 items.id = item_tracking.item_id) as itemOrginalPrice"),
            DB::raw("(SELECT t1.quantity FROM item_tracking as t1
                                WHERE t1.transaction_operation = 'in' 
                                and t1.status = 1
                                and t1.action is NULL 
                                and t1.cycle_id = ".Session::get('display_cycle')."  
                                and t1.id = item_tracking.id and item_tracking.source = t1.source ) as item_in "),
            DB::raw("(SELECT t2.quantity FROM item_tracking as t2
                               WHERE t2.transaction_operation = 'out'
                               and t2.status = 1
                               and t2.action is NULL 
                               and t2.cycle_id = ".Session::get('display_cycle')."  
                               and item_tracking.id = t2.id and item_tracking.source = t2.source) as item_out")
        )
            ->join("items", "items.id", "item_tracking.item_id")
            ->join("item_units", "item_units.id", "items.item_unit_id")
            ->join("item_tracking_types", "item_tracking_types.id", "item_tracking.item_tracking_type_id")
            ->leftjoin("inventories as source", "item_tracking.source", "source.id")
            ->leftjoin("inventories as destination", "destination.id", "item_tracking.destination")
            ->leftjoin("bills", "item_tracking.bill_id", "bills.id")
            ->where('item_tracking.status', 1)
            ->where('item_tracking.action', NULL)
            ->where('item_tracking.cycle_id', Session::get('display_cycle'))
            ->orderBy('trackingDate');

        if ($request['item_id'] != -1 && $request['item_id'] != null) {
            $query->where('item_tracking.item_id', $request['item_id']);
        }

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            if ($request['inventory_id'] != -1 && $request['inventory_id'] != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request['inventory_id']);
                    $query1->where('item_tracking.action', NULL);
                });
            }
            else {
                $query->whereIn('item_tracking.source', $inventories_ids);
                $query->where('item_tracking.action', NULL);
            }

        }
        else {
            if ($request['inventory_id'] != -1 && $request['inventory_id'] != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request['inventory_id']);
                });
            }
        }

        if ($request['type_id'] != -1 && $request['type_id'] != null) {
            $query->where('item_tracking.item_tracking_type_id', $request['type_id']);
        }

        if ($request['from_date'] != null && $request['to_date'] == null) {
            $query->where('item_tracking.date', '>=', $request['from_date']);
        }
        if ($request['from_date'] == null && $request['to_date'] != null) {
            $query->where('item_tracking.date', '<=', $request['to_date']." 23:59:59");
        }
        if ($request['from_date'] != null && $request['to_date'] != null) {
            $query->whereBetween('item_tracking.date', [$request['from_date'], $request['to_date']." 23:59:59"]);
        }
        $query->distinct('items.id');
        //-------------------

        $data = $query->offset($offset)->limit($limit)->get();

        if ($data->count() > 0) {
            $allQuantity = $subtotal;
            $data->each(function ($item) use (&$allQuantity) {
                $item->account_name = '';
                if ($item->typeId == 1 || $item->typeId == 3) {
                    $item->account_name = $item->creditName != null ? $item->creditName : '';
                }
                else {
                    $item->account_name = $item->debitName != null ? $item->debitName : '';
                    ;
                }

                $item->item_in = $item->item_in ? number_format($item->item_in, 2) : 0;
                $item->item_out = $item->item_out ? number_format($item->item_out, 2) : 0;

                if ($item->trackingOperation == 'in') {
                    $allQuantity += $item->trackingQuantity;
                }
                else {
                    $allQuantity -= $item->trackingQuantity;
                }

                $item->allQuantity = $allQuantity != 0 ? number_format($allQuantity, 2) : 0;

                if ($item->typeId == 5) { // بضاعة أول المدة 
                    $ib_tracking_id = BeginningTrackingList::where('p_code', $item->trackingName)->where('cycle_id',Session::get('display_cycle'))->first()->ib_tracking_id;
                    $item->trackingId = $ib_tracking_id;
                }

                if ($item->typeId == 6) { //مناقة مواد 
                    $transfer_tracking_id = TransferTrackingList::where('p_code', $item->trackingName)->where('cycle_id',Session::get('display_cycle'))->first()->transfer_tracking_id;
                    $item->trackingId = $transfer_tracking_id;
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
        $user = CRUDBooster::getUser();
        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            $inventories_ids = GeneralDelegate::find($user->id)->inventories()->pluck('inventory_id')->toArray();
        }
        else {
            $inventories_ids = Inventory::where('major_classification', 0)->select('id')->pluck('id')->toArray();
        }

        $query = ItemTracking::select(
            'item_tracking.id as record_id',
            'item_tracking.p_code as trackingName', 'item_tracking.date as trackingDate',
            'item_tracking.transaction_operation as trackingOperation',
            'item_tracking.quantity as trackingQuantity',
            'items.name_ar as itemNameAr',
            'item_units.name_ar as itemUnitNameAr',
            'source.name_ar as sourceInventory',
            'item_tracking_types.id as typeId',
            'item_tracking_types.name_ar as typeName',
            'bills.id as billId', 'item_tracking_types.name_en as typeEn', 'item_tracking.id as trackingId',

            DB::raw("(SELECT name_ar FROM accounts WHERE
                        accounts.id = bills.debit ) as debitName"),
            DB::raw("(SELECT name_ar FROM accounts WHERE
                        accounts.id = bills.credit ) as creditName"),
            DB::raw("(SELECT max(unit_price) FROM bills_items WHERE
                             bills_items.item_id = item_tracking.item_id and
                             bills_items.bill_id = bills.id) as itemPrice"),
            DB::raw("(SELECT price FROM items WHERE
                             items.id = item_tracking.item_id) as itemOrginalPrice"),
            DB::raw("(SELECT t1.quantity FROM item_tracking as t1
                            WHERE t1.transaction_operation = 'in'
                            and t1.status = 1 
                            and t1.action is NULL 
                            and t1.cycle_id = ".Session::get('display_cycle')."  
                            and t1.id = item_tracking.id and item_tracking.source = t1.source ) as item_in "),
            DB::raw("(SELECT t2.quantity FROM item_tracking as t2
                           WHERE t2.transaction_operation = 'out'
                           and t2.status = 1 
                           and t2.action is NULL 
                           and t2.cycle_id = ".Session::get('display_cycle')."  
                           and item_tracking.id = t2.id and item_tracking.source = t2.source) as item_out")
        )
            ->join("items", "items.id", "item_tracking.item_id")
            ->join("item_units", "item_units.id", "items.item_unit_id")
            ->join("item_tracking_types", "item_tracking_types.id", "item_tracking.item_tracking_type_id")
            ->leftjoin("inventories as source", "item_tracking.source", "source.id")
            ->leftjoin("inventories as destination", "destination.id", "item_tracking.destination")
            ->leftjoin("bills", "item_tracking.bill_id", "bills.id")
            ->where('item_tracking.status', 1)
            ->where('item_tracking.action', NULL)
            ->where('item_tracking.cycle_id', Session::get('display_cycle'))
            ->orderBy('trackingDate');

        if ($request['item_id'] != -1 && $request['item_id'] != null) {
            $query->where('item_tracking.item_id', $request['item_id']);
        }

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
            if ($request['inventory_id'] != -1 && $request['inventory_id'] != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request['inventory_id']);
                    $query1->where('item_tracking.action', NULL);
                });
            }
            else {
                $query->whereIn('item_tracking.source', $inventories_ids);
                $query->where('item_tracking.action', NULL);
            }

        }
        else {
            if ($request['inventory_id'] != -1 && $request['inventory_id'] != null) {

                $query->where(function ($query1) use ($request) {
                    $query1->where('source.id', $request['inventory_id']);
                });
            }
        }

        if ($request['type_id'] != -1 && $request['type_id'] != null) {
            $query->where('item_tracking.item_tracking_type_id', $request['type_id']);
        }

        if ($request['from_date'] != null && $request['to_date'] == null) {
            $query->where('item_tracking.date', '>=', $request['from_date']);
        }
        if ($request['from_date'] == null && $request['to_date'] != null) {
            $query->where('item_tracking.date', '<=', $request['to_date']." 23:59:59");
        }
        if ($request['from_date'] != null && $request['to_date'] != null) {
            $query->whereBetween('item_tracking.date', [$request['from_date'], $request['to_date']." 23:59:59"]);
        }
        $query->distinct('items.id');

        //----------------------------------------------
        $data = $query->get();

        $data_collect = collect($data);
        $item_in = $data_collect->sum('item_in');
        $item_out = $data_collect->sum('item_out');
        $item_total = $item_in - $item_out;

        return view("report_print.itemMovement", array("data" => $data, 'total_quantity' => $item_total));

    }
}