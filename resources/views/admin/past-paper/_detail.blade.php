@extends('admin.layouts.default')
@section('content')
@section('title', 'Past Paper Detail')
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
                                        Past Paper Detail
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <a href="{{route('past-paper.index')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                    <span><i class="la la-arrow-left"></i><span>{{__('formname.back')}}</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.past-paper.title').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$pastPaper->name}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.year').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$pastPaper->year}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.exam_board').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$pastPaper->school_year}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.school').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$pastPaper->school->school_name}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.grade').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$pastPaper->grade->title}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-form__group row">
                                    {!! Form::label(__('formname.subject').' :', null,['class'=>'font-weight-bold col-form-label col-lg-4 col-sm-12']) !!}
                                    <div class="col-lg-6 col-md-9 col-sm-12 col-form-label">
                                        {{@$pastPaper->subject->title}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                @if(@$pastPaper->file != null)
                                    <div class="pdfApp border" data-index="{{@$pastPaper->id}}" data-src="{{@$pastPaper->file_path}}">
                                        <div id="viewport-container{{@$pastPaper->id}}" class="viewport-container" data-index="{{@$pastPaper->id}}">
                                            <div role="main" class="viewport" id="viewport{{@$pastPaper->id}}" data-index="{{@$pastPaper->id}}"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card p-4 mt-4 mb-4">
                            @php
                                $questionAsnwers = (@$pastPaper->pastPaperQuestion != null) ? $pastPaper->pastPaperQuestion->sortBy('question_no') : []; 
                            @endphp
                            @forelse($questionAsnwers??[] as $qkey => $question)
                                <div class="form-group m-form__group row col-md-12">
                                    <div class="optn_box mrgn_bt_15 w-100">
                                        <div class="optn_head">
                                            <div class="question_spark">
                                                <span class="text_14_wt">
                                                    Question {{@$question->question_no}}
                                                </span>
                                            </div>
                                            <div class="row text_14_wt">
                                                <div class="col-md-12">  »  {{@$question->subject->title}}  »  {{@$question->topic_names}} </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            @if($question->question_image != null)
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
                                            @if($question->answer_image != null)
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
                                            @if(@$questionData->question_type == 1)
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
                                                {{-- <strong>Answer : </strong>
                                                {!! @$question->getSingleAnswer->answer !!} --}}
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
                                            <a role="button" href="{{route('edit.past-paper.question',['uuid'=>@$question->uuid,'mockId'=>@$mockTest->uuid])}}" class="btn m-btn--square  btn-outline-primary mr-3" title="{{__('formname.edit')}}">{{__('formname.edit')}}</a>
                                            <button type="button" data-module_name="question" data-module="Question" data-id="{{@$question->uuid}}" data-mock_test_id="{{@$question->uuid}}" data-msg="You want to delete this question" data-url="{{route('delete.past-paper.question',['uuid'=>$question->uuid])}}" class="btn m-btn--square btn-outline-danger deleteQuestion" title="{{__('formname.delete')}}">{{__('formname.delete')}}</button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                            <div class="row pl-4 pr-4 mt-4 mb-4">
                                <a href="{{route('add.past-paper.question',['uuid'=>@$pastPaper->uuid])}}" class="btn btn-primary">
                                    <span class="fa fa-plus"></span>
                                    Add Question
                                </a>
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
<script src="{{asset('js/pdf.min.js')}}"></script>
<script src="{{asset('js/pdf.worker.js')}}"></script>
<script src="{{asset('js/pdf-creator.js')}}"></script>
<script>
initializePdf();
$('.deleteQuestion').on('click',function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
    });
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    var msg = $(this).attr('data-msg');
    var mock_test_id = $(this).attr('data-mock_test_id');
    swal({
        title:'Are you sure?',
        text:msg,
        icon:'warning',
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                method: "DELETE",
                data: { id: id, mock_test_id:mock_test_id},
                success: function (response) {
                    swal(response['msg'], {
                        icon: response['icon'],
                        closeOnClickOutside: false,
                    });
                    window.location.reload();
                }
            });
        }
    });
})
</script>
@stop
