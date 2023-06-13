<?php 
    namespace App\Http\Controllers;
    namespace App\Http\Controllers\Notifications;

	use App\Http\Controllers\General\VouchersFunctionsController;
    use App\Traits\VouchersTrait;
    use DB;
	use CRUDBooster;
    use App\Traits\GeneralTrait;
    use App\Http\Controllers\General\GeneralFunctionsController;
    use App\Models\Accounts\Account;
    use App\Models\Users\User;
    use App\Models\Accounts\Person;
    use App\Models\Currencies\Currency;
    use App\Models\Entries\Entry;
    use App\Models\Entries\EntryBase;
    use App\Models\Vouchers\Voucher;
    use App\Models\Vouchers\VoucherType;
    use App\Models\Vouchers\VoucherFile;
    use Session;

	class ReceiptNotificationsController extends \crocodicstudio_voila\crudbooster\controllers\CBController
    {
        use GeneralTrait,VouchersTrait;
        public function cbInit()
        {

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
            $this->table = "vouchers";
            # END CONFIGURATION DO NOT REMOVE THIS LINE

            # START COLUMNS DO NOT REMOVE THIS LINE
            $user = CRUDBooster::getUser();

            $this->col = [];
            $this->col[] = ["label" => trans('modules.code'), "name" => "p_code","type" => "hidden"];
            $this->col[] = ["label" => trans('modules.voucher_number'), "name" => "voucher_number"];
            $this->col[] = ["label"=>trans('modules.date'),"name"=>"date"];
            $this->col[] = ["label" => trans('modules.debit_account'), "name" => "debit", "join" => "accounts,name_ar"];
            $this->col[] = ["label" => trans('modules.credit_account'), "name" => "credit", "join" => "accounts,name_ar"];
            $this->col[] = ["label" => trans('modules.delegate'), "name" => "delegate_id", "join" => "cms_users,name"];
            $this->col[] = ["label" => trans('modules.currency'), "name" => "currency_id", "join" => "currencies,name_ar"];
            $this->col[] = ["label" => trans('modules.voucher_amount'), "name" => "amount"];
            $this->col[] = ["label" => trans('modules.narration'), "name" => "narration"];
            if ($user->showStaffFeild == true)
                $this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name"];
            else
                $this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name", "visible" => false];

            $this->col[] = ["label" => "", "name" => "status", "visible" => false];
            # END COLUMNS DO NOT REMOVE THIS LINE

            # START FORM DO NOT REMOVE THIS LINE
            
            $this->form = [];
            $this->form[] = ['label' => trans('modules.transfer_number'), 'name' => 'voucher_number', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
            //$this->form[] = ['label' => trans('modules.code'), 'name' => 'code', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10'];
            
            $vfunc = new VouchersFunctionsController();
            $tv_accountsIds = $vfunc->getTransferVoucherAccountsIds();
            $this->form[] = ['label' => trans('modules.debit_account'), 'name' => 'debit', 'type' => 'select2', 'width' => 'col-sm-10', 'validation' => 'required', 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification = 0','datatable_where' =>'id in ('.implode(',',$tv_accountsIds).')'];
            $this->form[] = ['label' => trans('modules.credit_account'), 'name' => 'credit', 'type' => 'select2', 'width' => 'col-sm-10', 'validation' => 'required', 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification = 0','datatable_where' =>'id = '.$user->boxAccount];

            if(!CRUDBooster::isManager()){
                $this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS').')' . $this->getDelegateCondition()];
            }
            $this->form[] = ['label' => trans('modules.narration'), 'name' => 'narration', 'type' => 'text', 'validation' => 'required','width' => 'col-sm-10'];
            $this->form[] = ['label' => trans('modules.date'), 'name' => 'date',  'validation' => 'required', 'type' => 'datetime','value' => date('Y-m-d H:i:s', time()), 'width' => 'col-sm-10'];
            $this->form[] = ['label' => trans('modules.credit_currency'), 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'currencies,name_ar','datatable_where' =>'active=1'];
            $this->form[] = ['label' => trans('modules.credit_amount'), 'name' => 'amount', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:1', 'width' => 'col-sm-10'];
            $columns[] = ['label' => trans('modules.image'), 'name' => 'file_id', 'type' => 'upload', 'required' => true ,'upload_type'=>'image'];
            $this->form[] = ['label' => trans('modules.add_image_en_ar'), 'name' => 'vouchers_files', 'type' => 'child', 'columns' => $columns, 'table' => 'vouchers_files', 'foreign_key' => 'voucher_id'];
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
			$this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/true/[id]'), 'icon' => 'fa  fa-check-circle', 'color' => 'warning','title'=> trans('labels.not_confirm_receipt_amount_yet'), 'showIf' => "[status] == 0",'confirmation'=>true,'confirmation_title'=> trans('labels.are_you_confirm'),'confirmation_text'=>trans('labels.receipt_notification_message')];
			$this->addaction[] = ['label' => '', 'url' => "javascript:void(0);", 'icon' => 'fa fa-check-square-o', 'color' => 'success','title'=> trans('labels.confirmed_receipt') ,'showIf' => "[status] == 1"];

            $this->addaction[] = ['label'=>'','url'=>'javascript:void(0);','icon'=>'fa fa-image','color'=>'info','title'=> trans('messages.voucher_has_attach'),'showIf'=>"[attach] > 0"];
			
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
            // if(CRUDBooster::isColumnExists($this->table,'checked_for_update')){
            //     $this->table_row_color[] = ["condition" => "[checked_for_update]==1", "color" => "info checked"];
            // }

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
                var  _VOUCHER_NUMBER_IS_USED= '".trans('alert.document_number_is_used')."';
                var  _CREDIT_ACCOUNT_BALANCE= '".trans('alert.credit_account_balance')."';
                var  _NOT_ENOUGH_CURRENT_BALANCE_IS= '".trans('alert.not_enough_current_balance_is')."';
                
				var  _ARE_YOU_CONFIRM= '".trans('labels.are_you_confirm')."';
				var  _RECEIPT_NOTIFICATION_MESSAGE= '".trans('labels.receipt_notification_message')."';
				var  _YES= '".trans('crudbooster.confirmation_yes')."';
				var  _NO= '".trans('crudbooster.confirmation_no')."';

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
            $this->load_js[] = asset("js/modules_js/notifications/receipt_notifications_script.js");
          

            /*
            | ----------------------------------------------------------------------
            | Add css style at body
            | ----------------------------------------------------------------------
            | css code in the variable
            | $this->style_css = ".style{....}";
            |
            */
            $this->style_css = "
                .selected-action ul li:nth-child(1),
                .selected-action ul li:nth-child(2),
                .selected-action ul li:nth-child(3) {
                    display: none !important;
                } 
            ";
            if(!CRUDBooster::isSuperAdmin()) {
                $this->style_css .= "
                    .selected-action {
                        display: none !important;
                    }
                    tr.checked .btn-edit, tr.checked .btn-delete{
                        display:none;
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

        public function getSetStatus($status, $id)
        {
            if ($status == 'true')
                $status = true;

				$user = CRUDBooster::getUser();	
				$voucher = Voucher::find($id);
				$voucher->update([
					'status'=>1,
					'receipt_date'=>date('Y-m-d H:i:s'),
					'receipt_by'=>$user->id
				]);

				$debit_entry = $voucher->entries->where('account_id',$user->boxAccount)->first();
				if($debit_entry){
					$debit_entry->update([
						'status'=>1
					]);
				}
            //This will redirect back and gives a message
            if($status){
                CRUDBooster::redirect($_SERVER['HTTP_REFERER'],trans('labels.you_confirm_receipt_amount'),"success");
            }
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
            if($button_name == 'set_checked') {
                Voucher::whereIn('id',$id_selected)->update(['checked_for_update'=>'1']);
            }  
            if($button_name == 'set_remove_checked') {
                Voucher::whereIn('id',$id_selected)->update(['checked_for_update'=>'0']);
            }
            
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
            $query->where('vouchers.debit', $user->boxAccount);
            $query->where("voucher_type_id", 3);
            $query->where("action", NULL);
            $query->where("cycle_id", Session::get('display_cycle'));
            
    
            $query = $query->select('vouchers.id as id',DB::raw("(SELECT count(*) FROM vouchers_files
                                    WHERE vouchers_files.voucher_id = vouchers.id ) as attach "));
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
            if($column_index == 8){
				$column_value = number_format($column_value,2);
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
            //some code here
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
        public function hook_before_edit(&$postdata, $id)
        {
           //some code here
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
          //some code here
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
          //some code here
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
		public function getDetail($id) {
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			  CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = trans('labels.receipt_notify');
			$data['row'] = Voucher::where('id',$id)->first();
			$data['id'] = $id;
			
			//Please use cbView method instead view method from laravel
			$this->cbView('detail_pages.receipt_notification',$data);
		  }
		  

    }
