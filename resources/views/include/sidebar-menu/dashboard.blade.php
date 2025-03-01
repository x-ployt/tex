{{-- Dashboard --}}
<li class="nav-item">
    <a href="{{route('dashboard')}}" class="nav-link {{ Str::contains(Request::url(), '/salveowell-dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-fw fa-chart-simple" style="color: #fda720;"></i>
        <p style="margin-left: 2px;">Dashboard</p>
    </a>
</li>