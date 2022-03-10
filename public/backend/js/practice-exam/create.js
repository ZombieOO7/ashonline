$(document).ready(function () {
    /* Form validation */
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                maxlength: rule.name_length,
                noSpace: true,
            },
            description: {
                required: true,
                maxlength: rule.content_length,
                noSpace: true,
            },
            exam_board_id:{
                required: true,
            },
            grade_id:{
                required: true,
            },
            'subject_id':{
                required: true,
            },
            topic_id:{
                required: true,
            },
            status: {
                required: true,
            },
        },
        ignore: [],
        errorPlacement: function (error, element) {
            $('.errors').remove();
            var elementName = '';
            if (element.attr("name") == "description")
                error.insertAfter(".descriptionError");
            else if(element.attr("name") == "subject_ids[]")
                error.insertAfter(".subjectError");
            else if(element.attr("name") == "price")
                error.insertAfter(".priceError");
            else if(element.attr("name") == "image_id")
                error.insertAfter(".imageError");
            else{
                error.insertAfter(element);
            }

            if(element.attr("name").indexOf('time') != -1){
                elementValue = $('input[name="'+element.attr('name')+'"]').val();
                if(parseInt(elementValue) < 10 && elementValue !=''  && elementValue != undefined){
                    $(element).next("div").remove();
                    $('.'+element.attr('id')).empty();
                    var html= '';
                    html='<div class="text-danger" style="font-size:.85rem;">Please enter greater than 10 minutes</div>';
                    $('.'+element.attr('id')).html(html);
                }else{
                    $('.'+element.attr('id')).empty();
                }
            }
        },
        invalidHandler: function (e, r) {
            console.log(e);
            console.log(r);
            // $("#m_form_1_msg").removeClass("m--hide").show(),mUtil.scrollTop()
            if($(document).find('.form-control-feedback').length >0){
                var errorId = $('.form-control-feedback:first').attr('id');
                setTimeout(function(){
                    $("body, html").animate({
                        scrollTop: $(document).find('.form-control-feedback').first().offset().top -250
                    }, 500);
                },200);
            }
            else if($(document).find('.text-danger').length >0){
                setTimeout(function(){
                    $("body, html").animate({
                        scrollTop: $(document).find('.text-danger').first().offset().top -250
                    }, 500);
                },100);
            }
        },
    });
    // validation rules for multidimension array inputs
    $('form#m_form_1').on('submit', function(event) {
        var time = $(document).find('#subjectTestDetails input[name^="test_detail"]');
        time.filter('input[name$="[time]"]').each(function() {
            $(this).rules("add", {
                required: true,
                number:true,
                min:10,
                messages: {
                    required: "This field is required",
                    min:" Please enter greater than 10 minutes",
                }
            });
        });

        var questions = $(document).find('#subjectTestDetails input[name^="test_detail"]');
        questions.filter('input[name$="[questions]"]').each(function() {
            $(this).rules("add", {
                required: true,
                number: true,
                messages: {
                    required : 'This field is required',
                }
            });
        });

        var subjectQuestions = $(document).find('#subjectTestDetails input[name^="subject"]');
        subjectQuestions.filter('input[name$="[question_ids]"]').each(function(k,v) {
            var data = $(this).attr('name');
            var values = $(this).val().split(',');
            var question = data.replace('question_ids','questions');
            var question = question.replace('subject','test_detail');
            var questionVal = Number($(document).find('input[name="'+question+'"]').val());
            $(this).rules("add", {
                required: true,
                max:function(){
                    if (values.length != questionVal){
                        return parseInt(questionVal);
                    }
                },
                messages: {
                    required : 'select questions',
                    max: 'Please select '+questionVal+' question',
                    min: 'Please select '+questionVal+' question',
                }
            });
        });

        var questions = $(document).find('#subjectTestDetails input[name^="test_detail"]');
        questions.filter('input[name$="[report_question]"]').each(function(k,v) {
            var data = $(v).attr('name');
            var question = data.replace('report_question','questions');
            var questionVal = Number($(document).find('input[name="'+question+'"]').val());
            $(this).rules("add", {
                required: true,
                number: true,
                max:function(){
                    return parseInt(questionVal);
                },
                messages: {
                    required : 'This field is required',
                    max: 'Please enter a value less than '+questionVal,
                }
            });
        });

        var duration = $(document).find('input[name^="data"]');
        duration.filter('input[name$="[duration]"]').each(function(k,v) {
            var data = $(v).attr('id');
            value = $(document).find('#'+data).val();
            $(this).rules("add", {
                max:15,
                messages: {
                    max : 'audio duration should be not greater then 15 seconds',
                }
            });
        });

        if($(document).find("#m_form_1").valid()){
            if($(document).find("#m_form_1").valid()){
                return true;
            } else {
                return false;
            }
        } else {
            if($(document).find("#m_form_1").valid()){
                return true;
            } else {
                return false;
            }
        }
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            $('#blah').css('display', 'block');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// CKEDITOR
CKEDITOR.on('instanceReady', function() {
    $.each(CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
        CKEDITOR.instances[instance].document.on("paste", CK_jQ);
        CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
        CKEDITOR.instances[instance].document.on("blur", CK_jQ);
        CKEDITOR.instances[instance].document.on("change", CK_jQ);
    });
});

CKEDITOR.editorConfig = function( config ) {
    config.allowedContent = true;
};

function CK_jQ() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}
CKEDITOR.replace('editor1');
// CKEDITOR.replace('editor2');
// CKEDITOR.replace('editor3');
CKEDITOR.config.removePlugins = 'image';

var id = $('select[name=exam_board_id]').val();
if(id == 3){
    $(document).find('.superSelective').show();
}else{
    $(document).find('.superSelective').hide();
}

$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')}
});
var j = $('.cloneAudioData').length;
$(document).find('.addMoreAudio').on('click',function(){
    j++;
    var cloneData = $(document).find('.cloneAudioData').eq(0).clone();
    cloneData.find('.fa-plus').removeClass('fa-plus').addClass('fa-times');
    cloneData.find('.btn-brand').removeClass('btn-brand').addClass('btn-danger');
    cloneData.find('.addMoreAudio').removeClass('addMoreAudio').addClass('removeAudio');
    cloneData.find('.audioInput').remove();
    cloneData.find('input').each(function() {
        this.value = '';
        this.name= this.name.replace('[0]', '['+j+']');
    });
    cloneData.find('select').each(function() {
        this.value = '';
        this.name= this.name.replace('[0]', '['+j+']');
    });
    $('#audioHtml').append(cloneData);
})
$(document).find('#audioHtml').on('click','.removeAudio',function(){
    $(this).parent().parent().remove();
})
$(document).find('.removeAudio').on('click',function(){
    $(this).parent().parent().remove();
})
var objectUrl;
$("#begningIntervalFile").change(function(e){
    var file = e.currentTarget.files[0];
    objectUrl = URL.createObjectURL(file);
    $("#audio1").prop("src", objectUrl);
});
$("#audio1").on("canplaythrough", function(e){
    var seconds = e.currentTarget.duration;
    var duration = moment.duration(seconds, "seconds");
    var seconds = 0;
    if (duration.hours() > 0) {
        seconds = duration.hours()*3600;
    }
    if( duration.minutes() > 0){
        minute = duration.minutes()*60;
        seconds = seconds+minute;
    }
    if(duration.seconds() >0){
        seconds = seconds + duration.seconds();
    }
    $("#begningIntervalDuration").val(seconds);
    $(this).parent().find('.text-danger').remove();
    var html = '';
    if(seconds > 15){
        html +='<div class="text-danger">audio duration should be not greater then 15 seconds</div>';
        $(html).insertAfter('#begningIntervalFileError');
    }else{
        $(html).insertAfter('#begningIntervalFileError');
    }
    URL.revokeObjectURL(objectUrl);
});
$("#endIntervalFile").change(function(e){
    var file = e.currentTarget.files[0];
    objectUrl = URL.createObjectURL(file);
    $("#audio3").prop("src", objectUrl);
});
$("#audio3").on("canplaythrough", function(e){
    var seconds = e.currentTarget.duration;
    var duration = moment.duration(seconds, "seconds");
    var seconds = 0;
    if (duration.hours() > 0) {
        seconds = duration.hours()*3600;
    }
    if( duration.minutes() > 0){
        minute = duration.minutes()*60;
        seconds = seconds+minute;
    }
    if(duration.seconds() >0){
        seconds = seconds + duration.seconds();
    }
    $("#endIntervalDuration").val(seconds);
    $(this).parent().find('.text-danger').remove();
    var html = '';
    if(seconds > 15){
        html +='<div class="text-danger">audio duration should be not greater then 15 seconds</div>';
        $(html).insertAfter('#endIntervalDurationError');
    }else{
        $(html).insertAfter('#endIntervalDurationError');
    }
    URL.revokeObjectURL(objectUrl);
});
var objectUrl;
$("#halfFile").change(function(e){
    var file = e.currentTarget.files[0];
    objectUrl = URL.createObjectURL(file);
    $("#audio2").prop("src", objectUrl);
});
$("#audio2").on("canplaythrough", function(e){
    var seconds = e.currentTarget.duration;
    var duration = moment.duration(seconds, "seconds");
    var seconds = 0;
    if (duration.hours() > 0) {
        seconds = duration.hours()*3600;
    }
    if( duration.minutes() > 0){
        minute = duration.minutes()*60;
        seconds = seconds+minute;
    }
    if(duration.seconds() >0){
        seconds = seconds + duration.seconds();
    }
    $("#halfDuration").val(seconds);
    $(this).parent().find('.text-danger').remove();
    var html = '';
    if(seconds > 15){
        html +='<div class="text-danger">audio duration should be not greater then 15 seconds</div>';
        $(html).insertAfter('#halfDurationError');
    }else{
        $(html).insertAfter('#halfDurationError');
    }
    URL.revokeObjectURL(objectUrl);
});
$("#lastFile").change(function(e){
    var file = e.currentTarget.files[0];
    objectUrl = URL.createObjectURL(file);
    $("#audio4").prop("src", objectUrl);
});
$("#audio4").on("canplaythrough", function(e){
    var seconds = e.currentTarget.duration;
    var duration = moment.duration(seconds, "seconds");
    var seconds = 0;
    if (duration.hours() > 0) {
        seconds = duration.hours()*3600;
    }
    if( duration.minutes() > 0){
        minute = duration.minutes()*60;
        seconds = seconds+minute;
    }
    if(duration.seconds() >0){
        seconds = seconds + duration.seconds();
    }
    $("#lastDuration").val(seconds);
    $(this).parent().find('.text-danger').remove();
    var html = '';
    if(seconds > 15){
        html +='<div class="text-danger">audio duration should be not greater then 15 seconds</div>';
        $(html).insertAfter('#lastDurationError');
    }else{
        $(html).insertAfter('#lastDurationError');
    }
    URL.revokeObjectURL(objectUrl);
});
$('#begningIntervalAudioRemove').on('click',function(){
    $('#begningIntervalAudio').remove();
    $('input[name="data[0][stored_audio_name]"]').val('');
    $(this).hide();
})
$('#endIntervalAudioRemove').on('click',function(){
    $('#endIntervalAudio').remove();
    $('input[name="data[1][stored_audio_name]"]').val('');
    $(this).hide();
})
$('#halfDurationAudioRemove').on('click',function(){
    $('#halfDurationAudio').remove();
    $('input[name="data[2][stored_audio_name]"]').val('');
    $(this).hide();
})
$('#lastDurationAudioRemove').on('click',function(){
    $('#lastDurationAudio').remove();
    $('input[name="data[3][stored_audio_name]"]').val('');
    $(this).hide();
})