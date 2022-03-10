(function ($) {
    stageId = null;
    grade_id = null
    $('.datatable').each(function(){
        var tableId = $(this).attr('id');
        var url = $(this).attr('data-url');
        grade_id = $(this).attr('data-grade_id');
        var exam_board_id = $(this).attr('data-exam_board_id');
        var school_id = $(this).attr('data-school_id');
        var subject_id = $(this).attr('data-subject_id');
        if(isParent == true){
            var field_coloumns = [
                {
                    "data": "image",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "exam_name",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "date",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "time",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "price",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
            ];
        }else{
            var field_coloumns = [
                {
                    "data": "image",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "exam_name",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "date",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "time",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "price",
                    orderable: false,
                    searchable: false
                },
            ];
        }
        var order_coloumns = [[2, "desc"]];
        $('#'+tableId).DataTable({
            stateSave: true,
            dom: 'trilp',
            "ajax": {
                url:url,
                type: "POST",
                global: false,
                "data":function ( d ) {
                    d.grade_id = $('#'+tableId).attr('data-grade_id');
                    d.exam_board_id = exam_board_id;
                    d.school_id = school_id;
                    d.exam_type = stageId;
                    d.subject_id = subject_id;
                },
            },
            "processing": true,
            "order": order_coloumns,
            "responsive":!0,
            "oLanguage": {
                "sProcessing":  '<div class="text-center"><img src="'+base_url +'/public/images/loader.svg" width="40"></div>',
                "sEmptyTable":"No Record Found",
            },
            "lengthMenu": [10, 25, 50, 75, 100 ],
            "serverSide": true,
            "bInfo": false,
            "autoWidth": false,
            "searching": false,
            "orderCellsTop": true,
            "columns": field_coloumns,
            "bPaginate":false,
            "ordering": false,
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': ['nosort']
            }],
            "aaSorting": [],
            "initComplete": function () {
            }
        });
    })
})(jQuery);
$(document).on('change','.filterBy',function(){
    table_id = $(this).attr('data-grade_id');
    grade_id = table_id;
    stageId = $(this).val();
    $('.filterTable'+table_id).each(function(){
        tableId = $(this).attr('id');
        table = $('#'+tableId).DataTable();
        table.draw();
    })
});
