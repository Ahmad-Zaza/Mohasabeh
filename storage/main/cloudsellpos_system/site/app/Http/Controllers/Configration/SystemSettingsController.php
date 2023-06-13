<?php
namespace App\Http\Controllers\Configration;

use App\Models\SystemConfigration\SystemSetting;
use CRUDBooster;
use Illuminate\Support\Facades\Request;

class SystemSettingsController extends \crocodicstudio_voila\crudbooster\controllers\CBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "reports";
        $this->title_field = "account_name";
        $this->limit = 20;
        $this->orderby = "sorting,asc";
        $this->show_numbering = false;
        $this->global_privilege = false;
        $this->button_table_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_delete = false;
        $this->button_edit = false;
        $this->button_detail = false;
        $this->button_show = false;
        $this->button_filter = false;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_bulk_action = false;
        $this->sidebar_mode = "normal"; //normal,mini,collapse,collapse-mini
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];

        # END FORM DO NOT REMOVE THIS LINE

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key       = foreign key of sub table/module
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
        | @color        = Default is primary. (primary, warning, succecss, info)
        | @showIf        = If condition when action show. Use field alias. e.g : [id] == 1
        |
         */
        $this->addaction = array();

        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon        = Icon from fontawesome
        | @name        = Name of button
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
        | FESAL VOILA DONT REMOVE THIS LINE
        | ----------------------------------------------------------------------
        | IF NOT SUCCESS ADD  $this->col[] = ["label"=>"Active","name"=>"active"]; IN COLUMNS
        |
         */

        $this->table_row_color[] = ["condition" => "[active]==1", "color" => "success"];
        $this->table_row_color[] = ["condition" => "[active]==0", "color" => "danger"];

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
        $this->script_js = null;

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
        $this->load_js[] = asset("js/modules_js/configrations/settings_script.js");

        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
         */
        $this->style_css = null;

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
        $data = null;

        return view("configration.settings.all", array("data" => $data));
    }

    // Temp Stop Setting
    public function changeTempStop()
    {
        $system_status = SystemSetting::where('setting_key', 'system_stop')->first()->setting_value;

        return $this->cbView("configration.settings.temp_stop", array("status" => $system_status));
    }

    public function editTempStopStatus($data)
    {
        $data = json_decode($data, true);
        $newSettingValue = $data[0]['value'];
        try {
            SystemSetting::where('setting_key', 'system_stop')->update([
                'setting_value' => $newSettingValue,
            ]);
            return json_encode(array('status' => 'success', 'massege' => trans('messages.success_message')));
        } catch (\Exception $e) {
            return json_encode(array('status' => 'error', 'massege' => trans('messages.failed_message')));
        }

    }

    //Images Settings

    public function changeImagesSettings()
    {
        $settings = SystemSetting::whereIn('setting_key', array('image_max_size', 'image_types', 'image_quality'))->get()->pluck('setting_value', 'setting_key');
        //dd($settings);
        $image_types_arr = explode(',', $settings['image_types']);
        return $this->cbView("configration.settings.images", array("image_max_size" => $settings['image_max_size'], "image_types" => $image_types_arr, "image_quality" => $settings['image_quality']));
    }

    public function editImagesSettings($data)
    {
        $data = json_decode($data, true);
        $image_max_size = 0;
        $image_types_arr = array();
        $image_types_str = '';
        $image_quality = 0;
        foreach ($data as $set) {
            if ($set['name'] == 'image_max_size') {
                $image_max_size = $set['value'];
            } elseif ($set['name'] == 'image_types') {
                array_push($image_types_arr, $set['value']);
            } elseif ($set['name'] == 'image_quality') {
                $image_quality = $set['value'];
            }
        }
        $image_types_str = implode($image_types_arr, ',');

        try {
            SystemSetting::where('setting_key', 'image_max_size')->update([
                'setting_value' => $image_max_size,
            ]);
            SystemSetting::where('setting_key', 'image_types')->update([
                'setting_value' => $image_types_str,
            ]);
            SystemSetting::where('setting_key', 'image_quality')->update([
                'setting_value' => $image_quality,
            ]);
            return json_encode(array('status' => 'success', 'massege' => trans('messages.success_message')));
        } catch (\Exception $e) {
            return json_encode(array('status' => 'error', 'massege' => trans('messages.failed_message')));
        }
    }

    //Images Settings

    public function changeBillsSettings()
    {
        $settings = SystemSetting::whereIn('setting_key', array('negative_bills'))->get()->pluck('setting_value', 'setting_key');
        //dd($settings);
        return $this->cbView("configration.settings.bills", array("negative_bills" => $settings['negative_bills']));
    }

    public function editBillsSettings($data)
    {
        $data = json_decode($data, true);
        //dd($data);
        $negative_bills = '';
        foreach ($data as $set) {
            if ($set['name'] == 'negative_bills') {
                $negative_bills = $set['value'];
            }
        }

        try {
            SystemSetting::where('setting_key', 'negative_bills')->update([
                'setting_value' => $negative_bills,
            ]);

            return json_encode(array('status' => 'success', 'massege' => trans('messages.success_message')));
        } catch (\Exception $e) {
            return json_encode(array('status' => 'error', 'massege' => trans('messages.failed_message')));
        }
    }

    public function lockSystemURL()
    {
        $lock_status = SystemSetting::where('setting_key', 'lock_system_url')->first()->setting_value;
        $unlock_url_token = SystemSetting::where('setting_key', 'unlock_system_url_token')->first()->setting_value;
        $unlock_req = "";
        if ($unlock_url_token) {
            $unlock_req = url('unlock/system/') . '/' . $unlock_url_token;
        }
        return $this->cbView("configration.settings.lock_url", array("status" => $lock_status, 'unlock_req' => $unlock_req));
    }

    public function makeSystemUrlLocked()
    {
        try {
            SystemSetting::where('setting_key', 'lock_system_url')->update([
                'setting_value' => 'on',
            ]);
            $token = str_random(16);
            SystemSetting::where('setting_key', 'unlock_system_url_token')->update([
                'setting_value' => $token,
            ]);
            $unlock_req = url('unlock/system/') . '/' . $token;
            return json_encode(array('status' => 'success', 'massege' => trans('messages.success_message'), 'unlock_req' => $unlock_req));
        } catch (\Exception $e) {
            return json_encode(array('status' => 'error', 'massege' => trans('messages.failed_message')));
        }
    }
    public function unLockSystemURL($token)
    {

        if ($token) {
            $unlock_url_token = SystemSetting::where('setting_key', 'unlock_system_url_token')->first()->setting_value;
            if ($unlock_url_token == $token) {
                SystemSetting::where('setting_key', 'lock_system_url')->update([
                    'setting_value' => 'off',
                ]);
                SystemSetting::where('setting_key', 'unlock_system_url_token')->update([
                    'setting_value' => '',
                ]);
                $system_url = url('modules/login');
                return view("configration.settings.unlock_url", array('message' => trans('labels.unlock_system_url_done', ['system_url' => $system_url])));
            }
        }
        return view("configration.settings.unlock_url", array('message' => trans('labels.unlock_system_url_failed')));

    }

    public function getHttpsSettings()
    {
        $settings = SystemSetting::whereIn('setting_key', array('https_option'))->get()->pluck('setting_value', 'setting_key');
        return $this->cbView("configration.settings.https_option", array("https_value" => $settings['https_option']));
    }

    public function editHttpsSettings()
    {
        $settings = SystemSetting::whereIn('setting_key', array('https_option'))->update([
            'setting_value' => Request::input('https_activity'),
        ]);

        return redirect()->back()->with([
            'status' => 'success',
            'massege' => trans('messages.success_message'),
            'https_value' => Request::input('https_activity'),
        ]);
    }
}
