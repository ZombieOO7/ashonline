@extends('admin.layouts.default')
@section('content')
@section('title', @$title)
@php
$percentage = percentages();
@endphp
<link rel="stylesheet" href="{{asset('css/pdf.css')}}">
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
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
                        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" style="display:Block ruby" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#mock_info" role="tab" aria-selected="false">
                                    <i class="la la-cog"></i> {{@$title}}
                                </a>
                            </li>
                            @forelse($mockTest->papers as $paperKey => $paper)
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#paper_{{$paperKey}}_info" role="tab" aria-selected="false">
                                        <i class="la la-briefcase"></i> {{$paper->name}}
                                    </a>
                                </li>
                            @empty
                            @endforelse
                            <li class="nav-item m-tabs__item float-right">
                                <a class="btn btn-accent m-btn m-btn--air m-btn--custom" href="{{route('mock-paper.create',['uuid'=>$mockTest->uuid])}}">
                                    <i class="fas fa-plus"></i> Add Paper
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="mock_info" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.title').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{@$mockTest->title}}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.exam_board_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{ @$mockTest->examBoard->title}}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.start_date').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {!! @$mockTest->proper_start_date_text !!}
                                            </div>
                                        </div>
                                        @if($mockTest->school !=null)
                                            <div class="form-group m-form__group row superSelective">
                                                {!! Form::label(__('formname.mock-test.school_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                    {{ @$mockTest->school ?$mockTest->school->school_name :'' }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($mockTest->header !=null)
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.header').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                    <div class="input-group">
                                                        {!! @$mockTest->header !!}
                                                    </div>
                                                    <span class="headerError">
                                                        @if ($errors->has('header')) <p style="color:red;">
                                                            {{ $errors->first('header') }}</p> @endif
                                                    </span>
                                                    <span class="m-form__help"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.grade_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{ @$mockTest->grade->title }}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.price').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                ${!! @$mockTest->price !!}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.end_date').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {!! @$mockTest->proper_end_date_text !!}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.image') .' :', null,['class'=>'font-weight-bold col-form-label
                                            col-lg-4 col-sm-12'])
                                            !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                @if(@$mockTest)
                                                    <img id="blah" src="{{@$mockTest->image_path }}" alt="" height="200px;" width="200px;"
                                                    style="display:block;" />
                                                @else
                                                <img id="blah" src="" alt="" height="200px;" width="200px;"
                                                    style="display:none;" />
                                                @endif
                                            </div>
                                        </div>
                                        @if($mockTest->summury !=null)
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.summury').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                    <div class="input-group">
                                                        {!! @$mockTest->summury !!}
                                                    </div>
                                                    <span class="summuryError">
                                                        @if ($errors->has('summury')) <p style="color:red;">
                                                            {{ $errors->first('summury') }}</p> @endif
                                                    </span>
                                                    <span class="m-form__help"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.mock_description').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-form-label">
                                        <div class="input-group">
                                            {!! @$mockTest->description !!}
                                        </div>
                                        <span class="descriptionError">
                                            @if ($errors->has('description')) <p style="color:red;">
                                                {{ $errors->first('description') }}</p> @endif
                                        </span>
                                        <span class="m-form__help"></span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.mock_instruction').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-form-label">
                                        <div class="input-group">
                                            {!! @$mockTest->instruction !!}
                                        </div>
                                    </div>
                                </div>
                                @if(isset($mockTest->mockAudio))
                                    @if(isset($mockTest->mockAudio[0]->audio))
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{@config('constant.intervalList')[1]}}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('formname.mock-test.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                                {{-- @if(isset($mockTest->mockAudio[0]->audio_path) && $mockTest->mockAudio[0]->audio_path != null) --}}
                                                    <audio id="begningIntervalAudio" class="audioInput" controls>
                                                        <source src="{{@$mockTest->mockAudio[0]->audio_path}}" type="audio/mpeg">
                                                    </audio>
                                                {{-- @endif --}}
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($mockTest->mockAudio[1]->audio))
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                            {{@config('constant.intervalList')[2]}}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                            {{-- @if(isset($mockTest->mockAudio[1]->audio_path) && $mockTest->mockAudio[1]->audio_path != null) --}}
                                                <audio id="begningIntervalAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[1]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($mockTest->mockAudio[2]->audio))
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                            {{@config('constant.intervalList')[3]}}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                            {{-- @if(isset($mockTest->mockAudio[2]->audio_path) && $mockTest->mockAudio[2]->audio_path != null) --}}
                                                <audio id="begningIntervalAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[2]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($mockTest->mockAudio[3]->audio))
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.interval').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                            {{@config('constant.intervalList')[4]}}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.mock-test.audio_file').' :', null,['class'=>'font-weight-bold col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                            {{-- @if(isset($mockTest->mockAudio[3]->audio_path) && $mockTest->mockAudio[3]->audio_path != null) --}}
                                                <audio id="begningIntervalAudio" class="audioInput" controls>
                                                    <source src="{{@$mockTest->mockAudio[3]->audio_path}}" type="audio/mpeg">
                                                </audio>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>
                            @forelse($mockTest->papers as $paperKey => $paper)
                                @php
                                    $resultGrade = $paper->resultGrade;
                                @endphp
                                <div class="tab-pane" id="paper_{{$paperKey}}_info" role="tabpanel">
                                    <div class="form-group m-form__group row">
                                        <div class="col-md-12">
                                            <div class="float-right">
                                                <a href="{{route('mock-paper.edit',['uuid'=>$paper->uuid])}}" role="button" class="btn btn-secondary">Edit</a>
                                                <button class="deleteQuestion btn btn-danger" data-id="{{@$paper->uuid}}" data-msg="You want to delete this paper" data-url="{{route('mock-paper.delete',['uuid'=>@$paper->uuid])}}" data-mock_test_id="{{@$mockTest->uuid}}">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card p-4 mt-4 mb-4">
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                <h6>{{__('formname.paper_name')}} : </h6>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                {{@$paper->name}}
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                <h6>{{__('formname.paper_time')}} : </h6>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                {{@$paper->time}} {{__('formname.minutes')}}
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                <h6>{{__('formname.paper_description')}} : </h6>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-form-label">
                                                <div class="unset-list">
                                                    {!! @$paper->description !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                <h6>{{__('formname.close_instruction')}} : </h6>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-form-label">
                                                {!! @$paper->complete_instruction !!}
                                            </div>
                                        </div>
                                        @if(@$paper->answer_sheet != null || @$paper->answer_sheet_path != null)
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-3 col-md-6 col-sm-12 col-form-label">
                                                    <h6>{{__('formname.answer_sheet')}} : </h6>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-form-label">
                                                    <a href="{{route('mock-paper.answer-sheet',['uuid'=>@$paper->uuid])}}" class="">
                                                        <img src="{{asset('images/doc.png')}}" alt="" class="img-fluid" style="width: 150px; heigth:150px;">
                                                        <div class="mt-2 btn btn-default btn-rounded ">
                                                                <span class="fa fa-download"></span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                        <form id='resultGrade{{$paperKey}}' class="resultGrade" data-index="{{$paperKey}}">
                                            <table class="table m-table--head-bg-primary table-bordered table-hover table-checkable for_wdth">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">{{__('formname.good_or_excellent')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="d-flex">
                                                        <td class="col-md-2">{{__('formname.excellent')}}</td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('excellent_min', @$percentage, @$resultGrade->excellent_min ?? config('constant.excellent_min'),
                                                            ['class' => 'form-control resultType', 'id'=>'excellent_min' ]) !!}
                                                        </td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('excellent_max', @$percentage, @$resultGrade->excellent_max ?? config('constant.excellent_max'),
                                                            ['class' => 'form-control resultType', 'id'=>'excellent_max' ]) !!}
                                                        </td>
                                                    </tr>
                                                    <tr class="d-flex">
                                                        <td class="col-md-2">{{__('formname.very_good')}}</td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('very_good_min', @$percentage, @$resultGrade->very_good_min ?? config('constant.very_good_min'),
                                                            ['class' => 'form-control resultType', 'id'=>'very_good_min' ]) !!}
                                                        </td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('very_good_max', @$percentage, @$resultGrade->very_good_max ?? config('constant.very_good_max'),
                                                            ['class' =>'form-control resultType', 'id'=>'very_good_max' ]) !!}
                                                        </td>
                                                    </tr>
                                                    <tr class="d-flex">
                                                        <td class="col-md-2">{{__('formname.good')}}</td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('good_min', @$percentage, @$resultGrade->good_min ?? config('constant.good_min'),
                                                            ['class' => 'form-control resultType', 'id'=>'good_min' ]) !!}
                                                        </td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('good_max', @$percentage, @$resultGrade->good_max ?? config('constant.good_max'),
                                                            ['class' => 'form-control resultType', 'id'=>'good_max' ]) !!}
                                                        </td>
                                                    </tr>
                                                    <tr class="d-flex">
                                                        <td class="col-md-2">{{__('formname.fair')}}</td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('fair_min', @$percentage, @$resultGrade->fair_min ?? config('constant.fair_min'),
                                                            ['class' => 'form-control resultType', 'id'=>'fair_min' ]) !!}
                                                        </td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('fair_max', @$percentage, @$resultGrade->fair_max ?? config('constant.fair_max'),
                                                            ['class' => 'form-control resultType', 'id'=>'fair_max' ]) !!}
                                                        </td>
                                                    </tr>
                                                    <tr class="d-flex">
                                                        <td class="col-md-2">{{__('formname.need_improvement')}}</td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('improve_min', @$percentage, @$resultGrade->improve_min ?? config('constant.improve_min'),
                                                            ['class' => 'form-control resultType', 'id'=>'improve_min' ]) !!}
                                                        </td>
                                                        <td class="col-md-2">
                                                            {!! Form::select('improve_max', @$percentage, @$resultGrade->improve_max ?? config('constant.improve_max'),
                                                            ['class' => 'form-control resultType', 'id'=>'improve_max' ]) !!}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                            <input type="hidden" name="id" value="{{@$resultGrade->uuid}}" id="id">
                                            <input type="hidden" name="mock_test_paper_id" value="{{@$paper->id}}" id="paper_id">
                                        </form>
                                    </div>
                                    @forelse(@$paper->mockTestSubjectDetail as $sqkey => $subjectQuestion)
                                        <div class="card p-4 mt-4 mb-4">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    <h6> {{__('formname.section_name')}} :</h6>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    {{@$subjectQuestion->name}}
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    <h6> {{__('formname.subject')}} :</h6>
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    {{@$subjectQuestion->subject->title}}
                                                </div>
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    <h6>{{__('formname.time')}} :</h6>
                                                </div>
                                                <div class="col-lg-2 col-form-label">
                                                    {{ @$subjectQuestion->time }} {{__('formname.minutes')}}
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    <h6>{{__('formname.section_instruction')}} :</h6>
                                                </div>
                                                <div class="col-lg-10 col-form-label">
                                                    {!! @$subjectQuestion->description !!}
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-2 col-sm-12 col-form-label">
                                                    <h6>{{__('formname.section_image')}} :</h6>
                                                </div>
                                                <div class="col-lg-9 col-form-label">
                                                    <img id="blah" src="{{@$subjectQuestion->image_path}}" alt="" max-width="200" height="200" style="{{ isset($subjectQuestion->image) && $subjectQuestion->image != null ? 'display:block;display: block;width: 200px;height: 200px;' : 'display:none;' }}"/>
                                                </div>
                                            </div>
                                            @php
                                                // $questionData = $subjectQuestion->question??[];
                                                $questionsList = $subjectQuestion->questionList3??[];
                                            @endphp
                                            @if(@$subjectQuestion->passage != null)
                                                <div class="pdfApp border" data-index="{{@$subjectQuestion->id}}" data-src="{{@$subjectQuestion->passage_path}}">
                                                    <div id="viewport-container{{@$subjectQuestion->id}}" class="viewport-container" data-index="{{@$subjectQuestion->id}}"><div role="main" class="viewport" id="viewport{{@$subjectQuestion->id}}" data-index="{{@$subjectQuestion->id}}"></div></div>
                                                </div>
                                            @endif
                                            @if($mockTest->stage_id == 1)
                                                {{ Form::open(array('route' => 'upload-passage','method'=>'POST','id'=>'m_form_1','class'=>'m-form m-form--label-align-left- m-form--state- card p-4 mb-4', 'files' => true, 'enctype'=>'multipart/form-data')) }}
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{@$subjectQuestion->id}}">
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-md-2 col-form-label ml-3">
                                                            <label for="" class="h6">Upload Passage</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="file" name="passage" class="custom-file-input" accept="application/pdf">
                                                            {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-success">Upload</button>
                                                            @if(@$subjectQuestion->passage != null)
                                                                <button type="button" class="btn btn-danger deleteQuestion" data-id="{{@$subjectQuestion->id}}" data-msg="You want to delete this passage" data-url="{{route('delete-passage',['uuid'=>@$mockTest->uuid])}}" data-mock_test_id="{{@$mockTest->uuid}}">Delete Passage</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                {{ Form::close()}}
                                            @elseif($subjectQuestion->subject->slug != 'maths')
                                                {{ Form::open(array('route' => 'upload-passage','method'=>'POST','id'=>'m_form_1','class'=>'m-form m-form--label-align-left- m-form--state- card p-4 mb-4', 'files' => true, 'enctype'=>'multipart/form-data')) }}
                                                    <input type="hidden" name="id" value="{{@$subjectQuestion->id}}">
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-md-2 col-form-label ml-3">
                                                            <label for="" class="h6">Upload Passage</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="file" name="passage" class="custom-file-input" accept="application/pdf">
                                                            {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-success">Upload</button>
                                                            @if(@$subjectQuestion->passage != null)
                                                                <button type="button" class="btn btn-danger deleteQuestion" data-id="{{@$subjectQuestion->id}}" data-msg="You want to delete this passage" data-url="{{route('delete-passage',['uuid'=>@$mockTest->uuid])}}" data-mock_test_id="{{@$mockTest->uuid}}">Delete Passage</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                {{ Form::close()}}
                                            @endif
                                            @forelse(@$questionsList as $qkey => $questionObject)
                                                @php
                                                    $questionData = $questionObject;
                                                    $question = $questionData;
                                                @endphp
                                                <div class="form-group m-form__group row ">
                                                    <div class="optn_box mrgn_bt_15 w-100">
                                                        <div class="optn_head text-white">
                                                            <div class="col-md-10 d-inline">
                                                                Question {{@$question->question_no}}  »  {{@$questionData->subject->title}}  »  {{@$questionData->topic->title}}  
                                                            </div>
                                                            <div class="col-md-2 d-inline">
                                                                Point: {{@$question->marks}} pt
                                                            </div>
                                                        </div>
                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                            <strong>{{@$question->instruction}}</strong>
                                                        </div>
                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                            <strong>{!!@$question->question !!}</strong>
                                                        </div>
                                                        <div class="row">
                                                            @if(@$question->image != null)
                                                                @if($question->resize_full_image != null)
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.image_full')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                                                {!! @$question->resize_full_image !!}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.image_full')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->image_path}}">
                                                                                <img class="img-fluid" src="{{@$question->image_path}}">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if(@$question->question_image != null)
                                                                @if($question->resize_question_image != null)
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.question_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                                                                                {!! @$question->resize_question_image !!}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.question_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->question_image_path}}">
                                                                                <img class="img-fluid" src="{{@$question->question_image_path}}">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                            @if(@$question->answer_image != null)
                                                                @if($question->resize_answer_image != null)
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.answer_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                                                                                {!! @$question->resize_answer_image !!}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="col-md-12">
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <strong>{{__('formname.answer_image')}}</strong>
                                                                        </div>
                                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                            <span class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{@$question->answer_image_path}}">
                                                                                <img class="img-fluid" src="{{@$question->answer_image_path}}">
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                            @if(@$questionData->question_type == 1 && @$questionData->type == 4)
                                                                @php
                                                                    $alphabet = ord("A");
                                                                    $correctAnswer = null;
                                                                @endphp
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        @forelse(@$question->answers??[] as $akey => $answer)
                                                                            @if($akey < 3)
                                                                                @if($answer->is_correct == 1)
                                                                                    <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                                                                @else
                                                                                    <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                                                                @endif
                                                                                <br>
                                                                                @php
                                                                                    $alphabet++;
                                                                                @endphp
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        @forelse(@$question->answers??[] as $akey => $answer)
                                                                            @if($akey > 2)
                                                                                @if($answer->is_correct == 1)
                                                                                    <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                                                                @else
                                                                                    <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                                                                @endif
                                                                                <br>
                                                                                @php
                                                                                    $alphabet++;
                                                                                @endphp
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                            @elseif(@$questionData->question_type == 1)
                                                                @php
                                                                    $alphabet = ord("A");
                                                                    $correctAnswer = null;
                                                                @endphp
                                                                @forelse(@$question->answers??[] as $akey => $answer)
                                                                    @if($answer->is_correct == 1)
                                                                        <strong>{{chr($alphabet)}}. {!! @$answer->answer !!} </strong>
                                                                    @else
                                                                        <strong>{{chr($alphabet)}}.</strong> {!! @$answer->answer !!}
                                                                    @endif
                                                                    <br>
                                                                    @php
                                                                        $alphabet++;
                                                                    @endphp
                                                                @empty
                                                                @endforelse
                                                            @else
                                                                <strong>Answer : </strong>
                                                                {!! @$question->getSingleAnswer->answer !!}
                                                            @endif
                                                        </div>
                                                        @if(@$question->explanation != null)
                                                            <div class="optn_infrmtn_v1 pt-3 pl-4">
                                                                <span class="font-weight-bold"> Explanation </span>
                                                                <br>
                                                                {!! @$question->explanation !!}
                                                            </div>
                                                        @endif
                                                        <div class="optn_infrmtn_v1 p-4">
                                                            <a role="button" href="{{route('edit-list-question',['uuid'=>@$question->uuid,'mockId'=>@$mockTest->uuid])}}" class="btn m-btn--square  btn-outline-primary mr-3" title="{{__('formname.edit')}}">{{__('formname.edit')}}</a>
                                                            <button type="button" data-module_name="question" data-module="Question" data-id="{{@$question->uuid}}" data-mock_test_id="{{@$mockTest->uuid}}" data-msg="You want to delete this question" data-url="{{route('delete-list-question',['uuid'=>@$question->uuid])}}" class="btn m-btn--square btn-outline-danger deleteQuestion" title="{{__('formname.delete')}}">{{__('formname.delete')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="row pl-4 pr-4 mt-4 mb-4">
                                            <a href="{{route('add-question',['uuid'=>@$subjectQuestion->id,'mockId'=>@$mockTest->uuid])}}" class="btn btn-primary">
                                                <span class="fa fa-plus"></span>
                                                Add Question
                                            </a>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script src="{{asset('js/pdf.min.js')}}"></script>
<script src="{{asset('js/pdf.worker.js')}}"></script>
<script src="{{asset('js/pdf-creator.js')}}"></script>
<script>
var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
var formname = $.extend({}, {!!json_encode(__('formname'), JSON_FORCE_OBJECT) !!});
var id = '{{@$mockTest->id}}';
var subjectUrl = '{{route("mock-test.subject-detail")}}';
var getQuestionList = '{{route("mock-test.question-list")}}';
var storeGradeUrl = "{{route('result-grade.store')}}";
$(function(){
    $("audio").on("play", function() {
        $("audio").not(this).each(function(index, audio) {
            audio.pause();
        });
    });
});
</script>
<script src="{{ asset('backend/js/result-grade/index.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('backend/js/mock-test/create.js') }}" type="text/javascript"></script> --}}
@stop
