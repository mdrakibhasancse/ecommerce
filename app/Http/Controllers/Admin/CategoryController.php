<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Section;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['category'] = Category::latest()->get();
       return view('admin.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['section']= Section::asSelectArray();
        return view('admin.category.create',$data);
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
            'name'       => 'required|string|unique:categories,name',
            'section_id' => 'required',
            'status'     => 'required',
            'image'      => 'required|image',
            'url'        => 'required',
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_ex =  $image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($image)->resize(399, 467); 
            $image->storeAs('category_images', $file_path,'public');
        }else{
            $file_path =  null;
        }

        try {
            $category                   = new Category();
            $category->name             = $request->name;
            $category->slug             = Str::slug($request->name);
            $category->section_id       = $request->section_id;
            $category->status           = $request->status;
            $category->url              = $request->url;
            $category->meta_title       = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->meta_keyword     = $request->meta_keyword;
            $category->image            = $file_path;
            $category->save();
            Toastr::success('Category Create successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->route('admin.categories.index');
            
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
    public function edit($slug)
    {
        $category = Category::where('slug',$slug)->first();
        if(!$category){
            Toastr::error('Data not found', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
            return redirect()->back();
        }
        $data['category'] = $category;
        $data['section']  = Section::asSelectArray();
        return view('admin.category.edit',$data);
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
            'name'=>'required|string|unique:categories,name,'.$id,
            'section_id' => 'required',
            'status'     => 'required',
            'image'      => 'required|image|sometimes',
            'url'        => 'required',
        ]);

        $category   = Category::find($id);

        if($request->hasFile('image')){
            if ($category->image) {
                Storage::delete('public/category_images/'.$category->image);
            }
            $image = $request->file('image');
            $image_ex =  $image->getClientOriginalExtension();
            $file_path = date('ymdhis').'.'.$image_ex;
            Image::make($image)->resize(399, 467); 
            $image->storeAs('category_images', $file_path,'public');
        }else{
            $file_path =  $category->image;
        }

        try {   
            $category->name             = $request->name;
            $category->slug             = Str::slug($request->name);
            $category->section_id       = $request->section_id;
            $category->url              = $request->url;
            $category->meta_title       = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->meta_keyword     = $request->meta_keyword;
            $category->image            = $file_path;
            $category->save();
            Toastr::success('Category Update successfuly', 'success', ["positionClass" => "toast-top-right",  "closeButton"=> true,   "progressBar"=> true,]);
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
        $category = Category::find($id);
        if(!$category){
          return errors_response('Data not found');
        }else{
           if($category->image) {
                Storage::delete('public/category_images/'.$category->image);
            }
            $category->delete();
            return success_response('Category Delete Successfully'); 
        }     
    }


    public function status(Request $request){
        $category = Category::where('slug',$request->slug)->first();
        if(!$category){
            return errors_response('Data not found');
        }
        $category->status = $request->status;
        $category->save();
        return success_response('category status'); 
    }
}
