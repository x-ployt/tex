@extends('layout') {{-- including layout.blade.php --}}
@section('title', 'View Remark Details') {{-- changing title of the page --}}
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('remark.index') }}">Remark</a></li>
    <li class="breadcrumb-item active">View Remark</li>
</ol>

{{-- Back Button at the Top --}}
<div class="mb-3">
    <a href="{{ route('remark.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

{{-- Remark Details Display --}}
<div class="card card-outline details-container">
    <div class="card-header">
        <h3>Remark Details</h3>
    </div>
    <div class="card-body">
        <div class="row">

            {{-- Remarks --}}
            <div class="col-md-12">
                <h6 class="font-weight-bold d-inline">Remarks:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $remark->remarks }}</span>
            </div>

            {{-- Type --}}
            <div class="col-md-12 mt-2">
                <h6 class="font-weight-bold d-inline">Type:</h6>
                <span class="text-dark" style="font-size: 15px;">{{ $remark->type }}</span>
            </div>

        </div>
    </div>

    {{-- Action Buttons Section --}}
    <div class="card-footer">
        <div class="d-flex gap-1 justify-content-end">

            {{-- Edit button for remark --}}
            @include('navigation.setting.remark.edit')

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
@elseif($errors->has('updateRemark'))
<script type="module">
    $(function(){
        const remarkID = {{$errors->first('updateRemark')}}
        $(`#editRemark${remarkID}`).modal('show')
        Toast.fire({
            icon: 'warning',
            title: 'Update error'
        })
    })
</script>
@endif
@endpush

@endsection
