$(document).find('#getDatatable').click(function () {
    $('#image_module_table').DataTable().destroy();
    var url = $('#image_module_table').attr('data-url'); // This variable is used for getting route name or url.
    table = $('#image_module_table').DataTable({
        dom: 'trilp',
        scrollY: "40vh",
        // scrollX: !0,
        scrollCollapse: !0,
        // stateSave: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url :  url,
            type: "GET",
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': ['nosort']
        }],
        "aaSorting": [],
        "order": [[0, "desc"]],
        "columns": [{
            "data": "checkbox",
            // "width": '251.5px',
            orderable: false,
            searchable: false
        },
        {
            "data": "path"
        }],
        initComplete:function(){
            setTimeout(function(){
                $(document).find($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            },500);
        },
        drawCallback: function () {
            $(document).find('input[name=image_checkbox]').each(function(key,value){
                if($(this).val()==$('#image_id').val()){
                    $(this).prop('checked',true);
                }
            })
            setTimeout(function(){
                $(document).find($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            },500);
        }
    });
})
$(document).on('click','#nav-profile-tab',function(){
    setTimeout(function(){
        $(document).find($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    },500);
});
$(document).on('change','input[name=image_checkbox]',function(){
    var checkboxLength = $('input[name=image_checkbox]:checked').prop('checked',false);
    // if(checkboxLength > 1){
        this.checked = true;
    // }
});
$(document).find('#SaveImageMedia').click(function () {
    var module = $(this).attr('data-module_name');
    var id = [];
    if($(document).find('.trade_checkbox:checked:visible').length>1){
        swal('Multiple image not allowed', {
            icon: "info",
        });
        return;
    }
    $(document).find('.trade_checkbox:checked:visible').each(function (i) {
        id = $(this).val();
    });
    if (id != '') {
        $("#exampleModal").modal('hide');
        $.ajax({
            url: getImageId,
            data: {
                image_id: id,
            },
            type: 'POST',
            global: true,
            success: function (response) {
                $('#ImageShowColumns').empty().append(response);
            },
            error: function () {
                this.model.show();
            }
        })
    }else if($(document).find('#blah').attr('src') != null){
        $("#exampleModal").modal('hide');
        readURL();
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
function readURL() {
    input = $("#imgInput")[0];
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            $('#blah').css('display', 'block');
        }
        reader.readAsDataURL(input.files[0]);
    }
}