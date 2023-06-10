@extends('dashboard.layouts.master')
@section('content')
    @php
        $customer = App\Http\Models\Customer::where('id', auth()->user()->id)->first();
        $package = null;
        if ($customer->package_id) {
            $pcackage = App\PricePkg::where('id', $customer->package_id);
        }
    @endphp

        <div class="pagetitle">
              <h1>{{  __('dashboard.dashboard')  }}</h1>
              <nav>
                    <ol class="breadcrumb">
                    </ol>
              </nav>
        </div>

    <section class="section dashboard">
        <div class="row">
            <div class="">
                <div class="col-md-8">
                    <div class="card info-card host-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}<span>
                                </span> </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-link"></i>
                                </div>
                                <div class="box">
                                    <a href="{{ auth()->user()->host_link }}" target="_blank">
                                        <h6>{{ auth()->user()->host_link }} </h6>
                                    </a>
                                    @if (auth()->user()->is_free_trial)
                                        <span class="text-muted small pt-2 ps-1">{{ __('dashboard.free_trail_ends_at') }}
                                            {{ auth()->user()->free_trial_end_date }}</span>
                                    @else
                                        <span class="text-muted small pt-2 ps-1">{{ __('dashboard.subscription_ends_at') }}
                                            {{ auth()->user()->subscription_end_date }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="action-buttons">
                            @if ($pcackage)
                                <a class="card-link" href="{{ URL('profile/checkout') }}">
                                    {{ __('dashboard.renew') }}
                                </a>
                            @else
                                <a class="card-link" href="{{ URL('pricing') }}">
                                    {{ __('dashboard.upgrade') }}
                                </a>
                            @endif
                            <a class="card-link deleteAccount" data-target="#deleteAccountModel" data-toggle="modal"
                                id="deleteAccount" href="">
                                {{ __('dashboard.delete_account') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteAccountModel" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Are you sure ?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ __('dashboard.are_you_sure') }} </div>
                            <div class="modal-footer">
                                <button id="confirmDeleteAccount" type="button" class="button">{{ __('dashboard.delete_account') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-md-4">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('dashboard.customers_count') }}<span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="box card-box ">
                                        <p>{{ auth()->user()->customer_report->allowed_clients_count == -1 ? auth()->user()->customer_report->used_clients_count . '/' . __('dashboard.unlimited') : auth()->user()->customer_report->used_clients_count . '/' . auth()->user()->customer_report->allowed_clients_count }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-4">
                        <div class="card info-card inventories-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('dashboard.inventories_count') }} <span></span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-list-ol "></i>
                                    </div>
                                    <div class="box card-box ">
                                        <p>{{ auth()->user()->customer_report->allowed_inventories_count == -1 ? auth()->user()->customer_report->used_inventories_count . '/' . __('dashboard.unlimited') : auth()->user()->customer_report->used_inventories_count . '/' . auth()->user()->customer_report->allowed_inventories_count }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-4">
                        <div class="card info-card currencies-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('dashboard.currencies_count') }} <span></span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-exchange"></i>
                                    </div>
                                    <div class="box card-box ">
                                        <p>{{ auth()->user()->customer_report->allowed_currencies_count == -1 ? auth()->user()->customer_report->used_currencies_count . '/' . __('dashboard.unlimited') : auth()->user()->customer_report->used_currencies_count . '/' . auth()->user()->customer_report->allowed_currencies_count }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-md-4">
                        <div class="card info-card storage-card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('dashboard.attached_storage_usage') }} </h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-sd-card"></i>
                                    </div>
                                    <div class="box card-box ">
                                        <p>{{ auth()->user()->customer_report->allowed_attachs_size == -1 ? auth()->user()->customer_report->used_attachs_size . 'MB/' . __('dashboard.unlimited') : auth()->user()->customer_report->used_attachs_size . 'MB/' . auth()->user()->customer_report->allowed_attachs_size . 'MB' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".deleteAccount").on("click", function(e) {
                e.preventDefault();
                $('#deleteAccountModel').modal('hide');
                $('#deleteAccountModel').modal('show');
            });

            $("#confirmDeleteAccount").click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.delete_customer') }}",
                    contentType: "application/json",
                    dataType: "json",
                    success: function(res) {
                      console.log(res);
                        // window.location.href = "{{ url('/') }}";
                    }
                });
            })
        });
    </script>
@endpush
