@php
    $user = auth()->user();
@endphp

{{-- Desktop Sidebar --}}
<nav class="col-lg-2 d-none d-lg-block sidebar text-white p-0">

    {{-- <h4 class="text-center py-4">
        <i class="fa fa-graduation-cap"></i> AmazingTrack
    </h4> --}}

    {{-- Sidebar Brand --}}
    {{-- <div class="text-center py-4 sidebar-brand">

        <img src="{{ asset('logo/logo.png') }}"
            alt="University Logo"
            class="sidebar-logo">

        <div class="sidebar-system-name">
            AmazingTrack
        </div>

    </div> --}}

        <div class="sidebar-brand flex-column text-center">

        <img src="{{ asset('logo/logo.png') }}"
            alt="University Logo"
            class="sidebar-logo">

        <h4 class="mt-2">
            AmazingTrack
        </h4>

    </div>

    {{-- Dashboard (All roles) --}}
    {{-- <a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa fa-home me-2"></i> Dashboard
    </a> --}}


    {{-- Vice Chancellor --}}
    @if($user?->role == 'vc')

        <a href="{{ route('vc.dashboard') }}" class="{{ Request::routeIs('vc.dashboard*') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('vc.calendar') }}" class="{{ Request::routeIs('vc.calendar*') ? 'active' : '' }}">
            <i class="fa fa-chart-line me-2"></i> Calendar
        </a>

        <a href="{{ route('vc.programs') }}" class="{{ Request::routeIs('vc.programs*') ? 'active' : '' }}">
            <i class="fa fa-calendar me-2"></i> All Programs
        </a>

        <a href="{{ route('vc.weekend-staff') }}" class="{{ Request::routeIs('vc.weekend-staff') ? 'active' : '' }}">
            <i class="fa fa-calendar-week"></i> Weekend Staff
        </a>

        <a href="{{ route('vc.non-weekend-staff') }}" class="{{ Request::routeIs('vc.non-weekend-staff') ? 'active' : '' }}">
            <i class="fa fa-user-times"></i> No Weekend Staff
        </a>

        <a href="{{ route('vc.reports') }}" class="{{ Request::routeIs('vc.reports*') ? 'active' : '' }}">
            <i class="fa fa-file-alt me-2"></i> Amazing Reports
        </a>

        <a href="{{ route('vc.gallery') }}" class="{{ Request::routeIs('vc.gallery') ? 'active' : '' }}">
            <i class="fa fa-image me-2"></i> Amazing Gallery
        </a>

    @endif 


    {{-- Admin --}}
    {{-- @if(auth()->user()->role == 'admin') --}}
    {{-- Super Admin --}}
    @if(Auth::guard('admin')->check())

        <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard*') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('admin.staff.index') }}" class="{{ Request::routeIs('admin.staff*') ? 'active' : '' }}">
            <i class="fa fa-user-tie me-2"></i> Staff Management
        </a>

         {{-- <a href="{{ route('admin.users.index') }}" class="{{ Request::routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fa fa-user-shield me-2"></i> Roles Access Management
        </a> --}}

        <a href="{{ route('admin.users.index') }}" class="{{ Request::routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fa fa-key me-2"></i> System Users Management
        </a>

        <a href="{{ route('admin.departments.index') }}" class="{{ Request::routeIs('admin.departments*') ? 'active' : '' }}">
            <i class="fa fa-building me-2"></i> Departments Management
        </a>

        <a href="{{ route('admin.programs.index') }}" class="{{ Request::routeIs('admin.programs*') ? 'active' : '' }}">
            <i class="fa fa-calendar-check me-2"></i> Programs Management
        </a>



    @endif


    {{-- Programme Secretariat --}}
    {{-- @if(auth()->user()->role == 'hd') --}}
    @if(in_array($user?->role, ['hd','az']))

        <a href="{{ route('head.dashboard') }}" class="{{ Request::routeIs('head.dashboard*') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('head.staff.index') }}" class="{{ Request::routeIs('head.staff*') ? 'active' : '' }}">
            <i class="fa fa-users me-2"></i> Department Staff
        </a>

        <a href="{{ route('head.calendar.index') }}" class="{{ Request::routeIs('head.calendar*') ? 'active' : '' }}">
             <i class="fa fa-calendar-alt me-2"></i> Calendar
        </a>

        {{-- FAEYZAN - ADD INDEX TO SO HOVER NOT DUPLICATE 14.05.2026 --}}
        <a href="{{ route('head.programs.index') }}" class="{{ Request::routeIs('head.programs.index') ? 'active' : '' }}">
            <i class="fa fa-calendar-check me-2"></i> My Programs
        </a>

        {{-- <a href="{{ route('head.committee.index', $program->id) }}" class="{{ Request::routeIs('head.committee*') ? 'active' : '' }}">
            <i class="fa fa-users-gear me-2"></i> Manage Committee
        </a> --}}

        <a href="{{ route('head.programs.committee') }}" class="{{ Request::routeIs('head.programs.committee*') ? 'active' : '' }}">
            <i class="fa fa-users-gear"></i> Programs & Committee
        </a>
        
        @if($user?->role === 'az')  {{-- Only show to AZ --}}
        <a href="{{ route('head.merit-claims') }}" class="{{ Request::routeIs('head.merit-claims*') ? 'active' : '' }}">
            <i class="fa fa-trophy me-2"></i> Amazing Merit Claims
        </a>
        @endif

    @endif

    {{-- Head of Department --}}
    {{-- @if($user?->role == 'ld') --}}
    @if(in_array($user?->role, ['ld','dv','rd','bs','dc']))

        <a href="{{ route('leader.overview') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.overview') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('leader.dashboard', ['tab' => 'programs']) }}" class="d-block text-white mb-3 {{ request('tab') === 'programs' ? 'active' : '' }}">
            <i class="fa fa-calendar-check me-2"></i> My Programs
        </a>

        <a href="{{ route('leader.calendar.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.calendar.*') ? 'active' : '' }}">
            <i class="fa fa-calendar-days me-2"></i> Calendar
        </a>

        <a href="{{ route('leader.departments.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.departments.*') ? 'active' : '' }}">
            <i class="fa fa-building me-2"></i> My Departments
        </a>

        <a href="{{ route('leader.staff.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.staff.*') ? 'active' : '' }}">
            <i class="fa fa-address-book me-2"></i> Staff Directory
        </a>

        <a href="{{ route('leader.dashboard', ['tab' => 'reports']) }}" class="d-block text-white mb-3 {{ request('tab') === 'reports' ? 'active' : '' }}">
            <i class="fa fa-chart-column me-2"></i> Monthly Report
        </a>

        <a href="{{ route('leader.dashboard', ['tab' => 'weekend']) }}" class="d-block text-white mb-3 {{ request('tab') === 'weekend' ? 'active' : '' }}">
            <i class="fa fa-people-roof me-2"></i> Weekend Staff
        </a>

        {{-- <a href="{{ route('leader.notifications.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.notifications.*') ? 'active' : '' }}">
            <i class="fa fa-bell me-2"></i> Notifications
            @if(($unreadNotifCount ?? 0) > 0)
                <span class="badge bg-danger rounded-pill ms-1">{{ $unreadNotifCount }}</span>
            @endif
        </a> --}}

    @endif

</nav>


{{-- Mobile Sidebar (Offcanvas) --}}
<div class="offcanvas offcanvas-start text-bg-dark d-lg-none" id="mobileSidebar">

    <div class="offcanvas-header">
        {{-- <h5>
            <i class="fa fa-graduation-cap"></i> AmazingTrack
        </h5> --}}

        <div class="text-center w-100">

            <img src="{{ asset('logo/logo.png') }}"
                alt="University Logo"
                style="width:50px; margin-bottom:6px;">

            <div style="font-weight:700;">
                AmazingTrack
            </div>

        </div>

        <button class="btn-close btn-close-white"
                data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body">

        {{-- <a href="{{ route('dashboard') }}" class="d-block text-white mb-3 {{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a> --}}


        {{-- Vice Chancellor --}}
        @if($user?->role == 'vc')

            <a href="{{ route('vc.dashboard') }}" class="d-block text-white mb-3 {{ Request::routeIs('vc.dashboard*') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i> Dashboard
            </a>

            <a href="{{ route('vc.calendar') }}" class="d-block text-white mb-3 {{ Request::routeIs('vc.calendar*') ? 'active' : '' }}">
                <i class="fa fa-chart-line me-2"></i> Calendar
            </a>

            <a href="{{ route('vc.programs') }}" class="d-block text-white mb-3 {{ Request::routeIs('vc.programs*') ? 'active' : '' }}">
                <i class="fa fa-calendar me-2"></i> All Programs
            </a>

            <a href="{{ route('vc.non-weekend-staff') }}" class="{{ Request::routeIs('vc.non-weekend-staff') ? 'active' : '' }}">
                <i class="fa fa-calendar-week"></i> Non-Weekend Staff
            </a>

            <a href="{{ route('vc.non-weekend-staff') }}" class="d-block text-white mb-3 {{ Request::routeIs('vc.non-weekend-staff*') ? 'active' : '' }}">
                <i class="fa fa-user-times me-2"></i> Non-Weekend Staff
            </a>

            <a href="{{ route('vc.reports') }}" class="d-block text-white mb-3 {{ Request::routeIs('vc.reports*') ? 'active' : '' }}">
                <i class="fa fa-file-alt me-2"></i> Amazing Reports
            </a>

            <a href="{{ route('vc.gallery') }}" class="d-block text-white mb-3 {{ Request::routeIs('vc.gallery') ? 'active' : '' }}">
                <i class="fa fa-image me-2"></i> Amazing Gallery
            </a>

        @endif


        {{-- Admin --}}
        {{-- @if(auth()->user()->role == 'admin') --}}

        {{-- Super Admin --}}
        @if(Auth::guard('admin')->check())

            <a href="{{ route('admin.dashboard') }}" class="d-block text-white mb-3 {{ Request::routeIs('admin.dashboard*') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i> Dashboard
            </a>

            <a href="{{ route('admin.staff.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('admin.staff*') ? 'active' : '' }}">
                <i class="fa fa-user-tie me-2"></i> Staff Management
            </a>

            <a href="{{ route('admin.users.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fa fa-key me-2"></i> System Users Management
            </a>

            <a href="{{ route('admin.departments.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('admin.departments*') ? 'active' : '' }}">
                <i class="fa fa-building me-2"></i> Departments Management
            </a>

              <a href="{{ route('admin.programs.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('admin.programs*') ? 'active' : '' }}">
                <i class="fa fa-calendar-check me-2"></i> Programs Management
            </a>

        @endif


        {{-- Programme secretariat --}}
        {{-- @if(auth()->user()->role == 'hd') --}}
        @if(in_array($user?->role, ['hd','az']))

            <a href="{{ route('head.dashboard') }}" class="d-block text-white mb-3 {{ Request::routeIs('head.dashboard*') ? 'active' : '' }}">
                <i class="fa fa-users me-2"></i> Dashboard
            </a>
            <a href="{{ route('head.staff.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('head.staff*') ? 'active' : '' }}">
                <i class="fa fa-users me-2"></i> Department Staff
            </a>

            <a href="{{ route('head.calendar.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('head.calendar*') ? 'active' : '' }}">
                <i class="fa fa-calendar-alt me-2"></i> Calendar
            </a>

            <a href="{{ route('head.programs.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('head.programs*') ? 'active' : '' }}">
                <i class="fa fa-calendar-check me-2"></i> My Programs
            </a>

            <a href="{{ route('head.programs.committee') }}" class="d-block text-white mb-3 {{ Request::routeIs('head.programs.committee*') ? 'active' : '' }}">
                <i class="fa fa-users-gear me-2"></i> Manage Committee
            </a>

            @if($user?->role === 'az')
                <a href="{{ route('head.merit-claims') }}"
                class="d-block text-white mb-3 {{ Request::routeIs('head.merit-claims*') ? 'active' : '' }}">
                    <i class="fa fa-trophy me-2"></i>
                    Amazing Merit Claims
                </a>
            @endif

        @endif

        

        {{-- Head of Department --}}
        {{-- @if($user?->role == 'ld') --}}
        @if(in_array($user?->role, ['ld','dv','rd','bs','dc']))

            <a href="{{ route('leader.dashboard') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.dashboard*') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i> Dashboard
            </a>

            <a href="{{ route('leader.dashboard', ['tab' => 'programs']) }}" class="d-block text-white mb-3 {{ request('tab') === 'programs' ? 'active' : '' }}">
                <i class="fa fa-calendar-check me-2"></i> My Programs
            </a>

            <a href="{{ route('leader.calendar.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.calendar.*') ? 'active' : '' }}">
                <i class="fa fa-calendar-days me-2"></i> Calendar
            </a>

            <a href="{{ route('leader.departments.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.departments.*') ? 'active' : '' }}">
                <i class="fa fa-building me-2"></i> My Departments
            </a>

            <a href="{{ route('leader.staff.index') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.staff.*') ? 'active' : '' }}">
                <i class="fa fa-address-book me-2"></i> Staff Directory
            </a>

            <a href="{{ route('leader.dashboard', ['tab' => 'reports']) }}" class="d-block text-white mb-3 {{ request('tab') === 'reports' ? 'active' : '' }}">
                <i class="fa fa-chart-column me-2"></i> Monthly Report
            </a>

            <a href="{{ route('leader.dashboard', ['tab' => 'weekend']) }}" class="d-block text-white mb-3 {{ request('tab') === 'weekend' ? 'active' : '' }}">
                <i class="fa fa-people-roof me-2"></i> Weekend Staff
            </a>



            {{-- <a href="{{ route('leader.programs') }}" class="d-block text-white mb-3 {{ Request::routeIs('leader.programs*') ? 'active' : '' }}">
                <i class="fa fa-calendar-check me-2"></i> My Program Reports
            </a> --}}
        @endif

    </div>
</div>