<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhIssueStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = DB::table('wh_issuestock_hd')
        ->leftjoin('wh_issuetype','wh_issuestock_hd.wh_issuetype_id','=','wh_issuetype.wh_issuetype_id')
        ->where('wh_issuestock_status_id',1)
        ->get();
        return view('whisssuestock.form-whissuestock-app', compact('hd'));
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
        $hd = DB::table('wh_issuestock_hd')
        ->leftjoin('wh_issuetype','wh_issuestock_hd.wh_issuetype_id','=','wh_issuetype.wh_issuetype_id')
        ->where('wh_issuestock_hd.wh_issuestock_hd_id',$id)
        ->first();
        $dt = DB::table('wh_issuestock_dt')->where('wh_issuestock_hd_id',$id)
        ->where('flag',true)
        ->get();
        $sta = DB::table('wh_issuestock_status')
        ->get();
        return view('whisssuestock.form-whissuestock-edit', compact('hd','dt','sta'));
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
        $ck = DB::table('wh_issuestock_hd')->where('wh_issuestock_hd_id',$id)->first();
        try{
            DB::beginTransaction();
            $up = DB::table('wh_issuestock_hd')
            ->where('wh_issuestock_hd_id',$id)
            ->update([
                'approved_date' => Carbon::now(),
                'approved_code' => Auth::user()->emp_person_code,
                'approved_save' => Auth::user()->name,
                'approved_remark' => $request->approved_remark,
                'wh_issuestock_status_id' => $request->approved_status
            ]);
            if($request->approved_status == 5){
                $dt = DB::table('wh_issuestock_dt')
                ->where('flag',true)
                ->where('wh_issuestock_hd_id',$id)
                ->get();
                foreach ($dt as $key => $value) {
                   $stc = DB::table('stc_stockcard')
                   ->insert([
                    'stc_stockcard_docuno' => $ck->wh_issuestock_hd_docuno,
                    'stc_stockcard_date' => $ck->wh_issuestock_hd_date,
                    'stc_stockcard_product' => $value->productcode,
                    'stc_stockcard_qty' => $value->wh_issuestock_dt_qty,
                    'stockflag' => -1,
                    'wh_warehouse_code' => $ck->wh_warehouse_code,
                    'multipleunit_rate' => $value->multipleunit_rate,
                    'multipleunit_name' =>  $value->productunit,
                    'create_at' => $ck->create_at,
                    'person_at' => $ck->person_at,
                    'stc_stockcard_model' => $value->productcode,
                   ]);
                }
            }
            DB::commit();
            $hd = DB::table('wh_issuestock_hd')
            ->leftjoin('wh_issuestock_status','wh_issuestock_hd.wh_issuestock_status_id','=','wh_issuestock_status.wh_issuestock_status_id')
            ->where('wh_issuestock_hd.wh_issuestock_hd_id',$id)
            ->first();
            // define('LINE_API', "https://notify-api.line.me/api/notify");
            // $token = "lRCvoL28V8jKeggZvPBEYP0qISUZgrRdOkJybKAzAGB";
            // $params = array(
            // "message"        => "เลขที่ใบเบิก : " . $hd->wh_issuestock_hd_docuno ."\n"
            // . "วันที่ดำเนินการ : " . Carbon::now()->format('d/m/y h:i') ."\n"
            // . "ผู้ดำเนินการ : " . Auth::user()->name ."\n"
            // . "หมายเหตุ : " . $request->approved_remark ."\n"
            // . "สถานะ : " . $hd->wh_issuestock_status_name ."\n", //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
            // "stickerPkg"     => 8522, //stickerPackageId
            // "stickerId"      => 16581281, //stickerId
            // // "imageThumbnail" => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", // max size 240x240px JPEG
            // // "imageFullsize"  => "https://c1.staticflickr.com/9/8220/8292155879_bd917986b4_m.jpg", //max size 1024x1024px JPEG
            // );
            // $res = $this->notify_message($params, $token);
            return redirect()->route('dashboard')->with('success', 'บันทึกข้อมูลเรียบร้อย');      
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
    public function ReportWarehouse(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-2 month", strtotime($dateend)));
        $hd = DB::table('vw_whissuestock_report')
        ->whereBetween('wh_issuestock_hd_date', [$datestart, $dateend])
        ->get();
        $groupedByMonthYear = $hd->groupBy(function($item) {
            return Carbon::parse($item->wh_issuestock_hd_date)->format('Y-m');
        })->toArray();
        return view('report.form-warehouse-report', compact('hd','dateend','datestart','groupedByMonthYear'));
    }
}
