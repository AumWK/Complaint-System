@extends("master.master_customer")
@section("main-content-customer")
<div class="col-sm-12">
    <div class="p-1 ps-2 pe-2">
        <div class="clearfix pb-2 fs-17 f-weight">
            <a href="{{url('/c_black_not_implemented')}}"><button class="btn btn-secondary btn-sm float-start">กลับ</button></a>
            @foreach($data as $t)     
            <div class="float-end">
                <a onclick="return confirm('คุณต้องการยกเลิกข้อมูลร้องเรียนนี้หรือไม่ ?')" href="{{url('/delete_c_complaint',$t->id_complaint)}}"><button class="btn btn-danger btn-sm">ยกเลิก</button></a>
                <a href="{{url('/c_edit',$t->id_complaint)}}"><button class="btn btn-warning btn-sm">แก้ไข</button></a>
                <button data-bs-toggle="modal" data-bs-target="#addStatus" class="btn btn-success btn-sm ">ส่ง</button>
            </div>
        </div> 

        <div class="row p-0 m-0">
            <div class="col-sm-12 col-md-12 col-lg-1"></div>
            <div class="col-sm-12 col-md-12 col-lg-10 rounded border border-dark p-2 fs-17">
                <div class="row mt-3 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-10 d-inline fs-17 f-weight">
                        <p class="d-inline">ชื่อ</p> <p class="d-inline">{{session('name');}}</p>
                        <p class="d-inline">บริษัท</p> <p class="d-inline">{{session('company');}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <input class="d-inline float-end rounded border text-center bg-info me-2" type="text" readonly="readonly" value="{{$t->name_status}}">
                    </div>
                </div>

                <div class="row mt-3 pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">โปรเจค</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" readonly="readonly" value="{{$t->name}}">
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">ประเภทเรื่องร้องเรียน</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" readonly="readonly" value="{{$t->name_complaint}}">
                        <input type="text" readonly="readonly" value="{{$t->othertype_complaint}}">
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">เรื่องร้องเรียน</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" readonly="readonly" value="{{$t->subject}}">
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">รายละเอียดเรื่องร้องเรียน</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <textarea rows="4" cols="40" readonly="readonly" value="{{$t->detail}}">{{$t->detail}}</textarea>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">ไฟล์รูป</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <img src="{{asset('image/image.gif')}}" style="width:30px;height:30px">
                        <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#viewImage">ดู</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-1"></div>
        </div>
    </div>
</div>

<!-- Submit Complaint -->
<div class="modal fade" id="addStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ส่งเรื่องร้องเรียน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body"> 
            <div class="text-center">
                <form id="addstatus" class="" action="{{url('/addstatus/'.$id_complaint)}}" method="post">
                @csrf
                    <!-- เพิ่มข้อความแจ้งเตือน -->
                    <input type="hidden" name="message" value="มีเรื่องร้องเรียนใหม่ Project">
                    <input type="hidden" name="is_read" value="0">

                    <!-- add status -->
                    <input type="hidden" name="status" value="2">
                    <p class="d-inline">วันที่ร้องเรียน : <input type="date" name="complaint_date" value="<?php echo date("Y-m-d");?>" readonly="readonly"></p>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="addstatus" type="submit" class="btn btn-success">ส่ง</button>
        </div>
    </div>
  </div>
</div>

<!-- ViewFile -->
<div class="modal fade" id="viewImage" data-bs-backdrop="static"  tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ไฟล์ที่แนบ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <div class="text-center">
                <!-- loop image -->
                @foreach (explode("|", $t->file) as $image)
                    <img src="{{asset('image_data/'.$image)}}" style="max-width: 100%;">
                    <br>
                @endforeach
            </div>
        </div>
        @endforeach 
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
        </div>
    </div>
  </div>
</div>
@endsection