{{-- Sidebar menu --}}
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        
        {{-- Dashboard --}}
        @include('include.sidebar-menu.dashboard')

        {{-- SuperAdmin Sidebar --}}
        @if(Auth::user()->role->role_name == 'SuperAdmin')
            @include('include.sidebar-menu.branch')
            @include('include.sidebar-menu.employee-maintenance')
            @include('include.sidebar-menu.order')

        {{-- Admin Sidebar --}}
        @elseif(Auth::user()->role->role_name == 'Admin')
            @include('include.sidebar-menu.order')
            @include('include.sidebar-menu.employee-maintenance')

        {{-- Rider Sidebar --}}
        @elseif(Auth::user()->role->role_name == 'Rider')
            @include('include.sidebar-menu.delivery')
        @endif
    </ul>
</nav>

