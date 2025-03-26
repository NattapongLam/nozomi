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
                    <canvas id="myChart" width="400" height="200"></canvas>
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
                                $groupedByDate = $hd->groupBy('wh_issuestock_hd_date');
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
                    <canvas id="myBarChart" width="400" height="200"></canvas>
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
                                $labels = [];
                                $data = [];
                                $colors = ['#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#9B59B6'];  // สีที่ใช้แยกประเภท
                                $colorIndex = 0;

                                foreach ($groupedByMonthYear as $monthYear => $monthItems) {
                                    $labels[] = $monthYear;  // รายเดือนหรือปี
                                }

                                foreach ($groupedType as $productTypeName => $items) {
                                    $typeData = [];
                                    foreach ($groupedByMonthYear as $monthYear => $monthItems) {
                                        $monthTotal = $items->whereIn('wh_issuestock_hd_date', collect($monthItems)->pluck('wh_issuestock_hd_date'))
                                            ->sum('totalcost');
                                        $typeData[] = $monthTotal;
                                    }
                                    $data[] = [
                                        'label' => $productTypeName,
                                        'data' => $typeData,
                                        'borderColor' => $colors[$colorIndex % count($colors)],  // สีของเส้นขอบ
                                        'backgroundColor' => $colors[$colorIndex % count($colors)],  // สีของแถบ
                                        'datalabels' => [
                                            'anchor' => 'end',
                                            'align' => 'top',
                                            'color' => '#000000',
                                            'font' => [
                                                'weight' => 'bold',
                                                'size' => 10
                                            ]
                                        ]
                                    ];
                                    $colorIndex++;
                                }                    
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
                    <canvas id="myPieChart" width="400" height="400"></canvas>
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
  // ข้อมูลจาก PHP
  var groupedByDate = @json($groupedByDate); 

// ดึงวันที่ทั้งหมดและเรียงลำดับ
var dateLabels = Object.keys(groupedByDate).sort();

// คำนวณยอดรวมของแต่ละวัน
var dailyTotals = dateLabels.map(function(date) {
    var total = groupedByDate[date].reduce((sum, item) => sum + parseFloat(item.wh_issuestock_dt_qty), 0);
    return total.toFixed(2);
});

// สร้างกราฟ Chart.js
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line', // ใช้ Line Chart
    data: {
        labels: dateLabels,
        datasets: [{
            label: 'ยอดขายรวมสินค้าทั้งหมด',
            data: dailyTotals,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            fill: true,
            pointRadius: 5, // ขนาดของจุดข้อมูล
            pointBackgroundColor: 'rgba(75, 192, 192, 1)', // สีของจุดข้อมูล
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end', // ตำแหน่งของตัวเลข
                align: 'top',  // ให้แสดงอยู่ด้านบนของจุด
                formatter: function(value) {
                    return value; // แสดงค่าของแต่ละจุด
                },
                font: {
                    weight: 'bold'
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'วันที่'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'จำนวนสินค้า'
                }
            }
        }
    },
    plugins: [ChartDataLabels] // เปิดใช้ Data Labels Plugin
});
var ctx = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',  // กราฟแบบ bar
        data: {
            labels: @json($labels),  // รายเดือน/ปี
            datasets: @json($data)   // ข้อมูลของแต่ละประเภท
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return value.toLocaleString(); }  // แสดงตัวเลขเป็น format
                    }
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                datalabels: {  // เพิ่มตัวเลขบนกราฟ
                    display: true,
                    color: 'black',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: function(value, context) {
                        return value.toLocaleString();  // แสดงตัวเลขในรูปแบบที่อ่านง่าย
                    }
                }
            }
        },
        plugins: [ChartDataLabels]  // เปิดใช้งาน plugin Data Labels
    });
    var ctx = document.getElementById('myPieChart').getContext('2d');

var data = {
    labels: [@foreach($groupedGroup as $GroupName => $items) "{{ $GroupName }}", @endforeach],
    datasets: [{
        label: 'ยอดรวมทั้งหมด',
        data: [
            @foreach($groupedGroup as $GroupName => $items)
                @php
                    $totalGroup = $items->sum('totalcost');
                @endphp
                {{ $totalGroup }},
            @endforeach
        ],
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
        ],
        borderWidth: 1
    }]
};

var config = {
    type: 'pie',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                    }
                }
            },
            datalabels: {
                color: '#fff', // กำหนดสีข้อความ
                display: true, // ให้แสดงข้อความ
                anchor: 'center', // การจัดตำแหน่งข้อความให้ตรงกลาง
                formatter: function(value, context) {
                    var total = context.chart._metasets[context.datasetIndex].data.reduce(function(a, b) { return a + b; }, 0); // คำนวณยอดรวมทั้งหมด
                    var percentage = ((value / total) * 100).toFixed(2) + '%'; // คำนวณเปอร์เซ็นต์
                    return value.toFixed(2) + ' (' + percentage + ')'; // แสดงตัวเลขและเปอร์เซ็นต์
                },
                font: {
                    weight: 'bold',
                    size: 14, // ขนาดตัวอักษร
                },
                align: 'center', // จัดตำแหน่งข้อความ
                offset: 10, // เพิ่มระยะห่างถ้าจำเป็น
            }
        }
    }
};

var myPieChart = new Chart(ctx, config);
</script>
@endpush