<?php

namespace App\Providers;

use App\CompanyInformation;
use App\SocialMedia;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $lang = config('app.locale');
        Schema::defaultStringLength(191);
        $social_media=SocialMedia::where('active',1)->orderBy('sorting')->get();
        $company_information=CompanyInformation::where('active',1)->first();
        View::share(['social_media'=>$social_media,'company_information'=>$company_information]);
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
