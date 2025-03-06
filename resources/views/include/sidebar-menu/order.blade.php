{{-- Order --}}
<li class="nav-item">
    <a href="{{route('order.index')}}" class="nav-link {{ Str::contains(Request::url(), '/orders') ? 'active' : '' }}">
        <i class="fa-solid fa-fw fa-box" style="color: #fda720;"></i>
        <p style="margin-left: 2px;">Order</p>
    </a>
</li>