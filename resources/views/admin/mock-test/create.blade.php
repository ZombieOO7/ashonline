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
    if($routeName == 'mock-test.copy'){
        $flag = false;
    }
@endphp
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        @if(@$errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{@$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
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
                                <a href="{{route('mock-test.index')}}"
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
                                @if(isset($mockTest) || !empty($mockTest))
                                    {{ Form::model($mockTest, ['route' => [isset($route)?$route:'mock-test.store', @$mockTest->uuid], 'method' => 'PUT','id'=>'m_form','class'=>'m-form m-form--label-align-left- m-form--state-','files' => true,'autocomplete' => "off"]) }}
                                @else
                                    {{ Form::open(['route' => isset($route)?$route:'mock-test.store','method'=>'post','class'=>'m-form m-form--label-align-left- m-form--state-','id'=>'m_form','files' => true,'autocomplete' => "off"]) }}
                                @endif
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',@$mockTest->title,['class'=>'form-control
                                            m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.title')]) !!}
                                            @if ($errors->has('title'))
                                                <p class='errors' style="color:red;">{{ $errors->first('title') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock_description').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('description',@$mockTest->description,['class'=>'form-control
                                                m-input do-not-ignore','id'=>'editor1']) !!}
                                            </div>
                                            <span class="descriptionError">
                                                @if ($errors->has('description')) <p class='errors' style="color:red;">
                                                    {{ $errors->first('description') }}</p>
                                                @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.image').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 img_msg_scn">
                                            <div class="input-group err_msg">
                                                <button type="button" class="btn btn-primary" id="getDatatable" data-toggle="modal"
                                                        data-target="#exampleModal">
                                                    Upload Image
                                                </button>
                                            </div>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <ul class="nav nav-tabs mb-0">
                                                                <nav>
                                                                    <div class="nav nav-tabs mb-0" id="nav-tab" role="tablist">
                                                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Upload Image</a>
                                                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Media Library</a>
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
                                                                        {!! Form::label(__('formname.mock-test.image') .'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                                                            {!!Form::file('test_image',['id'=>'imgInput','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                                                            <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                                                            @if ($errors->has('test_image')) <p class='errors' style="color:red;">
                                                                                {{ $errors->first('test_image') }}</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                                    {{-- <div class="m-scrollable m-scroller ps ps--active-y" data-scrollbar-shown="true" data-scrollable="true" data-height="400" style="height: 400px; overflow: hidden;"> --}}
                                                                        <table class="table table-striped- table-bordered table-hover for_wdth" id="image_module_table" data-type="" data-url="{{ route('mock-test.images_datatable') }}">
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
                                                                    {{-- </div> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" id="SaveImageMedia" data-module_name="Image">{{__('formname.save')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="ImageShowColumns" class="mt-3" max-width="200" ;
                                                height="400">
                                                {!! Form::hidden('image_id',@$mockTest->image_id ,['id'=>'image_id','class'=>'do-not-ignore']) !!}

                                                <img id="blah" src="{{@$mockTest->image_path}}" alt="" max-width="200" height="200" style="{{ isset($mockTest) ? 'display:block;display: block;width: 200px;height: 200px;' : 'display:none;' }}"/>
                                            </div>
                                            <span class="imageError"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.exam_board_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::select('exam_board_id', @$boardList, @$mockTest->exam_board_id,
                                            ['class' =>'form-control' ]) !!}
                                            @if ($errors->has('exam_board_id'))
                                                <p class='errors' style="color:red;">{{ $errors->first('exam_board_id') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row superSelective"
                                        style="{{ (@$mockTest->exam_board_id==3)?'':'display:none;' }}">
                                        {!! Form::label(__('formname.mock-test.school_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {{-- {!! Form::select('school_id', @$schoolList, @$mockTest->school_id, ['class' =>'form-control']) !!} --}}
                                            <select name="school_id" id="" class="form-control">
                                                <option value="">{{__('formname.select_school')}}</option>
                                                @forelse($schoolList as $school)
                                                    <option value="{{@$school->id}}"
                                                            {{(@$school->id == @$mockTest->school_id)?'selected':''}} data-is_multiple={{@$school->is_multiple}}>{{@$school->school_name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('school_id'))
                                                <p class='errors' style="color:red;">{{ $errors->first('school_id') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.grade_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::select('grade_id', @$gradeList, @$mockTest->grade_id,
                                            ['class' =>'form-control' ]) !!}
                                            @if ($errors->has('grade_id'))
                                                <p class='errors' style="color:red;">{{ $errors->first('grade_id') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row superSelective"
                                        style="{{ (@$mockTest->exam_board_id==3)?'':'display:none;' }}">
                                        {!! Form::label(__('formname.mock-test.stage_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 mt-1">
                                            <div class="m-radio-inline">
                                                <label class="m-radio">
                                                    <input type="radio" name="stage_id"
                                                        value="1" {{(@$mockTest->stage_id == 1 || @$mockTest->stage_id == null)?'checked':''}}>
                                                        {{__('formname.mcq_lbl')}}
                                                    <span></span>
                                                </label>
                                                <label class="m-radio">
                                                    <input type="radio" name="stage_id" value="2" {{(@$mockTest->stage_id == 2)?'checked':''}}>
                                                    {{__('formname.standard_lbl')}}
                                                    <span></span>
                                                </label>
                                            </div>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock_instruction').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('instruction',@$mockTest->instruction,['class'=>'form-control
                                                m-input do-not-ignore','id'=>'editor2']) !!}
                                            </div>
                                            <span class="instructionError">
                                                    @if ($errors->has('instruction')) <p class='errors' style="color:red;">
                                                        {{ $errors->first('instruction') }}</p> @endif
                                                </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.no_of_papers').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-3 col-md-9 col-sm-12">
                                            {!! Form::text('no_of_papers',@$mockTest->totalPaper,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.no_of_papers')]) !!}
                                            @if ($errors->has('no_of_papers'))
                                                <p class='errors' style="color:red;">{{ $errors->first('no_of_papers') }}</p>
                                            @endif
                                        </div>
                                        <div class="col-lg-3">
                                            <button class="btn btn-primary addPaper" type="button">
                                                <span class="fa fa-plus"> {{__('formname.add_paper')}}</span>
                                            </button>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.header'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('header',@$mockTest->header,['class'=>'form-control
                                                m-input','id'=>'editor2']) !!}
                                            </div>
                                            <span class="headerError">
                                                    @if ($errors->has('header')) <p class='errors' style="color:red;">
                                                        {{ $errors->first('header') }}</p> @endif
                                                </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.summury'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('summury',@$mockTest->summury,['class'=>'form-control
                                                m-input','id'=>'editor3']) !!}
                                            </div>
                                            <span class="summuryError">
                                                    @if ($errors->has('summury')) <p class='errors' style="color:red;">
                                                        {{ $errors->first('summury') }}</p> @endif
                                                </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div> --}}
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.start_date').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('start_date',($flag==true)?@$mockTest->proper_start_date_text:'',['class'=>'form-control
                                            m-input datepicker err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.start_date'),
                                            'id'=>'start_date','readOnly'=>true]) !!}
                                            @if ($errors->has('start_date'))
                                                <p class='errors' style="color:red;">{{ $errors->first('start_date') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.end_date').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('end_date',($flag==true)?@$mockTest->proper_end_date_text:'',['class'=>'form-control
                                            m-input datepicker err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.end_date'),
                                            'id'=>'end_date','readOnly'=>true]) !!}
                                            @if ($errors->has('end_date'))
                                                <p class='errors' style="color:red;">{{ $errors->first('end_date') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.price').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class=" input-group m-input-group">
                                                <div class="input-group-prepend">
                                                    <span
                                                        class="input-group-text">{{config('constant.default_currency_symbol')}}</span>
                                                </div>
                                                {!! Form::text('price',@$mockTest->price,['class'=>'form-control m-input err_msg','maxlength'=>config('constant.price_length'),'placeholder'=>__('formname.mock-test.price')]) !!}
                                                @if ($errors->has('price'))
                                                    <p class='errors' style="color:red;">{{ $errors->first('price') }}</p>
                                                @endif
                                            </div>
                                            <span class="priceError"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.display_report').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class=" input-group m-input-group">
                                                {!! Form::text('no_of_days',@$mockTest->no_of_days,['class'=>'form-control m-input err_msg','maxlength'=>config('constant.price_length'),'placeholder'=>__('formname.mock-test.days')]) !!}
                                                @if ($errors->has('no_of_days'))
                                                    <p class='errors' style="color:red;">{{ $errors->first('no_of_days') }}</p>
                                                @endif
                                            </div>
                                            <span class="priceError"></span>
                                        </div>
                                    </div>
                                    <div class="m-form__heading">
                                        <h3 class="m-form__heading-title">{{__('formname.audio_file')}}</h3>
                                    </div>
                                    <div class="form-group m-form__group row cloneAudioData">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 m-form__group-sub">
                                            <label for="exampleInputEmail1">{{config('constant.intervalList')[1]}}</label>
                                            <div></div>
                                            <div class="custom-file">
                                                {!! Form::hidden('data[0][interval]',1 ) !!}
                                                {!!Form::file('data[0][audio]',['id'=>'begningIntervalFile','class'=>'custom-file-input','accept' => 'audio/*'])!!}
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            @if(isset($mockTest->mockAudio[0]->audio_path) && $mockTest->mockAudio[0]->audio_path != null)
                                                <audio id="begningIntervalAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[0]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            @endif
                                            {!! Form::hidden('data[0][duration]',null,['id'=>'begningIntervalDuration']) !!}
                                            {!! Form::hidden('data[0][stored_audio_name]',@$mockTest->mockAudio[0]->audio) !!}
                                            <span id="begningIntervalFileError"></span>
                                        </div>
                                        @if(isset($mockTest->mockAudio[0]->audio_path) && $mockTest->mockAudio[0]->audio_path != null)
                                            <div class="col-lg-3 mt-4">
                                                <span class="btn btn-danger mt-2" id="begningIntervalAudioRemove"><i
                                                        class="fa fa-trash"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 m-form__group-sub">
                                            <label for="exampleInputEmail1">{{config('constant.intervalList')[2]}}</label>
                                            <div></div>
                                            <div class="custom-file">
                                                {!! Form::hidden('data[1][interval]',3 ) !!}
                                                {!!Form::file('data[1][audio]',['id'=>'endIntervalFile','class'=>'custom-file-input','accept' => 'audio/*'])!!}
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            @if(isset($mockTest->mockAudio[1]->audio_path) && $mockTest->mockAudio[1]->audio_path != null)
                                                <audio id="endIntervalAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[1]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            @endif
                                            {!! Form::hidden('data[1][duration]',null,['id'=>'endIntervalDuration']) !!}
                                            {!! Form::hidden('data[1][stored_audio_name]',@$mockTest->mockAudio[1]->audio) !!}
                                            <span id="endIntervalDurationError"></span>
                                        </div>
                                        @if(isset($mockTest->mockAudio[1]->audio_path) && $mockTest->mockAudio[1]->audio_path != null)
                                            <div class="col-lg-3 mt-4">
                                                <span class="btn btn-danger mt-2" id="endIntervalAudioRemove"><i
                                                        class="fa fa-trash"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 m-form__group-sub">
                                            <label for="exampleInputEmail1">{{config('constant.intervalList')[3]}}</label>
                                            <div></div>
                                            <div class="custom-file">
                                                {!! Form::hidden('data[2][interval]',4 ) !!}
                                                {!!Form::file('data[2][audio]',['id'=>'halfFile','class'=>'custom-file-input','accept' => 'audio/*'])!!}
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            @if(isset($mockTest->mockAudio[2]->audio_path) && $mockTest->mockAudio[2]->audio_path != null)
                                                <audio id="halfDurationAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[2]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            @endif
                                            {!! Form::hidden('data[2][duration]',null,['id'=>'halfDuration']) !!}
                                            {!! Form::hidden('data[2][stored_audio_name]',@$mockTest->mockAudio[2]->audio) !!}
                                            <span id="halfDurationError"></span>
                                        </div>
                                        @if(isset($mockTest->mockAudio[2]->audio_path) && $mockTest->mockAudio[2]->audio_path != null)
                                            <div class="col-lg-3 mt-4">
                                                <span class="btn btn-danger mt-2" id="halfDurationAudioRemove"><i
                                                        class="fa fa-trash"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 m-form__group-sub">
                                            <label for="exampleInputEmail1">{{config('constant.intervalList')[4]}}</label>
                                            <div></div>
                                            <div class="custom-file">
                                                {!! Form::hidden('data[3][interval]',4 ) !!}
                                                {!!Form::file('data[3][audio]',['id'=>'lastFile','class'=>'custom-file-input','accept' => 'audio/*'])!!}
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            {!! Form::hidden('data[3][duration]',null,['id'=>'lastDuration']) !!}
                                            {!! Form::hidden('data[3][stored_audio_name]',@$mockTest->mockAudio[3]->audio) !!}
                                            <span id="lastDurationError"></span>
                                            @if(isset($mockTest->mockAudio[3]->audio_path) && $mockTest->mockAudio[3]->audio_path != null)
                                                <audio id="lastDurationAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[3]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            @endif
                                        </div>
                                        @if(isset($mockTest->mockAudio[3]->audio_path) && $mockTest->mockAudio[3]->audio_path != null)
                                            <div class="col-lg-3 mt-4" id="lastDurationAudioRemove">
                                                <span class="btn btn-danger mt-2"><i class="fa fa-trash"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                    <audio id="audio1"></audio>
                                    <audio id="audio2"></audio>
                                    <audio id="audio3"></audio>
                                    <audio id="audio4"></audio>
                                    <div class="form-group m-form__group row">
                                        <label class='col-form-label col-lg-3 col-sm-12'>Show this mock test to</label>
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <select class="form-control" name="show_mock">
                                                <option value="1" {{ @$mockTest->show_mock == 1 ? 'selected' : ''}}>Tuition
                                                    Parents
                                                </option>
                                                <option value="2" {{ @$mockTest->show_mock == 2 ? 'selected' : ''}}>Everyone
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::select('status', @$statusList, @$mockTest->status, ['class' =>'form-control' ]) !!}
                                        </div>
                                    </div>
                                    {!! Form::hidden('id',@$mockTest->id ,['id'=>'id']) !!}
                                </div>
                                <div class="m-portlet__foot m-portlet__foot--fit">
                                    <div class="m-form__actions m-form__actions">
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-9 ml-lg-auto">
                                                {!! Form::submit(__('formname.save_and_continue'), ['class' => 'btn btn-success'] ) !!}
                                                <a href="{{route('mock-test.index')}}"
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
    </div>
</div>
@stop
@section('inc_script')
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
    <script>
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
        var formname = $.extend({}, {!!json_encode(__('formname'), JSON_FORCE_OBJECT) !!});
        var id = '{{@$mockTest->id}}';
        var subjectUrl = '{{route("mock-test.subject-detail")}}';
        var getQuestionList = '{{route("mock-test.question-list")}}';
        var getDatatables = '{{route("mock-test.images_datatable")}}';
        var getImageId = '{{route("mock-test.GetSelectedImage")}}';
        var common_id = id;
        var stageId = '{{@$mockTest->stage_id}}';
        var startDate = '{{@$mockTest->proper_start_date_text}}';
        var endDate = '{{@$mockTest->proper_end_date_text}}';
        $(function () {

            $("audio").on("play", function () {
                $("audio").not(this).each(function (index, audio) {
                    audio.pause();
                });
            });
        });
        if(id=='' || id == undefined || id ==null){
            $('.selectpicker').selectpicker().val('');
            $('.selectpicker').selectpicker({noneSelectedText: 'Select Subject'}).trigger('change');
        }

        // $('#start_date').datepicker('setDate', startDate);
        // $('#end_date').datepicker('setDate',endDate);
        var importUrl = "{{route('question.importFile')}}";
        var getPaperLayout = "{{route('mock-test.paper')}}";
        var importRoute = '{{route("mock.import.section")}}';
        $('.paperDetail').find('.subjectData').selectpicker();
    </script>
    <script src="{{ asset('backend/js/mock-test/create.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>
@stop
