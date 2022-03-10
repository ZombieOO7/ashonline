@php
    $routeName = Route::currentRouteName();
@endphp
<div class="col-md-12 prfl_ttl">
    <h3>{{__('frontend.dashboard')}} <a class="btn btn-dttgl" data-toggle="collapse" href="#SidebarMenu" role="button" aria-expanded="false" aria-controls="SidebarMenu"><span class="ash-menu"></span></a></h3>
</div>
<div class="col-md-3 sdbr_box">
    <div class="collapse" id="SidebarMenu">
        <div class="card card-body">
            <ul class="crd_list">
                <li class="@if($routeName=='parent-profile') active @endif"><a href="{{ route('parent-profile') }}">{{__('frontend.my_profile')}}</a></li>
                <li class="@if($routeName=='child-profile') active @endif"><a href="{{ route('child-profile') }}">{{__('frontend.child_profile')}}</a></li>
                <li class="@if($routeName=='purchased-mock') active @endif"><a href="{{route('purchased-mock')}}">{{__('frontend.purchased_mock')}}</a></li>
                <li class="@if($routeName=='purchased-paper') active @endif"><a href="{{route('purchased-paper')}}">{{__('frontend.purchased_paper')}}</a></li>
                <li class="@if($routeName=='parent.practice-by-topic') active @endif"><a href="{{route('practice-home')}}">{{__('frontend.practice')}}</a></li>
                <li class="@if($routeName=='invoice') active @endif"><a href="{{route('invoice')}}">{{__('frontend.invoices')}}</a></li>
            </ul>
        </div>
    </div>
</div>
