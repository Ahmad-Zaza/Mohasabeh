<?php 
	namespace App\Http\Controllers;
	namespace App\Http\Controllers\Notifications;

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
	
	class ReceiptItemsNotificationsController extends \crocodicstudio_voila\crudbooster\controllers\CBController {
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
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
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
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('detail/[id]'), 'icon' => 'fa  fa-truck', 'color' => 'danger','title'=> trans('labels.not_confirm_receipt_items_yet'), 'showIf' => "[status] == 0"];
			$this->addaction[] = ['label' => '', 'url' => "javascript:void(0);", 'icon' => 'fa fa-check-square-o', 'color' => 'success','title'=> trans('labels.confirmed_items_receipt') ,'showIf' => "[status] == 1"];
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('detail/[id]'), 'icon' => 'fa fa-truck', 'color' => 'warning','title'=> trans('labels.you_confirm_receipt_just_some_items'), 'showIf' => "[status] == 2"];
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('detail/[id]'), 'icon' => 'fa fa-comments-o', 'color' => 'info', 'title' => trans('labels.transfer_tracking_has_notes'), 'showIf' => "[notes] > 0"];

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
	        $this->script_js = "";
			$this->script_js .=" 
				var  _CHOOSE_ITEM= '".trans('labels.choose_item')."';
				var  _CURRENT_BALANCE = '".trans('alert.current_balance')."';
				var  _CHOOSE_INVENTORY = '".trans('alert.choose_inventory')."';

				var  _ARE_YOU_CONFIRM= '".trans('labels.are_you_confirm')."';
				var  _RECEIPT_NOTIFICATION_MESSAGE= '".trans('labels.receipt_items_notification_message')."';
				var  _YES= '".trans('crudbooster.confirmation_yes')."';
				var  _NO= '".trans('crudbooster.confirmation_no')."';

				var  _PLEASE_CHECK_RECEIPT_ITEMS= '".trans('alert.please_check_receipt_items')."';
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
			$this->load_js[] = asset("js/modules_js/notifications/receipt_items_notifications_script.js");

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
				$query->whereIn('destination',$user_invs);
			}
			$query->where("cycle_id", Session::get('display_cycle'));
			
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
			//some code here
        }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
	        //some code here
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
			//some code here
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
           //some code here
            
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
			//some code here
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
		public function getDetail($id) {
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			  CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = trans('labels.receipt_items_notify');
			$data['row'] = TransferTracking::where('id',$id)->first();
			$data['id'] = $id;
			
			//Please use cbView method instead view method from laravel
			$this->cbView('detail_pages.receipt_items_notification',$data);
		  }
	}