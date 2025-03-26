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
                <h3 class="card-title">การส่งสินค้าประจำวัน</h3>
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
        <canvas id="myChart" width="400" height="200"></canvas>
           <table id="tb_job" class="table table-bordered">
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
                @endphp
        
                @foreach ($groupedMpd as $MpdName => $items)
                    <tr>
                        <td>{{ $MpdName }}</td>
                        @foreach ($groupedByDay as $Days => $dayItems)
                            @php
                                $dayTotal = $items->whereIn('date', collect($dayItems)->pluck('date'))
                                                     ->sum('qty');
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
var data = @json($groupedMpd); // ข้อมูลจาก server

var labels = []; // วันทั้งหมด
@foreach ($groupedByDay as $Days => $dayItems)
    labels.push('{{ $Days }}'); // สร้าง labels สำหรับกราฟ
@endforeach

// กำหนดข้อมูลที่จะใช้ในการสร้างกราฟ
var datasets = [];
@foreach ($groupedMpd as $MpdName => $items)
    var qtyData = [];
    @foreach ($groupedByDay as $Days => $dayItems)
        @php
            $dayTotal = $items->whereIn('date', collect($dayItems)->pluck('date'))->sum('qty');
        @endphp
        qtyData.push({{ $dayTotal }});
    @endforeach

    datasets.push({
        label: '{{ $MpdName }}', // ชื่อแต่ละชุดข้อมูล
        data: qtyData, // ข้อมูลของกราฟ (qty ตามวัน)
        backgroundColor: getRandomColor(), // กำหนดสีที่สุ่ม
        borderColor: 'rgba(0, 0, 0, 0.1)', // สีขอบ
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันเพื่อสุ่มสีให้กับแต่ละกราฟ
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (bar หรือ line)
    data: {
        labels: labels, // ใส่ labels
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูล
    },
    options: {
        plugins: {
            datalabels: {
                display: true, // ให้แสดงตัวเลข
                color: 'black',
                font: {
                    weight: 'bold',
                    size: 14
                },
                align: 'center',
                formatter: function(value) {
                    return value.toLocaleString(); // แสดงตัวเลขแบบมีคอมม่า
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
    plugins: [ChartDataLabels] // ใช้ plugin สำหรับแสดงตัวเลข
});
</script>
@endpush