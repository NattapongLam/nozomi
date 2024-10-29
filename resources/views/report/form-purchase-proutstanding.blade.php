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
        <h4 class="card-title">PR คงค้าง</h4>   
        <br>
        <div style="overflow-x:auto;">
            <table id="tb_job" class="table table-bordered nowrap w-100 text-center table-sm">
                <thead>
                    <tr>
                        <th>วันที่ PR</th>
                        <th>เลขที่ PR</th>
                        <th>ผู้ขอสั่งซื้อ</th>
                        <th>แผนก</th>
                        <th>วันที่ต้องการใช้</th>
                        <th>สินค้า</th>
                        <th>จำนวนค้างสั่งซื้อ</th>
                        <th>จำนวนสั่งซื้อแล้ว</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hd as $item)
                        <tr>
                            <td>{{Carbon\Carbon::parse($item->pur_purchaserequest_hd_date)->format('d/m/Y')}}</td>
                            <td>{{$item->pur_purchaserequest_hd_docuno}}</td>
                            <td>{{$item->pur_purchaserequest_hd_save}}</td>
                            <td>{{$item->emp_department_name}}</td>
                            <td>{{Carbon\Carbon::parse($item->duedate)->format('d/m/Y')}}</td>
                            <td>{{$item->productcode}}/{{$item->productname}}</td>
                            <td>{{number_format($item->pur_purchaserequest_total,2)}} {{$item->productunit}}</td>
                            <td>{{number_format($item->pur_purchaseorder_dt_qty,2)}} {{$item->productunit}}</td>
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
        "pageLength": 20,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
    ],
    "order": [[ 0, "asc" ]],        
    })
});
</script>
@endpush