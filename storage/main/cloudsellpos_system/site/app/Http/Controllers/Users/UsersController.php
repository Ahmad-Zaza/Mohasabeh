<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Users;

use App\Models\Accounts\SuppliersDelegates;
use App\Models\Entries\Entry;
use App\Models\Inventories\InventoriesDelegates;
use App\Models\Users\GeneralDelegate;
use DB;
use CRUDbooster;
use App\Models\Accounts\Account;
use App\Traits\GeneralTrait;
use App\Models\Users\User;
use App\Models\Bills\Bill;
use App\Models\Vouchers\Voucher;
use App\Models\Users\Delegate;
class UsersController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{
    use GeneralTrait;
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = 'cms_users';
        $this->primary_key = 'id';
        $this->title_field = "name";
        $this->button_action_style = 'button_icon';
        $this->button_import = FALSE;
        $this->button_export = FALSE;
        
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => trans('modules.name'), "name" => "name");
        $this->col[] = array("label" => trans('modules.email'), "name" => "email");
        $this->col[] = array("label" => trans('crudbooster.Privilege'), "name" => "id_cms_privileges", "join" => "cms_privileges,name");
        $this->col[] = array("label" => trans('crudbooster.Photo'), "name" => "photo", "image" => 1);
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = array();
        $this->form[] = array("label" => trans('modules.name'), "name" => "name", 'required' => true, 'validation' => 'required|alpha_spaces|min:3|unique:cms_users,name');
        $this->form[] = array("label" => trans('modules.email'), "name" => "email", 'required' => true, 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
        $this->form[] = array("label" => trans('modules.image'), "name" => "photo", "type" => "filemanager", "help" => "القياس المفضل 200x200px", 'resize_width' => 90, 'resize_height' => 90);
        $this->form[] = array("label" => trans('crudbooster.Role'), "name" => "id_cms_privileges", "type" => "select", "datatable" => "cms_privileges,name", 'required' => true);
        
        // $this->form[] = array("label"=>"Password","name"=>"password","type"=>"password","help"=>"Please leave empty if not change");

        if (CRUDBooster::getCurrentMethod() == 'getEdit' || CRUDBooster::getCurrentMethod() == 'getProfile') {
            $this->form[] = array("label" => trans('modules.password'), "name" => "password", "type" => "password", "validation" => "min:8", "help" => trans('help.users_password_help'));
            $this->form[] = array("label" => trans('modules.password_confirmation'), "name" => "password_confirmation", "type" => "password", "validation" => "min:8", "help" => trans('help.users_password_help'));
        }
        else {
            $this->form[] = array("label" => trans('modules.password'), "name" => "password", "type" => "password", "validation" => "required|min:8",'required' => true, "help" => trans('help.please_enter_your_password'));
            $this->form[] = array("label" => trans('modules.password_confirmation'), "name" => "password_confirmation", "type" => "password", "validation" => "required|min:8",'required' => true, "help" => trans('help.please_enter_your_password_again'));
        }

        if (CRUDBooster::getCurrentMethod() != 'getProfile') {

            if (CRUDBooster::getCurrentMethod() != 'getAdd') {
                $this->form[] = array("label" => trans('modules.delegate_customers_account'), "name" => "customers_account_id", "type" => "select2", 'required' => false, 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification=1');
            }

            $id = CRUDBooster::getCurrentId();
            $method = CRUDBooster::getCurrentMethod();
            $custom_select = view('custom.multi_inventories_select', ['id' => $id, 'method' => $method])->render();
            $this->form[] = ["label" => trans('crudbooster.Inventories'), "name" => "inventories", "type" => "custom", "html" => $custom_select, "help" => trans('help.users_management_inventories_help')];


            $custom2_select = view('custom.multi_suppliers_select', ['id' => $id, 'method' => $method])->render();
            $this->form[] = ["label" => trans('crudbooster.Suppliers'), "name" => "suppliers", "type" => "custom", "html" => $custom2_select, "help" => trans('help.users_management_suppliers_help')];

        }
        # END FORM DO NOT REMOVE THIS LINE

        if (CRUDBooster::getCurrentMethod() == 'getIndex') {
            $this->alert[] = ['message' => trans('messages.users_info_message'), 'type' => 'info'];
        }

        $this->index_button = array();
        if (CRUDBooster::getCurrentMethod() == 'getIndex') {
            $this->index_button[] = ['label' => trans('modules.display_roles'), 'url' => CRUDBooster::mainpath("display-roles"), "icon" => "fa fa-bars"];
        }

        $this->script_js = NULL;
        $this->script_js .=" 
				var  _PASSWORD_ISNOT_SIMILAR= '".trans('alert.password_isnot_similar')."';
				var  _PASSWORD_IS_SIMILAR= '".trans('alert.password_is_similar')."';
				var  _THIS_ROLE_IS_DELEGATE_YOU_CANOT_CHANGE_IT= '".trans('alert.this_role_is_delegate_you_canot_change_it')."';
                var  _NUM_PASSWORD_CHARACTERS_LEAST_THAN_DEFAULT= '".trans('alert.num_password_characters_least_than_default')."';
                var  _NUM_PASSWORD_CHARACTERS_CORRECT= '".trans('alert.num_password_characters_correct')."';
		";
        $this->script_js .="
			$('#name').change(function(){
				$(this).val($(this).val().trim());
			});
            $('#form-group-id_cms_privileges').find('.help-block').append(' ".trans('help.read_more_about_system_privilages')." <a href=\"".CRUDBooster::mainpath("display-roles")."\" target=\"blank\">  ".trans('modules.display_roles')." </a>');
		";

        if (CRUDBooster::getCurrentMethod() != 'getIndex') {
            $this->load_js[] = asset("js/modules_js/users/users_script1.js");
        }
        if (CRUDBooster::getCurrentMethod() == 'getEdit') {
            $this->load_js[] = asset("js/modules_js/users/users_script2.js");
        }
        
        $this->load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");

        $this->style_css = "
            i.show-password-eye {
                position: absolute;
                left: 20px;
                top: 10px;
                cursor:pointer;
            }

            .selected-action {
                display:none !important;
            }
        ";
        if(CRUDBooster::getCurrentMethod() == 'getEdit'){
            $this->style_css .= "
            #form-group-id_cms_privileges{
                pointer-events: none;
            }
            ";
        }

        $this->load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");

    }


    public function getProfile()
    {

        $this->button_addmore = FALSE;
        $this->button_cancel = FALSE;
        $this->button_show = FALSE;
        $this->button_add = FALSE;
        $this->button_delete = FALSE;
        $this->hide_form = ['id_cms_privileges'];

        $data['page_title'] = trans("crudbooster.label_button_profile");
        $data['row'] = CRUDBooster::first('cms_users', CRUDBooster::myId());
        $this->cbView('crudbooster::default.form', $data);
    }


    public function hook_before_add(&$postdata)
    {
        $avilableDelegatesNum = $this->getPackageConfigValue('users_num');
        //check if package config allow to add user
        $users_now = User::get();
        if ($avilableDelegatesNum > 0 && count($users_now) + 1 > $avilableDelegatesNum) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.cannot_add_new_user_allowed_count_is') ." $avilableDelegatesNum", "warning");
        }

        DB::beginTransaction();

        try {

            if (in_array($postdata['id_cms_privileges'],[3,4])) { //check role if sales manager or delegate
                $code = Account::getCode($this->getSystemConfigValue('Delegates_Parent_Account'));

                $accountId = Account::insertGetId([
                    'name_en' => trans('modules.box_en'). ' ' . $postdata['name'],
                    'name_ar' => trans('modules.box'). ' ' . $postdata['name'],
                    'code' => $code,
                    'parent_id' => $this->getSystemConfigValue('Delegates_Parent_Account'),
                    'major_classification' => 0,
                    "active" => 1

                ]);

                $postdata['account_id'] = $accountId;
                
                //generate customers account id

                $newcode = Account::getCode($this->getSystemConfigValue('Customers_Account'));
                $customersAccountId = Account::insertGetId([
                    'name_en' => trans('modules.costomers_en') . ' ' . $postdata['name'],
                    'name_ar' => trans('modules.costomers') . ' ' . $postdata['name'],
                    'code' => $newcode,
                    'parent_id' => $this->getSystemConfigValue('Customers_Account'),
                    'major_classification' => 1,
                    "active" => 1

                ]);

                $postdata['customers_account_id'] = $customersAccountId;

            }else if (in_array($postdata['id_cms_privileges'],[6])) { //check role if Factory delegate
                
                $newcode = Account::getCode($this->getSystemConfigValue('Customers_Account'));
                $customersAccountId = Account::insertGetId([
                    'name_en' => trans('modules.costomers_en') . ' ' . $postdata['name'],
                    'name_ar' => trans('modules.costomers') . ' ' . $postdata['name'],
                    'code' => $newcode,
                    'parent_id' => $this->getSystemConfigValue('Customers_Account'),
                    'major_classification' => 1,
                    "active" => 1

                ]);

                $postdata['customers_account_id'] = $customersAccountId;

            }else if (in_array($postdata['id_cms_privileges'],[7])) { //check role if Factory Cashier
                $code = Account::getCode($this->getSystemConfigValue('Delegates_Parent_Account'));

                $accountId = Account::insertGetId([
                    'name_en' => trans('modules.box_en'). ' ' . $postdata['name'],
                    'name_ar' => trans('modules.box'). ' ' . $postdata['name'],
                    'code' => $code,
                    'parent_id' => $this->getSystemConfigValue('Delegates_Parent_Account'),
                    'major_classification' => 0,
                    "active" => 1
                ]);

                $postdata['account_id'] = $accountId;
            }
            
            if (in_array($postdata['id_cms_privileges'],[3,4,6])) { //check role if sales manager or delegate or factory delegate
                $inventories = $postdata['inventories'];
                session()->put("inventories", $inventories);

                $suppliers = $postdata['suppliers'];
                session()->put("suppliers", $suppliers);
            } 

            DB::commit();

        }
        catch (Exception $e) {
            DB::rollback();
        }



        unset($postdata['password_confirmation']);
        unset($postdata['inventories']);
        unset($postdata['suppliers']);

    }

    public function hook_after_add($id)
    {
        $user = GeneralDelegate::find($id);
        //app inventories
        $inventories = session("inventories");
        if($user && in_array($user->id_cms_privileges,[4,6])){ //check if Delegate or Factory Delegate
            if ($inventories == "") {$inventories = array();}
            $user->inventories()->sync($inventories); //remove old inventories and add new inventories
        }else{
            InventoriesDelegates::where('delegate_id', $id)->delete(); 
        }

        session()->forget("inventories");

        //add suppliers
        $suppliers = session("suppliers");
        if($user){
            if ($suppliers == "") {$suppliers = array();}
            $user->suppliers()->sync($suppliers); //remove old suppliers and add new suppliers
    
        }else{
            InventoriesDelegates::where('delegate_id', $id)->delete();
        }
        
        session()->forget("suppliers");

    }


    public function hook_before_edit(&$postdata, $id)
    {

        $id = session("user_id");

        $user = User::find($id);
        //check if change name to change box and customer account name
        if($user->name !== $postdata['name']){
            if($user->account_id !== 0){
                Account::where('id',$user->account_id)->update([
                    'name_en' => trans('modules.box_en'). ' ' . $postdata['name'],
                    'name_ar' => trans('modules.box'). ' ' . $postdata['name']
                ]);
            }
            if($user->customers_account_id !== 0){
                Account::where('id',$user->customers_account_id)->update([
                    'name_en' => trans('modules.costomers_en') . ' ' . $postdata['name'],
                    'name_ar' => trans('modules.costomers') . ' ' . $postdata['name']
                ]);
            }
        }

        if (in_array($postdata['id_cms_privileges'],[3,4,6])) { //check role if sales manager or delegate or factory delegate
            $inventories = $postdata['inventories'];
            $suppliers = $postdata['suppliers'];

            DB::beginTransaction();
            try {
               
                //edit Inventories
                if ($inventories == "") {$inventories = array();}
                $user->inventories()->sync($inventories); //remove old inventories and add new inventories
            
                //edit Suppliers
                if ($suppliers == "") {$suppliers = array();}
                $user->suppliers()->sync($suppliers); //remove old suppliers and add new suppliers
        
                DB::commit();
                $postdata['account_id'] = $user->account_id;



            }
            catch (Exception $e) {
                DB::rollback();
            }
        }

        unset($postdata['password_confirmation']);
        unset($postdata['inventories']);
        unset($postdata['suppliers']);
    }

    public function hook_query_index(&$query)
    {
        //Your code here
        session()->forget("inventories");
        session()->forget("suppliers");
        //don't show superadmin account
        $query->where('cms_users.id', '>', 1);
    }


    public function hook_before_delete($id)
    {

        //check if deleted user is login now
        $user = CRUDbooster::getUser();
        if ($user->id == $id) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.cannot_delete_user_you_login_by_it'), "warning");
        }

        $hasBills = Bill::where('staff_id', $id)->orWhere('delegate_id', $id)->first();
        $hasVouchers = Voucher::where('staff_id', $id)->orWhere('delegate_id', $id)->first();
       
        //get deleted user record
        $user = User::find($id);

        $hasCustomers = false;
        $customers = Account::where('parent_id', $user->customers_account_id)->get();
        if (count($customers) > 0) {
            $hasCustomers = true;
        }

        $hasEntries = false;
        if($user->account_id != 0){
            $hasEntries = Entry::where('account_id',$user->account_id)->first();
       }
       
        if ($hasBills || $hasVouchers || $hasEntries) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.delete_user_failed_he_has_entries'), "warning");
        }
        else if ($hasCustomers) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], trans('messages.delete_user_failed_he_has_customers'), "warning");
        }
        else {
            Account::where('id', $user->account_id)->delete();
            Account::where('id', $user->customers_account_id)->delete();
            InventoriesDelegates::where('delegate_id', $id)->delete();
            SuppliersDelegates::where('delegate_id', $id)->delete();
        }
    }

    
    public function displayRoles()
	{
	    return view('users.roles.display');
	}
}