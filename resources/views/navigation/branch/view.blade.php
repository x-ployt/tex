@extends('layout') {{-- including layout.blade.php --}}
@section('title', 'View Branch') {{-- changing title of the page --}}
@section('content')

<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Salveowell Branch</a></li>
    <li class="breadcrumb-item active">View Branch Details</li>
</ol>

{{-- Back Button at the Top --}}
<div class="mb-3">
    <a href="{{ route('branch.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

{{-- Branch Details Display --}}
<div class="card card-outline details-container">
    <div class="card-header">
        <h3>Branch Details</h3>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <h6 class="font-weight-bold d-inline">Branch Name:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $branch->branch_name }}</span>
            </div>
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Branch Address:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $branch->branch_address }}</span>
            </div>
        </div>
    </div>

    {{-- Action Buttons Section --}}
    <div class="card-footer">
        <div class="d-flex gap-1 justify-content-end">

            {{-- Edit button for branch --}}
            @include('navigation.branch.edit')

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
@elseif($errors->has('updateBranch'))
    <script type="module">
        $(function(){
            const branchID = {{$errors->first('updateBranch')}}
            $(`#editBranch${branchID}`).modal('show')
            Toast.fire({
                icon: 'warning',
                title: 'Update error'
            })
        })
    </script>
@endif
@endpush

@endsection
