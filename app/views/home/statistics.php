<!doctype html>
<html lang="en">
<head>
    <!-- make page responsive-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistici</title>
    <link rel="stylesheet" href="/public/static/statisticsStyle.css">
    <link rel="stylesheet" href="/public/static/style.css">
    <script src="https://kit.fontawesome.com/342e71a7d6.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js "></script>
    <script type="text/javascript" src="/public/static/js/piechart.js"></script>
    <script type="text/javascript" src="/public/static/js/misc.js"></script>
    <script type="text/javascript" src="/public/static/js/recycle_info.js"></script>
    <script type="text/javascript" src="/public/static/js/map.js"></script>
    <script type="text/javascript" src="/public/static/js/stats.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin="" async></script>
</head>
<body>
<section id="Buttons">
    <div class="statsButtonClass">
        <div class="statsButton ">
            <label for="downloadInfo">Alege perioada:</label>
            <select name="perioada" id="downloadInfo">
                <option value="daily">Zi</option>
                <option value="monthly">Luna</option>
            </select>
        </div>
        <button class="statsButton hoverAction" onclick="download('csv')" id="CSV"><i class="fas fa-download"></i> Descarca CSV</button>
        <button class="statsButton hoverAction" onclick="download('json')" id="JSON"><i class="fas fa-download"></i> Descarca JSON</button>
        <?php if ($_SESSION['IS_ADMIN'] ?? false) { ?>
        <div class="statsButton ">
            <input type="file" id="jsonFile" value="Import" />
            <button class="uploadBtn hoverAction" onclick="upload()" id="UJSON"><i class="fas fa-upload"></i> Încarcă</button>
        </div>
        <?php } ?>
        <button class="statsButton hoverAction" onclick="document.location.href='userPage'"><i class="fas fa-arrow-alt-circle-left"></i> Înapoi</button>
    </div>
</section>

<section id="Situatia">
    <div class="situation-elements">
        <div id="piechart" class="chart"></div>
        <canvas id="myChart" class="chart"></canvas>
        <div class="map-container">
            <div id="map" class="map-controller"></div>
        </div>
    </div>
</section>


<script>
    window.onload = initSMap;
</script>
</body>
</html>
