@extends('newfrontend.layouts.default')
@section('title','My Profile')
@section('content')
@php
    $date = date('d-m-Y');
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('student-profile'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <!--inner content-->
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.child.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>My Proﬁle</h3>
                    <div class="pdng_box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="def_form def_form_v2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <img src="{{ @$user->image_thumb }}" alt="" class="avtr_img">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <p>{{ @$user->first_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <p>{{ @$user->middle_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <p>{{ @$user->last_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <p>{{@$user->dobText}}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <p>{{ @$user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>School Year</label>
                                                <p>{{ @$user->school_year }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Preferred Exam Board</label>
                                                <p>{{@$examBoardName}} </p>
                                            </div>
                                        </div>
                                        @if($user->exam_style_id != null)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Exam Style</label>
                                                <p>{{@config('constant.exam_style')[@$user->exam_style_id]}}</p>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>School Name</label>
                                                <p>{{ @$user->school->school_name }} </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!--close inner content-->

@stop
@section('pageJs')
<script type="text/javascript">
  var oldPasswordURL = "{{ route('check-old-password') }}";
</script>
<script src="{{asset('newfrontend/js/profile.js')}}"></script>
@stop
