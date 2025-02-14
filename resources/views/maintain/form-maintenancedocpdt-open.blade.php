@extends('layouts.main')
@section('content')
<div class="row">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<div class="card">
    <div class="card-body">
        <h3 class="card-title">ใบแจ้งซ่อมเครื่องจักร</h3>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                   <th>สถานะ</th>
                   <th>วัน-เวลาแจ้งซ่อม</th>
                   <th>เลขที่แจ้งซ่อม</th>
                   <th>เครื่องจักร</th>
                   <th>แผนก</th>
                   <th>ตำแหน่งที่ตั้ง</th>
                   <th>ผู้แจ้งซ่อม</th>
                   <th></th>
                </tr>
            </thead>
            <tbody>        
                @foreach ($hd as $item)
                    <tr>
                        <td>{{$item->mtn_maintenancestatus_name}}</td>
                        <td>{{ \Carbon\Carbon::parse($item->mtn_maintenancedoc_datetime)->format('d/m/Y H:i') }}</td>
                        <td>{{$item->mtn_maintenancedoc_docuno}}</td>
                        <td>{{$item->mtn_machinery_name}}</td>
                        <td>{{$item->emp_department_name}}</td>
                        <td>{{$item->mtn_maintenancedoc_location}}</td>
                        <td>{{$item->mtn_maintenancedoc_person}}</td>
                        <td>
                            <a href="{{route('mt-docpdt.edit',$item->mtn_maintenancedoc_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach       
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
});
</script>
@endpush