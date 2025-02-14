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
        <h3 class="card-title">รายงานการตรวจเช็คประจำเดือน  ( Monthly Maintenance Schedule )</h3>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>เดือน-ปี</th>
                    <th>เครื่องจักร</th>
                    <th>สถานที่ตั้ง</th>
                    <th>ทำความสะอาด</th>
                    <th>เติมน้ำมันหล่อสื่น</th>
                    <th>เปลี่ยนน้ำมันหล่อลื่น</th>
                    <th>ตรวจเช็ค</th>
                    <th>ปรับแต่ง</th>
                    <th>ซ่อมแซม</th>
                    <th>เปลี่ยน</th>
                    <th>ซ่อมใหญ่</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{$item->ms_month_name}} - {{$item->ms_year_name}}</td>
                        <td>{{$item->mtn_machinery_code}}/{{$item->mtn_machinery_name}}</td>
                        <td>{{$item->mtn_machinerycheck_hd_location}}</td>
                        <td>
                            @if($item->check_c)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_t)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_l)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_i)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_a)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_r)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_p)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            @if($item->check_o)
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="">
                            @else
                            <input class="form-check-input" type="checkbox" id="formCheckcolor3">
                            @endif
                        </td>
                        <td>
                            <a href="{{route('mt-checklist.edit',$item->mtn_machinerycheck_hd_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
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