<?php
use App\Models\Product;
?>
@extends('frontend.layouts.app')
@section('title','My Account')
@section('content')
<!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>MY Account</h3>
	</div>
</div>

<!-- typography -->
<div class="typrography">
	 <div class="container">	
		<div class="grid_3 grid_4 wow fadeInLeft animated" data-wow-delay=".5s">
		    <div class="login-grids">
                <div class="login">
                    <div class="account-bottom">
                        <h3>Contact Details</h3>
                        <form id="contactDetails" action="{{ route('account.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Name :</h4>
                                <input type="text"  class="@error('name') is-invalid @enderror" name="name" id="name" value="{{ $user->name ?? ''}}" placeholder="Enter Name">	
                            </div>

                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Email :</h4>
                                <input type="email" id="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? '' }}" placeholder="Enter Email">
                            </div>
                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Address :</h4>
                                <input type="text"  class="@error('address') is-invalid @enderror" name="address" id="address" value="{{ $user->address ?? '' }}" placeholder="Enter Address">	
                            </div>

                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Mobile :</h4>
                                <input type="number"  class="@error('mobile') is-invalid @enderror" name="mobile" id="mobile" value="{{ $user->mobile ?? '' }}" placeholder="Enter Mobile">	
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="sign-up">
                                        <h4 style="margin-bottom: 5px;">Image :</h4>
                                        <input type="file" id="image" name="image">	<br>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="sign-up">
                                        <img width="50" height="50" id="showImage" src="{{(!empty($user->image)) ? asset("storage/user_image/".$user->image) : asset('/upload/extra.jpg')}}" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="sign-up">
                                <input type="submit" value="UPDATE" >
                            </div>
                            
                        </form>
                    </div>
                    <div class="account-right">
                        <h3>Update Password </h3>
                        <form id="updatePassword" action="{{ route('password.update')}}" method="post">
                            @csrf
                            @method('put')
                            <div class="sign-in">
                                <h4>Current Password :</h4>
                                <input type="password" id="current_password" name="current_password" placeholder="Enter Current Password"><br>
                                <span id="checkCurrentPwd" style="font-weight: bold"></span>
                            </div>

                            <div class="sign-in">
                                <h4>New Password :</h4>
                                <input type="password" id="new_pwd" name="new_pwd" placeholder="Enter New Password"><br>
                            </div>

                            <div class="sign-in">
                                <h4>Confirm Password :</h4>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password"><br>
                            </div>
                           
                            <div class="sign-in">
                                <input type="submit" value="UPDATE" >
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
               
            </div>
	    </div>
		<div class="clearfix"></div>
	</div>
</div>


<div class="coupons">
	<div class="container">
		<div class="coupons-grids text-center">
			<div class="col-md-3 coupons-gd">
				<h3>Buy your product in a simple way</h3>
			</div>
			<div class="col-md-3 coupons-gd">
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
				<h4>LOGIN TO YOUR ACCOUNT</h4>
				<p>Neque porro quisquam est, qui dolorem ipsum quia dolor
			sit amet, consectetur.</p>
			</div>
			<div class="col-md-3 coupons-gd">
				<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
				<h4>SELECT YOUR ITEM</h4>
				<p>Neque porro quisquam est, qui dolorem ipsum quia dolor
			sit amet, consectetur.</p>
			</div>
			<div class="col-md-3 coupons-gd">
				<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
				<h4>MAKE PAYMENT</h4>
				<p>Neque porro quisquam est, qui dolorem ipsum quia dolor
			sit amet, consectetur.</p>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {
            // validate signup form on keyup and submit
		$("#contactDetails").validate({
			rules: {
				name: "required",
                email: {
					required: true,
					email: true,
				},
                mobile: {
                    required: true,
					minlength: 11,
					maxlength: 11,
                    digits :true
				},
				
			},
			messages: {
				name: "Please enter your name",
				email: {
					required: "Please enter your email",
					email: "Please enter a valid email address",
				},
				
			}
		});


        $('#current_password').keyup(function(){
             let current_pwd = $('#current_password').val();
              $.ajax({
                url: "/user/check-current-pwd",
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


          $("#updatePassword").validate({
              rules: {
                current_password: {
                  required: true,
                },
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
                current_password: {
                  required: "Please choose a password",
                },

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
