@extends('crudbooster::admin_template')
@section('title', 'Translation ') @section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link href="{{ asset('css/treeview.css') }}" rel="stylesheet">

</head>

<body>
    @php
        use App\Http\Controllers\General\GeneralFunctionsController;
        $gfunc = new GeneralFunctionsController();
        $hasPermission = $gfunc->checkOldCycleHasEditedPermission();
    @endphp 
    <div class="container">
        @if ($table_name == 'accounts'  && CRUDBooster::isCreate() == true && $hasPermission)
            <div class="col-sm-1" style="padding-left:0px;">
            </div>
            <div class="col-sm-11" style="padding-left:0px;">
                <div class="callout callout-info" id="massege-info">
                    <p class=""> {{trans('labels.go_to_page_to_create_customer_or_supplier')}}<a href="/modules/persons"
                            class="btn btn-xs btn-success" style="text-decoration:none;"> {{trans('labels.customers')}}</a> {{trans('labels.or')}} <a
                            href="/modules/suppliers" class="btn btn-xs btn-success" style="text-decoration:none;">
                            {{trans('labels.suppliers')}}</a> {{trans('labels.system_generate_accounts')}}</p>
                    <p class=""> {{trans('labels.go_to_page_to_create_users')}}<a href="/modules/users"
                            class="btn btn-xs btn-success" style="text-decoration:none;"> {{trans('labels.users_management')}}</a> 
                        {{trans('labels.system_generate_user_account')}}
                        </p>
                </div>
            </div>
        @endif
        <div class="">
            <div class="col-md-12">
                @if (CRUDBooster::isCreate() && $hasPermission &&
                    ($table_name == 'accounts' || $table_name == 'inventories' || $table_name == 'item_categories'))
                    <a class="btn btn-sm btn-success" id="btn_add_new_data"
                        href="{{ url('modules/' . $table_name . '/add') }}"><i class="fa fa-plus-circle"></i>
                        {{ trans('crudbooster.action_add_data') }}</a>
                @endif
                @if ($table_name != 'inventories' && $table_name != 'accounts' && CRUDBooster::isSuperAdmin() && $hasPermission)
                    <a class="btn btn-sm btn-primary" href="{{ url('modules/' . $table_name . '/import-data-form') }}"
                        id="btn-import-data"><i class="fa fa-download"></i> {{trans('labels.import_data')}}</a>
                @endif
            </div>
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-12">

                        @php
                            $Main_Accounts_ids_str = DB::table('system_config')
                                ->where('config_key', 'Main_Accounts_ids')
                                ->first()->config_value;
                            
                            $main_accounts = explode(',', $Main_Accounts_ids_str);
                            $activeCurrencies = DB::table('currencies')
                                ->where('active', 1)
                                ->get();
                            foreach ($activeCurrencies as $curr) {
                                $main_accounts[] = $curr->account_id;
                            }
                        @endphp
                        <ul id="tree1" class="list-group">

                            @foreach ($itemCategories as $category)
                                <li class="list-group-item {{ $category->major_classification == 0 ? 'item-child' : '' }}">
                                    <p style="display:inline;">{{ $category->name_ar }} ({{ count($category->childs) }})
                                        / {{ $category->code }}</p>


                                    <div class="button_action float_lft" style="display:inline-block">
                                        @if (CRUDBooster::isDelete() && $hasPermission &&
                                            ($table_name == 'accounts' || $table_name == 'inventories' || $table_name == 'item_categories'))
                                            @if ($table_name == 'accounts' && in_array($category->id, $main_accounts))
                                            @else
                                                <a class="click-cat btn btn-warning btn-xs float_lft btn-delete"
                                                    href="javascript:void(0)"
                                                    data-href="{{ url('modules/' . $table_name . '/delete/' . $category->id) }}">
                                                    <span class="fa fa-trash"></span> </a>
                                            @endif
                                        @endif


                                        @if (CRUDBooster::isUpdate() && $hasPermission)
                                            @if (CRUDBooster::isSuperAdmin() || (!CRUDBooster::isSuperAdmin() && $category->major_classification == 0))
                                                <a class="click-cat btn btn-success btn-xs float_lft"
                                                    href="{{ url('modules/' . $table_name . '/edit/' . $category->id) }}">
                                                    <span class="fa fa-pencil"></span></a>
                                            @endif
                                        @endif
                                        @if (CRUDBooster::isRead())
                                            <a class="click-cat btn btn-primary btn-xs float_lft btn-detail"
                                                href="{{ url('modules/' . $table_name . '/detail/' . $category->id) }}">
                                                <span class="fa fa-eye"></span></a>
                                        @endif
                                    </div>

                                    @include('itemCategories.manageChild', [
                                        'childs' => $category->childs->sortBy('code'),'hasPermission' => $hasPermission
                                    ])


                                </li>
                            @endforeach

                        </ul>

                    </div>




                </div>

            </div>                            
            <script type="text/javascript">
                $('.btn-delete').on('click', function(e) {
                    $url = $(this).data('href');
                    var id = $(this).data('id');

                    var i=$(this).children(".fa");
                    i.removeClass("fa-trash");
                    i.addClass("fa-spinner fa-spin");
                    $.get("/checkBeforeDelete/{{CRUDBooster::getCurrentModule()->path}}/"+id, function(res) {
                        let json_res = JSON.parse(res);
                        let text_msg = json_res.massege;
                        
                        swal({
                                title: "{{trans('crudbooster.delete_title_confirm')}}",
                                text: text_msg,
                                type: 'warning',
                                showCancelButton: true,
                                allowOutsideClick: true,
                                confirmButtonColor: '#DD6B55',
                                confirmButtonText: "{{trans('crudbooster.confirmation_yes')}}",
                                cancelButtonText: "{{trans('crudbooster.confirmation_no')}}",
                                closeOnConfirm: false
                            }, function() {

                                swal.close();
                                location.href = $url;
                            }

                        );
                        i.removeClass("fa-spinner fa-spin");
                        i.addClass("fa-trash");
                    });
                });
            </script>

            <script src="{{ asset('js/treeview.js') }}"></script>

            <script type="text/javascript">
                $('#tree1  li  a.float_lft span').css('display', 'inline-block');
            </script>

            @if ($table_name == 'accounts')
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#tree1 > li > i').click();
                    });
                </script>
            @endif

            @if (!CRUDBooster::isSuperAdmin())
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#tree1 > li > i').addClass('hidden');
                        $('.button_action a').css('display', 'block');
                    });
                </script>
            @endif

            <script>
                function getToSort(parent_id) {

                    $.get("/modules/getToSort/" + parent_id, function(data) {
                        $(".append-tbody").empty();
                        data.data.forEach(element => {
                            $(".append-tbody").append(`
                
                    <tr class="row1" data-id="` + element.id + `" parent-id="` + element.parent_id + `">
                        <td class="pl-3"><img src="` + element.image + `" class="img-responsive img-thumbnail" style="width:40x;height:40px;display:inline">
                        </td>
                        <td>` + element.name_ar + `</td>

                    </tr>
                
                `);

                        });

                    });
                }
            </script>

            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
            <script type="text/javascript">
                $(function() {

                    $(".append-tbody").sortable({
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
                        var parent_id = -1;
                        $('tr.row1').each(function(index, element) {
                            order.push({
                                id: $(this).attr('data-id'),
                                position: index + 1

                            });
                            parent_id = $(this).attr('parent-id');
                        });

                        var data_request = {
                            order: order,
                            _token: token,
                            parent_id: parent_id
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
