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
                <h3 class="card-title">รายงานการรับเข้า</h3>
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
        <hr>
        <div style="overflow-x:auto;">
            <h3 class="card-title text-center">รับเข้าสินค้าจากการผลิต</h3>
            <table id="tb_job1" class="table table-bordered">
            <thead>
                <tr>
                    <th>Model/Product</th>
                    @foreach ($groupedByDay as $Days => $dayItems)
                    <th>{{ $Days }}</th>
                @endforeach
                </tr>
            </thead>          
            <tbody>
                @php
                    $totalAmount = 0;
                    $groupedMpd = $hd->groupBy('mpd');
                @endphp
        
                @foreach ($groupedMpd as $MpdName => $items)
                    <tr>
                        <td>{{ $MpdName }}</td>
                        @foreach ($groupedByDay as $Days => $dayItems)
                            @php
                                $dayTotal = $items->whereIn('fg_receiveproduct_hd_date', collect($dayItems)->pluck('fg_receiveproduct_hd_date'))
                                                     ->sum('fg_receiveproduct_dt_qty');
                            @endphp
                            <td>{{ number_format($dayTotal, 2) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
           </table>
        </div>
        <div style="overflow-x:auto;">
            <h3 class="card-title text-center">รับเข้า PU</h3>
            <table id="tb_job2" class="table table-bordered">
            <thead>
                <tr>
                    <th>Code</th>
                    @foreach ($groupedByDay1 as $Days => $dayItems)
                    <th>{{ $Days }}</th>
                @endforeach
                </tr>
            </thead>          
            <tbody>
                @php
                    $totalAmount = 0;
                    $groupedMpd = $hd1->groupBy('productcode');
                @endphp
        
                @foreach ($groupedMpd as $MpdName => $items)
                    <tr>
                        <td>{{ $MpdName }}</td>
                        @foreach ($groupedByDay1 as $Days => $dayItems)
                            @php
                                $dayTotal = $items->whereIn('wh_receivepu_hd_date', collect($dayItems)->pluck('wh_receivepu_hd_date'))
                                                     ->sum('wh_receivepu_dt_qty');
                            @endphp
                            <td>{{ number_format($dayTotal, 2) }}</td>
                        @endforeach
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
    $('#tb_job1').DataTable({
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
$(document).ready(function() {
    $('#tb_job2').DataTable({
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