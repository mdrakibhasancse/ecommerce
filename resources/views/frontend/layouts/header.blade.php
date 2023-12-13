<!-- header -->
<div class="header">
	<div class="container">
		<ul>
			<li><span class="glyphicon glyphicon-time" aria-hidden="true"></span>Free and Fast Delivery</li>
			<li><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>Free shipping On all orders</li>
			<li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span><a href="mailto:info@example.com">info@example.com</a></li>
		</ul>
	</div>
</div>
<!-- //header -->
<!-- header-bot -->
<div class="header-bot">
	<div class="container">
		<div class="col-md-3 header-left">
			<h1><a href="index.html"><img src="{{asset("/frontend/images/logo3.jpg")}}"></a></h1>
		</div>
		<div class="col-md-6 header-middle">
			<form>
				<div class="search">
					<input type="search" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" required="">
				</div>
				<div class="section_room">
					<select id="country" onchange="change_country(this.value)" class="frm-field required">
						<option value="null">All categories</option>
						@foreach($sections as $value => $description)
						<option value="null">{{ $description }}</option>
						@endforeach
					</select>
				</div>
				<div class="sear-sub">
					<input type="submit" value=" ">
				</div>
				<div class="clearfix"></div>
			</form>
		</div>

		<div class="col-md-3 header-right footer-bottom">
			<ul>
				<li><a class="fb" href="#"></a></li>
				<li><a class="twi" href="#"></a></li>
				<li><a class="insta" href="#"></a></li>
				<li><a class="you" href="#"></a></li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- //header-bot -->
<!-- banner -->
<div class="ban-top">
	<div class="container">
		<div class="top_nav_left">
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse menu--shylock" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav menu__list">
					<li class="active menu__item menu__item--current"><a class="menu__link" 
					href="{{url('/')}}">Home <span class="sr-only">(current)</span></a></li>
					
					@foreach($sections as $value => $description)
					@php
						$slug = preg_replace('/\s+/u', '-', trim(strtolower($description)));
					@endphp
					<li class="dropdown menu__item">
						<a href="" class="dropdown-toggle menu__link" data-toggle="dropdown" role="button">{{ $description }} <span class="caret"></span></a>
							<ul class="dropdown-menu multi-column columns-3">
								<div class="row">
									@php
										$categories = DB::table('categories')->where('section_id', $value)->where('status',1)->get();
										$collection = array_chunk($categories->all(), ceil(count($categories)/2));
									@endphp

									@foreach($collection as $row)
									<div class="col-sm-6 multi-gd-img">
										<ul class="multi-column-dropdown">
											@foreach($row as $category)
											 <li><a href="{{ route('category', ['section' => $slug ,'slug' => $category->slug])}}">{{ $category->name}}</a></li>
											@endforeach
										</ul>
									</div>
									@endforeach
									<div class="clearfix"></div>
								</div>
							</ul>
					</li>
					@endforeach
					
					<li class="menu__item"><a class="menu__link" href="contact.html">contact</a></li>

					

					@if(Auth::check())
					<li>
						<a href="{{ route('account')}}" class="menu__link">
						  My Account
					   </a>
				   </li>

					<li class="menu__item">
						<a class="menu__link" href="{{ route('user.logout')}}">Logout</a>
					</li>
					@else
					<li class="menu__item"><a class="menu__link" 
					href="{{ url('/user/login')}}">Login</a></li>
					<li class="menu__item"><a class="menu__link" 
					href="{{ url('/user/register')}}">Register</a></li>
					@endif

				  </ul>
				</div>
			  </div>
			</nav>	
		</div>
		<div class="top_nav_right">
			<div class="cart box_1">
						<a href="{{ route('checkout')}}">
							<h3> 
								<div class="total">
								<i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i>
								(<span class="totalCartItems">{{ totalCartItems() }}</span> items)
							    </div>
							</h3>
						</a>	
						<p><a href="{{ route('checkout')}}" class="simpleCart_empty">Tk. {{ totalCartAmount() }}</a></p>	
			</div>	
		</div>
		<div class="clearfix"></div>
	</div>
</div>

@push('css')
	
@endpush