@extends('admin.layouts.app')
@section('title','Category')
@section('content-title') 
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Category</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Category</li>
      </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title mt-2">Category List</h3>

      <div class="card-tools">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>
      </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="myTable">
            <thead>
              <tr>
                <th style="width: 20px">#Sl</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Section</th>
                <th>Status</th>
                <th style="width: 100px">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach($category as $row)
                <tr id="ids{{$row->id}}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->slug }}</td>
                    <td>{{ App\Enums\Section::getDescription($row->section_id) }}</td>
                    <td>
                        <input type="checkbox" data-toggle="toggle" data-on="Active"  data-off="Inactive" id="categoryStatus" data-slug="{{$row->slug}}"
                        data-size="small" data-width="85" data-onstyle="success" data-offstyle="danger" {{ $row->status === 1 ? 'checked' : ''}}>
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit',$row->slug)}}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" id="categoryDelete"
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
            $(document).on("click","#categoryDelete",function(e){
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
                            url    : `/admin/categories/${id}`,
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
          $(document).on("change","#categoryStatus",function(e){
                e.preventDefault();
                let slug = $(this).attr('data-slug');
                if(this.checked){
                  var status = 1;
                }else{
                  var status = 0;
                }
                let change = status == 1 ? 'Active' : 'Inactive';

                $.ajax({
                    url    : "{{ route('admin.category.status') }}",
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