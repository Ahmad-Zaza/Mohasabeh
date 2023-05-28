<?php

namespace App\Http\Controllers;

use App\Http\Models\Advantages;
use App\Http\Models\ContactUs;
use App\Http\Models\Customer;
use App\Http\Models\CustomerModule;
use App\Http\Models\Feature;
use App\Http\Models\Module;
use App\Http\Models\PriceOption;
use App\Http\Models\Section;
use App\Http\Models\Solution;
use PDOException;
use Illuminate\Support\Facades\Auth;
use App\PricePkg;
use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\Hash;
use App\Rules\WebsiteReCapcha;
use Carbon\Carbon;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Exception as GlobalException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PDO;
use PHPUnit\Exception;

// use Validator;

class HomeController extends Controller
{
    public function index()
    {
        $lang = App::getLocale();
        //---------------------//
        $sections = Section::where('active', '1')->orderby("sorting")->get();
        $temp = [];
        foreach ($sections as $item) {
            $temp[$item->code] = $item;
        }
        $sections = $temp;
        //---------------------//
        $modules = Module::all();
        //---------------------//
        $settings = DB::table('cms_settings')->whereIn('group_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name'); // pluck('value', 'key') => the data is look like: 'key' => 'value'
        //---------------------//
        $features = Feature::where('active', '1')->orderby("sorting")->get();
        $advantages = Advantages::where('active', '1')->orderby("sorting")->get();
        $solutions = Solution::with(['modules'])->where('active', '1')->orderby("sorting")->get();
        //---------------------//
        $usersOptions = PriceOption::where('code', 'users')->orderby("sorting")->get();
        $languagesOptions = PriceOption::where('code', 'languages')->orderby("sorting")->get();
        //---------------------//
        return view('home', compact(['solutions', 'sections', 'lang', 'features', 'advantages', 'settings', 'modules', 'usersOptions', 'languagesOptions']));
        //---------------------//
    }

    public function solutions($id)
    {
        $lang = App::getLocale();
        //------------------------//
        $settings = DB::table('cms_settings')->whereIn('أخةgroup_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name'); // pluck('value', 'key') => the data is look like: 'key' => 'value'
        //------------------------//
        $solution = Solution::with(['modules'])->where('id', $id)->orderby("sorting")->where('active', '1')->first();
        //------------------------//
        return view('solution', compact(['lang', 'settings', 'solution']));
    }

    public function _pricing()
    {
        $lang = App::getLocale();
        //------------------------//
        $settings = DB::table('cms_settings')->whereIn('group_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name'); // pluck('value', 'key') => the data is look like: 'key' => 'value'
        //------------------------//
        $section = Section::where([
            'active' => '1',
            'code' => 'pricing',
        ])->first();
        //------------------------//
        $usersOptions = PriceOption::where('code', 'users')->get();
        $languagesOptions = PriceOption::where('code', 'languages')->get();
        //------------------------//
        $modules = Module::where('active', 1)->get();
        //------------------------//
        return view('pricing', compact(['lang', 'settings', 'section', 'usersOptions', 'modules', 'languagesOptions']));
    }
    public function pricing()
    {
        $lang = App::getLocale();
        //------------------------//
        $settings = DB::table('cms_settings')->whereIn('group_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name'); // pluck('value', 'key') => the data is look like: 'key' => 'value'
        //------------------------//
        $section = Section::where([
            'active' => '1',
            'code' => 'pricing',
        ])->first();
        //------------------------//
        $packages = PricePkg::select('*')->get();
        $languagesOptions = PriceOption::where('code', 'languages')->get();
        //------------------------//
        return view('pricing', compact(['lang', 'settings', 'section', 'packages', 'languagesOptions']));
    }
    public function activationProgress($token)
    {
        $lang = App::getLocale();
        $customer = Customer::where('custom_token', $token)->first();
        $settings = DB::table('cms_settings')->whereIn('group_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name'); // pluck('value', 'key') => the data is look like: 'key' => 'value'
        if (!$customer) {
            return abort(404);
        } else {
            $message = __('data.activated_customer');
            return view('activate-progress', compact(['lang', 'settings', 'message', 'customer']));
        }
    }

    public function customer_activate($id)
    {
        $lang = App::getLocale();
        //------------------------//
        $settings = DB::table('cms_settings')->whereIn('group_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name'); // pluck('value', 'key') => the data is look like: 'key' => 'value'
        //------------------------//
        $customer = Customer::where('id', $id)->first();
        //----- Activate Customer
        if ($customer->is_free_trial) {
            $customer->free_trial_start_date = Carbon::now()->format('Y-m-d');
            $customer->free_trial_end_date = Carbon::now()->addDays(15)->format('Y-m-d');
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
        //------------------------------------------------//
        try {
            $this->createCustomerFiles($customer);
        } catch (Exception $e) {
            Log::log("error", "message $e");
            return response()->json([], 500);
        }
        $customer = Customer::where('id', $id)->first();
        if ($customer->active) {
            $message = __('data.activate_success');
        } else {
            $message = __('data.activate_error');
        }
        return response()->json(["message" => $message]);
    }

    public function saveCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => [
                'required',
                'numeric',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('customers')->whereNull('deleted_at'),
            ],
            'company' => 'required',
            'g-recaptcha-response' => [
                'required',
                new WebsiteReCapcha,
            ],
     
        ], [
            'phone.numeric' => __("data.phone_numeric", [], Lang::getLocale()),
            'email.email' => __("data.email_valid", [], Lang::getLocale()),
            'email.unique' => __("data.email_unique", [], Lang::getLocale()),
            'g-recaptcha-response.required' => __("data.alert_recaptcha", [], Lang::getLocale()),
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(), 'request' => $request->all()], 200);
        }
        //---------------------------------//
        if ($request->file('logo')) {
            $file = $request->file('logo');
        } else if ($request->file('logo2')) {
            $file = $request->file('logo2');
        }
        if ($file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            // Upload file
            $file->move("images/customers", $filename);
            // File path
            $filepath = 'images/customers/' . $filename;
        }
        //---------------------------------//
        $website = strtolower(str_replace(" ", "", $request->domain));
        $existed = Customer::where("website", $website)->get()->count();
        if ($existed > 0) {
            return response()->json(['success' => false, 'errors' => ["link" => [__("data.domain_exist")]]], 200);
        }
        //---------------------------------//
        $customer = new Customer();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        if (!empty($request->package_id)) {
            $customer->package_id = $request->package_id;
            $pac = PricePkg::findOrFail($request->package_id);
            $customer->users_count = $pac->users_count;
        }
        $customer->company = $request->company;
        $customer->subscription_type = $request->sub_type;
        $customer->sys_lang = "ar";
        $customer->notes = $request->notes;
        $customer->website = $website;
        // $customer->logo_path = env("APP_URL") . 'images/customers/' . $filename;
        // $customer->color = $request->color;
        $customer->host_link = 'http:/' . env("HOST_LINK") . strtolower(str_replace(' ', '', $request->domain)) . '.cloudsellpos.com';
        if (!$request->package_id) {
            $customer->is_free_trial = 1;
        }
        $customer->last_renewal_date = $request->last_renewal_date;
        $customer->custom_token = Str::random(32);
        $customer->active = 0;
        $customer->save();
        $lang = App::getLocale();
        if ($customer->is_free_trial) {
            try {
                $domainName = str_replace(" ", "", $customer->website);
                $folderName = strtolower($domainName . ".cloudsellpos.com");
                $this->createDomainIfNotExist($folderName, $domainName);
                $this->changeDomainPhpVersion($domainName);
                CRUDBooster::sendEmail([
                    'to' => $request->email,
                    'data' => [
                        'full_name' => $request->first_name . ' ' . $request->last_name,
                        'link' => url("/customers/{$customer->custom_token}"),
                    ],
                    'template' => 'activation_link_template',
                    'attachments' => [],
                ]);
            } catch (GlobalException $e) {
                Log::log("error", "Error Sending Email " . $e->getMessage());
            }
        } else {
            try {
                CRUDBooster::sendEmail([
                    'to' => CRUDBooster::getSetting("admin_emails"),
                    'data' => [
                        'name' => $request->first_name . ' ' . $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'subscribe_option' => $request->sub_type,
                    ],
                    'template' => 'admin_new_subscribe',
                    'attachments' => [],
                ]);

                CRUDBooster::sendEmail([
                    'to' => $customer->email,
                    'template' => 'paid-subscriber-thanks',
                    'attachments' => [],
                ]);
            } catch (GlobalException $e) {
                Log::log("error", "Error Sending Email " . $e->getMessage());
            }
        }
        return response()->json(['success' => true, "message" => __("data.subscription_success"), 'errors' => false, 'request' => $request->all()], 200);
    }

    public function checkEmailUnique($email)
    {
        $status = !Customer::where("email", $email)->get()->count() > 0;
        //$message = $status ? "" : "Email is already registered.";
        $message = $status ? "" : trans('data.email_unique');
        return response()->json(['state' => $status, "msg" => $message], 200);
    }

    private function createCustomerFiles(Customer $customer)
    {
        set_time_limit(0);
        //----------------------------------------------//
        //--------- 1- create subdomain
        $domainName = str_replace(" ", "", $customer->website);
        $folderName = strtolower($domainName . ".cloudsellpos.com");
        $folderPath = "/home/cloudsell/domains/$domainName.cloudsellpos.com/public_html";
        $mainDomainFolderPath = config("app.cloudsellpos_settings.MAIN_WEBSITE_PATH");
        //---------------------//
        //--- Check if domain already exist
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

        //add Mohasabeh user to customer database
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
                $client->request("GET", 'https:/' . env("HOST_LINK") . $folderName . "/clear-cache");
            } catch (ClientException $e) {
                Log::log("error", "Error Clearing Cache $e");
            }
        } catch (RequestException $e) {
            Log::log("error", "Error Clearing Cache $e");
        }
        //$result = shell_exec("php /$folderPath/backend/artisan config:clear");
        //$result = shell_exec("php /$folderPath/backend/artisan cache:clear");
        //$result = shell_exec("php /$folderPath/backend/artisan view:clear");
        //$result = shell_exec("php /$folderPath/backend/artisan route:clear");
        //-----------------------//
        // 8- send email to the customers
        CRUDBooster::sendEmail([
            'to' => $customer->email,
            'data' => [
                'full_name' => $customer->first_name . ' ' . $customer->last_name,
                'site_link' => 'http://' . env("HOST_LINK") . $folderName,
                'host' => env("HOST_LINK") . $folderName,
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

    private function copydir($source, $destination)
    {
        if (!is_dir($destination)) {
            $oldumask = umask(0);
            mkdir($destination, 01777); // so you get the sticky bit set
            umask($oldumask);
        }
        $dir_handle = @opendir($source) or die("Unable to open $source");
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

    private function getCustomerModulesJson($customer)
    {
        $customerModules = CustomerModule::where('customers_id', $customer->id)->with('module')->get();
        $modules = Module::all();
        $obligatedModules = Module::where('is_obligate', 1)->get();
        //-------------------------------------------//
        $data = [];
        foreach ($modules as $module) {
            $data[$module->code] = false;
        }
        foreach ($customerModules as $module) {
            $data[$module->module->code] = true;
        }
        foreach ($obligatedModules as $module) {
            $data[$module->code] = true;
        }
        $data['language'] = $customer->sys_lang; // yazan_edits
        $data['users_count'] = $customer->users_count;
        $data['start_subscription_date'] = $customer->subscription_start_date;
        $data['end_subscription_date'] = $customer->subscription_end_date;
        $data['start_free_trial_date'] = $customer->free_trial_start_date;
        $data['end_free_trial_date'] = $customer->free_trial_end_date;
        $data['last_renewal_date'] = $customer->last_renewal_date;
        $data['subscription_type'] = $customer->subscription_type; // yazan_edits
        $data['company'] = $customer->company;
        // $data['logo'] = $customer->logo_path;
        // $data['color'] = $customer->color;
        return $data;
    }

    private function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass) . "&L123"; //turn the array into a string
    }

    public function rrmdir($src)
    {
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src . '/' . $file;
                if (is_dir($full)) {
                    rrmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }

    public function loginCustomer(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $customer = Customer::where("email", $email)->first();

        if (!$customer) {
            return response()->json(["message" => __("data.email_wrong")], 500);
        }

        $customerDB = "{$customer->database_name}";
        $customerDBHost = "localhost";
        $customerDBUser = "{$customer->database_name}";
        $customerDBPassword = "{$customer->database_password}";
        try {
            $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $query = "select * from cms_users where email = '$email'";
            $res = $dbh->query($query);
            $user = $res->fetchAll(PDO::FETCH_ASSOC)[0];


            if (Hash::check($password, $user['password'])) {
                Auth::guard('customer')->login($customer);

                return response()->json(["url" => '/profile'], 200);
            } else {

                return response()->json(["message" => __("data.password_wrong")], 500);
            }
        } catch (PDOException $ex) {
            return response()->json(["message" => __("data.unable_to_make_the_connection")], 500);
        }
    }

    public function forgetPasswordCustomer(Request $request)
    {
        $email = $request->email;
        $customer = Customer::where("email", $email)->first();
        if (!$customer) {
            return response()->json(["message" => __("data.email_wrong")], 500);
        }
        //do some thing here

        //generate  new password
        $customerEmailNewPassword = $this->randomPassword();
        $newPasswordHash = password_hash($customerEmailNewPassword, PASSWORD_DEFAULT);
        //change custome database admin pass
        $customerDB = "{$customer->database_name}";
        $customerDBHost = "localhost";
        $customerDBUser = "{$customer->database_name}";
        $customerDBPassword = "{$customer->database_password}";
        $dbh = new PDO("mysql:host=$customerDBHost;dbname=$customerDB", $customerDBUser, $customerDBPassword);
        $query = "UPDATE `cms_users` SET `password` = '$newPasswordHash' WHERE `cms_users`.`email` = '$customer->email';";
        $dbh->exec($query);
        if ($dbh->errorCode() != "00000") {
            throw new Exception("error");
        }
        //send new password to customer email
        CRUDBooster::sendEmail([
            'to' => $customer->email,
            'data' => [
                'full_name' => $customer->first_name . ' ' . $customer->last_name,
                'site_link' => $customer->host_link,
                'host' => str_replace('https://', '', $customer->host_link),
                'email' => $customer->email,
                'password' => $customerEmailNewPassword,
            ],
            'template' => 'customer_get_new_password',
            'attachments' => [],
        ]);

        return response()->json(["status" => 'success', "message" => __("data.we_generate_new_password_please_check_your_email")], 200);
    }

    public static function post_captcha($user_response)
    {
        $fields_string = '';
        $fields = array(
            'secret' => '6Lc4N9YfAAAAACpXyJgEeySVnXVkuV0STwBUbsxF',
            'response' => $user_response,
        );
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }

        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function saveContact(Request $request)
    {
        try {
            //-----------------------
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email',
                    //Rule::unique('customers')->whereNull('deleted_at'),
                ],
                'g-recaptcha-response' => ['required', new ReCaptcha],
            ], [
                'email.email' => __("data.email_valid", [], Lang::getLocale()),
                //'email.unique' => __("data.email_unique", [], Lang::getLocale()),
                'g-recaptcha-response.required' => __("data.alert_recaptcha", [], Lang::getLocale()),
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors(), 'request' => $request->all()], 200);
            }
            //-----------------------
            //save reqest to database
            ContactUs::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            //send mail to client
            CRUDBooster::sendEmail([
                'to' => $request->email,
                "data" => [],
                'template' => 'client-contact-us',
                'attachments' => [],
            ]);
            //send mail to admin
            CRUDBooster::sendEmail([
                'to' => 'info@cloudsellpos.com',
                "data" => [
                    'email' => $request->email,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'message' => $request->message,

                ],
                'template' => 'admin-contact-us',
                'attachments' => [],
            ]);
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            Log::log("error", "Error $e");
            return response()->json([], 200);
        }
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
            $result = $da->query(
                'CMD_API_SUBDOMAINS',
                array(
                    'action' => 'create',
                    'domain' => 'cloudsellpos.com',
                    'subdomain' => $subdomainName,
                )
            );
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
            // return new Exception("error");
            throw new \Exception("error");
        }
        Storage::append('publish_result.txt', "check domains: " . json_encode($result));
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
            $result = $da->query(
                'CMD_API_DOMAIN',
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

    public function cleanCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        return "done";
    }
}
