<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function upgrade_account_view(Request $request)
    {
        $sub_type = $request->session()->get('sub_type');
        $pkgg_id = $request->session()->get('pkgg_id');
        $package = DB::table('price_pkgs')->where('id', '=', $pkgg_id)->get();
        $package = json_decode($package);
        return view('dashboard.pages.upgrade-account', compact('sub_type', 'pkgg_id', 'package'));
    }
}
