$(document).on('click','.loginBtn', function(){
    $('#LoginModal').modal('show');
    $('#type').val('parent');
    $('.parentMail').show();
    $('.childUsername').hide();
})
$(function () {
    // This function is used for applying csrf token in ajax.
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
    });
    $.validator.addMethod("noSpace", function (value, element) {
        return $.trim(value);
    }, "This field is required");
    $("#login").validate({
        ignore:':hidden',
        rules: {
            email: {
                required: true,
                email: true,
                noSpace: true,
                maxlength: rule.email_length,
            },
            username: {
                required: true,
                maxlength: rule.email_length,
                noSpace: true,
            },
            password: {
                noSpace: true,
                required: true,
                maxlength: rule.password_max_length,
                minlength: rule.password_min_length,
            }
        },
        messages: {
            email: "Please enter a valid email address",
            password: {
                required: "Please enter password",
            }
        },
    });
    $('#login').on('submit',function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        if($("#login").valid()){
            $('.lds-ring').show();
            $('#loginBtn').attr('disabled',true);
            $.ajax({
                url:checkUserlogin,
                type:'POST',
                data:formData,
                success:function(response){
                    $('#loginBtn').attr('disabled',false);
                    if(response.status == 'info'){
                        swal({
                            title: 'Are you sure?',
                            text: response.msg,
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                            closeOnClickOutside: false,
                        }).then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url:loginUrl,
                                    type:'POST',
                                    data:formData,
                                    success:function(response){
                                        $('.lds-ring').hide();
                                        if(response.icon == 'error'){
                                            toastr.warning(response.msg);
                                        }
                                        if(response.icon == 'success'){
                                            $('#LoginModal').modal('hide');
                                            toastr.success(response.msg);
                                            setTimeout(function(){
                                                if(response.type =='parent')
                                                    window.location.replace(homeRoute);
                                                else
                                                    window.location.replace(studentUrl);
                                            },2000);
                                        }
                                    },
                                    error: function (response) {
                                        toastr.warning('Something went wrong !');
                                        console.log(response);
                                        window.location.reload();
                                    }
                                });
                            }else{
                                $('.lds-ring').hide();
                            }
                        })
                    }else if(response.status == 'success'){
                        $.ajax({
                            url:loginUrl,
                            type:'POST',
                            data:formData,
                            success:function(response){
                                $('.lds-ring').hide();
                                $('#LoginModal').modal('hide');
                                if(response.icon == 'error'){
                                    toastr.warning(response.msg);
                                }
                                if(response.icon == 'success'){
                                    toastr.success(response.msg);
                                    setTimeout(function(){
                                        if(response.type =='parent')
                                            window.location.replace(homeRoute);
                                        else
                                            window.location.replace(studentUrl);
                                    },2000);
                                }
                            },
                            error: function (response) {
                                toastr.warning('Something went wrong !');
                                console.log(response);
                                window.location.reload();
                            }
                        });
                    }else{
                        toastr.warning('Something went wrong !');
                        console.log(response);
                        window.location.reload();
                    }
                },
                error: function (response) {
                    toastr.warning('Something went wrong ! Please try again');
                    console.log(response);
                    window.location.reload();
                }
            });
        }
    });
    $("#forgotPassword").validate({
        rules: {
            email: {
                required: true,
                email: true,
                noSpace: true,
            },
        },
        messages: {
            email: "Please enter a valid email address",
        },
    });
    $('#forgotPassword').on('submit',function(e){
        e.preventDefault();
        var formData = $(this).serialize();
        if($("#forgotPassword").valid()){
            $('.lds-ring').show();
            $.ajax({
                url:forgotPassUrl,
                type:'POST',
                data:formData,
                success:function(response){
                    $('.lds-ring').hide();
                    if(response.icon == 'error'){
                        toastr.error(response.msg);
                    }
                    if(response.icon == 'success'){
                        toastr.success(response.msg);
                        $('#LoginModal').modal('hide');
                    }
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });

    $('.frgt_pswrd').on('click',function(){
        $(document).find('#login').hide();
        $(document).find('#forgotPassword').show();
    })
    $('.childLogin').on('click',function(){
        $(document).find('.parentMail').hide();
        $(document).find('.childUsername').show();
        $(document).find('#type').val('child');
    })
    $('.parentLogin').on('click',function(){
        $(document).find('.childUsername').hide();
        $(document).find('.parentMail').show();
        $(document).find('#type').val('parent');
    })
    $("#LoginModal").on('show.bs.modal', function () {
        $(document).find('#login').show();
        $(document).find('#forgotPassword').hide();
        $("#login").trigger("reset");
        $("#forgotPassword").trigger("reset");
    });
    $('#loginLink').on('click',function(){
        $(document).find('#login').show();
        $(document).find('#forgotPassword').hide();
    })
});
