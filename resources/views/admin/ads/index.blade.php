@extends('admin.layouts.app')
@section('title','Ads')
@section('content-title') 
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Category</h1>
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
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Ads List</h3>

      <div class="card-tools">
        <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">Add Ads</a>
      </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="myTable">
            <thead>
              <tr>
                <th style="width: 20px">#Sl</th>
                <th>Section</th>
                <th>Category</th>
                <th>Product</th>
                <th>Image</th>
                <th style="width: 100px">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($ads as $row)
                <tr id="ids{{$row->id}}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ App\Enums\Section::getDescription($row->section_id) }}</td>
                    <td>{{ $row->category->name }}</td>
                    <td>{{ $row->product->name }}</td>
                    <td><img width="50px" src="{{(!empty($row->image)) ? 
                      asset("storage/ads_images/".$row->image) : asset('/upload/extra.jpg')}}" alt=""></td>
                    <td>
                        <a href="{{ route('admin.ads.edit',$row->id)}}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" id="adsDelete"
                        data-id ="{{$row->id}}">Delete</button>  
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
            $(document).on("click","#adsDelete",function(e){
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
                            url    : `/admin/ads/${id}`,
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