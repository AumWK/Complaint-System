@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12">
    <div class="m-3">
        <div class="pb-3">
            <a href="{{url('/black_manage_complaint')}}"><button class="btn btn-secondary btn-sm float-start fs_3">กลับ</button></a>   

            <form action="{{url('/update_complaint/'.$id_complaint)}}" method="post">
            @csrf
                <div class="clearfix">
                    <button class="btn btn-success btn-sm float-end fs_3">บันทึก</button>
                </div>

                <div class="text-center h4 pb-3">
                    <p>แก้ไขประเภทร้องเรียน</p>
                </div>

                @foreach($data as $t) 
                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">ชื่อประเภทร้องเรียน :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <input type="text" class="w-50" name="name_complaint" value="{{$t->name_complaint}}">
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