<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/font.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}"> 
    <title>Complaint System</title>  
</head>
<body>
    <div class="row sticky-top">
        <div class="top-menu bg-dark">
            <div class="d-inline float-strat">
                <div class="ms-1 dropdown d-inline">
                    <button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img class="button-hhg" src="{{asset('image/III.gif')}}">
                    </button>
                </div>
                <a class="nav-link d-inline ps-0 pe-0" href="{{url('/a_dashboard')}}">
                    <img class="logo" src="{{asset('image/CS.gif')}}" style="width:30px;height:30px">
                    <p class="text-light d-inline">Complaint System</p>
                </a>
            </div>

            <div class="d-inline float-end">
                <div class="dropdown d-inline me-1">
                    <button class="button-dropdown btn dropdown-toggle text-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item"><img class="mb-1" src="{{asset('image/user.gif')}}"style="width:16px;height:16px"> {{session('name');}}</a></li>
                        <li><a class="dropdown-item"  href="{{url('/logout')}}" onclick="return confirm('คุณต้องการออกจากระบบหรือไม่ ?')"><img class="mb-1" src="{{asset('image/lougout.gif')}}"style="width:16px;height:16px"> Lougout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        @yield("main-content-admin")
    </div>

    <div class="modal fade" id="exampleModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="logo-modal ms-1 d-inline ">
                    <button class="btn" data-bs-dismiss="modal">
                        <img class="" src="{{asset('image/III.gif')}}"style="width:18px;height:15px">
                    </button>
                    <a class="nav-link d-inline ps-0 pe-0" href="{{url('/a_dashboard')}}">
                        <img class="logo" src="{{asset('image/CS.gif')}}" style="width:30px;height:30px">
                        <p class="text-light d-inline ps-1 fs-18">Complaint System</p>
                    </a>
                </div>
                
                <div class="fs-17">
                    <a class="dropdown-item text-light mt-4 ho-ac" href="{{url('/a_dashboard')}}">
                        <img class="mb-1" src="{{asset('image/AR2.gif')}}"style="width:20px;height:20px">
                        <p class="ms-3 d-inline">Dashboard</p> 
                    </a>
                </div>

                <hr class="dropdown-divider bg-light mt-3 mb-3">

                <div class="fs-17">
                    <div class="dropdown-item text-light ho-ac" disabled>
                        <img class="mb-1" src="{{asset('image/Document.gif')}}"style="width:20px;height:20px">
                        <p class="ms-3 d-inline">จัดการผู้ใช้งาน</p>
                    </div>
                        <ul><a class="dropdown-item text-light mt-2 ho-ac" href="{{url('/manage_customer')}}">
                                <img class="" src="{{asset('image/Jud.gif')}}"style="width:3px;height:3px">
                                <p class="ms-1 d-inline">Customer</p>
                            </a>
                            <a class="dropdown-item text-light mt-2 ho-ac" href="{{url('/manage_employee')}}">
                                <img class="" src="{{asset('image/Jud.gif')}}"style="width:3px;height:3px">
                                <p class="ms-1 d-inline">Employee</p>
                            </a>
                        </ul>
                </div>

                <div class="fs-17">
                    <a class="dropdown-item text-light mt-2 ho-ac" href="{{url('/manage_types')}}">
                        <img class="mb-1" src="{{asset('image/Document.gif')}}"style="width:20px;height:20px">
                        <p class="ms-3 d-inline">จัดการตำแหน่ง</p> 
                    </a>
                </div>

                <div class="fs-17">
                    <a class="dropdown-item text-light mt-2 ho-ac" href="{{url('/manage_project')}}">
                        <img class="mb-1" src="{{asset('image/Document.gif')}}"style="width:20px;height:20px">
                        <p class="ms-3 d-inline">จัดการ Project</p> 
                    </a>
                </div>

                <div class="fs-17">
                    <a class="dropdown-item text-light mt-2 ho-ac" href="{{url('/manage_complaint')}}">
                        <img class="mb-1" src="{{asset('image/Document.gif')}}"style="width:20px;height:20px">
                        <p class="ms-3 d-inline">จัดการประเภทร้องเรียน</p> 
                    </a>
                </div>

                <hr class="dropdown-divider bg-light mt-3 mb-3">
            </div>
        </div>
    </div>

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>
</body>
</html>