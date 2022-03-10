(function ($) {
        var field_coloumns = [
            {
                "data": "image",
                orderable: false,
                searchable: false
            },
            {
                "data": "school_name",
                orderable: false,
                searchable: false
            },
            {
                "data": "exam_style",
                orderable: false,
                searchable: false
            },
            {
                "data": "short_description",
                orderable: false,
                searchable: false
            },
            {
                "data": "action",
                orderable: false,
                searchable: false
            },
        ];
        var order_coloumns = [[1, "desc"]];
        $('#school_table').DataTable({
            stateSave: true,
            dom: 'trilp',
            "ajax": {
                url:url,
                type: "get",
                global: false,
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
})(jQuery);
$(document).on('change','#filterBy',function(){
    table_id = $(this).attr('data-table_id');
    table = $('#'+table_id).DataTable();
    table.draw();
});