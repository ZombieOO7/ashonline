$(document).ready(function() {
    $(document).on('click', '.nxt_qus', function() {
        $('.optn_bbx label').css({
            "border": "1px solid #EEEEEE",
            "background-color": "#fff",
            "color": "#000000"
        });
        $(".main_loader").css("display", "block");
        var nextquestionid = $(this).data('next_question_id');
        var mocktestid = $(this).data('mock_test_id');
        var prevquestionid = $(this).data('prev_question_id');
        var btntype = $(this).data('btn_type');
        var currentquestionid = $(this).data('current_question_id');
        var currentsubquestionid = $(this).data('current_sub_question_id');
        var prevsubquestionid = $(this).data('prev_sub_question_id');
        var nextsubquestionid = $(this).data('next_sub_question_id');
        var subjectid = $(this).data('subject_id');
        var currentquestionNumber = $(this).data('current_question_number');
        var prevquestionNumber = $(this).data('prev_question_number');
        var nextquestionNumber = $(this).data('next_question_number');
        var answer = $('input[name=asnwer]:checked', '.qstn_form').val();
        if(answer== undefined){
            answer = '';
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: ajaxNextQuestionUrl,
            data: {
                next_question_id: nextquestionid,
                mock_test_id: mocktestid,
                prev_question_id: prevquestionid,
                type: btntype,
                current_question_id: currentquestionid,
                subject_id: subjectid,
                current_sub_question_id: currentsubquestionid,
                prev_sub_question_id: prevsubquestionid,
                next_sub_question_id: nextsubquestionid,
                current_question_number: currentquestionNumber,
                previous_question_number: prevquestionNumber,
                next_question_number: nextquestionNumber,
                student_id: student_id,
                answer:answer,
            },
            type: 'POST',
            global: true,
            success: function(result) {
                $(document).find('.in_qstn_box').empty().html(result.nextQuestionTitle);
                $(document).find('.main-dv').html(result.testDetail);
                $(document).find('.t_marks').html(result.question_marks);
                $(document).find('.prev-btn-li').html(result.prevButton);
                $(document).find('.cmplt-mock').html(result.completeMockBtn);
                $(document).find('.next-btn-li').html(result.nextButton);
                $(".main_loader").css("display", "none");
                $(document).find('.selectedAns').removeClass('selectedAns');
                $("input[name='asnwer']").attr('checked',false);
                debugger;
                if(result.selectedAns != null && result.selectedAns != ''){
                    $('#' + result.labelId).addClass('selectedAns');
                    $("input[name='asnwer']").each(function() {
                        if (this.value == result.selectedAns) {
                            $(this).attr('checked',true);
                            $(this).trigger('click');
                        }
                    });
                }else{
                    // $('#' + result.labelId).parent().find('input').attr('checked',false);
                }
                $(document).find('.marks_obtained').html(result.marks_obtained);
                $(document).find('#previewQuestionList').html(result.previewList);
                $(document).find('#examData').html(result.passage);
                $(document).find('.sectionTitle').text(result.section.name);
                initializePdf();
                // $(document).find('.answerList').empty().html(result.answerList);
            },
            error: function() {}
        });
    });

    $(document).on('click', '#asnwer_a', function() {
        $('#asnwer_a').attr('checked',false);
        $('.optn_bbx label').css({
            "border": "1px solid #EEEEEE",
            "background-color": "#fff",
            "color": "#000000"
        });
        // $(".main_loader").css("display", "block");
        var mocktestid = $(".next-btn-li button").data('mock_test_id');
        var currentquestionid = $(".next-btn-li button").data('current_question_id');
        var currentsubquestionid = $(".next-btn-li button").data('current_sub_question_id');
        var subjectid = $(".next-btn-li button").data('subject_id');
        var answer = $(this).val();
        var obt_marks = $(".marks_obtained").val();
        $(document).find('.selectedAns').removeClass('selectedAns');
        $(this).next('label').addClass('selectedAns');
        $(this).attr('checked',true);
    });

    $(document).on('click', '.cmplt_btn', function() {
        $('.optn_bbx label').css({
            "border": "1px solid #EEEEEE",
            "background-color": "#fff",
            "color": "#000000"
        });
        $(".main_loader").css("display", "block");

        var mocktestid = $(".next-btn-li button").data('mock_test_id');
        var subjectid = $(".next-btn-li button").data('subject_id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        storeAnswer().done(function(){});
        $.ajax({
            url: completeMockUrl,
            data: {
                mock_test_id: mocktestid,
                subject_id: subjectid,
                student_id: student_id,
                student_test_result_id: student_test_result_id
            },
            type: 'POST',
            global: true,
            success: function(result) {
                $(".main_loader").css("display", "none");
                redirectUrl = result.redirectUrl;
                $('#CompleteMockExamModal').modal('show');
            },
            error: function() {}
        });
    });

    $(document).on('click', '.prv_qus', function() {
        $('.optn_bbx label').css({
            "border": "1px solid #EEEEEE",
            "background-color": "#fff",
            "color": "#000000"
        });
        $(".main_loader").css("display", "block");
        var nextquestionid = $(this).data('next_question_id');
        var mocktestid = $(this).data('mock_test_id');
        var prevquestionid = $(this).data('prev_question_id');
        var btntype = $(this).data('btn_type');
        var currentquestionid = $(this).data('current_question_id');
        var currentsubquestionid = $(this).data('current_sub_question_id');
        var prevsubquestionid = $(this).data('prev_sub_question_id');
        var nextsubquestionid = $(this).data('next_sub_question_id');
        var subjectid = $(this).data('subject_id');
        var currentquestionNumber = $(this).data('current_question_number');
        var prevquestionNumber = $(this).data('prev_question_number');
        var nextquestionNumber = $(this).data('next_question_number');
        var answer = $('input[name=asnwer]:checked', '.qstn_form').val();
        if(answer== undefined){
            answer = '';
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: ajaxNextQuestionUrl,
            data: {
                next_question_id: nextquestionid,
                mock_test_id: mocktestid,
                prev_question_id: prevquestionid,
                type: btntype,
                current_question_id: currentquestionid,
                subject_id: subjectid,
                current_sub_question_id: currentsubquestionid,
                prev_sub_question_id: prevsubquestionid,
                next_sub_question_id: nextsubquestionid,
                current_question_number: currentquestionNumber,
                previous_question_number: prevquestionNumber,
                next_question_number: nextquestionNumber,
                student_id: student_id,
                answer:answer,
            },
            type: 'POST',
            global: true,
            success: function(result) {
                $(document).find('.in_qstn_box').empty().html(result.nextQuestionTitle);
                $(document).find('.main-dv').html(result.testDetail);
                $(document).find('.t_marks').html(result.question_marks);
                $(document).find('.prev-btn-li').html(result.prevButton);
                $(document).find('.cmplt-mock').html(result.completeMockBtn);
                $(document).find('.next-btn-li').html(result.nextButton);
                $(".main_loader").css("display", "none");
                $(document).find('.selectedAns').removeClass('selectedAns');
                $("input[name='asnwer']").attr('checked',false);
                debugger;
                if(result.selectedAns != null && result.selectedAns != ''){
                    $('#' + result.labelId).addClass('selectedAns');
                    $("input[name='asnwer']").each(function() {
                        if (this.value == result.selectedAns) {
                            $(this).attr('checked',true);
                            $(this).trigger('click');
                        }
                    });
                }else{
                    // $('#' + result.labelId).parent().find('input').attr('checked',false);
                }
                $(document).find('.marks_obtained').html(result.marks_obtained);
                $(document).find('#previewQuestionList').html(result.previewList);
                // $(document).find('.answerList').empty().html(result.answerList);
                $(document).find('.sectionTitle').text(result.section.name);
                $(document).find('#examData').html(result.passage);
                initializePdf();

            },
            error: function() {}
        });
    });
    function storeAnswer() {
        var deferred = $.Deferred();
        $('.optn_bbx label').css({
            "border": "1px solid #EEEEEE",
            "background-color": "#fff",
            "color": "#000000"
        });
        // $(".main_loader").css("display", "block");
        var mocktestid = $(".next-btn-li button").data('mock_test_id');
        var currentquestionid = $(".next-btn-li button").data('current_question_id');
        var currentsubquestionid = $(".next-btn-li button").data('current_sub_question_id');
        var subjectid = $(".next-btn-li button").data('subject_id');
        var answer = $('input[name=asnwer]:checked', '.qstn_form').val();
        if(answer== undefined){
            answer = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: markQuestionUrl,
            data: {
                mock_test_id: mocktestid,
                current_question_id: currentquestionid,
                current_sub_question_id: currentsubquestionid,
                subject_id: subjectid,
                answer: answer
            },
            type: 'POST',
            global: true,
            success: function(result) {
                $(document).find('.marks_obtained').html(result.marks_obtained);
            },
            error: function() {}
        });
        return deferred.promise();
    }
});
$(document).on('click','.quest_lst_n',function(){
    var questionId = $(this).attr('data-index');
    goToQuestion(questionId);
})

function goToQuestion(questionId){
    $('.optn_bbx label').css({
        "border": "1px solid #EEEEEE",
        "background-color": "#fff",
        "color": "#000000"
    });
    $(".main_loader").css("display", "block");
    var currentQuestionId = $(document).find('.nxt_qus').data('current_question_id');
    var answer = $('input[name=asnwer]:checked', '.qstn_form').val();
    if(answer== undefined){
        answer = '';
    }
    $.ajax({
        url:questionUrl,
        data:{
            question_id:questionId,
            answer:answer,
            current_question_id:currentQuestionId,
        },
        method:'POST',
        success:function(result){
            if(result.status == 'success'){
                $(document).find('.in_qstn_box').empty().html(result.nextQuestionTitle);
                // $(document).find('.main-dv').html(result.testDetail);
                // $(document).find('.t_marks').html(result.question_marks);
                $(document).find('.prev-btn-li').html(result.prevButton);
                $(document).find('.cmplt-mock').html(result.completeMockBtn);
                $(document).find('.next-btn-li').html(result.nextButton);
                $(".main_loader").css("display", "none");
                $(document).find('.selectedAns').removeClass('selectedAns');
                $("input[name='asnwer']").attr('checked',false);
                $(document).find('#previewQuestionList').html(result.previewList);
                debugger;
                if(result.selectedAns != null && result.selectedAns != ''){
                    $('#' + result.labelId).addClass('selectedAns');
                    $("input[name='asnwer']").each(function() {
                        if (this.value == result.selectedAns) {
                            $(this).attr('checked',true);
                            $(this).trigger('click');
                        }
                    });
                }else{
                    // $('#' + result.labelId).parent().find('input').attr('checked',false);
                }
                $(document).find('.marks_obtained').html(result.marks_obtained);
                $(document).find('#examData').html(result.passage);
                $(document).find('.sectionTitle').text(result.section.name);
                initializePdf();
            }
        },
        error:function(){

        }
    })
}
$(document).on('click','.cmplt_mck',function(){
    if(redirectUrl != null){
        location.href = redirectUrl;
    }
})