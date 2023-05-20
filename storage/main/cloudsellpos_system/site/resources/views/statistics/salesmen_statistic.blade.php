@extends('crudbooster::admin_template')
@section('content')
@php
    //fix data to show it
    $curr_balances=array();
    foreach($active_currencies as $curr){
        $curr_balances['curr_balance_'.$curr->id]=0;	
    }

    foreach($salesman_balance as $bal){
        $curr_balances['curr_balance_'.$bal->currency_id]=$bal->curr_balance;	
    }
@endphp
<div class='row'>
    <div class="col-sm-12">
        <h3>   صندوق المندوب  </h3>
        <hr style="border:1px solid white;"/>
    </div>
    @foreach($active_currencies as $curr)
        @php
            $bg_colors_array = ['bg-red','bg-yellow'];
            $rand_key = array_rand($bg_colors_array, 1);
            $bg_color = $bg_colors_array[$rand_key];

            switch($curr->id){
                case 2: $icon = 'ion-social-usd'; $bg_color='bg-green';  break;
                case 3: $icon = 'ion-social-euro'; $bg_color='bg-aqua'; break;
                default: $icon = 'ion-bag';
            }
            $column_num = count($active_currencies);
            if(count($active_currencies) > 6){
                $column_num = 3;
            }
        @endphp
        <div class="col-md-{{12/$column_num}} col-sm-{{12/$column_num}} col-xs-12"  >
            <div class="border-box">
                <div class="small-box {{$bg_color}}">
                    <div class="inner inner-box">
                        <h3 id="final_SP_balance"> {{number_format($curr_balances['curr_balance_'.$curr->id],2)}}	</h3>
                        <p> {{$curr->name_ar}}	</p>
                    </div>
                    <div class="icon">
                        <i class="ion {{$icon}}	"></i>
                    </div>
                    <a href="/modules/reports99?account_id=<?=$salesman_account_id?>&currency_id={{$curr->id}}" class="small-box-footer">شاهد التفاصيل <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    @endforeach
    
</div>
<div class='row'>
    <div class="col-sm-12">
        <h3> أرصدة الزبائن  </h3>
        <hr style="border:1px solid white;"/>
    </div>
    <!----- start Table ------>
    <div class="col-sm-12">

                    <div id="form-table" class="dataTables_wrapper form-inline dt-bootstrap">
                                
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable text-center" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="text-align:right" > اسم الحساب</th>
                                        @foreach($active_currencies as $curr)
                                            <th style="text-align:center" > رصيد {{$curr->name_ar}}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($customers_balances != null)
                                        @foreach($customers_balances as $item)
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
    <!----- End table -------->

</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">


    </script>
@endsection
