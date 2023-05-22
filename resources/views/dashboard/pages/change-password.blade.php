@extends('dashboard.layouts.master')
@section('content')

<div class="pagetitle">
    <h1>{{__('dashboard.Change Password')}}</h1>


</div>
<section class="section">
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>


                    <form>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">{{__('dashboard.Current Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="current_password" id="inputPassword">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">{{__('dashboard.New Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="new_password" id="inputNewPassword">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">{{__('dashboard.Confirm Password')}}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirm_password" id="inputConfirmPassword">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="button w-25">{{__('dashboard.Change Password')}}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</section>
@endsection