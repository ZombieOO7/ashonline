// For Notification
$(document).ready(function() {
    // TOTO M2
    setInterval(function() {
        $.ajax({
            url: base_url+'/notification',
            type: 'GET',
            data: {last_id: $('#last_notify_id').text()},
            global: false,
            success: function(data) {
                if(data.status == 'success')
                {
                    $('#last_notify_id').text(data.id);
                    var settings = {
                        theme: 'smoke',
                        life: 10000,
                        heading: data.user,
                        horizontalEdge: 'bottom',
                        verticalEdge: 'left',
                        zindex: 11500,
                    };
                    var info = '<img src="'+data.img+'" width="50" height="80"><a href="'+data.link+'">'+data.paper+'</a> <p>About '+data.time+'</p>';
                    //var info = '<a href="'+data['link']+'">'+data['paper']+'</a> <p>About '+data['time']+'</p>';
                    $.notific8(info, settings);
                }
            }
        });
    }, 30000);
});