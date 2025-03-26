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
         <form method="GET" class="form-horizontal">
            @csrf
    <div class="row">      
    <!-- ส่วนของการเลือกปี -->
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
    <!-- ส่วนของการเลือกเดือน -->
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
        </form>            
        </div>
    </form>
    <br>
        <h4 class="card-title">แผนจัดส่งประจำเดือน {{$hd1->pdt_plandelivery_hd_month}}/{{$hd1->pdt_plandelivery_hd_year}}</h4>   
        <div style="overflow-x:auto;">   
            <canvas id="myChart"></canvas>      
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Model/Product</th>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                         <th>
                             {{ date('D', strtotime($currentYear . '-' . $currentMonth . '-' . $day)) }} {{ sprintf('%02d', $day) }}
                         </th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                   @foreach ($hd2 as $item)
                       <tr>
                        <td>{{$item->model}}/{{$item->product}}</td>
                        <td> {{number_format($item->plan01,0)}}</td>
                        <td> {{number_format($item->plan02,0)}}</td>
                        <td> {{number_format($item->plan03,0)}}</td>
                        <td> {{number_format($item->plan04,0)}}</td>
                        <td> {{number_format($item->plan05,0)}}</td>
                        <td> {{number_format($item->plan06,0)}}</td>
                        <td> {{number_format($item->plan07,0)}}</td>
                        <td> {{number_format($item->plan08,0)}}</td>
                        <td> {{number_format($item->plan09,0)}}</td>
                        <td> {{number_format($item->plan10,0)}}</td>
                        <td> {{number_format($item->plan11,0)}}</td>
                        <td> {{number_format($item->plan12,0)}}</td>
                        <td> {{number_format($item->plan13,0)}}</td>
                        <td> {{number_format($item->plan14,0)}}</td>
                        <td> {{number_format($item->plan15,0)}}</td>
                        <td> {{number_format($item->plan16,0)}}</td>
                        <td> {{number_format($item->plan17,0)}}</td>
                        <td> {{number_format($item->plan18,0)}}</td>
                        <td> {{number_format($item->plan19,0)}}</td>
                        <td> {{number_format($item->plan20,0)}}</td>
                        <td> {{number_format($item->plan21,0)}}</td>
                        <td> {{number_format($item->plan22,0)}}</td>
                        <td> {{number_format($item->plan23,0)}}</td>
                        <td> {{number_format($item->plan24,0)}}</td>
                        <td> {{number_format($item->plan25,0)}}</td>
                        <td> {{number_format($item->plan26,0)}}</td>
                        <td> {{number_format($item->plan27,0)}}</td>
                        <td> {{number_format($item->plan28,0)}}</td>
                        <td> {{number_format($item->plan29,0)}}</td>
                        <td> {{number_format($item->plan30,0)}}</td>
                        <td> {{number_format($item->plan31,0)}}</td>
                       </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
        <h5>กำลังการผลิตประจำเดือน {{$hd1->pdt_plandelivery_hd_month}}/{{$hd1->pdt_plandelivery_hd_year}}</h5>
        <div style="overflow-x:auto;">      
        <canvas id="pieChart"></canvas>
        <table class="table table-bordered">
           <thead>
            <tr>
                <th>Line</th>
                <th>Max</th>
                @for ($day = 1; $day <= $daysInMonth; $day++)
                <th>
                    {{ date('D', strtotime($currentYear . '-' . $currentMonth . '-' . $day)) }} {{ sprintf('%02d', $day) }}
                </th>
                @endfor
            </tr>
           </thead>
           <tbody>
            @foreach ($hd3 as $item)
                <tr>
                    <td>{{$item->pdt_process_hd_code}}</td>
                    <td>{{number_format($item->pdt_process_hd_qty,0)}}</td>
                    @if ($item->qty01 > $item->pdt_process_hd_qty)
                        <td style="background-color: #FAE0D8">
                            {{number_format($item->qty01,0)}}
                        </td>
                    @elseif($item->qty01 <= $item->pdt_process_hd_qty)
                        <td style="background-color: #D0F4DE">
                            {{number_format($item->qty01,0)}}
                        </td>
                    @endif          
                    @if ($item->qty02 > $item->pdt_process_hd_qty)
                        <td style="background-color: #FAE0D8">
                            {{number_format($item->qty02,0)}}
                        </td>
                    @elseif($item->qty02 <= $item->pdt_process_hd_qty)
                        <td style="background-color: #D0F4DE">
                            {{number_format($item->qty02,0)}}
                        </td>
                    @endif          
                    @if ($item->qty03 > $item->pdt_process_hd_qty)
                        <td style="background-color: #FAE0D8">
                            {{number_format($item->qty03,0)}}
                        </td>
                    @elseif($item->qty03 <= $item->pdt_process_hd_qty)
                        <td style="background-color: #D0F4DE">
                            {{number_format($item->qty03,0)}}
                        </td>
                    @endif     
                    @if ($item->qty04 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty04,0)}}
                    </td>
                    @elseif($item->qty04 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty04,0)}}
                    </td>
                    @endif         
                    @if ($item->qty05 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty05,0)}}
                    </td>
                    @elseif($item->qty05 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty05,0)}}
                    </td>
                    @endif    
                    @if ($item->qty06 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty06,0)}}
                    </td>
                    @elseif($item->qty06 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty06,0)}}
                    </td>
                    @endif    
                    @if ($item->qty07 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty07,0)}}
                    </td>
                    @elseif($item->qty07 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty07,0)}}
                    </td>
                    @endif   
                    @if ($item->qty08 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty08,0)}}
                    </td>
                    @elseif($item->qty08 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty08,0)}}
                    </td>
                    @endif   
                    @if ($item->qty09 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty09,0)}}
                    </td>
                    @elseif($item->qty09 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty09,0)}}
                    </td>
                    @endif  
                    @if ($item->qty10 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty10,0)}}
                    </td>
                    @elseif($item->qty10 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty10,0)}}
                    </td>
                    @endif  
                    @if ($item->qty11 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty11,0)}}
                    </td>
                    @elseif($item->qty11 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty11,0)}}
                    </td>
                    @endif  
                    @if ($item->qty12 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty12,0)}}
                    </td>
                    @elseif($item->qty12 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty12,0)}}
                    </td>
                    @endif  
                    @if ($item->qty13 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty13,0)}}
                    </td>
                    @elseif($item->qty13 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty13,0)}}
                    </td>
                    @endif
                    @if ($item->qty14 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty14,0)}}
                    </td>
                    @elseif($item->qty14 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty14,0)}}
                    </td>
                    @endif
                    @if ($item->qty15 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty15,0)}}
                    </td>
                    @elseif($item->qty15 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty15,0)}}
                    </td>
                    @endif
                    @if ($item->qty16 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty16,0)}}
                    </td>
                    @elseif($item->qty16 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty16,0)}}
                    </td>
                    @endif
                    @if ($item->qty17 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty17,0)}}
                    </td>
                    @elseif($item->qty17 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty17,0)}}
                    </td>
                    @endif
                    @if ($item->qty18 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty18,0)}}
                    </td>
                    @elseif($item->qty18 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty18,0)}}
                    </td>
                    @endif
                    @if ($item->qty19 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty19,0)}}
                    </td>
                    @elseif($item->qty19 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty19,0)}}
                    </td>
                    @endif
                    @if ($item->qty20 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty20,0)}}
                    </td>
                    @elseif($item->qty20 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty20,0)}}
                    </td>
                    @endif
                    @if ($item->qty21 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty21,0)}}
                    </td>
                    @elseif($item->qty21 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty21,0)}}
                    </td>
                    @endif
                    @if ($item->qty22 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty22,0)}}
                    </td>
                    @elseif($item->qty22 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty22,0)}}
                    </td>
                    @endif
                    @if ($item->qty23 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty23,0)}}
                    </td>
                    @elseif($item->qty23 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty23,0)}}
                    </td>
                    @endif
                    @if ($item->qty24 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty24,0)}}
                    </td>
                    @elseif($item->qty24 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty24,0)}}
                    </td>
                    @endif
                    @if ($item->qty25 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty25,0)}}
                    </td>
                    @elseif($item->qty25 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty25,0)}}
                    </td>
                    @endif
                    @if ($item->qty26 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty26,0)}}
                    </td>
                    @elseif($item->qty26 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty26,0)}}
                    </td>
                    @endif
                    @if ($item->qty27 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty27,0)}}
                    </td>
                    @elseif($item->qty27 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty27,0)}}
                    </td>
                    @endif
                    @if ($item->qty28 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty28,0)}}
                    </td>
                    @elseif($item->qty28 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty28,0)}}
                    </td>
                    @endif
                    @if ($item->qty29 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty29,0)}}
                    </td>
                    @elseif($item->qty29 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty29,0)}}
                    </td>
                    @endif
                    @if ($item->qty30 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty30,0)}}
                    </td>
                    @elseif($item->qty30 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty30,0)}}
                    </td>
                    @endif
                    @if ($item->qty31 > $item->pdt_process_hd_qty)
                    <td style="background-color: #FAE0D8">
                        {{number_format($item->qty31,0)}}
                    </td>
                    @elseif($item->qty31 <= $item->pdt_process_hd_qty)
                    <td style="background-color: #D0F4DE">
                        {{number_format($item->qty31,0)}}
                    </td>
                    @endif
                </tr>
            @endforeach
           </tbody>
        </table>
        </div>
        <h5>แผนการผลิตประจำเดือน {{$hd1->pdt_plandelivery_hd_month}}/{{$hd1->pdt_plandelivery_hd_year}}</h5>
        @php
            // สมมติว่า $hd4 เป็น Collection ของข้อมูลที่มีฟิลด์: pdt_process_hd_code, product, qty01, qty02, ... qty31
            // กลุ่มข้อมูลตาม pdt_process_hd_code และ product
            $grouped = $hd4->groupBy(function($item) {
                return $item->pdt_process_hd_code . ' / ' . $item->product;
            });

            $labels = [];
            $data = [];
            
            // วนลูปแต่ละกลุ่มและคำนวณผลรวมของ qty ตั้งแต่ qty01 ถึง qty31
            foreach ($grouped as $groupLabel => $items) {
                $total = 0;
                foreach ($items as $item) {
                    for ($day = 1; $day <= 31; $day++) {
                        $dayKey = 'qty' . sprintf('%02d', $day); // เช่น qty01, qty02,...
                        if (isset($item->$dayKey)) {
                            $total += (float) $item->$dayKey;
                        }
                    }
                }

                // กรองค่า 0 ออก
                if ($total > 0) {
                    $labels[] = $groupLabel;
                    $data[] = $total;
                }
            }

            // กำหนดสีพื้นหลังและขอบแบบสุ่ม
            $backgroundColors = array_map(function() {
                return sprintf('rgba(%d, %d, %d, 0.7)', rand(0,255), rand(0,255), rand(0,255));
            }, range(1, count($labels)));

            $borderColors = array_map(function() {
                return sprintf('rgba(%d, %d, %d, 1)', rand(0,255), rand(0,255), rand(0,255));
            }, range(1, count($labels)));

            // สร้างชุดข้อมูลสำหรับ Chart.js โดยใช้ dataset เดียว
            $chartDatas = json_encode([
                'labels' => array_values($labels), // จัดเรียง index ใหม่
                'datasets' => [
                    [
                        'label' => 'Total Quantity (Day 1-31)',
                        'data' => array_values($data), // จัดเรียง index ใหม่
                        'backgroundColor' => $backgroundColors,
                        'borderColor' => $borderColors,
                        'borderWidth' => 1,
                    ]
                ]
            ]);
        @endphp
        <div style="overflow-x:auto;">      
            <div style="width: 100%; max-width: 1600px; height: 500px; margin: auto;">
                <canvas id="myCharts"></canvas>
            </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Model/Product</th>
                    <th>Line</th>
                    @for ($day = 1; $day <= $daysInMonth; $day++)
                        <th>
                            {{ date('D', strtotime($currentYear . '-' . $currentMonth . '-' . $day)) }} {{ sprintf('%02d', $day) }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($hd4 as $item)
                    @php
                        // กำหนดสีของแถวตามเงื่อนไข
                        $rowColor = '';
                        if ($item->pdt_process_hd_code == "L1") {
                            $rowColor = 'background-color: lightblue;'; // เปลี่ยนสีตามที่ต้องการ
                        } elseif ($item->pdt_process_hd_code == "L2") {
                            $rowColor = 'background-color: lightgreen;'; // เปลี่ยนสีตามที่ต้องการ
                        } elseif ($item->pdt_process_hd_code == "L3") {
                            $rowColor = 'background-color: lightcoral;'; // เปลี่ยนสีตามที่ต้องการ
                        }
                    @endphp
                    <tr style="{{ $rowColor }}">
                        <td>{{$item->model}}/{{$item->product}}</td>
                        <td>{{$item->pdt_process_hd_code}}</td>
                        <td>{{number_format($item->qty01,0)}}</td>
                        <td>{{number_format($item->qty02,0)}}</td>
                        <td>{{number_format($item->qty03,0)}}</td>
                        <td>{{number_format($item->qty04,0)}}</td>
                        <td>{{number_format($item->qty05,0)}}</td>
                        <td>{{number_format($item->qty06,0)}}</td>
                        <td>{{number_format($item->qty07,0)}}</td>
                        <td>{{number_format($item->qty08,0)}}</td>
                        <td>{{number_format($item->qty09,0)}}</td>
                        <td>{{number_format($item->qty10,0)}}</td>
                        <td>{{number_format($item->qty11,0)}}</td>
                        <td>{{number_format($item->qty12,0)}}</td>
                        <td>{{number_format($item->qty13,0)}}</td>
                        <td>{{number_format($item->qty14,0)}}</td>
                        <td>{{number_format($item->qty15,0)}}</td>
                        <td>{{number_format($item->qty16,0)}}</td>
                        <td>{{number_format($item->qty17,0)}}</td>
                        <td>{{number_format($item->qty18,0)}}</td>
                        <td>{{number_format($item->qty19,0)}}</td>
                        <td>{{number_format($item->qty20,0)}}</td>
                        <td>{{number_format($item->qty21,0)}}</td>
                        <td>{{number_format($item->qty22,0)}}</td>
                        <td>{{number_format($item->qty23,0)}}</td>
                        <td>{{number_format($item->qty24,0)}}</td>
                        <td>{{number_format($item->qty25,0)}}</td>
                        <td>{{number_format($item->qty26,0)}}</td>
                        <td>{{number_format($item->qty27,0)}}</td>
                        <td>{{number_format($item->qty28,0)}}</td>
                        <td>{{number_format($item->qty29,0)}}</td>
                        <td>{{number_format($item->qty30,0)}}</td>
                        <td>{{number_format($item->qty31,0)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
 document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("myChart").getContext("2d");

        var chartData = {!! $chartData !!}; // ดึงข้อมูลจาก Laravel

        // กำหนด backgroundColor ให้ dataset แต่ละชุด
        chartData.datasets.forEach((dataset, index) => {
            dataset.backgroundColor = dataset.borderColor; // ใช้สีเดียวกับเส้น borderColor
        });

        var myChart = new Chart(ctx, {
            type: 'bar', // เปลี่ยนจาก 'line' เป็น 'bar'
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("pieChart").getContext("2d");

        var chartData = {
            labels: {!! json_encode($hd3->pluck('pdt_process_hd_code')) !!}, // ชื่อ Line
            datasets: [{
                data: {!! json_encode($hd3->pluck('pdt_process_hd_qty')) !!}, // ค่า Max
                backgroundColor: [
                    "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", 
                    "#FF9F40", "#C9CBCF", "#E7E9ED", "#74C476", "#A1D99B"
                ]
            }]
        };

        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("myCharts").getContext("2d");
    var chartDatas = {!! $chartDatas !!}; // ข้อมูล JSON ที่เตรียมไว้

    var myCharts = new Chart(ctx, {
        type: 'bar', // Bar Chart
        data: chartDatas,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value;
                    },
                    font: {
                        weight: 'bold'
                    },
                    color: '#000' // สีของตัวเลข
                }
            }
        },
        plugins: [ChartDataLabels] // ลงทะเบียน plugin
    });
});
</script>
@endpush