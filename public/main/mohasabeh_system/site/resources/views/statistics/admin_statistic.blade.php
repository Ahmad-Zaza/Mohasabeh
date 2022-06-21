@extends('crudbooster::admin_template')
@section('content')
@php 
    $column_num = count($active_currencies);
    if(count($active_currencies) > 6){
        $column_num = 3;
    }
@endphp
<div class='row'>
    <div class="col-sm-12">
        <div class="col-sm-10">
            <h3>  الصفحة الرئيسية   </h3>
            <hr style="border:1px solid white;"/>
        </div>
        <div class="col-sm-2">
            <a class="btn btn-primary" style="float:left;" href="{{url('modules/admin/statistics/setting')}}">  الإعدادات <i class="fa fa-gear"></i>  </a>
        </div>
    </div>

    


@if($show_method==0) 
<!-- start show method is tables -->
    <!----- start Table ------>
    <div class="col-sm-12">
                    <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">
                                
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="tableFixHead">
                                    <table id="tableId" class="table table-bordered table-striped dataTable text-center" role="grid" aria-describedby="example1_info">
                                        <thead>
                                        <tr role="row">
                                            <th style="text-align:right" > اسم الحساب</th>
                                            @foreach($active_currencies as $curr)
                                            <th style="text-align:center" > رصيد {{$curr->name_ar}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($accounts_info != null)
                                            @foreach($accounts_info as $item)
                                                <tr>
                                                    <td style="text-align:right; padding-right:30px;">{{$item['account_name']}}</td>
                                                    @foreach($active_currencies as $curr)
                                                        <td>{{number_format($item['curr_balance_'.$curr->id],2)}}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                           
                                            
                                        @else
                                            <tr id="trTotal">
                                                <td colspan='{{count($active_currencies)+1}}' > لا توجد  نتائج</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
            
                    </div>         
               
    </div>       
    <!----- End table -------->
<!-- end show method is tables -->
@else 
<!-- start show method is Boxes -->
@php
    $main_accounts = [];
    foreach($active_currencies as $curr){
        $main_accounts[]= $curr->account_id;
    }
@endphp
    @if($accounts_info != null)
        @foreach($accounts_info as $item)
        @if(in_array($item['account_id'],$main_accounts))
            @php        
            $account_currency_info = DB::table('currencies')->where('account_id',$item['account_id'])->first();
            
            $icon = $account_currency_info->icon!=null?$account_currency_info->icon:'fa fa-money';
            $bg_color =  $account_currency_info->color!=null?'bg-'.$account_currency_info->color:'bg-red';
            $bal = 0;
            $bal = $item['curr_balance_'.$account_currency_info->id];
            $link = '/modules/reports99?account_id='.$item['account_id'].'&delegate_id=-1&from_date=&to_date=&currency_id='.$account_currency_info->id;
            @endphp
            <div class="col-md-{{12/$column_num}} col-sm-{{12/$column_num}} col-xs-12">
                <div class="border-box">
                    <div class="small-box {{$bg_color}}	">
                        <div class="inner inner-box">
                            <h3 id="final_SP_balance">   {{number_format($bal,2)}}	</h3>
                            <p>{{$item['account_name']}}</p>
                        </div>
                        <div class="icon">
                            <i class="{{$icon}}	"></i>
                        </div>
                        <a href="{{$link}}" class="small-box-footer">شاهد التفاصيل <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        @else
                <div class="col-sm-12">
                    <div class="box box-solid">
                                <div class="box-header with-border">
                                <i class="fa fa-text-width"></i>
                                <h3 class="box-title">{{$item['account_name']}}</h3>
                                </div>
                                <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            @foreach($active_currencies as $curr)
                                @php
                                $icon = $curr->icon!=null?$curr->icon:'fa fa-money';
                                $bg_color =  $curr->color!=null?'bg-'.$curr->color:'bg-red';
                                @endphp
                                <div class="col-md-{{12/$column_num}} col-sm-{{12/$column_num}} col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon {{$bg_color}}"><i class="{{$icon}}"></i></span>
                                    <div class="info-box-content">
                                    <span class="info-box-text">{{$curr->name_ar}}</span>
                                    <span class="info-box-number">{{number_format($item['curr_balance_'.$curr->id],2)}}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                </div>
            @endif
        @endforeach
    @endif

    <!-- end show method is Boxes -->
@endif

</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">

    </script>
@endsection
