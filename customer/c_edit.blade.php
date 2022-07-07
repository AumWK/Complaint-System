@extends("master.master_customer")
@section("main-content-customer")
<div class="col-sm-12">
    <div class="p-1 ps-2 pe-2">
        <div class="fs-17 f-weight">
            <a href="{{url('/c_black_not_implemented')}}"><button class="btn btn-secondary btn-sm float-start">กลับ</button></a>
        </div>
        <form action="{{url('/c_update_complaint/'.$id_complaint)}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="clearfix pb-2">
                <button class="btn btn-success btn-sm float-end">บันทึก</button>
            </div>
            @foreach($data as $t) 
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
                            <input type="hidden" name="status" value="{{$t->status}}">
                            @foreach($view_data as $v)
                                <input class="d-inline float-end rounded border text-center bg-info" type="text" readonly="readonly" value="{{$v->name_status}}">
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3 pb-3">
                        <div class="col-sm-1 d-inline"></div>
                        <div class="col-sm-3 d-inline">
                            <p class="d-inline">โปรเจค :</p>
                        </div>
                        <div class="col-sm-8 d-inline">
                            <select class="w-50" style="width:30vh;" name="id_project">
                                <option value="{{$t->id_project}}">@foreach($view_data as $v){{$v->name}}@endforeach</option>
                                @foreach($tb_proj as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('id_project')<p class="d-inline text-danger">*{{$message}}</p>@enderror
                        </div>
                    </div>

                    <div class="row pb-3">
                        <div class="col-sm-1 d-inline"></div>
                        <div class="col-sm-3 d-inline">
                            <p class="d-inline">ประเภทเรื่องร้องเรียน :</p>
                        </div>
                        <div class="col-sm-8 d-inline">
                            <select class="w-50" name="type_complaint">
                                <option value="{{$t->type_complaint}}">@foreach($view_data as $v){{$v->name_complaint}}@endforeach</option>
                                @foreach($type_com as $itemc)
                                    <option value="{{$itemc->id_complaint}}">{{$itemc->name_complaint}}</option>
                                @endforeach
                            </select>
                            
                            <input type="text" name="othertype_complaint" placeholder="ประเภทอื่นๆ โปรดระบุ" value="{{$t->othertype_complaint}}">
                            @error('type_complaint')<p class="d-inline text-danger">*{{$message}}</p>@enderror
                        </div>
                    </div>

                    <div class="row pb-3">
                        <div class="col-sm-1 d-inline"></div>
                        <div class="col-sm-3 d-inline">
                            <p class="d-inline">เรื่องร้องเรียน :</p>
                        </div>
                        <div class="col-sm-8 d-inline">
                            <input type="text" class="w-50" name="subject" value="{{$t->subject}}">
                            @error('subject')<p class="d-inline text-danger">*{{$message}}</p>@enderror
                        </div>
                    </div>

                    <div class="row pb-3">
                        <div class="col-sm-1 d-inline"></div>
                        <div class="col-sm-3 d-inline">
                            <p class="d-inline">รายละเอียดเรื่องร้องเรียน :</p>
                        </div>
                        <div class="col-sm-8 d-inline">
                            <textarea cols="40" rows="5" name="detail" value="{{$t->detail}}">{{$t->detail}}</textarea>
                            @error('detail')<p class="d-inline text-danger">*{{$message}}</p>@enderror
                        </div>
                    </div>

                    <div class="row pb-3">
                        <div class="col-sm-1 d-inline"></div>
                        <div class="col-sm-3 d-inline">
                            <p class="d-inline">แนบไฟล์รูป :</p>
                        </div>
                        <div class="col-sm-8 d-inline">
                            <img src="{{asset('image/image.gif')}}" style="width:30px;height:30px">
                            แนบไฟล์ใหม่ <input type="file" class="w-50" name="file[]" accept="image/*" multiple="multiple">
                            @error('file')<p class="d-inline text-danger">*{{$message}}</p>@enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-1"></div>
            </div>
            @endforeach 
        </form>
    </div>
</div>
@endsection