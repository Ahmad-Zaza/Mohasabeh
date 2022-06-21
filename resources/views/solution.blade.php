@extends('layouts.app')

@section('content')
    <div id="features" class="features">
        <div class="container-m">
            <div class="row text-center">
                <div class="col-md-12">
                    <div class="features-intro">
                        <h2>{{ $solution["name_$lang"] }}</h2>
                        <p>{{ $solution["description_$lang"] }}</p>
                    </div>
                </div>
                @foreach ($solution->modules as $item)
                    <div class="col-sm-6 col-lg-4 allHeight">
                        <div class="feature-list allHeight mb-0">
                            <div class="card-icon">
                                <div class="card-img">
                                    <img src="{{ asset($item->image) }}" width="60" alt="Feature" loading="lazy">
                                </div>
                            </div>
                            <div class="card-text">
                                <h3>{{ $item["name_$lang"] }}</h3>
                                @php
                                    $length = strlen($item["description_$lang"]);
                                    if ($length > 30) {
                                        $cutDesc = substr($item["description_$lang"], 0, 30);
                                    } else {
                                        $cutDesc = $item["description_$lang"];
                                    }
                                @endphp
                                <p class="all-desc hide">
                                    {{ $item["description_$lang"] }}
                                    <a type="button" class="lessDescription">.. {{ __('data.less') }}</a>
                                </p>
                                <p class="cut-desc">
                                    {{ $cutDesc }}
                                    <a type="button" class="moreDescription">.. {{ __('data.more') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
