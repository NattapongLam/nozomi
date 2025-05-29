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
        <?php
        $currentYear = date('Y');  // ปีปัจจุบัน
        $years = range($currentYear, $currentYear - 10); // แสดงปีย้อนหลัง 10 ปี
        $months = [
        1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน', 5 => 'พฤษภาคม', 
        6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม', 9 => 'กันยายน', 
        10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $currentMonth = date('m');  // เดือนปัจจุบัน
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);  // จำนวนวันในเดือนปัจจุบัน
        ?>
        <div class="row">
            <h3 class="card-title text-center">Line : Brake 230B/350B  เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart1" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job1">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd1 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
         <div class="row">
            <h3 class="card-title text-center">Line : Brake 640  เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart2" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job2">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd2 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
        <div class="row">
            <h3 class="card-title text-center">Line : Door console 230B,384D  เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart3" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job3">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd3 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
         <div class="row">
            <h3 class="card-title text-center">Line : Door console 640A   เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart4" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job4">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd4 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
        <div class="row">
            <h3 class="card-title text-center">Line : Garnish console   เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart5" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job5">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd5 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
        <div class="row">
            <h3 class="card-title text-center">Line : Hood - Door S/A   เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart6" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job6">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd6 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
        <div class="row">
            <h3 class="card-title text-center">Line : Shifting hole D92A   เดือน : {{$year}}/{{$month}}</h3>
            <canvas id="barChart7" width="400" height="200"></canvas>    
            <div style="overflow-x:auto;">   
                <table class="table table-bordered" id="tb_job7">              
                    <thead>
                        <tr>                    
                            <th>Process</th>
                            <th>Model/Product</th>
                            <th>QTY</th>
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd6 as $item)
                            <tr>                        
                                <td>{{$item->pdt_process_dt_listno}}.{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->total,0)}}</td>                              
                            </tr>
                        @endforeach
                    </tbody>           
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
@php
    $grouped1 = $hd1->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
    $grouped2 = $hd2->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
    $grouped3 = $hd3->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
    $grouped4 = $hd4->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
    $grouped5 = $hd5->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
    $grouped6 = $hd6->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
    $grouped7 = $hd7->groupBy(function($item) {
        return $item->pdt_process_dt_listno . '.' . $item->pdt_process_dt_name;
    })->map(function($items) {
        return $items->sum('total');
    });
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
const labels = @json($grouped1->keys());
const data = @json($grouped1->values());
const ctx = document.getElementById('barChart1').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
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
const labels = @json($grouped2->keys());
const data = @json($grouped2->values());
const ctx = document.getElementById('barChart2').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
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
const labels = @json($grouped3->keys());
const data = @json($grouped3->values());
const ctx = document.getElementById('barChart3').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
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
const labels = @json($grouped4->keys());
const data = @json($grouped4->values());
const ctx = document.getElementById('barChart4').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
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
const labels = @json($grouped5->keys());
const data = @json($grouped5->values());
const ctx = document.getElementById('barChart5').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
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
const labels = @json($grouped6->keys());
const data = @json($grouped6->values());
const ctx = document.getElementById('barChart6').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
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
const labels = @json($grouped7->keys());
const data = @json($grouped7->values());
const ctx = document.getElementById('barChart7').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดรวมจำนวนตาม Process',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                anchor: 'end',
                align: 'top',
                color: '#000',
                font: {
                    weight: 'bold'
                },
                formatter: function(value) {
                    return value.toLocaleString(); // คอมม่าแยกหลักพัน
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});
});
</script>
@endpush