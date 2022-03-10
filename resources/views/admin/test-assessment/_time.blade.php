@forelse (@$subjects as $key => $subject)
<div class="form-group m-form__group row">
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
        {{-- <div class="form-control-feedback text-danger time{{$key}}" style="display: none; font-size:.85rem;">Please enter greater than 10 minutes</div> --}}
        </span>
    </div>
    {{-- {!! Form::label(__('formname.mock-test.question').'*', null,['class'=>'col-form-label col-lg-2 col-sm-12']) !!}
    <div class="col-lg-2">
        {!! Form::text("test_detail[".@$subject->id."][questions]",null,['class'=>'form-control
        m-input err_msg dynamicQInput','maxlength'=>config('constant.question_length'),'placeholder'=>__('formname.mock-test.question')]) !!}
        @if ($errors->has('question'))
            <p style="color:red;">{{ $errors->first('question') }}</p> 
        @endif
    </div> --}}
</div>
<div class="form-group m-form__group row">
    <div class='col-lg-5 col-sm-12'>
    </div>
    <div class='col-lg-3 col-sm-12'>
        {{-- {!! Form::button(__('formname.add_question'), ['class' => 'btn btn-info addQuestion', 
        'data-subject-id'=>@$subject->id,'data-limit'=>'test_detail['.@$subject->id.'][questions]',
        'data-toggle'=>'modal'] )!!} --}}
    {!! Form::hidden("test_detail[".@$subject->id."][subject_id]",@$subject->id) !!}
    {{-- {!! Form::hidden("subject[".@$subject->id."][question_ids]",null,['id'=>'questionId-'.@$subject->id]) !!} --}}
    </div>
</div>
@empty
@endforelse