@php
$subject = subject();
@endphp
<li class="breadcrumb-item"><a href="{{route('practice')}}">{{__('frontend.home')}}</a></li>
<li class="breadcrumb-item"><a href="{{route('weekly-assessments',['slug'=>@$subject->slug,'studentId'=>Auth::guard('student')->user()->uuid])}}">{{__('frontend.practice_by_week')}}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{@$testAssessment->title}}</li>
<li class="breadcrumb-item"><a href="{{route('weekly-assessments',['slug'=>@$testAssessment->testAssessmentSubjectDetail[0]->subject->slug,'studentId'=>Auth::guard('student')->user()->uuid])}}">{{@$section->name}} </a></li>