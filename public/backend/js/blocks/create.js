$(document).ready(function () {
    $(document).find('#price').keypress(function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            sub_title: {
                required: function (element) {
                    if(slug != CONSTANT_VARS.blocks.home.all_subjects && slug != CONSTANT_VARS.blocks.home.exam_formats && slug != CONSTANT_VARS.blocks.home.exam_styles) {
                        return true;
                    } else {
                        return false;
                    }
                },
                maxlength: CONSTANT_VARS.input_title_max_length,
            },
            subject_title_1: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_2: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_3: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_4: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_1_content: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_2_content: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_3_content: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            subject_title_4_content: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.all_subjects) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            content: {
                required:true,
            },
            note: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.banner_section || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            exam_format_title_1: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.exam_formats || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            exam_format_title_1_content: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.exam_formats || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            exam_format_title_2: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.exam_formats || slug == CONSTANT_VARS.blocks.about_us.mind_behind_scene) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
            exam_format_title_2_content: {
                required: function (element) {
                    if(slug == CONSTANT_VARS.blocks.home.exam_formats) {
                        return true;
                    } else {
                        return false;
                    }
                },
            },
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "content")
                error.insertAfter(".contentError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            mUtil.scrollTop();
        },
        submitHandler: function (form) {
            // Prevent double submission
            if (!this.beenSubmitted) {
                this.beenSubmitted = true;
                form.submit();
            }
        },
    });
    function readURL(input,id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInput1").change(function () {
        $('#blah').show();
        readURL(this,'#blah');
    });
    $("#imgInput2").change(function () {
        $('#blah2').show();
        readURL(this,'#blah2');
    });
    $("#imgInput3").change(function () {
        $('#blah3').show();
        readURL(this,'#blah3');
    });
    $("#imgInput4").change(function () {
        $('#blah4').show();
        readURL(this,'#blah4');
    });
    $("#imgInput5").change(function () {
        $('#blah5').show();
        readURL(this,'#blah5');
    });
    $("#imgInput6").change(function () {
        $('#blah6').show();
        readURL(this,'#blah6');
    });
});
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

if($('#slide1title').length >0)
    CKEDITOR.replace('slide1title');
if($('#slide2title').length >0)
    CKEDITOR.replace('slide2title');
if($('#slide3title').length >0)
    CKEDITOR.replace('slide3title');
if($('#slide1subtitle').length >0)
    CKEDITOR.replace('slide1subtitle');
if($('#slide2subtitle').length >0)
    CKEDITOR.replace('slide2subtitle');
if($('#slide3subtitle').length >0)
    CKEDITOR.replace('slide3subtitle');
if($('#slider1description').length >0)
    CKEDITOR.replace('slider1description');
if($('#slide2description').length >0)
    CKEDITOR.replace('slide2description');
if($('#slide3description').length >0)
    CKEDITOR.replace('slide3description');
if($('#eslide1title').length >0)
    // CKEDITOR.replace('eslide1title');
if($('#eslider1description').length >0)
    // CKEDITOR.replace('eslider1description');


// if(slug == CONSTANT_VARS.blocks.ePaper.home.exam_formats) {
//     CKEDITOR.replace('exam_format_title_1_content');
//     CKEDITOR.replace('exam_format_title_2_content');
// } else if(slug == CONSTANT_VARS.blocks.ePaper.about_us.mind_behind_scene) {
//     CKEDITOR.replace('subject_title_1_content');
//     CKEDITOR.replace('subject_title_2_content');
//     CKEDITOR.replace('subject_title_3_content');
//     CKEDITOR.replace('editor1');
// } else {
//     CKEDITOR.replace('editor1');
// }
if($('#practiceHelpSection').length >0){
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('content_1');
    CKEDITOR.replace('content_2');
    CKEDITOR.replace('content_3');
    CKEDITOR.replace('content_4');
}
if($('#practicePaySection').length >0){
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('content_1');
    CKEDITOR.replace('content_2');
    CKEDITOR.replace('content_3');
    CKEDITOR.replace('content_4');
}

if($('#practiceModuleSection').length >0){
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('content_1');
    CKEDITOR.replace('content_2');
    CKEDITOR.replace('content_3');
    CKEDITOR.replace('content_4');
}

if($('#practiceAboutSection').length >0){
    CKEDITOR.replace('editor1');
}
CKEDITOR.config.removePlugins = 'image';
