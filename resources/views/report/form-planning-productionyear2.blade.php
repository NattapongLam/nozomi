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
    {{-- <div class="col-12 col-md-3">
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
        </div> --}}
            <div class="col-12 col-md-3">
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>
        </div>
        </form>
        <div class="row"> 
            <canvas id="summaryBarChart" width="400" height="200"></canvas>
            <div style="overflow-x:auto;">
                <table id="tb_job" class="table table-bordered nowrap w-100 text-center">
                    <thead>
                        <tr>
                            <th>Year/Month</th>
                            <th>Model/Product</th>
                            <th>Delivery</th>
                            <th>Plan</th>
                            <th>Forcast</th>
                            <th>Final</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($hd as $item)
                           <tr>
                            <td>{{$item->pdt_productresult_hd_year}}/{{$item->pdt_productresult_hd_month}}</td>
                            <td>{{$item->mpd}}</td>
                            <td>{{number_format($item->DeliveryQty,2)}}</td>
                            <td>{{number_format($item->PlanQty,2)}}</td>
                            <td>{{number_format($item->ForcastQty,2)}}</td>
                            <td>{{number_format($item->FinalQty,2)}}</td>
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
    $sumDelivery = $hd->sum('DeliveryQty');
    $sumPlan     = $hd->sum('PlanQty');
    $sumForcast  = $hd->sum('ForcastQty');
    $sumFinal    = $hd->sum('FinalQty');
@endphp
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    "order": [[ 0, "desc" ]],        
    })
});
$(document).ready(function() {
    const labels = ['Delivery', 'Plan', 'Forcast', 'Final'];
    const data = [
        {{ $sumDelivery }},
        {{ $sumPlan }},
        {{ $sumForcast }},
        {{ $sumFinal }}
    ];
    const ctx = document.getElementById('summaryBarChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'ยอดรวมรวมทั้งหมด',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>
@endpush