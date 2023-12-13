<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Section;
use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ads'] = Ads::with(['product','category'])->orderBy('id','desc')->get();
        return view('admin.ads.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['section']  = Section::asSelectArray();
        $data['category'] = Category::orderBy('id','desc')->get();
        $data['product']  = Product::orderBy('id','desc')->get();
        return view('admin.ads.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_id'  => 'required',
            'category_id' => 'required',
            'product_id'  => 'required',
            'image'       =>'required|image'
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_ex =  $image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($image)->resize(900, 600); 
            $image->storeAs('ads_images', $file_path,'public');
        }else{
            $file_path =  null;
        }

        
        try {
            $ads             = new Ads();
            $ads->section_id  = $request->section_id;
            $ads->category_id = $request->category_id;
            $ads->product_id  = $request->product_id;
            $ads->image       = $file_path;
            $ads->save();
            Toastr::success('Ads Create successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.ads.index');
            
        } catch (\Throwable $th) {
            Toastr::error('something worng', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
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
    public function edit($id)
    {
        $ads = Ads::find($id);
        if(!$ads){
            Toastr::error('Data not found', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
        }
        $data['ads'] = $ads;
        $data['section']   = Section::asSelectArray();
        $data['category']  = Category::get();
        $data['product']   = Product::get();
        return view('admin.ads.edit',$data);
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
            'section_id'  => 'required',
            'category_id' => 'required',
            'product_id'  => 'required',
            'image'      => 'required|image|sometimes',
        ]);

        $ads = Ads::find($id);

        if($request->hasFile('image')){
            if ($ads->image) {
                Storage::delete('public/ads_images/'.$ads->image);
            }
            $image = $request->file('image');
            $image_ex =  $image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($image)->resize(399, 467); 
            $image->storeAs('ads_images', $file_path,'public');
        }else{
            $file_path =  $ads->image;
        }

        try {   
            $ads->section_id  = $request->section_id;
            $ads->category_id = $request->category_id;
            $ads->product_id  = $request->product_id;
            $ads->image       = $file_path;
            $ads->save();
            Toastr::success('Ads Update successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.ads.index');
            
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
        $ads = Ads::find($id);
        if(!$ads){
          return errors_response('Data not found');
        }else{
           if($ads->image) {
                Storage::delete('public/ads_images/'.$ads->image);
            }
            $ads->delete();
            return success_response('Ads Delete Successfully'); 
        } 
    }
}
