@extends('crudbooster::admin_template')
@section('content')
 

        <style type="text/css">
                            
                .select2-container--default .select2-selection--single {
                    border-radius: 0px !important
                }

                .select2-container .select2-selection--single {
                    height: 35px
                }

                .select2-container--default .select2-selection--multiple .select2-selection__choice {
                    background-color: #3c8dbc !important;
                    border-color: #367fa9 !important;
                    color: #fff !important;
                }

                .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                    color: #fff !important;
                }
        </style>

<div class='row'>
    <div class="col-sm-12">
        <div class="col-sm-9">
            <h3>  الإعدادات    </h3>
            <hr style="border:1px solid white;"/>
        </div>
        <div class="col-sm-3">
            <a class="btn btn-warning" style="float:left; margin-right:5px;" href="{{url('/modules/admin/statistics')}}">  رجوع <i class="fa fa-chevron-circle-right"></i>  </a>

            <a class="btn btn-primary" id="edit-setting" style="float:left;" href="javascript:void(0)">  حفظ التعديل <i class="fa fa-save"></i>  </a>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <div style="padding:30px;">
                @php
                $selected = [];
                $last_show_method = DB::table('statistics_setting')->where('id',1)->first()->value;
                $last_choosen_accounts = DB::table('statistics_setting')->where('id',2)->first()->value;
                $selected = explode(',',$last_choosen_accounts);
                
                $details = DB::table('accounts')->where('major_classification',0)->get();

                @endphp
                <form id="form-setting" name="form-setting" role="form" method="get" >
                    <div class="form-group">
                            <label> أختر طريقة عرض النتائج على الصفحة الرئيسية :</label>
                            <label class="">
                                <input type="radio" name="show_method" class="flat-red" value="1" <?php echo ($last_show_method == 1)?" checked":"" ?>> صناديق
                            </label>
                            <label class="">
                                <input type="radio" name="show_method" class="flat-red" value="0" <?php echo ($last_show_method == 0)?" checked":"" ?> > جداول
                            </label>
                        </div>
                    
                        <div class="form-group">
                                <label> أختر الحسابات المراد عرضها على الصفحة الرئيسية :</label>
                               
                                <select class="accounts_ids form-control" name="accounts[]" multiple >
                                    @foreach ($details as $item)
                                    @if(in_array($item->id,$selected))
                                    <option value="{{$item->id}}" selected>{{$item->name_ar}}</option>
                                    @else
                                    <option value="{{$item->id}}">{{$item->name_ar}}</option>
                                    @endif
                                    @endforeach
                                </select>

                        </div>
                    </div>
                </form>
            </div>
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
    
    $(document).ready(function(){
        $("#edit-setting").click(function(){
           let data =$('form#form-setting').serializeArray();
           let data_json = JSON.stringify(data);
           //let data_str =$('form#form-setting').serialize();
           //console.log(data_str);
           console.log(data_json);

            $('#edit-setting i').removeClass('fa-save');
            $('#edit-setting i').addClass('fa-refresh fa-spin');
            $('#edit-setting').addClass('disabled');
            $.get('/modules/admin/statistics/setting/edit/'+data_json,function(res){
                console.log(res);
                $('#edit-setting i').removeClass('fa-refresh fa-spin');
                $('#edit-setting i').addClass('fa-save');
                $('#edit-setting').removeClass('disabled');

                //location.href = 'http://127.0.0.1:8000/modules';
            })
            
        });
    });
    
</script>
@endsection
