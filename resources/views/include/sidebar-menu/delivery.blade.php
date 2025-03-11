{{-- Delivery --}}
<li class="nav-item">
    <a href="{{route('delivery.index')}}" class="nav-link {{ Str::contains(Request::url(), '/deliveries') ? 'active' : '' }}">
        <i class="fa-solid fa-fw fa-building" style="color: #fda720;"></i>
        <p style="margin-left: 2px;">Delivery</p>
    </a>
</li>