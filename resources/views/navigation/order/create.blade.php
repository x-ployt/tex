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

            {{-- Order Date --}}
            <div class="mb-3">
                <label for="order_date" class="form-label">Order Date:<span class="text-danger">*</span></label>
                <input type="text" name="order_date" id="order_date" class="form-control" placeholder="Select Date" value="{{ old('order_date') }}" required>
                <x-error-message field="order_date"/>
            </div>
            
            {{-- Order Number --}}
            <div class="mb-3">
                <label for="order_no" class="form-label">Order No:<span class="text-danger">*</span></label>
                <input type="text" name="order_no" id="order_no" class="form-control" placeholder="Enter Order Number" value="{{ old('order_no') }}" required>
                <x-error-message field="order_no"/>
            </div>

            {{-- Customer Name --}}
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name:<span class="text-danger">*</span></label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Enter Customer Name" value="{{ old('customer_name') }}" required>
                <x-error-message field="customer_name"/>
            </div>

            {{-- Customer Address --}}
            <div class="mb-3">
                <label for="customer_address" class="form-label">Customer Address:<span class="text-danger">*</span></label>
                <input type="text" name="customer_address" id="customer_address" class="form-control" placeholder="Enter Customer Address" value="{{ old('customer_address') }}" required>
                <x-error-message field="customer_address"/>
            </div>

            {{-- Customer Contact Number --}}
            <div class="mb-3">
                <label for="customer_contact_number">Contact Number:<span class="text-danger">*</span></label>
                <input type="text" name="customer_contact_number" id="customer_contact_number" class="form-control" 
                placeholder="Enter Contact Number" 
                pattern="[0-9]+" 
                maxlength="12" 
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                value="{{ old('customer_contact_number') }}" 
                autocomplete="off" required>
            </div>

           {{-- Order Amount --}}
            <div class="mb-3">
                <label for="order_amount">Order Amount:<span class="text-danger">*</span></label>
                <input type="text" name="order_amount" id="order_amount" class="form-control" 
                    placeholder="Enter Order Amount" 
                    pattern="^\d+(\.\d{1,2})?$"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/^(\d*\.\d{2}).*$/, '$1').replace(/^(\d*\.\d*)\./, '$1');"
                    value="{{ old('order_amount') }}" 
                    autocomplete="off" required>
            </div>

            {{-- Order Mode of Payment --}}
            <div class="mb-3">
                <label for="order_mop" class="form-label">MOP:<span class="text-danger">*</span></label>
                <select name="order_mop" id="order_mop" class="form-control">
                    <option value="COD" selected>COD</option>
                    <option value="GCASH">GCASH</option>
                    <option value="Remittance">Remittance</option>
                    <option value="Bank">Bank</option>
                    <option value="Credit/Debit Card">Credit/Debit Card</option>
                    <option value="Xendit">Xendit</option>
                </select>
            </div>

            {{-- Delivery Rider --}}
            <div class="mb-3">
                <label for="assigned_user_id" class="form-label">Assigned Delivery Rider:<span class="text-danger">*</span></label>
                <select name="assigned_user_id" id="assigned_user_id" class="form-control select2" required>
                    <option value="" selected>Select Rider</option>
                    @foreach ($riders as $rider)
                        <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                    @endforeach
                </select>
                <x-error-message field="assigned_user_id"/>
            </div>

            {{-- Branch --}}
            <div class="mb-3">
                <label for="branch_id" class="form-label">Branch:<span class="text-danger">*</span></label>
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
                <label for="order_status" class="form-label">Order Status:<span class="text-danger">*</span></label>
                <select name="order_status" id="order_status" class="form-control">
                    <option value="For Delivery" selected>For Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <option value="RTS">RTS</option>
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
            <button type="submit" class="btn greenBtn">Upload Bulk Orders</button>
        </form>

    </div>
</div>

{{-- Scripts --}}
@push('scripts')

{{-- DatePicker --}}
<script>
    $(document).ready(function() {
        $("#order_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>

{{-- Success Notification --}}
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

{{-- Error Notification --}}
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
