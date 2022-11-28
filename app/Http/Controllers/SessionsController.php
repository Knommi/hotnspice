<?php

namespace App\Http\Controllers;

Use Str;
Use Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use Session;
use DB;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin=admin::where('email','=',$req->email)->first();
        if($admin){
            if(Hash::check($req->password,$admin->password)){
                $req->session()->put('logid',$admin->id);
                // echo "fsdsd";
                return redirect('/dashboard');
            }
            else{
                return redirect('/sign-in');
    
            }
        }

        // if (! auth()->attempt($attributes)) {
        //     throw ValidationException::withMessages([
        //         'email' => 'Your provided credentials could not be verified.'
        //     ]);
        // }

        // session()->regenerate();

        // return redirect('/dashboard');

    }

    public function show(){
        request()->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            request()->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
        
    }

    public function update(){
        
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]); 
          
        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => ($password)
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function destroy()
    {
        if(session()->has('logid')){
            session()->pull('logid');
            return redirect('/sign-in');
        }

    }


    public function buynow(Request $request,$id){

        $course=tbl_courses::where('id',$id)->get();
        
        $user=tbl_users::where('uid',$this->session->set_userdata('logged_in_raw'))->get();


        $uemail=$request->email;
        $mobile_no=$request->mobile;
        $fee=$request->fee;

        
        $order =$entity->order_id;
        $TXNDATE = date('Y-m-d H:i:s');
        $cc_id ='48';
        $pay_mode = 'manual';
        $date_time = date('Y-m-d H:i:s');
        $u_email = $entity->email;
        $mobile_no = $entity->contact;
        $fee = '149';

        $product_discount = '0';
        $STATUS = 'TXN_SUCCESS';
        $product_name = 'Zero to Hero';
        $issuccess = 'true';
        $expiry_date = date('Y-m-d', strtotime($Date. ' + 365 days'));


        $entry_date = date('Y-m-d H:i:s');
        $last_updated = date('Y-m-d H:i:s');
        $is_promo = 'no';
        $is_selected_promo = 'no';
        $expire_date = date('Y-m-d', strtotime($Date. ' + 365 days'));


        $order_count=DB::table('tbl_user_products')->where('ORDER_ID','!=',$orderid)->count();
        if($order_count>0){
            echo "order already exists";

        }
        else{
            $sql3 = "INSERT INTO tbl_user_products (uemail, uphone, combo_id_p, product_price, product_original_price, product_discount, is_promo, promo_code, is_selected_promo, payment_status, product_name, ORDER_ID, entry_date, last_updated, total_days, expire_date, suspend, platform) VALUES ('$u_email', '$mobile_no', '$cc_id', '$fee', '$fee', '0', '$is_promo', 'razor', '$is_selected_promo', 'success', '$product_name', '$order', '$entry_date', '$last_updated', '365', '$expiry_date', '0', '0')";

            
            $tbl_user_products=new tbl_user_products;
            $tbl_user_products->uemail=$user->email;
            $tbl_user_products->uphone=$user->contact_no;
            $tbl_user_products->combo_id_p=$cc_id;
            $tbl_user_products->product_price=$course->c_price;
            $tbl_user_products->product_original_price=$course->c_price;
            $tbl_user_products->product_discount=$course->c_discount;
            $tbl_user_products->is_promo=  $is_promo ;
            $tbl_user_products->promo_code= 'razor';
            $tbl_user_products->is_selected_promo= $is_selected_promo;
            $tbl_user_products->payment_status= 'success';
            $tbl_user_products->prooduct_name= $course->coruse_name;
            $tbl_user_products->ORDER_ID= $id;
            $tbl_user_products->entry_date= $entry_date;
            $tbl_user_products->last_updated= $last_updated;
            $tbl_user_products->total_days= '365';
            $tbl_user_products->expire_date= $expiry_date;
            $tbl_user_products->suspend= '0';
            $tbl_user_products->platform= '0';


    
        }
        

    }

}
