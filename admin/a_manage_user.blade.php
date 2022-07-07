@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12">
    <div class="m-3">
        <div class="float-end">
            <button type="button" class="btn btn-sm btn-primary fs_4" data-bs-toggle="modal" data-bs-target="#addUser">เพิ่มข้อมูล</button>
        </div>
        <div>
            <p class="text-center fs_1 ps-5 ms-3">จัดการผู้ใช้งาน</p>
            <hr class="m-auto" style="width:50vh;">
            <form action="{{url('/search_user')}}" method="get" class="float-end">
                <input class="rounded border border-secondary" type="text" placeholder=" email or user id" name="search_user">
                <button class="btn btn-secondary btn-sm mb-1">Search</button>
            </form>
        </div>
        <table class="table">
            <thead class="text-center bg_htb">
                <th>User ID</th>
                <th>Email</th>
                <th>รหัสผ่าน</th>
                <th>จัดการ</th>
                <th>ลบ</th>
            </thead>

            @foreach($tb as $item) 
            <tbody class="bg_btb">
                <!-- <th class="text-center">{{$item->id}}</th> -->
                <th class="text-center">{{$item->id}}</th>
                <th>{{$item->email_user}}</th>
                <th>{{$item->password_user}}</th>
                <th  class="text-center"><a href="{{url('/edit_user',$item->id)}}"><img src="{{asset('images/edit.gif')}}" style="width:35px;height:35px" alt=""></a></th>
                <th  class="text-center">
                    <a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="{{url('/delete_user',$item->id)}}">
                        <img src="{{asset('images/delete.gif')}}" style="width:35px;height:35px" alt="">
                    </a>
                </th>
            </tbody>
            @endforeach  
        </table>
        <div class="text-center  pt-4">{{$tb->links()}}</div>
    </div>
</div>

<!-- เพิ่มผู้ใช้งาน -->
<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sx">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4">เพิ่มผู้ใช้</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <form id="add_user" action="add_user_data" method="post">
            @csrf
                <div class="row fs_2 pb-1">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">Email</p>
                    </div>
                    <div class="col-sm-9 d-inline">
                        <input type="text" class="w-50vh" name="email_user">
                        @error('email_user')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-1 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสผ่าน</p>
                    </div>
                    <div class="col-sm-9 d-inline">
                        <input type="text" class="w-50vh" name="password_user">
                        @error('password_user')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary fs_3" data-bs-dismiss="modal">ออก</button>
            <button form="add_user" type="submit" class="btn btn-success fs_3">บันทึก</button>
        </div>
    </div>
  </div>
</div>
@endsection