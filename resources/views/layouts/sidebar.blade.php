<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">จัดซื้อ</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" key="t-vertical">อนุมัติเอกสารขอสั่งซื้อ</a>
                            <ul class="sub-menu" aria-expanded="true">
                                {{-- <li><a href="{{ url('/pr-approved1') }}" key="t-default">หัวหน้างาน</a></li>   --}}
                                <li><a href="{{ url('/pr-approved2') }}" key="t-default">ผู้ตรวจสอบ</a></li> 
                                <li><a href="{{ url('/pr-approved3') }}" key="t-default">ผู้อนุมัติ</a></li> 
                            </ul>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" key="t-vertical">อนุมัติเอกสารสั่งซื้อ</a>
                            <ul class="sub-menu" aria-expanded="true">
                                {{-- <li><a href="{{ url('/po-approved1') }}" key="t-default">ท่านที่ 1</a></li>   --}}
                                <li><a href="{{ url('/po-approved2') }}" key="t-default">ผู้ตรวจสอบ</a></li> 
                                <li><a href="{{ url('/po-approved3') }}" key="t-default">ผู้อนุมัติ</a></li> 
                            </ul>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" key="t-vertical">อนุมัติค่าใช้จ่ายอื่นๆ</a>
                            <ul class="sub-menu" aria-expanded="true">
                                {{-- <li><a href="{{ url('/ase-approved1') }}" key="t-default">ท่านที่ 1</a></li>   --}}
                                <li><a href="{{ url('/ase-approved2') }}" key="t-default">ผู้ตรวจสอบ</a></li> 
                                <li><a href="{{ url('/ase-approved3') }}" key="t-default">ผู้อนุมัติ</a></li> 
                            </ul>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow" key="t-vertical">อนุมัติปิดเอกสารสั่งซื้อ</a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="{{ url('/po-approvedclose1') }}" key="t-default">ผู้ตรวจสอบ</a></li> 
                                <li><a href="{{ url('/po-approvedclose2') }}" key="t-default">ผู้อนุมัติ</a></li> 
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">คลังวัตถุดิบ</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('wh-issue.index')}}" key="t-vertical">อนุมัติการเบิกสินค้า</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('wh-adjust.index')}}" key="t-vertical">อนุมัติปรับปรุงสินค้า</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-layouts">ซ่อมบำรุง</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('mt-checklist.index')}}" key="t-vertical">ตรวจเช็คประจำเดือน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('mt-docpdt.index')}}" key="t-vertical">แจ้งซ่อมเครื่องจักร</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('mt-docoff.index')}}" key="t-vertical">แจ้งซ่อมบำรุง</a>
                        </li>
                    </ul>
                </li>
                <li class="menu-title" key="t-apps">Report</li>   
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานผลิต (โรง 1)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{ url('/report-planningdl') }}">
                                <i class="bx bx-calendar"></i>
                                <span key="t-users">แผนรวม</span>
                            </a>
                            </li> 
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpd')}}" key="t-vertical">เป้าผลิตประจำวัน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpdday')}}" key="t-vertical">ผลผลิตประจำวัน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpdmonth')}}" key="t-vertical">ผลผลิตประจำเดือน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpdyear')}}" key="t-vertical">ผลผลิตประจำปี</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-qcday')}}" key="t-vertical">ตรวจผลผลิตประจำวัน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-qclossday')}}" key="t-vertical">ของเสียประจำวัน</a>
                        </li>
                    </ul>
                </li>   
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานผลิต (โรง 2)</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{ url('/report-planningdl2') }}">
                                <i class="bx bx-calendar"></i>
                                <span key="t-users">แผนรวม</span>
                            </a>
                            </li> 
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpd2')}}" key="t-vertical">เป้าผลิตประจำวัน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpdday2')}}" key="t-vertical">ผลผลิตประจำวัน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpdmonth2')}}" key="t-vertical">ผลผลิตประจำเดือน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-planningpdyear2')}}" key="t-vertical">ผลผลิตประจำปี</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-qcday2')}}" key="t-vertical">ตรวจผลผลิตประจำวัน</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-qclossday2')}}" key="t-vertical">ของเสียประจำวัน</a>
                        </li>
                    </ul>
                </li>   
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานจัดซื้อ</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-proutstanding')}}" key="t-vertical">PR คงค้าง</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-pooutstanding')}}" key="t-vertical">PO คงค้าง</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-purchaseorder')}}" key="t-vertical">ภาพรวมการสั่งซื้อ</a>
                        </li>
                    </ul>
                </li>   
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานคลังสินค้า</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-deliveryday')}}" key="t-vertical">การจัดส่ง</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-receiveday')}}" key="t-vertical">การรับเข้า</a>                           
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{url('/report-warehouse')}}" key="t-vertical">การเบิก</a>                           
                        </li>
                    </ul>
                </li>       
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-calendar"></i>
                        <span key="t-layouts">รายงานซ่อมบำรุง</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('mt-checklist.create')}}" key="t-vertical">ทะเบียนเครื่องจักร</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="true">
                        <li>
                            <a href="{{route('mt-docoff.create')}}" key="t-vertical">รายงานการซ่อม</a>                           
                        </li>
                    </ul>
                </li>                                         
                <li class="menu-title" key="t-pages">Setting</li>   
                <li>
                    <a href="{{route('profiles.index')}}">
                        <i class="bx bx-user"></i>
                        <span key="t-users">ผู้ใช้งาน</span>
                    </a>
                </li>                    
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>