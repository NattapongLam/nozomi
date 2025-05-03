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
    @if ($hd1)
    <h4 class="card-title">แผนจัดส่งประจำเดือน {{$hd1->pdt_plandelivery_hd_month}}/{{$hd1->pdt_plandelivery_hd_year}}</h4>   
    <div style="overflow-x:auto;">      
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
                    <td> {{$item->product}}</td>
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
    <table class="table table-bordered">
       <thead>
        <tr>
            <th>Process</th>
            <th>Man Power</th>
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
                <td>{{$item->pdt2_planprocess_process}} ({{$item->pdt2_planprocess_leader}})</td>
                <td>{{number_format($item->pdt2_planprocess_empqty,0)}}</td>
                <td>{{number_format($item->pdt2_planprocess_max,0)}}</td>
                @if ($item->pdt2_planprocess_qty01 > 0)
                    <td style="background-color: #FAE0D8">
                        OT : {{number_format($item->pdt2_planprocess_qty01,2)}}
                    </td>
                @else
                    <td style="background-color: #D0F4DE">
                        OT : {{number_format($item->pdt2_planprocess_qty01,2)}}
                    </td>
                @endif          
                @if ($item->pdt2_planprocess_qty02 > 0)
                    <td style="background-color: #FAE0D8">
                        OT : {{number_format($item->pdt2_planprocess_qty02,2)}}
                    </td>
                @else
                    <td style="background-color: #D0F4DE">
                        OT : {{number_format($item->pdt2_planprocess_qty02,2)}}
                    </td>
                @endif          
                @if ($item->pdt2_planprocess_qty03 > 0)
                    <td style="background-color: #FAE0D8">
                        OT : {{number_format($item->pdt2_planprocess_qty03,2)}}
                    </td>
                @else
                    <td style="background-color: #D0F4DE">
                        OT : {{number_format($item->pdt2_planprocess_qty03,2)}}
                    </td>
                @endif     
                @if ($item->pdt2_planprocess_qty04 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty04,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty04,2)}}
                </td>
                @endif         
                @if ($item->pdt2_planprocess_qty05 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty05,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty05,2)}}
                </td>
                @endif    
                @if ($item->pdt2_planprocess_qty06 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty06,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty06,2)}}
                </td>
                @endif    
                @if ($item->pdt2_planprocess_qty07 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty07,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty07,2)}}
                </td>
                @endif   
                @if ($item->pdt2_planprocess_qty08 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty08 ,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty08,2)}}
                </td>
                @endif   
                @if ($item->pdt2_planprocess_qty09 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty09,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty09,0)}}
                </td>
                @endif  
                @if ($item->pdt2_planprocess_qty10 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty10,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty10,2)}}
                </td>
                @endif  
                @if ($item->pdt2_planprocess_qty11 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty11,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty11,2)}}
                </td>
                @endif  
                @if ($item->pdt2_planprocess_qty12 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty12,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty12,2)}}
                </td>
                @endif  
                @if ($item->pdt2_planprocess_qty13 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty13,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty13,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty14 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty14,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty14,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty15 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty15,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty15,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty16 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty16,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty16,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty17 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty17,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty17,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty18 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty18,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty18,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty19 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty19,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty19,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty20 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty20,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty20,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty21 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty21,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty21,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty22 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty22,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty22,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty23 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty23,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty23,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty24 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty24,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty24,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty25 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty25,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty25,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty26 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty26,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty26,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty27 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty27,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty27,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty28 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty28,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty28,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty29 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty29,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty29,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty30 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty30,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty30,2)}}
                </td>
                @endif
                @if ($item->pdt2_planprocess_qty31 > 0)
                <td style="background-color: #FAE0D8">
                    OT : {{number_format($item->pdt2_planprocess_qty31,2)}}
                </td>
                @else
                <td style="background-color: #D0F4DE">
                    OT : {{number_format($item->pdt2_planprocess_qty31,2)}}
                </td>
                @endif
            </tr>
        @endforeach
       </tbody>
    </table>
    </div>
    <h5>แผนการผลิตประจำเดือน {{$hd1->pdt_plandelivery_hd_month}}/{{$hd1->pdt_plandelivery_hd_year}}</h5>
    <div style="overflow-x:auto;">  
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
                    <tr>
                        <td>{{$item->pdt2_planproduction_model}}/{{$item->pdt2_planproduction_partname}}</td>
                        <td>
                            {{$item->pdt2_planproduction_process}}<br>
                            ({{$item->pdt2_planproduction_type}})
                        </td>
                        <td>{{number_format($item->pdt2_planproduction_qty01,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty02,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty03,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty04,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty05,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty06,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty07,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty08,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty09,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty10,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty11,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty12,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty13,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty14,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty15,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty16,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty17,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty18,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty19,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty20,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty21,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty22,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty23,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty24,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty25,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty26,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty27,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty28,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty29,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty30,0)}}</td>
                        <td>{{number_format($item->pdt2_planproduction_qty31,0)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
    @endif       
    </div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
</script>
@endpush