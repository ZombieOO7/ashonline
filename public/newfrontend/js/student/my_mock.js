
$(document).ready(function(){
    $(document).on('click','.btn_join',function(){  
        $(document).find('.mck-tst-title').html($(this).attr('data-mock-test-title'));
        $(document).find('.mck-tst-img').attr('src',$(this).attr('data-mock-test-image'));
        $(document).find('.mck-tst-desc').html($(this).attr('data-mock-test-description'));
        $(document).find('.mck-tst-topics').html($(this).attr('data-topics'));
        $(document).find('.mck-tst-img-url').attr('href',$(this).attr('data-url'));
        $(document).find('.mck-tst-title-url').attr('href',$(this).attr('data-url'));
        $(document).find('.submit_btn').attr('data-href',$(this).attr('data-start-mock'));
        $(document).find('.mck-tst-time').html($(this).attr('data-time'));
        $(document).find('.submit_btn').attr('data-mock_id',$(this).attr('data-mock_test_id'));
    });
})
// This function is used for applying csrf token in ajax.
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') }
});
// $(document).on('click','.submit_btn',function(){
//     redirectUrl = $(this).attr('data-href');
//     mockTestId = $(this).attr('data-mock_id');
//     $.ajax({
//         url:url,
//         data:{
//             student_id:studentId,
//             mockTestId:mockTestId,
//         },
//         method:'POST',
//         success:function(response){
//             if(response.status == 'error'){
//                 toastr.error(response.msg);
//             }else{
//                 window.location.replace(redirectUrl);
//             }
//         },
//         error:function(){

//         }
//     })
// });