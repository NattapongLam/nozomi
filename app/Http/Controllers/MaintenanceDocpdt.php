<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceDocpdt extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = DB::table('mtn_maintenancedoc')
        ->leftjoin('mtn_maintenancestatus','mtn_maintenancedoc.mtn_maintenancestatus_id','=','mtn_maintenancestatus.mtn_maintenancestatus_id')
        ->get();
        return view('maintain.form-maintenancedocpdt-open', compact('hd'));
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
        $hd = DB::table('mtn_maintenancedoc')
        ->leftjoin('mtn_maintenancestatus','mtn_maintenancedoc.mtn_maintenancestatus_id','=','mtn_maintenancestatus.mtn_maintenancestatus_id')
        ->where('mtn_maintenancedoc.mtn_maintenancedoc_id',$id)
        ->first();
        return view('maintain.form-maintenancedocpdt-edit', compact('hd'));
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
        try {
            DB::beginTransaction();
            $hd = DB::table('mtn_maintenancedoc')->where('mtn_maintenancedoc_id',$id)->first();
            if($hd->mtn_maintenancestatus_id == 1){
                $up = DB::table('mtn_maintenancedoc')
                ->where('mtn_maintenancedoc_id',$id)
                ->update([
                    'mtn_maintenancestatus_id' => 3,
                    'mtn_maintenancedoc_jobperson' => Auth::user()->name,
                    'mtn_maintenancedoc_jobdate' => Carbon::now(),
                    'job_at' => Carbon::now()
                ]);
            }
            elseif($hd->mtn_maintenancestatus_id == 3){
                $up = DB::table('mtn_maintenancedoc')
                ->where('mtn_maintenancedoc_id',$id)
                ->update([
                    'mtn_maintenancestatus_id' => 7,
                    'approved_jobdate' => Carbon::now(),
                    'approved_jobsave' => Auth::user()->name,
                ]);
            }
            elseif($hd->mtn_maintenancestatus_id == 7){
                $up = DB::table('mtn_maintenancedoc')
                ->where('mtn_maintenancedoc_id',$id)
                ->update([
                    'mtn_maintenancestatus_id' => 4,
                    'mtn_maintenancedoc_jobresultperson' => Auth::user()->name,
                    'mtn_maintenancedoc_jobresultdate' => Carbon::now(),
                    'mtn_maintenancedoc_check1' => $request->mtn_maintenancedoc_check1,
                    'mtn_maintenancedoc_check2' => $request->mtn_maintenancedoc_check2,
                    'mtn_maintenancedoc_check3' => $request->mtn_maintenancedoc_check3,
                    'mtn_maintenancedoc_check4' => $request->mtn_maintenancedoc_check4,
                    'mtn_maintenancedoc_check5' => $request->mtn_maintenancedoc_check5,
                    'mtn_maintenancedoc_other' => $request->mtn_maintenancedoc_other,
                    'mtn_maintenancedoc_jobremark' => $request->mtn_maintenancedoc_jobremark,
                    'mtn_maintenancedoc_jobnote' => $request->mtn_maintenancedoc_jobnote
                ]);
            }           
            elseif($hd->mtn_maintenancestatus_id == 4){
                $up = DB::table('mtn_maintenancedoc')
                ->where('mtn_maintenancedoc_id',$id)
                ->update([
                    'mtn_maintenancestatus_id' => 5,
                    'mtn_maintenancedoc_jobrecheckperson' => Auth::user()->name,
                    'mtn_maintenancedoc_jobrecheckdate' => Carbon::now(),
                    'recheck_at' => Carbon::now()
                ]);
            }
            elseif($hd->mtn_maintenancestatus_id == 5){
                $up = DB::table('mtn_maintenancedoc')
                ->where('mtn_maintenancedoc_id',$id)
                ->update([
                    'mtn_maintenancestatus_id' => 6,
                    'mtn_maintenancedoc_jobapprovedperson' => Auth::user()->name,
                    'mtn_maintenancedoc_jobapproveddate' => Carbon::now(),
                    'approved_at' => Carbon::now()
                ]);
            }
            DB::commit();
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        }
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
}
