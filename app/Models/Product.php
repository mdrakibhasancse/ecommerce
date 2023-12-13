<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }
    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public static function getDiscountPrice($product_id)
    {
        $product = Product::select('id','price','discount')->where('id',$product_id)
        ->first();
        
        if($product->discount > 0){
            $discount_price = $product->price - ($product->price * $product->discount/100);
        }
        else{
            $discount_price = 0;
        }

         return $discount_price;
    }


    public static function getAttrDiscountPrice($product_id, $size)
    {
        $product = Product::select('id','discount')->where('id',$product_id)
        ->first();
        $productArrtibute = ProductAttribute::where(['product_id' =>$product_id, 'size' => $size])->first();
     
        if($product->discount > 0){
            $final_price = $productArrtibute->price - 
            ($productArrtibute->price * $product->discount/100);
            $discount = $productArrtibute->price - $final_price;
         }
         else{
            $final_price = $productArrtibute->price;
            $discount    = 0;
         }

         return  array('product_price'=> $productArrtibute->price ,'final_price'=>$final_price,'discount' => $discount);
    }

}
