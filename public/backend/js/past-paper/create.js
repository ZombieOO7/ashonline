$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            name: {
                required: true,
                maxlength:rule.name_length,
            },
            year: {
                required: true,
            },
            school_year: {
                required: true,
            },
            month:{
                required: true,
            },
            subject_id:{
                required: true,
            },
            instruction:{
                required: true,
                maxlength:rule.content_length,
            },
            total_duration:{
                required: true,
                digits:true,
                maxlength:rule.content_length,
            },
            status:{
                required: true,
            },
            pdf_file:{
                required: function(element){
                    if($('#stored_file').val() != ""){
                        return false;
                    }
                    return true;
                },
                accept: "application/pdf",
            },
            import_file:{
                required:function(element){
                    if(parseInt(pregunta) > '0' ){
                        return false;
                    }
                    return true;
                }
            },
            'images[]':{
                required:function(element){
                    if(parseInt(pregunta) > '0' ){
                        return false;
                    }
                    return true;
                }
            }
        },
        messages:{
            pdf_file:{
                accept:'Only .pdf file formats are allowed.',
            },
        },
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "instruction")
                error.insertAfter(".descriptionError");
            else if(element.attr("name").includes('topic') == true){
                var id = element.attr('id');
                error.insertAfter("."+id+"Error");
            }
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
        submitHandler: function (form) {
            // Prevent double submission
            if (!this.beenSubmitted) {
                this.beenSubmitted = true;
                form.submit();
            }
        },
    });
});
CKEDITOR.on('instanceReady', function() {
    $.each(CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
        CKEDITOR.instances[instance].document.on("change", CK_jQ);
    });
});

function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

CKEDITOR.replace('editor1');
CKEDITOR.config.removePlugins = 'image';

$(document).on('click','.addQuestionAnswer',function(){
    getQuestionLayout('add');
})

$('#groupQuestionAnswerData').on('click','.removeQuestionAnswer',function(){
    var cloneDataId = $(this).attr('data-id');
    $('#'+cloneDataId).remove();
})

$('form#m_form_1').on('submit', function (event) {
    if ($("#m_form_1").valid()) {
        return true;
    } else {
        return false;
    }
})

if($('#m_form_3').length > 0){
    $('#m_form_3').validate({
        rules:{
            question_no:{
                required :true,
            },
            solved_question_time:{
                required :true,
                digits:true,
            },
            subject_id:{
                required :true,
            },
            topic_id:{
                required :true,
            },
            question_file:{
                required :function(element){
                    if($('#stored_question_image').val() == '' || $('#stored_question_image').val() != null){
                        return false;
                    }else{
                        return true;
                    }
                },
            },
            answer_file:{
                required :function(element){
                    if($('#stored_answer_image').val() == '' || $('#stored_answer_image').val() != null){
                        return false;
                    }else{
                        return true;
                    }
                },
            }
        }
    })
}