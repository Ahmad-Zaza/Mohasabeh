<?php namespace crocodicstudio_voila\crudbooster\controllers;

use Illuminate\Support\Facades\Excel;
use Illuminate\Support\Facades\PDF;
use Request;
use DB;
class LogsController extends CBController
{
    public function cbInit()
    {
        $this->table = 'cms_logs';
        $this->primary_key = 'id';
        $this->title_field = "ipaddress";
        $this->button_bulk_action = true;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_add = false;
        $this->button_edit = false;
        $this->button_delete = true;

        $this->col = [];
        $this->col[] = ["label" => "التاريخ", "name" => "created_at"];
        $this->col[] = ["label" => "IP عنوان", "name" => "ipaddress"];
        $this->col[] = ["label" => "الموظف", "name" => "id_cms_users", "join" => config('crudbooster.USER_TABLE').",name"];
        $this->col[] = ["label" => "التوصيف", "name" => "description"];

        $this->form = [];
        $this->form[] = ["label" => "التاريخ", "name" => "created_at", "readonly" => true];
        $this->form[] = ["label" => "IP عنوان", "name" => "ipaddress", "readonly" => true];
        $this->form[] = ["label" => "User Agent", "name" => "useragent", "readonly" => true];
        $this->form[] = ["label" => "الرابط URL", "name" => "url", "readonly" => true];
        $this->form[] = [
            "label" => "الموظف",
            "name" => "id_cms_users",
            "type" => "select",
            "datatable" => config('crudbooster.USER_TABLE').",name",
            "readonly" => true,
        ];
        $this->form[] = ["label" => "التوصيف", "name" => "description", "readonly" => true];
        $this->form[] = ["label" => "التفاصيل", "name" => "details", "type" => "custom"];
    }

    public static function displayDiff($old_values, $new_values)
    {
        //dd($old_values);
        //dd($new_values);
        $diff = self::getDiff($old_values, $new_values);
        //dd($diff);
        $table = '<table class="table table-striped"><thead><tr><th>Key</th><th>Old Value</th><th>New Value</th></thead><tbody>';
        foreach ($diff as $key => $value) {
            $table .= "<tr><td>$key</td><td>$old_values[$key]</td><td>$new_values[$key]</td></tr>";
        }
        $table .= '</tbody></table>';

        return $table;
    }

    private static function getDiff($old_values, $new_values)
    {
        unset($old_values['id']);
        unset($old_values['created_at']);
        unset($old_values['updated_at']);

        unset($new_values['created_at']);
        unset($new_values['updated_at']);

        return array_diff($old_values, $new_values);
    }

    public static function displayAddSource($id)
    {
        $url = Request::url();
        $url = str_replace('add-save',"detail/$id",$url);
        $btn = "<a href='$url' target='_blank' class='btn btn-xs btn-primary' >المصدر</a>";
        return $btn;
    }

    public static function displayDeleteSource($table,$id)
    {
        $btn = '';
        if(in_array($table,array('bills','vouchers'))){
            $url = Request::url();
            $url = str_replace('delete',"detail",$url);
            $btn = "<a href='$url' target='_blank' class='btn btn-xs btn-primary' >المصدر</a>";
        }else{
            $btn = '';
        }
        return $btn;
    }

    public static function displayEditSource($table,$id,$old_values, $new_values)
    {
        $btn = '';
        if(in_array($table,array('bills','vouchers'))){
            if($table == 'bills'){
                $btn_after_edit_title = 'الفاتورة المعدلة';
                $btn_before_edit_title = 'الفاتورة القديمة';
            }else{
                $btn_after_edit_title = 'السند المعدل';
                $btn_before_edit_title = 'السند القديم';
            }
            $url = Request::url();
            $url = str_replace('edit-save',"detail",$url);
            $btn = "<a href='$url' target='_blank' class='btn btn-xs btn-primary' > $btn_after_edit_title </a>";
            
            $p_code = DB::table("$table")->where('id',$id)->first()->p_code;
            $old_bill_id = DB::table("$table")->where('p_code',$p_code)->where('delete_by','!=',0)->orderby('id','desc')->first()->id;
            $old_url = Request::url();
            $old_url = str_replace("edit-save/$id","detail/$old_bill_id",$old_url);
            $btn .= "<br/><a href='$old_url' target='_blank' class='btn btn-xs btn-warning' > $btn_before_edit_title </a>";
            
        }else{
            $url = Request::url();
            $url = str_replace('edit-save',"detail",$url);
            $btn = "<a href='$url' target='_blank' class='btn btn-xs btn-primary' >المصدر</a>";
        }
        return $btn;
    }
}
