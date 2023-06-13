<?php namespace crocodicstudio_voila\crudbooster\controllers;

use App;
use App\Http\Controllers\Users\User;
use App\Rules\ReCaptcha;
use Carbon\Carbon;
use CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends CBController
{
    public function getIndex()
    {
        \LaravelLocalization::setLocale(config('setting.LANG'));

        $data = [];
        $data['page_title'] = '<strong>Dashboard</strong>';

        return view('crudbooster::home', $data);
    }

    public function getLockscreen()
    {

        if (!CRUDBooster::myId()) {
            Session::flush();

            return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_session_expired'));
        }

        Session::put('admin_lock', 1);

        return view('crudbooster::lockscreen');
    }

    public function postUnlockScreen()
    {
        $id = CRUDBooster::myId();
        $password = Request::input('password');
        $users = DB::table(config('crudbooster.USER_TABLE'))->where('id', $id)->first();

        if (\Hash::check($password, $users->password)) {
            Session::put('admin_lock', 0);

            return redirect(CRUDBooster::adminPath());
        } else {
            echo "<script>alert('" . trans('crudbooster.alert_password_wrong') . "');history.go(-1);</script>";
        }
    }

    public function getLogin()
    {
        \LaravelLocalization::setLocale(config('setting.LANG'));

        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }
        $recaptchaSiteKey = env('RECAPTCHA_SITE_KEY') ?? null;
        $recaptchaSecretKey = env('RECAPTCHA_SECRET_KEY') ?? null;

        return view('crudbooster::login', ['recaptchaSiteKey' => $recaptchaSiteKey, 'recaptchaSecretKey' => $recaptchaSecretKey]);
    }

    public function postLogin()
    {
        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:' . config('crudbooster.USER_TABLE'),
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha],
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->withInput(Request::except('password'))->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $email = Request::input("email");
        $password = Request::input("password");
        $users = DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->first();

        if (\Hash::check($password, $users->password)) {
            $priv = DB::table("cms_privileges")->where("id", $users->id_cms_privileges)->first();

            $roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', $users->id_cms_privileges)->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();

            $packageSettings = DB::table('package_config')->first();

            if ($packageSettings->free_trial_end_date && $packageSettings->free_trial_end_date != "0000-00-00" && $packageSettings->free_trial_end_date < Carbon::now()) {

                return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_free_trial_end'));

            } else if ($packageSettings->subscription_end_date && $packageSettings->subscription_end_date != "0000-00-00" && $packageSettings->subscription_end_date < Carbon::now()) {

                return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_subscription_end'));

            }
            //this code for filemanager
            @session_start();
            $_SESSION["cms_session"] = $users->id;

            $photo = ($users->photo) ? asset($users->photo) : asset('vendor/crudbooster/avatar.jpg');
            Session::put('admin_id', $users->id);
            Session::put('admin_is_superadmin', $priv->is_superadmin);
            Session::put('admin_name', $users->name);
            Session::put('admin_photo', $photo);
            Session::put('admin_privileges_roles', $roles);
            Session::put("admin_privileges", $users->id_cms_privileges);
            Session::put('admin_privileges_name', $priv->name);
            Session::put('admin_lock', 0);
            Session::put('theme_color', $priv->theme_color);
            Session::put("appname", CRUDBooster::getSetting('appname'));
            Session::put('user', new User());

            DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->update([
                'last_login_date' => Carbon::now(),
            ]);
            CRUDBooster::insertLog(trans("crudbooster.log_login", ['email' => $users->email, 'ip' => Request::server('REMOTE_ADDR')]));

            $cb_hook_session = new \App\Http\Controllers\General\CBHook;
            $cb_hook_session->afterLogin();

            return redirect(CRUDBooster::adminPath());
        } else {
            $email = Request::input("email");
            return redirect()->route('getLogin')->with('email', $email)->with('message', trans('crudbooster.alert_password_wrong'));
        }
    }

    public function getForgot()
    {
        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('crudbooster::forgot');
    }

    public function postForgot()
    {
        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:' . config('crudbooster.USER_TABLE'),
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $rand_string = str_random(8);
        $password = \Hash::make($rand_string);

        DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(['password' => $password]);

        $appname = CRUDBooster::getSetting('appname');
        $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);
        $user->password = $rand_string;
        CRUDBooster::sendEmail(['to' => $user->email, 'data' => $user, 'template' => 'forgot_password_backend']);

        CRUDBooster::insertLog(trans("crudbooster.log_forgot", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));

        return redirect()->route('getLogin')->with('message', trans("crudbooster.message_forgot_password"));
    }

    public function getLogout()
    {

        $me = CRUDBooster::me();
        CRUDBooster::insertLog(trans("crudbooster.log_logout", ['email' => $me->email]));

        Session::flush();

        @session_start();
        unset($_SESSION["cms_session"]);

        return redirect()->route('getLogin')->with('message', trans("crudbooster.message_after_logout"));
    }
}
