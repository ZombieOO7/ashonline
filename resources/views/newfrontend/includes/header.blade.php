@php
$routeName = Route::currentRouteName();
$islogout = logoutUser();
forgotTestSession();
$url = route('firstpage');
@endphp
<script>
	var isLogout = '{{$islogout}}';
	var url = '{{$url}}';
	if(isLogout == 1){
		window.location.replace(url);
	}
</script>

<header id="header" class="header">
@php
      $webSetting = getWebSettings();
      $promoCode = promocode();
	  $isParent = false;
@endphp

    @if($promoCode && $webSetting->code_status == 1 && $isParent ==true) <!-- Check if promo code is active-->
      <div class="top_text">

        <p>{{$promoCode->discount_1}}% OFF ORDERS ABOVE {{@config('constant.default_currency_symbol').$promoCode->amount_1}}. {{$promoCode->discount_2}}% OFF ORDERS ABOVE {{@config('constant.default_currency_symbol').$promoCode->amount_2}}. USE CODE: {{$promoCode->code}}</p>

      </div>
    @endif

	<div class="top_header">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="{{route('firstpage')}}"><img
						src="{{asset('newfrontend/images/ashace_logo.png')}}" alt="AshACE" title="AshACE"></a>
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
							class="nav-item dropdown dropdown_mbl @if($routeName == 'home' || $routeName == 'legal.and.other.documents') active @endif">
							<a class="nav-link dropdown-toggle" href="{{route('firstpage')}}" id="papersMenu"
								role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('frontend.home')}}</a>
							<div class="dropdown-menu" aria-labelledby="papersMenu">
								<a class="dropdown-item" href="{{ route('about-us') }}">{{__('frontend.about_us')}}</a>
								<a class="dropdown-item " href="{{ route('benefits') }}">{{__('frontend.benefits')}}</a>
								<a class="dropdown-item" href="{{ route('testimonials') }}">{{__('frontend.testimonials')}}</a>
								<a class="dropdown-item" href="{{ route('eblogs/index') }}">{{__('frontend.blogs')}}</a>
								<a class="dropdown-item @if($routeName == " legal.and.other.documents") active @endif"
									href="{{ route('legal.and.other.documents') }}">{{__('frontend.legal_and_other_documents')}}</a>

							</div>
						</li>
						@if(!Auth::guard('student')->user())
							<li class="nav-item dropdown dropdown_mbl @if($routeName == 'home' || $routeName == 'papers' || $routeName == 'tution') active @endif">
								<a class="nav-link dropdown-toggle epaper" id="epapersMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-href="{{route('home')}}">E-Papers</a>
								<div class="dropdown-menu" aria-labelledby="epapersMenu">
									<a class="dropdown-item" href="{{ route('home') }}">{{__('frontend.papers_lbl')}}</a>
									<a class="dropdown-item " href="{{ route('tution') }}">{{__('frontend.tution')}}</a>
								</div>
							</li>
							<li class="nav-item @if($routeName == 'e-mock' || $routeName == 'mock-detail') active @endif">
								<a class="nav-link" href="{{ route('e-mock') }}">{{__('frontend.emock.title')}}</a>
							</li>
						@endif
						<li class="nav-item @if($routeName == 'practice') active @endif">
							<a class="nav-link" href="{{ route('practice') }}">{{__('frontend.practice')}}</a>
						</li>
                        <li class="nav-item dropdown dropdown_mbl @if (\Request::is('resources/*papers*') || \Request::is('resources/guidance*') || \Request::is('eresource/detail*')) active @endif">
                            <a class="nav-link dropdown-toggle" href="{{route('firstpage')}}" id="papersMenu"
								role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{__('frontend.resources')}}</a>
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
							<a class="nav-link" href="{{route('contact-us')}}">{{__('frontend.contact')}}</a>
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
						<a href="javascript:void(0)" class="ash_lgn_btn loginBtn">{{__('frontend.login')}}</a>
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
								<a class="dropdown-item" href="{{ route('parent-profile') }}">{{__('frontend.profile')}}</a>
							@endif
                            @if(Auth::guard('student')->user() != null)
                                <a class="dropdown-item" href="{{ route('student-profile') }}">{{__('frontend.profile')}}</a>
                            @endif
							<a class="dropdown-item" href="{{route('user.logout')}}">{{__('frontend.logout')}}</a>
						</div>
					</div>
				</div>
				@endif
			</nav>
		</div>

	</div>
	<div class="main_loader" style="display:none; margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;">
		<p style="position: absolute; color: White; top: 50%; left: 45%;">
		Loading, please wait...
		<img src="{{ URL::asset('images/loader.svg') }}" height="75px;" width="75px;">
		</p>
	</div>

</header>
<!--Login Modal -->
<div class="modal fade def_modal lgn_modal" id="LoginModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
			<div class="modal-body">
				<form class="def_form" id='login' aria-label="{{ __('frontend.login') }}">
					<h3 class='childUsername' style="display: none;">{{__('frontend.child_login')}}</h3>
					<h3 class='parentMail'>{{__('frontend.parent_login')}}</h3>
					<p class="mrgn_bt_40">{{__('frontend.login_label')}}</p>
					@csrf
					<div class="row">
						<div class="col-md-12 parentMail">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="{{__('frontend.email_address')}}"
									name="email">
							</div>
						</div>
						<input type="hidden" name="type" value="parent" id='type'>
						<div class="col-md-12 childUsername" style="display: none;">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="{{__('frontend.user_name')}}"
									name="username">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<input type="password" class="form-control" placeholder="{{__('frontend.password')}}" name="password">
							</div>
						</div>
						<div class="col-md-12 text-right">
							<a href="javascript:;" class="frgt_pswrd">{{__('frontend.forgot_password')}}</a>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" id='loginBtn' class="btn submit_btn">{{__('frontend.login')}}
									<div class="lds-ring" style="display:none;">
										<div></div>
										<div></div>
										<div></div>
									</div>
								</button>
							</div>
						</div>
						<div class="col-md-12 btm_action">
							<p>{{__('frontend.not_having_an_account')}} <a href="{{ route('parent-sign-up') }}">{{__('frontend.sign_up')}}</a></p>
						</div>
						<div class="col-md-12 btm_action parentMail">
							<p><a href="javascript:;" class="childLogin">{{__('frontend.child_login')}}</a></p>
						</div>
						<div class="col-md-12 btm_action childUsername" style="display: none;">
							<p><a href="javascript:;" class="parentLogin">{{__('frontend.parent_login')}}</a></p>
						</div>
					</div>
				</form>
				<form class="def_form" id='forgotPassword' aria-label="{{__('frontend.forgot_password')}}" style="display:none;">
					<h3>{{__('frontend.forgot_password')}}</h3>
					@csrf
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Email Address"
									name="email">
							</div>
						</div>
						<div class="col-md-12 text-right">
							<a href="javascript:;" id="loginLink">{{__('frontend.login')}}
							</a>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn submit_btn">{{__('frontend.submit')}}
									<div class="lds-ring" style="display:none;">
										<div></div>
										<div></div>
										<div></div>
									</div>
								</button>
							</div>
						</div>
						<div class="col-md-12 btm_action">
							<p>{{__('frontend.not_having_an_account')}} <a href="{{ route('parent-sign-up') }}">{{__('frontend.sign_up')}}</a></p>
						</div>
					</div>
				</form>
			</div>
			<div class="lgn_note">
				<span>{{__('frontend.note_label')}}</span>: {{__('frontend.login_note')}}
			</div>
		</div>
	</div>
</div>
