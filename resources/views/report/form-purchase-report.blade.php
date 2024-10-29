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
                <h3 class="card-title">ภาพรวมการสั่งซื้อ</h3>
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
            <canvas id="myDonutChart" width="400" height="400"></canvas>
            <table id="tb_job1" class="table table-bordered">
                <thead>
                    <tr>
                        <th>แผนก</th>
                        <th>ยอดเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $groupedHd = $hd->groupBy('emp_department_name');
                    @endphp
            
                    @foreach ($groupedHd as $departmentName => $items)
                        @php
                            $departmentTotal = $items->sum('pur_purchaseorder_dt_netamount');
                            $totalAmount += $departmentTotal;
                        @endphp
                        <tr>
                            <td>{{ $departmentName }}</td>
                            <td>{{ number_format($departmentTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ยอดรวมทั้งหมด</th>
                        <th>{{ number_format($totalAmount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <h3 class="card-title text-center">แยกตามประเภทสินค้า</h3>
        <div class="row">            
            <canvas id="myColumnChart"></canvas>
            <table id="tb_job2" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ประเภท</th>
                        @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                            <th>{{ $monthYear }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $groupedType = $hd->groupBy('pd_producttype_name');
                    @endphp
            
                    @foreach ($groupedType as $productTypeName => $items)
                        <tr>
                            <td>{{ $productTypeName }}</td>
                            @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                @php
                                    $monthTotal = $items->whereIn('pur_purchaseorder_hd_date', collect($monthItems)->pluck('pur_purchaseorder_hd_date'))
                                                         ->sum('pur_purchaseorder_dt_netamount');
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
                                $monthTotal = collect($monthItems)->sum('pur_purchaseorder_dt_netamount');
                            @endphp
                            <th>{{ number_format($monthTotal, 2) }}</th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr>
        <h3 class="card-title text-center">แยกตามจัดสรร</h3>
        <div class="row">
            <table id="tb_job3" class="table table-bordered">
                <thead>
                    <tr>
                        <th>จัดสรร</th>
                        @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                            <th>{{ $monthYear }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $groupedAllocate = $hd->groupBy('ms_allocate_name');
                    @endphp
            
                    @foreach ($groupedAllocate as $AllocateName => $items)
                        <tr>
                            <td>{{ $AllocateName }}</td>
                            @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                @php
                                    $monthTotal = $items->whereIn('pur_purchaseorder_hd_date', collect($monthItems)->pluck('pur_purchaseorder_hd_date'))
                                                         ->sum('pur_purchaseorder_dt_netamount');
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
                                $monthTotal = collect($monthItems)->sum('pur_purchaseorder_dt_netamount');
                            @endphp
                            <th>{{ number_format($monthTotal, 2) }}</th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr>
        <h3 class="card-title text-center">แยกตามผู้จำหน่าย</h3>
        <div class="row">
            <table id="tb_job4" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ผู้จำหน่าย</th>
                        @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                            <th>{{ $monthYear }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $groupedVendor = $hd->groupBy('vd_vendor_fullname');
                    @endphp
            
                    @foreach ($groupedVendor as $VendorName => $items)
                        <tr>
                            <td>{{ $VendorName }}</td>
                            @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                @php
                                    $monthTotal = $items->whereIn('pur_purchaseorder_hd_date', collect($monthItems)->pluck('pur_purchaseorder_hd_date'))
                                                         ->sum('pur_purchaseorder_dt_netamount');
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
                                $monthTotal = collect($monthItems)->sum('pur_purchaseorder_dt_netamount');
                            @endphp
                            <th>{{ number_format($monthTotal, 2) }}</th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr>
        <h3 class="card-title text-center">แยกตามสินค้า</h3>
        <div class="row">
            <table id="tb_job5" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ผู้จำหน่าย</th>
                        @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                            <th>{{ $monthYear }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                        $groupedProduct = $hd->groupBy('productname');
                    @endphp
            
                    @foreach ($groupedProduct as $ProductName => $items)
                        <tr>
                            <td>{{ $ProductName }}</td>
                            @foreach ($groupedByMonthYear as $monthYear => $monthItems)
                                @php
                                    $monthTotal = $items->whereIn('pur_purchaseorder_hd_date', collect($monthItems)->pluck('pur_purchaseorder_hd_date'))
                                                         ->sum('pur_purchaseorder_dt_netamount');
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
                                $monthTotal = collect($monthItems)->sum('pur_purchaseorder_dt_netamount');
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
@php
    $departmentNames = $groupedHd->keys()->toArray();
    $departmentTotals = $groupedHd->map->sum('pur_purchaseorder_dt_netamount')->values()->toArray();
@endphp
@php
    $groupedType = collect($hd->groupBy('pd_producttype_name'));
    $groupedByMonthYear = collect($hd->groupBy(function($item) {
        return \Carbon\Carbon::parse($item->pur_purchaseorder_hd_date)->format('Y-m');
    }));
@endphp
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
  const departmentNames = @json($departmentNames); // ชื่อแผนก
  const departmentTotals = @json($departmentTotals); // ยอดรวมต่อแผนก
  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('myDonutChart').getContext('2d');
    const myDonutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: departmentNames,
            datasets: [{
                label: 'ยอดเงินต่อแผนก',
                data: departmentTotals,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        const total = ctx.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0);
                        const percentage = ((value / total) * 100).toFixed(2) + '%';
                        return percentage;
                    },
                    color: '#000000',
                }
            }
        },
        plugins: [ChartDataLabels] // เพิ่ม plugin ที่นี่
    });
});
document.addEventListener('DOMContentLoaded', function() {
        // ข้อมูลประเภทและยอดตามเดือน-ปี จาก Laravel
        const productTypeNames = @json($groupedType->keys());
        const monthlyTotals = @json($groupedType->map(function($items) use ($groupedByMonthYear) {
            return $groupedByMonthYear->map(function($monthItems) use ($items) {
                return $items->whereIn('pur_purchaseorder_hd_date', collect($monthItems)->pluck('pur_purchaseorder_hd_date'))
                             ->sum('pur_purchaseorder_dt_netamount');
            })->values();
        })->values());

        const monthLabels = @json(array_keys($groupedByMonthYear->toArray())); 

        // ตั้งค่าการแสดงผลของ Chart
        const ctx = document.getElementById('myColumnChart').getContext('2d');
        const myColumnChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productTypeNames,
                datasets: monthLabels.map((month, index) => ({
                    label: month,
                    data: monthlyTotals.map(total => total[index]),
                    backgroundColor: `rgba(${75 + index * 30}, ${192 - index * 30}, ${192 + index * 10}, 0.2)`,
                    borderColor: `rgba(${75 + index * 30}, ${192 - index * 30}, ${192 + index * 10}, 1)`,
                    borderWidth: 1
                }))
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'ยอดเงิน'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'ประเภทผลิตภัณฑ์'
                        }
                    }
                }
            }
        });
    });
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
</script>
@endpush