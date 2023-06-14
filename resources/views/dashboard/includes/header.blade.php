<div class="d-flex align-items-center justify-content-between">
    <a href="{{ URL('/') }}" class="navbar-brand main">
        <img width="150" src="{{ asset($settings['logo']) }}" alt="CloudSellPOS" loading="lazy">
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
</div>

<nav class="navbar  navbar-expand-lg header-nav @if (app()->isLocale('en')) ms-auto @else me-auto @endif">


    <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <span class="d-md-block dropdown-toggle ps-2">{{ Config::get('languages')[App::getLocale()] }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                @foreach (Config::get('languages') as $lang => $language)
                    @if ($lang != App::getLocale())
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('lang.switch', $lang) }}"> <i
                                class="bi bi-twitch"></i> {{ $language }}</a>
                    @endif
                @endforeach
            </ul>
        </li>
        <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <span class="d-md-block dropdown-toggle ps-2">{{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <a class="dropdown-item d-flex align-items-center" href="{{ URL('profile/logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ __('dashboard.sign_out') }}</span>
                </a>
            </ul>
        </li>

    </ul>
</nav>
