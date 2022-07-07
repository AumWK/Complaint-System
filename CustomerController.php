<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class CustomerController extends Controller
{
    public function dash_board(){
        $dash_oen = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
        ->where('tb_project.id_customer', '=', session('id'))->whereIn('status',[1])->count();
        $dash_two = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
        ->where('tb_project.id_customer', '=', session('id'))->whereIn('status',[2])->count();
        $dash_three = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
        ->where('tb_project.id_customer', '=', session('id'))->whereIn('status',[3])->count();
        $dash_four = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
        ->where('tb_project.id_customer', '=', session('id'))->whereIn('status',[4])->count();
        Session::put('count_one',$dash_oen);
        Session::put('count_two',$dash_two);
        Session::put('count_three',$dash_three);
        Session::put('count_four',$dash_four);

        $noti = DB::table('tb_noti')
            ->join('tb_project', 'tb_noti.project_id', '=', 'tb_project.id')
            ->join('tb_complaint', 'tb_noti.complaint_id', '=', 'tb_complaint.id_complaint')
            ->select(
                        'tb_noti.id',
                        'tb_noti.message',
                        'tb_noti.project_id',
                        'tb_noti.is_read',
                        'tb_noti.user_id',
                        'tb_project.name',
                        'tb_complaint.id_complaint'
                    )
            ->where('tb_noti.user_id', '=', session('id_user'))
            ->where('tb_noti.is_read', '=', '0')->get();
        Session::put('noti',$noti);
        
        return view('customer.c_dashboard');
    }

    //รายการแจ้งเตือน (กระดิ่ง)
    public function ep_viewnew($id){
        $read = '1';
        $insert = DB::table("tb_noti")->where('id', $id)->update(
            [
                'is_read' => $read
            ]
        );
        if($insert){
            $tb_noti = DB::table("tb_noti")->where('id', $id)->get();
            $id_complaint = $tb_noti[0]->complaint_id;
            $data = DB::table('tb_complaint')
                ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
                ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
                ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
                ->select(
                            'tb_complaint.id_complaint',
                            'tb_project.name',
                            'types_complaint.name_complaint',
                            'tb_complaint.othertype_complaint',
                            'tb_complaint.subject',
                            'tb_complaint.detail',
                            'tb_complaint.complaint_date',
                            'tb_complaint.pickup_date',
                            'tb_complaint.finish_date',
                            'tb_complaint.file',
                            'types_status.name_status',
                            'tb_complaint.note'
                        )
                ->where('tb_complaint.id_complaint', $id_complaint)
                ->get()->toArray();
            $delete = DB::table("tb_noti")->where('id', $id)->delete();
            return view('customer.c_view_implemented',['data' => $data,'id_complaint' => $id_complaint]);
        }else{
            return redirect()->intended('c_dashboard');
        } 
    }

    //รายการที่ยังไม่ได้ดำเนินการ
        public function not_implemented(){
            $tb = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
            ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_project.name',
                        'types_complaint.name_complaint',
                        'tb_complaint.othertype_complaint',
                        'tb_complaint.subject',
                        'tb_complaint.detail',
                        'tb_complaint.complaint_date',
                        'tb_complaint.file',
                        'types_status.name_status',
                    )
            ->where('tb_project.id_customer', '=', session('id'))
            ->whereIn('status',[1,2])->simplePaginate(5);
            $tb_proj = DB::table('tb_project')->where('id_customer', '=', session('id'))->get();

            $noti = DB::table('tb_noti')
            ->join('tb_project', 'tb_noti.project_id', '=', 'tb_project.id')
            ->join('tb_complaint', 'tb_noti.complaint_id', '=', 'tb_complaint.id_complaint')
            ->select(
                        'tb_noti.id',
                        'tb_noti.message',
                        'tb_noti.project_id',
                        'tb_noti.is_read',
                        'tb_noti.user_id',
                        'tb_project.name',
                        'tb_complaint.id_complaint'
                    )
            ->where('tb_noti.user_id', '=', session('id_user'))
            ->where('tb_noti.is_read', '=', '0')->get();
            Session::put('noti',$noti);

            $type_com = DB::table("types_complaint")->get();
            return view('customer.c_not_implemented',compact('tb','tb_proj','type_com'));
        }

        public function search_not_implemented(Request $request){
            $validated = $request->validate(
                [
                    'search_not_implemented' => 'required',
                ],
                [
                    'search_not_implemented.required'=>"*",
                ]
            );
            $search_not_implemented = $request->input('search_not_implemented');
            if($search_not_implemented!=''){
                $tb = DB::table('tb_complaint')
                    ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
                    ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
                    ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
                    ->select(
                                'tb_complaint.id_complaint',
                                'tb_project.name',
                                'types_complaint.name_complaint',
                                'tb_complaint.othertype_complaint',
                                'tb_complaint.subject',
                                'tb_complaint.detail',
                                'tb_complaint.complaint_date',
                                'tb_complaint.file',
                                'types_status.name_status',
                            )
                    ->where('tb_project.id_customer', '=', session('id'))
                    ->whereIn('status',[1,2])
                    ->where('tb_project.name','LIKE',"%{$search_not_implemented}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$search_not_implemented}%")
                    ->simplePaginate(5);
                $tb_proj = DB::table('tb_project')
                ->where('tb_project.id_customer', '=', session('id'))->get();
                $type_com = DB::table("types_complaint")->get();
                return view('customer.c_not_implemented',compact('tb','tb_proj','type_com'));
            }
        }

        public function add_complaintdata(Request $request)
        {
            $validated = $request->validate(
                [
                    'id_project' => 'required',
                    'subject' => 'required',
                    'type_complaint' => 'required',
                    'detail' => 'required',
                    'file' => 'required'
                ],
                [
                    'id_project.required'=>"*",
                    'subject.required'=>"*",
                    'type_complaint.required'=>"*",
                    'detail.required'=>"*",
                    'file.required'=>"*"
                ]
            );

            // รับภาพมาจาก add_complaintdata ทำการเปลี่ยนชื่อไหม่แล้วเก็บลลงในโฟลเดอร์ image_data
            $images = $request->file('file');
            if ($request->hasFile('file')){
                foreach ($images as $item){
                    $name=$item->store('');
                    $img[]=$name;
                } 
            }else{$img = '';}

            // ถ้า img ใม่ใช่ค่าว่างให้เข้า if ทำการบันทึกลงฐานข้อมูล
            if($img != '')
            {
                $insert = DB::table("tb_complaint")->insert([
                    [
                        'id_project' => $request->id_project,
                        'subject' => $request->subject,
                        'status' => $request->status,
                        'detail' => $request->detail,
                        'type_complaint' => $request->type_complaint,
                        'file' => implode("|",$img),
                        'othertype_complaint' => $request->othertype_complaint,
                        'complaint_date' => $request->complaint_date,
                        'pickup_date' => $request->pickup_date,
                        'finish_date' => $request->finish_date,
                        'note' => $request->note
                    ]
                ]);
                if($insert){
                    return redirect()->intended('/c_not_implemented');
                }
                else{dd("Error");} 
            }
            else{dd('file not data');}
        }

        public function c_view_nimplemented($id_complaint){
            $data = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
            ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_project.name',
                        'types_complaint.name_complaint',
                        'tb_complaint.othertype_complaint',
                        'tb_complaint.subject',
                        'tb_complaint.detail',
                        'tb_complaint.complaint_date',
                        'tb_complaint.file',
                        'types_status.name_status'
                    )
            ->where('tb_complaint.id_complaint', $id_complaint)
            ->get()->toArray();
            if(isset($data[0])){
                $type=$data[0]->name_status;
                switch($type){
                    case"บันทึก":
                        return view('customer.c_view_n-implemented',['data' => $data,'id_complaint' => $id_complaint]);
                        break;
                    case"ส่งเรื่องร้องเรียน":
                        return view('customer.c_view_n-implemented2',['data' => $data,'id_complaint' => $id_complaint]);
                        break;
                }
                
            }
        }

        public function black_not_implemented(){
            return redirect('/c_not_implemented'); 
        }

        public function edit($id_complaint){
            $data = DB::table("tb_complaint")->where('id_complaint',$id_complaint)->get()->toArray();
            $view_data = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
            ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_project.name',
                        'types_complaint.name_complaint',
                        'tb_complaint.othertype_complaint',
                        'tb_complaint.subject',
                        'tb_complaint.detail',
                        'tb_complaint.complaint_date',
                        'tb_complaint.file',
                        'types_status.name_status'
                    )
            ->where('tb_complaint.id_complaint', $id_complaint)
            ->get()->toArray();

            $type_com = DB::table("types_complaint")->get();
            $tb_proj = DB::table('tb_project')->where('id_customer', '=', session('id'))->get();
            return view('customer.c_edit',['type_com' => $type_com,'data' => $data,'view_data' => $view_data,'id_complaint' => $id_complaint,'tb_proj' => $tb_proj]);
        }

        public function update_complaint(Request $request, $id_complaint){
            $validated = $request->validate(
                [
                    'id_project' => 'required',
                    'type_complaint' => 'required',
                    'file' => 'required',
                    'subject' => 'required',
                    'detail' => 'required'
                ],
                [
                    'id_project.required'=>"โปรดเลือกโปรเจคใหม่",
                    'type_complaint.required'=>"โปรดเลือกประเภทเรื่องร้องเรียนใหม่",
                    'file.required'=>"โปรดแนบไฟล์ใหม่",
                    'subject.required'=>"โปรดระบุเรื่องร้องเรียน",
                    'detail.required'=>"โปรดระบุรายละเอียด"
                ]
            );

            $images = $request->file('file');
            if ($request->hasFile('file')){
                foreach ($images as $item){
                    $name=$item->store('');
                    $img[]=$name;
                } 
            }else{$img = '';}

            if($img != '')
            {
                $updatedata = DB::table("tb_complaint")->where('id_complaint', $id_complaint)->update(
                    [
                        'id_project' => $request->id_project,
                        'subject' => $request->subject,
                        'status' => $request->status,
                        'detail' => $request->detail,
                        'type_complaint' => $request->type_complaint,
                        'file' => implode("|",$img),
                        'othertype_complaint' => $request->othertype_complaint
                    ]);
                    if($updatedata){
                        return redirect()->intended('/c_black_not_implemented');
                    }else{
                        dd("คุณยังไม่ได้แก้ไขข้อมูล");
                    }
            }
            else{dd('file not data');}
        }

        public function delete_complaint($id_complaint){
            $delete = DB::table("tb_complaint")->where('id_complaint', $id_complaint)->delete();
            return redirect()->intended('/c_black_not_implemented');
        }

        public function addstatus(Request $request, $id_complaint){
            $complaint = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_complaint.id_project',
                        'tb_project.id_support'
                    )
            ->where('id_complaint', $id_complaint)->get();

            $id = $complaint[0]->id_support;
            $tb_sup = DB::table('tb_employee')->where('id', $id)->get();
            $user_id = $tb_sup[0]->user_id;

            $project_id = $complaint[0]->id_project;
            $complaint_id = $complaint[0]->id_complaint;

            $insert = DB::table("tb_complaint")->where('id_complaint', $id_complaint)->update(
                [
                    'complaint_date' => $request->complaint_date,
                    'status' => $request->status
                ]
            );
            if($insert){
                $insert_noti = DB::table("tb_noti")->insert([
                [
                    'project_id' => $project_id,
                    'user_id' => $user_id,
                    'message' => $request->message,
                    'is_read' => $request->is_read,
                    'complaint_id' => $complaint_id,
                ]
                ]);
                return redirect()->intended('/c_not_implemented');
            }else{
                dd("Error");
            } 
        }



    //รายการที่ดำเนินการแล้ว
        public function implemented(){
            $tb = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
            ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_project.name',
                        'types_complaint.name_complaint',
                        'tb_complaint.othertype_complaint',
                        'tb_complaint.subject',
                        'tb_complaint.detail',
                        'tb_complaint.complaint_date',
                        'tb_complaint.file',
                        'types_status.name_status',
                        'tb_complaint.pickup_date',
                        'tb_complaint.finish_date',
                        'tb_complaint.note'
                    )
            ->where('tb_project.id_customer', '=', session('id'))
            ->whereIn('status',[3,4])->simplePaginate(5);
            $noti = DB::table('tb_noti')
            ->join('tb_project', 'tb_noti.project_id', '=', 'tb_project.id')
            ->join('tb_complaint', 'tb_noti.complaint_id', '=', 'tb_complaint.id_complaint')
            ->select(
                        'tb_noti.id',
                        'tb_noti.message',
                        'tb_noti.project_id',
                        'tb_noti.is_read',
                        'tb_noti.user_id',
                        'tb_project.name',
                        'tb_complaint.id_complaint'
                    )
            ->where('tb_noti.user_id', '=', session('id_user'))
            ->where('tb_noti.is_read', '=', '0')->get();
            Session::put('noti',$noti);
            return view('customer.c_implemented',compact('tb'));
        }

        public function search_implemented(Request $request){
            $validated = $request->validate(
                [
                    'search_implemented' => 'required',
                ],
                [
                    'search_implemented.required'=>"*",
                ]
            );
            $search_implemented = $request->input('search_implemented');
            if($search_implemented!=''){
                $tb = DB::table('tb_complaint')
                    ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
                    ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
                    ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
                    ->select(
                                'tb_complaint.id_complaint',
                                'tb_project.name',
                                'types_complaint.name_complaint',
                                'tb_complaint.othertype_complaint',
                                'tb_complaint.subject',
                                'tb_complaint.detail',
                                'tb_complaint.complaint_date',
                                'tb_complaint.file',
                                'types_status.name_status',
                                'tb_complaint.pickup_date',
                                'tb_complaint.finish_date',
                                'tb_complaint.note'
                            )
                    ->where('tb_project.id_customer', '=', session('id'))
                    ->whereIn('status',[3,4])
                    ->where('tb_project.name','LIKE',"%{$search_implemented}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$search_implemented}%")
                    ->simplePaginate(5);
                return view('customer.c_implemented',compact('tb'));
            }
        }

        public function c_view_implemented($id_complaint){
            $data = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->join('types_complaint', 'tb_complaint.type_complaint', '=', 'types_complaint.id_complaint')
            ->join('types_status', 'tb_complaint.status', '=', 'types_status.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_project.name',
                        'types_complaint.name_complaint',
                        'tb_complaint.othertype_complaint',
                        'tb_complaint.subject',
                        'tb_complaint.detail',
                        'tb_complaint.complaint_date',
                        'tb_complaint.pickup_date',
                        'tb_complaint.finish_date',
                        'tb_complaint.file',
                        'types_status.name_status',
                        'tb_complaint.note'
                    )
            ->where('tb_complaint.id_complaint', $id_complaint)
            ->get()->toArray();
            if(isset($data[0])){
                $type=$data[0]->name_status;
                switch($type){
                    case"กำลังดำเนินการ":
                        return view('customer.c_view_implemented',['data' => $data,'id_complaint' => $id_complaint]);
                        break;
                    case"ดำเนินการเสร็จสิ้น":
                        return view('customer.c_view_implemented2',['data' => $data,'id_complaint' => $id_complaint]);
                        break;
                }
                
            }
        }

        public function black_implemented(){
            return redirect()->intended('/c_implemented');
        }
}
