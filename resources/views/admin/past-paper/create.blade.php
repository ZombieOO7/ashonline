@extends('admin.layouts.default')
@section('content')
@section('title', @$title)

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
                                <a href="{{route('past-paper.index')}}"
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
                        @if(isset($pastPaper) || !empty($pastPaper))
                        {{ Form::model($pastPaper, ['route' => ['past-paper.store', @$pastPaper->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                        {{ Form::open(['route' => 'past-paper.store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.past-paper.name').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('name',@$pastPaper->name,['class'=>'form-control m-input err_msg','maxlength' => config('constant.name_length'),'placeholder'=>__('formname.title')]) !!}
                                    @if ($errors->has('name')) 
                                        <p style="color:red;">{{ $errors->first('name') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.year').'*', null,['class'=>'col-form-label
                                col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::text('year',@$pastPaper->year,['id'=>'yeardId','class'=>'form-control m-input err_msg','maxlength' => config('constant.name_length'),'placeholder'=>__('formname.year'),'readonly'=>true]) !!}
                                    @if ($errors->has('year')) 
                                        <p style="color:red;">{{ $errors->first('year') }}</p> 
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.exam_board').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('exam_board_id',@$boardList,@$pastPaper->exam_board_id,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('exam_board_id')) 
                                        <p style="color:red;">{{ $errors->first('exam_board_id') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.school').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('school_id',@$schoolList,@$pastPaper->school_id,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('school_id')) 
                                        <p style="color:red;">{{ $errors->first('school_id') }}</p> 
                                    @endif
                                </div>
                            </div> --}}
                            {{-- <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.grade').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('grade_id',@$gradeList,@$pastPaper->grade_id,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('grade_id')) 
                                        <p style="color:red;">{{ $errors->first('grade_id') }}</p> 
                                    @endif
                                </div>
                            </div> --}}
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.school_year').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('school_year',@$yearList,@$pastPaper->school_year,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('school_year')) 
                                        <p style="color:red;">{{ $errors->first('school_year') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.month').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('month',@$monthList,@$pastPaper->month,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('month')) 
                                        <p style="color:red;">{{ $errors->first('month') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.subject').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('subject_id',@$subjectList,@$pastPaper->subject_id,['class'=>'form-control
                                    m-input err_msg']) !!}
                                    @if ($errors->has('subject_id')) 
                                        <p style="color:red;">{{ $errors->first('subject_id') }}</p> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.pdf').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group err_msg">
                                        {!! Form::file("pdf_file", ['class'=>'custom-file-input' ,'id'=>'fileId' ]) !!}
                                        {!! Form::label('fileId','Choose file',['class'=>'custom-file-label']) !!}
                                        <input type="hidden" name="stored_file" id="stored_file"
                                            value="{{@$pastPaper->file}}">
                                    </div>
                                    @if ($errors->has("file"))
                                        <p style="color:red;">
                                            {{ $errors->first("file") }}
                                        </p>
                                    @endif
                                    @if(isset($pastPaper))
                                        <img src="{{ asset('images/pdf.jpeg') }}" alt=""><a
                                            href="{{route('download-media',@$pastPaper->uuid)}}" class="download_pdf"><i
                                                class="la la-download"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.past-paper.instruction').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-sm-12">
                                    <div class="input-group">
                                        {!! Form::textarea('instruction',@$testAssessment->instruction,['class'=>'form-control
                                        m-input','id'=>'editor1']) !!}
                                    </div>
                                    <span class="descriptionError">
                                            @if ($errors->has('instruction')) <p class='errors' style="color:red;">
                                                {{ $errors->first('instruction') }}</p> @endif
                                        </span>
                                    <span class="m-form__help"></span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.question.import_file')}} *</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="file" class="custom-file-input" name="import_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="questionImport">
                                        <label class="custom-file-label" for="questionImport">{{__('formname.choose_file')}}</label>
                                        @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                                    </div>
                                    <br>
                                    <div class="input-group">
                                        <div class="alert m-alert m-alert--default" role="alert">
                                            Download <a target="__blank" href="{{ URL('/public/uploads/past-paper-question.xls') }}">Sample</a> file
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.images')}} </label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <div class="input-group">
                                        <input type="file" class="custom-file-input" name="images[]"  id="paperQuestionImages" multiple='true' accept='image/*'>
                                        <label class="custom-file-label" for="paperQuestionImages">{{__('formname.choose_file')}}</label>
                                        @if($errors->has('images'))<p class="errors">{{$errors->first('images')}}</p>@endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row mt-3 ml-2">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <a href="javascript:;" class="col-md-5 btn btn-primary addQuestionAnswer mr-3" data-index="{{(@$pastPaper->pastPaperQuestion != null) ? @$pastPaper->pastPaperQuestion->count():'0'}}" role="button"><span class="fa fa-plus"></span> {{__('formname.add_question')}}</a>
                                </div>
                            </div> --}}
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.paper_for').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('paper_show_to', @config('constant.member_type')??[], @$pastPaper->paper_show_to,['class' => 'form-control' ]) !!}
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                                col-sm-12']) !!}
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    {!! Form::select('status', @$statusList, @$pastPaper->status,
                                    ['class' => 'form-control' ]) !!}
                                </div>
                            </div>
                            {!! Form::hidden('id',@$pastPaper->id ,['id'=>'id']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                            !!}
                                            <a href="{{Route('past-paper.index')}}"
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
<script>
    var rule = $.extend({}, {!!json_encode(config('constant.rules'), JSON_FORCE_OBJECT) !!});
    $('#yeardId').datepicker({
        format: 'yyyy',
        viewMode: "years", 
        minViewMode: "years"
    });
    var addQuestionUrl = "{{route('add.question')}}";
    var uuid = "{{@$pastPaper->uuid??''}}"
    var pregunta = "{{@$pastPaper->no_of_question??0}}"
</script>
<script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
<script src="{{ asset('backend/js/past-paper/create.js') }}" type="text/javascript"></script>
<script>
    getQuestionLayout('get')
</script>
@stop