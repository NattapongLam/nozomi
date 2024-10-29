<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hd = DB::table('users')->get();
        return view('employee.form-employee-list', compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = DB::table('emp_person')->where('flag',true)->get();
        return view('employee.form-employee-create', compact('hd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'empcode' => ['required'],
        ]);
        try{
            DB::beginTransaction();
            $emp = DB::table('emp_person')->where('emp_person_code',$request->empcode)->first();
            if($emp){
                $ck = DB::table('userslogin')->where('userslogin_name',$request->empcode)->first();
                if($ck){
                    $hd = DB::table('users')->insert([
                        'name' => $emp->emp_person_fullname,
                        'password' => Hash::make($ck->password_text),
                        'emp_person_code' => $request->empcode,
                        'username' => $request->empcode,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }else {
                    $hd = DB::table('users')->insert([
                        'name' => $emp->emp_person_fullname,
                        'password' => Hash::make('123456'),
                        'emp_person_code' => $request->empcode,
                        'username' => $request->empcode,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                DB::commit();
                return redirect()->route('profiles.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            }
        }catch(\Exception $e){
            Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
        }          
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emp = User::where('id',$id)->first();
        return view('profile',[
            'emp' => $emp,
        ]);
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
        $request->validate([
            'password_confirmation' => ['required'],
            'password' => ['required']
        ]);
        $data =[
            'password' => Hash::make($request->password),
        ];
        $emp = User::where('id',$id)->first();
        try {
            DB::beginTransaction();
            User::where('id', $id)->update($data);
            DB::commit();
            return redirect()->route('profiles.show',$emp->id)->with('success', 'แก้ไขข้อมูลสำเร็จ ' . Carbon::now());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            dd($e->getMessage()); 
            return redirect()->route('profiles.show',$emp->id)->with('error', 'แก้ไขข้อมูลไม่สำเร็จ ' . Carbon::now());
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
