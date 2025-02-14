@extends('layouts.main')
@section('content')
<link href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
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
        <h3 class="card-title">รายงานการตรวจเช็คประจำเดือน  ( Monthly Maintenance Schedule )</h3>
        <form id="frm_sub" method="POST" class="form-horizontal" action="{{ route('mt-checklist.update',$hd->mtn_machinerycheck_hd_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="row">
            <div class="col-3">
                เดือน-ปี : {{$hd->ms_month_name}}-{{$hd->ms_year_name}}
            </div>
            <div class="col-3">
                หมายเลขเครื่อง : {{$hd->mtn_machinery_code}}
            </div>
            <div class="col-3">
                ชื่อเครื่องจักร : {{$hd->mtn_machinery_name}}
            </div>
            <div class="col-3">
                สถานที่ตั้ง : {{$hd->mtn_machinerycheck_hd_location}}
            </div>
            <div class="col-3">
                หน.ผลิต : {{$pdt}}
            </div>
            <div class="col-3">
                จนท.ซ่อมบำรุง : {{$job}}
            </div>
            <div class="col-3">
                หน.แผนก :  {{$app}}
            </div>
            <div class="col-3">
                หมายเหตุ : {{$hd->mtn_machinerycheck_hd_note}}
            </div>
            <div class="col-3">
                สัญลักษณ์:
            </div>
            <div class="col-3"></div>
            <div class="col-3"></div>
            <div class="col-3"></div>
            <div class="col-3">
                @if($hd->check_c)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> ทำความสะอาด
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> ทำความสะอาด
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_t)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> เติมน้ำมันหล่อสื่น
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> เติมน้ำมันหล่อสื่น
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_l)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> เปลี่ยนน้ำมันหล่อลื่น
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> เปลี่ยนน้ำมันหล่อลื่น
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_i)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> ตรวจเช็ค
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> ตรวจเช็ค
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_a)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> ปรับแต่ง
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> ปรับแต่ง
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_r)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> ซ่อมแซม
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> ซ่อมแซม
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_p)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> เปลี่ยน
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> เปลี่ยน
                @endif
            </div>
            <div class="col-3">
                @if($hd->check_o)
                <input class="form-check-input" type="checkbox" id="formCheckcolor3" checked=""> ซ่อมใหญ่
                @else
                <input class="form-check-input" type="checkbox" id="formCheckcolor3"> ซ่อมใหญ่
                @endif
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
            <div style="overflow-x:auto;">
            <table class="table table-bordered text-center" id="tb_job">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ตำแหน่งการตรวจสอบ</th>
                        <th>วิธีการตรวจสอบ</th>
                        <th>01</th>
                        <th>02</th>
                        <th>03</th>
                        <th>04</th>
                        <th>05</th>
                        <th>06</th>
                        <th>07</th>
                        <th>08</th>
                        <th>09</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                        <th>13</th>
                        <th>14</th>
                        <th>15</th>
                        <th>16</th>
                        <th>17</th>
                        <th>18</th>
                        <th>19</th>
                        <th>20</th>
                        <th>21</th>
                        <th>22</th>
                        <th>23</th>
                        <th>24</th>
                        <th>25</th>
                        <th>26</th>
                        <th>27</th>
                        <th>28</th>
                        <th>29</th>
                        <th>30</th>
                        <th>31</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dt as $item)
                        <tr>
                            <td>
                                <label class="col-form-label" style="width: 10px">
                                    {{$item->mtn_machinerycheck_dt_listno}}
                                </label>
                                <input type="hidden" value="{{$item->mtn_machinerycheck_dt_id}}" name="dt_id[]">                               
                            </td>
                            <td>
                                <label class="col-form-label" style="width: 200px">
                                {{$item->loclcheck}}
                                </label>
                            </td>
                            <td>
                                <label class="col-form-label" style="width: 200px">
                                {{$item->listcheck}}
                                </label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action01[]" style="width: 40px">
                                        @if($item->c01 == true)
                                        <option value="{{$item->c01}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c01}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action02[]" style="width: 40px">
                                        @if($item->c02 == true)
                                        <option value="{{$item->c02}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c02}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action03[]" style="width: 40px">
                                        @if($item->c03 == true)
                                        <option value="{{$item->c03}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c03}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action04[]" style="width: 40px">
                                        @if($item->c04 == true)
                                        <option value="{{$item->c04}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c04}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action05[]" style="width: 40px">
                                        @if($item->c05 == true)
                                        <option value="{{$item->c05}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c05}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action06[]" style="width: 40px">
                                        @if($item->c06 == true)
                                        <option value="{{$item->c06}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c06}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action07[]" style="width: 40px">
                                        @if($item->c07 == true)
                                        <option value="{{$item->c07}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c07}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action08[]" style="width: 40px">
                                        @if($item->c08 == true)
                                        <option value="{{$item->c08}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c08}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action09[]" style="width: 40px">
                                        @if($item->c09 == true)
                                        <option value="{{$item->c09}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c09}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action10[]" style="width: 40px">
                                        @if($item->c10 == true)
                                        <option value="{{$item->c10}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c10}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action11[]" style="width: 40px">
                                        @if($item->c11 == true)
                                        <option value="{{$item->c11}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c11}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action12[]" style="width: 40px">
                                        @if($item->c12 == true)
                                        <option value="{{$item->c12}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c12}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action13[]" style="width: 40px">
                                        @if($item->c13 == true)
                                        <option value="{{$item->c13}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c13}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action14[]" style="width: 40px">
                                        @if($item->c14 == true)
                                        <option value="{{$item->c14}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c14}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action15[]" style="width: 40px">
                                        @if($item->c15 == true)
                                        <option value="{{$item->c15}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c15}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action16[]" style="width: 40px">
                                        @if($item->c16 == true)
                                        <option value="{{$item->c16}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c16}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action17[]" style="width: 40px">
                                        @if($item->c17 == true)
                                        <option value="{{$item->c17}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c17}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action18[]" style="width: 40px">
                                        @if($item->c18 == true)
                                        <option value="{{$item->c18}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c18}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action19[]" style="width: 40px">
                                        @if($item->c19 == true)
                                        <option value="{{$item->c19}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c19}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action20[]" style="width: 40px">
                                        @if($item->c20 == true)
                                        <option value="{{$item->c20}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c20}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action21[]" style="width: 40px">
                                        @if($item->c21 == true)
                                        <option value="{{$item->c21}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c21}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action22[]" style="width: 40px">
                                        @if($item->c22 == true)
                                        <option value="{{$item->c22}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c22}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action23[]" style="width: 40px">
                                        @if($item->c23 == true)
                                        <option value="{{$item->c23}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c23}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action24[]" style="width: 40px">
                                        @if($item->c24 == true)
                                        <option value="{{$item->c24}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c24}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>                        
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action25[]" style="width: 40px">
                                        @if($item->c25 == true)
                                        <option value="{{$item->c25}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c25}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action26[]" style="width: 40px">
                                        @if($item->c26 == true)
                                        <option value="{{$item->c26}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c26}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action27[]" style="width: 40px">
                                        @if($item->c27 == true)
                                        <option value="{{$item->c27}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c27}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action28[]" style="width: 40px">
                                        @if($item->c28 == true)
                                        <option value="{{$item->c28}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c28}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action29[]" style="width: 40px">
                                        @if($item->c29 == true)
                                        <option value="{{$item->c29}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c29}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action30[]" style="width: 40px">
                                        @if($item->c30 == true)
                                        <option value="{{$item->c30}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c30}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="action31[]" style="width: 40px">
                                        @if($item->c31 == true)
                                        <option value="{{$item->c31}}">/</option>
                                        <option value="0">X</option>
                                        @else
                                        <option value="{{$item->c31}}">X</option>
                                        <option value="1">/</option>
                                        @endif   
                                    </select>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary waves-effect waves-light">บันทึกข้อมูล</button>    
        </div>
        </form>
    </div>
</div>
</div>
@endsection
@push('scriptjs')
<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
<script>
$(document).ready(function() {
    $('#tb_job').DataTable({
        autoWidth: false,
        pageLength: 50,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel'
        ],
        order: [[1, "asc"]],
        scrollX: true,
        scrollCollapse: true,
        paging: true,
        fixedColumns: {
            leftColumns: 3
        },
        columns: [
            { width: "10px" }, 
            { width: "200px" }, 
            { width: "200px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
            { width: "40px" }, 
        ]
    });
});
</script>
@endpush