@extends('layout') {{-- including layout.blade.php --}}
@section('title', 'View Employee Account') {{-- changing title of the page --}}
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Employee Maintenance</li>
    <li class="breadcrumb-item"><a href="{{ route('account.index') }}">Employee Account</a></li>
    <li class="breadcrumb-item active">View Employee Account</li>
</ol>

{{-- Back Button at the Top --}}
<div class="mb-3">
    <a href="{{ route('account.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

{{-- Employee Account Details Display --}}
<div class="card card-outline details-container">
    <div class="card-header">
        <h3>Employee Account Details</h3>
    </div>
    <div class="card-body">

        <div class="row">

            {{-- Full Name --}}
            <div class="col-md-12">
                <h6 class="font-weight-bold d-inline">Full Name:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->name }}</span>
            </div>

            {{-- Username --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Username:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->username }}</span>
            </div>

            {{-- Email --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Email:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->email }}</span>
            </div>

            {{-- Contact Number --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Contact Number:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->contact_number }}</span>
            </div>

            {{-- Role --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Role:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->role->role_name }}</span>
            </div>

            {{-- Branch --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Branch:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->branch->branch_name }}</span>
            </div>

            {{-- Branch Address --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Branch Address:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $user->branch->branch_address }}</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons Section --}}
    <div class="card-footer">
        <div class="d-flex gap-1 justify-content-end">

            {{-- Edit button for employee account --}}
            @include('navigation.employee_maintenance.account.edit')

        </div>
    </div>
</div>

{{-- Success Toast Notification --}}
@push('scripts')
@if(session()->has('updateSuccess'))
<script type="module">
    $(function(){
        Toast.fire({
            icon: 'success',
            title: '{{session('updateSuccess')}}'
        })
    })
</script>
@elseif(session()->has('updateSuccess'))
<script type="module">
    $(function(){
        Toast.fire({
            icon: 'success',
            title: '{{session('updateSuccess')}}'
        })
    })
</script>
@elseif($errors->has('updateAccount'))
<script type="module">
    $(function(){
        const userID = {{$errors->first('updateAccount')}}
        $(`#editAccount${userID}`).modal('show')
        Toast.fire({
            icon: 'warning',
            title: 'Update error'
        })
    })
</script>
@endif
@endpush

@endsection
