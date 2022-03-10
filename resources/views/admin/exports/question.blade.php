<table>
    <thead>
    <tr>
        <th>{{__('formname.question.subject_id')}}</th>
        <th>{{__('formname.q_no')}}</th>
        <th>{{__('formname.question_instruction')}}</th>
        <th>{{__('formname.question.question_title')}}</th>
        <th>Answer A</th>
        <th>Answer B</th>
        <th>Answer C</th>
        <th>Answer D</th>
        <th>Answer E</th>
        <th>Answer F</th>
        <th>Answer Type</th>
        <th>Correct Answer</th>
        <th>Exam Style</th>
        <th>Question Type</th>
        <th>Total Answer</th>
        <th>Points</th>
        <th>Topics</th>
    </tr>
    </thead>
    <tbody>
    @forelse($questions as $question)
        <tr>
            <td>{{ @$question->subject->title }}</td>
            <td>{{ @$question->question_no}}</td>
            <td>{{ @$question->instruction }}</td>
            <td>{{ @$question->question }}</td>
            @php
                $correctAns = [];
                $alphabet = ord("A");
                $count = 0;
            @endphp
            @for($i=0; $i <= 5; $i++)
                @php
                    $answer = @$question->answers[$i];
                    if(@$answer->is_correct == '1'){
                        $correctAns[$i] = chr($alphabet);
                    }
                    $count++;
                    $alphabet++;
                @endphp
                <td> {{@$answer->answer}} </td>
            @endfor
            <td>{{@$question->answer_type == 1 ? 'Single' : 'Multiple'}}</td>
            <td>
                {{ implode(',',@$correctAns) }}
            </td>
            <td>{{@config('constant.questionSubType')[@$question->question_type]}}</td>
            <td>{{@config('constant.question_type')[@$question->type]}}</td>
            <td>{{@$count}}</td>
            <td>{{@$question->marks}}</td>
            <td>{{@$question->topic->title}}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
@php
// exit;
@endphp
