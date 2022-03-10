$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
    });
    $("#address_update").validate({
        ignore: ":hidden",
        rules: {
            country:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            address:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            address2:{
                // noSpace: true,
                maxlength: rule.text_length,
                // required:true,
            },
            city:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            state:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            country:{
                noSpace: true,
                maxlength: rule.text_length,
                required:true,
            },
            postal_code:{
                required:true,
                noSpace: true,
                maxlength: rule.zipcode_length,
                minlength: rule.zipcode_length,
            },
        },
        messages: {
            region:{
                required: "This field is required",
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);

        },

        submitHandler: function (form) {
            form.submit();
        }
    });
});
$('#changePass').on('click',function(){
    $('input[name=old_password]').val('');
    $('input[name=new_password]').val('');
    $('input[name=password_confirmation]').val('');
});
$('.delete').on('click',function(){
    $('#deleteAddress').modal('show');
    $('#deleteLink').attr('data-url',$(this).attr('data-url'));
});
$('#deleteLink').on('click',function(){
    $('.lds-ring').show();
    $.ajax({
        url:$(this).attr('data-url'),
        method:'DELETE',
        success:function(response){
            if(response.icon == 'success'){
                $('.lds-ring').hide();
                toastr.success(response.msg);
                $('#deleteAddress').modal('hide');
                window.location.reload();
            }else{
                toastr.info(response.msg);
            }
        },
        error:function(){

        }
    });

})