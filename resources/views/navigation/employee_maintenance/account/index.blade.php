@extends('layout') {{-- including layout.blade.php --}} 
@section('title', 'Employee Account') {{-- changing title of the page --}}
@section('content')

<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item">Employee Maintenance</li>
    <li class="breadcrumb-item active">Employee Account</li>
</ol>

{{-- Data Table --}}
<div class="table-container card card-outline">

    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
        <h4 class="text-primary-color fw-bold text-capitalize">Employee Account</h4>
        <div class="ms-auto">
            @include('navigation.employee_maintenance.account.add')
        </div>
    </div>  

    <table id="data_table" class="table table-bordered table-sm table-striped table-responsive-sm" style="width: 100%;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Branch Name</th>
                <th class="action" style="width: 50px;">View</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->role_name }}</td>
                    <td>{{ $user->branch->branch_name }}</td>
                    <td>
                        {{-- View Button --}}
                        <x-view-button id="viewBtn{{ $user->id }}" class="extra-class" route="{{ route('account.view', $user) }}" title="View Account Details"/>
                    </td>
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
            {orderable: false, targets: [5]},
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
@if($errors->has('addAccount'))
<script type="module">
    $(function(){
        $(`#addAccount`).modal('show')
        Toast.fire({
            icon: 'warning',
            title: 'Add error'
        })
    })
</script>
@endif

@endpush
@endsection
{{-- END OF CONTENT --}}