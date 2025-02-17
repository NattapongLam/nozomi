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
    <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('mt-docpdt.update',$hd->mtn_maintenancedoc_id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
<div class="card">
    <div class="card-body">
        <h3 class="card-title">ใบแจ้งซ่อมเครื่องจักร สถานะ {{$hd->mtn_maintenancestatus_name}}</h3>
        <div class="row">
            <div class="col-3">
                วัน - เวลาที่แจ้ง : {{ \Carbon\Carbon::parse($hd->mtn_maintenancedoc_datetime)->format('d/m/Y H:i') }}
            </div>
            <div class="col-3">
                เลขที่ซ่อม : {{$hd->mtn_maintenancedoc_docuno }}
            </div>
            <div class="col-3">
                เลขที่เครื่องจักร : {{$hd->mtn_machinery_code }}
            </div>
            <div class="col-3">
                แผนก : {{$hd->emp_department_name }}
            </div>
            <div class="col-3">
                ตำแหน่งที่ตั้ง : {{$hd->mtn_maintenancedoc_location }}
            </div>
            <div class="col-3">
                ผู้แจ้งซ่อม : {{$hd->mtn_maintenancedoc_person }}
            </div>           
            <div class="col-12">
                รายละเอียดของปัญหา : {{$hd->mtn_maintenancedoc_remark }}
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">สำหรับผู้รับแจ้งซ่อม</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->mtn_maintenancedoc_jobperson)
                ผู้รับแจ้งซ่อม : {{$hd->mtn_maintenancedoc_jobperson}}  
                @else
                ผู้รับแจ้งซ่อม : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->mtn_maintenancedoc_jobdate)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenancestatus_id == 1)
                <button type="submit" class="btn btn-primary waves-effect waves-light">รับงาน</button>    
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
            <div class="col-3">
                @if($hd->mtn_maintenancedoc_check1)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="mtn_maintenancedoc_check1"> ซ่อมเสร็จใช้งานได้
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="mtn_maintenancedoc_check1"> ซ่อมเสร็จใช้งานได้
                @endif
            </div>
            <div class="col-3">
                @if($hd->mtn_maintenancedoc_check2)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="mtn_maintenancedoc_check2"> ขาดวัสดุอุปกรณ์/เครื่องมือ
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="mtn_maintenancedoc_check2"> ขาดวัสดุอุปกรณ์/เครื่องมือ
                @endif
            </div>
            <div class="col-3">
                @if($hd->mtn_maintenancedoc_check3)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="mtn_maintenancedoc_check3"> ส่งซ่อมภายนอก
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="mtn_maintenancedoc_check3"> ส่งซ่อมภายนอก
                @endif
            </div>
            <div class="col-3">
                @if($hd->mtn_maintenancedoc_check4)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="mtn_maintenancedoc_check4"> ซื้อทดแทนของเดิม
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="mtn_maintenancedoc_check4"> ซื้อทดแทนของเดิม
                @endif
            </div>
            <div class="col-3">
                @if($hd->mtn_maintenancedoc_check5)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked="" name="mtn_maintenancedoc_check5"> อื่นๆ(ระบุ)
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" name="mtn_maintenancedoc_check5"> อื่นๆ(ระบุ)
                @endif
            </div>
            <div class="col-9">
                <input type="text" class="form-control" value="{{$hd->mtn_maintenancedoc_other}}" name="mtn_maintenancedoc_other">
            </div>
            <div class="col-12">
                สาเหตุและแนวทางแก้ไข : <input type="text" class="form-control" value="{{$hd->mtn_maintenancedoc_jobremark}}" name="mtn_maintenancedoc_jobremark">
            </div>
            <div class="col-12">
                หมายเหตุ : <input type="text" class="form-control" value="{{$hd->mtn_maintenancedoc_jobnote}}" name="mtn_maintenancedoc_jobnote">
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenancestatus_id == 3)
                <button type="submit" class="btn btn-primary waves-effect waves-light">รับงาน</button>    
                @endif
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">หัวหน้าแผนกพิจารณา</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->mtn_maintenancedoc_jobresultperson)
                ผู้พิจารณา : {{$hd->mtn_maintenancedoc_jobresultperson}}  
                @else
                ผู้พิจารณา : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->mtn_maintenancedoc_jobresultdate)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenancestatus_id == 4)
                <button type="submit" class="btn btn-primary waves-effect waves-light">ตรวจสอบงาน</button>    
                @endif
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">ผู้แจ้งรับทราบ</h3>
        <div class="row">
            <div class="col-3">
                @if ($hd->mtn_maintenancedoc_jobapprovedperson)
                ผู้รับทราบ : {{$hd->mtn_maintenancedoc_jobapprovedperson}}  
                @else
                ผู้รับทราบ : {{auth()->user()->name}} 
                @endif
                
            </div>
            <div class="col-3">
                วันที่ : {{ \Carbon\Carbon::parse($hd->mtn_maintenancedoc_jobapproveddate)->format('d/m/Y') }}
            </div>
            <div class="col-3">
                @if ($hd->mtn_maintenancestatus_id == 5)
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