<?php
use App\Models\Product;
?>
@extends('frontend.layouts.app')
@section('title','Register')
@section('content')
<!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>Login/Register</h3>
	</div>
</div>

<!-- typography -->
<div class="typrography">
	 <div class="container">	
		<div class="grid_3 grid_4 wow fadeInLeft animated justify-center" data-wow-delay=".5s">
		    <div class="login-grids">
                <div class="login">
                    <div class="login-bottom">
						@if (Session::has('r_success_message'))
						<div class="alert alert-success" role="alert">
							 {{Session::get('r_success_message')}}
							 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							   <span aria-hidden="true">&times;</span>
							 </button>
						 </div>
						 @endif
						@if (Session::has('r_error_message'))
						<div class="alert alert-danger" role="alert">
							{{Session::get('r_error_message')}}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						@endif
                        <h3 style="text-align:center; font-size:30px;">Register</h3>
                        <form id="registerForm" action="{{ url('/user/register') }}" method="post">
                            @csrf
                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Name :</h4>
                                <input type="text"  class="@error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Enter Name">	
								@error('name')
								<span style="color: red">{{ $message }}</span>
							    @enderror
                            </div>

                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Email :</h4>
                                <input type="email" id="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email">
								@error('email')
								<span style="color: red">{{ $message }}</span>
							    @enderror
                            </div>
                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Password :</h4>
                                <input type="password" id="password" name="password" placeholder="Enter Password">
								@error('password')
								<span style="color: red">{{ $message }}</span>
							    @enderror
                            </div>
                            <div class="sign-up">
                                <h4 style="margin-top: 5px;">Confirm Password :</h4>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter confirm Password">     
                            </div>
                            <div class="sign-up">
                                <input type="submit" value="REGISTER NOW" >
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
		$("#registerForm").validate({
			rules: {
				name: "required",
				password: {
					required: true,
					minlength: 6
				},
                email: {
					required: true,
					email: true,
                    romote: "/user/check-email"
				},

				confirm_password: {
					required: true,
					minlength: 6,
					equalTo: "#password"
				},
				
			},
			messages: {
				name: "Please enter your name",
				email: {
					required: "Please enter your email",
					email: "Please enter a valid email address",
                    romote: "Email already exits"
				},
				password: {
					required: "Please choose a password",
					minlength: "Your password must be at least 6 characters long"
				},
				confirm_password: {
					required: "Please choose a password",
					minlength: "Your password must be at least 6 characters long",
				},
				
			}
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
