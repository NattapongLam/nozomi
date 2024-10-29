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
    <h4 class="card-title">ผลผลิตประจำเดือน</h4>    
    <form method="GET" class="form-horizontal">
    @csrf
    <div class="row">      
    <div class="col-12 col-md-3">
        <div class="mb-3 row">
            <label for="years" class="col-md-3 col-form-label">ปี</label>
            <div class="col-md-9">
                <select class="form-control" name="years" id="years">
                    <option value="">ระบุปี</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="mb-3 row">
            <label for="months" class="col-md-3 col-form-label">เดือน</label>
            <div class="col-md-9">
                <select class="form-control" name="months" id="months">
                    <option value="">ระบุเดือน</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>
        </div>
        </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-info w-lg">
                    <i class="fas fa-search"></i> ค้นหา
                </button>
            </div>
        </div>
        </form>
        <br>
        <div class="row">
            <h3 class="card-title text-center">Line : L1  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL1 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd1->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL1 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL1 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div> 
        <div class="row">
            <h3 class="card-title text-center">Line : L2  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL2 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd2->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL2 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL2 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <h3 class="card-title text-center">Line : L3  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL3 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd3->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL3 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL3 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div> 
        <div class="row">
            <h3 class="card-title text-center">Line : L4  เดือน : {{$year}}/{{$month}}</h3>    
            <div style="overflow-x:auto;">
                <table class="table table-bordered nowrap w-100 text-center">
                    <thead>
                        <tr>
                            <th>Model/Product</th>
                            @foreach ($groupedByL4 as $line => $items)
                            <th>{{$line}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $columnTotals = [];
                        @endphp
                        @foreach ($hd4->groupBy('mpd') as $productName => $itemsByProduct)
                        <tr>
                            <td>{{$productName}}</td>
                            @php
                                $rowTotal = 0; 
                            @endphp
                            @foreach ($groupedByL4 as $line => $items) 
                                @php
                                    $purchase = $itemsByProduct->firstWhere('jobtype', $line);
                                    $amount = $purchase ? $purchase->total : 0;
                                    $rowTotal += $amount;
                                    if (!isset($columnTotals[$line])) {
                                        $columnTotals[$line] = 0; 
                                    }
                                        $columnTotals[$line] += $amount;
                                @endphp
                            <td>{{ number_format($amount, 2) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            @foreach ($groupedByL4 as $line => $items)
                                <td>{{ number_format($columnTotals[$line] ?? 0, 2) }}</td> 
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>                                   
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
</script>
@endpush