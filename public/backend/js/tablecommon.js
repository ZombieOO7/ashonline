// This function is used to initialize the data table.
(function ($) {
    var acePaperCommon = function () {
    };
    var c = acePaperCommon.prototype;

    //Generate data table
    c._generateDataTable = function (element_id_name, ajax_URL, field_coloumns, order_coloumns, data, dom) {
        var bSearching = true;
        if (element_id_name === 'image_module_table') {
            bSearching = false;
        }
        if (element_id_name === 'image_table') {
            bSearching = false;
        }
        if (field_coloumns === undefined) {
            field_coloumns = [];
        }
        if (order_coloumns === undefined) {
            order_coloumns = [[1, "desc"]];
        }

        var intial_url = 'http://';
        var intial_url2 = 'https://';
        var final_ajax_url = '';
        if (ajax_URL.indexOf(intial_url) != -1) {
            final_ajax_url = ajax_URL;
        } else if (ajax_URL.indexOf(intial_url2) != -1) {
            final_ajax_url = ajax_URL;
        } else {
            final_ajax_url = base_url + ajax_URL;
        }
        var doms = 'trilp', button = [];
        if (dom != undefined) {
            doms = dom;
            button = [
                {
                    extend: 'csvHtml5',
                    // title: 'Data List',
                    text: 'Export',
                    extension: '.csv',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
        }
        table = $('#' + element_id_name).DataTable({
            // stateSave:true,
            "processing": true,
            "order": order_coloumns,
            "oLanguage": {
                // "sProcessing":  '<img src="'+image_base_url +'/images/loader.gif" width="40">',
                "sEmptyTable": "No Record Found",
            },
            "lengthMenu": [10, 25, 50, 75, 100],
            "serverSide": true,
            "bInfo": true,
            "autoWidth": false,
            "searching": bSearching,
            "orderCellsTop": true,
            "columns": field_coloumns,
            "bPaginate": true,
            // dom: doms,
            buttons: button,
            initComplete: function () {
                $.fn.raty.defaults.path = base_url + '/public/images';
                $(document).find('.default').raty({readOnly: true});
                if (data != undefined) {
                    if (element_id_name == 'subject_table') {
                        this.api().columns([0, 2]).visible(false);
                    }
                }
            },
            "ajax": {
                url: final_ajax_url,
                type: "get", // method  , by default get
                global: false,
                "data": function (d) {
                    $.extend(d, data);
                    d.status = $('.statusFilter').val();
                    d.image_id = $('#image_id').val();
                    d.logo_image_id = $('#logo_image_id').val();


                },
                "error": function () {
                    // window.location.reload();
                }
            },
            createdRow: function (row, data, dataIndex) {
                // Set the data-id attribute, and add a class
                if (element_id_name == 'subject_table' || element_id_name == 'resources_table') {
                    $(row).attr('data-id', data.id);
                    // $(document).find("#subject_table tbody").attr('id','tablecontents');
                }
            }
        });
        c.table = table;
        if (bSearching) {
            c._tableSearchInput(element_id_name);
        }
        c._tableResetFilter();
        return table;
    };

    //Event added for table search
    c._tableSearchInput = function (element_id_name) {

        var r = $('#' + element_id_name + ' tfoot tr');
        $('#' + element_id_name + ' thead').append(r);
        var table = c.table;
        table.columns().every(function (colindex) {
            var column = this;
            column.search('');
            $('.tbl-filter-column').val('');
            table.ajax.reload(null, false);
            var tColumn = $('#' + element_id_name + ' thead th').eq(this.index());
            $('input', this.footer()).on('keyup change', function () {
                column.search($.trim($(this).val()), false, false, true).draw();
            });
            $('select', this.footer()).on('change', function () {
                // column.search($(this).val(), false, false, true);
                table.draw();
            });
        });
    };

    //Event added for record per page
    c._tableResetFilter = function () {
        $(document).on('click', '#clr_filter', function (event) {
            c._tableResetFilterDraw();
        });
    };

    //Table Draw after reset table
    c._tableResetFilterDraw = function () {
        $('.tbl-filter-column').val('');
        var columns = c.table.columns();
        columns.every(function (i) {
            var column = this;
            column.search('').draw();
        });
        c.table.clear().draw();
    };

    window.acePaperCommon = new acePaperCommon();
})(jQuery);
