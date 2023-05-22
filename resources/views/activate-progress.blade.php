@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/spinner.css') }}">
@php $_left = ($lang=="ar"?"right":"left")@endphp
@section('content')
    <style>
        .footer-sm {
            bottom: 0;
            width: 100%;
        }

        .footer-sm ul li a {
            padding: 17px;
        }
    </style>
    <div class="w-100 container hero pb-0 message-parent relative progress-parent flex align-items-center">
        <div class="w-100 text-center message-cont">
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 100px;">
                {{ __('data.configure_account') }}
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div id="loop" class="loop-center"></div>
                <div id="bike-wrapper" class="loop-center">
                    <div id="bike" class="centerBike"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let customerId = "{{ $customer->id }}";

            let minutes = "{{ env('PROGREE_PERIOD_MINUTES') }}";
            let widthStep = 5;
            let step = minutes * 60 * 5 * 1000 / 100;
            let width = widthStep;
            let nIntervId = setInterval(function() {
                if (width == 100)
                    clearInterval(nIntervId);
                else {
                    width += widthStep;
                    $("#progress-bar").width(width + "%");
                    $("#progress-bar").html(width + "%");
                }
            }, step);

            activateCustomer(customerId);
        })

        function activateCustomer(customerId) {
            $.ajax({
                type: "GET",
                url: "{{ url('activate-customer') }}/" + customerId,
                contentType: "application/json",
                dataType: "json",
                success: function(res) {
                    width = 100;
                    $("#progress-bar").width(width + "%");
                    $("#progress-bar").html(width + "%");
                    $(".message-cont").html(res.message);
                },
                error: function(data) {
                    activateCustomer(customerId);
                }
            });
        }
    </script>
@endsection
