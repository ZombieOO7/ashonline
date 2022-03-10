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
            // topic_id:{
            //     required:true,
            // }
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
                {"data": "subject" },
                {"data": "topic" },
                {"data":'question_image'},
                {"data":'answer_image'},
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
