@extends('layout')
@section('title', 'Salveowell Branch')
@section('content')

{{-- Breadcrumb --}}
<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Salveowell Branch</li>
</ol>

{{-- Data Table --}}
<div class="table-container card card-outline">

    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
        <h4 class="text-primary-color fw-bold text-capitalize">Salveowell Branch</h4>
        <div class="ms-auto">
            @include('navigation.branch.add')
        </div>
    </div>    

    <table id="data_table" class="table table-bordered table-sm table-striped table-responsive-sm" style="width: 100%;">
        <thead>
            <tr>
                <th>Branch Name</th>
                <th>Address</th>
                <th class="action" style="width: 50px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
                <tr>
                    <td>{{ $branch->branch_name }}</td>
                    <td>{{ $branch->branch_address }}</td>
                    <td>
                        {{-- View Button --}}
                        <x-view-button id="viewBtn{{ $branch->id }}" class="extra-class" route="{{ route('branch.view', $branch) }}" title="View Branch Details"/>
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
            {orderable: false, targets: [2]},
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
@if($errors->has('addBranch'))
    <script type="module">
        $(function(){
            $(`#addBranch`).modal('show')
            Toast.fire({
                icon: 'warning',
                title: 'Add error'
            })
        })
    </script>
@endif

@endpush
@endsection
