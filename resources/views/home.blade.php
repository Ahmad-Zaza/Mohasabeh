aa@extends('layouts.app')

@section('content')
    @php $_right = ($lang=="ar"?"left":"right")@endphp
    @php $_r = ($lang=="ar"?"r":"l")@endphp
    @php $_l = ($lang=="ar"?"l":"r")@endphp
    @php $_left = ($lang=="ar"?"right":"left")@endphp
    <div id="hero" class="hero">
        <div class="container" data-aos="fade-in">
            <div class="row align-center header-row">
                <div class="col-md-12 col-lg-6">
                    <div class="hero-content pt-5 text-{{ $_left }}">
                        <h2 class="text-blue">
                            {!! $sections['highlight']["sub_title_$lang"] !!}</h2>
                        <h2 class="mt-1 " style="font-size:22px;">{!! $sections['highlight']["title_$lang"] !!}
                        </h2>
                        {!! $sections['highlight']["description_$lang"] !!}
                        <a type="button"
                            class="request_now js-scroll-trigger custom-button text-white ml-0">{{ __('data.free_trial') }}</a>
                    </div>
                </div>
                @if ($lang == 'ar')
                    <div class="col-md-12 col-lg-6">
                    @else
                        <div class="col-md-12 col-lg-6">
                @endif
                <img class="img-fluid" src="{{ asset($sections['highlight']['image']) }}" data-aos-delay="100"
                    alt="CloudSellPOS" loading="lazy">
            </div>
        </div>
    </div>
    </div>
    <div id="advantages" class="features mt-5 pb-5" style="background: #506d84;position: relative;">
        <div class="row mt-5 mr-auto ml-auto justify-content-center text-center ">
            <div class="features-intro" data-aos-delay="100" style="padding-top: 30px;">
                @if ($sections['advantages']["title_$lang"])
                    <h2 class="text-white">{{ $sections['advantages']["title_$lang"] }}</h2>
                @endif
                @if ($sections['advantages']["description_$lang"])
                    <div class="text-new-gray">{!! $sections['advantages']["description_$lang"] !!}</div>
                @endif
            </div>
        </div>
        <div class="container" data-aos="fade-up" style="">

            <div class="flex-row mr-auto ml-auto">
                @foreach ($advantages as $advantages)
                    <div class="pb-2 @if ($lang == 'ar') col-lg-3 col-md-4 aos-init aos-animate @else flex-row-col @endif"
                        data-aos-delay="{{ ($loop->iteration + 2) * 150 }}">
                        <div class="@if ($lang == 'en') feature-list @endif feature-card allHeight pl-2 pr-2 pt-1"
                            style="padding-top: 20px !important;">
                            <div class="card-icon">
                                <div class="card-img text-center">
                                    <img src="{{ asset($advantages->image) }}" height="70" alt="Feature" loading="lazy">
                                </div>
                            </div>
                            <div class="card-text text-center">
                                <h3>{{ $advantages["title_$lang"] }}</h3>
                                <p>{{ $advantages["description_$lang"] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="overlay_para"></div>
    </div>
    </div>
    <div id="services" class="ar-ft-single mt-5" style="    background-color: #f2f5fa!important;">
        <div class="container" data-aos="fade-up">
            <div class="row mr-auto ml-auto">
                <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="features-intro text-center">
                        <h2 class="text-blue">{{ $sections['solutions']["title_$lang"] }}</h2>
                        <p class="text_new_gray">{!! $sections['solutions']["description_$lang"] !!}</p>
                    </div>
                </div>
            </div>
            @foreach ($solutions as $item)
                @php
                    $class = $loop->iteration % 2 == 0 ? '' : 'flex-direction-row-reverse';
                    $leftOffset = $rightOffset = '';
                    if ($lang == 'en' && $class) {
                        $leftOffset = 'offset-lg-1';
                    } elseif ($lang == 'ar' && !$class) {
                        $leftOffset = 'offset-lg-1 order-2 service_ar';
                    }
                    if ($lang == 'en' && !$class) {
                        $rightOffset = 'offset-lg-1';
                    } elseif ($lang == 'ar' && $class) {
                        $rightOffset = 'offset-lg-1 order-2 service_ar';
                    }
                @endphp
                <div class="row service-row align-center header-row {{ $class }} mt-5 mr-auto ml-auto"
                    data-aos="fade-up" data-aos-delay="{{ ($loop->iteration + 2) * 150 }}">
                    <div class=" col-md-12 col-lg-6 {{ $leftOffset }}  details ">
                        <div class="pt-2 pb-4 service-content">
                            <h2 class="d-none d-sm-block solution-title">
                                {{ $item["name_$lang"] }}</h2>
                            {!! $item["description_$lang"] !!}
                            <a type="button"
                                class="request_now js-scroll-trigger custom-button text-white ml-0 mt-5">{{ __('data.free_trial') }}</a>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5 {{ $rightOffset }}">
                        <img class="img-fluid p{{ $lang == 'en' ? ($class ? 'r' : 'l') : ($class ? 'l' : 'r') }}-2"
                            src="{{ asset($item['image']) }}" alt=" {{ $item["name_$lang"] }}" loading="lazy">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div id="features" class="features mt-5" style="background: #506d84;position:relative;">
        <div class="row ml-auto mr-auto mt-5 justify-content-center col-md-12" data-aos-delay="100">
            <div class="features-intro">
                <h2 class="text-white text-center">{{ $sections['features']["title_$lang"] }}</h2>
                <p class="text_new_gray text-center">{!! $sections['features']["description_$lang"] !!}</p>
            </div>
        </div>
        <div class="container" data-aos="fade-up">
            <div class="row ml-auto mr-auto text-center features-row">
                <div class="row mt-5 ml-auto mr-auto justify-content-center">
                    @foreach ($features as $feature)
                        <div class="col-lg-3 col-md-4" data-aos="fade-out"
                            data-aos-delay="{{ ($loop->iteration + 2) * 150 }}">
                            <div class="feature-card text-{{ $lang == 'ar' ? 'right' : 'left' }}">
                                <img src="{{ asset($feature->image) }}" height="46" alt="Feature" loading="lazy">
                                <h3>{{ $feature["name_$lang"] }}</h3>
                                <p>{{ $feature["description_$lang"] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="overlay_para"></div>
    </div>
    <div class="ar-ft-single" data-aos="fade-up" style="margin-top:50px;">
        <div class="container">
            <div class="row text-center" data-aos-delay="100">
                <div class="features-intro mb-5">
                    <h2 class="text-blue">{{ $sections['marketing']["title_$lang"] }}</h2>
                    <p class="text-gray">{!! $sections['marketing']["sub_title_$lang"] !!}</p>
                    <a type="button" class="custom-button ml-0 text-white request_now">{{ __('data.get_started') }}</a>
                </div>
            </div>
            <div class="row text-center justify-content-center">
                <img width="600" src="{{ asset($sections['marketing']['image']) }}" data-aos-delay="100"
                    loading="lazy" alt="CloudSellPOS" />
            </div>
        </div>
    </div>
    <section id="contact" class="add-padding border-top-color2"
        style="padding-top:96px;padding-bottom:96px;background: #506d84;position: relative;">
        <div class="row mt-5 justify-content-center col-md-12" data-aos-delay="100">
            <div class="features-intro" style="">
            </div>
        </div>
        <div class="container text-center">

            <div class="row">

                <div class="col-sm-6 col-md-5 text-{{ $_left }} scrollimation fade-up d1">

                    <h1 class="big-text">{{ __('data.contact_us') }}</h1>
                    <div style="color:white"> {{ __('data.for_more_information') }}</div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="foo_phone_box">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="foot_contact_us mt-3">
                                <div>
                                    <div>
                                        <h3>
                                            <a href="tel:{{ $company_information->contact_phone }}"
                                                class="third-color">{{ $company_information->contact_phone }}</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="foo_phone_box">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="foot_contact_us mt-3">
                                <div>
                                    <h3>
                                        <a href="mailto:{{ $company_information->email }}"
                                            class="third-color">{{ $company_information->email }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!--=== Contact Form ===-->
                <form id="contact-form" class="col-sm-6 col-md-offset-1 scrollimation fade-left d3" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="subject" value="" />
                    <div class="form-group">
                        <label class="control-label" for="contact-name">{{ __('data.cont_name') }}</label>
                        <div class="controls">
                            <input id="contact-name" type="text" name="name"
                                placeholder="{{ __('data.your_name') }}" class="form-control requiredField required"
                                data-new-placeholder="Your name" data-error-empty="Please enter your name">
                            <i class="fa fa-user"></i>
                        </div>
                    </div><!-- End name input -->

                    <div class="form-group">
                        <label class="control-label" for="contact-mail">{{ __('data.cont_email') }}</label>
                        <div class=" controls">
                            <input id="contact-mail" type="email" name="email"
                                placeholder="{{ __('data.your_email') }}" class="form-control requiredField required"
                                data-new-placeholder="Your email" data-error-empty="Please enter your email"
                                data-error-invalid="Invalid email address">
                            <i class="fa fa-envelope"></i>
                        </div>
                    </div><!-- End email input -->
                    <div class="form-group">
                        <label class="control-label" for="contact-phone">Phone</label>
                        <div class=" controls">
                            <input id="contact-phone" type="text" name="phone"
                                placeholder="{{ __('data.your_phone') }}" class="form-control requiredField required"
                                data-new-placeholder="Your email" data-error-empty="Please enter your Phone"
                                data-error-invalid="Invalid Phone Number">
                            <i class="fa fa-phone"></i>
                        </div>
                    </div><!-- End email input -->
                    <div class="form-group">
                        <label class="control-label" for="contact-message">{{ __('data.cont_Message') }}</label>
                        <div class="controls">
                            <textarea id="contact-message" name="message" placeholder="{{ __('data.your_message') }}"
                                class="form-control requiredField required" data-new-placeholder="Your message" rows="6"
                                data-error-empty="Please enter your message"></textarea>
                            <i class="fa fa-comment"></i>
                        </div>
                    </div><!-- End textarea -->
                    <div class="form-group">
                        <div class="g-recaptcha" id="g-recaptcha"
                            data-sitekey="{{ CRUDBooster::getSetting('website_recaptcha_site_key') }}">
                        </div>
                        <div class="cs-height_20 cs-height_lg_20"></div>
                    </div>
                    <p><button name="submit" type="button" class="btn btn-color2 btn-block"
                            data-error-message="Error!" data-sending-message="Sending..." data-ok-message="Message Sent"
                            onclick="contactSubmit(event)"><i class="fa fa-paper-plane" id="contact-btn"></i>
                            {{ __('data.send_message') }} </button></p>
                    <input type="hidden" name="submitted" id="submitted" value="true" />

                </form><!-- End contact-form -->

            </div>
        </div>

    </section>
@endsection
