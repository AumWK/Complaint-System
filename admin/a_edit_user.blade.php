@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12">
    <div class="m-3">
        <div class="pb-3">
            <a href="{{url('/black_manage_user')}}"><button class="btn btn-secondary btn-sm float-start fs_3">กลับ</button></a>   

            <form action="{{url('/update_user/'.$id)}}" method="post">
            @csrf
                <div class="clearfix">
                    <button class="btn btn-success btn-sm float-end fs_3">บันทึก</button>
                </div>

                <div class="text-center h4">
                    <p>เพิ่มผู้ใช้งาน</p>
                </div>
                @foreach($data as $t) 
                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">Email :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="email_user" value="{{$t->email_user}}">
                        
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสผ่าน :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="password_user" value="{{$t->password_user}}">
                        
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