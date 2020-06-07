// Load google charts
google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function recycleChart() {

}

// Draw the chart and set the chart values
function drawChart() {
    fetch('/api/getdata/json')
        .then(response => response.json())
        .then(function (data) {
            var info = google.visualization.arrayToDataTable([
                ['Tip', 'Kilograme de'],
                ['Plastic', data[0].plastic],
                ['Metal', data[0].metal],
                ['Hârtie', data[0].paper],
                ['Deșeu Menajer', data[0].waste],
                ['Sticlă', data[0].glass],
                ['Amestecat', data[0].mixed],
            ]);
            var options = { 'title': 'Collected Garbage', 'width': 550, 'height': 400, backgroundColor: { fill:'transparent' } };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(info, options);
            $(window).smartresize(function () {
                chart.draw(data, options);
            });
        });

}

function resize () {
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

window.onload = resize;
window.onresize = resize;