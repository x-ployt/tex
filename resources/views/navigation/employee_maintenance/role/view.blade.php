@extends('layout') {{-- including layout.blade.php --}}
@section('title', 'View Role') {{-- changing title of the page --}}
@section('content')

<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Employee Role</a></li>
    <li class="breadcrumb-item active">View Role Details</li>
</ol>

{{-- Back Button at the Top --}}
<div class="mb-3">
    <a href="{{ url()->previous() }}" onclick="handleBack(event)" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

{{-- Role Details Display --}}
<div class="card card-outline details-container">
    <div class="card-header">
        <h3>Role Details</h3>
    </div>
    <div class="card-body">

        <div class="row">
            {{-- Role Name --}}
            <div class="col-md-12">
                <h6 class="font-weight-bold d-inline">Role Name:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $role->role_name }}</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons Section --}}
    <div class="card-footer">
        <div class="d-flex gap-1 justify-content-end">

            {{-- Edit button for role --}}
            @include('navigation.role.edit')

        </div>
    </div>
</div>

{{-- Scripts --}}
@push('scripts')

{{-- Back button --}}
<script>
    function handleBack(event) {
        if (history.length > 1) {
            event.preventDefault();
            history.back();
        }
    }
</script>

{{-- Success Notification --}}
@if(session()->has('updateSuccess'))
    <script type="module">
        $(function(){
            Toast.fire({
                icon: 'success',
                title: '{{session('updateSuccess')}}'
            })
        })
    </script>
@endif

{{-- Error Notification --}}
@if($errors->has('updateRole'))
    <script type="module">
        $(function(){
            const roleID = {{$errors->first('updateRole')}}
            $(`#editRole${roleID}`).modal('show')
            Toast.fire({
                icon: 'warning',
                title: 'Update error'
            })
        })
    </script>
@endif
@endpush

@endsection
