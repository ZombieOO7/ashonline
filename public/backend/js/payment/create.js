$(document).ready(function () {
    $("#m_form_1").validate({
        rules: {
            'title': {
                required: true
            },
            'paper_category_id': {
                required: true,
            },
        },
        
        ignore: [],
        errorPlacement: function (error, element) {
            if (element.attr("name") == "paper_category_id")
                error.insertAfter(".paperCategoryError");
            else
                error.insertAfter(element);
        },
        invalidHandler: function (e, r) {
            $("#m_form_1_msg").removeClass("m--hide").show(),
                mUtil.scrollTop()
        },
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imgInp").change(function () {
        readURL(this);
    });
}); 