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
                <h3 class="card-title">ภาพรวมการเบิก</h3>
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
        <div class="row">
            <div class="col-12">
                <h3 class="card-title text-center">แยกตามสินค้า (จำนวน)</h3>
                <div style="overflow-x:auto;">   
                    <table id="tb_job1" class="table table-bordered">
                        <thead>
                            <tr>
                                <tr>
                                    <th>สินค้า</th>
                                    @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                        <th>{{ $monthYear }}</th>
                                    @endforeach
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalAmount = 0;
                                $groupedProduct = $hd->groupBy('pd_product_name1');
                            @endphp
                    
                            @foreach ($groupedProduct as $productName => $items)
                                <tr>
                                    <td>{{ $productName }}</td>
                                    @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                        @php
                                            $monthTotal = $items->whereIn('wh_issuestock_hd_date', collect($monthItems)->pluck('wh_issuestock_hd_date'))
                                                                 ->sum('wh_issuestock_dt_qty');
                                        @endphp
                                        <td>{{ number_format($monthTotal, 2) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ยอดรวมทั้งหมด</th>
                                @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                    @php
                                        $monthTotal = collect($monthItems)->sum('wh_issuestock_dt_qty');
                                    @endphp
                                    <th>{{ number_format($monthTotal, 2) }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>               
            </div>
            <div class="col-12">
                <h3 class="card-title text-center">แยกตามประเภท (มูลค่า)</h3>
                <div style="overflow-x:auto;">   
                    <table id="tb_job2" class="table table-bordered">
                        <thead>
                            <tr>
                                <tr>
                                    <th>ประเภท</th>
                                    @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                        <th>{{ $monthYear }}</th>
                                    @endforeach
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalAmount = 0;
                                $groupedType = $hd->groupBy('wh_issuetype_name');
                            @endphp
                    
                            @foreach ($groupedType as $productTypeName => $items)
                                <tr>
                                    <td>{{ $productTypeName }}</td>
                                    @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                        @php
                                            $monthTotal = $items->whereIn('wh_issuestock_hd_date', collect($monthItems)->pluck('wh_issuestock_hd_date'))
                                                                 ->sum('totalcost');
                                        @endphp
                                        <td>{{ number_format($monthTotal, 2) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ยอดรวมทั้งหมด</th>
                                @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                    @php
                                        $monthTotal = collect($monthItems)->sum('totalcost');
                                    @endphp
                                    <th>{{ number_format($monthTotal, 2) }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>             
            </div>
            <div class="col-12">
                <h3 class="card-title text-center">แยกตามกลุ่มสินค้า (มูลค่า)</h3>
                <div style="overflow-x:auto;">   
                    <table id="tb_job3" class="table table-bordered">
                        <thead>
                            <tr>
                                <tr>
                                    <th>กลุ่มสินค้า</th>
                                    @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                        <th>{{ $monthYear }}</th>
                                    @endforeach
                                </tr>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalAmount = 0;
                                $groupedGroup = $hd->groupBy('pd_productgroup_name');
                            @endphp
                    
                            @foreach ($groupedGroup as $GroupName => $items)
                                <tr>
                                    <td>{{ $GroupName }}</td>
                                    @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                        @php
                                            $monthTotal = $items->whereIn('wh_issuestock_hd_date', collect($monthItems)->pluck('wh_issuestock_hd_date'))
                                                                 ->sum('totalcost');
                                        @endphp
                                        <td>{{ number_format($monthTotal, 2) }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ยอดรวมทั้งหมด</th>
                                @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                    @php
                                        $monthTotal = collect($monthItems)->sum('totalcost');
                                    @endphp
                                    <th>{{ number_format($monthTotal, 2) }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>             
            </div>
        </div>    
    </div>
</div>
</div>
@php
    // แปลง array เป็น Collection เพื่อให้สามารถใช้ keys() ได้
    $groupedType = collect($groupedType);
    $groupedByMonthYear = collect($groupedByMonthYear);
@endphp
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
$(document).ready(function() {
    $('#tb_job1').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'excel',
        ]
    })
});
$(document).ready(function() {
    $('#tb_job2').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'excel',
        ]
    })
});
$(document).ready(function() {
    $('#tb_job3').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'excel',
        ]
    })
});
</script>
@endpush