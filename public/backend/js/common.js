function trim(el) {
    el.value = el.value.
        replace(/(^\s*)|(\s*$)/gi, ""). // removes leading and trailing spaces
        replace(/[ ]{2,}/gi, " "). // replaces multiple spaces with one space
        replace(/\n +/, "\n"); // Removes spaces after newlines
    return;
}

setTimeout(function() {
    $(document).find('.alert-success').fadeOut('slow');
}, 3000); // <-- time in milliseconds

setTimeout(function() {
    $(document).find('.alert-warning').fadeOut('slow');
}, 3000); // <-- time in milliseconds

setTimeout(function() {
    $(document).find('.alert-info').fadeOut('slow');
}, 3000); // <-- time in milliseconds

setTimeout(function() {
    $(document).find('.alert-danger').fadeOut('slow');
}, 3000); // <-- time in milliseconds
(function ($)
{
    var backloadzCommon = function ()
    { };
    var c = backloadzCommon.prototype;

    //Generate data table
    c._generateDataTable = function(element_id_name,ajax_URL,field_coloumns,order_coloumns,data,dom){
        var bSearching = true;
        if (field_coloumns === undefined) {
            field_coloumns = [];
        }
        if (order_coloumns === undefined) {
            order_coloumns = [[7, "desc"]];
        }

        var intial_url = 'http://';
        var intial_url2 = 'https://';
        var final_ajax_url = '';
        if(ajax_URL.indexOf(intial_url) != -1){
            final_ajax_url = ajax_URL;
        }else if(ajax_URL.indexOf(intial_url2) != -1){
            final_ajax_url = ajax_URL;
        }else{
            final_ajax_url = base_url + ajax_URL;
        }
        var doms = 'trilp' , button = [];
        if(dom != undefined) {
            doms = dom;
            button = [
                {
                    extend: 'csvHtml5',
                    // title: 'Data List',
                    text:'Export',
                    extension:'.csv',
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }
            ]
        }
        if(element_id_name !='cms_table'){
            type = null;
        }
        table = $('#'+element_id_name).DataTable({
            stateSave:true,
            global:false,
            "processing": true,
            "order": order_coloumns,
            "responsive":!0,
            "oLanguage": {
                "sProcessing":  '<img src="'+base_url +'/public/images/loader.svg" width="40">',
                "sEmptyTable":"No Record Found",
            },
            "lengthMenu": [10, 25, 50, 75, 100 ],
            "serverSide": true,
            "bInfo": true,
            "autoWidth": false,
            "searching": bSearching,
            "orderCellsTop": true,
            "columns": field_coloumns,
            "bPaginate":true,
            dom: doms,
            buttons:button,
            initComplete: function () {
                if(data != undefined) {
                    if(data['user_type'] == 'user') {
                        this.api().columns([7]).visible(false);
                        this.api().columns([5]).visible(false);
                    }
                }
            },
            
            "ajax": {
                url: final_ajax_url,
                type: "get", // method  , by default get
                global: false,
                "data": function ( d ) {
                    $.extend( d, data);
                    d.status = $('.statusFilter').val();
                    d.is_tuition_parent = $('.isTuitionParentFilter').val();
                    d.from_date_filter = $('.from_date_filter').val();
                    d.to_date_filter = $('.to_date_filter').val();
                    d.select_mock_title_filter = $('.select_mock_title_filter').val();
                    d.type = type;
                    d.subject_id = $('#subject_id').val();
                    d.topic_id = $('#topic_id').val();
                    d.student_id = $('#studentId').val();
                    d.parent_id = $('#'+element_id_name).attr('data-parent_id');
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                 },
                "error":function(){
                    // window.location.reload();
                }
            }
        });
        table.on( 'page.dt', function () {
            $('.allCheckbox').prop("checked", false);
            $('.checkbox').prop("checked", false);
        } );
        c.table = table;
        if(bSearching)
            c._tableSearchInput(element_id_name);
        c._tableResetFilter();
        c._tableResetFilterDraw();
        return table;
    };

    var today = new Date();
    $(".from_date_filter").datepicker({
        onClose:function(evt, ui){
            table.draw();
        },
        dateFormat: 'dd-mm-yy',
        maxDate : today,
        autoclose: true,
        todayHighlight: true
    });

    $('.from_date_filter').datepicker().on('changeDate', function(ev){
        table.draw();
    });

    $(".to_date_filter").datepicker({
        onClose:function(evt, ui){
            table.draw();
        },
        dateFormat: 'dd-mm-yy',
        maxDate : today,
        autoclose: true,
        todayHighlight: true
    });

    $('.to_date_filter').datepicker().on('changeDate', function(ev){
        table.draw();
    });
    if($('.select_mock_title_filter').length > 0){
        $('.select_mock_title_filter').select2({
            placeholder: 'Select Mock Test Title'
        }).on("change", function (e) { 
            table.draw();
            e.preventDefault();
        });
    }
    $(document).on('click','#clr_filter', function(event) {
        $('select').val('');
        $('input').val('');
    });
    //Event added for table search
    c._tableSearchInput = function(element_id_name) {

        var r = $('#'+element_id_name+' tfoot tr');
        $('#'+element_id_name+' thead').append(r);
        var table = c.table;
        table.columns().every(function (colindex) {
            var column = this;
            column.search('');
            $('.tbl-filter-column').val('');
            // table.ajax.reload(null, false);
            var tColumn = $('#'+element_id_name+' thead th').eq(this.index());
            $('input', this.footer()).on('keyup change', function () {
                column.search($.trim($(this).val()), false, false, true).draw();
            });
            $('select', this.footer()).on('change', function () {
                table.draw();
            });
        });
    };

    //Event added for record per page
    c._tableResetFilter = function(){
        $(document).on('click','#clr_filter', function(event) {
            c._tableResetFilterDraw();
            $('select').val('');
        });
    };

    //Table Draw after reset table
    c._tableResetFilterDraw = function(){
        $('.tbl-filter-column').val('');
        var columns = c.table.columns();
        columns.every(function(i) {
            var column = this;
            column.search('');
            // column.search('').draw();
        });
        c.table.clear().draw();
    };

    window.backloadzCommon = new backloadzCommon();
})(jQuery);

$.validator.addMethod("noSpace", function (value, element) {
    return $.trim(value);
}, "This field is required");
$.validator.addMethod("postcodeUK", function (value, element) {
    return this.optional(element) || /^(([gG][iI][rR] {0,}0[aA]{2})|((([a-pr-uwyzA-PR-UWYZ][a-hk-yA-HK-Y]?[0-9][0-9]?)|(([a-pr-uwyzA-PR-UWYZ][0-9][a-hjkstuwA-HJKSTUW])|([a-pr-uwyzA-PR-UWYZ][a-hk-yA-HK-Y][0-9][abehmnprv-yABEHMNPRV-Y]))) {0,}[0-9][abd-hjlnp-uw-zABD-HJLNP-UW-Z]{2}))$/i.test(value);
}, "Please specify a valid Postcode");

// This function is used to initialize the data table.
(function ($) {
    var acePaperCommon = function () {
        c.initiallize();
    };
    var c = acePaperCommon.prototype;

    c.initiallize = function () {
        c.actionSubmit();
        c.activeInactive();
        c.singleDelete();
        c.commonCode();
    };

    c.commonCode = function() {
        // This function is used for applying csrf token in ajax.
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
        });

        $(document)
        .ajaxStart(function () {
            $('.main_loader').show();   //ajax request went so show the loading image
        })  
        .ajaxStop(function () {
            $('.main_loader').hide();   //got response so hide the loading image
        });

        // var date = new Date();
        // $('#dob').datetimepicker({
        //     format: 'yyyy-mm-dd',
        //     minView: 2,
        //     maxView: 4,
        //     autoclose: true,
        //     language: 'en',
        //     endDate: date
        // });

        // This function is used for un checking all checkbox.
        $("body").on('change', '.checkbox', function () {
            if ($(this).is(':unchecked')) {
                $(".allCheckbox").prop("checked", false);
            }
        });

        /*Mutiple checkbox checked or unchecked*/
        $(document).on('click', '.allCheckbox',function () {
            if ($(this).is(':checked')) {
                $('.checkbox').prop("checked", true);
            } else {
                $('.checkbox').prop("checked", false);
            }
        });
    }

    c.actionSubmit = function () {
        // Bulk Action
        $('body').on('click', '#action_submit', function (e) {
            e.preventDefault();
            var url = $(this).attr('data-url');
            var tableName = $(this).attr('data-table_name');
            var module = $(this).attr('data-module_name');
            var id = [], msg;
            $('.checkbox:checked').each(function () {
                id.push($(this).val());
            });
            var action = $("#action option:selected").val();
            if (action != "" && id.length > 0) {
                if (action == 'Active' || action == 'Inactive' || action == 'publish' || action == 'unpublish') {
                    msg = message['once_updated_status'];
                }
                else {
                    msg = message['once_deleted'] + module;
                    if(id.length>1){
                        msg = message['once_deleted'] + module + "'s";
                    }
                }
                swal({
                    title: message['sure'],
                    text: msg,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeOnClickOutside: false,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            method: "post",
                            data: { ids: id, action: action},
                            success: function (response) {
                                swal(response['msg'], {
                                    icon: response['icon'],
                                    closeOnClickOutside: false,
                                });
                                $('.allCheckbox').prop("checked", false);
                                $('#' + tableName).DataTable().ajax.reload(null, false);
                            }
                        });

                    }
                });
            } else {
                var msgTxt;
                if (id.length <= 0) {
                    msgTxt = message['select_checkbox'] + " " + module;
                } else {
                    msgTxt = message['select_action'];
                }
                    swal(msgTxt, {
                    icon: "info",
                });
            }
        });
    };

    c.activeInactive = function () {
        // Change Status (Active/Inactive)
        $(document).on('click', '.active_inactive', function (e) {
            e.preventDefault();
            var url = $(this).attr('data-url');
            var id = $(this).attr('id');
            var tableName = $(this).attr('data-table_name');
            swal({
                title: message['sure'],
                text: message['once_updated_status'],
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
            }).then((isConfirm) => {
                if (isConfirm) {
                    $.ajax({
                        url: url,
                        method: "post",
                        data: { 'id': id },
                        success: function (response) {
                            swal(response['msg'], {
                                icon: response['icon'],
                                closeOnClickOutside: false,
                            });
                            $('#' + tableName).DataTable().ajax.reload(null, false);
                        }
                    })
                }
            });
        });

        // Update rating status (Published/Unpublished)
        $(document).on('change', '.published_unpublished', function (e) {
            e.preventDefault();
            var url = $(this).attr('data-url');
            var id = $(this).attr('id');
            var tableName = $(this).attr('data-table_name');
            var status = $(this).val();
            if (status == 0) {
                swal('Please select option to update status', {
                    icon: 'warning',
                    closeOnClickOutside: false,
                }); 
            } else {
                swal({
                    title: message['sure'],
                    text: message['once_updated_status'],
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeOnClickOutside: false,
                }).then((isConfirm) => {
                    if (isConfirm) {
                        $.ajax({
                            url: url,
                            method: "post",
                            data: { 'id': id, 'status' : status },
                            success: function (response) {
                                swal(response['msg'], {
                                    icon: response['icon'],
                                    closeOnClickOutside: false,
                                });
                                $('#' + tableName).DataTable().ajax.reload(null, false);
                            }
                        })
                    }
                });
            }
        });
    }
    c.singleDelete = function () {
        // Delete Record
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            var url = $(this).attr('data-url');
            var tableName = $(this).attr('data-table_name');
            var module = $(this).attr('data-module_name');
            swal({
                title: message['sure'],
                text: message['once_deleted'] + module,
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        method: "delete",
                        data: { 'id': id },
                        success: function (response) {
                            if (response['msg'] != 'error') {
                                swal(response['msg'], {
                                    icon: response['icon'],
                                    closeOnClickOutside: false,
                                });
                                $('#' + tableName).DataTable().ajax.reload(null, false);
                            }
                        }
                    })
                }
            });
        });
    }

    window.acePaperCommon = new acePaperCommon();
})(jQuery);