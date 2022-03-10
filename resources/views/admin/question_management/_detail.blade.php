@extends('admin.layouts.default')
@section('content')

@section('title', 'Question Management')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
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
                                        Question Detail
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('question.index')}}"
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
                        {{-- <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.question.title').' :', null,['class'=>'font-weight-bold col-form-label col-lg-2 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                {{@$question->question_title}}
                            </div>
                        </div> --}}
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.question.subject_id').' :', null,['class'=>'font-weight-bold col-form-label col-lg-2 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                {{@$question->subject->title}}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.question.question_type').' :', null,['class'=>'font-weight-bold col-form-label col-lg-2 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                {{@config('constant.questionSubType')[$question->question_type]}}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.question.type').' :', null,['class'=>'font-weight-bold col-form-label col-lg-2 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                {{@config('constant.question_type')[$question->type]}}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label(__('formname.question.topic').' :', null,['class'=>'font-weight-bold col-form-label col-lg-2 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                {{@$question->topic->title}}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            {!! Form::label('Question', null,['class'=>'font-weight-bold col-form-label col-lg-2 col-sm-12']) !!}
                            <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                {!! @$question->question !!}
                            </div>
                        </div>
                        {{-- @forelse($question->questionsList as $list) --}}
                        <div class="form-group m-form__group row ml-2">
                            <div class="col-md-12 form-group m-form__group row">
                                <div class="font-weight-bold col-md-4">
                                    {!! Form::label('%Correct') !!}
                                    <br>
                                    {!! @$question->progress_bar !!}
                                </div>
                                <div class="font-weight-bold col-md-3">
                                    {!! Form::label('Correct') !!}
                                    <br>
                                    {!! @$question->average_correct_answer !!}
                                </div>
                                <div class="font-weight-bold col-md-2">
                                    {!! Form::label('Incorrect') !!}
                                    <br>
                                    {!! @$question->average_incorrect_answer !!}
                                </div>
                                <div class="font-weight-bold col-md-2">
                                    {!! Form::label('Attemped') !!}
                                    <br>
                                    {!! @$question->average_responses !!}
                                </div>
                            </div>
                        </div>
                        @php $i=65; @endphp
                            @forelse ($question->answers as $answer)
                                <div class="form-group m-form__group row ml-2">
                                    <div class="col-md-4 font-weight-bold col-form-label {{(@$answer->is_correct==1)?'text-success':'text-danger'}}">
                                        {{chr($i)}}) {{@$answer->answer}}
                                    </div>
                                    <div class="col-md-6 form-group m-form__group row">
                                        <div class="font-weight-bold col-md-6">
                                            <div class="progress m-progress--sm">
                                                @php
                                                    $per = 0;
                                                    if($answer->is_correct == 1){
                                                        if($answer->selected_correct_answer > 0 && $question->average_responses > 0){
                                                            $per = (@$answer->selected_correct_answer * 100) / @$question->average_responses;
                                                            $per = number_format($per,2);
                                                        }
                                                    }else{
                                                        if($answer->selected_answer > 0 && $question->average_responses > 0){
                                                            $per = (@$answer->selected_answer * 100) / @$question->average_responses;
                                                            $per = number_format($per,2);
                                                        }
                                                    }
                                                @endphp
                                                <div class="progress-bar m--bg-success" role="progressbar" style="width: {{$per}}%;" aria-valuenow="{{$per}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="m-widget24__number">{{$per}}%</span>
                                        </div>
                                        <div class="font-weight-bold col-md-3">
                                            <div class="font-weight-bold col-form-label pt-0 pb-0">
                                                @if($answer->is_correct == 1)
                                                    {!! $answer->selected_correct_answer !!}
                                                @else
                                                    {!! @$answer->selected_answer !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @empty
                            @endforelse
                        {{-- @empty
                        @endforelse --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
