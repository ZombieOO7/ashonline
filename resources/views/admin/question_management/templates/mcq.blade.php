@php
    $questionsAnswerArr = isset($question) ? $question : [];
    // $limit = ($subject==2)?6:5;
    if($type == 4){
        $limit = 6;
    }elseif($subject==2){
        $limit = 6;
    }else{
        $limit = 5;
    }
@endphp
@if(@$subject !=3)
@endif
{{-- @if(@$type != 1) --}}
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-sm-12"></div>
        <div class="col-lg-6 col-md-9 col-sm-12">
            <a href="javascript:void(0);" class="btn btn-primary add-cloze add-more-btn">{{__('formname.add_more')}}</a>
        </div>
    </div>
    <input type="hidden" class="limitCheckBox" name="total_ans" value="{{ isset($question->total_ans) ? $question->total_ans : 0 }}">
    @php $questionsList = isset($question) ? $question : []; $key =1; @endphp
    @if($question != null)
    <div class="clone-cloze" id="text_{{$key}}">
            <input type="hidden" name="text[{{$key}}][uuid]" value="{{$question->uuid}}" data-flag="answer">
            @if(@$subject == 2)
                <div class="m-form__group form-group row">
                    <label for="" class='col-form-label col-lg-3 col-sm-12'>{{__('formname.choose_no_option')}}</label>
                    <div class="m-radio-inline">
                        <label class="m-radio">
                            <input type="radio" name="no_of_option[{{$key}}]" value="5" data-id='{{$key}}_option_5' {{(isset($question->answers)&&count($question->answers)==5)?'checked':''}}>5
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input type="radio" name="no_of_option[{{$key}}]" value="6" data-id='{{$key}}_option_5' data-checkbox='text[{{$key}}][5][is_correct]' data-answer="text[{{$key}}][5][answer]" {{(isset($question->answers)&&count($question->answers)==6)?'checked':''}}>6
                            <span></span>
                        </label>
                    </div>
                    <span class="m-form__help"></span>
                </div>
            @endif
            <div class="m-portlet  m-portlet--full-height">
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_instruction'), null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionInstructionLable'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[{{$key}}][instruction]" id='question_instruction_{{$key}}' class="form-control m-input questionInstruction qckeditor" rows="9">{{@$question->instruction}}</textarea>
                        @error('instruction') <p class="errors">{{$errors->first('instruction')}}</p> @enderror
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(($key==1)?__('formname.mock-test.questions').'*':__('formname.question_no',['no'=>$key]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[{{$key}}][question]" id="question_{{$key}}" class="form-control m-input question qckeditor" rows="9" required="true">{{@$question->question}}</textarea>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        <span class="inError"></span>
                    </div>
                </div>
                {{-- @if(@$type != 4) --}}
                    <div class="m-form__group form-group row @if(@$type == 4) d-none @endif">
                        <label for="" class='col-form-label col-lg-3 col-sm-12'>{{__('formname.answer_type')}}</label>
                        <div class="m-radio-inline">
                            <label class="m-radio">
                                <input type="radio" name="text[{{$key}}][answer_type]" value="1" class='answerType' data-index='{{$key}}' id="answer_type_{{$key}}" @if(@$question->answer_type == 1) checked @endif>{{__('formname.single_answer')}}
                                <span></span>
                            </label>
                            <label class="m-radio">
                                <input type="radio" name="text[{{$key}}][answer_type]" value="2" class='answerType' data-index='{{$key}}' id="answer_type_{{$key}}" @if(@$question->answer_type == 2 || @$question->type == 4) checked @endif>{{__('formname.multiple_answer')}}
                                <span></span>
                            </label>
                        </div>
                        <span class="m-form__help"></span>
                    </div>
                {{-- @endif --}}
                {{-- @if($subject == 1 || $subject == 3)
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::file('text['.$key.'][image]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_'.$key,'data-id'=>'q_image_preview_'.$key,'accept'=>'image/*')) !!}
                        {!! Form::hidden('text['.$key.'][image_file]',@$question->image) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        <div class="row row_img create-edit-preview">
                        <img id="q_image_preview_{{$key}}" src="{{@$question->image_path}}" alt="" height="200px;" width="200px;" style="display:{{isset($question->image_path)?'':'none'}};" />
                        </div>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
                </div>
                @endif --}}
                @php
                    $alphabet = ord("A");
                    $j = 1;
                @endphp
                @php $answers = isset($question->answers)?$question->answers:[]; @endphp
                @forelse (@$answers as $akey => $answer)
                    {!! Form::hidden('text['.$key.'][answer]['.$akey.'][answer_id]', @$answer->id, ['data-flag'=>'answer']) !!}
                    <div id='{{$key}}_option_{{$akey}}' class="form-group m-form__group row option_no_{{$akey}}">
                        {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            @php
                                $name = 'text['.$key.'][answer]['.$akey.'][answer]';
                                $ansName = 'text['.$key.'][answer]['.$akey.'][is_correct]';
                            @endphp
                            {!! Form::textarea($name,@$answer->answer,array('id'=>'question_'.$key.'_answer'.$akey, 'class'=>'form-control m-input option-answers ckeditor answer'.$key, 'maxlength'=>'50', 'data-option'=>($akey==5)?'false':'true' ,'data-selected-ans' => $key)) !!}
                            <span class="inError"></span>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="m-checkbox-list" id="answer_{{$key}}">
                                {{__('formname.correct_answer')}} :
                                <label class="m-checkbox closeCheckbox">
                                    <input name="{{$ansName}}" type="checkbox" class="correctAnswers qna{{$key}} correct{{$akey}}"  id="answer_{{$key}}" data-answerType='answer_type_{{$key}}' data-questionIndex='{{$key}}' {{($answer->is_correct == 1)?'checked':''}}>
                                    <span></span>
                                </label>
                            </div>
                            <span class="checkBoxError text-danger"></span>
                        </div>
    
                        <span class="error"></span>
                    </div>
                    @php  $alphabet++; $j++; @endphp
                @empty
                    @for($i=0; $i<$limit; $i++)
                        <div id='1_option_{{$i}}' class="form-group m-form__group row option_no_{{$i}}" style='display:{{($i==5 && $limit == 6)?'none':''}};'>
                            {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                            @php
                                $name = 'text['.$key.'][answer]['.$i.'][answer]';
                                $ansName = 'text['.$key.'][answer]['.$i.'][is_correct]';
                                if($i==5 && $limit == 6 && $type != 4){
                                    $name = '';
                                    $ansName = '';
                                }
                            @endphp
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                {!! Form::text($name,@$answer->answer,array('id'=>'question_'.$key.'_answer'.$i,'class'=>'form-control m-input option-answers answer{{$key}}', 'required' => ($i==5)?'':'required','maxlength'=>'50', 'data-option'=>($i==5)?'false':'true', 'data-selected-ans' => $key)) !!}
                                <span class="inError"></span>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="m-checkbox-list" id="answer_{{$key}}">
                                    {{__('formname.correct_answer')}} :
                                    <label class="m-checkbox closeCheckbox">
                                        <input name="{{$ansName}}" type="checkbox" class="correctAnswers qna{{$key}} correct{{$i}}"  id="answer_{{$key}}" data-answerType='answer_type_{{$key}}' data-questionIndex='{{$key}}'>
                                        <span></span>
                                    </label>
                                </div>
                                <span class="checkBoxError text-danger"></span>
                            </div>
                            <span class="error"></span>
                        </div>
                        @php  $alphabet++; $j++; @endphp
                    @endfor
                @endforelse
                @if(count($answers) < $limit)
                    <div id='{{$key}}_option_5' class="form-group m-form__group row option_no_5" style='display:none;'>
                        {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            {!! Form::text("",null,array('id'=>'question_'.$key.'_answer5','class'=>'form-control m-input option-answers ckeditor answer5', 'maxlength'=>'50', 'data-option'=>'true','maxlength'=>'50','data-selected-ans' => $key)) !!}
                            <span class="inError"></span>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="m-checkbox-list" id="answer_{{$key}}">
                                {{__('formname.correct_answer')}} :
                                <label class="m-checkbox closeCheckbox">
                                    <input name="" type="checkbox" class="correctAnswers qna{{$key}} correct5"  id="answer_{{$key}}" data-answerType='answer_type_{{$key}}' data-questionIndex='{{$key}}'>
                                    <span></span>
                                </label>
                            </div>
                            <span class="checkBoxError text-danger"></span>
                        </div>
                        <span class="error"></span>
                    </div>
                @endif

                <div class="form-group m-form__group row" >
                    {!! Form::label(__('formname.question_mark').'*', null,array('class'=>'question_mark col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[".$key."][marks]",@$question->marks,array('class'=>'form-control m-input', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => $key)) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row" >
                    {!! Form::label(__('formname.explanation'), null,array('class'=>'explanation col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[{{$key}}][explanation]" id="explanation{{$key}}" class="form-control m-input explanationEditor" rows="6">{!! @$questionsAnswer->explanation !!}</textarea>
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.image_full'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                        {!! Form::file('text['.$key.'][file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_0','data-id'=>'q_image_preview_0','accept'=>'image/*')) !!}
                        {!! Form::hidden('text['.$key.'][image_file]',@$question->image) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
                </div>
                <div class="resizeImgEditors">
                    @if(@$question->image != null || @$question->resize_full_image != null)
                    <div class="form-group m-form__group row col-md-12">
                        <label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
                        <div class="col-lg-6 col-md-9 col-sm-12">
                                @if(@$question->resize_full_image != null)
                                    <textarea name="text[{{$key}}][resize_full_image]" id="p_full_img_path" class="imgCkeditor" cols="30" rows="10">
                                        {!! @$question->resize_full_image !!}
                                    </textarea>
                                @else
                                    <textarea name="text[{{$key}}][resize_full_image]" id="p_full_img_path" class="imgCkeditor" cols="30" rows="10">
                                        <img src="{{ @$question->image_path }}" class="img-fluid mb-3" style="display:{{isset($question->image_path) && @$question->image != null ?'':'none'}};">
                                    </textarea>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                    <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.question_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                        <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                            {!! Form::file('text['.$key.'][question_file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_1','data-id'=>'q_image_preview_1','accept'=>'image/*')) !!}
                            {!! Form::hidden('text['.$key.'][image_file]',null) !!}
                            {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                            @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        </div>
                    </div>
                <div class="resizeImgEditors">
                    @if(@$question->question_image != null)
                        <div class="form-group m-form__group row col-md-12">
                            <label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                @if(@$question->resize_question_image != null)
                                    <textarea name="text[{{$key}}][resize_question_image]" id="p_que_img_path" class="imgCkeditor" cols="30" rows="10">
                                        {!! @$question->resize_question_image !!}
                                    </textarea>
                                @else
                                    <textarea name="text[{{$key}}][resize_question_image]" id="p_que_img_path" class="imgCkeditor" cols="30" rows="10">
                                        <img src="{{ @$question->question_image_path }}" class="img-fluid mb-3" style="display:{{isset($question->question_image_path) && $question->question_image != null ?'':'none'}};">
                                    </textarea>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                    <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.answer_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                        <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                            {!! Form::file('text['.$key.'][answer_file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_2','data-id'=>'q_image_preview_2','accept'=>'image/*')) !!}
                            {!! Form::hidden('text['.$key.'][image_file]',null) !!}
                            {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                            @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        </div>
                    </div>
                <div class="resizeImgEditors">
                    @if(@$question->answer_image != null)
                        <div class="form-group m-form__group row col-md-12">
                            <label for="" class="'col-form-label col-lg-3 col-sm-12'"></label>
                            <div class="col-lg-6 col-md-9 col-sm-12">
                                @if(@$question->resize_answer_image != null)
                                    <textarea name="text[{{$key}}][resize_answer_image]" id="p_ans_img_path" class="imgCkeditor" cols="30" rows="10">
                                        {!! @$question->resize_answer_image !!}
                                    </textarea>
                                @else
                                    <textarea name="text[{{$key}}][resize_answer_image]" id="p_ans_img_path" class="imgCkeditor" cols="30" rows="10">
                                        <img src="{{ @$question->answer_image_path }}" class="img-fluid mb-3" style="display:{{isset($question->answer_image_path) && $question->answer_image != null ?'':'none'}};">
                                    </textarea>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-6 col-md-9 col-sm-12 remove-style" style="display:{{($key == 1)?'none':'block'}};">
                        <div class=' col-lg-3 col-sm-12'></div>
                        <center>
                        <a href="javascript:void(0);" class="btn btn-danger remove-btn remove-cloze edit-remove-cloze" id="remove_{{$key}}" data-remove="{{$key}}" data-j-remove="{{$key}}" data-question-id="{{ $question->uuid }}" data-url="{{ route('question.edit-cloze') }}">{{__('formname.remove')}}</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="clone-cloze" id="text_1">
            @if(@$subject == 2)
                <div class="m-form__group form-group row">
                    <label for="" class='col-form-label col-lg-3 col-sm-12'>{{__('formname.choose_no_option')}}</label>
                    <div class="m-radio-inline">
                        <label class="m-radio">
                            <input type="radio" name="no_of_option[1]" value="5" data-id='1_option_5' checked>5
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input type="radio" name="no_of_option[1]" value="6" data-id='1_option_5' data-checkbox='text[1][5][is_correct]' data-answer="text[1][5][answer]">6
                            <span></span>
                        </label>
                    </div>
                    <span class="m-form__help"></span>
                </div>
            @endif
            <div class="form-group m-form__group row">
                {!! Form::label(__('formname.question_instruction'), null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionInstructionLable'))!!}
                <div class="col-lg-6 col-md-9 col-sm-12">
                    <textarea name="text[1][instruction]" id='question_instruction_1' class="form-control m-input questionInstruction qckeditor" rows="9">{{@$question->instruction}}</textarea>
                    @error('instruction') <p class="errors">{{$errors->first('instruction')}}</p> @enderror
                    <span class="inError"></span>
                </div>
            </div>
            <div class="m-portlet  m-portlet--full-height">
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.mock-test.questions').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[1][question]" id="question_1" class="form-control m-input question qckeditor" rows="9" required="true"></textarea>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        <span class="inError"></span>
                    </div>
                </div>
                {{-- @if(@$type != 4) --}}
                    <div class="m-form__group form-group row @if(@$type == 4) d-none @endif">
                        <label for="" class='col-form-label col-lg-3 col-sm-12'>{{__('formname.answer_type')}}</label>
                        <div class="m-radio-inline">
                            <label class="m-radio">
                                <input type="radio" name="text[1][answer_type]" value="1" class='answerType' data-index='0' id="answer_type_0" @if(@$question->answer_type == 1 || $question == null) checked @endif>{{__('formname.single_answer')}}
                                <span></span>
                            </label>
                            <label class="m-radio">
                                <input type="radio" name="text[1][answer_type]" value="2" class='answerType' data-index='0' id="answer_type_0" @if(@$question->answer_type == 2 || @$type == 4) checked @endif>{{__('formname.multiple_answer')}}
                                <span></span>
                            </label>
                        </div>
                        <span class="m-form__help"></span>
                    </div>
                {{-- @endif --}}
                {{-- @if($subject == 1 || $subject == 3)
                    <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            {!! Form::file('text[1][image]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_1','data-id'=>'q_image_preview_1','accept'=>'image/*')) !!}
                            {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                            <div class="row row_img create-edit-preview">
                                <img id="q_image_preview_1" src="" alt="" height="200px;" width="200px;" style="display:none;" />
                            </div>
                            @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        </div>
                    </div>
                @endif --}}
                @php
                    $alphabet = ord("A");
                    $j = 1;
                @endphp
                @for($i=0; $i<$limit; $i++)
                    <div id='1_option_{{$i}}' class="form-group m-form__group row option_no_{{$i}}" style='display:{{($i==5 && $limit == 6 && $type !=4)?'none':''}};'>
                        {!! Form::label(__('formname.option',['char'=>chr($alphabet)]).'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            {!! Form::textarea("text[1][answer][".$i."][answer]",null,array('id'=>'question_1_answer'.$i,'class'=>'form-control m-input option-answers ckeditor answer1', 'required' => ($i==5)?'':'required','maxlength'=>'50', 'data-option'=>($i==5)?'false':'true', 'data-selected-ans' => 1)) !!}
                            <span class="inError"></span>
                        </div>
                        <div class="col-lg-3 col-sm-12">
                            <div class="m-checkbox-list" id="answer_1">
                                {{__('formname.correct_answer')}} :
                                <label class="m-checkbox closeCheckbox">
                                    <input name="text[1][answer][{{$i}}][is_correct]" type="checkbox" class="correctAnswers qna1 correct{{$j}}"  id="answer_1" data-answerType='answer_type_1' data-questionIndex='1'>
                                    <span></span>
                                </label>
                            </div>
                            <span class="checkBoxError text-danger"></span>
                        </div>
                    </div>
                    @php
                        $alphabet++;
                        $j++;
                    @endphp
                @endfor
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_mark').'*',null,array('class'=>'question_mark col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[1][marks]",null,array('class'=>'form-control m-input', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => 1)) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.explanation'),null,array('class'=>'explanation col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[1][explanation]" id="explanation1" class="form-control m-input explanationEditor" rows="6"></textarea>
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.image_full'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                        {!! Form::file('text[1][file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_0','data-id'=>'q_image_preview_0','accept'=>'image/*')) !!}
                        {!! Form::hidden('text[1][image_file]',@$question->image) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                        {!! Form::file('text[1][question_file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_1','data-id'=>'q_image_preview_1','accept'=>'image/*')) !!}
                        {!! Form::hidden('text[1][image_file]',null) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.answer_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                        {!! Form::file('text[1][answer_file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_2','data-id'=>'q_image_preview_2','accept'=>'image/*')) !!}
                        {!! Form::hidden('text[1][image_file]',null) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-lg-6 col-md-9 col-sm-12 remove-style" style="display:none;">
                        <div class=' col-lg-3 col-sm-12'></div>
                        <center>
                            <a href="javascript:void(0);" class="btn btn-danger remove-btn remove-cloze edit-remove-cloze" id="remove_1" data-remove="1" data-j-remove="1">{{__('formname.remove')}}</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    @endif
<div class="cloned_html">
</div>
