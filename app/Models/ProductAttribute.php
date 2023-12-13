<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    public static function isStockAvailable($product_id,$size){
        $getProductStock = ProductAttribute::select('stock')->where(['product_id'=> $product_id,'size' => $size])->first();
        return $getProductStock->stock;
    }
}
