// Load google charts
google.charts.load('current', {'packages': ['corechart']});
google.charts.setOnLoadCallback(drawChart);

function recycleChart() {

}

// Draw the chart and set the chart values
async function drawChart() {
    fetch('/api/getdata/json')
        .then(response => response.json())
        .then(function (data) {
            let info = google.visualization.arrayToDataTable([
                ['Tip', 'Kilograme de'],
                ['Plastic', data[0].plastic],
                ['Metal', data[0].metal],
                ['Hârtie', data[0].paper],
                ['Deșeu Menajer', data[0].waste],
                ['Sticlă', data[0].glass],
                ['Amestecat', data[0].mixed],
            ]);
            let options = {
                'title': 'Collected Garbage',
                'width': 550,
                'height': 400,
                backgroundColor: {fill: 'transparent'}
            };
            let chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(info, options);
        });


    fetch('/api/getdata/json?report=monthly&county=1')
        .then(response => response.json())
        .then(function (data) {
            let ctx = document.getElementById('myChart').getContext('2d');
            let myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Recycled Paper', 'Recycled Glass', 'Recycled Plastic', 'Recycled Metal', 'Recycled Waste', 'Processed Mixed'],
                    datasets: [{
                        label: '% of materials recycled',
                        data: [data[0].recycled_paper / data[0].added_paper * 100, data[0].recycled_glass / data[0].added_glass * 100, data[0].recycled_plastic / data[0].added_plastic * 100, data[0].recycled_metal / data[0].added_metal * 100, data[0].recycled_waste / data[0].added_waste * 100, data[0].processed_mixed / data[0].added_mixed * 100],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });


}

function resize() {
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

window.onload = resize;
window.onresize = resize;