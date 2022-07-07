@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12 not-imple">
    <div class="p-2">
        <p class="h-text">จัดการประเภทร้องเรียน</p>
        <hr class="m-auto mb-2" style="max-width: 50%;">
        <div class="clearfix mb-2">
            <button type="button" class="btn btn-primary btn-sm float-end me-3" data-bs-toggle="modal" data-bs-target="#addComplaint">เพิ่มข้อมูล</button>
        </div>
        
        <table class="table table-striped table-hover">
            <thead class="text-center">
                <th>ลำดับที่</th>
                <th>ชื่อประเภทร้องเรียน</th>
                <th>จัดการ</th>
                <th>ลบ</th>
            </thead>
            @php($number=1)
            @foreach($results as $item)
            <tbody class="text-center">
                <th>{{$number++}}</th>
                <th>{{$item->name_complaint}}</th>
                <th><a href="{{url('/edit_complaint',$item->id_complaint)}}">
                        <img src="{{asset('image/edit.gif')}}" style="width:35px;height:35px">
                    </a>
                </th>
                <th><a onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')" href="{{url('/delete_complaint',$item->id_complaint)}}">
                        <img src="{{asset('image/delete.gif')}}" style="width:35px;height:35px">
                    </a>
                </th>
            </tbody>
            @endforeach 
        </table>
    </div>
</div>

<!-- เพิ่มประเภทร้องเรียน -->
<div class="modal fade" id="addComplaint" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มประเภทร้องเรียน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
       <div class="modal-body"> 
            <form id="add_complaint_data" action="add_complaint_data" method="post">
            @csrf
                <div class="row fs_2 pb-3">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อประเภทร้องเรียน</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name_complaint">
                        @error('name_complaint')<p class="d-inline text-danger">{{$message}}</p>@enderror
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer fs_3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ออก</button>
            <button form="add_complaint_data" type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
  </div>
</div>
@endsection