flag = false;
$('#Start_Date').datetimepicker({
    format: 'MM/YYYY',
    minDate: moment(),
});

function cardRadio() {
    setTimeout(function () {
        document.getElementById('forCardpayment').style.display = 'block';
        // $('.addressError').get(0).nextSibling.remove();
        $('.agree_err').get(0).nextSibling.remove();    
    }, 10);
    document.getElementById('paypal-button-container').style.display = 'none';
    document.getElementById('pay-now').style.display = 'block';
    $(document).find('#card_number').val('');
    $(document).find('#name_on_card').val('');
    $(document).find('#cvv').val('');
}

function cardRadionone() {
    document.getElementById('forCardpayment').style.display = 'none';
    document.getElementById('paypal-button-container').style.display = 'block';
    document.getElementById('pay-now').style.display = 'none';
    setTimeout(function () {
        $('.agree_err').get(0).nextSibling.remove();
        // $('.addressError').get(0).nextSibling.remove();
    },10);
}

// ALLOW CVV TO ONLY NUMBERS
$(document).find('#cvv').keypress(function (event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
// ALLOW CARD NUMBER TO ONLY NUMBERS
$(document).find('#card_number').keypress(function (event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

$(document).find("#billing-frm-id").validate({
    ignore: ":hidden",
    rules: {
        selected_address: {
            required: true,
        },
        card_number: {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#first_name').val("");
                    return false;
                }
            },
        },
        name_on_card: {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#name_on_card').val("");
                    return false;
                }
            },
        },
        expire_date: {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#expire_date').val("");
                    return false;
                }
            },
        },
        cvv: {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#cvv').val("");
                    return false;
                }
            },
        },
        agree: {
            required: true,
        },
    },
    messages: {
        selected_address: {
            required: 'Please select address',
        },
        confirm_email: {
            equalTo: 'Confirm email must be same as email.'
        },
        phone: {
            minlength: 'Please enter at least 10 digits.',
            maxlength: 'Please enter at least 10 digits.',
        },
        agree: {
            required: 'Please agree terms & conditions to continue',
        }
    },
    errorPlacement: function (error, element) {
        if (element.attr('name') == 'selected_address') {
            error.insertAfter('.addressError');
        } else if (element.attr('name') == 'agree') {
            error.insertAfter('.agree_err');
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function (form) {
        if (!this.beenSubmitted) {
            if ($(document).find('#Cardid').prop('checked')) { // Credit card validation
                var expDate = $(document).find('#Start_Date').val();
                var expDate = expDate.split('/');
                var expMonth = expDate[0];
                var expYear = expDate[1];

                // createToken returns immediately - the supplied callback submits the form if there are no errors
                Stripe.createToken({
                    number: $('#card_number').val(),
                    cvc: $('#cvv').val(),
                    exp_month: expMonth,
                    exp_year: expYear,
                }, stripeResponseHandler);
                return false;
            }
            this.beenSubmitted = true;
            form.submit();
        }
    },
});
// this identifies your website in the createToken call below
Stripe.setPublishableKey($(document).find('#billing-frm-id').attr('data-stripe-publishable-key'));

// Handle stripe response
function stripeResponseHandler(status, response) {
    if (response.error) {
        // // show the errors on the form
        if (response.error.code == "invalid_number" && response.error.param == "exp_month" || response.error.code == "invalid_number" && response.error.param == "exp_year") {
            $(document).find('.exp_date_err').html(response.error.message);
        }
        if (response.error.code == "incorrect_number" && response.error.param == "number" || response.error.code == "invalid_number" && response.error.param == "number") {
            $(document).find('.card_number_err').html(response.error.message);
        }
        if (response.error.code == "invalid_cvc") {
            $(document).find('.cvv_err').html(response.error.message);
        }
        if (response.error.code == "missing_payment_information") {
            $(document).find('.agree_err').html(response.error.message);
        }
        if (response.error.code == "invalid_cvc") {
            $(document).find('.cvv_err').html(response.error.message);
        }
    } else {
        var form$ = $("#billing-frm-id");
        // token contains id, last4, and card type
        var token = response['id'];
        console.log(token);
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // and submit
        $(document).find('.main_loader').show();

        if ($('#submitPressed').val() == '1') {
            form$.get(0).submit();
        }

    }
}

$(document).ready(function () {
    if (window.location.protocol === 'file:') {
        alert("stripe.js does not work when included in pages served over file:// URLs. Try serving this page over a webserver. Contact support@stripe.com if you need assistance.");
    }
    // SET PAYPAL BUTTONS
    var form = $('#billing-frm-id');
    paypal.Buttons({
        env: 'sandbox',
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'horizontal',
          label: 'pay',
          tagline: true,
        },
        createOrder: function(data,actions) {
            if($("#billing-frm-id").valid()) {
                return actions.order.create({
                    intent:'CAPTURE',
                    application_context:{
                        return_url:return_url,
                        cancel_url:cancel_url
                    },
                    purchase_units: [{
                        description:description,
                        amount: {
                            value:amount,
                        }
                    }]
                });
            } else {
            }
        },
        onApprove: function(data) {
            $(document).find('.main_loader').show();
            $('#order_id').val(data.orderID);
            $.ajax({
                url: site_url+'/approve/checkout/request',
                method: 'post',
                data: form.serialize(),
                success: function(data) {
                    if(data.success) {
                    $(document).find('.main_loader').hide();
                      window.location.href = base_url+"/thank-you/"+data.uuid;
                    }
                }
            }).fail(function(res) {
              $(document).find('.main_loader').hide();
              return res;
            });
        }
    }).render('#paypal-button-container');
});

$('#pay-now').on('click', function () {
    flag =true;
    if ($("#billing-frm-id").valid()) {
        $('#submitPressed').val('1');
    }
});
