<?php 
	namespace App\Http\Controllers;
	namespace App\Http\Controllers\Inventories;

	use App\Models\Inventories\TransferTrackingNote;
	use App\Models\Items\Item;
	use Request;
	use DB;
	use CRUDBooster;
	use Session;
	use App\Traits\GeneralTrait;
	use App\Http\Controllers\General\GeneralFunctionsController;
	use App\Models\Users\User;
	use App\Models\ItemsTracking\ItemTrackingType;
	use App\Models\ItemsTracking\ItemTracking;
	use App\Models\Inventories\TransferTrackingList;
	use App\Models\Inventories\TransferTracking;
	
	class TransferItemsController extends \crocodicstudio_voila\crudbooster\controllers\CBController {
		use GeneralTrait;
	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "date,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			if(Session::get('display_cycle') != Session::get('current_cycle')){
                $this->button_add = false;
            }else{
                $this->button_add = true;
            }
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "transfer_tracking";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=> trans('modules.document_number'),"name"=>"transfer_number"];
			$this->col[] = ["label"=> trans('modules.from_inventory'),"name"=>"source","join"=>"inventories,name_ar"];
			$this->col[] = ["label"=> trans("modules.to_inventory"),"name"=>"destination","join"=>"inventories,name_ar"];
			$this->col[] = ["label"=> trans('modules.date'),"name"=>"date"];
			$this->col[] = ["label" => trans('modules.delegate'), "name" => "delegate_id", "join" => "cms_users,name"];
			$this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name"];
        	$this->col[] = ["label" => "", "name" => "status", "visible" => false];
        
			# END COLUMNS DO NOT REMOVE THIS LINE
			
			# START FORM DO NOT REMOVE THIS LINE
			$gfunc= new GeneralFunctionsController();
			$user = CRUDBooster::getUser();
			$this->form = [];
			$this->form[] = ['label' => trans('modules.transfer_number'), 'name' => 'transfer_number', 'type' => 'text', 'validation' => 'unique:transfer_tracking', 'width' => 'col-sm-10'];
			if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
				$this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES').') ' . $this->getDelegateCondition()];
			}else{
				$this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES').') ' . $this->getDelegateCondition()];
			}
			if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
				$this->form[] = ['label'=>trans('modules.from_inventory'),'name'=>'source','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'inventories,name_ar','datatable_where'=>'id in ('.implode(',',$user->getInventoriesIds()).')'];
				$this->form[] = ['label'=>trans('modules.to_inventory'),'name'=>'destination','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'inventories,name_ar','datatable_where'=>'id in ('.implode(',',$user->getInventoriesIds()).')'];
			}else{
				$this->form[] = ['label'=>trans('modules.from_inventory'),'name'=>'source','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'inventories,name_ar','datatable_where'=>'major_classification=0'];
				$this->form[] = ['label'=>trans('modules.to_inventory'),'name'=>'destination','type'=>'select2','width'=>'col-sm-10','validation'=>'required','datatable'=>'inventories,name_ar','datatable_where'=>'major_classification=0'];
			}
			$this->form[] = ['label'=>trans('modules.date'),'name'=>'date','type'=>'datetime','width'=>'col-sm-10','value' => date('Y-m-d H:i:s'),'validation'=>'required|date'];
			
			$columns[] = ['label' => trans('modules.item'), 'name' => 'item_id', 'type' => 'select', 'datatable' => 'items,name_ar', 'required' => true];
			$columns[] = ['label' => trans('modules.quantity'), 'name' => 'quantity', 'type' => 'number', 'step' => 'any', 'required' => true];
			$this->form[] = ['label' => trans('modules.add_to_table_ar_en'), 'name' => 'transfer_items_list', 'type' => 'child','validation' => 'required', 'columns' => $columns, 'table' => 'transfer_items_list', 'foreign_key' => 'transfer_tracking_id'];
			
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
			$this->addaction[] = ['label' => '', 'url' => "javascript:void(0);", 'icon' => 'fa fa-truck', 'color' => 'danger','title'=> trans('labels.items_on_road'), 'showIf' => "[status] == 0"];
			$this->addaction[] = ['label' => '', 'url' => "javascript:void(0);", 'icon' => 'fa fa-check-square-o', 'color' => 'success','title'=> trans('labels.confirmed_items_receipt') ,'showIf' => "[status] == 1"];
			$this->addaction[] = ['label' => '', 'url' => "javascript:void(0);", 'icon' => 'fa  fa-truck', 'color' => 'warning','title'=> trans('labels.some_items_not_receipt_yet'), 'showIf' => "[status] == 2"];
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('notes/[id]'), 'icon' => 'fa fa-comments-o', 'color' => 'info', 'title' => trans('labels.transfer_tracking_has_notes'), 'showIf' => "[notes] > 0"];

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
			if(CRUDBooster::isColumnExists($this->table,'status')){
                $this->table_row_color[] = ["condition" => "[status]!=0", "color" => "info receipted"];
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
				var  _CHOOSE_ITEM= '".trans('labels.choose_item')."';
				var  _CURRENT_BALANCE = '".trans('alert.current_balance')."';
				var  _CHOOSE_INVENTORY = '".trans('alert.choose_inventory')."';

				var  _TABLE_DATA_NOT_FOUND= '".trans('crudbooster.table_data_not_found')."';
				var  _CHANGE_INVENTORY_CONFIRM_MESSAGE= '".trans('messages.change_inventory_confirm_message_for_transfer_items')."';
				var  _PLEASE_ENTER_NOTE= '".trans('alert.please_enter_note')."';
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
			$this->load_js[] = asset("js/modules_js/inventories/transfer_items_script1.js");					
			if(CRUDBooster::getCurrentMethod() != 'getEdit'){
				$this->load_js[] = asset("js/modules_js/inventories/transfer_items_script2.js");
			}
			if(CRUDBooster::getCurrentMethod() == 'getEdit'){
				$this->load_js[] = asset("js/modules_js/inventories/transfer_items_script3.js");
			}
			if (CRUDBooster::isSuperAdmin()) {
				$this->load_js[] = asset("js/modules_js/inventories/transfer_items_script4.js");
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
				.selected-action {
					display: none !important;
				}
				tr.receipted .btn-edit, tr.receipted .btn-delete{
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
			//$this->load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");

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

			$user = CRUDBooster::getUser();
			if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS_HAS_OWN_INVENTORIES')))) {
				$user_invs = $user->getInventoriesIds();
				$query->whereIn('source',$user_invs);
			}
			$query->where('cycle_id',Session::get('display_cycle'));
			$query = $query->select('transfer_tracking.id as id', DB::raw("(SELECT count(*) FROM transfer_tracking_notes
                                WHERE transfer_tracking_notes.transfer_tracking_id = transfer_tracking.id ) as notes "));
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

			if($postdata['source'] == $postdata['destination']){
				$this->setTransferItemsDataToSession();
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),trans('messages.source_and_target_inventory_is_same_choose_another_inventory_to_transfer_items'),"warning");
			}

			//check if source has quantity
			$allRequestData = Request::all();
			$itemsIds = $allRequestData['adaflljdol-item_id'];
			$quantitys = $allRequestData['adaflljdol-quantity'];
			$items_quantity = array_combine($itemsIds,$quantitys);
			
			$gfunc= new GeneralFunctionsController();
			$hasEnough_status = true;
			foreach($items_quantity as $item_id=>$qty){
				$hasEnough= $gfunc->getInventoryQauntityItem($postdata['source'],$item_id,$qty);
				if(!$hasEnough){
					$hasEnough_status = false;
					break;
				}
			}
			if(!$hasEnough_status){
				$this->setTransferItemsDataToSession();
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"),trans('messages.source_inventory_donnot_have_enough'),"warning");
			}
			$postdata["staff_id"] = CRUDBooster::myId();
			
			//make transfer tracking not receipt yet
			$postdata["status"] = 0;

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
				$tt = TransferTracking::find($id);
				$tranfer_items = TransferTrackingList::where('transfer_tracking_id', $tt->id)->get();
				
				foreach($tranfer_items as $item){
					$max = ItemTracking::where("item_tracking_type_id", 6)->where('action',NULL)->where('cycle_id',Session::get('display_cycle'))->max('code');
					$prefixCode = ItemTrackingType::where('id',6)->select('prefix')->first();
		
					$maxCode = ($max) ? $max + 1 : 1;
					$prefix = $prefixCode->prefix .''. $maxCode;
					
					ItemTracking::insert(
						['code' => $maxCode, 'item_id' => $item->item_id,
						'source'=>$tt->source,'destination'=>$tt->destination,
						'date'=>$tt->date,'quantity'=>$item->quantity,
						'item_tracking_type_id'=>6,'transaction_operation'=> 'out',
						'status'=>1,
						'cycle_id' => Session::get('display_cycle'),
						'p_code' =>$prefix,'create_by'=>CRUDBooster::myId()
						]
					);
		
					ItemTracking::insert(
						['code' => $maxCode, 'item_id' => $item->item_id,
						'source'=>$tt->destination,'date'=>$tt->date,
						'quantity'=>$item->quantity,'item_tracking_type_id'=>6,
						'transaction_operation'=> 'in','p_code' =>$prefix,
						'status'=>0,
						'cycle_id' => Session::get('display_cycle'),
						'create_by'=>CRUDBooster::myId()
						]
					);

					
					TransferTrackingList::where('id',$item->id)->update([
						'p_code' =>$prefix,
						'cycle_id'=> Session::get('display_cycle'),
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

			if($postdata['source'] == $postdata['destination']){
				$this->setTransferItemsDataToSession();
				CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.source_and_target_inventory_is_same_choose_another_inventory_to_transfer_items'),"warning");
			}
			
			
			//check if inventory has enough quantity
			$allRequestData = Request::all();
			$itemsIds = $allRequestData['adaflljdol-item_id'];
			$quantitys = $allRequestData['adaflljdol-quantity'];
			$items_quantity = array_combine($itemsIds,$quantitys);
			
			$gfunc= new GeneralFunctionsController();
			$hasEnough_status = true;
			foreach($items_quantity as $item_id=>$qty){
				$hasEnough= $gfunc->getInventoryQauntityItem($postdata['source'],$item_id,$qty,'edit',$id);
				if(!$hasEnough){
					$hasEnough_status = false;
					break;
				}
			}
			if(!$hasEnough_status){
				$this->setTransferItemsDataToSession();
				CRUDBooster::redirect(CRUDBooster::mainpath("edit/$id"), trans('messages.source_inventory_donnot_have_enough'),"warning");
			}
			$postdata["staff_id"] = CRUDBooster::myId();

			//check delete all record from item_tracking that connected with this transfer
			$tt = TransferTracking::find($id);
			$tranfer_items = TransferTrackingList::where('transfer_tracking_id', $tt->id)->get();
			foreach($tranfer_items as $item){
				ItemTracking::where('p_code',$item->p_code)->where('cycle_id',Session::get('display_cycle'))->delete();
			}
			TransferTrackingList::where('transfer_tracking_id',$tt->id)->delete();
			TransferTracking::where('id',$id)->update([
												'transfer_number' => $postdata['transfer_number'],
												'source' => $postdata['source'],
												'destination'=>$postdata['destination'],
												'date'=>$postdata['date'],
												'staff_id'=>$postdata['staff_id'],
												'delegate_id'=>$postdata['delegate_id'],
												'status'=>0
												]);

			//insert other records in item_tracking
			$allRequestData = Request::all();
			$itemsIds = $allRequestData['adaflljdol-item_id'];
			$quantitys = $allRequestData['adaflljdol-quantity'];
			$items_quantity = array_combine($itemsIds,$quantitys);
			$tt_after_edit = TransferTracking::find($id);
			foreach($items_quantity as $item_id=>$qty){
				$list_index = TransferTrackingList::insertGetId([
					'transfer_tracking_id' => $tt_after_edit->id, 
					'item_id'=>$item_id,
					'quantity'=>$qty,
					'cycle_id' => Session::get('display_cycle'),
					]
				);

				$max = ItemTracking::where("item_tracking_type_id", 6)->where('action',NULL)->where('cycle_id',Session::get('display_cycle'))->max('code');
				$prefixCode = ItemTrackingType::where('id',6)->select('prefix')->first();
	
				$maxCode = ($max) ? $max + 1 : 1;
				$prefix = $prefixCode->prefix .''. $maxCode;
				
				ItemTracking::insert(
					['code' => $maxCode, 'item_id' => $item_id,
					'source'=>$tt_after_edit->source,'destination'=>$tt_after_edit->destination,
					'date'=>$tt_after_edit->date,'quantity'=>$qty,
					'item_tracking_type_id'=>6,'transaction_operation'=> 'out',
					'p_code' =>$prefix,'create_by'=>CRUDBooster::myId(),
					'cycle_id' => Session::get('display_cycle'),
					'status'=>1
					]
				);
	
				ItemTracking::insert(
					['code' => $maxCode, 'item_id' => $item_id,
					'source'=>$tt_after_edit->destination,'date'=>$tt_after_edit->date,
					'quantity'=>$qty,'item_tracking_type_id'=>6,
					'transaction_operation'=> 'in','p_code' =>$prefix,
					'create_by'=>CRUDBooster::myId(),
					'cycle_id' => Session::get('display_cycle'),
					'status'=>0
					]
				);

				
				TransferTrackingList::where('id',$list_index)->update([
					'p_code' =>$prefix
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
	    public function hook_after_edit($id) {
            $postdata['item_tracking_type_id']=6;
            
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
			$tranfer_items = TransferTrackingList::where('transfer_tracking_id', $id)->get();
			foreach($tranfer_items as $item){
				ItemTracking::where('p_code',$item->p_code)->where('cycle_id',Session::get('display_cycle'))->delete();
			}
			$tranfer_items = TransferTrackingList::where('transfer_tracking_id', $id)->delete();
			TransferTrackingNote::where('transfer_tracking_id', $id)->delete();
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



	    //By the way, you can still create your own method in here... :)
		public function getEdit($id)
		{
	
			$tt = TransferTracking::find($id);
			if(!CRUDBooster::isManager() && ($tt->staff_id !== CRUDBooster::getUser()->id)){
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_update_permission_because_you_arenot_creator_of_transfer_tracking'), "warning");
			}

			if ($tt->status != 0) {
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_cannot_update_transfer_tracking_because_this_tracking_is_receipted'), "warning");
			}
	
			return parent::getEdit($id); // TODO: Change the autogenerated stub
		}

		public function getDelete($id)
		{
	
			$tt = TransferTracking::find($id);
			if(!CRUDBooster::isManager() && ($tt->staff_id !== CRUDBooster::getUser()->id)){
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_delete_permission_because_you_arenot_creator_of_transfer_tracking'), "warning");
			}

			if ($tt->status != 0) {
				return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_cannot_delete_transfer_tracking_because_this_tracking_is_receipted'), "warning");
			}

			return parent::getDelete($id); // TODO: Change the autogenerated stub
		}

		public function checkInventoryItemEditQty($inventory,$item_id,$request_qty,$id){
            $gfunc= new GeneralFunctionsController();
			$hasEnough= $gfunc->getInventoryQauntityItem($inventory,$item_id,$request_qty,'edit',$id);
			if(!$hasEnough){
				return trans('messages.source_donnot_have_enough_from_choosen_item');
			}
    	}

		public function setTransferItemsDataToSession(){
			$allRequestData = Request::all();
			//set items list to session as collection
			$IdsArr = $allRequestData['adaflljdol-item_id'];
			$qtyArr = $allRequestData['adaflljdol-quantity'];
			$oldData = array();
			if($IdsArr){
				foreach($IdsArr as $key=>$id){
					$item_info = [
						"item_id"=>$id,
						"items_name_ar"=> Item::find($id)->name_ar,
						"quantity"=> $qtyArr["$key"]                                        
					];
					array_push($oldData,(object)$item_info);
				}
			}
			$oldData = collect($oldData);
			Session::put("OldData", $oldData);
		}


		public function showNotes($id)
		{
			
			$data = [];
			$data['page_title'] = trans('labels.transfer_tracking_detail');
			$data['row'] = TransferTracking::where('id',$id)->first();
			$data['id'] = $id;
			
			//Please use cbView method instead view method from laravel
			$this->cbView('detail_pages.transfer_items',$data);
		}

	}