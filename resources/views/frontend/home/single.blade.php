<?php
use App\Models\Product;
?>
@extends('frontend.layouts.app')
@section('title','Single Page')
@section('content')
<!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>{{ $product->name }}</h3>
	</div>
</div>
<!-- //banner -->
<!-- single -->
<div class="single">
	<div class="container">
		<div class="col-md-6 single-right-left animated wow slideInUp animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInUp;">
			<div class="grid images_3_of_2">
				<div class="flexslider">
					<!-- FlexSlider -->
						<script>
						// Can also be used with $(document).ready()
							$(window).load(function() {
								$('.flexslider').flexslider({
								animation: "slide",
								controlNav: "thumbnails"
								});
							});
						</script>
					<!-- //FlexSlider--> 
					<ul class="slides">
						<li data-thumb="{{asset("/storage/product_featured_images/$product->featured_image")}}">
							<div class="thumb-image"> <img src="{{asset("/storage/product_featured_images/$product->featured_image")}}" data-imagezoom="true" class="img-responsive"> </div>
						</li>

						@foreach($product->images as $image)
						<li data-thumb="{{asset("storage/product_images/".$image->images) }}">
							<div class="thumb-image"> <img src="{{asset("storage/product_images/".$image->images) }}" data-imagezoom="true" class="img-responsive"> </div>
						</li>
						@endforeach
					</ul>
					<div class="clearfix"></div>
				</div>	
			</div>
		</div>
		<div class="col-md-6 single-right-left simpleCart_shelfItem animated wow slideInRight animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInRight;">
			   <form action="{{ route('add-to-cart')}}" method="post">
				   @csrf
				   <input type="hidden" name="product_id" value="{{ $product->id }}">
					<h3>{{ $product->name }}</h3><br>
					{{-- <div class="rating1">
						<span class="starRating">
							<input id="rating5" type="radio" name="rating" value="5">
							<label for="rating5">5</label>
							<input id="rating4" type="radio" name="rating" value="4">
							<label for="rating4">4</label>
							<input id="rating3" type="radio" name="rating" value="3" checked="">
							<label for="rating3">3</label>
							<input id="rating2" type="radio" name="rating" value="2">
							<label for="rating2">2</label>
							<input id="rating1" type="radio" name="rating" value="1">
							<label for="rating1">1</label>
						</span>
					</div> --}}

					
					<div class="occasional">
						@if($total_stock)
						<h5>Available Stock({{ $total_stock }})</h5>	
						@else
						<h5>No Available Stock</h5>
						@endif
					</div>

					<p>
						<span class="getArrtibutePrice">
							@php
							$getDiscountPrice = Product::getDiscountPrice($product->id);
							@endphp
							@if($getDiscountPrice > 0)
							<span class="item_price">Tk.{{ $getDiscountPrice }}</span>
							<del>Tk.{{ $product->price }}</del>
							@else
							<span class="item_price">Tk.{{ $product->price }}</span>
							@endif
						</span>
					</p>


					<div class="occasional">
						<h5>Avialable Size :</h5>
                        @foreach($product->attributes as $size)
                        <div class="colr ert">
							<label class="radio">
							 <input type="radio" value="{{ $size->size }}" id="getprice" name="size" data-id="{{ $product->id }}" 
							 data-size="{{ $size->size }}">
								<i></i>{{ $size->size }}
							</label>
						</div>
                        @endforeach
						<div class="clearfix"> </div>
					</div>

					<div class="color-quality">
						<div class="color-quality-right">
							<h5>Quality :</h5>
							<input type="number" name="quantity" value="1" min="1" style="width: 80px; height:35px; border: 1px solid gray">
						</div>
					</div>

					

                   <br>
					<div class="occasion-cart">
						<button style="border: none" class="item_add hvr-outline-out button2">
							Add to cart
						</button>
					</div>
					</form>
					
		        </div>
				<div class="clearfix"> </div>

				<div class="bootstrap-tab animated wow slideInUp animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: slideInUp;">
					<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
						<ul id="myTab" class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Description</a></li>
							<li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">Reviews</a></li>

							<li role="presentation"><a href="#information" id="information-tab" role="tab" data-toggle="tab" aria-controls="information" aria-expanded="true">Product Information</a></li>
								
						</ul>
						<div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade in active bootstrap-tab-text" id="home" aria-labelledby="home-tab">
								<h5>Product Brief Description</h5>
								<p>{!! $product->description !!}</p>
							</div>
							<div role="tabpanel" class="tab-pane fade bootstrap-tab-text" id="profile" aria-labelledby="profile-tab">
								<div class="bootstrap-tab-text-grids">
									<div class="bootstrap-tab-text-grid">
										<div class="bootstrap-tab-text-grid-left">
											<img src="{{asset("/frontend/images/men3.jpg")}}" alt=" " class="img-responsive">
										</div>
										<div class="bootstrap-tab-text-grid-right">
											<ul>
												<li><a href="#">Admin</a></li>
												<li><a href="#"><span class="glyphicon glyphicon-share" aria-hidden="true"></span>Reply</a></li>
											</ul>
											<p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis 
												suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem 
												vel eum iure reprehenderit.</p>
										</div>
										<div class="clearfix"> </div>
									</div>
									
									<div class="add-review">
										<h4>add a review</h4>
										<form>
											<input type="text" value="Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Name';}" required="">
											<input type="email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
											
											<textarea type="text" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Message...';}" required="">Message...</textarea>
											<input type="submit" value="SEND">
										</form>
									</div>
								</div>
							</div>
							
							<div role="tabpanel" class="tab-pane fade bootstrap-tab-text" id="information" aria-labelledby="information-tab">
								<div class="row">
									<div class="col-md-6">
										<h5>Product Information</h5>
										<table class="table table-border">
											<tr>
												<th style="color: black;">Name</th>
												<td>{{ $product->name }}</td>
											</tr>
											<tr>
												<th style="color: black;">Category</th>
												<td>{{ $product->category->name }}</td>
											</tr>
											<tr>
												<th style="color: black;">Code</th>
												<td>{{ $product->code }}</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
	</div>
</div>
<!-- //single -->
<!-- //product-nav -->
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
    $(document).on("click","#getprice",function() {
		let id   = $(this).attr('data-id');
		let size = $(this).attr('data-size');
		$.ajax({
			url    : "{{ route('get-product') }}",
            method : "post",
			data   : {id : id, size : size},
            success: function(result){
			 if(result.discount > 0){
				$(".getArrtibutePrice").html("<span class='item_price'>Tk."+result.final_price+"</span><del>Tk."+result.product_price+"</del>");
              }else{
				$(".getArrtibutePrice").html('<span class="item_price">'+result.product_price+'</span>'); 
			  }          
	        },error:function(){
				alert("Error");
			}
       });
    });
  });
</script>
@endpush

@push('css')
	<style>
		.occasion-cart button {
			padding: 8px 15px;
			text-decoration: none;
			color: #fff;
			font-size: 16px;
		}
	</style>
@endpush
