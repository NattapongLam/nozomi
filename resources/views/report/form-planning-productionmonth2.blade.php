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
            <div style="overflow-x:auto;">   
                <table class="table table-bordered">              
                    <thead>
                        <tr>
                            <th>Line</th>
                            <th>Listno</th>
                            <th>Process</th>
                            <th>Model/Product</th>
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                <th>
                                    {{ date('D', strtotime($currentYear . '-' . $currentMonth . '-' . $day)) }} {{ sprintf('%02d', $day) }}
                                </th>
                            @endfor
                        </tr>
                    </thead>     
                    <tbody>
                        @foreach ($hd1 as $item)
                            <tr>
                                <td>{{$item->pdt_productresult_hd_line}}</td>
                                <td>{{$item->pdt_process_dt_listno}}</td>
                                <td>{{$item->pdt_process_dt_name}}</td>
                                <td>{{$item->model}}/{{$item->product}}</td>
                                <td> {{number_format($item->qty01,0)}}</td>
                                <td> {{number_format($item->qty02,0)}}</td>
                                <td> {{number_format($item->qty03,0)}}</td>
                                <td> {{number_format($item->qty04,0)}}</td>
                                <td> {{number_format($item->qty05,0)}}</td>
                                <td> {{number_format($item->qty06,0)}}</td>
                                <td> {{number_format($item->qty07,0)}}</td>
                                <td> {{number_format($item->qty08,0)}}</td>
                                <td> {{number_format($item->qty09,0)}}</td>
                                <td> {{number_format($item->qty10,0)}}</td>
                                <td> {{number_format($item->qty11,0)}}</td>
                                <td> {{number_format($item->qty12,0)}}</td>
                                <td> {{number_format($item->qty13,0)}}</td>
                                <td> {{number_format($item->qty14,0)}}</td>
                                <td> {{number_format($item->qty15,0)}}</td>
                                <td> {{number_format($item->qty16,0)}}</td>
                                <td> {{number_format($item->qty17,0)}}</td>
                                <td> {{number_format($item->qty18,0)}}</td>
                                <td> {{number_format($item->qty19,0)}}</td>
                                <td> {{number_format($item->qty20,0)}}</td>
                                <td> {{number_format($item->qty21,0)}}</td>
                                <td> {{number_format($item->qty22,0)}}</td>
                                <td> {{number_format($item->qty23,0)}}</td>
                                <td> {{number_format($item->qty24,0)}}</td>
                                <td> {{number_format($item->qty25,0)}}</td>
                                <td> {{number_format($item->qty26,0)}}</td>
                                <td> {{number_format($item->qty27,0)}}</td>
                                <td> {{number_format($item->qty28,0)}}</td>
                                <td> {{number_format($item->qty29,0)}}</td>
                                <td> {{number_format($item->qty30,0)}}</td>
                                <td> {{number_format($item->qty31,0)}}</td>
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
</script>
@endpush