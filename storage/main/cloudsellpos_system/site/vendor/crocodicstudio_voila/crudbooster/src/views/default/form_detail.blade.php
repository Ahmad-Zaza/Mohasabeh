<?php
use App\Models\Bills\BillType;
use App\Models\Users\Delegate;
use App\Models\Users\User;
use App\Models\Users\Privilege;
use App\Models\Inventories\Inventory;
use App\Models\Accounts\Supplier;

use App\Http\Controllers\General\GeneralFunctionsController;
$gfunc = new GeneralFunctionsController();
$hasPermission = $gfunc->checkOldCycleHasEditedPermission();

//Loading Assets
$asset_already = [];
echo "<div class='pull-left detail-page-btns print_display_none' style='margin-top:-26px;'>";
echo "<span class='btn btn-info btn-xs' onclick='window.print();' > ".trans('labels.print')." <i class='fa fa-print'></i></span>";

if($hasPermission && $row->checked_for_update !== null && CRUDBooster::isSuperAdmin() && $row->action == NULL &&  (CRUDBooster::getCurrentModule()->path != 'transfer_vouchers')){
    if($row->checked_for_update == 0 ){
        echo "<a class='btn btn-xs btn-success' title='".trans('modules.checked')."' onclick='' href='".CRUDBooster::mainpath()."/set-status/true/$id' target='_self' > ".trans('modules.checked')." <i class='fa fa-check'></i> </a>"; 
    }else{
        echo "<a class='btn btn-xs btn-warning' title='".trans('modules.remove_checked')."' onclick='' href='".CRUDBooster::mainpath()."/set-status/false/$id' target='_self'> ".trans('modules.remove_checked')." <i class='fa fa-ban'></i> </a>";
    }
}


if($hasPermission){
    $url = url()->current();
    $edit_url = str_replace('detail','edit',$url);
    $edit_url = $edit_url ."?return_url=".$url;

    if(CRUDBooster::isSuperAdmin() && $row->action == NULL){
        echo "<a class='btn btn-xs btn-success' href='$edit_url'> ".trans('labels.edit')." <i class='fa fa-pencil'></i></a>";
    }else if(!CRUDBooster::isSuperAdmin() && CRUDBooster::isUpdate() && $row->checked_for_update !== 1 && $row->action == NULL){    
        //dd($edit_url);
        echo "<a class='btn btn-xs btn-success' href='$edit_url'> ".trans('labels.edit')." <i class='fa fa-pencil'></i></a>";
    }
}
if(isset($_REQUEST['link']) && $_REQUEST['link']=='source'){    
    echo "<a class='btn btn-xs btn-primary' href='javascript:void();' onclick='window.close();'> ".trans('labels.close')." <i class='fa fa-close'></i></a>";
}

echo "</div>";
if($row->staff_id || $row->checked_for_update == 1){
    echo "<div class='other_details_container'><div class='other_details_sect' >";
    if($row->staff_id){
        
        $staff_name = User::find($row->staff_id)->name;
        echo "<span> ".trans('labels.entered_by')."  <span class='badge'> $staff_name </span></span>";
    
    }
    if($row->edit_by != 0){
        echo "<br/>";
        $edit_by_name = User::find($row->edit_by)->name;
        echo "<span> ".trans('labels.last_edit_by')."  <span class='badge'> $edit_by_name </span></span>";
    }
    if($row->delete_by != 0){
        echo "<br/>";
        $delete_by_name = User::find($row->delete_by)->name;
        echo "<span> ".trans('labels.delete_by')."  <span class='badge'> $delete_by_name </span></span>";
    }
    if($row->checked_for_update == 1){
        echo "<br/>";
        $admin_privilage_name = Privilege::find(1)->name;
        echo "<span> ".trans('labels.checked_by')."  <span class='badge'> $admin_privilage_name </span></span>";
    }
    echo "</div> </div>";
}

foreach($forms as $form) {
$type = @$form['type'] ?: 'text';

if (in_array($type, $asset_already)) continue;

?>
@if(file_exists(base_path('/vendor/crocodicstudio_voila/crudbooster/src/views/default/type_components/'.$type.'/asset.blade.php')))
    @include('crudbooster::default.type_components.'.$type.'.asset')
@elseif(file_exists(resource_path('views/vendor/crudbooster/type_components/'.$type.'/asset.blade.php')))
    @include('vendor.crudbooster.type_components.'.$type.'.asset')
@endif
<?php
$asset_already[] = $type;
} //end forms
?>

@push('head')
    <style type="text/css">
        #table-detail tr td:first-child {
            font-weight: bold;
            width: 25%;
        }
    </style>
@endpush

<div class='table-responsive'>
    <table id='table-detail' class='table table-striped'>
        <?php
        //dd($forms);
        foreach($forms as $index=>$form):

        $name = $form['name'];
        @$join = $form['join'];
        @$value = (isset($form['value'])) ? $form['value'] :null;
        @$value = (isset($row->{$name})) ? $row->{$name} : $value;
        @$showInDetail = (isset($form['showInDetail'])) ? $form['showInDetail'] : true;


        if ($showInDetail == FALSE) {
            continue;
        }
        //معالجات خاصة بعرض السندات الافتتاحية
        if($row->voucher_type_id !== null && $row->voucher_type_id == 4 ){
            if(($name =='debit' && $value == 0) || ($name =='credit' && $value == 0)){
                continue;
            }
        }
        //----------------

        if (isset($form['callback_php'])) {
            @eval("\$value = ".$form['callback_php'].";");
        }

        if (isset($form['callback'])) {
            $value = call_user_func($form['callback'], $row);
        }

        if (isset($form['default_value'])) {
            @$value = $form['default_value'];
        }

        if ($join && @$row) {
            $join_arr = explode(',', $join);
            array_walk($join_arr, 'trim');
            $join_table = $join_arr[0];
            $join_title = $join_arr[1];
            $join_table_pk = CB::pk($join_table);
            $join_fk = CB::getForeignKey($table, $join_table);
            $join_query_{$join_table} = DB::table($join_table)->select($join_title)->where($join_table_pk, $row->{$join_fk})->first();
            $value = @$join_query_{$join_table}->{$join_title};
            
        }

        $type = @$form['type'] ?: 'text';
        if($type=='radio' && $name=="opposite" && is_int($value)){
            $currency_name = DB::table('currencies')->where('id',$value)->first()->name_ar;
            $value = $currency_name;
        }else if($type=='radio' && $name=="is_cash" || $type=='radio' && $name=="active"
            || $type=='radio' && $name=="is_major"
            || $type=='radio' && $name=="major_classification"
            || $type=='radio' && $name=="visible_to_delegates"){
            if($value == '1'){
                $value = trans('crudbooster.Yes');
            }else{
                $value = trans('crudbooster.No');
            }
        }else if($type=='text' && $name=="bill_type_id" && is_int($value)){
            $value = BillType::find($value)->name_ar;
        }else if($type=='custom' && $name=="inventories"){
            $invs = User::find($id)->inventories()->pluck('name_ar')->toArray();
            $temp= "";
            foreach($invs as $inv){
                $temp.=" <span class='badge'> $inv </span> ";
            }
            $value = $temp;
        }else if($type=='custom' && $name=="suppliers"){
            $sups = User::find($id)->suppliers()->pluck('name_ar')->toArray();
            $temp= "";
            foreach($sups as $sup){
                $temp.=" <span class='badge'> $sup </span> ";
            }
            $value = $temp;
        }else if($type=='custom' && $name=="icon"){
            $value=" <i class='$value'></i> ";
        }else if($type=='custom' && $name=="delegates"){
            $delegates = Inventory::find($id)->delegates()->pluck('name')->toArray();
            $temp= "";
            foreach($delegates as $del){
                $temp.=" <span class='badge'> $del </span> ";
            }
            $value = $temp;
        }else if($type=='custom' && $name=="supplier_delegates"){
            $delegates = Supplier::find($id)->delegates()->pluck('name')->toArray();
            $temp= "";
            foreach($delegates as $del){
                $temp.=" <span class='badge'> $del </span> ";
            }
            $value = $temp;
        }else if($type=='select' && $name=="status"){ //in bills details
            if($value == 1){
                $value = '<span class="badge bg-green">'.trans('labels.active_bill').'</span>';
            }else if($value == 0){
                $value = '<span class="badge bg-yellow">'.trans('labels.draft_bill').'</span>';
            };
        }

        $required = (@$form['required']) ? "required" : "";
        $readonly = (@$form['readonly']) ? "readonly" : "";
        $disabled = (@$form['disabled']) ? "disabled" : "";
        $jquery = @$form['jquery'];
        $placeholder = (@$form['placeholder']) ? "placeholder='".$form['placeholder']."'" : "";
        $file_location = base_path('vendor/crocodicstudio_voila/crudbooster/src/views/default/type_components/'.$type.'/component_detail.blade.php');
        $user_location = resource_path('views/vendor/crudbooster/type_components/'.$type.'/component_detail.blade.php');

        ?>

        @if(file_exists($file_location))
            <?php $containTR = (substr(trim(file_get_contents($file_location)), 0, 4) == '<tr>') ? TRUE : FALSE;?>
            @if($containTR)
                @include('crudbooster::default.type_components.'.$type.'.component_detail')
            @else
                <tr>
                    <td>{{$form['label']}}</td>
                    <td>@include('crudbooster::default.type_components.'.$type.'.component_detail')</td>
                </tr>
            @endif
        @elseif(file_exists($user_location))
            <?php $containTR = (substr(trim(file_get_contents($user_location)), 0, 4) == '<tr>') ? TRUE : FALSE;?>
            @if($containTR)
                @include('vendor.crudbooster.type_components.'.$type.'.component_detail')
            @else
                <tr>
                    <td>{{$form['label']}}</td>
                    <td>@include('vendor.crudbooster.type_components.'.$type.'.component_detail')</td>
                </tr>
            @endif
        @else
        <!-- <tr><td colspan='2'>NO COMPONENT {{$type}}</td></tr> -->
        @endif

        <?php endforeach;?>

        
    </table>
</div>

<!-------------- Next & Prev Buttons Section ------------->
<?php 
        
        if(!isset($_REQUEST['link'])){
            Session::put('opened_item',$id); // to highlight item was opened
        }
        //dd($table);
        /*
        $sect_display = true;
        if(isset($_REQUEST['link']) && $_REQUEST['link']=='source'){
            $sect_display = false;
        }else{
                Session::put('opened_item',$id); // to highlight item was opened
                
                $me = DB::table('cms_users')->find(CRUDBooster::myId());
                $conditions = [];
                switch($table){
                    case 'bills': 
                        $conditions = array(['action', '=',  NULL ]);
                        $bill = DB::table($table)->where('id', $id)->first();
                        $bill_type = $bill->bill_type_id;

                        array_push($conditions,['bill_type_id',$bill_type]);

                        if ($me->id_cms_privileges == 4) { //is delegate
                            array_push($conditions,['delegate_id',$me->id]);
                        }

                        break;
                    case 'vouchers': 
                        $conditions = array(['action', '=',  NULL ]);
                        $voucher = DB::table($table)->where('id', $id)->first();
                        $voucher_type = $voucher->voucher_type_id;

                        array_push($conditions,['voucher_type_id',$voucher_type]);

                        if ($me->id_cms_privileges == 4) { //is delegate
                            array_push($conditions,['delegate_id',$me->id]);
                        }
                        break;

                    case 'item_tracking': 
                        $conditions = array(['action', '=',  NULL ]);
                        $record = DB::table($table)->where('id', $id)->first();
                        $record_type = $record->item_tracking_type_id;

                        array_push($conditions,['item_tracking_type_id',$record_type]);
                        break;  

                    case 'persons': 
                            $conditions = array();
                            $record = DB::table($table)->where('id', $id)->first();
                            $record_type = $record->person_type_id;
                            array_push($conditions,['person_type_id',$record_type]);

                            if ($me->id_cms_privileges == 4) { //is delegate
                                array_push($conditions,['delegate_id',$me->id]);
                            }
                            if($me->id_cms_privileges == 4 && $record_type == 2){ //موردين
                                $sect_display = false;
                            }
                            break;
                    
                    case 'transfer_tracking': 
                        if ($me->id_cms_privileges == 4) { //is delegate
                            array_push($conditions,['staff_id',$me->id]);
                        }
                        break;          
                    case 'inventories': 
                            if ($me->id_cms_privileges == 4) { //is delegate
                                $sect_display = false;
                            }
                            break;      
                        

                }
            }       

        if($sect_display){
                $previous = DB::table($table)->where($conditions)->where('id', '<', $id)->max('id');
                $next = DB::table($table)->where($conditions)->where('id', '>', $id)->min('id');

                $previous_url = '';
                $next_url = '';
                $url = url()->current();
                //dd($url);
                if($previous){
                    $previous_url = str_replace("detail/$id","detail/$previous",$url);
                }
                if($next){
                    $next_url = str_replace("detail/$id","detail/$next",$url);
                }
        }

        //dd($previous);
        */
?>
<!--
<div class="prev_next_sect">
    @if($next_url != '') 
        <a href="{{$next_url}}" class="btn btn-sm btn-primary"><i class="fa fa-angle-double-right"></i> التالي </a>
    @endif
    @if($previous_url != '') 
        <a href="{{$previous_url}}" class="btn btn-sm btn-info" style="float:left;">السابق <i class="fa fa-angle-double-left"></i></a> 
    @endif
</div>
-->
