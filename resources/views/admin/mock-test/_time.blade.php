@forelse (@$subjects as $key => $subject)
<div class="form-group m-form__group row">
    {{-- <div class="col-lg-5 col-sm-12">
    </div> --}}
    <div class="col-lg-12 col-sm-12 text-center">
        <h5>{!!@$subject->title!!}</h5>
    </div>
</div>
<div class="form-group m-form__group row">
    {!! Form::label(__('formname.mock-test.time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
    <div class="col-lg-6">
        {!! Form::text("test_detail[".@$subject->id."][time]",null,['id'=>'time'.$key,'class'=>'form-control
        m-input err_msg dynamicTInput','maxlength'=>config('constant.time_length'),'placeholder'=>__('formname.mock-test.time')]) !!}
        @if ($errors->has('time'))
            <p style="color:red;">{{ $errors->first('time') }}</p> 
        @endif
        <span class="timeError time{{$key}}">
        </span>
    </div>
</div>
<div class="form-group m-form__group row">
    {!! Form::label(__('formname.mock-test.report_question').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
    <div class="col-lg-6">
        {!! Form::text("test_detail[".@$subject->id."][report_question]",null,['class'=>'form-control
        m-input err_msg dynamicTInput','maxlength'=>config('constant.question_length'),'placeholder'=>__('formname.mock-test.report_question')]) !!}
        @if ($errors->has('report_question'))
            <p style="color:red;">{{ $errors->first('report_question') }}</p> 
        @endif
    </div>
</div>
{{-- <div class="form-group m-form__group row">
    <div class='col-lg-5 col-sm-12'>
    </div>
    <div class='col-lg-3 col-sm-12'>
        {!! Form::button(__('formname.add_question'), ['class' => 'btn btn-info addQuestion', 
        'data-subject-id'=>@$subject->id,'data-limit'=>'test_detail['.@$subject->id.'][questions]',
        'data-toggle'=>'modal'] )!!} --}}
    {!! Form::hidden("test_detail[".@$subject->id."][subject_id]",@$subject->id) !!}
    {{-- {!! Form::hidden("subject[".@$subject->id."][question_ids]",null,['id'=>'questionId-'.@$subject->id]) !!} --}}
    {{-- </div> --}}
{{-- </div> --}}
@empty
@endforelse