@extends("master.master_admin")
@section("main-content-admin")
<div class="col-sm-12">
    <div class="m-3">
        <div class="pb-3">
            <a href="{{url('/black_manage_project')}}"><button class="btn btn-secondary btn-sm float-start fs_3">กลับ</button></a>   

            <form action="{{url('/update_project/'.$id)}}" method="post">
            @csrf
                <div class="clearfix">
                    <button class="btn btn-success btn-sm float-end fs_3">บันทึก</button>
                </div>

                <div class="text-center h4 pb-3">
                    <p>แก้ไข Project</p>
                </div>
                @foreach($data as $t) 
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
                        <p class="d-inline">รหัสลูกค้า :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="id_customer">
                            <option value="{{$t->id_customer}}">{{str_pad($t->id_customer, 3, '0', STR_PAD_LEFT);}}</option>
                            @foreach($cus as $cus) 
                            <option value="{{$cus->id}}">{{str_pad($cus->id, 3, '0', STR_PAD_LEFT);}} - {{$cus->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสพนักงานประสาน :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="id_support">
                            <option value="{{$t->id_support}}">{{str_pad($t->id_support, 3, '0', STR_PAD_LEFT);}}</option>
                            @foreach($empsup as $empsup) 
                            <option value="{{$empsup->id}}">{{str_pad($empsup->id, 3, '0', STR_PAD_LEFT);}} - {{$empsup->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row fs_2 pb-1">
                    <div class="col-sm-2 d-inline"></div>
                    <div class="col-sm-2 d-inline">
                        <p class="d-inline">รหัสพนักงานที่ดูแล :</p>
                    </div>
                    <div class="col-sm-8 d-inline">
                        <select class="w-50" style="height:30px" name="id_programmer">
                            <option value="{{$t->id_programmer}}">{{str_pad($t->id_programmer, 3, '0', STR_PAD_LEFT);}}</option>
                            @foreach($emppro as $emppro) 
                            <option value="{{$emppro->id}}">{{str_pad($emppro->id, 3, '0', STR_PAD_LEFT);}} - {{$emppro->name}}</option>
                            @endforeach
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