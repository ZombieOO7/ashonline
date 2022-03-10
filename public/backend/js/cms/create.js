jQuery.validator.addMethod("cke_required", function (value, element) {
    var idname = $(element).attr('id');
    var editor = CKEDITOR.instances[idname];
    editor_val = $(element).val(editor.getData());
    if (editor_val != "" && editor_val != "" && jQuery.trim(editor_val).length != 0){
        return false;
    }else{
        return true;
    }
}, "This field is required");
$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            title: {
                required: true,
                noSpace: true,
            },
            content: {
                required: true,
                noSpace: true,
                // cke_required : true,
            },
            short_description:{
                // required: true,
                // noSpace: true,
            },
            exam_style:{
                required: true,
                noSpace: true,
                // cke_required : true,
            },
            logo_file:{
                required: function (element) {
                    if ($("#logoImg").attr('src') != "") {
                        return false;
                    } else {
                        return true;
                    }
                },
                // noSpace: true,
            },
            // 'name':{
            //     required: function (element) {
            //         if ($("#blah").attr('src') != "") {
            //             return false;
            //         } else {
            //             return true;
            //         }
            //     },
            //     extension: "jpg|jpeg|png"
            // },
            name: {
                required: function (element) {
                    if ($("#blah").attr('src') != "" || $('#image_id').val() != "") {
                        return false;
                    } else {
                        return true;
                    }
                },
                extension: "jpg|jpeg|png"
            },
            image_id: {
                required: function (element) {
                    if ($("#blah").attr('src') != "" || $('#image_id').val() != "") {
                        return false;
                    } else {
                        return true;
                    }
                },
            },
            school_id:{
                required: true,
                noSpace: true,
            }
        },
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "content")
                error.insertAfter(".contentError");
            else if (element.attr("name") == "exam_style")
                error.insertAfter(".examStyleError");
            else if(element.attr("name") == "short_description")
                error.insertAfter(".shrtDescError");
            else if(element.attr("name") == "image_id")
                error.insertAfter(".imageError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            // $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
});
//deal with copying the ckeditor text into the actual textarea
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

CKEDITOR.replace('editor');
CKEDITOR.replace('editor1');
CKEDITOR.replace('editor2');
function readURL(input,imgId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(imgId).show();
            $(imgId).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imgInp").change(function () {
    readURL(this,'#blah');
});
$("#logoInp").change(function () {
    readURL(this,'#logoImg');
});

$('#school_id').on('change',function(){
    var school_id = $(this).val();
    $('#mock_test_id').empty().selectpicker('refresh');
    if(school_id != null && school_id != '' && school_id !=undefined){
        $.ajax({
            url:mockUrl,
            type:'POST',
            data:{
                school_id:school_id,
            },
            global:false,
            success:function(response){
                $('#mock_test_id').empty().selectpicker('refresh');
                $.each(response.mockTests, function(value,key){
                    $('#mock_test_id').append('<option value="'+value+'">'+key+'</option>')
                });
                $('#mock_test_id').selectpicker("refresh");
            },
            error:function(){

            }
        })
    }
})
