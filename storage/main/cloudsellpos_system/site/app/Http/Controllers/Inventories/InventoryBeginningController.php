<?php 
	namespace App\Http\Controllers;
	namespace App\Http\Controllers\Inventories;

	use App\Http\Controllers\General\GeneralFunctionsController;
	use App\Models\SystemConfigration\SystemSetting;
	use Request;
	use DB;
	use CRUDBooster;
	use App\Traits\GeneralTrait;
	use App\Traits\ImportDataTrait;
	use App\Http\Controllers\Data\ImportController;
	use App\Models\ItemsTracking\ItemTrackingType;
	use App\Models\ItemsTracking\ItemTracking;
	use App\Models\Items\Item;
	use App\Models\Inventories\BeginningTrackingList;
	use App\Models\Inventories\BeginningTracking;
	use Session;

	class InventoryBeginningController extends \crocodicstudio_voila\crudbooster\controllers\CBController {
		use GeneralTrait,ImportDataTrait;
	    public function cbInit() {

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
			$this->table = "inventory_beginning_tracking";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>trans('modules.document_number'),"name"=>"ib_number"];
			$this->col[] = ["label"=>trans('modules.inventory'),"name"=>"source","join"=>"inventories,name_ar"];
			$this->col[] = ["label"=>trans('modules.date'),"name"=>"date"];
			$this->col[] = ["label"=>trans('modules.notes'),"name"=>"note"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>trans('modules.document_number'),'name'=>'ib_number','type'=>'text','validation'=>'unique:inventory_beginning_tracking,ib_number','width'=>'col-sm-10'];
			$this->form[] = ['label'=>trans('modules.inventory'),'name'=>'source','type'=>'select2','validation'=>'required','width'=>'col-sm-10','datatable'=>'inventories,name_ar','datatable_where'=>'major_classification=0'];
			$this->form[] = ['label'=>trans('modules.date'),'name'=>'date','type'=>'datetime','width'=>'col-sm-10','value' => date('Y-m-d H:i:s'),'validation'=>'required|date'];
			$this->form[] = ['label'=>trans('modules.notes'),'name'=>'note','type'=>'textarea','width'=>'col-sm-10'];
			
			$columns[] = ['label' => trans('modules.item'), 'name' => 'item_id', 'type' => 'select', 'datatable' => 'items,name_ar', 'required' => true];
			$columns[] = ['label' => trans('modules.item_unit'), 'name' => 'item_unit', 'type' => 'text','readonly'=>true];
			$columns[] = ['label' => trans('modules.quantity'), 'name' => 'quantity', 'type' => 'number', 'step' => 'any', 'required' => true];
			$this->form[] = ['label' => trans('modules.add_to_table_ar_en'), 'name' => 'inventory_beginning_items_list', 'type' => 'child','validation' => 'required', 'columns' => $columns, 'table' => 'inventory_beginning_items_list', 'foreign_key' => 'ib_tracking_id'];
			
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
			$gfunc = new GeneralFunctionsController();
        	$hasPermission = $gfunc->checkOldCycleHasEditedPermission(); //when display old cycles hasPermission = false execipt last cycle hasPermission = true 
		
			if( CRUDBooster::getCurrentMethod() == 'getIndex' && CRUDBooster::isSuperAdmin() && $hasPermission){
				$items_count=Item::count();
				if($items_count > 0){
					$this->index_button[] = ['label'=>trans('modules.import_data'),'url'=>CRUDBooster::mainpath("import-data-form"),"icon"=>"fa fa-download"];
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
            $this->script_js = "";
			$this->script_js .=" 
				var  _CHOOSE_ITEM= '".trans('labels.choose_item')."';
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
			$this->load_js[] = asset("js/modules_js/inventories/inventory_beginning_script.js");


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
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here

	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate query of index result
	    | ----------------------------------------------------------------------
	    | @query = current sql query
	    |
	    */
	    public function hook_query_index(&$query) {
			$query->where('cycle_id',Session::get('display_cycle'));
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
			
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
			
			//check if there are items in request
			$allRequestData = Request::all();
			$itemsIds = $allRequestData['adaflljdol-item_id'];
			if ($itemsIds == null || ($itemsIds != null && count($itemsIds) < 1)) {
                return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.please_enter_items'), "warning");
			}

			$postdata["staff_id"] = CRUDBooster::myId();


	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
	        
			DB::beginTransaction();
			try {   
				$ibt = BeginningTracking::find($id);
				$ib_items = BeginningTrackingList::where('ib_tracking_id', $ibt->id)->get();
				
				foreach($ib_items as $item){
					$max = ItemTracking::where("item_tracking_type_id", 5)->where('action',NULL)->where('cycle_id',Session::get('display_cycle'))->max('code');
					$prefixCode = ItemTrackingType::where('id',5)->select('prefix')->first();
		
					$maxCode = ($max) ? $max + 1 : 1;
					$p_code = $prefixCode->prefix .''. $maxCode;
		
					ItemTracking::insert(
						['code' => $maxCode, 'item_id' => $item->item_id,
						'source'=>$ibt->source,'date'=>$ibt->date,
						'quantity'=>$item->quantity,'item_tracking_type_id'=>5,
						'transaction_operation'=> 'in','p_code' =>$p_code,
						'cycle_id' => Session::get('display_cycle'),
						'create_by'=>CRUDBooster::myId()
						]
					);

					BeginningTrackingList::where('id',$item->id)->update([
						'p_code' =>$p_code,
						'cycle_id' =>  Session::get('display_cycle'),
					]);

		
				}
				DB::commit();
			} catch (\Exception $e) {
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
	    public function hook_before_edit(&$postdata,$id) {
			
			//check if there are items in request
			$allRequestData = Request::all();
			$itemsIds = $allRequestData['adaflljdol-item_id'];
			if ($itemsIds == null || ($itemsIds != null && count($itemsIds) < 1)) {
				$this->setBeginningItemsDataToSession();
                return CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.please_enter_items'), "warning");
			}


			$postdata["staff_id"] = CRUDBooster::myId();

			//check delete all record from item_tracking that connected with this transfer
			$ibt = BeginningTracking::find($id);
			$ib_items = BeginningTrackingList::where('ib_tracking_id', $ibt->id)->get();
			foreach($ib_items as $item){
				ItemTracking::where('p_code',$item->p_code)->where('cycle_id',Session::get('display_cycle'))->delete();
			}
			BeginningTrackingList::where('ib_tracking_id',$ibt->id)->delete();
			BeginningTracking::where('id',$id)->update([
												'ib_number' => $postdata['ib_number'],
												'source' => $postdata['source'],
												'note' => $postdata['note'],
												'date'=>$postdata['date'],
												'staff_id'=>$postdata['staff_id']
												]);

			//insert other records in item_tracking
			$allRequestData = Request::all();
			$itemsIds = $allRequestData['adaflljdol-item_id'];
			$quantitys = $allRequestData['adaflljdol-quantity'];
			$items_quantity = array_combine($itemsIds,$quantitys);
			$ibt_after_edit = BeginningTracking::find($id);
			foreach($items_quantity as $item_id=>$qty){
				
				$unit_name= Item::join('item_units','item_units.id','items.item_unit_id')
				->where('items.id',$item_id)->first()->name_ar;
				
				$list_index = BeginningTrackingList::insertGetId([
					'ib_tracking_id' => $ibt_after_edit->id, 
					'item_id'=>$item_id,
					'item_unit'=>$unit_name,
					'quantity'=>$qty,
					'cycle_id' => Session::get('display_cycle'),
					]
				);

				$max = ItemTracking::where("item_tracking_type_id", 5)->where('action',NULL)->where('cycle_id',Session::get('display_cycle'))->max('code');
				$prefixCode = ItemTrackingType::where('id',5)->select('prefix')->first();
	
				$maxCode = ($max) ? $max + 1 : 1;
				$p_code = $prefixCode->prefix .''. $maxCode;
	
				ItemTracking::insert(
					['code' => $maxCode, 'item_id' => $item_id,
					'source'=>$ibt_after_edit->source,'date'=>$ibt_after_edit->date,
					'quantity'=>$qty,'item_tracking_type_id'=>5,
					'transaction_operation'=> 'in','p_code' =>$p_code,
					'cycle_id' => Session::get('display_cycle'),
					'create_by'=>CRUDBooster::myId()
					]
				);

				
				BeginningTrackingList::where('id',$list_index)->update([
					'p_code' =>$p_code
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
			
			//make copy of record and make it as delete 
			//$this->makeInventoryBeginningAsDeleted($id);
			
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        
			$tranfer_items = BeginningTrackingList::where('ib_tracking_id', $id)->get();
			foreach($tranfer_items as $item){
				ItemTracking::where('p_code',$item->p_code)->where('cycle_id',Session::get('display_cycle'))->delete();
			}
			$tranfer_items = BeginningTrackingList::where('ib_tracking_id', $id)->delete();

	    }

	    /*
	    | ----------------------------------------------------------------------
    	| Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }
	
		public function setBeginningItemsDataToSession(){
			$allRequestData = Request::all();
			//set items list to session as collection
			$IdsArr = $allRequestData['adaflljdol-item_id'];
			$unitsArr = $allRequestData['adaflljdol-item_unit'];
			$qtyArr = $allRequestData['adaflljdol-quantity'];
			$oldData = array();
			if($IdsArr){
				foreach($IdsArr as $key=>$id){
					$item_info = [
						"item_id"=>$id,
						"items_name_ar"=> Item::find($id)->name_ar,
						"item_unit"=>$unitsArr["$key"],
						"quantity"=> $qtyArr["$key"]                                        
					];
					array_push($oldData,(object)$item_info);
				}
			}
			$oldData = collect($oldData);
			Session::put("OldData", $oldData);
		}
		
		//importing data methods in ImportDataTraits



}