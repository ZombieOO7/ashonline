$(document).ready(function() {
    // remove exam from cart
    $(document).on('click','.dlt-crt-prdt',function(e) {
        swal({
            title: 'Are You Sure ?',
            text: 'Want to remove this Exam from cart!',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $(document).find('#hidden-mock-id').val($(this).attr('data-mock-id'));
                $(document).find('.rmv-prdt-frm-id').submit();
            } else {
            }
        });
    });
    // CLEAR ALL PAPERS FROM CART
    $(document).on('click','.clr-cart',function(e) {
        swal({
            title: 'Are You Sure ?',
            text: 'You want to clear your cart!',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $(document).find('.clr-crt-frm-id').submit();
            } else {

            }
        });
    });

    // VALIDATE COUPON CODE FORM
    $(document).find("#code-frm-id").validate({
        rules: {
            code: {
                required: true,
            }
        },
        messages: {
            code: {
                required: 'Please enter a coupon code.'
            }
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element.closest('.input-group'));
        },
    });
});
