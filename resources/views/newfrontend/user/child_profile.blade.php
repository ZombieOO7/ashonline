@extends('newfrontend.layouts.default')
@section('title',"Child's Profile")
@section('content')
@php
    $date = date('d-m-Y');
    $routeArray = [
    [
		'title' => __('frontend.my_profile'),
		'route' => route('parent-profile'),
	],
    [
		'title' => "Child's Profile",
		'route' => route('child-profile'),
	],
];
@endphp
@include('newfrontend.includes.breadcrumbs',$routeArray)
    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.user.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>Child’s Information
                        @if(Auth::user()->child_count < 2)
                        <span style="margin-left: 430px">
                            <a href="{{route('new-child-add',['parentIds' => Auth::user()->uuid]) }}" >Add Child</a>
                        </span>
                        @endif
                    </h3>
                    <br>
                    <ul class="nav nav-tabs">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab"
                                 role="tablist">
                                {{--                                @foreach($students as $key => $student)--}}
                                @forelse(@$students as $key => $student)
                                    <a class="nav-item nav-link @if($key == 0)active @endif"
                                       id="nav-home-tab{{$key}}"
                                       data-toggle="tab" href="#nav-home{{$key}}" role="tab"
                                       aria-controls="nav-home"
                                       aria-selected="true">Child {{$key+1}}</a>
                                @empty
                                @endforelse
                                {{--                                @endforeach--}}
                            </div>
                        </nav>
                    </ul>
                    @if(count($students)>0)
                        <div class="tab-content" id="nav-tabContent">
                                @forelse(@$students as $key => $student)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home{{$key}}"
                                        role="tabpanel" aria-labelledby="nav-home-tab{{$key}}">
                                        <div class="pdng_box">
                                            {{ Form::open(['route' => ['child-profile-update'], 'method' => 'POST','id'=>'child_profile_update'.$key,'class'=>'def_form max80','autocomplete' => "off",'enctype'=> 'multipart/form-data']) }}
                                            <input type="hidden" name="id" value="{{ @$student->id }}"/>

                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="pro-img ch-pic">
                                                            <img class="profile-pic propic{{$key}}"
                                                                src="{{@$student->image_thumb}}">
                                                            <input class="file-upload-nw upic{{$key}}" name="image" type="file"
                                                                accept="image/*"/>
                                                            <a href="javascript:void(0);" class="change-pic cpic{{$key}}">Update Proﬁle
                                                                Picture</a>
                                                        </div>
                                                        @if ($errors->has('image'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('image') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="full_name" class="col-form-label">First Name
                                                            <i class="fas fa-info-circle"></i></label>
                                                        <input type="text" name="first_name" class="form-control"
                                                            placeholder="First Name"
                                                            value="{{ @$student->first_name }}">
                                                        @if ($errors->has('first_name'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('first_name') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="middle_name" class="col-form-label">Middle Name
                                                            <i class="fas fa-info-circle"></i></label>
                                                        <input type="text" name="middle_name" class="form-control"
                                                            placeholder="Middle Name"
                                                            value="{{ @$student->middle_name }}">
                                                        @if ($errors->has('middle_name'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('middle_name') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="full_name" class="col-form-label">Last Name
                                                            <i class="fas fa-info-circle"></i></label>
                                                        <input type="text" name="last_name" class="form-control"
                                                            placeholder="Last Name"
                                                            value="{{ @$student->last_name }}">
                                                        @if ($errors->has('last_name'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('last_name') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="full_name" class="col-form-label">Date of Birth
                                                        </label>
                                                        <input type="text" class="form-control dob" readonly id="dob"
                                                            placeholder="Date of Birth"
                                                            name='dob' value="{{ @$student->DobText}}">
                                                        @if ($errors->has('dob'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('dob') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username" class="col-form-label">User Name</label>
                                                        <input type="text" name="email" class="form-control"
                                                            placeholder="Username"
                                                            value="{{ @$student->email }}" readonly>
                                                        @if ($errors->has('email'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('email') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="full_name" class="col-form-label">Password</label>
                                                        <input type="text" name="child_password" class="form-control"
                                                            placeholder="Password"
                                                            value="{{ @$student->child_password }}" readonly>
                                                        @if ($errors->has('child_password'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('child_password') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="child_id" class="col-form-label">Child Id</label>
                                                        <input type="text" name="child_id" class="form-control"
                                                            placeholder="Child Id"
                                                            value="{{ @$student->ChildIdText }}" readonly>
                                                        @if ($errors->has('child_id'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('child_id') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="full_name" class="col-form-label">School Year
                                                        <i class="fas fa-info-circle"></i></label>

                                                    <div class="form-group">
                                                        {!! Form::select('school_year', schoolYearList(), @$student->school_year,
                                                        ['title'=>"School
                                                        Year",'class' =>'selectpicker def_select' ]) !!}
                                                        <span class="yearError"></span>
                                                        @if ($errors->has('school_year'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('school_year') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="full_name" class="col-form-label">Target School (s)
                                                            <i class="fas fa-info-circle"></i></label>
                                                        <input type="text" name="school_name" class="form-control"
                                                            placeholder="School Name"
                                                            value="{{ @$student->school->school_name}}">
                                                        @if ($errors->has('school_name'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('school_name') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="full_name" class="col-form-label">Preferred Exam Board
                                                            <i class="fas fa-info-circle"></i></label>
                                                        @forelse($examBoardList as $examBoard)
                                                            <div class="checkbox agreeckbx">
                                                                <input id="{{@$examBoard->slug.$key}}" type="checkbox"
                                                                @if(in_array(@$examBoard->id,$student->examBoards->pluck('exam_board_id')->toArray())) checked @endif
                                                                class="dt-checkboxes" name="exam_board_id[]" value="{{@$examBoard->id}}">
                                                                <label for="{{@$examBoard->slug.$key}}">{{@$examBoard->title}}</label>
                                                            </div>
                                                        @empty
                                                        @endforelse
                                                        <span class="boardError"></span>
                                                        @if ($errors->has('exam_board_id'))
                                                            <p class="errors" style="color:red;">
                                                                {{ $errors->first('exam_board_id') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6 changepassword_clps">
                                                    <div class="collapse" id="ChangePassword">
                                                        <div class="card card-body">
                                                            <div class="form-group">
                                                                <input type="password" class="form-control" name="new_password"
                                                                    placeholder="New Password" maxlength="12">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="password" class="form-control"
                                                                    name="password_confirmation"
                                                                    placeholder="Conﬁrm New Password" maxlength="12">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                            <span class="inf_txt">*Note : Leave password field blank if you do not want to
                                                change.</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 sgnup_action btm_action mrgn_bt_0">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn_join" @if($key==0)
                                                        id="child_profile_updates" @endif>Save Updates
                                                        </button>
                                                        <br><br>
                                                        <a class="btn_clps" data-toggle="collapse" href="#ChangePassword"
                                                        role="button"
                                                        aria-expanded="false" aria-controls="ChangePassword">
                                                            Change Password
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                            {!! Form::close() !!}
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                        </div>
                    @else
                        <div class="pdng_box">
                            <strong>Child profile not found!</strong>
                        </div>
                    @endif

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('pageJs')
    <script type="text/javascript">
        var oldPasswordURL = "{{ route('check-old-password') }}";
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
    </script>
    <script src="{{asset('newfrontend/js/child_profile.js')}}"></script>
@stop


















