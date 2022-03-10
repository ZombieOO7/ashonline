$(document).ready(function(){
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': csrf}
    });
    var field_coloumns = [
        {
            "data": "order_no",
            "name": 'order_no'
        },
        {
            "data": "invoice_no",
            "name": 'invoice_no'
        },
        {
            "data": "amount",
            "name": 'amount'
        },
        {
            "data": "discount",
            "name": 'discount'
        },
        {
            "data": "total",
            "name": 'total'
        },
        {
            "data": "created_at",
            "name": 'created_at'
        },
        {
            "data": "action",
            orderable: false,
            searchable: false
        },
    ];
    var field_coloumns2 = [
        {
            "data": "transaction_id"
        },
        {
            "data": "amount"
        },
        {
            "data": "method"
        },
        {
            "data": "payment_date"
        },
        {
            "data": "description",
            orderable: false,
            searchable: false
        },
        {
            "data": "status"
        },
        {
            "data": "action",
            orderable: false,
            searchable: false
        },
    ];
    var order_coloumns = [[1, "desc"]];
    table2 = $('#mock_table').DataTable({
        stateSave: true,
        dom: 'trilp',
        "ajax": {
            url: url,
            type: "POST",
            global: false,
            data: function (d) {
                d.from_date = $("#fromdate").val();
                d.to_date = $("#todate").val();
            },

        },
        "processing": true,
        "order": order_coloumns,
        "responsive": !0,
        "oLanguage": {
            "sProcessing": '<div class="text-center"><img src="' + base_url + '/public/images/loader.svg" width="40"></div>',
            "sEmptyTable": "No Record Found",
        },
        "lengthMenu": [10, 25, 50, 75, 100],
        "serverSide": true,
        "bInfo": false,
        "autoWidth": false,
        "searching": false,
        "orderCellsTop": true,
        "columns": field_coloumns,
        "bPaginate": true,
        "ordering": false,
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "aaSorting": [],
        "initComplete": function (settings, json) {
        },
        "fnDrawCallback":function(settings, json){
            var length = settings._iRecordsTotal;
            if ( ! table2.data().any() || length < 10 ) {
                $('#mock_table_paginate')[0].style.display = "none";
                $('#mock_table_length')[0].style.display = "none";
            }
            $('#mock_table_processing')[0].style.display = "none";
        }
    });
    table = $('#paper_table').DataTable({
        stateSave: true,
        dom: 'trilp',
        "ajax": {
            url: url2,
            type: "POST",
            global: false,
            data: function (d) {
                d.from_date = $("#fromdate").val();
                d.to_date = $("#todate").val();
            },
        },
        "processing": true,
        "order": order_coloumns,
        "responsive": !0,
        "oLanguage": {
            "sProcessing": '<div class="text-center"><img src="' + base_url + '/public/images/loader.svg" width="40"></div>',
            "sEmptyTable": "No Record Found",
        },
        "lengthMenu": [10, 25, 50, 75, 100],
        "serverSide": true,
        "bInfo": false,
        "autoWidth": false,
        "searching": false,
        "orderCellsTop": true,
        "columns": field_coloumns2,
        "bPaginate": true,
        "ordering": false,
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "aaSorting": [],
        "initComplete": function () {
            // this.api().columns([4]).visible(false);
        },
        "fnDrawCallback":function(settings, json){
            length = table.column( 0 ).data().length;
            var length = settings._iRecordsTotal;
            if ( ! table.data().any() || length < 10 ) {
                $('#paper_table_paginate')[0].style.display = "none";
                $('#paper_table_length')[0].style.display = "none";
            }
            $('#paper_table_processing')[0].style.display = "none";
            $(document).find('.fixedStar').raty({
                readOnly:  true,
                path    :  rateImagePath,
                starOff : 'star-off.svg',
                starOn  : 'star-on.svg',
                starHalf:   'star-half.svg',
                start: $(document).find(this).attr('data-score')
            });
        }
    });
    $("#fromdate").datepicker({    
        endDate: new Date(),
        autoclose: true, 
        todayHighlight: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#todate').datepicker('setStartDate', minDate);
        table.draw();
        table2.draw();
    });

    $("#todate").datepicker({ 
        endDate: new Date(),
        // startDate: $("#fromdate").val(),
        autoclose: true, 
        todayHighlight: true
    }).on('changeDate', function (selected) {
        var maxDate = new Date(selected.date.valueOf());
        $('#fromdate').datepicker('setEndDate', maxDate);
        table.draw();
        table2.draw();
    });
    $(document).on('click','.shw-dsc', function(){
        var content = $(this).attr('data-description');
        $(document).find('.paymentDescription').html(content);
    })
})