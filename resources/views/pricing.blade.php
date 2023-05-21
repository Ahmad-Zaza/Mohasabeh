@extends('layouts.app')
@php $_left = ($lang=="ar"?"right":"left")@endphp
@section('content')
<link rel="stylesheet" href="{{ asset('css/pricing.css') }}" />
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
                        @foreach ($packages as $pkg)
                        <div class="col col-small-4 plan-team top-half">
                            <div class="product-card product-card-primary">
                                <div class="card-hero">
                                    <h3 class="katamari-field center product-title" data-katamari-field-id="8">
                                        {{ $pkg["title_$lang"] }}
                                    </h3>
                                    <input type="hidden" name="package_id" value={{$pk->id}} class="type">
                                    <div class="price-lockup">
                                        <p class="price" style="text-align: center;">
                                            <span class="katamari-field agent" data-katamari-field-id="11">{{ $pkg["description_$lang"] }}</span>
                                        </p>
                                        <div class="form-group">
                                            <input type="hidden" name="subscription_type" value="month" />
                                            <input type="hidden" name="sys_lang" value="ar">
                                            <select class="form-control subscription_ttype" name="subscription_type_{{ $pkg->id }}" pack_id="{{ $pkg->id }}">
                                                <option value="month-{{ $pkg['monthly_price'] }}" selected> {{ __('data.monthly_pricing') }}</option>
                                                <option value="six_month-{{ $pkg['six_month_price'] }}"> {{ __('data.six_month_pricing') }}</option>
                                                <option value="year-{{ $pkg['year_price'] }}"> {{ __('data.yearly_pricing') }}</option>
                                            </select>
                                        </div>
                                        <p class="price" style="text-align: center;">
                                            <span class="katamari-field amount text-center" data-pricingplan="team" data-katamari-field-id="10" style="font-size:26px;font-style: italic" id="dy_amnt_pkg_{{ $pkg->id }}"><strong>${{ $pkg['monthly_price'] }}</strong></span>
                                        </p>
                                    </div>
                                    <div class="product-ctas">

                                        <a type="button" class="request_now text-white js-product-buy-now button button-medium button-primary button-default" style="width:100%;">{{ __('data.free_trial') }}</a>
                                    </div>
                                </div>

                            </div>
                            <div class="product-card product-card-primary">
                                @foreach ($pkg->price_pkg_main_options as $item)
                                <div class="pb-1 nowrap text-{{ $_left }}" style="padding-{{ $_left }}:10px;">
                                    <div class="form-holder"><strong class="mr-1">{{ $item['value'] }}</strong>
                                        {{ $item["name_$lang"] }}
                                    </div>
                                </div>
                                @endforeach
                                <ul class="feature-list">
                                    @php $reports=$pkg->price_pkg_mult_options(); @endphp
                                    @foreach ($reports as $item)
                                    <li class="katamari-field  text-{{ $_left }}" data-katamari-field-id="35" data-katamari-field-type="html">
                                        <div style="float:{{ $_left }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27">
                                                <g id="Group_2743" data-name="Group 2743" transform="translate(-319 -730)">
                                                    <circle id="Ellipse_1" data-name="Ellipse 1" cx="13.5" cy="13.5" r="13.5" transform="translate(319 730)" fill="#fff" />
                                                    <path id="Icon_awesome-check" data-name="Icon awesome-check" d="M5.926,17.333.256,11.663a.872.872,0,0,1,0-1.234L1.489,9.195a.872.872,0,0,1,1.234,0l3.82,3.82,8.182-8.182a.872.872,0,0,1,1.234,0l1.234,1.234a.872.872,0,0,1,0,1.234L7.16,17.334A.872.872,0,0,1,5.926,17.333Z" transform="translate(323.874 732.923)" fill="var(--third-color)" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div>
                                            {{ $item["title_$lang"] }}
                                            <span class="tooltip">
                                                <span class="tooltip-content tooltip-content-{{ $_left }}">
                                                    {{ $item["title_$lang"] }}
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.subscribe_now').click(function() {
            //render in show modal
            try {
                grecaptcha.getResponse(subscribedRecaptcha);
            } catch (error) {
                subscribedRecaptcha = grecaptcha.render('subscribedRecaptcha', {
                    'sitekey': '{{ config('
                    app.recaptcha_site_key ')}}'
                });
            }

            let title = "{{__('data.subscribe')}}";
            $('#subscribeModal').find(".modal-header").html(title + " (" + $(this).attr("package_name") + ")");
            $('#subscribeModal').find("[name='package_id']").val($(this).attr("package_id"));
            $('#subscribeModal').modal('show');
            let items = ``;
            $(".module:checked").each(function() {
                items += `<div class="flex">
                            <span class="span-check text-main"></span>
                            ` + $(this).siblings(".form-check-label").html() + `</div>`;
            });
            $('#subscribeModal').find('.grid-container').html(items);
        });
    })

</script>
@endsection