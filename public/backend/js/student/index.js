var url = $('#student_table').attr('data-url'); // This variable is used for getting route name or url.
// This function is used to initialize the data table.
(function ($)
{
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
            {data: 'checkbox', name: 'checkbox', orderable: false},
            {data: 'student_no', name: 'student_no'},
            {data: 'parent_name', name: 'parent_name'},
            {data: 'first_name', name: 'first_name'},
            {data: 'middle_name', name: 'middle_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'dob', name: 'dob'},
            {data: 'school_year', name: 'school_year'},
            {data: 'exam_board_id', name: 'exam_board_id'},
            {data: 'action', name: 'action' , orderable: false},
        ];
        var order_coloumns = [[7, "desc"]];
        backloadzCommon._generateDataTable('student_table',url,field_coloumns,order_coloumns);
    };
    window.acePaperAssessment = new acePaperAssessment();
})(jQuery);