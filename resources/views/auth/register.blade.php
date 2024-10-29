<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Register | Nozomi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{URL::asset('assets/images/favicon.ico')}}">

        <!-- Bootstrap Css -->
        <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{URL::asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>
        
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">สมัครสมาชิก</h5>
                                            <img src="{{URL::asset('assets/images/nozomi.png')}}" alt=""  height="40">
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                {{-- <div>
                                    <a href="index.html">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{URL::asset('assets/images/nozomi.png')}}" alt=""  height="40">
                                            </span>
                                        </div>
                                    </a>
                                </div> --}}
                                <div class="p-2">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf   
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">อีเมล</label>
                                            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
                                            <div class="invalid-feedback">
                                               กรุณาระบุข้อมูล
                                            </div>      
                                        </div>       
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">รหัสผ่าน</label>
                                            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                                            <div class="invalid-feedback">
                                                กรุณาระบุข้อมูล
                                            </div>       
                                        </div>
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">ยืนยันรหัสผ่าน</label>
                                            <input id="password_confirmation" class="form-control"type="password"name="password_confirmation" required />
                                            <div class="invalid-feedback">
                                                กรุณาระบุข้อมูล
                                            </div>       
                                        </div>                                                      
                                        <div class="mb-3">
                                            <label for="username" class="form-label">ชื่อ - นามสกุล</label>
                                            <input id="name" class="form-control" type="text" name="name" :value="old('name')" required />
                                            <div class="invalid-feedback">
                                                กรุณาระบุข้อมูล
                                            </div>  
                                        </div>                    
                                        <div class="mt-4 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">สมัคร</button>
                                        </div>           
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            
                            <div>
                                <p>Already have an account ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Login</a> </p>
                                <p>© <script>document.write(new Date().getFullYear())</script>By<i class="mdi mdi-heart text-danger"></i> YASAKI</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>

        <!-- validation init -->
        <script src="{{URL::asset('assets/js/pages/validation.init.js')}}"></script>
        
        <!-- App js -->
        <script src="{{URL::asset('assets/js/app.js')}}"></script>

    </body>
</html>
