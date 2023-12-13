<?php
use App\Models\Product;
?>
@extends('frontend.layouts.app')
@section('title','Login')
@section('content')
<!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>Login</h3>
	</div>
</div>

<!-- typography -->
<div class="typrography">
	 <div class="container">	
		<div class="grid_3 grid_4 wow fadeInLeft animated justify-center" data-wow-delay=".5s">
		    <div class="login-grids">
                <div class="login">
                    <div class="login-right">
                        @if (Session::has('l_success_message'))
						<div class="alert alert-success" role="alert">
							 {{Session::get('l_success_message')}}
							 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							   <span aria-hidden="true">&times;</span>
							 </button>
						 </div>
						 @endif
						@if (Session::has('l_error_message'))
						<div class="alert alert-danger" role="alert">
							{{Session::get('l_error_message')}}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						@endif
                        <h3 style="text-align:center;font-size:30px;">Login</h3>
                        <form id="loginForm" action="{{ url('user/login') }}" method="post">
                            @csrf
                            <div class="sign-in">
                                <h4>Email :</h4>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email">	
								@error('email')
								<span style="color: red">{{ $message }}</span>
							    @enderror
                            </div>
                            <div class="sign-in">
                                <h4>Password :</h4>
                                <input type="password" id="password" name="password" placeholder="Enter Password"><br>
                                @error('password')
								<span style="color: red">{{ $message }}</span>
							    @enderror
                            </div>
                           
                            <div class="sign-in">
                                <input type="submit" value="SIGNIN" >
                            </div>
                        </form>
                    </div>
					<p style="color: #7B7B7B; font-size: 16px;">New customer? 
						<a style="color: #FDA30E;" href="{{ url('/user/register')}}">Register
						</a> here.
					</p>
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
       
        $("#loginForm").validate({
			rules: {
                email: {
					required: true,
					email: true,
				},

				password: {
					required: true,
					minlength: 6
				},
				
			},
			messages: {
				email: {
					required: "Please enter your email",
					email: "Please enter a valid email address",
				},
				password: {
					required: "Please choose a password",
					minlength: "Your password must be at least 6 characters long"
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
