// Load google charts
google.charts.load('current', { 'packages': ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Tip', 'Kilograme de'],
        ['Plastic', 800],
        ['Metal', 1200],
        ['Hârtie', 300],
        ['Deșeu Menajer', 500],
    ]);
    var options = { 'title': 'Collected Garbage', 'width': 550, 'height': 400, backgroundColor: { fill:'transparent' } };
    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
    $(window).smartresize(function () {
        chart.draw(data, options);
    });
}

function resize () {
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

window.onload = resize;
window.onresize = resize;