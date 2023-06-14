<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ForceHttps
{
    public function handle($request, Closure $next)
    {
        $systemSetting = DB::table('system_settings')->where('setting_key', 'https_option')->first();

        if (!$request->secure() && $systemSetting->setting_value == 'on') {
            return redirect()->secure($request->getRequestUri());

        } else if ($request->secure() && $systemSetting->setting_value == 'off') {
            return redirect()->to(str_replace('https://', 'http://', $request->fullUrl()));
        }

        return $next($request);
    }
}
