<?php namespace App\Http\Controllers;

use App\Account;
use App\Traits\GeneralTrait;
use CRUDbooster;
use DB;
use Session;

class AdminCmsUsersController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

    use GeneralTrait;
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = 'cms_users';
        $this->primary_key = 'id';
        $this->title_field = "name";
        $this->button_action_style = 'button_icon';
        $this->button_import = false;
        $this->button_export = false;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => trans('crudbooster.Name'), "name" => "name");
        $this->col[] = array("label" => trans('crudbooster.Email'), "name" => "email");
        $this->col[] = array("label" => trans('crudbooster.Privilege'), "name" => "id_cms_privileges", "join" => "cms_privileges,name");
        $this->col[] = array("label" => trans('crudbooster.Photo'), "name" => "photo", "image" => 1);
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = array();
        $this->form[] = array("label" => "المندوب", "name" => "name", 'required' => true, 'validation' => 'required|alpha_spaces|min:3');
        $this->form[] = array("label" => "البريد الإلكتروني", "name" => "email", 'required' => true, 'type' => 'email', 'validation' => 'required|email|unique:cms_users,email,' . CRUDBooster::getCurrentId());
        $this->form[] = array("label" => "الصورة", "name" => "photo", "type" => "filemanager", "help" => "القياس المفضل 200x200px", 'resize_width' => 90, 'resize_height' => 90);
        $this->form[] = array("label" => "الدور", "name" => "id_cms_privileges", "type" => "select", "datatable" => "cms_privileges,name", 'required' => true);
        // $this->form[] = array("label"=>"Password","name"=>"password","type"=>"password","help"=>"Please leave empty if not change");

        if (CRUDBooster::getCurrentMethod() == 'getEdit') {
            $this->form[] = array("label" => "كلمة المرور", "name" => "password", "type" => "password", "help" => "من فضلك اتركه فارغ إن لم ترد تغيير كلمة المرور");
            $this->form[] = array("label" => "تأكيد كلمة المرور", "name" => "password_confirmation", "type" => "password", "help" => "من فضلك اتركه فارغ إن لم ترد تغيير كلمة المرور");
        } else {
            $this->form[] = array("label" => "كلمة المرور", "name" => "password", "type" => "password", "help" => "من فضلك ادخل كلمة المرور");
            $this->form[] = array("label" => "تأكيد كلمة المرور", "name" => "password_confirmation", "type" => "password", "help" => "من فضلك ادخل كلمة المرور مرة أخرى");
        }

        if (CRUDBooster::getCurrentMethod() != 'getAdd') {
            $this->form[] = array("label" => 'حساب زبائن المندوب', "name" => "customers_account_id", "type" => "select2", 'required' => true, 'datatable' => 'accounts,name_ar', 'datatable_where' => 'major_classification=1');
        }

        $id = CRUDBooster::getCurrentId();
        $method = CRUDBooster::getCurrentMethod();
        $custom_select = view('custom.multi_inventories_select', ['id' => $id, 'method' => $method])->render();
        $this->form[] = ["label" => trans('crudbooster.Inventories'), "name" => "inventories", "type" => "custom", "html" => $custom_select];

        # END FORM DO NOT REMOVE THIS LINE

        $this->load_js[] = asset("vendor/crudbooster/assets/select2/dist/js/select2.full.min.js");

        $this->style_css = "";

        $this->load_css[] = asset("vendor/crudbooster/assets/select2/dist/css/select2.min.css");

    }

    public function getProfile()
    {

        $this->button_addmore = false;
        $this->button_cancel = false;
        $this->button_show = false;
        $this->button_add = false;
        $this->button_delete = false;
        $this->hide_form = ['id_cms_privileges'];

        $data['page_title'] = trans("crudbooster.label_button_profile");
        $data['row'] = CRUDBooster::first('cms_users', CRUDBooster::myId());
        $this->cbView('crudbooster::default.form', $data);
    }

    public function hook_before_add(&$postdata)
    {
        $avilableDelegatesNum = $this->getPackageConfigValue('users_num');
        //check if package config allow to add user
        $users_now = DB::table('cms_users')->get();
        if ($avilableDelegatesNum > 0 && count($users_now) + 1 > $avilableDelegatesNum) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], " لايمكنك إضافة  مستخدم جديد. العدد المسموح به هو $avilableDelegatesNum", "warning");
        }
        //dd($postdata);
        DB::beginTransaction();

        try {

            if ($postdata['id_cms_privileges'] == 4) {
                $code = Account::getCode($this->getSystemConfigValue('Delegates_Parent_Account'));

                $accountId = DB::table('accounts')->insertGetId([
                    'name_en' => 'صندوق ' . $postdata['name'],
                    'name_ar' => 'صندوق ' . $postdata['name'],
                    'code' => $code,
                    'parent_id' => $this->getSystemConfigValue('Delegates_Parent_Account'),
                    'major_classification' => 0,
                    "active" => 1,

                ]);

                $postdata['account_id'] = $accountId;
                //generate customers account id

                $newcode = Account::getCode($this->getSystemConfigValue('Customers_Account'));
                $customersAccountId = DB::table('accounts')->insertGetId([
                    'name_en' => 'زبائن ' . $postdata['name'],
                    'name_ar' => 'زبائن ' . $postdata['name'],
                    'code' => $newcode,
                    'parent_id' => $this->getSystemConfigValue('Customers_Account'),
                    'major_classification' => 1,
                    "active" => 1,

                ]);

                $postdata['customers_account_id'] = $customersAccountId;

                $inventories = $postdata['inventories'];
                session()->put("inventories", $inventories);

                DB::commit();
            }

        } catch (Exception $e) {
            DB::rollback();
        }

        unset($postdata['password_confirmation']);
        unset($postdata['inventories']);

    }

    public function hook_after_add($id)
    {
        $inventories = session("inventories");

        if ($inventories != "" && count($inventories) > 0) {
            foreach ($inventories as $inv) {
                DB::table('inventories')->where('id', $inv)->update([
                    'delegate_id' => $id,
                ]);
            }
        }
        session()->forget("inventories");
    }

    public function hook_before_edit(&$postdata, $id)
    {
        //dd($postdata);
        $id = session("user_id");

        if ($postdata['id_cms_privileges'] == 4) { //check role
            $inventories = $postdata['inventories'];
            //dd($inventories);
            //$hasBills = DB::table('bills')->where('staff_id', $id)->orWhere('delegate_id',$id)->first();
            //$hasVouchers = DB::table('vouchers')->where('staff_id', $id)->orWhere('delegate_id',$id)->first();
            $user = DB::table('cms_users')->find($id);

            //$user_account = DB::table('accounts')->where('id',$user->account_id)->first();
            //dd($user);
            DB::beginTransaction();
            try {

                //eidt Inventories
                DB::table('inventories')->where('delegate_id', $id)->update([
                    'delegate_id' => null,
                ]);

                if ($inventories != null && count($inventories) > 0) {
                    foreach ($inventories as $inv) {
                        DB::table('inventories')->where('id', $inv)->update([
                            'delegate_id' => $id,
                        ]);
                    }

                }

                DB::commit();
                $postdata['account_id'] = $user->account_id;

            } catch (Exception $e) {
                DB::rollback();
            }
        }

        unset($postdata['password_confirmation']);
        unset($postdata['inventories']);
    }

    public function hook_query_index(&$query)
    {
        //Your code here
        session()->forget("inventories");

    }

    public function hook_before_delete($id)
    {

        $hasBills = DB::table('bills')->where('staff_id', $id)->orWhere('delegate_id', $id)->first();
        $hasVouchers = DB::table('vouchers')->where('staff_id', $id)->orWhere('delegate_id', $id)->first();
        $user = DB::table('cms_users')->find($id);
        $hasCustomers = false;
        $customers = DB::table('accounts')->where('parent_id', $user->customers_account_id)->get();
        if (count($customers) > 0) {
            $hasCustomers = true;
        }

        if ($hasBills || $hasVouchers) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "لا تستطيع حذف هذا الموظف لان لديه ارتباط بسجلات !!", "warning");
        } else if ($hasCustomers) {
            return CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "لا تستطيع حذف هذا الموظف لان لديه  زبائن مرتبطة به !!", "warning");
        } else {
            DB::table('accounts')->where('id', $user->account_id)->delete();
            DB::table('accounts')->where('id', $user->customers_account_id)->delete();
            DB::table('inventories')->where('delegate_id', $id)->update([
                'delegate_id' => null,
            ]);
        }
    }
}
