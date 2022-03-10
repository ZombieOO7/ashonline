$(document).ready(function(){
    var isReview = 0;
    // store Answer
    $(document).on('click','.answer',function(){
        $(".main_loader").css("display", "block");
        var id = $(this).attr('data-testQuestionAnswerId'); 
        storeAnswer(id,0);
    });
    /* get next question  */
    $(document).on('click','.nextQuestion',function(){
        $(".main_loader").css("display", "block");
        var currentQuestionNo = parseInt($(document).find('.questionNo').attr('data-questionNo'));
        var questionNo = currentQuestionNo + 1 ;
        getNextPreviousQuestion(this,questionNo,nextQuestionUrl);
    });

    /* get previous question */
    $(document).on('click','.previousQuestion',function(){
        $(".main_loader").css("display", "block");
        var currentQuestionNo = parseInt($(document).find('.questionNo').attr('data-questionNo'));
        var questionNo = currentQuestionNo - 1 ;
        getNextPreviousQuestion(this,questionNo,previousQuestionUrl);
    });
     function getNextPreviousQuestion(data,questionNo,url){
        var id = $(data).attr('data-id');
        var next_question_id = $(data).attr('data-questionId');
        var answerId = $(document).find('.answer:checked').attr('data-answerId');    
        var is_correct = 0;
        var markAsReview = 1;
        if(answerId != undefined && ($(document).find('.answer:checked').attr('data-answerId') == $(document).find('.answer:checked').attr('data-correctAnswerId'))){
            is_correct = 1;
        }
        $.ajax({
            url:url,
            method:'POST',
            data:{
                id:id,
                answer_id:answerId,
                mark_as_review:markAsReview,
                is_correct:is_correct,
                next_question_id:next_question_id,
                question_no:questionNo,
                is_review_question:1,
            },
            success:function(response){
                $(".main_loader").css("display", "none");
                $('.questionNo').text(questionNo);
                $('.questionNo').attr('data-questionNo',questionNo);
                $(document).find(".questionContent").empty().html(response.html);
                var target = $('.questionContent');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                    return false;
                }
                isReview = response.isReview;
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
    });
    function storeAnswer(id,status){
        var id = id; 
        var answerId = $(document).find('.answer:checked').attr('data-answerId'); 
        var correctAnswerId = $(document).find('.answer:checked').attr('data-correctAnswerId');
        var is_correct = 0;
        var markAsReview = 1;
        if((answerId != undefined && correctAnswerId != undefined) && answerId == correctAnswerId){
            is_correct = 1;
        }
        $.ajax({
            url:storeAnswerUrl,
            method:'POST',
            data:{
                id:id,
                answer_id:answerId,
                mark_as_review:markAsReview,
                is_correct:is_correct,
                is_review_question:1,
            },
            success:function(response){
                $(".main_loader").css("display", "none");
                isReview = response.isReview;
                if(isReview == 0){
                    $(document).find('.reviewPaper').hide();
                }else{
                    $(document).find('.reviewPaper').show();
                }
                if(status==1){
                    $("#CompleteMockExamModal").modal('show');
                }
            },
            error: function () {
            }
        })
    }
})
