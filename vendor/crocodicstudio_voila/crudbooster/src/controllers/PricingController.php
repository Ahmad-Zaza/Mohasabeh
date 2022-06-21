<?php namespace crocodicstudio_voila\crudbooster\controllers;

use Request;
use Response;
use Storage;
use CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Excel;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Session;
class PricingController extends Controller
{
    public function cbInit()
    {
        $this->module_name = "price_pkg_options";
        $this->table = 'price_pkg_options';
        $this->primary_key = 'id';
        $this->title_field = "name";
        $this->button_import = false;
        $this->button_export = false;
        $this->button_action_style = 'button_icon';
        $this->button_detail = false;
        $this->button_bulk_action = false;

        $this->col = [];
        $this->col[] = ["label" => "ID", "name" => "id"];
        $this->col[] = ["label" => "Name", "name" => "name"];
        $this->col[] = [
            "label" => "Superadmin",
            "name" => "is_superadmin",
            'callback_php' => '($row->is_superadmin)?"<span class=\"label label-success\">Superadmin</span>":"<span class=\"label label-default\">Standard</span>"',
        ];

        $this->form = [];
        $this->form[] = ["label" => "Name", "name" => "name", 'required' => true];
        $this->form[] = ["label" => "Is Superadmin", "name" => "is_superadmin", 'required' => true];
        $this->form[] = ["label" => "Theme Color", "name" => "theme_color", 'required' => true];

        $this->alert[] = [
            'message' => "You can use the helper <code>CRUDBooster::getMyPrivilegeId()</code> to get current user login privilege id, or <code>CRUDBooster::getMyPrivilegeName()</code> to get current user login privilege name",
            'type' => 'info',
        ];
    }
    public function getAdd(){
        $this->cbLoader();
        $pricing_pkgs=\App\PricePkgOption::all();
        //dd($pricing_pkgs);
        $data['page_title'] = "Add Data";
        $data['moduls'] = DB::table("price_pkg_options")->whereNull('deleted_at')->get();
        $data['page_menu'] = Route::getCurrentRoute()->getActionName();
        return view('crudbooster::create_pricing_options', compact($pricing_pkgs,$data));
    }
}
?>