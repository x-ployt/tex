@extends('layout')
@section('title', 'Salveowell Order')
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Salveowell Order</li>
</ol>

{{-- Data Table --}}
<div class="table-container card card-outline">
    <div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">

        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
            <h4 class="text-primary-color fw-bold text-capitalize">Salveowell Order</h4>
            <div class="ms-auto">
                {{-- Create Button --}}
                <a href="{{ route('order.create') }}" class="btn lightGreenBtn" title="Create Order">
                    <span> <i class="fa-solid fa-plus"></i> Create Order </span>
                </a>
            </div>
        </div>  

        {{-- Date filter --}}
        @include('navigation.order.date-filter')

        {{-- Select status --}}
        {{-- @include('navigation.order.select-status') --}}

        <table id="data_table" class="table table-bordered table-sm table-striped">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Order No.</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Amount</th>
                    <th>MOP</th>
                    <th>Branch</th>
                    <th>Rider</th>
                    <th>Status</th>
                    <th>Dispatched Date</th>
                    <th>Order Updated</th>
                    <th>Remarks</th>
                    <th class="action" style="width: 50px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ date("Y-m-d", strtotime($order->order_date)) }}</td>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td title="{{ $order->customer_address }}">
                            {{ \Illuminate\Support\Str::limit($order->customer_address, 50, '...') }}
                        </td>
                        <td>{{ $order->customer_contact_number }}</td>
                        <td>{{ number_format((float) str_replace(',', '', $order->order_amount), 2) }}</td>
                        <td>{{ $order->order_mop }}</td>
                        <td>{{ $order->branch->branch_name }}</td>
                        <td>{{ $order->assignedUser->name }}</td>
                        <td>
                            <span class="badge 
                                @if($order->order_status === 'Re-Schedule Delivery') bg-warning 
                                @elseif($order->order_status === 'For Delivery') bg-primary 
                                @elseif($order->order_status === 'Delivered') bg-success 
                                @elseif($order->order_status === 'RTS') bg-danger 
                                @endif">
                                {{ $order->order_status }}
                            </span>
                        </td>
                        <td>{{ date("Y-m-d", strtotime($order->created_at)) }}</td>
                        <td>
                            @if ($order->created_at == $order->updated_at)
                                No updates
                            @else
                                {{ date("Y-m-d", strtotime($order->updated_at)) }}
                            @endif
                        </td>
                        <td>
                            {{ optional($order->orderHistory->sortByDesc('created_at')->first())->delivery_remarks ?? 'N/A' }}
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
</div>

{{-- Scripts --}}
@push('scripts')
<script>
    $(document).ready(function() {
        new DataTable('#data_table', {
            lengthMenu: [10, 25, 50, 100], 
            pageLength: 10,
            columnDefs: [
                { orderable: false, targets: [13] }, 
                { width: "auto", targets: '_all' },
                { className: 'text-center', targets: '_all' }
            ],
            fixedHeader: true,
            dom: '<"top d-flex justify-content-between mt-2 mb-2"<"d-flex"lB><"ml-auto"f>>rt<"bottom"ip><"clear">', 
            buttons: [
                {
                    extend: 'excel',
                    text: 'Export as Excel',
                    className: 'ml-3 btn btn-sm greenBtn',
                    exportOptions: {
                        columns: ':not(:last-child)',
                        format: {
                            body: function (data, row, column, node) {
                                if ($(node).find('span').length) {
                                    return $(node).find('span').text().trim();
                                }
                                return node.hasAttribute('title') ? node.getAttribute('title') : data;
                            }
                        }
                    }
                }
            ]
        });
    });
</script>
@endpush
@endsection
