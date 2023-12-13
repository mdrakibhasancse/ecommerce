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
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Product List</h3>

      <div class="card-tools">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
      </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="myTable">
            <thead>
              <tr>
                <th style="width: 20px">#Sl</th>
                <th>Name</th>
                <th>Image</th>
                <th>price</th>
                <th>Code</th>
                <th>Section</th>
                <th>Category</th>
                <th>Status</th>
                <th style="width: 130px">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($product as $row)
                <tr id="ids{{$row->id}}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->name }}</td>
                    <td><img width="50px" src="{{(!empty($row->featured_image)) ? 
                    asset("storage/product_featured_images/".$row->featured_image) : asset('/upload/extra.jpg')}}" alt=""></td>
                    <td>{{ $row->price }}</td>
                    <td>{{ $row->code }}</td>
                    <td>{{ App\Enums\Section::getDescription($row->section_id) }}</td>
                    <td>{{ $row->category->name }}</td>
                    <td>
                        <input type="checkbox" data-toggle="toggle" data-on="Active"  data-off="Inactive" id="productStatus" data-slug="{{$row->slug}}"
                        data-size="small" data-width="85" data-onstyle="success" data-offstyle="danger" {{ $row->status === 1 ? 'checked' : ''}}>
                    </td>
                    <td>
                        <a title="Add-Attribute" href="{{ route('admin.product-attributes',$row->id) }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></a>

                        <a title="Add-Images" href="{{ route('admin.product-images',$row->id) }}" class="btn btn-info btn-sm"><i class="fas fa-images"></i></a>


                        <a title="Edit" href="{{ route('admin.products.edit',$row->slug) }}" 
                        class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>

                        <button title="Delete" class="btn btn-danger btn-sm" id="productDelete"
                        data-id ="{{$row->id}}"><i class="fas fa-trash"></i></button>  
                    </td>
                  </tr> 
                @endforeach
            </tbody>
          </table>
    </div>
 
</div>
@endsection

@push('scripts')
 <script>
        $( document ).ready(function() {
            $(document).on("click","#productDelete",function(e){
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
                            url    : `/admin/products/${id}`,
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

          //change status
          $(document).on("change","#productStatus",function(e){
                e.preventDefault();
                let slug = $(this).attr('data-slug');
                if(this.checked){
                  var status = 1;
                }else{
                  var status = 0;
                }
                let change = status == 1 ? 'Active' : 'Inactive';

                $.ajax({
                    url    : "{{ route('admin.product.status') }}",
                    method : "get",
                    data   : {slug : slug , status : status},
                    success: function(result){
                        if(result.success == true){
                             Command: toastr["success"](result.message +' '+ change +'!!')
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
            });
        });
 </script>   
@endpush