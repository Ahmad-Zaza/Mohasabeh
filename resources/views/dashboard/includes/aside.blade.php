<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link" href="/profile">
            <i class="bi bi-grid"></i>
            <span>{{__('dashboard.dashboard')}}</span>
        </a>
    </li>

    <li class="nav-item ">
        <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#" aria-expanded="true">
            <i class="bi bi-person"></i><span>{{__('dashboard.profile')}}</span><i class="bi bi-chevron-down @if(app()->isLocale('en'))ms-auto @else me-auto @endif"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse {{ (\Request::route()->getName() == ('dashboard.change_password_view'||'dashboard.change_personal_info_view')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">

            <li>
                <a href="{{route('dashboard.change_password_view')}}" class="{{ (\Request::route()->getName() == 'dashboard.change_password_view') ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>{{__('dashboard.change_password')}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard.change_personal_info_view')}}" class=" {{ (\Request::route()->getName() == 'dashboard.change_personal_info_view') ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>{{__('dashboard.change_profile_info')}}</span>
                </a>
            </li>
        </ul>
    </li>

</ul>