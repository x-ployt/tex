@extends('layout')
@section('title', 'Salveowell Delivery')
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Salveowell Delivery</li>
</ol>

<div class="table-container card card-outline">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
        <h4 class="text-primary-color fw-bold text-capitalize">Salveowell Deliveries</h4>
        <input type="text" id="searchOrder" class="form-control mb-2" placeholder="Search Order No.">
        {{-- Status --}}
        @include('navigation.delivery.select-status')
    </div>  
    <div>
        <div>
            <div class="row">
                @foreach ($orders as $order)
                    @php
                        $orderDate = strtotime($order->order_date);
                        $currentDate = strtotime(now());
                        $dateDiff = floor(($currentDate - $orderDate) / (60 * 60 * 24));
                        
                        if ($order->order_status === 'Cancelled') {
                            $bg = 'bg-danger';
                        } elseif ($order->order_status === 'Delivered') {
                            $bg = 'bg-success';
                        } elseif ($dateDiff >= 3) {
                            $bg = 'bg-warning';
                        } elseif ($order->order_status === 'For Delivery') {
                            $bg = 'bg-primary';
                        } elseif ($order->order_status === 'Re-Schedule Delivery') {
                            $bg = 'bg-orange';
                        } else {
                            $bg = '';
                        }

                    @endphp
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill position-relative">
                            @if ($order->order_status != 'Delivered' && $order->order_status != 'RTS')
                                @if ($dateDiff >= 3)
                                    <div class="ribbon-wrapper ribbon-lg">
                                        <div class="ribbon bg-danger text-md">
                                            {{ $dateDiff }} Days Due
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div class="card-header {{ $bg }} border-bottom-0">
                                    Order # {{ $order->order_no }}
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <h2 class="lead mt-2"><b>{{ $order->customer_name }}</b></h2>
                                    <p class="text-muted text-sm">
                                        <b>Address:</b> {{ $order->customer_address }}
                                    </p>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> 
                                            Contact Number: {{ $order->customer_contact_number }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-peso-sign"></i></span> 
                                            Amount: {{ number_format((float) str_replace(',', '', $order->order_amount), 2) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-handshake-angle"></i></span> 
                                            Mode of Payment: {{ $order->order_mop }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-box"></i></span> 
                                            Status: {{ ucfirst($order->order_status) }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-calendar"></i></span> 
                                            Order Date: {{ date("D, M j, Y", $orderDate) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <x-view-button id="viewBtn{{ $order->id }}" class="extra-class" route="{{ route('delivery.view', $order) }}" title="View Order Details"/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#searchOrder').on('keyup', function () {
            let searchValue = $(this).val();

            $.ajax({
                url: "{{ route('delivery.index') }}",
                type: "GET",
                data: { search: searchValue },
                success: function (response) {
                    let orders = response.orders;
                    let ordersContainer = $('.row');
                    ordersContainer.html('');

                    if (orders.length > 0) {
                        orders.forEach(order => {
                            let orderDate = new Date(order.order_date);
                            let currentDate = new Date();
                            let timeDiff = currentDate - orderDate;
                            let dateDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

                            let bgClass = '';
                            let ribbonHtml = '';

                            if (order.order_status === 'Cancelled') {
                                bgClass = 'bg-danger';
                            } else if (order.order_status === 'Delivered') {
                                bgClass = 'bg-success';
                            } else if (dateDiff >= 3) {
                                bgClass = 'bg-warning';
                            } else if (order.order_status === 'For Delivery') {
                                bgClass = 'bg-primary';
                            } else if (order.order_status === 'Re-Schedule Delivery') {
                                bgClass = 'bg-orange';
                            }

                            if (dateDiff >= 3 && order.order_status !== 'Delivered' && order.order_status !== 'Cancelled') {
                                ribbonHtml = `<div class="ribbon-wrapper ribbon-lg">
                                                <div class="ribbon bg-danger text-md">${dateDiff} Days Due</div>
                                            </div>`;
                            }

                            let formattedDate = orderDate.toLocaleDateString('en-US', {
                                weekday: 'short', month: 'short', day: 'numeric', year: 'numeric'
                            });

                            let orderHtml = `
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                    <div class="card bg-light d-flex flex-fill position-relative">
                                        ${ribbonHtml}
                                        <div class="card-header ${bgClass} border-bottom-0">
                                            Order # ${order.order_no}
                                        </div>
                                        <div class="card-body pt-0">
                                            <h2 class="lead mt-2"><b>${order.customer_name}</b></h2>
                                            <p class="text-muted text-sm"><b>Address:</b> ${order.customer_address}</p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Contact Number: ${order.customer_contact_number}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-peso-sign"></i></span> Amount: ${parseFloat(order.order_amount.replace(/,/g, '')).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-handshake-angle"></i></span> Mode of Payment: ${order.order_mop}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-box"></i></span> Status: ${order.order_status}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar"></i></span> Order Date: ${formattedDate}</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <x-view-button class="extra-class" route="/deliveries/${order.id}" title="View Order Details"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;

                            ordersContainer.append(orderHtml);
                        });
                    } else {
                        ordersContainer.html('<p class="text-center w-100">No orders found.</p>');
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection