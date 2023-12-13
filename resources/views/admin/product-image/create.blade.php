@extends('admin.layouts.app')
@section('title','Product Image')
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

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title mt-2">Product Images</h3>
    <div class="card-tools">
      <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
          <i class="fas fa-arrow-left mr-1"></i>Back</a>
    </div>
  </div>
  <div class="card-body">
       <div class="row">
          <div class="col-md-7">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product</h3>
              </div>
              <form id="attributeForm" action="{{ route('admin.product-images.store')}}" method="POST"  enctype="multipart/form-data">
                @csrf
              <div class="card-body">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group">
                  <label>Product Name : </label>&nbsp;&nbsp;
                  {{ $product->name }} 
                </div>
                <div class="form-group">
                  <label>Product Code : </label>&nbsp;&nbsp;
                  {{ $product->code }}
                </div>
                <div class="form-group">
                  <img width="120" src="{{(!empty($product->featured_image)) ? 
                   asset("storage/product_featured_images/".$product->featured_image) : asset('/upload/extra.jpg')}}" alt="">
                </div>

                <div class="form-group">
                  <label>Mutiple Product Images</label><br>
                  <input type="file" name="images[]" multiple="" id="images">
                   @error('images')
                  <span style="color: red">{{ $message }}</span>
                   @enderror
                 </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Add images</button>
              </div>
            </form>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Images</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered" id="myTable">
                  <thead>
                    <tr>
                      <th style="width: 20px">#Id</th>
                      <th>Image</th>
                      <th style="width: 100px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($product->images as $image)
                     <input style="display: none" type="text" name="image_id[]" value="{{$image->id}}">
                       <tr id="ids{{$image->id}}">
                        <td style="width: 20px">{{ $image->id }}</td>
                        <td>
                          <img width="50px" src="{{(!empty($image->images)) ? 
                            asset("storage/product_images/".$image->images) : asset('/upload/extra.jpg')}}" alt="">
                        </td>
                        <td style="width: 100px">
                          <button title="Delete" class="btn btn-danger btn-sm" id="imageDelete"
                           data-id ="{{$image->id}}"><i class="fas fa-trash"></i></button> 
                        </td>
                       </tr>
                     @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
       </div>
  </div>
</div>
@endsection



@push('scripts')
 <script>
 $( document ).ready(function() {
      $(document).on("click","#imageDelete",function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                  url : `/admin/product-images/delete/${id}`,
                  method : "delete",
                  success: function(result){
                  if(result.success == true){
                     $('#ids'+id).remove();
                      Command: toastr["success"](result.message)
                      toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                      }
                    }
                    },error:function(error){
                     console.log(error)
                     }
                  });
              }
          })
      });
  });
 </script>
@endpush

