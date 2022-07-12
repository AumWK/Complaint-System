@extends("master.master_support")
@section("main-content-support")
<div class="col-sm-12">
    <div class="p-1 ps-2 pe-2">
        @foreach($data as $t) 
        <div class="clearfix pb-2 fs-17 f-weight">
            <a href="{{url('/es_black_implemented')}}"><button class="btn btn-secondary btn-sm float-start">กลับ</button></a>
            <div class="float-end">
                @if ($t->name_status == 'ส่งเรื่องร้องเรียน')
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#bounce_dataComplaint">ตีกลับ</button>
                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#forwardComplaint">ส่งต่อ</button>
                @endif
            </div>
        </div>

        <div class="row p-0 m-0">
            <div class="col-sm-12 col-md-12 col-lg-1"></div>
            <div class="col-sm-12 col-md-12 col-lg-10 rounded border border-dark p-2 fs-17">
                <div class="row mt-3 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-10 d-inline fs-17 f-weight">
                        <p class="d-inline">ชื่อ</p> <p class="d-inline">{{session('name');}}</p>
                        <p class="d-inline">ตำแหน่ง</p> <p class="d-inline">{{session('name_types');}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        @if ($t->name_status == 'ส่งเรื่องร้องเรียน')
                            <input class="d-inline float-end rounded border text-center bg-primary text-light me-2" type="text" readonly="readonly" value="{{$t->name_status}}">
                        @elseif ($t->name_status == 'กำลังดำเนินการ')
                            <input class="d-inline float-end rounded border text-center bg-warning text-light me-2" type="text" readonly="readonly" value="{{$t->name_status}}">
                        @elseif ($t->name_status == 'ดำเนินการเสร็จสิ้น')
                            <input class="d-inline float-end rounded border text-center bg-success text-light me-2" type="text" readonly="readonly" value="{{$t->name_status}}">
                        @endif
                    </div>
                </div>

                <div class="row mt-3 pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">วันที่ร้องเรียน {{$t->complaint_date}}</p>
                    </div>
                    <div class="col-sm-8 d-inline"></div>
                </div>

                <div class="row pb-3">
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
                @if ($t->name_status == 'ดำเนินการเสร็จสิ้น')
                    <div class="row pb-3">
                        <div class="col-sm-1 d-inline"></div>
                        <div class="col-sm-3 d-inline ">
                            <p class="d-inline">หมายเหตุ</p>
                        </div>
                        <div class="col-sm-8 d-inline">
                            <img src="{{asset('images/mail.gif')}}" style="width:30px;height:30px">
                            <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#viewNote">ดู</button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-sm-12 col-md-12 col-lg-1"></div>
        </div>
    </div>
</div>

<!-- ViewFile -->
<div class="modal fade" id="viewImage" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ไฟล์ที่แนบ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <div class="text-center">
                @foreach (explode("|", $t->file) as $image)
                    <img src="{{asset('image_data/'.$image)}}" style="max-width: 100%;">
                    <br>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
        </div>
    </div>
  </div>
</div>

<!-- ส่งต่อเรื่องร้องเรียน -->
<div class="modal fade" id="forwardComplaint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sx">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ส่งต่อเรื่องร้องเรียน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body text-center"> 
            <form id="forward" action="{{url('/forward_pgm/'.$id_complaint)}}" method="post">
                @csrf
                <!-- เพิ่มข้อความแจ้งเตือน -->
                <input type="hidden" name="message1" value="เรื่องร้องเรียนที่ต้องดำเนินการ Project">
                <input type="hidden" name="message2" value="เรื่องร้องเรียนที่กำลังดำเนินการ Project">
                <input type="hidden" name="is_read" value="0">

                <input type="hidden" name="status" value="3">
                <p class="d-inline">วันที่รับเรื่อง : <input type="date" name="pickup_date" value="<?php echo date("Y-m-d");?>" readonly="readonly"></p>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="forward" type="submit" class="btn btn-success">ส่อ</button>
        </div>
    </div>
  </div>
</div>

<!-- ตีกลับเรื่องร้องเรียน -->
<div class="modal fade" id="bounce_dataComplaint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ตีกลับเรื่องร้องเรียน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <form id="bounce_data" action="{{url('/bounce_data/'.$id_complaint)}}" method="post">
                @csrf
                <!-- เพิ่มข้อความแจ้งเตือน -->
                <input type="hidden" name="message" value="เรื่องร้องเรียนที่ถูกตีกลับ Project">
                <input type="hidden" name="is_read" value="0">
                <input type="hidden" name="status" value="4">

                <p class="">วันที่รับ : <input type="date" name="pickup_date" value="<?php echo date("Y-m-d");?>" readonly="readonly"></p>

                <p class="">วันที่ปิด : <input type="date" name="finish_date" value="<?php echo date("Y-m-d");?>" readonly="readonly"></p>

                <p class="pt-3 fs-17">ระบุหมายเหตุ</p><textarea name="note" rows="4" cols="40"></textarea>
                @error('note')<p class="text-danger">{{$message}}</p>@enderror
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="bounce_data" type="submit" class="btn btn-danger">ตีกลับ</button>
        </div>
    </div>
  </div>
</div>

<!-- หมายเหตุ -->
<div class="modal fade" id="viewNote" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">หมายเหตุจากพนักงาน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <div class="text-center">
                <p class="pt-3"><textarea name="note" cols="40" rows="4"readonly="readonly" value="{{$t->note}}">{{$t->note}}</textarea></p>
            </div>
        </div>
        @endforeach 
    </div>
  </div>
</div>
@endsection