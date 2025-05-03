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
<div class="card">
    <div class="card-body">      
        <form method="GET" class="form-horizontal">
            @csrf
        <div class="row">           
            <div class="col-12 col-md-3">
                <h3 class="card-title">รายงานการซ่อม</h3>
            </div>
            <div class="col-12 col-md-3">
                วันที่ :<input type="date" class="form-control" id="datestart" name="datestart" value="{{ $datestart }}">
            </div>
            <div class="col-12 col-md-3">
                ถึงวันที่ : <input type="date" class="form-control" id="dateend" name="dateend" value="{{ $dateend }}">
            </div>
            <div class="col-12 col-md-3">
                <p></p>
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>          
        </div>
        </form>
        <br>    
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>  
                    <th>สถานะ</th>     
                    <th>ประเภท</th>  
                    <th>วัน - เวลา</th>                        
                    <th>เครื่องจักร</th>      
                    <th>แผนก</th>        
                    <th>สถานที่</th>
                    <th>ผู้แจ้ง</th>
                    <th>ปัญหา</th>
                    <th>ผู้ดำเนินการ</th>
                    <th>รายละเอียด</th>
                </tr>
            </thead>
            <tbody>       
                  @foreach ($hd as $item)
                      <tr>
                        <td>{{$item->mtn_maintenancestatus_name}}</td>
                        <td>{{$item->mtn_maintenancedoc_type}}</td>
                        <td>{{ Carbon\Carbon::parse($item->mtn_maintenancedoc_datetime)->format('d/m/Y H:i')}}</td>
                        <td>{{$item->mtn_machinery_name}}</td>
                        <td>{{$item->emp_department_name}}</td>
                        <td>{{$item->mtn_maintenancedoc_location}}</td>
                        <td>{{$item->mtn_maintenancedoc_person}}</td>
                        <td>{{$item->mtn_maintenancedoc_remark}}</td>
                        <td>{{$item->mtn_maintenancedoc_jobresultperson}}</td>                      
                        <td>{{$item->mtn_maintenancedoc_jobremark}} ({{Carbon\Carbon::parse($item->mtn_maintenancedoc_jobresultdate)->format('d/m/Y')}})</td>
                      </tr>
                  @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 10,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    })
});
</script>
@endpush