<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ReportPlanningPd(Request $request)
    {
        $datestart = $request->datestart ? date("Y-m-d", strtotime($request->datestart . ' -1 day')) : date("Y-m-d", strtotime('-1 day'));
        $hd = DB::table('vw_productresult_daily_time')
        ->where('vw_productresult_daily_time.date',$request->datestart)
        ->whereIn('pdt_productresult_hd_line',['L1','L2','L3','L4'])
        ->get();
        $hdsum = DB::table('vw_productresult_daily_sum')
        ->where('date',$request->datestart)
        ->whereIn('pdt_productresult_hd_line',['L1','L2','L3','L4'])
        ->get();
        return view('report.form-planning-production', compact('hd','datestart','hdsum'));
    }
    public function ReportPlanningPdMonth(Request $request)
    {
        if($request->years){
            $year = $request->years;    
        }else{
            $year = Carbon::now()->year;    
        }
        if($request->months){
            $month = $request->months;      
        }else{
            $month = Carbon::now()->month;      
        } 
        $hd1 = DB::table('vw_reportproduct_process')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','L1')
        ->get();
        $groupedByL1 = $hd1->groupBy('jobtype')->toArray();
        $hd2 = DB::table('vw_reportproduct_process')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','L2')
        ->get();
        $groupedByL2 = $hd2->groupBy('jobtype')->toArray();
        $hd3 = DB::table('vw_reportproduct_process')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','L3')
        ->get();
        $groupedByL3 = $hd3->groupBy('jobtype')->toArray();
        $hd4 = DB::table('vw_reportproduct_process')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','L4')
        ->get();
        $groupedByL4 = $hd3->groupBy('jobtype')->toArray();
        return view('report.form-planning-productionmonth', compact('year','month','hd1','groupedByL1','hd2','groupedByL2','hd3','groupedByL3','hd4','groupedByL4'));
    }
    public function ReportPlanningPdYear(Request $request)
    {
        if($request->years){
            $year = $request->years;    
        }else{
            $year = Carbon::now()->year;    
        }
        // if($request->months){
        //     $month = $request->months;      
        // }else{
        //     $month = Carbon::now()->month;      
        // } 
        $hd = DB::table('vw_reportproduct_process_yearv1')
                // ->where('pdt_productresult_hd_month',$month)
                ->where('pdt_productresult_hd_year',$year)
                ->get();
        return view('report.form-planning-productionyear', compact('year','hd'));
    }
    public function ReportPlanningDl(Request $request)
    {
        if($request->years){
            $year = $request->years;    
        }else{
            $year = Carbon::now()->year;    
        }
        if($request->months){
            $month = $request->months;      
        }else{
            $month = Carbon::now()->month;      
        } 
        if($year){
            if($month){
                $hd1 = DB::table('pdt_plandelivery_hd')
                ->where('pdt_plandelivery_hd_year',$year)
                ->where('pdt_plandelivery_hd_month',$month)
                ->where('pdt_plandelivery_hd_type','PDT1')
                ->first();
                if ($hd1) {
                    $hd2 = DB::table('pdt_plandelivery_dt')
                    ->where('pdt_plandelivery_hd_id', $hd1->pdt_plandelivery_hd_id)
                    ->get();
                    $hd3 = DB::table('pdt_planproduction_capacity')
                    ->where('pdt_planproduction_capacity_year',$hd1->pdt_plandelivery_hd_year)
                    ->where('pdt_planproduction_capacity_month',$hd1->pdt_plandelivery_hd_month)
                    ->get();
                    $hd4 = DB::table('pdt_planproduction')
                    ->where('pdt_planproduction_year',$hd1->pdt_plandelivery_hd_year)
                    ->where('pdt_planproduction_month',$hd1->pdt_plandelivery_hd_month)
                    ->whereIn('pdt_process_hd_code',['L1','L2','L3','L4'])
                    ->get();
                } else {
                    $hd2 = collect();
                    $hd3 = collect();
                    $hd4 = collect();
                }              
            }
            $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
            $data = [];
            $labels = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $labels[] = sprintf('%02d', $day); // เก็บวันที่ 01, 02, 03, ...
            }
            foreach ($hd2 as $item) {
                $data[] = [
                    'label' => "{$item->model}/{$item->product}",
                    'data' => [
                        $item->plan01, $item->plan02, $item->plan03, $item->plan04, 
                        $item->plan05, $item->plan06, $item->plan07, $item->plan08, 
                        $item->plan09, $item->plan10, $item->plan11, $item->plan12, 
                        $item->plan13, $item->plan14, $item->plan15, $item->plan16, 
                        $item->plan17, $item->plan18, $item->plan19, $item->plan20, 
                        $item->plan21, $item->plan22, $item->plan23, $item->plan24, 
                        $item->plan25, $item->plan26, $item->plan27, $item->plan28, 
                        $item->plan29, $item->plan30, $item->plan31
                    ],
                    'borderColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)), // สีสุ่ม
                    'fill' => false
                ];
            }
            $chartData = json_encode([
                'labels' => $labels,
                'datasets' => $data
            ]);
        }                    
        return view('report.form-planning-delivery', compact('hd1','hd2','hd3','hd4','chartData'));
    }
    public function ReportPlanningPdDay(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd1 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','L1')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL1 = $hd1->groupBy('pdt_process_dt_name')->toArray();
        $hd2 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','L2')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL2 = $hd2->groupBy('pdt_process_dt_name')->toArray();
        $hd3 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','L3')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL3 = $hd3->groupBy('pdt_process_dt_name')->toArray();
        $hd4 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','L4')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL4 = $hd4->groupBy('pdt_process_dt_name')->toArray();
        return view('report.form-planning-productionday', compact('dateend','datestart','hd1','groupedByL1','hd2','groupedByL2','hd3','groupedByL3','hd4','groupedByL4'));
    }
    public function ReportDeliveryDay(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-5 day", strtotime($dateend)));
        $hd = DB::table('vw_fgissuestock_report')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByDay = $hd->groupBy('date')->toArray();
        return view('report.form-delivery-day', compact('dateend','datestart','hd','groupedByDay'));

    }
    public function ReportReceiveDay(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd = DB::table('vw_fgreceive_report')
        ->whereBetween('fg_receiveproduct_hd_date', [$datestart, $dateend])
        ->get();
        $groupedByDay = $hd->groupBy('fg_receiveproduct_hd_date')->toArray();
        $hd1 = DB::table('vw_pureceive_report')
        ->whereBetween('wh_receivepu_hd_date', [$datestart, $dateend])
        ->get();
        $groupedByDay1 = $hd1->groupBy('wh_receivepu_hd_date')->toArray();
        $hd2 = DB::table('vw_whreceive_report')
        ->whereBetween('wh_receiveproduct_hd_date', [$datestart, $dateend])
        ->get();
        $groupedByDay2 = $hd2->groupBy('wh_receiveproduct_hd_date')->toArray();
        return view('report.form-receive-report', compact('dateend','datestart','hd','groupedByDay','hd1','groupedByDay1','hd2','groupedByDay2'));

    }
    public function ReportPlanningDl2(Request $request)
    {
        if($request->years){
            $year = $request->years;    
        }else{
            $year = Carbon::now()->year;    
        }
        if($request->months){
            $month = $request->months;      
        }else{
            $month = Carbon::now()->month;      
        } 
        if($year){
            if($month){
                $hd1 = DB::table('pdt_plandelivery_hd')
                ->where('pdt_plandelivery_hd_year',$year)
                ->where('pdt_plandelivery_hd_month',$month)
                ->where('pdt_plandelivery_hd_type','PDT2')
                ->first();
                if ($hd1) {
                    $hd2 = DB::table('pdt_plandelivery_dt')
                    ->where('pdt_plandelivery_hd_id', $hd1->pdt_plandelivery_hd_id)
                    ->get();
                    $hd3 = DB::table('pdt2_planprocess')
                    ->where('pdt2_planprocess_year',$year)
                    ->where('pdt2_planprocess_month',$month)
                    ->get();
                    $hd4 = DB::table('pdt2_planproduction')
                    ->where('pdt2_planproduction_year',$year)
                    ->where('pdt2_planproduction_month',$month)
                    ->where('pdt2_planproduction_line','LINE')
                    ->orderBy('pdt2_planproduction_model','asc')
                    ->get();
                } else {
                    $hd2 = collect();      
                    $hd3 = collect();
                    $hd4 = collect();             
                }              
            }
        }                    
        return view('report.form-planning-delivery2', compact('hd1','hd2','hd3','hd4'));
    }
    public function ReportPlanningPd2(Request $request)
    {
        $datestart = $request->datestart ? date("Y-m-d", strtotime($request->datestart . ' -1 day')) : date("Y-m-d", strtotime('-1 day'));
        $hd = DB::table('vw_productresult_daily_time')
        ->where('vw_productresult_daily_time.date',$request->datestart)
        ->whereNotIn('pdt_productresult_hd_line',['L1','L2','L3','L4'])
        ->get();
        $hdsum = DB::table('vw_productresult_daily_sum')
        ->where('date',$request->datestart)
        ->whereNotIn('pdt_productresult_hd_line',['L1','L2','L3','L4'])
        ->get();
        return view('report.form-planning-production2', compact('hd','datestart','hdsum'));
    }
    public function ReportPlanningPdDay2(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd1 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Skin')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL1 = $hd1->groupBy('pdt_process_dt_name')->toArray();
        $hd2 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Door console 640A ')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL2 = $hd2->groupBy('pdt_process_dt_name')->toArray();
        $hd3 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Hood - Door S/A')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL3 = $hd3->groupBy('pdt_process_dt_name')->toArray();
        $hd4 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Door console 230B,384D')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL4 = $hd4->groupBy('pdt_process_dt_name')->toArray();
        $hd5 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Garnish console')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL5 = $hd5->groupBy('pdt_process_dt_name')->toArray();
        $hd6 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Shifting hole 230B')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL6 = $hd6->groupBy('pdt_process_dt_name')->toArray();
        $hd7 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Brake 230B/350B')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL7 = $hd7->groupBy('pdt_process_dt_name')->toArray();
        $hd8 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Tonneua')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL8 = $hd8->groupBy('pdt_process_dt_name')->toArray();
        $hd9 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Mirage')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL9 = $hd9->groupBy('pdt_process_dt_name')->toArray();
        $hd10 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Brake 640')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL10 = $hd10->groupBy('pdt_process_dt_name')->toArray();
        $hd11 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Shifting hole D92A')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL11 = $hd11->groupBy('pdt_process_dt_name')->toArray();
        $hd12 = DB::table('vw_productresult_dailymodel')
        ->where('pdt_productresult_hd_line','Shifting hole 650A')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByL12 = $hd12->groupBy('pdt_process_dt_name')->toArray();
        return view('report.form-planning-productionday2', compact('dateend','datestart','hd1','groupedByL1','hd2','groupedByL2','hd3','groupedByL3'
        ,'hd4','groupedByL4','hd5','groupedByL5','hd6','groupedByL6','hd7','groupedByL7','hd8','groupedByL8','hd9','groupedByL9','hd10','groupedByL10'
        ,'hd11','groupedByL11','hd12','groupedByL12'));
    }
    public function ReportPlanningPdMonth2(Request $request)
    {
        if($request->years){
            $year = $request->years;    
        }else{
            $year = Carbon::now()->year;    
        }
        if($request->months){
            $month = $request->months;      
        }else{
            $month = Carbon::now()->month;      
        } 
        $hd1 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Brake 230B/350B')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        $hd2 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Brake 640')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        $hd3 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Door console 230B,384D')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        $hd4 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Door console 640A ')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        $hd5 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Garnish console')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        $hd6 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Hood - Door S/A')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        $hd7 = DB::table('vw_productionresult_2sum')
        ->where('pdt_productresult_hd_year',$year)
        ->where('pdt_productresult_hd_month',$month)
        ->where('pdt_productresult_hd_line','Shifting hole D92A')
        ->orderBy('pdt_process_dt_listno','asc')
        ->get();
        return view('report.form-planning-productionmonth2', compact('year','month','hd1','hd2','hd3','hd4','hd5','hd6','hd7'));
    }
    public function ReportPlanningPdYear2(Request $request)
    {
        if($request->years){
            $year = $request->years;    
        }else{
            $year = Carbon::now()->year;    
        }
        // if($request->months){
        //     $month = $request->months;      
        // }else{
        //     $month = Carbon::now()->month;      
        // } 
        $hd = DB::table('vw_reportproduct_process_yearv21')
                // ->where('pdt_productresult_hd_month',$month)
                ->where('pdt_productresult_hd_year',$year)
                ->get();
        return view('report.form-planning-productionyear2', compact('year','hd'));
    }
    public function ReportQcDay(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd = DB::table('vw_pdt_productqc_list')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        return view('report.form-production-qcday', compact('dateend','datestart','hd'));
    }
    public function ReportQcDay2(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd = DB::table('vw_pdt_productqc_list2')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        return view('report.form-production-qcday', compact('dateend','datestart','hd'));
    }
    public function ReportQcLossDay(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd = DB::table('vw_pdt_productqc_loss')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        return view('report.form-production-qclossday', compact('dateend','datestart','hd'));
    }
    public function ReportQcLossDay2(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd = DB::table('vw_pdt_productqc_loss2')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        return view('report.form-production-qclossday', compact('dateend','datestart','hd'));
    }
}
