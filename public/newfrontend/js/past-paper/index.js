if($('#past_paper').length > 0){
    (function ($) {
        var field_coloumns = [
            {
                "data": "DT_RowIndex",
                orderable: false,
                searchable: false
            },{
                "data": "name",
                orderable: false,
                searchable: false
            },{
                "data": "download",
                orderable: false,
                searchable: false
            },
            {
                "data": "answer_sheet",
                orderable: false,
                searchable: false
            }
        ];
        var order_coloumns = [[0, "desc"]];
        $('#past_paper').DataTable({
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
            "pageLength": 20,
            "serverSide": true,
            "bInfo": true,
            "autoWidth": false,
            "searching": true,
            "orderCellsTop": false,
            "columns": field_coloumns,
            "bPaginate":true,
            "bLengthChange": false,
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
}

if($('#pastPaperQuestion').length > 0){
    debugger;
    (function ($) {
        var field_coloumns = [
            {
                "data": "question_answers",
                orderable: false,
                searchable: false
            }
        ];
        var order_coloumns = [[0, "desc"]];
        $('#pastPaperQuestion').DataTable({
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
            "pageLength": 20,
            "serverSide": true,
            "bInfo": true,
            "autoWidth": false,
            "searching": true,
            "orderCellsTop": false,
            "columns": field_coloumns,
            "bPaginate":true,
            "bLengthChange": false,
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
}
