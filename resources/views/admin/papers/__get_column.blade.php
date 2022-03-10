@if(@$type == 1)
<div class="form-group m-form__group row">
    {!! Form::label('subject_id',__('formname.test_papers.subject')." <sup class='rqvr'>*</sup>" ,['class'=>'col-form-label col-lg-3
    col-sm-12'],false) !!}
    <div class="col-lg-6 col-md-9 col-sm-12">
        {!! Form::select('subject_id', @$subjects, @$paper->subject_id,
        ['id'=>'subject_id','class' =>'form-control','placeholder' => __('formname.select')]) !!}
    </div>
</div>
<div class="form-group m-form__group row">
    {!! Form::label('exam_type_id',__('formname.test_papers.exam_type')." <sup class='rqvr'>*</sup>" ,['class'=>'col-form-label col-lg-3
    col-sm-12'],false) !!}
    <div class="col-lg-6 col-md-9 col-sm-12">
        {!! Form::select('exam_type_id', @$examTypes, @$paper->exam_type_id,
        ['id' => 'exam_type_id','class' =>'form-control','placeholder' => __('formname.select')]) !!}
    </div>
</div>
<div class="form-group m-form__group row mb-3">
    {!! Form::label('age','Age'." <sup class='rqvr'>*</sup>" ,['class'=>'col-form-label col-lg-3
    col-sm-12'],false) !!}
    <div class="col-lg-6 col-md-9 col-sm-12">
        {!! Form::select('age_id', @$ages, @$paper->age_id,
        ['id' => 'age_id','class' =>'form-control','placeholder' => __('formname.select')]) !!}
    </div>
</div>
@elseif(@$type == 2)
<div class="form-group m-form__group row">
    {!! Form::label('stage_id',__('formname.test_papers.stage')." <sup class='rqvr'>*</sup>" ,['class'=>'col-form-label col-lg-3
    col-sm-12'],false) !!}
    <div class="col-lg-6 col-md-9 col-sm-12">
        {!! Form::select('stage_id', @$stages, @$paper->stage_id,
        ['id'=>'stage_id','class' =>'form-control','placeholder' => __('formname.select')]) !!}
    </div>
</div>
@endif