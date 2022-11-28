<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\employeecontroller;
            

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('islogin')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('signup', [RegisterController::class, 'store'])->middleware('guest')->name('signup');

Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest')->name('signin');;
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('islogin')->name('logout');
// Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
// Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
// Route::get('/reset-password/{token}', function ($token) {
// 	return view('sessions.password.reset', ['token' => $token]);
// })->middleware('guest')->name('password.reset');
Route::post('emp_logout', [employeecontroller::class,'emp_logout'])->middleware('emp_auth')->name('emp_logout');

Route::get('empl_add', [employeecontroller::class, 'empl_add'])->middleware('islogin');
Route::get('/signin_emp', [employeecontroller::class, 'view_signin']);
Route::get('/emp_dash', [employeecontroller::class, 'emp_dash'])->middleware('emp_auth')->name('emp_dash');
Route::post('/signin_emp', [employeecontroller::class, 'signin_emp'])->name('signin_emp');
Route::post('emp_add', [employeecontroller::class, 'emp_add'])->middleware('islogin')->name('emp_add');
Route::get('/emp_del/{id}', [employeecontroller::class, 'emp_del'])->middleware('islogin')->name('emp_del');
Route::get('/emp_upd/{id}', [employeecontroller::class, 'emp_upd'])->name('emp_upd');
Route::post('/employee_updated/{id}', [employeecontroller::class, 'employee_updated'])->middleware('islogin')->name('employee_updated');
Route::post('/add_attendance/{id}', [employeecontroller::class, 'add_attendance'])->middleware('emp_auth');
Route::get('/emp-profile', [employeecontroller::class, 'emp_profile'])->middleware('emp_auth')->name('emp-profile');
Route::post('/employee_updates/{id}', [employeecontroller::class, 'employee_updates'])->middleware('emp_auth')->name('employee_updates');
Route::get('/schedule', [employeecontroller::class, 'schedule'])->middleware('emp_auth')->name('schedule');
Route::get('/prev', [employeecontroller::class, 'prev'])->middleware('emp_auth')->name('prev');
Route::get('/next', [employeecontroller::class, 'next'])->middleware('emp_auth')->name('next');
Route::post('/get_month', [employeecontroller::class, 'get_month'])->middleware('emp_auth')->name('get_month');

Route::get('profile', [ProfileController::class, 'create'])->middleware('islogin')->name('profile');
Route::get('users-profile', [ProfileController::class, 'user_profile'])->middleware('islogin')->name('users-profile');
Route::get('user-management', [ProfileController::class, 'user_management'])->middleware('islogin')->name('user-management');
// Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
// Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');

	// Route::get('user-management', function () {
	// 	return view('pages.laravel-examples.user-management');
	// })->middleware('islogin')->name('user-management');
	// Route::get('users-profile', function () {
	// 	return view('pages.laravel-examples.user-profile');
	// })->name('users-profile');
// });