@extends('dashboard.layouts.master')
@section('content')

<div class="pagetitle">
    <h1>{{__('dashboard.Change Email Address')}}</h1>


</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>


                    <form>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">{{__('dashboard.Email')}}</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">{{__('dashboard.Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="button w-25"> {{__('dashboard.Change Email')}}</button>
                        </div>
                    </form>

                </div>
            </div>
            
        </div>

    </div>
</section>
@endsection