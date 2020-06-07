<!doctype html>
<html lang="en">
<head>
    <!-- make page responsive-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistici</title>
    <link rel="stylesheet" href="/public/static/statisticsStyle.css">
    <link rel="stylesheet" href="/public/static/style.css">
    <script src="https://kit.fontawesome.com/342e71a7d6.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="/public/static/js/piechart.js"></script>
    <script type="text/javascript" src="/public/static/js/misc.js"></script>
    <script type="text/javascript" src="/public/static/js/recycle_info.js"></script>
    <script type="text/javascript" src="/public/static/js/map.js"></script>
    <script type="text/javascript" src="/public/static/js/stats.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
</head>
<body>
<section id="Buttons">
    <div class="statsButtonClass">
        <button class="statsButton" onclick="download('csv')" id="CSV"><i class="fas fa-download"></i> Descarca CSV</button>
        <button class="statsButton" onclick="download('json')" id="JSON"><i class="fas fa-download"></i> Descarca JSON</button>
        <button class="statsButton" onclick="document.location.href='userPage'"><i class="fas fa-arrow-alt-circle-left"></i> Înapoi</button>

    </div>
</section>
<section id="Situatia">
    <div class="situation-elements">
        <div id="piechart" class="chart"></div>
        <div class="map-container">
            <div id="map"></div>
        </div>
    </div>
</section>
<script>
    window.onload = initMap;
</script>
</body>
</html>
