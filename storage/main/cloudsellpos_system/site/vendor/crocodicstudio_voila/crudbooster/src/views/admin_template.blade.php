@php 
session_start();
if(!session()->has('admin_id')){
    return redirect()->route('getLogin');
}  
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ ($page_title)?config('setting.AppName').': '.strip_tags($page_title):config('setting.AppName') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name='generator' content='CRUDBooster 5.4.6'/>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon"
          href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('favicon.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="{{asset("vendor/crudbooster/assets/adminlte/font-awesome/css")}}/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="{{asset("vendor/crudbooster/ionic/css/ionicons.min.css")}}" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    @if (in_array(App::getLocale(), ['ar', 'fa']))
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/AdminLTE_rtl.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/skins/_all-skins_rtl.min.css")}}" rel="stylesheet" type="text/css"/>
    @else
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("vendor/crudbooster/assets/adminlte/dist/css/skins/_all-skins.min.css")}}" rel="stylesheet" type="text/css"/>
    @endif
   
    <!-- Print Style --->
    <link href="{{ asset("assets/css/print.css")}}" rel="stylesheet" type="text/css"/>
    <!-- support rtl-->

   @if (in_array(App::getLocale(), ['ar', 'fa']))
        <!-- <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css"> -->
        <link rel="stylesheet" href="{{ asset("vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap-rtl.min.css") }}">
        <link href="{{ asset("vendor/crudbooster/assets/rtl.css")}}" rel="stylesheet" type="text/css"/>
        <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/main_rtl.css").'?r='.time()}}'/>
    @else
        <link rel='stylesheet' href='{{asset("vendor/crudbooster/assets/css/main.css").'?r='.time()}}'/>    
    @endif

    <!-- include guide chimp -->
    <script  type="text/javascript" src="{{ asset("vendor/crudbooster/assets/adminlte/plugins/guide_chimp/dist/js/guidechimp.js") }}"></script>   
    <link rel="stylesheet" href="{{ asset("vendor/crudbooster/assets/adminlte/plugins/guide_chimp/dist/css/guidechimp_rtl.css") }}">
    
    <!-- include jquery toast -->  
    <link rel="stylesheet" href="{{ asset("vendor/crudbooster/assets/adminlte/plugins/jquery.toast/css/jquery.toast.css") }}">
  
    <!-- load css -->
    <style type="text/css">
        @if($style_css)
            {!! $style_css !!}
        @endif
    </style>
    @if($load_css)
        @foreach($load_css as $css)
            <link href="{{$css}}" rel="stylesheet" type="text/css"/>
        @endforeach
    @endif

    <style type="text/css">
        .dropdown-menu-action {
            left: -130%;
        }

        .btn-group-action .btn-action {
            cursor: default
        }

        #box-header-module {
            box-shadow: 10px 10px 10px #dddddd;
        }

        .sub-module-tab li {
            background: #F9F9F9;
            cursor: pointer;
        }

        .sub-module-tab li.active {
            background: #ffffff;
            box-shadow: 0px -5px 10px #cccccc
        }

        .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
            border: none;
        }

        .nav-tabs > li > a {
            border: none;
        }

        .breadcrumb {
            margin: 0 0 0 0;
            padding: 0 0 0 0;
        }

        .form-group > label:first-child {
            display: block
        }
        .loading{
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            text-align: center;
            opacity: 0.4;
            background-color: #222222;
            color:#fff;
            z-index: 9999999;
        }
        .loading i{
            display:table-cell;
            vertical-align: middle;

        }
    </style>

    @stack('head')
</head>

@if (!$display_current_cycle)
   @php
        $skin_cls = 'skin-black-light';    
   @endphp 
@else
    @php
    $skin_cls = (Session::get('theme_color'))?:'skin-blue';
    @endphp
@endif
<body class="@php echo $skin_cls; echo ' '; echo config('crudbooster.ADMIN_LAYOUT'); @endphp {{($sidebar_mode)?:''}}">
<div class="loading"><i class="fa fa-refresh fa-spin fa-3x fa-fw "></i></div>
<div id='app' class="wrapper">

    <!-- Header -->
@include('crudbooster::header')

<!-- Sidebar -->
@include('crudbooster::sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if(!$old_cycle_edited_status) <!-- start old cycle edited status = false -->

            @if($system_status == 'off') <!-- start system stop status if -->

                <section class="content-header">
                    <?php
                    $module = CRUDBooster::getCurrentModule();
                    ?>
                    @if($module)
                        <h1>
                            <i class='{{$module->icon}}'></i> {{($page_title)?:$module->name}} &nbsp;&nbsp;

                            <!--START BUTTON -->

                            @if(CRUDBooster::getCurrentMethod() == 'getIndex')
                                @if($button_show)
                                    <a href="{{ CRUDBooster::mainpath().'?'.http_build_query(Request::all()) }}" id='btn_show_data' class="btn btn-sm btn-primary"
                                    title="{{trans('crudbooster.action_show_data')}}">
                                        <i class="fa fa-table"></i> {{trans('crudbooster.action_show_data')}}
                                    </a>
                                @endif

                                @if($button_add && CRUDBooster::isCreate())
                                    <a href="{{ CRUDBooster::mainpath('add').'?return_url='.urlencode(Request::fullUrl()).'&parent_id='.g('parent_id').'&parent_field='.$parent_field }}"
                                    id='btn_add_new_data' class="btn btn-sm btn-success" title="{{trans('crudbooster.action_add_data')}}">
                                        <i class="fa fa-plus-circle"></i> {{trans('crudbooster.action_add_data')}}
                                    </a>
                                @endif
                            @endif


                            @if($button_export && CRUDBooster::getCurrentMethod() == 'getIndex')
                                <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='{{$build_query}}' title='Export Data'
                                class="btn btn-sm btn-primary btn-export-data">
                                    <i class="fa fa-upload"></i> {{trans("crudbooster.button_export")}}
                                </a>
                            @endif

                            @if($button_import && CRUDBooster::getCurrentMethod() == 'getIndex')
                                <a href="{{ CRUDBooster::mainpath('import-data') }}" id='btn_import_data' data-url-parameter='{{$build_query}}' title='Import Data'
                                class="btn btn-sm btn-primary btn-import-data">
                                    <i class="fa fa-download"></i> {{trans("crudbooster.button_import")}}
                                </a>
                            @endif

                        <!--ADD ACTIon-->
                            @if(!empty($index_button))

                                @foreach($index_button as $ib)
                                    <a href='{{$ib["url"]}}' id='{{str_slug($ib["label"])}}' class='btn {{($ib['color'])?'btn-'.$ib['color']:'btn-primary'}} btn-sm'
                                    @if($ib['onClick']) onClick='return {{$ib["onClick"]}}' @endif
                                    @if($ib['onMouseOver']) onMouseOver='return {{$ib["onMouseOver"]}}' @endif
                                    @if($ib['onMouseOut']) onMouseOut='return {{$ib["onMouseOut"]}}' @endif
                                    @if($ib['onKeyDown']) onKeyDown='return {{$ib["onKeyDown"]}}' @endif
                                    @if($ib['onLoad']) onLoad='return {{$ib["onLoad"]}}' @endif
                                    >
                                        <i class='{{$ib["icon"]}}'></i> {{$ib["label"]}}
                                    </a>
                            @endforeach
                        @endif
                        <!-- END BUTTON -->
                        </h1>


                        <ol class="breadcrumb">
                            <li><a href="{{CRUDBooster::adminPath()}}"><i class="fa fa-dashboard"></i> {{ trans('crudbooster.home') }}</a></li>
                            <li class="active">{{$module->name}}</li>
                        </ol>
                    @else
                        <!-- h1>{{Session::get('appname')}}
                            <small>Information </small>
                        </h1 -->
                    @endif
                </section>


                <!-- Main content -->
                <section id='content_section' class="content">

                    @if(@$alerts)
                        @foreach(@$alerts as $alert)
                            <div class='callout callout-{{$alert["type"]}}'>
                                {!! $alert['message'] !!}
                            </div>
                        @endforeach
                    @endif


                    @if (Session::get('message')!='')
                        <div class='alert alert-{{ Session::get("message_type") }}'>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> {{ trans("crudbooster.alert_".Session::get("message_type")) }}</h4>
                            {!!Session::get('message')!!}
                        </div>
                        @php
                            Session::forget('message');
                            Session::forget('message_type');
                        @endphp
                    @endif



                <!-- Your Page Content Here -->
                    @yield('content')
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Footer -->
            @include('crudbooster::footer')

            @else  <!-- system stop status is on -->
            <section id='content_section' class="content">
                <div class='callout callout-warning'>
                    <h4><i class="icon fa fa-ban"></i> {{trans('labels.temp_stop')}} </h4>
                    {{trans('labels.temp_stop_message')}} 
                    <a class="btn btn-xs btn-success" href="" alt="refresh" >  {{trans('crudbooster.action_show_data')}} </a>
                </div>
            </section>
            @endif <!-- end system stop status if -->
            @if(!$display_current_cycle)
                <div class="display_old_cycle">
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa-history"></i> {{trans('labels.now_display_old_cycle')}}</h4>
                        <h6>{{Session::get('display_cycle_name')}}</h6>
                        <p>{{trans('labels.to_go_back_to_current_cycle_click_here')}} <a href='{{route('goBackToCurrentCycle')}}'>{{trans('labels.click_here')}}.</a></p>
                    </div>
                </div>
            @endif    
        
        @else  <!-- else old cycle edited status == true -->
            @include('crudbooster::recalculate_form') <!-- after edit old cycle -->
        @endif <!-- end if old cycle edited status -->

</div><!-- ./wrapper -->


@include('crudbooster::admin_template_plugins')

<!-- load js -->
@if($load_js)
    @foreach($load_js as $js)
        <script src="{{$js}}"></script>
    @endforeach
@endif
<script type="text/javascript">
    var site_url = "{{url('/')}}";
    @if($script_js)
        {!! $script_js !!}
    @endif


    $('body').on('click',function(){
        $(".alert").fadeOut(700);
    });

    // $("#table_dashboard th:not(:first-child)").css("width","7%");
</script>

@stack('bottom')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

<script type="text/javascript" src="{{asset('assets/js/shortcut.js')}}"></script>      
<script type="text/javascript" src="{{asset('assets/js/shortcuts-functions.js')}}"></script>

<script type="text/javascript">
    //show loading
    $(window).bind('beforeunload', function() {
            $('.loading').css("display", "table");
    });
    //check if there are ajax request
    $(function() {
        window.ajax_loading = false;
        $.hasAjaxRunning = function() {
            return window.ajax_loading;
        };
        $(document).ajaxStart(function() {
            window.ajax_loading = true;
            $('#form input[type=submit]').attr('disabled','true');
        });
        $(document).ajaxStop(function() {
            window.ajax_loading = false;
            $('#form input[type=submit]').prop('disabled', false);
        });
    });

    if($("#btn-back").length){
        var submit_clicked = false;
        $('#btn-save-data').click(function(){
            submit_clicked = true; 
        });
        $('#btn-save-more').click(function(){
            submit_clicked = true; 
        });
        window.onbeforeunload = function closeEditorWarning () {
            /** Check to see if the settings warning is displayed */
            if(submit_clicked === false) {
                bol_option_changed = true;
            }
            /** Display a warning if the user is trying to leave the page with unsaved settings */
            if(bol_option_changed === true){
                $('.loading').css("display", "none");
                return '';
            }
        };
    }
</script>

<!-- include jquery toast -->  
<script  type="text/javascript" src="{{ asset("vendor/crudbooster/assets/adminlte/plugins/jquery.toast/js/jquery.toast.js") }}"></script> 

<script type="text/javascript" src="{{asset('assets/js/general_script.js')}}"></script> 

@include('crudbooster::admin_template_tour')
</body>
</html>
