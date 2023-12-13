<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Alert;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function create(){
        return view('frontend.user.register');
    }


    public function store(Request $request){

        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
            
        ]);
        Session::forget('r_success_message');
        Session::forget('r_error_message');
        $checkEmail = User::where('email',$request->email)->count();
        if($checkEmail > 0){
           $message = "Email already exits";
           Session::flash('r_error_message',$message);
           return redirect()->back();
        }else{
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->status   = 0;
            $user->save();

            $email =  $request->email;
            $messageData = [
                 'email' =>  $request->email,
                 'name'  =>  $request->name,
                 'code' =>  base64_encode($request->email),
            ];

            Mail::send('frontend.emails.confirmation', $messageData, function($message) use($email){
                 $message->to($email)->subject('confirm your e-comerce account');
            });

            $message = 'Please confirm your email to activate your account !';
            Session::put('r_success_message',$message);
            return redirect()->back();
        }
      
    }

    public function checkEmail(Request $request){
         
        $checkEmail = User::where('email',$request->email)->count();

        if($checkEmail > 0){
            return "false";
        }else{
            return "true";
        }
    }
    
    public function loginCreate(){
        return view('frontend.user.login');
    }

    public function loginStore(Request $request){
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',            
        ]);
        Session::forget('l_success_message');
        Session::forget('l_error_message');
        $credentails = $request->only('email','password');
        if(Auth::attempt($credentails)){

            $userStatus = User::where('email',$request->email)->first();
            if($userStatus->status == 0){
              Auth::logout();
              $message = " Your account is not activated yet! Please confirm your email to activate!";
              Session::put('l_error_message',$message);
              return redirect()->back();
            }

            if(!empty(Session::get('session_id'))){
                $user_id    = Auth::user()->id;
                $session_id = Session::get('session_id');
                Cart::where('session_id',$session_id)->update(['user_id' =>  $user_id]);
            }
           Alert::success('Success!', 'You are successfuly Login!');
           return redirect()->route('checkout');
        }else{
           Alert::error('Sorry!', 'Invalid Email or Password');
           return redirect()->back();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }


    public function confirmAccount($email){
        Session::forget('l_success_message');
        Session::forget('l_error_message');
          $email = base64_decode($email);
          $userCount = User::where('email', $email)->count();
          if($userCount > 0){
            $user = User::where('email', $email)->first();
            if($user->status == 1){
                $message = "Your email account already activated ! You can login!";
                Session::put('l_error_message',$message);
                return redirect('user/login');
            }else{
                User::where('email', $email)->update(['status' => 1]);
                $messageData = [
                    'email' => $user->email,
                    'name'  => $user->name,
               ];
                Mail::send('frontend.emails.welcome', $messageData, function($message) use($email){
                    $message->to($email)->subject('confirm your e-comerce account');
               });
   
               $message = 'Your email account is activated ! You can login now!';
               Session::put('l_success_message',$message);
               return redirect('user/login');
            }
          }else{
            abort(404);
          }
    }


    public function account(){
        $data['user'] = Auth::user();
        return view('frontend.user.account',$data);
    }

    public function updateAccount(Request $request){
        $user = User::where('id',Auth::user()->id)->first();
         if($request->hasFile('image')){
             if ($user->image) {
                 Storage::delete('public/user_imags/' . $user->image);
             }
             $image = $request->file('image');
             $image_ex =  $image->getClientOriginalExtension();
             $file_path = date('ymdhis').'.'.$image_ex;
             Image::make($image)->resize(500, 310); 
             $image->storeAs('user_image', $file_path,'public');
         }else{
             $file_path =  $user->image;
         }
         $user->name    = $request->name;
         $user->email   = $request->email;
         $user->mobile  = $request->mobile;
         $user->address = $request->address;
         $user->image   =  $file_path;
         $user->save();
         Alert::success('Success!', 'User Account Update successfuly');
         return redirect()->back();
         }

         public function checkCurrentPwd(Request $request){
            $password = Auth::user()->password;
            if(Hash::check($request->current_pwd,$password)){
               return response()->json([
                    'success' => true,
               ]);
            }else{
              return response()->json([
                 'success' => false,
              ]);
            }
        }

         public function updatePassword(Request $request){
            $current_password = Auth::user()->password;
            if(Hash::check($request->current_password, $current_password)){
               if(!Hash::check($request->new_pwd, $current_password)){
                 if($request->new_pwd == $request->confirm_password){
                    $user = User::where('id',Auth::user()->id)->first();
                    $user->password = Hash::make($request->new_pwd);
                    $user->save();
                    Alert::success('Success!', 'Password Update successfuly');
                    return redirect()->back();
                 }else{
                  Alert::error('Sorry!', 'New password and Confirm doed not match');
                   return redirect()->back();
                 }
                   
               }else{
                   Alert::error('Sorry!', 'New password and Current password are same');
                   return redirect()->back();
               }
     
            }else{
               Alert::error('Sorry!', 'Current password is not match');
               return redirect()->back();
            }
       }
}
