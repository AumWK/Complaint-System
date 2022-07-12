@extends("master.master_customer")
@section("main-content-customer")
<div class="col-sm-12 not-imple">
    <div class="p-2">
        <p class="h-text">รายการร้องเรียนที่ยังไม่ได้ดำเนินการ</p>
        <hr class="m-auto mb-2" style="max-width: 50%;">
        <div class="clearfix mb-2">
            <button class="btn btn-primary btn-sm float-end me-3" type="button" data-bs-toggle="modal" data-bs-target="#addComplaint">เพิ่มข้อมูล</button>
        </div>
        <form class="search" action="{{url('/search_not_implemented')}}" method="get">
            <input class="imput-search" type="text" placeholder=" ชื่อโปรเจค หรือ เรื่อง" name="search_not_implemented">
            <button class="btn-search"><img src="{{asset('image/Search.gif')}}"></button>
        </form>
        <table class="table table-striped table-hover">
            <thead class="text-center">
                <th>#</th>
                <th>โปรเจค</th>
                <th>เรื่อง</th>
                <th>สถานะ</th>
                <td></td>
            </thead>
            @foreach($tb as $item)
            <tbody class="">
                <th class="text-center">{{$tb->firstItem()+$loop->index}}</th>
                <th class="text-center">{{$item->name}}</th>
                <th class="text-center">{{$item->subject}}</th>
                <th class="text-center">
                    @if ($item->name_status == 'บันทึก')
                        <span class="bg-info text-center rounded p-1">{{$item->name_status}}</span>
                    @else ($item->name_status == 'ส่งเรื่องร้องเรียน')
                        <span class="bg-primary text-center rounded p-1">{{$item->name_status}}</span>
                    @endif
                </th>
                <th><a href="{{url('/c_view_n-implemented',$item->id_complaint)}}"><button type="button" class="btn btn-primary btn-sm">ดู</button></a></th>
            </tbody>
            @endforeach
        </table>
        <div class="text-center pt-3">{{$tb->links()}}</div>
    </div>
</div>

<!-- Add Complaint -->
<div class="modal fade" id="addComplaint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มข้อมูลร้องเรียน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
           <form id="myformadd" action="add_complaintdata" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="1" name="status">
            <input type="hidden" value="-" name="complaint_date">
            <input type="hidden" value="-" name="pickup_date">
            <input type="hidden" value="-" name="finish_date">
            <input type="hidden" value=".-" name="note">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 d-inline">
                        <p class="d-inline">ชื่อ</p> <p class="d-inline">{{session('name');}}</p>
                        <p class="d-inline">บริษัท</p> <p class="d-inline">{{session('company');}}</p>
                    </div>
                </div>
                <br>

                <div class="row pb-3">
                    <div class="col-sm-4 d-inline">
                        <p class="d-inline">โปรเจค :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="width:30vh;" name="id_project">
                            <option value="">เลือกโปรเจค</option>
                            @foreach($tb_proj as $itemp)
                                <option value="{{$itemp->id}}">{{$itemp->name}}</option>
                            @endforeach
                        </select>
                        @error('id_project')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-4 d-inline">
                        <p class="d-inline">ประเภทเรื่องร้องเรียน :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" name="type_complaint">
                            <option value="">เลือกประเภทเรื่องร้องเรียน</option>
                            @foreach($type_com as $itemc)
                            <option value="{{$itemc->id_complaint}}">{{$itemc->name_complaint}}</option>
                            @endforeach
                        </select>
                        <input type="text" name="othertype_complaint" placeholder="ประเภทอื่นๆ โปรดระบุ">
                        @error('type_complaint')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-4 d-inline">
                        <p class="d-inline">เรื่องร้องเรียน :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="subject">
                        @error('subject')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-4 d-inline">
                        <p class="d-inline">รายละเอียดเรื่องร้องเรียน :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <textarea rows="4" cols="40" name="detail"></textarea>
                        @error('detail')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col-sm-4 d-inline">
                        <p class="d-inline">แนบไฟล์รูป :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="file" class="w-50" name="file[]" accept="image/*" multiple="multiple">
                        @error('file')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="myformadd" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
  </div>
</div>

@endsection