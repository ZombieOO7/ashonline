<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
    <div class="m-stack__item m-topbar__nav-wrapper">
        <ul class="m-topbar__nav m-nav m-nav--inline">
            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                m-dropdown-toggle="click">
                <a href="javascript:;" class="m-nav__link m-dropdown__toggle">
                    <span class="m-topbar__userpic">
                        <img src="{{asset('images/user_profile_bg.png')}}" class="m--img-rounded m--marginless" alt="user_profile_bg.jpg" title="user_profile_bg.jpg"
                            style="text-align: center;
                                        max-width: 40px!important;
                                        height: 40px;
                                        margin: 0 auto!important;
                                        border-radius: 50%;
                                        width: 100%;">
                    </span>
                    <span class="m-topbar__username m--hide">Nick</span>
                </a>
                <div class="m-dropdown__wrapper">
                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__header m--align-center"
                            style="background: url({{ asset('/images/user_profile_bg.png') }}); background-size: cover;">
                            <div class="m-card-user m-card-user--skin-dark">
                                <div class="m-card-user__pic">
                                    <img src="{{  config('app.defaultAdminProfilePic') }}"
                                        class="m--img-rounded m--marginless" alt="" style="text-align: center;height: 70px;
                                                        " />
                                </div>
                                <div class="m-card-user__details">
                                    <span class="m-card-user__name m--font-weight-500">
                                        @if(\Auth::guard('admin')->user())
                                        {{ \Auth::guard('admin')->user()->full_name }}
                                    </span>
                                    <a href="javascript:;" class="m-card-user__email m--font-weight-300 m-link">
                                        {{  \Auth::guard('admin')->user()->email }}
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__content">
                                <ul class="m-nav m-nav--skin-light">
                                    <li class="m-nav__item">
                                    <a href="{{ route('firstpage') }}" target="_blank" class="m-nav__link">
                                        <i class="m-nav__link-icon fa fa-tv"></i>
                                        <span class="m-nav__link-text">Visit Site</span>
                                    </a>
                                    </li>
                                    <li class="m-nav__item">
                                        
                                        <a href="{{ route('admin.logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                                            class="m-nav__link">
                                            <i class="m-nav__link-icon flaticon-logout"></i>
                                            <span class="m-nav__link-text">Logout</span>
                                        </a>
                                        <form id="frm-logout" action="{{ route('admin.logout') }}" method="post"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>