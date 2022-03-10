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
                                        {!! @$title !!}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        {{ Form::model($block, ['route' => ['block_store', @$block->id], 'method' => 'PUT','id'=>'m_form_1','class'=>'m-form m-form--fit m-form--label-align-right','files' => true,'autocomplete' => "off"]) }}
                            @if($block->project_type == 0)
                                <!-- title -->
                                @if(config('constant.blocks.ePaper.about_us.sub_section') != @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- sub title -->
                                @if(config('constant.blocks.ePaper.home.all_subjects') != @$block->slug && config('constant.blocks.ePaper.home.exam_formats') != @$block->slug && config('constant.blocks.ePaper.home.exam_styles') != @$block->slug && config('constant.blocks.ePaper.tutions.main_section') != @$block->slug && config('constant.blocks.ePaper.tutions.sub_section') != @$block->slug && config('constant.blocks.ePaper.about_us.sub_section') != @$block->slug && config('constant.blocks.ePaper.about_us.main_section') != @$block->slug && config('constant.blocks.ePaper.about_us.we_provide') != @$block->slug)
                                    <div class="form-group m-form__group row">
                                        @if(config('constant.blocks.ePaper.about_us.mind_behind_scene') == @$block->slug)
                                            {!! Form::label(__('formname.block.fname_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        @else 
                                            {!! Form::label(__('formname.block.sub_title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        @endif
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('sub_title',isset($block)?$block->sub_title:'',['class'=>'form-control m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('sub_title')) <p style="color:red;">
                                                {{ $errors->first('sub_title') }}</p> @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- designation -->
                                @if(config('constant.blocks.ePaper.about_us.mind_behind_scene') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.desg_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('note',isset($block)?$block->note:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('note')) <p style="color:red;">
                                                {{ $errors->first('note') }}</p> @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- content -->
                                @if(config('constant.blocks.ePaper.home.all_subjects') != @$block->slug && config('constant.blocks.ePaper.home.exam_formats') != @$block->slug)
                                    <div class="form-group m-form__group row">
                                        @if(config('constant.blocks.ePaper.about_us.mind_behind_scene') == @$block->slug)
                                            {!! Form::label(__('formname.block.content_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        @else 
                                            {!! Form::label(__('formname.test_papers.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        @endif
                                        
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Mind behinde the scene rest 3 starts here-->
                                @if(config('constant.blocks.ePaper.about_us.mind_behind_scene') == @$block->slug)
                                    <!-- 2 -->
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.fname_2').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_1',isset($block)?$block->subject_title_1:'',['class'=>'form-control m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.desg_2').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_4',isset($block)?$block->subject_title_4:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.content_2').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_1_content',isset($block)?$block->subject_title_1_content:'',['class'=>'form-control m-input','id'=>'subject_title_1_content']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 3 -->
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.fname_3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_2',isset($block)?$block->subject_title_2:'',['class'=>'form-control m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.desg_3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('exam_format_title_1',isset($block)?$block->exam_format_title_1:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.content_3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_2_content',isset($block)?$block->subject_title_2_content:'',['class'=>'form-control m-input','id'=>'subject_title_2_content']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 4 -->
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.fname_4').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_3',isset($block)?$block->subject_title_3:'',['class'=>'form-control m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.desg_4').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('exam_format_title_2',isset($block)?$block->exam_format_title_2:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.content_4').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_3_content',isset($block)?$block->subject_title_3_content:'',['class'=>'form-control m-input','id'=>'subject_title_3_content']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- Mind behinde the scene rest 3 ends here-->


                                <!-- note -->
                                @if(config('constant.blocks.ePaper.home.banner_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.note').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('note',isset($block)?$block->note:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('note')) <p style="color:red;">
                                                {{ $errors->first('note') }}</p> @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- all subjects -->
                                @if(config('constant.blocks.ePaper.home.all_subjects') == @$block->slug)

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_1_title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_1',isset($block)?$block->subject_title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_1')) <p style="color:red;">
                                                {{ $errors->first('subject_title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_1_content').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('subject_title_1_content',isset($block)?$block->subject_title_1_content:'',['class'=>'form-control
                                                m-input ','id'=>'subject_title_1_content']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_1_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_1_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_2_title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_2',isset($block)?$block->subject_title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_2')) <p style="color:red;">
                                                {{ $errors->first('subject_title_2') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_2_content').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('subject_title_2_content',isset($block)?$block->subject_title_2_content:'',['class'=>'form-control
                                                m-input ','id'=>'subject_title_2_content']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_2_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_2_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_3_title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_3',isset($block)?$block->subject_title_3:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_3')) <p style="color:red;">
                                                {{ $errors->first('subject_title_3') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_3_content').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('subject_title_3_content',isset($block)?$block->subject_title_3_content:'',['class'=>'form-control
                                                m-input ','id'=>'subject_title_3_content']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_3_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_3_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_4_title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_4',isset($block)?$block->subject_title_4:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_4')) <p style="color:red;">
                                                {{ $errors->first('subject_title_4') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.subject_4_content').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('subject_title_4_content',isset($block)?$block->subject_title_4_content:'',['class'=>'form-control
                                                m-input ','id'=>'subject_title_4_content']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_4_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_4_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif

                                <!-- exam formats -->
                                @if(config('constant.blocks.ePaper.home.exam_formats') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.exam_format_1_title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('exam_format_title_1',isset($block)?$block->exam_format_title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('exam_format_title_1')) <p style="color:red;">
                                                {{ $errors->first('exam_format_title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.exam_format_1_content').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('exam_format_title_1_content',isset($block)?$block->exam_format_title_1_content:'',['class'=>'form-control
                                                m-input ','id'=>'exam_format_title_1_content']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('exam_format_title_1_content')) <p style="color:red;">
                                                    {{ $errors->first('exam_format_title_1_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.exam_format_2_title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('exam_format_title_2',isset($block)?$block->exam_format_title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('exam_format_title_2')) <p style="color:red;">
                                                {{ $errors->first('exam_format_title_2') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.exam_format_2_content').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('exam_format_title_2_content',isset($block)?$block->exam_format_title_2_content:'',['class'=>'form-control
                                                m-input ','id'=>'exam_format_title_2_content']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('exam_format_title_2_content')) <p style="color:red;">
                                                    {{ $errors->first('exam_format_title_2_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if($block->project_type == 3)
                                {{-- Ace mock Landing page slider --}}
                                @if(config('constant.blocks.aceMock.home.banner_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_1_title',isset($block)?$block->slider_1_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide1title']) !!}
                                            @if ($errors->has('slider_1_title')) <p style="color:red;">
                                                {{ $errors->first('slider_1_title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_1'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('slider_1_sub_title',isset($block)?$block->slider_1_sub_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide1subtitle']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_sub_title')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_sub_title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description1'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_1_description',isset($block)?$block->slider_1_description:'',['class'=>'form-control
                                                m-input ','id'=>'slider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_2_title',isset($block)?$block->slider_1_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide2title']) !!}
                                            @if ($errors->has('slider_2_title')) <p style="color:red;">
                                                {{ $errors->first('slider_2_title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_2'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_2_sub_title',isset($block)?$block->slider_2_sub_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide2subtitle']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_2_sub_title')) <p style="color:red;">
                                                    {{ $errors->first('slider_2_sub_title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description2'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_2_description',isset($block)?$block->slider_2_description:'',['class'=>'form-control
                                                m-input ','id'=>'slide2description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_2_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_2_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_3_title',isset($block)?$block->slider_3_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide3title']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_3_title')) <p style="color:red;">
                                                    {{ $errors->first('slider3title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_3_sub_title',isset($block)?$block->slider_3_sub_title:'',['class'=>'form-control
                                            m-input err_msg ','id'=>'slide3subtitle','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('slider_3_sub_title')) <p style="color:red;">
                                                {{ $errors->first('slider_3_sub_title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_3_description',isset($block)?$block->slider_3_description:'',['class'=>'form-control
                                                m-input ','id'=>'slide3description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_3_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_3_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Ace mock Landing page our module --}}
                                @if(config('constant.blocks.aceMock.home.our_module_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.content_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::text('title_3',isset($block)?$block->title:'',['class'=>'form-control
                                                m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('title_3')) <p style="color:red;">
                                                    {{ $errors->first('title_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_3',isset($block)?$block->content_3:'',['class'=>'form-control
                                                m-input ','id'=>'content_3']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_3')) <p style="color:red;">
                                                    {{ $errors->first('content_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page our module --}}
                                @if(config('constant.blocks.aceMock.home.about_ash_ace') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Total No. Of E-PAPER *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_1',isset($block)?$block->subject_title_1:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_1_max_length')]) !!}
                                            @if ($errors->has('subject_title_1')) <p style="color:red;">
                                                {{ $errors->first('subject_title_1') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Total No. Of Exams *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_2',isset($block)?$block->subject_title_2:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_2_max_length')]) !!}
                                            @if ($errors->has('subject_title_2')) <p style="color:red;">
                                                {{ $errors->first('subject_title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Total No. Of Questions *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_3',isset($block)?$block->subject_title_3:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_3_max_length')]) !!}
                                            @if ($errors->has('subject_title_3')) <p style="color:red;">
                                                {{ $errors->first('subject_title_3') }}</p> @endif
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page  why choose us --}}
                                @if(config('constant.blocks.aceMock.home.why_choose_ash_ace') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_3',isset($block)?$block->title_3:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_3')) <p style="color:red;">
                                                {{ $errors->first('title_3') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_3',isset($block)?$block->content_3:'',['class'=>'form-control
                                                m-input ','id'=>'content_3']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_3')) <p style="color:red;">
                                                    {{ $errors->first('content_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_4').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_4',isset($block)?$block->title_4:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_4')) <p style="color:red;">
                                                {{ $errors->first('title_4') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_4').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_4',isset($block)?$block->content_4:'',['class'=>'form-control
                                                m-input ','id'=>'content_4']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_4')) <p style="color:red;">
                                                    {{ $errors->first('content_4') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_5').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_5',isset($block)?$block->title_5:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_5')) <p style="color:red;">
                                                {{ $errors->first('title_5') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_5').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_5',isset($block)?$block->content_5:'',['class'=>'form-control
                                                m-input ','id'=>'content_5']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_5')) <p style="color:red;">
                                                    {{ $errors->first('content_5') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_6').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_6',isset($block)?$block->title_6:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_6')) <p style="color:red;">
                                                {{ $errors->first('title_6') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_6').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_6',isset($block)?$block->content_6:'',['class'=>'form-control
                                                m-input ','id'=>'content_6']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_6')) <p style="color:red;">
                                                    {{ $errors->first('content_6') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page  video section --}}
                                @if(config('constant.blocks.aceMock.home.video_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.video').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('video_url',isset($block)?$block->video_url:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('video_url')) <p style="color:red;">
                                                {{ $errors->first('video_url') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page help section --}}
                                @if(config('constant.blocks.aceMock.home.help_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.image') .'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12'])
                                        !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!!Form::file('image_1',['id'=>'imgInput1','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                            <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                            @if ($errors->has('image_1')) <p class='errors' style="color:red;">
                                                {{ $errors->first('image_1') }}</p>
                                            @endif
                                            @if($block)
                                                <img id="blah" src="{{@$block->image_path }}" alt="" height="200px;" width="200px;"
                                                style="display:block;" />
                                            @else
                                            <img id="blah" src="" alt="" height="200px;" width="200px;"
                                                style="display:none;" />
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.image') .'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12'])
                                        !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!!Form::file('image_2',['id'=>'imgInput2','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                            <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                            @if ($errors->has('image_2')) <p class='errors' style="color:red;">
                                                {{ $errors->first('image_2') }}</p>
                                            @endif
                                            @if($block)
                                                <img id="blah2" src="{{@$block->image_path }}" alt="" height="200px;" width="200px;"
                                                style="display:block;" />
                                            @else
                                            <img id="blah2" src="" alt="" height="200px;" width="200px;"
                                                style="display:none;" />
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.image') .'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12'])
                                        !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!!Form::file('image_3',['id'=>'imgInput3','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                            <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                            @if ($errors->has('image_3')) <p class='errors' style="color:red;">
                                                {{ $errors->first('image_3') }}</p>
                                            @endif
                                            @if($block)
                                                <img id="blah3" src="{{@$block->image_path }}" alt="" height="200px;" width="200px;"
                                                style="display:block;" />
                                            @else
                                            <img id="blah3" src="" alt="" height="200px;" width="200px;"
                                                style="display:none;" />
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_3',isset($block)?$block->title_3:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_3')) <p style="color:red;">
                                                {{ $errors->first('title_3') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_3',isset($block)?$block->content_3:'',['class'=>'form-control
                                                m-input ','id'=>'content_3']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_3')) <p style="color:red;">
                                                    {{ $errors->first('content_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.image') .'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12'])
                                        !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!!Form::file('image_4',['id'=>'imgInput4','class'=>'form-control m-input','accept' => 'image/*'])!!}
                                            <input type="hidden" name="stored_img_name" id="stored_img_id" value="{{@$user->profile_pic}}">
                                            @if ($errors->has('image_4')) <p class='errors' style="color:red;">
                                                {{ $errors->first('image_4') }}</p>
                                            @endif
                                            @if($block)
                                                <img id="blah4" src="{{@$block->image_path }}" alt="" height="200px;" width="200px;"
                                                style="display:block;" />
                                            @else
                                            <img id="blah4" src="" alt="" height="200px;" width="200px;"
                                                style="display:none;" />
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_4').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_4',isset($block)?$block->title_4:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_4')) <p style="color:red;">
                                                {{ $errors->first('title_4') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_4').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_4',isset($block)?$block->content_4:'',['class'=>'form-control
                                                m-input ','id'=>'content_4']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_4')) <p style="color:red;">
                                                    {{ $errors->first('content_4') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page school section --}}
                                @if(config('constant.blocks.aceMock.home.school_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control m-input ','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page help section --}}
                                @if(config('constant.blocks.aceMock.home.subscribe_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if($block->project_type == 1)
                                {{-- Ace mock Landing page slider --}}
                                @if(config('constant.blocks.aceMock.emock.banner_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_1_title',isset($block)?$block->slider_1_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide1title']) !!}
                                            @if ($errors->has('slider_1_title')) <p style="color:red;">
                                                {{ $errors->first('slider_1_title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_1'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('slider_1_sub_title',isset($block)?$block->slider_1_sub_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide1subtitle']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_sub_title')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_sub_title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description1'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_1_description',isset($block)?$block->slider_1_description:'',['class'=>'form-control
                                                m-input ','id'=>'slider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_2_title',isset($block)?$block->slider_1_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide2title']) !!}
                                            @if ($errors->has('slider_2_title')) <p style="color:red;">
                                                {{ $errors->first('slider_2_title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_2'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_2_sub_title',isset($block)?$block->slider_2_sub_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide2subtitle']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_2_sub_title')) <p style="color:red;">
                                                    {{ $errors->first('slider_2_sub_title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description2'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_2_description',isset($block)?$block->slider_2_description:'',['class'=>'form-control
                                                m-input ','id'=>'slide2description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_2_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_2_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_3_title',isset($block)?$block->slider_3_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide3title']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_3_title')) <p style="color:red;">
                                                    {{ $errors->first('slider3title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_3_sub_title',isset($block)?$block->slider_3_sub_title:'',['class'=>'form-control
                                            m-input err_msg ','id'=>'slide3subtitle','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('slider_3_sub_title')) <p style="color:red;">
                                                {{ $errors->first('slider_3_sub_title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_3_description',isset($block)?$block->slider_3_description:'',['class'=>'form-control
                                                m-input ','id'=>'slide3description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_3_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_3_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                @if(config('constant.blocks.aceMock.emock.paper_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                                m-input ','id'=>'eslide1title']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.content'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input ','id'=>'eslider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                @if(config('constant.blocks.aceMock.emock.how_exam_work_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                                m-input ','id'=>'eslide1title']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.content'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input ','id'=>'eslider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.video').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('video_url',isset($block)?$block->video_url:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('video_url')) <p style="color:red;">
                                                {{ $errors->first('video_url') }}</p> @endif
                                        </div>
                                    </div>
                                @endif
                                @if(config('constant.blocks.aceMock.emock.question_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                                m-input ','id'=>'eslide1title']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.content'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input ','id'=>'eslider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                @if(config('constant.blocks.aceMock.emock.child_performance_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                                m-input ','id'=>'eslide1title']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.content'), null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input ','id'=>'eslider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if($block->project_type == 2)
                                {{-- Ace mock Landing page slider --}}
                                @if(config('constant.blocks.practice.home.banner_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_1_title',isset($block)?$block->slider_1_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide1title']) !!}
                                            @if ($errors->has('slider_1_title')) <p style="color:red;">
                                                {{ $errors->first('slider_1_title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_1'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('slider_1_sub_title',isset($block)?$block->slider_1_sub_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide1subtitle']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_sub_title')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_sub_title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description1'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_1_description',isset($block)?$block->slider_1_description:'',['class'=>'form-control
                                                m-input ','id'=>'slider1description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title2').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_2_title',isset($block)?$block->slider_1_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide2title']) !!}
                                            @if ($errors->has('slider_2_title')) <p style="color:red;">
                                                {{ $errors->first('slider_2_title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_2'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_2_sub_title',isset($block)?$block->slider_2_sub_title:'',['class'=>'form-control
                                                m-input ','id'=>'slide2subtitle']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_2_sub_title')) <p style="color:red;">
                                                    {{ $errors->first('slider_2_sub_title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description2'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('slider_2_description',isset($block)?$block->slider_2_description:'',['class'=>'form-control
                                                m-input ','id'=>'slide2description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_2_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_2_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.title3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('slider_3_title',isset($block)?$block->slider_3_title:'',['class'=>'form-control m-input ','id'=>'slide3title']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_3_title')) <p style="color:red;">
                                                    {{ $errors->first('slider3title') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.sub_title_3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('slider_3_sub_title',isset($block)?$block->slider_3_sub_title:'',['class'=>'form-control
                                            m-input err_msg ','id'=>'slide3subtitle','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('slider_3_sub_title')) <p style="color:red;">
                                                {{ $errors->first('slider_3_sub_title') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.description3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('slider_3_description',isset($block)?$block->slider_3_description:'',['class'=>'form-control
                                                m-input ','id'=>'slide3description']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_3_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_3_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Ace mock Landing page our module --}}
                                @if(config('constant.blocks.practice.home.our_module_section') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practiceModuleSection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.content_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::text('title_3',isset($block)?$block->title:'',['class'=>'form-control
                                                m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('title_3')) <p style="color:red;">
                                                    {{ $errors->first('title_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_3',isset($block)?$block->content_3:'',['class'=>'form-control
                                                m-input ','id'=>'content_3']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_3')) <p style="color:red;">
                                                    {{ $errors->first('content_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page our module --}}
                                @if(config('constant.blocks.practice.home.about_ash_ace') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Total Practice Papaers *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_1',isset($block)?$block->subject_title_1:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_1_max_length')]) !!}
                                            @if ($errors->has('subject_title_1')) <p style="color:red;">
                                                {{ $errors->first('subject_title_1') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Total Practice Questions *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_2',isset($block)?$block->subject_title_2:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_2_max_length')]) !!}
                                            @if ($errors->has('subject_title_2')) <p style="color:red;">
                                                {{ $errors->first('subject_title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Practice Papers *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_3',isset($block)?$block->subject_title_3:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_3_max_length')]) !!}
                                            @if ($errors->has('subject_title_3')) <p style="color:red;">
                                                {{ $errors->first('subject_title_3') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row" id="practiceAboutSection">
                                        {!! Form::label('Happy Customers *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_4',isset($block)?$block->subject_title_4:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_subject_title_3_max_length')]) !!}
                                            @if ($errors->has('subject_title_3')) <p style="color:red;">
                                                {{ $errors->first('subject_title_3') }}</p> @endif
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page  why choose us --}}
                                @if(config('constant.blocks.practice.home.why_choose_ash_ace') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_3',isset($block)?$block->title_3:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_3')) <p style="color:red;">
                                                {{ $errors->first('title_3') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_3',isset($block)?$block->content_3:'',['class'=>'form-control
                                                m-input ','id'=>'content_3']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_3')) <p style="color:red;">
                                                    {{ $errors->first('content_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_4').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_4',isset($block)?$block->title_4:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_4')) <p style="color:red;">
                                                {{ $errors->first('title_4') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_4').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_4',isset($block)?$block->content_4:'',['class'=>'form-control
                                                m-input ','id'=>'content_4']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_4')) <p style="color:red;">
                                                    {{ $errors->first('content_4') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_5').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_5',isset($block)?$block->title_5:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_5')) <p style="color:red;">
                                                {{ $errors->first('title_5') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_5').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_5',isset($block)?$block->content_5:'',['class'=>'form-control
                                                m-input ','id'=>'content_5']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_5')) <p style="color:red;">
                                                    {{ $errors->first('content_5') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_6').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_6',isset($block)?$block->title_6:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_6')) <p style="color:red;">
                                                {{ $errors->first('title_6') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_6').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_6',isset($block)?$block->content_6:'',['class'=>'form-control
                                                m-input ','id'=>'content_6']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_6')) <p style="color:red;">
                                                    {{ $errors->first('content_6') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page  video section --}}
                                @if(config('constant.blocks.practice.home.video_section') == @$block->slug)
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.video').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('video_url',isset($block)?$block->video_url:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('video_url')) <p style="color:red;">
                                                {{ $errors->first('video_url') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page help section --}}
                                @if(config('constant.blocks.practice.home.help_section') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practiceHelpSection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',isset($block)?$block->title:'',['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',isset($block)?$block->content:'',['class'=>'form-control
                                                m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_1',isset($block)?$block->title_1:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_1')) <p style="color:red;">
                                                {{ $errors->first('title_1') }}</p> @endif
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_1',isset($block)?$block->content_1:'',['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_1')) <p style="color:red;">
                                                    {{ $errors->first('content_1') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_2',isset($block)?$block->title_2:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_2')) <p style="color:red;">
                                                {{ $errors->first('title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_2').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_2',isset($block)?$block->content_2:'',['class'=>'form-control
                                                m-input ','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_2')) <p style="color:red;">
                                                    {{ $errors->first('content_2') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_3',isset($block)?$block->title_3:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_3')) <p style="color:red;">
                                                {{ $errors->first('title_3') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_3').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_3',isset($block)?$block->content_3:'',['class'=>'form-control
                                                m-input ','id'=>'content_3']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_3')) <p style="color:red;">
                                                    {{ $errors->first('content_3') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_4').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title_4',isset($block)?$block->title_4:'',['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title_4')) <p style="color:red;">
                                                {{ $errors->first('title_4') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_4').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!!
                                                Form::textarea('content_4',isset($block)?$block->content_4:'',['class'=>'form-control
                                                m-input ','id'=>'content_4']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content_4')) <p style="color:red;">
                                                    {{ $errors->first('content_4') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- Ace mock Landing page pay section --}}
                                @if(config('constant.blocks.practice.home.pay_section') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practicePaySection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',@$block->title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',@$block->content,['class'=>'form-control m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label('Price *', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('sub_title',@$block->sub_title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('sub_title')) 
                                                <p style="color:red;">
                                                    {{ $errors->first('sub_title') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('slider_1_title',@$block->slider_1_title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('slider_1_title')) 
                                                <p style="color:red;">
                                                    {{ $errors->first('slider_1_title') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label
                                        col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('slider_1_sub_title',@$block->slider_1_sub_title,['class'=>'form-control
                                            m-input err_msg ','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('slider_1_sub_title')) <p style="color:red;">
                                                {{ $errors->first('slider_1_sub_title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label
                                        col-lg-3
                                        col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('slider_1_description',@$block->slider_1_description,['class'=>'form-control
                                                m-input ','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('slider_1_description')) <p style="color:red;">
                                                    {{ $errors->first('slider_1_description') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- practice home page practice section --}}
                                @if(config('constant.blocks.practice.practice.practice_section') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practicePaySection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',@$block->title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',@$block->content,['class'=>'form-control m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- practice home page topic section --}}
                                @if(config('constant.blocks.practice.practice.topic_section') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practicePaySection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',@$block->title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',@$block->content,['class'=>'form-control m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_1',@$block->subject_title_1,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_1')) <p style="color:red;">
                                                {{ $errors->first('subject_title_1') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_1_content',@$block->subject_title_1_content,['class'=>'form-control m-input']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_1_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_1_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_2',@$block->subject_title_2,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_2')) <p style="color:red;">
                                                {{ $errors->first('subject_title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_2_content',@$block->subject_title_2_content,['class'=>'form-control m-input']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_2_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_2_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_3').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_3',@$block->subject_title_3,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_3')) <p style="color:red;">
                                                {{ $errors->first('subject_title_3') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_3_content',@$block->subject_title_3_content,['class'=>'form-control m-input']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_3_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_3_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- practice home page past paper section --}}
                                @if(config('constant.blocks.practice.practice.past_paper_section') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practicePaySection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',@$block->title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',@$block->content,['class'=>'form-control m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_1',@$block->subject_title_1,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_1')) <p style="color:red;">
                                                {{ $errors->first('subject_title_1') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_1_content',@$block->subject_title_1_content,['class'=>'form-control m-input','id'=>'content_1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_1_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_1_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_title_2').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('subject_title_2',@$block->subject_title_2,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('subject_title_2')) <p style="color:red;">
                                                {{ $errors->first('subject_title_2') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.module_description_1').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('subject_title_2_content',@$block->subject_title_2_content,['class'=>'form-control m-input','id'=>'content_2']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('subject_title_2_content')) <p style="color:red;">
                                                    {{ $errors->first('subject_title_2_content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- practice home page practice section detail --}}
                                @if(config('constant.blocks.practice.practice.practice_section_detail') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practicePaySection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::text('title',@$block->title,['class'=>'form-control
                                            m-input err_msg','maxlength' => config('constant.input_title_max_length')]) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',@$block->content,['class'=>'form-control m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label('Note *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('note',@$block->note,['class'=>'form-control m-input','id'=>'content_1']) !!}
                                            </div>
                                            <span class="noteError">
                                                @if ($errors->has('note')) <p style="color:red;">
                                                    {{ $errors->first('note') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                                {{-- practice home page past paper section detail --}}
                                @if(config('constant.blocks.practice.practice.past_paper_section_detail') == @$block->slug)
                                    <div class="form-group m-form__group row" id="practicePaySection">
                                        {!! Form::label(__('formname.title').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            {!! Form::textarea('title',@$block->title,['class'=>'form-control m-input','id'=>'content_1']) !!}
                                            @if ($errors->has('title')) <p style="color:red;">
                                                {{ $errors->first('title') }}</p> @endif
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label(__('formname.block.aceMock.content').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::textarea('content',@$block->content,['class'=>'form-control m-input','id'=>'editor1']) !!}
                                            </div>
                                            <span class="contentError">
                                                @if ($errors->has('content')) <p style="color:red;">
                                                    {{ $errors->first('content') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! Form::label('Tite 2 *', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                                        <div class="col-lg-6 col-md-9 col-sm-12">
                                            <div class="input-group">
                                                {!! Form::text('note',@$block->note,['class'=>'form-control m-input']) !!}
                                            </div>
                                            <span class="noteError">
                                                @if ($errors->has('note')) <p style="color:red;">
                                                    {{ $errors->first('note') }}</p> @endif
                                            </span>
                                            <span class="m-form__help"></span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            {!! Form::hidden('id',isset($block)?$block->id:'' ,['id'=>'id']) !!}
                            {!! Form::hidden('slug',isset($block)?$block->slug:'' ,['id'=>'slug']) !!}
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions">
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            {!! Form::submit('Save', ['class' => 'btn btn-success'] )!!}
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
    var slug = "{{ @$block->slug }}";
    var CONSTANT_VARS = $.extend({}, {!!json_encode(config('constant'), JSON_FORCE_OBJECT) !!});
</script>
<script src="{{ asset('backend/js/blocks/create.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js">
</script>

@stop