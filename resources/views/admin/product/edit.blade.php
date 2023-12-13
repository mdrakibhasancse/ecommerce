@extends('admin.layouts.app')
@section('title','Product')
@section('content-title') 
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Product</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Product</li>
      </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
@php
  $categories  = DB::table('categories')->where('section_id', $product->section_id)->get();
@endphp
<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title mt-2">Product Create</h3>

    <div class="card-tools">
      <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Product List</a>
    </div>
  </div>
  <!-- /.card-header -->
  <form method="post" action="{{ route('admin.products.update',$product->id)}}" enctype="multipart/form-data">
    @csrf
    @method('put')
  <div class="card-body">
    <div class="row">
        <div class="form-group col-md-6">
          <label for="name">Product Name</label>
          <input type="text" class="form-control" name="name" value="{{ $product->name }}" id="name">
          @error('name')
               <span style="color: red">{{ $message }}</span>
           @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="code">Product Code</label>
            <input type="text" class="form-control" name="code" value="{{ $product->code }}" id="code">
            @error('code')
                 <span style="color: red">{{ $message }}</span>
             @enderror
          </div>
        <!-- /.form-group -->
        <div class="form-group col-md-6">
          <label for="section_id">Section</label>
          <select name="section_id" id="section_id" class="form-control">
              <option value="">--Choose Section--</option>
              @foreach ($section as $value => $description)
              <option value="{{ $value }}"{{ $product->section_id == $value ? 'selected' : ' ' }}>{{ $description }}</option>
              @endforeach
          </select>
          @error('section_id')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>


        <div class="form-group col-md-6">
            <label for="category_id">Category</label>
            <select name="category_id" value="{{ old('category_id')}}" class="form-control" id="category_id">
                <option disabled="" selected="">-- Choose Category --</option>
                @foreach($categories as $row)
                <option value="{{ $row->id }}"
                  {{ $product->category_id == $row->id ? 'selected' : ' '}}>
                  {{ $row->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <span style="color: red">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-md-6">
            <label for="price">Product Price</label>
            <input type="number" class="form-control" name="price" value="{{ $product->price }}" id="price" placeholder="Enter Price">
            @error('price')
                 <span style="color: red">{{ $message }}</span>
             @enderror
          </div>

        <div class="form-group col-md-6">
          <label for="discount">Product Discount(%)</label>
          <input type="number" class="form-control" name="discount" value="{{ $product->discount }}" id="url">
        </div>

        <div class="form-group col-md-6">
          <label for="url">Product Url</label>
          <input type="text" class="form-control" name="url" value="{{ $product->url }}" id="url">
          @error('url')
               <span style="color: red">{{ $message }}</span>
           @enderror
        </div>

        <div class="form-group col-md-6">
          <div class="row">
            <div class="col-md-6">
             <label for="featured_image">Product Featured Image</label>
             <input type="file" name="featured_image" id="featured_image" class="form-control">
             @error('featured_image')
             <span style="color: red">{{ $message }}</span>
             @enderror
            </div>

            <div class="col-md-6">
             <img src="" id="showImage" style="width: 100px;">
            </div>
          </div>
        </div>

        <div class="form-group col-md-12">
            <label for="description">Product Description</label>
            <textarea id="summernote" name="description">{{ $product->description }}</textarea>
            @error('description')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-md-4">
          <label for="meta_title">Meta Title</label>
          <textarea name="meta_title" id="meta_title" rows="3" class="form-control">
            {{ $product->meta_title }}
          </textarea>
        </div>

        <div class="form-group col-md-4">
          <label for="meta_description">Meta Description</label>
          <textarea name="meta_description" id="meta_description" rows="3" class="form-control">
            {{ $product->meta_description }}
          </textarea>
        </div>

        <div class="form-group col-md-4">
          <label for="meta_keyword">Meta Keyword</label>
          <textarea name="meta_keyword" id="meta_keyword" rows="3" class="form-control">
            {{ $product->meta_keyword }}
          </textarea>
        </div>
        
      

        <div class="form-group col-md-6">
          <label for="status">Product Status</label><br>
          <div class="icheck-success d-inline">
            <input type="radio" name="status" id="active" value="1" {{ $product->status == '1' ? 'checked' : ''}}>
            <label for="active">
              Active
            </label>
          </div>
          <div class="icheck-success d-inline">
            <input type="radio" name="status" id="inactive" value="0" {{ $product->status == '0' ? 'checked' : ''}}>
            <label for="inactive">
              Inactive
            </label>
          </div><br>
          @error('status')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>
        </div>
    </div>
   
    <div class="card-footer text-right">
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>
</div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {

            $(document).on('change', 'select[name="section_id"]', function() {
                let section_id = $(this).val();
                $.ajax({
                    url    : "{{ route('admin.get.category')}}",
                    method : 'get',
                    data   : {section_id : section_id },
                    success: function(result){
                        $('#category_id').empty();
                        $.each(result,function(key, value){
                            $('#category_id').append('<option value="'+value.id+'">'
                                +value.name+'</option>')
                        });
                    }
                });

             
            });

            $('#featured_image').change(function(e){
                var reader = new FileReader();
                reader.onload=function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush