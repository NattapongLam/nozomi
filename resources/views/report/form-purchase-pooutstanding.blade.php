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
        <h4 class="card-title">PO คงค้าง</h4>   
        <br>
        <div style="overflow-x:auto;">
            <table id="tb_job" class="table table-bordered nowrap w-100 text-center table-sm">
                <thead>
                    <tr>
                        <th>วันที่ PO</th>
                        <th>เลขที่ PO</th>
                        <th>ผู้จำหน่าย</th>
                        <th>สินค้า</th>
                        <th>จำนวนค้างรับ</th>
                        <th>จำนวนรับแล้ว</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hd as $item)
                        <tr>
                            <td>{{Carbon\Carbon::parse($item->pur_purchaseorder_hd_date)->format('d/m/Y')}}</td>
                            <td>{{$item->pur_purchaseorder_hd_docuno}}</td>
                            <td>{{$item->vd_vendor_fullname}}</td>
                            <td>{{$item->productcode}}/{{$item->productname}}</td>
                            <td>{{number_format($item->pur_purchaseorder_total,2)}} {{$item->productunit}}</td>
                            <td>{{number_format($item->wh_receiveproduct_dt_qty,2)}} {{$item->productunit}}</td>
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