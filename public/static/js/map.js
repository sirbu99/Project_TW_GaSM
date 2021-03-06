let popup;
let mymap;
let tempe;

function onMapClick(e) {
    //to do: open a form for the user to report the issue

    document.getElementById('id03').style.display = 'block';
    tempe = e;
    // document.getElementById("loc").innerHTML = ;
    //47.20, 27.46; 47.12, 27.67
}

async function initMap() {
    popup = L.popup();
    //to do: initialize position with user's county
    mymap = L.map('map').setView([47.17, 27.58], 9);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiaXVsaWZlaWYiLCJhIjoiY2s5eDB4aTFmMGVldjNla29tMzNpd291NyJ9.iVjuD8Ffuo-D6x3ZN2f3rg'
    }).addTo(mymap);


    mymap.on('click', onMapClick);
}

async function initSMap() {
    mymap = L.map('map').setView([47.17, 27.58], 15);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiaXVsaWZlaWYiLCJhIjoiY2s5eDB4aTFmMGVldjNla29tMzNpd291NyJ9.iVjuD8Ffuo-D6x3ZN2f3rg'
    }).addTo(mymap);
    let circle;
    let reps;
    fetch('/api/')
    fetch('/api/getlocations')
        .then(response => response.json())
        .then(function (data) {
            data.forEach(function (e) {
                    circle = L.circle([e.latitude, e.longitude], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.5,
                        radius: 500
                    }).addTo(mymap);
                    circle.bindPopup('Plangeri deseuri stradale: ' + e.complaints1 + '\n Plangeri colectare nrec.: ' + e.complaints2);
                }
            )

        });


}