@extends('admin.layouts.default')
@section('inc_css')
@section('content')

@section('title', @$methodType)


<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        @include('admin.includes.flashMessages')
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"
                    id="main_portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        {{ucwords($methodType)}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{Route('student.index')}}"
                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{trans('users.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if(isset($student) || !empty($student))
                            {{ Form::model($student, ['route' => ['admin.student.update', @$student->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right', 'files' => true, 'enctype' => "multipart/form-data"]) }}
                            @else
                            {{ Form::open(array('route' => ['student.store'],'method'=>'POST','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1', 'files' => true, 'enctype' => "multipart/form-data")) }}
                        @endif
                        {!! Form::hidden('uuid',(isset($student) ? @$student->uuid : '') ,['id'=>'uuid']) !!}
                        {!! Form::hidden('id',(isset($student) ? @$student->id : '')) !!}
                        <div class="m-portlet__body">

                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.student.parents').'*', null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('parent_id', @$parentUser, @$student->parent_id,
                                    ['class' =>
                                    'form-control selectpicker' ]) !!}
                                    @error('parent_id') <p class="errors">{{$errors->first('parent_id')}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.name') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('first_name',@$student->first_name,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('first_name') <p class="errors">{{$errors->first('first_name')}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.middle_name') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('middle_name',@$student->middle_name,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('middle_name') <p class="errors">{{$errors->first('middle_name')}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.last_name') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('last_name',@$student->last_name,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('last_name') <p class="errors">{{$errors->first('last_name')}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.dob') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('dob',isset($student->dob)?date('m/d/Y',strtotime($student->dob)):'',array('class'=>'form-control m-input','id'=>'m_datepicker_1' ,'readonly'=>'', 'placeholder'=>'Select date')) !!}
                                    @error('dob') <p class="errors">{{$errors->first('dob')}}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.school_year') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('school_year', schoolYearList(), @$student->school_year, ['id'=>'schoolYear','title'=>"School Year",'class' =>'form-control selectpicker' ]) !!}
                                    <span class="yearError"></span>
                                    @if ($errors->has('school_year'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('school_year') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.exam_board') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    @forelse($examBoardList as $examBoard)
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox m-checkbox--state-primary">
                                                <input id="{{@$examBoard->slug}}" type="checkbox" class="chkbx" name="exam_board_id[]" value="{{@$examBoard->id}}"
                                                @if(isset($student)&&in_array(@$examBoard->id,$student->examBoards->pluck('exam_board_id')->toArray())) checked @endif>
                                                {{@$examBoard->title}}
                                                <span></span>
                                            </label>
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
                            <div id='examStyle' class="form-group m-form__group row" style="display: none;">
                                {!! Form::label(trans('users.exam_style_id') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('exam_style_id', @$examStyle, @$student->exam_style_id, ['title'=>"Exam Style",'class'
                                    =>'selectpicker def_select' ]) !!}
                                    <span class="styleError"></span>
                                    @if ($errors->has('exam_style_id'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('exam_style_id') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.school_id') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('school_id', @$schoolList, @$student->school_id, ['title'=>"School",'class'
                                    =>'selectpicker form-control' ]) !!}
                                    <span class="schoolError"></span>
                                    @if ($errors->has('school_name'))
                                        <p class="errors" style="color:red;">
                                            {{ $errors->first('school_name') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="m-form__group form-group row">
                                {!! Form::label(trans('users.gender') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12 mt-1">
                                    @php
                                        $isMalechecked = isset($student) && $student->gender == 'Male'  ? true : false;
                                        $isFemalechecked = isset($student) && $student->gender == 'Female' ? true : false ;
                                    @endphp
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            {{Form::radio('gender', 'Male', $isMalechecked)}} Male
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            {{Form::radio('gender', 'Female', $isFemalechecked)}} Female
                                            <span></span>
                                        </label>
                                        @error('gender') <p class="errors">{{$errors->first('gender')}}</p> @enderror
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.username') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('email',@$student->email,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('email') <p class="errors">{{$errors->first('email')}}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                {!! Form::label(isset($student)?__('users.password'):__('users.password').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::password('password', array('id'=> 'password','class'=>'form-control m-input','minlength'=>'6','maxlength'=>'16'))!!}
                                    @error('password') <p class="errors">{{$errors->first('password')}}</p> @enderror
                                </div>
                            </div>


                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.address') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::textarea('address',@$student->address,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('address') <p class="errors">{{$errors->first('address')}}</p> @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.student.county') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('county',@$student->county,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('county') <p class="errors">{{$errors->first('county')}}</p> @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.city') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('city',@$student->city,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('city') <p class="errors">{{$errors->first('city')}}</p> @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.zip_code') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('zip_code',@$student->zip_code,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('zip_code') <p class="errors">{{$errors->first('zip_code')}}</p> @enderror
                                </div>
                            </div> --}}

                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.mobile') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('mobile',@$student->mobile,array('class'=>'form-control m-input','maxlength'=>'50')) !!}
                                    @error('mobile') <p class="errors">{{$errors->first('mobile')}}</p> @enderror
                                </div>
                            </div> --}}

                            <div class="form-group m-form__group row">
                                {!! Form::label(trans('users.status').'*', null,array('class'=>'col-form-label col-lg-3
                                col-sm-12')) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('active', @$statusList, @$student->active,
                                    ['class' =>'selectpicker form-control','disabled'=>(isset($student->parents->status)&&$student->parents->status==0)?true:false]) !!}
                                    <span class="statusError"></span>
                                </div>
                            </div>

                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(trans('users.submit'), ['class' => 'btn btn-success'] )!!}
                                            <a href="{{Route('student.index')}}"
                                                class="btn btn-secondary">{{trans('users.cancel')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script>
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
</script>
<script src="{{ asset('backend/dist/default/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{ asset('backend/js/student/create.js') }}" type="text/javascript"></script>
@stop
