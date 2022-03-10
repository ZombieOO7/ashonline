@php
$questionAsnwers = (@$pastPaper->pastPaperQuestion != null) ? $pastPaper->pastPaperQuestion->sortBy('question_no') : []; 
$count = count($questionAsnwers);
@endphp
@if($type == 'get')
@forelse($questionAsnwers as $key => $questionAnswer)
    <div class="row questionAnswerData card pt-5" id='clone{{$key}}'>
        {{-- <div class="col-md-3"></div> --}}
        {{-- <div class="col-md-6"> --}}
            <input type="hidden" name="data[{{$key}}][past_paper_question_id]" value="{{$questionAnswer->id}}">
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.question_image_lbl').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                <div class="col-lg-6 col-sm-12">
                    <div class="input-group err_msg">
                        {!! Form::file("data[".$key."][question_image]", ['class'=>'custom-file-input' ,'id'=>'questioImage'.$key ]) !!}
                        {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                        <input type="hidden" name="data[{{$key}}][stored_question_image]" id="stored_question_image_{{$key}}"
                            value="{{@$questionAnswer->question_image}}">
                    </div>
                    @if ($errors->has("data[".$key."][question_image]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$key."][question_image]") }}
                        </p>
                    @endif
                    @if(isset($questionAnswer))
                        <div class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{$questionAnswer->question_image_path}}" >
                            <img src="{{ $questionAnswer->question_image_path }}" alt="" width='200px' height='200px'>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.answer_image_lbl').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                <div class="col-lg-6 col-sm-12">
                    <div class="input-group err_msg">
                        {!! Form::file("data[".$key."][answer_image]", ['class'=>'custom-file-input' ,'id'=>'answerImage'.$key ]) !!}
                        {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                        <input type="hidden" name="data[{{$key}}][stored_answer_image]" id="stored_answer_image_{{$key}}"
                            value="{{@$questionAnswer->answer_image}}">
                    </div>
                    @if ($errors->has("data[".$key."][answer_image]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$key."][answer_image]") }}
                        </p>
                    @endif
                    @if(isset($questionAnswer))
                        <div class="gallery2" data-lightbox="image-1" data-featherlight="image" href="{{$questionAnswer->answer_image_path}}" >
                            <img src="{{ $questionAnswer->answer_image_path }}" alt=""  width='200px' height='200px'>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.solved_question_time').'*', null,['class'=>'col-form-label col-lg-3
                col-sm-12']) !!}
                <div class="col-lg-6 col-sm-12">
                    {!! Form::text("data[".$key."][solved_question_time]",@$questionAnswer->solved_question_time,['class' => 'form-control' ]) !!}
                    @if ($errors->has("data[".$key."][solved_question_time]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$key."][solved_question_time]") }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {{-- {!! Form::label(__('formname.question_topic').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!} --}}
                <div class="col-md-3 text-right mt-2">
                    <label for="" class="">{{__('formname.question_topic')}}</label>
                </div>
                <div class="col-lg-6 col-sm-12">
                    {!! Form::select("data[".$key."][topic][]",@$topicList,@$questionAnswer->topicList(),['id'=>'topic'.$key, 'class' => 'form-control selectpicker', 'multiple'=>true]) !!}
                    <span class='topic{{$key}}Error'></span>
                    @if ($errors->has("data[".$key."][topic]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$key."][topic]") }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row mb-4">
                    <div class="col-md-3"></div>
                    <div class="col-md-3 ml-2">
                        <a href="javascript:;" class="col-md-5 btn btn-danger removeQuestionAnswer" data-id="clone{{$key}}"  role="button"><span class="fa fa-trash"></span> {{__('formname.remove_question')}}</a>
                    </div>
            </div>
        {{-- </div> --}}
    </div>
@empty
@endforelse
@else
    <div class="row questionAnswerData card pt-5" id='clone{{$index}}'>
        {{-- <div class="col-md-3"></div> --}}
        {{-- <div class="col-md-6"> --}}
            <input type="hidden" name="data[{{$index}}][past_paper_question_id]" value="">
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.question_image_lbl').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                <div class="col-lg-6 col-sm-12">
                    <div class="input-group err_msg">
                        {!! Form::file("data[".$index."][question_image]", ['class'=>'custom-file-input' ,'id'=>'questionImage'.$index ]) !!}
                        {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                        <input type="hidden" name="data[{{$index}}][stored_question_image]" id="stored_question_image_{{$index}}" value="">
                    </div>
                    @if ($errors->has("data[".$index."][question_image]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$index."][question_image]") }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.answer_image_lbl').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                <div class="col-lg-6 col-sm-12">
                    <div class="input-group err_msg">
                        {!! Form::file("data[".$index."][answer_image]", ['class'=>'custom-file-input' ,'id'=>'answerImage'.$index ]) !!}
                        {!! Form::label('Choose file', null,['class'=>'custom-file-label']) !!}
                        <input type="hidden" name="data[{{$index}}][stored_answer_image]" id="stored_answer_image_{{$index}}"
                            value="">
                    </div>
                    @if ($errors->has("data[".$index."][answer_image]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$index."][answer_image]") }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.solved_question_time').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
                <div class="col-lg-6 col-sm-12">
                    {!! Form::text("data[".$index."][solved_question_time]",@$pastPaper->solved_question_time,['class' => 'form-control' ]) !!}
                    @if ($errors->has("data[".$index."][solved_question_time]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$index."][solved_question_time]") }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {{-- {!! Form::label(__('formname.question_topic').'*', null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!} --}}
                <div class="col-md-3"></div>
                <div class="col-lg-6 col-sm-12">
                    {!! Form::select("data[".$index."][topic][]",@$topicList,null,['id'=>'topic'.$index, 'class' => 'form-control selectpicker', 'multiple'=>true]) !!}
                    <span class='topic{{$index}}Error'></span>
                    @if ($errors->has("data[".$index."][topic]"))
                        <p style="color:red;">
                            {{ $errors->first("data[".$index."][topic]") }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row mb-4">
                <div class="col-md-3"></div>
                <div class="col-md-3 ml-2">
                    {{-- <a href="javascript:;" class="col-md-5 btn btn-primary addQuestionAnswer mr-3" role="button"><span class="fa fa-plus"></span> {{__('formname.add_question')}}</a> --}}
                    <a href="javascript:;" class="col-md-5 btn btn-danger removeQuestionAnswer" role="button"><span class="fa fa-trash"></span> {{__('formname.remove_question')}}</a>
                </div>
            </div>
        {{-- </div> --}}
    </div>
@endif