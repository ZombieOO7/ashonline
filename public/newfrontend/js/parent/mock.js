$('.activeModal').on('click',function(){
    mockTestId = null;
    $('#activeMockModal').modal('show');
    mockTestId = $(this).attr('data-mock_test_id');
    $('#mockTestId').val(mockTestId);
    $('#studentId').val('');
});

$(document).on('submit','#m_form_1',function(e){
    e.preventDefault();
    $(this).validate({
        ignore: [],
        rules: {
            student_id:{
                required:true,
            }
        },
        messages: {
            student_id:{
                required:'Please select child',
            },
        },
        errorPlacement: function (error, element) {
            if(element.attr('id') == 'studentId'){
                error.insertAfter('.childError');
            }else{
                error.insertAfter(element);
            }
        },
    });
    if($(this).valid()){
        $('.lds-ring').show();
        // $(document).find('.assignMock').prop('disabled', true);
        $.ajax({
            url:activeMockUrl,
            method:'POST',
            data:$('#m_form_1').serialize(),
            success:function(response){
                $('.lds-ring').hide();
                // $(document).find('.assignMock').prop('disabled', false);
                if(response.icon == 'success'){
                    toastr.success(response.msg);
                }else{
                    toastr.info(response.msg);
                }
                mockTestId = $('#mockTestId').val();
                $(".activeModal[data-mock_test_id="+mockTestId+"]").attr('disabled',true);
                $('#activeMockModal').modal('hide');
            },
            error:function(){
            }
        })
    }
})
$('.feedback_form').submit(function(e){
    e.preventDefault();
    $.ajax({
        url:feedbackUrl,
        method:'POST',
        data:$(this).serialize(),
        success:function(response){
            if(response.icon == 'success'){
                toastr.success(response.msg);
                $('#success_modal').modal('show');
                window.location.reload();
            }else{
                toastr.info(response.msg);
            }
        },
        error:function(){

        }
    });
})
$('.viewFeedback').on('click',function(){
    review = $(this).attr('data-review');
    rate = $(this).attr('data-rate');
    $(document).find('#paperReview').text(review);
    $(document).find('#pScore').raty({
        readOnly:  false,
        half:  true,
        path    :  base_url+'/public/frontend/images',
        starOff : 'star-off.svg',
        starOn  : 'star-on.svg',
        starHalf:   'star-half.svg',
        start: rate,
    });
    $(document).find('#pScore').raty('score',rate);
    $('#feedback_modal').modal('show');
})

$('.shr_ic').on('click',function(){
    $('.main_loader').show();
    $.ajax({
        url:$(this).attr('data-url') ,
        method:'GET',
        success:function(result){
            $('.main_loader').hide();
           if(result.status == 'success'){
              toastr.success('Mail sent successfully');
           }else{
              toastr.warning('Something went wrong');
           }
        },
        error:function(result){
            toastr.warning('Something went wrong');
        }
     })
})
$(document).on('change','.agreeToPrint',function(){
    var dataId = $(this).attr('data-id');
    if (dataId != null || dataId !='' || dataId != undefined){
        if(this.checked == true){
            $(document).find('.printPdf[data-id="'+dataId+'"]').attr('disabled',false);
        }else{
            $(document).find('.printPdf[data-id="'+dataId+'"]').attr('disabled',true);
        }
    }
})

if($(document).find(".btnprn").length > 0){
    $(document).ready(function () {
        $('.btnprn').printPage();
    });
    $(".btnprn").click(function () {
        var id = ($(this).attr('id'));
        $('#btn' + id).prop('disabled', false);
    });
}
$('.ev_btn').on('click', function () {
    var url = $(this).attr('data-url');
    var dataTarget = $(this).attr('data-target');
    if (dataTarget == "#SEvaluateMockModal") {
        var oldUrl = $('#s_start_eval').attr("href"); // Get current url
        var newUrl = oldUrl.replace("", url); // Create new url
        $('#s_start_eval').attr("href", newUrl); // Set herf value
    } else {
        $('#m_start_eval').attr("href", url);
    }
});
if($(document).find('.fixedStar').length > 0){

    $(document).find('.fixedStar').raty({
        readOnly: true,
        half: true,
        path: base_url + '/public/frontend/images',
        starOff: 'star-off.svg',
        starOn: 'star-on.svg',
        starHalf: 'star-half.svg',
        start: $(document).find(this).attr('data-score')
    });
    $(document).find('.editable_star').raty({
        readOnly: false,
        half: true,
        path: base_url + '/public/frontend/images',
        starOff: 'star-off.svg',
        starOn: 'star-on.svg',
        starHalf: 'star-half.svg',
        start: $(document).find(this).attr('data-score')
    });
}
$(document).find('.selectChildId').on('click',function(){
    $(document).find('.selectChildId').removeClass('active');
    $(this).addClass('active');
    studentId = $(this).attr('data-student_id');
    $(document).find('#studentId').val(studentId);
})
