<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body, html{
            margin: 0 auto;
            padding: 0;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }
        table{
            border-collapse:collapse;
            border-spacing: 0;
            font-size: 13px;
            color: #212121;
        }
        .page-break {
            page-break-after:always !important;
        }
        td{line-height: 20px;}
        th, td {vertical-align: top;text-align: left;}
    </style>
</head>
@php
    $txt = '<br/><br/><br/>'; 
@endphp
<body style="background-color: #ffffff; font-family: 'Poppins', sans-serif; font-size: 14px; color: #757575; margin: 0 auto;padding: 0; width: 100%;">
<table style="width: 100%" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    {{--first-table--}}
    <tr>
        @php
        echo nl2br($txt);
        echo nl2br($txt);
        @endphp
        <td>
            <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">{{__('formname.student.student_no')}}</th>
                        {{-- <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Name</th> --}}
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Attempt</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Exam Name</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Exam ID</th>
                        <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$student->student_no}}</td>
                        {{-- <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$student->full_name}}</td> --}}
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{$resetAttempt}}</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$mockTest->title}}</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$mockTest->id}}</td>
                        <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTest->created_at_user_readable}}</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    {{--space-table--}}
    <tr><td height="20px"></td></tr>

    {{--second table--}}
    <tr>
        <td>
            @php
                echo nl2br($txt);
                echo nl2br($txt);
            @endphp
            <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                <thead>
                <tr>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Questions</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Attempted</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Correctly Answered</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Unanswered</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Marks</th>
                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Overall Result</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTestResults->questions}}</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTestResults->attempted ?? 0}}</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTestResults->correctly_answered ?? 0}}</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTestResults->unanswered ?? 0}}</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #2296f3 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTestResults->obtained_marks ?? 0}} out of {{@$studentTestResults->total_marks ?? 0}}</td>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #2296f3 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$studentTestResults->overall_result_text ?? 0}}%</td>
                </tr>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 15px !important;color: #000 !important;text-align: left !important;vertical-align: middle;">
                        <img src="{{base_path()}}/public/images/mlt_str.png" alt="" style="vertical-align: middle;padding-right: 15px">
                        Your Ranking
                    </td>
                    <td colspan="5" style="font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 15px !important;color: #000 !important;text-align: left !important;vertical-align: middle;">{{@$studentTestResults->rank}} out of {{@$totalStudentAttemptTest}}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    {{--space-table--}}
    <tr><td height="30px"></td></tr>

    {{--Answer analysis--}}
    <tr>
        <td>
            @php
                echo nl2br($txt);
                echo nl2br($txt);
                echo nl2br($txt);
            @endphp
            <table style="width: 90%;background-color: #ffffff;max-width: 90%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 700 !important;font-size: 16px !important;color: #000 !important;text-align: left !important;">Question Analysis</td>
                </tr>
                <tr><td height="15px"></td></tr>
                <tr>
                    <td style="font-family: 'Poppins', sans-serif !important;font-weight: 400 !important;font-size: 14px !important;color: #949494 !important;text-align: left !important;">
                        Want to check the answers for the questions you didn't attempt and the wrong answered ones?
                    </td>
                </tr>
                <tr><td height="25px"></td></tr>
                <tr>
                    <td>
                        <div class="page-break"></div>
                        @php
                            echo nl2br($txt);
                        @endphp
                        <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Q No.</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Questions</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Topic</th>
                                @if(@$mockTest->stage_id == 1)
                                    <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Your Answer</th>
                                @endif
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Correct Answer</th>
                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Result</th>
                            </tr>
                            </thead>
                            <tbody style="width: 100%;height:100% !important;">
                            @if($studentTest->studentTestResult)
                                @php $count = 1; @endphp
                                @forelse(@$studentTestQuestionAnswers as $key => $studentTestQuestionAnswer)
                                    @php
                                        $correctImage = 'wrng_ic.png';
                                        //if(isset($studentTestQuestionAnswer->answer)){
                                            //$answer = \App\Models\Answer::whereQuestionListId($studentTestQuestionAnswer->answer->question_list_id)->whereIsCorrect('1')->first();
                                            if($studentTestQuestionAnswer->is_correct == 1){
                                                $correctImage = 'ys_ic.png';
                                            }
                                        //}
                                    @endphp
                                        <tr>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{$count}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{Str::limit(@$studentTestQuestionAnswer->questionList->question, 100)}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{Str::limit(@$studentTestQuestionAnswer->question->topic->title,30)}}</td>
                                            @if($mockTest->stage_id == 1)
                                                <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{isset($studentTestQuestionAnswer->answer->answer)?Str::limit(@$studentTestQuestionAnswer->answer->answer,30):null}}</td>
                                            @endif
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{Str::limit(@$studentTestQuestionAnswer->questionList->correctAnswer->answer,30)}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;"><img src="{{base_path()}}/public/images/{{@$correctImage}}"></td>
                                        </tr>
                                     @php $count++; @endphp
                                     @if($loop->iteration == 6)
                                        </tbody>
                                        </table>
                                        <div class="page-break"></div>
                                        @php
                                            echo nl2br($txt);
                                        @endphp
                                        <table style="width: 100%;background-color: #ffffff; border: 1px solid #e0e0e0; max-width: 100%" align="left" border="0" cellpadding="10" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Q No.</th>
                                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Questions</th>
                                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Topic</th>
                                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Your Answer</th>
                                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Correct Answer</th>
                                                <th style="background-color: #1a237e !important;font-family: 'Poppins', sans-serif !important;font-weight: 600 !important;font-size: 13px !important;color: #ffffff !important;text-align: left !important;">Result</th>
                                            </tr>
                                            </thead>
                                            <tbody style="width: 100%;height:100% !important;">
                                    @endif
                                @empty
                                @endforelse
                                @if(count($studentTestQuestionAnswers) == 0)
                                    @forelse (@$questionList as $question)
                                        <tr>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{$count}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$question->question}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$question->questionData->topic->title}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;"></td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;">{{@$question->correctAnswer->answer}}</td>
                                            <td style="font-family: 'Poppins', sans-serif !important;font-weight: 500 !important;font-size: 13px !important;color: #000 !important;text-align: left !important;border: 1px solid #e0e0e0;"><img src="{{base_path()}}/public/images/wrng_ic.png"></td>
                                        </tr>
                                        @php $count++; @endphp
                                   @empty
                                    @endforelse
                                @endif
                            @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
 </tbody>
</table>
</body>
</html>
