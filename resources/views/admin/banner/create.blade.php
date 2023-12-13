@extends('admin.layouts.app')
@section('title','Banner')
@section('content-title') 
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Banner</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Banner</li>
      </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')

<div class="row justify-content-center">
     <div class="col-md-6">
        <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title mt-2">Banner Create</h3>
          
              <div class="card-tools">
                <a href="{{ route('admin.banners.index') }}" class="btn btn-primary">Banner List</a>
              </div>
            </div>
            <!-- /.card-header -->
            <form method="post" action="{{ route('admin.banners.store')}}" enctype="multipart/form-data">
              @csrf
            <div class="card-body">
                  <div class="form-group">
                    <label for="title">Banner Title</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title')}}" id="title" placeholder="Enter title">
                    @error('title')
                         <span style="color: red">{{ $message }}</span>
                     @enderror
                  </div>
                  <div class="form-group">
                    <label for="link">Banner Link</label>
                    <input type="text" class="form-control" name="link" value="{{ old('link')}}" id="link" placeholder="Enter link">
                  </div>

                  <div class="form-group">
                    <label for="alt_tag">Banner Alter Tag</label>
                    <input type="text" class="form-control" name="alt_tag" 
                    value="{{ old('alt_tag')}}" id="alt_tag" placeholder="Enter Alt_tag">
                  </div>
                  
                  <div class="form-group">
                     <div class="row">
                       <div class="col-md-6">
                        <label for="image">Banner Image</label>
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
             
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
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