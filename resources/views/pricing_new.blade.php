@extends('layouts.app')
@php $_left = ($lang=="ar"?"right":"left")@endphp
@section('content')
    <style>
        .feature-list {
            list-style: none;
            padding: 0;
            margin-top:20px !important;
            margin-left: 0 !important;
            margin-right:0 !important;
        }

        .feature-list li {
            margin-bottom: 0;
            padding: .5rem 1.5rem;
            border-top: 1px solid #c2c8cc;
            transition: background-color .25s;
            position: relative;
            padding-right: 0;
            padding-left: 0;
        }

        .top-half .product-card {
            border-bottom: none;
        }

        .product-card .card-hero {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            padding: 1.5rem;
            height: 100%;
        }

        .bottom-half {
            -ms-flex-order: 1;
            order: 1;
        }

        .bottom-half .product-card {
            border-top: none;
            height: auto;
        }

        .product-card {
            background: #fff;
            box-shadow: 0 4px 12px 0 rgba(104, 115, 125, .15);
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            position: relative;
            text-align: {{$_left}};
            transition: box-shadow .25s;
            height: 100%;
            padding-left: 30px;
            padding-right: 30px;
        }

        .product-card .product-ctas {
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: start;
            justify-content: flex-start;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        @media only screen and (min-width: 768px) {
            .grid .col.col-small-4 {
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: 33.3333333333%;
            }
        }

        .p-pricing-landing .row-product-cards {
            -ms-flex-pack: center;
            justify-content: center;
        }

        .p-pricing-landing .product-card .card-hero {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            padding: 1.5rem;
            height: 100%;
        }

        @media only screen and (min-width: 768px) {
            .p-pricing-landing .product-card .product-title {
                font-size: 2rem;
                text-align: center;
            }
        }

        .p-pricing-landing .product-card .price-lockup {
            margin: auto;
        }

        .p-pricing-landing .product-card .product-ctas {
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: start;
            justify-content: flex-start;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        @media only screen and (min-width: 768px) {
            .grid .col.col-small-4 {
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                width: 33.3333333333%;
            }
        }

        .p-pricing-landing .top-half {
            padding-bottom: 0;
        }

        .grid .col {
            position: relative;
            padding: 8px;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            width: 100%;
            -ms-flex-pack: start;
            justify-content: flex-start;
        }

        .p-pricing-landing .top-half {
            padding-bottom: 0;
        }

        .p-pricing-landing .product-card .product-title {
            font-size: 1.5rem;
            margin: 0 0 .75rem;
            font-weight:bold;
        }

        .p-pricing-landing .product-card .product-ctas .button, .p-pricing-landing .product-card .product-ctas .subdomain-cta {
            width: 100%;
        }

        .p-pricing-landing .product-card .product-ctas > * {
            margin-top: 1rem;
        }

        .link-small, .link-medium, .link-large, .link-video, .anchor-small, .anchor-medium, .anchor-large, .anchor-video {
            display: inline-block;
            font-family: sharp sans, Arial, sans-serif;
            font-weight: 600;
            line-height: 1.5em;
            text-decoration: none;
        }

        .link, .anchor {
            cursor: pointer;
            font-size: inherit;
            width: auto;
            text-decoration: underline;
            display: inline;
            transition: all .25s;
        }

        .button.button-medium, a.button.button-medium, input.button.button-medium, button.button.button-medium {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .button, a.button, input.button, button.button {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            background-color: #3c576c;
            border-radius: 0;
            border: 2px solid #334c5f;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font: 600 1rem/1.25em "Sharp Sans", Arial, sans-serif;
            margin: 0;
            min-width: 8rem;
            padding: .5rem 1.5rem;
            text-align: center;
            text-decoration: none;
            transition: background-color .25s, border .25s, color .25s;
            width: 100%;
        }

        .link, .anchor {

            cursor: pointer;
            font-size: inherit;
            width: auto;
            text-decoration: underline;
            display: inline;
            transition: all .25s;
        }

        .button.button-arrow:after, a.button.button-arrow:after, input.button.button-arrow:after, button.button.button-arrow:after, .link-arrow:after, .anchor-arrow:after, .icon-arrow-small-right::before {
            content: "\f301";font-family: Material-Design-Iconic-Font;
            display: none;
        }
        .link-arrow:after, .anchor-arrow:after {
            font-family: Material-Design-Iconic-Font;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
        }
        .link-small, .link-medium, .link-large, .link-video, .anchor-small, .anchor-medium, .anchor-large, .anchor-video {
            display: inline-block;
            font-family: sharp sans,Arial,sans-serif;
            font-weight: 600;
            line-height: 1.5em;
            text-decoration: none;
        }
        .link-small span, .link-medium span, .link-large span, .link-video span, .anchor-small span, .anchor-medium span, .anchor-large span, .anchor-video span {
            border-bottom: 2px solid #3c576c;
            transition: all .25s;
        }
        .link-arrow::after, .anchor-arrow::after {
            font-size: 1.75rem;
            margin-{{$_left}}: .125rem;
            position: relative;
            top: .3125rem;
            left: 0;
            transition: {{$_left}} .25s;
        }
        strong{
            font-weight: bold;
        }
        ul li.katamari-field:hover{
            /*background-color: #eee;*/
            cursor: pointer;
        }
        .form-control:focus,select.form-control{
            color: #333 !important;
        }
    </style>
    {{--    <link rel="stylesheet" href="https://web-assets.zendesk.com/css/p-pricing-landing.min.1962fa45.css"/>--}}
    <div id="pricing" class="pricing-section p-pricing-landing text-center" style="margin-top:100px;margin-bottom:100px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="pricing-intro" data-aos="fade-up" data-aos-delay="200">
                        <h1>{{ $section["title_$lang"] }}</h1>
                        <p>{{ $section["sub_title_$lang"] }}</p>
                    </div>
                    <div class=" grid" style="display: flex">
                        <div class="row row-product-cards">
                            @foreach($packages as $pkg)
                                <div class="col col-small-4 plan-team top-half">
                                    <div class="product-card product-card-primary">
                                        <div class="card-hero">
                                            <h3 class="katamari-field center product-title" data-katamari-field-id="8">
                                                {{$pkg["title_$lang"]}}</h3>

                                            <div class="price-lockup">
                                                <p class="price" style="text-align: center;">
                                                    <span class="katamari-field agent" data-katamari-field-id="11">{{$pkg["description_$lang"]}}</span>
                                                </p>
                                                <div class="form-group">
                                                    <input type="hidden" name="subscription_type" value="month" />
                                                    <input type="hidden" name="sys_lang" value="ar">
                                                <select class="form-control subscription_ttype" name="subscription_type_{{$pkg->id}}" pack_id="{{$pkg->id}}">
                                                    <option value="month-{{$pkg["monthly_price"]}}" selected>Monthly Pricing</option>
                                                    <option value="six_month-{{$pkg["six_month_price"]}}">Six Month Pricing</option>
                                                    <option value="year-{{$pkg["year_price"]}}">Yearly</option>
                                                </select>
                                                </div>
                                                <p class="price" style="text-align: center;">
                                                    <span class="katamari-field amount text-center" data-pricingplan="team"
                                                          data-katamari-field-id="10" style="font-size:26px;font-style: italic" id="dy_amnt_pkg_{{$pkg->id}}"><strong>${{$pkg["monthly_price"]}}</strong></span>
                                                </p>
                                            </div>
                                            <div class="product-ctas">
                                                <a href="javascript:void(0)"
                                                   class="js-product-buy-now button button-medium button-primary button-default request_now"
                                                   data-product="Suite" target="" style="width:100%;" package_id="{{$pkg->id}}">{{ __('data.requestADemo') }}</a>
                                                <a href="javascript:void(0)"
                                                   class="link-arrow js-product-free-trial link link-medium request_trial free_trial"
                                                   data-product="Suite" target=""><span style=" color: #3c576c;" package_id="{{$pkg->id}}">{{ __('data.free_trial') }}</span></a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="product-card product-card-primary">
                                        @foreach($pkg->price_pkg_main_options as $item)
                                        <div class="pb-1 nowrap text-{{$_left}}" style="padding-{{$_left}}:10px;">
                                            <div class="form-holder"><strong class="mr-1">{{$item["value"]}}</strong>
                                                {{$item["name_$lang"]}}</div>
                                        </div>
                                        @endforeach
                                        <ul class="feature-list">
                                            @php $reports=$pkg->price_pkg_mult_options(); @endphp
                                            @foreach($reports as $item)
                                                <li class="katamari-field  text-{{ $_left }}"
                                                    data-katamari-field-id="35"
                                                    data-katamari-field-type="html">
                                                    <div style="float:{{$_left}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27"
                                                         viewBox="0 0 27 27">
                                                        <g id="Group_2743" data-name="Group 2743"
                                                           transform="translate(-319 -730)">
                                                            <circle id="Ellipse_1" data-name="Ellipse 1" cx="13.5" cy="13.5"
                                                                    r="13.5" transform="translate(319 730)" fill="#fff"/>
                                                            <path id="Icon_awesome-check" data-name="Icon awesome-check"
                                                                  d="M5.926,17.333.256,11.663a.872.872,0,0,1,0-1.234L1.489,9.195a.872.872,0,0,1,1.234,0l3.82,3.82,8.182-8.182a.872.872,0,0,1,1.234,0l1.234,1.234a.872.872,0,0,1,0,1.234L7.16,17.334A.872.872,0,0,1,5.926,17.333Z"
                                                                  transform="translate(323.874 732.923)" fill="#ce7a26"/>
                                                        </g>
                                                    </svg>
                                                    </div>
                                                    <div>
                                                    {{$item["title_$lang"] }}
                                                    <span class="tooltip">
                                                      <span class="tooltip-content tooltip-content-{{$_left}}">
                                                     {{$item["title_$lang"] }}
                                                    </span>
                                                  </span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{--                        @foreach($packages as $pkg)--}}
                        {{--                            <div class="col-md-3" data-aos="fade-right" data-aos-delay="200">--}}
                        {{--                                <div class="table-left">--}}
                        {{--                                    <h3>{{ $pkg["title_$lang"] }}</h3>--}}
                        {{--                                    <p>{{ $pkg["description_$lang"] }}</p>--}}
                        {{--                                    <div class="pricing-details pt-5">--}}
                        {{--                                        <span>{{  $pkg["price"] }}</span>--}}
                        {{--                                    </div>--}}
                        {{--                                    @foreach($pkg->price_pkg_main_options as $item)--}}
                        {{--                                    <div class="pb-1 nowrap text-{{ $_left }}">--}}
                        {{--                                        <div class="form-holder"><strong class="mr-1">{{ $item["value"]  }}</strong>--}}
                        {{--                                            {{ $item["name_$lang"]  }}</div>--}}
                        {{--                                    </div>--}}
                        {{--                                    @endforeach--}}
                        {{--                                        @php $reports=$pkg->price_pkg_mult_options(); @endphp--}}
                        {{--                                    <ul class="feature-list">--}}
                        {{--                                    @foreach($reports as $item)--}}
                        {{--                                        <li class="katamari-field  text-{{ $_left }}" data-katamari-field-id="35" data-katamari-field-type="html"> {{$item["title_$lang"] }}--}}
                        {{--                                            <span class="tooltip">--}}
                        {{--                                                <span class="tooltip-content tooltip-content-left">--}}
                        {{--                                                  {{$item["title_$lang"] }}--}}
                        {{--                                                </span>--}}
                        {{--                                            </span>--}}
                        {{--                                        </li>--}}
                        {{--                                    @endforeach--}}
                        {{--                                    </ul>--}}
                        {{--                                    <button class="btn btn-primary btn-action request_now"--}}
                        {{--                                            type="button">{{ __('data.get_started') }}</button>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        @endforeach--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('.subscribe_now').click(function () {
                $('#subscribeModal').modal('show');
                let items = ``;
                $(".module:checked").each(function () {
                    items += `<div class="flex">
                            <span class="span-check text-main"></span>
                            ` + $(this).siblings(".form-check-label").html() + `</div>`;
                });
                $('#subscribeModal').find('.grid-container').html(items);
            });
        })
    </script>
@endsection