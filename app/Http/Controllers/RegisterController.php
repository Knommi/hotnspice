<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\admin;
use Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store(Request $req){

       
      $req->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:5|max:255',
        ]);


        $admin=new admin;
        $admin->name=$req->name; 
        $admin->email=$req->email; 
        $admin->password=Hash::make($req->password); 
        $admin->save();
        
        
        return redirect('/dashboard');
    } 
}
