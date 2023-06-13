<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Bills;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Traits\AccountsTrait;
use App\Traits\BillsTrait;
use App\Traits\GeneralTrait;
use DB;
use CRUDBooster;
use App\Models\Accounts\Account;
use App\Models\Users\User;
use App\Models\Accounts\Person;
use App\Models\Bills\Bill;
use App\Models\Bills\BillType;
use App\Models\Entries\Entry;
use App\Models\Entries\EntryBase;
use App\Models\ItemsTracking\ItemTrackingType;
use App\Models\ItemsTracking\ItemTracking;
use App\Models\Accounts\Customer;
use App\Models\Bills\BillItem;
use Session;

class BillsSalesReturnInvoiceController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
    use GeneralTrait,BillsTrait,AccountsTrait;
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
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "bills";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => trans('modules.code'), "name" => "p_code"];
        $this->col[] = ["label" => trans('modules.bill_number'), "name" => "bill_number"];
        $this->col[] = ["label" => trans('modules.account'), "name" => "debit", "join" => "accounts,name_ar"];
        $this->col[] = ["label" => trans('modules.customer'), "name" => "credit", "join" => "accounts,name_ar"];
        $this->col[] = ["label" => trans('modules.date'), "name" => "date"];
        $this->col[] = ["label" => trans('modules.bill_type'), "name" => "bill_type_id", "join" => "bill_types,name_ar"];
        $this->col[] = ["label" => trans('modules.inventory'), "name" => "inventory_id", "join" => "inventories,name_ar"];
        $this->col[] = ["label" => trans('modules.currency'), "name" => "currency_id", "join" => "currencies,name_ar"];
        $this->col[] = ["label" => trans('modules.delegate'), "name" => "delegate_id", "join" => "cms_users,name"];
        $this->col[] = ["label" => trans('modules.staff'), "name" => "staff_id", "join" => "cms_users,name"];
        $this->col[] = ["label" => trans('modules.bill_status'), "name" => "status"];
        $this->col[] = ["label" => "", "name" => "checked_for_update", "visible" => false];


        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $user = CRUDBooster::getUser();
        $this->form = [];
        $this->form[] = ['label' => trans('modules.bill_number'), 'name' => 'bill_number', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
        
        $this->form[] = ['label' => trans('modules.customer'), 'name' => 'credit', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'accounts,name_ar', 'datatable_format' => "code,' - ',name_ar", 'datatable_where' => 'id in (' . implode(',', $user->getCustomersIdsInProcess()) . ')'];
        
        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
            $this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS').') ' . $this->getDelegateCondition()];
        }
        else {
            $this->form[] = ['label' => trans('modules.delegate'), 'name' => 'delegate_id', 'type' => 'select2', 'validation' => '', 'width' => 'col-sm-10', 'datatable' => 'cms_users,name', 'datatable_where' => 'id_cms_privileges in ('.config('setting.DELEGATES_ROLES_IDS').') ' . $this->getDelegateCondition()];
        }

        $this->form[] = ['label' => trans('modules.inventory'), 'name' => 'inventory_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'inventories,name_ar', 'datatable_where' => 'id in (' . implode(',',$user->getInventoriesIds()) . ')'];
        
        $this->form[] = ['label' => trans('modules.currency'), 'name' => 'currency_id', 'type' => 'select2', 'validation' => 'required', 'width' => 'col-sm-10', 'datatable' => 'currencies,name_ar','datatable_where' =>'active=1'];
        $this->form[] = ['label' => trans('modules.ex_rate'), 'name' => 'ex_rate', 'type' => 'number', 'step' => 'any', 'validation' => 'required|min:0.01', 'width' => 'col-sm-10', 'value' => 0];
        $this->form[] = ['label' => trans('modules.date'), 'name' => 'date', 'type' => 'datetime', 'value' => date('Y-m-d H:i:s'), 'validation' => 'required|date', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => trans('modules.notes'), 'name' => 'note', 'type' => 'textarea', 'width' => 'col-sm-10'];
        $is_cash_values = '1|'.trans('modules.yes').';0|'.trans('modules.no');
        if($user->roleId == 6){ //factory delegate
            $is_cash_values = '0|'.trans('modules.no');
        }
        $this->form[] = ['label' => trans('modules.is_cash'), 'name' => 'is_cash', 'type' => 'radio', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => $is_cash_values, 'value' => '0'];
        $this->form[] = ['label' => trans('modules.bill_type'), 'name' => 'bill_type_id', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10', 'style' => 'display:none', 'value' => '4'];

        $columns[] = ['label' => trans('modules.item'), 'name' => 'item_id', 'type' => 'select', 'datatable' => 'items,name_ar', 'required' => true];
        $columns[] = ['label' => trans('modules.quantity'), 'name' => 'quantity', 'type' => 'number', 'required' => true];
        $columns[] = ['label' => trans('modules.unit_price'), 'name' => 'unit_price', 'type' => 'number', 'required' => true];
        $columns[] = ['label' => trans('modules.subtotal'), 'name' => 'subtotal', 'type' => 'number', 'formula' => "[unit_price] * [quantity]", "readonly" => true, 'required' => true];
        $this->form[] = ['label' => trans('modules.add_item_en_ar'), 'name' => 'bills_items', 'type' => 'child', 'columns' => $columns, 'table' => 'bills_items', 'foreign_key' => 'bill_id'];
        $columnsFiles[] = ['label' => trans('modules.image'), 'name' => 'file_id', 'type' => 'upload', 'required' => true, 'upload_type' => 'image'];
        $this->form[] = ['label' => trans('modules.add_image_en_ar'), 'name' => 'bills_files', 'type' => 'child', 'columns' => $columnsFiles, 'table' => 'bills_files', 'foreign_key' => 'bill_id'];
        $this->form[] = ['label' => trans('modules.bill_amount'), 'name' => 'amount', 'type' => 'number', "readonly" => true, 'required' => true];
        $this->form[] = ['label' => trans('modules.discount'), 'name' => 'discount', 'type' => 'number', 'step' => 'any', 'required' => true, 'value' => 0, 'min' => 0];
        $this->form[] = ['label' => trans('modules.after_discount'), 'name' => 'after_discount', 'type' => 'number', 'step' => 'any', "readonly" => true, 'required' => true];

        $bill_status = array('1|'.trans('labels.active_bill'), '0|'.trans('labels.draft_bill'));
        $status_value = '';
        if (CRUDBooster::getCurrentMethod() == 'getAdd') {
            $status_value = '1';
        }
		$this->form[] = ['label' => trans('modules.bill_status'), 'name' => 'status', 'type' => 'select', 'validation' => 'required', 'width' => 'col-sm-10', 'dataenum' => '' . implode(';', $bill_status) . '','value' => $status_value];
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
        $gfunc = new GeneralFunctionsController();
        $hasPermission = $gfunc->checkOldCycleHasEditedPermission();
        
        $this->addaction = array();
        if (CRUDBooster::isSuperAdmin() && $hasPermission) {
            $this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/true/[id]'), 'icon' => 'fa fa-check', 'color' => 'success', 'title' => trans('modules.checked'), 'showIf' => "[checked_for_update] == '0'"];
            $this->addaction[] = ['label' => '', 'url' => CRUDBooster::mainpath('set-status/false/[id]'), 'icon' => 'fa fa-ban', 'color' => 'warning', 'title' => trans('modules.remove_checked'), 'showIf' => "[checked_for_update] == '1'"];
            $this->button_edit = true;
        }
        $this->addaction[] = ['label' => '', 'url' => 'javascript:void(0);', 'icon' => 'fa fa-image', 'color' => 'info', 'title' => trans('messages.bill_has_attach'), 'showIf' => "[attach] > 0"];

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
        if (CRUDBooster::isSuperAdmin() && $hasPermission) {
            $this->button_selected[] = ['label' => trans('modules.checked'), 'icon' => 'fa fa-check', 'name' => 'set_checked'];
            $this->button_selected[] = ['label' => trans('modules.remove_checked'), 'icon' => 'fa fa-ban', 'name' => 'set_remove_checked'];
        }

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
        if(CRUDBooster::isColumnExists($this->table,'checked_for_update')){
			$this->table_row_color[] = ["condition" => "[checked_for_update]==1", "color" => "info checked"];
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
            var  _YOU_MUST_CHOOSE_CUSTOMER= '".trans('alert.you_must_choose_customer_if_bill_isnot_cash')."';
            var  _BILL_NUMBER_IS_USED= '".trans('alert.document_number_is_used')."';
            var  _CHOOSE_INVENTORY = '".trans('labels.choose_inventory')."';
            var  _DISCOUNT_MUST_BY_Positive= '".trans('alert.discount_must_be_positive')."';
            var  _TABLE_DATA_NOT_FOUND= '".trans('crudbooster.table_data_not_found')."';
            var  _CHANGE_INVENTORY_CONFIRM_MESSAGE= '".trans('messages.change_inventory_confirm_message')."';
            var  _CHOOSEN_DATE_IS_GREATER_THAN_CURRENT_DATE= '".trans('alert.choosen_date_is_greater_than_current_date')."';
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
        $this->load_js[] = asset("js/modules_js/bills/bills_sales_return_invoice_script1.js");
        if (CRUDBooster::isManager()) {
            $this->load_js[] = asset("js/modules_js/bills/bills_sales_return_invoice_script2.js");
        }

        if (CRUDBooster::getCurrentMethod() == 'getEdit') {
            $this->load_js[] = asset("js/modules_js/bills/bills_sales_return_invoice_script3.js");
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
            .selected-action ul li:nth-child(1),
            .selected-action ul li:nth-child(2),
            .selected-action ul li:nth-child(3) {
                display: none !important;
            }
            ";
        if (!CRUDBooster::isSuperAdmin()) {
            $this->style_css .= "
                    .selected-action {
                        display: none !important;
                    }
                    tr.checked .btn-edit, tr.checked .btn-delete{
                        display:none;
                    }
                ";
        }

        if (in_array($user->roleId,explode(',',config('setting.DELEGATES_ROLES_IDS')))) {
			$this->style_css .= "
					#form-group-delegate_id{
						cursor:not-allowed;
					}
					#form-group-delegate_id div {
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

    public function getSetStatus($status, $id)
    {


        if ($status == 'true')
            $status = true;
        elseif ($status == 'false')
            $status = false;


        Bill::where('id', $id)->update(['checked_for_update' => $status]);

        //This will redirect back and gives a message
        if ($status) {
            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.bill_status_changed_and_delegate_doesnot_have_permission_on_this_bill'), "success");
        }
        else {
            CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.bill_status_changed_and_delegate_has_permission_on_this_bill'), "success");
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
        if ($button_name == 'set_checked') {
            Bill::whereIn('id', $id_selected)->update(['checked_for_update' => '1']);
        }
        if ($button_name == 'set_remove_checked') {
            Bill::whereIn('id', $id_selected)->update(['checked_for_update' => '0']);
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
        if ($user->roleId == 4) {
            $query->where('bills.delegate_id', $user->id);
        }

        if (in_array($user->roleId,[3,6])) { //sales manager & factory Delegate
            $query->whereNotIn('bills.staff_id',$this->getAdminsIds());
        }

        $query = $query->where("bill_type_id", 4);
        $query = $query->where("action", NULL);
        $query = $query->where("cycle_id", Session::get('display_cycle'));
        


        $query = $query->select('bills.id as id', DB::raw("(SELECT count(*) FROM bills_files
                                    WHERE bills_files.bill_id = bills.id ) as attach "));
    }

    /*
     | ----------------------------------------------------------------------
     | Hook for manipulate row of index table html
     | ----------------------------------------------------------------------
     |
     */
    public function hook_row_index($column_index, &$column_value)
    {
        if($column_index == 11){
            if($column_value == 1){
                $column_value = '<span class="badge bg-green">'.trans('labels.active_bill').'</span>';
            }else if($column_value == 0){
                $column_value = '<span class="badge bg-yellow">'.trans('labels.draft_bill').'</span>';
            }
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

        //check bill to prevent empty bill or box don't have enought money
        $this->checkBill($postdata, 'add', null, 4);

        $user = CRUDBooster::getUser();

        $max = Bill::where("bill_type_id", 4)->where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
        $prefixCode = BillType::where('id', 4)->select('prefix')->first();

        $postdata["code"] = ($max) ? $max + 1 : 1;
        $postdata['p_code'] = $prefixCode->prefix . '' . $postdata['code'];

        //check if p_code is unique
        $this->checkP_Code($postdata['p_code']);

        $postdata["staff_id"] = CRUDBooster::myId();
        $account = Account::where("id", "=", $this->getSystemConfigValue('Sales_Return_Account'))->first();
        $postdata["debit"] = $account->id;

        $currency = $this->getExchangeRate($postdata['currency_id']);
        if ($postdata['ex_rate'] != $currency->ex_rate) {
            $this->changeExchangeRate($currency->id, $postdata['ex_rate']);
        }

        $postdata['equalizer'] = (int)$postdata['ex_rate'] * (int)$postdata['amount'];

        $postdata["bill_type_id"] = 4;
        if ($postdata["is_cash"] == 1) {
            if ($user->hasBox == 'own') {
                $this->box = $user->boxAccount;
            }
            else {

                $box_account_id = $this->getSystemConfigValue("General_Box");
                if ($box_account_id)
                    $this->box = $box_account_id;
            }
        }

        if ($postdata["is_cash"] == 0 && $postdata["credit"] == null) { //check if debit not null if is_cash is 0
            $this->setItemsDataToSession();
            return CRUDBooster::redirect(CRUDBooster::mainpath("add/"), trans('messages.no_save_isnot_cash_bill_if_donot_select_customer'), "danger");
        }

        $postdata['create_by'] = CRUDBooster::myId();

    }

    public $customerId;
    public $accountId;
    public $box;

    /*
     | ----------------------------------------------------------------------
     | Hook for execute command after add public static function called
     | ----------------------------------------------------------------------
     | @id = last insert id
     |
     */
    public function hook_after_add($id)
    {

        DB::beginTransaction();
        try {
            $bill = Bill::find($id);
            $afterDiscount_amount = $bill->after_discount;

            $bill_details = BillItem::where('bill_id', $bill->id)->sum('subtotal');
            $max = EntryBase::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('entry_number');
            $entry_number = $max + 1;

            $entry_base_id = EntryBase::insertGetId([
                'entry_number' => $entry_number,
                'narration' => $bill->note,
                'date' => $bill->date,
                'bill_id' => $id,
                'active' => 1,
                'cycle_id' => Session::get('display_cycle'),
                'create_by' => CRUDBooster::myId()

            ]);

            
            if ($bill->is_cash) {


                Entry::insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $afterDiscount_amount,
                    'account_id' => $this->box,
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                    'currency_id' => $bill->currency_id,
                    'create_by' => CRUDBooster::myId(),
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status

                ]);
                if ($bill->credit != NULL) { //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                    Entry::insert([
                        'entry_base_id' => $entry_base_id,
                        'debit' => $afterDiscount_amount,
                        'account_id' => $bill->credit,
                        'credit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                        'currency_id' => $bill->currency_id,
                        'create_by' => CRUDBooster::myId(),
                        'cycle_id' => Session::get('display_cycle'),
                        'status'=> $bill->status

                    ]);
                }
            }


            Entry::insert([
                'entry_base_id' => $entry_base_id,
                'debit' => $bill_details,
                'account_id' => $bill->debit,
                'credit' => null,
                'ex_rate' => $bill->ex_rate,
                'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                'currency_id' => $bill->currency_id,
                'create_by' => CRUDBooster::myId(),
                'cycle_id' => Session::get('display_cycle'),
                'status'=> $bill->status

            ]);
            if ($bill->credit != NULL) { //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                Entry::insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $bill_details,
                    'account_id' => $bill->credit,
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                    'currency_id' => $bill->currency_id,
                    'create_by' => CRUDBooster::myId(),
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status

                ]);
            }


            if ($bill->discount > 0) {

                Entry::insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $bill->discount,
                    'account_id' => $this->getSystemConfigValue('Earned_Discount'),
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                    'currency_id' => $bill->currency_id,
                    'create_by' => CRUDBooster::myId(),
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status

                ]);
                if ($bill->credit != NULL) { //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                    Entry::insert([
                        'entry_base_id' => $entry_base_id,
                        'debit' => $bill->discount,
                        'account_id' => $bill->credit,
                        'credit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                        'currency_id' => $bill->currency_id,
                        'create_by' => CRUDBooster::myId(),
                        'cycle_id' => Session::get('display_cycle'),
                        'status'=> $bill->status

                    ]);
                }
            }


            $max = ItemTracking::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
            $Bills_items = BillItem::where("bill_id", $id)->get();
            $bill = Bill::find($id);

            $opr = "";
            if ($bill->bill_type_id == 1) {
                $opr = "in";
            }
            else if ($bill->bill_type_id == 2) {
                $opr = "out";
            }
            else if ($bill->bill_type_id == 3) {
                $opr = "out";
            }
            else if ($bill->bill_type_id == 4) {
                $opr = "in";
            }
            $prefixCode = ItemTrackingType::where('id', 4)->select('prefix')->first();
            $prefix = $prefixCode->prefix . '' . ($max + 1);

            foreach ($Bills_items as $key => $item) {
                ItemTracking::insert([
                    'code' => $max + 1,
                    'item_id' => $item->item_id,
                    'item_tracking_type_id' => $bill->bill_type_id,
                    'source' => $bill->inventory_id,
                    'date' => $bill->date,
                    'quantity' => $item->quantity,
                    'bill_id' => $bill->id,
                    'note' => $bill->note,
                    'transaction_operation' => $opr,
                    'p_code' => $prefix,
                    'create_by' => CRUDBooster::myId(),
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status

                ]);
            }
            DB::commit();

        }
        catch (\Exception $e) {
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
    public function hook_before_edit(&$postdata, $id)
    {
        //check bill to prevent empty bill or box don't have enought money
        $this->checkBill($postdata, 'edit', $id, 4);

        $user = CRUDBooster::getUser();

        //$postdata["staff_id"] = CRUDBooster::myId();

        $account = Account::where("id", "=", $this->getSystemConfigValue('Sales_Return_Account'))->first();
        $postdata["debit"] = $account->id;

        $postdata["bill_type_id"] = 4;

        if ($postdata["is_cash"] == 1) {
            if ($user->hasBox == 'own') {
                $this->editBox = $user->boxAccount;
            }
            else {

                $box_account_id = $this->getSystemConfigValue("General_Box");
                if ($box_account_id)
                    $this->editBox = $box_account_id;
            }
        }

        if ($postdata["is_cash"] == 0 && $postdata["credit"] == null) { //check if debit not null if is_cash is 0
            $this->setItemsDataToSession();
            return CRUDBooster::redirect(CRUDBooster::mainpath("edit/" . $id), trans('messages.no_save_isnot_cash_bill_if_donot_select_customer'), "danger");
        }

        //change ex_rate if is different
        $currency = $this->getExchangeRate($postdata['currency_id']);
        if ($postdata['ex_rate'] != $currency->ex_rate) {
            $this->changeExchangeRate($currency->id, $postdata['ex_rate']);
        }

        //create new bill with another id and save old data to new record with delete_by delete_at
        //change forgin key in others tables bill_id to new copy of bill with delete_by delete_at
        $this->makeBillAsDeleted($id); //in GeneralTrait
        
        $postdata["edit_by"] = CRUDBooster::myId();
        $postdata["edit_at"] = date('Y-m-d H:i:s');


    }

    public $editCustomerId;

    public $editBox;

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
        DB::beginTransaction();
        try {

            $bill = Bill::find($id);
            $afterDiscount_amount = $bill->after_discount;


            $bill_details = BillItem::where('bill_id', $bill->id)->sum('subtotal');
            $max = EntryBase::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('entry_number');
            $entry_number = $max + 1;

            $entry_base_id = EntryBase::insertGetId([
                'entry_number' => $entry_number,
                'narration' => $bill->note,
                'date' => $bill->date,
                'bill_id' => $id,
                'active' => 1,
                'cycle_id' => Session::get('display_cycle'),
                'create_by' => $bill->create_by
            ]);

            
            if ($bill->is_cash) {

                Entry::insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $afterDiscount_amount,
                    'account_id' => $this->editBox,
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                    'currency_id' => $bill->currency_id,
                    'create_by' => $bill->create_by,
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status


                ]);
                if ($bill->credit != NULL) { //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                    Entry::insert([
                        'entry_base_id' => $entry_base_id,
                        'debit' => $afterDiscount_amount,
                        'account_id' => $bill->credit,
                        'credit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$bill->discount,
                        'currency_id' => $bill->currency_id,
                        'create_by' => $bill->create_by,
                        'cycle_id' => Session::get('display_cycle'),
                        'status'=> $bill->status
                    ]);
                }
            }

            
            Entry::insert([
                'entry_base_id' => $entry_base_id,
                'debit' => $bill_details,
                'account_id' => $bill->debit,
                'credit' => null,
                'ex_rate' => $bill->ex_rate,
                'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                'currency_id' => $bill->currency_id,
                'create_by' => $bill->create_by,
                'cycle_id' => Session::get('display_cycle'),
                'status'=> $bill->status


            ]);
            if ($bill->credit != NULL) { //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                Entry::insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $bill_details,
                    'account_id' => $bill->credit,
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$bill_details,
                    'currency_id' => $bill->currency_id,
                    'create_by' => $bill->create_by,
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status


                ]);
            }

            if ($bill->discount > 0) {


                Entry::insert([
                    'entry_base_id' => $entry_base_id,
                    'credit' => $bill->discount,
                    'account_id' => $this->getSystemConfigValue('Earned_Discount'),
                    'debit' => null,
                    'ex_rate' => $bill->ex_rate,
                    'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                    'currency_id' => $bill->currency_id,
                    'create_by' => $bill->create_by,
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status

                ]);
                if ($bill->credit != NULL) { //في حال كانت عملية مردود مبيع كاش لزبون  ليس له حساب
                    Entry::insert([
                        'entry_base_id' => $entry_base_id,
                        'debit' => $bill->discount,
                        'account_id' => $bill->credit,
                        'credit' => null,
                        'ex_rate' => $bill->ex_rate,
                        'equalizer' => (int)$bill->ex_rate * (int)$afterDiscount_amount,
                        'currency_id' => $bill->currency_id,
                        'create_by' => $bill->create_by,
                        'cycle_id' => Session::get('display_cycle'),
                        'status'=> $bill->status

                    ]);
                }
            }




            $max = ItemTracking::where('action', NULL)->where('cycle_id', Session::get('display_cycle'))->max('code');
            $Bills_items = BillItem::where("bill_id", $id)->get();
            $bill = Bill::find($id);

            $opr = "";
            if ($bill->bill_type_id == 1) {
                $opr = "in";
            }
            else if ($bill->bill_type_id == 2) {
                $opr = "out";
            }
            else if ($bill->bill_type_id == 3) {
                $opr = "out";
            }
            else if ($bill->bill_type_id == 4) {
                $opr = "in";
            }

            $prefixCode = ItemTrackingType::where('id', 4)->select('prefix')->first();
            $prefix = $prefixCode->prefix . '' . ($max + 1);

            foreach ($Bills_items as $key => $item) {
                ItemTracking::insert([
                    'code' => $max + 1,
                    'item_id' => $item->item_id,
                    'item_tracking_type_id' => $bill->bill_type_id,
                    'source' => $bill->inventory_id,
                    'date' => $bill->date,
                    'quantity' => $item->quantity,
                    'bill_id' => $bill->id,
                    'note' => $bill->note,
                    'transaction_operation' => $opr,
                    'p_code' => $prefix,
                    'create_by' => $bill->create_by,
                    'cycle_id' => Session::get('display_cycle'),
                    'status'=> $bill->status

                ]);
            }


            DB::commit();

        }
        catch (\Exception $e) {
            // Rollback Transaction
            DB::rollback();
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
        $this->deleteBill($id);

        return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.delete_bill_success'), "success");

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



    public function getEdit($id)
    {

        $bill = Bill::find($id);
        if(!CRUDBooster::isManager() && ($bill->delegate_id !== CRUDBooster::getUser()->id)){
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_update_permission_on_other_delegate_bill'), "warning");
        }
        if (!CRUDBooster::isSuperadmin() && $bill->checked_for_update == 1) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_update_permission_on_this_bill'), "warning");

        }
        return parent::getEdit($id); // TODO: Change the autogenerated stub
    }


    public function getDelete($id)
    {

        $bill = Bill::find($id);
        if(!CRUDBooster::isManager() && ($bill->delegate_id !== CRUDBooster::getUser()->id)){
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_delete_permission_on_other_delegate_bill'), "warning");
        }
        if (!CRUDBooster::isSuperadmin() && $bill->checked_for_update == 1) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.you_donnot_have_delete_permission_on_this_bill'), "warning");
        }
        return parent::getDelete($id); // TODO: Change the autogenerated stub
    }




}