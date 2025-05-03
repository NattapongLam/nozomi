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
        <h3 class="card-title">ทะเบียนเครื่องจักร</h3>
        <table id="tb_job" class="table table-bordered dt-responsive nowrap w-100 text-center">
            <thead>
                <tr>  
                    <th>กลุ่ม</th>     
                    <th>รหัสเครื่อง</th>  
                    <th>ชื่อเครื่อง</th>                        
                    <th>Serial</th>      
                    <th>วันที่หมดประกัน</th>        
                    <th>วันที่ตรวจเช็คครั้งต่อไป</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>       
                @foreach ($hd as $item)
                    <tr>
                        <td>{{$item->mtn_machinerygroup_name}}</td>
                        <td>{{$item->mtn_machinery_code}}</td>
                        <td>{{$item->mtn_machinery_name}}</td>                        
                        <td>{{$item->mtn_machinery_serial}}</td>
                        <td>{{$item->mtn_machinery_duedate}}</td>
                        <td>{{Carbon\Carbon::parse($item->mtn_machinery_datenow)->format('d/m/Y')}}</td>
                        <td>
                            <a href="{{route('mt-checklist.show',$item->mtn_machinery_id)}}" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></a>
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