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
    if($routeName == 'practice-exam.copy'){
        $flag = false;
    }
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
                                <a href="{{route('practice-exam.index')}}"
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
                        @if(isset($practiceExam) || !empty($practiceExam))
                            {{ Form::model($practiceExam, ['route' => [isset($route)?$route:'practice-exam.store', @$practiceExam->uuid], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                        @else
                            {{ Form::open(['route' => isset($route)?$route:'practice-exam.store','method'=>'post','class'=>'m-form m-form--fit m-form--label-align-right','id'=>'m_form_1','files' => true,'autocomplete' => "off"]) }}
                        @endif
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.practice-exam.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text('title',@$practiceExam->title,['class'=>'form-control
                                m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.practice-exam.title')]) !!}
                                @if ($errors->has('title'))
                                    <p class='errors' style="color:red;">{{ $errors->first('title') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.description').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                <div class="input-group">
                                    {!! Form::textarea('description',@$practiceExam->description,['class'=>'form-control
                                    m-input','id'=>'editor1']) !!}
                                </div>
                                <span class="descriptionError">
                                        @if ($errors->has('description')) <p class='errors' style="color:red;">
                                            {{ $errors->first('description') }}</p> @endif
                                    </span>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        {{-- <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test-assessment.exam_board_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('exam_board_id', @$boardList, @$practiceExam->exam_board_id,
                                ['class' =>'form-control' ]) !!}
                                @if ($errors->has('exam_board_id'))
                                    <p class='errors' style="color:red;">{{ $errors->first('exam_board_id') }}</p>
                                @endif
                            </div>
                        </div> --}}
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test-assessment.school_year').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('school_year', @$yearList, @$practiceExam->school_year,
                                ['class' =>'form-control' ]) !!}
                                @if ($errors->has('grade_id'))
                                    <p class='errors' style="color:red;">{{ $errors->first('grade_id') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.test-assessment.subject_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('subject_id', @$subjectList, @$subjectIds,
                                ['class' =>'form-control selectpicker','multiple'=>(@$practiceExam->exam_board_id==3)?true:false]) !!}
                                @if ($errors->has('subject_id'))
                                    <p class='errors' style="color:red;">{{ $errors->first('subject_id') }}</p>
                                @endif
                                <span class="subjectError"></span>
                            </div>
                        </div>
                        {{-- {{dd(@$practiceExam->topic_ids)}} --}}
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.question.topic') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('topic_id[]',@$topics??[],@$practiceExam->topic_ids,['class'=>'form-control select2','id'=>'topicId','maxlength'=>'50','multiple'=>true,'data-live-search'=>true]) !!}
                                @error('title') <p class="errors">{{$errors->first('title')}}</p> @enderror
                                <span class="inError"></span>
                            </div>
                        </div>
                        <div id="topicData">
                            @forelse (@$practiceExam->practiceExamTopic??[] as $key => $topic)
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-12 col-sm-12 text-center">
                                        <h5>{!! Str::ucfirst(@$topic->topic->title) !!}</h5>
                                    </div>
                                </div>
                                {!! Form::hidden("topic[".@$topic->topic_id."][topic_id]",@$topic->topic_id,['id'=>'time'.$key,'class'=>'']) !!}
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.practice-exam.no_of_question').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                    <div class="col-lg-6">
                                        {!! Form::text("topic[".@$topic->topic_id."][no_of_questions]",@$topic->no_of_questions,['id'=>'time'.$key,'class'=>'form-control m-input err_msg dynamicTInput','maxlength'=>config('constant.time_length'),'placeholder'=>__('formname.practice-exam.no_of_question')]) !!}
                                        @if ($errors->has('no_of_questions'))
                                            <p style="color:red;">{{ $errors->first('no_of_questions') }}</p> 
                                        @endif
                                        <span class="timeError"></span>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.status').'*', null,['class'=>'col-form-label col-lg-3
                            col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::select('status', @$statusList, @$practiceExam->status, ['class' =>'form-control' ]) !!}
                            </div>
                        </div>
                        {!! Form::hidden('id',@$practiceExam->id ,['id'=>'id']) !!}
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <br>
                                <div class="row">
                                    <div class="col-lg-9 ml-lg-auto">
                                        {!! Form::submit(__('formname.submit'), ['class' => 'btn btn-success'] )
                                        !!}
                                        <a href="{{Route('practice-exam.index')}}"
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
        var id = '{{@$practiceExam->id}}';
        var common_id = id;
        var getTopicInputs = '{{route("practice-exam.get.inputs")}}';
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
        $('.select2').select2({
            multiple: true,
        });
        $('.select2').on('select2:select', function (e) {
            getSelect2();
        });
        $('.select2').on('select2:unselecting', function (e) {
            getSelect2();
        });
        function getSelect2(){
            var topicIds = $('.select2').val();
            $.ajax({
                url:getTopicInputs,
                method:'POST',
                data:{
                    ids:JSON.stringify(topicIds),
                },
                success:function(response){
                    if(response.status == 'success'){
                        $('#topicData').html(response.html);
                    }
                }
            })
        }
    </script>
    <script src="{{ asset('backend/js/practice-exam/create.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/js/Image/imageModel.js') }}" type="text/javascript"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
@stop
