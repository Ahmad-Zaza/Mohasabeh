<?php

namespace App\Providers;

use App\CompanyInformation;
use App\Seo;
use App\SocialMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        $lang = config('app.locale');
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {

            if (Route::current()) {
                $lang = config('app.locale');
                $social_media = SocialMedia::where('active', 1)->orderBy('sorting')->get();
                $settings = DB::table('cms_settings')->whereIn('group_setting', ['Application Setting', 'SEO Setting'])->pluck('content', 'name');

                $company_information = CompanyInformation::where('active', 1)->first();

                if (Route::current()->uri == "/") {
                    $seo = Seo::where("page", "home")->where('language', $lang)->first();
                } else if (strpos(Route::current()->uri, "{title}") === false) {
                    $seo = Seo::where("page", Route::current()->uri)->whereNull("page_id")->where('language', $lang)->first();
                } else if (Route::current()->parameters) {
                    $temp = explode("/{title}", Route::current()->uri)[0];
                    $db_table = '';
                    if ($temp == 'blogs') {
                        $db_table = 'articles';
                    } else {
                        $db_table = $temp;
                    }
                    $modul_id = DB::table($db_table)->where('slug', Route::current()->parameters["title"])->whereNull('deleted_at')->first()->id;
                    $seo = Seo::where("page", $temp)->where("page_id", $modul_id)->where('language', $lang)->first();
                }

                //if page don't has seo show site SEO
                if (!$seo) {
                    $seo = $seo = Seo::where("page", "home")->where('language', $lang)->first();
                }
                $view->with('seo', $seo);
                $view->with('settings', $settings);
                $view->with('social_media', $social_media);
                $view->with('company_information', $company_information);
            }
        });

        // View::share(['social_media' => $social_media, 'company_information' => $company_information]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('path.public', function () {
            return realpath(base_path() . '/../');
        });
    }
}
