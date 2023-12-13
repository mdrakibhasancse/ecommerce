@extends('admin.layouts.app')
@section('title','Profile')
@section('content-title')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Admin Profile</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->  
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{(!empty($admin->image)) ? asset("storage/admin_image/".$admin->image) : asset('/upload/extra.jpg')}}" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{ Str::ucfirst($admin->name) }}</h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right">{{ $admin->email }}</a>
                </li>
                <li class="list-group-item">
                  <b>Mobile</b> <a class="float-right">{{ $admin->mobile ?? '' }}</a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
         
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Update Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Change Password</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="settings">
                  <form id="updateProfile" method="post" action="{{ route('admin.profile.update')}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                      <label for="name" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                        <input type="text" name="name" value="{{ $admin->name }}" class="form-control" id="name">
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="email" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="email" name="email" value="{{ $admin->email }}" class="form-control" id="email">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="mobile" class="col-sm-2 col-form-label">Mobile</label>
                      <div class="col-sm-10">
                        <input type="number" name="mobile" value="{{ $admin->mobile }}" class="form-control" id="mobile">
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-4">
                          <input type="file" name="image" id="image">
                        </div>
                        <div class="col-sm-4">
                          <img width="50" height="50" id="showImage" src="{{(!empty($admin->image)) ? asset("storage/admin_image/".$admin->image) : asset('/upload/extra.jpg')}}" alt="">
                        </div>
                    </div>
                   
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Upddate</button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="tab-pane" id="timeline">
                  <form id="updatePasswordForm" method="post" action="{{ route('admin.password.update')}}">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                      <label for="current_password" class="col-sm-3 col-form-label">Current Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Enter Current Password">
                        <span id="checkCurrentPwd" style="font-weight: bold"></span>
                        @error('current_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    </div>

                    <div class="form-group row">
                        <label for="new_pwd" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                        <input type="password" name="new_pwd" class="form-control" id="new_pwd" placeholder="Enter New Password">
                        @error('new_pwd')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    </div>

                      <div class="form-group row">
                        <label for="confirm_pwd" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                          <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Enter Again New Password">
                      </div>
                      </div>

                    <div class="form-group row">
                      <div class="offset-sm-3 col-sm-9">
                        <button type="submit" class="btn btn-success">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->

                
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
@endsection


@push('scripts')
    <script>
       $( document ).ready(function() {
          $('#current_password').keyup(function(){
             let current_pwd = $('#current_password').val();
              $.ajax({
                url: "/admin/check-current-pwd",
                method: 'post',
                data: { current_pwd : current_pwd },
                success: function(result){
                  if(result.success == true){
                    $('#checkCurrentPwd').html("<font style='color: green;'>current password is correct</font>");
                  }else if(result.success == false){
                    $('#checkCurrentPwd').html("<font style='color: red;'>current password is iscorrect</font>");
                  }
                },error:function(error){
                   console.log(error)
                }
            });
          });

          $("#updatePasswordForm").validate({
              rules: {
                new_pwd: {
                  required: true,
                  minlength: 6
                },
                confirm_password: {
                  required: true,
                  minlength: 6,
                  equalTo: "#new_pwd"
                },
                
              },
              messages: {
                new_pwd: {
                  required: "Please choose a password",
                  minlength: "Your password must be at least 6 characters long"
                },

                confirm_password: {
                  required: "Please choose a password",
                  minlength: "Your password must be at least 6 characters long",
                }, 
              }
            });


            
          $("#updateProfile").validate({
            rules: {
                name   : "required",
                email  : "required",
                mobile : "required",
                image  : "required",
                
              },
              messages: {
                name  : "Please enter your name",
                email : "Please enter your email",
                mobile: "Please enter your mobile",
                image : "Please enter your image",  
              }
            });

          //image show
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

@push('css')
    <style>
        form.cmxform label.error, label.error {
            color: red;
            font-style: italic;
        }
    </style>
@endpush

