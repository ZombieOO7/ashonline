
$(document).ready(function () {
    $('.deleteQuestion').on('click',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
        });
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        var msg = $(this).attr('data-msg');
        var mock_test_id = $(this).attr('data-mock_test_id');
        swal({
            title:'Are you sure?',
            text:msg,
            icon:'warning',
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    method: "DELETE",
                    data: { id: id, mock_test_id:mock_test_id},
                    success: function (response) {
                        swal(response['msg'], {
                            icon: response['icon'],
                            closeOnClickOutside: false,
                        });
                        window.location.reload();
                    }
                });
            }
        });
    })
    jQuery.validator.addMethod("cke_required",function (value, element) {
            var idname = $(element).attr("id");
            var editor = CKEDITOR.instances[idname];
            $(element).val(editor.getData());
            return $(element).val().length > 0;
    }, "This field is required");

    jQuery.validator.addMethod("minTime",function (value, element) {
        var name = $(element).attr("name");
        var minutes = name.replace('seconds', 'minutes');
        var minuteVal = $('select[name="'+minutes+'"]').val();
        var hours = name.replace('seconds', 'hours');
        var hoursVal = $('select[name="'+hours+'"]').val();
        if(parseInt(hoursVal) > 0){
            value = hoursVal;
            return parseInt(value) >= 1;
        }else if(parseInt(minuteVal) > 0){
            value = minuteVal;
            return parseInt(value) >= 1;
        }else if(element.value < 10){
            value = $(element).val();
            return parseInt(value) >= 5;
        }
        return parseInt(value) >= 5;
    }, "Please select second grater than or equal 5 seconds.");
    jQuery.validator.addMethod("minMinutes",function (value, element) {
        var name = $(element).attr("name");
        var minutes = name.replace('seconds', 'minutes');
        var minuteVal = $('select[name="'+minutes+'"]').val();
        var hours = name.replace('seconds', 'hours');
        var hoursVal = $('select[name="'+hours+'"]').val();
        if(parseInt(hoursVal) > 0){
            value = hoursVal;
            return parseInt(value) >= 1;
        }else if(parseInt(minuteVal) > 10){
            value = minuteVal;
            return parseInt(value) >= 10;
        }
        return parseInt(value) >= 10;
    }, "Please select second grater than or equal 10 Minutes.");
    $(document).on('click','.shw-dsc',function(e) {
        $(document).find('.show_desc').html($(this).attr('data-description'));
        $(document).find('.mdl_ttl').html($(this).attr('data-title'));
    });
    $(document).find('.cd-stts').on('click',function(){
        if($(this).attr('data-status') == 1) {
            $("#tggl-clss").removeClass('fas fa-toggle-on');
            $("#tggl-clss").addClass('fas fa-toggle-off');
            $(this).attr('data-status',0);
            $(document).find('#hidden_code_status').val(0);
        } else {
            $("#tggl-clss").removeClass('fas fa-toggle-off');
            $("#tggl-clss").addClass('fas fa-toggle-on');
            $(this).attr('data-status',1);
            $(document).find('#hidden_code_status').val(1);
        }
    });

    // $("#imgInput").change(function () {
    //     readURL(this);
    // });
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

$("#start_date").datepicker({
    // startDate: new Date(),
    autoclose: true,
    todayHighlight: true,
    format: 'dd-mm-yyyy',
}).on('changeDate', function (selected) {
    var minDate = new Date(selected.date.valueOf());
    var maxDate = new Date(selected.date.getFullYear(),7,31);
    if(selected.date > maxDate){
        var minDate = new Date(selected.date.getFullYear()+1,7,01);
        var maxDate = new Date(selected.date.getFullYear()+1,7,31);
    }
    $('#end_date').datepicker('setStartDate', minDate);
    $('#end_date').datepicker('setEndDate', maxDate);
    $('#end_date').datepicker('setDate',new Date(minDate));
});

$("#end_date").datepicker({
    startDate: $("#start_date").val(),
    autoclose: true,
    todayHighlight: true,
    format: 'dd-mm-yyyy',
}).on('changeDate', function (selected) {
    var maxDate = new Date(selected.date.valueOf());
    $('#start_date').datepicker('setStartDate', new Date());
});



var id = $('select[name=exam_board_id]').val();
if(id == 3){
    $(document).find('.superSelective').show();
}else{
    $(document).find('.superSelective').hide();
}

$(document).find('select[name=exam_board_id]').change(function(e){
    var id = $(this).val();
    if(id == 3){
        $(document).find('.superSelective').show();
        // $(document).find('select[name="subject_ids[]"]').attr('multiple','true');
        // $(document).find('select[name="subject_ids[]"]').selectpicker('destroy');
        // $(document).find('select[name="subject_ids[]"]').selectpicker();
        // $(document).find('select[name="subject_ids[]"]').trigger('change');
    }else{
        $(document).find('.superSelective').hide();
    //     $(document).find('select[name="subject_ids[]"]').removeAttr('multiple');
    //     $(document).find('select[name="subject_ids[]"]').selectpicker('destroy');
    //     $(document).find('select[name="subject_ids[]"]').selectpicker();
    }
});

$(document).find('select[name=school_id]').change(function(e){
    var isMultiple = $('option:selected', this).attr('data-is_multiple');
    if(isMultiple == 1){
        $(document).find('select[name="subject_ids[]"]').attr('multiple','true');
        $(document).find('select[name="subject_ids[]"]').selectpicker('destroy');
        $(document).find('select[name="subject_ids[]"]').selectpicker();
        $(document).find('select[name="subject_ids[]"]').trigger('change');
    }else{
        $(document).find('select[name="subject_ids[]"]').removeAttr('multiple');
        $(document).find('select[name="subject_ids[]"]').selectpicker('destroy');
        $(document).find('select[name="subject_ids[]"]').selectpicker();
    }
    $(document).find('select[name="subject_ids[]"]').selectpicker('refresh');
    $(document).find('#subjectTestDetails').empty();
});

if(id==''){
    $(document).find('select[name=grade_id]').val(6);
}
var selectedQuestionIds = {};
$(document).find('select[name="subject_ids[]"]').change(function(){
    selectedQuestionIds = {};
    var subjectIds = $(this).val();
    // var examBoardId = $('select[name=exam_board_id]').val();
    var isMultiple = $('option:selected', 'select[name=school_id]').attr('data-is_multiple');
    if($('select[name=exam_board_id]').val() != 3){
        var isMultiple = 0;
    }
    if(subjectIds != '' && subjectIds != undefined){
        $.ajax({
            url:subjectUrl,
            type:'POST',
            data:{
                isMultiple: isMultiple,
                subject_ids:subjectIds,
            },
            dataType:'html',
            global:true,
            success:function(response){
                $(document).find('#subjectTestDetails').empty().html(response);
            },
            error:function(){
    
            }
        })
    }else{
        $(document).find('#subjectTestDetails').empty();
    }
})
var limit;
$(document).find('#subjectTestDetails').on('click', '.addQuestion', function() {
    var subjectId = $(this).attr('data-subject-id');
    var dataLimit = $(this).attr('data-limit');
    stageId = $(document).find('input[name="stage_id"]:checked').val();
    questionType = null;
    if(stageId==1){
        $('#questionFilter').hide();
        questionType = 1;
    }else{
        $('#questionFilter').show();
    }
    limit = Number($('input[name="'+dataLimit+'"]').val());
    $('#m_modal_1').modal('show');
    var table = $('#question_table').DataTable();
    table.destroy();
    $('#m_modal_1 input[name=questionSubjectId]').val(subjectId);
    $('#m_modal_1 input[name=questionSubjectId]').attr('id',subjectId);
    setDataTable(subjectId,id,questionType);
})
$(document).find('#getIds').click(function(){
    var subjectId = $(document).find('input[name=questionSubjectId]').val();
    var questionIds = {};
    if(stageId == parseInt($('input[name=stage_id]:checked').val())){
        selectedQuestionIds.subjectId = [];
    }
    $('.questionCheckbox:checked').each(function () {
        // questionIds.push($(this).val());
        selectedQuestionIds.subjectId.push($(this).val());
    });
    questionIds = selectedQuestionIds.subjectId;
    questionIds =   questionIds.filter(function(itm, i, questionIds) {
                        return i == questionIds.indexOf(itm);
                    });
    if(questionIds.length != limit){
        if(limit > 1){
            questions = ' questions';
        }else{
            questions = ' question';
        }
        swal({
            text: 'Please select '+limit+questions,
            icon: "info",
            closeOnClickOutside: false,
        });
        return false;
    }
    $(document).find('#questionId-'+subjectId).val(questionIds);
    $('#m_modal_1').modal('hide');
})

$(document).find('#questionList').on('change', 'input.questionCheckbox', function() {
    var subjectId = $(document).find('input[name=questionSubjectId]').val();
    if(selectedQuestionIds.subjectId == undefined){
        selectedQuestionIds.subjectId = [];
    }
    if($('.questionCheckbox:checked').length >= (limit+1) && $(this).prop('checked')==true) {
        this.checked = false;
    }else{

        if($(this).prop('checked')==true){
            selectedQuestionIds.subjectId.push($(this).val());
            questionIds = selectedQuestionIds.subjectId;
            questionIds =   questionIds.filter(function(itm, i, questionIds) {
                                return i == questionIds.indexOf(itm);
                            });
        }else{
            questionIds = selectedQuestionIds.subjectId;
            questionIds =   questionIds.filter(function(itm, i, questionIds) {
                                return i == questionIds.indexOf(itm);
                            });
            var remove_Item = $(this).val();
            selectedQuestionIds.subjectId = $.grep(selectedQuestionIds.subjectId, function(value) {
                return value != remove_Item;
            });
        }
    }
});
$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content')}
});
$(document).find('#questionFilter').on('change',function(){
    table = $('#question_table').DataTable();
    if($(this).val()!=null && $(this).val() !=''){
        var questionType = $("#questionFilter option:selected").text();
        table.column(3).search(questionType).draw();
    }else{
        table.column(3).search('').draw();
    }
})
function setDataTable(subjectId,id,questionType=null){
    table = $('#question_table').DataTable({
        dom: 'trilp',
       // stateSave: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url : getQuestionList,
            type: "POST",
            data:{
                subject_id:subjectId,
                mock_test_id:id,
                question_type:questionType
            },
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "aaSorting": [],
        "order": [[1, "desc"]],
        "columns": [{
            "data": "checkbox",
            orderable: false,
            searchable: false
        },
        {
            "data": "question_title"
        },
        {
            "data" : "topic"
        },
        {
            "data" : "question_type"
        },
        {
            "data": "type"
        },
        ],
        "search": {
            "regex": true
        },

        "initComplete": function () {
            var r = $('#question_table tfoot tr');
            $('#question_table thead').append(r);
            this.api().columns().every(function (i) {
                var column = this;
                r.find(' td:first-child').css('visibility', 'hidden');
                r.find(' td:last-child').css('visibility', 'hidden');
                if (i == 5) {
                    $('select', this.footer()).on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                } else {
                        var title = $('#question_table thead th').eq(this.index()).text();
                        var input = "<input type='text' class='form-control form-control-sm search_field_font' placeholder=" + title + ">";
                        $(input).appendTo($(column.footer()).empty())
                        .on('keyup change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                }
                var subjectId = $(document).find('input[name=questionSubjectId]').val();
                selectedQuestionIds.subjectId = [];
                var selectedIds = $(document).find('input[name="subject['+subjectId+'][question_ids]"]').val();

                if(selectedIds.length > 1){
                    selectedIds = selectedIds.split(',');
                    $.each(selectedIds, function(k, value){
                        $('.questionCheckbox').each(function () {
                            var val = $(this).val();
                            if(val == value){
                                $(this).attr('checked',true);
                            }
                            selectedQuestionIds.subjectId.push(value);
                        });
                    });
                }else{
                    $('.questionCheckbox').each(function () {
                        var val = $(this).val();
                        if(selectedIds == val){
                            $(this).attr('checked',true);
                            selectedQuestionIds.subjectId.push(selectedIds);
                        }
                    });
                }
            });
        },
        "drawCallback": function() {
            setTimeout(function(){
                if(selectedQuestionIds.subjectId == undefined){
                    selectedQuestionIds.subjectId = [];
                }
                var subjectId = $(document).find('input[name=questionSubjectId]').val();
                $('.questionCheckbox:checked').each(function () {
                    selectedQuestionIds.subjectId.push($(this).val());
                    // selectedQuestionIds.push($(this).val());
                });
                // selectedQuestionIds = selectedQuestionIds.split(',');
                if(selectedQuestionIds.subjectId.length > 0){
                    $.each(selectedQuestionIds.subjectId, function(k, value){
                        $('.questionCheckbox').each(function () {
                            var val = $(this).val();
                            if(val == value){
                                $(this).attr('checked',true);
                            }
                        });
                    });
                }else{
                    $('.questionCheckbox').each(function () {
                        var val = $(this).val();
                        if(selectedQuestionIds.subjectId == val){
                            $(this).attr('checked',true);
                        }
                    });
                }
            },200)
        }
    });
}
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
$(document).ready(function(){
    $("#question_import_form").validate({
        rules: {
            import_file: {
                // required: true,
                extension: "csv,xls,xlsx,odt",
            },
            passage:{
                extension: "pdf",
            },
            images:{
                extension: "jpg|jpeg|png",
            }
        },
        messages: {
            import_file: {
                required: 'Import file field is required.',
                extension: 'Use only CSV or Excel file to import Questions.'
            },
        },
        invalidHandler:function(e,r){$("#m_form_1_msg").removeClass("m--hide").show(),
        mUtil.scrollTop()},
    });
});

$('#m_form').validate({
    ignore: ":hidden:not(.do-not-ignore)",
    rules: {
        name: {
            required: true,
            maxlength: rule.name_length,
            noSpace: true,
        },
        description: {
            cke_required: true,
            maxlength: rule.content_length,
            noSpace: true,
        },
        complete_instruction: {
            cke_required: true,
            maxlength: rule.content_length,
            noSpace: true,
        },
        is_time_mandatory:{
            required: true,
        },
        test_image:{
            required: function (element) {
                if ($("#blah").attr('src') != "" || $('image_id').val() == 'undefined') {
                    return false;
                } else {
                    return true;
                }
            },
            extension: "jpg|jpeg|png"
        },
        image_id:{
            required: function (element) {
                if ($("#blah").attr('src') != "" || $('#image_id').val() == 'undefined') {
                    return false;
                } else {
                    return true;
                }
            },
        },
        import_file: {
            required:true, 
            // function(element){
            //     if($('#id').val() == null || $('#id').val()==''){
            //         return true;
            //     }else{
            //         return false;
            //     }
            // },
            extension: "csv,xls,xlsx,odt",
        },
        passage:{
            extension: "pdf",
        },
        images:{
            extension: "jpg|jpeg|png",
        },
        answer_sheet:{
            required: function(element){
                if(($('#ans_sheet_file').val() == '' || $('#ans_sheet_file').val() == null) && (element.value !== null || element.value == '')){
                    return true;
                }
                return false;
            },
            extension: "pdf,doc,docx,odt,xls,xlsx",
        },
        no_of_section:{
            required:true,
            min:1,
        }
    },
    messages: {
        import_file: {
            required: 'Import file field is required.',
            extension: 'Use only CSV or Excel file to import Questions.'
        },
        no_of_section:{
            min:'Please add at least one section',
            required:'Please add at least one section',
        }
    },
    errorPlacement: function (error, element) {
        $('.errors').remove();
        var elementName = '';
        if (element.attr("name") == "description")
            error.insertAfter(".descriptionError");
        else if(element.attr("name") == "price")
            error.insertAfter(".priceError");
        else if(element.attr("name") == "image_id")
            error.insertAfter(".imageError");
        else if(element.attr("name")=="complete_instruction")
            error.insertAfter('.completeInstructionError');
        else if(element.attr("name")=="no_of_section")
            error.insertAfter('.sectionError');
        else if(element.attr('name').includes("seconds") == true){
            element.next('span').html(error);
        }
        else
            error.insertAfter(element);
    },
    invalidHandler: function (e, r) {
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
    // submitHandler: function (form) {
    //     // Prevent double submission
    //     if (!this.beenSubmitted) {
    //         this.beenSubmitted = true;
    //         form.submit();
    //     }
    // },
})
$('#m_form').on("submit", function (r) {
        var paperName = $(document).find('.sectionDiv').find('input[name^="section"]');
        paperName.filter('input[name$="[name]"]').each(function() {
            $(this).rules("add", {
                required: true,
                maxlength: rule.name_length,
                messages: {
                    required: "This field is required",
                }
            });
        });

        paperName.filter('input[name$="[time]"]').each(function() {
            $(this).rules("add", {
                required: true,
                maxlength: rule.name_length,
                messages: {
                    required: "This field is required",
                }
            });
        });

        paperName.filter('input[name$="[report_question]"]').each(function() {
            $(this).rules("add", {
                required: true,
                maxlength: rule.name_length,
                digits:true,
                messages: {
                    required: "This field is required",
                }
            });
        });

        var paperDescription = $(document).find('.sectionDiv').find('textarea[name^="section"]');
        // paperDescription.filter('textarea[name$="[description]"]').each(function() {
        //     $(this).rules("add", {
        //         cke_required:true,
        //         messages: {
        //             required: "This field is required",
        //         }
        //     });
        // });

        paperDescription.filter('textarea[name$="[close_instruction]"]').each(function() {
            $(this).rules("add", {
                cke_required:true,
                messages: {
                    required: "This field is required",
                }
            });
        });

        var paperSubject = $(document).find('.sectionDiv').find('select[name^="section"]');
        paperSubject.filter('select[name$="[subject_id]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "This field is required",
                }
            });
        });

        var paperQuestions = $(document).find('.sectionDiv').find('input[name^="section"]');
        paperQuestions.filter('input[name$="[questions]"]').each(function() {
            $(this).rules("add", {
                required: true,
                maxlength: rule.name_length,
                digits: true,
                messages: {
                    required: "This field is required",
                }
            });
        });

        var paperReportQuestion = $(document).find('.sectionDiv').find('input[name^="section"]');
        paperReportQuestion.filter('input[name$="[report_question]"]').each(function(k,v) {
            $(this).rules("add", {
                required: true,
                maxlength: rule.name_length,
                messages: {
                    required : 'This field is required',
                }
            });
        });

        var paperReportQuestion = $(document).find('.sectionDiv').find('input[name^="section"]');
        paperReportQuestion.filter('input[name$="[is_time_mandatory]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "This field is required",
                }
            });
        });

        paperReportQuestion.filter('input[name$="[import_file]"]').each(function() {
            $(this).rules("add", {
                required: function(element){
                    questionName = element.name.replace('import_file','question_ids');
                    questionVal = $('input[name="'+questionName+'"]').val();
                    if(questionVal=='' || questionVal== null){
                        if(parseInt(element.files.length) > 0){
                            return false;
                        }
                        return true;
                    }else{
                        return false;
                    }
                },
                extension:'xls|csv|xlsx',
                messages: {
                    required: "This field is required",
                }
            });
        });

        paperReportQuestion.filter('input[name$="[images][]"]').each(function() {
            $(this).rules("add", {
                extension:'png|jpe?g|PNG|JPE?G',
                messages: {
                    required: "This field is required",
                }
            });
        });

        paperReportQuestion.filter('input[name$="[passage]"]').each(function() {
            $(this).rules("add", {
                extension:'pdf',
                messages: {
                    required: "This field is required",
                }
            });
        });
        var paperInstructionTime = $(document).find('.sectionDiv').find('select[name^="section"]');
        paperInstructionTime.filter('select[name$="[seconds]"]').each(function() {
            if($(this).attr('name').includes('instruction_read_time')){
                $(this).rules("add", {
                    minTime:true,
                    messages: {
                        required: "This field is required.",
                        minTime:'Please select second grater than or equal 5 seconds.'
                    }
                });
            }
        });
        paperInstructionTime.filter('select[name$="[minutes]"]').each(function() {
            if($(this).attr('name').includes('section_time')){
                $(this).rules("add", {
                    minMinutes:true,
                    messages: {
                        required: "This field is required.",
                        minMinutes:'Please select second grater than or equal 10 Minutes.'
                    }
                });
            }
        });
        // paperReportQuestion.filter('input[name$="[import_file]"]').each(function() {
        //     $(this).rules("add", {
        //         required: true,
        //         messages: {
        //             required: "This field is required",
        //         }
        //     });
        // });

        if($(document).find("#m_form").valid()){
            if($(document).find("#m_form").valid()){
                $(this).prop('disabled',true);
                return true;
            } else {
                return false;
            }
        }else{
            if($(document).find("#m_form").valid()){
                $(this).prop('disabled',true);
                return true;
            } else {
                return false;
            }
        }
})

$('.addPaper').on('click',function(){
    var validator = $("#m_form").validate();
    isValid = validator.element(".noOfPapaer");
    if(isValid){
        var papers = $('.noOfPapaer').val();
        if(papers != 0 || papers !=''){
            $.ajax({
                url:getPaperLayout,
                method:'POST',
                data:{
                    no_of_papers:papers,
                    stage_id : stageId,
                },
                success:function(response){
                    if(response.status=='success'){
                        $('.paperDetail').html(response.html);
                        $('.paperDetail').find('.subjectData').selectpicker();
                        $('.paperDetail').find('.subjectData').selectpicker('val', '');
                        $(response.html).find('.ckeditor').each(function(e){
                            CKEDITOR.replace( this.id);
                            // CKEDITOR.config.removePlugins = 'image';
                            CKEDITOR.config.removeButtons= 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord';
                            CKEDITOR.config.removePlugins = "dialogui,dialog,a11yhelp,about,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu,contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,richcombo,font,format,forms,horizontalrule,htmlwriter,iframe,image,indent,indentblock,indentlist,justify,magicline,maximize,newpage,pagebreak,pastefromword,pastetext,preview,print,removeformat,resize,save,menubutton,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table";
                        });
                    }
                },
                error:function(response){
                }
            })
        }else{
        }
    }
})
$('.paperDetail').on('change','.subjectData',function(){
    var subject_id = $(this).val();
    var paper_key = $(this).attr('data-key');
    if(subject_id != ''){
        $.ajax({
            url:getPaperLayout,
            method:'POST',
            data:{
                subject_id:subject_id,
                paper_key:paper_key,
                stage_id : stageId,
            },
            success:function(response){
                if(response.status=='success'){
                    $('.paperDetail').find('.questionAndTime'+paper_key).html(response.html);
                    $(response.html).find('.ckeditor').each(function(e){
                        CKEDITOR.replace( this.id);
                        CKEDITOR.config.removePlugins = 'image';
                        CKEDITOR.config.removeButtons= 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord';
                    });
                }
            },
            error:function(response){
            }
        })
    }else{

    }
})
$('.paperDetail').on('click','.addPaperSubject',function(){
    var paperKey = $(this).attr('data-paper_key');
    var subjectKey = $(this).attr('data-subject_key');
    var slug = $(this).attr('data-subject_slug');
    var html = $('.paperDetail').find('.paper[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]').eq(0).clone();
    var length = $('.paperDetail').find('.paper[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]').length;
    html.find('input').each(function () {
        this.name = this.name.replace('paper['+paperKey+'][section][0]', 'paper['+paperKey+'][section]['+length+']');
        if(this.name == 'paper['+paperKey+'][section]['+length+'][seq]'){
            this.value = length;
        }else{
            if(this.type != 'radio'){
                this.value = null;
            }
        }
    })
    html.find('textarea').each(function () {
        this.name = this.name.replace('paper['+paperKey+'][section][0]', 'paper['+paperKey+'][section]['+length+']');
        this.value = null;
    })
    html.find('select').each(function () {
        this.name = this.name.replace('paper['+paperKey+'][section][0]', 'paper['+paperKey+'][section]['+length+']');
        this.value = '';
    })
    $('.paperDetail').find('.subjectDetail[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]:last').append(html);
    // html.find('.timedSection').hide();
    html.find('#cke_paper'+parseInt(paperKey)+'Subject'+slug+''+subjectKey+'Instruction').remove();
    html.find('#paper'+parseInt(paperKey)+'Subject'+slug+''+subjectKey+'Instruction').attr('id','paper'+parseInt(paperKey)+'Subject'+slug+''+length+'Instruction');
    html.find('.paper'+parseInt(paperKey)+'Subject'+subjectKey).attr('id','paper'+parseInt(paperKey)+'Subject'+length);
    html.find('.paper'+parseInt(paperKey)+'Subject'+subjectKey+'InstrctTime').attr('id','paper'+parseInt(paperKey)+'Subject'+length+'InstrctTime');
    html.find('#paper'+parseInt(paperKey)+'Subject'+subjectKey+'Button').attr('id','paper'+parseInt(paperKey)+'Subject'+length+'Button');
    html.find('#paper'+parseInt(paperKey)+'Subject'+subjectKey+'Button').attr('data-subject_slug',slug);
    html.find('#paper'+parseInt(paperKey)+'Subject'+subjectKey+'Button').attr('data-paper_key',parseInt(paperKey));
    html.find('#paper'+parseInt(paperKey)+'Subject'+subjectKey+'Button').attr('data-subject_key',length);
    html.find('#paper'+parseInt(paperKey)+'Subject'+subjectKey+'Button').attr('data-subject_key',length);

    html.find('.ckeditor').each(function(e){
        CKEDITOR.replace( this.id);
        // CKEDITOR.config.removePlugins = 'image';
        CKEDITOR.config.removeButtons= 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord';

    });
    $div = $('.paperDetail').find('.subjectDetail[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]:last');
    $div.addClass('card');
    $div.addClass('mt-4');
    $div.addClass('mb-4');
    $div.addClass('p-4');
    // $div.find('.timedSection').hide();
    var length2 = $('.paperDetail').find('.paper[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]').length;
    if(length2 > 1){
        $('.paperDetail').find('.removedPaperSubject[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]').show();
    }
})
$('.paperDetail').on('click','.removedPaperSubject',function(){
    var paperKey = $(this).attr('data-paper_key');
    var slug = $(this).attr('data-subject_slug');
    $('.paperDetail').find('.paperSection[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]:last').remove();
    var length = $('.paperDetail').find('.paper[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]').length;
    if(length == 1){
        $('.paperDetail').find('.removedPaperSubject[data-paper_key="'+parseInt(paperKey)+'"][data-subject_slug="'+slug+'"]').hide();
    }
    // noOfSection = $('.paperDetail').find('.paperSection').length;
    // noOfSection = $('.paperDetail').find('.paperSection').length;
    // if(stageId == 2){
    //     if(noOfSection < 1){
    //         $(document).find('.addSections').show();
    //     }
    // }
    $(document).find('#noOfSection').val(noOfSection);
})

$('.paperDetail').on('click','.addSections',function(){
    var paper_key = $(this).attr('data-paper_key');
    // if(subject_id != ''){
        $.ajax({
            url:getPaperLayout,
            method:'POST',
            data:{
                paper_key:paper_key,
                no_of_section:no_of_section,
                stage_id : stageId,
            },
            success:function(response){
                if(response.status=='success'){
                    $('.paperDetail').find('.questionAndTime'+paper_key).append(response.html);
                    $(response.html).find('.ckeditor').each(function(e){
                        CKEDITOR.replace( this.id);
                        // CKEDITOR.config.removePlugins = 'image';
                        CKEDITOR.config.removeButtons= 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord';

                    });
                    no_of_section++;
                    noOfSection = $('.paperDetail').find('.paperSection').length;
                    // if(stageId == 2){
                    //     if(noOfSection > 0){
                    //         $(document).find('.addSections').hide();
                    //     }
                    // }
                    $(document).find('#noOfSection').val(noOfSection);
                    $(response.html).find('.timepicker').datetimepicker(
                        {
                        disableFocus: true,
                        showInputs: false,
                        showSeconds: true,
                        showMeridian: false,
                        defaultValue: '12:45:30'
                        }
                    );
                }
            },
            error:function(response){
            }
        })
    // }else{
    // }
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
// CKEDITOR.config.removePlugins = 'image';
CKEDITOR.config.removeButtons= 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar,PasteFromWord';
CKEDITOR.config.removePlugins = "dialogui,dialog,a11yhelp,about,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,menu,contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup,filebrowser,find,fakeobjects,flash,floatingspace,richcombo,font,format,forms,horizontalrule,htmlwriter,iframe,image,indent,indentblock,indentlist,justify,magicline,maximize,newpage,pagebreak,pastefromword,pastetext,preview,print,removeformat,resize,save,menubutton,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table";
