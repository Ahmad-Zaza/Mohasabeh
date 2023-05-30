@extends('dashboard.layouts.master')
@section('content')

<div class="pagetitle">
    <h1>{{__('dashboard.change_email_address')}}</h1>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form class="row g-3" method="POST" action="{{route('dashboard.change_email')}}">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="change-email" placeholder="Your Email">
                                <label >Your Email</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                <label >Password</label>
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection