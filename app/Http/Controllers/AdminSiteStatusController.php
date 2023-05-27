<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use crocodicstudio\crudbooster\controllers\CBController;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AdminSiteStatusController extends CBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->sortable_table = false;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->record_seo = false;
        $this->button_add = false;
        $this->button_edit = false;
        $this->button_delete = false;
        $this->button_detail = true;
        $this->pdf_direction = "ltr";
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->page_seo = false;
        $this->table = "site_status";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Customer", "name" => "customer_id", "join" => "customers,email"];
        $this->col[] = ["label" => "Bills", "name" => "bills_count"];
        $this->col[] = ["label" => "Vouchers", "name" => "vouchers_count"];
        $this->col[] = ["label" => "Users", "name" => "allowed_users_count", "callback_php" => '($row->allowed_users_count == -1 ? $row->used_users_count  . "/unlimited" : $row->used_users_count . "/" . $row->allowed_users_count)'];
        $this->col[] = ["label" => "Used Users", "name" => "used_users_count", "visible" => false];
        $this->col[] = ["label" => "Inventories", "name" => "allowed_inventories_count", "callback_php" => '($row->allowed_inventories_count == -1 ? $row->used_inventories_count  . "/unlimited" : $row->used_inventories_count . "/" . $row->allowed_inventories_count)'];
        $this->col[] = ["label" => "Used Inventories", "name" => "used_inventories_count", "visible" => false];
        $this->col[] = ["label" => "Currencies", "name" => "allowed_currencies_count", "callback_php" => '($row->allowed_currencies_count == -1 ? $row->used_currencies_count . "/unlimited" : $row->used_currencies_count . "/" . $row->allowed_currencies_count)'];
        $this->col[] = ["label" => "Used Currencies", "name" => "used_currencies_count", "visible" => false];
        $this->col[] = ["label" => "Clients", "name" => "allowed_clients_count", "callback_php" => '($row->allowed_clients_count == -1 ? $row->used_clients_count .  "/unlimited" : $row->used_clients_count . "/" . $row->allowed_clients_count)'];
        $this->col[] = ["label" => "Used Clients", "name" => "used_clients_count", "visible" => false];
        $this->col[] = ["label" => "Used Attachs Size", "name" => "used_attachs_size", "visible" => false];
        $this->col[] = ["label" => "Attachs Size", "name" => "allowed_attachs_size", "callback_php" => '($row->allowed_attachs_size == -1 ? $row->used_attachs_size .  "MB/unlimited" : $row->used_attachs_size . "MB/" . $row->allowed_attachs_size . "MB")'];
        $this->col[] = ["label" => "Subscription Type", "name" => "subscription_type"];
        $this->col[] = ["label" => "Subscription Start Date", "name" => "subscription_start_date"];
        $this->col[] = ["label" => "Subscription End Date", "name" => "subscription_end_date"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Customer Id', 'name' => 'customer_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'customers,id'];
        $this->form[] = ['label' => 'Bills Count', 'name' => 'bills_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Vouchers Count', 'name' => 'vouchers_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Allowed Users', 'name' => 'allowed_users_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Used Users', 'name' => 'used_users_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Allowed Inventories', 'name' => 'allowed_inventories_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Used Inventories', 'name' => 'used_inventories_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Allowed Currencies', 'name' => 'allowed_currencies_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Used Currencies', 'name' => 'used_currencies_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Allowed Clients', 'name' => 'allowed_clients_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Used Clients', 'name' => 'used_clients_count', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Allowed Attachs Size', 'name' => 'allowed_attachs_size', 'type' => 'number', 'validation' => 'required', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Used Attachs Size', 'name' => 'used_attachs_size', 'type' => 'number', 'validation' => 'required', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Subscription Type', 'name' => 'subscription_type', 'type' => 'text', 'validation' => 'required', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Subscription Start Date', 'name' => 'subscription_start_date', 'type' => 'date', 'validation' => 'required', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Subscription End Date', 'name' => 'subscription_end_date', 'type' => 'date', 'validation' => 'required', 'width' => 'col-sm-10'];

        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Customer Id","name"=>"customer_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"customer,id"];
        //$this->form[] = ["label"=>"Bills Count","name"=>"bills_count","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Vouchers Count","name"=>"vouchers_count","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        # OLD END FORM

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
        //    $this->addaction[] = ['label' => 'Get Last Reports', 'url' => CRUDBooster::mainpath('generate-report'), 'icon' => 'fa fa-history', 'color' => 'success'];
        $this->addaction[] = ['label' => 'Users Info', 'url' => CRUDBooster::mainpath('generate-users-info/[customer_id]'), 'icon' => 'fa fa-users', 'color' => 'success'];
        $this->addaction[] = ['label' => 'Currencies', 'url' => CRUDBooster::mainpath('generate-currencies-info/[customer_id]'), 'icon' => 'fa fa-dollar', 'color' => 'success'];
        $this->addaction[] = ['label' => 'Bills & Vouchers', 'url' => CRUDBooster::mainpath('generate-bills-info/[customer_id]'), 'icon' => 'fa fa-money', 'color' => 'success'];

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
        $this->index_button[] = ['label' => 'Generate Report', 'url' => CRUDBooster::mainpath("generate-report"), "icon" => "fa fa-history"];

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

    public function getGenerateReport()
    {
        $customers = DB::table('customers')->get();
        DB::beginTransaction();
        try {
            foreach ($customers as $customer) {
                $customerDB = "{$customer->database_name}";
                $customerDBHost = "localhost";
                $customerDBUser = "{$customer->database_name}";
                $customerDBPassword = "{$customer->database_password}";
                try {
                    $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
                } catch (PDOException $ex) {
                    continue;
                    return redirect()->back()->with(['message' => trans("recaptcha.error_generating_report"), 'message_type' => 'danger']);
                }

                $bills_query = "SELECT COUNT(*) FROM `bills`";
                $bills_stmt = $dbh->query($bills_query);
                $bills_count = $bills_stmt->fetchColumn();

                $vouchers_query = "SELECT COUNT(*) FROM `vouchers`";
                $vouchers_stmt = $dbh->query($vouchers_query);
                if ($vouchers_stmt === false) {
                    $errorInfo = $dbh->errorInfo();
                    return redirect()->back()->with(['message' => "Error executing query: " . $errorInfo[2], 'message_type' => 'danger']);
                } else {
                    $vouchers_count = $vouchers_stmt->fetchColumn();
                }

                $package_config_query = "SELECT * FROM `package_config`";
                $package_config_stmt = $dbh->query($package_config_query);
                $package_config_data = $package_config_stmt->fetchAll(PDO::FETCH_ASSOC)[0];

                $clients_query = "SELECT count(*) FROM `persons`";
                $client_stmt = $dbh->query($clients_query);
                $clients_count = $client_stmt->fetchColumn();

                $users_query = "SELECT count(*) FROM `cms_users`
						INNER JOIN `cms_privileges` ON cms_privileges.id = cms_users.id_cms_privileges
						WHERE cms_privileges.is_superadmin != 1";
                $users_stmt = $dbh->query($users_query);
                $users_count = $users_stmt->fetchColumn();

                $inventories_query = "SELECT count(*) FROM `inventories`";
                $inventories_stmt = $dbh->query($inventories_query);
                $inventories_count = $inventories_stmt->fetchColumn();

                $currencies_query = "SELECT count(*) FROM `currencies`";
                $currencies_stmt = $dbh->query($currencies_query);
                $currencies_count = $currencies_stmt->fetchColumn();

                $storagePath = $customer->folder_location . '/site/storage/app';
                if (file_exists($storagePath)) {
                    $attachment_size = 0;
                    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePath)) as $file) {
                        $attachment_size += $file->getSize();
                    }
                    // calculate size im MB
                    $attachment_size = round($attachment_size / 1024 / 1024, 2);
                }
                $subscription_type = 'Free Trial';
                if ($package_config_data['free_trial_start_date'] == null || $package_config_data['free_trial_start_date'] == '0000-00-00') {
                    $start_date = $package_config_data['subscription_start_date'];
                    $subscription_type = 'Year';
                } else {
                    $start_date = $package_config_data['free_trial_start_date'];
                }
                if ($package_config_data['free_trial_end_date'] == null || $package_config_data['free_trial_end_date'] == '0000-00-00') {
                    $end_date = $package_config_data['subscription_end_date'];
                } else {
                    $end_date = $package_config_data['free_trial_end_date'];
                }
                $site_status = DB::table('site_status')->where('customer_id', $customer->id)->get();
                DB::table('site_status')->updateOrInsert(
                    ['customer_id' => $customer->id],
                    [
                        'bills_count' => $bills_count,
                        'vouchers_count' => $vouchers_count,
                        'allowed_users_count' => ($package_config_data['users_num']),
                        'used_users_count' => $users_count,
                        'allowed_inventories_count' => ($package_config_data['inventories_num']),
                        'used_inventories_count' => $inventories_count,
                        'allowed_currencies_count' => ($package_config_data['currencies_num']),
                        'used_currencies_count' => $currencies_count,
                        'allowed_clients_count' => ($package_config_data['clients_num']),
                        'used_clients_count' => $clients_count,
                        'allowed_attachs_size' => ($package_config_data['attachs_size']),
                        'used_attachs_size' => $attachment_size,
                        'subscription_start_date' => $start_date,
                        'subscription_end_date' => $end_date,
                        'subscription_type' => $subscription_type,
                    ]
                );
                DB::commit();
            }
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(['message' => trans("recaptcha.error_generating_report"), 'message_type' => 'danger']);
            throw $ex;
        }
        return redirect()->back()->with(['message' => trans("recaptcha.successfully_generating_report"), 'message_type' => 'success']);
    }

    public function getGenerateUsersInfo($id)
    {
        header('Content-Type: text/html; charset=utf-8');
        $customer = DB::table('customers')->where('id', $id)->first();
        $cols = [];
        $cols[] = ['name' => 'Name', 'label' => 'Name'];
        $cols[] = ['name' => 'Email', 'label' => 'Email'];
        $cols[] = ['name' => 'Last Login Date', 'label' => 'Last Login Date'];
        $cols[] = ['name' => 'Privileges Name', 'label' => 'Privilege'];
        try {
            $customerDB = "{$customer->database_name}";
            $customerDBHost = "localhost";
            $customerDBUser = "{$customer->database_name}";
            $customerDBPassword = "{$customer->database_password}";
            try {
                $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
                $dbh->exec("SET NAMES 'utf8mb4'");
            } catch (PDOException $ex) {
                return redirect()->back()->with(['message' => trans("recaptcha.error_generating_usres_info_report"), 'message_type' => 'danger']);
            }

            $customer_name = $customer->first_name . " " . $customer->last_name;
            $customer_email = $customer->email;

            $user_query = "SELECT `cms_users`.`name`, `cms_users`.`email`, `cms_users`.`last_login_date`, `cms_privileges`.`name` as `privileges_name`
                FROM `cms_users`
                INNER JOIN `cms_privileges` ON `cms_users`.`id_cms_privileges` = `cms_privileges`.`id`";

            $user_stmt = $dbh->query($user_query);
            $users = $user_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return redirect()->back()->with(['message' => trans("recaptcha.error_generating_usres_info_report"), 'message_type' => 'danger']);
        }
        return view('cms_reports.users_info_details', compact('users','customer_name', 'customer_email', 'cols'));
    }

    public function getGenerateCurrenciesInfo($id)
    {
        header('Content-Type: text/html; charset=utf-8');
        $customer = DB::table('customers')->where('id', $id)->first();
        $cols = [];
        $cols[] = ['name' => 'Name En', 'label' => 'Name En'];
        $cols[] = ['name' => 'Name Ar', 'label' => 'Name Ar'];
        $cols[] = ['name' => 'Code', 'label' => 'Code'];
        $cols[] = ['name' => 'Default', 'label' => 'Default'];
        $cols[] = ['name' => 'Active', 'label' => 'Active'];
        try {
            $customerDB = "{$customer->database_name}";
            $customerDBHost = "localhost";
            $customerDBUser = "{$customer->database_name}";
            $customerDBPassword = "{$customer->database_password}";
            try {
                $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
                $dbh->exec("SET NAMES 'utf8mb4'");
            } catch (PDOException $ex) {
                return redirect()->back()->with(['message' => trans("recaptcha.error_generating_currencies_info_report"), 'message_type' => 'danger']);
            }

            $customer_name = $customer->first_name . " " . $customer->last_name;
            $customer_email = $customer->email;

            $currencies_query = "SELECT `currencies`.`name_en`, `currencies`.`name_ar`,`currencies`.`code`,`currencies`.`is_major`,`currencies`.`active`
                                     FROM `currencies`";
            $currencies_stmt = $dbh->query($currencies_query);
            $currencies = $currencies_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return redirect()->back()->with(['message' => trans("recaptcha.error_generating_currencies_info_report"), 'message_type' => 'danger']);
        }
        return view('cms_reports.currencies_details', compact('currencies','customer_name', 'customer_email', 'cols'));
    }

    public function getGenerateBillsInfo(Request $request, $id){
        header('Content-Type: text/html; charset=utf-8');
        $customer = DB::table('customers')->where('id', $id)->first();
        $cols = [];
        $cols[] = ['name' => 'Month', 'label' => 'Month'];
        $cols[] = ['name' => 'Bills Count', 'label' => 'Bills Count'];
        $cols[] = ['name' => 'Vouchers Count', 'label' => 'Vouchers Count'];
        try {
            $customerDB = "{$customer->database_name}";
            $customerDBHost = "localhost";
            $customerDBUser = "{$customer->database_name}";
            $customerDBPassword = "{$customer->database_password}";
            try {
                $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
                $dbh->exec("SET NAMES 'utf8mb4'");
            } catch (PDOException $ex) {
                return redirect()->back()->with(['message' => trans("recaptcha.error_generating_bills_info_report"), 'message_type' => 'danger']);
            }
            $customer_name = $customer->first_name . " " . $customer->last_name;
            $customer_email = $customer->email;
            $subscription_year = $request->year ?? null;
            $totalBills = [];
            $totalVouchers = [];
            if($subscription_year){
                for($month = 1; $month<=12;$month++){
                    $bills_query = "SELECT COUNT(*) AS count FROM `bills` WHERE YEAR(create_at) = $subscription_year AND MONTH(create_at) = $month GROUP BY MONTH($month)";
                    $bills_stmt = $dbh->query($bills_query);
                    $bills = $bills_stmt->fetchColumn();
                   
                    $vouchers_query = "SELECT COUNT(*) AS count FROM `vouchers` WHERE YEAR(create_at) = $subscription_year AND MONTH(create_at) = $month GROUP BY MONTH($month)";
                    $vouchers_stmt = $dbh->query($vouchers_query);
                    $vouchers = $vouchers_stmt->fetchColumn();

                    $totalBills[] = $bills == false ? '0' : $bills;
                    $totalVouchers[] = $vouchers == false ? '0' : $vouchers;
                }
            }

            $startSubscriptionDate = $customer->created_at;
            $endSubscriptionDate =  $customer->subscription_end_date ?? $customer->free_trial_end_date;
            if(!$endSubscriptionDate)
            $endSubscriptionDate = $customer->created_at;
            $startYear = null;
            $endYear = null;
            if ($startSubscriptionDate)
                $startYear = intval(date('Y', strtotime($startSubscriptionDate)));
            if ($endSubscriptionDate)
                $endYear = intval(date('Y', strtotime($endSubscriptionDate)));

            $currentYear = intval(date('Y'));
            if($endYear > $currentYear)
                $endYear = $currentYear;
                
        } catch (Exception $ex) {
            return redirect()->back()->with(['message' => trans("recaptcha.error_generating_bills_info_report"), 'message_type' => 'danger']);
        }
        return view('cms_reports.vouchers_bills_details', compact('totalBills','totalVouchers','customer_name', 'customer_email', 'cols','subscription_year', 'startYear', 'endYear', 'id'));
    }
}
