@extends("master.master_customer")
@section("main-content-customer")
<div class="col-sm-12 not-imple">
    <div class="p-2">
        <p class="h-text">รายการร้องเรียนที่ดำเนินการแล้ว</p>
        <hr class="m-auto mb-4" style="max-width: 50%;">
        <form class="search" action="{{url('/search_implemented')}}" method="get">
            <input class="imput-search" type="text" placeholder=" ชื่อโปรเจค หรือ เรื่อง" name="search_implemented">
            <button class="btn-search"><img src="{{asset('image/Search.gif')}}"></button>
        </form>
        <table class="table table-striped table-hover">
            <thead class="text-center">
                <th>#</th>
                <th>โปรเจค</th>
                <th>เรื่อง</th>
                <th>สถานะ</th>
                <td></td>
            </thead>
            @foreach($tb as $item)
            <tbody class="">
                <th class="text-center">{{$tb->firstItem()+$loop->index}}</th>
                <th class="text-center">{{$item->name}}</th>
                <th class="text-center">{{$item->subject}}</th>
                <th class="text-center">
                    @if ($item->name_status == 'กำลังดำเนินการ')
                        <span class="bg-warning text-center rounded p-1">{{$item->name_status}}</span>
                    @elseif ($item->name_status == 'ดำเนินการเสร็จสิ้น')
                        <span class="bg-success text-center rounded p-1">{{$item->name_status}}</span>
                    @endif
                </th>
                <th  class="text-center"><a href="{{url('/c_view_implemented',$item->id_complaint)}}"><button class="btn btn-primary btn-sm">ดู</button></a></th>
            </tbody>
            @endforeach
        </table>
        <div class="text-center pt-3">{{$tb->links()}}</div>
    </div>
</div>
@endsection