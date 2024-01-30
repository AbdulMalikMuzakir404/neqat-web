<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-neqat-banner.jpg') }}" alt="logo-neqat-banner" style="width: 50%">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo-neqat-icon.png') }}" alt="logo-neqat-banner" style="width: 50%">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ (Request::segment(1) == 'home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fire"></i><span>Home</span>
                </a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://docs-neqat.vercel.app/pages/documentation/what-is-neqat" target="_blank" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
