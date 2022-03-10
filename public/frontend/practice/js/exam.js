var count = examTotalTimeSeconds;
var counter = setInterval(timer, 1000);
function timer() {
    count--;
    if (count < 0) return clearInterval(counter);
    document.getElementById('timer').innerHTML = formatTime(count);
}

$(document).find('#header').click(false);
$(document).find('.subscibe_sc').click(false);
$(document).find('.footer').click(false);
$(document).on('click','#epapersMenu', function(e){
    e.preventDefault();
});

function formatTime(seconds) {
    var h = Math.floor(seconds / 3600),
        m = Math.floor(seconds / 60) % 60,
        s = seconds % 60;
    if (h < 10) h = "0" + h;
    if (m < 10) m = "0" + m;
    if (s < 10) s = "0" + s;
    if (h == '00' && m == '00' && s == '00') {
        window.location.href = examUrl;
    }
    return h + ":" + m + ":" + s;
}

$('#m_form').validate({
    rules:{
        agree:{
            required:true,
        },
    },
    messages:{
        agree:{
            required:'Please select the required checkbox',
        }
    },
    ignore: [],
    errorPlacement: function (error, element) {
        error.insertAfter('.agreeError');
    },
})
$('#startExam').on('click',function(e){
    if($('#m_form').valid()){
    }else{
        e.preventDefault();
    }
})