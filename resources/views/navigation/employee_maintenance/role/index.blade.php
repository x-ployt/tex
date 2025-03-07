@extends('layout')
@section('title', 'Employee Roles')
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item">Employee Maintenance</li>
    <li class="breadcrumb-item active">Employee Roles</li>
</ol>

{{-- Data Table --}}
<div class="table-container card card-outline">

    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
        <h4 class="text-primary-color fw-bold text-capitalize">Employee Roles</h4>
        {{-- <div class="ms-auto">
            @include('navigation.role.add')
        </div> --}}
    </div>    

    <table id="data_table" class="table table-bordered table-sm table-striped table-responsive-sm" style="width: 100%;">
        <thead>
            <tr>
                <th>Role Name</th>
                {{-- <th class="action" style="width: 50px;">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->role_name }}</td>
                    {{-- <td>
                        View Button
                        <a id="viewBtn{{$role->id}}" href="{{route('role.view', $role)}}" class="btn yellowBtn" title="View Role Details">
                            <span> View </span>
                        </a>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- Data Table --}}

{{-- Scripts --}}
@push('scripts')

<script type="module">
    new DataTable('#data_table', {
        columnDefs: [
            // {orderable: false, targets: [1]},
            {width: "auto", targets: '_all'},
            {className: 'text-center', targets: '_all' }
        ],
        fixedHeader: true,
    });
</script>

{{-- Success Notification --}}
@if(session()->has('addSuccess'))
    <script type="module">
        $(function(){
            Toast.fire({
                icon: 'success',
                title: '{{session('addSuccess')}}'
            })
        })
    </script>
@endif

{{-- Error Notification --}}
@if($errors->has('addRole'))
    <script type="module">
        $(function(){
            $(`#addRole`).modal('show')
            Toast.fire({
                icon: 'warning',
                title: 'Add error'
            })
        })
    </script>
@endif

@endpush

@endsection
