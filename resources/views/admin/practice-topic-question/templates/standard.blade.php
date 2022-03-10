{{-- <div class="form-group m-form__group row">
    {!! Form::label(__('formname.question.passage'), null,['class'=>'col-form-label col-lg-3 col-sm-12']) !!}
    <div class="col-lg-6 col-md-9 col-sm-12">
        <div class="position-relative custom-file">
            {!! Form::file('question_image[]',['class'=>'custom-file-input','id'=> 'question_image','accept'=>'application/pdf']) !!}
            {!! Form::label('Choose file',null,['class'=>'custom-file-label', 'for'=>'question_image']) !!}<br>
            <span><br></span>
            @php $questionIamges = isset($question->questionImages) ? $question->questionImages : null; @endphp
            @php $questionPdf = isset($question->questionPdfs) ? $question->questionPdfs : null; @endphp
            <div class="row row_img create-edit-preview" id="image_preview">
                @if(isset($questionIamges->question_image))
                    <div class='col-6 mt-5'>
                        <img src="{{ @$questionIamges->question_image }}" class='img-fluid'>
                    </div>
                @endif
                @if(isset($questionPdf))
                    <div class='row col-5' id="q_pdf_preview_1">
                        <img src="{{ asset('images/pdf.jpeg') }}" alt="">
                    </div>
                    <div class="col-2 mt-5">
                        <a href="{{route('dowload.passage',['uuid'=>@$questionPdf->uuid])}}" class="download_pdf">
                            <i class="la la-download"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> --}}
<div class="form-group m-form__group row">
    {!! Form::label(trans(''), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
    <div class="col-lg-6 col-md-9 col-sm-12">
        <a href="javascript:void(0);" class="btn btn-primary add-cloze add-more-btn">{{__('formname.add_more')}}</a>
    </div>
</div>
@php $questionsAnswerArr = isset($question->questionsList) ? $question->questionsList : []; @endphp
@if(@$question->mcqQuestion)
    @forelse ($questionsAnswerArr as $key =>  $questionsAnswer)
        @php
            $key = $key + 1;
        @endphp
        <div class="clone-cloze" id="text_{{ $key }}">
            <div class="m-portlet  m-portlet--full-height">
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_no',['no'=>@$key]).' *', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[{{ $key }}][question]" id="question_{{ $key }}" class="form-control m-input question qckeditor" rows="9" required>{{ @$questionsAnswer->question }} </textarea>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        <span class="inError"></span>
                    </div>
                </div>
                {{-- @if($subject == 1) --}}
                    {{-- <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.test_papers.qa_pdf'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            {!! Form::file('text['.$key.'][image]',array('class'=>'form-control questionImg','multiple'=> 'false','id'=> 'text_question_image_'.$key,'data-id'=>'q_image_preview_'.$key,'accept'=>'image/*')) !!}
                            <div class="row row_img create-edit-preview">
                                @if($questionsAnswer->image_path!= null)
                                    @if(pathinfo($questionsAnswer->image_path)['extension'] != 'pdf')
                                        <div class='col-6 mt-5'>
                                            <img src="{{ @$questionsAnswer->image_path }}" class='img-fluid' id="q_image_preview_{{$key}}">
                                        </div>
                                    @else
                                        <div class='row col-5' id="q_pdf_preview_{{$key}}">
                                            <img src="{{ asset('images/pdf.jpeg') }}" alt="">
                                        </div>
                                        <div class="col-1 mt-5">
                                            <a href="{{ @$questionsAnswer->image_path }}" target='_blank' class="download_pdf">
                                                <i class="la la-download"></i>
                                            </a>
                                        </div>
                                    @endif
                                    {!! Form::hidden('text['.$key.'][image_file]',@$questionsAnswer->image) !!}
                                @endif
                            </div>
                            <span class="inError"></span>
                            @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        </div>
                    </div> --}}
                {{-- @endif --}}
                <input type="hidden" class="uuid" name="text[{{ $key }}][uuid]" value="{{ $questionsAnswer->uuid }}">
                @php $questionAnsList = isset($questionsAnswer->answers) ? $questionsAnswer->answers : [];  @endphp
                @forelse($questionAnsList as $key1 =>  $questionsAnswerList)
                    <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.answer').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            {!! Form::textarea("text[".$key."][".$key1."][answer]",@$questionsAnswerList->answer,array('id'=>'question_'.$key.'_answer'.$key1,'class'=> "form-control m-input option-answers ckeditor correct1" , 'required' =>  'required' ,'data-selected-ans' => $key1)) !!}
                            <span class="inError"></span>
                        </div>
                        <input type="hidden" class="id" name="text[{{ $key }}][{{ $key1 }}][id]" value="{{ $questionsAnswerList->id }}">
                        <div class="col-lg-3">
                            <div class="m-checkbox-list">
                                <input name="text[{{ $key }}][{{ $key1 }}][is_correct]" value="on" @if($questionsAnswerList->is_correct == 1) checked @endif type="hidden" class="correctAnswers correct1"  id="answer_{{ $key1 }}" >
                                <span></span>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_mark').'*', null,array('class'=>'question_mark col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[".$key."][marks]",@$questionsAnswer->marks,array('class'=>'form-control m-input', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => 1)) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question.hint'),null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[".$key."][hint]",@$questionsAnswer->hint,array('class'=>'form-control m-input','maxlength'=>'150')) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.explanation'),null,array('class'=>'explanation col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[".$key."][explanation]",@$questionsAnswer->explanation,array('class'=>'form-control m-input explanationEditor', 'id'=>'explanation'.$key)) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.image_full'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                        {!! Form::file('text['.$key.'][file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_0','data-id'=>'q_image_preview_0','accept'=>'image/*')) !!}
                        {!! Form::hidden('text[1][image_file]',@$question->image) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
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
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.answer_image'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                    <div class="col-lg-5 col-md-9 col-sm-12 ml-3 mr-3">
                        {!! Form::file('text['.$key.'][answer_file]',array('class'=>'custom-file-input questionImg','multiple'=> 'false','id'=> 'text_question_image_2','data-id'=>'q_image_preview_2','accept'=>'image/*')) !!}
                        {!! Form::hidden('text['.$key.'][image_file]',null) !!}
                        {!! Form::label(__('formname.choose_file'),null,array('class'=>'custom-file-label')) !!}<br>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                    </div>
                </div>
                <div class="form-group m-form__group row remove-style" style="display:@if($key==1) none; @else block; @endif">
                    <div class="col-lg-6 col-md-9 col-sm-12" >
                        {!! Form::label('', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                        <center>
                        <a href="javascript:void(0);" class="btn btn-danger remove-btn remove-cloze edit-remove-cloze"  id="remove_{{ $key }}" data-remove="{{ $key }}" data-question-id="{{ $questionsAnswer->uuid }}" data-url="{{ route('question.edit-cloze') }}">{{__('formname.remove')}}</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="clone-cloze" id="text_1">
            <div class="m-portlet  m-portlet--full-height">
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_no',['no'=>1]) .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        <textarea name="text[1][question]" id="question_1" class="form-control m-input question" rows="9" required>{{ @$question->question }} </textarea>
                        @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        <span class="inError"></span>
                    </div>
                </div>
                {{-- @if($subject == 1) --}}
                    <div class="form-group m-form__group row">
                        {!! Form::label(__('formname.test_papers.qa_pdf'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
                        <div class="col-lg-6 col-md-9 col-sm-12">
                            {!! Form::file('text[1][image]',array('class'=>'form-control questionImg','multiple'=> 'false','id'=> 'text_question_image_1','data-id'=>'q_image_preview_1','accept'=>'image/*')) !!}
                            <div class="row row_img create-edit-preview">
                                <img id="q_image_preview_1" src="" alt="" height="200px;" width="200px;" style="display:none;" />
                            </div>
                            @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
                        </div>
                    </div>
                {{-- @endif --}}
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.answer') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::textarea("text[1][0][answer]",Null,array('class'=>'form-control m-input option-answers answer1', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => 1)) !!}
                        <span class="inError"></span>
                    </div>
                    <div class="m-checkbox-list" id="answer_1">
                        <input name="text[1][0][is_correct]" type="hidden" class="correctAnswers correct1" value="on" id="answer_1">
                        <span></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question_mark').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[1][marks]",null,array('class'=>'question_mark form-control m-input', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => 1)) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.question.hint'),null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[1[hint]",null,array('class'=>'form-control m-input','maxlength'=>'150')) !!}
                        <span class="inError"></span>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label(__('formname.explanation'),null,array('class'=>'explanation col-form-label col-lg-3 col-sm-12'))!!}
                    <div class="col-lg-6 col-md-9 col-sm-12">
                        {!! Form::text("text[1][explanation]",null,array('class'=>'form-control m-input explanationEditor', 'id'=>'explanation1')) !!}
                        <span class="inError"></span>
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
    @endforelse
@else
<div class="clone-cloze" id="text_1">
    <div class="m-portlet  m-portlet--full-height">
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.question_no',['no'=>1]) .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12 questionlable'))!!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                <textarea name="text[1][question]" id="question_1" class="form-control m-input question qckeditor" rows="9" required>{{ @$question->question }} </textarea>
                <span class="inError"></span>
                @error('question') <p class="errors">{{$errors->first('question')}}</p> @enderror
            </div>
        </div>
        {{-- <div class="form-group m-form__group row">
            {!! Form::label(__('formname.test_papers.qa_pdf'), null,array('class'=>'col-form-label col-lg-3 col-sm-12')) !!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::file('text[1][image]',array('class'=>'form-control','multiple'=> 'false','id'=> 'text_question_image_1','data-id'=>'q_image_preview_1','accept'=>'image/*')) !!}
                <div class="row row_img create-edit-preview">
                <img id="q_image_preview_1" src="" alt="" height="200px;" width="200px;" style="display:none;" />
                </div>
            </div>
        </div> --}}
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.answer') .'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::textarea("text[1][0][answer]",Null,array('id'=> 'question_0_answer0','class'=>'form-control m-input option-answers answer1 ckeditor', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => 1)) !!}
                <span class="inError"></span>
            </div>
            <div class="m-checkbox-list" id="answer_1">
                <input name="text[1][0][is_correct]" type="hidden" class="correctAnswers correct1" value="on" id="answer_1">
                <span></span>
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.question_mark').'*', null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::text("text[1][marks]",null,array('class'=>'question_mark form-control m-input', 'required' =>  'required','maxlength'=>'50', 'data-selected-ans' => 1)) !!}
                <span class="inError"></span>
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.question.hint'),null,array('class'=>'col-form-label col-lg-3 col-sm-12'))!!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::text("text[1][hint]",null,array('class'=>'form-control m-input','maxlength'=>'150')) !!}
                <span class="inError"></span>
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!! Form::label(__('formname.explanation'),null,array('class'=>'explanation col-form-label col-lg-3 col-sm-12'))!!}
            <div class="col-lg-6 col-md-9 col-sm-12">
                {!! Form::text("text[1][explanation]",null,array('class'=>'form-control m-input explanationEditor', 'id'=>'explanation1')) !!}
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