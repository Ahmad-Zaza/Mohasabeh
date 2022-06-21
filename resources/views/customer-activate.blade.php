@extends('layouts.app')

@section('content')
    <div class="container-m hero pb-0">
        <div class="relative message-parent">
            <div class="activate-message text-center">
                {{ $message }}
            </div>
        </div>
    </div>
@endsection
