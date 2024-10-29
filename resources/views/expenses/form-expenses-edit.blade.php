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
        <h4 class="card-title">ค่าใช้จ่ายอื่นๆ</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('pur-ase.update',$hd->pur_expenses_hd_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-12 col-md-3">
                <h5>
                    วันที่ : {{Carbon\Carbon::parse($hd->pur_expenses_hd_date)->format('d/m/Y')}}
                </h5>              
            </div>
            <div class="col-12 col-md-3">
                <h5>
                เลขที่ : {{$hd->pur_expenses_hd_docuno}}
                </h5>  
            </div>
            <div class="col-12 col-md-3">
                <h5>
                ผู้บันทึก : {{$hd->pur_expenses_hd_save}}
                </h5>  
            </div>
            <div class="col-12 col-md-3">
                @if($hd->pur_expenses_hd_file)
                <a href="{{asset($hd->pur_expenses_hd_file)}}" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a> 
                @endif        
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <h5>
                    ผู้จำหน่าย : {{$hd->vd_vendor_fullname}}
                </h5>              
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <h5>
                    หมายเหตุ : {{$hd->pur_expenses_hd_note}}
                </h5>              
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-2">
                <h5>
                    สกุลเงิน : {{$hd->ms_currency_code}}
                </h5>              
            </div>
            <div class="col-12 col-md-2">
                <h5>
                    อัตรา : {{number_format($hd->ms_currency_rate,4)}}
                </h5>              
            </div>
            <div class="col-12 col-md-2">
                <h5>
                    ฐานภาษี : {{number_format($hd->pur_expenses_hd_basevat,2)}}
                </h5>              
            </div>
            <div class="col-12 col-md-2">
                <h5>
                    ภาษี : {{number_format($hd->pur_expenses_hd_vat,2)}}
                </h5>  
            </div>
            <div class="col-12 col-md-2">
                <h5>
                    สุทธิ : {{number_format($hd->pur_expenses_hd_netamount,2)}}
                </h5>  
            </div>
            <div class="col-12 col-md-2">
                <h5>
                    ส่วนลด : {{number_format($hd->pur_expenses_hd_discount,2)}}
                </h5>  
            </div>
        </div>
        <hr>
        <div class="row">
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>เลขที่ PR</th>
                        <th>สินค้า</th>
                        <th>หน่วยนับ</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>ส่วนลด</th>
                        <th>สุทธิ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>{{$item->pur_expenses_dt_listno}}</td>
                            <td>{{$item->pur_purchaserequest_hd_docuno}}</td>
                            <td>{{$item->productcode}}/{{$item->productname}}</td>
                            <td>{{$item->productunit}}</td>
                            <td>{{number_format($item->pur_expenses_dt_qty,2)}}</td>
                            <td>{{number_format($item->pur_expenses_dt_price,2)}}</td>     
                            <td>{{number_format($item->pur_expenses_dt_discount,2)}}</td>
                            <td>{{number_format($item->pur_expenses_dt_netamount,2)}}</td>                         
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-md-12">
                สถานะ :
                <select class="form-control" name="approved_status" id="approved_status">
                    <option>กรุณาเลือก</option>
                    @foreach ($sta as $item)
                        <option value="{{$item->pur_expenses_status_id}}">{{$item->pur_expenses_status_name}}</option>
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