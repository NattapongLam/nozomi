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
                <h3 class="card-title">การส่งสินค้าประจำวัน</h3>
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
        <div style="overflow-x:auto;">
           <table class="table">
            <tr>
                <th>Model/Product</th>
                @foreach ($groupedByDay as $Days => $dayItems)
                <th>{{ $Days }}</th>
            @endforeach
            </tr>
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
                                $dayTotal = $items->whereIn('date', collect($dayItems)->pluck('date'))
                                                     ->sum('qty');
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