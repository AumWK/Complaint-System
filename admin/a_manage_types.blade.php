@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12 not-imple">
    <div class="p-2">
        <p class="h-text">จัดการตำแหน่ง</p>
        <hr class="m-auto mb-2" style="max-width: 50%;">
        <div class="clearfix mb-2">
            <button disabled type="button" class="btn btn-primary btn-sm float-end me-3" data-bs-toggle="modal" data-bs-target="#addTypes">เพิ่มข้อมูล</button>
        </div>
        
        <table class="table table-striped table-hover">
            <thead class="text-center">
                <th>รหัส</th>
                <th>ตำแหน่ง</th>
                <th>จัดการ</th>
                <th>ลบ</th>
            </thead>
 
            @foreach($results as $item) 
            <tbody class="text-center">
                <th>{{$item->id}}</th>
                <th>{{$item->name_types}}</th>
                <th>
                    <!-- <a href="{{url('/edit_types',$item->id)}}"> -->
                        <img src="{{asset('image/edit.gif')}}" style="width:35px;height:35px" alt="">
                    <!-- </a> -->
                </th>
                <th>
                    <!-- <a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="{{url('/delete_types',$item->id)}}"> -->
                        <img src="{{asset('image/delete.gif')}}" style="width:35px;height:35px" alt="">
                    <!-- </a> -->
                </th>
            </tbody>
            @endforeach 
        </table>
    </div>
</div>

<!-- เพิ่มตำแหน่ง -->
<div class="modal fade" id="addTypes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มตำแหน่งในระบบ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <form id="add_types" action="add_types_data" method="post">
            @csrf
                <div class="row fs_2 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อตำแหน่ง</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name_types">
                        @error('name_types')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="add_types" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
  </div>
</div>
@endsection