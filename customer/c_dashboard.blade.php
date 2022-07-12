@extends("master.master_customer")
@section("main-content-customer")
    <div class="col-sm-12">
        <div class="row d-board">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="bg-info d-item">
                    <img class="" src="{{asset('image/Save.gif')}}" >
                    <p class="h-item">รายการที่ยังไม่ได้ดำเนินการ</p>
                    <div class="border-item"></div>
                    <p class="body-item">รายการที่บันทึก</p>
                    <p class="number-item">{{session('count_one');}}</p>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="bg-primary d-item">
                    <img class="" src="{{asset('image/Dc1.gif')}}" >
                    <p class="h-item">รายการที่ยังไม่ได้ดำเนินการ</p>
                    <div class="border-item"></div>
                    <p class="body-item">รายการที่ส่ง</p>
                    <p class="number-item">{{session('count_two');}}</p>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="bg-warning d-item">
                    <img class="" src="{{asset('image/Dc2.gif')}}" >
                    <p class="h-item">รายการที่ดำเนินการแล้ว</p>
                    <div class="border-item"></div>
                    <p class="body-item">รายการที่กำลังดำเนินการ</p>
                    <p class="number-item">{{session('count_three');}}</p>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="bg-success d-item">
                    <img class="" src="{{asset('image/Dc3.gif')}}" >
                    <p class="h-item">รายการที่ดำเนินการแล้ว</p>
                    <div class="border-item"></div>
                    <p class="body-item">รายการที่ดำเนินการเสร็จสิ้น</p>
                    <p class="number-item">{{session('count_four')+session('count_five');}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection