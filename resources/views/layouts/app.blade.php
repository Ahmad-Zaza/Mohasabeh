<!DOCTYPE html>
<html lang="{{ $lang }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'CloudSellPOS') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset($settings['favicon']) }}" type="image/png" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" defer> <!-- Resource style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}" defer> <!-- Resource style -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/steps-style.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}" defer>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @if ($lang == 'ar')
        <link href="{{ asset('css/style-rtl.css') }}" defer rel="stylesheet" type="text/css" media="all" />
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" async defer
        rel="stylesheet">
    <link href="{{ asset('css/custome.css') }}" rel="stylesheet" type="text/css" media="all" defer />
    <link href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.css') }}" rel="stylesheet"
        type="text/css" media="all" defer />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,900%7COpen+Sans:400|Baloo Bhaijaan 2"
        rel="stylesheet" defer>
    <link href="https://fonts.googleapis.com/css?family=Almarai:300,400,500,600,700,900" rel="stylesheet" defer>
    <link href="{{ asset('css/bootstrap4-toggle.min.css') }}" rel="stylesheet" defer>
    <link href="{{ asset('css/custom-toast.css') }}" rel="stylesheet" defer />
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

    <!-- Phone number validation -->
    <link rel="stylesheet" href="{{ asset('intl_tel_input/css/intlTelInput.css') }}">
    @if ($lang == 'ar')
        <link rel="stylesheet" href="{{ asset('intl_tel_input/css/intlTelInput_rtl.css') }}">
    @endif

</head>
@php $_right = ($lang=="ar"?"left":"right")@endphp
@php $_r = ($lang=="ar"?"r":"l")@endphp
@php $_l = ($lang=="ar"?"l":"r")@endphp
@php $_left = ($lang=="ar"?"right":"left")@endphp

<body lang="{{ $lang }}">
    <div class="wrapper flex flex-direction-column">
        <!-- Navbar Section -->
        <nav id="main" class="navbar navbar-expand-md navbar-light bg-light fixed-top">
            <div class="container">
                <a class="navbar-brand main" href="#">
                    <img width="150" src="{{ asset($settings['logo']) }}" alt="CloudSellPOS" loading="lazy" />
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto ml-auto navbar-center">
                        @php
                            $menu_items = DB::table('site_menu')
                                ->where('active', 1)
                                ->orderby('sorting', 'asc')
                                ->get();
                        @endphp
                        @foreach ($menu_items as $item)
                            @php
                                $href = config('app.url') . '#' . $item->section;
                                if ($item->section == 'pricing') {
                                    $href = url('pricing') . '#' . $item->section;
                                }
                            @endphp
                            <li class="nav-item"><a class="nav-link js-scroll-trigger"
                                    href="{{ $href }}">{{ $lang == 'ar' ? $item->name_ar : $item->name_en }}</a>
                            </li>
                        @endforeach
                        <li class="nav-item mobile third-color"><a class="nav-link js-scroll-trigger"
                                href="{{ url('setLang/' . ($lang == 'ar' ? 'en' : 'ar')) }}">{{ $lang == 'ar' ? 'English' : 'العربية' }}</a>
                        </li>
                        <li class="nav-item mobile login-color" onclick="openLoginModal()">{{ __('data.login') }}</li>
                    </ul>
                </div>
                <a type="button"
                    class="request-a-demo request_now text-white m-0 js-scroll-trigger">{{ __('data.free_trial') }}</a>

                <a type="button" data-toggle="modal" data-target="#loginModal"
                    class="text-orange p-4 login-button desktop"><img width="20" height="auto"
                        src="{{ asset('images/Login.svg') }}" alt="MyAccount" loading="lazy"></a>

                <a class="languge-switch"
                    href="{{ url('setLang/' . ($lang == 'ar' ? 'en' : 'ar')) }}">{{ $lang == 'ar' ? 'English' : 'العربية' }}</a>
            </div>
        </nav><!-- Navbar End -->


        <div class="main">
            <div class="modal fade loginModal" id="loginModal" tabindex="-1" role="dialog"
                aria-labelledby="loginModal" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="" id="loginForm" class="requestForm needs-validation"
                            enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <section>
                                <div>
                                    <div class="form-content">
                                        <div class="form-header">
                                            <h2 class="text-blue mb-4">{{ __('data.login') }}</h2>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder w-100 flex">
                                                <input type="email" placeholder="{{ __('data.email') }}"
                                                    name="email" required class="form-control mr-1">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="password" placeholder="{{ __('data.password') }}"
                                                    required name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row text-center justify-content-center">
                                            <button type="submit" onclick="loginSubmit(event)"
                                                class="btn btn-primary">{{ __('data.login') }}</button>
                                        </div>
                                        <div class="form-row">
                                            <a type="" data-toggle="modal" data-target="#forgetPasswordModal"
                                                style="color:#4c4c4e">{{ __('data.forget_password') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade forgetPasswordModal" id="forgetPasswordModal" tabindex="-1" role="dialog"
                aria-labelledby="forgetPasswordModal" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="" id="forgetPasswordForm" class="requestForm needs-validation"
                            enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <section>
                                <div>
                                    <div class="form-content">
                                        <div class="form-header">
                                            <h2 class="text-blue mb-4">{{ __('data.get_new_password') }}</h2>
                                        </div>
                                        <div class="form-row" style="margin-top:60px;">
                                            <p>{{ __('data.forget_password_message') }}</p>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder w-100 flex">
                                                <input type="email" placeholder="{{ __('data.email') }}"
                                                    name="email" required class="form-control mr-1">
                                            </div>
                                        </div>

                                        <div class="form-row text-center justify-content-center">
                                            <button type="submit" onclick="forgetPasswordSubmit(event)"
                                                class="btn btn-primary">{{ __('data.send') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade subscribtionModal" id="subscribtionModal" tabindex="-1" role="dialog"
                aria-labelledby="subscribtionModal" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <form action="" id="wizard" class="requestForm needs-validation"
                            enctype="multipart/form-data" method="POST" novalidate>
                            <input type="hidden" name="type" class="type">
                            <input type="hidden" name="package_id" class="type">
                            <input type="hidden" name="free_trial" class="type" value="off">
                            <!-- SECTION 1 -->
                            <h2></h2>
                            <section>
                                <div class="inner">
                                    <div class="form-content">
                                        <div class="form-header">
                                            <h3 class="text-blue">{{ __('data.free_trial') }}</h3>
                                        </div>
                                        <p>{{ __('data.personal_info') }}</p>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="text" name="first_name"
                                                    placeholder="{{ __('data.first_name') }}" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="text" name="last_name"
                                                    placeholder="{{ __('data.last_name') }}" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="email" name="email"
                                                    placeholder="{{ __('data.email') }}" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="tel" name="phone" id="mobile_phone1"
                                                    class="tel form-control" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </section>
                            <!-- SECTION 2 -->
                            <h2></h2>
                            <section>
                                <div class="inner">
                                    <div class="form-content">
                                        <div class="form-header">
                                            <h3 class="text-blue">{{ __('data.requestADemo') }}</h3>
                                        </div>
                                        <p>{{ __('data.domain_info') }}</p>
                                        <div class="form-row">
                                            <div class="form-holder w-100 flex">
                                                <label class="english-text" style="direction: ltr;"
                                                    for="">https://</label>
                                                <input type="text" placeholder="{{ __('data.website_pref') }}"
                                                    name="domain" required class="form-control mr-1">
                                                <span style="direction: ltr;">.cloudsellpos.com</span>

                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="text" placeholder="{{ __('data.company') }}" required
                                                    name="company" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder w-100">
                                                <div id="freeRecaptcha"></div>
                                            </div>
                                            <div class="form-holder"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade subscribtionModal" id="subscribeModal" tabindex="-1" role="dialog"
                aria-labelledby="subscribeModal" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <form action="" id="wizard1" class="requestForm needs-validation"
                            enctype="multipart/form-data" method="POST" novalidate>
                            <input type="hidden" name="type" class="type">
                            <input type="hidden" name="package_id">
                            <input type="hidden" name="free_trial" value="off">
                            <!-- SECTION 1 -->
                            <h2></h2>
                            <section>
                                <div class="inner">
                                    <div class="form-content">
                                        <div class="form-header">
                                            <h3 class="text-blue modal-header">{{ __('data.subscribe') }}</h3>
                                        </div>
                                        <p>{{ __('data.personal_info') }}</p>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="text" name="first_name"
                                                    placeholder="{{ __('data.first_name') }}" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="text" name="last_name"
                                                    placeholder="{{ __('data.last_name') }}" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="email" name="email"
                                                    placeholder="{{ __('data.email') }}" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">

                                                <input type="tel" name="phone" id="mobile_phone2"
                                                    class="tel form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- SECTION 2 -->
                            <h2></h2>
                            <section>
                                <div class="inner">
                                    <div class="form-content">
                                        <div class="form-header">
                                            <h3 class="text-blue">{{ __('data.subscribe') }}</h3>
                                        </div>
                                        <p>{{ __('data.domain_info') }}</p>
                                        <div class="form-row">
                                            <div class="form-holder w-100 flex">
                                                <label class="english-text" style="direction: ltr;"
                                                    for="">https://</label>
                                                <input type="text" placeholder="{{ __('data.website_pref') }}"
                                                    name="domain" required class="form-control mr-1">
                                                <span style="direction: ltr;">.cloudsellpos.com</span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder">
                                                <input type="text" placeholder="{{ __('data.company') }}" required
                                                    name="company" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-holder w-100">
                                                <div id="subscribedRecaptcha"></div>
                                            </div>
                                            <div class="form-holder"></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>

            <div class="toast success_toast" data-autohide="false" role="alert" aria-live="assertive"
                style="{{ $_right }}:0" aria-atomic="true">
                <div class="toast-header">
                    <strong class="m{{ $_l }}-auto">{{ __('data.success') }}</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    {{ __('data.success_msg') }}
                </div>
            </div>
            <div class="toast error_toast" data-autohide="false" role="alert" aria-live="assertive"
                style="{{ $_right }}:0" aria-atomic="true">
                <div class="toast-header">
                    <strong class="m{{ $_l }}-auto">{{ __('data.error') }}</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                </div>
            </div>

            @yield('content')
            <div class="footer-sm">
                <div class="container-m">
                    <div class="row justify-content-center mt-4">
                        <ul class="social-links text-center">
                            @foreach ($social_media as $sm)
                                <li><a href="{{ $sm->value }}" target="_blank"><i
                                            class="fa {{ $sm->icon }} fa-fw"></i></a></li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="row justify-content-center logo-row">
                        <a class="footer-logo pr-3" href="{{ url('/') }}">
                            <img width="80px" src="{{ asset($settings['logo']) }}" alt="CloudSellPOS"
                                loading="lazy" />
                        </a>
                        <span class="ml-3">
                            {{ date('Y') }}
                            {{ __('data.rights') }}
                        </span>

                    </div>
                </div>
            </div>
            <!-- Scroll To Top -->
            <div id="back-top" class="bk-top">
                <div class="bk-top-txt">
                    <a class="back-to-top js-scroll-trigger" href="#"><i class=" fa fa-angle-up"
                            style="font-size: 18px;"></i></a>
                </div>
            </div>
            <!-- Scroll To Top Ends-->
        </div> <!-- Main -->
        <div class="snackbar error bg-danger">Contact us Failed</div>
        <div class="snackbar success bg-success">Contact us Successfully</div>
    </div><!-- Wrapper -->

    <!-- Jquery and Js Plugins -->
    <script src="{{ asset('js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/sticky-sidebar.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/plugins.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery.steps.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery.appear.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/jquery.nav.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/aos.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('intl_tel_input/js/intlTelInput.js') }}"></script>

    <script>
        $(function() {
            //------------------------------------------//
            //------------------------------------------//
            $('.navbar-nav').onePageNav({
                currentClass: 'current',
                changeHash: false,
                scrollSpeed: 750,
                scrollThreshold: 0.5,
                filter: ':not(.request-a-demo)',
                easing: 'swing',
                begin: function() {
                    //get fired when the animation is starting
                },
                end: function() {
                    //I get fired when the animation is ending
                },
                scrollChange: function($currentListItem) {
                    //get fired when you enter a section and I pass the list item of the section
                }
            });
            //------------------------------------------//
            $('.request_now').click(function() {
                //initialize phone number
                if (typeof($(this).attr('package_id')) !== "undefined" && $(this).attr('package_id') !==
                    null) {
                    package_id = $(this).attr('package_id');
                    $('.requestForm').find('input[name=package_id]').val(package_id);
                }

                //render in show modal
                try {
                    grecaptcha.getResponse(freeRecaptcha);
                } catch (error) {
                    freeRecaptcha = grecaptcha.render('freeRecaptcha', {
                        'sitekey': '{{ CRUDBooster::getSetting('website_recaptcha_site_key') }}'
                    });
                }


                $('#subscribtionModal').modal('show');
            });
            $('.request_trial').click(function() {
                if (typeof($(this).attr('package_id')) !== "undefined" && $(this).attr('package_id') !==
                    null) {
                    $('.requestForm').find('input[name=package_id]').val($(this).attr('package_id'));
                }
                $('.requestForm').find('input[name=type]').val('free');
                $('.requestForm').find('input[name=free_trial]').val('free');

                $('#subscribtionModal').modal('show');
            });
            $('.moreDescription').click(function() {
                var parent = $(this).closest('.card-text');
                parent.find('.cut-desc').addClass('hide');
                parent.find('.all-desc').removeClass('hide');
            })
            $('.lessDescription').click(function() {
                var parent = $(this).closest('.card-text');
                parent.find('.all-desc').addClass('hide');
                parent.find('.cut-desc').removeClass('hide');
            })
            calculateTotalPrice();
            $('.subscription_type,.module,.sys_lang,.users_count').change(function() {
                calculateTotalPrice();
            })
        })

        function calculateTotalPrice() {
            let attr = $('.subscription_type').prop('checked') ? "data-price-year" : "data-price-month";
            let total = 0;
            total += parseInt($('.users_count option:selected').attr(attr));
            total += parseInt($('.sys_lang option:selected').attr(attr));
            let modules = $('.module:checked');
            modules.each(function() {
                total += parseInt($(this).attr(attr));
            });
            $('.total').html(total);
        }

        function saveCustomer(wizard) {
            if ($('#' + wizard)[0].checkValidity()) {
                //get full number (country code + number)
                //we need to find better way to do it
                //note: iti and iti1 are Global Var
                if (wizard == 'wizard') {
                    document.getElementById('mobile_phone1').value = iti.getNumber();
                } else {
                    document.getElementById('mobile_phone2').value = iti1.getNumber();
                }
                event.preventDefault();
                var form_data = new FormData($('#' + wizard)[0]);
                if ($('#' + wizard).find('.type').val() != 'free') {
                    form_data.append("users_count", $('.users_count').val());
                    form_data.append("sys_lang", "ar");
                    form_data.append("sub_type", $('input[name=subscription_type]').val());
                } else {
                    form_data.append("users_count", 4);
                    form_data.append("sys_lang", "ar");
                    form_data.append("free_trial_checkbox", "on");
                }
                let modules = [];
                $('input[name="module"]').each(function() {
                    if ($(this).prop('checked')) {
                        modules.push($(this).val());
                    }
                });
                form_data.append("modules", modules);
                $('a[href="#finish"]').html(
                    '<div class="spinner-grow spinner-grow-sm text-light" role="status">' +
                    '<span class="sr-only">Loading...</span>' +
                    '</div>').addClass("isDisabled").attr("href", "").attr("type", "button");

                $.ajax({
                    type: 'POST',
                    url: '{{ route('save-customer') }}',
                    processData: false,
                    beforeSend: function() {
                        $('a[href="#finish"]').html(
                            '<div class="spinner-grow spinner-grow-sm text-light" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            '</div>').addClass("isDisabled").attr("href", "").attr("type", "button");
                    },
                    contentType: false,
                    data: form_data,
                    success: function(res) {
                        $('a.isDisabled').html("{{ __('data.submit') }}").removeClass("isDisabled").attr(
                            "href",
                            '#finish').removeAttr("type");
                        if (res.success) {

                            $('.success_toast').find('.toast-body').html(res.message);
                            $('.success_toast').toast('show');
                            $('.subscribtionModal').modal('hide');

                            setTimeout(function() {
                                $('.success_toast').toast('hide');
                            }, 5000);
                            $("form input").val("");
                            resetForm(wizard);
                        } else if (res.errors) {
                            var message = '';
                            $.each(res.errors, function(key, value) {
                                message += '<p>' + value[0] + '</p>';
                            });
                            $('.error_toast').find('.toast-body').html(message);
                            $('.error_toast').toast('show');
                            setTimeout(function() {
                                $('.error_toast').toast('hide');
                            }, 8000);
                        }
                    }
                });
            }
        }

        function resetModal() {
            $("#wizard-p-1").find("input").val("");
            $("#wizard-p-1").find("select").val("");
        }
        window.addEventListener('load', () => {
            AOS.init({
                duration: 1000,
                offset: -60,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            })
        });

        function checkLoginFormValid() {
            let form = $("#loginForm");
            let inputs = form.find('input');
            let isValid = true;
            inputs.each(function() {
                if (!$(this).valid()) {
                    isValid = false;
                    $(this).closest("div.form-holder").addClass("was-validated");
                }
            });
            return isValid;
        }
    </script>

    <script>
        $(function() {
            $("#wizard").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "fade",
                enableAllSteps: true,
                transitionEffectSpeed: 500,
                labels: {
                    finish: "{{ __('data.submit') }}",
                    next: "{{ __('data.next') }}",
                    previous: "{{ __('data.previous') }}"
                }
            });
            // Custome Jquery Step Button
            $('.forward').click(function() {
                $("#wizard").steps('next');
            })
            $('.backward').click(function() {
                $("#wizard").steps('previous');
            })
            // Select Dropdown
            $('html').click(function() {
                $('.select .dropdown').hide();
            });
            $('.select').click(function(event) {
                event.stopPropagation();
            });
            $('.select .select-control').click(function() {
                $(this).parent().next().toggle();
            })
            $('.select .dropdown li').click(function() {
                $(this).parent().toggle();
                var text = $(this).attr('rel');
                $(this).parent().prev().find('div').text(text);
            })

        })

        $(function() {
            $("#wizard1").steps({
                headerTag: "h2",
                bodyTag: "section",
                transitionEffect: "fade",
                enableAllSteps: true,
                transitionEffectSpeed: 500,
                labels: {
                    finish: "{{ __('data.submit') }}",
                    next: "{{ __('data.next') }}",
                    previous: "{{ __('data.previous') }}"
                }
            });
            // Custome Jquery Step Button
            $('.forward').click(function() {
                $("#wizard1").steps('next');
            })
            $('.backward').click(function() {
                $("#wizard1").steps('previous');
            })
            // Select Dropdown
            $('html').click(function() {
                $('.select .dropdown').hide();
            });
            $('.select').click(function(event) {
                event.stopPropagation();
            });
            $('.select .select-control').click(function() {
                $(this).parent().next().toggle();
            })
            $('.select .dropdown li').click(function() {
                $(this).parent().toggle();
                var text = $(this).attr('rel');
                $(this).parent().prev().find('div').text(text);
            })
        })
        $(document).ready(function() {
            $('.subscription_ttype').change(function() {
                pack_id = $(this).attr('pack_id');
                option_value = $(this).val();
                price_amount = option_value.split('-')[1];
                pkg_sub_type = option_value.split('-')[0];
                $('input[name=subscription_type]').val(pkg_sub_type);
                $('#dy_amnt_pkg_' + pack_id).html('<strong>$' + price_amount + '</strong>');
            });
        });

        function loginSubmit(event) {
            event.preventDefault();
            if (checkLoginFormValid()) {
                let data = $("#loginForm").serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('login-customer') }}',
                    beforeSend: function() {
                        $('#loginForm [type="submit"]').html(
                            '<div class="spinner-grow spinner-grow-sm text-light" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            '</div>').addClass("isDisabled").attr("type", "button").attr("disabled",
                            "disabled");
                    },
                    data: data,
                    success: function(res) {
                        $('#loginForm [type="button"]').html("{{ __('data.submit') }}").removeClass(
                            "isDisabled").attr("type", "submit").removeAttr("disabled");
                        $('#loginModal').modal('hide');
                        $('#loginModal input').val("");
                        //-------------------------------------------//
                        if (res.url) {
                            window.location.href = res.url;
                        }
                        //-------------------------------------------//
                    },
                    error: function(res) {
                        $('#loginForm [type="button"]').html("{{ __('data.submit') }}").removeClass(
                            "isDisabled").attr("type", "submit").removeAttr("disabled");
                        let message = res.responseJSON.message;
                        $('.error_toast').find('.toast-body').html(message);
                        $('.error_toast').toast('show');
                        setTimeout(function() {
                            $('.error_toast').toast('hide');
                        }, 5000);
                    }
                });
            }
        }

        function forgetPasswordSubmit(event) {
            event.preventDefault();
            let form = $("#forgetPasswordForm");
            let inputs = form.find('input');
            let isValid = true;
            inputs.each(function() {
                if (!$(this).valid()) {
                    isValid = false;
                    $(this).closest("div.form-holder").addClass("was-validated");
                }
            });
            if (isValid) {
                let data = $("#forgetPasswordForm").serialize();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('forget-password-customer') }}',
                    beforeSend: function() {
                        $('#forgetPasswordForm [type="submit"]').html(
                            '<div class="spinner-grow spinner-grow-sm text-light" role="status">' +
                            '<span class="sr-only">Loading...</span>' +
                            '</div>').addClass("isDisabled").attr("type", "button").attr("disabled",
                            "disabled");
                    },
                    data: data,
                    success: function(res) {
                        $('#forgetPasswordForm [type="button"]').html("{{ __('data.send') }}").removeClass(
                            "isDisabled").attr("type", "submit").removeAttr("disabled");
                        $('#forgetPasswordForm').modal('hide');
                        $('#forgetPasswordForm input').val("");
                        //hidden Modal and show message
                        let message = res.message;
                        $('.success_toast').find('.toast-body').html(message);
                        $('.success_toast').toast('show');
                        $('.forgetPasswordModal').modal('hide');
                    },
                    error: function(res) {
                        $('#forgetPasswordForm [type="button"]').html("{{ __('data.send') }}").removeClass(
                            "isDisabled").attr("type", "submit").removeAttr("disabled");
                        let message = res.responseJSON.message;
                        $('.error_toast').find('.toast-body').html(message);
                        $('.error_toast').toast('show');
                        setTimeout(function() {
                            $('.error_toast').toast('hide');
                        }, 5000);
                    }
                });
            }
        }
    </script>
    <script>
        function contactSubmit(event) {
            // event.preventDefault();
            var procceed = 1;
            $('input').each(function() {
                if ($(this).hasClass('required') && $(this).val() === "") {
                    procceed = 0;
                    $(this).css('border', '1px solid red');
                }
            });
            $('textarea').each(function() {
                if ($(this).hasClass('required') && $(this).val() === "") {
                    procceed = 0;
                    $(this).css('border', '1px solid red');
                }
            });
            if (procceed == 0) {
                customToast2("error", "{{ trans('data.please_fill_the_required_fields') }}");
            } else if ($('#g-recaptcha-response-2').val() == "") {
                customToast2("error", "{{ trans('data.alert_recaptcha') }}");
            } else {
                //   alert($('input[name=email]').val());
                let data = $("#contact-form").serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('save-contact') }}",
                    data: data,
                    beforeSend: function() {
                        $(".cs-preloader").css("display", "block");
                        $(".cs-preloader_in").css("display", "block");
                        $("#contact-btn").removeClass("fa fa-paper-plane");
                        $("#contact-btn").addClass("fa fa-spinner fa-spin");
                    },
                    success: function(res) {

                        if (res.success) {
                            $(".cs-preloader").delay(150).fadeOut("slow");
                            customToast("success", "{{ trans('data.contact_us_successfully') }}");
                            $("#contact_form").val("").html("");
                        } else if (res.errors) {
                            var message = '';
                            $.each(res.errors, function(key, value) {
                                message += '<p>' + value[0] + '</p>';
                            });
                            customToast("error", message);
                        }
                    },
                    error: function(res) {
                        $(".cs-preloader").delay(150).fadeOut("slow");
                        customToast("error", "{{ trans('data.contact_us_failed') }}");
                    }
                }).done(function(data) {
                    $("#contact-btn").removeClass("fa fa-spinner fa-spin");
                    $("#contact-btn").addClass("fa fa-paper-plane");
                });
            }
        }

        function customToast2(value, msg) {

            $(".snackbar." + value)[0].innerHTML = msg;

            // Add the "show" class to DIV
            $(".snackbar." + value).addClass("show");

            // After 3 seconds, remove the show class from DIV
            setTimeout(function() {
                $(".snackbar." + value).removeClass("show");
            }, 3000);
        }

        function customToast(value, msg) {

            $(".snackbar." + value)[0].innerHTML = msg;

            // Add the "show" class to DIV
            $(".snackbar." + value).addClass("show");

            // After 3 seconds, remove the show class from DIV
            setTimeout(function() {
                $(".snackbar." + value).removeClass("show");
                if (value == 'success')
                    location.reload();
            }, 3000);
        }
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-229582840-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());



        gtag('config', 'UA-229582840-1');
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            /***** validation input ******/
            $("input[name=domain]").keyup(function() {
                var input = $(this);
                var text = input.val().replace(/[^0-9a-z]/g, ""); //allow  just numbers with +
                if (/_|\s/.test(text)) {
                    text = text.replace(/_|\s/g, "");
                    // logic to notify user of replacement
                }
                input.val(text);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            invalidMobileMessage = "{{ trans('data.invalid_mobile') }}";
            //setup mobile phone
            var mobilePhone2 = document.getElementById('mobile_phone2');
            iti1 = window.intlTelInput(mobilePhone2, {
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    selectedCountryPlaceholder = selectedCountryPlaceholder.replace(/\s/g, '');
                    return selectedCountryPlaceholder;
                },
                initialCountry: "auto",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {

                        var countryCode = (resp && resp.country) ? resp.country : "ae";
                        callback(countryCode);
                    });
                },
                utilsScript: "{{ asset('intl_tel_input/js/utils.js?1638200991544') }}"
            });
            //end

            //setup mobile phone
            var mobilePhone1 = document.getElementById('mobile_phone1');
            iti = window.intlTelInput(mobilePhone1, {
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    selectedCountryPlaceholder = selectedCountryPlaceholder.replace(/\s/g, '');
                    return selectedCountryPlaceholder;
                },
                initialCountry: "auto",
                geoIpLookup: function(callback) {
                    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {

                        var countryCode = (resp && resp.country) ? resp.country : "ae";
                        callback(countryCode);
                    });
                },
                utilsScript: "{{ asset('intl_tel_input/js/utils.js?1638200991544') }}"
            });
            //end
        });
    </script>

    <script>
        function openLoginModal() {

            $('#loginModal').modal('show');
        }
    </script>

    <script>
        function resetForm(formName) {
            document.getElementById(formName).reset();
            formName = "#" + formName;
            $(formName).steps('previous');

            if (formName == "#wizard1") {
                grecaptcha.reset(subscribedRecaptcha);
            } else {
                grecaptcha.reset(freeRecaptcha);
            }
        }
    </script>
</body>

</html>
