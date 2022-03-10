// Add To Cart
$(document).on('click','.addToCart',function() {
    $(".main_loader").css("display", "block");
    if(cartFlag == 'false'){
        $(".main_loader").css("display", "none");
        toastr.error(warningMsg);
    }else{
        $.ajax({
            url: $(this).attr('data-url'),
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            global: false,
            data: {
                    mock_id : $(this).attr('data-mock_id'),
                    paper_id : $(this).attr('data-paper_id'),
                },
            success: function (result) {
                $(".main_loader").css("display", "none");
                if(result.error != undefined) {
                    toastr.error(result.error);
                } else {
                    toastr.success(result.msg);
                    $(document).find('.itmcounts').text(result.total);
                    $(document).find('.added-crt').html('<button class="btn btn-addtocar btn_added">Added</button><a href="'+ cartURL +'" class="btn btnviewcart mt-3" >View Cart <span class="ash-right-thin-chevron"></span></a>');
                    if(flag == true){
                        window.location.reload();
                    }
                }
            }
        });
    }
});
// CLEAR ALL PAPERS FROM CART
$(document).on('click','.clr-cart',function(e) {
    swal({
        title: 'Are You Sure',
        text: 'Want to clear cart ?',
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

// DELETE SINGLE PAPER FROM CART
$(document).on('click','.dlt-crt-prdt',function(e) {
    swal({
        title: 'Are You Sure ?',
        text: 'Want to remove this exam from cart!',
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $(document).find('#hidden-mock-id').val($(this).attr('data-mock-id'));
            $(document).find('#hidden-paper-id').val($(this).attr('data-paper-id'));
            $(document).find('.rmv-prdt-frm-id').submit();
        } else {

        }
    });
});
$('.loginAlert').on('click',function(){
    toastr.error('Please login first to checkout your cart items');
    $('#LoginModal').modal('show');
})
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
