(function ($) {
    $('.datatable').each(function(){
        tableId = $(this).attr('id');
        url = $(this).attr('data-url');
        grade_id = $(this).attr('data-grade_id');
        exam_board = $(this).attr('data-exam_board');
        school_id = school_id;
        subject_id = $(this).attr('data-subject_id');
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
        var order_coloumns = [[2, "desc"]];
        $('#'+tableId).DataTable({
            stateSave: true,
            dom: 'trilp',
            "ajax": {
                url:url,
                type: "get",
                global: false,
                "data":function ( d ) {
                    d.grade_id = grade_id;
                    d.exam_board = exam_board;
                    d.school_id = school_id;
                    d.exam_type = $('#filterBy').val();
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
$(document).on('change','#filterBy',function(){
    table_id = $(this).attr('data-table_id');
    table = $('#'+table_id).DataTable();
    table.draw();
});
