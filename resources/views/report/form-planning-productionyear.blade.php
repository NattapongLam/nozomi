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
            <canvas id="barChart" width="400" height="200"></canvas>
            <div style="overflow-x:auto;">
                <table id="tb_job" class="table table-bordered nowrap w-100 text-center">
                    <thead>
                        <tr>
                            <th>Year/Month</th>
                            <th>Model/Product</th>
                            <th>Delivery</th>
                            <th>Plan</th>
                            <th>Actual</th>
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
                            <td>{{number_format($item->ActualQty,2)}}</td>
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
document.addEventListener("DOMContentLoaded", function() {
        const labels = [];
        const deliveryData = {};
        const planData = {};
        const actualData = {};
        const finalData = {};

        // เก็บข้อมูลจากตาราง และทำการ SUM
        document.querySelectorAll("#tb_job tbody tr").forEach(function(row) {
            const columns = row.querySelectorAll("td");
            const yearMonth = columns[0].innerText; // Year/Month

            if (!deliveryData[yearMonth]) {
                deliveryData[yearMonth] = 0;
                planData[yearMonth] = 0;
                actualData[yearMonth] = 0;
                finalData[yearMonth] = 0;
            }

            deliveryData[yearMonth] += parseFloat(columns[2].innerText.replace(/,/g, '')); // Delivery
            planData[yearMonth] += parseFloat(columns[3].innerText.replace(/,/g, '')); // Plan
            actualData[yearMonth] += parseFloat(columns[4].innerText.replace(/,/g, '')); // Actual
            finalData[yearMonth] += parseFloat(columns[5].innerText.replace(/,/g, '')); // Final
        });

        // สร้าง arrays สำหรับแสดงข้อมูลใน Chart
        const labelKeys = Object.keys(deliveryData);
        const deliveryValues = Object.values(deliveryData);
        const planValues = Object.values(planData);
        const actualValues = Object.values(actualData);
        const finalValues = Object.values(finalData);

        const data = {
            labels: labelKeys,
            datasets: [
                {
                    label: 'Delivery',
                    data: deliveryValues,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Plan',
                    data: planValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Actual',
                    data: actualValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Final',
                    data: finalValues,
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // สร้าง Bar Chart
        const barChart = new Chart(
            document.getElementById('barChart'),
            config
        );
    });
</script>
@endpush