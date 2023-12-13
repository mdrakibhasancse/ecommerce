@extends('admin.layouts.app')
@section('title','Ads')
@section('content-title') 
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Ads</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Ads</li>
      </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title mt-2">Ads Create</h3>

    <div class="card-tools">
      <a href="{{ route('admin.ads.index') }}" class="btn btn-primary">Ads List</a>
    </div>
  </div>
  <!-- /.card-header -->
  <form method="post" action="{{ route('admin.ads.store')}}" enctype="multipart/form-data">
    @csrf
  <div class="card-body">
    <div class="row">
        <!-- /.form-group -->
        <div class="form-group col-md-6">
          <label for="section_id">Section</label>
          <select name="section_id" id="section_id" class="form-control">
              <option value="">--select section--</option>
              @foreach ($section as $value => $description)
              <option value="{{ $value }}"{{ old('section_id') == strval($value) ? 'selected' : ' ' }}>{{ $description }}</option>
              @endforeach
          </select>
          @error('section_id')
          <span style="color: red">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">--select category--</option>
                @foreach ($category as $row)
                <option value="{{ $row->id }}"{{ old('category_id') == $row->id ? 'selected' : ' ' }}>{{ $row->name }}</option>
                @endforeach
            </select>
            @error('section_id')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-md-6">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control">
                <option value="">--select product--</option>
                @foreach ($product as $row)
                <option value="{{ $row->id }}"{{ old('product_id') == strval($value) ? 'selected' : ' ' }}>{{  $row->name }}</option>
                @endforeach
            </select>
            @error('section_id')
            <span style="color: red">{{ $message }}</span>
            @enderror
        </div>

      


        <div class="form-group col-md-6">
          <div class="row">
            <div class="col-md-6">
             <label for="image">Ads Image</label>
             <input type="file" name="image" id="image" class="form-control">
             @error('image')
             <span style="color: red">{{ $message }}</span>
             @enderror
            </div>

            <div class="col-md-6">
             <img src="" id="showImage" style="width: 100px;">
            </div>
          </div>
        </div>
        </div>
    </div>
   
    <div class="card-footer text-right">
      <button type="submit" class="btn btn-primary">Create</button>
    </div>
  </form>
</div>
</div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload=function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endpush