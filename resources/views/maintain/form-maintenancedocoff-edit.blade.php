@extends('layouts.main')
@section('content')
<div class="row">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="mdi mdi-check-all me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('mt-docoff.update',$hd->mtn_maintenanceoffdoc_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
<div class="card">
    <div class="card-body">
        <h3 class="card-title">ใบแจ้งซ่อมบำรุงภายใน สถานะ {{$hd->mtn_maintenanceoffstatus_name}}</h3>
        <div class="row">
            <div class="col-3">
                วัน - เวลา : {{ \Carbon\Carbon::parse($hd->mtn_maintenanceoffdoc_datetime)->format('d/m/Y H:i') }}
            </div>
            <div class="col-3">
                เลขที่ : {{ $hd->mtn_maintenanceoffdoc_docuno }}
            </div>
            <div class="col-6">
                อุปกรณ์ที่ชำรุด : {{ $hd->mtn_maintenanceoffdoc_name }}
            </div>
            <div class="col-3">
                แผนก :{{ $hd->emp_department_name }}
            </div>
            <div class="col-3">
                ตำแหน่งที่ตั้ง : {{ $hd->mtn_maintenanceoffdoc_location }}
            </div>
            <div class="col-6">
                อาการที่เสีย : {{ $hd->mtn_maintenanceoffdoc_case }}
            </div>
            <div class="col-12">สาเหตุ</div>
            <div class="col-2">
                @if($hd->ck_cause1)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_cause1"> ชำรุดใช้งานไม่ได้
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_cause1"> ชำรุดใช้งานไม่ได้
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_cause2)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_cause2"> บำรุงรักษา
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_cause2"> บำรุงรักษา
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_cause3)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_cause3"> แก้ไขเพิ่มเติม
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_cause3"> แก้ไขเพิ่มเติม
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_cause4)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_cause4"> เพื่อความปลอดภัย
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_cause4"> เพื่อความปลอดภัย
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_cause5)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_cause5"> อื่นๆ (ระบุ)
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_cause5"> อื่นๆ (ระบุ)
                @endif
            </div>
            <div class="col-2">
                {{$hd->remaek_cause}}
            </div>
            <div class="col-12">ระดับความต้องการ</div>
            <div class="col-2">
                @if($hd->ck_need1)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_need1"> เร่งด่วน
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_need1"> เร่งด่วน
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_need2)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_need2"> ฉุกเฉิน
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_need2"> ฉุกเฉิน
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_need3)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_need3"> ธรรมดา
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_need3"> ธรรมดา
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_need4)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_need4"> รอได้
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_need4"> รอได้
                @endif
            </div>
            <div class="col-12">ประเภทอุปกรณ์</div>
            <div class="col-2">
                @if($hd->ck_type1)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_type1"> ประปา
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_type1"> ประปา
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_type2)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_type2"> ไฟฟ้า
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_type2"> ไฟฟ้า
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_type3)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_type3"> เบ็ตเตล็ดทั่วไป
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_type3"> เบ็ตเตล็ดทั่วไป
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_type4)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_type4"> ระบบ SAFETY
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_type4"> ระบบ SAFETY
                @endif
            </div>
            <div class="col-2">
                @if($hd->ck_type5)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_type5"> อื่นๆ (ระบุ)
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_type5"> อื่นๆ (ระบุ)
                @endif
            </div>
            <div class="col-2">
                {{$hd->remark_type}}
            </div>
            <div class="col-3">
                ผู้แจ้ง : {{$hd->emp_person_fullname}}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">สำหรับผู้รับแจ้งซ่อม</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->jobperson_at)
                ผู้รับแจ้งซ่อม : {{$hd->jobperson_at}}  
                @else
                ผู้รับแจ้งซ่อม : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->jobperson_date)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenanceoffstatus_id == 1)
                <button type="submit" class="btn btn-primary waves-effect waves-light">รับงาน</button>    
                @endif
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">สำหรับผู้อนุมัติซ่อม</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->approved_jobsave)
                ผู้อนุมัติซ่อม : {{$hd->approved_jobsave}}  
                @else
                ผู้อนุมัติซ่อม : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->approved_jobdate)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenanceoffstatus_id == 3)
                <button type="submit" class="btn btn-primary waves-effect waves-light">อนุมัติ</button>    
                @endif
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title"> สรุปผลรายงาน</h3>
        <div class="row">
            <div class="col-12">
                สาเหตุและแนวทางแก้ไข : <input type="text" class="form-control" value="{{$hd->mtn_maintenanceoffdoc_result}}" name="mtn_maintenanceoffdoc_result">
            </div>
            <div class="col-3">
                @if($hd->ck_result1)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_result1"> ซ่อมเสร็จใช้งานได้
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_result1"> ซ่อมเสร็จใช้งานได้
                @endif
            </div>
            <div class="col-3">
                @if($hd->ck_result2)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_result2"> ขาดวัสดุ/อุปกรณ์เครื่องมือ
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_result2"> ขาดวัสดุ/อุปกรณ์เครื่องมือ
                @endif
            </div>
            <div class="col-3">
                @if($hd->ck_result3)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_result3"> ส่งซ่อมภายนอก
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_result3"> ส่งซ่อมภายนอก
                @endif
            </div>
            <div class="col-3">
                @if($hd->ck_result4)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_result4"> ซื้อทดแทนของเดิม
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_result4"> ซื้อทดแทนของเดิม
                @endif
            </div>
            <div class="col-3">
                @if($hd->ck_result5)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="ck_result5"> อื่นๆ (ระบุ)
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="ck_result5"> อื่นๆ (ระบุ)
                @endif
            </div>
            <div class="col-9">
                <input type="text" class="form-control" value="{{$hd->remark_result}}" name="remark_result">
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenanceoffstatus_id == 7)
                <button type="submit" class="btn btn-primary waves-effect waves-light">บันทึก</button>    
                @endif
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">สำหรับผู้อนุมัติ</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->approved_at)
                ผู้อนุมัติ : {{$hd->approved_at}}  
                @else
                ผู้อนุมัติ : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->approved_date)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenanceoffstatus_id == 4)
                <button type="submit" class="btn btn-primary waves-effect waves-light">อนุมัติ</button>    
                @endif
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">สำหรับผู้แจ้งรับทราบ</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->recheck_at)
                ผู้แจ้งรับทราบ : {{$hd->recheck_at}}  
                @else
                ผู้แจ้งรับทราบ : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->recheck_date)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenanceoffstatus_id == 5)
                <button type="submit" class="btn btn-primary waves-effect waves-light">รับทราบ</button>    
                @endif
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
</form>
</div>
@endsection
@push('scriptjs')
<script>
</script>
@endpush