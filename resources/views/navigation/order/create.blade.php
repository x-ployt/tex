@extends('layout')

@section('title', 'Create Order')
@section('content')

<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">Create Order</li>
</ol>

{{-- Back Button at the Top --}}
<div class="mb-3">
    <a href="{{ route('order.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

{{-- Order Creation Form --}}
<div class="card card-outline details-container">
    <div class="card-header">
        <h3>Create Order</h3>
    </div>
    <div class="card-body">
        {{-- Toggle for Single/Bulk --}}
        <button id="toggleBulkBtn" class="btn yellowBtn mb-3">Switch to Bulk Order</button>
        
        {{-- Single Order Form --}}
        <form action="{{ route('order.store') }}" method="POST" id="singleOrderForm" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="mb-3">
                <label>Order No:</label>
                <input type="text" name="order_no" id="order_no" class="form-control" value="{{ old('order_no') }}" required>
                <x-error-message field="order_no"/>
            </div>

            <div class="mb-3">
                <label>Customer Name:</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                <x-error-message field="customer_name"/>
            </div>

            <div class="mb-3">
                <label>Customer Address:</label>
                <input type="text" name="customer_address" id="customer_address" class="form-control" value="{{ old('customer_address') }}" required>
                <x-error-message field="customer_address"/>
            </div>

            <div class="mb-3">
                <label>Assigned Delivery Rider:</label>
                <select name="assigned_user_id" id="assigned_user_id" class="form-control select2" required>
                    <option value="" selected>Select Rider</option>
                    @foreach ($riders as $rider)
                        <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                    @endforeach
                </select>
                <x-error-message field="assigned_user_id"/>
            </div>

            <div class="mb-3">
                <label>Branch:</label>
                <select name="branch_id" id="branch_id" class="form-control" required>
                    <option value="" selected>Select Branch</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                    @endforeach
                    <x-error-message field="branch_id"/>
                </select>
            </div>

            {{-- Order Status --}}
            <div class="mb-3">
                <label for="order_status" class="form-label">Order Status:</label>
                <select name="order_status" id="order_status" class="form-control">
                    <option value="Processing">Processing</option>
                    <option value="For Delivery" selected>For Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <button type="submit" class="btn greenBtn">Create Order</button>
        </form>

        <form action="{{ route('order.bulkStore') }}" method="POST" id="bulkOrderForm" enctype="multipart/form-data" style="display: none;">
            @csrf
            <div class="mb-3">
                <label>Upload Bulk Orders (CSV or JSON):</label>
                <input type="file" name="bulk_orders" class="form-control" accept=".csv, .json" required>
                <x-error-message field="bulk_orders"/>
            </div>
        
            {{-- Mandatory Rider Selection --}}
            <div class="mb-3">
                <label>Assign Delivery Rider:</label>
                <select name="assigned_user_id" id="assigned_user_id" class="form-control select2" required>
                    <option value="" disabled selected>Select Rider</option>
                    @foreach ($riders as $rider)
                        <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                    @endforeach
                </select>
                <x-error-message field="assigned_user_id"/>
            </div>
        
            <button type="submit" class="btn greenBtn">Upload Bulk Orders</button>
        </form>

    </div>
</div>

{{-- Success Toast Notification --}}
@push('scripts')
@if(session()->has('addSuccess'))
    <script type="module">
        $(function(){
            Toast.fire({
                icon: 'success',
                title: '{{ session('addSuccess') }}'
            });
        });
    </script>
@endif

@if($errors->any())
    <script type="module">
        $(function(){
            Toast.fire({
                icon: 'error',
                title: '{{ $errors->first() }}'
            });
        });
    </script>
@endif

<script>
    document.getElementById('toggleBulkBtn').addEventListener('click', function () {
        let singleForm = document.getElementById('singleOrderForm');
        let bulkForm = document.getElementById('bulkOrderForm');

        if (singleForm.style.display === "none") {
            singleForm.style.display = "block";
            bulkForm.style.display = "none";
            this.textContent = "Switch to Bulk Order";
        } else {
            singleForm.style.display = "none";
            bulkForm.style.display = "block";
            this.textContent = "Switch to Single Order";
        }
    });
</script>

@endpush
@endsection
