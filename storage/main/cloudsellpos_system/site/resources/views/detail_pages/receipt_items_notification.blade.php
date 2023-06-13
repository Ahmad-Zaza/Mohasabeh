@extends('crudbooster::admin_template')
@section('content')
<!-- <link href='{{ asset("vendor/crudbooster/assets/adminlte/plugins/iCheck/all.css")}}' rel="stylesheet" type="text/css"/>
<style>
    .icheckbox_minimal-blue.checked.disabled {
        background-position: -40px 0;
        cursor:not-allowed;
    }
</style> -->
<?php 
    use App\Models\Users\User;
    use App\Models\Users\Privilege;
    use App\Models\Inventories\TransferTrackingList;
    use App\Models\Inventories\TransferTrackingNote;
    
?>
<div>
       
        @if($button_cancel)
            @if(g('return_url'))
                <p><a title='Return' href='{{g("return_url")}}' id="go-back"><i class='fa fa-chevron-circle-left '></i>
                        &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
            @else
                @if(!isset($_REQUEST['link']))
                <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}' id="go-back"><i class='fa fa-chevron-circle-left '></i>
                        &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
                @endif        
            @endif
        @endif
<div class="row">        
    <div class="col-sm-6 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {{trans('labels.transfer_tracking_detail')}}</strong>
            </div>

            <div class="panel-body" style="padding:20px 0px 0px 0px">

                <div class="box-body" id="parent-form-area">

                    <?php

                    //Loading Assets
                    $asset_already = [];

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


                    <?php 

                            if(!isset($_REQUEST['link'])){
                                Session::put('opened_item',$id); // to highlight item was opened
                            }

                    ?>


                </div><!-- /.box-body -->

                <div class="box-footer" style="background: #F5F5F5">

                </div><!-- /.box-footer-->

                        
            </div>
        </div>
        
    </div> <!-- END COL 8 -->

    <div class="col-sm-6 col-xs-12">
                    <div class='pull-left detail-page-btns print_display_none' style='margin-top:-26px;'>
                        <span class='btn btn-info btn-xs' onclick='window.print();' > {{trans('labels.print')}} <i class='fa fa-print'></i></span>

                        @if(isset($_REQUEST['link']) && $_REQUEST['link']=='source'){    
                            <a class='btn btn-xs btn-primary' href='javascript:void();' onclick='window.close();'> {{trans('labels.close')}} <i class='fa fa-close'></i></a>
                        @endif

                    </div>
        @php 
           $panel_cls = 'panel-success'; 
           $panel_msg = trans('labels.you_confirm_receipt_items');                                
           if($row->status == 0){
                $panel_cls = 'panel-danger';
                $panel_msg = trans('labels.items_not_receipt_yet_please_confirm');                                 
           }elseif($row->status == 2){
                $panel_cls = 'panel-warning';
                $panel_msg = trans('labels.you_have_partially_received_the_items');  
           }
        @endphp                   
        <div class="panel {{$panel_cls}}">
                <div class="panel-heading">
                    <strong><i class='fa fa-text-width'></i> {{trans('labels.receipt_items_confirm')}}</strong>
                </div>
                <div class="panel-body">
                    <div class="box-body" >
                        @if($row->status != 1) 
                          {{$panel_msg}}
                           <hr>
                            @php 
                                $items=TransferTrackingList::select(
                                    'items.id as itemID',
                                    'items.name_ar as itemName',
                                    'transfer_items_list.quantity as itemQty',
                                    'item_units.name_ar as itemUnit',
                                    'item_tracking.id as trackID',
                                    'item_tracking.status as trackStatus')
                                ->join("items", "items.id", "transfer_items_list.item_id")
                                ->join("item_tracking", "item_tracking.p_code", "transfer_items_list.p_code")
                                ->join("item_units", "item_units.id", "items.item_unit_id")
                                ->where('transfer_tracking_id',$id)
                                ->where('transaction_operation','in')
                                ->where('item_tracking.action',NULL)
                                ->orderby('transfer_items_list.p_code','desc')
                                ->get();
                            @endphp
                           <form id="receipt_items_confirm_form">
                                <input type="hidden" name="id" value="{{$id}}"/>    
                                <table class="table table-bordered table-striped text-center">
                                    <tbody>
                                        <tr>
                                            <th>{{trans('modules.item')}}</th>
                                            <th>{{trans('modules.quantity')}}</th>
                                            <th>{{trans('modules.item_unit')}}</th>
                                            <th style="width: 40px">
                                            {{trans('modules.status')}}
                                            <br/>
                                            <input type="checkbox" id="receipt_items_check_all" name="receipt_items_check_all" class="minimal">
                                        </th>
                                        </tr>
                                        @foreach ($items as $item)
                                        <tr>
                                            <td>{{$item->itemName}}</td>
                                            <td><span class="badge bg-red">{{$item->itemQty}}</span></td>
                                            <td>{{$item->itemUnit}}</td>
                                            @php 
                                            $checked = "";
                                            if($item->trackStatus){
                                                $checked = "checked disabled";
                                            }
                                            @endphp
                                            <td><label> <input type="checkbox" name="receipt_items" class="minimal" value="{{$item->trackID}}" {{$checked}}> </label> </td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </form>

                           <hr> 
                           <a class='btn btn-block btn-sm btn-primary' id='receipt_items_confirm' data-id="{{$id}}" href='javascript:void();' > {{trans('crudbooster.confirmation_title')}} <i class='fa  fa-check-circle'></i> </a>  
                        @else
                        <div class="text-center">
                            <i class='fa fa-5x fa-check-circle text-green'></i>  </br> 
                            {{$panel_msg}} 
                            @if($row->receipt_by != 0)
                            <hr>
                                @php $receipt_by_name = User::find($row->receipt_by)->name; @endphp
                                <div class="pull-right"><i class='fa  fa-user text-green'></i>  {{trans('modules.action_by')}}  <span class='badge'> {{$receipt_by_name}} </span> </div>
                                <div class="pull-left"><i class='fa  fa-calendar text-green'></i>    {{$row->receipt_date}} </div>
                            @endif    
                        </div>
                        @endif               
                    </div>
                </div>
        </div>
        
        <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class='fa fa-comments-o'></i> {{trans('modules.notes')}}</strong>
                    <span class="text-muted pull-left" id="loading"><i class="fa"></i></span>
                </div>
                    @php 
                        $notes = TransferTrackingNote::where('transfer_tracking_id',$id)->get();
                        $current_user_id = CRUDBooster::getUser()->id;
                        $current_user_img = User::find($current_user_id)->photo;
                        if($current_user_img){
                            $current_user_img = asset("$current_user_img");
                        }else{
                            $current_user_img = asset("vendor/crudbooster/avatar.jpg");
                        } 
                    @endphp
                <div class="panel-body">

                    <div class="box-body" >
                    @if($row->status != 1) 
                        {{trans('labels.if_you_have_notes_add_it')}}
                    @elseif($notes->count() == 0)
                        {{trans('labels.no_notes')}}
                    @endif              
                    </div><!-- /.box-body -->
                  

                    @if($notes->count() > 0)
                    
                    <div class="box-footer box-comments">
                        @foreach ($notes as $note)
                            @php 
                            $user= User::find($note->user_id);
                            $user_name = $user->name;
                            $user_img = asset("vendor/crudbooster/avatar.jpg");
                            if($user->photo){
                                $user_img = asset("$user->photo");
                            }
                            @endphp                
                                <div class="box-comment">
                                    <img class="img-circle img-sm" src="{{$user_img}}" alt="User Image">
                                    <div class="comment-text">
                                        <span class="username">
                                            {{$user_name}}
                                            <span class="text-muted pull-left">{{$note->date}}</span>
                                        </span>
                                        {{$note->note}}
                                    </div>
                                </div>
                        @endforeach                    

                    </div>
                    @endif 
                    @if($row->status != 1) 
                    <div class="box-footer">
                            <img class="img-responsive img-circle img-sm" src="{{$current_user_img}}" alt="Alt Text">

                            <div class="img-push">
                                <textarea  class="form-control input-sm" id="transfer_tracking_not" data-transfer_tracking_id={{$id}} data-user_id="{{$current_user_id}}" placeholder="{{trans('labels.press_enter_to_save_note')}}"></textarea>
                            </div>
                    </div>
                    @endif
                </div>
        </div>

        <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><i class='fa fa-text-width'></i> {{trans('labels.voucher_detail')}}</strong>
                </div>

                <div class="panel-body">

                    <div class="box-body" >
                         <?php
                            if($row->staff_id || $row->checked_for_update == 1){
                                echo "<div class=''><div class='' >";
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
                                if($row->receipt_by != 0){
                                    echo "<br/>";
                                    $receipt_by_name = User::find($row->receipt_by)->name;
                                    echo "<span> ".trans('labels.receipt_by')."  <span class='badge'> $receipt_by_name </span></span>";
                                }
                                if($row->checked_for_update == 1){
                                    echo "<br/>";
                                    $admin_privilage_name = Privilege::find(1)->name;
                                    echo "<span> ".trans('labels.checked_by')."  <span class='badge'> $admin_privilage_name </span></span>";
                                }
                                echo "</div> </div>";
                            }
                         ?>                      
                    </div><!-- /.box-body -->
                </div>
        </div>

        
                                        
    </div> <!-- END COL 4 -->
</div> <!-- END ROW -->
<script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- <script  type="text/javascript" src='{{ asset("vendor/crudbooster/assets/adminlte/plugins/iCheck/icheck.min.js") }}'></script> -->
<script type="text/javascript">
  
  $('input[name=receipt_items_check_all]').on('click', function(event){
        let check_all_status = $(this).is(':checked');
        if(check_all_status == true){
            $('input[name=receipt_items]').prop('checked', true);
        }else{
            $('input[name=receipt_items]:not(:disabled)').prop('checked', false);
        }
    });


//  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
//       checkboxClass: 'icheckbox_minimal-blue',
//       radioClass   : 'iradio_minimal-blue'
//     });



   
</script>
@endsection