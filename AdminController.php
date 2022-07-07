<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;

class AdminController extends Controller
{
// Dashboard
    public function dash_board(){
        $dash_user = DB::table('tb_user')->count();
        $dash_project = DB::table('tb_project')->count();

        Session::put('dash_user',$dash_user);
        Session::put('dash_project',$dash_project);
        return view('admin.a_dashboard');
    }

//จัดการผู้ใช้งาน
    //Customer
        public function manage_customer(){
            $tb = DB::table('tb_customer')
            ->join('types_user', 'tb_customer.types', '=', 'types_user.id')
            ->select(
                        'tb_customer.id',
                        'tb_customer.name',
                        'tb_customer.company',
                        'types_user.name_types',
                        'tb_customer.phone',
                        'tb_customer.email',
                        'tb_customer.user_id'
                    )
            ->simplePaginate(5);
            return view('admin.a_manage_customer',compact('tb'));
        }

        public function search_manage_cus(Request $request){
            $validated = $request->validate(
                [
                    'search_manage_cus' => 'required',
                ],
                [
                    'search_manage_cus.required'=>"*",
                ]
            );
            $search_manage_cus = $request->input('search_manage_cus');
            if($search_manage_cus!=''){
                $tb = DB::table("tb_customer")
                    ->join('types_user', 'tb_customer.types', '=', 'types_user.id')
                    ->select(
                        'tb_customer.id',
                        'tb_customer.name',
                        'tb_customer.company',
                        'types_user.name_types',
                        'tb_customer.phone',
                        'tb_customer.email',
                        'tb_customer.user_id'
                    )
                    ->where('tb_customer.name','LIKE',"%{$search_manage_cus}%")
                    ->orWhere('tb_customer.id','LIKE',"%{$search_manage_cus}%")
                    ->orWhere('tb_customer.email','LIKE',"%{$search_manage_cus}%")
                    ->simplePaginate(5);
                return view('admin.a_manage_customer',compact('tb'));
            }
        }

        public function black_managecustomer(){
            return redirect()->intended('/manage_customer');
        }

        public function addcustomer_data(Request $request)
        {
            $validated = $request->validate(
                [
                    'name' => 'required',
                    'company' => 'required',
                    'phone' => 'required|max:10',
                    'email' => 'required',
                    'password' => 'required'
                ],
                [
                    'name.required'=>"โปรดระบุชื่อ",
                    'company.required'=>"โปรดระบุชื่อบริษัท",
                    'phone.required'=>"โปรดระบุเบอร์โทรศัพท์",
                    'phone.max'=>"ห้ามป้อนเกิน 10 ตัวเลข",
                    'email.required'=>"โปรดระบุอีเมล",
                    'password.required'=>"โปรดระบุ Password"
                ]
            );
            if($validated){
                $insert_user = DB::table("tb_user")->insertGetId(
                    [
                        'email_user' => $request->email,
                        'password_user' => Hash::make($request->password)
                    ]
                );

                $insert = DB::table("tb_customer")->insert([
                    [
                        'name' => $request->name,
                        'company' => $request->company,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'types' => $request->types,
                        'user_id' => $insert_user
                    ]
                ]);

                if($insert){
                    return redirect()->intended('/manage_customer');
                }else{
                    dd("Error");
                }  
            }
        }

        public function edit_customer($id){
            $data = DB::table("tb_customer")->where('id',$id)->get()->toArray();
            return view('admin.a_edit_customer',['data' => $data,'id' => $id]);
        }   
        
        public function update_customer(Request $request, $id){
            $cus = DB::table("tb_customer")->where('id',$id)->get();
            $user = $cus[0]->user_id;

            $updateuser = DB::table("tb_user")->where('id',$user)->update(
                [
                    'email_user' => $request->email
                ]
            );

            $updatedata = DB::table("tb_customer")->where('id', $id)->update(
            [
                'name' => $request->name,
                'company' => $request->company,
                'phone' => $request->phone,
                'email' => $request->email,
                'types' => $request->types,
            ]);
            if($updatedata){
                return redirect()->intended('/manage_customer');
            }else{
                return redirect()->back()->with('no_success',"บันทึกข้อมูลไม่สำเร็จ คูณไม่ได้แก้ไขข้อมูล");
            }
        }

        public function delete_customer($id){
            $cus = DB::table("tb_customer")->where('id',$id)->get();
            $user = $cus[0]->user_id;
            $delete_user = DB::table("tb_user")->where('id',$user)->delete();
            $delete = DB::table("tb_customer")->where('id', $id)->delete();
            return redirect()->intended('/manage_customer');
        }

    //Employee
    public function manage_employee(){
        $tb = DB::table('tb_employee')
            ->join('types_user', 'tb_employee.types', '=', 'types_user.id')
            ->select(
                        'tb_employee.id',
                        'tb_employee.name',
                        'types_user.name_types',
                        'tb_employee.phone',
                        'tb_employee.email',
                        'tb_employee.user_id'
                    )
            ->simplePaginate(5);
        return view('admin.a_manage_employee',compact('tb'));
    }

    public function search_manage_emp(Request $request){
        $validated = $request->validate(
            [
                'search_manage_emp' => 'required',
            ],
            [
                'search_manage_emp.required'=>"*",
            ]
        );
        $search_manage_emp = $request->input('search_manage_emp');
        if($search_manage_emp!=''){
            $tb = DB::table('tb_employee')
                ->join('types_user', 'tb_employee.types', '=', 'types_user.id')
                ->select(
                        'tb_employee.id',
                        'tb_employee.name',
                        'types_user.name_types',
                        'tb_employee.phone',
                        'tb_employee.email',
                        'tb_employee.user_id'
                    )
                ->where('tb_employee.name','LIKE',"%{$search_manage_emp}%")
                ->orWhere('tb_employee.id','LIKE',"%{$search_manage_emp}%")
                ->orWhere('tb_employee.email','LIKE',"%{$search_manage_emp}%")
                ->simplePaginate(5);
            return view('admin.a_manage_employee',compact('tb'));
        }
    }

    public function black_manageemployee(){
        return redirect()->intended('/manage_employee');
    }

    public function addemployee_data(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'phone' => 'required|max:10',
                'email' => 'required',
                'types' => 'required',
                'password' => 'required'
            ],
            [
                'name.required'=>"โปรดระบุชื่อ",
                'phone.required'=>"โปรดระบุเบอร์โทรศัพท์",
                'phone.max'=>"ห้ามป้อนเกิน 10 ตัวเลข",
                'email.required'=>"โปรดระบุอีเมล",
                'types.required'=>"โปรดระบุตำแหน่งงาน",
                'password.required'=>"โปรดระบุ Password"
            ]
        );
        if($validated){
            $insert_user = DB::table("tb_user")->insertGetId(
                [
                    'email_user' => $request->email,
                    'password_user' => Hash::make($request->password)
                ]
            );

            $insert = DB::table("tb_employee")->insert([
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'types' => $request->types,
                    'user_id' => $insert_user
                ]
            ]);

            if($insert){
                return redirect()->intended('/manage_employee');
            }else{
                dd("Error");
            }  
        }
    }

    public function edit_employee($id){
        $data = DB::table("tb_employee")
            ->join('types_user', 'tb_employee.types', '=', 'types_user.id')
            ->select(
                        'tb_employee.*',
                        'types_user.name_types'
                    )
            ->where('tb_employee.id',$id)->get()->toArray();
        return view('admin.a_edit_employee',['data' => $data,'id' => $id]);
    }   
    
    public function update_employee(Request $request, $id){
        $emp = DB::table("tb_employee")->where('id',$id)->get();
        $user = $emp[0]->user_id;

        $updateuser = DB::table("tb_user")->where('id',$user)->update(
            [
                'email_user' => $request->email
            ]
        );

        $updatedata = DB::table("tb_employee")->where('id', $id)->update(
        [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'types' => $request->types,
        ]);
        if($updatedata){
            return redirect()->intended('/manage_employee');
        }else{
            return redirect()->back()->with('no_success',"บันทึกข้อมูลไม่สำเร็จ คุณไม่ได้แก้ไขข้อมูล");
        }
    }

    public function delete_employee($id){
        $emp = DB::table("tb_employee")->where('id',$id)->get();
        $user = $emp[0]->user_id;
        $delete_user = DB::table("tb_user")->where('id',$user)->delete();
        $delete = DB::table("tb_employee")->where('id', $id)->delete();
        return redirect()->intended('/manage_employee');
    }

//จัดการตำแหน่ง
    public function manage_types(){
        $results = DB::select('select * from types_user');
        return view('admin.a_manage_types',compact('results'));
    }

    public function add_types(){
        return view('admin.a_add_types');
    }

    public function black_managetypes(){
        return redirect()->intended('/manage_types');
    }

    public function add_types_data(Request $request){
        $validated = $request->validate(
            [
                'name_types' => 'required',
            ],
            [
                'name_types.required'=>"โปรดระบุชื่อตำแหน่ง",
            ]
        );
        if($validated){
            $insert = DB::table("types_user")->insert([
                [
                    'name_types' => $request->name_types,
                ]
            ]);
            if($insert){
                return redirect()->intended('/manage_types');
            }else{
                dd("Error");
            }
        }
    }

    public function edit_types($id){
        $data = DB::table("types_user")->where('id',$id)->get()->toArray();
        return view('admin.a_edit_types',['data' => $data,'id' => $id]);
    }

    public function update_types(Request $request, $id){
        $updatedata = DB::table("types_user")->where('id', $id)->update(
        [
            'name_types' => $request->name_types,
        ]);
        if($updatedata){
            return redirect()->intended('/manage_types');
        }else{
            return redirect()->back()->with('no_success',"บันทึกข้อมูลไม่สำเร็จ คุณไม่ได้แก้ไขข้อมูล");
        }
    }

    public function delete_types($id_types){
        $delete = DB::table("types_user")->where('id', $id)->delete();
        return redirect()->intended('/manage_types');
    }

//จัดการ Project
    public function manage_project(){
        $results = DB::table('tb_project')->simplePaginate(5);
        $cus = DB::table('tb_customer')->get();
        $empsup = DB::table('tb_employee')->where('types','=','1')->get();
        $emppro = DB::table('tb_employee')->where('types','=','2')->get();
        return view('admin.a_manage_project',compact('results','empsup','emppro','cus'));
    }

    public function add_project_data(Request $request){
        $validated = $request->validate(
            [
                'name' => 'required',
                'id_customer' => 'required',
                'id_support' => 'required',
                'id_programmer' => 'required'
            ],
            [
                'name.required'=>"โปรดระบุชื่อ Project",
                'id_customer.required'=>"โปรดระบุชื่อ ID Customer",
                'id_support.required'=>"โปรดระบุชื่อ ID Support",
                'id_programmer.required'=>"โปรดระบุชื่อ ID Programmer"
            ]
        );
        $insert = DB::table("tb_project")->insert([
            [
                'name' => $request->name,
                'id_customer' => $request->id_customer,
                'id_support' => $request->id_support,
                'id_programmer' => $request->id_programmer
            ]
        ]);
        if($insert){
            return redirect()->intended('/manage_project');
        }else{
            dd("Error");
        }
    }

    public function black_manageproject(){
        return redirect()->intended('/manage_project');
    }

    public function edit_project($id){
        $data = DB::table("tb_project")->where('id',$id)->get()->toArray();
        $cus = DB::table('tb_customer')->get();
        $empsup = DB::table('tb_employee')->where('types','=','1')->get();
        $emppro = DB::table('tb_employee')->where('types','=','2')->get();
        return view('admin.a_edit_project',['data' => $data,'id' => $id],compact('empsup','emppro','cus'));
    }

    public function update_project(Request $request, $id){
        $updatedata = DB::table("tb_project")->where('id', $id)->update(
        [
            'name' => $request->name,
            'id_customer' => $request->id_customer,
            'id_support' => $request->id_support,
            'id_programmer' => $request->id_programmer
        ]);
        if($updatedata){
            return redirect()->intended('/manage_project');
        }else{
            return redirect()->back()->with('no_success',"บันทึกข้อมูลไม่สำเร็จ คุณไม่ได้แก้ไขข้อมูล");
        }
    }

    public function delete_project($id){
        $d_complaint = DB::table("tb_complaint")->where('id_project', $id)->delete();
        if(isset($d_complaint)){
            $delete = DB::table("tb_project")->where('id', $id)->delete();
            return redirect()->intended('/manage_project');
        }else{
            dd("ไม่สามารถลบได้");
        }
            
        
    }

    public function search_project(Request $request){
        $validated = $request->validate(
            [
                'search_pro' => 'required',
            ],
            [
                'search_pro.required'=>"*",
            ]
        );
        $search_pro = $request->input('search_pro');
        if($search_pro!=''){
            $results = DB::table("tb_project")
                ->where('name','LIKE',"%{$search_pro}%")
                ->simplePaginate(5);
            $cus = DB::table('tb_customer')->get();
            $empsup = DB::table('tb_employee')->where('types','=','1')->get();
            $emppro = DB::table('tb_employee')->where('types','=','2')->get();
            return view('admin.a_manage_project',compact('results','cus','empsup','emppro'));
        }
    }

//จัดการประเภทร้องเรียน
    public function manage_complaint(){
        $results = DB::select('select * from types_complaint');
        return view('admin.a_manage_complaint',compact('results'));
    }

    public function add_complaint(){
        return view('admin.a_add_complaint');
    }

    public function add_complaint_data(Request $request){
        $validated = $request->validate(
            [
                'name_complaint' => 'required'
            ],
            [
                'name_complaint.required'=>"โปรดระบุชื่อ"
            ]
        );
        if($validated){
            $insert = DB::table("types_complaint")->insert([
                [
                    'name_complaint' => $request->name_complaint
                ]
            ]);
            if(isset($insert)){
                return redirect()->intended('/manage_complaint');
            }else{
                dd("Error");
            }
        }
    }

    public function black_managecomplaint(){
        return redirect()->intended('/manage_complaint');
    }

    public function edit_complaint($id_complaint){
        $data = DB::table("types_complaint")->where('id_complaint',$id_complaint)->get()->toArray();
        return view('admin.a_edit_complaint',['data' => $data,'id_complaint' => $id_complaint]);
    }

    public function update_complaint(Request $request, $id_complaint){
        $updatedata = DB::table("types_complaint")->where('id_complaint', $id_complaint)->update(
        [
            'name_complaint' => $request->name_complaint
        ]);
        if($updatedata){
            return redirect()->intended('/manage_complaint');
        }else{
            return redirect()->back()->with('no_success',"บันทึกข้อมูลไม่สำเร็จ คุณไม่ได้แก้ไขข้อมูล");
        }
    }

    public function delete_complaint($id_complaint){
        $delete = DB::table("types_complaint")->where('id_complaint', $id_complaint)->delete();
        return redirect()->intended('/manage_complaint');
    }
}
