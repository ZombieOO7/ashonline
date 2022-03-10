function readURL(input, placeToInsertImagePreview) {

    if (input.files) {
        var filesAmount = input.files.length;
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            var extension = input.files[0].name.split('.').pop().toLowerCase();
            if (extension != 'pdf') {
                reader.onload = function (event) {
                    var img = "<div class='col-6'><img src='" + event.target.result + "' class='img-fluid'></div>";
                    $(placeToInsertImagePreview).append(img);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

}

jQuery.validator.addMethod("cke_required",function (value, element) {
},"This field is required");
$('#question-append').on('change', '.correctAnswers', function () {
    var limit = $(this).attr('id');
    var answerType = $(this).attr('data-answerType');
    var questionIndex =  $(this).attr('data-questionIndex');
    var answerTypeValue = $('#'+answerType+':checked').val();
    if (parseFloat(answerTypeValue) == 2 || $('#type').val() == 4 || $('#qType').val() == 4) {
        if(this.checked == true){
            $(this).prop('checked', true);
            $(this).val('on');
        }else{
            $(this).prop('checked',false);
        }
    } else {
        $('.qna'+questionIndex).prop('checked',false);
        if ($('#' + limit + ':checked').length > 1){
            if(this.checked == true){
                $(this).prop('checked', true);
                $(this).val('on');
            }else{
                $(this).prop('checked',false);
            }
        }else{
            if(this.checked == false){
                $(this).prop('checked', true);
                $(this).val('on');
            }else{
                $(this).prop('checked',false);
            }
        }
    }
});

$(document).ready(function () {
    setTimeout(function () {
        var questionId = $(document).find('.questionedit').val();
        if (questionId != "") {
            $(document).find('#type').trigger('change');
        }
    }, 500);

    $(document).on('change', '#subject_id', function () {
        var subject_id = $(this).val();
        $(document).find('#type').val('');
        $(document).find('#question_type').val('');
        $(document).find('#type').attr('data-subject-id', subject_id);
    });

    $(document).on('change', '#type', function () {
        var type = $(this).val();
        var question_type = $('#question_type').val();
        var subject_id = $(this).attr('data-subject-id');
        var question_id = $(this).attr('data-question-id');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            method: "get",
            data: {
                subject_id: subject_id,
                question_id: question_id,
                type: type,
                question_type: question_type,
            },
            success: function (response) {
                $("#question-append").html('');
                if (response.html != "") {
                    $("#question-append").html(response.html);
                    initializeCkeditor();
                } else {
                    $("#question-append").html('');
                }
            }
        })
    });

    $(document).on('keyup', '.option-answer', function () {
        var limit = $(document).find('.limitCheckBox').val();
        var selectedAns = $(this).attr('data-selected-ans');
        if ($(this).val() != "") {
            if (selectedAns == 5 || selectedAns == 6) {
                sum = selectedAns;
            }
        } else {
            if (selectedAns == 6) {
                sum = parseFloat(limit) - 1;
            }
            $(document).find('#answer_' + selectedAns).prop("checked", false);
        }
        $(document).find('.limitCheckBox').val(sum)
    });

    $(document).on('change', '#question_image', function () {
        $('#image_preview').empty();
        readURL(this, 'div#image_preview');
    });
    jQuery.validator.addMethod("notEqualTo", function (value, element) {
        inpName = element.name;
        className = $('input[name="' + inpName + '"]').attr('data-selected-ans');
        ansValue = $('input[name="' + inpName + '"]').val();
        var counter = 0;
        console.log(className);
        $('.answer' + className).each(function (k, v) {
            if (ansValue == $(this).val()) {
                counter++;
            }
        })
        if (counter > 1) {
            return false;
        } else {
            return true;
        }
    }, "Answer must be unique");

    $("#m_form_1").validate({
        rules: {
            question_no:{
                noSpace: true,
                required: true,
                maxlength: rule.content_length,
                digits: true,
            },
            subject_id: {
                required: function () {
                    if ($("#subject_id option:selected").val() != '') {
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            question: {
                noSpace: true,
                required: true,
                maxlength: rule.content_length,
            },
            is_correct: {
                noSpace: true,
                required: true,
            },
            topic_id: {
                noSpace: true,
                required: true,
                maxlength: rule.name_length,
            },
            question_type: {
                required: true,
            },
            type: {
                required: true,
            },
            hint: {
                maxlength: rule.name_length,
            }
        },
        errorPlacement: function (error, element) {
            console.log(error);
            $('.errors').remove();
            // error.insertAfter(element);
            if(element.attr('type') == 'checkbox'){
                var html = '';
                html+='<div class="mt-4 chkError">please select correct answer</div>';
                element.parent().parent().parent().find('.checkBoxError').html(html);
            }else{
                element.parent().parent().find('.inError:first').html(error);
            }
        },
        invalidHandler: function (e, r) {
            // $("#m_form_1_msg").removeClass("m--hide").show(),mUtil.scrollTop()
            if ($(document).find('.form-control-feedback').length > 0) {
                var errorId = $('.form-control-feedback:first').attr('id');
                $("body, html").animate({
                    scrollTop: $(document).find('.form-control-feedback').first().offset().top -250 
                }, 500);
            }else if($(document).find('.chkError').length >0){
                $("body, html").animate({
                    scrollTop: $(document).find('.chkError').first().offset().top -250 
                }, 500);
            }
        },
        ignore: ":hidden",
        submitHandler: function (form) {
            // Prevent double submission
            if($('#questionId').val() != '' && $('#questionId').val() !=null){
                swal('If you change the subject of this question and if this question is used in any mock exam, this question will unlink from the Mock exam', {
                    icon: "warning",
                    title: message['sure'],
                    buttons: true,
                    dangerMode: true,
                    closeOnClickOutside: false,
                }).then((isConfirm) => {
                    if (isConfirm) {
                        if (!this.beenSubmitted) {
                            this.beenSubmitted = true;
                            form.submit();
                        }
                    }
                });
            }else{
                if (!this.beenSubmitted) {
                    this.beenSubmitted = true;
                    form.submit();
                }
            }
        },
    });
    $(document).on("click", ".add-cloze", function () {
        addCloze();
    });

    function addCloze() {
        var $clone = $(".clone-cloze").eq(0).clone();
        var k = $(document).find(".clone-cloze").length;
        k++;
        $clone.find('input').each(function () {
            if ($(this).attr('type') == 'radio') {
                $(this).attr('data-id', k + '_option_5');
                $(this).attr('data-checkbox', 'text[' + k + '][answer][5][is_correct]');
                $(this).attr('data-answer', 'text[' + k + '][answer][5][answer]');
                $(this).prop("checked", false);
                this.name = this.name.replace('no_of_option[1]', 'no_of_option[' + k + ']');
            }
            if ($(this).attr('type') == 'text') {
                this.value = '';
                $(this).removeClass("answer1");
                $(this).addClass("answer" + k);
                $(this).attr("data-selected-ans", k);
            }
            if ($(this).attr('type') == 'hidden') {
                if($(this).attr("data-flag") == 'answer'){
                    $(this).val('');
                }
            }
            this.name = this.name.replace('text[1]', 'text[' + k + ']');
            $(this).attr('data-answertype', 'answer_type_'+k);
            if ($(this).attr('type') == 'checkbox') {
                $(this).removeClass('qna1');
                $(this).addClass('qna'+k);
            }
        });
        $clone.find('textarea').each(function () {
            this.value = '';
            this.name = this.name.replace('text[1]', 'text[' + k + ']');
            $clone.find('.cke_editor_'+this.id).remove();
            this.id = this.id.replace('question_1_answer', 'question_'+k+'_answer');
            this.id = this.id.replace('explanation1', 'explanation'+k);
            // $clone.removeClass("answer1");
            // $clone.addClass("answer"+k);
        });
        var limit = 9;
        var cloze = $(document).find('#type').val();
        var questionType = $(document).find('#question_type').val();
        $clone.find('.questionInstructionLable').text("Question Instruction" + k );
        $clone.find('.questionlable').text("Question " + k + " *");
        $clone.find('.question').attr('id', "question_" + k);
        $clone.find('.questionInstruction').attr('id', "question_instruction_" + k);
        $clone.find('.m-checkbox-list').attr('id', "answer_" + k);
        $clone.find('.correctAnswers').attr('id', "answer_" + k);
        $clone.find('.answerType').attr('id','answer_type_'+k);
        $clone.find('.correctAnswers').attr('data-questionindex', k);
        $clone.find('.answerType').attr('data-index',k);
        $clone.find('.remove-cloze').attr('id', 'remove_' + k);
        $clone.find('.remove-cloze').attr('data-url', '');
        $clone.find('.remove-cloze').attr('data-question-id', '');
        $clone.find('.remove-cloze').attr('data-remove', k);
        $clone.find('#remove_' + k).show();
        $clone.find('.remove-style').removeAttr("style");
        $clone.attr('id', "text_" + k);
        $clone.find('#text_question_image_1').attr('id', 'text_question_image_' + k);
        $clone.find('#text_question_image_' + k).attr('data-id', 'q_image_preview_' + k);
        $clone.find('#text_question_image_' + k).attr('data-id', 'q_image_preview_' + k);
        $clone.find('#q_image_preview_1').attr('id', 'q_image_preview_' + k);
        $clone.find('#q_image_preview_' + k).attr('src', null);
        $clone.find('#q_image_preview_' + k).hide();
        // $clone.find('#p_ans_img_path_1').attr('id','p_ans_img_path_'+k);
        // $clone.find('#p_que_img_path_1').attr('id','p_que_img_path_'+k);
        // $clone.find('#p_full_img_path_1').attr('id','p_full_img_path_'+k);
        $clone.find('.correctAnswers').prop("checked", false);
        $clone.find('.resizeImgEditors').remove();
        // if (cloze == 3 || cloze == 2 || questionType == 2) {
            if ($('.clone-cloze').length <= limit) {
                $clone.appendTo($('.cloned_html'));
                initializeCkeditor();
            } else {
                alert('You can not add more then 10!');
            }
        // }
        $clone.find('#1_option_5').attr('id', k + '_option_5');
        i++;
    }

    $(document).on('click', ".remove-cloze", function () {
        var lastClone = $(this).attr('data-remove');
        var questionId = $(this).attr('data-question-id');
        var url = $(this).attr('data-url');
        $(document).find("div #text_" + lastClone).remove();
        var i = 1;
        $('.questionlable').each(function () {
            $(this).text('Question ' + i + '*');
            i++;
        });
    });
    $(document).on('change', '#question_type', function () {
        $("#type").val('');
        addOrRemoveMcq();
    });
    if ($('#question_type').val() == 2) {
        addOrRemoveMcq()
    }

    function addOrRemoveMcq() {
        if ($('#question_type').val() == 1) {
            var optionExists = ($('#type option[value=1]').length > 0);
            if (!optionExists) {
                $('#type').append("<option value='1'>MCQ</option>");
            }
        } else {
            $("#type option[value='1']").remove();
        }
    }
});
$('form#m_form_1').on('submit', function (event) {
    var question = $(document).find('#question-append textarea[name^="text"]');
    question.filter('textarea[name$="[question]"]').each(function () {
        $(this).rules("add", {
            noSpace: true,
            required: true,
            maxlength: rule.content_length,
            messages: {
                required: "This field is required"
            }
        });
    });
    question.filter('textarea[name$="[answer]"]').each(function () {
        $(this).rules("add", {
            // noSpace: true,
            cke_required: true,
            maxlength: rule.content_length,
            messages: {
                required: "This field is required"
            }
        });
    });
    var answer = $(document).find('#question-append input[name^="text"]');
    answer.filter('input[name$="[image]"]').each(function () {
        $(this).rules("add", {
            extension: "jpeg|png|jpg",
            messages: {
                required: "This field is required",
                extension: "Invalid file jpg,png and jpeg file types are supported",
            }
        });
    });
    answer.filter('input[name$="[answer]"]').each(function () {
        $(this).rules("add", {
            // noSpace: true,
            cke_required: true,
            maxlength: rule.text_length,
            notEqualTo: true,
            messages: {
                required: "This field is required"
            }
        });
    });
    answer.filter('input[name$="[is_correct]"]').each(function() {
        $(this).rules("add", {
            required:function(element){
                if($(document).find('#'+element.id+' input[type=checkbox]:checked').length == 0){
                    return true;
                }else{
                    $(document).find('.checkBoxError').empty();
                    return false;
                }
            },
            messages: {
                required: "select correct answer"
            }
        });
    });
    var marks = $(document).find('#question-append input[name^="text"]');
    marks.filter('input[name$="[marks]"]').each(function () {
        $(this).rules("add", {
            required: true,
            noSpace: true,
            number: true,
            maxlength: rule.mark_length,
            messages: {
                required: "This field is required"
            }
        });
    });
    if ($("#m_form_1").valid()) {
        return true;
    } else {
        return false;
    }
});
$('#question-append').on("change", "input[type=radio][name^=no_of_option]", function () {
    var dataId = $(this).attr('data-id');
    var dataName = $(this).attr('data-answer');
    var dataCheckbox = $(this).attr('data-checkbox');
    if ($(this).val() == 6 || $('#type').val() == 4 || $('#qType').val() == 4) {
        $(document).find('#' + dataId).show();
        inp = $(document).find('#' + dataId + ' .answer5').attr('name', dataName);
        chkbx = $(document).find('#' + dataId + ' .correct5').attr('name', dataCheckbox);
    } else {
        $(document).find('#' + dataId).hide();
        inp = $(document).find('#' + dataId + ' .answer5').attr('name', '');
        chkbx = $(document).find('#' + dataId + ' .correct5').attr('name', dataCheckbox);
    }
})

function readURL2(input, dataId) {
    var reader = new FileReader();
    var extension = input.files[0].name.split('.').pop().toLowerCase();
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var extension = input.files[0].name.split('.').pop().toLowerCase();
        if (extension != 'pdf') {
            reader.onload = function (e) {
                $(document).find('#' + dataId).attr('src', e.target.result);
                $(document).find('#' + dataId).css('display', 'block');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
}

$(document).on("change", ".questionImg", function () {
// $(document).find(".questionImg").change(function () {
    var dataId = $(this).attr('data-id');
    readURL2(this, dataId);
});
$('input[name="no_of_option"]:checked').val();

// for clone vr cloze
var ck = $(document).find(".clone-cloze").length;
$('#question-append').on('click', '.addMore', function () {
    var $clone = $(".clone-cloze").eq(0).clone();
    if (ck == 0 || ck == undefined) {
        var ck = $(document).find(".clone-cloze").length;
    }
    ck++;
    $clone.find('input').each(function () {
        if ($(this).attr('type') != 'hidden') {
            this.value = '';
        }
        this.name = this.name.replace('text[1][1]', 'text[1][' + ck + ']');
    });
    var j = 1;
    $clone.attr('id', 'text_' + ck);
    var i = 1;
    $('.questionlable').each(function () {
        $(this).text('Question ' + i + '*');
        i++;
    });
    $clone.find('.questionlable').text('Question ' + i + '*');
    $clone.find('.addMore').removeClass('btn-primary');
    $clone.find('.addMore i').removeClass('fa-plus');
    $clone.find('.addMore').addClass('btn-danger');
    $clone.find('.addMore i').addClass('fa-times');
    $clone.find('.addMore').addClass('remove-cloze');
    $clone.find('.addMore').removeClass('addMore');
    $clone.find('.remove-cloze').attr('id', 'remove_' + ck);
    $clone.find('.remove-cloze').attr('data-url', '');
    $clone.find('.remove-cloze').attr('data-question-id', '');
    $clone.find('.remove-cloze').attr('data-remove', ck);
    $clone.appendTo($('.cloned_html'));
});
$(document).find('#m_form_2').validate({
    rules: {
        title: {
            required: true,
            minlength: 3,
            maxlength: 50,
            noSpace:true,
            remote: {
                url: validateTitleURL,
                type: "POST",
                global: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    value: function () {
                        return $("#title").val();
                    },
                    id: function () {
                        return $("#hidden_grade_id").val();
                    },
                }
            },
        }
    },
    messages:{
        title:{
            remote:'This title already exists',
        },
    },
    ignore: [],
    errorPlacement: function (error, element) {
        error.insertAfter(element);
    },
    invalidHandler: function (e, r) {
        $("#m_form_1_msg").removeClass("m--hide").show(),
            mUtil.scrollTop()
    },
    submitHandler: function (form) {
        $(document).find('.saveTopic').prop('disabled', true);
        $(document).find('.saveTopic').val('Please Wait..');
        // form.submit();
        $.ajax({
            url: actionUrl,
            data: $('#m_form_2').serialize(),
            type: 'POST',
            success: function (response) {
                $(document).find('.saveTopic').prop('disabled', false);
                $(document).find('.saveTopic').val('Submit');
                if (response.status == 'success') {
                    $('#m_modal_1').modal('hide');
                    $('#m_form_2').trigger("reset");
                    $('#topicId').find('option').remove().end();
                    $.each(response.topicData, function (key, value) {
                        $('#topicId').append($("<option></option>")
                            .attr("value", key)
                            .text(value));
                    });
                }
            },
            error: function (response) {
            },
        })
    }
});
function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}
$('#question-append').on('change','.answerType',function(){
    var index = $(this).attr('data-index');
    if($(this).val()==1){
        $('.qna'+index).prop('checked',false);
    }
})
function initializeCkeditor(){
    var buttons = "Maximize,ShowBlocks,oembed,MediaEmbed,Save,DocProps,Print,Templates,document,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,Anchor,CreatePlaceholder,Image,Flash,button1,button2,button3,About"
    CKEDITOR.plugins.addExternal('ckeditor_wiris', 'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/plugins/ckeditor_wiris/', 'plugin.js');
	// CKEDITOR.plugins.addExternal('image2', 'https://cdn.ckeditor.com/4.16.1/standard-all/plugins/image2/plugin.js');

    $(document).find('.qckeditor').each(function(e){
        CKEDITOR.replace( this.id,{
            useCapture: true,
            className:'form-control',
            removeButtons: buttons,//'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord',
            on: {
                    focus: function (instance) {
                        $("#" + instance.editor.id + "_top").show();
                    },
                    blur: function (instance) {
                        $("#" + instance.editor.id + "_top").hide();
                    },
                    keyup: CK_jQ,
                    paste: CK_jQ,
                    change: CK_jQ,
            },
        });
    });
    $(document).find('.ckeditor').each(function(e){
        CKEDITOR.replace( this.id,{
            useCapture: true,
            className:'form-control',
            height : 35,
            removeButtons: buttons,//'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord',
            on: {
                    focus: function (instance) {
                        $("#" + instance.editor.id + "_top").show();
                    },
                    blur: function (instance) {
                        $("#" + instance.editor.id + "_top").hide();
                    },
                    keyup: CK_jQ,
                    paste: CK_jQ,
                    change: CK_jQ,
            },
        });
    });
    $(document).find('.explanationEditor').each(function(e){
        CKEDITOR.replace( this.id,{
            useCapture: true,
            className:'form-control',
            height : 35,
            removeButtons: buttons,//'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord',
            on: {
                    focus: function (instance) {
                        $("#" + instance.editor.id + "_top").show();
                    },
                    blur: function (instance) {
                        $("#" + instance.editor.id + "_top").hide();
                    },
                    keyup: CK_jQ,
                    paste: CK_jQ,
                    change: CK_jQ,
            },
        });
    });
    $(document).find('.imgCkeditor').each(function(e){
        CKEDITOR.replace( this.id,{
            extraPlugins:'image2',
            // filebrowserUploadUrl: imgUpload,
            // filebrowserUploadMethod: 'form',
            useCapture: true,
            className:'form-control',
            height : 350,
            removeButtons: buttons,
            autoParagraph: false,
            ignoreEmptyParagraph: true,
            removeDialogTabs : 'image:advanced;image:Link',
            on: {
                    focus: function (instance) {
                        // $("#" + instance.editor.id + "_top").show();
                        $("#" + instance.editor.id + "_top").hide();
                    },
                    blur: function (instance) {
                        $("#" + instance.editor.id + "_top").hide();
                    },
                    keyup: CK_jQ,
                    paste: CK_jQ,
                    change: CK_jQ,
                    key: ckeditorKeyPress
            },
        });
    });
    function ckeditorKeyPress(event){
        if (event.keyCode == 8 || event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39) {
        }else{ 
            event.cancel();
            event.stop();
        }
    }
    // CKEDITOR.config.removePlugins = "dialogui,dialog,a11yhelp,about,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu,contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,richcombo,font,format,forms,horizontalrule,htmlwriter,iframe,indent,indentblock,indentlist,justify,magicline,maximize,newpage,pagebreak,pastefromword,pastetext,preview,print,removeformat,resize,save,menubutton,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table";
    CKEDITOR.config.startupFocus = false;
    CKEDITOR.config.resize_enabled = true;
    CKEDITOR.config.autoParagraph = false;
    CKEDITOR.config.extraPlugins = 'autogrow,ckeditor_wiris';
    CKEDITOR.config.autoGrow_minHeight = 50;
    CKEDITOR.config.autoGrow_maxHeight = 300;
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.on("instanceReady", function (ev) {
        $.each(CKEDITOR.instances, function (instance) {
            $("#" + CKEDITOR.instances[instance].id + "_top").hide();
            $("#" + CKEDITOR.instances[instance].id + "_bottom").hide();
        });
    });
}
jQuery.validator.addMethod("cke_required",function (value, element) {
    var idname = element.id;
    var editor = CKEDITOR.instances[idname];
    var flag = false;
    $(element).val(editor.getData());
    if(element.name.includes('answer')){
        editor2 = CKEDITOR.instances['p_ans_img_path'];
        if($(element).val().length > 0 || data.length > 0){
            return true;
        }
        return false;
    }else{
        if($(element).val().length > 0){
            return true;
        }
        return false;
    }
    return flag;
},"This field is required");
$('#m_form_3').validate({
    rules:{
        question_no:{
            required:true,
        },
        question:{
            required:true,
        },
        // q_topic:{
        //     required:true,
        // },
        marks:{
            required:true,
        },
        'no_of_option[0]':{
            required:true,
        },
        answer_type:{
            required:true,
        },
    },
    errorPlacement:function(error,element){
        if(element.attr('name').includes('answer')){
            error.insertAfter(element.parent().find('.inError'));
        }else{
            error.insertAfter(element);
        }
    },
    // submitHandler: function (form) {
    //     if (!this.beenSubmitted) {
    //         this.beenSubmitted = true;
    //         form.submit();
    //     }
    // }
})
$(document).find('#m_form_3').on('submit', function(){
    var answer = $(document).find('textarea[name^="text"]');
    answer.filter('textarea[name$="[answer]"]').each(function () {
        $(this).rules("add", {
            // noSpace: true,
            cke_required: true,
            maxlength: rule.content_length,
            messages: {
                required: "This field is required"
            }
        });
    });
    var answer2 = $(document).find('textarea[name^="text"]');
    answer2.filter('input[name$="[is_correct]"]').each(function() {
        $(this).rules("add", {
            required:function(element){
                if($(document).find('#'+element.id+' input[type=checkbox]:checked').length == 0){
                    return true;
                }else{
                    $(document).find('.checkBoxError').empty();
                    return false;
                }
            },
            messages: {
                required: "select correct answer"
            }
        });
    });
    if ($("#m_form_3").valid()) {
        return true;
    } else {
        return false;
    }
})