$(document).ready(function(){
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
        var index = $(data).attr('data-index');
        var next_question_id = $(data).attr('data-questionId');
        var answerId = $(document).find('.answer:checked').attr('data-answerId');
        var markAsReview = 0;
        if($(document).find('#agreeCheck').prop('checked')==true){
            markAsReview = 1;
        }
        var answerIds = [];
        $(document).find('.answer:checked').each(function(k,v){
            answerIds.push(this.value);
        })
        $.ajax({
            url:url,
            method:'POST',
            global: true,
            data:{
                id:id,
                answer_ids:JSON.stringify(answerIds),
                mark_as_review:markAsReview,
                next_question_id:next_question_id,
                question_no:questionNo,
                is_review_question:0,
                index:index,
            },
            success:function(response){
                $(".main_loader").css("display", "none");
                if(response.status == 'success'){
                    $('.questionNo').text(questionNo);
                    $('.questionNo').attr('data-questionNo',questionNo);
                    $(document).find(".questionContent").empty().html(response.html);
                    $(document).find("#previewQuestionList").empty().html(response.previewHtml);
                    var target = $('.questionContent');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                        return false;
                    }
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
    });
    function storeAnswer(id,status){
        var id = id;
        var is_correct = 0;
        var markAsReview = 0;
        if($(document).find('#agreeCheck').prop('checked')==true){
            markAsReview = 1;
        }
        var answerIds = [];
        $(document).find('.answer:checked').each(function(k,v){
            answerIds.push(this.value);
        })
        $.ajax({
            url:storeAnswerUrl,
            method:'POST',
            global: true,
            data:{
                id:id,
                answer_ids:JSON.stringify(answerIds),
                mark_as_review:markAsReview,
                is_review_question:0,
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

    /* get next question  */
    $(document).on('click','.goToQuestion',function(){
        $(".main_loader").css("display", "block");
        var id = $(this).attr('data-id');
        var index = $(this).attr('data-index');
        var questionNo = $(this).attr('data-questionNo');
        var answerIds = [];
        $(document).find('.answer:checked').each(function(k,v){
            answerIds.push(this.value);
        })
        $.ajax({
            url:goToQuestionUrl,
            method:'POST',
            global: true,
            data:{
                id:id,
                answer_ids:JSON.stringify(answerIds),
                index:index,
                question_no:questionNo,
            },
            success:function(response){
                $(".main_loader").css("display", "none");
                if(response.status == 'success'){
                    $('.questionNo').text(questionNo);
                    $('.questionNo').attr('data-questionNo',questionNo);
                    $(document).find(".questionContent").empty().html(response.html);
                    $(document).find("#previewQuestionList").empty().html(response.previewHtml);
                    var target = $('.questionContent');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                        return false;
                    }
                    isReview = response.isReview;
                }
            },
            error: function () {
            }
        });
        // savePaperRemainingTime();
    });
})