<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin;
use DB;
class ProfileController extends Controller
{
    public function create()
    {
        return view('pages.profile');
    }

    public function update()
    {
            
        $user = request()->user();
        $attributes = request()->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required',
            'phone' => 'required|max:10',
            'about' => 'required:max:150',
            'location' => 'required'
        ]);

        auth()->user()->update($attributes);
        return back()->withStatus('Profile successfully updated.');
    
}

    public function user_profile(){
            $admin=  admin::where('id',session()->has('logid'))->get();
            return view('pages.laravel-examples.profile-user',compact('admin'));
        
    }
    public function user_management(){

            $emp=  DB::table('employees')->get();
            return view('pages.laravel-examples.user-management',compact('emp'));
        
    }
}
