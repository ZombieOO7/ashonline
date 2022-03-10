/*profile-upload*/
$(document).ready(function () {
    var markAsReview = false;
    //Prev/Next
    $(document).on('click', '.nxt_qus', function () {
        if(ajaxNextQuestionUrl == null){
            return;
        }
        $(".main_loader").css("display", "block");
        var nextQuestionId = $(this).data('next-question-id');
        var mockTestId = $(this).data('mock-test-id');
        var prevQuestionId = $(this).data('prev-question-id');
        var btnType = $(this).data('type');
        var current_question_id = $(this).data('current_question_id');
        var answerIds = [];
        $("input[name='asnwer']:checked").each(function(k,v){
            answerIds.push(this.value); 
        })
        var answer = $("input[name='asnwer']:checked").val();
        var mark_as_review = 0;
        if ($("input[name='mark_for_review']").prop("checked") == true) {
            var mark_as_review = 1;
        }
        // var mark_as_review = $("input[name='mark_for_review']").val();
        var subjectId = $(this).data('subject_id');
        var questionNo = $(document).find('.qus-no').text();
        var time_taken = $("input[name='time_taken']").val();
        var nextSectionId = $(this).data('next_section_id');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: ajaxNextQuestionUrl,
            global: true,
            data: {
                next_question_id: nextQuestionId,
                mock_test_id: mockTestId,
                prev_question_id: prevQuestionId,
                type: btnType,
                current_question_id: current_question_id,
                answer: JSON.stringify(answerIds),
                subject_id: subjectId,
                question_number: questionNo,
                mark_as_review: mark_as_review,
                time_taken: time_taken,
                student_test_id: studentTestId,
                student_test_result_id: studentTestResultId,
                next_subject_id:nextSubjectId,
                section_id : sectionId,
                next_section_id: nextSectionId,
                paper_id:paperId,
            },
            type: 'POST',
            success: function (result) {
                $(document).find('#examData').html(result.testDetail);
                // var height = $(document).find('#examData').find('.in_qstn_box').height();
                // $(document).find('#examData').find('.question_list_scn').css('height',height+'px');
                $(document).find('.is_attmpt-cls').html(result.attemptedCount);
                initializePdf();
                if(result.nextQuestionId==null || result.nextQuestionId == ''){
                    $(document).find('.lastQuestionLabel').show();
                }else{
                    $(document).find('.lastQuestionLabel').hide();
                }
                if(current_subject_id != result.subject_id && btnType == 'next'){
                    current_subject_id = result.subject_id;
                    jQuery.unique(subjectIds);
                    console.log(subjectIds);
                }
                if(result.mark_as_review == "1"){
                    $(document).find('#agreeCheck').prop("checked",true);
                }else{
                    $(document).find('#agreeCheck').prop("checked",false);
                }
                $(".main_loader").css("display", "none");
                setTimeout(function () {
                    timeTakenCount = 0;
                }, 100);
                // if(parseInt(result.review_count) > 0 || $(document).find('#agreeCheck').prop("checked") == true){
                //     $(document).find('.section_review_btn').show();
                // }else{
                //     $(document).find('.section_review_btn').hide();
                // }
            },
            error: function () {
            }
        });
    });

    $(document).on('click', '.cmplt_btn', function () {
        $(".main_loader").css("display", "block");
        var current_question_id = $(this).data('current_question_id');
        var mockTestId = $(this).data('mock-test-id');
        // var subjectId = $(this).data('subject_id');
        var time_taken = $("input[name='time_taken']").val();
        // var mark_as_review = $("input[name='mark_for_review']").val();
        var mark_as_review = 0;
        if ($("input[name='mark_for_review']").prop("checked") == true) {
            mark_as_review = 1;
        }
        if ($("input[name='mark_for_review']").attr('type') == 'hidden'){
            mark_as_review = 1;
        }
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
            url: saveQuestionAnsURL,
            data: {
                current_question_id: current_question_id,
                mock_test_id: mockTestId,
                answer_ids: JSON.stringify(answerIds),
                // subject_id: current_subject_id,
                mark_as_review: mark_as_review,
                time_taken: time_taken,
                student_test_id: studentTestId,
                student_test_result_id: studentTestResultId,
                paper_id:paperId,
            },
            type: 'POST',
            global: true,
            success: function (result) {
                if(result.success == true){
                    $(".main_loader").css("display", "none");
                    $('#CompleteMockExamModal').modal('show');
                    if(result.mark_as_review == '0'){
                        $(document).find('.btn_rvw').hide();
                    }else{
                        markAsReview = true;
                        $(document).find('.btn_rvw').show();
                    }
                    $(document).find('.is_attmpt-cls').html(result.attemptedCount);
                    // if(parseInt(result.review_count) > 0 || $(document).find('#agreeCheck').prop("checked") == true){
                    //     $(document).find('.section_review_btn').show();
                    // }else{
                    //     $(document).find('.section_review_btn').hide();
                    // }
                }
            },
            error: function () {
            }
        });
        // $(document).find('.mck-tst-img').attr('src', $(this).attr('data-mock-test-image'));
        // $(document).find('.mck-tst-title').html($(this).attr('data-mock-test-title')+' Followed By '+paperName);
        // $(document).find('.mck-tst-img-url').attr('href', $(this).attr('data-url'));
        // $(document).find('.mck-tst-title-url').attr('href', $(this).attr('data-url'));
    });

    function formatTime(seconds) {
        var h = Math.floor(seconds / 3600),
            m = Math.floor(seconds / 60) % 60,
            s = seconds % 60;
        if (h < 10) h = "0" + h;
        if (m < 10) m = "0" + m;
        if (s < 10) s = "0" + s;

        var time_taken = $(document).find("input[name='time_taken']").val();
        $.ajax({
            url:updateTestStatus,
            global: false,
            data:{
                mock_test_id:mockTestId,
                test_id:studentTestId,
                paper_id:paperId,
                time_taken:time_taken,
            },
            method:'GET',
            success:function(response){
                if(response.status == 'success'){
                }
            }
        })

        if (h == '00' && m == '00' && s == '00') {
            if(nextSubjectId == null || nextSubjectId ==''){
                // $('#MockExamCompleteModal').modal('show');
            }else{
                // $('#StartNextSectionModal').modal('show');
            }
            if(nextSectionId == null || nextSectionId ==''){
                window.location.replace(resultUrl);
            }else{
                url = $('#nextSection').attr('data-href');
                savePaperRemainingTime(url);
            }
        }
        return h + ":" + m + ":" + s;
    }

    var count = examTotalTimeSeconds;
    var timeTakenCount = 0;
    if(stageId == '1'){
        var counter = setInterval(timer, 1000);
        var timeTakenCounter = setInterval(timeTaken, 1000);
    }

    function timer() {
        count--;
        if (count < 0) return clearInterval(counter);
        document.getElementById('timer').innerHTML = formatTime(count);
    }

    function timeTaken() {
        timeTakenCount++;
        if (timeTakenCount < 0) return clearInterval(timeTakenCounter);
        if(timeTakenCount < examTotalTimeSeconds){
            $('#timeTaken').val(timeTakenCount);
            section_taken_time++;
        }
    }

    $(document).on('click','.cmplt_btn2',function(){  
        // $(document).find('.mck-tst-img').attr('src',$(this).attr('data-mock-test-image'));
        // $(document).find('.mck-tst-title').html($(this).attr('data-mock-test-title'));
        // $(document).find('.mck-tst-img-url').attr('href',$(this).attr('data-mock-test-image'));
        // $(document).find('.mck-tst-title-url').attr('href',$(this).attr('data-url'));
      });
  
    // Save mock details
    $(document).on('click','.cmplt_mck',function(){
        $('#CompleteMockExamModal').modal('hide');
        $("#CompletionSuccessfulModal").modal('hide');
        $(".main_loader").css("display", "block");
        var mockTestId = $(this).data('mock-test-id');
        var ipAddress = $(document).find('.ip_cls').text();
        var redirectUrl = $(this).attr('data-url');
        var time_taken = $(document).find("input[name='time_taken']").val();
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
                    time_taken:time_taken,
                    paper_id:paperId,
                    section_taken_time:section_taken_time,
            },
            type:'POST',
            global:true,
            success:function(result) {
                $(".main_loader").css("display", "none");
                if(result.success == true){
                    window.location.replace(redirectUrl);
                }
            },
            error:function() {
            }
        });
    });
});

$('#examData').on('click', '.nxtSubQue', function () {
    var current_question_id = $(this).data('current_question_id');
    var mockTestId = $(this).data('mock-test-id');
    var subjectId = $(this).data('subject_id');
    var time_taken = $("input[name='time_taken']").val();
    // var mark_as_review = $("input[name='mark_for_review']").val();
    var mark_as_review = 0;
    if ($("input[name='mark_for_review']").prop("checked") == true) {
        mark_as_review = 1;
    }
    if ($("input[name='mark_for_review']").attr('type') == 'hidden'){
        mark_as_review = 1;
    }
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
        url: saveQuestionAnsURL,
        data: {
            current_question_id: current_question_id,
            mock_test_id: mockTestId,
            subject_id: current_subject_id,
            mark_as_review: mark_as_review,
            time_taken: time_taken,
            student_test_id: studentTestId,
            student_test_result_id: studentTestResultId,
            section_id : sectionId,
            answer_ids : JSON.stringify(answerIds),
        },
        type: 'POST',
        global: true,
        success: function (result) {
            $(".main_loader").css("display", "none");
            $(document).find('.is_attmpt-cls').html(result.attemptedCount);
        },
        error: function () {
        }
    });
});

function addcheckbox(event) {
    console.log(event.target.value);
}

$('#nextSection').on('click',function(e){
    url = $(this).attr('data-href');
    savePaperRemainingTime(url);
})

$('#prevSection').on('click',function(e){
    url = $(this).attr('data-href');
    savePaperRemainingTime(url);
})

function savePaperRemainingTime(url=null){
    $.ajax({
        url:saveRemainingTime,
        method:'POST',
        global:false,
        data:{
            section_taken_time:section_taken_time,
            examTotalTimeSeconds:examTotalTimeSeconds,
            section_id:sectionId
        },
        success:function(response){
            if(response.status == 'success'){
                if(url != null){
                    window.location.href=url;
                }
            }
        },
        failure:function(){

        },
    })
}

$('.btn_rvw').on('click',function(e){
    url = $(this).attr('data-href');
    $.ajax({
        url:saveRemainingTime,
        method:'POST',
        global:false,
        data:{
            section_taken_time:section_taken_time,
            examTotalTimeSeconds:examTotalTimeSeconds,
            section_id:sectionId
        },
        success:function(response){
            if(response.status == 'success'){
                window.location.href=url;
            }
        },
        failure:function(){
        },
    })
})

$('#examData').on('click','.quest_lst_n',function(){
    var questionId = $(this).attr('data-index');
    goToQuestion(questionId);
})

function goToQuestion(questionId){
    var answerIds = [];
    $("input[name='asnwer']:checked").each(function(k,v){
        answerIds.push(this.value); 
    })
    var mark_as_review = 0;
    if ($("input[name='mark_for_review']").prop("checked") == true) {
        var mark_as_review = 1;
    }
    var currentQuestionId = $(document).find('#examData').find('.nxt_qus').data('current_question_id')  ;
    $.ajax({
        url:questionUrl,
        global: false,
        data:{
            question_id:questionId,
            section_id:sectionId,
            answer:JSON.stringify(answerIds),
            mark_as_review:mark_as_review,
            current_question_id:currentQuestionId,
        },
        method:'POST',
        success:function(result){
            if(result.status == 'success'){
                $(document).find('#examData').html(result.testDetail);
                $(document).find('.is_attmpt-cls').html(result.attemptedCount);
                $(document).find('.sectionName').text(result.sectionName);
                if(result.nextQuestionId==null || result.nextQuestionId == ''){
                    $(document).find('.lastQuestionLabel').show();
                }else{
                    $(document).find('.lastQuestionLabel').hide();
                }
                if(result.mark_as_review == "1"){
                    $(document).find('#agreeCheck').prop("checked",true);
                }else{
                    $(document).find('#agreeCheck').prop("checked",false);
                }
                // if(parseInt(result.review_count) > 0 || $(document).find('#agreeCheck').prop("checked") == true){
                //     $(document).find('.section_review_btn').show();
                // }else{
                //     $(document).find('.section_review_btn').hide();
                // }
                initializePdf();
                $(".main_loader").css("display", "none");
                setTimeout(function () {
                    timeTakenCount = 0;
                }, 100);
            }
        },
        error:function(){

        }
    })
}