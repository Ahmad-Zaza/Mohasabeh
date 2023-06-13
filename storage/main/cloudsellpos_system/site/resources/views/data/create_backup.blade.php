@extends('crudbooster::admin_template')
@section('content')
       <!-- Box -->
       <div id='box_main' class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> {{trans('modules.create_backup')}} </h3>
                <div class="box-tools">

                </div>
            </div>

            <?php
            $action_path = CRUDBooster::mainpath();
            $action = $action_path . '/get-import-data';
            ?>

            <form id="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="box-body">

                    <div class='callout callout-success' id="info-message">
                        <h4>{{trans('labels.wellcome_create_backup')}} </h4>
                        <p>{{trans('labels.backup_system_details')}}</p>
                        {!! trans('labels.create_backup_statements') !!}
                    </div>

                    <div class="form-group">
                        <label for="backup_name">{{trans('labels.backup_name')}}</label>
                        <input type="text" class="form-control" id="backup_name" name="backup_name" placeholder="{{trans('labels.enter_backup_name')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="backup_note">{{trans('labels.backup_notes')}}</label>
                        <textarea rows="4" class="form-control" id="backup_notes" name="backup_notes" placeholder="{{trans('labels.enter_backup_notes')}}" required></textarea>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    @if($showErrorMsg)
                    <div class="callout callout-danger">
                            <i class="icon fa fa-ban"></i>
                            {{trans('messages.connot_create_new_backup_because_no_enough_size')}}
                    </div> 
                    @endif
                    <div class='pull-right'>
                        <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default' id="go-back"> {{trans('labels.back')}} <i class="fa fa-chevron-circle-left"></i> </a>
                        <button id="submit-btn" class='btn btn-primary' name="submit"
                            type="submit"  @if($showErrorMsg) disabled @endif> {{trans('labels.create')}} <i class="fa fa-download"></i> </button>

                    </div>
                    <div class="">
                        <br />
                        <br />
                        <br />
                        <div class="callout callout-info waiting-msg hidden">
                            <h4> {{trans('labels.please_waitting')}}</h4>
                            <p>{{trans('labels.process_take_some_time')}} <i class="fa fa-refresh fa-spin"></i></p>

                        </div>
                    </div>
                </div><!-- /.box-footer-->
            </form>
        </div><!-- /.box -->

    <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

    <script type="text/javascript">
        function formSubmit(e) {
            e.preventDefault();
            $("#submit-btn").addClass('disabled');
            $("#submit-btn i").removeClass('fa-download');
            $("#submit-btn i").addClass('fa-spinner fa-spin');
            $('.waiting-msg').removeClass('hidden');
            $('.loading').css("display", "table");
            
            let data = $('form').serializeArray();
            let data_json = JSON.stringify(data);
            $.post("/backup/create",$('form').serialize(), function(res) {
                let json_res = JSON.parse(res);
                let text_msg = json_res.massege;
                if(json_res.status == 'error'){
                    notify(_ERROR,text_msg,'error');
                }else{
                    notify(_SUCCESS,text_msg,'success');
                    location.href="{{ CRUDBooster::mainpath() }}";
                }
            });

        }
         
            const form = document.getElementById('form');
            form.addEventListener('submit',formSubmit);
    </script>
@endsection
