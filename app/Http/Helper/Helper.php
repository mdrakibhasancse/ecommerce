<?php

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function success_response($message = '', $code = 200){
    return response()->json([
        'success' => true,
        'message' => $message
  ],$code);
}

function errors_response($message = '', $code = 400){
    return response()->json([
        'success' => false,
        'message' => $message
  ],$code);
}


function totalCartItems(){
   if(Auth::check()){
      $user_id = Auth::user()->id;
      $totalCartItems = Cart::where('user_id',$user_id)->sum('quantity');
   }else{
      $session_id = Session::get('session_id');
      $totalCartItems = Cart::where('session_id',$session_id)->sum('quantity');
   }

   return $totalCartItems;
}



function totalCartAmount(){
   if(Auth::check()){
      $user_id = Auth::user()->id;
      $totalCart = Cart::where('user_id',$user_id)->get();
      $total_price = 0;
      foreach($totalCart as $cart){
         $getAttrDiscountPrice = Product::getAttrDiscountPrice($cart->product_id,$cart->size);
         $total_price = $total_price + ($getAttrDiscountPrice['final_price'] * $cart->quantity); 
      }

   }else{
      $session_id = Session::get('session_id');
      $totalCart = Cart::where('session_id',$session_id)->get();
      $total_price = 0;
      foreach($totalCart as $cart){
         $getAttrDiscountPrice = Product::getAttrDiscountPrice($cart->product_id,$cart->size);
         $total_price = $total_price + ($getAttrDiscountPrice['final_price'] * $cart->quantity); 
     }
   }

   return  $total_price;
}
