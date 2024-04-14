<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home.index') }}">
                <img src="{{ asset('assets/images/logo-neqat-banner.jpg') }}" alt="logo-neqat-banner" style="width: 50%">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home.index') }}">
                <img src="{{ asset('assets/images/logo-neqat-icon.png') }}" alt="logo-neqat-banner" style="width: 50%">
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="{{ Request::segment(1) == 'home' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home.index') }}">
                    <i class="fas fa-fire"></i><span>Home</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu">
            <li class="{{ Request::segment(1) == 'user' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fas fa-users"></i><span>User</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu">
            <li
                class="{{ Request::segment(1) == 'announcement' || Request::segment(1) == 'temporary' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('announcement.index') }}">
                    <i class="fas fa-bullhorn"></i><span>Announcement</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu">
            <li class="{{ Request::segment(1) == 'classroom' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('classroom.index') }}">
                    <i class="fas fa-person-booth"></i><span>Class Room</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu">
            <li class="{{ Request::segment(1) == 'student' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.index') }}">
                    <i class="fas fa-graduation-cap"></i><span>Student</span>
                </a>
            </li>
        </ul>

        <ul class="sidebar-menu">
            <li class="{{ Request::segment(1) == 'attendance' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('attendance.index') }}">
                    <i class="fas fa-list"></i><span>Attendance</span>
                </a>
            </li>
        </ul>

        @if (auth()->check() && auth()->user()->hasRole('developer'))
            <ul class="sidebar-menu">
                <li class="{{ Request::segment(1) == 'logactivity' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('logactivity.index') }}">
                        <i class="fas fa-chart-line"></i><span>Log Activity</span>
                    </a>
                </li>
            </ul>
        @endif

        <ul class="sidebar-menu">
            <li class="{{ Request::segment(1) == 'setting' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('setting.index') }}">
                    <i class="fas fa-toolbox"></i><span>Setting</span>
                </a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://docs-neqat.vercel.app/pages/documentation/what-is-neqat" target="_blank"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
