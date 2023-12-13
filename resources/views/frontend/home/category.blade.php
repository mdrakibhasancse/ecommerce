<?php
use App\Models\Product;
?>
@extends('frontend.layouts.app')
@section('title','Category Page')
@section('content')
<!-- banner -->
<div class="page-head">
	<div class="container">
		<h3>{{ $category->name }}</h3>
	</div>
</div>
<!-- //banner -->
<!-- mens -->
<div class="men-wear">
	<div class="container">
		<div class="col-md-4 products-left">
			<div class="css-treeview">
				<h4>Categories</h4>
				<ul class="tree-list-pad">
                    @foreach($sections as $value => $description)
					@php
						$slug = preg_replace('/\s+/u', '-', trim(strtolower($description)));
					@endphp
					<li><input type="checkbox" checked="checked" id="item-0" /><label for="item-0"><span></span>{{$description}}</label>
						<ul>
                            @php
								$categories = DB::table('categories')->where('section_id', $value)->where('status',1)->get();
							@endphp
                          @foreach($categories as $row)
						  <li>
                            <a href="{{ route('category', ['section' => $slug ,'slug' => $row->slug])}}">{{ $row->name }}</a>
                          </li>
                          @endforeach
						</ul>
					</li>
					@endforeach
				</ul>
			</div>
			{{-- <div class="community-poll">
				<h4>Community Poll</h4>
				<div class="swit form">	
					<form>
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio" checked=""><i></i>More convenient for shipping and delivery</label> </div></div>
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Lower Price</label> </div></div>
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Track your item</label> </div></div>
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Bigger Choice</label> </div></div>
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>More colors to choose</label> </div></div>	
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Secured Payment</label> </div></div>
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Money back guaranteed</label> </div></div>	
					<div class="check_box"> <div class="radio"> <label><input type="radio" name="radio"><i></i>Others</label> </div></div>		
					<input type="submit" value="SEND">
					</form>
				</div>
			</div> --}}
			<div class="clearfix"></div>
		</div>
		<div class="col-md-8 products-right">
			<h5>Product Compare</h5>
			<div class="sort-grid">
				<form name="shortProducts" id="shortProducts">
					<div class="sorting">
						<h6>Sort By</h6>
						<select name="sort" id="sort" class="frm-field required sect">
							<option value="null">Default</option>
							<option value="product_latest" @if(isset($_GET['sort']) && ($_GET['sort'] == 'product_latest')) selected="" @endif>
								Latest Product
							</option> 
							<option value="price_lowest" @if(isset($_GET['sort']) && ($_GET['sort'] == 'price_lowest')) selected="" @endif>
								Lowest Price
							</option>	
							<option value="price_highest" @if(isset($_GET['sort']) && ($_GET['sort'] == 'price_highest')) selected="" @endif>
								Highest Price
							</option>
							<option value="name_a_z" @if(isset($_GET['sort']) && ($_GET['sort'] == 'name_a_z')) selected="" @endif>
								Name (A - Z)
							</option>
							<option value="name_z_a"  @if(isset($_GET['sort']) && ($_GET['sort'] == 'name_z_a')) selected="" @endif>
								Name (Z - A)
							</option>					
						</select>
						<div class="clearfix"></div>
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
			<div class="men-wear-top">
				<script src="{{asset("/frontend/js/responsiveslides.min.js")}}"></script>
				<script>
						// You can also use "$(window).load(function() {"
						$(function () {
						 // Slideshow 4
						$("#slider3").responsiveSlides({
							auto: true,
							pager: true,
							nav: false,
							speed: 500,
							namespace: "callbacks",
							before: function () {
						$('.events').append("<li>before event fired.</li>");
						},
						after: function () {
							$('.events').append("<li>after event fired.</li>");
							}
							});
						});
				</script>
				
				<div class="clearfix"></div>
			</div>

			@foreach($products->take(3) as $product) 
			<div class="col-md-4 product-men no-pad-men">
					<div class="men-pro-item simpleCart_shelfItem">
						<div class="men-thumb-item">
							<img src="{{asset("/storage/product_featured_images/$product->featured_image")}}" alt="" class="pro-image-front">
							<img src="{{asset("/storage/product_featured_images/$product->featured_image")}}" alt="" class="pro-image-back">
								<div class="men-cart-pro">
									<div class="inner-men-cart-pro">
										<a href="{{ route('single', ['category' => $product->category->slug ,'slug' => $product->slug])}}" class="link-product-add-cart">
											Quick View
										</a>
									</div>
								</div>
							<span class="product-new-top">New</span>
										
						</div>
						<div class="item-info-product ">
							<h4><a href="{{ route('single', ['category' =>   $product->category->slug ,'slug' => $product->slug])}}">
								{{ Str::limit($product->name, 15) }}</a>
							</h4>
								<div class="info-product-price">
									@php
									$getDiscountPrice = Product::getDiscountPrice($product->id);
									@endphp
									@if($getDiscountPrice > 0)
									<span class="item_price">Tk.{{ $getDiscountPrice }}</span>
									<del>Tk.{{ $product->price }}</del>
									   @else
									<span class="item_price">Tk.{{ $product->price }}</span>
									@endif
								</div>
								<a href="#" class="item_add single-item hvr-outline-out button2">Add to cart</a>									
						</div>
					</div>
			</div>	
			@endforeach
			<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<div class="single-pro">
			@foreach($products->skip(3) as $product) 
				<div class="col-md-3 product-men" style="margin-top: 30px;">
					<div class="men-pro-item simpleCart_shelfItem">
						<div class="men-thumb-item">
							<img src="{{asset("/storage/product_featured_images/$product->featured_image")}}" alt="" class="pro-image-front">
							<img src="{{asset("/storage/product_featured_images/$product->featured_image")}}" alt="" class="pro-image-back">
								<div class="men-cart-pro">
									<div class="inner-men-cart-pro">
										<a href="{{ route('single', ['category' => $product->category->slug ,'slug' => $product->slug])}}" class="link-product-add-cart">Quick View</a>
									</div>
								</div>
							<span class="product-new-top">New</span>				
						</div>
						<div class="item-info-product ">
							<h4><a href="{{ route('single', ['category' => $product->category->slug ,'slug' => $product->slug])}}">{{ Str::limit($product->name, 15) }}</a></h4>
								<div class="info-product-price">
										@php
										$getDiscountPrice = Product::getDiscountPrice($product->id);
										@endphp
										@if($getDiscountPrice > 0)
										<span class="item_price">Tk.{{ $getDiscountPrice }}</span>
										<del>Tk.{{ $product->price }}</del>
										@else
										<span class="item_price">Tk.{{ $product->price }}</span>
										@endif
								</div>
								<a href="#" class="item_add single-item hvr-outline-out button2">Add to cart</a>							
						</div>
					</div>
				</div>
			@endforeach
	
		<div class="clearfix"></div>
          @if(isset($_GET['sort']))
		  <div style="margin-left: 15px;">
            {{ $products->appends(['sort' => $_GET['sort']])->links() }}
          </div>
		  @else
		  <div style="margin-left: 15px;">
            {{ $products->links() }}
          </div>
		  @endif
		</div>
		{{-- <div class="pagination-grid text-right">
			<ul class="pagination paging">
				<li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
				<li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
			</ul>
		</div> --}}
	</div>
</div>	
<!-- //mens -->
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
   $('#sort').on('change', function() {
       this.form.submit();
   });
});	
</script>
@endpush
