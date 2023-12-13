<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Alert;
use App\Models\Cart;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
   public function addCart(Request $request){
        if($request->size == null){
             Alert::error('Sorry!', 'Please select size!');
             return redirect()->back();     
        }

        $getProductStock = ProductAttribute::isStockAvailable($request->product_id,$request->size);
        if($getProductStock < $request->quantity ){
            Alert::error('Sorry!', 'Quantity is not Available!');
            return redirect()->back(); 
        }

        $session_id = Session::get('session_id');
        if(empty($session_id)){
            $session_id = Session::getId();
            Session::put('session_id', $session_id);
        }

        if(Auth::check()){
            $user_id = Auth::user()->id;
            $countProduct = Cart::where(['product_id' => $request->product_id,'size' =>$request->size,'user_id' => $user_id])->count();
        }else{
            $user_id = 0;
            $countProduct = Cart::where(['product_id' => $request->product_id,'size' =>$request->size,'session_id' => $session_id])->count();
        }

        if($countProduct > 0){
            Alert::error('Sorry!', 'Product already exits in Cart!');
            return redirect()->back(); 
           
        }


        $cart             = new Cart();
        $cart->product_id = $request->product_id;
        $cart->session_id = $session_id;
        $cart->user_id    = $user_id;
        $cart->size       = $request->size;
        $cart->quantity   = $request->quantity;
        $cart->save();
        Alert::success('Success', 'Product has been added to Cart');
        return redirect()->route('checkout');  
        
   }

   public function checkout(){
      $data['collection'] = Cart::getCartItems();
      return view('frontend.home.check-out',$data);
   }

   public function cartRemove(Request $request){
    $cart  = Cart::find($request->cart_id);
    $cart->delete();
    $collection = Cart::getCartItems();
    $totalCartItems = totalCartItems();
    $totalCartAmount = totalCartAmount();
    return response()->json(['status' => true, 'totalCartItems' => $totalCartItems, 
    'totalCartAmount' => $totalCartAmount,
    'view' => (String)View::make('frontend.home.checkout_item')->with(compact('collection'))]);
  }


  public function updateCartQty(Request $request){

       $cart = Cart::find($request->cart_id);
       $availableStock = ProductAttribute::select('stock')
       ->where(['product_id'=> $cart->product_id, 'size' => $cart->size])->first();

       if($request->new_qty >  $availableStock->stock){
            $collection = Cart::getCartItems();
            return response()->json([
                    'status' => false,
                    'message' => 'product stock not available',
                    'view' => (String)View::make('frontend.home.checkout_item')->with(compact('collection'))
            ]);
       }

       Cart::where('id',$request->cart_id)->update(['quantity' => $request->new_qty]);
       $collection = Cart::getCartItems();
       $totalCartItems = totalCartItems();
       $totalCartAmount = totalCartAmount();
       return response()->json(['status' => true, 'totalCartItems' => $totalCartItems, 
       'totalCartAmount' => $totalCartAmount,
       'view' => (String)View::make('frontend.home.checkout_item')->with(compact('collection'))]);
  }
  
}
