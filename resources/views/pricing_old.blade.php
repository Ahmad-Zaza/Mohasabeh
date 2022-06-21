    @extends('layouts.app')
    @php $_left = ($lang=="ar"?"right":"left")@endphp
    @section('content')
        <div id="pricing" class="pricing-section text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-8">
                        <div class="pricing-intro" data-aos="fade-up" data-aos-delay="200">
                            <h1>{{ $section["title_$lang"] }}</h1>
                            <p>{{ $section["sub_title_$lang"] }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                                <div class="table-left">
                                    <h3>{{ __('data.free_package_title') }}</h3>
                                    <p>{{ __('data.free_package_sub_title') }}</p>
                                    <div class="pricing-details pt-5">
                                        <span>{{ __('data.free_package_title') }}</span>
                                    </div>
                                    <div class="pb-1 nowrap text-{{ $_left }}">
                                        <div class="form-holder"><strong class="mr-1">100MB</strong>
                                            {{ __('data.storage') }}</div>
                                    </div>
                                    <div class="pb-1 nowrap text-{{ $_left }}">
                                        <div class="form-holder">
                                            1 - 20
                                            <label class="nowrap mx-2">&nbsp;{{ __('data.users_count') }}</label>
                                        </div>
                                    </div>
                                    <div class="pb-1 nowrap text-{{ $_left }}">
                                        <div class="form-holder">
                                            English & Arabic
                                            <label class="mx-2 nowrap">&nbsp;{{ __('data.sys_lang') }}</label>
                                        </div>
                                    </div>
                                    @foreach ($modules as $item)
                                        @php $checked = $item->is_obligate?"checked":"" @endphp
                                        <div class="pb-{{$lang=="ar"?1:2}} nowrap text-{{ $_left }}">
                                            <span class="span-check text-main"></span>
                                            <label class="nowrap">{{ $item["name_$lang"] }}</label>
                                        </div>
                                    @endforeach
                                    <button class="btn btn-primary btn-action request_now"
                                        type="button">{{ __('data.get_started') }}</button>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="fade-left" data-aos-delay="300">
                                <div class="table-right">
                                    <form class="subscribtionForm">
                                        <h3>{{ __('data.subscription_package_title') }}</h3>
                                        <p>{{ __('data.subscription_package_sub_title') }}</p>
                                        <div class="pt-2">
                                            <input type="checkbox" name="subscription_type" class="subscription_type"
                                                checked data-toggle="toggle" data-onstyle="light"
                                                data-on="{{ __('data.yearly') }}" data-off="{{ __('data.monthly') }}">
                                        </div>
                                        <div class="pricing-details pt-1">
                                            <span>$<span class="total mb-0"></span></span>
                                        </div>
                                        <div class="pb-1 nowrap text-{{ $_left }}">
                                            <div><strong class="mx-2">100MB</strong> {{ __('data.storage') }}
                                            </div>
                                        </div>
                                        <div class="pb-1 nowrap text-{{ $_left }}">
                                            <div class="form-holder">
                                                <select class="p-0 ml-1 mr-1 custom-select users_count required"
                                                    name="users_count" style="color: white;">
                                                    @foreach ($usersOptions as $item)
                                                        <option data-price-month="{{ $item->month_price }}"
                                                            data-price-six-month="{{ $item->six_month_price }}"
                                                            data-price-year="{{ $item->year_price }}"
                                                            value="{{ $item->value }}" class="number">
                                                            {{ $item["name_$lang"] }}</option>
                                                    @endforeach
                                                </select>
                                                <label class="mx-2 nowrap">{{ __('data.users_count') }}</label>
                                            </div>
                                        </div>
                                        <div class="pb-1 nowrap text-{{ $_left }}">
                                            <div class="form-holder">
                                                <select class="p-0 ml-1 mr-1 custom-select sys_lang required"
                                                    name="sys_lang" style="color: white;">
                                                    @foreach ($languagesOptions as $item)
                                                        <option data-price-month="{{ $item->month_price }}"
                                                            data-price-six-month="{{ $item->six_month_price }}"
                                                            data-price-year="{{ $item->year_price }}"
                                                            value="{{ $item->value }}">
                                                            {{ $item["name_$lang"] }}</option>
                                                    @endforeach
                                                </select>
                                                <label class="mx-2 nowrap">{{ __('data.sys_lang') }}</label>
                                            </div>
                                        </div>

                                        @foreach ($modules as $item)
                                            @php $checked = $item->is_obligate?"checked":"" @endphp
                                            @php $readonly = $item->is_obligate?"false":"true" @endphp

                                            <div class="pb-1 nowrap text-{{ $_left }}">
                                                <div class="form-check pl-2">
                                                    <input type="checkbox" class="form-check-input form-input module"
                                                        {{ $checked }} value="{{ $item->id }}" name="module"
                                                        data-price-month="{{ $item->month_price }}"
                                                        data-price-six-month="{{ $item->six_month_price }}"
                                                        data-price-year="{{ $item->year_price }}"
                                                        id="module{{ $item->id }}">
                                                    <label class="form-check-label" for="module{{ $item->id }}"
                                                        onclick="return {{ $readonly }};">{{ $item["name_$lang"] }}</label>
                                                </div>

                                                {{-- <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="materialChecked"
                                                        checked="">
                                                    <label class="mx-2 nowrap">{{ $item["name_$lang"] }}</label>
                                                </div> --}}
                                            </div>
                                        @endforeach
                                        <button class="subscribe_now btn btn-action btn-white mt-2"
                                            type="button">{{ __('data.subscribe_now') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $('.subscribe_now').click(function() {
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
