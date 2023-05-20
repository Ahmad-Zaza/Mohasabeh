@extends('crudbooster::admin_template')
@section('title', 'Translation ') @section('content')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <link href="{{ asset('css/treeview.css') }}" rel="stylesheet">
    
  

</head>

<body>

<div class="container">
    @if($table_name == 'accounts')
    <div class="col-sm-1" style="padding-left:0px;">
    </div>
    <div class="col-sm-11" style="padding-left:0px;">
      <div class="callout callout-info">
          <p class="">  تنبيه1 : إن اردت إنشاء حساب زبون أو مورد اذهب إلى صفحة <a href="/modules/persons" class="btn btn-success" style="text-decoration:none;"> الموردون والزبائن</a>  . لا حاجة لبناء حساب مسبق النظام يقوم ببناء الحساب الخاص بالمورد أو الزبون المضاف  .</p>
          <p class="">  تنبيه2 : إن اردت إنشاء حساب مندوب اذهب إلى صفحة <a href="/modules/users" class="btn btn-success" style="text-decoration:none;"> إدارة المستخدمين</a>  . لا حاجة لبناء حساب مسبق، النظام يقوم ببناء الحساب الخاص بالمندوب  .</p>
      </div>
    </div>
  
    @endif
    <div class="">
    <div class="col-md-12">
      <a class="btn btn-primary" href="{{url('modules/'.$table_name.'/add')}}"><i class="fa fa-plus-circle"></i> {{trans('crudbooster.action_add_data')}}</a>
      @if(count($itemCategories) == 0 && ($table_name != 'inventories'))
        <a class="btn btn-info" href="{{url('modules/'.$table_name.'/import-data-form')}}"><i class="fa fa-download"></i> استيراد البيانات</a>
      @endif
    </div>
        <div class="panel-body">

            <div class="row">

                <div class="col-md-12">

                @php
                      $Main_Accounts_ids_str = DB::table('system_config')->where('config_key','Main_Accounts_ids')->first()->config_value;
                      
                      $main_accounts = explode(',',$Main_Accounts_ids_str);
                      $activeCurrencies = DB::table('currencies')->where('active',1)->get();
                      foreach($activeCurrencies as $curr){
                        $main_accounts[] = $curr->account_id;
                      } 
                @endphp
                    <ul id="tree1" class="list-group">
                       
                        @foreach($itemCategories as $category)

                            <li class="list-group-item {{$category->major_classification==0 ? 'item-child':''}}">
                            <p style="display:inline;">{{ $category->name_ar }} ({{count($category->childs)}}) / {{$category->code}}</p>

                            

                            @if(CRUDBooster::isDelete() && ($table_name == 'accounts' || $table_name == 'inventories' || $table_name == 'item_categories'))
                              
                              @if($table_name == 'accounts' && in_array($category->id,$main_accounts))

                              @else
                               <a  class="click-cat btn btn-warning btn-sm float_lft btn-delete" href="javascript:void(0)"  data-href="{{url('modules/'.$table_name.'/delete/'.$category->id)}}">{{trans('crudbooster.Delete')}}</a> 
                              @endif
                             
                             
                            @endif
                           
                            
                            @if(CRUDBooster::isUpdate())
                              @if(CRUDBooster::isSuperAdmin() || (!CRUDBooster::isSuperAdmin() && $category->major_classification ==0))
                                <a  class="click-cat btn btn-primary btn-sm float_lft" href="{{url('modules/'.$table_name.'/edit/'.$category->id)}}">{{trans('crudbooster.Edit')}}</a> 
                              @endif
                            @endif


                            @include('itemCategories.manageChild',['childs' => $category->childs->sortBy('code')])


                            </li>
                          

                        @endforeach

                    </ul>

                </div>

                


    </div>

</div>

<script type="text/javascript">
    $('.btn-delete').on('click', function (e) {
      $url = $(this).data('href');
      console.log($url);
      swal({
                title: 'هل أنت متأكد؟',
                text: "لا يمكنك التراجع عن عملية الحذف !",
                type:'info',
                showCancelButton:true,
                allowOutsideClick:true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'نعم',
                cancelButtonText: 'لا',
                closeOnConfirm: false
                }, function(){
                   
                    swal.close();
                    location.href = $url;
                }
                
            );  
    });
</script>

<script src="{{ asset('js/treeview.js') }}"></script>


@if($table_name == 'accounts')
<script type="text/javascript">
  $(document).ready(function(){
    $('#tree1 > li > i').click();
  });
</script>
@endif

@if(!CRUDBooster::isSuperAdmin())
<script type="text/javascript">
  $(document).ready(function(){
    $('#tree1 > li > i').addClass('hidden');
  });
</script>
@endif

<script>

function getToSort(parent_id) {

    $.get("/modules/getToSort/"+parent_id, function(data){        
            $(".append-tbody").empty();
            data.data.forEach(element => {
                $(".append-tbody").append(`
                
                    <tr class="row1" data-id="`+element.id+`" parent-id="`+element.parent_id+`">
                        <td class="pl-3"><img src="`+element.image+`" class="img-responsive img-thumbnail" style="width:40x;height:40px;display:inline">
                        </td>
                        <td>`+element.name_ar+`</td>

                    </tr>
                
                `);

            });

    });
}

</script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript">
      $(function () {

        $( ".append-tbody" ).sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

        function sendOrderToServer() {
          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');
          var parent_id=-1;
          $('tr.row1').each(function(index,element) {
            order.push({
              id: $(this).attr('data-id'),
              position: index+1
              
            });
            parent_id=$(this).attr('parent-id');
          });

          var data_request={
              order: order,
              _token: token,
              parent_id:parent_id
            };

          $.ajax({
            type: "POST", 
            dataType: "json", 
            url: "{{ url('post-sortable') }}",
            data: data_request,
            success: function(response) {
                if (response.status == "success") {
                  console.log(response);
                } else {
                  console.log(response);
                }
            }
          });
        }
      });
    </script>

@endsection