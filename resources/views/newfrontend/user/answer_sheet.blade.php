<div class="container mrgn_bt_40">
    <h2>Exam Type : Standard </h2>
    @forelse($mockTest->papers??[] as $paper)
    <div class="row border">
            <h3>Paper Name : {{@$paper->name}}</h3>
            @php
            $i=0;
            @endphp
            @forelse($paper->mockTestSubjectDetail as $sqkey => $section)
                <div class="row">
                    <h4> Section Name : {{@$section->name}}</h4>
                </div>
                <div class="row">
                    <h4> Question List</h4>
                </div>
                @php
                $questionData = $section->question??[];
                $questionlist = $section->questionList??[];
                @endphp
                <div class="row">
                    @forelse(@$questionlist as $key => $question)
                        <p><strong></strong> {!! @$question->instruction !!}</p>
                        <p><strong>Q.{{$question->question_no}}</strong> {!! @$question['question'] !!}</p>
                        @if($question->image != null)
                            <img style="max-width:800px !important;" src="{{@$question->image_path}}">
                        @endif
                        @if($question->questionData->question_type == 1)
                            @php
                                $alphabet = ord("A");
                            @endphp
                            @forelse($question->answers as $answer)
                                @if($answer->is_correct == 1)
                                    <p><strong>{{chr($alphabet)}}.{!! $answer->answer !!}</strong></p>
                                @else
                                    <p><strong>{{chr($alphabet)}}.</strong>{!! $answer->answer !!}</p>
                                @endif
                                @php $alphabet++; @endphp
                            @empty
                            @endforelse
                            <br>
                            <strong>Your Answer :</strong>
                                <br><hr>
                                <br><hr>
                        @else
                            {{-- @php
                                $correctAnswer = @$question->getSingleAnswer->answer;
                            @endphp
                            <p><strong>Answer.</strong>{!! $correctAnswer !!}</p> --}}
                            <br>
                            <strong>Your Answer :</strong>
                            <br><hr>
                            <br><hr>
                            <br><hr>
                            <br><hr>
                            <br><hr>
                        @endif
                    @empty
                        <p><strong>{{__('formname.question_not_found')}}</strong></p>
                    @endforelse
                </div>
            @empty
            @endforelse
    </div>
    @empty
    @endforelse
</div>
@php
exit;
@endphp