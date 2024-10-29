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
        <h3 class="card-title">อนุมัติเอกสารท่านที่ 1</h3>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ผู้จำหน่าย</th>
                    <th>ผู้บันทึก</th>
                    <th>หมายเหตุ</th>
                    <th>ฐานภาษี</th>
                    <th>ภาษี</th>
                    <th>สุทธิ</th>
                    <th>ส่วนลด</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($item->pur_expenses_hd_date)->format('d/m/Y')}}</td>
                        <td>{{$item->pur_expenses_hd_docuno}}</td>
                        <td>{{$item->vd_vendor_fullname}}</td>
                        <td>{{$item->pur_expenses_hd_save}}</td>
                        <td>{{$item->pur_expenses_hd_note}}</td>
                        <td>{{number_format($item->pur_expenses_hd_basevat,2)}}</td>
                        <td>{{number_format($item->pur_expenses_hd_vat,2)}}</td>
                        <td>{{number_format($item->pur_expenses_hd_netamount,2)}}</td>
                        <td>{{number_format($item->pur_expenses_hd_discount,2)}}</td>
                        <td>
                            <a href="{{route('pur-ase.edit',$item->pur_expenses_hd_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
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