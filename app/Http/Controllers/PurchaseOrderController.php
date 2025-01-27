<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
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
        $hd = DB::table('pur_purchaseorder_hd')       
        ->where('pur_purchaseorder_hd_id',$id)
        ->first();
        $dt = DB::table('pur_purchaseorder_dt')->where('pur_purchaseorder_hd_id',$id)
        ->where('flag',true)
        ->get();
        $wh = DB::table('pur_purchaseorder_wh')->where('pur_purchaseorder_hd_id',$id)
        ->where('flag',true)
        ->get();
        $fc = DB::table('pur_purchaseorder_fc')->where('pur_purchaseorder_hd_id',$id)
        ->where('flag',true)
        ->get();
        if($hd->pur_purchaseorder_status_id == 1){
            $sta = DB::table('pur_purchaseorder_status')
            ->whereIn('pur_purchaseorder_status_id',[1,3,2,6])
            ->get();
        }
        elseif ($hd->pur_purchaseorder_status_id == 5) {
            $sta = DB::table('pur_purchaseorder_status')
            ->whereIn('pur_purchaseorder_status_id',[1,3,2,6])
            ->get();
        }
        elseif ($hd->pur_purchaseorder_status_id == 6 || $hd->pur_purchaseorder_status_id == 7) {
            $sta = DB::table('pur_purchaseorder_status')
            ->whereIn('pur_purchaseorder_status_id',[3,2,7])
            ->get();
        }
        elseif($hd->pur_purchaseorder_status_id == 10){
            $sta = DB::table('pur_purchaseorder_status')
            ->whereIn('pur_purchaseorder_status_id',[10,11])
            ->get();
        }
        elseif($hd->pur_purchaseorder_status_id == 11){
            $sta = DB::table('pur_purchaseorder_status')
            ->whereIn('pur_purchaseorder_status_id',[10,11,12])
            ->get();
        }
        else{
            return view('dashboard');
        }
        $groupedByDaywh = $wh->groupBy('pur_purchaseorder_wh_duedate')->toArray();
        ksort($groupedByDaywh);
        $groupedByDayfc = $fc->groupBy('pur_purchaseorder_fc_duedate')->toArray();
        ksort($groupedByDayfc);
        return view('purchaseorder.form-purchaseorder-edit', compact('hd','dt','sta','wh','fc','groupedByDaywh','groupedByDayfc'));
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
        $hd = DB::table('pur_purchaseorder_hd')
        ->where('pur_purchaseorder_hd_id',$id)
        ->first();
        try{
            DB::beginTransaction();
            if($hd->pur_purchaseorder_status_id == 1){
            $up = DB::table('pur_purchaseorder_hd')
            ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
            ->update([
                'approved2_date' => Carbon::now(),
                'approved2_code' => Auth::user()->emp_person_code,
                'approved2_remark' => $request->approved_remark,
                'pur_purchaseorder_status_id' => $request->approved_status
            ]);
            DB::commit();
            define('LINE_API', "https://notify-api.line.me/api/notify");
            $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
            $params = array(
            "message"        => "เลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
            . "วันที่ดำเนินการ : " .  Carbon::now()->format('d/m/y H:i') ."\n"
            . "ผู้ดำเนินการ : " . Auth::user()->name ."\n"
            . "หมายเหตุ : " . $request->approved_remark ."\n"
            . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
            . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
            "stickerPkg"     => 8522, //stickerPackageId
            "stickerId"      => 16581281, //stickerId
            // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
            // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
            );
            $res = $this->notify_message($params, $token);
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            elseif ($hd->pur_purchaseorder_status_id == 5) {
                $up = DB::table('pur_purchaseorder_hd')
                ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                ->update([
                    'approved2_date' => Carbon::now(),
                    'approved2_code' => Auth::user()->emp_person_code,
                    'approved2_remark' => $request->approved_remark,
                    'pur_purchaseorder_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "เลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
                . "วันที่ตรวจสอบ : " . Carbon::now()->format('d/m/y H:i') ."\n"
                . "ผู้ตรวจสอบ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            elseif ($hd->pur_purchaseorder_status_id == 6) {
                
                $up = DB::table('pur_purchaseorder_hd')
                ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                ->update([
                    'approved3_date' => Carbon::now(),
                    'approved3_code' => Auth::user()->emp_person_code,
                    'approved3_remark' => $request->approved_remark,
                    'pur_purchaseorder_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "เลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
                . "วันที่อนุมัติ : " .  Carbon::now()->format('d/m/y H:i') ."\n"
                . "ผู้อนุมัติ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            elseif ($hd->pur_purchaseorder_status_id == 7) {
                if($hd->check_approved4 == null){
                    $up = DB::table('pur_purchaseorder_hd')
                    ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                    ->update([
                        'approved4_date' => Carbon::now(),
                        'approved4_code' => Auth::user()->emp_person_code,
                        'approved4_remark' => $request->approved_remark,
                        'approved4_save' =>  Auth::user()->name,
                        'pur_purchaseorder_status_id' => $request->approved_status
                    ]);
                    DB::commit();
                    define('LINE_API', "https://notify-api.line.me/api/notify");
                    $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                    $params = array(
                    "message"        => "เลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
                    . "วันที่รับทราบ : " .  Carbon::now()->format('d/m/y H:i') ."\n"
                    . "ผู้รับทราบ : " . Auth::user()->name ."\n"
                    . "หมายเหตุ : " . $request->approved_remark ."\n"
                    . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                    . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                    "stickerPkg"     => 8522, //stickerPackageId
                    "stickerId"      => 16581281, //stickerId
                    // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                    // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                    );
                    $res = $this->notify_message($params, $token);
                    return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
                }              
            }
            elseif ($hd->pur_purchaseorder_status_id == 10) {
                $up = DB::table('pur_purchaseorder_hd')
                ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                ->update([
                    'approvedclose1_date' => Carbon::now(),
                    'approvedclose1_code' => Auth::user()->emp_person_code,
                    'approvedclose1_note' => $request->approved_remark,
                    'pur_purchaseorder_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "ปิดเลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
                . "วันที่อนุมัติ : " . Carbon::now()->format('d/m/y H:i') ."\n"
                . "ผู้อนุมัติ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            elseif ($hd->pur_purchaseorder_status_id == 11) {
                $up = DB::table('pur_purchaseorder_hd')
                ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                ->update([
                    'approvedclose2_date' => Carbon::now(),
                    'approvedclose2_code' => Auth::user()->emp_person_code,
                    'approvedclose2_note' => $request->approved_remark,
                    'pur_purchaseorder_status_id' => $request->approved_status
                ]);
                DB::commit();
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "ปิดเลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
                . "วันที่อนุมัติ : " . Carbon::now()->format('d/m/y H:i') ."\n"
                . "ผู้อนุมัติ : " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
                return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
            }
            else{
                $up = DB::table('pur_purchaseorder_hd')
                ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                ->update([
                    'pur_purchaseorder_status_id' => $request->approved_status
                ]);
                DB::commit();
                $sta = DB::table('pur_purchaseorder_status')
                ->where('pur_purchaseorder_status_id',$request->approved_status)
                ->first();
                $dt = DB::table('pur_purchaseorder_dt')
                ->where('pur_purchaseorder_hd_id',$hd->pur_purchaseorder_hd_id)
                ->get();
                foreach ($dt as $key => $value) {
                    $up = DB::table('pur_purchaserequest_hd')
                    ->where('pur_purchaserequest_hd_docuno',$value->pur_purchaserequest_hd_docuno)
                    ->update([
                        'pur_purchaserequest_status_id' => 7
                    ]);
                }
                define('LINE_API', "https://notify-api.line.me/api/notify");
                $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
                $params = array(
                "message"        => "เลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
                . "วันที่ : " .  Carbon::now()->format('d/m/y H:i') ."\n"
                . "ผู้ดำเนินการ: " . Auth::user()->name ."\n"
                . "หมายเหตุ : " . $request->approved_remark ."\n"
                . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
                . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n"
                . "สถานะ : " . $sta->pur_purchaseorder_status_name, //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
                "stickerPkg"     => 8522, //stickerPackageId
                "stickerId"      => 16581281, //stickerId
                // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
                // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
                );
                $res = $this->notify_message($params, $token);
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
    public function ApprovedPo1(Request $request)
    {
        $hd = DB::table('pur_purchaseorder_hd')->where('pur_purchaseorder_status_id',1)->get();
        return view('purchaseorder.form-purchaseorder-app1', compact('hd'));
    }
    public function ApprovedPo2(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));
        if(Auth::user()->id == 1 || Auth::user()->id == 9){
            $hd = DB::table('pur_purchaseorder_hd')
            ->leftjoin('pur_purchaseorder_status','pur_purchaseorder_hd.pur_purchaseorder_status_id','=','pur_purchaseorder_status.pur_purchaseorder_status_id')
            ->where('pur_purchaseorder_hd.pur_purchaseorder_status_id','<>',2)
            ->whereBetween('pur_purchaseorder_hd.pur_purchaseorder_hd_date', [$datestart, $dateend])
            ->get();
        }else{
            $hd = DB::table('pur_purchaseorder_hd')
            ->leftjoin('pur_purchaseorder_status','pur_purchaseorder_hd.pur_purchaseorder_status_id','=','pur_purchaseorder_status.pur_purchaseorder_status_id')
            ->where('pur_purchaseorder_hd.approved2_save',Auth::user()->name)
            ->where('pur_purchaseorder_hd.pur_purchaseorder_status_id','<>',2)
            ->whereBetween('pur_purchaseorder_hd.pur_purchaseorder_hd_date', [$datestart, $dateend])
            ->get();
        }
       
        return view('purchaseorder.form-purchaseorder-app2', compact('hd','dateend','datestart'));
    }
    public function ApprovedPo3(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));
        if(Auth::user()->id == 1 || Auth::user()->id == 9){
            $hd = DB::table('pur_purchaseorder_hd')
            ->leftjoin('pur_purchaseorder_status','pur_purchaseorder_hd.pur_purchaseorder_status_id','=','pur_purchaseorder_status.pur_purchaseorder_status_id')
            ->where('pur_purchaseorder_hd.pur_purchaseorder_status_id','<>',2)
            ->whereBetween('pur_purchaseorder_hd.pur_purchaseorder_hd_date', [$datestart, $dateend])
            ->get();
        }else{
            $hd = DB::table('pur_purchaseorder_hd')
            ->leftjoin('pur_purchaseorder_status','pur_purchaseorder_hd.pur_purchaseorder_status_id','=','pur_purchaseorder_status.pur_purchaseorder_status_id')
            ->where('pur_purchaseorder_hd.approved3_save',Auth::user()->name)
            ->where('pur_purchaseorder_hd.pur_purchaseorder_status_id','<>',2)
            ->whereBetween('pur_purchaseorder_hd.pur_purchaseorder_hd_date', [$datestart, $dateend])
            ->get();
        }     
        return view('purchaseorder.form-purchaseorder-app3', compact('hd','dateend','datestart'));
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
    public function getDataPo(Request $request)
    {
        $id = $request->refid;
        $dt = DB::table('pur_purchaseorder_dt')    
            ->where('pur_purchaseorder_hd_id',$id)
            ->where('flag',true)
            ->get();
        return response()->json(
            [
                'status' => true,
                'dt' => $dt
            ]
        );
    }

    public function confirmDelPo(Request $request)
    {
        $id = $request->refid;
        try {
            $hd = DB::table('pur_purchaseorder_hd')
            ->where('pur_purchaseorder_hd_id',$id)
            ->first();
            define('LINE_API', "https://notify-api.line.me/api/notify");
            $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
            $params = array(
            "message"        => "ปิดเลขที่ PO : " . $hd->pur_purchaseorder_hd_docuno ."\n"
            . "วันที่ยกเลิก : " . Carbon::now() ."\n"
            . "ผู้ยกเลิก : " . Auth::user()->name ."\n"
            . "ผู้จำหน่าย : " . $hd->vd_vendor_fullname ."\n"
            . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaseorder_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
            "stickerPkg"     => 8522, //stickerPackageId
            "stickerId"      => 16581281, //stickerId
            // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
            // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
            );
            $res = $this->notify_message($params, $token);
            DB::beginTransaction();
            $update_hd = DB::table('pur_purchaseorder_hd')
            ->where('pur_purchaseorder_hd_id', $id)
                ->update([
                    'pur_purchaseorder_status_id' => 2
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

    public function ReportPoOutstanding(Request $request)
    {
        $hd = DB::table('vw_poconvertgr')->where('pur_purchaseorder_total','>',0)->get();
        return view('report.form-purchase-pooutstanding', compact('hd'));
    }

    public function ReportPurchaseOrder(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));
        $hd = DB::table('vw_report_purchaseorder')
        ->whereBetween('pur_purchaseorder_hd_date', [$datestart, $dateend])
        ->get();
        $groupedByMonthYear = $hd->groupBy(function($item) {
            return Carbon::parse($item->pur_purchaseorder_hd_date)->format('Y-m');
        })->toArray();
        return view('report.form-purchase-report', compact('hd','dateend','datestart','groupedByMonthYear'));
    }
    public function ApprovedPoClose1(Request $request)
    {
        $hd = DB::table('pur_purchaseorder_hd')
        ->where('pur_purchaseorder_status_id',10)
        ->where('approved2_save',Auth::user()->name)
        ->get();
        return view('purchaseorder.form-purchaseorder-appclose1', compact('hd'));
    }
    public function ApprovedPoClose2(Request $request)
    {
        $hd = DB::table('pur_purchaseorder_hd')
        ->where('pur_purchaseorder_status_id',11)
        ->where('approved3_save',Auth::user()->name)
        ->get();
        return view('purchaseorder.form-purchaseorder-appclose2', compact('hd'));
    }
}
