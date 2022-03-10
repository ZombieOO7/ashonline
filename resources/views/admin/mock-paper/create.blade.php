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
    $paperKey = 0;
    $hours = hours();
    $minutes = minutes();
    $seconds = seconds();
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
                        @if(isset($paper) || !empty($paper))
                            {{ Form::model($paper, ['route' => [isset($route)?$route:'mock-paper.store', @$paper->uuid], 'method' => 'PUT','id'=>'m_form','class'=>'m-form m-form--label-align-left- m-form--state-','files' => true,'autocomplete' => "off"]) }}
                        @else
                            {{ Form::open(['route' => isset($route)?$route:'mock-paper.store','method'=>'post','class'=>'m-form m-form--label-align-left- m-form--state-','id'=>'m_form','files' => true,'autocomplete' => "off"]) }}
                        @endif
                        <div class="m-portlet__body paperDetail" id="paperInfo">
                            {!! Form::hidden('mock_test_id',@$mockTestId ,['id'=>'mock_test_id']) !!}
                            {!! Form::hidden('id',@$paper->id ,['class'=>'']) !!}
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_name').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('name',@$paper->name,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.paper_name')]) !!}
                                    @if ($errors->has('name'))
                                        <p class='errors' style="color:red;">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_description').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::textarea('description',@$paper->description,['id'=>'paper'.$paperKey.'Instruction','class'=>'form-control do-not-ignore ckeditor noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.description')]) !!}
                                    <span class="descriptionError"></span>
                                    @if ($errors->has('name'))
                                        <p class='errors' style="color:red;">{{ $errors->first('instruction') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.close_instruction').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::textarea('complete_instruction',@$paper->complete_instruction,['id'=>'paper'.$paperKey.'CloseInstruction','class'=>'form-control do-not-ignore ckeditor noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.close_instruction')]) !!}
                                    <span class="completeInstructionError"></span>
                                    @if ($errors->has('name'))
                                        <p class='errors' style="color:red;">{{ $errors->first('instruction') }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($mockTest->stage_id == 2)
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.answer_sheet').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                        <div class="input-group">
                                            {!! Form::file('answer_sheet',['id'=>'answer_sheet','class'=>'custom-file-input','placeholder'=>__('formname.answer_sheet'),'accept'=>'']) !!}
                                            <label class="custom-file-label" for="answer_sheet">{{__('formname.choose_file')}}</label>
                                            <input type="hidden" name="answer_sheet_file" value="{{@$paper->answer_sheet}}" id="ans_sheet_file">
                                        </div>
                                        <span class="answeSheetError"></span>
                                        @if ($errors->has('answer_sheet'))
                                            <p class='errors' style="color:red;">{{ $errors->first('answer_sheet') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if(@$paper->answer_sheet != null && @$paper->answer_sheet_path != null)
                            <div class="form-group m-form__group row" id='answerSheet'>
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <a href="{{route('mock-paper.answer-sheet',['uuid'=>@$paper->uuid])}}" class="">
                                            <img src="{{asset('images/doc.png')}}" alt="" class="img-fluid">
                                            <div class="mt-2 btn btn-default btn-rounded ">
                                                    <span class="fa fa-download"></span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group m-form__group row timedSection">
                                <label for="" class="col-lg-3"></label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            <input type="radio" name="is_time_mandatory" value="1" @if(@$paper->is_time_mandatory == '1' || $paper == null) checked @endif> Timed
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="is_time_mandatory" value="0" @if(@$paper->is_time_mandatory == '0') checked @endif> UnTimed
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @php
                                $mockTestSubjectDetails = $paper->mockTestSubjectDetail??[];
                            @endphp
                            <div class="questionAndTime{{$paperKey}} sectionDiv">
                                @forelse($mockTestSubjectDetails as $key => $subjectDetail)
                                    @php
                                        $questionIds = @$subjectDetail->question_ids;
                                    @endphp
                                    <div class="paperSection card p-4 mt-4 mb-4" data-subject_slug='{{@$subjectDetail->subject->slug}}' data-paper_key="{{@$paperKey}}">
                                        @if($subjectDetail->seq == 0)
                                        <div class="m-portlet__head-title row">
                                            <div class="col-md-3">
                                                <h5 class="m-portlet__head-text">
                                                    Section
                                                </h5>
                                            </div>
                                            <div class="col-md-6">
                                            </div>
                                        </div>
                                        @endif
                                        {!! Form::hidden('section['.@$key.'][question_ids]',@$questionIds ,['class'=>'']) !!}
                                        {!! Form::hidden('section['.@$key.'][id]',@$subjectDetail->id ,['class'=>'']) !!}
                                        <div class="paper mt-4 mb-4" id='paper{{@$paperKey}}Subject0' data-subject_slug='{{@$subjectDetail->subject->slug}}' data-paper_key="{{@$paperKey}}" data-subject_key="{{$key}}">
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.subject_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][subject_id]', @$subjectList, @$subjectDetail->subject_id, ['class' =>'form-control','data-key'=>$key,'multiple'=>false]) !!}
                                                    @if ($errors->has('subject_id'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('subject_ids') }}</p>
                                                    @endif
                                                    <span class="subjectError"></span>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.section_name'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::text('section['.@$key.'][name]',@$subjectDetail->name,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.section_name')]) !!}
                                                    @if ($errors->has('name'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('name') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.section_instruction'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::textarea('section['.@$key.'][description]',@$subjectDetail->description,['id'=>'paper'.@$paperKey.'Subject'.@$subjectDetail->subject->slug.''.@$subjectDetail->seq.'Instruction','class'=>'form-control do-not-ignore ckeditor  noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.instruction')]) !!}
                                                    @if ($errors->has('instruction'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('instruction') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.instruction_image'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        {!! Form::file('section['.@$key.'][image]',['id'=>'paper'.@$paperKey.'Subject'.@$subjectDetail->seq.'InstrctImage','class'=>'custom-file-input noOfPapaer','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.instruction_image')]) !!}
                                                        <label class="custom-file-label" for="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}InstrctImage">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                    <div id="ImageShowColumns" class="mt-3" width="200" height="400">
                                                        {!! Form::hidden('section['.@$key.'][image_id]',@$subjectDetail->image ,['class'=>'do-not-ignore']) !!}
                                                        <img id="blah" src="{{@$subjectDetail->image_path}}" alt="" max-width="200" height="200" style="{{ isset($subjectDetail->image) ? 'display:block;display: block;width: 200px;height: 200px;' : 'display:none;' }}"/>
                                                    </div>
                                                    <span class="imageError"></span>
                                                    @if ($errors->has('questions'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.instruction_read_time'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::text('section['.@$key.'][instruction_read_time]',@$subjectDetail->instruction_read_time,['id'=>'paper'.@$paperKey.'Subject'.@$subjectDetail->seq.'InstrctTime','class'=>'form-control noOfPapaer','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.instruction_read_time')]) !!}
                                                    @if ($errors->has('questions'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                                                    @endif
                                                </div>
                                            </div> --}}
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.instruction_read_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][instruction_read_time][hours]',@$hours,@$subjectDetail->instruction_hours,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][instruction_read_time][minutes]',@$minutes,@$subjectDetail->instruction_minutes,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][instruction_read_time][seconds]',@$seconds,@$subjectDetail->instruction_seconds,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    <span class="secondError"></span>
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.mock-test.report_question').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    {!! Form::text('section['.@$key.'][report_question]',@$subjectDetail->report_question,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.report_question')]) !!}
                                                    @if ($errors->has('questions'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label(__('formname.section_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][section_time][hours]',@$hours,@$subjectDetail->section_hours,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][section_time][minutes]',@$minutes,@$subjectDetail->section_minutes,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                                                    @if ($errors->has('time'))
                                                        <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-2 col-md-9 col-sm-12">
                                                    {!! Form::select('section['.@$key.'][section_time][seconds]',@$seconds,@$subjectDetail->section_seconds,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
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
                                                        <input type="file" class="custom-file-input" name="section[{{@$key}}][import_file]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}Import">
                                                        @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                                                        <label class="custom-file-label" for="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}Import">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                    <br>
                                                    <div class="input-group">
                                                        <div class="alert m-alert m-alert--default" role="alert">
                                                            Download <a target="__blank" href="{{ URL('/public/uploads/mcq-sample.xls') }}">MCQ Question Sample</a> file
                                                        </div>
                                                    </div>
                                                    <div class="input-group">
                                                        <div class="alert m-alert m-alert--default" role="alert">
                                                            Download <a target="__blank" href="{{ URL('/public/uploads/standard-sample.xls') }}">Standard Question Sample</a> file
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.passage')}} </label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$key}}][passage]" multiple='false' id="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}Passage">
                                                        @if($errors->has('passage'))<p class="errors">{{$errors->first('passage')}}</p>@endif
                                                        <label class="custom-file-label" for="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}Passage">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.images')}} </label>
                                                <div class="col-lg-6 col-md-9 col-sm-12">
                                                    <div class="input-group">
                                                        <input type="file" class="custom-file-input" name="section[{{@$key}}][images][]"  id="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}Images" multiple='true' accept='image/*'>
                                                        @if($errors->has('images'))<p class="errors">{{$errors->first('images')}}</p>@endif
                                                        <label class="custom-file-label" for="paper{{@$paperKey}}Subject{{@$subjectDetail->seq}}Images">{{__('formname.choose_file')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::hidden('section['.@$key.'][seq]',@$subjectDetail->seq,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.time')]) !!}
                                            <div class="form-group m-form__group row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6 mt-3">
                                                    {{-- <button type="button" class="btn btn-primary addPaperSubject" data-subject_slug='{{@$subjectDetail->subject->slug}}' data-paper_key="{{@$paperKey}}" data-subject_key="{{$key}}">Add Section</button> --}}
                                                    <button type="button" class="btn btn-danger removedPaperSubject" data-subject_slug='{{@$subjectDetail->subject->slug}}' data-paper_key="{{@$paperKey}}" data-subject_key="{{$key}}">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-3">
                                    {!! Form::hidden('no_of_section',@$paper->no_of_section,['id'=>'noOfSection','class'=>'do-not-ignore']) !!}
                                </div>
                                <div class="col-lg-6">
                                    <button class="btn btn-primary addSections" type="button" data-paper_key="{{$paperKey}}" data-input_name="paper[{{$paperKey}}][no_of_sections]">
                                        <span class="fa fa-plus"> {{__('formname.add_sections')}}</span>
                                    </button>
                                    <span class="sectionError"></span>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <br>
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        {!! Form::submit(__('formname.save'), ['class' => 'btn btn-success'] ) !!}
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
@stop
@section('inc_script')
    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
    <script>
        var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
        var formname = $.extend({}, {!!json_encode(__('formname'), JSON_FORCE_OBJECT) !!});
        var id = '{{@$paper->id}}';
        var subjectUrl = '{{route("mock-test.subject-detail")}}';
        var getQuestionList = '{{route("mock-test.question-list")}}';
        var getDatatables = '{{route("mock-test.images_datatable")}}';
        var getImageId = '{{route("mock-test.GetSelectedImage")}}';
        var common_id = id;
        var stageId = '{{@$paper->stage_id}}';
        var startDate = '{{@$paper->proper_start_date_text}}';
        var endDate = '{{@$paper->proper_end_date_text}}';
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
        var importUrl = "{{route('question.importFile')}}";
        var getPaperLayout = "{{route('mock-test.paper')}}";
        var importRoute = '{{route("mock.import.section")}}';
        var no_of_section = '{{@$paper->no_of_section??0}}';
        $('.paperDetail').find('.subjectData').selectpicker();
        var stageId = "{{@$mockTest->stage_id}}";
    </script>
    <script src="{{ asset('backend/js/mock-paper/create.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>
@stop
