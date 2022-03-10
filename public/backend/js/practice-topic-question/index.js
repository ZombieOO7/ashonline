// This function is used to initialize the data table.
(function ($)
{
})(jQuery);

$('#export').on('click', function (e) {
    var action = $("#action option:selected").val();
    if($("#m_form_1").valid()){
        if (action == "" ) {
            e.preventDefault();
            msgTxt = message['select_action'];
            swal(msgTxt, {
                icon: "info",
            });
        }
        var limit = $('#question_table').DataTable().ajax.params().length;
        var start = $('#question_table').DataTable().ajax.params().start;
        $('#m_form_1').append("<input type='hidden' name='export_limit' value='"+limit+"' />");
        $('#m_form_1').append("<input type='hidden' name='export_start' value='"+start+"' />");
    }
});
$(document).ready(function(){
    if(subjectId != '' && subjectId != null){
        generateDataTable()
    }
    if(topicId != '' && topicId != null){
    }
})
$('#getData').on('click', function (e) {
    e.preventDefault();
    generateDataTable();
});
function generateDataTable(){
    $("#m_form_1").validate({
        rules: {
            subject_id :{
                required:true,
            },
        },
        errorPlacement: function (error, element) {
            error.insertAfter('#subjectError');
        },
    });
    if($("#m_form_1").valid()){
        $("#question_table").DataTable().destroy();
        $("#question_table tbody").empty();
        var acePaperAssessment = function ()
        {
            $(document).ready(function ()
            {
                c._initialize();
            });
        };
        var c = acePaperAssessment.prototype;
    
        c._initialize = function ()
        {
            c._listingView();
        };
    
        c._listingView = function(){
            var field_coloumns = [
                {"data": "question_title",'width':'60%','maxWidth':'60%'},
                {"data":'progress','width':'15%','maxWidth':'15%'},
                {"data":'corrected_answer','width':'5%','maxWidth':'5%'},
                {"data":'incorrected_answer','width':'5%','maxWidth':'5%'},
                {"data": "action", orderable: false, searchable: false,'width':'10%','maxWidth':'10%' },
            ];
            var order_coloumns = [[0, "desc"]];
            backloadzCommon._generateDataTable('question_table',url,field_coloumns,order_coloumns);
        };
        window.acePaperAssessment = new acePaperAssessment();
    }
}
$(document).on('click','.shw-dsc',function(e) {
    $(document).find('.show_desc').html($(this).attr('data-description'));
    $(document).find('.mdl_ttl').html($(this).attr('data-title'));
    $(document).find('.show_question').html($(this).attr('data-question'));
});
