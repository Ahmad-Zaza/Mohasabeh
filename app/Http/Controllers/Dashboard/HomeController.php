<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Models\Customer;
use App\Http\Controllers\DirectAdmin;
use App\SiteStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        Artisan::call('report:generate', ['customer' => auth()->user()->id]);
        return view('dashboard.pages.index');
    }
    public function change_email_view()
    {
        return view('dashboard.pages.change-email');
    }
    public function change_password_view()
    {
        return view('dashboard.pages.change-password');
    }
    public function change_personal_info_view()
    {
        $user = Auth::user();
        return view('dashboard.pages.change-personal-info', compact('user'));
    }
    public function my_payments()
    {
        $user = Auth::user();
        return view('dashboard.pages.my-payments', compact('user'));
    }
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }
    public function upgrade_account_ajax(Request $request)
    {
        Session::put('sub_type', $request->sub_type);
        Session::put('pkgg_id', $request->pkgg_id);
        return response()->json(array('msg' => 'success'));
    }

    public function checkout(Request $request)
    {
        $customer = Customer::where('id', auth()->user()->id)->first();
        if ($customer->package_id) {
            $request->session()->put('pkgg_id', $customer->package_id);
            $request->session()->put('sub_type', $customer->subscription_type);
        }

        $sub_type = $request->session()->get('sub_type');
        $pkgg_id = $request->session()->get('pkgg_id');
        $package = DB::table('packages')->where('id', '=', $pkgg_id)->first();
        if ($sub_type == 'month') {
            $request->session()->put('price', $package->monthly_price);
        } else if ($sub_type == 'year') {
            $request->session()->put('price', $package->year_price);
        } else {
            $request->session()->put('price', $package->six_month_price);
        }
        return view('dashboard.pages.checkout', compact('customer', 'sub_type', 'pkgg_id', 'package'));
    }
    public function delete_customer()
    {
        $customer = Auth::guard('customer');
        //-- Delete domain
        $domainName = strtolower($customer->website);
        if (!$domainName) {
            Log::log("error", "failed to delete website ".$customer->website);
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
        //--- Delete Site Status
        SiteStatus::where("customer_id", $customer->id)->delete();
        $customer = Customer::find($customer->id);
        $customer->delete();
        //-----------------------------//
        return response()->json([]);
    }
}
