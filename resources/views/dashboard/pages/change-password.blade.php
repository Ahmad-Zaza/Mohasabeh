@extends('dashboard.layouts.master')
@section('content')

<div class="pagetitle">
    <h1>{{__('dashboard.Change Password')}}</h1>


</div>
<section class="section">
    <div class="row">
        <div class="col-lg-8">

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ __(session('success')) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif



            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ __(session('error')) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>

                    <form class="row g-3" method="POST" action="{{route('dashboard.change_password')}}">
                        {{ csrf_field() }}
                        <div class="">
                            <div class="form-floating">
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="Current Password">
                                <label>{{__('dashboard.Current Password')}}</label>

                                @error('current_password')
                                <span class="invalid-feedback">
                                    {{ $errors->first('current_password') }}
                                </span>
                                @enderror
                            </div>

                        </div>


                        <div class="">
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="New Password">
                                <label>{{__('dashboard.New Password')}}</label>
                                @error('password')
                                <span class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="">
                            <div class="form-floating">
                                <input type="password" name="password_confirmation " class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password">
                                <label>{{__('dashboard.Confirm Password')}}</label>
                                @error('password_confirmation')
                                <span class="invalid-feedback">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                                @enderror
                            </div>
                        </div>



                        <div class="">
                            <button type="submit" class="button">{{__('dashboard.Change Password')}}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</section>
@endsection