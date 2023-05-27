<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link" href="/profile">
            <i class="bi bi-grid"></i>
            <span>{{__('dashboard.Dashboard')}}</span>
        </a>
    </li>

    <li class="nav-item ">
        <a class="nav-link  collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#"  aria-expanded="true" >
            <i class="bi bi-person"></i><span>{{__('dashboard.Profile')}}</span><i class="bi bi-chevron-down @if(app()->isLocale('en'))ms-auto @else me-auto @endif"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
                <a href="{{route('dashboard.change_email_view')}}" target="_blank" class="{{ (\Request::route()->getName() == 'dashboard.change_email_view') ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>{{__('dashboard.Change Email Address')}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard.change_password_view')}}" target="_blank" class="{{ (\Request::route()->getName() == 'dashboard.change_password_view') ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>{{__('dashboard.Change Password')}}</span>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard.change_personal_info_view')}}" target="_blank" class=" {{ (\Request::route()->getName() == 'dashboard.change_personal_info_view') ? 'active' : '' }}">
                    <i class="bi bi-circle"></i><span>{{__('dashboard.Change Profile Info')}}</span>
                </a>
            </li>
        </ul>
    </li>

</ul>