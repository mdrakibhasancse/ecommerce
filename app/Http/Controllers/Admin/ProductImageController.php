<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Intervention\Image\ImageManagerStatic as Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function addProductImg($id){
        $data['product'] = Product::with('images')->where('id',$id)->first();
        return view('admin.product-image.create',$data);
    }

    public function storeProductImg(Request $request){

       $request->validate([
           'images' => 'required',
       ]);
       if($request->hasFile('images')){
        foreach($request->file('images') as $image) {
            $image_ex = $image->getClientOriginalExtension();
            $file_path = rand(111,999).'.'.$image_ex;
            Image::make($image)->resize(120, 200); 
            $image->storeAs('product_images', $file_path,'public');
            $image=new ProductImage();
            $image->images = $file_path;
            $image->product_id = $request->product_id;
            $image->save();
        }
      }
       Toastr::success('Product Image create successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
       return redirect()->back();
    }

    public function DeleteProductImg($id){
        $productImg = ProductImage::find($id);
        if(!$productImg){
          return errors_response('Data not found');
        }else{
           if($productImg->images) {
                Storage::delete('public/product_images/'. $productImg->images);
            }
            $productImg->delete();
            return success_response('Product Image Delete Successfully'); 
        }    
    }

}
