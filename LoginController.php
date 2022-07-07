<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Session;

class LoginController extends Controller
{
    public function login(Request $request){
        $id="";
        $validated = $request->validate(
            [
                'username' => 'required',
                'password' => 'required|max:30',
            ],
            [
                'username.required'=>"*",
                'password.required'=>"*",
            ]
        );
        $sql = DB::table('tb_user')
            ->where('email_user',$request->username)
            ->get()
            ->toArray();
        // $hashed = Hash::make($request->password);
        // dd($hashed);
        if($sql){
            if (Hash::check($request->password, $sql[0]->password_user)){
                if(isset($sql[0])){
                    $id=$sql[0]->id;
                }
                if($id!=""){
                    $is_customer=true;
                    $is_login=false;
                    $sql_emp = DB::table('tb_employee')
                    ->join('types_user', 'tb_employee.types', '=', 'types_user.id')
                    ->where('user_id',$id)
                    ->select(
                                'tb_employee.id',
                                'tb_employee.name',
                                'tb_employee.email',
                                'types_user.name_types',
                                'tb_employee.phone',
                                'tb_employee.user_id'
                            )
                    ->get()
                    ->toArray();
                    $sql_cus = DB::table('tb_customer')
                    ->join('types_user', 'tb_customer.types', '=', 'types_user.id')
                    ->where('user_id',$id)
                    ->select(
                        'tb_customer.id',
                        'tb_customer.name',
                        'tb_customer.company',
                        'types_user.name_types',
                        'tb_customer.phone',
                        'tb_customer.email',
                        'tb_customer.user_id'
                    )
                    ->get()
                    ->toArray();
                    if(isset($sql_emp[0])){
                        $is_customer=false;
                        $is_login=true;
                        $type=$sql_emp[0]->name_types;
                        switch ($type){
                            case 'Support' : 
                                Session::put('id_user',$sql[0]->id);
                                Session::put('name',$sql_emp[0]->name);
                                Session::put('name_types',$sql_emp[0]->name_types);
                                Session::put('id',$sql_emp[0]->id);
                                return redirect()->intended('e_support_dashboard');
                                break;
                            case 'Programmer' : 
                                Session::put('id_user',$sql[0]->id);
                                Session::put('name',$sql_emp[0]->name);
                                Session::put('name_types',$sql_emp[0]->name_types);
                                Session::put('id',$sql_emp[0]->id);
                                return redirect()->intended('e_programmer_dashboard');
                                break;
                            case 'Admin' : 
                                Session::put('id_user',$sql[0]->id);
                                Session::put('name',$sql_emp[0]->name);
                                return redirect()->intended('a_dashboard');
                                break;
                            default :
                                break;
                        }
                    }
                    if(isset($sql_cus[0])){
                        $is_customer=true;
                        $is_login=true;
                        $type=$sql_cus[0]->name_types;
                        switch ($type){
                            case 'Customer' : 
                                Session::put('id_user',$sql[0]->id);
                                Session::put('name',$sql_cus[0]->name);
                                Session::put('company',$sql_cus[0]->company);
                                Session::put('id',$sql_cus[0]->id);
                                Session::put('name_types',$sql_cus[0]->name_types);
                                return redirect()->intended('c_dashboard');
                                break;
                        }
                    }
                }
                else {
                    return redirect()->back()->with('no_success',"เกิดข้อผิดพลาด โปรดแจ้งเจ้าหน้าที่");
                }
            }
            else {
                return redirect()->back()->with('no_success',"รหัสผ่านไม่ถูกต้อง");
            }
        }
        else {
            return redirect()->back()->with('no_success',"ไม่มีบัญชีผู้ใช้นี้อยู่ในระบบ");
        }
    }

    public function log_out(){
        Session::flush();
        return redirect('/');
    }
}
        