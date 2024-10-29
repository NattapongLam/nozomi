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
        <h3 class="card-title">อนุมัติเอกสารหัวหน้างาน</h3>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>แผนก</th>
                    <th>ผู้บันทึก</th>
                    <th>หมายเหตุ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($item->pur_purchaserequest_hd_date)->format('d/m/Y')}}</td>
                        <td>{{$item->pur_purchaserequest_hd_docuno}}</td>
                        <td>{{$item->emp_department_name}}</td>
                        <td>{{$item->pur_purchaserequest_hd_save}}</td>
                        <td>{{$item->pur_purchaserequest_hd_note}}</td>
                        <td>
                            <a href="{{route('pur-pr.edit',$item->pur_purchaserequest_hd_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
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