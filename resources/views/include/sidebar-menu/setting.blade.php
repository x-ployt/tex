{{-- Setting --}}
<li class="nav-item {{ Str::contains(Request::url(), '/setting') ? 'menu-is-opening menu-open' : 'menu-close' }}">
    <a href="#" class="nav-link {{ Str::contains(Request::url(), '/setting') ? 'active' : '' }}">
        <i class="fa-solid fa-fw fa-gear" style="color: #fda720;"></i>
        <p style="margin-left: 2px;">Settings<i class="right fas fa-fw fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        {{-- Employee Role --}}
        <li class="nav-item">
            <a href="{{route('remark.index')}}" class="nav-link {{ Str::contains(Request::url(), '/setting/remarks') ? 'active' : '' }}">
                <i class="fa-solid fa-fw fa-angle-right" style="color: white;"></i>
                <p style="margin-left: 2px;">Remark</p>
            </a>
        </li>
    </ul>
</li>

