$(document).ready(function () {
    var url = $('#paper_table').attr('data-url'); // This variable is used for getting route name or url.

    // This funtion is used to initialize the data table.
    (function ($) {
        var acePaperAssessment = function () {
            $(document).ready(function () {
                c._initialize();
            });
        };
        var c = acePaperAssessment.prototype;
    
        c._initialize = function () {
            c._listingView();
        };
    
        c._listingView = function () {
            var field_coloumns = [
                {
                    "data": "checkbox",
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "title",
                    "name": 'title'
                },
                {
                    "data": "category_id",
                    "name": 'category_id'
                },
                {
                    "data": "stage",
                    "name": 'stage'
                },
                {
                    "data": "subject_id",
                    "name": 'subject_id'
                },
                {
                    "data": "exam_type_id",
                    "name": 'exam_type_id'
                },
                {
                    "data": "price",
                    "name": 'price'
                },
                {
                    "data": "avg_rate",
                    "name": 'avg_rate'
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "status",
                    "name": 'status'
                },
                {
                    "data": "action",
                    orderable: false,
                    searchable: false
                },
            ];
            var order_coloumns = [[8,"desc"]];
            table = acePaperCommon._generateDataTable('paper_table', url, field_coloumns, order_coloumns, data = null);
            table.on( 'draw.dt', function () {
                $.fn.raty.defaults.path = base_url + '/public/images';
                $(document).find('.default').raty({readOnly:  true});
            });
        };
        window.acePaperAssessment = new acePaperAssessment();
        c.singleDelete = function () {

        }
    })(jQuery);
    // get paper order info and than after delete 
    $(document).on('click', '.deletePaper', function () {
        var id = $(this).attr('id');
        var url = $(this).attr('data-url');
        var deleteUrl = $(this).attr('data-delete-url');
        var tableName = $(this).attr('data-table_name');
        var module = $(this).attr('data-module_name');
        $.ajax({
            url: url,
            method: "get",
            success: function (response) {
                if(response.items > 0)
                {
                    $txt = '<b>Total '+ response.items +'</b> user has purchased this paper, still you want to delete ?';
                    var content = document.createElement('div');
                    content.innerHTML = $txt;
                    deletePaper(content,id,tableName,deleteUrl);
                }else{
                    var content = document.createElement('div');
                    $txt= 'You want to delete this ' + module;
                    content.innerHTML = $txt;
                    deletePaper(content,id,tableName,deleteUrl);
                }
            }
        })
    });
    // delete paper
    function deletePaper($txt,id,tableName,url){
        swal({
            title: message['sure'],
            content: $txt,
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
    }
    CKEDITOR.on('instanceReady', function() {
        $.each(CKEDITOR.instances, function(instance) {
            CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
            CKEDITOR.instances[instance].document.on("paste", CK_jQ);
            CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
            CKEDITOR.instances[instance].document.on("blur", CK_jQ);
            CKEDITOR.instances[instance].document.on("change", CK_jQ);
        });
    });
    
    function CK_jQ() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }
});
