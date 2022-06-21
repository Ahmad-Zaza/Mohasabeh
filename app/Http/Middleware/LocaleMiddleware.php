<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard as Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{

    public function __construct(Session $session)
    {
        $this->session      = $session;
    }


    //Languages available in your resources/lang

    protected $languages = ['en', 'ar'];

    public function handle($request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        return $next($request);
    }
}
