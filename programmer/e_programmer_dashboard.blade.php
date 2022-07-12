@extends("master.master_programmer")
@section("main-content-programmer")
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="bg-warning ms-5 me-5 mt-5 rounded text-center">
                <img class="mt-5" src="{{asset('image/DocMenu.gif')}}" style="width:140px;height:140px">
                <p class="mt-5 fs-18">เอกสารร้องเรียน</p>
                <hr class="mt-5">
                <p class="pb-3 number-item-emp">{{session('count_three');}}</p>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-6"">
            <div class="bg-success ms-5 me-5 mt-5 rounded text-center">
                <img class="mt-5" src="{{asset('image/success-emp.gif')}}" style="width:140px;height:140px">
                <p class="mt-5 fs-18">ดำเนินการเสร็จสิ้น</p>
                <hr class="mt-5">
                <p class="pb-3 number-item-emp">{{session('count_four');}}</p>
            </div> 
        </div>
    </div>
</div>  
@endsection