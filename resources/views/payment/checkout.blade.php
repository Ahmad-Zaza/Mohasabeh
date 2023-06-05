@extends('dashboard.layouts.master')

@section('content')
    <div class="container">
        <h1>Checkout</h1>
        <div class="pricing-container">
            <p>Total Price: <span>{{ $price }} &dollar;</span></p>
            <div id="paypal-button-container" class="paypal-button-container"></div>
        </div>
    </div>
@endsection
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
