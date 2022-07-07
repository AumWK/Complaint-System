@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12 not-imple">
    <div class="p-2">
        <p class="h-text">จัดการ Project</p>
        <hr class="m-auto mb-2" style="max-width: 50%;">
        <div class="clearfix mb-2">
            <button type="button" class="btn btn-primary btn-sm float-end me-3" data-bs-toggle="modal" data-bs-target="#addProject">เพิ่มข้อมูล</button>
        </div>
        <form class="search" action="{{url('/search_project')}}" method="get">
            <input class="imput-search" type="text" placeholder=" ชื่อโปรเจค" name="search_pro">
            <button class="btn-search"><img src="{{asset('image/Search.gif')}}"></button>
        </form>
        <table class="table table-striped table-hover">
            <thead class="text-center">
                <th>รหัส</th>
                <th>ชื่อ</th>
                <th>รหัสลูกค้า</th>
                <th>จัดการ</th>
                <th>ลบ</th>
            </thead>
            @foreach($results as $item) 
            <tbody class="text-center">
                <th>{{str_pad($item->id, 3, '0', STR_PAD_LEFT);}}</th>
                <th>{{$item->name}}</th>
                <th>{{str_pad($item->id_customer, 3, '0', STR_PAD_LEFT);}}</th>
                <th><a href="{{url('/edit_project',$item->id)}}"><img src="{{asset('image/edit.gif')}}" style="width:35px;height:35px" alt=""></a></th>
                <th><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="{{url('/delete_project',$item->id)}}"><img src="{{asset('image/delete.gif')}}" style="width:35px;height:35px" alt=""></a></th>
            </tbody>
            @endforeach
        </table>
        <div class="text-center pt-3">{{$results->links()}}</div>
    </div>
</div>

<!-- เพิ่มProject -->
<div class="modal fade" id="addProject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่ม Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <form id="add_project" action="add_project_data" method="post">
            @csrf
                <div class="row fs_2 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อ Project</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name">
                        @error('name')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสลูกค้า(Customer)</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="id_customer">
                            <option value="">เลือกลูกค้า</option>
                            @foreach($cus as $cus)
                            <option value="{{$cus->id}}">{{str_pad($cus->id, 3, '0', STR_PAD_LEFT);}} - {{$cus->name}}</option>
                            @endforeach
                        </select>
                        @error('id_customer')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสพนักงานประสาน(Support)</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="id_support">
                            <option value="">เลือกพนักงาน(Support)</option>
                            @foreach($empsup as $empsup) 
                            <option value="{{$empsup->id}}">{{str_pad($empsup->id, 3, '0', STR_PAD_LEFT);}} - {{$empsup->name}}</option>
                            @endforeach
                        </select>
                        @error('id_support')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>

                <div class="row fs_2 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสพนักงานที่ดูแล(Programmer)</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="id_programmer">
                            <option value="">เลือกพนักงาน(Programmer)</option>
                            @foreach($emppro as $emppro) 
                            <option value="{{$emppro->id}}">{{str_pad($emppro->id, 3, '0', STR_PAD_LEFT);}} - {{$emppro->name}}</option>
                            @endforeach
                        </select>
                        @error('id_programmer')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="add_project" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
  </div>
</div>
@endsection