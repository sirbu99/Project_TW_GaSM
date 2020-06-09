async function download(type) {
    const time = document.getElementById("downloadInfo").value;
    console.log(time);
    const response = await fetch(`/api/getdata/${type}?report=${time}`, {
        method: 'GET',
    })
        .then(response => response.blob())
        .then(blob => {
            const a = document.createElement('a');
            a.href = window.URL.createObjectURL(blob);
            a.download = `filename.${type}`;
            a.click();
            return false
        });
}

async function upload() {
    let files = document.getElementById('jsonFile').files;
    let fileName = document.querySelector('#jsonFile').value;
    let extension = fileName.substring(fileName.lastIndexOf('.') + 1);
    if (files.length <= 0) {
        return false;
    }

    let fr = new FileReader();

    fr.onload = function (e) {
        let result;
        if (extension === 'json') {
            result = JSON.parse(e.target.result);
            result = JSON.stringify(result, null, 2);
        } else if (extension === 'csv') {
            result = csvJSON(e.target.result);
        }
        fetch('/api/insertdata/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: result,
        })
    }

    fr.readAsText(files.item(0));
}