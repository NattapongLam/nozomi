<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PurchaseRequestController extends Controller
{
    private function notifyTelegram($message, $token, $chatId)
    {
        $queryData = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $response = file_get_contents($url . "?" . http_build_query($queryData));
        return json_decode($response);
    }
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
        $hd = DB::table('pur_purchaserequest_hd')
        ->leftjoin('ms_allocate','pur_purchaserequest_hd.ms_allocate_id','=','ms_allocate.ms_allocate_id')
        ->where('pur_purchaserequest_hd_id',$id)
        ->first();
        $dt = DB::table('pur_purchaserequest_dt')->where('pur_purchaserequest_hd_id',$id)
        ->where('flag',true)
        ->get();
        if($hd->pur_purchaserequest_status_id == 1){
            $sta = DB::table('pur_purchaserequest_status')
            ->whereIn('pur_purchaserequest_status_id',[3,2,6])
            ->get();
        }
        elseif ($hd->pur_purchaserequest_status_id == 5) {
            $sta = DB::table('pur_purchaserequest_status')
            ->whereIn('pur_purchaserequest_status_id',[1,3,2,6])
            ->get();
        }
        elseif ($hd->pur_purchaserequest_status_id == 6 || $hd->pur_purchaserequest_status_id == 7) {
            $sta = DB::table('pur_purchaserequest_status')
            ->whereIn('pur_purchaserequest_status_id',[3,2,7])
            ->get();
        }
        else{
            return view('dashboard');
        }
        return view('purchaserequest.form-purchaserequest-edit', compact('hd','dt','sta'));
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
        $hd = DB::table('pur_purchaserequest_hd')
        ->where('pur_purchaserequest_hd_id',$id)
        ->first();
        try{
            DB::beginTransaction();
        if($hd->pur_purchaserequest_status_id == 1){
            $up = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id',$hd->pur_purchaserequest_hd_id)
            ->update([
                'approved2_date' => Carbon::now(),
                'approved2_code' => Auth::user()->emp_person_code,
                'approved2_remark' => $request->approved_remark,
                'pur_purchaserequest_status_id' => $request->approved_status
            ]);
            DB::commit();
            // define('LINE_API', "https://notify-api.line.me/api/notify");
            // $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
            // $params = array(
            // "message"        => "เลขที่ PR : " . $hd->pur_purchaserequest_hd_docuno ."\n"
            // . "วันที่ดำเนินการ : " .  Carbon::now()->format('d/m/y h:i') ."\n"
            // . "ผู้ดำเนินการ : " . Auth::user()->name ."\n"
            // . "หมายเหตุ : " . $request->approved_remark ."\n"
            // . "แผนก : " . $hd->emp_department_name ."\n"
            // . "ผู้ขอสั่งซื้อ : " . $hd->pur_purchaserequest_hd_save ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
            // "stickerPkg"     => 8522, //stickerPackageId
            // "stickerId"      => 16581281, //stickerId
            // // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
            // // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
            // );
            // $res = $this->notify_message($params, $token);
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
        }
        elseif ($hd->pur_purchaserequest_status_id == 5) {
            $up = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id',$hd->pur_purchaserequest_hd_id)
            ->update([
                'approved2_date' => Carbon::now(),
                'approved2_code' => Auth::user()->emp_person_code,
                'approved2_remark' => $request->approved_remark,
                'pur_purchaserequest_status_id' => $request->approved_status
            ]);
            DB::commit();
            $token = "7681986758:AAEB-BCtW1Yw-F30bMYeX-Hhlt36a9SIvgQ";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4779044927";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 เลขที่ PR" . $hd->pur_purchaserequest_hd_docuno  ."\n"
                . "🔹 หมายเหตุ  : ". $request->approved_remark . "\n"
                . "📅 วันที่ตรวจสอบ : " . Carbon::now()->format('d/m/y H:i') . "\n"
                . "👤 ผู้ตรวจสอบ : " . Auth::user()->name;    
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);    
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
        }
        elseif ($hd->pur_purchaserequest_status_id == 6) {
            $up = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id',$hd->pur_purchaserequest_hd_id)
            ->update([
                'approved3_date' => Carbon::now(),
                'approved3_code' => Auth::user()->emp_person_code,
                'approved3_remark' => $request->approved_remark,
                'pur_purchaserequest_status_id' => $request->approved_status,
                'check_approved4' =>  $request->check_approved4 ?? false,
            ]);
            DB::commit();
            $token = "7681986758:AAEB-BCtW1Yw-F30bMYeX-Hhlt36a9SIvgQ";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4779044927";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 เลขที่ PR" . $hd->pur_purchaserequest_hd_docuno  ."\n"
                . "🔹 หมายเหตุ  : ". $request->approved_remark . "\n"
                . "📅 วันที่อนุมัติ : " . Carbon::now()->format('d/m/y H:i') . "\n"
                . "👤 ผู้อนุมัติ : " . Auth::user()->name;    
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);    
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
        } 
        elseif ($hd->pur_purchaserequest_status_id == 7) {
            $up = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id',$hd->pur_purchaserequest_hd_id)
            ->update([
                'approved4_date' => Carbon::now(),
                'approved4_code' => Auth::user()->emp_person_code,
                'approved4_remark' => $request->approved_remark,
                'approved4_save' =>  Auth::user()->name,
                'pur_purchaserequest_status_id' => $request->approved_status,
            ]);
            DB::commit();
            $token = "7681986758:AAEB-BCtW1Yw-F30bMYeX-Hhlt36a9SIvgQ";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4779044927";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 เลขที่ PR" . $hd->pur_purchaserequest_hd_docuno  ."\n"
                . "🔹 หมายเหตุ  : ". $request->approved_remark . "\n"
                . "📅 วันที่อนุมัติ : " . Carbon::now()->format('d/m/y H:i') . "\n"
                . "👤 ผู้อนุมัติ : " . Auth::user()->name;    
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);    
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
        } 
        elseif ($hd->pur_purchaserequest_status_id == 3) 
        {
            $up = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id',$hd->pur_purchaserequest_hd_id)
            ->update([
                'pur_purchaserequest_status_id' => $request->approved_status,
            ]);
            DB::commit();
            $token = "7681986758:AAEB-BCtW1Yw-F30bMYeX-Hhlt36a9SIvgQ";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4779044927";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 เลขที่ PR" . $hd->pur_purchaserequest_hd_docuno  ."\n"
                . "🔹 ส่งกลับแก้ไข ". "\n"
                . "📅 วันที่บันทึก : " . Carbon::now()->format('d/m/y H:i') . "\n"
                . "👤 ผู้บันทึก : " . Auth::user()->name;    
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);  
            return redirect()->back()->withInput()->with('success', 'เพิ่มข้อมูลสำเร็จ ' . Carbon::now());
        }   
        elseif ($hd->pur_purchaserequest_status_id == 4) 
        {
            $up = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id',$hd->pur_purchaserequest_hd_id)
            ->update([
                'pur_purchaserequest_status_id' => $request->approved_status,
            ]);
            DB::commit();
            $token = "7681986758:AAEB-BCtW1Yw-F30bMYeX-Hhlt36a9SIvgQ";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4779044927";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 เลขที่ PR" . $hd->pur_purchaserequest_hd_docuno  ."\n"
                . "🔹 ไม่อนุมัติ ". "\n"
                . "📅 วันที่บันทึก : " . Carbon::now()->format('d/m/y H:i') . "\n"
                . "👤 ผู้บันทึก : " . Auth::user()->name;    
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);  
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
    public function ApprovedPr1(Request $request)
    {
        $hd = DB::table('pur_purchaserequest_hd')->where('pur_purchaserequest_status_id',1)->get();
        return view('purchaserequest.form-purchaserequest-app1', compact('hd'));
    }
    public function ApprovedPr2(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));
        if(Auth::user()->id == 1 || Auth::user()->id == 9)
        {
            $hd = DB::table('pur_purchaserequest_hd')
            ->leftjoin('pur_purchaserequest_status','pur_purchaserequest_hd.pur_purchaserequest_status_id','=','pur_purchaserequest_status.pur_purchaserequest_status_id')
            ->leftjoin('ms_allocate','pur_purchaserequest_hd.ms_allocate_id','=','ms_allocate.ms_allocate_id')
            ->whereBetween('pur_purchaserequest_hd_date', [$datestart, $dateend])
            ->get();
        }
        else
        {
            $hd = DB::table('pur_purchaserequest_hd')
            ->leftjoin('pur_purchaserequest_status','pur_purchaserequest_hd.pur_purchaserequest_status_id','=','pur_purchaserequest_status.pur_purchaserequest_status_id')
            ->leftjoin('ms_allocate','pur_purchaserequest_hd.ms_allocate_id','=','ms_allocate.ms_allocate_id')
            ->where('pur_purchaserequest_hd.approved2_save',Auth::user()->name)
            ->whereBetween('pur_purchaserequest_hd.pur_purchaserequest_hd_date', [$datestart, $dateend])
            ->get();
        }
        
        return view('purchaserequest.form-purchaserequest-app2', compact('hd','dateend','datestart'));
    }
    public function ApprovedPr3(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-3 month", strtotime($dateend)));
        if(Auth::user()->id == 1 || Auth::user()->id == 9)
        {
            $hd = DB::table('pur_purchaserequest_hd')
            ->leftjoin('pur_purchaserequest_status','pur_purchaserequest_hd.pur_purchaserequest_status_id','=','pur_purchaserequest_status.pur_purchaserequest_status_id')
            ->leftjoin('ms_allocate','pur_purchaserequest_hd.ms_allocate_id','=','ms_allocate.ms_allocate_id')
            ->whereBetween('pur_purchaserequest_hd.pur_purchaserequest_hd_date', [$datestart, $dateend])
            ->get();
        }
        else {
            $hd = DB::table('pur_purchaserequest_hd')
            ->leftjoin('pur_purchaserequest_status','pur_purchaserequest_hd.pur_purchaserequest_status_id','=','pur_purchaserequest_status.pur_purchaserequest_status_id')
            ->leftjoin('ms_allocate','pur_purchaserequest_hd.ms_allocate_id','=','ms_allocate.ms_allocate_id')
            ->where('pur_purchaserequest_hd.approved3_save',Auth::user()->name)
            ->whereBetween('pur_purchaserequest_hd.pur_purchaserequest_hd_date', [$datestart, $dateend])
            ->get();
        }      
        return view('purchaserequest.form-purchaserequest-app3', compact('hd','dateend','datestart'));
    }

    // function notify_message($params, $token)
    // {
    //     $queryData = array(
    //         'message'          => $params["message"],
    //         'stickerPackageId' => $params["stickerPkg"],
    //         'stickerId'        => $params["stickerId"],
    //         // 'imageThumbnail'   => $params["imageThumbnail"],
    //         // 'imageFullsize'    => $params["imageFullsize"],
    //     );
    //     $queryData = http_build_query($queryData, '', '&');
    //     $headerOptions = array(
    //         'http' => array(
    //             'method'  => 'POST',
    //             'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
    //                 . "Authorization: Bearer " . $token . "\r\n"
    //                 . "Content-Length: " . strlen($queryData) . "\r\n",
    //             'content' => $queryData,
    //         ),
    //     );
    //     $context = stream_context_create($headerOptions);
    //     $result = file_get_contents(LINE_API, FALSE, $context);
    //     $res = json_decode($result);
    //     return $res;
    // }
    public function getDataPr(Request $request)
    {
        $id = $request->refid;
        $dt = DB::table('pur_purchaserequest_dt')    
            ->where('pur_purchaserequest_hd_id',$id)
            ->where('flag',true)
            ->get();
        return response()->json(
            [
                'status' => true,
                'dt' => $dt
            ]
        );
    }
    public function confirmDelPr(Request $request)
    {
        $id = $request->refid;
        try {
            $hd = DB::table('pur_purchaserequest_hd')->where('pur_purchaserequest_hd_id',$id)->first();
            $token = "7681986758:AAEB-BCtW1Yw-F30bMYeX-Hhlt36a9SIvgQ";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4779044927";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 เลขที่ PR" . $hd->pur_purchaserequest_hd_docuno  ."\n"
                . "🔹 ยกเลิก ". "\n"
                . "📅 วันที่บันทึก : " . Carbon::now()->format('d/m/y H:i') . "\n"
                . "👤 ผู้บันทึก : " . Auth::user()->name;    
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId); 
            DB::beginTransaction();
            $update_hd = DB::table('pur_purchaserequest_hd')
            ->where('pur_purchaserequest_hd_id', $id)
                ->update([
                    'pur_purchaserequest_status_id' => 2
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
    public function ReportPrOutstanding(Request $request)
    {
        $hd = DB::table('vw_prconvertpo')->where('pur_purchaserequest_total','>',0)->get();
        return view('report.form-purchase-proutstanding', compact('hd'));
    }
}
