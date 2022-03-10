$(document).ready(function () {

    // DELETE SINGLE PAPER FROM CART
    $(document).on('click', '.dlt-crt-prdt', function (e) {
        swal({
            title: 'Are You Sure ?',
            text: 'You Want to clear this paper in your cart!',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $(document).find('#hidden-paper-id').val($(this).attr('data-paper-id'));
                    $(document).find('.rmv-prdt-frm-id').submit();
                } else {

                }
            });
    });

    // CLEAR ALL PAPERS FROM CART
    $(document).on('click', '.clr-cart', function (e) {
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
