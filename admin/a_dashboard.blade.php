@extends("master.master_admin")
@section("main-content-admin")
    <div class="col-sm-12">
        <div class="row d-board">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="bg-info d-item">
                    <img class="" src="{{asset('image/userW.gif')}}" >
                    <p class="h-item">จำนวนผู้ใช้งานในระบบ</p>
                    <div class="border-item"></div>
                    <p class="number-item">{{session('dash_user');}}</p>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="bg-success d-item">
                    <img class="" src="{{asset('image/doc.gif')}}" >
                    <p class="h-item">จำนวน Project ในระบบ</p>
                    <div class="border-item"></div>
                    <p class="number-item">{{session('dash_project');}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection