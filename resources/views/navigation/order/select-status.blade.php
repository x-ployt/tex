@php
    $currentRoute = 'order.index'; // Default route name
    $selectedStatus = request()->query('order_status', 'all'); 

    // Define button colors based on status
    $statusColors = [
        'Re-Schedule Delivery' => 'btn-warning',
        'For Delivery' => 'btn-primary',
        'Delivered' => 'btn-success',
        'RTS' => 'btn-danger',
        'all' => 'btn-secondary' // Default color
    ];

    $buttonColor = $statusColors[$selectedStatus] ?? 'btn-secondary';
@endphp

<div class="dropdown">
    <button type="button" class="btn btn-sm {{ $buttonColor }} dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span>Status: {{ ucfirst($selectedStatus) }}</span>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item {{ $buttonColor }} {{ $selectedStatus === 'all' ? 'active' : '' }}" href="{{ route($currentRoute, ['order_status' => 'all']) }}">All</a></li>
        <li><a class="dropdown-item {{ $buttonColor }} {{ $selectedStatus === 'Re-Schedule Delivery' ? 'active' : '' }}" href="{{ route($currentRoute, ['order_status' => 'Re-Schedule Delivery']) }}">Re-Schedule Delivery</a></li>
        <li><a class="dropdown-item {{ $buttonColor }} {{ $selectedStatus === 'For Delivery' ? 'active' : '' }}" href="{{ route($currentRoute, ['order_status' => 'For Delivery']) }}">For Delivery</a></li>
        <li><a class="dropdown-item {{ $buttonColor }} {{ $selectedStatus === 'Delivered' ? 'active' : '' }}" href="{{ route($currentRoute, ['order_status' => 'Delivered']) }}">Delivered</a></li>
        <li><a class="dropdown-item {{ $buttonColor }} {{ $selectedStatus === 'RTS' ? 'active' : '' }}" href="{{ route($currentRoute, ['order_status' => 'RTS']) }}">RTS</a></li>
    </ul>
</div>