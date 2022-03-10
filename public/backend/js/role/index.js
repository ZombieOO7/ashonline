$(document).ready(function () {
    $('#role_table').DataTable({
        stateSave: true,
        dom: 'trilp',
        "processing": true,
        "serverSide": true,
        "ajax": role_list_url,
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
            "data": "role_name",
            "name": 'name'
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
            var r = $('#role_table tfoot tr');
            $('#role_table thead').append(r);
            this.api().columns().every(function () {
                var column = this;
                r.find(' td:first-child').css('visibility', 'hidden');
                r.find(' td:last-child').css('visibility', 'hidden');
                var title = $('#role_table thead th').eq(this.index()).text();
                var input = "<input type='text' class='form-control form-control-sm search_field_font' placeholder=" + title + ">";
                $(input).appendTo($(column.footer()).empty())
                    .on('keyup change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        }
    });
});
