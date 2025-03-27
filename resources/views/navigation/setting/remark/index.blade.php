@extends('layout') {{-- including layout.blade.php --}} 
@section('title', 'Employee Account') {{-- changing title of the page --}}
@section('content')

<ol class="breadcrumb float">
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Remark</li>
</ol>

{{-- Data Table --}}
<div class="table-container card card-outline">

    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
        <h4 class="text-primary-color fw-bold text-capitalize">Remarks</h4>
        <div class="ms-auto">
            @include('navigation.setting.remark.add')
        </div>
    </div>  

    <table id="data_table" class="table table-bordered table-sm table-striped table-responsive-sm" style="width: 100%;">
        <thead>
            <tr>
                <th>Remarks</th>
                <th>Type</th>
                <th class="action" style="width: 50px;">View</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($remarks as $remark)
                <tr>
                    <td>{{ $remark->remarks }}</td>
                    <td>{{ $remark->type }}</td>
                    <td>
                        {{-- View Button --}}
                        <x-view-button id="viewBtn{{ $remark->id }}" class="extra-class" route="{{ route('remark.view', $remark) }}" title="View Remarks Details"/>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- Data Table --}}

{{-- Scripts --}}
@push('scripts')

<script>
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
@if($errors->has('addRemark'))
<script type="module">
    $(function(){
        $(`#addRemark`).modal('show')
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