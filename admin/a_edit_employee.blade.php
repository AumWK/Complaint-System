@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12">
    <div class="m-3">
        <div class="pb-3">
            <a href="{{url('/black_manage_employee')}}"><button class="btn btn-secondary btn-sm float-start fs_3">กลับ</button></a>   
  
            <form action="{{url('/update_employee/'.$id)}}" method="post">
            @csrf
                <div class="clearfix">
                    <button class="btn btn-success btn-sm float-end fs_3">บันทึก</button>
                </div>

                <div class="text-center h4">
                    <p>แก้ไขผู้ใช้งาน Emplouyee</p>
                </div>

                @foreach($data as $t) 

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อ :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name" value="{{$t->name}}">
                        @error('name')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">Email :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="email" value="{{$t->email}}">
                        @error('email')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">เบอร์โทรศัพท์ :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="phone" value="{{$t->phone}}">
                        @error('phone')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ตำแหน่ง :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="types">
                            <option value="{{$t->types}}">{{$t->name_types}}</option>
                            <option value="1">Support</option>
                            <option value="2">Programmer</option>
                            <option value="4">Admin</option>
                        </select>
                        @error('types')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
                @endforeach 
                <div class="row fs_3 pt-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-8 d-inline">
                        @if(session("no_success"))
                            <p class="text-danger">*{{session('no_success')}}*</p>
                        @endif
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection