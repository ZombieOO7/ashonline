@php
$routeName = Route::currentRouteName();
// logoutUser();
@endphp

<header id="header" class="header">
    @php
        $webSetting = getWebSettings();
    @endphp
    @if (@$settings && @$webSetting->code_status == 1)
        <!-- Check if promo code is active-->
        <div class="top_text">
            <p>
                {{ __('formname.promo_code_label', ['discount_1' => @$settings->discount_1 . config('constant.percentage_symbol'), 'amount_1' => config('constant.default_currency_symbol') . @$settings->amount_1, 'discount_2' => @$settings->discount_2 . config('constant.percentage_symbol'), 'amount_2' => config('constant.default_currency_symbol') . @$settings->amount_2, 'code' => @$settings->code]) }}
            </p>
        </div>
    @endif
    <div class="top_header">
        <div class="container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="{{route('firstpage')}}"><img
						src="{{asset('frontend/images/logo.png')}}" alt="AshACE" title="AshACE-Papers"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#HomeNave"
					aria-controls="HomeNave" aria-expanded="false" aria-label="Toggle navigation">
					<span class="ash-menu"></span>
				</button>

				<div class="collapse navbar-collapse ascllps" id="HomeNave">
					<button class="navbar-toggler clssdbr_btn" type="button" data-toggle="collapse"
						data-target="#HomeNave" aria-controls="HomeNave" aria-expanded="false"
						aria-label="Toggle navigation">
						<span class="ash-cancel"></span>
					</button>
					<ul class="navbar-nav as-navbar-nav">
						<li
							class="nav-item dropdown dropdown_mbl @if($routeName == 'legal.and.other.documents') active @endif">
							<a class="nav-link dropdown-toggle" href="{{route('firstpage')}}" id="papersMenu"
								role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>
							<div class="dropdown-menu" aria-labelledby="papersMenu">
								<a class="dropdown-item" href="{{ route('about-us') }}">About Us</a>
								<a class="dropdown-item " href="{{ route('benefits') }}">Beneﬁts</a>
								<a class="dropdown-item" href="{{ route('testimonials') }}">Testimonials</a>
								<a class="dropdown-item" href="{{ route('eblogs/index') }}">Blogs</a>
								<a class="dropdown-item @if($routeName == " legal.and.other.documents") active @endif"
									href="{{ route('legal.and.other.documents') }}">Legal & Other Documents</a>

							</div>
						</li>
						<li class="nav-item dropdown dropdown_mbl @if($routeName == 'home' || $routeName == 'papers' || $routeName == 'tution') active @endif" data-href="{{route('home')}}">
							<a class="nav-link dropdown-toggle epaper" data-href="{{route('home')}}" id="epapersMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">E-Papers</a>
							<div class="dropdown-menu" aria-labelledby="epapersMenu">
								<a class="dropdown-item" href="{{ route('papers') }}">Papers</a>
								<a class="dropdown-item " href="{{ route('tution') }}">Tution</a>
							</div>
						</li>
						<li class="nav-item @if($routeName == 'e-mock' || $routeName == 'mock-detail') active @endif">
							<a class="nav-link" href="{{ route('e-mock') }}">E-Mock</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('practice') }}">Practice</a>
						</li>
                        <li class="nav-item dropdown dropdown_mbl @if (\Request::is('resources/*papers*') || \Request::is('resources/guidance*') || \Request::is('eresource/detail*')) active @endif">
                            <a class="nav-link dropdown-toggle" href="{{route('firstpage')}}" id="papersMenu"
								role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Resources</a>
							<div class="dropdown-menu" aria-labelledby="papersMenu">
								@forelse (sidebarResourceCategory() as $key => $item)
									@if($item != 'Blog')
									<a class="dropdown-item" href="{{ route('eresources/index', $key) }}">{{ $item }}</a>
									@endif
								@empty
								@endforelse
							</div>
                        </li>
						<li class="nav-item">
							<a class="nav-link" href="{{route('contact-us')}}">Contact</a>
						</li>

					</ul>

				</div>
				<div class="form-inline my-2 my-lg-0">
					<div class="nav-item dropdown">
						@if(Auth::guard('parent')->user() != null)
						<a class="cstm-drpdwn" href="{{ route('emock-cart') }}" style="text-decoration: none;">
							<span class="c_text"></span> <span class="ash-cart"><span class="itmcounts">{{ @$cartItemsTotal }}</span></span>
						</a>
						@endif
					</div>
					@php
						if(Auth::guard('parent')->user() != null){
							$user = Auth::guard('parent')->user();
						}else if(Auth::guard('student')->user() !=null){
							$user = Auth::guard('student')->user();
						}else{
							$user = null;
						}
					@endphp
					@if($user == null)
					<div class="nav-item dropdown">
						<a href="javascript:void(0)" class="ash_lgn_btn loginBtn">Login</a>
					</div>
					@endif
				</div>
				@if($user != null)
				<div class="nav-item">
					<div class="dropdown dropdownusr">
						<button class="btn btn-secondary dropdown-toggle lgn_usr" type="button" id="dropdownMenuButton"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="{{@$user->imageThumb}}" alt="">
						</button>
						<div class="dropdown-menu us_drpdwn" aria-labelledby="dropdownMenuButton">

							@if(Auth::guard('parent')->user() != null)
								<a class="dropdown-item" href="{{ route('parent-profile') }}">Proﬁle</a>
							@endif
                            @if(Auth::guard('student')->user() != null)
                                <a class="dropdown-item" href="{{ route('student-profile') }}">Proﬁle</a>
                            @endif
							<a class="dropdown-item" href="{{route('user.logout')}}">Logout</a>
						</div>
					</div>
				</div>
				@endif
			</nav>
        </div>
    </div>
    <div class="bottom_header">
        <div class="container text-center">
            @forelse(@$paperCategories as $paperCategory)
                <a href="{{ route('paper.detail', @$paperCategory->slug) }}" class="category_color_1"
                    style='background-color:{{ @$paperCategory->color_code }}'>{{ @$paperCategory->title }}</a>
            @empty
                @endif
            </div>
        </div>
    </header>
    <!--Login Modal -->
    <div class="modal fade def_modal lgn_modal" id="LoginModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <form class="def_form" id='login' aria-label="{{ __('Login') }}">
						<h3 class='childUsername' style="display: none;">Child Login</h3>
						<h3 class='parentMail'>Parent Login</h3>
						<p class="mrgn_bt_40 parentMail">Please login to your account to access features</p>
						@csrf
						<div class="row">
							<div class="col-md-12 parentMail">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Email Address"
										name="email">
								</div>
							</div>
							<input type="hidden" name="type" value="parent" id='type'>
							<div class="col-md-12 childUsername" style="display: none;">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="User Name"
										name="username">
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Password" name="password">
								</div>
							</div>
							<div class="col-md-12 text-right">
								<a href="javascript:;" class="frgt_pswrd">Forgot Password?</a>
							</div>
	
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn submit_btn">Login
										<div class="lds-ring" style="display:none;">
											<div></div>
											<div></div>
											<div></div>
										</div>
									</button>
								</div>
							</div>
							<div class="col-md-12 btm_action">
								<p>Not having an account? <a href="{{ route('parent-sign-up') }}">Sign Up</a></p>
							</div>
							<div class="col-md-12 btm_action parentMail">
								<p><a href="javascript:;" class="childLogin">Child Login</a></p>
							</div>
							<div class="col-md-12 btm_action childUsername" style="display: none;">
								<p><a href="javascript:;" class="parentLogin">Parent Login</a></p>
							</div>
						</div>
					</form>
					<form class="def_form" id='forgotPassword' aria-label="{{ __('Forgot Password') }}" style="display:none;">
						<h3>Forgot Password</h3>
						@csrf
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Email Address"
										name="email">
								</div>
							</div>
							<div class="col-md-12 text-right">
								<a href="javascript:;" id="loginLink">Login
								</a>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<button type="submit" class="btn submit_btn">Submit
										<div class="lds-ring" style="display:none;">
											<div></div>
											<div></div>
											<div></div>
										</div>
									</button>
								</div>
							</div>
							<div class="col-md-12 btm_action">
								<p>Not having an account? <a href="{{ route('parent-sign-up') }}">Sign Up</a></p>
							</div>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
