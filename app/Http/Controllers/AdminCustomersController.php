<?php

namespace App\Http\Controllers;

use App\Http\Models\Customer;
use App\PricePkg;
use Carbon\Carbon;
use crocodicstudio\crudbooster\controllers\CBController;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class AdminCustomersController extends CBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "first_name";
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
        $this->button_export = false;
        $this->sortable_table = false;
        $this->page_seo = false;
        $this->record_seo = false;
        $this->table = "customers";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Name", "name" => "first_name", "callback_php" => '$row->first_name." ".$row->last_name'];
        $this->col[] = ["label" => "HIDDEN", "name" => "last_name", "visible" => false];
        // $this->col[] = ["label" => "Company", "name" => "company"];
        $this->col[] = ["label" => "Email", "name" => "email"];
        $this->col[] = ["label" => "Phone", "name" => "phone"];
        $this->col[] = ["label" => "Free Trial", "name" => "is_free_trial", "callback_php" => '$row->is_free_trial?"<span class=\"fa fa-check text-success\"></span>":"<span class=\"fa fa-close text-danger\"></span>"'];
        $this->col[] = ["label" => "Link", "name" => "host_link", "callback_php" => '$row->host_link?"<a target=\"_blank\" href=\"$row->host_link\">$row->host_link</a>":""'];
        $this->col[] = ["label" => "Due Date", "name" => "free_trial_end_date", "callback_php" => '$row->free_trial_end_date?$row->free_trial_end_date:$row->subscription_end_date'];
        $this->col[] = ["label" => "HIDDEN", "name" => "subscription_end_date", "visible" => false];
        $this->col[] = ["label" => "active", "name" => "active", "switch" => true];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Phone', 'name' => 'phone', 'type' => 'number', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the number only'];
        $this->form[] = ['label' => 'Company', 'name' => 'company', 'type' => 'text', 'width' => 'col-sm-9', 'placeholder' => 'Please enter a valid email address'];
        $this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Host Link', 'name' => 'host_link', 'type' => 'text', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Folder Location', 'name' => 'folder_location', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Database Name', 'name' => 'database_name', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Database Password', 'name' => 'database_password', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Free Trial Start Date', 'name' => 'free_trial_start_date', 'type' => 'date', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Free Trial End Date', 'name' => 'free_trial_end_date', 'type' => 'date', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Subscription Type', 'name' => 'subscription_type', 'type' => 'select', 'width' => 'col-sm-9', 'dataenum' => 'year|Year;month|Month;six-month|SixMonths'];
        $this->form[] = ['label' => 'Subscription Start Date', 'name' => 'subscription_start_date', 'type' => 'date', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Subscription End Date', 'name' => 'subscription_end_date', 'type' => 'date', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Last Renewal Date', 'name' => 'last_renewal_date', 'type' => 'date', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Users Count', 'name' => 'users_count', 'type' => 'number', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Modules', 'name' => 'modules', 'type' => 'select2', 'width' => 'col-sm-9', 'datatable' => 'modules,name_en', 'relationship_table' => 'customer_module'];
        $this->form[] = ['label' => 'System Language', 'name' => 'sys_lang', 'type' => 'text', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Free Trial', 'name' => 'is_free_trial', 'type' => 'checkbox', 'validation' => 'required', 'width' => 'col-sm-9'];
        $this->form[] = ['label' => 'Active', 'name' => 'active', 'type' => 'radio', 'width' => 'col-sm-10'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form   = [];
        //$this->form[] = ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'width' => 'col-sm-10'];
        //$this->form[] = ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'width' => 'col-sm-10'];
        //$this->form[] = ['label' => 'Phone', 'name' => 'phone', 'type' => 'number', 'width' => 'col-sm-10', 'placeholder' => 'You can only enter the number only'];
        //$this->form[] = ['label' => 'Company', 'name' => 'company', 'type' => 'text', 'width' => 'col-sm-9', 'placeholder' => 'Please enter a valid email address'];
        //$this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'width' => 'col-sm-10'];
        //$this->form[] = ['label' => 'Host Link', 'name' => 'host_link', 'type' => 'text', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Folder Location', 'name' => 'folder_location', 'type' => 'text', 'width' => 'col-sm-10'];
        //$this->form[] = ['label' => 'Database Name', 'name' => 'database_name', 'type' => 'text', 'width' => 'col-sm-10'];
        //$this->form[] = ['label' => 'Database Password', 'name' => 'database_password', 'type' => 'text', 'width' => 'col-sm-10'];
        //$this->form[] = ['label' => 'Free Trial Start Date', 'name' => 'free_trial_start_date', 'type' => 'date', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Free Trial End Date', 'name' => 'free_trial_end_date', 'type' => 'date', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Subscription Type', 'name' => 'subscription_type', 'type' => 'select', 'width' => 'col-sm-9', 'dataenum' => 'year|Year;month|Month;six-month|SixMonths'];
        //$this->form[] = ['label' => 'Subscription Start Date', 'name' => 'subscription_start_date', 'type' => 'date', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Subscription End Date', 'name' => 'subscription_end_date', 'type' => 'date', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Last Renewal Date', 'name' => 'last_renewal_date', 'type' => 'date', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Users Count', 'name' => 'users_count', 'type' => 'number', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Modules', 'name' => 'modules', 'type' => 'select2', 'width' => 'col-sm-9', 'datatable' => 'modules,name_en', 'relationship_table' => 'customer_module'];
        //$this->form[] = ['label' => 'System Language', 'name' => 'sys_lang', 'type' => 'text', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Free Trial', 'name' => 'is_free_trial', 'type' => 'checkbox', 'validation' => 'required', 'width' => 'col-sm-9'];
        //$this->form[] = ['label' => 'Active', 'name' => 'active', 'type' => 'radio', 'width' => 'col-sm-10'];
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
        | @color        = Default is primary. (primary, warning, success, info)
        | @showIf        = If condition when action show. Use field alias. e.g : [id] == 1
        |
         */
        $this->addaction = array();
        $this->addaction[] = [
            'label' => 'Activate',
            'url' => CRUDBooster::mainpath('activateCustomer/[id]'),
            'icon' => 'fa fa-check',
            'color' => 'success',
            'showIf' => '[is_free_trial] == 0 && [active] == 0',
        ];

        $this->addaction[] = [
            'label' => 'Renewal',
            'url' => CRUDBooster::mainpath('renewalSubscriptionPage/[id]'),
            'icon' => 'fa fa-check',
            'color' => 'success',
            'showIf' => '[active] == 1',
        ];

        $this->addaction[] = [
            'label' => 'Delete',
            'icon' => 'fa fa-close',
            'color' => 'danger',
            'confirmation' => true,
            'url' => CRUDBooster::mainpath('delete-customer/[id]'),
        ];

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
        | IF NOT SUCCESS ADD  $this->col[] = ["label"=>"active","name"=>"active"]; IN COLUMNS
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

    public function activateCustomer($id)
    {
        $customer = Customer::where('id', $id)->first();

        if ($customer->is_free_trial) {
            $customer->free_trial_start_date = Carbon::now()->format('Y-m-d');
            $customer->free_trial_end_date = Carbon::now()->addMonth()->format('Y-m-d');
        } else if ($customer->subscription_type == 'year') {
            $customer->last_renewal_date = $customer->subscription_start_date = Carbon::now()->format('Y-m-d');
            $customer->subscription_end_date = Carbon::now()->addYear()->format('Y-m-d');
        } else if ($customer->subscription_type == 'month') {
            $customer->last_renewal_date = $customer->subscription_start_date = Carbon::now()->format('Y-m-d');
            $customer->subscription_end_date = Carbon::now()->addMonth()->format('Y-m-d');
        } else if ($customer->subscription_type == 'six-month') {
            $customer->last_renewal_date = $customer->subscription_start_date = Carbon::now()->format('Y-m-d');
            $customer->subscription_end_date = Carbon::now()->addMonths(6)->format('Y-m-d');
        }
        $customer->active = 1;
        $customer->save();
        //-------------------------------------------//
        //--- Send Email with Details
        if (!$customer->is_free_trial) {
            //------------------------------------------------//
            $customer->custom_token = null;
            $customer->save();
            //----------------------------------------------------//
            $this->createCustomerFiles($customer);
            //----------------------------------------------------//
        }
        //-------------------------------------------//
        CRUDBooster::redirect(
            CRUDBooster::adminPath('customers'),
            "customer {$customer->first_name} {$customer->last_name} Activated!",
            "success"
        );
    }
    //---------------------------------------------------------------------------------------------//
    private function createCustomerFiles(Customer $customer)
    {
        set_time_limit(0);
        //----------------------------------------------//
        //--------- 1- create subdomain
        $domainName = str_replace(" ", "", $customer->website);
        $folderName = strtolower($domainName . ".cloudsellpos.com");
        $folderPath = "/home/cloudsell/domains/$domainName.cloudsellpos.com/public_html";
        $mainDomainFolderPath = config("app.cloudsellpos_settings.MAIN_WEBSITE_PATH");
        //check if exist & create domain
        $this->createDomainIfNotExist($folderName, $domainName);
        //--------- 2- create domain folder
        if (file_exists($folderPath)) {
            rrmdir($folderPath);
        }
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
        //----------------------------------------------//
        //--------- 3- change subdomain settings (PHP VERSION & SUBDOMAIN FOLDERS)
        // $subdomainSettingFile = "/usr/local/directadmin/data/users/cloudsell/domains/cloudsellpos.com.subdomains.docroot.override";
        // $fp = fopen($subdomainSettingFile, 'w');
        // $old_content = file_get_contents($subdomainSettingFile);
        //if (strpos($old_content, "$subdomainName=") === false) {
        //     fwrite($fp, $old_content . "\n$subdomainName=" . urlencode("php1_select=1&php2_select=0"));
        //}
        // fclose($fp);
        //----------------------------------------------//
        //--------- 4- Publishing (Copy files from main website to subdomains)
        $formDir = $mainDomainFolderPath . '/site/storage/main/cloudsellpos_system';
        $toDir = $folderPath;
        $this->copydir($formDir, $toDir);
        //----------------------------------------------//
        // 8- create customer db and change settings in .env of backend
        $customerDB = "cloudsell_db-{$customer->website}";
        $customerDBHost = "localhost";
        $customerDBUser = "{$customerDB}";
        $customerDBPassword = $this->randomPassword();
        //--- Check if database exist
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query("CMD_API_DATABASES");
        if ($da->error) {
            return new Exception("error");
        }
        foreach ($result as $database) {
            if ($database == $customerDB) {
                $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
                $result = $da->query("CMD_API_DATABASES", [
                    "action" => "delete",
                    "select0" => $customerDB,
                ]);
                if ($da->error) {
                    return new Exception("error");
                }
            }
        }
        //--- Create Subdomain Database
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query("CMD_API_DATABASES", array(
            'action' => 'create',
            'name' => "db-{$customer->website}",
            'user' => "db-{$customer->website}",
            'passwd' => "$customerDBPassword",
            'passwd2' => "$customerDBPassword",
        ));
        if ($da->error) {
            return new Exception("Error");
        }

        //add CloudSellPOS user to customer database
        $this->addMainDatabaseUserToCustomerDatabase($customerDB);

        $customer->database_name = $customerDB;
        $customer->database_password = $customerDBPassword;
        $customer->folder_location = $folderPath;
        $customer->save();
        //----
        $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
        //-----------------------//
        $customerEmailPassword = $this->randomPassword();
        $query = file_get_contents($mainDomainFolderPath . '/site/storage/main/db.sql');
        $query = str_replace('$$company_name$$', $customer->company, $query);
        $query = str_replace('$$email$$', $customer->email, $query);
        $query = str_replace('$$password$$', password_hash($customerEmailPassword, PASSWORD_DEFAULT), $query);
        $query = str_replace('$$package_id$$', $customer->package_id ? $customer->package_id : 'null', $query);

        $query = str_replace('$$first_name$$', $customer->first_name, $query);
        $query = str_replace('$$last_name$$', $customer->last_name, $query);
        $query = str_replace('$$phone$$', $customer->phone, $query);

        $contact_email = DB::table('cms_settings')->where('name', 'contact_emails')->first()->content;
        $query = str_replace('$$contact_emails$$', $contact_email, $query);

        $company_info = DB::table('company_information')->first();
        $query = str_replace('$$mohasabeh_phone$$', $company_info->contact_phone, $query);
        $query = str_replace('$$mohasabeh_email$$', $company_info->email, $query);

        if (!$customer->package_id) {
            $query = str_replace('$$users_num$$', -1, $query);
            $query = str_replace('$$inventories_num$$', -1, $query);
            $query = str_replace('$$currencies_num$$', -1, $query);
            $query = str_replace('$$clients_num$$', -1, $query);
            $query = str_replace('$$month_bills_num$$', -1, $query);
            $query = str_replace('$$backups_size$$', -1, $query);
            $query = str_replace('$$attachs_size$$', -1, $query);
        } else {
            $package = PricePkg::where("id", $customer->package_id)->first();
            $query = str_replace('$$users_num$$', $package->users_count, $query);
            $query = str_replace('$$inventories_num$$', $package->warehouses, $query);
            $query = str_replace('$$currencies_num$$', $package->currency, $query);
        }
        $query = str_replace('$$free_trial_start_date$$', $customer->free_trial_start_date ?: 'null', $query);
        $query = str_replace('$$free_trial_end_date$$', $customer->free_trial_end_date ?: 'null', $query);
        $query = str_replace('$$subscription_start_date$$', $customer->subscription_start_date ?: 'null', $query);
        $query = str_replace('$$subscription_end_date$$', $customer->subscription_end_date ?: 'null', $query);

        $dbh->exec("SET NAMES 'utf8';");
        if ($dbh->errorCode() != "00000") {
            throw new Exception("error");
        }
        $dbh->exec("SET SESSION query_cache_type = OFF;");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        // $dbh->prepare($query);

        $dbh->exec($query);
        if ($dbh->errorCode() != "00000") {
            throw new Exception("error");
        }
        //-----------------------//
        // 9- create customer db and change settings in .env of backend
        $envFileName = $folderPath . '/site/.env';
        $envFile = file_get_contents($envFileName);
        $envFile = str_replace('$$DB_DATABASE$$', $customerDB, $envFile);
        $envFile = str_replace('$$DB_USERNAME$$', $customerDBUser, $envFile);
        $envFile = str_replace('$$DB_PASSWORD$$', $customerDBPassword, $envFile);
        file_put_contents($envFileName, $envFile);
        //-----------------------//
        sleep(40);
        try {
            try {
                $client = new Client([
                    "http_errors" => false,
                ]);
                $client->request("GET", 'http:/' . env("HOST_LINK") . $folderName . "/clear-cache");
            } catch (ClientException $e) {
                Log::log("error", "Error Clearing Cache $e");
            }
        } catch (RequestException $e) {
            Log::log("error", "Error Clearing Cache $e");
        }
        //-----------------------//
        // 8- send email to the customers
        CRUDBooster::sendEmail([
            'to' => $customer->email,
            'data' => [
                'full_name' => $customer->first_name . ' ' . $customer->last_name,
                'site_link' => 'http://' . env("HOST_LINK") . $folderName,
                'email' => $customer->email,
                'password' => $customerEmailPassword,
            ],
            'template' => 'customer_activation_done',
            'attachments' => [],
        ]);
        //-----------------------//
        // 9- expire token
        $customer->custom_token = null;
        $customer->active = 1;
        $customer->save();
        //-----------------------//
    }
    //---------------------------------------------------------------------------------------------//
    public function renewalSubscriptionPage($id)
    {
        $customer = Customer::find($id);
        $packages = PricePkg::all();
        return view("customer.renewal-subscription", compact("customer", "packages"));
    }
    //---------------------------------------------------------------------------------------------//
    public function saveRenewalSubscription()
    {
        $data = $_POST;
        $customer = Customer::where('id', $data["id"])->first();
        $customer->package_id = $data["package_id"];
        $customer->last_renewal_date = Carbon::now();
        $customer->subscription_type = $data["subscription_type"];
        $customer->subscription_start_date = $data["subscription-start-date"];
        if ($data["subscription_type"] == "year") {
            $customer->subscription_end_date = Carbon::parse($data["subscription-start-date"])->addYear()->format('Y-m-d');
        } else if ($data["subscription_type"] == "month") {
            $customer->subscription_end_date = Carbon::parse($data["subscription-start-date"])->addMonth()->format('Y-m-d');
        } else if ($data["subscription_type"] == "six-month") {
            $customer->subscription_end_date = Carbon::parse($data["subscription-start-date"])->addMonths(6)->format('Y-m-d');
        }
        $customer->is_free_trial = 0;
        $customer->active = 1;
        $customer->save();
        //--------------------------------------------------------------------//
        // 1- Change the subscription date
        $dbh = new PDO("mysql:host=localhost;dbname=" . $customer->database_name, $customer->database_name, $customer->database_password);
        $sql = "UPDATE package_config SET package_id=?, users_num=?, inventories_num=?, currencies_num=?,subscription_start_date=?,subscription_end_date=?,free_trial_start_date=null,free_trial_end_date=null WHERE id=1";
        $stmt = $dbh->prepare($sql);
        $result = $stmt->execute([$data["package_id"], $data["users_count"], $data["warehouses"], $data["currency"], $data["subscription-start-date"], $data["subscription-end-date"]]);
        //---------------------------------------------------------------------//
        //2- clear cache
        try {
            try {
                $client = new Client([
                    "http_errors" => false,
                ]);
                $client->request("GET", $customer->host_link . "/clear-cache");
            } catch (ClientException $e) {
                Log::log("error", "Error Clearing Cache $e");
            }
        } catch (RequestException $e) {
            Log::log("error", "Error Clearing Cache $e");
        }
        //---------------------------------------------------------------------//
        CRUDBooster::redirect(
            CRUDBooster::adminPath('customers'),
            "customer {$customer->first_name} {$customer->last_name} Has renewal successfully!",
            "success"
        );
    }
    //---------------------------------------------------------------------------------------------//
    public function sendLink($id)
    {
        $customer = Customer::where('id', $id)->first();
        $value = $customer->host_link;
        return view('customer.set-host-link', compact('id', 'value'));
    }

    public function saveLink()
    {
        $data = $_REQUEST;
        $customer = Customer::where('id', $data['id'])->first();
        $customer->host_link = $_REQUEST['host_link'];
        $customer->save();
        $full_name = $customer['first_name'] . ' ' . $customer['last_name'];
        $link = $customer['host_link'];
        $email = $customer['email'];
        $data = [
            'full_name' => $full_name,
            'link' => $link,
        ];
        CRUDBooster::sendEmail(['to' => $email, 'data' => $data, 'template' => 'email_template_send_host_link', 'attachments' => []]);
        CRUDBooster::redirect(CRUDBooster::adminPath('customers'), "Email has been sent successfully to Customer {$customer->first_name} {$customer->last_name}", "success");
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

    private function copydir($source, $destination)
    {
        if (!is_dir($destination)) {
            $oldumask = umask(0);
            mkdir($destination, 01777); // so you get the sticky bit set
            umask($oldumask);
        }
        $dir_handle = @opendir($source) or die("Unable to open");
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != ".." && !is_dir("$source/$file")) //if it is file
            {
                copy("$source/$file", "$destination/$file");
            }

            if ($file != "." && $file != ".." && is_dir("$source/$file")) //if it is folder
            {
                $this->copydir("$source/$file", "$destination/$file");
            }

        }
        closedir($dir_handle);
    }

    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass) . "&L123"; //turn the array into a string
    }

    public function getDeleteCustomer($id)
    {
        $customer = Customer::find($id);

        //-- Delete domain
        $domainName = strtolower($customer->website);
        if (!$domainName) {
            return CRUDBooster::redirect(
                CRUDBooster::adminPath('customers'),
                "Some thing wrong!",
                "danger"
            );
        }

        $folderPath = "/home/cloudsell/domains/$domainName.cloudsellpos.com";
        $customerDB = "cloudsell_db-{$customer->website}";

        //--- Check if domain already exist
        $this->deleteDomain($domainName);

        //--- 2- delete domain folder
        if (file_exists($folderPath)) {
            rrmdir($folderPath);
        }

        //-----------------------------//
        //--- 3- delete customer database
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query("CMD_API_DATABASES");
        if ($da->error) {
            return new Exception("error");
        }
        print_r($result);
        foreach ($result as $database) {
            if ($database == $customerDB) {
                $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
                $result = $da->query("CMD_API_DATABASES", [
                    "action" => "delete",
                    "select0" => $customerDB,
                ]);
                if ($da->error) {
                    return new Exception("error");
                }
            }
        }
        //-----------------------------//
        $customer->delete();
        //-----------------------------//
        return CRUDBooster::redirect(
            CRUDBooster::adminPath('customers'),
            "customer {$customer->first_name} {$customer->last_name} Deleted!",
            "success"
        );
    }

    private function createSubdomainIfNotExist($folderName, $subdomainName)
    {
        //--------- 1- create subdomain
        //--- Check if subdomain already exist
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query('CMD_API_SUBDOMAINS', ["domain" => "cloudsellpos.com"]);
        if ($da->error) {
            return new Exception("error");
        }
        $exist = false;
        if (count($result) > 0) {
            foreach ($result as $domain) {
                if ($domain . ".cloudsellpos.com" == $folderName) {
                    $exist = true;
                }
            }
        }
        //---------------------//
        if (!$exist) {
            $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
            $result = $da->query('CMD_API_SUBDOMAINS',
                array(
                    'action' => 'create',
                    'domain' => 'cloudsellpos.com',
                    'subdomain' => $subdomainName,
                ));
            if ($da->error) {
                throw new Exception("error");
            }
        }
    }

    private function deleteSubDomain($subdomainName)
    {
        //--- Check if subdomain already exist
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query('CMD_API_SUBDOMAINS', ["domain" => "cloudsellpos.com"]);
        if ($da->error) {
            return new Exception("error");
        }
        $exist = false;
        if (count($result) > 0) {
            foreach ($result as $item) {
                if ($item == $subdomainName) {
                    $exist = true;
                }
            }
        }
        //---------------------//
        if ($exist) {
            $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
            $result = $da->query('CMD_API_SUBDOMAINS',
                array(
                    'action' => 'delete',
                    'domain' => 'cloudsellpos.com',
                    'select0 ' => $subdomainName,
                    'contents ' => "yes",
                ));
            if ($da->error) {
                throw new Exception("error");
            }
        }
    }

    private function createDomainIfNotExist($folderName, $domainName)
    {
        //--------- 1- create domain
        //--- Check if domain already exist
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query('CMD_API_SHOW_DOMAINS', []);
        if ($da->error) {
            return new Exception("error");
        }
        $exist = false;
        if (count($result) > 0) {
            foreach ($result as $domain) {
                if ($domain == $folderName) {
                    $exist = true;
                }
            }
        }
        //---------------------//
        if (!$exist) {
            $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"), false);
            $result = $da->query('CMD_API_DOMAIN',
                array(
                    'action' => 'create',
                    'domain' => $domainName . ".cloudsellpos.com",
                    'php' => 'ON',
                    'ssl' => 'ON',
                    'bandwidth' => '1000',
                    'cgi' => 'ON',
                    'quota' => '20000',
                )
            );
            if ($da->error) {
                throw new Exception("error");
            }
        }
    }

    private function deleteDomain($domainName)
    {
        //--- Check if domain already exist
        $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
        $result = $da->query('CMD_API_SHOW_DOMAINS', []);
        if ($da->error) {
            return new Exception("error");
        }
        $exist = false;
        if (count($result) > 0) {
            foreach ($result as $item) {
                if ($item == $domainName . '.cloudsellpos.com') {
                    $exist = true;
                }
            }
        }
        //---------------------//
        if ($exist) {
            //delete domain query
            $da = new DirectAdmin("https://cloudsellpos.com:2222", config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER"), config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"));
            $result = $da->query('CMD_API_DOMAIN',
                array(
                    'confirmed' => 'Confirm',
                    'delete' => 'yes',
                    'select0 ' => $domainName . '.cloudsellpos.com',
                ));
            if ($da->error) {
                throw new Exception("error");
            }
        }
    }

    public function addMainDatabaseUserToCustomerDatabase($databaseName)
    {

        try {
            try {
                $client = new Client([
                    "http_errors" => false,
                    "headers" => [
                        "Authorization" => "Basic " . base64_encode(config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER") . ":" . config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD")),
                    ],
                ]);
                $body = [
                    "name" => $databaseName,
                    "userlist" => "db",
                    "domain" => "cloudsellpos.com",
                    "json" => "yes",
                    "action" => "createuser",
                    "passwd" => config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"),
                    "passwd2" => config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD"),
                ];
                return $client->request("POST", "https://cloudsellpos.com:2222/CMD_DB?json=yes", ["form_params" => $body]);
            } catch (ClientException $e) {
                Log::log("error", "Error changePhpVersion $e");
            }
        } catch (RequestException $e) {
            Log::log("error", "Error changePhpVersion $e");
        }
    }

    public function changeDomainPhpVersion($domain)
    {
        try {
            try {
                $client = new Client([
                    "http_errors" => false,
                    "headers" => [
                        "Authorization" => "Basic " . base64_encode(config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_USER") . ":" . config("app.cloudsellpos_settings.DIRECT_ADMIN_USER_PASSWORD")),
                    ],
                ]);
                $body = [
                    "php1_select" => 2,
                    "domain" => $domain . '.cloudsellpos.com',
                    "action" => "php_selector",
                ];
                $result = $client->request("POST", "https://cloudsellpos.com:2222/CMD_API_DOMAIN?json=yes", ["form_params" => $body]);
                return $result;
            } catch (ClientException $e) {
                Log::log("error", "Error changePhpVersion $e");
            }
        } catch (RequestException $e) {
            Log::log("error", "Error changePhpVersion $e");
        }
    }

}
