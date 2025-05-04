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
                <h3 class="card-title">ของเสียประจำวัน</h3>
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
                    <th>วันที่</th>     
                    <th>Line</th>     
                    <th>ปัญหา</th>                                       
                    <th>ผู้ตรวจ</th> 
                    <th>จำนวน</th>        
                </tr>
            </thead>
            <tbody>       
                  @foreach ($hd as $item)
                      <tr>
                        <td>
                            {{ Carbon\Carbon::parse($item->date)->format('d/m/Y')}}
                        </td>
                        <td>{{$item->line}}</td>
                        <td>{{$item->ms_problem_name}}</td>                        
                        <td>
                            {{$item->pdt_productqc_hd_save}}
                        </td>
                        <td>
                            ปกติ : {{$item->pdt_productqc_note_qty}} / OT : {{$item->pdt_productqc_note_qtyot}}
                        </td>                       
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