@extends('crudbooster::admin_template')
@section('content')
    @include('statistics.CSS.statistic_style');
    <div class='row'>
        <div class="col-sm-12">
            <div class="col-sm-9">
                <h3> {{trans('labels.configration')}} </h3>
                <hr style="border:1px solid white;" />
            </div>
            <div class="col-sm-3">

            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div style="padding:30px;">
                    @php
                        $selected = [];
                        $last_show_method = DB::table('statistics_setting')
                            ->where('id', 1)
                            ->first()->value;
                        $last_choosen_accounts = DB::table('statistics_setting')
                            ->where('id', 2)
                            ->first()->value;
                        $selected = explode(',', $last_choosen_accounts);
                        
                        $details = DB::table('accounts')
                            ->where('major_classification', 0)
                            ->get();
                        
                    @endphp
                    <form id="form-setting" name="form-setting" role="form" method="get">
                        <div class="form-group" id="form-setting-show-method">
                            <label> {{trans('labels.choose_show_method_in_dashboard')}} :</label>
                            <label class="">
                                <input type="radio" name="show_method" class="flat-red" value="1"
                                    <?php echo $last_show_method == 1 ? ' checked' : ''; ?>>  {{trans('labels.boxes')}}
                            </label>
                            <label class="">
                                <input type="radio" name="show_method" class="flat-red" value="0"
                                    <?php echo $last_show_method == 0 ? ' checked' : ''; ?>> {{trans('labels.tables')}}
                            </label>
                        </div>

                        <div class="form-group" id="form-setting-accounts">
                            <label> {{trans('labels.choose_accounts_that_showen_in_dashboard')}} :</label>

                            <select class="accounts_ids form-control" name="accounts[]" multiple>
                                @foreach ($details as $item)
                                    @if (in_array($item->id, $selected))
                                        <option value="{{ $item->id }}" selected>{{ $item->name_ar }}</option>
                                    @else
                                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>

                    </form>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top:100px;">
                <a class="btn btn-primary" id="edit-setting" style="margin-right:15px;" href="javascript:void(0)"> {{trans('labels.save_edits')}}
                     <i class="fa fa-save"></i> </a>
                <a class="btn btn-default" href="{{ url('/modules/admin/statistics') }}" id="go-back"> {{trans('labels.back')}} <i
                        class="fa fa-chevron-circle-left"></i> </a>
            </div>
        </div>

    </div>

    <script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script>
        $(function() {
            $('.accounts_ids').select2({
                dir: "rtl"
            });

        });

        $(document).ready(function() {
            $("#edit-setting").click(function() {
                let data = $('form#form-setting').serializeArray();
                let data_json = JSON.stringify(data);
                //let data_str =$('form#form-setting').serialize();
                //console.log(data_str);
                console.log(data_json);

                $('#edit-setting i').removeClass('fa-save');
                $('#edit-setting i').addClass('fa-refresh fa-spin');
                $('#edit-setting').addClass('disabled');
                $.get('/modules/admin/statistics/setting/edit/' + data_json, function(res) {
                    console.log(res);
                    $('#edit-setting i').removeClass('fa-refresh fa-spin');
                    $('#edit-setting i').addClass('fa-save');
                    $('#edit-setting').removeClass('disabled');

                    var base_url = window.location.origin;
                    window.location.href = base_url + '/modules/admin/statistics';
                })

            });
        });
    </script>
@endsection
