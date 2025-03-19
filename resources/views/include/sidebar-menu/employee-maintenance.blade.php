{{-- Employee Maintenance --}}
<li class="nav-item {{ Str::contains(Request::url(), '/employee-maintenance') ? 'menu-is-opening menu-open' : 'menu-close' }}">
    <a href="#" class="nav-link {{ Str::contains(Request::url(), '/employee_maintenance') ? 'active' : '' }}">
        <i class="fa-solid fa-fw fa-user-gear" style="color: #fda720;"></i>
        <p style="margin-left: 2px;">Employee<i class="right fas fa-fw fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        @if (Auth::user()->role->role_name === 'SuperAdmin')
            {{-- Employee Role --}}
            <li class="nav-item">
                <a href="{{route('role.index')}}" class="nav-link {{ Str::contains(Request::url(), '/employee-maintenance/roles') ? 'active' : '' }}">
                    <i class="fa-solid fa-fw fa-angle-right" style="color: white;"></i>
                    <p style="margin-left: 2px;">Roles</p>
                </a>
            </li>
            {{-- Employee Account --}}
            <li class="nav-item">
                <a href="{{route('account.index')}}" class="nav-link {{ Str::contains(Request::url(), '/employee-maintenance/accounts') ? 'active' : '' }}">
                    <i class="fa-solid fa-fw fa-angle-right" style="color: white;"></i>
                    <p style="margin-left: 2px;">Account</p>
                </a>
            </li>
        @elseif(Auth::user()->role->role_name === 'Admin')
            {{-- Employee Account --}}
            <li class="nav-item">
                <a href="{{route('account.index')}}" class="nav-link {{ Str::contains(Request::url(), '/employee-maintenance/accounts') ? 'active' : '' }}">
                    <i class="fa-solid fa-fw fa-angle-right" style="color: white;"></i>
                    <p style="margin-left: 2px;">Account</p>
                </a>
            </li>
        @endif
    </ul>
</li>

