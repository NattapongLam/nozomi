
<!doctype html>
<html lang="en">
    <head>      
        <meta charset="utf-8" />
        <title>@yield('title','NOZOMI')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="{{URL::asset('assets/images/favicon.ico')}}">
        <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />   
    </head>
<body data-sidebar="dark" data-layout-mode="light">
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <h5>รหัสเครื่อง : {{$hd->mtn_machinery_code}}</h5>
                                </div>
                                <div class="col-6">
                                    <h5>ชื่อเครื่อง : {{$hd->mtn_machinery_name}}</h5>
                                </div>
                                <div class="col-6">
                                    <h5>Serial : {{$hd->mtn_machinery_serial}}</h5>
                                </div>
                                <div class="col-6">
                                    <h5>วันที่ซื้อ : {{$hd->mtn_machinery_date}}</h5>
                                </div>
                                <div class="col-6">
                                    <h5>วันที่ตรวจเช็คล่าสุด : {{$hd->mtn_machinery_dateold}}</h5>
                                </div>
                                <div class="col-6">
                                    <h5>วันที่ตรวจเช็คครั้งต่อไป : {{$hd->mtn_machinery_datenow}}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <h5>ประวัติการซ่อม</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>สถานะ</th>
                                            <th>วัน - เวลา</th>
                                            <th>เลขที่</th>
                                            <th>แผนก</th>
                                            <th>รายละเอียดปัญหา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dt as $item)
                                            <tr>
                                                <td>{{$item->mtn_maintenancestatus_name}}</td>
                                                <td>{{$item->mtn_maintenancedoc_datetime}}</td>
                                                <td>{{$item->mtn_maintenancedoc_docuno}}</td>
                                                <td>{{$item->emp_department_name}}</td>
                                                <td>{{$item->mtn_maintenancedoc_remark}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="rightbar-overlay"></div>       
        <!-- JAVASCRIPT -->
        <script src="{{URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/app.js')}}"></script>
        <script src="{{URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/jszip/jszip.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/pages/datatables.init.js')}}"></script>      
        <script>
        </script>
    </body>
</html>

