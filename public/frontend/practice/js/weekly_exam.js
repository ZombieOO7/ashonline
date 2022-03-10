// disable page refresh and and back button
function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

$(document).ready(function(){
    $(document).on("keydown", disableF5);
});
$(document).bind("contextmenu",function(e){
    return false;
});
$(document).find('#header').click(false);
$(document).find('.subscibe_sc').click(false);
$(document).find('.footer').click(false);
$(document).on('click','#epapersMenu', function(e){
    e.preventDefault();
});
$(document).ready(function() {
    swal("Please do not refresh or go back data may be lost", {
        icon: 'info',
        closeOnClickOutside: false,
    });
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, "", window.location.href);
    };
    $(window).keydown(function(event){
        if(event.keyCode == 116) {
            event.preventDefault();
            return false;
        }
    });
});
$(document).ready(function(){
    if($('#firstAudio').length >0){
        setTimeout(function(){
        document.getElementById("firstAudio").play();
        }, 3000);
    }
    if($('#secondAudio').length >0){
        setTimeout(function(){
        document.getElementById("secondAudio").play();
        }, secondAudioPlayTime);
    }
    if($('#thirdAudio').length >0){
        setTimeout(function(){
        document.getElementById("thirdAudio").play();
        }, thirdAudioPlayTime);
    }
    if($('#forthAudio').length >0){
        setTimeout(function(){
        document.getElementById("forthAudio").play();
        }, forthAudioPlayTime);
    }
})
$(document).ready(function(){
    var isReview = 0;
    // store Answer
    // $(document).on('click','.answer',function(){
    //     $(".main_loader").css("display", "block");
    //     var id = $(this).attr('data-testQuestionAnswerId'); 
    //     storeAnswer(id,0);
    // });
    /* get next question  */
    $(document).on('click','.nextQuestion',function(){
        $(".main_loader").css("display", "block");
        var currentQuestionNo = parseInt($(document).find('.questionNo').attr('data-questionNo'));
        var questionNo = currentQuestionNo + 1 ;
        getNextPreviousQuestion(this,questionNo,nextQuestionUrl);
        savePaperRemainingTime();
    });

    /* get previous question */
    $(document).on('click','.previousQuestion',function(){
        $(".main_loader").css("display", "block");
        var currentQuestionNo = parseInt($(document).find('.questionNo').attr('data-questionNo'));
        var questionNo = currentQuestionNo - 1 ;
        getNextPreviousQuestion(this,questionNo,previousQuestionUrl);
        // savePaperRemainingTime();
    });
    /* get next question  */
    $(document).on('click','.quest_lst_n',function(){
        $(".main_loader").css("display", "block");
        var currentQuestionNo = parseInt($(this).attr('data-questionNo'));
        var questionNo = currentQuestionNo + 1 ;
        getNextPreviousQuestion(this,questionNo,nextQuestionUrl);
        // savePaperRemainingTime();
    });
    function getNextPreviousQuestion(data,questionNo,url){
        var id = $(data).attr('data-id');
        var next_question_id = $(data).attr('data-questionId');
        var answerId = $(document).find('.answer:checked').attr('data-answerId');    
        var is_correct = 0;
        var markAsReview = 0;
        if($(document).find('#agreeCheck').prop('checked')==true){
            markAsReview = 1;
        }
        // if(answerId != undefined && ($(document).find('.answer:checked').attr('data-answerId') == $(document).find('.answer:checked').attr('data-correctAnswerId'))){
        //     is_correct = 1;
        // }
        var answerIds = [];
        $(document).find('.answer:checked').each(function(k,v){
            answerIds.push(this.value); 
        })
        $.ajax({
            url:url,
            method:'POST',
            data:{
                id:id,
                answer_ids:JSON.stringify(answerIds),
                mark_as_review:markAsReview,
                is_correct:is_correct,
                next_question_id:next_question_id,
                question_no:questionNo,
                is_review_question:0,
                section_id:sectionId,
            },
            success:function(response){
                if(response.status == 'success'){
                    initializePdf();
                    $(".main_loader").css("display", "none");
                    $('.questionNo').text(response.questionNo);
                    $('.questionNo').attr('data-questionNo',response.questionNo);
                    $(document).find(".questionContent").empty().html(response.html);
                    $(document).find('.attempted').text(response.attempted);
                    var target = $('.questionContent');
                    // if (target.length) {
                    //     $('html,body').animate({
                    //         scrollTop: target.offset().top - 100
                    //     }, 1000);
                    //     return false;
                    // }
                    isReview = response.isReview;
                }
            },
            error: function () {
            }
        })
    }
    // store Answer
    $(document).on('click','.completeBtn',function(){
        $(".main_loader").css("display", "block");
        var id = $(this).attr('data-id');
        storeAnswer(id,1);
        savePaperRemainingTime();
    });
    $(document).on('click','.nextSection', function(){
        $(".main_loader").css("display", "block");
        var id = $(this).attr('data-id');
        storeAnswer(id,1);
        savePaperRemainingTime();
        window.location.href=nextSectionUrl;
    })
    function storeAnswer(id,status){
        var id = id; 
        var answerIds = [];
        $(document).find('.answer:checked').each(function(k,v){
            answerIds.push(this.value); 
        })
        var is_correct = 0;
        var markAsReview = 0;
        if($(document).find('#agreeCheck').prop('checked')==true){
            markAsReview = 1;
        }
        $.ajax({
            url:storeAnswerUrl,
            method:'POST',
            data:{
                id:id,
                answer_ids:JSON.stringify(answerIds),
                mark_as_review:markAsReview,
                is_correct:is_correct,
                is_review_question:0,
            },
            success:function(response){
                $(".main_loader").css("display", "none");
                isReview = response.isReview;
                if(status==1){
                    $("#CompleteMockExamModal").modal('show');
                }
            },
            error: function () {
            }
        })
    }

    function formatTime(seconds) {
        var h = Math.floor(seconds / 3600),
            m = Math.floor(seconds / 60) % 60,
            s = seconds % 60;
        if (h < 10) h = "0" + h;
        if (m < 10) m = "0" + m;
        if (s < 10) s = "0" + s;
        if (h == '00' && m == '00' && s == '00') {
            // $('#CompleteMockExamModal').modal('show');
            // console.log('h=' + h);
            // console.log('m=' + m);
            // console.log('s=' + s);
            // setTimeout(function(){
            //     if(isReview == 1){
            //         window.location.replace(examReviewUrl);
            //     }else{
            //         window.location.replace(resultUrl);
            //     }
            // },3000);
            if(nextSectionId == null || nextSectionId == ''){
                window.location.replace(resultUrl);
            }else{
                savePaperRemainingTime();
                window.location.replace(nextSectionUrl);
            }
        }
        return h + ":" + m + ":" + s;
    }

    var count = examTotalTimeSeconds;
    var timeTakenCount = 0;
    var counter = setInterval(timer, 1000);
    var timeTakenCounter = setInterval(timeTaken, 1000);

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
})
$(document).find('#reportProblem').validate({
    rules: {
        description:{
            required:true,
            maxlength: rule.content_length,
        }
    },
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    }
})
$(document).on('click','.rprt_btn',function(){
    $(".main_loader").css("display", "block");
    var questionId = $(document).find('#questionListId').val();
    var testQuestionAnswerId = $(document).find('#testQuestionAnswerId').val();
    $.ajax({
        url:getReportProblemUrl,
        method:'POST',
        data:{
            question_answer_id:testQuestionAnswerId,
            question_id:questionId,
            test_assessment_id:testAssessmentId,
            project_type:2,
        },
    success:function(response){
        $(".main_loader").css("display", "none");
        $('#reportProblemModal').modal('show');
        if(response.status=='success'){
            $(document).find('#problem').val(response.data.description);
        }else{
            $(document).find('#problem').val('');
        }
    },
    error: function () {
    }
    });
})
$(document).on('click','.submitReport',function(){
    if($(document).find('#reportProblem').valid()){
        $('.lds-ring').show();
        var questionId = $(document).find('#questionListId').val();
        var description = $(document).find('#problem').val();
        var testQuestionAnswerId = $(document).find('#testQuestionAnswerId').val();
        $.ajax({
            url:reportProblemUrl,
            method:'POST',
            data:{
                question_answer_id:testQuestionAnswerId,
                question_id:questionId,
                description:description,
                test_assessment_id:testAssessmentId,
                project_type:2,
            },
            success:function(response){
                $('.lds-ring').hide();
                toastr.success(response.msg);
                $('#reportProblemModal').modal('hide');
            },
            error: function () {
            }
        })
    }
})

/* save paper taken time  */
function savePaperRemainingTime(url=null){
    $.ajax({
        url:saveRemainingTime,
        method:'POST',
        data:{
            section_taken_time:section_taken_time,
            examTotalTimeSeconds:examTotalTimeSeconds,
            section_id:sectionId
        },
        success:function(response){
            if(response.status == 'success'){
                // if(url != null){
                //     window.location.href=url;
                // }
            }
        },
        failure:function(){

        },
    })
}
