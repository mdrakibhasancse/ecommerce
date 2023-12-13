@extends('admin.layouts.app')
@section('title','Product Attribute')
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
      <h3 class="card-title mt-2">Product Attribute</h3>
      <div class="card-tools">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left mr-1"></i>Back</a>
      </div>
    </div>
    <!-- /.card-header -->
    <form id="attributeForm" action="{{ route('admin.product-attributes.store')}}" method="POST">
      @csrf
      <div class="card-body">
         <input type="hidden" name="product_id" value="{{ $product->id }}">
         <div class="row">
           <div class="col-md-6">
            <div class="form-group">
              <label>Product Name : </label>&nbsp;&nbsp;
              {{ $product->name }} 
            </div>
            <div class="form-group">
              <label>Product Code : </label>&nbsp;&nbsp;
              {{ $product->code }}
            </div>
           </div>
           <div class="col-md-6">
            <div class="form-group">
              <img width="120" src="{{(!empty($product->featured_image)) ? 
               asset("storage/product_featured_images/".$product->featured_image) : asset('/upload/extra.jpg')}}" alt="">
             </div>
            </div>
         </div>
 
          
        <div class="field_wrapper">
          <div class="d-flex">
            <input type="text" name="size[]"  class="form-control" placeholder="Size"
            style="width: 110px"/>&nbsp;&nbsp;
            <input type="text" name="sku[]" class="form-control" placeholder="SKU"
            style="width: 110px"/>&nbsp;&nbsp;
            <input type="number" name="price[]" class="form-control" placeholder="Price"
            style="width: 110px"/>&nbsp;&nbsp;
            <input type="number" name="stock[]" class="form-control" placeholder="Stock"
            style="width: 110px"/>&nbsp;&nbsp;
            <a href="javascript:void(0);" class="add_button btn btn-success btn-sm text-center" title="Add field" style="height: 37px; width:37px;">
              <i class="fas fa-plus" style="margin-top: 6px; font-size:15px"></i>
            </a>
          </div>
          
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Add Attribute</button>
      </div>
    </form>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Product Attribute</h3>
    </div>
    <!-- /.card-header -->
    <form action="{{ route('admin.product-attributes.update')}}" method="POST">
      @csrf
    <div class="card-body">
      <table class="table table-bordered" id="myTable">
        <thead>
          <tr>
            <th style="width: 20px">#Id</th>
            <th>Size</th>
            <th>Sku</th>
            <th>Stock</th>
            <th>Price</th>
            <th style="width: 100px">Action</th>
          </tr>
        </thead>
        <tbody>
           @foreach($product->attributes as $attribute)
           <input style="display: none" type="text" name="attribute_id[]" value="{{$attribute->id}}">
             <tr id="ids{{$attribute->id}}">
              <td style="width: 20px">{{ $attribute->id }}</td>
              <td>{{ $attribute->size }}</td>
              <td>{{ $attribute->sku }}</td>
              <td>
                 <input type="number" name="stock[]" value="{{  $attribute->stock }}" required>
              </td>
              <td>
                <input type="number" name="price[]" value="{{  $attribute->price }}" required>
             </td>
              <td style="width: 100px">
                <button title="Delete" class="btn btn-danger btn-sm" id="attributeDelete"
                 data-id ="{{$attribute->id}}"><i class="fas fa-trash"></i></button> 
              </td>
             </tr>
           @endforeach
          
        </tbody>
      </table>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Update Attribute</button>
    </div>
    </form>
    <!-- /.card-body -->
  </div>
@endsection



@push('scripts')
 <script>
   $( document ).ready(function() {
      var maxField = 10; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var fieldHTML = '<div class="d-flex" style="margin-top: 8px;"><input name="size[]" class="form-control" placeholder="Size" style="width: 110px"/>&nbsp;&nbsp;<input name="sku[]" class="form-control" placeholder="SKU" style="width: 110px"/>&nbsp;&nbsp;<input name="price[]" class="form-control" placeholder="Price" style="width: 110px"/>&nbsp;&nbsp;<input name="stock[]" class="form-control" placeholder="Stock" style="width: 110px"/>&nbsp;&nbsp;<a href="javascript:void(0);" style="height: 37px; width:37px;" class="remove_button btn btn-danger btn-sm"><i class="fas fa-trash" style="margin-top: 6px; font-size:15px"></i></a></div>'; //New input field html
      var x = 1; //Initial field counter is 1
      
      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields
          if(x < maxField){ 
              x++; //Increment field counter
              $(wrapper).append(fieldHTML); //Add field html
          }
      });
      
      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          $(this).parent('div').remove(); //Remove field html
          x--; //Decrement field counter
      });

    //  jQuery validate
    jQuery("#attributeForm").validate({
          rules: {
           "size[]" : {
              required: true,
            },
            "sku[]" : {
              required: true,
            },
            "stock[]" : {
              required: true,
            },
            "price[]": {
              required: true,
            },

            "color[]" : {
              required: true,
            },
          },
          messages: {
          
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });


        $(document).on("click","#attributeDelete",function(e){
                e.preventDefault();
                let id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete attribute it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url    : `/admin/product-attributes/delete/${id}`,
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

