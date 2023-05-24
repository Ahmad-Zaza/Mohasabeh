<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
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
        return view('dashboard.pages.change-personal-info');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
