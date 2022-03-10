$(document).ready(function () {
    $(document).find('#resultGrade:visible').validate({
        ignore:':hidden',
        rules:{
            excellent_max:{
                min: function(){
                    return parseInt($(document).find('#excellent_min:visible').val()) - 1;
                },
                max:100,
            },
            excellent_min:{
                min: function(){
                    return parseInt($(document).find('#very_good_max:visible').val()) - 1;
                },
                max: function(){
                    return ((parseInt($(document).find('#excellent_max:visible').val()) - 1)  && (parseInt($(document).find('#very_good_max:visible').val()) + 1));
                },
            },
            very_good_max:{
                min: function(){
                    return parseInt($(document).find('#very_good_min:visible').val()) + 1;
                },
                max: function(){
                    return parseInt($(document).find('#excellent_min:visible').val()) - 1;
                },
            },
            very_good_min:{
                min: function(){
                    return parseInt($(document).find('#good_max:visible').val()) + 1;
                },
                max: function(){
                    return ((parseInt($(document).find('#very_good_max:visible').val()) - 1) && (parseInt($(document).find('#good_max:visible').val()) + 1));
                },
            },
            good_max:{
                min: function(){
                    return parseInt($(document).find('#good_min:visible').val()) + 1;
                },
                max: function(){
                    return parseInt($(document).find('#very_good_min:visible').val()) - 1;
                },
            },
            good_min:{
                min: function(){
                    return parseInt($(document).find('#fair_max:visible').val()) + 1;
                },
                max: function(){
                    return ((parseInt($(document).find('#good_max:visible').val()) - 1) && (parseInt($(document).find('#fair_max:visible').val()) + 1));
                },
            },
            fair_max:{
                min: function(){
                    return parseInt($(document).find('#fair_min:visible').val()) + 1;
                },
                max: function(){
                    return parseInt($(document).find('#good_min:visible').val()) - 1 ;
                },
            },
            fair_min:{
                min: function(){
                    return parseInt($(document).find('#improve_max:visible').val());
                },
                max: function(){
                    return ((parseInt($(document).find('#fair_max:visible').val()) - 1) && (parseInt($(document).find('#improve_max:visible').val()) + 1));
                },
            },
            improve_max:{
                min: function(){
                    return parseInt($(document).find('#improve_min:visible').val())+1;
                },
                max: function(){
                    return parseInt($(document).find('#fair_min:visible').val())-1;
                },
            },
            improve_min:{
                min:0,
                max: function(){
                    return parseInt($(document).find('#improve_max:visible').val())-1;
                },
            },
        }
    })
});
$(document).find('.resultGrade').on('submit', function(e){
    e.preventDefault();
    var index = $(this).attr('data-index');
    var data = $(document).find('#resultGrade'+index).serialize();
    if($(document).find('#resultGrade'+index).valid()){
        $.ajax({
            url:storeGradeUrl,
            method:'POST',
            data:data,
            global:false,
            success:function(response){
                if(response.status =='success'){
                    $(document).find('#id:visible').val(response.id);
                    swal(response['msg'], {
                        icon: response['icon'],
                        closeOnClickOutside: false,
                    });
                }
            },
            error:function(){

            }
        })
    }
})
$('.deleteQuestion').on('click',function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
    });
    var url = $(this).attr('data-url');
    var id = $(this).attr('data-id');
    var msg = $(this).attr('data-msg');
    var mock_test_id = $(this).attr('data-mock_test_id');
    swal({
        title:'Are you sure?',
        text:msg,
        icon:'warning',
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: url,
                method: "DELETE",
                data: { id: id, mock_test_id:mock_test_id},
                success: function (response) {
                    swal(response['msg'], {
                        icon: response['icon'],
                        closeOnClickOutside: false,
                    });
                    window.location.reload();
                }
            });
        }
    });
})