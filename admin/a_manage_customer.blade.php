@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12 not-imple">
    <div class="p-2">
        <p class="h-text">จัดการผู้ใช้งาน Customer</p>
        <hr class="m-auto mb-2" style="max-width: 50%;">
        <div class="clearfix mb-2">
            <button type="button" class="btn btn-primary btn-sm float-end me-3" data-bs-toggle="modal" data-bs-target="#addCustomer">เพิ่มข้อมูล</button>
        </div>
        <form class="search" action="{{url('/search_manage_cus')}}" method="get">
            <input class="imput-search" type="text" placeholder=" id or name or email" name="search_manage_cus">
            <button class="btn-search"><img src="{{asset('image/Search.gif')}}"></button>
        </form>
        <table class="table table-striped table-hover">
            <thead class="text-center">
                <th>รหัส</th>
                <th>ชื่อ</th>
                <th>บริษัท</th>
                <th>จัดการ</th>
                <th>ลบ</th>
            </thead>

            @foreach($tb as $item) 
            <tbody class="text-center">
                <th>{{str_pad($item->id, 3, '0', STR_PAD_LEFT);}}</th>
                <th>{{$item->name}}</th>
                <th>{{$item->company}}</th>
                <th><a href="{{url('/edit_customer',$item->id)}}"><img src="{{asset('image/edit.gif')}}" style="width:35px;height:35px" alt=""></a></th>
                <th><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="{{url('/delete_customer',$item->id)}}">
                        <img src="{{asset('image/delete.gif')}}" style="width:35px;height:35px" alt="">
                    </a>
                </th>
            </tbody>
            @endforeach  
        </table>
        <div class="text-center pt-3">{{$tb->links()}}</div>
    </div>
</div>

<!-- เพิ่มผู้ใช้งาน Customer -->
<div class="modal fade" id="addCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มผู้ใช้งาน (Customer)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <form id="add_cus" action="add_customer_data" method="post">
            @csrf
                <div class="row pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">Email</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="email">
                        @error('email')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสผ่าน</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="password">
                        @error('password')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อ</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name">
                        @error('name')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">บริษัท</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="company">
                        @error('company')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">เบอร์โทรศัพท์</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="phone">
                        @error('phone')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ประเภท</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="types">
                            <option value="3">Customer</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer fs_3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="add_cus" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
  </div>
</div>
@endsection