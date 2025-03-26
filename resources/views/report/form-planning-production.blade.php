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
        <h4 class="card-title">เป้าผลิตประจำวัน</h4>   
        <form method="GET" class="form-horizontal">
            @csrf
        <div class="row">          
            <div class="col-12 col-md-3">
                <input type="date" class="form-control" name="datestart" id="datestart" value="{{$datestart}}">
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>
        </div>
        </form>
        <br>
        <div style="overflow-x:auto;">
           {{-- <table class="table">
            <thead>
                <tr>
                    <th>Line/Process</th>
                    <th>Day</th>
                    <th>OT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hdsum as $item)
                <tr>
                    <td>{{$item->process}}</td>
                    <td>{{number_format($item->qty,0)}}</td>               
                    <td>{{number_format($item->qtyot,0)}}</td>
                </tr>
            @endforeach
            </tbody>
           </table> --}}
           <canvas id="myChart" width="400" height="200"></canvas>
            <table id="tb_job" class="table table-bordered nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>Line</th>
                        <th>Process</th>
                        <th>Person</th>
                        <th>Target</th>
                        <th>Day</th>
                        <th>OT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hd as $item)
                        <tr>
                            <td>{{$item->pdt_productresult_hd_line}}</td>
                            <td>{{$item->pdt_process_dt_name}}</td>
                            <td>{{$item->emp_person_fullname}}</td>
                            <td>{{number_format($item->emp_person_target,0)}}</td>
                            @if ($item->qty < $item->emp_person_target)
                                <td style="color: red">
                                    {{number_format($item->qty,0)}}
                                </td>
                            @else
                                <td>
                                    {{number_format($item->qty,0)}}
                                </td>
                            @endif
                            
                            <td>{{number_format($item->qtyot,0)}}</td>
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
var data = @json($hdsum); // ข้อมูลจาก server จะถูกแปลงเป็น JSON
    
    var labels = data.map(function(item) {
        return item.process; // เอาค่า 'process' มาใช้เป็น label
    });

    var qtyData = data.map(function(item) {
        return item.qty; // เอาค่า 'qty' มาใช้เป็นข้อมูลของกราฟ
    });

    var qtyotData = data.map(function(item) {
        return item.qtyot; // เอาค่า 'qtyot' มาใช้เป็นข้อมูลของกราฟ
    });

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // ประเภทของกราฟที่ต้องการ (เช่น 'line', 'bar', 'pie' ฯลฯ)
        data: {
            labels: labels, // labels ของกราฟ
            datasets: [{
                label: 'Day', // ชื่อ Dataset 1
                data: qtyData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'OT', // ชื่อ Dataset 2
                data: qtyotData,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                datalabels: {
                    display: true, // ให้แสดงตัวเลข
                    color: 'black', // สีตัวเลข
                    font: {
                        weight: 'bold', // ความหนาของฟอนต์
                        size: 14 // ขนาดฟอนต์
                    },
                    align: 'center', // การจัดตำแหน่งตัวเลข
                    formatter: function(value) {
                        return value.toLocaleString(); // แสดงตัวเลขในรูปแบบที่อ่านง่าย (เช่น 1,000)
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
        plugins: [ChartDataLabels] // ใช้ plugin datalabels
    });
</script>
@endpush