<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class EmployeeController extends Controller
{
    //Support
    public function e_support_dash_board(){
        $dash_two = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->where('tb_project.id_support', '=', session('id'))->whereIn('status',[2])->count();
        $dash_three = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->where('tb_project.id_support', '=', session('id'))->whereIn('status',[3])->count();
        $dash_four = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->where('tb_project.id_support', '=', session('id'))->whereIn('status',[4])->count();
        
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

        return view('support.e_support_dashboard');
    }

    //รายการร้องเรียนใหม่ (กระดิ่ง)
    public function es_viewnewimplemented($id){
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
                return view('support.es_view_implemented',['data' => $data,'id_complaint' => $id_complaint]);
        }else{
            return redirect()->intended('e_support_dashboard');
        } 
    }

        //รายการร้องเรียน
        public function es_implemented(){
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
                        'types_status.name_status'
                    )
            ->where('tb_project.id_support', '=', session('id'))
            ->whereIn('status',[2])->simplePaginate(5);
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
            return view('support.es_implemented',compact('tb'));
        }

        public function es_search_implemented(Request $request){
            $validated = $request->validate(
                [
                    'es_search_implemented' => 'required',
                ],
                [
                    'es_search_implemented.required'=>"*",
                ]
            );
            $es_search_implemented = $request->input('es_search_implemented');
            if($es_search_implemented!=''){
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
                                'types_status.name_status'
                            )
                    ->where('tb_project.id_support', '=', session('id'))
                    ->whereIn('status',[2])
                    ->where('tb_project.name','LIKE',"%{$es_search_implemented}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$es_search_implemented}%")
                    ->simplePaginate(5);
                return view('support.es_implemented',compact('tb'));
            }
        }

        public function es_viewimplemented($id_complaint){
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
                        'types_status.name_status',
                        'tb_complaint.note'
                    )
            ->where('tb_complaint.id_complaint', $id_complaint)
            ->get()->toArray();
            return view('support.es_view_implemented',['data' => $data,'id_complaint' => $id_complaint]);
        }

        public function bounce_data(Request $request, $id_complaint){
            $validated = $request->validate(
                [
                    'note' => 'required',
                    'pickup_date' => 'required',
                    'finish_date' => 'required'
                ],
                [
                    'note.required'=>"*กรุณาระบุหมายเหตุ",
                    'pickup_date.required'=>"*กรุณาระบุวันที่ตีกลับ",
                    'finish_date.required'=>"*กรุณาระบุวันที่ปิดงาน"
                ]
            );
            $complaint = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_complaint.id_project',
                        'tb_project.id_programmer',
                        'tb_project.id_customer'
                    )
            ->where('id_complaint', $id_complaint)->get();

            $id_cus = $complaint[0]->id_customer;
            $tb_cus = DB::table('tb_customer')->where('id', $id_cus)->get();
            $user_id_cus = $tb_cus[0]->user_id;

            $project_id = $complaint[0]->id_project;
            $complaint_id = $complaint[0]->id_complaint;

            if($validated){
                $insert = DB::table("tb_complaint")->where('id_complaint', $id_complaint)->update(
                    [
                        'status' => $request->status,
                        'note' => $request->note,
                        'pickup_date' => $request->pickup_date,
                        'finish_date' => $request->finish_date
                    ]
                );
                if($insert){
                    $insert_noti = DB::table("tb_noti")->insert([
                        [
                            'project_id' => $project_id,
                            'user_id' => $user_id_cus,
                            'message' => $request->message,
                            'is_read' => $request->is_read,
                            'complaint_id' => $complaint_id,
                        ]
                        ]);
                    return redirect()->intended('/es_implemented');
                }else{
                    dd("Error");
                } 
            }
        }

        public function forward_pgm(Request $request, $id_complaint){
            $validated = $request->validate(
                [
                    'pickup_date' => 'required',
                ],
                [
                    'pickup_date.required'=>"*กรุณาระบุวันที่รับเรื่อง",
                ]
            );
            $complaint = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_complaint.id_project',
                        'tb_project.id_programmer',
                        'tb_project.id_customer'
                    )
            ->where('id_complaint', $id_complaint)->get();

            $id_pro = $complaint[0]->id_programmer;
            $tb_pro = DB::table('tb_employee')->where('id', $id_pro)->get();
            $user_id_pro = $tb_pro[0]->user_id;

            $id_cus = $complaint[0]->id_customer;
            $tb_cus = DB::table('tb_customer')->where('id', $id_cus)->get();
            $user_id_cus = $tb_cus[0]->user_id;

            $project_id = $complaint[0]->id_project;
            $complaint_id = $complaint[0]->id_complaint;

            if($validated){
                $insert = DB::table("tb_complaint")->where('id_complaint', $id_complaint)->update(
                    [
                        'status' => $request->status,
                        'pickup_date' => $request->pickup_date,
                    ]
                );
                if($insert){
                    $insert_noti1 = DB::table("tb_noti")->insert([
                        [
                            'project_id' => $project_id,
                            'user_id' => $user_id_pro,
                            'message' => $request->message1,
                            'is_read' => $request->is_read,
                            'complaint_id' => $complaint_id,
                        ]
                        ]);
                    $insert_noti2 = DB::table("tb_noti")->insert([
                        [
                            'project_id' => $project_id,
                            'user_id' => $user_id_cus,
                            'message' => $request->message2,
                            'is_read' => $request->is_read,
                            'complaint_id' => $complaint_id,
                        ]
                        ]);
                    return redirect()->intended('/es_implemented');
                }else{
                    dd("Error");
                } 
            }
        }

        public function es_blackimplemented(){
            return redirect()->intended('/es_implemented');
        }

        //รายการที่กำลังดำเนินการ
        public function es_inprogress(){
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
                        'tb_complaint.pickup_date',
                        'tb_complaint.file',
                        'types_status.name_status'
                    )
            ->where('tb_project.id_support', '=', session('id'))
            ->whereIn('status',[3])->simplePaginate(5);
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
            return view('support.es_in_progress',compact('tb'));
        }

        public function es_search_inprogress(Request $request){
            $validated = $request->validate(
                [
                    'es_search_inprogress' => 'required',
                ],
                [
                    'es_search_inprogress.required'=>"*",
                ]
            );
            $es_search_inprogress = $request->input('es_search_inprogress');
            if($es_search_inprogress!=''){
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
                                'types_status.name_status'
                            )
                    ->where('tb_project.id_support', '=', session('id'))
                    ->whereIn('status',[3])
                    ->where('tb_project.name','LIKE',"%{$es_search_inprogress}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$es_search_inprogress}%")
                    ->simplePaginate(5);
                return view('support.es_in_progress',compact('tb'));
            }
        }

        public function es_viewinprogress($id_complaint){
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
                        'tb_complaint.file',
                        'types_status.name_status',
                        'tb_complaint.note'
                    )
            ->where('tb_complaint.id_complaint', $id_complaint)
            ->get()->toArray();
            return view('support.es_view_inprogress',['data' => $data,'id_complaint' => $id_complaint]);
        }

        public function es_blackinprogress(){
            return redirect()->intended('/es_in_progress');
        }

        //รายการที่ดำเนินการเสร็จสิ้น
        public function es_finish(){
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
                        'tb_complaint.pickup_date',
                        'tb_complaint.finish_date',
                        'tb_complaint.file',
                        'types_status.name_status',
                        'tb_complaint.note'
                    )
            ->where('tb_project.id_support', '=', session('id'))
            ->whereIn('status',[4])->simplePaginate(5);
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
            return view('support.es_finish',compact('tb'));
        }

        public function es_search_finish(Request $request){
            $validated = $request->validate(
                [
                    'es_search_finish' => 'required',
                ],
                [
                    'es_search_finish.required'=>"*",
                ]
            );
            $es_search_finish = $request->input('es_search_finish');
            if($es_search_finish!=''){
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
                                'tb_complaint.pickup_date',
                                'tb_complaint.finish_date',
                                'tb_complaint.file',
                                'types_status.name_status',
                                'tb_complaint.note'
                            )
                    ->where('tb_project.id_support', '=', session('id'))
                    ->whereIn('status',[4])
                    ->where('tb_project.name','LIKE',"%{$es_search_finish}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$es_search_finish}%")
                    ->simplePaginate(5);
                return view('support.es_finish',compact('tb'));
            }
        }

        public function es_viewfinish($id_complaint){
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
            return view('support.es_view_finish',['data' => $data,'id_complaint' => $id_complaint]);
        }

        public function es_blackfinish(){
            return redirect()->intended('/es_finish');
        }


    //Programmer
    public function e_programmer_dash_board(){
        $dash_three = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
        ->where('tb_project.id_programmer', '=', session('id'))->whereIn('status',[3])->count();
        $dash_four = DB::table('tb_complaint')->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
        ->where('tb_project.id_programmer', '=', session('id'))->whereIn('status',[4])->count();

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

        return view('programmer.e_programmer_dashboard');
    }

    //รายการร้องเรียนใหม่ (กระดิ่ง)
    public function ep_viewnewinprogress($id){
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
                            'types_status.name_status'
                        )
                ->where('tb_complaint.id_complaint', $id_complaint)
                ->get()->toArray();
                $delete = DB::table("tb_noti")->where('id', $id)->delete();
                return view('programmer.ep_view_inprogress',['data' => $data,'id_complaint' => $id_complaint]);
        }else{
            return redirect()->intended('e_programmer_dashboard');
        } 
    }

        //รายการร้องเรียน
        public function ep_inprogress(){
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
                        'tb_complaint.pickup_date',
                        'tb_complaint.file',
                        'types_status.name_status'
                    )
            ->where('tb_project.id_programmer', '=', session('id'))
            ->whereIn('status',[3])->simplePaginate(5);
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
            return view('programmer.ep_in_progress',compact('tb'));
        }

        public function ep_search_inprogress(Request $request){
            $validated = $request->validate(
                [
                    'ep_search_inprogress' => 'required',
                ],
                [
                    'ep_search_inprogress.required'=>"*",
                ]
            );
            $ep_search_inprogress = $request->input('ep_search_inprogress');
            if($ep_search_inprogress!=''){
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
                                'tb_complaint.pickup_date',
                                'tb_complaint.file',
                                'types_status.name_status'
                            )
                    ->where('tb_project.id_programmer', '=', session('id'))
                    ->whereIn('status',[3])
                    ->where('tb_project.name','LIKE',"%{$ep_search_inprogress}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$ep_search_inprogress}%")
                    ->simplePaginate(5);
                return view('programmer.ep_in_progress',compact('tb'));
            }
        }

        public function ep_viewinprogress($id_complaint){
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
                        'types_status.name_status'
                    )
            ->where('tb_complaint.id_complaint', $id_complaint)
            ->get()->toArray();
            return view('programmer.ep_view_inprogress',['data' => $data,'id_complaint' => $id_complaint]);
        }

        public function ep_finish_inprogress(Request $request, $id_complaint){
            $validated = $request->validate(
                [
                    'note' => 'required',
                    'finish_date' => 'required'
                ],
                [
                    'note.required'=>"*กรุณาระบุหมายเหตุ",
                    'finish_date.required'=>"*กรุณาระบุวันที่ปิดงาน"
                ]
            );
            $complaint = DB::table('tb_complaint')
            ->join('tb_project', 'tb_complaint.id_project', '=', 'tb_project.id')
            ->select(
                        'tb_complaint.id_complaint',
                        'tb_complaint.id_project',
                        'tb_project.id_support',
                        'tb_project.id_customer'
                    )
            ->where('id_complaint', $id_complaint)->get();

            $id_sup = $complaint[0]->id_support;
            $tb_sup = DB::table('tb_employee')->where('id', $id_sup)->get();
            $user_id_sup = $tb_sup[0]->user_id;

            $id_cus = $complaint[0]->id_customer;
            $tb_cus = DB::table('tb_customer')->where('id', $id_cus)->get();
            $user_id_cus = $tb_cus[0]->user_id;

            $project_id = $complaint[0]->id_project;
            $complaint_id = $complaint[0]->id_complaint;

            if($validated){
                $insert = DB::table("tb_complaint")->where('id_complaint', $id_complaint)->update(
                    [
                        'status' => $request->status,
                        'note' => $request->note,
                        'finish_date' => $request->finish_date
                    ]
                );
                if($insert){
                    $insert_noti1 = DB::table("tb_noti")->insert([
                        [
                            'project_id' => $project_id,
                            'user_id' => $user_id_cus,
                            'message' => $request->message,
                            'is_read' => $request->is_read,
                            'complaint_id' => $complaint_id,
                        ]
                        ]);
                    $insert_noti2 = DB::table("tb_noti")->insert([
                        [
                            'project_id' => $project_id,
                            'user_id' => $user_id_sup,
                            'message' => $request->message,
                            'is_read' => $request->is_read,
                            'complaint_id' => $complaint_id,
                        ]
                        ]);
                    return redirect()->intended('/ep_in_progress');
                }else{
                    dd("Error");
                } 
            }
        }
        
        public function ep_blackinprogress(){
            return redirect()->intended('/ep_in_progress');
        }

        //รายการร้องเรียนที่ดำเนินการเสร็จสิ้น
        public function ep_finish(){
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
                        'tb_complaint.pickup_date',
                        'tb_complaint.finish_date',
                        'tb_complaint.file',
                        'types_status.name_status',
                        'tb_complaint.note'
                    )
            ->where('tb_project.id_programmer', '=', session('id'))
            ->whereIn('status',[4])->simplePaginate(5);
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
            return view('programmer.ep_finish',compact('tb'));
        }

        public function ep_search_finish(Request $request){
            $validated = $request->validate(
                [
                    'ep_search_finish' => 'required',
                ],
                [
                    'ep_search_finish.required'=>"*",
                ]
            );
            $ep_search_finish = $request->input('ep_search_finish');
            if($ep_search_finish!=''){
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
                                'tb_complaint.pickup_date',
                                'tb_complaint.finish_date',
                                'tb_complaint.file',
                                'types_status.name_status',
                                'tb_complaint.note'
                            )
                    ->where('tb_project.id_programmer', '=', session('id'))
                    ->whereIn('status',[4])
                    ->where('tb_project.name','LIKE',"%{$ep_search_finish}%")
                    ->orWhere('tb_complaint.subject','LIKE',"%{$ep_search_finish}%")
                    ->simplePaginate(5);
                return view('programmer.ep_finish',compact('tb'));
            }
        }

        public function ep_viewfinish($id_complaint){
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
            return view('programmer.ep_view_finish',['data' => $data,'id_complaint' => $id_complaint]);
        }
        
        public function ep_blackfinish(){
            return redirect()->intended('/ep_finish');
        }

}
