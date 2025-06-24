<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrScanController extends Controller
{
     public function MaintenanceList($id)
    {        
        $hd = DB::table('mtn_machinery')
        ->where('mtn_machinery_code',$id)
        ->first();
        return view('qrscan.maintenance-list',compact('hd'));
    }
}
