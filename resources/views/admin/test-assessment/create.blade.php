@extends('admin.layouts.default')
@section('inc_css')
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
@endsection
@section('content')
@section('title', @$title)
<style>
    .modal {
        overflow: auto !important;
    }
</style>
@php
    $flag = true;
    $routeName = Route::currentRouteName();
    if($routeName == 'test-assessment.copy'){
        $flag = false;
    }
@endphp
@php
    $hours = hours();
    $minutes = minutes();
    $seconds = seconds();
@endphp
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
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
                                        {{@$title}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('test-assessment.index')}}"
                                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>{{__('formname.back')}}</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if(isset($testAssessment) || !empty($testAssessment))
                            {{ Form::model($testAssessment, ['route' => [isset($route)?$route:'test-assessment.store', @$testAssessment->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                            {{ Form::open(['route' => isset($route)?$route:'test-assessment.store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                        <div class="m-portlet__body paperDetail">
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('title',@$testAssessment->title,['class'=>'form-control
                                    m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.test-assessment.title')]) !!}
                                    @if ($errors->has('title'))
                                        <p class='errors' style="color:red;">{{ $errors->first('title') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.image').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                    <div class="input-group err_msg">
                                        <button type="button" class="btn btn-primary" id="getDatatable" data-toggle="modal"
                                                data-target="#exampleModal">
                                                {{__('formname.upload_image')}}
                                        </button>
                                    </div>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <ul class="nav nav-tabs">
                                                        <nav>
                                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                <a class="nav-item nav-link active" id="nav-home-tab"
                                                                data-toggle="tab" href="#nav-home" role="tab"
                                                                aria-controls="nav-home" aria-selected="true">Upload
                                                                    Image</a>
                                                                <a class="nav-item nav-link" id="nav-profile-tab"
                                                                data-toggle="tab" href="#nav-profile" role="tab"
                                                                aria-controls="nav-profile" aria-selected="false">Media
                                                                    Library</a>
                                                            </div>
                                                        </nav>
                                                    </ul>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-home"
                                                            role="tabpanel" aria-labelledby="nav-home-tab">
                                                            <div class="form-group m-form__group row">
                                                                {!! Form::label(__('formname.mock-test.image') .'*', null,['class'=>'col-form-label col-lg-3 col-sm-12'])!!}
                                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                                    {!!Form::file('test_image',['id'=>'imgInput','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                                                    <input type="hidden" name="stored_img_name"
                                                                        id="stored_img_id"
                                                                        value="{{@$user->profile_pic}}">
                                                                    @if ($errors->has('test_image')) <p class='errors'
                                                                                                        style="color:red;">
                                                                        {{ $errors->first('test_image') }}</p>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                                            aria-labelledby="nav-profile-tab">

                                                            <table
                                                                class="table table-striped- table-bordered table-hover for_wdth"
                                                                id="image_module_table"
                                                                data-type=""
                                                                data-url="{{ route('mock-test.images_datatable') }}">
                                                                <thead>
                                                                <tr>
                                                                    <th>
                                                                    </th>
                                                                    <th>{{__('formname.image_name.path')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tfoot>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                    id="SaveImageMedia"
                                                    data-module_name="Image">{{__('formname.save')}}</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ImageShowColumns" class="mt-3" width="200" height="400">
                                        {!! Form::hidden('image_id',@$testAssessment->image_id ,['id'=>'image_id']) !!}
                                        <img id="blah" src="{{@$testAssessment->image->image_path}}" alt="" width="200" height="200"
                                            style="{{ isset($testAssessment->image_id) ? 'display:block;width:200px;' : 'display:none;width:200px;' }}"/>
                                    </div>
                                    <span class="imageError"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.test-assessment.school_year').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('school_year', @$yearList, @$testAssessment->school_year,
                                    ['class' =>'form-control' ]) !!}
                                    @if ($errors->has('school_year'))
                                        <p class='errors' style="color:red;">{{ $errors->first('grade_id') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.week') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <select name="week" id="weekId" class="form-control selectpicker" data-live-search="true">
                                        <option value="">{{__('formname.select_week')}}</option>
                                        <option value="53" @if(53==@$testAssessment->week) selected @endif>Free Trail Period</option>
                                        @forelse(@$weekList as $key => $week)
                                            @php
                                                $currentDate = date('Y-m-d');
                                                $weekStartDate = date('Y-m-d',strtotime(@$week['start_date']));
                                                $weekEndDate = date('Y-m-d',strtotime(@$week['end_date']));
                                                $flag = 'disabled';
                                                if($currentDate <= $weekEndDate){
                                                    $flag = '';
                                                }
                                            @endphp
                                            <option value="{{@$week['id']}}" @if(@$week['id']==@$testAssessment->week) selected @endif  data-end_date="{{@$week['end_date']}}" data-start_date="{{@$week['start_date']}}" {{$flag}}>
                                                {{@$week['name']}} ({{(@$week['start_date'].' - '.@$week['end_date'])}})
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('week') <p class="errors">{{$errors->first('week')}}</p> @enderror
                                    <span class="weekError"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row week {{(isset($testAssessment->week) && $testAssessment->week != null && $testAssessment->week != 53)?'':'d-none'}}">
                                {!! Form::label(__('formname.week_date'), null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                <div id='weekDate' class="col-form-label col-lg-6 col-md-9 col-sm-12">
                                    {{@$testAssessment->proper_start_date_text}} TO {{@$testAssessment->proper_end_date_text}}
                                </div>
                            </div>
                            {!! Form::hidden('start_date',@$testAssessment->proper_start_date_text,['class'=>'form-control m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.test-assessment.start_date'),'id'=>'start_date','readOnly'=>true]) !!}
                            {!! Form::hidden('end_date',@$testAssessment->proper_end_date_text,['class'=>'form-control m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.test-assessment.end_date'), 'id'=>'end_date','readOnly'=>true]) !!}
                            <div class="questionAndTime0 sectionDiv">
                                @forelse($testAssessment->testAssessmentSubjectDetail??[] as $skey => $section)
                                    <div class="paperSection" data-paper_key="0" data-subject_slug="{{$skey}}">
                                        @php
                                            $questionIds = @$section->question_ids;
                                        @endphp
                                        {!! Form::hidden('section['.@$skey.'][question_ids]', @$questionIds ,['class'=>'']) !!}
                                        {!! Form::hidden('section['.@$skey.'][id]', @$section->id ,['class'=>'']) !!}
                                        <div class="paper mt-4 mb-4" id='paper0Subject0' data-paper_key="0" data-subject_key="{{$skey}}">
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.subject_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][subject_id]', @$subjectList, @$section->subject_id, ['class' =>'form-control','data-key'=>$skey,'multiple'=>false]) !!}
                                                    @if ($errors->has('subject_id'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('subject_ids') }}</p>
                                                    @endif
                                                    <span class="subjectError"></span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.test-assessment.description').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        {!! Form::textarea('description',@$testAssessment->description,['class'=>'form-control
                                                        m-input','id'=>'editor1']) !!}
                                                    </div>
                                                    <span class="descriptionError">
                                                            @if ($errors->has('description')) <p class='errors' style="color:red;">
                                                                {{ $errors->first('description') }}</p> @endif
                                                        </span>
                                                    <span class="m-form__help"></span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.report_question'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::text('section['.@$skey.'][report_question]',@$section->report_question,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.report_question')]) !!}
                                                    @if ($errors->has('questions'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.paper_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][section_time][hours]',@$hours,@$section->section_hours,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][section_time][minutes]',@$minutes,@$section->section_minutes,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][section_time][seconds]',@$seconds,@$section->section_seconds,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    <span class="secondError"></span>
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.import_file')}} *</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$skey}}][import_file]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="paper0Subject0Import">
                                                        @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                                                        <label class="custom-file-label" for="paper0Subject0Import">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <div class="alert m-alert m-alert--default" role="alert">
                                                            Download <a target="__blank" href="{{ URL('/public/uploads/mcq-sample.xls') }}">MCQ Question Sample</a> file
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.passage')}} </label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$skey}}][passage]" multiple='false' accept="application/pdf" id="paper0Subject0Passage">
                                                        @if($errors->has('passage'))<p class="errors">{{$errors->first('passage')}}</p>@endif
                                                        <label class="custom-file-label" for="paper0Subject0Passage">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.images')}} </label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$skey}}][images][]" accept="image/png, image/jpeg" id="paper0Subject0Images" multiple='true'>
                                                        @if($errors->has('images'))<p class="errors">{{$errors->first('images')}}</p>@endif
                                                        <label class="custom-file-label" for="paper0Subject0Images">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::hidden('section['.@$skey.'][seq]',0,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.time')]) !!}
                                        </div>
                                    </div>
                                @empty
                                    @php
                                        $skey = 0;
                                    @endphp
                                    <div class="paperSection" data-paper_key="0" data-subject_slug="{{$skey}}">
                                        {!! Form::hidden('section['.@$skey.'][question_ids]',@$questionIds ,['class'=>'']) !!}
                                        <div class="paper mt-4 mb-4" id='paper0Subject0' data-paper_key="0" data-subject_key="{{$skey}}">
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.subject_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][subject_id]', @$subjectList, @$section->subject_id, ['class' =>'form-control','data-key'=>$skey,'multiple'=>false]) !!}
                                                    @if ($errors->has('subject_id'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('subject_ids') }}</p>
                                                    @endif
                                                    <span class="subjectError"></span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.test-assessment.description').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        {!! Form::textarea('description',@$testAssessment->description,['class'=>'form-control
                                                        m-input','id'=>'editor1']) !!}
                                                    </div>
                                                    <span class="descriptionError">
                                                            @if ($errors->has('description')) <p class='errors' style="color:red;">
                                                                {{ $errors->first('description') }}</p> @endif
                                                        </span>
                                                    <span class="m-form__help"></span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.report_question'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::text('section['.@$skey.'][report_question]',@$section->report_question,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.report_question')]) !!}
                                                    @if ($errors->has('questions'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.paper_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][section_time][hours]',@$hours,@$section->section_hours,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][section_time][minutes]',@$minutes,@$section->section_minutes,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$skey.'][section_time][seconds]',@$seconds,@$section->section_seconds,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    <span class="secondError"></span>
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.import_file')}} *</label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$skey}}][import_file]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="paper0Subject0Import">
                                                        <label class="custom-file-label" for="paper0Subject0Import">{{__('formname.choose_file')}}</label>
                                                        @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <div class="alert m-alert m-alert--default" role="alert">
                                                            Download <a target="__blank" href="{{ URL('/public/uploads/mcq-sample.xls') }}">MCQ Question Sample</a> file
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.passage')}} </label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$skey}}][passage]" multiple='false' accept="application/pdf" id="paper0Subject0Passage">
                                                        <label class="custom-file-label" for="paper0Subject0Passage">{{__('formname.choose_file')}}</label>
                                                        @if($errors->has('passage'))<p class="errors">{{$errors->first('passage')}}</p>@endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.images')}} </label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$skey}}][images][]" accept="image/png, image/jpeg" id="paper0Subject0Images" multiple='true'>
                                                        <label class="custom-file-label" for="paper0Subject0Images">{{__('formname.choose_file')}}</label>
                                                        @if($errors->has('images'))<p class="errors">{{$errors->first('images')}}</p>@endif
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::hidden('section['.@$skey.'][seq]',0,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.time')]) !!}
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <div class="questionAndTime0"></div>
                            {!! Form::hidden('stage_id',1,['id'=>'stageId']) !!}
                            {!! Form::hidden('no_of_section',@$paper->no_of_section,['id'=>'noOfSection','class'=>'do-not-ignore']) !!}
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', @$statusList, @$testAssessment->status, ['class' =>'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',@$testAssessment->id ,['id'=>'id']) !!}
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <br>
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        {!! Form::submit(__('formname.save_and_continue'), ['class' => 'btn btn-success'] ) !!}
                                        <a href="{{route('test-assessment.index')}}"
                                            class="btn btn-secondary">{{__('formname.cancel')}}</a>
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
{{-- Question title model --}}
<div class="modal fade def_mod dtails_mdl" id="DescModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="mdl_ttl"></h3>
                <p class="mrgn_tp_20 show_desc" style="word-wrap: break-word;">
                </p>
                <button type="button" class="btn btn-success pull-right"
                        data-dismiss="modal">{{__('formname.close')}}</button>
            </div>
        </div>
    </div>
</div>
{{-- common image upload --}}
{{-- @include('admin.includes.commonImageUpload') --}}
@stop
@section('inc_script')
    <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
    <script>
        var getPaperLayout = "{{route('mock-test.paper')}}";
        var no_of_section = '{{@$testAssessment->no_of_section??0}}';
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
        var formname = $.extend({}, {!!json_encode(__('formname'), JSON_FORCE_OBJECT) !!});
        var id = '{{@$testAssessment->id}}';
        var subjectUrl = '{{route("test-assessment.subject-detail")}}';
        var getQuestionList = '{{route("test-assessment.question-list")}}';
        var getDatatables = '{{route("test-assessment.images_datatable")}}';
        var getImageId = '{{route("test-assessment.GetSelectedImage")}}';
        var common_id = id;
        var stageId = '{{@$testAssessment->stage_id}}';
        $(function () {
            $("audio").on("play", function () {
                $("audio").not(this).each(function (index, audio) {
                    audio.pause();
                });
            });
        });
        if(id=='' || id == undefined || id ==null){
            $('#subjectId').selectpicker().val('');
            $('#topicId').selectpicker().val('');
            $('#subjectId').selectpicker({noneSelectedText: 'Select Subject'}).trigger('change');
            $('#topicId').selectpicker({noneSelectedText: 'Select Topic'}).trigger('change');
        }
        var importUrl = "{{route('question.importFile')}}";
    </script>
    <script src="{{ asset('backend/js/test-assessment/create.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>
@stop
