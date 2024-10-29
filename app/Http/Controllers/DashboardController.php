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
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d");
        $hd = DB::table('vw_productresult_daily')
        ->where('date',$request->datestart)
        ->get();
        return view('report.form-planning-production', compact('hd','datestart'));
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
        }                    
        return view('report.form-planning-delivery', compact('hd1','hd2','hd3','hd4'));
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
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-7 day", strtotime($dateend)));
        $hd = DB::table('vw_fgissuestock_report')
        ->whereBetween('date', [$datestart, $dateend])
        ->get();
        $groupedByDay = $hd->groupBy('date')->toArray();
        return view('report.form-delivery-day', compact('dateend','datestart','hd','groupedByDay'));

    }
}
