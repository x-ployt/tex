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
        <div class="ms-auto">
            {{-- Status --}}
            @include('navigation.delivery.select-status')
        </div>
    </div>  
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">
                @foreach ($orders as $order)
                    @php
                        if($order->order_status === 'Re-Schedule Delivery'){
                            $bg = 'bg-orange';
                        } elseif($order->order_status === 'For Delivery'){
                            $bg = 'bg-primary';
                        } elseif($order->order_status === 'Delivered'){
                            $bg = 'bg-success';
                        } elseif($order->order_status === 'Cancelled'){
                            $bg = 'bg-danger';
                        } else {
                            $bg = '';
                        }
                    @endphp
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
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
                                            Contact Number {{ $order->customer_contact_number }}
                                        </li>
                                        <li class="small">
                                            <span class="fa-li"><i class="fas fa-lg fa-peso-sign"></i></span> 
                                            Amount: {{ number_format($order->order_amount, 2) }}
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
                                            Date: {{ date("D, M j, Y", strtotime($order->created_at)) }}
                                        </li>
                                    </ul>
                                </div>
                                    {{-- <div class="col-5 text-center">
                                        <img src="{{ asset('path_to_default_order_image.jpg') }}" alt="Order Image" class="img-circle img-fluid">
                                    </div> --}}
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
@endsection