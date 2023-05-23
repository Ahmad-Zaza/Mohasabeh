@extends('dashboard.layouts.master')
@section('content')

<div class="pagetitle">
    <h1>{{__('dashboard.Change Personal Information')}}</h1>


</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form>
                        <div class="row mb-3">
                            <label for="inputFirstName" class="col-sm-2 col-form-label">{{__('dashboard.First Name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputFirstName">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputLastName" class="col-sm-2 col-form-label">{{__('dashboard.Last Name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputLastName">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputCompany" class="col-sm-2 col-form-label">{{__('dashboard.Company')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCompany">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputCompany" class="col-sm-2 col-form-label">{{__('dashboard.Phone')}}</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" id="inputPhone">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputAddress" class="col-sm-2 col-form-label">{{__('dashboard.Address')}}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputAddress">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="button w-25"> {{__('dashboard.Save')}}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</section>
@endsection