@php
    $hours = hours();
    $minutes = minutes();
    $seconds = seconds();
@endphp
<div class="paperSection card p-4 mt-4 mb-4" data-paper_key="{{@$paperKey}}" data-subject_slug="{{$i}}">
    <div class="m-portlet__head-title row">
        <div class="col-md-3">
            <h5 class="m-portlet__head-text">
                Section
            </h5>
        </div>
        <div class="col-md-6">
        </div>
    </div>
    {!! Form::hidden('section['.@$i.'][question_ids]',null ,['class'=>'']) !!}
    <div class="paper mt-4 mb-4" id='paper{{@$paperKey}}Subject0' data-paper_key="{{@$paperKey}}" data-subject_key="{{$i}}">
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.mock-test.subject_id').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][subject_id]', @$subjectList, null, ['class' =>'form-control','data-key'=>$i,'multiple'=>false]) !!}
                @if ($errors->has('subject_id'))
                    <p class='errors' style="color:red;">{{ $errors->first('subject_ids') }}</p>
                @endif
                <span class="subjectError"></span>
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.section_name'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::text('section['.@$i.'][name]',null,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.section_name')]) !!}
                @if ($errors->has('name'))
                    <p class='errors' style="color:red;">{{ $errors->first('name') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.section_instruction'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::textarea('section['.@$i.'][description]',null,['id'=>'paper'.@$paperKey.'Subject'.@$i.'0Instruction','class'=>'form-control ckeditor noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.instruction')]) !!}
                @if ($errors->has('instruction'))
                    <p class='errors' style="color:red;">{{ $errors->first('instruction') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.instruction_image'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                <div class="input-group">
                    {!! Form::file('section['.@$i.'][image]',['id'=>'paper'.@$paperKey.'Subject0InstrctImage','class'=>'custom-file-input noOfPapaer','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.instruction_read_time'),'accept'=>'image/png, image/jpeg']) !!}
                    <label class="custom-file-label" for="paper{{@$paperKey}}Subject0InstrctImage">{{__('formname.choose_file')}}</label>
                </div>
                @if ($errors->has('questions'))
                    <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.instruction_read_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-2 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][instruction_read_time][hours]',@$hours,null,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                @if ($errors->has('time'))
                    <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                @endif
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][instruction_read_time][minutes]',@$minutes,null,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                @if ($errors->has('time'))
                    <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                @endif
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][instruction_read_time][seconds]',@$seconds,null,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                <span class="secondError"></span>
                @if ($errors->has('time'))
                    <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.mock-test.report_question').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::text('section['.@$i.'][report_question]',null,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.report_question')]) !!}
                @if ($errors->has('questions'))
                    <p class='errors' style="color:red;">{{ $errors->first('questions') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.section_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
            <div class="col-lg-2 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][section_time][hours]',@$hours,null,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                @if ($errors->has('time'))
                    <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                @endif
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][section_time][minutes]',@$minutes,null,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
                @if ($errors->has('time'))
                    <p class='errors' style="color:red;">{{ $errors->first('time') }}</p>
                @endif
            </div>
            <div class="col-lg-2 col-md-9 col-sm-12">
                {!! Form::select('section['.@$i.'][section_time][seconds]',@$seconds,null,['class'=>'form-control noOfPapaer m-input err_msg timepicker','maxlength'=>config('constant.name_length')]) !!}
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
                    <input type="file" class="custom-file-input" name="section[{{@$i}}][import_file]" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="paper{{@$paperKey}}Subject0Import">
                    @if($errors->has('import_file'))<p class="errors">{{$errors->first('import_file')}}</p>@endif
                    <label class="custom-file-label" for="paper{{@$paperKey}}Subject0Import">{{__('formname.choose_file')}}</label>
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
                    <input type="file" class="custom-file-input" name="section[{{@$i}}][passage]" multiple='false' accept="application/pdf" id="paper{{@$paperKey}}Subject0Passage">
                    @if($errors->has('passage'))<p class="errors">{{$errors->first('passage')}}</p>@endif
                    <label class="custom-file-label" for="paper{{@$paperKey}}Subject0Passage">{{__('formname.choose_file')}}</label>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-form-label col-lg-3 col-sm-12">{{__('formname.images')}} </label>
            <div class="col-lg-6 col-md-9 col-sm-12">
                <div class="input-group">
                    <input type="file" class="custom-file-input" name="section[{{@$i}}][images][]" accept="image/png, image/jpeg" id="paper{{@$paperKey}}Subject0Images" multiple='true'>
                    @if($errors->has('images'))<p class="errors">{{$errors->first('images')}}</p>@endif
                    <label class="custom-file-label" for="paper{{@$paperKey}}Subject0Images">{{__('formname.choose_file')}}</label>
                </div>
            </div>
        </div>
        {!! Form::hidden('section['.@$i.'][seq]',0,['class'=>'form-control noOfPapaer m-input err_msg','maxlength'=>config('constant.name_length'),'placeholder'=>__('formname.mock-test.time')]) !!}
        <div class="form-group m-form__group row">
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-3">
                <button type="button" class="btn btn-danger removedPaperSubject" data-subject_slug="{{$i}}" data-paper_key="{{@$paperKey}}" data-subject_key="{{$i}}">Delete</button>
            </div>
        </div>
    </div>
</div>
