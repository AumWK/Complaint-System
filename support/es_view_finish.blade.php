@extends("master.master_support")
@section("main-content-support")
<div class="col-sm-12">
    <div class="p-1 ps-2 pe-2">
        <div class="clearfix pb-2 fs-17 f-weight">
            <a href="{{url('/es_black_finish')}}"><button class="btn btn-secondary btn-sm float-start">กลับ</button></a>   
        </div>

        @foreach($data as $t)
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
                        <input class="d-inline float-end rounded border text-center bg-success text-light me-2" type="text" readonly="readonly" value="{{$t->name_status}}">
                    </div>
                </div>

                <div class="row mt-3 pb-1">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">วันที่ร้องเรียน {{$t->complaint_date}}</p>
                    </div>
                    <div class="col-sm-8 d-inline"></div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">วันที่รับเรื่อง {{$t->pickup_date}}</p>
                    </div>
                    <div class="col-sm-8 d-inline"></div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline">
                        <p class="d-inline">วันที่ปิดงาน {{$t->pickup_date}}</p>
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

                <div class="row pb-3">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-3 d-inline ">
                        <p class="d-inline">หมายเหตุ</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <img src="{{asset('image/mail.gif')}}" style="width:30px;height:30px">
                        <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#viewNote">ดู</button>
                    </div>
                </div>
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

<!-- หมายเหตุ -->
<div class="modal fade" id="viewNote" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">หมายเหตุจากพนักงาน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <div class="text-center">
                <p class="pt-3"><textarea name="note" cols="40" rows="5" readonly="readonly" value="{{$t->note}}">{{$t->note}}</textarea></p>
            </div>
        </div>
        @endforeach 
    </div>
  </div>
</div>
@endsection