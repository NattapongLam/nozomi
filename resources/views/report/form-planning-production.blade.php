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
        <h4 class="card-title">เป้าผลิตประจำวัน</h4>   
        <form method="GET" class="form-horizontal">
            @csrf
        <div class="row">          
            <div class="col-12 col-md-3">
                <input type="date" class="form-control" name="datestart" id="datestart" value="{{$datestart}}">
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>
        </div>
        </form>
        <br>
        <div style="overflow-x:auto;">
            <table id="tb_job" class="table table-bordered nowrap w-100 text-center">
                <thead>
                    <tr>
                        <th>Line</th>
                        <th>Process</th>
                        <th>Person</th>
                        <th>Target</th>
                        <th>Day</th>
                        <th>OT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hd as $item)
                        <tr>
                            <td>{{$item->pdt_productresult_hd_line}}</td>
                            <td>{{$item->pdt_process_dt_name}}</td>
                            <td>{{$item->emp_person_fullname}}</td>
                            <td>{{number_format($item->emp_person_target,0)}}</td>
                            @if ($item->qty < $item->emp_person_target)
                                <td style="color: red">
                                    {{number_format($item->qty,0)}}
                                </td>
                            @else
                                <td>
                                    {{number_format($item->qty,0)}}
                                </td>
                            @endif
                            
                            <td>{{number_format($item->qtyot,0)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        "pageLength": 20,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
    ],
    "order": [[ 0, "asc" ]],        
    })
});
</script>
@endpush