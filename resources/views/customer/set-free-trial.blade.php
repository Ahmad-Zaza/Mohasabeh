@extends('crudbooster::admin_template')
@section('content')
<div>

    @if(CRUDBooster::getCurrentMethod() != 'getProfile')
        @if(g('return_url'))
            <p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i>
                    &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
        @else
            <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i>
                    &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
        @endif
    @endif
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {!! "Set Customer Free Trial" !!}</strong>
    </div>

    <div class="panel-body" style="padding:20px 0px 0px 0px">
        <?php
        $action = CRUDBooster::mainpath("saveFreeTrial");
        ?>
        <form class='form-horizontal was-validated' method='post' id="form" enctype="multipart/form-data" action='{{ $action}}'>
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type='hidden' name='return_url' value='{{ @$return_url }}'/>
            <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}'/>
            <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}'/>
            <div class="box-body" id="parent-form-area">
                @include('crudbooster::default.type_components.date.asset')
                <div class='form-group form-datepicker' id='form-group-free-trial-start-date'
                    style="{{@$form['style']}}">
                   <label class='control-label col-sm-2'>Free Trial Start Date
                        <span class='text-danger' title='{!! trans('crudbooster.this_field_is_required') !!}'>*</span>
                   </label>
               
                   <div class="col-sm-4">
                       <div class="input-group">
                           <span class="input-group-addon open-datetimepicker"><a><i class='fa fa-calendar '></i></a></span>
                           <input type='text' title="Free Trial Start Date"
                                  required class='form-control notfocus input_date' name="free-trial-start-date" id="free-trial-start-date"
                                  value='{{$value}}'/>
                       </div>
                       <div class="text-danger">{!! $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):"" !!}</div>
                   </div>
               </div>
               <div class='form-group form-datepicker' id='form-group-free-trial-start-date'
                    style="{{@$form['style']}}">
                   <label class='control-label col-sm-2'>Free Trial End Date
                        <span class='text-danger' title='{!! trans('crudbooster.this_field_is_required') !!}'>*</span>
                   </label>
               
                   <div class="col-sm-4">
                       <div class="input-group">
                           <span class="input-group-addon open-datetimepicker"><a><i class='fa fa-calendar '></i></a></span>
                           <input type='text' title="Free Trial End Date"
                                  require class='form-control notfocus input_date' name="free-trial-end-date" id="free-trial-end-date"
                                  value='{{$value}}'/>
                       </div>
                       <div class="text-danger">{!! $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):"" !!}</div>
                   </div>
               </div>
               
            </div>


            <div class="box-footer" style="background: #F5F5F5">
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">
                        <input type="submit" name="submit" value='{{trans("crudbooster.button_save")}}' class='btn btn-success'>
                        <a href='{{CRUDBooster::mainpath() }}' class='btn btn-default'><i
                                    class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}</a>
                    </div>
                </div>


            </div><!-- /.box-footer-->

        </form>
    </div>
</div>
<script language="javascript" type="text/javascript">
    //$("#form").submit(function(e) {
   //     e.preventDefault();
   //     var data = $("#form").serialize();
   //     //$("#form").submit();
   //     $("#form").validate();
   // });

</script>

@endsection