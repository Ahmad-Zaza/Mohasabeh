<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
