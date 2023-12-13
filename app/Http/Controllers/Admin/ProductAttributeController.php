<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttribute;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function addProductAttr($id){
        $data['product'] = Product::with('attributes')->where('id',$id)->first();
        return view('admin.product-attribute.create',$data);
    }

    public function StoreProductAttr(Request $request){
        $data = $request->all();
        foreach ($data['sku'] as $key => $value) {
           if(!empty($value)){

            $attrCountSku = ProductAttribute::where(['sku'=>$value])->count();
            if($attrCountSku > 0){
                Toastr::error('sku already exits, please add another sku!', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
                return redirect()->back();
            }

            $attrCountSize = ProductAttribute::where(['product_id'=> $request->product_id,'size'=>$data['size'][$key]])->count();
            if($attrCountSize > 0){
                Toastr::error('size already exits, please add another size!', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
                return redirect()->back();
            }

            $attribute = new ProductAttribute();
            $attribute->product_id = $request->product_id; 
            $attribute->sku        = $value;
            $attribute->size       = $data['size'][$key]; 
            $attribute->price      = $data['price'][$key]; 
            $attribute->stock      = $data['stock'][$key]; 
            $attribute->save();  
           }
        }
        Toastr::success('Product attribute create successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
        return redirect()->back();
    }

    public function UpdateProductAttr(Request $request){
        $data = $request->all();
        foreach ($data['attribute_id'] as $key => $value) {
           if(!empty($value)){
              ProductAttribute::where(['id'=> $data['attribute_id'][$key]])
              ->update(['price' => $data['price'][$key],'stock' => $data['stock'][$key]]); 
           }
        }
        Toastr::success('Product attribute update successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
        return redirect()->back();
    }

    public function DeleteProductAttr($id){
        $attribute = ProductAttribute::find($id);
        if(!$attribute){
          return errors_response('Data not found');
        }else{
            $attribute->delete();
            return success_response('Product Delete Successfully'); 
        } 
    }
}
