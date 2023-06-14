<?php

namespace App\Providers;

use App\Http\Controllers\General\GeneralFunctionsController;
use App\Models\SystemConfigration\SystemSetting;
use App\Models\Tours\Tour;
use App\Models\Tours\TourStepElements;
use crocodicstudio_voila\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function ($view) {

            //check url active status config
            $lock_url_status = SystemSetting::where('setting_key', 'lock_system_url')->first()->setting_value;
            if ($lock_url_status == 'on') {
                die(trans('labels.lock_url_message'));
            }

            //check Cycle Session
            $gfunc = new GeneralFunctionsController();
            $display_current_cycle = $gfunc->checkCycleSession();

            //check old_cycle_edited
            $old_cycle_edited_status = false;
            if (CRUDBooster::getCurrentModule()->path != 'financial_cycles') {
                $old_cycle_edited_status = $gfunc->checkOldCycleEdited();
            } else {
                $old_cycle_edited_status = false;
            }

            //get System Settings values
            $system_status = 'off';
            $user = CRUDBooster::getUser();
            if ($user && !$user->isSuperAdmin) {
                $system_status = SystemSetting::where('setting_key', 'system_stop')->first()->setting_value;
                if ($system_status == 'on') {
                    //dd("System stoped now. please try later.");
                    $system_status = 'on';
                }
            }

            $image_max_size = SystemSetting::where('setting_key', 'image_max_size')->first()->setting_value;
            if ($image_max_size) {
                $image_max_size = $image_max_size * 1000;
            }
            $image_types = SystemSetting::where('setting_key', 'image_types')->first()->setting_value;

            /*
            //add this code to tracking redirect message
            if(Session::get('redirect_with_message')){
            //dd(Session::all());
            $user_name= Session::get('admin_name');
            $item_id= Session::get('opened_item');
            $session_message= Session::get('message');
            $session_message_type= Session::get('message_type');
            Storage::append( 'after_redirect_messages.txt',"message:($session_message) message_type:($session_message_type) to:($to) item_id:($item_id) username:($user_name) date:(".date('Y-m-d h:i:s').")" );
            Session::forget('redirect_with_message');
            }
             */
            /*---------Tours -------*/
            $module_id = CRUDBooster::getCurrentModule()->id;
            $page_type = CRUDBooster::getCurrentMethod();

            if ($page_type != "importDataForm") {
                $tour = Tour::where('module_id', $module_id)
                    ->where('page_type', $page_type)
                    ->where('active', 1)
                    ->with('steps')->first();
            } else {
                $tour = Tour::where('page_type', $page_type)
                    ->where('active', 1)
                    ->with('steps')->first();
            }
            $tour_steps = $tour->steps;

            $steps = [];
            if ($tour_steps) {
                foreach ($tour_steps as $step) {
                    $elem = $step->element_key;
                    if ($elem == "") {
                        $elem = TourStepElements::find($step->element_id)->element_key;
                    }
                    $temp = array(
                        'element' => "$elem",
                        'title' => $step->title,
                        'description' => $step->description,
                    );
                    array_push($steps, $temp);
                }
            }

            //check tour cookies and process autoplay
            $tour_autoplay = false;
            /*
            if($steps && CRUDBooster::myId()){

            $tour_cookie_name = "Tour_".$tour->id."_user_".CRUDBooster::myId();
            //$cookie_value = Cookie::get($tour_cookie_name);
            $cookie_value = $_COOKIE[$tour_cookie_name];
            if($cookie_value != null){
            //there is tour cookies
            $tour_autoplay = false;
            }else{
            $tour_autoplay = true;
            //Cookie::queue($tour_cookie_name, 1, 2);
            setcookie($tour_cookie_name, 1, time() + (10 * 365 * 24 * 60 * 60)); //expired after 10 years
            }
            }
             */

            /*----------------------*/
            $view->with('tour', $steps);
            $view->with('tour_autoplay', $tour_autoplay);
            $view->with('system_status', $system_status);
            $view->with('setting_image_max_size', $image_max_size);
            $view->with('setting_image_types', $image_types);
            $view->with('display_current_cycle', $display_current_cycle);
            $view->with('old_cycle_edited_status', $old_cycle_edited_status);
        });

        $systemSetting = DB::table('system_settings')->where('setting_key', 'https_option')->first();

        if ($systemSetting->setting_value == 'on') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
