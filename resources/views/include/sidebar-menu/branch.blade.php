{{-- Branch --}}
<li class="nav-item">
    <a href="{{route('branch.index')}}" class="nav-link {{ Str::contains(Request::url(), '/salveowell-branches') ? 'active' : '' }}">
        <i class="fa-solid fa-fw fa-building" style="color: #fda720;"></i>
        <p style="margin-left: 2px;">Branch</p>
    </a>
</li>