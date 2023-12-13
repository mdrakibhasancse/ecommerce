<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Section;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['product'] = Product::latest()->get();
       return view('admin.product.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['section']= Section::asSelectArray();
        return view('admin.product.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if($request->hasFile('featured_image')){
            $featured_image = $request->file('featured_image');
            $image_ex =  $featured_image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($featured_image)->resize(255, 251); 
            $featured_image->storeAs('product_featured_images', $file_path,'public');
        }else{
            $file_path =  null;
        }

        try {
            $product                   = new Product();
            $product->name             = $request->name;
            $product->slug             = Str::slug($request->name);
            $product->section_id       = $request->section_id;
            $product->category_id      = $request->category_id;
            $product->status           = $request->status;
            $product->discount         = $request->discount;
            $product->url              = $request->url;
            $product->price            = $request->price;
            $product->description      = $request->description;
            $product->code             = $request->code;
            $product->meta_title       = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword     = $request->meta_keyword;
            $product->featured_image   = $file_path;
            $product->save();
            Toastr::success('Product Create successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.products.index');
            
        } catch (\Throwable $th) {
            Toastr::error('somthing wrong', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $product = Product::where('slug',$slug)->first();
        if(!$product){
            Toastr::error('Data not found', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
        }
        $data['product'] = $product;
        $data['section'] = Section::asSelectArray();
        return view('admin.product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => 'required|string|unique:products,name,'.$id,
            'section_id'     => 'required',
            'category_id'    => 'required',
            'status'         => 'required',
            'price'          => 'required',
            'featured_image' => 'required|image|sometimes',
            'url'            => 'required',
            'code'           => 'required|unique:products,code,'.$id,
            'description'    => 'required',
        ]);

        $product   = Product::find($id);

        if($request->hasFile('featured_image')){
            if ($product->featured_image) {
                Storage::delete('public/product_featured_images/'.$product->featured_image);
            }
            $featured_image = $request->file('featured_image');
            $image_ex =  $featured_image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($featured_image)->resize(255, 251); 
            $featured_image->storeAs('product_featured_images', $file_path,'public');
        }else{
            $file_path =  $product->featured_image;
        }

        try {   
            $product->name             = $request->name;
            $product->slug             = Str::slug($request->name);
            $product->section_id       = $request->section_id;
            $product->category_id      = $request->category_id;
            $product->status           = $request->status;
            $product->discount         = $request->discount;
            $product->url              = $request->url;
            $product->price            = $request->price;
            $product->description      = $request->description;
            $product->code             = $request->code;
            $product->meta_title       = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword     = $request->meta_keyword;
            $product->featured_image   = $file_path;
            $product->save();
            Toastr::success('Product update successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.products.index');
            
        } catch (\Throwable $th) {
            Toastr::error('something worng', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if(!$product){
          return errors_response('Data not found');
        }else{
           if($product->featured_image) {
                Storage::delete('public/product_featured_images/'. $product->featured_image);
            }
            $product->delete();
            return success_response('Product Delete Successfully'); 
        }     
    }

    public function status(Request $request){
        $product = Product::where('slug',$request->slug)->first();
        if(!$product){
            return errors_response('Data not found');
        }
        $product->status = $request->status;
        $product->save();
        return success_response('product status'); 
    }

    public function getCategory(Request $request){
         $category = Category::where('section_id', $request->section_id)->get();
         return response()->json($category); 
    }
}
