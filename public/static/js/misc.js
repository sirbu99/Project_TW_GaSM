function hide(id) {

    var element = document.getElementById(id);
    if (element.style.display === 'none') {
        element.style.display = 'block';
    } else {
        element.style.display = 'none';
    }

}

serialize = function(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

async function repForm(){
    let lat = tempe.latlng.lat.valueOf();
    let lng = tempe.latlng.lng.valueOf();
    let form = document.getElementById('rform');
    let data = {
        latitude: lat,
        longitude: lng,
        text: form.elements['reporttext'].value,
        issue: form.elements['issues'].value,
    }
    const response = await fetch('/api/report', {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: serialize(data)
    });
}

async function matForm(){

    let form = document.getElementById('materials')
    let data = {
        paper: form.elements['paper'].value,
        metal: form.elements['metal'].value,
        location: form.elements['location'].value,
        glass: form.elements['glass'].value,
        plastic: form.elements['plastic'].value,
        waste: form.elements['waste'].value,
        mixedGarbage: form.elements['mixedGarbage'].value,
        type: form.elements['type'].value,
    }
    const response = await fetch('/api/insertdata', {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: serialize(data) // body data type must match "Content-Type" header
    });
    document.getElementById('id04').style.display='none';
    return response.json();
}

window.addEventListener('resize', function (event) {
    document.getElementById("drop1").style.display = "none";
});

