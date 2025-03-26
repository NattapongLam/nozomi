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
    <h4 class="card-title">ผลผลิตประจำเดือน</h4>    
    <form method="GET" class="form-horizontal">
    @csrf
    <div class="row">      
    <div class="col-12 col-md-3">
        <div class="mb-3 row">
            <label for="years" class="col-md-3 col-form-label">ปี</label>
            <div class="col-md-9">
                <select class="form-control" name="years" id="years">
                    <option value="">ระบุปี</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="mb-3 row">
            <label for="months" class="col-md-3 col-form-label">เดือน</label>
            <div class="col-md-9">
                <select class="form-control" name="months" id="months">
                    <option value="">ระบุเดือน</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
        </div>
        </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>
        </div>
        </form>
        <br>
        <div class="row">
            <h3 class="card-title text-center">Line : L1  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <canvas id="myChart1" width="400" height="200"></canvas>
                <table class="table table-bordered nowrap w-100 text-center">
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
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
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
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL1 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div> 
        <div class="row">
            <h3 class="card-title text-center">Line : L2  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <canvas id="myChart2" width="400" height="200"></canvas>
                <table class="table table-bordered nowrap w-100 text-center">
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
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
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
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL2 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <h3 class="card-title text-center">Line : L3  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <canvas id="myChart3" width="400" height="200"></canvas>
                <table class="table table-bordered nowrap w-100 text-center">
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
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
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
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL3 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div> 
        <div class="row">
            <h3 class="card-title text-center">Line : L4  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <canvas id="myChart4" width="400" height="200"></canvas>
                <table class="table table-bordered nowrap w-100 text-center">
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
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
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
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL4 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
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
var products = @json(array_unique(array_column($groupedByL1['Plan'], 'product')));
// สร้างยอดรวมสำหรับแต่ละ product และ jobtype
var totals = {
    'Plan': [],
    'Actual': [],
    'Final': []
};
products.forEach(function(product) {
    // กรองข้อมูลที่มี 'product' ตรงกับที่ต้องการ และหายอดรวม
    var planTotal = @json($groupedByL1['Plan']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);
    var actualTotal = @json($groupedByL1['Actual']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);
    var finalTotal = @json($groupedByL1['Final']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);

    totals['Plan'].push(planTotal.toFixed(2));
    totals['Actual'].push(actualTotal.toFixed(2));
    totals['Final'].push(finalTotal.toFixed(2));
});
var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: products,
            datasets: [{
                label: 'Plan',
                data: totals['Plan'],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Actual',
                data: totals['Actual'],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Final',
                data: totals['Final'],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(2);  // แสดงทศนิยม 2 ตำแหน่ง
                        }
                    }
                }
            }
        }
    });
var products = @json(array_unique(array_column($groupedByL2['Plan'], 'product')));
// สร้างยอดรวมสำหรับแต่ละ product และ jobtype
var totals = {
    'Plan': [],
    'Actual': [],
    'Final': []
};
products.forEach(function(product) {
    // กรองข้อมูลที่มี 'product' ตรงกับที่ต้องการ และหายอดรวม
    var planTotal = @json($groupedByL2['Plan']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);
    var actualTotal = @json($groupedByL2['Actual']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);
    var finalTotal = @json($groupedByL2['Final']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);

    totals['Plan'].push(planTotal);
    totals['Actual'].push(actualTotal);
    totals['Final'].push(finalTotal);
});
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: products,  // ชื่อของแต่ละ Product
        datasets: [{
            label: 'Plan',
            data: totals['Plan'],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Actual',
            data: totals['Actual'],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }, {
            label: 'Final',
            data: totals['Final'],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
var products = @json(array_unique(array_column($groupedByL3['Plan'], 'product')));
// สร้างยอดรวมสำหรับแต่ละ product และ jobtype
var totals = {
    'Plan': [],
    'Actual': [],
    'Final': []
};
products.forEach(function(product) {
    // กรองข้อมูลที่มี 'product' ตรงกับที่ต้องการ และหายอดรวม
    var planTotal = @json($groupedByL3['Plan']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);
    var actualTotal = groupedByL3.Actual ? groupedByL3.Actual.filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0) : 0;
    var finalTotal = groupedByL3.Final ? groupedByL3.Final.filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0) : 0;

    totals['Plan'].push(planTotal);
    totals['Actual'].push(actualTotal);
    totals['Final'].push(finalTotal);
});
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: products,  // ชื่อของแต่ละ Product
        datasets: [{
            label: 'Plan',
            data: totals['Plan'],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Actual',
            data: totals['Actual'],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }, {
            label: 'Final',
            data: totals['Final'],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
var products = @json(array_unique(array_column($groupedByL4['Plan'], 'product')));
// สร้างยอดรวมสำหรับแต่ละ product และ jobtype
var totals = {
    'Plan': [],
    'Actual': [],
    'Final': []
};
products.forEach(function(product) {
    // กรองข้อมูลที่มี 'product' ตรงกับที่ต้องการ และหายอดรวม
    var planTotal = @json($groupedByL4['Plan']).filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0);
    var actualTotal = groupedByL4.Actual ? groupedByL4.Actual.filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0) : 0;
    var finalTotal = groupedByL4.Final ? groupedByL4.Final.filter(function(item) { return item.product === product; }).reduce(function(acc, curr) { return acc + parseFloat(curr.total); }, 0) : 0;

    totals['Plan'].push(planTotal);
    totals['Actual'].push(actualTotal);
    totals['Final'].push(finalTotal);
});
var ctx = document.getElementById('myChart4').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: products,  // ชื่อของแต่ละ Product
        datasets: [{
            label: 'Plan',
            data: totals['Plan'],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Actual',
            data: totals['Actual'],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }, {
            label: 'Final',
            data: totals['Final'],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush