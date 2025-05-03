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
        <h3 class="card-title">ประวัติเครื่องจักร</h3>
        <div class="row">
            <div class="col-2">
                รหัสเครื่อง : {{$hd->mtn_machinery_code}}
            </div>
            <div class="col-5">
                ชื่อเครื่อง : {{$hd->mtn_machinery_name}}
            </div>
            <div class="col-2">
                Serial : {{$hd->mtn_machinery_serial}}
            </div>
            <div class="col-3">
                วันที่ตรวจเช็คครั้งต่อไป : {{Carbon\Carbon::parse($hd->mtn_machinery_datenow)->format('d/m/Y')}}
            </div>
        </div>
        <hr>
        <table id="tb_job1" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>สถานะ</th>
                    <th>วัน - เวลา</th>
                    <th>เลขที่</th>
                    <th>แผนก</th>
                    <th>ปัญหา</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($docs as $item)
                    <tr>
                        <td>{{$item->mtn_maintenancestatus_name}}</td>
                        <td>{{Carbon\Carbon::parse($item->mtn_maintenancedoc_datetime)->format('d/m/Y H:i')}}</td>
                        <td>{{$item->mtn_maintenancedoc_docuno}}</td>
                        <td>{{$item->emp_department_name}}</td>
                        <td>{{$item->mtn_maintenancedoc_remark}}</td>
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
    $('#tb_job1').DataTable({
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