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
                <h3 class="card-title">ผลผลิตประจำวัน</h3>
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
            <h3 class="card-title text-center">Skin : L1 วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart1" width="400" height="200"></canvas>
                <table id="tb_job1" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL1 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd1->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL1 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>
        <div class="row">   
            <h3 class="card-title text-center">Door console 640A  : L2 วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart2" width="400" height="200"></canvas>
                <table id="tb_job2" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL2 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd2->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL2 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div> 
        <div class="row">   
            <h3 class="card-title text-center">Line : Hood - Door S/A วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart3" width="400" height="200"></canvas>
                <table id="tb_job3" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL3 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd3->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL3 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div> 
        <div class="row">   
            <h3 class="card-title text-center">Line : Door console 230B,384D วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart4" width="400" height="200"></canvas>
                <table id="tb_job4" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL4 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd4->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL4 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>  
        <div class="row">   
            <h3 class="card-title text-center">Line : Garnish console วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart5" width="400" height="200"></canvas>
                <table id="tb_job5" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL5 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd5->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL5 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>    
        <div class="row">   
            <h3 class="card-title text-center">Line : Shifting hole 230B วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart6" width="400" height="200"></canvas>
                <table id="tb_job6" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL6 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd6->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL6 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div> 
        <div class="row">   
            <h3 class="card-title text-center">Line : Brake 230B/350B วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart7" width="400" height="200"></canvas>
                <table id="tb_job7" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL7 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd7->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL7 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>  
        <div class="row">   
            <h3 class="card-title text-center">Line : Tonneua วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart8" width="400" height="200"></canvas>
                <table id="tb_job8" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL8 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd8->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL8 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div> 
        <div class="row">   
            <h3 class="card-title text-center">Line : Mirage วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart9" width="400" height="200"></canvas>
                <table id="tb_job9" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL9 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd9->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL9 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>    
        <div class="row">   
            <h3 class="card-title text-center">Line : Brake 640e วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart10" width="400" height="200"></canvas>
                <table id="tb_job10" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL10 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd10->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL10 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>     
        <div class="row">   
            <h3 class="card-title text-center">Line : Shifting hole D92A วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart11" width="400" height="200"></canvas>
                <table id="tb_job11" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL11 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd11->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL11 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>  
        <div class="row">   
            <h3 class="card-title text-center">Line : Shifting hole 650A วันที่ {{ $datestart }} ถึง {{ $dateend }}</h3>
            <div style="overflow-x:auto;">
                <canvas id="myChart12" width="400" height="200"></canvas>
                <table id="tb_job12" class="table table-bordered nowrap w-100 text-center table-sm">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL12 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd12->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL12 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
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
$(document).ready(function() {
    $('#tb_job4').DataTable({
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
    $('#tb_job5').DataTable({
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
    $('#tb_job6').DataTable({
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
    $('#tb_job7').DataTable({
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
    $('#tb_job8').DataTable({
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
    $('#tb_job9').DataTable({
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
    $('#tb_job10').DataTable({
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
    $('#tb_job11').DataTable({
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
    $('#tb_job12').DataTable({
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
var data = @json($hd1); // ข้อมูลจาก server

    // สร้าง labels จากชื่อ Model/Product
    var labels = [];
    @foreach ($hd1->groupBy('mpd') as $productName => $itemsByProduct)
        labels.push('{{ $productName }}');
    @endforeach

    // สร้าง datasets สำหรับแต่ละ line
    var datasets = [];
    @foreach ($groupedByL1 as $line => $items)
        var lineData = [];
        @foreach ($hd1->groupBy('mpd') as $productName => $itemsByProduct)
            @php
                $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                $amount = $purchase ? $purchase->total : 0;
            @endphp
            lineData.push({{ $amount }});
        @endforeach

        datasets.push({
            label: '{{ $line }}', // ชื่อของแต่ละ line
            data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
            backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
            borderColor: 'rgba(0, 0, 0, 0.1)',
            borderWidth: 1
        });
    @endforeach

    // ฟังก์ชันสุ่มสี
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // สร้างกราฟ
    var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
        data: {
            labels: labels, // ใส่ labels (ชื่อ Model/Product)
            datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
    var data = @json($hd2); // ข้อมูลจาก server

    // สร้าง labels จากชื่อ Model/Product
    var labels = [];
    @foreach ($hd2->groupBy('mpd') as $productName => $itemsByProduct)
        labels.push('{{ $productName }}');
    @endforeach

    // สร้าง datasets สำหรับแต่ละ line
    var datasets = [];
    @foreach ($groupedByL2 as $line => $items)
        var lineData = [];
        @foreach ($hd2->groupBy('mpd') as $productName => $itemsByProduct)
            @php
                $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
                $amount = $purchase ? $purchase->total : 0;
            @endphp
            lineData.push({{ $amount }});
        @endforeach

        datasets.push({
            label: '{{ $line }}', // ชื่อของแต่ละ line
            data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
            backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
            borderColor: 'rgba(0, 0, 0, 0.1)',
            borderWidth: 1
        });
    @endforeach

    // ฟังก์ชันสุ่มสี
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    // สร้างกราฟ
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
        data: {
            labels: labels, // ใส่ labels (ชื่อ Model/Product)
            datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
    var data = @json($hd3); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd3->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL3 as $line => $items)
    var lineData = [];
    @foreach ($hd3->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd4); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd4->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL4 as $line => $items)
    var lineData = [];
    @foreach ($hd4->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart4').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd5); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd5->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL5 as $line => $items)
    var lineData = [];
    @foreach ($hd5->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart5').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd6); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd6->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL6 as $line => $items)
    var lineData = [];
    @foreach ($hd6->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart6').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd7); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd7->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL7 as $line => $items)
    var lineData = [];
    @foreach ($hd7->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart7').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd8); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd8->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL8 as $line => $items)
    var lineData = [];
    @foreach ($hd8->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart8').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd9); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd9->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL9 as $line => $items)
    var lineData = [];
    @foreach ($hd9->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart9').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd10); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd10->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL10 as $line => $items)
    var lineData = [];
    @foreach ($hd10->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart10').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd11); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd11->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL11 as $line => $items)
    var lineData = [];
    @foreach ($hd11->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart11').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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
var data = @json($hd12); // ข้อมูลจาก server

// สร้าง labels จากชื่อ Model/Product
var labels = [];
@foreach ($hd12->groupBy('mpd') as $productName => $itemsByProduct)
    labels.push('{{ $productName }}');
@endforeach

// สร้าง datasets สำหรับแต่ละ line
var datasets = [];
@foreach ($groupedByL12 as $line => $items)
    var lineData = [];
    @foreach ($hd12->groupBy('mpd') as $productName => $itemsByProduct)
        @php
            $purchase = $itemsByProduct->firstWhere('pdt_process_dt_name', $line);
            $amount = $purchase ? $purchase->total : 0;
        @endphp
        lineData.push({{ $amount }});
    @endforeach

    datasets.push({
        label: '{{ $line }}', // ชื่อของแต่ละ line
        data: lineData, // ข้อมูลของแต่ละ line ตาม Model/Product
        backgroundColor: getRandomColor(), // สุ่มสีสำหรับแต่ละชุดข้อมูล
        borderColor: 'rgba(0, 0, 0, 0.1)',
        borderWidth: 1
    });
@endforeach

// ฟังก์ชันสุ่มสี
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// สร้างกราฟ
var ctx = document.getElementById('myChart12').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // ประเภทกราฟ (เช่น 'bar', 'line' ฯลฯ)
    data: {
        labels: labels, // ใส่ labels (ชื่อ Model/Product)
        datasets: datasets // ใส่ datasets ที่สร้างจากข้อมูลของแต่ละ line
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