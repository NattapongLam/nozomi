<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceDocoff extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = DB::table('mtn_maintenanceoffdoc')
        ->leftjoin('mtn_maintenanceoffstatus','mtn_maintenanceoffdoc.mtn_maintenanceoffstatus_id','=','mtn_maintenanceoffstatus.mtn_maintenanceoffstatus_id')
        ->leftjoin('emp_person','mtn_maintenanceoffdoc.person_at','=','emp_person.emp_person_code')
        ->get();
        return view('maintain.form-maintenancedocoff-open', compact('hd'));
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
        $hd = DB::table('mtn_maintenanceoffdoc')
        ->leftjoin('mtn_maintenanceoffstatus','mtn_maintenanceoffdoc.mtn_maintenanceoffstatus_id','=','mtn_maintenanceoffstatus.mtn_maintenanceoffstatus_id')
        ->leftjoin('emp_person','mtn_maintenanceoffdoc.person_at','=','emp_person.emp_person_code')
        ->where('mtn_maintenanceoffdoc.mtn_maintenanceoffdoc_id',$id)
        ->first();
        return view('maintain.form-maintenancedocoff-edit', compact('hd'));
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
}
