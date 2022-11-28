<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    public function index()
    {

        $emp=DB::table('employees')->count();
        return view('dashboard.index',compact('emp'));
    }
}
