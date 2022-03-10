@extends('admin.layouts.default')
@section('content')

@section('title', 'Question Management')
<style>
    .modal { overflow: auto !important; }
</style>
@php
    $subjectId = session()->get('subject_id');
    $topicId = session()->get('topic_id');
@endphp
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        @include('admin.includes.flashMessages')
        <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">
                    <div class="m-form__content">
                        <h5>{{__('formname.question_mngt')}}</h5>
                    </div>
                    <hr>
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            {{ Form::open(array('route' => 'question.export','id'=>'m_form_1','method'=>'POST'))}}
                            <div class="row">
                                <div class="m-portlet__head-title">
                                    <div class="col-md-2 pr-0">
                                    {!! Form::select('subject_id', @$subjectList, @$subjectId, ['class' =>'form-control',
                                    'placeholder'=>__("formname.select_subject"),'id'=>'subject_id']) !!}
                                    </div>
                                    <div class="col-md-2 pr-0">
                                    {!! Form::select('topic_id', @$topicList, @$topicId, ['class' =>'form-control',
                                    'placeholder'=>__("formname.select_topic"),'id'=>'topic_id']) !!}
                                    </div>
                                    <div class="col-md-2 pr-0">
                                        <button type="button" id="getData" class="btn btn-success" style='margin:0px 0px 0px 12px'
                                        data-table_name="question_table">{{__('formname.submit')}}</button>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-info" style='margin:0px 0px 0px 12px' id='clr_filter'
                                        data-table_name="question_table">{{__('formname.clear_filter')}}</button>
                                    </div>
                                </div>
                            </div>
                            <span id='subjectError'></span>
                            {!! Form::close() !!}
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{route('past-paper-question.add')}}" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>{{__('formname.new_record')}}</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="question_table">
                    <thead>
                        <tr>
                            <th>{{__('formname.subject')}}</th>
                            <th>{{__('formname.question.topic')}}</th>
                            <th>{{__('formname.question.question_image')}}</th>
                            <th>{{__('formname.answer_image')}}</th>
                            <th>{{__('formname.action')}}</th>
                        </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<!-- Show Description Modal -->
<div class="modal fade def_mod dtails_mdl" id="DescModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content ">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="mdl_ttl"></h3>
                <p class="mrgn_tp_20 show_desc" style="word-wrap: break-word;">
                </p>
                <p class="mrgn_tp_20 show_question"></p>
                <button type="button" class="btn btn-success pull-right" data-dismiss="modal">{{__('formname.close')}}</button>
            </div>
        </div>
    </div>
</div>
@stop
@section('inc_script')
<script>
    var url = "{{route('past-paper-question.datatable')}}";
    var subjectId = '{{@$subjectId}}';
    var topicId = '{{@$topicId}}';
</script>
<script src="{{ asset('backend/js/past-paper-question/index.js') }}" type="text/javascript"></script>
@stop
