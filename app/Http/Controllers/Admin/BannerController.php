<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['banner'] = Banner::latest()->get();
        return view('admin.banner.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
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
            'title'  => 'required|string',
            'image'  => 'required|image',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_ex =  $image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($image)->resize(1000, 591); 
            $image->storeAs('banner_images', $file_path,'public');
        }else{
            $file_path =  null;
        }

        try {
            $banner          = new Banner();
            $banner->title   = $request->title;
            $banner->link    = $request->link;
            $banner->alt_tag = $request->alt_tag;
            $banner->image   = $file_path;
            $banner->save();
            Toastr::success('banner Create successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.banners.index');
            
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
        $banner = Banner::find($id);
        if(!$banner){
            Toastr::error('Data not found', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
        }
        $data['banner'] =  $banner;
        return view('admin.banner.edit',$data);
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
            'title'  =>'required|string',
            'image' => 'required|image|sometimes',
        ]);

        $banner   = Banner::find($id);

        if($request->hasFile('image')){
            if ($banner->image) {
                Storage::delete('public/banner_images/'. $banner->image);
            }
            $image = $request->file('image');
            $image_ex =  $image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($image)->resize(399, 467); 
            $image->storeAs('banner_images', $file_path,'public');
        }else{
            $file_path = $banner->image;
        }

        try {   
            $banner->title   = $request->title;
            $banner->link    = $request->link;
            $banner->alt_tag = $request->alt_tag;
            $banner->image   = $file_path;
            $banner->save();
            Toastr::success('Banner Update successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.categories.index');
            
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
        $banner = Banner::find($id);
        if(!$banner){
          return errors_response('Data not found');
        }else{
           if($banner->image) {
                Storage::delete('public/banner_images/'. $banner->image);
            }
            $banner->delete();
            return success_response('banner Image Delete Successfully'); 
        }    
    }
}
