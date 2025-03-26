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
                <h3 class="card-title">รายงานการรับเข้า</h3>
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
        <hr>
        <div style="overflow-x:auto;">
            <h3 class="card-title text-center">รับเข้าสินค้าจากการผลิต</h3>
            <canvas id="myChart1" width="400" height="200"></canvas>
            <table id="tb_job1" class="table table-bordered">
            <thead>
                <tr>
                    <th>Model/Product</th>
                    @foreach ($groupedByDay as $Days => $dayItems)
                    <th>{{ $Days }}</th>
                @endforeach
                </tr>
            </thead>          
            <tbody>
                @php
                    $totalAmount = 0;
                    $groupedMpd = $hd->groupBy('mpd');
                    // คำนวณผลรวมตามวัน
                    $dayTotals = [];
                    foreach ($groupedByDay as $Days => $dayItems) {
                        $totalForDay = 0;
                        foreach ($groupedMpd as $MpdName => $items) {
                            $totalForDay += $items->whereIn('fg_receiveproduct_hd_date', collect($dayItems)->pluck('fg_receiveproduct_hd_date'))->sum('fg_receiveproduct_dt_qty');
                        }
                        $dayTotals[$Days] = $totalForDay;
                    }
                @endphp
        
                @foreach ($groupedMpd as $MpdName => $items)
                    <tr>
                        <td>{{ $MpdName }}</td>
                        @foreach ($groupedByDay as $Days => $dayItems)
                            @php
                                $dayTotal = $items->whereIn('fg_receiveproduct_hd_date', collect($dayItems)->pluck('fg_receiveproduct_hd_date'))
                                                     ->sum('fg_receiveproduct_dt_qty');
                            @endphp
                            <td>{{ number_format($dayTotal, 2) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
           </table>
        </div>
        <div style="overflow-x:auto;">
            <h3 class="card-title text-center">รับเข้า PU</h3>
            <canvas id="myChart2" width="400" height="200"></canvas>
            <table id="tb_job2" class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    @foreach ($groupedByDay1 as $Days => $dayItems)
                    <th>{{ $Days }}</th>
                @endforeach
                </tr>
            </thead>          
            <tbody>
                @php
                    $totalAmount = 0;
                    $groupedMpd = $hd1->groupBy('productcode');
                    // คำนวณผลรวมตามวัน
                    $dayTotals1 = [];
                    foreach ($groupedByDay1 as $Days => $dayItems) {
                        $totalForDay = 0;
                        foreach ($groupedMpd as $MpdName => $items) {
                            $totalForDay += $items->whereIn('wh_receivepu_hd_date', collect($dayItems)->pluck('wh_receivepu_hd_date'))->sum('wh_receivepu_dt_qty');
                        }
                        $dayTotals1[$Days] = $totalForDay;
                    }
                @endphp
        
                @foreach ($groupedMpd as $MpdName => $items)
                    <tr>
                        <td>{{ $MpdName }}</td>
                        @foreach ($groupedByDay1 as $Days => $dayItems)
                            @php
                                $dayTotal = $items->whereIn('wh_receivepu_hd_date', collect($dayItems)->pluck('wh_receivepu_hd_date'))
                                                     ->sum('wh_receivepu_dt_qty');
                            @endphp
                            <td>{{ number_format($dayTotal, 2) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
           </table>
        </div>
        <div style="overflow-x:auto;">
            <h3 class="card-title text-center">รับเข้าสินค้า</h3>
            <canvas id="myChart3" width="400" height="200"></canvas>
            <table id="tb_job2" class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    @foreach ($groupedByDay2 as $Days => $dayItems)
                    <th>{{ $Days }}</th>
                @endforeach
                </tr>
            </thead>          
            <tbody>
                @php
                    $totalAmount = 0;
                    $groupedMpd = $hd2->groupBy('pd_product_name1');
                    // คำนวณผลรวมตามวัน
                    $dayTotals2 = [];
                    foreach ($groupedByDay2 as $Days => $dayItems) {
                        $totalForDay = 0;
                        foreach ($groupedMpd as $MpdName => $items) {
                            $totalForDay += $items->whereIn('wh_receiveproduct_hd_date', collect($dayItems)->pluck('wh_receiveproduct_hd_date'))->sum('wh_receiveproduct_dt_qty');
                        }
                        $dayTotals2[$Days] = $totalForDay;
                    }
                @endphp
        
                @foreach ($groupedMpd as $MpdName => $items)
                    <tr>
                        <td>{{ $MpdName }}</td>
                        @foreach ($groupedByDay2 as $Days => $dayItems)
                            @php
                                $dayTotal = $items->whereIn('wh_receiveproduct_hd_date', collect($dayItems)->pluck('wh_receiveproduct_hd_date'))
                                                     ->sum('wh_receiveproduct_dt_qty');
                            @endphp
                            <td>{{ number_format($dayTotal, 2) }}</td>
                        @endforeach
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
$(document).ready(function() {
    $('#tb_job1').DataTable({
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
$(document).ready(function() {
    $('#tb_job2').DataTable({
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
 // ดึงข้อมูลจาก Blade ที่คำนวณแล้ว
 var dayTotals = @json($dayTotals); // ผลรวมของ fg_receiveproduct_dt_qty ตามวัน
    var days = Object.keys(dayTotals); // ดึงวันที่ทั้งหมด
    var totals = Object.values(dayTotals); // ดึงผลรวมตามวัน

    // สร้างกราฟ
    var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // ประเภทกราฟ (bar หรือ line)
        data: {
            labels: days, // ใส่ labels (วันที่)
            datasets: [{
                label: 'Total Quantity by Day', // ชื่อชุดข้อมูล
                data: totals, // ผลรวมตามวัน
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // สีของแท่งกราฟ
                borderColor: 'rgba(54, 162, 235, 1)', // สีของขอบแท่ง
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    display: true, // แสดงตัวเลข
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    align: 'center',
                    formatter: function(value) {
                        return value.toLocaleString(); // แสดงตัวเลขในรูปแบบที่อ่านง่าย
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true // เริ่มต้นแกน Y ที่ 0
                }
            }
        },
        plugins: [ChartDataLabels] // ใช้ plugin สำหรับแสดงตัวเลข
    });
     // ดึงข้อมูลจาก Blade ที่คำนวณแล้ว
    var dayTotals1 = @json($dayTotals1); // ผลรวมของ fg_receiveproduct_dt_qty ตามวัน
    var days1 = Object.keys(dayTotals1); // ดึงวันที่ทั้งหมด
    var totals1 = Object.values(dayTotals1); // ดึงผลรวมตามวัน

    // สร้างกราฟ
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // ประเภทกราฟ (bar หรือ line)
        data: {
            labels: days1, // ใส่ labels (วันที่)
            datasets: [{
                label: 'Total Quantity by Day', // ชื่อชุดข้อมูล
                data: totals1, // ผลรวมตามวัน
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // สีของแท่งกราฟ
                borderColor: 'rgba(54, 162, 235, 1)', // สีของขอบแท่ง
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    display: true, // แสดงตัวเลข
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    align: 'center',
                    formatter: function(value) {
                        return value.toLocaleString(); // แสดงตัวเลขในรูปแบบที่อ่านง่าย
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true // เริ่มต้นแกน Y ที่ 0
                }
            }
        },
        plugins: [ChartDataLabels] // ใช้ plugin สำหรับแสดงตัวเลข
    });
     // ดึงข้อมูลจาก Blade ที่คำนวณแล้ว
     var dayTotals2 = @json($dayTotals2); // ผลรวมของ fg_receiveproduct_dt_qty ตามวัน
    var days2 = Object.keys(dayTotals2); // ดึงวันที่ทั้งหมด
    var totals2 = Object.values(dayTotals2); // ดึงผลรวมตามวัน

    // สร้างกราฟ
    var ctx = document.getElementById('myChart3').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // ประเภทกราฟ (bar หรือ line)
        data: {
            labels: days2, // ใส่ labels (วันที่)
            datasets: [{
                label: 'Total Quantity by Day', // ชื่อชุดข้อมูล
                data: totals2, // ผลรวมตามวัน
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // สีของแท่งกราฟ
                borderColor: 'rgba(54, 162, 235, 1)', // สีของขอบแท่ง
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    display: true, // แสดงตัวเลข
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 14
                    },
                    align: 'center',
                    formatter: function(value) {
                        return value.toLocaleString(); // แสดงตัวเลขในรูปแบบที่อ่านง่าย
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true // เริ่มต้นแกน Y ที่ 0
                }
            }
        },
        plugins: [ChartDataLabels] // ใช้ plugin สำหรับแสดงตัวเลข
    });
</script>
@endpush