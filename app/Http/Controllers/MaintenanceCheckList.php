<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MaintenanceCheckList extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = DB::table('mtn_machinerycheck_hd')->where('flag',true)->get();
        return view('maintain.form-maintenancechecklist-open', compact('hd'));
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
        $hd = DB::table('mtn_machinerycheck_hd')->where('mtn_machinerycheck_hd_id',$id)->first();
        $dt = DB::table('mtn_machinerycheck_dt')->where('mtn_machinerycheck_hd_id',$id)->where('flag',true)->get();
        if($hd->person_pdt){
            $emppdt = DB::table('emp_person')->where('emp_person_code',$hd->person_pdt)->first();
            $pdt = $emppdt->emp_person_fullname;
        }else{
            $pdt = '-';
        }
        if($hd->person_job){
            $empjob = DB::table('emp_person')->where('emp_person_code',$hd->person_job)->first();
            $job = $empjob->emp_person_fullname;
        }else{
            $job = '-';
        }
        if($hd->person_app){
            $empapp = DB::table('emp_person')->where('emp_person_code',$hd->person_app)->first();
            $app = $empapp->emp_person_fullname;
        }else{
            $app = '-';
        }        
        return view('maintain.form-maintenancechecklist-edit', compact('hd','dt','pdt','job','app'));
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
            $hd = DB::table('mtn_machinerycheck_hd')
            ->where('mtn_machinerycheck_hd_id',$id)
            ->update([
                'update_at' => Carbon::now(),
            ]);
            foreach ($request->dt_id as $key => $value) {
                $dt = DB::table('mtn_machinerycheck_dt')
                ->where('mtn_machinerycheck_dt_id',$value)
                ->update([
                    'c01' => $request->action01[$key],
                    'c02' => $request->action02[$key],
                    'c03' => $request->action03[$key],
                    'c04' => $request->action04[$key],
                    'c05' => $request->action05[$key],
                    'c06' => $request->action06[$key],
                    'c07' => $request->action07[$key],
                    'c08' => $request->action08[$key],
                    'c09' => $request->action09[$key],
                    'c10' => $request->action10[$key],
                    'c11' => $request->action11[$key],
                    'c12' => $request->action12[$key],
                    'c13' => $request->action13[$key],
                    'c14' => $request->action14[$key],
                    'c15' => $request->action15[$key],
                    'c16' => $request->action16[$key],
                    'c17' => $request->action17[$key],
                    'c18' => $request->action18[$key],
                    'c19' => $request->action19[$key],
                    'c20' => $request->action20[$key],
                    'c21' => $request->action21[$key],
                    'c22' => $request->action22[$key],
                    'c23' => $request->action23[$key],
                    'c24' => $request->action24[$key],
                    'c25' => $request->action25[$key],
                    'c26' => $request->action26[$key],
                    'c27' => $request->action27[$key],
                    'c28' => $request->action28[$key],
                    'c29' => $request->action29[$key],
                    'c30' => $request->action30[$key],
                    'c31' => $request->action31[$key],
                    'person_at' => Auth::user()->emp_person_code,
                    'update_at' => Carbon::now()
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
