<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProfileController extends Controller
{
    public function edit(){
        $data['admin'] = Auth::guard('admin')->user();
        return view('admin.profile.edit',$data);
     }
  
     public function checkCurrentPwd(Request $request){     
         $password = Auth::guard('admin')->user()->password;
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
        $request->validate([
            'current_password' => 'required',
            'new_pwd'          => 'required|email',
        ]);
         $current_password = Auth::guard('admin')->user()->password;
         if(Hash::check($request->current_password, $current_password)){
            if(!Hash::check($request->new_pwd, $current_password)){
              if($request->new_pwd == $request->confirm_password){
                 $admin = Admin::where('id',Auth::guard('admin')->user()->id)->first();
                 $admin->password = Hash::make($request->new_pwd);
                 $admin->save();
                 Auth::guard('admin')->logout();
                 return redirect()->back();
              }else{
                 Toastr::error('New password and Confirm doed not match', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
                return redirect()->back();
              }
                
            }else{
                Toastr::error('New password and Current password are same', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
                return redirect()->back();
            }
  
         }else{
            Toastr::error('Current password is not match', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
         }
    }
  
    public function updateProfile(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
     $admin = Admin::where('id',Auth::guard('admin')->user()->id)->first();
      if($request->hasFile('image')){
          if ($admin->image) {
              Storage::delete('public/admin_image/' . $admin->image);
          }
          $image = $request->file('image');
          $image_ex =  $image->getClientOriginalExtension();
          $file_path = date('ymdhis').'.'.$image_ex;
          Image::make($image)->resize(500, 310); 
          $image->storeAs('admin_image', $file_path,'public');
      }else{
          $file_path =  $admin->image;
      }
      $admin->name   = $request->name;
      $admin->email  = $request->email;
      $admin->mobile = $request->mobile;
      $admin->image  =  $file_path;
      $admin->save();
      Toastr::success('Profile Update successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
      return redirect()->back();
      }
    
}
