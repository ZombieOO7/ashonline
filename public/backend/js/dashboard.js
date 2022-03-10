// This function is used to initialize the data table.
(function ($)
{
    var acePaperDashboard = function ()
    {
        $(document).ready(function ()
        {
            c._initialize();
        });
    };
    var c = acePaperDashboard.prototype;

    c._initialize = function ()
    {
        c.createChart();
        c.changeEvent();
        $('#year').val(new Date().getFullYear()).trigger('change');
    };
    // Draw category chart
    c.createChart = function(dataArr) {
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(dataArr);

            var options = {
                /*chart: {
                    title: 'Orders',
                    subtitle: '',
                },*/
                legend: {position: 'none'},
                vAxis: {
                    format: 'decimal',
                    title: 'Total sold papers',
                    viewWindow: {min: 0},
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    };

    // Get category chart data
    c.changeEvent = function() {
        $('#year, #category, #subject').change(function() {
            var year = $('#year').val();
            var catId = $('#category').val();
            var subId = $('#subject').val();
            $.ajax({
                url: base_url+"/admin/chart/data",
                type: 'GET',
                data: {year:year, cat_id: catId, sub_id:subId},
                success: function(data) {
                    var chartData = [];
                    chartData.push(['Month', 'Total']);
                    $.each(data, function(i, item){
                        chartData.push([i, item]);
                    });
                    c.createChart(chartData);
                }
            });
        });
    };

    window.acePaperDashboard = new acePaperDashboard();
})(jQuery);

