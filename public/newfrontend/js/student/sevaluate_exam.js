
$(document).ready(function() {

    //Prev/Next
    $(document).on('click','.nxt_qus',function(){
        //alert($(this).data('next_question_id'))
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

      //  console.log('next_question_id',nextquestionid);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:ajaxNextQuestionUrl,
            data:{
                next_question_id : nextquestionid,
                mock_test_id : mocktestid,
                prev_question_id : prevquestionid,
                type : btntype,
                current_question_id : currentquestionid, 
                subject_id : subjectid,
                current_sub_question_id:currentsubquestionid,
                prev_sub_question_id: prevsubquestionid,
                next_sub_question_id: nextsubquestionid
            },
            type:'POST',
            global:true,
            success:function(result) {
               // console.log(result.nextSubQuestionId);
              
                $(document).find('.quest-title').html(result.nextQuestionTitle);
                $(document).find('.ajx-quest').html(result.subQuestion);
                $(document).find('.ajx-ans').html(result.subQuestionAnswer);
                  
                if(result.nextSubQuestionId == null || result.nextSubQuestionId == ''){
                    $(document).find('.nxt_btn').attr('data-next_sub_question_id','');
                    $(document).find('.nxt_btn').attr('data-prev_sub_question_id',result.prevSubQuestionId);          
                    $(document).find('.nxt_btn').attr('data-next-question-id',result.nextQuestionId);
                    $(document).find('.nxt_btn').attr('data-current_question_id',result.currentquestionId);
                    $(document).find('.nxt_btn').attr('data-type','next-main-question');
              
                }else{
                   $(document).find('.nxt_btn').attr('data-next_sub_question_id',result.nextSubQuestionId); 
                }
                
                

                if(result.nextQuestion != '' || result.nextQuestion != null){
                    $(document).find('.quest-title').html(result.nextQuestion);
                    $(document).find('.ajx-quest').html(result.questionList);
                    $(document).find('.ajx-ans').html(result.answer);
                }
                
                // if(result.detailArr.btn_type == 'next' && (result.detailArr.next_sub_question_id != '' || result.detailArr.next_sub_question_id != null)){


                // }
           //     $(document).find('.next-btn-li').html(result.nextButton);
                   

                // $(document).find('.nxt_btn').attr('data-prev_sub_question_id',result.prevSubQuestionId);          
                // $(document).find('.nxt_btn').attr('data-next-question-id',result.nextQuestionId);
                // $(document).find('.nxt_btn').attr('data-current_question_id',result.currentquestionId); 
                
                
                $(".main_loader").css("display", "none");
                            
              
               // $(document).find('.nxt-qus-li').html(result.nextButton);
               // $(document).find('.prv-qus-li').html(result.prevButton);
                //$(document).find('.ajx-dv').html(result.testDetail);
             
               // $(document).find('.is_attmpt-cls').html(result.attemptedCount);
               // $(document).find('.cpmlt-mck').html(result.completeButton);
                //$(document).find('#agreeCheck').prop("checked", false);
               
                // setTimeout(function(){
                //     timeTakenCount = 0;
                // },100);
            },
            error:function() {
            }
        });
    });

   
  });