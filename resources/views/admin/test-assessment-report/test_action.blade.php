<a href="{{$route}}" class="glyphicon glyphicon-list-alt" title="Detail">
    <i class="fa fa-eye">
    </i>
</a>
{{-- <a href="{{route('download-report',['uuid'=>@$studentTest->uuid])}}" class="glyphicon glyphicon-list-alt" title="Download Report">
    <i class="fa fa-download">
    </i>
</a>
<a href="javascript:void(0);" data-url="{{route('email-report',['uuid'=>@$studentTest->uuid])}}" class="glyphicon glyphicon-list-alt send-mail" title="Send Mail">
    <i class="flaticon-mail-1">
    </i>
</a> --}}
@php
    $ratio = 0;
    $attemptedCount =0;
    if(isset($studentTest->lastTestAssessmentResult->attemptTestQuestionAnswers)){
        $attemptedCount = @$studentTest->lastTestAssessmentResult->attempted;
        $totalQuestion = @$studentTest->lastTestAssessmentResult->questions;
        if($attemptedCount > 0 && $totalQuestion > 0){
            $ratio = ($attemptedCount * 100) / $totalQuestion;
        }
    }
@endphp
{{-- @if($ratio <= 50) --}}
    @if(isset($studentTest->lastTestAssessmentResult))
        <a href="javascript:;" data-url="{{route('reset-assessment-attempt',['uuid'=>@$studentTest->lastTestAssessmentResult->uuid])}}" class="glyphicon glyphicon-list-alt resetTest" title='reset'>
            <i class="fa fa-redo-alt">
            </i>
        </a>
    @endif
{{-- @endif --}}
