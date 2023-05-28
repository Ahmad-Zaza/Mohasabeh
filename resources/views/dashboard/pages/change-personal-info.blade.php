@extends('dashboard.layouts.master')
@section('content')

<div class="pagetitle">
    <h1>{{__('dashboard.Change Personal Information')}}</h1>
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
                    <form method="POST" action="{{route('dashboard.change_personal_info')}}" class="row g-3">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="first_name" class="form-control  @error('first_name') is-invalid @enderror" id="first_name" value="{{$user->first_name}}" placeholder="{{__('dashboard.First Name')}}">
                                <label for="first_name">{{__('dashboard.First Name')}}</label>

                                @error('first_name')
                                <span class="invalid-feedback">
                                    {{ $errors->first('first_name') }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="last_name" class="form-control  @error('last_name') is-invalid @enderror" id="last_name" value="{{$user->last_name}}" placeholder="{{__('dashboard.Last Name')}}">
                                <label for="last_name">{{__('dashboard.Last Name')}}</label>

                                @error('last_name')
                                <span class="invalid-feedback">
                                    {{ $errors->first('last_name') }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="company" class="form-control  @error('company') is-invalid @enderror" id="company" value="{{$user->company}}" placeholder="{{__('dashboard.Company')}}">
                                <label for="company">{{__('dashboard.Company')}}</label>
                                @error('company')
                                <span class="invalid-feedback">
                                    {{ $errors->first('company') }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="tel" name="phone" class="form-control  @error('phone') is-invalid @enderror" id="phone" value="{{$user->phone}}" placeholder="{{__('dashboard.Phone')}}">
                                <label for="phone">{{__('dashboard.Phone')}}</label>

                                @error('phone')
                                <span class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="text" name="address" class="form-control  @error('address') is-invalid @enderror" id="address" value="{{$user->address}}" placeholder="{{__('dashboard.Address')}}">
                                <label for="address">{{__('dashboard.Address')}}</label>

                                @error('address')
                                <span class="invalid-feedback">
                                    {{ $errors->first('address') }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="button">{{__('dashboard.Save')}}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</section>
@endsection