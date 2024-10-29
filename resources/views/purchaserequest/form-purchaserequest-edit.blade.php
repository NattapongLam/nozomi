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
        <h4 class="card-title">ใบขอสั่งซื้อ</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('pur-pr.update',$hd->pur_purchaserequest_hd_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-12 col-md-4">
                <h5>
                    วันที่ : {{Carbon\Carbon::parse($hd->pur_purchaserequest_hd_date)->format('d/m/Y')}}
                </h5>              
            </div>
            <div class="col-12 col-md-4">
                <h5>
                เลขที่ : {{$hd->pur_purchaserequest_hd_docuno}}
                </h5>  
            </div>
            <div class="col-12 col-md-4">
                <h5>
                ผู้ขอสั่งซื้อ : {{$hd->pur_purchaserequest_hd_save}}
                </h5>  
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <h5>
                แผนก : {{$hd->emp_department_name}}
                </h5> 
            </div>
            <div class="col-12 col-md-8">
                <h5>
                จัดสรร : {{$hd->ms_allocate_name}}
                </h5> 
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-9">
                <h5>
                    หมายเหตุ : {{$hd->pur_purchaserequest_hd_note}}
                </h5>              
            </div>
            <div class="col-12 col-md-3">
                @if($hd->pur_purchaserequest_hd_file)
                <a href="{{asset($hd->pur_purchaserequest_hd_file)}}" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a> 
                @endif              
            </div>
        </div><hr>
        <div class="row">
            <div style="overflow-x:auto;">
            <table class="table table-bordered nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่ต้องการ</th>
                        <th>สินค้า</th>
                        <th>หน่วยนับ</th>
                        <th>จำนวน</th>
                        <th>สต็อค</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>{{$item->pur_purchaserequest_dt_listno}}</td>
                            <td>{{Carbon\Carbon::parse($item->duedate)->format('d/m/Y')}}</td>
                            <td>{{$item->productcode}}/{{$item->productname}}</td>
                            <td>{{$item->productunit}}</td>
                            <td>{{number_format($item->pd_product_qty,2)}}</td>
                            <td>{{number_format($item->stcqty,2)}}</td>                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div><hr>
        <div class="row">
            @if ($hd->pur_purchaserequest_status_id == 6)
            <div class="col-12 col-md-12">               
                <div class="input-group">
                    <div class="d-flex">
                        <div class="square-switch">
                            <input type="checkbox"
                                id="check_approved4" switch="none" name="check_approved4"
                                value="true" />
                            <label for="check_approved4" data-on-label="ใช่" data-off-label="ไม่ใช่"></label>     
                            <h5 style="color: red">ต้องการให้มีผู้อนุมัติร่วม</h5>                      
                        </div>
                    </div>
                </div>           
            </div>
            @endif            
            <div class="col-12 col-md-12">
                สถานะ :
                <select class="form-control" name="approved_status" id="approved_status">
                    <option>กรุณาเลือก</option>
                    @foreach ($sta as $item)
                        <option value="{{$item->pur_purchaserequest_status_id}}">{{$item->pur_purchaserequest_status_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-12">
                หมายเหตุอนุมัติ : <textarea class="form-control" name="approved_remark" id="approved_remark"></textarea>
            </div>                               
        </div><br>
        <div class="row">
            <div class="col-12 col-md-12">
                <button class="btn btn-primary waves-effect waves-light" type="submit" >บันทึก</button>
            </div>
        </div> 
        </form>
</div>
</div>
@endsection
@push('scriptjs')
<script>
</script>
@endpush