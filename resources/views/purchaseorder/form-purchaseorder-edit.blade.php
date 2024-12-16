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
        <h4 class="card-title">ใบสั่งซื้อ</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('pur-po.update',$hd->pur_purchaseorder_hd_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-12 col-md-4">
                <h5>
                    วันที่ : {{Carbon\Carbon::parse($hd->pur_purchaseorder_hd_date)->format('d/m/Y')}}
                </h5>              
            </div>
            <div class="col-12 col-md-4">
                <h5>
                เลขที่ : {{$hd->pur_purchaseorder_hd_docuno}}
                </h5>  
            </div>
            <div class="col-12 col-md-4">
                <h5>
                ผู้บันทึก : {{$hd->pur_purchaseorder_hd_save}}
                </h5>  
            </div>
            <div class="col-12 col-md-3">
                @if($hd->pur_purchaseorder_hd_file)
                <a href="{{asset($hd->pur_purchaseorder_hd_file)}}" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a> 
                @endif    
                @if($hd->pur_purchaseorder_hd_file1)
                <a href="{{asset($hd->pur_purchaseorder_hd_file1)}}" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a> 
                @endif      
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>
                    ผู้จำหน่าย : {{$hd->vd_vendor_code}}/{{$hd->vd_vendor_fullname}}
                </h5>              
            </div>
            <div class="col-12 col-md-6">
                <h5>
                    วันเครดิต : {{number_format($hd->vd_vendor_creditday,0)}}
                </h5>              
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <h5>
                    ที่อยู่ : {{$hd->vd_vendor_fulladdress}}
                </h5>
            </div>
        </div>
        <div class="row">
           
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <h5>
                    หมายเหตุ : {{$hd->pur_purchaseorder_hd_note}}
                </h5>              
            </div>
        </div>
        <hr>
        <div class="row">
            <div style="overflow-x:auto;">
            <table class="table table-bordered nowrap w-100 text-center table-info">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>เลขที่ PR</th>
                        <th>สินค้า</th>
                        <th>หน่วยนับ</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>ส่วนลด</th>
                        <th>ฐานภาษี</th>
                        <th>ภาษี</th>
                        <th>สุทธิ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>{{$item->pur_purchaseorder_dt_listno}}</td>
                            <td>{{$item->pur_purchaserequest_hd_docuno}}</td>
                            <td>{{$item->productcode}}/{{$item->productname}}</td>
                            <td>{{$item->productunit}}</td>
                            <td>{{number_format($item->pur_purchaseorder_dt_qty,2)}}</td>
                            <td>{{number_format($item->pur_purchaseorder_dt_price,2)}}</td>     
                            <td>{{number_format($item->pur_purchaseorder_dt_discount,2)}}</td>
                            <td>{{number_format($item->pur_purchaseorder_dt_basevat,2)}}</td>    
                            <td>{{number_format($item->pur_purchaseorder_dt_vat,2)}}</td>    
                            <td>{{number_format($item->pur_purchaseorder_dt_netamount,2)}}</td>                         
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">สกุลเงิน : {{$hd->ms_currency_code}} อัตรา : {{number_format($hd->ms_currency_rate,4)}}</th>
                        <th>รวม</th>
                        <th>{{number_format($hd->pur_purchaseorder_hd_discount,2)}}</th>
                        <th>{{number_format($hd->pur_purchaseorder_hd_basevat,2)}}</th>
                        <th>{{number_format($hd->pur_purchaseorder_hd_vat,2)}}</th>
                        <th>{{number_format($hd->pur_purchaseorder_hd_netamount,2)}}</th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
        <div class="row">
            <h4 class="card-title">Delivery Plan</h4>
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center table-info">
                <thead>
                    <tr>
                        <th>Product</th>
                        @foreach ($groupedByDaywh as $day => $items)
                            <th>{{ \Carbon\Carbon::parse($day)->format('d/m/Y') }}</th>
                        @endforeach                        
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    // ตัวแปรเพื่อเก็บยอดรวมทั้งเดือน
                        $columnTotals = [];
                    @endphp
                    @foreach ($wh->groupBy('productcode') as $ProductCode => $itemProductCode)
                    <tr>
                        <td>{{ $ProductCode }}</td>   
                        @php
                        $rowTotal = 0; // ตัวแปรเพื่อเก็บยอดรวมของลูกค้า
                    @endphp
                    @foreach ($groupedByDaywh as $day => $items) 
                        @php
                            // ค้นหา netamount ของลูกค้าในแต่ละเดือน
                            $purchase = $itemProductCode->firstWhere('pur_purchaseorder_wh_duedate', $day);
                            $amount = $purchase ? $purchase->pur_purchaseorder_wh_qty : 0;
                            $rowTotal += $amount; // เพิ่มยอดรวมรายลูกค้า
                            
                            // เพิ่มยอดรวมใน columnTotals
                            if (!isset($columnTotals[$day])) {
                                $columnTotals[$day] = 0; // กำหนดค่าเริ่มต้นถ้ายังไม่มี
                            }
                            $columnTotals[$day] += $amount; // เพิ่มยอดรวมของเดือน
                        @endphp
                        <td>{{ number_format($amount, 2) }}</td>
                    @endforeach
                    <td>{{ number_format($rowTotal, 2) }}</td> <!-- แสดงยอดรวมของลูกค้า -->     
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="row">
            <h4 class="card-title">Forecast</h4>
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center table-info">
                <thead>
                    <tr>
                        <th>Product</th>
                        @foreach ($groupedByDayfc as $day => $items)
                        <th>{{ \Carbon\Carbon::parse($day)->format('m/Y') }}</th>
                        @endforeach  
                        {{-- <th>Total</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                    // ตัวแปรเพื่อเก็บยอดรวมทั้งเดือน
                        $columnTotals = [];
                    @endphp
                    @foreach ($fc->groupBy('productcode') as $ProductCode => $itemProductCode)
                    <tr>
                        <td>{{ $ProductCode }}</td>   
                        @php
                        $rowTotal = 0; // ตัวแปรเพื่อเก็บยอดรวมของลูกค้า
                    @endphp
                    @foreach ($groupedByDayfc as $day => $items) 
                        @php
                            // ค้นหา netamount ของลูกค้าในแต่ละเดือน
                            $purchase = $itemProductCode->firstWhere('pur_purchaseorder_fc_duedate', $day);
                            $amount = $purchase ? $purchase->pur_purchaseorder_fc_qty : 0;
                            $rowTotal += $amount; // เพิ่มยอดรวมรายลูกค้า
                            
                            // เพิ่มยอดรวมใน columnTotals
                            if (!isset($columnTotals[$day])) {
                                $columnTotals[$day] = 0; // กำหนดค่าเริ่มต้นถ้ายังไม่มี
                            }
                            $columnTotals[$day] += $amount; // เพิ่มยอดรวมของเดือน
                        @endphp
                        <td>{{ number_format($amount, 2) }}</td>
                    @endforeach
                    {{-- <td>{{ number_format($rowTotal, 2) }}</td> <!-- แสดงยอดรวมของลูกค้า -->      --}}
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <hr>
        <div class="row">
            @if($hd->pur_purchaseorder_status_id == 6)
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
            @if($hd->pur_purchaseorder_status_id <> 10)     
            <div class="col-12 col-md-12">
                สถานะ :
                <select class="form-control" name="approved_status" id="approved_status">
                    <option>กรุณาเลือก</option>
                    @foreach ($sta as $item)
                        <option value="{{$item->pur_purchaseorder_status_id}}">{{$item->pur_purchaseorder_status_name}}</option>
                    @endforeach
                </select>
            </div>
            @endif
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
</div>
@endsection
@push('scriptjs')
<script>
</script>
@endpush