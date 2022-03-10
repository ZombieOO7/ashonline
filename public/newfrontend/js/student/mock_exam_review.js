$(document).ready(function() {

    $(document).on('click','.cmplt_btn2',function(){  
      $(document).find('.mck-tst-img').attr('src',$(this).attr('data-mock-test-image'));
      $(document).find('.mck-tst-title').html($(this).attr('data-mock-test-title'));
      $(document).find('.mck-tst-img-url').attr('href',$(this).attr('data-url'));
      $(document).find('.mck-tst-title-url').attr('href',$(this).attr('data-url'));
    });

    // Save mock details
    $(document).on('click','.cmplt_mck',function(){
        var time_taken = $(document).find("input[name='time_taken']").val();
        var mockTestId = $(this).data('mock-test-id');
        var ipAddress = $(document).find('.ip_cls').text();
        var redirectUrl = $(this).attr('data-url');
        var current_question_id = $(this).data('current_question_id');
        var answerIds = [];
        $("input[name='asnwer']:checked").each(function(k,v){
            answerIds.push(this.value); 
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:ajaxSaveStudentTestUrl,
            data:{
                mock_test_id : mockTestId,
                ip_address : ipAddress,
                student_test_id:studentTestId,
                student_test_result_id:studentTestResultId,
                current_question_id: current_question_id,
                answer_ids: JSON.stringify(answerIds),
                mark_as_review:1,
                time_taken: time_taken,
                paper_id:paperId,
                section_taken_time:section_taken_time,
            },
            type:'POST',
            global:true,
            success:function(result) {
                if(result.success == true){
                    window.location.href=redirectUrl;
                }
            },
            error:function() {
            }
        });
    });
    
    //Prev/Next
    $(document).on('click','.nxt_qus',function(){
        $(".main_loader").css("display", "block");
        var nextQuestionId = $(this).data('next-question-id');
        var mockTestId = $(this).data('mock-test-id');
        var prevQuestionId = $(this).data('prev-question-id');
        var btnType = $(this).data('type');
        var subjectId = $(this).data('subject-id');
        var questionNo = $(document).find('.qus-no').text();
        var current_question_id = $(this).data('current_question_id');
        var answerIds = [];
        $("input[name='asnwer']:checked").each(function(k,v){
            answerIds.push(this.value); 
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:ajaxReviewNextQuestionUrl,
            data:{
                next_question_id : nextQuestionId,
                mock_test_id : mockTestId,
                prev_question_id : prevQuestionId,
                type : btnType,
                subject_id : subjectId,
                student_test_id:studentTestId,
                student_test_result_id:studentTestResultId,
                question_number : questionNo,
                current_question_id: current_question_id,
                answer_ids: JSON.stringify(answerIds),
                mark_as_review: 1,

            },
            type:'POST',
            global:true,
            success:function(result) {
                $(".main_loader").css("display", "none");
                $(document).find('#examData').html(result.testDetail);
                $(document).find('.sectionName').text(result.sectionName);
                var height = $(document).find('#examData').find('.in_qstn_box').height();
                $(document).find('#examData').find('.question_list_scn').css('height',height+'px');
            },
            error:function() {
            }
        });
    });
});