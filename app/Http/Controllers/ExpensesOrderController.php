<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ExpensesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $hd = DB::table('pur_expenses_hd')->where('pur_expenses_hd_id',$id)->first();
        $dt = DB::table('pur_expenses_dt')->where('pur_expenses_hd_id',$id)
        ->where('flag',true)
        ->get();
        if($hd->pur_expenses_status_id == 1){
            $sta = DB::table('pur_expenses_status')
            ->whereIn('pur_expenses_status_id',[1,3,2,6])
            ->get();
        }
        elseif ($hd->pur_expenses_status_id == 5) {
            $sta = DB::table('pur_expenses_status')
            ->whereIn('pur_expenses_status_id',[1,3,2,6])
            ->get();
        }
        elseif ($hd->pur_expenses_status_id == 6) {
            $sta = DB::table('pur_expenses_status')
            ->whereIn('pur_expenses_status_id',[3,2,7])
            ->get();
        }
        return view('expenses.form-expenses-edit', compact('hd','dt','sta'));
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
        $hd = DB::table('pur_expenses_hd')
        ->where('pur_expenses_hd_id',$id)
        ->first();
        try{
            DB::beginTransaction();
            if($hd->pur_expenses_status_id == 1){
                $up = DB::table('pur_expenses_hd')
                ->where('pur_expenses_hd_id',$hd->pur_expenses_hd_id)
                ->update([
                    'approved1_date' => Carbon::now(),
                    'approved1_code' => Auth::user()->emp_person_code,
                    'approved1_remark' => $request->approved_remark,
                    'pur_expenses_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "เลขที่ ASE : " . $hd->pur_expenses_hd_docuno ."\n"
                . "วันที่ดำเนินการ : " . Carbon::now() ."\n"
                . "ผู้ดำเนินการ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_expenses_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            elseif ($hd->pur_expenses_status_id == 5) {
                $up = DB::table('pur_expenses_hd')
                ->where('pur_expenses_hd_id',$hd->pur_expenses_hd_id)
                ->update([
                    'approved2_date' => Carbon::now(),
                    'approved2_code' => Auth::user()->emp_person_code,
                    'approved2_remark' => $request->approved_remark,
                    'pur_expenses_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "เลขที่ ASE : " . $hd->pur_expenses_hd_docuno ."\n"
                . "วันที่ตรวจสอบ : " . Carbon::now() ."\n"
                . "ผู้ตรวจสอบ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_expenses_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            elseif ($hd->pur_expenses_status_id == 6) {
                $up = DB::table('pur_expenses_hd')
                ->where('pur_expenses_hd_id',$hd->pur_expenses_hd_id)
                ->update([
                    'approved3_date' => Carbon::now(),
                    'approved3_code' => Auth::user()->emp_person_code,
                    'approved3_remark' => $request->approved_remark,
                    'pur_expenses_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "เลขที่ ASE : " . $hd->pur_expenses_hd_docuno ."\n"
                . "วันที่อนุมัติ : " . Carbon::now() ."\n"
                . "ผู้อนุมัติ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_expenses_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            else{
                $up = DB::table('pur_expenses_hd')
                ->where('pur_expenses_hd_id',$hd->pur_expenses_hd_id)
                ->update([
                    'pur_expenses_status_id' => $request->approved_status
                ]);
                DB::commit();
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
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
    public function ApprovedAse1(Request $request)
    {
        $hd = DB::table('pur_expenses_hd')->where('pur_expenses_status_id',1)->get();
        return view('expenses.form-expenses-app1', compact('hd'));
    }
    public function ApprovedAse2(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));      
        if(Auth::user()->id == 1 || Auth::user()->id == 9){
            $hd = DB::table('pur_expenses_hd')
            ->leftjoin('pur_expenses_status','pur_expenses_hd.pur_expenses_status_id','=','pur_expenses_status.pur_expenses_status_id')
            ->where('pur_expenses_hd.pur_expenses_status_id','<>',2)
            ->whereBetween('pur_expenses_hd.pur_expenses_hd_date', [$datestart, $dateend])
            ->get();
        }else{
            $hd = DB::table('pur_expenses_hd')
            ->leftjoin('pur_expenses_status','pur_expenses_hd.pur_expenses_status_id','=','pur_expenses_status.pur_expenses_status_id')
            ->where('pur_expenses_hd.approved2_save',Auth::user()->name)
            ->where('pur_expenses_hd.pur_expenses_status_id','<>',2)
            ->whereBetween('pur_expenses_hd.pur_expenses_hd_date', [$datestart, $dateend])
            ->get();
        }
       
        return view('expenses.form-expenses-app2', compact('hd','dateend','datestart'));
    }
    public function ApprovedAse3(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));
        if(Auth::user()->id == 1 || Auth::user()->id == 9){
            $hd = DB::table('pur_expenses_hd')
            ->leftjoin('pur_expenses_status','pur_expenses_hd.pur_expenses_status_id','=','pur_expenses_status.pur_expenses_status_id')
            ->where('pur_expenses_hd.pur_expenses_status_id','<>',2)
            ->whereBetween('pur_expenses_hd.pur_expenses_hd_date', [$datestart, $dateend])
            ->get();
        }else{
            $hd = DB::table('pur_expenses_hd')
            ->leftjoin('pur_expenses_status','pur_expenses_hd.pur_expenses_status_id','=','pur_expenses_status.pur_expenses_status_id')
            ->where('pur_expenses_hd.approved3_save',Auth::user()->name)
            ->where('pur_expenses_hd.pur_expenses_status_id','<>',2)
            ->whereBetween('pur_expenses_hd.pur_expenses_hd_date', [$datestart, $dateend])
            ->get();
        }
       
        return view('expenses.form-expenses-app3', compact('hd','dateend','datestart'));
    }

    function notify_message($params, $token)
    {
        $queryData = array(
            'message'          => $params["message"],
            'stickerPackageId' => $params["stickerPkg"],
            'stickerId'        => $params["stickerId"],
            // 'imageThumbnail'   => $params["imageThumbnail"],
            // 'imageFullsize'    => $params["imageFullsize"],
        );
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
                    . "Authorization: Bearer " . $token . "\r\n"
                    . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData,
            ),
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents(LINE_API, FALSE, $context);
        $res = json_decode($result);
        return $res;
    }

    public function getDataAse(Request $request)
    {
        $id = $request->refid;
        $dt = DB::table('pur_expenses_dt')    
            ->where('pur_expenses_hd_id',$id)
            ->where('flag',true)
            ->get();
        return response()->json(
            [
                'status' => true,
                'dt' => $dt
            ]
        );
    }

    public function confirmDelAse(Request $request)
    {
        $id = $request->refid;
        try {
            DB::beginTransaction();
            $update_hd = DB::table('pur_expenses_hd')
            ->where('pur_expenses_hd_id', $id)
                ->update([
                    'pur_expenses_status_id' => 2
                ]);           
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกเอกสารเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
