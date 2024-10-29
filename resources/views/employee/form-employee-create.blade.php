@extends('layouts.main')
@section('content')
<link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
<div class="card">
    <div class="card-body">
        <h4 class="card-title">ผู้ใช้งาน</h4>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('profiles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12">
                <label class="form-label" >พนักงาน</label>
                <select class="select2 form-control" name="empcode" id="empcode" required autofocus>
                    <option>กรุณาเลือก</option>
                    @foreach ($hd as $item)
                        <option value="{{$item->emp_person_code}}">{{$item->emp_person_code}}/{{$item->emp_person_fullname}}</option>
                    @endforeach
                </select>
            </div>            
        </div><br>
        <div class="row">
            <div class="col-12 col-md-12">
                <button class="btn btn-primary waves-effect waves-light" type="submit" >บันทึก</button>
            </div>
        </div> 
        </form>
</div>
</div>
@endsection
@push('scriptjs')
<script src="{{ asset('/assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/form-advanced.init.js') }}"></script>
<script>
</script>
@endpush