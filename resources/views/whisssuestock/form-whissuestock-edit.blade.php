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
        <h4 class="card-title">ใบเบิกสินค้า</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('wh-issue.update',$hd->wh_issuestock_hd_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-12 col-md-4">
                <h5>
                    วันที่ : {{Carbon\Carbon::parse($hd->wh_issuestock_hd_date)->format('d/m/Y')}}
                </h5>              
            </div>
            <div class="col-12 col-md-4">
                <h5>
                เลขที่ : {{$hd->wh_issuestock_hd_docuno}}
                </h5>  
            </div>          
            <div class="col-12 col-md-4">
                <h5>
                แผนก : {{$hd->emp_department_name}}
                </h5> 
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <h5>
                ประเภท : {{$hd->wh_issuetype_name}} รหัสคลัง : {{$hd->wh_warehouse_code}}
                </h5>  
            </div>
            <div class="col-12 col-md-4">
                <h5>
                เลขที่อ้างอิง : {{$hd->wh_issuestock_hd_refdocu}}
                </h5>  
            </div>
            <div class="col-12 col-md-4">
                <h5>
                ผู้เบิก : {{$hd->wh_issuestock_hd_save}}
                </h5>  
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <h5>
                    หมายเหตุ : {{$hd->wh_issuestock_hd_note}}
                </h5>              
            </div>
        </div><hr>
        <div class="row">
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>สินค้า</th>
                        <th>หน่วยนับ</th>
                        <th>จำนวน</th>
                        <th>สต็อค</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>{{$item->wh_issuestock_dt_listno}}</td>
                            <td>{{$item->productcode}}/{{$item->productname}}</td>
                            <td>{{$item->productunit}}</td>
                            <td>{{number_format($item->wh_issuestock_dt_qty,2)}}</td>
                            <td>{{number_format($item->stcqty,2)}}</td>                           
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-12 col-md-12">
                สถานะ :
                <select class="form-control" name="approved_status" id="approved_status">
                    <option>กรุณาเลือก</option>
                    @foreach ($sta as $item)
                        <option value="{{$item->wh_issuestock_status_id}}">{{$item->wh_issuestock_status_name}}</option>
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