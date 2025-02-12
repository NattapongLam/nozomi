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
        <form method="GET" class="form-horizontal">
            @csrf
        <div class="row">           
            <div class="col-12 col-md-3">
                <h3 class="card-title">อนุมัติเอกสารจัดซื้อ</h3>
            </div>
            <div class="col-12 col-md-3">
                วันที่ :<input type="date" class="form-control" id="datestart" name="datestart" value="{{ $datestart }}">
            </div>
            <div class="col-12 col-md-3">
                ถึงวันที่ : <input type="date" class="form-control" id="dateend" name="dateend" value="{{ $dateend }}">
            </div>
            <div class="col-12 col-md-3">
                <p></p>
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>          
        </div>
    </form>
        <br>       
        <div style="overflow-x:auto;">
        <table id="tb_job" class="table table-bordered nowrap w-100 text-center table-sm">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>สถานะ</th>
                    <th>เลขที่</th>
                    <th>ผู้จำหน่าย</th>
                    <th>ผู้บันทึก</th>
                    <th>หมายเหตุ</th>
                    {{-- <th>ฐานภาษี</th>
                    <th>ภาษี</th> --}}
                    <th>สุทธิ</th>
                    <th>ส่วนลด</th>
                    {{-- <th>อนุมัติท่านที่ 1</th> --}}
                    <th>รายละเอียด</th>
                    <th>ยกเลิก</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hd as $item)
                    <tr>
                        <td>{{ Carbon\Carbon::parse($item->pur_expenses_hd_date)->format('d/m/Y')}}</td>
                        <td>
                            @if($item->pur_expenses_status_id == 1 || $item->pur_expenses_status_id == 2)
                            <span class="badge bg-danger"> {{$item->pur_expenses_status_name}}</span>
                            @elseif($item->pur_expenses_status_id == 6)
                            <span class="badge bg-warning"> {{$item->pur_expenses_status_name}}</span>
                            @elseif($item->pur_expenses_status_id == 7)
                            <span class="badge bg-success"> {{$item->pur_expenses_status_name}}</span>
                            @elseif($item->pur_expenses_status_id == 8)
                            <span class="badge bg-success"> {{$item->pur_expenses_status_name}}</span>
                            @elseif($item->pur_expenses_status_id == 9)
                            <span class="badge bg-success"> {{$item->pur_expenses_status_name}}</span>
                            @elseif($item->pur_expenses_status_id == 3 || $item->pur_expenses_status_id == 4)
                            <span class="badge bg-secondary"> {{$item->pur_expenses_status_name}}</span>
                            @endif         
                        </td>
                        <td>{{$item->pur_expenses_hd_docuno}}</td>
                        <td>{{$item->vd_vendor_fullname}}</td>
                        <td>{{$item->pur_expenses_hd_save}}</td>
                        <td>{{$item->pur_expenses_hd_note}}</td>
                        {{-- <td>{{number_format($item->pur_expenses_hd_basevat,2)}}</td>
                        <td>{{number_format($item->pur_expenses_hd_vat,2)}}</td> --}}
                        <td>{{number_format($item->pur_expenses_hd_netamount,2)}}</td>
                        <td>{{number_format($item->pur_expenses_hd_discount,2)}}</td>
                        {{-- <td>{{$item->approved1_save}}/{{$item->approved1_remark}}</td> --}}
                        <td>
                            @if ($item->pur_expenses_status_id == 1)
                            <a href="{{route('pur-ase.edit',$item->pur_expenses_hd_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a> 
                            @else
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" onclick="getDataAse('{{ $item->pur_expenses_hd_id }}')"><i class="fas fa-eye"></i></a>
                            @endif                        
                        </td>
                        <td>
                            @if ($item->pur_expenses_status_id == 6)
                            @if ($item->approved2_code == Auth::user()->emp_person_code )
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDelAse('{{ $item->pur_expenses_hd_id }}')"><i class="fas fa-trash"></i></a> 
                            @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
</div>
<div class="modal fade bs-example-modal-center modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายการ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>เลขที่ PR</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>จำนวน</th>
                                <th>หน่วยนับ</th>
                                <th>จุดสั่งซื้อ</th>
                                <th>จุดเติมเต็ม</th>
                                <th>ราคาต่อหน่วย</th>
                                <th>สุทธิ</th>
                                <th>ส่วนลด</th>
                            </tr>
                        </thead>
                        <tbody id="tb_list">
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
        ],
        columnDefs: [{
                targets: 1,
                type: 'time-date-sort'
            }],
        order: [
            [1, "asc"],
            [0, "desc"],           
        ],
    })
});
getDataAse = (id) => {
$.ajax({
    url: "{{ url('/getDataAse') }}",
    type: "post",
    dataType: "JSON",
    data: {
        refid: id,
        _token: "{{ csrf_token() }}"
    },
    success: function(data) {

        let el_list = '';
        let unique = [...new Map(data.dt.map(item => [item['pur_expenses_dt_listno'], item])).values()];
        $.each(unique, function(key, item) {
            el_list += `
                    <tr>
                                    <th scope="row">${ item.pur_expenses_dt_listno }</th>
                                    <td>${ item.pur_purchaserequest_hd_docuno }</td>
                                    <td>${ item.productcode }</td>
                                    <td>${ item.productname }</td>
                                    <td>${ parseFloat(item.pur_expenses_dt_qty).toFixed(2) }</td>
                                    <td>${ item.productunit }</td>
                                    <td>${ parseFloat(item.pd_product_min).toFixed(2) }</td>
                                    <td>${ parseFloat(item.pd_product_max).toFixed(2) }</td>
                                    <td>${ parseFloat(item.pur_expenses_dt_price).toFixed(2) }</td>
                                    <td>${ parseFloat(item.pur_expenses_dt_netamount).toFixed(2) }</td>
                                    <td>${ parseFloat(item.pur_expenses_dt_discount).toFixed(2) }</td>
                                </tr>`
        })
        $('#tb_list').html(el_list);
    }
});
}
confirmDelAse = (refid) =>{
Swal.fire({
    title: 'คุณแน่ใจหรือไม่ !',
    text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก',
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false         
}).then(function(result) {
    if (result.value) {
        $.ajax({
            url: `{{ url('/confirmDelAse') }}`,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "refid": refid,               
            },           
            dataType: "json",
            success: function(data) {
                // console.log(data);
                if (data.status == true) {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ยกเลิกเอกสารเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกเอกสารไม่สำเร็จ',
                        icon: 'error'
                    });            }
        });

    } else if ( // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
            title: 'ยกเลิก',
            text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
            icon: 'error'
        });
    }
});
}
</script>
@endpush