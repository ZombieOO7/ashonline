@extends('newfrontend.layouts.default')
@section('title',"Child's Profile")
@section('content')

    <div class="container mrgn_bt_40">
        <div class="row">
            @include('newfrontend.user.leftbar')
            <div class="col-md-9">
                <div class="form_box">
                    <h3>New Child’s Account Creation</h3></div>
                <div class="col-md-12">
                    {{ Form::open(['route' => 'new-child.register.post','method'=>'post','class'=>'def_form','id'=>'child_register','autocomplete' => "off"]) }}
                    <input type="hidden" class="form-control" placeholder="" name='parent_id'
                           value="{{@$parent_id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="col-form-label">
                                    First Name
                                    <i class="fas fa-info-circle"></i>
                                </label>
                                <input type="text" class="form-control"
                                       placeholder="First Name"
                                       value="{{old('first_name')}}" name='first_name'
                                       maxlength="{{config('constant.rules.text_length')}}">
                                @if ($errors->has('first_name'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('first_name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="middle_name" class="col-form-label">
                                    Middle Name
                                    <i class="fas fa-info-circle"></i>
                                </label>
                                <input type="text" class="form-control"
                                       placeholder="Middle Name "
                                       value="{{old('middle_name')}}" name='middle_name'
                                       maxlength="{{config('constant.rules.text_length')}}">
                                @if ($errors->has('middle_name'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('middle_name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="col-form-label">
                                    Last Name
                                    <i class="fas fa-info-circle"></i>
                                </label>
                                <input type="text" class="form-control"
                                       placeholder="Last Name"
                                       value="{{old('last_name')}}" name='last_name'
                                       maxlength="{{config('constant.rules.text_length')}}">
                                @if ($errors->has('last_name'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('last_name') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="col-form-label">
                                    Date of Birth
                                    <i class="fas fa-info-circle"></i>
                                </label>
                                <input type="text" class="form-control" id="dob"
                                       placeholder="Date of Birth"
                                       value="{{old('dob')}}" name='dob' readonly>
                                @if ($errors->has('dob'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('dob') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_year" class="col-form-label">
                                    School Year
                                    <i class="fas fa-info-circle"></i>
                                </label>
                                {!! Form::select('school_year', schoolYearList(), null, ['title'=>"School
                                Year",'class' =>'selectpicker def_select', 'id'=>'schoolYear' ]) !!}
                                <span class="yearError"></span>
                                @if ($errors->has('school_year'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('school_year') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_name" class="col-form-label">
                                    Target School (s)
                                    <i class="fas fa-info-circle"></i>
                                </label>
                                <input type="text" class="form-control"
                                       placeholder="Target School (s) "
                                       value="{{old('school_name')}}" name='school_name'
                                       maxlength="{{config('constant.rules.text_length')}}">
                                @if ($errors->has('school_name'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('school_name') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="exam_board" class="col-form-label">--}}
{{--                                    Select Exam Board--}}
{{--                                    <i class="fas fa-info-circle"></i>--}}
{{--                                </label>--}}
{{--                                {!! Form::select('exam_board_id', @$examType, null, ['title'=>"Exam Type",'class'--}}
{{--                                =>'selectpicker def_select','id'=>'examBoardId' ]) !!}--}}
{{--                                <span class="boardError"></span>--}}
{{--                                @if ($errors->has('exam_board_id'))--}}
{{--                                    <p class="errors" style="color:red;">--}}
{{--                                        {{ $errors->first('exam_board_id') }}--}}
{{--                                    </p>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name" class="col-form-label">Preferred Exam Board
                                    <i class="fas fa-info-circle"></i>
                                    </label>
                                @forelse($examBoardList as $examBoard)
                                    <div class="checkbox agreeckbx">
                                        <input id="{{@$examBoard->slug}}" type="checkbox" class="dt-checkboxes" name="exam_board_id[]" value="{{@$examBoard->id}}">
                                        <label for="{{@$examBoard->slug}}">{{@$examBoard->title}}</label>
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






                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name" class="col-form-label">Preferred Exam Board
                                    {{__("formname.required_sign")}}</label>
                                    <div class="checkbox agreeckbx">
                                        <input id="gl" type="checkbox" class="dt-checkboxes" name="exam_board_id" value="2">
                                        <label for="gl">GL(Grammar)</label>
                                    </div>
                                    <div class="checkbox agreeckbx">
                                        <input id="cem" type="checkbox" class="dt-checkboxes" name="exam_board_id" value="1">
                                        <label for="cem">CEM</label>
                                    </div>
                                    <div class="checkbox agreeckbx">
                                        <input id="super_selective" type="checkbox" class="dt-checkboxes" name="exam_board_id" value="3">
                                        <label for="super_selective">Super selective</label>
                                    </div>
                                    <div class="checkbox agreeckbx">
                                        <input id="independent" type="checkbox" class="dt-checkboxes" name="exam_board_id" value="4">
                                        <label for="independent">Independent</label>
                                    </div>
                                    <span class="boardError"></span>
                                    @if ($errors->has('exam_board_id'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('exam_board_id') }}
                                    </p>
                                    @endif
                            </div>
                        </div> --}}
                        {{-- <div id="examStyle" class="col-md-6" style="display: none;">
                            <div class="form-group">
                                {!! Form::select('exam_style_id', @$examStyle, null, ['title'=>"Exam Style",'class'
                                =>'selectpicker def_select' ]) !!}
                                <span class="boardError"></span>
                                @if ($errors->has('exam_style_id'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('exam_style_id') }}
                                    </p>
                                @endif
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username" class="col-form-label">
                                    Username  <i class="fas fa-info-circle"></i>
                                </label>
                                <input type="text" class="form-control" placeholder="UserName" value="{{old('username')}}"
                                       name='username' maxlength="{{config('constant.rules.text_length')}}">
                                @if ($errors->has('username'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('username') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="col-form-label">
                                    Password
                                </label>
                                <input type="password" class="form-control" placeholder="Password"
                                       value="{{old('password')}}" name='password' id='password'
                                       maxlength="{{config('constant.rules.password_max_length')}}"
                                       minlength="{{config('constant.rules.password_min_length')}}">
                                @if ($errors->has('password'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="col-form-label">
                                    Confirm Password
                                </label>

                                <input type="password" class="form-control" placeholder="Conﬁrm Password"
                                       value="{{old('password_confirmation')}}" name='password_confirmation'
                                       maxlength="{{config('constant.rules.password_max_length')}}"
                                       minlength="{{config('constant.rules.password_min_length')}}">
                                @if ($errors->has('password_confirmation'))
                                    <p class="errors" style="color:red;">
                                        {{ $errors->first('password_confirmation') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                    <span class="inf_txt">{{__("formname.required_sign")}}Note : Please share the username and password with your
                                        child</span>
                            </div>
                        </div>
                        <div class="col-md-12 text-center sgnup_action">
                            <div class="form-group">
                                <button type="submit" class="btn btn_join">Create Account</button>
                            </div>
                        </div>


                    </div>
                    {!! Form::close() !!}
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
