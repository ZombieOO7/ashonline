$('#Start_Date').datetimepicker({
    format: 'MM/YYYY',
    minDate: moment(),
});
function cardRadio(){
  document.getElementById('forCardpayment').style.display ='block';
  document.getElementById('paypal-button-container').style.display ='none';
  document.getElementById('pay-now').style.display ='block';
  $(document).find('#card_number').val('');
  $(document).find('#name_on_card').val('');
  $(document).find('#cvv').val('');
}
function cardRadionone(){
  document.getElementById('forCardpayment').style.display ='none';
  document.getElementById('paypal-button-container').style.display ='block';
  document.getElementById('pay-now').style.display ='none';
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

// VALIDATE CHECKOUT FORM
$(document).find("#billing-frm-id").validate({
      rules: {
          email: {
              required: true,
              maxlength: 255,
          },
          confirm_email : {
              required: true,
              maxlength: 255,
              equalTo : "#email"
          },
          first_name : {
            required: true,
            maxlength: 255,
          },
          last_name : {
            required: true,
            maxlength: 255,
          },
          address1 : {
            required: true,
          },
          phone : {
            required: true,
            minlength: 10, 
            maxlength: 20 
          },
          postal_code : {
            required: true,
            minlength: 3, 
            maxlength: 10
          },
          city : {
            required: true,
            maxlength: 255,
          },
          state : {
            required: true,
            maxlength: 255,
          },
          country : {
            required: true,
            maxlength: 255,
          },
          card_number : {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#first_name').val("");
                    return false;
                }
            },
          },
          name_on_card : {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#name_on_card').val("");
                    return false;
                }
            },
          },
          expire_date : {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#expire_date').val("");
                    return false;
                }
            },
          },
          cvv : {
            required: function () {
                if ($(document).find('#Cardid').prop('checked')) {
                    return true;
                } else {
                    $('#cvv').val("");
                    return false;
                }
            },
          },
          agree : {
            required : true,
          },
      },
      messages: {
        confirm_email: {
          equalTo: 'Confirm email must be same as email.'
        },
        agree : {
          required : 'Please agree terms & conditions to continue',
        }
      },
      errorPlacement: function (error, element) {
      error.insertAfter(element);   
    }
});

// this identifies your website in the createToken call below
Stripe.setPublishableKey($(document).find('#billing-frm-id').attr('data-stripe-publishable-key'));
  
// Handle stripe response
function stripeResponseHandler(status, response) 
{
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
    $(document).find('.page-loader').show();  
    form$.get(0).submit();
  }
}

$(document).ready(function() {
    $("#billing-frm-id").submit(function(event) {    
        if (!$("input[name=agree]").is(":checked")) {
            return false;
        } else {
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
        }
    });
    if (window.location.protocol === 'file:') {
      alert("stripe.js does not work when included in pages served over file:// URLs. Try serving this page over a webserver. Contact support@stripe.com if you need assistance.");
    }

    // SET PAYPAL BUTTONS
    
    var form = $('#billing-frm-id');
    paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'horizontal',
          label: 'pay',
          tagline: true,
        },
        createOrder: function() {
          if($("#billing-frm-id").valid()) {
            return $.ajax({
                url: site_url+'/checkout/order/request',
                method: 'post',
                data: form.serialize(),
                success: function(data){
                  $(document).find('.page-loader').hide();
                  return data;
                }
            }).fail(function(res) {
              $(document).find('.page-loader').hide();
              return res;
            });
          } else {

          }
        },
        onApprove: function(data) {
            $('#order_id').val(data.orderID);
            $.ajax({
                url: site_url+'/approve/checkout/request',
                method: 'post',
                data: form.serialize(),
                success: function(data) {
                    if(data.success) {
                      window.location.href = site_url+"/thank-you/"+data.uuid;
                    }
                }
            }).fail(function(res) {
              $(document).find('.page-loader').hide();
              return res;
            });
        }
    }).render('#paypal-button-container');
});