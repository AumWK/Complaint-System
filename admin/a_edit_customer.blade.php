@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12">
    <div class="m-3">
        <div class="pb-3">
            <a href="{{url('/black_manage_customer')}}"><button class="btn btn-secondary btn-sm float-start fs_3">กลับ</button></a>   

            <form action="{{url('/update_customer/'.$id)}}" method="post">
            @csrf
                <div class="clearfix">
                    <button class="btn btn-success btn-sm float-end fs_3">บันทึก</button>
                </div>

                <div class="text-center h4">
                    <p>แก้ไขผู้ใช้งาน (Customer)</p>
                </div>

                @foreach($data as $t) 
                <!-- <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ID User :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="user_id" value="{{$t->user_id}}" readonly="readonly">
                        
                    </div>
                </div> -->

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อ :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name" value="{{$t->name}}">
                        
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">บริษัท :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="company" value="{{$t->company}}">
                        
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">เบอร์โทรศัพท์ :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="phone" value="{{$t->phone}}">
                        
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">Email :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="email" value="{{$t->email}}">
                        
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ประเภท :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="types">
                            <option value="{{$t->types}}">Customer</option>
                        </select>
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