@extends('layout')
@section('title', 'Salveowell Order')
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Salveowell Order</li>
</ol>

{{-- Data Table --}}
<div class="table-container card card-outline">

    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
        <h4 class="text-primary-color fw-bold text-capitalize">Salveowell Order</h4>
        <div class="ms-auto">
            {{-- Create Button --}}
            <a href="{{ route('order.create') }}" class="btn lightGreenBtn" title="Create Order">
                <span> <i class="fa-solid fa-plus"></i> Create Order </span>
            </a>
        </div>
    </div>    

    <table id="data_table" class="table table-bordered table-sm table-striped table-responsive-sm" style="width: 100%;">

        @include('navigation.order.select-status')

        <thead>
            <tr>
                <th>Order No.</th>
                @if (Auth::user()->role->role_name === 'SuperAdmin')
                <th>Branch</th>
                @endif
                <th>Customer Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Amount</th>
                <th>MOP</th>
                <th>Assigned Rider</th>
                <th>Status</th>
                <th class="action" style="width: 50px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_no }}</td>
                    @if (Auth::user()->role->role_name === 'SuperAdmin')
                    <td>{{ $order->branch->branch_name }}</td>
                    @endif
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->customer_address }}</td>
                    <td>{{ $order->customer_contact_number }}</td>
                    <td>{{ number_format($order->order_amount, 2) }}</td>
                    <td>{{ $order->order_mop }}</td>
                    <td>{{ $order->assignedUser->name }}</td>
                    <td>   
                        <span class="badge 
                            @if($order->order_status === 'Re-Schedule Delivery') bg-warning 
                            @elseif($order->order_status === 'For Delivery') bg-primary 
                            @elseif($order->order_status === 'Delivered') bg-success 
                            @elseif($order->order_status === 'Cancelled') bg-danger 
                            @endif">
                            {{ $order->order_status }}
                        </span>
                    </td>
                    <td>
                        {{-- View Button --}}
                        <x-view-button id="viewBtn{{ $order->id }}" class="extra-class" route="{{ route('order.view', $order) }}" title="View Order Details"/>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- Data Table --}}

{{-- Scripts --}}
@push('scripts')

@if (Auth::user()->role->role_name === 'SuperAdmin')
<script>
    $(document).ready(function() {
        new DataTable('#data_table', {
            columnDefs: [
                { orderable: false, targets: [9] }, 
                { width: "auto", targets: '_all' },
                { className: 'text-center', targets: '_all' }
            ],
            fixedHeader: true,
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Export as excel',
                            className: 'btn btn-sm btn-primary', 
                            exportOptions: {
                                modifier: { page: 'current' },
                                columns: ':not(:last-child)' 
                            }
                        }
                    ]
                }
            },
        });
    });
</script>

@else 
<script>
    $(document).ready(function() {
        new DataTable('#data_table', {
            columnDefs: [
                { orderable: false, targets: [8] },
                { width: "auto", targets: '_all' },
                { className: 'text-center', targets: '_all' }
            ],
            fixedHeader: true,
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Export as excel',
                            className: 'btn btn-sm btn-primary', 
                            exportOptions: {
                                modifier: { page: 'current' },
                                columns: ':not(:last-child)' 
                            }
                        }
                    ]
                }
            },
        });
    });
</script>
@endif

@endpush
@endsection
