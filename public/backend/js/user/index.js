$(document).ready(function () {
    $('#user_table').DataTable({
        //stateSave: true,
        dom: 'trilp',
        "processing": true,
        "serverSide": true,
        "ajax": user_list_url,
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "aaSorting": [],
        "order": [[1, "desc"]],
        "columns": [{
            "data": "checkbox",
            orderable: false,
            searchable: false
        },
        {
            "data": "id"
        },
        {
            "data": "first_name"
        },
        {
            "data": "last_name"
        },
        {
            "data": "email"
        },
        {
            "data": "status"
        },
        {
            "data": "action",
            orderable: false,
            searchable: false
        },
        ],
        "search": {
            "regex": true
        },
        "initComplete": function () {
            var r = $('#user_table tfoot tr');
            $('#user_table thead').append(r);
            this.api().columns().every(function (i) {
                var column = this;
                r.find(' td:first-child').css('visibility', 'hidden');
                r.find(' td:last-child').css('visibility', 'hidden');
                if (i == 5) {
                    $('select', this.footer()).on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                } else {
                    var title = $('#user_table thead th').eq(this.index()).text();
                    var input = "<input type='text' class='form-control form-control-sm search_field_font' placeholder=" + title + ">";
                    $(input).appendTo($(column.footer()).empty())
                        .on('keyup change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });

                }
            });
        }
    });
});
