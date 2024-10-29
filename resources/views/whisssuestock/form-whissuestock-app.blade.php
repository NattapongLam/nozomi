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
        <h3 class="card-title">อนุมัติเบิกสินค้า</h3>
        <div style="overflow-x:auto;">
        <table id="tb_job" class="table table-bordered nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ประเภท</th>
                    <th>ผู้เบิก</th>
                    <th>แผนก</th>
                    <th>หมายเหตุ</th>
                    <th>รหัสคลัง</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($item->wh_issuestock_hd_date)->format('d/m/Y')}}</td>
                        <td>{{$item->wh_issuestock_hd_docuno}}</td>
                        <td>{{$item->wh_issuetype_name}}</td>
                        <td>{{$item->wh_issuestock_hd_save}}</td>
                        <td>{{$item->emp_department_name}}</td>
                        <td>{{$item->wh_issuestock_hd_note}}</td>
                        <td>{{$item->wh_warehouse_code}}</td>              
                        <td>
                            <a href="{{route('wh-issue.edit',$item->wh_issuestock_hd_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
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