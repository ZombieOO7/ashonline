@forelse (@$topics as $key => $topic)
<div class="form-group m-form__group row">
    <div class="col-lg-12 col-sm-12 text-center">
        <h5>{!! Str::ucfirst(@$topic->title) !!}</h5>
    </div>
</div>
{!! Form::hidden("topic[".@$topic->id."][topic_id]",@$topic->id,['id'=>'time'.$key,'class'=>'']) !!}
<div class="form-group m-form__group row">
    {!! Form::label(__('formname.practice-exam.no_of_question').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
    <div class="col-lg-6">
        {!! Form::text("topic[".@$topic->id."][no_of_questions]",null,['id'=>'time'.$key,'class'=>'form-control m-input err_msg dynamicTInput','maxlength'=>config('constant.time_length'),'placeholder'=>__('formname.practice-exam.no_of_question')]) !!}
        @if ($errors->has('no_of_questions'))
            <p style="color:red;">{{ $errors->first('no_of_questions') }}</p> 
        @endif
        <span class="timeError"></span>
    </div>
</div>
@empty
@endforelse