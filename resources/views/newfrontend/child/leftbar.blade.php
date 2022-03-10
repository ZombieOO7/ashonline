@php
    $routeName = Route::currentRouteName();
@endphp
<div class="col-md-12 prfl_ttl">
    <h3>Proﬁle <a class="btn btn-dttgl" data-toggle="collapse" href="#SidebarMenu" role="button" aria-expanded="false" aria-controls="SidebarMenu"><span class="ash-menu"></span></a></h3>    
</div>
<div class="col-md-3 sdbr_box">
    <div class="collapse" id="SidebarMenu">
        <div class="card card-body">
            <ul class="crd_list">
                <li class="@if($routeName=='student-profile') active @endif"><a href="{{route('student-profile')}}">My Proﬁle</a></li>
                <li class="@if($routeName=='student-mocks') active @endif"><a href="{{route('student-mocks')}}">My Mocks</a></li>
                <li class="@if($routeName=='practice') active @endif"><a href="{{route('practice')}}">My Practice</a></li>
            </ul>
        </div>  
    </div>  
</div>
