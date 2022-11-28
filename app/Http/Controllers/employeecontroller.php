<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use App\Models\employee;
use App\Models\attendance;
Use Hash;
Use Callback;
Use DB;
use Carbon\Carbon;

class employeecontroller extends Controller
{
    //
    function empl_add(){
        if(session()->has('logid')){
            $admin=admin::where('id',session()->get('logid'))->first();
            return view('pages.laravel-examples.emp_add');
        }
    }

    function emp_add(Request $req){
        $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:10|max:10',
            'role' => 'required|min:5|max:255',
            'password' => 'required|min:8',

        ]);

        $emp=new employee;
        $emp->name=$req->name;
        $emp->email=$req->email;
        $emp->phone=$req->phone;
        $emp->role=$req->role;
        $emp->password=Hash::make($req->password);
        $emp->save();
        return redirect('/user-management');

    }

    function emp_del($id){
        employee::where('id',$id)->delete();
        return redirect('/user-management');
    }

    function emp_upd($id){

        $emp= employee::where('id',$id)->get();
        if(session()->has('logid')){
           return view('pages.laravel-examples.emp_upd',compact('emp'));
        }
        else{
            return view('pages.laravel-examples.emp_auto_upd',compact('emp'));
        }
    }

    function employee_updates(Request $req,$id){
        $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'role' => 'required|min:5|max:255',
        ]);


        $emp=employee::where('id',$id)->update([
            'name'=>$req->name,
            'email'=>$req->email,
            'phone'=>$req->phone,
            'role'=>$req->role,
        ]); 

        return redirect('/emp_dash');
    }

    function employee_updated(Request $req,$id){
        $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'role' => 'required|min:5|max:255',
        ]);


        $emp=employee::where('id',$id)->update([
            'name'=>$req->name,
            'email'=>$req->email,
            'phone'=>$req->phone,
            'role'=>$req->role,
        ]); 

        return redirect('/user-management');

    }
    

    function view_signin(){
        return view('pages.laravel-examples.emp_signin');
    }

    function signin_emp(Request $req){
        $req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $emp=employee::where('email','=',$req->email)->first();
        if($emp){
            if(Hash::check($req->password,$emp->password)){
                $req->session()->put('emp_logid',$emp->id);
                // echo "fsdsd";
                return redirect('/emp_dash');
            }
            else{
                return redirect('/signin_emp');
    
            }
        }
        else{
            return redirect('/signin_emp');

        }
        
    }

    function emp_logout(){
        if(session()->has('emp_logid')){
            session()->pull('emp_logid');
            return redirect('/signin_emp');
        }
    }

    function emp_dash(){
        // $now = new DateTime();
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i:s');
        $emp=employee::where('id',session()->get('emp_logid'))->get();
        return view('pages.laravel-examples.emp_dash',compact('emp','date','time'));
    }

    function add_attendance(Request $req,$id){

        $req->validate([
            'password'=>'required',
            'status'=>'required'
        ]);

        $emp=employee::where('id',$id)->get();
        if($emp){
            if(Hash::check($req->password,$emp[0]->password)){
                    if($req->status=='clock_in'){
                        $attend=new attendance;
                        $attend->employee_name=$emp[0]->name;
                        $attend->Date=$req->date;
                        $attend->Clock_in=$req->time;
                        $attend->eid=$req->eid;
                        $attend->save();
                        return redirect('emp_dash');
                    }
                    elseif($req->status=='lunch_in'){
                        $attend= attendance::where('date',$req->date)->where('employee_name',$emp[0]->name)->update([ 
                      
                        'Lunch_in'=>$req->time
                        ]);
                        return redirect('emp_dash');
                    }                    
                    elseif($req->status=='lunch_out'){
                        $attend= attendance::where('date',$req->date)->where('employee_name',$emp[0]->name)->update([ 
                     
                        'Lunch_out'=>$req->time
                        ]);
                        return redirect('emp_dash');
                    }                    
                    elseif($req->status=='clock_out'){
                        $attend= attendance::where('date',$req->date)->where('employee_name',$emp[0]->name)->update([ 
                  
                        'Clock_out'=>$req->time
                        ]);
                        return redirect('emp_dash');
                    }                    
            }
            else{
                return redirect('emp_dash');
            }
        }
        else{
            return redirect('emp_dash');
        }
    }

    
    function emp_profile(){
       $emp= employee::where('id',session()->get('emp_logid'))->get();
       $id= $emp[0]->id;
       return redirect('/emp_upd/'.$id.'');
    }


    function schedule(){
      
        // echo $e;
        // $revenueLastMonth = Callback::whereBetween('created_at',[$fromDate,$tillDate])->get();
        // echo $fromDate;
        // echo $tillDate;

        // $date = Carbon::now();
        // $lastMonth = $date->subMonth()->format('F'); // August.
        // dd($lastMonth);
 
        // echo $revenueLastMonth;
        // $users = attendance::whereMonth('date', '=', Carbon::now()->subMonth()->startOfMonth()->toDateString())->get();
        // $revenueMonth = Callback::where('created_at', '>=', Carbon::today()->startOfMonth()->subMonth())->get();

        // echo $users;
        // echo $revenueMonth;
        // $revenueMonth = Callback::whereMonth(
        //     'date', '=', Carbon::now()->subMonth()->month
        // );
        // echo $revenueMonth;
        // $prev= Carbon::now()->subMonth()->month;
        // echo $prev;
        // $lastMonth =  Carbon::now()->subMonth()->format('M'); // 11
        // // echo $lastMonth;
        // $monthy = Carbon::now()->format('M-Y');
        $months = Carbon::now()->format('d-m-Y');
        $monthdigit = Carbon::now()->format('M');
        // echo session()->get('emp_logid');
        // echo $months;
        
        // echo date($months);
        $month=substr($months,3);
        // echo $fistdt;
        $firstdate='01-'.$month;
            // echo $firstdate;
       $lastdt=date('t',strtotime($months));
       $lastdate=$lastdt.'-'.$month;
    //    echo $lastdate;
        $empA=attendance::where('eid',session()->get('emp_logid'))->whereBetween('Date',[$firstdate,$lastdate])->get();
        return view('pages.laravel-examples.schedule',compact('empA','monthdigit'));
    }


    // function prev(){
    //     $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
    //     $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
    //     // $currmonth = Carbon::now()->format('m');
    //     // $currmonth--;
    //     // $prevmonth=Carbon::now()->format('d-'.$currmonth.'-Y');
    //     // echo $prevmonth;
    //     $monthdigit = Carbon::now()->subMonth()->format('M');
    //     $emp= attendance::where('eid',session()->get('emp_logid'))->where('date','>=',$fromDate)->where('date','<=',$tillDate)->get();




    //     // $emp= attendance::where('eid',session()->get('emp_logid'))->where('date','>=',$prevmonth)->where('date','<=',$prevmonth)->get();
    //     // echo $emp;
    //     return view('pages.laravel-examples.schedule',compact('emp','monthdigit')); 
        
        
    // }

    // function next(){
    //     $fromDate = Carbon::now()->subMonth()->startOfMonth()->toDateString();
    //     $tillDate = Carbon::now()->subMonth()->endOfMonth()->toDateString();
    //     $emp= attendance::where('eid',session()->get('emp_logid'))->where('date','>=',$fromDate)->where('date','<=',$tillDate)->get();
    //     $month = Carbon::now()->format('M');
    //     return view('pages.laravel-examples.schedule',compact('emp','month')); 
    // }

    function get_month(Request $req){
       $reqs=$req->month;

        $db=DB::table('attendances')->get();
        // echo substr($req->month,2);
      
    }

}

























