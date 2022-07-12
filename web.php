<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

// login logout
Route::post('/login',[LoginController::class,'login']);
Route::get('/logout',[LoginController::class,'log_out']);

Route::middleware(['check'])->group(function(){
    //Customer
    Route::get('/c_dashboard',[CustomerController::class,'dash_board']);
    
    Route::get('/c_view_new/{id}',[CustomerController::class,'ep_viewnew']);
        //รายการที่ยังไม่ได้ดำเนินการ
        Route::get('/c_not_implemented',[CustomerController::class,'not_implemented']);
        Route::post('/add_complaintdata',[CustomerController::class,'add_complaintdata']);
        Route::get('/c_view_n-implemented/{id_complaint}',[CustomerController::class,'c_view_nimplemented']);
        Route::get('/c_edit/{id_complaint}',[CustomerController::class,'edit']);
        Route::get('/c_black_not_implemented',[CustomerController::class,'black_not_implemented']);
        Route::post('/c_update_complaint/{id_complaint}',[CustomerController::class,'update_complaint']);
        Route::get('/delete_c_complaint/{id_complaint}',[CustomerController::class,'delete_complaint']);
        Route::post('/addstatus/{id_complaint}',[CustomerController::class,'addstatus']);
        Route::get('/search_not_implemented',[CustomerController::class,'search_not_implemented']);

        //รายการที่ยังไม่ได้ดำเนินการ
        Route::get('/c_implemented',[CustomerController::class,'implemented']);
        Route::get('/c_view_implemented/{id_complaint}',[CustomerController::class,'c_view_implemented']);
        Route::get('/c_black_implemented',[CustomerController::class,'black_implemented']);
        Route::get('/search_implemented',[CustomerController::class,'search_implemented']);

    // Employee //
    //support
    Route::get('/e_support_dashboard',[EmployeeController::class,'e_support_dash_board']);
        //รายการร้องเรียน
        Route::get('/es_implemented',[EmployeeController::class,'es_implemented']);
        Route::get('/es_view_newimplemented/{id}',[EmployeeController::class,'es_viewnewimplemented']);
        Route::get('/es_view_implemented/{id_complaint}',[EmployeeController::class,'es_viewimplemented']);
        Route::post('/forward_pgm/{id_complaint}',[EmployeeController::class,'forward_pgm']);
        Route::post('/bounce_data/{id_complaint}',[EmployeeController::class,'bounce_data']);
        Route::get('/es_black_implemented',[EmployeeController::class,'es_blackimplemented']);
        Route::get('/es_search_implemented',[EmployeeController::class,'es_search_implemented']);

        //รายการที่กำลังดำเนินการ
        Route::get('/es_in_progress',[EmployeeController::class,'es_inprogress']);
        Route::get('/es_view_inprogress/{id_complaint}',[EmployeeController::class,'es_viewinprogress']);
        Route::get('/es_black_inprogress',[EmployeeController::class,'es_blackinprogress']);
        Route::get('/es_search_inprogress',[EmployeeController::class,'es_search_inprogress']);

        //รายการที่ดำเนินการเสร็จสิ้น
        Route::get('/es_finish',[EmployeeController::class,'es_finish']);
        Route::get('/es_view_finish/{id_complaint}',[EmployeeController::class,'es_viewfinish']);
        Route::get('/es_black_finish',[EmployeeController::class,'es_blackfinish']);
        Route::get('/es_search_finish',[EmployeeController::class,'es_search_finish']);

    //programmer
    Route::get('/e_programmer_dashboard',[EmployeeController::class,'e_programmer_dash_board']);
        //รายการร้องเรียนที่ต้องดำเนินการ
        Route::get('/ep_in_progress',[EmployeeController::class,'ep_inprogress']);
        Route::get('/ep_view_newinprogress/{id}',[EmployeeController::class,'ep_viewnewinprogress']);
        Route::get('/ep_view_inprogress/{id_complaint}',[EmployeeController::class,'ep_viewinprogress']);
        Route::post('/ep_finish_inprogress/{id_complaint}',[EmployeeController::class,'ep_finish_inprogress']);
        Route::get('/ep_black_inprogress',[EmployeeController::class,'ep_blackinprogress']);
        Route::get('/ep_search_inprogress',[EmployeeController::class,'ep_search_inprogress']);

        //รายการที่ดำเนินการเสร็จสิ้น
        Route::get('/ep_finish',[EmployeeController::class,'ep_finish']);
        Route::get('/ep_view_finish/{id_complaint}',[EmployeeController::class,'ep_viewfinish']);
        Route::get('/ep_black_finish',[EmployeeController::class,'ep_blackfinish']);
        Route::get('/ep_search_finish',[EmployeeController::class,'ep_search_finish']);


    //Admin
    Route::get('/a_dashboard',[AdminController::class,'dash_board']);
        //จัดการผู้ใช้งาน
            //Customer
            Route::get('/manage_customer',[AdminController::class,'manage_customer']);
            Route::post('/add_customer_data',[AdminController::class,'addcustomer_data']);
            Route::get('/black_manage_customer',[AdminController::class,'black_managecustomer']);
            Route::get('/edit_customer/{id_member}',[AdminController::class,'edit_customer']);
            Route::post('/update_customer/{id_member}',[AdminController::class,'update_customer']);
            Route::get('/delete_customer/{id_member}',[AdminController::class,'delete_customer']);
            Route::get('/search_manage_cus',[AdminController::class,'search_manage_cus']);

            //Employee
            Route::get('/manage_employee',[AdminController::class,'manage_employee']);
            Route::post('/add_employee_data',[AdminController::class,'addemployee_data']);
            Route::get('/black_manage_employee',[AdminController::class,'black_manageemployee']);
            Route::get('/edit_employee/{id_member}',[AdminController::class,'edit_employee']);
            Route::post('/update_employee/{id_member}',[AdminController::class,'update_employee']);
            Route::get('/delete_employee/{id_member}',[AdminController::class,'delete_employee']);
            Route::get('/search_manage_emp',[AdminController::class,'search_manage_emp']);


        //จัดการตำแหน่ง
        Route::get('/manage_types',[AdminController::class,'manage_types']);
        Route::post('/add_types_data',[AdminController::class,'add_types_data']);
        Route::get('/black_manage_types',[AdminController::class,'black_managetypes']);
        Route::get('/edit_types/{id_types}',[AdminController::class,'edit_types']);
        Route::post('/update_types/{id_types}',[AdminController::class,'update_types']);
        Route::get('/delete_types/{id_types}',[AdminController::class,'delete_types']);

        //จัดการ Project
        Route::get('/manage_project',[AdminController::class,'manage_project']);
        Route::post('/add_project_data',[AdminController::class,'add_project_data']);
        Route::get('/black_manage_project',[AdminController::class,'black_manageproject']);
        Route::get('/edit_project/{id_project}',[AdminController::class,'edit_project']);
        Route::post('/update_project/{id_project}',[AdminController::class,'update_project']);
        Route::get('/delete_project/{id_project}',[AdminController::class,'delete_project']);
        Route::get('/search_project',[AdminController::class,'search_project']);

        //จัดการประเภทร้องเรียน
        Route::get('/manage_complaint',[AdminController::class,'manage_complaint']);
        Route::post('/add_complaint_data',[AdminController::class,'add_complaint_data']);
        Route::get('/black_manage_complaint',[AdminController::class,'black_managecomplaint']);
        Route::get('/edit_complaint/{id_complaint}',[AdminController::class,'edit_complaint']);
        Route::post('/update_complaint/{id_complaint}',[AdminController::class,'update_complaint']);
        Route::get('/delete_complaint/{id_complaint}',[AdminController::class,'delete_complaint']);   
});