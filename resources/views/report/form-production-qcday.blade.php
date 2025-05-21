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
                <h3 class="card-title">ตรวจผลผลิตประจำวัน</h3>
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
        <canvas id="jobBarChart" width="100%" height="40"></canvas>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>  
                    <th>วันที่</th>     
                    <th>Line</th>     
                    <th>Model/Product</th>                                       
                    <th>จำนวนส่งงาน</th>     
                    <th>ผู้ตรวจ</th> 
                    <th>จำนวนตรวจจริง</th>        
                </tr>
            </thead>
            <tbody>       
                  @foreach ($hd as $item)
                      <tr>
                        <td>
                            {{ Carbon\Carbon::parse($item->date)->format('d/m/Y')}}
                        </td>
                        <td>{{$item->line}}</td>
                        <td>{{$item->model}}/{{$item->product}}</td>                        
                        <td>
                            ปกติ : {{$item->pdt_productqc_dt_qty}} / OT : {{$item->pdt_productqc_dt_qtyot}}
                        </td>
                        <td>
                            {{$item->pdt_productqc_hd_save}}
                        </td>
                        <td>
                            ปกติ : {{$item->pdt_productqc_dt_loss}} / OT : {{$item->pdt_productqc_dt_lossot}}
                        </td>                       
                      </tr>
                  @endforeach
            </tbody>
        </table>
    </div>
</div>
@php
$grouped = $hd->groupBy(function($item) {
    return \Carbon\Carbon::parse($item->date)->format('d/m/Y');
});
$labels = [];
$normalSum = [];
$otSum = [];

foreach ($grouped as $date => $items) {
    $labels[] = $date;
    $normalSum[] = $items->sum('pdt_productqc_dt_loss');
    $otSum[] = $items->sum('pdt_productqc_dt_lossot');
}
@endphp
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
});
const labels = {!! json_encode($labels) !!};
const normalQty = {!! json_encode($normalSum) !!};
const otQty = {!! json_encode($otSum) !!};
const data = {
    labels: labels,
    datasets: [
        {
            label: 'จำนวนปกติ',
            data: normalQty,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'จำนวน OT',
            data: otQty,
            backgroundColor: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }
    ]
};

const config = {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                mode: 'index',
                intersect: false
            },
            legend: {
                position: 'top'
            },
            // ✅ Plugin แสดงค่ารวมบนแท่ง
            datalabels: {
                display: false // ไม่แสดงค่าทั่วไป
            },
            sumLabel: {
                // Custom Plugin จะใส่ไว้ด้านล่าง
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'จำนวนส่งงาน'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'วันที่'
                }
            }
        }
    },
    plugins: [
        {
            id: 'sumLabel',
            afterDatasetsDraw(chart) {
                const {ctx, chartArea: {top}, data} = chart;

                chart.data.labels.forEach((_, i) => {
                    const sum = chart.data.datasets.reduce((acc, dataset) => {
                        return acc + (dataset.data[i] || 0);
                    }, 0);

                    const meta = chart.getDatasetMeta(0);
                    const xPos = meta.data[i].x;
                    const yPos = meta.data[i].y;

                    ctx.save();
                    ctx.fillStyle = 'black';
                    ctx.font = 'bold 12px sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(sum, xPos, yPos - 10); // แสดงผลรวมด้านบน
                    ctx.restore();
                });
            }
        }
    ]
};

const jobBarChart = new Chart(
    document.getElementById('jobBarChart'),
    config
);
</script>
@endpush