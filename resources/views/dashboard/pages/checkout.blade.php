@extends('dashboard.layouts.master')
@section('content')
    <div class="pagetitle pb-1">
        <h1>{{ __('dashboard.upgrade_your_account') }}</h1>
    </div>

    <section class="section contact">

        <div class="col-md-6">

            <div class="info-box card ">
                <div class="info">
                    <h3>{{ __('dashboard.plan') }}</h3>
                    <p>
                        @if (App::isLocale('ar'))
                            {{ $package->title_ar }}
                        @else
                            {{ $package->title_en }}
                        @endif
                    </p>
                </div>
                <div class="info">
                    <h3>{{ __('dashboard.Description') }}</h3>
                    @if ($type == 'renew')
                        <p>{{ __('dashboard.renew_your_account_for') }}
                            @if ($sub_type == 'month')
                                {{ __('dashboard.a_month') }}
                            @elseif($sub_type == 'year')
                                {{ __('dashboard.a_year') }}
                            @elseif($sub_type == 'six_month')
                                {{ __('dashboard.six_months') }}
                            @endif
                            </br>
                            {{ __('dashboard.from') }} {{ $customer->subscription_end_date->format('d/m/Y') }}
                            {{ __('dashboard.to') }}
                            @if ($sub_type == 'month')
                                {{ $customer->subscription_end_date->addMonths(1)->format('d/m/Y') }}
                            @elseif($sub_type == 'year')
                                {{ $customer->subscription_end_date->addYears(1)->format('d/m/Y') }}
                            @elseif($sub_type == 'six_month')
                                {{ $customer->subscription_end_date->addMonths(6)->format('d/m/Y') }}
                            @endif
                        </p>
                    @elseif($type == 'subscribe')
                        <p>{{ __('dashboard.upgrade_your_account_for') }}

                            @if ($sub_type == 'month')
                                {{ __('dashboard.a_month') }}
                            @elseif($sub_type == 'year')
                                {{ __('dashboard.a_year') }}
                            @elseif($sub_type == 'six_month')
                                {{ __('dashboard.six_months') }}
                            @endif

                            </br>
                            {{ __('dashboard.from') }} {{ now()->format('d/m/Y') }} {{ __('dashboard.to') }}
                            @if ($sub_type == 'month')
                                {{ $customer->subscription_end_date? $customer->subscription_end_date->addMonths(1)->format('d/m/Y'): now()->addMonths(1)->format('d/m/Y') }}
                            @elseif($sub_type == 'year')
                                {{ $customer->subscription_end_date? $customer->subscription_end_date->addMonths(12)->format('d/m/Y'): now()->addMonths(12)->format('d/m/Y') }}
                            @elseif($sub_type == 'six_month')
                                {{ $customer->subscription_end_date? $customer->subscription_end_date->addMonths(6)->format('d/m/Y'): now()->addMonths(6)->format('d/m/Y') }}
                            @endif
                        </p>
                    @endif

                </div>
                <div class="info">
                    <h3>{{ __('dashboard.total') }}</h3>
                    <p>
                        @if ($sub_type == 'month')
                            {{ $package->monthly_price }}$
                        @elseif($sub_type == 'year')
                            {{ $package->year_price }}$
                        @elseif($sub_type == 'six_month')
                            {{ $package->six_month_price }}$
                        @endif
                    </p>
                </div>
            </div>

            <div class="info-box card">
                <div class="info">
                    <h3>{{ __('dashboard.payment_method') }}</h3>
                    <p>Paypal</p>
                </div>
            </div>
            <div id="paypal-button-container" class="paypal-button-container"></div>
        </div>

        <div class="col-xl-6">

        </div>

    </section>

    @push('js')
        <script>
            var routes = [];
            routes['cart'] = `{{ route('pricing') }}`;
            routes['successPayment'] = `{{ route('success-payment-page') }}`;
            routes['createTransaction'] = `{{ route('create-transaction') }}`;
            routes['captureTransaction'] = `{{ route('capture-transaction', ['id' => 'transactionID']) }}`;
        </script>
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&locale={{ App::isLocale('en') ? 'en_US' : 'ar_AR' }}&currency=USD&debug=true&enable-funding=paypal">
        </script>
        <script type="text/javascript" src="{{ asset('js/payment/payment-paypal.js') }}"></script>
    @endpush
@endsection
